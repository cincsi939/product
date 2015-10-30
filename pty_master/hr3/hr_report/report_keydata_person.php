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


$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 
$db_site = STR_PREFIX_DB."$xsiteid";
//$profile_id = 1;




include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("../common/class.loadpage.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$edubkk_master = DB_MASTER ; 
$dbname_temp = DB_CHECKLIST;
$time_start = getmicrotime();


function GetTypeMenu($get_menu){
	global $dbname_temp;
	$sql_menu = "SELECT * FROM tbl_check_menu WHERE menu_id='$get_menu'";
	$result_menu = mysql_db_query($dbname_temp,$sql_menu);
	$rs_menu = mysql_fetch_assoc($result_menu);
	return $rs_menu[menu_detail];
}


function GetTypeProblem($get_problem){
global $dbname_temp;
	$sql_p = "SELECT * FROM tbl_problem WHERE problem_id='$get_problem'";
	$result_p = mysql_db_query($dbname_temp,$sql_p);
	$rs_p = mysql_fetch_assoc($result_p);
	return $rs_p[problem];
}

	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$month_s = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 
		$date_curent = intval(date("d"))." ".$month[intval(date("m"))]." ".(date("Y")+543);

$getdepid = $depid ;

function ShowDateThai($get_d){
	global $month_s;
		if($get_d != "" and $get_d != "0000-00-00"){
			$arr = explode("-",$get_d);
				return intval($arr[2])." ".$month_s[intval($arr[1])]." ".$arr[0];
		}else{
				return "";	
		}
}

function ShowDateThaiv1($get_d){
	global $month_s;
		if($get_d != "" and $get_d != "0000-00-00"){
			$arr = explode("-",$get_d);
				return intval($arr[2])." ".$month_s[intval($arr[1])]." ".($arr[0]+543);
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
	$db_site = STR_PREFIX_DB.$xsiteid;
	$xconW = " ".find_groupstaff($xtype);
	$sql_type = "SELECT COUNT(*)  AS num1 FROM view_general WHERE  $xconW ";
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

	$sql_count = "SELECT COUNT(*) AS NUM1 FROM allschool  WHERE siteid='$xsiteid'";
	$result_count = mysql_db_query($dbnamemaster,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[NUM1]-1;
}


function CountCheckList($xsiteid,$schoolid=""){
	global $profile_id,$type,$schoolid;
		$dbname_temp = "temp_check_data";

				if($schoolid == ""){
						$conG = " GROUP BY siteid";
				}else{
						$conG = "   AND schoolid='$schoolid' GROUP BY schoolid";
				}

		
		$sql = "SELECT
".DB_CHECKLIST.".tbl_checklist_kp7.schoolid,
".DB_CHECKLIST.".tbl_checklist_kp7.siteid,
Count(idcard) AS NumAll,
Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' and page_upload>0  ,1,0 )) as NumUpload, 
Sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and page_upload > 0 ,1,0)) as NumUpNomain,
Sum(if((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0'  and (page_upload IS NULL or page_upload='' or page_upload < 1)) or (status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and (page_upload IS NULL or page_upload='' or page_upload < 1))  ,1,0 )) as NumNoUpload,
Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ,1,0 )) as NumPass, 
Sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumDocFalse, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0' ,1,0)) as NumDis, 
sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse,
sum(if(status_numfile='1',1,0)) as numrevice


FROM
".DB_CHECKLIST.".tbl_checklist_kp7
WHERE  profile_id='$profile_id' AND ".DB_CHECKLIST.".tbl_checklist_kp7.siteid='$xsiteid'   $conG";
//echo $sql;die;

	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($schoolid != ""){
			$arr[$rs[schoolid]]['NumAll'] = $rs['NumAll'];
			$arr[$rs[schoolid]]['NumUpload'] = $rs['NumUpload'];
			$arr[$rs[schoolid]]['NumPass'] = $rs['NumPass'];
			$arr[$rs[schoolid]]['NumDis'] = $rs['NumDis'];
			$arr[$rs[schoolid]]['NumDocFalse'] = $rs['NumDocFalse'];
			$arr[$rs[schoolid]]['numidfalse'] = $rs['numidfalse'];
			$arr[$rs[schoolid]]['numnorecive'] = $rs['numnorecive'];
			$arr[$rs[schoolid]]['numnorecive_idfalse'] = $rs['numnorecive_idfalse'];
			$arr[$rs[schoolid]]['NumNoMain'] = $rs['NumNoMain'];
			$arr[$rs[schoolid]]['numrevice'] = $rs['numrevice'];
			$arr[$rs[schoolid]]['NumUpNomain'] = $rs['NumUpNomain'];
			$arr[$rs[schoolid]]['NumNoUpload'] = $rs['NumNoUpload'];
		}else{
			$arr['NumAll'] = $rs['NumAll'];
			$arr['NumUpload'] = $rs['NumUpload'];
			$arr['NumPass'] = $rs['NumPass'];
			$arr['NumDis'] = $rs['NumDis'];
			$arr['NumDocFalse'] = $rs['NumDocFalse'];
			$arr['numidfalse'] = $rs['numidfalse'];
			$arr['numnorecive'] = $rs['numnorecive'];
			$arr['numnorecive_idfalse'] = $rs['numnorecive_idfalse'];
			$arr['NumNoMain'] = $rs['NumNoMain'];	
			$arr['numrevice'] = $rs['numrevice'];
			$arr['NumUpNomain'] = $rs['NumUpNomain'];
			$arr['NumNoUpload'] = $rs['NumNoUpload'];
		
		}//end if($schoolid != ""){
			
	}
	return $arr;
}//end  function CountCheckList(){


function NumPersonKey($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = "temp_check_data";
		if($schoolid == ""){
				$conG = "  GROUP BY t1.siteid";
		}else{
				$conG = "  AND t1.schoolid='$schoolid' GROUP BY t1.schoolid";
		}
		
	$sql = "SELECT
t1.siteid,
t1.schoolid,
count(distinct t1.idcard) as numkey
FROM
".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard
AND t1.siteid = t2.siteid AND t1.profile_id=t2.profile_id
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) and 
t1.profile_id =  '$profile_id' AND
t2.approve =  '2' AND t1.siteid='$xsiteid'  $conG
";
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($schoolid != ""){
			$arr1[$rs[schoolid]]['numkey'] = $rs['numkey'];
		}else{
			$arr1['numkey'] = $rs['numkey'];	
		}
		
	}
	return $arr1;
}//

function NumPersonNonKey($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = "temp_check_data";
		if($schoolid == ""){
				$conG = "  GROUP BY t1.siteid";
		}else{
				$conG = "  AND t1.schoolid='$schoolid' GROUP BY t1.schoolid";
		}
		
	$sql = "SELECT
	t1.siteid,
t1.schoolid,
count(distinct t1.idcard) as numnonkey
FROM
".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Left Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard and t1.profile_id=t2.profile_id
AND t1.siteid = t2.siteid
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) and 
t1.profile_id =  '$profile_id'  AND t1.siteid='$xsiteid' 
AND (t2.approve='' or t2.approve IS NULL or t2.approve='0' or t2.approve='1' or t2.approve='3')
 $conG
";
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($schoolid != ""){
			$arr1[$rs[schoolid]]['numnonkey'] = $rs['numnonkey'];
		}else{
			$arr1['numnonkey'] = $rs['numnonkey'];	
		}
		
	}
	return $arr1;
}//function NumPersonNonKey($xsiteid,$schoolid){


function NumIDFalse($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = "temp_check_data";

		
	if($schoolid != ""){
			$conG = "  AND schoolid='$schoolid' GROUP BY schoolid";
	}else{
			$conG = "  GROUP BY siteid";	
	}
		$sql = "SELECT
		count(tbl_checklist_kp7_false.idcard) as num1,
		tbl_checklist_kp7_false.schoolid
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid' $conG";
//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	if($schoolid != ""){
		$arr[$rs[schoolid]]['idF'] = $rs[num1];
	}else{
		$arr['idF'] = $rs[num1];	
	}
			

}//end while($rs = mysql_fetch_assoc($result)){
	
	return $arr;
}//end function NumIDFalse(){


function ShowLableSchool($xsiteid){
		global $dbnamemaster;
		$sql = "SELECT id,office FROM allschool WHERE siteid='$xsiteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if($rs[id] != "$xsiteid"){
					$office = "โรงเรียน".$rs[office];
			}else{
					$office = $rs[office];	
			}
				$arr[$rs[id]] = $office;
		}
		return $arr;
}//end function ShowLableSchool($xsiteid){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<title>รายงานข้อมูลการยืนยันข้อมูล ของ สพท.</title>
<link href="../common/cssfixtable.css" rel="stylesheet" type="text/css">
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>

<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>

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
		$arrsite = CountCheckList($xsiteid,$schoolid);
		 $arrkey = NumPersonKey($xsiteid,$schoolid);	
		 $arrnonkey = NumPersonNonKey($xsiteid,$schoolid);
		 $arrIdF = NumIDFalse($xsiteid,$schoolid);
	

	
		if($schoolid == ""){
			$exsum_all = $arrsite['NumAll']+$arrIdF['idF'];// จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)
			$exsum_recive = $arrsite['numrevice'];// สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ
			$exsum_norecive  = $arrsite['numnorecive']; //เอกสารค้างรับจากเขต
			$exsum_checklist = $arrsite['NumPass']+$arrsite['NumDocFalse']+$arrsite['NumNoMain']+$arrsite['numidfalse'];// ตรวจสอบแล้ว
			$exsum_pass = $arrsite['NumPass'];// end  เอกสารสมบูรณ์
			$exsum_false = $arrsite['NumDocFalse']; // end  เอกสารไม่สมบูรณ
			$exsum_nopage = $arrsite['NumNoMain'];// end  ขาดเอกสารประกอบ
			$exsum_idfalse = $arrsite['numidfalse'];//end   เลขบัตรไม่สมบูรณ์ 
			$exsum_wait = $arrsite['NumDis'];//end อยู่ระหว่างตรวจสอบ
			$exsum_upload =  $arrsite['NumUpload'];//แฟ้มข้อมูลสแกนสำเนาเอกสาร กพ.7 ต้นฉบับ 
			$exsum_upload_nomain =  $arrsite['NumUpNomain'];
			$exsum_noupload = $arrsite['NumNoUpload']; //ยังไม่ได้ upload
			$exsum_key = $arrkey['numkey']; // ข้อมูลปฐมภูมิ
			$exsum_nonkey = $arrnonkey['numnonkey'];// ยังไม่ได้คีย์
			$idfalse = $arrIdF['idF'];
		}else{
			
			//echo "<pre>";
			//print_r($arrIdF);
			foreach($arrIdF as $k1 => $v1){
					$idfalse = $v1['idF'];
			}
			
			foreach($arrsite as $key => $val){
			
				$exsum_all += $val['NumAll'];
				$exsum_recive += $val['numrevice'];
				$exsum_norecive += $val['numnorecive'];
				$exsum_checklist += $val['NumPass']+$val['NumDocFalse']+$val['NumNoMain']+$val['numidfalse'];
				$exsum_pass += $val['NumPass'];
				$exsum_false += $val['NumDocFalse'];
				$exsum_nopage += $val['NumNoMain'];
				$exsum_idfalse += $val['numidfalse'];
				$exsum_wait += $val['NumDis'];
				$exsum_upload += $val['NumUpload'];
				$exsum_upload_nomain +=  $val['NumUpNomain'];
				$exsum_noupload += $val['NumNoUpload']; // ยังไม่ได้ upload
				$exsum_key += $val['numkey'];	
				$exsum_nonkey += $val['numnonkey'];// ยังไม่ได้คีย์
			}//end foreach($arrsite as $key => $val){
				
				
		}//end if($schoolid == ""){
			$exsum_idfalse = $exsum_idfalse+$idfalse;
			$exsum_all = $exsum_all+$idfalse;

//echo "id ::".$idfalse;


?>

<table width="100%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="2" align="left"><b><? if($schoolid == $xsiteid){ echo "<a href='report_keydata_main.php?profile_id=$profile_id'>กลับหน้าหลัก</a> :"; if($exsum_key > 0){  echo "<a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$areaname</a>";}else{ echo "$areaname";} echo ": $office";}else{ echo "<a href='report_keydata_main.php?profile_id=$profile_id'>กลับหน้าหลัก</a> :"; if($exsum_key > 0){ echo "<a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$areaname</a>";}else{ echo "$areaname"; } echo ": $office";}?></b></td>
         <td width="8%" align="center">&nbsp;</td>
       </tr>
       <tr>
         <td width="10%" rowspan="2" align="center" valign="top">&nbsp;</td>
         <td width="82%" align="center">

         <table width="90%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#DDDDDD"><table width="100%" border="0" cellspacing="1" cellpadding="3">
               <tr>
                 <td colspan="3" align="center" bgcolor="#CCCCCC">รายงานผลการจัดทำข้อมูลปฐมภูมิข้าราชการครูและบุคลากรทางการศึกษา
                   <? if($profile_id != ""){ echo ShowDateProfile($profile_id);}else{?>
                   (ข้อมูล ณ วันที่
                   <?=$DateNData?>
                   )
                   <? }?><? if($exsum_false > 0){ echo "<a href='../application/checklist_kp7_management/report_document_problem.php?xsiteid=$xsiteid&profile_id=$profile_id' target='_blank'>แสดงรายละเอียดปัญหา</a>";}?></td>
                 </tr>
               <tr>
                 <td width="56%" align="left" bgcolor="#FFFFFF">จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)</td>
                 <td width="20%" align="center" bgcolor="#FFFFFF"><? if($exsum_all > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=all&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_all)."</a>";}else{ echo "0";}?></td>
                 <td width="24%" align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_recive > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=numdoc&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_recive)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">เอกสารค้างรับจากเขต</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_norecive > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=diforg&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_norecive)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">ตรวจสอบแล้ว</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_checklist > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=numcheck&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_checklist)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เอกสารสมบูรณ์</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_pass > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=pass&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_pass)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เอกสารไม่สมบูรณ์</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_false > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=diforg1&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_false)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขาดเอกสารประกอบ</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_nopage > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=nopage&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_nopage)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขบัตรไม่สมบูรณ์</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_idfalse > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=idfalse&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_idfalse)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">อยู่ระหว่างตรวจสอบ</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_wait > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=numdis&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_wait)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">แฟ้มข้อมูลสแกนสำเนาเอกสาร ก.พ.7 ต้นฉบับ(สมบูรณ์)</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_upload > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=org&profile_id=$profile_id&schoolid=$schoolid&flag_uploadfalse=0'>".number_format($exsum_upload)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">แฟ้มข้อมูลสแกนสำเนาเอกสาร ก.พ.7 ต้นฉบับ(ขาดปก)</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_upload_nomain > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=org&profile_id=$profile_id&schoolid=$schoolid&flag_uploadfalse=1'>".number_format($exsum_upload_nomain)."</a>"; }else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">แฟ้มข้อมูลสแกนสำเนาเอกสาร ก.พ.7 ต้นฉบับ(ยังไม่ได้นำเข้าระบบ)</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_noupload > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=noupload&profile_id=$profile_id&schoolid=$schoolid&flag_uploadfalse=1'>".number_format($exsum_noupload)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">ข้อมูลปฐมภูมิ</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_key > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=keydata&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_key)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">ยังไม่ได้บันทึกข้อมูล</td>
                 <td align="center" bgcolor="#FFFFFF"><? if($exsum_nonkey > 0){ echo "<a href='?xsiteid=$xsiteid&secname=$secname&type=nonkeydata&profile_id=$profile_id&schoolid=$schoolid'>".number_format($exsum_nonkey)."</a>";}else{ echo "0";}?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
               </tr>
             </table></td>
           </tr>
         </table>
         </td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" align="right">รายงาน ณ. วันที่
          <?=$date_curent?></td>
        </tr>
     </table></td>
  </tr>
  <? 
  
  if($type == "all"){ $xtitle = "จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)";}
  if($type == "numdoc"){ $xtitle = "สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ";}
  if($type == "diforg"){ $xtitle = "เอกสารค้างรับจากเขต";}
  if($type == "numcheck"){ $xtitle = "ตรวจสอบแล้ว";}
  if($type == "pass"){ $xtitle = "เอกสารสมบูรณ์";}
  if($type == "diforg1"){ $xtitle = "เอกสารไม่สมบูรณ์ ";}
  if($type == "nopage"){ $xtitle = "ขาดเอกสารประกอบ";}
  if($type == "idfalse"){ $xtitle = "เลขบัตรไม่สมบูรณ์";}
  if($type == "numdis"){ $xtitle = "อยู่ระหว่างตรวจสอบ";}
  if($type == "noupload"){ $xtitle = "แฟ้มข้อมูลสแกนสำเนาเอกสารยังไม่ได้นำเข้าระบบ";}
  if($type == "org"){ 
  	if($flag_uploadfalse == "1"){
		$xtitle = "แฟ้มข้อมูลสแกนสำเนาเอกสารขาดปก";
	}else{
		$xtitle = "แฟ้มข้อมูลสแกนสำเนาเอกสารสมบูรณ์";	
	}
}//end if($type == "org"){ 
  if($type == "keydata"){ $xtitle = "ข้อมูลปฐมภูมิ";}
  if($type == "nonkeydata"){ $xtitle = "ยังไม่ได้บันทึกข้อมูล"; }
  
   if($type != "keydata" and $type != "diforg1" and $type != "nonkeydata"){  
   	$xcons = "7";
   }else{
	$xcons = "8";	  	 
  }
  
  
  if($type == "all_noarea"){
	 	 $xtitle = "จำนวนบุคลากรที่ยังไม่ได้ระบุหน่วยงานสังกัด";
	 }else{
		$xtitle = "จำนวนบุคลากรในหน่วยงาน"; 
	}
  
  ?>
</table>
      <table cellspacing="1" cellpadding="3" width="100%" align="center" bgcolor="#F5F5F5" border="0" class="tbl3">
   <tbody>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"     >
       <td colspan="<?=$xcons?>" bgcolor="#CCCCCC" ><strong><?=$xtitle?></strong></td>
     </tr>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"     >
       <td width="4%" bgcolor="#CCCCCC" >ลำดับ</td>
       <td width="11%" bgcolor="#CCCCCC">เลขบัตรประชาชน</td>
       <td width="12%" bgcolor="#CCCCCC">ชื่อ-นามสกุล</td>
       <td width="13%" bgcolor="#CCCCCC">ตำแหน่ง</td>
       <td width="13%" bgcolor="#CCCCCC">หน่วยงานสังกัด</td>
       <td width="15%" bgcolor="#CCCCCC">ประวัติ upload ไฟล์ต้นฉบับ</td>
       <? if($type == "keydata"){  ?>
       <td width="5%" bgcolor="#CCCCCC">ก.พ.7 ต้นฉบับ</td>
       <? }//end 
		else if($type == "org" and $flag_uploadfalse  == "0"){
			
			echo "<td width=\"5%\" bgcolor=\"#CCCCCC\">ไฟล์ ต้นฉบับ</td>";
			}
	   if($type == "diforg1"){  
	   ?>
       <td width="27%" bgcolor="#CCCCCC">รายการปัญหา</td>
       <? } //end  if($type == "diforg1"){   ?>
     </tr>
     <?
	 
	 $arroffice = ShowLableSchool($xsiteid);
	if($schoolid != ""){
			$conschool = " AND ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid='$schoolid'";
			$conschool_false = " AND ".DB_CHECKLIST.".tbl_checklist_kp7_false.schoolid='$schoolid'";
	}else{
			$conschool = "";	
			$conschool_false = "";
	}
	
	
if($type == "all"){
		$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid as schoolid,
tbl_checklist_kp7_false.status_school_fail as status_idfalse,
tbl_checklist_kp7_false.status_file,
'F' as status_check_file,
'' as mainpage
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid'  $conschool_false

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid as schoolid,
tbl_checklist_kp7.status_id_false as status_idfalse,
tbl_checklist_kp7.status_file,
tbl_checklist_kp7.status_check_file as status_check_file,
tbl_checklist_kp7.mainpage as mainpage
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND siteid='$xsiteid' $conschool
ORDER  BY schoolid ASC";
}else if($type == "numdoc"){
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE status_numfile='1' AND profile_id='$profile_id' AND siteid='$xsiteid' $conschool ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";	
}else if($type == "diforg"){
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE status_numfile='0' and status_id_false='0' AND profile_id='$profile_id' AND siteid='$xsiteid' $conschool  ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";	
}else if($type == "numcheck"){
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool  AND ((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0') OR (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0') OR (status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR (status_id_false='1' and status_numfile='1')) ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
		
}else if($type == "pass"){
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
}else if($type == "diforg1"){
		$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
		
}else if($type == "nopage"){
		$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
}else if($type == "idfalse"){
		$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid as schoolid,
tbl_checklist_kp7_false.status_school_fail as status_idfalse,
tbl_checklist_kp7_false.status_file,
'F' as status_check_file,
'' as mainpage
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid' $conschool

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid as schoolid,
tbl_checklist_kp7.status_id_false as status_idfalse,
tbl_checklist_kp7.status_file,
tbl_checklist_kp7.status_check_file as status_check_file,
tbl_checklist_kp7.mainpage as mainpage
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND tbl_checklist_kp7.status_id_false='1' AND siteid='$xsiteid' $conschool
ORDER  BY schoolid ASC ";
}else if($type == "numdis"){
		$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid as schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0' ORDER  BY schoolid ASC";
}else if($type == "org"){
	if($flag_uploadfalse == "1"){
			$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and page_upload > 0  ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
	}else{
		$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid' $conschool AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' and page_upload>0 ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
	}
 
}else if($type == "noupload"){
		$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.status_file
FROM `tbl_checklist_kp7`
 WHERE  profile_id='$profile_id' AND siteid='$xsiteid'  AND
((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0'  and (page_upload IS NULL or page_upload='' or page_upload < 1)) or (status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and (page_upload IS NULL or page_upload='' or page_upload < 1))) $conschool
  ORDER  BY ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid ASC";
 
}else if($type == "keydata"){
		$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid
FROM
".DB_CHECKLIST.".tbl_checklist_kp7 as t1
inner Join ".DB_USERENTRY.".view_kp7approve as t2 ON t1.idcard = t2.idcard
 AND t1.siteid = t2.siteid AND t1.profile_id=t2.profile_id
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) and
t1.profile_id =  '$profile_id' 
and t1.siteid='$xsiteid' $conschool  ORDER  BY t1.schoolid ASC";
}else if($type == "nonkeydata"){
	
$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid
FROM
".DB_CHECKLIST.".tbl_checklist_kp7 as t1
left Join ".DB_USERENTRY.".view_kp7approve as t2 ON t1.idcard = t2.idcard
 AND t1.siteid = t2.siteid AND t1.profile_id = t2.profile_id
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) and
t1.profile_id =  '$profile_id' 
and t2.idcard IS NULL
and t1.siteid='$xsiteid' $conschool  ORDER  BY t1.schoolid ASC";		
	
}else if($type == "all_org"){
	$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid as schoolid,
tbl_checklist_kp7_false.status_school_fail as status_idfalse,
tbl_checklist_kp7_false.status_file,
'F' as status_check_file,
'' as mainpage
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid'  $conschool_false

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid as schoolid,
tbl_checklist_kp7.status_id_false as status_idfalse,
tbl_checklist_kp7.status_file,
tbl_checklist_kp7.status_check_file as status_check_file,
tbl_checklist_kp7.mainpage as mainpage
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND siteid='$xsiteid' $conschool
ORDER  BY schoolid ASC";	
}else if($type == "all_noarea"){
	$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid as schoolid,
tbl_checklist_kp7_false.status_school_fail as status_idfalse,
tbl_checklist_kp7_false.status_file,
'F' as status_check_file,
'' as mainpage
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' AND siteid='$xsiteid'  and (".DB_CHECKLIST.".tbl_checklist_kp7_false.schoolid=0 or ".DB_CHECKLIST.".tbl_checklist_kp7_false.schoolid='' or ".DB_CHECKLIST.".tbl_checklist_kp7_false.schoolid IS NULL)

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid as schoolid,
tbl_checklist_kp7.status_id_false as status_idfalse,
tbl_checklist_kp7.status_file,
tbl_checklist_kp7.status_check_file as status_check_file,
tbl_checklist_kp7.mainpage as mainpage
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND siteid='$xsiteid' and (".DB_CHECKLIST.".tbl_checklist_kp7.schoolid=0 or ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid='' or ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid IS NULL)
ORDER  BY schoolid ASC";
		
}


$result = mysql_db_query($dbname_temp, $sql) ; 
//echo  $dbname_temp." ".$sql;
$i=0;
while ($rs = mysql_fetch_assoc($result)){  
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
/*	 	if($type == "org"){
			$fname = "../../edubkk_checklist_kp7file/$rs[siteid]/".$rs[idcard].".pdf"  ;
		}else{
	 		$fname = "../../edubkk_kp7file/$rs[siteid]/".$rs[idcard].".pdf"  ;
		}
*/		
	$fname = "../../edubkk_kp7file/$rs[siteid]/".$rs[idcard].".pdf"  ;
		//echo "::".file_exists($fname)."<br>"; 
	//	if($type == "org" and $flag_uploadfalse  == "0"){
		//echo "<a href='$fname' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a><br>";
	//	}//end 
	 if (is_file($fname)){ 
			$pdf_orig = " <a href='$fname' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$sql_pdf = "SELECT CZ_ID AS idcard,siteid FROM  view_general WHERE CZ_ID='$rs[idcard]'  ";
			$result_pdf = mysql_db_query($dbnamemaster,$sql_pdf);
			$rspdf = mysql_fetch_assoc($result_pdf);
			$fname1 = "../../edubkk_kp7file/$rspdf[siteid]/".$rs[idcard].".pdf"  ;
			if(is_file($fname1)){
				$sql_area = "SELECT secname FROM eduarea WHERE secid='$rspdf[siteid]'";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				$rsaa = mysql_fetch_assoc($result_area);
				$pdf = " <a href='$fname1' target='_blank'><img src='../images_sys/gpdf_tranfer.png' title='ก.พ.7 สำเนาจากต้นฉบับที่ย้ายไป ".$rsaa[secname]."' width='16' height='16' border='0'  /></a> " ; 
			}else{
				$pdf_orig = "";	
			}
		}

if($type == "keydata"){
 $xpdf	= "<a href=\"../application/hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\"   alt='ก.พ.7 สร้างโดยระบบ '  ></a>";
}//end if($type != "org"){
	
if($rs[status_check_file] == "F"){ // ยังไม่มีเอกสารเป็นเลขบัตรที่ไม่ถูกต้องและยังไม่ได้อยู่ในระบบ checklist
		$xfont = "<font color='#FF0000'>";
		$xfonte = "</font>";
}else{
		$xfont = "";
		$xfonte = "";
}

?>

     <tr   bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="center"><? echo "$xfont".$rs[idcard]."$xfonte"?></td>
       <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
       <td align="left"><? echo "$rs[position_now]";?></td>
       <td align="left"><? echo $arroffice[$rs[schoolid]];?></td>
       <? 
	   	####  ประวัติการ up ไฟล์ กรณีของกลุ่มเอกสารไม่สมบูรณ์
	 $sql_upfile = "SELECT * FROM tbl_checklist_log_uploadfile WHERE profile_id='$profile_id' AND idcard='$rs[idcard]' ORDER BY date_upload DESC";
	 //echo "$dbname_temp :: $sql_upfile";
	$result_upfile = mysql_db_query($dbname_temp,$sql_upfile);
	$num_upfile = @mysql_num_rows($result_upfile);
	   
	   
	   ?>
       <td align="center" valign="top"><? if($num_upfile < 1 and $pdf_orig != ""){ echo "$pdf_orig";}else{?><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
             <tr></tr>
           </table>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td>
                 <?
                 	if($num_upfile > 0){
				 ?>
                 <table width="100%" border="0" cellspacing="1" cellpadding="1">
                   <tr>
                     <td width="69%" align="center" bgcolor="#E2E2E2"><strong>วันที่ upload</strong></td>
                     <td width="31%" align="center" bgcolor="#E2E2E2">&nbsp;</td>
                   </tr>
                   <?
						$xj=0;
						while($rs_upfile = mysql_fetch_assoc($result_upfile)){
						if ($xj++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
							
			 		?>
                   <tr bgcolor="<?=$bg1?>">
                     <td align="center"><?=ShowDateThaiv1($rs_upfile[date_upload]);?></td>
                     <td align="center"><? echo "<a href='$rs_upfile[kp7file]' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> ";?></td>
                   </tr>
                   <?
						
						}//end 
			 		?>
                 </table>
                 <?
					}//end num_upfile
				 ?>
                 </td>
               </tr>
             </table>
             <table width="100%" border="0" cellspacing="1" cellpadding="1">
            </table></td>
         </tr>
       </table><? } //end if($num_upfile < 1){?></td>
       <? if($type == "keydata"){
		 ?>
       <td align="center"><? echo $pdf_orig."&nbsp;".$xpdf;?></td>
       <? }  if($type == "org" and $flag_uploadfalse  == "0"){
		  	 echo "<td align='center'>$pdf_orig</td>";
		  }//end if($type != "diforg1"){
		 	if($type == "diforg1"){  
		 ?>
       <td align="center">
           <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#E2E2E2"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#E2E2E2"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?
				if($rs[mainpage_comment] != ""){
							echo " <tr bgcolor=\"#FFFFFF\">
                <td align=\"left\">ปกเอกสาร ก.พ.7 ต้นฉบับ</td>
                <td align=\"left\">$rs[mainpage_comment]</td>
                </tr>";
					}

				
                	$sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'  AND status_problem = 0   ORDER BY menu_id,problem_id  ASC";
					$result_detail = mysql_db_query($dbname_temp,$sql_detail);
					$j=0;
					while($rs_d = mysql_fetch_assoc($result_detail)){
						if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
				?>
              <tr bgcolor="<?=$bg1?>">
                <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
                <td align="left"><?=$rs_d[problem_detail]?></td>
                </tr>
               <?
					}//end while(){
			   ?>
        </table> 
           </td>
           <? }//end if($type == "diforg1"){   ?>
     </tr>
<?

}//end while ($rs = mysql_fetch_assoc($result)){  
?>
   </tbody>
 </table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
