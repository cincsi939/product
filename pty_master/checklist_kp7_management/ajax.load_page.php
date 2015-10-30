<?php
###################################################################
## POLICY TIMELINE STAT 
###################################################################
## Version :		20100407.001 (Created/Modified; Date.RunNumber)
## Created Date :		2010-04-07 10:09
## Created By :		Mr.KIDSANA PANYA (JENG)
## E-mail :			kidsana@sapphire.co.th
## Tel. :			084-0558131
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
session_start(); 
include ("../../config/conndb_nonsession.inc.php");
include ("../../common/system.inc.php");
header("Content-Type: text/html; charset=windows-874");

### เรียกใช้ Class CPULoad
$cpuload = new CPULoad();
$cpuload->get_load();

/*
ฟังชั่น: คำนวณ ชั่วโมง, นาที, วินาที
*/
function getTimeFormat($timeProcess = ""){
	$difference = $timeProcess;
	$diff = floor($difference / 84600);
    $difference -= 84600 * floor($difference / 84600);		#	คำนวณจำนวน ชม. ที่เกิน 24 ให้เป็นจำนวนวัน
    $array['diff_day'] = $diff;
    #$diff .= ' days, ';
    $diff = "";
	#	คำนวณ ชม.
    $diff .= sprintf("%01d", floor($difference / 3600));        
    $difference -= 3600 * floor($difference / 3600);
    $diff .= " ชั่วโมง ";
	#	คำนวณ นาที
    $diff .= sprintf("%01d", floor($difference / 60));			
    $difference -= 60 * floor($difference / 60);
	$diff .= " นาที ";
	#	คำนวณวินาที
    $diff .= sprintf("%01d", $difference);	
	$diff .= " วินาที ";
    $array['diff_time'] = $diff;
	#return $diff;
	return $diff;
}

function bandwidth(){
	$exec = shell_exec("/etc/munin/plugins/if_eth0");
	$arrBW = explode("\n",$exec);
	$downValue = trim(str_replace("down.value","",$arrBW[0]));
	$upValue = trim(str_replace("up.value","",$arrBW[1]));
	$arrBandwidth = array("down"=>$downValue,"up"=>$upValue);
	return  $arrBandwidth;
}

//$bandwidth = bandwidth();
//echo "Down:".getSize($bandwidth['down'])."-Up:".getSize($bandwidth['up']);

#Begin จำนวนพื้นที่ทั้งที่ทำการสำรองข้อมูล
//$sql_SelectQueueNumAll = "  SELECT count(queue_id) AS countSiteID FROM `pts_queue_process` WHERE  queue_profile_id='".$_GET['profile_id']."' ";
//
//$Query_SelectQueueNumAll = mysql_db_query('cmss_pts',$sql_SelectQueueNumAll);
//$RowNumAll = mysql_fetch_assoc($Query_SelectQueueNumAll);
#GET DATA[1]
//echo $RowNumAll['countSiteID'].",";//แสดงผล
//$x1= 2;
//echo $x1.",";
#End จำนวนพื้นที่ทั้งที่ทำการสำรองข้อมูล

#Begin จำนวนพื้นที่เกิดข้อมูลผิดพาด
//$sql_SelectQueueNumError = " SELECT
//					cmss_pts.pts_log_timeline_stat.siteid,
//					count(cmss_pts.pts_log_timeline_stat.table_name) AS countTable,
//					edubkk_master.eduarea.secname
//					FROM
//					cmss_pts.pts_log_timeline_stat
//					Inner Join edubkk_master.eduarea ON edubkk_master.eduarea.secid = cmss_pts.pts_log_timeline_stat.siteid WHERE pts_log_timeline_stat.profile_id='".$_GET['profile_id']."' AND status_id <> '1' AND pts_log_timeline_stat.profile_status_id IN( SELECT MAX(pts_log_timeline_stat.profile_status_id) FROM pts_log_timeline_stat WHERE pts_log_timeline_stat.profile_id='".$_GET['profile_id']."' )  AND pts_log_timeline_stat.profile_status_id IN(SELECT MAX(pts_profile_status.status_id) FROM pts_profile_status WHERE pts_profile_status.profile_id='".$_GET['profile_id']."' AND ( profile_status='Play' OR  profile_status='Replay'  OR  profile_status='Resume'  ) ) GROUP BY pts_log_timeline_stat.siteid HAVING countTable >= 1 ";
//$Query_SelectQueueNumError = mysql_db_query('cmss_pts',$sql_SelectQueueNumError);
//$RowNumError = mysql_num_rows($Query_SelectQueueNumError);
#GET DATA[2]
//echo $RowNumError.",";//แสดงผล
#End จำนวนพื้นที่เกิดข้อมูลผิดพาด

#Begin จำนวนพื้นที่ที่สำรองข้อมูลเสร็จแล้ว
$sql_SelectQueueNumForce = " SELECT count(queue_id) AS countSiteID FROM `pts_queue_process` WHERE `queue_status` = 'Finish' AND queue_profile_id='".$_GET['profile_id']."' ";
$Query_SelectQueueNumForce = mysql_db_query('cmss_pts',$sql_SelectQueueNumForce);
$RowNumForce = mysql_fetch_assoc($Query_SelectQueueNumForce);
#GET DATA[3]
//echo $RowNumForce['countSiteID'].",";

//echo "100,";
#End จำนวนพื้นที่ที่สำรองข้อมูลเสร็จแล้ว

#Begin จำนวนพื้นที่ที่ยังไม่ได้สำรองข้อมูล
//echo $RowNumAll['countSiteID']-$RowNumForce['countSiteID'].",";
#GET DATA[4]
#End จำนวนพื้นที่ที่ยังไม่ได้สำรองข้อมูล
$sql_page = "SELECT TIMESTAMPDIFF(SECOND,'start_time','end_time') as difftime_e, TIMESTAMPDIFF(SECOND,'start_time','m_time') as difftime_m, start_time,m_time,end_time FROM tbl_temp_profile  WHERE profile_id='".$_GET['profile_id']."' AND page_load='2'";
echo $sql_page;
$result_page = mysql_db_query(DB_CHECKLIST,$sql_page);
$rsp = mysql_fetch_assoc($result_page);
echo "$rsp[difftime_e],";
echo "0,";
echo "$rsp[difftime_m],";
echo "0,";






#Begin แสดงเวลาที่ใช้งาน
$sql_SelectTimeQueue = "SELECT * FROM pts_queue_process WHERE queue_profile_id='".$_GET['profile_id']."' ";
$Query_SelectTimeQueue = mysql_db_query('cmss_pts',$sql_SelectTimeQueue);
$timeWork = 0;
$IntQueueAll = 0;
$IntQueueFinish = 0;
while($RowTime = mysql_fetch_assoc($Query_SelectTimeQueue)){
	$IntQueueAll++;
	if($RowTime['queue_status']=="Finish"){
		$IntQueueFinish++;
		$timeWork += ($RowTime['queue_time_process']/$IntQueueFinish);  //รวมเวลาที่ทำงานจริง
	}
}
$avgTime = 0;
@$avgTime = $timeWork/$IntQueueFinish;
$mkTimeRunAll = $IntQueueAll*$avgTime;//ใช้ทั้งหมด
$mkTimeRun = ($IntQueueAll-$IntQueueFinish)*$avgTime;//เหลือเวลา
$setTimeRunAll = ($mkTimeRunAll != '')?getTimeFormat($mkTimeRunAll):"-";
$setTimeWork = ($timeWork != '')?getTimeFormat($timeWork):"-";
$setTimeRun = ($mkTimeRun != '')?getTimeFormat($mkTimeRun):(($mkTimeRunAll != '' && $timeWork != '')?"0":"-");
echo "เวลาที่ต้องใช้ทั้งหมด ".$setTimeRunAll." (เวลาที่ผ่านไป ".$setTimeWork.")(เวลาที่เหลือ ".$setTimeRun.") ,";
#GET DATA[4]
#End แสดงเวลาที่ใช้งาน

#Begin แสดงสถานะล่าสุดของโปรไฟล์
$sql_profile_status = "SELECT profile_status from cmss_pts.pts_profile_status WHERE profile_id='".$_GET['profile_id']."' ORDER BY status_id DESC LIMIT 0,1 ";
$Query_profile_status = mysql_db_query('cmss_pts',$sql_profile_status);
$Row_profile_status = mysql_fetch_assoc($Query_profile_status);
echo $Row_profile_status['profile_status'].",";
#GET DATA[5]
#End แสดงสถานะล่าสุดของโปรไฟล์

#Begin CPU Usage
$resultcpu =  number_format($cpuload->load["cpu"],2);
#GET DATA[6]
echo $resultcpu.",";
#End CPU Usage

#Begin Memory Usage
$resultmemory = get_memory() ;
#GET DATA[7]
echo $resultmemory.",";
#End Memory Usage

#Begin HDD Usage
$partition = "/";
$totalSpace = disk_total_space($partition) / 1048576;
$usedSpace = $totalSpace - disk_free_space($partition) / 1048576;
$totalSpace = number_format(($totalSpace/1024),2);
$usedSpace = number_format(($usedSpace/1024),2);
$resulthdd = number_format((($usedSpace/$totalSpace)*100),2);
#GET DATA[8]
echo $resulthdd.",";
#End HDD Usage

#Begin comfig_system
$sql_get_config = "SELECT * FROM pts_comfig_system ORDER BY create_date DESC LIMIT 1 ";
$Query_get_config = mysql_db_query('cmss_pts', $sql_get_config) or die (mysql_error());
$rowConfig = mysql_fetch_assoc($Query_get_config);
#GET DATA[9] Cpu Usage Comfig
echo $rowConfig['cpu_max'].",";
#GET DATA[10] Memory Usage Comfig
echo $rowConfig['memory_max'].",";
#GET DATA[11] HDD Usage Comfig
echo $rowConfig['harddisk_max'].",";
#GET DATA[12] Bandwidth_support Comfig
echo $rowConfig['bandwidth_support']."";
#End  comfig_system
?>
