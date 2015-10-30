<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");


?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>รายการที่มีเอกสารแต่ยังไม่ได้มอบหมายงาน </strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="26%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประจำตัว</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>หน่วยงาน</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>ก.พ.7</strong></td>
      </tr>
	  <?
	 	$sql_area = "SELECT * FROM config_area WHERE defult_config='1' ORDER BY secname ASC"; 
		$result_area = mysql_db_query($db_name,$sql_area);
		$i=0;
		while($rs = mysql_fetch_assoc($result_area)){
		$i++;
			echo "<tr  bgcolor='#CCCCCC'><td colspan='6' align='left'>$i $rs[secname]</td></tr>";
				$sql1 = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard as id,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname, ".DB_USERENTRY.".tbl_assign_key.idcard
FROM
 ".DB_CHECKLIST.".tbl_check_data
Left Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$rs[secid]'
ORDER BY ".DB_USERENTRY.".tbl_assign_key.idcard ASC";
$result1 = mysql_db_query("edubkk_checklist",$sql1);
$j=0;
while($rs1 = mysql_fetch_assoc($result1)){
	if($rs1[idcard] == ""){
		
					$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs1[id]".".pdf";
				if(file_exists($path_img)){
				$j++;
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" border=\"0\"></a>";
					


		
	  ?>
      <tr>
        <td align="center"><?=$i.".".$j;?></td>
        <td align="center"><?=$rs1[id]?></td>
        <td align="left"><? echo "$rs1[prename_th]$rs1[name_th] $rs1[surname_th]";?></td>
        <td align="left"><? echo "$rs1[position_now]";?></td>
        <td align="left"><? echo "$rs1[schoolname]";?></td>
        <td align="center"><?=$link_img?></td>
      </tr>
	 <?
	 	}// end if(file_exists($path_img)){
	 } //end 	if($rs1[idcard] == ""){
	 }//endwhile($rs1 = mysql_fetch_assoc($result1)){
	 }
	 ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
