<?
include "epm.inc.php";
$dbcall = DB_USERENTRY;
if($action == "process"){
	$sql = "SELECT * FROM temp_old_new_id ORDER BY new_id";
	$result = mysql_db_query($dbcall,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "UPDATE monitor_keyin SET idcard='$rs[new_id]' WHERE idcard='$rs[old_id]'";
		//echo "$sql1<br>";
		mysql_db_query($dbcall,$sql1);
		$sql2 = "UPDATE  general_check SET idcard='$rs[new_id]' WHERE idcard = '$rs[old_id]'";
		mysql_db_query($dbcall,$sql2);
	}
}

?>
<a href="?action=process">ประมวลผล</a>