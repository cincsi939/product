<?
session_start() ; 	
	if($hr_logout=="all" ){
	$ipserver_logout = "www.cmss-otcsc.com";
	}else{
	$ipserver_logout = "www.cmss-otcsc.com";
	}




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0037) -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK media=screen href="common/styles.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-h.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-v.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="common/jquery.min.js" type=text/javascript></SCRIPT>
<!--[if gte IE 5.5]>
<SCRIPT language=JavaScript 
src="common/jquery.ienav.js" 
type=text/javascript></SCRIPT>
<![endif]-->
<SCRIPT language=JavaScript type=text/javascript>
$(document).ready(function() {
  $('.links li code').hide();  
  $('.links li p').click(function() {
    $(this).next().slideToggle('fast');
  });
});
</SCRIPT>
</HEAD>
<BODY>

<DIV align="left" id=content>
  <UL align="left" id=navmenu-v>
  <LI><a href="search_school.php" target="iframe_body" >ค้นหาเพื่อตรวจสอบชื่อโรงเรียน</A></LI>
  
  <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){ ?> 
    <LI><A href="#">รายงานและการค้นหา +</A> 
      <UL>
       <LI><a href="report_idfalse.php" target="iframe_body" >รายงานข้อมูลเลขบัตรที่ไม่ถูกต้องกรมการปกครอง(ค้างแก้ไข)</A></LI>
      <LI><a href="../hr3/tool_competency/change_idcard/report_change_idcard.php" target="_blank" >รายงานประวัติการเปลี่ยนเลขบัตร</A>    </LI>  
      <? if($_SESSION['session_sapphire'] == "1"){?>
       <LI><a href="main_report.php" target="iframe_body" >รายงานสรุปภาพรวม</A>    </LI>  
       <? }//end if($_SESSION['session_sapphire'] == "1"){?>
       <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){  // ?>
      <LI><a href="../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile.php" target="iframe_body">นำเข้าข้อมูลตั้งต้น</A></LI>
	  
      <? }//end if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){  
	  ?>
	  <LI><a href="../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile_detail.php" target="iframe_body">สถานะการติดตามเอกสาร</A></LI>
	  <?
	  	if($_SESSION['session_sapphire'] == "1"){
	  ?>
        <LI><a href="search_person_check.php" target="iframe_body" >ข้อมูลบุคลากรที่ถูกตรวจสอบ</A>        </LI>
        <LI><a href="search_person_num_check.php" target="iframe_body" >ข้อมูลพนักงานที่ตรวจสอบข้อมูล</A>        </LI>
        <? } //end if($_SESSION['session_sapphire'] == "1"){?>
	</UL>
  <!----- 	
    <LI><A href="#">รายงาน +</A> 
      <UL>
        <LI><a href="stat_num_check.php" target="iframe_body" >รายงานสถิติการตรวจสอบข้อมูล</A>        </LI>
	</UL>
------>	  	
<?
	}//end  if($_SESSION['session_sapphire'] == "1"){ 
	//if($_SESSION['session_staffid'] == "64"){
?>

<?
	//}// end if($_SESSION['session_staffid'] == "64"){
?>
	<LI><A href="#">บริหารจัดการข้อมูล+</A>
    <UL>
     <LI><a href="assign_management.php" target="iframe_body" >มอบหมายงานสแกนเอกสาร </A></LI>
     <LI><a href="check_kp7_index.php" target="iframe_body" >ตรวจสอบเอกสาร ก.พ.7 </A></LI>
     <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "64" or $_SESSION['session_staffid'] == "72" or $_SESSION['session_staffid'] == "57" or $_SESSION['session_staffid'] == "10242" or $_SESSION['session_staffid'] == "93" or $_SESSION['session_staffid'] == "10394" or  $_SESSION['session_staffid'] == "9974"){ // เห็นเฉพาะพี่เพ็ญ กับยุ้ย และพี่เจี๊ยบ?>
      <LI><a href="form_lock_area.php" target="iframe_body" >ยืนยันจำนวนบุคลากรในเขต</A></LI>
      <LI><a href="import_checklist_to_cmss.php" target="iframe_body" >นำเข้าข้อมูลสู่ระบบ cmss</A></LI>

     <? } //end ?>
    </UL>
	<?
		if($_SESSION['session_sapphire'] == "1"){
	
	?>
    <LI><A href="#">บริหารจัดการไฟล์ PDF +</A>
    <UL>
           <LI><a href="browser_zip.php" target="iframe_body">นำไฟล์ PDF โดยการบีบอัดไฟล์</A></LI>
           <LI><a href="script_manage_filepdf.php" target="_blank">ประมวลผลเพื่อเชื่อมโยงไฟล์ PDF กับข้อมูลบุคลากร</A></LI>
        <!-- <LI><a href="report_idcard_nomath_name.php" target="_blank">ตรวจสอบ ชื่อ นามสกุล checklist ไม่ตรงกับ cmss </A></LI>-->
        <LI><a href="report_xref_pdferror.php" target="_blank">รายงานจำนวนไฟล์ PDF ที่มีปัญหา</A></LI>
        <LI><a href="../../report/report_scanpdf.php" target="_blank">รายงานเิอกสารต้นฉบับที่จะส่งงาน</A></LI>
    </UL>
    </LI>
    
   <LI><a href="../userentry/org_user.php" target="iframe_body" >ระบบจัดการผู้ใช้</A></LI>
   <?
   		}//end  // จัดการเมนูผู้ใช้ได้เฉพาะพนักงาน office
		
   ?>    
     <LI><a href="../../report/report_genpdf.php" target="_blank" >พิมพ์รายงานข้อมูล pdf ต้นฉบับ</A></LI>
     <LI><a href="../../report/report_keydata_respdf.php" target="_blank" >พิมพ์รายงานเอกสารอิเล็กทรอนิกส์</A></LI>
          
    <LI><a href="logout.php">ออกจากระบบ</A></LI>
	</LI>
  </UL>
	</DIV>
</BODY></HTML>
