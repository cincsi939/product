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
  <LI><a href="search_school.php" target="iframe_body" >�������͵�Ǩ�ͺ�����ç���¹</A></LI>
  
  <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){ ?> 
    <LI><A href="#">��§ҹ��С�ä��� +</A> 
      <UL>
       <LI><a href="report_idfalse.php" target="iframe_body" >��§ҹ�������Ţ�ѵ÷�����١��ͧ�����û���ͧ(��ҧ���)</A></LI>
      <LI><a href="../hr3/tool_competency/change_idcard/report_change_idcard.php" target="_blank" >��§ҹ����ѵԡ������¹�Ţ�ѵ�</A>    </LI>  
      <? if($_SESSION['session_sapphire'] == "1"){?>
       <LI><a href="main_report.php" target="iframe_body" >��§ҹ��ػ�Ҿ���</A>    </LI>  
       <? }//end if($_SESSION['session_sapphire'] == "1"){?>
       <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){  // ?>
      <LI><a href="../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile.php" target="iframe_body">����Ң����ŵ�駵�</A></LI>
	  
      <? }//end if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "10394" ){  
	  ?>
	  <LI><a href="../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile_detail.php" target="iframe_body">ʶҹС�õԴ����͡���</A></LI>
	  <?
	  	if($_SESSION['session_sapphire'] == "1"){
	  ?>
        <LI><a href="search_person_check.php" target="iframe_body" >�����źؤ�ҡ÷��١��Ǩ�ͺ</A>        </LI>
        <LI><a href="search_person_num_check.php" target="iframe_body" >�����ž�ѡ�ҹ����Ǩ�ͺ������</A>        </LI>
        <? } //end if($_SESSION['session_sapphire'] == "1"){?>
	</UL>
  <!----- 	
    <LI><A href="#">��§ҹ +</A> 
      <UL>
        <LI><a href="stat_num_check.php" target="iframe_body" >��§ҹʶԵԡ�õ�Ǩ�ͺ������</A>        </LI>
	</UL>
------>	  	
<?
	}//end  if($_SESSION['session_sapphire'] == "1"){ 
	//if($_SESSION['session_staffid'] == "64"){
?>

<?
	//}// end if($_SESSION['session_staffid'] == "64"){
?>
	<LI><A href="#">�����èѴ��â�����+</A>
    <UL>
     <LI><a href="assign_management.php" target="iframe_body" >�ͺ���§ҹ�᡹�͡��� </A></LI>
     <LI><a href="check_kp7_index.php" target="iframe_body" >��Ǩ�ͺ�͡��� �.�.7 </A></LI>
     <? if($_SESSION['session_sapphire'] == "1" or $_SESSION['session_staffid'] == "64" or $_SESSION['session_staffid'] == "72" or $_SESSION['session_staffid'] == "57" or $_SESSION['session_staffid'] == "10242" or $_SESSION['session_staffid'] == "93" or $_SESSION['session_staffid'] == "10394" or  $_SESSION['session_staffid'] == "9974"){ // ���੾�о���� �Ѻ���� ��о�����º?>
      <LI><a href="form_lock_area.php" target="iframe_body" >�׹�ѹ�ӹǹ�ؤ�ҡ��ࢵ</A></LI>
      <LI><a href="import_checklist_to_cmss.php" target="iframe_body" >����Ң���������к� cmss</A></LI>

     <? } //end ?>
    </UL>
	<?
		if($_SESSION['session_sapphire'] == "1"){
	
	?>
    <LI><A href="#">�����èѴ������ PDF +</A>
    <UL>
           <LI><a href="browser_zip.php" target="iframe_body">����� PDF �¡�úպ�Ѵ���</A></LI>
           <LI><a href="script_manage_filepdf.php" target="_blank">�����ż�����������§��� PDF �Ѻ�����źؤ�ҡ�</A></LI>
        <!-- <LI><a href="report_idcard_nomath_name.php" target="_blank">��Ǩ�ͺ ���� ���ʡ�� checklist ���ç�Ѻ cmss </A></LI>-->
        <LI><a href="report_xref_pdferror.php" target="_blank">��§ҹ�ӹǹ��� PDF ����ջѭ��</A></LI>
        <LI><a href="../../report/report_scanpdf.php" target="_blank">��§ҹ��͡��õ鹩�Ѻ�����觧ҹ</A></LI>
    </UL>
    </LI>
    
   <LI><a href="../userentry/org_user.php" target="iframe_body" >�к��Ѵ��ü����</A></LI>
   <?
   		}//end  // �Ѵ������ټ������੾�о�ѡ�ҹ office
		
   ?>    
     <LI><a href="../../report/report_genpdf.php" target="_blank" >�������§ҹ������ pdf �鹩�Ѻ</A></LI>
     <LI><a href="../../report/report_keydata_respdf.php" target="_blank" >�������§ҹ�͡�������硷�͹ԡ��</A></LI>
          
    <LI><a href="logout.php">�͡�ҡ�к�</A></LI>
	</LI>
  </UL>
	</DIV>
</BODY></HTML>
