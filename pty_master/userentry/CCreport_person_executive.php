<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานข้อมูลบุคลากรในกลุ่มผู้บริหารและเจ้าหน้าที่ประจำเขต
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
set_time_limit(0);
include "epm.inc.php";

	### ทำการลบข้อมูลการจัดเก็บใน temp
	mysql_db_query($dbnamemaster,"DELETE FROM view_person_executive");
	### เก็บข้อมูลบุคลากรในเขต
		$sql_insert = "REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,pid,schoolid)
		SELECT
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.pid,
t1.schoolid
FROM
view_general AS t1
Inner Join eduarea AS t2 ON t1.schoolid = t2.secid";
	mysql_db_query($dbnamemaster,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
	
## เก็บข้อมูลผู้บริหารโรงเรียน
$sql_insert1 = "REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,pid,schoolid)
SELECT
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.pid,
t1.schoolid
FROM
view_general AS t1
WHERE
t1.pid IN('325001002','325001003','325001005','325001006','325001007','325001010','325471008','325471009','325471012','325471013','325481014','325481015')
";
mysql_db_query($dbnamemaster,$sql_insert1) or die(mysql_error()."".__LINE__);

### ข้อมูลใน checklist ที่ไม่มีใน cmss
$sql_insert2 = " REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_data) 
SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,0
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join  ".DB_MASTER.".eduarea AS t3 ON t2.schoolid = t3.secid
GROUP BY
t1.idcard
";
mysql_db_query($dbnamemaster,$sql_insert2) or die(mysql_error()."$sql_insert2<br>LINE__".__LINE__);

########### ข้อมูลผู้บริหารสถานศึกษา
$sql_insert3 = " REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_data) 
SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,0
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
where t2.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการสถานศึกษา','ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','รองผู้อำนวยการสถานศึกษา','ผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการวิทยาลัย','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ')
GROUP BY
t1.idcard";
mysql_db_query($dbnamemaster,$sql_insert3) or die(mysql_error()."$sql_insert3<br>LINE__".__LINE__);


############  update ข้อมูล 

$sqlmain = "SELECT
t1.idcard,
t1.siteid,
t1.pid,
t1.position_now
FROM
view_person_executive AS t1
WHERE
t1.status_process =  '0'";
$resultmain = mysql_db_query($dbnamemaster,$sqlmain) or die(mysql_error()."$sqlmain<br>LINE__".__LINE__);
while($rsm = mysql_fetch_assoc($resultmain)){
	
	### ตรวจสอบการ QC 
	
	$sql_qc = "SELECT count(idcard) as numqc FROM `validate_checkdata` where idcard='$rsm[idcard]' group by idcard;";
	$result_qc = mysql_db_query($dbnameuse,$sql_qc) or die(mysql_error()."$sql_qc<br>LINE__".__LINE__);
	$rs_qc = mysql_fetch_assoc($result_qc);
	if($rs_qc[numqc] > 0){
			$status_qc = "1";
	}else{
			$status_qc = "0";
	}
	
	### ตรวจสอบการยื่นคำร้อง
	$sql_req = "SELECT count(idcard) as num_req  FROM `req_problem_person` where idcard='$rsm[idcard]' group by idcard;";
	$result_req = mysql_db_query($dbnamemaster,$sql_req) or die(mysql_error()."$sql_req<br>LINE__".__LINE__);
	$rs_req = mysql_fetch_assoc($result_req);
	if($rs_req[num_req] > 0){
			$status_send_req = "1";
	}else{
			$status_send_req = "0";	
	}
	
	if($rsm[pid] == ""){ 
			$sqlpid = "SELECT t1.pid FROM hr_addposition_now AS t1 WHERE t1.`position` =  '$rsm[position_now]' ";
			$resultpid= mysql_db_query($dbnamemaster,$sqlpid) or die(mysql_error()."$sqlpid<br>LINE__".__LINE__);
			$rspid = mysql_fetch_assoc($resultpid);
			$update_pid = ",pid='$rspid[pid]'";
	}else{
			$update_pid = " ";	
	}//end if($rsm[pid] == ""){
		
	# update ข้อมูล
	
	$sql_up = "UPDATE view_person_executive SET status_qc='$status_qc',status_send_req='$status_send_req',status_process='1',timeupdate=NOW() $update_pid  WHERE idcard='$rsm[idcard]' ";
	mysql_db_query($dbnamemaster,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
	
		
}//end while($rsm = mysql_fetch_assoc($resultmain)){

	
	
echo "Done....";			
?>