<?
session_start();
include("checklist.inc.php");


//echo "ip :: ".$_SERVER['SERVER_ADDR']."<br>";
//echo "ip2 :: ".$_SERVER['SERVER_NAME']."<br>";
//echo "ip3 ::".getenv("SERVER_NAME"); 

$ipn = getenv("SERVER_NAME"); 
if(substr($ipn,0,8) != "192.168."){
		header("Location: http://192.168.2.12/competency_master/application/checklist_kp7_management/login_ip.php");
}

if ($_SERVER[REQUEST_METHOD] == "POST"){ 
	$result = mysql_db_query($dbcallcenter_entry,"select * from keystaff where username='$uname';");
	$rs = mysql_fetch_assoc($result);  //print_r($rs);die;
	if($rs[status_permit] == "NO"){
		echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้ รหัสผู้ใช้นี้ได้ถูกระงับสิทธิการใช้โปรแกรมเนื่องจากสิ้นสุดการจ้าง'); location.href='login.php';</script>";
		exit;
}
///	echo $rs[username]." ::  $rs[password]";die;
	if ($rs[username] == "$uname"  && $pwd  == $rs[password]){
		$_SESSION[session_username] = $uname;
		$_SESSION[session_staffid] = $rs[staffid];
		$_SESSION[session_dev_id] = $rs[org_id];
		$_SESSION[session_depusername] = $rs[username];
		$_SESSION[session_fullname] = $rs[prename] . " " . $rs[staffname] . " " . $rs[staffsurname];
		$_SESSION[session_sapphire] = $rs[sapphireoffice];
		$_SESSION[session_depname] = "sapphire";
		$_SESSION[session_status_extra] = $rs[status_extra]; // สถานะงานพิเศษเช่นตรวจสอบงาน, ฝ่ายบัญชี
		
		

		addLog(9,"Login เป็น $uname");
		if ($uname == "root" || ($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]) ){
			header("Location: index_main.php");
		}else{
			header("Location: index_main.php");
		}
		exit;
	}else{

	//8=login fail, 9 = login , 10 = logout
	addLog(8,"พยายาม login เป็น $uname ด้วยรหัสผ่าน $pwd");
	$msg = "Username หรือ Password ไม่ถูกต้อง";
	
	}//end if ($rs[username] == "$uname"  && $pwd  == $rs[password]){
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-size: 18px;
	color: #000000;
}
-->
</style>
</head>
<body  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#273F6F', EndColorStr='#ffffff');">
<table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="694" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
      
      <tr>
        <td bgcolor="#ECECEC" style="border:#818181 solid 1px; "><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="50" align="center" bgcolor="#ECECEC"><span class="style1">ระบบตรวจสอบเอกสารทะเบียนประวัติอิเล็กทรอนิกส์ต้นฉบับ</span></td>
          </tr>
          <tr>
            <td align="center" style=" padding:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
              <tr>
                <td width="463" background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top"><FORM METHOD=POST ACTION="">
                  <br>
                  <table width="420" border=0 align=center>
                    <tr>
                      <td width="150" rowspan="4" align="right" style="color:#FFFFFF"><img src="images/emp_main_new_19.gif" width="79" height="88"></td>
                      <td width="59" align="right" style="color:#FFFFFF">&nbsp;</td>
                      <td width="1" align="left">&nbsp;</td>
                      <td width="192" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><B>Username</B></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><INPUT NAME="uname" TYPE="text" class="epm_inputbox" value="" size=20 maxlength=20></td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><B>Password</B></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><INPUT NAME="pwd" TYPE="password" class="epm_inputbox" value="" size=20 maxlength=20></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input name="submit" type=submit class="epm_button" value="   Login   "></td>
                    </tr>
                    
                    <tr>
                      <td colspan="4" align="center"><div align="center"><font color="RED"><b>
                          <?=$msg?>
                      </b></font></div></td>
                    </tr>
                  </TABLE>
                  </FORM></td>
                </tr>
              <tr>
                <td background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top">&nbsp;</td>
              </tr>
              <tr>
                <td background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top">&nbsp;</td>
              </tr>              
            </table></td>
          </tr>
          <tr>
            <td align="center" style=" padding:10px;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
