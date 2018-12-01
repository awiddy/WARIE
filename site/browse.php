
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

		<script>
		//validate isn't working for some reason
		function validate(){

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd = '0'+dd
					}

		if(mm<10) {
			mm = '0'+mm
			}

		today = mm + '/' + dd + '/' + yyyy;
		document.write(today);

		var start_date = new Date(document.forms["allInputs"]["start_date"].value);
		var end_date = new Date(document.forms["allInputs"]["end_date"].value);
		var err1 = (start_date > end_date);
		var err2 = (start_date == end_date);
		var err3 = (start_date <= (current_date+6));
		var err4 = (end_date<=(start_date+13));
		var err5 = (start_date<current_date);

		if(err1){
			alert("Start date cannot be after end date");
			return false;
		}else if (err2){
			alert("Start date and end date must be at least 1 week (7 days) apart");
			return false;
		}else if (err3 || err5){
			alert("Start date must be at least 1 week (7 days) after today");
			return false;
		}else if (err4){
			alert("End date must be at least 1 week (7 days) after start");
			return false;
		}else{ return true;}
		}

		</script>
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
					<li><a href="login.php">Login</a></li>
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
					<form name="allInputs" method="post" action="results.php">
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
										<option value="Jacksonville">Jacksonville, TX</option>
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
										<input type="number" name="storage_needed" id="storage_needed" value="" min = "0" placeholder="Space Needed" required />
									</div>
									<br><br><h4>When do you need your contract to start?</h4></br></br>

									<div class="12u$">
										<input type="date" name="start_date" id="start_date" value="" min="start_min" max = "start_max" placeholder="Start Date"  required />
																		<script>
									/*
									//get all new dates and set to today
									var start_min = new Date().toISOString().split('T')[0];
									var start_max = new Date().toISOString().split('T')[0];
									var end_min = new Date().toISOString().split('T')[0];
									var end_max = new Date().toISOString().split('T')[0];
									//set actual min/max values of all dates based on today
									start_min.setDate(start_min.getDate()+7);
									start_max.setDate(start_max.getDate()+103);
									end_min.setDate(end_min.getDate()+14);
									end_max.setDate(end_max.getDate()+ 364)
									document.getElementById("start_min").value=start_min;
									document.getElementById("start_max").value=start_max;
									document.getElementById("end_min").value=end_min;
									document.getElementById("end_max").value=end_max;*/

									var today=new Date()toISOString().split('T')[0];
									document.getElementsByName("start_date")[0].setAttribute('min',today+7);//min start date is 1 week out from today
									document.getElementsByName("start_date")[0].setAttribute('max',today+103); //max start date is 24 weeks (96 days) out from 1 week (7 days) from today
									document.getElementsByName("end_date")[0].setAttribute('min',today+14);//min contract length is 1 week (7 days) after the start date (7 days away)
									document.getElementsByName("end_date")[0].setAttribute('max',today+364);//max end date is 52 weeks (364 days) from today


									</script>
									</div>
									<br><br><h4>When will your contract be ending?</h4></br></br>
									<div class="12u$">
										<input type="date" name="end_date" id="end_date" value="" min = "end_min" max = "end_max" placeholder="End Date" required />
									</div>

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
				 <ul class="icons">
					<li><a href="https://twitter.com/WARIE49834226" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="https://www.facebook.com/WARIE-639800186472059/?modal=admin_todo_tour" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="https://www.instagram.com/warie_business/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
				</ul>
				<a href ="terms_conditions.html">Terms and Conditions</a><br><br>

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