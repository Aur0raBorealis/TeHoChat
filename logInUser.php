<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			TeHoChat kirjautuminen
		</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/teHoChat.css" rel="stylesheet"/>
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
            include("includes/inavLogInUser.php"); 
            include("forms/flogInUser.php"); 
        ?>
        <?php
            //Lomakkeen submit painettu?
            if(isset($_POST['submitUser'])){
                unset($_SESSION['swarningInput']);  
                try {
                    //Tiedot kannasta, hakuehto
                    $data['name'] = $_POST['givenUsername'];
                    $STH = $DBH->prepare("SELECT userID, userPassword FROM TeHoChat_user WHERE userName = :name;");
                    $STH->execute($data);
                    $STH->setFetchMode(PDO::FETCH_OBJ);
                    $tulosOlio=$STH->fetch();
                    //lomakkeelle annettu salasana + suola
                    $givenPasswordAdded = $_POST['givenPassword'].$added; //$added löytyy cconfig.php

                    //Löytyikö tunus kannasta?   
                    if($tulosOlio!=NULL){
                        //Tunnus löytyi
                        // var_dump($tulosOlio);
                        if(password_verify($givenPasswordAdded,$tulosOlio->userPassword)){
                            $_SESSION['sloggedIn']="yes";
                            $_SESSION['suserName']=$_POST['givenUsername'];
                            $_SESSION['suserId']=$tulosOlio->userID;
                            header("Location: index.php"); //Palataan pääsivulle kirjautuneena
                        }else{
                            $_SESSION['swarningInput']="Wrong password";
                        }
                    }else{
                        $_SESSION['swarningInput']="Wrong email";
                    }
                } catch(PDOException $e) {
                    file_put_contents('log/DBErrors.txt', 'signInUser.php: '.$e->getMessage()."\n", FILE_APPEND);
                    $_SESSION['swarningInput'] = 'Database problem';
                }        
            }
        ?>
        <?php
            //***Luovutetaanko ja palataan takaisin pääsivulle alkutilanteeseen
            //ilman rekisteröintiä?
            if(isset($_POST['submitBack'])){
                session_unset();
                session_destroy();
                header("Location: index.php");
            }
        ?>
        <?php
            //***Näytetäänkö lomakesyötteen aiheuttama varoitus?
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
