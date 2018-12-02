<?php session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
    exit;
}
?>
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Sent!</title>
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
					<li><a href="logout.php">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Warehouse submitted!</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h3>This warehouse is now linked to your account.</h3>
					<a href="newhouse.php" class="button special" target="_blank">Add another warehouse</a>
					<?php
					//Retreiving data from Post/Session function, as well as setting variables for the query/DB connection
					
					$city=$_POST['city'];
					$state=$_POST['state'];
					$zip=$_POST['zip'];
					$lat=$_POST['lat'];
					$long=$_POST['long'];
					$storagetype=$_POST['storagetype'];
					$storagecapacity=$_POST['storagecapacity'];
					$price=($_POST['price'])*12;
					$o_id=$_SESSION['id'];
					
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

					//Writing query to add warehouse contract into table in DB
					$sql = "INSERT INTO Warehouse (StorageCapacity,StorageType,BasePrice,Zipcode,City, State,Latitude,Longitude,Owner_ID) VALUES (".$storagecapacity.",".$storagetype.",".$price.",".$zip.",'".$city."','".$state."',".$lat.",".$long.",".$o_id.")";
				
					mysqli_query($conn,$sql);
					mysqli_close($conn);
					echo($sql);
					?>

					</div>
					</section>

					<!-- Footer -->
						<footer id="footer">
							 <ul class="icons">
								<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							</ul>
							<a href ="terms_conditions.html">Terms and Conditions</a><br><br>

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
