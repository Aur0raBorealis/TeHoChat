<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            TeHoChat tilin luonti
        </title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/teHoChat.css" rel="stylesheet">
        <link rel="stylesheet" href="forms/build/css/intlTelInput.css">
        <link rel="stylesheet" href="forms/build/css/demo.css">
    </head>
    <body>
        <div id="header-wrapper">
            <div id="header" class="container">
                <div id="logo">
                    <span class="icon icon-group">
                    </span>
                    <h1>
                        <a href="index.php">
                            TeHoChat
                        </a>
                    </h1>
                </div>
            </div>
            <?php
				include("includes/iheader.php");
			?>
        </div>
        <div id="menu-wrapper">
			<div id="menu">
				<ul>
					<?php
						//Käyttäjän tila
						if($_SESSION['sloggedIn']=="yes"){
					?>
					<li>
						<a href="#" accesskey="3" title="">
							<?php
								echo("<p>
										Käyttäjä: 
									</p>" . $_SESSION['suserName']);
							?>
						</a>
					</li>
					<li>
						<a href="chat/userChat.php" accesskey="2" title="">
							Aloita chat
						</a>
					</li>
					<li>
						<a href="chart.php" accesskey="3" title="">
							HRV
						</a>
					</li>
					<li>
						<a href="settings.php">
							Asetukset
						</a>
					</li>
					<li>
						<a href="logOutUser.php"> 
							Kirjaudu ulos        
						</a>
					</li>
					<?php
						}else{
					?>
					<li>		
						<a href="createAccount.php">
							Luo uuden käyttäjän
						</a> 
					</li>
					<li>
						<p>
							tai
						</p>
					</li>
					<li>
						<a href="logInUser.php">
							Kirjaudu sisään
						</a>
					</li>
				</ul>
			</div>
		</div>
        <?php 
            include("forms/fcreateAccount.php");
            require_once("functions/functions.php");
        ?>
        <script src="forms/build/js/intlTelInput.js">
        </script>
        <script>
            var input = document.querySelector("#phone");
            window.intlTelInput(input, {
            // allowDropdown: false,
            //autoHideDialCode: false,
            autoPlaceholder: "off",
            // dropdownContainer: document.body,
            // excludeCountries: ["fi"],
            // formatOnDisplay: false,
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "fi";
                    callback(countryCode);
                });
            },
            //hiddenInput: "full_number",
            initialCountry: "fi",
            localizedCountries: { 'fi': 'Suomi' },
            // nationalMode: false,
            onlyCountries: ['fi'],
            // placeholderNumberType: "MOBILE",
            //preferredCountries: ['fi'],
            // separateDialCode: true,
            utilsScript: "forms/build/js/utils.js",
            });
        </script>
        <?php
            //Lomakkeen submit painettu?
            if(isset($_POST['submitUser'])){
                //Tarkistetaan syötteet myös palvelimella
                if(!preg_match('/^\+358[0-9]{9}$/', $_POST['givenPhoneNumber']) && !preg_match('/^\358[0-9]{9}$/', $_POST['givenPhoneNumber']) && !preg_match('/^\04[0-9]{8}$/', $_POST['givenPhoneNumber'])){
                    $_SESSION['swarningInput']="Laiton puh1";

                }else if($_POST['givenPassword'] != $_POST['givenPasswordVerify']){
                    $_SESSION['swarningInput']="Annettu ja vahvistettu salasanat eivät ole samoja";
                        
                }else{
                    if(preg_match('/^\358[0-9]{9}$/', $_POST['givenPhoneNumber'])){
                        $_POST['givenPhoneNumber'] = "+".$_POST['givenPhoneNumber'];
                    }else if(preg_match('/^\358[0-9]{9}$/', $_POST['givenPhoneNumber'])){
                        $_POST['givenPhoneNumber'] = "+".$_POST['givenPhoneNumber'];
                    }
                    unset($_SESSION['swarningInput']);
                    //1. Tiedot sessioon
                    $_SESSION['suserName']=$_POST['givenUsername'];
                    $_SESSION['sloggedIn']="yes";
                    $_SESSION['suserNumber']= $_POST['givenPhoneNumber'];
                    //2. Tiedot kantaan - kesken
                    //Testataan pääsivulle paluu
                    //Palataan pääsivulle jos tallennus onnistui -kesken   

                    $data['name'] = $_POST['givenUsername'];
                    $data['phoneNumber'] = $_POST['givenPhoneNumber'];
                    $added='#â‚¬%&&/'; //suolataan annettu salasana
                    $data['password'] = password_hash($_POST['givenPassword'].$added, PASSWORD_BCRYPT);
                    try {
                        //***Käyttäjätunnus ei saa olla käytetty aiemmin
                        $sql = "SELECT COUNT(*) FROM TeHoChat_user where userName  =  " . "'".$_POST['givenUsername']."' OR userPhoneNumber =  " . "'".$_POST['givenPhoneNumber']."'"  ;                       
                        $kysely=$DBH->prepare($sql);
                        $kysely->execute();				
                        $tulos=$kysely->fetch();
                        if($tulos[0] == 0){ //Puhelin ei ole käytössä
                            $STH = $DBH->prepare("INSERT INTO TeHoChat_user (userName, userPhoneNumber, userPassword) VALUES (:name, :phoneNumber, :password);" .
                            "INSERT INTO chat_users (username, current_session, online) VALUES (:name, 0, 0);");
                            $STH->execute($data);
                            header("Location: index.php"); //Palataan pääsivulle kirjautuneena
                        }else{
                            $_SESSION['swarningInput']="Phone is reserved";
                        }
                    }catch(PDOException $e) {
                        file_put_contents('log/DBErrors.txt', 'signInUser.php: '.$e->getMessage()."\n", FILE_APPEND);            $_SESSION['swarningInput'] = 'Database problem';
                    }  
                } 
            }      
        ?>
        <?php
            //Luovutetaanko ja palataan takaisin pääsivulle alkutilanteeseen
            if(isset($_POST['submitBack'])){
                session_unset();
                session_destroy();
                header("Location: index.php");
            }
        ?>
        <?php
            //Näytetäänkö lomakesyötteen aiheuttama varoitus?
            if(isset($_SESSION['swarningInput'])){
                echo("<p class=\"warning\">ILLEGAL INPUT: ". $_SESSION['swarningInput']."</p>");
            }
        ?>
        <?php
			}
		?>
        <?php
            include("includes/ifooter.php");
        ?>
    </body>
</html>