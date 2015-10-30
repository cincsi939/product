<?
## ��Ǩ�ͺ error �ͧ��úѹ�֡������ �.�. 7
## by suwat


include("class.db.php");
class CheckDataError extends mysql_db{
	private $arr_pid = array(); // �����ʵ��˹�
	var $arr_error = array(); // �� error �ͧ������
	private $arr_level = array();// �������дѺ�Ѩ�غѹ
	private $arr_pos = array(); // �����ʵ��˹�
	private $graduate_id = "40"; // �����дѺ����֡�һ�ԭ�ҵ��
	private $arr_pgroup = array();
	private $__minage = 18; # ���ص���ش����Ѻ�Ҫ�����
	private $__maxage = 61;
	private $__mmdd = "10-01"; // ��͹������¹�����Ҫ���
	private $__minageG = 0; #���͹䢡�õ�Ǩ�ͺ�����Ҫ���
	private $__maxageG = 42; ## �����Ҫ����٧�ش
	private $__diffyy = 0; # �ŵ�ҧ�ͧ�����ѹ�������Ժѵ��Ҫ�������ѹ�ѧ��è�
	private $arr_vitaya = array(); // �������Է°ҹ�
	private $arr_sex = array("1"=>"���","2"=>"˭ԧ");// ��������
	private $arr_prename = array(); // �����ʵ��˹�
	var $__arr = array();
	
	
		
	
	## �ӹ�˹�Ҫ��� 
	private function GetPrenameCode(){
		$sql = "SELECT PN_CODE, prename_th FROM prename_th WHERE active='on'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_prename[$rs[PN_CODE]] = $rs[prename_th];
		}
		$this->SetResult();
		return $this->arr_prename;
	}
	
		###  loop �ҵ��˹觷���زԡ���֡�ҵ�ͧ����ӡ��һ�ԭ�ҵ��
	private function GetpidG(){
		
		$sql = "SELECT pid FROM `hr_addposition_now` where status_graduate_high='1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
			$this->arr_pid["{$rs[pid]}"] = "{$rs[pid]}";	
		}//end while($rs = $this->FetchRow($result)){
			$this->SetResult();
			return $this->arr_pid;
	}// end 	private function GetpidG(){
	
	### �ҵ��˹觻Ѩ�غѹ
	private function GetPositionR(){
			$sql = "SELECT pid,`position` FROM hr_addposition_now WHERE status_active='yes' ";
			$this->Query($this->db_master,$sql);
			while($rs = $this->FetchRow($this->__result)){
					$this->arr_pos["{$rs[pid]}"] = "{$rs[position]}";
			}
			$this->SetResult();
			return $this->arr_pos;
	}//end private function GetPositionR(){
	
	### �����дѺ
	private function GetRadubR(){
		$sql = "SELECT t1.level_id, t1.radub FROM hr_addradub AS t1 WHERE t1.active_now =  '1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_level["{$rs[level_id]}"] = "{$rs[radub]}";
		}
		$this->SetResult();
		return $this->arr_level;
	}//end private function GetRadubR(){
		
	### ���ʡ�������˹�
	private function GetPositionGroup(){
		$sql = "SELECT t1.positiongroupid, t1.positiongroup FROM hr_positiongroup AS t1 where t1.status_active='1'";	
		$this->Query($this->db_master,$sql);
		while($rs = $this->FetchRow($this->__result)){
				$this->arr_pgroup["{$rs[positiongroupid]}"] = "{$rs[positiongroup]}";
		}
		$this->SetResult();
		return $this->arr_pgroup;
	}
	### �ҵ��˹�
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
	
	#### ��Ǩ�ͺ����
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
	
	
	### ��Ǩ�ç���¹�������ѹ��Ѻࢵ
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
		
	### ��Ǩ�ͺ�ѧ�Ѵࢵ��蹷�����֡��
	private function GetSecnameFromSchool($schoolid){
		$sql = "SELECT t2.secname_short FROM allschool AS t1
Inner Join eduarea AS t2 ON t1.siteid = t2.secid where t1.id='$schoolid' and t1.activate_status='open'";	
		$this->Query($this->db_master,$sql);
		$rs = $this->FetchRow();
		$this->SetResult();
		return $rs[secname_short];
	}// end private function GetSecnameFromSchool($schoolid){
	
		
	#### �Ѻ�ӹǹ�����š���֡��	
	private function CheckGraduate($siteid,$idcard){
			$dbsite = "cmss_".$siteid;
			$sql = "SELECT COUNT(id) as num FROM graduate WHERE id='{$idcard}' GROUP BY id";
			$this->Query($dbsite,$sql);
			$rs = $this->FetchRow();
			$this->SetResult();
			return $rs[num];
	}
	
	## ��Ǩ�ͺ�ѧ�Թ��͹
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
	
	
### ��Ǩ�ͺ�Է°ҹз������ѹ��Ѻ���˹�����Է°ҹ�
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
		
		
### �����������Է°ҹ�Ѻ�Է°ҹ�
private function Getvitaya(){
	$sql = "SELECT runid as vitaya_id, vitayaname as vitaya FROM vitaya ";
	$this->Query($this->db_master,$sql);
	while($rs = $this->FetchRow($this->__result)){
			$this->arr_vitaya["{$rs[vitaya_id]}"] = "{$rs[vitaya]}";
	}//end 
	$this->SetResult();
	return $this->arr_vitaya;
}//end private function Getvitaya(){
	
### ��Ǩ�ͺ�������Ѩ�غѹ
private function GetAddress($siteid,$idcard){
	$dbsite = "cmss_".$siteid;
	$sql = "SELECT COUNT(gen_id) as num1 FROM  hr_addhistoryaddress WHERE gen_id='{$idcard}'";	
	$this->Query($dbsite,$sql);
	$rs = $this->FetchRow();
	$this->SetResult();
	return $rs[num1];
}

### ��Ǩ�ͺ�������ٻ�Ҿ
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
			$arrmsg[1] = "�ӹǹ�ٻ��к� cmss ���ç�Ѻ Checklist  ˹��¹Ѻ� Checklist �� {$numpic_checklist} �ٻ �к� cmss �� {$numpic_cmss} �ٻ";
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
			
			$this->GetpidG();### �����ʷ����˹�
			$this->GetRadubR(); # �����дѺ�Ѩ�غѹ
			$this->GetPositionR();# ���˹觻Ѩ�غѹ
			$this->GetPositionGroup();# ��§ҹ
			$this->Getvitaya();// �ʴ�������������Է°ҹ�
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
			

			
			$age = intval($this->GetAge($rs[birthday]));## ���ص��
			$age_gov = intval($this->GetAge($rs[begindate])); # �����Ѻ�Ҫ���
			$age_start =  intval($this->GetAge($rs[startdate])); # ���عѺ�ҡ�ѹ������Ѻ�Ҫ���
			$age_diff = $age_gov-$age_start; # �ŵ�ҧ�����ҧ�����Ҫ�������ѹ��觺�è�
			

			
			### ��Ǩ�ͺ�����ŷ����
			# �ٻ�Ҿ
			$arrpic = $this->CheckPic_kp7($rs[siteid],$rs[CZ_ID],$profile_id);
			if($arrpic[0] == "0"){
				$this->arr_error['A001'] = $arrpic[1];
				
			}
			
			# �������Ѩ�غѹ
			if($this->GetAddress($rs[siteid],$rs[CZ_ID]) < 1){
					$this->arr_error['A002'] = "����кط������Ѩ�غѹ";
			}
			if($rs[prename_th] == "" or $rs[name_th] == "" or $rs[surname_th] == ""){
					$this->arr_error['A003'] = "����к� �ӹ�˹�Ҫ��� ���� ��� ���� ���ʡ��";
			}
			
			
			
			
		####################  ��Ǩ�ͺ�زԡ���֡��
			## ��Ǩ�ͺ��úѹ�֡�����š���֡��
			if($this->CheckGraduate($rs[siteid],$rs[CZ_ID]) < 1){
				$this->arr_error['B001'] = "��辺��úѹ�֡�����š���֡��";
			}else{
		
			### ��Ǩ�ͺ����֡���繤����ҧ
			if($rs[education] == "" or $rs[graduate_level] == ""){
					$this->arr_error['B002'] = "����֡���٧�ش�繤����ҧ";
			}
			#### ��Ǩ�ͺ���˹觷�����֡������õ�ӡ��һ�ԭ�ҵ��
			if ((array_key_exists($rs[graduate_level], $this->arr_pid)) and $rs[graduate_level] < $this->graduate_id) {
					$this->arr_error['B003'] = "���˹� {$rs[position_now]}  ����֡������õ�ӡ��һ�ԭ�ҵ��";
			}
			### ��Ǩ�ͺ�زԡ���֡���繤����ҧ
			if($rs[degree_level] == ""){
					$this->arr_error['B004'] = "�زԡ���֡��������繤����ҧ";
			}
		}// end if($this->CheckGraduate($rs[siteid],$rs[CZ_ID]) < 1){
	################## end ��Ǩ�ͺ�زԡ���֡��
	
	## ��Ǩ�ͺ�дѺ
		if($rs[radub] == ""){
				$this->arr_error['R001'] = "�дѺ�繤����ҧ";
		}
	
		if($this->CheckPosMathRadub($rs[pid],$rs[level_id]) < 1){
				$this->arr_error['R002'] = "�дѺ�������ѹ��Ѻ���˹�  �дѺ��� {$rs[radub]} ���˹觤�� {$rs[position_now]} ";		
		}
		### �дѺ������дѺ�Ѩ�غѹ
		
		
		if(!(array_key_exists($rs[level_id],$this->arr_level))){
			$this->arr_error['R003'] = "�дѺ {$rs[radub]} ������дѺ�Ѩ�غѹ";
		}
		### �����дѺ�������ѹ��Ѻ�����дѺ
		if($this->arr_level[$rs[level_id]] != $rs[radub]){
				$this->arr_error['R004'] = "�����дѺ�������ѹ��Ѻ�����дѺ �дѺ {$rs[radub]} �ҡ�ԧ�ҡ�����дѺ���١��ͧ��� ".$this->arr_level[$rs[level_id]];
		}
		
	### ��Ǩ�ͺ���˹� ####################################
	if($rs[position_now] == ""){
		$this->arr_error['P001'] = "���˹觻Ѩ�غѹ�繤����ҧ";
	}
	
	if($this->arr_pos[$rs[pid]] != $rs[position_now]){
			$this->arr_error['P002'] = "���ʵ��˹��������ѹ��Ѻ���͵��˹�  {$rs[position_now]} �ҡ��ҧ�ԧ�ҡ���ʵ��˹觷��١��ͧ��� ".$this->arr_pos[$rs[pid]];
	}
	## ���ʵ��˹��������ѹ��Ѻ���ʡ�������˹�
	if(substr($rs[pid],0,1) != $rs[positiongroup]){
			$this->arr_error['P003'] = "���˹��������ѹ��Ѻ��§ҹ��§ҹ�Ѩ�غѹ��� ".$this->arr_pgroup["{$rs[positiongroup]}"]." �ҡ�ԧ������ʵ��˹���§ҹ���١��ͧ��� ".$this->arr_pgroup[substr($rs[pid],0,1)];
	}
	if($rs[noposition] == ""){
			$this->arr_error['P004'] = "�Ţ�����˹��繤����ҧ";
	}
	
	#### ��Ǩ�ͺ�ѹ��͹���Դ
	if($age < $this->__minage){
			$this->arr_error['D001'] = "�ѹ��͹���Դ���١��ͧ �ѹ��͹���Դ��� {$rs[birthday]} ";
	}
	### ��Ǩ�ͺ����
	if($age < $this->__minage and $age >  $this->__maxage){
			$this->arr_error['D002'] = "�ѹ��͹���Դ���١��ͧ����ͤӹǳ�������ػѨ�غѹ��ҡѺ  $age ��";
	}
	
	### ��Ǩ�ͺ�����Ҫ���
	if($age_gov < $this->__minageG){
			$this->arr_error['D003'] = "�ѹ�������Ժѵ��Ҫ������١��ͧ �ѹ�������Ժѵ��Ҫ��ä�� {$rs[begindate]} ";
	}
	
	## ��Ǩ�ͺ�����Ҫ��÷�������
	if($age_gov < $this->__minageG and $age_gov > $this->__maxageG){
			$this->arr_error['D004'] = "�ѹ�������Ժѵ��Ҫ������١��ͧ����ͤӹǳ���������Ҫ��ûѨ�غѹ��ҡѺ $age_gov ��";
	}
	
	# ��Ǩ�ͺ�ѹ��觺�è�
	if($age_start < $this->__minageG){
		$this->arr_error['D005'] = "�ѹ��觺�è����١��ͧ �ѹ��觺�è� ��� {$rs[begindate]} ";	
	}
	
	if($age_start < $this->__minageG and $age_start > $this->__maxageG){
			$this->arr_error['D006'] = "�ѹ��觺�è����١��ͧ����ͤӹǳ�����ѧ��è�������  $age_gov ��";
	}
	
	### �ŵ�ҧ�ͧ�ѹ�������Ժѵ��Ҫ�������ѹ��觺�è�
	if($age_diff != $this->__diffyy){
			$this->arr_error['D007'] = "�ѹ��觺�è������ѹ�������Ժѵ��Ҫ������١��ͧ �Ѩ�غѹ��ҧ�ѹ $age_diff ��";
	}
		
	### ��Ǩ�ͺ˹��§ҹ�ѧ�Ѵ 
	
	if($this->CheckSchoolMathSite($rs[CZ_ID]) < 1){
			$this->arr_error['E001'] = "�������ѧ�Ѵ�ç���¹�������ѹ��Ѻࢵ��鹷�����֡�� �ҡ��ҧ�ԧ��������ç���¹�Ѩ�غѹ�ѧ�Ѵ ʾ� ��� ".$this->GetSecnameFromSchool($rs[schoolid]);
	}
			
	if($this->CheckSalaryLevel($rs[level_id],$rs[salary]) < 1){
			$this->arr_error['S001'] = "�Թ��͹���١��ͧ �дѺ $rs[radub] ������Թ��͹ $rs[salary] 㹼ѧ�Թ��͹";
	}
	
	#### ���ͨ�ͺ�Է°ҹз���������ѹ��Ѻ���˹�����дѺ
	if($rs[vitaya] != "" and  $this->arr_vitaya[$rs[vitaya_id]] != $rs[vitaya]){
		$this->arr_error['V001'] = "�����������Է°ҹ��������ѹ��Ѻ�����Է°ҹ� �ҡ�ԧ��������Է°ҹЪ����Է°ҹФ�� ".$this->arr_vitaya[$rs[vitaya_id]]." ������Է°ҹФ�� {$rs[vitaya]}";
			
	}
	
	if($rs[vitaya] != ""){
		$arr_vitaya = $this->CheckVitayaMath($rs[vitaya_id],$rs[pid],$rs[level_id]);
		if($arr_vitaya['level_id'] == ""){
				$this->arr_error['V002'] = "�������Է°ҹ��������ѹ��Ѻ�дѺ  ".$this->arr_level[$rs[level_id]] ." ��������Է°ҹ� ".$this->arr_vitaya[$rs[vitaya_id]];
		}
		
		if($arr_vitaya['pid'] == ""){
				$this->arr_error['V003'] = "�������Է°ҹ��������ѹ��Ѻ���˹� ".$rs[position_now]." ��������Է°ҹ�  ".$this->arr_vitaya[$rs[vitaya_id]];
		}
			
	}
	
	
	### ��Ǩ�ͺ��������
	if($rs[sex] == ""){
			$this->arr_error['GN01'] = "����к���";
	}else{
			if($this->arr_sex[$rs[gender_id]] != $rs[sex]){
				$this->arr_error['GN02'] = "���������������ѹ��ѹ �������������ѹ��Ѻ Label ";
			}	
	}
	
	
		$this->SetResult();
		return $this->arr_error;
		
			
	}
		
}//end class CheckDataError{ 

### ������ҧ
/*$idcard = "3509900589319";
$profile_id = "9";

$obj = new CheckDataError();
$arr = $obj->CheckDataCmss($idcard,$profile_id);
echo "�ʴ���ͤ��� => <pre>";
print_r($arr);*/







	



?>