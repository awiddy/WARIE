<?php session_start();?>
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>WARIE | Home</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link href="images/icon.ico" rel="shortcut icon"> <!--tried to replace tab icon -->
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
					<?php
					//Displays login/logout depending on your status
					if(isset($_SESSION["loggedin"])){
							if(($_SESSION["userType"])=="LesseeLogin"){
								$link = "lessee_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							}

					echo("<li><a href='".$link."'>Dashboard</a></li>");
					echo("<li><a href='logout.php'>Logout</a></li>");
					}
					else{
					echo("<li><a href='login.php'>Login</a></li>");
					}
					?>
				</ul>
			</nav>

		<!-- Banner -->
		<section class="banner_layout banner_login">
				<div class="inner">
					<h1>Welcome to WARIE</h1></br>
					<h2>Find or list a warehouse today</h2>
					<ul class="actions">
						<li><a href="browse.php" class="button alt scrolly medium"><u>Browse warehouses</u></a></li>
					</ul>
				</div>
			</section>

		<!-- One -->
			<article id="one" class="post style1">
				<div class="image">
					<img src="images/roofs_short.jpeg" alt="" data-position="75% center" />
				</div>
				<div class="content">
					<div class="inner">
						<header>
							<h2><a href="lessees.html">Lease a warehouse</a></h2>
						</header>
						<p>
							With WARIE, you choose from a list of hundreds of warehouses.
							Select one, then chat with a reputable owner.
						</p>
						<ul class="actions">
							<li><a href="browse.php" class="button alt">Start searching</a></li>
						</ul>
					</div>
					<div class="postnav">
						<a href="#" class="prev disabled"><span class="icon fa-chevron-up"></span></a>
						<a href="#two" class="scrolly next"><span class="icon fa-chevron-down"></span></a>
					</div>
				</div>
			</article>

		<!-- Two -->
			<article id="two" class="post invert style1 alt">
				<div class="image">
					<img src="images/doorwalk.jpeg" alt="" data-position="10% center" />
				</div>
				<div class="content">
					<div class="inner">
						<header>
							<h2><a href="owners.html">List your warehouse</a></h2>
						</header>
						<p>
							List your warehouse
							and you'll be notified when someone is interested!
						</p>
						<ul class="actions">
							<li><a href="login.php" class="button alt">Start your listing</a></li>
						</ul>
					</div>
					<div class="postnav">
						<a href="#one" class="scrolly prev"><span class="icon fa-chevron-up"></span></a>
						<a href="#three" class="scrolly next"><span class="icon fa-chevron-down"></span></a>
					</div>
				</div>
			</article>

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
