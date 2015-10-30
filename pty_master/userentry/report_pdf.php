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







function count_data_area($secid,$type=""){
	if($type == "1"){
			$conv = " AND status_file_scan='1'";
	}else if($type == "0"){
			$conv = " AND status_file_scan='0'";
	}else{
			$conv = "";
	}
		$sql = "SELECT COUNT(idcard) AS num1 FROM tbl_check_data  WHERE secid = '$secid'  $conv  GROUP BY secid";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}



function count_in_kp7file($secid){
global $dbnamemaster,$db_name;
	$sql_file = "SELECT count($dbnamemaster.log_pdf.idcard) as num2 FROM $dbnamemaster.log_pdf INNER JOIN  ".DB_CHECKLIST.".tbl_check_data ON
	$dbnamemaster.log_pdf.idcard= ".DB_CHECKLIST.".tbl_check_data.idcard 
	   WHERE  ".DB_CHECKLIST.".tbl_check_data.secid='$secid'  and   ".DB_CHECKLIST.".tbl_check_data.status_file_scan='1' GROUP BY  ".DB_CHECKLIST.".tbl_check_data.secid";
	   $result_file = mysql_db_query($dbnamemaster,$sql_file);
	   $rs_f = mysql_fetch_assoc($result_file);
return $rs_f[num2];
}// end function id_in_kp7file($secid){


function count_in_kp7file_v1($secid){
global $dbnamemaster,$db_name;
	$sql_file = "SELECT count($dbnamemaster.log_pdf.idcard) as num2 FROM $dbnamemaster.log_pdf INNER JOIN  ".DB_CHECKLIST.".tbl_check_data ON
	$dbnamemaster.log_pdf.idcard= ".DB_CHECKLIST.".tbl_check_data.idcard 
	   WHERE  ".DB_CHECKLIST.".tbl_check_data.secid='$secid'  and   ".DB_CHECKLIST.".tbl_check_data.status_file_scan='0' GROUP BY  ".DB_CHECKLIST.".tbl_check_data.secid";
	   $result_file = mysql_db_query($dbnamemaster,$sql_file);
	   $rs_f = mysql_fetch_assoc($result_file);
return $rs_f[num2];
}// end function id_in_kp7file($secid){


$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // รหัสของครู
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center" valign="top" bgcolor="#A3B2CC"><strong>หน้ารายงานตรวจสอบการ upfile ขึ้นสู่ระบบ </strong></td>
        </tr>
    </table></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="2%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ที่</strong></td>
            <td width="18%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่การศึกษา</strong></td>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนทั้งหมด</strong></td>
            <td width="12%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>จำนวนไฟล์ที่มีในระบบ</strong></td>
            <td width="13%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>จำนวนไฟล์ที่ไม่มีในระบบ</strong></td>
            <td width="18%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>จำนวนไฟล์ที่มี(สถานะเป็น 0)</strong></td>
            <td width="14%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>สถานะเป็น 0 ที่ยัง<br>
              ไม่มีไฟล์ในระบบ </strong></td>
          </tr>
          
          <tr>
            <td width="8%" align="center" bgcolor="#A3B2CC"><strong>ส่งแสกน(1)</strong></td>
            <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ค้างส่งแสกน(0)</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
            </tr>
			<?
				$sql_area = "SELECT * FROM config_area  WHERE defult_config = '1'  ORDER BY secname ASC";
				$result_area = mysql_db_query($db_name,$sql_area);
				$j=0;
				while($rs_a = mysql_fetch_assoc($result_area)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  
				  $data_all = count_data_area($rs_a[secid],""); // จำนวนไฟล์ทั้งหมด
				  $data_sent_scan = count_data_area($rs_a[secid],1); // จำนวนไฟล์ที่ส่งแสกน
				  $data_no_scan = count_data_area($rs_a[secid],0);// จำนวนที่ยังไม่ได้ส่งแสกน
				  
				  $num_file_scan = count_in_kp7file($rs_a[secid]);// จำนวนไฟล์ที่มีอยู่ในระบบ
				  $num_file_scan_dis = $data_sent_scan-$num_file_scan;// ส่วนต่างของไฟล์ที่นำเข้า
				  
				  $num_file_scan0 = count_in_kp7file_v1($rs_a[secid]); /// ไฟล์ที่สถานะเป็น 0 จากระบบของยุ้ย
				  $num_file_scan0_dis = $data_no_scan-$num_file_scan0;

			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$j?></td>
            <td align="left"><a href="?action=view&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname])?></a></td>
            <td align="right"><? if($data_sent_scan > 0){?><a href="?action=view&type=1&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($data_sent_scan);?></a><? } else{ echo "0";}?></td>
            <td align="right"><? if($data_no_scan > 0){?><a href="?action=view&type=2&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($data_no_scan);?></a><? }else{ echo "0";}?></td>
            <td align="right"><? if($data_all > 0){?><a href="?action=view&type=3&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($data_all);?></a><? }else{ echo "0";}?></td>
            <td align="right"><? if($num_file_scan > 0){?><a href="?action=view&secid=<?=$rs_a[secid]?>&type=4&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_file_scan);?></a><? }else{ echo "0";}?></td>
            <td align="right"><? if($num_file_scan_dis > 0){?><a href="?action=view&secid=<?=$rs_a[secid]?>&type=5&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_file_scan_dis);?></a><? }else{ echo "0";} ?></td>
            <td align="right"><? if($num_file_scan0 > 0){?><a href="?action=view&secid=<?=$rs_a[secid]?>&type=ext&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_file_scan0)?></a><? }else{ echo "0";}?></td>
            <td align="right"><? if($num_file_scan0_dis > 0){?><a href="?action=view&secid=<?=$rs_a[secid]?>&type=ext1&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_file_scan0_dis)?></a><? }else{ echo "0";}?></td>
          </tr>
		  <?
				$sum_data_all += $data_all;
				$sum_data_sent_scan += $data_sent_scan;
				$sum_data_no_scan += $data_no_scan;
				$sum_num_file_scan += $num_file_scan;
				$sum_num_file_scan_dis += $num_file_scan_dis;
				$sum_num_file0 += $num_file_scan0;
				$sum_num_file0_dis += $num_file_scan0_dis;
		  	}// end while(){
		  ?>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>รวม </strong></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_data_sent_scan)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_data_no_scan)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_data_all)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_num_file_scan)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_num_file_scan_dis)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_num_file0);?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_num_file0_dis);?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
		}//end if($action == ""){
	if($action == "view"){
//	$num_file_scan0 = count_in_kp7file_v1($secid);
//	$num_file_scan = count_in_kp7file($secid);
//	$num_file_scan_all = count_data_area($secid,"1");
//	$dis_file_sanc = $num_file_scan_all-$num_file_scan;
	
	#########
				 $data_all = count_data_area($secid,""); // จำนวนไฟล์ทั้งหมด
				  $num_file_scan_all = count_data_area($secid,1); // จำนวนไฟล์ที่ส่งแสกน
				  $data_no_scan = count_data_area($secid,0);// จำนวนที่ยังไม่ได้ส่งแสกน
				  
				  $num_file_scan = count_in_kp7file($secid);// จำนวนไฟล์ที่มีอยู่ในระบบ
				  $num_file_scan_dis = $num_file_scan_all-$num_file_scan;// ส่วนต่างของไฟล์ที่นำเข้า
				  
				  $num_file_scan0 = count_in_kp7file_v1($secid); /// ไฟล์ที่สถานะเป็น 0 จากระบบของยุ้ย
				  $num_file_scan0_dis = $data_no_scan-$num_file_scan0;

	
	
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><strong><?=$secname?></strong></td>
        </tr>
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><strong>จำนวนรวมบุคลากรทั้งหมด : </strong></td>
          <td width="15%" align="right"><a href="?action=view&type=3&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรทั้งหมด">
		  <?=number_format($data_all);?></a></td>
          <td width="20%"><strong>คน</strong></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ส่งไปแสกน : </strong></td>
          <td align="right"><? if($num_file_scan_all > 0){ ?> <a href="?action=view&type=1&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่บันทึกข้อมูลเสร็จ"><?=number_format($num_file_scan_all)?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ค้างส่งแสกน : </strong></td>
          <td align="right"><? if($data_no_scan > 0){?><a href="?action=view&type=2&secid=<?=$secid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่ค้างบันทึก"><?=number_format($data_no_scan)?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนไฟล์ที่มีในระบบ : </strong> </td>
          <td align="right"><? if($num_file_scan > 0){ echo "<a href='?action=view&type=4&secid=$secid&secname=$secname&xtitle=รายชื่อบุคคลที่ไม่มี ก.พ.7 ต้นฉบับ'>".number_format($num_file_scan)."</a>";}else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนไฟล์ที่ยังไม่ได้ up ไฟล์ขึ้นระบบ : </strong></td>
          <td align="right"><? if($dis_file_sanc > 0){ echo "<a href='?action=view&type=5&secid=$secid&secname=$secname&xtitle=รายชื่อบุคคลที่ไม่มี ก.พ.7 ต้นฉบับ'>".number_format($dis_file_sanc)."</a>"; }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>ไฟล์ที่มีในระบบแต่สถานะของยุ้ยเป็น 0 : </strong></td>
          <td align="right"><? if($num_file_scan0 > 0){ echo "<a href='?action=view&type=ext&secid=$secid&secname=$secname&xtitle=รายชื่อคนที่มีไฟล์ไฟล์แต่สถานะของยุ้ยเป็น 0'>".number_format($num_file_scan0)."</a>";}else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>สถานะเป็น 0 ที่ยังไม่มีไฟล์ในระบบ : </strong></td>
          <td align="right"><? if($num_file_scan0_dis > 0){?><a href="?action=view&secid=<?=$secid?>&type=ext1&secname=<?=$secname?>&xtitle=จำนวไฟล์ที่สถานะเป็น 0 และยังไม่มีไฟล์ต้นฉบับในระบบ"><?=number_format($num_file_scan0_dis)?></a><? }else{ echo "0";}?></td>
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
                  <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="29%" align="center" bgcolor="#A3B2CC"><strong>บัตรประจำตัวประชาชน</strong></td>
                  <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="21%" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
                  </tr>
                
				<?
			if($type != ""){$type = $type;}else{ $type = "3";}
		$db_site = STR_PREFIX_DB.$secid;
			
		if($type == "3"){ // ข้อมูลของคนทั้งหมดรวมที่ส่งและไม่ส่งแสกนด้วย
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

}else if($type == "1"){
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
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan='1'";
}else if($type == "2"){
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
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan='0'";

	//echo $sql;
}else if($type == "4"){
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
Inner join  ".DB_MASTER.".log_pdf ON  ".DB_CHECKLIST.".tbl_check_data.idcard= ".DB_MASTER.".log_pdf.idcard
Inner Join $db_site.general ON  ".DB_MASTER.".log_pdf.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'  AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan='1' ";

}// end if($type_view == "discount"){
else if($type == "5"){
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Left Join  ".DB_MASTER.".log_pdf ON  ".DB_CHECKLIST.".tbl_check_data.idcard =  ".DB_MASTER.".log_pdf.idcard
where  ".DB_MASTER.".log_pdf.idcard IS NULL AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan = '1' AND  ".DB_CHECKLIST.".tbl_check_data.secid='$secid'";
}else if($type == "ext"){
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
Inner join  ".DB_MASTER.".log_pdf ON  ".DB_CHECKLIST.".tbl_check_data.idcard= ".DB_MASTER.".log_pdf.idcard
Inner Join $db_site.general ON  ".DB_MASTER.".log_pdf.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'  AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan='0' ";

}else if($type == "ext1"){
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Left Join  ".DB_MASTER.".log_pdf ON  ".DB_CHECKLIST.".tbl_check_data.idcard =  ".DB_MASTER.".log_pdf.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.status_file_scan =  '0' AND
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid' AND
 ".DB_MASTER.".log_pdf.idcard IS NULL ";
}
//echo "$sql<br>";

		$result = mysql_db_query($db_site,$sql);
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
		
			if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
			
				}else{
					$link_img = "<font color='red'>ไม่มีไฟล์ ก.พ.7 ต้นฉบับ</a>";
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
                  <td align="left"><?=$rs[idcard]?>&nbsp;&nbsp;<?=$link_img?></td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="left"><?=$rs[position_now]?></td>
                  <td align="left"><?=$xschoolname?></td>
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
 	}//end if($action == "view"){
 ?>
</BODY>
</HTML>
