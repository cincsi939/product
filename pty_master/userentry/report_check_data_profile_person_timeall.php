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
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
#End Set var

#Begin Funtions ---------------------------------------------------

function dateToString($date=""){
	$str_date = "";
	$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
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
				$orgfile = "../../../edubkk_kp7file/".$siteid."/" . $row_general['id'] . ".pdf";
				if($_GET['check_file']=="kp7"){
					if(is_file($orgfile)){
						$arr_idcard['m1'][] = $row_general['id'];
					}
				}else if($_GET['check_file']=="not_kp7"){
					if(!is_file($orgfile)){
						$arr_idcard['m1'][] = $row_general['id'];
					}
				}else{
					$arr_idcard['m1'][] = $row_general['id'];
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
	$sql_school = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
	$sql_school .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
	$sql_school .= ($schoolid!="")?" AND id ='".$schoolid."' ":"";
	$query_school = mysql_db_query($dbname, $sql_school);
	$row_school = mysql_fetch_assoc($query_school);
	return $row_edu['caption'].(($schoolid!="")?"=&gt;".$row_school['caption']:"");
	
}

function get_school($siteid="",$schoolid=""){
	global $dbname; 
	$sql_school = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
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
<title>รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</title>
</head>
<body>
	<center>
	<strong style="font-size:16px;">รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</strong><br/>
	</center>
	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid'], $_GET['schoolid']);?></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc">
		<td width="4%"><strong>ลำดับ</strong></td>
		<td width="10%"><strong>หน่วยงาน</strong></td>
		<td width="9%"><strong>เลขบัตรประจำตัวประชาชน</strong></td>
		<td width="9%"><strong>ชื่อ-นามสกุล</strong></td>
		<td width="15%"><strong>ตำแหน่ง</strong></td>
		<td width="8%"><strong>ก.พ.7</strong></td>
	  </tr>
<?php
$arr_pin = math_position_date($siteid,$_GET['schoolid'],$_GET['date_profile_s'],$_GET['date_profile_e']);
if(count($arr_pin[$_GET['m_type']])>0){
$sql = "SELECT * FROM `general` WHERE `idcard` IN('".implode("','",$arr_pin[$_GET['m_type']])."') ORDER BY schoolid ASC";
$query = mysql_db_query($dbsite, $sql);
$int_row = 0;
$bg_color = array("#DDDDDD", "#EFEFEF");
while($row = mysql_fetch_assoc($query)){
$int_row++;
$orgfile = "../../../edubkk_kp7file/".$_GET['siteid']."/" . $row['idcard'] . ".pdf";
?>
	  <tr  bgcolor="<?php echo $bg_color[$int_row%2];?>" align="center" <?php echo  (!is_file($orgfile))?'style="color:#ff0000;"':""?>>
		<td><?php echo $int_row;?></td>
		<td align="left">
		<?php 
		$school = get_school($row['siteid'],$row['schoolid']);
		echo $school['caption'];
		?>
		</td>
		<td><?php echo $row['idcard'] ?></td>
		<td align="left">
		<!--<a href="../../report/search/login_data.php?action=login&idcard=<?=$row['idcard']?>&name_th=<?=$row['name_th']?>&surname_th=<?=$row['surname_th']?>&siteid=<?=$row['siteid']?>" target="_blank"><?php echo $row['prename_th'].$row['name_th']." ".$row['surname_th'] ?></a>-->
		<a href="http://202.129.35.120/competency_master/common/login_data.php?action=login&idcard=<?=$row['idcard']?>&name_th=<?=$row['name_th']?>&surname_th=<?=$row['surname_th']?>&xsiteid=<?=$row['siteid']?>" target="_blank"><?php echo $row['prename_th'].$row['name_th']." ".$row['surname_th'] ?></a>
		</td>
		<td align="left"><?php echo $row['position_now'] ?></td>
		<td>
		<?php
		if(is_file($orgfile)){
		?>
		<a href='<?=$orgfile?>' target='_blank'><img src="../../images_sys/gnome-mime-application-pdf.png" align="absmiddle" title="ก.พ.7 สำเนาจากต้นฉบับ" border="0" width="18" /></a>
		<?php } ?>
		<a href="http://202.129.35.120/edubkk_master/application/hr3/hr_report/kp7_search.php?id=<?php echo $row['idcard'] ?>&sentsecid=<?=$row['siteid']?>" target="_blank"><img src="../../application/hr3/hr_report/bimg/pdf.gif" width="16" height="16" border="0" alt='ก.พ.7 สร้างโดยระบบ ' align="absmiddle"  ></a>
		</td>
	  </tr>
<?php 
	} 
}
?>
	</table>

</body>
</html>