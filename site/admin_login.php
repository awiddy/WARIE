<?php
// Initialize the session
session_start();

//Login/Logout/Registration page reference: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php


// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if($_SESSION["userType"]=="Admin"){
	  header("location: admin_dash.php");
	  exit;
  }
}

// Include config file to startup database
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 $sub = $_POST["Submit"];

    // Check if username is empty
    if(!isset($_POST["username"])){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty($_POST["password"])){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
		// Prepare a select statement
		if($sub == "Admin"){
        $sql = "SELECT ID, Email, Password FROM Admin WHERE Email = ?";
		} 
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $sqlpassword);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password == $sqlpassword){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
							$_SESSION["userType"] = $sub;

                            // Redirect user to welcome page
							if($sub == "Admin"){
								header("location: admin_dash.php");
							}  
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
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
		<title>Admin Login</title>
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
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Login with WARIE</font></h1></br>
				</div>
		</section>
	<!-- Forms and stuff -->
		<section id="main">
			<div class="slimmer">
				<h4> Admin Credentials</h4>
				<div class="6u$ 12u$(small)">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
						<label>Email  :<input type = "text" name = "username" class = "box" value="<?php echo $username; ?>"></label>
						<span style="color:red"><?php echo $username_err; ?></span>
					</div>
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
						<label>Password  :<input type = "password" name = "password" class = "box"></label>
						<span style="color:red"><?php echo $password_err; ?></span>
					</div>
				</div>
				  <input type = "submit" name = "Submit" value ="Admin" class="button special">&emsp;&emsp;<br /><br />
		
			   </form>
			   <br><a href="login.php"> Not an admin? login here</a>
			</div>
		</section>

		<!-- Footer -->
		<footer id="footer">
			<div class="copyright" style="font-weight:500;">
			<ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.php">Terms and Conditions</a>	
				&copy; Untitled. Design: <a href="https://templated.co" style="font-weight:500;">TEMPLATED</a>. Images: <a href="https://unsplash.com" style="font-weight:500;">Unsplash</a>.
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
