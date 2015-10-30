<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_percenentry_byarea";
$module_code 		= "percenentry_byarea"; 
$process_id			= "percenentry_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################
session_start() ; 
//echo "x1 == ".$xsiteid;
//if ($xsiteid == ""){ $xsiteid = $_SESSION[siteid]  ; } 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
$time_start = getmicrotime();
include("positionsql.inc.php");
include("percen_entry_v4.inc.php");


	$c_year = date("Y")+543;

$getdepid = $depid ;
$print_t =$_REQUEST[print_t]; 
$arr_area = array('3303','6502','6702','6301','8602','5101','7002','7103','7302','4802','5701','7203');
$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
$month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$dd = date("j")   ; 
$mm1 = date("n")  ; 
$mm =  $month[$mm1] ; 
$yy = date("Y") + 543 ; 
$nowdd = " $dd $mm  $yy "  ; 

$shour = (int)date("H")  ;
$sminute = (int)date("i")   ; 
$nowtime =  "   $shour:$sminute น.  "; 
$get_secid='$_SESSION[secid]' ;
if($Disp=="province" ){ 
 if($get_secid==""||!isset($get_secid)){
     $Disp="aumphur";  
     $xswap="1";       
 }
}
 ##################### หาชื่อสพท.
//if ($scid == ""){  	die ("กรุณาระบุรหัสสถานศึกษา") ; }
$sql = " SELECT * FROM `allschool` WHERE `id` LIKE '$scid' " ; 
$result = mysql_query($sql) ; 
$rs  = mysql_fetch_assoc($result) ; 
$scname = $rs[office] ; 
//$xsiteid = $rs[siteid] ; 

$arrtmp =  (explode("x" , $scid)) ; 
if ($arrtmp[1] != ""){ 
$xsiteid = $arrtmp[1]   ; 
$scid = ""; 
$where_area  = " AND siteid = $xsiteid ";
}
# echo $xsiteid ; 


$sql = " 
SELECT
secid,name_proth,office_ref,secname,provid 
area_name,IP,intra_ip
FROM  eduarea
Inner Join area_info ON eduarea.area_id = area_info.area_id
 WHERE `secid` LIKE '%$xsiteid%'  

  " ; 
$result = mysql_query($sql) ; 
$rs  = mysql_fetch_assoc($result) ; 
$areaname = $rs[secname] ; 
$cz_ip = $rs[IP] ; 


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



function count_type_position($xtype,$schoolid){ // บุคลากรจำแนกตามสายงาน
	global $xsiteid;
	$db_site = STR_PREFIX_DB.$xsiteid;
	$xconW = " ".find_groupstaff($xtype);
	$sql_type = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE schoolid='$schoolid' AND $xconW ";
	//echo $sql_type."<br>";
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
			$xconW = " AND (".find_groupstaff($xtype).")";
		}else{
			$xconW = " ";
		}
	if($sex == "m"){
		$xconv = " AND (sex LIKE '%ชาย%')";
	}else if($sex == "f"){
		$xconv = " AND (sex LIKE '%หญิง%')";
	}
		
		$sql_area = "SELECT COUNT(CZ_ID)  AS num1 FROM view_general WHERE  schoolid = '$schoolid' $xconv $xconW ";
		//echo $sql_area."<hr>";
		$result_area = @mysql_db_query($db_site,$sql_area);
		$rs_area = @mysql_fetch_assoc($result_area);
		return $rs_area[num1];
	//	$result_area = mysql_db_query($);
}
## function count_person_area($xtype,$schoolid){
###  function  ตรวจสอบ คนที่เราทำข้อมูลให้
function show_icon($get_idcard,$get_secid=""){
	$db_cal = DB_CHECKLIST;
	$sql_check_1 = "SELECT * FROM tbl_check_data WHERE idcard='$get_idcard'";
	$result_check_1 = @mysql_db_query($db_cal,$sql_check_1);
	$num_cdate = @mysql_num_rows($result_check_1);
	$rs_c1 = @mysql_fetch_assoc($result_check_1);
		if($num_cdate > 0){
			if($rs_c1[status_file_scan] == "1"){
				$s_img = "<font color='green'><b>*</b></font>";
			}else{
				$s_img = "<font color='#FFCC00'><b>!</b></font>";
			}
		}else{
			$s_img = "";
		}
		
	####  กรณีเป็นเชียงใหม่เขต 1-6 ในแสดงสีเขียวเลย
	$temp_get_secid = substr($get_secid,0,2);
	if($temp_get_secid == "50"){
		$s_img = "<font color='green'><b>*</b></font>";
	}else{
		$s_img = $s_img;
	}
	return $s_img;
}//end function show_icon($get_idcard){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<link href="pading.css" type="text/css" rel="stylesheet">
<title>รายงานจำนวนบุคลากร<?=$areaname?>  <?=$scname?></title>
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
A:link {
	FONT-SIZE: 12px;color: #000000;	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline ;FONT-WEIGHT: bold;
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline ;FONT-WEIGHT: bold;
}
.style2 {color: #009900}
-->
</style>
</head>
<body>

<?
switch ($xcol) {
case 2:
$where_str  =" AND approve_status != 'approve'   ";
    break;
case 3:
$where_str  =" AND approve_status = 'approve'  ";
    break;
default:
$where_str   =""; 
}
//echo "xsiteid :: $xsiteid<br>";
$areadb = STR_PREFIX_DB. $xsiteid ; 
$view_general  = STR_PREFIX_DB. $xsiteid .  ".view_general";
$edubkk_master = "edubkk_master";

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
	//$orderby = " $edubkk_master.vitaya.orderby asc  ";
	$xorder3 = " $img_asc";
	$or_by3 = "desc";
	}else{
	$orderby = " vitaya desc  ";
	//$orderby = " $edubkk_master.vitaya.orderby desc  ";
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
	$xorder5 =" $img_asc  ";
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
	
}else if($xorder == "8"){
		if($or_by8 == "asc"){
				$orderby = "  begindate asc ";
				$xorder8 = " $img_asc ";
				$or_by8 = "desc";
		}else{
				$orderby = "  begindate desc ";
				$xorder8 = " $img_desc  ";
				$or_by8 = "asc";
		}

}else if($xorder == "9"){
		if($or_by9 == "asc"){
				$orderby = "  birthday asc ";
				$xorder9 = " $img_asc ";
				$or_by9 = "desc";
		}else{
				$orderby = "  birthday desc ";
				$xorder9 = " $img_desc  ";
				$or_by9 = "asc";
		}

}else{
	$orderby = "  $edubkk_master.hr_addposition.orderby desc,$view_general.begindate asc,$view_general.vitaya desc "; 	
	//$orderby = "  $edubkk_master.hr_addposition.orderby desc,$view_general.vitaya desc "; 	
	//$view_general.salary DESC 
} ##### END else if ($xorder == 1 ){ 

//$sql = "
//SELECT  CZ_ID, siteid,prename_th,name_th,surname_th,position_now, orderby , approve_status ,salary  
//    , vitaya_stat.name  AS vitaya , birthday,begindate
//FROM  $view_general 
//Left Join $edubkk_master.hr_addposition ON $view_general.position_now = $edubkk_master.hr_addposition.`position`
//Left  Join  $areadb.vitaya_stat ON $view_general.id =   $areadb.vitaya_stat.id 
//
//WHERE  $view_general.schoolid =  '$scid' 
//$where_str  $where_area  
//order by  $orderby
//" ; 

$sql = "
SELECT CZ_ID, siteid,prename_th,name_th,surname_th,position_now, orderby , approve_status ,salary, vitaya  , birthday,begindate,
  TIMESTAMPDIFF(MONTH,begindate,'$c_year-09-30')/12 AS age_gov   
FROM  $view_general 
Left Join $edubkk_master.hr_addposition ON $view_general.position_now = $edubkk_master.hr_addposition.`position`

WHERE  ($view_general.sex =  ''  OR $view_general.sex IS NULL)
$where_str  $where_area  
order by  $orderby
" ; 
//Left Join $edubkk_master.vitaya ON   $view_general.vitaya = $edubkk_master.vitaya.vitayaname
//echo $sql;
$db_site = STR_PREFIX_DB."$xsiteid";
$result = mysql_db_query($db_site,$sql) ; 
while ($rs = mysql_fetch_assoc($result) ){
	$arr_d = explode("-",$rs[birthday]);
	$arr_d1 = explode("-",$rs[begindate]);
	$CZ_ID = $rs[CZ_ID] ; 
	$arr_name[$CZ_ID] =$rs[prename_th]  ."$rs[name_th]   $rs[surname_th]    " ;
	$arr_prename_th[$CZ_ID] = $rs[prename_th];
	$arr_name_th[$CZ_ID] = $rs[name_th];
	$arr_surname_th[$CZ_ID] = $rs[surname_th];
	$arr_positionnow[$CZ_ID] = " $rs[position_now]      " ;
	$arr_salary[$CZ_ID] = " $rs[salary]";
	$arr_birthday[$CZ_ID] = intval($arr_d[2])." ".$month[intval($arr_d[1])]." ".$arr_d[0];
	$arr_begindate[$CZ_ID] = intval($arr_d1[2])." ".$month[intval($arr_d1[1])]." ".$arr_d1[0];
	$arr_siteid[$CZ_ID] = $rs[siteid];
	$arr_begindate_val[$CZ_ID] = $rs[begindate];
	$arr_agegov[$CZ_ID] = floor($rs[age_gov]); // อายุราชการ
	$arr_date_retire[$CZ_ID] = xretireDate($rs[birthday]);// วันครบเกษียณอายุราชการ
	if ($rs[approve_status] ==  "approve"){ 
		$approve_nm++ ; 	$arr_appstatus[$CZ_ID] ="<img src=\"../images_sys/approve20.png\" border='0' alt='รับรองข้อมูลแล้ว'>";
	}else{ 
		$waiting_nm++; 	$arr_appstatus[$CZ_ID] ="<img src=\"../images_sys/unapprove.png\" border='0' alt='ยังไม่ได้รับรองข้อมูล'>";
	} ############### if ($rs[approve_status] ==  "approve"){ 
	$allnm++;
}  ############ while ($rs = mysql_fetch_assoc($result) ){ 

?>
<table width="99%" border="0" align="center">
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>	 
     <td class="strong_black">  </td>
   </tr>
</table>
 <table cellspacing="1" cellpadding="3" width="99%" align="center" bgcolor="#000000" border="0">
   <tbody>
     <tr   bgcolor="#a3b2cc"  class="strong_black" align="center"  >
       <td width="5%" >ลำดับ</td>
       <td width="17%">รหัสบัตร</td>
       <td width="17%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=1&or_by1=<?=$or_by1?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>" class="strong_black">ชื่อ-นามสกุล</a>         <?=$xorder1?></td>
       <td width="15%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=2&or_by2=<?=$or_by2?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">ตำแหน่ง</a>         <?=$xorder2?></td>
       <td width="11%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=3&or_by3=<?=$or_by3?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">วิทยฐานะ</a>         <?=$xorder3?></td>
       <td width="10%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=5&or_by5=<?=$or_by5?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">เงินเดือนปัจจุบัน<br /> 
       (บาท)<?=$xorder5?></a></td>
       <td width="11%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=6&or_by6=<?=$or_by6?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">วันเดือนปีเกิด</a>    <?=$xorder6?></td>
       <td width="10%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=7&or_by7=<?=$or_by7?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">วันเริ่มรับราชการ</a>  <?=$xorder7?></td>
       <td width="10%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=8&or_by8=<?=$or_by8?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">อายุราชการ(ปี)</a><?=$xorder8?></td>
       <td width="10%"><a href="?scid=<?=$scid?>&xcol=<?=$xcol?>&xorder=9&or_by9=<?=$or_by9?>&xsiteid=<?=$xsiteid?>&office=<?=$office?>">วันครบเกษียณ<br />
       อายุราชการ</a><?=$xorder9?></td>
       <!--       <td width="9%">login</td>-->
     </tr>
     <?

#reset($arr_name) ; 
while (list ($CZ_ID, $xname) = each($arr_name)) {
#while ($rs = mysql_fetch_assoc($result)){  
	$nonm++; 
	if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
	
$urlpath = "../../edubkk_kp7file/$arr_siteid[$CZ_ID]/" . $CZ_ID . ".pdf"  ;

		if ( is_file("$urlpath") ){ 
			$pdf_orig = " <a href='open_original_pdf.php?id=$CZ_ID&sentsiteid=$arr_siteid[$CZ_ID]' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$pdf_orig = "";
		}
		
		 $xpdf		= "<a href=\"../application/hr3/hr_report/kp7.php?id=".$CZ_ID."&sentsecid=".$arr_siteid[$CZ_ID]."\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";

?>
     <tr   bgcolor="#<?=$bgcolor1?>"  align="center"    >
       <td ><?=$nonm?></td>
       <td align="left"><?=$CZ_ID?></td>
       <td align="left">&nbsp;<?=$arr_name[$CZ_ID]?> </td>
       <td align="center"><?=$arr_positionnow[$CZ_ID]?></td>
       <td align="center"><?=$arr_vitaya[$CZ_ID]?></td>
       <td align="center"><?=number_format($arr_salary[$CZ_ID])?></td>
       <td align="center"><?=$arr_birthday[$CZ_ID]?></td>
       <td align="center"><?=$arr_begindate[$CZ_ID]?></td>
       <td align="center"><? 
	   	if($arr_agegov[$CZ_ID] == 0){ //กรณีอายุราชการยังไม่ถึงหนึ่งปี
			   $diff  = dateLength($arr_begindate_val[$CZ_ID]);			
                   	if ($arr_begindate_val[$CZ_ID] != ""){
						echo $diff[month]."&nbsp;เดือน";
					}
			}else{
					   echo $arr_agegov[$CZ_ID];
	   		}
	   
	   ?></td>
       <td align="center"><?=$arr_date_retire[$CZ_ID]?></td>
       <!--       <td align="center"><? //echo "<a href='login_data.php?name_th=$arr_name_th[$CZ_ID]&surname_th=$arr_surname_th[$CZ_ID]&idcard=$CZ_ID&action=login&siteid=$arr_siteid[$CZ_ID]' target='_blank'><img src='../images_sys/person.gif' width='16' height='13' border='0'></a>";?>
</td>-->
     </tr>
     <?
} ## while ($rs = mysql_fetch_assoc($result)){ 


?>
   </tbody>
 </table>

 <table width="99%" border="0" align="center" cellpadding="3" cellspacing="0">
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><em>หมายเหตุ : <span class="style2">*</span> เป็นข้อมูลที่ได้ถูกตรวจสอบความถูกต้องอ้างอิงจากเอกสารทะเบียนประวัติ ก.พ.7 ณ วันที่ 1 เมษายน 2552 แล้ว </em></td>
   </tr>
 </table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
