<?php
session_start();

include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");


global $temp_id;
$dbmaster = "edubkk_master";
$dbcallcenter = "edubkk_userentry";
### begin get data ###
### step 1

### ถ้าระบุ idcard 
unset($where_idcard);
$idcard = intval($idcard);
$where_idcard = $idcard != 0 ? " AND req_problem_person.idcard = '$idcard'" : "";
### 

function ProcessTempData(){
global $dbmaster,$dbcallcenter,$where_idcard;




### modified by sak 2011-08-11 16:25
### ดึงข้อมูลเฉพาะ req_status in(2) (กำลังดำเนินการอยู่)
### ของเดิน req_status in (1,2) (แจ้ง , ดำเนินการอยู่)
$sql_get = "	SELECT 
					* 
				FROM 
					req_problem_person 
					INNER JOIN req_problem 
						ON req_problem_person.req_person_id = req_problem.req_person_id					
				WHERE 
					req_problem_person.req_status IN(2)
					AND NOT idcard IS NULL
					AND TRIM(idcard) <> ''
					AND del <> 1
					AND flag_queue='0'
					$where_idcard
				ORDER BY
					req_problem_person.req_person_id
";

//echo "<pre>";
//echo $sql_get;
//exit;
$res_get = mysql_db_query("edubkk_master",$sql_get);
$new_data_no=0;
$old_data_no=0;
while($row_get = mysql_fetch_assoc($res_get)){
	$id = $row_get[req_person_id];
	if(have_data($id) == false){
		$status_permit = getStatusPermit($row_get[idcard]); #ค้นหา สถานะจาก idcard
		
		if(insert_data($id,$status_permit) == true){
			UpdateFlagQueue($row_get[req_person_id],$row_get[problem_group],$row_get[number_no]); // update รายการที่ทำการดึงข้อมูลมาแล้ว
			$new_data_no+=1;
		}
		//exit;
	} else {
		$old_data_no+=1;
	}
	//exit;
}

### step 2 
insert_log($new_data_no,$old_data_no);

}//end function ProcessTempData(){
### end get data ###

function UpdateFlagQueue($req_person_id,$problem_group,$number_no){
	global $dbnamemaster;
	$sql = "UPDATE  req_problem SET  flag_queue='1' WHERE req_person_id='$req_person_id' AND problem_group='$problem_group' AND number_no='$number_no'";
	mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<hr>LINE::".__LINE__);
		
}//end function UpdateFlagQueue(){

function insert_log($no,$old){
	$sql = "INSERT INTO 
				req_log_wrongdata 
			SET 
				logtime = now(),
				req_person_amt = $no,
				req_person_old = $old
			";
	mysql_db_query("edubkk_master",$sql);
}

function have_data($id){
	$req_person_id = $id;
	$sql = "SELECT
				COUNT(req_person_id) AS cn
			FROM
				req_temp_wrongdata
			WHERE
				req_person_id = '$req_person_id'
	";
	//echo $sql;
	//exit;
	$res = mysql_db_query("edubkk_master",$sql);
	$row = mysql_fetch_assoc($res);
	
	$cnt = $row[cn];
	if($cnt > 0)
		return true;
	else
		return false;
}

function insert_data($id,$status_permit){
	global $temp_id;
	$req_person_id = $id;
	$sql = "INSERT INTO 
				req_temp_wrongdata (req_person_id,problem_type,status_permit,status_req_approve)
					SELECT 
						req_problem_person.req_person_id , 
						req_problem.problem_type,
						'".$status_permit."','1'
					FROM 
						( SELECT * FROM req_problem_person WHERE req_problem_person.req_person_id = '$req_person_id' ) req_problem_person
						INNER JOIN req_problem 
							ON req_problem_person.req_person_id = req_problem.req_person_id
						
			";
//	echo $sql;
//	exit;
	$res = mysql_db_query("edubkk_master",$sql);
	if($res){
		if(mysql_affected_rows() > 0){
			return true;
		}
	} else {
		return false;
	}
}

function getStatusPermit($idcard){
	$sql = "SELECT
				keystaff.staffid,
				keystaff.status_permit,
				keystaff.status_extra
			FROM
				tbl_assign_key
				INNER JOIN tbl_assign_sub 
					ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
				INNER JOIN keystaff 
					ON keystaff.staffid = tbl_assign_sub.staffid
			WHERE
				tbl_assign_key.idcard = '$idcard'
				
				";
				//AND keystaff.status_permit = 'YES'
	$res = mysql_db_query("edubkk_userentry",$sql);
	$row = mysql_fetch_assoc($res);
	//return trim($row[staffid]) != "" ? "YES" : "NO";
	return $row[status_permit]=="YES" && $row[status_extra] == "NOR" ? "YES" : "NO";
}

#################  process 

	ProcessTempData();
?>
