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
$sql = "SELECT webandruser.Username as WUsername , webandruser.Pass as WPass,androiduser.Username as AUsername,androiduser.Pass as APass ,androiduser.AUId , androiduser.CDate FROM webandruser INNER JOIN androiduser on webandruser.AUId=androiduser.AUId where androiduser.appr!=0 ORDER by androiduser.status DESC ";
$result = $conn->query($sql);

	if($result->num_rows>0){
		$k=0;
	  while($row = $result->fetch_assoc()) {
		  if(in_array($row['AUId'],$_SESSION['devices'] )==false){
			  $k++;
		  }
		
	  }
	  if($k==0){
		die("empty");  
	  }
	  else {
		  die("change");
	  }
}

		
}
	  ?>
      
   
      
       