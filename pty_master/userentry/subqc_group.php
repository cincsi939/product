<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

//$constaff = " and staffid='10015'";

$configdate = "2011-04";

$sql = "SELECT
stat_user_keyperson.datekeyin,
stat_user_keyperson.staffid,
stat_user_keyperson.flag_qc
FROM `stat_user_keyperson`
where datekeyin LIKE '$configdate%' and status_approve='1' and status_random_qc='1'";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
		$sql_up = "UPDATE stat_user_person_temp SET qc_pass='1' WHERE flag_id='$rs[flag_qc]' AND staffid='$rs[staffid]' AND dateqc LIKE '$configdate%' ";
		mysql_db_query($dbnameuse,$sql_up);
		//echo $sql_up."<br>";
}// end while($rs = mysql_fetch_assoc($result)){


/*$arr_d = explode("-",$configdate);
$intd = intval($arr_d[1]);
if($intd == 1){
		$condate1 = ($arr_d[0]-1)."-".$mm1;
}else{
	$mm = ($intd-1);
	$mm1 = sprintf("%02d",$mm);
	$condate1 = $arr_d[0]."-".$mm1;	
}//end if($intd == 1){




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
and keystaff_group.rpoint ='20' ";
//echo $dbname_temp.": $sql<br>";or datek >= '2010-10-01' or datek >= '2010-10-01' 
	$result = mysql_db_query($dbname_temp,$sql);

	while($rs = mysql_fetch_assoc($result)){
		$sql_update1 = "UPDATE stat_user_keyperson SET flag_qc='0' WHERE datekeyin LIKE '$configdate%' and status_approve='1'  and staffid='$rs[staffid]' ";
		mysql_db_query($dbname_temp,$sql_update1);
		

		 $sql1 = "SELECT max(flag_qc) as maxid FROM `stat_user_keyperson` where datekeyin LIKE '$condate1%' and status_approve='1' and (hidden_point IS NULL)   and staffid='$rs[staffid]';";
		//echo $dbname_temp." :: $sql1<br><br>";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			$flgid = $rs1[maxid];
			$sql2 = "SELECT * FROM stat_user_keyperson WHERE datekeyin LIKE '$configdate%' and status_approve='1'  and staffid='$rs[staffid]' and hidden_point IS NULL ORDER BY flag_qc ASC";
			$result2 = mysql_db_query($dbname_temp,$sql2);
			$i=0;			
			while($rs2 = mysql_fetch_assoc($result2)){
				
				$i++;
				if($i <= 20){
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
	
	}//end while($rs = mysql_fetch_assoc($result)){*/
		




?>