<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

echo "CLOSE";die;


include("../../common/common_competency.inc.php");
include("../../common/function_getsite_continue.php");
include("checklist2.inc.php");
$file_name = basename($_SERVER['PHP_SELF']);
$time_start = getmicrotime();
############################  start ###########################
function GetFieldTableChecklist($tbl){
	global $dbname_temp;
		$infield = "";
		$sql = "SHOW COLUMNS FROM  $tbl  WHERE  Extra NOT LIKE '%auto_increment%'";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				if($infield > "") $infield .= ",";
				$infield .= "$rs[Field]";
		}// end 	while($rs = mysql_fetch_assoc($result)){
		return $infield;
}// end function GetFieldTableChecklist($tbl){






if($xsiteid != ""){
	$consite = " AND t1.site_area='$xsiteid'";
}else{
	$consite	 = "";
}

$yy = date("Y");
$date1 = $yy."-04-01";
$date2 = $yy."-10-01";
$date2_1 = ($yy-1)."-10-01"; // วันที่ย้อนหลังของเดือนตุลาคม
$cdate = date("Y-m-d"); // วันที่ปัจจุบัน
if($cdate >= $date1 and $cdate < $date2 ){ // ข้อมูลเมษายนของปีนั้น
		$datep = $date1;
}else if($cdate >= $date2){ # ข้อมูลรอบตุลาคม
		$datep = $date2;
}else if($cdate < $date1){
		$datep = $date2_1;
}

$sql_profile = "SELECT profile_date,profile_id FROM tbl_checklist_profile WHERE profile_date='$datep' ";
$result_profile = mysql_db_query($dbname_temp,$sql_profile) or die(mysql_error()."$sql_profile<br>LINE__".__LINE__);
$rsp = mysql_fetch_assoc($result_profile);
if($rsp[profile_id] != ""){
		$profile_id = $rsp[profile_id];
}else{
	$sql_maxorder = "SELECT MAX(orderby) AS maxorder FROM tbl_checklist_profile ";
	$result_maxorder = mysql_db_query($dbname_temp,$sql_maxorder);
	$rsm = mysql_fetch_assoc($result_maxorder);
	$sql_insert = "INSERT INTO tbl_checklist_profile SET profilename='ข้อมูล ณ วันที่".thai_date($datep)."',profilename_short='".thai_date($datep)."',profile_date='$datep',profile_comment='โฟรไฟล์อัตโนมัติที่สร้างขึ้นจากการซิงข้อมูลจาก Cmss สู่ Checklist',status_active='1',status_update='1',orderby='".($rsm[maxorder]+1)."' ";	
	mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
	$profile_id = mysql_insert_id();// profile_ล่าสุด
}


//echo "$profile_id";
//echo "END";die;
	$sql = "SELECT 	t1.site_area AS siteid 	FROM 	callcenter_entry.keystaff AS t1
	Inner Join $dbnamemaster.eduarea as t2 ON t1.site_area = t2.secid
	WHERE 	t1.status_permit =  'YES' $consite 	GROUP BY 	t1.site_area 	ORDER BY t2.secname ASC";
	//echo $sql;die;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$db_site = "cmss_".$rs[siteid];
		##############  ตรวจสอบข้อมูลใน eduarea_config
				$sql_conf = "SELECT * FROM eduarea_config WHERE profile_id='$profile_id' and site='$rs[siteid]' AND group_type='keydata'";
				$result_conf = mysql_db_query($dbnamemaster,$sql_conf);
				$rsconf = mysql_fetch_assoc($result_conf);
				if($rsconf[profile_id] == ""){
						$sql_intconf = "INSERT INTO eduarea_config SET group_type='keydata',site='$rs[siteid]', keydata_active='1', profile_id='$profile_id',timeupdate=NOW() ";
						mysql_db_query($dbnamemaster,$sql_intconf) or die(mysql_error()."".__LINE__);
				}

		
		
			#############  ข้อมูลแต่ละเขต
		$sql1 = "SELECT t2.CZ_ID as idcard,t2.siteid,t2.prename_th,t2.name_th,t2.surname_th,t2.birthday,t2.begindate,t2.gender_id as sex,t2.position_now,t2.schoolid,t2.schoolname  FROM edubkk_checklist.tbl_checklist_kp7 as t1 
RIGHT JOIN $dbnamemaster.view_general as t2 ON t1.idcard=t2.CZ_ID and t1.siteid=t2.siteid and t1.siteid='$rs[siteid]' and t1.profile_id='$profile_id'  
WHERE t2.siteid='$rs[siteid]' and t1.idcard IS NULL";
		$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
		while($rs1 = mysql_fetch_assoc($result1)){
			$sql_c1 = "SELECT  page_num,pic_num,page_upload,pic_upload FROM tbl_checklist_kp7 WHERE idcard='$rs1[idcard]' ORDER BY profile_id DESC LIMIT 1 ";
			$result_c1 = mysql_db_query($dbname_temp,$sql_c1) or die(mysql_error()."$sql_c1<br>LINE__".__LINE__);
			$rsc1 = mysql_fetch_assoc($result_c1);
			## หาข้อมูลรูปในเขต
			$sql_pic  = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$rs1[idcard]' and kp7_active='1' GROUP BY id";
			$result_pic = mysql_db_query($db_site,$sql_pic) or die(mysql_error()."".__LINE__);
			$rspic = mysql_fetch_assoc($result_pic);
			if($rspic[numpic] > 0){
					$pic_num = $rspic[numpic];
					$pic_upload = $rspic[numpic];
			}else{
					$pic_num = $rsc1[pic_num];
					$pic_upload = $rsc1[pic_upload];	
			}
			
			$sql_insert_checklist = "REPLACE INTO tbl_checklist_kp7 SET profile_id='$profile_id',idcard='$rs1[idcard]',siteid='$rs1[siteid]',prename_th='$rs1[prename_th]',name_th='$rs1[name_th]',surname_th='$rs1[surname_th]',birthday='$rs1[birthday]',begindate='$rs1[begindate]',sex='$rs1[sex]',position_now='$rs1[position_now]',schoolid='$rs1[schoolid]',type_doc='1',status_numfile='1',status_file='1',page_num='$rsc1[page_num]',pic_num='$pic_num',page_upload='$rsc1[page_upload]',pic_upload='$pic_upload',mainpage='1',status_check_file='YES',general_status='1',graduate_status='1',salary_status='1',seminar_status='1',sheet_status='1',getroyal_status='1',special_status='1',goodman_status='1',absent_status='1',nosalary_status='1',prohibit_status='1',specialduty_status='1',other_status='1'  ";
			//echo $sql_insert_checklist;die;
			$result_insert_checklist  = mysql_db_query($dbname_temp,$sql_insert_checklist) or die(mysql_error()."$sql_insert_checklist<br>LINE__".__LINE__);
			if($result_insert_checklist){
					$sql_temp = "REPLACE INTO  tbl_check_data SET idcard='$rs1[idcard]',profile_id='$profile_id',secid='$rs1[siteid]',prename_th='$rs1[prename_th]',name_th='$rs1[name_th]',surname_th='$rs1[surname_th]',sex='$rs1[sex]',birthday='$rs1[birthday]',begindate='$rs1[begindate]',schoolid='$rs1[schoolid]',position_now='$rs1[position_now]',dateposition_now='2553-10-01',schoolname='$rs1[schoolname]',status_compare='OK',status_idcard='YES',timeupdate=NOW(),status_file_scan='1',status_tranfer_filekp7='1',status_tranfer_data='1',idcard_structure='1'";
					mysql_db_query($dbname_temp,$sql_temp) or die(mysql_error()."$sql_temp<br>LINE__".__LINE__);
					$sql_log = "INSERT INTO tbl_checklist_log_synchronize SET idcard='$rs1[idcard]',siteid='$rs1[siteid]',profile_id='$profile_id',prename_th='$rs1[prename_th]',name_th='$rs1[name_th]',surname_th='$rs1[surname_th]',schoolid='$rs1[schoolid]',position_now='$rs1[position_now]',timeupdate=NOW()";
					$result_log = mysql_db_query($dbname_temp,$sql_log) or die(mysql_error()."$sql_log<br>LINE__".__LINE__);
			}
			
		}//end while($rs1 = mysql_fetch_assoc($result1)){
		############### end ข้อมูลรายเขต
			
	}// end while($rs = mysql_fetch_assoc($result)){
		
	$in_site = GetSiteContinue(); // เขตต่อเนื่อง
	function SaveTempChecklist($idcard,$siteid,$profile_id){
		global $dbname_temp;
		$sql = "REPLACE INTO tbl_checklist_kp7_1log_delete (".GetFieldTableChecklist("tbl_checklist_kp7_1log_delete").") SELECT ".GetFieldTableChecklist("tbl_checklist_kp7")." FROM tbl_checklist_kp7 WHERE idcard='$idcard' and siteid='$siteid' AND profile_id='$profile_id'";	
		//echo "<hr>".$sql."<hr>";
		mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	}
	#### ตรวจสอบว่าอยู่ใน 48 เขตรึเปล่า
	function GetPersonAreaContinue($idcard){
		global $dbnamemaster;
		$sql = "SELECT COUNT(CZ_ID) AS num1,siteid FROM view_general WHERE CZ_ID='$idcard' and siteid IN(".GetSiteContinue().") GROUP BY siteid";	
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[$rs[siteid]] = $rs[num1];
	}
	
	####  update ให้เป็นข้อมูลของ 48 เขตต่อเนื่อง
	function UpdateChecklistTranferSite($idcard,$profile_id,$site_new){
			global $dbname_temp;
			$sql = "UPDATE tbl_checklist_kp7 SET siteid='$site_new' WHERE idcard='$idcard' AND profile_id='$profile_id'";
			$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
	}
	
#### ลบข้อมูลที่ไม่มีใน cmss ใน 48 เขต
	function DeleteChecklistAreaContinute($idcard,$siteid,$profile_id){
		global $dbname_temp;
		$sql = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$siteid' AND profile_id='$profile_id' ";	
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	}

	
	########### ดึงข้อมูลจาก updateข้อมูลใน checklist กรณีข้อมูลย้ายออกภายใน 48 เขต หรือเกษียณ
	$sql_edu = "SELECT 	t1.site_area AS siteid 	FROM 	callcenter_entry.keystaff AS t1
	Inner Join $dbnamemaster.eduarea as t2 ON t1.site_area = t2.secid
	WHERE 	t1.status_permit =  'YES' $consite 	GROUP BY 	t1.site_area 	ORDER BY t2.secname ASC";
	$result_edu = mysql_db_query($dbnameuse,$sql_edu) or die(mysql_error()."".__LINE__);
	while($rse = mysql_fetch_assoc($result_edu)){
			$sql_ch = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th
FROM edubkk_checklist.tbl_checklist_kp7 as t1 
Left JOIN $dbnamemaster.view_general as t2 ON t1.idcard=t2.CZ_ID and t1.siteid=t2.siteid and t2.siteid='$rse[siteid]' 
WHERE t1.siteid='$rse[siteid]' and t1.profile_id='$profile_id' and t2.CZ_ID IS NULL";
#echo $sql_ch."<br>";
			$result_ch = mysql_db_query($dbname_temp,$sql_ch) or die(mysql_error()."$sql_ch<br>LINE__".__LINE__);
			while($rsc = mysql_fetch_assoc($result_ch)){
				$arrch = GetPersonAreaContinue($rsc[idcard]);
				#echo "ข้อมูล :: <pre>";
				#print_r($arrch); 
				if(count($arrch) > 0){
					foreach($arrch as $key => $val){
							if($val < 1){ // ไม่มีใน 48 เขต .ให้ลบ
									SaveTempChecklist($rsc[idcard],$rsc[siteid],$rsc[profile_id]); // เก็บข้อมูลไว้ใน temp
									DeleteChecklistAreaContinute($rsc[idcard],$rsc[siteid],$rsc[profile_id]);// ลบข้อมูลที่ไม่อยู่ใน 48 เขตออกไปจาก checklist
							}else{
									UpdateChecklistTranferSite($rsc[idcard],$rsc[profile_id],$key);// update ย้ายไปอยู่อีกเขตที่เป็น 48 เขต	
							}
					}//end foreach($arrch as $key => $val){
				}else{
									SaveTempChecklist($rsc[idcard],$rsc[siteid],$rsc[profile_id]); // เก็บข้อมูลไว้ใน temp
									DeleteChecklistAreaContinute($rsc[idcard],$rsc[siteid],$rsc[profile_id]);// ลบข้อมูลที่ไม่อยู่ใน 48 เขตออกไปจาก checklist	
				}// end 	if(count($arrch) > 0){
			}// end while($rsc = mysql_fetch_assoc($result_ch)){
	}//end while($rse = mysql_fetch_assoc($result_edu)){
	
	echo "DONE....";
############################ end ###########################
$time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
