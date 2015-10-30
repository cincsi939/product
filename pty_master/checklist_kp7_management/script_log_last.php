<?
session_start();
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");

	$sql = "INSERT INTO tbl_checklist_log_last(idcard, siteid,schoolid,siteid_old,schoolid_old, user_update,user_save, ip_server,action_data,time_update,timeupdate,type_action,profile_id) SELECT tbl_checklist_log.idcard, tbl_checklist_log.siteid,tbl_checklist_log.schoolid,tbl_checklist_log.siteid_old,tbl_checklist_log.schoolid_old, tbl_checklist_log.user_update,tbl_checklist_log.user_save, tbl_checklist_log.ip_server,tbl_checklist_log.action_data,tbl_checklist_log.time_update,tbl_checklist_log.timeupdate,tbl_checklist_log.type_action,tbl_checklist_log.profile_id  FROM tbl_checklist_log
WHERE type_action='1'
group by idcard,profile_id
ORDER BY time_update DESC";


?>