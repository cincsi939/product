<?
/*****************************************************************************
Function		: �ͺ���¡�ä�������� �.�.7 ���Ѻ�����
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
set_time_limit(0);
include "epm.inc.php";
define('FPDF_FONTPATH','/fpdi/font/');
require_once('fpdi/fpdf.php');

include("function_assign.php");
//$type_cmss = "province"; // ��˹��ó����к��ͧ �ѧ��Ѵ
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����";

?>

<html>
<head>
<title>���ҡ���ͺ�ҹ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date.value == ""){
		alert("��س��к��ѹ���Ҵ��Ҩд��Թ�����������");
		document.form1.sent_date.focus();
		return false;
	}
}
</script>
</head>

<body bgcolor="#EFEFFF">
<form name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5" align="right" bgcolor="#EFEFFF">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="left" bgcolor="#A5B6CE"><img src="logo_sapp.jpg" width="160" height="50"></td>
          </tr>
        <tr>
          <td colspan="3" align="left"><strong>��������ҡ���ͺ���§ҹ</strong></td>
          <td width="27%" align="right">&nbsp;</td>
          <td width="29%" align="right"><label>&nbsp;          </label></td>
        </tr>
		<? 
		if($rs[recive_date] != "0000-00-00"){
			$arr_rd =explode("-",$rs[recive_date]);
			$recive_date = sw_date_intxtbox($rs[recive_date]);
		}else{
			$recive_date = date("d/m")."/".(date("Y")+543);
		}
		
		?>
        <tr>
          <td width="15%" align="left"><strong>�ѵû�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="18%" align="left"><label>
            <input name="idcard" type="text" id="idcard" value="<?=$idcard?>">
          </label></td>
          <td width="11%" align="left"><strong>���ͺؤ�ҡ�</strong></td>
          <td align="left"><input name="fullname" type="text" id="fullname" value="<?=$fullname?>"></td>
          <td align="left"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="����">
          </label></td>
        </tr>
        <tr>
          <td colspan="5" align="center"><label></label></td>
        </tr>
        <tr>
          <td colspan="5" align="center">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="left" bgcolor="#A5B6CE"><strong>�š�ä���</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#A5B6CE"><strong>�ӴѺ</strong></td>
        <td width="19%" align="center" bgcolor="#A5B6CE"><strong>���ʺѵû�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="18%" align="center" bgcolor="#A5B6CE"><strong>���� - ���ʡ�� �ؤ�ҡ� </strong></td>
        <td width="20%" align="center" bgcolor="#A5B6CE"><strong>���͹��ʡ�� Sub </strong></td>
        <td width="13%" align="center" bgcolor="#A5B6CE"><strong>���� Ticketid </strong></td>
        <td width="17%" align="center" bgcolor="#A5B6CE"><strong>�ѹ����ͺ�ҹ</strong></td>
        <td width="8%" align="center" bgcolor="#A5B6CE"><strong>ʶҹ�</strong></td>
      </tr>
	  <?
if($idcard == "" and $fullname == ""){
	$num1 = 0;
}else{
if($idcard != ""){
$con1 = " AND tbl_assign_key.idcard = '$idcard'";
}
if($fullname != ""){ 
$con1 .= " AND tbl_assign_key.fullname LIKE  '%$fullname%'";

}
	$sql = "SELECT
	tbl_assign_key.idcard,
tbl_assign_key.fullname,
tbl_assign_sub.ticketid,
tbl_assign_sub.assign_date,
tbl_assign_key.approve,
keystaff.staffname,
keystaff.staffsurname
FROM
tbl_assign_key
LEFT Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
LEFT Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE  tbl_assign_key.idcard <> '' $con1 ";
//echo $sql;
$result = mysql_db_query($db_name,$sql);
$num1 = mysql_num_rows($result);

}
	if($num1 < 1){
	echo "  <tr>
        <td colspan=\"7\" align=\"center\" bgcolor=\"#FFFFFF\"><strong> ��辺��¡�÷����� </strong></td>
        </tr>";
	}else{
	$k=0;
	while($rs = mysql_fetch_assoc($result)){
	 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>"> 
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[fullname]?></td>
        <td align="left"><? echo "$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><? echo "$rs[ticketid]";?></td>
        <td align="center"><?=thai_date($rs[assign_date]);?></td>
        <td align="center"><?
			if($rs[approve] == "1" or $rs[approve] == "0"){
				echo "�͵�Ǩ�ҹ";
			}else if($rs[approve] == "2"){
				echo "��ҹ QC ����";
			}else{
				echo "�� QC ";
			}
		?></td>
      </tr>
	<?
	}//end while(){
		}//end if($num1 < 1){
	?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
