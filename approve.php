<?php 

if(isset($_POST['AUId'])){
$devicesid = $_POST['AUId'];
include "connection.php";
$conn = new mysqli($server,$username,$password,$dbname);
$sql = "UPDATE `androiduser` SET `appr`=1,status=1 WHERE AUId=".$devicesid;
$conn->query($sql);
header("Location: appreq.php");
}
?>