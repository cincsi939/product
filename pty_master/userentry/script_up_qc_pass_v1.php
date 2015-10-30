<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";



?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date_true.value == ""){
		alert("กรุณาระบุวันส่งคือเอกสาร");
		document.form1.sent_date_true.focus();
		return false;
	}
	}
	
	
	
	var checkflag = "false";
function check(field) {
	if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
			field[i].checked = true;
		}
		checkflag = "true";
		return "ไม่เลือกทั้งหมด"; 
	} else {
		for (i = 0; i < field.length; i++) {
			field[i].checked = false; 
		}
		checkflag = "false";
		return "เลือกทั้งหมด"; 
	}

}

function checkAll(field,x) {
	for (i = 0; i < field.length; i++) {
		field[i].checked = x;
	}
}


</script>
</head>

<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="61%" align="center" bgcolor="#A5B2CE"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="31%" align="center" bgcolor="#A5B2CE"><strong>ตรวจสอบ</strong></td>
      </tr>
	  <?
	  	$sql_area = "SELECT * FROM eduarea WHERE  secid NOT IN('5001','5002','5003','5004','5005','5006') and config_area='1'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$i=0;
		while($rs_a = mysql_fetch_assoc($result_area)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs_a[secname]?></td>
        <td align="center"><a href="?action=run&secid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>" target="_blank"> run</a></td>
      </tr>
	  <?
	  	}// end while(){
	  ?>
    </table></td>
  </tr>
</table>
<? } //end  if($action == ""){
	if($action == "run"){
		//$sql_sel = "SELECT  DISTINCT idcard FROM monitor_keyin WHERE siteid='$secid' and (timestamp_key LIKE '2009-09-14%' or timestamp_key LIKE '2009-09-13%' or timeupdate LIKE '2009-09-12%' )";
		$sql_sel = "SELECT 
monitor_keyin.idcard
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
(keystaff.sapphireoffice =  '2') and (timestamp_key LIKE '2009-09-14%' or timestamp_key LIKE '2009-09-13%' or timestamp_key LIKE '2009-09-12%'
 or timestamp_key LIKE '2009-09-15%' or timestamp_key LIKE '2009-09-16%' or timeupdate LIKE '2009-09-14%' or timeupdate LIKE '2009-09-13%' or timeupdate LIKE '2009-09-12%'
 or timeupdate LIKE '2009-09-15%' or timeupdate LIKE '2009-09-16%' ) GROUP BY monitor_keyin.idcard ";
 
		$result = mysql_db_query(DB_USERENTRY,$sql_sel);
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT ticketid, idcard FROM tbl_assign_key WHERE idcard='$rs[idcard]'";
			$result1 = @mysql_db_query(DB_USERENTRY,$sql1);
			$rs1 = @mysql_fetch_assoc($result1);
				if($rs1[idcard] != ""){
					$sql_up = "UPDATE tbl_assign_key SET approve='0' WHERE idcard='$rs1[idcard]'";
					echo $sql_up."<br>";
				//	@mysql_db_query("edubkk_userentry",$sql_up);
					
						if($rs1[ticketid] != $tem_ticketid){
							$sql_up1 = "UPDATE tbl_assign_sub SET approve='0'  WHERE ticketid='$rs1[ticketid]'";
							echo "$sql_up1<br>";
						//	@mysql_db_query("edubkk_userentry",$sql_up1);
							$tem_ticketid = $rs1[ticketid];
						} //end 	if($rs1[ticketid] != $tem_ticketid){
					
				} //end 	if($rs1[idcard] != ""){
		}// while($rs = mysql_fetch_assoc($result)){
	} //end if($aciton == "run"){
?>
</BODY>
</HTML>
