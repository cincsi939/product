<?php
set_time_limit(0);
include("../checklist2.inc.php");
include("../../../config/conndb_nonsession.inc.php");
include("function_imp.php");
include("../../pic2cmss/function/function.php");

####  ��Ǩ�ͺ㹡ó��ա�� uplolad ���ͧ��������
if($debug == "on"){
$arrup = GetPrecessUpload("1101","4","99999");
if(count($arrup > 0)){	
	$xnumall = $arrup['numall']; // �ӹǹ�͡��÷�����
	$xnumpic = $arrup['pic']; // �ӹǹ�ٻ��� up �������
	$xnumpage = $arrup['page']; // �ӹǹ˹��
	$xnumupload = $arrup['upload'];
	$xnumuploadall = $arrup['uploadall'];
	$xnumuploaddiff = $arrup['uploaddiff'];
		echo "<script>alert('�š�� upload �͡��� �.�. 7\\n �ӹǹ�͡��÷����� $xnumall �� \\n �ӹǹ�͡��÷����Թ������Ƿ����� $xnumuploadall �� \\n �ӹǹ�͡��ä�ҧ���Թ��� $xnumuploaddiff  �� \\n�ӹǹ�����Թ����� $xnumupload ��  \\n �ӹǹ��� upload �ٻ�Ҿ $xnumpic  �ٻ�Ҿ \\n �ӹǹ���͡��÷����Թ�����  $xnumpage �� ');</script>";

}
	echo "xxxx";die;

}//end if($debug == "on"){
	
	
##########  �ӡ���׹�ѹ�Դ�ӡ�â�����
if($conF_site != ""){
	$sqlc1 = "SELECT * FROM tbl_checklist_kp7_confirm_site WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
	$resultc1 = mysql_db_query($dbname_temp,$sqlc1);
	$rsc1 = mysql_fetch_assoc($resultc1);
	if($rsc1[siteid] == ""){
		$sql_insert = "INSERT INTO tbl_checklist_kp7_confirm_site SET siteid='$xsiteid',profile_id='$profile_id',flag_xls_endprocess='$conF_site',staff_endprocess='".$_SESSION['session_staffid']."',flag_download_xls='1',staff_download='".$_SESSION['session_staffid']."'";
	}else{
		$sql_insert = "UPDATE tbl_checklist_kp7_confirm_site SET flag_xls_endprocess='$conF_site',staff_endprocess='".$_SESSION['session_staffid']."' WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
	}//end if($rsc1[siteid] == ""){
		$result_insert = mysql_db_query($dbname_temp,$sql_insert);
		
		if($conF_site == "1"){
			SaveLogConfirmSite($xsiteid,$profile_id,"2","upload ������������� ","$conF_site");	
		}// end if($conF_site == "1"){
		
		
}// end if($conF_site != ""){




LogImpExpExcel($xsiteid,$profile_id,"����Ң����� excel ���ͻ�Ѻ��ا������㹡�õ�Ǩ�ͺ�͡��õ鹩�Ѻ");
?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
</HEAD>
<BODY bgcolor="#A5B2CE">

<p>
  <?

require_once 'Excel/reader.php';
$setstrartrow = 4 ; // ��÷Ѵ�á�ͧ������

function GetRandomString($length){
	
	$template = "1234567890abcdefghijklmnopqrstuvwxyz";  
    
	settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
    	$b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('TIS-620');



//error_reporting(E_ALL ^ E_NOTICE);

/*
echo "<pre>";
print_r($data->sheets);
die;
*/


if($process=="execute"){

	$myfile = GetRandomString(7);

	while(is_file($myfile.".xls")){
		$myfile = GetRandomString(7);
	}
	//echo "$name<hr>";die;

	if(!copy($name,"upload_tmp/".$myfile.".xls")){
		//cannot copy file
		echo "&error_msg=����Ѿ��Ŵ������ �Դ��Ҵ �������ö Backup ��� $filename2 ��";
		die;
	}else{
		//write log keyin
		chmod("upload_tmp/".$myfile.".xls", 0777); 
	}

$data->read('upload_tmp/'.$myfile.'.xls');
//echo "<pre>";
//print_r($data);die;

if(!count($data->sheets)){
	echo "&error_msg=�������ö��ҹ������������ �Ҩ�繼��Ҩҡ�����١��ͧ �����ٻẺ������١��ͧ";
	die;
}

		$k=0;
		$a = 0;
		$v=0;
		$d=0;
		$jj=0;
		
		if(trim($data->sheets[0]['cells'][4][2]) != ""){
		  $setstrartrow = 4;
		}else{
		  $setstrartrow = 5;
		}
		
				
		$check_column = $data->sheets[0]['cells'][2][7];
		$check_position = $data->sheets[0]['cells'][2][6]; // ��Ǩ�ͺ����繵��˹�������
		$date_upload = date("Y-m-d H:i:s"); // ��� upload ������
		
		//echo "$check_column  :: $check_position<br> ";
		
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
				if($check_column == "�����"){ // �ʴ������ �������ҷ����Ŵ�
					$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // �Ţ�ѵ�
					$prname_th = trim($data->sheets[0]['cells'][$i][3]) ; // �ӹ�˹�Ҫ���
					$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ����
					$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // ���ʡ��
					
					if($check_position == "���˹觻Ѩ�غѹ"){
						$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ���˹�
						$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // �ç���¹
						$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // �����ç���¹
						$page_num = trim($data->sheets[0]['cells'][$i][10]) ;// �ӹǹ���͡���
						$pic_num = trim($data->sheets[0]['cells'][$i][11]) ;//  �ӹǹ�ٻ
						$mainpage = 	trim($data->sheets[0]['cells'][$i][12]) ;//  ʶҹл��͡���
						$staffid = trim($data->sheets[0]['cells'][$i][13]) ;//  ���ʾ�ѡ�ҹ
						$status_data = trim($data->sheets[0]['cells'][$i][14]) ;//  ʶҹС��
						$new_idcard = trim($data->sheets[0]['cells'][$i][15]) ;//  �Ţ�ѵ�����
						$birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ��͹���Դ
						$begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  �ѹ�������Ժѵ��Ҫ���
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][18]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][19]) ;// new pic
						
					}else{
						$schoolname = trim($data->sheets[0]['cells'][$i][6]) ; // �ç���¹
						$schoolid = trim($data->sheets[0]['cells'][$i][7]) ; // �����ç���¹
						$page_num = trim($data->sheets[0]['cells'][$i][9]) ;// �ӹǹ���͡���
						$pic_num = trim($data->sheets[0]['cells'][$i][10]) ;//  �ӹǹ�ٻ
						$mainpage = 	trim($data->sheets[0]['cells'][$i][11]) ;//  ʶҹл��͡���
						$staffid = trim($data->sheets[0]['cells'][$i][12]) ;//  ���ʾ�ѡ�ҹ
						$status_data = trim($data->sheets[0]['cells'][$i][13]) ;//  ʶҹС��
						$new_idcard = trim($data->sheets[0]['cells'][$i][14]) ;//  �Ţ�ѵ�����
						$birthday = trim($data->sheets[0]['cells'][$i][15]) ;//  �ѹ��͹���Դ
						$begindate = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ�������Ժѵ��Ҫ���
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][17]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][18]) ;// new pic

					}//end if($check_position == "���˹觻Ѩ�غѹ"){
				}else{ // �ʴ�����繿����������Ẻ�������������ç���¹���������
					$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // �Ţ�ѵ�
					$prname_th = trim($data->sheets[0]['cells'][$i][3]) ; // �ӹ�˹�Ҫ���
					$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ����
					$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // ���ʡ��
					
					
					if($check_position == "���˹觻Ѩ�غѹ"){
						$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ���˹�
						$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // �ç���¹
						$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // �����ç���¹
						$page_num = trim($data->sheets[0]['cells'][$i][10]) ;// �ӹǹ���͡���
						$pic_num = trim($data->sheets[0]['cells'][$i][11]) ;//  �ӹǹ�ٻ
						$mainpage = 	trim($data->sheets[0]['cells'][$i][12]) ;//  ʶҹл��͡���
						$staffid = trim($data->sheets[0]['cells'][$i][13]) ;//  ���ʾ�ѡ�ҹ
						$status_data = trim($data->sheets[0]['cells'][$i][14]) ;//  ʶҹС��
						$new_idcard = trim($data->sheets[0]['cells'][$i][15]) ;//  �Ţ�ѵ�����
						$birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ��͹���Դ
						$begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  �ѹ�������Ժѵ��Ҫ���
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][18]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][19]) ;// new pic
					}else{
						$schoolname = trim($data->sheets[0]['cells'][$i][6]) ; // �ç���¹
						$schoolid = trim($data->sheets[0]['cells'][$i][7]) ; // �����ç���¹
						$page_num = trim($data->sheets[0]['cells'][$i][9]) ;// �ӹǹ���͡���
						$pic_num = trim($data->sheets[0]['cells'][$i][10]) ;//  �ӹǹ�ٻ
						$mainpage = 	trim($data->sheets[0]['cells'][$i][11]) ;//  ʶҹл��͡���
						$staffid = trim($data->sheets[0]['cells'][$i][12]) ;//  ���ʾ�ѡ�ҹ
						$status_data = trim($data->sheets[0]['cells'][$i][13]) ;//  ʶҹС��
						$new_idcard = trim($data->sheets[0]['cells'][$i][14]) ;//  �Ţ�ѵ�����
						$birthday = trim($data->sheets[0]['cells'][$i][15]) ;//  �ѹ��͹���Դ
						$begindate = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ�������Ժѵ��Ҫ���
						
						$page_num_new = trim($data->sheets[0]['cells'][$i][17]) ;//new page
						$pic_num_new_cut = trim($data->sheets[0]['cells'][$i][18]) ;// new pic

					}//end if($check_position == "���˹觻Ѩ�غѹ"){

				}//end if($check_column == "�����"){
					
					$sql_find_sex="SELECT
					t1.prename,
					t1.gender_id
					FROM
					hr_prename AS t1
					WHERE t1.prename='$prename_th' ";
					$result_sex=mysql_db_query(DB_MASTER,$sql_find_sex);
					$row_sex=mysql_fetch_assoc($result_sex);
					$sex =$row_sex[gender_id];
					
					
					if($prname_th != ""){
							$conupdate_data .=  " ,prename_th='$prname_th' ";
					}
					if($name_th != ""){
							 $conupdate_data .= " ,name_th='$name_th'";
					}
					if($surname_th != ""){
							 $conupdate_data .= " ,surname_th='$surname_th'";
					}
					if($sex == "1" or $sex == "2"){
							$conupdate_data .= " ,sex='$sex'";
					}
					
					
					
					
				####################  �� log ���͵�Ǩ�ͺ error ������ �ҡ���ŧ list excel
					## ��Ǩ�ͺʶҹС���ջ��͡���
						CleanLogError($idcard,$xsiteid,$profile_id,"1");
						if($mainpage != "" and $mainpage != "0" and $mainpage != "1"){
							SaveErrorDataFromExcel($idcard,$profile_id,$xsiteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,"1",$mainpage);	
						}
					##  ��Ǩ�ͺ˹��§ҹ�ç���¹�������ѹ��Ѻࢵ��鹷�����֡��
						CleanLogError($idcard,$xsiteid,$profile_id,"2");
						if(CheckSchoolFormChecklist($xsiteid,$schoolid) < 1){ // �ʴ���������ç���¹��� upload �������١��ͧ����ç���ҧ��������
							SaveErrorDataFromExcel($idcard,$profile_id,$xsiteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,"2",$mainpage);			
						}// end 	if(CheckSchoolFormChecklist($xsiteid,$schoolid) < 1){ 
				
				
				################## end ����� log ���͵�Ǩ�ͺ error ������ �ҡ���ŧ list excel
				##echo $idcard."::".$prname_th."<br>";	
				
				
					
					
					####  �� temp ������
					InsertTempChecklist($idcard,$xsiteid,$prname_th,$name_th,$surname_th,$profile_id);
					
					if($new_idcard != ""){
						InsertTempChecklist($new_idcard,$xsiteid,$prname_th,$name_th,$surname_th,$profile_id);	
					}// �� � temp ��͹㹡ó�����¹�Ţ�ѵ�
					
				if($staffid == ""){ // �ó����� excel ������к�������
						$staffid = $_SESSION['session_staffid'];
				}
				### end �红����� temp
					#############  �ӡ�õ�Ǩ�ͺ��Ҩ��ա�� update ���ʼ����������
						$conupstaff = StringUpdateStaff($page_num,$idcard,$profile_id,$staffid,$date_upload);
					if($new_idcard != ""){
						$conupstaff = StringUpdateStaff($page_num,$new_idcard,$profile_id,$staffid,$date_upload);	
					}
					
					#### ����͡��������������������
					if($page_num > 15){ $type_doc=0;}else{ $type_doc = 1;}  // 0 ���������  1 ����������
					
					if($position_now != ""){
						$conposition_now = ",position_now='$position_now'";	
					}else{
						$conposition_now = "";
					}
					
					
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // �������ç���¹
						}//end if($schoolid == ""){

					
						if($schoolid != ""){
								$conschool = " ,schoolid='$schoolid'";
						}else{
								$conschool = "";	
						}// if($schoolid != ""){
							
						##############  ��Ǩ�ͺ ��Ҩе�ͧ�ա�� update  �ӹǹ�ٻ���ͨӹǹ��������
						$conupdate_pagepic = CheckUpdatePicPagenum($idcard,$profile_id,$staffupdate,$page_num,$pic_num,$mainpage,$page_num_new,$pic_num_new_cut);
						#echo "$idcard => $profile_id => $staffupdate => $page_num => $pic_num => $mainpage => $page_num_new => $pic_num_new_cut <br>";
						#echo $page_num_new."::".$pic_num_new_cut."<br>";
						#echo $conupdate_pagepic;
						#die;
						###  end ��õ�Ǩ�ͺ ��� update �ӹǹ�ٻ���ͨӹǹ��
						
					
					$len_newid = strlen(intval($new_idcard));
					if($new_idcard != "" and $len_newid == "13"){	
					$arridx1 = CheckIdcardReplace($idcard,$new_idcard,$profile_id);
						if($arridx1[0] == 0){ // �ʴ��������բ����ū��
							if(Check_IDCard($new_idcard)){
								$conupdate_id = " , idcard='$new_idcard'";
								$txtchange_id = " ����¹���Ţ�ѵ� $new_idcard";
							}else{
								$arrchid[] = "�Ţ�ѵ� $new_idcard �ͧ $prname_th$name_th $surname_th ���١��ͧ��������û���ͧ";	
							}// end 	if(Check_IDCard($new_idcard)){
						}else{
								$arrchid[] = "�Ţ�ѵ� $new_idcard �ͧ $prname_th$name_th $surname_th  仫�ӡѺ $arridx1[1]";
						}//end if(CheckIdcardReplace($idcard,$new_idcard,$profile_id) == "0"){
					}//end if($new_idcard != "" and $len_newid == "13"){	
			//echo "$idcard  :: $prname_th  :: $name_th ::  $surname_th :: $schoolid ::  $page_num :: $pic_num :: $mainpage :: $staffid :: $status_data :: $new_idcard :: $begindate :: $position_now ::$conupdate_id ";	
			//echo "<pre>";
			//print_r($arrchid);
			//die; // 3340500080803 :: ��� :: ����� :: ��ǧ�� :: ��ҹ���¾�� :: ��������Ұ :: 7 :: 3 :: 1 :: :: 0 :: 2496-07-08 :: 
					
					$xreturn = ReDataFromChecklist($idcard,$xsiteid,$profile_id);
					if($xreturn == 0){ // �ó�����բ������ checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
						
						$bday1 = CheckBdate($birthday);// �ѹ�Դ
						$bday2 = CheckBdate($begindate);// �ѹ�������Ժѵ��Ҫ���
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ��ͧ����բ����� ���
						$a++;
						
							$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc' $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;
							mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>".__LINE__);
														
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ��Ǩ�ͺ���� update �ҹ������ cmss
							#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
						}
							
					}// end if($xreturn == 0){ // �ó�����բ������ checklist
					
		####################   		��Ǩ�ͺ������
					
					if($status_data == "0"){ // ��� update ʶҹТ�����
						$v++;
						$arrupdate[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid).$txtchange_id;
						
					$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool  $conupdate_id $conupdate_data  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					//echo "sql :: ".$sqlupdata."<br><br>";
					$result_update = mysql_db_query($dbname_temp,$sqlupdata) or die(mysql_error()."$sqlupdata<br>".__LINE__);
					#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
					
					if(!$result_update){
						$sqlupdata1 = "REPLACE INTO tbl_checklist_kp7  SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc',idcard='$idcard',profile_id='$profile_id',siteid='$xsiteid'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool $conupdate_data  ";	
						//echo $sqlupdata1."<br><br>";
						mysql_db_query($dbname_temp,$sqlupdata1) or die(mysql_error()."$sqlupdata1<br>".__LINE__);
						#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
						
						$arrup_replace[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
				
					}//end 	if(!result_update){
					//echo "xxx";die;
			
					insert_log_import($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ �ҡ��� excel","1","$staffid","","","",$profile_id);
					insert_log_checklist_last($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ  �ҡ��� excel","1","$staffid","","","",$profile_id);

												
					
						###########   
						if($new_idcard != ""){ // �ó�����¹�Ţ�ѵ�
							$new_idcard = strlen(intval($new_idcard));
							if($new_idcard == "13"){
								if(Check_IDCard($new_idcard)){ 
								$fullname = "$prname_th$name_th  $surname_th";
									$sql_insert = "REPLACE INTO  temp_change_idcard SET old_idcard='$idcard', new_idcard='".$new_idcard."', siteid='$xsiteid',fullname='$fullname',status_process='0',profile_id='$profile_id',updatetime=NOW(),staffid_change='".$staffid."' ,flag_sendmail='0'";
									mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
								}//end if(Check_IDCard($idcard)){ 	
							}//end if($new_idcard == "13"){
						}//end if($new_idcard != ""){ // �ó�����¹�Ţ�ѵ�
						## end update ������
					}else if($status_data == "1"){ //  ��������������� checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
							
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // �������ç���¹	
						}// end if($schoolid == ""){
						
						$bday1 = CheckBdate($birthday);// �ѹ�Դ
						$bday2 = CheckBdate($begindate);// �ѹ�������Ժѵ��Ҫ���
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ��ͧ����բ����� ���
						$a++;
						
						$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc' $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;
							$result_add = mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
							
							if(!$result_add){
								$sql_add = "REPLACE INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool" ;	
								mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
								
								$arradd_replace[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							}
							
								
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ��Ǩ�ͺ���� update �ҹ������ cmss
							#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
						}else{
								
								$sql_rep = "SELECT *  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid <> '$xsiteid'";
								$result_rep = mysql_db_query($dbname_temp,$sql_rep);
								$rsp3 = mysql_fetch_assoc($result_rep);
								if($rsp3[idcard] == ""){ // �ó� upload 仫�������� excel ��ӡ�� mark ʶҹ�����繡���������������� update ᷹
									$v++;
									$arrupdate[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
									
								$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool $conupdate_data WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					mysql_db_query($dbname_temp,$sqlupdata) or die(mysql_error()."$sqlupdata<br>LINE__".__LINE__);
						
					#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
					insert_log_import($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ �ҡ��� excel","1","$staffid","","","",$profile_id);
					insert_log_checklist_last($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ  �ҡ��� excel","1","$staffid","","","",$profile_id);
					
								}else{ // 㹡�ó���������������� ��Ө�ԧ�
									$k++;
								
								$sql_add = "REPLACE INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff  $conposition_now  $conschool" ;	
								
									mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
									#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
						
									$arrrep[] = "$rsp3[idcard]  $rsp3[prename_th]$rsp3[name_th]  $rsp3[surname_th]   :: ".show_school($rsp3[schoolid])." :: ".ShowAreaSortName($rsp3[siteid]);
								
							$sql_add = "INSERT INTO tbl_checklist_kp7_false SET profile_id='$profile_id', idcard='$idcard', siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$bday1',begindate='$bday2',schoolid='$schoolid',status_IDCARD_REP='REP_CHECKLISTSITE' ";
							mysql_db_query($dbname_temp,$sql_add);
								}
						}//end if($rss[num1] < 1){ 
							
							
					}else if($status_data == "2"){ //  ���ź������� checklist
					$d++;
						$sql_sel4 = "SELECT * FROM  tbl_checklist_kp7 WHERE  idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
						$result_sel4 = mysql_db_query($dbname_temp,$sql_sel4);
						$rs4 = mysql_fetch_assoc($result_sel4);
						$arrdel[] = "$idcard $prename_th$name_th $surname_th";
					
							$sql_del  = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
							mysql_db_query($dbname_temp,$sql_del);
							
							insert_log_import($xsiteid,$idcard,"ź�����źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"ź�����źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
					}elseif($status_data == "3"){
					     $rr++;
						 $sql_count1 = "SELECT COUNT(idcard) as num1 FROM tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid' ";
						 $result_count1 = mysql_db_query($dbname_temp,$sql_count1) or die(mysql_error());
						 $rs_c1 = mysql_fetch_assoc($result_count1);
						 if($rs_c1[num1] > 0){
					     	$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='0',status_file='0',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
						 }else{
							 $sqlupdata = "INSERT INTO tbl_checklist_kp7 SET prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$bday1',begindate='$bday2', status_numfile='0',status_file='0',status_check_file='YES',type_doc='$type_doc',idcard='$idcard',profile_id='$profile_id', siteid='$xsiteid'  $conupdate_pagepic  $conupstaff $conposition_now  $conschool  ";	 
						}
					     mysql_db_query($dbname_temp,$sqlupdata)or die(mysql_error()."$sqlupdata<br>LINE__".__LINE__);
						 #GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
						 $arr_not_re[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
						 
						 
					}else{
						$jj++;
						$arrnon[] =  "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
						
						$xreturn = ReDataFromChecklist($idcard,$xsiteid,$profile_id);
					if($xreturn == 0){ // �ó�����բ������ checklist
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}
						if($schoolid == ""){
							$schoolid = GetSchoolid($xsiteid,$schoolname); // �������ç���¹
						}
						
						$bday1 = CheckBdate($birthday);// �ѹ�Դ
						$bday2 = CheckBdate($begindate);// �ѹ�������Ժѵ��Ҫ���
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ��ͧ����բ����� ���
						$a++;
						
						$arradd[] = "$idcard $prname_th$name_th  $surname_th  ::  ".$schoolname." :: ".ShowAreaSortName($xsiteid);
							
							
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc'  $conupdate_pagepic  $conupstaff" ;
							mysql_db_query($dbname_temp,$sql_add) or die(mysql_error()."$sql_add<br>LINE__".__LINE__);
							#GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
							
						
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ��Ǩ�ͺ���� update �ҹ������ cmss
						}
							
					}// end if($xreturn == 0){ // �ó�����բ������ checklist
					}//end if($status_data == "0"){
			$conupdate_id = "";		
			$txtchange_id = "";
			$conupdate_data = "";
			
		}//end 	for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
		##### �ӡ�õѴ�ʹ������ � checklist ��������� excel 
			//CutOffChecklistKp7($xsiteid,$profile_id);		
		#######  ź������� temp
			//CleanTemp($xsiteid,$profile_id);
				chkUpdateNewCut_ALL($xsiteid);
			
			LogImpExpExcel($xsiteid,$profile_id,"����Ң����� excel ���ͻ�Ѻ��ا������㹡�õ�Ǩ�ͺ�͡��õ鹩�Ѻ",$a,$v,$d);
/*		echo "<center><h3>";
		echo " ��Ѻ��اʶҹ��͡��� �.�. 7 ��к������� $v ��¡��<br> ������������к���Ǩ�ͺ�����ŵ�駵�  $a ��¡��<br>  ź�����źؤ�ҡ��͡�ҡ�к���Ǩ�ͺ�����ŵ�駵� $d ��¡��<br> �������ö���������ͧ�ҡ�����ū����к� checklist  $k  ��¡��" ;
		echo "<br>";
*/		echo "<a href=\"../../../report/report_keydata_main.php?xlv=1&profile_id=$profile_id\" target=\"_blank\">�������͵�Ǩ�ͺ˹����§ҹ</a><br><br></h3></center>";
//echo "end";die;
$arrup = GetPrecessUpload($xsiteid,$profile_id,$_SESSION['session_staffid']);
if(count($arrup > 0)){	
	$xnumall = number_format($arrup['numall']); // �ӹǹ�͡��÷�����
	$xnumpic = number_format($arrup['pic']); // �ӹǹ�ٻ��� up �������
	$xnumpage = number_format($arrup['page']); // �ӹǹ˹��
	$xnumupload = number_format($arrup['upload']);
	$xnumuploadall = number_format($arrup['uploadall']);
	$xnumuploaddiff = number_format($arrup['uploaddiff']);
	$xnum_pic_add = number_format($arrup['pic_add']);
	$xnum_page_add = number_format($arrup['page_add']);
	$xnum_norecive = number_format($arrup['norecive']);

		echo "<script>alert('�š�� upload �͡��� �.�. 7\\n �ӹǹ�͡��÷����� $xnumall �� \\n �ӹǹ�͡��÷����Թ������Ƿ����� $xnumuploadall �� \\n �ӹǹ�͡��ä�ҧ���Թ��� $xnumuploaddiff  �� \\n�ӹǹ�����Թ����� $xnumupload ��  \\n �ӹǹ��� upload �ٻ�Ҿ $xnumpic  �ٻ�Ҿ \\n �ӹǹ���͡��÷����Թ�����  $xnumpage ��\\n �ӹǹ�ٻ���������� $xnum_pic_add �ٻ \\n �ӹǹ�蹷���������  $xnum_page_add  �� \\n �ӹǹ�͡��ä�ҧ�Ѻ  $xnum_norecive  �ش  ');</script>";

}

}


      	$arr_update  = $arrupdate;
		$arr_add = $arradd;
		$arr_del = $arrdel;
		$arr_rep = $arrrep;
		



####  ��Ǩ�ͺ㹡ó��ա�� uplolad ���ͧ��������
$arrrep = CheckUploadReplace($profile_id,$xsiteid);

if(count($arrrep) > 0){ // 㹡ó��ա�� upload �����ū�ӡѹ
echo "<a href='processxls_conf.php?profile_id=$profile_id&xsiteid=$xsiteid' target=\"_blank\">�բ����ū�ӡ�سҤ�����������ѹ������</a>&nbsp;<img src='../../../images_sys/new11.gif' width='26' height='7' border='0'><br>";
}// end if(count($arrrep) > 0){





?>
</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <?
    	if(count($arrchid) > 0){
	?>
         <tr>
           <td colspan="2" bgcolor="#CCCCCC"><strong>ʶҹТ����ŷ��ӡ��ŧ�����¡�����١��ͧ</strong></td>
         </tr>
         <tr>
           <td colspan="2" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
             <tr>
               <td width="5%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
               <td width="63%" align="center" bgcolor="#A5B2CE"><strong>���͹��ʡ��</strong></td>
               <td width="32%" align="center" bgcolor="#A5B2CE"><strong>��Ǵ�ѭ��</strong></td>
             </tr>
             <?
			 $arr_type = GetTypeError();
			 $sql = "SELECT * FROM tbl_checklist_imp_excel_error WHERE siteid='$xsiteid' AND profile_id='$profile_id' ORDER BY name_th ASC";
			 $result = mysql_db_query($dbname_temp,$sql);
			 $n=0;
			 while($rs = mysql_fetch_assoc($result)){
             	if ($n++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 ?>
             <tr bgcolor="<?=$bg?>">
               <td align="center"><?=$n?></td>
               <td align="left"><? echo "$rs[idcard] $rs[prename_th]$rs[name_th] $rs[surname_th] $rs[position_now]";?></td>
               <td align="left"><?=$arr_type[type_error]?></td>
             </tr>
             <?
			 }//end while($rs = mysql_fetch_assoc($result)){
			 ?>
           </table></td>
         </tr>
         <tr>
        <td colspan="2" bgcolor="#CCCCCC"><strong>ʶҹС������¹�Ţ�ѵ����١��ͧ</strong></td>
      </tr>
      <?
      				$iii=0;
			foreach($arrchid as $key_id => $val_id){
				 	if ($iii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

	  ?>
      <tr  bgcolor="<?=$bg?>">
        <td bgcolor="#CCCCCC"><?=$iii?></td>
        <td bgcolor="#CCCCCC"><?=$val_id?></td>
      </tr>
      
      <?
			}//end foreach($arrchid as $key_id => $val_id){
	}// end 	if(count($arrchid) > 0){
	  ?>
      <tr>
        <td colspan="2" bgcolor="#CCCCCC">��Ѻ��اʶҹ��͡��� �.�. 7 ��к������� 
          <? if($v > 0){ echo "$v";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arr_update) > 0){
			$ii=0;
		 foreach($arr_update as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">������������к���Ǩ�ͺ�����ŵ�駵� 
          <? if($a > 0){ echo "$a";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arr_add) > 0){
			$ii=0;
		 foreach($arr_add as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">ź�����źؤ�ҡ��͡�ҡ�к���Ǩ�ͺ�����ŵ�駵�
          <? if($d > 0){ echo "$d";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arr_del) > 0){
			$ii=0;
		 foreach($arr_del as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                
              <tr>
        <td colspan="2" bgcolor="#CCCCCC">�������ö���������ͧ�ҡ�����ū����к� checklist
          <? if($k > 0){ echo "$k";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arr_rep) > 0){
			$ii=0;
		 foreach($arr_rep as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
        
                      <tr>
        <td colspan="2" bgcolor="#CCCCCC"> ������˹�ʶҹС�û�Ѻ��ا������
          <? if($k > 0){ echo "$jj";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arrnon) > 0){
			$ii=0;
		 foreach($arrnon as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arrview) > 0){
		?>
		
		
		
		<tr>
        <td colspan="2" bgcolor="#CCCCCC"> �͡��ä�ҧ�Ѻ
          <? if($rr > 0){ echo "$rr";}else{ echo "0";}  echo " ��¡��";?></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>��¡��</strong></td>
        </tr>
        <?
		if(count($arr_not_re) > 0){
			$ii=0;
		 foreach($arr_not_re as $key => $val){
			 	if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="left"><?=$val?></td>
        </tr>
        <?
		}
	}//end if(count($arr_not_re) > 0)
		?>
		
		

    </table></td>
  </tr>
</table>
<p>&nbsp; </p>
