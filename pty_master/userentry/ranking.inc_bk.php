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
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$dbnameuse = $db_name;
			
			$time_start = getmicrotime();
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
				$d1 = intval($x[0]+543);
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
			
			$str_std = " SELECT k_point ,tablename  FROM  table_price  ";
			$result_std = mysql_db_query($dbnameuse,$str_std);
			while($rs_std = mysql_fetch_assoc($result_std)){
				$tb = $rs_std[tablename]."$subfix" ;
				$k_point[$tb] =  $rs_std[k_point] ;
			}


	if(date(G) < 19){$round = "am";}else{$round = "pm";}
	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$date1 = swapdate($date1);
		$datereq1 = $date1 ;
		$exday = explode("-",$date1);
		$datereq = ($exday[0]+543)."-$exday[1]-$exday[2]";
		
		
	}else{
		
		$dd = date("d");
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy += 543;
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		
		
	}

	if($round == "am"){
		$checked1 = "checked" ;
		$checked2 = "" ;
		$datebet1 = "$datereq1 08:00:00";
		$datebet2 = "$datereq1 18:00:00";
	}else{
		$checked1 = "" ;
		$checked2 = "checked" ;
		$datebet1 = "$datereq1 18:00:00";
		$datebet2 = "$datereq1 22:00:00";
	}

$TNUM = 0 ;
$sql = "
select  
*
from  keystaff  INNER JOIN   monitor_keyin ON  monitor_keyin.staffid = keystaff.staffid  WHERE
 ( timestamp_key  BETWEEN  '$datebet1' AND '$datebet2')  AND (  keystaff.sapphireoffice = 0 )  ORDER BY   keystaff.staffid ASC
 " ;
// echo "$sql <br>";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

$dbsite = STR_PREFIX_DB.$rs[siteid] ;
//echo "$rs[staffid] <hr>";
//	  	$sql2 = " SELECT  count(username) AS NUM , username , subject , logtime , user_ip  FROM  log_update WHERE  username = '$rs[idcard]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC ";
//		$result2 = mysql_db_query($dbsite,$sql2) ;
//		$rs2 = mysql_fetch_assoc($result2);
//		if($rs2[NUM] > 0 ){ $arrnum[$rs[staffid]] += $rs2[NUM]  ; }
		
		
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
 
 } 
 
$numberuser = count($arrnum);
//echo "<pre>";print_r($arrnum);echo "</pre>";


arsort($arrnum);
$maxkey = $arrnum[0];
$n = 1 ;

mysql_db_query($dbnameuse," TRUNCATE  ranking;  ");

foreach($arrnum AS $key => $val){

	$sql5 = " INSERT INTO  ranking(staffid,numrowdata,rank) VALUES ('$key','$val','$n')";
	//echo "$sql5 <br>";
	mysql_db_query($dbnameuse,$sql5);
	$n++;
	
}

echo " <center><h1>Success </h1></center>";


?>
