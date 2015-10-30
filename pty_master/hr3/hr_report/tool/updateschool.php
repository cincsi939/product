<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_updatereport";
$module_code 		= "updatereport"; 
$process_id			= "updatereport";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
include("session.inc.php");
ob_start();
include("../../libary/function.php");
include("../../../../config/config_hr.inc.php");
include("../../../../common/common_competency.inc.php");
$time_start = getmicrotime();

//include("timefunc.inc.php");
include("../phpconfig.php");
include("../db.inc.php");
conn2DB();

function Query1($sql){
	$result = mysql_query($sql);
	$rs = mysql_fetch_array($result);
	return $rs[0];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>ข้อมูลเลขที่ตำแหน่ง</title>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>
</head>
<body>


<?

$i			= 0;
$sql		= " select * from smis_matchschool where id is not null or id <> ''; ";
$result	= mysql_query($sql)or die(" line : " . __LINE__ . "<hr>".mysql_error());
while($rs = mysql_fetch_assoc($result)){
		$i += 1; 
		
		$nteacher = Query1("select count(*) from general where positiongroup = '4' and unit='$rs[id]';");
		$nexec = Query1("select count(*) from general where positiongroup = '3' and unit='$rs[id]';");
		$ampid = Query1("select ampid from login where id='$rs[id]';");
		if ($ampid == ""){
			$tamid = Query1("select tumbolid from smis.dba_mas_schoolmst where SCHOOLID='$rs[schoolid]';");
			$ampid = substr($tamid,0,4);
		}

		$sql = "update report_quantitywork_data set j18_executive='$nexec',j18_techer='$nteacher',ampurid='$ampid' where schoolid='$rs[schoolid]';";
		echo "$sql<br>";
		mysql_query($sql);
	
}
mysql_free_result($result);
?>

<? //include("http://58.147.20.42/cmss_cms2/licence_inc.php"); ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>