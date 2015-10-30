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

/*$arrstaff = array('19'=>'NOR','34'=>'QC','35'=>'AC','16'=>'CALLCENTER','12'=>'SCAN','18'=>'GRAPHIC','40'=>'site_area');// site งาน

$arr_tbl = array("monitor_keyin"=>"staffid","tbl_assign_sub"=>"staffid");
function CheckStaffLogin($staffid){
		global $dbnameuse,$arr_tbl;
		$num_staff = 0;
		if(count($arr_tbl) > 0){
			foreach($arr_tbl as $key => $val){
					$sql = "SELECT COUNT($val) as num1 FROM $key WHERE $val='$staffid'";
					$result = mysql_db_query($dbnameuse,$sql);
					$rs = mysql_fetch_assoc($result);
					$arr_keytbl[$key] = intval($rs[num1]);
			}//end foreach($arr_tbl as $key => $val){	
		}//end if(count($arr_tbl) > 0){
		return $arr_keytbl;
}//end function CheckStaffLogin(){
	
	
	


if($action == "process"){
	mysql_db_query($dbnameuse,"DELETE FROM temp_delete_userkeyin");
		$sql = "SELECT Count(card_id) AS num1, keystaff.card_id, keystaff.staffname, keystaff.staffsurname, keystaff.staffid FROM `keystaff` WHERE  sapphireoffice='0' and period_time='am' and card_id <> '' GROUP BY card_id HAVING num1 > 1 ORDER BY num1 DESC";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$sql1 = "SELECT staffid FROM keystaff WHERE card_id='$rs[card_id]' AND  sapphireoffice='0' AND  period_time='am'  ";
				$result1 = mysql_db_query($dbnameuse,$sql1);
				while($rs1 = mysql_fetch_assoc($result1)){
					$arrkeytbl= CheckStaffLogin($rs1[staffid]);
					$sql_save  = "REPLACE INTO temp_delete_userkeyin SET staffid='$rs1[staffid]',card_id='$rs[card_id]',monitor_status='".$arrkeytbl['monitor_keyin']."',assign_status='".$arrkeytbl['tbl_assign_sub']."'";
					mysql_db_query($dbnameuse,$sql_save);

				}//end while($rs1 = mysql_fetch_assoc($result1)){
		}//end while($rs = mysql_fetch_assoc($result)){
}//end if($action == "process"){




if($action == "delete"){
	$sql = "SELECT * FROM temp_delete_userkeyin WHERE monitor_status='0' and assign_status='0'";
	$result = mysql_db_query($dbnameuse,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		$i++;
			$sql_del = "DELETE FROM keystaff WHERE staffid='$rs[staffid]'";
			echo "$i::$sql_del<br>";
			mysql_db_query($dbnameuse,$sql_del);
	}//end while($rs = mysql_fetch_assoc($result)){
}//end if($action == "delete"){


*/

if($action == "update"){
	$sql = "SELECT staffid,staffname,staffsurname FROM  keystaff WHERE card_id='' or card_id IS NULL ";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		ConHost($host_face,$user_face,$pass_face); // connect faceaccess
		$sql_face = "SELECT pin FROM faceacc_officer WHERE firstname LIKE '%".trim($rs[staffname])."%' AND surname LIKE '%".trim($rs[staffsurname])."%' and pin <> '' ";
		echo $sql_face."<br><hr>";
		$result_face = mysql_db_query($dbface,$sql_face);
		$rsf = mysql_fetch_assoc($result_face);
		if($rsf[pin] != ""){
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
				$sql_update = "UPDATE keystaff SET card_id='$rsf[pin]' WHERE staffid='$rs[staffid]'";
				echo "$sql_update<br>";
		}
			
	}//end while($rs = mysql_fetch_assoc($result)){
		
}// end if($action == "update"){


echo "<a href='?action=update'>process</a>";


/*function GetStaffFace($pin,$date_start,$xtype=""){
	global $dbface,$dbnameuse,$host_face,$user_face,$pass_face;
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
t1.surname_eng
FROM faceacc_officer as t1 left join tbl_prename as t2 ON t1.prename=t2.id
left join faceacc_officer_to_status as t3 ON t1.officer_id=t3.officer_id
WHERE t1.pin='$pin'";
	$result = mysql_db_query($dbface,$sql) or die(mysql_error());
	$rs = mysql_fetch_assoc($result);
	if($rs[pin] != ""){
		ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
		if($xtype == "in"){
				$sub_user = $rs[firstname_eng].".".substr($rs[surname_eng],0,3);
			$sql_insert_staff= "INSERT INTO keystaff SET prename='$rs[prename_th]',staffname='$rs[firstname]',staffsurname='$rs[surname]',card_id='$rs[pin]',status_permit='YES',email='$rs[email]',username='$sub_user',password='logon',telno='$rs[phone_number]',status_extra='".$arrstaff[office]."',sapphireoffice='0',engname='$rs[firstname_eng]',engsurname='$rs[surname_eng]'";
			mysql_db_query($dbnameuse,$sql_insert_staff);
		}else if($xtype == "out" and  $rs[status_id] != "1"){

			$sql_update_staff	 = "UPDATE keystaff SET retire_date='$date_start' WHERE card_id='$pin' ";
			mysql_db_query($dbnameuse,$sql_update_staff);
		}else if($xtype == "turn_back"){
			$sql_return_staff = "UPDATE keystaff SET status_permit='YES',retire_date='$date_start' WHERE card_id='$pin'";
			mysql_db_query($dbnameuse,$sql_return_staff);
		}//end 	if($xtype == "in"){
			
	}//end if($rs[pid] != ""){
	
}//end function GetStaffFace(){
	
	
#####################  proces #########################3

if($_SERVER['REQUEST_METHOD'] == "GET"){
	GetStaffFace($pin,$date_start,$xtype);  //  in คือ พนักงานเข้างานใหม่ out คือ พนักงานที่ออกงาน
	echo "<script>location.href='$url';</script>";
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){
*/	

?>