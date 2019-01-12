<?php 
session_start();
if(isset($_SESSION['name'])){
	if($_SESSION['name'] != 'admin') {
		header("Location: Location.php");
	}
	 /* Redirect browser */
}
$error = "";
if(isset($_POST['oldpwd'])){
$oldpassword = $_POST['oldpwd'];
$newpassword = $_POST['newpwd'];
$rnewpassword = $_POST['rnewpwd'];
include 'connection.php';
$conn = new MySQLi($server,$username,$password ,$dbname);
$sql = "select * from admin";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
$pwd = $row['pass'];
if($pwd == $oldpassword){
	if($newpassword == $rnewpassword){
		$sql = "UPDATE `admin` SET `pass`= '".$newpassword."' WHERE Username='admin'";
		$conn->query($sql);
		$error = "Password Changed!";	
		
		
	}
	else {
		$error = "New passwords does not matched!";
	}
	
}
else {
	$error = "Old Password is incorrect!";
	
}	
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
<form action="#" method="post">
	<tr>
		<td align="right">Username:</td>
		<td align="left"><input type="text" value="admin" disabled readonly></td>
	</tr>
	<tr>
		<td align="right">Old Password:</td>
		<td align="left"><input type="password"  placeholder="Enter your old password" name="oldpwd" autofocus required></td>
	</tr>
	<tr>
		<td align="right">New Password:</td>
		<td align="left"><input type="password" placeholder="Enter your new password..." name="newpwd" required></td>
	</tr>
	<tr>
		<td align="right">Retype Password:</td>
		<td align="left"><input type="password" name="rnewpwd" placeholder="Re-Enter your new password" required> </td>
	</tr>
<tr>
	<td colspan="2">
<input type="submit" value="Change Password" class="btn btn-danger">
<p style="color:red;" > <?php echo $error; ?></p>
</td>
</tr>
</form></table>
</body>
</html>