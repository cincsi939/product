<?
session_start() ; 	

	function SubMenu($status_active,$app_id,$level){
	if($level>3){$level=3;}
	 global $dbnamemaster,$xsiteid,$it_count,$menu_app;
	 $xsql1 = "SELECT * FROM app_list WHERE parent_id='$app_id' AND app_status='1'";
	 $xresult1 = mysql_db_query($dbnamemaster,$xsql1);
	 $xnum1 = @mysql_num_rows($xresult1);
	 //echo "db :: $dbnamemaster :: num :: ".$xnum1;
	 if($xnum1 > 0){
		 $xstr .= "<div class=\"fusion-submenu-wrapper level$level columns2\">\n
			<div class=\"drop-top\"></div>\n
			<ul class=\"level$level columns2\">\n";
		 $url = "";
		 $taget = "";
	 while($xrs1 = mysql_fetch_assoc($xresult1)){
			
			if($xrs1[sent_para] != ""){
				$url =  "$xrs1[app_url]?".str_replace('$xsiteid',$xsiteid,$xrs1[sent_para]);		
				$taget = " target='$xrs1[targetpage]' ";
			}else{
				$url = "$xrs1[app_url]";	
				$taget = "";
			}	
		$xsql_2 = "SELECT * FROM app_list WHERE parent_id='$xrs1[id]' AND app_status='1'";
				$xresult2 = mysql_db_query($dbnamemaster,$xsql_2);
				$xnum2 = @mysql_num_rows($xresult2);
				
			if($xnum2>0){				
				$xclass=" class=\"item$it_count parent\"";
				$xclass_a="class=\"daddy item bullet subtext nolink\"";
			}else{
			    $xclass=" class=\"item$it_count \"";
				$xclass_a="class=\"orphan item bullet\"";
			}
			
			if($status_active == 1){
			$xstr .= "<LI $xclass><a  $xclass_a  href='$url' $taget ><span>".iconv(  'TIS-620','UTF-8',$xrs1[caption])."</span></a>\n";
			$xstr .= SubMenu($status_active,$xrs1[id],$level+1);
			$xstr .= "</LI>\n";
			}else{
				if(in_array($xrs1[id], $menu_app)){
			$xstr .= "<LI $xclass><span $xclass_a ><span class='Dismenu'>".iconv(  'TIS-620','UTF-8',$xrs1[caption])."</span></span>\n";
			$xstr .= SubMenu($status_active,$xrs1[id],$level+1);
			$xstr .= "</LI>\n";

				}else{
			$xstr .= "<LI $xclass><a  $xclass_a  href='$url' $taget ><span>".iconv(  'TIS-620','UTF-8',$xrs1[caption])."</span></a>\n";
			$xstr .= SubMenu($status_active,$xrs1[id],$level+1);
			$xstr .= "</LI>\n";
	
				}
			}//end if($status_active == 1){
			
			
	}//end  while($xrs1 = mysql_fetch_assoc($xsql1)){
		$xstr .= "</ul>\n</div>";
	}//end 
	//echo $xstr;die;
 	return $xstr;
}//end function SubMenu($app_id){
?>


 
  <link rel="stylesheet" href="css_menu/css/modal.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/style.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/rokbox-style.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/rokbox-style-ie8.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/template.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/header-style1.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/body-light.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/typography.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/menu-fusion.css" type="text/css" />
  <link rel="stylesheet" href="css_menu/css/rokstories.css" type="text/css" />
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
  
<script type="text/javascript" src="css_menu/js/mootools.js"></script>
  <script type="text/javascript" src="css_menu/js/modal.js"></script>
  <script type="text/javascript" src="css_menu/js/fusion.js"></script>
  <script type="text/javascript" src="css_menu/js/rokfonts.js"></script>
  <script type="text/javascript" src="css_menu/js/rokutils.js"></script>
  <script type="text/javascript" src="css_menu/js/rokstories.js"></script>
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

	<div id="ff-optima" class="f-default style1 body-light head-style1  iehandle" style="background:url(images/banner01_top.jpg) 0 0 no-repeat; height:90px">
	<!--Begin Header-->
	<div id="header-bg" style="float:right;">
		<!--Begin Horizontal Menu-->
				<div id="horiz-menu" class="fusion">
			<div class="wrapper">
				<div class="padding">
					<div id="horizmenu-surround">
											<ul class="menutop level1" >
			<li class="item_home active root" >
			<a class="orphan item bullet" href="main_report.php"  target="iframe_body" >
			<span>รายงานสรุปภาพรวม</span>	</a></li>		
         
         <li class="item1  root" >            
			<a class="daddy item bullet" href="#" target="iframe_body">
			<span >พิมพ์รายงาน</span>	</a>
            
            <div class=\"fusion-submenu-wrapper level2 columns2\">\n
			<div class=\"drop-top\"></div>\n
			<ul class=\"level2 columns2\">\n

<LI class="item1 parent"><a   href='../../report/report_genpdf.php' target="iframe_body" class="daddy item bullet">พิมพ์รายงานข้อมูล pdf ต้นฉบับ</a></LI>
<LI class="item1 parent"><a   href='../../report/report_keydata_respdf.php' target="iframe_body" class="daddy item bullet">พิมพ์รายงานเอกสารอิเล็กทรอนิกส์</a></LI>

</ul></div>

        </li>	
         
         
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
