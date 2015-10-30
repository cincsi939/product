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


function XCount_Page($file){
        if(file_exists($file)) { 
		
                        //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
						
                    }else { 
                          $contents = fread($handle, 1000); 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
						//echo "<pre>";
						//print_r($found);
						//$count_file = $found['1'];
                        // return $found[1]; 
                        } 
                    } 
                    $i++; 
                } //end   while (!feof($handle)) { 
				}
			}
		return $found[1];
		//fclose($handle); 
	}//end function Count_Page(){




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
function read_file_folder($get_site){
		$Dir_Part="../../../checklist_kp7file/$get_site/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		//echo "name :: ".$Name;
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
//		echo "<pre>";
//		print_r($File_Array);
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
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong><a href="?action=getdata&type=pdfall">ประมวลผลทั้งหมด</a></strong></td>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>จำนวนหน้าที่แสกน<br />
      กับการนับไฟล์<br />
      ไม่ตรงกัน(คน)</strong></td>
    <td height="24" colspan="4" align="center" bgcolor="#CAD5FF"><strong>จำนวนรายการ</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#CAD5FF"><strong>จำนวนบุคลากรทั้งหมด(คน)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>จำนวนไฟล์ pdf <br />ที่ำนำเข้าระบบ(ไฟล์)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>คงค้างเข้า<br />
      ระบบ(ไฟล์)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>คัดลอกไฟล์<br>เข้าในระบบ</strong></td>
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
    <td width="4%" height="24" align="center"><?=$j?></td>
    <td width="23%"><?=$rs[secname]?>&nbsp;[<?=$rs[secid]?>]</td>
    <td width="12%" align="center"><a href="?action=getdata&type=pdf&xsecid=<?=$rs[secid]?>">ประมวลผลรายเขต</a></td>
    <td width="14%" align="center"><? if($arr1[NumPageFail] > 0){ echo "<a href='?action=view_page_fail&sentsecid=$rs[secid]&amount=$arr1[NumPageFail]' target='_blank'>".number_format($arr1[NumPageFail])."</a>";}else{ echo "0";}?></td>
    <td width="15%" align="center"><? if($arr1[NumPerson] > 0){ echo "<a href='?action=view_all&sentsecid=$rs[secid]&amount=$arr1[NumPerson]' target='_blank'>".number_format($arr1[NumPerson])."</a>";}else{ echo "0";}?></td>
    <td width="11%" align="center"><? if($arr1[NumPdf] > 0){ echo "<a href='?action=view_in&sentsecid=$rs[secid]&amount=$arr1[NumPdf]' target='_blank'>".number_format($arr1[NumPdf])."</a>";}else{ echo "0";}?></td>
    <td width="12%" align="center"><? if($DisCount > 0){ echo "<a href='?action=view_discount&sentsecid=$rs[secid]&amount=$DisCount' target='_blank'>".number_format($DisCount)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><a href="?action=copyfile&xsecid=<?=$rs[secid]?>">คัดลอกไฟล์</a></td>
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
    <td height="24" colspan="3" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_pagefail);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numperson);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numpdf);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_discount);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</td></tr></table>
<? } // end if(){
#################  ทำการคัดลอกไฟล์ จาก checklist ไปไว้ในระบบ cmss เพื่อใช้เป็นเอกสารในการบันทึกข้อมูล
if($action == "copyfile"){
	$date_copy = date("Y-m-d");
	$path_source = "../../../checklist_kp7file/$xsecid/";
	$path_dest = "../../../".PATH_KP7_FILE."/$xsecid/";
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsecid' ORDER BY idcard ASC";
	$result = mysql_db_query($dbname_temp,$sql);
	$k=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		$file_source = $path_source."$rs[idcard]".".pdf";
		$file_dest = $path_dest."$rs[idcard]".".pdf";
		if(copy($file_source,$file_dest)){
			$j++;
			$sql_up = "INSERT INTO log_copy_kp7file(idcard,siteid,date_copy,user_copy,status_copy_file)VALUES('$rs[idcard]','$rs[siteid]','$date_copy','".$_SESSION[session_staffid]."','1')";
			chmod("$file_dest",0777);
		}else{
			$k++;
			$sql_up = "INSERT INTO log_copy_kp7file(idcard,siteid,date_copy,user_copy,status_copy_file)VALUES('$rs[idcard]','$rs[siteid]','$date_copy','".$_SESSION[session_staffid]."','0')";	
		}//end if(copy($file_source,$file_dest)){
		mysql_db_query($dbname_temp,$sql_up);
		
			
	}//end while($rs = mysql_fetch_assoc($result)){
	echo "<script>alert('คัดลอกไฟล์ได้  $j  รายการไม่สามารถคัดลอกได้ $k รายการ'); location.href='script_manage_filepdfv1.php?action=';</script>";	
}//end if($action == "copyfile"){
#################  end  คัดลอกไฟล์
if($action == "getdata"){
	####  sript log pdf
	if($type == "pdf"){
	$file_pdf = read_file_folder($xsecid);
	
//echo "<pre>";
//print_r($file_pdf);
//die;
	
	$path_n = "../../../checklist_kp7file/$xsecid/";
	if(!is_dir($path_n)){
		xRmkdir($path_n);
	}
	$path_old = "../../../checklist_kp7file/fileall/";
	$pdf = ".pdf";
		if(count($file_pdf) > 0){
		$j=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v' AND siteid='$xsecid'";
				//echo $sql_c."<br>";
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$rs_c = mysql_fetch_assoc($result_c);
					if($rs_c[idcard] != ""){// กรณีมีข้อมูลในเขตนี้เท่านั้น
						$file_source =$path_old.$v.$pdf;
						$file_dest = $path_n.$v.$pdf;
					//echo "<a href='$file_source' target='_blank'>$file_source [$xsecid]</a><br>";
							//copy($file_source,$file_dest);
							###  เก็บ log เวลาการ upload ไฟล์
/*							if(is_file($file_source)){
								$temp_date = date("Y-m-d", filectime($file_source));
								$sql_cf = "SELECT COUNT(idcard) as numid FROM log_pdf WHERE idcard='$v'";
								$result_cf = mysql_db_query($dbnamemaster,$sql_cf);
								$rs_cf = mysql_fetch_assoc($result_cf);
								if($rs_cf[numid] > 0){
										$sql_re = "UPDATE log_pdf SET  date_m='$temp_date'  WHERE idcard='$rs_c[idcard]'";
										
								}else{
										$sql_re = "REPLACE INTO log_pdf(idcard,secid,date_c,date_m)VALUES('$rs_c[idcard]','$rs_c[siteid]','$temp_date','$temp_date')";	
								}//end if($rs_cf[numid] > 0){
								
								mysql_db_query($dbnamemaster,$sql_re);
							}//end if(is_file($file_source)){*/
							### end เก็บ log การ upload ไฟล์
							//echo $file_dest."<br>";
							if(is_file($file_dest)){ 
								
								//chmod("$file_dest",0777);
								$temp_page = CountPageSystem($file_dest);
								echo "จำนวนแผ่น :: ".$temp_page."<br>";
								//$temp_page = XCount_Page($file_dest);
								//echo "temp ".$temp_page;die;
								if($temp_page < 1){ 
									$temp_page = "99";
								//$temp_page = 99;
								}else{ 
									$temp_page = $temp_page;
								} // กรณีนับแผ่นไม่ได้ให้กำหนดเป็นค่าสูงสุดเพื่อจัดกลุ่มข้อมูลได้

								$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
								echo "$sql_update<br>";
								//mysql_db_query($dbname_temp,$sql_update);
								//AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
								//echo $temp_page."<br>";
								// จากนั้นทำการลบไฟล์ต้นฉบับ
								//@unlink($file_source);
							}//else{
//								//AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
//							}
						$j++;	
					}//end if($rs_c[idcard] != ""){
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
		//echo "script เก็บ log บันทึกข้อมูลเรียบร้อยแล้ว  $j  รายการ";
	echo "<script>alert('script เก็บ log บันทึกข้อมูลเรียบร้อยแล้ว  $j  รายการ'); location.href='script_manage_numpage_pdf.php?action=';</script>";
	}// end if($type == "pdf"){
	#### end sript log pdf
#####  ประมวลผลทั้งหมด
	if($type == "pdfall"){
		$file_pdf = read_file_folder();
		$path_n = "../../../checklist_kp7file/";
		$path_old = "../../../checklist_kp7file/fileall/";
		$pdf = ".pdf";	
		if(count($file_pdf) > 0){
			$i=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v'";
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$rs_c = mysql_fetch_assoc($result_c);
				if($rs_c[idcard] != ""){
					$i++;
						$file_source =$path_old.$v.$pdf;
						$path_f = $path_n.$rs_c[siteid]."/";
							if(!is_dir($path_f)){
								xRmkdir($path_f);
							}
							$file_dest = $path_n.$rs_c[siteid]."/".$v.$pdf;
							@copy($file_source,$file_dest);
							
							
														###  เก็บ log เวลาการ upload ไฟล์
							if(is_file($file_source)){
								$temp_date = date("Y-m-d", filectime($file_source));
								$sql_cf = "SELECT COUNT(idcard) as numid FROM log_pdf WHERE idcard='$v'";
								$result_cf = mysql_db_query($dbnamemaster,$sql_cf);
								$rs_cf = mysql_fetch_assoc($result_cf);
								if($rs_cf[numid] > 0){
										$sql_re = "UPDATE log_pdf SET  date_m='$temp_date'  WHERE idcard='$rs_c[idcard]'";
										
								}else{
										$sql_re = "REPLACE INTO log_pdf(idcard,secid,date_c,date_m)VALUES('$rs_c[idcard]','$rs_c[siteid]','$temp_date','$temp_date')";	
								}//end if($rs_cf[numid] > 0){
								
								mysql_db_query($dbnamemaster,$sql_re);
							}//end if(is_file($file_source)){
							### end เก็บ log การ upload ไฟล์

							
							
						if(is_file($file_dest)){ 
								chmod("$file_dest",0777);
								$temp_page = CountPageSystem($file_dest);
								if($temp_page < 1){ 
									$temp_page = "99";
								//$temp_page = 99;
								}else{ 
									$temp_page = $temp_page;
								} // กรณีนับแผ่นไม่ได้ให้กำหนดเป็นค่าสูงสุดเพื่อจัดกลุ่มข้อมูลได้
								//$temp_page = XCount_Page($file_dest);
								$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
								mysql_db_query($dbname_temp,$sql_update);
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
								//echo $temp_page."<br>";
								// จากนั้นทำการลบไฟล์ต้นฉบับ
								//@unlink($file_source);
							}else{
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
							}//end if(is_file($file_dest)){ 
				}//end if($rs_c[idcard] != ""){
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){	
		
		echo "<script>alert('script เก็บ log บันทึกข้อมูลเรียบร้อยแล้ว  $i รายการ'); location.href='script_manage_numpage_pdf.php?action=';</script>";
	}//end if($type == "pdfall"){
}// if($action == "getdata"){
################  แสดงรายละเอียดจำนวนบุคลากร
if($action == "view_all" or $action == "view_in" or $action == "view_discount" or $action == "view_page_fail"){
	if($action == "view_all"){
			$xtitle = "รายงานจำนวนบุคลากรทั้งหมด ".show_area($sentsecid);
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' ORDER BY id ASC";
	}else if($action == "view_in"){
			$xtitle = "รายงานจำนวนบุคลากรที่มีไฟล์ pdf แล้ว ".show_area($sentsecid);	
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num  FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND page_upload > 0 AND page_upload IS NOT NULL ORDER BY id ASC";
	}else if($action == "view_discount"){
			$xtitle = "รายงานจำนวนบุคลากรที่ยังไม่มีไฟล์ pdf ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (page_upload = 0 OR page_upload IS NULL) ORDER BY id ASC";
	}else if($action == "view_page_fail"){
			$xtitle = "รายงานจำนวนบุคลากรที่ผลการนับจำนวนหน้าเอกสารกับจากการที่ระบบนับไม่ตรงกัน ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (page_upload > 0 and  page_upload  <> page_num ) ORDER BY id ASC";	
			//echo $sql;
	}
	$result = mysql_db_query($dbname_temp,$sql);
	$numrow = @mysql_num_rows($result);
	
	if($action == "view_page_fail"){ $col = "9";}else{ $col = "8";}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$col?>" align="left" bgcolor="#CAD5FF"><strong><?=$xtitle?>&nbsp;&nbsp;จำนวนรายการทั้งหมด <?=$numrow?> รายการ</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ลำ<br />
          ดับ</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="14%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่ง</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>สังกัด</strong></td>
        <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>จำนวนผ่น(แผ่น)</strong></td>
        <? if($action == "view_page_fail"){?>
        <td width="25%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>คนตรวจ</strong></td>
        <? }//end if($action == "view_page_fail"){ ?>
        <td width="3%" rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ไฟล์</strong></td>
      </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#CAD5FF"><strong>คนนับ</strong></td>
        <td width="10%" align="center" bgcolor="#CAD5FF"><strong>ระบบนับ</strong></td>
        </tr>
        <?
        if($numrow < 0){
			echo "<tr> <td colspan='6' align='center'> - ไม่พบรายการ - </td></tr>";
		}else{
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../checklist_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
				}else{
					$img_pdf = "";
				}//end if(is_file($file_pdf)){
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="center"><?=$rs[page_num]?></td>
        <td align="center"><?=$rs[page_upload]?></td>
        <? if($action == "view_page_fail"){ ?>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="52%" align="center" bgcolor="#CAD5FF"><strong>ชื่อคนตรวจ</strong></td>
                <td width="48%" align="center" bgcolor="#CAD5FF"><strong>เวลาตรวจ</strong></td>
              </tr>
              <?
              	$sql_a = "SELECT
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_log.time_update
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1'
and edubkk_checklist.tbl_checklist_log.idcard='$rs[idcard]'
order by time_update DESC";
	$result_a = mysql_db_query(DB_USERENTRY,$sql_a);
	$j=0;
	while($rs_a = mysql_fetch_assoc($result_a)){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="left"><? echo "$rs_a[prename]$rs_a[staffname]  $rs_a[staffsurname]";?></td>
                <td align="left"><? echo "$rs_a[time_update]";?></td>
              </tr>
              <?
	}
			  ?>
            </table></td>
          </tr>
        </table></td>
        <? } //end if($action == "view_page_fail"){?>
        <td align="center"><? echo $img_pdf;?></td>
        </tr>
        <?
			}//end while(){
		}//end if($numrow < 0){
		?>
    </table></td>
  </tr>
</table>
<?
}//end if($action == "view_all" or $action == "view_in" or $action == "view_discount"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>