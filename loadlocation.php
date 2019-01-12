<?php 
session_start();
	//$deviceid = $_GET['id'];
	$deviceid=$_SESSION['AUId'];
include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
$sql = "select * from locations where AUId=".$deviceid;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$longitude = $row['Latitude'];
		$langitude = $row['Longtitude'];
		$lup = $row['lastupdated'];
	}
	$loc = array("lat"=>$longitude,"long" => $langitude,"lup"=> $lup);
	echo  json_encode($loc);



?>