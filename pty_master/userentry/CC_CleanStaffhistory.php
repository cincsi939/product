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

			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm_report.inc.php")  ;
			include("function_face2cmss.php");
			include("function_date.php");
			include("function_get_data.php");
			
			
			$sql = "SELECT staffid FROM keystaff WHERE keyin_group in('2','3')  AND  period_time='am' and status_extra='NOR' and sapphireoffice='0' AND status_permit='YES'  ";
			$result = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
				$sql1 = "SELECT count(*) as num1, concat(staff_yy,staff_mm) as yymm,staff_yy,staff_mm,staffid FROM `keystaff_history` where staffid='$rs[staffid]'  group by yymm having num1 > 1";
				$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
				$rs1 = mysql_fetch_assoc($result1);
				if($rs1[staffid] != ""){
				$sql2 = "SELECT * FROM keystaff_history WHERE staffid='$rs[staffid]' AND staff_yy='$rs1[staff_yy]' and staff_mm='$rs1[staff_mm]' ORDER BY group_id desc LIMIT 1";
				$result2 = mysql_db_query($dbnameuse,$sql2);
				$rs2 = mysql_fetch_assoc($result2);
				
				######## ทำการลบข้อมูล
				$sql_del = "DELETE FROM keystaff_history WHERE staffid='$rs2[staffid]' AND staff_yy='$rs2[staff_yy]' AND staff_mm='$rs2[staff_mm]' AND group_id='$rs2[group_id]' ";
				mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
				#echo $sql_del."<br>";
				
				}
				
				
			}//end 	while($rs = mysql_fetch_assoc($result)){
			
?>