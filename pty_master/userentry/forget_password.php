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
	## Modified Detail :		�Ѵ��ü����
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM


echo "<h3 align='center'> <font color='#CC0000'>�Դ�к�������ʼ�ҹ���Ǥ��� �ҡ�ջѭ������ͧ���������ʼ�ҹ<br>�ô�Դ����Ѻ���ʼ�ҹ�������������������� email �Ңͷ�� suwat@sapphire.co.th</font></h3>";die();

include "epm.inc.php";




$report_title = "�ؤ�ҡ�";

$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");

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
############  �ӡ�õ�Ǩ�ͺ������� password
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
<title>��蹢�����¹ password </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>

function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	//alert(xstatus);
	if (document.form1.xusername.value == "")  {	missinginfo1 += "\n- ��ͧ username �������ö�繤����ҧ"; }		
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ��ͧ���� �������ö�繤����ҧ"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ��ͧ���ʡ�� �������ö�繤����ҧ"; }		
	if (document.form1.card_id.value == "")  {	missinginfo1 += "\n- ��ͧ���ʺѵû�ЪҪ��������ö�繤����ҧ"; }		
	
	if (missinginfo1 != "") { 
		missinginfo += "�������ö������������  ���ͧ�ҡ \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\n��سҵ�Ǩ�ͺ �ա����";
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
              <td colspan="2" align="center" bgcolor="#a3b2cc"><strong>��͡��������ǹ��������к��зӡ���������ʼ�ҹ���</strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>username :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="xusername" type="text" id="xusername" size="25" value="<?=$xusername?>">
              </label></td>
            </tr>
            <tr>
              <td width="27%" align="right" bgcolor="#EFEFFF"><strong>���� :
                  <span class="redlink"> *</span></strong></td>
              <td width="73%" bgcolor="#EFEFFF"><label>
                <input name="staffname" type="text" id="staffname" size="25" value="<?=$staffname?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>���ʡ�� :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="staffsurname" type="text" id="staffsurname" size="25" value="<?=$staffsurname?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>�Ţ�ѵû�ЪҪ� :
                  <span class="redlink"> *</span></strong></td>
              <td bgcolor="#EFEFFF"><label>
                <input name="card_id" type="text" id="card_id" size="25" value="<?=$card_id?>">
              </label></td>
            </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3" style="display:<?=$xdisplay?>">
                <tr class="redlink">
                  <td width="64%" align="center"><strong>���ʼ�ҹ����㹡�������ҹ�к��ͧ��ҹ���� : <?=$newpassword?></strong></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
              <td bgcolor="#EFEFFF"><label>
                <input type="submit" name="button" id="button" value="��ŧ">
                <input type="button" name="btnC" value="�Դ˹�ҵ�ҧ" onClick="window.close()">
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
