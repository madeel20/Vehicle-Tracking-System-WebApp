<?php 
session_start();
if(isset($_SESSION['name'])){
	if($_SESSION['name'] != 'admin'){
		header("Location: Location.php");
	}
	 /* Redirect browser */
}
if(isset($_POST['AUId']) == false){
	header("Location: admin.php");
}
if(isset($_POST['wuname'])){
	include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
$uwuname = 	$_POST['wuname'];
$uwpass = $_POST['wpass'];

$sql = "UPDATE `webandruser` SET `Username`='".$uwuname. "',`Pass`='".$uwpass. "' where AUId=". $_POST['AUId'];
$conn->query($sql);
$wsalert = "changes saved!";
	
}
if(isset($_POST['auname'])){
	include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
$uwuname = 	$_POST['auname'];
$uwpass = $_POST['apass'];

$sql = "UPDATE `androiduser` SET `Username`='".$uwuname. "',`Pass`='".$uwpass. "' where AUId=". $_POST['AUId'];
$conn->query($sql);
	$asalert = "changes saved!";
	
}

if(isset($_POST['fname'])){
	include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
$fname = 	$_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$cellno = $_POST['cellno'];
$vehicle = $_POST['vehicleno'];
$cnic = $_POST['cnic'];
$brokerno = $_POST['brokerno'];
$partyname = $_POST['partyname'];

$sql = "UPDATE `tbl_udetails` SET `firstname`='".$fname."',`lastname`='".$lname."',`address`='".$address."',`cellno`='".$cellno."',`vehicleno`='".$vehicle."',`brokerno`='".$brokerno."',`cnic`='".$cnic."',`partyname`='".$partyname."' where AUId=". $_POST['AUId'];
$conn->query($sql);
	$dsalert = "changes saved!";
}
include "connection.php";
// Create connection
$conn = new mysqli($server, $username, $password,$dbname);
// Check connection 
if ($conn->connect_error) {
	$error = die("Connection failed: " . $conn->connect_error);
	
	
    
} 
$sql = "SELECT webandruser.Username as WUsername , webandruser.Pass as WPass,androiduser.Username as AUsername,androiduser.Pass as APass ,androiduser.AUId , androiduser.CDate,androiduser.status FROM webandruser INNER JOIN androiduser on webandruser.AUId=androiduser.AUId where androiduser.AUId=".$_POST['AUId'];
$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		 $wuname = $row['WUsername'];
		 $wpass = $row['WPass'];
		 $auname = $row['AUsername'];
		 $apass = $row['APass'];
	  }
	}
	else {
	echo $conn->error;
	}
	$sql = "SELECT * FROM `tbl_udetails` where AUId=".$_POST['AUId'];
	$result = $conn->query($sql);
	if($result->num_rows>0){
	  while($row = $result->fetch_assoc()) {
		 $fname= $row['firstname'];
		 $lname = $row['lastname'];
		 $address = $row['address'];
		 $cellno = $row['cellno'];
		 $vehicleno = $row['vehicleno'];
		 $brokerno = $row['brokerno'];
		 $cnic = $row['cnic'];
		 $partyname = $row['partyname'];
		echo $conn->error;
	  }
	}
	else {
	
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
<table class="table">
	<tr><td align="left" colspan="2">
<form method="post" action="viewdetails.php">
	<input type="submit" value="Back" class="btn btn-warning">
	<input type="hidden"  name="AUId" value="<?php echo $_POST['AUId'];?>" />
    <input type="hidden"  name="WUsername" value="<?php echo $_POST['WUsername'];?>" />
</form>
</td>
</tr>
<tr><td colspan="2">
<h2>Edit  Details Of: <?php echo $_POST['WUsername'];?></h2>
</td>
</tr>

<tr>
 <td colspan="2"><h2>Website Credentials</h2></td>
 </tr>
<form action="#" method="post" >
<tr>
	<td align="right">Username:</td>
	<td align="left"><input readonly type="text" name="wuname" value="<?php echo $wuname;?>" required /></td>
</tr>
<tr>
	<td align="right">Password:</td>
	<td align="left"><input type="text" name="wpass" value="<?php echo $wpass;?>" required/></td>
</tr>
    <input type="hidden"  name="AUId" value="<?php echo $_POST['AUId'];?>" />
    <input type="hidden"  name="WUsername" value="<?php echo $_POST['WUsername'];?>" />
<tr><td colspan="2">
	<input type="submit" value="Save" class="btn btn-danger"  />
	<span style="color:red;"> <?php
if(isset($wsalert)) echo $wsalert;?></span>
</td></tr>
</form> 
<tr>
 <td colspan="2"><h2>Android Credentials</h2></td>
 </tr>
<form action="#" method="post" >
<tr><td align="right">Username:</td>
	<td align="left"><input readonly type="text"name="auname" required value="<?php echo $auname;?>" /></td>
</tr>
<tr><td align="right">Password:</td>
	<td align="left"><input type="text" name="apass" required value="<?php echo $apass;?>"/></td>
</tr>
	<input type="hidden"  name="AUId" value="<?php echo $_POST['AUId'];?>" /> 
	<input type="hidden"  name="WUsername" value="<?php echo $_POST['WUsername'];?>" />
<tr>
	<td colspan="2"><input type="submit" value="Save" class="btn btn-danger"/>
	<span style="color:red;"> <?php
if(isset($asalert)) echo $asalert;?></span>
</td>
</tr>	
</form>
<tr>
	<td colspan="2"><h2>Edit Details</h2></td>
</tr>
<form action="#" method="post">
	<input type="hidden"  name="WUsername" value="<?php echo $_POST['WUsername'];?>" />
    <input type="hidden"  name="AUId" value="<?php echo $_POST['AUId'];?>" />
<tr>
	<td align="right">First Name:</td>
	<td align="left"><input type="text"name="fname" value="<?php echo $fname;?>"  required /></td>
</tr>
<tr>
	<td align="right">Last Name:</td>
	<td align="left"><input type="text" name="lname"value="<?php echo $lname;?>"  required/></td>
</tr>
<tr>
	<td align="right">Address:</td>
	<td align="left"><input value="<?php echo $address;?>"  type="text" name="address" required/></td>
</tr>
<tr>
	<td align="right">Cell No:</td>
	<td align="left"><input value="<?php echo $cellno;?>"  type="text" name="cellno" required/></td>
</tr>
<tr>
	<td align="right">Vehicle No:</td>
	<td align="left"><input type="text" name="vehicleno" value="<?php echo $vehicleno;?>"  required/></td>
</tr>
<tr>
	<td align="right">Broker No:</td>
	<td align="left"><input value="<?php echo $brokerno;?>"  type="text" name="brokerno" required/></td>
</tr>
<tr>
	<td align="right">CNIC:</td>
	<td align="left"><input type="text" name="cnic" required value="<?php echo $cnic;?>" /></td>
</tr>
<tr>
	<td align="right">Party Name:</td>
	<td align="left"><input type="text" name="partyname" value="<?php echo $partyname;?>"  required/></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Save" class="btn btn-danger"/>
		<span style="color:red;"> <?php
if(isset($dsalert)) echo $dsalert;?></span>
</td>
</tr>
</form>
</table>
</body>
</html>