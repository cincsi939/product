<?
set_time_limit(0);
include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");
## แสดงข้อมูลเขตพื้นที่การศึกษา
function GetEduArea($get_secid){
	global $dbnamemaster;
	$sql_eduarea = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
	$result_eduarea = mysql_db_query($dbnamemaster,$sql_eduarea);
	$rs_edu = mysql_fetch_assoc($result_eduarea);
	return $rs_edu[secname];
}
###  ตรวจสอบว่าเขตถูกยืนยันจำนวนบุคลากรในเขตจากทีม checklist หรือยัง
function CheckLockSite(){
	global $dbname_temp;
	$sql = "SELECT count(siteid) as num1,siteid FROM tbl_status_lock_site GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function CheckLockSite(){
	
function CheckImportToCmss($get_siteid){
	global $dbname_temp;
	$db_site = "cmss_$get_siteid";
	$sql = "SELECT
count(edubkk_checklist.tbl_check_data.idcard) as num1,
sum(if(page_upload>0,1,0)) as numpdf,
sum(if(pic_upload>0,pic_upload,0)) as numpic
FROM
edubkk_checklist.tbl_checklist_profile 
Inner Join edubkk_checklist.tbl_checklist_kp7 ON edubkk_checklist.tbl_checklist_profile.profile_id = edubkk_checklist.tbl_checklist_kp7.profile_id
Inner Join edubkk_checklist.tbl_check_data ON edubkk_checklist.tbl_checklist_kp7.idcard = edubkk_checklist.tbl_check_data.idcard 
Inner Join $db_site.general ON  edubkk_checklist.tbl_check_data.idcard = $db_site.general.idcard
WHERE
edubkk_checklist.tbl_checklist_profile.status_active =  '1'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.siteid
";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['numperson'] = $rs[num1];
	$arr['numpdf'] = $rs[numpdf];
	$arr['numpic'] = $arr[numpic];
	
	return $arr;
}//end function CheckImportToCmss($get_siteid){
	
### function นับข้อมูลในฐานข้อมูล checklidt
function NumDataChecklist(){
	global $dbname_temp;
	$sql = "SELECT
count(tbl_checklist_kp7.siteid) as num1,
sum(if(page_upload > 0,1,0)) as numpdf,
sum(if(pic_num > 0,pic_num,0)) as numpic,
siteid
FROM
tbl_checklist_kp7
Inner Join tbl_checklist_profile ON tbl_checklist_kp7.profile_id = tbl_checklist_profile.profile_id
WHERE
tbl_checklist_profile.status_active =  '1'
GROUP BY siteid
";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs['siteid']]['numperson'] = $rs[num1]	;
		$arr[$rs['siteid']]['numpdf'] = $rs[numpdf];
		$arr[$rs['siteid']]['numpic'] = $rs[numpic];
	}
	return $arr;
}//end function NumDataChecklist(){

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>รายงานแสดงจำนวนหน่วยนับข้อมูลบุคลากรตั้งแต่กระบวนการเริ่มจนถึงกระบวนการคีย์ข้อมูล</title>
</head>
<body>
<? if($action == ""){?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="12" align="center" bgcolor="#CAD5FF"><strong>รายงานแสดงจำนวนหน่วยนับข้อมูลบุคลากรตั้งแต่กระบวนการเริ่มจนถึงกระบวนการคีย์ข้อมูล</strong></td>
        </tr>
        <tr>
          <td width="4%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
          <td width="20%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>เขตพื้นที่การศึกษา</strong></td>
          <td width="10%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>สถานะยืนยัน<br />
            จำนวนจาก <br />
            Checklist</strong></td>
          <td width="8%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>สถานะนำเข้า<br />
            ข้อมูล<br />
            checklist สู่ 
          cmss</strong></td>
          <td colspan="3" align="center" bgcolor="#CAD5FF"><strong>ข้อมูลจากฐาน Checklist</strong></td>
          <td colspan="3" align="center" bgcolor="#CAD5FF"><strong>ข้อมูลจากฐาน Cmss</strong></td>
          <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>จำนวน<br />
          ไฟล์ค้าง</strong></td>
          </tr>
        <tr>
          <td width="8%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวน<br />
          บุคลากร</strong></td>
          <td width="7%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ <br />
          PDF</strong></td>
          <td width="8%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวน<br />
          นับรูป</strong></td>
          <td width="8%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวน<br />
          บุคลากร</strong></td>
          <td width="8%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ <br />
PDF</strong></td>
          <td width="7%" align="center" valign="top" bgcolor="#CAD5FF"><strong>จำนวน<br />
          นับรูป</strong></td>
          <td width="6%" align="center" valign="top" bgcolor="#CAD5FF"><strong>PDF</strong></td>
          <td width="6%" align="center" valign="top" bgcolor="#CAD5FF"><strong>รูปภาพ</strong></td>
        </tr>
        <?
			//$path_file = "../../../checklist_kp7file/";
			$arr_chklist = NumDataChecklist(); // นับจำนวนข้อมูลในฐานข้อมูล Checklilt
			$arr_locksite = CheckLockSite();
        	$sql = "SELECT eduarea.secid, eduarea.secname FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' ORDER BY eduarea.secname ASC";
			$result = mysql_db_query($dbnamemaster,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if($i% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $i++;
			$arrcmss = CheckImportToCmss($rs[secid]); // นับจำนวนข้อมูลที่นำเข้าไปในฐาน cmss แล้ว
			##  สถานะยืนยันข้อมูลจากทีม checklist
			if($arr_locksite[$rs[secid]] > 0){ 
				$locksite="<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" title=\"สถานะยืนยันข้อมูลจากทีม Checklist\" border=\"0\">";
			}else{
				$locksite="<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" title=\"ยังไม่ได้ยืนยันข้อมูลจากทีม Checklist\" border=\"0\">";
			}//end if($arr_locksite[$rs[secid]] > 0){
			##  สถานะนำเข้าข้อมูลในฐานข้อมูล cmss แล้วหรือยัง
			if($arrcmss['numperson'] > 0){
				$img_imp = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" title=\"สถานะนำเข้าข้อมูลจากฐาน Cmss \" border=\"0\">";
			}else{
				$img_imp = "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" title=\"ยังไม่ได้นำเข้าข้อมูลจากฐาน Cmss\" border=\"0\">";
			}
			## จำข้อมูลในฐาน Checklist
			$num_chk = $arr_chklist[$rs[secid]]['numperson']; // จำนวนคนข้อมูลใน checklist
			$num_chk_pdf = $arr_chklist[$rs[secid]]['numpdf'];// จำนวนไฟล์ pdf
			$num_chk_pic = $arr_chklist[$rs[secid]]['numpic'];// จำนวนไฟล์รูป
			# จำนวนข้อมูลในฐาน Cmss
			$num_cmss = $arrcmss['numperson'];
			$num_cmss_pdf = $arrcmss['numpdf'];
			$num_cmss_pic = $arrcmss['numpic'];
			
			
//			$pdf_file = $path_file.$rs[siteid]."/".$rs[idcard].".pdf";
//				if(is_file($pdf_file)){
//						$show_pdf = "<a href='$pdf_file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf_gray.gif\" width=\"20\" height=\"20\" border=\"0\" title=\"ไฟล์ pdf ต้นฉบับ\"></a>";
//				}else{
//						$show_pdf = "";	
//				}
		$def_pdf = $num_chk - $num_cmss_pdf;
		$def_pic = $num_chk - $num_cmss_pic;
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="left"><? echo str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);?></td>
          <td align="center"><? echo $locksite ;?></td>
          <td align="center"><? echo $img_imp ;?></td>
          <td align="center"><? echo number_format($num_chk);?></td>
          <td align="center"><? echo number_format($num_chk_pdf);?></td>
          <td align="center"><? echo number_format($num_chk_pic);?></td>
          <td align="center"><? echo number_format($num_cmss);?></td>
          <td align="center"><? echo number_format($num_cmss_pdf);?></td>
          <td align="center"><? echo number_format($num_cmss_pic);?></td>
          <td align="center"><? echo number_format($def_pdf)?></td>
          <td align="center"><? echo number_format($def_pic);?></td>
        </tr>
        <?
					$num_chk_all += $num_chk;
					$num_chk_pdf_all += $num_chk_pdf;
					$num_chk_pic_all += $num_chk_pic;
					$num_cmss_all += $num_cmss;
					$num_cmss_pdf_all += $num_cmss_pdf;
					$num_cmss_pic_all += $num_cmss_pic;
					$def_pdf_all += $def_pdf;
					$def_pic_all += $def_pic;
			}//end while($rs = mysql_fetch_assoc()){
		?>
        <tr>
          <td colspan="4" align="center" bgcolor="#EBEBEB"><strong>รวม :</strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_chk_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_chk_pdf_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_chk_pic_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_cmss_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_cmss_pdf_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($num_cmss_pic_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($def_pdf_all);?></strong></td>
          <td align="center" bgcolor="#EBEBEB"><strong><? echo number_format($def_pic_all);?></strong></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <?
			}//end if($action == ""){
  ?>
</body>
</html>
