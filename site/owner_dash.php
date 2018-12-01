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

									$Owner_ID=$_SESSION["id"];
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
									$count1_qry = "SELECT COUNT(*) FROM Contract WHERE Owner_ID = ".$Owner_ID." AND Approval=1";
									$count1 = $conn->query($count1_qry);
									$row1 = $count1->fetch_assoc();

									$count2_qry = "SELECT COUNT(*) FROM Contract WHERE Owner_ID = ".$Owner_ID." AND Approval=0";
									$count2 = $conn->query($count2_qry);
									$row2 = $count2->fetch_assoc();

								if( $_GET["name"]!="existing_contracts" && $_GET["name"]!="warehouse_activity" && $_GET["name"]!="account"){ //OR operator used to set this selection to default
									echo"




									<h3>Prospective Contracts</h3>
									<p>Complete a contract action by clicking its green ID on the left.<br>
									You currently have [".$row2["COUNT(*)"]."] prospective contracts <br>
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
									You currently have [".$row1["COUNT(*)"]."] active contracts</p>
							</div>
						</div>
					</div>";
					existing_conts();
									}
								if( $_GET["name"]=="warehouse_activity"){
									echo"
									<h3>Warehouse Activity</h3>
									<p> Here is Your Optimized Activity
									</p>";

									pieChart();
									lineCurve();

						echo"</div>
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



						$result = $conn->query($sql);

						$ID = $_SESSION["id"];

						$sql2 = "SELECT ID FROM Warehouse WHERE Owner_ID = ".$ID."";
						$WID = $conn->query($sql2);
						$row3 = $WID->fetch_assoc();
						echo ($row["ID"]);
						$WID2=(int)$row3["ID"];
						#$location='S:\Softgrid\v5\BF13EC5E-3AD1-479A-9A79-62710CF57235\9E30E881-D22F-4EB9-9514-EAFD8721E6CA\Root\RStudio\bin\rstudio.exe';
						#$lastline = exec("".$location." W:\www\OwnerContractOpt.R $WID2",$full_output,$return_status);
						#$lastline = exec("S:\Softgrid\v5\BF13EC5E-3AD1-479A-9A79-62710CF57235\9E30E881-D22F-4EB9-9514-EAFD8721E6CA\Root\RStudio\bin\rstudio.exe C:\Users\g1090423\W:\www\OwnerContractOpt.R $WID2",$full_output,$return_status);
						#$out = shell_exec("Rscript --verbose OwnerContractOpt_test.R $WID2 2>&1");
						$out = shell_exec("Rscript OwnerContractOpt_test.R $WID2 2>/dev/null");
						$result2 = explode(" ",$out);
						#echo ($result2[1]);
						#echo ($lastline);
						#echo implode("\n",$full_output);
						#print_r($full_output);

						print_r($result2);

						echo "
						<style>
							td, tr:hover {
								opacity: 0.6;
							}

							th:hover {
								opacity: 1.0;
							}
						</style>";
						echo"<table width=450px>";
						echo"<th>Optimized Contract ID</th><th>Accept</th><th>Deny</th>";
						for ($x=1;$x<= ((count($result2))-1);$x++){
						echo"<tr><td>".$result2[$x]."<td>check accept</td><td>check no</td></td></tr>";
						}
						echo"</table>";




						##not printing correct warehouses for logged in owner
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
							<th>Signing Date</th>
							<th>Accept/Deny</th>";

							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {

							echo"
							<tr><td><a href='request.php'>".$row['Warehouse_ID']. "</a></td>
							<td>".$row["Start Date"]."</td>
							<td>".round($row["End Date"],2)."</td>
							<td>".$row["Rented_Space"]."</td>
							<td>".$row["Lessee_ID"]."</td>
							<td>".$row["Signing_date"]."</td>
							<td><form><input type=submit value=".$ID." name = "Accept Contract"></form></td>";
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

					function pieChart()
					{
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
					function lineCurve()
					{
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
