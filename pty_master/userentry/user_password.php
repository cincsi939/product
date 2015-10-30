<?
/*****************************************************************************
Function		: แก้ไขข้อมูลของ epm_staff
Version			: 1.0
Last Modified	: 16/8/2548
Changes		:

*****************************************************************************/
include "epm.inc.php";
$report_title = "รหัสผ่าน";

$org_id = intval($_SESSION[session_dev_id]);
$id = $_SESSION[session_staffid];
$_GET[action] = $action = "edit";

$msg = "";
if ($_SERVER[REQUEST_METHOD] == "POST"){ 
/*
	// remove slashes from variable
	foreach ($_POST as $key => $value){
		if (!is_array($value) && !is_numeric($value)){
			$_POST[$key] = stripslashes($value);
		}
	}
*/


	if ($id == ""){
		$msg = "กรุณาระบุ id ของผู้ที่จะแก้ไขรหัสผ่าน";
	}else{
		$result = mysql_query("select * from epm_staff where staffid='$id';");
		$rs = mysql_fetch_assoc($result);

		if ($oldpassword != $rs[password]){
			$msg = "รหัสผ่านเดิมไม่ถูกต้อง";
		}else if ($newpassword == $xpassword){
			$sql = " update epm_staff set password='$xpassword',flag_change_password='0' where staffid = '$id'; ";
			echo $sql;
			$msg = "";
		}else{
			$msg = "รหัสผ่านใหม่ ไม่ตรงกัน ในการยืนยัน ไม่สามารถเปลี่ยนรหัสได้";
		}

		if ($msg == ""){
			@mysql_query($sql);
			if (mysql_errno() != 0){
				$msg = "ไม่สามารถบันทึกลงฐานข้อมูลได้<BR>$sql<BR><BR>" . mysql_error() ;
			}else{
				// SUCCESS
				echo "<script>alert('เปลี่ยนแปลงรหัสผ่านเรียบร้อยแล้ว\\nรหัสผ่านใหม่จะมีผลในการเข้าสู่ระบบครั้งต่อไป'); location.href='?';</script>";
				//header("Location: ?org_id=$org_id");
				exit;
			}
		}

		echo "<script>alert('$msg'); location.href='?';</script>";
		exit;		

	}
	$action = "";
}
//include("index_top.php");
?>


<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.newpassword.value == "")  {	missinginfo1 += "\n- ช่องรหัสผ่านใหม่ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.xpassword.value == "")  {	missinginfo1 += "\n- ช่องยืนยันรหัสผ่านใหม่ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.xpassword.value != document.form1.newpassword.value)  {	missinginfo1 += "\n- ช่องรหัสผ่านใหม่ และ ช่องยืนยันรหัสผ่านใหม่ ต้องตรงกัน"; }		

	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
</script>

</head>

<body bgcolor="#A3B2CC">
<BR>
<form action="?" method="POST" NAME="form1" ONSUBMIT="Javascript:return (checkFields());">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>" >
<INPUT TYPE="hidden" NAME="org_id" VALUE="<?=$org_id?>" >
<INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>"  >
<table border=0 align=center cellspacing=1 cellpadding=3 bgcolor="#808080" width="98%">
    <tr bgcolor="#A3B2CC"> 
      <td colspan=2>  <img src="images/info2.gif" align=middle> 
	  <FONT COLOR="WHITE" style="font-size:14pt;"><B><?=$title?>ข้อมูล<?=$report_title?></B></font></td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">รหัสผ่านเดิม </td>
      <td> 
        <INPUT TYPE="password" NAME="oldpassword" VALUE="" size="30" maxlength=50 class=inputbox>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">รหัสผ่านใหม่ </td>
      <td> 
        <INPUT TYPE="password" NAME="newpassword" VALUE="" size="30" maxlength=50 class=inputbox>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">ยืนยันรหัสผ่านใหม่ </td>
      <td> 
        <INPUT TYPE="password" NAME="xpassword" VALUE="" size="30" maxlength=50 class=inputbox>      </td>
    </tr>

    <tr bgcolor="#888899" valign=top> 
      <td colspan=2 align=right> 
        <INPUT TYPE="submit" VALUE="    บันทึก    " CLASS=xbutton>
        <INPUT TYPE="reset" VALUE=" ยกเลิก " class=xbutton>      
	  </td>
    </tr>

  </table>
</form>


<BR><BR>
</BODY>
</HTML>
