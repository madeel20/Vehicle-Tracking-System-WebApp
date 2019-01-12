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
include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
	
	
    
} 
$appreq =0;
$sql = "select * from androiduser where appr=0";
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		  $appreq++;
	  }}

	if(isset($_POST['savestatus'])){
		if(isset($_POST['status'])){
			$ustatus =1;
		}
		else {
		$ustatus = 0;
		}
		include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
	
	
    
} 
$sql = "UPDATE `androiduser` SET `status`=".$ustatus." WHERE AUId=".$_POST['sAUId'];
 $conn->query($sql);
	}

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
	 window.location="admin.php";
 }
 /*setInterval("reload()",10000);*/
 
  </script>

	<script>

function loadonlinepl(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
			
                document.getElementById("req").innerHTML=this.response;
				
            }
        };
        xmlhttp.open("GET","loadappreq.php",true);
        xmlhttp.send();
	  
  }
 setInterval("loadonlinepl();",1000);
</script>
<body class="text-center">
<table class="table">
<tr>
<td align="left">	
<a href="changepassword.php" class="btn btn-warning">Change Password</a>
<a href="appreq.php" class="btn btn-warning">Approval Requests ( <span id="req"><?php echo $appreq;?></span> )</a>
</td>
<td align="right">
<form method="post" action="logout.php">
	<input type="submit" value="Log Out" class="btn btn-warning">
</form>
</td>
</tr>
<tr>
	<td colspan="3">
<h2>All Registered Devices</h2>
</td>
</tr>
<!-- header ends here -->
<tr>
	<td colspan="3">
<table id="alldevices" class="table table-striped"> 

<tr>
	<th colspan="2">Website Credentials</th>
	<th colspan="2">Android Credentials</th>
	<th colspan="7"></th>
	</tr>
	<tr  style="background:black; color:white;">
	<th>Username</th>
    <th>Password</th>
    <th> Username</th>
    <th> Password</th>
    <th>Date Created</th>
    <th colspan="3">Status</th>
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
$appreq =0;
$sql = "select * from androiduser where appr=0";
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		  $appreq++;
	  }}

$sql = "SELECT webandruser.Username as WUsername , webandruser.Pass as WPass,androiduser.Username as AUsername,androiduser.Pass as APass ,androiduser.AUId , androiduser.CDate,androiduser.status FROM webandruser INNER JOIN androiduser on webandruser.AUId=androiduser.AUId where androiduser.appr!=0 ORDER by androiduser.status DESC ";
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		  array_push($_SESSION['devices'],$row['AUId']);
		  if($row['status'] == 0){
		  $style = "opacity:0.8";
		 $st = '';
		 $status = "Not Active ";
	  }
		  else{
		  $style= "";
		   $st = 'checked';
		   $status = "  Active  ";}
		  
			echo "<tr style='font-size:15px; ".$style."'><td>". $row['WUsername'] . "</td><td>". $row['WPass'] . "</td><td>". $row['AUsername'] . "<td>". $row['APass'] . '</td><td>'. $row['CDate'] . '</td>'.'<form action="#" method="post"><td>'.$status. '</td><input type="hidden" name="sAUId" value="'.$row['AUId'].'">'. '<td><input type="checkbox" name="status" value="'.$row['status'].'" '.$st.' /></td>  <td><input type="submit" class="btn btn-warning" value="Save" name="savestatus"></td>' . '</form></td><td><form action="viewdetails.php" method="post"><input class="btn btn-default" type="submit" value="Details" name="vdetails"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/><input type="hidden" name="ustatus" value="'.$row['status'].'"/><input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td><td><form action="Location.php" method="post"><input type="submit" class="btn btn-default" value="Location" name="vloc"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/><input type="hidden" name="ustatus" value="'.$row['status'].'"/><input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td><td><form action="delete.php" method="post"><input type="submit" class="btn btn-danger" value="Delete" name="sdelete"><input type="hidden" name="WUsername" value="'.$row['WUsername'].'"/><input type="hidden" name="AUId" value="'.$row['AUId'].'">'. '</form></td></tr>' ;
	
	  }}
?></table>
</td></tr>
</table>
</body>
</html>
<?php 
	
unset($_SESSION['devices']);
$_SESSION['devices'] = array();
	include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
	
} 
$sql = "SELECT * from androiduser ";
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		  array_push($_SESSION['devices'],$row['AUId']);
	  }}
	  ?>