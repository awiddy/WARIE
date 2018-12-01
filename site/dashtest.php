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
       
		
	   $revenue = array();
       foreach ($data as $data1){
		   $diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
		   $diffDays = floor($diff/(3600*24));
		   $revenue = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
		echo $revenue;
       }
		
			
	   $revenueTable = array_combine($data, $revenue);
			
			
		// $revenueTable= array();
		// $revenueTable['cols'] = array(
			// array('lable' => "StartDate", 'type'=>'date'),
            // array('lable' => "EndDate", 'type'=>'date'),
            // array('lable' => 'ID', 'type' => 'string'),
			// array('lable' => 'Warehouse_ID', 'type' => 'string'),
			// array('lable' => 'Revenue', 'type' => 'number'),
		// );
		
		// $revenue_rows = array();
		// foreach( $data as $data1){
			// $temp = array();
			// $temp[] = array('v' => (date) $data1['StartDate']);
			// $temp[] = array('v' => (date) $data1['EndDate']);
			// $temp[] = array('v' => (string) $data1['ID']);
			// $temp[] = array('v' => (string) $data1['Warehouse_ID']);
			// $diff = strtotime($data1['End Date']) - strtotime($data1['Start Date']);   //Site the Stack overflow
		    // $diffDays = floor($diff/(3600*24));
		    // $revenue = $data1['BasePrice']/365 *$data1['Rented_Space'] * $diffDays;
			// $temp[] = array('v' => (int) $revenue);
			// $revenue_rows[] = array('c' => $temp);
			
		// }
		
		// $revenue = array($data['Start Date'],$data['End Date'], $data['ID'], $data['Warehouse_ID'], $Revenue); 
		// print_r($revenue);
		
		// print_r($data['End Date'];
	
		// $revenueTable['rows'] = $NewArray;
		// $jsonTable = json_encode($revenueTable);
		// echo jsonTable
		
        // $contracts = array();
        // $contracts['cols'] = array(
        //     array('lable' => "StartDate", 'type'=>'string'),
        //     array('lable' => "EndDate", 'type'=>'string'),
        //     array('lable' => 'ID', 'type' => 'string'),
        //     array('lable' => "Lessee_Rating", 'type'=>'number'),
        //     array('lable' => "Owner_Rating", 'type'=>'number'),
        //     array('lable' => "Lessee_ID", 'type'=>'number'),
        //     array('lable' => "Owner_ID", 'type'=>'number'),
        //     array('lable' => "Rented_Space", 'type'=>'number'),
        //     array('lable' => "SigningDate", 'type'=>'string'),
        //     array('lable' => "Approval", 'type'=>'number'),
        // );

        // $contracts_rows = array();
        // while($row = $contracts_result->fetch_assoc()){
        //     $temp = array();
        //     $temp[] = array('v' => (string) $row['StartDate']);
        //     $temp[] = array('v' => (string) $row['EndDate']);
        //     $temp[] = array('v' => (int) $row['ID']);
        //     $temp[] = array('v' => (int) $row['Lessee_Rating']);
        //     $temp[] = array('v' => (int) $row['Owner_Rating']);
        //     $temp[] = array('v' => (int) $row['Lessee_ID']);
        //     $temp[] = array('v' => (int) $row['Owner_ID']);
        //     $temp[] = array('v' => (int) $row['Rented_Space']);
        //     $temp[] = array('v' => (string) $row['SigningDate']);
        //     $temp[] = array('v' => (int) $row['Approval']);
        // }
        // $contracts['rows'] = $contracts_rows;
        // $jsonTable = json_encode($contracts);
        // echo $jsonTable;







        $conn->close();
    ?>

</body>

</html>