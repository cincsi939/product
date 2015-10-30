<?
include("epm.inc.php");
$sql = "SELECT
t1.staffid,
t1.status_permit,
t3.idcard,
t3.profile_id,
t3.status_keydata,
t3.ticketid
FROM
keystaff as t1
Inner Join tbl_assign_sub as t2 ON t1.staffid = t2.staffid
Inner Join tbl_assign_key as t3 ON t2.ticketid = t3.ticketid
where t1.status_permit='NO'
and (t3.approve='1' OR t3.approve='0') and t3.status_keydata='0'
and t3.profile_id >= 4";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
		$sql_del = "DELETE FROM tbl_assign_key WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' AND ticketid='$rs[ticketid]'";
		echo "$sql_del<br>";
		mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
}//end while($rs = mysql_fetch_assoc($result)){
echo "OK";
	
?>