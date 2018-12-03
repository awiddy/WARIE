<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
    <p>
        Test Google Dashboard
    </p>

    <?php
        /*Open Database connection*/
        $Owner_ID=$_SESSION["id"]; 
        $servername = "mydb.ics.purdue.edu";
        $username = "g1090423";
        $password = "marioboys";
        $dbname = "g1090423";
        // Createconnection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Checkconnection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        //$contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = ".$Owner_ID." AND Contract.Approval=1";
        $contracts_sql = "Select Contract.*, Warehouse.StorageCapacity, Warehouse.BasePrice, Warehouse.Zipcode From Contract INNER JOIN Warehouse ON Contract.Warehouse_ID = Warehouse.ID Where Contract.Owner_ID = 1 AND Contract.Approval=1";
        
        //Makes multidimensional array of contracts_sql query result
        $contracts_result = mysqli_query($conn, $contracts_sql);
        $contract = array();
        if(mysqli_num_rows($contracts_result)>0){
            while($row = mysqli_fetch_assoc($contracts_result)){
                $contract[] = $row;
            }
        }
       
		//Construct Revenue Table
	   $revenue_table = array();
       foreach ($contract as $contract1){
		   $diff = strtotime($contract1['End Date']) - strtotime($contract1['Start Date']);   //Site the Stack overflow
		   $diffDays = floor($diff/(3600*24));
           $revenue = $contract1['BasePrice']/365 *$contract1['Rented_Space'] * $diffDays;
           $revenue_table[] = array($contract1['ID'],(int)$revenue); 
        }
        //makes json file of revenue table
        $revenue_table = json_encode($revenue_table);
       
        
       //$location_sql = "Select Warehouse.Latitude, Warehouse.Longitude, Warehouse.ID From Warehouse Where Owner_ID = ".$Owner_ID."";
       $location_sql = "Select Warehouse.Latitude, Warehouse.Longitude, Warehouse.ID From Warehouse Where Owner_ID = 1";

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
        $location_table[] = array($location1['Latitude'],$location1['Longitude'], $location1['ID']); 
     }

       $location_table = json_encode($location_table);
     
    
        $conn->close();
    
    ?>

  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
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
  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', { 'packages': ['map'] });
    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
        var data = new google.visualization.DataTable();
          data.addColumn('number', 'Lat');
          data.addColumn('number','Long');
          data.addColumn('number', 'Warehouse ID');
          data.addRows(<?=$location_table?>);

    var options = {
      showTooltip: true,
      showInfoWindow: true
    };

    var map = new google.visualization.Map(document.getElementById('chart_div'));

    map.draw(data, options);
  };
  </script>
  </head>

  <body>
    <div id="chart_div"></div>

  </body>
</html>
    