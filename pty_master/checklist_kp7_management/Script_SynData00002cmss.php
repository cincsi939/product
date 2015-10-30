<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");

$sql = "SELECT
t1.CZ_ID as idcard, t1.siteid, t1.prename_th, t1.name_th, t1.surname_th, t2.prename_th, t2.name_th, t2.surname_th,t1.schoolid ,t1.position_now FROM edubkk_master.view_general as t1 Inner Join cmss_0000.general as t2 ON t1.CZ_ID = t2.id";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){

$idcard = "$rs[idcard]";
$sitesource = "0000";
$sitedest = "$rs[siteid]";
$schoolid = "$rs[schoolid]";
$db_site = "cmss_".$sitedest;

#### ตรวจสอบขอ้มูลว่าปลายทางมีหรือไม่

mysql_db_query($db_site,"DELETE FROM hr_addhistoryaddress  WHERE gen_id  = '$idcard'");
 mysql_db_query($db_site,"DELETE FROM hr_addhistoryfathername  WHERE gen_id  = '$idcard'");
 mysql_db_query($db_site,"DELETE FROM hr_addhistorymarry  WHERE gen_id  = '$idcard'");
 mysql_db_query($db_site,"DELETE FROM hr_addhistorymothername  WHERE gen_id  = '$idcard'");
 mysql_db_query($db_site,"DELETE FROM hr_addhistoryname  WHERE gen_id  = '$idcard'");
$result_tranfer = transfer_data($idcard,$sitesource,$sitedest,"0000",$schoolid,"11","tranfer_data_to_cmss");
if($result_tranfer == "OK"){
	$sql_log = "INSERT INTO log_tranferdatacmss0000tocmss SET idcard='$idcard',siteid='$sitedest',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',schoolid='$rs[schoolid]',position_now='$rs[position_now]',timeupdate=NOW()";	
	mysql_db_query($dbnamemaster,$sql_log) or die(mysql_error()."$sql_log<br>LINE__".__LINE__);
}

}//end 
echo "Done....";
?>