<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
<div>
    <p>
        Test Google Dashboard Full
    </p>

    <?php

        dashboard();
        
        echo"<table>
        <tr>
        <td><div id=\"rev_div\"></div></td>
        <td><div id=\"Space_div\"></div></td>
        </tr>
        <tr>
        <td>Time Line </td>
        </tr>
        <td colspan=\"2\"><div id=\"timeline\" style=\"height: 500px;\"></div></td>
        </tr>
        </table>
        </div>";

        ///Makes Dashboard////
        function dashboard(){
         
        ////////Bring In Map Data///////////
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
            
            $conn->close(); 
                
        ////////Bring In Revenue Data///////////
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
            print_r($revenue_table);
            $conn->close();   
                
        ////////Bring In Space Data///////////
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

        ////////Bring In Timeline Data///////////
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

                
                $conn->close();



        ////Google Chart Creation/////
            echo"<head>";
            echo'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
            echo'<script type="text/javascript">
            google.charts.load("visualization", "1", {packages:["map", "corechart", "timeline"], "mapsApiKey": "AIzaSyDlCFMRDDqE9uI1VaccIE8k7iHTbsfeD1I"});
            google.charts.setOnLoadCallback(init);

            function init () {
               
                drawRev();
                drawSpace();
                drawTimeline(); 
            }

            function drawMap() {
                var dataMap = new google.visualization.DataTable();
                    dataMap.addColumn(\'string\', \'zip\');
                    dataMap.addColumn(\'number\', \'Warehouse ID\');
                    dataMap.addRows('.$location_table.');
        
                var map = new google.visualization.Map(document.getElementById(\'map_div\'));
                map.draw(dataMap, {
                showTooltip: true,
                showInfoWindow: true
                });
            }

            function drawRev() {

                var dataRev = new google.visualization.DataTable();
                        dataRev.addColumn(\'string\', \'ID\');
                        dataRev.addColumn(\'number\',\'Revenue\');
                        dataRev.addRows('.$revenue_table.');
                var options = {
                    title: \'Percentage Revenue by Contract\',
                    is3D: \'true\',
                    width: 600,
                    height: 600
                    };
                
                var chartRev = new google.visualization.PieChart(document.getElementById(\'rev_div\'));
                chartRev.draw(dataRev, options);
                }
            
            function drawSpace() {

                var dataSpace = new google.visualization.DataTable();
                        dataSpace.addColumn(\'string\', \'ID\');
                        dataSpace.addColumn(\'number\',\'Space\');
                        dataSpace.addRows('.$space_table.');
                var options = {
                    title: \'Space Occupied\',
                    is3D: \'true\',
                    width: 600,
                    height: 600
                    };
                
                var chartSpace = new google.visualization.PieChart(document.getElementById(\'Space_div\'));
                chartSpace.draw(dataSpace, options);
                }

            
            function drawTimeline(){
                
                    
                var container = document.getElementById(\'timeline\');
                var Timeline = new google.visualization.Timeline(container);
                var dataTime = new google.visualization.DataTable('.$jsonTable.');

                


                Timeline.draw(dataTime);
            
            }
        
            </script>';
            echo"</head>";
        }
    
    ?>


  </body>
</html>