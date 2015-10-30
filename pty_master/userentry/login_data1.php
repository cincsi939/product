<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_search_people";
$module_code 		= "search_people"; 
$process_id				= "search_people";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::13/01/2008
#LastUpdate	::13/01/2008
#DatabaseTabel::  ".DB_MASTER.".view_general
#END
#########################################################
# ob_start();
session_start();
set_time_limit(0) ; 
include ("../../../../config/conndb_nonsession.inc.php")  ;
// logon เข้าไปแก้ไขข้อมูลส่วนบุคคล ===========================
			if($action == "login"){
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $xidcard ;
				$_SESSION[name] = $xname_th ;
				$_SESSION[surname] = $xsurname_th ;
				$_SESSION[session_username] = $xidcard;
				$_SESSION[idoffice] = $xidcard ;
				$_SESSION[secid] = $xsiteid ;
				$sqlxx = "INSERT INTO tbl_log_edit SET idcard='$xidcard'";
				//echo $sql;die;
				mysql_db_query("cmss_6502",$sqlxx);
				//echo "<pre>";
				//print_r($_SESSION);die;
				echo "<script>top.location.href='../../hr_frame/frame.php';</script>";
				exit;
			} 
?>
