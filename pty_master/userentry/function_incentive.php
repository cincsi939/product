<?

//function ProcessSubtract($get_date){
//	global $db_name;
//	$dbnameuse = $db_name;
//	$datereq1 = $get_date;
//	if($datereq1 != "2010-06-01"){ // เนื่องจากวันที่ 1 มีปัญหายังไม่สามารถหาสาเหตุได้ว่าทำมัยข้อมูลวันที่ 1 มิถุนายน ถึงมี จำนวนรายงานถึง 6000 กว่ารายการ
//	###  ทำการล้างข้อมูลก่อนคำนวณใหม่
//	$sql_clear = "UPDATE validate_checkdata  SET datecal='0000-00-00', status_cal='0' WHERE datecal='$datereq1'";
//	//echo $sql_clear;die;
//	@mysql_db_query($db_name,$sql_clear);
//	###  end  ทำการล้างข้อมูลก่อนคำนวณใหม่
//	
//	$sql_update = "UPDATE stat_subtract_keyin SET spoint='0',num_p='0' WHERE datekey='$datereq1' ";
//	//echo "$sql_update<br>";
//	mysql_db_query($dbnameuse,$sql_update);
//	
///*	$sql = "SELECT DISTINCT
//monitor_keyin.idcard,
//monitor_keyin.staffid,
//tbl_assign_key.ticketid
//FROM
//monitor_keyin
//Inner Join tbl_assign_key ON monitor_keyin.idcard = tbl_assign_key.idcard
//WHERE
//tbl_assign_key.nonactive =  '0' 
//AND  monitor_keyin.timestamp_key like '$datereq1%' ";*/
////echo $dbnameuse."<br>".$sql;die;
//$sql = "SELECT monitor_keyin.idcard, monitor_keyin.staffid
//FROM monitor_keyin 
//WHERE monitor_keyin.timestamp_key like '$datereq1%' ";
////echo $sql;die;
//$result = mysql_db_query($dbnameuse,$sql);
//while($rs = mysql_fetch_assoc($result)){
//	$sql_assign = "SELECT tbl_assign_key.ticketid FROM tbl_assign_key WHERE  idcard='$rs[idcard]' AND tbl_assign_key.nonactive =  '0'";
//	$result_assign = mysql_db_query($dbnameuse,$sql_assign);
//	$rsa = mysql_fetch_assoc($result_assign);
//	
//	$subtract = CalSubtract($rs[idcard],$rs[staffid],$rsa[ticketid]); // ค่าคะแนนที่คำนวณได้
//
//	$nump = NumP($rs[staffid],$rs[idcard]);
//	$sql_update = "UPDATE validate_checkdata SET validate_checkdata.status_cal='1' ,validate_checkdata.datecal='$datereq1'  WHERE validate_checkdata.idcard='$rs[idcard]' AND validate_checkdata.staffid='$rs[staffid]' AND validate_checkdata.ticketid='$rsa[ticketid]' and status_cal='0'";
//	//echo $sql_update."<br>";
//	@mysql_db_query($dbnameuse,$sql_update);
//
//	$arr_subtract[$rs[staffid]] = $arr_subtract[$rs[staffid]]+$subtract;
//	$arr_num_p[$rs[staffid]] = $arr_num_p[$rs[staffid]]+$nump;
//		
//	}//end while($rs = mysql_fetch_assoc($result)){ 
////}//end foreach($arr_date1 as $keydate => $valdate){
//
////	echo "<pre>";
////	print_r($arr_subtract);
////	echo "<pre>";
////	print_r($arr_num_p);
////	die;
// $arr_d1 = explode("-",$datereq1);
// $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
// $curent_week = $xFTime["wday"];
// 
// ## 1 คือ เลขสัปดาห์ ของวันจันทร์
// ## 6 คือ เลขสัปดาห์ ของวันเสาร์
//	 $curent_week = $xFTime["wday"];
//	 $xsdate = $curent_week -1;
//	 $xedate = 6-$curent_week;
//	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
//	 if($xsdate > 0){ $xsdate = "-$xsdate";}
//	 
//				
//				 $xbasedate = strtotime("$datereq1");
//				 $xdate = strtotime("$xsdate day",$xbasedate);
//				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
//				 
//				 $xbasedate1 = strtotime("$datereq1");
//				 $xdate1 = strtotime("$xedate day",$xbasedate1);
//				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป
//
//
////echo "<pre>";
////print_r($arr_ticketid);
//if(count($arr_subtract) > 0){
//	foreach($arr_subtract as $key => $val){		
//		$group_type = CheckGroupKey($key); // ตรวจสอบกลุ่มการคีย์ข้อมูลถ้าค่า เป็น 1 แสดงว่า เป็น กลุ่ม A และ กลุ่ม B ซึ่งจะนำมาหักตามช่วงเวลาที่กำหนด
//		
//		
//		
//		if($group_type > 0){
//			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
//			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p)VALUE('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."')";
//		}else{
//			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."')";	
//			$str_update = "";
//		}//end if($group_type > 0){
//		
//		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
//		$result_select = mysql_db_query($dbnameuse,$sql_select);
//		$rs_s = mysql_fetch_assoc($result_select);
//		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
//			if($val > 0){
//				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
//				//echo " UP  ::".$sql_insert."<br><br>";
//				mysql_db_query($dbnameuse,$sql_insert);
//			}//end 	if($val > 0){	
//		}else{
//				if($val > 0){
//					//echo "insert ::".$sql_insert1."<br><br>";
//				mysql_db_query($dbnameuse,$sql_insert1);
//				}//end if($val > 0){
//		}//end if($rs_s[spoint] > 0){
//
//	//	echo"$sql_insert<br>$sql_insert1<hr><hr>";
//	}//end foreach($arr_subtract as $key => $val){ 
//		
//	}//end if(count($arr_subtract) > 0){
//		
//	}//end 	if($datereq1 != "2010-06-01"){ 
//	
//}//end function ProcessSubtract($get_date){
//#################################################   function ProcessSubtract($get_date){ ########################





############  functin ในการคำนวณค่าคะแนนสัมประสิทธิ

function ProcessSubtract($get_date){
	global $db_name,$ratio_t1,$ratio_t2;
	$dbnameuse = $db_name;
	$datereq1 = $get_date;
	if($datereq1 != "2010-06-01"){ // เนื่องจากวันที่ 1 มีปัญหายังไม่สามารถหาสาเหตุได้ว่าทำมัยข้อมูลวันที่ 1 มิถุนายน ถึงมี จำนวนรายงานถึง 6000 กว่ารายการ
	###  ทำการล้างข้อมูลก่อนคำนวณใหม่
	$sql_clear = "UPDATE validate_checkdata  SET datecal='0000-00-00', status_cal='0' WHERE datecal='$datereq1' AND status_process_point='YES'";
	//echo $sql_clear;die;
	mysql_db_query($db_name,$sql_clear);
	###  end  ทำการล้างข้อมูลก่อนคำนวณใหม่
	
	$sql_update = "UPDATE stat_subtract_keyin SET spoint='0',num_p='0' WHERE datekey='$datereq1' ";
	//echo "$sql_update<br>";
	mysql_db_query($dbnameuse,$sql_update);
	
	
$sql = "SELECT
sum(if(tx.mistaken_id='2',t1.num_point*$ratio_t1,t1.num_point*$ratio_t2)) as sumval,
t1.staffid,t1.idcard,t1.ticketid
FROM
validate_checkdata as t1
Inner Join validate_datagroup as tx ON t1.checkdata_id = tx.checkdata_id
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3  ON t1.idcard = t3.idcard AND t1.staffid = t3.staffid
where  t1.qc_date LIKE '$datereq1%' and t1.status_process_point='YES' group by t1.idcard,t1.staffid
UNION
SELECT 0,staffid,idcard,ticketid FROM validate_checkdata 
WHERE  qc_date='$datereq1' AND result_check='1' AND validate_checkdata.status_process_point='YES' ";	
	
	
	
/*$sql = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval,
staffid,idcard
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE qc_date='$datereq1'  AND validate_checkdata.status_process_point='YES'
group by idcard,staffid
UNION
SELECT 0,staffid,idcard FROM validate_checkdata 
WHERE  qc_date='$datereq1' AND result_check='1' AND validate_checkdata.status_process_point='YES' " ;
*/
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_assign = "SELECT tbl_assign_key.ticketid FROM tbl_assign_key WHERE  idcard='$rs[idcard]' AND tbl_assign_key.nonactive =  '0'";
	$result_assign = mysql_db_query($dbnameuse,$sql_assign);
	$rsa = mysql_fetch_assoc($result_assign);
	
	$subtract = $rs[sumval];// ค่าคะแนนที่คำนวณได้

	$nump = NumP($rs[staffid],$rs[idcard],$rs[ticketid]);
	$sql_update = "UPDATE validate_checkdata SET validate_checkdata.status_cal='1' ,validate_checkdata.datecal='$datereq1'  WHERE validate_checkdata.idcard='$rs[idcard]' AND validate_checkdata.staffid='$rs[staffid]' AND validate_checkdata.ticketid='$rsa[ticketid]' and status_cal='0'";
	//echo $sql_update."<br>";
	@mysql_db_query($dbnameuse,$sql_update);
	
	$arr_subtract[$rs[staffid]] = $arr_subtract[$rs[staffid]]+$subtract;
	$arr_num_p[$rs[staffid]] = $arr_num_p[$rs[staffid]]+$nump;
		
	}//end while($rs = mysql_fetch_assoc($result)){ 
//}//end foreach($arr_date1 as $keydate => $valdate){

//	echo "<pre>";
//	print_r($arr_subtract);
//	echo "<pre>";
//	print_r($arr_num_p);
//	die;
 $arr_d1 = explode("-",$datereq1);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 คือ เลขสัปดาห์ ของวันจันทร์
 ## 6 คือ เลขสัปดาห์ ของวันเสาร์
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$datereq1");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
				 
				 $xbasedate1 = strtotime("$datereq1");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป


//echo "<pre>";
//print_r($arr_ticketid);
if(count($arr_subtract) > 0){
	foreach($arr_subtract as $key => $val){		
		$group_type = CheckGroupKey($key); // ตรวจสอบกลุ่มการคีย์ข้อมูลถ้าค่า เป็น 1 แสดงว่า เป็น กลุ่ม A และ กลุ่ม B ซึ่งจะนำมาหักตามช่วงเวลาที่กำหนด
		$arrk1 =  FindGroupKeyData($key,$datereq1); 
		$point_ratio = $arrk1['rpoint'];// หาค่าคะแนน Ratio ของคนตามช่วงเวลาที่มีการเปลี่ยนกลุ่มการคีย์ข้อมูล
		 
		if($group_type > 0){
			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p,point_ratio)VALUE('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."','$point_ratio')";
		}else{
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p,point_ratio)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."','$point_ratio')";	
			$str_update = "";
		}//end if($group_type > 0){
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
		$result_select = mysql_db_query($dbnameuse,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
			if($val > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]',point_ratio='$point_ratio' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
				//echo " UP  ::".$sql_insert."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert);
			}//end 	if($val > 0){	
		}else{
				if($val > 0){
					//echo "insert ::".$sql_insert1."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert1);
				}//end if($val > 0){
		}//end if($rs_s[spoint] > 0){

	//	echo"$sql_insert<br>$sql_insert1<hr><hr>";
	}//end foreach($arr_subtract as $key => $val){ 
		
	}//end if(count($arr_subtract) > 0){
		
	}//end 	if($datereq1 != "2010-06-01"){ 
	
}//end function ProcessSubtract($get_date){
#################################################   function ProcessSubtract($get_date){ ########################





function ProcessSubtractByPerson($get_date,$staffid,$typestaff=""){
	global $db_name,$ratio_t1,$ratio_t2,$base_point,$base_point_pm,$point_w;
	
	if($typestaff != ""){ ///ค่าคะแนนของการทำงานของพนักงาน pattimeคือ 120 คะแนน  พนักงานปกติคือ 240 คะแนน
		$base_point = $base_point_pm;// ค่าคะแนนของพนักงาน parttime
	}//end if($typestaff == ""){ //
	
	$dbnameuse = $db_name;
	$datereq1 = $get_date;
	if($datereq1 != "2010-06-01"){ // เนื่องจากวันที่ 1 มีปัญหายังไม่สามารถหาสาเหตุได้ว่าทำมัยข้อมูลวันที่ 1 มิถุนายน ถึงมี จำนวนรายงานถึง 6000 กว่ารายการ
	###  ทำการล้างข้อมูลก่อนคำนวณใหม่
	$sql_clear = "UPDATE validate_checkdata  SET datecal='0000-00-00', status_cal='0' WHERE datecal='$datereq1' and staffid='$staffid'";
	//echo $sql_clear;die;
	mysql_db_query($db_name,$sql_clear);
	###  end  ทำการล้างข้อมูลก่อนคำนวณใหม่
	
	$sql_update = "UPDATE stat_subtract_keyin SET spoint='0',num_p='0' WHERE datekey='$datereq1' and staffid='$staffid' ";
	//echo "$sql_update<br>";
	mysql_db_query($dbnameuse,$sql_update);
	
//$sql = "SELECT
//sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval,
//staffid,idcard
//FROM
//validate_checkdata
//Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
//WHERE qc_date='$datereq1' and staffid='$staffid'
//group by idcard,staffid
//UNION
//SELECT 0,staffid,idcard FROM validate_checkdata 
//WHERE  qc_date='$datereq1' AND result_check='1' AND staffid='$staffid' " ;

$sql = "SELECT
sum(if(tx.mistaken_id='2',t1.num_point*$ratio_t1,t1.num_point*$ratio_t2)) as sumval,
t1.staffid,t1.idcard,t1.ticketid
FROM
validate_checkdata as t1
Inner Join validate_datagroup as tx ON t1.checkdata_id = tx.checkdata_id
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3  ON t1.idcard = t3.idcard AND t1.staffid = t3.staffid
where  t1.qc_date = '$datereq1' and t1.status_process_point='YES' and t1.staffid='$staffid' group by t1.idcard,t1.staffid
UNION
SELECT 0,staffid,idcard,ticketid FROM validate_checkdata 
WHERE  qc_date='$datereq1' AND result_check='1' AND validate_checkdata.status_process_point='YES' ";	

//echo $sql."<br>";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	//$sql_assign = "SELECT tbl_assign_key.ticketid FROM tbl_assign_key WHERE  idcard='$rs[idcard]' AND tbl_assign_key.nonactive =  '0'";
	
	$sql_assign = "SELECT tbl_assign_key.ticketid FROM tbl_assign_key Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
WHERE tbl_assign_sub.staffid='$staffid' AND tbl_assign_key.idcard='$rs[idcard]' AND tbl_assign_key.nonactive='0' ";

	$result_assign = mysql_db_query($dbnameuse,$sql_assign);
	$rsa = mysql_fetch_assoc($result_assign);
	
	$subtract = $rs[sumval];// ค่าคะแนนที่คำนวณได้

	$nump = NumP($rs[staffid],$rs[idcard],$rs[ticketid]); // จำนนวนรายการที่ทำการตรวจเช็ค
	
	$sql_update = "UPDATE validate_checkdata SET validate_checkdata.status_cal='1' ,validate_checkdata.datecal='$datereq1'  WHERE validate_checkdata.idcard='$rs[idcard]' AND validate_checkdata.staffid='$rs[staffid]' AND validate_checkdata.ticketid='$rs[ticketid]' and status_cal='0'";
	//echo $sql_update."<br>";
	@mysql_db_query($dbnameuse,$sql_update);
	
	$arr_subtract[$rs[staffid]] = $arr_subtract[$rs[staffid]]+$subtract;
	$arr_num_p[$rs[staffid]] = $arr_num_p[$rs[staffid]]+$nump;
		
	}//end while($rs = mysql_fetch_assoc($result)){ 
//}//end foreach($arr_date1 as $keydate => $valdate){

//	echo "<pre>";
//	print_r($arr_subtract);
//	echo "<pre>";
//	print_r($arr_num_p);
//	die;
 $arr_d1 = explode("-",$datereq1);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 คือ เลขสัปดาห์ ของวันจันทร์
 ## 6 คือ เลขสัปดาห์ ของวันเสาร์
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$datereq1");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
				 
				 $xbasedate1 = strtotime("$datereq1");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป


//echo "<pre>";
//print_r($arr_ticketid);
if(count($arr_subtract) > 0){
	foreach($arr_subtract as $key => $val){		
		$group_type = CheckGroupKey($key); // ตรวจสอบกลุ่มการคีย์ข้อมูลถ้าค่า เป็น 1 แสดงว่า เป็น กลุ่ม A และ กลุ่ม B ซึ่งจะนำมาหักตามช่วงเวลาที่กำหนด
		$arrk1 =  FindGroupKeyData($key,$datereq1); // หาค่าคะแนน Ratio ของคนตามช่วงเวลาที่มีการเปลี่ยนกลุ่มการคีย์ข้อมูล
		$point_ratio = $arrk1['rpoint'];
		 
		if($group_type > 0){
			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p,point_ratio)VALUE('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."','$point_ratio')";
		}else{
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p,point_ratio)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."','$point_ratio')";	
			$str_update = "";
		}//end if($group_type > 0){
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
		$result_select = mysql_db_query($dbnameuse,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
			if($val > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]',point_ratio='$point_ratio' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
				//echo " UP  ::".$sql_insert."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert);
			}//end 	if($val > 0){	
		}else{
				if($val > 0){
					//echo "insert ::".$sql_insert1."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert1);
				}//end if($val > 0){
		}//end if($rs_s[spoint] > 0){

	//	echo"$sql_insert<br>$sql_insert1<hr><hr>";
	}//end foreach($arr_subtract as $key => $val){ 
		
	}//end if(count($arr_subtract) > 0){
		
	}//end 	if($datereq1 != "2010-06-01"){ 
	
	##############  เก็บค่าคะแนน incentive เว็นในฐานข้อมูล
	CalAddPointIncentive($staffid,$get_date,$typestaff);
	
}//end function ProcessSubtractByPerson($get_date){






###  funciton หาคะแนนสะสมล่าสุด
function SumPointAdd($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);// 	
	$yymm = $arrxd[0]."-".$arrxd[1]; // เดือนที่ทำการคิดค่า incentive
	$sqlcount = "SELECT COUNT(staffid) as numid FROM stat_incentive_temp  WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND  datekeyin < '$get_date' GROUP BY staffid";
	$resultcount = mysql_db_query($dbnameuse,$sqlcount);
	$rsc = mysql_fetch_assoc($resultcount);// ตรวจสอบว่าเดือนนั้นมีการบันทึกค่าคะแนนสะสมหรือยัง	
	if($rsc[numid] > 0){ // แสดงว่าเดือนนั้นมีการจัดเก็บค่าคะแนนไปแล้ว
			$sql1 = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND net_point <> 0 ORDER BY datekeyin DESC LIMIT 1";	
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$stat_val = $rs1[net_point];
	}else{
			$stat_val = 0;
	}
	
	return $stat_val;
}// end function SumPointAdd($get_staffid,$get_date){
####  end 

	function GetSubtractPoint($get_date,$get_staffid,$ratio=""){
		global $dbnameuse;
		
		$kgroup = GetKeyinGroupDate($get_staffid,$get_date);
		$ratio_point = intval(CheckGroupKeyRatio($get_staffid,$get_date));// ค่าถ่วงน้ำหนักการ QC ของแต่ละกลุ่ม 
		$sqlS = "SELECT spoint,point_ratio  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		####  
		if($ratio != "" and $ratio > 0){
			$rpoint = $ratio;	
		}else if($rsS[point_ratio] > 0){
			$rpoint = $rsS[point_ratio];	
		}else{
			$rpoint = $ratio_point;
		}
		
		return ($rsS[spoint]*$rpoint);

}//end 	function GetSubtractPoint($get_date,$get_staffid){







###########################################  function ในการคำนวณค่าคะแนนสะสมใหม่ ###################################
function CalAddPointIncentive($staffid,$datekey,$typestaff=""){
	global $dbnameuse,$base_point,$base_point_pm,$point_w;
	
	if($typestaff != ""){ ///ค่าคะแนนของการทำงานของพนักงาน pattimeคือ 120 คะแนน  พนักงานปกติคือ 240 คะแนน
		$base_point = $base_point_pm;// ค่าคะแนนของพนักงาน parttime
	}//end if($typestaff == ""){ //
	
	$date_show = DateSaveDB($sdate);
	$date_sub = substr($date_show,0,7); // แสดงข้อมูล่าเป็นปีและเดือนอะไร
	$sql = "DELETE  FROM stat_incentive_temp WHERE datekeyin LIKE '$date_sub%' AND datekeyin >='$date_show' AND staffid='$staffid'";
	mysql_db_query($dbnameuse,$sql);
	$sql1 = "DELETE FROM stat_incentive WHERE  datekeyin LIKE '$date_sub%' AND datekeyin >= '$date_show' AND staffid='$staffid'";
	mysql_db_query($dbnameuse,$sql1);
	
	$sql_sel = "SELECT
stat_user_keyin.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numkpoint,
stat_user_keyin.keyin_group,
stat_user_keyin.rpoint,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE
stat_user_keyin.datekeyin LIKE '$date_sub%' AND stat_user_keyin.datekeyin >= '$date_show' AND keystaff.staffid='$staffid' ORDER BY stat_user_keyin.datekeyin ASC";
	$result_sel = mysql_db_query($dbnameuse,$sql_sel);
	while($rsv = mysql_fetch_assoc($result_sel)){
			## ทำการบันทึกข้อมูลใส่ตาราง temp ก่อนนำมาคำนวณยอดสะสม
			$numkpoint = $rsv[numkpoint];  // ค่าคะแนนที่บันทึกได้		

			$arrxd = ShowSdateEdate($rsv[datekeyin]); // หาช่วงวันที่ของสัปดาห์นั้นๆ
			  
			 $kpoint_add = CutPoint($numkpoint-$base_point);  // ค่าคะแนนส่วนเพิ่ม
			  
				  if($kpoint_add < 0){
					  $kpoint_add = 0;
				  }else{
					  $kpoint_add = $kpoint_add;
				  }//end   if($kpoint_add < 0){
			  
			  $point_add1 = SumPointAdd($rsv[staffid],$rsv[datekeyin]); // คะแนนส่วนเพิ่มสะสม
			  $kpoint_stat = CutPoint($kpoint_add+$point_add1); // คะแนนสะสมรวม
			  
			  $subtract  =  GetSubtractPoint($rsv[datekeyin],$rsv[staffid],"$rsv[rpoint]"); // ค่าคะแนน ลบ
			  $subtract = CutPoint($subtract);
			  					
			  $netval  =  $kpoint_stat-$subtract;
			  //$netval = CutPoint($kpoint_stat-$subtract);
			  $incentive = CutPoint($netval*$point_w);  // ค่าincentive สุทธิ
			  
			  $sql_temp = "REPLACE INTO stat_incentive_temp SET staffid='$rsv[staffid]',datekeyin='$rsv[datekeyin]',numkpoint='$numkpoint',kpoint_add='$kpoint_add',kpoint_stat='$kpoint_stat',subtract='$subtract',net_point='$netval',incentive='$incentive',start_date='$arrxd[start_date]',end_date='$arrxd[end_date]'";
			  //echo "$sql_temp<br>";
			  $result_temp = mysql_db_query($dbnameuse,$sql_temp);
			  ###  ทำการเก็บค่าคะแนนไว้ในข้อมูลจริงด้วย
			  
			  if($result_temp){
			  	$sql_replace = "REPLACE INTO stat_incentive(staffid,datekeyin,staff_approve,status_approve,subtract,net_point,incentive,kpoint_add,kpoint_stat,numkpoint)VALUES('$rsv[staffid]','$rsv[datekeyin]','".$_SESSION['session_staffid']."','1','$subtract','$netval','$incentive','$kpoint_add','$kpoint_stat','$numkpoint')";
				//echo $sql_replace."<br><br>";
				mysql_db_query($dbnameuse,$sql_replace);		
			  }//end   if($result_temp){
			  
	}//end while($rss = mysql_fetch_assoc($result_sel)){
}// end function CalAddPointIncentive($staffid,$datekey){
###############  end คำนวณค่าคะแนน ใหม่ #########################################


######################  function ในการ จัดเก็บค่าคะแนนการคีย์รายชุดในแต่ วัน เก็บไว้เป็นยอดสรุป ##########################
function SumPointKeyPerPerson($staffid,$yymm){
	global $dbnameuse;
	$sql = "SELECT
stat_user_keyperson.datekeyin,
Sum(numpoint) AS sumpoint,
stat_user_keyin.numkpoint,
Sum(stat_user_keyperson.numkeyin) AS sumkey,
stat_user_keyin.numkeyin
FROM
stat_user_keyperson
Inner Join stat_user_keyin ON stat_user_keyperson.staffid = stat_user_keyin.staffid AND stat_user_keyperson.datekeyin = stat_user_keyin.datekeyin
WHERE stat_user_keyperson.staffid ='$staffid'  and stat_user_keyperson.datekeyin LIKE '$yymm%' 
GROUP BY stat_user_keyperson.datekeyin
order by stat_user_keyperson.datekeyin desc";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[sumpoint] > $rs[numkpoint]){
			$sql_update = "UPDATE stat_user_keyin SET numkpoint='$rs[sumpoint]',numkeyin='$rs[sumkey]' WHERE staffid='$staffid' AND datekeyin='$rs[datekeyin]'";	
			//echo "$sql_update<br>";
			mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()." LINE :: ".__LINE__);
		}//end if($rs[sumpoint] > $rs[numkpoint]){
			
	}// end while($rs = mysql_fetch_assoc($result)){
		//echo "<br>end ";die;
}//end 


?>