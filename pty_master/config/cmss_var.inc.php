<?php
/**
* @comment ��� config ��ҡ�ҧ�ͧ�к�
* @projectCode 56EDUBKK01
* @tor 7.2 (Opt.)
* @package core
* @author suwat khamtum (or ref. by "EDUBKK" path "/edubkk_master/config/cmss_var.inc.php")
* @access private
* @created 10/01/2014
*/

	$iphost = $_SERVER[SERVER_ADDR]; # ����� Host 
	
	define("HOST", "192.168.2.102");
	define("USERNAME_HOST","ptymaster");
	define("PASSWORD_HOST","pty2015");
	define("HOST_INTRA","$iphost");
	define("USERNAME_HOST_INTRA","cmss");
	define("PASSWORD_HOST_INTRA","2010cmss");
	define("APPHOST","$iphost");
	define("APPHOST_INTRA","$iphost");
	define("AHTTP","http://");
	define("APPHOST_TEST","$iphost");
	define("HOST_FILE","http://192.168.2.102");
	define("HOST_DB_INTRA","$iphost"); 
	define("APPURL","http://192.168.2.102");
	define("MAIN_URL","http://192.168.2.102");
	define("HOST_PDF","http://$iphost");
	
	define("APPNAME","/pty_master/");
	
	define("PKP7FILE","http://192.168.2.102");
	
	define("SALARY_COMMENT", "1");//ʶҹ�㹡����������˵� salary 1=��ҹ, 0=�����ҹ
	define("COPYRIGHT","ʧǹ�Ԣ�Է����� �ӹѡ�ҹ��С�����â���Ҫ��ä����кؤ�ҡ÷ҧ����֡�� ��з�ǧ�֡�Ҹԡ��"); // �Ԣ�Է���
	
	
	define("SITE_CENTER","0000"); // site �ҹ�����š�ҧ
	define("DB_ZERO","edubkk_0000"); // site �ҹ�����š
	
	## user ����Ѻ crontab
	## User crontab
	define("USER_CRONTAB","ptymaster");
	define("PASS_CRONTAB","pty2015");
	
	#@modify suwat.k ����˹�� default ����������к�
	define("MAIN_WEB_AUTHORITY","http://192.168.2.102/pty_master/application/main_app/index.php");
	#@end ����ش�������˹�� define ����������к�
	
	
	$pty_db = "pty_cms";
	$db_competency="pty_system";
	$cmss_master=STR_PREFIX_DB."master";
	$hostgraph = "202.129.35.106";
	$servergraph = "202.129.35.106";
	$dbtemp_pobec = "pty_import_checklist";
	$now_dbname = STR_PREFIX_DB."master";
	$dbnamemaster = STR_PREFIX_DB."master";
	$pty_db = "pty_cms";
	$db_competency="pty_system";
	$cmss_master=STR_PREFIX_DB."master";
	$hostgraph = "202.129.35.106";
	$servergraph = "202.129.35.106";
	$dbtemp_pobec = "pty_import_checklist";
	$now_dbname = STR_PREFIX_DB."master";
	$dbnamemaster = STR_PREFIX_DB."master"; 	
	$dbname_sapp = "pty_sapphire_app";
	
	## ??????? face
	$host_face = "$iphost";
	$user_face = "sapphire";
	$pass_face = "sprd!@#$%";
	$dbface = "faceaccess";
	$dbnameuse = "pty_userentry";
	$dbname_temp = "pty_checklist";
	
	$tbl_report = "view_general";
	
	##  ??????? epm
	     $host_epm = "202.129.35.99";
	     $user_epm = "webmaster";
		 $pass_epm = "office!sprd";
		 $dbepm = "epm";

		function ConHost($host,$user,$pass){
				$myconnect = mysql_connect($host,$user,$pass) OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
	}	
	function conn($host=""){

				$myconnect = mysql_connect(HOST,USERNAME_HOST,PASSWORD_HOST) OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
	}
	class DBConnection{
		function getConnection(){
		 	 //change to your database server/user name/password
			mysql_connect(HOST,USERNAME_HOST,PASSWORD_HOST) or die("Could not connect: " . mysql_error());
			//change to your database name
			mysql_select_db("jqcalendar") or die("Could not select database: " . mysql_error());
		}
	}
	
	
	function connectdb($server_name,$db_name,$username, $password) {       
	$server_name = HOST;
	$username = USERNAME_HOST;
	$password = PASSWORD_HOST;
	
      $link= mysql_connect($server_name, $username, $password) or die($server_name ." Unable to connect to database  ");
      mysql_select_db($db_name,$link) or die($db_name. " Unable to select database");
      mysql_query('SET CHARACTER SET tis620');
      return  $link ;
    }//end function connectdb($server_name,$db_name,$username, $password) {   
	
	function  conn_db($rshost , $actDB) {
	$rshost = HOST;
	$myconnect = mysql_connect($rshost , USERNAME_HOST, PASSWORD_HOST) OR DIE("Unable to connect to database  ");
	mysql_select_db($actDB) or die( "Unable to select database");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
} ################################################# END function  conn_db($rshost , $actDB) { 

function connx($xx_ip){ 
	$myconnect = mysql_connect(HOST, USERNAME_HOST, PASSWORD_HOST) OR DIE("Unable to connect to database  ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");	
}//end function connx($xx_ip){ 


	function conn_local(){
				$myconnect = @mysql_connect(HOST,USERNAME_HOST,PASSWORD_HOST) ; //OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
	}
	
function connserver($hr_host=""){ 
global 	$now_dbname;
	$myconnect = mysql_connect(HOST, USERNAME_HOST, PASSWORD_HOST)   ;  
	//@mysql_select_db($now_dbname) or die("Cannot connect to Database. ::$now_dbname  ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
}  ### END function connserver($hr_host){ 


function con_db($siteid){

global $dbnamemaster,$s_db;

$sql_sel = "SELECT area_info.intra_ip, eduarea.secid, eduarea.area_id FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id
WHERE eduarea.secid =  '$siteid' ";
#echo $sql_sel."<br>";
$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
$rs_sel = mysql_fetch_assoc($result_sel);

if($rs_sel[intra_ip] == ""){ $conhost = HOST;$xdbname = $dbnamemaster;}else{ $conhost = $rs_sel[intra_ip];$xdbname = "$s_db".$siteid;}

$myconnect = mysql_connect($conhost, USERNAME_HOST, PASSWORD_HOST)or die("Unable to connect to database");
mysql_select_db($xdbname) or die( "<center>�������ö�Դ��Ͱҹ�����ŷ���ҹ���¡��</center>");
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

} // end function con_db($siteid){


function conn2DB()
{ 


    $conn = mysql_connect( HOST,USERNAME_HOST,PASSWORD_HOST );
    if (!$conn)
	die ("�������ö�Դ��͡Ѻ MySql �� ");
  mysql_select_db($db_name,$conn) 
	   or die ("�������ö���͡��ҹ�������� ");

  $iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

}


function connect_db(){
 $link1 =MYSQL_CONNECT(HOST, USERNAME_HOST, PASSWORD_HOST) ;
if (!$link1) {
   return false;
}else{
	mysql_query("SET character_set_results=tis-620");
mysql_query("SET NAMES TIS620");

   return true;
} 
}
?>