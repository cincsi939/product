<?php
include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");
global $db_master;
$idcard = $_GET[idcard];
$group_id = $_GET[group_id];
$kp7loadid = $_GET[kp7loadid];
if($idcard != "" && $group_id != "" && $kp7loadid != ""){
	$sql = "SELECT req_problem_groupno.*, req_kp7_load.* , req_problem_groupno.runid AS runid2 FROM req_problem_groupno INNER JOIN req_kp7_load 
	ON req_problem_groupno.kp7_loadid = req_kp7_load.kp7_loadid
	WHERE req_kp7_load.idcard = '$idcard' AND problem_groupid = '$group_id' AND req_problem_groupno.kp7_loadid='$kp7loadid'";
	$res = mysql_db_query("edubkk_master",$sql);
	$int=0;
	echo "<select name='sel_load' id='sel_load' style='width:400px'> ";
	while($row = mysql_fetch_assoc($res)){
		$int++;
		echo "<option value='$row[runid2]'>$row[no_caption]</option>";
	}
	if($int <= 0){
		echo "<option value=''>---ไม่มีรายการนี้ในก.พ.7---</option>";
	}
	echo "</select>";
	exit;
} else {
	echo "---กรุณาเลือกหมวดรายการ---";
}

?>

