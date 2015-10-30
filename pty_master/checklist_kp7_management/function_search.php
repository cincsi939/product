<?
function DateReciveDoc($idcard,$profile_id,$tdoc=""){
	global $dbname_temp;
	if($tdoc == ""){
		$sel = " min(time_update) as time1";
	}else{
		$sel = " max(time_update) as time1";	
	}
	$sql = "SELECT $sel ,user_save,user_update  FROM `tbl_checklist_log` where idcard='$idcard' and profile_id='$profile_id' AND type_action='1' AND action_data LIKE '%บันทึกตรวจสอบเอกสาร%'";	
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[user_save] != ""){
			$arr['user'] = show_user($rs[user_save]);
	}else{
			$arr['user'] = show_user($rs[user_update]);
	}
		$arr['time'] = get_dateThai($rs[time1]);
		
		//echo "<pre>";
	//	print_r($arr);
	return $arr;
	
}//end function DateReciveDoc($idcard,$profile_id,$tdoc=""){
	

	
function DateAssign($idcard,$profile_id){
		global $dbcallcenter_entry;
		$sql = "SELECT
	tbl_assign_key.idcard,
	tbl_assign_key.siteid,
	tbl_assign_key.approve,
	tbl_assign_key.comment_approve,
	tbl_assign_key.update_time,
	tbl_assign_key.staff_apporve,
	tbl_assign_sub.assign_date,
	tbl_assign_sub.staffid,
	tbl_assign_sub.admin_id
	FROM
	tbl_assign_sub
	Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
	WHERE
	tbl_assign_key.idcard =  '$idcard' AND
	tbl_assign_key.profile_id =  '$profile_id'";	
		
	$result = mysql_db_query($dbcallcenter_entry,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['dateassign'] = get_dateThai($rs[assign_date],"T");
	$arr['staff_key'] = show_user($rs[staffid]);
		$sql_key = "SELECT
monitor_keyin.timeupdate,
monitor_keyin.timestamp_key,
monitor_keyin.timeupdate_user
FROM `monitor_keyin`
WHERE `staffid` LIKE '$rs[staffid]' AND `idcard` LIKE '$idcard'
ORDER BY timestamp_key desc LIMIT 0,1";
	$result_key = mysql_db_query($dbcallcenter_entry,$sql_key);
	$rskey = mysql_fetch_assoc($result_key);
	if($rskey[timeupdate_user] != "" and $rskey[timeupdate_user] != "0000-00-00 00:00:00"){
		$datekey = $rskey[timeupdate_user];
	}else if($rskey[timestamp_key] != "" and $rskey[timestamp_key] != "0000-00-00 00:00:00"){
		$datekey = $rskey[timestamp_key];
	}

	$arr['datecomp'] = get_dateThai($datekey,"T");
	$arr['dateapprove'] =  get_dateThai($rs[update_time],"T");
	$arr['staff_approve'] =  show_user($rs[admin_id]);
	if($rs[approve] == "2" and $rs[comment_approve] == "รับรองอัตโนมัติโดยระบบ"){
		$arr['comment_approve'] = "รับรองโดยระบบ";
	}else if($rs[approve] == "2" and $rs[comment_approve] != "รับรองอัตโนมัติโดยระบบ"){
		$arr['comment_approve'] = "รับรองโดยพนักงาน";
	}//end  if($rs[approve] == "2" and $rs[comment_approve] == "รับรองอัตโนมัติโดยระบบ"){ รับรองอัตโนมัติโดยระบบ
	
	
	
	
return $arr;
}//end function DateAssign($idcard,$profile_id){
	
function SearchGetQcKp7($idcard,$profile_id){
	global $dbnameuse;
	$sql = "SELECT
concat(t4.prename,
t4.staffname,' ',
t4.staffsurname) as fullname,
t3.qc_date as dateqc
FROM
tbl_assign_key AS t1
Inner Join tbl_assign_sub AS t2 ON t2.ticketid = t1.ticketid
Inner Join validate_checkdata AS t3 ON t1.idcard = t3.idcard
Inner Join keystaff AS t4 ON t3.qc_staffid = t4.staffid
where t1.idcard='$idcard' and t1.profile_id='$profile_id'
group by t1.idcard";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr['fullname']	 = $rs[fullname];
		$arr['dateqc'] = get_dateThai($rs[dateqc],"T");
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function SearchGetQcKp7($idcard,$profile_id){
	

function DateUploadFile($idcard,$profile_id){
	global $dbname_temp;
	
		$sql = " SELECT max(time_update) as time1,staff_upload FROM tbl_checklist_log_upkp7file WHERE idcard='$idcard' AND profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[time1] != "" and $rs[time1] != "0000-00-00 00:00:00"){
			$arr['staff_upload'] = show_user($rs[staff_upload]);
			$arr['date_upload'] =get_dateThai($rs[time1],"T"); 
		}else{
			$sql = "SELECT
staffid,
max(time_update) as time1
FROM `tbl_log_upload_pdf`
where idcard='$idcard' ";	
			$result = mysql_db_query($dbname_temp,$sql);
			$rs = mysql_fetch_assoc($result);
			$arr['staff_upload'] = "System Upload";
			$arr['date_upload'] = get_dateThai($rs[time1],"T");
			
		}
	
	return $arr;
}//end function DateUploadFile

function DateMoreFile($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT time_update FROM tbl_checklist_log_upkp7file WHERE idcard='$idcard' AND profile_id='$profile_id' ORDER BY time_update ASC LIMIT 1,10";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[] = get_dateThai($rs[time_update]);
			
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function DateMoreFile($idcard,$profile_id){

?>