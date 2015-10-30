<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	//echo $dbnamemaster;die;
	$sql_del = "DELETE FROM tbl_checklist_assign_detail  WHERE ticketid='$ticketid' AND idcard='$idcard' AND profile_id='$profile_id' and activity_id='$activity_id'";
	@mysql_db_query($dbname_temp,$sql_del);
//	echo $dbname_temp." :: ".$sql_del;die;
	SaveLogAssign($idcard,"",$ticketid,"delete","$comment");
	
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

function CheckF(){
	if(document.form1.comment.value == ""){
		alert("กรุณาระบุเหตุผลการลบ");
		document.form1.comment.focus();
		return false;	
	}//end 
}// end function CheckF(){

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
          <td width="74%" align="left"><label>
            <input name="comment" type="text" id="comment" size="30">
          </label></td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" align="center"><label>
		 <input type="hidden" name="idcard" value="<?=$idcard?>">
		 <input type="hidden" name="ticketid" value="<?=$ticketid?>">
		 <input type="hidden" name="staffid" value="<?=$staffid?>">
         <input  type="hidden" name="profile_id" value="<?=$profile_id?>">
         <input type="hidden" name="activity_id" value="<?=$activity_id?>">
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
