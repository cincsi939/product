<?php
session_start();
#START 
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_report";
$module_code 		= "report_person"; 
$process_id			= "report_person";
$VERSION 				= "1";
$BypassAPP 			= true;

//$_SESSION[secid];
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20091222.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-12-22 15:15
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20091222.001
	## Modified Detail :		ระบบรายงานข้อมูลประวัติการรับราชการ
	## Modified Date :		2009-12-22 15:15
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

include ("../libary/function.php");
include("../../../common/common_competency.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	
if($_SESSION['secid'] != "" and $_SESSION['secid'] != "edubkk_master"){
	$db_name = STR_PREFIX_DB.$_SESSION['secid'];	
}else if($_SESSION['temp_dbsite'] != ""){
	$db_name = $_SESSION['temp_dbsite'];
}else if($xsiteid != "" and $xsiteid != "edubkk_master"){
	$db_name = STR_PREFIX_DB.$xsiteid;
}else{
				echo "
					<script language=\"javascript\">
							alert(\"ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณาตรวจสอบอีกครั้ง\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
}//end if($_SESSION['secid'] != "" and $_SESSION['secid'] != "edubkk_master"){
	
if($_GET['debug'] == "on"){
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	echo $db_name;
	exit();
}	
	
##  ข้อมูลทั่วไป
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
$result_general = mysql_db_query($db_name,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT max(date) as maxdate FROM salary WHERE id='".$id."'";
$result_salary = mysql_db_query($db_name,$sql_salary);
$rs_salary = mysql_fetch_assoc($result_salary);


	//$arr1 = array("../../../../edubkk_image_file/6502/5650600015489_2524.jpg","../../../../edubkk_image_file/6502/5650600015489_2531.jpg","../../../../edubkk_image_file/6502/5650600015489_2538.jpg");
	$sql_pic = "SELECT * FROM general_pic WHERE id='$id' ORDER BY yy DESC";
	$resust_pic = mysql_db_query($db_name,$sql_pic);
	$num_pic = mysql_num_rows($resust_pic);
	$pathfile = "../../../../edubkk_image_file/$rsv[siteid]/";
	$i=0;
	while($rs_pic = mysql_fetch_assoc($resust_pic)){
		$arr1[$i] = $pathfile.$rs_pic[imgname];	
		$arr2[$i] = "ภาพ ปีพ.ศ.".$rs_pic[yy];
		$i++;
	}
?>
<html>
<head>

<title>ประวัติการรับราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script type="text/javascript" src="showimg/fadeslideshow.js"></script>

<style type="text/css">
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
a.pp:link, a.pp:visited, a.pp:active { color: #444444;	
	font-weight:normal;
	text-decoration: none}
a.pp:hover {
	text-decoration: underline;
	color: #444444;
}
.sub_head_td{
border-bottom:#5595CC 1px solid; 
border-top:#5595CC 1px solid;
height:25px;
padding-left:10px;
filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#F4F4F4', EndColorStr='#F4F4F4'); 

}
.style1 {border-bottom: #5595CC 1px solid; border-top: #5595CC 1px solid; height: 25px; padding-left: 10px; font-weight: bold; }
.headtable {
	font-size: 14px;
}

-->
</style>

<script type="text/javascript">
<? if($num_pic > 0){?>
var mygallery2=new fadeSlideShow({
	wrapperid: "fadeshow2", //ID of blank DIV on page to house Slideshow
	dimensions: [125, 180], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
	<?
	$i=0;
	$count1 = count($arr1);
	foreach($arr1 as $key1 => $val1){
		$i++;
		if($i < $count1){
	?>
	["<?=$val1?>", "", "", "<?=$arr2[$key1]?>"],
	<?
		}else{
	?>
	["<?=$val1?>", "", "", "<?=$arr2[$key1]?>"]
	<?
		}////end if($i < $count1){
	}//end 
	?>
		],
//	imagearray: [
//		["../edubkk_image_file/6502/5650600015489_2524.jpg", "", "", "รูปภาพ ปี 2524"],
//		["../edubkk_image_file/6502/5650600015489_2531.jpg", "", "", "รูปภาพ ปี 2531"],
//		["../edubkk_image_file/6502/5650600015489_2538.jpg", "", "", "รูปภาพ ปี 2538"] //<--no trailing comma after very last image element!
//	],
	

displaymode: {type:'manual', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "always",
	togglerid: "fadeshow2toggler"
})
<? } // end if($num_pic > 0){?>
</script>


</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3" id="subject_table">
  <tr>
    <td colspan="4" align="left" bgcolor="#A5B2CE" class="menuitem">แผนผังการรับราชการและการดำรงตำแหน่ง</td>
  </tr>
  </table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="20%" rowspan="9" align="left" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="76%" align="center" bgcolor="#FFFFFF"><? if($num_pic > 0){?>
              <div id="fadeshow2"></div>
              <div id="fadeshow2toggler" style="width:150px; text-align:center; margin-top:10px"> <a href="#" class="prev"><img src="../../../images_sys/arrow_left_blue.png" style="border-width:0"></a> <span class="status" style="margin:10px; font-weight:bold"></span> <a href="#" class="next"><img src="../../../images_sys/arrow_right_blue.png" style="border-width:0" /></a></div>
              <? }else{ echo "<img src=\"../../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border='0'>";}?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
        <td width="20%" bgcolor="#FFFFFF"><span class="headtable"><strong>ชื่อ &ndash; สกุล (ไทย)</strong></span></td>
    <td width="60%" colspan="2" align="left" bgcolor="#FFFFFF"><span class="headtable"><strong><? echo "$rsv[prename_th]$rsv[name_th]  $rsv[surname_th]";?></strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>ตำแหน่ง</strong></span></td>
    <td colspan="2" align="left" bgcolor="#FFFFFF">
      
      
      <span class="headtable"><strong>
      <?=$rsv[position_now]?>
      </strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>ระดับ</strong></span></td>
    <td colspan="2" align="left" bgcolor="#FFFFFF">
      
      
      <span class="headtable"><strong>
      <?
                    	if($rsv[level_id] != ""){
								echo ShowRadub($rsv[level_id]);
						}else{
							echo "$rsv[radub]";	
						}
					?>
      </strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>ที่อยู่ปัจจุบัน</strong></span></td>
    <td colspan="2" align="left" bgcolor="#FFFFFF">
      
      
      <span class="headtable"><strong>
      <?=$rsv[contact_add]?>
      </strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>วัน-เดือน-ปี เกิด</strong></span></td>
    <td align="left" bgcolor="#FFFFFF" colspan="2"><span class="headtable"><strong><? echo MakeDate($rsv[birthday]);?></strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>อายุราชการ ณ ปัจจุบัน</strong></span></td>
    <td align="left" bgcolor="#FFFFFF" colspan="2">
      
      
      <span class="headtable"><strong>
      <?
                    $diff  = dateLength($rsv[begindate]);
					if ($rsv[begindate] != ""){
						echo "".$diff[year]."&nbsp;ปี&nbsp;&nbsp;".$diff[month]."&nbsp;เดือน&nbsp;&nbsp;".$diff[day]."&nbsp;วัน";
					}else{
						echo "-";
					}
					
					?>
      </strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="headtable"><strong>หน่วยงาน</strong></span></td>
    <td align="left" bgcolor="#FFFFFF" colspan="2">
      
      
      <span class="headtable"><strong>
      <? 
					if($rsv[schoolid] != $rsv[siteid]){ $prearea = "โรงเรียน";}else{ $prearea = "";}
					echo $prearea."".ShowSchool($rsv[schoolid])." / ".ShowArea($rsv[siteid]);?>
      </strong></span></td>
  </tr>
    <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript">
	function setWH(w,h){
		document.getElementById('subject_table').width = w;
		document.getElementById('govPlan').width = w;
		document.getElementById('govPlan').height = h;
	}
</script>

	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="1000" height="1000" id="govPlan" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="govPlan.swf" /><param name="quality" value="high" /><param name="scale" value="noscale" /><param name="salign" value="lt" /><param name="wmode" value="gpu" /><param name="bgcolor" value="#ffffff" />	<embed src="govPlan.swf" quality="high" scale="noscale" salign="lt" wmode="gpu" bgcolor="#ffffff" width="1000" height="1000" name="govPlan" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
	</object>
</body>
</html>

