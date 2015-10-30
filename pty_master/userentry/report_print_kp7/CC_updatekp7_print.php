<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/03/2011
#LastUpdate::29/03/2011
#DatabaseTable:tbl_person_print
#END
#########################################################
//session_start();

			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			require_once("../../../common/common_competency.inc.php");
			require_once("function_print_kp7.php");
			
			$sql = "SELECT
t1.staffid,
t1.datekqc,
t1.flag_qc,
t2.status_random_qc,
t2.status_random_flag,
t2.status_approve
FROM
tbl_person_print_kp7 as t1
Inner Join stat_user_keyperson as t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard AND t1.flag_qc = t2.flag_qc
where t2.status_random_qc='1'
";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql_up = "UPDATE tbl_person_print_kp7 SET status_print='1',timeprint=NOW() WHERE staffid='$rs[staffid]' AND datekqc='$rs[datekqc]' AND flag_qc='$rs[flag_qc]'";
			mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."".__LINE__);
	}//end 	while($rs = mysql_fetch_assoc($result)){
			


 ?>