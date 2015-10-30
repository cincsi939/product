<?
##################  function ในการสร้างใบงานในการคีย์ข้อมูล  update
include("../../config/conndb_nonsession.inc.php");
$g_extra = "10"; // รหัสกลุ่มเฉพาะกิจ
$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));

function ran_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}


function CheckUserKeyUpdate($staffid){
		global $dbnameuse,$g_extra;
		$sql = "SELECT COUNT(staffid) as num1 FROM keystaff WHERE staffid='$staffid' and keyin_group='$g_extra'";
		$result = mysql_db_query($dbnameuse,$dbnameuse) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}//end function CheckUserKeyUpdate(){
	
###############  สร้างใบงานโดยอัตโนมัต ###################
function CreateTicketid($staffid,$profile_id){
	global $dbnameuse,$ticketYY;
			$sql_ch = "SELECT  ticketid  FROM tbl_assign_sub WHERE mode_assign='KEYUPDATE' and staffid='$staffid' AND profile_id='$profile_id'";
			$result_ch = mysql_db_query($dbnameuse,$sql_ch) or die(mysql_error()."$sql_ch<br>LINE__".__LINE__);
			$rsch = mysql_fetch_assoc($result_ch);
			if($rsch[ticketid] == ""){
				$TicketId = "TK-".$ticketYY."".ran_digi(7);
				$sql_tk = "INSERT INTO tbl_assign_sub SET ticketid='$TicketId' , staffid='$staffid' , profile_id='$profile_id',assign_date='".date("Y-m-d")."', mode_assign='KEYUPDATE',assign_status='YES',assign_comment='มอบหมายงานอัตโนมัติในการคีย์ update'";		
				mysql_db_query($dbnameuse,$sql_tk) or die(mysql_error()."$sql_tk<br>LINE__".__LINE__);
			}else{
				$TicketId = $rsch[ticketid];
			}// end if($rsch[ticketid] == ""){
		return $TicketId;		
}//end function CreateTicketid(){
	
################  มอบมายงานให้พนักงานคีย์ #######################
function CreateAssignKey($staffid,$idcard,$siteid){
	global $dbnameuse,$dbname_temp;
	
		#### ตรวจสอบข้อมูลใน checklist  #############
		$sqlchecklist = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' and siteid='$siteid' ORDER BY profile_id DESC  LIMIT 1 ";
		$resultchecklist = mysql_db_query($dbname_temp,$sqlchecklist) or die(mysql_error()."$sqlchecklist<br>LINE__".__LINE__);
		$rsc = mysql_fetch_assoc($resultchecklist);
		
		$ticketid = CreateTicketid($staffid,$rsc[profile_id]);
		$sql_assign = "SELECT count(idcard) as num1 FROM tbl_assign_key WHERE idcard='$idcard' and siteid='$siteid' and ticketid='$ticketid'";
		$result_assign = mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."$sql_assign<br>LINE__".__LINE__);
		$rsa = mysql_fetch_assoc($result_assign);
		if($rsa[num1] < 1){
				$fullname = "$rsc[prename_th]$rsc[name_th] $rsc[surname_th]";
				$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id,status_keydata,userkey_wait_approve)VALUES('$ticketid','$idcard','$siteid','$fullname','$rsc[profile_id]','1','1')";
				mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE___".__LINE__);
		}// end if($rsa[num1] < 1){
		
}// end function CreateAssignKey($staffid,$idcard,$siteid){


##################  ทดสอบสร้างใบงาน ##################################
$idcard = "3401500210472";
$staffid = "11849";
$siteid = "7103";

CreateAssignKey($staffid,$idcard,$siteid);
	
	


?>