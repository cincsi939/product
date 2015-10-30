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

$datereq1 = "2010-03-19";
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


$round = "am";

$TNUM = 0 ;
	  $j =1 ;


$sql1 = "
SELECT 
date(monitor_keyin.timestamp_key) AS update_date
FROM monitor_keyin WHERE date(monitor_keyin.timestamp_key) >= '$datereq1' GROUP BY date(monitor_keyin.timestamp_key)
ORDER BY  update_date  DESC   " ;
//echo "$sql1<br>";
$result1 = mysql_db_query($dbnameuse,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){

$dayrecord[] =   $rs1[update_date] ;

}

$dayrecord = array_unique($dayrecord);
rsort($dayrecord);
reset($dayrecord);

//echo "<pre>"; print_r($dayrecord);echo"</pre>";
//die;

##############################################  ประมาวลผลการรับรองข้อมูลของแต่ละคนรายวัน

$round = "am";
$TNUM = 0 ;
$j=1;
$numrows= 0;
foreach($dayrecord AS $key=>$val){
	//echo "วันที่ :: ".$val;die;
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
WHERE monitor_keyin.timestamp_key  LIKE  '$val%' 
GROUP BY idcard ORDER BY keystaff.staffid ASC " ;
//echo "$dbnameuse  :: ".$str."<hr>";timestamp_key LIKE  '$datereq1%' 
$results = mysql_db_query($dbnameuse,$str);
$numrows = mysql_num_rows($results);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){
		$j++;
				$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
				$rss3 = mysql_fetch_assoc($results3);
				
				$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
				$d = explode("-", $val);
				$ndate = $d[0]."-".$d[1]."-".$d[2];
				


			foreach($arr_f_tbl1 AS $key1 => $val1){
					$t = explode("#",$val1);
					$c = cond_str($t[1]);
					$xa1 = explode("||",$t[1]);
					
					#### หาฟิลด์ที่จะนำเป็นเป็นเงือนไขการคิดคำนวณจุด
					 $arrF = CheckFieldPoint($t[0]);
					
					$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
					//echo "$dbsite  :: $sql_ff <br>";die;
					$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
					$rs_ff = @mysql_fetch_assoc($result_ff);
					if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$ndate%' ";}else{ $contimestamp = "";}
					//echo $contimestamp;die;
		
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
					$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]'  $contimestamp  GROUP BY $c";
				}else{
					$sql_c1 = "SELECT min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]'  $contimestamp  GROUP BY $c";	
				}
		//echo $sql_c1;die;
			$result_c1 = mysql_db_query($dbsite,$sql_c1);
			while($rs_c1 = mysql_fetch_assoc($result_c1)){
					$sql_c2 = "SELECT ".$list_field." ,auto_id, $c  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' AND auto_id='$rs_c1[auto_id]' GROUP BY $c";
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
						
						$sql_check = "SELECT staffid  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' and auto_id < '$rs_c1[auto_id]'  $conA $conList ORDER BY  auto_id DESC LIMIT 0,1";
						//echo $sql_check."<br>";
						$result_check = mysql_db_query($dbsite,$sql_check);
						$rs_check = mysql_fetch_assoc($result_check);

						  if($rs_check[staffid] != $rss[staffid]){
							  $calcuatepoint = true;
						  }//end if($rs_check[staffid] != $rs1[staffid]){
							if($calcuatepoint==true){
							$result1_diff = array_diff_assoc($sql_c1, $sql_c2);
							$numpoint  = count($result1_diff);
							//echo "จำนวนรายการที่แก้ไข :: ".$numpoint."<br>";
								if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
									$tb1 = $t[0]."$subfix";
									$TPOINT_PERSON[$rss[staffid]][$rss[idcard]] = $TPOINT_PERSON[$rss[staffid]][$rss[idcard]] + ( $numpoint*$price_point[$tb1]) ;

								}//end if($numpoint > 0){
							}//end if($calcuatepoint==true){
							
						}else{
							$tb1 = $t[0]."$subfix";
							$TNUM += 1;
							$sumkeyuser_person[$rss[staffid]][$rss[idcard]] +=  1 ;
							$TPOINT_PERSON[$rss[staffid]][$rss[idcard]] = $TPOINT_PERSON[$rss[staffid]][$rss[idcard]] + ( 1*$k_point[$tb1]) ;
						}// end if($rs_c2[id] > 0)
					}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){
				}//end 	foreach($arr_f_tbl1 AS $key1 => $val1){
			} /// end while($rss  = mysql_fetch_assoc($results)){
				
	}//end foreach($dayrecord AS $key=>$val){
			//echo "<pre>";	
			//print_r($TPOINT_PERSON);
			//die;
	### ทำการบันทึกข้อมูลในระบบ
			foreach($sumkeyuser_person as $key_person => $val_person){
			foreach($val_person as $k => $v){
			//	echo "รหัสพนักงาน :: $key_person  เลขบัตร :: $k  ค่าคะแนน ::".$TPOINT_PERSON[$key_person][$k]."<br>";
			$sql_check = "SELECT * FROM stat_user_keyperson WHERE datekeyin='$datereq1' AND staffid='$key_person' AND idcard='$k'";
			//echo $sql_check."<br>";
			$result_check = mysql_db_query($dbnameuse,$sql_check);
			$rs_check = mysql_fetch_assoc($result_check);
/*			if(KeyDataCurrent($k) > 0){
					$status_approve = 1;
			}else{
					$status_approve = 0;	
			}//end if(KeyDataCurrent($k) > 0){*/
				$status_approve = intval(CheckKeyApprove($k,$key_person));
			
			if($rs_check[idcard] != ""){
				$sql_key_person = "UPDATE stat_user_keyperson SET numpoint='".$TPOINT_PERSON[$key_person][$k]."', numkeyin='$v',status_approve='$status_approve' WHERE datekeyin='$datereq1' AND staffid='$key_person' AND idcard='$k'";
			}else{
			$sql_key_person = "INSERT INTO stat_user_keyperson(datekeyin,staffid,idcard,numkeyin,numpoint,status_approve)VALUES('$datereq1','$key_person','$k','$v','".$TPOINT_PERSON[$key_person][$k]."','$status_approve')";	
			}
			//echo $sql_key_person."<br><hr>";
			@mysql_db_query($dbnameuse,$sql_key_person);
			}// end foreach($val_person as $k => $v){
		}//end foreach($sumkeyuser_person as $key_person => $val_person){
##############################################  ประมาวลผลการรับรองข้อมูลของแต่ละคนรายวัน		
## แบ่งกลุ่มในการ QC งาน
$sql_staff = "SELECT
keystaff.staffid
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id";
$result_staff = mysql_db_query($dbnameuse,$sql_staff);
while($rs_staff = mysql_fetch_assoc($result_staff)){
		SubGroupQC($rs_staff[staffid]);
}//end while($rs_staff = mysql_fetch_assoc($result_staff)){

CalHiddenPersonPoint();// คำนวณหาค่าคะแนนความซับซ้อน
##  end เขียนข้อมูลใส่ใน ranking 
$time_end = getmicrotime();
echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";




 echo "<h1>Done...................";
 ?>