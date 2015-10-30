<?
session_start();
header("Location: report_noproblem_comment_comparev1.php");

include("checklist2.inc.php");
include("../../common/common_competency.inc.php");
$db_source = "edubkk_checklist_jogo";
$db_dest = DB_CHECKLIST;

####  ตัวแปรเก็บชื่อตาราง หน่วยงานตามข้อมูลโฟรไฟล์
$arrEduSchool = GetEduareaAllschool($profile_id);
$eduarea = $arrEduSchool['eduarea'];
$allschool = $arrEduSchool['allschool'];
$tbl_allschool = "edubkk_master.".$allschool;
### end ตัวแปรเก็บชื่อตาราง

function GetCondition(){
	$arrfield_comment = FieldComment();
	if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $key => $val){
				if($conv > "") $conv .= " or ";
				$conv .= " $key <> '' ";
		}
	}// end 	if(count($arrfield_comment;) > 0){
		return $conv;
}//end function GetCondition(){
	
function GetField(){
	$arrfield_comment = FieldComment();
	if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $key => $val){
				if($conv > "") $conv .= ", ";
				$conv .= " $key ";
		}
	}// end 	if(count($arrfield_comment;) > 0){
		return $conv;
}//end function GetCondition(){

	
#########################
function GetPersonComment($type,$profile_id){
	global $db_source,$db_dest;
	if($type == "S"){
			$dbname = $db_source;
			ConHost("61.19.255.74","suwat","suwat2010");
	}else if($type == "D"){
			ConHost("61.19.255.74","cmss","2010cmss");
			$dbname = $db_dest;
	}//endif($type == "S"){ 
	
	$conv1 = GetCondition(); // เงื่อนไขการหาหมายเหตุ
	$sql = "SELECT COUNT(idcard) as num1,siteid FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' and ($conv1) GROUP BY siteid";
	//echo $dbname. " :: ".$sql."<hr>";
	$result = mysql_db_query($dbname,$sql) or die(mysql_error());
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}// end while($rs = mysql_fetch_assoc($result)){
	
return $arr;	
}//end function GetPersonComment(){
	
	
############  แสดงข้อมูลรายคน
function GetPersonBysite($type,$siteid,$profile_id){
	global $db_source,$db_dest;
	$arrfield_comment = FieldComment();
	if($type == "S"){
			$dbname = $db_source;
			ConHost("61.19.255.74","suwat","suwat2010");
	}else if($type == "D"){
			ConHost("61.19.255.74","cmss","2010cmss");
			$dbname = $db_dest;
	}//endif($type == "S"){ 
	
	$conv1 = GetCondition(); // เงื่อนไขการหาหมายเหตุ
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$siteid' AND profile_id='$profile_id' AND ($conv1) ORDER BY name_th,surname_th ASC";
	$result = mysql_db_query($dbname,$sql);
	while($rs = mysql_fetch_assoc($result)){
		foreach($arrfield_comment as $k => $v){
			if($rs[$k] != ""){
					$arr[$rs[idcard]][$k] = $rs[$k];
			}
				
		}//end foreach($arrfield_comment as $k => $v){
		
		$arr[$rs[idcard]]['idcard'] = $rs[idcard];
		$arr[$rs[idcard]]['prename_th'] = $rs[prename_th];
		$arr[$rs[idcard]]['name_th'] = $rs[name_th];
		$arr[$rs[idcard]]['surname_th'] = $rs[surname_th];
		$arr[$rs[idcard]]['position_now'] = $rs[position_now];
		$arr[$rs[idcard]]['schoolname'] = show_school($rs[schoolid]);
			
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetPersonBysite(){


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
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body>
<?
	ConHost("61.19.255.74","cmss","2010cmss");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onChange="gotourl(this)">
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
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<? if($lv == ""){?>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>

 <tr>
   <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
     <tr>
       <td colspan="4" align="left" bgcolor="#A8B9FF"><strong>เปรียบเทียบเอกสารสมบูรณ์แต่มีหมายเหตุระหว่างข้อมูลที่สำรองไว้กับข้อมูลในปัจจุบัน</strong></td>
       </tr>
     <tr>
       <td width="4%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
       <td width="44%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>เขตพื้นที่การศึกษา</strong></td>
       <td colspan="2" align="center" bgcolor="#A8B9FF"><strong>หมายเหตุเอกสารสมบูรณ์(คน)</strong></td>
       </tr>
     <tr>
       <td width="25%" align="center" bgcolor="#A8B9FF"><strong>ฐานข้อมูลที่สำรองไว้</strong></td>
       <td width="27%" align="center" bgcolor="#A8B9FF"><strong>ฐานข้อมูลปัจจุบัน</strong></td>
     </tr>
     <?
	$arrs =  GetPersonComment("S",$profile_id); // จำนวนเอกสารที่ไม่สมบูรณ์ผัง BK
	$arrd = GetPersonComment("D",$profile_id); // จำนวนเอกสารที่ไม่สมบูรณ์ฝั่ง dest
	//echo "<pre>";
	//print_r($arrs);
	//echo "<hr>";
	//print_r($arrd);
	
     $sql_edu = "SELECT 
	 t1.secid, t1.name_proth, t1.office_ref, t1.secname, t1.provid, t1.partid, t1.siteid,t1.secname_short,
if(substring(t1.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
$eduarea as t1
Inner Join eduarea_config as t2 ON t1.secid = t2.site
WHERE
t2.group_type =  'keydata' AND
t2.profile_id =  '$profile_id' 
order by idsite, t1.secname  ASC";
	 $result_edu = mysql_db_query($dbnamemaster,$sql_edu);
	 $i=0;
	 while($rs_e = mysql_fetch_assoc($result_edu)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	 
	 	$nums = $arrs[$rs_e[secid]]; // จำนวนเอกสารที่มีหมายเหตุฝั่งต้นทาง
		$numd = $arrd[$rs_e[secid]]; // จำนวนเอกสารที่มีหมายเหตุฝั่งปลายทาง
		//<a href='?lv=1&xsiteid=$rs_e[secid]&profile_id=$profile_id&type=S' target='_blank'>
		//<a href='?lv=1&xsiteid=$rs_e[secid]&profile_id=$profile_id&type=D' target='_blank'>
	 ?>
     <tr bgcolor="<?=$bg?>">
       <td align="center"><?=$i?></td>
       <td align="left"><? if($nums > 0 or $numd > 0){ echo "<a href='?lv=1&xsiteid=$rs_e[secid]&profile_id=$profile_id&type=S' target='_blank'>".$rs_e[secname]."</a>"; }else{ echo "$rs_e[secname]";}?></td>
       <td align="center"><? if($nums > 0){ echo "<a href='?lv=2&xsiteid=$rs_e[secid]&profile_id=$profile_id&type=S' target='_blank'>".number_format($nums)."</a>";}else{ echo "0";}?></td>
       <td align="center"><? if($numd > 0){ echo "<a href='?lv=2&xsiteid=$rs_e[secid]&profile_id=$profile_id&type=D' target='_blank'>".number_format($numd)."</a>";}else{ echo "0";}?></td>
     </tr>
    <?
		$arr1 = "";
	 }//end  while(){
	?>
   </table></td>
 </tr>
 <? } //end if($lv == ""){
	 
	if($lv == "1"){	 
	$arrfield_comment = FieldComment();
	$arrshow = GetPersonBysite("D",$xsiteid,$profile_id);
	$arr_S = GetPersonBysite("S",$xsiteid,$profile_id);

	$count1 = count($arrshow);
	$count2 = count($arr_S);
	if($count1 >= $count2){
		$arrloop  = $arrshow;
	}else{
		$arrloop = $arr_S;	
	}
	
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="10" bgcolor="#A8B9FF"><strong> <?="รายชื่อบุคลากรที่ตรวจเอกสารสมบูรณ์".show_area($xsiteid);?></strong>
		</td>
        </tr>
      <tr>
        <td width="2%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="11%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td colspan="2" align="center" bgcolor="#A8B9FF"><strong>หมายเหตุเอกสารสมบูรณ์(คน)</strong></td>
        <td width="3%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ไฟล์ ก.พ.7</strong></td>
      </tr>
      <tr>
        <td width="27%" align="center" bgcolor="#A8B9FF"><strong>ฐานข้อมูลที่สำรองไว้</strong></td>
        <td width="23%" align="center" bgcolor="#A8B9FF"><strong>ฐานข้อมูลปัจจุบัน</strong></td>
        </tr>
      <?

		if(count($arrloop) > 0){
		foreach($arrloop as $key => $val){
			
				foreach($arrfield_comment as $k1 => $v1){
					if($arr_S[$key][$k1] != ""){
						$arr_comment1[$v1] = $arr_S[$key][$k1];
					}//end if($arr_S[$key][$k1] != ""){
					if($arrshow[$key][$k1] != ""){
						$arr_comment2[$v1] = $arrshow[$key][$k1];
					}// end if($val[$k1] != ""){
						
				}// end foreach($arrfield_comment as $k1 => $v1){

			
			
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$kp7file = "../../../".PATH_KP7_FILE."/$xsiteid/$key.pdf";
		if(is_file($kp7file)){
				$kp7img = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" border=\"0\" title=\"คลิ๊กเพื่อดูเอกสาร ก.พ.7 ต้นฉบับ\"></a>";
		}else{
				
				$arrkp7 = GetPdfOrginal($key,$path_pdf,$imgpdf,"","pdf");
				$kp7img = $arrkp7['linkfile'];	

				//$kp7img = "";	
		}
		

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$key?></td>
        <td align="left"><? echo "$val[prename_th]";?></td>
        <td align="left"><? echo "$val[name_th]";?></td>
        <td align="left"><? echo "$val[surname_th]";?></td>
        <td align="left"><? echo "$val[position_now]";?></td>
        <td align="left"><? echo $val[schoolname];?></td>
        <td align="center" valign="top">
        <?
        	if(count($arr_comment1) > 0){
		?>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
   <td bgcolor="#009900" align="center">หมวดข้อมูล</td>
   <td bgcolor="#009900" align="center">หมายเหตุ</td>
 </tr>
    <? 
	foreach($arr_comment1 as $xk1 => $xv1){
	
	?>
  <tr>
    <td width="44%" bgcolor="#FFFFFF"><?=$xk1?></td>
    <td width="56%" bgcolor="#FFFFFF"><?=$xv1?></td>
  </tr>
  <?

	}//end foreach($arr_comment1 as $xk1 => $xv1){

  ?>
</table>
<?
	}//end if(count($arr_comment1) > 0){
?>
</td>
        <td align="center" valign="top">
      <?
      	if(count($arr_comment2) > 0){
	  ?>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
   <td bgcolor="#009900" align="center">หมวดข้อมูล</td>
   <td bgcolor="#009900" align="center">หมายเหตุ</td>
 </tr>
    <? 
	foreach($arr_comment2 as $xk2 => $xv2){
	?>
  <tr>
    <td width="44%" bgcolor="#FFFFFF"><?=$xk2?></td>
    <td width="56%" bgcolor="#FFFFFF"><?=$xv2?></td>
  </tr>
  <?

	}//end  	foreach($arr_comment2 as $xk2 => $xv2){
  ?>
</table>
<?
	}//end 	if(count($arr_comment2) > 0){
?>
</td>
        <td align="center"><?=$kp7img?></td>
      </tr>
     <?
	 	unset($arr_comment1);
	 	unset($arr_comment2);
		}// end foreach($arrshow as $key => $val){
	}//end 	if(count($arrcomp) > 0){
	
	 ?>
    </table></td>
  </tr>
 <? } //end ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <?
  	if($lv == "2"){
	$arrfield_comment = FieldComment();
	$arrshow = GetPersonBysite($type,$xsiteid,$profile_id);
		
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" bgcolor="#A8B9FF"><strong> <?="รายชื่อบุคลากรที่ตรวจเอกสารสมบูรณ์".show_area($xsiteid);?></strong>
		</td>
        </tr>
      <tr>
        <td width="2%" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="6%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="23%" align="center" bgcolor="#A8B9FF"><strong>หมายเหตุเอกสารสมบูรณ์(คน)</strong></td>
        <td width="3%" align="center" bgcolor="#A8B9FF"><strong>ไฟล์ ก.พ.7</strong></td>
      </tr>
      <?

		if(count($arrshow) > 0){
		foreach($arrshow as $key => $val){
			
				foreach($arrfield_comment as $k1 => $v1){
					if($val[$k1] != ""){
						$arr_comment[$v1] = $val[$k1];
					}//end if($val[$k1] != ""){
						
				}// end foreach($arrfield_comment as $k1 => $v1){

			
			
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$kp7file = "../../../".PATH_KP7_FILE."/$xsiteid/$key.pdf";
		if(is_file($kp7file)){
				$kp7img = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" border=\"0\" title=\"คลิ๊กเพื่อดูเอกสาร ก.พ.7 ต้นฉบับ\"></a>";
		}else{
				
				$arrkp7 = GetPdfOrginal($key,$path_pdf,$imgpdf,"","pdf");
				$kp7img = $arrkp7['linkfile'];	

				//$kp7img = "";	
		}
		

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$key?></td>
        <td align="left"><? echo "$val[prename_th]";?></td>
        <td align="left"><? echo "$val[name_th]";?></td>
        <td align="left"><? echo "$val[surname_th]";?></td>
        <td align="left"><? echo "$val[position_now]";?></td>
        <td align="left"><? echo $val[schoolname];?></td>
        <td align="center" valign="top">
          <?
      	if(count($arr_comment) > 0){
	  ?>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td bgcolor="#009900" align="center">หมวดข้อมูล</td>
              <td bgcolor="#009900" align="center">หมายเหตุ</td>
              </tr>
            <? 
	foreach($arr_comment as $xk2 => $xv2){
	?>
            <tr>
              <td width="44%" bgcolor="#FFFFFF"><?=$xk2?></td>
              <td width="56%" bgcolor="#FFFFFF"><?=$xv2?></td>
              </tr>
            <?

	}//end  	foreach($arr_comment2 as $xk2 => $xv2){
  ?>
  </table>
  <?
	}//end 	if(count($arr_comment2) > 0){
?>
</td>
        <td align="center"><?=$kp7img?></td>

      </tr>
     <?
	 	unset($arr_comment);
		}// end foreach($arrshow as $key => $val){
	}//end 	if(count($arrcomp) > 0){
	
	 ?>
    </table></td>
  </tr>
  <?
	}//end 	if($lv == "2"){
  ?>
</table>
</body>
</html>
