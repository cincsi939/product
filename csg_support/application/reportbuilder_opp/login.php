<?php
/**
 * @comment check login
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/07/2014
 * @access     public
 */
require_once "report.db.inc.php";
// @modify Phada Woodtikarn 21/07/2014 Check Login
$msg = "";
if(isset($_GET['logout'])){
	session_destroy();
	if(isset($_SESSION['uname']) || isset($_SESSION['priv'])){
		unset($_SESSION['uname']);
		unset($_SESSION['priv']);
	}
}
if(isset($_POST['xuname'])){
	$sql = "SELECT pwd,priv FROM userinfo WHERE uname = '".$_POST['xuname']."'";
	$result = mysql_query($sql);
	$rs = mysql_fetch_assoc($result);
	if($rs){
		if($_POST['pwd']  == $rs['pwd']){
			$_SESSION['uname'] = $_POST['xuname'];
			$_SESSION['priv'] = $rs['priv'];
			header("Location: report_manage.php");
			exit;
		}else{
			$msg = 'Incorrect password';
		}
	}else{
		$msg = 'Incorrect password';
	}
}
// @end
?>
<html>
<head>
<title>Report Management : Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#A3B2CC">

<BR><BR><BR>
<FORM METHOD="POST" ACTION="login.php">
<TABLE ALIGN=CENTER BORDER=0>
<TR>
	<TD>Username :</TD><TD><INPUT TYPE="text" NAME="xuname" value="admin"></TD>
</TR>
<TR>
	<TD>Password :</TD><TD><INPUT TYPE="password" NAME="pwd"></TD>
</TR>
<!--<TR>
	<TD>Connect to</TD>
	<TD>
	<INPUT TYPE="radio" NAME="connect" value="mySQL" checked> mySQL
	<INPUT TYPE="radio" NAME="connect" value="ODBC"> ODBC
	</TD>
</TR>-->
<tr>
	<td></td>
	<td style="font-size:11px;color:red;"><?php echo $msg ?></td>
</tr>
<TR>
	<TD COLSPAN=2 ALIGN=CENTER><BR><BR><INPUT TYPE="submit" VALUE="   Login   ">
	<INPUT TYPE="reset" VALUE="   Cancel   "></TD>
</TR>
</TABLE>
</FORM>
<BR><BR><BR><BR>

</body></html>