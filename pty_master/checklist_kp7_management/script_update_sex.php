<?
set_time_limit(0);

include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
//include("checklist.inc.php");

include("function_check_xref.php");

//mail_daily_request($workname, $xemail , $email_sys ,$msgtext,"","5001");	




	## function count �ӹǹ�� �Ѻ��� pdf
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

	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>����ͧ���㹡�èѴ������ pdf</title>
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
<tr>
  <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">
      <tr>
        <td height="24" colspan="10" align="center" bgcolor="#a3b2cc"><strong><!--<a href="?action=getdata&type=pdfall">�����żŷ�����</a>-->����������������¹�����ԵԵ鹩�Ѻ</strong></td>
        </tr>
      <tr>
        <td rowspan="2" align="center" bgcolor="#a3b2cc"><strong>�ӴѺ</strong></td>
        <td rowspan="2" align="center" bgcolor="#a3b2cc"><strong>ࢵ��鹷�����֡��</strong></td>
        <td rowspan="2" align="center" bgcolor="#a3b2cc">&nbsp;</td>
        <td rowspan="2" align="center" bgcolor="#a3b2cc"><strong>�ӹǹ˹�ҷ���ʡ�<br />
�Ѻ��ùѺ���<br />
���ç�ѹ(��)</strong></td>
    <td height="24" colspan="6" align="center" bgcolor="#a3b2cc"><strong>�ӹǹ��¡��</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#a3b2cc"><strong>�ӹǹ�ؤ�ҡ÷�����(��)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>�ӹǹ��� pdf <br />���ӹ�����к�(���)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>����ҧ���<br />
      �к�(���)</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>�ӹǹ���<br />
      ����ջѭ��</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>�Ѵ�͡���<br />
      ��� CMSS</strong></td>
    <td align="center" bgcolor="#a3b2cc"><strong>Log</strong></td>
    </tr>
  <?
  $arrXref = NumXrefError();
	$j = 1;
	$sql = " SELECT  eduarea.secid, eduarea.area_id , secname  FROM  eduarea    WHERE  status_area53 = '1' ORDER BY secname ASC";
	$result = mysql_db_query(DB_MASTER,$sql) ;
	while($rs = mysql_fetch_assoc($result)){	
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		$arr1 = CountPersonPdf($rs[secid]);
		$DisCount = $arr1[NumPerson]-$arr1[NumPdf];
		$numxref = $arrXref[$rs[secid]];
?>
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="4%" height="24" align="center"><?=$j?></td>
    <td width="18%"><?=str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname])?>&nbsp;[<?=$rs[secid]?>]</td>
    <td width="6%" align="center"><a href="?action=getdata&type=pdf&xsecid=<?=$rs[secid]?>">upload</a></td>
    <td width="10%" align="center"><? if($arr1[NumPageFail] > 0){ echo "<a href='?action=view_page_fail&sentsecid=$rs[secid]&amount=$arr1[NumPageFail]' target='_blank'>".number_format($arr1[NumPageFail])."</a>";}else{ echo "0";}?></td>
    <td width="16%" align="center"><? if($arr1[NumPerson] > 0){ echo "<a href='?action=view_all&sentsecid=$rs[secid]&amount=$arr1[NumPerson]' target='_blank'>".number_format($arr1[NumPerson])."</a>";}else{ echo "0";}?></td>
    <td width="11%" align="center"><? if($arr1[NumPdf] > 0){ echo "<a href='?action=view_in&sentsecid=$rs[secid]&amount=$arr1[NumPdf]' target='_blank'>".number_format($arr1[NumPdf])."</a>";}else{ echo "0";}?></td>
    <td width="11%" align="center"><? if($DisCount > 0){ echo "<a href='?action=view_discount&sentsecid=$rs[secid]&amount=$DisCount' target='_blank'>".number_format($DisCount)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><? if($numxref > 0){ echo "<a href='?action=view_error&xsiteid=$rs[secid]' target='_blank'>$numxref</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><a href="?action=copyfile&xsecid=<?=$rs[secid]?>">�Ѵ�͡���</a></td>
    <td width="6%" align="center"><a href="report_log_upload.php?action=&xsiteid=<?=$rs[secid]?>"><img src="../../images_sys/button_select.png" width="14" height="13" / border="0" title="�ʴ������� log ���� upload ��� pdf"></a></td>
    </tr>
   <? 
  $sum_all_pagefail += $arr1[NumPageFail];
  $sum_all_numperson += $arr1[NumPerson];
  $sum_all_numpdf += $arr1[NumPdf];
  $sum_all_discount += $DisCount;
  $sum_all_xref += $numxref;
  
 $j++ ;
 }  // end while
  ?> 
  <tr>
    <td height="24" colspan="3" align="right" bgcolor="#FFFFFF"><strong>��� : </strong></td>
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
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($sum_all_xref)?></strong></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>
</td></tr></table>
<? } // end if(){
#################  �ӡ�äѴ�͡��� �ҡ checklist ������к� cmss ���������͡���㹡�úѹ�֡������
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
		if(is_file($file_source)){ // �ӡ��ź�����·ҧ��͹�ӡ�ù����价Ѻ
			//	@unlink($file_dest);
		}
		
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
	echo "<script>alert('�Ѵ�͡�����  $j  ��¡���������ö�Ѵ�͡�� $k ��¡��'); location.href='?action=';</script>";	
}//end if($action == "copyfile"){
#################  end  �Ѵ�͡���
if($action == "getdata"){
	####  sript log pdf
	if($type == "pdf"){
	$file_pdf = ReadFileFolder();
	$count = 1;
	
//echo "<pre>";
//print_r($file_pdf);
//die;
//	
### log pdf main ��͹�ӡ���� ��������´
	if(count($file_pdf) > 1){
		$lastlog_id = SaveLogUploadPdf($xsecid);
		$xsfile = 1;
	}else{
		$xsfile = 0;
	}//end if(count($file_pdf) > 0){


	$path_n = "../../../checklist_kp7file/$xsecid/";
	if(!is_dir($path_n)){
		xRmkdir($path_n);
	}
	$path_old = "../../../checklist_kp7file/fileall/";
	$path_filekp7 = "../../../".PATH_KP7_FILE."/$xsecid/";
	$pdf = ".pdf";
	//echo "�ӹǹ������".count($file_pdf)."<br>";
		if(count($file_pdf) > 0){
			DelDataXrefPdf($xsecid); // ź������ log xref error ��͹�ӡ���红������ա����
		$j=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v' AND siteid='$xsecid'";
				//echo $sql_c."<br>";
				
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$num_check =  @mysql_num_rows($result_c);
				$rs_c = mysql_fetch_assoc($result_c);
					if($num_check > 0){// �ó��բ������ࢵ�����ҹ��

						$file_source =$path_old.$v.$pdf;
						$file_dest = $path_n.$v.$pdf;
						$xEncrytp = CheckFileEncrypt($file_source); // ��Ǩ�ͺ������ջѭ�ҡ���������
						$xPdfError = CheckFileError($file_source); // ��Ǩ�ͺ����ջѭ�� error ������
						
						
							//echo "<a href='$file_source' target='_blank'>$file_source [$xsecid]</a><br>";
							//@copy($file_source,$file_dest);
							###  �� log ���ҡ�� upload ��� 
						if((CheckXrefPdf($rs_c[idcard],$rs_c[siteid]) == "ok") and $xEncrytp == "ok" and $xPdfError == "ok"){ // ��Ǩ�ͺ�� xref
							### �� log
							CopyFilePdfBackup($lastlog_id,$rs_c[idcard],$rs_c[siteid]); // �ӡ�� backup file �����͹��� copy ���价Ѻ
							SaveLogUploadPdfDetail($lastlog_id,$rs_c[idcard],$rs_c[siteid],"1");// �ӡ���� logfile
							### end �� log
							@copy($file_source,$file_dest);
							//    echo $count." Upload  ".$file_source." <font color='#cc0000'>---></font>  ".$file_dest."   <b><font color='#006600'>�����</font></b>"."<br><br>";
						
							
							### end �� log ��� upload ���
							//echo $file_dest."<br>";
							if(is_file($file_dest)){
								$kp7file_dest = $path_filekp7.$v.$pdf;
								
								
								@chmod("$file_dest",0777);	
								@copy($file_dest,$kp7file_dest);
								@chmod("$kp7file_dest",0777);	
								$temp_page = XCountPagePdf($file_dest);
								if($temp_page < 1){ 
									$temp_page = $rs_c[page_num];
								}else{ 
									$temp_page = $temp_page;
								} // �óչѺ�����������˹��繤���٧�ش���ͨѴ�������������
								###  ��Ǩ�ͺ���ͤѴ�͡��� �ҡ checklist ����� kp7file
								
								if(is_file($kp7file_dest)){
										$page_dest = XCountPagePdf($kp7file_dest);
												if($temp_page >= $page_dest){
													$status_file = 1;
												}else{
													$status_file = 0;	
												}//end 	if($temp_page >= $page_dest){		
								}else{ ## �óշ��������������������Ѵ�͡�������
										@copy($file_dest,$kp7file_dest);// �ӡ�äѴ�͡����������� kp7 file	
										$status_file = 1;
								}//end if(is_file($kp7file_dest)){
								## end ###  ��Ǩ�ͺ���ͤѴ�͡��� �ҡ checklist ����� kp7file
								
																
								$temp_date = date("Y-m-d", filectime($file_source));
								$sql_cf = "SELECT COUNT(idcard) as numid FROM log_pdf WHERE idcard='$v'";
								$result_cf = mysql_db_query($dbnamemaster,$sql_cf);
								$rs_cf = mysql_fetch_assoc($result_cf);
								if($rs_cf[numid] > 0){
										$sql_re = "UPDATE log_pdf SET  date_m='$temp_date', status_file='$status_file'  WHERE idcard='$rs_c[idcard]'";
										
								}else{
										$sql_re = "REPLACE INTO log_pdf(idcard,secid,date_c,date_m,status_file)VALUES('$rs_c[idcard]','$rs_c[siteid]','$temp_date','$temp_date','$status_file')";	
								}//end if($rs_cf[numid] > 0){
								//echo $sql_re;
								mysql_db_query($dbnamemaster,$sql_re)or die(mysql_error());
		
								
								
								
								$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
								//echo "$sql_update<br>";
								mysql_db_query($dbname_temp,$sql_update);
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
								//@unlink($file_source);
							}else{
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
							}
							
						$j++;
					}else{
							CopyFilePdfBackup($lastlog_id,$rs_c[idcard],$rs_c[siteid]); // �ӡ�� backup file �����͹��� copy ���价Ѻ
							if($xEncrytp == "error"){
									SaveLogUploadPdfDetail($lastlog_id,$rs_c[idcard],$rs_c[siteid],"2");// �ӡ���� logfile	����ջѭ��������ʡ�͹�Ӣ����Ţ���
							}else if($xPdfError == "error"){
									SaveLogUploadPdfDetail($lastlog_id,$rs_c[idcard],$rs_c[siteid],"3");// �ӡ���� logfile	 ����ջѭ�� ��ͧ repare
							}else{
									SaveLogUploadPdfDetail($lastlog_id,$rs_c[idcard],$rs_c[siteid],"0");// �ӡ���� logfile	// ����ջѭ�� �� xref �����
							}
							
							//@unlink($file_source); // �ӡ��ź�����ջѭ���͡�ҡ fileall
					}//end if(CheckXrefPdf($rs_c[idcard],$rs_c[siteid]) == "ok"){ // ��Ǩ�ͺ�� xref
					
						$count = $count+1;
					}//end	if($num_check > 0){// �ó��բ������ࢵ�����ҹ��
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
		##// ��Ǩ�ͺ�ó��� xref �������Ҥ������ż�

		//echo "<h3><a href='script_manage_filepdf.php'>��Ѻ˹����ѡ</a></h3>";
		
		//echo "script �� log �ѹ�֡���������º��������  $j  ��¡��";
	if($xsfile == 1){
		echo "<script>alert('�����żŢ��������º�������Ǩӹǹ  $j  ����к����ʴ� log ������㹡�� upload'); location.href='report_log_upload.php?action=&upload_id=$lastlog_id&xsiteid=$xsecid';</script>";
	}else{
		echo "<script>alert('��辺��������� PDF �������'); location.href='?action=';</script>";
	}
}// end if($type == "pdf"){
	#### end sript log pdf
#####  �����żŷ�����
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
//														###  �� log ���ҡ�� upload ���
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
//							### end �� log ��� upload ���
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
//								} // �óչѺ�����������˹��繤���٧�ش���ͨѴ�������������
//								//$temp_page = XCount_Page($file_dest);
//								$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
//								mysql_db_query($dbname_temp,$sql_update);
//								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
//								//echo $temp_page."<br>";
//								// �ҡ��鹷ӡ��ź���鹩�Ѻ
//								@unlink($file_source);
//							}else{
//								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
//							}//end if(is_file($file_dest)){ 
//				}//end if($rs_c[idcard] != ""){
//			}//end foreach($file_pdf as $k => $v){
//		}//end if(count($file_pdf) > 0){	
//		
/*	echo "<script>alert('script �� log �ѹ�֡���������º��������  $i ��¡��'); location.href='script_manage_filepdf.php?action=';</script>";*/
//	}//end if($type == "pdfall"){
}// if($action == "getdata"){
################  �ʴ���������´�ӹǹ�ؤ�ҡ�
if($action == "view_all" or $action == "view_in" or $action == "view_discount" or $action == "view_page_fail"){
	if($action == "view_all"){
			$xtitle = "��§ҹ�ӹǹ�ؤ�ҡ÷����� ".show_area($sentsecid);
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' ORDER BY id ASC";
	}else if($action == "view_in"){
			$xtitle = "��§ҹ�ӹǹ�ؤ�ҡ÷������� pdf ���� ".show_area($sentsecid);	
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num  FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND page_upload > 0 AND page_upload IS NOT NULL ORDER BY id ASC";
	}else if($action == "view_discount"){
			$xtitle = "��§ҹ�ӹǹ�ؤ�ҡ÷���ѧ�������� pdf ".show_area($sentsecid);		
			$sql = "SELECT CAST(schoolid as SIGNED) as id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,page_upload,page_num FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (page_upload = 0 OR page_upload IS NULL) ORDER BY id ASC";
	}else if($action == "view_page_fail"){
			$xtitle = "��§ҹ�ӹǹ�ؤ�ҡ÷��š�ùѺ�ӹǹ˹���͡��áѺ�ҡ��÷���к��Ѻ���ç�ѹ ".show_area($sentsecid);		
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
        <td colspan="<?=$col?>" align="left" bgcolor="#a3b2cc"><strong><?=$xtitle?>&nbsp;&nbsp;�ӹǹ��¡�÷����� <?=$numrow?> ��¡��</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>��<br />
          �Ѻ</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>���ʺѵû�ЪҪ�</strong></td>
        <td width="14%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>���� - ���ʡ��</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>���˹�</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>�ѧ�Ѵ</strong></td>
        <td colspan="2" align="center" bgcolor="#a3b2cc"><strong>�ӹǹ��(��)</strong></td>
        <? if($action == "view_page_fail"){?>
        <td width="25%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>����Ǩ</strong></td>
        <? }//end if($action == "view_page_fail"){ ?>
        <td width="3%" rowspan="2" align="center" bgcolor="#a3b2cc"><strong>���</strong></td>
      </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#a3b2cc"><strong>���Ѻ</strong></td>
        <td width="10%" align="center" bgcolor="#a3b2cc"><strong>�к��Ѻ</strong></td>
        </tr>
        <?
        if($numrow < 0){
			echo "<tr> <td colspan='6' align='center'> - ��辺��¡�� - </td></tr>";
		}else{
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../checklist_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'></a>";
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
                <td width="52%" align="center" bgcolor="#CAD5FF"><strong>���ͤ���Ǩ</strong></td>
                <td width="48%" align="center" bgcolor="#CAD5FF"><strong>���ҵ�Ǩ</strong></td>
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
tbl_check_xref_pdf.siteid =  '$xsiteid'
";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#a3b2cc"><strong>��� pdf ����ջѭ�� xref <?=show_area($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#a3b2cc"><strong>�ӴѺ</strong></td>
        <td width="20%" align="center" bgcolor="#a3b2cc"><strong>���ʺѵû�ЪҪ�</strong></td>
        <td width="24%" align="center" bgcolor="#a3b2cc"><strong>���� - ���ʡ��</strong></td>
        <td width="22%" align="center" bgcolor="#a3b2cc"><strong>���˹�</strong></td>
        <td width="23%" align="center" bgcolor="#a3b2cc"><strong>�ѧ�Ѵ</strong></td>
        <td width="7%" align="center" bgcolor="#a3b2cc"><strong>���</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../checklist_kp7file/fileall/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ�ջѭ�� xref' width='16' height='16' border='0'></a>";
				}else{
					$img_pdf = "";
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
