<!DOCTYPE HTML>
<html>
<head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
          title: 'My Weekly Plan',
          is3D: 'true',
          width: 800,
          height: 600
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
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
       
		
	   $revenue = array();
       foreach ($data as $data1){
		   $diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
		   $diffDays = floor($diff/(3600*24));
           $revenue[] = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
       }
        //print_r($revenue);
        
        //$revenue_array  = array($data,$revenue);
        //print_r($revenue_array);
			
	   //$revenueTable = array_combine($data, $revenue);
			
			
		$revenueTable= array();
		$revenueTable['cols'] = array(
			//array('lable' => "StartDate", 'type'=>'date'),
            //array('lable' => "EndDate", 'type'=>'date'),
            array('lable' => 'ID', 'type' => 'string'),
            //array('lable' => 'Warehouse_ID', 'type' => 'string'),
            array('lable' => 'revenue', 'type' => 'number'),
		);
		$i=0;
		$revenue_rows = array();
		foreach($data as $data2){
			$temp = array();
			//$temp[] = array('v' => (string) $data2['StartDate']);
			//$temp[] = array('v' => (int) $data2['EndDate']);
			$temp[] = array('v' => (int) $data2['ID']);
			//$temp[] = array('v' => (int) $data2['Warehouse_ID']);
            $temp[] = array('v' => (int) $revenue[$i]);
            $revenue_rows[] = array('c' => $temp);
            $i= $i++;
            
		}
		
        $revenueTable['rows'] = $revenue_rows;
        $jsonTable = json_encode($revenueTable);
        //echo $jsonTable; 
        
        







        $conn->close();
    ?>
       <!--this is the div that will hold the pie chart-->
    <div id="chart_div"></div> 
</body>



</html>