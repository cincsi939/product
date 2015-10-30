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

function getCountKeyIn($staff_id="",$siteid="",$type_staff="",$arr_id=array()){
	global $dbaddlog, $arr_type;
	$in_id = implode("','",$arr_id);
	$in_type = implode("','",$arr_type);
	$field_id = ($type_staff=="key")? "key_id":"qc_id";
	$sql = "SELECT  idcard, key_id, qc_id FROM salary_lablevalues_chk 
				WHERE {$field_id}='".$staff_id."' ";
	$sql .=  " AND status_check IN('".$in_type."')";
	$sql .=  ($in_id!="")?" AND idcard IN('".$in_id."') ":"";
	$sql .=  ($siteid!="")?" AND siteid='".$siteid."' ":"";
	$query = mysql_db_query($dbaddlog, $sql);
	$count_qc=0;
	$count_key=0;
	while($row = mysql_fetch_assoc($query)){
		if($row['qc_id']!=""){
			$count_qc++;
		}
		$count_key++;
	}
	return array("count_key"=>$count_key,"count_qc"=>$count_qc);
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
	<table width="98%" border="0" align="center">
	  <tr>
		<td>
		<P>
		<a href="?date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&report_type=KEYIN">รายชื่อพนักงาน KEYIN</a>
		|
		<a href="?date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&report_type=QC">รายชื่อพนักงาน QC</a>
		</P>
		</td>
	  </tr>
	</table>

	
	<?php
	if($_GET['report_type']=="KEYIN" || $_GET['report_type']==""){
	#Begin KEYIN LIST =-=-=-=-=-=-=-=-=-=-=-=-=
	?>
	<table width="98%"  border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center" bgcolor="#a3b2cc">
		<td width="50" ><strong>ลำดับ</strong></td>
		<td><strong>ชื่อ-นามสกุล KEYIN</strong></td>
		<td width="150"><strong>จำนวนคีย์</strong></td>
		<td width="150"><strong>จำนวนQC</strong></td>
	  </tr>
	 	<?php
		$sql = "SELECT 
			key_id,
			key_prename,
			key_fname,
			key_lname,
			siteid,
			qc_id
			FROM `salary_lablevalues_chk`
			WHERE siteid='".$_GET['siteid']."' ";
		$sql .= ($_GET['schoolid']!="")?"AND schoolid='".$_GET['schoolid']."' ":"";
		$sql .=  "AND status_check IN('".$in_type."')";
		$sql .=  "AND idcard IN('".$in_id."')";
		$sql .= " GROUP BY key_id";
		$bg_color = array("#F9F9F9","#FFFFFF");
		$intRow=0;
		$count_key_all = 0;
		$count_qc_all = 0;
		$query = mysql_db_query($dbaddlog, $sql);
		while($row = mysql_fetch_assoc($query)){
		$intRow++;
		$count_data = getCountKeyIn($row['key_id'],$row['siteid'],'key',$arr_id);
		$count_key_all += $count_data['count_key'];
		$count_qc_all += $count_data['count_qc'];
		?>
	  <tr bgcolor="<?=$bg_color[$intRow%2]?>">
		<td align="center"><?php echo $intRow;?></td>
		<td><?php echo $row['key_prename'].$row['key_fname']."  ".$row['key_lname']?></td>
		<td align="center"><a href="report_salary_lablevalues_detail.php?date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&type_staff=key&staff_id=<?=$row['key_id']?>" target="_blank"><?php echo $count_data['count_key']?></a></td>
		<td align="center">
		<?php 
		if($count_data['count_qc']>0){ 
		?>
			<a href="report_salary_lablevalues_detail.php?date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&type_staff=qc&staff_id=<?=$row['key_id']?>" target="_blank"><?php echo $count_data['count_qc']?></a>
		<?php 
		}else{
			echo "0";
		} 
		?>
		</td>
	  </tr>
	  <?php } ?>
	  <tr bgcolor="#CCCCCC">
		<td align="center">&nbsp;</td>
		<td><strong>รวม</strong></td>
		<td align="center"><strong><?php echo $count_key_all?></strong></td>
		<td align="center"><strong><?php echo $count_qc_all?></strong></td>
	  </tr>
	</table>
	<?php
	#End KEYIN LIST =-=-=-=-=-=-=-=-=-=-=-=-=
	}else if($_GET['report_type']=="QC"){
	#Begin QC LIST =-=-=-=-=-=-=-=-=-=-=-=-=
	?>
	<table width="98%"  border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center" bgcolor="#a3b2cc">
		<td width="50" ><strong>ลำดับ</strong></td>
		<td><strong>ชื่อ-นามสกุล QC</strong></td>
		<td width="150"><strong>จำนวนQC</strong></td>
	  </tr>
	 	<?php
		$sql = "SELECT 
			key_id,
			qc_id,
			qc_prename,
			qc_fname,
			qc_lname,
			siteid
			FROM `salary_lablevalues_chk`
			WHERE siteid='".$_GET['siteid']."' 
			AND qc_id IS NOT NULL 
			AND qc_id!=''
			AND qc_fname IS NOT NULL 
			AND qc_fname!=''
			AND qc_lname IS NOT NULL 
			AND qc_lname!=''
			 ";
		$sql .= ($_GET['schoolid']!="")?"AND schoolid='".$_GET['schoolid']."' ":"";
		$sql .=  "AND status_check IN('".$in_type."')";
		$sql .=  "AND idcard IN('".$in_id."')";
		$sql .= " GROUP BY qc_id";
		$bg_color = array("#F9F9F9","#FFFFFF");
		$intRow=0;
		$count_key_all = 0;
		$count_qc_all = 0;
		$query = mysql_db_query($dbaddlog, $sql);
		while($row = mysql_fetch_assoc($query)){
		$intRow++;
		$count_data = getCountKeyIn($row['qc_id'],$row['siteid'],'qc',$arr_id);
		$count_qc_all += $count_data['count_qc'];
		?>
	  <tr bgcolor="<?=$bg_color[$intRow%2]?>">
		<td align="center"><?php echo $intRow;?></td>
		<td><?php echo $row['qc_prename'].$row['qc_fname']."  ".$row['qc_lname']?></td>
		<td align="center">
		<?php 
		if($count_data['count_qc']>0){ 
		?>
			<a href="report_salary_lablevalues_detail.php?date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&type_staff=qc_user&staff_id=<?=$row['qc_id']?>" target="_blank"><?php echo $count_data['count_qc']?></a>
		<?php 
		}else{
			echo "0";
		} 
		?>
		</td>
	  </tr>
	  <?php } ?>
	  <tr bgcolor="#CCCCCC">
		<td align="center">&nbsp;</td>
		<td><strong>รวม</strong></td>
		<td align="center"><strong><?php echo $count_qc_all?></strong></td>
	  </tr>
	</table>
	<?php
	#End QC LIST =-=-=-=-=-=-=-=-=-=-=-=-=
	}
	?>
</body>
</html>