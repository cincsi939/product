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
          <td colspan="3" align="left"><strong>ฟอร์มค้นหาพนักงานคีย์ข้อมูลบุคลากร</strong></td>
          <td width="25%" align="right">&nbsp;</td>
          <td width="28%" align="right"><label>&nbsp;          </label></td>
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
          <td width="15%" align="left"><strong>บัตรประจำตัวประชาชน</strong></td>
          <td width="18%" align="left"><label>
            <input name="idcard" type="text" id="idcard" value="<?=$idcard?>">
          </label></td>
          <td width="14%" align="left"><strong>ชื่อ - นามสกุล บุคลากร</strong></td>
          <td align="left"><input name="fullname" type="text" id="fullname" value="<?=$fullname?>"></td>
          <td align="left"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="ค้นหา">
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
        <td colspan="9" align="left" bgcolor="#A5B6CE"><strong>ผลการค้นหา</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B6CE"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#A5B6CE"><strong>รหัสบัตรประจำตัวประชาชน</strong></td>
        <td width="13%" align="center" bgcolor="#A5B6CE"><strong>ชื่อ - นามสกุล บุคลากร </strong></td>
        <td width="15%" align="center" bgcolor="#A5B6CE"><strong>หน่วยงานสังกัด</strong></td>
        <td width="15%" align="center" bgcolor="#A5B6CE"><strong>ชื่อนามสกุล Sub </strong></td>
        <td width="10%" align="center" bgcolor="#A5B6CE"><strong>วันที่คีย์ข้อมูล</strong></td>
        <td width="11%" align="center" bgcolor="#A5B6CE"><strong>จำนวนที่คีย์ทั้งหมด</strong></td>
        <td width="9%" align="center" bgcolor="#A5B6CE"><strong>ประเภทบุคคล</strong></td>
        <td width="8%" align="center" bgcolor="#A5B6CE"><strong>สถานะบุคคล</strong></td>
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
tbl_assign_key.siteid,
tbl_assign_sub.assign_date,
tbl_assign_key.approve,
keystaff.staffid,
keystaff.staffname,
keystaff.staffsurname,
keystaff.status_permit,
keystaff.sapphireoffice

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
        <td colspan=\"9\" align=\"center\" bgcolor=\"#FFFFFF\"><strong> ไม่พบรายการที่ค้นหา </strong></td>
        </tr>";
	}else{
	$k=0;
	while($rs = mysql_fetch_assoc($result)){
	 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 $show_num_key = count_num_key($rs[staffid]);
	  ?>
      <tr bgcolor="<?=$bg?>"> 
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[fullname]?></td>
        <td align="left"><?=search_school($rs[siteid],$rs[idcard]);?></td>
        <td align="left"><? echo "$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><? 
		$sql_monitor = "SELECT monitor_keyin.timeupdate,monitor_keyin.timestamp_key FROM monitor_keyin WHERE staffid='$rs[staffid]' AND idcard = '$rs[idcard]' AND siteid='$rs[siteid]' ORDER BY timeupdate DESC, timestamp_key DESC  LIMIT 0,1";
		$result_monitor = mysql_db_query(DB_USERENTRY,$sql_monitor);
		$rs_m = mysql_fetch_assoc($result_monitor);
			if($rs_m[timeupdate] != ""){
					$time_key = $rs_m[timeupdate];
			}else{
					$time_key = $rs_m[timestamp_key];
			}
			$arr_t = explode(" ",$time_key);
			
			echo "".thai_date($arr_t[0])." เวลา :".$arr_t[1];
		
		?></td>
        <td align="center"><? if($show_num_key > 0){ echo "<a href='search_userkey_detail.php?staffid=$rs[staffid]&staffname=$rs[staffname] $rs[staffsurname]' target='_blank'>$show_num_key</a>";}else{ echo "0";}?></td>
        <td align="center"><?
			if($rs[sapphireoffice] == "1"){
				echo "พนักงาน sapphie";
			}else if($rs[sapphireoffice] == "0"){
				echo "ลูกจ้างชั่วคราว";
			}else{
				echo "Subcontract";
			}
		?></td>
        <td align="center"><?
			if($rs[status_premit] == "YES"){
					echo "อยู่ระหว่างการจ้าง";
			}else{
					echo "<font color='red'>เลิกจ้าง</font>";
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
