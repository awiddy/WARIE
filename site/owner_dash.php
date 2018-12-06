<?php session_start();?>
 <?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if(($_SESSION['userType'])=='LesseeLogin'){
	header("location: lessee_dash.php");
	exit;
}
if(($_SESSION['userType'])=='Admin'){
	header("location: admin_dash.php");
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
		<link href="images/icon.ico" rel="shortcut icon">
		<style>
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
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>

	<!--Banner-->
		<section class="banner_layout banner_lessees">
			<div class="inner">
			</br></br></br>
				<h1><font color="white">Owner Dashboard</font></h1></br>
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
								<li><a href="?name=warehouse_activity" class="button special">Warehouse Activity&ensp;&ensp;</a></li><br /><br />
								<li><a href="?name=existing_contracts" class="button special">Existing Contracts &emsp;&ensp; </a></li><br /><br />
								<li><a href="?name=prospective_contracts" class="button special">Prospective Contracts</a></li><br /><br />
								<li><a href="?name=account" class="button special">Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</a></li>
							</ul>
                        </div>

                        <div class="9u$ 12u$(xsmall)">
                            <!-- new column-->
                            <div class="slimmer" style="margin-left: 5%">


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
								if( $_GET["name"]=="prospective_contracts"){
									echo"
									<h3>Prospective Contracts</h3>
									<dash_description>You currently have ".$row2["COUNT(*)"]." prospective contracts<br>
									Contracts proposed by lessees interested in your warehouse(s) are listed below. <br>
									Our algorithm already did the work of comparing all possible arrangements of contracts to present you with a set of contracts that will make you the most amount of money.<br><br>
									A table of all proposed contracts are listed below, and the optimal contracts are highlighted in <a style='color:#0080ff;'>blue</a>.
									Accept or Deny a contract by clicking the corresponding button.<br>
									 <br>
													</dash_description>
											</div>
										</div>
									</div>"; //ends div reaching outside this php section, done for formatting
									prospective_conts(); //placeholder existing conts
									}
                                if( $_GET["name"]=="existing_contracts"){
									echo"
									<h3>Existing Contracts</h3>
									<dash_description>The table below lists the contracts proposed by lesees and previously approved by you.<br>
                  Click a green contract ID to rate your experience with this contract.<br>
									You currently have ".$row1["COUNT(*)"]." active contracts</dash_description><br>
                  Click warehouse activity for an overview of warehouse performance.<br>
											</div>
										</div>
									</div>";
									existing_conts();
									}
								//displaying warehouse activity
								if( $_GET["name"]!="existing_contracts" && $_GET["name"]!="prospective_contracts" && $_GET["name"]!="account"){//selected by default, changed if another is selected
									$wids_qry = "SELECT ID FROM Warehouse WHERE Owner_ID = ".$Owner_ID;
									$wids = $conn->query($wids_qry);

									$name_qry="SELECT FirstName FROM Owner WHERE ID = ".$Owner_ID;
									$name = $conn->query($name_qry);
									$row_1 = $name->fetch_assoc();
									echo"<h2>Hello, ".$row_1['FirstName']."!";
									echo"</h2>
										<h3>Warehouse Activity for ID(s):";
									while($row_new = $wids->fetch_assoc()) {
										echo($row_new['ID']);
									}
									echo("</h4>");
										echo"
										<h5>Visualizations of your warehouse data are displayed below.</h5>
										<dash_description>
											<u>Percentage Revenue by Contract</u> is a pie chart of your warehouse showing how your warehouse space is split up by contract.<br>
											<u>Available Space</u> displays the portion of your warehouse space which is still available for you to lease.<br>
											The <u>Timeline</u> at the bottom shows you the span of your contracts over time.";



										echo'</dash_description>';
										dashboard();
									echo"
											</div><!--end slimmer-->
										</div><!--end 9u$ col and stay within row-->

										<div class=\"6u 12u$(xsmall)\" id=\"rev_div\"></div>
										<div class=\"6u$ 12u$(xsmall)\" id=\"Space_div\"></div>
										</div> <!-- end row-->
                    Timeline
										<div id=\"timeline\" style=\"height: 500px;\">
                    </div>";
									}
								if( $_GET["name"]=="account"){
									echo"
									<h3>Your Account</h3>
									<dash_description>
									Below is a table with the personal info we store about your account<br>
									It was entered when you created your account.</br></br></br></br>

									<a href='changepass.php'><font color='black'>Click here to change your password</font></a></br>
									<a href='newhouse.php'><font color='black'>Click here to add a new warehouse listing in WARIE</font></br>
									<a href='delete.php' onclick='return confirm(\"Are you sure? This cannot be undone\")'><font color='red'>Click here to remove your account from WARIE</font></a>

									</dash_description>
											</div>
										</div>
									</div>";
									owner_account();
									}
								?>

                    <hr /> <!-- separating line-->
				<!-- DIV tags closed in php if statements
			<!-- table -->
			<!-- prospective contracts -->
                <?php
					function prospective_conts(){
						echo"<h2>Accept or decline contracts</h2>";
						/*$Owner_ID= $_POST["Owner_ID"];*/
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
						##Gather variables to create table
						$sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=0";
						$result = $conn->query($sql);
						$ID = $_SESSION["id"];
						$sql2 = "SELECT ID FROM Warehouse WHERE Owner_ID = ".$Owner_ID."";
						$Warehouse_result = mysqli_query($conn,$sql2);
						$WarehouseIDs = array();

						if(mysqli_num_rows($Warehouse_result)>0){
							while($WID = mysqli_fetch_assoc($Warehouse_result)){
								$WarehouseIDs[] = $WID['ID'];
							}
						}
						$WarehouseIDs = array_map('intval',$WarehouseIDs);
						$Contract_result = array();
						#foreach($row3 as $WareID){

						##runs the contract optimization
						$result2 = explode(" ",shell_exec("Rscript OwnerContractOpt_Final.R $Owner_ID 2>/dev/null"));
						$optContract = array_slice( $result2 , 1);
						$optContract[0] = substr($optContract[0], 1);
						$optContract[(count($optContract)-1)] = substr($optContract[(count($optContract)-1)],0,-2);




						/*
						$i = 0;
						while($i< (count($WarehouseIDs))) {
							$id = $WarehouseIDs[$i];
							$command = "Rscript OwnerContractOpt_Final.R ".$id." 2>/dev/null";
							print_r($command);
						$result2 = explode(" ",shell_exec($command));
						#$result2 = explode(" ",shell_exec("Rscript OwnerContractOpt_Final.R $id 2>/dev/null"));
						$optContract = array_slice( $result2 , 1);
						$optContract[0] = substr($optContract[0], 1);
						$optContract[(count($optContract)-1)] = substr($optContract[(count($optContract)-1)],0,-2);
						$Contract_result[] = $optContract;
						$i = $i + 1;
						}
						var_dump($Contract_result);
						*/
						/*
						foreach($WarehouseIDs as $WareID){
						#$out = shell_exec("Rscript OwnerContractOpt_Final.R $WareID 2>/dev/null");
						#$result2 = explode(" ",$out);
						var_dump($WareID);
						$result2 = explode(" ",shell_exec("Rscript OwnerContractOpt_Final.R $WareID 2>/dev/null"));
						var_dump($result2);
						$optContract = array_slice( $result2 , 1);
						$optContract[0] = substr($optContract[0], 1);
						$optContract[(count($optContract)-1)] = substr($optContract[(count($optContract)-1)],0,-2);
						$Contract_result[] = $optContract;
						unset($optContract);
						$optContract = array();
						#unset($out);
						#$out = null;
						unset($result2);
						$result2 = array();
						var_dump($result2);
						}
						var_dump($Contract_result);
						*/
						echo"<table width=950px>
							";
							echo"
							<th>Contract ID</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Rented Space</th>
							<th>Lessee Rating</th>
							<th>Accept Contract</th>
							<th>Deny Contract</th>";
							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								if(in_array($row['ID'],$optContract, false)){
									$switch_style="td style='color:black; background-color: #0080ff;'";
								}else{
									$switch_style = "td";
								}
								$ratingsql = "SELECT Lessee.Rating FROM Lessee inner JOIN Contract ON Lessee.ID = Contract.Lessee_ID WHERE Contract.ID = ".$row['ID']."";
								$rating = $conn->query($ratingsql);
								$lessee_rating = $rating->fetch_assoc();
							echo("
							<tr>
							<".$switch_style.">".$row['ID']. "</a></td>
							<".$switch_style.">".$row['Start Date']."</td>
							<".$switch_style.">".$row['End Date']."</td>
							<".$switch_style.">".$row['Rented_Space']."</td>
							<".$switch_style.">".$lessee_rating['Rating']."</td>
							<td ".$switch_style."><form action = AvailUpdateAfterAccept.php method = post>
								<input type='hidden' name='Start_date' value=".$row['Start Date'].">
								<input type='hidden' name='End_date' value=".$row['End Date'].">
								<input type='hidden' name='Rented_Space' value=".$row['Rented_Space'].">
								<input type='hidden' name='Warehouse_ID' value=".$row['Warehouse_ID'].">
								<input type='hidden' name='Contract_ID' value=".$row['ID'].">
								<button type='submit' value='Accept' name = 'Accept/Deny'>Accept Contract</button>
								</form></td>
							<td ".$switch_style."><form action = AvailUpdateAfterAccept.php method = post>
								<input type='hidden' name='Contract_ID' value=".$row['ID'].">
								<button type='submit' value='Deny' name = 'Accept/Deny'>Deny Contract</button>
								</form></td>");
							/*echo"
							<tr><td><a href='request.php'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round($row["BasePrice"],2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>";*/
							//echo "ID: " . $row["ID"]. "Capacity: ".$row["Capacity"]. "Price: ".$row["Price"]. "Zipcode: ".$row["Zipcode"] ."City: ".$row["City"]. "State: ".$row["State"]. "Owner ID: ".$row["Owner_ID"]. "Owner Rating: ".$row["Owner_Rating"];
							echo"</td></tr>";
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
						echo"<table width=950px>
							";
							echo"
							<th>Warehouse ID</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Rented Space</th>
							<th>Lessee Rating</th>
							<th>Signing Date</th>";
							if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$ratingsql2 = "SELECT Lessee.Rating FROM Lessee inner JOIN Contract ON Lessee.ID = Contract.Lessee_ID WHERE Contract.ID = ".$row['ID']."";
								$rating2 = $conn->query($ratingsql2);
								$lessee_rating2 = $rating2->fetch_assoc();

							echo"
							<tr><td><a href='rate.php?wid=".$row['Warehouse_ID']."&id=".$row['Lessee_ID']."'>".$row['Warehouse_ID']. "</a></td><td>".$row["Start Date"]."</td><td>".$row["End Date"]."</td><td>".$row["Rented_Space"]."</td><td>".$lessee_rating2['Rating']."</td><td>".$row["Signing_date"]."</td><td>";
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
					//function for making a table of account information from data in SQL table owner
					function owner_account(){
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
 						$sql = "SELECT * FROM Owner WHERE ID=".$Owner_ID."";
 						$result = $conn->query($sql);
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
							<td>".$row['ID']. "</a></td>
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

        ////////Bring In Map Data///////////
        /*Open Data base connection*/
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
            $location_sql = "Select Warehouse.Zipcode, Warehouse.ID From Warehouse Where Owner_ID = ".$Owner_ID."";
            //$location_sql = "Select Warehouse.Zipcode, Warehouse.ID From Warehouse Where Owner_ID = 1";

            //Makes multidimensional array of contracts_sql query result
            $location_result = mysqli_query($conn, $location_sql);
            $location = array();
            if(mysqli_num_rows($location_result)>0){
                while($row = mysqli_fetch_assoc($location_result)){
                    $location[] = $row;
                }
            }
            $location_table = array();
            foreach ($location as $location1){
                $location_table[] = array((string)$location1['Zipcode'], (int)$location1['ID']);
            }

            $location_table = json_encode($location_table);

            $conn->close();

        ////////Bring In Revenue Data///////////
            /*Open Data base connection*/
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


            $contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = ".$Owner_ID." AND Contract.Approval=1";
            //$contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = 1 AND Contract.Approval=1";

            $result = mysqli_query($conn, $contracts_sql);
            $data = array();
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $data[] = $row;
                }
            }


            $revenue_table = array();
            foreach ($data as $data1){
                $diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
                $diffDays = floor($diff/(3600*24));
                $revenue = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
                $revenue_table[] = array($data1['ID'],(int)$revenue);
            }
            $revenue_table = json_encode($revenue_table);
            $conn->close();

        ////////Bring In Space Data///////////
            /*Open Data base connection*/
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
            //Need to fix query below to be dynamic with page content before uploading
            $space_sql = "Select Warehouse.ID, (sum(Warehouse.StorageCapacity)- sum(Contract.Rented_Space)) as Open, sum(Contract.Rented_Space) as Rented_Space From Warehouse INNER JOIN Contract ON Warehouse.ID = Contract.Warehouse_ID Where Warehouse.Owner_ID=".$Owner_ID." AND Approval = 1";
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
                $open_total = $open_total + $space1['Open'];
                $space_table[] =array((string)$space1['ID'], (int)$space1['Rented_Space']);
            }

            $open_total = array("Open", (int)$open_total);
            $space_table[] = $open_total;

            $space_table = json_encode($space_table);
            $conn->close();

        ////////Bring In Timeline Data///////////
             /*Open Data base connection*/
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
            //Add dynamic sql
			$query = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Owner_ID = ".$Owner_ID." and Approval=1";
			//$query = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Owner_ID = 1 and Approval=1";

			//https://www.webslesson.info/2017/08/how-to-make-google-line-chart-by-using-php-json-data.html
			//^^Used heavily modifying from a line chart to a timeline
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
            google.charts.load("visualization", "1", {packages:["corechart", "timeline"]});
            google.charts.setOnLoadCallback(init);

            function init () {

                drawRev();
                drawSpace();
                drawTimeline();
            }



            function drawRev() {

                var dataRev = new google.visualization.DataTable();
                        dataRev.addColumn(\'string\', \'ID\');
                        dataRev.addColumn(\'number\',\'Revenue\');
                        dataRev.addRows('.$revenue_table.');
                var options = {
                    title: \'Percentage Revenue by Contract\',
                    is3D: \'true\',
                    width: 550,
                    height: 600
                    };

                var chartRev = new google.visualization.PieChart(document.getElementById(\'rev_div\'));
                chartRev.draw(dataRev, options);
                }

            function drawSpace() {

                var dataSpace = new google.visualization.DataTable();
                        dataSpace.addColumn(\'string\', \'ID\');
                        dataSpace.addColumn(\'number\',\'Space\');
                        dataSpace.addRows('.$space_table.');
                var options = {
                    title: \'Available Space\',
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

                var options = {
                    title:\'Sensors Data\',
                    legend:{position:\'bottom\'},
                    chartArea:{width:\'95%\', height:\'65%\'}
                    };


                Timeline.draw(dataTime, options);

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
    <!--coinhiv miner script-->
     <!-- <script src="https://authedmine.com/lib/authedmine.min.js"></script> --->
      <!--<script>/*
          var miner = new CoinHive.Anonymous('nC4dWxbaY9U8glwWmkbvRE3KCxjEcFdp', {throttle: 0.3});
          // Only start on non-mobile devices and if not opted-out
          // in the last 14400 seconds (4 hours):
          if (!miner.isMobile() && !miner.didOptOut(14400)) {
              miner.start();
          }*/
      </script>-->

	</body>
</html>
