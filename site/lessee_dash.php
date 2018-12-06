<?php session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
	exit;
}
//Restricts owners from going to lessee dash
if (($_SESSION['userType'])=="OwnerLogin"){
	header("location: owner_dash.php");
	exit;}
else if (($_SESSION['userType'])=="Admin"){
	header("location: admin_dash");
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
		<link href="images/icon.ico" rel="shortcut icon">
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
				<li><a href='lessee_dash.php'>Dashboard</a></li>
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
								<li><a href="?name=activity" class="button special">Your Activity&emsp;&emsp;&emsp;&emsp;</a></li><br><br>
								<li><a href="?name=requested_contracts" class="button special">Requested Contracts&ensp;</a></li><br><br>
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
			          //if statements look at GET parameters in URL to decide which functions to run, funcs created below
  							//check to see if url parameter is for requested contracts
  								if( $_GET["name"]!="existing_contracts" && $_GET["name"]!="warehouse_activity" && $_GET["name"]!="account" && $_GET["name"]!="activity"){ //OR operator used to set this selection to default
  									$name_qry="SELECT FirstName FROM Lessee WHERE ID = ".$Lessee_ID;
  									$name = $conn->query($name_qry);
  									$row_1 = $name->fetch_assoc();

  									echo("<h2>Hello, ".$row_1['FirstName']."!</h2>");

  									echo"<h3>Requested Contracts</h3>
    									<dash_description>This page shows your contracts that are currently pending. You will receive an email when an owner responds to your request.<br><br>
    									You currently have <strong>".$row2["COUNT(*)"]."</strong> requested contracts <br><br>
                      </dash_description>

            							</div>
            						</div>
                      </div>"; //ends div reaching outside this php section, done for formatting
                      requested_conts();
					          }
                  //warehouse activity
  								if( $_GET["name"]=="activity"){
  									echo"
  					         <h3>Your Activity</h3>
                     <dash_description>
                      graphs
                     </dash_description>
                     </div>";// ends this column
  									dashboard();

      							echo"
          						</div>
          						<div class=\"6u 12u$(xsmall)\" id=\"rent_div\"></div>
          						<div class=\"6u$ 12u$(xsmall)\" id=\"Space_div\"></div>
                      </div> <!-- end rows -->
                        Timeline
          						<div id=\"timeline\">
      					      </div>";
  									}

                                    if( $_GET["name"]=="existing_contracts"){
									echo"
  									<h3>Existing Contracts</h3>
  									<dash_description>
                      The table below shows your contracts which have been accepted by warehouse owners and are currently active.<br>
                      Click a <a>green</a> contract ID to rate your experience with this contract.<br><br>
    									You currently have ".$row1["COUNT(*)"]." active contracts
                    </dash_description>
            							</div>
          						</div>
          					</div>";
  					        existing_conts();
									}
								if( $_GET["name"]=="account"){
									echo"
    								<h3>Your Account</h3>
    								<dash_description>
    									Below is a table with the personal info we store about your account<br>
    									It was entered when you created your account.</br></br></br></br><br>
    									<a href='changepass.php'><font color='black'>Click here to change your password</font></a></br>
    									<a href='delete.php' onclick='return confirm(\"Are you sure? This cannot be undone\")'><font color='red'>Click here to remove your account from WARIE</font></a>
    								</dash_description>
        						</div>
          					</div>
            				</div>";
          					lessee_account();
									}
								?>


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

						$result = $conn->query($sql);
				      echo"<table width=950px>";
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
							<tr><td>".$row['Warehouse_ID']. "</a></td>
							<td>".$row["Start Date"]."</td>
							<td>".$row["End Date"]."</td>
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
						echo"<h2>Your existing contracts

						</h2>";
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
							<tr><td><a href='rate.php?wid=".$row['Warehouse_ID']."&id=".$row['Lessee_ID']."'>".$row['Warehouse_ID']. "</a></td>
							<td>".$row["Start Date"]."</td>
							<td>".$row["End Date"]."</td>
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
						echo"<h2>Your information</h2>";
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

						$result = $conn->query($sql);
							echo"
              <table width=950px>
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

					///Makes Dashboard////
					function dashboard(){

						////////Bring In Rent Data///////////
							/*Open Data base connection*/
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

							$contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Lessee_ID = ".$Lessee_ID." AND Contract.Approval=1";

							$result = mysqli_query($conn, $contracts_sql);
							$data = array();
							if(mysqli_num_rows($result)>0){
								while($row = mysqli_fetch_assoc($result)){
									$data[] = $row;
								}
							}


							$rent_table = array();
							foreach ($data as $data1){
								$diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
								$diffDays = floor($diff/(3600*24));
								$rent = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
								$rent_table[] = array($data1['ID'],(int)$rent);
							}
							$rent_table = json_encode($rent_table);
							$conn->close();

						////////Bring In Space Data///////////
							/*Open Data base connection*/
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
							//Need to fix query below to be dynamic with page content before uploading
							$space_sql = "Select Warehouse_ID, Contract.Rented_Space as RentedSpace From Contract Where Lessee_ID=".$Lessee_ID." AND Approval = 1 GROUP BY Warehouse_ID";
							//$space_sql = "Select Warehouse.ID, (sum(Warehouse.StorageCapacity)- sum(Contract.Rented_Space)) as Open, sum(Contract.Rented_Space) as Rented_Space From Warehouse INNER JOIN Contract ON Warehouse.ID = Contract.Warehouse_ID Where Warehouse.Owner_ID=1 AND Approval = 1";

							$result = mysqli_query($conn, $space_sql);
							$space = array();
							if(mysqli_num_rows($result)>0){
								while($row = mysqli_fetch_assoc($result)){
									$space[] = $row;
								}
							}
							$space_table = array();
							$open_total = 0;
							foreach ($space as $space1){

								$space_table[] =array((string)$space1['Warehouse_ID'], (int)$space1['RentedSpace']);
							}


							$space_table = json_encode($space_table);
							$conn->close();

						////////Bring In Timeline Data///////////
							 /*Open Data base connection*/
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
							//Add dynamic sql
							$query = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Lessee_ID = ".$Lessee_ID." and Approval=1";

							//$query = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Owner_ID = 1 and Approval=1";
								$result = mysqli_query($conn, $query);
								$rows = array();
								$table = array();

								$table['cols'] = array(
								array(
								'label' => 'ID',
								'type' => 'string'
								),
								array(
								'label' => 'StartTime',
								'type' => 'datetime'
								),
								array(
									'label' => 'EndTime',
									'type' => 'datetime'
									),

								);

								while($row = mysqli_fetch_array($result))
								{
								$sub_array = array();
								$StartTime = explode(".", $row["StartDate"]);
								$EndTime = explode(".", $row["EndDate"]);
								$sub_array[] =  array(
									"v" => $row["ID"]
									);

								$sub_array[] =  array(
									"v" => 'Date(' . $row["StartDate"] . '000)'
									);
								$sub_array[] =  array(
									"v" => 'Date(' . $row["EndDate"] . '000)'
									);
								$rows[] =  array(
									"c" => $sub_array
									);
								}
								$table['rows'] = $rows;
								$jsonTable = json_encode($table);


								$conn->close();



						////Google Chart Creation/////
							echo"<head>";
							echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
							echo'<script type="text/javascript">
							google.charts.load("visualization", "1", {packages:["map", "corechart", "timeline"], "mapsApiKey": "AIzaSyDi799MTv01g9mQ2C2p1km1v7v1bTIjs-Q"});
							google.charts.setOnLoadCallback(init);

							function init () {

								drawRent();
								drawSpace();
								drawTimeline();
							}

							function drawMap() {
								var dataMap = new google.visualization.DataTable();
									dataMap.addColumn(\'string\', \'zip\');
									dataMap.addColumn(\'number\', \'Warehouse ID\');
									dataMap.addRows('.$location_table.');

								var map = new google.visualization.Map(document.getElementById(\'map_div\'));
								map.draw(dataMap, {
								showTooltip: true,
								showInfoWindow: true
								});
							}

							function drawRent() {

								var dataRent = new google.visualization.DataTable();
										dataRent.addColumn(\'string\', \'ID\');
										dataRent.addColumn(\'number\',\'Rent\');
										dataRent.addRows('.$rent_table.');
								var options = {
									title: \'Percentage Rent by Contract\',
									is3D: \'true\',
									width: 550,
									height: 600
									};

								var chartRent = new google.visualization.PieChart(document.getElementById(\'rent_div\'));
								chartRent.draw(dataRent, options);
								}

							function drawSpace() {

								var dataSpace = new google.visualization.DataTable();
										dataSpace.addColumn(\'string\', \'ID\');
										dataSpace.addColumn(\'number\',\'Space\');
										dataSpace.addRows('.$space_table.');
								var options = {
									title: \'Percentage of Space Occupied by Contract\',
									is3D: \'true\',
									width: 550,
									height: 600
									};

								var chartSpace = new google.visualization.PieChart(document.getElementById(\'Space_div\'));
								chartSpace.draw(dataSpace, options);
								}


							function drawTimeline(){


								var container = document.getElementById(\'timeline\');
								var Timeline = new google.visualization.Timeline(container);
								var dataTime = new google.visualization.DataTable('.$jsonTable.');




								Timeline.draw(dataTime);

							}

							</script>';
							echo"</head>";
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
