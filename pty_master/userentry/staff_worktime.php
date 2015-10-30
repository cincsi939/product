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
$time_conf = "09:20:00";
$curent_date = date("Y-m-d");

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
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A3B2CC"><strong>รายงานการเข้าปฏิบัตงานของลูกจ้างชั่วคราวประจำวันที่  <?=show_date($curent_date);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="48%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>ประเภทงาน</strong></td>
        <td width="30%" align="center" bgcolor="#A3B2CC"><strong>เวลาเข้างาน</strong></td>
      </tr>
	  <?
	  	$sql = "SELECT * FROM keystaff   WHERE keystaff.sapphireoffice='0' AND keystaff.status_permit='YES' ORDER BY staffname ASC ";
		$result = mysql_db_query($db_name,$sql);
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
		if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			if($rs[status_extra] == "QC"){ $xtype_person = "ฝ่ายตรวจสอบข้อมูล";}else{ $xtype_person = "ฝ่ายคีย์ข้อมูล";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$m?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]" ;?></td>
        <td align="center"><?=$xtype_person?></td>
        <td align="center">
			<?	
				$sql1 = "SELECT timeupdate FROM monitor_keyin WHERE staffid='$rs[staffid]' AND timeupdate LIKE '$curent_date%' ORDER BY timeupdate ASC LIMIT 0,1 ";
				$result1 = mysql_db_query($db_name,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				$arr_dd1 = explode(" ",$rs1[timeupdate]);
					if($arr_dd1[1] >$time_conf){
						echo  "<font color='red'>$arr_dd1[1]</font>";
					}else{
						echo "$arr_dd1[1]";
					}
			?>
		</td>
      </tr>
	 <?
	}
	 ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
