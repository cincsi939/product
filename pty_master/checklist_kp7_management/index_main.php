 <?php
 	/**
	 * @comment ��ª���������ѡ,��§ҹ��С�ä���,�Ѵ��â�����,�����èѴ������ PDF 
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
<a href='#'    class="daddy item bullet " ><span>��§ҹ��С�ä���</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='../../report/report_follow_kp7.php'  target='iframe_body'  ><span>��§ҹ�ʴ��ӹǹ����ͺ���§ҹ����͡��ä���ҧ</span></a>
</LI>
<LI  class="item3 ">
            <a  class="orphan item bullet"  href='report_monitor_assign.php'  target='iframe_body'  ><span>��§ҹ�͡��ä�ҧ�ͺ���§ҹ</span></a>
</LI>
                   <LI  class="item3 ">
            <a  class="orphan item bullet"  href='search_kp7_destroy.php'  target='iframe_body'  ><span>�������͵�Ǩ�ͺʶҹС�͹�ӧҹ�͡��� �.�.7</span></a>
</LI>

            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='report_assign_index.php'  target='iframe_body'  ><span>��§ҹ����ͺ���§ҹ�͡��� �.�.7</span></a>
</LI>
                        <LI  class="item3 "><a  class="orphan item bullet"  href='report_scan.php'  target='iframe_body'  ><span>��§ҹ����ʡ���� pdf �鹩�Ѻ</span></a>
</LI>
 <LI  class="item3 "><a  class="orphan item bullet"  href='report_scan_false.php'  target='iframe_body'  ><span>��§ҹ����᡹���(�ó��͡����������ó�)</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='search_school.php'  target='iframe_body'  ><span>�������͵�Ǩ�ͺ�����ç���¹</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_idfalse.php'  target='iframe_body'  ><span>��§ҹ�������Ţ�ѵ÷�����١��ͧ�����û���ͧ(��ҧ���)</span></a>
</LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='main_report.php'  target='iframe_body'  ><span>��§ҹ��ػ�Ҿ���</span></a></LI>
<? 	if($_SESSION['session_sapphire'] == "1"){ ?>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_viewexecutive.php'  target='_blank'  ><span>��§ҹ executive ����Ѻ senior</span></a></LI>
<?
}//end 	if($_SESSION['session_sapphire'] == "1"){
if($_SESSION['session_staffid'] == "10088"){ // ����Ѻ�س�����ҷ
?>	
<LI  class="item3 "><a  class="orphan item bullet"  href='report_link_viewexecutive.php?lv=1'  target='iframe_body'  ><span>��¡�á����Ҵ���§ҹ����Ѻ��������</span></a></LI>
<?   
}
?>
<LI  class="item3 "><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_change_idcard.php?get_type=1'  target='iframe_body'  ><span>��§ҹ�������¹�Ţ�ѵ�</span></a></LI>
<LI  class="item3 "><a  class="orphan item bullet"  href='report_diffassignkey.php'  target='iframe_body'  ><span>��§ҹ�ӹǹ����ҧ���������ͺ���§ҹ���Ѻ��ѡ�ҹ��������Ũҡ�ӹǹ����ͺ�����͡��èҡ��� checklist</span></a></LI>

<LI  class="item3 "><a  class="orphan item bullet"  href='report_compare_checklist_log.php'  target='iframe_body'  ><span>��§ҹ��º�ӹǹ�ٻ �.�.7 �ҡ checklist , log ��� ��к� cmss</span></a>
</LI>
</ul>
</div></LI>
<LI class="item4 parent   root"  ><a href='#'    class="daddy item bullet " ><span>�Ѵ��â�����</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item4 "><a  class="orphan item bullet"  href='check_kp7_index.php'  target='iframe_body'  ><span>��Ǩ�ͺ�͡��� �.�.7</span></a>
             <LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='process_update_numpic.php'  target='_blank'  ><span>����ͧ���㹡�� update �ٻ �.�.7 ��к� ���ç�Ѻ checklist</span></a>
</LI>
   <LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='script_update_bdate.php'  target='_blank'  ><span>����ͧ��� update �ѹ�Դ����ѹ�������Ժѵ�Ҫ���</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_area.php'  target='iframe_body'  ><span>���Һؤ�ҡ����ͺѹ�֡��üš�õ�Ǩ�ͺ�͡���</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='assign_management.php'  target='iframe_body'  ><span>�ͺ���§ҹ�᡹�͡���</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/import_dbf_pobec_checklist/from_create_profile.php'  target='iframe_body'  ><span>����Ң����ŵ�駵�</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='../hr3/import_dbf_pobec_checklist/from_create_profile_detail.php'  target='iframe_body'  ><span>ʶҹС�õԴ����͡���</span></a>
</LI>

<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_check.php'  target='iframe_body'  ><span>�����źؤ�ҡ÷��١��Ǩ�ͺ</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='search_person_num_check.php'  target='iframe_body'  ><span>�����ž�ѡ�ҹ����Ǩ�ͺ������</span></a>
</LI>

<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='form_lock_area.php'  target='iframe_body'  ><span>�׹�ѹ�ӹǹ�ؤ�ҡ��ࢵ</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='form_unlockcheck_area.php'  target='iframe_body'  ><span>����ͧ��ͻŴʶҹ��Ǩ�ͺ�͡����������</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='import_checklist_to_cmss.php'  target='iframe_body'  ><span>����Ң���������к� cmss</span></a>
</LI>
<?
	if($_SESSION['session_sapphire'] == "1"){
?>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='../userentry/org_user.php'  target='iframe_body'  ><span>�к��Ѵ��ü����</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='index_unlock_confirm_checklist.php'  target='iframe_body'  ><span>�Ŵ��͡����׹�ѹ��ô��Թ��âͧ����͡�͡��鹷��</span></a>
</LI>
<?
	}//end 
?>
<LI  class="item4"><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_changidcard.php?action=chang_index'  target='iframe_body'  ><span>�к�����¹�Ţ�ѵû�ЪҪ�</span></a>
</LI>
<LI  class="item4 " style="display:none;"><a  class="orphan item bullet"  href='report_genfiletxt_idcardfalse.php?action='  target='iframe_body'  ><span>�к����ҧ��� text �Ţ�ѵ��������ó�</span></a>
</LI>
</ul>
</div></LI>
<LI class="item5 parent   root"  ><a href='#'    class="daddy item bullet " ><span>�����èѴ������ PDF </span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='browser_zip.php'  target='iframe_body'  ><span>����� PDF �¡�úպ�Ѵ���</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_manage_filepdf.php'  target='_blank'  ><span>�����ż�������§������¹����ѵ�<br />
�鹩�Ѻ(PDF)<br />
</span></a>
</LI>
<LI  class="item5 " ><a  class="orphan item bullet"  href='script_manage_filepdfrefdoc.php'  target='_blank'  ><span>�����ż�����������§<br />
����͡��á�͵���Է���(Ref Doc)</span></a>
</LI>

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='script_checkpdffile.php'  target='iframe_body'  ><span>��§ҹ��Ǩ�ͺ��� PDF</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='report_xref_pdferror.php'  target='_blank'  ><span>��§ҹ�ӹǹ��� PDF ����ջѭ��</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_scanpdf.php'  ><span>��§ҹ�͡��õ鹩�Ѻ�����觧ҹ</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_org.php'  target='_blank'  ><span>�������§ҹ�͡��÷���¹����ѵԵ鹩�Ѻ</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_genpdf_org_new.php'  target='_blank'  ><span>�������§ҹ������ pdf �鹩�Ѻ<br>(��è���������է�����ҳ 2555)</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_sys.php'  target='_blank'  ><span>�������§ҹ�͡��÷���¹����ѵ�����硷�͹ԡ��</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf_refdoc.php'  target='_blank'  ><span>�������§ҹ�͡�����ѡ�ҹ��͵���Է��</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../../report/report_genpdf_sys_new.php'  target='_blank'  ><span>�������§ҹ�͡�������硷�͹ԡ��<br>(��è���������է�����ҳ 2555)</span></a>
</LI>
<LI  class="item5 " ><a  class="orphan item bullet"  href='../hr3/tool_competency/generate_kp7/gen_pdf.php'  target='_blank'  ><span>����ͧ������ҧ������¹����ѵԵ鹩�Ѻ,<br />
  ����硷�͹ԡ�� ����͡��á�͵���Է���..</span></a>
</LI>
<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='../hr3/tool_competency/generate_kp7/gen_pdf_new.php'  target='_blank'  ><span>gen ��� pdf �鹩�Ѻ ��� pdf ����硷�͹ԡ��<br>(��è���������է�����ҳ 2555)</span></a>
</LI>

<LI  class="item5 " style="display:none;"><a  class="orphan item bullet"  href='http://61.19.255.77/competency_master/application/hr3/tool_competency/generate_kp7/index_profile.php'  target='_blank'  ><span>���ҧ���鹩�Ѻ�������硷�͹ԡ������Ѻ�觧ҹ(�Ҫ��)</span></a>
</LI>

</ul>
</div></LI>
    	
			<li class="itemexit  root" >            
			<a class="orphan item bullet" href="logout.php"  >
			<span >�͡�ҡ�к�</span>	</a>
		
			
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
    <td width="98%" align="center">&copy;2013 ʧǹ�Ԣ�Է����� �ӹѡ����֡�� ��ا෾��ҹ�� </td>
    <td width="1%" align="right">&nbsp;</td>
  </tr>
</table>
    </span></td>
  </tr>
</table>
</body>
</html>

