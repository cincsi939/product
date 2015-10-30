<?
include("../libary/config.inc.php");
$id			= $id;
$result 		= mysql_query("select no, location from `news_pic` where id='$id' order by no")or die("Query line " . __LINE__ . " error<hr>".mysql_error());	
$row			= mysql_num_rows($result);
$disable		= ($row <= 0) ? " disabled " : "" ;
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" rel="stylesheet" type="text/css" />
<title>Insert Image from URL</title>
<script language="javascript">
function onPreview() {
  var f_url = document.getElementById("imageurl");
  var url = f_url.value;
  if (!url) {
    alert("You have to enter an URL first");
    f_url.focus();
    return false;
  }
  window.ipreview.location.replace(url);
  return false;
};

function Accept(){
  	var f_url = document.getElementById("imageurl");
  	var url = f_url.value;
  	if (!url) {
    	alert("You have to enter an URL first");
    	f_url.focus();
    	return false;
	} else {	
	
	var image = '<img src="' + document.getElementById('imageurl').value + '" alt="' + document.getElementById('alt').value + '" align="' ;
	image		+= document.getElementById('alignment').value + '" border="' + document.getElementById('borderThickness').value ;
	image		+= '" hspace="' + document.getElementById('horizontal').value + '" vspace="' + document.getElementById('vertical').value + '">';

	window.opener.idContent.document.selection.createRange().pasteHTML(image); 	
	window.close();	
	}
}
</script>
</head>
<body bgcolor="#f8f8f8"> 
<table width="400" border="0" cellspacing="0" cellpadding="0" class="normal">
<tr>
	<td colspan="2">
<table width="400" border="0" cellspacing="0" cellpadding="2" class="normal">
<tr>
    <td colspan="2" height="20">&nbsp;<b class="normal_blue">Insert Image From DB</b></td>
</tr>
<tr>
	<td width="95" height="20" align="right">Image URL&nbsp;<b>:</b>&nbsp;</td>
    <td width="297"><select name="imageurl" id="imageurl" onChange="onPreview();" style="width:285px;" class="input" <?=$disable?>>
  <option value="" class="normal_blue">Preview Image</option>
<?  

while($rs = mysql_fetch_assoc($result)){
	$i = $i + 1;
	echo "<option value=\"../main/images/news/".$rs[location]."\" class=\"normal\">¿“æ∑’Ë $i</option>";			
}	
mysql_free_result($result);	 
?> 	
  </select>	
	</td>
</tr>	
<tr>
	<td height="20" align="right">Alternate text&nbsp;<b>:</b>&nbsp;</td>
    <td><input type="text" name="alt" id="alt" value="" class="input" style="width:285px;"></td>
</tr>	
</table>	
	</td>	
</tr>
<tr>
    <td width="200">
<fieldset style="float: left; width:180px;" class="fieldset">
<legend>Layout</legend>
<table width="175" border="0" cellspacing="0" cellpadding="0" class="normal">
<tr>
    <td height="3" colspan="2"></td>
</tr>
<tr>
    <td width="75" height="20" align="right">Align&nbsp;<b>:</b>&nbsp;</td>
	<td width="100"><select name="alignment" id="alignment" class="input" style="width:100px;">
      <option value="">Not Set</option>
      <option value="left">Left</option>
      <option value="right">Right</option>
      <option value="texttop">Texttop</option>
      <option value="absmiddle">Absmiddle</option>
      <option value="baseline">Baseline</option>
      <option value="absbottom" selected="selected">Absbottom</option>
      <option value="bottom">Bottom</option>
      <option value="middle">Middle</option>
      <option value="top">Top</option>
    </select></td>
</tr>
<tr>
    <td align="right">Border&nbsp;<b>:</b>&nbsp;</td>
	<td><select name="borderThickness" id="borderThickness" class="input" style="width:100px;">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select></td>
</tr>
<tr>
    <td height="3" colspan="2"></td>
</tr>
</table>
</fieldset>			
	</td>
    <td width="200">
<fieldset style="float: right; width:180px;" class="fieldset">
<legend>Space</legend>
<table width="175" border="0" cellspacing="0" cellpadding="0" class="normal">
<tr>
    <td height="3" colspan="2"></td>
</tr>
<tr>
    <td width="75" height="20" align="right">Horizontal&nbsp;<b>:</b>&nbsp;</td>
	<td width="100"><select name="horizontal" id="horizontal" class="input" style="width:100px;">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select></td>
</tr>
<tr>
    <td align="right">Vertical&nbsp;<b>:</b>&nbsp;</td>
	<td><select name="vertical" id="vertical" class="input" style="width:100px;">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select></td>
</tr>
<tr>
    <td height="3" colspan="2"></td>
</tr>
</table>
</fieldset>	
	</td>
</tr>
<tr>
	<td colspan="2" height="20">&nbsp;<img src="../images/dtree/imgfolder.gif" width="18" height="18" align="absmiddle">
	<b class="normal_blue">Image Preview</b></td>
</tr>	
<tr align="center">
	<td colspan="2">
<table width="400" border="0" cellspacing="0" cellpadding="2">
<tr>
    <td><iframe name="ipreview" id="ipreview" frameborder="0" style="border:1px solid #dddddd;" height="200" width="100%" src=""></iframe></td>
</tr>
</table>	
	</td>
</tr>
<tr>
	<td height="4" colspan="2"></td>
</tr>
<tr align="center" valign="middle">
	<td height="25" colspan="2">
	<button type="button" style="width:60px;" name="ok" onClick="return Accept();">OK</button>††
    <button type="button" style="width:60px;" name="cancel" onClick="self.close();">Cancel</button>	
	</td>
</tr>
</table>
</body>
</html>