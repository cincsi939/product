<?
session_start();
include("checklist2.inc.php");

function change_datex($temp_date){
	if($temp_date != ""){
		$arr = explode("-",$temp_date);
		$result = ($arr[0]+543)."-".$arr[1]."-".$arr[2];
	}
	return $result;
}//function change_datex($temp_date){

$sql ="SELECT idcard, profile_id,birthday,begindate FROM `tbl_checklist_kp7` where year(birthday) < 2000 and birthday <> '0000-00-00' and birthday <> '' and birthday IS NOT NULL ";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_update = "UPDATE tbl_checklist_kp7 SET birthday='".change_datex($rs[birthday])."',begindate='".change_datex($rs[begindate])."' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
	mysql_db_query($dbname_temp,$sql_update);
	echo $sql_update."<br>";
	
		
}//end while($rs = mysql_fetch_assoc($result)){

?>