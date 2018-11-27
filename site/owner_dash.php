<!DOCTYPE HTML>
<!--
	Binary by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Owners</title>
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
				<li><a href="login.php">Login</a></li>
			</ul>
		</nav>

	<!--Banner-->
		<section class="banner_layout banner_lessees">
			<div class="inner">
			</br></br></br>
				<h1><font color="white">Owner Dashboard</font></h1></br>
				<h3>Toggle your view below</h3>
			</div>
		</section>

	<!-- Main -->
		<section id="main">
			<div class="inner">
                <section>
                    <div class="row">
                        <!-- begin row-->
                        <div class="3u 12u$(xsmall)">

                            <ul class="actions">
                                <li><a href="#" class="button special">Prospective Contracts</a></li>
                                <br>
                                <br>
                                <li><a href="#" class="button special">Existing Contracts &emsp;&ensp; </a></li>
                                <br>
                                <br>
                                <li><a href="#" class="button special">Warehouse Activity&ensp;&ensp;</a></li>
                                <br>
                                <br>
                                <li><a href="#" class="button special">Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</a></li>
                                <br>
                                <br>
                                <li><a href="#" class="button special">Contracts &emsp;&emsp;&emsp; &emsp; &emsp;</a></li>
                                <br>
                                <br>
                            </ul>

                        </div>

                        <div class="9u$ 12u$(xsmall)">
                            <!-- new column-->
                            <div class="slimmer">
                                <h4>Prospective contracts</h4>
                                <ol>
                                    <li>
                                        Dolor pulvinar etiam magna etiam.
                                        Etiam vel felis at lorem sed viverra.
                                        Felis enim feugiat dolore viverra.
                                        Dolor pulvinar etiam magna etiam.
                                    </li>
                                    <li>Etiam vel felis at lorem sed viverra.</li>
                                    <li>Felis enim feugiat dolore viverra.</li>
                                </ol>
                            </div>
                        </div>
                    </div> <!-- end of row-->

                    <hr /> <!-- separating line-->
                    <h2>Accept or decline contracts</h2>
                    <p>
                        Use php/js to create a list of links or buttons by iterating through the exhasutive list
                        of prospective contracts for the owner to approve
                    </p>
                    <!-- table -->
                <?php
                function prospective_conts(){
                    /*$Owner_ID= $_POST["Owner_ID"];*/
                    $Owner_ID="201"; //hardcoded ID
                    $servername = "mydb.ics.purdue.edu";
                    $username = "g1090423";
                    $password = "marioboys";
                    $dbname = "g1090423";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                    }

                    /*$sql_1 = "SELECT *";
                    $sql_2 = "FROM Warehouse WHERE Owner_ID=$Owner_ID";*/
                    $sql_1 = "SELECT *";
                    $sql_2 = "FROM Contract WHERE Owner_ID=$Owner_ID AND Approval=0";
                    $sql = $sql_1.$sql_2;

                    /*$sql_1 = "SELECT W.ID, StorageCapacity,BasePrice,Zipcode,City,State,Owner_ID,R.Rating as Owner_Rating ";
                    $sql_2 = "FROM (Warehouse W INNER JOIN(SELECT MIN(Open_Space),WarehouseID FROM Availability WHERE WeekFromDate BETWEEN ".$start_date_week." AND ".$end_date_week." GROUP BY WarehouseID) A ";
                    $sql_3 = "ON W.ID = A.WarehouseID) INNER JOIN (SELECT Rating,Owner.ID FROM Owner) R ON W.Owner_ID=R.ID WHERE StorageType = ".$storage_type." AND City = '".$city."' ORDER BY ";
                    $sql = $sql_1.$sql_2.$sql_3; */

                    $result = $conn->query($sql);
                    echo "
                    <style>
                        td, tr:hover {
                            opacity: 0.6;
                        }

                        th:hover {
                            opacity: 1.0;
                        }
                    </style>";
                    echo"<table width=950px>
                        ";
                        echo"
                        <th>Warehouse ID</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Rented Space</th>
                        <th>Lessee ID</th>
                        <th>Signing Date</th>";

                        if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                        
                        echo"
                        <tr><td><a href='request.php'>".$row['Warehouse_ID']. "</a></td><td>".$row["Start Date"]."</td><td>".round($row["End Date"],2)."</td><td>".$row["Rented_Space"]."</td><td>".$row["Lessee_ID"]."</td><td>".$row["Signing_date"]."</td><td>";
                        /*echo"
                        <tr><td><a href='request.php'>".$row['ID']. "</a></td><td>".$row["StorageCapacity"]."</td><td>".round($row["BasePrice"],2)."</td><td>".$row["Zipcode"]."</td><td>".$row["City"]."</td><td>".$row["State"]."</td><td>";*/
                        //echo "ID: " . $row["ID"]. "Capacity: ".$row["Capacity"]. "Price: ".$row["Price"]. "Zipcode: ".$row["Zipcode"] ."City: ".$row["City"]. "State: ".$row["State"]. "Owner ID: ".$row["Owner_ID"]. "Owner Rating: ".$row["Owner_Rating"];

                        echo"</td>";
                        }
                        } else {
                        echo "0 results";
                        }
                        $conn->close();
                        echo"
                    </table>";
                    }

                    function existing()
                    {
                        echo "I Exist!\n";
                    }
                    
                    prospective_conts();
                    existing();

                    ?>
                    </font></p>

                </section>
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

	</body>
</html>
