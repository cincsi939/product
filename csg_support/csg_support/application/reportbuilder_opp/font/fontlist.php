<?
/*****************************************************************************
Function		: เพิ่ม/ลบ รายชื่อ font ในระบบ โดยเก็บไว้ใน fontlist.txt (อย่าลืม change mode หาก upload ขึ้น server)
Version			: 1.0
Last Modified	: 28/7/2548
Changes		:

*****************************************************************************/

//$fontname = Array("Angsana New","AngsanaUPC","Arial","Browallia New","BrowalliaUPC","Cordia New","CordiaUPC" ,"Courier New", "Comic Sans MS","Impact","Microsoft Sans Serif","MS Sans Serif","Small","System","Tahoma","Terminal","Times New Roman","Wingdings");

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	$f1 = fopen("fontlist.txt","wt");
	fputs($f1,$_POST['fontlist']);
	fclose($f1);

	$msg = "Font Name has already saved.";
}

// read fontlist from file
$fontname = file("fontlist.txt");
usort($fontname,'strcasecmp');

?>
<html>
<head>
<title>Add / Remove Font Name</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="../report.css" type="text/css" rel="stylesheet">
</head>

<body>

<FORM name="fontform" ACTION="?" METHOD="POST">
<INPUT TYPE="hidden" NAME="fontlist" VALUE="">

<TABLE BORDER=0 WIDTH="500" align="center" CELLSPACING=5 CELLPADDING=1>

<TR>
	<TD><B>Font Name</B><BR>
	<SELECT NAME="fontname" size=10 style="width:200; background:#99CCDD;">
	<?
		for ($i=0;$i<count($fontname);$i++){
			echo "<OPTION>" . $fontname[$i];
		}
	?>
	</SELECT>
	</TD>

	<TD>
	<INPUT TYPE="button" NAME="remove" VALUE="  >  " TITLE="Remove Font" ONCLICK="RemoveFont();"><BR><BR>
	<INPUT TYPE="button" NAME="remove" VALUE="  <  " TITLE="Restore Font" ONCLICK="RestoreFont();">
	</TD>

	<TD><B>UnUse Font</B><BR><select name="unuse" size=10 style="width:200;background:#CCCCCC;"></select></TD>

</TR>

<tr>
<td>
<INPUT TYPE="text" NAME="newfont" size=20 maxlength=100> 
<INPUT TYPE="button" NAME="add" VALUE=" Add " TITLE="Add new Font" ONCLICK="AddFont();">
</td>

<td>&nbsp;</td>

<td>
<INPUT TYPE="button" VALUE=" Save Font Name " ONCLICK="document.fontform.submit();" style="width: 130;">
<INPUT TYPE="button" VALUE=" Close " ONCLICK="window.close();"  style="width: 65;">
</td>

</tr>
</table>

<CENTER><FONT SIZE="+1" COLOR="RED"><B><?=$msg?></B></FONT></CENTER>
</FORM>


<SCRIPT LANGUAGE="JavaScript">
<!--
function RemoveFont(){
	var x = document.fontform;
	if (x.fontname.selectedIndex >= 0){
		// add to unuse box
		fontname=x.fontname.options[x.fontname.selectedIndex].text;
		newoption = new Option(fontname, fontname, false, false); 
		x.unuse.options[x.unuse.length] = newoption;
		
		//remove from fontname list
		x.fontname.options[x.fontname.selectedIndex] = null;
	}
	
	UpdateList();
}

function RestoreFont(){
	var x = document.fontform;
	if (x.unuse.selectedIndex >= 0){
		// add to fontname box
		fontname=x.unuse.options[x.unuse.selectedIndex].text;
		newoption = new Option(fontname, fontname, false, false); 
		x.fontname.options[x.fontname.length] = newoption;
		x.fontname.selectedIndex = x.fontname.length-1;
		
		//remove from unuse list
		x.unuse.options[x.unuse.selectedIndex] = null;
	}
	
	UpdateList();
}

function AddFont(){
	var x = document.fontform;
	if (x.newfont.value){
		// add to fontname box
		fontname=x.newfont.value;
		newoption = new Option(fontname, fontname, false, false); 
		x.fontname.options[x.fontname.length] = newoption;
		x.fontname.selectedIndex = x.fontname.length-1;
		
		//remove from textbox
		x.newfont.value="";
	}
	
	UpdateList();
}

function UpdateList(){
	var x = document.fontform;
	x.fontlist.value="";
	for (var i=0;i<x.fontname.length;i++){
		x.fontlist.value += x.fontname.options[i].text+"\n";	
	}

}

UpdateList();
window.opener.location.reload()
//-->
</SCRIPT>

</body>
</html>