<?
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$sql = "SELECT
t3.req_person_id,
t1.ticketid,
t1.idcard,
t1.siteid,
t1.fullname,
date(t1.update_time) AS date_edit,
t3.runid AS log_id,
t2.staffid,
t1.userkey_wait_approve,
Count(t4.runid) AS numpointedit,
t1.approve
FROM ".DB_USERENTRY.".tbl_assign_edit_key AS t1
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log AS t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail AS t3 ON t2.runid = t3.log_id
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail_key AS t4 ON t3.runid = t4.log_detail_id
WHERE
t1.userkey_wait_approve =  '1' and t1.approve <> '2'
GROUP BY
t3.req_person_id
HAVING
numpointedit >  0";			
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			#############  approve ในระบบ มอบหมายงาน
			$sql_update1 = "UPDATE tbl_assign_edit_key SET approve='2' WHERE ticketid='$rs[ticketid]' AND idcard='$rs[idcard]'  ";
			mysql_db_query($dbnameuse,$sql_update1) or die(mysql_error()."$sql_update1<br>LINE__".__LINE__);
			#########  update ในคำร้องขอแก้ไขข้อมูล
			$sql_up2 = "UPDATE req_temp_wrongdata SET status_assign='1',status_key_approve='1',status_admin_key_approve='1' WHERE req_person_id='$rs[req_person_id]'  ";
			mysql_db_query($dbnamemaster,$sql_up2) or die(mysql_error()."$sql_up2<br>LINE__".__LINE__);
			
			$sql_up3 = "UPDATE req_problem_person SET  req_status='3' WHERE req_person_id='$rs[req_person_id]'";
			mysql_db_query($dbnamemaster,$sql_up3) or die(mysql_error()."$sql_up3<br>LINE__".__LINE__);
			
			$sql_up4 = "UPDATE req_problem SET  req_status='3' WHERE req_person_id='$rs[req_person_id]'";
			mysql_db_query($dbnamemaster,$sql_up4) or die(mysql_error()."$sql_up4<br>LINE__".__LINE__);
			
			
			
				
		}// end while($rs = mysql_fetch_assoc($result)){

echo "Done....";


?>

