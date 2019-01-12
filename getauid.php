<?php 

if(isset($_GET['key'])){
	if($_GET['key'] == "1345"){
$aname = $_GET['username'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
	$sql ="select AUId from androiduser where Username='".$aname. "'";
	$result = $conn->query($sql);
	if($result->num_rows >0) 
	while($row = $result->fetch_assoc()){
	 echo $row['AUId'];
	
	}
	else echo $conn->error;
	
}
}
?>