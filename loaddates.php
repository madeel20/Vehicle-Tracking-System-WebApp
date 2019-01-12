<?php
session_start();
if(isset($_GET['q'])){
include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/

$con = new mysqli($server, $username, $password,$dbname);// this create connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
if(isset($_SESSION['uname']))
$nm = $_SESSION['uname'];
else
$nm = $_SESSION['name'];
$sql = "select id,tm from tblUser_".substr($nm
,4)." where dt like '".$_GET['q']."'";
$result = $con->query($sql)or die($con->error);
echo '<option value="" selected>
Select Time</option>';
while($row = $result->fetch_assoc()){
    
    echo "<option value='".$row['id']."'>" . $row['tm'] . "</option>";
}
mysqli_close($con);

}
?>
