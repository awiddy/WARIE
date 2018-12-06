<?php session_start();?>
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>About WARIE</title>
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
					<?php

					//Displays either login or logout depending on your status
					if(isset($_SESSION["loggedin"])){
							if(($_SESSION["userType"])=="LesseeLogin"){
								$link = "lessee_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							}else if (($_SESSION["userType"])=="AdminLogin"){
								$link = "admin_dash.php";
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

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">About WARIE</font></h1></br>
					<h3>Connecting warehouse lessees and owners</h3>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
                <div class="inner">
                    <div class="inner">
                        <h2>Our Mission</h2>
                        <p>
                            We strive to deliver optimized and engineered results to provide the best customer experience possible.
                            Whether you are a small startup looking for space to store your inventory, or a warehouse owner wanting to better utilize your space, we will provide
                            industry leading results tailored to your needs.
                        </p>

                        <h2>How It Works</h2>
                        <p>
                            If you're looking to <u>lease storage space</u>, simply put in your desired features, square footage, and
                            the dates which you would like to rent. Our search algorithm is tailored to show you the best possible selection to choose from.<br>
                        </p>
                        <p>
                            As a <u>warehouse owner</u>, we provide advanced AI and machine learning to give you a recommended price for
                            your warehouse based on other successful listings. Once your warehouse has been posted, you will be able to monitor the usage of your space in the
                            analytics page. As you have more and more contract requests, our optimized scheduling algorithm will give you the best subset of contracts to maximize
                            the potential of your warehouse.
                        </p>
						<p>
							Our business model depends on 2 main revenue streams: a monthly cut of monthly revenue and a service fee on a one time per contract basis.
							In a departure from traditional websites, we have chosen to forgo ads and membership fees. All our owners pay is a cut of their monthly revenue. All our lessees pay is a
							$10 per contract service fee and rent of the warehouse.
						</p>
                        <h2>Contact Us</h2>
                        <p>
                            Have a question about WARIE? Don't hesitate to reach out via email, phone, or any of the social
                            media platforms that we are on.
                        </p>
                        <p>WARIE Headquarters<br>West Lafayette, IN 47907<br>765-1212-4444<br>wariestaff@gmail.com</p>

                        </div>
                    </div>
            </section>

		<!-- Footer -->
			<footer id="footer">
				 <ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.php">Terms and Conditions</a><br>

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
