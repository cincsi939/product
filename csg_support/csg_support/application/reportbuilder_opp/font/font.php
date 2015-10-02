<?php
/*****************************************************************************
Function		: เลือก Font Style
Version			: 1.0
Last Modified	: 28/7/2548
Changes		:
	28/7/2548	- เพิ่ม การจัดการรายชื่อ Font โดยอ่านจาก ไฟล์แทนจาก Fixed Array


*****************************************************************************/

//$fontname = Array("Angsana New","AngsanaUPC","Arial","Browallia New","BrowalliaUPC","Cordia New","CordiaUPC" ,"Courier New", "Comic Sans MS","Impact","Microsoft Sans Serif","MS Sans Serif","Small","System","Tahoma","Terminal","Times New Roman","Wingdings");


$fontname = file("fontlist.txt");
usort($fontname,'strcasecmp');
if(!isset($_GET['size'])){
	$_GET['size'] = "";
}
if(!isset($_GET['font'])){
	$_GET['font'] = "";
}
if(!isset($_GET['color'])){
	$_GET['color'] = "";
}
if(!isset($_GET['action'])){
	$_GET['action'] = "";
}
if(!isset($_GET['bold'])){
	$_GET['bold'] = "";
}
if(!isset($_GET['underline'])){
	$_GET['underline'] = "";
}
if(!isset($_GET['italic'])){
	$_GET['italic'] = "";
}

$fsize = intval(str_replace("pt","",$_GET['size']));
if ($fsize == "0") $fsize="";

if (trim($_GET['sample']) > ""){
	// @modify Phada Woodtikarn 24/07/2014 แก้ให้ภาษาไทยทำงาน
	//$sampletext = htmlspecialchars(trim($_GET[sample]));
	$sampletext = urldecode(trim($_GET['sample']));
	// @end
	if($sampletext == ''){
		$sampletext = "Example";
	}
}else{
	$sampletext = "Example";
}


if ($_GET['style'] > ""){
	$style = htmlspecialchars($_GET['style']);
}
?>
<html>
<head>
<title>Font Picker</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="../report.css" type="text/css" rel="stylesheet">
<script src="../js/jquery-1.10.1.min.js"></script>
<script src="../js/jquery-numeric.js"></script>
<script src="../js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="../js/kolorpicker/style/kolorpicker.css" type="text/css" />
<link rel="stylesheet" href="../common/font/AllFont.css" />
</head>

<body onFocus="ChangeStyle();">
<FORM name="fontform">
<TABLE BORDER=0 WIDTH="500" align="center" CELLSPACING=5 CELLPADDING=1>
<TR>
	<?php
	//<TD><A HREF="#" TITLE="Click to manage font list" ONCLICK="window.open('fontlist.php','fontlist_window','width=550, height=250, location=no,menubar=no,toolbars=no');">Font Name</A></TD>
	?>
    <td>
    	Font Name
    </td>
	<TD>
	<SELECT NAME="fontname" onChange="ChangeStyle();">
	<OPTION VALUE=""> (default)
	<?
		for ($i=0;$i<count($fontname);$i++){
			if (strtoupper($_GET['font']) == strtoupper($fontname[$i])){
				echo "<OPTION SELECTED>" . $fontname[$i];
			}else{
				echo "<OPTION>" . $fontname[$i];
			}
		}
	?>
	</SELECT>
	</TD>
	<TD>Font Size</TD>
	<TD><INPUT TYPE="text" id="fontsize" NAME="fontsize" size="3" maxlength="3" value="<?=$fsize?>" onChange="ChangeStyle();"></TD>
</TR>

<TR valign=top>
	<TD>Font Color</TD>
	<TD>
    <?php // @modify Phada Woodtikarn 24/07/2014 เพิ่มการเลือกสีแบบใหม่ และเก็บ css อื่นๆไว้?>
    <input type="text" name="fontcolor" size="10" class="kolorPicker" value="<?php echo $_GET['color']?>" onChange="ChangeStyle();">
    <input type="hidden" name="display" value="">
    <input type="hidden" name="padding" value="">
    <input type="hidden" name="margin" value="">
	<?php // @end ?>
    </TD>
	<td <?php echo $_GET['action']=='editreport'?'style="display:none"':'' ?>>Font Style</td>
	<td <?php echo $_GET['action']=='editreport'?'style="display:none"':'' ?>>
		<INPUT TYPE="checkbox" NAME="bold" <?php if ($_GET['bold']) echo "CHECKED"?> onClick="ChangeStyle();"> Bold<br>
		<INPUT TYPE="checkbox" NAME="underline" <?php if ($_GET['underline']) echo "CHECKED"?> onClick="ChangeStyle();"> UnderLine<br>
		<INPUT TYPE="checkbox" NAME="italic" <?php if ($_GET['italic']) echo "CHECKED"?> onClick="ChangeStyle();"> Italic<br>
	</td>
</TR>

<TR valign=top><TD COLSPAN=4 BGCOLOR=BLACK>
<table width="100%" align=center border=0 bgcolor=white>
<tr><td align=center>
<INPUT TYPE="text" id="test" NAME="test" style="border:none; width:100%; height:100%; text-align:center; <?=$style?>" value="<?=$sampletext?>">
</td></tr></table>

</TD></TR>

</TABLE>

<CENTER>
<BR>
<input type="Button" value=" Select Font " onClick="if (window.opener.obj1) {window.opener.obj1.value=GetStyle();} window.close();">
<input type="Button" value=" Cancel " onClick="window.close();">
</CENTER>
</FORM>
<?php // @modify Phada Woodtikarn 31/07/2014 เพิ่มให้การกรอก font size ใส่ได้เฉพาะตัวเลข ?>
<script>
	$(document).ready(function(){
		$('#fontsize').numeric();
	});
</script>
<?php // @end ?>
<script language="JavaScript">
<!-- 
function GetStyle(){
	var fx = document.forms[0];
	var st = "";
	if (fx.fontname.selectedIndex > 0){
		st = "font-family: " +fx.fontname.options[fx.fontname.selectedIndex].text + "; ";
	}

	if (fx.fontsize.value != ""){
		st += "font-size: " + fx.fontsize.value + "px; ";
	}

	if (fx.italic.checked){
		st += "font-style: italic; ";
	}

	if (fx.bold.checked){
		st += "font-weight: bold; ";
	}

	if (fx.underline.checked){
		st += "text-decoration: underline; ";
	}

	if (fx.fontcolor.value != ""){
		st += "color: " + fx.fontcolor.value.substring(0,7) + "; ";
	}
	
	if (fx.display.value != ""){
		st += "display: " + fx.display.value + "; ";
	}
	
	if (fx.padding.value != ""){
		st += "padding: " + fx.padding.value + "; ";
	}
	
	if (fx.margin.value != ""){
		st += "margin: " + fx.margin.value + "; ";
	}
	return (st);
}

function ChangeStyle(){
	var fx = document.forms[0];
	var st = fx.test.style;
	if (fx.fontname.selectedIndex > 0){
		st.fontFamily = fx.fontname.options[fx.fontname.selectedIndex].text;
	}else{
		st.fontFamily = "";  // default
	}

	if (fx.fontsize.value != ""){
		st.fontSize = fx.fontsize.value;
	}

	if (fx.fontcolor.value != ""){
		st.color = fx.fontcolor.value.substring(0,7);
	}

	if (fx.italic.checked){
		st.fontStyle="italic";
	}else{
		st.fontStyle="";
	}

	if (fx.bold.checked){
		st.fontWeight="bold";
	}else{
		st.fontWeight="";
	}

	if (fx.underline.checked){
		st.textDecoration="underline";
	}else{
		st.textDecoration="";
	}
}

function SetDefault(){
	var fx = document.forms[0];
	var st = fx.test.style;
	var i=0;
	for (i =0;i<fx.fontname.options.length;i++){
		if (st.fontFamily.toLowerCase().replace(/ /g,'').replace(/'/g,'') == fx.fontname.options[i].text.toLowerCase().replace(/ /g,'')){
			fx.fontname.selectedIndex = i;
			break;
		}
	}
	
	if (st.fontSize != ""){
		fx.fontsize.value = st.fontSize.replace('px','');
	}

	if (st.color != ""){
		fx.fontcolor.value = rgb2hex(st.color);
	}

	if (st.fontStyle=="italic"){
		fx.italic.checked = true;
	}else{
		fx.italic.checked = false;
	}

	if (st.fontWeight=="bold"){
		fx.bold.checked = true;
	}else{
		fx.bold.checked = false;
	}

	if (st.textDecoration=="underline"){
		fx.underline.checked = true;
	}else{
		fx.underline.checked = false;
	}

	if (st.display != ""){
		fx.display.value = st.display;
	}

	if (st.padding != ""){
		fx.padding.value = st.padding;
	}
	
	if (st.margin != ""){
		fx.margin.value = st.margin;
	}
}

// Do it at first time
SetDefault();
ChangeStyle();

function ylib_Browser()
{
	d=document;
	this.agt=navigator.userAgent.toLowerCase();
	this.major = parseInt(navigator.appVersion);
	this.dom=(d.getElementById)?1:0;
	this.ns=(d.layers);
	this.ns4up=(this.ns && this.major >=4);
	this.ns6=(this.dom&&navigator.appName=="Netscape");
	this.op=(window.opera? 1:0);
	this.ie=(d.all);
	this.ie4=(d.all&&!this.dom)?1:0;
	this.ie4up=(this.ie && this.major >= 4);
	this.ie5=(d.all&&this.dom);
	this.win=((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac=(this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

	function DisplayElement ( elt, displayValue ) {
		if ( typeof elt == "string" )
			elt = document.getElementById( elt );
		if ( elt == null ) return;

		if ( oBw && oBw.ns6 ) {
			// OTW table formatting will be lost:
			if ( displayValue == "block" && elt.tagName == "TR" )
				displayValue = "table-row";
			else if ( displayValue == "inline" && elt.tagName == "TR" )
				displayValue = "table-cell";
		}

		elt.style.display = displayValue;
	}

var obj1 = null;
function PickColor(obj){
	obj1 = obj;
	window.open('../color/color.htm','color_window','width=450, height=550, noresize,location=no,menubar=no,toolbars=no');
}

//--> 
function rgb2hex(rgb){
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 return "#" +
  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}
</script>

</body>
</html>