<?


session_start();


include("checklist2.inc.php");

$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.birthday,
tbl_checklist_kp7_false.begindate,
tbl_checklist_kp7_false.position_now,
tbl_checklist_kp7_false.schoolid
FROM
tbl_checklist_kp7
Inner Join tbl_checklist_kp7_false ON tbl_checklist_kp7.idcard = tbl_checklist_kp7_false.idcard
WHERE
tbl_checklist_kp7.siteid =  '9401' AND
tbl_checklist_kp7.profile_id =  '5' AND
tbl_checklist_kp7.name_th =  '' AND
tbl_checklist_kp7_false.profile_id =  '5' AND
tbl_checklist_kp7_false.siteid =  '9401'";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
		$sql_update = "UPDATE tbl_checklist_kp7 SET prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',
		birthday='$rs[birthday]',begindate='$rs[begindate]',position_now='$rs[position_now]',schoolid='$rs[schoolid]'  where idcard='$rs[idcard]' AND profile_id='5' and siteid='$rs[siteid]' ";
		//echo "$sql_update<br>";
		mysql_db_query($dbname_temp,$sql_update) or die(mysql_error());
}//end 

?>
