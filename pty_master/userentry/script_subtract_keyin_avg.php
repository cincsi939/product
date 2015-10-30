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
			
			$sql = "SELECT * FROM stat_subtract_keyin  WHERE datekey LIKE '2010-03%' ORDER BY staffid ASC";
			$result = mysql_db_query($dbnameuse,$sql);
			while($rs = mysql_fetch_assoc($result)){
				
					CheckQC_Per_Week($rs[staffid],$rs[datekey]);
					
			}//end while($rs = mysql_fetch_assoc($result)){ 
echo "<center><h3>ประมวลผลเพื่อหาค่าเฉลี่ยเรียบร้อยแล้ว</h3></center>";
?>