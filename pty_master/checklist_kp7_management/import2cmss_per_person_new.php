<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("../../common/common_competency.inc.php");
include("class/class.compare_data.php");

if($_SESSION['session_username'] == ""){
	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
	header("Location: login.php");
	die;
}
####  �����ż���¡��
### ���ͺ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ���ͺ
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//require_once("../../common/preloading.php");
	//echo "saddd";die;
		$dbsite = "cmss_".$xsiteid;
		AlterField($dbsite,"general_pic","img_owner");// ��Ǩ�ͺ���ͷ��зӡ�û�Ѻ�ç���ҧ���ҧ general_pic
		$dateposition_now = SwDateT($dateposition_now);
		
		$arrsitecon = GetSiteContinute();// ����ࢵ������ͧ
		$last_id = InsertLogImpChecklistToCmss($xsiteid,$_SESSION['session_staffid']); // log ��ù���Ң���������ش
		
	## �ѹ�֡��������¡�â����ŷ��й�����к�
	$sql_status_field = "REPLACE INTO tbl_status_field_import(secid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_import_data)VALUES('$xsiteid','$Fprename_th','$Fname_th','$Fsurname_th','$Fbirthday','$Fbegindate','$Fposition_now','$Fschoolid','$status_data')";
@mysql_db_query($dbname_temp,$sql_status_field);
	## end �ѹ�֡��������¡�â����ŷ��й�����к�
	
	if(count($arr_id) > 0){ // �����੾���Ţ�ѵ÷�����͡��ºؤŷ��зӡ�ä��������
		foreach($arr_id as $keyid => $valid){
		$sql_upstatus = "DELETE FROM   tbl_check_data  WHERE idcard='$valid' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_upstatus);
	
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND idcard='$valid' AND profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			## �������кǹ��ùӢ������������к� cmss
				$schoolname = show_school($rs[schoolid]);
					if($rs[page_num] != $rs[page_upload] and $rs[page_upload] > 0){
							$status_file_scan = "0";
					}else{
							$status_file_scan = "1";	
					}

				if(CheckDataOldYear($rs[idcard]) > 0 or CheckMonitorKey($rs[idcard]) > 0){
						$status_data_old = 1; // �����ࢵ���
				}else{
						$status_data_old = 0; // ����������ࢵ���
				}//end if(CheckDataOldYear($rs[idcard]) > 0){
			####  ��Ǩ�ͺ�Ţ�ѵû�ЪҪ�
			if(!Check_IDCard($rs[idcard])){
					$idcard_structure = 0; // �Ţ�ѵ����١��ͧ��������û���ͧ
			}else{
					$idcard_structure = 1;	 //  �Ţ�ѵö١��ͧ��������û���ͧ
			}//end 	if(!Check_IDCard($rs[idcard])){
				
						#####  ��Ǩ�ͺ�����ū����к� cmss ��͹
			$arrid = CheckReplaceCmss($rs[idcard],$rs[siteid]);
			if($arrid[0] == "1"){ // �óբ����ŷ�����ҫ�ӡѺ��������к� cmss ������������Ţͧࢵ���
				$status_id_replace = 1;
				$siteid_replace = $arrid[1];
				$sql_update_tblkp7 = "UPDATE tbl_checklist_kp7 SET status_id_replace='$status_id_replace',siteid_replace='$siteid_replace' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
				mysql_db_query($dbname_temp,$sql_update_tblkp7);
			}else{
				$status_id_replace = $rs[status_id_replace];
				$siteid_replace = $rs[siteid_replace];
			}//end if($arrid[0] == "1"){ // �óբ����ŷ�����ҫ�ӡѺ��������к� cmss ������������Ţͧࢵ���
	
				//echo $status_id_replace ." :: ".$siteid_replace."<br>";
				
				
						###  log ��ù���Ң����� #####
				if(array_key_exists("$siteid_replace",$arrsitecon)){
				   	$status_replace_sitecon = "1";
				}else{
					$status_replace_sitecon = "0";	
				}// end if(array_key_exists("$siteid_replace",$arrsitecon)){

		
		 		InsertLogImpDetail($last_id,$rs[idcard],$rs[siteid],$profile_id,$rs[prename_th],$rs[name_th],$rs[surname_th],$rs[schoolid],$rs[position_now],$siteid_replace,$status_replace_sitecon);

				

			if($rs[status_id_replace] == "1"){ // �óշ����������к� checklist 仫�ӡѺࢵ���㹰ҹ cmss
				## ��Ǩ�ͺ����繢�������Ҩҡ�ç��ûշ������
					if(CheckDataTable($rs[idcard],$profile_id) > 0){ // �ó���� tbl_check_data ��������
					$sql_insert = "UPDATE tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='REPLACE_ID',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id' WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
					}else{
					$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='REPLACE_ID',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id'";
					}// if(CheckDataTable($rs[idcard]) > 0){
					mysql_db_query($dbname_temp,$sql_insert);
			
			}else{// �óբ���������ӡѺࢵ���
				if(CheckDataTable($rs[idcard],$profile_id) > 0){ // �ó���� tbl_check_data ��������
				$sql_insert = "UPDATE tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',  begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace',status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id'  WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
				}else{
				$sql_insert = "INSERT INTO tbl_check_data SET sex='$rs[sex]',prename_th='$rs[prename_th]', name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]', idcard='$rs[idcard]', begindate='$rs[begindate]', position_now='$rs[position_now]',dateposition_now='$dateposition_now',schoolname='$schoolname',schoolid='$rs[schoolid]',secid='$rs[siteid]',status_compare='OK',status_file_scan='$status_file_scan',status_id_replace='$status_id_replace',siteid_replace='$siteid_replace', status_data_old='$status_data_old',idcard_structure='$idcard_structure',profile_id='$profile_id' ";
				}//end 	if(CheckDataTable($rs[idcard]) > 0){ 
				//echo "sql :: ".$sql_insert."<br>";
				mysql_db_query($dbname_temp,$sql_insert);
			}//if($rs[status_id_replace] == "1"){
			##  end �������кǹ��ùӢ������������к� cmss
		}//end while($rs = mysql_fetch_assoc($result)){	
		
		//echo $sql_insert;die;
	}//end 	foreach($arr_id as $keyid => $valid){
}else{
		echo "<script>alert('��辺�����ŷ���ҹ���͡');location.href='import2cmss_per_person.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1&lv=$lv&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;	
}//end if(count($arr_id) > 0){ // �����੾���Ţ�ѵ÷�����͡��ºؤŷ��зӡ�ä��������
	
		//echo "����ش��ùӢ��������";die;
### �ӡ�ùӢ����Ũҡ edubkk_checklist ������ҹ Cmss#########################################################
//echo "���ѧ��Ѻ��ا�����";die;
#$conidcard = "and idcard='4359900002229'";
$arrField = FieldProtectionImport(); // ��Ŵ�����㹡�õ�Ǩ�ͺ�����š�͹������к� cmss
CleanPositionChecklistNoMath($xsiteid,$profile_id);// ��ҧ�����ŵ��˹觷���������ѹ��Ѻ��������к�
#$sql = "SELECT * FROM tbl_check_data WHERE secid='$xsiteid' AND status_tranfer_data='0' AND idcard_structure='1' AND profile_id='$profile_id' $conidcard  ";

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
$dbsite = "cmss_".$rs[secid];
#$check_retire = CheckRetire($rs[idcard]);	 // ��Ǩ�ͺ������³�����Ҫ��������
$check_retire = 0;
if($check_retire > 0){ // �ʴ�����ա�����³�����Ҫ�����������������

		$sql_upch = "UPDATE tbl_check_data SET status_tranfer_data='2' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' AND secid='$rs[secid]'";
		mysql_db_query($dbname_temp,$sql_upch);
		SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"2");// �� log ��ù���Ң�����
		
}else{
	
	
	
		## ��Ǩ�ͺ ��Ŵ���й���Ң�����
		## �ӹ�˹�Ҫ���
		//echo "<pre>";
		//print_r($rs);die;
		###  ��Ǩ�ͺ field ����ա�û�ͧ�ѹ������
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
	####  �ó���辺�����ҧ� field ���ѧ�Ѻ
	
			
//	echo "<pre>";
	//print_r($arrfalse);
	
	if($check_field > 0){ # �óբ����ŷ��й������� field �ѧ�Ѻ�繤����ҧ
			SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"0");// �� log ��ù���Ң�����
			CleanImportError($rs[idcard],$rs[secid],$rs[profile_id]);// ��ҧ������ error ��͹�ӡ�úѹ�֡
		### ����¡�÷�� error
		foreach($arrfalse as $k => $v){
			SaveImpotError($rs[idcard],$rs[secid],$rs[profile_id],$k);
		}// end foreach($check_field as $k => $v){
			
	}else{ // �óռ�ҹ��͹䢿�Ŵ�ѧ�Ѻ
		
		## ��Ǩ�ͺ ��Ŵ���й���Ң�����
		## �ӹ�˹�Ҫ���
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
		## ���
		if(CheckField($rs[secid],"name_th") > 0){
			$update_name = ", name_th='$rs[name_th]'";	
		}else{
			$update_name = "";
		}//end if(CheckField($rs[secid],"name_th") > 0){
		## ���ʡ��
		if(CheckField($rs[secid],"surname_th") > 0){
			$update_surname = ", surname_th='$rs[surname_th]'";
		}else{
			$update_surname = "";	
		}//end if(CheckField($rs[secid],"surname_th") > 0){
		###  �ѹ��͹���Դ
		if(CheckField($rs[secid],"birthday") > 0){
			$update_birthday = ", birthday='$rs[birthday]'";
		}else{
			$update_birthday = "";
		}
		## �ѹ�������Ժѵ�Ҫ���
		if(CheckField($rs[secid],"begindate") > 0){
			$update_begindate = ", begindate='$rs[begindate]'";
		}else{
			$update_begindate = "";
		}//end if(CheckField($rs[secid],"begindate") > 0){
		## ���˹觻Ѩ�غѹ 
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
		## ˹��§ҹ
		if(CheckField($rs[secid],"schoolid") > 0){
			$update_schoolid = ", schoolid='$rs[schoolid]'";
		}else{
			$update_schoolid = "";
		}

		$result_tranfer = "";
		
		$num_retire = GetDataCenterForImport($rs[idcard]); // �Ѻ�ӹǹ���١��˹����͡仨ҡ�к�
		$num_center = CheckDataCenterImport($rs[idcard]); //�Ң����ŷ������㹰ҹ��ҧ
		$num_cmss = GetNumCmssImport($rs[idcard]); // �Ѻ�ӹǹ�����ŷ������������� cmss

		
		## end ��Ǩ�ͺ ��Ŵ��ù���� 
#############################  �óչ�����黡�� ##################################
		if($rs[status_id_replace] == "0"){ // ��͢����Ż�������ö�����������
					
					SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"1");// �� log ��ù���Ң�����
					$numdatacmss = CountSalaryInsite($rs[secid],$rs[idcard]); // �Ѻ�ӹǹ�������Թ��͹�ࢵ�������
					$numcmss0000 = CheckNumCmssCenter($rs[idcard],"0000"); //�Ѻ�ӹǹ������㹰ҹ��ҧ
					if($num_retire > 0 and $num_center > 0 and $num_cmss < 1 ){
						$site_source1= "0000";
						$site_dest1 = $rs[secid];
							
							#CleanDataBeforeTranfer($site_dest1,$rs[idcard]);
							$result_tranfer = transfer_data($rs[idcard],$site_source1,$site_dest1,"0000",$rs[schoolid],"11","Tranfer From 0000 To Cmss");// ���¢����Ũҡ cmss 0000
							
							$sql_update_tranfer = "UPDATE tbl_check_data SET status_restoredata='1' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
							mysql_db_query($dbname_temp,$sql_update_tranfer);
					}//end if($numcmss0000 > 0 and $numdatacmss < 1 ){

		
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0 ){ // �ó����������� update ����繡�������Ҩҡࢵ���
				
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss) or die(mysql_error()."$sql_imp2cmss<br>LINE__".__LINE__);
					//echo "update";
				}else{// �ó��ѧ���������
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',position='',pivate_key='$pivate_key',blood='',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss)or die(mysql_error()."$sql_imp2cmss<br>LINE__".__LINE__);
					//echo "insert";
				}
			//echo "<br>sql = ".$sql_imp2cmss."<br>";
			
				### �ӡ����������㹻���ѵԡ������¹����
				AddHistoryNameCmss($rs[secid],$rs[idcard],$rs[prename_th],$rs[name_th],$rs[surname_th]); 
			###  �ӡ�äѴ�͡����ٻ���ҹ������ cmss
			 ImportPicToCmss($rs[secid],$rs[idcard]); // �ӡ�äѴ�͡������ҹ������  cmss
			## end �ӡ�äѴ�͡�ٻ���ҹ������ cmss
			## �ӡ�äѴ�͡��� kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // �ó��������ҹ��
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
				//echo $sql_update_tranfer."<br>";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end  //if($result_imp2cmss){


#############################  �ó�仫�ӡѺࢵ��� ##################################		
		}else{ // �óբ�����仫�ӡѺࢵ���
		
			$dbsource = "cmss_".$rs[siteid_replace]; // �ҹ������ࢵ�鹷ҧ
			$dbdest = "cmss_".$rs[secid];
			$result_tranfer = "";

				if($rs[status_data_old] == "1"){ // �ó��繢�������Ҩҡ�շ������
						#### ��ҡ�кǹ������¢�����
							
							// �������ࢵ�鹷ҧ����繢ͧࢵ���������ࢵ�Ҩ����ж١�Ѵ��������� temp_general � master ��ͧ�֧��Ѻ�ҡ�͹�ӡ������
							
							
/*							if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							$xdb_site = "cmss_".$rs[siteid_replace];
							$sql_update1 = "REPLACE INTO general SET id='$rs[idcard]',idcard='$rs[idcard]', siteid='$rs[secid]',position='',blood='',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";
							mysql_db_query($dbsite,$sql_update1);
								
								
							}//end if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
*/							
							//echo $dbsource."::".$dbdest."  $rs[siteid_replace] :: $rs[idcard] ";die;
							###  ���ͧ�ҡ��ѭ�ҡ�÷ӧҹ�ͧ crontrab ��� triggers �����Ҫ��
							####  �ӡ��ź������㹵��ҧ view_general � site ���� master
							$sql_delv = "DELETE FROM view_general WHERE CZ_ID='$rs[idcard]'";
							mysql_db_query($dbsource,$sql_delv);
							$sql_delvm = "DELETE FROM view_general WHERE CZ_ID='$rs[idcard]' AND siteid='$rs[siteid_replace]'";
							mysql_db_query($dbnamemaster,$sql_delvm);
							
									$num_retire = GetDataCenterForImport($rs[idcard]); // �Ѻ�ӹǹ���١��˹����͡仨ҡ�к�
									$num_center = CheckDataCenterImport($rs[idcard]); //�Ң����ŷ������㹰ҹ��ҧ
									$num_cmss = GetNumCmssImport($rs[idcard]); // �Ѻ�ӹǹ�����ŷ������������� cmss

							####  end �ӡ��ź������㹵��ҧ view_general � site ���� master
							$sitesource = $rs[siteid_replace];
							$sitedest = $rs[secid];
							if($num_cmss < 1 and $num_retire > 0 and $num_center > 0){
								#CleanDataBeforeTranfer($siteid,$idcard);
								$result_tranfer = transfer_data($rs[idcard],"0000",$sitedest,"0000",$rs[schoolid],"11","tranfer_checkdata");
							}else{
							
							if($sitesource != $sitedest){
								
								$result_tranfer = transfer_data($rs[idcard],$sitesource,$sitedest,"0000",$rs[schoolid],"11","tranfer_checkdata");
							}
							}
							
						#### end ��ҡ�кǹ������¢�����
					###  update ������ � general 
					if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1 ){  // update 㹡ó��繢���������
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',position='',blood='',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
					}//end 
			### �ӡ����������㹻���ѵԡ������¹����
				AddHistoryNameCmss($rs[secid],$rs[idcard],$rs[prename_th],$rs[name_th],$rs[surname_th]); 
			## �ӡ�äѴ�͡��� kp7

			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]' and profile_id='$profile_id'";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
				}//end  if($result_imp2cmss){
					
				}else{ ###  �ó�����������ࢵ��ҵ���ѭ�һշ������

				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // �ó����������� update
					$sql_imp2cmss = "UPDATE general SET siteid='$rs[secid]',unit='$rs[secid]',vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
				}else{// �ó��ѧ���������
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',position='',pivate_key='$pivate_key',blood='',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
				}
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
			## �ӡ�äѴ�͡��� kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // �ó��������ҹ��
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
	}//end if($check_field > 0){ # �óբ����ŷ��й������� field �ѧ�Ѻ�繤����ҧ
		unset($arrfalse); // ��ҧ��� array ��Ǩ�ͺ
		
	}//end if($check_retire > 0){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end �ӡ�ùӢ����Ũҡ edubkk_checklist ������ҹ Cmss

		###  �ӡ�� update ����������㹢������ general , view_general �Ѻ view_general � master �ç�ѹ
		$sql_update_general = "UPDATE general SET  id=idcard,siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
			### update ʶҹ�ࢵ����ա�ù���Ң���������
			UpdateKeydataActive($xsiteid,$profile_id);
		
		echo "<script>alert('����Ң��������º��������');location.href='import2cmss_per_person.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1&lv=$lv&schoolid=$schoolid&profile_id=$profile_id&import_id=$last_id';</script>";
		exit;
//?action=&xsiteid=6502&secname=�ӹѡ�ҹࢵ��鹷�����֡�Ҿ�ɳ��š ࢵ 2
	}// end if($Aaction == "process"){
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
###  end �����ż���¡��

function CheckImportPerPerson($get_siteid,$get_idcard,$profile_id){
	global $dbname_temp;
	if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������
	$sql = "SELECT COUNT(idcard) as num1 FROM tbl_check_data WHERE idcard='$get_idcard' AND secid='$get_siteid' and profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckImportPerPerson(){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
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
<script language="javascript">
function CheckAll(chk)
{
for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
}

function UnCheckAll(chk)
{
for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}


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
	if($lv == "0"){// �٢��������ࢵ
		$arr1 = show_val_exsum("1",$xsiteid,$schoolid,$profile_id);
	}else if($lv == "1"){ // �٢���������ç���¹
		$arr1 = show_val_exsum("2",$xsiteid,$schoolid,$profile_id);
	}
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
<form name="form1" method="post" action="?">
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><? if(substr($xsiteid,0,2) == "99"){?><!--<a href="import2cmss.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">����Ң���ٷ��ࢵ</a> ||--> <? }?><a href="import2cmss_per_person.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=0&profile_id=<?=$profile_id?>">����Ң�������ºؤ��</a>  || <!--<a href="import2cmss_doccomplate.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">����Ң�����੾��ʶҹ��͡�������ó���ҹ��</a>|| --><!--<a href="import2cmss_uncomp.php?action=<?=$action?>&xsiteid=<?=$xsiteid?>&secname=<?=$secname?>&lv=<?=$lv?>&profile_id=<?=$profile_id?>">������͡����������ó����ͷ���ѧ������ cmss</a>--><br>
<br>


    </td>
 </tr>
 <? if($lv == "1"){ //����Ң�������ºؤ�� ?>
 <tr>
   <td align="left">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
               <tr>
                 <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>��Ǵ��¡�ùӢ���������к� cmss �������ö���͡��ºؤ����</strong></td>
                 </tr>
               <tr>
                 <td width="26%" align="right" bgcolor="#CAD5FF"><strong>������ �.�ѹ���</strong></td>
                 <td width="74%" align="left" bgcolor="#CAD5FF">
                  <input type="hidden" name="dateposition_now" value="<?=$config_date?>"> �������ѹ���١��˹��� <?=Show_dateThai($config_date)?> ��������кǹ��úѹ�֡�����Ŷ١��ͧ
                 <!--<INPUT name="dateposition_now" onFocus="blur();" value="<?//=$config_date?>" size="15" readOnly>
                   <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.dateposition_now, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>-->
               </tr>
               <tr>
                 <td align="right" bgcolor="#FFFFFF">ʶҹФ�������ó������</td>
                 <td align="left" bgcolor="#FFFFFF"><label>
                   <input type="radio" name="status_data" id="status_data1" value="1">
                 ����ó�
                 	<input type="radio" name="status_data" id="status_data0" value="0">
                 �������ó�</label></td>
               </tr>
               <tr>
                 <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>�����˵� : </strong>�óշ�� checklist �������ö�׹�ѹ�ӹǹ�ؤ�ҡ��ࢵ</td>
                 </tr>
               <tr>
                 <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                 <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>���͡�����ŷ��й�����к�</strong></td>
                   </tr>
                   <tr>
                     <td width="11%" align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fprename_th" value="1"  checked="checked">
                     </label></td>
                     <td width="89%" align="left" bgcolor="#FFFFFF">�ӹ�˹�Ҫ���</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fname_th" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">����</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fsurname_th" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">���ʡ��</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fbirthday" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">�ѹ��͹���Դ</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fbegindate" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">�ѹ�������Ժѵ��Ҫ���</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fposition_now" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">���˹觻Ѩ�غѹ</td>
                   </tr>
                   <tr>
                     <td align="center" bgcolor="#FFFFFF"><label>
                       <input type="checkbox" name="Fschoolid" value="1" checked="checked">
                     </label></td>
                     <td align="left" bgcolor="#FFFFFF">˹��§ҹ�ѧ�Ѵ</td>
                   </tr>
                 </table></td>
               </tr>
               <tr bgcolor="#FFFFFF">
                 <td align="right">&nbsp;</td>
                 <td align="left">
                	 <input type="submit" name="submit" value="�����żŢ�����">
                 	<input type="button" name="btnClose" value="¡��ԡ" onClick="window.close()" style="cursor:hand">
                   <input type="hidden" name="Aaction" value="process">
                   <input type="hidden" name="secname" value="<?=$secname?>">
                   <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                   <input type="hidden" name="schoolid" value="<?=$schoolid?>">
                   <input type="hidden" name="lv" value="<?=$lv?>">
                   <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                   </td>
               </tr>
               <? } // end if($lv == "1"){?>
             </table></td>
           </tr>
         </table></td>
         <td width="50%" align="center" valign="bottom"><table width="90%" border="0" cellspacing="0" cellpadding="0">
         <? if($flag_crontab == "1"){
			 	$arr_result = CheckImportData($xsiteid,$profile_id);
				//echo "<pre>";
			//	print_r($arr_result);
			 ?>
           <tr>
             <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="3" align="center" bgcolor="#CAD5FF"><strong>��ػ��ùӢ����Ũҡ checklist �������к� cmss<br>
                       (�к��зӡ�ù����Ң����źѭ�� �.18 ����㹡óշ����ࢵ����)                     </strong></td>
                     </tr>
                      <? if(CheckNumJ18($xsiteid) > 0){ ?>
                   <tr>
                     <td colspan="3" align="center" bgcolor="#FFFFFF"><strong><a href="../j18/manager_group/reportj18/index_school.php?xsiteid=<?=$xsiteid?>" target="_blank">�ʴ������źѭ�� �.18</a></strong></td>
                     </tr>
                     <? } // end  if(CheckNumJ18($xsiteid) > 0){ ?>
                   <tr>
                     <td width="63%" align="left" bgcolor="#FFFFFF"><strong>1. �ӹǹ������������</strong></td>
                     <td width="23%" align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr1['numall']);?>
                     </strong></td>
                     <td width="14%" align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>2. �ӹǹ��������к� cmss</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['NumAll'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.1 �ӹǹ�ؤ�ҡ÷�������ࢵ���</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['InSite'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.2 �ӹǹ�ؤ�ҡ÷���������������</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr_result['TranferIn'])?>
                     </strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;2.3 �ӹǹ�ؤ�ҡ÷���������ö�������<br>
���ͧ�ҡ�����źҧ��¡���繤����ҧ</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong><? if($arr_result['imp_err'] > 0){ echo "<a href='report_import_error.php?action=&xsiteid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($arr_result['imp_err'])."</a>";}else{ echo "0";}?></strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>3. �ӹǹ�ؤ�ҡ÷��������������š�ҧ</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><? $numcenter = CountDataCenter($xsiteid) ; if($numcenter > 0){ echo "<a href='report_import2cmss_center.php?xsiteid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($numcenter)."</a>";}else{ echo "0";}?></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                                      <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>4. �ӹǹ������������ö�������<br>
                       ���ͧ�ҡ�ա�è�˹��ºؤ�ҡ������</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><? if($arr_result['retire'] > 0){ echo "<a href='report_import_error.php?action=&xsiteid=$xsiteid&profile_id=$profile_id&mode=retire' target='_blank'>".number_format($arr_result['retire'])."</a>";}else{ echo "0";}?></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                 <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>5. �����ū�ӡѺ 48 ࢵ����ͧ����������ö�������</strong></td>
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
                     <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
           <? } //end  if($flag_crontab == "1"){ 
		   
		 
		   ?>
           <tr>
             <td align="center">&nbsp;</td>
           </tr>
           <tr>
             <td align="center">
             <?
             	  if($flag_crontab != "1"){
			 ?>
             <table width="95%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                   <tr>
                     <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>��§ҹ��ػ
                       <?=show_area($xsiteid);?>
                       <br>
                       (�к��зӡ�ù����Ң����źѭ�� �.18 ����㹡óշ����ࢵ����)                     </strong></td>
                   </tr>
                   <tr>
                     <td width="59%" align="center" bgcolor="#CAD5FF"><strong>��¡��</strong></td>
                     <td width="41%" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ</strong></td>
                   </tr>
                    <? if(CheckNumJ18($xsiteid) > 0){ ?>
                    <tr>
                     <td colspan="2" align="center" bgcolor="#FFFFFF"><strong><a href="../j18/manager_group/reportj18/index_school.php?xsiteid=<?=$xsiteid?>" target="_blank">�ʴ������źѭ�� �.18</a></strong></td>
                     </tr>
                     <? }//end  if(CheckNumJ18($xsiteid) > 0){ ?>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ˹��§ҹ������checklist������</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=$numschoolall?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ�ؤ�ҡ÷�����</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><strong>
                       <?=number_format($arr1['numall']);?>
                     </strong></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ˹���͡��÷��Ѻ��</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numpage']);?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ�ٻ���Ѻ��</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numpic']);?></td>
                   </tr>
                   <tr>
                     <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ��� pdf �������к�</strong></td>
                     <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['NumFile']);?></td>
                   </tr>
                 </table></td>
               </tr>
             </table>
                        <?
					 }//end if($flag_crontab != "1"){
		   ?>

             </td>
           </tr>
         </table></td>
       </tr>
     </table>
</td>
 </tr>
 <tr>
    <td align="right">&nbsp;</td>
  </tr>
 <tr>
   <td align="right">&nbsp;</td>
 </tr>
 <? if($lv == "0"){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr align="center">
       <td colspan="6" align="left" bgcolor="#A8B9FF"><strong>�к�����Ң����Ũҡ�ҹ checklist ����к� cmss <?=show_area($xsiteid);?></strong></td>
        </tr>
      <tr>
        <th width="4%" align="center" bgcolor="#A8B9FF"><strong>�ӴѺ</strong></th>
        <th width="40%" align="center" bgcolor="#A8B9FF">˹��§ҹ/�ç���¹</th>
        <th width="14%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ<br>
          ������(��)</strong></th>
        <th width="13%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ˹��<br>
          �͡���(��)</strong></th>
        <th width="15%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ<br>
          �ٻ(�ٻ)</strong></th>
        <th width="14%" align="center" bgcolor="#A8B9FF">�ӹǹ��� pdf<br>
���������ú�(��)</th>
      </tr>
      </thead>    
	<tbody>   
		<?
			$sql = "SELECT
CAST(id as SIGNED) as id, allschool.siteid,office,
Sum(if(page_upload > 0 ,1,0)) AS NumFile,
Sum(page_num) AS NumPage,
Sum(pic_num) AS NumPic,
Count(idcard) AS NumAll,
id as schoolid
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
AND edubkk_master.allschool.siteid='$xsiteid'
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' and edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.schoolid
order by id ASC
";
//echo ":: ".$sql;
			$result = mysql_db_query($dbname_temp,$sql);
			$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
			$i1=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i1++ % 2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
				  $temp_dis = CheckLockArea($rs[secid],$profile_id);
				  //$arrN = CountCheckListKp7($rs[secid],"",$profile_id);
				  $id_org = "$rs[secid]";
				  $numpage = $rs['NumPage']; //  �ӹǹ��
				  $numpic = $rs['NumPic']; // �ӹǹ�ٻ
				  $numfile = $rs['NumFile'];
				  $count_impP = $rs['NumAll'];// �ӹǹ������			 
			 
		?>
      <tr bgcolor="<?=$bg1?>">
        <td align="center"><?=$i1?></td>
        <td align="left"><? if($count_impP > 0){ echo "<a href='?action=&lv=1&xsiteid=$xsiteid&schoolid=$rs[schoolid]&profile_id=$profile_id'>".$rs[office]."</a>";}else{ echo "$rs[office]";}?></td>
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
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
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
    </table></td></tr></table></td>
  </tr>
  <? }else	if($lv == "1"){	  
?>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#A8B9FF"><strong>����Ң����Ţͧ &nbsp;<?=show_area($xsiteid);?>&nbsp;<?=show_school($xschoolid);?></strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>�ӴѺ</strong></td>
        <td width="19%" align="center" bgcolor="#A8B9FF"><strong>�Ţ�ѵû�ЪҪ�</strong></td>
        <td width="27%" align="center" bgcolor="#A8B9FF"><strong>���� - ���ʡ��</strong></td>
        <td width="24%" align="center" bgcolor="#A8B9FF"><strong>���˹�</strong></td>
        <td width="24%" align="center" bgcolor="#A8B9FF"><input  type="button" value="���͡������" onclick="CheckAll(document.form1.n)" /> <input  type="button" value="¡��ԡ������" onclick="UnCheckAll(document.form1.n)" /></td>
      </tr>
      <?
    //  $sql_view = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND schoolid='$schoolid'";
	  $sql_view = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.siteid,
edubkk_checklist.tbl_checklist_kp7.prename_th,
edubkk_checklist.tbl_checklist_kp7.name_th,
edubkk_checklist.tbl_checklist_kp7.surname_th,
edubkk_checklist.tbl_checklist_kp7.birthday,
edubkk_checklist.tbl_checklist_kp7.begindate,
edubkk_checklist.tbl_checklist_kp7.position_now,
edubkk_checklist.tbl_checklist_kp7.schoolid
FROM
edubkk_checklist.tbl_checklist_kp7
Left Join edubkk_master.hr_addposition_now ON edubkk_checklist.tbl_checklist_kp7.position_now = edubkk_master.hr_addposition_now.`position`
WHERE
siteid='$xsiteid' AND schoolid='$schoolid' and profile_id='$profile_id'
order by edubkk_master.hr_addposition_now.orderby  ASC";
	  //echo $sql_view;
	  $result_view = mysql_db_query($dbname_temp,$sql_view);
	  $i=0;
	  while($rsv = mysql_fetch_assoc($result_view)){
	  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  	$file_pdf = "../../../checklist_kp7file/$xsiteid/$rsv[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'></a>";
					$disable_ch = "";
				}else{
					$img_pdf = "";
					//$disable_ch = "disabled='disable_ch'";
				}//end if(is_file($file_pdf)){
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rsv[idcard]?></td>
        <td align="left"><? echo "$rsv[prename_th]$rsv[name_th]  $rsv[surname_th]";?></td>
        <td align="left"><? echo "$rsv[position_now]";?></td>
        <td align="center"><?=$img_pdf?><label>
          <input type="checkbox" name="arr_id[<?=$i?>]" id="n" value="<?=$rsv[idcard]?>" <?=$disable_ch?>>
        </label>
        <? if(CheckImportPerPerson($xsiteid,$rsv[idcard],$profile_id) > 0){ "���������";}else{ echo "";}?>
        </td>
      </tr>
      <?
	}//end while(){
	  ?>
    </table></td>
  </tr>
  <input type="hidden" name="list_data" value="<?=$i?>">
    <?
	}//end if($lv == "1"){	
  ?>

  <tr>
    <td align="left" valign="middle"><em>�����˵� <font color="#FF0000">*</font> ���¶֧ࢵ����Ǩ�ͺ�ӹǹ�١��ͧ����</em></td>
  </tr>
</table>
   </form>
<? if($flag_crontab == "1"){
?>
<iframe src="../hr3/tool_competency/crontab_update_master_view_general.php?sent_xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" style="display:none"></iframe>
<?

		include("../pic2cmss/function/function.php");
		$sql1 = "SELECT idcard,profile_id, siteid FROM `upic_temp_person` WHERE status_number_process='2'  AND  status_finish='UNSUCCESS'  AND siteid='$xsiteid' ";
		$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
		while($rs1 = mysql_fetch_assoc($result1)){
			contrab2_updateWorkingChecklist($rs1[idcard],$xsiteid,$rs1[profile_id]);
		}//end while($rs1 = mysql_fetch_assoc($result1)){


####  ����Ң����� �.18
if(CheckNumJ18($xsiteid) < 1){
	ProcessImpJ18($xsiteid);	
}//end if(CheckNumJ18($xsiteid) < 1){
####  ����Ң����� �.18

}//end  if($flag_crontab == "1"){
}//end if($action == ""){
?>
</body>
</html>
