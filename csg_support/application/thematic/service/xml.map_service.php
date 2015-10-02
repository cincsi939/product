<?php
$nochecklogin=true;
include("../../../config/config_epm.inc.php");
include('service_function.php');
header("Content-type: text/xml; charset=utf-8");
$db_name = getDataBase();
$tbl_name = getTable();
$ac = $_GET['ac'];
$max_data = $_GET['max_data'];
$datatarget = $_GET['datatarget'];
$data = $_GET['data'];

//$icon = "images/blank.png";
$icon = "images/google_maps_marker.png";


echo "<markers>";
if(strlen($ac) == 1){
	$strSQL = "SELECT partid AS ccDigi, area_part AS ccName, '' AS ccType, g_point, g_shape FROM area_part WHERE partid='".$ac."' ";
}else{
	$strSQL = "SELECT * FROM ".$tbl_name." WHERE ccDigi='".$ac."' ";
}
//echo $db_name;
$Fetch = mysql_db_query($db_name, $strSQL) or die(mysql_error());
while( $Result = mysql_fetch_assoc($Fetch) ) {
	//print_r($Result);
	$mapid = $Result['ccDigi'];
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
		echo 'name="'.parseToXML($Result['ccName']).'" ';
		echo 'lat="'. $latitude .'" ';
		echo 'lng="' . $longitude.'" ';
		echo 'shape="'.$Result['g_shape'].'" ';
		echo 'shape_color="'.$shape_color.'" ';
		echo 'boder_color="#FF0000" ';
		echo 'shape_opacity="0.5" ';
		echo 'icon="'.$icon.'" ';
		echo 'mapid="'.$mapid.'" ';
	    echo 'identify="identify.php?data='.$data.'" ';
	  	echo '/>';
	}

}//end while1

echo "</markers>";
?>
