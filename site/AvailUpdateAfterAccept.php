<?php
require_once "config.php";

$Warehouse_ID = $_POST["Warehouse_ID"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$rentedspace = $_POST["rentedspace"];

$sql = "SELECT Open_Space FROM Availability A, WHERE Warehouse_ID = ".$sql." AND 
$sql = "(SELECT Warehouse_ID FROM Contract WHERE ID = ".$Contract_ID.")"


UPDATE Availability
SET column1=value, column2=value2,...
WHERE some_column=some_value  


UPDATE Availability
SET Open_Space=(SELECT Open_Space FROM Availability WHERE WeekFromDate Between ".$startdate." AND ".$enddate." AND  Warehouse_ID = ".$Warehouse_ID.") - ".$rentedspace."  
WHERE WeekFromDate Between ".$startdate." AND ".$enddate."AND  Warehouse_ID = ".$Warehouse_ID."")
?>