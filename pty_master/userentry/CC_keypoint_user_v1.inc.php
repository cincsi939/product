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
# Modifine :: Suwat
#LastUpdate::26/01/2010
#DatabaseTable::edubkk_userentry, moniter_keyin

#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$dbnameuse = $db_name;

function CalMoneySubV1($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix,$subfix_befor,$arr_f_tbl3;
$datereq1 = "2009-12-14";

$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
	
}

//echo "<pre>";
//print_r($price_point);

$round = "am";
$TNUM = 0 ;
 $j =1 ;
$j=1;
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
AND date(monitor_keyin.timeupdate) >= '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query(DB_MASTER," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];

	$list_field = "";
		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			
			$str_listfield = "SHOW COLUMNS FROM $t[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield = mysql_db_query($dbsite,$str_listfield);
			$xi = 0;
			$list_field = "";
			while($rs_l = mysql_fetch_assoc($result_listfield)){
				if($rs_l[Field] != "staffid"){
					if($list_field > "") $list_field .= ","; 
					$list_field .= " $rs_l[Field] ";
					$xarr_field[] = $rs_l[Field];
					$xi++;
				}//end if($rs_l[Field] != "staffid"){
			}//end while($rs_l = mysql_fetch_assoc($result_listfield)){
			
			
			##  log หลังทำการบันทึก
			
			$sql_after = "SELECT $list_field  FROM $t[0]".$subfix." WHERE id='$rss[idcard]' AND date($rs_ff[Field]) >= '$ndate'  GROUP BY $c";
			$result_after = mysql_db_query($dbsite,$sql_after);
			if($t[0] == "salary"){ echo $sql_after."<br>";}
			while($rs_after = mysql_fetch_assoc($result_after)){
			$sql_befor = "SELECT ".$list_field."  FROM  $t[0]".$subfix_befor." WHERE id='$rss[idcard]' and runid='$rs_after[runid]' ORDER BY runid ASC ";	
			if($t[0] == "salary"){ echo $sql_befor."<br><hr>";}
			$result_befor = mysql_db_query($dbsite,$sql_befor);
			$rs_befor = mysql_fetch_assoc($result_befor);
			$numr1 = @mysql_num_rows($result_befor);
			if($numr1 > 0){ // กรณีมีข้อมูลก่อนการบันทึก
				$result1 = array_diff_assoc($rs_befor, $rs_after);
				$numpoint  = count($result1);
				if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
					$tb1 = $t[0]."$subfix";
					$numval[$tb1] +=   $numpoint*$price_point[$tb1];
					echo $t[0]."$subfix   ::  $numpoint   *  ". $price_point[$tb1]." === ".$numpoint*$price_point[$tb1]." <br>";
				}//end if($numpoint > 0){
			}else{
				$tb1 = $t[0]."$subfix";
				echo $t[0]."$subfix  :: 1 * ". $k_point[$tb1]." === ".(1*$k_point[$tb1])."<br>";
					$numval[$tb1] += 1*$k_point[$tb1];
			}//end if($numr1 > 0){
		}// end while($rs_after = mysql_fetch_assoc($result_after)){
	} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){	
	
##################  คำนวณจาก ตารางที่มีรหัสเป็น gen_id ##################################################
	
		$list_field3 = "";
		foreach($arr_f_tbl3 AS $key3 => $val3){
			$t3 = explode("#",$val3);
			$c3 = cond_str($t3[1]);
			//echo $t3[0]."<br>";
			
			$sql_ff3 = " SHOW  COLUMNS FROM  $t3[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			$result_ff3 = @mysql_db_query($dbsite,$sql_ff3) ;
			$rs_ff3 = @mysql_fetch_assoc($result_ff3);
			
			$str_listfield3 = "SHOW COLUMNS FROM $t3[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield3 = mysql_db_query($dbsite,$str_listfield3);
			$xi3 = 0;
			$list_field3 = "";
			while($rs_l3 = mysql_fetch_assoc($result_listfield3)){
				if($rs_l3[Field] != "staffid"){
					if($list_field3 > "") $list_field3 .= ","; 
					$list_field3 .= " $rs_l3[Field] ";
					$xarr_field3[] = $rs_l3[Field];
					$xi3++;
				}//end if($rs_l3[Field] != "staffid"){
			}//end while($rs_l3 = mysql_fetch_assoc($result_listfield3)){
			
			
			##  log หลังทำการบันทึก
			$sql_after3 = "SELECT $list_field3  FROM $t3[0]".$subfix." WHERE gen_id='$rss[idcard]' AND date($rs_ff3[Field]) >= '$ndate'  GROUP BY $c3";
			//echo "$dbsite  :::  $sql_after3<br>";
			$result_after3 = mysql_db_query($dbsite,$sql_after3);
			while($rs_after3 = mysql_fetch_assoc($result_after3)){
			//echo "<pre>";
			//print_r($rs_after3);
			$sql_befor3 = "SELECT ".$list_field3."  FROM  $t3[0]".$subfix_befor." WHERE gen_id='$rss[idcard]' and runid='$rs_after3[runid]' ORDER BY runid ASC ";	
			$result_befor3 = mysql_db_query($dbsite,$sql_befor3);
			$rs_befor3 = mysql_fetch_assoc($result_befor3);
			$numr13 = @mysql_num_rows($result_befor3);
			if($numr13 > 0){ // กรณีมีข้อมูลก่อนการบันทึก
				$result13 = array_diff_assoc($rs_befor3, $rs_after3);
				$numpoint3  = count($result13);
				if($numpoint3 > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
					$tb13 = $t3[0]."$subfix";
					$numval3[$tb13] +=   $numpoint3*$price_point[$tb13];
				}//end if($numpoint3 > 0){
			}else{
				$tb13 = $t3[0]."$subfix";
					$numval3[$tb13] += 1*$k_point[$tb1];
			}//end if($numr1 > 0){
		}// end while($rs_after = mysql_fetch_assoc($result_after)){
	} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){	

###############################   end 	
}//end while($rss  = mysql_fetch_assoc($results)){
	
	echo "<pre>";
	print_r($numval);
	print_r($numval3);

	return  (array_sum($numval))+(array_sum($numval3));
}//end function 


echo CalMoneySubV1("10039","5650600015489","TK-255212281649350");

 ?>