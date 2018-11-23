<?php
session_start()
?>
<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Register</title>
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
				<li><a href="login.html">Login</a></li>
			</ul>
		</nav>

	<!--Banner-->
	<section class="banner_layout banner_login">
			<div class="inner">
			</br></br></br>
				<h1><font color="white">Login with WARIE</font></h1></br>
			</div>
	</section>
	
	<!-- PHP code -->
	<?php
	   define('DB_SERVER', 'mydb.ics.purdue.edu');
	   define('DB_USERNAME', 'g1090423');
	   define('DB_PASSWORD', 'marioboys');
	   define('DB_DATABASE', 'g1090423');
	   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	?>
	<?php 
	$_SESSION["err"] = "";
	   if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Submit"])) {
			
		  // username and password sent from form 
		  $sub = $_POST["Submit"];
		  $myemail = mysqli_real_escape_string($db,$_POST["email"]);
		  $mypassword = mysqli_real_escape_string($db,$_POST["password"]); 

		  //if (isset($sub["OwnerLogin"])) {
		  if ($sub == "OwnerLogin") {
		  $sql = "SELECT ID,FirstName FROM Owner O WHERE O.Email = $myemail and O.Password = $mypassword";
		  //$result = mysqli_query($db,$sql);
		  $result = mysqli_query($db,"SELECT ID,FirstName FROM Owner O WHERE O.Email = '".$myemail."' and O.Password = '".$mypassword."'");
		  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		  $active = $row['active'];
		  $count = mysqli_num_rows($result);
		  $_SESSION["ID"] = $row[0][0];
		  }
		  // If result matched $myusername and $mypassword, table row must be 1 row
			//elseif (isset($sub["LesseeLogin"])){
			elseif ($sub == "LesseeLogin"){
			$sql = "SELECT ID FROM Lessee L WHERE L.Email = '".$myemail."' and L.Password = '".$mypassword."'";
			$result = mysqli_query($db,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$active = $row['active'];
			$count = mysqli_num_rows($result);
			}
		
			if($count == 1) {
			$_SESSION["login"] = "1";
			$_SESSION["email"] = $myemail;
			//session_register("$myemail");
			//if(isset($sub["OwnerLogin"])){
			if($sub == "OwnerLogin"){
				echo '<script>window.location.assign("http://web.ics.purdue.edu/~g1090423/owners.html");</script>';
				exit();
			}
			else {
				echo '<script>window.location.assign("http://web.ics.purdue.edu/~g1090423/lessees.html");</script>';
				exit();
			}
		}elseif(!empty($_POST["email"]) && !empty($_POST["password"])){	
			 $_SESSION["err"] = "* Your Email or Password is invalid";
		  }
		}
	mysqli_close($db);
	?>	
<!-- Forms and stuff -->
	<section id="main">
		<div class="slimmer">
		<h3>View or update account information, listings, or contracts</h3>
		<br/><br/>
			<h4>Credentials</h4>
			<h5><span style="color:red"><?php echo $_SESSION["err"];?></span></h5>
		   <form method = "post">
			<div class="6u$ 12u$(small)">
			  <label>Email  :</label><input type = "email" name = "email" class = "box" value = "awilson@gmail.com"/>
			  <label>Password  :</label><input type = "password" name = "password" class = "box" value = "6n1yGl%!o2"/><br/>
			</div>
			  <input type = "submit" name = "Submit" value ="LesseeLogin" class="button special"/>&emsp;&emsp;<br /><br />
			  <input type = "submit" name = "Submit" value = "OwnerLogin" class="button special"/>&emsp;&emsp;<br />
		   </form>
		   
		</div>
	</section>	
	
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


		<!-- Main 
			<section id="main">
				<div class="slimmer">
					<h3>View or update account information, listings, or contracts</h3>
					<!----<form method="post" action="#">
						<div class="row uniform 50%">
							<div class="12u$"><!--
								<div class="select-wrapper">
									<h4>Select an action:</h4>
									<select name="category" id="category">
										<option value="">- User -</option>
										<option value="1">New Lesee</option>
										<option value="2">New Owner</option>
										<option value="3">Lesee Login</option>
										<option value="3">Owner Login</option>
									</select> 
								</div>
								
								</br>
								<h4>Credentials</h4>
								<div class="6u$ 12u$(small)">
									<input type="email" name="email" id="email" value="" placeholder="Email" />
								</div>
								</br>
								<div class="6u$ 12u$(small)">
									<input type="text" name="password" id="password" value="" placeholder="Password" />
								</div>
							</div>
						</div>
					</form> 
					<a href="login.html" class="button special">Lessee Login</a>
					&emsp;&emsp;
					<a href="login.html" class="button special">Owner Login</a>
				</div>
			</br></br></br>
			</section>-->

			

	</body>
</html>
