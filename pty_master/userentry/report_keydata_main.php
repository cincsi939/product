<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "competency_percenentry_byarea";
$module_code 		= "percenentry_byarea"; 
$process_id			= "percenentry_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		Rungsit
	## E-mail :			
	## Tel. :			
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ระบบฐานข้อมูลบุคลากร
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

session_start() ; 
set_time_limit(0) ; 
if ( $_SESSION[siteid]   != ""){ 
	# $_SESSION[reportsecid]
} 
if ($xsiteid == ""){ $xsiteid = $_SESSION[siteid]  ;    $xxsiteid = $xsiteid  ; } 

if ($loginid != ""){   $xxsiteid = $loginid  ; } 
if ($_SESSION[reportsecid] == "cmss-otcsc" ){
	########### ok 
} ### END if ($_SESSION[reportsecid] == "cmss-otcsc" ){
//
/*echo "<pre>";
print_r($_SESSION);
*/
$link_file = "percen_entry_v5sc_appv_detail.php";
$link_file1 = "percen_entry_v5sc_appv.php";
if($xsiteid != ""){ $xsiteid = $xsiteid;}else{ $xsiteid = "5006";}; // กรณีทดสอบในเครื่อง

$edubkk_master = DB_MASTER; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$profile_id = 1; // fix profile
$date_conf = "2009-11-01";// fix ปี

$time_start = getmicrotime();



	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 

$getdepid = $depid ;

?>
<? ##################### หาชื่อสพท.
#	if ($xsiteid == ""){  	die ("กรุณาระบุรหัสพื้นที่") ; }



function echo_percen($val1){
	if (is_int($val1)){
		$returnval = number_format($val1) ; 
	}else if ($val1 == 0 ) {		
		$returnval = 0 ; 		
	}else{
		$returnval = number_format($val1 ,2) ; 
	}
	return $returnval ; 
}

function query_array($xdbname , $sql){
	$result  = mysql_db_query($xdbname , $sql);
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <hr><pre> $sql </pre><hr> ".mysql_error() ."<br>"  ;   } 
	while ($rs = mysql_fetch_array($result)){
#		echo " <hr> ";
#		print_r($rs) ; echo " <hr> ";
		$arrtmp[0] =   $rs[0] ; 
	} 
	return $arrtmp ;
} ######### END function query_array($sql){ 

function count_type_position($xtype){ // บุคลากรจำแนกตามสายงาน
global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	$xconW = " ".find_groupstaff($xtype);
	$sql_type = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  $xconW ";
	$result_type = mysql_db_query($db_site,$sql_type);
	$rs_t = mysql_fetch_assoc($result_type);
	return $rs_t[num1];
}



## function นับจำนวนบุคลากรแยกรายหน่วยงานแยกตามสายงาน
function count_person_area_appv($status_appv,$xtype,$schoolid){

global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	
		//echo $xconW;
		if($xtype != ""){
			$xconW = " AND ".find_groupstaff($xtype);
		}else{
			$xconW = " ";
		}
		
		
		### สถานะ รับรองข้อมูล
		if($status_appv == "approve"){
				$xconv = " AND approve_status LIKE '%approve%'";
		}else{
				$xconv = " AND (approve_status = '' or approve_status IS NULL)";
		}
	#### 
		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid' $xconv $xconW ";
		//echo $sql_area;
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area_appv($xtype,$schoolid){
	
###########  function นับจำนวนที่คีย์ข้อมูลเสร็จแล้วในแต่ละเขต
function CountPersonKey($xsiteid){
global $profile_id,$date_conf;
		$sql = "SELECT
monitor_keyin.idcard, monitor_keyin.siteid
FROM
monitor_keyin
WHERE
date(monitor_keyin.timeupdate) >=  '$date_conf' AND siteid='$xsiteid'
group by monitor_keyin.idcard";
//echo $sql."<br>";
	$result = mysql_db_query(DB_USERENTRY,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $arr[$rs[siteid]]+1;
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function CountPersonKey(){


############ function นับจำนวนข้อมูลที่ assign แล้ว
function CountPersonAssign(){
		global $profile_id,$date_conf;
		$sql = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.idcard,
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND
 ".DB_CHECKLIST.".tbl_checklist_kp7.profile_id =  '$profile_id'
group by  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard";
	$result = mysql_db_query(DB_USERENTRY,$sql);
	while($rs = mysql_fetch_assoc($result)){
//		$sqlcheck = "SELECT count(idcard) as num1 FROM `monitor_keyin` WHERE date(monitor_keyin.timeupdate) >=  '$date_conf' and idcard='$rs[idcard]'";
//		$resultcheck = mysql_db_query("edubkk_userentry",$sqlcheck);
//		$rsc = mysql_fetch_assoc($resultcheck);
//		if($rsc[num1] > 0){
//		$arr[$rs[siteid]]['numkey']  = $arr[$rs[siteid]]['numkey']+1;
//		}
		$arr[$rs[siteid]]['numassign'] = $arr[$rs[siteid]]['numassign']+1;
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountPersonAssign(){

function count_school($xsiteid){ // นับจำนวนโรงเรียน
global $dbnamemaster;
//	$sql_count = "SELECT
//count(distinct schoolid) as NUM1
//FROM
//cmss_$xsiteid.general as t1
//Right Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
//WHERE  ".DB_MASTER.".allschool.siteid='$xsiteid'";
//echo $sql_count;
	$sql_count = "SELECT COUNT(siteid) AS NUM1 FROM allschool  WHERE siteid='$xsiteid'";
	$result_count = mysql_db_query($dbnamemaster,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[NUM1]-1;
}



function count_person_appv($app_status,$schoolid){ // นับจำนวนบุคลากรจำแนกตามหน่วยงานตามสถานะรับรองข้อมูล

global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	
			if($app_status == "approve"){
				$xconW = " AND approve_status LIKE '%approve%'";
			}else{
				$xconW = " AND (approve_status = '' or approve_status IS NULL)";
			}
		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid'  $xconW ";
		//echo $sql_area;
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area_appv($xtype,$schoolid){

#######################   รายงานรายหน่วยงานแยกตามสายงานแยกตามเพศ
function count_person_type_sex($sex,$xtype,$schoolid){
global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	
		//echo $xconW;
		if($xtype != ""){
			$xconW = " AND ".find_groupstaff($xtype);
		}else{
			$xconW = " ";
		}
	if($sex == "m"){
		$xconv = " AND sex LIKE '%ชาย%'";
	}else if($sex == "f"){
		$xconv = " AND sex LIKE '%หญิง%'";
	}
		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid' $xconv $xconW ";
		//echo $sql_area;
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area_appv($xtype,$schoolid){
#############  นับจำนวนข้อมูลใน checklist
function CountCheckList(){
	global $profile_id;
		$dbname_temp = DB_CHECKLIST;
		
		$sql = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid,
Count(idcard) AS NumAll,
Sum(if(page_upload > 0 and status_file=1,1,0)) AS NumUpload,
sum(if(status_file=1,1,0)) as NumPass,
sum(if(status_file=0,1,0)) as NumDis
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
WHERE  profile_id='$profile_id'
group by  ".DB_CHECKLIST.".tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['NumAll'] = $rs['NumAll'];
		$arr[$rs[siteid]]['NumUpload'] = $rs['NumUpload'];
		$arr[$rs[siteid]]['NumPass'] = $rs['NumPass'];
		$arr[$rs[siteid]]['NumDis'] = $rs['NumDis'];
			
	}
	return $arr;
}//end  function CountCheckList(){
	
function CountPersonPdf(){
		$dbname_temp = DB_CHECKLIST;	
		$sql = "SELECT
Count(idcard) AS NumPerson,
Sum(if(page_upload > 0,1,0)) AS NumPdf,
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
Inner Join  ".DB_MASTER.".eduarea ON  ".DB_CHECKLIST.".tbl_checklist_kp7.siteid =  ".DB_MASTER.".eduarea.secid
Inner Join  ".DB_MASTER.".eduarea_config ON  ".DB_MASTER.".eduarea.secid =  ".DB_MASTER.".eduarea_config.site
WHERE
 ".DB_MASTER.".eduarea_config.group_type =  'keydata' AND
 ".DB_MASTER.".eduarea_config.pdf_org =  '1'
group by  ".DB_CHECKLIST.".tbl_checklist_kp7.siteid";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['NumPdf'] = $rs[NumPdf];
			$arr[$rs[siteid]]['NumPerson'] = $rs[NumPerson];
		}
		return $arr;
	}

function CountNumChecklist($get_site){
	$dbname_temp = DB_CHECKLIST;
	$sql = "SELECT
count(tbl_check_data.idcard) as NUM,
secid
FROM
tbl_check_data
inner Join tbl_checklist_kp7 ON tbl_check_data.idcard = tbl_checklist_kp7.idcard
group by secid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[secid]] = $rs[NUM];	
	}
	return $arr;
}//end function CountNumChecklist($get_site){
	
#####  function นับจำนวนข้อมูลที่ผ่านการคีย์ข้อมูลแล้ว
function NumPersonKey(){
	global $profile_id;
		$dbname_temp = DB_CHECKLIST;
	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid,
count( ".DB_CHECKLIST.".tbl_checklist_kp7.idcard) as numkey
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_checklist_kp7.profile_id =  '$profile_id' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2'
GROUP BY
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numkey'] = $rs['numkey'];
	}
	return $arr1;
}//

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<title>รายงานข้อมูลการยืนยันข้อมูล ของ สพท.</title>
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
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<link href="../application/hr3/hr_report/libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../application/hr3/hr_report/libary/tabber.js"></script>
<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script language=JavaScript> 

function CheckIsIE() 
{ 
if (navigator.appName.toUpperCase() == 'MICROSOFT INTERNET EXPLORER') { return true;} 
else { return false; } 
} 


function PrintThisPage() 
{ 

if (CheckIsIE() == true) 
{ 
parent.iframe1.focus(); 
parent.iframe1.print(); 
} 
else 
{ 
window.frames['iframe1'].focus(); 
window.frames['iframe1'].print(); 
} 

} 

 
</script></head>
<body>
<table width="99%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td width="10%" align="center">&nbsp;</td>
         <td width="90%" align="right"><strong>
           ข้อมูล ณ วันที่
  <?=$DateNData?>
          </strong></td>
       </tr>
     </table></td>
   </tr>
</table>
      <table cellspacing="1" cellpadding="3" width="99%" align="center" bgcolor="#000000" border="0">
   <tbody>
     <tr>
       <td colspan="7" align="center" bgcolor="#A3B2CC" ><strong>รายงานผลการจัดทำข้อมูลปฐมภูมิข้าราชการครูและบุคลากรทางการศึกษาในสังกัด สพฐ.</strong></td>
     </tr>
     <tr >
       <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC" ><strong>ลำดับ</strong></td>
       <td width="29%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>สพท.</strong></td>
       <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>อัตราจริง (คน)</strong></td>
       <td colspan="3" align="center" bgcolor="#A3B2CC"><strong><a href="report_keydata_main_checklist.php" target="_blank">สำเนาเอกสาร กพ.7 ต้นฉบับ (คน)</a></strong></td>
       <td width="18%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ข้อมูลปฐมภูมิ (คน)</strong></td>
     </tr>
     <tr >
       <td width="14%" align="center" bgcolor="#A3B2CC"><strong>ได้รับเอกสาร</strong></td>
       <td width="13%" align="center" bgcolor="#A3B2CC"><strong>ค้างรับ/ไม่สมบูรณ์</strong></td>
       <td width="12%" align="center" bgcolor="#A3B2CC"><strong>Uploaded</strong></td>
     </tr>
		 <?
		 $arrsite = CountCheckList();
		 $arrkey = NumPersonKey();		 
		
		$sql = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND
eduarea_config.pdf_org =  '1' order by eduarea_config.orde_by DESC";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 	if($rs[pdf_sys] == 1){
				$num_personsys = 1;
			}else{
				$num_personsys = 0;	
			}
			
			
			 if($arrsite[$rs[secid]]['NumAll'] == $arrsite[$rs[secid]]['NumPass']){
				$sfont = "<strong><font color='#009900'>";
				$efont = "</font></strong>";
			}else if(($arrsite[$rs[secid]]['NumPass'] < $arrsite[$rs[secid]]['NumAll']) or ($arrsite[$rs[secid]]['NumUpload'] < $arrsite[$rs[secid]]['NumAll']) or ($arrkey[$rs[secid]]['numkey'] < $arrsite[$rs[secid]]['NumAll']) ){
				$sfont = "<strong><font color='#FF0000'>";
				$efont = "</font></strong>";	
			}else if($arrsite[$rs[secid]]['NumAll'] == $arrkey[$rs[secid]]['numkey']){
				$sfont = "<strong><font color='#009900'>";
				$efont = "</font></strong>";	
			}else{
				$sfont = "";
				$efont = "";	
			}
			
		
					if($arrsite[$rs[secid]]['NumDis'] > 0){
						$sfont = "<strong>";
						$efont = "</strong>";	
					}
			
		 
		 	####  กรณีตัวเลขค้างรับถ้าเป็นศูนย์ให้เป็นตัวหนังสือสีดำ
			if($arrsite[$rs[secid]]['NumDis'] == "0"){
					$sfont = "<font color='#000000'>";
					$efont = "</font>";	
			}
		 
			####ข้อมูลของคนที่จะคีย์
		?>
     <tr bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="left"><? if($num_personsys > 0){echo "<a href='report_keydata_area.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=all' target='_blank'>".$rs[secname]."</a>&nbsp;<font color='green'><b>*</b></font>";}else{ echo $rs[secname];}?></td>
       <td align="center"><?=number_format($arrsite[$rs[secid]]['NumAll']);?></td>
       <td><?=$sfont?><?=number_format($arrsite[$rs[secid]]['NumPass']);?><?=$efont?></td>
       <td><?=$sfont?>
	   <?  
	  // echo number_format($arrsite[$rs[secid]]['NumDis']);
	   $NumDisCheck = $arrsite[$rs[secid]]['NumDis'];
	   if($NumDisCheck > 0){ echo "<a href='report_keydata_person.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=diforg'  target='_blank'>".number_format($NumDisCheck)."</a>";}else{ echo "0";} ?><?=$efont?></td>
       <td><?=$sfont?><? 
	  // echo number_format($arrsite[$rs[secid]]['NumUpload']);
	   $NumUploadFile = $arrsite[$rs[secid]]['NumUpload'];
	   if($NumUploadFile > 0){echo "<a href='report_keydata_person.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=org'  target='_blank'>".number_format($NumUploadFile)."</a>";}else{  echo "0";}?><?=$efont?></td>
       <td><?=$sfont?><? 
	   $numpersonkey = $arrkey[$rs[secid]]['numkey'];
	   if($numpersonkey > 0){ echo "<a href='report_keydata_pass.php?xsiteid=$rs[secid]&secname=$rs[secname]&numkey=$numpersonkey' target='_blank'>".number_format($numpersonkey)."</a>";}else{ echo "0";}
	   ?><?=$efont?></td>
     </tr>
<?
		$sum_allperson += $arrsite[$rs[secid]]['NumAll'];
		$sum_allpass += $arrsite[$rs[secid]]['NumPass'];
		$sum_pdf_dif += $arrsite[$rs[secid]]['NumDis'];
		$sum_pdf_org += $arrsite[$rs[secid]]['NumUpload'];
		$sum_numkey += $arrkey[$rs[secid]]['numkey'];
		}// end while($rs = mysql_fetch_assoc()){
?>
     <tr  bgcolor="#A3B2CC"  align="center"   class="strong_black"    >
       <td colspan="2"  ><strong>รวม</strong></td>
       <td><strong>
        <?=number_format($sum_allperson)?>
       </strong></td>
       <td align="center"><strong>
        <?=number_format($sum_allpass)?>
       </strong></td>
       <td align="center"><strong>
        <?=number_format($sum_pdf_dif)?>
       </strong></td>
       <td align="center"><strong>
        <?=number_format($sum_pdf_org);?>
       </strong></td>
       <td align="center"><strong>
        <?=number_format($sum_numkey);?>
       </strong></td>
     </tr>
   </tbody>
 </table>
&nbsp;&nbsp;&nbsp; หมายเหตุ เครื่องหมาย * เป็นเขตที่บันทึกข้อมูลในระบบแล้ว
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
