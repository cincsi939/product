<?
session_start();
set_time_limit(0);
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
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");



	function xShowAreaSort($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_area[secname]);
	}//end function ShowAreaSort($get_secid){
	
###  ฟังก์ชั่นแสดงหน่วยงาน
	function xshow_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){





##############################  ทำการบันทึกข้อมูล ไฟล์ ก.พ. 7 ต้นฉบับ
if($_SERVER['REQUEST_METHOD'] == "POST"){
/*	echo "<pre>";
	print_r($_POST);*/
	
		$file_path = "../../../checklist_kp7file/$sentsecid/";
		$xfile = $file_path.$idcard.".pdf";
		if(is_file($xfile)){
			
			@unlink($xfile);	
			SaveLogUnlinkFile($idcard,$sentsecid,"check_kp7_popup_delete.php",$xfile,$profile_id);
		}
	$sql_del = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
	//echo $sql_del;die;
	$result_del = mysql_db_query($dbname_temp,$sql_del);
	
	
	if($result_del){
		insert_log_import($sentsecid,$idcard,"ลบข้อมูลในchecklist","1",$_SESSION['session_staffid'],"","","",$profile_id,$comment_delete);
		insert_log_checklist_last($sentsecid,$idcard,"ลบข้อมูลในchecklist","1",$_SESSION['session_staffid'],"","","",$profile_id,$comment_delete);
		if($action == "form_search"){
		echo "<script language=\"javascript\">alert('ลบรายการเรียบร้อยแล้ว');
window.opener.location='../../../change_idcard/$xfilename?action=$action&lv=$lv&sentsecid=$sentsecid&idcard=$idcard&search=$search&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&schoolid=$schoolid&xsiteid=$xsiteid&profile_id=$profile_id&s_idcard=$s_idcard&s_name=$s_name&s_surname=$s_surname';
window.close();
</script>";
		}else{
			echo "<script language=\"javascript\">alert('ลบรายการเรียบร้อยแล้ว');
window.opener.location='$xfilename?action=$action&lv=$lv&sentsecid=$sentsecid&idcard=$idcard&search=$search&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&schoolid=$schoolid&xsiteid=$xsiteid&profile_id=$profile_id&s_idcard=$s_idcard&s_name=$s_name&s_surname=$s_surname';
window.close();
</script>";	
		}
exit();
	}
	
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
	

	

?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="../../common/script_event.js"></script>
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
<script language="javascript">
	function CheckF(){
		if(document.form1.comment_delete.value == ""){
				alert("กรุณาใส่หมายเหตุการลบด้วย");
				document.form1.comment_delete.focus();
				return false;
		}
		if(document.form1.comment_delete.value.length < 10){
			alert("หมายเหตุที่ใส่มีข้อความน้อยเกินไป กรุณาระบุเหตุผลการลบมากกว่านี้")
			document.form1.comment_delete.focus();
			return false;	
		}
		
	return true;
}
</script>
</head>
<body>
<?
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CheckF()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" align="center" bgcolor="#CCCCCC"><img src="../../images_sys/attention.png" width="30" height="30"></td>
              <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC"><strong>ฟอร์มยืนยันการลบข้อมูลใน checklist</strong></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน : </strong></td>
              <td width="71%" align="left" bgcolor="#FFFFFF"><?=$rs[idcard]?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[position_now]";?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>สังกัดหน่วยงาน :</strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo xShowAreaSort($rs[siteid])."/".xshow_school($rs[schoolid]);?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><span class="main"><strong>*</strong></span><strong>หมายเหตุ :</strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <textarea name="comment_delete" id="textarea" cols="50" rows="5"></textarea></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">
                <input type="submit" name="button" id="button" value="บันทึก">
                <input type="button" name="btnc" id="btnc1" value="ปิดหน้าต่าง" onClick="window.close();">
                <input type="hidden" name="idcard" value="<?=$rs[idcard]?>">
                <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
                <input type="hidden" name="fullname" value="<?=$fullname?>">
                <input type="hidden" name="search" value="<?=$search?>">
                <input type="hidden" name="key_name" value="<?=$key_name?>">
                <input type="hidden" name="key_surname" value="<?=$key_surname?>">
                <input type="hidden" name="key_idcard" value="<?=$key_idcard?>">
                <input type="hidden" name="schoolid" value="<?=$schoolid?>">
                <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                <input type="hidden" name="action" value="<?=$action?>">
                <input type="hidden" name="lv" value="<?=$lv?>">
                <input type="hidden" name="xfilename" value="<?=$xfilename?>">
                </td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
