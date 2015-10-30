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
$time_start = getmicrotime();


if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}


function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
if($xaction=="setuser"){
	unset($_SESSION['def_staff']);
	$arr=explode(",",$setuser);
	if(is_array($arr) ){
	foreach($arr as $index=>$values){
	 $_SESSION['def_staff'][$values]='ok';
		}
	}
 
}

if(is_array($_SESSION['def_staff']) ){
	foreach($_SESSION['def_staff'] as $index=>$values){	
	 if($xstr_arr!=""){$xstr_arr.=",";}
	  $xstr_arr.="'".$index."'";
	 
	}
}
//echo $xstr_arr;

##########  บันทึกการตรวจสอบเอกสาร
$arr_problem = show_problem(); // รายการปัญหาทั้งหมด
if($action == "process"){
	
	//echo "<pre>";
	//print_r($commentT);
	//die;
	$file_path = "../../../checklist_kp7file/$sentsecid/";
	$xpathfile = "../../../checklist_kp7file/$sentsecid/$idcard/";
	if(!is_dir($file_path)){
			xRmkdir($file_path);
	}
	
if($kp7_file_name != ""){
	$temp_imgid = substr($kp7_file_name,0,-4);	
}
	

/*	echo "upload file :: <br>";
	echo "<pre>";
	print_r($_POST);
	echo "<pre>";
	print_r($_SESSION);
	echo "<br>";
	echo "file_name  :: ".$kp7_file_name."<br>";die;
*/	###  ทำการ upload file
		if($kp7_file_name != "" and $idcard == $temp_imgid){		

			if(!is_dir($xpathfile)){
				xRmkdir($xpathfile);
			}

			$xd = sw_dateE($date_upload);
			$upload		= upload($xpathfile, $kp7_file, $kp7_file_name,"doc",$idcard,$xd);		
			$msg 		= upload_status($upload[0]);
			$xpfile = $xpathfile.$idcard."_".$xd.".pdf";
			
			
			//echo "file :: ".$xpfile;
			

				if(file_exists($xpfile)){			
					$page_num = XCountPagePdf_Brows($xpfile);
					$sql_logup = "REPLACE INTO tbl_checklist_log_uploadfile SET idcard='$idcard',siteid='$sentsecid',schoolid='$schoolid',numpage='$page_num',numpic='$pic_num',date_upload='".sw_dateE($date_upload)."',kp7file='$xpfile',user_update='$user_check',user_save='".$_SESSION['session_staffid']."',profile_id='$profile_id',time_update=NOW()";
					//echo $sql_logup;		
					if($page_num > 0){
						mysql_db_query($dbname_temp,$sql_logup);	
						$sql_flag_upload = "UPDATE tbl_checklist_kp7 SET flag_uploadfalse='1' WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
						mysql_db_query($dbname_temp,$sql_flag_upload);
					}else{
						$xmsg = "ไม่สามารถupload ไฟล์ได้เนื่องจากไฟล์มีปัญหา";
					}
					
				}//end if(file_exists($xpfile)){	
	
			
			//echo "xxxxxxxxxxx".die;
		}else if($kp7_file_name != "" and $idcard != $temp_imgid){
			$xmsg = "ชื่อไฟล์ไม่่ตรงกับเลขบัตรประจำตัวประชาชน";	
		}//end if($kp7_file_name != ""){		

		
	//echo "<a href='$xpfile'>$xpfile</a>";die;

		//echo $filedb;die;
	### end medki upload file
$check_file = "$file_path".$idcard.".pdf";
//echo "<a href='$check_file'>file</a>";
if(is_file($xpfile)){
	$temp_page = XCountPagePdf_Brows($xpfile);

}else{
	$temp_page = "";
}
//echo "numpage :: ".$temp_page;die;
//echo "<br>page == $temp_page";die;
//echo "<pre>";
//print_r($_POST);die;
	$sql_count = "SELECT COUNT(menu_id) as num1 FROM tbl_check_menu";
	$result_count = mysql_db_query($dbname_temp,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	$num_menu = $rs_c[num1]; // จำนวนทั้งหมดของรายการ
	###  จำนวนเมนูรายการทั้งหมดที่ตรวจสอบ
	$sql = "SELECT * FROM tbl_check_menu ORDER BY menu_id ASC ";
	$result = mysql_db_query($dbname_temp,$sql);
	$check_i = 0;
	while($rs = mysql_fetch_assoc($result)){
		if($$rs[field_name] == "1"){
			$check_i++;
			### ทำการล้างปัญหาเมื่อทำการ
			$sql_update_problem = "UPDATE tbl_checklist_problem_detail SET status_problem='1',profile_id='$profile_id' WHERE idcard='$idcard' AND menu_id='$rs[menu_id]' AND profile_id='$profile_id'";
			mysql_db_query($dbname_temp,$sql_update_problem);
			
		}else{
			##  ทำการลบรายการปัญหาก่อนทำการสร้างใหม่
				$sql_del = "DELETE FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND menu_id='$rs[menu_id]' AND profile_id='$profile_id'";
				$result_del = mysql_db_query($dbname_temp,$sql_del);
			## end ทำการลบรายการปัญหาก่อนทำการสร้างใหม่
			foreach($arr_problem as $k => $v){
				if($check_problem[$idcard][$rs[menu_id]][$k] != ""){
					$sql_problem = "REPLACE INTO tbl_checklist_problem_detail(idcard,problem_id,menu_id,problem_detail,status_problem,profile_id)VALUE('".$idcard."','".$k."','".$rs[menu_id]."','".$problem_detail[$idcard][$rs[menu_id]][$k]."','0','$profile_id')";
					$result_problem = mysql_db_query($dbname_temp,$sql_problem);
					//echo "$sql_problem<hr>";
				}//end if($check_problem[$idcard][$rs[menu_id]][$k] != ""){
			}//end foreach($arr_problem as $k => $v){
		}//end if($$rs[field_name] == "1"){
		$update_value .= ",$rs[field_name]='".$$rs[field_name]."'";
	}//end while($rs = mysql_fetch_assoc($result)){
	## ตรวจสอบว่ารายการทั้งหมดสมบูรณ์หรือยัง
	
	if($cls_usercheck == "1"){  // กรณีต้องการล้างข้อมูลคนตรวจเอกสาร
		$sql_del1 = "DELETE FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_del1);
		$val_statusfile = "0";
		$con_file = ", status_check_file='NO',mainpage=NULL ,mainpage_comment=NULL , status_numfile='0' ,pic_num=NULL,page_num=NULL,type_doc=NULL";
	}else{
		if($page_num == "0" and  $pic_num == "0"){
			$con_file = ", status_check_file='NO'";	
		}else{
			$con_file = ", status_check_file='YES'";	
		}
		$val_statusfile = "1";
	}// end 	if($cls_usercheck == "1"){

	if($check_i == $num_menu){ $sql_status_file = " ,status_file='$val_statusfile'";}else{ $sql_status_file = " ,status_file='0'";}
	## select เพื่อตรวจสอบข้อมูล
	if($problem_status_id != ""){ $conPS = " ,problem_status_id='$problem_status_id'";}else{ $conPS = "";}
	
	###  กรณ๊เอกสารสมบูรณ์และใส่ comment ไว้
	if(count($commentT) > 0){
			foreach($commentT as $kx1 => $vx1){
					$update_con .= " ,$kx1='$vx1' ";		
			}//end foreach($commentT as $kx1 => $vx1){
	}//endif(count($$commentT) > 0){ 
	###  end  กรณ๊เอกสารสมบูรณ์และใส่ comment ไว้
	
	$sql_update = "UPDATE tbl_checklist_kp7 SET profile_id='$profile_id',page_num='$page_num', type_doc='$type_doc',mainpage='$mainpage',mainpage_comment='$mainpage_comment',pic_num='$pic_num',comment_pic='$comment_pic',status_numfile='$status_numfile'  $sql_status_file $update_value $con_file $conPS $update_con  WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id' ";
	//echo $sql_update;die;
	$result_update = mysql_db_query($dbname_temp,$sql_update);
	
	
	####  ตรวจสอบเพื่อนำไฟล์ที่สถานะเอาสารจากไม่สมบูรณ์มาเป็นสมบูรณ์เข้าไปในระบบ(กรณีสถานะเอกสารเป็นสมบูรณ์แล้ว
	ChangStatusFile($idcard,$profile_id,$sentsecid);
	## end ตรวจสอบเพื่อนำไฟล์ที่สถานะเอาสารจากไม่สมบูรณ์มาเป็นสมบูรณ์เข้าไปในระบบ(กรณีสถานะเอกสารเป็นสมบูรณ์แล้ว
	
	
	if($kp7_file_name != ""){
		if($temp_page == "0"){
				$xmsg .= "เกิดข้อผิดพลาดไม่สามารถนับจำนวนหน้าในระบบได้";	
		}else{
			if($page_num != $temp_page){
				$xmsg .= "จำนวนแผ่นที่ตรวจสอบกับไฟล์ที่อยู่ในระบบจำนวนหน้าไม่เท่ากัน";	
			}else{
				$xmsg .= "";	
			}
		}
	}else{
		$xmsg = "";	
	}//end if($kp7_file_name != ""){
		
	if($extra == "1"){ // มาจากการเปิดหน้าต่างการแก้ไขข้อมูลจำนวนแผ่นไม่เจอ report_page_no_math.php?sentsecid=6502
		if($result_update){
		insert_log_import($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
		insert_log_checklist_last($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
		echo "<script>alert(\" บันทึกข้อมูลเรียบร้อยแล้ว \");opener.document.location.reload();window.close();</script>";
		exit;
		}else{
			echo "<script>alert(' !ไม่สามารถบันทึกข้อมูลได้');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}
	}else{
	if($result_update){
			if($cls_usercheck == "1"){ // แสดงว่าต้องการล้างค่าพนักงานตรวจสอบเอกสาร
					$sql_up1 = "UPDATE tbl_checklist_log SET type_action='2' WHERE type_action='1' AND idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id' ";
					@mysql_db_query($dbname_temp,$sql_up1);
					insert_log_import($sentsecid,$idcard,"ล้างค่าบันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
					insert_log_checklist_last($sentsecid,$idcard,"ล้างค่าบันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
			}else{
					insert_log_import($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
					insert_log_checklist_last($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check,"","","",$profile_id);
			}//end if($cls_usercheck == "1"){
		if($msg != ""){
		echo "<script>alert(\" ไม่สามารถuploadไฟล์ต้นฉบับได้ <br>
$msg \");location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}else{
		echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยแล้ว $xmsg\");location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}//end if($msg != ""){
	}else{
		echo "<script>alert(' !ไม่สามารถบันทึกข้อมูลได้');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
	}//end 	if($result_update){
	}//end if($extra == "1"){
	

##  ตรวจสอบ ถ้าข้อมูลรายการอื่นๆ สมบูรณ์ กำหนดสถานะรวมเป็น 1
/*	if($page_num > 0 and $general_status == "1" and $graduate_status == "1" and $salary_status == "1" and $seminar_status == "1" and $sheet_status == "1" and $getroyal_status == "1" and $special_status == "1" and $goodman_status == "1" and $absent_status == "1" and $nosalary_status == "1" and $prohibit_status == "1" and $specialduty_status == "1" and $other_status == "1"){
		$txt_status = "1";	
	}else{
		$txt_status = "0";
	}
###  end ##  ตรวจสอบ ถ้าข้อมูลรายการอื่นๆ สมบูรณ์ กำหนดสถานะรวมเป็น 1
	$sql_update = "UPDATE tbl_checklist_kp7 SET status_file='$txt_status',page_num='$page_num',comment_page='$comment_page',pic_num='$pic_num',comment_pic='$comment_pic',general_status='$general_status',comment_general='$comment_general',graduate_status='$graduate_status',comment_graduate='$comment_graduate',salary_status='$salary_status',comment_salary='$comment_salary',seminar_status='$seminar_status',comment_seminar='$comment_seminar',sheet_status='$sheet_status',comment_sheet='$comment_sheet',getroyal_status='$getroyal_status',comment_getroyal='$comment_getroyal',special_status='$special_status',comment_special='$comment_special',goodman_status='$goodman_status',comment_goodman='$comment_goodman',absent_status='$absent_status',comment_absent='$comment_absent',nosalary_status='$nosalary_status',comment_nosalary='$comment_nosalary',prohibit_status='$prohibit_status',comment_prohibit='$comment_prohibit',specialduty_status='$specialduty_status',comment_specialduty='$comment_specialduty',other_status='$other_status',comment_other='$comment_other',status_check_file='YES'   WHERE idcard='$idcard' AND siteid='$sentsecid'";
//	echo $sql_update;die;
	$result_update = mysql_db_query($dbname_temp,$sql_update);
	insert_log_import($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1");
	if($result_update){
			echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid';</script>";
		exit;
	}else{
		echo "<script>alert(' !ไม่สามารถบันทึกข้อมูลได้');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid';</script>";
		exit;
	}
*/	
}//end if($action == "process"){

#######  ลบข้อมูล
if($action == "DEL"){
	$file_path = "../../../checklist_kp7file/$sentsecid/";
	$xfile = $file_path.$idcard.".pdf";
		if(is_file($xfile)){
			
			@unlink($xfile);	
			SaveLogUnlinkFile($idcard,$sentsecid,"check_kp7_area.php",$xfile,$profile_id);
		}
	$sql_del = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
	$result_del = mysql_db_query($dbname_temp,$sql_del);
	insert_log_import($sentsecid,$idcard,"ลบข้อมูลในchecklist","1",$_SESSION['session_staffid'],"","","",$profile_id);
	insert_log_checklist_last($sentsecid,$idcard,"ลบข้อมูลในchecklist","1",$_SESSION['session_staffid'],"","","",$profile_id);
	
	if($result_del){
		echo "<script>alert('ลบรายการเรียบร้อยแล้ว');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
	}
	
}//end if($action == "DEL"){

?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
var xidcard = "<?=$idcard?>";
var numfalse = 0;
var numf1 = 0;
function check_F(){
var check_num = 4;
var ch1 = 0;
var ch_detail = 0;
	if(document.form2.cls_usercheck.checked == true){ // กรณีล้างค่าพนักงานตรวจไม่ปล๊อก
			 ch1 = 1;
	}else{
			if(document.form2.status_numfile[0].checked == true){
			ch1 = 1;			
			}else{
			ch1 = 0;
			}
	}

	if(document.form2.page_num.value == "0" && ch1 != 1){
		alert("กรุณาระบุจำนวนแผ่นเอกสาร");
		document.form2.page_num.focus();
		return false;
	}
	

	if(document.form2.page_num.value > 0){
		ch_detail = 1;
	}
	
	if(document.form2.status_numfile[1].checked == false){
		ch_detail = 0;	
	}
	
	//alert(ch1);
	//return false;
	/// ข้อมูลทั่วไป
if(ch_detail == 1){
		if(document.form2.general_status[0].checked == false && document.form2.general_status[1].checked == false){
			alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลทั่วไป");
			return false;
		}else{
			if(document.form2.general_status[1].checked == true){
				numf1++;
			
						var n=0;
						for(i=1;i<=4;i++) { 
							if(eval("document.form2.check_problem1"+i+".checked")==false) { 
								n++;
							} 
						} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลทั่วไป");
					return false;
				}
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem1"+i+".checked")==true) && document.getElementById("problem_detail1"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail1"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
			
			} // end if(document.form2.general_status[1].checked == true){
		}//end 	if(document.form2.general_status[0].checked == false && document.form2.general_status[1].checked == false){
	// end ข้อมูลทั่วไป
	// ข้อมูลประวัติการศึกษา
	if(document.form2.graduate_status[0].checked == false && document.form2.graduate_status[1].checked == false ){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลประวัติการศึกษา");
		return false;
	}else{
		if(document.form2.graduate_status[1].checked == true){
			
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem2"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลประวัติการศึกษา");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem2"+i+".checked")==true) && document.getElementById("problem_detail2"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail2"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){

		}//end if(document.form2.graduate_status[1].checked == true){
	}
	// end ข้อมูลประวัติการศึกษา
	// ข้อมูล ตำแหน่งและอัตราเงินเดือน
	if(document.form2.salary_status[0].checked == false && document.form2.salary_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลตำแหน่งและอัตราเงินเดือน");
		return false;
	}else{
		if(document.form2.salary_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem3"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลตำแหน่งและอัตราเงินเดือน");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem3"+i+".checked")==true) && document.getElementById("problem_detail3"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail3"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
			
		}
	}
	// end ข้อมูล ตำแหน่งและอัตราเงินเดือน
	//ฝึกอบรมและดูงาน seminar_status
	if(document.form2.seminar_status[0].checked == false && document.form2.seminar_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลฝึกอบรมและดูงาน");
		return false;
	}else{
		if(document.form2.seminar_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem4"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลฝึกอบรมและดูงาน");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem4"+i+".checked")==true) && document.getElementById("problem_detail4"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail4"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end ฝึกอบรมและดูงาน 
	// ผลงานทางวิชาการ  
	if(document.form2.sheet_status[0].checked == false && document.form2.sheet_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลผลงานทางวิชาการ");
		return false;
	}else{
		if(document.form2.sheet_status[1].checked == true){
numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem5"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลผลงานทางวิชาการ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem5"+i+".checked")==true) && document.getElementById("problem_detail5"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail5"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){

		}
	}
	// end ผลงานทางวิชาการ
	
	// เครื่องราชอิสริยาภรณ์ฯ 
		if(document.form2.getroyal_status[0].checked == false && document.form2.getroyal_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลเครื่องราชอิสริยาภรณ์ฯ ");
		return false;
	}else{
		if(document.form2.getroyal_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem6"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลเครื่องราชอิสริยาภรณ์ฯ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem6"+i+".checked")==true) && document.getElementById("problem_detail6"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail6"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end เครื่องราชอิสริยาภรณ์ฯ
	
		// ความรู้ความสามารถพิเศษ 
	if(document.form2.special_status[0].checked == false && document.form2.special_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลความรู้ความสามารถพิเศษ");
		return false;
	}else{
		if(document.form2.special_status[1].checked == true){
			numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem7"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลความรู้ความสามารถพิเศษ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem7"+i+".checked")==true) && document.getElementById("problem_detail7"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail7"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end ความรู้ความสามารถพิเศษ
	
	// ความดีความชอบ 
	if(document.form2.goodman_status[0].checked == false && document.form2.goodman_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลความดีความชอบ");
		return false;
	}else{
		if(document.form2.goodman_status[1].checked == true){
numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem8"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลความดีความชอบ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem8"+i+".checked")==true) && document.getElementById("problem_detail8"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail8"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end ความดีความชอบ

	// จำนวนวันลาหยุดราชการฯ 
	if(document.form2.absent_status[0].checked == false && document.form2.absent_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลจำนวนวันลาหยุดราชการฯ");
		return false;
	}else{
		if(document.form2.absent_status[1].checked == true){
	numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem9"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลจำนวนวันลาหยุดราชการฯ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem9"+i+".checked")==true) && document.getElementById("problem_detail9"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail9"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end จำนวนวันลาหยุดราชการฯ

	// วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็มฯ 
	if(document.form2.nosalary_status[0].checked == false && document.form2.nosalary_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลวันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็มฯ");
		return false;
	}else{
		if(document.form2.nosalary_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem10"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลวันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็มฯ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
					if((eval("document.form2.check_problem10"+i+".checked")==true) && document.getElementById("problem_detail10"+i).value == "" ) { 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail10"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็มฯ
	
	// การได้รับโทษทางวินัย 
	if(document.form2.prohibit_status[0].checked == false && document.form2.prohibit_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลการได้รับโทษทางวินัย");
		return false;
	}else{
		if(document.form2.prohibit_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem11"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลการได้รับโทษทางวินัย");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
				if((eval("document.form2.check_problem11"+i+".checked")==true) && document.getElementById("problem_detail11"+i).value == "" ){ 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail11"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end การได้รับโทษทางวินัย
	
	
// การปฏิบัติราชการพิเศษ 
	if(document.form2.specialduty_status[0].checked == false && document.form2.specialduty_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลการปฏิบัติราชการพิเศษ ");
		return false;
	}else{
		if(document.form2.specialduty_status[1].checked == true){
		numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem12"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลการปฏิบัติราชการพิเศษ ");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
				if((eval("document.form2.check_problem12"+i+".checked")==true) && document.getElementById("problem_detail12"+i).value == "" ){ 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail12"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
		
		}
	}
	// end การปฏิบัติราชการพิเศษ

 // รายการอื่น ๆ ที่จำเป็น
	if(document.form2.other_status[0].checked == false && document.form2.other_status[1].checked == false){
		alert("กรุณาเลือกสถานะความสมบูรณ์ของเอกสารหมวดข้อมูลรายการอื่น ๆ ที่จำเป็น");
		return false;
	}else{
		if(document.form2.other_status[1].checked == true){
			numf1++;
			var n=0;
			for(i=1;i<=4;i++) { 
					if(eval("document.form2.check_problem13"+i+".checked")==false) { 
							n++;
					} 
			} //end for(i=1;i<=4;i++) { 
				if(check_num == n){
					alert("กรุณาเลือกปัญหาเอกสารไม่สมบูรณ์หมวดข้อมูลรายการอื่น ๆ ที่จำเป็น");
					return false;
				}//end for(i=1;i<=4;i++) { 
				
				for(i=1;i<=4;i++){
				if((eval("document.form2.check_problem13"+i+".checked")==true) && document.getElementById("problem_detail13"+i).value == "" ){ 
						alert("เลือกหมวดปัญหาแล้วกรุณาระบุรายละเอียดของปัญหาด้วย");
						document.getElementById("problem_detail13"+i).focus();
						return false;
					}	
				}// end for(i=1;i<=4;i++){
	
		}
	}
	// end รายการอื่น ๆ ที่จำเป็น
	
	
	if(numf1 > 0){
			if(document.form2.problem_status_id.value == ""){
					alert("กรุณาระบุสถานะการส่งแก้ไขเอกสาร");
					document.form2.problem_status_id.focus();
					return false;
			}
	}
	
}// end if(ch_detail == 1){

		return true;
} //end function check_F(){



function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}


function sw_table(ch_id,menu_id){

	
	if(ch_id == "0"){
		document.getElementById("tblName"+menu_id).style.display = "";
		document.getElementById("radio_all1").checked=false;
		document.getElementById("xtblName"+menu_id).style.display = "none";
		numfalse++;

	}else if(ch_id == "1"){
		document.getElementById("xtblName"+menu_id).style.display = "";
		document.getElementById("tblName"+menu_id).style.display = "none";
		
	}else{
		numfalse--;
		document.getElementById("tblName"+menu_id).style.display = "none";
		document.getElementById("radio_all2").checked=false;
		document.getElementById("xtblName"+menu_id).style.display = "none";

	}
	
	if(numfalse > 0){
		document.getElementById("problem_status_id").disabled=false;			
	}else{
		document.getElementById("problem_status_id").disabled=true;			
	}
	


}//end function sw_table(menu_id){
	
	
//  ฟังก์ชั่นเลือกการตรวจสอบสถานะทั้งหมด
function check_radio_all(txtpotion){
	var arrmenu = new Array('','general_status','graduate_status','salary_status','seminar_status','sheet_status','getroyal_status','special_status','goodman_status','absent_status','nosalary_status','prohibit_status','specialduty_status','other_status');
		if(txtpotion == "1"){ /// กรณีสมบูรณ์ทั้งหมด
				for(i=1;i<14;i++){
					//alert(arrmenu[i]);
					document.getElementById(arrmenu[i]+"1").checked=true;
					sw_table(1,i)
				}//end for(i=0;i<count(arrment);i++){
		}else if(txtpotion == "2"){// กรณีไม่สมบูรณ์
				for(i=1;i<14;i++){
					document.getElementById(arrmenu[i]+"2").checked=true;
					 sw_table(0,i)
				}//end for(i=0;i<count(arrment);i++){
		}
	
}//end function check_radio_all(txtpotion){
	

function control_checkbox(){
//alert("sad");
	for(i=1;i<=13;i++){ // หมวดเมนู
		for(j=1;j<=4;j++){
			var str_checkbox = "check_problem"+i+""+j;
			var str_textbox = "problem_detail"+i+""+j;
			//alert(document.getElementById("check_problem"+i+j).value);
			if(eval("document.form2."+str_checkbox+".checked") == true) { 
				document.getElementById("problem_detail"+i+j).disabled=false;
				
			}else{
				document.getElementById("problem_detail"+i+j).disabled=true;
				document.getElementById("problem_detail"+i+j).value="";
			}//end if(eval("document.form2.check_problem13"+i+".checked")==false) { 
			
		}//end for(j=1;j<=4;j++){
	}//end for(i=1;i<=13;i++){

	
}







function setuser(){
 var left=(document.width/2)-(450/2);
 var top=(document.height/2)-(500/2);
// if(xnorsel==undefined){xnorsel="";}
 var url="popup_setuser.php?Rnd="+(Math.random()*1000);
 var prop="dialogHeight: 500px; dialogWidth: 450px; scroll: yes; help: No; status: No;center:yes ;dialogTop:"+top+";dialogLeft:"+left;
 var o=showModalDialog(url,"pop",prop); 

 if(o){
	 var xstr=o.strname;
	
    document.formsetuser.setuser.value=xstr;
	 document.formsetuser.submit();
 }
}

</script>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onChange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>

<form name="formsetuser" method="post" action="<?="check_kp7_area.php?action=$action&sentsecid=$sentsecid&idcard=$idcard&fullname=$fullname  &search=$search&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&schoolid=$schoolid&xsiteid=$xsiteid&profile_id=$profile_id"?>">
<input name="xaction"  type="hidden" value="setuser">
<input name="setuser"  type="hidden" value="<?=$setuser?>">

</form>
<?
	if($action == ""){
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A8B9FF" align="center"><strong><?=show_area($sentsecid);?></strong></td>
  </tr>
  <tr>
    <td bgcolor="#A8B9FF">&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" bgcolor="#A8B9FF"><strong>ค้นหาบุคลากรเพื่อตรวจสอบข้อมูล ก.พ. 7 ต้นฉบับ </strong></td>
              </tr>
            <tr>
              <td width="8%" bgcolor="#FFFFFF"><strong>ชื่อ:</strong></td>
              <td width="25%" bgcolor="#FFFFFF"><label>
                <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>">
              </label></td>
              <td width="18%" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน:</strong></td>
              <td width="49%" bgcolor="#FFFFFF"><label>
                <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>">
              </label></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF"><strong>นามสกุล:</strong></td>
              <td bgcolor="#FFFFFF"><label>
                <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>">
              </label></td>
              <td colspan="2" bgcolor="#FFFFFF"><label>
			  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
              <input type="hidden" name="profile_id" value="<?=$profile_id?>">
			  <input type="hidden" name="action" value="">
			  <input type="hidden" name="search" value="search">
                <input type="submit" name="Submit" value="ค้นหา">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="search_person_area.php?profile_id=<?=$profile_id?>"><img src="../../images_sys/searchb.gif" width="26" height="22" border="0" title="คลิ๊กเพื่อค้นหาข้อมูลบุคลากรเพื่อบันทึกผลการตรวจสอบเอกสาร">ค้นหาบุคลากร&nbsp;::</a>
	<? if($sentsecid != ""){ $xsiteid = $sentsecid;}?>
	<strong>
	<a href='check_kp7_index.php?lv=1&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'><?=show_area($xsiteid)?></a> =></strong> <?=show_school($schoolid);?></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="14" bgcolor="#A8B9FF"><strong>รายชื่อบุคลากรที่ทำการตรวจสอบข้อมูล ก.พ. 7 ต้นฉบับ </strong></td>
        </tr>
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>เลขบัตรประชาชน</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>คำนำ<br>
          หน้าชื่อ</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>สถานะ<br>
          เอกสาร</strong></td>
        <td colspan="2" align="center" bgcolor="#A8B9FF"><strong>จำนวนแผ่น</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ไฟล์<br>
          upload</strong></td>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนรูป</strong><strong><br>
        </strong></td>
        <td width="23%" rowspan="2" align="center" bgcolor="#A8B9FF"> <? if(CheckLockArea($sentsecid,$profile_id) > 0){ echo "<em>Lock</em>"; }else{?><input type="button" name="btnA" value="เพิ่มข้อมูล" onClick="location.href='form_manage_checklist.php?profile_id=<?=$profile_id?>&action=ADD&sentsecid=<?=$sentsecid?>&schoolid=<?=$schoolid?>'" style="cursor:hand"><? } //end <? if(CheckLockArea($sentsecid) > 0){ ?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>พนักงาน<br>
          ตรวจ</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>script<br>
          ตรวจ</strong></td>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>พนักงาน<br>
          นับ</strong></td>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>upload</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>จำนวนนับ<br>
          ใหม่</strong></td>
        </tr>
	  <?
	  	$arrfield_comment = FieldComment();
	 $page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 20 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
		if($search == "search"){
			if($key_name != ""){ $conv .= " AND name_th LIKE '%$key_name%'";}
			if($key_surname != ""){ $conv .= " AND surname_th LIKE '%$key_surname%'";}
			if($key_idcard != ""){ $conv .= " AND idcard LIKE '%$key_idcard%'";}
		}
			if($schoolid != ""){ $conschool = " AND schoolid='$schoolid'";}else{ $conschool = "";}
		$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND profile_id='$profile_id' $conschool $conv ORDER  BY name_th,surname_th ASC";
		//echo $sql_main."<br>$dbname_temp<br>name :: $key_name<br>$key_surname";
		
		
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$n=0;
		if($all < 1){// ไม่รบรายการที่ค้นหา
			echo "<tr bgcolor='#FFFFFF'><td colspan='14' align='center'> - ไม่พบรายการที่ค้นหา - </td></tr>";
		}else{
		while($rs1 = mysql_fetch_assoc($result_main)){
		$i++;
		 	if ($n++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
			
			if($rs1[page_num] > 0 and $rs1[page_upload] > 0){
				if($rs1[page_num] != $rs1[page_upload]){
					$bg = "#FF0000";		$tr_title = " title='ข้อมูลจำนวนหน้าที่นับโดยระบบกับที่พนักงานนับไม่ตรงกันกรุณาตรวจสอบอีกครั้ง'  style='cursor:hand'";
					$link_up_count_pdf = "1";
				}else{
					$link_up_count_pdf = "0";
					$bg = $bg;		$tr_title = "";	
				}
			}else{
					$link_up_count_pdf = "0";
					$bg = $bg;		$tr_title = "";	
			}
			###  แสดงไฟล์ upload 
			$path_file = "../../../kp7file/$rs1[siteid]/$rs1[idcard]".".pdf";
			if(is_file($path_file)){
				$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
			}else{
				
				$sql_file = "SELECT * FROM tbl_checklist_log_uploadfile WHERE profile_id='$profile_id' AND idcard='$rs1[idcard]' ORDER BY date_upload DESC";
				$result_file = mysql_db_query($dbname_temp,$sql_file);
				$numrowfile = @mysql_num_rows($result_file);
				if($numrowfile > 0){
						$img_pdf = "<A href=\"#\" OnClick=\"window.open('report_scan_false_detail_person.php?profile_id=$profile_id&idcard=$rs1[idcard]&fullname=$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]','_blank','address=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=400')\"><img src=\"../../images_sys/doc_problem.png\" width=\"23\" height=\"22\" title='คลิ๊กเพื่อดูประวัติิการ upload ไฟล์ ก.พ.7' border='0'></a>";	
				}else{
						$img_pdf = "";
				}
				
				
			}
			
			########  ตรวจสอบความสมบูรณ์ของรายการที่ตรวจสอบ
			if($rs1[general_status] == "1" and $rs1[graduate_status] == "1" and $rs1[salary_status] == "1"  and $rs1[seminar_status] == "1" and $rs1[sheet_status] == "1" and $rs1[getroyal_status] == "1" and $rs1[special_status] == "1" and  $rs1[goodman_status] == "1" and $rs1[absent_status] == "1" and $rs1[nosalary_status] == "1" and $rs1[prohibit_status] == "1" and $rs1[specialduty_status] == "1" and $rs1[other_status] == "1"){
					$file_complate = "1";
			}else if($rs1[general_status] == "0" or $rs1[graduate_status] == "0" or $rs1[salary_status] == "0"  or $rs1[seminar_status] == "0" or $rs1[sheet_status] == "0" or $rs1[getroyal_status] == "0" or $rs1[special_status] == "0" or $rs1[goodman_status] == "0" or $rs1[absent_status] == "0" or $rs1[nosalary_status] == "0" or $rs1[prohibit_status] == "0" or $rs1[specialduty_status] == "0" or $rs1[other_status] == "0"){
					$file_complate = "0";
			}else{
					$file_complate = "";
			}
			
			
			if(trim($rs1[comment_pic]) != ""){
				$alert_pic = "<img src=\"../../images_sys/alert.png\" width=\"15\" height=\"14\" border=\"0\" title='เอกสารที่หมายเหตุหลังจำนวนรูปภาพอาจหมายถึงเอกสารไม่มีปกหน้าเป็นต้น'>";
			}else{
				$alert_pic = "";
			}
			## end แสดงไฟล์  upload
	  ?>
	  
      <tr bgcolor="<?=$bg?>" <?=$tr_title?>>
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs1[idcard]?><?=$alert_pic?>
          </td>
        <td align="left"><? echo "$rs1[prename_th]";?></td>
        <td align="left"><? echo "$rs1[name_th]";?></td>
        <td align="left"><? echo "$rs1[surname_th]";?></td>
        <td align="center"><? echo "$rs1[position_now]";?></td>
        <td align="center"><?=show_icon_check($rs1[status_file],$rs1[status_check_file],$rs1[status_numfile],$file_complate);?><? if($rs1[problem_status_id] > 0){ echo "<font color='red'>*</font>";}else{ echo "";}?></td>
        <td align="center"><? if($rs1[page_num] > 0){ echo number_format($rs1[page_num]); }else{ echo "-";}?></td>
        <td align="center"><?  if($rs1[page_upload] > 0){ echo number_format($rs1[page_upload]); }else{ echo "-";}  if($link_up_count_pdf == 1){ echo " <a href=\"count_filepdf.php?temp_siteid=$rs1[siteid]&xidcard=$rs1[idcard]&profile_id=$profile_id\" target=\"_blank\"> ประมวลผล </a>";}?></td>
        <td align="center"><?=$img_pdf?></td>
        <td align="center"><? if($rs1[pic_num] > 0){ echo number_format($rs1[pic_num]);}else{ echo "-";}?></td>
        <td align="center">
        <?
        	echo "$rs1[pic_upload]";
		?> 
        </td>
        <td align="center"><?
        $sql_numpic = "SELECT * FROM upload_compare_kp7 WHERE id='$rs1[idcard]'";
		$result_numpic = @mysql_db_query($dbname_temp,$sql_numpic);
		$rs_numpic = @mysql_fetch_assoc($result_numpic);
		echo $rs_numpic[number];
		?></td>
		<td align="center">
<? if($file_complate == "1"){ // ไฟล์ที่สมบูรณ์เท่านั้น?>
       <A href="#" onClick="window.open('check_kp7_popup_upload.php?idcard=<?=$rs1[idcard]?>&profile_id=<?=$profile_id?>&xsiteid=<?=$rs1[siteid]?>&lv=<?=$lv?>&schoolid=<?=$rs1[schoolid]?>&sentsecid=<?=$rs1[siteid]?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=400');"><img src="../../images_sys/move-file-icon.png" width="25" height="25" border="0"  title="คลิ๊กเพื่อ upload ไฟล์ ก.พ. 7 ต้นฉบับ"></a><? }//end  if($file_complate == "1"){ ?>&nbsp;
<? // if(CheckLockArea($sentsecid) > 0){ echo "<em>Lock</em>"; }else{?>
		<img src="../../images_sys/b_edit.png" width="16" height="16" border="0" alt="แก้ไขรายการ" onClick="location.href='form_manage_checklist.php?action=EDIT&sentsecid=<?=$rs1[siteid]?>&idcard=<?=$rs1[idcard]?>&fullname=<? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'" style="cursor:hand">
        <? //} //end if(CheckLockArea($rs[secid]) > 0){ ?>
		&nbsp;&nbsp;
		<? if($rs1[status_file] != "1"){?>
		<img src="../../images_sys/b_drop.png" width="16" height="16" border="0" alt="ลบรายการ" onClick="return confirmDelete('check_kp7_area.php?action=DEL&sentsecid=<?=$rs1[siteid]?>&idcard=<?=$rs1[idcard]?>&fullname=<? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>')" style="cursor:hand">
		&nbsp;&nbsp;<? } //end if($rs1[status_file] != "1"){ ?>
          <? //if(CheckLockArea($sentsecid) <  1){  // กรณี log เขต?>
        <a href="?action=execute&sentsecid=<?=$rs1[siteid]?>&idcard=<?=$rs1[idcard]?>&fullname=<? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>"><img src="../../images_sys/refresh.png" width="18" height="18" border="0" alt="คลิ๊กเพื่อบันทึกผลการตรวจสอบเอกสาร"></a>
		<? //} //end  if(CheckLockArea($sentsecid) <  1){ ?>
		
<?
$sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$rs1[idcard]' AND status_problem = '0' AND profile_id='$profile_id'   ORDER BY menu_id,problem_id  ASC";
$result_detail = mysql_db_query($dbtemp_check,$sql_detail);
if (@mysql_num_rows($result_detail) > 0 ){ 
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#A8B9FF"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#A8B9FF"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?

					$j=0;
					while($rs_d = mysql_fetch_assoc($result_detail)){
					
					
						if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
				?>
              <tr bgcolor="<?=$bg1?>">
                <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
                <td align="left"><?=$rs_d[problem_detail]?></td>
                </tr>
               <?
					}//end while(){
			   ?>
            </table>
<? } ########## END if (@mysql_num_rows(result_detail) > 0 ){ 

if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $kx1 => $vx1){
			if($rs1[$kx1] != ""){
					$arrcomp[$vx1] = $rs1[$kx1];
			}
		}//end foreach($arrfield_comment as $kx1 => $vx1){
}// end if(count($arrfield_comment) > 0){

if(count($arrcomp) > 0){
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
    <td colspan="2" bgcolor="#009900" align="center"><strong>หมายเหตุรายการเอกสารสมบูรณ์</strong></td>
    </tr>
  <tr>
    <td bgcolor="#009900" align="center">หมวดข้อมูล</td>
    <td bgcolor="#009900" align="center">หมายเหตุ</td>
  </tr>
    <? 
	foreach($arrcomp as $keyc => $valc){
	?>
  <tr>
    <td width="44%" bgcolor="#FFFFFF"><?=$keyc?></td>
    <td width="56%" bgcolor="#FFFFFF"><?=$valc?></td>
  </tr>
  <?
	}//end  foreach($arrcomp as $keyc => $valc){
  ?>
</table>

<? }//end if(count($arrcomp) > 0){?>
</td>
      </tr>
	  <?
	  $arrcomp = array();
	 
	  	}//end while(){
		} //end if($all < 1){
		if($all > 0){ //
	  ?>
      <tr>
        <td colspan="14" align="center" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
	<? } //end 	if($all > 0){?>
    </table></td>
  </tr>
</table>

  <?
	}else if($action == "execute"){
	
		$sql_edit = "SELECT * FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
		$result_edit = mysql_db_query($dbname_temp,$sql_edit);
		$rs_e = mysql_fetch_assoc($result_edit);
		
		$sql_chedit = "SELECT COUNT(idcard) as NUMCH FROM tbl_checklist_kp7  WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id' AND status_numfile='1' AND status_check_file='YES' AND status_file='0'";
		$result_chedit = mysql_db_query($dbname_temp,$sql_chedit);
		$rsch = mysql_fetch_assoc($result_chedit);
		if($rsch[NUMCH] > 0){
				$disb = "";
		}else{
				$disb = " disabled";	
		}
		

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><form name="form2" method="post" action="" onSubmit="return check_F();" enctype="multipart/form-data">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#FFFFFF"><strong><a href="check_kp7_area.php?action=&sentsecid=<?=$sentsecid?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&profile_id=<?=$profile_id?>"><img src="../../images_sys/home.gif" alt="กลับหน้าหลัก" width="20" height="20" border="0"></a>&nbsp;ตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับของ&nbsp;<?=$fullname?></strong></td>
          </tr>
          <?
          $sql_sf = "SELECT user_update,user_save  FROM tbl_checklist_log where type_action='1' and idcard='$rs_e[idcard]' AND profile_id='$profile_id' ORDER BY time_update DESC LIMIT 1;";
		  $result_sf1 = mysql_db_query($dbname_temp,$sql_sf);
		  $rs_sf1 = mysql_fetch_assoc($result_sf1);
		 // echo $rs_sf1[user_update];
		  	
		  ?>
        <tr>
          <td colspan="2" align="right" valign="top" bgcolor="#FFFFFF"><strong>พนักงานที่ตรวจเอกสาร : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="user_check" id="user_check">
            <option value="">เลือกพนักงาน</option>
            <?
			if( $xstr_arr!=""){
				$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES' and staffid in($xstr_arr) ORDER BY staffname ASC";
			}else{
				$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES'  ORDER BY staffname ASC";
			}
            	
				//echo $sql_staff;
				$result_staff = mysql_db_query($dbcallcenter_entry,$sql_staff);
				while($rs_sf = mysql_fetch_assoc($result_staff)){
						if($rs_sf1[user_update] == $rs_sf[staffid]){  $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_sf[staffid]' $sel>$rs_sf[staffname] $rs_sf[staffsurname]</option>";
				}//end while($rs_sf = mysql_fetch_assoc($result_staff)){
			?>
            </select>
        
            <input type="button" name="button" id="button" value="กำหนดพนักงานตรวจ" style="font-size:12px;width:auto;height:auto" onClick="setuser();">
            <br>
            <input type="checkbox" name="cls_usercheck" id="cls_usercheck" value="1">
            คลิ๊กเพื่อล้างค่าการตรวจเอกสาร
          </label></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="right" bgcolor="#FFFFFF"><strong>พนักงานที่บันทึกรายการ : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?
          	$sql_s1 = "SELECT * FROM keystaff WHERE staffid='$rs_sf1[user_save]'";
			$result_s1 = mysql_db_query($dbcallcenter_entry,$sql_s1);
			$rss1 = mysql_fetch_assoc($result_s1);
			echo "$rss1[prename]$rss1[staffname]  $rss1[staffsurname]";
		  
		  ?></td>
        </tr>
        <tr>
          <td width="27%" align="center" bgcolor="#FFFFFF"><strong>หมวดรายการ </strong></td>
          <td width="25%" align="center" bgcolor="#FFFFFF"><strong>สถานะความสมบูรณ์ของเอกสาร</strong></td>
          <td width="48%" align="center" bgcolor="#FFFFFF"><strong>หมายเหต</strong>ุ</td>
          </tr>
<!--        <tr>
          <td align="left" bgcolor="#FFFFFF"> สถานะเอกสารต้นฉบับ</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="status_file"  id="status_file" type="radio" value="1" <?// if($rs_e[status_file] == "1"){ echo "checked=\"checked\"";}?>>
            สมบูรณ์
            <input name="status_file" id="status_file" type="radio" value="0" <?// if($rs_e[status_file] == "0"){  echo "checked=\"checked\"";}?>>
            ไม่สมบูรณ์
          </label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_file" value="<?//=$rs_e[comment_file]?>">
          </label></td>
          </tr>
-->       

        <tr>
          <td align="left" bgcolor="#CCCCCC">สถานะการนับไฟล์</td>
          <td align="left" bgcolor="#CCCCCC">
            <input type="radio" name="status_numfile" id="radio" value="1" <? if($rs_e[status_numfile] == "1"){ echo "checked='checked'";}?>>
            ตรวจนับ
            <input type="radio" name="status_numfile" id="radio2" value="0" <? if($rs_e[status_numfile] == "0"){ echo "checked='checked'";}?>>
            ยังไม่ตรวจนับ</td>
          <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>

        <tr>
          <td align="left" bgcolor="#FFFFFF">ชนิดเอกสารทะเบียนประวัติ</td>
          <td align="left" bgcolor="#FFFFFF">
            <input type="radio" name="type_doc" id="radio5" value="1" <? if($rs_e[type_doc] == "1"){ echo "checked='checked'";}?>>
          รุ่นใหม่ 
          <input type="radio" name="type_doc" id="radio6" value="0" <? if($rs_e[type_doc] == "0"){ echo "checked='checked'";}?>>
          รุ่นเก่า</td>
          <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">จำนวนแผ่นเอกสาร</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="page_num">
			<option value="0">จำนวนแผ่น</option>
			<?
				for($i=0;$i<=31;$i++){
					if($rs_e[page_num] == $i){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$i' $sel>$i</option>";
				}
			?>
            </select>
            แผ่น
          </label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
           <!-- <input name="comment_page" type="text" value="<?=$rs_e[comment_page]?>" size="50">-->
          </label></td>
          </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">จำนวนรูป</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="pic_num">
			<option value="0">จำนวนรูป</option>
			<?
				for($n=0;$n <= 20; $n++){
					if($rs_e[pic_num] == $n){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$n' $sel>$n</option>";
				}
			?>
            </select>
          รูป</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_pic" value="<?=$rs_e[comment_pic]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">ปกเอกสาร</td>
          <td align="left" bgcolor="#FFFFFF">
            <input type="radio" name="mainpage" id="radio3" value="1" <? if($rs_e[mainpage] == "1"){ echo "checked='checked'";}?>>
          มีปก 
          <input type="radio" name="mainpage" id="radio4" value="0" <? if($rs_e[mainpage] == "0"){ echo "checked='checked'";}?>>
          ไม่มีปก</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="mainpage_comment" type="text" id="textfield" size="50" value="<?=$rs_e[mainpage_comment]?>">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#CCCCCC">เลือกรายการทั้งหมด</td>
          <td align="left" bgcolor="#CCCCCC">
            <input type="radio" name="radio_all" id="radio_all1" value="1" onClick="return check_radio_all(this.value)">
          สมบูรณ์ 
          <input type="radio" name="radio_all" id="radio_all2" value="2" onClick="return check_radio_all(this.value)">
          ไม่สมบูรณ์</td>
          <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
		<?
			$sql_m1 = "SELECT * FROM tbl_check_menu ORDER BY orderby ASC";
			$result_m1 = mysql_db_query($dbname_temp,$sql_m1);
			$xi = 0;
			while($rsm1 = mysql_fetch_assoc($result_m1)){
			$fieldname = $rsm1[field_name];
			$fieldcom = $rsm1[field_comment];
			if($rs_e["$fieldname"] == "0"){ $disp = "style='display:'"; $disp1 = "style='display:none'";}else if($rs_e["$fieldname"] == "1"){ $disp = "style='display:none'";$disp1 = "style='display:'";}else{ $disp = "style='display:none'";$disp1 = "style='display:none'";}
			
			$xi++;
		?>
        <tr>
          <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left"><?=$rsm1[menu_detail]?></td>
            </tr>
          </table></td>
          <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left"><input name="<?=$fieldname?>" id="<?=$fieldname."1"?>" type="radio" value="1" <? if($rs_e["$fieldname"] == "1"){ echo "checked='checked'";}?> onClick="return sw_table(this.value,'<?=$rsm1[menu_id]?>');">
          สมบูรณ์ 
          <input name="<?=$fieldname?>" type="radio" id="<?=$fieldname."2"?>"  value="0" <? if($rs_e["$fieldname"] == "0"){ echo "checked='checked'";}?> onClick="return sw_table(this.value,'<?=$rsm1[menu_id]?>');">
          ไม่สมบูรณ์</td>
            </tr>
          </table></td>
          <td align="left" bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" id="xtblName<?=$rsm1[menu_id]?>" <?=$disp1?>>
            <tr>
              <td>
                <input name="commentT[<?=$fieldcom?>]" type="text" id="commentT<?=$xi?>" size="50" value="<?=$rs_e[$fieldcom]?>"></td>
            </tr>
          </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblName<?=$rsm1[menu_id]?>" <?=$disp?>>
  <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td colspan="2" align="center" bgcolor="#A8B9FF"><strong><?=$rsm1[menu_detail]?></strong></td>
                  </tr>
                <tr>
                  <td width="46%" align="center" bgcolor="#A8B9FF"><strong>หมวดปัญหา</strong></td>
                  <td width="54%" align="center" bgcolor="#A8B9FF"><strong>หมายเหตุ</strong></td>
                </tr>
				<? 
				$n=0;
				foreach($arr_problem as $k1 => $v1){
					$sql_1 = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND problem_id='$k1' AND menu_id='$rsm1[menu_id]' AND profile_id='$profile_id'";
					$result_1 = mysql_db_query($dbname_temp,$sql_1);
					$rs_1 = mysql_fetch_assoc($result_1);
					if ($n++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
					if($rs_1[problem_id] != ""){ $chk = "checked='checked'"; $distxt = "";}else{ $chk = ""; $distxt = " disabled='disabled'";}
					
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="left"><label>
                    <input type="checkbox" name="check_problem[<?=$idcard?>][<?=$rsm1[menu_id]?>][<?=$k1?>]" id="check_problem<?=$rsm1[menu_id]?><?=$k1?>" value="<?=$k1?>" <?=$chk?> onClick="return control_checkbox(this.value);"><?=$v1?>
                  </label></td>
                  <td><label>
                    <input name="problem_detail[<?=$idcard?>][<?=$rsm1[menu_id]?>][<?=$k1?>]" type="text" id="problem_detail<?=$rsm1[menu_id]?><?=$k1?>" size="30" value="<?=$rs_1[problem_detail]?>" <?=$distxt?>>
                  </label></td>
                </tr>
				<?
					} //end foreach($arr_problem as $k1 => $v1){
				?>
              </table></td>
            </tr>
        </table></td>
        </tr>
	<?
		}//end while($rsm1 = mysql_fetch_assoc($result_m1)){
	?>
            <tr>
          <td align="left" bgcolor="#CCCCCC">สถานะการส่งเอกสารกลับเพื่อแก้ไข</td>
          <td align="left" bgcolor="#CCCCCC">
            <select name="problem_status_id" id="problem_status_id" <?=$disb?>>
            <option value="">เลือกสถานะแก้ไขเอกสาร</option>
            	<?
                	$sql_ps = "SELECT * FROM tbl_checklist_problem_status ORDER BY orderby ASC";
					$result_ps = mysql_db_query($dbname_temp,$sql_ps);
					while($rsps = mysql_fetch_assoc($result_ps)){
						if($rsps[problem_status_id] == $rs_e[problem_status_id]){  $sel = "selected='selected'"; }else{ $sel = "";}
						echo "<option value='$rsps[problem_status_id]' $sel>$rsps[problen_status_name]</option>";
					}//end 
				?>
            
            </select>
         </td>
          <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>

    
    
        <tr>
          <td align="left" bgcolor="#FFFFFF">แนบไฟล์แสกนต้นฉบับ</td>
          <td colspan="2" align="left" bgcolor="#FFFFFF">
            <input type="file" name="kp7_file" id="kp7_file">
          &nbsp;<strong>รหัสบัตร 
          : <?=$idcard?>
          </strong></td>
          </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">วันที่ upload ไฟล์ต้นฉบับ</td>
          <td colspan="2" align="left" bgcolor="#FFFFFF"><INPUT name="date_upload" onFocus="blur();" value="<? if($date_upload == ""){ echo date("d/m/").(date("Y")+543);}else{ echo $date_upload;}?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.date_upload, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
        </tr>
        <tr>
          <td height="35" colspan="3" align="center" valign="bottom" bgcolor="#FFFFFF"><label>
		  <input type="hidden" name="action" value="process">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		  <input type="hidden" name="idcard" value="<?=$idcard?>">
		  <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
		  <input type="hidden" name="schoolid" value="<?=$schoolid?>">
		  <input type="hidden" name="lv" value="<?=$lv?>">
		  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
          <input type="hidden" name="extra" value="<?=$extra?>">
            <input type="submit" name="Submit2" value="บันทึก">
            &nbsp;
            <input type="reset" name="Submit3" value="ล้างค่า">
			&nbsp;
           
            <?
			if($extra == "1"){
				echo " <input type=\"button\" name=\"btnClose\" value=\"ปิดหน้าต่าง\" onClick=\"window.close()\">";
			}else{	
			?>
            <input type="button" name="btnB" value="ยกเลิก" onClick="location.href='check_kp7_area.php?action=&sentsecid=<?=$sentsecid?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>'">
            <? } //end  if($extra == "1"){ ?>
          </label></td>
          </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<? }//end else if($action == "execute"){ ?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
