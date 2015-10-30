<?
include("../../../config/conndb_nonsession.inc.php");

echo '<pre>';
//print_r($_SERVER);

$myserverip = $_SERVER[SERVER_ADDR];

$sql = "select eduarea.secid,eduarea.secname from area_info inner join eduarea on area_info.area_id=eduarea.area_id where area_info.intra_ip='$myserverip'";
//echo $sql;
$rs = mysql_query($sql);
while($arr = mysql_fetch_assoc($rs)){
	echo '<b>'.$arr[secname].'</b><br>';
	$rundbname = STR_PREFIX_DB. $arr[secid]   ; 
######################################################## Start add script 
	// update view general
	$sql = "

	";
	mysql_db_query( $rundbname ,$sql);
	echo mysql_error().'<br>';
	
 
# ALTER TABLE hr_prohibit   ADD `kp7_active` VARCHAR( 20 ) NOT NULL ;

######################################################## END  add script 
}
?>