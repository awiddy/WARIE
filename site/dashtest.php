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
        echo"<tr></table>";
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

            
    ?>
  </body>
</html>