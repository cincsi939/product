<?
set_time_limit(0);


include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");


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
### function �Ѻ�ӹǹ˹�� pdf by ������
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
function read_file_folder($get_site=""){
	if($get_site == ""){
		$Dir_Part="../../../checklist_kp7file/fileall/";	
	}else{
		$Dir_Part="../../../checklist_kp7file/$get_site/";	
	}
		
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///�Դ Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
	// edit_pic----------------------------------------------------------------------------------------
	
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
	###  ���ҧ �������
	function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	
function CountPagePdfFile($get_filepdf){
	$file_r = $get_filepdf;
	echo "<a href='$file_r' target='_blank'>$file_r</a>";


        $max=0; 
        while(!feof($fp)) { 
                $line = fgets($fp,255); 
                if (preg_match('/\/Count [0-9]+/', $line, $matches)){ 
                        preg_match('/[0-9]+/',$matches[0], $matches2); 
                        if ($max<$matches2[0]) $max=$matches2[0]; 
                } 
        } 
        fclose($fp); 
			$num_pagefile = $max;
	//echo 'There '.($max<2?'is ':'are ').$max.' page'.($max<2?'':'s').' in '. $_REQUEST['file'].'.'; 
return $num_pagefile;
}//end function CountPagePdfFile(){
	
//$filex = "3710900109066.pdf";
//echo XCount_Page($filex);
	
//echo CountPagePdfFile($filex);
	
	
//die;
?> 



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>����ͧ���㹡�èѴ������ pdf</title>
</head>
<body>
<? if($action == ""){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
<tr>
  <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">
  <tr>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>�ӴѺ</strong></td>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>ࢵ��鹷�����֡��</strong></td>
    <td rowspan="2" align="center" bgcolor="#CAD5FF">&nbsp;</td>
    <td rowspan="2" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ˹�ҷ���ʡ�<br />
      �Ѻ��ùѺ���<br />
      ���ç�ѹ(��)</strong></td>
    <td height="24" colspan="3" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ��¡��</strong></td>
  </tr>
  <tr>
    <td height="24" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ�ؤ�ҡ÷�����(��)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>�ӹǹ��� pdf <br />���ӹ�����к�(���)</strong></td>
    <td align="center" bgcolor="#CAD5FF"><strong>����ҧ���<br />
      �к�(���)</strong></td>
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
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="4%" height="24" align="center"><?=$j?></td>
    <td width="23%"><?=$rs[secname]?>&nbsp;[<?=$rs[secid]?>]</td>
    <td width="12%" align="center"><a href="?action=getdata&type=pdf&xsecid=<?=$rs[secid]?>">�����ż����ࢵ</a></td>
    <td width="14%" align="center"><? if($arr1[NumPageFail] > 0){ echo "<a href='?action=view_page_fail&sentsecid=$rs[secid]&amount=$arr1[NumPageFail]' target='_blank'>".number_format($arr1[NumPageFail])."</a>";}else{ echo "0";}?></td>
    <td width="15%" align="center"><? if($arr1[NumPerson] > 0){ echo "<a href='?action=view_all&sentsecid=$rs[secid]&amount=$arr1[NumPerson]' target='_blank'>".number_format($arr1[NumPerson])."</a>";}else{ echo "0";}?></td>
    <td width="11%" align="center"><? if($arr1[NumPdf] > 0){ echo "<a href='?action=view_in&sentsecid=$rs[secid]&amount=$arr1[NumPdf]' target='_blank'>".number_format($arr1[NumPdf])."</a>";}else{ echo "0";}?></td>
    <td width="12%" align="center"><? if($DisCount > 0){ echo "<a href='?action=view_discount&sentsecid=$rs[secid]&amount=$DisCount' target='_blank'>".number_format($DisCount)."</a>";}else{ echo "0";}?></td>
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
    </tr>
</table>
</td></tr></table>
<? } // end if(){
#################  �ӡ�äѴ�͡��� �ҡ checklist ������к� cmss ���������͡���㹡�úѹ�֡������
#################  end  �Ѵ�͡���
if($action == "getdata"){
	####  sript log pdf
	if($type == "pdf"){
	$file_pdf = read_file_folder($xsecid);
	$count = 1;
	
//echo "<pre>";
//print_r($file_pdf);
//die;
//	
//$fixidcard = "3710900109066";
	$path_n = "../../../checklist_kp7file/$xsecid/";
	if(!is_dir($path_n)){
		xRmkdir($path_n);
	}
	$path_old = "../../../checklist_kp7file/fileall/";
	$pdf = ".pdf";
	//echo "�ӹǹ������".count($file_pdf)."<br>";
	//die;
		if(count($file_pdf) > 0){
		$j=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v'";
				//echo $sql_c."<br>";
				//$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$fixidcard'";
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$num_check =  mysql_num_rows($result_c);
				$rs_c = mysql_fetch_assoc($result_c);
				if($rs_c[idcard] != ""){
					//$v = $rs_c[idcard];

						//$file_source =$path_old.$rs_c[idcard].$pdf;
						$file_dest = $path_n.$rs_c[idcard].$pdf;
						//echo "file :: ".CountPagePdfFile($file_dest)." :::  ";
						echo "<a href='$file_dest' target='_blank'>$file_dest [$xsecid]</a><br>";
							//@copy($file_source,$file_dest);
							###  �� log ���ҡ�� upload ���
//							if($file_dest){
//							    echo $count." Upload  ".$file_source." <font color='#cc0000'>---></font>  ".$file_dest."   <b><font color='#006600'>�����</font></b>"."<br><br>";
//								
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
//								//echo $sql_re;
//								mysql_db_query($dbnamemaster,$sql_re)or die(mysql_error());
//								
//							}//end if(is_file($file_source)){
							### end �� log ��� upload ���
							//echo $file_dest."<br>";
							if(is_file($file_dest)){
							   
								
								chmod("$file_dest",0777);
								
								

								##################################
								##  ��� ... ��� .... ���  ..... ��� ......... ���.....ERROR 
								##  ��ǧ��� 23 ����¹ 2553  ��¾�����Ѳ�� �͡ �Ǫ   ���   ����������ҡ���
								##  ����� ����ͧ ˹֧㹹��
								##
								##  ���ͧ�ҡ CountpageSystem �ӧҹ����� ���� ��ͧ� ���� ������
								##  �˵����� �ѹ ���� �Թ ������� �ҹ��� 
								##  �ѹ��� ��4 �֧�Դ��� ����� �к� �׹��� �͡���� 99 ����ѧ����к� �ӧҹ������
								##  �պ�ê� �ҡ  �س pairoj  ���ͽ���ԡĵ��觧ҹ  
								##  ��� ����¹�ŧ��ô֧��� �ҡ kp7 ����ҹ������� �к� �����觧ҹ�� 
								##  �� ��� �֧��� checklist �ҡ ���ࢵ ��� �ش� 2 �Ҿ��2 ˹ͧ��� 3
								##  ������������ �ҹ��� ���� �ʹ��ʹ��¡�͹ ��� ������ � �ش��� ���� ��� �ع���Ѳ�� ˹����Ѵ ��Ѻ��  ������Ѻʤ�Ի���
								##  $xsecid = 4802,4102,4303
								##################################
								/*$Site_array = array(4802,4102,4303);
								if( in_array( $xsecid , $Site_array )){
									$strSQL = " SELECT page_num FROM `tbl_checklist_kp7` WHERE `siteid` = '$xsecid' AND idcard = '$v'	";
									$Result_KP7num = @mysql_db_query($dbname_temp,$strSQL);
									$Row_KP7num = @mysql_fetch_assoc($Result_KP7num);
									$temp_page = $Row_KP7num['page_num'] ? $Row_KP7num['page_num'] : 0 ;
									echo $Turn_word = " �к��֧�ӹǹ˹��ҹ���Ҩҡ tbl_checklist_kp7.page_num �����鷴᷹��÷ӧҹ�ͧ�ѧ��� CountPageSystem �����ࢵ������¡����觴�ǹ (�ش� 2 , ��þ��2 , ˹ͧ��� 3) <br>";
								}*///$temp_page = $rs_c[page_num];
								##################################
															
								
								//$temp_page = CountPageSystem($file_dest);
								$temp_page = XCount_Page($file_dest);
								//echo "temp ".$temp_page;die;
								//XCount_Page
								//$temp_page = $rs_c[page_num];
								if($temp_page < 1){ 
									$temp_page = $rs_c[page_num];
								}else{ 
									$temp_page = $temp_page;
								} // �óչѺ�����������˹��繤���٧�ش���ͨѴ�������������
								
								//$sql_update = "UPDATE tbl_checklist_kp7 SET page_num='$rs_c[page_num]' ,page_upload='$temp_page',birthday='$rs_c[birthday]',begindate='$rs_c[begindate]',status_file='$rs_c[status_file]',pic_num='$rs_c[pic_num]',profile_id='$rs_c[profile_id]' WHERE idcard='$rs_c[idcard]' AND siteid='$xsecid'";
								$sql_update = "UPDATE tbl_checklist_kp7 SET page_num='$rs_c[page_num]' ,page_upload='$temp_page'  WHERE idcard='$rs_c[idcard]' AND siteid='$xsecid'";
								if($rs_c[page_num] != $temp_page){ 
									echo "<font color='red'>$sql_update</font><br>";
								}else{
									echo "$sql_update<br>";
								}
								
								mysql_db_query($dbname_temp,$sql_update);
								//AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
								//echo $temp_page."<br>";
								// �ҡ��鹷ӡ��ź���鹩�Ѻ
								//@unlink($file_source);
							}else{
							//	AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
							}
						$j++;
						
						$count = $count+1;
						/*if($count == 100){
						  exit();
						}*/
							
					}//endif($rs_c[idcard] != ""){ 
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
		
		echo "<h3><a href='script_manage_filepdf_site.php'>��Ѻ˹����ѡ</a></h3>";
		
		//echo "script �� log �ѹ�֡���������º��������  $j  ��¡��";
	/*echo "<script>alert('script �� log �ѹ�֡���������º��������  $j  ��¡��'); location.href='script_manage_filepdf.php?action=';</script>";*/
	}// end if($type == "pdf"){
	#### end sript log pdf
#####  �����żŷ�����
	if($type == "pdfall"){
/*		$file_pdf = read_file_folder();
		$path_n = "../../../checklist_kp7file/";
		$path_old = "../../../checklist_kp7file/fileall/";
		$pdf = ".pdf";	
		if(count($file_pdf) > 0){
			$i=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7_bk200553 WHERE idcard='$v' and siteid=''";
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
							//@copy($file_source,$file_dest);
							
							
														###  �� log ���ҡ�� upload ���
							if(is_file($file_dest)){
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



							}//end if(is_file($file_source)){
							### end �� log ��� upload ���

							
							
						if(is_file($file_dest)){ 
								chmod("$file_dest",0777);
								#$temp_page = CountPageSystem($file_dest);
								if($temp_page < 1){ 
									$temp_page = "99";
								//$temp_page = 99;
								}else{ 
									$temp_page = $temp_page;
								} // �óչѺ�����������˹��繤���٧�ش���ͨѴ�������������
								//$temp_page = XCount_Page($file_dest);
								$sql_update = "UPDATE tbl_checklist_kp7 SET pagepage_upload='$rs_c[page_upload]' WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]'";
								mysql_db_query($dbname_temp,$sql_update);
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Complete");
								//echo $temp_page."<br>";
								// �ҡ��鹷ӡ��ź���鹩�Ѻ
								@unlink($file_source);
							}else{
								AddLogPdf($rs_c[idcard],$rs_c[siteid],"Upload Uncomplete");
							}//end if(is_file($file_dest)){ 
				}//end if($rs_c[idcard] != ""){
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){	
		
		echo "<script>alert('script �� log �ѹ�֡���������º��������  $i ��¡��'); location.href='script_manage_filepdf.php?action=';</script>";
*/	}//end if($type == "pdfall"){
}// if($action == "getdata"){
################  �ʴ���������´�ӹǹ�ؤ�ҡ�

?>
</body>
</html>
