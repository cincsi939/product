<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");


if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}



####  ประมวลผลรายการ
### ทดสอบ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ทดสอบ
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//require_once("../../common/preloading.php");
		$dbsite = "cmss_".$xsiteid;
		AlterField($dbsite,"general_pic","img_owner");// ตรวจสอบเพื่อที่จะทำการปรับโครงสร้างตาราง general_pic
		$dateposition_now = SwDateT($dateposition_now);
		
		$arrsitecon = GetSiteContinute();// รหัสเขตต่อเนื่อง
		$last_id = InsertLogImpChecklistToCmss($xsiteid,$_SESSION['session_staffid']); // log การนำเข้าข้อมูลล่าสุด
		

	## บันทึกข้อมูลรายการข้อมูลที่จะนำเข้าระบบ
	$sql_status_field = "REPLACE INTO tbl_status_field_import(secid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_import_data)VALUES('$xsiteid','$Fprename_th','$Fname_th','$Fsurname_th','$Fbirthday','$Fbegindate','$Fposition_now','$Fschoolid','1')";
@mysql_db_query($dbname_temp,$sql_status_field);
	## end บันทึกข้อมูลรายการข้อมูลที่จะนำเข้าระบบ
	
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND profile_id='$profile_id' $con_doccomplate ";
		//echo $sql;die;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			
			$sql_upstatus = "DELETE FROM   tbl_check_data  WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
			mysql_db_query($dbname_temp,$sql_upstatus);
			## เริ่มกระบวนการนำข้อมูลเข้าสู่ระบบ cmss
				$schoolname = show_school($rs[schoolid]);
					if($rs[page_num] != $rs[page_upload] and $rs[page_upload] > 0){
							$status_file_scan = "0";
					}else{
							$status_file_scan = "1";	
					}

				if(CheckDataOldYear($rs[idcard],$profile_id) > 0 or CheckMonitorKey($rs[idcard]) > 0){
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
					$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='REPLACE_ID',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id' ";
					}// if(CheckDataTable($rs[idcard]) > 0){
					mysql_db_query($dbname_temp,$sql_insert);
			
			}else{// กรณีข้อมูลไม่ซ้ำกับเขตอื่น
				if(CheckDataTable($rs[idcard],$profile_id) > 0){ // กรณีมีใน tbl_check_data อยู่แล้ว
				$sql_insert = "UPDATE tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',  begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace',status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id'  WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
				}else{
				$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure' ,profile_id='$profile_id'";
				}//end 	if(CheckDataTable($rs[idcard]) > 0){ 
				//echo "sql :: ".$sql_insert."<br>";
				mysql_db_query($dbname_temp,$sql_insert);
			}//if($rs[status_id_replace] == "1"){
			##  end เริ่มกระบวนการนำข้อมูลเข้าสู่ระบบ cmss
}//end while($rs = mysql_fetch_assoc($result)){	
		//echo "สิ้นสุดการนำข้อมูลเข้า";die;
### ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss#########################################################
$arrField = FieldProtectionImport(); // ฟิลด์ที่ใช้ในการตรวจสอบข้อมูลก่อนนำเข้าระบบ cmss
CleanPositionChecklistNoMath($xsiteid,$profile_id);// ล้างข้อมูลตำแหน่งที่ไม่สัมพันธ์กับข้อมูลในระบบ
#$sql = "SELECT * FROM tbl_check_data WHERE secid='$xsiteid' AND status_tranfer_data='0' AND idcard_structure='1' AND schoolid IS NOT NULL AND schoolid <> '0'  AND profile_id='$profile_id'";
//echo $sql."<br>";die;
$sql = "SELECT
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
t1.secid =  '$xsiteid' AND
t1.status_tranfer_data =  '0' AND
t1.idcard_structure =  '1' AND
t1.schoolid IS NOT NULL  AND
t1.schoolid <>  '0' AND
t1.profile_id =  '$profile_id' AND t2.status_replace_sitecon='0' AND t2.import_id='$last_id' GROUP BY idcard ";

$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$pivate_key = gen_pivatekey();

	$check_retire = CheckRetire($rs[idcard]);	 // ตรวจสอบการเกษียณอายุราชการไปแล้ว
if($check_retire > 0){ // แสดงว่ามีการเกษียณอายุราชการไปแล้วห้ามนำเข้า
$sql_upch = "UPDATE tbl_check_data SET status_tranfer_data='2' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' AND secid='$rs[secid]'";
mysql_db_query($dbname_temp,$sql_upch);
SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"2");// เก็บ log การนำเข้าข้อมูล
}else{

	
	if(count($arrField) > 0){
		foreach($arrField as $key => $val){
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

	
	####  กรณีไม่พบค่าว่างใน field ที่บังคับ
	$check_field = count($arrfalse);
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

		## end ตรวจสอบ ฟิลด์การนำเข้า 
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

			
			
			
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // กรณีมีอยู่แล้ว update
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					//echo "update";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',position='',pivate_key='$pivate_key',blood='',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
					//echo "insert";
				}
			//echo "<br>sql = ".$sql_imp2cmss."<br>";
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
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
			### ล้างข้อมูลใหม่ก่อนคีย์
/*			if($rs[status_data_old] != "1"){ // ล้างข้อมูลกรณีไม่ใช่โครงการปีที่แล้ว
				DeleteDataNew($rs[secid],$rs[idcard]);
			}
*/
#############################  กรณีไปซ้ำกับเขตอื่น ##################################		
		}else{ // กรณีข้อมูลไปซ้ำกับเขตอื่น
		
			$dbsource = "cmss_".$rs[siteid_replace]; // ฐานข้อมูลเขตต้นทาง
			$dbdest = "cmss_".$rs[secid];
				if($rs[status_data_old] == "1"){ // กรณีเป็นข้อมูลเก่าจากปีที่แล้ว
						#### เข้ากระบวนการย้ายข้อมูล
							
/*							// ข้อมูลในเขตต้นทางที่เป็นของเขตเก่าไม่มีในเขตอาจเป็นเพาะถูกตัดเข้าไปอยู่ใน temp_general ใน master ต้องดึงกลับมาก่อนทำการย้าย
							if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
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
							}// end if($sitesource != $sitedest){
						#### end เข้ากระบวนการย้ายข้อมูล
					###  update ข้อมูล ใน general 
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',position='',blood='',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
	### ทำการเพิ่มชื่อในประวัติการเปลี่ยนชื่อ
				AddHistoryNameCmss($rs[secid],$rs[idcard],$rs[prename_th],$rs[name_th],$rs[surname_th]); 

			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' and profile_id='$profile_id'";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
				}//end  if($result_imp2cmss){
					
				}else{ ###  กรณีไม่ได้อยู่ในเขตเก่าตามสัญญาปีที่แล้ว

					###  
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // กรณีมีอยู่แล้ว update
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',position='',pivate_key='$pivate_key',blood='',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
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
	}//end if($check_retire > 0){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss
###  ทำการเทียบข้อมูลใน ตาราง checkl_data กับฐานข้อมูล cmss ถ้าข้อมูลส่วนเกินให้ย้ายและเก็บไปไว้ใน temp_general ก่อนเนื่องจากเป็นข้อมูลที่เคยคีย์อยู่แล้้ว




### end ทำการเทียบข้อมูลใน ตาราง checkl_data กับฐานข้อมูล cmss ถ้าข้อมูลส่วนเกินให้ย้ายและเก็บไปไว้ใน temp_general ก่อนเนื่องจากเป็นข้อมูลที่เคยคีย์อยู่แล้้ว
	//echo "AAAA";die;
		###  ทำการ update ข้อมูลเพื่อในข้อมูลใน general , view_general กับ view_general ใน master ตรงกัน
		$sql_update_general = "UPDATE general SET id=idcard,siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
			### update สถานะเขตที่มีการนำเข้าข้อมูลแล้ว
			UpdateKeydataActive($xsiteid,$profile_id);
		
		echo "<script>alert('นำเข้าข้อมูลเรียบร้อยแล้ว');location.href='import2cmss_doccomplate.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1&profile_id=$profile_id&import_id=$last_id';</script>";
		exit;

//?action=&xsiteid=6502&secname=สำนักงานเขตพื้นที่การศึกษาพิษณุโลก เขต 2
	}// end if($Aaction == "process"){
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
###  end ประมวลผลรายการ
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
//	function copyit(theField) {
//		var selectedText = document.selection;
//		if (selectedText.type == 'Text') {
//			var newRange = selectedText.createRange();
//			theField.focus();
//			theField.value = newRange.text;
//		} else {
//			alert('select a text in the page and then press this button');
//		}
//	}
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
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<?
	
if($action == ""){
	
	$arr1 = show_val_exsum("1",$xsiteid,$schoolid,$profile_id);
	//echo "<pre>";
	//print_r($arr1);
	//echo "db :: $dbname_temp";
/*	$sql_count_school = "SELECT COUNT(schoolid) as NUMSCHOOL,schoolid  FROM edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
WHERE edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' GROUP BY siteid";*/
	$sql_count_school = "SELECT COUNT(schoolid) as NUMSCHOOL,edubkk_checklist.tbl_checklist_kp7.siteid   FROM edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
WHERE edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' and edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' GROUP BY edubkk_checklist.tbl_checklist_kp7.siteid,schoolid";
	$result_count_school = @mysql_db_query($dbname_temp,$sql_count_school);
	while($rs_cs = @mysql_fetch_assoc($result_count_school)){
			$arrnum_school[$rs[siteid]] = $arrnum_school[$rs[siteid]]+1;
	}//end while($rs_cs = @mysql_fetch_assoc($result_count_school)){
	if($arrnum_school[$xsiteid] < 1){
			$sql_cs = "SELECT
count(edubkk_master.allschool.id) as nums
FROM
edubkk_master.allschool 
WHERE
edubkk_master.allschool.siteid =  '$xsiteid'";
		$result_cs = mysql_db_query(DB_MASTER,$sql_cs);
		$rscs1 = mysql_fetch_assoc($result_cs);
		$numschoolall = $rscs1['nums'];
		
	}else{
		$numschoolall = $arrnum_school[$xsiteid] ;	
	}
	
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><!--<a href="import2cmss.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">นำเข้าข้อมูทั้งเขต</a> ||--> <a href="import2cmss_per_person.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=0&profile_id=<?=$profile_id?>">นำเข้าข้อมูลรายบุคคล</a> <!--|| <a href="import2cmss_doccomplate.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">นำเข้าข้อมูลเฉพาะสถานะเอกสารสมบูรณ์เท่านั้น</a>--><!--|| <a href="import2cmss_uncomp.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">นำเข้าเอกสารไม่สมบูรณ์หรือที่ยังไม่มีใน cmss</a>--><br>
<br>


    </td>
 </tr>
 <tr>
   <td align="left"><form name="form1" method="post" action="?">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
               <tr>
                 <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>หมวดรายการนำข้อมูลสู่ระบบ cmss เฉพาะกลุ่มสถานะเอกสารสมบูรณ์จากทีม checklist เท่านั้น</strong></td>
                 </tr>
               <tr>
                 <td width="26%" align="right" bgcolor="#CAD5FF"><strong>ข้อมูล ณ.วันที่</strong></td>
                 <td width="74%" align="left" bgcolor="#CAD5FF">
                  <input type="hidden" name="dateposition_now" value="<?=$config_date?>"> ข้อมูลวันที่ถูกกำหนดเป็น <?=Show_dateThai($config_date)?> เพื่อให้กระบวนการบันทึกข้อมูลถูกต้อง
                 <!--<INPUT name="dateposition_now" onFocus="blur();" value="<?=$config_date?>" size="15" readOnly>
                   <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.dateposition_now, 'dd/mm/yyyy')"value="วันเดือนปี">--></td>
               </tr>
<!--               <tr>
                 <td align="right" bgcolor="#FFFFFF">สถานะความสมบูรณ์ข้อมูล</td>
                 <td align="left" bgcolor="#FFFFFF"><label>
                   <input type="radio" name="status_data" id="status_data1" value="1">
                 สมบูรณ์
                 	<input type="radio" name="status_data" id="status_data0" value="0">
                 ไม่สมบูรณ์</label></td>
               </tr>
-->               <tr>
                 <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>หมายเหตุ : </strong>กรณีทีม checklist ไม่สามารถยืนยันจำนวนบุคลากรในเขต</td>
                 </tr>
               <tr>
                 <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                 <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>เลือกข้อมูลที่จะนำเข้าระบบ</strong></td>
                   </tr>
                   <tr>
                     <td width="11%" align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fprename_th" value="1"  checked="checked">
                     </label></td>
                     <td width="89%" align="left" bgcolor="#FFFFFF">คำนำหน้าชื่อ</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fname_th" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">ชื่อ</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fsurname_th" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">นามสกุล</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fbirthday" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">วันเดือนปีเกิด</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fbegindate" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">วันเริ่มปฏิบัติราชการ</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fposition_now" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">ตำแหน่งปัจจุบัน</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fschoolid" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">หน่วยงานสังกัด</td>
                   </tr>
                 </table></td>
               </tr>
               <tr bgcolor="#FFFFFF">
                 <td align="right">&nbsp;</td>
                 <td align="left">
                	 <input type="submit" name="submit" value="ประมวลผลข้อมูล">
                 	<input type="button" name="btnClose" value="ยกเลิก" onClick="window.close()" style="cursor:hand">
                   <input type="hidden" name="Aaction" value="process">
                   <input type="hidden" name="secname" value="<?=$secname?>">
                   <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                   <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                   </td>
               </tr>
             </table></td>
           </tr>
         </table></td>
         <td width="50%" align="center" valign="bottom"><table width="90%" border="0" cellspacing="0" cellpadding="0">
         <? if($flag_crontab == "1"){
			 	$arr_result = CheckImportData($xsiteid,$profile_id);
			 ?>
           <tr>
             <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="3" align="center" bgcolor="#CAD5FF"><strong>สรุปการนำข้อมูลจาก checklist เข้าสู่ระบบ cmss<br>
                       (ระบบจะทำการนำ้เข้าข้อมูลบัญชี จ.18 ด้วยในกรณีที่เป็นเขตใหม่)
                     </strong></td>
                     </tr>
                  <? if(CheckNumJ18($xsiteid) > 0){ ?>
                   <tr>
                     <td colspan="3" align="center" bgcolor="#FFFFFF"><strong><a href="../j18/manager_group/reportj18/index_school.php?xsiteid=<?=$xsiteid?>" target="_blank">แสดงข้อมูลบัญชี จ.18</a></strong></td>
                     </tr>
                     <? } //end if(CheckNumJ18($xsiteid) > 0){?>
                   <tr>
                     <td width="63%" align="left" bgcolor="#FFFFFF"><strong>1. จำนวนทั้งหมดในเช็คลิส</strong></td>
                     <td width="23%" align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr1['numall']);?>
                     </strong></td>
                     <td width="14%" align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#009900"> <strong>&nbsp;1.1 จำนวนที่เอกสารสมบูรณ์</strong></td>
                     <td align="center" bgcolor="#009900"><?=number_format($arr1['numY1'])?></td>
                     <td align="center" bgcolor="#009900"><strong>คน</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>2. จำนวนที่นำเข้าระบบ cmss</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['NumAll'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.1 จำนวนบุคลากรที่อยู่ในเขตเดิม</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['InSite'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.2 จำนวนบุคลากรที่ย้ายเข้ามาใหม่</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['TranferIn'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.3 จำนวนบุคลากรที่ไม่สามารถนำเข้าได้<br>
เนื่องจากข้อมูลบางรายการเป็นค่าว่าง</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong><? if($arr_result['imp_err'] > 0){ echo "<a href='report_import_error.php?action=&xsiteid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($arr_result['imp_err'])."</a>";}else{ echo "0";}?></strong></td>
                     <td align="center" bgcolor="#FFFFFF">คน</td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>3. จำนวนบุคลากรที่ย้ายไปไว้ข้อมูลกลาง</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><? $numcenter = CountDataCenter($xsiteid) ; if($numcenter > 0){ echo "<a href='report_import2cmss_center.php?xsiteid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($numcenter)."</a>";}else{ echo "0";}?></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                                      <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>4. จำนวนคนที่ไม่สามารถนำเข้าได้<br>
                       เนื่องจากมีการจำหน่ายบุคลากรไปแล้ว</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><? if($arr_result['retire'] > 0){ echo "<a href='report_import_error.php?action=&xsiteid=$xsiteid&profile_id=$profile_id&mode=retire' target='_blank'>".number_format($arr_result['retire'])."</a>";}else{ echo "0";}?></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                 <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>5. ข้อมูลซ้ำกับ 48 เขตนำร่องที่ไม่สามารถนำเข้าได้</strong></td>
                     <td align="center" bgcolor="#FFFFFF">
                     <?
                     	$sql_rep = "SELECT COUNT(t1.idcard) AS num1 FROM log_import_cmss_detail AS t1 WHERE t1.siteid='$xsiteid' AND t1.profile_id='$profile_id' AND t1.status_replace_sitecon='1' AND import_id='$import_id'";
						$result_rep = mysql_db_query($dbname_temp,$sql_rep);
						$rsrep = mysql_fetch_assoc($result_rep);
						if($rsrep[num1] > 0){
								echo "<a href='report_import_replace.php?action=&xsiteid=$xsiteid&profile_id=$profile_id&import_id=$import_id' target='_blank'>".number_format($rsrep[num1])."</a>";
						}else{
								echo "0";	
						}
					 ?>
                     
                     </td>
                     <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
           <? } //end  if($flag_crontab == "1"){ ?>
           <tr>
             <td align="center">&nbsp;</td>
           </tr>
           <tr>
             <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>รายงานสรุป
                       <?=show_area($xsiteid);?>
                       <br>
                       (ระบบจะทำการนำ้เข้าข้อมูลบัญชี จ.18 ด้วยในกรณีที่เป็นเขตใหม่)                     </strong></td>
                   </tr>
                   <tr>
                     <td width="59%" align="center" bgcolor="#CAD5FF"><strong>รายการ</strong></td>
                     <td width="41%" align="center" bgcolor="#CAD5FF"><strong>จำนวน</strong></td>
                   </tr>
                   <? if(CheckNumJ18($xsiteid) > 0){ ?>
                   <tr>
                     <td colspan="2" align="center" bgcolor="#FFFFFF"><strong><a href="../j18/manager_group/reportj18/index_school.php?xsiteid=<?=$xsiteid?>" target="_blank">แสดงข้อมูลบัญชี จ.18</a></strong></td>
                     </tr>
                     <? } //end if(CheckNumJ18($xsiteid) > 0){?>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>จำนวนหน่วยงานที่มีในchecklistทั้งหมด</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=$numschoolall?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr1['numall']);?>
                     </strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#009900"><strong>&nbsp;&nbsp;จำนวนเอกสารสมบูรณ์</strong></td>
                     <td align="center" bgcolor="#009900"><?=number_format($arr1['numY1']);?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>จำนวนหน้าเอกสารที่นับได้</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numpage']);?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>จำนวนรูปที่นับได้</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numpic']);?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>จำนวนไฟล์ pdf ที่มีในระบบ</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['NumFile']);?></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
         </table></td>
       </tr>
     </table>
   </form></td>
 </tr>
 <tr>
    <td align="right">&nbsp;</td>
  </tr>
 <tr>
   <td align="right">&nbsp;</td>
 </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr align="center">
       <td colspan="6" align="left" bgcolor="#A8B9FF"><strong>ระบบนำเข้าข้อมูลจากฐาน checklist สู่ระบบ cmss <?=show_area($xsiteid);?></strong></td>
        </tr>
      <tr>
        <th width="4%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></th>
        <th width="40%" align="center" bgcolor="#A8B9FF">หน่วยงาน/โรงเรียน</th>
        <th width="14%" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          ทั้งหมด(คน)</strong></th>
        <th width="13%" align="center" bgcolor="#A8B9FF"><strong>จำนวนหน้า<br>
          เอกสาร(แผ่น)</strong></th>
        <th width="15%" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          รูป(รูป)</strong></th>
        <th width="14%" align="center" bgcolor="#A8B9FF">จำนวนไฟล์ pdf<br>
ที่อยู่ในะรบบ(คน)</th>
      </tr>
      </thead>    
	<tbody>   
		<?
			$sql = "SELECT
CAST(id as SIGNED) as id, allschool.siteid,office,
Sum(if(page_upload > 0 ,1,0)) AS NumFile,
Sum(page_num) AS NumPage,
Sum(pic_num) AS NumPic,
Count(idcard) AS NumAll
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
AND edubkk_master.allschool.siteid='$xsiteid'
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' and edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' $con_doccomplate
GROUP BY
edubkk_checklist.tbl_checklist_kp7.schoolid
order by id ASC
";
//echo "$dbname_temp ::: ".$sql;
			$result = mysql_db_query($dbname_temp,$sql);
			$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  $temp_dis = CheckLockArea($rs[secid],$profile_id);
				  //$arrN = CountCheckListKp7($rs[secid],"",$profile_id);
				  $id_org = "$rs[secid]";
				  $numpage = $rs['NumPage']; //  จำนวนแผ่น
				  $numpic = $rs['NumPic']; // จำนวนรูป
				  $numfile = $rs['NumFile'];
				  $count_impP = $rs['NumAll'];// จำนวนทั้งหมด			 
			 
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[office]?></td>
        <td align="center"><?=number_format($count_impP)?></td>
        <td align="center"><?=number_format($numpage)?></td>
        <td align="center"><?=number_format($numpic)?></td>
        <td align="center"><?=number_format($numfile)?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_pic_all += $numpic;
			$sum_imp_all += $count_impP;
			$sum_file_all += $numfile;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
 <tfoot>
      <tr class="txthead">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_imp_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_page_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sum_file_all)?></td>
        </tr>
 </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><em>หมายเหตุ <font color="#FF0000">*</font> หมายถึงเขตที่ตรวจสอบจำนวนถูกต้องแล้ว</em></td>
  </tr>
</table>
<? if($flag_crontab == "1"){	?>
<iframe src="../hr3/tool_competency/crontab_update_master_view_general.php?sent_xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" style="display:none"></iframe>
<?
		include("../pic2cmss/function/function.php");
		$sql1 = "SELECT idcard,profile_id, siteid FROM `upic_temp_person` WHERE status_number_process='2'  AND  status_finish='UNSUCCESS'  AND siteid='$xsiteid' ";
		$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
		while($rs1 = mysql_fetch_assoc($result1)){
			contrab2_updateWorkingChecklist($rs1[idcard],$xsiteid,$rs1[profile_id]);
		}//end while($rs1 = mysql_fetch_assoc($result1)){

		######  นำเข้าข้อมูล จ. 18
		if(CheckNumJ18($xsiteid) < 1){
				ProcessImpJ18($xsiteid);
		}//end if(CheckNumJ18($xsiteid) < 1){
		### end นำขเ้ข้าข้อมูล จ. 18
}//end  if($flag_crontab == "1"){
}//end if($action == ""){
?>
</body>
</html>
