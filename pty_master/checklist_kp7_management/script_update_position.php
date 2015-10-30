<?


session_start();


include("checklist2.inc.php");


if($action == "process"){
				$sql = "SELECT
		t1.idcard,
		t1.profile_id,
		t1.siteid,
		t1.prename_th,
		t1.name_th,
		t1.surname_th,
		t1.birthday,
		t1.begindate,
		t1.position_now,
		t1.schoolid,
		t2.report_id,
		t3.position_now as pos,
		t3.schoolid,
		t3.birthday,
		t3.begindate
		FROM
		edubkk_checklist.tbl_checklist_kp7 AS t1
		Inner Join edubkk_checklist.tbl_cmss_profile_new AS t2 ON t1.profile_id = t2.profile_id AND t1.siteid = t2.siteid
		Inner Join edubkk_master.view_general as t3 ON t1.idcard = t3.CZ_ID
		WHERE
		t2.report_id =  '10' and ( t1.position_now='' or t1.position_now IS NULL) ";
		$result=  mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET position_now='$rs[pos]',birthday='$rs[birthday]',begindate='$rs[begindate]' WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]' and siteid='$rs[siteid]'";
			//echo $sql_up."<br>";
			$sql_up1 = "UPDATE tbl_check_data SET position_now='$rs[pos]',birthday='$rs[birthday]',begindate='$rs[begindate]' WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]' and secid='$rs[siteid]' ";	
				mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."".__LINE__);
				mysql_db_query($dbname_temp,$sql_up1) or die(mysql_error()."".__LINE__);
		}
}//end if($action == "process"){


echo "<a href='?action=process'>คลิ๊กประมวลผล</a>";

echo "OK $i รายการ";
?>
