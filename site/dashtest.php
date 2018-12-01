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
        $contracts_sql = "SELECT * FROM Contract WHERE Owner_ID=5 AND Approval=1";
        $contracts_result = $conn->query($contracts_sql);
        

        $contracts = array();
        $contracts['cols'] = array(
            array('lable' => "StartDate", 'type'=>'string'),
            array('lable' => "EndDate", 'type'=>'string'),
            array('lable' => 'ID', 'type' => 'string'),
            array('lable' => "Lessee_Rating", 'type'=>'number'),
            array('lable' => "Owner_Rating", 'type'=>'number'),
            array('lable' => "Lessee_ID", 'type'=>'number'),
            array('lable' => "Owner_ID", 'type'=>'number'),
            array('lable' => "Rented_Space", 'type'=>'number'),
            array('lable' => "SigningDate", 'type'=>'string'),
            array('lable' => "Approval", 'type'=>'number'),
        );

        $contracts_rows = array();
        while($row = $contracts_result->fetch_assoc()){
            $temp = array();
            $temp[] = array('v' => (string) $row['StartDate']);
            $temp[] = array('v' => (string) $row['EndDate']);
            $temp[] = array('v' => (int) $row['ID']);
            $temp[] = array('v' => (int) $row['Lessee_Rating']);
            $temp[] = array('v' => (int) $row['Owner_Rating']);
            $temp[] = array('v' => (int) $row['Lessee_ID']);
            $temp[] = array('v' => (int) $row['Owner_ID']);
            $temp[] = array('v' => (int) $row['Rented_Space']);
            $temp[] = array('v' => (string) $row['SigningDate']);
            $temp[] = array('v' => (int) $row['Approval']);
        }
        $contracts['rows'] = $contracts_rows;
        $jsonTable = json_encode($contracts);
        echo $jsonTable;







        $conn->close();
    ?>

</body>

</html>

