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
					<header><h2>Search Results</h2></header>
					<p><font color="black"></br>Click on any Warehouse ID to draft up a contract for that location.</font></p>
					
					<?php 
					//Getting all inputted search parameters and setting values for DB connection
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
					
					
					//Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					//Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						} 
						
					//Get user-selected dates in correct format
					$start_date1= date_create("$start_date");
					$end_date1=date_create("$end_date");
					$current_date = new DateTime(date("Y-m-d"));
					
					//Get user-selected dates in a format of "weeks out" (required for the search qry)
					$start_date_week = ceil((date_diff($start_date1, $current_date))/7);
					$end_date_week = ceil((date_diff($end_date1, $current_date))/7);
					
					//Create query that will return all warehouses in the correct location, with the correct storage type, that have enough availability between the weeks the user has searched for
					$sql_1 = "SELECT W.ID, StorageCapacity,BasePrice,Zipcode,City,State,Owner_ID,R.Rating as Owner_Rating ";
					$sql_2 = "FROM (Warehouse W INNER JOIN(SELECT MIN(Open_Space),WarehouseID FROM Availability WHERE WeekFromDate BETWEEN ".$start_date_week." AND ".$end_date_week." GROUP BY WarehouseID) A ";
					$sql_3 = "ON W.ID = A.WarehouseID) INNER JOIN (SELECT Rating,Owner.ID FROM Owner) R ON W.Owner_ID=R.ID WHERE StorageType = ".$storage_type." AND City = '".$city."' ORDER BY ";
					$sql = $sql_1.$sql_2.$sql_3;
					if($sort_val==1){$sql=$sql."BasePrice";};
					if($sort_val==2){$sql=$sql."Owner_Rating DESC";};
					
					//Get result of the above query
					$result = $conn->query($sql);
					
					//Start of the results table
					echo "<style>td,tr:hover{opacity:0.6;} th:hover{opacity:1.0;}</style>";
					echo"<table width = 950px>";
					echo"<th>Warehouse ID</th><th>Storage Capacity</th><th>Price ($/sq ft/month)</th><th>Zipcode</th><th>City</th><th>State</th><th>Owner ID</th><th>Owner Rating</th>";
					
					//If statement and while loop print all results returned from the above query 
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							//Warehouse ID appears as a link, which sends the user to a drafted contract for the user's inputted search parameters and selected warehouse information
							echo"<tr><td><a href='request.php?w=".$row['ID']."&o=".$row['Owner_ID']."&pr=".$row['BasePrice']."&c=".$row['City']."&st=".$row['State']."&z=".$row['Zipcode']."&sd=".$start_date."&ed=".$end_date."&sn=".$storage_needed."' target='_blank'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round(($row["BasePrice"])/12,2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>".$row["Owner_ID"]."</td><td>".$row["Owner_Rating"]."</td></tr>";
							echo"</td>";
							}
						} else {
							//showing the user if there are no relevant results
							echo "<h3>0 results</h3>";
							}
							//close connection
							$conn->close();
					//End table
					echo"</table>";
					?>
					</font></p>
					<!-- Restart search -->
					<a href="browse.html" class="button special" target="_blank">Search Again</a>
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