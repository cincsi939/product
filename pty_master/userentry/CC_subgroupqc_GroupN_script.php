<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;
$arrgroup = array("3"=>"3","4"=>"4");
//echo "xxx :: $group_id :: $configdate";die;

$staffid = "";
$group_id = 1;
$configdate = "2013-08";


$sql_m = "SELECT staffid  FROM `keystaff` WHERE (keyin_group='1' ) ";
$result_m = mysql_db_query($dbnameuse,$sql_m) or die(mysql_error()."".__LINE__);
while($rsm = mysql_fetch_assoc($result_m)){

$sql_updateflag = "SELECT
t4.datekeyin,
t4.staffid,
t4.idcard
FROM
tbl_assign_sub AS t1
Inner Join tbl_assign_key AS t2 ON t2.ticketid = t1.ticketid
Inner Join keystaff AS t3 ON t3.staffid = t1.staffid
Inner Join stat_user_keyperson AS t4 ON t2.idcard = t4.idcard AND t1.staffid = t4.staffid
WHERE
t1.profile_id >= '10' and  t1.profile_id <> '99' and 
t2.userkey_wait_approve =  '1' AND
t4.status_approve =  '0' AND
t4.staffid='$rsm[staffid]'";
#echo $sql_updateflag."<hr>";
$result_updateflag = mysql_db_query($dbnameuse,$sql_updateflag) or die(mysql_error()."".__LINE__);
while($rsf = mysql_fetch_assoc($result_updateflag)){
		$sql_update = "UPDATE stat_user_keyperson SET status_approve='1' WHERE datekeyin='$rsf[datekeyin]' AND  staffid='$rsf[staffid]' AND idcard='$rsf[idcard]' ";
		mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."".__LINE__);
}//end while($rsf = mysql_fetch_assoc($result_updateflag)){
	


SubQCGroupL($group_id,$configdate,$rsm[staffid]);	
}//end 

echo "Done..";




?>