<?


session_start();


include("checklist2.inc.php");
$sql = "SELECT COUNT(idcard) as num1,siteid  FROM `tbl_checklist_kp7_all_view` group by siteid ";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT * FROM  tbl_checklist_estimate_new  WHERE siteid='$rs[siteid]' ";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	echo "$rs[num1]  :::  $rs1[num_cmss]<br>";
	if($rs[num1] > $rs1[num_cmss]){
			$sql_up = "UPDATE tbl_checklist_estimate_new SET num_cmss='$rs[num1]' WHERE siteid='$rs1[siteid]' ";
			echo "$sql_up<br>";
			mysql_db_query($dbname_temp,$sql_up);
	}
		
}//end while($rs = mysql_fetch_assoc($result)){
echo "OK";
?>
