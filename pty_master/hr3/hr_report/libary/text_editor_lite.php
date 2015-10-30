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
</select>	
	</td>
	<td width="12" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>				
    <td width="22">
<img 	onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('bold')" 
    		onmouseout="button_out(this);" height="20" alt="ตัวหนา" hspace="1" src="../images/txt_edit/bold.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
    <td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('italic')" 
      		onmouseout="button_out(this);" height="20" alt="ตัวเอียง" hspace="1"  src="../images/txt_edit/italic.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
    <td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('underline')" 
      		onmouseout="button_out(this);" height="20" alt="ขีดเส้นใต้" hspace="1" src="../images/txt_edit/underline.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
	<td width="22" align="center">			
<img 	onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('removeformat')" 
      		onMouseOut="button_out(this);" height="20" alt="ลบรูปแบบที่เลือก" hspace="1" src="../images/txt_edit/removeformat.gif" width="20" 
			align="absMiddle" vspace="1"> 			
	</td>	
    <td width="10" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>
    <td width="22">
<img 	id="color" onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="foreColor()" 
			onmouseout="button_out(this);" height="20" alt="สีตัวอักษร" hspace="1" src="../images/txt_edit/forecolor.gif" width="20" 
			align="absMiddle" vspace="1">
	</td>
	<td width="22">
<img 	id="backcolor" onMouseUp="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="backColor()" 
			onmouseout="button_out(this);" height="20" alt="สีพื้นหลัง" hspace="1" src="../images/txt_edit/backcolor.gif" width="20" 
			align="absMiddle" vspace="1">	
	</td>	
    <td width="10" align="center"><img src="../images/txt_edit/spacer.gif" width="1" height="15" align="middle"></td>	
	<td width="22">
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyLeft')" 
      		onmouseout="button_out(this);" height="20" alt="ชิดซ้าย" hspace="1" src="../images/txt_edit/justifyleft.gif" width="20" align="absMiddle"
			vspace="1">	
	</td>
	<td width="22">		
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyCenter')" 
      		onmouseout="button_out(this);" height="20" alt="กึ่งกลาง" hspace="1" src="../images/txt_edit/justifycenter.gif" width="20" align="absMiddle" 
	  		vspace="1">	
	</td>
	<td width="22">		 
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyRight')" 
      		onmouseout="button_out(this);" height="20" alt="ชิดขวา" hspace="1" src="../images/txt_edit/justifyright.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>
	<td width="22">		
<img    onmouseup="button_up(this);" onMouseDown="button_down(this);" onMouseOver="button_over(this);" onClick="cmdExec('JustifyFull')" 
      		onmouseout="button_out(this);" height="20" alt="เท่ากันทั้งสองด้าน" hspace="1" src="../images/txt_edit/justifyfull.gif" width="20" align="absMiddle" 
			vspace="1">	
	</td>	   
    <td>&nbsp;</td>
</tr>
</table>
	</td>
</tr>
</tbody>
</table> 
<table cellSpacing="0" cellPadding="0" border="1" width="100%">
<tbody>
<tr vAlign="top">
    <td><iframe id="idContent" src="contents.php" frameBorder="0" width="100%" scrolling="yes" height="300"></iframe></td>
</tr>		
</tbody>
</table>
</body>
</html>