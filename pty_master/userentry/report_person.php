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
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$secid'  $conv";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}



function count_in_kp7file($secid){
global $dbnamemaster,$db_name;
	$sql_file = "SELECT count($dbnamemaster.log_pdf.idcard) as num2 FROM $dbnamemaster.log_pdf INNER JOIN  ".DB_CHECKLIST.".tbl_check_data ON
	$dbnamemaster.log_pdf.idcard= ".DB_CHECKLIST.".tbl_check_data.idcard 
	   WHERE  ".DB_CHECKLIST.".tbl_check_data.secid='$secid'  and   ".DB_CHECKLIST.".tbl_check_data.status_file_scan='1'";
	   $result_file = mysql_db_query($dbnamemaster,$sql_file);
	   $rs_f = mysql_fetch_assoc($result_file);
return $rs_f[num2];
}// end function id_in_kp7file($secid){


$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // รหัสของครู
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');



####################  function แสดงหน่วยงาน
function show_school($schoolid,$siteid){
	global $dbnamemaster;
	$sql_school = "SELECT id,office  FROM allschool  WHERE id='$schoolid'";
	$result_school = mysql_db_query($dbnamemaster,$sql_school);
	$rs_school = mysql_fetch_assoc($result_school);
		if($rs_school[id] == $siteid){
				$xschool = "$rs_school[office]";
		}else{
				$xschool = "โรงเรียน$rs_school[office]";
		}
	return $xschool;
}// end function show_school($schoolid){
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
.style6 {font-size: 16px; font-weight: bold; }
.style7 {font-size: 16px}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center" valign="top" bgcolor="#A3B2CC"><strong>หน้ารายงานจำนวนบุคลากรที่มีทั้งหมดที่มีเอกสาร</strong></td>
        </tr>
    </table></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ที่</strong></td>
            <td width="63%" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่การศึกษา</strong></td>
            <td width="31%" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากร</strong></td>
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

			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$j?></td>
            <td align="left"><a href="?action=view&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname])?></a></td>
            <td align="center"><a href="?action=view&secid=<?=$rs_a[secid]?>&type=4&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_file_scan);?></a></td>
            </tr>
		  <?
				$sum_data_all += $data_all;
				$sum_data_sent_scan += $data_sent_scan;
				$sum_data_no_scan += $data_no_scan;
				$sum_num_file_scan += $num_file_scan;
				$sum_num_file_scan_dis += $num_file_scan_dis;
		  	}// end while(){
		  ?>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>รวม </strong></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_num_file_scan)?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
		}//end if($action == ""){
	if($action == "view"){
	$num_file_scan = count_in_kp7file($secid);
	$num_file_scan_all = count_data_area($secid,"1");
	$dis_file_sanc = $num_file_scan_all-$num_file_scan;
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><span class="style1">
            <?=$secname?>
       </span></td>
        </tr>
		
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><span class="style6">จำนวนบุคลากรทั้งหมด  :  </span></td>
          <td width="15%" align="right"><span class="style7">
           <? if($num_file_scan > 0){ echo "<a href='?action=view&type=4&secid=$secid&secname=$secname&xtitle=รายชื่อบุคคลที่ไม่มี ก.พ.7 ต้นฉบับ'>".$num_file_scan."</a>";}else{ echo "0";}?>
          </span></td>
          <td width="20%"><span class="style6">คน</span></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr bgcolor="<?=$bg?>">
          <td colspan="5"><strong><?=$xtitle?></strong></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="17%" align="center" bgcolor="#A3B2CC"><strong>บัตรประจำตัวประชาชน</strong></td>
                  <td width="21%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="15%" align="center" bgcolor="#A3B2CC"><strong>วันเดือนปีเกิด</strong></td>
                  <td width="14%" align="center" bgcolor="#A3B2CC"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
                  <td width="21%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="8%" align="center" bgcolor="#A3B2CC"><strong>(ก.พ.7)</strong></td>
                  </tr>
                
				<?
	if($type != ""){$type = $type;}else{ $type = "4";}
	$db_site = STR_PREFIX_DB.$secid;
if($type == "4"){
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
$db_site.general.position_now,
CAST($db_site.general.schoolid as SIGNED) as schoolid,
$db_site.general.siteid,
$db_site.general.birthday,
$db_site.general.begindate,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner join  ".DB_MASTER.".log_pdf ON  ".DB_CHECKLIST.".tbl_check_data.idcard= ".DB_MASTER.".log_pdf.idcard
Inner Join $db_site.general ON  ".DB_MASTER.".log_pdf.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$secid'  AND  ".DB_CHECKLIST.".tbl_check_data.status_file_scan='1'  order by schoolid asc ";

}// end if($type_view == "discount"){

//echo "$sql<br>";

		$result = mysql_db_query($db_site,$sql);
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
		
			if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"16\" height=\"16\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
				}else{
					$link_img = "";
				}
				
				 $pdf		= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\">";
				 $pdf		.= "<img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";
				
			###############  แสดงโรงเรียน
			if($rs[schoolid] != $tmp_schoolid){
				echo "<tr bgcolor='#F0F0F0' height='30'><td colspan='7' align='left'><strong>".show_school($rs[schoolid],$rs[siteid])."</strong></td></tr>";
				$tmp_schoolid = $rs[schoolid];
			}
		?>

				  <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$m?></td>
                  <td align="left"><?=$rs[idcard]?></td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="center"><? echo thai_datev1($rs[birthday]);?></td>
                  <td align="center"><? echo thai_datev1($rs[begindate]);?></td>
                  <td align="left"><?=$rs[position_now]?></td>
                  <td align="center"><? echo "$link_img  $pdf";?></td>
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
