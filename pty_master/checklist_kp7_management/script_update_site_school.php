<?


session_start();


include("checklist2.inc.php");


if($action == "process"){
				$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.profile_id,
edubkk_checklist.tbl_checklist_kp7.siteid,
edubkk_checklist.tbl_checklist_kp7.position_now,
edubkk_checklist.tbl_checklist_kp7.schoolid,
edubkk_master.view_general.siteid as site1,
edubkk_master.view_general.position_now,
edubkk_master.view_general.schoolid as schoolid1
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.view_general ON edubkk_checklist.tbl_checklist_kp7.idcard = edubkk_master.view_general.CZ_ID
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '' OR
edubkk_checklist.tbl_checklist_kp7.siteid IS NULL  ";
		$result=  mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$i++;
			$sql_up = "UPDATE tbl_checklist_kp7 SET siteid='$rs[site1]',schoolid='$rs[schoolid1]' WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]' and siteid='$rs[siteid]'";
			//echo $sql_up."<br>";
			$sql_up1 = "UPDATE tbl_check_data SET secid='$rs[site1]',schoolid='$rs[schoolid1]'  WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]' and secid='$rs[siteid]' ";	
				mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."".__LINE__);
				mysql_db_query($dbname_temp,$sql_up1) or die(mysql_error()."".__LINE__);
		}
}//end if($action == "process"){


echo "<a href='?action=process'>คลิ๊กประมวลผล</a>";

echo "OK $i รายการ";
?>
