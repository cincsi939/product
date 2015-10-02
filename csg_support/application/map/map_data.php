<?php
include('../survey/lib/class.function.php');
$con = new Cfunction();
$con->connectDB();

include("class/class_map_keydata.php");
$mapKD = new MapKeyData();

$mapKD->setDBMaster( 'question_project' );

$arrArea = $mapKD->getArea();

$countArea = count($arrArea);
$intArea = 0;
$categories = '';
$dataset = '';
foreach($arrArea as $k=>$areaid){
		$intArea++;
		$categories .= $areaid.(($intArea!=$countArea)?'|':'');
		$datatarget  .= (50).(($intArea!=$countArea)?'|':'');
		$dataset  .= (40).(($intArea!=$countArea)?'|':'');
}
	$height = ($_GET['height'])?$_GET['height']:240; 
	$zoom = ($_GET['zoom'])?$_GET['zoom']:8; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>Map Key Data</title>
<link href="css/map_keydata.css?t=<?php echo time();?>" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="title_name">สถานะการสำรวจ</div>
<center>
<iframe class="box_sys" src="service/map_service.php?categories=<?php echo $categories;?>&datatarget=<?php echo $datatarget;?>&dataset=<?php echo $dataset;?>&focus=12.1541772323455,102.524100541103&zoom=<?php echo $zoom;?>" width="99%" height="<?php echo $height;?>" frameborder="0"></iframe>
</center>
<?php
if($height == 240){
?>
<DIV style="text-align:right"><a href="map_data.php?height=580&zoom=9" target="_blank"><img src="images/more.png" align="absmiddle"/></a></DIV>
<? } ?>
</body>
</html>