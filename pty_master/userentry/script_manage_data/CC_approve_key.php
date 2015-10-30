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
			
$sql = "select t1.idcard,t1.siteid,t1.profile_id FROM tbl_assign_key as t1 LEFT JOIN view_kp7approve as t2 on t1.idcard=t2.idcard and t1.siteid=t2.siteid and t1.profile_id=t2.profile_id  where t1.approve='2' and t1.profile_id > 0 and t1.profile_id IS NOT NULL and t2.idcard IS NULL";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
		$sql_replace = "REPLACE INTO view_kp7approve SET idcard='$rs[idcard]' ,siteid='$rs[siteid]',profile_id='$rs[profile_id]'";
		
		//echo $sql_replace."<br>";
		mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."".__LINE__);
}
			
			
		
		##  end เขียนข้อมูลใส่ใน ranking 
		$time_end = getmicrotime();
		echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
		 writetime2db($time_start,$time_end);
		 
	 echo "<h1>Done...................";
 ?>