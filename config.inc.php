<?php
/**
 * @comment 		connect db and config
 * @projectCode	P1
 * @tor
 * @package			core
 * @author			Eakkaksit Kamwong
 * @created			31/08/2015
 * @access			public
 */
include('define_db.php');
include('define_host.php');
include('define_var.php');

$host = "localhost"  ;
$username = "wandc"  ;
$epm_password = "c;ofu:u"  ;
$password = "c;ofu:u"  ;
// $username = "family_admin"  ;
// $epm_password = "F@m!ly[0vE"  ;
// $password = "F@m!ly[0vE"  ;
$epm_username = "sapphire"  ;
$connect_status =   "On line"  ;
$mainwebsite = "";
$servergraph = "123.242.173.136";
$show_title = "ระบบสำนักงานอัตโนมัติ";
$province = "Sapphire Research and Development";
$provincename = "แซฟไฟร์  รีเสิร์ช แอนด์ ดีเวลล็อปเม็นท์";
$province_code = "13000000";
$fullname="บริษัท $provincename จำกัด";


$manual_path="http://123.242.173.131/download/e-office_manual.rar";
$manual_show="on";						# เปิด ปิด / โชวคู่มือ
$fix_gennum_atlast=="off";				# เปิด ปิด / fix /autunumber ่ "/xxxx"  ไว้ท้ายเสมอ (รูปแบบหนังสือ ศูยน์ราชการ)

$dbname = DB_XMLSERVICE  ;				# ฐานข้อมูลที่ใช้งาน

$db_epm="epm";							# ฐานข้อมูลที่เชื่อมกับ epm
$perpage="30";								# Dart ต่อ หน้า
$signby="off";									# MODE ลงนามแทน


$db_mode="self";							//epm //self โหมดรายการ staff

if($db_mode=="self"){
$table_staff=$dbname.".epm_staff";
}
if($db_mode=="epm"){
$table_staff=$db_epm.".epm_staff";
}

$table_mainmenu		= $dbname.".main_menu";
$table_staffgroup		= $dbname.".epm_staffgroup";
$table_groupmember	= $dbname.".epm_groupmember";
$profile_staffgroup		= $dbname.".profile_staffgroup";
$profile_groupmember	= $dbname.".profile_groupmember";

$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database");
mysql_select_db($dbname) or die("cannot select database $dbname");;
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

if ($_SESSION[session_depusername] == "infoadmin") $isAdmin = true; else $isAdmin = false;
if ($_SESSION[session_depusername] == "infoadmin") $isFinance = true; else $isFinance = false;


if (!$nochecklogin){
	if ($_SESSION[session_staffid] <= 0){
		echo " <script language=\"JavaScript\">  alert(\" กรุณา loginเข้าสู่ระบบอีกครั้ง \") ;
		location.href='http://".$_SERVER['HTTP_HOST']."/".TXT_DCY_USERMANAGER."/'; </script>  " ;
		exit;
	}
}

#$wordingset = array("0"=>" $fullname","1"=>array("ประธานกรรมการ $fullname","ผู้จัดการโครงการ $fullname"));
$wordingset = array("0"=>" $fullname","1"=>array(" "  ));
$show_text_size="280";					# ความกว้างของ text box
$wordingposition="show";
$sercet_select="off";						// เปิด ปิด ระบบ เลือกชั้นความลับ
$flag_secret="on";					// เปิด ปิด ระบบหนังสือลับ

### SEND_CIRCULAR MERGE
$send_circular_merge="on";  //  เปิดระบบ ให้ ใช้ตัวเลข หนังสือส่งและเวียน ตัวเดียวกัน โดยใช้ตัวหลักเป็นตัวเลขจากหนังสือส่ง

### SMS config
$sms_mode='on'; // เปิดระบบการส่ง sms
$sms_host="www.sms.in.th";
$sms_method="POST";
$sms_path="/tunnel/sendsms.php";

$sms_RefNo="1001";//1001-9999
$sms_MsgType="T";
$sms_Sender="Eoffice";
$sms_User="sapphire";
$sms_Password="es53y7h";
$sms_defualt_mobile="086676915";
### SMS config
?>
