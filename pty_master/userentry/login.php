<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "login"; 
$process_id			= "login";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		�к� login userentry
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
$nochecklogin= true;
include "epm.inc.php";

include ("../../common/common_competency.inc.php")  ;

include ("function_face2cmss.php");

include ("function_login_authority_new.php");

if($_SERVER['SERVER_NAME'] == APPHOST_TEST){
	$url = APPURL.APPNAME."application/sapphire_app/";
	header("Location: $url");
}//end if($_SERVER['SERVER_NAME'] == APPHOST_TEST){

//if($_SERVER['SERVER_NAME'] == APPHOST_TEST){
//	$url = APPURL."/edubkk_master/application/userentry/login.php";
	//header("Location: $url");
//}//end if($_SERVER['SERVER_NAME'] == APPHOST_TEST){



if(APPHOST=="202.29.35.104" || APPHOST_INTRA=="192.168.1.12"){
     $fromuserip=get_real_ip();
	 $arr_APPHOST=explode(".",APPHOST);	 
	 $arr_INTRA=explode(".",APPHOST_INTRA);
	 $arr_user=explode(".",$fromuserip);	 
	 $str_userip=$arr_user[0].".".$arr_user[1];
	 $str_APPHOST=$arr_APPHOST[0].".".$arr_APPHOST[1];
	 $str_INTRA=$arr_INTRA[0].".".$arr_INTRA[1];
		if($str_userip==$str_APPHOST || $str_userip==$str_INTRA){
		     //   header("Location: login.php");
		}else{
		        header("Location: ".APPURL."/edubkk_master/application/userentry/login.php");
				// die();
		}
	}

//check_redirec();
$time_am = "08:30:00";
$time_am1 = "17:30:00";
$time_pm = "17:30:00";
$time_pm1 = "23:00:00";



//echo "���� : ".date("H:i:s");


/*$ipn = getenv("SERVER_NAME"); 
if(substr($ipn,0,8) == "192.168."){
		header("Location: http://".APPHOST."/edubkk_master/application/userentry/login.php");
}
*/


$time_curent = date("H:i:s");
function CheckLogin($get_staffid){
	$sql_login = "SELECT COUNT(staffid) AS numL FROM keystaff WHERE staffid='$get_staffid' AND status_extra='NOR' GROUP BY staffid";
	$result_login = mysql_db_query("edubkk_userentry",$sql_login);
	$rs_login = mysql_fetch_assoc($result_login);
	return $rs_login[numL];
}//end function CheckLogin(){


		
//if ($_SERVER[REQUEST_METHOD] == "POST"){ 
if($_POST["submit"]){
	$result = mysql_query("select * from $epm_staff where username='$uname';");
	$rs = mysql_fetch_assoc($result);
	//echo "select * from $epm_staff where username='$uname'";
	//echo "select * from $logintable where username='$uname';"; die;
	#### ��˹���ǧ����㹡�� login
	  //print_r($rs);die;  and CheckLogin($rs[staffid]) > 0
	  //echo $rs['card_id'];
	
	######  check �ѹ�������㹡�� login  by kamonchai ######

	/* 	$date_login = date('Y-m-d');
		$time_login=date('H:i:s');
		$timestamp = strtotime($time_login); //���� login Ẻ timestamp
		$dayid_login = date('w')+1; // �����ѹ  ���ӡ�� login */
		/* $checkLogin = getCheckLogin($_POST['uname'],$_POST['pwd'],$dayid_login,$timestamp,$date_login);
		//echo $checkLogin[0];
		//��ҹ�������ö�������к������ͧ�ҡ��ҹ���ѧ������ͧ����������㹡�� login ��Һѹ�֡�����Ţͧࢵ 177 ࢵ
		if($checkLogin[0] == '0'){
			echo '<script>
					alert("�������ö�������к��� ���ͧ�ҡ\n'.$checkLogin[1].'"); 
					location.href="login.php";
					</script>';
					exit;
		} */
		/* elseif($checkLogin[0] == '1'){
			echo $checkLogin[1];	
		} */

	
		#######  end check �ѹ�������㹡��  login  ########
		
	  ### block ��ä���
/* 	  $sql_staff= "SELECT count(staffid) as numstaff from $epm_staff where username='$uname'  and password='$pwd' and staffid IN(SELECT staffid FROM authority_math_profile) ";
	  $result_staff = mysql_query($sql_staff);
	  $rs_staff = mysql_fetch_assoc($result_staff);
	  $datekey1 = date("Y-m-d");
	  #$sql_day1 = "SELECT DAYOFWEEK('".$datekey1."') AS day1";
	  $sql_date = mysql_query("SELECT DAYOFWEEK('".$datekey1."') AS day1 ");
	  $rsdate = mysql_fetch_assoc($sql_date);
	  $h1 = intval(date("H")); */
	  
	#echo   "$sql_day1<br>$rsdate[day1] =>  $rsdate[day1]  =>  $rs_staff[numstaff] => $h1";die();
/*	  if($rsdate[day1] >1 and $rsdate[day1]  < 7 and $rs_staff[numstaff] > 0 ){
			#if($h1 >=8 and $h1 <= 17){
		  	echo "<script>alert('��úѹ�֡������ update ����Ѻ���ʡ����ҹ�ͧ��ҹ����ö�ӧҹ��੾���ѹ�������ҹ�� �ҡ�բ��ʧ��¡�سҵԴ��ͷ���ٹ���Ҥ'); location.href='login.php';</script>";
			exit;
		  #}
		}*/
	 ### end block ��ä���
	  
	  
	  	if($rs[status_permit] == "NO"){
			echo "<script>alert('�������ö�������к��� ���ʼ��������١�ЧѺ�Է�ԡ������������ͧ�ҡ����ش��è�ҧ'); location.href='login.php';</script>";
			exit;
		}
		### ��Ǩ�ͺ��������ҹ�к� By suwat
		$day_now = date("w")+1;
		#echo "�ѹ :".$day_now."<br>";die();
		$arr_authority = CheckAuthorityLogin($rs[staffid],$rs[card_id],$day_now); # �Է�ԡ�������ҹ�к�
		#echo "<pre>";
		#print_r($arr_authority);die();
		if($arr_authority[0] == "0"){ ## �������ö�������к���
			$msg_alert = "�������ö�������к���  ".str_replace("||"," \\n ",$arr_authority[1]);
			#echo "msg => ".$msg_alert;
			echo "<script>alert('".$msg_alert."'); location.href='login.php';</script>";
			exit;	
		}
		
		
	  
	/*if($rs[period_time] == "am" and  $rs[sapphireoffice] == "0" and CheckLogin($rs[staffid]) > 0){
			if(($time_curent > $time_am1) or ($time_curent < $time_am)){
			addLog("",8,"������ login �� $uname �������ʼ�ҹ $pwd 㹪�ǧ���� 09.00 �. - 17.30 �.");
			echo "<script>alert('�������ö�������к��� ���ͧ�ҡ����㹡������к��ͧ��ҹ��� 09.00 �. - 17.30 �.'); location.href='login.php';</script>";
			exit;
			}//end if(($time_curent > $time_am1) or ($time_curent < $time_am)){
	}else if($rs[period_time] == "pm" and  $rs[sapphireoffice] == "0" and CheckLogin($rs[staffid]) > 0){
			if(($time_curent > $time_pm1 ) or ($time_curent < $time_pm)){
			addLog("",8,"������ login �� $uname �������ʼ�ҹ $pwd 㹪�ǧ����18.00 �. - 22.00 �.");
			echo "<script>alert('�������ö�������к��� ���ͧ�ҡ����㹡������к��ͧ��ҹ��� 18.00 �. - 22.00 �.'); location.href='login.php';</script>";
			exit;	
			}
	}*/
	### end ��˹���ǧ����㹡�� login
	

	if ($rs && $pwd  == $rs[password]){
		
		$_SESSION[session_username] = $uname;
		$_SESSION[session_staffid] = $rs[staffid];
		$_SESSION[session_dev_id] = $rs[org_id];
		$_SESSION[session_depusername] = $rs[username];
		$_SESSION[session_fullname] = $rs[prename] . "" . $rs[staffname] . " " . $rs[staffsurname];
		$_SESSION[session_staffname] = "$rs[staffname]";
		$_SESSION[session_sapphire] = $rs[sapphireoffice];
		$_SESSION[session_depname] = "sapphire";
		$_SESSION[session_status_extra] = $rs[status_extra]; // ʶҹЧҹ������蹵�Ǩ�ͺ�ҹ, ���ºѭ��
		$_SESSION[session_sex] = $rs[sex];
		$_SESSION[sesion_sec] = $rs[period_time];
		$_SESSION[session_site] = $rs[site_area]; 
		$_SESSION[status_report_excellent] = $rs[status_report_excellent]; 
		$_SESSION[session_sub] = $rs[status_adminsub];
		
				## �óշ�� login �繾�ѡ�ҹ��������Ţ�ҧ�͡
		$sql_key = "SELECT  siteid FROM tbl_asign_key WHERE staffid='$rs[staffid]'  group by siteid";
		$result_key = mysql_db_query($db_name,$sql_key);
		while($rs_key = mysql_fetch_assoc($result_key)){
			if($temp_siteid > "") $temp_siteid .= ",";
			$temp_siteid .= "'$rs_key[siteid]'";
			$arr_siteid[$rs_key[siteid]] = $rs_key[siteid];
		}
		$_SESSION[session_key_siteid] = $temp_siteid;
		$_SESSION[session_arr_siteid] = $arr_siteid;
	##  end �óշ�� login �繾�ѡ�ҹ��������Ţ�ҧ�͡


		addLog("",9,"Login �� $uname");
		if ($uname == "root" || ($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]) ){
			header("Location: login_admin.php");
		}else{
			header("Location: login_main.php");
		}
		exit;

	}

	//8=login fail, 9 = login , 10 = logout
	addLog("",8,"������ login �� $uname �������ʼ�ҹ $pwd");
	$msg = "Username ���� Password ���١��ͧ";
		
}else if($_SESSION[session_username]!=""){
	addLog("",9,"Login �� $uname");
		if (($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]) ){
			header("Location: login_admin.php");
		}else{
			header("Location: login_main.php");
		}
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
            <td align="left" class="table_head_text style1">�к��ѹ�֡�����Ţ���Ҫ��ä����кؤ�ҡ÷ҧ����֡�� �ӹѡ����֡�� ��ا෾��ҹ��</td>
          </tr>
          <tr>
            <td><img src="images/2_03.png" width="780" height="159"></td>
          </tr>
          <tr>
            <td align="center" style=" padding:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
              <tr>
                <td width="463" background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top"><form name="form1" method="post" action="login.php"> 
                  <br>
                  <table width="420" border=0 align=center>
                    <tr>
                      <td width="150" rowspan="4" align="right" style="color:#FFFFFF"><img src="images/2_07.png" width="150" height="112"></td>
                      <td width="59" align="right" style="color:#FFFFFF">&nbsp;</td>
                      <td width="1" align="left">&nbsp;</td>
                      <td width="192" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><b>Username</b></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input NAME="uname" TYPE="text" class="epm_inputbox" value="" size=20 maxlength=50></td>
                    </tr>
                    <tr>
                      <td align="right" style="color:#666666"><b>Password</b></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input NAME="pwd" TYPE="password" class="epm_inputbox" value="" size=20 maxlength=50></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><input name="submit" type=submit class="epm_button" value="   Login   "> </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="right" style="color:#FFFFFF"><span style="color:#666666"><b><a href="forget_password.php" target="_blank">���ꡡó���� Password</a></b></span></td>
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
                <td align="right" background="images/emp_main_new_20.gif" style="background-repeat:repeat-x; background-position:top"><!--<a href="http://202.129.35.104/wordpress/" target="_blank">������ webblog �����š����¹�����Դ�����Ф������</a>-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IP: <?=get_real_ip()?></td>
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
<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>
