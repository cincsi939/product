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
session_start();	
include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");	
	
#Begin Set var
$dbsite = STR_PREFIX_DB.$_GET['siteid'];
$siteid = $_GET['siteid'];
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$part_forder = "../../../image_file/".$siteid."/";
#End Set var

#Begin Funtions ---------------------------------------------------
#Function แสดงรูปแบบวันที่
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

#Function ตรวจสสอบข้อมูลคนรูปและประเภทรูปว่าเป็นรูปขาวดำหรือสี
#Note. Function CheckimageGrayscale() จากไฟล์ ../../common/common_competency.inc.php
function checkDataImage($siteid="", $schoolid=""){
		global $part_forder; 
		$dbsite = STR_PREFIX_DB.$siteid;
		$sum_general = 0;
		$max_image=0;
		$max_image=array();
		if($siteid!="" ){
			$sql_general = "SELECT id, siteid FROM {$dbsite}.`general` AS `general` WHERE  siteid='".$siteid."' ";
			$sql_general .= ($schoolid!="")?" AND schoolid='".$schoolid."' ":"";	
			$query_general = mysql_query($sql_general);
			while($row_general = mysql_fetch_assoc($query_general)){
				$sum_general++;
				$sql = "SELECT general_pic.id, general_pic.imgname FROM {$dbsite}.general_pic AS general_pic WHERE general_pic.id='".$row_general['id']."'  ";
				$query = mysql_query($sql);
				$num_rows = mysql_num_rows($query);
				while($row = mysql_fetch_assoc($query)){
					if(is_file($part_forder.$row['imgname'])){
						if(CheckimageGrayscale($part_forder.$row['imgname']) == 1){
							$general_person['no_color'][$row['id']] += 1; 	
						}else{
							$general_person['color'][$row['id']] += 1;
						}
					}
				}
				
				$sum_all[$row_general['id']] = count($general_person['no_color'][$row_general['id']]).":".count($general_person['color'][$row_general['id']]).":".$num_rows;
				$arr_num_type = explode(":",$sum_all[$row_general['id']]);
				if($arr_num_type[0]>=1){
					$arr_pin_image['all'][] = $row_general['id'];
					$arr_pin_image['no_color'][] = $row_general['id'];
					$max_image['no_color'][] = $num_rows;
				}else if($arr_num_type[0]==0 && $arr_num_type[1]>0&& $arr_num_type[2] > 0){
					$arr_pin_image['all'][] = $row_general['id'];
					$arr_pin_image['color'][] = $row_general['id'];
					$max_image['color'][] = $num_rows;	
				}else if($arr_num_type[2]==0){
					$arr_pin_image['all'][] = $row_general['id'];
					$arr_pin_image['no_image'][] = $row_general['id'];
					$max_image['no_image'][] = 0;
				}
				$arr_pin_image['max_image']['all'] = ($arr_pin_image['max_image']['all']>$num_rows)?$arr_pin_image['max_image']['all']:$num_rows;
				$arr_pin_image['max_image']['no_color'] = max($max_image['no_color']);
				$arr_pin_image['max_image']['color'] = max($max_image['color']);
				$arr_pin_image['max_image']['no_image'] = max($max_image['no_image']);
			}
		}
		return $arr_pin_image;
}

#Function แสดงลิงก์ :: เขตพื้นที่=>โรงเรียน
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
<title>รายงานตรวจสอบข้อมูลรูปข้าราชการครูและบุคลาการทางการศึกษา</title>
</head>
<body>
	<center>
	<strong style="font-size:16px;">รายงานตรวจสอบข้อมูลรูปข้าราชการครูและบุคลาการทางการศึกษา</strong><br/>
	</center>
	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid'], $_GET['schoolid']);?></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<?php
	$arr_data = checkDataImage($siteid,$_GET['schoolid']);
	$arridcard = implode("','",$arr_data[$_GET['m_type']]);
	if($_GET['m_type2']){
		//echo implode("','",$arr_data[$_GET['m_type2']]);
		$arridcard .= "','".implode("','",$arr_data[$_GET['m_type2']]);
	}
	$max_image =  $arr_data['max_image'][$_GET['m_type']];
	$sql_pic = "SELECT general_pic.id, general_pic.imgname, general_pic.no FROM general_pic WHERE general_pic.`id` IN('".$arridcard."') ";
	$query_pic = mysql_db_query($dbsite, $sql_pic);
	while($row_pic = mysql_fetch_assoc($query_pic)){
		$pic[$row_pic['id']][$row_pic['no']] = $row_pic['imgname'];
	}
	
	$sql = "SELECT * FROM `general` WHERE `idcard` IN('".$arridcard."') ";
	$query = mysql_db_query($dbsite, $sql);
	?>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc">
		<td width="4%"><strong>ลำดับ</strong></td>
		<td width="9%"><strong>เลขบัตรประจำตัวประชาชน</strong></td>
		<td width="9%"><strong>ชื่อ-นามสกุล</strong></td>
		<td width="10%"><strong>หน่วยงาน</strong></td>
		<td width="15%"><strong>ตำแหน่ง</strong></td>
		<?php
			for($i=0;$i<$max_image;$i++){
				echo '<td width="5%"><strong>รูปที่ '.($i+1).'</strong></td>';
			}
		?>
	  </tr>
<?php
$int_row = 0;
$bg_color = array("#DDDDDD", "#EFEFEF");
while($row = mysql_fetch_assoc($query)){
$int_row++;
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
		<?php
			for($i=0;$i<$max_image;$i++){
				echo '<td align="center">';
				if(is_file($part_forder.$pic[$row['idcard']][($i+1)])){
					echo '<img src="'.$part_forder.$pic[$row['idcard']][($i+1)].'" border="0" width="150" title="'.$pic[$row['idcard']][($i+1)].'" />';
				}
				echo '</td>';
			}
		?>
	  </tr>
	<?php } ?>
	</table>

</body>
</html>