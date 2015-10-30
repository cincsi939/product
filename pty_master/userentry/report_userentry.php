<?
session_start();
include "epm.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="../../common/style.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#F2F4F7">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr style="background-color:#E0E0E0;">
    <td background="images/login_right2_04.gif" width="1%" valign="top"><img src="images/login_right2_03.gif" width="6" height="24"></td>
    <td width="98%"><table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/login_right2_04.gif">
      <tr class="headerTB">
        <td width="28%">รายการบันทึกข้อมูล</td>
        <td width="0%"><img src="images/login_right2_06.gif" width="2" height="30" align="absmiddle"></td>
        <td width="72%" align="right">&nbsp;</td>
      </tr>
    </table></td>
    <td background="images/login_right2_04.gif" width="1%" valign="top" align="right">
	<img src="images/login_right2_08.gif" width="6" height="24"></td>
  </tr>
  <tr valign="top">
    <td colspan="3" height="350"><table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#404040">
      <tr bgcolor="#E0E0E0">
        <th width="5%" height="20" class="table_head_text">ลำดับ</th>
        <th width="27%" class="table_head_text">ชื่อ นามสกุล </th>
        <th width="19%" class="table_head_text">&nbsp;</th>
        <th width="18%" class="table_head_text">&nbsp;</th>
        <th width="31%" class="table_head_text">&nbsp;</th>
      </tr>
      <tr bgcolor="<?=$bg?>">
        <td height="20" align="center"><a href="project_summary.php?action=view&epm_id=<?=$rs[epm_id]?>">
          <?=$i?>
        </a></td>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr bgcolor="<?=$bg?>">
        <td height="20" align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</BODY>
</HTML>