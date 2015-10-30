<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
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

set_time_limit(0);
require_once("../../../config/conndb_nonsession.inc.php");
$mm1 = "06";
			
			$sql = "SELECT
t1.staffid,
t1.keyin_group,
t1.rpoint,
min(t1.datekeyin) as  date_start,
max(t1.datekeyin) as date_end
FROM stat_user_keyin as t1
where t1.datekeyin LIKE  '2011-06%' and  t1.keyin_group='3' and t1.rpoint='20'
group by t1.staffid
having date_end = '2011-06-30'  ";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error().__LINE__);
			while($rs = mysql_fetch_assoc($result)){
	
					$sql_replace = "REPLACE INTO keystaff_history SET staff_yy='".date("Y")."',staff_mm='$mm1',staffid='$rs[staffid]',group_id='3',ratio_id='3',date_start='$rs[date_start]',date_end='$rs[date_end]'";
					echo $sql_replace."<br>";
					mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE__".__LINE__);
					
			}//end while($rs = mysql_fetch_assoc($result)){
				
	echo "Done...";
			
?>

