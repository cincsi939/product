<?
$path_config = '../../../';
include("../checklist2.inc.php");
?>
<HTML><HEAD><TITLE>����Ң����Ũҡ��� excel ��� checklist �����繢����ŵ�駵�</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="javascript">

function chFrom(){
	 if(document.form1.name.value == ""){
			alert("��س���������");
			document.form1.name.focus();
			return false;
	
	}
	return true;
}


</script>

</HEAD>
<BODY bgcolor="#A5B2CE"><br>
<br>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr align="center"><td align="center">
<form action="processxls_checklist.php?process=execute&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chFrom();">
  <fieldset >
    <legend><strong> �к�����Ң����� checklist �ҡ��� excel �����繢����ŵ�駵�㹡�õ�Ǩ�͡��� �.�.7 �鹩�Ѻ  <?=show_area($xsiteid);?></strong>  </legend>
      <table width="100%" border="0">
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
          <td width="17%" align="right" >����������� : </td>
      <td width="79%"><?=ShowProfile_name($profile_id);?> </td>
      <td width="4%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" >���������� :</td>
      <td><input name="name" type="file" id="name"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="submit" name="Submit" value=" upload "></td>
      <td>&nbsp;</td>
    </tr>
    </table>
  </fieldset>
</form>
</td>
</tr>
</table>

</BODY>
</HTML>