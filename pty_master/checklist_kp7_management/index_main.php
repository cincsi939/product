 <?php
 	/**
	 * @comment รายชื่อเมนูหลัก,รายงานและการค้นหา,จัดการข้อมูล,บริหารจัดการไฟล์ PDF 
	 * @projectCode projet
	 * @tor
	* @package core
	* @author Wised Wisesvatcharajaren
	* @access public
	* @created 07/03/2015
	*/
 	session_start();
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
	
	function uinfo_popup(){
	
		var url= "../user_information/u_info.php";
 		var prop="dialogHeight: 400px; dialogWidth:600px; scroll: No; help: No; status: No;";
 		showModalDialog(url,"pop",prop);
	}
	
  </script>
 
<link href="../kj_report/aussy/css/ie7.css" rel="stylesheet" type="text/css" />
<link href="../kj_report/aussy/css/template_ie7.css" rel="stylesheet" type="text/css" />	
 
 
	<div id="ff-optima" class="f-default style1 body-light head-style1  iehandle" style="background:url(images/banner.jpg) 0 0 no-repeat; height:90px">
	<!--Begin Header-->
	<div id="header-bg" style="float:right;">
		<!--Begin Horizontal Menu-->
				<div id="horiz-menu" class="fusion">
			<div class="wrapper">
				<div class="padding">
					<div id="horizmenu-surround">
											<ul class="menutop level1" >
<LI class="item3 parent   root" style="display:none;">
<a href='#'    class="daddy item bullet " ><span>รายงานและการค้นหา</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='../../report/report_follow_kp7.php'  target='iframe_body'  ><span>รายงานแสดงจำนวนการมอบหมายงานและเอกสารคงค้าง</span></a>
</LI>
<LI  class="item3 ">
            <a  class="orphan item bullet"  href='report_monitor_assign.php'  target='iframe_body'  ><span>รายงานเอกสารค้างมอบหมายงาน</span></a>
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
             <LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='process_update_numpic.php'  target='_blank'  ><span>เครื่องมือในการ update รูป ก.พ.7 ในระบบ ให้ตรงกับ checklist</span></a>
</LI>
   <LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='script_update_bdate.php'  target='_blank'  ><span>เครื่องมือ update วันเกิดและวันเริ่มปฏิบัตราชการ</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_area.php'  target='iframe_body'  ><span>ค้นหาบุคลากรเพื่อบันทึกการผลการตรวจสอบเอกสาร</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='assign_management.php'  target='iframe_body'  ><span>มอบหมายงานสแกนเอกสาร</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/import_dbf_pobec_checklist/from_create_profile.php'  target='iframe_body'  ><span>นำเข้าข้อมูลตั้งต้น</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='../hr3/import_dbf_pobec_checklist/from_create_profile_detail.php'  target='iframe_body'  ><span>สถานะการติดตามเอกสาร</span></a>
</LI>

<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_check.php'  target='iframe_body'  ><span>ข้อมูลบุคลากรที่ถูกตรวจสอบ</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_num_check.php'  target='iframe_body'  ><span>ข้อมูลพนักงานที่ตรวจสอบข้อมูล</span></a>
</LI>

<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='form_lock_area.php'  target='iframe_body'  ><span>ยืนยันจำนวนบุคลากรในเขต</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='form_unlockcheck_area.php'  target='iframe_body'  ><span>เครื่องมือปลดสถานเตรวจสอบเอกสารเสร็จสิ้น</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='import_checklist_to_cmss.php'  target='iframe_body'  ><span>นำเข้าข้อมูลสู่ระบบ cmss</span></a>
</LI>
<?
	if($_SESSION['session_sapphire'] == "1"){
?>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='../userentry/org_user.php'  target='iframe_body'  ><span>ระบบจัดการผู้ใช้</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='index_unlock_confirm_checklist.php'  target='iframe_body'  ><span>ปลดล็อกการยืนยันการดำเนินการของทีมออกนอกพื้นที่</span></a>
</LI>
<?
	}//end 
?>
<LI  class="item4"><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_changidcard.php?action=chang_index'  target='iframe_body'  ><span>ระบบเปลี่ยนเลขบัตรประชาชน</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='report_genfiletxt_idcardfalse.php?action='  target='iframe_body'  ><span>ระบบสร้างไฟล์ text เลขบัตรไม่สมบูรณ์</span></a>
</LI>
</ul>
</div></LI>
<LI class="item5 parent   root"  ><a href='#'    class="daddy item bullet " ><span>บริหารจัดการไฟล์ PDF </span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='browser_zip.php'  target='iframe_body'  ><span>นำไฟล์ PDF โดยการบีบอัดไฟล์</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_manage_filepdf.php'  target='_blank'  ><span>ประมวลผลเชื่อมโยงไฟล์ทะเบียนประวัติ<br />
ต้นฉบับ(PDF)<br />
</span></a>
</LI>
<LI  class="item5 " ><a  class="orphan item bullet"  href='script_manage_filepdfrefdoc.php'  target='_blank'  ><span>ประมวลผลเพื่อเชื่อมโยง<br />
ไฟล์เอกสารก่อตั้งสิทธิ์(Ref Doc)</span></a>
</LI>

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='script_checkpdffile.php'  target='iframe_body'  ><span>รายงานตรวจสอบไฟล์ PDF</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='report_xref_pdferror.php'  target='_blank'  ><span>รายงานจำนวนไฟล์ PDF ที่มีปัญหา</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_scanpdf.php'  ><span>รายงานเอกสารต้นฉบับที่จะส่งงาน</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_org.php'  target='_blank'  ><span>พิมพ์รายงานเอกสารทะเบียนประวัติต้นฉบับ</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_genpdf_org_new.php'  target='_blank'  ><span>พิมพ์รายงานข้อมูล pdf ต้นฉบับ<br>(บรรจุใหม่ตั้งแต่ปีงบประมาณ 2555)</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_sys.php'  target='_blank'  ><span>พิมพ์รายงานเอกสารทะเบียนประวัติอิเล็กทรอนิกส์</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_refdoc.php'  target='_blank'  ><span>พิมพ์รายงานเอกสารหลักฐานก่อตั้งสิทธิ</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_genpdf_sys_new.php'  target='_blank'  ><span>พิมพ์รายงานเอกสารอิเล็กทรอนิกส์<br>(บรรจุใหม่ตั้งแต่ปีงบประมาณ 2555)</span></a>
</LI>
<LI  class="item5 " ><a  class="orphan item bullet"  href='../hr3/tool_competency/generate_kp7/gen_pdf.php'  target='_blank'  ><span>เครื่องมือสร้างไฟล์ทะเบียนประวัติต้นฉบับ,<br />
  อิเล็กทรอนิกส์ และเอกสารก่อตั้งสิทธิ์..</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../hr3/tool_competency/generate_kp7/gen_pdf_new.php'  target='_blank'  ><span>gen ไฟล์ pdf ต้นฉบับ และ pdf อิเล็กทรอนิกส์<br>(บรรจุใหม่ตั้งแต่ปีงบประมาณ 2555)</span></a>
</LI>

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='http://61.19.255.77/competency_master/application/hr3/tool_competency/generate_kp7/index_profile.php'  target='_blank'  ><span>สร้างไฟล์ต้นฉบับและอิเล็กทรอนิกส์สำหรับส่งงาน(อาชีว)</span></a>
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
    <td width="98%" align="center">&copy;2013 สงวนลิขสิทธิ์โดย สำนักการศึกษา กรุงเทพมหานคร </td>
    <td width="1%" align="right">&nbsp;</td>
  </tr>
</table>
    </span></td>
  </tr>
</table>
</body>
</html>

