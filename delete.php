<?php 
session_start();
if(isset($_SESSION['name'])){
	if($_SESSION['name'] != 'admin'){
		header("Location: Location.php");
	}
	 /* Redirect browser */
}


if(isset($_POST['confirmdelete'])){
$devicesid = $_POST['AUId'];
include "connection.php";
$conn = new mysqli($server,$username,$password,$dbname);
$sql = "select  * from androiduser where AUId=".$devicesid;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$aname = $row['Username'];
}
      $sql = "DELETE FROM webandruser WHERE AUId=".$devicesid;
	  if($conn->query($sql)){
	  $sql = "DELETE FROM androiduser WHERE AUId=".$devicesid;
	  if($conn->query($sql)){
		  $sql = "DROP TABLE tblUser_".$aname;
		  if($conn->query($sql)){
			   $sql = "DELETE FROM `tbl_udetails` WHERE AUId=".$devicesid;
			   if($conn->query($sql)){
				   if(!isset($_POST['approval1']))
			header("Location: appreq.php");	   
				   else
		header("Location: admin.php");}
		  }
	  }
	  }

}
if(isset($_POST['AUId']) == false){
	header("Location: admin.php");
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

<body class="text-center">
<table class="table">
	<tr><td>
<h2>  Do you want to delete : <?php echo $_POST['WUsername'];?></h2></td></tr>
<tr><td><h4 class="text-danger"><?php if(!isset($_POST['approval']))
echo 'Note: Locations history will also be deleted'  ?>
</h4></td></tr>
<tr>
	<td>
<form action="#" method="post">
<input type="hidden" name="AUId" value="<?php echo $_POST['AUId'];?>"/>  
<input type="hidden" name="confirmdelete"  value="1"/>
<?php if(!isset($_POST['approval']))
echo '<input type="hidden" name="approval1" value="1"/>';
?>
<input type="submit" value="Confirm" class="btn btn-danger"/>
<a class="btn btn-warning" href="admin.php">Cancel</a>
</form>
</td></tr></table>
</body>
</html>