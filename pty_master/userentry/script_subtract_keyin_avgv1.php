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
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$dbnameuse = $db_name;
			$xdatekey = "2010-03";
			
			$sql_avg = "SELECT * FROM stat_subtract_keyin  WHERE datekey LIKE '$xdatekey%' ORDER BY datekey ASC ";
			$result_avg = mysql_db_query($dbnameuse,$sql_avg);
			while($rsa = mysql_fetch_assoc($result_avg)){
				if($rsa[spoint] == 0 or $rsa[spoint] == ""){ $spoint = intval($rsa[spoint]);}else{ $spoint = $rsa[spoint];}
				$arrd1 = ShowSdateEdate($rsa[datekey]);
				$xsdate = $arrd1['start_date'];
				$xedate = $arrd1['end_date'];
				$sql_save = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p,sdate,edate) VALUES('$rsa[staffid]','$rsa[datekey]','$spoint','1','$xsdate','$xedate')";
				//echo $sql_save."<br>";
				mysql_db_query($dbnameuse,$sql_save);
			}//end while($rsa = mysql_fetch_assoc($result_avg)){
echo "<center><h3>ประมวลผลเพื่อหาค่าเฉลี่ยเรียบร้อยแล้ว</h3></center>";
?>