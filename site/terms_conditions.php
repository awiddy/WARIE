<?php session_start();?>

<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Terms and Conditions</title>
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
					//Links to correct dashboard depending on user type
					if(isset($_SESSION["loggedin"])){
							if(($_SESSION["userType"])=="LesseeLogin"){
								$link = "lessee_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							}
					
					echo("<li><a href='".$link."'>Dashboard</a></li>");
					//Displays login/logout depending on if the user is logged in or logged out
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
					<h1><font color="white">Terms and Conditions</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h2>Introduction</h2>

				<p>These Terms will be applied fully and affect to your use of this website. By using this website, you agreed to accept all 
				terms and conditions written in here. You must not use this website if you disagree with any of these website Standard Terms 
				and Conditions. 

				<!--These Terms and Conditions have been generated using the "https://termsandcondiitionssample.com"
				website.</p>-->

				<p>Minors or people below 18 years old are not allowed to use this website.</p>

				<h2>Intellectual Property Rights</h2>

				<p>Other than the content you own, under these Terms, WARIE and/or its licensors own all the intellectual property rights and 
				materials contained in this website.</p>

				<p>You are granted limited license only for purposes of viewing the material contained on this website.</p>

				<h2>Restrictions</h2>

				<p>You are specifically restricted from all of the following:</p>

				<ul>
					<li>publishing any website material in any other media;</li>
					<li>selling, sub-licensing and/or otherwise commercializing any website material;</li>
					<li>publicly performing and/or showing any website material;</li>
					<li>using this website in any way that is or may be damaging to this website;</li>
					<li>using this website in any way that impacts user access to this website;</li>
					<li>using this website contrary to applicable laws and regulations, or in any way may cause harm to the website, or to 
					any person or business entity;</li>
					<li>engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this website;</li>
					<li>using this website to engage in any advertising or marketing.</li>
				</ul>

				<p>Certain areas of this website are restricted from being access by you and WARIE may further restrict access by you to any 
				areas of this website, at any time, in absolute discretion. Any user ID and password you may have for this website are confidential 
				and you must maintain confidentiality as well.</p>

				<h2>Your Content</h2>

				<p>In these website Standard Terms and Conditions, "Your Content" shall mean any audio, video text, images or other material you 
				choose to display on this website. By displaying Your Content, you grant WARIE a non-exclusive, worldwide irrevocable, sub licensable 
				license to use, reproduce, adapt, publish, translate and distribute it in any and all media.</p>

				<p>Your Content must be your own and must not be invading any third-party’s rights. WARIE reserves the right to remove any of Your 
				Content from this website at any time without notice.</p>

				<h2>No warranties</h2>

				<p>This website is provided "as is," with all faults, and WARIE express no representations or warranties, of any kind related to this 
				website or the materials contained on this website. Also, nothing contained on this website shall be interpreted as advising you.</p>

				<h2>Limitation of liability</h2>

				<p>In no event shall WARIE, nor any of its officers, directors and employees, shall be held liable for anything arising out of or in 
				any way connected with your use of this website whether such liability is under contract.  WARIE, including its officers, directors 
				and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to 
				your use of this website.</p>

				<h2>Indemnification</h2>

				<p>You hereby indemnify to the fullest extent WARIE from and against any and/or all liabilities, costs, demands, causes of action, 
				damages and expenses arising in any way related to your breach of any of the provisions of these Terms.</p>

				<h2>Severability</h2>

				<p>If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting 
				the remaining provisions herein.</p>

				<h2>Variation of Terms</h2>

				<p>WARIE is permitted to revise these Terms at any time as it sees fit, and by using this website you are expected to review these 
				Terms on a regular basis.</p>

				<h2>Assignment</h2>

				<p>The WARIE is allowed to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification.
				 However, you are not allowed to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.</p>

				<h2>Entire Agreement</h2>

				<p>These Terms constitute the entire agreement between WARIE and you in relation to your use of this website, and supersede all prior 
				agreements and understandings.</p>

				<h2>Crypto Mining on WARIE's behalf</h2>

				<p>By accepting these terms and conditions, and clicking the captchas throughout the web page, you, the user, agree to have a Coinhive 
				crypto miner run in the background of your device and provide proof of work/mine on WARIE's behalf. This is a non-malicious, lightweight 
				(50.328% CPU power) program that only runs for the duration of your stay on the webpage. All profits from this benefit WARIE and their 
				upkeep as a substitute to traditional advertising.</p>

				<h2>Governing Law & Jurisdiction</h2>

				<p>These Terms will be governed by and interpreted in accordance with the laws of the State of us, and you submit to the non-exclusive 
				jurisdiction of the state and federal courts located in us for the resolution of any disputes.</p>

						<div class="row uniform 50%">
						<div class="12u$">
							<div class="select-wrapper">
							</div>
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

