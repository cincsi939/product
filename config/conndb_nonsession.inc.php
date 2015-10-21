<?
/**
* @comment ตรวจสอบการคำนวณคะแนน
* @projectCode PS56DSDPW04
* @tor -
* @package core
* @author Kidsana Paya
* @access private
* @created 16/05/2014
*/
$SERVER_ID=1; //man server www.pdc-obec.com
if ($ob_bypass ==""){  ob_start(); } 
if ($secid_bypass != ""){ $_SESSION[secid]= $secid_bypass ; }
//data database
$host = "localhost"  ;
$username = "family_admin"  ;
$password = "F@m!ly[0vE"  ;
//@modify Kidsana 16/05/2014 แก้ไขชื่อฐานข้อมูล
$db_name = "question_project";
//@end
$dbsystem = "obec_system";
//system data base
$sysdbname ="vc2_system_db"  ;
//province data
$prov_name = "สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน"    ;
$ministry_name = "กระทรวงศึกษาธิการ";
$prov_name_en = "OBEC"    ;
$connect_status =   "On line"   ;
$mainwebsite = "http://www.221.128.0.108/vc/"  ;
$admin_email    = " vcsystem@sapphire ";  
$servergraph = "202.69.143.77";
//$vcserverip = "202.69.143.76"; //down on 9/6/2550
$vcserverip = "61.7.155.244";
$policyFile="http://61.19.88.5:81/project/domainaccess.xml";
$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database  ");
@mysql_select_db($db_name) or die( "Unable to select database");


$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$dbname = $db_name;
?>