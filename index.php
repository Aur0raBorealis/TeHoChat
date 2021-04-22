<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			TeHoChat
		</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/teHoChat.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="logo">
					<span class="icon icon-group"></span>
					<h1>
						<a href="index.php">
							TeHoChat
						</a>
					</h1>
					<?php
						require_once("functions/functions.php");
						include("includes/inavIndex.php");
					?>
				</div>
			</div>
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
										</p>" .$_SESSION['suserName']);
								?>
							</a>
						</li>

						<li>
							<a href="userChat.php" accesskey="2" title="">
								Aloita chat
							</a>
						</li>
						<li>
							<a href="#" accesskey="3" title="">
								HRV
							</a>
						</li>
						<li>
							<a href="#" accesskey="5" title="">
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
						<?php
							}
						?>	
					</ul>
				</div>
		</div>

		<?php
			include("includes/ifooter.php")
		?>
	</body>
</html>