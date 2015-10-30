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
			include ("function_startwork.php");
			
		//echo $dbnameuse."<br>";
				$sql = "SELECT
keystaff.staffid,
keystaff.card_id,
keystaff.period_time,
keystaff_group.groupname,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff_group.groupkey_id
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id  where status_permit='YES'";
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
					if($rs[period_time] == "am"){
							$PT = "F";
					}else{
							$PT = "P";	
					}
						
						$start_work = getStartWork("$rs[card_id]","$PT");
						ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
						 if($start_work == "No Work Here !!"){
							$sql_s = "SELECT MIN(datekeyin) AS mindate FROM `stat_user_keyin` WHERE  staffid='$rs[staffid]' and datekeyin <> '0000-00-00' group by staffid "; 
							$result_s = mysql_db_query($dbnameuse,$sql_s) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
							$rss = mysql_fetch_assoc($result_s);
							$start_work = $rss[mindate];
						}//end  if($start_work == "No Work Here !!"){
					
						$datec = date("Y-m-d");			
					
					
					$sql_update = "UPDATE keystaff SET start_date='$start_work'  WHERE staffid='$rs[staffid]'";
					mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::"._LINE__);
					//echo $diffday."  ::: ".$sql_update."<br>";
					$conup = "";
					$diffday = 0;
						
				}//end 	while($rs = mysql_fetch_assoc($result)){




 echo "<h1>Done...................";
 ?>