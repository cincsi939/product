<?php
set_time_limit(0);
include("../checklist2.inc.php");
include("function_imp.php");
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
				
		$check_column = $data->sheets[0]['cells'][2][7];
		
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
					$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // �Ţ�ѵ�
					$prname_th = trim($data->sheets[0]['cells'][$i][3]) ; // �ӹ�˹�Ҫ���
					$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ����
					$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // ���ʡ��
					$schoolname = trim($data->sheets[0]['cells'][$i][6]) ; // �ç���¹
					$schoolid =  trim($data->sheets[0]['cells'][$i][7]) ; // �����ç���¹
					$page_num = trim($data->sheets[0]['cells'][$i][9]) ;// �ӹǹ���͡���
					$pic_num = trim($data->sheets[0]['cells'][$i][10]) ;//  �ӹǹ�ٻ
					$mainpage = 	trim($data->sheets[0]['cells'][$i][11]) ;//  ʶҹл��͡���
					$staffid = trim($data->sheets[0]['cells'][$i][12]) ;//  ���ʾ�ѡ�ҹ
					$status_data = trim($data->sheets[0]['cells'][$i][13]) ;//  ʶҹС��
					$new_idcard = trim($data->sheets[0]['cells'][$i][14]) ;//  �Ţ�ѵ�����
					//$birthday = trim($data->sheets[0]['cells'][$i][15]) ;//  �ѹ��͹���Դ
					$positon_now = trim($data->sheets[0]['cells'][$i][15]) ;
					//$begindate = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ�������Ժѵ��Ҫ���
					
					
							if(!Check_IDCard($idcard)){ // 
								$xstatus_id_false = 1;	
							}else{
								$xstatus_id_false = 0;	
							}

						
							
							if($page_num > 15){ $type_doc=0;}else{ $type_doc = 1;}
							$sql_add = "REPLACE INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$xsiteid', prename_th='$prname_th',name_th='$name_th',surname_th='$surname_th',schoolid='$schoolid',profile_id='$profile_id',birthday='$bday1',begindate='$bday2',status_id_false='$xstatus_id_false',status_numfile='1',status_file='1',status_check_file='YES',type_doc='$type_doc',page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage',position_now='$positon_now'" ;
							echo "$sql_add;<br>";
							mysql_db_query($dbname_temp,$sql_add);
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ����� excel","1","$staffid","","","",$profile_id);
							UpdateDataCmss($xsiteid,$idcard,$schoolid);// ��Ǩ�ͺ���� update �ҹ������ cmss
					
			
		}//end 	for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
/*		#########  �ӡ��ź�������͡�ҡ checklist ������ç�Ѻ excel
		$sql_kp7 = "SELECT tbl_checklist_kp7.idcard,tbl_checklist_kp7.siteid,tbl_checklist_kp7.profile_id FROM tbl_checklist_kp7 Left Join tbl_checklist_kp7_temp ON tbl_checklist_kp7.idcard = tbl_checklist_kp7_temp.idcard
WHERE tbl_checklist_kp7_temp.idcard IS NULL  AND tbl_checklist_kp7.profile_id =  '$profile_id' AND tbl_checklist_kp7.siteid =  '$xsiteid'";
		$result_kp7 = mysql_db_query($dbname_temp,$sql_kp7);
		while($rs7 = mysql_fetch_assoc($result_kp7)){
			LogDeleteChecklistkp7($rs7[idcard],$rs7[siteid],$rs7[profile_id]); // �� log ���ź
			### ź������� checklist
			$sql_delkp7 = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$rs7[idcard]' AND siteid='$rs7[siteid]' AND profile_id='$rs7[profile_id]' ";
			mysql_db_query($dbname_temp,$sql_delkp7);
			
				
		}//end while($rskp7 = mysql_fetch_assoc($result_kp7)){
		
		#######  ź������� temp
			CleanTemp($xsiteid);
			
			LogImpExpExcel($xsiteid,$profile_id,"����Ң����� excel ���ͻ�Ѻ��ا������㹡�õ�Ǩ�ͺ�͡��õ鹩�Ѻ",$a,$v,$d);
*//*		echo "<center><h3>";
		echo " ��Ѻ��اʶҹ��͡��� �.�. 7 ��к������� $v ��¡��<br> ������������к���Ǩ�ͺ�����ŵ�駵�  $a ��¡��<br>  ź�����źؤ�ҡ��͡�ҡ�к���Ǩ�ͺ�����ŵ�駵� $d ��¡��<br> �������ö���������ͧ�ҡ�����ū����к� checklist  $k  ��¡��" ;
		echo "<br>";
*/		
	echo "<a href=\"../../../report/report_keydata_main.php?xlv=1&profile_id=$profile_id\" target=\"_blank\">�������͵�Ǩ�ͺ˹����§ҹ</a><br><br></h3></center>";
}



		

?>
