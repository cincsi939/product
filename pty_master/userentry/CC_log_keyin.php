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
			$dbnameuse = DB_USERENTRY;
			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

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


	if (!isset($datereq)){
		if(!isset($dd)){
			$dd = date("d");
		}
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy += 543;
		$datereq = "$yy-$mm-$dd";
	}else{
		$datetemp = explode("-",$datereq);
		$datereq = ($datetemp[0]-543)."-$datetemp[1]-$datetemp[2]";
	}

$TNUM = 0 ;$j =1 ;

			$str_std = " SELECT k_point ,tablename  FROM  table_price  ";
			$result_std = mysql_db_query($dbnameuse,$str_std);
			while($rs_std = mysql_fetch_assoc($result_std)){
				$tb = $rs_std[tablename]."$subfix" ;
				$k_point[$tb] =  $rs_std[k_point] ;
			}

if($staffid > 0 ){

// ----------   LOGIC ---------------------
$time1 = "08:00:00";
$con_n = 15;


$arrdata2 = array();

for($n = 1 ; $n <= $con_n ;$n++){

	//echo "1: $time1 <br>";
	$timestart = $time1 ;

	$sqlx01 = " SELECT ADDTIME('$datereq $time1','01:00:00') AS a; " ;
	//echo "$sqlx01<hr>";
	$resultx01 = mysql_db_query($dbnameuse,$sqlx01);
	$rsx01 = mysql_fetch_assoc($resultx01) ;

	$exptime = explode(" ",$rsx01[a]);
	$time1 = $exptime[1];

	$sql = "
	SELECT *
	FROM monitor_keyin
	WHERE
	timeupdate  LIKE  '$datereq%'  AND staffid = '$staffid'  
	  " ;
	 # echo "$sql<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){

		$result3 = mysql_db_query(DB_MASTER," SELECT  siteid, prename_th,name_th,surname_th   FROM  view_general  WHERE  CZ_ID = '$rs[idcard]' ");
		$rs3 = mysql_fetch_assoc($result3);
		$dbsite = STR_PREFIX_DB.$rs3[siteid] ;



//		$sql2 = " SELECT  count(username) AS NUM , MAX(logtime) AS Maxtime , MIN(logtime) AS Mintime , TIMEDIFF( MAX(logtime),MIN(logtime)) AS difftime  , username , subject , logtime  FROM  log_update WHERE  username = '$rs[idcard]'   AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) AND (logtime BETWEEN '$datereq $timestart' AND  '$datereq $exptime[1]' ) GROUP BY username  ORDER BY   logtime  DESC ";
//		//echo "$dbsite : $sql2 <br>";
//		$result2 = mysql_db_query($dbsite,$sql2) ;
//		$rs2 = mysql_fetch_assoc($result2);

		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			#echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
						
			$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rs[idcard]' AND $rs_ff[Field] BETWEEN '$datereq $timestart' AND  '$datereq $exptime[1]'  GROUP BY  $c " ;
			$result_c = @mysql_db_query($dbsite,$sql_c) ;
			$rs_c = @mysql_fetch_assoc($result_c);
			$rs_c[num] = @mysql_num_rows($result_c);
			#echo "$sql_c <hr> $dbsite $t[0]".$subfix." $rs_c[num]<br>";
			
			
			if($rs_c[num]>0){
				$tb1 = $t[0]."$subfix";
				$addkey = "$datereq $timestart" ;
				$arrdata2[$addkey] = $arrdata2[$addkey]  + ($rs_c[num]*$k_point[$tb1]) ;
			}


		}
		
	}
		
} //end for	
//echo "$staffid <br>";
//echo "<pre>";print_r($arrdata2);echo "</pre>";

foreach($arrdata2 AS $key=>$val){
	$sql_ins = " REPLACE INTO  stat_user_time(datekeyin,staffid,numkeyin)VALUES('$key','$staffid','$val'); ";
	//echo "$sql_ins <br>";
	//echo "$numkey[$key2] <hr>";
	mysql_db_query($dbnameuse,$sql_ins);
}

}

			echo "<meta http-equiv='refresh' content='0; url=report_keyin_user4.php?staffid=$staffid&datereq=$datereq'>";
			exit;

?>