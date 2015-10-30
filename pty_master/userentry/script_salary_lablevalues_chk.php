<?php
###################################################################
## REPORT: CHECK SALARY LABLE VALUE
###################################################################
## Version :			20110112.001 (Created/Modified; Date.RunNumber)
## Created Date :	2011-01-12 11:30
## Created By :		Mr.KIDSANA PANYA(JENG)
## E-mail :				kidsana@sapphire.co.th
## Tel. :				-
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
	
include("../../config/conndb_nonsession.inc.php");
include("../../common/check_label_values/class.checkvalue_label.php");

function getSiteName($siteid=""){
	global $dbname;
	$sql = "SELECT siteshortname FROM `eduarea_config` WHERE group_type='report' AND site='".$siteid."' ";
	$query = mysql_db_query($dbname, $sql);
	$row = mysql_fetch_assoc($query);
	return $row['siteshortname'];
}
function salary_checkvalue_label($siteid=""){
	/*
	$status_check = 0;//ถูกต้อง
	$status_check = 1;//วัน value กับ label ไม่ตรงกัน
	$status_check = 2;//ไม่มี label 
	$status_check = 3;//ไม่มี value
	*/
	$dbedubkk_userentry = DB_USERENTRY;
	$dbaddlog = "edubkk_system";
	$dbsite = STR_PREFIX_DB.$siteid;
	$status_check = 0;
	$class_chk=new check_values_label(); 
	$sql_salary = "SELECT * FROM `salary` ";
	$query_salary = mysql_db_query($dbsite, $sql_salary);
	while($row_salary = mysql_fetch_assoc($query_salary)){
		$values = trim($row_salary['date']);
		$label = trim($row_salary['label_date']);
		if($values!=""){
			 list($year_values, $month_values, $day_values)=split($class_chk->symbol, $values);
			 $values_format = $day_values."-".$month_values."-".$year_values;
			$class_chk->check_date_label($values_format, $label);
			 $day_values*1; $month_values*1; $year_values*1;
			 $chkdate = @checkdate($month_values,$day_values, ($year_values-543)); 
			 if($chkdate){
				  	if($class_chk->datecheck()){
						 $str_reval="$values|$label:ok:ถูกต้อง";
						 $status_check = 0;//ถูกต้อง
					}else{
						$str_reval="$values|$label:error:วันไม่ตรงกัน";
						if($label!=""){
							$status_check = 1;//วัน value กับ label ไม่ตรงกัน
						}else{
							$status_check = 2;//ไม่มี label 
						}
					}
			}else{
				$status_check = 1;//วัน value กับ label ไม่ตรงกัน
				//echo $day_values."-".$month_values."-".($year_values-543);
				//echo "<br/>";
			}//IF chkdate
		}else{
			$status_check = 3;//ไม่มี value
		}//IF values
		/*echo $str_reval."[".$status_check."]";
		echo "<br/>";*/
		#Insert log
		if($status_check>0){
			#Begin clear log
			$sql_clear_log = "DELETE FROM salary_lablevalues_chk WHERE siteid='".$siteid."' AND   idcard='".$row_salary['id']."' ";
			 mysql_db_query($dbaddlog, $sql_clear_log);
			 #End clear log
			 #get keystaff
			 $sql_keystaff ="SELECT
			 				keystaff.staffid,
							keystaff.staffname,
							keystaff.staffsurname,
							keystaff.staffsurname
							FROM
							tbl_assign_sub
							Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
							Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
							Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
							WHERE
							tbl_assign_key.idcard =  '".$row_salary['id']."'
							ORDER BY monitor_keyin.timeupdate_user DESC
							";
			$query_keystaff = mysql_db_query($dbedubkk_userentry, $sql_keystaff) OR DIE(mysql_error()); 
			$row_keystaff = mysql_fetch_assoc($query_keystaff);
			#get keystaff QC
			$sql_keystaff_qc =" SELECT
						keystaff.staffid,
						keystaff.prename,
						keystaff.staffname,
						keystaff.staffsurname
						FROM
						tbl_assign_sub
						Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
						Inner Join validate_checkdata ON tbl_assign_key.idcard = validate_checkdata.idcard
						Inner Join keystaff ON validate_checkdata.qc_staffid = keystaff.staffid
						WHERE
						tbl_assign_key.idcard =  '".$row_salary['id']."' 
						group by keystaff.staffid
						ORDER BY validate_checkdata.timeupdate DESC";
			$query_keystaff_qc = mysql_db_query($dbedubkk_userentry, $sql_keystaff_qc);
			$row_keystaff_qc = mysql_fetch_assoc($query_keystaff_qc);
			
			
			$sql_view_general = "SELECT prename_th, name_th, surname_th,schoolid,schoolname FROM `view_general` WHERE CZ_ID='".$row_salary['id']."' ";
			$query_view_general = mysql_db_query($dbsite, $sql_view_general);
			$row_view_general = mysql_fetch_assoc($query_view_general);
			$sql_addlog = "INSERT INTO salary_lablevalues_chk 
									 SET siteid='".$siteid."',
									 sitename='".getSiteName($siteid)."',
									 idcard='".$row_salary['id']."',
									 prename='".$row_view_general['prename_th']."',
									 fname='".$row_view_general['name_th']."',
									 lname='".$row_view_general['surname_th']."',
									 salary_id='".$row_salary['runid']."',
									 salary_no='".$row_salary['runno']."',
									 date_value='".$row_salary['date']."',
									 date_label='".$label."',
									 status_check='".$status_check."',
									 replace_date_value='',
									 replace_date_label='',
									 replace_status='0',
									 date_check=NOW(),
									 key_id='".$row_keystaff['staffid']."',
									 key_prename='".$row_keystaff['prename']."',
									 key_fname='".$row_keystaff['staffname']."',
									 key_lname='".$row_keystaff['staffsurname']."',
									 qc_id='".$row_keystaff_qc['staffid']."',
									 qc_prename='".$row_keystaff_qc['prename']."',
									 qc_fname='".$row_keystaff_qc['staffname']."',
									 qc_lname='".$row_keystaff_qc['staffsurname']."',
									 schoolid='".$row_view_general['schoolid']."',
									 schoolname='".$row_view_general['schoolname']."'
									";
				//echo $sql_addlog."<p/>";
				mysql_db_query($dbaddlog, $sql_addlog);
			}
	}//WHERE
}



$dateTime = intval(date("H"));
$dbsystem = "edubkk_system";
$dbnamemaster = DB_MASTER;

$time_start = microtime(true);
if( $_GET['run_time']=='on'  || $dateTime >= 0 ){//(($dateTime >= 0 && $dateTime < 8) || ($dateTime >= 20 && $dateTime <=24 )) || $_GET['run_time']=='on'
	// $dateTime >= 0
	$query_check = mysql_db_query($dbsystem,"SELECT secid FROM queue_salary_lablevalues_chk WHERE status_manual = 'working'  ") or die(mysql_error());
	$num_check = mysql_num_rows($query_check);
	
	if($num_check == 0){//ถ้าไม่มีการประมวณผล
	  $query = mysql_db_query($dbsystem,"SELECT *  FROM queue_salary_lablevalues_chk WHERE status_manual = 'wait'  ORDER BY order_by ASC LIMIT 0,1 ");
	  $rows = mysql_fetch_array($query);//เรียกข้อมูลเพื่อทำการคำนวณคะแนน
	  if($rows['secid'] != "" ){
	  	mysql_query("UPDATE queue_salary_lablevalues_chk SET status_manual = 'working', update_time=NOW() WHERE secid = '".$rows['secid']."' ");//แก้ไขสถานะเป็น working
	  	#เรียกใช้ Function
		salary_checkvalue_label($rows['secid']);
	  	mysql_db_query($dbsystem,"UPDATE queue_salary_lablevalues_chk SET status_manual = 'finish' WHERE secid = '".$rows['secid']."' ");//แก้ไขสถานะเป็น finish
	  }
	}
	
	if($dateTime >= 1 && $dateTime < 23){
		$query = mysql_db_query($dbsystem,"SELECT *  FROM queue_salary_lablevalues_chk WHERE status_manual = 'working' ORDER BY update_time ASC LIMIT 0,1 ");
	  	$rows = mysql_fetch_array($query);//เรียกข้อมูลเพื่อทำการคำนวณคะแนน
		$arrDT_s = explode(" ",$rows['update_time']);
		$arrD_s =  explode("-",$arrDT_s[0]);
		$arrT_s = explode(":",$arrDT_s[1]);
		$timeWork = @mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')) - mktime($arrT_s[0],$arrT_s[1],$arrT_s[2],$arrD_s[1],$arrD_s[2],$arrD_s[0]);
		if($timeWork > 120){
			mysql_query("UPDATE queue_salary_lablevalues_chk SET status_manual = 'wait' WHERE secid = '".$rows['secid']."' ");//แก้ไขสถานะเป็น working
		}
	}
}else{
	echo " <U>ไม่อยู่ในเวลาประมวลผล</u> <br/>ประมวลผลในช่วงเวลา 22.00 - 08.00 น.  <br/>";
	if($dateTime >= 9 && $dateTime < 21){
		$query_working = mysql_db_query($dbsystem,"SELECT queue_id FROM queue_salary_lablevalues_chk WHERE status_manual = 'working'  ORDER BY update_time ASC LIMIT 0,1 ") or die(mysql_error());
		$rows = mysql_fetch_array($query_working);//เรียกข้อมูลเพื่อทำการคำนวณคะแนน
		$num_working = mysql_num_rows($query_working);
		if($num_working > 0){//ถ้าสถานะค้างอยู่ที่ working
			echo "Update : queue_status <br/>";
			echo " Process... ";
			mysql_db_query($dbsystem, "UPDATE queue_salary_lablevalues_chk SET status_manual = 'wait' WHERE secid = '".$rows['secid']."' ");//แก้ไขสถานะเป็น working
		}
		
	}
}
$time_end = microtime(true);
$timeProcess = $time_end - $time_start;
echo "<br/>".number_format($timeProcess,4)."&nbsp;วินาที <br/>";


?>