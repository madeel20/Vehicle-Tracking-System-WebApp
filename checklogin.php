
<?php

if(isset($_GET['key'])){
	if($_GET['key'] == "1345"){
$user= $_GET['username'];
$pass = $_GET['password'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
$sql = "SELECT * FROM androiduser"; //query for selecting data from studentlogin table
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
		
		if($row['Username'] == $user && $row['Pass'] == $pass){
if($row['status'] == '0'){
echo "na";
}
else {
		 echo "Succeed";
}   
		}
}
	}}
	}

	
?>