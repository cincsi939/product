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
		$sql .= "ORDER BY orde_by ASC";
	}else if($get_view=="school"){
		$sql = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
		$sql .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
		$sql .= ($siteid!="")?" AND siteid ='".$siteid."' ":"";
		$sql .= ($id!="")?" AND id ='".$id."' ":"";
		$sql .= "ORDER BY orderfilde ASC";
	}
	return $sql;
}

function getCountLabelValue($siteid="",$schoolid=""){
	$dbaddlog = "edubkk_system";
	$sql = "SELECT COUNT(distinct idcard) AS count_id FROM salary_lablevalues_chk 
				WHERE siteid='".$siteid."' ";
	$sql .= ($schoolid!="")?"AND schoolid='".$schoolid."' ":"";
	$query = mysql_db_query($dbaddlog,$sql);
	$row = mysql_fetch_assoc($query);
	return $row['count_id'];
}

function math_position_date($get_view="edu",$siteid="",$schoolid="",$date_profile_s="",$date_profile_e=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	if($siteid!=""){
		$strHaving="";
		if($date_profile_e==""){
				$strHaving="
				HAVING  general.dateposition_now >= DATE( '".$date_profile_s."')  OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}else{
				$strHaving="
				HAVING  general.dateposition_now BETWEEN DATE( '".$date_profile_s."') AND DATE( '".$date_profile_e."') OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}
		
		if($get_view=="edu"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE siteid ='".$siteid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			
			$general = "SELECT
			general.id, general.dateposition_now
			FROM
			general
			WHERE general.siteid='".$siteid."'
			GROUP BY general.id
			".$strHaving."
			";
		}else if($get_view=="school"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE schoolid ='".$schoolid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			$general = "SELECT
			general.id, general.dateposition_now
			FROM
			general
			WHERE general.siteid='".$siteid."'
			AND general.schoolid ='".$schoolid."'
			GROUP BY general.id
			".$strHaving."
			";
		}
		//echo $general."(".$dbsite.")<hr/>";
		$query_general = mysql_db_query($dbsite, $general);
		$str_idcard = "";
		$int_count = 0;
		$int_count_no_math = 0;
		$int_count_no_file = 0;
		while($row_general = mysql_fetch_assoc($query_general)){
				$orgfile = "../../../edubkk_kp7file/".$siteid."/" . $row_general['id'] . ".pdf";
				if($_GET['check_file']=="kp7"){
					if(is_file($orgfile)){
						$int_count++;
					}else{
						$int_count_no_file++;
					}
				}else{
					$int_count++;
				}
				
		}
	}
	$data = array("count_all"=>$count_general_all,"count"=>$int_count,"count_no_math"=>$int_count_no_math,"count_no_file"=>$int_count_no_file);
	//echo $int_count." (".$int_count_no_math.")[PIN:".$str_idcard."]";
	return $data;
}

function math_position_date_join_salary($get_view="edu",$siteid="",$schoolid="",$date_profile_s="",$date_profile_e=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	if($siteid!=""){
		$strHaving="";
		if($date_profile_e==""){
				$strHaving="
				HAVING  general.dateposition_now >= DATE( '".$date_profile_s."')  OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}else if($date_profile_s==""){
				$strHaving="
				HAVING  general.dateposition_now < DATE( '".$date_profile_e."')  OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}else{
				$strHaving="
				HAVING  general.dateposition_now BETWEEN DATE( '".$date_profile_s."') AND DATE( '".$date_profile_e."') OR  ( general.dateposition_now = '' OR  general.dateposition_now IS NULL)
				";
		}
		
		if($get_view=="edu"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE siteid ='".$siteid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			
			$general = "SELECT
			general.id, general.dateposition_now
			FROM
			general
			Inner Join salary ON general.id = salary.id
			WHERE general.siteid='".$siteid."'
			GROUP BY general.id
			".$strHaving."
			";
		}else if($get_view=="school"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE schoolid ='".$schoolid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			$general = "SELECT
			general.id, general.dateposition_now
			FROM
			general
			Inner Join salary ON general.id = salary.id
			WHERE general.siteid='".$siteid."'
			AND general.schoolid ='".$schoolid."'
			GROUP BY general.id
			".$strHaving."
			";
		}
		//echo $general."(".$dbsite.")<hr/>";
		$query_general = mysql_db_query($dbsite, $general);
		$str_idcard = "";
		$int_count = 0;
		$int_count_no_math = 0;
		$int_count_no_file = 0;
		while($row_general = mysql_fetch_assoc($query_general)){
				$orgfile = "../../../edubkk_kp7file/".$siteid."/" . $row_general['id'] . ".pdf";
				if($_GET['check_file']=="kp7"){
					if(is_file($orgfile)){
						$int_count++;
					}else{
						$int_count_no_file++;
					}
				}else{
					$int_count++;
				}
				
		}
	}
	$data = array("count_all"=>$count_general_all,"count"=>$int_count,"count_no_math"=>$int_count_no_math,"count_no_file"=>$int_count_no_file);
	//echo $int_count." (".$int_count_no_math.")[PIN:".$str_idcard."]";
	return $data;
}

function countNoSave($get_view="edu",$siteid="",$schoolid=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	if($siteid!=""){
		
		if($get_view=="edu"){			
			$general = "
			SELECT
			general.id
			FROM			general
			Left Join salary ON general.id = salary.id
			WHERE salary.id IS NULL  AND  general.siteid='".$siteid."'
			";
		}else if($get_view=="school"){
			$general = "
			SELECT
			general.id
			FROM			general
			Left Join salary ON general.id = salary.id
			WHERE salary.id IS NULL  AND  general.siteid='".$siteid."'  AND general.schoolid ='".$schoolid."'
			";
		}
		//echo $general."(".$dbsite.")<hr/>";
		$query_general = mysql_db_query($dbsite, $general);
		$str_idcard = "";
		$int_count = 0;
		$int_count_no_math = 0;
		$int_count_no_file = 0;
		while($row_general = mysql_fetch_assoc($query_general)){
				$orgfile = "../../../edubkk_kp7file/".$siteid."/" . $row_general['id'] . ".pdf";
				if($_GET['check_file']=="kp7"){
					if(is_file($orgfile)){
						$int_count++;
					}else{
						$int_count_no_file++;
					}
				}else{
					$int_count++;
				}
				
		}
	}
	$data = array("count_all"=>$count_general_all,"count"=>$int_count,"count_no_math"=>$int_count_no_math,"count_no_file"=>$int_count_no_file);
	//$data = $row_general['NUM'];
	return $data;
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
 	$arr_profile = array(	array('2552-04-01','2552-09-30','1 เม.ย 2552'), 
										array('2552-10-01','2553-03-31','1 ต.ค. 2552'), 
										array('2553-04-01','2553-09-30','1 เม.ย 2553'), 
										array('2553-10-01','2554-03-31','1 ต.ค. 2553'), 
										array('2554-04-01','2554-09-30','1 เม.ย 2554'), 
	  									array('2554-10-01','','1 ต.ค. 2554')
										);
if($_GET['check_file']==""){
	$arr_profile = $arr_profile;
}else{
	$arr_profile_ck_file = array(	array('2552-04-01','2552-09-30','1 เม.ย 2552'), 
										array('2552-10-01','2553-03-31','1 ต.ค. 2552'), 
										array('2553-04-01','2553-09-30','1 เม.ย 2553'), 
										array('2553-10-01','2554-03-31','1 ต.ค. 2553'), 
										array('2554-04-01','2554-09-30','1 เม.ย 2554'), 
	  									array('2554-10-01','','1 ต.ค. 2554'),
										"t1"=>array('','','ไม่ได้บันทึกข้อมูล'),
										"t2"=>array('','','น้อยกว่า 1 เม.ย. 2552'),
										);
	$pf_id = $_GET['pf_id'];
	 $arr_profile = array(	$arr_profile_ck_file[$pf_id] );
}
$data_count_r_all=0;
$data_count_r_no_all=0;
$data_count_r_sumall=0;
$dataNoSave_all=0;
$data_count_25520401_all=0;
$data_count_25520401_all_count=0;
$data_count_25520401_all_count_no=0;
$dataNoSave_all_count=0;
$dataNoSave_all_count_no=0;
$sql =  gen_sql($get_view,$siteid); 
$query = mysql_db_query($dbname, $sql);
while($row = mysql_fetch_assoc($query)){	
		$dataNoSave_all=countNoSave($get_view,$row['siteid'],$row['schoolid']);		
		$dataNoSave_all_count+=$dataNoSave_all['count'];
		$dataNoSave_all_count_no+=$dataNoSave_all['count_no_file'];
		
        $data_count_25520401_all_1=math_position_date_join_salary($get_view,$row['siteid'],$row['schoolid'],"","2552-04-01");
		$data_count_25520401_all_count+=$data_count_25520401_all_1['count'];
		$data_count_25520401_all_count_no+=$data_count_25520401_all_1['count_no_file'];
	foreach($arr_profile as $k=>$date_profile){
		$data_count = math_position_date($get_view,$row['siteid'],$row['schoolid'],$date_profile[0],$date_profile[1]);
		$data_count_arr_all[$k] += $data_count['count'];
		$data_count_no_arr_all[$k] += $data_count['count_no_file'];
		$data_count_r_all += $data_count['count'];
		$data_count_r_no_all += $data_count['count_no_file'];
		$data_count_r_sumall += ($data_count['count']+$data_count['count_no_file']);
	}
	if($_GET['check_file']==""){
	$data_count_r_all+=$data_count_25520401_all_1['count'];
	$data_count_r_sumall+=$data_count_25520401_all_count;
	$data_count_r_sumall+=$data_count_25520401_all_count_no;
	
	$data_count_r_all+=$dataNoSave_all['count'];
	$data_count_r_sumall+=$dataNoSave_all_count;
	$data_count_r_sumall+=$dataNoSave_all_count_no;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>รายงานตรวจสอบข้อมูลข้าราชการครูตามช่วงเวลา</title>
</head>
<body>

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
	<table width="600" border="0" align="center"  cellpadding="2" cellspacing="1" bgcolor="#BBBBBB">
	  <tr bgcolor="#a3b2cc"  align="center">
		<td width="300" rowspan="<?=$rowspan_sum?>" ><strong>ช่วงเวลา</strong></td>
		<td width="100" colspan="<?=$colspan_sum?>" ><strong>จำนวนข้าราชการ</strong></td>
		<td width="100" rowspan="<?=$rowspan_sum?>" ><strong>ร้อยละ</strong></td>
		<td width="180" rowspan="<?=$rowspan_sum?>" ><strong>ตรวจสอบไฟล์ ก.พ.7</strong></td>
	  </tr>
	  <?php 
	 if($_GET['check_file']!=""){
	  	echo '
		<tr bgcolor="#a3b2cc"  align="center">
		<td width="100" ><strong>มีไฟล์</strong></td>
		<td width="100"><strong>ไม่มีไฟล์</strong></td>
		<td width="100"><strong>ทั้งหมด</strong></td>
	  	</tr>
		';
	  }
	  ?>
      
      <?
        if($_GET['check_file']==""){
		?>
      <tr bgcolor="#FFFFFF">
		<td><strong>ไม่ได้บันทึกข้อมูล</strong></td>
		<td align="right"><?php echo number_format($dataNoSave_all_count);?></td>
		<?php
		 if($_GET['check_file']!=""){
		 	echo '
			<td align="right">'.number_format($dataNoSave_all_count_no).'</td>
			<td align="right">'.number_format(($dataNoSave_all_count+$dataNoSave_all_count_no)).'</td>
			';
		 }
		?>
		<td align="right"><?php echo number_format( ((($dataNoSave_all_count+$dataNoSave_all_count_no)/$data_count_r_sumall)*100),2 );?></td>
		<td align="center">
		<?php if($_GET['pf_id']==""){ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=N&date_profile_e=N&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=kp7&pf_id=t1">แสดงรายงาน</a>
		<?php }else{ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=">แสดงทั้งหมด</a>
		<?php } ?>
		</td>
	  </tr>
      <tr bgcolor="#FFFFFF">
		<td><strong>น้อยกว่า 1 เม.ย. 2552</strong></td>
		<td align="right"><?php echo number_format($data_count_25520401_all_count);?></td>
		<?php
		 if($_GET['check_file']!=""){
		 	echo '
			<td align="right">'.number_format($data_count_25520401_all_count_no).'</td>
			<td align="right">'.number_format(($data_count_25520401_all_count+$data_count_25520401_all_count_no)).'</td>
			';
		 }
		?>
		<td align="right"><?php echo number_format( ((($data_count_25520401_all_count+$data_count_25520401_all_count_no)/$data_count_r_sumall)*100),2 );?></td>
		<td align="center">
		<?php if($_GET['pf_id']==""){ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=kp7&pf_id=t2">แสดงรายงาน</a>
		<?php }else{ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=">แสดงทั้งหมด</a>
		<?php } ?>
		</td>
	  </tr>
      <? }?>
      
      <?
	  foreach($arr_profile as $k=>$date_profile){
	  ?>
	  <tr bgcolor="#FFFFFF">
		<td><strong><?php echo $date_profile[2]?></strong></td>
		<?php
		if($_GET['pf_id']=="t1"){
			echo '<td align="right">'.number_format($dataNoSave_all_count).'</td>';
		}else if($_GET['pf_id']=="t2"){
			echo '<td align="right">'.number_format($data_count_25520401_all_count).'</td>';
		}else{
			echo '<td align="right">'.number_format($data_count_arr_all[$k]).'</td>';
		}
		 if($_GET['check_file']!=""){
			 if($_GET['pf_id']=="t1"){
				echo '
				<td align="right">'.number_format($dataNoSave_all_count_no).'</td>
				<td align="right">'.number_format(($dataNoSave_all_count+$dataNoSave_all_count_no)).'</td>
				';
			}else if($_GET['pf_id']=="t2"){
				echo '
				<td align="right">'.number_format($data_count_25520401_all_count_no).'</td>
				<td align="right">'.number_format(($data_count_25520401_all_count+$data_count_25520401_all_count_no)).'</td>
				';
			}else{
				echo '
				<td align="right">'.number_format($data_count_no_arr_all[$k]).'</td>
				<td align="right">'.number_format(($data_count_arr_all[$k]+$data_count_no_arr_all[$k])).'</td>
				';
				
			}
		 }
		 if($_GET['pf_id']=="t1"){
		 	echo '<td align="right">'.number_format( ((($dataNoSave_all_count+$dataNoSave_all_count_no)/($dataNoSave_all_count+$dataNoSave_all_count_no))*100),2 ).'</td>';
		 }else if($_GET['pf_id']=="t2"){
		 	echo '<td align="right">'.number_format( ((($data_count_25520401_all_count+$data_count_25520401_all_count_no)/($data_count_25520401_all_count+$data_count_25520401_all_count_no))*100),2 ).'</td>';
		 }else{
		 	echo '<td align="right">'.number_format( ((($data_count_arr_all[$k]+$data_count_no_arr_all[$k])/$data_count_r_sumall)*100),2 ).'</td>';
		 }
		?>
		<td align="center">
		<?php if($_GET['pf_id']==""){ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=kp7&pf_id=<?=$k?>">แสดงรายงาน</a>
		<?php }else{ ?>
		<a href="?get_view=<?=$get_view_link?>&date_profile_s=<?=$_GET['date_profile_s']?>&date_profile_e=<?=$_GET['date_profile_e']?>&siteid=<?=$_GET['siteid']?>&schoolid=<?=$_GET['schoolid']?>&check_file=">แสดงทั้งหมด</a>
		<?php } ?>
		</td>
	  </tr>
	  <?php } ?>
	   <tr bgcolor="#CCCCCC">
		<td><strong>รวม</strong></td>
		<?php
		if($_GET['pf_id']=="t1"){
			echo '<td align="right"><strong>'.number_format($dataNoSave_all_count).'</strong></td>';
		}else if($_GET['pf_id']=="t2"){
			echo '<td align="right"><strong>'.number_format($data_count_25520401_all_count).'</strong></td>';
		}else{
			echo '<td align="right"><strong>'.number_format($data_count_r_all).'</strong></td>';
			
		}
		 if($_GET['check_file']!=""){
			 if($_GET['pf_id']=="t1"){
				echo '
				<td align="right"><strong>'.number_format($dataNoSave_all_count_no).'</strong></td>
				<td align="right"><strong>'.number_format(($dataNoSave_all_count+$dataNoSave_all_count_no)).'</strong></td>
				';
			 }else if($_GET['pf_id']=="t2"){
			 	echo '
				<td align="right"><strong>'.number_format($data_count_25520401_all_count_no).'</strong></td>
				<td align="right"><strong>'.number_format(($data_count_25520401_all_count+$data_count_25520401_all_count_no)).'</strong></td>
				';
			 }else{
				echo '
				<td align="right"><strong>'.number_format($data_count_r_no_all).'</strong></td>
				<td align="right"><strong>'.number_format($data_count_r_sumall).'</strong></td>
				';
			}
		 }
		 if($_GET['pf_id']=="t1"){
		 	echo '<td align="right">'.number_format( ((($dataNoSave_all_count+$dataNoSave_all_count_no)/($dataNoSave_all_count+$dataNoSave_all_count_no))*100),2 ).'</td>';
		 }else if($_GET['pf_id']=="t2"){
		 	echo '<td align="right">'.number_format( ((($data_count_25520401_all_count+$ddata_count_25520401_all_count_no)/($data_count_25520401_all_count+$ddata_count_25520401_all_count_no))*100),2 ).'</td>';
		 }else{
		 	echo '<td align="right"><strong>'.number_format( (($data_count_r_sumall/$data_count_r_sumall)*100),2 ).'</strong></td>';
		 }
		?>
		<td align="center">&nbsp;</td>
	  </tr>
	</table>

	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid']);?></td>
		<td align="right">&nbsp;
		
		</td>
	  </tr>
	</table>
	<?php
	if($_GET['check_file']!=""){
		$rowspan=3;
		$colspan_per = 3;
		$colspan_p = 3;
		$width_p = 300;
	}else{
		$rowspan=2;
		$colspan_per = count($arr_profile)+2;
		$colspan_p = 1;
		$width_p = 80;
	}
	?>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc" >
		<td width="50" rowspan="<?php echo $rowspan;?>"><strong>ลำดับ</strong></td>        
		<td rowspan="<?php echo $rowspan;?>"><strong>หน่วยงาน</strong></td>
		<td colspan="<?=$colspan_per;?>"><strong>จำนวนข้าราชการตามช่วงเวลา</strong></td>
		<?php if($_GET['check_file']==""){ ?>
		<td rowspan="<?php echo $rowspan;?>" width="150"><strong>จำนวนข้าราชการทั้งหมด</strong></td>
		<td rowspan="<?php echo $rowspan;?>" width="100"><strong>จำนวน LABEL ไม่ตรงกับ VALUE</strong></td>
		<?php } ?>
		<td rowspan="<?php echo $rowspan;?>" width="100"><strong>จัดการข้อมูล ณ วันที่</strong></td>
	  </tr>
	  <tr align="center"  bgcolor="#a3b2cc" >
	  <?
        if($_GET['check_file']==""){
		?>
        <td width="<?php echo $width_p;?>" colspan="<?php echo $colspan_p;?>"><strong>ไม่ได้บันทึกข้อมูล</strong></td>
        <td width="<?php echo $width_p;?>" colspan="<?php echo $colspan_p;?>"><strong>น้อยกว่า 1 เม.ย. 2552</strong></td>
        <? }?>
		<?php 
		foreach($arr_profile as $k=>$date_profile){
		?>
		<td width="<?php echo $width_p;?>" colspan="<?php echo $colspan_p;?>"><strong><?=$date_profile[2]?></strong></td>
		<?php } ?>
	  </tr>
	  <?php
	  if($_GET['check_file']!=""){
	  	echo '<tr align="center"  bgcolor="#a3b2cc"><td><strong>มีไฟล์</strong></td><td><strong>ไม่มีไฟล์</strong></td><td><strong>ทั้งหมด</strong></td></tr>';
	  }
	  
	  $sql =  gen_sql($get_view,$siteid); 
	//  echo $sql."".$dbname."<br>";
	  $query = mysql_db_query($dbname, $sql);
	  $int_row = 0;
	  $sum_c = 0;
	  $sum_no_c = 0;
	  $data_count_arr_all = array();
	  $data_count_r_all = 0;
	  $sum_c_all = 0;
	  $data_count_no_arr_all = array();
	  $num_LabelValue=0;
	  $bg_color = array("#DDDDDD", "#EFEFEF");
	  while($row = mysql_fetch_assoc($query)){
	  	$int_row++;
	  ?>
	  <tr bgcolor="<?php echo $bg_color[$int_row%2];?>" align="center">
		<td><?php echo $int_row;?></td>
		<td align="left">
			<?php 
			$get_view_link = ($get_view!="edu")?$get_view:"school";
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
			?>
		</td>
        <?
		$dataNoSave=countNoSave($get_view,$row['siteid'],$row['schoolid']);
		$totalNoSave+=$dataNoSave['count'];
		$dataNoSave_no+=$dataNoSave['count_no_file'];
		
        $data_count_25520401=math_position_date_join_salary($get_view,$row['siteid'],$row['schoolid'],"","2552-04-01");
		$total_count_25520401+=$data_count_25520401['count'];
		$data_count_25520401_no+=$data_count_25520401['count_no_file'];
		
		$total_NoS25520401=0;
		$total_NoS25520401=$dataNoSave['count']+$data_count_25520401['count'];
		?>
        
        <?
        if($_GET['check_file']==""){
		?>
        <td align="center">
		<?php
			if($dataNoSave['count']>0){
				echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s=N&date_profile_e=N&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file='.$_GET['check_file'].'&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($dataNoSave['count']).'</a>';
			}else{
				echo '0';
			}
			?>
		</td>
        <td align="center">
		<?php
			if($data_count_25520401['count']>0){
				echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s=&date_profile_e=2552-04-01&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file='.$_GET['check_file'].'&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($data_count_25520401['count']).'</a>';
			}else{
				echo '0';
			}
			?>
            </td>
            <? }?>
		<?php
		$data_count_r_all=0;
		foreach($arr_profile as $k=>$date_profile){
			$data_count = math_position_date($get_view,$row['siteid'],$row['schoolid'],$date_profile[0],$date_profile[1]);
			$data_count_arr_all[$k] += $data_count['count'];
			$data_count_no_arr_all[$k] += $data_count['count_no_file'];
			$data_count_r_all += $data_count['count'];
			$sum_c_all += $data_count['count'];
		?>
			<td>
			<?php
			if($_GET['pf_id']=="t1"){
				if($dataNoSave['count']>0){
					echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s=N&date_profile_e=N&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file='.$_GET['check_file'].'&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($dataNoSave['count']).'</a>';
				}else{
					echo '0';
				}
			}else if($_GET['pf_id']=="t2"){
				if($data_count_25520401['count']>0){
					echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s=&date_profile_e=2552-04-01&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file='.$_GET['check_file'].'&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($data_count_25520401['count']).'</a>';
				}else{
					echo '0';
				}
			}else{
				if($data_count['count']>0){
					echo '<a href="report_check_data_profile_person_timeall.php?date_profile_s='.$date_profile[0].'&date_profile_e='.$date_profile[1].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file='.$_GET['check_file'].'&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($data_count['count']).'</a>';
				}else{
					echo '0';
				}
			}
			?>
			</td>
		<?php 
			if($_GET['check_file']!=""){
				if($_GET['pf_id']=="t1"){
					echo '
						<td>
						'.(($dataNoSave['count_no_file']>0)? '<a href="report_check_data_profile_person_timeall.php?date_profile_s=N&date_profile_e=N&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file=not_kp7&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($dataNoSave['count_no_file']).'</a>':'0').'
						</td>
						<td>'.($dataNoSave['count']+$dataNoSave['count_no_file']).'</td>
						';
				}else if($_GET['pf_id']=="t2"){
					echo '
						<td>
						'.(($data_count_25520401['count_no_file']>0)? '<a href="report_check_data_profile_person_timeall.php?date_profile_s=&date_profile_e=2552-04-01&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file=not_kp7&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($data_count_25520401['count_no_file']).'</a>':'0').'
						</td>
						<td>'.($data_count_25520401['count']+$data_count_25520401['count_no_file']).'</td>
						';
				}else{
					echo '
					<td>
					'.(($data_count['count_no_file']>0)? '<a href="report_check_data_profile_person_timeall.php?date_profile_s='.$date_profile[0].'&date_profile_e='.$date_profile[1].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1&check_file=not_kp7&pf_id='.$_GET['pf_id'].'" target="_blank">'.number_format($data_count['count_no_file']).'</a>':'0').'
					</td>
					<td>
					'.($data_count['count']+$data_count['count_no_file']).'
					</td>
					';
				}
			}
		}// foreach
		 if($_GET['check_file']==""){ 
		$countLabelValue = getCountLabelValue($row['siteid'],$row['schoolid']);
		 $num_LabelValue += $countLabelValue;
		 ?>
		<td><?php echo number_format(($data_count_r_all+$total_NoS25520401));?></td>
		<td>
		<?php if($countLabelValue>0){ ?>
		<a href="report_salary_lablevalues_detail.php?siteid=<?=$row['siteid']?>&schoolid=<?=$row['schoolid']?>" target="_blank"><?php echo number_format($countLabelValue);?></a>
		<?php }else{ echo "0";}?>
		</td>
		<?php } ?>
		<td><?php echo $arr_profilename_short[$row['siteid']]?></td>
	  </tr>
	  <?php }  ?>
	   <tr bgcolor="#FFFFFF" align="center">
		<td>&nbsp;</td>
		<td align="left"><strong>รวม</strong></td>
        <?
        $allTotalNoS25520401=0;
		$allTotalNoS25520401=$totalNoSave+$total_count_25520401;
		?>
        
        <?
        if($_GET['check_file']==""){
		?>
        <td align="center"><strong><?=number_format($totalNoSave)?></strong></td>
        <td align="center"><strong><?=number_format($total_count_25520401)?></strong></td>
        
        <? }?>
		<?php
		foreach($arr_profile as $k=>$date_profile){
			if($_GET['pf_id']=='t1'){
			echo '
				<td>
				<strong>'.number_format($totalNoSave).'</strong>
				</td>
				';
			}else if($_GET['pf_id']=='t2'){
			echo '
				<td>
				<strong>'.number_format($total_count_25520401).'</strong>
				</td>
				';
			}else{
				echo '
				<td>
				<strong>'.number_format($data_count_arr_all[$k]).'</strong>
				</td>
				';
			}
		} 
		if($_GET['check_file']!=""){
			if($_GET['pf_id']=='t1'){
				echo '<td><strong>'.number_format($dataNoSave_no).'</strong></td><td><strong>'.number_format($totalNoSave+$dataNoSave_no).'</strong></td>';
			}else if($_GET['pf_id']=='t2'){
				echo '<td><strong>'.number_format($data_count_25520401_no).'</strong></td><td><strong>'.number_format($total_count_25520401+$data_count_25520401_no).'</strong></td>';
			}else{
	  			echo '<td><strong>'.number_format($data_count_no_arr_all[$k]).'</strong></td><td><strong>'.number_format($data_count_arr_all[$k]+$data_count_no_arr_all[$k]).'</strong></td>';
			}
	  	}
		if($_GET['check_file']==""){ 
		?>
		<td><strong><?php echo number_format(($sum_c_all+$allTotalNoS25520401));?></strong></td>
		<td><strong><?php echo number_format(($num_LabelValue));?></strong></td>
		<?php } ?>
		<td>&nbsp;</td>
	  </tr>
	</table>

</body>
</html>