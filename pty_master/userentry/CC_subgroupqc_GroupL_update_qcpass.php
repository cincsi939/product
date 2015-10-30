<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");

function NextDate($date){
	$xbasedate = strtotime("$date");
	 $xday = strtotime("$date +1 days",$xbasedate);
	 $daynex = date("Y-m-d",$xday);// เดือนก่อนหน้านี้	
	 return $daynex;
	
}// end function NextDate($date){

echo "nextday".NextDate("2011-04-01");

		
		$yymm = "2011-01";
				$xbasedate = strtotime("$yymm");
				 $xdate = strtotime("$yymm -1 month",$xbasedate);
				 $xsdate = date("Y-m",$xdate);// วันถัดไป
				 echo "month :: ".$xsdate;

		die();
		
function UpdateQcPass($staffid,$yymm){
	global $dbnameuse;
	$month = date("Y-m");
	$sql = "SELECT * FROM `stat_user_person_temp` where dateqc LIKE '$yymm%' and num_doc='20' and qc_pass='0'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT COUNT(*) as num1  FROM `stat_user_keyperson` WHERE `flag_qc` = '$rs[flag_id]' AND `staffid` = '$rs[staffid]'  AND status_random_qc='1' ";
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			if($rs1[num1] > 0){
					$sql_up = "UPDATE  stat_user_person_temp SET qc_pass='1' WHERE flag_id='$rs[flag_id]' AND staffid='$rs[staffid]'";
					//echo $rs[dateqc]." => ".$sql_up."<br>";
					$result_up = mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
			}//end if($rs1[num1] > 0){
	}//end while($rs = mysql_fetch_assoc($result)){

}// end function UpdateQcPass(){
	


?>