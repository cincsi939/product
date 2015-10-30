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
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$dbnameuse = $db_name;
			
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
		$datereq1 = ($yy-543)."-$mm-$dd";
		//$datereq =  "2552-06-01" ;
		//$datereq1 = "2009-06-01" ;
	}

$str_std = " SELECT k_point ,tablename  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
}

$round = "am";

$TNUM = 0 ;
	  $j =1 ;



$sql1 = "
SELECT 
date(monitor_keyin.timeupdate) AS update_date
FROM monitor_keyin WHERE date(monitor_keyin.timeupdate) >= '$datereq1'
GROUP BY date(monitor_keyin.timestamp_key) 
ORDER BY  update_date  DESC   " ;
echo "$sql1<br>";
$result1 = mysql_db_query($dbnameuse,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){

$dayrecord[] =   $rs1[update_date] ;

}

$dayrecord = array_unique($dayrecord);
rsort($dayrecord);
reset($dayrecord);

//echo "<pre>"; print_r($dayrecord);echo"</pre>";
//die;

$j=1;

foreach($dayrecord AS $key=>$val){
if($val != "0000-00-00"){
$sumkeyuser = array() ;
$numkey= array() ;
$TPOINT = array();
$str = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' ) AND timestamp_key LIKE  '$val%' GROUP BY idcard   ORDER BY keystaff.staffid ASC    " ;

echo $str."<hr>";
$results = mysql_db_query($dbnameuse,$str);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){


$j++;

$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $val);
$ndate = $d[0]."-".$d[1]."-".$d[2];

//$sql2 = " SELECT  count(username) AS NUM , username , subject , logtime  FROM  log_update WHERE  username = '$rss[idcard]'  AND logtime LIKE  '$ndate%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC ";
//$result2 = mysql_db_query($dbsite,$sql2) ;
//$rs2 = mysql_fetch_assoc($result2);
//echo $sql2." $dbsite<br>";
//$TNUM +=  $rs2[NUM] ;
//if($rs2[NUM] != 0){
//	$sumkeyuser[$rss[staffid]] +=  $rs2[NUM] ;
//	$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
//}
//echo "<hr>$ndate $rss[staffname] :  $rss[idcard] <hr>";

		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);





						
			$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rss[idcard]' AND $rs_ff[Field] LIKE '$ndate%' GROUP BY  $c " ;
			$result_c = @mysql_db_query($dbsite,$sql_c) ;
			$rs_c = @mysql_fetch_assoc($result_c);
			$rs_c[num] = @mysql_num_rows($result_c);
			//echo "$rss[staffid]  $t[0]".$subfix." $rs_c[num]<br>";
			
			
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$sumkeyuser[$rss[staffid]] +=  $rs_c[num] ;
				$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
				$tb1 = $t[0]."$subfix";
				$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
			}


		}
		



}

// echo "<pre>"; print_r($TPOINT);echo"</pre>";
foreach($sumkeyuser AS $key2=>$val2){
	$sql_ins = " REPLACE INTO  stat_user_keyin(datekeyin,staffid,val_avg,val_max,val_min,numkeyin,kval_avg,kval_max,kval_min,numkpoint)VALUES('$val','$key2','$avg','$val2','$minc','$sumkeyuser[$key2]','','$TPOINT[$key2]','$TPOINT[$key2]','$TPOINT[$key2]'); ";
//	echo "$sql_ins <hr>";
//	echo "$numkey[$key2] <hr>";
	mysql_db_query($dbnameuse,$sql_ins);
}
	  	rsort($sumkeyuser);
		$maxc = $sumkeyuser[0] ;
		reset($sumkeyuser);
	  	sort($sumkeyuser);
		$minc = $sumkeyuser[0] ;
		reset($sumkeyuser);
		
		rsort($TPOINT);
		$maxk = $TPOINT[0] ;
		reset($TPOINT);
	  	sort($TPOINT);
		$mink = $TPOINT[0] ;
		reset($TPOINT);
//echo "<pre>"; print_r($TPOINT);echo"</pre>";
//echo "$maxk<hr>$mink<hr>";

$sql_x = " SELECT  Avg(stat_user_keyin.val_max) AS val_avg,Avg(numkpoint) AS kval_avg   FROM stat_user_keyin  WHERE  stat_user_keyin.datekeyin LIKE   '$val%'   ";
$result_x = mysql_db_query($dbnameuse,$sql_x);
$rs_x = mysql_fetch_assoc($result_x);
//echo "$sql_x <hr>";

$sql_u = " UPDATE   stat_user_keyin SET val_avg = '$rs_x[val_avg]' ,val_min = '$minc' , val_max = '$maxc' , kval_max = '$maxk' ,kval_min = '$mink' , kval_avg = '$rs_x[kval_avg]'  WHERE datekeyin LIKE '$val%' ; ";
mysql_db_query($dbnameuse,$sql_u);


$sql_r = " REPLACE INTO  std_val_ref(datekeyin,val_avg,val_max,val_min,val_kavg,val_kmax,val_kmin)VALUES('$val','$rs_x[val_avg]','$maxc','$minc','$rs_x[kval_avg]','$maxk','$mink'); ";
mysql_db_query($dbnameuse,$sql_r);


//echo "$sql_x <br> $sql_r <br> $sql_u <hr>";

} // end

} // end 

 echo "<h1>Done...................";
 ?>