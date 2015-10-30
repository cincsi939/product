<?
########### นับจำนวนบุคลากรทั้งหมด
$profile_48 = 5;
$profile_new = "4";

function NumpersonAll(){
	global $dbnamemaster;
	$sql = "SELECT
COUNT(t1.CZ_ID) AS numall,
sum(if(t2.status_keydata='1',1,0)) as numkey,
sum(if(t2.status_keydata='0',1,0)) as numkey_diff
FROM 
view_general as t1
inner Join view_general_primarydata as t2 ON t1.CZ_ID = t2.idcard AND t1.siteid = t2.siteid ";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$rs = mysql_fetch_assoc($result);
$arr['numall'] = $rs[numall];
$arr['numkey'] = $rs[numkey];
$arr['numkey_diff'] = $rs[numkey_diff];
return $arr;
		
}//end function NumpersonAll(){
	
##############  function นับจำนวนที่คีย์ข้อมูลไปแล้ว ##############	
function GetNumKeyApprove($profile_id){
		global $dbname_temp;
		$sql = "SELECT
count(distinct t1.idcard) as numkey
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2  ON t1.idcard = t2.idcard AND t1.profile_id = t2.profile_id
where t1.profile_id='$profile_id' and t2.approve='2'
group by t1.profile_id";
		$result = mysql_db_query($dbname_temp,$sql) or(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[numkey];
}//end function GetNumKeyApprove($profile_id){
	
######## จำนวนข้อมูลทั้งหมด ##########################
function GetNumKp7All($profile_id){
	global $dbname_temp;
	$sql = "SELECT count(idcard) as num1 FROM tbl_checklist_kp7 where profile_id='$profile_id' ";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	#####  จำนวนในเลขบัตรไม่ถูกต้องตามกรมการปกครอง
	$sql1 = "SELECT count(idcard) as num1  FROM  tbl_checklist_kp7_false  WHERE  profile_id='$profile_id' AND status_IDCARD LIKE  '%IDCARD_FAIL%' AND status_chang_idcard LIKE  '%NO%'";
	$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
	$rs1 = mysql_fetch_assoc($result1);
	$numall = $rs[num1]+$rs1[num1];
	
	return $numall;
}
	
###########

function ShowProfile_name($profile_id){
	global $dbname_temp;
	$sqlp = "SELECT profilename FROM tbl_checklist_profile WHERE profile_id='$profile_id'";
	$resultp = mysql_db_query($dbname_temp,$sqlp);
	$rsp = mysql_fetch_assoc($resultp);
	return $rsp[profilename];
}// end function ShowProfile_name($profile_id){
	
#####  เลือกข้อมูล 48 เขตต่อเนื่องในโครงการปี 2552
function GetsiteContinue(){
	global $dbname_temp,$profile_48;
	$sql = "SELECT siteid FROM  tbl_cmss_profile_new WHERE report_id='$profile_48' ";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($in_site > "") $in_site .= ",";
			$in_site .= "'$rs[siteid]'";
	}
	return $in_site;
}//end function GetsiteContinue(){

function GetNumKeyApproveSite($xtype=""){
	global $dbname_temp,$profile_new;
	$insite = GetsiteContinue();
	if($xtype == "NEW"){
		if($insite != ""){
					$conv = " AND t1.siteid NOT IN($insite)";
		}
	}else{
			if($insite != ""){
					$conv = " AND t1.siteid  IN($insite)";
		}
	}
	$sql = "SELECT
count(distinct t1.idcard) as numkey
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2  ON t1.idcard = t2.idcard AND t1.profile_id = t2.profile_id
where t1.profile_id >='$profile_new' and t2.approve='2' $conv";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[numkey];
		
}//end function GetNumKeyApproveSite($xtype=""){
	
function GetNumKp7Allv1($profile_id,$xtype=""){
	global $dbname_temp;
	$insite = GetsiteContinue();
	if($xtype == "NEW"){
		if($insite != ""){
					$conv = " AND siteid NOT IN($insite)";
		}
	}else{
			if($insite != ""){
					$conv = " AND siteid  IN($insite)";
		}
	}

	
	
	$sql = "SELECT count(idcard) as num1 FROM tbl_checklist_kp7  where profile_id='$profile_id' $conv";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	#####  จำนวนในเลขบัตรไม่ถูกต้องตามกรมการปกครอง
	$sql1 = "SELECT count(idcard) as num1  FROM  tbl_checklist_kp7_false  WHERE  profile_id='$profile_id' AND status_IDCARD LIKE  '%IDCARD_FAIL%' AND status_chang_idcard LIKE  '%NO%' $conv";
	$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
	$rs1 = mysql_fetch_assoc($result1);
	$numall = $rs[num1]+$rs1[num1];
	
	return $numall;
}


?>