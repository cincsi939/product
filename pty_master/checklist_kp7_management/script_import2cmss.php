<?
session_start();
set_time_limit(0);
include("checklist.inc.php");
include("function_tranfer.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
	header("Location: login.php");
	die;
}
//echo "script by suwat";die;

####  �����ż���¡��
### ���ͺ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ���ͺ
	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//	echo "script by suwat";die;
	//require_once("../../common/preloading.php");
		$dbsite = "cmss_".$xsiteid;
		AlterField($dbsite,"general_pic","img_owner");// ��Ǩ�ͺ���ͷ��зӡ�û�Ѻ�ç���ҧ���ҧ general_pic
		$dateposition_now = SwDateT($dateposition_now);
		//echo "����ش��ùӢ��������";die;
### �ӡ�ùӢ����Ũҡ edubkk_checklist ������ҹ Cmss#########################################################
$sql = "SELECT * FROM tbl_check_data WHERE secid='$xsiteid' AND status_tranfer_data='0' AND idcard_structure='1' AND schoolid IS NOT NULL AND schoolid <> '0' ";
//echo $sql."<br>";die;

$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
		## ��Ǩ�ͺ ��Ŵ���й���Ң�����
		## �ӹ�˹�Ҫ���
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
		}// end if(CheckField($rs[secid],"prename_th") > 0){
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
		### 
		## end ��Ǩ�ͺ ��Ŵ��ù���� 
#############################  �óչ�����黡�� ##################################
		if($rs[status_id_replace] == "0"){ // ��͢����Ż�������ö�����������
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // �ó����������� update
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					//echo "update";
				}else{// �ó��ѧ���������
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
					//echo "insert";
				}
			//echo "<br>sql = ".$sql_imp2cmss."<br>";die;
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
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
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
				//echo $sql_update_tranfer."<br>";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end  //if($result_imp2cmss){
			### ��ҧ�����������͹����
			if($rs[status_data_old] != "1"){ // ��ҧ�����šó�������ç��ûշ������
				DeleteDataNew($rs[secid],$rs[idcard]);
			}
#############################  �ó�仫�ӡѺࢵ��� ##################################		
		}else{ // �óբ�����仫�ӡѺࢵ���
		//echo "���¢�����";die;
		
			$dbsource = "cmss_".$rs[siteid_replace]; // �ҹ������ࢵ�鹷ҧ
			$dbdest = "cmss_".$rs[secid];
				if($rs[status_data_old] == "1"){ // �ó��繢�������Ҩҡ�շ������
						#### ��ҡ�кǹ������¢�����
							
							// �������ࢵ�鹷ҧ����繢ͧࢵ���������ࢵ�Ҩ����ж١�Ѵ��������� temp_general � master ��ͧ�֧��Ѻ�ҡ�͹�ӡ������
							if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							$xdb_site = "cmss_".$rs[siteid_replace];
							//echo "��������";die;
									trn_temp_general2cmss("temp_general",$ipsource,$dbnamemaster,$rs[idcard],"id",$xdb_site);
									//echo "AAA <br>";
							}//end if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							//echo "����������";die;
							
							//echo $dbsource."::".$dbdest."  $rs[siteid_replace] :: $rs[idcard] ";die;
							
									foreach($arr_tbl1 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"id");
									}
									foreach($arr_tbl2 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"gen_id");		
									}
									foreach($arr_tbl5 as  $tbl){	
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"idcard");	
									}
									
								#######  �ӡ�� trigger �����š���֡�ҷ�����дѺ�٧�ش
									// trigger_euation($rs[secid],$rs[idcard]);
								####### end  �ӡ�� trigger �����š���֡�ҷ�����дѺ�٧�ش
								
									//CHECK_DATA  �����ź������ࢵ�鹷ҧ
									 foreach($arr_tbl1 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"id");
									}
									foreach($arr_tbl2 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"gen_id");		
									}
									foreach($arr_tbl5 as  $tbl){	
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"idcard");	
									}	

						#### end ��ҡ�кǹ������¢�����
					###  update ������ � general 
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
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
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
				}//end  if($result_imp2cmss){
					
				}else{ ###  �ó�����������ࢵ��ҵ���ѭ�һշ������
					####  ź������ࢵ�鹷ҧ������������� 46 ࢵ
					//echo "$rs[siteid_replace] ::: $rs[idcard]";die;
					//DeleteDataNotIn($rs[siteid_replace],$rs[idcard]);
					###  
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // �ó����������� update
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
				}else{// �ó��ѧ���������
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
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
			$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
			mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end if($result_imp2cmss){
					
#####################################################################################################					
				}// end if($rs[status_data_old] == "1"){ 
		}//end if($rs[status_id_replace] == "0"){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end �ӡ�ùӢ����Ũҡ edubkk_checklist ������ҹ Cmss
###  �ӡ����º������� ���ҧ checkl_data �Ѻ�ҹ������ cmss ��Ң�������ǹ�Թ����������������� temp_general ��͹���ͧ�ҡ�繢����ŷ���¤������������
//		$sql1 = "SELECT $dbsite.general.id FROM $dbsite.general Left Join $dbname_temp.tbl_check_data ON $dbsite.general.id = $dbname_temp.tbl_check_data.idcard WHERE $dbname_temp.tbl_check_data.idcard IS NULL ";
//		$result1 = mysql_db_query($dbsite,$sql1);
//		$numrow1 = @mysql_num_rows($result1);
//		if($numrow1 > 0){
//			while($rs1 = mysql_fetch_assoc($result1)){
//				### �Ѵ�红��������¡�÷������͡�˹�ͨҡࢵ������� temp_general
//				//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
//				trn_temp_general("general",$ipsource,$dbsite,$rs1[id],"id");
//			}
//		}//end if($numrow1 > 0){
### end �ӡ����º������� ���ҧ checkl_data �Ѻ�ҹ������ cmss ��Ң�������ǹ�Թ����������������� temp_general ��͹���ͧ�ҡ�繢����ŷ���¤������������
	//echo "AAAA";die;
		###  �ӡ�� update ����������㹢������ general , view_general �Ѻ view_general � master �ç�ѹ
	//	$sql_update_general = "UPDATE general SET siteid='$xsiteid'";
		//$result_update_general = mysql_db_query($dbsite,$sql_update_general);
		
		
/*		echo "<script>alert('����Ң��������º��������');location.href='import2cmss.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1';</script>";
		exit;*/
//?action=&xsiteid=6502&secname=�ӹѡ�ҹࢵ��鹷�����֡�Ҿ�ɳ��š ࢵ 2

		$sql_update_general = "UPDATE general SET siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
		
	}// end if($Aaction == "process"){
###  end �����ż���¡��
?>