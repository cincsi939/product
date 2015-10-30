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
			include ("epm.inc.php");
			
			$sql = "SELECT * FROM k_atemp_point";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					$sql1 = "SELECT * FROM monitor_keyin WHERE staffid='$rs[staffid]' AND date(timeupdate) between '2011-06-01' and '2011-06-30'";
					$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."".__LINE__);
					while($rs1 = mysql_fetch_assoc($result1)){
						$dbsite = STR_PREFIX_DB.$rs1[siteid];
						$sql2 = "SELECT hour(t1.updatetime) as H,
count(t1.username) as numkey
FROM  log_update as t1
where date(t1.updatetime) between '2011-06-01' and '2011-06-30' and t1.staff_login='$rs[staffid]'
group by hour(t1.updatetime)";
						$result2 = mysql_db_query($dbsite,$sql2);
						while($rs2 = mysql_fetch_assoc($result2)){
								$arr[$rs[staffid]][$rs2[H]] = $arr[$rs[staffid]][$rs2[H]]+$rs2[numkey];
						}//end while($rs2 = mysql_fetch_assoc($result2)){
					}//end while($rs1 = mysql_fetch_assoc($result1)){
			}//end while($rs = mysql_fetch_assoc($result)){
				
				
			if(count($arr) > 0){
				foreach($arr as $key => $val){
					foreach($val as $k => $v){
						$sql_insert = "REPLACE INTO k_atemp_point_detail SET staffid='$key' ,Houre1='$k',numkey='$v'";
						mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
							//echo $sql_insert."<br>";
					}
						
				}// end foreach($arr as $key => $val){
					
			}//end if(count($arr) > 0){
			
	//	echo "<pre>";	
		//print_r($arr);
	



 echo "<h1>Done...................";
 ?>