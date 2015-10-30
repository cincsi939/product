<?
session_start();
include("function.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Salary wizard</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript">
var req;
function getsum()
{
	if (window.XMLHttpRequest)
		req=new XMLHttpRequest();
	else if (window.ActiveXObject)
		req=new ActiveXObject("Microsoft.XMLHTTP");
	else{
		alert("Browser not support");
		return false;
	}
	req.onreadystatechange = statechange;
	// random number เพื่อป้องกันแคช windows
	var str=Math.random();
	
	// **** get URL PHP  ******
	var querystr="../import_pobec2cmss.php?pop="+str;

	req.open("GET",  querystr  ,true);
	req.Send(null);
}

function statechange()
{
	if (req.readyState==4) {
		var x=document.getElementById("answer");
		x.innerHTML=req.responseText;
	}
	else{
		var x=document.getElementById("answer");
		x.innerHTML="<img src=images/indicator_mozilla_yellow.gif><br>Please wait...";
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="3" class="table_main">
        <tr class="table_main">
          <td width="20%" align="center" class="table_main">Step 1 </td>
          <td width="19%" align="center" class="table_main">Step 2 </td>
          <td width="20%" align="center" class="table_main">Step 3 </td>
          <td width="20%" align="center" class="table_main">Step 4 </td>
          <td width="19%" align="center" class="table_main">Step 5 </td>
          <td width="2%" align="center" class="header_font">&nbsp;</td>
        </tr>
        <tr>
          <td height="281" align="center" valign="top" class="table_main"><table width="100%" height="100%" border="0" bgcolor="#9BB4BE">
            <tr>
              <td height="66" colspan="3" align="center">นำเข้าข้อมูลเอกสาร excel จาก<br />
โปรแกรม P-obec เข้าสู่ระบบ CMSS</td>
              </tr>
            <tr>
              <td width="37%" height="50" align="center"><img src="../images/pobec.jpg" width="48" height="48" /></td>
              <td width="29%" align="center"><img src="../../../images_sys/nav_right_blue.png" width="24" height="24" /></td>
              <td width="34%" align="center"><img src="../../../images_sys/cmss64.png" width="48" height="48" /></td>
            </tr>
            <tr>
              <td height="18" colspan="3">&nbsp;</td>
              </tr>
            <tr>
              <td height="16" colspan="3" align="center" valign="middle">
			   <?=showstatus(1,1)?>
			   <a href="#" onClick="MM_openBrWindow('browse.php','','scrollbars=0,width=660,height=520,status=0')">นำเข้าข้อมูลจาก P-OBEC</a></td>
              </tr>
            <tr>
              <td height="16" colspan="3" align="center">
			  <div class="table_main" id="answer" onclick="getsum();" style="cursor:hand">
                <?=showstatus(1,2)?>
                ประมวลผลข้อมูลจาก <br />
			  	  P-OBEC สู่ระบบ CMSS</div>				
				  </td>
              </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
              </tr>
          </table></td>
          <td align="center" valign="top" class="table_main">
		  <table width="100%" height="100%" border="0" bgcolor="#9BB4BE">
            <tr>
              <td height="66" align="center">ระบบออกหนังสือ<br/>
คำสั่งพิจารณาเลื่อนขั้น</td>
              </tr>
            <tr>
              <td height="18">&nbsp;</td>
            </tr>
            <tr>
              <td height="16" align="left" valign="middle"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /> <a href="../form_addorder_index.php?disable_menu=1" target="_blank">บันทึกเอกสาร</a></td>
            </tr>
            <tr>
              <td height="16" align="left"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /><a href="../form_addorder_index.php?disable_menu=0" target="_blank"> พิมพิ์เอกสาร PDF</a></td>
            </tr>
            <tr>
              <td height="49">&nbsp;</td>
            </tr>
          </table></td>
          <td align="center" valign="top" class="table_main"><table width="100%" height="100%" border="0" bgcolor="#9BB4BE">
              <tr>
                <td height="66" align="center">ตรวจสอบแก้ไข<br />
ข้อมูลบัญชีผู้ได้รับการพิจารณา<br />
เลื่อนขั้นแต่ละขั้น </td>
              </tr>
              <tr>
                <td height="18">&nbsp;</td>
              </tr>
              <tr>
                <td height="16" align="left" valign="middle"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /><a href="../spt_index.php" target="_blank"> ตรวจสอบแก้ไขข้อมูล</a></td>
              </tr>
              <tr>
                <td height="16" align="left"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /> <a href="../index_report_fdf.php" target="_blank">พิมพิ์เอกสาร PDF </a></td>
              </tr>
              
              <tr>
                <td height="16">&nbsp;</td>
              </tr>
            </table></td>
          <td align="center" valign="top" class="table_main"><table width="100%" height="100%" border="0" bgcolor="#9BB4BE">
            <tr>
              <td height="66" align="center">ระบบบันทึกข้อมูลตำแหน่งและ<br />
                อัตราเงินเดือน กพ.7</td>
            </tr>
            <tr>
              <td height="18">&nbsp;</td>
            </tr>
            <tr>
              <td height="16" align="left" valign="middle"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /> <a href="../certificate_index.php" target="_blank">ตรวจสอบแก้ไขข้อมูล</a></td>
            </tr>
            <tr>
              <td height="16" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td height="16">&nbsp;</td>
            </tr>
          </table></td>
          <td align="center" valign="top" class="table_main"><table width="100%" height="100%" border="0" bgcolor="#9BB4BE">
              <tr>
                <td height="66" align="center">ระบบรายงานข้อมูลขั้นเงินเดือน ภาษี เงิน กบข. </td>
              </tr>
              <tr>
                <td height="18" align="center"><img src="../images/images.jpg" width="60" height="47" /></td>
              </tr>
              <tr>
                <td height="16" align="left" valign="middle"><img src="../../../images_sys/circlearrow.gif" width="16" height="16" /><a href="../index_kpk.php" target="_blank"> นำเข้าข้อมูลจาก P-OBEC </a></td>
              </tr>
              <tr>
                <td height="16">&nbsp;</td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
</table>
</body>
</html>
