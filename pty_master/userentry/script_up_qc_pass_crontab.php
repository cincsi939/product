<?
/*****************************************************************************
Function		: �ͺ���¡�ä�������� �.�.7 ���Ѻ�����
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
set_time_limit(0);

//$cur_date = date("Y-m-d");
######### ��Ǩ�ͺ����Թ��͹�������繢ͧ�ջѨ�غѹ���ѧ
function check_salary($secid,$idcard){
$yy = date("Y")+543;
	$db_site = STR_PREFIX_DB.$secid;
	$sql1 = "SELECT COUNT(id) AS NUM1 FROM salary WHERE id='$idcard' AND date LIKE '$yy%'";
	$result1 = mysql_db_query($db_site,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[NUM1];
} //end //function check_salary($secid,$idcard){


function check_assign_key($idcard ,$ticketid){
	$sql_count = "SELECT COUNT(idcard) AS num2 FROM tbl_assign_key WHERE approve='2' and idcard='$idcard' and ticketid='$ticketid'";
	$result_count = mysql_db_query("edubkk_userentry",$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	
	$sql_count1 = "SELECT COUNT(idcard) AS num3 FROM tbl_assign_key WHERE  idcard='$idcard' and ticketid='$ticketid'";
	$result_count1 = mysql_db_query("edubkk_userentry",$sql_count1);
	$rs_c1 = mysql_fetch_assoc($result_count1);
		if($rs_c[num2] == $rs_c1[num3]){
			return 1;
		}else{
			return 0;
		}
	
}

function check_subkey($ticketid){
	$sql_sub = "SELECT COUNT(tbl_assign_sub.ticketid) AS num_key FROM tbl_assign_sub INNER JOIN keystaff ON tbl_assign_sub.staffid=keystaff.staffid WHERE keystaff.sapphireoffice='2' AND tbl_assign_sub.ticketid='$ticketid'";
	$result_sub = mysql_db_query("edubkk_userentry",$sql_sub);
	$rs_sub = mysql_fetch_assoc($result_sub);
	return $rs_sub[num_key];
}

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
		alert("��س��к��ѹ�觤���͡���");
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
		return "������͡������"; 
	} else {
		for (i = 0; i < field.length; i++) {
			field[i].checked = false; 
		}
		checkflag = "false";
		return "���͡������"; 
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
<? if($action == "run"){
	if($date_up != ""){
			$date_up = $date_up;
	}else{
			$date_up = date("d/m/")."".(date("Y")+543);
	}
?>
<form name="post" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#EFEFFF"><strong>���͡�ѹ�����Ѻ�ͧ������</strong></td>
        </tr>
      <tr>
        <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="90%" bgcolor="#FFFFFF"><INPUT name="date_up" id="date_up" onFocus="blur();" value="<?=$date_up?>" size="15">
              <INPUT name="button" id="button0" type="button"  onClick="popUpCalendar(this, post.date_up, 'dd/mm/yyyy')"value="�ѹ ��͹ ��" <?=$dis1?>></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF"><label>
          <input type="submit" name="Submit" value="�����ż��Ѻ�ͧ������">
		  <input type="hidden" name="action" value="run1">
        </label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?
}// if($action == "run"){
	if($action == "run1"){
	$arr_d = explode("/",$date_up);
	$cur_date = ($arr_d[2]-543)."-".$arr_d[1]."-".$arr_d[0];
		$sql_sel = "SELECT  monitor_keyin.idcard, monitor_keyin.keyin_name, monitor_keyin.siteid, monitor_keyin.status_key, monitor_keyin.status_approve
FROM monitor_keyin where timeupdate like '$cur_date%' GROUP BY monitor_keyin.idcard  order by siteid ASC";
		$result = mysql_db_query("edubkk_userentry",$sql_sel);
		$k=0;
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT ticketid, idcard, siteid FROM tbl_assign_key WHERE idcard='$rs[idcard]'";
			$result1 = @mysql_db_query("edubkk_userentry",$sql1);
			$rs1 = @mysql_fetch_assoc($result1);
				if($rs1[idcard] != ""){
					if(check_salary($rs1[siteid],$rs1[idcard]) > 0){
							if(check_subkey($rs1[ticketid]) < 1){ // �ó��� sub ����ͧ approve
							$k++;
								$sql_up = "UPDATE tbl_assign_key SET approve='2' WHERE idcard='$rs1[idcard]'";
								echo $sql_up."<br>";
								@mysql_db_query("edubkk_userentry",$sql_up);
									if(check_assign_key($rs1[idcard],$rs1[ticketid]) > 0){ // update ticket  ����� approve
										$sql_up1 = "UPDATE tbl_assign_sub SET approve='2'  WHERE ticketid='$rs1[ticketid]'";
											echo "$sql_up1<br>";
											@mysql_db_query("edubkk_userentry",$sql_up1);
									}
								}//end if(check_subkey() < 1){ 
//						if($rs1[ticketid] != $tem_ticketid){
//							$sql_up1 = "UPDATE tbl_assign_sub SET approve='2'  WHERE ticketid='$rs1[ticketid]'";
//							echo "$sql_up1<br>";
//							//@mysql_db_query("edubkk_userentry",$sql_up1);
//							$tem_ticketid = $rs1[ticketid];
//						} //end 	if($rs1[ticketid] != $tem_ticketid){
					}//end if(check_salary($rs1[siteid],$rs1[idcard]) > 0){
				} //end 	if($rs1[idcard] != ""){
		}// while($rs = mysql_fetch_assoc($result)){
		echo "<h3><font color='red'>����ش��кǹ����Ѻ�ͧ������ ��¡�÷����� $k  ��¡��</font></h3>";
	} //end if($aciton == "run1"){
?>
</BODY>
</HTML>
