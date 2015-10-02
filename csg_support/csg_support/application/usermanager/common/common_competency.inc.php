<?
//กำหนดให้ทุกไฟล์ ต้องใส่ตัวแปร $module_code,$process_id ไว้ที่หัวไฟล์ทุกครั้ง


$debug_mode = 0; // 1 = DEBUG MODE / 0=PUBLISH MODE
$show_warning = 0; // 1 = แสดง warning / 0= ไม่แสดง warning
$maindatabase = "competency_system";
$cmssdatabase = "cmss_master";
$mainapp = "compentency_master";

/* ฟังชั่นก์สำหรับการเขียน log
$user : ชื่อผู้ใช้
$module_code : รหัส module ที่กำลังใช้งาน
$process_id : รหัส Process ID ใช้ตาราง process_log
$pcrs : ผลลัพท์ของ process อาจเป็น seccess , error , unknow , 
$msg : ข้อความแจ้งให้ทราบของโปรแกรม
$filename : file ที่กำลังรันโปรแกรม
$siteid : เซิร์ฟเวอร์ที่รันโปรแกรม 
*/

 function write_log($usr,$md,$pcid,$pcrs,$msg,$filename,$siteid){
	 global $dbsystem;

	 $filename =    addslashes($filename) ; 
	 $msg =    addslashes($msg) ;
	 $msg =    str_replace("'"," ",$msg);

	 $sql = "INSERT INTO  syslog(userid,modulecode,processid,processresult,msg,filename,siteid) VALUES ( '$usr','$md','$pcid','$pcrs','$msg','$filename','$siteid' ); ";	 
	@mysql_db_query($dbsystem,$sql);
	
	return @mysql_insert_id() ; 
 }

 // set the error reporting level for this script
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// error handler function
//กำหนดให้ทุกไฟล์ ต้องใส่ตัวแปร $module_code,$process_id ไว้ที่หัวไฟล์ทุกครั้ง

function myErrorHandler($errno, $errstr, $errfile, $errline){
global $debug_mode,$module_code,$process_id,$siteid,$show_warning , $dbsystem;
	 
	 //DO NOTHING
	 return;


	switch ($errno) {
	 case E_ERROR:
			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$_SESSION[secid]);
			exit(1);
			break;
	 case E_WARNING:
			if ($debug_mode && $show_warning){
				echo "<b>คำเตือน</b>  บรรทัดที่ : <U>$errline</U> ไฟล์ : <U>$errfile</U><br />[$errno] $errstr<br />";
			}

			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 case E_PARSE:
			if ($debug_mode){
			   echo "<b>หมายเหตุ</b> บรรทัดที่ : <U>$errline</U> ไฟล์ : <U>$errfile</U><br />[$errno] $errstr<br />";
			}
			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 default:
	   //echo "เกิดข้อผิดพลาดที่ไม่ทราบชนิด : [$errno] $errstr<br />\n";
		//write_log($session_username,$module_code,$process_id,"incomplete",$errstr,$errfile,$siteid);
	   break;
	}
}

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
 } 

//$time_start = getmicrotime();
//$time_end = getmicrotime();

function writetime2db($timestart,$timeend){
	GLOBAL $maindatabase,$ApplicationName,$session_username , $dbsystem ;

	$serverip = $_SERVER['SERVER_NAME'];
	$ipaddress = $_SERVER["REMOTE_ADDR"] ;
	$file_name = basename($_SERVER['PHP_SELF']);
	$filefullpath = __FILE__;
	$timequery = $timeend - $timestart;
	$sessionid = session_id();
	$siteid1 = $_SESSION[secid];
	
	$sql = " INSERT INTO system_timequery  SET  username = '".$_SESSION[session_username]."' ,ipaddress = '$ipaddress' ,siteid='$siteid1',appname = '$ApplicationName', filename = '$file_name' ,timequery = '$timequery' , serverip = '$serverip'  ";
	mysql_db_query($dbsystem,$sql);


	$sql1 = " REPLACE INTO useronline  SET sessionid= '$sessionid', username = '".$_SESSION[session_username]."' ,siteid='$siteid1',ipaddress = '$ipaddress' ,appname = '$ApplicationName',filename = '$file_name' , serverip = '$serverip' ";
	//echo "$sql1 $dbsystem ";die;
	mysql_db_query($dbsystem,$sql1);

}
	ob_end_flush();

//=================== ฟังก์ชันปิดเมนู ใน cmss 
function set_privilage($secid,$pivilage){
	global $dbnamemaster;
	$strSQL = "SELECT secid FROM $dbnamemaster.eduarea WHERE status <> 1";
	$Result = mysql_query($strSQL);
	while($Rs = mysql_fetch_array($Result)){
		if($secid == $Rs[secid]){
					if(($secid == $Rs[secid]) and ($pivilage == "")){
					$disable_link = true;
					}else{
					$disable_link = false;
					}	
			break;
			}
	}
		return $disable_link;
}



?>