<?
session_start();
include("../../config/conndb_nonsession.inc.php");
$nochecklogin= true;
include "epm.inc.php";
$time_am = "08:30:00";
$time_am1 = "17:30:00";
$time_pm = "17:30:00";
$time_pm1 = "23:00:00";
//echo "เวลา : ".date("H:i:s");


$ipn = getenv("SERVER_NAME"); 
if(substr($ipn,0,8) == "192.168."){
		header("Location: http://".APPHOST.APPNAME."application/userentry/login.php");
}



$time_curent = date("H:i:s");
function CheckLogin($get_staffid){
	$sql_login = "SELECT COUNT(staffid) AS numL FROM keystaff WHERE staffid='$get_staffid' AND status_extra='NOR' GROUP BY staffid";
	$result_login = mysql_db_query(DB_USERENTRY,$sql_login);
	$rs_login = mysql_fetch_assoc($result_login);
	return $rs_login[numL];
}//end function CheckLogin(){


if ($_SERVER[REQUEST_METHOD] == "POST"){ 
	$result = mysql_query("select * from $epm_staff where username='$uname';");
	$rs = mysql_fetch_assoc($result);
	//echo "select * from $epm_staff where username='$uname'";
	//echo "select * from $logintable where username='$uname';"; die;
	#### กำหนดช่วงเวลาในการ login
	  //print_r($rs);die;  and CheckLogin($rs[staffid]) > 0
	  
	  	if($rs[status_permit] == "NO"){
		echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้ รหัสผู้ใช้นี้ได้ถูกระงับสิทธิการใช้โปรแกรมเนื่องจากสิ้นสุดการจ้าง'); location.href='login.php';</script>";
		exit;
	}
	  
	/*if($rs[period_time] == "am" and  $rs[sapphireoffice] == "0" and CheckLogin($rs[staffid]) > 0){
			if(($time_curent > $time_am1) or ($time_curent < $time_am)){
			addLog("",8,"พยายาม login เป็น $uname ด้วยรหัสผ่าน $pwd ในช่วงเวลา 09.00 น. - 17.30 น.");
			echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้ เนื่องจากเวลาในการเข้าระบบของท่านคือ 09.00 น. - 17.30 น.'); location.href='login.php';</script>";
			exit;
			}//end if(($time_curent > $time_am1) or ($time_curent < $time_am)){
	}else if($rs[period_time] == "pm" and  $rs[sapphireoffice] == "0" and CheckLogin($rs[staffid]) > 0){
			if(($time_curent > $time_pm1 ) or ($time_curent < $time_pm)){
			addLog("",8,"พยายาม login เป็น $uname ด้วยรหัสผ่าน $pwd ในช่วงเวลา18.00 น. - 22.00 น.");
			echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้ เนื่องจากเวลาในการเข้าระบบของท่านคือ 18.00 น. - 22.00 น.'); location.href='login.php';</script>";
			exit;	
			}
	}*/
	### end กำหนดช่วงเวลาในการ login
	

	if ($rs && $pwd  == $rs[password]){

		$_SESSION[session_username] = $uname;
		$_SESSION[session_staffid] = $rs[staffid];
		$_SESSION[session_dev_id] = $rs[org_id];
		$_SESSION[session_depusername] = $rs[username];
		$_SESSION[session_fullname] = $rs[prename] . " " . $rs[staffname] . " " . $rs[staffsurname];
		$_SESSION[session_staffname] = "$rs[staffname]";
		$_SESSION[session_sapphire] = $rs[sapphireoffice];
		$_SESSION[session_depname] = "sapphire";
		$_SESSION[session_status_extra] = $rs[status_extra]; // สถานะงานพิเศษเช่นตรวจสอบงาน, ฝ่ายบัญชี
		$_SESSION[session_sex] = $rs[sex];
		$_SESSION[sesion_sec] = $rs[period_time];
		
				## กรณีที่ login เป็นพนักงานคีย์ข้อมูลข้างนอก
		$sql_key = "SELECT  siteid FROM tbl_asign_key WHERE staffid='$rs[staffid]'  group by siteid";
		$result_key = mysql_db_query($db_name,$sql_key);
		while($rs_key = mysql_fetch_assoc($result_key)){
			if($temp_siteid > "") $temp_siteid .= ",";
			$temp_siteid .= "'$rs_key[siteid]'";
			$arr_siteid[$rs_key[siteid]] = $rs_key[siteid];
		}
		$_SESSION[session_key_siteid] = $temp_siteid;
		$_SESSION[session_arr_siteid] = $arr_siteid;
	##  end กรณีที่ login เป็นพนักงานคีย์ข้อมูลข้างนอก

		

		addLog("",9,"Login เป็น $uname");
		if ($uname == "root" || ($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]) ){
			header("Location: login_admin.php");
		}else{
			header("Location: login_main.php");
		}
		exit;
	}

	//8=login fail, 9 = login , 10 = logout
	addLog("",8,"พยายาม login เป็น $uname ด้วยรหัสผ่าน $pwd");
	$msg = "Username หรือ Password ไม่ถูกต้อง";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Data Entry Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../common/style.css" rel=stylesheet>
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
.style1 {font-size: 18px}
-->
</style>
</head>
<body  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#273F6F', EndColorStr='#ffffff');">
<table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="694" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
      
      <tr>
        <td style="border:#818181 solid 1px; "><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" class="table_head_text style1">ระบบบันทึกข้อมูลข้าราชการครูและบุคลากรทางการศึกษา สนง.ก.ค.ศ. </td>
          </tr>
          <tr>
            <td><img src="images/collage.jpg" width="780" height="149"></td>
          </tr>
          <tr>
            <td align="center" style=" padding:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
              <tr>
                <td width="463" background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top"><form METHOD=POST ACTION="">
                  <br>
                  <table width="420" border=0 align=center>
                    <tr>
                      <td width="150" rowspan="4" align="right" style="color:#FFFFFF"><img src="images/key.jpg" width="150" height="112"></td>
                      <td width="59" align="right" style="color:#FFFFFF">&nbsp;</td>
                      <td width="1" align="left">&nbsp;</td>
                      <td width="192" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><b>Username</b></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input NAME="uname" TYPE="text" class="epm_inputbox" value="" size=20 maxlength=20></td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><b>Password</b></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input NAME="pwd" TYPE="password" class="epm_inputbox" value="" size=20 maxlength=20></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input name="submit" type=submit class="epm_button" value="   Login   "> </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="right" style="color:#FFFFFF"><span style="color:#666666"><b><a href="forget_password.php" target="_blank">คลิ๊กกรณีลืม Password</a></b></span></td>
                      </tr>
                    
                    <tr>
                      <td colspan="4" align="center"><div align="center"><font color="RED"><b>
                          <?=$msg?>
                      </b></font></div></td>
                    </tr>
                  </table>
                  </form></td>
                </tr>
              <tr>
                <td align="right" background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top"><a href="http://202.129.35.104/wordpress/" target="_blank">เข้าสู่ webblog เพื่อแลกเปลี่ยนความคิดเห็นและความรู้</a></td>
              </tr>
              
              
            </table></td>
          </tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
</table>
</body>
</html>
