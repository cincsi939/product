<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_check_data"; 
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
			$sql = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%'";
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
		//$db_site = "cmss_$secid";
		$sql_secname = "SELECT * FROM eduarea where secid='$xsecid1'";
		$result_secname = mysql_db_query($dbnamemaster,$sql_secname);
		$rs_s = mysql_fetch_assoc($result_secname);
		
		$sql_check = "SELECT * FROM check_data_l1 WHERE siteid='$xsecid1' AND status_flag = '0'";
		//echo $sql_check;
		$result_check = mysql_db_query($dbname_temp,$sql_check);
		while($rs_c = mysql_fetch_assoc($result_check)){
		//echo "$rs_c[idcard] $rs_c[name_th] $rs_c[surname_th]<br>";
			$ch_rep = check_replace($rs_c[siteid],$rs_c[idcard],$rs_c[prename_th],$rs_c[name_th],$rs_c[surname_th]);
			if(!Check_IDCard($rs_c[idcard])){
				$sql_update = "UPDATE check_data_l1 SET status_idcard='0' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
				mysql_db_query($dbname_temp,$sql_update);
			}
			if($ch_rep == 1){ // cแสดงว่าเลขบัตรไปซ้ำกับคนอื่น
				$sql_update = "UPDATE check_data_l1 SET status_replace='0' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
				mysql_db_query($dbname_temp,$sql_update);
			}
			$sq_update1 = "UPDATE check_data_l1 SET status_flag='1' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
			$result_update1 = mysql_db_query($dbname_temp,$sq_update1);
		}//end while($rs_c = mysql_fetch_assoc($result_check)){

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="left" bgcolor="#9FB3FF"><strong><a href="?action=">กลับหน้าหลัก</a></strong>&nbsp;&nbsp;<strong><?=$rs_s[secname]?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
        <td width="13%" align="center" bgcolor="#9FB3FF"><strong>รหัสบัตร</strong></td>
        <td width="16%" align="center" bgcolor="#9FB3FF"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="9%" align="center" bgcolor="#9FB3FF"><strong>วันเดือนปีเกิด</strong></td>
        <td width="10%" align="center" bgcolor="#9FB3FF"><strong>วันเริ่มปฏิบัติ<br>
          ราชการ</strong></td>
        <td width="15%" align="center" bgcolor="#9FB3FF"><strong>ตำแหน่งปัจจุบัน</strong></td>
        <td width="14%" align="center" bgcolor="#9FB3FF"><strong>หน่วยงาน</strong></td>
        <td width="6%" align="center" bgcolor="#9FB3FF"><strong>ความ<br>
          ถูกต้อง</strong></td>
        <td width="6%" align="center" bgcolor="#9FB3FF"><strong>ซ้ำภาย<br>
          ใน<br>
          checklist</strong></td>
      </tr>
		<?
		$i=0;
		$sql_view = "SELECT * FROM check_data_l1 WHERE siteid='$xsecid1'";
		$result_view = mysql_db_query($dbname_temp,$sql_view);
		while($rs_v = mysql_fetch_assoc($result_view)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 if($rs_v[status_idcard] == 0){
		 	$txt_s .= "เลขบัตรไม่ถูกต้อง ";
		 }
//		 if($rs_v[status_replace] == 0){
//		 	$txt_s .= " เลขบัตรซ้ำในระบบ";
//		 }
		 
		 	if(strlen($rs_v[cdayb]) != "2"){
				$birth_day = "0".$rs_v[cdayb];
			}else{
				$birth_day = $rs_v[cdayb];
			}
			## เดือนที่เกิด
			if(strlen($rs_v[cmonb]) != 2){
				$birth_month = "0".$rs_v[cmonb];
			}else{
				$birth_month = $rs_v[cmonb];
			}
			
			if(strlen($rs_v[cdayf]) != "2"){
				$begin_day = "0".$rs_v[cdayf];
			}else{
				$begin_day = $rs_v[cdayf];
			}
			##  เดือนที่เริ่มปฏิบัติราชการ
			if(strlen($rs_v[cmonf] != "")){
				$begin_month = "0".$rs_v[cmonf];
			}else{
				$begin_month = $rs_v[cmonf];
			}
			####  วันเกิด
			if($rs_v[cdayb] != "" and $rs_v[cmonb] != "" and $rs_v[cyearb] != ""){
				$birthday = "$birth_day-$birth_month-$rs_v[cyearb]";
			}else{
				$birthday = "";
			}
			### วันเริ่มปฏิบัตราชการ
			if($rs_v[cdayf] != "" and $rs_v[cmonf] != "" and $rs_v[cyearf] != ""){
				$begindate = "$begin_day-$begin_month-$rs_v[cyearf]";
			}else{
				$begindate = "";
			}
			
			if(check_person_now($rs_v[siteid],$rs_v[idcard]) == "1"){
				$status_data = "ข้อมูลเก่า";
			}else{
				$status_date = "ข้อมูลใหม่";
			}
			if(check_idreplace($rs_v[idcard]) > 1){
				$status_r1 = "ข้อมูลซ้ำกันภายในchecklist";
			}else{
				$status_r1 = "";
			}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs_v[idcard]?></td>
        <td align="center"><? echo "$rs_v[prename_th]$rs_v[name_th]  $rs_v[surname_th]";?></td>
        <td align="center"><?=$birthday?></td>
        <td align="center"><?=$begindate?></td>
        <td align="center"><?=$rs_v[position_now]?></td>
        <td align="center"><?=$rs_v[area]?></td>
        <td align="center"><?=$txt_s?></td>
        <td align="center"><?=$status_r1?></td>
      </tr>
		<?
			$txt_s = "";
		}//end 
		?>
    </table></td>
  </tr>
</table>
<?
	}//edn if($action == "check_data"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>