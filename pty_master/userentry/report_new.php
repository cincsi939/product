<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "report_data"; 
$process_id			= "report_data";
$VERSION 				= "9.91";
$BypassAPP 			= true;


	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			include ("../../common/common_competency.inc.php")  ;
			include "epm.inc.php";
			include("function_assign.php");

			$time_start = getmicrotime();

if($_GET['profile_id'] ==""){ // กรณีที่ไม่ได้เลือกโฟรไฟล์ข้อมูล
		$profile_id = LastProfile();
}


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


function search_ticket($get_siteid){
	global $db_name,$profile_id;
$sql = "SELECT keystaff.prename, keystaff.staffname, keystaff.staffsurname, tbl_assign_sub.ticketid,
tbl_assign_sub.recive_date,".DB_USERENTRY.".tbl_assign_key.idcard
FROM ".DB_USERENTRY.".keystaff
Inner Join ".DB_USERENTRY.".tbl_assign_sub ON ".DB_USERENTRY.".keystaff.staffid = ".DB_USERENTRY.".tbl_assign_sub.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
WHERE ".DB_USERENTRY.".tbl_assign_key.siteid =  '$get_siteid' AND ".DB_USERENTRY.".tbl_assign_sub.nonactive =  '0' AND ".DB_USERENTRY.".tbl_assign_key.profile_id='$profile_id'";
//echo $db_name,$sql;
$result = mysql_db_query($db_name,$sql);
while($rs = mysql_fetch_assoc($result)){
	$arrname[$rs[idcard]] = "$rs[staffname]  $rs[staffsurname]<br>$rs[ticketid] <br> วันที่ ".(thai_date($rs[recive_date]));
}
return $arrname;
}

function search_null_ticket($idcard){
	global $db_name,$profile_id;
$sql = "SELECT COUNT(idcard) AS num1 FROM
tbl_assign_key
Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_key.idcard =  '$idcard'
AND tbl_assign_key.nonactive='0' AND tbl_assign_key.profile_id='$profile_id'
GROUP BY idcard";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
if($rs[num1] < 1){
	return "รอส่งออก";
}
	return "";
}


function count_all($xsecid){ // function คำนวณหาจำนวนทั้งหมด
global $dbnamemaster;
	$sql = "SELECT COUNT(secid) AS num FROM log_pdf_check WHERE secid='$xsecid' group by secid";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
} // end function count_all($xsecid){ 

function count_file_pdf($xsecid){ // นับจำนวนไฟล์ pdf ที่ up ขึ้นในระบบ
	global $dbnamemaster;
	$sql1 = "SELECT COUNT(secid) AS num1 FROM  log_pdf  WHERE  secid='$xsecid' group by secid";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[num1];
}// end function count_file_pdf($xsecid){ // นับจำนวนไฟล์ pdf ที่ up ขึ้นในระบบ

function count_qc_pass1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '2' AND tbl_assign_key.siteid =  '$siteid' AND tbl_assign_key.profile_id='$profile_id' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' group by tbl_assign_key.siteid ";
//echo $sql;
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){

function count_qc1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '3' AND tbl_assign_key.siteid =  '$siteid' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' AND tbl_assign_key.profile_id='$profile_id' group by tbl_assign_key.siteid";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_wait1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid  Inner Join   ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype' AND (tbl_assign_key.approve =  '0' or tbl_assign_key.approve = '1') AND tbl_assign_key.siteid =  '$siteid' AND tbl_assign_key.profile_id='$profile_id' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' GROUP BY  tbl_assign_key.siteid";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_area_all($xsecid){
global $db_name,$profile_id;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$xsecid' AND profile_id='$profile_id'  group by secid";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


function count_area_all_dis($xsecid){
global $db_name,$profile_id;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$xsecid' AND profile_id='$profile_id' group by secid";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}




function id_in_kp7file($xsecid){
global $dbnamemaster,$db_name;
	$sql = "SELECT * FROM log_pdf  WHERE secid='$xsecid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($temp_id > "") $temp_id .= ","; 
			$temp_id .= "'$rs[idcard]'";
	}// end 	while($rs = mysql_fetch_assoc($result)){
 return $temp_id;
}// end function id_in_kp7file($xsecid){


function count_null_pdf($xsecid){ // ฟังก์ชั่นนันจำนวนคนที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ
global $profile_id;
	$temp_id = id_in_kp7file($xsecid);
	if($temp_id != ""){ $temp_id = $temp_id;}else{ $temp_id = "''";}
	$sql_count = "SELECT COUNT(idcard) AS num1  FROM tbl_check_data  WHERE secid='$xsecid' AND idcard  NOT IN ($temp_id) and profile_id='$profile_id'  group by secid";
	$result_count = mysql_db_query(DB_CHECKLIST,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
		return  $rs_c[num1];
}// end function count_null_pdf($xsecid){ // ฟังก์ชั่นนันจำนวนคนที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ

function count_pdf_fail($xsecid){// นับจำนวนไฟล์เอกสารที่ไม่สมบูรณ์
	global $dbnamemaster;
	$sql = "SELECT COUNT(secid) num1 FROM log_pdf  WHERE  secid='$xsecid' and status_file ='0' group by secid";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function count_pdf_fail(){// นับจำนวนไฟล์เอกสารที่ไม่สมบูรณ์
$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // รหัสของครู


## ตรวจสอบ ไฟล์ที่ไม่สมบูรณ์
function check_file_fail($idcard,$xsecid){
global $dbnamemaster;
	$sql_check_file = "SELECT COUNT(idcard) AS num1 FROM log_pdf   WHERE idcard='$idcard' AND status_file='0' AND secid='$xsecid' group by secid";
	//echo $sql_check_file."<br>$dbnamemaster";
	$result_check_file = mysql_db_query($dbnamemaster,$sql_check_file);
	$rs_c = mysql_fetch_assoc($result_check_file);
	return $rs_c[num1];
}// end function check_file_fail(){

#######  นับจำนวนรายการที่รับรองข้อมูลแล้วโดยบุคลากรในเขตหรือเจ้าตัว
function count_person_approve(){
	global $dbnamemaster;
	$sql = "SELECT COUNT(CZ_ID) as num,siteid FROM view_general WHERE approve_status='approve' GROUP BY siteid";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	
}// end function count_person_approve(){
	
## นับจำนวนที่มีการนำเข้าข้อมูลแล้ว
function CountPersonImp($xprofile_id=""){
	global $db_temp,$profile_id;
	if($xprofile_id != ""){
		$profile_id = $xprofile_id;	
	}
	$sql = "SELECT COUNT(tbl_checklist_kp7.idcard) AS NumAll, SUM(tbl_checklist_kp7.page_num) AS NumPage,
SUM(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0'  and page_upload>0,1,0)) AS NumFileUpload,
SUM(if((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0'  and (page_upload IS NULL or page_upload='' or page_upload < 1)) or (status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and (page_upload IS NULL or page_upload='' or page_upload < 1)),1,0)) AS NumNotFile,
tbl_checklist_kp7.siteid
FROM tbl_checklist_kp7  WHERE tbl_checklist_kp7.profile_id='$profile_id' GROUP BY siteid";	
//echo $sql;
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['NumAll'] = $rs[NumAll];
			$arr[$rs[siteid]]['NumPage'] = $rs[NumPage];
			$arr[$rs[siteid]]['NumFileUpload'] = $rs[NumFileUpload];
			$arr[$rs[siteid]]['NumNotFile'] = $rs[NumNotFile];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function CountPersonImp(){
	
### funciton ตรวจนับการคีย์งานและการรับรองความถูกต้อง
function CountKey($xprofile_id=""){
	global $db_name,$profile_id;
	if($xprofile_id != ""){
			$profile_id = $xprofile_id;
	}
	$sql_count = "SELECT
t1.siteid,
Sum(if(t4.sapphireoffice ='1' AND t2.approve='2',1,0)) AS NumSapphireQcPass,
Sum(if(t4.sapphireoffice ='1' AND t2.approve='3',1,0)) AS NumSapphireQcWait,
Sum(if(t4.sapphireoffice ='1' AND (t2.approve='1' OR t2.approve='0' ),1,0)) AS NumSapphireProcess,
Sum(if(t4.sapphireoffice='1' and (t2.approve='1' OR t2.approve='0' ) and t2.status_keydata='1',1,0 )) as NumSapphireKey,
Sum(if(t4.sapphireoffice='1' and (t2.approve='1' OR t2.approve='0' ) and t2.status_keydata='0' and t4.status_permit='YES',1,0 )) as NumSapphireWaitKey,
Sum(if(t4.sapphireoffice='1' and (t2.approve='1' OR t2.approve='0' ) and t2.status_keydata='0' and t4.status_permit='NO',1,0 )) as NumSapphireOutKey,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND t2.approve='2',1,0)) AS NumStaffTempQcPass,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND t2.approve='3',1,0)) AS NumStaffTempQcWait,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND (t2.approve='1' OR t2.approve='0'),1,0)) AS NumStaffTempProcess,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='1',1,0)) AS NumStaffTempKey,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='0' and t4.status_permit='YES' ,1,0)) AS NumStaffTempWaitKey,
Sum(if((t4.sapphireoffice ='0' or t4.sapphireoffice IS NULL) AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='0' and t4.status_permit='NO' ,1,0)) AS NumStaffTempOutKey,
Sum(if(t4.sapphireoffice ='2' AND t2.approve='2',1,0)) AS NumOutsoreceQcPass,
Sum(if(t4.sapphireoffice ='2' AND t2.approve='3',1,0)) AS NumOutsoreceQcWait,
Sum(if(t4.sapphireoffice ='2' AND (t2.approve='1' OR t2.approve='0'),1,0)) AS NumOutsoreceQcProcess,
Sum(if(t4.sapphireoffice ='2' AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='1',1,0)) AS NumOutsoreceKey,
Sum(if(t4.sapphireoffice ='2' AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='0' and t4.status_permit='YES' ,1,0)) AS NumOutsoreceWaitKey,
Sum(if(t4.sapphireoffice ='2' AND (t2.approve='1' OR t2.approve='0') and t2.status_keydata='0' and t4.status_permit='NO' ,1,0)) AS NumOutsoreceOutKey

FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid and t1.profile_id='$profile_id' and t2.profile_id='$profile_id'
Left Join ".DB_USERENTRY.".tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
Left Join ".DB_USERENTRY.".keystaff as t4 ON t3.staffid = t4.staffid
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))
GROUP BY  t1.siteid
";
//echo "$db_name :: $sql_count ";die;
	$result_count = mysql_db_query($db_name,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$arr1[$rs_c[siteid]]['NumSapphireQcPass'] = $rs_c[NumSapphireQcPass];
		$arr1[$rs_c[siteid]]['NumSapphireQcWait'] = $rs_c[NumSapphireQcWait];
		$arr1[$rs_c[siteid]]['NumSapphireProcess'] = $rs_c[NumSapphireProcess];
		$arr1[$rs_c[siteid]]['NumSapphireKey'] = $rs_c[NumSapphireKey];
		$arr1[$rs_c[siteid]]['NumSapphireWaitKey'] = $rs_c[NumSapphireWaitKey];
		$arr1[$rs_c[siteid]]['NumSapphireOutKey'] = $rs_c[NumSapphireOutKey];
		
		
		$arr1[$rs_c[siteid]]['NumStaffTempQcPass'] = $rs_c[NumStaffTempQcPass];
		$arr1[$rs_c[siteid]]['NumStaffTempQcWait'] = $rs_c[NumStaffTempQcWait];
		$arr1[$rs_c[siteid]]['NumStaffTempProcess'] = $rs_c[NumStaffTempProcess];
		$arr1[$rs_c[siteid]]['NumStaffTempKey'] = $rs_c[NumStaffTempKey];
		$arr1[$rs_c[siteid]]['NumStaffTempWaitKey'] = $rs_c[NumStaffTempWaitKey];
		$arr1[$rs_c[siteid]]['NumStaffTempOutKey'] = $rs_c[NumStaffTempOutKey];
		
		
		$arr1[$rs_c[siteid]]['NumOutsoreceQcPass'] = $rs_c[NumOutsoreceQcPass];
		$arr1[$rs_c[siteid]]['NumOutsoreceQcWait'] = $rs_c[NumOutsoreceQcWait];
		$arr1[$rs_c[siteid]]['NumOutsoreceQcProcess'] = $rs_c[NumOutsoreceQcProcess];
		$arr1[$rs_c[siteid]]['NumOutsoreceKey'] = $rs_c[NumOutsoreceKey];
		$arr1[$rs_c[siteid]]['NumOutsoreceWaitKey'] = $rs_c[NumOutsoreceWaitKey];
		$arr1[$rs_c[siteid]]['NumOutsoreceOutKey'] = $rs_c[NumOutsoreceOutKey];
		
	}// end while($rs_c = mysql_fetch_assoc($result_count)){
	return $arr1;
	
}// end function CountKey(){
	
## function นับจำนวนบุคลากรทั้งหมดในเขตและจำนวนแผ่นเอกสาร
function CountPersonAndFile($xprofile_id=""){
	global $profile_id;
	if($xprofile_id != ""){
		$profile_id = $xprofile_id;
	}
	$db = DB_CHECKLIST;	
$sql_count1 = "SELECT 
 t1.siteid,
COUNT(t1.idcard) AS NumAll, 
SUM(t1.page_num) AS NumPage, 
SUM(if(t1.page_upload > 0 and t1.page_upload IS NOT NULL,1,0)) AS NumFileUpload,
SUM(if(t1.page_upload < 1 OR t1.page_upload IS NULL,1,0)) AS NumNotFile
FROM tbl_checklist_kp7 as t1
WHERE t1.profile_id='$profile_id'  GROUP BY t1.siteid ";
//echo $sql_count1;
	$result_count1 = mysql_db_query($db,$sql_count1);
	while($rs_c1 = mysql_fetch_assoc($result_count1)){
	$arr2[$rs_c1[siteid]]['NumAll'] = $rs_c1[NumAll];
	$arr2[$rs_c1[siteid]]['NumPage'] =  $rs_c1[NumPage];
	$arr2[$rs_c1[siteid]]['NumFileUpload'] = $rs_c1[NumFileUpload];
	$arr2[$rs_c1[siteid]]['NumNotFile'] = $rs_c1[NumNotFile];
	}
	return $arr2;
	
}// end CountPersonAndFile

## ฟังก์ชั่นตรวจสอบสถานะการรับรองข้อมูลโดยระบบ
function CheckApproveKey($get_site){
	global $profile_id;
	$db = DB_USERENTRY;
	$sql_ap = "SELECT idcard,approve FROM tbl_assign_key WHERE siteid='$get_site' AND nonactive='0' AND profile_id='$profile_id'";
	//echo $sql_ap." ::  $db <br>";
	$result_ap = mysql_db_query($db,$sql_ap);
	while($rs_ap = mysql_fetch_assoc($result_ap)){
		$arr[$rs_ap[idcard]] = $rs_ap[approve];
	}
	return $arr;
}
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script src="../../../common/gs_sortable.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 5 });
        });
</script>
<link href="../../../common/gs_sortable.css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #FFF;
}
a:active {
	color: #000;
}
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

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>


<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body bgcolor="#EFEFFF">

<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกรายการข้อมูลตามช่วงเวลาข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = " selected='selected' ";}else{ $sel = "";}
		?>
              <option value="?action=<?=$action?>&profile_id=<?=$rsp[profile_id]?>&xmode=<?=$xmode?>&xshow=<?=$xshow?>&xsecid=<?=$xsecid?>&secname=<?=$secname?>&type_view=<?=$type_view?>&xtitle=<?=$xtitle?>&xsiteid=<?=$xsiteid?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
            </td>
        </tr>
        </table>
   </td>
  </tr>
</table>
 </form>
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <!--<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="70%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td colspan="4" bgcolor="#A3B2CC"><span class="style1">รายงานสรุปการบันทึกข้อมูล </span></td>
              </tr>
              <tr>
                <td width="22%" align="center" bgcolor="#A3B2CC">วันเริ่มดำเนินงาน</td>
                <td width="25%" align="center" bgcolor="#A3B2CC">วันสิ้นสุดดำเนินงาน</td>
                <td width="17%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td width="23%" align="center" bgcolor="#A3B2CC">จำนวนวันดำเนินการ(วัน)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d1);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">วันเริ่มดำเนินงาน</td>
                <td align="center" bgcolor="#A3B2CC">ปัจจุบัน</td>
                <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td align="center" bgcolor="#A3B2CC">จำนวนวันดำเนินการ(วัน)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_dc);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total_c?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">จำนวนเป้าหมายการบันทึก(คน)</td>
                <td align="center" bgcolor="#A3B2CC">จำนวนการบันทึกจริง(คน)</td>
                <td align="center" bgcolor="#A3B2CC">คงเหลือ(คน)</td>
                <td align="center" bgcolor="#A3B2CC">เปอร์เซ็นต์เป้าหมายการบันทึก</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_all"><?=$txt_sum_all;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_key"><?=$txt_sum_key;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><a href="report_non_key.php" target="_blank"><div id="dis_key"></div></a></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="persent_key"><?=$txt_persent_key?></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="22%">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><strong class="headerTB">เปอร์เซนต์การบันทึกข้อมูล ณ ปัจจุบัน</strong></td>
            </tr>
            <tr>
              <td>	<div id="cockpit_area">
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="310" height="161" align="middle">
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="movie" value="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#ffffff" />
    <embed src="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" quality="high" bgcolor="#ffffff" width="310" height="161" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />  
</object>
</div>	</td>
            </tr>
          </table>		</td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="top"><font color="#FF0000">(หมายเหตุ : จำนวนเป้าหมายการบันทึกจะกำหนดค่าไว้ก่อน )</font>&nbsp;&nbsp;ข้อมูล ณ วันที่ <?=thai_date($temp_dc);?></td>
        </tr>
    </table>--></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" >
         <thead>  
            <tr>
              <td colspan="16" align="center" bgcolor="#A3B2CC"><strong><?=ShowDateProfile($profile_id);?></strong></td>
            </tr>
            <tr>
              <th width="2%" rowspan="4" align="center" bgcolor="#A3B2CC"><strong>ที่</strong></th>
              <th width="14%" rowspan="4" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่การศึกษา</strong></th>
              <td width="7%" align="center" bgcolor="#A3B2CC"><strong>PDF<a href="report_pdf.php" target="_blank"><img src="images/yast_www.png" alt="คลิ๊กเพื่อดูหน้ารายงานตรวจสอบไฟล์ pdf" width="22" height="22" border="0"></a></strong></td>
              <th width="6%" rowspan="4" align="center" bgcolor="#A3B2CC"><strong>จำนวนรับรอง<br>
ข้อมูลโดยเขต</strong></th>
            <td colspan="10" align="center" bgcolor="#A3B2CC"><strong>รายงานการกรอกข้อมูล</strong></td>
            <th width="4%" rowspan="4" align="center" bgcolor="#A3B2CC"><strong>รอส่ง<br>
ออก</strong></th>
            <th width="4%" rowspan="4" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></th>
            </tr>
          <tr>
            <td width="7%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากร<br>
ทั้งหมด<br>
(คน/แผ่น)</strong></td>
            <td colspan="5" align="center" bgcolor="#A3B2CC"><strong>พนักงานจ้าง</strong></td>
            <td colspan="5" align="center" bgcolor="#A3B2CC"><strong>Outsource</strong></td>
            </tr>
          <tr>
            <th width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></th>
            <th width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รอ QC</strong></th>
            <th width="7%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คีย์แล้ว</strong></th>
            <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>กำลังดำเนินการ</strong></td>
            <th width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></th>
            <th width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รอ QC</strong></th>
            <th width="7%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คีย์แล้ว</strong></th>
            <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>กำลังดำเนินการ</strong></td>
            </tr>
          <tr>
            <th width="7%" align="center" bgcolor="#A3B2CC"><strong>ใบงานยังอยู่</strong></th>
            <th width="6%" align="center" bgcolor="#A3B2CC"><strong>ใบงานตกค้าง</strong></th>
            <th width="7%" align="center" bgcolor="#A3B2CC"><strong>ใบงานยังอยู่</strong></th>
            <th width="7%" align="center" bgcolor="#A3B2CC"><strong>ใบงานตกค้าง</strong></th>
            </tr>
             <thead>  
             	<tbody>   
			<?
				$arrnum1 = CountPersonAndFile($profile_id); // ข้อมูลจำนวนบุคลกรจำนวนไฟล์
				$arrnumc = CountKey($profile_id);/// ผลการตรวจข้อมูลการการคีย์ข้อมูล
				$arrb = CountPersonImp($profile_id);// นับรายการที่นำข้อมูลเข้าไปเรียบร้อยแล้ว
				$arrapp = count_person_approve(); // นับรายการ approve 
				//$sql_area = "SELECT * FROM eduarea  WHERE status_area53 = '1'  ORDER BY secname ASC";
				$sql_area = "SELECT eduarea.secid , eduarea.secname  FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id =  '$profile_id' order by eduarea.secname  ASC ";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				$j=0;
				while($rs_a = mysql_fetch_assoc($result_area)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  	
					$num_all = $arrnum1[$rs_a[secid]]['NumAll'];
					$num_page = $arrnum1[$rs_a[secid]]['NumPage'];
					$num_file = $arrnum1[$rs_a[secid]]['NumFileUpload'];
					$num_nofile = $arrnum1[$rs_a[secid]]['NumNotFile'];
					##  ผลการตรวจข้อมูลการการคีย์ข้อมูล
					//$arrnumc = CountKey($rs_a[secid]);
					## พนักงานชั่วคราว
					$NumTempPass = $arrnumc[$rs_a[secid]]['NumStaffTempQcPass'];
					$NumTempWait = $arrnumc[$rs_a[secid]]['NumStaffTempQcWait'];
					$NumTempProcess = $arrnumc[$rs_a[secid]]['NumStaffTempProcess'];
					$NumStaffTempKey = $arrnumc[$rs_a[secid]]['NumStaffTempKey'];
					$NumStaffTempWaitKey = $arrnumc[$rs_a[secid]]['NumStaffTempWaitKey'];
					$NumStaffTempOutKey = $arrnumc[$rs_a[secid]]['NumStaffTempOutKey'];
					##  Outsource
					$NumOutPass = $arrnumc[$rs_a[secid]]['NumOutsoreceQcPass'];
					$NumOutWait = $arrnumc[$rs_a[secid]]['NumOutsoreceQcWait'];
					$NumOutProcess = $arrnumc[$rs_a[secid]]['NumOutsoreceQcProcess'];
					$NumOutsoreceKey = $arrnumc[$rs_a[secid]]['NumOutsoreceKey'];
					$NumOutsoreceWaitKey = $arrnumc[$rs_a[secid]]['NumOutsoreceWaitKey'];
					$NumOutsoreceOutKey = $arrnumc[$rs_a[secid]]['NumOutsoreceOutKey'];
					
					## พนักงาน Sapphire
					$NumSapphirePass = $arrnumc[$rs_a[secid]]['NumSapphireQcPass'];
					$NumSapphireWait = $arrnumc[$rs_a[secid]]['NumSapphireQcWait'];
					$NumSapphireProcess = $arrnumc[$rs_a[secid]]['NumSapphireProcess'];
					$NumSapphireKey = $arrnumc[$rs_a[secid]]['NumSapphireKey'];
					$NumSapphireWaitKey = $arrnumc[$rs_a[secid]]['NumSapphireWaitKey'];
					$NumSapphireOutKey = $arrnumc[$rs_a[secid]]['NumSapphireOutKey'];
					

					$num_approve = $arrapp[$rs_a[secid]];
				  	if($num_approve > 0){
						$link_approve = "<a href='report_person_approve.php?xsecid=$rs_a[secid]&secname=$rs_a[secname]&profile_id=$profile_id' target='_blank'>".number_format($num_approve)."</a>";
					}else{
						$link_approve = "0";
					}
					$sum_num_approve += $num_approve;
					
					
					## ตรวจสอบกรณี ยังไม่ได้ import ข้อมูล checklist เข้าสู่ระบบ cmss
					if($num_all < 1){
//							$sql_checklist = "SELECT COUNT(tbl_checklist_kp7.idcard) AS NumAll, SUM(tbl_checklist_kp7.page_num) AS NumPage,
//SUM(if(tbl_checklist_kp7.page_upload > 0 and tbl_checklist_kp7.page_upload  IS NOT NULL,1,0)) AS NumFileUpload,
//SUM(if(tbl_checklist_kp7.page_upload < 1 OR tbl_checklist_kp7.page_upload  IS NULL,1,0)) AS NumNotFile
//FROM tbl_checklist_kp7  WHERE siteid='$rs_a[secid]' GROUP BY siteid";
//							$result_checklist = mysql_db_query("edubkk_checklist",$sql_checklist);
//							$rs_chk = mysql_fetch_assoc($result_checklist);
							$num_all = $arrb[$rs_a[secid]]['NumAll'];
							$num_page  = $arrb[$rs_a[secid]]['NumPage'];
							$num_file = $arrb[$rs_a[secid]]['NumFileUpload'];
							$glink = 0;	
					}else{
						$glink = 1;	
					}
					
					
					if($num_page > 0){
						$totalnum_all = number_format($num_all)."/".number_format($num_page);
					}else{
						$totalnum_all = 	number_format($num_all);
					}
					###  ไฟล์ที่คงเหลือ
					$num_nofile = $num_all-$num_file;
					
			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center" width="2%"><?=$j?></td>
            <td align="left" width="14%"><a href="?action=view&xsecid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>&profile_id=<?=$profile_id?>" target="_blank"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname])?></a></td>
            <td align="right" width="7%"><? echo $totalnum_all;?></td>
            <td align="right" width="6%"><?=$link_approve?></td>
            <td align="right" width="6%"><?  if($NumTempPass > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่ผ่านการตรวจสอบแล้ว[พนักงานจ้าง]&profile_id=$profile_id' target='_blank'>".number_format($NumTempPass)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="5%"><?  if($NumTempWait > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่รอการตรวจสอบแล้ว[พนักงานจ้าง]&profile_id=$profile_id' target='_blank'>".number_format($NumTempWait)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="7%"><? if($NumStaffTempKey > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่บันทึกแล้ว[พนักงานจ้าง]&profile_id=$profile_id' target='_blank'>".number_format($NumStaffTempKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="7%"><? if($NumStaffTempWaitKey > 0){ echo "<a href='report_flow_ticket.php?action=waitkey&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่ยังไม่ได้บันทึกข้อมูล(พนักงานยังทำงานอยู่)[พนักงานจ้าง]&profile_id=$profile_id' target='_blank'>".number_format($NumStaffTempWaitKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="6%"><? if($NumStaffTempOutKey > 0){ echo "<a href='report_flow_ticket.php?action=Outkey&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=รายงานข้อมูลที่ยังไม่ได้บันทึกข้อมูล(พนักงานลาออกไปแล้ว)[พนักงานจ้าง]&profile_id=$profile_id' target='_blank'>".number_format($NumStaffTempOutKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="5%"><?  if($NumOutPass > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่ผ่านการตรวจสอบแล้ว[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutPass)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="6%"><? if($NumOutWait > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่รอการตรวจสอบข้อมูล[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutWait)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="7%"><? if($NumOutsoreceKey > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่บันทึกข้อมูลแล้ว[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutsoreceKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="7%"><? if($NumOutsoreceWaitKey > 0){ echo "<a href='report_flow_ticket.php?action=waitkey&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่ยังไม่ได้บันทึกข้อมูล(พนักงานยังทำงานอยู่)[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutsoreceWaitKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="7%"><? if($NumOutsoreceOutKey > 0){ echo "<a href='report_flow_ticket.php?action=outkey&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=รายงานข้อมูลที่ยังไม่ได้บันทึกข้อมูล(พนักงานลากออกไปแล้ว)[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutsoreceOutKey)."</a>";}else{ echo "0";}?></td>
            <td align="right" width="4%"><? 
				$temp_n = $num_all-($NumTempPass+$NumTempWait+$NumTempProcess+$NumOutPass+$NumOutWait+$NumOutProcess+$NumSapphirePass+$NumSapphireWait+$NumSapphireProcess);
				if($temp_n > 0){
					if($glink > 0){
					echo "<a href='report_new.php?action=view&xsecid=$rs_a[secid]&secname=$rs_a[secname]&type_view=discount&xtitle=รายชื่อที่รอส่งออก&profile_id=$profile_id' target='_blank'>".number_format($temp_n)."</a>";
					}else{
						echo 	number_format($temp_n);
					}
				}else{
					echo "0";
				}
				
			?></td>
            <td align="right" width="4%"><? 
				$total1  = $num_all;
				echo number_format($total1);
			?></td>
          </tr>
		  <?
		  	$sumall1 += $num_all;
			$sumall2 += $num_file;
			$sumall3 += $num_nofile;
			$sumall4 += $NumTempPass;
			$sumall5 += $NumTempWait;
			$sumall6 += $NumStaffTempKey;
			$sumall6_1 += $NumStaffTempWaitKey;
			$sumall6_2 += $NumStaffTempOutKey;
			$sumall7 += $NumOutPass;
			$sumall8 += $NumOutWait;
			$sumall9 += $NumOutsoreceKey;
			$sumall9_1 += $NumOutsoreceWaitKey;
			$sumall9_2 += $NumOutsoreceOutKey;
			$sumall10 += $NumSapphirePass;
			$sumall11 += $NumSapphireWait;
			$sumall12 += $NumSapphireProcess;

		  
		  	}// end while(){
		  ?>
          </tbody>
          <tfoot>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>รวม </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sum_num_approve);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall4);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall5);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall6);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall6_1);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall6_2);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall7);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall8);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall9);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall9_1);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall9_2);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?
				$temp_sumall = $sumall1-($sumall4+$sumall5+$sumall6+$sumall6_1+$sumall6_2+$sumall7+$sumall8+$sumall9+$sumall9_1+$sumall9_2+$sumall10+$sumall11+$sumall12);
				echo number_format($temp_sumall);
			?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
          </tr>
          </tfoot>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
	$temp_key = ($sumall4+$sumall7+$sumall10);
	$total_ratio = number_format((($temp_key*100)/$sumall1),2);
	
	$temp_total1 = $sumall1/$date_total;
	//$temp_total2 = $temp_total1*$date_total_c;
	$temp_total2 = $sumall1 ;
	
	$alert_file = number_format(($temp_total2*100)/$sumall1,2);
	
	$dis_key = number_format($sumall1-$temp_key);
	$persen_k1 = number_format(($dis_key*100)/$temp_total2,2); // เปอร์เซ็นการบันทึก
	
//	echo " วันทั้งหมด==  ".$date_total."   วันปัจจุบัน ==  ".$date_total_c."  จำนวนชุดต่อวัน  $temp_total1 ==  ".$temp_total2." == ".$alert_file;
	//echo $total_ratio;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
/*document.getElementById("cockpit_area").innerHTML="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"310\" height=\"161\" align=\"middle\">       <param name=\"allowScriptAccess\" value=\"sameDomain\" />        <param name=\"movie\" value=\"../../images_sys/pocmanger_cockpit.swf?score=<?//=$total_ratio?>&showalert=<?//=$alert_file?>&showalertwindow=_self\" />        <param name=\"quality\" value=\"high\" />        <param name=\"bgcolor\" value=\"#ffffff\" />        <embed src=\"../../images_sys/pocmanger_cockpit.swf?score=<?//=$total_ratio?>&showalert=<?//=$alert_file?>&showalertwindow=_self\" quality=\"high\" bgcolor=\"#ffffff\" width=\"310\" height=\"161\" align=\"middle\" allowscriptaccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />      </object>	";
document.getElementById("sum_all").innerHTML="<?//=number_format($temp_total2)?>";
document.getElementById("sum_key").innerHTML="<?//=number_format($temp_key)?>";
document.getElementById("persent_key").innerHTML="<?//=$alert_file?>";
document.getElementById("dis_key").innerHTML="<?//=$dis_key?>";
document.getElementById("persen_k1").innerHTML="<?//=$persen_k1?>";
*///-->
</SCRIPT>


<?
	}//end if($action == ""){
	if($action == "view"){
		$arr_view = CountKey($profile_id);
		//$arr_view = CountKey($xsecid);
		//$arr_view1 = CountPersonAndFile($xsecid);
		$arr_view1 = CountPersonAndFile($profile_id);		
		$num_key_pass = $arr_view[$xsecid]['NumSapphireQcPass']+$arr_view[$xsecid]['NumStaffTempQcPass']+$arr_view[$xsecid]['NumOutsoreceQcPass'];
		$num_Nokey = $arr_view1[$xsecid]['NumAll']-$num_key_pass;
		$num_NotFile = $arr_view1[$xsecid]['NumNotFile'];
		
		
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><strong><?=$secname?></strong></td>
        </tr>
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
          <td width="15%" align="right"><? if($arr_view1[$xsecid]['NumAll'] > 0){?><a href="?action=view&type_view=all&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรทั้งหมด&profile_id=<?=$profile_id?>"><?=number_format($arr_view1[$xsecid]['NumAll']);?></a><? }else{ echo "0";}?></td>
          <td width="20%"><strong>คน</strong></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่บันทึกข้อมูลเสร็จ</strong></td>
          <td align="right"><? if($num_key_pass > 0){ ?> <a href="?action=view&type_view=key_pass&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่บันทึกข้อมูลเสร็จ&profile_id=<?=$profile_id?>"><?=$num_key_pass?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนที่ค้างตรวจสอบและรับรองความถูกต้อง</strong></td>
          <td align="right"><? if($num_Nokey > 0){ ?><a href="?action=view&type_view=key_dis&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=รายชื่อจำนวนบุคลากรที่ค้างบันทึก&profile_id=<?=$profile_id?>"><?=number_format($num_Nokey)?></a><? }else{ echo "0";}?></td>
          <td><strong>คน</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>จำนวนบุคลากรที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ</strong> </td>
          <td align="right"><? if($num_NotFile > 0){ echo "<a href='?action=view&type_view=null_kp7&xsecid=$xsecid&secname=$secname&xtitle=รายชื่อบุคคลที่ไม่มี ก.พ.7 ต้นฉบับ&profile_id=$profile_id'>".number_format($num_NotFile)."</a>";}else{ echo "0";}?></td>
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
                  <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="16%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>บัตรประจำตัวประชาชน</strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="14%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
                  <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>สถานะการบันทึกข้อมูล</strong></td>
                  </tr>
                <tr>
                  <td width="11%" align="center" bgcolor="#A3B2CC"><strong>บันทึกข้อมูลเสร็จ</strong></td>
                  <td width="12%" align="center" bgcolor="#A3B2CC"><strong>อยู่ระหว่างดำเนินการ</strong></td>
                  <td width="13%" align="center" bgcolor="#A3B2CC"><strong>กำลังดำเนินการโดย</strong></td>
                </tr>
				<?
if($type_view != ""){$type_view = $type_view;}else{ $type_view = "all";}
$db_site = STR_PREFIX_DB.$xsecid;
			
if($type_view == "all"){
$sql = "SELECT
t2.idcard,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.schoolname,
t2.position_now AS pos_now,
t3.position_now,
t1.siteid as secid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1 
Left Join
 ".DB_CHECKLIST.".tbl_check_data as t2 ON t1.idcard=t2.idcard and t2.profile_id='$profile_id'
Left Join $db_site.general as t3 ON t2.idcard = t3.idcard
WHERE
t1.siteid =  '$xsecid' AND t1.profile_id='$profile_id' GROUP BY t1.idcard
";
	
$result = mysql_db_query($db_site,$sql);	
}else if($type_view == "key_pass"){

$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t3.office as schoolname,
if(t3.id='$xsecid',1,0) as run_site,
t1.siteid as secid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Left Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard
and t1.siteid=t2.siteid and t2.profile_id='$profile_id'
left join  ".DB_MASTER.".allschool as t3 ON t1.schoolid=t3.id
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))
 and  
t1.profile_id =  '$profile_id' 
and (t2.approve='2')
and t1.siteid='$xsecid'
group by t1.idcard
order by run_site desc,t3.office asc";

$result = mysql_db_query($db_name,$sql);	

}else if($type_view == "key_dis"){
	
$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t3.office as schoolname,
if(t3.id='$xsecid',1,0) as run_site,
t1.siteid as secid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Left Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard
and t1.siteid=t2.siteid and t2.profile_id='$profile_id' and t2.approve='2'
left join  ".DB_MASTER.".allschool as t3 ON t1.schoolid=t3.id
WHERE
t1.profile_id =  '$profile_id' 
and t1.siteid='$xsecid'
and t2.idcard IS NULL
group by t1.idcard
order by run_site desc,t3.office asc";

$result = mysql_db_query($db_temp,$sql);
	//echo $sql;
}else if($type_view == "discount"){


$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t3.office as schoolname,
if(t3.id='$xsecid',1,0) as run_site,
t1.siteid as secid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Left Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard
and t1.siteid=t2.siteid and t2.profile_id='$profile_id' 
left join  ".DB_MASTER.".allschool as t3 ON t1.schoolid=t3.id
WHERE
t1.profile_id =  '$profile_id' 
and t1.siteid='$xsecid'
and t2.idcard IS NULL
group by t1.idcard
order by run_site desc,t3.office asc";
$result = mysql_db_query($db_temp,$sql);
//echo $sql."<br>";die;
}// end if($type_view == "discount"){
else if($type_view == "null_kp7"){

$sql  = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t3.office as schoolname,
t1.position_now,
if(t3.id='$xsecid',1,0) as run_site,
t1.siteid as secid
FROM
tbl_checklist_kp7 as t1
left Join tbl_check_data as t2 ON t1.idcard = t2.idcard
left join  ".DB_MASTER.".allschool as t3 ON t1.schoolid=t3.id
WHERE
t1.siteid =  '$xsecid' AND
(t1.page_upload IS NULL or t1.page_upload < 1) 
AND t1.profile_id='$profile_id'
AND t2.profile_id='$profile_id'
GROUP BY t1.idcard
order by run_site desc,t3.office asc
";
$result = mysql_db_query($db_temp,$sql);
}
//echo "$sql<br>";
	$arr_app = CheckApproveKey($xsecid); // ตรวจสอบว่ามีการรับรองข้อมูลหรือยัง
	$arr_ticket = search_ticket($xsecid);
		
		
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
			$status_approve = $arr_app[$rs[idcard]];
//		
//		$sql_check_approve = "SELECT approve FROM tbl_assign_key WHERE idcard='$rs[idcard]'";
//		$result_check_approve = mysql_db_query("edubkk_userentry",$sql_check_approve);
//		$rs_appv = mysql_fetch_assoc($result_check_approve);
//		
			if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			$path_imgtemp = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			if(is_file($path_imgtemp) and is_file($path_img)){
				$flag_file = "";	
			}else{
				$flag_file = "<img src=\"../../images_sys/question.gif\" width=\"18\" height=\"18\" border='0' title='ไฟล์ค้างเก่าจากโครงการปีที่แล้ว'>";	
			}
			
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>&nbsp;$flag_file";
					if($status_approve != "2"){
					$link_del = "  <img src=\"images/Cancel-2-32x32.png\" alt=\"คลิ๊กเพื่อกำหนดสถานะเอกสารไม่สมบูรณ์\" width=\"18\" height=\"18\" border=\"0\" onClick=\"return confirmDelete('pupup_kp7_fail.php?idcard=$rs[idcard]')\" style=\"cursor:hand\">";
					}else{
					$link_del = "";
					}
				}else{
					$link_del = "";
					$link_img = "<font color='red'>ไม่มีไฟล์ ก.พ.7 ต้นฉบับ</a>";
				}
		
		#####################  กรณี หน้ารายงานของคนที่รอส่งออก ###################
//		if(check_file_fail($rs[idcard],$xsecid) == 1){
//				$f_color1 = "<font color='red'>";
//				$f_color2 = "</font>";
//		}else{
//				$f_color1 = "";
//				$f_color2 = "";
//		}
		
		#############  กรณีหน่วยงานสักกัดเป็น ตัวเลเนื่องจากการนำเข้าผิด
//		if($rs[schoolname] > 0 or $rs[schoolname] == ""){
//			$xschoolname = $rs[pos_now];
//		}else{
//			$xschoolname = $rs[schoolname];
//		}
		#############  กรณีหน่วยงานสักกัดเป็น ตัวเลเนื่องจากการนำเข้าผิด
		$xschoolname = $rs[schoolname];
		?>

				     <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$m?></td>
                  <td align="left"><?=$f_color1?><?=$rs[idcard]?><?=$f_color2?>&nbsp;&nbsp;<?=$link_img?>&nbsp;<?=$link_del?> </td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="left"><?=$rs[position_now]?></td>
                  <td align="left"><?=$xschoolname?></td>
                  <td align="center">
				  <?
					if($status_approve == "2"){
						echo "ผ่าน";
					}
				  ?>				  </td>
                  <td align="center"><?
					if($status_approve  != "2"){
						echo "อยู่ระหว่างดำเนินการ";
					}
				  ?></td>
                  <td align="LEFT">
				  	<? if($rs_c1[num] > 0){ echo $arr_ticket[$rs[idcard]];}else{ echo search_null_ticket($rs[idcard]);}?>
				  </td>
                </tr>

				<?
					$status_approve = "";
				}//end 		while($rs = mysql_fetch_assoc($result)){
				?>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
 <?
 		echo "<br><center><font color='red'>หมายเหตุ: รหัสบัตรที่เป็นตัวหนังสือสีแดงคือรายการที่มีไฟล์ pdf แล้วแต่สถานไฟล์ต้นฉบับไม่สมบูรณ์</font><br>
<img src=\"../../images_sys/question.gif\" width=\"18\" height=\"18\" border='0' title='ไฟล์ค้างเก่า'> คือ เป็นไฟล์ค้างเก่าจากโครงการปีที่แล้ว</center>";
 	}//end if($action == "view"){
 ?>


<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ?>


</BODY>
</HTML>
