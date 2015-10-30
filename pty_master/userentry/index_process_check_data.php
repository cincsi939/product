<?
set_time_limit(0);
session_start();
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function_checkdata.inc.php') ;

if($lv == ""){
		$lv = 1;
}//end if($lv == ""){

function ShowDataError(){
		global $db_temp;
		$sql = "SELECT count(idcard) as numid,siteid FROM `diag_checkdata` GROUP BY idcard,siteid";
		$result = mysql_db_query($db_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arrnum[$rs[siteid]] = $arrnum[$rs[siteid]]+1;
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arrnum;
}//end function ShowReport(){
	
function ShowDataAll(){
	global $db_temp;
	$sql = "SELECT COUNT(idcard) as numid,siteid FROM tbl_checklist_kp7 GROUP BY siteid";
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrnum_site[$rs[siteid]] = $rs[numid];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arrnum_site;
}//end function ShowDataAll(){

function CheckProcessData(){
		global $db_temp;
		$sql = "SELECT COUNT(siteid) as numsite, siteid FROM diag_checkmain GROUP BY siteid";
		$result = mysql_db_query($db_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arrdata[$rs[siteid]] = $rs[numsite];
		}//end while(){
			//echo "<pre>";
			//print_r($arrdata);
			return $arrdata;
}//end function CheckProcessData(){
	
function CheckImportToCmss($get_secid){
		global $db_temp;
		$sql = "SELECT secid FROM tbl_check_data WHERE secid='$get_secid' LIMIT 1";
		$result =mysql_db_query($db_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[secid] != ""){
				return 1;
		}else{
				return 0;	
		}
}//end 
	
################  บันทึกขอมูลหลังจากมีการประมวลผล
if($_SERVER['REQUEST_METHOD'] == "GET"){
	if($action == "process" and $lv == "1"){
			$sql_save = "REPLACE INTO diag_checkmain SET dateprocess='".date("Y-m-d")."',siteid='$xsiteid'";
			//mysql_db_query($db_temp,$sql_save);
			//ProcessCheckData($xsiteid,$idcard);// ประมวลผลตรวจสอบความถูกต้องของข้อมูล
		echo "<script>alert('ตรวจสอบข้อมูลเรียบร้อยแล้ว');location.href='?action=&lv=$lv';</script>";
		exit;	
	}//end if($action == "process" and $lv == "1"){
		
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบความถูกต้องของข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="46%" align="left"><img src="../../../kj_report/images/braner/Untitled-1_02.png" width="742" height="137" /></td>
        <td width="28%" background="../../../kj_report/images/braner/Untitled-1_03.png"></td>
        <td width="26%" align="right"><img src="../../../kj_report/images/braner/Untitled-1_04.png" width="267" height="137" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <? if($lv == "1"){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#A5B2CE">&nbsp;</td>
        </tr>
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="35%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลการตรวจสอบข้อมูล</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
        <td width="11%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>สถานะนำเข้าข้อมูล</strong></td>
        <td width="11%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>สถานะการประมวลผล<br />
        ตรวจสอบข้อมูล</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>สมบูรณ์</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ไม่สมบูรณ์</strong></td>
        </tr>
        <?
$arr = ShowDataError(); // รายการที่พบข้อมูลพลาด
$arr1 = ShowDataAll();// แสดงข้อมูลทั้งหมดในเขตนั้น
$arr2 = CheckProcessData();// แสดงสถานะที่มีการประมวลผลข้อมูล
$sql = "SELECT eduarea.secid, eduarea.secname,if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' group by eduarea.secid ORDER BY idsite, eduarea.secname ";
$result = mysql_db_query($dbnamemaster,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 ##  ตรวจสอบว่าเขตนั้นมีการประมวลผลข้อมูลรึยัง

	 if($arr2[$rs[secid]] > 0){
		$img_check = "<img src=\"../../../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='ประมวลมลตรวจสอบข้อมูลเรียบร้อยแล้ว'>";	 
		if($arr[$rs[secid]] < 1){
			$img_pass = "<img src=\"../../../../images_sys/status6.gif\" width=\"17\" height=\"17\" border=\"0\" title=\"ตรวจสอบข้อมูลแล้วไม่พบข้อผิดพลาด\">"	;
		}else{
			$img_pass = "";	
		}
	}else{
		$img_check = "";
	}
	######  ตรวจสอบสถานะการนำเข้าข้อมูล
	if(CheckImportToCmss($rs[secid])){
			$img_import = "<img src=\"../../../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='สถานะนำเข้าข้อมูลเรียบร้อยแล้ว'>";
	}else{
			$img_import = "";	
	}
	
	#####  จำนวนรายการที่สมบูรณ์
			$num_ture = $arr1[$rs[secid]]-$arr[$rs[secid]];
	
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?>&nbsp;<?=$img_pass?></td>
        <td align="center"><?=number_format($num_ture)?></td>
        <td align="center"><?=number_format($arr[$rs[secid]]);?></td>
        <td align="center"><?=number_format($arr1[$rs[secid]]);?></td>
        <td align="center"><?=$img_import?></td>
        <td align="center"><?=$img_check?></td>
        <td align="center"><img src="../../../../images_sys/refresh.png" width="20" height="20" border="0" title="ประมวลผลตรวจสอบข้อมูล" onclick="location.href='?action=process&xsiteid=<?=$rs[secid]?>'" style="cursor:hand"></td>
      </tr>
      <?
}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <? }else if($lv == "2"){?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <? } //end  }else if($lv == "2"){?>
</table>
</body>
</html>
