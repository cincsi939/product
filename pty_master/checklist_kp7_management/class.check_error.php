<?
## ตรวจสอบ error ของการบันทึกข้อมูล ก.พ. 7
## by suwat


include("class.db.php");
class CheckDataError extends mysql_db{
	private $arr_pid = array(); // เก็บรหัสตำแหน่ง
	var $arr_error = array(); // เก็บ error ของข้อมูล
	private $arr_level = array();// เก็บรหัสระดับปัจจุบัน
	private $arr_pos = array(); // เก็บรหัสตำแหน่ง
	private $graduate_id = "40"; // รหัสระดับการศึกษาปริญญาตรี
	private $arr_pgroup = array();
	private $__minage = 18; # อายุต่ำสุดที่รับราชการได้
	private $__maxage = 61;
	private $__mmdd = "10-01"; // เดือนที่เกษียนอายุราชการ
	private $__minageG = 0; #เงื่อนไขการตรวจสอบอายุราชการ
	private $__maxageG = 42; ## อายุราชการสูงสุด
	private $__diffyy = 0; # ผลต่างของเวลาวันเริ่มปฏิบัติราชการและวันสังบรรจุ
	private $arr_vitaya = array(); // ข้อมูลวิทยฐานะ
	private $arr_sex = array("1"=>"ชาย","2"=>"หญิง");// ข้อมูลเพศ
	private $arr_prename = array(); // เก็บรหัสตำแหน่ง
	var $__arr = array();
	
	
		
	
	## คำนำหน้าชื่อ 
	private function GetPrenameCode(){
		$sql = "SELECT PN_CODE, prename_th FROM prename_th WHERE active='on'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_prename[$rs[PN_CODE]] = $rs[prename_th];
		}
		$this->SetResult();
		return $this->arr_prename;
	}
	
		###  loop หาตำแหน่งที่วุฒิการศึกษาต้องไม่ต่ำกว่าปริญญาตรี
	private function GetpidG(){
		
		$sql = "SELECT pid FROM `hr_addposition_now` where status_graduate_high='1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
			$this->arr_pid["{$rs[pid]}"] = "{$rs[pid]}";	
		}//end while($rs = $this->FetchRow($result)){
			$this->SetResult();
			return $this->arr_pid;
	}// end 	private function GetpidG(){
	
	### หาตำแหน่งปัจจุบัน
	private function GetPositionR(){
			$sql = "SELECT pid,`position` FROM hr_addposition_now WHERE status_active='yes' ";
			$this->Query($this->db_master,$sql);
			while($rs = $this->FetchRow($this->__result)){
					$this->arr_pos["{$rs[pid]}"] = "{$rs[position]}";
			}
			$this->SetResult();
			return $this->arr_pos;
	}//end private function GetPositionR(){
	
	### รหัสระดับ
	private function GetRadubR(){
		$sql = "SELECT t1.level_id, t1.radub FROM hr_addradub AS t1 WHERE t1.active_now =  '1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_level["{$rs[level_id]}"] = "{$rs[radub]}";
		}
		$this->SetResult();
		return $this->arr_level;
	}//end private function GetRadubR(){
		
	### รหัสกลุ่มตำแหน่ง
	private function GetPositionGroup(){
		$sql = "SELECT t1.positiongroupid, t1.positiongroup FROM hr_positiongroup AS t1 where t1.status_active='1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_pgroup["{$rs[positiongroupid]}"] = "{$rs[positiongroup]}";
		}
		$this->SetResult();
		return $this->arr_pgroup;
	}
	### หาตำแหน่ง
	private function CheckPosMathRadub($pid,$level){
		$sql = "SELECT
count(t2.pid) as num1
FROM
position_math_radub AS t1
Inner Join hr_addposition_now AS t2 ON t1.position_id = t2.runid
Inner Join hr_addradub AS t3 ON t1.radub_id = t3.runid
where t2.pid='{$pid}' and t3.level_id='{$level}' GROUP BY t2.pid ";	
		$this->Query($this->db_master,$sql);
		$rs = $this->FetchRow();
		$this->SetResult();
		return $rs[num1];
	}
	
	#### ตรวจสอบอายุ
	 public function GetAge($d1){
		$arr_d1 = explode("-",$d1);
		$date1 = ($arr_d1[0]-543)."-".$arr_d1[1]."-".$arr_d1[2];
		$yy = date("Y");
		$mm = date("m");
		if(intval($mm) >= 10){
				$yy = $yy+1;
		}
		$date2 = $yy."-".$this->__mmdd;

		
		$sql = "SELECT FLOOR((TIMESTAMPDIFF(MONTH,'".$date1."','".$date2."')/12)) as age";	
		#echo $sql."<hr>";
		$this->Query($this->db_master,$sql);
		$rs = $this->FetchRow();
		$this->SetResult();
		#$rs = $this->GetResult($this->db_master,$sql);
		return $rs[age];
	}
	
	
	### ตรวจโรงเรียนไม่สัมพันธ์กับเขต
	public function CheckSchoolMathSite($idcard){
		$sql = "SELECT
count(t1.CZ_ID) as num1
FROM
view_general AS t1
Inner Join allschool AS t2 ON t1.schoolid = t2.id AND t1.siteid = t2.siteid
where t1.CZ_ID='{$idcard}' and t2.activate_status='open'
group by t1.CZ_ID";
		$this->Query($this->db_master,$sql);
		$rs = $this->FetchRow();
		$this->SetResult();
		return $rs[num1];
	}// end public function CheckSchoolMathSite($idcard){
		
	### ตาวจสอบสังกัดเขตพื่นที่การศึกษา
	private function GetSecnameFromSchool($schoolid){
		$sql = "SELECT t2.secname_short FROM allschool AS t1
Inner Join eduarea AS t2 ON t1.siteid = t2.secid where t1.id='$schoolid' and t1.activate_status='open'";	
		$this->Query($this->db_master,$sql);
		$rs = $this->FetchRow();
		$this->SetResult();
		return $rs[secname_short];
	}// end private function GetSecnameFromSchool($schoolid){
	
		
	#### นับจำนวนข้อมูลการศึกษา	
	private function CheckGraduate($siteid,$idcard){
			$dbsite = "cmss_".$siteid;
			$sql = "SELECT COUNT(id) as num FROM graduate WHERE id='{$idcard}' GROUP BY id";
			$this->Query($dbsite,$sql);
			$rs = $this->FetchRow();
			$this->SetResult();
			return $rs[num];
	}
	
	## ตรวจสอบผังเงินเดือน
	private function CheckSalaryLevel($level_id,$salary){
		$sql = "SELECT
count(t1.money) as num1
FROM
tbl_salary_level AS t1
Inner Join tbl_salary_radub AS t2 ON  t2.salary_radub_id = t1.salary_radub_id
Inner Join tbl_salary_math_radub AS t3 ON t3.salary_radub_id = t2.salary_radub_id
Inner Join hr_addradub AS t4 ON t4.runid = t3.radub_id
WHERE
t4.level_id =  '$level_id' and (t1.money='$salary' or  t1.money0_5='$salary' or  t1.money1='$salary' or  t1.money1_5='$salary')
group by t1.money";
	$this->Query($this->db_master,$sql);
	$rs = $this->FetchRow();
	$this->SetResult();
	return $rs[num1];	
	}// end private function CheckSalaryLevel($level_id,$salary){
	
	
### ตรวจสอบวิทยฐานะที่สัมพันธ์กับตำแหน่งและวิทยฐานะ
	private function CheckVitayaMath($vitaya_id,$pid,$level_id){
		$sql = "SELECT
t1.position_id,
t1.vitaya_id,
t2.`position`,
t4.level_id,
t2.pid
FROM
position_math_vitaya AS t1
Inner Join hr_addposition_now AS t2 ON t2.runid = t1.position_id
Inner Join position_math_radub AS t3 ON t1.position_id = t3.position_id
Inner Join hr_addradub AS t4 ON t3.radub_id = t4.runid
where t1.vitaya_id='{$vitaya_id}' and t2.pid='{$pid}' and t4.level_id='{$level_id}'";
			$this->Query($this->db_master,$sql);
			$rs = $this->FetchRow();
			$this->SetResult();
		$arrdata['pid'] = $rs[pid];
		$arrdata['level_id'] = $rs[level_id];
		$arrdata['vitaya_id'] = $rs[vitaya_id];
	return $arrdata;
	}
		
		
### ข้อมูลรหัสวิทยฐานกับวิทยฐานะ
private function Getvitaya(){
	$sql = "SELECT runid as vitaya_id, vitayaname as vitaya FROM vitaya ";
	$this->Query($this->db_master,$sql);
	while($rs = $this->FetchRow($this->__result)){
			$this->arr_vitaya["{$rs[vitaya_id]}"] = "{$rs[vitaya]}";
	}//end 
	$this->SetResult();
	return $this->arr_vitaya;
}//end private function Getvitaya(){
	
### ตรวจสอบที่อยู่ปัจจุบัน
private function GetAddress($siteid,$idcard){
	$dbsite = "cmss_".$siteid;
	$sql = "SELECT COUNT(gen_id) as num1 FROM  hr_addhistoryaddress WHERE gen_id='{$idcard}'";	
	$this->Query($dbsite,$sql);
	$rs = $this->FetchRow();
	$this->SetResult();
	return $rs[num1];
}

### ตรวจสอบข้อมูลรูปภาพ
 function CheckPic_kp7($siteid,$idcard,$profile_id){
	$db_site = "cmss_".$siteid;
	$sql = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='{$idcard}' GROUP BY id";
	$this->Query($db_site,$sql);
	$rs = $this->FetchRow();
	
	$numpic_cmss = $rs[numpic];
	$this->SetResult();
	
	$sqlc = "SELECT pic_num FROM  tbl_checklist_kp7 WHERE siteid='{$siteid}' AND idcard='{$idcard}' AND profile_id='{$profile_id}' ";
	$this->Query($this->db_temp,$sqlc);
	$rsc = $this->FetchRow();

	$numpic_checklist = $rsc[pic_num];
	$this->SetResult();
	
	#echo "numpic_cmss = $numpic_cmss || numpic_checklist = $numpic_checklist<br>";die();
	
	if($numpic_checklist > 0){
		if($numpic_cmss != $numpic_checklist){
			$arrmsg[0] = 0;
			$arrmsg[1] = "จำนวนรูปในระบบ cmss ไม่ตรงกับ Checklist  หน่วยนับใน Checklist มี {$numpic_checklist} รูป ระบบ cmss มี {$numpic_cmss} รูป";
		}else{
			$arrmsg[0] = 1;
		}
	}else{
			$arrmsg[0] = 1;	
	}//end if($rs[pic_num] > 0){
		return $arrmsg;
	
}//end private function CheckPic_kp7($siteid,$idcard,$profile_id){
	
public function GetCodeError(){
		$sql = "SELECT tbl_error_code.error_code, tbl_error_code.error_comment FROM `tbl_error_code` where status_block='1'";	
		$this->Query($this->db_entry,$sql);
		while($rs = $this->FetchRow()){
			$this->__arr["{$rs[error_code]}"] =   "{$rs[error_comment]}";
		}
	return $this->__arr;
}


		
	public function CheckDataCmss($idcard,$profile_id){
					
			unset($this->arr_error);
			unset($this->arr_pid);
			unset($this->arr_level);
			unset($this->arr_pos);
			unset($this->arr_pgroup);
			unset($this->arr_vitaya);
			
			$this->GetpidG();### หารหัสที่ตำแหน่ง
			$this->GetRadubR(); # รหัสระดับปัจจุบัน
			$this->GetPositionR();# ตำแหน่งปัจจุบัน
			$this->GetPositionGroup();# สายงาน
			$this->Getvitaya();// แสดงชื่อและรหัสวิทยฐานะ
			#echo "idcard = $idcard<br>";
			$xsql = "SELECT * FROM view_general WHERE CZ_ID='{$idcard}'";	
			$this->Query($this->db_master,$xsql);
			$xrs = $this->FetchRow($this->__result);
			$dbsite = "cmss_".$xrs[siteid];
			$this->SetResult();
			
			$sql = "SELECT * FROM view_general WHERE CZ_ID='{$idcard}'";	
			$this->Query($dbsite,$sql);
			$rs = $this->FetchRow($this->__result);
			#echo "<pre>";
			#print_r($rs);
			

			
			$age = intval($this->GetAge($rs[birthday]));## อายุตัว
			$age_gov = intval($this->GetAge($rs[begindate])); # อายุรับราชการ
			$age_start =  intval($this->GetAge($rs[startdate])); # อายุนับจากวันเริ่มรับราชการ
			$age_diff = $age_gov-$age_start; # ผลต่างระหว่างอายุราชการและวันสั่งบรรจุ
			

			
			### ตรวจสอบข้อมูลทั่วไป
			# รูปภาพ
			$arrpic = $this->CheckPic_kp7($rs[siteid],$rs[CZ_ID],$profile_id);
			if($arrpic[0] == "0"){
				$this->arr_error['A001'] = $arrpic[1];
				
			}
			
			# ที่อยู่ปัจจุบัน
			if($this->GetAddress($rs[siteid],$rs[CZ_ID]) < 1){
					$this->arr_error['A002'] = "ไม่ระบุที่อยู่ปัจจุบัน";
			}
			if($rs[prename_th] == "" or $rs[name_th] == "" or $rs[surname_th] == ""){
					$this->arr_error['A003'] = "ไม่ระบุ คำนำหน้าชื่อ หรือ ชือ หรือ นามสกุล";
			}
			
			
			
			
		####################  ตรวจสอบวุฒิการศึกษา
			## ตรวจสอบการบันทึกข้อมูลการศึกษา
			if($this->CheckGraduate($rs[siteid],$rs[CZ_ID]) < 1){
				$this->arr_error['B001'] = "ไม่พบการบันทึกข้อมูลการศึกษา";
			}else{
		
			### ตรวจสอบการศึกษาเป็นค่าว่าง
			if($rs[education] == "" or $rs[graduate_level] == ""){
					$this->arr_error['B002'] = "การศึกษาสูงสุดเป็นค่าว่าง";
			}
			#### ตรวจสอบตำแหน่งที่การศึกษาไม่ควรต่ำกว่าปริญญาตรี
			if ((array_key_exists($rs[graduate_level], $this->arr_pid)) and $rs[graduate_level] < $this->graduate_id) {
					$this->arr_error['B003'] = "ตำแหน่ง {$rs[position_now]}  การศึกษาไม่ควรต่ำกว่าปริญญาตรี";
			}
			### ตรวจสอบวุฒิการศึกษาเป็นค่าว่าง
			if($rs[degree_level] == ""){
					$this->arr_error['B004'] = "วุฒิการศึกษาไม่ควรเป็นค่าว่าง";
			}
		}// end if($this->CheckGraduate($rs[siteid],$rs[CZ_ID]) < 1){
	################## end ตรวจสอบวุฒิการศึกษา
	
	## ตรวจสอบระดับ
		if($rs[radub] == ""){
				$this->arr_error['R001'] = "ระดับเป็นค่าว่าง";
		}
	
		if($this->CheckPosMathRadub($rs[pid],$rs[level_id]) < 1){
				$this->arr_error['R002'] = "ระดับไม่สัมพันธ์กับตำแหน่ง  ระดับคือ {$rs[radub]} ตำแหน่งคือ {$rs[position_now]} ";		
		}
		### ระดับไม่ใช่ระดับปัจจุบัน
		
		
		if(!(array_key_exists($rs[level_id],$this->arr_level))){
			$this->arr_error['R003'] = "ระดับ {$rs[radub]} ไม่ใช่ระดับปัจจุบัน";
		}
		### รหัสระดับไม่สัมพันธ์กับชื่อระดับ
		if($this->arr_level[$rs[level_id]] != $rs[radub]){
				$this->arr_error['R004'] = "รหัสระดับไม่สัมพันธ์กับชื่อระดับ ระดับ {$rs[radub]} หากอิงจากรหัสระดับที่ถูกต้องคือ ".$this->arr_level[$rs[level_id]];
		}
		
	### ตรวจสอบตำแหน่ง ####################################
	if($rs[position_now] == ""){
		$this->arr_error['P001'] = "ตำแหน่งปัจจุบันเป็นค่าว่าง";
	}
	
	if($this->arr_pos[$rs[pid]] != $rs[position_now]){
			$this->arr_error['P002'] = "รหัสตำแหน่งไม่สัมพันธ์กับชื่อตำแหน่ง  {$rs[position_now]} หากอ้างอิงจากรหัสตำแหน่งที่ถูกต้องคือ ".$this->arr_pos[$rs[pid]];
	}
	## รหัสตำแหน่งไม่สัมพันธ์กับรหัสกลุ่มตำแหน่ง
	if(substr($rs[pid],0,1) != $rs[positiongroup]){
			$this->arr_error['P003'] = "ตำแหน่งไม่สัมพันธ์กับสายงานสายงานปัจจุบันคือ ".$this->arr_pgroup["{$rs[positiongroup]}"]." หากอิงตามรหัสตำแหน่งสายงานที่ถูกต้องคือ ".$this->arr_pgroup[substr($rs[pid],0,1)];
	}
	if($rs[noposition] == ""){
			$this->arr_error['P004'] = "เลขที่ตำแหน่งเป็นค่าว่าง";
	}
	
	#### ตรวจสอบวันเดือนปีเกิด
	if($age < $this->__minage){
			$this->arr_error['D001'] = "วันเดือนปีเกิดไม่ถูกต้อง วันเดือนปีเกิดคือ {$rs[birthday]} ";
	}
	### ตรวจสอบอายุ
	if($age < $this->__minage and $age >  $this->__maxage){
			$this->arr_error['D002'] = "วันเดือนปีเกิดไม่ถูกต้องเมื่อคำนวณแล้วอายุปัจจุบันเท่ากับ  $age ปี";
	}
	
	### ตรวจสอบอายุราชการ
	if($age_gov < $this->__minageG){
			$this->arr_error['D003'] = "วันเริ่มปฏิบัติราชการไม่ถูกต้อง วันเริ่มปฏิบัติราชการคือ {$rs[begindate]} ";
	}
	
	## ตรวจสอบเวลาราชการที่เป็นไปได้
	if($age_gov < $this->__minageG and $age_gov > $this->__maxageG){
			$this->arr_error['D004'] = "วันเริ่มปฏิบัติราชการไม่ถูกต้องเมื่อคำนวณแล้วอายุราชการปัจจุบันเท่ากับ $age_gov ปี";
	}
	
	# ตรวจสอบวันสั่งบรรจุ
	if($age_start < $this->__minageG){
		$this->arr_error['D005'] = "วันสั่งบรรจุไม่ถูกต้อง วันสั่งบรรจุ คือ {$rs[begindate]} ";	
	}
	
	if($age_start < $this->__minageG and $age_start > $this->__maxageG){
			$this->arr_error['D006'] = "วันสั่งบรรจุไม่ถูกต้องเมื่อคำนวณแล้วสังบรรจุมาแล้ว  $age_gov ปี";
	}
	
	### ผลต่างของวันเริ่มปฏิบัติราชการและวันสั่งบรรจุ
	if($age_diff != $this->__diffyy){
			$this->arr_error['D007'] = "วันสั่งบรรจุหรือวันเริ่มปฏิบัติราชการไม่ถูกต้อง ปัจจุบันห่างกัน $age_diff ปี";
	}
		
	### ตรวจสอบหน่วยงานสังกัด 
	
	if($this->CheckSchoolMathSite($rs[CZ_ID]) < 1){
			$this->arr_error['E001'] = "ข้อมูลสังกัดโรงเรียนไม่สัมพันธ์กับเขตพื้นที่การศึกษา หากอ้างอิงตามรหัสโรงเรียนปัจจุบันสังกัด สพท คือ ".$this->GetSecnameFromSchool($rs[schoolid]);
	}
			
	if($this->CheckSalaryLevel($rs[level_id],$rs[salary]) < 1){
			$this->arr_error['S001'] = "เงินเดือนไม่ถูกต้อง ระดับ $rs[radub] ไม่มีเงินเดือน $rs[salary] ในผังเงินเดือน";
	}
	
	#### ตรวอจสอบวิทยฐานะที่ไม่สัมพันธ์กับตำแหน่งและระดับ
	if($rs[vitaya] != "" and  $this->arr_vitaya[$rs[vitaya_id]] != $rs[vitaya]){
		$this->arr_error['V001'] = "ข้อมูลรหัสวิทยฐานะไม่สัมพันธ์กับชื่อวิทยฐานะ หากอิงตามรหัสวิทยฐานะชื่อวิทยฐานะคือ ".$this->arr_vitaya[$rs[vitaya_id]]." แต่ชื่อวิทยฐานะคือ {$rs[vitaya]}";
			
	}
	
	if($rs[vitaya] != ""){
		$arr_vitaya = $this->CheckVitayaMath($rs[vitaya_id],$rs[pid],$rs[level_id]);
		if($arr_vitaya['level_id'] == ""){
				$this->arr_error['V002'] = "ข้อมูลวิทยฐานะไม่สัมพันธ์กับระดับ  ".$this->arr_level[$rs[level_id]] ." ไม่ควรมีวิทยฐานะ ".$this->arr_vitaya[$rs[vitaya_id]];
		}
		
		if($arr_vitaya['pid'] == ""){
				$this->arr_error['V003'] = "ข้อมูลวิทยฐานะไม่สัมพันธ์กับตำแหน่ง ".$rs[position_now]." ไม่ควรมีวิทยฐานะ  ".$this->arr_vitaya[$rs[vitaya_id]];
		}
			
	}
	
	
	### ตรวจสอบข้อมูลเพศ
	if($rs[sex] == ""){
			$this->arr_error['GN01'] = "ไม่ระบุเพศ";
	}else{
			if($this->arr_sex[$rs[gender_id]] != $rs[sex]){
				$this->arr_error['GN02'] = "ข้อมูลเพศไม่สัมพันธ์กัน โดยรหัสไม่สัมพันธ์กับ Label ";
			}	
	}
	
	
		$this->SetResult();
		return $this->arr_error;
		
			
	}
		
}//end class CheckDataError{ 

### ตัวอย่าง
/*$idcard = "3509900589319";
$profile_id = "9";

$obj = new CheckDataError();
$arr = $obj->CheckDataCmss($idcard,$profile_id);
echo "แสดงข้อความ => <pre>";
print_r($arr);*/







	



?>