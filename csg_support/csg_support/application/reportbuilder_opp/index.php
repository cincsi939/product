<?
/**
 * @comment index
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    04/08/2014
 * @access     public
 */
/*****************************************************************************
Function		: หน้าหลักของระบบ / เลือก Database Connection ในการทำงาน
Version			: 1.0
Last Modified	: 27/7/2548
Changes		:
	27/7/2548 - รองรับการแก้ไขค่าของการเชื่อมต่อฐานข้อมูล

*****************************************************************************/
session_start();

if(isset($_SESSION['uname'])){
	header("Location: report_manage.php");
}else{
	header("Location: login.php");
}
exit;



$notconnect = "yes";
include "db.inc.php";

function ConnectDB($host,$db,$usr,$pwd){ 
	$conn = @mysql_connect( $host,$usr,$pwd);
	if (!$conn){
		return "Cannot connect to specific host.";
	}

	if (!@mysql_select_db($db,$conn)){
		  return "Cannot select specific database.";
	}

	$reporttable = array("reportinfo","cellinfo","paraminfo","templateinfo");

	for ($i=0;$i<count($reporttable);$i++){
		$result = mysql_query("select * from " . $reporttable[$i] . " limit 1;",$conn);
		if (mysql_errno($conn) != 0){
			return "Cannot find Report Data in this database.";
		}
	}

	return "";
}

$msg = "";
if ($_SERVER[REQUEST_METHOD] == "POST"){ 
	
	$_SESSION[newdb] = "";  // reset SETTING

	$msg = ConnectDB($_POST[host],$_POST[dbname],$_POST[user],$_POST[pwd]);

	if (isset($_POST[test])){ // Testing Connection
		if ($msg == ""){
			$msg = "<FONT COLOR='GREEN'>Connection is valid.</FONT>";
		}

		$host = $_POST[host];
		$dbname =  $_POST[dbname];
		$user = $_POST[user];
		$pwd = $_POST[pwd];

	}else{ // Connect 
		if 	($msg == ""){  // no error, valid connection
			$_SESSION[newdb] = "yes";
			$_SESSION[xhostname] = $_POST[host];
			$_SESSION[xdbname] = $_POST[dbname];
			$_SESSION[xuser] = $_POST[user];
			$_SESSION[xpwd] = $_POST[pwd];

			header("Location: report_manage.php");
			exit;
		}
	}



}else{ // GET
	$host = $hostname;
	$dbname = $db_name;
	$user = $db_username;
	$pwd = $db_password;
}

?>
<html>
<head>
<title>Report Management : Main</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#FFFFFF">
<BR>
<CENTER><h2><FONT COLOR="#336699">Setting Database Connection</FONT></h2></CENTER>

<FORM ACTION="?" METHOD=POST>
<table border=0 cellspacing=0 cellpadding=3 align=center>
<tr>
<td><B>Activate Host</B></td>
<td><INPUT TYPE="text" NAME="host" size="20" maxlength=100 value="<?=$host?>"></td>
</tr>

<tr>
<td><B>Database Name</B></td>
<td><INPUT TYPE="text" NAME="dbname" size="20" maxlength=100 value="<?=$dbname?>"></td>
</tr>

<tr>
<td><B>UserName</B></td>
<td><INPUT TYPE="text" NAME="user" size="20" maxlength=100 value="<?=$user?>"></td>
</tr>

<tr>
<td><B>Password</B></td>
<td>
<INPUT TYPE="password" NAME="pwd" size="20" maxlength=100 value="<?=$pwd?>">
<INPUT TYPE="submit" NAME="test" VALUE=" Test Connection " class="xbutton" style="height: 22;">
</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>
<INPUT TYPE="submit" NAME="connect" VALUE=" Connect " class="xbutton" style="width: 140; height: 30;">
</td>
</tr>

</table>
</FORM>

<CENTER><FONT SIZE="+1" COLOR="RED"><b><?=$msg?></b></FONT></CENTER>


</body></html>