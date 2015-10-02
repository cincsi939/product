<?php
$nochecklogin=true;
include("../../../config/config_epm.inc.php");
include('service_function.php');
header("Content-type: text/xml; charset=utf-8");
$db_name = 'dcy_usermanager';
//$icon = "images/blank.png";
$icon = "images/google_maps_marker.png";

echo "<markers>";

$strSQL = "SELECT
							org_staffgroup.gid,
							org_staffgroup.groupname,
							org_staffgroup.tambon,
							org_staffgroup.amphur,
							org_staffgroup.province,
							org_staffgroup.latitude,
							org_staffgroup.longitude
						FROM org_staffgroup
						WHERE org_staffgroup.latitude!=''
						AND org_staffgroup.longitude!='' ";

//echo $db_name;
$Fetch = mysql_db_query($db_name, $strSQL) or die(mysql_error());
while( $Result = mysql_fetch_assoc($Fetch) ) {
	//print_r($Result);
	$gid = $Result['gid'];
	$latitude = $Result['latitude'];
	$longitude = $Result['longitude'];

	if($latitude != '' && $longitude != ''){

		echo '<marker ';
		echo 'name="'.parseToXML($Result['groupname']).'" ';
		echo 'lat="'. $latitude .'" ';
		echo 'lng="' . $longitude.'" ';
		echo 'shape="" ';
		echo 'shape_color="" ';
		echo 'boder_color="#FF0000" ';
		echo 'shape_opacity="0.5" ';
		echo 'icon="'.$icon.'" ';
	  echo 'identify="identify_org.php?gid='.$Result['gid'].'" ';
	  echo '/>';
	}

}//end while1

echo "</markers>";
?>
