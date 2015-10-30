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
set_time_limit(8000);

include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");

#Begin Set var
$get_view = ($_GET['get_view']!="")?$_GET['get_view']:"edu";
$siteid = ($_GET['siteid']!="")?$_GET['siteid']:$_SESSION['session_site'];//แสดงตามพื้นที่ (รหัสพื้นที่)//$_SESSION['session_site']
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
if($_SESSION['session_staffid']=="" && $_SESSION['session_site'] ==""){
	echo "<script>window.location='http://www.cmss-otcsc.com/';</script>";
}
#End Set var

if($_SESSION['session_staffid'] != "" and $_SESSION['session_site'] == ""){
	$user_site = "edubkk_master";	
}else if($_SESSION['session_site'] != ""){
	$user_site = $_SESSION['session_site'];	
}else{
	$user_site = $siteid;	
}// end if($_SESSION[session_staffid] != ""){

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

#Function สร้าง SQL สำหรับแสดงเขตพื้นที่และโรงเรียน
#$get_view คือ edu, school
function gen_sql($get_view="edu",$siteid="",$id=""){
	global $user_site;
	if($get_view=="edu" || $get_view==""){ 
		/*$sql = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM  ".DB_MASTER.".`eduarea_config` AS `eduarea_config` 
					Inner Join  sapphire_app.employee_work_site ON sapphire_app.employee_work_site.siteid =  ".DB_MASTER.".eduarea_config.site    ";
		$sql .= "WHERE eduarea_config.site IS NOT NULL AND eduarea_config.sitename IS NOT NULL AND eduarea_config.site NOT LIKE('99%') ";*/
		$sql = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter 
						FROM  ".DB_MASTER.".`eduarea_config` AS `eduarea_config` ";
		$sql .= "WHERE eduarea_config.site IS NOT NULL AND eduarea_config.sitename IS NOT NULL 
						AND eduarea_config.site NOT LIKE('99%') ";
		$sql .= ($siteid!="" and $user_site != "edubkk_master")?" AND eduarea_config.site ='".$siteid."' ":"";
		$sql .= "ORDER BY eduarea_config.orde_by ASC";
	}else if($get_view=="school"){
		$sql = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
		$sql .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
		$sql .= ($siteid!="")?" AND siteid ='".$siteid."' ":"";
		$sql .= ($id!="")?" AND id ='".$id."' ":"";
		$sql .= "ORDER BY orderfilde ASC";
	}
	return $sql;
}


#Function แสดงลิงก์ :: ภาพรวมประเทศ=>เขตพื้นที่
function gen_part($siteid=""){
	global $dbname,$user_site; 
	$str_link = "";
	if($siteid!=""){
		#edu 
		$sql_edu = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM `eduarea_config` Inner Join  sapphire_app.employee_work_site ON sapphire_app.employee_work_site.siteid =  ".DB_MASTER.".eduarea_config.site  ";
		$sql_edu .= "WHERE site IS NOT NULL AND sitename IS NOT NULL ";
		$sql_edu .= ($siteid!="" and $user_site != "edubkk_master")?" AND site ='".$siteid."' ":"";
		$query_edu = mysql_db_query($dbname, $sql_edu);
		$row_edu = mysql_fetch_assoc($query_edu);
		$str_link = '<a href="?get_view=edu&date_profile='.$_GET['date_profile'].'">ภาพรวม</a>'; 
		$str_link .= '=&gt;'.$row_edu['caption'];
	}else{
		$str_link = 'ภาพรวม'; 
	}
	return $str_link;
	
}

#Function ตรวจสสอบข้อมูลจำนวนรูปและประเภทรูปว่าเป็นรูปขาวดำหรือสี
#Note. Function CheckimageGrayscale() จากไฟล์ ../../common/common_competency.inc.php
function checkDataImage($siteid="", $schoolid=""){
		$dbsite = STR_PREFIX_DB.$siteid;
		$part_forder = "../../../image_file/".$siteid."/";
		$sum_general = 0;
		if($siteid!="" ){
			$sql_general = "SELECT id, siteid FROM {$dbsite}.`general` AS `general`   WHERE  siteid='".$siteid."'  ";
			$sql_general .= ($schoolid!="")?" AND schoolid='".$schoolid."' ":"";	
			$query_general = mysql_query($sql_general);
			while($row_general = mysql_fetch_assoc($query_general)){
				$sum_general++;
				$sql = "SELECT general_pic.id, general_pic.imgname FROM {$dbsite}.general_pic AS general_pic WHERE general_pic.id='".$row_general['id']."'  ";
				$query = mysql_query($sql);
				$num_rows = mysql_num_rows($query);
				while($row = mysql_fetch_assoc($query)){
					if(is_file($part_forder.$row['imgname'])){
						/*$time_start = getmicrotime();
						echo CheckimageGrayscale($part_forder.$row['imgname']);
						echo "<br/>";
						$time_end = getmicrotime();
						echo $time_end-$time_start."<br/>";
						exit();*/
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
					$arr_ckeck_image['no_color'][] = $row_general['id'];
				}else if($arr_num_type[0]==0 && $arr_num_type[1]>0&& $arr_num_type[2] > 0){
					$arr_ckeck_image['color'][] = $row_general['id'];
				}else if($arr_num_type[2]==0){
					$arr_ckeck_image['no_image'][] = $row_general['id'];
				}
			}
			$data = array("sum_general"=>$sum_general, "sum_no_image"=>count($arr_ckeck_image['no_image']),
									"sum_image_color"=>count($arr_ckeck_image['color']), "sum_image_no_color"=>count($arr_ckeck_image['no_color'])
								); 
		}else{
			$data = array("sum_general"=>0, "sum_no_image"=>0,"sum_image_color"=>0,"sum_image_no_color"=>0); 
		}
		unset($sum_all);
		unset($arr_ckeck_image);
		return $data;
}

#Function บันทึกข้อมูล Temp การตรวจสอบรูป
function update_temp_check_image($siteid="", $general="", $no_image="", $no_color_image="", $color_image=""){
	global $dbname,$user_site;
	//echo $user_site."<br/>";
	//if($user_site != "edubkk_master"){
		$sql = "REPLACE INTO temp_check_image 
					SET siteid='".$siteid."', general='".$general."', no_image='".$no_image."', no_color_image='".$no_color_image."', 
					color_image='".$color_image."', update_date=NOW() ";
		mysql_db_query($dbname, $sql) or die(mysql_error());
	//}
}

function get_temp_image_db($siteid=""){
	global $dbname;
	$data_image = array();
	$sql = " SELECT * FROM temp_check_image WHERE siteid='".$siteid."' ";
	$query = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_assoc($query);
	$data_image['sum_general'] = $row['general'];
	$data_image['sum_no_image'] = $row['no_image'];
	$data_image['sum_image_no_color'] = $row['no_color_image'];
	$data_image['sum_image_color'] = $row['color_image'];
	return $data_image;
}
function percen_event($num_all=0, $num_event=0){
	return @number_format( (($num_event*100)/$num_all) ,2);
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

	<center><strong style="font-size:16px;">รายงานตรวจสอบข้อมูลรูปข้าราชการครูและบุคลาการทางการศึกษา</strong></center>
	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid']);?></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc" >
		<td width="50" rowspan="2"><strong>ลำดับ</strong></td>
		<td rowspan="2"><strong>หน่วยงาน</strong></td>
		<td colspan="6"><strong>ข้อมูลด้านรูปภาพ</strong></td>
	  </tr>
	  <tr  bgcolor="#a3b2cc"  align="center">
		<td width="120"><strong>จำนวนคนทั้งหมด</strong></td>
		<td width="120"><strong>จำนวนคนที่ไม่มีรูป</strong></td>
		<td width="120"><strong>จำนวนคนที่มีรูปขาวดำ</strong></td>
		<td width="120"><strong>จำนวนคนที่มีรูปสี</strong></td>
		<td width="120"><strong>เปอร์เซนต์ความสำเร็จ</strong></td>
		<td width="120"><strong>เปอร์เซนต์ที่ต้องทำ</strong></td>
	  </tr>
	  <?php
	  $sql =  gen_sql($get_view,$siteid); 
	//  echo $sql."".$dbname."<br>";
	  $query = mysql_db_query($dbname, $sql);
	  $int_row = 0;
	  $sum_general = 0;
	  $sum_general_no_im = 0;
	  $sum_no_color = 0;
	  $sum_color = 0;
	  $bg_color = array("#DDDDDD", "#EFEFEF");
	  while($row = mysql_fetch_assoc($query)){
	  	$int_row++;
		if($user_site == "edubkk_master" ){
			if( $row['siteid']!='' && $_GET['process']=='on' ){
				$data_temp_image = get_temp_image_db($row['siteid']);
				if($data_temp_image['sum_general']<=0){
					$data_image = checkDataImage($row['siteid'], $row['schoolid']);
					update_temp_check_image($row['siteid'], $data_image['sum_general'], $data_image['sum_no_image'], $data_image['sum_image_no_color'], $data_image['sum_image_color']);
				}
			} else if($row['siteid']!="" && $row['schoolid']!=""){
				$data_image = checkDataImage($row['siteid'], $row['schoolid']);
			}else if($row['siteid']!=""){
				$data_image = get_temp_image_db($row['siteid']);
				/*$data_image = checkDataImage($row['siteid'], $row['schoolid']);
				update_temp_check_image($row['siteid'], $data_image['sum_general'], $data_image['sum_no_image'], $data_image['sum_image_no_color'], $data_image['sum_image_color']);*/
			}  
		}else if($user_site != "edubkk_master"){
			if($row['siteid']!="" && $row['schoolid']!=""){
				$data_image = checkDataImage($row['siteid'], $row['schoolid']);
			}else if($row['siteid']!=""){
				$data_image = get_temp_image_db($row['siteid']);
				/*$data_image = checkDataImage($row['siteid'], $row['schoolid']);
				update_temp_check_image($row['siteid'], $data_image['sum_general'], $data_image['sum_no_image'], $data_image['sum_image_no_color'], $data_image['sum_image_color']);*/
			}
			
		}
		#set var sum
		$sum_general += $data_image['sum_general'];
		$sum_general_no_im += $data_image['sum_no_image'];
		$sum_no_color += $data_image['sum_image_no_color'];
	  	$sum_color += $data_image['sum_image_color'];
	  ?>
	  <tr bgcolor="<?php echo $bg_color[$int_row%2];?>" align="center">
		<td><?php echo $int_row;?></td>
		<td align="left">
			<?php 
			$get_view_link = ($get_view!="edu")?$get_view:"school";
			if($get_view!="school"){ 
			?>
			<a href="?get_view=<?=$get_view_link?>&siteid=<?=$row['siteid']?>&schoolid=<?=$row['schoolid']?>"><?php echo $row['caption'];?></a>
			<?php 
			}else{
				echo $row['caption'];
			}
			?>
		</td>
		<td>
		<?php
		if($data_image['sum_general']>0){
			echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=all" target="_blank">'.number_format($data_image['sum_general']).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td>
		<?php
		if($data_image['sum_no_image']>0){
			echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=no_image" target="_blank">'.number_format( $data_image['sum_no_image'] ).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td>
		<?php
		if(($data_image['sum_image_no_color'])>0){
			echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=no_color" target="_blank">'.number_format( $data_image['sum_image_no_color'] ).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td>
		<?php
		if(($data_image['sum_image_color'])>0){
			echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=color" target="_blank">'.number_format( $data_image['sum_image_color'] ).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td>
		<?php 
		echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=color" target="_blank" style="color:#006600;">';
		echo percen_event($data_image['sum_general'], $data_image['sum_image_color']);
		echo '</a>';
		?>
		</td>
		<td>
		<?php 
		echo '<a href="report_check_data_image_person.php?siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=no_color&m_type2=no_image" target="_blank" style="color:#FF0000;">';
		echo percen_event($data_image['sum_general'], ($data_image['sum_no_image']+$data_image['sum_image_no_color']) );
		echo '</a>';
		?>
		</td>
	  </tr>
	  <?php }  ?>
	   <tr bgcolor="#CCCCCC" align="center">
		<td>&nbsp;</td>
		<td align="left"><strong>รวม</strong></td>
		<td>
		<strong><?php echo number_format($sum_general);?></strong>
		</td>
		<td>
		<strong><?php echo number_format($sum_general_no_im);?></strong>
		</td>
		<td>
		<strong><?php echo number_format($sum_no_color);?></strong>
		</td>
		<td>
		<strong><?php echo number_format($sum_color);?></strong>
		</td>
		<td style="color:#006600"><strong><?php echo percen_event($sum_general, $sum_color)?></strong></td>
		<td style="color:#FF0000"><strong><?php echo percen_event($sum_general, ($sum_general_no_im+$sum_no_color) )?></strong></td>
	  </tr>
	</table>

</body>
</html>