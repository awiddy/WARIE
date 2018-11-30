<?php session_start();?>
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
					<h1><font color="white">Send a Request</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h2>Terms and Conditions</h2>					
					<p>Below is our simple, 3 sectioned contract. Fill out your relevant information, and submit your request to the warehouse owner.</p>
					
					<?php $signing_date=new DateTime(date("Y-m-d"));
					$servername = "mydb.ics.purdue.edu";
					$username = "g1090423";
					$password = "marioboys";
					$dbname = "g1090423";
					$o_id = $_GET['o'];
					$w_id = $_GET['w'];
					$price_raw = $_GET['pr'];
					$price = round($price_raw,2);
					$city = $_GET['c'];
					$state = $_GET['st'];
					$zip = $_GET['z'];
					$start_date = $_GET['sd'];
					$end_date = $_GET['ed'];
					$storage_needed = $_GET['sn'];
					$Owner_ID=$_SESSION["id"]; 
					
					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					} 
					$qry1="SELECT FirstName, LastName, Email FROM Owner WHERE ID = ".$o_id."";
					$fullname = $conn->query($qry1);
					$row1 = $fullname->fetch_assoc();
					
					

					echo "<ul><h3>Persons</h3><li>This contract for the rental of a warehouse is made this day, <u>".date('Y/m/d'). "</u>, by and between ";
					?>
					
					<form name="contractInputs" method="post" action="http://web.ics.purdue.edu/~g1090423/success.php" onsubmit="return validate()">
					
					<div class="6u 12u$(xsmall)">
					<input type="text" name="l_fname" id="l_fname" value="" placeholder="Lessee First Name" required />
					<input type="text" name="l_lname" id="l_lname" value="" placeholder="Lessee Last Name" required />
					</div> hereafter referred to as the Lessee, and
					
					<?php echo("<u>".$row1['FirstName']." ".$row1['LastName']."</u> (<u>".$row1['Email'].")</u>");?>
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
					<!--<div class="4u 12u$(xsmall)">
										<input type="radio" id="disagree" name="agreement">
										<label for="disagree">I do not agree to the above terms and conditions.</label>
									</div>-->
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
