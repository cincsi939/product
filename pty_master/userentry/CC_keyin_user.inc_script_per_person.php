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
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
	$sql = "SELECT 
count(staffid) as nump,
datekeyin,
sum(numpoint) as point,
 sum(numkeyin) as point_key,
staffid  
FROM stat_user_keyperson  
where  datekeyin='2010-08-17'  group by staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
	$sql_up = "UPDATE stat_user_keyin SET numperson='$rs[nump]',numkeyin='$rs[point_key]',numkpoint='$rs[point]'  WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]'";	
	mysql_db_query($dbnameuse,$sql_up);
	echo "$dbnameuse :: $sql_up<br>";
		
	}//end while($rs = mysql_fetch_assoc($result)){
			


 ?>