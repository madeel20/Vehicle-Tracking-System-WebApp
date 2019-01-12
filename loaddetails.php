<?php
session_start();
if(isset($_GET['key'])){
if($_GET['key'] == '1234'){
include 'connection.php'; 

$con = new mysqli($server, $username, $password,$dbname);// this create connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$sql = "SELECT * FROM tbl_udetails inner join androiduser on tbl_udetails.AUId=androiduser.AUId WHERE androiduser.AUId=".$_GET['AUId'];
$result = $con->query($sql)or die($con->error);
while($row = $result->fetch_assoc()){
	$data = array('firstname'=>$row['firstname'],'lastname'=>$row['lastname'],'address'=>$row['address'],'cellno'=>$row['cellno'],'vehicleno'=>$row['vehicleno'],'brokerno'=>$row['brokerno'],'cnic'=>$row['cnic'],'partyname'=>$row['partyname'],'status'=>$row['status']);
}

	echo  json_encode($data);

mysqli_close($con);

}}
?>
