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
and keystaff_group.rpoint ='10'  $constaff ";
//echo $dbname_temp.": $sql<br>";or datek >= '2010-10-01' or datek >= '2010-10-01' 
	$result = mysql_db_query($dbname_temp,$sql);

	while($rs = mysql_fetch_assoc($result)){

		 $sql1 = "SELECT max(flag_qc) as maxid FROM `stat_user_keyperson` where datekeyin LIKE '$configdate%' and status_approve='1' and (hidden_point IS NULL)   and staffid='$rs[staffid]';";
		//echo $dbname_temp." :: $sql1<br><br>";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			$flgid = $rs1[maxid];
			$sql2 = "SELECT * FROM stat_user_keyperson WHERE datekeyin LIKE '$configdate%' and status_approve='1'  and staffid='$rs[staffid]' and hidden_point IS NULL ORDER BY flag_qc ASC";
			$result2 = mysql_db_query($dbname_temp,$sql2);
			$i=0;			
			while($rs2 = mysql_fetch_assoc($result2)){
				
				$i++;
				if($i <= 10){
					$flgid = $flgid;
				}else{
					$i=1;
					$flgid++;
				}//end 		if($i < 10){
					
				$sqlupdate = "UPDATE stat_user_keyperson SET flag_qc='$flgid'  WHERE datekeyin='$rs2[datekeyin]' AND staffid='$rs2[staffid]' AND idcard='$rs2[idcard]' ";
				//echo "$i :: $sqlupdate<br>";
				mysql_db_query($dbname_temp,$sqlupdate);
			
			}// end while($rs2 = mysql_fetch_assoc($result2)){
				$sql_deltemp = "DELETE FROM stat_user_person_temp WHERE staffid='$rs[staffid]' AND dateqc LIKE '$configdate%'";
				echo "<hr>".$sql_deltemp."<br>";
				mysql_db_query($dbname_temp,$sql_deltemp);
				
		
			
		SubGroupQC_Script($rs[staffid]);
	
	}//end while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process"){


echo "<a href='?action=process'>ประมวลผลข้อมูล</a>";
?>