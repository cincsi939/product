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
#DateCreate::29/07/2011
#LastUpdate::29/07/2011
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			
			$time_start = getmicrotime();

	function  UpdateSiteStaff($ptime=""){
		global $host_face,$user_face,$pass_face,$dbnameuse,$dbface;
		ConHost($host_face,$user_face,$pass_face); // connect faceaccess	
		if($ptime == "pm"){
			$conup = " and (hour(t2.start_work) = '18')";	
			$period_time = "pm";
		}else{
			$conup = " and (hour(t2.start_work) = '09' or hour(t2.start_work) = '08')";	
			$period_time = "am";
		}
		$sql = "SELECT
t1.site_id,
t1.pin
FROM
faceacc_officer as t1
Inner Join faceacc_site as t2 ON t1.site_id = t2.site_id
where t2.site_parent='62' $conup";
//echo $sql."<br>";
		$result = mysql_db_query($dbface,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$sql_update = "UPDATE keystaff SET site_id='$rs[site_id]' WHERE card_id='$rs[pin]' AND period_time='$period_time'";
			mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
				
		}//end while($rs = mysql_fetch_assoc($result)){
	}// end 	function  UpdateSiteStaff(){
		
	UpdateSiteStaff("am");
	UpdateSiteStaff("pm");


##  end เขียนข้อมูลใส่ใน ranking 
$time_end = getmicrotime();
echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
 writetime2db($time_start,$time_end);




 echo "<h1>Done...................";
 ?>