<?php
set_time_limit(0);
include("../checklist2.inc.php");
include("../../../config/conndb_nonsession.inc.php");
include("function_imp.php");
include("../../pic2cmss/function/function.php");

####  ตรวจสอบในกรณีมีการ uplolad ไฟล์ของคนเดิมซ้ำ
if($debug == "on"){
$arrup = GetPrecessUpload("1101","4","99999");
if(count($arrup > 0)){	
	$xnumall = $arrup['numall']; // จำนวนเอกสารทั้งหมด
	$xnumpic = $arrup['pic']; // จำนวนรูปที่ up ได้ทั้งหมด
	$xnumpage = $arrup['page']; // จำนวนหน้า
	$xnumupload = $arrup['upload'];
	$xnumuploadall = $arrup['uploadall'];
	$xnumuploaddiff = $arrup['uploaddiff'];
		echo "<script>alert('ผลการ upload เอกสาร ก.พ. 7\\n จำนวนเอกสารทั้งหมด $xnumall คน \\n จำนวนเอกสารที่ดำเนินการแล้วทั้งหมด $xnumuploadall คน \\n จำนวนเอกสารค้างดำเนินการ $xnumuploaddiff  คน \\nจำนวนที่ดำเนินการได้ $xnumupload คน  \\n จำนวนการ upload รูปภาพ $xnumpic  รูปภาพ \\n จำนวนแผ่นเอกสารที่ดำเนินการได้  $xnumpage แผ่น ');</script>";

}
	echo "xxxx";die;

}//end if($debug == "on"){
	
	
##########  ทำการยืนยันปิดทำการข้อมูล
if($conF_site != ""){
	$sqlc1 = "SELECT * FROM tbl_checklist_kp7_confirm_site WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
	$resultc1 = mysql_db_query($dbname_temp,$sqlc1);
	$rsc1 = mysql_fetch_assoc($resultc1);
	if($rsc1[siteid] == ""){
		$sql_insert = "INSERT INTO tbl_checklist_kp7_confirm_site SET siteid='$xsiteid',profile_id='$profile_id',flag_xls_endprocess='$conF_site',staff_endprocess='".$_SESSION['session_staffid']."',flag_download_xls='1',staff_download='".$_SESSION['session_staffid']."'";
	}else{
		$sql_insert = "UPDATE tbl_checklist_kp7_confirm_site SET flag_xls_endprocess='$conF_site',staff_endprocess='".$_SESSION['session_staffid']."' WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
	}//end if($rsc1[siteid] == ""){
		$result_insert = mysql_db_query($dbname_temp,$sql_insert);
		
		if($conF_site == "1"){
			SaveLogConfirmSite($xsiteid,$profile_id,"2","upload ข้อมูลเสร็จสิ้น ","$conF_site");	
		}// end if($conF_site == "1"){
		
		
}// end if($conF_site != ""){




LogImpExpExcel($xsiteid,$profile_id,"นำเข้าข้อมูล excel เพื่อปรับปรุงข้อมูลในการตรวจสอบเอกสารต้นฉบับ");
?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
</HEAD>
<BODY bgcolor="#A5B2CE">

<p>
  <?

require_once 'Excel/reader.php';
$setstrartrow = 4 ; // บรรทัดแรกของข้อมูล

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

$data->read('upload_tmp/'.$myfile.'.xls');
//echo "<pre>";
//print_r($data);die;

if(!count($data->sheets)){
	echo "&error_msg=ไม่สามารถอ่านข้อมูลในไฟล์ได้ อาจเป็นผลมาจากไฟลไม่ถูกต้อง หรือรูปแบบไฟล์ไม่ถูกต้อง";
	die;
}

		$k=0;
		$a = 0;
		$v=0;
		$d=0;
		$jj=0;
		
		if(trim($data->sheets[0]['cells'][4][2]) != ""){
		  $setstrartrow = 4;
		}else{
		  $setstrartrow = 5;
		}
		
				
		$check_column = $data->sheets[0]['cells'][2][7];
		$check_position = $data->sheets[0]['cells'][2][6]; // ตรวจสอบว่าเป็นตำแหน่งรึเปล่า
		$date_upload = date("Y-m-d H:i:s"); // ที่ upload ข้อมูล
		
		//echo "$check_column  :: $check_position<br> ";
		
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
				if($check_column == "อำเภอ"){ // แสดงว่าเป็น ฟอร์มเก่าที่โหลดไป
					$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // เลขบัตร
					$prname_th = trim($data->sheets[0]['cells'][$i][3]) ; // คำนำหน้าชื่อ
					$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ชื่อ
					$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // นามสกุล
					
					if($check_position == "ตำแหน่งปัจจุบัน"){
						$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ตำแหน่ง
						$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // โรงเรียน
						$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // รหัสโรงเรียน
						$page_num = trim($data->sheets[0]['cells'][$i][10]) ;// จำนวนแผ่นเอกสาร
						$pic_num = trim($data->sheets[0]['cells'][$i][11]) ;//  จำนวนรูป
						$mainpage = 	trim($data->sheets[0]['cells'][$i][12]) ;//  สถานะปกเอกสาร
						$staffid = trim($data->sheets[0]['cells'][$i][13]) ;//  รหัสพนักงาน
						$status_data = trim($data->sheets[0]['cells'][$i][14]) ;//  สถานะการ
						$new_idcard = trim($data->sheets[0]['cells'][$i][15]) ;//  เลขบัตรใหม่
						$birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  วันเดือนปีเกิด
						$begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  วันเริ่มปฏิบัติราชการ
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][18]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][19]) ;// new pic
						
					}else{
						$schoolname = trim($data->sheets[0]['cells'][$i][6]) ; // โรงเรียน
						$schoolid = trim($data->sheets[0]['cells'][$i][7]) ; // รหัสโรงเรียน
						$page_num = trim($data->sheets[0]['cells'][$i][9]) ;// จำนวนแผ่นเอกสาร
						$pic_num = trim($data->sheets[0]['cells'][$i][10]) ;//  จำนวนรูป
						$mainpage = 	trim($data->sheets[0]['cells'][$i][11]) ;//  สถานะปกเอกสาร
						$staffid = trim($data->sheets[0]['cells'][$i][12]) ;//  รหัสพนักงาน
						$status_data = trim($data->sheets[0]['cells'][$i][13]) ;//  สถานะการ
						$new_idcard = trim($data->sheets[0]['cells'][$i][14]) ;//  เลขบัตรใหม่
						$birthday = trim($data->sheets[0]['cells'][$i][15]) ;//  วันเดือนปีเกิด
						$begindate = trim($data->sheets[0]['cells'][$i][16]) ;//  วันเริ่มปฏิบัติราชการ
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][17]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][18]) ;// new pic

					}//end if($check_position == "ตำแหน่งปัจจุบัน"){
				}else{ // แสดงว่าเป็นฟอร์มข้อมูลแบบใหม่ที่มีรหัสโรงเรียนเพิ่มเข้ามา
					$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // เลขบัตร
					$prname_th = trim($data->sheets[0]['cells'][$i][3]) ; // คำนำหน้าชื่อ
					$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ชื่อ
					$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // นามสกุล
					
					
					if($check_position == "ตำแหน่งปัจจุบัน"){
						$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ตำแหน่ง
						$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // โรงเรียน
						$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // รหัสโรงเรียน
						$page_num = trim($data->sheets[0]['cells'][$i][10]) ;// จำนวนแผ่นเอกสาร
						$pic_num = trim($data->sheets[0]['cells'][$i][11]) ;//  จำนวนรูป
						$mainpage = 	trim($data->sheets[0]['cells'][$i][12]) ;//  สถานะปกเอกสาร
						$staffid = trim($data->sheets[0]['cells'][$i][13]) ;//  รหัสพนักงาน
						$status_data = trim($data->sheets[0]['cells'][$i][14]) ;//  สถานะการ
						$new_idcard = trim($data->sheets[0]['cells'][$i][15]) ;//  เลขบัตรใหม่
						$birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  วันเดือนปีเกิด
						$begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  วันเริ่มปฏิบัติราชการ
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][18]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][19]) ;// new pic
					}else{
						$schoolname = trim($data->sheets[0]['cells'][$i][6]) ; // โรงเรียน
						$schoolid = trim($data->sheets[0]['cells'][$i][7]) ; // รหัสโรงเรียน
						$page_num = trim($data->sheets[0]['cells'][$i][9]) ;// จำนวนแผ่นเอกสาร
						$pic_num = trim($data->sheets[0]['cells'][$i][10]) ;//  จำนวนรูป
						$mainpage = 	trim($data->sheets[0]['cells'][$i][11]) ;//  สถานะปกเอกสาร
						$staffid = trim($data->sheets[0]['cells'][$i][12]) ;//  รหัสพนักงาน
						$status_data = trim($data->sheets[0]['cells'][$i][13]) ;//  สถานะการ
						$new_idcard = trim($data->sheets[0]['cells'][$i][14]) ;//  เลขบัตรใหม่
						$birthday = trim($data->sheets[0]['cells'][$i][15]) ;//  วันเดือนปีเกิด
						$begindate = trim($data->sheets[0]['cells'][$i][16]) ;//  วันเริ่มปฏิบัติราชการ
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][17]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][18]) ;// new pic

					}//end if($check_position == "ตำแหน่งปัจจุบัน"){

				}//end if($check_column == "อำเภอ"){
					
					$sql_find_sex="SELECT
					t1.prename,
					t1.gender_id
					FROM
					hr_prename AS t1
					WHERE t1.prename='$prename_th' ";
					$result_sex=mysql_db_query(DB_MASTER,$sql_find_sex);
					$row_sex=mysql_fetch_assoc($result_sex);
					$sex =$row_sex[gender_id];
					
					
					if($prname_th != ""){
							$conupdate_data .=  " ,prename_th='$prname_th' ";
					}
					if($name_th != ""){
							 $conupdate_data .= " ,name_th='$name_th'";
					}
					if($surname_th != ""){
							 $conupdate_data .= " ,surname_th='$surname_th'";
					}
					if($sex == "1" or $sex == "2"){
							$conupdate_data .= " ,sex='$sex'";
					}
					
					
					
					
				####################  เก็บ log เพื่อตรวจสอบ error ข้อมูล จากการลง list excel
					## ตรวจสอบสถานะการมีปกเอกสาร
						CleanLogError($idcard,$xsiteid,$profile_id,"1");
						if($mainpage != "" and $mainpage != "0" and $mainpage != "1"){
							SaveErrorDataFromExcel($idcard,$profile_id,$xsiteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,"1",$mainpage);	
						}
					##  ตรวจสอบหน่วยงานโรงเรียนไม่สัมพันธ์กับเขตพื้นที่การศึกษา
						CleanLogError($idcard,$xsiteid,$profile_id,"2");
						if(CheckSchoolFormChecklist($xsiteid,$schoolid) < 1){ // แสดงว่ารหัสโรงเรียนที่ upload เข้าไปไม่ถูกต้องตามโครงสร้างที่แบ่งไว้
							SaveErrorDataFromExcel($idcard,$profile_id,$xsiteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,"2",$mainpage);			
						}// end 	if(CheckSchoolFormChecklist($xsiteid,$schoolid) < 1){ 
				
				
				################## end การเก็บ log เพื่อตรวจสอบ error ข้อมูล จากการลง list excel
				##echo $idcard."::".$prname_th."<br>";	
				
				
					
					
					####  เก็บ temp ข้อมูล
					InsertTempChecklist($idcard,$xsiteid,$prname_th,$name_th,$surname_th,$profile_id);
					
					if($new_idcard != ""){
						InsertTempChecklist($new_idcard,$xsiteid,$prname_th,$name_th,$surname_th,$profile_id);	
					}// เก็บ ใน temp ก่อนในกรณีเปลี่ยนเลขบัตร
					
				if($staffid == ""){ // กรณีในไฟล์ excel ไม่ได้ระบบข้อมูล
						$staffid = $_SESSION['session_staffid'];
				}
				### end เก็บข้อมูล temp
					#############  ทำการตรวจสอบว่าจะมีการ update รหัสผู้ใชหรือไม่
						$conupstaff = StringUpdateStaff($page_num,$idcard,$profile_id,$staffid,$date_upload);
					if($new_idcard != ""){
						$conupstaff = StringUpdateStaff($page_num,$new_idcard,$profile_id,$staffid,$date_upload);	
					}
					
					#### รุ่นเอกสารรุ่นใหม่หรือรุ่นเก่า
					if($page_num > 15){ $type_doc=0;}else{ $type_doc = 1;}  // 0 คือรุ่นเก่า  1 คือรุ่นใหม่
					
					if($position_now != ""){
						$conposition_now = ",position_now='$position_now'";	
					}else{
						$conposition_now = "";
					}
					
					
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // หารหัสโรงเรียน
						}//end if($schoolid == ""){

					
						if($schoolid != ""){
								$conschool = " ,schoolid='$schoolid'";
						}else{
								$conschool = "";	
						}// if($schoolid != ""){
							
						##############  ตรวจสอบ ว่าจะต้องมีการ update  จำนวนรูปหรือจำนวนแผ่นรึเปล่า
						$conupdate_pagepic = CheckUpdatePicPagenum($idcard,$profile_id,$staffupdate,$page_num,$pic_num,$mainpage,$page_num_new,$pic_num_new_cut);
						#echo "$idcard => $profile_id => $staffupdate => $page_num => $pic_num => $mainpage => $page_num_new => $pic_num_new_cut <br>";
						#echo $page_num_new."::".$pic_num_new_cut."<br>";
						#echo $conupdate_pagepic;
						#die;
						###  end การตรวจสอบ การ update จำนวนรูปหรือจำนวนแผ่น
						
					
					$len_newid = strlen(intval($new_idcard));
					if($new_idcard != "" and $len_newid == "13"){	
					$arridx1 = CheckIdcardReplace($idcard,$new_idcard,$profile_id);
						if($arridx1[0] == 0){ // แสดงว่าไม่มีข้อมูลซ้ำ
							if(Check_IDCard($new_idcard)){
								$conupdate_id = " , idcard='$new_idcard'";
								$txtchange_id = " เปลี่ยนเป็นเลขบัตร $new_idcard";
							}else{
								$arrchid[] = "เลขบัตร $new_idcard ของ $prname_th$name_th $surname_th ไม่ถูกต้องตามกรมการปกครอง";	
							}// end 	if(Check_IDCard($new_idcard)){
						}else{
								$arrchid[] = "เลขบัตร $new_idcard ของ $prname_th$name_th $surname_th  ไปซ้ำกับ $arridx1[1]";
						}//end if(CheckIdcardReplace($idcard,$new_idcard,$profile_id) == "0"){
					}//end if($new_idcard != "" and $len_newid == "13"){	
			//echo "$idcard  :: $prname_th  :: $name_th ::  $surname_th :: $schoolid ::  $page_num :: $pic_num :: $mainpage :: $staffid :: $status_data :: $new_idcard :: $begindate :: $position_now ::$conupdate_id ";	
			//echo "<pre>";
			//print_r($arrchid);
			//die; // 3340500080803 :: นาย :: วัลลภ :: เทศวงศ์ :: บ้านทรายพูล :: อำเภอเขมราฐ :: 7 :: 3 :: 1 :: :: 0 :: 2496-07-08 :: 
					
					$xreturn = ReDataFromChecklist($idcard,$xsiteid,$profile_id);
					if($xreturn == 0){ // กรณีไม่มีข้อมูลใน checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
						
						$bday1 = CheckBdate($birthday);// วันเกิด
						$bday2 = CheckBdate($begindate);// วันเริ่มปฏิบัติราชการ
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ต้องไม่มีข้อมูล ซ้ำ
						$a++;
						
							$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc' $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;
							mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>".__LINE__);
														
							insert_log_import($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
							#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
						}
							
					}// end if($xreturn == 0){ // กรณีไม่มีข้อมูลใน checklist
					
		####################   		ตรวจสอบข้อมูล
					
					if($status_data == "0"){ // การ update สถานะข้อมูล
						$v++;
						$arrupdate[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid).$txtchange_id;
						
					$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool  $conupdate_id $conupdate_data  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					//echo "sql :: ".$sqlupdata."<br><br>";
					$result_update = mysql_db_query($dbname_temp,$sqlupdata) or die(mysql_error()."$sqlupdata<br>".__LINE__);
					#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
					
					if(!$result_update){
						$sqlupdata1 = "REPLACE INTO tbl_checklist_kp7  SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc',idcard='$idcard',profile_id='$profile_id',siteid='$xsiteid'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool $conupdate_data  ";	
						//echo $sqlupdata1."<br><br>";
						mysql_db_query($dbname_temp,$sqlupdata1) or die(mysql_error()."$sqlupdata1<br>".__LINE__);
						#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
						
						$arrup_replace[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
				
					}//end 	if(!result_update){
					//echo "xxx";die;
			
					insert_log_import($xsiteid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ จากไฟล์ excel","1","$staffid","","","",$profile_id);
					insert_log_checklist_last($xsiteid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ  จากไฟล์ excel","1","$staffid","","","",$profile_id);

												
					
						###########   
						if($new_idcard != ""){ // กรณีเปลี่ยนเลขบัตร
							$new_idcard = strlen(intval($new_idcard));
							if($new_idcard == "13"){
								if(Check_IDCard($new_idcard)){ 
								$fullname = "$prname_th$name_th  $surname_th";
									$sql_insert = "REPLACE INTO  temp_change_idcard SET old_idcard='$idcard', new_idcard='".$new_idcard."', siteid='$xsiteid',fullname='$fullname',status_process='0',profile_id='$profile_id',updatetime=NOW(),staffid_change='".$staffid."' ,flag_sendmail='0'";
									mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
								}//end if(Check_IDCard($idcard)){ 	
							}//end if($new_idcard == "13"){
						}//end if($new_idcard != ""){ // กรณีเปลี่ยนเลขบัตร
						## end update ข้อมูล
					}else if($status_data == "1"){ //  เพิ่มข้อมูลใหม่ใน checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
							
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // หารหัสโรงเรียน	
						}// end if($schoolid == ""){
						
						$bday1 = CheckBdate($birthday);// วันเกิด
						$bday2 = CheckBdate($begindate);// วันเริ่มปฏิบัติราชการ
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ต้องไม่มีข้อมูล ซ้ำ
						$a++;
						
						$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc' $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;
							$result_add = mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
							
							if(!$result_add){
								$sql_add = "REPLACE INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;	
								mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
								
								$arradd_replace[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							}
							
								
							insert_log_import($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
							#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
						}else{
								
								$sql_rep = "SELECT *  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid <> '$xsiteid'";
								$result_rep = mysql_db_query($dbname_temp,$sql_rep);
								$rsp3 = mysql_fetch_assoc($result_rep);
								if($rsp3[idcard] == ""){ // กรณี upload ไปซ้ำแต่ในไฟล์ excel ได้ทำการ mark สถานะว่าเป็นการเพิ่มข้อมูลให้ไป update แทน
									$v++;
									$arrupdate[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
									
								$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool $conupdate_data WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					mysql_db_query($dbname_temp,$sqlupdata) or die(mysql_error()."$sqlupdata<br>LINE__".__LINE__);
						
					#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
					insert_log_import($xsiteid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ จากไฟล์ excel","1","$staffid","","","",$profile_id);
					insert_log_checklist_last($xsiteid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ  จากไฟล์ excel","1","$staffid","","","",$profile_id);
					
								}else{ // ในการณี้เพิ่มไม่ได้ข้อมูล ซ้ำจริงๆ
									$k++;
								
								$sql_add = "REPLACE INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff  $conposition_now  $conschool" ;	
								
									mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
									#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
						
									$arrrep[] = "$rsp3[idcard]  $rsp3[prename_th]$rsp3[name_th]  $rsp3[surname_th]   :: ".show_school($rsp3[schoolid])." :: ".ShowAreaSortName($rsp3[siteid]);
								
							$sql_add = "INSERT INTO tbl_checklist_kp7_false SET profile_id='$profile_id', idcard='$idcard', siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$bday1',begindate='$bday2',schoolid='$schoolid',status_IDCARD_REP='REP_CHECKLISTSITE' ";
							mysql_db_query($dbname_temp,$sql_add);
								}
						}//end if($rss[num1] < 1){ 
							
							
					}else if($status_data == "2"){ //  การลบข้อมูลใน checklist
					$d++;
						$sql_sel4 = "SELECT * FROM  tbl_checklist_kp7 WHERE  idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
						$result_sel4 = mysql_db_query($dbname_temp,$sql_sel4);
						$rs4 = mysql_fetch_assoc($result_sel4);
						$arrdel[] = "$idcard $prename_th$name_th $surname_th";
					
							$sql_del  = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
							mysql_db_query($dbname_temp,$sql_del);
							
							insert_log_import($xsiteid,$idcard,"ลบข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"ลบข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
					}elseif($status_data == "3"){
					     $rr++;
						 $sql_count1 = "SELECT COUNT(idcard) as num1 FROM tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid' ";
						 $result_count1 = mysql_db_query($dbname_temp,$sql_count1) or die(mysql_error());
						 $rs_c1 = mysql_fetch_assoc($result_count1);
						 if($rs_c1[num1] > 0){
					     	$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='0',status_file='0',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
						 }else{
							 $sqlupdata = "INSERT INTO tbl_checklist_kp7 SET prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$bday1',begindate='$bday2', status_numfile='0',status_file='0',status_check_file='YES',type_doc='$type_doc',idcard='$idcard',profile_id='$profile_id', siteid='$xsiteid'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool  ";	 
						}
					     mysql_db_query($dbname_temp,$sqlupdata)or die(mysql_error()."$sqlupdata<br>LINE__".__LINE__);
						 #GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
						 $arr_not_re[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
						 
						 
					}else{
						$jj++;
						$arrnon[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
						
						$xreturn = ReDataFromChecklist($idcard,$xsiteid,$profile_id);
					if($xreturn == 0){ // กรณีไม่มีข้อมูลใน checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // หารหัสโรงเรียน
						}
						
						$bday1 = CheckBdate($birthday);// วันเกิด
						$bday2 = CheckBdate($begindate);// วันเริ่มปฏิบัติราชการ
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ต้องไม่มีข้อมูล ซ้ำ
						$a++;
						
						$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff" ;
							mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
							#GetNewCutPic($idcard,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
							
						
							insert_log_import($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"เพิ่มข้อมูลบุคลากรจากฟอร์ม excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
						}
							
					}// end if($xreturn == 0){ // กรณีไม่มีข้อมูลใน checklist
					}//end if($status_data == "0"){
			$conupdate_id = "";		
			$txtchange_id = "";
			$conupdate_data = "";
			
		}//end 	for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
		##### ทำการตัดยอดข้อมูล ใน checklist ที่ไม่มีใน excel 
			//CutOffChecklistKp7($xsiteid,$profile_id);		
		#######  ลบข้อมูลใน temp
			//CleanTemp($xsiteid,$profile_id);
				chkUpdateNewCut_ALL($xsiteid);
			
			LogImpExpExcel($xsiteid,$profile_id,"นำเข้าข้อมูล excel เพื่อปรับปรุงข้อมูลในการตรวจสอบเอกสารต้นฉบับ",$a,$v,$d);
/*		echo "<center><h3>";
		echo " ปรับปรุงสถานะเอกสาร ก.พ. 7 ในระบบทั้งหมด $v รายการ<br> เพิ่มข้อมูลในระบบตรวจสอบข้อมูลตั้งต้น  $a รายการ<br>  ลบข้อมูลบุคลากรออกจากระบบตรวจสอบข้อมูลตั้งต้น $d รายการ<br> ไม่สามารถเพิ่มได้เนื่องจากข้อมูลซ้ำในระบบ checklist  $k  รายการ" ;
		echo "<br>";
*/		echo "<a href=\"../../../report/report_keydata_main.php?xlv=1&profile_id=$profile_id\" target=\"_blank\">คลิ๊กเพื่อตรวจสอบหน้ารายงาน</a><br><br></h3></center>";
//echo "end";die;
$arrup = GetPrecessUpload($xsiteid,$profile_id,$_SESSION['session_staffid']);
if(count($arrup > 0)){	
	$xnumall = number_format($arrup['numall']); // จำนวนเอกสารทั้งหมด
	$xnumpic = number_format($arrup['pic']); // จำนวนรูปที่ up ได้ทั้งหมด
	$xnumpage = number_format($arrup['page']); // จำนวนหน้า
	$xnumupload = number_format($arrup['upload']);
	$xnumuploadall = number_format($arrup['uploadall']);
	$xnumuploaddiff = number_format($arrup['uploaddiff']);
	$xnum_pic_add = number_format($arrup['pic_add']);
	$xnum_page_add = number_format($arrup['page_add']);
	$xnum_norecive = number_format($arrup['norecive']);

		echo "<script>alert('ผลการ upload เอกสาร ก.พ. 7\\n จำนวนเอกสารทั้งหมด $xnumall คน \\n จำนวนเอกสารที่ดำเนินการแล้วทั้งหมด $xnumuploadall คน \\n จำนวนเอกสารค้างดำเนินการ $xnumuploaddiff  คน \\nจำนวนที่ดำเนินการได้ $xnumupload คน  \\n จำนวนการ upload รูปภาพ $xnumpic  รูปภาพ \\n จำนวนแผ่นเอกสารที่ดำเนินการได้  $xnumpage แผ่น\\n จำนวนรูปที่ถ่ายเพิ่ม $xnum_pic_add รูป \\n จำนวนแผ่นที่ถ่ายเพิ่ม  $xnum_page_add  แผ่น \\n จำนวนเอกสารค้างรับ  $xnum_norecive  ชุด  ');</script>";

}

}


      	$arr_update  = $arrupdate;
		$arr_add = $arradd;
		$arr_del = $arrdel;
		$arr_rep = $arrrep;
		



####  ตรวจสอบในกรณีมีการ uplolad ไฟล์ของคนเดิมซ้ำ
$arrrep = CheckUploadReplace($profile_id,$xsiteid);

if(count($arrrep) > 0){ // ในกรณีมีการ upload ข้อมูลซ้ำกัน
echo "<a href='processxls_conf.php?profile_id=$profile_id&xsiteid=$xsiteid' target=\"_blank\">มีข้อมูลซ้ำกรุณาคลิ๊กเพื่อยื่นยันข้อมูล</a>&nbsp;<img src='../../../images_sys/new11.gif' width='26' height='7' border='0'><br>";
}// end if(count($arrrep) > 0){





?>
</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <?
    	if(count($arrchid) > 0){
	?>
         <tr>
           <td colspan="2" bgcolor="#CCCCCC"><strong>สถานะข้อมูลที่ทำการลงลิสรายการไม่ถูกต้อง</strong></td>
         </tr>
         <tr>
           <td colspan="2" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
             <tr>
               <td width="5%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
               <td width="63%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนามสกุล</strong></td>
               <td width="32%" align="center" bgcolor="#A5B2CE"><strong>หมวดปัญหา</strong></td>
             </tr>
             <?
			 $arr_type = GetTypeError();
			 $sql = "SELECT * FROM tbl_checklist_imp_excel_error WHERE siteid='$xsiteid' AND profile_id='$profile_id' ORDER BY name_th ASC";
			 $result = mysql_db_query($dbname_temp,$sql);
			 $n=0;
			 while($rs = mysql_fetch_assoc($result)){
             	if ($n++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 ?>
             <tr bgcolor="<?=$bg?>">
               <td align="center"><?=$n?></td>
               <td align="left"><? echo "$rs[idcard] $rs[prename_th]$rs[name_th] $rs[surname_th] $rs[position_now]";?></td>
               <td align="left"><?=$arr_type[type_error]?></td>
             </tr>
             <?
			 }//end while($rs = mysql_fetch_assoc($result)){
			 ?>
           </table></td>
         </tr>
         <tr>
        <td colspan="2" bgcolor="#CCCCCC"><strong>สถานะการเปลี่ยนเลขบัตรไม่ถูกต้อง</strong></td>
      </tr>
      <?
      				$iii=0;
			foreach($arrchid as $key_id => $val_id){
				 	if ($iii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

	  ?>
      <tr  bgcolor="<?=$bg?>">
        <td bgcolor="#CCCCCC"><?=$iii?></td>
        <td bgcolor="#CCCCCC"><?=$val_id?></td>
      </tr>
      
      <?
			}//end foreach($arrchid as $key_id => $val_id){
	}// end 	if(count($arrchid) > 0){
	  ?>
      <tr>
        <td colspan="2" bgcolor="#CCCCCC">ปรับปรุงสถานะเอกสาร ก.พ. 7 ในระบบทั้งหมด 
          <? if($v > 0){ echo "$v";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arr_update) > 0){
			$ii=0;
		 foreach($arr_update as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">เพิ่มข้อมูลในระบบตรวจสอบข้อมูลตั้งต้น 
          <? if($a > 0){ echo "$a";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arr_add) > 0){
			$ii=0;
		 foreach($arr_add as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">ลบข้อมูลบุคลากรออกจากระบบตรวจสอบข้อมูลตั้งต้น
          <? if($d > 0){ echo "$d";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arr_del) > 0){
			$ii=0;
		 foreach($arr_del as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">ไม่สามารถเพิ่มได้เนื่องจากข้อมูลซ้ำในระบบ checklist
          <? if($k > 0){ echo "$k";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arr_rep) > 0){
			$ii=0;
		 foreach($arr_rep as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                      <tr>
        <td colspan="2" bgcolor="#CCCCCC"> ไม่ได้กำหนดสถานะการปรับปรุงข้อมูล
          <? if($k > 0){ echo "$jj";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arrnon) > 0){
			$ii=0;
		 foreach($arrnon as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
		
		
		
		<tr>
        <td colspan="2" bgcolor="#CCCCCC"> เอกสารค้างรับ
          <? if($rr > 0){ echo "$rr";}else{ echo "0";}  echo " รายการ";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>รายการ</strong></td>
        </tr>
        <?
		if(count($arr_not_re) > 0){
			$ii=0;
		 foreach($arr_not_re as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arr_not_re) > 0)
		?>
		
		

    </table></td>
  </tr>
</table>
<p>&nbsp; </p>
