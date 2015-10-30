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


//	if (!isset($datereq))										
//		if(!isset($dd)){
//			$dd = date("d");
//		}
//		$mm = date("m");
//		$mm = sprintf("%02d",intval($mm));
//		$yy=date("Y");
//		$yy += 543;
//		$datereq = "$yy-$mm-$dd";
//		$datereq1 = ($yy-543)."-$mm-$dd";
//		//$datereq =  "2552-06-01" ;
//		//$datereq1 = "2009-06-01" ;
//	}

function CalMoneySub($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix;
$datereq1 = "2009-12-14";

$str_std = " SELECT k_point ,tablename  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
}

$round = "am";

$TNUM = 0 ;
	  $j =1 ;
$sql_view = "SELECT siteid FROM view_general WHERE CZ_ID='$get_idcard'";
$result_view = mysql_db_query($dbnamemaster,$sql_view);
$rsv = mysql_fetch_assoc($result_view);
$db_site = STR_PREFIX_DB.$rsv[siteid];


$sql1 = "SELECT date(updatetime) as update_date, username as idcard  FROM `log_update` where  staff_login='$staff_id' and date(updatetime) > '$datereq1' group by date(updatetime)";
//echo "$db_site ::: $sql1<br>";
$result1 = mysql_db_query($db_site,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){

$dayrecord[] =   $rs1[update_date] ;

}
//echo "<pre>";
//print_r($dayrecord);
$dayrecord = array_unique($dayrecord);
rsort($dayrecord);
reset($dayrecord);

//echo "<pre>"; print_r($dayrecord);echo"</pre>";
//die;

$j=1;

//foreach($dayrecord AS $key=>$val){
//if($val != "0000-00-00"){
$sumkeyuser = array() ;
$numkey= array() ;
$TPOINT = array();
$str = "SELECT 
monitor_keyin.idcard,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
date(monitor_keyin.timeupdate) as val
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND 
keystaff.staffid='$staff_id'
AND date(monitor_keyin.timeupdate) > '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];


		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
						
		//$sql_c = " SELECT COUNT(*) AS num  FROM  $t[0]".$subfix." WHERE id = '$rss[idcard]' AND $rs_ff[Field] LIKE '$ndate%' GROUP BY  $c " ;
		$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rss[idcard]' AND date($rs_ff[Field]) >= '$ndate' GROUP BY  $c " ;
		echo $sql_c."<br>";
		$result_c = @mysql_db_query($dbsite,$sql_c) ;
		$rs_c = @mysql_fetch_assoc($result_c);
		$rs_c[num] = @mysql_num_rows($result_c);
		echo "$rss[staffid]  $t[0]".$subfix." $rs_c[num]<br>";
			
			
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$sumkeyuser[$rss[staffid]] +=  $rs_c[num] ;
				$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
				$tb1 = $t[0]."$subfix";
				$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
				echo "aaa : ".$TPOINT[$rss[staffid]] ."  bbb :". $TPOINT[$rss[staffid]] ."  + ( $rs_c[num]*$k_point[$tb1])<hr>";
				//echo "$kpoint :: ".$k_point[$tb1]."<br>";
				$num_val  = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
			}//end if($rs_c[num]>0){
		} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){
		
}//end while($rss  = mysql_fetch_assoc($results)){

//} // end if($val != "0000-00-00"){

//} // end foreach($dayrecord AS $key=>$val){
return $TPOINT;
}//end function 


print_r(CalMoneySub("10000","3650900271999","TK-255301040123468"));

 ?>