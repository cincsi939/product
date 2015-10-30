<?
require_once("../../config/conndb_nonsession.inc.php");
$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = "edubkk_userentry";

$host = HOST;
$user = "cmss";
$pass = "2010cmss";

$arrstaff = array('19'=>'NOR','34'=>'QC','35'=>'AC','16'=>'CALLCENTER','12'=>'SCAN','18'=>'GRAPHIC','40'=>'site_area');// site งาน






	ConHost($host_face,$user_face,$pass_face); // connect faceaccess
	$sql = "SELECT
t1.pin,
t1.firstname,
t1.surname,
t2.prename_th,
t1.status_id,
t1.office,
t1.email,
t1.phone_number,
t1.username,
t1.`password`,
t3.time_start,
t1.firstname_eng,
t1.surname_eng,
t1.period_group_id
FROM faceacc_officer as t1 left join tbl_prename as t2 ON t1.prename=t2.id
left join faceacc_officer_to_status as t3 ON t1.officer_id=t3.officer_id
WHERE t1.period_group_id IN('1','3')  and t1.status_id <> '1'";
	$result = mysql_db_query($dbface,$sql) or die(mysql_error());
	while($rs = mysql_fetch_assoc($result)){
	
		 if($rs[period_group_id] == "1"){
				 $conw1 = " AND period_time='am'";
			}else if($rs[period_group_id] == "3"){
				 $conw1 = " AND period_time='pm'";
			}
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
			$sql_update_staff	 = "UPDATE keystaff SET  status_permit='NO', retire_date='$rs[time_start]' WHERE card_id='$rs[pin]' and sapphireoffice='0' $conw1";
			//echo " $rs[firstname] $rs[surname] :: ".$sql_update_staff."<br>";
			mysql_db_query($dbnameuse,$sql_update_staff) or die(mysql_error()."$sql_update_staff<br>LINE__".__LINE__);

			
	}//end 	while($rs = mysql_fetch_assoc($result)){
		
echo "Done....";

#####################  proces #########################3



?>