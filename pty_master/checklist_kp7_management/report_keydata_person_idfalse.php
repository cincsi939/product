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
$tblgeneral = "general"; // ตารางหลักในการค้นหาบุคลากร
$link_file = "percen_entry_v5sc_appv_detail.php";
$link_file1 = "percen_entry_v5sc_appv.php";

$edubkk_master = DB_MASTER ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = "cmss_". $xxsiteid ; 
$db_site = "cmss_$xsiteid";
//$profile_id = 1;
$dbname_temp = DB_CHECKLIST;


include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("../common/class.loadpage.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$time_start = getmicrotime();



	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 
	$date_curent = intval(date("d"))." ".$month[intval(date("m"))]." ".(date("Y")+543);

$getdepid = $depid ;

function ShowDateThai($get_d){
	global $month;
		if($get_d != "" and $get_d != "0000-00-00"){
			$arr = explode("-",$get_d);
				return intval($arr[2])." ".$month[intval($arr[1])]." ".$arr[0];
		}else{
				return "";	
		}
}

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

### exsum
function CountExsum($get_siteid){
	global $dbnamemaster,$type,$schoolid,$profile_id,$dbname_temp;	
	$db_site = "cmss_$get_siteid";
	if($type == "all"){
		$conx = " general   where schoolid='$schoolid'";
	}else if($type == "org"){
		$conx = "  edubkk_checklist.tbl_checklist_kp7 LEFT JOIN $db_site.general   ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general.idcard  Where   edubkk_checklist.tbl_checklist_kp7.siteid = '$get_siteid' AND tbl_checklist_kp7.page_upload > 0 and  tbl_checklist_kp7.status_file='1' AND profile_id='$profile_id'";	
		

	}else if($type == "diforg"){
		$conx = "  edubkk_checklist.tbl_checklist_kp7 LEFT JOIN $db_site.general   ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general.idcard  Where   edubkk_checklist.tbl_checklist_kp7.siteid = '$get_siteid'  and  edubkk_checklist.tbl_checklist_kp7.status_check_file='NO' AND profile_id='$profile_id'";	
	}else if($type == "diforg1"){
			$conx = "  edubkk_checklist.tbl_checklist_kp7 LEFT JOIN $db_site.general   ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general.idcard  Where   edubkk_checklist.tbl_checklist_kp7.siteid = '$get_siteid'  and  edubkk_checklist.tbl_checklist_kp7.status_check_file='YES' and edubkk_checklist.tbl_checklist_kp7.status_file='0' AND profile_id='$profile_id'";	
	}else if($type == "idfalse"){
		
		$conx = " tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND
tbl_checklist_kp7_false.siteid='$get_siteid' ";
		
	$db_site = DB_CHECKLIST;
		
	}else{
		$conx = " general where siteid='$get_siteid'";		
	}
	
	
		$sqlh1 = find_groupstaff(1); // ผอ. เขต
		$sqlh2 = find_groupstaff(2); // รอง ผอ.เขต
		$sqlh3 = find_groupstaff(3); // ศึกษานิเทศ
		$sqlh4 = find_groupstaff(4); // ผอ.โรงเรียน 
		$sqlh5 = find_groupstaff(5); // รอง ผอ.โรงเรียน 
		$sqlh6 = find_groupstaff(6)." or ".find_groupstaff(8); // ครู+ครูผู้ช่วย
		$sqlh7 = find_groupstaff(7); // 38 ค
		
	$sql = "SELECT 
		sum(if($sqlh1,1,0)) as LineH1,
		sum(if($sqlh2,1,0)) as LineH2,
		sum(if($sqlh3,1,0)) as LineH3,
		sum(if($sqlh4,1,0)) as LineH4,
		sum(if($sqlh5,1,0)) as LineH5,
		sum(if($sqlh6,1,0)) as LineH6,
		sum(if($sqlh7,1,0)) as LineH7
		FROM $conx ";
		//echo $sql;
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['LineH1'] = $rs['LineH1'];
	$arr['LineH2'] = $rs['LineH2'];
	$arr['LineH3'] = $rs['LineH3'];
	$arr['LineH4'] = $rs['LineH4'];
	$arr['LineH5'] = $rs['LineH5'];
	$arr['LineH6'] = $rs['LineH6'];
	$arr['LineH7'] = $rs['LineH7'];
	return $arr;	
}//end function CountExsum(){


############  นับจำนวนบุคลากรจำแนกรายตำแหน่ง
function CountNumPersonSchool($get_site){
		$db_site = "cmss_$get_site";
		$sqlh1 = find_groupstaff(1); // ผอ. เขต
		$sqlh2 = find_groupstaff(2); // รอง ผอ.เขต
		$sqlh3 = find_groupstaff(3); // ศึกษานิเทศ
		$sqlh4 = find_groupstaff(4); // ผอ.โรงเรียน 
		$sqlh5 = find_groupstaff(5); // รอง ผอ.โรงเรียน 
		$sqlh6 = find_groupstaff(6)." or ".find_groupstaff(8); // ครู+ครูผู้ช่วย
		$sqlh7 = find_groupstaff(7); // 38 ค
		
		$sql = "SELECT 
		sum(if($sqlh1,1,0)) as LineH1,
		sum(if($sqlh2,1,0)) as LineH2,
		sum(if($sqlh3,1,0)) as LineH3,
		sum(if($sqlh4,1,0)) as LineH4,
		sum(if($sqlh5,1,0)) as LineH5,
		sum(if($sqlh6,1,0)) as LineH6,
		sum(if($sqlh7,1,0)) as LineH7,
		schoolid
		FROM general GROUP BY schoolid";
		$result = mysql_db_query($db_site,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr1[$rs[schoolid]]['LineH1'] = $rs['LineH1'];
				$arr1[$rs[schoolid]]['LineH2'] = $rs['LineH2'];
				$arr1[$rs[schoolid]]['LineH3'] = $rs['LineH3'];
				$arr1[$rs[schoolid]]['LineH4'] = $rs['LineH4'];
				$arr1[$rs[schoolid]]['LineH5'] = $rs['LineH5'];
				$arr1[$rs[schoolid]]['LineH6'] = $rs['LineH6'];
				$arr1[$rs[schoolid]]['LineH7'] = $rs['LineH7'];		
		}// end while($rs = mysql_fetch_assoc($result)){
	return $arr1;
}

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
<!--<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="92%" align="right"><strong>รหัสรายงาน : </strong></td>
    <td width="8%"><strong>&nbsp;Report01</strong></td>
  </tr>
</table>-->
<?

$sql = " SELECT * FROM `eduarea` WHERE `secid` LIKE '%$xsiteid%'  " ; 
$result = mysql_query($sql) ; 
$rs  = mysql_fetch_assoc($result) ; 
$areaname = $rs[secname] ; 

	 if($schoolid != ""){
			$conv = " AND schoolid='$schoolid'";
	}else{
			$conv = "";	
	}


$sql_idf = "SELECT
COUNT(tbl_checklist_kp7_false.idcard) AS num1
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid' $conv";
$result_idf = mysql_db_query($dbname_temp,$sql_idf);
$rsf = mysql_fetch_assoc($result_idf);

$sql_idt = "SELECT
COUNT(tbl_checklist_kp7.idcard) AS numt1,
SUM(if(status_id_false='1' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1'),1,0 )) AS  numtrue,
SUM(if(status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1'),1,0)) AS  numfalse,
SUM(if(status_id_false='1' and mainpage='0',1,0 )) AS  numpagefalse
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND tbl_checklist_kp7.status_id_false='1' AND siteid='$xsiteid' $conv";
//echo $sql_idt;
$result_idt = mysql_db_query($dbname_temp,$sql_idt);
$rst = mysql_fetch_assoc($result_idt);



?>

<table width="99%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="3" align="left" valign="top"><b><? if($schoolid == $xsiteid){ echo "<a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$secname</a> :: $office";}else{ echo "<a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$secname</a> :: $office";}?></b></td>
       </tr>
       <tr>
         <td width="10%" rowspan="2" align="center" valign="top">&nbsp;</td>
         <td width="78%" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
               <tr>
                 <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รายงานจำนวนข้าราชการครูและบุคลากรทางการศึกษา <? echo str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท. ",$secname);?></strong></td>
                 </tr>
               <tr>
                 <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ที่เลขบัตรประชาชนไม่ตรงตามกรมการปกครอง
                   <? if($profile_id != ""){ echo ShowDateProfile($profile_id);}else{?>
                   (ข้อมูล ณ วันที่
                   <?=$DateNData?>
                   )
                   <? }?>
                   </strong></td>
                 </tr>
               <tr>
                 <td width="50%" align="left" bgcolor="#FFFFFF"><strong>มีรายชื่อแต่ไม่ได้รับเอกสารจากเขต</strong></td>
                 <td width="25%" align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rsf[num1]);?>
                   </strong></td>
                 <td width="25%" align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF"><strong>มีรายชื่อและได้รับเอกสารจากเขตแล้ว</strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rst[numt1]);?>
                   </strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF"><strong> - เอกสารสมบูรณ์</strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rst[numtrue]);?>
                   </strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF"><strong> - เอกสารไม่สมบูรณ์</strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rst[numfalse]);?>
                   </strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF"><strong>- เอกสารขาดเอกสารประกอบ</strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rst[numpagefalse]);?>
                   </strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF"><strong>รวม</strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>
                   <?=number_format($rst[numt1]+$rsf[num1]);?>
                   </strong></td>
                 <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
                 </tr>
               </table></td>
             </tr>
          </table></td>
         <td width="12%" align="center">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" align="right"><strong>รายงาน ณ. วันที่ 
           <?=$date_curent?>
         </strong></td>
       </tr>
     </table></td>
  </tr>
</table>
      <table cellspacing="1" cellpadding="3" width="99%" align="center" bgcolor="#F5F5F5" border="0">
   <tbody>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"     >
       <td width="4%" bgcolor="#CCCCCC" >ลำดับ</td>
       <td width="18%" bgcolor="#CCCCCC">หมายเลขบัตรประชาชน</td>
       <td width="17%" bgcolor="#CCCCCC">ชื่อ-นามสกุล</td>
       <td width="19%" bgcolor="#CCCCCC">ตำแหน่ง</td>
       <td width="32%" bgcolor="#CCCCCC">สังกัดหน่วยงาน</td>
       <td width="10%" bgcolor="#CCCCCC">สถานะเอกสาร</td>
     </tr>
     <?
	
//$sql = "SELECT
//tbl_checklist_kp7_false.idcard,
//tbl_checklist_kp7_false.siteid,
//tbl_checklist_kp7_false.prename_th,
//tbl_checklist_kp7_false.name_th,
//tbl_checklist_kp7_false.surname_th,
//tbl_checklist_kp7_false.position_now,
//tbl_checklist_kp7_false.schoolid
//FROM
//tbl_checklist_kp7_false
//WHERE
//tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
//tbl_checklist_kps7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
//tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' and siteid='$xsiteid' $conv";
//

$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid,
tbl_checklist_kp7_false.status_school_fail as status_idfalse,
tbl_checklist_kp7_false.status_file,
'' as mainpage
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid' $conv

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_id_false as status_idfalse,
tbl_checklist_kp7.status_file,
tbl_checklist_kp7.mainpage as mainpage
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND tbl_checklist_kp7.status_id_false='1' AND siteid='$xsiteid' $conv
ORDER  BY status_idfalse ASC
";
//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
while ($rs = mysql_fetch_assoc($result)){  
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	
	if($rs[status_idfalse] == "1" and $rs[status_file] == "1" and $rs[mainpage] == ""){
		$xicon = " <img src=\"../images_sys/document_green.png\" width=\"25\" height=\"25\" title=\"เลขบัตรไม่ถูกต้องตามกรมการปกครองแต่สถานะเอกสารสมบูรณ์\" border=\"0\">";	
		$fcolor = "#000000";
		$xbgc ="";
	}else if($rs[status_idfalse] == "1" and $rs[status_file] == "0" and $rs[mainpage] == ""){
		
		
		$xicon = "<A href=\"#\" onClick=\"window.open('../application/checklist_kp7_management/popup_checklist_problem.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=400')\"><img src=\"../images_sys/document_red.png\" width=\"25\" height=\"25\" title=\"เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะเอกสารไม่สมบูรณ์\" border=\"0\"></a>";	 
		$fcolor = "#000000";
		$xbgc ="";
	}else if($rs[status_idfalse] == "1" and $rs[mainpage] == "0"){
		$xicon = "<img src=\"../images_sys/document_blue.png\" width=\"25\" height=\"25\" title=\"เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะเอกสารขาดปก\" border=\"0\">";
		$fcolor = "#000000";
		$xbgc ="";
	}else{
		$xicon = "<em>ไม่มีเอกสาร</em>";	
		$fcolor = "#FF0000";
		$xbgc = " bgcolor=\"#FF0000\"";
	}//end if($rs[status_idfalse] == "1" and $rs[status_file] == "1"){
	 


?>

     <tr   bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="center"><font color="<?=$fcolor?>"><? echo $rs[idcard]?></font></td>
       <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
       <td align="left"><? echo "$rs[position_now]";?></td>
       <td align="left"><? 
	   if($rs[schoolid] == ""){ echo "ไม่ระบุ";}else{
		  	$sql_school = "SELECT office FROM allschool WHERE id='$rs[schoolid]'"; 
			$result_school = mysql_db_query($dbnamemaster,$sql_school);
			$rss = mysql_fetch_assoc($result_school);
			echo $rss[office];
		  }
	   
	   ?></td>
       <td align="center" <?=$xbgc?>><? echo $xicon;?></td>
     </tr>
<?

}//end while ($rs = mysql_fetch_assoc($result)){  
?>
   </tbody>
 </table>
 <br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" align="left"><em>หมายเหตุ : </em></td>
            </tr>
            <tr>
              <td width="7%" align="center"><img src="../images_sys/document_green.png" width="25" height="25" title="เลขบัตรไม่ถูกต้องตามกรมการปกครองแต่สถานะเอกสารสมบูรณ์" border="0"></td>
              <td width="93%" align="left"><em>เลขบัตรไม่ถูกต้องตามกรมการปกครองแต่สถานะเอกสารสมบูรณ์</em></td>
            </tr>
            <tr>
              <td align="center"><img src="../images_sys/document_red.png" width="25" height="25" title="เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะเอกสารไม่สมบูรณ์" border="0"></td>
              <td align="left"><em>เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะเอกสารไม่สมบูรณ์</em></td>
            </tr>
            <tr>
              <td align="center"><img src="../images_sys/document_blue.png" width="25" height="25" title="เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะเอกสารขาดปก" border="0"></td>
              <td align="left"><em>เลขบัตรไม่ถูกต้องตามกรมการปกครองและสถานะขาดเอกสารประกอบ</em></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FF0000">&nbsp;</td>
              <td align="left"><em>เลขบัตรที่เป็นตัวหนังสือสีแดงคือไม่มีเอกสาร ก.พ.7</em></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
