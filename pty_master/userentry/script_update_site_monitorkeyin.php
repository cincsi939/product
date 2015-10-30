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

			if($action == "process"){
				$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid LIKE '0%' ";
				//echo $sql." :: $db_temp";
				$result = mysql_db_query($db_temp,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					$sqlup = "UPDATE monitor_keyin SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]' and timeupdate LIKE '2010%'";
					$resultup = mysql_db_query($dbnameuse,$sqlup);
					//echo "$sqlup<br>";
					if($resultup){
					$i++;
					}
						
				}//end while($rs = mysql_db_query($result)){
				echo "จำนวนรายการ  $i  รายการ";
			}//end if($action == "process"){
			
	#############################  end การประมวลผลข้อมูล		
	echo "<br><a href='?action=process'>ประมวลผลข้อมูล</a> ";
	//echo "|| <a href='?action=CleanData'>ล้างข้อมูล</a>";

 ?>