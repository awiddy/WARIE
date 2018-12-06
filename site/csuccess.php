<?php session_start();
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
		<title>Sent!</title>
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
					<?php if(($_SESSION["userType"])=="LesseeLogin"){
								$link = "lessee_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							}
							echo("<li><a href=".$link.">Dashboard</a></li>");
							?>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Request sent!</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h3>Please wait until you hear back from the owner.</h3>
					<a href="browse.php" class="button special" target="_blank">Search Again</a>
					<?php
					//Retreiving data from URL/Post function, as well as setting variables for the query/DB connection
					$start_date_raw = $_GET["sd"];
					$end_date_raw = $_GET["ed"];
					$o_id = $_GET['o'];
					$l_id = $_GET['l'];
					$sn = $_GET['sn'];
					$w_id = $_GET['w'];
					$signing_date1=new DateTime(date("Y-m-d"));
					$approval=0; //approval always starts as 0, because it starts as unaccepted/pending
					
					
					$servername = "mydb.ics.purdue.edu";
					$username = "g1090423";
					$password = "marioboys";
					$dbname = "g1090423";

					$email_qry = "SELECT Email FROM Owner WHERE ID = ".$o_id."";
					$email_result = $conn->query($email_qry);
					$row1 = $email_result->fetch_assoc();
					$email = $row1['Email'];
					
					//Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					//Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}


					//Ensuring dates are in correct format
					$signing_date = $signing_date1->format('Y-m-d');
					

					//Writing query to add requested contract into Contract table in DB
					$sql = "INSERT INTO Contract (`Start Date`,`End Date`,Lessee_ID,Owner_ID,Rented_Space, Signing_date,Warehouse_ID,Approval) VALUES ('".$start_date_raw."','".$end_date_raw."',".$l_id.",".$o_id.",".$sn.",'".$signing_date."',".$w_id.",".$approval.")";
					
					mysqli_query($conn,$sql);
					$msg = "Hello from the Warie Staff!\n\nYou have a new requested Contract at Warehouse ID #".$w_id."\n\nTo review all prospective and existing contracts, please visit your Dashboard.\n\nThank you,\nWarie Staff.";
					$msg = wordwrap($msg,70); //wrap if lines are longer than 70 characters
					$subject = "New Contract Request at Warehouse #".$w_id."";
					
					mail($email,$subject,$msg); //sends email

					
					mysqli_close($conn);
					?>

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
