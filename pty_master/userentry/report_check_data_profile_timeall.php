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



#Begin Set var
$get_view = ($_GET['get_view']!="")?$_GET['get_view']:"edu";
$siteid = ($_GET['siteid']!="")?$_GET['siteid']:$_SESSION[session_site];//$_GET['siteid']
$_GET['date_profile'] = ($_GET['date_profile']!="")?$_GET['date_profile']:'2553-10-01';
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
#End Set var

if($_SESSION[session_staffid] != "" and $_SESSION[session_site] == ""){
	$user_site = DB_MASTER;	
}else if($_SESSION[session_site] != ""){
	$user_site = $_SESSION[session_site];	
}else{
	$user_site = $siteid;	
}// end if($_SESSION[session_staffid] != ""){
$dbaddlog = "edubkk_system";

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

function gen_sql($get_view="edu",$siteid="",$id=""){
	global $user_site;
	
	if($get_view=="edu" || $get_view==""){ 
		$sql = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM `eduarea_config`    ";
		$sql .= "WHERE site IS NOT NULL AND sitename IS NOT NULL AND site NOT LIKE('99%') ";
		$sql .= ($siteid!="" and $user_site != DB_MASTER)?" AND site ='".$siteid."' ":"";
		$sql .= "ORDER BY orde_by ASC ";
	}else if($get_view=="school"){
		$sql = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
		$sql .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
		$sql .= ($siteid!="")?" AND siteid ='".$siteid."' ":"";
		$sql .= ($id!="")?" AND id ='".$id."' ":"";
		$sql .= "ORDER BY orderfilde ";
	}
	return $sql;
}

function getCountLabelValue($idcard=""){
	global $dbaddlog;
	$arr_type = array(1,3);
	$in_type = implode("','",$arr_type);
	$sql = "SELECT COUNT(distinct idcard) AS count_id FROM salary_lablevalues_chk 
				WHERE idcard='".$idcard."' ";
	$sql .=  "AND status_check IN('".$in_type."')";
	$query = mysql_db_query($dbaddlog,$sql);
	$row = mysql_fetch_assoc($query);
	return $row['count_id'];
}

function getProfile(){
		$sql = "SELECT
		MAX(tbl_checklist_kp7_all_view.profile_id) AS profile_id,
		MAX(tbl_checklist_profile.profilename_short) AS profilename_short,
		tbl_checklist_kp7_all_view.siteid
		FROM
		tbl_checklist_kp7_all_view
		Inner Join tbl_checklist_profile ON tbl_checklist_profile.profile_id = tbl_checklist_kp7_all_view.profile_id
		group by  ".DB_CHECKLIST.".tbl_checklist_kp7_all_view.siteid
		ORDER BY tbl_checklist_kp7_all_view.profile_id DESC";
		$query = mysql_db_query(DB_CHECKLIST, $sql);
		while($row = mysql_fetch_assoc($query)){
			$arr_profile[$row['siteid']]=$row['profilename_short'];
		}
		return $arr_profile;
}
$arr_profilename_short = getProfile();
/*echo "<pre>";
print_r($arr_profile);
echo "</pre>";*/

function gen_part($siteid=""){
	global $dbname,$user_site; 
	$str_link = "";
	if($siteid!=""){
		#edu 
		$sql_edu = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM `eduarea_config`  ";
		$sql_edu .= "WHERE site IS NOT NULL AND sitename IS NOT NULL ";
		$sql_edu .= ($siteid!="" and $user_site != DB_MASTER)?" AND site ='".$siteid."' ":"";
		$query_edu = mysql_db_query($dbname, $sql_edu);
		$row_edu = mysql_fetch_assoc($query_edu);
		$str_link = '<a href="?get_view=edu">ภาพรวม</a>'; 
		$str_link .= '=&gt;'.$row_edu['caption'];
	}else{
		$str_link = 'ภาพรวม'; 
	}
	return $str_link;
	
}
function percen_event($num_all=0, $num_event=0){
	return @number_format( (($num_event*100)/$num_all) ,2);
}
#End Funtions ---------------------------------------------------

$sql_subject = "SELECT * FROM `subject_salary_lablevalues_chk` ";
$query_subject = mysql_db_query($dbaddlog, $sql_subject);
while($row_subject = mysql_fetch_assoc($query_subject)){
	$arr_profile[$row_subject['subject_id']] = array($row_subject['datetime_s'], $row_subject['datetime_e'],$row_subject['subject_name']);
}


#Begin Get data 
$sql_val_chk = "SELECT * FROM `sum_salary_lablevalues_chk` ";
$query_val_chk = mysql_db_query($dbaddlog, $sql_val_chk);
while($row_sv_chk = mysql_fetch_assoc($query_val_chk)){
	$dataValues[$row_sv_chk['siteid']][$row_sv_chk['subject_id']]['count'] = $row_sv_chk['int_count'];
	$dataValues[$row_sv_chk['siteid']][$row_sv_chk['subject_id']]['count_no_labelvalue'] = $row_sv_chk['int_count_no_labelvalue'];
	$dataValues[$row_sv_chk['siteid']][$row_sv_chk['subject_id']]['count_no_file'] = $row_sv_chk['int_count_no_file'];
	$exsum[$row_sv_chk['subject_id']]['count']+=$row_sv_chk['int_count'];
	$exsum[$row_sv_chk['subject_id']]['count_no_labelvalue']+=$row_sv_chk['int_count_no_labelvalue'];
	$exsum['all']+=$row_sv_chk['int_count'];
}
#End Get data

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</title>
</head>
<body>
<table border="0" style="background-color:#CCCCCC; border:#FFFFCC 1px solid; color:#006699;">
  <tr>
    <td><strong>รายงานนี้จะมีการประมวลผลทุก 1 ชั่วโมง</strong></td>
  </tr>
  <tr>
    <td align="center"><DIV style="cursor:pointer; text-align:center; width:160px; color:#00CC33; font-weight:bold; margin:5px; padding:5px; border: #009933 1px solid; background-color:#EEEEEE;" onclick="window.open('script_check_data_profile_timeall.php','popup','toolbar=0,location=0,resizeable=0,directories=0,menubar=0,scrollbars=0,status=0,width=250,height=250');"><img src="../../images_sys/refresh.png" align="absmiddle" border="0" width="20" /> ประมวลผลทันที</DIV></td>
  </tr>
</table>

	<center><strong style="font-size:16px;">รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</strong></center>
	<p/>
	<?php
	if($_GET['check_file']!=""){
		$rowspan_sum = 2;
		$colspan_sum = 3;
	}else{
		$rowspan_sum = 1;
		$colspan_sum = 1;
	}
	?>
	<table width="600" border="0" align="center"  cellpadding="2" cellspacing="1" bgcolor="#666666">
	  <tr bgcolor="#a3b2cc"  align="center">
		<td width="300"><strong>ช่วงเวลา</strong></td>
		<td width="100"><strong>จำนวนข้าราชการ</strong></td>
		<td width="100"><strong>ร้อยละ</strong></td>
	  </tr>
	  <?php
	  $bg_color = array("#DDDDDD", "#EFEFEF");
	  foreach($arr_profile as $subject_id=>$profile){
	  $int_sum++;
	  ?>
	   <tr bgcolor="<?php echo $bg_color[$int_sum%2]?>"  align="center">
		<td align="left"><strong><?php echo $profile[2]?></strong></td>
		<td><?php echo number_format($exsum[$subject_id]['count']) ?></td>
		<td><?php echo number_format((($exsum[$subject_id]['count']*100)/$exsum['all']),2);?></td>
	  </tr>
	  <?php } ?>
	  <tr bgcolor="#BBBBBB"  align="center">
		<td align="left"><strong>รวม</strong></td>
		<td><strong><?php echo number_format($exsum['all'])?></strong></td>
		<td><strong><?php echo number_format((($exsum['all']*100)/$exsum['all']),2);?></strong></td>
	  </tr>
	</table>

	<table border="0" width="98%"  align="center">
	  <tr>
		<td><!--<?php echo gen_part($_GET['siteid']);?>-->
		<a href="report_check_data_profile_timeall.php">ตรวจสอบ LB ไม่ตรง VL</a>&nbsp;|&nbsp;
		<a href="?get_view=<?=$get_view_link?>&check_file=kp7">ตรวจสอบ ที่ไม่มีไฟล์ PDF</a></td>
		<td align="right">&nbsp;
		
		</td>
	  </tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
		  <tr align="center"  bgcolor="#a3b2cc" >
			<td width="30" rowspan="3"><strong>ลำดับ</strong></td>        
			<td rowspan="3"><strong>หน่วยงาน</strong></td>
			<td colspan="<?=(count($arr_profile)*2)?>"><strong>จำนวนข้าราชการตามช่วงเวลา</strong></td>
			<td rowspan="3" width="60"><strong>ทั้งหมด</strong></td>
			<td rowspan="3" width="80"><strong>ข้อมูล ณ วันที่</strong></td>
		  </tr>
		  <tr  bgcolor="#a3b2cc" align="center">
		  <?php
	 		foreach($arr_profile as $subject_id=>$profile){
	  			echo '<td colspan="2"><strong>'.$profile[2].'</strong></td>' ;
			} 
			?>
		  </tr>
		  <tr  bgcolor="#a3b2cc" align="center">
		  <?php
	 		foreach($arr_profile as $subject_id=>$profile){
	  			echo '<td width="50"><strong>ทั้งหมด</strong></td>' ;
				if($_GET['check_file']!=""){
					echo '<td width="50"><strong>ไม่มีไฟล์<br/>PDF</strong></td>';
				}else{
					echo '<td width="50"><strong>LB<br/>ไม่ตรง<br/>VL</strong></td>';
				}
			} 
			?>
		  </tr>
		  <?php
		    $sql =  gen_sql($get_view,$siteid); 
			//  echo $sql."".$dbname."<br>";
			$query = mysql_db_query($dbname, $sql);
		 	$bg_color = array("#DDDDDD", "#EFEFEF");
			$row_sum_all=0;
	  		while($row = mysql_fetch_assoc($query)){
	  		$int_row++;
		  ?>
		  <tr align="center"  bgcolor="<?php echo $bg_color[$int_row%2]?>" >
			<td><?php echo $int_row;?></td>        
			<td align="left">
			<?php
			$get_view_link = ($get_view!="edu")?$get_view:"school";
			/*
			if($get_view!="school"){ 
				$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE siteid ='".$row['siteid']."' ";
				$query_count_general = mysql_db_query(STR_PREFIX_DB.$row['siteid'], $count_general);
				$row_count_general = mysql_fetch_assoc($query_count_general);
				$count_general_all = $row_count_general['count_general'];
				if($count_general_all>0){
			?>
			<a href="?get_view=<?=$get_view_link?>&siteid=<?=$row['siteid']?>&schoolid=<?=$row['schoolid']?>&check_file=<?=$_GET['check_file']?>&pf_id=<?=$_GET['pf_id']?>"><?php echo $row['caption'];?></a>
			<?php 
			}else{
				echo $row['caption'];
			}
			}else{
				echo $row['caption'];
			}
			*/
			echo $row['caption'];
			?>
			</td>
			<?php
			$row_sum=0;
	 		 foreach($arr_profile as $subject_id=>$profile){
			 $row_sum += ($dataValues[$row['siteid']][$subject_id]['count']);
			 $row_sum_all += ($dataValues[$row['siteid']][$subject_id]['count']);
	  		?>
			<td>
			<?php
			if($dataValues[$row['siteid']][$subject_id]['count']>0){
					echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s='.$profile[0].'&date_profile_e='.$profile[1].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file=" target="_blank">'.number_format($dataValues[$row['siteid']][$subject_id]['count']).'</a>';
				}else{
					echo '0';
				}
				?>
			</td>
			<td>
			<?php
			if($_GET['check_file']!=""){
				if($dataValues[$row['siteid']][$subject_id]['count_no_file']>0){
					echo '<a href="report_check_data_profile_person_timeall.php?m_type=m1&date_profile_s='.$profile[0].'&date_profile_e='.$profile[1].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&check_file=not_kp7" target="_blank">'. number_format($dataValues[$row['siteid']][$subject_id]['count_no_file']).'</a>';
				}else{
					echo '0';
				}
			}else{
				if($dataValues[$row['siteid']][$subject_id]['count_no_labelvalue']>0){
					echo '<a href="report_salary_lablevalues_detail_list.php?date_profile_s='.$profile[0].'&date_profile_e='.$profile[1].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'" target="_blank">'. number_format($dataValues[$row['siteid']][$subject_id]['count_no_labelvalue']).'</a>';
				}else{
					echo '0';
				}
			}
			?>
			</td>
			<?php } ?>
			<td><?php echo number_format($row_sum)?></td>
			<td><?php echo $arr_profilename_short[$row['siteid']]?></td>
		  </tr>
		  <?php } ?>
		  <tr align="center"  bgcolor="#CCCCCC" >
			<td colspan="2"><strong>รวม</strong></td>
			<?php
	 		 foreach($arr_profile as $subject_id=>$profile){
	  		?>
			<td><strong><?php echo number_format($exsum[$subject_id]['count'])?></strong></td>
			<td><strong><?php echo number_format($exsum[$subject_id]['count_no_labelvalue'])?></strong></td>
			<?php } ?>
			<td><strong><?php echo number_format($row_sum_all);?></strong></td>
			<td>&nbsp;</td>
			</tr>
	  </table>

</body>
</html>