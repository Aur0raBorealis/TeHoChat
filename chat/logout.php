<!--Koodi jota käytetty sivustolla: http://www.phpzag.com/build-live-chat-system-with-ajax-php-mysql/ -->
<?php 
SESSION_START();
include ('Chat.php');
$chat = new Chat();
$chat->updateUserOnline($_SESSION['userid'], 0);
$user['username'] = "";
$_SESSION['userid']  = "";
$user['login_details_id']= "";
header("Location:../index.php");
?>