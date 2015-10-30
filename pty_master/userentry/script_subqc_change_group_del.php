<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

//$constaff = " and staffid='10015'";
$configdate = "2010-12";

if($action == "process"){
	$sql = "SELECT
keystaff_group.rpoint,
keystaff.staffid,
keystaff_group.groupkey_id
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff.status_extra =  'NOR' AND
keystaff.status_permit =  'YES'
and keystaff_group.rpoint ='10' and  keystaff.staffid='11029'";
//echo $dbname_temp.": $sql<br>";or datek >= '2010-10-01' or datek >= '2010-10-01' 
	$result = mysql_db_query($dbname_temp,$sql);

	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT
stat_user_keyperson.idcard,
Count(idcard) AS num1,
stat_user_keyperson.staffid,
stat_user_keyperson.datekeyin,
stat_user_keyperson.numkeyin,
stat_user_keyperson.numpoint,
stat_user_keyperson.hidden_point,
stat_user_keyperson.flag_qc
FROM `stat_user_keyperson`
where datekeyin LIKE '2010-12%' and staffid='$rs[staffid]'
group by idcard
having num1 > 1";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$sql2 = "SELECT * FROM stat_user_keyperson WHERE  staffid='$rs1[staffid]' AND idcard='$rs1[idcard]' and datekeyin LIKE '2010-12%' ORDER BY datekeyin DESC LIMIT 1";
		$result2 = mysql_db_query($dbname_temp,$sql2); 
		$rs2 = mysql_fetch_assoc($result2);
		$sql_del = "DELETE FROM stat_user_keyperson WHERE staffid='$rs2[staffid]' AND datekeyin ='$rs2[datekeyin]' AND idcard='$rs2[idcard]'";
		echo "$sql_del<br>";
			
	}

	
	}//end while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process"){


echo "<a href='?action=process'>ประมวลผลข้อมูล</a>";
?>