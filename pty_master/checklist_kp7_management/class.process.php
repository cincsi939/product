<?php
### function นำข้อมูลจาก excel ไปประมวลผลต่อ
#include("../../config/conndb_nonsession.inc.php");
include("../../common/class.salarylevel.php");
include("../../common/class.getdata_master.php");


class ProcessImport extends GetDataMaster{	
	private $db_master = DB_MASTER;
	private  $db_command = "command_verification_temp";
	private $db_temp = DB_CHECKLIST;
	private $ch_num="";
	
	
	function GetResult($sql,$dbname=""){
			if($dbname == ""){ $dbname = $this->db_master;}
			return mysql_fetch_assoc(mysql_db_query($dbname,$sql));
	}//end 	function GetResult($sql){
	function Query($dbname,$sql){
			return mysql_db_query($dbname,$sql) or die(mysql_error()."".__LINE__);	
	}


### หาข้อมูล profile ล่าสุด
function GetLastProfile($siteid){
	$sql = "SELECT last_profile AS profile_id FROM view_checklist_lastprofile WHERE siteid='$siteid'";	
	$rs = $this->GetResult($sql,$this->db_temp);
	return $rs[profile_id];
}// end function GetLastProfile($siteid){



function SiteMathSchool($schoolid,$siteid){
	$sql = "SELECT
count(t1.id) as num1
FROM
allschool AS t1
where t1.id='$schoolid' and t1.siteid='$siteid'";	
 	$rs = GetResult($sql);
	return $rs[num1];
}// end function SiteMathSchool($schoolid,$siteid){
	
### ตรวจสอบตำแหน่างที่สัมพันธ์กับระดับ

function PositionMathRadub($position,$radub){
	$sql = "SELECT
count(t1.position) as num1
FROM
hr_addposition_now AS t1
Inner Join position_math_radub AS t2 ON t1.runid = t2.position_id
Inner Join hr_addradub AS t3 ON t2.radub_id = t3.runid
where t1.position='$position' and t3.radub='$radub'";	
 	$rs = GetResult($sql);
	return $rs[num1];
}// end function PositionMathRadub($position,$radub){
	
function PositionMathVitaya($position,$vitaya){
	global $dbnamemaster;
	$sql = "SELECT
Count(t1.position) AS num1
FROM
hr_addposition_now AS t1
Inner Join position_math_vitaya AS t2 ON t1.runid = t2.position_id
Inner Join vitaya AS t3 ON t2.vitaya_id = t3.runid
WHERE
t1.`position`= '$position'  and t3.vitayaname='$vitaya'";	
 	$rs = GetResult($sql);
	return $rs[num1];
}// end function PositionMathVitaya($position,$vitaya){
	
	
############  function เก็บข้อมูลจาก excel_data เข้าไปใน log ประมวลผลนำเข้าข้อมูล
	function SaveLogProcess($idcard,$siteid,$schoolid,$status_site_school,$prename_th,$name_th,$surname_th,$position_now,$pid,$radub,$level_id,$status_position_radub,$vitaya,$vitaya_id,$status_position_vitaya,$no_position,$salary_before,$salary_after,$status_salary,$education,$degree,$birthday,$begindate,$sex,$gender_id,$status_import,$type_action){
		$sql = "INSERT INTO log_import_process SET idcard='$idcard',siteid='$siteid',schoolid='$schoolid',status_site_school='$status_site_school',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',position_now='$position_now',pid='$pid',radub='$radub',level_id='$level_id',status_position_radub='$status_position_radub',vitaya='$vitaya',vitaya_id='$vitaya_id',status_position_vitaya='$status_position_vitaya',no_position='$no_position',salary_before='$salary_before',salary_after='$salary_after',status_salary='$status_salary',education='$education',degree='$degree',birthday='$birthday',begindate='$begindate',sex='$sex',gender_id='$gender_id',status_import='$status_import',type_action='$type_action'";
		$this->Query($this->db_command,$sql);
	}//end function SaveLogProcess(){
	
	function CheckDataCmss($idcard){
			$sql = "SELECT COUNT(CZ_ID) AS num1 FROM view_general WHERE CZ_ID='$idcard' ";
			$rs =$this->GetResult($sql,$this->db_master);
			return $rs[num1];
	}// end function CheckDataCmss($siteid,$idcard){
		
	function CheckDataLog($idcard){
		$sql = "SELECT COUNT(idcard) as num1 FROM log_check_salary WHERE idcard='$idcard'";	
		$rs =$this->GetResult($sql);
		return $rs[num1];
	}
	function CheckDataLast($CZ_ID){
		$sql = "SELECT COUNT(CZ_ID) as num1 FROM view_general_report_lastdata WHERE CZ_ID='$CZ_ID'";	
		$rs =$this->GetResult($sql);
		return $rs[num1];
	}
	
	function GetSexFromPrename(){
		$sql = "SELECT
t1.sex,
t1.gender,
t1.prename_th,
t1.t1.PN_CODE
FROM
prename_th AS t1
where t1.active='on'";	
		$result = mysql_db_query($this->db_master,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[prename_th]]['sex'] = $rs[sex];
				$arr[$rs[prename_th]]['gender_id'] = $rs[gender];
				$arr[$rs[prename_th]]['prename_id'] = $rs[PN_CODE];
		}
		
		return $arr;
	}
	
	### ตรวจสอบวันเดือนปีเกิดและวันเริ่มปฏิบัติ
	function CheckDateImp($date1,$date2){
		$sql = "SELECT  FLOOR(TIMESTAMPDIFF(MONTH,'".$date1."','".$date2."')/12) AS yy";	
		$rs =$this->GetResult($sql);
		if($rs[yy] == "" or $rs[yy] < 0){
				$result = 0;
		}else{
				$result = 1;	
		}//end if($rs[yy] == "" or $rs[yy] < 0){
		return $result;
	}
	
	### 
function GetMaxImportExcel($siteid){
		$sql = "SELECT
Max(t1.excel_id) AS maxid,
t1.siteid
FROM
excel_profile AS t1
where t1.siteid='$siteid'";	
		$rs =$this->GetResult($sql,$this->db_command);
		return $rs[maxid];
	}
	
	#### function เพิ่มข้อมูล ในตาราง general
	function InsertDataGeneral($idcard,$siteid,$schoolid,$birthday,$prename_th,$name_th,$surname_th,$begindate,$radub,$level_id,$sex,$gender_id,$position_now,$pid,$dateposition_now,$salary,$positiongroup,$vitaya,$vitaya_id,$noposition){
		$dbsite = "cmss_".$siteid;
			$sql = "INSERT INTO general SET id='$idcard',idcard='$idcard',pivate_key='',siteid='$siteid',schoolid='$schoolid',birthday='$birthday',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',begindate='$begindate',radub='$radub',level_id='$level_id',sex='$sex',gender_id='$gender_id',position_now='$position_now',pid='$pid',dateposition_now='$dateposition_now',salary='$salary',positiongroup='$positiongroup',vitaya='$vitaya',vitaya_id='$vitaya_id',noposition='$noposition'";
			$this->Query($dbsite,$sql);
	}
	
	
	
	
	## GetBdateChecklist
	function GetBdate($idcard,$profile_id){
		$sql = "SELECT birthday,begindate FROM tbl_checklist_kp7 WHERE idcard='$idcard'  AND profile_id='$profile_id' ";	
		$rs =$this->GetResult($sql,$this->db_temp);
		$arr['birthday'] = $rs[birthday];
		$arr['begindate'] = $rs[begindate];
		return $arr;
	}
	
	#### function ตรวจสอบข้อมูล
	function CheckDataCheckList($idcard,$profile_id){
		$sql = "SELECT COUNT(idcard) as num1 FROM tbl_checklist_kp7 WHERE idcard='$idcard' and profile_id='$profile_id'";	
		$rs =$this->GetResult($sql,$this->db_temp);
		return $rs[num1];
	}
	
	### function เพิ่มข้อมูลใน checklist
	function InsertDataChecklist($idcard,$profile_id,$siteid,$prename_th,$name_th,$surname_th,$birthday,$begindate,$position_now,$schoolid,$sex,$status_numfile,$status_file,$status_check_file){
		$sql = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard',profile_id='$profile_id',siteid='$siteid',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',birthday='$birthday',begindate='$begindate',position_now='$position_now',schoolid='$schoolid',sex='$sex',status_numfile='$status_numfile',status_file='$status_file',status_check_file='$status_check_file'";	
		$this->Query($this->db_temp,$sql);
	}

	#### บันทึกข้อมูลลงใน view_general_report_lastdata 
	function InsertViewGeneralLastData($idcard,$siteid,$prename_th,$name_th,$surname_th,$education,$graduate_level,$degree_level,$radub,$level_id,$position_now,$pid,$schoolid,$salary,$vitaya,$vitaya_id,$positiongroup,$schoolname,$date_command,$noposition,$birthday,$begindate,$sex,$genera_id){
		$sql = "INSERT INTO view_general_report_lastdata SET CZ_ID='$idcard',siteid='$siteid',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',education='$education',graduate_level='$graduate_level',degree_level='$degree_level',radub='$radub',level_id='$level_id',position_now='$position_now',pid='$pid',schoolid='$schoolid',salary='$salary',vitaya='$vitaya',vitaya_id='$vitaya_id',positiongroup='$positiongroup',schoolname='$schoolname',date_command='$date_command',noposition='$noposition',birthday='$birthday',begindate='$begindate',sex='$sex',genera_id='$genera_id',status_key='1' ";
		$this->Query($this->db_master,$sql);
	}
	
	#### function ตรวจสอบข้อมูลใน logsalary
	function CheckLogCheckSalary($idcard){
			$sql = "SELECT COUNT(idcard) as num1 FROM log_check_salary WHERE idcard='$idcard'";
			$rs =$this->GetResult($sql,$this->db_master);
	}
	
	### บันทึกข้อมูลลงใน log_check_salary เพื่อใช้ประมวลผลเงินเดือน หมื่นห้า
	
	function InsertLogCheckSalary($idcard,$siteid,$name,$surname,$level,$level_id,$position_now,$pid,$education,$education_name,$salary_now,$salary_date_now){
		$sql = "INSERT INTO log_check_salary SET idcard='$idcard',siteid='$siteid',name='$name',surname='$surname',level='$level',level_id='$level_id',position_now='$position_now',pid='$pid',education='$education',education_name='$education_name',salary_now='$salary_now',salary_date_now='$salary_date_now',flag_data='1'";	
		$this->Query($this->db_master,$sql);
	}
	
	### แปลงปี คศ. เป็น พ.ศ.
	function ConvDateYY($d){
			if($d == "0000-00-00") return "";
			if($d == "none") return "";
			if($d == "") return "";
			$arr = explode("-",$d);
			return ($arr[0]+543)."-".$arr[1]."-".$arr[2];
	}
	
}//####################################################################### end class


### ตัวอย่าง class

#$obj_process = new ProcessImport(); // ตรวจสอบการประมวล
#$obj_data = new GetDataMaster();// แสดงผข้อมูลหลักใน master

#$obj_salary=new salary_level(); // ตรวจสอบข้อมูลผังเงินเดือน
#$radub = $obj_data->GetRadub("91254701");
#$x=$obj_salary->check("$radub",'18690','2011-10-01');




?>