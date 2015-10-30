<?
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "search_person"; 
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


function read_file_folder($get_siteid){
		$Dir_Part="../../../checklist_kp7file/$get_siteid/";
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
	
	
function CountErrorFile(){
	global $dbname_temp;
	$sql = "SELECT  
	SUM(if(status_file=0,1,0)) as sum_error,
	SUM(if(status_file=1,1,0)) as sum_ok,
	siteid
	FROM temp_check_pdf_error GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['sum_error'] = $rs['sum_error'];
			$arr[$rs[siteid]]['sum_ok'] = $rs['sum_ok']; 
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function CountErrorFile(){
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title> script ตรวจสอบไฟล์ pdf error</title>
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
    <td height="24" colspan="4" align="center" bgcolor="#CAD5FF"><strong>จำนวนรายการ</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ที่ไม่สมบูรณ์</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ที่สมบูรณ</strong>์</td>
    <td align="center" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ทั้งหมด</strong></td>
    <td align="center" bgcolor="#CAD5FF">&nbsp;</td>
  </tr>
  <?
  $arr_count = CountErrorFile();
//  echo "<pre>";
 // print_r($arr_count);
	$sql = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata'
ORDER BY secname ASC";
	$result = mysql_db_query(DB_MASTER,$sql) ;
	$i=0;
	while($rs = mysql_fetch_assoc($result)){	
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$file_error = $arr_count[$rs[secid]]['sum_error'];
			$file_ok = $arr_count[$rs[secid]]['sum_ok'];
			$sumfile = $file_error+$file_ok;
?>
  <tr bgcolor="<?=$bg?>">
    <td width="4%" height="24" align="center"><?=$i?></td>
    <td width="34%"><? echo "$rs[secname] [$rs[secid]]";?></td>
    <td width="15%" align="center"><? echo number_format($file_error);?></td>
    <td width="16%" align="center"><? echo number_format($file_ok);?></td>
    <td width="16%" align="center"><? echo number_format($sumfile);?></td>
    <td width="15%" align="center"><a href="?action=getdata&type=pdf&xsecid=<?=$rs[secid]?>">ประมวลผลรายเขต</a></td>
  </tr>
   <?   
   		$sum_fileerror += $file_error;
		$sum_fileok += $file_ok;
		
	 }  // end while($rs = mysql_fetch_assoc($result)){	
  ?> 
  <tr>
    <td height="24" colspan="2" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_fileerror);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_fileok);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_fileerror+$sum_fileok);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</td></tr></table>
<? } // end if(){
#################  end  คัดลอกไฟล์
if($action == "getdata"){
	####  sript log pdf
	if($type == "pdf"){
	$file_pdf = read_file_folder($xsecid);
		
	$path_n = "../../../checklist_kp7file/$xsecid/";
	if(!is_dir($path_n)){
		xRmkdir($path_n);
	}
	$pdf = ".pdf";
	//echo "<pre>";
	//print_r($file_pdf);die;
	
	//$file_pdf = array("3710600163588");
	
		if(count($file_pdf) > 0){
		$j=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v' AND siteid='$xsecid'";
				//echo $sql_c."<br>";
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$rs_c = mysql_fetch_assoc($result_c);
					if($rs_c[idcard] != ""){// กรณีมีข้อมูลในเขตนี้เท่านั้น
						$file_dest = $path_n.$v.$pdf;
							//echo $file_dest."<br>";
							if(is_file($file_dest)){ 
								///$temp_date = date("Y-m-d", filectime($file_dest));
								$temp_page = CountPageSystem($file_dest);
								//echo "temp ".$temp_page;die;
								if($temp_page < 1){  // กรณีที่ไฟล์ pdf  error
									$sql_up = "REPLACE INTO temp_check_pdf_error SET idcard='$v', siteid='$xsecid', date_create='$temp_date',status_file='0'";
								}else{
									$sql_up = "REPLACE INTO temp_check_pdf_error SET idcard='$v', siteid='$xsecid', date_create='$temp_date',status_file='1'";	
								}//end if($temp_page < 1){
									mysql_db_query($dbname_temp,$sql_up);
							}//end if(is_file($file_dest)){ 
						$j++;	
					}//end if($rs_c[idcard] != ""){
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
	echo "<script>alert('script เก็บ log บันทึกข้อมูลเรียบร้อยแล้ว  $j  รายการ'); location.href='script_check_pdf_error.php?action=';</script>";
	}// end if($type == "pdf"){
}// if($action == "getdata"){
################  แสดงรายละเอียดจำนวนบุคลากร
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>