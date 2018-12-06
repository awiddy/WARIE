<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
<div>
    <p>
        Test Admin Dashboard Full
    </p>

    <?php
        
        dashboard();
        echo "<div id=\"Space_div\"></div>";
        echo"<div id=\"line_chart\" style=\"height: 500px;\">";
        
        function dashboard() {
             ////////Get number of current users///////////////
                        //Connect to database
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

						$user_sql = "Select count(Lessee.ID) as Lessees from Lessee";
                        $result = mysqli_query($conn, $user_sql);
                        $user = array();
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $user[] = $row;
                            }
                        }
                        $user_table = array();
                        foreach ($user as $user1){
                            $user_table[] = array("Lessees", (int)$user1['Lessees']); 
                        }

                        $user_sql = "Select count(Owner.ID) as Owners from Owner";
                        $result = mysqli_query($conn, $user_sql);
                        $user = array();
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $user[] = $row;
                            }
                        }
                        foreach ($user as $user1){
                            $user_table[] = array("Owners", (int)$user1['Owners']); 
                        }
                        print_r($user_table);
                        
                        $user_table = json_encode($user_table);
                        
                        $conn->close(); 


                    ////////Pending vs Accepted Contracts///////////////
                        //Connect to database
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

						$approve_sql = "Select count(Approval) as Approved from Contract";
                        $result = mysqli_query($conn, $user_sql);
                        $user = array();
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $user[] = $row;
                            }
                        }
                        $user_table = array();
                        foreach ($user as $user1){
                            $user_table[] = array("Lessees", (int)$user1['Lessees']); 
                        }

                        $user_sql = "Select count(Owner.ID) as Owners from Owner";
                        $result = mysqli_query($conn, $user_sql);
                        $user = array();
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $user[] = $row;
                            }
                        }
                        foreach ($user as $user1){
                            $user_table[] = array("Owners", (int)$user1['Owners']); 
                        }
                        print_r($user_table);
                        
                        $user_table = json_encode($user_table);
                        
                        $conn->close(); 
                    ////////Bring In Revenue Data///////////
                        /*Open Data base connection*/ 
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
                        //https://www.webslesson.info/2017/08/how-to-make-google-line-chart-by-using-php-json-data.html
                        //^^Used and modified to format the dates properly for the timeline 
                        $contracts_sql = "SELECT A.WeekFromDate as Week, SUM((W.StorageCapacity - A.Open_Space)*W.BasePrice*7*0.02/365) AS Profit
                        FROM Availability A, Warehouse W
                        WHERE W.ID = A.WarehouseID
                        GROUP BY A.WeekFromDate
                        ";
                        
                        $resultContracts = mysqli_query($conn, $contracts_sql);
                        $data = array();
                        if(mysqli_num_rows($resultContracts)>0){
                            while($row = mysqli_fetch_assoc($resultContracts)){
                                $data[] = $row;
                            }
                        }
                       

                        $revenue_table = array();
                        foreach ($data as $data1){
                            $revenue_table[] = array((float)$data1['Week'], (float)$data1['Profit']);
                        }

                        $revenue_table = json_encode($revenue_table);
                        
                        $conn->close();
                            
            




            ////Google Chart Creation/////
            echo"<head>";
            echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
            echo'<script type="text/javascript">
            google.charts.load("visualization", "1", {packages:["corechart", "timeline"]});
            google.charts.setOnLoadCallback(init);

            function init () {

                drawUser();
                drawRevline();
            }

            

            
            function drawUser() {

                var dataSpace = new google.visualization.DataTable();
                        dataSpace.addColumn(\'string\', \'User\');
                        dataSpace.addColumn(\'number\',\'Number\');
                        dataSpace.addRows('.$user_table.');
                var options = {
                    title: \'Available Space\',
                    is3D: \'true\',
                    width: 550,
                    height: 600
                    };
                
                var chartSpace = new google.visualization.PieChart(document.getElementById(\'Space_div\'));
                chartSpace.draw(dataSpace, options);
                }

            
            function drawRevline(){
                
                    
                var dataRev = new google.visualization.DataTable();
                        dataRev.addColumn(\'number\', \'Week\');
                        dataRev.addColumn(\'number\',\'Revenue\');
                        dataRev.addRows('.$revenue_table.');
                        var options = {
                            title:\'Revenue from Rent per Week after Data Generation\',
                            legend:{position:\'bottom\'},
                            chartArea:{width:\'95%\', height:\'100%\'}
                            };

                        var chart = new google.visualization.LineChart(document.getElementById(\'line_chart\'));          
                        chart.draw(dataRev, options);
            
            }
        
            </script>';
            echo"</head>";
        }



                        
        



    ?>


</body>
</html>