<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");


### ทดสอบ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ทดสอบ

	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//require_once("../../common/preloading.php");
	//echo "saddd";die;
		#$dbsite = "cmss_".$xsiteid;
		#AlterField($dbsite,"general_pic","img_owner");// ตรวจสอบเพื่อที่จะทำการปรับโครงสร้างตาราง general_pic
		$dateposition_now = SwDateT($dateposition_now);
		$dateposition_now = "2553-10-01";
		
/*		$arrsitecon = GetSiteContinute();// รหัสเขตต่อเนื่อง
		$last_id = InsertLogImpChecklistToCmss($xsiteid,$_SESSION['session_staffid']); // log การนำเข้าข้อมูลล่าสุด
		
	## บันทึกข้อมูลรายการข้อมูลที่จะนำเข้าระบบ
	$sql_status_field = "REPLACE INTO tbl_status_field_import(secid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_import_data)VALUES('$xsiteid','$Fprename_th','$Fname_th','$Fsurname_th','$Fbirthday','$Fbegindate','$Fposition_now','$Fschoolid','$status_data')";
mysql_db_query($dbname_temp,$sql_status_field) or die(mysql_error()."".__LINE__);
	## end บันทึกข้อมูลรายการข้อมูลที่จะนำเข้าระบบ
	
	$sqlm = "SELECT
t2.idcard,
t2.profile_id,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,
t2.sex
FROM
tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join view_checklist_lastprofile as t3 ON t2.profile_id = t3.last_profile AND t2.siteid = t3.siteid
left join edubkk_master.view_general as t5 on t2.idcard = t5.CZ_ID
where t2.status_numfile='1' and t2.status_file='1' and t2.status_check_file='YES' and t2.status_id_false='0' and status_retire='0'
and(
FLOOR((TIMESTAMPDIFF(MONTH,t2.birthday,'2554-10-01')/12)) > '15' and 
FLOOR((TIMESTAMPDIFF(MONTH,t2.begindate,'2553-09-30')/12)) >= '0'
and t2.position_now <> '' and t2.position_now IS NOT NULL
and t2.schoolid <> '' and t2.schoolid <> '0' and t2.schoolid IS NOT NULL
)
and t1.siteid NOT IN('1801','2101','3301','3302','3303','3304','3404','3405','3801','4001','4005','4101','4102','4403','4802','5001','5002','5003','5004','5005','5006','5101','5102','5201','5202','5301','5501','5601','5701','5704','6002','6102','6301','6302','6402','6502','6601','6701','6702','7101','7102','7103','7203','7301','7302','7702','8401','8602')
and t5.CZ_ID IS NULL
and length(t2.idcard)='13'

UNION

SELECT
t2.idcard,
t2.profile_id,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,
t2.sex
FROM
tbl_checklist_kp7 AS t2
Inner Join view_checklist_lastprofile as t3 ON t2.profile_id = t3.last_profile AND t2.siteid = t3.siteid
left join edubkk_master.view_general as t5 on t2.idcard = t5.CZ_ID
where t2.status_numfile='1' and t2.status_file='1' and t2.status_check_file='YES' and t2.status_id_false='0' 
and(
FLOOR((TIMESTAMPDIFF(MONTH,t2.birthday,'2554-10-01')/12)) > '15' and 
FLOOR((TIMESTAMPDIFF(MONTH,t2.begindate,'2553-09-30')/12)) >= '0'
and t2.position_now <> '' and t2.position_now IS NOT NULL
and t2.schoolid <> '' and t2.schoolid <> '0' and t2.schoolid IS NOT NULL
)
and t2.siteid LIKE '99%'
and t5.CZ_ID IS NULL
and length(t2.idcard)='13'";
	$resultm = mysql_db_query($dbname_temp,$sqlm);
	$numm = mysql_num_rows($resultm);
	
	
	if($numm > 0){ // นำเข้าเฉพาะเลขบัตรที่เลือกรายบุคลที่จะทำการคีย์ข้อมูล
		while($rsm = mysql_fetch_assoc($resultm)){
			$valid = $rsm[idcard];
			$profile_id = $rsm[profile_id];
			$xsiteid = $rsm[siteid];
			$dbsite = "cmss_".$xsiteid;
		$sql_upstatus = "DELETE FROM   tbl_check_data  WHERE idcard='$valid' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_upstatus);
	
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND idcard='$valid' AND profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			## เริ่มกระบวนการนำข้อมูลเข้าสู่ระบบ cmss
				$schoolname = show_school($rs[schoolid]);
					if($rs[page_num] != $rs[page_upload] and $rs[page_upload] > 0){
							$status_file_scan = "0";
					}else{
							$status_file_scan = "1";	
					}

				if(CheckDataOldYear($rs[idcard]) > 0 or CheckMonitorKey($rs[idcard]) > 0){
						$status_data_old = 1; // อยู่ในเขตเก่า
				}else{
						$status_data_old = 0; // ไม่ได้อยู่ในเขตเก่า
				}//end if(CheckDataOldYear($rs[idcard]) > 0){
			####  ตรวจสอบเลขบัตรประชาชน
			if(!Check_IDCard($rs[idcard])){
					$idcard_structure = 0; // เลขบัตรไม่ถูกต้องตามกรมการปกครอง
			}else{
					$idcard_structure = 1;	 //  เลขบัตรถูกต้องตามกรมการปกครอง
			}//end 	if(!Check_IDCard($rs[idcard])){
				
						#####  ตรวจสอบข้อมูลซ็ำในระบบ cmss ก่อน
			$arrid = CheckReplaceCmss($rs[idcard],$rs[siteid]);
			if($arrid[0] == "1"){ // กรณีข้อมูลที่นำเข้าซ้ำกับข้อมูลในระบบ cmss ที่ไม่ใช่ข้อมูลของเขตเดิม
				$status_id_replace = 1;
				$siteid_replace = $arrid[1];
				$sql_update_tblkp7 = "UPDATE tbl_checklist_kp7 SET status_id_replace='$status_id_replace',siteid_replace='$siteid_replace' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
				mysql_db_query($dbname_temp,$sql_update_tblkp7);
			}else{
				$status_id_replace = $rs[status_id_replace];
				$siteid_replace = $rs[siteid_replace];
			}//end if($arrid[0] == "1"){ // กรณีข้อมูลที่นำเข้าซ้ำกับข้อมูลในระบบ cmss ที่ไม่ใช่ข้อมูลของเขตเดิม
	
				//echo $status_id_replace ." :: ".$siteid_replace."<br>";
				
				
						###  log การนำเข้าข้อมูล #####
				if(array_key_exists("$siteid_replace",$arrsitecon)){
				   	$status_replace_sitecon = "1";
				}else{
					$status_replace_sitecon = "0";	
				}// end if(array_key_exists("$siteid_replace",$arrsitecon)){

		
		 		InsertLogImpDetail($last_id,$rs[idcard],$rs[siteid],$profile_id,$rs[prename_th],$rs[name_th],$rs[surname_th],$rs[schoolid],$rs[position_now],$siteid_replace,$status_replace_sitecon);

				

			if($rs[status_id_replace] == "1"){ // กรณีที่ข้อมูลในะระบบ checklist ไปซ้ำกับเขตอื่นในฐาน cmss
				## ตรวจสอบว่าเป็นข้อมูลเก่าจากโครงการปีที่แล้ว
					if(CheckDataTable($rs[idcard],$profile_id) > 0){ // กรณีมีใน tbl_check_data อยู่แล้ว
					$sql_insert = "UPDATE tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='REPLACE_ID',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id' WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
					}else{
					$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='REPLACE_ID',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id'";
					}// if(CheckDataTable($rs[idcard]) > 0){
					mysql_db_query($dbname_temp,$sql_insert);
			
			}else{// กรณีข้อมูลไม่ซ้ำกับเขตอื่น
				if(CheckDataTable($rs[idcard],$profile_id) > 0){ // กรณีมีใน tbl_check_data อยู่แล้ว
				$sql_insert = "UPDATE tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',  begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace',status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id'  WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
				}else{
				$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id' ";
				}//end 	if(CheckDataTable($rs[idcard]) > 0){ 
				//echo "sql :: ".$sql_insert."<br>";
				mysql_db_query($dbname_temp,$sql_insert);
			}//if($rs[status_id_replace] == "1"){
			##  end เริ่มกระบวนการนำข้อมูลเข้าสู่ระบบ cmss
		}//end while($rs = mysql_fetch_assoc($result)){	
		
		//echo $sql_insert;die;
	}//end 	foreach($arr_id as $keyid => $valid){
}else{
		echo "<script>alert('ไม่พบข้อมูลที่ท่านเลือก');location.href='import2cmss_per_person.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1&lv=$lv&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;	
}//end if(count($arr_id) > 0){ // นำเข้าเฉพาะเลขบัตรที่เลือกรายบุคลที่จะทำการคีย์ข้อมูล*/
	
		//echo "สิ้นสุดการนำข้อมูลเข้า";die;
### ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss#########################################################
//echo "กำลังปรับปรุงโปรแกรม";die;
#$conidcard = "and idcard='4359900002229'";
$arrField = FieldProtectionImport(); // ฟิลด์ที่ใช้ในการตรวจสอบข้อมูลก่อนนำเข้าระบบ cmss


$sql = " SELECT
t1.idcard,
t1.profile_id,
t1.secid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.sex,
t1.birthday,
t1.begindate,
t1.schoolid,
t1.position_now,
t1.dateposition_now,
t1.schoolname,
t1.status_compare,
t1.old_idcard,
t1.status_idcard,
t1.timeupdate,
t1.status_file_scan,
t1.status_id_replace,
t1.siteid_replace,
t1.status_data_old,
t1.status_tranfer_filekp7,
t1.status_tranfer_data,
t1.status_restoredata,
t1.idcard_structure,
t2.status_replace_sitecon
FROM
tbl_check_data AS t1
Inner Join log_import_cmss_detail AS t2 ON t1.idcard = t2.idcard AND t1.secid = t2.siteid AND t1.profile_id = t2.profile_id
WHERE
t1.status_tranfer_data =  '0' AND
t1.idcard_structure =  '1' AND
t1.schoolid IS NOT NULL  AND
t1.schoolid <>  '0' AND
 t2.status_replace_sitecon='0' AND t2.import_id='3661'
  GROUP BY idcard";
#echo "$sql <br>";die();

$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
while($rs = mysql_fetch_assoc($result)){
$dbsite = "cmss_".$rs[secid];

#$check_retire = CheckRetire($rs[idcard]);	 // ตรวจสอบการเกษียณอายุราชการไปแล้ว

if($check_retire > 0){ // แสดงว่ามีการเกษียณอายุราชการไปแล้วห้ามนำเข้า

		$sql_upch = "UPDATE tbl_check_data SET status_tranfer_data='2' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' AND secid='$rs[secid]'";
		mysql_db_query($dbname_temp,$sql_upch);
		SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"2");// เก็บ log การนำเข้าข้อมูล
		
}else{
	
	
	
		## ตรวจสอบ ฟิลด์ที่จะนำเข้าข้อมูล
		## คำนำหน้าชื่อ
		//echo "<pre>";
		//print_r($rs);die;
		###  ตรวจสอบ field ที่มีการป้องกันข้อมูล
	if(count($arrField) > 0){
		foreach($arrField as $key => $val){
			//echo " $key :: ".$rs[$key]."<br>";
			if($key == "birthday" or $key == "begindate"){
				if($rs[$key] == "0000-00-00" or $rs[$key] == "" or strlen($rs[$key]) != 10){
					$arrfalse[$val] = $key;
				}//end 	if($rs[$key] == "0000-00-00" or $rs[$key] == ""){
			}else if($key == "schoolid"){
					if(show_school($rs[$key]) == ""){
						$arrfalse[$val] = $key;	
					}
			}else if($key == "sex"){
				if($rs[$key] == "" or $rs[$key] == "0"){
					$arrfalse[$val] = $key;	
				}
			}else{
				if($rs[$key] == ""){
					$arrfalse[$val] = $key;	 //  
				}// end if($rs[$key] == ""){
			}
		}//end foreach($arrField as $key => $val){
	}//end 	if(count($arrField) > 0){
	$check_field = count($arrfalse);
	####  กรณีไม่พบค่าว่างใน field ที่บังคับ
	
			
/*	echo "
	จำนวน => $check_field<br>
	<pre>";
	print_r($arrfalse);die();
*/	
	if($check_field > 0){ # กรณีข้อมูลที่จะนำเข้ามีใน field บังคับเป็นค่าว่าง
			SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"0");// เก็บ log การนำเข้าข้อมูล
			CleanImportError($rs[idcard],$rs[secid],$rs[profile_id]);// ล้างข้อมูล error ก่อนทำการบันทึก
		### เก็บรายการที่ error
		foreach($arrfalse as $k => $v){
			SaveImpotError($rs[idcard],$rs[secid],$rs[profile_id],$k);
		}// end foreach($check_field as $k => $v){
			
	}else{ // กรณีผ่านเงือนไขฟิลด์บังคับ
		
		## ตรวจสอบ ฟิลด์ที่จะนำเข้าข้อมูล
		## คำนำหน้าชื่อ
		if($rs[sex] != ""){
			$update_sex = ", sex='".$arr_sex[$rs[sex]]."'";
			$update_gender_id = ", gender_id='$rs[sex]'";
				$arrp1 = GetPrenameId($rs[prename_th]);
				$update_prename = ", prename_th='$rs[prename_th]' ";
				$update_prename_id = ", prename_id='$arrp1[PN_CODE]' ";
		}else{
			if(CheckField($rs[secid],"prename_th") > 0){
				$arrp1 = GetPrenameId($rs[prename_th]);
				$update_prename = ", prename_th='$rs[prename_th]' ";
				$update_prename_id = ", prename_id='$arrp1[PN_CODE]' ";
				$update_sex = ", sex='$arrp1[sex]'";
				$update_gender_id = ", gender_id='$arrp1[gender]'";
			}else{
				$update_prename = "";
				$update_prename_id = "";
				$update_sex = "";
				$update_gender_id = "";	
			}
			
		}//end // end if(CheckField($rs[secid],"prename_th") > 0){
		## ชือ
		if(CheckField($rs[secid],"name_th") > 0){
			$update_name = ", name_th='$rs[name_th]'";	
		}else{
			$update_name = "";
		}//end if(CheckField($rs[secid],"name_th") > 0){
		## นามสกุล
		if(CheckField($rs[secid],"surname_th") > 0){
			$update_surname = ", surname_th='$rs[surname_th]'";
		}else{
			$update_surname = "";	
		}//end if(CheckField($rs[secid],"surname_th") > 0){
		###  วันเดือนปีเกิด
		if(CheckField($rs[secid],"birthday") > 0){
			$update_birthday = ", birthday='$rs[birthday]'";
		}else{
			$update_birthday = "";
		}
		## วันเริ่มปฏิบัตราชการ
		if(CheckField($rs[secid],"begindate") > 0){
			$update_begindate = ", begindate='$rs[begindate]'";
		}else{
			$update_begindate = "";
		}//end if(CheckField($rs[secid],"begindate") > 0){
		## ตำแหน่งปัจจุบัน 
		if(CheckField($rs[secid],"position_now") > 0){
			$arrp2 = GetPositionId($rs[position_now]);
			$update_position = ", position_now='$rs[position_now]'";
			$update_pid = ", pid='$arrp2[pid]'";
			$update_positiongroup = ", positiongroup='$arrp2[Gpid]'";
		}else{
			$update_position = "";
			$update_pid = "";
			$update_positiongroup = "";
		}
		## หน่วยงาน
		if(CheckField($rs[secid],"schoolid") > 0){
			$update_schoolid = ", schoolid='$rs[schoolid]'";
		}else{
			$update_schoolid = "";
		}

		$result_tranfer = "";
		## end ตรวจสอบ ฟิลด์การนำเข้า 
		
		#echo "สถานะข้อมูลซ้ำ => $rs[status_id_replace]";die;
#############################  กรณีนำเข้าได้ปกติ ##################################
		if($rs[status_id_replace] == "0"){ // คือข้อมูลปกติสามารถนำเข้าไปได้เลย
					
					SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"1");// เก็บ log การนำเข้าข้อมูล
					$numdatacmss = CountSalaryInsite($rs[secid],$rs[idcard]); // นับจำนวนข้อมูลเงินเดือนในเขตที่นำเข้า
					$numcmss0000 = CheckNumCmssCenter($rs[idcard],"0000"); //นับจำนวนข้อมูลในฐานกลาง
					
				
					
					
					if($numcmss0000 > 0 and $numdatacmss < 1 ){
						$site_source1= "0000";
						$site_dest1 = $rs[secid];
							$result_tranfer = transfer_data($rs[idcard],$site_source1,$site_dest1,"0000",$rs[schoolid],"11","Tranfer From 0000 To Cmss");// ย้ายข้อมูลจาก cmss 0000
							
							$sql_update_tranfer = "UPDATE tbl_check_data SET status_restoredata='1' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
							mysql_db_query($dbname_temp,$sql_update_tranfer);
					}//end if($numcmss0000 > 0 and $numdatacmss < 1 ){


			#echo "$result_tranfer :: debug => ".CheckDataInDb($rs[secid],$rs[idcard]);die();
		
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0 ){ // กรณีมีอยู่แล้ว update และเป็นการย้ายมาจากเขตอื่น
				
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
					//echo "update";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',position='',blood='',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss) or die(mysql_error()."$sql_imp2cmss<br>LINE__".__LINE__);
					//echo "insert";
				}
			#echo "<br>dbsite = ".$dbsite."sql = ".$sql_imp2cmss."<br>";die();
			
				### ทำการเพิ่มชื่อในประวัติการเปลี่ยนชื่อ
				AddHistoryNameCmss($rs[secid],$rs[idcard],$rs[prename_th],$rs[name_th],$rs[surname_th]); 
			###  ทำการคัดลอกไฟล์รูปสู่ฐานข้อมูล cmss
			 ImportPicToCmss($rs[secid],$rs[idcard]); // ทำการคัดลอกไฟล์สู่ฐานข้อมูล  cmss
			## end ทำการคัดลอกรูปสู่ฐานข้อมูล cmss
			## ทำการคัดลอกไฟล์ kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // กรณีมีไฟล์เท่านั้น
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
				//echo $sql_update_tranfer."<br>";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end  //if($result_imp2cmss){


#############################  กรณีไปซ้ำกับเขตอื่น ##################################		
		}else{ // กรณีข้อมูลไปซ้ำกับเขตอื่น
		
			$dbsource = "cmss_".$rs[siteid_replace]; // ฐานข้อมูลเขตต้นทาง
			$dbdest = "cmss_".$rs[secid];
			$result_tranfer = "";

				if($rs[status_data_old] == "1"){ // กรณีเป็นข้อมูลเก่าจากปีที่แล้ว
						#### เข้ากระบวนการย้ายข้อมูล
							
							// ข้อมูลในเขตต้นทางที่เป็นของเขตเก่าไม่มีในเขตอาจเป็นเพาะถูกตัดเข้าไปอยู่ใน temp_general ใน master ต้องดึงกลับมาก่อนทำการย้าย
							
							
/*							if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							$xdb_site = "cmss_".$rs[siteid_replace];
							$sql_update1 = "REPLACE INTO general SET id='$rs[idcard]',idcard='$rs[idcard]', siteid='$rs[secid]',position='',blood='',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";
							mysql_db_query($dbsite,$sql_update1);
								
								
							}//end if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
*/							
							//echo $dbsource."::".$dbdest."  $rs[siteid_replace] :: $rs[idcard] ";die;
							###  เนื่องจากแก้ปัญหาการทำงานของ crontrab และ triggers ที่ล่าช้า
							####  ทำการลบข้อมูลในตาราง view_general ใน site และใน master
							$sql_delv = "DELETE FROM view_general WHERE CZ_ID='$rs[idcard]'";
							mysql_db_query($dbsource,$sql_delv);
							$sql_delvm = "DELETE FROM view_general WHERE CZ_ID='$rs[idcard]' AND siteid='$rs[siteid_replace]'";
							mysql_db_query($dbnamemaster,$sql_delvm);
							####  end ทำการลบข้อมูลในตาราง view_general ใน site และใน master
							$sitesource = $rs[siteid_replace];
							$sitedest = $rs[secid];
							if($sitesource != $sitedest){
								$result_tranfer = transfer_data($rs[idcard],$sitesource,$sitedest,"0000",$rs[schoolid],"11","tranfer_checkdata");
							}
							
						#### end เข้ากระบวนการย้ายข้อมูล
					###  update ข้อมูล ใน general 
					if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1 ){  // update ในกรณีเป็นข้อมูลใหม่
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',position='',blood='',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
					}//end 
			### ทำการเพิ่มชื่อในประวัติการเปลี่ยนชื่อ
				AddHistoryNameCmss($rs[secid],$rs[idcard],$rs[prename_th],$rs[name_th],$rs[surname_th]); 
			## ทำการคัดลอกไฟล์ kp7

			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' and profile_id='$profile_id'";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
				}//end  if($result_imp2cmss){
					
				}else{ ###  กรณีไม่ได้อยู่ในเขตเก่าตามสัญญาปีที่แล้ว

				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // กรณีมีอยู่แล้ว update
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',position='',blood='',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
				}
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
			## ทำการคัดลอกไฟล์ kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // กรณีมีไฟล์เท่านั้น
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
			$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' AND profile_id='$profile_id' ";
			mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end if($result_imp2cmss){
					
#####################################################################################################					
				}// end if($rs[status_data_old] == "1"){ 
		}//end if($rs[status_id_replace] == "0"){
	}//end if($check_field > 0){ # กรณีข้อมูลที่จะนำเข้ามีใน field บังคับเป็นค่าว่าง
		unset($arrfalse); // ล้างค่า array ตรวจสอบ
		
		
		$sql_upd = "UPDATE tbl_checklist_kp7_all_checklist_notin_cmss_checkimp SET flag_import='1' WHERE idcard='$rs[idcard]' AND siteid='$rs[secid]'";
		mysql_db_query($dbname_temp,$sql_upd) or die(mysql_error()."".__LINE__);
		
	}//end if($check_retire > 0){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss

		###  ทำการ update ข้อมูลเพื่อในข้อมูลใน general , view_general กับ view_general ใน master ตรงกัน
		$sql_update_general = "UPDATE general SET  id=idcard,siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
			### update สถานะเขตที่มีการนำเข้าข้อมูลแล้ว
			UpdateKeydataActive($xsiteid,$profile_id);
		
		
//?action=&xsiteid=6502&secname=สำนักงานเขตพื้นที่การศึกษาพิษณุโลก เขต 2
	}// end if($Aaction == "process"){

###  end ประมวลผลรายการ
echo "Done...";
?>

