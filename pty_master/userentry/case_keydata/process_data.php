<?php
### function นำข้อมูลจาก excel ไปประมวลผลต่อ
include("../../config/conndb_nonsession.inc.php");
include("class.process.php");
$gid = 5;// รหัสกลุ่มตัวแรกของ 38 ค
$gid1 = 6;


if($action == "process"){
	
	$obj_process = new ProcessImport(); // ตรวจสอบการประมวล
	$obj_data = new GetDataMaster();// แสดงผข้อมูลหลักใน master
	
	$obj_salary=new salary_level(); // ตรวจสอบข้อมูลผังเงินเดือน
	$radub = $obj_data->GetRadub("91254701");
	
	
	$x=$obj_salary->check("$radub",'18690','2011-10-01');
	
	echo "radub => $radub :: chsalary => $x";
	die();
	
	
	$arr_sex = $obj_process->GetSexFromPrename();// หาเพศจากคำนำหน้าชื่อ
	
	$sql ="SELECT * FROM site_process_data WHERE status_process='0' ";
	$result = mysql_db_query($db_command_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$siteid = $rs[siteid];
		## ข้อมูลส่วสุดที่นำเข้า
		$excel_id = $obj_process->GetMaxImportExcel($rs[siteid]);
		$sql_data = "SELECT
t1.excel_id,
t1.date_create,
t1.siteid,
t1.schoolid,
t1.prename,
t1.name,
t1.surname,
t1.idcard,
t1.`position`,
t1.vitaya,
t1.no_position,
t1.level_before,
t1.salary_before,
t1.salary_after,
t1.education,
t1.degree,
t1.schoolname,
t1.birthday,
t1.begindate,
t1.sex,
t1.gender_id,
t1.payment_2,
t1.percen_up
FROM
excel_data AS t1
WHERE t1.excel_id='$excel_id' AND t1.siteid='$siteid' and t1.idcard <> 'none' and t1.salary_before <> 'none'";
	$result_data = mysql_db_query($db_command_temp,$sql_data) or die(mysql_error()."".__LINE__);
	while($rsd = mysql_db_query($result_data)){
				$idcard = $rsd[idcard];
				$siteid = $rsd[siteid]; // รหัสเขต
				$schoolid = $rsd[schoolname]; // รหัสโรงเรียน
				$schoolname = $obj_data->GetSchool($rsd[schoolname]);
				$noposition = $rsd[no_position];
				$radub = $obj_data->GetRadub($rsd[level_before]);
				$level_id = $rsd[level_before];
				$position_now = $obj_data->GetPosition($rsd[position]); // ชื่อตำแหน่ง
				$pid = $rsd[position];// รหัสตำแหน่ง
				
				$prename_th = $rsd[prename];
				$name_th = $rsd[name];
				$surname_th = $rsd[surname];
		
				$sub_pid = substr($rsd[position],0,1); // หารหัสตัวแรกเพื่อตรวจสอบว่าเป็นข้อมูล 38 ค.รึเปล่า
				$positiongroup = $sub_pid;
				if($rsd[education] != "none"){
					$education = $rsd[education];
					$education_name = $obj_data->GetHighgrade($education);
				}else{
					$education = "";
					$education_name = "";
				}
				
		
		
			## หาข้อมูล profile ล่าสุด
			$profile_id = $obj_process->GetLastProfile($rs[siteid]);
			
			##  หาข้อมูลเงินเดือน
			if($sub_pid == $gid or $sub_pid == $gid1){ # เป็นบุคลากร 38 ค
				if($rsd[payment_2] > 0){
					$salary = $rsd[salary_after]-$rsd[payment_2];// เงินเดือนที่หักค่าตอบแทนพิเศษ
				}else{
					$salary = $rsd[salary_after];
				}//end if($rsd[payment_2] > 0){
			}else{
					$salary = $rsd[salary_after]	;
			}//end if($sub_pid == $gid or $sub_pid == $gid1){ 
			########### end ข้อมูลเงินเดือน
			### ข้อมูลวันเดือนปีเกิด
			if($rsd[birthday] == 'none' or $rsd[begindate] == 'none'){
					$arr_d = $obj_process->GetBdate($rsd[idcard],$profile_id);
			}// end end if($rsd[birthday])
				### ข้อมูลวันเกิด
					if($rsd[birthday] == 'none'){
						$birthday = $arr_d['birthday']; 
					}else{
						$birthday = $rsd[birthday];	
					}
				### ข้อมูลวันเริ่มปฏิบัติราชการ
					if($rsd[begindate] == 'none'){
						$begindate = $arr_d['begindate']; 
					}else{
						$begindate = $rsd[begindate];	
					}
						
					### ข้อมูลเพศ
					if($rsd[sex] == "none" ){
							$sex = $arr_sex[$rsd[prename_th]]['sex'];
					}else{
							$sex = $rsd[sex];	
					}
					### รหัสเพศ
					if($rsd[gender_id] == "none"){
							$gender_id = $arr_sex[$rsd[prename_th]]['gender_id'];
					}else{
							$gender_id = $rsd[gender_id];	
					}
					### รหัสคำนำหน้าชื่อ
					$prename_id = $arr_sex[$rsd[prename_th]]['prename_id'];
					
					### หาข้อมูลวิทยฐานะ
					if($rsd[vitaya] != "none"){
							$vitaya = $obj_data->GetVitaya($rsd[vitaya]);
							$vitaya_id = $rsd[vitaya];
					}else{
							$vitaya = "";
							$vitaya_id = "";
					}
					
					## วันที่เงินเดือน
					$date_salary = $rsd['date_create']; // ค.ศ.
					$dateposition_now = $obj_process->ConvDateYY($date_salary); // วันที่เงินเดือน พ.ศ.
					
					
				#### ตรวจสอบ รหัสโรงเรียนต้องสัมพันกับเขต
				$checkmathschool = $obj_process->SiteMathSchool($schoolid,$siteid); 
				###  ตรวจสอบเงินเดือนตรงตามผัง
				$checksalary =$obj_salary->check("$radub","$salary","$date_salary");
				## ตรวจสอบตำแหน่งสัมพันธ์กับระดับ
				$checkpositon_radub = $obj_process->PositionMathRadub($position_now,$radub);
				
				### ตรวจสอบวิทยฐานะที่สัมพันธ์กับตำแหน่ง
				if($vitaya != ""){
						$checkvitaya = $obj_process->PositionMathVitaya($position_now,$vitaya);
				}else{
						$checkvitaya = "1";		
				}
				
				if($checkmathschool > 0){ // ข้อมูลรหัสโรงเรียนสัมพันธ์กับเขต
				### ตรวจสอบว่ามีข้อมูลอยู่ในระบบ cmss หรือยัง
				$numcmss = $obj_process->CheckDataCmss($idcard);
				## หากไม่มีข้อมูลใน cmss
				if($numcmss < 1){
						$obj_process->InsertDataGeneral($idcard,$siteid,$schoolid,$birthday,$prename_th,$name_th,$surname_th,$begindate,$radub,$level_id,$sex,$gender_id,$position_now,$pid,$dateposition_now,$salary,$positiongroup,$vitaya,$vitaya_id,$noposition);
						$type_action = "insert"; // ประเภทข้อมูล
				}else{
						$type_action = "update";	
				}//end if($numcmss < 1){
				
				### ตรวจสอบเพื่อบันทึกข้อมูลใน temp ข้อมูลล่าสุด
				$numlastdata = $obj_process->CheckDataLast($idcard);// หาข้อมูลล่าสุด
				if($numlastdata < 1){
						$obj_process->InsertViewGeneralLastData($idcard,$siteid,$prename_th,$name_th,$surname_th,$education,$graduate_level,$degree_level,$radub,$level_id,$position_now,$pid,$schoolid,$salary,$vitaya,$vitaya_id,$positiongroup,$schoolname,$dateposition_now,$noposition,$birthday,$begindate,$sex,$genera_id);
				}// end if($numlastdata < 1){
					
				
				
				### ตรวจสอบบันทึกข้อมูลใน สนเ  log salary
				$status_import = 0;	
				$numlog_salary = $obj_process->CheckLogCheckSalary($idcard);
				if($numlog_salary < 1){
						$obj_process->InsertLogCheckSalary($idcard,$siteid,$name_th,$surname_th,$radub,$level_id,$position_now,$pid,$education,$education_name,$salary,$dateposition_now);
						$status_import = 1;				
				}// end if($numlog_salary < 1){
				
				
				#### ตรวจสอบข้อมูลใน checklist
				$num_checklist = $obj_process->CheckDataCheckList($idcard,$profile_id);
				if($num_checklist < 1){
						$obj_process->InsertDataChecklist($idcard,$profile_id,$siteid,$prename_th,$name_th,$surname_th,$birthday,$begindate,$position_now,$schoolid,$sex,"1","1","YES");
				}
			
		}//end  if($checkmathschool > 0){ // ข้อมูลรหัสโรงเรียนสัมพันธ์กับเขต
		
		
		### บันทึกข้อมูลใน log การนำเข้าข้อมูล
		$obj_process->SaveLogProcess($idcard,$siteid,$schoolid,$checkmathschool,$prename_th,$name_th,$surname_th,$position_now,$pid,$radub,$level_id,$checkpositon_radub,$vitaya,$vitaya_id,$checkvitaya,$noposition,$rsd[salary_before],$salary,$checksalary,$rsd[education],$rsd[degree],$birthday,$begindate,$rsd[sex],$rsd[gender_id],$status_import,$type_action);
		
		
		
			
	}// end while($rsd = mysql_db_query($result_data)){
		
		
		
			
	}//end while($rs = mysql_fetch_assoc($result)){

}// end if($action == "process"){

echo "Done...";
?>