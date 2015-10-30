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
			include("../../common/class.time_query.php");			
			$mytime_query->ApplicationName="crontab";
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
						
			$Hcurent = date("H");
			$Hm = date("i");
			//echo $Hcurent;die;
			if(($Hcurent == '22' or  $Hcurent  == "23" or $Hcurent  == "12") or ($Hcurent  == "11" and $Hm > 50) or ($Hcurent  == "13" and $Hm < 10)){
			

			
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
			
$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
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
			$xa1 = explode("||",$t[1]);
			 #### หาฟิลด์ที่จะนำเป็นเป็นเงือนไขการคิดคำนวณจุด
			  $arrF = CheckFieldPoint($t[0]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$datereq1%' ";}else{ $contimestamp = "";}
			
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
		$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rs[idcard]'  $contimestamp  GROUP BY $c";
	}else{
		$sql_c1 = "SELECT min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rs[idcard]'  $contimestamp  GROUP BY $c";	
	}
		
	$result_c1 = mysql_db_query($dbsite,$sql_c1);		
	while($rs_c1 = mysql_fetch_assoc($result_c1)){
				$sql_c2 = "SELECT ".$list_field." ,auto_id, $c  FROM $t[0]".$subfix_befor." WHERE id='$rs[idcard]' AND auto_id='$rs_c1[auto_id]' GROUP BY $c";
				//echo $sql_c2."<br> รหัสบัต :: $rs_c2[id]<hr>";
				$result_c2 = mysql_db_query($dbsite,$sql_c2);
				$rs_c2 = mysql_fetch_assoc($result_c2);
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
					
					$sql_check = "SELECT staffid  FROM $t[0]".$subfix_befor." WHERE id='$rs[idcard]' and auto_id < '$rs_c1[auto_id]'  $conA $conList ORDER BY  auto_id DESC LIMIT 0,1";
					//echo $sql_check."<br>";
					$result_check = mysql_db_query($dbsite,$sql_check);
					$rs_check = mysql_fetch_assoc($result_check);

					if($rs_check[staffid] != $rs[staffid]){
						
						$calcuatepoint = true;
						
					}//end if($rs_check[staffid] != $rs1[staffid]){
						
							if($calcuatepoint==true){
							$result1_diff = array_diff_assoc($sql_c1, $sql_c2);
							
							$numpoint  = count($result1_diff);
							//echo "จำนวนรายการที่แก้ไข :: ".$numpoint."<br>";
								if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
									$tb1 = $t[0]."$subfix";
									$arrnum[$rs[staffid]] = $arrnum[$rs[staffid]] + ($numpoint*$price_point[$tb1]) ;
								}//end if($numpoint > 0){
							}else{

							}
							
									
						
				}else{
					//echo $sql_c1."<br>";
						$tb1 = $t[0]."$subfix";
						$TNUM += 1;
				$arrnum[$rs[staffid]] = $arrnum[$rs[staffid]] + (1*$k_point[$tb1]) ;
				}// end if($rs_c2[id] > 0){
				
		}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){
			
			
						
//			$sql_c = " SELECT COUNT(*) AS num  FROM  $t[0]".$subfix." WHERE id = '$rs[idcard]' AND $rs_ff[Field] LIKE '$datereq1%' GROUP BY  $c " ;
//			$result_c = @mysql_db_query($dbsite,$sql_c) ;
//			$rs_c = @mysql_fetch_assoc($result_c);
//			$rs_c[num] = @mysql_num_rows($result_c);
//			//echo "$rs[staffid] $t[0]".$subfix." $rs_c[num]<br>";
//			
//			if($rs_c[num]>0){
//				$TNUM = $TNUM + $rs_c[num] ;
//				$tb1 = $t[0]."$subfix";
//				$arrnum[$rs[staffid]] = $arrnum[$rs[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
//			}
			
			
			
			
		}//end 	foreach($arr_f_tbl1 AS $key1 => $val1){
 
 } // end while($rs = mysql_fetch_assoc($result)){
 
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


 }//end 		if($Hcurent >= 22){	
	
			
			

echo " <center><h1>Success </h1></center>";


?>
