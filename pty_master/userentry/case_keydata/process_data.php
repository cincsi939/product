<?php
### function �Ӣ����Ũҡ excel 任����żŵ��
include("../../config/conndb_nonsession.inc.php");
include("class.process.php");
$gid = 5;// ���ʡ��������á�ͧ 38 �
$gid1 = 6;


if($action == "process"){
	
	$obj_process = new ProcessImport(); // ��Ǩ�ͺ��û�����
	$obj_data = new GetDataMaster();// �ʴ����������ѡ� master
	
	$obj_salary=new salary_level(); // ��Ǩ�ͺ�����żѧ�Թ��͹
	$radub = $obj_data->GetRadub("91254701");
	
	
	$x=$obj_salary->check("$radub",'18690','2011-10-01');
	
	echo "radub => $radub :: chsalary => $x";
	die();
	
	
	$arr_sex = $obj_process->GetSexFromPrename();// ���Ȩҡ�ӹ�˹�Ҫ���
	
	$sql ="SELECT * FROM site_process_data WHERE status_process='0' ";
	$result = mysql_db_query($db_command_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$siteid = $rs[siteid];
		## ����������ش�������
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
				$siteid = $rsd[siteid]; // ����ࢵ
				$schoolid = $rsd[schoolname]; // �����ç���¹
				$schoolname = $obj_data->GetSchool($rsd[schoolname]);
				$noposition = $rsd[no_position];
				$radub = $obj_data->GetRadub($rsd[level_before]);
				$level_id = $rsd[level_before];
				$position_now = $obj_data->GetPosition($rsd[position]); // ���͵��˹�
				$pid = $rsd[position];// ���ʵ��˹�
				
				$prename_th = $rsd[prename];
				$name_th = $rsd[name];
				$surname_th = $rsd[surname];
		
				$sub_pid = substr($rsd[position],0,1); // �����ʵ���á���͵�Ǩ�ͺ����繢����� 38 �.������
				$positiongroup = $sub_pid;
				if($rsd[education] != "none"){
					$education = $rsd[education];
					$education_name = $obj_data->GetHighgrade($education);
				}else{
					$education = "";
					$education_name = "";
				}
				
		
		
			## �Ң����� profile ����ش
			$profile_id = $obj_process->GetLastProfile($rs[siteid]);
			
			##  �Ң������Թ��͹
			if($sub_pid == $gid or $sub_pid == $gid1){ # �繺ؤ�ҡ� 38 �
				if($rsd[payment_2] > 0){
					$salary = $rsd[salary_after]-$rsd[payment_2];// �Թ��͹����ѡ��ҵͺ᷹�����
				}else{
					$salary = $rsd[salary_after];
				}//end if($rsd[payment_2] > 0){
			}else{
					$salary = $rsd[salary_after]	;
			}//end if($sub_pid == $gid or $sub_pid == $gid1){ 
			########### end �������Թ��͹
			### �������ѹ��͹���Դ
			if($rsd[birthday] == 'none' or $rsd[begindate] == 'none'){
					$arr_d = $obj_process->GetBdate($rsd[idcard],$profile_id);
			}// end end if($rsd[birthday])
				### �������ѹ�Դ
					if($rsd[birthday] == 'none'){
						$birthday = $arr_d['birthday']; 
					}else{
						$birthday = $rsd[birthday];	
					}
				### �������ѹ�������Ժѵ��Ҫ���
					if($rsd[begindate] == 'none'){
						$begindate = $arr_d['begindate']; 
					}else{
						$begindate = $rsd[begindate];	
					}
						
					### ��������
					if($rsd[sex] == "none" ){
							$sex = $arr_sex[$rsd[prename_th]]['sex'];
					}else{
							$sex = $rsd[sex];	
					}
					### ������
					if($rsd[gender_id] == "none"){
							$gender_id = $arr_sex[$rsd[prename_th]]['gender_id'];
					}else{
							$gender_id = $rsd[gender_id];	
					}
					### ���ʤӹ�˹�Ҫ���
					$prename_id = $arr_sex[$rsd[prename_th]]['prename_id'];
					
					### �Ң������Է°ҹ�
					if($rsd[vitaya] != "none"){
							$vitaya = $obj_data->GetVitaya($rsd[vitaya]);
							$vitaya_id = $rsd[vitaya];
					}else{
							$vitaya = "";
							$vitaya_id = "";
					}
					
					## �ѹ����Թ��͹
					$date_salary = $rsd['date_create']; // �.�.
					$dateposition_now = $obj_process->ConvDateYY($date_salary); // �ѹ����Թ��͹ �.�.
					
					
				#### ��Ǩ�ͺ �����ç���¹��ͧ����ѹ�Ѻࢵ
				$checkmathschool = $obj_process->SiteMathSchool($schoolid,$siteid); 
				###  ��Ǩ�ͺ�Թ��͹�ç����ѧ
				$checksalary =$obj_salary->check("$radub","$salary","$date_salary");
				## ��Ǩ�ͺ���˹�����ѹ��Ѻ�дѺ
				$checkpositon_radub = $obj_process->PositionMathRadub($position_now,$radub);
				
				### ��Ǩ�ͺ�Է°ҹз������ѹ��Ѻ���˹�
				if($vitaya != ""){
						$checkvitaya = $obj_process->PositionMathVitaya($position_now,$vitaya);
				}else{
						$checkvitaya = "1";		
				}
				
				if($checkmathschool > 0){ // �����������ç���¹����ѹ��Ѻࢵ
				### ��Ǩ�ͺ����բ�����������к� cmss �����ѧ
				$numcmss = $obj_process->CheckDataCmss($idcard);
				## �ҡ����բ������ cmss
				if($numcmss < 1){
						$obj_process->InsertDataGeneral($idcard,$siteid,$schoolid,$birthday,$prename_th,$name_th,$surname_th,$begindate,$radub,$level_id,$sex,$gender_id,$position_now,$pid,$dateposition_now,$salary,$positiongroup,$vitaya,$vitaya_id,$noposition);
						$type_action = "insert"; // ������������
				}else{
						$type_action = "update";	
				}//end if($numcmss < 1){
				
				### ��Ǩ�ͺ���ͺѹ�֡������� temp ����������ش
				$numlastdata = $obj_process->CheckDataLast($idcard);// �Ң���������ش
				if($numlastdata < 1){
						$obj_process->InsertViewGeneralLastData($idcard,$siteid,$prename_th,$name_th,$surname_th,$education,$graduate_level,$degree_level,$radub,$level_id,$position_now,$pid,$schoolid,$salary,$vitaya,$vitaya_id,$positiongroup,$schoolname,$dateposition_now,$noposition,$birthday,$begindate,$sex,$genera_id);
				}// end if($numlastdata < 1){
					
				
				
				### ��Ǩ�ͺ�ѹ�֡������� ʹ�  log salary
				$status_import = 0;	
				$numlog_salary = $obj_process->CheckLogCheckSalary($idcard);
				if($numlog_salary < 1){
						$obj_process->InsertLogCheckSalary($idcard,$siteid,$name_th,$surname_th,$radub,$level_id,$position_now,$pid,$education,$education_name,$salary,$dateposition_now);
						$status_import = 1;				
				}// end if($numlog_salary < 1){
				
				
				#### ��Ǩ�ͺ������� checklist
				$num_checklist = $obj_process->CheckDataCheckList($idcard,$profile_id);
				if($num_checklist < 1){
						$obj_process->InsertDataChecklist($idcard,$profile_id,$siteid,$prename_th,$name_th,$surname_th,$birthday,$begindate,$position_now,$schoolid,$sex,"1","1","YES");
				}
			
		}//end  if($checkmathschool > 0){ // �����������ç���¹����ѹ��Ѻࢵ
		
		
		### �ѹ�֡������� log ��ù���Ң�����
		$obj_process->SaveLogProcess($idcard,$siteid,$schoolid,$checkmathschool,$prename_th,$name_th,$surname_th,$position_now,$pid,$radub,$level_id,$checkpositon_radub,$vitaya,$vitaya_id,$checkvitaya,$noposition,$rsd[salary_before],$salary,$checksalary,$rsd[education],$rsd[degree],$birthday,$begindate,$rsd[sex],$rsd[gender_id],$status_import,$type_action);
		
		
		
			
	}// end while($rsd = mysql_db_query($result_data)){
		
		
		
			
	}//end while($rs = mysql_fetch_assoc($result)){

}// end if($action == "process"){

echo "Done...";
?>