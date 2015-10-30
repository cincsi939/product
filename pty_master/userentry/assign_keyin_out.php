<?php
	###################################################################
	## REPORT: ASSIGN KEY
	###################################################################
	## Version :			20110111.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2011-01-11 11:30
	## Created By :		Mr.KIDSANA PANYA(JENG)
	## E-mail :				kidsana@sapphire.co.th
	## Tel. :				-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
session_start();
include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");
$dbname_edubkk_userentry = DB_USERENTRY;
$arr_logExp = array();
function assignKeyinExperience($ticketid=""){
		global $dbname, $dbname_edubkk_userentry, $arr_logExp; 
		$sql_assign = "SELECT idcard FROM `tbl_assign_key` WHERE `ticketid` LIKE '".$ticketid."' ";
		$query_assign = mysql_db_query($dbname_edubkk_userentry, $sql_assign);
		while($row_assign= mysql_fetch_assoc($query_assign)){
			$sql_view_general = "
				SELECT 
				TIMESTAMPDIFF(YEAR,date( concat(  CAST( substring(  begindate,1,4) as UNSIGNED )-543,substring( begindate,5,10 ) ) ) ,NOW()  ) AS year_begindate 
				FROM view_general 
				WHERE CZ_ID='".$row_assign['idcard']."' ";
			$query_vg = mysql_db_query($dbname, $sql_view_general);
			$row_vg = mysql_fetch_assoc($query_vg);
			$calculateExperience = 16+($row_vg['year_begindate']*2.42);
			$arr_logExp[$ticketid][$row_assign['idcard']] = $calculateExperience;
			$calculateExperienceSum += $calculateExperience;
		}
		$calculateExperienceTag = $calculateExperienceSum+($calculateExperienceSum*5)/100;
		echo $str_cal = "คะแนนทั้งหมด : ".$calculateExperienceSum."  ค่าคะแนนบวก 5%:".$calculateExperienceTag."<br>";
		return $calculateExperienceTag;
}

function assignKeyinAVG($staffid=""){
	global $dbname_edubkk_userentry; 
	$date_start = date('Y-m-d', (strtotime("-1 month") ));
	$date_end = date('Y-m-d');
	$sql_avg = "
		SELECT AVG(numkpoint) AS pointavg, COUNT( keystaff.staffid) AS numday,SUM(numkpoint) AS pointall, keystaff.staffid
		FROM
		stat_user_keyin
		Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
		WHERE    (stat_user_keyin.datekeyin BETWEEN '".$date_start."'  AND  '".$date_end."') 
		AND keystaff.status_permit =  'YES' 
		AND keystaff.status_extra =  'NOR' 
		AND keystaff.period_time =  'am'
		AND keystaff.staffid='".$staffid."' 
		";
	$query_avg = mysql_db_query($dbname_edubkk_userentry, $sql_avg);
	$row_avg = mysql_fetch_assoc($query_avg);
	$calculateAVG = $row_avg['pointavg']*6;
	echo $str_cal = "ค่าเฉลี่ยต่อวัน: ".$row_avg['pointavg']." ค่าคะแนนกลาง: ".$calculateAVG."<br/>";
	return $calculateAVG;
}
?>
<html>
<head>
<title>ระบบบริหารจัดการมอบหมายงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body>
</body>
<center><strong>ใบงานที่มอบหมายงาน (25 ชุดขึ้นไป)</strong></center>
<?php
	$sql_assignTicket = "SELECT
				COUNT(tbl_assign_key.idcard) AS num1,
				tbl_assign_sub.staffid,
				tbl_assign_sub.ticketid
				FROM
				tbl_assign_sub
				Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
				WHERE tbl_assign_key.profile_id >= '4'
				GROUP BY tbl_assign_sub.ticketid
				HAVING num1 > 30
				ORDER BY  num1 DESC 
				";
		$query_assignTicket = mysql_db_query($dbname_edubkk_userentry, $sql_assignTicket);
		while($row_assignTicket = mysql_fetch_assoc($query_assignTicket)){
			unset($arr_logExp[$row_assignTicket['ticketid']] );
			echo "<strong>Staff ID:".$row_assignTicket['staffid']."</strong><br/>";
			$keyExp = assignKeyinExperience($row_assignTicket['ticketid']);
			$keyAVG = assignKeyinAVG($row_assignTicket['staffid']);
			$cal_rate = ($keyExp-$keyAVG);
			echo "Calculate Rate: <strong>".$cal_rate."</strong><br/>";
			arsort($arr_logExp[$row_assignTicket['ticketid']]);
			if($cal_rate > 0){
				$cal_ticketOut = 0;
				$i=0;
				foreach($arr_logExp[$row_assignTicket['ticketid']] as $idcard=>$val){
					$i++;
					$cal_ticketbefore = $cal_ticketOut;
					$cal_ticketOut+=$val;
					if($cal_ticketOut<$keyAVG || $cal_ticketbefore<$keyAVG){
						echo "<span style='color:#FF0000;'>$i: ".$val." (".$cal_ticketOut.")</span><br/>";
					}else{
						echo "$i: ".$val."<br/>";
						echo $sql_insert = "INSERT INTO assign_keyin_out SET ticketid='".$row_assignTicket['ticketid']."', idcard='".$idcard."', staffid='".$row_assignTicket['staffid']."' ";
						#mysql_query($dbname_edubkk_userentry, $sql_insert);
						echo "<br/>";
						echo $sql_del = "DELETE FORM tbl_assign_key WHERE ticketid='".$row_assignTicket['ticketid']."' AND idcard='".$idcard."' ";
						#mysql_query($dbname_edubkk_userentry, $sql_del);
						echo "<br/>";
					}
				}
			}
			echo "<hr/>";
		}		
?>
</html>