<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
//include "epm.inc.php";
include("../../config/conndb_nonsession.inc.php");
## function นับจำนวน เอกสาร ก.พ.7 #################   credit  by พี่น้อย #################################3
function count_page($idcard,$siteid) {

		$file = "../../../edubkk_kp7file/$siteid/$idcard.pdf";
		//echo $file ;
        if(file_exists($file)) { 

            //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
                    } 
                    else { 
                          $contents = fread($handle, 1000); 
                        //In some pdf files, there is an N tag containing the number of 
                        //of pages. This doesn't seem to be a result of the PDF version. 
                        //Saves reading the whole file. 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
                            return $found[1]; 
                        } 
                    } 
                    $i++; 
                } 
                fclose($handle); 
  
                //get all the trees with 'pages' and 'count'. the biggest number 
                //is the total number of pages, if we couldn't find the /N switch above.                 
                if(preg_match_all("/\/Type\s*\/Pages\s*.*\s*\/Count\s+([0-9]+)/", $contents, $capture, PREG_SET_ORDER)) { 
                    foreach($capture as $c) { 
                        if($c[1] > $count) 
                            $count = $c[1]; 
                    } 
                    return $count;             
                } 
            } 
        } 
        return 0; 
}

###  end function  นับจำนวนหน้า



?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date_true.value == ""){
		alert("กรุณาระบุวันส่งคือเอกสาร");
		document.form1.sent_date_true.focus();
		return false;
	}
	}
	
	
	
	var checkflag = "false";
function check(field) {
	if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
			field[i].checked = true;
		}
		checkflag = "true";
		return "ไม่เลือกทั้งหมด"; 
	} else {
		for (i = 0; i < field.length; i++) {
			field[i].checked = false; 
		}
		checkflag = "false";
		return "เลือกทั้งหมด"; 
	}

}

function checkAll(field,x) {
	for (i = 0; i < field.length; i++) {
		field[i].checked = x;
	}
}


</script>
</head>

<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="61%" align="center" bgcolor="#A5B2CE"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="31%" align="center" bgcolor="#A5B2CE"><strong>ตรวจสอบ</strong></td>
      </tr>
	  <?
	  	$sql_area = "SELECT * FROM eduarea WHERE  secid IN('5001','5002','5003','5004','5005','5006')";
		//echo $sql_area."                      $dbnameaster";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$i=0;
		while($rs_a = mysql_fetch_assoc($result_area)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs_a[secname]?></td>
        <td align="center"><a href="?action=show&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"> ตรวจสอบ</a></td>
      </tr>
	  <?
	  	}// end while(){
	  ?>
    </table></td>
  </tr>
</table>
<? } //end  if($action == ""){
	if($action == "show"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>สคริปตรวจสอบจำนวนหน้าของ ก.พ. 7 ต้นฉบับ <?=$secname?> </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="38%" align="center" bgcolor="#A5B2CE"><strong>รหัสบัตร ชื่อนามสกุล </strong></td>
        <td width="33%" align="center" bgcolor="#A5B2CE"><strong>อายุราชการ</strong></td>
        <td width="25%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
	  <?
	  $cyy = date("Y")+543;
	  $db_site = STR_PREFIX_DB.$secid;
	  	$sql_general = "SELECT id,siteid,prename_th,name_th,surname_th, position_now, schoolid, TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  FROM general ORDER BY age_gov  ASC";
		$result_general = mysql_db_query($db_site,$sql_general);
		$j=0;
		while($rs_g = mysql_fetch_assoc($result_general)){
		 if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
			$path_img = "../../../edubkk_kp7file/$rs_g[siteid]/$rs_g[id]".".pdf";
			
			
			$num_p = count_page($rs_g[id],$rs_g[siteid]);
			if(file_exists($path_img)){
			
			$xget_img = filesize($path_img);
			$xpdf_size = floor($xget_img/1024);
	
			if($num_p == "1"){ $num_p = 3;}else if($num_p == "0"){ $num_p = 1;}else{ $num_p = $num_p;}
				$link_file = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
			}else{
				$num_p = 0;
				$link_file = "";
			}
			$idcard[$rs_g[id]] = "$rs_g[id]";
			$fullname[$rs_g[id]] = "$rs_g[prename_th]$rs_g[name_th] $rs_g[surname_th]";
			$age[$rs_g[id]] =  floor($rs_g[age_gov]);
			$num_page[$rs_g[id]] = $num_p;
			$pdf_org[$rs_g[id]] = $link_file;
			$arr_site[$rs_g[id]] = $rs_g[siteid];
			$ximg_size[$rs_g[id]] = $xpdf_size;
			
}// end while(){
	//asort($num_page);
	$j=0;
	foreach($idcard  as $key => $val){
		if(($ximg_size[$key] < 170) and ($num_page[$key] <= 1)){ // กรณีขนาดไฟล์น้อยกว่า 150 k อนุมาณว่ามีแค่หน้าเดียว
	 if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
		//if($num_page[$key] < 3 and $num_page[$key] != 0){
//			$bg1 = "#FFCC00";
//		}else if($num_page[$key] == 0){
//			$bg1 = "#FF6600";
//		}else{
//			$bg1 = $bg1;
//		}
	  ?>
      <tr bgcolor="<?=$bg1?>">
        <td align="center"><?=$j?></td>
        <td align="left"><? echo "[$val]  $fullname[$key]";  ?></td>
        <td align="center"><? echo $age[$key];?></td>
        <td align="center"><? /* if($num_page[$key] == 0){ echo "<font color='red'>ไม่มีก.พ. 7 ต้นฉบับ</font>";}else{ echo $num_page[$key];}  */ echo "&nbsp;&nbsp;$pdf_org[$key]";?><? //echo "&nbsp;&nbsp;".count_page($val,$arr_site[$key]);?></td>
      </tr>
	  <?
	  	}// end if($ximg_size[$key] < 150){
	}// end 	foreach(){

	  ?>
    </table></td>
  </tr>
</table>
<?
	} //end if($aciton == "show"){
?>
</BODY>
</HTML>
