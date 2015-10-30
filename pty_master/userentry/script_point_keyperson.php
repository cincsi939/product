<?
include ("../../config/conndb_nonsession.inc.php")  ;
$yymm = "2011-03";

$sql = "SELECT
stat_user_keyperson.idcard,
stat_user_keyperson.staffid,
Count(idcard) AS num1,
stat_user_keyperson.numpoint,
stat_user_keyperson.datekeyin
FROM `stat_user_keyperson`
WHERE datekeyin LIKE '$yymm%'
group by staffid,idcard, numpoint
having num1 > 1";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT * FROM stat_user_keyperson WHERE idcard='$rs[idcard]' and staffid='$rs[staffid]' and numpoint='$rs[numpoint]' order by datekeyin desc LIMIT 1  ";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$sql_del = "DELETE FROM stat_user_keyperson WHERE  idcard='$rs[idcard]' and staffid='$rs[staffid]' and numpoint='$rs[numpoint]' AND datekeyin='$rs1[datekeyin]'";
	mysql_db_query($dbnameuse,$sql_del);
	//echo "$sql_del;<br>";
		
}// end while($rs = mysql_fetch_assoc($result)){


echo "OK";


?>