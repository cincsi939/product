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
require_once("../../config/conndb_nonsession.inc.php");
function Datediff($datefrom,$dateto){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        $differnce = $startDate - $lastDate;
        $differnce = ($differnce / (60*60*24)); //กรณืที่ต้องการให้ return ค่าเป็นวันนะครับ
        return $differnce;
      } // end function Datediff($datefrom,$dateto){

//$alert_file = 50;
$temp_d = "2009-06-01";
$temp_d1 = "2009-08-31";
$date_total = Datediff($temp_d1,$temp_d);
$temp_dc = date("Y-m-d");
$date_total_c = Datediff($temp_dc,$temp_d);


function search_ticket($idcard){
	global $db_name;
$sql = "SELECT keystaff.prename, keystaff.staffname,
keystaff.staffsurname,
tbl_assign_sub.ticketid,
tbl_assign_sub.recive_date
FROM
tbl_assign_key
Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_key.idcard =  '$idcard'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
$name = "$rs[staffname]  $rs[staffsurname]<br>$rs[ticketid] <br> วันที่ ".(thai_date($rs[recive_date]));
return $name;
}

function search_null_ticket($idcard){
	global $db_name;
$sql = "SELECT COUNT(tbl_assign_key.idcard) AS num1 FROM
tbl_assign_key
Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_key.idcard =  '$idcard'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
if($rs[num1] < 1){
	return "รอส่งออก";
}
	return "";
}


function count_all($secid){ // function คำนวณหาจำนวนทั้งหมด
global $dbnamemaster;
	$sql = "SELECT COUNT(secid) AS num FROM log_pdf_check WHERE secid='$secid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
} // end function count_all($secid){ 

function count_file_pdf($secid){ // นับจำนวนไฟล์ pdf ที่ up ขึ้นในระบบ
	global $dbnamemaster;
	$sql1 = "SELECT COUNT(secid) AS num1 FROM  log_pdf  WHERE  secid='$secid'";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[num1];
}// end function count_file_pdf($secid){ // นับจำนวนไฟล์ pdf ที่ up ขึ้นในระบบ

function count_qc_pass1($siteid,$xtype){
global $db_name;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '2' AND tbl_assign_key.siteid =  '$siteid'";
//echo $sql;
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){

function count_qc1($siteid,$xtype){
global $db_name;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '3' AND tbl_assign_key.siteid =  '$siteid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_wait1($siteid,$xtype){
global $db_name;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid  Inner Join   ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype' AND (tbl_assign_key.approve =  '0' or tbl_assign_key.approve = '1') AND tbl_assign_key.siteid =  '$siteid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_area_all($secid){
global $db_name;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$secid' ";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


function count_area_all_dis($secid){
global $db_name;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$secid' ";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


function count_key_pass($secid){
	global $db_name;
	$sql ="SELECT count(
 ".DB_CHECKLIST.".tbl_check_data.idcard) as num1
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE ".DB_USERENTRY.".tbl_assign_key.approve =  '2' AND
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard";
	$result  = mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr;
}

function id_in_kp7file($secid){
global $dbnamemaster,$db_name;
	$sql = "SELECT * FROM log_pdf  WHERE secid='$secid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($temp_id > "") $temp_id .= ","; 
			$temp_id .= "'$rs[idcard]'";
	}// end 	while($rs = mysql_fetch_assoc($result)){
 return $temp_id;
}// end function id_in_kp7file($secid){


function count_null_pdf($secid){ // ฟังก์ชั่นนันจำนวนคนที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ
	$temp_id = id_in_kp7file($secid);
	if($temp_id != ""){ $temp_id = $temp_id;}else{ $temp_id = "''";}
	$sql_count = "SELECT COUNT(idcard) AS num1  FROM tbl_check_data  WHERE secid='$secid' AND idcard  NOT IN ($temp_id)  ";
	$result_count = mysql_db_query(DB_CHECKLIST,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
		return  $rs_c[num1];
}// end function count_null_pdf($secid){ // ฟังก์ชั่นนันจำนวนคนที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ

function count_pdf_fail($secid){// นับจำนวนไฟล์เอกสารที่ไม่สมบูรณ์
	global $dbnamemaster;
	$sql = "SELECT COUNT(secid) num1 FROM log_pdf  WHERE  secid='$secid' and status_file ='0'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function count_pdf_fail(){// นับจำนวนไฟล์เอกสารที่ไม่สมบูรณ์
$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // รหัสของครู
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');

## ตรวจสอบ ไฟล์ที่ไม่สมบูรณ์
function check_file_fail($idcard,$secid){
global $dbnamemaster;
	$sql_check_file = "SELECT COUNT(idcard) AS num1 FROM log_pdf   WHERE idcard='$idcard' AND status_file='0' AND secid='$secid'";
	//echo $sql_check_file."<br>$dbnamemaster";
	$result_check_file = mysql_db_query($dbnamemaster,$sql_check_file);
	$rs_c = mysql_fetch_assoc($result_check_file);
	return $rs_c[num1];
}// end function check_file_fail(){

#######  นับจำนวนรายการที่รับรองข้อมูลแล้วโดยบุคลากรในเขตหรือเจ้าตัว
function count_person_approve($siteid){
$dbsite = STR_PREFIX_DB.$siteid;
	$sql_app = "SELECT count($dbsite.general.idcard) as num FROM  ".DB_CHECKLIST.".tbl_check_data Inner Join $dbsite.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $dbsite.general.idcard
WHERE
$dbsite.general.approve_status =  'approve' AND
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$siteid'";
//echo $sql_app." ::  ".$dbsite;
$result_app = @mysql_db_query($dbsite,$sql_app);
$rs_app = @mysql_fetch_assoc($result_app);
return $rs_app[num];
}// end function count_person_approve(){
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="70%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td colspan="5" bgcolor="#A3B2CC"><span class="style1">รายงานสรุปการบันทึกข้อมูล </span></td>
              </tr>
              <tr>
                <td width="23%" align="center" bgcolor="#A3B2CC">วันเริ่มดำเนินงาน</td>
                <td width="26%" align="center" bgcolor="#A3B2CC">วันสิ้นสุดดำเนินงาน</td>
                <td width="23%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td width="23%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td width="28%" align="center" bgcolor="#A3B2CC">จำนวนวันดำเนินการ(วัน)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d1);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">วันเริ่มดำเนินงาน</td>
                <td align="center" bgcolor="#A3B2CC">ปัจจุบัน</td>
                <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td align="center" bgcolor="#A3B2CC">จำนวนวันดำเนินการ(วัน)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_dc);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total_c?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">จำนวนเป้าหมายการบันทึก(คน)</td>
                <td align="center" bgcolor="#A3B2CC">จำนวนการบันทึกจริง(คน)</td>
                <td align="center" bgcolor="#A3B2CC">คงเหลือ(คน)</td>
                <td align="center" bgcolor="#A3B2CC">เปอร์เซ็นบันทึก</td>
                <td align="center" bgcolor="#A3B2CC">เปอร์เซ็นต์เป้าหมายการบันทึก</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_all"><?=$txt_sum_all;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_key"><?=$txt_sum_key;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><a href="report_non_key.php"><div id="dis_key"></div></a></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="persen_k1"></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="persent_key"><?=$txt_persent_key?></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="22%">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><strong class="headerTB">เปอร์เซนต์การบันทึกข้อมูล ณ ปัจจุบัน</strong></td>
            </tr>
            <tr>
              <td>	<div id="cockpit_area">
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="310" height="161" align="middle">
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="movie" value="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#ffffff" />
    <embed src="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" quality="high" bgcolor="#ffffff" width="310" height="161" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />  
</object>
</div>	</td>
            </tr>
          </table>		</td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="top"><font color="#FF0000">(หมายเหตุ : จำนวนเป้าหมายการบันทึกจะกำหนดค่าไว้ก่อน)</font>&nbsp;&nbsp;ข้อมูล ณ วันที่ <?=thai_date($temp_dc);?></td>
        </tr>
    </table></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="2%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>ที่</strong></td>
            <td width="14%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่การศึกษา</strong></td>
            <td colspan="3" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>PDF<a href="report_pdf.php" target="_blank"><img src="images/yast_www.png" alt="คลิ๊กเพื่อดูหน้ารายงานตรวจสอบไฟล์ pdf" width="22" height="22" border="0"></a></strong></td>
            <td width="5%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนรับรองข้อมูลโดยเขต</strong></td>
            <td colspan="9" align="center" bgcolor="#A3B2CC"><strong>รายงานการกรอกข้อมูล</strong></td>
            <td width="4%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>รอส่ง<br>
              ออก</strong></td>
            <td width="5%" rowspan="3" align="center" bgcolor="#A3B2CC">เ<strong>อกสาร<br>
              ไม่ชัด</strong></td>
            <td width="4%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
          </tr>
          <tr>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>พนักงานจ้าง</strong></td>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>Outsource</strong></td>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>พนักงาน sapphire </strong></td>
            </tr>
          <tr>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>ยอดรวม<br>
              (คน/แผ่น)</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>Up File</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คงเหลือ</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>รอ QC</strong></td>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>กำลัง<br>
              ดำเนินการ</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>รอ QC</strong></td>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>กำลัง<br>
              ดำเนินการ</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC<br>
              PASS</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>รอ QC </strong></td>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>กำลัง<br>
              ดำเนินการ</strong></td>
          </tr>
			<?
				$sql_area = "SELECT * FROM config_area  WHERE defult_config = '1'  ORDER BY secname ASC";
				$result_area = mysql_db_query($db_name,$sql_area);
				$j=0;
				while($rs_a = mysql_fetch_assoc($result_area)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  	$sql_count = "SELECT COUNT(secid) AS  num1 FROM tbl_check_data WHERE secid='$rs_a[secid]'";
					//echo $sql_count."<br>";
					$result_count = mysql_db_query(DB_CHECKLIST,$sql_count);
					$rs_c =mysql_fetch_assoc($result_count);
						$num_all = $rs_c[num1];
						$temp_all = $rs_c[num1];
				//  ####################
//				  if($rs_a[status_com] == 1){
//				  	$num_all = number_format($rs_a[est_num]);
//					$temp_all = $rs_a[est_num];
//				  }else{
//				  	$num_all = "<font color='red'> ~ </font>".(number_format($rs_a[est_num]));
//					$temp_all = $rs_a[est_num];
//				  }// end   if(count_all($rs_a[secid]) > 0){
				  ###################
				  $num_approve = count_person_approve($rs_a[secid]);
				  	if($num_approve > 0){
						$link_approve = "<a href='report_person_approve.php?xsecid=$rs_a[secid]&secname=$rs_a[secname]' target='_blank'>".number_format($num_approve)."</a>";
					}else{
						$link_approve = "0";
					}
					$sum_num_approve += $num_approve;
			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$j?></td>
            <td align="left"><a href="report.php?action=view&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname])?></a></td>
            <td align="right"><?=number_format($num_all)?></td>
            <td align="right"><?=number_format(count_file_pdf($rs_a[secid]));?></td>
            <td align="right"><?=number_format($temp_all-count_file_pdf($rs_a[secid]));?></td>
            <td align="right"><?=$link_approve?></td>
            <td align="right"><?  if(count_qc_pass1($rs_a[secid],"0") > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่ผ่านการตรวจสอบแล้ว[พนักงานจ้าง]' target='_blank'>".number_format(count_qc_pass1($rs_a[secid],"0"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if(count_qc1($rs_a[secid],"0") > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่รอการตรวจสอบแล้ว[พนักงานจ้าง]' target='_blank'>".number_format(count_qc1($rs_a[secid],"0"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if(count_wait1($rs_a[secid],"0") > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่ค้างดำเนินการ[พนักงานจ้าง]' target='_blank'>".number_format(count_wait1($rs_a[secid],"0"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if(count_qc_pass1($rs_a[secid],"2") > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่ผ่านการตรวจสอบแล้ว[Outsource]' target='_blank'>".number_format(count_qc_pass1($rs_a[secid],"2"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if(count_qc1($rs_a[secid],"2") > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่รอการตรวจสอบข้อมูล[Outsource]' target='_blank'>".number_format(count_qc1($rs_a[secid],"2"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if(count_wait1($rs_a[secid],"2") > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&siteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่ค้างดำเนินการ[Outsource]' target='_blank'>".number_format(count_wait1($rs_a[secid],"2"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if(count_qc_pass1($rs_a[secid],"1") > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&siteid=$rs_a[sedid]&xtype=1&xtitle=รายงานข้อมูลที่ผ่านการตรวจสอบแล้ว[พนักงาน sapphire]' target='_blank'>".number_format(count_qc_pass1($rs_a[secid],"1"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if(count_qc1($rs_a[secid],"1") > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&siteid=$rs_a[sedid]&xtype=1&xtitle=รายงานข้อมูลที่รอการตรวจสอบข้อมูล[พนักงาน sapphire]' target='_blank'>".number_format(count_qc1($rs_a[secid],"1"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if(count_wait1($rs_a[secid],"1") > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&siteid=$rs_a[sedid]&xtype=1&xtitle=รายงานข้อมูลที่ค้างดำเนินการ[พนักงาน sapphire]' target='_blank'>".number_format(count_wait1($rs_a[secid],"1"))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? 
				$temp_n = $temp_all-(count_qc_pass1($rs_a[secid],"0")+count_qc_pass1($rs_a[secid],"2")+count_qc1($rs_a[secid],"0")+count_qc1($rs_a[secid],"2")+count_wait1($rs_a[secid],"0")+count_wait1($rs_a[secid],"2")+count_qc_pass1($rs_a[secid],"1")+count_qc1($rs_a[secid],"1")+count_wait1($rs_a[secid],"1"));
				if($temp_n > 0){
					echo "<a href='report.php?action=view&secid=$rs_a[secid]&secname=$rs_a[secname]&type_view=discount&xtitle=รายชื่อที่รอส่งออก' target='_blank'>".number_format($temp_n)."</a>";
				}else{
					 echo number_format($temp_n);
				}
				
			?></td>
            <td align="right"><? if(count_pdf_fail($rs_a[secid]) >0){  echo "<a href='report_pdf_fail.php?secid=$rs_a[secid]&secname=$rs_a[secname]'>".number_format(count_pdf_fail($rs_a[secid]))."</a>";}else{ echo "0";}?></td>
            <td align="right"><? 
				$total1  = $temp_all;
				echo number_format($total1);
			?></td>
          </tr>
		  <?
		  $temp_dis = $temp_all-count_file_pdf($rs_a[secid]);
		  	$sumall1 += $temp_all;
			$sumall2 += count_file_pdf($rs_a[secid]);
			$sumall3 += $temp_dis;
			$sumall4 += count_qc_pass1($rs_a[secid],"0");
			$sumall5 += count_qc1($rs_a[secid],"0");
			$sumall6 += count_wait1($rs_a[secid],"0");
			$sumall7 += count_qc_pass1($rs_a[secid],"2");
			$sumall8 += count_qc1($rs_a[secid],"2");
			$sumall9 += count_wait1($rs_a[secid],"2");
			$sumall10 += count_qc_pass1($rs_a[secid],"1");
			$sumall11 += count_qc1($rs_a[secid],"1");
			$sumall12 += count_wait1($rs_a[secid],"1");
			$sumall13 += count_pdf_fail($rs_a[secid]);

		  
		  	}// end while(){
		  ?>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>รวม </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall2);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall3);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sum_num_approve);?>
             </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall4);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall5);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall6);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall7);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall8);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall9);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall10);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall11);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall12);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?
				$temp_sumall = $sumall1-($sumall4+$sumall5+$sumall6+$sumall7+$sumall8+$sumall9+$sumall10+$sumall11+$sumall12);
			//	echo " $sumall1       ($sumall4       $sumall5         $sumall6    $sumall7   $sumall8   $sumall9)";
				echo number_format($temp_sumall);
			?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong><?=number_format($sumall13);?></strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
	$temp_key = ($sumall4+$sumall7+$sumall10);
	$total_ratio = number_format((($temp_key*100)/$sumall1),2);
	
	$temp_total1 = $sumall1/$date_total;
	//$temp_total2 = $temp_total1*$date_total_c;
	$temp_total2 = $sumall1 ;
	$alert_file = number_format(($temp_total2*100)/$sumall1,2);
	
	$dis_key = $sumall1-$temp_key;
	$persen_k1 = ($temp_key*100)/$sumall1; // เปอร์เซ็นการบันทึก
	
//	echo " วันทั้งหมด==  ".$date_total."   วันปัจจุบัน ==  ".$date_total_c."  จำนวนชุดต่อวัน  $temp_total1 ==  ".$temp_total2." == ".$alert_file;
	//echo $total_ratio;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
document.getElementById("cockpit_area").innerHTML="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"310\" height=\"161\" align=\"middle\">       <param name=\"allowScriptAccess\" value=\"sameDomain\" />        <param name=\"movie\" value=\"../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self\" />        <param name=\"quality\" value=\"high\" />        <param name=\"bgcolor\" value=\"#ffffff\" />        <embed src=\"../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self\" quality=\"high\" bgcolor=\"#ffffff\" width=\"310\" height=\"161\" align=\"middle\" allowscriptaccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />      </object>	";
document.getElementById("sum_all").innerHTML="<?=number_format($temp_total2)?>";
document.getElementById("sum_key").innerHTML="<?=number_format($temp_key)?>";
document.getElementById("persent_key").innerHTML="<?=$alert_file?>";
document.getElementById("dis_key").innerHTML="<?=$dis_key?>";
document.getElementById("persen_k1").innerHTML="<?=$persen_k1?>";
//-->
</SCRIPT>


<?
	}//end if($action == ""){
	if($action == "view"){
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><strong><?=$secname?></strong></td>
        </tr>
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
          <td width="15%" align="right"><a href="report.php?action=view&type_view=all&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรทั้งหมด"><?=count_area_all($secid);?></a></td>
          <td width="20%"><strong>คน</strong></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่บันทึกข้อมูลเสร็จ</strong></td>
          <td align="right"><? if(count_key_pass($secid) > 0){ ?> <a href="report.php?action=view&type_view=key_pass&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่บันทึกข้อมูลเสร็จ"><?=count_key_pass($secid);?></a><? }else{ echo count_key_pass($secid);}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนที่ค้างบันทึก</strong></td>
          <td align="right"><? if(count_area_all($secid) > 0){ $disc = count_area_all($secid)-count_key_pass($secid); }else{ 
		  $disc = "<font color='red'>".(count_area_all_dis($secid)-count_key_pass($secid))." </font>"; }?><a href="report.php?action=view&type_view=key_dis&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่ค้างบันทึก"><?=$disc?></a></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ</strong> </td>
          <td align="right"><? if(count_null_pdf($secid) > 0){ echo "<a href='report.php?action=view&type_view=null_kp7&secid=$secid&secname=$secname&xtitle=รายชื่อบุคคลที่ไม่มี ก.พ.7 ต้นฉบับ'>".count_null_pdf($secid)."</a>";}else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="<?=$bg?>">
          <td colspan="5"><strong><?=$xtitle?></strong></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="16%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>บัตรประจำตัวประชาชน</strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="14%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
                  <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>สถานะการบันทึกข้อมูล</strong></td>
                  </tr>
                <tr>
                  <td width="11%" align="center" bgcolor="#A3B2CC"><strong>บันทึกข้อมูลเสร็จ</strong></td>
                  <td width="12%" align="center" bgcolor="#A3B2CC"><strong>อยู่ระหว่างดำเนินการ</strong></td>
                  <td width="13%" align="center" bgcolor="#A3B2CC"><strong>กำลังดำเนินการโดย</strong></td>
                </tr>
				<?
			if($type_view != ""){$type_view = $type_view;}else{ $type_view = "all";}
		$db_site = STR_PREFIX_DB.$secid;
			
		if($type_view == "all"){
$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
$db_site.general.position_now,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'
";
	
	
}else if($type_view == "key_pass"){
		$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
$db_site.general.prename_th,
$db_site.general.name_th,
$db_site.general.surname_th,
$db_site.general.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
Inner Join ".DB_USERENTRY.".tbl_assign_key ON $db_site.general.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2'";
		}else if($type_view == "key_dis"){
$sql_temp = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
Inner Join ".DB_USERENTRY.".tbl_assign_key ON $db_site.general.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2'";
//echo $sql_temp;
$result_temp = mysql_db_query($db_site,$sql_temp);
while($rs_t = mysql_fetch_assoc($result_temp)){
	if($xidcard > "") $xidcard .= ",";
	$xidcard .= "'$rs_t[idcard]'";
}

if($xidcard != ""){ $xidcard = $xidcard;}else{ $xidcard = "''";}
	$sql = "SELECT
	 ".DB_CHECKLIST.".tbl_check_data.idcard,
	$db_site.general.prename_th,
	$db_site.general.name_th,
	$db_site.general.surname_th,
	 ".DB_CHECKLIST.".tbl_check_data.schoolname,
	 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
	$db_site.general.position_now,
	 ".DB_CHECKLIST.".tbl_check_data.secid
	FROM
	 ".DB_CHECKLIST.".tbl_check_data
	Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
	WHERE
	 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND  ".DB_CHECKLIST.".tbl_check_data.idcard NOT IN($xidcard)";

	//echo $sql;
}else if($type_view == "discount"){
//	$sql_temp1 = "SELECT
// ".DB_CHECKLIST.".tbl_check_data.idcard
//FROM
// ".DB_CHECKLIST.".tbl_check_data
//Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
//WHERE
// ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'";
	$sql_temp1 = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard, ".DB_USERENTRY.".tbl_assign_key.idcard as id
FROM
 ".DB_CHECKLIST.".tbl_check_data
Left Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' order by id ASC";

$result_temp1 = mysql_db_query($db_name,$sql_temp1);
while($rs1 = mysql_fetch_assoc($result_temp1)){
	//echo $rs1[idcard]."<br>";
if($rs1[id] == "" or $rs1[id] == NULL){
		if($xidcard_d > "") $xidcard_d .= ",";
		$xidcard_d .= "'$rs1[idcard]'";
}
}// end while($rs1 = mysql_fetch_assoc($result_temp1)){
	if($xidcard_d != ""){ $xidcard_d = $xidcard_d;}else{ $xidcard_d = "''";}	
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
$db_site.general.position_now,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'  AND  ".DB_CHECKLIST.".tbl_check_data.idcard  IN($xidcard_d) ";
//echo $sql."<br>";
}// end if($type_view == "discount"){
else if($type_view == "null_kp7"){

if(id_in_kp7file($secid) != ""){ $xidcard = id_in_kp7file($secid);}else{ $xidcard = "''";}
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
$db_site.general.position_now,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'  AND  ".DB_CHECKLIST.".tbl_check_data.idcard NOT IN($xidcard) ";
}
//echo "$sql<br>";

		$result = mysql_db_query($db_site,$sql);
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
		
		$sql_check_approve = "SELECT approve FROM tbl_assign_key WHERE idcard='$rs[idcard]'";
		$result_check_approve = mysql_db_query(DB_USERENTRY,$sql_check_approve);
		$rs_appv = mysql_fetch_assoc($result_check_approve);
		
			if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
					if($rs_appv[approve] != "2"){
					$link_del = "  <img src=\"images/Cancel-2-32x32.png\" alt=\"คลิ๊กเพื่อกำหนดสถานะเอกสารไม่สมบูรณ์\" width=\"18\" height=\"18\" border=\"0\" onClick=\"return confirmDelete('pupup_kp7_fail.php?idcard=$rs[idcard]')\" style=\"cursor:hand\">";
					}else{
					$link_del = "";
					}
				}else{
					$link_del = "";
					$link_img = "<font color='red'>ไม่มีไฟล์ ก.พ.7 ต้นฉบับ</a>";
				}
		
		#####################  กรณี หน้ารายงานของคนที่รอส่งออก ###################
		if(check_file_fail($rs[idcard],$secid) == 1){
				$f_color1 = "<font color='red'>";
				$f_color2 = "</font>";
		}else{
				$f_color1 = "";
				$f_color2 = "";
		}
		
		#############  กรณีหน่วยงานสักกัดเป็น ตัวเลเนื่องจากการนำเข้าผิด
		if($rs[schoolname] > 0 or $rs[schoolname] == ""){
			$xschoolname = $rs[pos_now];
		}else{
			$xschoolname = $rs[schoolname];
		}
		#############  กรณีหน่วยงานสักกัดเป็น ตัวเลเนื่องจากการนำเข้าผิด
		?>

				     <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$m?></td>
                  <td align="left"><?=$f_color1?><?=$rs[idcard]?><?=$f_color2?>&nbsp;&nbsp;<?=$link_img?>&nbsp;<?=$link_del?> </td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="left"><?=$rs[position_now]?></td>
                  <td align="left"><?=$xschoolname?></td>
                  <td align="center">
				  <?
				  	$sql_c= "SELECT COUNT(idcard) AS num FROM tbl_assign_key WHERE  idcard='$rs[idcard]' and  approve = '2'";
					$result_c = mysql_db_query($db_name,$sql_c);
					$rs_c = mysql_fetch_assoc($result_c);
					if($rs_c[num] > 0){
						echo "ผ่าน";
					}
				  ?>				  </td>
                  <td align="center">				  <?
				  	$sql_c1= "SELECT COUNT(idcard) AS num FROM tbl_assign_key WHERE   idcard='$rs[idcard]' and approve <> '2'";
					$result_c1 = mysql_db_query($db_name,$sql_c1);
					$rs_c1 = mysql_fetch_assoc($result_c1);
					if($rs_c1[num] > 0){
						echo "อยู่ระหว่างดำเนินการ";
					}
				  ?></td>
                  <td align="LEFT">
				  	<? if($rs_c1[num] > 0){ echo search_ticket($rs[idcard]);}else{ echo search_null_ticket($rs[idcard]);}?>
				  </td>
                </tr>

				<?

				}//end 		while($rs = mysql_fetch_assoc($result)){
				?>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
 <?
 		echo "<br><center><font color='red'>หมายเหตุ: รหัสบัตรที่เป็นตัวหนังสือสีแดงคือรายการที่มีไฟล์ pdf แล้วแต่สถานไฟล์ต้นฉบับไม่สมบูรณ์</font></center>";
 	}//end if($action == "view"){
 ?>
</BODY>
</HTML>
