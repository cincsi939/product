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
if($xsiteid != ""){ $xsiteid = $xsiteid;}else{ $xsiteid = "5006";}; // กรณีทดสอบในเครื่อง

$edubkk_master = DB_MASTER ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("positionsql.inc.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$time_start = getmicrotime();



	
	$month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 

$getdepid = $depid ;

function show_xdate_thai($xdate){
	global $month;
	if($xdate != "" and $xdate != "0000-00-00" and $xdate != NULL){
			$arr_d = explode("-",$xdate);
				$show_d = intval($arr_d[2])." ".$month[intval($arr_d[1])]." ".$arr_d[0];
	}else{
			$show_d = "";
	}
	return $show_d;
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
	$sql_type = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  $xconW ";
	$result_type = mysql_db_query($db_site,$sql_type);
	$rs_t = mysql_fetch_assoc($result_type);
	return $rs_t[num1];
}



## function นับจำนวนบุคลากรแยกรายหน่วยงานแยกตามสายงาน
function count_person_area($xtype,$schoolid){

	global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	
		//echo $xconW;
		if($xtype != ""){
			$xconW = " AND ".find_groupstaff($xtype);
		}else{
			$xconW = " ";
		}

		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid'  $xconW ";
		//echo $sql_area;
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area($xtype,$schoolid){

function count_school($siteid){ // นับจำนวนโรงเรียน
global $dbnamemaster;
	$sql_count = "SELECT COUNT(id) AS NUM1 FROM 	allschool WHERE siteid='$siteid'";
	$result_count = mysql_db_query($dbnamemaster,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[NUM1]-1;
}

function count_person_sex($sex,$schoolid){ // นับจำนวนบุคลากรจำแนกตามหน่วยงานและเพศ

global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	
			if($sex == "m"){
				$xconW = " AND sex LIKE '%ชาย%'";
			}else if($sex == "f"){
				$xconW = " AND sex LIKE '%หญิง%'";
			}
		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid'  $xconW ";
		//echo $sql_area;
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area($xtype,$schoolid){

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
## function count_person_area($xtype,$schoolid){



function sum_line_postion($type_line,$sex){
	global $xsiteid;
	$db_site = STR_PREFIX_DB."$xsiteid";
		if($type_line == "1"){
				$conv =  " AND ( ".find_groupstaff(1)." OR ".find_groupstaff(2)." )";
		}else if($type_line == "2"){
				$conv = " AND  ( ".find_groupstaff(4)." OR ".find_groupstaff(5)." ) ";
		}else if($type_line == "3"){
			$conv = "  AND ( ".find_groupstaff(3)." )";
		}else if($type_line == "4"){
			$conv = " AND (".find_groupstaff(7)." ) ";
		}else if($type_line == "5"){
			$conv = " AND  ( ".find_groupstaff(6)." OR ".find_groupstaff(8)." ) ";
		}else{
			$conv = "";
		}
		
		$sql_sum = "SELECT COUNT(id) as num1 FROM general WHERE sex='$sex' $conv ";
		$result_sum = mysql_db_query($db_site,$sql_sum);
		$rs_s = mysql_fetch_assoc($result_sum);
		
		return $rs_s[num1];
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<title> จำนวนบุคลากร ราย สพท.</title>
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
<script language="javascript" src="../common/getdata.js"></script>
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

 
</script>
</head>
<body>
<?
//if ( $_POST[submit]  != ""){ 
//	$gositeid = str_replace("cmss.","",$frm_username) ; 
//	$localDB = STR_PREFIX_DB.  $gositeid ; 
//
//	$sql = " 
//	SELECT IP, intra_ip FROM  eduarea  
//	Inner Join area_info ON eduarea.area_id = area_info.area_id
//	WHERE `secid` LIKE '$loginid'  "; 
//	$result = mysql_db_query(DB_MASTER , $sql) ;  
//	$rs = mysql_fetch_assoc($result) ; 
//	$rshost = $rs[intra_ip] ; 
//
//
//	$sql = " SELECT * FROM `login` WHERE `username` LIKE '$frm_username' AND `pwd` LIKE '$frm_password'    ";
//	$result = mysql_db_query($localDB , $sql) ;  
//	echo mysql_error() ; 
//	$nm_row = @mysql_num_rows($result) ; 
//	if ($nm_row > 0 ){ 
//		$rs = mysql_fetch_assoc($result) ; 
//		$xsiteid = $rs[id] ; 
//#		echo "   <hr>    :::::::::::::::::  $xsiteid    ";
//
//	}else{
//		$errmsg = "  <br><br> <font color =red><b>ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง </b></font>  ";
//	}
	
//} ############ if ( $submit != ""){  

$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$loginid'  "; 
$result = mysql_db_query(DB_MASTER , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 

 
?>
 <?
$sql = " SELECT * FROM `eduarea` WHERE `secid` LIKE '%$xsiteid%'  " ; 
$result = mysql_query($sql) ; 
$rs  = mysql_fetch_assoc($result) ; 
$areaname = $rs[secname] ; 

//$select_area = " '5001', '5002' , '5003' , '5004', '5005', '5006'" ;   
//$arr_select = array( 5001 => '5001' , 5002 => '5002' , 5003 => '5003' , 5004 => '5004' , 5005 => '5005', 5006=>'5006' ) ; 
//
//$temp_xprovince = substr($xsiteid,0,2);
//
///*
//if ($arr_select[$xsiteid] == ""){ ########## ไม่เอาครู
//	$sql_tech = find_groupstaff(6)  ;  
//	$str_whereposition = "  NOT  $sql_tech  " ;
//}else{
//	$str_whereposition = "  1  " ;
//}   */   
//?>
 <?
//
//if ($arr_select[$xsiteid] == $xsiteid ){ ##########  สำหรับ เขตนำร่อง เกณฑ์ sum จาก general ที่ site เลย 
//	$str_whereposition = "  1  " ;
//	$act_dbname  = STR_PREFIX_DB. $xsiteid ;
//	$act_table  = "general"  ; 
//}else{  #### if ($arr_select[$xsiteid] != ""){ 
//	$sql_tech = find_groupstaff(6)  ;  
//	$str_whereposition = "  NOT  $sql_tech  " ;
//	$act_dbname  = "pty_master";	
//	$act_table  = "view_general"  ; 	
//}		########## END   สำหรับ เขตนำร่อง เกณฑ์ sum จาก general ที่ site เลย 
//	#------------------------------------------------------------------------------------------------------------
//	########Start เรียกดูข้อมูล ทุกกลุ่ม รวมทั้งครูด้วย ######### สำหรับเขตนำร่องเท่านั้น 
//	#-----------------------------------------------------------------------------------------------------------
//		$sql = " SELECT  Count(name_th) AS countnm , siteid,  schoolid 
//		FROM   $act_table   WHERE  siteid = $xsiteid   AND $str_whereposition    GROUP BY   schoolid    " ; 
//		//echo $sql;
//		$result = mysql_db_query($act_dbname  , $sql) ; 
//		echo mysql_error() ; 
//		while ($rs = mysql_fetch_assoc($result) ){
//			$runscid = $rs[schoolid] ; 
//			if ($runscid == ""){ $runscid  = "x" . $xsiteid  ; $runxscid  = "x" . $xsiteid  ;	}	
//			$arr_all[$runscid] = $rs[countnm] ; 
//		}  ############ while ($rs = mysql_fetch_assoc($result) ){ 	
//		//echo "<pre>";
//		//echo array_sum($arr_all);
//	$sql = " SELECT  Count(name_th) AS countnm , siteid,approve_status  , schoolid 
//	FROM   $act_table   WHERE  siteid  = $xsiteid  AND $str_whereposition    GROUP BY  schoolid ,  approve_status  " ;  
//	$result = mysql_db_query($act_dbname  , $sql) ; 
//	while ($rs = mysql_fetch_assoc($result) ){
//		$runscid = $rs[schoolid] ; 
//		$approve_status = $rs[approve_status] ; 
//		if ($runscid == ""){ $runscid  =   $xsiteid  ; $runxscid  =   $xsiteid  ;	}
//		$arr_test[$runscid] = "scid=".$runscid ."=" ; 
//		if (trim($approve_status) == ""){ 
//			$arr_waiting[$runscid] += $rs[countnm] ; 
//		}else{
//			$arr_approve[$runscid] += $rs[countnm] ; 
//		}
//	}  ############ while ($rs = mysql_fetch_assoc($result) ){ 
//
#------------------------------------------------------------------------------------------------------------
########END เรียกดูข้อมูล ทุกกลุ่ม รวมทั้งครูด้วย ######### สำหรับเขตนำร่องเท่านั้น 
#-----------------------------------------------------------------------------------------------------------

?>
 <?
#------------------------------------------------------------------------------------------------------------
########Start array gain 
#-----------------------------------------------------------------------------------------------------------
//
//// 50 คือรหัส 2 ตัวแรกของจังหวัดนำร่อง เชียงใหม่
//if ($arr_select[$xsiteid] == "" or $temp_xprovince != "50"){  ############ ไม่ใช่เขตนำร่อง
//	$alltarget = $val_gain  ; 
//}else{ ############ เป็นเขตนำ่ร่อง 
////echo "saddddddd";
//	$alltarget = array_sum($arr_all) ; 
//}
////echo $alltarget;
//#------------------------------------------------------------------------------------------------------------
//########END array gain 
//#-----------------------------------------------------------------------------------------------------------
//
//
//
//$allpercenaprove = @((100 *  @array_sum($arr_approve)) / ($alltarget) ) ; 
//$allpercenwaiting = @((100 *  @array_sum($arr_waiting)) / ($alltarget) ) ; 
//
//# echo " session secid ::::::::: ". $_SESSION[secid] ." ||||||===|       _SESSION reportsecid  " . $_SESSION[reportsecid] ; 
//?><?	 
//$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$xsiteid'  "; 
//$result1= mysql_db_query( DB_MASTER ,  $sql1);  
//$rs = mysql_fetch_assoc($result) ; 
//$rssecname  = $rs[secname] ; 
//
//?><? 
//
//$app_str = " AND approve_status ='approve'  "; 
//$noapp_str =  " AND (approve_status !='approve'   or approve_status is null )  "; 
//$arr_position = array(1=> "ผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา","รองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา","ศึกษานิเทศก์","ผู้อำนวยการโรงเรียน","รองผู้อำนวยการโรงเรียน","ครู" ,"บุคคลากรทางการศึกษาอื่นตามมาตรา 38 ค.(2) สังกัด สพท." ) ; 
//#########################	$area_head   ####### ผอ. สพท.	$area_head_approve   ####### ผอ. สพท.	
//$sql_posittion  = find_groupstaff(1) ;  
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_head_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $noapp_str"; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_head  = $arrtmp[0] ; 
//$std_area_head = $area_head_approve + $area_head  ; 
//#########################		2$area_voicehead    ## รอง. ผอ. สพท.		$area_voicehead_approve   # รอง. ผอ. สพท.	
//$sql_posittion  = find_groupstaff(2) ;  
//$sql="SELECT count( position_now )AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_voicehead_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now )AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $noapp_str "; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_voicehead   = $arrtmp[0] ; 
//$std_area_voicehead = $area_voicehead + $area_voicehead_approve ;
//#########################		3$area_eduadvice   ####### ศึกษานิเทศ	$area_eduadvice_approve   #######  ศึกษานิเทศ 
//$sql_posittion  = find_groupstaff(3) ;  
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_eduadvice_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $noapp_str"; 
//$arrtmp = query_array($act_dbname , $sql ) ; $area_eduadvice   = $arrtmp[0] ; 
//$std_area_eduadvice = $area_eduadvice + $area_eduadvice_approve ; 
//#########################		4$schead    ####### ผอ.รร.รายโรง	$schead_approve   ####### ผอ.รร.รายโรง
//$sql_posittion  = find_groupstaff(4) ;  
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $schead_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $noapp_str"; 
//$arrtmp = query_array($act_dbname , $sql ) ; $schead   = $arrtmp[0] ; 
//$std_sc = $schead +  $schead_approve  ; 
//#########################		5$scvoice  ### รองผอ.รร.รายโรง	$scvoice_approve ### รองผอ.รร.รายโรง
//$sql_posittion  = find_groupstaff(5) ;  
//$sql="SELECT count( position_now )AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $scvoice_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now )AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid  $noapp_str"; 
//$arrtmp = query_array($act_dbname , $sql ) ; $scvoice   = $arrtmp[0] ; 
//$std_scvoice = $scvoice +  $scvoice_approve  ; 
//#########################		6$scteach  ## ครู 	$scteach_approve  ### ครู 
//$sql_posittion  = find_groupstaff(6) ;  
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str" ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $scteach_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $noapp_str ";
//$arrtmp = query_array($act_dbname , $sql ) ; $scteach   = $arrtmp[0] ; 
//$std_teach  = $scteach +  $scteach_approve  ; 
//#########################		7$areastaff   ##  จนท เขต	$areastaff_approve  ### จนท เขต
//$sql_posittion  = find_groupstaff(7) ;  
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid = $xsiteid $app_str  " ; 
//$arrtmp = query_array($act_dbname , $sql ) ; $areastaff_approve = $arrtmp[0] ; 
//$sql="SELECT count( position_now ) AS countnm FROM $act_table WHERE $sql_posittion and siteid =$xsiteid $noapp_str"; 
//$arrtmp = query_array($act_dbname , $sql ) ; $areastaff   = $arrtmp[0] ; 
//$std_area_staff = $areastaff + $areastaff_approve ; 
//#######################  9 $areastaff ## สำหรับ กรณีไม่ระบุ
//$sql_posittion = find_groupstaff(9);
//$sql = "SELECT count(position_now) AS countnm FROM $act_table WHERE $sql_posittion AND siteid= $xsiteid $app_str";
//$arrtmp = query_array($act_dbname,$sql); $otherstaff_approve = $arrtmp[0];
//$sql = "SELECT count(position_now) AS countnm FROM  $act_table WHERE $sql_posittion AND siteid = $xsiteid $noapp_str";
//$arrtmp = query_array($act_dbname,$sql); $otherstaff = $arrtmp[0];
//$std_other = $otherstaff_approve + $otherstaff;
// #########################-----------------------------------------------------------------------------------------------
//if ( $arr_select[$xsiteid]  == "" or $temp_xprovince != "50"){  $scteach = 0 ; } 
//$std_staffobecarea =  $std_area_head +$std_area_voicehead +$std_area_eduadvice +$std_area_staff ; 
//$all_waiting = $area_head+$area_voicehead+$area_eduadvice+$schead+$scvoice+$scteach+$areastaff  ;  
//
//########################################################### Start  if  ไม่ใช่ เขต นำร่อง    
//
//if ( $arr_select[$xsiteid]  == "" or $temp_xprovince != "50"){  
//
//
//
//	 ################################################## Start ผู้บริหาร / เจ้าหน้าที่ในเขต ตามเกณฑ์ สำหรับ ทุกสพท.
//	$sql1= " 
//	SELECT  siteid,  areaname, sc_num, area_head, area_voicehead, area_eduadvice, area_staff
//	FROM `area_staffref`
//	WHERE `siteid` LIKE '$xsiteid'
//	";
//	$result1= mysql_query(  $sql1); 
//	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
//	while($rs1 = @mysql_fetch_assoc($result1)){	
//		$std_area_head =  $rs1[area_head] ; 
//		$std_area_voicehead =  $rs1[area_voicehead] ; 	
//		$std_area_eduadvice =  $rs1[area_eduadvice] ; 	
//		$std_area_staff =  $rs1[area_staff] ; 	
//		$val_gain  =  $std_area_head  + $std_area_voicehead + $std_area_eduadvice  + $std_area_staff  ;
//		$val_gainarea  =   $val_gain ; 
//	} ################################################## End ผู้บริหาร / เจ้าหน้าที่ในเขต ตามเกณฑ์
//	 ####################################################### Start จำนวน บุคลากรใน โรงเรียน ที่ต้องบันทึกข้อมูล
//		$sql1 = "  SELECT * FROM `allschool` WHERE `siteid` LIKE '$xsiteid'   	 "; 
//		$result1= mysql_query(  $sql1); 
//		$school_nm = mysql_num_rows($result1)  ; 
//		if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
//		while($rs1 = @mysql_fetch_assoc($result1)){	
//			$depid = $rs1[id] ; 
//			$arr_name[$depid]  =  $rs1[office] ;  	
//			$arr_voiceexe[$depid]  =  $rs1[voice_exe] ;  
//			$arr_schead[$depid]  =  $rs1[sc_head] ;  
//			$arr_all[$runscid] =  $rs1[voice_exe] + $rs1[sc_head] ;  
//		}
//		$std_sc = @array_sum($arr_schead ) ; 
//		$std_scvoice = @array_sum($arr_voiceexe ) ; 
//		$val_gain   = $val_gain + $std_sc  + $std_scvoice  ; 
//		$arr_all[$xsiteid] = $val_gainarea ; 
//	 ####################################################### END จำนวน บุคลากรใน โรงเรียน ที่ต้องบันทึกข้อมูล
//	########################################################### END   if  ไม่ใช่ เขต นำร่อง  } ######## END 
//     $alltarget = $val_gain ;	
//}else{
//     $alltarget = $std_staffobecarea +$std_sc +$std_scvoice +$std_teach+$std_other ;	 
//	 
//	
//} ########### if ( $arr_select[$xsiteid]  == ""){   
//
//$xxx = @array_sum($arr_approve)  ; 
//$allpercenaprove =  (  $xxx   /     $alltarget *100 ) ; 


//
//	$sum_h = count_type_position(1)+count_type_position(2); // สายบริหาร
//	$sum_h1 = count_type_position(4)+count_type_position(5); // สายงานบริหารสถานศึกษา
//	$sum_h2 = count_type_position(3) ;// สายงานนิเทศการศึกษา
//	$sum_h3 = count_type_position(7) ;// บุคคลากรทางการศึกษา 38 ค.(2)
//	$sum_h4 = count_type_position(6)+count_type_position(8) ;// สายงานการสอน
//	
//	// กราฟ
//$daylist ="สายงานบริหารการศึกษา;สายงานบริหารสถานศึกษา;สายงานนิเทศการศึกษา;บุคคลากรทางการศึกษา 38 ค.(2);สายงานการสอน";
//$data1 = $sum_h.";".$sum_h1.";".$sum_h2.";".$sum_h3.";".$sum_h4;
//
//$txt_title = " กราฟสถิติแสดงข้อมูลจำนวนบุคลากรแยกตามสายงาน";
//$graphurl = $graph_path . "?category=$daylist&data1=$data1&outputstyle=&numseries=1&seriesname=&graphtype=pie&graphstyle=epm_sf_003&title=$title&subtitle=";
////$w1= "700";   $h1="350"; 
//$w1= "300";   $h1="150"; 

############  ทั้งหมด
$sum_all_m = sum_line_postion("","ชาย");
$sum_all_f = sum_line_postion("","หญิง");
$sum_all = $sum_all_m+$sum_all_f;
################  สายบริหารสถานศึกษา
$sum_h1_m = sum_line_postion("1","ชาย");
$sum_h1_f = sum_line_postion("1","หญิง");
$sum_h1_all = $sum_h1_m+$sum_h1_f;
############  สายบริหารการศึกษา
$sum_h2_m = sum_line_postion("2","ชาย");
$sum_h2_f = sum_line_postion("2","หญิง");
$sum_h2_all = $sum_h2_m+$sum_h2_f;
##########  สายนิเทศ
$sum_h3_m = sum_line_postion("3","ชาย");
$sum_h3_f = sum_line_postion("3","หญิง");
$sum_h3_all = $sum_h3_m+$sum_h3_f;
##############  เจ้าหน้าที่ 38
$sum_h4_m = sum_line_postion("4","ชาย");
$sum_h4_f = sum_line_postion("4","หญิง");
$sum_h4_all = $sum_h4_m+$sum_h4_f;
############  ครู
$sum_h5_m = sum_line_postion("5","ชาย");
$sum_h5_f = sum_line_postion("5","หญิง");
$sum_h5_all = $sum_h5_m+$sum_h5_f;




?>
 <table width="100%" border="0" align="center">
   <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="2" align="left"><strong>
           <? //=$areaname?>
มีโรงเรียนในการกำกับดูแลจำนวน&nbsp;

<?=count_school($xsiteid);?>
&nbsp;โรง</strong></td>
         <td width="11%" align="center">&nbsp;</td>
       </tr>
       <tr>
         <td width="12%" align="center" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><!--<img src="../images_sys/maximize.gif" alt="แสดงกราฟขนาดใหญ่" width="18" height="18" class="fillcolor_loginleft2" style="cursor:hand" onClick="window.open('<?=$graphurl?>')">--></td>
          </tr>
    </table></td>
  </tr>
  <tr>
    <td>
<!--	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>" style="z-index:-9999">
<param name="movie" value="<?=$graphurl?>">
<param name="quality" value="high">
<param name="wmode" value="transparent">  
<embed src="<?=$graphurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$w1?>" height="<?=$h1?>"></embed>
</object>
--></td>
  </tr>
</table></td>
         <td width="77%" align="center"><table width="100%" border="0" cellpadding="3" cellspacing="1" id="exsum">
           <tr>
             <td width="43%" rowspan="2" bgcolor="#F3F3F3">&nbsp;</td>
             <td colspan="2" align="center" bgcolor="#F3F3F3"><strong>ชาย</strong></td>
             <td colspan="2" align="center" bgcolor="#F3F3F3"><strong>หญิง</strong></td>
             <td colspan="2" align="center" bgcolor="#F3F3F3"><strong>รวม</strong></td>
           </tr>
           <tr>
             <td width="11%" align="center" bgcolor="#F3F3F3"><strong>คน</strong></td>
             <td width="9%" align="center" bgcolor="#F3F3F3"><strong>(%)</strong></td>
             <td width="10%" align="center" bgcolor="#F3F3F3"><strong>คน</strong></td>
             <td width="10%" align="center" bgcolor="#F3F3F3"><strong>(%)</strong></td>
             <td width="8%" align="center" bgcolor="#F3F3F3"><strong>คน</strong></td>
             <td width="9%" align="center" bgcolor="#F3F3F3"><strong>(%)</strong></td>
           </tr>
           <tr>
             <td align="left"><strong>มีจำนวนบุคลากร (อัตราจริง) <br />
               ตามบัญชี จ.18 รวมทั้งสิ้น  </strong></td>
             <td align="center"><a href="?action=view_report&type_line=all&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_all_m)?></a></td>
             <td align="center"><?=@number_format(($sum_all_m*100)/$sum_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=all&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_all_f)?></a></td>
             <td align="center"><?=@number_format(($sum_all_f*100)/$sum_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=all&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_all)?></a></td>
             <td align="center"><?=@number_format(($sum_all*100)/$sum_all,2)?></td>
           </tr>
           <tr>
             <td align="left" bgcolor="#F9F9F9"><strong> - สายงานบริหารการศึกษา</strong></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=1&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h1_m)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h1_m*100)/$sum_h1_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=1&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h1_f)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h1_f*100)/$sum_h1_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=1&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h1_all)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h1_all*100)/$sum_h1_all,2)?></td>
           </tr>
           <tr>
             <td align="left"><strong> - สายงานบริหารสถานศึกษา</strong></td>
             <td align="center"><a href="?action=view_report&type_line=2&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h2_m)?></a></td>
             <td align="center"><?=number_format(($sum_h2_m*100)/$sum_h2_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=2&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h2_f)?></a></td>
             <td align="center"><?=number_format(($sum_h2_f*100)/$sum_h2_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=2&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h2_all)?></a></td>
             <td align="center"><?=number_format(($sum_h2_all*100)/$sum_h2_all,2)?></td>
           </tr>
           <tr>
             <td align="left" bgcolor="#F9F9F9"><strong> - สายงานนิเทศการศึกษา</strong></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=3&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h3_m)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h3_m*100)/$sum_h3_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=3&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h3_f)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h3_f*100)/$sum_h3_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=3&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h3_all)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h3_all*100)/$sum_h3_all,2)?></td>
           </tr>
           <tr>
             <td align="left"><strong> - บุคคลากรทางการศึกษา 38 ค.(2)</strong></td>
             <td align="center"><a href="?action=view_report&type_line=4&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h4_m)?></a></td>
             <td align="center"><?=number_format(($sum_h4_m*100)/$sum_h4_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=4&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h4_f)?></a></td>
             <td align="center"><?=number_format(($sum_h4_f*100)/$sum_h4_all,2)?></td>
             <td align="center"><a href="?action=view_report&type_line=4&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h4_all)?></a></td>
             <td align="center"><?=number_format(($sum_h4_all*100)/$sum_h4_all,2)?></td>
           </tr>
           <tr>
             <td align="left" bgcolor="#F9F9F9"><strong> - สายงานการสอน</strong></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=5&sex=m&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h5_m)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h5_m*100)/$sum_h5_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=5&sex=f&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h5_f)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h5_f*100)/$sum_h5_all,2)?></td>
             <td align="center" bgcolor="#F9F9F9"><a href="?action=view_report&type_line=5&sex=all&xsiteid=<?=$xsiteid?>"><?=number_format($sum_h5_all)?></a></td>
             <td align="center" bgcolor="#F9F9F9"><?=number_format(($sum_h5_all*100)/$sum_h5_all,2)?></td>
           </tr>
         </table></td>
         <td align="center"><? if($print_t == "Y"){ $xshow_img = "<img src=\"../images_sys/logo_kks.gif\" width=\"153\" height=\"144\" />";}else{ $xshow_img = "<img src=\"../images_sys/cmss_logo.gif\" width=\"130\" height=\"120\">";} echo $xshow_img;?></td>
       </tr>
       <tr>
         <td align="center">&nbsp;</td>
         <td colspan="2" align="right"></td>
        </tr>
       <tr>
         <td align="center">&nbsp;</td>
         <td colspan="2" align="right">&nbsp;</td>
       </tr>
       <tr>
         <td align="center">&nbsp;</td>
         <td colspan="2" align="right"><strong>
		 <?
		 if($print_t == "" ){
		 ?>
		 <a href="?print_t=Y&xsiteid=<?=$xsiteid?>" target="_blank"> <img src="../images_sys/print.gif" alt="แสดงหน้ารายงาน" width="21" height="20" border="0"></a>
		 <?
		 	}//end 	if($print_t == ){
		 ?>
		 รายงาน ณ วันที่
             <?=$nowdd?>
         </strong></td>
        </tr>
       <tr>
         <td align="center">&nbsp;</td>
         <td colspan="2" align="right">&nbsp;</td>
       </tr>
	   <?
if($action == "view_report"){
$img_asc  = "<img src='../images_sys/s_asc.png'  width='11' height='9' border='0'>  ";
$img_desc  = "<img src='../images_sys/s_desc.png'  width='11' height='9' border='0'>  ";
 
if ($xorder == 2 ){ 
	if($or_by2 == "asc"){
		$orderby = " position_now asc  ";
	$xorder2 = " $img_asc";
		$or_by2 = "desc";
	}else{
	$orderby = " position_now desc  ";
	$xorder2 = "$img_desc";
	$or_by2 = "asc";
	}
}else if ($xorder == 1 ){ 
	if($or_by1 == "asc"){
	$orderby = " trim(name_th) asc ";
	$xorder1 ="$img_asc  ";
	$or_by1 = "desc";
	}else{
	$orderby = " trim(name_th)  desc ";
	$xorder1 =" $img_desc";
	$or_by1 = "asc";
	}

}else if ($xorder == 3 ){ 
	if($or_by3 == "asc"){
	$orderby = " vitaya asc  ";
	$xorder3 = " $img_asc";
	$or_by3 = "desc";
	}else{
	$orderby = " vitaya desc  ";
	$xorder3 = " $img_desc";
	$or_by3 = "asc";
	}
}else if ($xorder == 4 ){ 
	if($or_by4 == "asc"){
	$orderby = " approve_status asc  ";
	$xorder4 =" $img_asc ";
	$or_by4 = "desc";

	}else{
	$orderby = " approve_status desc  ";
	$xorder4 ="$img_desc ";
	$or_by4 = "asc";
	}
}else if($xorder == "5"){

	if($or_by5 == "asc"){
	$orderby = "  salary asc ";
	$xorder5 =" $img_asc";
	$or_by5 = "desc";
	}else{
	$orderby = "  salary desc ";
	$xorder5 =" $img_desc  ";
		$or_by5 = "asc";
	}
	
}else if($xorder == "6"){

		if($or_by6 == "asc"){
		$orderby = "  birthday asc ";
		$xorder6 = " $img_asc ";
		$or_by6 = "desc";
		}else{
		$orderby = "  birthday desc ";
		$xorder6 = " $img_desc ";
		$or_by6 = "asc";
		}

	
}else if($xorder == "7"){
		if($or_by7 == "asc"){
				$orderby = "  begindate asc ";
				$xorder7 = " $img_asc ";
				$or_by7 = "desc";
		}else{
				$orderby = "  begindate desc ";
				$xorder7 = " $img_desc  ";
				$or_by7 = "asc";
		}
	
}else if($xorder == "id"){
			if($or_byid == "asc"){
				$orderby = "  id asc ";
				$xorderid = " $img_asc ";
				$or_byid = "desc";
		}else{
				$orderby = "  id desc ";
				$xorderid = " $img_desc  ";
				$or_byid = "asc";
		}	
}else{
	$orderby = " name_th ASC "; 	
} ##### END else if ($xorder == 1 ){ 

#####################  เงื่อนไขตามสายงาน
		if($type_line == "1"){
			$conv =  " AND ( ".find_groupstaff(1)." OR ".find_groupstaff(2)." )";
		}else if($type_line == "2"){
			$conv = " AND  ( ".find_groupstaff(4)." OR ".find_groupstaff(5)." ) ";
		}else if($type_line == "3"){
			$conv = "  AND ( ".find_groupstaff(3)." )";
		}else if($type_line == "4"){
			$conv = " AND (".find_groupstaff(7)." ) ";
		}else if($type_line == "5"){
			$conv = " AND  ( ".find_groupstaff(6)." OR ".find_groupstaff(8)." ) ";
		}else{
			$conv = "";
		}
		
		if($sex == "m"){
				$consex = " AND  sex='ชาย'";
		}else if($sex == "f"){
				$consex = " AND sex='หญิง'";
		}else{
				$consex = "";
		}
		$db_site = STR_PREFIX_DB."$xsiteid";

	   $sql_general = "SELECT * FROM general WHERE  id <> '' $conv $consex   order by  $orderby  ";
	 //  echo "$db_site<br>";
	   //echo $sql_general;
	   
	   ?>
       <tr>
         <td colspan="3" align="center"><table cellspacing="1" cellpadding="3" width="100%" align="center" bgcolor="#000000" border="0">
   <tbody>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"  >
       <td width="4%" >ลำดับ</td>
       <td width="11%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=id&or_byid=<?=$or_byid?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>" class="strong_black">รหัสบัตรประชาชน</a><?=$xorderid?></td>
       <td width="15%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=1&or_by1=<?=$or_by1?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>" class="strong_black">ชื่อ-นามสกุล</a>         <?=$xorder1?></td>
       <td width="12%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=2&or_by2=<?=$or_by2?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>">ตำแหน่ง</a>         <?=$xorder2?></td>
       <td width="11%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=3&or_by3=<?=$or_by3?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>">วิทยฐานะ</a>         <?=$xorder3?></td>
       <td width="9%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=5&or_by5=<?=$or_by5?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>">เงินเดือนปัจจุบัน<br /> 
       (บาท)<?=$xorder5?></a></td>
       <td width="9%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=6&or_by6=<?=$or_by6?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>">วันเดือนปีเกิด</a>    <?=$xorder6?></td>
       <td width="11%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=7&or_by7=<?=$or_by7?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>&action=<?=$action?>&type_line=<?=$type_line?>&sex=<?=$sex?>">วันเริ่มรับราชการ</a>  <?=$xorder7?></td>
       <td width="4%">v1</td>
       <td width="3%">v2</td>
       <td width="4%">v3</td>
       <td width="7%">กพ.7 <br /></td>
     </tr>
     <?

$result = mysql_db_query($db_site,$sql_general);
while ($rs = mysql_fetch_assoc($result)){  
	$nonm++; 
	if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
	
$urlpath = "../../edubkk_kp7file/$rs[siteid]/" . $rs[id] . ".pdf"  ;

		if ( is_file("$urlpath") ){ 
			$pdf_orig = " <a href='open_original_pdf.php?id=$rs[id]' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$pdf_orig = "";
		}
		
		 $xpdf		= "<a href=\"../application/hr3/hr_report/kp7.php?id=".$rs[id]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";

?>
     <tr   bgcolor="#<?=$bgcolor1?>"  align="center"    >
       <td ><?=$nonm?></td>
       <td align="left"><?=$rs[id]?></td>
       <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
       <td align="left"><?=$rs[position_now]?></td>
       <td align="center"><? if($rs[vitaya] != ""){ echo $rs[vitaya];}else{
	   
	   	$sql_vitaya="select * from vitaya_stat where id='$rs[id]' ORDER BY date_command DESC LIMIT 1";
								 $query_vitaya=@mysql_db_query($db_name,$sql_vitaya);
								$arr_vitaya=@mysql_fetch_assoc($query_vitaya);		
								echo $arr_vitaya[name];	
	   ?></td>
       <td align="center"><?=number_format($rs[salary])?></td>
       <td align="center"><?=show_xdate_thai($rs[birthday]);?></td>
       <td align="center"><?=show_xdate_thai($rs[begindate]);?></td>
       <td align="center"><? echo " <a href='../application/hr3/hr_report/report_data_general.php?xid=$rs[id]&action=edit' target='_blank'> <img src='../images_sys/doc_zoom.png' alt='แสดงข้อมูลสรุป general' width='16' height='16' border='0' /></a> "; ?></td>
       <td align="center"><? echo " <a href='../application/hr3/hr_report/report_data_view_general.php?xid=$rs[id]&action=edit' target='_blank'> <img src='../images_sys/doc_zoom.png' alt='แสดงข้อมูลสรุป view_general' width='16' height='16' border='0' /></a> "; ?></td>
       <td align="center"><? echo " <a href='../application/hr3/hr_report/report_data_view_general_master.php?xid=$rs[id]&action=edit' target='_blank'> <img src='../images_sys/doc_zoom.png' alt='แสดงข้อมูลสรุป view_general master' width='16' height='16' border='0' /></a> "; ?></td>
       <td align="center">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="54%" align="center"><?=$xpdf; ?></td>
		     <td width="46%" align="center">  <?=$pdf_orig?></td>
         </tr>
       </table></td>
     </tr>
     <?
} ## while ($rs = mysql_fetch_assoc($result)){ 

?>
   </tbody>
 </table></td>
        </tr>
<?
	}//end if($action == "view_report"){
?>
     </table></td>
   </tr>
</table>
 <blockquote>&nbsp;	</blockquote>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
