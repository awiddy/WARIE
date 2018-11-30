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
					<h1><font color="white">Request sent!</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h3>Please wait until you hear back from the owner.</h3>
					<a href="browse.html" class="button special" target="_blank">Search Again</a>
					<?php 
					$start_date_raw = $_POST["start_date"];
					$end_date_raw = $_POST["end_date"];
					$o_id = $_GET['o'];
					$l_id = $_GET['l'];
					$sn = $_GET['sn'];
					$w_id = $_GET['w'];
					
					
					$signing_date1=new DateTime(date("Y-m-d"));
					$approval=0;
					
					$start_date1= date_create("$start_date_raw");
					$end_date1=date_create("$end_date_raw");
					$current_date = new DateTime(date("Y-m-d"));
					$start_date_week = ceil((date_diff($start_date1, $current_date))/7);
					$end_date_week = ceil((date_diff($end_date1, $current_date))/7);
					
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

				
					
					$signing_date = $signing_date1->format('Y-m-d');
					$start_date=$start_date1->format('Y-m-d');
					$end_date=$end_date1->format('Y-m-d');


					$sql = "INSERT INTO Contract (`Start Date`,`End Date`,Lessee_ID,Owner_ID,Rented_Space, Signing_date,Warehouse_ID,Approval) VALUES ('".$start_date."','".$end_date."',".$l_id.",".$o_id.",".$sn.",'".$signing_date."',".$w_id.",".$approval.")";
					echo($sql);
					echo("<br>o id is ".$o_id." sos");
					mysqli_query($conn,$sql);

					
					mysqli_close($conn);

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
