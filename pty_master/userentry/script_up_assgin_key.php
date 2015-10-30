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
	$db_site = STR_PREFIX_DB.$secid;
		$sql = "SELECT * FROM log_delete_assign_key WHERE siteid='$secid'";
		$result = mysql_db_query(DB_USERENTRY,$sql);
		while($rs = mysql_fetch_assoc($result)){

				$arr1 = explode(" ",$rs[fullname]);
//				echo "<pre>";
//				print_r($arr1);
				$surname_th =  trim($arr1[2]);
				$temp_name = trim($arr1[0]);
				$name1 = substr($temp_name,0,strlen($temp_name));
				$name2 = substr($temp_name,1,strlen($temp_name));
				$name3 = substr($temp_name,2,strlen($temp_name));
				$name4 = substr($temp_name,3,strlen($temp_name));
				$name5 = substr($temp_name,4,strlen($temp_name));
				$name6 = substr($temp_name,5,strlen($temp_name));
				$name7 = substr($temp_name,6,strlen($temp_name));
				$sql1 = "SELECT  id  FROM general  WHERE (surname_th='$surname_th' and name_th='$name1')  or  (surname_th='$surname_th' and name_th='$name2') or  (surname_th='$surname_th' and name_th='$name3')or  (surname_th='$surname_th' and name_th='$name4')or  (surname_th='$surname_th' and name_th='$name5') or  (surname_th='$surname_th' and name_th='$name6') or  (surname_th='$surname_th' and name_th='$name7')  GROUP BY id";
				$result1 = mysql_db_query($db_site,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
					if($rs1[id] != ""){
						$sql_assign = "SELECT COUNT(idcard) as n1 FROM tbl_assign_key WHERE idcard = '$rs1[id]' GROUP BY idcard";
						$result_assgin = mysql_db_query(DB_USERENTRY,$sql_assign);
						$rs_a = mysql_fetch_assoc($result_assgin);
						//echo "$rs_a[n1]<br>";
							if($rs_a[n1] < 1){ // แสดงว่ายังไม่มีการ assgin งานให้เอา log_delete up ขึ้นมา
									$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,fullname,siteid,approve,kp7file,estimate_pay,pay_net,update_time,staff_apporve)VALUES('$rs[ticketid]','$rs1[id]','$rs[fullname]','$rs[siteid]','$rs[approve]','$rs[kp7file]','$rs[estimate_pay]','$rs[pay_net]','$rs[update_time]','$rs[staff_apporve]')";
									echo $sql_insert."<br>";
									//@mysql_db_query("edubkk_userentry",$sql_insert);
							} // end 	if($rs_a[n1] < 1){ 
					} //end if($rs1[id] != ""){
		}// end while($rs = mysql_fetch_assoc($result)){
	} //end if($aciton == "run"){
?>
</BODY>
</HTML>
