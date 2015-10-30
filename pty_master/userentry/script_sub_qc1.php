<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

//$constaff = " and staffid='10015'";

if($action == "process"){
	$sql = "SELECT count(idcard) as num,flag_qc,staffid FROM `stat_user_keyperson` WHERE flag_qc > 0 group by staffid,flag_qc having num=11; ";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT * FROM  stat_user_keyperson WHERE  staffid='$rs[staffid]' AND flag_qc='$rs[flag_qc]' order by hidden_point ASC LIMIT 1";
		//echo $sql1."<br>";
		$reulst1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($reulst1);
		$sql_update = "UPDATE stat_user_keyperson SET flag_qc='1' WHERE staffid='$rs1[staffid]' and datekeyin='$rs1[datekeyin]' and idcard='$rs1[idcard]'";
		mysql_db_query($dbname_temp,$sql_update);
		//echo "$sql_update;<br>";
	}//end 
}//end if($action == "process"){


echo "<a href='?action=process'>ประมวลผลข้อมูล</a>";
?>