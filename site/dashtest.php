<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
    <p>
        Test Google Dashboard
    </p>

    <?php
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

        /*$contracts_sql = "SELECT * FROM Contract WHERE Owner_ID=".$Owner_ID." AND Approval=1";*/
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
        
        
        $conn->close();
       
    ?>

  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
            data.addColumn('string', 'ID');
            data.addColumn('number','Revenue');
            data.addRows(<?=$revenue_table?>);
      var options = {
           title: 'Percentage Revenue by Contract',
          is3D: 'true',
          width: 800,
          height: 600
        };
    
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
 </head>
  
    <div id="chart_div"></div>

  </body>
</html>
    