<?php 
session_start();
if(isset($_SESSION['name']) == false){
	header("Location: index.php");
}
if($_POST['dt'] == "" ){
	header("Location: Location.php");
}
$name = $_SESSION['name'];
$deviceid = $_SESSION['AUId'];
if($_POST['tm'] == ""){
include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
if(isset($_SESSION['uname']))
$nm = $_SESSION['uname'];
else
$nm = $_SESSION['name'];
$sql = "select * from tblUser_".substr($nm,4)." where dt like '".$_POST['dt']."'";
	$result = $conn->query($sql);
	$points = array();
	if($result->num_rows >0) 
	while($row = $result->fetch_assoc()){
		$loc = array($row['lat'],$row['lon'],$row['tm']);
		array_push($points,$loc);
	}
	 //echo json_encode($points);
}
else {
	include 'connection.php';
$conn = new mysqli($server,$username,$password,$dbname);
if(isset($_SESSION['uname']))
$nm = $_SESSION['uname'];
else
$nm = $_SESSION['name'];
$sql = "select * from tblUser_".substr($nm,4)." where id=".$_POST['tm'];
	$result = $conn->query($sql);
	$points = array();
	if($result->num_rows >0) 
	while($row = $result->fetch_assoc()){
		$loc = array('lat'=>$row['lat'],'lng'=>$row['lon'],'name'=>$row['tm']);
		array_push($points,$loc);
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
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJ5gViGoNX8KeyCnKU0dToFkoJdfPjziI&libraries=geometry"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdawpoYgnQI8EBFTDBgK7q_JslipmhrPE&libraries=geometry"></script> 
    <script>
 var stations = '<?php echo json_encode($points); ?>'; <!--'[{"address":{"address":"plac Grzybowski, Warszawa, Polska","lat":"52.2360592","lng":"21.002903599999968"},"title":"Warszawa"},{"address":{"address":"Jana Paw\u0142a II, Warszawa, Polska","lat":"52.2179967","lng":"21.222655600000053"},"title":"Wroc\u0142aw"},{"address":{"address":"Wawelska, Warszawa, Polska","lat":"52.2166692","lng":"20.993677599999955"},"title":"O\u015bwi\u0119cim"}]';-->
//var MapPoints = '[{"address":{"address":"plac Grzybowski, Warszawa, Polska","lat":"52.2360592","lng":"21.002903599999968"},"title":"Warszawa"},{"address":{"address":"Jana Paw\u0142a II, Warszawa, Polska","lat":"52.2179967","lng":"21.222655600000053"},"title":"Wroc\u0142aw"},{"address":{"address":"Wawelska, Warszawa, Polska","lat":"52.2166692","lng":"20.993677599999955"},"title":"O\u015bwi\u0119cim"}]';
  function initMap() {
     
    var service = new google.maps.DirectionsService;
    var map = new google.maps.Map(document.getElementById('map'), {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scrollwheel: false,
      zoom:12
    });

    // list of points
     stations = jQuery.parseJSON(stations);
     // map.setCenter(new google.maps.LatLng(stations[0][1],stations[0][0] )); 
    // Zoom and center map automatically by stations (each station will be in visible map area)
    var lats = stations.map(function(station) { return station[0]; });
    var lngs = stations.map(function(station) { return station[1]; });
   
    map.fitBounds({
        west: Math.min.apply(null, lngs),
        east: Math.max.apply(null, lngs), 
        north: Math.min.apply(null, lats),
        south: Math.max.apply(null, lats),
    });

    // Show stations on the map as markers
   
       
            new google.maps.Marker({
            position: new google.maps.LatLng(stations[0][0], stations[1][1]),
            map: map,
            title: stations[0][2],
            label: stations[0][2],
        });
         new google.maps.Marker({
            position: new google.maps.LatLng(stations[stations.length-1][0], stations[stations.length-1][1]),
            map: map,
            title: stations[stations.length-1][2],
            label: stations[stations.length-1][2],
        });
        
            
        
        
    

    // Divide route to several parts because max stations limit is 25 (23 waypoints + 1 origin + 1 destination)
    for (var i = 0, parts = [], max = 25 - 1; i < stations.length; i = i + max)
        parts.push(stations.slice(i, i + max + 1));

    // Service callback to process service results
    var service_callback = function(response, status) {
        if (status != 'OK') {
            console.log('Directions request failed due to ' + status);
            return;
        }
        var renderer = new google.maps.DirectionsRenderer;
        renderer.setMap(map);
        renderer.setOptions({ suppressMarkers: true, preserveViewport: true });
        renderer.setDirections(response);
    };

    // Send requests to service to get route (for stations count <= 25 only one request will be sent)
    for (var i = 0; i < parts.length; i++) {
        // Waypoints does not include first station (origin) and last station (destination)
        var waypoints = [];
        for (var j = 1; j < parts[i].length - 1; j++)
            waypoints.push({location:new google.maps.LatLng( parts[i][j][0],parts[i][j][1]), stopover: false});
            
        // Service options
        var service_options = {
            origin: new google.maps.LatLng(parts[i][0][0], parts[i][0][1]),
            destination: new google.maps.LatLng(parts[i][parts[i].length - 1][0],parts[i][parts[i].length - 1][1]) ,
            waypoints: waypoints,
            travelMode: 'WALKING' 
        };
        // Send request
        service.route(service_options, service_callback);
    }
   google.maps.event.addListener(map, 'zoom_changed', function () {
     if (map.getZoom() > 16) map.setZoom(16);
 });
  }
google.maps.event.addDomListener(window, 'load', initMap);
    </script>
  </head>
<body class="text-center">
<table class="table">
<tr>
<td align="left">
<form method="post" action="Location.php">
	<input type="submit" value="Back" class="btn btn-warning">
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

<tr>
    <td class="text-center col-sm-12"><p>Date: <?php echo $_POST['dt']; ?> </p></td></tr>
    <td  style="display:none"><?php 
if($_POST['tm'] != "")
echo '<P>Time:' .  $loc[2]. '</P>
';?></td>
    </tr>
    <tr><td colspan="2">
<div id="map" style="width:100%;min-height:390px;border: solid 1px #ccc;">
     <?php 
	if(isset($errorfornotactive)){
		echo "<br><br><center><h1 style='color:red'>".$errorfornotactive."</h1></center>";

	}
	if(isset($error)){
		
		echo "<br><br><center><h1 style='color:red'>".$error."</h1></center>";
	}
	
	
	?>
    </div>
</td>
</table>   
 </body>
</html>
