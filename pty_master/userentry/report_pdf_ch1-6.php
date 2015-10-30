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







function count_data_area($xsecid){
$db_site = STR_PREFIX_DB.$xsecid;
		$sql = "SELECT COUNT(id) AS num1 FROM general ";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}



function read_file_folder($xsecid){
		$Dir_Part="../../../edubkk_kp7file/$xsecid/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}// end if(($File_Name!= ".") && ($File_Name!= "..")){
		}// end while($File_Name=readdir($Dir)){
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){


function count_file_in($xsecid){
$db_site = STR_PREFIX_DB.$xsecid;
$arr_file = read_file_folder($xsecid);
	if(count($arr_file) > 0){
	$n=0;
		foreach($arr_file as $key => $val){
			$sql_check_general = "SELECT COUNT(id) as num1 FROM general WHERE id='$val'";
			$result_check_general = mysql_db_query($db_site,$sql_check_general);
			$rs_ch = mysql_fetch_assoc($result_check_general);
				if($rs_ch[num1] > 0){
						$n++;
				}//end if($rs_ch[num1] > 0){
		}//end foreach($arr_file as $key => $val){
	}//end if(count(read_file_folder($xsecid)) > 0){
	return $n;
	
}//end function count_file_in(){


function count_file_fail($xsecid){
		$db_site = STR_PREFIX_DB.$xsecid;
		$sql_data = "SELECT * FROM general  ORDER BY  idcard ASC";
		$result_data = mysql_db_query($db_site,$sql_data);
		$count_file = 0;
		while($rs_d = mysql_fetch_assoc($result_data)){
			$path_file = "../../../edubkk_kp7file/$xsecid/$rs_d[id].pdf";
			
			if(file_exists($path_file)){
			$num_file = count_page($rs_d[id],$xsecid);
			$xget_img = filesize($path_file);
			$xpdf_size = floor($xget_img/1024);
			if($num_file == "1"){ $num_file = 3;}else if($num_file == "0"){ $num_file = 1;}else{ $num_file = $num_file;}
			if($xpdf_size < 170 and $num_file <= 1){
					$count_file++;
			}
			}//end 	if(file_exists($path_img)){
		}//end while($rs_d = mysql_fetch_assoc($result_data)){
		return $count_file;
}// end function count_file_fail($secid){

function search_school1($schoolid){
	global	$dbnamemaster;
	$sql1 = "SELECT office FROM allschool WHERE id='$schoolid'";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[office];
}
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center" valign="top" bgcolor="#A3B2CC"><strong>หน้ารายงานตรวจสอบการ upfile ขึ้นสู่ระบบ </strong></td>
        </tr>
    </table></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
            <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากรที่มีในะรบบ (คน) </strong></td>
            <td width="16%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ไฟล์ไม่สมบูรณ</strong>์</td>
          </tr>
          <tr>
            <td width="3%" align="center" bgcolor="#A3B2CC"><strong>ที่</strong></td>
            <td width="33%" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่การศึกษา</strong></td>
            <td width="16%" align="center" bgcolor="#A3B2CC"><strong>บุคลากรทั้งหมด</strong></td>
            <td width="17%" align="center" bgcolor="#A3B2CC"><strong>มีไฟล์ก.พ.7</strong></td>
            <td width="15%" align="center" bgcolor="#A3B2CC"><strong>ไม่มีไฟล์ ก.พ.7 </strong></td>
            </tr>
          
			<?
				$sql_area = "SELECT * FROM config_area  WHERE secid IN('5001','5002','5003','5004','5005','5006') ORDER BY secname ASC ";
				$result_area = mysql_db_query($db_name,$sql_area);
				$j=0;
				while($rs_a = mysql_fetch_assoc($result_area)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  	$num_all = count_data_area($rs_a[secid]); // จำนวนบุคลากรทั้งหมด
				 	//$num_file = count(read_file_folder($rs_a[secid]))-1;
					$num_file = count_file_in($rs_a[secid]);
					$num_dif = $num_all-$num_file;
					$num_file_fail = count_file_fail($rs_a[secid]);

			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$j?></td>
            <td align="left"><a href="?action=view&type=1&xsecid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname])?></a></td>
            <td align="right"><a href="?action=view&type=1&xsecid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"><?=number_format($num_all);?></a></td>
            <td align="right"><? if($num_file > 0){ echo "<a href='?action=view&type=2&xsecid=$rs_a[secid]&secname=$rs_a[secname]' target='_blank'>".number_format($num_file)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if($num_dif > 0){ echo "<a href='?action=view&type=3&xsecid=$rs_a[secid]&secname=$rs_a[secname]' target='_blank'>".number_format($num_dif)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if($num_file_fail > 0){ echo "<a href='?action=view&type=4&xsecid=$rs_a[secid]&secname=$rs_a[secname]' target='_blank'>".number_format($num_file_fail)."</a>";}else{ echo "0";}?></td>
          </tr>
		  <?
		  $sum_all += $num_all;
			$sum_file += $num_file;
			$sum_dif += $num_dif;
			$sum_file_fail += $num_file_fail;
		  	}// end while(){
		  ?>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>รวม </strong></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_all);?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_file)?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_dif);?></td>
            <td align="right" bgcolor="#E2E2E2"><?=number_format($sum_file_fail);?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
		}//end if($action == ""){
	if($action == "view"){
			  		$num_all = count_data_area($xsecid); // จำนวนบุคลากรทั้งหมด
				 //	$num_file = count(read_file_folder($xsecid))-1;
					$num_file = count_file_in($xsecid);
					$num_dif = $num_all-$num_file;
					$num_file_fail = count_file_fail($xsecid);

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><strong><?=$secname?></strong></td>
        </tr>
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><strong>จำนวนรวมบุคลากรทั้งหมด : </strong></td>
          <td width="15%" align="right"><a href="?action=view&type=1&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=จำนวนรวมบุคลากรทั้งหมด">
		  <?=$num_all?></a></td>
          <td width="20%"><strong>คน</strong></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่มีไฟล์ในระบบ : </strong></td>
          <td align="right"><? if($num_file > 0){ ?> <a href="?action=view&type=2&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=จำนวนบุคลากรที่มีไฟล์ในระบบ"><?=$num_file?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ไม่มีไฟล์ในระบบ : </strong></td>
          <td align="right"><? if($num_dif > 0){?><a href="?action=view&type=3&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=จำนวนบุคลากรที่ไม่มีไฟล์ในระบบ"><?=$num_dif?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ไฟล์ไม่สมบูรณ : </strong> </td>
          <td align="right"><? if($num_file_fail > 0){ echo "<a href='?action=view&type=4&xsecid=$xsecid&secname=$secname&xtitle=จำนวนบุคลากรที่ไฟล์ไม่สมบูรณ'>".$num_file_fail."</a>";}else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="<?=$bg?>">
          <td colspan="5"><strong><?=$xtitle?></strong></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="30%" align="center" bgcolor="#A3B2CC"><strong>บัตรประจำตัวประชาชน</strong></td>
                  <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="21%" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
                  </tr>
                
				<?
		$db_site = STR_PREFIX_DB.$xsecid;
		if($type == "1"){
			$sql_view = "SELECT * FROM general";
			$result_view = mysql_db_query($db_site,$sql_view);
			while($rs_v = mysql_fetch_assoc($result_view)){
				$path_img = "../../../edubkk_kp7file/$rs_v[siteid]/$rs_v[id]".".pdf";
				if(file_exists($path_img)){
					$link_file = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
				}else{
					$link_file = "";
				}//end if(file_exists($path_img)){
				$arr_file[$rs_v[id]] = $link_file;
				$arr_name[$rs_v[id]] = "$rs_v[prename_th]$rs_v[name_th]  $rs_v[surname_th]";
				$arr_position[$rs_v[id]] = "$rs_v[position_now]";
				$arr_school[$rs_v[id]] = search_school1($rs_v[schoolid]);
			}
		}//end if($type == "1"){
	####################################
	if($type == "2"){
		if(count(read_file_folder($xsecid)) > 0){
			foreach(read_file_folder($xsecid) as $k1 => $v1){
				$sql_general = "SELECT * FROM general  WHERE id='$v1'";
				$result_general = mysql_db_query($db_site,$sql_general);
				$rs_v = mysql_fetch_assoc($result_general);
				if($rs_v[id] != ""){
				$path_img = "../../../edubkk_kp7file/$rs_v[siteid]/$rs_v[id]".".pdf";
					$link_file = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
				$arr_file[$rs_v[id]] = $link_file;
				$arr_name[$rs_v[id]] = "$rs_v[prename_th]$rs_v[name_th]  $rs_v[surname_th]";
				$arr_position[$rs_v[id]] = "$rs_v[position_now]";
				$arr_school[$rs_v[id]] = search_school1($rs_v[schoolid]);

				}//end 	if($rs_v[id] != ""){
			}//end foreach(){
		}//end 	if(count(read_file_folder($secid)) > 0){
	}	// end if($type == "2"){
##############  
if($type == "3"){
			$sql_view = "SELECT * FROM general";
			$result_view = mysql_db_query($db_site,$sql_view);
			while($rs_v = mysql_fetch_assoc($result_view)){
				$path_img = "../../../edubkk_kp7file/$rs_v[siteid]/$rs_v[id]".".pdf";
				if(!(file_exists($path_img))){
				$arr_file[$rs_v[id]] = "";
				$arr_name[$rs_v[id]] = "$rs_v[prename_th]$rs_v[name_th]  $rs_v[surname_th]";
				$arr_position[$rs_v[id]] = "$rs_v[position_now]";
				$arr_school[$rs_v[id]] = search_school1($rs_v[schoolid]);
				}//end if(file_exists($path_img)){
			}

}//end if($type == "3"){
#######################  นับจำนวนบุคลากรที่ไฟล์มีปัญหา
if($type == "4"){
		$sql_data = "SELECT * FROM general  ORDER BY  idcard ASC";
		$result_data = mysql_db_query($db_site,$sql_data);
		while($rs_d = mysql_fetch_assoc($result_data)){
			$path_file = "../../../edubkk_kp7file/$xsecid/$rs_d[id].pdf";
			
			if(file_exists($path_file)){
			$num_file = count_page($rs_d[id],$xsecid);
			$xget_img = filesize($path_file);
			$xpdf_size = floor($xget_img/1024);
			if($num_file == "1"){ $num_file = 3;}else if($num_file == "0"){ $num_file = 1;}else{ $num_file = $num_file;}
			if($xpdf_size < 170 and $num_file <= 1){
					
					$path_img = "../../../edubkk_kp7file/$rs_d[siteid]/$rs_d[id]".".pdf";
					$link_file = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
				$arr_file[$rs_d[id]] = $link_file;
				$arr_name[$rs_d[id]] = "$rs_d[prename_th]$rs_d[name_th]  $rs_d[surname_th]";
				$arr_position[$rs_d[id]] = "$rs_d[position_now]";
				$arr_school[$rs_d[id]] = search_school1($rs_d[schoolid]);
					
				}//end 		if($xpdf_size < 170 and $num_file <= 1){
			}//end 	if(file_exists($path_img)){
		}//end while($rs_d = mysql_fetch_assoc($result_data)){
}//end if($type == "4"){


if(count($arr_file) > 0){
$i=0;
	foreach($arr_file as $key => $val){
		 if ($i++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
		?>

				    <tr bgcolor="<?=$bg1?>">
                  <td align="center"><?=$i?></td>
                  <td align="left"><?=$key?>&nbsp;&nbsp;<?=$val?></td>
                  <td align="left"><? echo "$arr_name[$key]";?></td>
                  <td align="left"><?=$arr_position[$key]?></td>
                  <td align="left"><?=$arr_school[$key]?></td>
                  </tr>

				<?
		}//end 
}//end if(count($arr_file) > 0){
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
