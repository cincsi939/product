<?
session_start();
set_time_limit(0);
$ApplicationName	= "CC_auto_approvekey";
$module_code 		= "script_manage_data"; 
$process_id			= "script_auto_approve";
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
	## Modified Detail :		เครื่องมือในการรับรองข้อมูลอัตโนมัติ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("function_data.php");
			$time_start = getmicrotime();
			
			$in_staffid = GetStaffLast2month();
			if($in_staffid != ""){
					$conw = " AND t3.staffid NOT IN($in_staffid)";
			}else{
					$conw = "";	
			}//end 
			
			$sql = "SELECT
t1.ticketid,
t1.idcard,
t1.siteid,
t1.profile_id,
t1.userkey_wait_approve,
t1.approve,
t3.sapphireoffice,
t3.period_time,
t3.keyin_group,
t3.staffid
FROM
tbl_assign_key  as t1
Inner Join tbl_assign_sub as t2  ON t1.ticketid = t2.ticketid
Inner Join keystaff as t3 ON t2.staffid = t3.staffid
where t1.userkey_wait_approve='1' and t1.approve <> '2' and 
((t3.sapphireoffice='0' and t3.period_time='am' and t3.keyin_group='2' $conw ) or (t3.keyin_group='5'))";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		
		$sql_update = "UPDATE tbl_assign_key SET approve='2',comment_approve='รับรองโดยอัตโนมัติโดยสคริป'  WHERE ticketid='$rs[ticketid]' AND idcard='$rs[idcard]'   ";
		mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
		
		InsertLogApprove($rs[idcard],$rs[siteid],$rs[profile_id],$rs[staffid]); // log การรับรองข้อมูลโดยอัตโนมัติ
		
			
	}//end while($rs = mysql_fetch_assoc($result)){
			
			
			
		
		##  end เขียนข้อมูลใส่ใน ranking 
		$time_end = getmicrotime();
		echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
		 writetime2db($time_start,$time_end);
		 
	 echo "<h1>Done...................";
 ?>