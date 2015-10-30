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
$yymm = date("Y-m");
			
			$sql = "SELECT
concat(year(t2.datekeyin),month(t2.datekeyin)) as yymm,
year(t2.datekeyin) as yy,
month(t2.datekeyin) as mm,
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.datekeyin,
min(t2.keyin_group) as mingroup,
min(t2.datekeyin) as date_start,
max(t2.datekeyin) as date_end,
t1.ratio_id as maxr
FROM
keystaff as t1
Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid
where t2.datekeyin LIKE '$yymm%' and (t2.keyin_group='2' or t2.keyin_group='3')
group by yymm,t1.staffid
order by yymm,t1.staffid";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error().__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					if($rs[mingroup] == "3"){
							if($rs[maxr] == "1"){
									$ratio_r = "1";
							}else if($rs[maxr] == "2"){
									$ratio_r = "2";
							}else{
									$ratio_r = "3";	
							}//end if($rs[mingroup] == "3"){
					}// if($rs[mingroup] == "3"){
						$mm1 = sprintf("%02d",$rs[mm]);
					$sql_replace = "REPLACE INTO keystaff_history SET staff_yy='$rs[yy]',staff_mm='$mm1',staffid='$rs[staffid]',group_id='$rs[mingroup]',ratio_id='$ratio_r',date_start='$rs[date_start]',date_end='$rs[date_end]'";
					//echo $sql_replace."<br>";
					mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE__".__LINE__);
					
			}//end while($rs = mysql_fetch_assoc($result)){
				
	echo "Done...";
			
?>

