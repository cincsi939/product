<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_list_person";
$module_code 		= "list_person"; 
$process_id			= "list_person";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################
include("../libary/function.php");
include("../../../config/conndb_nonsession.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();


set_time_limit(36000);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

$nowIPx =  $_SERVER[SERVER_ADDR] ; 
if ($nowIPx == "127.0.0.1"){
	$masterIP = "127.0.0.1";
	$nowIP = "localhost";
}else{
	$masterIP = "192.168.2.12";	
	$nowIP =  HOST ;
} ############### END  if ($nowIP == "127.0.0.1"){
#$masterIP = "192.168.2.12";	
$masterDB = $dbnamemaster ; 
$title 	= "จำแนกตามสังกัด"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานสถานะการขอปรับปรุงข้อมูล</title>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>
<style type="text/css">
<!--
.style1 {

	text-decoration: underline;
}
-->
</style>
</head>
<body>
<?
$arr_sitesendback["1701"] = "ok"; 
$arr_sitesendback["7103"] = "ok"; 
$arr_sitesendback["5701"] = "ok"; 
$arr_sitesendback["7302"] = "ok"; 
$arr_sitesendback["4802"] = "ok"; 
$arr_sitesendback["6702"] = "ok"; 
$arr_sitesendback["7001"] = "ok"; 
$arr_sitesendback["7002"] = "ok"; 
$arr_sitesendback["5101"] = "ok"; 
$arr_sitesendback["7401"] = "ok"; 
$arr_sitesendback["7702"] = "ok"; 
$arr_sitesendback["5601"] = "ok"; 

$arr_sitesendback["4102"] = "ok"; 
$arr_sitesendback["5602"] = "ok"; 

$arr_sitesendback["3404"] = "22 กพ 51"; 

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">

<tr align="right" >
    <td style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#868E94', EndColorStr='#ffffff')">&nbsp;</td>
</tr>
</table>
<?
#$masterIP = "192.168.2.12";	
$masterDB = $dbnamemaster ; 
# echo "  <h4>   $masterIP  <br>  $masterDB<br>   </hr>    ";

conn($masterIP) ; 

	$sql = " SELECT   secid,secname,IP   FROM    eduarea 
Inner Join area_info ON eduarea.area_id = area_info.area_id " ; 
	$result = mysql_db_query($masterDB , $sql); 
	while( $rs = mysql_fetch_assoc($result) ){
		$arr_ip[$rs[secid]] = $rs[IP] ; 
#		if ($nowIPx == "127.0.0.1"){ $arr_ip[$rs[secid]] = "127.0.0.1" ; } 
	} ######  while( $rs = mysql_fetch_assoc($result) ){ 

	$sql = " SELECT siteid, areaname, sc_num, area_head, area_voicehead, area_eduadvice, area_staff FROM area_staffref "; 
	$result = mysql_db_query($masterDB , $sql); 
	while( $rs = mysql_fetch_assoc($result) ){
		$secid = $rs[siteid] ; 
		$arr_arearef[$secid] = $rs[area_head] + 	 $rs[area_voicehead]    +$rs[area_staff]  + $rs[area_eduadvice]   ; 
	} ######  while( $rs = mysql_fetch_assoc($result) ){ 
	
	$sql=" SELECT siteid , Sum(sc_head) AS sum_schead, Sum(voice_exe) AS sum_scvoice  ,  count(sc_head) AS countnm 
	FROM allschool GROUP BY siteid
	" ; 
	$result = mysql_db_query($masterDB , $sql); 
	while( $rs = mysql_fetch_assoc($result) ){
		$secid = $rs[siteid] ; 
		$arr_arearef[$secid] += $rs[sum_schead]  +  $rs[sum_scvoice] ; 
		$arr_scnum[$secid]  = $rs[countnm]    ; 		
	} ######  while( $rs = mysql_fetch_assoc($result) ){ 


	$sql = " SELECT siteid, areaname, sc_num, area_head, area_voicehead, area_eduadvice, area_staff FROM area_staffref 
	where 
	siteid != 1040 and siteid < 9900  
	"; 
	$result = mysql_db_query($masterDB , $sql); 
	while( $rs = mysql_fetch_assoc($result) ){
		$secid = $rs[siteid] ; 
		$arr_exenum[$secid] = $rs[sc_num]     ; 
		$arr_name[$secid]  =  $rs[areaname] ;  		
		$arr_areanum[$secid] = $rs[area_staff]  + $rs[area_eduadvice]   ; 
		$arr_areaexenum[$secid] = $rs[area_head] + 	 $rs[area_voicehead]   ; 
	} ######  while( $rs = mysql_fetch_assoc($result) ){ 
	
#	$sql1 = "   SELECT * FROM `view_percen_entry_dep` 
#	WHERE  dep_code != 1040 and dep_code < 9000 ORDER BY  timestamps desc  
	$sql1 = "  
SELECT
dep_code  ,  dep_name ,   sc_head , sc_voice  , 
( area_head+area_voice+area_eduadvice+area_38k2+sc_head+sc_voice ) AS sum_keyin,
( app_area_head+app_area_voice+
app_area_eduadvice+app_area_38k2+app_sc_head+app_sc_voice ) AS sum_approve   
 
FROM
view_percen_entry_dep

WHERE  dep_code != 1040 and dep_code < 9900  

 "; 
	$result1= mysql_db_query($masterDB , $sql1); 
	while($rs1 = @mysql_fetch_assoc($result1)){
		$depid = $rs1[dep_code] ; 
		$db_lastupdate = $rs1[timestamps] ; 		

		$arr_keyin[$depid]  =  $rs1[sum_keyin] ;  
		$arr_approve[$depid]  =  $rs1[sum_approve] ;  		
		
		$arr_schead[$depid]  =  $rs1[sc_head] ;  
		$arr_scvoice[$depid]  =  $rs1[sc_voice] ;  
	} ###while($rs1 = @mysql_fetch_assoc($result)){ 
################ ข้อมูลที่ได้จาก E_me	
?>


<? 
@reset($arr_name) ; 
@reset($arr_name1) ; 
 ?> 
<table width="99%" align="center" border="0" cellspacing="0" cellpadding="3" bgcolor="#000000" style="margin-top:5px; border:1px solid #000000">
<tr bgcolor="#A3B2CC"  style="font-weight:bold;"     align="center"       >
	<td width="4%" height="37" rowspan="2" class="boder_rb">ลำดับ</td>
	<td rowspan="2" class="boder_rb">สำนักงานเขตพื้นที่</td>
	<td colspan="4" class="boder_rb">จำนวนบุคคลากรที่ต้องบันทึกข้อมูล <br />
    ตามหนังสือเลขที่ ศธ.0206.6/1158 ลว.24 ก.ย. 2550 </td>
  </tr>

<tr bgcolor="#A3B2CC"  style="font-weight:bold;"     align="center"            >
  <td width="15%" height="51" class="boder_rb">ทั้งหมด (คน) (จากการประมาณ) </td>
  <td width="15%" class="boder_rb">จำนวนข้อมูล ที่มีอยู่จริงในระบบ(คน) </td>
  <td width="15%" class="boder_rb">ผ่านการ รับรองข้อมูล (คน) </td>
  <td width="15%" class="boder_rb">ความสมบูรณ์ ของข้อมูล (ร้อยละ) </td>
</tr>
<? 
 while (list ($depid, $depname) = each ($arr_name)) {
#	$xx1 = @($arr_keyin[$depid]  * 100 )/  $arr_arearef[$depid]  ; 
	$arr_percen[$depid] =  @($arr_approve[$depid]  * 100 )/  $arr_arearef[$depid]  ; 
}
arsort($arr_percen);

$i=0 ; 
# while (list ($depid, $depname) = each ($arr_name)) {
while (list ($depid, $percenapprove) = each ($arr_percen)) { 
$depname = $arr_name[$depid] ; 
#    echo "$codeid, $name, $val  <br> "; 
$i++; 
if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
#$cal_nm  = ($arr_exenm[$depid]) + ($arr_scnm[$depid] *2 ) ; 
$allcal_nm += $cal_nm ; 
# if ($cal_nm <= $arr_numperson[$depid]){ 	$bgcolor1 = "FFFFCC";   }
?>
<tr bgcolor="<?=$bgcolor1?>" align="center" onmouseover='mOvr(this,&quot;dbf2ae&quot;);' onmouseout='mOut(this,&quot;<?=$bgcolor1?>&quot;);'>
	<td class="boder_rb" height="18"><?=$i?></td>
	<td align="left" class="boder_rb"> 
<? if ($debug == "on" ) {    ?> 
<? } #  if ($debug == "on" ) { echo  $depid ;    ?> 

<a href="http://<?=$arr_ip[$depid]?>/pty_master/application/hr3/hr_report/percen_entry_depV2excel.php?xsiteid=<?=$depid?>"  target="_blank" ><img src="../../../images_sys/xls_logo.gif" width="16" height="16" border="0" /></a>

&nbsp; 
<a href="http://<?=$arr_ip[$depid]?>/pty_master/application/hr3/hr_report/list_person_summaryV3.php?xsiteid=<?=$depid?>" target="_top"  >
<u><?=$depname?></u><a>
<?


if ($arr_sitesendback[$depid]  != ""){ echo "*"; } 


?>


</td>
	<td align="right" class="boder_rb"><?=number_format($arr_arearef[$depid])?></td>
	<td align="right" class="boder_rb"><?	

	# $x = $arr_arearef[$depid]  - $arr_approve[$depid]  ; 
	$x = $arr_keyin[$depid]  ;  
?>
        <?=number_format($x)?>    </td>
	<td align="right" class="boder_rb"><?

	$x = $arr_approve[$depid]  ; 


?>
	    <?=number_format($x)?>    </td>
    <td align="right" class="boder_rb"> &nbsp;
<?
$xx1 = @($arr_keyin[$depid]  * 100 )/  $arr_arearef[$depid]  ; 
$xx2 = @($arr_approve[$depid]  * 100 )/  $arr_arearef[$depid]  ; 

$yy =   $arr_keyin[$depid] - $arr_arearef[$depid]  ; 
#  if ($xx1 > 100 ){ echo "<font color = red ><b> "; echo "$arr_keyin[$depid] ลบ  $arr_arearef[$depid] "; echo " ||| $yy ";  } 
# echo " key  $xx1 |||| app $xx2   <br> รร  $arr_scnum[$depid]   ||ผอ   $arr_schead[$depid]     ||รอง  $arr_scvoice[$depid]   ";

echo number_format($percenapprove,2)  ; 
 

?>	
	</td>
</tr>
<?

} #########  while (list ($depid, $depname) = each ($arr_name)) {

?>
<tr bgcolor="#A3B2CC" align="right" style="font-weight:bold;">
	<td colspan="2" align="center" class="boder_rb">รวม </td>
    <td align="center" class="boder_rb"><?=number_format(@array_sum($arr_arearef))?></td>
    <td align="center" class="boder_rb">
	<? 
	$xgain = @array_sum($arr_arearef) ; 
	$xkeyin = @array_sum($arr_keyin)  ;
	$xapprove = @array_sum($arr_approve) ;
#	$keyin_ing = $xkeyin -   $xapprove ; 	
	$keyin_ing = $xgain -   $xapprove ;  ?>
	<?=number_format($xkeyin)?></td>
    <td align="center" class="boder_rb"><?=number_format(@array_sum($arr_approve))?></td>
    <td align="center" class="boder_rb">
<?
$xx2 = @(array_sum($arr_approve)  * 100 )/  array_sum($arr_arearef)  ; 

echo number_format($xx2,2) ; 
?>	%
	</td>
</tr>
<tr bgcolor="#A3B2CC" align="right" style="font-weight:bold;">
  <td colspan="6" align="left" class="boder_rb">เขตที่มีเครื่องหมาย * เป็นเขตที่จัดส่งรายชื่อตามหนังสือสั่งการ </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
<?
/*
	$sql = "
	SELECT 
	Count(general.name_th) AS count_nm , id_ministry.m_name, id_department.dep_name,
	id_ministry.m_code,  id_department.dep_code ,   approve_status 
	FROM   general
	Inner Join eduarea ON general.siteid = eduarea.secid
	Inner Join id_department ON eduarea.beunderid = id_department.dep_code
	Inner Join id_ministry ON id_department.m_code = id_ministry.m_code
	group by dep_code  ,   approve_status  
	"; 
*/
?>