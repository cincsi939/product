<?php

if($_GET['province_id'] != ''){
	//echo 'gis_province';
	include('gis_province.php');
}else  if($_GET['mapid'] != '' ){
	//echo 'gis_province_part';
	include('gis_province_part.php');
}else{
	//echo 'gis_part';
	include('gis_part.php');
}
?>
