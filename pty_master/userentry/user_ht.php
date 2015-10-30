<?
session_start();
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");
include("epm.inc.php");
include("function.php");
?>
<form name="post">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#A0A0A0">
   	<td height="20" colspan="2" bgcolor="#DADCED"><span style="font-size:11pt; font-weight:bold">สถิติการเข้าใช้งานระบบ</span></td>
</tr>	
<tr bgcolor="#FFFFFF">
   	<td colspan="2" bgcolor="#F2F4F7" style="border-style:inset; border-top:#BCBFDE 1 solid; border-left:#BCBFDE 1 solid;border-bottom:#ffffff 1 solid;border-right:#ffffff 1 solid;" >
	<iframe name="history" src="user_history.php" id="ipreview" frameborder="0" height="431" width="100%" scrolling="no">	</iframe>	</td>
</tr>
</table>	
</form>