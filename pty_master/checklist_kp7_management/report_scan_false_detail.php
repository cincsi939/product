<?
session_start();
include("checklist2.inc.php");
include("../../common/common_competency.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<?
	
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<? if($lv == ""){?>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>

 <tr>
   <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
     <tr>
       <td colspan="3" align="left" bgcolor="#A8B9FF"><strong>ข้อมูลจำนวนบุคลากรที่เอกสารมีปัญหาแยกรายเขตพื้นที่การศึกษา</strong></td>
       </tr>
     <tr>
       <td width="6%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
       <td width="61%" align="center" bgcolor="#A8B9FF"><strong>เขตพื้นที่การศึกษา</strong></td>
       <td width="33%" align="center" bgcolor="#A8B9FF"><strong>จำนวนรายการ(คน)</strong></td>
     </tr>
     <?
     $sql_edu = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata'  and eduarea_config.profile_id='$profile_id'
ORDER BY  secname";
	 $result_edu = mysql_db_query($dbnamemaster,$sql_edu);
	 $i=0;
	 while($rs_e = mysql_fetch_assoc($result_edu)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	 $arr1 = show_val_exsum("1",$rs_e[secid],"",$profile_id);
	 	if($xtype == "wait"){
			$val = $arr1['numN'];
		}else{
			$val = $arr1['numY1'];
		}
	 ?>
     <tr bgcolor="<?=$bg?>">
       <td align="center"><?=$i?></td>
       <td align="left"><?=$rs_e[secname]?></td>
       <td align="center"><? if($val > 0){ echo "<a href='?lv=1&sentsecid=$rs_e[secid]&xtype=$xtype&profile_id=$profile_id' target='_blank'>".number_format($val)."";}else{ echo "0";}?></td>
     </tr>
    <?
		$arr1 = "";
	 }//end  while(){
	?>
   </table></td>
 </tr>
 <? } //end if($lv == ""){
	 
	if($lv == "1"){	 	  
	
	if($xtype == "all"){ $xtitle = "รายชื่อบุคลากรอัตราจริงรวม";}else if($xtype == "ql"){ $xtitle = "รายชื่อบุคลากรที่รับเอกสาร";}else if($xtype == "numt"){ $xtitle = "รายชื่อบุคลากรที่ตรวจสอบเอกสารสมบูรณ์";}else if($xtype == "numf"){ $xtitle = "รายชื่อบุคลากรที่เอกสารไม่สมบูรณ์";}else if($xtype == "numfup"){ $xtitle = "รายชื่อบุคลากรที่เอกสารไม่สมบูรณ์และuploadแล้ว";}else if($xtype == "numfdis"){$xtitle = "รายชื่อบุคลากรที่เอกสารไม่สมบูรณ์ที่ค้าง upload ";}else if($xtype == "numnm"){$xtitle = "รายชื่อบุคลากรที่ขาดปกเอกสาร";}else if($xtype == "numnmup"){$xtitle = "รายชื่อบุคลากรที่ขาดปกเอกสารที่ upload แล้ว";}else if($xtype == "nummdis"){$xtitle = "รายชื่อบุคลากรที่ขาดปกเอกสารที่ค้าง upload ";}else if($xtype == "numidf"){$xtitle = "รายชื่อบุคลากรที่ืเลขบัตรไม่สมบูรณ์";}else if($xtype == "numidfup"){$xtitle = "รายชื่อบุคลากรที่ืเลขบัตรไม่สมบูรณ์ที่ upload แล้ว";}else if($xtype == "numidfdis"){$xtitle = "รายชื่อบุคลากรที่ืเลขบัตรไม่สมบูรณ์ที่ค้าง upload";}else{ $xtitle = "รายชื่อบุคลากรอัตราจริงรวม";}
	
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" bgcolor="#A8B9FF"><strong> <?=$xtitle."".show_area($sentsecid);?></strong>
		
		<? if($schoolid != ""){ 
		$xsc =get_school($schoolid,$sentsecid);
		echo $xsc['schoolname'];
		}//end if($schoolid != ""){
		?> 
		</td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>คำนำ<br>
          หน้าชื่อ</strong></td>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="19%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="20%" align="center" bgcolor="#A8B9FF"><strong>ประวัติการ upload</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>ไฟล์ ก.พ.7</strong></td>
      </tr>
      <?
	if($schoolid != ""){
		  $conS = " AND schoolid='$schoolid'";
	}else{
		$conS = "";	
	}
	
	
	
	if($xtype == "all"){
		$conW = " WHERE  siteid='$sentsecid' ";	
	}else if($xtype == "ql"){
		$conW = " WHERE status_numfile='1' AND siteid='$sentsecid' ";
	}else if($xtype == "numt"){
		$conW = " WHERE status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' AND siteid='$sentsecid'";
	}else if($xtype == "numf"){
		$conW = 	" WHERE status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' AND siteid='$sentsecid' ";
	}else if($xtype == "numfup"){
		$conW = " WHERE status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' and flag_uploadfalse='1' AND  siteid='$sentsecid'";
	}else if($xtype == "numfdis"){
		$conW = " WHERE status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' and flag_uploadfalse='0' AND  siteid='$sentsecid'";
	}else if($xtype == "numnm"){
			$conW = " WHERE status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' AND  siteid='$sentsecid'";
	}else if($xtype == "numnmup"){
		$conW = " WHERE status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and flag_uploadfalse='1' AND  siteid='$sentsecid'";
		
	}else if($xtype == "nummdis"){
		$conW = " WHERE status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and flag_uploadfalse='0' AND  siteid='$sentsecid'";
	}else if($xtype == "numidf"){
		$conW = " WHERE status_id_false='1' and status_numfile='1' AND  siteid='$sentsecid'";
	}else if($xtype == "numidfup"){
		$conW = " WHERE status_id_false='1' and status_numfile='1' and flag_uploadfalse='1' AND  siteid='$sentsecid'";
	}else if($xtype == "numidfdis"){
		$conW = " WHERE status_id_false='1' and status_numfile='1' and flag_uploadfalse='0' AND  siteid='$sentsecid'";
	}else{
		$conW = 	" WHERE siteid='$sentsecid' ";
	}
	
	  $con1 = " AND profile_id='$profile_id'";
      $sql = "SELECT * FROM tbl_checklist_kp7  $conW $conS $con1";
	  //echo $sql;
	  $result = mysql_db_query($dbtemp_check,$sql);
	  $i=0;
	  while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$kp7file = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard].pdf";
		if(is_file($kp7file)){
				$kp7img = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" border=\"0\" title=\"คลิ๊กเพื่อดูเอกสาร ก.พ.7 ต้นฉบับ\"></a>";
		}else{
				$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
				$kp7img = $arrkp7['linkfile'];	
				//$kp7img = "";	
		}
		
		
	####  ประวัติการ up ไฟล์ กรณีของกลุ่มเอกสารไม่สมบูรณ์
	 $sql_upfile = "SELECT * FROM tbl_checklist_log_uploadfile WHERE profile_id='$profile_id' AND idcard='$rs[idcard]' ORDER BY date_upload DESC";
	 //echo "$dbname_temp :: $sql_upfile";
	$result_upfile = mysql_db_query($dbtemp_check,$sql_upfile);
	$num_upfile = @mysql_num_rows($result_upfile);
	   

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]";?></td>
        <td align="left"><? echo "$rs[name_th]";?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?><? echo "(".FindOldArea($rs[schoolid]).")";?></td>
        <td align="center"><? if($num_upfile < 1){ echo "<em>-ยังไม่ได้ upload ไฟล์-</em>"; }else{?><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                   <tr>
                     <td width="74%" align="center" bgcolor="#E2E2E2"><strong>วันที่ upload</strong></td>
                     <td width="26%" align="center" bgcolor="#E2E2E2"><strong>ไฟล์</strong></td>
                   </tr>
                   <?
						$xj=0;
						while($rs_upfile = mysql_fetch_assoc($result_upfile)){
						if ($xj++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
			 		?>
                   <tr bgcolor="<?=$bg1?>">
                     <td align="center"><?=thai_dateS($rs_upfile[date_upload]);?></td>
                     <td align="center"><? echo "<a href='$rs_upfile[kp7file]' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> ";?></td>
                   </tr>
                   <?
						}//end 
			 		?>
                 </table></td>
          </tr>
        </table><? }//end if($num_upfile < 1){ ?></td>
        <td align="center"><?=$kp7img?></td>
      </tr>
     <?
     	}//end   while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table></td>
  </tr>
 <? } //end ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
