
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
			
			$dbnameuse = $db_name;

$str = " SELECT 
stat_user_keyin.staffid, 
max(stat_user_keyin.numkpoint) as maxp, 
max(stat_user_keyin.numkpoint/8.5) as avgpoing,
max((stat_user_keyin.numkpoint/8.5)*4) as point_add
FROM `stat_user_keyin`
where datekeyin LIKE '2010-07%' 
AND stat_user_keyin.staffid IN('10015','10028','10127','10128','10237','10273','10277','10319','10333','10351','10360','10378','10490','10493','10501','10523','10531','10532','10538','10543','10544','10547','10548','10558','10562','10570','10599','10614','10631','10648','10649','10666','10677','10690','10699','10767','10810','10836','10872','10874','10880','10916','10930','10944','10945','10952')
group by stat_user_keyin.staffid";
//echo $str;
$results = mysql_db_query($dbnameuse,$str);
while($rss  = mysql_fetch_assoc($results)){
$j++;
$maxp = CutNumberPoint($rss[maxp]);
$maxavg = CutNumberPoint($maxp/8.5);
$pointadd = ($maxavg*4)+$maxp;
//echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
//  <tr>
//    <td align='left'>". ShowStaffOffice($rss[staffid])."</td>
//	 <td align='left'>".CutNumberPoint($maxp)."</td>
//	  <td align='left'>".CutNumberPoint($maxavg)."</td>
//	  <td align='left'>".CutNumberPoint($pointadd)."</td>
//  </tr>
//</table>";
	
	$sql_insert = "UPDATE stat_user_keyin SET numkpoint='".CutNumberPoint($pointadd)."'  WHERE staffid='$rss[staffid]' AND datekeyin='2010-08-17'";
	echo $sql_insert."<br>";
	mysql_db_query($dbnameuse,$sql_insert);
	
}//end 




 echo "<h1>Done...................";
 ?>