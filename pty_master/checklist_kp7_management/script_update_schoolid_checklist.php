<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_update_schoolid_checklist"; 
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



include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();
### function ตรวจสอบเลขบัตรซ้ำกับเขตอื่น
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>update ข้อมูลหน่วยงาน</title>
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
<?
	if($action == ""){
?>
<table width="100%"border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td colspan="5" bgcolor="#9FB3FF"><strong>เครื่องมือตรวจสอบความถูกต้อง ข้อมูลก.พ.7 ปรับปรุงข้อมูลหน่วยงานในระบบ checklist </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
        <td width="50%" align="center" bgcolor="#9FB3FF"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="16%" align="center" bgcolor="#9FB3FF"><strong>จำนวนรายการข้อมูล<br>
          ที่ไม่สามารถ<br>
          เชื่อมโยงหน่วยงานได</strong>้</td>
        <td width="14%" align="center" bgcolor="#9FB3FF"><strong>ปรับปรุงข้อมูลในตาราง tbl_checklist_kp7</strong></td>
        <td width="16%" align="center" bgcolor="#9FB3FF"><strong>ปรับปรุงข้อมูลในตาราง<br>
        tbl_checklist_kp7_false</strong></td>
        </tr>
		<?
			$sql = "SELECT count(idcard) as num, siteid FROM tbl_checklist_kp7 where schoolid ='0' or schoolid IS NULL or schoolid = '' group by siteid";
			$result = mysql_db_query($dbtemp_check,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=show_area($rs[siteid])?></td>
        <td align="center"><?=$rs[num]?></td>
        <td align="center"><a href="?action=check_kp7&sentsecid=<?=$rs[siteid]?>">ปรับปรุงข้อมูล</a></td>
        <td align="center"><a href="?action=check_kp7_false&sentsecid=<?=$rs[siteid]?>">ปรับปรุงข้อมูล</a></td>
      </tr>
	  <?
	  	}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?
	}//end if($action == ""){
####  update ข้อมูลหน่วยงานในตาราง	tbl_checklist_kp7
if($action == "check_kp7"){
	$tbl_pobec = "pobec_".$sentsecid;
	$tbl_pobec_school = "school_".$sentsecid;
			$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.siteid,
edubkk_checklist.tbl_checklist_kp7.prename_th,
edubkk_checklist.tbl_checklist_kp7.name_th,
edubkk_checklist.tbl_checklist_kp7.surname_th,
edubkk_checklist.tbl_checklist_kp7.schoolid,
temp_pobec_import_checklist.$tbl_pobec.I_CODE,
temp_pobec_import_checklist.$tbl_pobec_school.S_NAME
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join temp_pobec_import_checklist.$tbl_pobec ON edubkk_checklist.tbl_checklist_kp7.idcard = temp_pobec_import_checklist.$tbl_pobec.IDCODE
Inner Join temp_pobec_import_checklist.$tbl_pobec_school ON temp_pobec_import_checklist.$tbl_pobec.I_CODE = temp_pobec_import_checklist.$tbl_pobec_school.I_CODE
WHERE
edubkk_checklist.tbl_checklist_kp7.schoolid =  '0' OR
edubkk_checklist.tbl_checklist_kp7.schoolid IS NULL  OR
edubkk_checklist.tbl_checklist_kp7.schoolid =  ''";
	$result = mysql_db_query($dbtemp_check,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		$arr_school = get_school($rs[I_CODE],$sentsecid);
		$schoolid = $arr_school['id'];
		if($schoolid != ""){ // กรณีมีรหัสโรงเรียน
		$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET schoolid='$schoolid' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]'";
			//echo "$sql_up<br>";
			mysql_db_query($dbtemp_check,$sql_up);
			
		} else{
			
			$xschoolid = GetSchoolByName($rs[S_NAME],$rs[siteid]);
			if($xschoolid != ""){
			$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET schoolid='$xschoolid' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]'";
			//echo "$sql_up<br>";
			mysql_db_query($dbtemp_check,$sql_up);
			}
		}// end if($schoolid != ""){
	}// end while($rs = mysql_fetch_assoc($result)){
	echo "ปรับปรุงข้อมูลเสร็จสิ้นแล้ว จำนวนที่ปรับปรุงทั้งหมด $i รายการ ";	
}// end if($action == "check_kp7"){
###   end update ข้อมูลหน่วยงานในตาราง	tbl_checklist_kp7
## ปรับปรุงข้อมูลในตาราง tbl_checklist_kp7_false
if($action == "check_kp7_false"){
		$tbl_pobec = "pobec_".$sentsecid;
		$tbl_pobec_school = "school_".$sentsecid;
		$sql = "SELECT
	edubkk_checklist.tbl_checklist_kp7_false.idcard,
	edubkk_checklist.tbl_checklist_kp7_false.siteid,
	edubkk_checklist.tbl_checklist_kp7_false.prename_th,
	edubkk_checklist.tbl_checklist_kp7_false.name_th,
	edubkk_checklist.tbl_checklist_kp7_false.surname_th,
	edubkk_checklist.tbl_checklist_kp7_false.schoolid,
	temp_pobec_import_checklist.$tbl_pobec.I_CODE,
	temp_pobec_import_checklist.$tbl_pobec_school.S_NAME
	FROM
	edubkk_checklist.tbl_checklist_kp7_false
	Inner Join temp_pobec_import_checklist.$tbl_pobec ON edubkk_checklist.tbl_checklist_kp7_false.idcard = temp_pobec_import_checklist.$tbl_pobec.IDCODE
	Inner Join temp_pobec_import_checklist.$tbl_pobec_school ON temp_pobec_import_checklist.$tbl_pobec.I_CODE = temp_pobec_import_checklist.$tbl_pobec_school.I_CODE
	WHERE
	edubkk_checklist.tbl_checklist_kp7_false.schoolid =  '0' OR
	edubkk_checklist.tbl_checklist_kp7_false.schoolid IS NULL  OR
	edubkk_checklist.tbl_checklist_kp7_false.schoolid =  ''";
	$result = mysql_db_query($dbtemp_check,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		$arr_school = get_school($rs[I_CODE],$sentsecid);
		$schoolid = $arr_school['id'];
		if($schoolid != ""){ // กรณีมีรหัสโรงเรียน
		$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET schoolid='$schoolid' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]'";
			mysql_db_query($dbtemp_check,$sql_up);
			
		} else{
			
			$xschoolid = GetSchoolByName($rs[S_NAME],$rs[siteid]);
			if($xschoolid != ""){
				$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET schoolid='$xschoolid' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]'";
			mysql_db_query($dbtemp_check,$sql_up);
			}
		}// end if($schoolid != ""){

	}// end while($rs = mysql_fetch_assoc($result)){
	echo "ปรับปรุงข้อมูลเสร็จสิ้นแล้ว จำนวนที่ปรับปรุงทั้งหมด $i รายการ ";	
}// end if($action == "check_kp7_false"){
###  end  ปรับปรุงข้อมูลในตาราง tbl_checklist_kp7_false
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>