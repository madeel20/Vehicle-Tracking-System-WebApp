<?php 
if($_GET['key'] == '1234'){
$user = $_GET['username'];
$pass = $_GET['password'];
$cdate = $_GET['cdate'];
	include 'connection.php';
	$conn = new MySQLi($server,$username,$password,$dbname);
$sql = "select * from androiduser where Username='".$user."'";
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
die("Username already Exists!");
exit();
}
else{
    
	$sql ="INSERT INTO `androiduser`( `Username`, `Pass`, `CDate`,status,appr) VALUES ('".$user. "','".$pass. "','".$cdate. "',1,0)";
	
	echo $conn->error;
	if($conn->query($sql) == true){
	    
	$sql = "select  * from androiduser where Username like '".$user."'";
	$result = $conn->query($sql); 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$auid= $row['AUId'];
	
		}
		$pass =  randomPassword();
		$sql = "INSERT INTO `webandruser`( `Username`, `Pass`, `AUId`) VALUES ('web_".$user. "','".$pass. "',".$auid. ")";
		if($conn->query($sql) == true){
			$sql = "create TABLE tblUser_".$user."(
    id int AUTO_INCREMENT PRIMARY KEY,
   lat varchar(20),
    lon varchar(20),
    tm time ,
    dt  date)";
	if($conn->query($sql) == true){
$sql = "INSERT INTO `locations`(`AUId`, `Latitude`, `Longtitude`, `lastupdated`) VALUES (".$auid.",'','','0000-00-00')";
		if($conn->query($sql) == true){
echo "1";
} else echo $conn->error;
	} else echo $conn->error;
	
		} else echo $conn->error;
	}
	else echo $conn->error;
}
}
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}	

?>