<?php
$nochecklogin=true;
header("Content-Type: text/html; charset=TIS-620");
include("../../config/config_epm.inc.php");
include('service/service_function.php');
$db_name = getDataBase();
//$strSQL = "SELECT ccDigi FROM ccaa WHERE `ccType` = 'Changwat' AND `partid` = '2'  ";
$strSQL = "SELECT partid AS ccDigi FROM `area_part` WHERE `partid` IN('1','2') ";
//echo $db_name;
$Fetch = mysql_db_query($db_name, $strSQL) or die(mysql_error());
while( $Result = mysql_fetch_assoc($Fetch) ) {
	$arrArea[] = $Result['ccDigi'];
	$arrTargetData[$Result['ccDigi']] = '100';
	$arrProductData[$Result['ccDigi']] = '40';
}

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
	$height = ($_GET['height'])?$_GET['height']:350;
	$zoom = ($_GET['zoom'])?$_GET['zoom']:6;
	$focus = '14.954730603695,102.110529076134';
	$hrefurl = '../../reportbuilder_dcy/report_preview.php?id=419';
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
<iframe class="box_sys" src="service/map_service.php?categories=<?php echo $categories;?>&datatarget=<?php echo $datatarget;?>&dataset=<?php echo $dataset;?>&focus=<?php echo $focus;?>&zoom=<?php echo $zoom;?>&hrefurl=<?php echo $hrefurl;?>" width="99%" height="<?php echo $height;?>" frameborder="0"></iframe>
</center>
</body>
</html>
