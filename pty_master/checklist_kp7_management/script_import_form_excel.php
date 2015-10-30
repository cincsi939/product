<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_import_excel"; 
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


include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");
$time_start = getmicrotime();
### function ตรวจสอบเลขบัตรซ้ำกับเขตอื่น
function check_replace($get_secid,$get_idcard,$get_prename,$get_name,$get_surname){
	global $dbnamemaster;
	$sql_r = "SELECT siteid,prename_th,name_th,surname_th FROM view_general WHERE CZ_ID='$get_idcard'";
	$result_r = mysql_db_query($dbnamemaster,$sql_r);
	$rs_r = mysql_fetch_assoc($result_r);
	
	if($rs_r[siteid] != $get_secid){
		if(($rs_r[name_th] == $get_name) and ($rs_r[surname_th] == $get_surname)){
			$num_r = 0;
		}else{
			$num_r = 1;
		}
	}else{
		if(($rs_r[name_th] == $get_name) and ($rs_r[surname_th] == $get_surname)){
			$num_r = 0;
		}else{
			$num_r = 1;
		}
	}
	
	return $num_r;
}// end function check_replace(){


function show_school($get_siteid,$get_icode){
	global $dbnamemaster;
	$sql_school = "SELECT office FROM allschool WHERE i_code='$get_icode' AND siteid = '$get_siteid'";
	$result_school = mysql_db_query($dbnamemaster,$sql_school);
	$rs_school = mysql_fetch_assoc($result_school);
	return $rs_school[office];
}// end function show_school($get_siteid,$get_icode){

function check_person_now($get_siteid,$get_idcard){
global $dbname_temp;
	$xsql1 = "SELECT COUNT(idcard) AS num2 FROM tbl_check_data WHERE idcard='$get_idcard' AND secid='$get_siteid'  ";
	//echo $sql1."<br>";
	$xresult1 = mysql_db_query(DB_CHECKLIST,$xsql1);
	$xrs1 = mysql_fetch_assoc($xresult1);
	return $xrs1[num2];
}

function check_idreplace($get_idcard){
	global $dbname_temp;
	$sql_check1 = "SELECT COUNT(idcard) AS num1 FROM check_data_l1 WHERE idcard='$get_idcard'";
	$result_check1 = mysql_db_query($dbname_temp,$sql_check1);
	$rs1 = mysql_fetch_assoc($result_check1);
	return $rs1[num1];
}

#### function เพื่อ return รหัสคำนำหน้าชื่อ
	function show_precode($get_prename){
		global $dbtemp_pobec;
		$sql = "SELECT * FROM prencode WHERE PRE_NAME='$get_prename' OR PRE_NAM='$get_prename'";
		$result = mysql_db_query($dbtemp_pobec,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[SUR_CODE];
	}
	
## function return รหัสตำแหน่งใน pobec
	function show_poscode($get_postion){
	global $dbtemp_pobec,$dbnamemaster;
	$sql = "SELECT
temp_pobec_import_checklist.postcode.POST_CODE
FROM
edubkk_master.hr_addposition_now
Inner Join temp_pobec_import_checklist.postcode ON edubkk_master.hr_addposition_now.pid = temp_pobec_import_checklist.postcode.pid
WHERE
edubkk_master.hr_addposition_now.`position` =  '$get_postion'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);

		return $rs[POST_CODE];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
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
        <td colspan="3" bgcolor="#9FB3FF"><strong>เครื่องมือตรวจสอบความถูกต้อง ข้อมูลก.พ.7 </strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
        <td width="81%" align="center" bgcolor="#9FB3FF"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="14%" align="center" bgcolor="#9FB3FF"><strong>ตรวจสอบ</strong></td>
        </tr>
		<?
			$sql = "SELECT * FROM eduarea WHERE status_area53='1' ORDER BY secname  ASC";
			$result = mysql_db_query($dbnamemaster,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center"><a href="?action=check_data&xsecid1=<?=$rs[secid]?>">ตรวจสอบข้อมูล</a></td>
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
	if($action == "check_data"){
	$dbtemp_pobec = "temp_pobec_import_checklist";
		//$db_site = "cmss_$secid";
		$sql_secname = "SELECT * FROM eduarea where secid='$xsecid1'";
		$result_secname = mysql_db_query($dbnamemaster,$sql_secname);
		$rs_s = mysql_fetch_assoc($result_secname);
		
		$sql_check = "SELECT * FROM check_data_l1 WHERE siteid='$xsecid1' ";
		//echo $sql_check;
		$result_check = mysql_db_query($dbname_temp,$sql_check);
		$i=0;
		while($rs_c = mysql_fetch_assoc($result_check)){
						## เดือนที่เกิด
			if(strlen($rs_v[cmonb]) != 2){
				$birth_month = "0".$rs_v[cmonb];
			}else{
				$birth_month = $rs_v[cmonb];
			}
			##  เดือนที่เริ่มปฏิบัติราชการ
			if(strlen($rs_v[cmonf] != "")){
				$begin_month = "0".$rs_v[cmonf];
			}else{
				$begin_month = $rs_v[cmonf];
			}
			####  วันเกิด
			if($rs_v[cdayb] != "" and $rs_v[cmonb] != "" and $rs_v[cyearb] != ""){
				$birthday = ($rs_v[cdayb]-543)."-$birth_month-$rs_v[cyearb]"." 00:00:00";
			}else{
				$birthday = "";
			}
			### วันเริ่มปฏิบัตราชการ
			if($rs_v[cdayf] != "" and $rs_v[cmonf] != "" and $rs_v[cyearf] != ""){
				$begindate = ($rs_v[cdayf]-543)."-$begin_month-$rs_v[cyearf]"." 00:00:00";
			}else{
				$begindate = "";
			}
		#############   บันทึกใน pboce
			@mysql_db_query($dbtemp_pobec,"TRUNCATE pobec_$xsecid1");
			$sur_code = show_precode($rs_v[prename_th]);
			$post_code = show_poscode($rs_v[position_now]);
			$sql_insert = "INSERT INTO pobec_$xsecid1 SET IDCODE='$rs_v[idcard]', I_CODE='$rs_v[i_code]', SUR_CODE='$sur_code', POST_CODE='$post_code', NAME1='$rs_v[name_th]', NAME2='$rs_v[surname_th]', DATE_B='$birthday',DATE_F='$begindate',O_POSITION='$rs_v[position_now]' ";
			$result_insert = mysql_db_query($dbtemp_pobec,$sql_insert);
			$i++;

		}//end while($rs_c = mysql_fetch_assoc($result_check)){

	echo "<script>alert('นำเข้าข้อมูลเรียบร้อย จำนวน $i รายการ ');location.href='?action=';</script>";
	}//edn if($action == "check_data"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>