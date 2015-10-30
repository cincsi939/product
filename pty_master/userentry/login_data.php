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
//echo HOST." ".USERNAME_HOST." ".PASSWORD_HOST." dbname ".$dbname;
// logon เข้าไปแก้ไขข้อมูลส่วนบุคคล ===========================
			if($action == "login"){
				
				
				
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $xidcard ;
				$_SESSION[name] = $xname_th ;
				$_SESSION[surname] = $xsurname_th ;
				$_SESSION[session_username] = $xidcard;
				$_SESSION[idoffice] = $xidcard ;
				$_SESSION[secid] = $xsiteid ;
				
				###  ตรวจสอบ การ login ผ่าน monitor คีย์อิน
				$sql = "SELECT COUNT(idcard) as numid FROM monitor_keyin WHERE staffid='".$_SESSION['session_staffid']."' and idcard='$xidcard'";
				//echo $dbnameuse." :: ".$sql."<br>";die;
				$result = mysql_db_query($dbnameuse,$sql);
				$rs = mysql_fetch_assoc($result);
					if($rs[numid] < 1){
						
					if($_SESSION['session_sapphire'] == 1){
						$status_user = 1; // พนักงาน sapphire
					}else if($_SESSION['session_sapphire'] != 1 and $_SESSION['session_status_extra'] == "QC"){
						$status_user = 2; // ลูกจ้างชั่วคราวที่กำหนดในเป็น qc
					}else{
						$status_user = 0;// พนักงานจ้าง
					}
						
						$namekey = "$xprename_th $xname_th $xsurname_th";
						$sql_insert = "INSERT INTO  monitor_keyin(staffid,idcard,siteid,keyin_name,timeupdate,timestamp_key,status_user,timeupdate_user) VALUES ('".$_SESSION['session_staffid']."','$xidcard','$xsiteid','$namekey',NOW(),NOW(),'$status_user',NOW())";
						mysql_db_query($dbnameuse,$sql_insert);
							
					}
				
				//echo "<pre>";
				//print_r($_SESSION);die;
				echo "<script>top.location.href='../../hr_frame/frame.php';</script>";
				exit;
			} 
?>
