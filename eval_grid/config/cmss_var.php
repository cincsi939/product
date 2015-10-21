<?php
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับdefine ค่าตัวแปลและconnectฐานข้อมูล
* @projectCode 56CMSS09
* @tor 
* @package core
* @author Pairoj Panturat
* @access private
* @created 24/05/2014
*/
	/*$local_ip = substr($_SERVER['REMOTE_ADDR'],0,7);

	if($local_ip == "192.168"){
		define("HOST", "192.168.2.121");
	}
	else*/

	#define("HOST", "202.129.35.121");

		#define("HOST", "61.19.255.74");
		#define("HOST_TEMP", "61.19.255.74");
		
		define("HOST", "database.cmss-otcsc.com");#database.cmss-otcsc.com
		define("HOST_TEMP", "database.cmss-otcsc.com");#database.cmss-otcsc.com
	
	define("USERNAME_HOST","cmss");
	define("PASSWORD_HOST","2010cmss");
	define("HOST_INTRA","61.19.255.75");
	
	# user ระบบเลื่อนเงินเดือน
	define("USERNAME_HOST_SALARY","salary_system");
	define("PASSWORD_HOST_SALARY","2013@salsapp");
	
	#host ระบบออกคำสั่ง
	define("HOST_WCS","http://wcs.cmss-otcsc.com/");


	define("USERNAME_HOST_INTRA","sapphire");
	define("PASSWORD_HOST_INTRA","sprd!@#$%");
	define("APPHOST","61.19.255.75");
	define("APPHOST_INTRA","61.19.255.75");
	define("AHTTP","http://");
	define("APHTTP","http://");
	define("APPHOST_TEST","61.19.255.75");
	define("HOST_FILE","61.19.255.75");
	define("HOST_DB_INTRA","database.cmss-otcsc.com");   	#database.cmss-otcsc.com
	#### USER sapphire   
	define("USER_SAPPHIRE","sapphire");   
	define("PASS_SAPPHIRE","sprd!@#$%");   
	//define("APPURL","http://61.19.255.75");
	define("APPURL","http://master.cmss-otcsc.com");
	## path file server
	#define("PKP7FILE","http://filemaster.cmss-otcsc.com/kp7file_original/");
	define("PKP7FILE","http://master.cmss-otcsc.com/kp7file/");
	
	## User crontab
	define("USER_CRONTAB","cmss_crontab");
	define("PASS_CRONTAB","cmss!@#$%");
	
	define("MAIN_URL","http://www.cmss-otcsc.com");
	//define("MAIN_URL","http://61.19.255.75");
	define("SITE_CENTER","0000"); // site ฐานข้อมูลกลาง
	define("RETIRE_CENTER","retireout"); // site ฐานข้อมูลกลาง เก็บข้อมูลคนที่เสียชีวิต ออกจากราชการถาวร
	define("DB_ZERO","cmss_0000"); // site ฐานข้อมูลก
	
	// define เครื่อง soap ที่เรียก
	define("SOAP_SERVER","http://192.168.2.102/php_webservice/index.php?wsdl");
	
	//ระบบอัพโหลดเอกสารหลักฐาน ----------------------------------
	define("DB_REFDOC", "cmss_refdoc");
	$k7_store = "kp7_refdoc";
	$index_root = "20140119_002";
	$index_folder = "20140119_002_1001";
	//$server_refdoc = "localhost";
	$server_refdoc = "../../../";
	$upload_limit = 999;
	$upload_size = '10MB';
	//------------------------------------------------------------------------
	
	define("SALARY_COMMENT", "1");//สถานะในการใส่หมายเหตุ salary 1=ใช้งาน, 0=ไม่ใช้งาน
	define("COPYRIGHT","สงวนลิขสิทธิ์โดย สำนักงานคณะกรรมการข้าราชการครูและบุคลากรทางการศึกษา กระทรวงศึกษาธิการ"); // ลิขสิทธิ์
	
	$cms_db = "competency_cms";
	$db_competency="competency_system";
	$cmss_master="cmss_master";
	$hostgraph = "graph.sapphire.co.th";
	//$servergraph = "202.129.35.106";
	$servergraph = "graph.sapphire.co.th";
	$dbtemp_pobec = "temp_pobec_import";
	$now_dbname = "cmss_master";
	$dbnamemaster = "cmss_master"; 	
	$dbname_sapp = "sapphire_app";
	$dbname_center = "cmss_0000"; // ฐานข้อมูลกลาง
	
	$tbl_report = "view_general";	// ชื่อ table ที่ใช้ในการแสดงหน้ารายงาน
	$dbcmss_log = "cmss_log_tranfer"; // ฐานข้อมูลในตาราง temp log
	$db_req = "cmss_req"; // ฐานข้อมูลระบบยื่นคำร้อง
	//ใช้สำหรับระบบรับรองข้อมูล
	define("TBL_REQ_PROBLEM_GNO", "cmss_req.req_problem_groupno_".$SESSTION_REQ['SITE']);
	define("TBL_REQ_KP7_LOAD", "cmss_req.req_kp7_load_".$SESSTION_REQ['SITE']);
	
	$arr_level_salary = array("20000||<"=>"น้อยกว่า 20,000 บาท","20000||>="=>" 20,000 บาทขึ้นไป","all"=>"แสดงทั้งหมด");
	
	### ตัวแปรที่เป็นเงื่อนไขในการนับข้อมูล สพท.และโรงเรียน เพื่อใช้ในการ join ระหว่าง allschool กับ view_general
	if(!$_GET['join']){
		$_GET['join'] = "Left"; // 	
	}// end if($_GET['join'] == ""){
	
	
	
	# ตัวแปรเก็บเขตที่ login โดยไม่ต้องหาข้อมูลในตาราง eduarea 
	$arr_sitelogin = array("0400");
	## เครื่อง face
	/* $host_face = "202.129.35.101";
	$user_face = "sapphire";
	$pass_face = "sprd!@#$%"; */
	$host_face = "61.19.255.74";
	$user_face = "cmss";
	$pass_face = "2010cmss";
	$dbface = "faceaccess";
	$dbnameuse = "callcenter_entry";
	$dbname_temp = "temp_check_data";
	$db_command_temp = "command_verification_temp";
	
	# on Off message ระบบบันทึกข้อมูลภายใน
	define("MESSAGE_OFFICE","OFF");
	# ค่ารอบการเลื่อนเงินเดือนเพื่อตรวจสอบการปิดการพิจารณาเลื่อนเงินเดือนชั่วคราว ตามหนังสือ  ก.ค.ศ. ที่ ศธ ๐๒๐๖.๗/๘๑
	define('CHECK_YEAR_DISABLE','');
	#end 
	
	
	##  เครื่อง epm
	     $host_epm = "202.129.35.101"; # แก้ไขหลังจากย้าย EPM บริษัทไว้เครื่อง 101 โดย PAIROJ
	     $user_epm = "sapphire";
		 $pass_epm = "sprd!@#$%";
		 $dbepm = "epm";
		 $db_sitemonitor = "datasite_monitor";
		 
		$arr_month = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$DateNData = "<DIV style='font-size:16px;text-align:right;font-weight:normal;'>รายงาน ณ วันที่ ".intval(date("d"))." ".$arr_month[intval(date("m"))]." ".(date("Y")+543)."</DIV>"; // ข้อมูล ณ.วันที่	
		$DateNData1 = " 1 เมษายน 2554";
		
		#ชื่อแบบฟอร์ม เอกสาร
		$str_pdf_elec = "ก.พ.7";


	
	$graph_path = APHTTP."$hostgraph/graphservice/graphservice.php";  //Sapphire Graph
	
	function ConHost($host,$user,$pass){
		
				$myconnect = @mysql_connect($host,$user,$pass) OR DIE("Unable to connect to database :: $host ");
				$iresult = @mysql_query("SET character_set_results=tis-620");
				$iresult = @mysql_query("SET NAMES TIS620");
			return $myconnect;
	}
	########
	
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
//echo $sql_sel."<br>";
$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
$rs_sel = mysql_fetch_assoc($result_sel);
$xdbname = "$s_db".$siteid;

//echo "$rs_sel[intra_ip], ".USERNAME_HOST.", ".PASSWORD_HOST." ".$xdbname;
if($siteid == ""){
 $myconnect = mysql_connect(HOST_TEMP, USERNAME_HOST, PASSWORD_HOST)or die("Unable to connect to database");
 @mysql_select_db('temp_check_data') or die( "<center>ไม่สามารถติดต่อฐานข้อมูลที่ท่านเรียกได้</center>");
}else{
 
 $myconnect = mysql_connect($rs_sel[intra_ip], USERNAME_HOST, PASSWORD_HOST)or die("Unable to connect to database");
 @mysql_select_db($xdbname) or die( "<center>ไม่สามารถติดต่อฐานข้อมูลที่ท่านเรียกได้</center>");
 
}


$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

} // end function con_db($siteid){


function conn2DB()
{ 


    $conn = mysql_connect( HOST,USERNAME_HOST,PASSWORD_HOST );
    if (!$conn)
	die ("ไม่สามารถติดต่อกับ MySql ได้ ");
  mysql_select_db($db_name,$conn) 
	   or die ("ไม่สามารถเลือกใช้ฐานข้อมูลได้ ");

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

function conDB($host="",$username="", $password=""){
		$host = ($host!="")?$host:HOST;
		$username = ($username!="")?$username:USERNAME_HOST;
		$password = ($password!="")?$password:PASSWORD_HOST;
		$myconnect = mysql_connect($host, $username, $password ) or die("Unable to connect to database :: $host ");
		$iresult = mysql_query("SET character_set_results=tis-620");
		$iresult = mysql_query("SET NAMES TIS620");
		if(!$myconnect){
			return false;
		}else{
			return true;
		}
}


?>
