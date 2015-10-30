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
#DatabaseTabel:: pty_master.view_general
#END
#########################################################
# ob_start();
session_start();
set_time_limit(0) ; 
// logon เข้าไปแก้ไขข้อมูลส่วนบุคคล ===========================

			if($action == "login"){
			//	session_destroy();
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $idcard ;
				$_SESSION[name] = $name_th ;
				$_SESSION[surname] = $surname_th ;
				$_SESSION[session_username] = $idcard;
				$_SESSION[idoffice] = $idcard ;
				$_SESSION[secid] = $siteid ;
/*				echo "<pre>";
				print_r($_SESSION);die;
*/				echo "<script>top.location.href='../application/hr3/hr_frame/frame.php';</script>";
				exit;
			} 
?>
