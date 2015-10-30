<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_nposition";
$module_code 		= "nposition"; 
$process_id			= "nposition";
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF;">
<tr style=" border-bottom:1px solid #FFFFFF" align="right">
    <td height="50" background="images/report_banner_01.gif"><img src="images/report_banner_03.gif" width="365" height="50" /></td>
</tr>
<tr align="right" >
    <td style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#868E94', EndColorStr='#ffffff')">&nbsp;</td>
</tr>
</table>
<table width="99%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
  <td width="6%" height="40">ลำดับ</td>
  <td width="10%">เลขบัตรประชาชน</td>
  <td width="55%">ชื่อ</td>
  <td width="15%">เลขที่ตำแหน่ง</td>
</tr>
<?

$i			= 0;
$sql		= " select id, prename_th, name_th, surname_th, idcard  from general ; ";
$result	= mysql_query($sql)or die(" line : " . __LINE__ . "<hr>".mysql_error());
while($rs = mysql_fetch_assoc($result)){
		$i += 1; 
		$pobec	= " select * from ongdat where IDCODE='$rs[idcard]'; ";
		$cmd		= mysql_query($pobec)or die(" line : " . __LINE__ . "<hr>".mysql_error()); 
		$rss		= mysql_fetch_assoc($cmd);
		

		if ($rss[N_POSITION] == ""){
			$pobec	= " select noposition as N_POSITION from salary where id='$rs[id]' order by runno desc limit 1; ";
			$cmd		= mysql_query($pobec)or die(" line : " . __LINE__ . "<hr>".mysql_error()); 
			$rss		= mysql_fetch_assoc($cmd);
		}

		if ($rss[N_POSITION] > ""){
			$bg = "#FFFFFF";
			$update2 = "update `general` set noposition='$rss[N_POSITION]' where id='$rs[id]';";
			mysql_query($update2)or die(" line : " . __LINE__ . "<hr>".mysql_error()); 

			//echo "<td align=center>Updated</td>";
		}else{
			$bg = "#FF0000";
			//echo "<td align=center>-</td>";
		}//if
		echo "
		<tr bgcolor=\"$bg\" align=\"center\">
			<td height=\"20\">".$i."</td>
			<td>&nbsp;".$rs[idcard]."</td>
    		<td align=\"left\">&nbsp;".$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]."</td>
    		<td>&nbsp;".$rss[N_POSITION]."</td>
		</tr>";
//	}
	
}
mysql_free_result($result);
?>
</table>
<? //include("http://58.147.20.42/cmss_cms2/licence_inc.php"); ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>