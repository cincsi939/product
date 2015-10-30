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
eduarea_config.group_type =  'keydata' 
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
	if($xtype == "wait"){ $xtitle = "รายชื่อบุคลากรที่อยู่ระหว่างการตรวจสอบเอกสาร";}else if($xtype == "complate"){ $xtitle = "รายชื่อบุคลากรที่ตรวจเอกสารสมบูรณ์";}else if($xtype == "checkall"){ $xtitle = "รายชื่อบุคลากรที่ตรวจเอกสารแล้วทั้งหมด";}else if($xtype == "all"){ $xtitle = "จำนวนบุคลากรทั้งหมด";}else{ $xtitle = "รายชื่อบุคลากรที่ตรวจเอกสารสมบูรณ์";}
	
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" bgcolor="#A8B9FF"><strong> <?=$xtitle."".show_area($sentsecid);?></strong>
		
		<? $xsc =get_school($schoolid,$sentsecid);

		echo $xsc['schoolname']   ;
		?> 
		</td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="10%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="8%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="10%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="32%" align="center" bgcolor="#A8B9FF"><strong>หมายเหตุเอกสารสมบูรณ์</strong></td>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>ไฟล์ ก.พ.7</strong></td>
      </tr>
      <?
	  $arrfield_comment = FieldComment();
	  $arrcomp = array();
	  
	if($schoolid != ""){
		  $conS = " AND schoolid='$schoolid'";
	}else{
		$conS = "";	
	}
	if($xtype == "wait"){
		$conW = " WHERE status_check_file='NO' AND siteid='$sentsecid'  AND status_numfile='1'";	
	}else if($xtype == "complate"){
		$conW = " WHERE status_file='1' and status_check_file='YES' AND siteid='$sentsecid' AND (mainpage IS NULL  or mainpage='' or mainpage='1') AND  status_id_false='0' AND  status_numfile='1'";
	}else if($xtype == "checkall"){
		$conW = " WHERE status_check_file='YES'  AND siteid='$sentsecid'  AND status_numfile='1'";
	}else if($xtype == "all"){
		$conW = 	" WHERE siteid='$sentsecid' ";
	}else{
		$conW = 	" WHERE status_check_file='YES' AND status_file='1' AND siteid='$sentsecid' AND (mainpage IS NULL  or mainpage='' or mainpage='1') AND  status_id_false='0' AND  status_numfile='1'";
	}
	
	$con1 = " AND profile_id='$profile_id'";
      $sql = "SELECT * FROM tbl_checklist_kp7  $conW $conS $con1";
	  //echo $sql;
	  $result = mysql_db_query($dbtemp_check,$sql);
	  $i=0;
	  while($rs = mysql_fetch_assoc($result)){
		
/*		if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $kx1 => $vx1){
			if($rs[$kx1] != ""){
					$arrcomp[$vx1] = $rs[$kx1];
			}
		}//end foreach($arrfield_comment as $kx1 => $vx1){
	}// end if(count($arrfield_comment) > 0){
		
*/		
		
	if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $kx1 => $vx1){
			if($rs[$kx1] != ""){
				$nexttext1 = wordwrap($rs[$kx1], 10, "\n",true);
					$arrcomp[$vx1] = $nexttext1;
			}
		}//end foreach($arrfield_comment as $kx1 => $vx1){
}// end if(count($arrfield_comment) > 0){


############  หาค่า comment ในการจัดเก็บรูปแบบใหม่(เอกสารสมบูรณ์)
$sql_docm = "SELECT
t1.idcard,
t1.menu_id,
t2.problem
FROM
tbl_checklist_problem_detail as t1
Inner Join tbl_problem as t2 ON t1.problem_id = t2.problem_id
WHERE
t1.status_problem =  '0' AND
t2.type_problem =  '1' AND t1.idcard='$rs[idcard]' AND t1.profile_id='$profile_id' ORDER BY  t1.menu_id ASC";
$result_doc = mysql_db_query($dbname_temp,$sql_docm);
$numr_doc = @mysql_num_rows($result_doc);
while($rsd = mysql_fetch_assoc($result_doc)){
	if($xmenu_id != $rsd[menu_id]){
		$comment_doc = "";
		$xmenu_id = $rsd[menu_id];
	}
	
	if($comment_doc > "") $comment_doc .= ",";
	$comment_doc .= $rsd[problem];
	
	$nexttext2 = wordwrap($comment_doc, 10, "\n",true);
	
	$arrdocp1[GetTypeMenu($rsd[menu_id])] = $nexttext2;

}// end while($rsd = mysql_fetch_assoc($result_doc)){
	
	
#####  ทำการเชื่อมโยงกันระหว่างข้อมูลรูปแบบเก่ากับแบบใหม่
if(count($arrdocp1) > 0){
	foreach($arrdocp1 as $xk2 => $xv2){
			if(array_key_exists("$xk2", $arrcomp)) {
				$temp_text =  $xv2.",".$arrcomp[$xk2];
				$nexttext = wordwrap($temp_text, 10, "\n",true);
				$arrc[$xk2] = $nexttext;
				 
				unset($arrcomp[$xk2]); // เคลียค่า array ทีซ้ำ
			}else{
				$arrc[$xk2] = $xv2;
			} //end 	if(array_key_exists("$xk2", $arrcomp)) {
	}//end foreach($arrdocp1 as $xk2 => $xv2){
}//end  if(count($arrdocp1) > 0){

if(count($arrdocp1) > 0 and count($arrcomp) > 0){
	$arrmerge = array_merge($arrc,$arrcomp);
}else if(count($arrdocp1) > 0 and count($arrcomp) < 1){
	$arrmerge = $arrdocp1;
}else if(count($arrdocp1) < 1 and count($arrcomp) > 0){
	$arrmerge = $arrcomp;
}//end if(count($arrdocp1) > 0 and count($arrcomp) > 0){	
		
		
		

		if(count($arrmerge) > 0){
			
			
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$kp7file = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard].pdf";
		if(is_file($kp7file)){
				$kp7img = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" border=\"0\" title=\"คลิ๊กเพื่อดูเอกสาร ก.พ.7 ต้นฉบับ\"></a>";
		}else{
				
				$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
				$kp7img = $arrkp7['linkfile'];	

				//$kp7img = "";	
		}
		

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]";?></td>
        <td align="left"><? echo "$rs[name_th]";?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="center">
        
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
    <td colspan="2" bgcolor="#009900" align="center"><strong>หมายเหตุรายการเอกสารสมบูรณ์</strong></td>
    </tr>
  <tr>
    <td bgcolor="#009900" align="center"><strong>หมวดข้อมูล</strong></td>
    <td bgcolor="#009900" align="center"><strong>หมายเหตุ</strong></td>
  </tr>
    <? 
	$xj=0;
	foreach($arrmerge as $keyc => $valc){
		if ($xj++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
	?>
  <tr bgcolor="<?=$bg1?>">
    <td width="44%"><?=$keyc?></td>
    <td width="56%"><?=$valc?></td>
  </tr>
  <?
	}//end  foreach($arrcomp as $keyc => $valc){
  ?>
</table>
        
        
        </td>
        <td align="center"><?=$kp7img?></td>
      </tr>
     <?
	 
	}//end 	if(count($arrcomp) > 0){
		unset($arrmerge);
		unset($arrc);
	  	unset($arrcomp);
	  	unset($arrdocp1);

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
