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
session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
if($action == "run"){			
			$sql = "SELECT point_nnn.staffid, point_nnn.datekeyin,
point_nnn.point,
stat_user_keyin.datekeyin,
stat_user_keyin.staffid,
stat_user_keyin.numkpoint
FROM
point_nnn
Inner Join stat_user_keyin ON point_nnn.datekeyin = stat_user_keyin.datekeyin AND point_nnn.staffid = stat_user_keyin.staffid";
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if($rs[point] > $rs[numkpoint]){ // กรณีค่ารายคนมากกว่าการประมวลผลรวมให้เข้ารายคนมา update
				$i++;
					$sql_update = "UPDATE stat_user_keyin SET numkpoint='$rs[point]' WHERE staffid='$rs[staffid]' AND datekeyin='$rs[datekeyin]'";
					mysql_db_query($dbnameuse,$sql_update);
					echo " $rs[point]  ::  $rs[numkpoint]  => $sql_update<br>";
						
				}// end if($rs[point] > $numkpoint){
			
				
		}//end while($rs = mysql_fetch_assoc($result)){
			echo "จำนวนรายการ  $i  รายการ";
}//end if($action == "run"){		

echo "<a href='?action=run'>ประมวลผล</a>";

?>