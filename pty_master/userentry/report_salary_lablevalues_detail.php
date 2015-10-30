<?php
	###################################################################
	## REPORT: CHECK DATA PROFILE
	###################################################################
	## Version :			20110111.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2011-01-11 11:30
	## Created By :		Mr.KIDSANA PANYA(JENG)
	## E-mail :				kidsana@sapphire.co.th
	## Tel. :				-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
session_start();

include("../../config/conndb_nonsession.inc.php");
$dbaddlog = "edubkk_system";
$arr_type = array(1,3);

function getCountLabelValue($idcard=""){
	global $dbaddlog, $arr_type;
	$in_type = implode("','",$arr_type);
	$sql = "SELECT COUNT(distinct idcard) AS count_id FROM salary_lablevalues_chk 
				WHERE idcard='".$idcard."' ";
	$sql .=  "AND status_check IN('".$in_type."')";
	$query = mysql_db_query($dbaddlog,$sql);
	$row = mysql_fetch_assoc($query);
	return $row['count_id'];
}

function math_position_date($siteid="",$schoolid="",$date_profile_s="",$date_profile_e=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	if($siteid!=""){
		$strHaving="";
		$strJoin="";
		$conditionT="";
		if($date_profile_e==""){
				$strHaving="
				HAVING  general.dateposition_now >= DATE( '".$date_profile_s."')  OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}else if($date_profile_s==""){
				$strHaving="
				HAVING  general.dateposition_now < DATE( '".$date_profile_e."')  OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
				$strJoin="Inner Join salary ON general.id = salary.id";
		}else if($date_profile_s=="N"  &&  $date_profile_e=="N"){
				$strJoin="Left Join salary ON general.id = salary.id";
				$conditionT="  AND  salary.id IS NULL ";
		}else{
				$strHaving="
				HAVING  general.dateposition_now BETWEEN DATE( '".$date_profile_s."') AND DATE( '".$date_profile_e."') OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}
		$general = "SELECT
			general.id, general.dateposition_now
			FROM
			general
			".$strJoin."
			WHERE general.siteid='".$siteid."'  ".$conditionT."
			";
		$general .= ($schoolid != "")?"AND general.schoolid ='".$schoolid."' ":"";
		$general .= "GROUP BY general.id
			".$strHaving."
			";
		$query_general = mysql_db_query($dbsite, $general);
		while($row_general = mysql_fetch_assoc($query_general)){
				if(getCountLabelValue($row_general['id'])){
					$arr_idcard[] = $row_general['id'];
				}
		}
	}
	return $arr_idcard;
}

$arr_id = math_position_date($_GET['siteid'],$_GET['schoolid'],$_GET['date_profile_s'],$_GET['date_profile_e']);
$in_id = implode("','",$arr_id);

$in_type = implode("','",$arr_type);
$field_id = ($_GET['type_staff']=="key")? "key_id":"qc_id";
$sql = "SELECT * FROM `salary_lablevalues_chk`
			WHERE siteid='".$_GET['siteid']."' ";
$sql .= ($_GET['schoolid']!="")?"AND schoolid='".$_GET['schoolid']."' ":"";
$sql .= ($_GET['type_staff']=="key")? "AND key_id='".$_GET['staff_id']."' ":"";
$sql .= ($_GET['type_staff']=="qc")? "AND key_id='".$_GET['staff_id']."' AND qc_id!='' ":"";
$sql .= ($_GET['type_staff']=="qc_user")? "AND qc_id='".$_GET['staff_id']."' AND qc_id!='' ":"";
$sql .=  "AND status_check IN('".$in_type."')";
$sql .=  "AND idcard IN('".$in_id."')";
$sql .= "GROUP BY idcard";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</title>
</head>
<body>
	<center>
	<strong style="font-size:16px;">รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</strong><br/>
	</center>
<table   width="650" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
  <tr align="center"  bgcolor="#a3b2cc" >
    <td>ลำดับ</td>
    <td>รายการ</td>
  </tr>
<?php
$intRow=0;
$query = mysql_db_query($dbaddlog, $sql);
while($row = mysql_fetch_assoc($query)){
$intRow++;
?>
  <tr bgcolor="#FFFFFF">
    <td align="center"><?=$intRow?></td>
    <td>
	<table width="100%" border="0">
	  <tr>
		<td width="150" align="right"><strong>ชื่อ-นามสกุล: </strong></td>
		<td><?php echo $row['prename'].$row['fname']."  ".$row['lname'] ?></td>
	  </tr>
	  <tr>
		<td align="right"><strong>เลขบัตรประจำตัวประชาชน:</strong></td>
		<td><?php echo $row['idcard']?></td>
	  </tr>
	  <tr>
		<td align="right"><strong>ชื่อ-นามสกุล KEYIN: </strong></td>
		<td><?php echo $row['key_prename'].$row['key_fname']."  ".$row['key_lname'] ?></td>
	  </tr>
	 <tr>
		<td align="right"><strong>ชื่อ-นามสกุล QC:</strong> </td>
		<td><?php echo $row['qc_prename'].$row['qc_fname']."  ".$row['qc_lname'] ?></td>
	  </tr>
	</table>
	<table border="0" bgcolor="#999999" cellpadding="2" cellspacing="1" align="center">
	  <tr bgcolor="#EEEEEE" align="center">
		<td width="150">บรรทัด</td>
		<td width="150">VALUE</td>
		<td width="150">LABEL</td>
	  </tr>
	  <?php
	  $sql_salary = "SELECT * FROM `salary_lablevalues_chk` WHERE idcard='".$row['idcard']."' ";
	  $sql_salary .=  "AND status_check IN('".$in_type."')";
	  $sql_salary .=  " ORDER BY salary_no ASC";
	  $query_salary = mysql_db_query($dbaddlog, $sql_salary);
		while($row_salary = mysql_fetch_assoc($query_salary)){
	  ?>
	  <tr bgcolor="#FFFFFF" align="center">
		<td><?php echo $row_salary['salary_no']?></td>
		<td><?php echo $row_salary['date_value']?></td>
		<td><?php echo $row_salary['date_label']?></td>
	  </tr>
	  <?php } ?>
	</table>

	</td>
  </tr>
 <?php } ?>
</table>

</body>
</html>