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
		<title>Browse Warehouses</title>
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
					//displays login/logout depending on status
					if(isset($_SESSION["loggedin"])){
							if(($_SESSION["userType"])=="LesseeLogin"){
								$link = "lessee_dash.php";
							}else if(($_SESSION["userType"])=="OwnerLogin"){
								$link = "owner_dash.php";
							} else if (($_SESSION["uesrType"])=="AdminLogin"){
								$link = 'admin_dash.php';
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
					<h1><font color="white">Browse Warehouses</font></h1></br>
				</div>
			</section>

		<!-- Main -->
			<section id="main">
				<div class="slimmer">
					<h3>Select your criteria to narrow the results</h3>
					<form name="allInputs" method="post" action="http://web.ics.purdue.edu/~g1090423/results.php">
						<div class="row uniform 50%">
							<div class="12u$">
								<div class="select-wrapper">
									<h4>Warehouse Location:</h4>
									<select name="city" required>
										<option value="">- Location -</option>
										<option value="San Diego">San Diego, CA</option>
										<option value="Los Angeles">Los Angeles, CA</option>
										<option value="San Francisco">San Francisco, CA</option>
										<option value="San Jose">San Jose, CA</option>
										<option value="Austin">Austin, TX</option>
										<option value="Dallas">Dallas, TX</option>
										<option value="Houston">Houston, TX</option>
										<option value="Fort Worth">Fort Worth, TX</option>
										<option value="San Antonio">San Antonio, TX</option>
										<option value="Jacksonville">Jacksonville, FL</option>
										<option value="Chicago">Chicago, IL</option>
										<option value="New York">New York, NY</option>
										<option value="Philadelphia">Philadelphia, PA</option>
										<option value="Phoenix">Phoenix, AZ</option>
										<option value="Columbus">Columbus, OH</option>
									</select>
								</div>
							</div>
							</br></br>
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
									<br><br><h4>How much space will you  be needing?</h4></br></br>
									<div class="12u$">
										<input type="number" min="0" name="storage_needed" id="storage_needed" value="" placeholder="Space Needed" required />
									</div>
									<br><br><h4>When do you need your contract to start? (Must be at least one week from today)</h4></br></br>
									<div class="12u$">
										<input type="date" name="start_date" id="start_date" onblur="endDate()" value="" min = "0" max="0" placeholder="Start Date" required />
									
									<script>
									var d = new Date().getTime() + 86400000*7; //Gets seven days from today
									var seven_days = new Date(d).toISOString().split("T")[0]; //Convert to string
									start_date.min = seven_days; //Set min
									</script>
									
									</div>
									<br><br><h4>When will your contract be ending? (Minimum length is one week)</h4></br></br>
									<div class="12u$">
										<input type="date" name="end_date" id="end_date" value="" min="0" max="0" placeholder="End Date" required />
									</div>
									<script>

									var d = new Date().getTime() + 86400000*14; 
									var seven_days = new Date(d).toISOString().split("T")[0]; //Same code but to initially make it 14 days from today
									end_date.min = seven_days; 
									
									function endDate(){ //gets called when you click away from start date text box
										
										var d1 = new Date(start_date.value).getTime() + 86400000*7; //Add 7 days to the value of the start date
										
										end_date.min = new Date(d1).toISOString().split("T")[0]; //set the end date minimum to above value
									}

									</script>
								</br></br>
									<div class="12u$">
									<div class="select-wrapper">
										<h4>Sort results by:</h4>
										<select name="sort_val" id="sort_val" required>
											<option value="">- Sort -</option>
											<option value="1">Price ($/sq ft/month)</option>
											<option value="2">Rating</option>

										</select>
									</div>
								</div>

								</br></br>

								<ul class="actions">
									<li><input type="submit" value="Search" /></li>
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
