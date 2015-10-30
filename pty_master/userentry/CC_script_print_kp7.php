<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/03/2011
#LastUpdate::29/03/2011
#DatabaseTable:tbl_person_print
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			include ("epm.inc.php");
			$ratio_n = 3; // อัตราส่วนของกลุ่ม N
			$ratio_l = 20;// อัตราส่วนของกลุ่ม N และกลุ่ม L
			
function GetDataPrint($yymm){
	global $dbnameuse,$ratio_n,$ratio_l;
	$sql = "SELECT flag_id, staffid  FROM  stat_user_person_temp WHERE dateqc LIKE '$yymm%' and qc_pass='0' and  (num_doc='$ratio_n' or num_doc='$ratio_l')";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			
	}// end 	while($rs = mysql_fetch_assoc($result)){
}//end function GetDataPrint($yymm){

			

 echo "<h1>Done...................";
 ?>