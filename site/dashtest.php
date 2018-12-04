<!DOCTYPE HTML>
<html>
<body>
    <p>
        Test Google Dashboard
    </p>

    <?php
        echo"<table>
        <tr>";
        revenue();
        echo"</tr>
        <tr>";
        space_filled();
        echo"</tr>
        <tr>";
        timeline2();
        echo"<tr></table>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        function map(){

                /*Open Data base connection*/
            $Owner_ID=$_SESSION["id"]; 
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
        //$location_sql = "Select Warehouse.Zipcode, Warehouse.ID From Warehouse Where Owner_ID = ".$Owner_ID."";
        $location_sql = "Select Warehouse.Zipcode, Warehouse.ID From Warehouse Where Owner_ID = 1";

        //Makes multidimensional array of contracts_sql query result
        $location_result = mysqli_query($conn, $location_sql);
        $location = array();
        if(mysqli_num_rows($location_result)>0){
            while($row = mysqli_fetch_assoc($location_result)){
                $location[] = $row;
            }
        } 
        $location_table = array();
        foreach ($location as $location1){
            $location_table[] = array((string)$location1['Zipcode'], (int)$location1['ID']); 
        }

        $location_table = json_encode($location_table);
        print_r($location_table);
        
            $conn->close();
        

            echo"<head>";
            echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
            echo'<script type="text/javascript">
            google.charts.load("current", {
                "packages":["map"],
                // Note: you will need to get a mapsApiKey for your project.
                // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                "mapsApiKey": "AIzaSyDi799MTv01g9mQ2C2p1km1v7v1bTIjs-Q"
            });
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                    data.addColumn(\'string\', \'zip\');
                    data.addColumn(\'number\', \'Warehouse ID\');
                    data.addRows('.$location_table.');
        
                var map = new google.visualization.Map(document.getElementById(\'map_div\'));
                map.draw(data, {
                showTooltip: true,
                showInfoWindow: true
                });
            }
        
            </script>';
        echo"</head>
        

            <div id=\"map_div\" style=\"width: 100%; height: 40%\"></div>";

        }
        
        
/////////////////////////////////////////////////////////////////////////////////////        
        function revenue(){
            /*Open Data base connection*/
            $Owner_ID=$_SESSION["id"]; 
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

        
            //$contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = ".$Owner_ID." AND Contract.Approval=1";
            $contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = 1 AND Contract.Approval=1";
            
            $result = mysqli_query($conn, $contracts_sql);
            $data = array();
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $data[] = $row;
                }
            }
        
            
            $revenue_table = array();
            foreach ($data as $data1){
                $diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
                $diffDays = floor($diff/(3600*24));
                $revenue = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
                $revenue_table[] = array($data1['ID'],(int)$revenue); 
            }
            $revenue_table = json_encode($revenue_table);
                //




            $conn->close();   
        
        


            echo"<head>";
                echo'<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
                echo'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>';
                echo'<script type="text/javascript">

                google.load(\'visualization\', \'1\', {\'packages\':[\'corechart\']});

                google.setOnLoadCallback(drawChart);

                function drawChart() {

                var data = new google.visualization.DataTable();
                        data.addColumn(\'string\', \'ID\');
                        data.addColumn(\'number\',\'Revenue\');
                        data.addRows('.$revenue_table.');
                var options = {
                    title: \'Percentage Revenue by Contract\',
                    is3D: \'true\',
                    width: 800,
                    height: 600
                    };
                
                var chart = new google.visualization.PieChart(document.getElementById(\'chart_div\'));
                chart.draw(data, options);
                }
                </script>';
            echo"</head>
            
                <div id=\"chart_div\"></div>";
        }
        
        ////////////////////////////////////////////////////////////////////////////////////////////////
        
        
        function space_filled(){

            /*Open Data base connection*/
            $Owner_ID=$_SESSION["id"]; 
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
            //Need to fix query below to be dynamic with page content before uploading
            //$space_sql = "Select Warehouse.ID, sum(Warehouse.StorageCapacity), sum(Contract.Rented_Space) From Warehouse INNER JOIN Contract ON Warehouse.ID = Contract.Warehouse_ID Where Warehouse.Owner_ID=".$Owner_ID." AND Approval = 1";
            $space_sql = "Select Warehouse.ID, (sum(Warehouse.StorageCapacity)- sum(Contract.Rented_Space)) as Open, sum(Contract.Rented_Space) as Rented_Space From Warehouse INNER JOIN Contract ON Warehouse.ID = Contract.Warehouse_ID Where Warehouse.Owner_ID=1 AND Approval = 1";
            
            $result = mysqli_query($conn, $space_sql);
            $space = array();
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $space[] = $row;
                }
            }
            $space_table = array();
            $open_total = 0;
            foreach ($space as $space1){
                $open_total = $open_total + $space1['Open'];
                $space_table[] =array((string)$space1['ID'], (int)$space1['Rented_Space']); 
            }
            
            $open_total = array("Open", (int)$open_total);
            $space_table[] = $open_total;
            
            $space_table = json_encode($space_table);
            




            $conn->close(); 
            echo"<head>";
                echo'<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
                echo'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>';
                echo'<script type="text/javascript">

                google.load(\'visualization\', \'1\', {\'packages\':[\'corechart\']});

                google.setOnLoadCallback(drawChart);

                function drawChart() {

                var data = new google.visualization.DataTable();
                        data.addColumn(\'string\', \'ID\');
                        data.addColumn(\'number\',\'Space\');
                        data.addRows('.$space_table.');
                var options = {
                    title: \'Percentage Revenue by Contract\',
                    is3D: \'true\',
                    width: 800,
                    height: 600
                    };
                
                var chart = new google.visualization.PieChart(document.getElementById(\'chart1_div\'));
                chart.draw(data, options);
                }
                </script>';
            echo"</head>
            
                <div id=\"chart1_div\"></div>";

        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        function timeline(){
            /*Open Data base connection*/
            $Owner_ID=$_SESSION["id"]; 
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
            //Add dynamic sql
            $time_sql = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Owner_ID = 1 and Approval=1";
            
            $result = mysqli_query($conn, $time_sql);
            $time = array();
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $time[] = $row;
                }
            }
            $time_table = array();
            foreach ($time as $time1){
            
                // $date1 = new DateTime($time1['Start Date']);
                // $date2 = "Date(".date_format($date1, 'Y').", ".((int) date_format($date1, 'm') - 1).", ".date_format($date1, 'd').")";

                // $date3 = new DateTime($time1['End Date']);
                // $date4 = "Date(".date_format($date3, 'Y').", ".((int) date_format($date3, 'm') - 1).", ".date_format($date3, 'd').")";
                $date1 = 'new Date(' . $time1['StartDate'] . '000)';
                $date2 = 'new Date(' . $time1['EndDate'] . '000)';

                

                $time_table[] =array((string)$time1['ID'], (string)$date1, (string)$date2);     

            }
            

        
            
            
            $time_table = json_encode($time_table);            
            print_r($time_table);

   

            $conn->close();
         
        echo"<head>";
            echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
            echo'<script type="text/javascript">
            google.charts.load(\'current\', {\'packages\':[\'timeline\']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var container = document.getElementById(\'timeline\');
                var chart = new google.visualization.Timeline(container);
                var dataTable = new google.visualization.DataTable();

                dataTable.addColumn({ type: \'string\', id: \'ID\' });
                dataTable.addColumn({ type: \'datetime\', id: \'Start\' });
                dataTable.addColumn({ type: \'datetime\', id: \'End\' });
                dataTable.addRows('.$time_table.');

                chart.draw(dataTable);
            }
            </script>';
        echo"</head>
        <body>
            <div id=\"timeline\" style=\"height: 180px;\"></div>
        </body>";
        }



        function timeline2()
        {



    
                //index.php
                /*Open Data base connection*/
            $Owner_ID=$_SESSION["id"]; 
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
            //Add dynamic sql
            $query = "Select ID, UNIX_TIMESTAMP(`Start Date`) as StartDate, UNIX_TIMESTAMP(`End Date`) as EndDate FROM Contract Where Owner_ID = 1 and Approval=1";
                $result = mysqli_query($conn, $query);
                $rows = array();
                $table = array();

                $table['cols'] = array(
                array(
                'label' => 'ID', 
                'type' => 'string'
                ),               
                array(
                'label' => 'StartTime', 
                'type' => 'datetime'
                ),
                array(
                    'label' => 'EndTime', 
                    'type' => 'datetime'
                    ),
                    
                );

                while($row = mysqli_fetch_array($result))
                {
                $sub_array = array();
                $StartTime = explode(".", $row["StartDate"]);
                $EndTime = explode(".", $row["EndDate"]);    
                $sub_array[] =  array(
                    "v" => $row["ID"]
                    );
                
                $sub_array[] =  array(
                    "v" => 'Date(' . $row["StartDate"] . '000)'
                    );
                $sub_array[] =  array(
                    "v" => 'Date(' . $row["EndDate"] . '000)'
                    );
                $rows[] =  array(
                    "c" => $sub_array
                    );
                }
                $table['rows'] = $rows;
                $jsonTable = json_encode($table);

                print_r($jsonTable);
                

    
                echo"<head>";
                echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
                echo'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
                echo'<script type="text/javascript">
                google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart()
                {
                    var data = new google.visualization.DataTable('.$jsonTable.');

                    var options = {
                    title:\'Sensors Data\',
                    legend:{position:\'bottom\'},
                    chartArea:{width:\'95%\', height:\'65%\'}
                    };

                    var chart = new google.visualization.LineChart(document.getElementById(\'line_chart\'));

                    chart.draw(data, options);
                }
                </script>';
             
               echo" </head>  

                <div class=\"page-wrapper\">
                <br />
                <h2 align=\"center\">Display Google Line Chart with JSON PHP & Mysql</h2>
                <div id=\"line_chart\" style=\"width: 100%; height: 500px\"></div>
                </div>";

        }

    ?>
  </body>
</html>