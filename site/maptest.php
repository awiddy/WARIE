<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
    <p>
        Test Google Maps
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
        //$location_sql = "Select Warehouse.City, Warehouse.ID From Warehouse Where Owner_ID = ".$Owner_ID."";
       $location_sql = "Select Warehouse.City, Warehouse.ID From Warehouse Where Owner_ID = 1";

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
        $location_table[] = array((string)$location1['City'], (int)$location1['ID']); 
     }

       $location_table = json_encode($location_table);
     
    
        $conn->close();
       
    ?>
<html>
  <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', { 'packages': ['map'] });
    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'City');
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
    