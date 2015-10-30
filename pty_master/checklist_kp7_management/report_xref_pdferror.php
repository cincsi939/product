<?
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "check_xref_pdf"; 
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


$db_system = "competency_system";

function CountPdfXref(){
	global $db_system;
	$sql = "SELECT count(siteid) as num1,siteid FROM `log_check_pdf`  group by siteid ORDER BY siteid";
	$result = mysql_db_query($db_system,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	return $arr;
}//end function CountPdfXref(){
function xShowArea($get_siteid){
	global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	///echo "::: ";$rs[secname];
	return $rs[secname];
}// function xShowArea($get_siteid){
function xShowSchool($get_schoolid){
	global $dbnamemaster;
	$sql = "SELECT office FROM allschool WHERE id='$get_schoolid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
		
}//end function xShowSchool(){
function xCountCheckKp7(){
	global $dbname_temp;
	$sql = "SELECT COUNT(idcard) as num1, siteid FROM tbl_checklist_kp7 GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr1[$rs[siteid]] = $rs[num1];
	}//end 	while($rs = mysql_fetch_assoc($result)){
		return $arr1;
}//end function xCountCheckKp7(){

?> 



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>รายงานการตรวจสอบไฟล์ pdf error Xref</title>
</head>
<body>
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A5B2CE"><strong>รายงานจำนวนไฟล์ pdf ที่มีปัญหา</strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="34%" align="center" bgcolor="#A5B2CE"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="33%" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
        <td width="26%" align="center" bgcolor="#A5B2CE"><strong>จำนวนไฟล์ pdf ที่มีปัญหา</strong></td>
      </tr>
      <?
     $arrxref =  CountPdfXref();
	 $arrnum1 = xCountCheckKp7();
	 if(count($arrxref) > 0){
		 $k=0;
		 foreach($arrxref as $key => $val){
			  if ($k++%  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="left"><?=xShowArea($key);?></td>
        <td align="center"><?=$arrnum1[$key]?></td>
        <td align="center"><? if($val > 0){ echo "<a href='?action=view&xsiteid=$key'>$val</a>";}else{ echo $val;}?></td>
      </tr>
      <?
		 }//end foreach(){
	 }//end  if(count($arrxref) > 0){
	  ?>
    </table></td>
  </tr>
</table>
<?
}//end if($action == ""){
else if($action == "view"){
	$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.prename_th,
edubkk_checklist.tbl_checklist_kp7.name_th,
edubkk_checklist.tbl_checklist_kp7.surname_th,
edubkk_checklist.tbl_checklist_kp7.schoolid
FROM
competency_system.log_check_pdf
Inner Join edubkk_checklist.tbl_checklist_kp7 ON competency_system.log_check_pdf.idcard = edubkk_checklist.tbl_checklist_kp7.idcard
WHERE
competency_system.log_check_pdf.siteid =  '$xsiteid' ORDER BY schoolid asc";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#A5B2CE"><strong><a href="?action=">ย้อนกลับ</a>  || รายการไฟล์ pdf ที่มีปัญหา  <? echo xShowArea($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="23%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
        <td width="23%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ นามสกุล</strong></td>
        <td width="28%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงานสังกัด</strong></td>
        <td width="19%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
      <?
      	$result = mysql_db_query($dbname_temp,$sql);
		$k=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($k++%  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $path_n = "../../../".PATH_KP7_FILE."/$xsiteid/";
			 $file_pdf = $path_n.$rs[idcard].".pdf";
			if(is_file($file_pdf)){
				$link_file = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";	
			}else{
				$link_file = "";	
			}
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><? echo $rs[idcard];?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo xShowSchool($rs[schoolid]);?></td>
        <td align="center"><?=$link_file?></td>
      </tr>
      <?
		}// end 
	  ?>
    </table></td>
  </tr>
</table>
<?
}//end else if($action == "view"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>