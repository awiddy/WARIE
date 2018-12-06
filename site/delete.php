<?php session_start();?>
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Account deleted</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
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
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Your account has been deleted. </font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h3><a href='index.php' >Return to the home page.</a></h3>
					<?php 
					
					$id=$_SESSION['id'];
					//determining the table from which to delete the user
					if(($_SESSION["userType"])=="LesseeLogin"){
								$table = "Lessee";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$table = "Owner";
							}
					
					
					$servername = "mydb.ics.purdue.edu";
					$username = "g1090423";
					$password = "marioboys";
					$dbname = "g1090423";
					
					//Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					//Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}

					//Deletes user from the appropriate table
					$del_qry = "DELETE FROM ".$table." WHERE ID = ".$id."";
					mysqli_query($conn,$del_qry);
					mysqli_close($conn);
					session_destroy();
					?>
			</section>

		<!-- Footer -->
			<footer id="footer">
  			<footer id="footer">
  				 <ul class="icons">
  					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
  					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
  					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
  				</ul>
  				<a href ="terms_conditions.php">Terms and Conditions</a><br><br>

  				<div class="copyright" style="font-weight:300; font-size: 10px;">
  					&copy; Untitled. Design: <a href="https://templated.co" style="font-weight:300;">TEMPLATED</a>. Images: <a href="https://unsplash.com" style="font-weight:300;">Unsplash</a>.
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
