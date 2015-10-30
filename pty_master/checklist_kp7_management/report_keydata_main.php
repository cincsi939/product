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

$edubkk_master = DB_MASTER ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = "cmss_". $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("../common/class.loadpage.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$dbname_temp = DB_CHECKLIST;

$date_conf = "2009-11-01";// fix ปี
function getprofile(){
	global $dbname_temp;
	$sql = "SELECT profile_id FROM tbl_temp_profile ";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[profile_id];
}

$time_start = getmicrotime();
//echo " xA :".$xprofile_id."<br>";
if($profile_id != ""){
	$profile_id = $profile_id;
}else{
	$profile_id = getprofile();
}
//echo " B :".$profile_id;

	
	
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 
	$date_curent = intval(date("d"))." ".$month[intval(date("m"))]." ".(date("Y")+543);

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
	$db_site = "cmss_".$xsiteid;
	$xconW = " ".find_groupstaff($xtype);
	$sql_type = "SELECT COUNT(*)  AS num1 FROM view_general WHERE  $xconW ";
	$result_type = mysql_db_query($db_site,$sql_type);
	$rs_t = mysql_fetch_assoc($result_type);
	return $rs_t[num1];
}



## function นับจำนวนบุคลากรแยกรายหน่วยงานแยกตามสายงาน
function count_person_area_appv($status_appv,$xtype,$schoolid){

global $xsiteid;
	$db_site = "cmss_".$xsiteid;
	
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
		
		$sql_area = "SELECT COUNT(*)  AS num1 FROM view_general WHERE  schoolid = '$schoolid' $xconv $xconW ";
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
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.siteid
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
WHERE
callcenter_entry.tbl_assign_key.nonactive =  '0' AND
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id'
group by edubkk_checklist.tbl_checklist_kp7.idcard";
	$result = mysql_db_query(DB_USERENTRY,$sql);
	while($rs = mysql_fetch_assoc($result)){
//		$sqlcheck = "SELECT count(idcard) as num1 FROM `monitor_keyin` WHERE date(monitor_keyin.timeupdate) >=  '$date_conf' and idcard='$rs[idcard]'";
//		$resultcheck = mysql_db_query(DB_USERENTRY,$sqlcheck);
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
//Right Join edubkk_master.allschool ON edubkk_master.allschool.id = t1.schoolid
//WHERE edubkk_master.allschool.siteid='$xsiteid'";
//echo $sql_count;
	$sql_count = "SELECT COUNT(*) AS NUM1 FROM allschool  WHERE siteid='$xsiteid'";
	$result_count = mysql_db_query($dbnamemaster,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[NUM1]-1;
}



function count_person_appv($app_status,$schoolid){ // นับจำนวนบุคลากรจำแนกตามหน่วยงานตามสถานะรับรองข้อมูล

global $xsiteid;
	$db_site = "cmss_".$xsiteid;
	
			if($app_status == "approve"){
				$xconW = " AND approve_status LIKE '%approve%'";
			}else{
				$xconW = " AND (approve_status = '' or approve_status IS NULL)";
			}
		
		$sql_area = "SELECT COUNT(*)  AS num1 FROM view_general WHERE  schoolid = '$schoolid'  $xconW ";
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
	$db_site = "cmss_".$xsiteid;
	
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
		
		$sql_area = "SELECT COUNT(*)  AS num1 FROM view_general WHERE  schoolid = '$schoolid' $xconv $xconW ";
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
edubkk_checklist.tbl_checklist_kp7.siteid,
Count(idcard) AS NumAll,
Sum(if(page_upload > 0,1,0)) AS NumUpload,
sum(if(status_file=1,1,0)) as NumPass,
Sum(if(status_check_file='NO',1,0)) as NumDis,
Sum(if(status_check_file='YES' and status_file=0,1,0)) AS NumDocFalse

FROM
edubkk_checklist.tbl_checklist_kp7
WHERE  profile_id='$profile_id'
group by edubkk_checklist.tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['NumAll'] = $rs['NumAll'];
		$arr[$rs[siteid]]['NumUpload'] = $rs['NumUpload'];
		$arr[$rs[siteid]]['NumPass'] = $rs['NumPass'];
		$arr[$rs[siteid]]['NumDis'] = $rs['NumDis'];
		$arr[$rs[siteid]]['NumDocFalse'] = $rs['NumDocFalse'];
			
	}
	return $arr;
}//end  function CountCheckList(){
	
function CountPersonPdf(){
		$dbname_temp = DB_CHECKLIST;	
		$sql = "SELECT
Count(idcard) AS NumPerson,
Sum(if(page_upload > 0,1,0)) AS NumPdf,
edubkk_checklist.tbl_checklist_kp7.siteid
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.eduarea ON edubkk_checklist.tbl_checklist_kp7.siteid = edubkk_master.eduarea.secid
Inner Join edubkk_master.eduarea_config ON edubkk_master.eduarea.secid = edubkk_master.eduarea_config.site
WHERE
edubkk_master.eduarea_config.group_type =  'keydata' AND
edubkk_master.eduarea_config.pdf_org =  '1'
group by edubkk_checklist.tbl_checklist_kp7.siteid";
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
edubkk_checklist.tbl_checklist_kp7.siteid,
count(edubkk_checklist.tbl_checklist_kp7.idcard) as numkey
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
AND edubkk_checklist.tbl_checklist_kp7.siteid = callcenter_entry.tbl_assign_key.siteid
WHERE
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
callcenter_entry.tbl_assign_key.nonactive =  '0' AND
callcenter_entry.tbl_assign_key.approve =  '2'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numkey'] = $rs['numkey'];
	}
	return $arr1;
}//

###########  นับจำนวนเลขบัตรไม่ตรองตามกรมการปกครอง
function NumIDFalse(){
	global $profile_id;
		$dbname_temp = DB_CHECKLIST;
		$sql = "SELECT
		count(tbl_checklist_kp7_false.idcard) as num1,
		tbl_checklist_kp7_false.siteid
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' group by siteid";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){

			$arr[$rs[siteid]] = $rs[num1];

}//end while($rs = mysql_fetch_assoc($result)){
	
	return $arr;
}//end function NumIDFalse(){


function ShowIconArea(){
		global $dbnamemaster;
		$sql = "SELECT
eduarea.secid,
eduarea.secname
FROM `eduarea`
WHERE
eduarea.full_area =  '1'
";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[secid]] = "<font color='green'>*</font>";
	}
	return $arr;
}


#############  function ตรวจสอบว่ายืนยันจำนวนข้อมูลในเขตนั้นหรือยัง
function CheckConFArea($get_siteid){
		global $profile_id;
		$dbname_temp = DB_CHECKLIST;
		$sql = "SELECT count(siteid) as num1  FROM `tbl_status_lock_site` where siteid='$get_siteid' and profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0){
				$xicon = "<font color='green'><strong>*</strong></font>";
		}else{
				$xicon = "";	
		}
		return $xicon;
		
}//end function CheckConFArea($get_siteid){

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


$('.popupProfile').popupWindow({ height:400, width:300, top:50, left:50 });

</script>
</head>
<body>
<? 	
		  $arrsite = CountCheckList();
		 $arrkey = NumPersonKey();		
		 $arrIdF = NumIDFalse();
		 $arricon = ShowIconArea(); // แสดง icon สำหรับเขตต่อเนื่อง
		 $exsum_idflase = array_sum($arrIdF); // จำนวนข้อมูลเลขบัตรไม่ถูกต้องทั้งหมด	
		foreach($arrsite as $k => $v){
			$exnum1 += $arrsite[$k]['NumPass'];
			$exnum2 += $arrsite[$k]['NumDocFalse'];
			$exnum3 += $arrsite[$k]['NumDis'];
			$exnum4 += $arrsite[$k]['NumUpload'];
			$exnum5 += $arrkey[$k]['numkey'];
			$exsum_numarea = $exsum_numarea+1; // จำนวนเขต
		}//end foreach($arrsite as $k => $v){
		 
		 $exsum_data = $exnum1+$exnum2+$exnum3;
		 $exsum_all = $exsum_idflase+$exsum_data; /// จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)
		 $exsum_doc = $exnum1+$exnum2; // สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ
		 $exsum_scan = $exnum4;//แฟ้มข้อมูลสแกนสำเนาเอกสาร กพ.7 ต้นฉบับ
		 $exsum_key = $exnum5;
?>
<table width="99%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="2" align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
               <tr>
                 <td colspan="5" align="center" bgcolor="#CCCCCC">รายงานผลการจัดทำข้อมูลปฐมภูมิข้าราชการครูและบุคลากรทางการศึกษา <? if($profile_id != ""){ echo ShowDateProfile($profile_id);}else{?>(ข้อมูล ณ วันที่ <?=$DateNData?>) <? }?></td>
                 </tr>
               <tr>
                 <td width="50%" align="left" bgcolor="#FFFFFF">จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)</td>
                 <td width="14%" align="center" bgcolor="#FFFFFF"><?=number_format($exsum_all)?></td>
                 <td width="11%" align="center" bgcolor="#FFFFFF">คน</td>
                 <td width="11%" align="center" bgcolor="#FFFFFF"><?=$exsum_numarea?></td>
                 <td width="14%" align="center" bgcolor="#FFFFFF">เขตพื้นที่</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_doc)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format(($exsum_doc*100)/$exsum_all,2)?></td>
                 <td align="center" bgcolor="#FFFFFF">%</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">แฟ้มข้อมูลสแกนสำเนาเอกสาร กพ.7 ต้นฉบับ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_scan)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format(($exsum_scan*100)/$exsum_all,2)?></td>
                 <td align="center" bgcolor="#FFFFFF">%</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">ข้อมูลปฐมภูมิ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_key)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format(($exsum_key*100)/$exsum_all,2)?></td>
                 <td align="center" bgcolor="#FFFFFF">%</td>
               </tr>
             </table></td>
           </tr>
         </table></td>
        </tr>
       <tr>
         <td width="10%" align="center">&nbsp;</td>
         <td width="90%" align="right"><A href="#" onClick="window.open('report_keydata_popup.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=400,height=300');"><img src="../application/validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อกำหนดโฟร์ไฟล์ข้อมูล"></A>&nbsp;รายงาน ณ วันที่
<?=$date_curent?></td>
       </tr>
     </table></td>
   </tr>
</table>
      <table cellspacing="1" cellpadding="3" width="99%" align="center" border="0" bgcolor="#F5F5F5">
   <tbody>
     <tr >
       <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC" >ลำดับ</td>
       <td width="23%" rowspan="2" align="center" bgcolor="#CCCCCC">สพท.</td>
       <td width="8%" rowspan="2" align="center" bgcolor="#CCCCCC">บุคลากรตาม<br />
        อัตราจริง<br />
       ทั้งหมด (คน)</td>
       <td colspan="3" align="center" bgcolor="#CCCCCC">ได้รับเอกสาร (คน)</td>
       <td width="9%" rowspan="2" align="center" bgcolor="#CCCCCC">เอกสาร<br />
ค้างรับ (คน)</td>
       <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">เลขบัตรฯไม่ตรง<br />
        ปกครอง(คน)</td>
       <td width="9%" rowspan="2" align="center" bgcolor="#CCCCCC">ไฟล์สำเนา กพ.7 (คน)</td>
       <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC"><a href="report_keydata_main_area.php?profile_id=<?=$profile_id?>">ข้อมูลปฐมภูมิ (คน)</a></td>
     </tr>
     <tr >
       <td width="9%" align="center" bgcolor="#CCCCCC"><a href="report_keydata_main_checklist.php?profile_id=<?=$profile_id?>" target="_blank">รวม</a></td>
       <td width="9%" align="center" bgcolor="#CCCCCC">สมบูรณ<strong>์</strong></td>
       <td width="10%" align="center" bgcolor="#CCCCCC">ไม่สมบูรณ์</td>
     </tr>
		 <?

		$sql = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata'  and eduarea_config.profile_id='$profile_id'  order by eduarea.secname ASC";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 	if(CheckImpCh($rs[secid]) > 0){
				$num_personsys = 1;
			}else{
				$num_personsys = 0;	
			}
			
			###  จำนวนข้อมูลเลขบัตรไม่ถูกต้องตามกรมการปกครอง
			$numIdFalse = $arrIdF[$rs[secid]];
			
			 if($arrsite[$rs[secid]]['NumAll'] == $arrsite[$rs[secid]]['NumPass']){
				$sfont = "<font color='#000000'>";
				$efont = "</font>";
				$link_style = " style='color:#000000'";
			}else if($arrsite[$rs[secid]]['NumPass'] < $arrsite[$rs[secid]]['NumAll']){
				$sfont = "<strong><font color='#FF0000'>";
				$efont = "</font></strong>";	
				$link_style = " style='color:#FF0000;font-weight:bold'";
			}else{
				$sfont = "<font color='#000000'>";
				$efont = "</font>";	
				$link_style = " style='color:#000000'";

			}
			
		
		 
		 
		 if(($arrkey[$rs[secid]]['numkey'] != $arrsite[$rs[secid]]['NumPass']) ){
				$sfont2 = "<strong><font color='#FF0000'>";
				$efont2 = "</font></strong>";	
				$link_style2 = " style='color:#FF0000;font-weight:bold'";
			}else{
				$sfont2 = "<font color='#000000'>";
				$efont2 = "</font>";	
				$link_style2 = " style='color:#000000'";
	
			}
			
			if($arrsite[$rs[secid]]['NumUpload'] != $arrsite[$rs[secid]]['NumPass']){
				$sfont3 = "<strong><font color='#FF0000'>";
				$efont3 = "</font></strong>";	
				$link_style3 = " style='color:#FF0000;font-weight:bold'";

			}else{
					
				$sfont3 = "<font color='#000000'>";
				$efont3 = "</font>";	
				$link_style3 = " style='color:#000000'";
			}
			####ข้อมูลของคนที่จะคีย์  <font color='green'><b>*</b></font>
			
			$area_name = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$rs[secname]);
			$numDocP1 = $arrsite[$rs[secid]]['NumPass']+$arrsite[$rs[secid]]['NumDocFalse'];
			$NumDisCheck = $arrsite[$rs[secid]]['NumDis'];
			
				if($NumDisCheck > 0){
						$link_style1 = " style='color:#FF0000;font-weight:bold'";
					}else{
						$sfont1 = "<font color='#000000'>";
						$efont1 = "</font>";		
					}
			
			
			
			### บุคลากรตามอัตราจริงทั้งหมด (คน)
			$sumPerson = $numIdFalse+$numDocP1+$NumDisCheck;

		?>
     <tr bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="left"><? if($num_personsys > 0){echo "<a href='report_keydata_area.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=all&profile_id=$profile_id' >".$area_name."</a>";}else{ echo $area_name;}?>&nbsp;<? echo $arricon[$rs[secid]];?></td>
       <td align="center"><?=number_format($sumPerson);?>&nbsp;<?=CheckConFArea($rs[secid]);?></td>
       <td><?=number_format($numDocP1)?></td>
       <td><?=number_format($arrsite[$rs[secid]]['NumPass']);?></td>
       <td><?=$sfont1?>
         <?
       $NumFalse = $arrsite[$rs[secid]]['NumDocFalse'];
 if($NumFalse > 0){ echo "<a href='report_keydata_person.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=diforg1&profile_id=$profile_id'  $link_style1>".number_format($NumFalse)."</a>";}else{ echo "0";}
	   
	   ?>
       <?=$efont1?></td>
       <td><?=$sfont1?>
         <?  
	   if($NumDisCheck > 0){ echo "<a href='report_keydata_person.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=diforg&profile_id=$profile_id'  $link_style1>".number_format($NumDisCheck)."</a>";}else{ echo "0";} ?>
       <?=$efont1?></td>
       <td><? if($numIdFalse > 0){ echo "<a href='report_keydata_person_idfalse.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=idfalse&profile_id=$profile_id'  $link_style1>".number_format($numIdFalse)."</a>";}else{ echo "0";}?></td>
       <td><?=$sfont3?><? 
	  // echo number_format($arrsite[$rs[secid]]['NumUpload']);
	   $NumUploadFile = $arrsite[$rs[secid]]['NumUpload'];
	   if($NumUploadFile > 0){echo "<a href='report_keydata_person.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=org&profile_id=$profile_id'  $link_style3>".number_format($NumUploadFile)."</a>";}else{  echo "0";}?><?=$efont3?></td>
       <td><? 
	   $numpersonkey = $arrkey[$rs[secid]]['numkey'];
	   if($numpersonkey > 0){ echo "<a href='report_keydata_pass.php?xsiteid=$rs[secid]&secname=$rs[secname]&numkey=$numpersonkey&profile_id=$profile_id' target='_blank'  $link_style2>".number_format($numpersonkey)."</a>";}else{ echo "0";}
	   ?></td>
     </tr>
<?
		$sum_allperson += $sumPerson;
		$sum_allpass += $arrsite[$rs[secid]]['NumPass'];
		$sum_pdf_dif += $arrsite[$rs[secid]]['NumDis'];
		$sum_pdf_org += $arrsite[$rs[secid]]['NumUpload'];
		$sum_numkey += $arrkey[$rs[secid]]['numkey'];
		$num_NumFalse += $NumFalse;
		$numIdFalse_all += $numIdFalse;
		$numDocP1_all += $numDocP1;
		}// end while($rs = mysql_fetch_assoc()){
?>
     <tr  bgcolor="#A3B2CC"  align="center" >
       <td colspan="2" bgcolor="#CCCCCC"  >รวม</td>
       <td bgcolor="#CCCCCC">
        <?=number_format($sum_allperson)?>
      </td>
       <td align="center" bgcolor="#CCCCCC">
        <?=number_format($numDocP1_all)?>
   </td>
       <td align="center" bgcolor="#CCCCCC">
        <?=number_format($sum_allpass)?>
     </td>
       <td align="center" bgcolor="#CCCCCC">
         <?=number_format($num_NumFalse);?>
   </td>
       <td align="center" bgcolor="#CCCCCC">
         <?=number_format($sum_pdf_dif)?>
     </td>
       <td align="center" bgcolor="#CCCCCC">
        <?=number_format($numIdFalse_all);?>
      </td>
       <td align="center" bgcolor="#CCCCCC">
        <?=number_format($sum_pdf_org);?>
      </td>
       <td align="center" bgcolor="#CCCCCC">
        <?=number_format($sum_numkey);?>
       </td>
     </tr>
   </tbody>
 </table>
&nbsp;&nbsp;<!--&nbsp; หมายเหตุ เครื่องหมาย <font color="green">*</font> เป็นเขตต่อเนื่องจากโครงการในปีงบประมาณ 2552
--></body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); 
//echo 
//echo "เวลา :: ".$time_end-$time_start;
	$sql_update_profile = "UPDATE tbl_temp_profile SET load_page='1' WHERE profile_id='$profile_id'";
	mysql_db_query($dbname_temp,$sql_update_profile);
?>
