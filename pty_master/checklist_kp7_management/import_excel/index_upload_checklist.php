<?
$path_config = '../../../';
include("../checklist2.inc.php");
?>
<HTML><HEAD><TITLE>นำเข้าข้อมูลจากไฟล์ excel เข้า checklist เพื่อเป็นข้อมูลตั้งต้น</TITLE>
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
			alert("กรุณาไฟล์ข้อมูล");
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
    <legend><strong> ระบบนำเข้าข้อมูล checklist จากไฟล์ excel เพื่อเป็นข้อมูลตั้งต้นในการตรวจเอกสาร ก.พ.7 ต้นฉบับ  <?=show_area($xsiteid);?></strong>  </legend>
      <table width="100%" border="0">
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
          <td width="17%" align="right" >โฟร์ไฟล์ข้อมูล : </td>
      <td width="79%"><?=ShowProfile_name($profile_id);?> </td>
      <td width="4%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" >ส่งไฟล์ข้อมูล :</td>
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