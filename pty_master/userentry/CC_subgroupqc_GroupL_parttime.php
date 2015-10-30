<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$group_id = 5;
$yymm = date("Y-m");
//echo $yymm;die;
$constaff = " and staffid NOT IN('11852','11853')";
$sql = "SELECT * FROM `keystaff` where period_time='pm' and status_permit='YES' and keyin_group='5' $constaff";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

 SubQCGroupL($group_id,$yymm,$rs[staffid]);
}//end 
 echo "OK";

?>