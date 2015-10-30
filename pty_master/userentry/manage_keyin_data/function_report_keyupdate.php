<?
	#####################  function เก็บ log บรรทัดการคีย์ข้อมูล ###################
	
	$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	function GetMonitorKeyin($date1,$date2,$staffid){
		global $dbnameuse;
		$sql = "SELECT
t1.staffid,
t1.idcard,
t1.siteid,
date(t1.timeupdate) as datekey,
date(t1.timestamp_key) as dateupdate
FROM  monitor_keyin as t1
where t1.staffid='$staffid' and ((date(t1.timeupdate) between '$date1' and '$date2') or (date(t1.timestamp_key) between '$date1' and '$date2') )";
//echo $sql;die;
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$dbsite = STR_PREFIX_DB.$rs[siteid];
			$sql_clean = "DELETE FROM log_update_view WHERE staff_login='$rs[staffid]' AND (updatetime LIKE '$rs[datekey]%' OR updatetime LIKE '$rs[dateupdate]%') and username='$rs[idcard]' ";
			mysql_db_query($dbnameuse,$sql_clean) or die(mysql_error()."$sql_clean<br>LINE__".__LINE__);
			
			############  เก็บข้อมูลไว้ใน temp ##########################
			$sql_insert = "INSERT INTO log_update_view (runid,siteid,server_id,logtime,username,subject,target_idcard,user_ip,action,updatetime,staff_login,menu_id) SELECT 
			t1.runid,'$rs[siteid]',t1.server_id,t1.logtime,t1.username,t1.subject,t1.target_idcard,t1.user_ip,t1.action,t1.updatetime,t1.staff_login,t1.menu_id 
			FROM  $dbsite.log_update as t1 WHERE t1.staff_login='$rs[staffid]' AND (t1.updatetime LIKE '$rs[datekey]%' OR t1.updatetime LIKE '$rs[dateupdate]%') and t1.username='$rs[idcard]'  ";
			mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
				
		}//end while($rs = mysql_fetch_assoc($result)){
			
	}//end function GetMonitorKeyin($date1,$date2,$staffid){
		
	function GetNumLineKey($date1,$date2){
		global $dbnameuse;
		$sql = "SELECT COUNT(username) as num1,staff_login FROM log_update_view WHERE date(updatetime) between '$date1' and '$date2' and action NOT LIKE '%login%' GROUP BY staff_login";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staff_login]] = $rs[num1];
				
		}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}// endfunction GetNumLineKey($date1,$date2){
		
		###########################
function GetProvinceKey(){
		global $dbnameuse;
		$sql = "SELECT t1.profile_id, t1.profile_name FROM keyin_area_profile as t1 WHERE t1.status_active='1' ";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[profile_id]] = $rs[profile_name];
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}//end function GetProvinceKey(){
	
function GetSecname($secid){
	global $dbnamemaster;
	$sql = "SELECT * FROM eduarea WHERE secid='$secid'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);
}
	
	function ShowStaffOffice($get_staffid){
	global $dbnameuse;
	$sql1 = "SELECT prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staffid'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return "$rs1[prename]$rs1[staffname]  $rs1[staffsurname]";
}//end function ShowStaffOffice(){

	
function DBThaiLongDateFull($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}

	
	
	function GetPercenServerDown($date_s,$date_e){
		global $dbnameuse;
		$sql = "SELECT t1.datekey, t1.percen_serverdown as p FROM kvalue_keyin as t1 WHERE  percen_serverdown > 0 
		and t1.datekey between '$date_s' and '$date_e' ";	
	//	echo $sql;
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[datekey]] = $rs[p];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}//end function GetPercenServerDown($yymm){
		
function GetDateFrom($temp_date){
	if($temp_date != "0000-00-00" and $temp_date != ""){
		$arr = explode("-",$temp_date);
		$result = $arr[2]."/".$arr[1]."/".($arr[0]+543);
	}else{
		$result = "";
	}
return $result;
}// end function GetDateFrom($temp_date){
	
function GetDateDB($temp_date){
	if($temp_date != "00/00/0000" and $temp_date != ""){
		$arr = explode("/",$temp_date);
		$result = ($arr[2]-543)."-".$arr[1]."-".($arr[0]);
	}else{
		$result = "";
	}
return $result;
}// end function GetDateFrom($temp_date){
	
	############### หาค่าชดเชย server ประมวลผลช้า ###########
	function GetKDate($date_s,$date_e){
	global $dbnameuse;
	$sql = "SELECT * FROM kvalue_keyin  where datekey between '$date_s' and '$date_e'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[datekey]] = $rs[kval];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}	

##############  function แสดงรหัสของศูนย์คีย์ข้อมูล #################
function GetSiteProvince($prov){
	global $dbnameuse;
	$sql  =  "SELECT site_id FROM keyin_area_site_profile where profile_id='$prov'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[site_id]] = $rs[site_id];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetSiteProvince($prov){
	
	################### in array site_id ##################
	
function GetInSite_id($prov){
	$arr = GetSiteProvince($prov);
	$in_id = "";
	if(count($arr) > 0){
		foreach($arr as $key => $val){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'$val'";
		}//end foreach(){
	}//end 	if(count($arr) > 0){
	return $in_id;
}//end function GetInSite_id($prov){
	
	
############  หาจังหวัดการคีย์ข้อมูล ################
function GetProvinceKeyData($profile_id){
	global $dbnameuse;
	$sql = "SELECT t1.profile_name FROM keyin_area_profile as t1 where t1.profile_id='$profile_id'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[profile_name];
}//end function GetProvinceKeyData(){
	
	
function GetIncentive($date1,$date2,$consite){
	global $dbnameuse;
	
	$sql = "SELECT t1.staffid, max(t2.datekeyin) as mdate 
	FROM stat_incentive as t2
	Inner Join keystaff as t1 ON t2.staffid = t1.staffid
where t2.datekeyin between '$date1' and '$date2'  $consite  group by t1.staffid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT  incentive FROM stat_incentive WHERE datekeyin='$rs[mdate]' AND staffid='$rs[staffid]' ";
			$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
			$rs1 = mysql_fetch_assoc($result1);
			$arr[$rs[staffid]] = $rs1[incentive];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetIncentive($date1,$date2){
	
	
###### function   get base point ##############
function  GetBasePoint(){
	global $dbnameuse;
	$sql = "SELECT
t1.groupkey_id,
t1.base_point,
t1.status_active
FROM keystaff_group as t1
WHERE t1.status_active='1' and t1.base_point > 0";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[groupkey_id]] = $rs[base_point];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function  GetBasePoint(){
	
	
	function StatSumPointAdd($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);// 	
	$yymm = $arrxd[0]."-".$arrxd[1]; // เดือนที่ทำการคิดค่า incentive
	$sqlcount = "SELECT COUNT(staffid) as numid FROM stat_addkpoint_report  WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND  datekeyin < '$get_date' GROUP BY staffid";
	$resultcount = mysql_db_query($dbnameuse,$sqlcount) or die(mysql_error()."$sqlcount<br>LINE__".__LINE__);
	$rsc = mysql_fetch_assoc($resultcount);// ตรวจสอบว่าเดือนนั้นมีการบันทึกค่าคะแนนสะสมหรือยัง	
	if($rsc[numid] > 0){ // แสดงว่าเดือนนั้นมีการจัดเก็บค่าคะแนนไปแล้ว
			$sql1 = "SELECT point_add_net  FROM stat_addkpoint_report WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND point_add_net <> 0 ORDER BY datekeyin DESC LIMIT 1";	
			$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
			$rs1 = mysql_fetch_assoc($result1);
			$stat_val = $rs1[point_add_net];
	}else{
			$stat_val = 0;
	}
	
	return $stat_val;
}// end function function StatSumPointAdd($get_staffid,$get_date){


#### function ล้างค่าการประมวลผล incentive ก่อนทำการบันทึกข้อมูลใหม่
function CleanStatIncentive($conid){
		global $dbnameuse;
		$inid = "";
		$sql = "SELECT t1.staffid FROM keystaff as t1 WHERE t1.staffid <> '' $conid ";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				if($inid > "") $inid .= ",";
				$inid .= "'$rs[staffid]'";
		}
		if($inid != ""){
					$sql_up = "UPDATE stat_addkpoint_report SET point_add='0' ,stat_pointadd='0',point_add_net='0' ,incentive='0' WHERE staffid IN($inid)";
					mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."".__LINE__);
		}
}//end function CleanStatIncentive(){
?>

