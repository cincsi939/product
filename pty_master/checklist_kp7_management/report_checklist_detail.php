<?
session_start();
include("checklist2.inc.php");

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
	if($xtype == "QL"){ $xtitle = "รายชื่อบุคลากรที่ได้รับเอกสาร";}else if($xtype == "norecive"){ $xtitle = "รายชื่อบุคลากรที่ค้างรับเอกสาร";}else if($xtype == "countn"){ $xtitle = "รายชื่อบุคลากรที่อยู่ระหว่างตรวจสอบ";}else if($xtype == "all"){ $xtitle = "รายชื่อบุคลากรทั้งหมด";}else if($xtype == "idfalse"){ $xtitle = "รายชื่อบุคลากรที่เลขบัตรไม่สมบูรณ";}else{ $xtitle = "รายชื่อบุคลากรทั้งหมด";}
	
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" bgcolor="#A8B9FF"><strong> <?=$xtitle."".show_area($sentsecid);?></strong>
		
		<? if($schoolid != ""){ 
		$xsc =get_school($schoolid,$sentsecid);
		echo $xsc['schoolname'];
		}//end if($schoolid != ""){
		?> 
		</td>
        </tr>
      <tr>
        <td width="2%" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="8%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="21%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="28%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="14%" align="center" bgcolor="#A8B9FF"><strong>ไฟล์ ก.พ.7</strong></td>
      </tr>
      <?
	if($schoolid != ""){
		  $conS = " AND schoolid='$schoolid'";
	}else{
		$conS = "";	
	}
	if($xtype == "QL"){
		$conW = " WHERE status_numfile='1' AND siteid='$sentsecid' ";	
	}else if($xtype == "norecive"){
		$conW = " WHERE status_numfile='0' AND siteid='$sentsecid' ";
	}else if($xtype == "countn"){
		$conW = " WHERE status_numfile='1' and status_file='0' and status_check_file='NO' AND status_id_false='0'  AND siteid='$sentsecid'";
	}else if($xtype == "all"){
		$conW = 	" WHERE siteid='$sentsecid' ";
	}else if($xtype == "idfalse"){
		$conW = " WHERE status_id_false='1' and status_numfile='1' AND  siteid='$sentsecid'";
	}else if($xtype == "norecive_idfalse"){
		$conW = " WHERE status_id_false='1' and status_numfile='0' AND  siteid='$sentsecid'";	
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
				$kp7img = "";	
		}
		
		if($rs[status_id_false] == "1"){ // แสดงว่าเป็นเลขบัตรที่ไม่ถูกต้องตามกรมการปกครอง
				$link_update_idcard = "<a href='../hr3/tool_competency/change_idcard/index_changidcard.php?action=form_search&s_idcard=$rs[idcard]&profile_id=$profile_id' target='_blank'><img src=\"../../images_sys/key_go.png\" title=\"คลิ๊กเพื่อเปลี่ยนเลขบัตรที่ไม่ถูกต้องตามกรมการปกครอง\" width=\"16\" height=\"16\" border=\"0\"></a>";
		}else{
				$link_update_idcard = "";
		}// end แสดงว่าเป็นเลขบัตรที่ไม่ถูกต้องตามกรมการปกครอง
		
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]";?></td>
        <td align="left"><? echo "$rs[name_th]";?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="center"><?=$kp7img?>&nbsp;&nbsp;<?=$link_update_idcard?></td>
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
