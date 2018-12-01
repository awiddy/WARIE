<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname = "";
$username_err = $password_err = $confirm_password_err = $lastname_err = $firstname = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
   if(empty($_POST["firstname"])){
        $firstname_err = "*Please enter your first name.";
   } else {
	   $firstname = trim($_POST["firstname"]);
   }
   if(empty($_POST["lastname"])){
        $lastname_err = "*Please enter your last name.";
   } else {
	   $lastname = trim($_POST["lastname"]);
   }
   // Validate username
    if(empty($_POST["username"])){
        $username_err = "Please enter an Email.";
    } else{
		if($_POST["usertype"] == "Owner"){
        // Prepare a select statement
        $sql = "SELECT ID FROM Owner WHERE Email = ?";
        } else if($_POST["usertype"] == "Lessee"){
		$sql = "SELECT ID FROM Lessee WHERE Email = ?";
		}
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "*This Email is already has an account.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
  
    // Validate password
    if(empty($_POST["password"])){
        $password_err = "*Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "*Password must have atleast 6 characters.";
    } else{
        if($_POST["usertype"] == "Owner"){
        // Prepare a select statement
        $sql = "SELECT ID FROM Owner WHERE Password = ?";
        } else if($_POST["usertype"] == "Lessee"){
		$sql = "SELECT ID FROM Lessee WHERE Password = ?";
		}
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_password);
            
            // Set parameters
            $param_username = trim($_POST["password"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $password_err = "*This password is already taken.";
                } else{
                    $password = trim($_POST["password"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
 
    // Validate confirm password
    if(empty($_POST["confirm_password"])){
        $confirm_password_err = "*Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "*Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ".$_POST["usertype"]." (FirstName,LastName,Email, password) VALUES (?, ?, ?, ?)";
 
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $param_username, $param_password);
            
            // Set parameters
			$firstname = $firstname;
			$lastname = $lastname;
            $param_username = $username;
            $param_password = $password; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
				exit;
            } else{
                echo "Something went wrong. Please try again later.";
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
					<li><a href="login.html">Login</a></li>
				</ul>
			</nav>

		<!--Banner-->
		<section class="banner_layout banner_login">
				<div class="inner">
				</br></br></br>
					<h1><font color="white">Register with WARIE</font></h1></br>
				</div>
		</section>
	<section id="main">
		<div class="slimmer">
			<h3>Sign Up</h3>
			<h4>Please fill this form to create an account.</h4>
			<div class="6u$ 12u$(small)">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
					<label>First Name:<input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>"></label>
					<span style="color:red"><?php echo $firstname_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
					
					<label>Last Name:<input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>"></label>
					<span style="color:red"><?php echo $lastname_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Email:<input type="email" name="username" class="form-control" value="<?php echo $username; ?>"></label>
					<span style="color:red"><?php echo $username_err; ?></span>
				</div>    
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					
					<label>Password:<input type="password" name="password" class="form-control" value="<?php echo $password; ?>"></label>
					<span style="color:red"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					
					<label>Confirm Password:<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>"></label>
					<span style="color:red"><?php echo $confirm_password_err; ?></span>
				</div>
				<fieldset> 
					  <br><label>I am creating an account to:</label>
					  <input type = "radio" name = "usertype" id = "Owner" value = "Owner"/>
					  <label for = "Owner">Rent out my warehouse</label>
					  <input type = "radio" name = "usertype" id = "Lessee" value = "Lessee" checked = "checked"/>
					  <label for = "Lessee">Store my stuff</label>       
				</fieldset>
				</div>
				<div class="form-group">
					<input type="submit" class="button special" value="Submit">
					<input type="reset" class="button special" value="Reset">
				</div>
				<p>Already have an account? <a href="login.php">Login here</a>.</p>
			</form>
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
				<a href ="terms_conditions.html">Terms and Conditions</a>	
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