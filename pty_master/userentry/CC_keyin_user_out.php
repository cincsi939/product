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
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
			$arrstaff = array('19'=>'NOR','34'=>'QC','35'=>'AC','16'=>'CALLCENTER','12'=>'SCAN','18'=>'GRAPHIC','40'=>'site_area');// site งาน
			$arr_pin = GetStaffOut();// เลขบัตรพนักงานที่ออกไแล้ว
			$arr_pinin = GetStaffIn();// การเข้างาน

			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			if(count($arr_pin) > 0){
					foreach($arr_pin as $key => $val){
						$sql_up = "UPDATE keystaff SET status_permit='NO',retire_date='$val'  WHERE card_id='$key' and sapphireoffice <> '2'";
						//echo "$sql_up<br>";	
						mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
					}// end foreach($arr_pin as $key => $val){
			}// end if(count($arr_pin) > 0){

		
		
		if(count($arr_pinin) > 0){
						foreach($arr_pinin as $key => $val){

						$sql_up = "UPDATE keystaff SET status_permit='YES',start_date='$val'  WHERE card_id='$key' ";
						//echo "$sql_up<br>";	
						mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
					}// end foreach($arr_pin as $key => $val){

		}

 echo "<h1>Done...................";
 ?>