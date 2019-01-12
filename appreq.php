<?php 
session_start();
if(isset($_SESSION['name'])){
	if($_SESSION['name'] != 'admin') {
		header("Location: Location.php");
	}
	 /* Redirect browser */
}

/*if(isset($_POST['delete'])){
$devicesid = array();
$devicesid = $_POST['deviceid'];
include "connection.php";
$conn = new mysqli($server,$username,$password,$dbname);
foreach($devicesid as $id){
      $sql = "DELETE FROM `devices` WHERE deviceid=".$id;
	  $conn->query($sql);	
}	
}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>MFE Vehicle Track</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<script>
 function reload(){
	 window.location="appreq.php";
 }
 setInterval("reload()",60000);
 
  </script>
<body class="text-center">
<table class="table">
<tr>
	<td align="left">
<form method="post" action="admin.php">
	<input type="submit" value="Back" class="btn btn-warning">
</form>
</td>
<td align="right">
<form method="post" action="logout.php">
	<input type="submit" value="Log Out" class="btn btn-warning">
</form>
</td>
</tr>
<tr><td colspan="2">
<h2>Approval Requests</h2>
</td></tr>
<!-- header ends here -->
<tr><td colspan="2">
<table id="alldevices" class="table table-striped"> 
	<tr>
		<th colspan="2">Website Details</th>
		<th colspan="6">Android Details</th>
	</tr>
	<tr  style="background:black; color:white;" >
		<th>Username</th>
    	<th>Password</th>
    	<th>Username</th>
    	<th>Password</th>
    	<th>Date Created</th>
     	<th colspan="3">More</th>
    </tr><?php 
	
unset($_SESSION['devices']);
$_SESSION['devices'] = array();
	include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
	
	
    
} 

$sql = "SELECT webandruser.Username as WUsername , webandruser.Pass as WPass,androiduser.Username as AUsername,androiduser.Pass as APass ,androiduser.AUId , androiduser.CDate,androiduser.status FROM webandruser INNER JOIN androiduser on webandruser.AUId=androiduser.AUId where androiduser.appr=0  ";
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) { 
		$style="";
		   $status = "  Active  ";
		  
			echo "<tr style='font-size:15px; ".$style."'><td>". $row['WUsername'] . "</td><td>". $row['WPass'] . "</td><td>". $row['AUsername'] . "<td>". $row['APass'] . '</td><td>'. $row['CDate'] . '</td>'. '<td><form action="viewdetails.php" method="post"><input class="btn btn-default" type="submit" value="Details" name="vdetails"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/><input type="hidden" name="approval" value="1"/><input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td><td><form action="delete.php" method="post"><input type="submit" class="btn btn-danger" value="Delete" name="sdelete"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/><input type="hidden" name="approval" value="1"/><input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td><td><form action="approve.php" method="post"><input type="submit" class="btn" value="Approve" name="btnappr"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/>
			<input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td></tr>' ;}
	
	  }
?></table>
</td>
</tr>
</table>
</body>
</html>

 