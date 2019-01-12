<?php 

//
if(isset($_GET['key']))
if($_GET['key'] == '1234'){
$auid = $_GET['auid'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$address = $_GET['address'];
$cellno = $_GET['cellno'];
$vehicleno = $_GET['vehicleno'];
$brokerno = $_GET['brokerno'];
$cnic = $_GET['cnic'];
$partyname= $_GET['pname'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
	$sql ="INSERT INTO `tbl_udetails`( `AUId`, `firstname`, `lastname`, `address`, `cellno`, `vehicleno`, `brokerno`, `cnic`, `partyname`) VALUES (".$auid.",'".$fname."','".$lname."','".$address."','".$cellno."','".$vehicleno."','".$brokerno."','".$cnic."','".$partyname."')";
	if($conn->query($sql) == true){
	
echo 1;
	}
else 
echo $conn->error;
	}