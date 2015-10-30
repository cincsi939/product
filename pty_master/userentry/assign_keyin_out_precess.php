DB_CHECKLIST<?php
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
die;
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
<center><strong>ใบงานที่มอบหมายงาน (30 ชุดขึ้นไป)</strong></center>
<?php
	$sql_assignTicket = "SELECT
				COUNT(tbl_assign_key.idcard) AS num1,
				tbl_assign_sub.staffid,
				tbl_assign_sub.ticketid
				FROM
				tbl_assign_sub
				Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
				WHERE tbl_assign_key.profile_id >= '4'
				AND tbl_assign_sub.ticketid  IN('TK-255401310913130124789','TK-255401310915140124567','TK-255401310916220125789','TK-255401310933150135789','TK-255401311312460135678','TK-255401311315541234679','TK-255401311317181234789','TK-255401311319090123568','TK-255401311319182345789','TK-255401311320090134679','TK-255401311323130123457','TK-255401311323290234789','TK-255401311324590124569','TK-255401311325030123579','TK-255401311326060234689','TK-255401311326450123579','TK-255401311327020123579','TK-255401311329020124569','TK-255401311329391234567','TK-255401311330121346789','TK-255401311331080123456','TK-255401311331170146789','TK-255401311332051234569','TK-255401311333002345678','TK-255401311333022346789','TK-255401311333502345789','TK-255401311334430123468','TK-255401311335050256789','TK-255401311336100345789','TK-255401311337190123456','TK-255401311338340123578','TK-255401311339330123578','TK-255401311340280134568','TK-255401311342130245678','TK-255401311343370235678','TK-255401311344590135789','TK-255401311345440123567','TK-255401311400010125678','TK-255401311407101346789','TK-255401311409230234678','TK-255401311410400245679','TK-255401311414171234589','TK-255401311419350134567','TK-255401311425400256789','TK-255401311428350123489','TK-255401311430470135689','TK-255401311433050134789','TK-255401311438352346789','TK-255401311441410356789','TK-255401311444561245689','TK-255401311449451245689','TK-255401311452302356789','TK-255401311453451356789','TK-255401311455051236789','TK-255401311456501456789','TK-255401311458341234789','TK-255401311501261345679','TK-255401311507120345678','TK-255401311510130235678','TK-255401311517390124567','TK-255401311519171256789','TK-255401311521311234678','TK-255401311523080134568','TK-255401311536052345678','TK-255401311538122345678','TK-255401311539420123457','TK-255401311545200234689','TK-255401311547490124589','TK-255401311549291345689','TK-255401311556181234579','TK-255401311558140123569','TK-255401311559570234567','TK-255401311602230234579','TK-255401311604420123478','TK-255401311607061235789','TK-255401311610070256789','TK-255401311612151234689','TK-255401311613410246789','TK-255401311615310234789','TK-255401311616561236789','TK-255401311618292345789','TK-255401311622010235678','TK-255401311624440123458','TK-255401311626520135678','TK-255401311628470156789','TK-255401311630170245689','TK-255401311631451346789','TK-255401311637591245789','TK-255401311640110124578','TK-255401311644070123459','TK-255401311715000145689','TK-255401311720270126789','TK-255402011505170235678')
				GROUP BY tbl_assign_sub.ticketid
				
				ORDER BY  num1 DESC 
				";
				
/*					AND 
				tbl_assign_sub.ticketid IN('TK-255401311519171256789','TK-255401311425400256789','TK-255401311419350134567','TK-255401311433050134789','TK-255401311430470135689','TK-255401311444561245689','TK-255401311140540124679','TK-255401311547490124589','TK-255401311549291345689','TK-255401311456501456789','TK-255401311521311234678','TK-255401311523080134568','TK-255401311559570234567','TK-255401311501261345679','TK-255401311507120345678','TK-255401311628470156789','TK-255401311337190123456','TK-255401311324590124569','TK-255401311312460135678','TK-255401311317181234789','TK-255401311315541234679','TK-255401311331080123456','TK-255402011505170235678','TK-255401311329391234567','TK-255401311331170146789','TK-255401311319182345789','TK-255401311338340123578')
*/		

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
					if(($cal_ticketOut<$keyAVG || $cal_ticketbefore<$keyAVG) and $i < 30){
						echo "<span style='color:#FF0000;'>$i: ".$val." (".$cal_ticketOut.")</span><br/>";
					}else{
						echo "$i: ".$val."<br/>";
						$sql_insert = "REPLACE INTO assign_keyin_out SET ticketid='".$row_assignTicket['ticketid']."', idcard='".$idcard."', staffid='".$row_assignTicket['staffid']."' ";
						echo "$dbname_edubkk_userentry ::".$sql_insert."";
						//mysql_db_query($dbname_edubkk_userentry, $sql_insert);
						echo "<br/>";
						 $sql_del = "DELETE FROM tbl_assign_key WHERE ticketid='".$row_assignTicket['ticketid']."' AND idcard='".$idcard."' ";
						 $sql_del2 = "DELETE FROM tbl_checklist_assign_detail WHERE ticketid='".$row_assignTicket['ticketid']."' AND idcard='".$idcard."' "; 
						// mysql_db_query("edubkk_checklist",$sql_del2);
						 echo $sql_del;
						//mysql_db_query($dbname_edubkk_userentry, $sql_del);
						echo "<br/>";
					}
				}
			}
			echo "<hr/>";
		}		
?>
</html>