<?
set_time_limit(3000);    
// PAIROJ  CC sum log
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/CC_statistic_hh.inc.php");
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/CCmaster_statistic_hh.inc.php");
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/CC_statistic_user_hh.inc.php");
### suwat
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/change_idcard/index_change_idcard.php?action=process");
//$result = @file ("http://192.168.2.11/master/application/epm/script_daily.php");
//$result = @file ("http://localhost/edubkk_master/application/hr3/tool_competency/CC_main_school_sumsite_hh.php");
//$result = @file ("http://localhost/edubkk_master/application/userentry/CC_keyin_user.inc.php");
//$result = @file ("http://localhost/edubkk_master/application/userentry/ranking.inc.php");
//$result = @file ("http://localhost/edubkk_master/application/userentry/CC_keyin_user.inc.php");

$result = @file ("http://localhost".APPNAME."application/userentry/CC_keyin_user.inc.php");

#script by Kidsana
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/script_queue_process_timequery.php");
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/crontab_report_viewgeneral.php"); 
$result = @file ("http://localhost".APPNAME."application/userentry/script_check_data_profile_timeall.php");
####  ตรวจสอบไฟล์ pdf ที่มีปัญหา By suwat 
#$result = @file ("http://localhost/edubkk_master/application/checklist_kp7_management/CCscript_manage_checkfilepdf.php");

#### ทำการล ไฟล์ temp_pdf encrypt
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/contab_delete_temp_pdf.php");

###### FACE
#$result = @file ("http://192.168.2.101/face_access/application/face_members/sendmail_unapprove.php");
#$result = @file ("http://192.168.2.101/face_access/application/face_members/script_autoapprove_keyin.php");
// khuan


#Pop Script Log Variable MySQL
$result = @file ("http://localhost/system_variable/script_insert_status.php");

###### ประมวลผลตรวจสอบข้อมูล by suwat
$result = @file ("http://localhost".APPNAME."application/hr3/tool_competency/diagnosticv1/CC_checkdata_qc.php");

//$result = @file ("http://202.129.35.104/edubkk_master/application/hr3/tool_competency/report_check_major.php");


?>
