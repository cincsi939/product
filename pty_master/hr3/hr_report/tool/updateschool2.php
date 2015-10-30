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
function stripnull($s){
	if ($s == "NULL") $s = "";
	return $s;
}



$i			= 0;
//$sql		= " select * from smis_matchschool where id is not null or id <> ''; ";
$sql		= " select * from smis_matchschool where en_name is null and schoolid > '';";
$result	= mysql_query($sql)or die(" line : " . __LINE__ . "<hr>".mysql_error());
while($rs = mysql_fetch_assoc($result)){
	$i += 1; 
		
	$result2 = mysql_query("select * from smis.dba_mas_schoolmst where SCHOOLID='$rs[schoolid]';");
	$rs2 = mysql_fetch_assoc($result2);

	$result3 = mysql_query("select * from smis.dba_schooldtl where schoolid='$rs[schoolid]';");		
	$rs3 = mysql_fetch_assoc($result3);

	$tamid = stripnull($rs2[tumbolid]);
	$ampid = substr($tamid,0,4);

	$en_name = stripnull($rs2[SCHOOLNAMEEN]);
	$shortname = stripnull($rs3[shortname]);
	$homeno = stripnull($rs2[HOMENO]);
	$moo = stripnull($rs2[MOO]);
	$street = stripnull($rs2[STREET]);
	$postcode = stripnull($rs2[POSTCODE]);
	$edate = stripnull($rs2[ESTABLISHDATE]);
	$secid = stripnull($rs2[EDUCATIONAREAID]);
	$orgid=stripnull($rs2[orgid]);
	$email=stripnull($rs3[email]);
	$url=stripnull($rs3[url]);
	$geoid = stripnull($rs3[geoid]);
	$guard_id = stripnull($rs3[guardianshipid]);
	$guard_name = stripnull($rs3[guardianshipname]);
	$etype_id = stripnull($rs3[educationtypeid]);

	$sql = "update smis_matchschool set en_name='$en_name',shortname='$shortname',homeno='$homeno',moo='$moo',street='$street', postcode='$postcode',ampid='$ampid',tamid='$tamid', establish_date='$edate',secid='$secid',orgid='$orgid',email='$email',url='$url', guardianship_id='$guard_id',guardianship_name='$guard_name',geoid='$geoid',education_type_id='$etype_id' where schoolid='$rs[schoolid]' ;";
	echo "$sql<br>";
	mysql_query($sql);
	
}
mysql_free_result($result);
?>

<? //include("http://58.147.20.42/cmss_cms2/licence_inc.php"); ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>