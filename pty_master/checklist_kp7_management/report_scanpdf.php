<?
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report_pobec"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist.inc.php");
$time_start = getmicrotime();
/*require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');
### function นับจำนวนหน้า pdf by พี่น้อย
function CountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}


function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

function get_picture($id){
	
	global $folder_img;	
	$ext_array	= array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

		for ($i=0;$i<count($ext_array);$i++){
			$img_file = $folder_img . $id . "." . $ext_array[$i];
			if(file_exists($img_file)) return $img_file;
		}

	return "";
}
*/
function read_file_folder(){
		$Dir_Part="../../../checklist_kp7file/fileall/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
	// edit_pic----------------------------------------------------------------------------------------
	
	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf($get_siteid){
		global $dbname_temp;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail
		FROM tbl_checklist_kp7 WHERE siteid='$get_siteid'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['NumPdf'] = $rs[NumPdf];
		$arr['NumPerson'] = $rs[NumPerson];
		$arr['NumPageFail'] = $rs[NumPageFail];
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}
	###  สร้าง โฟล์เดอร์
	function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
</head>
<body>
<? if($action == ""){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
<tr>
  <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">
  <tr>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>เขตพื้นที่การศึกษา</strong></td>
    <td height="24" colspan="3" align="center" bgcolor="#CAD5FF"><strong>จำนวนรายการ</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#CAD5FF"><strong>จำนวนบุคลากรทั้งหมด(คน)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ pdf <br />ที่ำนำเข้าระบบ(ไฟล์)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>คงค้างเข้าระบบ(ไฟล์)</strong></td>
  </tr>
  <?
	$j = 1;
	$sql = " SELECT  eduarea.secid, eduarea.area_id , secname  FROM  eduarea    WHERE  status_area53 = '1' ORDER BY secname ASC";
	$result = mysql_db_query(DB_MASTER,$sql) ;
	while($rs = mysql_fetch_assoc($result)){	
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		$arr1 = CountPersonPdf($rs[secid]);
		$DisCount = $arr1[NumPerson]-$arr1[NumPdf];
?>
  <tr bgcolor="<?=$bgcolor1?>">
    <td width="7%" height="24" align="center"><?=$j?></td>
    <td width="39%"><?=$rs[secname]?>&nbsp;[<?=$rs[secid]?>]</td>
    <td width="22%" align="center"><? if($arr1[NumPerson] > 0){ echo "<a href='?action=view_all&sentsecid=$rs[secid]&amount=$arr1[NumPerson]' target='_blank'>".number_format($arr1[NumPerson])."</a>";}else{ echo "0";}?></td>
    <td width="15%" align="center"><? if($arr1[NumPdf] > 0){ echo "<a href='?action=view_in&sentsecid=$rs[secid]&amount=$arr1[NumPdf]' target='_blank'>".number_format($arr1[NumPdf])."</a>";}else{ echo "0";}?></td>
    <td width="17%" align="center"><? if($DisCount > 0){ echo "<a href='?action=view_discount&sentsecid=$rs[secid]&amount=$DisCount' target='_blank'>".number_format($DisCount)."</a>";}else{ echo "0";}?></td>
  </tr>
   <? 
  $sum_all_pagefail += $arr1[NumPageFail];
  $sum_all_numperson += $arr1[NumPerson];
  $sum_all_numpdf += $arr1[NumPdf];
  $sum_all_discount += $DisCount;
  
 $j++ ;
 }  // end while
  ?> 
  <tr>
    <td height="24" colspan="2" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numperson);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numpdf);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_discount);?>
    </strong></td>
  </tr>
</table>
</td></tr></table>
<? } // end if(){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>