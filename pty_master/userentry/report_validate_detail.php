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
	## Modified Detail :		��§ҹ��úѹ�֡������
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
session_start();
include("../../config/conndb_nonsession.inc.php");
include("validate.inc.php");

function StartDateKey($get_staffid){
	global $db_name;	
	$sql = "SELECT
	min(date(monitor_keyin.timeupdate)) as mindate
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid =  '$get_staffid' AND
	tbl_assign_key.nonactive =  '0'
	";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[mindate];
}

###  function �Ѻ�ӹǹ��¡�÷����������
function NumStaffKey($get_staffid){
	global $db_name;
	$sql = "SELECT
	count(monitor_keyin.idcard) as num
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid =  '$get_staffid' AND
	tbl_assign_key.nonactive =  '0' group by monitor_keyin.idcard";
	$result = mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr;
	//$rs = mysql_fetch_assoc($result);
	//return $rs[num];
}

## function ��èӹǹ�ѹ���ѹ�֡�����Ũ�ԧ
function CountDateKey($get_staffid,$get_date){
	global $db_name;
	$sql = "SELECT
	count(monitor_keyin.timeupdate) as count_data
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid = '$get_staffid' AND
	tbl_assign_key.nonactive =  '0'
	and date(monitor_keyin.timeupdate) >= '$get_date'
	group by date(monitor_keyin.timeupdate)";
	$result = @mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr ;
}

### �Ѻ�ӹǹ�š�á�õ�Ǩ�ͺ������
function CountNumCheckAll($get_staffid){
	global $db_name;
	$sql = "SELECT
count(validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid' GROUP BY validate_checkdata.idcard";
	$result = mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr;
	//$rs = mysql_fetch_assoc($result);
	//return $rs[num1];
}

### �Ѻ�ӹǹ�š�á�õ�Ǩ�ͺ����ҹ
function CountNumCheckFalse($get_staffid){
	global $db_name;
	$sql = "SELECT
count(validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid' and result_check='0' GROUP BY validate_checkdata.idcard";
	$result = mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr;

//	$rs = mysql_fetch_assoc($result);
//	return $rs[num1];
}

### �Ѻ�ӹǹ�š�á�õ�Ǩ�ͺ��ҹ
function CountNumCheckTrue($get_staffid){
	global $db_name;
	$sql = "SELECT
count(validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid' and result_check='1' GROUP BY validate_checkdata.idcard";
	$result = mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr;

//	$rs = mysql_fetch_assoc($result);
//	return $rs[num1];
}

####  �ʴ����;�ѡ�ҹ
function ShowStaff($get_staffid){
global $db_name;
$sql = "SELECT * FROM keystaff WHERE staffid='$get_staffid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
	
}
?>

<html>
<head>
<title>��§ҹ�š�õ�Ǩ�ͺ��úѹ�֡������ �.�. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
  <tr>
    <td height="50" align="right" background="images/report_banner_01.gif"  style=" border-bottom:1px solid #FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="45%" style="padding-left:15px"><font style="color:#FFFFFF; font-size:16px; font-weight:bold">��§ҹʶԵԡ�úѹ�֡�š�õ�Ǩ�ͺ������</font><br>
<font style="color:#FFFFFF">&copy;  2002-2008 Sapphire Research and Development Co.,Ltd.</font></td>
        <td width="55%" style="padding-left:15px">&nbsp;</td>
      </tr>
      <tr>
        <td style="padding-left:15px">&nbsp;</td>
        <td style="padding-left:15px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="71%" align="right">&nbsp;</td>
            <td width="27%" align="right">&nbsp;</td>
            <td width="2%" align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td><form name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="4" align="left"><strong>�������˹�ҷ��ѹ�֡������</strong></td>
            </tr>
          <tr>
            <td width="14%" align="right"><strong>���� - ���ʡ��: </strong></td>
            <td width="24%" align="left"><label>
              <select name="key_staffid" id="key_staffid">
              <option value=""> - ���͡���;�ѡ�ҹ - </option>
              <?
              		$sql_staff = "SELECT * FROM keystaff WHERE sapphireoffice='0' ORDER BY staffname ASC";
					$rsult_staff = mysql_db_query($db_name,$sql_staff);
					while($rs_s = mysql_fetch_assoc($rsult_staff)){
						if($rs_s[staffid] == $key_staffid){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='' $sel>$rs_s[prename]$rs_s[staffname]  $rs[staffsurname]</option>";
					}//end while(){
			  ?>
              </select>
            </label></td>
            <td width="8%" align="right">&nbsp;</td>
            <td width="54%" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right"><strong>������ѹ��� : </strong></td>
            <td align="left"><INPUT name="startdate" onFocus="blur();" value="<?=$startdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.startdate, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
            <td align="right"><strong>�֧�ѹ��� : </strong></td>
            <td align="left"><INPUT name="enddate" onFocus="blur();" value="<?=$enddate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.enddate, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="2" align="left"><label>
              <input type="submit" name="button" id="button" value="����">
            </label></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </form></td></tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A3B2CC"><strong>�š�õ�Ǩ�ͺ�����Ţͧ : <?=ShowStaff($key_staffid);?></strong></td>
        </tr>
      <tr>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="31%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>��Ǵ / ��¡��</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ����(����µ���ѹ)</strong></td>
        </tr>
      <tr>
        <td width="11%" align="center" bgcolor="#A3B2CC"><strong>�����</strong></td>
        <td width="53%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
        </tr>
        <?
        	$sql = "SELECT * FROM validate_datagroup WHERE parent_id='0' ORDER BY checkdata_id ASC";
			$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				echo "<tr bgcolor='$bg'><td align='center'>$i</td>";
				echo "<td colspan='2' align='left'>$rs[dataname]</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
			
			$sql1 = "SELECT * FROM validate_datagroup WHERE parent_id='$rs[checkdata_id]'";	
			$result1 = mysql_db_query($sql1);
			$j=0;
			while($rs1 = mysql_fetch_assoc($result1)){
			if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rs1[dataname]?></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
        <?
			}//end while(){
		?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
