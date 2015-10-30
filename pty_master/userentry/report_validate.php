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
	tbl_assign_key.nonactive =  '0' GROUP BY monitor_keyin.idcard";
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
//	$rs = mysql_fetch_assoc($result);
//	return $rs[num1];
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
	//$rs = mysql_fetch_assoc($result);
	//return $rs[num1];
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

	//$rs = mysql_fetch_assoc($result);
	//return $rs[num1];
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
            <td width="14%" align="right"><strong>���� : </strong></td>
            <td width="24%" align="left"><label>
              <input name="key_name" type="text" id="key_name" size="25">
            </label></td>
            <td width="11%" align="right"><strong>���ʡ�� :</strong></td>
            <td width="51%" align="left"><label>
              <input name="key_surname" type="text" id="key_surname" size="25">
            </label></td>
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
        <td colspan="9" align="left" bgcolor="#A3B2CC"><strong>������ʶԵԡ�úѹ�֡�š�õ�Ǩ�ͺ�����Ũ�ṡ�����ª��;�ѡ�ҹ</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="15%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ��</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>�ѹ������������ҹ</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ���ѹ�֡<br>
          ������(��)</strong></td>
        <td width="11%" align="center" bgcolor="#A3B2CC"><strong>����¹��úѹ�֡<br>
          �����ŵ���ѹ(�ش)</strong></td>
        <td width="13%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ��¡�÷��<br>
          ������Ǩ�ͺ(��)</strong></td>
        <td width="11%" align="center" bgcolor="#A3B2CC"><strong>������Ǩ����<br>
          ��ҹ(��)</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>������Ǩ����<br>
          ����ҹ(��)</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>������<br>
          ��õ�Ǩ�ͺ</strong></td>
      </tr>
      <?
      		$sql = "SELECT * FROM keystaff WHERE sapphireoffice='0'"; // ��ѡ�ҹ��ҧ���Ǥ�����ҹ��
			$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			$startdate = StartDateKey($rs['staffid']); // �ѹ�����鹡�ä�������Ũ�ԧ
			if($startdate != ""){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numkeydate = CountDateKey($rs[staffid],$startdate); // �Ѻ�ӹǹ�ѹ����������Ũ�ԧ
			$numkeyall = NumStaffKey($rs['staffid']); // �Ѻ�ӹǹ���������
			$numcheckall =  CountNumCheckAll($rs[staffid]);
			$numcheckfalse =  CountNumCheckFalse($rs[staffid]);
			$numchecktrue =  CountNumCheckTrue($rs[staffid]);
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><? echo DBThaiLongDate($startdate);?></td>
        <td align="center"><? echo number_format($numkeyall);?></td>
        <td align="center"><? if($numkeyall > 0){ echo number_format(($numkeyall/$numkeydate),2);}else{ echo "0";}?></td>
        <td align="center"><? echo number_format($numcheckall);?></td>
        <td align="center"><? echo number_format($numcheckfalse);?></td>
        <td align="center"><? if($numchecktrue > 0){echo "<a href='report_validate_detail.php?action=view'>".number_format($numchecktrue)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numkeyall > 0){ echo number_format(($numcheckall*100)/$numkeyall,2);}else{ echo "0";}?></td>
      </tr>
      <?
			}//end if($startdate != ""){
			}//end while(){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
