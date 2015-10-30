 <?
 	@session_start();
	$staff_idarray = array('10217','10357','10192','10169','10092');
if(in_array($_SESSION['session_staffid'],$staff_idarray)){
	$unlock_approve = 1;
}else{
	$unlock_approve = 0;	
}

if ($_SESSION[session_sapphire] == 1 ){
	if($_SESSION[session_staffid] == "11026"){ // สำหรับหัวหน้าวัชชัย
		$main_url = "../../report/report_keydata_main.php" ;
	}else{
		$main_url = "index_key_report.php" ;
	}
}else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}

if($_SESSION[session_staffid] == "11026"){
	$menu_group = array("หน้าหลัก"=>"$main_url,iframe_body","ออกจากระบบ"=>"logout.php,_top");
}else{
$menu_group = array("หน้าหลัก"=>"$main_url,iframe_body","ระบบค้นหาข้อมูล"=>"qsearch2.php,iframe_body","การจัดการข้อมูลระบบ"=>"","รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท."=>"","รายงานสำหรับผู้บริหาร"=>"","ทดสอบความเร็ว"=>"../diagnose/bandwidth/initialmeter.php,_blank","ตรวจสอบการนำเข้ารูป ก.พ.7"=>"../pic2cmss_entry_new/site_report.php?profile_id=4&direct_check=ON,_blank","ออกจากระบบ"=>"logout.php,_top");
}

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1  and $_SESSION[session_staffid] != "11026"){
	


/*$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank",
							 "เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../hr3/tool_competency/pic2cmss/_index.php","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),
*/
$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("กำหนดเปิดปิดระบบรับรองข้อมูล"=>"../req_approve/admin_sapphire/main_manager.php,_blank","ระบบปลดรับรองข้อมูลนับตัวรายโรงเรียน"=>"../raise_salary/unapprove_school/index.php,_blank","กำหนดสถานะการป้องกันข้อมูลการมอบหมายงาน"=>"assign_protection.php","ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank","เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank","รายงาน Download Excel ข้อมูล กบข."=>"../gpf_download/index_download.php,_blank"),


"รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท."=>array("รายงานจำนวนรายการที่ยังไม่ได้ปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile.php","รายงานตรวจสอบข้อมูลรูปราชการครูและบุคลาการทางการศึกษา"=>"report_check_data_image.php"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php","รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล"=>"report_keydata_error.php,_blank","รายงานคีย์ข้อมูลผู้บริหาร"=>"report_executive_area.php,_blank","รายงานพนักงานคีย์ข้อมูลบันทึกข้อมูล Sub ในเวลางาน"=>"report_check_userkeydata.php,_blank")

//"รายงานสรุปการบันทึกข้อมูล"=>"report_sum.php",
//"ประมวลผล Ranking "=>"ranking.inc.php",
);

if($_SESSION[session_staffid] != 64 and $_SESSION[session_staffid] != 72){
	unset($menu_array['รายงาน']['รายงานพนักงานคีย์ข้อมูลบันทึกข้อมูล Sub ในเวลางาน']);	
}



} else if($_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "QC_WORD"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","ระบบสุ่มตรวจสอบข้อมูล"=>"report_alert_qc1.php,_blank","เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin","รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล"=>"report_keydata_error.php,_blank","รายงานคีย์ข้อมูลผู้บริหาร"=>"report_executive_area.php,_blank")



);

	if($unlock_approve != "1"){ // กลุ่ม QC บางคนเท่านั้นที่เห็นเมนูนี้
		unset($menu_array['การจัดการข้อมูลระบบ']['เครื่องมือในการปลดรับรองข้อมูล']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php"),
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	//$menu_group = array("ระบบค้นหาข้อมูล"=>"qsearch2.php,iframe_body");
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array( "กำหนดเปิดปิดระบบรับรองข้อมูล"=>"../req_approve/admin_sapphire/main_manager.php,_blank","ระบบปลดรับรองข้อมูลนับตัวรายโรงเรียน"=>"../raise_salary/unapprove_school/index.php,_blank","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));
}else if($_SESSION[session_status_extra] == "site_area"){
	
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php"),
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("รายงานจำนวนรายการที่ยังไม่ได้ปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile.php","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin") );
	
}else{

$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php"),
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

unset($menu_group['ตรวจสอบการนำเข้ารูป ก.พ.7']);
}

if($_SESSION[session_staffid] != 93 AND $_SESSION[session_staffid] != 9948 AND $_SESSION[session_staffid] != 95 AND $_SESSION[session_staffid] != 57 AND $_SESSION[session_staffid] != 9974){
	unset($menu_array['รายงานจัดการผู้ใช้']);
}

if($_SESSION[session_staffid] == 10691){ // กรณีเป็น userของ ก.ค.ศ. ที่เข้ามาดูหน้ารายงาน
	unset($menu_group['การจัดการข้อมูลระบบ']);
	unset($menu_group['ระบบค้นหาข้อมูล']);
/*	"รายงาน"=>array("รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php")*/
	unset($menu_array['รายงานสถิติสำหรับผู้บริหาร']);
	unset($menu_array['การเข้างานลูกจ้างประจำ']);
	unset($menu_array['รายงานสถิติการตรวจข้อมูล']);

}


if($_SESSION[session_status_extra] == "QC_WORD"){
		unset($menu_array['การจัดการข้อมูลระบบ']['เครื่องมือในการปลดรับรองข้อมูล']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบมอบหมายงาน ก.พ.7']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบสุ่มตรวจสอบข้อมูล']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['รายงานจัดการผู้ใช้']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบร้องขอแจ้งแก้ไขข้อมูล']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานการเปลี่ยนเลขบัตร']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานคีย์ข้อมูลผู้บริหาร']);
}


 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<html>
<head>
<title>CMSS : Competency Management Supporting System</title>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
 
 
<style type="text/css"> 
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
 
<body>
 
 
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #398BCB">
  <tr>
    <td>
  <link rel="stylesheet" href="../kj_report/aussy/css/modal.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/style.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/rokbox-style.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/rokbox-style-ie8.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/template.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/header-style1.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/body-light.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/typography.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/menu-fusion.css" type="text/css" />
  <link rel="stylesheet" href="../kj_report/aussy/css/rokstories.css" type="text/css" />
  <style type="text/css">
    <!--
 
	div.wrapper { margin: 0 auto; width: 982px;padding:0;}
	body { min-width:982px;}
	#inset-block-left { width:0px;padding:0;}
	#inset-block-right { width:0px;padding:0;}
	#maincontent-block { margin-right:0px;margin-left:0px;}
	
	.s-c-s .colmid { left:0px;}
	.s-c-s .colright { margin-left:-280px;}
	.s-c-s .col1pad { margin-left:280px;}
	.s-c-s .col2 { left:280px;width:0px;}
	.s-c-s .col3 { width:280px;}
	
	.s-c-x .colright { left:0px;}
	.s-c-x .col1wrap { right:0px;}
	.s-c-x .col1 { margin-left:0px;}
	.s-c-x .col2 { right:0px;width:0px;}
	
	.x-c-s .colright { margin-left:-280px;}
	.x-c-s .col1 { margin-left:280px;}
	.x-c-s .col3 { left:280px;width:280px;}
    -->
#Layer1 {
	position:absolute;
	left:0px;
	top:66px;
	width:100%;
	height:17px;
	z-index:1;
	text-align:right;
	bottom:
	padding-right:3;
}
  </style>
  
  
<script type="text/javascript" src="../kj_report/aussy/js/mootools.js"></script>
  <script type="text/javascript" src="../kj_report/aussy/js/modal.js"></script>
  <script type="text/javascript" src="../kj_report/aussy/js/fusion.js"></script>
  <script type="text/javascript" src="../kj_report/aussy/js/rokfonts.js"></script>
  <script type="text/javascript" src="../kj_report/aussy/js/rokutils.js"></script>
  <script type="text/javascript" src="../kj_report/aussy/js/rokstories.js"></script>
  <script src="../../common/WindowSize.js"></script>
  <script type="text/javascript">
  function resize_window(){
var theFrame = document.getElementById('iframe_body');
var winsize=GetWindowSize();
theFrame.height=winsize.Height -125;
  }
  
	window.addEvent('domready', function() {
		resize_window();								 
		SqueezeBox.initialize({});
 
		$$('a.modal').each(function(el) {
			el.addEvent('click', function(e) {
				new Event(e).stop();
				SqueezeBox.fromElement(el);
			});
		});
	});
	
	window.addEvent('domready', function() {
		new Fusion('ul.menutop', {
			pill: 1,
			effect: 'slide',
			opacity: 1,
			hideDelay: 500,
			tweakInitial: {'x': -20, 'y': 6},
			tweakSubsequent: {'x': -12, 'y': -14},
			menuFx: {duration: 400, transition: Fx.Transitions.Quint.easeOut},
			pillFx: {duration: 400, transition: Fx.Transitions.Quint.easeOut}
		});
	});
	
	window.addEvent('domready', function() {
		var modules = ['side-mod', 'showcase-panel', 'moduletable', 'article-rel-wrapper'];
		var header = ['h3','h2','h1'];
		RokBuildSpans(modules, header);
	});
	
	
  </script>
 
<link href="../kj_report/aussy/css/ie7.css" rel="stylesheet" type="text/css" />
<link href="../kj_report/aussy/css/template_ie7.css" rel="stylesheet" type="text/css" />	
 
 
	<div id="ff-optima" class="f-default style1 body-light head-style1  iehandle" style="background:url(../kj_report/images/braner/banner.jpg) 0 0 no-repeat; height:90px">
	<!--Begin Header-->
	<div id="header-bg" style="float:right;">
		<!--Begin Horizontal Menu-->
				<div id="horiz-menu" class="fusion">
			<div class="wrapper">
				<div class="padding">
					<div id="horizmenu-surround">
											<ul class="menutop level1" >
<LI class="item3 parent   root"  >
<a href='#'    class="daddy item bullet " ><span>รายงานและการค้นหา</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='../../report/report_follow_kp7.php'  target='iframe_body'  ><span>รายงานแสดงจำนวนการมอบหมายงานและเอกสารคงค้าง</span></a>
</LI>
                   <LI  class="item3 ">
            <a  class="orphan item bullet"  href='search_kp7_destroy.php'  target='iframe_body'  ><span>ค้นหาเพื่อตรวจสอบสถานะก่อนทำงานเอกสาร ก.พ.7</span></a>
</LI>

            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='report_assign_index.php'  target='iframe_body'  ><span>รายงานการมอบหมายงานเอกสาร ก.พ.7</span></a>
</LI>
                        <LI  class="item3 "><a  class="orphan item bullet"  href='report_scan.php'  target='iframe_body'  ><span>รายงานการแสกนไฟล์ pdf ต้นฉบับ</span></a>
</LI>
 <LI  class="item3 "><a  class="orphan item bullet"  href='report_scan_false.php'  target='iframe_body'  ><span>รายงานการสแกนไฟล์(กรณีเอกสารไม่สมบูรณ์)</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='search_school.php'  target='iframe_body'  ><span>ค้นหาเพื่อตรวจสอบชื่อโรงเรียน</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_idfalse.php'  target='iframe_body'  ><span>รายงานข้อมูลเลขบัตรที่ไม่ถูกต้องกรมการปกครอง(ค้างแก้ไข)</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='main_report.php'  target='iframe_body'  ><span>รายงานสรุปภาพรวม</span></a></LI>
<? 	if($_SESSION['session_sapphire'] == "1"){ ?>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_viewexecutive.php'  target='_blank'  ><span>รายงาน executive สำหรับ senior</span></a></LI>
<?
}//end 	if($_SESSION['session_sapphire'] == "1"){
if($_SESSION['session_staffid'] == "10088"){ // สำหรับคุณกัมปนาท
?>	
<LI  class="item3 "><a  class="orphan item bullet"  href='report_link_viewexecutive.php?lv=1'  target='iframe_body'  ><span>รายการการเข้าดูรายงานสำหรับผู้บริหาร</span></a></LI>
<?   
}
?>
<LI  class="item3 "><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_change_idcard.php?get_type=1'  target='iframe_body'  ><span>รายงานการเปลี่ยนเลขบัตร</span></a></LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_diffassignkey.php'  target='iframe_body'  ><span>รายงานจำนวนคงค้างที่ไม่ได้มอบหมายงานให้กับพนักงานคีย์ข้อมูลจากจำนวนการมอบหมายเอกสารจากทีม checklist</span></a></LI>

<LI  class="item3 "><a  class="orphan item bullet"  href='report_compare_checklist_log.php'  target='iframe_body'  ><span>รายงานเทียบจำนวนรูป ก.พ.7 จาก checklist , log และ ในระบบ cmss</span></a>
</LI>
</ul>
</div></LI>
<LI class="item4 parent   root"  ><a href='#'    class="daddy item bullet " ><span>จัดการข้อมูล</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item4 "><a  class="orphan item bullet"  href='check_kp7_index.php'  target='iframe_body'  ><span>ตรวจสอบเอกสาร ก.พ.7</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_area.php'  target='iframe_body'  ><span>ค้นหาบุคลากรเพื่อบันทึกการผลการตรวจสอบเอกสาร</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='assign_management.php'  target='iframe_body'  ><span>มอบหมายงานสแกนเอกสาร</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile.php'  target='iframe_body'  ><span>นำเข้าข้อมูลตั้งต้น</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile_detail.php'  target='iframe_body'  ><span>สถานะการติดตามเอกสาร</span></a>
</LI>

<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_check.php'  target='iframe_body'  ><span>ข้อมูลบุคลากรที่ถูกตรวจสอบ</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_num_check.php'  target='iframe_body'  ><span>ข้อมูลพนักงานที่ตรวจสอบข้อมูล</span></a>
</LI>

<LI  class="item4 "><a  class="orphan item bullet"  href='form_lock_area.php'  target='iframe_body'  ><span>ยืนยันจำนวนบุคลากรในเขต</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='form_unlockcheck_area.php'  target='iframe_body'  ><span>เครื่องมือปลดสถานเตรวจสอบเอกสารเสร็จสิ้น</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='import_checklist_to_cmss.php'  target='iframe_body'  ><span>นำเข้าข้อมูลสู่ระบบ cmss</span></a>
</LI>
<?
	if($_SESSION['session_sapphire'] == "1"){
?>
<LI  class="item4 "><a  class="orphan item bullet"  href='../userentry/org_user.php'  target='iframe_body'  ><span>ระบบจัดการผู้ใช้</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='index_unlock_confirm_checklist.php'  target='iframe_body'  ><span>ปลดล็อกการยืนยันการดำเนินการของทีมออกนอกพื้นที่</span></a>
</LI>
<?
	}//end 
?>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_changidcard.php?action=chang_index'  target='iframe_body'  ><span>ระบบเปลี่ยนเลขบัตรประชาชน</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='report_genfiletxt_idcardfalse.php?action='  target='iframe_body'  ><span>ระบบสร้างไฟล์ text เลขบัตรไม่สมบูรณ์</span></a>
</LI>
</ul>
</div></LI>
<LI class="item5 parent   root"  ><a href='#'    class="daddy item bullet " ><span>บริหารจัดการไฟล์ PDF </span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">

<LI  class="item5 "><a  class="orphan item bullet"  href='browser_zip.php'  target='iframe_body'  ><span>นำไฟล์ PDF โดยการบีบอัดไฟล์</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_manage_filepdf.php'  target='iframe_body'  ><span>ประมวลผลเพื่อเชื่อมโยงไฟล์ PDF กับข้อมูลบุคลากร</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_checkpdffile.php'  target='iframe_body'  ><span>รายงานตรวจสอบไฟล์ PDF</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='report_xref_pdferror.php'  target='_blank'  ><span>รายงานจำนวนไฟล์ PDF ที่มีปัญหา</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_scanpdf.php'  ><span>รายงานเอกสารต้นฉบับที่จะส่งงาน</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf.php'  target='_blank'  ><span>พิมพ์รายงานข้อมูล pdf ต้นฉบับ</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_keydata_respdf.php'  target='_blank'  ><span>พิมพ์รายงานเอกสารอิเล็กทรอนิกส์</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../hr3/tool_competency/gen_pdf_systemv1.php'  target='_blank'  ><span>gen ไฟล์ pdf ต้นฉบับ และ pdf อิเล็กทรอนิกส์</span></a>
</LI>
</ul>
</div></LI>
    	
			<li class="itemexit  root" >            
			<a class="orphan item bullet" href="logout.php"  >
			<span >ออกจากระบบ</span>	</a>
		
			
</li>	
	</ul>
										</div>
				<div class="clr"></div>
				</div>
			</div>
		</div>
				<!--End Horizontal Menu-->
		</div>

    </td>
  </tr>
  
  
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td></td>
              </tr>
              <tr>
                <td ><iframe src="main_report.php" width="100%" height="600" frameborder="0" hspace="0" marginwidth="0" vspace="0"   name="iframe_body"  id="iframe_body" style="z-index:9999"></iframe></td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><span style="border-right:1 solid #909090">
      
<style type="text/css"> 
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="../kj_report/css/style.css" rel="stylesheet" type="text/css">
</head>
 
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../kj_report/images/banner_01.gif" style="border-top: 1px solid #ffffff">
  <tr>
    <td width="1%"><img src="images/banner_01.gif" width="10" height="36"></td>
    <td width="98%" align="center">&copy;2009 สงวนลิขสิทธิ์โดย สำนักงานคณะกรรมการข้าราชการครูและบุคลากรทางการศึกษา </td>
    <td width="1%" align="right">&nbsp;</td>
  </tr>
</table>
    </span></td>
  </tr>
</table>
</body>
</html>

