<?
//��˹����ء��� ��ͧ������� $module_code,$process_id �����������ء����


$debug_mode = 0; // 1 = DEBUG MODE / 0=PUBLISH MODE
$show_warning = 0; // 1 = �ʴ� warning / 0= ����ʴ� warning
$maindatabase = "competency_system";
$cmssdatabase = "cmss_master";
$mainapp = "compentency_master";

/* �ѧ��蹡�����Ѻ�����¹ log
$user : ���ͼ����
$module_code : ���� module �����ѧ��ҹ
$process_id : ���� Process ID ����ҧ process_log
$pcrs : ���Ѿ��ͧ process �Ҩ�� seccess , error , unknow , 
$msg : ��ͤ���������Һ�ͧ�����
$filename : file �����ѧ�ѹ�����
$siteid : ������������ѹ����� 
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
//��˹����ء��� ��ͧ������� $module_code,$process_id �����������ء����

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
				echo "<b>����͹</b>  ��÷Ѵ��� : <U>$errline</U> ��� : <U>$errfile</U><br />[$errno] $errstr<br />";
			}

			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 case E_PARSE:
			if ($debug_mode){
			   echo "<b>�����˵�</b> ��÷Ѵ��� : <U>$errline</U> ��� : <U>$errfile</U><br />[$errno] $errstr<br />";
			}
			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 default:
	   //echo "�Դ��ͼԴ��Ҵ�������Һ��Դ : [$errno] $errstr<br />\n";
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

//=================== �ѧ��ѹ�Դ���� � cmss 
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