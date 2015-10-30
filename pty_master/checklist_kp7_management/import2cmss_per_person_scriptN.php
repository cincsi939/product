<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");


### ทดสอบ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ทดสอบ

	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;

	## end บันทึกข้อมูลรายการข้อมูลที่จะนำเข้าระบบ
	
	$sqlm = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.sex,
t1.position_now,
t1.flag_import,
tbl_check_data.idcard_structure
FROM
tbl_checklist_kp7_all_checklist_notin_cmss_checkimp AS t1
Inner Join tbl_check_data ON t1.idcard = tbl_check_data.idcard AND t1.siteid = tbl_check_data.secid AND t1.profile_id = tbl_check_data.profile_id
WHERE
t1.status_48area =  '0' AND
t1.status_replace =  'NO' AND
t1.flag_kp7file =  '1' AND
(length(t1.birthday) = 10 and
length(t1.begindate) =  10) and
t1.flag_import='0'";
	$resultm = mysql_db_query($dbname_temp,$sqlm);
	while($rsm = mysql_fetch_assoc($resultm)){
			$sql_up = "UPDATE  tbl_checklist_kp7 SET status_id_false='1' WHERE idcard='$rsm[idcard]' and siteid='$rsm[siteid]' AND profile_id='$rsm[profile_id]'";
			echo $sql_up."<hr>";
			mysql_db_query($dbname_temp,$sql_up);
	}
	
	?>
