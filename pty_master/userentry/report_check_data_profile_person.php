<?php
###################################################################
## REPORT: CHECK DATA PROFILE
###################################################################
## Version :			20110112.001 (Created/Modified; Date.RunNumber)
## Created Date :	2011-01-12 11:30
## Created By :		Mr.KIDSANA PANYA(JENG)
## E-mail :				kidsana@sapphire.co.th
## Tel. :				-
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
	
include("../../config/conndb_nonsession.inc.php");
	
#Begin Set var
$dbsite = STR_PREFIX_DB.$_GET['siteid'];
$siteid = $_GET['siteid'];
$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
#End Set var

#Begin Funtions ---------------------------------------------------

function dateToString($date=""){
	$str_date = "";
	$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
	if($date != "" || $date!="0000-00-00"){
		 $arr_date = explode("-",$date);
		 $str_date = intval($arr_date[2])." ".$mname[intval($arr_date[1])]." ".$arr_date[0];
	}else{
		$str_date = "-";
	}
	return $str_date;
}

function max_salary($siteid="",$idcard=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	if($siteid==''){
		return "No Site DB.";
	}else{
		$sql = "SELECT MAX(`date`) AS max_date FROM `salary` WHERE id='".$idcard."' ";
		$query = mysql_db_query($dbsite, $sql);
		$row = mysql_fetch_assoc($query);
		return $row['max_date'];
	}
}

function math_position_date($siteid="",$schoolid=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	$date_profile = $_GET['date_profile'];
	if($siteid!=""){
		$general = "SELECT
			general.id, MAX( salary.`date` ) AS max_date, general.dateposition_now
			FROM
			general
			LEFT JOIN salary ON general.id = salary.id 
			WHERE general.siteid='".$siteid."'
			";
		$general .= ($schoolid != "")?"AND general.schoolid ='".$schoolid."' ":"";
		$general .= "GROUP BY general.id
			HAVING MAX( DATE(salary.`date`) ) < DATE( '".$date_profile."')  OR  (max_date = '' OR max_date IS NULL)";
		$query_general = mysql_db_query($dbsite, $general);
		while($row_general = mysql_fetch_assoc($query_general)){
			if($date_profile > $max_date){
				$arr_idcard['m1'][] = $row_general['id'];
				if($row_general['dateposition_now'] != $row_general['max_date']){
					$arr_idcard['m2'][] = $row_general['id'];
				}
			}
		}
	}
	return $arr_idcard;
}
function gen_part($siteid="",$schoolid=""){
	global $dbname; 
	#edu
	$sql_edu = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM `eduarea_config`  ";
	$sql_edu .= "WHERE site IS NOT NULL AND sitename IS NOT NULL ";
	$sql_edu .= ($siteid!="")?" AND site ='".$siteid."' ":"";
	$query_edu = mysql_db_query($dbname, $sql_edu);
	$row_edu = mysql_fetch_assoc($query_edu);
	#school
	$sql_school = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('�ç���¹',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
	$sql_school .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
	$sql_school .= ($schoolid!="")?" AND id ='".$schoolid."' ":"";
	$query_school = mysql_db_query($dbname, $sql_school);
	$row_school = mysql_fetch_assoc($query_school);
	return $row_edu['caption'].(($schoolid!="")?"=&gt;".$row_school['caption']:"");
	
}

function get_school($siteid="",$schoolid=""){
	global $dbname; 
	$sql_school = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('�ç���¹',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
	$sql_school .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
	$sql_school .= ($schoolid!="")?" AND id ='".$schoolid."' ":"";
	$query_school = mysql_db_query($dbname, $sql_school);
	$row_school = mysql_fetch_assoc($query_school);
	return $row_school;
}
#End Funtions ---------------------------------------------------	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>��§ҹ ��Ǩ�ͺ�����ŵ��������ç��������</title>
</head>
<body>
	<center>
	<strong style="font-size:16px;">��§ҹ ��Ǩ�ͺ�����ŵ��������ç��������</strong><br/>
	<strong>����������� <?php echo dateToString($_GET['date_profile']);?></strong>
	</center>
	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid'], $_GET['schoolid']);?></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc">
		<td width="4%"><strong>�ӴѺ</strong></td>
		<td width="9%"><strong>�Ţ�ѵû�Шӵ�ǻ�ЪҪ�</strong></td>
		<td width="9%"><strong>����-���ʡ��</strong></td>
		<td width="10%"><strong>˹��§ҹ</strong></td>
		<td width="15%"><strong>���˹�</strong></td>
		<td width="10%"><strong>�����ŵ��˹觻Ѩ�غѹ � �ѹ��� (general)</strong></td>
		<td width="10%"><strong>�����ŵ��˹觻Ѩ�غѹ � �ѹ��� (salary)</strong></td>
        <td width="10%"><strong>�.�.7</strong></td>
	  </tr>
<?php
$arr_pin = math_position_date($siteid,$_GET['schoolid']);
if(count($arr_pin[$_GET['m_type']])>0){
$sql = "SELECT * FROM `general` WHERE `idcard` IN('".implode("','",$arr_pin[$_GET['m_type']])."')
			ORDER BY schoolid DESC
 			";
$query = mysql_db_query($dbsite, $sql);
$int_row = 0;
$bg_color = array("#DDDDDD", "#EFEFEF");
while($row = mysql_fetch_assoc($query)){
$int_row++;
$orgfile = "../../../edubkk_kp7file/".$_GET['siteid']."/" . $row['idcard'] . ".pdf";
?>
	  <tr  bgcolor="<?php echo $bg_color[$int_row%2];?>" align="center">
		<td><?php echo $int_row;?></td>
		<td><?php echo $row['idcard'] ?></td>
		<td align="left"><?php echo $row['prename_th'].$row['name_th']." ".$row['surname_th'] ?></td>
		<td align="left">
		<?php 
		$school = get_school($row['siteid'],$row['schoolid']);
		echo $school['caption'];
		?>
		</td>
		<td align="left"><?php echo $row['position_now'] ?></td>
		<td><?php echo dateToString($row['dateposition_now']) ?></td>
		<td><?php echo dateToString(max_salary($row['siteid'],$row['idcard']));?></td>
        <td><?php
		if(is_file($orgfile)){
		?>
		<a href='<?=$orgfile?>' target='_blank'><img src="../../images_sys/gnome-mime-application-pdf.png" align="absmiddle" title="�.�.7 ���Ҩҡ�鹩�Ѻ" border="0" width="18" /></a>
		<?php } ?>
		<a href="http://202.129.35.120".APPNAME."application/hr3/hr_report/kp7_search.php?id=<?php echo $row['idcard'] ?>&sentsecid=<?=$row['siteid']?>" target="_blank"><img src="../../application/hr3/hr_report/bimg/pdf.gif" width="16" height="16" border="0" alt='�.�.7 ���ҧ���к� ' align="absmiddle"  ></a>
        </td>
	  </tr>
<?php 
	} 
}
?>
	</table>

</body>
</html>