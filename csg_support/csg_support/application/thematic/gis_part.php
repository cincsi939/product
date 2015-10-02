<?php
$nochecklogin=true;
header("Content-Type: text/html; charset=TIS-620");
include("../../config/config_epm.inc.php");
include('service/service_function.php');
$db_name = getDataBase();

#========= Set Config ============#
if($mapid != ''){
	$wherePart = " WHERE `partid` ='".$mapid."' ";
}else{
	$wherePart = "";
}
$strSQL = "SELECT partid AS ccDigi FROM `area_part` ".$wherePart;
$Fetch = mysql_db_query($db_name, $strSQL) or die($strSQL.':'.mysql_error());
while( $Result = mysql_fetch_assoc($Fetch) ) {
	$arrArea[] = $Result['ccDigi'];
	#Set Value
	$arrTargetData[$Result['ccDigi']] = '100';
	$arrProductData[$Result['ccDigi']] = '40';
}

if($wherePart!=''){
	$strSqlPart = "SELECT partid AS ccDigi, g_point FROM `area_part` ".$wherePart;
	$FetchPart = mysql_db_query($db_name, $strSqlPart) or die(mysql_error());
	$ResultPart = mysql_fetch_assoc($FetchPart);
	$g_point = explode(',', $ResultPart['g_point']);
	$latitude = $g_point[1];
	$longitude = $g_point[0];
	$focus = $g_point[1].','.$g_point[0];
}else{
	$focus = '14.954730603695,102.110529076134';
}

$height = ($_GET['height'])?$_GET['height']:350;
$zoom = ($_GET['zoom'])?$_GET['zoom']:6;
if($_GET['hrefurl'] != ''){
	//$hrefurl = '../../reportbuilder_dcy/report_preview.php?id=419';
	$hrefurl = $_GET['hrefurl'];
}else{
	$hrefurl = '#';
}
//echo $hrefurl;
$hrefurl = '';
foreach ($_GET as $keyget=>$urlget) {
		if($keyget != 'mapid'){
			$hrefurl .= '&'.$keyget.'='.$urlget;
		}
}
$hrefurl = str_replace('&hrefurl=','',$hrefurl);
$hrefurl = base64_encode($hrefurl);
//echo $hrefurl;
$type_page = 'part_id';
#========= Set Config ============#

$countArea = count($arrArea);
$intArea = 0;
$categories = '';
$dataset = '';
foreach($arrArea as $k=>$areaid){

		$categories .= $areaid.(($intArea<$countArea)?'|':'');
		$datatarget  .= $arrTargetData[substr($areaid,0,6)].(($intArea<$countArea)?'|':'');
		$dataset  .= $arrProductData[substr($areaid,0,6)].(($intArea<$countArea)?'|':'');
		$intArea++;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>Map Key Data</title>
<link href="css/map_keydata.css?t=<?php echo time();?>" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="title_name"></div>
<center>
<iframe class="box_sys" src="service/map_service.php?categories=<?php echo $categories;?>&datatarget=<?php echo $datatarget;?>&dataset=<?php echo $dataset;?>&focus=<?php echo $focus;?>&zoom=<?php echo $zoom;?>&type_page=<?php echo $type_page;?>&hrefurl=<?php echo $hrefurl;?>" width="99%" height="<?php echo $height;?>" frameborder="0"></iframe>
</center>
</body>
</html>
