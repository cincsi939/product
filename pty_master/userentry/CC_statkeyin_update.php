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
			$date_config = "2011-11-11";
			
			$date_config_end = "2011-11-12";

			
			
			
			$dbnameuse = DB_USERENTRY;
			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

$str_std = " SELECT *  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
	$table_id[$tb] = $rs_std[id];
}


###หาจุดฟิล์ดที่จะนำไปคำนวณจุด
function CheckFieldPoint($get_tbl){
	global $dbnameuse;
	$sql_checkfield = "SELECT * FROM keyin_point WHERE keyinpoint > 0 AND tablename='$get_tbl'";
	$result_checkfield = mysql_db_query($dbnameuse,$sql_checkfield);
	while($rs_chF = mysql_fetch_assoc($result_checkfield)){
		$arr[] = $rs_chF[keyname];	
	}//end while($rs_chF = mysql_fetch_assoc($result_checkfield)){
	return $arr;
}//end function CheckFieldPoint(){



	function GetMaxDate(){
		global $dbnameuse;
		$sql_max = "SELECT max(date(log_time_userkeyupdate_new.start_date)) AS maxdate FROM log_time_userkeyupdate_new";
		$result_max = mysql_db_query($dbnameuse,$sql_max);
		$rsm = mysql_fetch_assoc($result_max);
		return $rsm[maxdate];		
	}//end 	function GetMaxDate(){
		
		$maxdate = GetMaxDate();
/*		if($maxdate != ""){
			$date_config = $maxdate;
		}*/

function SaveLogKey($datekey,$staffid,$idcard,$siteid,$start_date,$end_date,$timediff,$numkey,$numline_key,$numpoint_key){
	global $dbnameuse;
	$sql = "REPLACE INTO log_time_userkeyupdate_new SET  datekey='$datekey',staffid='$staffid',idcard='$idcard',siteid='$siteid',start_date='$start_date',end_date='$end_date',timediff='$timediff',numkey='$numkey',numline_key='$numline_key',numpoint_key='$numpoint_key'";
	//echo $dbnameuse."$sql<br><br>";
	mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		
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
		


	//$xlimit = " LIMIT 0,1";
	
	$TNUM = 0 ;
	  $j =1 ;

$sql = "
SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.idcard,
t2.siteid,
t2.timestamp_key,
date(t2.timestamp_key) as datekey1
FROM
keystaff as t1
Inner Join monitor_keyin as t2 ON t1.staffid = t2.staffid
WHERE   ( t1.sapphireoffice = 0 )  AND (t1.status_extra = 'NOR' )  
AND date(t2.timestamp_key) between '$date_config'  and '$date_config_end'  
GROUP BY t2.idcard   ORDER BY t2.timestamp_key ASC  $xlimit  
  " ;
  #AND date(t2.timestamp_key) between '$date_config'  and '$date_config_end'  

echo "<hr>$sql</hr>";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while($rss = mysql_fetch_assoc($result)){
	
$datereq1 = $rss[datekey1];
//echo $datereq1."<br>";

$result3 = mysql_db_query($dbnamemaster," SELECT  siteid, prename_th,name_th,surname_th   FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ") or die(mysql_error()."LINE___".__LINE__);
$rs3 = mysql_fetch_assoc($result3);
if($rs3[siteid] != ""){
	$dbsite = STR_PREFIX_DB.$rs3[siteid] ;

	


	  	$sql2 = " SELECT  count(username) AS NUM , MAX(logtime) AS Maxtime , MIN(logtime) AS Mintime , TIMEDIFF( MAX(logtime),MIN(logtime)) AS difftime  , username , subject , logtime  FROM  log_update WHERE  username = '$rss[idcard]' AND staff_login='$rss[staffid]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'add%'  OR action LIKE 'insert%') GROUP BY username  ORDER BY   logtime  DESC ";
		//echo "$dbsite : $sql2 <br>";
		$result2 = mysql_db_query($dbsite,$sql2) ;
		$rs2 = mysql_fetch_assoc($result2);


		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			$xa1 = explode("||",$t[1]);
			
			#### หาฟิลด์ที่จะนำเป็นเป็นเงือนไขการคิดคำนวณจุด
			 $arrF = CheckFieldPoint($t[0]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$ndate%' ";}else{ $contimestamp = "";}


			$str_listfield = "SHOW COLUMNS FROM $t[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield = mysql_db_query($dbsite,$str_listfield);
			$xi = 0;
			$list_field = "";
			while($rs_l = mysql_fetch_assoc($result_listfield)){
				if(in_array($rs_l[Field],$arrF)){
					if($list_field > "") $list_field .= ","; 
					$list_field .= " $rs_l[Field] ";
					$xi++;
				}//end if(in_array($rs_l[Field],$arrF)){
			}//end while($rs_l = mysql_fetch_assoc($result_listfield)){

	if($list_field != ""){ 
		$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]'  and staffid='$rss[staffid]' $contimestamp  GROUP BY $c";
	}else{
		$sql_c1 = "SELECT min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]' and staffid='$rss[staffid]' $contimestamp  GROUP BY $c";	
	
	}
		//echo "<hr>".$sql_c1."<br>";
		$result_c1 = mysql_db_query($dbsite,$sql_c1) or die(mysql_error()."$sql_c1<br>LINE___".__LINE__);
	while($rs_c1 = mysql_fetch_assoc($result_c1)){
				$sql_c2 = "SELECT ".$list_field." ,auto_id, $c  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' AND auto_id='$rs_c1[auto_id]' GROUP BY $c";
				//echo $sql_c2."<br> รหัสบัต :: $rs_c2[id]<hr>";
				
				$result_c2 = mysql_db_query($dbsite,$sql_c2) or die(mysql_error()."$sql_c2<br>LINE__".__LINE__);
				$rs_c2 = mysql_fetch_assoc($result_c2);
				//echo "$t[0]".$subfix." <pre>";
				//print_r($rs_c1)."<br>";
				$calcuatepoint=false ;
				if($rs_c2[id] > 0){
					//echo "รหัสคนคีย์ปัจจุบัน  :: ".$rs1[staffid]."<br>";
					/// selectr  staff ที่มี auto_id น้อยกว่าของบรรทัดเดียวกัน   ก่อนหน้าว่าเป็นตัวเองหรือไม่ หากไม่ใช่ให้คิดคะแนนรายจุด โดย	 $calcuatepoint =true	
					$conList = "";
					foreach($xa1 as $xk1 => $xv1){
						if($conList != "") $conList .= " AND "; 
						$conList .= "$xv1='".$rs_c1[$xv1]."'";
							
					}
					if($conList != ""){ $conA = " AND ";}else{ $conA = "";}
					
					$sql_check = "SELECT staffid  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' and auto_id < '$rs_c1[auto_id]'  $conA $conList ORDER BY  auto_id DESC LIMIT 0,1";
					//echo $sql_check."<br>";
					$result_check = mysql_db_query($dbsite,$sql_check);
					$rs_check = mysql_fetch_assoc($result_check);
					//echo "<Pre>";
					//echo $t[0].$subfix_befor."<br><pre>$rs_check[staffid] == $rss[staffid]<br>";
					//print_r($rs_c1);
					//echo "<hr>".$t[0].$subfix."<br>";
					//print_r($rs_c2);	
					//echo "<hr>";
					//$result1_diffx = array_diff_assoc($rs_c1, $rs_c2);
					//echo "diff :: ".count($result1_diffx)."<br>";				
					

					if($rs_check[staffid] != $rss[staffid]){
						$calcuatepoint = true;
					}//end if($rs_check[staffid] != $rs1[staffid]){
							if($calcuatepoint==true){
							$result1_diff = array_diff_assoc($rs_c1, $rs_c2);
							$numpoint  = count($result1_diff);
							//echo "จำนวนรายการที่แก้ไข :: ".$numpoint."<br>";
								if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
									$tb1 = $t[0]."$subfix";
									//$TPOINT  +=   $numpoint*$price_point[$tb1];
									
									$TPOINT[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $TPOINT[$rss[datekey1]][$rss[staffid]][$rss[idcard]] + ( $numpoint*$price_point[$tb1]) ;
									$TPOINT_KEY[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $TPOINT_KEY[$rss[datekey1]][$rss[staffid]][$rss[idcard]] + ( $numpoint) ;

								}//end if($numpoint > 0){
							}//end if($calcuatepoint==true){
							
				}else{
					//echo $sql_c1."<br>";
						$tb1 = $t[0]."$subfix";
						
						
						
								$TNUM += 1;
								$result1_diff = array_diff_assoc($rs_c1, $rs_c2);
								$numpoint  = count($result1_diff);
								if($numpoint < 1){
									$numpoint = GetNumFieldTable($t[0]);	
								}
								
								$TPOINT[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $TPOINT[$rss[datekey1]][$rss[staffid]][$rss[idcard]] + ( 1*$k_point[$tb1])  ;
								$TPOINT_KEY[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $TPOINT_KEY[$rss[datekey1]][$rss[staffid]][$rss[idcard]] + ( $numpoint) ;
								
				}// end if($rs_c2[id] > 0){
				
		}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){

		}// end foreach($arr_f_tbl1 AS $key1 => $val1){
		

		
		$t1 = explode(" ",$rs2[Mintime]);
		$t2 = explode(" ",$rs2[Maxtime]);
		$datet1 = $datereq1." ".$t1[1];
		$datet2 = $datereq1." ".$t2[1];
		$DATE_START[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $datet1;
		$DATE_END[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $datet2;
		$DATE_DIFF[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $rs2[difftime];
		$NUM_LINE[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $rs2[NUM]; // จำนวนบรรทัด
		$Arr_site[$rss[datekey1]][$rss[staffid]][$rss[idcard]] = $rss[siteid]; // จำนวนบรรทัด
		


		}//end if($rs3[siteid] != ""){
}//end 
		
/*		echo "<pre>";
		echo "<hr> TPOINT<br>::";
		print_r($TPOINT);
		echo "<hr>TPOINT_KEY<br>::";
		print_r($TPOINT_KEY);
		echo "<hr >NUM_LINE <br>::";
		print_r($NUM_LINE);
		
	die;
*/	
if(count($NUM_LINE) > 0){
		foreach($NUM_LINE as $key => $val){
			foreach($val as $k1 => $v1){
				foreach($v1 as $k2 => $v2){
				
					SaveLogKey($key,$k1,$k2,$Arr_site[$key][$k1][$k2],$DATE_START[$key][$k1][$k2],$DATE_END[$key][$k1][$k2],$DATE_DIFF[$key][$k1][$k2],$TPOINT[$key][$k1][$k2],$NUM_LINE[$key][$k1][$k2],$TPOINT_KEY[$key][$k1][$k2]); // เก็บ log การ คีย์ข้อมูล	
				}//end foreach($v1 as $k2 => $v2){
			}// end foreach($val as $k1 => $v1){
		}// end foreach($NUM_LINE as $key => $val){
	}//end if(count($NUM_LINE) > 0){


	
	echo "<h3>Done:.......</h3>";
	  ?>
</BODY></HTML>