<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_import_pdf"; 
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


if($_SESSION['session_staffid'] == ""){
	echo "<script>alert(\" ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่ \");location.href='login.php';</script>";
	die;
}


include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
//include("checklist.inc.php");

$path_pdf = "../../../".PATH_KP7_FILE."/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='16' height='16' border='0'>";



	$dbname_temp = DB_CHECKLIST;
	if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
		
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = @mysql_db_query($dbname_temp,$sql_profile);
		$rspro = @mysql_fetch_assoc($result_profile);
		$profile_id = $rspro[profile_id];
	}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

include("function_check_xref.php");

function SaveLogUnlinkFile($idcard,$siteid,$file_script,$url_file,$profile_id){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_log_unlinkfile SET idcard='$idcard',siteid='$siteid',file_script='$file_script',url_file='$url_file',profile_id='$profile_id',staff_id='".$_SESSION['session_staffid']."',timeupdate=NOW()";
	mysql_db_query($dbname_temp,$sql);	
}//end 


$time_start = getmicrotime();

//mail_daily_request($workname, $xemail , $email_sys ,$msgtext,"","5001");	
function ApproveScanFile($idcard,$approve="",$page_upload=""){
	
	global $dbname_temp,$profile_id;
	if($approve == ""){
		$approve = 1;	
	}
	$date_recive_true = date("Y-m-d");
	// date_recive_true='$date_recive_true'
	$sql_update = "UPDATE tbl_checklist_assign_detail SET approve='$approve',page_upload='$page_upload' WHERE idcard ='$idcard' AND profile_id='$profile_id'";
	@mysql_db_query($dbname_temp,$sql_update);
	$sql_c = "SELECT ticketid FROM tbl_checklist_assign_detail WHERE  idcard ='$idcard' AND profile_id='$profile_id'";
	$result_c = mysql_db_query($dbname_temp,$sql_c);
	$rsc = mysql_fetch_assoc($result_c);
	#############  ตรวจสอบว่าจำนวนบุคลากรในใบงานกับจำนวนที่รับรองไปแล้วเท่ากันรึเปล่า
	$sqlc1 = "SELECT COUNT(idcard) AS num1, sum(if(approve='1',1,0)) as napprove,sum(if(approve='2',1,0)) AS numedit FROM tbl_checklist_assign_detail WHERE ticketid='$rsc[ticketid]' GROUP BY ticketid";
	$resultc1 = mysql_db_query($dbname_temp,$sqlc1);
	$rsc1 = mysql_fetch_assoc($resultc1);
	if($rsc1[num1] == $rsc1[napprove]){
		$approve = 1;	
	}else if($rsc1[numedit] > 0){
		$approve	= 2;
	}else{
		$approve = 0;	
	}//end if($rsc1[num1] == $rsc1[napprove]){
	################## 
	$sql_up1 = "UPDATE tbl_checklist_assign SET approve='$approve',date_recive_true='$date_recive_true' WHERE ticketid='$rsc[ticketid]'";
	@mysql_db_query($dbname_temp,$sql_up1);
	
}//end function ApproveScanFile(){



	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf(){
		global $dbname_temp,$profile_id;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1') and  status_id_false='0',1,0)) AS NumTrue,
		siteid
		FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' GROUP BY siteid";
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['NumPdf'] = $rs[NumPdf];
		$arr[$rs[siteid]]['NumPerson'] = $rs[NumPerson];
		$arr[$rs[siteid]]['NumPageFail'] = $rs[NumPageFail];
		$arr[$rs[siteid]]['NumTrue'] = $rs[NumTrue];
		}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}

	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<link href="../../common/jscriptfixcolumn/cssfixtable.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</SCRIPT>

</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<? if($action == ""){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
<tr>
  <td>
<table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="#000000" class="tbl3">
      <tr>
        <td height="24" colspan="9" align="center" bgcolor="#a3b2cc"><strong><!--<a href="?action=getdata&type=pdfall">ประมวลผลทั้งหมด</a>-->โปรแกรมนำเข้าไฟล์ทะเบียนประวัติต้นฉบับ</strong></td>
        </tr>
      <tr>
        <td rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ลำดับ</strong></td>
        <td rowspan="2" align="center" bgcolor="#a3b2cc"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td rowspan="2" align="center" bgcolor="#a3b2cc">&nbsp;</td>
        <td height="24" colspan="6" align="center" bgcolor="#a3b2cc"><strong>จำนวนรายการ</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#a3b2cc"><strong>จำนวนบุคลากร<br />
      ทั้งหมด(คน)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>จำนวนเอกสาร<br />
      พร้อมแสกน</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>จำนวนเอกสาร<br />
      ไม่พร้อมแสกน</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>จำนวนไฟล์ pdf <br />ที่นำเข้าระบบ(ไฟล์)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>คงค้างเข้า<br />
      ระบบ(ไฟล์)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>จำนวนไฟล์<br />
      ที่มีปัญหา</strong></td>
    </tr>
  <?
  $arrXref = NumXrefError();
	$j = 1;
	//$sql = " SELECT  eduarea.secid, eduarea.area_id , secname  FROM  eduarea    WHERE  status_area53 = '1' ORDER BY secname ASC";
	$sql = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
		if(substring(eduarea.secid,1,1) ='0',cast(eduarea.secid as SIGNED),9999) as idsite,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND  eduarea_config.profile_id='$profile_id'  order by idsite,eduarea.secname ASC";
	$result = mysql_db_query(DB_MASTER,$sql) ;
	$arr1 = CountPersonPdf();
	while($rs = mysql_fetch_assoc($result)){	
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		$site_id = $rs[secid];		
		$NumPdf = $arr1[$site_id]['NumPdf'];// จำนวนไฟล์ pdf
		$NumPerson = $arr1[$site_id]['NumPerson']; // จำนวนบุคลากรทั้งหมด
		$NumPageFail = $arr1[$site_id]['NumPageFail']; // จำนวนหน้าที่ไม่สมบูรณ์
		$NumTrue = $arr1[$site_id]['NumTrue']; // จำนวนเอกสารที่พร้อมแสกน
		$NumDiff = $NumPerson-$NumTrue; // จำนวนเอกสารที่ไม่พร้อมแสกน
		 
		$DisCount = $NumTrue-$NumPdf;
		$numxref = $arrXref[$rs[secid]];
?>
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="3%" height="24" align="center"><?=$j?></td>
    <td width="18%"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])?>&nbsp;[<?=$rs[secid]?>]</td>
    <td width="7%" align="center"><a href="?action=getdata&type=pdf&xsecid=<?=$rs[secid]?>&profile_id=<?=$profile_id?>">คัดลอกไฟล์</a></td>
    <td width="10%" align="center"><? if($NumPerson > 0){ echo "<a href='?action=view_all&sentsecid=$rs[secid]&amount=$NumPerson&profile_id=$profile_id' target='_blank'>".number_format($NumPerson)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><? if($NumTrue > 0){ echo "<a href='?action=view_True&sentsecid=$rs[secid]&amount=$NumTrue&profile_id=$profile_id' target='_blank'>".number_format($NumTrue)."</a>";}else{ echo "0";}?></td>
    <td width="10%" align="center"><? if($NumDiff > 0){ echo "<a href='?action=view_False&sentsecid=$rs[secid]&amount=$NumDiff&profile_id=$profile_id' target='_blank'>".number_format($NumDiff)."</a>";}else{ echo "0";}?></td>
    <td width="10%" align="center"><? if($NumPdf > 0){ echo "<a href='?action=view_in&sentsecid=$rs[secid]&amount=$NumPdf&profile_id=$profile_id' target='_blank'>".number_format($NumPdf)."</a>";}else{ echo "0";}?></td>
    <td width="7%" align="center"><? if($DisCount > 0){ echo "<a href='?action=view_discount&sentsecid=$rs[secid]&amount=$DisCount&profile_id=$profile_id' target='_blank'>".number_format($DisCount)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><? if($numxref > 0){ echo "<a href='?action=view_error&xsiteid=$rs[secid]&profile_id=$profile_id' target='_blank'>$numxref</a>";}else{ echo "0";}?></td>
    </tr>
   <? 
  $sum_all_pagefail += $NumPageFail;
  $sum_all_numperson += $NumPerson;
  $sum_all_numpdf += $NumPdf;
  $sum_all_discount += $DisCount;
  $sum_all_xref += $numxref;
  $sum_all_docT += $NumTrue ;
  $sum_all_docF += $NumDiff ;
  
 $j++ ;
 }  // end while
  ?> 
  <tr>
    <td height="24" colspan="3" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numperson);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($sum_all_docT);?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($sum_all_docF);?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sum_all_numpdf);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <? if($sum_all_discount > 0){ echo number_format($sum_all_discount);}else{ echo "0";}?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($sum_all_xref)?></strong></td>
    </tr>
</table>
</td></tr></table>
<? } // end if(){
#################  ทำการคัดลอกไฟล์ จาก checklist ไปไว้ในระบบ cmss เพื่อใช้เป็นเอกสารในการบันทึกข้อมูล
/*if($action == "copyfile"){
	$date_copy = date("Y-m-d");
	$path_source = "../../../checklist_kp7file/$xsecid/";
	$path_dest = "../../../".PATH_KP7_FILE."/$xsecid/";
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsecid' AND profile_id='$profile_id' and status_file='1'  ORDER BY idcard ASC";
	$result = mysql_db_query($dbname_temp,$sql);
	$k=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		$file_source = $path_source."$rs[idcard]".".pdf";
		$file_dest = $path_dest."$rs[idcard]".".pdf";
		//if(is_file($file_source)){ // ทำการลบไฟล์ปลายทางก่อนทำการนำไฟล์ไปทับ
				//@unlink($file_dest);
		//}
		
					if(copy($file_source,$file_dest)){
						$j++;
						$sql_up = "INSERT INTO log_copy_kp7file(idcard,siteid,date_copy,user_copy,status_copy_file)VALUES('$rs[idcard]','$rs[siteid]','$date_copy','".$_SESSION[session_staffid]."','1')";
						chmod("$file_dest",0777);
						if(file_exists($file_dest)){
							@unlink($file_source);	
						}//end if(file_exists($file_dest)){
					}else{
						$k++;
						$sql_up = "INSERT INTO log_copy_kp7file(idcard,siteid,date_copy,user_copy,status_copy_file)VALUES('$rs[idcard]','$rs[siteid]','$date_copy','".$_SESSION[session_staffid]."','0')";	
					}//end if(copy($file_source,$file_dest)){
					mysql_db_query($dbname_temp,$sql_up);
	
			
		
			
	}//end while($rs = mysql_fetch_assoc($result)){
	echo "<script>alert('คัดลอกไฟล์ได้  $j  รายการไม่สามารถคัดลอกได้ $k รายการ'); location.href='?action=';</script>";	
}//end if($action == "copyfile"){
*/#################  end  คัดลอกไฟล์
if($action == "getdata"){
	####  sript log pdf
	if($type == "pdf"){
		
		function xReadFileFolder1($get_site=""){
		if($get_site == ""){
			$Dir_Part="../../../".PATH_KP7_FILE."/fileall/";	
		}else{
			$Dir_Part="../../../".PATH_KP7_FILE."/$get_site/";	
		}//end if($get_site == ""){
		
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
	}// end function ReadFileFolder($get_site=""){
#############  end #########################################  นับไฟล์ในโฟล์เดอร์

		
	$file_pdf = xReadFileFolder1($xsecid);
	$count = 1;
	
//echo "<pre>";
//print_r($file_pdf);
//die;
//	
### log pdf main ก่อนทำการเก็บ รายละเอียด


	$path_n = "../../../checklist_kp7file/$xsecid/";
	$path_filekp7 = "../../../".PATH_KP7_FILE."/$xsecid/";
	$pdf = ".pdf";
	$i=0;
	foreach($file_pdf as $key => $val){
		$file_d = $path_filekp7.$val.$pdf;
		chmod("$file_d",0777);
		$i++;
			
	}//end 

		echo "<script>alert('นำเข้าไฟล์ pdf เรียบร้อยแล้ว  $i  รายการ  '); location.href='?action=&profile_id=$profile_id';</script>";

}// end if($type == "pdf"){
	#### end sript log pdf
#####  ประมวลผลทั้งหมด
//	if($type == "pdfall"){
//		$file_pdf = read_file_folder();
//		$path_n = "../../../checklist_kp7file/";
//		$path_old = "../../../checklist_kp7file/fileall/";
//		$pdf = ".pdf";	
//		if(count($file_pdf) > 0){
//			$i=0;
//			foreach($file_pdf as $k => $v){
//				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v'";
//				$result_c = mysql_db_query($dbname_temp,$sql_c);
//				$rs_c = mysql_fetch_assoc($result_c);
//				if($rs_c[idcard] != ""){
//					$i++;
//						$file_source =$path_old.$v.$pdf;
//						$path_f = $path_n.$rs_c[siteid]."/";
//							if(!is_dir($path_f)){
//								xRmkdir($path_f);
//							}
//							$file_dest = $path_n.$rs_c[siteid]."/".$v.$pdf;
//							@copy($file_source,$file_dest);
//							
//							
//														###  เก็บ log เวลาการ upload ไฟล์
//							if(is_file($file_source)){
//								$temp_date = date("Y-m-d", filectime($file_source));
//								$sql_cf = "SELECT COUNT(idcard) as numid FROM log_pdf WHERE idcard='$v'";
//								$result_cf = mysql_db_query($dbnamemaster,$sql_cf);
//								$rs_cf = mysql_fetch_assoc($result_cf);
//								if($rs_cf[numid] > 0){
//										$sql_re = "UPDATE log_pdf SET  date_m='$temp_date'  WHERE idcard='$rs_c[idcard]'";
//										
//								}else{
//										$sql_re = "REPLACE INTO log_pdf(idcard,secid,date_c,date_m)VALUES('$rs_c[idcard]','$rs_c[siteid]','$temp_date','$temp_date')";	
//								}//end if($rs_cf[numid] > 0){
//								
//								mysql_db_query($dbnamemaster,$sql_re);
//							}//end if(is_file($file_source)){
//							### end เก็บ log การ upload ไฟล์
//
//							
//							
//						if(is_file($file_dest)){ 
//								chmod("$file_dest",0777);
//								#$temp_page = CountPageSystem($file_dest);
//								if($temp_page < 1){ 
//									$temp_page = "99";
//								//$temp_page = 99;
//								}else{ 
//									$temp_page = $temp_page;
//								} // กรณีนับแผ่นไม่ได้ให้กำหนดเป็นค่าสูงสุดเพื่อจัดกลุ่มข้อมูลได้
//								//$temp_page = XCount_Page($file_dest);
//								$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
//								mysql_db_query($dbname_temp,$sql_update);
//								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
//								//echo $temp_page."<br>";
//								// จากนั้นทำการลบไฟล์ต้นฉบับ
//								@unlink($file_source);
//							}else{
//								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
//							}//end if(is_file($file_dest)){ 
//				}//end if($rs_c[idcard] != ""){
//			}//end foreach($file_pdf as $k => $v){
//		}//end if(count($file_pdf) > 0){	
//		
/*	echo "<script>alert('script เก็บ log บันทึกข้อมูลเรียบร้อยแล้ว  $i รายการ'); location.href='script_manage_filepdf.php?action=';</script>";*/
//	}//end if($type == "pdfall"){
}// if($action == "getdata"){
################  แสดงรายละเอียดจำนวนบุคลากร
if($action == "view_all" or $action == "view_in" or $action == "view_discount" or $action == "view_page_fail" or $action == "view_True" or $action == "view_False"){
	
	
	if($action == "view_all"){
			$xtitle = "รายงานจำนวนบุคลากรทั้งหมด ".show_area($sentsecid);
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND profile_id='$profile_id'  ORDER BY id ASC";
	}else if($action == "view_in"){
			$xtitle = "รายงานจำนวนบุคลากรที่มีไฟล์ pdf แล้ว ".show_area($sentsecid);	
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num  FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND page_upload > 0 AND page_upload IS NOT NULL AND profile_id='$profile_id'  ORDER BY id ASC";
	}else if($action == "view_discount"){
			$xtitle = "รายงานจำนวนบุคลากรที่ยังไม่มีไฟล์ pdf ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (page_upload = 0 OR page_upload IS NULL) AND profile_id='$profile_id' and status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1') and  status_id_false='0'  ORDER BY id ASC";
	}else if($action == "view_page_fail"){
			$xtitle = "รายงานจำนวนบุคลากรที่ผลการนับจำนวนหน้าเอกสารกับจากการที่ระบบนับไม่ตรงกัน ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (page_upload > 0 and  page_upload  <> page_num ) AND profile_id='$profile_id'   ORDER BY id ASC";	
			//echo $sql;
	}else if($action == "view_True"){
			$xtitle = "รายงานจำนวนบุคลากรที่เอกสารพร้อมแสกน ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND  profile_id='$profile_id'  AND status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1') and  status_id_false='0'  ORDER BY id ASC";	
	}else if($action == "view_False"){
			$xtitle = "รายงานจำนวนบุคลากรที่เอกสารไม่พร้อมแสกน ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND  profile_id='$profile_id'  AND (!(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1') and  status_id_false='0'))  ORDER BY id ASC";	
	}
	$result = mysql_db_query($dbname_temp,$sql);
	$numrow = @mysql_num_rows($result);
	
	if($action == "view_page_fail"){ $col = "9";}else{ $col = "8";}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$col?>" align="left" bgcolor="#a3b2cc"><strong><?=$xtitle?>&nbsp;&nbsp;จำนวนรายการทั้งหมด <?=$numrow?> รายการ</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ลำ<br />
          ดับ</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="14%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ตำแหน่ง</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>สังกัด</strong></td>
        <td colspan="2" align="center" bgcolor="#a3b2cc"><strong>จำนวนผ่น(แผ่น)</strong></td>
        <? if($action == "view_page_fail"){?>
        <td width="25%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>คนตรวจ</strong></td>
        <? }//end if($action == "view_page_fail"){ ?>
        <td width="3%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ไฟล์</strong></td>
      </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#a3b2cc"><strong>คนนับ</strong></td>
        <td width="10%" align="center" bgcolor="#a3b2cc"><strong>ระบบนับ</strong></td>
        </tr>
        <?
        if($numrow < 0){
			echo "<tr> <td colspan='6' align='center'> - ไม่พบรายการ - </td></tr>";
		}else{
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
				}else{
					$arrpdf = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,$rs[schoolid],"pdf");
					$img_pdf = $arrpdf['linkfile'];
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
and edubkk_checklist.tbl_checklist_log.idcard='$rs[idcard]' AND profile_id='$profile_id' 
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
if($action == "view_error"){
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid
FROM
tbl_check_xref_pdf
Inner Join tbl_checklist_kp7 ON tbl_check_xref_pdf.idcard = tbl_checklist_kp7.idcard
WHERE
tbl_check_xref_pdf.siteid =  '$xsiteid' AND tbl_checklist_kp7.profile_id='$profile_id' 
";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#a3b2cc"><strong>ไฟล์ pdf ที่มีปัญหา xref <?=show_area($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#a3b2cc"><strong>ลำดับ</strong></td>
        <td width="20%" align="center" bgcolor="#a3b2cc"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="24%" align="center" bgcolor="#a3b2cc"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#a3b2cc"><strong>ตำแหน่ง</strong></td>
        <td width="23%" align="center" bgcolor="#a3b2cc"><strong>สังกัด</strong></td>
        <td width="7%" align="center" bgcolor="#a3b2cc"><strong>ไฟล์</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../".PATH_KP7_FILE."/fileall/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับมีปัญหา xref' width='16' height='16' border='0'></a>";
				}else{
					$arrpdf = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,$rs[schoolid],"pdf");
					$img_pdf = $arrpdf['linkfile'];
				}//end if(is_file($file_pdf)){
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo $rs[idcard];?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><?=show_school($rs[schoolid]);?></td>
        <td align="center"><?=$img_pdf?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<? } //endif($action == "view_error"){ ?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>