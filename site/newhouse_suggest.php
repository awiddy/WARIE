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
					<li><a href="logout.php">Login</a></li>
				</ul>
			</nav>

		<!-- Main -->
			<section id="main">
				<div class="inner">
				<div class="slimmer">
					<div class="image fit">
						<img src="images/pic11.jpg" alt="" />
					</div>
					<header>
						<h2>List a new warehouse</h2>
						<p class="info">Enter information to create a new listing</p>

					</header>
					<form method="post" action="wsuccess.php">
					<?php
					$lat = $_POST['lat'];
					$long = $_POST['long'];
					$storagecapacity=$_POST['storagecapacity'];
					$zip=$_POST['zip'];
					$storagetype=$_POST['storagetype'];
					
					
					?>
					<!-- Auto fills information from last page and suggests price using neural network-->
						<div class="row uniform 50%">
							<div class="6u 12u$(xsmall)">
								<h4>Warehouse location:</h4>
								<input type="number" name="zip" id="zip" value="<?php echo($zip);?>" placeholder="Zip code" required />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Location latitude:</h4>
								<input type="number" name="lat" id="lat" value="<?php echo($lat);?>" placeholder="Latitude" required />
							</div>


							<br><br><br><br>

							<div class="6u 12u$(xsmall)">
								<h4>Storage capacity (sq ft):</h4>
								<input type="number" min="500" name="storagecapacity" id="storagecapacity" value="<?php echo($storagecapacity);?>" placeholder="Square feet" required />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Location longitude:</h4>
								<input type="number" name="long" id="long" value="<?php echo($long);?>" placeholder="Longitude" required />
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
								<select name="storagetype" value = "1" required>
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
								<input type="number" name="price" min = "0" id="price" step="0.01" value="" placeholder="Price" />
								</div>
								<br>
								<div class="6u$ 12u$(xsmall)">
								<ul class="actions">
									<li><button type="button" name="suggestprice">Suggest a price for me!</button></li>
									<li><div class="tooltip"> What is this?
									<span class="tooltiptext">Our AI takes into account all these parameters, and suggests a price for your warehouse.</span>
									</div></li>
								</ul>
								
								
								</div>
								</div>
								

								<?php function Suggest(){
								$zip = $_POST["zip"];
								$storagecapacity=$_POST["storagecapacity"];
								$storagetype=$_POST["storagetype"];
								$lat = $_POST["lat"];
								$long = $_POST["long"];
								echo("<div id='suggest'>
								<h5>Suggested Price: </h5>");
							//Calling R script that suggests a price from the neural network
								$out = shell_exec("Rscript suggestPrice_test.R $zip $storagecapacity $storagetype $lat $long 2>/dev/null");//2>&1
								echo("<h5>$");
								echo str_replace("[1]","",$out);
								echo("/sq ft/month</h5>");
								}
								
								if(isset($_POST['suggestprice'])){
									Suggest(); //calling function when button is pressed
								}
							
								echo($out);?>
								</div>
								
						
							
							<div class="slimmer">
							<div class="6u 12u$(xsmall)">
								<br><h4>City:</h4>
								<input type="text" name="city" id="city" value="" placeholder="City" />
							</div>
							<div class="6u 12u$(xsmall)">
								<br><h4>State:</h4>
								<h5>Please input the state in it's 2 letter format</h5>
								<input type="text" size = "2" name="state" id="state" value="" placeholder="State" />
							</div>
								
									<br><h4>Describe your warehouse:</h4>
									<textarea name="description" id="description" placeholder="Description" rows="6"></textarea>
								
								<br><br>

								
								<br>
								<div class="4u 12u$(xsmall)">
									<input type="radio" id="disagree" name="term_check" checked>
									<label for="disagree">I do not agree with the terms and conditions</label>
								</div>
								<div class="4u 12u$(xsmall)">
									<input type="radio" id="agree" name="term_check">
									<label for="agree">I have read and agree with the terms and conditions</label>
								</div>
								<br>
								
								

								<ul class="actions">
									<li><button type="submit">Create listing</button></li>
								</ul>
						
				</div>
				</div>
				</form>
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
