<?php 
session_start();
//print_r($_SESSION['devices']);
if(isset($_SESSION['devices'])){

include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT  * from androiduser where appr=0";
$result = $conn->query($sql);
$k=0;
	if($result->num_rows>0){
	
	  while($row = $result->fetch_assoc()) {
		
			  $k++;
		
	  }
	  
}

echo $k;
		
}
	  ?>
      
   
      
       