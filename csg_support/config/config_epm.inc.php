<?php
	require_once('config_host.php');
	session_start();
	header("Content-Type: text/html; charset=windows-874"); //แก้ไขปัญหาการดึงข้อมูล
	$username = "family_admin"  ;
	$password = "F@m!ly[0vE"  ;
	$dbname ="$dbname"  ;
	$db_mainobec = "obec"; 
	//system data base
	$sysdbname ="vc2_system_db"  ;
	//province data
	$prov_name = "กองประสานโครงการสายใยรักแห่งครอบครัว"    ;
	$prov_name_en = "OBEC"    ;
	$connect_status =   "On line"   ;
	$mainwebsite = "http://www.221.128.0.108/vc/"  ;
	$admin_email    = " vcsystem@sapphire ";  
	$servergraph = "202.129.35.106";
	$IP_FILE_SERVER = '61.19.255.77';
	
	$policyFile="http://61.19.88.5:81/project/domainaccess.xml";
	$host = "localhost";
	$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to databasex  ");
	
	
	//$logintable = "$db_dataentry.login";
	//$officetable = "$db_dataentry.office_detail";
	$logintable = "main_menu";
	$officetable = "main_menu";
	$ministytable = "ministry_lbl";
	$departtable = "department_lbl" ;
	$maintbl = "main_menu";
	
	
	$dbname = DB_DATA;
	mysql_select_db($dbname) or die("cannot select database $dbname");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
	//ระบบงับการใช้
/*	echo "<SCRIPT>window.location='http://202.129.35.104/saiyairak_master/application/usermanager/chpage.php'</SCRIPT>";*/
	
	//check admin
	if ($_SESSION[session_depusername] == "infoadmin") $isAdmin = true; else $isAdmin = false;
	if ($_SESSION[session_depusername] == "infoadmin") $isFinance = true; else $isFinance = false;
	
	/*if (!$nochecklogin){
		if ($_SESSION[session_staffid] <= 0){
			echo " <script language=\"JavaScript\">  alert(\" กรุณา loginเข้าสู่ระบบอีกครั้ง \") ;  
			location.href='http://www.familylove.go.th'; </script>  " ;  
			exit;
		}
	}*/
	
	

?>