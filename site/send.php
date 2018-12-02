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
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<a href="index.html" class="logo"><strong>WARIE</strong> &ensp; Home</a>
				<nav>
					<a href="#menu">Menu</a>
					<a href="about.html">About</a>
				</nav>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.html">Home</a></li>
					<li><a href="browse.html">Browse Warehouses</a></li>
					<li><a href="lessees.html">Lease a warehouse</a></li>
					<li><a href="owners.html">List your warehouse</a></li>
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
					//generate random string
					$length=10;//length of random string
					$chars = array_merge(range('A','Z'),range('a','z'),range('0','9'));
					$max=count($chars) - 1;
					for($n=0;$n<$length;$n++){
						$r = mt_rand(0,$max);
						$str .=$chars[$r];
					}
					$newpass = $str;
					
					//Find whether or not user is owner or lessee
					$find_o = "SELECT * FROM Owner WHERE Email = '".$email."'";
					$find_l = "SELECT * FROM Lessee WHERE Email = '".$email."'";
					
					$result_o = $conn->query($find_o);
					$result_l = $conn->query($find_l);
					$o = (mysqli_num_rows($result_o));
					$l = (mysqli_num_rows($result_l));
					
					$qry_o = "UPDATE Owner SET Password = '".$newpass."' WHERE ID = ".$id."";
					$qry_l = "UPDATE Lessee SET Password = '".$newpass."' WHERE ID = ".$id."";

					//put random string in email
					$msg="Hello from the Warie Staff,\n\n We have your new password that you have requested.\n\nNew password : ".$newpass."\nIf you would like to log in, please go to http://web.ics.purdue.edu/~g1090423/login.php \n\nThank you,\nWarie Staff";
					$msg = wordwrap($msg,70); //wrap if lines are longer than 70 characters
						
					//replace password string with random string in appropriate table
					if ($o==1){
						mysqli_query($conn,$qry_o);
						//send random string in email
						mail($email,"Reset your password for Warie",$msg);
						echo("<header><h2>We have sent the reset email. If you did not receive the email after a few seconds, please <a href='forgot.php'>retry.</a></h2></header>");
					
					}else if ($l==1){
						mysqli_query($conn,$qry_l);
						//send random string in email
						mail($email,"Reset your password for Warie",$msg);
						echo("<header><h2>We have sent the reset email. If you did not receive the email after a few seconds, please <a href='forgot.php'>retry.</a></h2></header>");
						echo("<font></font>");
					
					}else{
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
				<a href ="terms_conditions.html">Terms and Conditions</a>	
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