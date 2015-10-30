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


@include("../../config/conndb_nonsession.inc.php");
include("function_check_xref.php");
$dbname_temp = DB_CHECKLIST;
$path_upload = "../../../checklist_kp7file/$xsiteid/";
$path_uploadall = "../../../checklist_kp7file/fileall/";
$path_kp7upload = "../../../".PATH_KP7_FILE."/$xsiteid/";
$kp7upload = "../../../".PATH_KP7_FILE."/";

function logUploadfile($idcard,$siteid,$profile_id){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_checklist_log_upkp7file SET idcard='$idcard',siteid='$siteid',staff_upload='".$_SESSION['session_staffid']."',profile_id='$profile_id',time_update=NOW()";
	
	mysql_db_query($dbname_temp,$sql);
		
}//end  function logUploadfile($idcard,$siteid,$profile_id){

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



function XCountPagePdf1($file){
        if(file_exists($file)) { 
		
            //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
						
                    }else { 
                          $contents = fread($handle, 1000); 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
						//echo "<pre>";
						//print_r($found);
						//$count_file = $found['1'];
                        // return $found[1]; 
                        } 
                    } 
                    $i++; 
                } //end   while (!feof($handle)) { 
				}
			}
		return $found[1];
		//fclose($handle); 
	}//end function XCountPagePdf($file){




function xRmkdir1($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}


function xgetFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

function uploadkp7file($file,$file_name,$idcard){
	global $path_uploadall;
	$file_ext 	= strtolower(xgetFileExtension($file_name));		
	if($file_ext == "pdf"){
		$filename = $path_uploadall.$idcard.".pdf";
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){
				$msg = "error";
			}else{
				$msg = "ok";	
			}
			//@unlink($file);  
			
		}//end if(is_uploaded_file($file)){ 
		
	}else{
		$msg = "error";	
	}//end if($file_ext == "pdf"){
	return $msg;
}// end function uploadkp7file($file,$file_name,$idcard){

##############################  ทำการบันทึกข้อมูล ไฟล์ ก.พ. 7 ต้นฉบับ
if($_SERVER['REQUEST_METHOD'] == "POST"){
	### ตรวจสอบการสร้างโฟล์เดอร์
	
	if(!is_dir($path_upload)){
			xRmkdir1($path_upload);
	}//end 	if(!is_dir($path_upload)){

	if(!is_dir($path_kp7upload)){
			xRmkdir1($path_kp7upload);
	}//end 	if(!is_dir($path_kp7upload)){
		
		
	$temp_idfile = substr($kp7file_name,0,-4);
	//echo $kp7file_name." ::".$temp_idfile;die;
	
	if($temp_idfile != $idcard){
			echo "<script>
alert(\"ชื่อไฟล์ที่ upload ที่เป็นเลขบัตรประชาชนไม่ตรงกับรหัสประชาชนของเจ้าของข้อมูล\");
location='?idcard=$idcard&action=$action&xsiteid=$xsiteid&lv=$lv&sentsecid=$sentsecid&schoolid=$schoolid&profile_id=$profile_id';
</script>";
		exit;

	}else{
	if($kp7file_name != ""){
		$msg = uploadkp7file($kp7file,$kp7file_name,$idcard);	
		
		if($msg == "ok"){
			$flag_up = "ok";
			$result = "นำเข้าไฟล์สมบูรณ์";	
			$filecheck = $path_uploadall.$idcard.".pdf";
			$xEncrytp = CheckFileEncrypt($filecheck); // ตรวจสอบไฟล์ที่มีปัญหาการเข้ารหัส
			
			$xPdfError = CheckFileError($filecheck); // ตรวจสอบไฟล์มีปัญหา error รึเปล่า
			
			$xRefer =   CheckXrefPdf($idcard,$xsiteid); // ตรวจสอบหา xrefer 
		
			if($xEncrytp == "ok" and $xPdfError == "ok" and $xRefer == "ok"){
				$file_dest = $kp7upload.$xsiteid."/".$idcard.".pdf";
					@copy($filecheck,$file_dest);
					if(file_exists($file_dest)){
						@chmod("$file_dest",0777);	
					$page_up=XCountPagePdf1($file_dest);
					$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$page_up' WHERE idcard='$idcard' AND siteid='$xsiteid' AND profile_id='$profile_id'";
					//echo $sql_update;die;
					mysql_db_query($dbname_temp,$sql_update);
				
					 logUploadfile($idcard,$xsiteid,$profile_id);
					
					@unlink($filecheck);
					SaveLogUnlinkFile($idcard,$xsiteid,"check_kp7_popup_upload.php",$filecheck,$profile_id);
					}
					
			}else{
					$result = "ไฟล์มีปัญหาไม่สามารถ upload ได้ อาจเป็นเพราะ version ของไฟล์หรือไฟล์เสียกรุณาตรวจสอบไฟล์ใหม่อีกครั้ง";
					$flag_up = "error";
					@unlink($filecheck);
					SaveLogUnlinkFile($idcard,$xsiteid,"check_kp7_popup_upload.php",$filecheck,$profile_id);
			}//end if($xEncrytp == "ok" and $xPdfError == "ok" and $xRefer == "ok"){
			
		}else{
			$flag_up = "error";
			$result = "ไม่สามารถ upload ไฟล์ได้";	
		}//end 
	}//end 	if($kp7file_name != ""){
		
echo "<script>
alert(\"$result\");
window.opener.location='check_kp7_area.php?action=$action&xsiteid=$xsiteid&lv=$lv&sentsecid=$sentsecid&schoolid=$schoolid&profile_id=$profile_id';
window.close();
</script>";
		exit;
	}
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
#################  end ทำการบันทึกข้อมูล ไฟล์ ก.พ. 7 ต้นฉบับ



	########### sql แสดงข้อมูลพื้นฐานตัวบุคคล
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
//	echo $dbname_temp." :: ".$sql;
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error());
	$rs = mysql_fetch_assoc($result);
	
	$file_path = "../../../".PATH_KP7_FILE."/$rs[siteid]/";
	$txt_filekp7 = $file_path.$rs[idcard].".pdf";
	if(file_exists($txt_filekp7)){
		$img_pdf = "<a href='$txt_filekp7' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
	}else{
		$img_pdf = "";	
	}
	

	

?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
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
		var idfile = document.form1.kp7file.value;
		if(idfile == ""){
				alert("กรุณาเลือกไฟล์ ก.พ. ที่จะนำเข้าระบบด้วย");
				document.form1.kp7file.focus();
				return false;
		}
	return true;
}
</script>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CheckF()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" align="left" bgcolor="#CCCCCC"><strong><img src="../../images_sys/move-file-icon.png" alt="" width="24" height="24"></strong></td>
              <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC"><strong>ฟอร์มบันทึกข้อมูลไฟล์ ก.พ.7 ต้นฉบับ</strong></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน </strong></td>
              <td width="71%" align="left" bgcolor="#FFFFFF"><?=$rs[idcard]?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล</strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง</strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[position_now]";?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>สังกัดหน่วยงาน</strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo xShowAreaSort($rs[siteid])."/".xshow_school($rs[schoolid]);?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ไฟล์ ก.พ.7</strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <input type="file" name="kp7file" id="kp7file">&nbsp; <?=$img_pdf?>
              </td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">
                <input type="submit" name="button" id="button" value="บันทึก">
                <input type="button" name="btnc" id="btnc1" value="ปิดหน้าต่าง" onClick="window.close();">
                <input type="hidden" name="xsiteid" value="<?=$rs[siteid]?>">
                <input type="hidden" name="idcard" value="<?=$rs[idcard]?>">
                <input type="hidden" name="profile_id" value="<?=$profile_id?>">
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
