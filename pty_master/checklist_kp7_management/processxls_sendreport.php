<?php
set_time_limit(0);
include("../checklist2.inc.php");

$get = mysql_fetch_assoc(mysql_db_query(DB_USERENTRY,"SELECT staffid FROM keystaff WHERE username='$username' AND password='$password' "));
$staffid = $get['staffid'];
if($staffid==""){
	echo "<script>alert('Username ����  Password �Դ��Ҵ');window.location='send_report_day.php'</script>";
	exit();
}
?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
</HEAD>
<BODY bgcolor="#A5B2CE">

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
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
					
					$idcard = $data->sheets[0]['cells'][$i][2] ; // �Ţ�ѵ�
					$prname_th = $data->sheets[0]['cells'][$i][3] ; // �ӹ�˹�Ҫ���
					$name_th = $data->sheets[0]['cells'][$i][4] ; // ����
					$surname_th = $data->sheets[0]['cells'][$i][5] ; // ���ʡ��
					$schoolname = $data->sheets[0]['cells'][$i][6] ; // �ç���¹
					$page_num = $data->sheets[0]['cells'][$i][8] ;// �ӹǹ���͡���
					$pic_num = $data->sheets[0]['cells'][$i][9] ;//  �ӹǹ�ٻ
					$mainpage = 	$data->sheets[0]['cells'][$i][10] ;//  ʶҹл��͡���
					$staffid = $data->sheets[0]['cells'][$i][11] ;//  ���ʾ�ѡ�ҹ
					$status_data = $data->sheets[0]['cells'][$i][12] ;//  ʶҹС��
					$new_idcard = $data->sheets[0]['cells'][$i][13] ;//  �Ţ�ѵ�����
					$birthday = $data->sheets[0]['cells'][$i][14] ;//  �ѹ��͹���Դ
					$begindate = $data->sheets[0]['cells'][$i][15] ;//  �ѹ�������Ժѵ��Ҫ���
					
					if($status_data == "0"){ // ��� update ʶҹТ�����
						if($page_num > 15){ $type_doc=0;}else{ $type_doc = 1;}
						$v++;
					
					$sqlupdata = "UPDATE tbl_checklist_kp7 SET status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc',page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage'  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					mysql_db_query($dbname_temp,$sqlupdata);
					insert_log_import($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ �ҡ��� excel","1","$staffid","","","",$profile_id);
					insert_log_checklist_last($xsiteid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ  �ҡ��� excel","1","$staffid","","","",$profile_id);
						###########   
						if($new_idcard != ""){ // �ó�����¹�Ţ�ѵ�
							$new_idcard = strlen(intval($new_idcard));
							if($new_idcard == "13"){
								if(Check_IDCard($new_idcard)){ 
								$fullname = "$prname_th$name_th  $surname_th";
									$sql_insert = "REPLACE INTO  temp_change_idcard SET old_idcard='$idcard', new_idcard='".$new_idcard."', siteid='$xsiteid',fullname='$fullname',status_process='0',profile_id='$profile_id',updatetime=NOW(),staffid_change='".$staffid."' ,flag_sendmail='0'";
									mysql_db_query($dbname_temp,$sql_insert);
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
						$schoolid = GetSchoolid($xsiteid,$schoolname); // �������ç���¹
						$bday1 = CheckBdate($birthday);// �ѹ�Դ
						$bday2 = CheckBdate($begindate);// �ѹ�������Ժѵ��Ҫ���
						$sql_select = "SELECT COUNT(idcard) AS num1  FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
						$result_select = mysql_db_query($dbname_temp,$sql_select);
						$rss = mysql_fetch_assoc($result_select);
						if($rss[num1] < 1){ // ��ͧ����բ����� ���
						$a++;
							if($page_num > 15){ $type_doc=0;}else{ $type_doc = 1;}
							$sql_add = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',schoolid='$schoolid',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc',page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage'" ;
							mysql_db_query($dbname_temp,$sql_add);
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ��Ǩ�ͺ���� update �ҹ������ cmss
						}else{
								$k++;
							$sql_add = "INSERT INTO tbl_checklist_kp7_false SET profile_id='$profile_id', idcard='$idcard', siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th', surname_th='surname_th', birthday='$bday1',begindate='$bday2',schoolid='$schoolid',status_IDCARD_REP='REP_CHECKLISTSITE' ";
							mysql_db_query($dbname_temp,$sql_add);
						}//end if($rss[num1] < 1){ 
							
							
					}else if($status_data == "2"){ //  ���ź������� checklist
					$d++;
						$sql_del  = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$xsiteid'";
						mysql_db_query($dbname_temp,$sql_del);
							insert_log_import($xsiteid,$idcard,"ź�����źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"ź�����źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
					}//end if($status_data == "0"){
					
			
		}//end 	for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
		echo "<center><h3>";
		echo " ��Ѻ��اʶҹ��͡��� �.�. 7 ��к������� $v ��¡��<br> ������������к���Ǩ�ͺ�����ŵ�駵�  $a ��¡��<br>  ź�����źؤ�ҡ��͡�ҡ�к���Ǩ�ͺ�����ŵ�駵� $d ��¡��<br> �������ö���������ͧ�ҡ�����ū����к� checklist  $k  ��¡��" ;
		echo "<br>";
		echo "<a href=\"../../../../report/report_keydata_main.php?xlv=1&profile_id=$profile_id\" target=\"_blank\">�������͵�Ǩ�ͺ˹����§ҹ</a><br><br></h3></center>";
}

?>