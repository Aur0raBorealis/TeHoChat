<!DOCTYPE html PUBLIC>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		TeHoChat
	</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/teHoChat.css" rel="stylesheet">
</head>
<body>
    <div id="header-wrapper">
        <div id="header" class="container">
            <div id="logo">
                <span class="icon icon-group"></span>
                <h1><a href="#">TeHoChat</a></h1>
            </div>
            <div id="triangle-up"></div>
            </div>
    </div>
    <?php    
        include("includes/iheader.php");
        if(isset($_SESSION['sloggedIn'])){
            include("forms/fremoveAccount.php");
            //Lomakkeen remove painettu?
            if(isset($_POST['removeUser'])){
                unset($_SESSION['swarningInput']);  
                try {
                    $data['rPhone']=$_POST["givenPhoneNumber"];
                    $data['rPassword']=$_POST["givenPassword"];

                    //Tiedot kannasta, hakuehto
                    $STH = $DBH->prepare("SELECT userPassword FROM TeHoChat_user where userPhoneNumber  =  " . "'".$_POST['givenPhoneNumber']."'  AND userName =  " . "'".$_SESSION['suserName']."'");                    
                    $STH->execute($data);
                    $STH->setFetchMode(PDO::FETCH_OBJ);
                    $tulosOlio=$STH->fetch();
                    //lomakkeelle annettu salasana + suola
                    $givenPasswordAdded = $_POST['givenPassword'].$added; //$added löytyy cconfig.php

                    //Löytyikö tunnus kannasta?   
                    if($tulosOlio!=NULL){
                        //Tunnus löytyi
                        // var_dump($tulosOlio);
                        echo("löyyi");

                            if(password_verify($givenPasswordAdded,$tulosOlio->userPassword)){
                                $sql = "DELETE FROM TeHoChat_user where userPhoneNumber  = " . "'".$_POST['givenPhoneNumber']."' and userName =  " . "'".$_SESSION['suserName']."'";
                                //DELETE (*) FROM TeHoChat_user where userPhoneNumber = '+358449749407' and userName = 'anatolru'
                                //$sql = "DELETE (*) FROM TeHoChat_user where userPhoneNumber  = " . "'".$_POST['givenPhoneNumber']."' and userName =  " . "'".$_SESSION['suserName']."'";
                                $kysely=$DBH->prepare($sql);
                                echo($sql);
                                $kysely->execute();				
                                $tulos=$kysely->fetch();
                                echo("poistettu");
                                //header("Location: index.php"); //Palataan pääsivulle 
                            }else{
                                $_SESSION['swarningInput']="Wrong password";
                            }
                        
                    }else{
                        $_SESSION['swarningInput']="Virhellinen numero";
                        echo("ei");
                    }
                } catch(PDOException $e) {
                    file_put_contents('log/DBErrors.txt', 'signInUser.php: '.$e->getMessage()."\n", FILE_APPEND);
                    $_SESSION['swarningInput'] = 'Database problem';
                }        
            } 
        }
    ?>
    <?php
        //Palataan takaisin pääsivulle alkutilanteeseen
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
        include("includes/ifooter.php");
    ?>
</body>