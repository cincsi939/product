
<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");

?>

<html>
<head>
<title>เลือกประเภทการแสดงผลข้อมูล</title>
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



function show_table1() {
	if(document.form1.type_doc[2].checked == true){
			document.getElementById("table1").style.display = "";
			document.getElementById("table2").style.display = "none";
	}else if(document.form1.type_doc[3].checked == true){
		document.getElementById("table1").style.display = "none";
		document.getElementById("table2").style.display = "";
	}
}



function submitfrom(){
	var profile_id="<?=$profile_id?>";
	var xsiteid = "<?=$xsiteid?>";
	var xlv="<?=$xlv?>";
	var schoolid="<?=$schoolid?>";
	var typep = document.form1.type_problem.value;
	var pid = document.form1.problem_status_id.value;

	if(document.form1.type_doc[0].checked == true){
		xid = "1";	
	}else if(document.form1.type_doc[1].checked == true){
		xid = "2";	
	}else if(document.form1.type_doc[2].checked == true){
		xid = "3";	
	}else if(document.form1.type_doc[3].checked == true){
		xid = "4";	
	}
	//alert(xlv);
	window.opener.location='report_document_problem.php?type_doc='+xid+'&profile_id='+profile_id+'&xsiteid='+xsiteid+'&xlv='+xlv+'&typeproblem='+typep+'&schoolid='+schoolid+'&problem_status_id='+pid;
	window.close();
}
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="" onSubmit="return submitfrom();">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" bgcolor="#DBDBDB"><strong>เลือกรูปแบบการแสดงผลข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="21%" align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="radio" value="1" onClick="show_table1(this.value)">
          </label></td>
          <td width="79%" align="left" bgcolor="#EFEFEF">แสดงรายละเอียดรายโรงเรียน</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="radio2" value="2" onClick="show_table1(this.value)">
          </label></td>
          <td align="left" bgcolor="#EFEFEF">แสดงรายละเอียดรายบุคคล</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="radio3" value="3" onClick="show_table1(this.value)">
          </label></td>
          <td align="left" bgcolor="#EFEFEF">แสดงข้อมูลรายหมวดปัญหา</td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#EFEFEF">
          <table width="100%" border="0" cellspacing="1" cellpadding="3" id="table1" style="display:none">
            <tr>
              <td width="21%" align="right">เลือกหมวดปัญหา</td>
              <td width="79%" align="left">
                <select name="type_problem" id="type_problem">
                <option value="99">แสดงหมวดปัญหาทั้งหมด</option>
                <option value="100">ขาดเอกสารประกอบ</option>
                <?
                	$sqlp = "SELECT * FROM tbl_problem ORDER BY problem_id ASC";
					$resultp = mysql_db_query($dbname_temp,$sqlp);
					while($rsp = mysql_fetch_assoc($resultp)){
							echo "<option value='$rsp[problem_id]'>$rsp[problem]</option>>";
					}//end while($rsp = mysql_fetch_assoc($resultp)){
				?>
                </select>
              </td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF">
            <input type="radio" name="type_doc" id="radio4" value="4" onClick="show_table1(this.value)">
          </td>
          <td align="left" bgcolor="#EFEFEF">แสดงข้อมูลแยกสถานะการแก้ไขเอกสาร</td>
        </tr>
        <tr>
          <td colspan="2" align="right" bgcolor="#EFEFEF"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="table2" style="display:none">
            <tr>
              <td width="21%" align="right">เลือกสถานะการแก้ไขเอกสาร</td>
              <td width="79%" align="left">
                <select name="problem_status_id" id="problem_status_id">
                <?
                	$sql_problem_status = "SELECT * FROM tbl_checklist_problem_status ORDER BY orderby ASC";
					$result_ps = mysql_db_query($dbname_temp,$sql_problem_status);
					while($rsps = mysql_fetch_assoc($result_ps)){
						if($rsps[problem_status_id] == $problem_status_id){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$rsps[problem_status_id]'>$rsps[problen_status_name]</option>";
					}//end  while($rsps = mysql_fetch_assoc($result_ps)){
						
				?>
                </select>
              </td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td bgcolor="#EFEFEF">&nbsp;</td>
          <td bgcolor="#EFEFEF"><label>
            <input type="submit" name="button" id="button" value="ตกลง">
            <input type="button" name="btn" id="btnC" value="ปิดหน้าต่าง" onClick="window.close();">
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script language="javascript">
/*function getCust_Data(id){
*///	var profile_id="<?//=$profile_id?>";
//	var xsiteid = "<?//=$xsiteid?>";
//	var xlv="<?//=$xlv?>";
//	//alert(xlv);
//window.opener.location='report_document_problem.php?type_doc='+id+'&profile_id='+profile_id+'&xsiteid='+xsiteid+'&xlv='+xlv;
//window.close();

//}
</script>

</BODY>
</HTML>
