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
		<title>Lessee Account</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<style>
			td, tr:hover {
				opacity: 0.6;
			}
			th:hover {
				opacity: 1.0;
			}
		</style>
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
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>

	<!--Banner-->
		<section class="banner_layout banner_lessees">
			<div class="inner">
			</br></br></br>
				<h1><font color="white">Lessee Dashboard</font></h1></br>
				<h3>Toggle your view below</h3>
			</div>
		</section>

	<!-- Main -->
		<section id="main">
			<div class="inner">
                <section>
                    <div class="row">
                        <!-- table of buttons triggering url change, the if statement evaluates this later-->
                        <div class="3u 12u$(xsmall)">
							<ul class="actions">
								<li><a href="?name=requested_contracts" class="button special">Requested Contracts </a></li><br><br>
								<li><a href="?name=existing_contracts" class="button special">Existing Contracts &emsp;&ensp;</a></li><br><br>
								<li><a href="?name=account" class="button special">Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</a></li><br><br>
							</ul>
                        </div>

                        <div class="9u$ 12u$(xsmall)">
                            <!-- new column-->
                            <div class="slimmer" style="margin-left: 5%;">
								<?php
									$Lessee_ID=$_SESSION["id"];
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
									$count1_qry = "SELECT COUNT(*) FROM Contract WHERE Lessee_ID = ".$Lessee_ID." AND Approval=1";
									$count1 = $conn->query($count1_qry);
									$row1 = $count1->fetch_assoc();

									$count2_qry = "SELECT COUNT(*) FROM Contract WHERE Lessee_ID = ".$Lessee_ID." AND Approval=0";
									$count2 = $conn->query($count2_qry);
									$row2 = $count2->fetch_assoc();
							//if statements look at GET parameters in URL to decide which function to run
							//the functions in these if statements are created below
								//check to see if url parameter is for requested contracts
								if( $_GET["name"]!="existing_contracts" && $_GET["name"]!="warehouse_activity" && $_GET["name"]!="account"){ //OR operator used to set this selection to default
									echo"

									<h3>Requested Contracts</h3>
									<p>Complete a contract action by clicking its green ID on the left.<br>
									You currently have <strong>".$row2["COUNT(*)"]."</strong> requested contracts <br><br>
									[Insert some R graph or personalized info]
									</p>
							</div>
						</div>
					</div>"; //ends div reaching outside this php section, done for formatting
					requested_conts(); //placeholder existing conts
									}
                                if( $_GET["name"]=="existing_contracts"){
									echo"
									<h3>Existing Contracts</h3>
									<p>Click a green contract ID to view more details<br>
									You currently have ".$row1["COUNT(*)"]." active contracts</p>
							</div>
						</div>
					</div>";
					existing_conts();
									}
								if( $_GET["name"]=="account"){
									echo"
									<h3>Your Account</h3>
									<p>
										See the account info we store about you below.
									</p>
							</div>
						</div>
					</div>";
					lessee_account();
									}
								?>

                    <hr /> <!-- separating line-->

			<!-- php functions for querying and printing results in table -->
                <?php
					//function for making a table of requested contracts from data in SQL table
					function requested_conts(){
						echo"<h2>Your requested contracts</h2>";
						$Lessee_ID = $_SESSION["id"];
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

						$sql = "SELECT * FROM Contract WHERE Lessee_ID=".$Lessee_ID." AND Approval=0";
						//$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=0";

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
							<th>Rented Space (Sqft.)</th>
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
							
							echo"</tr>";
							}
							} else {
							echo "0 results";
							}
							$conn->close();
							echo"
						</table>";
						}

				//function for making a table of existing contracts from data in SQL table
					function existing_conts(){
						echo"<h2>Your existing contracts</h2>";
						/*$Owner_ID= $_POST["Owner_ID"];*/
						$Lessee_ID = $_SESSION["id"];
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

						$sql = "SELECT * FROM Contract WHERE Lessee_ID=".$Lessee_ID." AND Approval=1";
						//$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=0";

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
							<th>Rented Space (Sqft.)</th>
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
							
							echo"</tr>";
							}
							} else {
							echo "0 results";
							}
							$conn->close();
							echo"
						</table>";
						}
				
					//function for making a table of account information from data in SQL table lessee
					function lessee_account(){
						echo"<h2>Your existing contracts</h2>";
						/*$Owner_ID= $_POST["Owner_ID"];*/
						$Lessee_ID = $_SESSION["id"];
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

						$sql = "SELECT * FROM Lessee WHERE ID=".$Lessee_ID."";
						//$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=0";

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
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Rating</th>";

							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {

							echo"
							<tr>
							<td><a href='request.php'>".$row['ID']. "</a></td>
							<td>".$row["FirstName"]."</td>
							<td>".$row["LastName"]."</td>
							<td>".$row["Email"]."</td>
							<td>".$row["Rating"]."</td>";
							
							echo"</tr>";
							}
							} else {
							echo "0 results";
							}
							$conn->close();
							echo"
						</table>";
						}

					function pieChart(){
						echo"<head>";
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
								</body>";
					}
					function lineCurve(){
						echo"<head>";
									echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
									echo'<script type="text/javascript">
										google.charts.load(\'current\', {\'packages\':[\'corechart\']});
										google.charts.setOnLoadCallback(drawChart);

										function drawChart() {
										var data = google.visualization.arrayToDataTable([
											[\'Year\', \'Sales\', \'Expenses\'],
											[\'2004\',  1000,      400],
											[\'2005\',  1170,      460],
											[\'2006\',  660,       1120],
											[\'2007\',  1030,      540]
										]);

										var options = {
											title: \'Company Performance\',
											curveType: \'function\',
											legend: { position: \'bottom\' }
										};

										var chart = new google.visualization.LineChart(document.getElementById(\'curve_chart\'));

										chart.draw(data, options);
										}
									</script>';
								echo"</head>
									<body>
									<div id=\"curve_chart\" style=\"width: 900px; height: 500px\"></div>
									</body>";
					}
				?>
                </font></p>

                </section>
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
