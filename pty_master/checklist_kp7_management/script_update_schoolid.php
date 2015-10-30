<?
session_start();
include("checklist.inc.php");
### function ตรวจสอบเลขบัตรซ้ำกับเขตอื่น

$sql = "SELECT
edubkk_checklist.tbl_check_data.schoolid,
g1.id
FROM
edubkk_checklist.tbl_check_data
Inner Join general as g1 ON edubkk_checklist.tbl_check_data.idcard = g1.idcard
WHERE
edubkk_checklist.tbl_check_data.schoolid <>  g1.schoolid";
$result = mysql_db_query("cmss_6502",$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_up = "UPDATE general set schoolid='$rs[schoolid]' where id='$rs[id]'";	
	//mysql_db_query("cmss_6502",$sql_up);
	echo "$sql_up<br>";
}
?>
