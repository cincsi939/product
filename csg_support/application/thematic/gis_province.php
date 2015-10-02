<?php
$nochecklogin=true;
header("Content-Type: text/html; charset=TIS-620");
include("../../config/config_epm.inc.php");
include('service/service_function.php');
$db_name = getDataBase();
$tbl_name = getTable();
#========= Set Config ============#

$strSQL = "SELECT ccDigi,g_point,partid FROM ".$tbl_name." WHERE `ccType` = 'Changwat'  AND `ccDigi` ='".$mapid."' ";
$Fetch = mysql_db_query($db_name, $strSQL) or die($strSQL.':'.mysql_error());
$Result = mysql_fetch_assoc($Fetch);
$arrArea[] = $Result['ccDigi'];
$arrTargetData[$Result['ccDigi']] = '100';
$arrProductData[$Result['ccDigi']] = '99';

$g_point = explode(',', $Result['g_point']);
$latitude = $g_point[1];
$longitude = $g_point[0];
$focus = $g_point[1].','.$g_point[0];
$partid = $Result['partid'];

$strSQLP = "SELECT ccDigi FROM ".$tbl_name."
						WHERE `ccType` = 'Changwat'
						AND `partid` ='".$partid."'";
$FetchP = mysql_db_query($db_name, $strSQLP) or die($strSQLP.':'.mysql_error());
while( $ResultP = mysql_fetch_assoc($FetchP) ) {
	if($Result['ccDigi'] != $ResultP['ccDigi']){
		$arrArea[] = $ResultP['ccDigi'];
		$arrTargetData[$ResultP['ccDigi']] = '100';
		$arrProductData[$ResultP['ccDigi']] = '40';
	}
}

$height = ($_GET['height'])?$_GET['height']:350;
$zoom = ($_GET['zoom'])?$_GET['zoom']:7;

if($_GET['hrefurl'] != ''){
	//$hrefurl = '../../reportbuilder_dcy/report_preview.php?id=419';
	$hrefurl = $_GET['hrefurl'];
}else{
	$hrefurl = '#';
}
$hrefurl = '';
foreach ($_GET as $keyget=>$urlget) {
		if($keyget != 'mapid'){
			$hrefurl .= '&'.$keyget.'='.$urlget;
		}
}
$hrefurl = str_replace('&hrefurl=','',$hrefurl);
$hrefurl = base64_encode($hrefurl);
//echo $hrefurl;
$type_page = 'province_id';
#========= Set Config ============#

$countArea = count($arrArea);
$intArea = 0;
$categories = '';
$dataset = '';
foreach($arrArea as $k=>$areaid){

		$categories .= $areaid.(($intArea<$countArea)?'|':'');
		$datatarget  .= $arrTargetData[$areaid].(($intArea<$countArea)?'|':'');
		$dataset  .= $arrProductData[$areaid].(($intArea<$countArea)?'|':'');
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
