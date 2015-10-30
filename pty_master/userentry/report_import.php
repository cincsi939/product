<?
set_time_limit(0);
//include("../../../../config/conndb_nonsession.inc.php");
//include ("../../../../common/common_competency.inc.php")  ;	
include("../../config/conndb_nonsession.inc.php");
include "epm.inc.php";
$number_all = "25561";
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

function cal_num_key($date_c){
global $dbnamemaster;
	$sql_count = "SELECT COUNT(".DB_USERENTRY.".tbl_assign_key.approve) AS numc FROM  ".DB_MASTER.".log_pdf  Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_MASTER.".log_pdf.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard WHERE  ".DB_MASTER.".log_pdf.date_c =  '$date_c' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2' group by  ".DB_MASTER.".log_pdf.date_c";
//echo 	$sql_count;
	$result = mysql_db_query($dbnamemaster,$sql_count);
	$rs = mysql_fetch_assoc($result);
	return $rs[numc];
}// end function cal_num_key($date_c){


function Datediff($datefrom,$dateto){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        $differnce = $startDate - $lastDate;
        $differnce = ($differnce / (60*60*24)); //กรณืที่ต้องการให้ return ค่าเป็นวันนะครับ
        return $differnce;
      } // end function Datediff($datefrom,$dateto){
$temp_d = date("Y-m-d");
$temp_d1 = "2009-09-15";
$date_remain = Datediff($temp_d1,$temp_d);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>รายงานการนำเข้าข้อมูล</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="7%"><img src="../../images_sys/secu.png" width="64" height="64" /></td>
        <td width="93%"><span class="style2">รายงานสรุปการอับโหลดไฟล์ ก.พ. 7 </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#A5B2CE"><strong>รายงานการนำเข้าข้อมูล &nbsp;&nbsp;&nbsp;&nbsp;ระบบกำหนดวันสิ้นสุดงานวันที่ 15 กันยายน 2552 </strong></td>
  </tr>
  <tr>
    <td bgcolor="#A5B2CE">&nbsp;</td>
  </tr>
  <? if($action == ""){
  		if($xtype == ""){ $temp_sort = "desc";  $simg = "<img src=\"../../../../images_sys/asc_order.gif\" width=\"7\" height=\"6\" border=\"0\" alt=\"เรียงลำดับจากน้อยไปหามาก\">";}
  		if($xtype == "asc"){ $temp_sort = "desc"; $simg = "<img src=\"../../../../images_sys/asc_order.gif\" width=\"7\" height=\"6\" border=\"0\" alt=\"เรียงลำดับจากน้อยไปหามาก\">";}
		if($xtype == "desc"){ $temp_sort = "asc"; $simg = "<img src=\"../../../../images_sys/desc_order.gif\" width=\"7\" height=\"6\" border=\"0\" alt=\"เรียงลำดับจากมากไปหาน้อย\">";}
  
  ?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong><a href="report_import.php?action=&xtype=<?=$temp_sort?>">วันที่ <?=$simg?></a></strong></td>
        <td width="33%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่นำเข้า</strong></td>
        <td width="31%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่คีย์เสร็จ</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>ค้าง</strong></td>
      </tr>
	<? 
		if($xtype == "asc"){ $orderby = " ORDER BY date_c ASC";}
		if($xtype == "desc"){ $orderby = " ORDER BY date_c DESC";}
		$sql_date = "SELECT COUNT(date_c) as num1, date_c  FROM log_pdf GROUP BY date_c  $orderby";
		$result_date = mysql_db_query($dbnamemaster,$sql_date);
		$n=0;
		while($rs = mysql_fetch_assoc($result_date)){
		if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $n++;
	?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$n?></td>
        <td align="center"><? $arr_d = explode("-",$rs[date_c]);  echo intval($arr_d[2])." ".$mname[intval($arr_d[1])]." ".($arr_d[0]+543) ;?></td>
        <td align="center"><? if($rs[num1] > 0){ echo "<a href='report_import.php?action=view_detail&type=1&date_c=$rs[date_c]'>".number_format($rs[num1])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if(cal_num_key($rs[date_c]) > 0){ echo "<a href='report_import.php?action=view_detail&type=2&date_c=$rs[date_c]'>".number_format(cal_num_key($rs[date_c]))."</a>";}else{ echo "0";}?></td>
        <td align="center"><? 
		$temp_des = $rs[num1]-cal_num_key($rs[date_c]);
		if($temp_des > 0){
		//echo "<a href='report_import.php?action=view_detail&type=3&date_c=$rs[date_c]'>".number_format($rs[num1]-cal_num_key($rs[date_c]))."</a>";
		echo number_format($temp_des);
		}else{ 
		echo "0";
		}
		?></td>
      </tr>
	 <?
	 		$total_pdf  += $rs[num1]; // จำนวนรวมนำเข้า pdf ทั้งหมด
			$total_key += cal_num_key($rs[date_c]); // จำนวนที่คีย์เสร็จ
			$total_remain += $rs[num1]-cal_num_key($rs[date_c]);
			
			}// end while(){
	?>
      <tr>
        <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ยอดคงเหลือที่จะต้องนำเข้าระบบ จากทั้งหมด 25,561 คน </strong></td>
        <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td width="24%" align="center" bgcolor="#A5B2CE"><strong>รวมที่นำเข้า</strong></td>
            <td width="35%" align="center" bgcolor="#A5B2CE"><strong>จำนวนคงเหลือ</strong></td>
            <td width="41%" align="center" bgcolor="#A5B2CE"><strong>ค่าเฉลี่ยที่ต้อง<br />
              นำเข้าแต่ละวัน</strong></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format($total_pdf);?></td>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format(($number_all-$total_pdf));?></td>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format(($number_all-$total_pdf)/$date_remain)?></td>
          </tr>
        </table></td>
        <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td width="28%" align="center" bgcolor="#A5B2CE"><strong>รวมที่คีย์เสร็จ</strong></td>
            <td width="33%" align="center" bgcolor="#A5B2CE"><strong>จำนวนคงเหลือ</strong></td>
            <td width="39%" align="center" bgcolor="#A5B2CE"><strong>ค่าเฉลี่ยที่ต้องคีย์<br />
              ให้เสร็จแต่ละวัน</strong></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format($total_key)?></td>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format($number_all-$total_key);?></td>
            <td align="center" bgcolor="#CCCCCC"><?=@number_format(($number_all-$total_key)/$date_remain);?></td>
          </tr>
        </table></td>
        <td align="center" bgcolor="#FFFFFF"><?=@number_format($total_remain);?></td>
    </tr
    ></table></td>
  </tr>
  <?
  	} //end if($action == ""){
   if($action == "view_detail"){?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A5B2CE"><img src="../../images_sys/home.gif" width="20" height="20" alt="กลับหน้าหลัก" onclick="location.href='index_key_report.php?action=&xmode=1'" style="cursor:hand">&nbsp;          <strong>
          <? $arr_c = explode("-",$date_c); echo "รายการข้อมูลนำเข้าวันที่  ".intval($arr_c[2])." ".$mname[intval($arr_c[1])]." ".($arr_c[0]+543);?>
        </strong></td>
        </tr>
      <tr>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="33%" align="center" bgcolor="#A5B2CE"><strong>รหัสบัตร</strong></td>
        <td width="29%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนามสกุล</strong></td>
        <td width="29%" align="center" bgcolor="#A5B2CE"><strong>เขตพื้นที่การศึกษา</strong></td>
      </tr>
	  <?
	 if($type == "1"){ //  ข้อมูลที่นำเข้าทั้งหมด
$sql = "SELECT  log_pdf.idcard,view_general.CZ_ID, view_general.prename_th, view_general.name_th, view_general.surname_th, eduarea.secname FROM log_pdf LEFT JOIN view_general ON log_pdf.idcard = view_general.CZ_ID LEFT JOIN eduarea ON view_general.siteid = eduarea.secid where log_pdf.date_c='$date_c'";
	}else if($type == "2"){
	$sql = "SELECT log_pdf.idcard, ".DB_MASTER.".view_general.CZ_ID,  ".DB_MASTER.".view_general.prename_th,  ".DB_MASTER.".view_general.name_th,  ".DB_MASTER.".view_general.surname_th,
 ".DB_MASTER.".eduarea.secname FROM  ".DB_MASTER.".log_pdf Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_MASTER.".log_pdf.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard Inner Join  ".DB_MASTER.".view_general ON ".DB_USERENTRY.".tbl_assign_key.idcard =  ".DB_MASTER.".view_general.CZ_ID
Inner Join  ".DB_MASTER.".eduarea ON  ".DB_MASTER.".view_general.siteid =  ".DB_MASTER.".eduarea.secid WHERE  ".DB_MASTER.".log_pdf.date_c =  '$date_c' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2'";
	}else{
		$sql = "SELECT log_pdf.idcard, ".DB_MASTER.".view_general.CZ_ID,  ".DB_MASTER.".view_general.prename_th,  ".DB_MASTER.".view_general.name_th,  ".DB_MASTER.".view_general.surname_th,
 ".DB_MASTER.".eduarea.secname FROM  ".DB_MASTER.".log_pdf Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_MASTER.".log_pdf.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard Inner Join  ".DB_MASTER.".view_general ON ".DB_USERENTRY.".tbl_assign_key.idcard =  ".DB_MASTER.".view_general.CZ_ID
Inner Join  ".DB_MASTER.".eduarea ON  ".DB_MASTER.".view_general.siteid =  ".DB_MASTER.".eduarea.secid WHERE  ".DB_MASTER.".log_pdf.date_c =  '$date_c' AND ".DB_USERENTRY.".tbl_assign_key.approve <>  '2'";
	}
	//end 
$result = mysql_db_query($dbnamemaster,$sql);
$j=0;
while($rs = mysql_fetch_assoc($result)){
	if($j% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $j++;
		  if($rs[CZ_ID] == ""){ 
	 			 $bg = "#FF6600";
				$txt_s = " title='ข้อมูลตั้งต้นยังไม่สมบูรณ์'";
	  }

	  ?>
      <tr bgcolor="<?=$bg?>" <?=$txt_s?>>
        <td align="center"><?=$j?></td>
        <td align="center"><? echo " $rs[idcard]  ";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[secname]";?></td>
      </tr>
	 <?
	 $txt_s = "";
	}// end while(){
	 ?>
    </table></td>
  </tr>
  <? } //end if($action == "search"){?>
</table>
<center> 
  <span class="style1">*หมายเหตุ </span>รายการที่เป็นแทบสีส้ม แสดงว่าข้อมูลตั้งต้นในระบบยังไม่สมบูรณ์
</center>
</body>
</html>
