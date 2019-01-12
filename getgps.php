<?php 

if(isset($_GET['key'])){
	if($_GET['key'] == "1345"){
$id = $_GET['AUId'];
$latitude = $_GET['lat'];
$longitude = $_GET['lon'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
	if($latitude != 0.0 || $longitude != 0.0){
	$sql ="UPDATE `locations` SET `Latitude`=".$latitude.", `Longtitude`=".$longitude.", lastupdated='".$_GET['lup']."' WHERE AUId=".$id;
	if($conn->query($sql) == true){
		echo "1";
	}
	else echo $conn->error;
	
}
	}
}
?>