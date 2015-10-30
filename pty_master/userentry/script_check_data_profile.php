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
		 $str_date = intval($arr_date[2])." ".$mname[intval($arr_date[1])]." ".($arr_date[0]+543);
	}else{
		$str_date = "-";
	}
	return $str_date;
}

function gen_sql($get_view="edu",$area_keyin_status="",$siteid="",$id=""){
	global $user_site;
	
	if($get_view=="edu" || $get_view==""){ 
		
		if($area_keyin_status!=""){
			$where_area_keyin_status = "AND  ".DB_MASTER.".eduarea.`area_keyin_status` = '$area_keyin_status' ";
		}else{
			$where_area_keyin_status = "";
		}
		$sql = "SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM  ".DB_MASTER.".eduarea ";
		$sql .= " WHERE 
						 ".DB_MASTER.".eduarea.secid IS NOT NULL AND  ".DB_MASTER.".eduarea.secname IS NOT NULL AND  ".DB_MASTER.".eduarea.secid NOT LIKE('99%') 
					".$where_area_keyin_status;
		$sql .= ($siteid!="" and $user_site != DB_MASTER)?" AND  ".DB_MASTER.".eduarea.secid ='".$siteid."' ":"";
		$sql .= " ORDER BY   ".DB_MASTER.".eduarea.secname_short,  ".DB_MASTER.".eduarea.secid ASC";
	}else if($get_view=="school"){
		$sql = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
		$sql .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
		$sql .= ($siteid!="")?" AND siteid ='".$siteid."' ":"";
		$sql .= ($id!="")?" AND id ='".$id."' ":"";
		$sql .= "ORDER BY orderfilde ASC";
	}
	
	return $sql;
}

function math_position_date($get_view="edu",$siteid="",$schoolid="",$date_profile="",$area_keyin_status=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	$date_profile = $date_profile;
	
	if($siteid!=""){
		if($get_view=="edu"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE siteid ='".$siteid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			
			$general = "SELECT
			general.id, MAX( salary.`date` ) AS max_date, general.dateposition_now
			FROM
			general
			LEFT JOIN salary ON general.id = salary.id 
			WHERE general.siteid='".$siteid."'
			GROUP BY general.id
			HAVING MAX( DATE(salary.`date`) ) < DATE( '".$date_profile."')  OR  (max_date = '' OR max_date IS NULL) ";
		}else if($get_view=="school"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE schoolid ='".$schoolid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			$general = "SELECT
			general.id, MAX( salary.`date` ) AS max_date, general.dateposition_now
			FROM
			general
			LEFT JOIN salary ON general.id = salary.id 
			WHERE general.siteid='".$siteid."'
			AND general.schoolid ='".$schoolid."'
			GROUP BY general.id
			HAVING MAX( DATE(salary.`date`) ) < DATE( '".$date_profile."') OR  (max_date = '' OR max_date IS NULL) ";
		}
		//echo $general."(".$dbsite.")<br/>";
		$query_general = mysql_db_query($dbsite, $general);
		$str_idcard = "";
		$int_count = 0;
		$int_count_no_math = 0;
		while($row_general = mysql_fetch_assoc($query_general)){
			if($date_profile > $row_general['max_date']){
				$int_count++;
				if($row_general['dateposition_now'] != $row_general['max_date']){
					$int_count_no_math++;
				}
			}
		}
	}
	$data = array("count_all"=>$count_general_all,"count"=>$int_count,"count_no_math"=>$int_count_no_math);
	
	$arr_p = explode("-",$date_profile);
	$profile_eng = ($arr_p[0]-543)."-".$arr_p[1]."-".$arr_p[2];
	$sql_insert = "REPLACE INTO  ".DB_MASTER.".report_check_data_profile
							SET  ".DB_MASTER.".report_check_data_profile.siteid='".$siteid."',
							 ".DB_MASTER.".report_check_data_profile.profile_date='".$profile_eng."',
							 ".DB_MASTER.".report_check_data_profile.count_all='".$count_general_all."',
							 ".DB_MASTER.".report_check_data_profile.count='".$int_count."',
							 ".DB_MASTER.".report_check_data_profile.count_no_math='".$int_count_no_math."',
							 ".DB_MASTER.".report_check_data_profile.area_keyin_status='".$area_keyin_status."',
							 ".DB_MASTER.".report_check_data_profile.update_datetime=NOW() ";
	mysql_query($sql_insert);
	//echo $sql_insert."<br/>";
	//echo $int_count." (".$int_count_no_math.")[PIN:".$str_idcard."]";
	return $data;
}

#End Funtions ---------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>ประมวลผลตรวจสอบข้อมูลตามที่ไม่ตรงตามโปรไฟล์</title>
</head>
<body>

	<center><strong style="font-size:16px;">ประมวลผลตรวจสอบข้อมูลตามที่ไม่ตรงตามโปรไฟล์</strong></center>
	
	  <?php
	  $arr_keyin_status = array("new","update");
	  foreach($arr_keyin_status as $v_status){
		  $area_keyin_status = $v_status;
		  $sql =  gen_sql($get_view,$area_keyin_status,$siteid); 
		  //echo $sql."".$dbname."<br>";
		  $query = mysql_db_query($dbname, $sql);
		  $bg_color = array("#DDDDDD", "#EFEFEF");
		  while($row = mysql_fetch_assoc($query)){
			#Begin ช่วงเวลา 
			$arr_period = array("04-01"=>"1 เม.ย. ", "10-01"=>"1 ต.ค. ");
			$year_s = 2009+543;
			$year_e = intval(date("Y"))+543;
			for($y=$year_s;$y<=$year_e;$y++){	
				foreach($arr_period as $period_k => $period_v){
					if($y<=$year_e){
						$data_count = math_position_date($get_view, $row['siteid'], $row['schoolid'], $y.'-'.$period_k,$area_keyin_status);
					}else if($year_e == $y ){
						if(intval(date('m')) < 4){
							if("04-01" == $period_k){
								$data_count = math_position_date($get_view, $row['siteid'], $row['schoolid'], $y.'-'.$period_k,$area_keyin_status);
							}
						}else if(intval(date('m')) >= 4){
							if("10-01" == $period_k){
								$data_count = math_position_date($get_view, $row['siteid'], $row['schoolid'], $y.'-'.$period_k,$area_keyin_status);
							}
						}
					}
				}//Foreach
			}//For
			#End ช่วงเวลา 
		  }  
	  }
		 ?>
<script>
opener.document.location.reload();
</script>
<center>
<strong style="font-size:18px; color:#060;">ประมวลผลเรียบร้อยแล้ว</strong>
<p><a href="javascript:window.close();">ปิดหน้าประมวล</a></p>
</center>
</body>
</html>