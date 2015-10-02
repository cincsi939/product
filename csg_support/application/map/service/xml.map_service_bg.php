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
$icon = "images/blank.png";
//$icon = "images/google_maps_marker.png";

echo "<markers>";
	echo '<marker ';  
	echo 'name="" ';
	echo 'lat="94.833984375" ';
	echo 'lng="19.145168196205297" ';
	echo 'shape="94.833984375,19.145168196205297,800.000 109.1162109375,18.68787868603421,800.000 108.9404296875,5.266007882805498,800.000 94.130859375,5.747174076651375,800.000 94.7900390625,19.062117883514652,800.000" ';
	echo 'shape_color="#FFFFFF" ';
	echo 'boder_color="#FFFFFF" ';
	echo 'shape_opacity="0.95" '; 
	echo 'icon="#" ';
	echo 'identify="#" ';
	echo '/>';

echo "</markers>";
?>
