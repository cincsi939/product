<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		จัดการผู้ใช้
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM


echo "<h3 align='center'> <font color='#CC0000'>ปิดระบบลืมรหัสผ่านชั่วคราว หากมีปัญหาเรื่องการลืมรหัสผ่าน<br>โปรดติดต่อรับรหัสผ่านได้ที่โปรแกรมเมอร์หรือส่ง email มาขอที่ suwat@sapphire.co.th</font></h3>";die();

include "epm.inc.php";




$report_title = "บุคลากร";

$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

function RandomPassword($num_require=6) {
	$alphanumeric = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9);
	if($num_require > sizeof($alphanumeric)){
		//echo "Error alphanumeric_rand(\$num_require) : \$num_require must less than " . sizeof($alphanumeric) . ", $num_require given";
		return "logon";
	}else{
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
	}
}//end function RandomPassword($num_require=6) {


				function thai_date($temp){
				global $mname;
				if($temp != "0000-00-00"){
				$x = explode("-",$temp);
				$m1 = $mname[intval($x[1])];
				$y1 = intval($x[0]+543);
				$y1 = substr($y1,-2);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				}//end if($temp != "0000-00-00"){
				return $xrs;
			}




$xdisplay = "none";
############  ทำการตรวจสอบการสุ่ม password
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$sql = "SELECT * FROM keystaff WHERE username='$xusername' AND staffname='$staffname' AND staffsurname='$staffsurname' AND card_id='$card_id' ";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[username] != ""){
		$newpassword = trim(RandomPassword(6));
			$sql_password = "INSERT INTO log_change_password SET staffid='$rs[staffid]',change_date='".date("Y-m-d")."',oldpassword='$rs[password]',newpassword='$newpassword'";
			$result_pass = mysql_db_query($db_name,$sql_password);
			if($result_pass){
				$sql_up = "UPDATE keystaff SET password='$newpassword',flag_change_password='1' WHERE staffid='$rs[staffid]'";
				mysql_db_query($db_name,$sql_up);
			}
			$xdisplay = "";
	}//end if($rs[username] != ""){
		
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){


?>


<html>
<head>
<title>ยื่นขอเปลี่ยน password </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>

function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	//alert(xstatus);
	if (document.form1.xusername.value == "")  {	missinginfo1 += "\n- ช่อง username ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.card_id.value == "")  {	missinginfo1 += "\n- ช่องรหัสบัตรประชาชนไม่สามารถเป็นค่าว่าง"; }		
	
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
	
	
</script></head>

<body bgcolor="#EFEFFF">
<form name="form1" method="post" action="" onSubmit="return checkFields();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50%">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" align="center" bgcolor="#a3b2cc"><strong>กรอกข้อมูลส่วนตัวแล้วระบบจะทำการสุ่มรหัสผ่านให้</strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>username :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="xusername" type="text" id="xusername" size="25" value="<?=$xusername?>">
              </label></td>
            </tr>
            <tr>
              <td width="27%" align="right" bgcolor="#EFEFFF"><strong>ชื่อ :
                  <span class="redlink"> *</span></strong></td>
              <td width="73%" bgcolor="#EFEFFF"><label>
                <input name="staffname" type="text" id="staffname" size="25" value="<?=$staffname?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>นามสกุล :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="staffsurname" type="text" id="staffsurname" size="25" value="<?=$staffsurname?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>เลขบัตรประชาชน :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="card_id" type="text" id="card_id" size="25" value="<?=$card_id?>">
              </label></td>
            </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3" style="display:<?=$xdisplay?>">
                <tr class="redlink">
                  <td width="64%" align="center"><strong>รหัสผ่านใหม่ในการเข้าใช้งานระบบของท่านคื่อ : <?=$newpassword?></strong></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
              <td bgcolor="#EFEFFF"><label>
                <input type="submit" name="button" id="button" value="ตกลง">
                <input type="button" name="btnC" value="ปิดหน้าต่าง" onClick="window.close()">
              </label></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
