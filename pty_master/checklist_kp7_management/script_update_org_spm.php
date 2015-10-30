<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

set_time_limit(0);
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");


$profile_id = 4;
$time_start = getmicrotime();

function CheckSiteidConfig($xsiteid,$profile_id){
	global $dbnamemaster;
	$sql = "SELECT
allschool_math_sd.siteid
FROM
allschool
Inner Join allschool_math_sd ON allschool.id = allschool_math_sd.schoolid
WHERE
allschool.siteid =  '$xsiteid' GROUP BY allschool_math_sd.siteid";
	$result = mysql_db_query($dbnamemaster,$sql);
	$numrow = 0;
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT COUNT(*) AS num1  FROM eduarea_config WHERE group_type='keydata' and  site='$rs[siteid]' and profile_id='$profile_id' ";
		$result1 = mysql_db_query($dbnamemaster,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[num1] > 0){
				$numrow++;
		}
	}//end while($rs = mysql_fetch_assoc($result)){
		return $numrow;
}//end function CheckSiteidConfig(){
	






if($action == "process"){ // ประมวลผลรายการ
	$sql1 = "SELECT id FROM allschool WHERE siteid='$xsiteid'";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
			$sql_update = "UPDATE  tbl_checklist_kp7 SET siteid='$xsiteid' WHERE (profile_id='4' or profile_id='5')  AND schoolid='$rs1[id]'";
			//echo "$sql_update<br>";
			mysql_db_query($dbname_temp,$sql_update);
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		if(CheckSiteidConfig($xsiteid,"4") > 0){ // กรณีเขตเดิมเป็นหน่วยงานที่จะทำการตรวจสอบข้อมูลอยู่แล้ว
			$sql_config = "REPLACE INTO eduarea_config SET group_type='keydata', site='$xsiteid',profile_id='4',st_active='1'";
			mysql_db_query($dbnamemaster,$sql_config);
		}// end if(CheckSiteidConfig($xsiteid) > 0){
			
			if(CheckSiteidConfig($xsiteid,"5") > 0){ // กรณีเขตเดิมเป็นหน่วยงานที่จะทำการตรวจสอบข้อมูลอยู่แล้ว
			$sql_config = "REPLACE INTO eduarea_config SET group_type='keydata', site='$xsiteid',profile_id='5',st_active='1'";
			mysql_db_query($dbnamemaster,$sql_config);
		}// end if(CheckSiteidConfig($xsiteid) > 0){

echo "<script>alert('ปรับโครงสร้างข้อมูลเรียบร้อยแล้ว'); location.href='?action=';</script>";	exit();
		
}else if($action == "unprocess"){
		$sql1 = "SELECT
allschool_math_sd.siteid,
allschool.id
FROM
allschool
Inner Join allschool_math_sd ON allschool.id = allschool_math_sd.schoolid
WHERE
allschool.siteid =  '$xsiteid'
";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$sql_update = "UPDATE  tbl_checklist_kp7 SET siteid='$rs1[siteid]' WHERE (profile_id='4' or profile_id='5') AND schoolid='$rs1[id]'";
		mysql_db_query($dbname_temp,$sql_update);
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		
	$sql_config = "DELETE  FROM eduarea_config  WHERE  group_type='keydata' and  site='$xsiteid' and profile_id='$profile_id'";
	mysql_db_query($dbnamemaster,$sql_config);
		$sql_config = "DELETE  FROM eduarea_config  WHERE  group_type='keydata' and  site='$xsiteid' and profile_id='5'";
	mysql_db_query($dbnamemaster,$sql_config);


	echo "<script>alert('ยกเลิกปรับโครงสร้างข้อมูลเรียบร้อยแล้ว'); location.href='?action=';</script>";	exit();
	
} //end if($action == "process"){ // ประมวลผลรายการ


function NumSPM(){
global $dbname_temp,$profile_id;
	$sql = "SELECT count(idcard) as num1, siteid  FROM `tbl_checklist_kp7` where profile_id='$profile_id' and siteid NOT LIKE '99%' group by siteid;";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	
	return $arr;
}//end function NumSPM(){
	
function NumProcess(){
	global $dbname_temp;
	$sql = "SELECT siteid FROM tbl_checklist_kp7 group by siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr1[$rs[siteid]] = $rs[siteid];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr1;	
}//end function NumProcess(){
	
	
if($action == "process_monitor"){
	if($xsiteid != ""){
			$consite = " AND siteid='$xsiteid'";
	}else{
			$consite = " AND siteid LIKE '0%'";
	}//end if($xsiteid != ""){ 
	$sql = "SELECT distinct idcard,siteid FROM tbl_checklist_kp7 WHERE profile_id >= '4' $consite ";
	//echo $dbname_temp." :: ".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$sql_up = "UPDATE monitor_keyin SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]'";
			//echo "$sql_up<br>";
			mysql_db_query($dbcallcenter_entry,$sql_up);
			$sql_up1 = "UPDATE tbl_assign_key SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]' AND profile_id >= '4'";
			//echo $sql_up1."<br>";
			mysql_db_query($dbcallcenter_entry,$sql_up1);
	}//end while($rs = mysql_db_query($result)){
		
}// end if($action == "process_monitor"){
	
	
##################################################################

if($action == "process_assign"){
	
	if($xsiteid != ""){
			$consite = " AND siteid='$xsiteid'";
	}else{
			$consite = " AND siteid LIKE '0%'";	
	}
	
	
	$sql = "SELECT distinct idcard,siteid FROM tbl_checklist_kp7 WHERE profile_id >= '4'  $consite ";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){	
		$sql1 = "SELECT * FROM tbl_checklist_assign_detail WHERE idcard='$rs[idcard]' AND profile_id >= '4' ";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[ticketid] != ""){
			$sql_up1 = "UPDATE tbl_checklist_assign SET siteid='$rs[siteid]' WHERE ticketid='$rs1[ticketid]'";
			//echo $sql_up1."<br>";
			mysql_db_query($dbname_temp,$sql_up1);	
		}//end if($rs1[ticketid] != ""){
			$sql_up2 = "UPDATE tbl_checklist_assign_detail SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]' AND profile_id >= '4'";
			//echo $sql_up2."<br>";
			mysql_db_query($dbname_temp,$sql_up2);
			$sql_up3 = "UPDATE tbl_checklist_assign_log SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]'";
			//echo $sql_up3."<br>";
			mysql_db_query($dbname_temp,$sql_up3);
			$sql_up4 = "UPDATE tbl_checklist_assign_log_activity SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]'";
			//echo $sql_up4."<br>";
			mysql_db_query($dbname_temp,$sql_up4);
	
	}//end while($rs = mysql_fetch_assoc($result)){	
}//end if($action == "process_assign"){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>script ปรับโครงสร้างหน่วยงานสังกัด สพม ในระบบ checklist</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>ปรับโครงสร้างข้อมูลในระบบตรวจสอบข้อมูลตั้งต้นเป็น สพม ข้อมูล ณ 1 เม.ย. 53</strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="34%" align="center" bgcolor="#CCCCCC"><strong>สพม.</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>จำนวนใน checklist(คน)</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong><a href="?action=process_assign">ประมวลผลเป็น สพม.</a></strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ย้อนกลับเป็น สพท.เดิม</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ปรับ Auto Increment<br>
  Logข้อมูล</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong><a href="?action=process_monitor">ปรับ log monitor</a></strong></td>
      </tr>
      <?
	  	$arrnum = NumSPM();
		$arrsite = NumProcess();
      	$sql = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%'  ORDER BY  secid ASC";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			if($arrsite[$rs[secid]] != ""){
				$syl = "<font color='#009900'>*</font>";
			}else{
				$syl = "";	
			}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?>&nbsp; <a href="?action=process_assign&xsiteid=<?=$rs[secid]?>">assign checklist </a></strong><?=$syl?></td>
        <td align="center"><?	echo number_format($arrnum[$rs[secid]]);	?></td>
        <td align="center"><a href="?action=process&xsiteid=<?=$rs[secid]?>">ประมวลผล</a></td>
        <td align="center"><a href="?action=unprocess&xsiteid=<?=$rs[secid]?>">ยกเลิกการประมวลผล</a></td>
        <td align="center"><a href="../hr3/tool_competency/convertDB/SET_AUTO_INCREMENT_SUWAT_EDIT.php?sent_secid=<?=$rs[secid]?>" target="_blank">ประมวลผล</a></td>
        <td align="center"><a href="?action=process_monitor&xsiteid=<?=$rs[secid]?>">ปรับ log monitor</a></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>