<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
set_time_limit(0);
include "epm.inc.php";
define('FPDF_FONTPATH','/fpdi/font/');
require_once('fpdi/fpdf.php');

include("function_assign.php");
//$type_cmss = "province"; // กำหนดกรณีเป็นระบบของ จังหวัด
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "มอบหมายการบันทึกข้อมูล ก.พ.7 ให้กับผู้ใช้";
######  ฟังก์ชั่น หาหน่วยงาน
function search_school($siteid,$idcard){
	$db_site = STR_PREFIX_DB.$siteid;
	$sql1 = "SELECT  ".DB_MASTER.".allschool.office FROM $db_site.general INNER JOIN  ".DB_MASTER.".allschool ON $db_site.general.schoolid= ".DB_MASTER.".allschool.id WHERE $db_site.general.id='$idcard'";
	$result1 = mysql_db_query($db_site,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$sql2 = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result2 = mysql_db_query(DB_MASTER,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	$org = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs2[secname]);
	return $org."/".$rs1[office];
}// end function search_school($siteid,$idcard){
##  function นับจำนวนบุค
function count_num_key($staffid){
	$sql_key = "SELECT COUNT(idcard) AS num1 FROM monitor_keyin WHERE staffid='$staffid' GROUP BY idcard";
	$result_key = mysql_db_query(DB_USERENTRY,$sql_key);
	$numr = @mysql_num_rows($result_key);
	return $numr;
	//$rs_key = mysql_fetch_assoc($result_key);
	//return $rs_key[num1];
}

?>

<html>
<head>
<title>ค้นหาการมอบงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date.value == ""){
		alert("กรุณาระบุวันที่คาดว่าจะดำเนินการแล้วเสร็จ");
		document.form1.sent_date.focus();
		return false;
	}
}
</script></head>

<body bgcolor="#EFEFFF">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A5B6CE"><strong>รายงานจำนวนการคีย์ข้อมูลของ <?=$staffname?> จำนวนทั้งหมด <?=count_num_key($staffid);?> คน </strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A5B6CE"><strong>ลำดับ</strong></td>
        <td width="33%" align="center" bgcolor="#A5B6CE"><strong>รหัสบัตรประจำตัวประชาชน</strong></td>
        <td width="32%" align="center" bgcolor="#A5B6CE"><strong>ชื่อ - นามสกุล บุคลากร </strong></td>
        <td width="28%" align="center" bgcolor="#A5B6CE"><strong>หน่วยงานสังกัด</strong></td>
        </tr>
	  <?
	 $sql = "SELECT *  FROM monitor_keyin  WHERE staffid='$staffid'";
	 $result = mysql_db_query(DB_USERENTRY,$sql);
	while($rs = mysql_fetch_assoc($result)){
	 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 $show_num_key = count_num_key($rs[staffid]);
	  ?>
      <tr bgcolor="<?=$bg?>"> 
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[keyin_name]?></td>
        <td align="left"><?=search_school($rs[siteid],$rs[idcard]);?></td>
        </tr>
	<?
	}//end while(){

	?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
