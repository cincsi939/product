<?php

include('../../survey/lib/class.function.php');
$con = new Cfunction();
$con->connectDB();
include('service_function.php');
header("Content-type: text/xml; charset=utf-8"); 

$ac = $_GET['ac'];
$max_data = $_GET['max_data'];
$datatarget = $_GET['datatarget'];
$data = $_GET['data'];
$icon_arr = array("images/green.png","images/yellow.png","images/red.png");
//$icon = "images/blank.png";
//$icon = "images/google_maps_marker.png";

echo "<markers>";

	

$strSQL = "SELECT * FROM ccaa WHERE ccDigi='".$ac."' ";
$Fetch = mysql_query($strSQL) or die(mysql_error());
while( $Result = mysql_fetch_assoc($Fetch) ) {
	
	$g_point = explode(',', $Result['g_point']);
	$latitude = $g_point[1];
	$longitude = $g_point[0];
	if($latitude != '' && $longitude != ''){
		$at = $Result['ccType'];
		if($datatarget){
			$dataPercent = ($data/$datatarget)*100;
			$shape_color = getColor(100, $dataPercent);
		}else{
			$shape_color = getColor($max_data,$data);
		}
	  	echo '<marker ';  
		echo 'name="'.parseToXML($Result['ccName']).', '.$data.'" ';
		echo 'lat="'. $latitude .'" ';
		echo 'lng="' . $longitude.'" ';
		echo 'shape="'.$Result['g_shape'].'" ';
		echo 'shape_color="#fafbc0" ';
		echo 'boder_color="#FF0000" ';
		echo 'shape_opacity="1" '; 
		echo 'icon="'.$icon_arr[rand(0,2)].'" ';
	    echo 'identify="#" ';
	  	echo '/>';
	}
  
}//end while1

echo "</markers>";
?>
