<?php 

if(isset($_GET['key'])){
	if($_GET['key'] == "1345"){
$name= $_GET['username'];
$latitude = $_GET['lat'];
$longitude = $_GET['lon'];
$dt = $_GET['dt'];
$tm = $_GET['tm'];

	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
	$sql ="INSERT INTO `tblUser_".$name."`( `lat`, `lon`, `tm`, `dt`) VALUES ('".$latitude. "','".$longitude."','".$tm."','".$dt."')";
	if($conn->query($sql) == true){
		echo "1";
	}
	else echo $conn->error;
	
}
}
?>