<?
//include ("session.inc.php");
session_start();
include ("../../../config/phpconfig.php");
include("pic_function.php");
include("../../../common/function_kp7_logerror.php");
include 'uploadresize/UploadFileImage.php';
$menu_id = "2";
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
function deletedir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           deletedir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
}
function makefoldertemp($folder,$file_name,$id){
	if (!file_exists($folder.'x1_'.$id.'_temp')) {
		mkdir($folder.'x1_'.$id.'_temp', 0777, true);
		mkdir($folder.'x1_'.$id.'_temp/thumbnail', 0777, true);		
		$chkfiles = glob($folder.'x1_'.$id.'_temp/thumbnail/*');
			if(empty($chkfiles)){
					if (!copy($folder.$file_name,$folder.'x1_'.$id.'_temp/'.$file_name)){	 
						echo 'error copy';
					}	
					if (!copy($folder.$file_name,$folder.'x1_'.$id.'_temp/thumbnail/'.$file_name)){	 
						echo 'error copy';
					}
			}
	}
	else{
		$chkfiles = glob($folder.'x1_'.$id.'_temp/thumbnail/*');
			if(empty($chkfiles)){
					if (!copy($folder.$file_name,$folder.'x1_'.$id.'_temp/'.$file_name)){	 
						echo 'error copy';
					}	
					if (!copy($folder.$file_name,$folder.'x1_'.$id.'_temp/thumbnail/'.$file_name)){	 
						echo 'error copy';
					}
			}
	}
		 
}
function upload($path, $file, $file_name, $type){
	
	global $height;
	global $width;
	$file_ext = strtolower(getFileExtension($file_name));		

	if($type == "img"){

		$chk_img = ($file_ext != "jpg" and $file_ext != "gif" and $file_ext != "jpeg"  and $file_ext != "png") ? "n" : "y" ;
		if($chk_img == "y"){
	
			$width 		= (!isset($width) || $width == "") ? 301 : $width ; 
			$height 		= (!isset($height) || $height == "") ? 381 : $height ; 
			if(file_exists($file)){
			$img_size 	= GetImageSize($file);  
			}
			if(($img_size[0] >= $width) || ($img_size[1] >= $height)) {
				$approve 	= "n";
				$status[0]	= "error_scale";
			}else{
				$approve 	= "y";
			}
		
		} else {
			$approve 		= "n";
			$status[0]		= "error_img";
		}  
	
	} else {

		$approve 	= "n";
		$status[0]	= "error_type";
	
	}

/* -------------------------------------------------------------Check file Exists */
	if($type == "img"){		
		$file_n		= chk_file($file_name, $path);
		$filename	= $path.$file_n;
	}
	$status[1] = $file_n;

/* ---------------------------------------------------------Begin Uploading File */
	if($approve == "y"){

		if($file_size >= "1000000") {
			$status[0] = "error_size";		
		} else {	
			if(file_exists($file)){ 
				if (!copy($file,$filename)){	 
					$status[0] = "error_upload";
				} else {
					$status[0] = "complete";
				}
				//unlink($file);
			} else { 
					$status[0] = "error_cmod";	
			}	
		}	
	}	
	return $status;

}

//Function check file exist
function chk_file($file_name, $folder){
	if(file_exists($folder.$file_name)){ 
		
		$f 	= explode(".", $file_name);
		$f_name 	= $f[0];	
		$f_ext 		= $f[1];		

		//find number in () 
		$f_otag 		= (strrpos($f[0], "(") + 1);	
		$f_ctag 		= (strrpos($f[0], ")") - $f_otag) ;		
		$f_num		= substr($f_name, $f_otag, $f_ctag);
		
		//if is number just increse it 		
		if(is_numeric($f_num)){ 	
			$filename 	= substr($f[0],0, strrpos($f[0], "("))."(".($f_num + 1).").".$f[1];					
		} else { 
			$filename 	= $f[0]."(1).".$f[1]; 
		}
		
	} else {	 
			$filename 		= $file_name; 
	}
		
return $filename;	
}

// function ที่ใช้แสดงรายละเอียดต่าง ๆ ของ files ที่จะทำการ upload
function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}


function upload_status($temp){
global $height;
global $width;

$width 		= (!isset($width) || $width == "") ? 301 : $width ; 
$height 		= (!isset($height) || $height == "") ? 381 : $height ; 

	if($temp == "error_scale"){	
		$msg = "\\n ขนาดของภาพเกินจากที่กำหนดไว้\\n ขนาดรูปภาพต้องไม่เกินสัดส่วนที่กำหนด";		
	} elseif($temp == "error_img") 	{	
		$msg = "\\n รูปแบบของ file ไม่ถูกต้อง\\n รูปภาพต้องมีนามสกุลเป็น jpg, jpeg และ gif เท่านั้น";		
	} elseif($temp == "error_type") 	{	
		$msg = "\\n รูปแบบของ file ที่นำเข้ามาไม่ถูกต้อง";		
	} elseif($temp == "error_size") 	{	
		$msg = "\\n รูปขนาดของ file มากกว่าที่ระบบกำหนด\\n ไฟล์ต้องมีขนาดไม่เกิน 800 Kilo Bytes";
	} elseif($temp == "error_upload") {	
		$msg = "\\n พบข้อผิดพลาดในการ Upload เข้าสู่ระบบ\\n โปรดติดต่อผู้ดูแล";			
	} elseif($temp == "error_cmod")	{	
		$msg = "\\n พบข้อผิดพลาดในการ Upload เข้าสู่ระบบ\\n โปรดตรวจสอบ CHMOD ของ Folder";				
	} elseif($temp == "error_doc"){	
		$msg = "\\n รูปแบบไฟล์ไม่ถูกต้อง\\n เอกสารต้องมีนามสกุลเป็น doc, xls และ pdf เท่านั้น";			
	} 
$msg	 = ($msg != "") ? $msg : "" ;
return $msg;
}

#Begin ตรวจสอบว่ามีเจ้าหน้าที่เขตหรือไม่และไม่ใช่พนักบันทึกข้อมูล
$strSql_personSite = "SELECT COUNT(siteid) AS count_siteid FROM edubkk_sapphire_app.`employee_work_site` WHERE siteid='".$siteid."' ";
$query_personSite = mysql_query($strSql_personSite);
$row_personSite = mysql_fetch_assoc($query_personSite);
$nums_personSite = $row_personSite['count_siteid'];
if($_SESSION['session_sapphire']==1 || 
	$_SESSION['session_status_extra']=="QC"  || $_SESSION['session_status_extra']=="CALLCENTER" || 
	$_SESSION['session_status_extra']=="SCAN" || $_SESSION['session_status_extra']=="GRAPHIC" ||
	$_SESSION['session_status_extra']=="site_area"
){
	//$nums_personSite = 0;//Test Keyin
	$nums_personSite = 1;
}
#End ตรวจสอบว่ามีเจ้าหน้าที่เขตหรือไม่และไม่ใช่พนักบันทึกข้อมูล

//$folder_img 	= "images/personal/";
$folder_img = "../../../../edubkk_image_file/$siteid/";
if($_SERVER['REQUEST_METHOD'] == "POST"){
$log_action = "edit_pic";
add_log("ข้อมูลภาพประวัติบุคลากร",$id,$log_action,$menu_id);	
	$action = $_POST[action];	
	$testxfile =  $_POST[chkupload];
	$namefolder1 = $_POST[nameimage];
	$sql_check = "select * from general_pic where id='$id'";
	$result_ch = mysql_query($sql_check);
	$xi=0;
	while($rs_ch = mysql_fetch_assoc($result_ch)){
		$ximgname[$xi] = $rs_ch[imgname];
		$xi++;
	}
			$check_ximg = "N";
			for($xa=0;$xa<count($ximgname);$xa++){
			if($ximgname[0] == $ximgname[$xa+1] ){
				$check_ximg = "Y";
				break;
				}
		}


		if($action=="upload" && $testxfile !="" ){
		$xselect ="select * from general_pic where id='$id' and no='$no'";
		$xresult=mysql_query($xselect);
		$xrs=mysql_fetch_assoc($xresult);
		$del_img=$folder_img.$xrs[imgname];
	//-------------------------------------------------
	//	$file = $_FILES['fileupload']['name'];
	//	$file_tem	= $_FILES['fileupload']['tmp_name'];
	//	$typefile = $_FILES['fileupload']['type']; 
	//	$sizefile = $_FILES['fileupload']['size']; 
		$file_tem = rawurldecode($_POST[imageurl]);	
		$file	= basename($_POST[imageurl]);
		$tempfile = $file;
		
		if($yy=="ไม่ระบุ"){
			$picname	= $id."_unknow".str_pad($no, 1, "0", STR_PAD_LEFT).".".strtolower(getFileExtension($tempfile));
		}else{
			$picname	= $id."_".$yy.".".strtolower(getFileExtension($tempfile));
		}
//	echo "Folder".$folder_img."<br>"."File".$file_tem."<br>"."File Name".$picname;die;
		$msg = upload_status($picname);
		if($msg != ""){
			echo "<script language=\"javascript\">alert(\"".$msg."\");window.location.href='?id=".$id."';</script>";	
			//echo "<br><br><div align\"center\">";
			//echo "<button name=\"button\" style=\"width:90px;\" onClick=\"window.location.href='?id=$id';\">ลองอีกครั้ง</button></div>";
			exit;
		}
	if($check_ximg == "Y"){
	echo "";
	}else{
	@unlink($del_img);
	}
		if(!is_dir($folder_img)){
			RmkDirPic($folder_img);
		}
	$upload		= upload($folder_img, $file_tem, $picname, "img");	
	deletedir($folder_img.'x1_'.$namefolder1.'_temp/');
//	copy($_FILES['fileupload']['tmp_name'],$folder_img.$tempfile);
	$sql 	= " update `general_pic` set yy='$yy', kp7_active='$kp7_active', imgname='$picname',label_yy='$label_yy',flag_imgnull='$flag_imgnull' where id='$id' and no='$no'; ";
	
	$returnid = add_monitor_logbefore("general_pic","id='$id' and no='$no'");
	mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	add_monitor_logafter("general_pic","id='$id' and no='$no'",$returnid);
		echo "
		<script language=\"javascript\">
		alert(\"ทำการปรับปรุงข้อมูลเรียบร้อยแล้ว\");
		window.opener.location.reload();
		window.close();
		</script>
		";		
		echo "<meta http-equiv='refresh' content='0;url=?id=$id&no=$no'>" ;
		exit;
		
		}else{
		
	$sql 	= " update `general_pic` set yy='$yy', kp7_active='$kp7_active',label_yy='$label_yy',flag_imgnull='$flag_imgnull' where id='$id' and no='$no'; ";
	$returnid = add_monitor_logbefore("general_pic","id='$id' and no='$no'");
	mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	add_monitor_logafter("general_pic","id='$id' and no='$no'",$returnid);
	
	######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'UPDATE',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
		deletedir($folder_img.'x1_'.$namefolder1.'_temp/');
	echo "
		<script language=\"javascript\">
		alert(\"ทำการปรับปรุงข้อมูลเรียบร้อยแล้ว\");
		window.opener.location.reload();
		window.close();
		</script>
		";		
	echo "<meta http-equiv='refresh' content='0;url=?id=$id&no=$no'>" ;
	exit;
	}		
}

$sql		= " select t1.*,t2.prename_th, t2.name_th, t2.surname_th ";
$sql		.= " from `general_pic` t1 left join `general` t2 on t1.id=t2.id ";
$sql		.= " where t1.id='$id' and t1.no='$no'; ";

$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs		= mysql_fetch_assoc($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>แก้ไขปีของรูปภาพ</title>
<script>
var imgDir_path="../popup_calenda/images/calendar/";
</script>
<script src="../popup_calenda/popcalendar.js" type="text/javascript"></script>
<script src="../popup_calenda/function.js" type="text/javascript"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="script.js" type="text/javascript"></script>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
<script src="../../../common/SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
	$('#value_yy').after("<span id='msg_value_yy' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_yy','values','number',"chk_yy");});
	$('#label_yy').after("<span id='msg_label_yy' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_yy','label','number',"chk_yy");});
});

function showValue(e){
		document.getElementById('value_yy').value=e.value;
}
function disabledUplaod(){
	if(document.getElementById('no_img_upload').checked == true){
		document.getElementById('xfile').disabled = true;
	}else{
		document.getElementById('xfile').disabled = false;
	}
}
function ch(){
		var f1=document.post;
		if(f1.file1.value=="" && document.getElementById('img_upload').checked == true && document.getElementById('hidden_imgname').value=="" ){
			alert('กรุณาเลือกรูปภาพที่ต้องการอัพโหลด');
			return false;
		}
		if (f1.chk_yy.value == 'false'){
			if(confirm("ปี พ.ศ. ไม่ตรงกับช่องแสดงผล ก.พ.7 ต้องการดำเนินการต่อหรือไม่")){
					f1.subject_error.value=f1.subject_error.value+"::"+"ปี พ.ศ. ไม่ตรงกับช่องแสดงผล ก.พ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.value_yy.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_yy.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"4";
					return true;
			}
			f1.subject_error.value="";
			f1.value_key_error.value="";
			f1.label_key_error.value="";
			f1.submenu_id.value="";
			return false;
		}
		return true;
}
/*function addImg(){

		document.post.submit();

}*/
function addImg(){
	if(ch()==true){
		document.post.action.value = "upload";
		document.post.submit();
	}
}
</script>
<style type="text/css">
<!--
.style11 {color: #8C0000}
.label1{
	font-size:13px !important;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); 
	padding: 2px;
}
-->
</style>
</head>
<body bgcolor="#f8f8f8">
<table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#dddddd">
    <td height="20" class="label1">&nbsp;&nbsp;<strong>แก้ไขข้อมูลคลังรูปภาพบุคลากร</strong></td>
</tr>	
<tr bgcolor="#ffffff" align="center">
    <td height="100"><table width="90%" border="0" cellspacing="0" cellpadding="0">
<tr align="center">
  <td align="left"><ul>
	  <li>รูปภาพควรสวมชุดข้าราชการขาว พื้นหลังสีน้ำเงิน หรือสีขาวเท่านั้น</li>
    <li>ขนาดรูปที่เหมาะสม กว้าง 120 pixel สูง 160 pixel  (หากนำเข้ารูปขนาดอื่น การแสดงผลอาจมีการผิดเพี้ยนไม่เหมือนต้นฉบับ) </li>
    <li>ในกรณีไฟล์ขนาดใหญ่เกินไประบบจะทำการประมวลผลเพื่อลดขนาดไฟล์โดยอัตโนมัติเพื่อความเหมาะสมในการแสดงผล</li>
    <li>ไฟล์ต้องเป็นนามสกุล jpg หรือ jpeg </li>
  </ul>
  </td>
</tr>
<tr align="center">
    <td>
<?
	$namefolder = basename($rs[imgname],".".pathinfo($rs[imgname], PATHINFO_EXTENSION)."");
	if($rs[imgname] != ""){
		//echo "<img src=\"".$folder_img.$rs[imgname]."\"  width=120 height=160 border=\"0\"><br>";
//		echo ($rs[yy] >= 1) ? " พ.ศ.".$rs[yy] : "" ;
		 makefoldertemp($folder_img,$rs[imgname],$namefolder);
	}else{
		//echo "<img src=\"../../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border=\"0\" title=\"ยังไม่มีไฟล์รูปภาพ\"><br>";	
//		echo ($rs[yy] >= 1) ? " พ.ศ.".$rs[yy] : "" ;
	}
?>	</td>
</tr>
</table>

	</td>
</tr>
<tr bgcolor="#ffffff">
    <td height="20" colspan="3">
<!--<form name="post" action="<?//=$PHP_SELF?>" method="post">	-->
<form id="formupdate" name="post" action="<?=$PHP_SELF."?id=".$id?>" method="post" enctype="multipart/form-data">	
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="no" value="<?=$no?>" />
<input type="hidden" name="action" value="upload" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="26%" height="20" align="right">เลือกรูปแบบ&nbsp;<b>:</b>&nbsp;</td>
	<td width="74%">
	<input type="radio" name="flag_imgnull" id="img_upload" value="0"  <?php echo ($nums_personSite>0 || ($rs['flag_imgnull']==0 && $rs['imgname']!=""))?"checked":"";?> <?php echo ($nums_personSite==0)?"disabled":'onclick="disabledUplaod();"';?>  />&nbsp;มีรูป&nbsp;
	|&nbsp;<input type="radio" name="flag_imgnull" id="no_img_upload" <?php echo ($nums_personSite==0 || ($rs['flag_imgnull']==1 || $rs['imgname']==""))?"checked":"";?> value="1" <?php echo ($nums_personSite==0 ||  ($rs['flag_imgnull']==0 && $rs['imgname']!=""))?"disabled":'onclick="disabledUplaod();"';?>  />&nbsp;ไม่มีรูป
	<?php
	if($nums_personSite==0){
		echo '<input type="hidden" name="flag_imgnull" value="1"/>';
	}
	?>
	</td>
</tr>
<tr>
  <td height="20" align="right">เลือกภาพ</td>
  <td>
  <!-- <input type="file" name="fileupload"  id="fileupload"  style="width:200px;" <?php// echo ($nums_personSite==0 ||  ($rs['flag_imgnull']==1 || $rs['imgname']==""))?"disabled":"";?> /> -->
  <input type="hidden" name="hidden_imgname"  id="hidden_imgname" value="<?php echo $rs['imgname'];?>" />
<br/>
    <?php
                            $options = array(
                                'path' => '../../../common/',
								'pathfolder' => $folder_img,
								'pathbeforesmcore' => $folder_img, //เหมือนกับpathfolder เพราะย้ายไฟล์ uploadnow มาในนี้ไม่ได้เรียกจาก smlcore
								'foldername' => 'x1_'.$namefolder.'_temp/',
								'themecss' => 'uploadresize/bootstrap.css',
								'maxfilesize' => 1000000,
								'acceptfiletypes' => '/(\.|\/)(jpe?g)$/i',
                                'formid' => 'formupdate',
								'maxnumberoffiles' => 2,
								'btnstart' => false,
								'btncancel' => false,
								'btndeleteupload' => false,
								'btndelete' => false,
								'showname' => false,
								'showsize' => true,
                            );
						$Optionbind = array(
						'fileuploadadd' =>"		$('.delete').click();
																$('.cancel').click();
																$('#chkupload').val('');",
							'fileuploaddone' => "$.each(data.result.files, function(index, file) {
																	$('#uploaddone').val(file.url);		
																	$('#imageurl').val(file.url);
																	$('#imagethumbnailUrl').val(file.thumbnailUrl);
																	$('#imagedeleteUrl').val(file.deleteUrl);
																	$('#chkupload').val('upload');
																	$('#btnsubmit').removeAttr('disabled');
																	$('#imageurl').click();															
																	return false;});",
								'fileuploadprocessfail' =>"$('#imageurl').val('');
																$('#btnsubmit').attr('disabled',true);
								",
																		); 


                       $testupload = new uploadfile($options,$Optionbind);
                            ?>
  </td>
</tr>
<tr>
<td></td>
<td>
<iframe id="iframere" scrolling="auto"  frameborder="0" width="500px" height="260px" style="display:none"></iframe>
</td>
</tr>
<tr>
    <td height="20"  width="30%"align="right">ปี พ.ศ.&nbsp;<b>:</b>&nbsp;</td>
	<td width="70%">	
	<select name="yy" id="yy" style="width:80px;" onchange="showValue(this);">	
<option value="ไม่ระบุ">ไม่ระบุ</option>
<?
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	$selected = ($rs[yy] == $i||$_GET[yy] == $i) ? " selected style=\"color:#0099CC;\" " : "";
	echo "<option value=\"".$i."\" ".$selected.">".$i."</option>";
}
?>
	</select>
	<input type="hidden" name="value_yy" id="value_yy" value="<?=$rs[yy]?>"  style="width:150px;" /></td>
<tr>
<?
	$sql_label = "SELECT label_yy FROM general_pic  WHERE id='$id' AND no='$no'";
	$result_label = mysql_query($sql_label);
	$rsl = mysql_fetch_assoc($result_label);
?>
  <td height="20" align="right">&nbsp;</td>
  <td>
    <input type="text" name="label_yy" id="label_yy"  style="width:140px;" value="<?=$rsl[label_yy]?>">
    <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
    <span class="style11">ปี พ.ศ.ส่วนการแสดงผลในก.พ.7</span></td>
</tr>
<? 
	$xsql="SELECT * FROM general_pic WHERE id='$id' and yy='".$rs[yy]."'";
	$xresult=mysql_query($xsql);
	$xrs=mysql_fetch_array($xresult);
?>
<tr>
  <td height="20" align="right">&nbsp;</td>
  <td><label>
     <input name="kp7_active" type="radio" value="1" <? if($xrs[kp7_active]=="1"){ echo "checked";}?>>
     แสดงผลใน ก.พ.7
     <input name="kp7_active" type="radio" value="0" <? if($xrs[kp7_active]=="0" || $xrs[kp7_active]==""){ echo "checked";}?>>
    ไม่แสดงใน ก.พ.7</label></td>
</tr>
<input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
    <?php
 $chkfiles = glob($folder_img.'x1_'.$namefolder.'_temp/thumbnail/*');
if(empty($chkfiles)){
	$fileurl = null;
}else{
	$filenamechk = scandir($folder_img.'x1_'.$namefolder.'_temp/',1);
	$fileurl = $folder_img.'x1_'.$namefolder.'_temp/'.$filenamechk[1];
	if( $filenamechk[1] !=  $rs[imgname] ){
	$chkupload = "upload";
	}else{
	$chkupload = "";
	}
}
 ?>
<input type="hidden" id="uploaddone"  name="file1"  value="<?php echo $fileurl ?>" >
<input type="hidden" id="imageurl"  name="imageurl" value="<?php echo $fileurl ?>" >
<input type="hidden" id="imagethumbnailUrl" name="imagethumbnailUrl"  value="" >
<input type="hidden" id="imagedeleteUrl" name="imagedeleteUrl"  value="" >
<input type="hidden" id="chkupload" name="chkupload"  value="<?php echo $chkupload ?>" >
<input type="hidden" id="nameimage" name="nameimage" value="<?php echo $namefolder ?>" >
</table>
</form>
	</td>
</tr>
<tr bgcolor="#dddddd" align="center">
    <td height="20">	<!--<button style="width:60px;" onclick="addImg();">ตกลง</button>-->
	<button id="btnsubmit" style="width:60px;" onclick="addImg();">ตกลง</button>&nbsp;&nbsp;
	<button style="width:60px;" onclick="self.close();">ยกเลิก</button></td>
</tr>
</table>
</body>
</html>
<script type="text/javascript">
	function deleteimage(){
		$(".delete").click();		
	}
	window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
	
    $(document).ready(function() {				
        $('#imageurl').click(function() {
			 document.getElementById('iframere').style.display ="block";
			 document.getElementById('iframere').src = "uploadresize/jracimage.php?imageurl=" + $("#imageurl").val() + '&imagethumbnailUrl=' + $("#imagethumbnailUrl").val() + '&imagedeleteUrl=' + $("#imagedeleteUrl").val() + '&newname=' + $("#newname").val()+'&id=<?=$_GET[id]?>&yy='+$('#yy').val()+'&act=pic_history_update&no=<?=$_GET['no']?>';          
            return false;
        });
    });
</script>
