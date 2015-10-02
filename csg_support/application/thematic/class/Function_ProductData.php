<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับทดสอบ
* @projectCode 56EDUBKK01
* @tor unknown
* @package core(or plugin)
* @author Pannawit (or ref. by "EDUBKK" path "/com.../....php")
* @access public/private
* @created 01/01/2014
*/
header("Content-type:application/json; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);  
require_once("../../config/conndb_nonsession.inc.php");
?>

<?php
class ProductData{
//var $dbnameuse;

function SevenDay($today,$lastday,$profile_id){ 
global $dbnameuse;
$sql="SELECT count(view_kp7approve.idcard) AS num_key, 
	  DATE(monitor_keyin.timeupdate) AS date_key
      FROM view_kp7approve 
	  INNER JOIN monitor_keyin ON view_kp7approve.idcard = monitor_keyin.idcard
      WHERE profile_id='".$profile_id."' 
	  AND DATE(monitor_keyin.timeupdate) BETWEEN  '".$lastday."' AND '".$today."'
      GROUP BY DATE(monitor_keyin.timeupdate)";
$qr = mysql_db_query($dbnameuse,$sql)or die (mysql_error());
	while($rs = mysql_fetch_array($qr)){
		$json_day[]=array( 
		"date_key"=>$rs['date_key'],
		"num_key"=>$rs['num_key']
		);	
	}
return $json_day;
}

function Today($today,$profile_id){ 
global $dbnameuse;
$sql  ="SELECT count(view_kp7approve.idcard) AS num_key, 
	  	DATE(monitor_keyin.timeupdate) AS date_key
       	FROM view_kp7approve 
		INNER JOIN monitor_keyin ON view_kp7approve.idcard = monitor_keyin.idcard
       	WHERE profile_id='".$profile_id."' AND DATE(monitor_keyin.timeupdate) = '".$today."'";
$qr = mysql_db_query($dbnameuse,$sql)or die (mysql_error());
	while($rs=mysql_fetch_array($qr)){
		$json_today[]=array(
		"num_key"=>$rs['num_key']
		);	
	}
return $json_today;
}

function AllDay($profile_id){ 
global $dbnameuse;
##COUNT(DISTINCT view_kp7approve.idcard) AS num_key, 
#15132 AS num_key,
$sql  ="SELECT 
		COUNT(DISTINCT view_kp7approve.idcard) AS num_key, 
	  	DATE(monitor_keyin.timeupdate) AS date_key
       	FROM view_kp7approve 
		INNER JOIN monitor_keyin ON view_kp7approve.idcard = monitor_keyin.idcard
       	WHERE profile_id='".$profile_id."'";
$qr = mysql_db_query($dbnameuse,$sql)or die (mysql_error());
	while($rs=mysql_fetch_array($qr)){
		$json_allday[]=array(
		"num_key"=>$rs['num_key']
		);	
	}
return $json_allday;
}
}
?>
