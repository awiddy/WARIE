<?php session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
	exit;
}if (($_SESSION['userType'])=="LesseeLogin"){
	header("location: lessee_dash.php");
	exit;
}if (($_SESSION['userType'])=="Admin"){
	header("location: admin_dash.php");
	exit;
}

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

	$lid_qry = "SELECT Lessee_ID FROM Contract WHERE ID = ".$_POST["Contract_ID"]."";
	$lid_result = $conn->query($lid_qry);
	$row1 = $lid_result->fetch_assoc(); 
	$l_id = $row1['Lessee_ID'];
		
	$email_qry = "SELECT Email FROM Lessee WHERE ID = ".$l_id."";
	$email_result = $conn->query($email_qry);
	$row2 = $email_result->fetch_assoc();
	$email = $row2['Email'];
	
	if($_POST['Accept/Deny'] == "Accept"){ ##if the user clicks accept contract
	##Assigning names to all the Passed in variables 
	$Warehouse_ID = $_POST["Warehouse_ID"];
	$Contract_ID = $_POST["Contract_ID"];
	$Start_date = $_POST["Start_date"];
	$End_date = $_POST["End_date"];
	$Rented_Space = $_POST["Rented_Space"];

	##turning the strings into dates
	$start_date1= date_create("$Start_date");
	$end_date1=date_create("$End_date");
	$current_date = new DateTime(date("Y-m-d")); ##current date

	##converting date intervals to int to get into format in availabilty table
	$start_days = $start_date1->diff($current_date)->format("%a");##days until start of contract
	$start_date_week = ceil($start_days/7);##weeks until the start of contract
	$end_days = $end_date1->diff($current_date)->format("%a"); ##days until end of contract
	$end_date_week = ceil($end_days/7); ##weeks until the end of contract

	##SQL Statement that updates the availability for the newly rented space once the contract has been accepted					
	$sql = "UPDATE Availability SET Open_Space = (Open_Space - ".$Rented_Space.") WHERE WeekFromDate Between ".$start_date_week." AND ".$end_date_week." AND  WarehouseID = ".$Warehouse_ID."";
	$result = $conn->query($sql);
	##Changes Contract Approval from 0 to 1
	$sql2 = "UPDATE Contract SET Approval = 1 WHERE ID = ".$Contract_ID."";
	$result2 = $conn->query($sql2);
	//Sends an email to the lessee
		$msg = "Hello from the Warie Staff!\n\n\nWe're emailing you to inform you that Contract ID #".$_POST['Contract_ID']." for Warehouse ID #".$_POST['Warehouse_ID']." has been accepted. \n\nPlease visit your Dashboard to see all updates.\n\nThank you,\nWarie Staff";
		$msg = wordwrap($msg,70); //wrap if lines are longer than 70 characters
		$subject = "Contract ID #".$_POST['Contract_ID']." accepted";
		mail($email,$subject,$msg); //sends email
	}
	
	if($_POST['Accept/Deny'] == "Deny"){ #if deny contract is clicked
		//Sends an email to the lessee
		$msg = "Hello from the Warie Staff!\n\n\nWe're emailing you to inform you that Contract ID #".$_POST['Contract_ID']." for Warehouse ID #".$_POST['Warehouse_ID']." has been denied. \n\nPlease visit your Dashboard to see all updates.\n\nThank you,\nWarie Staff";
		$msg = wordwrap($msg,70); //wrap if lines are longer than 70 characters
		$subject = "Contract ID #".$_POST['Contract_ID']." denied";
		mail($email,$subject,$msg); //sends email
	
		$sql3 = "DELETE FROM Contract WHERE ID = ".$_POST["Contract_ID"].""; ##Deletes Contract From Database
		$result3 = $conn->query($sql3);	
	
	
	}

	//close connection
	$conn->close();	
?>

<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	SELECT Open_Space FROM Availability WHERE WeekFromDate Between ".$Start_Date." AND ".$End_Date." AND WarehouseID = ".$Warehouse_ID.") - ".$Rented_Space." 
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

<html>
	<head>
		<title>Contracts updated</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<!-- Header -->
			<header id="header">
				<a href="index.php" class="logo"><strong>WARIE</strong> &ensp; Home</a>
				<nav>
					<a href="#menu">Menu</a>
				</nav>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="browse.php">Browse Warehouses</a></li>
					<li><a href="newhouse.php">List your warehouse</a></li>
					<li><a href="owner_dash.php">Dashboard</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Contracts updated</font></h1></br>
				</div>
		</section>
		<section id="main">
			<div class="slimmer">
			<h3> Success! <h3></br>			
			<div class="9u$ 12u$(xsmall)">
				<?php
				
					
					if($_POST['Accept/Deny'] == "Accept"){
					echo "<p> You accepted Contract ID #".$_POST['Contract_ID'].".<p>
					<p>The availability of Warehouse #".$_POST['Warehouse_ID']." has been updated accordingly, and we have notified the lessee of your decision.<p>";
					
					
					}
					if($_POST['Accept/Deny'] == "Deny"){
					echo "<p> You have denied Contract ID #".$_POST['Contract_ID'].". We have notified the lessee of your decision.<p>";
					$status = "denied.";
					$subject = "Contract ID #".$_POST['Contract_ID']." denied";
					}
					

				?>
			</div>
			<a href="owner_dash.php"><font color="blue">Click here to return to the contract dashboard</font></a>
			</div>
			</section>

<footer id="footer">
			<div class="copyright" style="font-weight:500;">
			<ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.php">Terms and Conditions</a>	
				&copy; Untitled. Design: <a href="https://templated.co" style="font-weight:500;">TEMPLATED</a>. Images: <a href="https://unsplash.com" style="font-weight:500;">Unsplash</a>.
			</div>
		</footer>