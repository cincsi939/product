<?php
/**
* @comment upload ไฟล์ excel
* @projectCode 56EDUBKK01
* @tor 7.2
* @package core
* @author Suwat.K 
* @access public/private
* @created 03/06/2014
*/
set_time_limit(0);
$path_config = '../../../';
include("../checklist2.inc.php");
include("function_imp.php");
include("../../pic2cmss/function/function.php");

CreateSiteProfile($xsiteid,$profile_id); // สร้าง เขต profile ข้อมูล
LogImpExpExcel($xsiteid,$profile_id,"นำเข้าข้อมูล excel เพื่อเป็นข้อมูลตั้งต้น");

require_once 'Excel/reader.php';

function GetRandomString($length){
	
	$template = "1234567890abcdefghijklmnopqrstuvwxyz";  
    
	settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
    	$b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('TIS-620');



//error_reporting(E_ALL ^ E_NOTICE);

/*
echo "<pre>";
print_r($data->sheets);
die;
*/


if($process=="execute"){
	
	

	$myfile = GetRandomString(7);

	while(is_file($myfile.".xls")){
		$myfile = GetRandomString(7);
	}
	//echo "$name<hr>";die;

	if(!copy($name,"upload_tmp/".$myfile.".xls")){
		//cannot copy file
		echo "&error_msg=การอัพโหลดข้อมูล ผิดพลาด ไม่สามารถ Backup ไฟล์ $filename2 ได้";
		die;
	}else{
		//write log keyin
		chmod("upload_tmp/".$myfile.".xls", 0777); 
	}

//$myfile = "8buia4qh";
//echo "AAAAAAAAAAAAAAAAAAAAAAA<br>$myfile<br>
//<a href='upload_tmp/$myfile".".xls''>$myfile</a><br>
//";
$data->read('upload_tmp/'.$myfile.'.xls');
/*echo "$myfile <br>";
echo "<pre>";
print_r($data);*/

if(!count($data->sheets)){
	echo "&error_msg=ไม่สามารถอ่านข้อมูลในไฟล์ได้ อาจเป็นผลมาจากไฟลไม่ถูกต้อง หรือรูปแบบไฟล์ไม่ถูกต้อง";
	die;
}


	
		$setstrartrow = 3;
				
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
			if(trim($data->sheets[0]['cells'][$i][1]) != ""){ // ตรวจสอบเลขบัตรต้องไม่เป็นค่าว่าง
			
			$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // เลขบัตร
			$prename_th = trim($data->sheets[0]['cells'][$i][3]) ; // คำนำหน้าชื่อ
			$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ชื่อ
			$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // นามสกุล
			$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ตำแหน่ง
			$arr_pos = explode("/",$position_now);
			if(count($arr_pos) > 1){ // กรณีตำแหน่งกรอกเป็น "/วิทยฐานะ"
				$position_now = $arr_pos[0];
			}// if(count($arr_pos) > 1){
			
			
			$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // โรงเรียน
			$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // รหัสโรงเรียน
			
			if($schoolid == ""){
				$schoolid = GetSchoolid($xsiteid,$schoolname); // หารหัสโรงเรียน
			}//end if($schoolid == ""){

			
			$temp_birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  วันเดือนปีเกิด
			$temp_begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  วันเริ่มปฏิบัติราชการ
			$arr_b = explode("-",$temp_birthday); // arr วันเกิด
			$arr_f = explode("-",$temp_begindate); // arr วันเริ่มปฏิบัติราชการ
			$num_ref = trim($data->sheets[0]['cells'][$i][20]) ; // จำนวนเอกสารนำส่ง
			
			######  วันเดือนปีเกิด ##########################################################
			if(count($arr_b) > 0){
				if($arr_b[2] > 0 and $arr_b[0] < 2000){ // แสดงว่าเป็นรูปแบบ xx-Jan-xx เช่า 02 Oct  59
					$birthday = ($arr_b[2]+1900+543)."-".$arr_text_month["$arr_b[1]"]."-".$arr_b[0];				
				}else if($arr_b[0] > 2000){ // แสดงว่ารูปแบบวันที่ในไฟล์ excel เป็น YYYY-mm-dd แล้ว เช่น 2502-10-02
					$birthday = $temp_birthday;
				}else{
					$birthday = "0000-00-00";	
				}
						
			}else{
				$birthday = "0000-00-00";
			}//end if(count($arr_b) > 0){
				
		################# วันเริ่มปฏิบัติราชการ ############################################
			if(count($arr_f) > 0){
				if($arr_f[2] > 0 and $arr_f[0] < 2000){ // แสดงว่าเป็นรูปแบบ xx-Jan-xx เช่า 02 Oct  59
					$begindate = ($arr_f[2]+1900+543)."-".$arr_text_month["$arr_f[1]"]."-".$arr_f[0];				
				}else if($arr_f[0] > 2000){ // แสดงว่ารูปแบบวันที่ในไฟล์ excel เป็น YYYY-mm-dd แล้ว เช่น 2502-10-02
					$begindate = $temp_begindate;
				}else{
					$begindate = "0000-00-00";	
				}
						
			}else{
				$begindate = "0000-00-00";
			}//end if(count($arr_b) > 0){
		######################  end  วันเริ่มปฏิบัติราชการ  ###################################
			
			
					//$sex = trim($data->sheets[0]['cells'][$i][21]) ;//  เพศ
					$sql_find_sex="SELECT
					t1.prename,
					t1.gender_id
					FROM
					hr_prename AS t1
					WHERE t1.prename='$prename_th' ";
					$result_sex=mysql_db_query(DB_MASTER,$sql_find_sex);
					$row_sex=mysql_fetch_assoc($result_sex);
					$sex =$row_sex[gender_id];
					
					if($prename_th != ""){
							$conupdate_data .=  " ,prename_th='$prename_th' ";
					}
					if($name_th != ""){
							 $conupdate_data .= " ,name_th='$name_th'";
					}
					if($surname_th != ""){
							 $conupdate_data .= " ,surname_th='$surname_th'";
					}
					if($position_now != ""){
							$conupdate_data .= " ,position_now='$position_now'";
					}
					
					
					
					
					if(CheckSchoolMathSite($schoolid,$xsiteid) > 0){
							$conupdate_data .= " ,schoolid='$schoolid'";
					}
					
					if($birthday != "" and $birthday != "0000-00-00"){
							$conupdate_data .= " ,birthday='$birthday'";
					}
					if($begindate != "" and $begindate != "0000-00-00"){
							$conupdate_data .= " ,begindate='$begindate'";
					}
					if($sex == "1" or $sex == "2"){
							$conupdate_data .= " ,sex='$sex'";
					}
					
					
					
					#@modify Suwat.K  03/05/2014 ตรวจสอบการเช็คเลขบัตร
					#if((!Check_IDCard($idcard)) or (substr($idcard,0,1) == "0")){
					if((!Check_IDCard($idcard))){
						$conupdate_data .= ",status_id_false='1'";
					}else{
						$conupdate_data .= ",status_id_false='0'";
					}
					# end
					
					$arr_rp = CheckIdReplaceChecklist($xsiteid,$idcard,$profile_id); // ตรวจสอบข้อมูลซ้ำใน checklist
					
					$status_retire = 0;
					if($birthday != "" and $birthday != "0000-00-00"){
						if(ChRetireDate($birthday) == "0"){
							$status_retire = 1;// เกษียณอายุราชการแล้ว
						}else{
							$status_retire = 0; // ยังไม่เกษียณ
						}
					}//end if($birthday != "" and $birthday != "0000-00-00"){


					if($staffid == ""){ // กรณีในไฟล์ excel ไม่ได้ระบบข้อมูล
							$staffid = $_SESSION['session_staffid'];
					}
					### end เก็บข้อมูล temp
					
					if($arr_rp['msg'] == "" and $status_retire == "0"){ // ตรวจสอบข้อมูลซ้ำใน checklist ไม่พบข้อมูลซ้ำ
						$sql_ch1 = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t1.salary,
t1.noposition,
t1.sex,
t1.type_doc,
t1.status_numfile,
t1.status_file,
t1.comment_file,
t1.page_num,
t1.comment_page,
t1.pic_upload,
t1.pic_num,
t1.comment_pic,
t1.mainpage,
t1.mainpage_id,
t1.mainpage_comment,
t1.general_status,
t1.comment_general,
t1.graduate_status,
t1.comment_graduate,
t1.salary_status,
t1.comment_salary,
t1.seminar_status,
t1.comment_seminar,
t1.sheet_status,
t1.comment_sheet,
t1.getroyal_status,
t1.comment_getroyal,
t1.special_status,
t1.comment_special,
t1.goodman_status,
t1.comment_goodman,
t1.absent_status,
t1.comment_absent,
t1.nosalary_status,
t1.comment_nosalary,
t1.prohibit_status,
t1.comment_prohibit,
t1.specialduty_status,
t1.comment_specialduty,
t1.other_status,
t1.comment_other,
t1.status_check_file,
t1.file_upload,
t1.time_update,
t1.status_id_replace,
t1.siteid_replace,
t1.page_upload,
t1.page_upload_log,
t1.status_id_false,
t1.flag_uploadfalse,
t1.problem_status_id,
t1.status_follow_doc,
t1.pic_num_old,
t1.pic_num_new_cut,
t1.page_num_new,
t1.staff_upload_pic,
t1.date_upload_pic,
t1.flag_data_old,
t1.hash_kp7file,
t1.num_ref,
t1.num_actual
FROM
tbl_checklist_kp7 AS t1
 WHERE t1.idcard='$idcard' AND t1.profile_id='$profile_id' AND t1.siteid='$xsiteid'";
						$result_ch1 = mysql_db_query($dbname_temp,$sql_ch1);
						$rsch1 = mysql_fetch_assoc($result_ch1);
						if($rsch1[idcard] != ""){
								$sql_checklist = "UPDATE tbl_checklist_kp7 SET siteid='$xsiteid', num_ref='$num_ref', status_file='1' $conupdate_data    WHERE  idcard='$idcard' AND profile_id='$profile_id'";
						}else{
								$sql_checklist = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard',siteid='$xsiteid',profile_id='$profile_id', num_ref='$num_ref', status_file='1' $conupdate_data ";
						}//end if($rsch1[idcard] != ""){
							
							
							mysql_db_query($dbname_temp,$sql_checklist) or die(mysql_error()."$sql_checklist");
							insert_log_import($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจาก excel จ.18 เพื่อเป็นข้อมูลตั้งต้น","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจาก excel จ.18 เพื่อเป็นข้อมูลตั้งต้น","1","$staffid","","","",$profile_id);
							GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
							
					}else{
							$sql_rep1 = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t1.status_file,
t1.comment_file,
t1.page_num,
t1.comment_page,
t1.pic_num,
t1.comment_pic,
t1.mainpage,
t1.mainpage_comment,
t1.general_status,
t1.comment_general,
t1.graduate_status,
t1.comment_graduate,
t1.salary_status,
t1.comment_salary,
t1.seminar_status,
t1.comment_seminar,
t1.sheet_status,
t1.comment_sheet,
t1.getroyal_status,
t1.comment_getroyal,
t1.special_status,
t1.comment_special,
t1.goodman_status,
t1.comment_goodman,
t1.absent_status,
t1.comment_absent,
t1.nosalary_status,
t1.comment_nosalary,
t1.prohibit_status,
t1.comment_prohibit,
t1.specialduty_status,
t1.comment_specialduty,
t1.other_status,
t1.comment_other,
t1.status_check_file,
t1.file_upload,
t1.time_update,
t1.status_IDCARD,
t1.status_IDCARD_REP,
t1.status_retire,
t1.site_replace,
t1.status_school_fail,
t1.status_position_fail,
t1.conf_replace,
t1.comment_replace,
t1.curent_site,
t1.new_idcard,
t1.status_chang_idcard,
t1.status_id_replace,
t1.siteid_replace,
t1.error_site
FROM
tbl_checklist_kp7_false AS t1
 WHERE t1.idcard='$idcard' AND t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' ";
							$result_rep1 = mysql_db_query($dbname_temp,$sql_rep1);
							$rs_rep1 = mysql_fetch_assoc($result_rep1);
							if($rs_rep1[idcard] == ""){
							$sql_checklist_rep  = "INSERT INTO tbl_checklist_kp7_false SET profile_id='$profile_id', idcard='$idcard', siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$birthday',begindate='$begindate',position_now='$position_now',schoolid='$schoolid',site_replace='".$arr_rp['siteid']."', status_retire='$status_retire',status_IDCARD_REP='".$arr_rp['msg']."' ";
							mysql_db_query($dbname_temp,$sql_checklist_rep) or die(mysql_error()."$sql_checklist_rep");
							}//end if($rs_rep1[idcard] == ""){
					}// end if($arr_rp['msg'] != ""){if($arr_rp['msg'] != ""){ // ตรวจสอบข้อมูลซ้ำใน checklis

$conupdate_data="";

		}//end if(trim($data->sheets[0]['cells'][$i][1]) != ""){
	}// end for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
chkUpdateNewCut_ALL($xsiteid);
echo "<script language=\"javascript\"> alert('นำเข้าข้อมูลตั้งต้นเรียบร้อยแล้วกรุณาตรวจสอบข้อมูลซ้ำและรายชื่อการเกษียณอายุราชการ');
window.opener.location='../../hr3/import_dbf_pobec_checklist/list_area_import_check.php?profile_id=$profile_id';
window.close();
</script>
";

}//	if($process=="execute"){	




?>

