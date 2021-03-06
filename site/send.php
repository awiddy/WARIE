<!-- DON'T FORCE LOGIN -->
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Forgotten password</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Pragma" content="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
		<link rel="stylesheet" href="assets/css/main.css" />
		<link href="images/icon.ico" rel="shortcut icon">
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<a href="index.php" class="logo"><strong>WARIE</strong> &ensp; Home</a>
				<nav>
					<a href="#menu">Menu</a>
					<a href="about.php">About</a>
				</nav>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="browse.php">Browse Warehouses</a></li>
					<li><a href="newhouse.php">List your warehouse</a></li>
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
			<section class="banner_layout banner_lessees">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Reset email sent</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<?php
					//Receiving information from form on forgot.php and setting variables for DB connection
					$email=$_POST['email'];
					$servername = "mydb.ics.purdue.edu";
					$username = "g1090423";
					$password = "marioboys";
					$dbname = "g1090423";
					$id = $_SESSION['id'];


					//Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					//Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
					//https://www.xeweb.net/2011/02/11/generate-a-random-string-a-z-0-9-in-php/
					//Referenced the above link in order to do this random password 
					//Generate random string that will serve as the new password
					$length=10;//length of random string
					$chars = array_merge(range('A','Z'),range('a','z'),range('0','9'));
					$max=count($chars) - 1;
					for($n=0;$n<$length;$n++){
						$r = mt_rand(0,$max);
						$newpass .=$chars[$r];
					}
										
					//Find whether or not user is owner or lessee
					$find_o = "SELECT * FROM Owner WHERE Email = '".$email."'";
					$find_l = "SELECT * FROM Lessee WHERE Email = '".$email."'";
					$result_o = $conn->query($find_o);
					$result_l = $conn->query($find_l);
					$o = (mysqli_num_rows($result_o));
					$l = (mysqli_num_rows($result_l));
					
					$qry_o = "UPDATE Owner SET Password = '".$newpass."' WHERE ID = ".$id."";
					$qry_l = "UPDATE Lessee SET Password = '".$newpass."' WHERE ID = ".$id."";

					//Email including the new password
					$msg="Hello from the Warie Staff,\n\n We have your new password that you have requested.\n\nNew password : ".$newpass."\nIf you would like to log in, please go to http://web.ics.purdue.edu/~g1090423/login.php \n\nThank you,\nWarie Staff";
					$msg = wordwrap($msg,70); //wrap if lines are longer than 70 characters
						
					//Replace existing password with the new one, ensuring to query the correct DB
					if ($o==1){
						mysqli_query($conn,$qry_o);
						mail($email,"Reset your password for Warie",$msg); //sends email
						echo("<header><h2>We have sent the reset email. If you did not receive the email after a few seconds, please <a href='forgot.php'>retry.</a></h2></header>");
					
					}else if ($l==1){
						mysqli_query($conn,$qry_l);
						mail($email,"Reset your password for Warie",$msg); //sends email
						echo("<header><h2>We have sent the reset email. If you did not receive the email after a few seconds, please <a href='forgot.php'>retry.</a></h2></header>");
						echo("<font></font>");
					
					}else{
						//Prints if the email does not exist in the DB
						echo("<header><h2>I'm sorry, we have no account attached to this email. If you'd like to create an account, please click <a href='registerpage.php'>here.</a></h2></header>");
					}

					mysqli_close($conn);

					?>
					</font></p>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
			<ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.php">Terms and Conditions</a>	
				<div class="copyright">
					&copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com">Unsplash</a>.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>