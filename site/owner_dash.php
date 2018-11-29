<?php session_start();?>
 <?php
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
		<title>Owners</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<style>
		</style>
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
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>

	<!--Banner-->
		<section class="banner_layout banner_lessees">
			<div class="inner">
			</br></br></br>
				<h1><font color="white">Owner Dashboard</font></h1></br>
				<h3>Toggle your view below</h3>
			</div>
		</section>

	<!-- Main -->
		<section id="main">
			<div class="inner">
                <section>
                    <div class="row">
                        <!-- begin row-->
                        <div class="3u 12u$(xsmall)">
							<ul class="actions">
								<li><a href="?name=prospective_contracts" class="button special">Prospective Contracts</a></li><br><br>
								<li><a href="?name=existing_contracts" class="button special">Existing Contracts &emsp;&ensp; </a></li><br><br>
								<li><a href="?name=warehouse_activity" class="button special">Warehouse Activity&ensp;&ensp;</a></li><br><br>
								<li><a href="?name=account" class="button special">Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</a></li><br><br>
							</ul>
                        </div>

                        <div class="9u$ 12u$(xsmall)">
                            <!-- new column-->
                            <div class="slimmer" margin-left="4em">
								<?php
								
									$Owner_ID=$_SESSION["id"]; //hardcoded ID
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
									$count_qry = "SELECT COUNT(*) FROM Contract WHERE Owner_ID = ".$Owner_ID."";
									$count = $conn->query($count_qry);
									$row = $count->fetch_assoc();
									
									

								if( $_GET["name"]!="existing_contracts" && $_GET["name"]!="warehouse_activity" && $_GET["name"]!="account"){ //OR operator used to set this selection to default
									echo"
									

						

									<h3>Prospective Contracts</h3>
									<p>Complete a contract action by clicking its green ID on the left.<br>
									You currently have [".$row["COUNT(*)"]."] prospective contracts <br>
									[Insert some R graph or personalized info]
									</p>
							</div>
						</div>
					</div>"; //ends div reaching outside this php section, done for formatting
					prospective_conts(); //placeholder existing conts
									}
                                if( $_GET["name"]=="existing_contracts"){
									echo"
									<h3>Existing Contracts</h3>
									<p>Click a green contract ID to view more details<br>
									You currently have [".$row["COUNT(*)"]."] active contracts</p>
							</div>
						</div>
					</div>";
					existing_conts();
									}
								if( $_GET["name"]=="warehouse_activity"){
									echo"
									<h3>Warehouse Activity</h3>
									<p> Here is Your Optimized Activity
									</p>

										  <head>";
										echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
										echo'<script type="text/javascript">
											  google.charts.load(\'current\', {\'packages\':[\'corechart\']});
											  google.charts.setOnLoadCallback(drawChart);

											  function drawChart() {

												var data = google.visualization.arrayToDataTable([
												  [\'Task\', \'Hours per Day\'],
												  [\'Work\',     11],
												  [\'Eat\',      2],
												  [\'Commute\',  2],
												  [\'Watch TV\', 2],
												  [\'Sleep\',    7]
												]);

												var options = {
												  title: \'My Daily Activities\'
												};

												var chart = new google.visualization.PieChart(document.getElementById(\'piechart\'));

												chart.draw(data, options);
											  }
											</script>';
										echo"</head>
										  <body>
											<div id=\"piechart\" style=\"width: 900px; height: 500px;\"></div>
										  </body>


							</div>
						</div>
					</div>";
					//[php function yieldning some info or query]();
									}
								if( $_GET["name"]=="account"){
									echo"
									<h3>Your Account</h3>
									<p>
									</p>
							</div>
						</div>
					</div>";
					//[php function yieldning some info or query]();
									}
								?>

                    <hr /> <!-- separating line-->

			<!-- table -->
			<!-- prospective contracts -->
                <?php
					function prospective_conts(){
						echo"<h2>Accept or decline contracts</h2>";
						/*$Owner_ID= $_POST["Owner_ID"];*/
						//$Owner_ID="201"; //hardcoded ID
						$Owner_ID=$_SESSION["id"]; //hardcoded ID
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

						/*$sql_1 = "SELECT *";
						$sql_2 = "FROM Warehouse WHERE Owner_ID=$Owner_ID";*/
						$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=0";

						$count_qry = "SELECT COUNT(*) FROM Contract WHERE Owner_ID = ".$Owner_ID."";
						$count = $conn->query($count_qry);
						$row = $count->fetch_assoc();

						$result = $conn->query($sql);
						echo "
						<style>
							td, tr:hover {
								opacity: 0.6;
							}

							th:hover {
								opacity: 1.0;
							}
						</style>";
						echo"<table width=950px>
							";
							
							echo"
							<th>Warehouse ID</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Rented Space</th>
							<th>Lessee ID</th>
							<th>Signing Date</th>";

							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {

							echo"
							<tr><td><a href='request.php'>".$row['Warehouse_ID']. "</a></td>
							<td>".$row["Start Date"]."</td>
							<td>".round($row["End Date"],2)."</td>
							<td>".$row["Rented_Space"]."</td>
							<td>".$row["Lessee_ID"]."</td>
							<td>".$row["Signing_date"]."</td>";
							/*echo"
							<tr><td><a href='request.php'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round($row["BasePrice"],2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>";*/
							//echo "ID: " . $row["ID"]. "Capacity: ".$row["Capacity"]. "Price: ".$row["Price"]. "Zipcode: ".$row["Zipcode"] ."City: ".$row["City"]. "State: ".$row["State"]. "Owner ID: ".$row["Owner_ID"]. "Owner Rating: ".$row["Owner_Rating"];

							echo"</td>";
							}
							} else {
							echo "0 results";
							}
							$conn->close();
							echo"
						</table>";
						}
/*Existing contracts table*/
					function existing_conts(){
						echo"<h2>Your existing contracts</h2>";
						/*$Owner_ID= $_POST["Owner_ID"];*/
						$Owner_ID = $_SESSION["id"];
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

						/*$sql_1 = "SELECT *";
						$sql_2 = "FROM Warehouse WHERE Owner_ID=$Owner_ID";*/
						$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=1";

						$result = $conn->query($sql);
						echo "
						<style>
							td, tr:hover {
								opacity: 0.6;
							}

							th:hover {
								opacity: 1.0;
							}
						</style>";
						echo"<table width=950px>
							";
							echo"
							<th>Warehouse ID</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Rented Space</th>
							<th>Lessee ID</th>
							<th>Signing Date</th>";

							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {

							echo"
							<tr><td><a href='request.php'>".$row['Warehouse_ID']. "</a></td><td>".$row["Start Date"]."</td><td>".round($row["End Date"],2)."</td><td>".$row["Rented_Space"]."</td><td>".$row["Lessee_ID"]."</td><td>".$row["Signing_date"]."</td><td>";
							/*echo"
							<tr><td><a href='request.php'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round($row["BasePrice"],2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>";*/
							//echo "ID: " . $row["ID"]. "Capacity: ".$row["Capacity"]. "Price: ".$row["Price"]. "Zipcode: ".$row["Zipcode"] ."City: ".$row["City"]. "State: ".$row["State"]. "Owner ID: ".$row["Owner_ID"]. "Owner Rating: ".$row["Owner_Rating"];

							echo"</td>";
							}
							} else {
							echo "0 results";
							}
							$conn->close();
							echo"
						</table>";
						}
                ?>
                </font></p>

                </section>
			</div>
		</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="copyright" style="font-weight:500;">
					&copy; Untitled. Design: <a href="https://templated.co" style="font-weight:500;">TEMPLATED</a>. Images: <a href="https://unsplash.com" style="font-weight:500;">Unsplash</a>.
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
