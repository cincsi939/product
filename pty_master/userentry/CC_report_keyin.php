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
			include ("epm.inc.php")  ;
			$date_config = "2010-10-01";
			
			

			
			
			
			$dbnameuse = "edubkk_userentry";
			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");



	function GetMaxDate(){
		global $dbnameuse;
		$sql_max = "SELECT max(date(log_time_userkey.start_date)) AS maxdate FROM log_time_userkey";
		$result_max = mysql_db_query($dbnameuse,$sql_max);
		$rsm = mysql_fetch_assoc($result_max);
		return $rsm[maxdate];		
	}//end 	function GetMaxDate(){
		
		$maxdate = GetMaxDate();
		if($maxdate != ""){
			$date_config = $maxdate;
		}

function SaveLogKey($staffid,$idcard,$siteid,$start_date,$end_date,$timediff,$numkey){
	global $dbnameuse;
	$sql = "REPLACE INTO log_time_userkey SET staffid='$staffid',idcard='$idcard',siteid='$siteid',start_date='$start_date',end_date='$end_date',timediff='$timediff',numkey='$numkey'";
	//echo $dbnameuse."$sql<br><br>";
	mysql_db_query($dbnameuse,$sql);
		
}//end function SaveLogKey(){




	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}

		$exday = explode("-",$datereq);
		$datereq1 = ($exday[0]-543)."-$exday[1]-$exday[2]";
		


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">
	function refresh_iframe(subject1,sentsecid,czid){
		top.frames['a1'].location = "statistic_graph_user.php?subject="+subject1+"&secid="+sentsecid+"&czid="+czid ;
	}
</script>
</HEAD>
<BODY >
<?
	
	$TNUM = 0 ;
	  $j =1 ;

$sql = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
monitor_keyin.idcard,
monitor_keyin.siteid,
monitor_keyin.timestamp_key,
date(monitor_keyin.timestamp_key) as datekey1
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid
WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' ) and monitor_keyin.timestamp_key >= '$date_config'    GROUP BY idcard   ORDER BY monitor_keyin.timestamp_key ASC   
  " ;
//echo "$sql";die;
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$datereq1 = $rs[datekey1];

$TNUM = 0 ;
$TPOINT = 0 ;

$result3 = mysql_db_query("edubkk_master"," SELECT  siteid, prename_th,name_th,surname_th   FROM  view_general  WHERE  CZ_ID = '$rs[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;




	  	$sql2 = " SELECT  count(username) AS NUM , MAX(logtime) AS Maxtime , MIN(logtime) AS Mintime , TIMEDIFF( MAX(logtime),MIN(logtime)) AS difftime  , username , subject , logtime  FROM  log_update WHERE  username = '$rs[idcard]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'   OR action LIKE 'insert%') GROUP BY username  ORDER BY   logtime  DESC ";
		//echo "$dbsite : $sql2 <br>";
		$result2 = mysql_db_query($dbsite,$sql2) ;
		$rs2 = mysql_fetch_assoc($result2);


		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
						
			$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rs[idcard]' AND $rs_ff[Field] LIKE '$datereq1%' GROUP BY  $c " ;
			$result_c = @mysql_db_query($dbsite,$sql_c) ;
			$rs_c = @mysql_fetch_assoc($result_c);
			$rs_c[num] = @mysql_num_rows($result_c);
			//echo "$rs[staffid] $t[0]".$subfix." $rs_c[num]<br>";
			
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$tb1 = $t[0]."$subfix";
				$arrnum[$rs[staffid]] = $arrnum[$rs[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
			}
		}
		
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		
		
		$t1 = explode(" ",$rs2[Mintime]);
		$t2 = explode(" ",$rs2[Maxtime]);
		$datet1 = $datereq1." ".$t1[1];
		$datet2 = $datereq1." ".$t2[1];
		if($TNUM > 0){
		
			SaveLogKey($rs[staffid],$rs[idcard],$rs3[siteid],$datet1,$datet2,$rs2[difftime],$TNUM); // เก็บ log การ คีย์ข้อมูล
		
		}//end if($TNUM > 0){


		}
		
	echo "<h3>Done:.......</h3>";
	  ?>
</BODY></HTML>