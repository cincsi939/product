<?php
/**
* @comment ไฟล์ config สำหรับเชื่อมต่อฐานข้อมูล
* @projectCode 56EDUBKK01
* @tor 7.2 (Opt.)
* @package core
* @author suwat khamtum (or ref. by "EDUBKK" path "/edubkk_master/config/config_hr.inc.php")
* @access private
* @created 10/01/2014
*/



session_start();
include("define_config_db.php");
include("cmss_var.inc.php");
include("cmss_var_config_linepagekp7.php");
include("cmss_define.php");
include("config_define_tables.php");

$mainwebsite = "http://master.cmss-edubkk.com/edubkk_master/";

if($secid != ""){
	$_SESSION[secid] = $secid ;
	$dbname = STR_PREFIX_DB.$secid;
	$siteid = $_SESSION[secid];
}

if($sentsecid != ""){
	$_SESSION[secid] = $sentsecid ;
	$dbname = STR_PREFIX_DB.$sentsecid;
	$siteid = $_SESSION[secid];
}

if($_SESSION[secid]=="edubkk_master"){
	$dbname = DB_MASTER;
	$siteid = 0;
}else if($_SESSION[secid]==""){
	echo " <script language=\"JavaScript\">  alert(\" กรุณา loginเข้าสู่ระบบอีกครั้ง \") ; </script>  " ;   
	echo " <script language=\"JavaScript\"> top.location.replace('$mainwebsite') </script>  " ;  
	die;
}else{
	$dbname = STR_PREFIX_DB.$_SESSION[secid];
	$siteid = $_SESSION[secid];
}



//echo " Connect:::::   $dbname";

$hr_dbname = $dbname;
$aplicationpath=STR_PREFIX_DB."master";
$dbnamemaster =STR_PREFIX_DB."master"  ;
$dbsystem = STR_PREFIX_DB."system";

//system data base
$gov_name = ""    ;
$ministry_name = "";
$gov_name_en = ""    ;
$connect_status =   ""   ;

$admin_email    = "";  
$servergraph = "202.129.35.106";
$masterserverip = "";
$policyFile="";
$array_full_siteid = array('5001','5002','5003','5004','5005','5006','4001','6002','6601','4005','6302','4101','7102','3405');
$array_notfull_siteid = array('3303','6502','6702','6301','8602','5101','7002','7103','7302','4802','5701','7203');


//echo HOST." ". USERNAME_HOST ." ".PASSWORD_HOST;
#echo "db::".$dbname."<hr>";
$myconnect = mysql_connect(HOST, USERNAME_HOST, PASSWORD_HOST) OR DIE("Unable to connect to database  ");
@mysql_select_db($dbname) or die( "<center>ไม่สามารถติดต่อฐานข้อมูลที่ท่านเรียกได้ <br> อาจเกิดจากท่านใส่รหัสพื้นที่(Siteid, $dbname )ผิด <br> กรุณาตรวจสอบอีกครั้งนะxxxx! </center>");


$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");


include("authen_user.inc.php");

?>