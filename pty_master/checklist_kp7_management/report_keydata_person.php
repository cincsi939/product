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

	$sql_count = "SELECT COUNT(*) AS NUM1 FROM allschool  WHERE siteid='$xsiteid'";
	$result_count = mysql_db_query($dbnamemaster,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[NUM1]-1;
}


function CountCheckList($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = DB_CHECKLIST;
//		if($type == ""  or $type == "all"){
//				$conv = " AND schoolid='$schoolid'";
//		}else{
//			
//				if($type == "diforg1"){
//					$conv = " AND status_check_file='YES' and status_file='0'";
//				}else if($type == "diforg"){
//					$conv = " AND status_check_file='NO'";
//				}else if($type == "org"){
//					$conv = " AND page_upload > 0";
//				}
//				
//					
//		}
				if($schoolid != ""){
						$conS = " AND schoolid='$schoolid'";
				}

		
		$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.schoolid,
Count(idcard) AS NumAll,
Sum(if(page_upload > 0,1,0)) AS NumUpload,
sum(if(status_file=1,1,0)) as NumPass,
Sum(if(status_check_file='NO',1,0)) as NumDis,
Sum(if(status_check_file='YES' and status_file=0,1,0)) AS NumDocFalse

FROM
edubkk_checklist.tbl_checklist_kp7
WHERE  profile_id='$profile_id' AND edubkk_checklist.tbl_checklist_kp7.siteid='$xsiteid' $conv  $conS  group by schoolid";

	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[schoolid]]['NumAll'] = $rs['NumAll'];
		$arr[$rs[schoolid]]['NumUpload'] = $rs['NumUpload'];
		$arr[$rs[schoolid]]['NumPass'] = $rs['NumPass'];
		$arr[$rs[schoolid]]['NumDis'] = $rs['NumDis'];
		$arr[$rs[schoolid]]['NumDocFalse'] = $rs['NumDocFalse'];
			
	}
	return $arr;
}//end  function CountCheckList(){


function NumPersonKey($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = DB_CHECKLIST;
//		if($type == ""  or $type == "all"){
//				$conv = " AND schoolid='$schoolid'";
//		}else{
//				if($type == "diforg1"){
//					$conv = " AND status_check_file='YES' and status_file='0'";
//				}else if($type == "diforg"){
//					$conv = " AND status_check_file='NO'";
//				}else if($type == "org"){
//					$conv = " AND page_upload > 0";
//				}
//				
//			
//					
//		}
		
			if($schoolid != ""){
						$conS = " AND schoolid='$schoolid'";
			}
	$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.schoolid,
count(edubkk_checklist.tbl_checklist_kp7.idcard) as numkey
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
AND edubkk_checklist.tbl_checklist_kp7.siteid = callcenter_entry.tbl_assign_key.siteid
WHERE
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
callcenter_entry.tbl_assign_key.nonactive =  '0' AND
callcenter_entry.tbl_assign_key.approve =  '2' AND edubkk_checklist.tbl_checklist_kp7.siteid='$xsiteid'  $conS group by schoolid
";
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[schoolid]]['numkey'] = $rs['numkey'];
	}
	return $arr1;
}//


function NumIDFalse($xsiteid,$schoolid){
	global $profile_id,$type,$schoolid;
		$dbname_temp = DB_CHECKLIST;
		if($type == ""  or $type == "all"){
				$conv = " AND schoolid='$schoolid'";
		}else{
				$conv = "";		
					if($schoolid != ""){
						$conS = " AND schoolid='$schoolid'";
				}
		}
		$sql = "SELECT
		count(tbl_checklist_kp7_false.idcard) as num1,
		tbl_checklist_kp7_false.schoolid
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' and siteid='$xsiteid' $conv $conS group by schoolid";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){

			$arr[$rs[schoolid]] = $rs[num1];

}//end while($rs = mysql_fetch_assoc($result)){
	
	return $arr;
}//end function NumIDFalse(){


function ShowLableSchool($xsiteid){
		global $dbnamemaster;
		$sql = "SELECT id,office,prefix_name FROM allschool WHERE siteid='$xsiteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){

				$arr[$rs[id]] = $rs[prefix_name].$rs[office];
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

		  $arrsite = CountCheckList($xsiteid,$schoolid);
		  //echo "<pre>";
		  //print_r($arrsite);
		 $arrkey = NumPersonKey($xsiteid,$schoolid);		
		 $arrIdF = NumIDFalse($xsiteid,$schoolid);
		 $exsum_idflase = array_sum($arrIdF,$schoolid); // จำนวนข้อมูลเลขบัตรไม่ถูกต้องทั้งหมด	
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

	####  ประวัติการ up ไฟล์ กรณีของกลุ่มเอกสารไม่สมบูรณ์
	 $sql_upfile = "SELECT * FROM tbl_checklist_log_uploadfile WHERE profile_id='$profile_id' AND idcard='$rs[idcard]' ORDER BY date_upload DESC";
	$result_upfile = mysql_db_query($dbname_temp,$sql_upfile);
	$num_upfile = @mysql_num_rows($result_upfile);
?>

<table width="100%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="2" align="left"><b><? if($schoolid == $xsiteid){ echo "<a href='report_keydata_main.php?profile_id=$profile_id'>กลับหน้าหลัก</a> > <a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$areaname</a> > $office";}else{ echo "<a href='report_keydata_main.php?profile_id=$profile_id'>กลับหน้าหลัก</a> > <a href='report_keydata_area.php?xsiteid=$xsiteid&secname=$secname&sys=$sys&type=$type&office=$office&profile_id=$profile_id'>$areaname</a> > $office";}?></b></td>
         <td width="8%" align="center">&nbsp;</td>
       </tr>
       <tr>
         <td width="10%" rowspan="2" align="center" valign="top">&nbsp;</td>
         <td width="82%" align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
               <tr>
                 <td colspan="3" align="center" bgcolor="#CCCCCC">รายงานผลการจัดทำข้อมูลปฐมภูมิข้าราชการครูและบุคลากรทางการศึกษา <? if($profile_id != ""){ echo ShowDateProfile($profile_id);}else{?>(ข้อมูล ณ วันที่ <?=$DateNData?>) <? }?></td>
               </tr>
               <tr>
                 <td width="50%" align="left" bgcolor="#FFFFFF">จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)</td>
                 <td width="14%" align="center" bgcolor="#FFFFFF"><?=number_format($exsum_all)?></td>
                 <td width="11%" align="center" bgcolor="#FFFFFF">คน</td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">สำเนาเอกสาร กพ.7 ต้นฉบับที่ได้รับจากเขตฯ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_doc)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">แฟ้มข้อมูลสแกนสำเนาเอกสาร กพ.7 ต้นฉบับ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_scan)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 </tr>
               <tr>
                 <td align="left" bgcolor="#FFFFFF">ข้อมูลปฐมภูมิ</td>
                 <td align="center" bgcolor="#FFFFFF"><?=number_format($exsum_key)?></td>
                 <td align="center" bgcolor="#FFFFFF">คน</td>
                 </tr>
             </table></td>
           </tr>
         </table></td>
         <td align="center">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" align="right">รายงาน ณ. วันที่
          <?=$date_curent?></td>
        </tr>
     </table></td>
  </tr>
</table>
      <table cellspacing="1" cellpadding="3" width="100%" align="center" bgcolor="#F5F5F5" border="0">
   <tbody>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"     >
       <td width="3%" bgcolor="#CCCCCC" >ลำ<br />
       ดับ</td>
       <td width="10%" bgcolor="#CCCCCC">เลขบัตรประชาชน</td>
       <td width="11%" bgcolor="#CCCCCC">ชื่อ-นามสกุล</td>
       <td width="12%" bgcolor="#CCCCCC">ตำแหน่ง</td>
       <td width="10%" bgcolor="#CCCCCC">วันเดือนปีเกิด</td>
       <td width="11%" bgcolor="#CCCCCC">หน่วยงานสังกัด</td>
       <? if($num_upfile > 0){ ?>
       <td width="14%" bgcolor="#CCCCCC">ประวัติ upload ไฟล์ต้นฉบับ</td>
       <? } //end if($num_upfile > 0){ ?>
       <? if($type != "diforg1"){  ?>
       <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
       <? }//end 
	   if($type == "diforg1"){  
	   ?>
       <td width="25%" bgcolor="#CCCCCC">รายการปัญหา</td>
       <? } //end  if($type == "diforg1"){   ?>
     </tr>
     <?
	 
	 $arroffice = ShowLableSchool($xsiteid);
	if($schoolid != ""){
			$conschool = " AND tbl_checklist_kp7.schoolid='$schoolid'";
	}else{
			$conschool = "";	
	}
if($type == "diforg1"){
	$sql = "SELECT * FROM tbl_checklist_kp7  Left Join $dbnamemaster.hr_addposition_now ON tbl_checklist_kp7.position_now = $dbnamemaster.hr_addposition_now.`position`  where siteid='$xsiteid'  and profile_id='$profile_id' AND status_check_file='YES' and status_file='0' $conschool ORDER BY  pid asc ";
}else if($type == "diforg"){
	$sql = "SELECT * FROM tbl_checklist_kp7  Left Join $dbnamemaster.hr_addposition_now ON tbl_checklist_kp7.position_now = $dbnamemaster.hr_addposition_now.`position`  where siteid='$xsiteid'  and profile_id='$profile_id' AND status_check_file='NO' $conschool ORDER BY  pid asc ";	
}else if($type == "org"){
	$sql = "SELECT * FROM tbl_checklist_kp7  Left Join $dbnamemaster.hr_addposition_now ON tbl_checklist_kp7.position_now = $dbnamemaster.hr_addposition_now.`position`  where siteid='$xsiteid'  and profile_id='$profile_id' AND page_upload > '0'  $conschool  ORDER BY  pid asc ";	
	
}else{
$sql = "SELECT * FROM tbl_checklist_kp7  Left Join $dbnamemaster.hr_addposition_now ON tbl_checklist_kp7.position_now = $dbnamemaster.hr_addposition_now.`position`  where siteid='$xsiteid'  and profile_id='$profile_id' AND schoolid='$schoolid' ORDER BY  pid asc ";
}
$result = mysql_db_query($dbname_temp, $sql) ; 
//echo $sql;
$i=0;
while ($rs = mysql_fetch_assoc($result)){  
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 	if($type == "org"){
			$urlpath = "../../".PATH_KP7_FILE."/$rs[siteid]/" . $rs[idcard] . ".pdf"  ;
		}else{
	 		$urlpath = "../../".PATH_KP7_FILE."/$rs[siteid]/" . $rs[idcard] . ".pdf"  ;
		}
	 if (is_file("$urlpath") ){ 
			$pdf_orig = " <a href='$urlpath' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$pdf_orig = "";
		}

if($type != "org"){
 $xpdf	= "<a href=\"../application/hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\"   alt='ก.พ.7 สร้างโดยระบบ '  ></a>";
}//end if($type != "org"){
	


?>

     <tr   bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="center"><? echo $rs[idcard]?></td>
       <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
       <td align="left"><? echo "$rs[position_now]";?></td>
       <td align="center"><? echo ShowDateThai($rs[birthday]);?></td>
       <td align="left"><? echo $arroffice[$rs[schoolid]];?></td>
       <? if($num_upfile > 0){ ?>
       <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
             <tr></tr>
           </table>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                   <tr>
                     <td width="74%" align="center" bgcolor="#E2E2E2"><strong>วันที่ upload</strong></td>
                     <td width="26%" align="center" bgcolor="#E2E2E2">&nbsp;</td>
                   </tr>
                   <?
						$xj=0;
						while($rs_upfile = mysql_fetch_assoc($result_upfile)){
						if ($xj++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
			 		?>
                   <tr bgcolor="<?=$xj?>">
                     <td align="left"><?=ShowDateThai($rs_upfile[date_upload]);?></td>
                     <td align="center"><? echo "<a href='$rs_upfile[kp7file]' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> ";?></td>
                   </tr>
                   <?
						}//end 
			 		?>
                 </table></td>
               </tr>
             </table>
             <table width="100%" border="0" cellspacing="1" cellpadding="1">
            </table></td>
         </tr>
       </table></td>
       <? }//end  if($num_upfile > 0){     $pdf_orig."&nbsp;".?>
       <? if($type != "diforg1"){?>
       <td align="center"><? echo $xpdf;?></td>
       <? }//end if($type != "diforg1"){
		 	if($type == "diforg1"){  
		 ?>
       <td align="center">
           <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#E2E2E2"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#E2E2E2"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?
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
