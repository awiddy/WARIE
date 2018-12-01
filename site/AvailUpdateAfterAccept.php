<?php
$servername = "mydb.ics.purdue.edu";
						$username = "g1090423";
						$password = "marioboys";
						$dbname = "g1090423";

						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}

$Warehouse_ID = $_POST["Warehouse_ID"];
$Start_Date = $_POST["Start_Date"];
$End_Date = $_POST["End_Date"];
$Rented_Space = $_POST["Rented_Space"];

$sql = "UPDATE Availability 
SET Open_Space=(SELECT Open_Space FROM Availability WHERE WeekFromDate Between ".$Start_Date." AND ".$End_Date." AND  Warehouse_ID = ".$Warehouse_ID.") - ".$Rented_Space."  
WHERE WeekFromDate Between ".$Start_Date." AND ".$End_Date."AND  Warehouse_ID = ".$Warehouse_ID."";

$result = $conn->query($sql);
?>

<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<!-- Header -->
			<header id="header">
				<a href="index.html" class="logo"><strong>WARIE</strong> &ensp; Home</a>
				<nav>
					<a href="#menu">Menu</a>
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
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Login with WARIE</font></h1></br>
				</div>
		</section>
		<section id="main">
			<div class="slimmer">
			<h3> Success! <h3>
			<a href="owner_dash.php">Back to contract dashboard</a>
			</div>
			</section>

<footer id="footer">
			<div class="copyright" style="font-weight:500;">
			<ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.html">Terms and Conditions</a>	
				&copy; Untitled. Design: <a href="https://templated.co" style="font-weight:500;">TEMPLATED</a>. Images: <a href="https://unsplash.com" style="font-weight:500;">Unsplash</a>.
			</div>
		</footer>