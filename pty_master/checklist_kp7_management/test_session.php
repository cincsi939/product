<?
include("checklist2.inc.php");
##########  เก็บตัวแปร session ไว้ในตาราง
function AddSessoinVariable(){
	global $cmssdatabase,$ApplicationName,$dbnamemaster;
	$arr_session = array();
	session_start();
	$serverip = $_SERVER['SERVER_NAME'];
	$file_name = basename($_SERVER['PHP_SELF']);
	$arr_session = $_SESSION;
	if(count($arr_session) > 0){
		foreach($arr_session as $key => $val){
			$sql_save = "REPLACE INTO temp_session_variable SET session_name='$key',session_val='$val',appname='$ApplicationName',filename='$file_name',server_ip='$serverip'";
			echo $sql_save."<br>";
			mysql_db_query($dbnamemaster,$sql_save);				
		}
	}//end 	if(count($arr_session) > 0){
		
}//end function AddSessoinVariable(){
	
	AddSessoinVariable();

?>