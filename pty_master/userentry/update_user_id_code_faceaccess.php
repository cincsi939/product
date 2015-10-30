<?
require_once("../../config/conndb_nonsession.inc.php");
$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = DB_USERENTRY;

$host = HOST;
$user = "cmss";
$pass = "2010cmss";

ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
$sql = "SELECT * FROM keystaff WHERE id_code='' OR id_code is null";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
		ConHost($host_face,$user_face,$pass_face); // connect faceaccess
		$sql1 = "SELECT id_code FROM faceacc_officer WHERE pin='$rs[card_id]' ";
		$result1 = mysql_db_query($dbface,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[id_code] != ""){
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
				$sql_update = "UPDATE keystaff SET id_code='$rs1[id_code]' WHERE staffid='$rs[staffid]'  ";
				mysql_db_query($dbnameuse,$sql_update);
		}// end if($rs1[id_code] != ""){
}// end while($rs = mysql_fetch_assoc($result)){





?>