<?
	###################################################################
	## IMMIGRATION : MAIN REDIRECT COMMAND
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			jessada@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
	
//include "epm.inc.php";
//include("function_assign.php");
session_start();
$report_title = "รายการบันทึกข้อมูลและการอัปโหลดไฟล์ก.พ.7 ต้นฉบับ";
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
</script>
</head>

<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td colspan="2" class="fillcolor"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="25%"  bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="index_key_report.php?xmode=&xshow=view"><strong><U style="color:<?=$bgcolor?>;">สรุปการบันทึกข้อมูล ก.พ.7</U></strong></A></td>
              <td width="31%"  bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="index_key_report.php?xmode=1&xshow=view"><strong><U style="color:<?=$bgcolor?>;"> รายการการอัปโหลดไฟล์ ก.พ.7 ต้นฉบับ</U></strong></A></td>
			  <!-- <td width="44%"><a href="report_kp7_noassign.php" target="_blank"><strong>รายการที่มีเอกสารต้นฉบับแล้วแต่ยังไม่ได้มอบหมายงาน</strong></a></td>-->
            </tr>
          </table></td></tr>
<tr><td width=39>&nbsp;</td>
<td width="908" align="left">&nbsp;</td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>
<BR></td>
</tr>
</table>

<? 
if($action == "" and $xshow == "view"){ 
		if($xmode == ""){ // รายงานการบันทึกข้อมูล
			include("report_new.php");
		}
		if($xmode == "1"){
			include("../checklist_kp7_management/report_upload_filepdf.php");
		}
}// end if($action == ""){ 
?>
</BODY>
</HTML>
