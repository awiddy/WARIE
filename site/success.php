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
					$storage_amt = $_POST["storage_amt"];
					$start_date_raw = $_POST["start_date"];
					$end_date_raw = $_POST["end_date"];
					$o_fname = $_POST["o_fname"];
					$o_lname = $_POST["o_lname"];
					$l_fname = $_POST["l_fname"];
					$l_lname = $_POST["l_lname"];
					$w_id = $_POST["w_id"];
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

					
					$o_id_qry="SELECT ID FROM Owner WHERE FirstName ='".$o_fname."' AND LastName='".$o_lname."'";
					$o_id_sql=$conn->query($o_id_qry);
					$row1 = $o_id_sql->fetch_assoc();
					$o_id=$row1['ID'];
					
					$l_id_qry="SELECT ID FROM Lessee WHERE FirstName ='".$l_fname."' AND LastName='".$l_lname."'";
					$l_id_sql=$conn->query($l_id_qry);
					$row2 = $l_id_sql->fetch_assoc();
					$l_id=$row2['ID'];
					
					$signing_date = $signing_date1->format('Y-m-d');
					$start_date=$start_date1->format('Y-m-d');
					$end_date=$end_date1->format('Y-m-d');
					echo($signing_date);
					echo($start_date);
					echo($end_date);
					echo("<br>".$o_id_qry."<br>".$l_id_qry."<br>");

					
					$sql = "INSERT INTO Contract ('Start Date','End Date',Lessee_ID,Owner_ID,Rented_Space, Signing_Date,WarehouseID,Approval) VALUES (".$start_date.",".$end_date.",".$l_id.",".$o_id.",".$storage_amt.",".$signing_date.",".$w_id.",".$approval.")";
					$result = $conn->query($sql);
					echo($sql);
					echo ($result);
					?>

					</div>
					</section>
					
					<!-- Footer -->
			<footer id="footer">
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
