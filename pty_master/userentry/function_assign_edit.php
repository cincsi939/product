<?
$type_problem = "1"; // 1 คือพิมพ์ผิด 2 คือ ข้อมูลไม่เป็นปัจจุบัน	
$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

function Eran_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}


function CheckTicketid(){
	global $dbnameuse,$ticketYY;
	$TicketId = "TK-".$ticketYY."".Eran_digi(7);
	$sql_sel = "SELECT COUNT(*) AS num1 FROM tbl_assign_edit_sub WHERE ticketid='$TicketId'";
	$result_sel = mysql_db_query($dbnameuse,$sql_sel) or die(mysql_error()."$sql_sel<hr>LINE:: ".__LINE__);
	$rss = mysql_fetch_assoc($result_sel);
	if($rss[num1] > 0){
			CheckTicketid();
	}else{
		return $TicketId;	
	}//end if($rss[num1] > 0){
	
}//end function CheckTicketid($ticketid){


function ECreateTicketid($staffid){
	global $dbnameuse,$ticketYY;
	$date1 = date("Y-m-d");
	$TicketId = CheckTicketid();
	$sql = "INSERT INTO tbl_assign_edit_sub SET ticketid='$TicketId',staffid='$staffid',assign_date='$date1',recive_date='$date1',sent_date='$date1',sent_date_true='$date1',assign_status='YES' ";
	mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<hr>LINE::".__LINE__);
	return $TicketId;
}//end function ECreateTicketid(){
	
	function EInsertLogAssignEdit($idcard,$siteid,$ticketid,$staffid,$action,$status_permit=""){
		global $dbnamemaster,$dbnameuse,$type_problem;
		$ip = get_real_ip();
				if($status_permit != ""){
				$conv = " AND t1.status_permit =  '$status_permit' ";
		}else{
				$conv = "  ";	
		}

		
		$sql = "INSERT INTO tbl_assign_edit_log SET idcard='$idcard',siteid='$siteid',ticketid='$ticketid',staffid='$staffid',server_ip='$ip',action='$action',time_update=NOW()";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()." $sql<hr>LINE :: ".__LINE__);
		$last_id = mysql_insert_id();
		
		$sql_select  = "SELECT
t1.req_person_id,
t1.runid
FROM
req_temp_wrongdata as t1
Inner Join req_problem_person  as t2 ON t1.req_person_id = t2.req_person_id 
inner join  req_problem as t3 ON t2.req_person_id =t3.req_person_id
WHERE
t1.problem_type =  '$type_problem' AND
t1.status_assign =  '0' AND 
t2.idcard='$idcard' AND t1.status_req_approve='1'
 $conv ";
 	$result_sel = mysql_db_query($dbnamemaster,$sql_select) or die(mysql_error()."$sql_select<HR>LINE::".__LINE__);
	//echo "$dbnamemaster<br><br>$sql1<hr>".mysql_num_rows($result_sel);die;
	while($rs1 = mysql_fetch_assoc($result_sel)){
			$sql_insert1 = "INSERT INTO tbl_assign_edit_log_detail SET log_id='$last_id',req_person_id='$rs1[req_person_id]',timeupdate=NOW()";
			mysql_db_query($dbnameuse,$sql_insert1) or die(mysql_error()."$sql_insert1<HR>LINE::".__LINE__);
			$sql_update = "UPDATE  req_temp_wrongdata SET status_assign='1' WHERE runid='$rs1[runid]' ";
			mysql_db_query($dbnamemaster,$sql_update) or die(mysql_error()."$sql_update<HR>LINE::".__LINE__);
	}
				
	}//end function InsertLogAssignEdit(){
		
	####  function check ข้อมูลก่อนทำการ มอบหมายงาน
	function ECheckDataAssign($idcard,$staffid){
		global $dbnameuse;
		$sql = "SELECT COUNT(t1.idcard) as num1 FROM tbl_assign_edit_key as t1 INNER JOIN tbl_assign_edit_sub as t2 ON t1.ticketid=t2.ticketid 
		WHERE t1.idcard='$idcard' AND t2.staffid='$staffid' AND t1.approve <> '2' ";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<hr>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);	
		return $rs[num1];
		
	}//end 	function CheckDataAssign(){
		
		
		
	########### update การมอบหมายงานกรณีทำากรคีย์เรียบร้อยแล้ว userkey_wait_approve
	function EUpdateEditKey($ticketid,$idcard){
			global $dbnameuse;
			$sql = "UPDATE tbl_assign_edit_key SET status_keydata='1'  WHERE ticketid='$ticketid' and idcard='$idcard'";
			mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<HR>LINE::".__LINE__);
	}//end 
	
	function EUpdateKeyApprove($ticketid,$idcard){
			global $dbnameuse;
			$sql = "UPDATE tbl_assign_edit_key SET userkey_wait_approve='1'  WHERE ticketid='$ticketid' and idcard='$idcard'";
			mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<HR>LINE::".__LINE__);
	}//end userkey_wait_approve(){
	
	################  function  Get Sql ข้อมูลที่ต้อง assign
	function EAssignEditKey($idqueue="",$status_permit=""){
		global $dbnamemaster,$dbnameuse,$type_problem;
		if($status_permit != ""){
				$conv = " AND t1.status_permit =  '$status_permit' ";
		}else{
				$conv = "  ";	
		}
		
		if($idqueue != ""){	
				$conid = " AND t1.runid";
		}else{
				$conid = "";	
		}
		
		$sql = "SELECT
t1.runid,
t2.idcard,
t3.siteid,
t3.prename_th,
t3.name_th,
t3.surname_th
FROM
req_temp_wrongdata as t1
Inner Join req_problem_person as t2 ON t1.req_person_id = t2.req_person_id
Inner Join view_general as t3 ON t2.idcard = t3.CZ_ID
WHERE
t1.problem_type =  '$type_problem' AND
t1.status_assign =  '0'
AND t1.status_req_approve='1'
$conv $conid
GROUP BY
t2.idcard ";	
//echo $sql." :: ".$dbnamemaster."<br>";die;
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<HR>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$staffid = GetStaffAssign($rs[idcard]); // พนักงานที่เคยคีย์ข้อมูล
			if($staffid != ""){
					$ticketid = EChecklistTicket($staffid);// เช็คว่า ticketid การแก้ไขงานของคนนี้ได้เคยมอบหมายงานไปแล้ว
					if($ticketid == ""){
						 $ticketid = ECreateTicketid($staffid);	
					}//end if($ticketid == ""){
						
					############ เพิ่มข้อมูลใน ticketid
					
					$check_data = ECheckDataAssign($rs[idcard],$staffid);
					if($check_data < 1){
						$fullname = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
						$sql_assign = "INSERT INTO tbl_assign_edit_key SET ticketid='$ticketid',idcard='$rs[idcard]',fullname='$fullname',siteid='$rs[siteid]',dateassgin=NOW()";
						mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."$sql_assign<hr>LINE::".__LINE__);
						EInsertLogAssignEdit($rs[idcard],$rs[siteid],$ticketid,$staffid,"มอบหมายงานแก้ไข","");// insert LOG
					}// end if($check_data < 1){
					
			}else{
					UpdateTempData($idcard);// update ข้อมูลในกรณีพนักงานคีย์ได้ออกไปแล้วหรือย้ายไปทำหน้าที่อื่น
			}//end if($staffid != ""){
		}// end while($rs = mysql_fetch_assoc($result)){
	}//end function GetSqlAssign($status_permit=""){ 
	
#####################
function UpdateTempData($idcard){
	global $dbnamemaster,$type_problem;
	$sql2 = "SELECT
req_temp_wrongdata.req_person_id,
req_temp_wrongdata.runid
FROM
req_temp_wrongdata
Inner Join req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id 
inner join 
req_problem on req_problem_person.req_person_id =req_problem.req_person_id
WHERE
req_temp_wrongdata.problem_type =  '$type_problem' AND
req_temp_wrongdata.status_assign =  '0' and
 req_problem_person.idcard='$idcard' ";
 					$result2 = mysql_db_query($dbnamemaster,$sql2) or die(mysql_error()."$sql1<HR>LINE::".__LINE__);
					while($rs2 = mysql_fetch_assoc($result2)){
						$sql_update = "UPDATE  req_temp_wrongdata SET status_permit='NO' WHERE runid='$rs1[runid]' ";
						mysql_db_query($dbnamemaster,$sql_update) or die(mysql_error()."$sql_update<HR>LINE::".__LINE__);		
					}// end while($rs1 = mysql_fetch_assoc($result1)){
}// end function UpdateTempData($idcard){
	
function GetStaffAssign($idcard){
	global $dbnameuse;
	$sql = "SELECT * FROM tbl_assign_key WHERE idcard='$idcard' ORDER BY profile_id DESC LIMIT 1";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<HR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$ticketid = $rs[ticketid];
	$sql_staff = "SELECT
keystaff.staffid
FROM
tbl_assign_sub
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE ticketid='$ticketid' and status_permit='YES' AND status_extra='NOR' and keyin_group > 0";
	$result_staff = mysql_db_query($dbnameuse,$sql_staff)or die(mysql_error()."$sql_staff<HR>LINE::".__LINE__);
	$rss = mysql_fetch_assoc($result_staff);
	return $rss[staffid];
}
	
function EChecklistTicket($staffid){
		global $dbnameuse;
		$sql = "SELECT * FROM tbl_assign_edit_sub WHERE staffid='$staffid'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[ticketid];
			
}//end function EChecklistTicket($staffid){
	



	
?>