
<?php

if(isset($_GET['key'])){
	if($_GET['key'] == "1345"){
$id= $_GET['AUId'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
$sql = "SELECT appr FROM androiduser where AUId=".$id; 
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
		echo $row['appr'];
	}
}
	}
}
	
?>