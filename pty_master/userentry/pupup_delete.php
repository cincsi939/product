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
	//echo $dbnamemaster;die;
	if($idcard == ""){
			$idcard = $idcard_assign;
	}
	
	$sql_main = "SELECT * FROM tbl_assign_key WHERE ticketid='$ticketid' AND idcard='$idcard' ";
	$resultm = mysql_db_query($dbnameuse,$sql_main) or die(mysql_error()."$sql_main<br>LINE__".__LINE__);
	$rsm = mysql_fetch_assoc($resultm);
	SaveLogAssignKey($ticketid,$idcard,$rsm[profile_id],$rsm[siteid],$rsm[fullname],"$rsm[approve]","delete","ลบข้อมูลรายละเอียดใบงาน");
	
	$sql_del = "DELETE FROM tbl_assign_key WHERE ticketid='$ticketid' AND idcard='$idcard'";
	mysql_db_query($db_name,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
	
	
	if($c_del != ""){ $c_del = $c_del;}else{ $c_del = 1;}
	$sql_up = "UPDATE log_pdf SET status_file='$c_del'  WHERE idcard='$idcard'";
	@mysql_db_query($dbnamemaster,$sql_up);
	
		if(!(mysql_error())){
				echo "<script language='javascript'>alert('ลบรายการเรียบร้อยแล้ว');opener.document.location.reload();
				opener.parent.leftFrame.location=opener.parent.leftFrame.location
				window.close();</script>";
		}

/*	if(!(mysql_error())){
		echo "<script>alert('ลบรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&staffid=$staffid&TicketId=$ticketid';</script>";
	}
*/


		
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
</script>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form name="form1" method="post" action="">
      <table width="400" border="0" cellspacing="1" cellpadding="5">
        <tr>
          <td colspan="2" align="center" bgcolor="#9A9CA6"><strong>กรุณาเหตุผลในการลบรายการ</strong></td>
          </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
          </tr>
        <tr>
          <td width="26%" align="right"><strong>เหตุผลการลบ : </strong></td>
          <td width="74%" align="left">
            <input name="c_del" type="radio" value="0">
            เนื่องจากเอกสารไม่ชัด 
            <input name="c_del" type="radio" value="1">
          อื่นๆ</td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" align="center"><label>
		 <input type="hidden" name="idcard" value="<?=$idcard?>">
		 <input type="hidden" name="ticketid" value="<?=$ticketid?>">
		 <input type="hidden" name="staffid" value="<?=$staffid?>">
         <input type="hidden" name="idcard_assign" value="<?=$idcard_assign?>">
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
