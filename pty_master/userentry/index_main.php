 <?
 	@session_start();
	$staff_idarray = array('10217','10357','10192','10169','10092');
if(in_array($_SESSION['session_staffid'],$staff_idarray)){
	$unlock_approve = 1;
}else{
	$unlock_approve = 0;	
}

if ($_SESSION[session_sapphire] == 1 ){
	if($_SESSION[session_staffid] == "11026"){ // ����Ѻ���˹���Ѫ���
		$main_url = "../../report/report_keydata_main.php" ;
	}else{
		$main_url = "index_key_report.php" ;
	}
}else if($_SESSION[session_status_extra] == "QC"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}

if($_SESSION[session_staffid] == "11026"){
	$menu_group = array("˹����ѡ"=>"$main_url,iframe_body","�͡�ҡ�к�"=>"logout.php,_top");
}else{
$menu_group = array("˹����ѡ"=>"$main_url,iframe_body","�к����Ң�����"=>"qsearch2.php,iframe_body","��èѴ��â������к�"=>"","��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�."=>"","��§ҹ����Ѻ��������"=>"","���ͺ��������"=>"../diagnose/bandwidth/initialmeter.php,_blank","��Ǩ�ͺ��ù�����ٻ �.�.7"=>"../pic2cmss_entry_new/site_report.php?profile_id=4&direct_check=ON,_blank","�͡�ҡ�к�"=>"logout.php,_top");
}

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1  and $_SESSION[session_staffid] != "11026"){
	


/*$menu_array = array(

"��èѴ��â������к�"=>array("�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�����èѴ�����Ǵ��¡�õ�Ǩ������"=>"../validate_management/index.php,_blank",
							 "����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","�к�������ٻ �.�.7"=>"../hr3/tool_competency/pic2cmss/_index.php","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank","�к� Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),
*/
$menu_array = array(
"��èѴ��â������к�"=>array("��˹��Դ�Դ�к��Ѻ�ͧ������"=>"../req_approve/admin_sapphire/main_manager.php,_blank","�к��Ŵ�Ѻ�ͧ�����ŹѺ�������ç���¹"=>"../raise_salary/unapprove_school/index.php,_blank","��˹�ʶҹС�û�ͧ�ѹ�����š���ͺ���§ҹ"=>"assign_protection.php","�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�����èѴ�����Ǵ��¡�õ�Ǩ������"=>"../validate_management/index.php,_blank","����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank","�к� Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank","��§ҹ Download Excel ������ ���."=>"../gpf_download/index_download.php,_blank"),


"��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�."=>array("��§ҹ�ӹǹ��¡�÷���ѧ������Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile.php","��§ҹ��Ǩ�ͺ�������ٻ�Ҫ��ä����кؤ�ҡ�÷ҧ����֡��"=>"report_check_data_image.php"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","��§ҹʶԵԡ�úѹ�֡������"=>"report_keyin_user.php","��§ҹ��ػ��Һѹ�֡�͡���"=>"report_keyin_user_p2p.php",
"��ػ�Ҿ�����úѹ�֡������"=>"report_sum_area.php?action=view",
"��§ҹʶԵ�����Ѻ��������"=>"index_key_report.php",
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php","��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������"=>"report_keydata_error.php,_blank","��§ҹ��������ż�������"=>"report_executive_area.php,_blank","��§ҹ��ѡ�ҹ��������źѹ�֡������ Sub ����ҧҹ"=>"report_check_userkeydata.php,_blank")

//"��§ҹ��ػ��úѹ�֡������"=>"report_sum.php",
//"�����ż� Ranking "=>"ranking.inc.php",
);

if($_SESSION[session_staffid] != 64 and $_SESSION[session_staffid] != 72){
	unset($menu_array['��§ҹ']['��§ҹ��ѡ�ҹ��������źѹ�֡������ Sub ����ҧҹ']);	
}



} else if($_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "QC_WORD"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$menu_array = array(

"��èѴ��â������к�"=>array("�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�к�������Ǩ�ͺ������"=>"report_alert_qc1.php,_blank","����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin","��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������"=>"report_keydata_error.php,_blank","��§ҹ��������ż�������"=>"report_executive_area.php,_blank")



);

	if($unlock_approve != "1"){ // ����� QC �ҧ����ҹ�鹷��������ٹ��
		unset($menu_array['��èѴ��â������к�']['����ͧ���㹡�ûŴ�Ѻ�ͧ������']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php"),
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	//$menu_group = array("�к����Ң�����"=>"qsearch2.php,iframe_body");
	$menu_array = array(
"��èѴ��â������к�"=>array( "��˹��Դ�Դ�к��Ѻ�ͧ������"=>"../req_approve/admin_sapphire/main_manager.php,_blank","�к��Ŵ�Ѻ�ͧ�����ŹѺ�������ç���¹"=>"../raise_salary/unapprove_school/index.php,_blank","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));
}else if($_SESSION[session_status_extra] == "site_area"){
	
	$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php","�Ѻ�ͧ��Ҥ�ṹ��úѹ�֡������"=>"report_keypiont_perday_index.php"),
//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("��§ҹ�ӹǹ��¡�÷���ѧ������Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile.php","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin") );
	
}else{

$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php","�Ѻ�ͧ��Ҥ�ṹ��úѹ�֡������"=>"report_keypiont_perday_index.php"),
//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

unset($menu_group['��Ǩ�ͺ��ù�����ٻ �.�.7']);
}

if($_SESSION[session_staffid] != 93 AND $_SESSION[session_staffid] != 9948 AND $_SESSION[session_staffid] != 95 AND $_SESSION[session_staffid] != 57 AND $_SESSION[session_staffid] != 9974){
	unset($menu_array['��§ҹ�Ѵ��ü����']);
}

if($_SESSION[session_staffid] == 10691){ // �ó��� user�ͧ �.�.�. �������Ҵ�˹����§ҹ
	unset($menu_group['��èѴ��â������к�']);
	unset($menu_group['�к����Ң�����']);
/*	"��§ҹ"=>array("��§ҹʶԵԡ�úѹ�֡������"=>"report_keyin_user.php","��§ҹ��ػ��Һѹ�֡�͡���"=>"report_keyin_user_p2p.php",
"��ػ�Ҿ�����úѹ�֡������"=>"report_sum_area.php?action=view",
"��§ҹʶԵ�����Ѻ��������"=>"index_key_report.php",
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php")*/
	unset($menu_array['��§ҹʶԵ�����Ѻ��������']);
	unset($menu_array['�����ҧҹ�١��ҧ��Ш�']);
	unset($menu_array['��§ҹʶԵԡ�õ�Ǩ������']);

}


if($_SESSION[session_status_extra] == "QC_WORD"){
		unset($menu_array['��èѴ��â������к�']['����ͧ���㹡�ûŴ�Ѻ�ͧ������']);	
		unset($menu_array['��èѴ��â������к�']['�к��ͺ���§ҹ �.�.7']);	
		unset($menu_array['��èѴ��â������к�']['�к�������Ǩ�ͺ������']);	
		unset($menu_array['��èѴ��â������к�']['��§ҹ�Ѵ��ü����']);	
		unset($menu_array['��èѴ��â������к�']['�к���ͧ������䢢�����']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ�������¹�Ţ�ѵ�']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ��������ż�������']);
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
<a href='#'    class="daddy item bullet " ><span>��§ҹ��С�ä���</span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">
            <LI  class="item3 ">
            <a  class="orphan item bullet"  href='../../report/report_follow_kp7.php'  target='iframe_body'  ><span>��§ҹ�ʴ��ӹǹ����ͺ���§ҹ����͡��ä���ҧ</span></a>
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
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_area.php'  target='iframe_body'  ><span>���Һؤ�ҡ����ͺѹ�֡��üš�õ�Ǩ�ͺ�͡���</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='assign_management.php'  target='iframe_body'  ><span>�ͺ���§ҹ�᡹�͡���</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile.php'  target='iframe_body'  ><span>����Ң����ŵ�駵�</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/import_dbf_pobec_checklist/from_create_profile_detail.php'  target='iframe_body'  ><span>ʶҹС�õԴ����͡���</span></a>
</LI>

<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_check.php'  target='iframe_body'  ><span>�����źؤ�ҡ÷��١��Ǩ�ͺ</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='search_person_num_check.php'  target='iframe_body'  ><span>�����ž�ѡ�ҹ����Ǩ�ͺ������</span></a>
</LI>

<LI  class="item4 "><a  class="orphan item bullet"  href='form_lock_area.php'  target='iframe_body'  ><span>�׹�ѹ�ӹǹ�ؤ�ҡ��ࢵ</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='form_unlockcheck_area.php'  target='iframe_body'  ><span>����ͧ��ͻŴʶҹ��Ǩ�ͺ�͡����������</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='import_checklist_to_cmss.php'  target='iframe_body'  ><span>����Ң���������к� cmss</span></a>
</LI>
<?
	if($_SESSION['session_sapphire'] == "1"){
?>
<LI  class="item4 "><a  class="orphan item bullet"  href='../userentry/org_user.php'  target='iframe_body'  ><span>�к��Ѵ��ü����</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='index_unlock_confirm_checklist.php'  target='iframe_body'  ><span>�Ŵ��͡����׹�ѹ��ô��Թ��âͧ����͡�͡��鹷��</span></a>
</LI>
<?
	}//end 
?>
<LI  class="item4 "><a  class="orphan item bullet"  href='../hr3/tool_competency/change_idcard/index_changidcard.php?action=chang_index'  target='iframe_body'  ><span>�к�����¹�Ţ�ѵû�ЪҪ�</span></a>
</LI>
<LI  class="item4 "><a  class="orphan item bullet"  href='report_genfiletxt_idcardfalse.php?action='  target='iframe_body'  ><span>�к����ҧ��� text �Ţ�ѵ��������ó�</span></a>
</LI>
</ul>
</div></LI>
<LI class="item5 parent   root"  ><a href='#'    class="daddy item bullet " ><span>�����èѴ������ PDF </span></a>
<div class="fusion-submenu-wrapper level2 columns2">
 
			<div class="drop-top"></div>
 
			<ul class="level2 columns2">

<LI  class="item5 "><a  class="orphan item bullet"  href='browser_zip.php'  target='iframe_body'  ><span>����� PDF �¡�úպ�Ѵ���</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_manage_filepdf.php'  target='iframe_body'  ><span>�����ż�����������§��� PDF �Ѻ�����źؤ�ҡ�</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='script_checkpdffile.php'  target='iframe_body'  ><span>��§ҹ��Ǩ�ͺ��� PDF</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='report_xref_pdferror.php'  target='_blank'  ><span>��§ҹ�ӹǹ��� PDF ����ջѭ��</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_scanpdf.php'  ><span>��§ҹ�͡��õ鹩�Ѻ�����觧ҹ</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_genpdf.php'  target='_blank'  ><span>�������§ҹ������ pdf �鹩�Ѻ</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../../report/report_keydata_respdf.php'  target='_blank'  ><span>�������§ҹ�͡�������硷�͹ԡ��</span></a>
</LI>
<LI  class="item5 "><a  class="orphan item bullet"  href='../hr3/tool_competency/gen_pdf_systemv1.php'  target='_blank'  ><span>gen ��� pdf �鹩�Ѻ ��� pdf ����硷�͹ԡ��</span></a>
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
    <td width="98%" align="center">&copy;2009 ʧǹ�Ԣ�Է����� �ӹѡ�ҹ��С�����â���Ҫ��ä����кؤ�ҡ÷ҧ����֡�� </td>
    <td width="1%" align="right">&nbsp;</td>
  </tr>
</table>
    </span></td>
  </tr>
</table>
</body>
</html>

