<?php
    include_once("config/chttps.php");
    include_once("config/cconfig.php");
    session_start();

    //Käyttäjän tila
    if($_SESSION['sloggedIn']=="yes"){
        if(time() - $_SESSION['timestamp'] > 900) { //subtract new timestamp from the old one
            echo"<script>Huomio('15 Minutes over!');</script>";
            unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
            $_SESSION['sloggedIn'] = false;
            header("Location: index.php"); //Palataan pääsivulle ei kirjautuneena
            exit;
        } else {
            $_SESSION['timestamp'] = time(); //set new timestamp
        }
    }
?>