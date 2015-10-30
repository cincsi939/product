<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
include("function_assign.php");

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	$sql_up = "UPDATE log_pdf SET status_file='0'  WHERE idcard='$idcard'";
	@mysql_db_query($dbnamemaster,$sql_up);
		if(!(mysql_error())){
				echo "<script language='javascript'>alert('ลบรายการเรียบร้อยแล้ว');opener.document.location.reload();window.close();</script>";
		}
		
	} // end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
    document.location = delUrl;
  }
}
</script></head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form name="form1" method="post" action="">
      <table width="400" border="0" cellspacing="1" cellpadding="5">
        <tr>
          <td width="100%" align="center" bgcolor="#9A9CA6"><strong>ยื่นยันการปัญหาเอกสาร</strong></td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
          </tr>
        <tr>
          <td align="center"><label>
		 <input type="hidden" name="idcard" value="<?=$idcard?>">
            <input type="submit" name="Submit" value="ยืนยันการลบข้อมูล">
            &nbsp;
            <input type="button" name="Clos" value="ปิดหน้าต่าง"  onClick="window.close();opener.document.location.reload();">
          </label></td>
          </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</BODY>
</HTML>
