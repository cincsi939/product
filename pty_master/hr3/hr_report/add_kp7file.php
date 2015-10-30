<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับทดสอบ
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core
* @author Suwat.K
* @access public/private
* @created 10/04/2014
*/
session_start();
set_time_limit(0);
$ApplicationName	= "hr_report";
$module_code 		= "add_kp7file"; 
$process_id			= "add_kp7file";
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
	## Modified Detail :		ระบบบันทึกข้อมูล ก.พ. 7
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

require_once ("../../../config/phpconfig.php");
include("../libary/function.php");
#require_once("../../../config/conndb_nonsession.inc.php");		
require_once("../../../common/common_competency.inc.php");
require_once("../../checklist_kp7_management/function_check_xref.php");
require_once("../../../common/function_upload_kp7file.php"); 
require_once("../../../common/function_add_queue_kp7.php");
$time_start = getmicrotime();
clearBrowserCache();

$siteid = trim(str_replace(STR_PREFIX_DB,"",$_SESSION[temp_dbsite]));
$dbsite = STR_PREFIX_DB.$siteid;

$path_checklist = "../../../../edubkk_checklist_kp7file/";
$path_kp7 = "../../../../edubkk_kp7file/";
$url_file = $path_kp7.$siteid."/".$id.".pdf";
if(is_file($url_file)){
	$img_pdf = 	"<a href='$url_file' target='_blank'><img src=\"../../../images_sys/gnome-mime-application-pdf.png\" title=\"แสดงเอกสาร ก.พ.7 ต้นฉบับ\" width=\"20\" height=\"20\" border=\"0\"></a>";
}else{
	$img_pdf = "";	
}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$siteid = trim(str_replace(STR_PREFIX_DB,"",$_SESSION[temp_dbsite]));
		//echo $siteid;die;
			$path_source = $path_checklist.$siteid."/"; // path ต้นทาง
			$path_dest = $path_kp7.$siteid."/"; // path ปลายทาง
			
			
			if($kp7file_name != ""){
				$sql_checklist = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$id' ORDER BY profile_id DESC LIMIT 1";
				$result_checklist = mysql_db_query($dbname_temp,$sql_checklist);
				$rsc = mysql_fetch_assoc($result_checklist);
				$page_num = CopyFileToSite($kp7file,$kp7file_name,$id,$path_source,$path_dest,$conF1);// upload ไฟล์
				$arrp1 = explode("_",$page_num);

				//echo '<pre>';print_r($arrp1);
//				echo $kp7file_name.','.$kp7file_name.','.$id.','.$path_source.','.$path_dest.','.$conF1.'<=';
//				die;
				if($arrp1[0] == "x"){
				
					$xstaff_key = $_SESSION[session_staffid];
					$xip = GET_IPADDRESS();
					$sql_log = "insert into log_upload_kp7false(idcard,siteid,server_ip,user_upload,page_false,time_upload)values('$id','$siteid','$xip','$xstaff_key','".$arrp1[1]."',NOW());";
					mysql_db_query($dbnamemaster,$sql_log);

					echo"
                <script language=\"javascript\">
                alert(\" ไม่สามารถนำเข้าได้เนื่องจากจำนวนแผ่นที่นำเข้าน้อยกว่าจำนวนแผ่นก่อนหน้า\\n \");
                </script><meta http-equiv='refresh' content='0;URL=add_kp7file.php?id=".$id."&action=edit'>
           ";
				}else{
					
					if($conF1 == "1"){
						$xstaff_key = $_SESSION[session_staffid];
						$xip = GET_IPADDRESS();
						$sql_log = "insert into log_upload_kp7false(idcard,siteid,server_ip,user_upload,page_false,time_upload,status_conf)values('$id','$siteid','$xip','$xstaff_key','".$arrp1[1]."',NOW(),'1')";
						mysql_db_query($dbnamemaster,$sql_log);	
					}
					
				//echo "page_num == ".$page_num."<br>";
				AddQueueKp7file($id,$siteid,$schoolid,$rsc[profile_id]);
				#### update checklist
				$sql_update = "UPDATE tbl_checklist_kp7 SET  page_upload='$page_num',page_num='$page_num' WHERE idcard='$id' and profile_id='$rsc[profile_id]' and siteid='$rsc[siteid]' ";
				
				mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
				//echo $sql_update;die;
				add_log("ข้อมูลไฟล์ ก.พ.7 ต้นฉบับ",$id,"add",$menu_id);	
				
				### update kp7file
				if(is_file($url_file)){
						$sql_upview = "UPDATE view_general SET flag_kp7='1',update_status='ok' WHERE CZ_ID='$id'";
						mysql_db_query($dbsite,$sql_upview) or die(mysql_error()."$sql_upview<br>".__LINE__);
						mysql_db_query($dbnamemaster,$sql_upview) or die(mysql_error()."$sql_upview<br>".__LINE__);
				}
				
				echo"
                <script language=\"javascript\">
                alert(\" Upload ไฟล์ ก.พ.7 ต้นฉบับเรียบร้อยแล้ว\\n \");
                </script>
				<meta http-equiv='refresh' content='0;URL=add_kp7file.php?id=".$id."&action=edit'>
            ";
				}//end // end if($arrp1[0] == "x"){

			}//end if($kp7file_name != ""){<meta http-equiv='refresh' content='0;URL=add_kp7file.php?id=".$id."'> <meta http-equiv='refresh' content='0;URL=add_kp7file.php'>
	
	
	
	
	}// end if($_SERVER['REQUEST_METHOD'] == "POST"){
		//echo $dbname_temp;
		
function ShowProfileNameLast($idcard){
	global $dbname_temp;
	$sql = "SELECT
	t1.profile_id,
	t2.profilename_short,
	t2.profile_date
FROM
tbl_checklist_kp7 AS t1
Inner Join tbl_checklist_profile AS t2 ON t1.profile_id = t2.profile_id
WHERE
t1.idcard =  '$idcard' order by t1.profile_id DESC LIMIT 1";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>__LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$arr['profilename'] = $rs[profilename_short];
	$arr['profiledate'] = $rs[profile_date];
	return $arr;
}

$arrp1 = ShowProfileNameLast($id);


$yy = date("Y");
$mm = date("m");
if(intval($mm) >= 1 and intval($mm) < 4){
		$date_check = ($yy-1)."-10-01";
}else if(intval($mm) >= 4  and intval($mm) < 10){
		$date_check = $yy."-04-01";
}else if(intval($mm) >= 10){
		$date_check = $yy."-10-01";
}


/*if($date_check > $arrp1['profiledate']){
		$msgA = "<font color=\"#FF0000\">ข้อมูลโฟรไฟล์น้อยกว่าฐานเวลาปัจจุบัน กรุณาติดต่อ admin</font>";
		$disx = " disabled=\"disabled\" ";
}else{
		$msgA = "";	
		$disx = "";
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>Upload ไฟล์แสกน ก.พ.7 ต้นฉบับ</title>
<style type="text/css">
<!--
.style11 {color: #8C0000}
-->
</style>
</head>
<script language="javascript" src="../../../common/js/jquery-1.8.2.js"></script>
<script>
$(document).ready(function(e) {
	$('#submit').click(function(e) {
        var txt = $('#kp7file').val();
		if(txt==''){
			alert('กรุณาเลือกไฟล์ ก.พ.7 ต้นฉบับ');
			$('#kp7file').focus();
			return false;
		}
    });
    $('#kp7file').change(function(e) {
		var uploadedFile = document.getElementById('kp7file');
		var fileSize = uploadedFile.files[0].size;
        if(!isImage($('#kp7file').val())){
			alert('เลือกไฟล์ .PDF เท่านั้น');
			$('#kp7file').val('');
			$('#kp7file').focus();
		}else if(fileSize > 20000000){
			alert('ขนาดไฟล์ต้องไม่เกิน 20Mb');
			$('#kp7file').val('');
			$('#kp7file').focus();
		}
    });
});
function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}
function isImage(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
    case 'pdf':
        //etc
        return true;
    }
    return false;
}
</script>

<body bgcolor="#f8f8f8">
<br>
<table width="90%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#dddddd">
    <td height="20"><strong>แนบเอกสาร ก.พ.7 ต้นฉบับ</strong></td>
</tr>	
<tr bgcolor="#ffffff">
    <td height="20" colspan="3">
     <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
             <tr>
               <td width="25%" align="right">เลือกไฟล์ ก.พ.7 ต้นฉบับ:</td>
               <td width="75%"> <input type="file" name="kp7file" id="kp7file" <?=$disx?>>&nbsp; <?=$img_pdf?> <?=$msgA?></td>
             </tr>
                   <?php
			 #@modify Suwat.k 06/08/2015 ตรวจสอบเงื่อนไขแสดงกรณีมีข้อมูลใน checklist เท่านั้น
			  if($arrp1[profilename] != ""){
				?>
             <tr>
               <td align="right">ข้อมูลโปรไฟล์เช็คลิส ณ วันที่ :</td>
               <td><?=$arrp1[profilename]?></td>
             </tr>
             <tr>
               <td align="right">ยืนยันกรณีไฟล์ใหม่มีจำนวนแผ่นน้อยกว่าไฟล์เก่า : </td>
               <td><input type="checkbox" name="conF1" id="conF1" value="1"></td>
             </tr>
             <?php
			  } 
			 #@end Suwat.k 06/08/2015 
			 ?>
             <tr>
               <td>&nbsp;</td>
               <td><input type="submit" name="Submit" id="submit" value="บันทึก" />
                 <input type="reset" name="Reset" id="button" value="ล้างข้อมูล" /></td>
             </tr>
           </table></td>
         </tr>
       </table>	

     </form>
	</td>
</tr>
</table>
</body>
</html>
<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>