<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Text Editor</title>
<meta content="MSHTML 6.00.2800.1458" name="generator">
</head>
<body>
<style>
BODY { 
	background-image 	: none; 
	font						: 8pt 'MS Sans Serif';
	background-color	: #f8f8f8;
	margin-top				: 5 px;
	margin-left				: 5 px;		
}
.content {
	color						: #000000;
	background-color	: #ffffcc;
}
</style>
<script>TPATH='.'; VISUAL=1; SECURE=1;</script>
<script language="javascript" src="../libary/text_editControl.js"></script>
<table class="editor" cellSpacing="0" cellPadding="0" width="100%" border="0">
<tbody>
  <tr>
    <td width="100%">	
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td height="20" width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('refresh')" 
			onmouseout="button_out(this);" height="20" alt="New Document" hspace="1" src="../images/txt_edit/newdocument.gif" width="20" 
			align="absMiddle" vspace="1">	
	</td>
    <td width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('bold')" 
    		onmouseout="button_out(this);" height="20" alt="Bold" hspace="1" src="../images/txt_edit/bold.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
    <td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('italic')" 
      		onmouseout="button_out(this);" height="20" alt="Italic" hspace="1"  src="../images/txt_edit/italic.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
    <td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('underline')" 
      		onmouseout="button_out(this);" height="20" alt="Underline" hspace="1" src="../images/txt_edit/underline.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
	<td width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('StrikeThrough')" 
        onmouseout="button_out(this);" height="20" alt="Strike-through" hspace="1" src="../images/txt_edit/strikethrough.gif" width="20" 
		align="absMiddle" vspace="1">	
	</td>	
    <td width="10" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
    <td width="22">
<img 	id="color" onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="foreColor()" 
			onmouseout="button_out(this);" height="20" alt="Font Color" hspace="1" src="../images/txt_edit/forecolor.gif" width="20" 
			align="absMiddle" vspace="1">
	</td>
	<td width="22">
<img 	id="backcolor" onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="backColor()" 
			onmouseout="button_out(this);" height="20" alt="Background Color" hspace="1" src="../images/txt_edit/backcolor.gif" width="20" 
			align="absMiddle" vspace="1">	
	</td>	
    <td width="10" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>	
	<td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyLeft')" 
      		onmouseout="button_out(this);" height="20" alt="Justify Left" hspace="1" src="../images/txt_edit/justifyleft.gif" width="20" align="absMiddle"
			vspace="1">	
	</td>
	<td width="22">		
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyCenter')" 
      		onmouseout="button_out(this);" height="20" alt="Center" hspace="1" src="../images/txt_edit/justifycenter.gif" width="20" align="absMiddle" 
	  		vspace="1">	
	</td>
	<td width="22">		 
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyRight')" 
      		onmouseout="button_out(this);" height="20" alt="Justify Right" hspace="1" src="../images/txt_edit/justifyright.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
	<td width="22">		
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyFull')" 
      		onmouseout="button_out(this);" height="20" alt="Justify Right" hspace="1" src="../images/txt_edit/justifyfull.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>	
    <td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>				
    <td width="110" align="center">
<select style="width:110px; height:19px; font-family:Tahoma; font-size:11px;" onChange="cmdExec('fontname',this[this.selectedIndex].value);"> 
	<option selected>Font</option> 
  	<option value="Angsana New">Angsana New</option>
  	<option value="MS Sans Serif">MS Sans Serif</option> 
  	<option value="Tahoma">Tahoma</option>
</select>	
	</td>
    <td width="65">
<select style="width: 65px; height:19px; font-family:Tahoma; font-size:11px;" onChange="cmdExec('fontsize',this[this.selectedIndex].value);"> 
	<option selected>Size</option> 
	<option value="1">1</option> 
	<option value="2">2</option> 
	<option value="3">3</option> 
	<option value="4">4</option> 
    <option value="5">5</option> 
	<option value="6">6</option> 
	<option value="7">7</option> 
	<option value="8">8</option> 
	<option value="9">9</option> 
    <option value="10">10</option>
</select>	
	</td>
    <td>&nbsp;</td>
    </tr>
</table>
	</td>
</tr>
<tr>
	<td>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td height="20" width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('cut')" 
			onmouseout="button_out(this);" height="20" alt="Cut" hspace="1" src="../images/txt_edit/cut.gif" width="20" align="absMiddle" 
			vspace="1"> 	
	</td>
	<td width="22">	
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('copy')" 
			onmouseout="button_out(this);" height="20" alt="Copy" hspace="1" src="../images/txt_edit/copy.gif" width="20" align="absMiddle" 
			vspace="1"> 
	</td>
	<td width="22">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('paste')" 
      		onmouseout="button_out(this);" height="20" alt="Paste" hspace="1" src="../images/txt_edit/paste.gif" width="20" align="absMiddle" 
			vspace="1">
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
	<td width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('Undo')" 
      		onmouseout="button_out(this);" height="20" alt="Undo" hspace="1" src="../images/txt_edit/undo.gif" width="20" align="absMiddle" 
			vspace="1">			
	</td>
	<td width="22">		
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('Redo')" 
      		onmouseout="button_out(this);" height="20" alt="Redo" hspace="1" src="../images/txt_edit/redo.gif" width="20" align="absMiddle" 
			vspace="1">
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
	<td width="22">	
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('insertorderedlist')" 
      		onmouseout="button_out(this);" height="20" alt="Ordered List" hspace="1" src="../images/txt_edit/numlist.gif" width="20" align="absMiddle" 
			vspace="1"> 
	</td>
	<td width="22">			
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('insertunorderedlist')" 
      		onmouseout="button_out(this);" height="20" alt="Unordered List" hspace="1" src="../images/txt_edit/bullist.gif" width="20" align="absMiddle"	
			vspace="1"> 
	</td>
	<td width="22">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('outdent')" 
      		onmouseout="button_out(this);" height="20" alt="Decrease Indent" hspace="1" src="../images/txt_edit/outdent.gif" width="20" align="absMiddle" 
	  		vspace="1"> 
	</td>
	<td width="22">			
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('indent')" 
      		onmouseout="button_out(this);" height="20" alt="Increase Indent" hspace="1" src="../images/txt_edit/indent.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>		
	<td width="22">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('createLink')" 
      		onmouseout="button_out(this);" height="20" alt="Insert Link" hspace="1" src="../images/txt_edit/link.gif" width="20" align="absMiddle" 
			vspace="1"> 
	 
	</td>
	<td width="22">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('unlink')" 
      		onmouseout="button_out(this);" height="20" alt="Delete Link" hspace="1" src="../images/txt_edit/unlink.gif" width="20" align="absMiddle" 
			vspace="1"> 	
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>	
	<td width="22">		
<img 	id="image" onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="insert_image()" 
			onmouseout="button_out(this);" height="20" alt="Forecolor" src="../images/txt_edit/image.gif" width="20" align="absMiddle"  
			vspace="1">
	</td>
	<td width="22" align="center">	
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" 
			onClick="db_image('<?=$id?>')" onMouseOut="button_out(this);" height="18" alt="Image From Database" 
			src="../images/txt_edit/imgfolder.gif" width="18" align="absMiddle" vspace="1" <?=$disable?>>
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
	<td width="22" align="center">	
<img 	onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('InsertHorizontalRule')" 
      		onMouseOut="button_out(this);" height="20" alt="Insert Horizontal Rule" hspace="1" src="../images/txt_edit/hr.gif" width="20" 
			align="absMiddle" vspace="1"> 
	</td>	
	<td width="22" align="center">			
<img 	onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('removeformat')" 
      		onMouseOut="button_out(this);" height="20" alt="Remove Format" hspace="1" src="../images/txt_edit/removeformat.gif" width="20" 
			align="absMiddle" vspace="1"> 			
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
	<td width="22" align="center">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('SuperScript')" 
      		onmouseout="button_out(this);" height="20" alt="superscript" hspace="1" src="../images/txt_edit/sup.gif" width="20" align="absMiddle"
			vspace="1"> 
	</td>
	<td width="22" align="center">			
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('SubScript')" 
			onmouseout="button_out(this);" height="20" alt="Subscript" hspace="1" src="../images/txt_edit/sub.gif" width="20" align="absMiddle" 
			vspace="1">	</td>				
	<td width="54"></td>
</tr>
</table>		 
	</td>
</tr>
</tbody>
</table> 
<table cellSpacing="0" cellPadding="0" border="1" width="100%">
<tbody>
<tr>
    <td vAlign="top">
	<iframe id="idContent" src="contents.php" frameBorder="0" width="100%" scrolling="yes" height="350"></iframe>
	</td>
</tr>	
<tr>
	<td>
<table width="385" border="0" cellPadding="2" cellSpacing="1" bgColor="#dddddd">
<tbody>
<tr bgColor="white">
	<td width="19"><a href="javascript:insertEmotion('regular_smile')">
	<img height="19" alt="smile" src="../images/emotion/regular_smile.gif" width="19" border="0"></a></td>
	<td width="19"><a href="javascript:insertEmotion('teeth_smile')">
	<img height="19" alt="cheese" src="../images/emotion/teeth_smile.gif" width="19" border="0"></a></td>
     <td width="19"><a href="javascript:insertEmotion('wink_smile')">
	 <img height="19" alt="wink" src="../images/emotion/wink_smile.gif" width="19" border="0"></a></td>
	<td width="19"><a href="javascript:insertEmotion('rose')">
	<img height="19" alt="rose" src="../images/emotion/rose.gif" width="19" border="0"></a></td>
 	<td width="19"><a href="javascript:insertEmotion('wilted_rose')">
	<img height="19" alt="wilted rose" src="../images/emotion/wilted_rose.gif" width="19" border="0"></a></td>
	<td width="19"><a href="javascript:insertEmotion('heart')">
	<img height="19" alt="heart" src="../images/emotion/heart.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('broken_heart')">
	<img height="19" alt="hurt" src="../images/emotion/broken_heart.gif" width="19" border="0"></a></td>
	<td width="19"><a href="javascript:insertEmotion('kiss')">
	<img height="19" alt="kiss" src="../images/emotion/kiss.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('angry_smile')">
	<img height="19" alt="angry" src="../images/emotion/angry_smile.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('confused_smile')">
	<img height="19" alt="confuse" src="../images/emotion/confused_smile.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('sad_smile')">
	<img height="19" alt="sad" src="../images/emotion/sad_smile.gif" width="19" border="0"></a></td>	
	 <td width="19"><a href="javascript:insertEmotion('cry_smile')">
	 <img height="19" alt="cry" src="../images/emotion/cry_smile.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('star')">
	<img height="19" alt="star" src="../images/emotion/star.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('tounge_smile')">
	<img height="19" alt="tounge" src="../images/emotion/tounge_smile.gif" width="19" border="0"></a></td>
    <td width="19"><a href="javascript:insertEmotion('omg_smile')">
	<img height="19" alt="oh oh" src="../images/emotion/omg_smile.gif" width="19" border="0"></a>	</td>
    <td width="24"><a href="javascript:insertEmotion('embaressed_smile')">
	<img height="19" alt="embaressed" src="../images/emotion/embaressed_smile.gif" width="19" border="0"></a></td>
</tr>
</tbody>
</table>	
	</td>
</tr>	
</tbody>
</table>
</body>
</html>