
<?php 


if(isset($_POST['AUId'])){
	$deviceid = $_POST['AUId'];
	$_SESSION['AUId'] = $_POST['AUId'];
	$_SESSION['uname'] = $_POST['WUsername'];
	$_SESSION['ustatus'] = $_POST['ustatus'];
	
}
else{
$deviceid = $_SESSION['AUId'];
}
$name = $_SESSION['name'];
$lupdated ="";
if(isset($_SESSION['ustatus']) && $_SESSION['ustatus']==0){
	$errorfornotactive = "User is not Active!";
}
else {

include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
$sql = "select * from locations where AUId=".$deviceid;
	$result = $conn->query($sql);
	if($result->num_rows >0) 
	while($row = $result->fetch_assoc()){
		$latitude= $row['Latitude'];
		$Longitude= $row['Longtitude'];
		
		$lupdated = $row['lastupdated'];
	}
	else {
		$error = "Location has not been recieved yet!";
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

<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML= this.responseText;
            }
        };
        xmlhttp.open("GET","loaddates.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJ5gViGoNX8KeyCnKU0dToFkoJdfPjziI&libraries=geometry"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdawpoYgnQI8EBFTDBgK7q_JslipmhrPE&libraries=geometry"></script> 
    <script>
        var map;
        var marker1;
var y;
var x;
        function initialize() {
          x = <?php if(isset($latitude)) echo $latitude;?>;
           y = <?php if(isset($Longitude)) echo $Longitude;?>;
         
		
            var latLng = new google.maps.LatLng(x, y);
   var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        directionsDisplay.setMap(map);

            var mapProp = {
                center: latLng,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP

            };
            var icon = {
    url: 'blank.png', // url
    scaledSize: new google.maps.Size(50, 50), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
};

            map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

            marker1 = new google.maps.Marker({
                position: latLng,
                title: 'Point A',

                draggable: false,
            });
           
           marker1.setIcon(icon);
          marker1.setAnimation(google.maps.Animation.DROP);
            google.maps.event.trigger(marker1, 'dragend', {
                latLng: marker1.getPosition()
            });
            google.maps.event.addListener(map, 'zoom_changed', function () {
     if (map.getZoom() > 14) map.setZoom(14);
 });
    marker1.setMap(map);
      drawPath(directionsService, directionsDisplay,67.00,24.00);
            }
        }


         

     google.maps.event.addDomListener(window, 'load', initialize);
        
        function updateMarker(lat,lng) {
            var latLng = new google.maps.LatLng(lat, lng);
			
            marker1.setPosition(latLng);
            map.panTo(latLng);
        }
		function loadonlinepl(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				document.getElementById('lup').innerHTML = myObj.lup;
				if(myObj.lat == y && myObj.long == x){
					
				}
				else {
					
				updateMarker(myObj.lat,myObj.long);
				}
		
       
            }
        };
        xmlhttp.open("GET","loadlocation.php",true);
        xmlhttp.send();
	  
  }
 	function drawPath(directionsService, directionsDisplay,start,end) {
        directionsService.route({
          origin: start,
          destination: end,
          waypoints: waypoints,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
            directionsDisplay.setDirections(response);
            } else {
            window.alert('Problem in showing direction due to ' + status);
            }
        });
  }
 setInterval("loadonlinepl();",1000
 );
 
		
    </script>
  </head>
  <body class="text-center">
<table class="table">
    <tr>
        
        <td style="<?php 
  if($_SESSION['name'] != 'admin'){echo 'display:none;';}?>" align="left">
    <form method="post" action="admin.php">
     <input type="submit"
       value="Back" class="btn btn-warning">
</form>
</td>
<td align="right">
<form method="post" action="logout.php">
  <input type="submit" value="Log Out" class="btn btn-warning">
</form>
</td>
</tr>
<tr><td colspan="2">
<h1>Location Of: <?php 
if(isset($_SESSION['uname'])){
echo 	$_SESSION['uname'];
}
else
echo $name;
 ?> </h1>
</td></tr>
<tr><td colspan="2">
 <p><?php 
 include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
$sql = "select * from tbl_udetails where AUId=".$deviceid;
	$result = $conn->query($sql);
	if($result->num_rows >0) 
	while($row = $result->fetch_assoc()){
		echo '<b>Driver Name:</b> '.$row['firstname'].' '.$row['lastname'];
		echo '&nbsp;&nbsp;&nbsp;<b>Vehicle NO:</b> '.$row['vehicleno'];
	}
	?>
 </p>
</td></tr>
<tr><td colspan="2">
 <p><b>Last Updated:</b> <span id="lup"><?php echo $lupdated; ?> </span></p>
</td></tr>


<tr style="<?php if($_SESSION['name'] != 'admin') echo 'display:none;'; ?>"><td colspan="2">
<h4>History:</h4>
<form action="lochistory.php" method="post" >
<select onchange="showUser(this.value)" name="dt" id="Sell"> 
<option value="" selected>
Select Date</option>
<?php 
include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
if(isset($_SESSION['uname']))
$nm = $_SESSION['uname'];
else

$nm = $_SESSION['name'];
$sql = "select distinct dt from tblUser_".substr($nm,4);
$result = $conn->query($sql);
	if($result->num_rows >0) 

	while($row = $result->fetch_assoc()){
		echo '<option value="'.$row['dt'].'">'.$row['dt']."</option>";
	}
?>
</select>

<select style="display:none;" name="tm" id="txtHint" id="Sell"> 
<option value="" selected>
Select Time</option>
</select>

<input type="submit" value="Load" class="btn btn-default"/>

</form>
</td></tr>



<tr><td colspan="2">
<div id="googleMap" style="width:100%;min-height:390px;border: solid 1px #ccc;">
    <?php 
	if(isset($errorfornotactive)){
		echo "<br><br><center><h1 style='color:red'>".$errorfornotactive."</h1></center>";

	}
	if(isset($error)){
		
		echo "<br><br><center><h1 style='color:red'>".$error."</h1></center>";
	}
	
	
	?></div>
</td></tr>
</table>      
  </body>
</html>
