<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");


### ���ͺ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ���ͺ

	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//require_once("../../common/preloading.php");
	//echo "saddd";die;
		#$dbsite = "cmss_".$xsiteid;
		#AlterField($dbsite,"general_pic","img_owner");// ��Ǩ�ͺ���ͷ��зӡ�û�Ѻ�ç���ҧ���ҧ general_pic
		$dateposition_now = SwDateT($dateposition_now);
		$dateposition_now = "2553-10-01";
		
		$arrsitecon = GetSiteContinute();// ����ࢵ������ͧ
		$last_id = InsertLogImpChecklistToCmss($xsiteid,$_SESSION['session_staffid']); // log ��ù���Ң���������ش
		
	## �ѹ�֡��������¡�â����ŷ��й�����к�
	$sql_status_field = "REPLACE INTO tbl_status_field_import(secid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_import_data)VALUES('$xsiteid','$Fprename_th','$Fname_th','$Fsurname_th','$Fbirthday','$Fbegindate','$Fposition_now','$Fschoolid','$status_data')";
mysql_db_query($dbname_temp,$sql_status_field) or die(mysql_error()."".__LINE__);
	## end �ѹ�֡��������¡�â����ŷ��й�����к�
	
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
	
	
	if($numm > 0){ // �����੾���Ţ�ѵ÷�����͡��ºؤŷ��зӡ�ä��������
		while($rsm = mysql_fetch_assoc($resultm)){
			$valid = $rsm[idcard];
			$profile_id = $rsm[profile_id];
			$xsiteid = $rsm[siteid];
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
and t1.idcard IN('1120100036004','3670100007375','3100504464225','3100504246619','3101700885468','3730200014283','3160100419716','3160101034494','3160190019704','3160300405484','3160500026151','3160500040234','3160500324445','3160500324453','3160600396758','3160600450523','3160600575334','3180500627472','3191100498773','3600800486608','3841500004976','5160699007003','3209900417791','3309901213055','5610700002826','1341600030110','5460790009959','3410600653308','3410601092636','3330101146584','3440400476488','3440600631622','3440601123787','3480500365238','5460390000318','3450700097890','3450800087179','3451001119984','3451500083438','3460300120177','1479900015511','3479900050089','3479900122331','3471000049214','3471100241273','3490100279156','5471000002885','1141400052146','1500700054131','1530400031349','1539900139554','1559900046360','1559900092990','1669900003091','3130700105836','3550100725058','3550700436294','3640400442140','5550500521642','5550590005029','3560300200374','3560300989296','3690301402034','6001902546813','3600700352871','6003419736028','6003680931475','6003753162948','1629900014211','3620600218332','3629900173782','1549900035511','1600900015228','1620700004541','1629900111403','1640400053317','1659900214008','1669800056079','3400500396583','3440600964567','3480800429614','3550400221101','3601000407399','3620100730123','3620100902455','3620101515561','3620101861345','3620200371567','3620401061204','3620600615633','3630800080881','3640300334337','3640400208252','3670100677737','5550500227060','3650600121088','3699900193414','3660500511062','3669800062571','3669900125885','3690300737547','1709900168862','3800100807973','3950600078074','3960100262119','3989900313115','3101202996942','3120600066804','3309900686731','3309900878061','7790000023257','3609900029789','3759900014080','3140700060298','3250200967927','3259800038739','3259900129361','3801300364278','3860800013414','3900300185452','3900400215345','3909900083110','3909900550788','3450200536843','3450700262947','3300100768930','3360100935046','3360300404923','3361200031565','3369900168528','3410500047058','9017877267952','3100100722303','3100500093494','3300101002272','3309900463805','3309900610913','3309901218367','3309901481891','3490600072691','3909801142177','3310300558122','3100201195837','3100220085123','3102001785975','3110102129658','3119800094428','3120100613037','3170400059751','3190300549906','3190600037844','3240400012228','3305000563025','3314600865790','3329900289549','3331000009726','3340700771346','3340990035827','3360400699833','3441300621219','3451100692517','3500600437814','3502100526501','3529900277729','3860100315958','3900100136570','3903800927685','3909900345997','3909900528064','5704000184221','5710500382704','3100603031637','3501300789654','9997042224332','9997432095804','9997542844411','9997613088753','9997998278701','9998162467985','9998186597218','9998391505494','9998402887754','9999163451226','9999407184183','9999787369482','9999891525622','9999992927009')
  GROUP BY idcard";
#echo "$sql <br>";die();

$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$dbsite = "cmss_".$rs[secid];

#$check_retire = CheckRetire($rs[idcard]);	 // ��Ǩ�ͺ������³�����Ҫ��������

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
		## end ��Ǩ�ͺ ��Ŵ��ù���� 
#############################  �óչ�����黡�� ##################################
		if($rs[status_id_replace] == "0"){ // ��͢����Ż�������ö�����������
					
					SaveLogImpotCheckListToCmss($rs[idcard],$rs[secid],$rs[profile_id],"1");// �� log ��ù���Ң�����
					$numdatacmss = CountSalaryInsite($rs[secid],$rs[idcard]); // �Ѻ�ӹǹ�������Թ��͹�ࢵ�������
					$numcmss0000 = CheckNumCmssCenter($rs[idcard],"0000"); //�Ѻ�ӹǹ������㹰ҹ��ҧ
					if($numcmss0000 > 0 and $numdatacmss < 1 ){
						$site_source1= "0000";
						$site_dest1 = $rs[secid];
							$result_tranfer = transfer_data($rs[idcard],$site_source1,$site_dest1,"0000",$rs[schoolid],"11","Tranfer From 0000 To Cmss");// ���¢����Ũҡ cmss 0000
							
							$sql_update_tranfer = "UPDATE tbl_check_data SET status_restoredata='1' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
							mysql_db_query($dbname_temp,$sql_update_tranfer);
					}//end if($numcmss0000 > 0 and $numdatacmss < 1 ){

		
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0 ){ // �ó����������� update ����繡�������Ҩҡࢵ���
				
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss) or die(mysql_error()."$sql_imp2cmss<br>LINE__".__LINE__);
					//echo "update";
				}else{// �ó��ѧ���������
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',position='',blood='',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
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
							####  end �ӡ��ź������㹵��ҧ view_general � site ���� master
							$sitesource = $rs[siteid_replace];
							$sitedest = $rs[secid];
							if($sitesource != $sitedest){
								$result_tranfer = transfer_data($rs[idcard],$sitesource,$sitedest,"0000",$rs[schoolid],"11","tranfer_checkdata");
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
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',position='',blood='',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
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
		
		
		$sql_upd = "UPDATE tbl_checklist_kp7_all_checklist_notin_cmss_checkimp SET flag_import='1' WHERE idcard='$rs[idcard]' AND siteid='$rs[secid]'";
		mysql_db_query($dbname_temp,$sql_upd) or die(mysql_error()."".__LINE__);
		
	}//end if($check_retire > 0){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end �ӡ�ùӢ����Ũҡ edubkk_checklist ������ҹ Cmss

		###  �ӡ�� update ����������㹢������ general , view_general �Ѻ view_general � master �ç�ѹ
		$sql_update_general = "UPDATE general SET  id=idcard,siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
			### update ʶҹ�ࢵ����ա�ù���Ң���������
			UpdateKeydataActive($xsiteid,$profile_id);
		
		
//?action=&xsiteid=6502&secname=�ӹѡ�ҹࢵ��鹷�����֡�Ҿ�ɳ��š ࢵ 2
	}// end if($Aaction == "process"){

###  end �����ż���¡��
echo "Done...";
?>

