<?php
/**
* @comment ไฟล์ ตัวแปรเกี่ยวกับฐานข้อมูล
* @projectCode 56EDUBKK01
* @tor 7.2 (Opt.)
* @package core
* @author suwat khamtum (or ref. by "EDUBKK" path "/edubkk_master/config/cmss_define.php")
* @access private
* @created 10/01/2014
*/


	#### ตัวแปรเกี่ยวกับฐานข้อมูล
	define("STR_PREFIX_DB", "edubkk_");
	define("DB_MASTER","edubkk_master");
	define("DB_ROYAL_MASTER","edubkk_royal_master");
	define("DB_VERIFICATION","command_verification");
	
	define("DB_CHECKLIST","edubkk_checklist");
	define("DB_USERENTRY","edubkk_userentry");
	
	define("DB_SYSTEM","edubkk_system");
	
	define("DB_LOGTRANFER","edubkk_log_tranfer");
	
	
	define("DB_REQ","edubkk_req");
	define("DB_REQ_PROB","req_problem_person");
	
	## ตัวแปร application
	define("APP_MAIN","edubkk_master");
	
	define("DB_EDUBKK_0000",STR_PREFIX_DB."0000");
    define("DB_IMPORT_CHECKLIST",STR_PREFIX_DB."import_checklist");
	
	define("HOST_GRAPH","202.129.35.106");
	define("INTRA_FACE","192.168.2.101");
	define("EXTRA_FACE","202.129.35.101");
	
?>