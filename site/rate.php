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
					<li><a href= "logout.php">Logout</a></li>
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
					<!-- Forms for all factors of the rating -->
					<h4>The user being rated is</h4>
						<div class="6u 12u$(xsmall)">
								User ID: <input type="number" name="id" id="id" value="<?php echo("".$id.""); ?>"  />
						</div>
						
					<br><br><h4>Please rate your the level of professionalism from the other user in this contract: </h4>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="prof_rate1" name="prof_rating" value="1">
						<label for="prof_rate1">1</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="prof_rate2" name="prof_rating" value="2">
						<label for="prof_rate2">2</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="prof_rate3" name="prof_rating" value="3">
						<label for="prof_rate3">3</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="prof_rate4" name="prof_rating" value="4">
						<label for="prof_rate4">4</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="prof_rate5" name="prof_rating" value="5" checked required>
						<label for="prof_rate5">5</label>
					</div>
					
					<br><br><h4>Please rate your experience with the communication between yourself and the other user in this contract: </h4>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="com_rate1" name="com_rating" value="1">
						<label for="com_rate1">1</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="com_rate2" name="com_rating" value="2">
						<label for="com_rate2">2</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="com_rate3" name="com_rating" value="3">
						<label for="com_rate3">3</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="com_rate4" name="com_rating" value="4">
						<label for="com_rate4">4</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="com_rate5" name="com_rating" value="5" checked required>
						<label for="com_rate5">5</label>
					</div>
					
						<br><br><h4>If you are a Lessee -- Please rate the cleanliness and general condition of the space at the beginning of the contract:<br>
									If you are an Owner -- Please rate the cleanliness and general condition of the space at the end of the contract: </h4>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="clean_rate1" name="clean_rating" value="1">
						<label for="clean_rate1">1</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="clean_rate2" name="clean_rating" value="2">
						<label for="clean_rate2">2</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="clean_rate3" name="clean_rating" value="3">
						<label for="clean_rate3">3</label>
						</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="clean_rate4" name="clean_rating" value="4">
						<label for="clean_rate4">4</label>
					</div>
					<div class="4u 12u$(xsmall)">
						<input type="radio" id="clean_rate5" name="clean_rating" value="5" checked required>
						<label for="clean_rate5">5</label>
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
