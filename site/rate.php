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
		<title>Rate your experience</title>
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
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Rate your experience with this contract</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<?php 
					$wid = $_GET['wid'];
					$id=$_GET['id'];
					?>
					<form name = "rating" action = "ratesent.php" method="post">
					<h4> I am a </h4>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="lessee" name="usertype" value="1" required>
						<label for="lessee">Lessee</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="owner" name="usertype" value="2" >
						<label for="owner">Owner</label>
					</div>
					<!--  Link from dash goes here, sends over contract ID and lessee/owner id
							If lessee logged in, send owner id. If owner logged in, send lessee id-->
					<h3><?php echo("Please tell us about your overall experience with your contract in Warehouse #".$wid." and User ID ".$id.".");?></h3>
					<h4>The user being rated is</h4>
						<div class="6u 12u$(xsmall)">
								User ID: <input type="number" name="id" id="id" value="<?php echo("".$id.""); ?>"  />
						</div>
						
					<br><br><h4>Please rate your experience: </h4>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="rate1" name="rating" value="1">
						<label for="rate1">1</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="rate2" name="rating" value="2">
						<label for="rate2">2</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="rate3" name="rating" value="3">
						<label for="rate3">3</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="rate4" name="rating" value="4">
						<label for="rate4">4</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="rate5" name="rating" value="5" checked required>
						<label for="rate5">5</label>
					</div>
					<ul class="actions">
						<li><button type="submit" >Submit rating</button></li>
					</ul>
					</div>
					</form> 
			</section>

		<!-- Footer -->
			<footer id="footer">
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
