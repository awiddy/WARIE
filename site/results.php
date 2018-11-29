<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Results</title>
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
					<h1><font color="white">Find the space you need</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<header>
						<h2>Search Results</h2>
					</header>
					<p><font color="black">
						</br>
						Click on any Warehouse ID to draft up a contract for that location.
					</font></p>
					
					


					<?php 
					$storage_type = $_POST["storagetype"];
					$city = $_POST["city"];
					$start_date = $_POST["start_date"];
					$end_date = $_POST["end_date"];
					$storage_needed = $_POST["storage_needed"];
					$sort_val = $_POST["sort_val"];
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
					$start_date1= date_create("$start_date");
					$end_date1=date_create("$end_date");
					$current_date = new DateTime(date("Y-m-d"));
					
					$start_date_week = ceil((date_diff($start_date1, $current_date))/7);
					$end_date_week = ceil((date_diff($end_date1, $current_date))/7);
					$sql_1 = "SELECT W.ID, StorageCapacity,BasePrice,Zipcode,City,State,Owner_ID,R.Rating as Owner_Rating ";
					$sql_2 = "FROM (Warehouse W INNER JOIN(SELECT MIN(Open_Space),WarehouseID FROM Availability WHERE WeekFromDate BETWEEN ".$start_date_week." AND ".$end_date_week." GROUP BY WarehouseID) A ";
					$sql_3 = "ON W.ID = A.WarehouseID) INNER JOIN (SELECT Rating,Owner.ID FROM Owner) R ON W.Owner_ID=R.ID WHERE StorageType = ".$storage_type." AND City = '".$city."' ORDER BY ";
					$sql = $sql_1.$sql_2.$sql_3;
					
					if($sort_val==1){$sql=$sql."BasePrice";};
					if($sort_val==2){$sql=$sql."Owner_Rating DESC";};
					
					$result = $conn->query($sql);
					
					echo "<style>td,tr:hover{opacity:0.6;} th:hover{opacity:1.0;}</style>";
					echo"<table width = 950px>";
					echo"<th>Warehouse ID</th><th>Storage Capacity</th><th>Price ($/sq ft/month)</th><th>Zipcode</th><th>City</th><th>State</th><th>Owner ID</th><th>Owner Rating</th>";
					
					if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
					
					echo"<tr><td><a href='request.php?w=".$row['ID']."&o=".$row['Owner_ID']."&pr=".$row['BasePrice']."&c=".$row['City']."&st=".$row['State']."&z=".$row["Zipcode"]."' target='_blank'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round($row["BasePrice"],2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>".$row["Owner_ID"]."</td><td>".$row["Owner_Rating"]."</td></tr>";
					//echo "ID: " . $row["ID"]. "Capacity: ".$row["Capacity"]. "Price: ".$row["Price"]. "Zipcode: ".$row["Zipcode"] ."City: ".$row["City"]. "State: ".$row["State"]. "Owner ID: ".$row["Owner_ID"]. "Owner Rating: ".$row["Owner_Rating"];
					
					echo"</td>";
						}
						} else {
							echo "<h3>0 results</h3>";
							}
							$conn->close();
					echo"</table>";
					
					?>
					</font></p>
					
					
					
					<a href="browse.html" class="button special" target="_blank">Search Again</a>
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
