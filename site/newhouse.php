<?php session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
    exit;
}
if($_SESSION['userType']=="LesseeLogin"){
	header("location: lessee_dash.php");
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
		<title>List a Warehouse</title>
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
				</nav>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="browse.php">Browse Warehouses</a></li>
					<li><a href="newhouse.php">List your warehouse</a></li>
					<?php if(($_SESSION["userType"])=="AdminLogin"){
								$link = "admin_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							}
							echo("<li><a href=".$link.">Dashboard</a></li>");
							?>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_utara">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">List a new warehouse</font></h1></br>
					<h3>Enter information to create a new listing</h3>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="inner">
				<div class="slimmer">
					<header>
						<h2>List a new warehouse</h2>
						<p class="info">Enter information to create a new listing</p>
				<!-- Form for adding information into a new warehouse
					when a price is suggested, it continues to a new page
				-->
					</header>
					<form method="post" action="newhouse_suggest.php">
						<div class="row uniform 50%">
							<div class="6u 12u$(xsmall)">
								<h4>Warehouse location:</h4>
								<input type="number" name="zip" id="zip" value="" placeholder="Zip code" required />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Location latitude:</h4>
								<input type="number" name="lat" id="lat" value="" placeholder="Latitude" required />
							</div>
							<br><br><br><br>
							<div class="6u 12u$(xsmall)">
								<h4>Storage capacity (sq ft):</h4>
								<input type="number" min="0" name="storagecapacity" id="storagecapacity" value="" placeholder="Square feet" required />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Location longitude:</h4>
								<input type="number" name="long" id="long" value="" placeholder="Longitude" required />
							</div>
						<br><br><br><br>

						<ul>
						<li> Don't know your latitude and longitude? Search your zip code on <a href="https://www.latlong.net/" target="_blank">this website</a>.</li>
						<li>
						<div class="tooltip"> Why do we need your latitude and longitude?
						<span class="tooltiptext">In order to suggest a price for your warehouse, we take into account many features of your warehouse, and one of those features is your location!</span>
						</div></li>
						</ul>

								<div class="12u$">
								<div class="select-wrapper">
								<h4>Storage Environment:</h4>
								<select name="storagetype" required>
										<option value="">- Storage Type -</option>
										<option value="1">General</option>
										<option value="2">Dry</option>
										<option value="3">Refrigerated</option>
										<option value="4">Frozen</option>
										</select>
										</div>
										</div>
								<br><br>
								<div class="6u 12u$(xsmall)">
								<h4>Price ($/sq ft/month)</h4>
								<input type="number" name="price" min="0" step="0.01" id="price" value="" placeholder="Price" />
								</div>
								<br>
								<div class="6u$ 12u$(xsmall)">
								<ul class="actions">
									<li><button type="submit" name="suggestprice"> Suggest a price for me! </button></li>
									<li><div class="tooltip"> What is this?
									<span class="tooltiptext">Our AI takes into account all these parameters, and suggests a price for your warehouse.</span>
									</div></li>
								</ul>
								</div>
								</div>
								</form>


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
