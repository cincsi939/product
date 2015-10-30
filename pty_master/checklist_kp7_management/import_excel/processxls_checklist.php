<?php
/**
* @comment upload ��� excel
* @projectCode 56EDUBKK01
* @tor 7.2
* @package core
* @author Suwat.K 
* @access public/private
* @created 03/06/2014
*/
set_time_limit(0);
$path_config = '../../../';
include("../checklist2.inc.php");
include("function_imp.php");
include("../../pic2cmss/function/function.php");

CreateSiteProfile($xsiteid,$profile_id); // ���ҧ ࢵ profile ������
LogImpExpExcel($xsiteid,$profile_id,"����Ң����� excel �����繢����ŵ�駵�");

require_once 'Excel/reader.php';

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

//$myfile = "8buia4qh";
//echo "AAAAAAAAAAAAAAAAAAAAAAA<br>$myfile<br>
//<a href='upload_tmp/$myfile".".xls''>$myfile</a><br>
//";
$data->read('upload_tmp/'.$myfile.'.xls');
/*echo "$myfile <br>";
echo "<pre>";
print_r($data);*/

if(!count($data->sheets)){
	echo "&error_msg=�������ö��ҹ������������ �Ҩ�繼��Ҩҡ�����١��ͧ �����ٻẺ������١��ͧ";
	die;
}


	
		$setstrartrow = 3;
				
		for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
			
			if(trim($data->sheets[0]['cells'][$i][1]) != ""){ // ��Ǩ�ͺ�Ţ�ѵõ�ͧ����繤����ҧ
			
			$idcard = trim($data->sheets[0]['cells'][$i][2]) ; // �Ţ�ѵ�
			$prename_th = trim($data->sheets[0]['cells'][$i][3]) ; // �ӹ�˹�Ҫ���
			$name_th = trim($data->sheets[0]['cells'][$i][4]) ; // ����
			$surname_th = trim($data->sheets[0]['cells'][$i][5]) ; // ���ʡ��
			$position_now = trim($data->sheets[0]['cells'][$i][6]) ; // ���˹�
			$arr_pos = explode("/",$position_now);
			if(count($arr_pos) > 1){ // �óյ��˹觡�͡�� "/�Է°ҹ�"
				$position_now = $arr_pos[0];
			}// if(count($arr_pos) > 1){
			
			
			$schoolname = trim($data->sheets[0]['cells'][$i][7]) ; // �ç���¹
			$schoolid = trim($data->sheets[0]['cells'][$i][8]) ; // �����ç���¹
			
			if($schoolid == ""){
				$schoolid = GetSchoolid($xsiteid,$schoolname); // �������ç���¹
			}//end if($schoolid == ""){

			
			$temp_birthday = trim($data->sheets[0]['cells'][$i][16]) ;//  �ѹ��͹���Դ
			$temp_begindate = trim($data->sheets[0]['cells'][$i][17]) ;//  �ѹ�������Ժѵ��Ҫ���
			$arr_b = explode("-",$temp_birthday); // arr �ѹ�Դ
			$arr_f = explode("-",$temp_begindate); // arr �ѹ�������Ժѵ��Ҫ���
			$num_ref = trim($data->sheets[0]['cells'][$i][20]) ; // �ӹǹ�͡��ù���
			
			######  �ѹ��͹���Դ ##########################################################
			if(count($arr_b) > 0){
				if($arr_b[2] > 0 and $arr_b[0] < 2000){ // �ʴ�������ٻẺ xx-Jan-xx ��� 02 Oct  59
					$birthday = ($arr_b[2]+1900+543)."-".$arr_text_month["$arr_b[1]"]."-".$arr_b[0];				
				}else if($arr_b[0] > 2000){ // �ʴ�����ٻẺ�ѹ������� excel �� YYYY-mm-dd ���� �� 2502-10-02
					$birthday = $temp_birthday;
				}else{
					$birthday = "0000-00-00";	
				}
						
			}else{
				$birthday = "0000-00-00";
			}//end if(count($arr_b) > 0){
				
		################# �ѹ�������Ժѵ��Ҫ��� ############################################
			if(count($arr_f) > 0){
				if($arr_f[2] > 0 and $arr_f[0] < 2000){ // �ʴ�������ٻẺ xx-Jan-xx ��� 02 Oct  59
					$begindate = ($arr_f[2]+1900+543)."-".$arr_text_month["$arr_f[1]"]."-".$arr_f[0];				
				}else if($arr_f[0] > 2000){ // �ʴ�����ٻẺ�ѹ������� excel �� YYYY-mm-dd ���� �� 2502-10-02
					$begindate = $temp_begindate;
				}else{
					$begindate = "0000-00-00";	
				}
						
			}else{
				$begindate = "0000-00-00";
			}//end if(count($arr_b) > 0){
		######################  end  �ѹ�������Ժѵ��Ҫ���  ###################################
			
			
					//$sex = trim($data->sheets[0]['cells'][$i][21]) ;//  ��
					$sql_find_sex="SELECT
					t1.prename,
					t1.gender_id
					FROM
					hr_prename AS t1
					WHERE t1.prename='$prename_th' ";
					$result_sex=mysql_db_query(DB_MASTER,$sql_find_sex);
					$row_sex=mysql_fetch_assoc($result_sex);
					$sex =$row_sex[gender_id];
					
					if($prename_th != ""){
							$conupdate_data .=  " ,prename_th='$prename_th' ";
					}
					if($name_th != ""){
							 $conupdate_data .= " ,name_th='$name_th'";
					}
					if($surname_th != ""){
							 $conupdate_data .= " ,surname_th='$surname_th'";
					}
					if($position_now != ""){
							$conupdate_data .= " ,position_now='$position_now'";
					}
					
					
					
					
					if(CheckSchoolMathSite($schoolid,$xsiteid) > 0){
							$conupdate_data .= " ,schoolid='$schoolid'";
					}
					
					if($birthday != "" and $birthday != "0000-00-00"){
							$conupdate_data .= " ,birthday='$birthday'";
					}
					if($begindate != "" and $begindate != "0000-00-00"){
							$conupdate_data .= " ,begindate='$begindate'";
					}
					if($sex == "1" or $sex == "2"){
							$conupdate_data .= " ,sex='$sex'";
					}
					
					
					
					#@modify Suwat.K  03/05/2014 ��Ǩ�ͺ������Ţ�ѵ�
					#if((!Check_IDCard($idcard)) or (substr($idcard,0,1) == "0")){
					if((!Check_IDCard($idcard))){
						$conupdate_data .= ",status_id_false='1'";
					}else{
						$conupdate_data .= ",status_id_false='0'";
					}
					# end
					
					$arr_rp = CheckIdReplaceChecklist($xsiteid,$idcard,$profile_id); // ��Ǩ�ͺ�����ū��� checklist
					
					$status_retire = 0;
					if($birthday != "" and $birthday != "0000-00-00"){
						if(ChRetireDate($birthday) == "0"){
							$status_retire = 1;// ���³�����Ҫ�������
						}else{
							$status_retire = 0; // �ѧ������³
						}
					}//end if($birthday != "" and $birthday != "0000-00-00"){


					if($staffid == ""){ // �ó����� excel ������к�������
							$staffid = $_SESSION['session_staffid'];
					}
					### end �红����� temp
					
					if($arr_rp['msg'] == "" and $status_retire == "0"){ // ��Ǩ�ͺ�����ū��� checklist ��辺�����ū��
						$sql_ch1 = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t1.salary,
t1.noposition,
t1.sex,
t1.type_doc,
t1.status_numfile,
t1.status_file,
t1.comment_file,
t1.page_num,
t1.comment_page,
t1.pic_upload,
t1.pic_num,
t1.comment_pic,
t1.mainpage,
t1.mainpage_id,
t1.mainpage_comment,
t1.general_status,
t1.comment_general,
t1.graduate_status,
t1.comment_graduate,
t1.salary_status,
t1.comment_salary,
t1.seminar_status,
t1.comment_seminar,
t1.sheet_status,
t1.comment_sheet,
t1.getroyal_status,
t1.comment_getroyal,
t1.special_status,
t1.comment_special,
t1.goodman_status,
t1.comment_goodman,
t1.absent_status,
t1.comment_absent,
t1.nosalary_status,
t1.comment_nosalary,
t1.prohibit_status,
t1.comment_prohibit,
t1.specialduty_status,
t1.comment_specialduty,
t1.other_status,
t1.comment_other,
t1.status_check_file,
t1.file_upload,
t1.time_update,
t1.status_id_replace,
t1.siteid_replace,
t1.page_upload,
t1.page_upload_log,
t1.status_id_false,
t1.flag_uploadfalse,
t1.problem_status_id,
t1.status_follow_doc,
t1.pic_num_old,
t1.pic_num_new_cut,
t1.page_num_new,
t1.staff_upload_pic,
t1.date_upload_pic,
t1.flag_data_old,
t1.hash_kp7file,
t1.num_ref,
t1.num_actual
FROM
tbl_checklist_kp7 AS t1
 WHERE t1.idcard='$idcard' AND t1.profile_id='$profile_id' AND t1.siteid='$xsiteid'";
						$result_ch1 = mysql_db_query($dbname_temp,$sql_ch1);
						$rsch1 = mysql_fetch_assoc($result_ch1);
						if($rsch1[idcard] != ""){
								$sql_checklist = "UPDATE tbl_checklist_kp7 SET siteid='$xsiteid', num_ref='$num_ref', status_file='1' $conupdate_data    WHERE  idcard='$idcard' AND profile_id='$profile_id'";
						}else{
								$sql_checklist = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard',siteid='$xsiteid',profile_id='$profile_id', num_ref='$num_ref', status_file='1' $conupdate_data ";
						}//end if($rsch1[idcard] != ""){
							
							
							mysql_db_query($dbname_temp,$sql_checklist) or die(mysql_error()."$sql_checklist");
							insert_log_import($xsiteid,$idcard,"���������źؤ�ҡèҡ excel �.18 �����繢����ŵ�駵�","1","$staffid","","","",$profile_id);
							insert_log_checklist_last($xsiteid,$idcard,"���������źؤ�ҡèҡ excel �.18 �����繢����ŵ�駵�","1","$staffid","","","",$profile_id);
							GetNewCutPic($idcard,$profile_id); // update �ӹǹ�ٻ����ͧ�Ѵ����
							
					}else{
							$sql_rep1 = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t1.status_file,
t1.comment_file,
t1.page_num,
t1.comment_page,
t1.pic_num,
t1.comment_pic,
t1.mainpage,
t1.mainpage_comment,
t1.general_status,
t1.comment_general,
t1.graduate_status,
t1.comment_graduate,
t1.salary_status,
t1.comment_salary,
t1.seminar_status,
t1.comment_seminar,
t1.sheet_status,
t1.comment_sheet,
t1.getroyal_status,
t1.comment_getroyal,
t1.special_status,
t1.comment_special,
t1.goodman_status,
t1.comment_goodman,
t1.absent_status,
t1.comment_absent,
t1.nosalary_status,
t1.comment_nosalary,
t1.prohibit_status,
t1.comment_prohibit,
t1.specialduty_status,
t1.comment_specialduty,
t1.other_status,
t1.comment_other,
t1.status_check_file,
t1.file_upload,
t1.time_update,
t1.status_IDCARD,
t1.status_IDCARD_REP,
t1.status_retire,
t1.site_replace,
t1.status_school_fail,
t1.status_position_fail,
t1.conf_replace,
t1.comment_replace,
t1.curent_site,
t1.new_idcard,
t1.status_chang_idcard,
t1.status_id_replace,
t1.siteid_replace,
t1.error_site
FROM
tbl_checklist_kp7_false AS t1
 WHERE t1.idcard='$idcard' AND t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' ";
							$result_rep1 = mysql_db_query($dbname_temp,$sql_rep1);
							$rs_rep1 = mysql_fetch_assoc($result_rep1);
							if($rs_rep1[idcard] == ""){
							$sql_checklist_rep  = "INSERT INTO tbl_checklist_kp7_false SET profile_id='$profile_id', idcard='$idcard', siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th', surname_th='$surname_th', birthday='$birthday',begindate='$begindate',position_now='$position_now',schoolid='$schoolid',site_replace='".$arr_rp['siteid']."', status_retire='$status_retire',status_IDCARD_REP='".$arr_rp['msg']."' ";
							mysql_db_query($dbname_temp,$sql_checklist_rep) or die(mysql_error()."$sql_checklist_rep");
							}//end if($rs_rep1[idcard] == ""){
					}// end if($arr_rp['msg'] != ""){if($arr_rp['msg'] != ""){ // ��Ǩ�ͺ�����ū��� checklis

$conupdate_data="";

		}//end if(trim($data->sheets[0]['cells'][$i][1]) != ""){
	}// end for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
chkUpdateNewCut_ALL($xsiteid);
echo "<script language=\"javascript\"> alert('����Ң����ŵ�駵����º�������ǡ�سҵ�Ǩ�ͺ�����ū�������ª��͡�����³�����Ҫ���');
window.opener.location='../../hr3/import_dbf_pobec_checklist/list_area_import_check.php?profile_id=$profile_id';
window.close();
</script>
";

}//	if($process=="execute"){	




?>

