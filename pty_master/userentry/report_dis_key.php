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
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');

function xshow_area($siteid){
	$sql_area = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result_area = mysql_db_query("edubkk_master",$sql_area);
	$rs_a = mysql_fetch_assoc($result_area);
	$xshow_area = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname]);
	return $xshow_area;
}


function show_school($schoolid){
		$sql_school = "SELECT office  FROM allschool WHERE id='$schoolid'";
		$result_school = mysql_db_query("edubkk_master",$sql_school);
		$rs_s = mysql_fetch_assoc($result_school);
		return $rs_s[office];
}

function count_salary($siteid,$idcard){
	$db_site = STR_PREFIX_DB.$siteid;
		$sql_count = "SELECT COUNT(id) AS num FROM salary WHERE id='$idcard'";
		$result_count = mysql_db_query($db_site,$sql_count);
		$rs_c = mysql_fetch_assoc($result_count);
		return $rs_c[num];
}

function last_date_salary($siteid,$idcard){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql_salary = "SELECT * FROM salary WHERE id='$idcard' AND date LIKE '2552-04%' ORDER BY date DESC LIMIT 0,1";
		$result_salary = mysql_db_query($db_site,$sql_salary);
		$rs_salary = mysql_fetch_assoc($result_salary);
		return $rs_salary[date];
}

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#A3B2CC"><strong>จำนวนคนที่ค้าง QC </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="13%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
        <td width="11%" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>จำนวนบรรทัดเงินเดือน</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>วันที่สุดท้ายเงินเดือน</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>รหัสใบงาน</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC">คนคีย์</td>
      </tr>
	  <?
	  	$sql = "SELECT * FROM tbl_assign_key WHERE  approve <> '2' order by siteid ASC";
		$result = mysql_db_query($db_name,$sql);
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
		  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  	$db_site = STR_PREFIX_DB.$rs[siteid];
			$sql_detail = "SELECT idcard, schoolid,position_now FROM $db_site.general WHERE idcard='$rs[idcard]'";
			$result_detail = mysql_db_query($db_site,$sql_detail);
			$rs1 = mysql_fetch_assoc($result_detail);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><?=$rs[fullname]?></td>
        <td align="center"><? echo $rs1[position_now];?></td>
        <td align="center"><? echo xshow_area($rs[siteid]);?></td>
        <td align="center"><? echo count_salary($rs[siteid],$rs1[idcard]);?></td>
        <td align="center"><? echo last_date_salary($rs[siteid],$rs1[idcard]);?></td>
        <td align="center"><? echo $rs[ticketid];?></td>
        <td align="center"><?
			$sql_key = "SELECT
keystaff.staffname,
keystaff.staffsurname
FROM
tbl_assign_sub
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_sub.ticketid =  '$rs[ticketid]'";
$result_key = mysql_db_query($db_name,$sql_key);
$rs_key = mysql_fetch_assoc($result_key);
echo "$rs_key[staffname] $rs_key[staffsurname]";
		?></td>
      </tr>
	  <?
	  	}//end while
	  ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
