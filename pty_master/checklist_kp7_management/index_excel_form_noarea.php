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
include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
include("import_excel/function_imp.php");
$time_start = getmicrotime();
$subid = substr($xsiteid,0,1); // สพนักงานประถมจะเป็น 1 มัธยมจะเป็น 0

$arrEduSchool = GetEduareaAllschool($profile_id);
$eduarea = $arrEduSchool['eduarea'];
$allschool = $arrEduSchool['allschool'];

function CheckAreaConfig($profile_id,$siteid){
	global $dbnamemaster;
	$sql = "SELECT
eduarea_config.group_type,
eduarea_config.site,
eduarea_config.profile_id
FROM `eduarea_config`
where group_type='keydata'  and site='$siteid' and profile_id='$profile_id'";
$result = mysql_db_query($dbnamemaster,$sql);
$rs = mysql_fetch_assoc($result);
	if($rs[site] == ""){
			$sql_insert = "INSERT INTO eduarea_config SET group_type='keydata' ,site='$siteid',profile_id='$profile_id'";
			mysql_db_query($dbnamemaster,$sql_insert);
	}
}// endfunction CheckAreaConfig(){ 


if($Aaction == "process"){
	//echo "<pre>";
	//print_r($_POST);die;
		$xsiteid = $_POST['xsiteid'];
		$profile_id = $_POST['profile_id'];
		### เพิ่มเขตพื้นที่การศึกษาใหม่กรณี upload ผ่านไฟล์ excel
		 CheckAreaConfig($profile_id,$xsiteid);
		
		echo "<script>location.href='?xsiteid=$xsiteid&action=$action&profile_id=$profile_id';</script>";
		exit;
}





?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ฟอร์ม excel ในกรณีที่ไม่มีข้อมูลตั้งต้นจาก pobec</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

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
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="13%" bgcolor="#FFFFFF">ข้อมูล ณ วันที่</td>
          <td width="87%" bgcolor="#FFFFFF">
                    <select name="profile_id" id="profile_id">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 

          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">สำนักงานเขตพื้นที่การศึกษา</td>
          <td bgcolor="#FFFFFF">
            <select name="xsiteid" id="xsiteid">
            <option value="">เลือก สพท.</option>
            <?
            	$sql_edu = " SELECT * FROM $eduarea WHERE secid NOT LIKE '99%' ORDER BY secname ASC";
				$result_edu = mysql_db_query($dbnamemaster,$sql_edu);
				while($rse = mysql_fetch_assoc($result_edu)){
					if($rse[secid] == $xsiteid){ $sel = " SELECTED='SELECTED'";}else{ $sel = "";}
					echo "<option value='$rse[secid]' $sel>$rse[secname]</option>";
				}//end 
			?>
            
            </select>
		</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">
          <input type="hidden" name="action" value="process">
          <input type="hidden" name="Aaction" value="process">
          <input type="submit" name="button" id="button" value="ตกลง"></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?
	}//end if($action == ""){
	if($action == "process"){
		
?>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="left" bgcolor="#999999"><strong><a href="?action=&xsiteid=<?=$xsiteid?>&profiel_id=<?=$profile_id?>">ย้อนกลับ</a> || หมวดบริหารจัดการข้อมูลตั้งต้นก.พ.7 โดย excel ฟอร์ม 
          <?=show_area($xsiteid);?></strong></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
<!--          <tr>
            <td width="6%" align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" width="16" height="16"></td>
            <td width="94%" align="left" bgcolor="#FFFFFF"><a href="excel_class/export_excel_checklist.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">ส่งออกไฟล์ excel เพื่อเข้าไปแก้ไขเอกสาร สพป.(เขตเก่า)</a></td>
            </tr>
-->          <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" width="16" height="16"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="excel_class/export_excel_checklist_areanew.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">ส่งออกไฟล์ excel เพื่อเข้าไปตรวจสอบเอกสาร</a></td>
            </tr>
<!--          <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" alt="" width="16" height="16"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="excel_class/export_excel_checklist_org.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">gen รายชื่อโรงเรียนและรหัสโรงเรียน</a></td>
          </tr>
-->          <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/db.gif" width="14" height="15"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="import_excel/index_upload.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">นำเข้าไฟล์ excel</a></td>
            </tr>
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>หมวดรายการสร้างโฟลเดอร์ในระบบ</strong></td>
            </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="../../images_sys/folderopen.gif" width="18" height="18" border="0"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="genfolder.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>&action=process" target="_blank">คลิ๊กเพื่อสร้างโฟลเดอร์ในระบบ</a></td>
          </tr>
          <?
          	$arrrep = CheckUploadReplace($profile_id,$xsiteid);
			if(count($arrrep) > 0){
		  ?>
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>หมวดรายการยืนยันจำนวนซ้ำ</strong></td>
            </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="../../images_sys/alert.gif" width="20" height="20"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="import_excel/processxls_conf.php?profile_id=<?=$profile_id?>&xsiteid=<?=$xsiteid?>" target="_blank">มีข้อมูลซ้ำกรุณาคลิ๊กเพื่อยื่นยันข้อมูล</a>&nbsp;<img src="../../images_sys/new11.gif" width="26" height="7" border="0"></td>
          </tr>
          <?
			}	// end 	if(count($arrrep) > 0){
		  ?>
          
          
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "process"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
