<?
$yy = "2547";
$db_name = "edubkk_userentry";
$dbnameuse = $db_name;
$db_system = "edubkk_system";
$dbtemp = "edubkk_checklist";
##  config  ��õ�Ǩ�ͺ��úѹ�֡�Թ��͹�֧���ش����
//$salary_date = (date("Y")+543);
$salary_date = "2552";
$con_date = "2552-10-01";
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$arrstaff = array("��ѡ�ҹ���Ǥ���","��ѡ�ҹ��Ш�","Subcontract");
####  �ѧ��ѹ��Ǩ�ͺ ������
####  ��Ǩ�ͺ����
function CheckName($get_siteid,$get_idcard){
		$db_site = STR_PREFIX_DB.$get_siteid;
		$sql = "SELECT count(id) as num1  FROM general  WHERE (prename_th='' or name_th='' or surname_th='' or prename_id='') AND idcard='$get_idcard'";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A002";
		}else{
				return "";	
		}
}//end function CheckName($get_siteid,$get_idcard){
	
###  ��Ǩ�ͺ�����Եԡ������¹����
function CheckHisName($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(gen_id) as num1  FROM hr_addhistoryname  WHERE (prename_th='' or name_th='' or surname_th='') AND gen_id='$get_idcard'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A003";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckHisName($get_siteid,$get_idcard){
	
####  ��Ǩ�ͺ�ӹ�˹�Ҫ�������ѹ��Ѻ��
function CheckPrenameMathSex($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT sum(if($db_site.general.sex!= ".DB_MASTER.".prename_th.sex,1,0)) as num1 FROM $db_site.general Inner Join  ".DB_MASTER.".prename_th ON $db_site.general.prename_id= ".DB_MASTER.".prename_th.PN_CODE  WHERE $db_site.general.idcard =  '$get_idcard'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A004";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckPrenameMathSex($get_siteid,$get_idcard){
	
###   ʶҹС���ʴ��Ū���� �.�.7 ��ͧ�� 1 ����ҹ��
function CheckActiveKp7($get_siteid,$get_idcard){
		$db_site = STR_PREFIX_DB.$get_siteid;
		$sql = "SELECT if(count(gen_id)!=1,1,0) as num1  FROM `hr_addhistoryname` where gen_id='$get_idcard' AND  kp7_active=1 group by gen_id";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A005";
		}else{
				return "";	
		}//end if($rs[num1] == 1){

}//end 

#############  ���ػѨغѹ��ͧ�����¡��� 18 �� �������Թ 61 ��
function CheckAgePerson($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  AND (!(ROUND(TIMESTAMPDIFF(MONTH,birthday, concat(YEAR(now())+543,'-09-30')) /12) BETWEEN '18' AND '61')) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A006";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckAgePerson(){

################  �ѹ��͹���Դ��ͧ����ҡ�����ѹ�������Ժѵ��Ҫ�����е�ͧ��ҧ�ѹ 18 �� ����
function CheckBegindatePerson($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1 FROM  general where idcard='$get_idcard'  AND (((ROUND(TIMESTAMPDIFF(MONTH,birthday, concat(YEAR(now())+543,'-09-30')) /12))- (ROUND(TIMESTAMPDIFF(MONTH,begindate, concat(YEAR(now())+543,'-09-30')) /12)))< 18 ) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A007";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckBegindatePerson($get_siteid,$get_idcard){

#############  �ѹ��͹���Դ��ͧ����繤����ҧ
function CheckBirthdayNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1 FROM  general where idcard='$get_idcard'  and (birthday = '' or birthday IS  NULL)  group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A008";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//endfunction CheckBirthdayNull($get_siteid,$get_idcard){
	
####  ����ࢵ��鹷�����֡�ҵ�ͧ����繤����ҧ

function CheckSiteNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (siteid='' or siteid IS NULL)  group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A009";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//endfunction CheckBirthdayNull($get_siteid,$get_idcard){
	
### �����ç���¹��ͧ����繤����ҧ

function CheckSchoolNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (schoolid='' or schoolid IS NULL)  group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A010";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckSchoolNull($get_siteid,$get_idcard){
	
#### �ѹ�������Ժѵ��Ҫ��õ�ͧ����繤����ҧ

function CheckBegindateNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (begindate='' or begindate IS NULL)  group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A011";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckSchoolNull($get_siteid,$get_idcard){
	
###  �дѺ��������дѺ��ͧ����繤����ҧ
function CheckRadubNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and ((radub='' or radub IS NULL) or (level_id='' or level_id IS NULL)) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A012";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckRadubNull($get_siteid,$get_idcard){


###  ����������ȵ�ͧ����繤����ҧ
function CheckSexNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and ((sex='' or sex IS NULL) or (gender_id='' or gender_id IS NULL)) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A013";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckSexNull($get_siteid,$get_idcard){
	
###  ����֡�ҵ�ͧ����繤����ҧ
function CheckGraduateNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(CZ_ID) as num1  FROM  view_general where CZ_ID='$get_idcard'  and (education='' or education IS NULL) group by CZ_ID";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A014";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckGraduateNull($get_siteid,$get_idcard){
	
###���˹觻Ѩ�غѹ������ʵ��˹觻Ѩ�غѹ��ͧ����繤����ҧ
function CheckPositionNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (position_now='' or position_now IS NULL or pid='' or pid IS NULL) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A015";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckPositionNull($get_siteid,$get_idcard){
	
###  �Թ��͹㹵��ҧ general ��ͧ����繤����ҧ
function CheckGsalaryNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (salary='' or salary IS NULL or  salary < 4500) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A016";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckGsalaryNull($get_siteid,$get_idcard){
	
	####�Ţ�����˹�� general ��ͧ����繤����ҧ
	
function CheckNopositionNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(idcard) as num1  FROM  general where idcard='$get_idcard'  and (noposition='' or noposition IS NULL) group by idcard";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 1){
				return "A018";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckNopositionNull($get_siteid,$get_idcard){
	
#### ��÷Ѵ�����š���֡�ҵ�ͧ����繤����ҧ

function CheckGraduate1Null($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT COUNT(id)  AS num1 FROM graduate WHERE id='$get_idcard' group by id";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] == 0){
				return "B001";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckGraduate1Null($get_siteid,$get_idcard){


####  �����дѺ����֡�ҵ�ͧ����繤����ҧ

function CheckGraduateLevelNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM graduate  WHERE id='$get_idcard' AND (graduate.graduate_level = '' OR graduate.graduate_level IS  NULL)";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				return "B002";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckGraduateLevelNull($get_siteid,$get_idcard){
	
####  ����֡���дѺ��ԭҵ�բ��仵�ͧ�к��زԡ���֡��
function CheckGradUpNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM graduate  WHERE (graduate.id='$get_idcard' AND graduate.graduate_level >= 40 AND type_graduate NOT LIKE 'room%') AND (degree_level = '' or  degree_level IS NULL)";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				return "B003";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckGradUpNull($get_siteid,$get_idcard){
	
#####  ��úѹ�֡�Թ��͹��ͧ�繢����Ţͧ�ѹ���Ѩ�غѹ

function  CheckCurentSalary($get_siteid,$get_idcard){
	global $con_date;
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM salary where id='$get_idcard'  and date >= '$con_date'";
	$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] < 1){
				return "C001";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function  CheckCurentSalary(){
	
############ �Ţ�����˹觵����վ.�. 2547 �繵�仵�ͧ����繤���ҧ
function CheckSalaryNoposition($get_siteid,$get_idcard){
	global $yy;
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM salary where id='$get_idcard'  and date LIKE '$yy%' and (noposition='' OR noposition IS NULL)";
	$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				return "C003";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
		
}//end function CheckSalaryNoposition($get_siteid,$get_idcard){
	
############ ���͵��˹�������ʵ��˹� ��ͧ��� 2547 �繵�仵�ͧ����繤����ҧ
function CheckSalaryPosition($get_siteid,$get_idcard){
	global $yy;
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM salary where id='$get_idcard'  and date LIKE '$yy%' and (`position`='' OR `position` IS NULL or position_id='' or position_id IS NULL)";
	$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				return "C004";
		}else{
				return "";	
		}//end if($rs[num1] == 1){
}//end function CheckSalaryPosition($get_siteid,$get_idcard){
	
##########  �����дѺ��������дѺ������ 2547 �繵�仵�ͧ����繤����ҧ
function CheckSalaryRadub($get_siteid,$get_idcard){
	global $yy;
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT count(id) as num1 FROM salary where id='$get_idcard'  and date LIKE '$yy%' and (`radub`='' OR `radub` IS NULL or level_id='' or level_id IS NULL)";
	$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				return "C005";
		}else{
				return "";	
		}//end if($rs[num1] == 1){		
}//end function CheckSalaryRadub($get_siteid,$get_idcard){
	
	
###  �ѧ���蹵�Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹
function CheckKeySalary($get_siteid,$get_idcard){
		global $yy;
		$dbnamemaster = "edubkk_master";
		$dbsite = STR_PREFIX_DB.$get_siteid;
		
		$sql_salary = "SELECT * FROM salary WHERE id='$get_idcard' AND year(date) > $yy ORDER BY date ASC";
		$result_salary = mysql_db_query($dbsite,$sql_salary);
		$IntA=0;
		//$salary_msg = "";
		while($rs_s = mysql_fetch_assoc($result_salary)){
		$sql_check = "SELECT
tbl_salary_level.money
FROM
tbl_salary_level
WHERE
 (money ='$rs_s[salary]' or money0_5='$rs_s[salary]' or money1='$rs_s[salary]' or money1_5='$rs_s[salary]')";
		$result_check = mysql_db_query($dbnamemaster,$sql_check);
		$rs_c = mysql_fetch_assoc($result_check);
		//echo "$rs_s[salary]  :: $rs_s[date] :: ".$rs_c[money]."<br>";
			if($rs_c[money] == ""){
					$IntA += 1;
					$salary_msg .= " �������Թ��͹��÷Ѵ��� $rs_s[runno]  �ѹ���  $rs_s[date]  �Թ��͹ $rs_s[salary]<br>";
			}
		}//end while($rs_s = mysql_fetch_assoc($result_salary)){
			$arr_check['NUM'] = $IntA;
			$arr_check['salary_error_msg'] = $salary_msg;
	return $arr_check;
}//end 	function CheckKeySalary(){
## end �ѧ���蹵�Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹

####   �Է°ҹе�ͧ����ѹ��Ѻ���˹�
function CheckPositionMathVitaya($get_siteid,$get_idcard){
	global $dbnamemaster;
	$db_site = STR_PREFIX_DB.$get_siteid;
	
	$sql_main = "SELECT * FROM view_general WHERE CZ_ID='$get_idcard' AND position_now NOT LIKE '%�����á���֡��%'";
	$result_main = mysql_db_query($db_site,$sql_main);
	$rsm = mysql_fetch_assoc($result_main);
	if($rsm[vitaya] != ""){
	$sql = "SELECT  COUNT(hr_addposition_now.pid) AS num1
FROM
hr_addposition_now
Inner Join position_math_vitaya ON hr_addposition_now.runid = position_math_vitaya.position_id
Inner Join vitaya ON position_math_vitaya.vitaya_id = vitaya.runid
WHERE
hr_addposition_now.pid =  '$rsm[pid]' AND
vitaya.vitayaname =  '$rsm[vitaya]' ";

//echo $dbnamemaster." :: ".$sql."<br>";
	$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] < 1){
				return "A019";
		}else{
				return "";	
		}//end if($rs[num1] == 1){		
}//end 	if($rsm[vitaya] != ""){
}//end 

####  ��Ǩ�ͺ�������Է°ҹе�ͧ����繤����ҧ
function CheckVitayaNull($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	$sql = "SELECT COUNT(CZ_ID) AS num1 FROM view_general WHERE (vitaya='' or vitaya IS NULL or vitaya_id ='' or vitaya_id IS NULL) and pid NOT LIKE '5%' AND position_now NOT LIKE '%���˹�ҷ��%�����á���֡��%' AND (radub LIKE '��.2' or radub LIKE '��.3' or radub LIKE '��.4' or radub LIKE '��.5') and CZ_ID='$get_idcard'";
	//echo $sql."<br>";
	//echo $sql."<br>";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[num1]  == 1){
				return "A020";
		}else{
				return "";	
		}//end if($rs[num1] == 1){		
		
}//end function CheckVitayaNull($get_siteid,$get_idcard){
	
	
##### ��Ǩ�ͺ�Թ��͹� general ��ͧ����繤����ҧ
function CheckGeneralSalary($get_siteid,$get_idcard){
	$db_site = STR_PREFIX_DB.$get_siteid;
	
	$sql = "SELECT
$db_site.view_general.CZ_ID
FROM
$db_site.view_general
Inner Join  ".DB_MASTER.".tbl_salary_level ON $db_site.view_general.salary =  ".DB_MASTER.".tbl_salary_level.money 
OR $db_site.view_general.salary =  ".DB_MASTER.".tbl_salary_level.money0_5 OR $db_site.view_general.salary =  ".DB_MASTER.".tbl_salary_level.money1 
OR $db_site.view_general.salary =  ".DB_MASTER.".tbl_salary_level.money1_5
where view_general.CZ_ID ='$get_idcard'  and salary > 4000 group by CZ_ID";

	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);	
	if($rs[CZ_ID] == ""){
			return "A017";
	}else{
			return "";	
	}
}



####################  funcntion  ��Ǩ�ͺ���������������
function CheckPersonData($get_siteid,$get_idcard){
	$id = $get_idcard;
	####  ��Ǩ�ͺ�Ţ�ѵ�
	if(!Script_checkID($get_idcard)){
		$arr[$id]['A001'] = "A001"; 
	}
	### end ��Ǩ�ͺ�Ţ�ѵ�
	####  ��Ǩ�ͺ����
	if(CheckName($get_siteid,$get_idcard) != ""){
		$arr[$id]['A002'] = CheckName($get_siteid,$get_idcard);	
	}
	####### ��Ǩ�ͺ�����Եԡ������¹����
	if(CheckHisName($get_siteid,$get_idcard) != ""){
		$arr[$id]['A003'] = CheckHisName($get_siteid,$get_idcard);
	}
	#############  ��Ǩ�ͺ�ӹ�˹�Ҫ�������ѹ��Ѻ��
	if(CheckPrenameMathSex($get_siteid,$get_idcard) != ""){
		$arr[$id]['A004'] = CheckPrenameMathSex($get_siteid,$get_idcard);		
	}
	###########   ʶҹС���ʴ��Ū���� �.�.7 ��ͧ�� 1 ����ҹ��
	if(CheckActiveKp7($get_siteid,$get_idcard) != ""){
		$arr[$id]['A005'] = CheckActiveKp7($get_siteid,$get_idcard);
	}
	#############  ���ػѨغѹ��ͧ�����¡��� 18 �� �������Թ 61 �
	if(CheckAgePerson($get_siteid,$get_idcard) != ""){
		$arr[$id]['A006'] = CheckAgePerson($get_siteid,$get_idcard);
	}
	##########  �ѹ��͹���Դ��ͧ����ҡ�����ѹ�������Ժѵ��Ҫ�����е�ͧ��ҧ�ѹ 18 �� ����
	if(CheckBegindatePerson($get_siteid,$get_idcard) != ""){
		$arr[$id]['A007'] = CheckBegindatePerson($get_siteid,$get_idcard);
	}
	###   �ѹ��͹���Դ��ͧ����繤����ҧ
	if(CheckBirthdayNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A008'] = CheckBirthdayNull($get_siteid,$get_idcard);
	}
	#######����ࢵ��鹷�����֡�ҵ�ͧ����繤����ҧ
	if(CheckSiteNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A009'] = CheckSiteNull($get_siteid,$get_idcard);
	}
	###  �����ç���¹��ͧ����繤����ҧ
	if(CheckSchoolNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A010'] = CheckSchoolNull($get_siteid,$get_idcard);
	}
	######  �ѹ�������Ժѵ��Ҫ��õ�ͧ����繤����ҧ
	if(CheckBegindateNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A011'] = CheckBegindateNull($get_siteid,$get_idcard);
	}
	######  �дѺ��������дѺ��ͧ����繤����ҧ
	if(CheckRadubNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A012'] = CheckRadubNull($get_siteid,$get_idcard);	
	}
	### ����������ȵ�ͧ����繤����ҧ
	if(CheckSexNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A013'] = CheckSexNull($get_siteid,$get_idcard);
	}
	######  ����֡�ҵ�ͧ����繤����ҧ
	if(CheckGraduateNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A014'] = CheckGraduateNull($get_siteid,$get_idcard);
	}
	#######  ���˹觻Ѩ�غѹ������ʵ��˹觻Ѩ�غѹ��ͧ����繤����ҧ
	if(CheckPositionNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A015'] = CheckPositionNull($get_siteid,$get_idcard);
	}
	#####  �Թ��͹㹵��ҧ general ��ͧ����繤����ҧ
	if(CheckGsalaryNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A016'] = CheckGsalaryNull($get_siteid,$get_idcard);	
	}
	#####  �Ţ�����˹�� general ��ͧ����繤����ҧ
	if(CheckNopositionNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A018'] = CheckNopositionNull($get_siteid,$get_idcard);
	}
	####### ��÷Ѵ�����š���֡�ҵ�ͧ����繤����ҧ
	if(CheckGraduate1Null($get_siteid,$get_idcard) != ""){
		$arr[$id]['B001'] = CheckGraduate1Null($get_siteid,$get_idcard);	
	}
	#####  �����дѺ����֡�ҵ�ͧ����繤����ҧ
	if(CheckGraduateLevelNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['B002'] = CheckGraduateLevelNull($get_siteid,$get_idcard);
	}
	#####  ����֡���дѺ��ԭҵ�բ��仵�ͧ�к��زԡ���֡��
	if(CheckGradUpNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['B003'] = CheckGradUpNull($get_siteid,$get_idcard);	
	}
	#####  ��úѹ�֡�Թ��͹��ͧ�繢����Ţͧ�ѹ���Ѩ�غѹ 
	if(CheckCurentSalary($get_siteid,$get_idcard) != ""){
		$arr[$id]['C001'] = CheckCurentSalary($get_siteid,$get_idcard);
	}
	#####  �Ţ�����˹觵����վ.�. 2547 �繵�仵�ͧ����繤���ҧ
	if(CheckSalaryNoposition($get_siteid,$get_idcard) != ""){
		$arr[$id]['C003'] = CheckSalaryNoposition($get_siteid,$get_idcard);
	}
	#####  ���͵��˹�������ʵ��˹� ��ͧ��� 2547 �繵�仵�ͧ����繤����ҧ
	if(CheckSalaryPosition($get_siteid,$get_idcard) != ""){
		$arr[$id]['C004'] = CheckSalaryPosition($get_siteid,$get_idcard);
	}
	#####  �����дѺ��������дѺ������ 2547 �繵�仵�ͧ����繤����ҧ
	if(CheckSalaryRadub($get_siteid,$get_idcard) != ""){
		$arr[$id]['C005'] = CheckSalaryRadub($get_siteid,$get_idcard);
	}
	#####  ��Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹
	$csalary = CheckKeySalary($get_siteid,$get_idcard);
	if($csalary['NUM'] > 0){
			$arr[$id]['A021'] = $csalary['NUM'];
			$arr[$id]['A022'] = $csalary['salary_error_msg'] ;
	}
	###########�Է°ҹе�ͧ����ѹ��Ѻ���˹�
	if(CheckPositionMathVitaya($get_siteid,$get_idcard) != ""){
		$arr[$id]['A019'] = CheckPositionMathVitaya($get_siteid,$get_idcard);
	}
	######### ��Ǩ�ͺ�������Է°ҹе�ͧ����繤����ҧ
	if(CheckVitayaNull($get_siteid,$get_idcard) != ""){
		$arr[$id]['A020'] = CheckVitayaNull($get_siteid,$get_idcard);
	}
	##########  ��Ǩ�ͺ�Թ��͹� general ��ͧ�ç����觡����û���ͧ
	if(CheckGeneralSalary($get_siteid,$get_idcard) != ""){
		$arr[$id]['A017'] = CheckGeneralSalary($get_siteid,$get_idcard);
	}
	
return $arr;
	
}//end function CheckPersonData($get_siteid,$get_idcard){





	



?>