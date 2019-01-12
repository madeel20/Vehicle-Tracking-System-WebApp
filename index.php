<?php
session_start();
if(isset($_SESSION['name'])){
	if($_SESSION['name'] == 'admin'){
		header("Location: admin.php");
	}
	else {
		header("Location: Location.php");
	}
	 /* Redirect browser */
exit();
}
$error = "";
if(isset($_POST['pwd'])){
	if($_POST['uname'] == 'admin'){
	 include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/

$conn = new mysqli($server, $username, $password);// this create connection

if ($conn->connect_error) { //  this checks if there error connecting to server
	$error = die("Connection failed: " . $conn->connect_error);} // saves error  in $error
	$sql = 'SELECT * FROM '.$dbname.'.admin '; //query for selecting data from studentlogin table
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$email = $_POST['uname'];
	$password = $_POST['pwd'];
		if($row['Username'] == $email && $row['pass'] == $password){
		    $_SESSION['name'] =  $row['Username'];
			header("Location: admin.php"); /* Redirect browser */
exit();
		}
		else 
		{
			$reluser = $_POST['uname'];
			$error = "UserName or Password Is Incorrect!";
			
		}
	}}
	
}
else {
	
	include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/

$conn = new mysqli($server, $username, $password);// this create connection

if ($conn->connect_error) { //  this checks if there error connecting to server
	$error = die("Connection failed: " . $conn->connect_error);} // saves error  in $error
	$sql = 'SELECT * FROM '.$dbname.'.webandruser '; //query for selecting data from studentlogin table
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$email = $_POST['uname'];
	$password = $_POST['pwd'];
		if($row['Username'] == $email && $row['Pass'] == $password){
		    $wbuser =  $row['Username'];
		    $wbid= $row['AUId'];
		   $sql = 'SELECT * FROM '.$dbname.'.androiduser where AUId='.$row['AUId'];
		  $result1 = $conn->query($sql); 
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        if($row1['status']==1){
              $_SESSION['name'] = $wbuser;
			$_SESSION['AUId'] = $wbid;
			header("Location: Location.php"); /* Redirect browser */
exit();
        }
        else {
          $error = "user is not active" ; 
        }
    }
}
		  
		}
		else 
		{
			$reluser = $_POST['uname'];
			$error = "Username or Password Is Incorrect!";
			
		}
	}}
	
	
}
	
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
<body class="text-center" style="margin:auto; width: 50%">
<form action="#" method="post" > 
 <table class="table">
 	<tr><td align="right">User ID:</td>
 		<td><input <?php 
  if(isset($reluser)){
	   echo 'value="'.$reluser.'"';
  }
  else echo 'autofocus'
 ?>  class="form-control" type="text" placeholder="Enter your username" required  name="uname"
  ></td>
 	</tr>

 	<tr><td align="right">Password:</td>
 		<td ><input 
 <?php 
  if(isset($reluser)){
	   echo 'autofocus';
  }
  ?> required  class="form-control" type="password" placeholder="Enter your password" name="pwd"></td>
 	</tr>
 	<tr>
 		<td colspan="2"><input type="submit" value="Log In" class="btn btn-warning"></td>
 	</tr>
<tr>
	<td colspan="2"> <span class="error"> <?php echo $error; ?> </span> 
<h2><a href="mfe_vehicle_tracker.apk" > Download App </a></h2>
</td>
</tr>
 </table>
</div>
 </form>
</body>
</html>