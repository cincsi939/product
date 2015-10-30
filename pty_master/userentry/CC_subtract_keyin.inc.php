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
//echo "ปิดการประมวลผล";die;
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include ("../../common/class.time_query.php")  ;		
			$mytime_query->ApplicationName="crontab";	
			$dbnameuse = $db_name;
			$time_start = getmicrotime();

			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");





	if (!isset($datereq)){
		if(!isset($dd)){
			$dd = date("d");
		}

		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$datereq = "$yy-$mm-$dd";
		//$datereq1 = ($yy-543)."-$mm-$dd";
	}




//$datereq1 = "2010-02-01";
  $datereq1 = $datereq;
  $xbasedate = strtotime("$datereq1");
  $xdate = strtotime("-1 day",$xbasedate);
  $xsdate = date("Y-m-d",$xdate);// วันถัดไป
  $datereq1 = $xsdate;

/*$sql = "SELECT 
t1.idcard,
t1.staffid,
t2.ticketid
FROM
monitor_keyin AS t1
Inner Join tbl_assign_key AS t2 ON t1.idcard = t2.idcard
Inner Join tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid AND t1.staffid = t3.staffid and t1.staffid <> '' and t1.staffid IS NOT NULL
WHERE
t2.nonactive =  '0' AND  t1.timeupdate like '$datereq1%'
GROUP BY t1.idcard";*/

$sql = "SELECT
t1.idcard,
t1.staffid,
t1.ticketid
FROM
validate_checkdata as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3  ON t1.idcard = t3.idcard AND t1.staffid = t3.staffid
where
 t3.timeupdate like '$datereq1%'and t1.status_process_point='YES'  group by t1.idcard ";

//echo $dbnameuse."<br>".$sql;die;
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$subtract = CalSubtract($rs[idcard],$rs[staffid],$rs[ticketid]); // ค่าคะแนนที่คำนวณได้

	$nump = NumP($rs[staffid],$rs[idcard],$rs[ticketid]);
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
		if($group_type > 0){
			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p)VALUE('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."')";
		}else{
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."')";	
			$str_update = "";
		}//end if($group_type > 0){
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
		$result_select = mysql_db_query($dbnameuse,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
			if($val > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
				echo " UP  ::".$sql_insert."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert);
			}//end 	if($val > 0){	
		}else{
				if($val > 0){
					echo "insert ::".$sql_insert1."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert1);
				}//end if($val > 0){
		}//end if($rs_s[spoint] > 0){

		
	}//end foreach($arr_subtract as $key => $val){ 
		
	}//end if(count($arr_subtract) > 0){
	//}// ed if(!in_array("$datereq1",$arrNotDate){
//}//end foreach($arr_d as $k => $datereq1){
$time_end = getmicrotime();
echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";




 echo "<h1>Done...................";
 ?>