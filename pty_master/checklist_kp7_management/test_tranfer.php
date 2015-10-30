<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");


$sql = "SELECT
t1.CZ_ID as idcard,
t1.siteid AS site_source,
t1.schoolid,
t2.siteid as site_dest
FROM
view_general_report AS t1
Inner Join allschool as t2  ON t1.schoolid = t2.id
WHERE
 t1.siteid <> t2.siteid
";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br<LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	
$idcard = "$rs[idcard]";
$sitesource = "$rs[site_source]";
$sitedest = "$rs[site_dest]";

$schoolsource = "$rs[schoolid]";
$schooldest = "$rs[schoolid]";


	$result_tranfer = transfer_data($idcard,$sitesource,$sitedest,$schoolsource,$schooldest,"11","tranfer_structure");

}//end 






echo "Done .. ".$result_tranfer;

?>
