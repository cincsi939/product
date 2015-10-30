<html>
<TITLE>ตรวจสอบข้อมูล Competency</TITLE>
<META content="text/html; charset=windows-874" http-equiv=Content-Type>
<link href="../../common/popup_calenda/calendar_style.css"rel=stylesheet type="text/css">
<script src="../../common/popup_calenda/popcalendar.js" type="text/javascript"></script>
<script language="javascript">
var imgDir_path="../../common/popup_calenda/images/calendar/";
function showvalue(){
	alert(document.getElementById('text').value)
}

</script>

</HEAD>
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%">&nbsp;</td>
    <td width="88%">&nbsp;<input type="text" readonly name="text" id="text" value="" />
<input type="button" name="but" id="but" value="..."   onClick='popUpCalendar(document.getElementById("text"), document.getElementById("text"), "dd/mm/yyyy","showvalue()") ;return false '/></td>
  </tr>
</table>
</BODY>
</HTML>
<?

?>
