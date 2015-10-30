<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

//$constaff = " and staffid='10015'";

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
and (keystaff_group.groupkey_id='5'  OR  keystaff_group.groupkey_id='2') $constaff ";
//echo $dbname_temp.": $sql<br>";or datek >= '2010-10-01' or datek >= '2010-10-01' 
	$result = mysql_db_query($dbname_temp,$sql);
	$flgid = 0;
	while($rs = mysql_fetch_assoc($result)){
		$sql_update1 = "UPDATE stat_user_keyperson SET flag_qc='0' WHERE datekeyin LIKE '2011-02%' and status_approve='1'  and staffid='$rs[staffid]' ";
		mysql_db_query($dbname_temp,$sql_update1);
		/*$sql1 = "SELECT count(idcard) as num1,flag_qc,max(datekeyin) as datek  FROM `stat_user_keyperson` where staffid='$rs[staffid]'  and status_random_qc  ='0'  and flag_qc > 0 
		 group by flag_qc  having num1 <> '19' and (datek LIKE '2010-11%' )      order by flag_qc asc LIMIT 1; ";*/
		 $sql1 = "SELECT max(flag_qc) as maxid FROM `stat_user_keyperson` where datekeyin LIKE '2011-01%' and status_approve='1'  and staffid='$rs[staffid]';";
		//echo $dbname_temp." :: $sql1<br><br>";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		$flgid = $rs1[maxid]+1;
			$sql2 = "SELECT * FROM stat_user_keyperson WHERE datekeyin LIKE '2011-02%' and status_approve='1'  and staffid='$rs[staffid]' GROUP BY idcard ORDER BY flag_qc ASC";
			$result2 = mysql_db_query($dbname_temp,$sql2);
			$i=0;			
			while($rs2 = mysql_fetch_assoc($result2)){
				$i++;
				if($i <= 20){
					$flgid = $flgid;
				}else{
					$i=1;
					$flgid++;
				}//end 		if($i <= 20){
					
					$sqlupdate = "UPDATE stat_user_keyperson SET flag_qc='$flgid'  WHERE datekeyin='$rs2[datekeyin]' AND staffid='$rs2[staffid]' AND idcard='$rs2[idcard]' ";
					echo "$i :: $sqlupdate<br>";
					mysql_db_query($dbname_temp,$sqlupdate);

			
			}// end while($rs2 = mysql_fetch_assoc($result2)){
				$sql_deltemp = "DELETE FROM stat_user_person_temp WHERE staffid='$rs[staffid]' AND dateqc LIKE '2011-02%'";
				echo "<hr>".$sql_deltemp."<br>";
				mysql_db_query($dbname_temp,$sql_deltemp);
				
		
			
		SubGroupQC_Script($rs[staffid]);
	
	}//end while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process"){


echo "<a href='?action=process'>ประมวลผลข้อมูล</a>";
?>