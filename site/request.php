<?php session_start();

// Check if the user is logged in, if not then redirect him/her to login page
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
		<title>Request</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link href="images/icon.ico" rel="shortcut icon">
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
					<li><a href="logout.php">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Send a Request</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h2>Terms and Conditions</h2>
					<p>Below is our simple, 3 sectioned contract. Fill out your relevant information, and submit your request to the warehouse owner.</p>

					<?php
					//Retreiving values from URL and setting values for DB connection
					$signing_date=new DateTime(date("Y-m-d"));
					$servername = "mydb.ics.purdue.edu";
					$username = "g1090423";
					$password = "marioboys";
					$dbname = "g1090423";
					$o_id = $_GET['o'];
					$w_id = $_GET['w'];
					$price_raw = $_GET['pr'];
					$price = round($price_raw/12,2);
					$city = $_GET['c'];
					$state = $_GET['st'];
					$zip = $_GET['z'];
					$start_date = $_GET['sd'];
					$end_date = $_GET['ed'];
					$storage_needed = $_GET['sn'];
					$l_id=$_SESSION["id"];

					//Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					//Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
					//Creating and executing a query to receive the full name of the Owner of the Warehouse selected (from the results page) by the user
					$qry1="SELECT FirstName, LastName, Email FROM Owner WHERE ID = ".$o_id."";
					$fullname = $conn->query($qry1);
					$row1 = $fullname->fetch_assoc();


					//Writing up the contract

					echo "<ul><h3>Persons</h3><li>This contract for the rental of a warehouse is made this day, <u>".date('Y/m/d'). "</u>, by and between ";
					?>
					<!-- Submitting this form sends all the information inputted/selected by the user to the success page-->
					<form name="contractInputs" method="post" action="http://web.ics.purdue.edu/~g1090423/csuccess.php?<?php echo("&sn=".$storage_needed."&o=".$o_id."&w=".$w_id."&l=".$l_id."&sd=".$start_date."&ed=".$end_date.""); ?>" onsubmit="return validate()">

					<!-- Lessee enters full name here -->
					<div class="6u 12u$(xsmall)">
					<input type="text" name="l_fname" id="l_fname" value="" placeholder="Lessee First Name" required />
					<input type="text" name="l_lname" id="l_lname" value="" placeholder="Lessee Last Name" required />
					</div> hereafter referred to as the Lessee, and
					<!-- Auto-filling the contract with information about the Owner and the contract based on the inputted/selected information by the user on the browse page-->
					<!-- Contract referenced from https://eforms.com/rental/commercial/facility-event-space-rental-agreement-template -->
					<?php
					echo("<u>".$row1['FirstName']." ".$row1['LastName']."</u> (<u>".$row1['Email'].")</u>");?>
					 hereafter referred to as the Owner, at the location  of Warehouse ID #<u><?php echo ($w_id)?></u> located in <u><?php echo "".$city.", ".$state.", ".$zip.","?></u>
					owned and agreed upon by the Owner, hereafter referred to as the warehouse.</li>
					<h3>Logistics</h3>
					<li>This contract between the Lessee and Owner is for the storage amount of <u><?php echo($storage_needed);?></u> sq ft
					 and the goods stored will be
					<div class="6u 12u$(xsmall)">
					<input type="text" name="goods" id="goods" value="" placeholder="Goods to be stored" required />
					</div> hereafter referred to as Goods. The price of $<u><?php echo($price); ?></u> /sq ft/ month set forward by the owner will be tendered to the Owner upon a monthly basis by the Lessee</li>
					<br><h3>Dates</h3>
					<li>The Lessee shall have access to and use of the warehouse from 8:00 am on <?php echo ("<u>".$start_date."</u>");?>
					to 5 pm on <?php echo("<u>".$end_date."</u>");?>
					<br></div></ul>
					<div class="slimmer">
					<ul>
					<li>Within 1 week (7 days) of the rental period’s expiration, Lessee shall return to Owner all keys and other access control devices in his/her possession.</li>
					<li>Lessee shall remove all Goods, personal property, trash, and other items that were not present in the warehouse when Lessee took control of it.</li>
					<li>Lessee will be liable for any physical damages, legal actions, and/or loss of reputation or business opportunities that Owner may incur as a consequence of the actions of Lessee or any of Lessee's guests
					while Lessee is in control of the warehouse, and shall indemnify and hold harmless the Owner against any and all legal actions which may arise from Lessee's use of the warehouse.</li>
					</ul>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="agree" name="agreement" required>
						<label for="agree">I agree to the above terms and conditions.</label>
					</div>
					<input type="submit" value="Submit your request">
					
					</div>
					</form>
					</div>
					</section>
					<?php $conn->close();?>

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
