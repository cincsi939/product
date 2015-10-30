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
			include ("epm_report.inc.php")  ;
			include("function_face2cmss.php");
			include("function_date.php");
			include("function_get_data.php");
			
			if($profile_id == ""){
					$profile_id = 5;
			}
			
			$start_project = "2011-02-01"; // วันเริ่มทำสัญญาโครงการ
			$end_date_project = "2011-12-20"; 	## วันสิ้นสุดโครงการ
			$curent_date_project = date("Y-m-d"); // วันที่ปัจจุบันของโครงการ
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$arrsite = GetSiteKeyData();
			$numHoliday = GetNumHoliday($curent_date_project,$end_date_project); // นับจำนวนวันหยุด
			$numHoliday_s = GetNumHoliday($start_project,$curent_date_project); // นับจำนวนวันหยุดก่อนวันปัจจุบัน
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			### นับจำนวนวันที่เหลือของโครงการโดยยังไม่หักวันหยุด
			$numdayproject = GetNumDayOfDate($curent_date_project,$end_date_project)-$numHoliday; // ระยะเวลาคงเหลือ
			$numdayproject_s  = GetNumDayOfDate($start_project,$curent_date_project)-$numHoliday_s; // ระยะเวลาที่คีย์ข้อมูลไปแล้ว
			
			//$num_approve = GetNumKeyApprove($profile_id); // จำนวนที่คีย์และรับรองข้อมูลไปแล้ว
			//$num_kp7all = GetNumKp7All($profile_id); // จำนวนบุคลากรทั้งหมด
			
			
			$num_kp7all = GetNumKp7Allv1($profile_id,"NEW"); // ข้อมูลทั้งหมดใหม่
			$num_kp7all_old = GetNumKp7Allv1($profile_id,""); // ข้อมูลทั้งหมดใหม่
			$num_approve = GetNumKeyApproveSite("NEW"); // เขตใหม่ที่ทำข้อมูล
			$num_approve_old = GetNumKeyApproveSite(""); // เขตต่อเนื่องที่ทำข้อมูล
			
			
			if($compare_id == ""){
					$compare_id = 2;
			}
			
			if($mm1 == ""){
					$mm1 = intval(date("m"))-1;
			}
			if($mm2 == ""){
					$mm2 = intval(date("m"));	
			}
			if($yy1 == ""){
					$yy1 = date("Y")+543;
			}
			
			if($yy2 == ""){
					$yy2 = date("Y")+543;
			}
			
			if($site_id == ""){
				$site_id = "999";
			}

			
			  $date_dis = (date("Y")+543)-2; // ปีย้อนหลัง
			 $idcard_ex = GetCard_idExcerent();// เลขบัตรประจำตัวประชาชนของกลุ่ม excerent
			 
	############################# function แสดงผลผลิตต่อกลุ่ม #####################	 
	function GetDataGroupE($site_id,$compare_id,$date1,$date2="",$ctype="0"){ // $ctype = 1 คือเดือนปัจจุบัน 0 คือเดือนที่ผ่านมา
		global $dbnameuse,$idcard_ex,$point_per_doc;
		$temp_date = $date1."-01";
		$end_date = GetdateEnd($temp_date);
		//echo "temp_date : $temp_date :: end : ".$end_date;die;
		if($compare_id == "2"){
			$conid = " AND t2.datekeyin LIKE '$date1%'";
				if($ctype == "0"){ // เดือนก่อนหน้า
					$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."-01' and  t1.start_date between '".$date1."-01' and '".$end_date."'))";
				}else{ // เดือนปัจจุบัน
					$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";	
				}// end 	if($ctype == "0"){ 
			
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
			//$conid_staff = " AND t1.start_date between '$date1' AND '$date2'";
			if($ctype == "0"){ // เดือนก่อนหน้า
				$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."' and  t1.start_date between '".$date1."' and '".$date2."'))";
			}else{
				$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";	
			}
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}//end if($compare_id == "2"){
				if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
			
	$sql = "SELECT count(distinct t1.staffid) as numstaff FROM keystaff as t1  WHERE   t1.keyin_group='2' and t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0'   $conid_staff $con1 GROUP BY  t1.keyin_group";
	//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


$sql2 = "SELECT 
count(distinct t2.datekeyin) as numday,
sum(t2.numkpoint) as numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint
FROM
keystaff as t1 Inner Join 
stat_user_keyin as t2  ON t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
	$arr['numday'] = $rs2[numday];
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	$arr['sub_numpoint'] = $rs2[sub_numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){
		
function GetDataGroupL($site_id,$compare_id,$date1,$date2="",$ctype="0"){ // 1 คือเดือนปัจจุบัน
		global $dbnameuse,$idcard_ex,$point_per_doc;
		$temp_date = $date1."-01";
		$end_date = GetdateEnd($temp_date);
		if($compare_id == "2"){
			$conid = "AND t2.datekeyin LIKE '$date1%'";
				if($ctype == "0"){ // ข้อมูลในเดือนก่อนหน้า
					$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."-01' and  t1.start_date between '".$date1."-01' and '".$end_date."'))";
				}else{// ข้อมูลในปัจจุบัน
					$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";
				}//end if($ctype == "0"){
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = "AND t2.datekeyin between '$date1' AND '$date2'";	
			//$conid_staff = " AND t1.start_date between '$date1' AND '$date2' ";
			
			if($ctype == "0"){ // ข้อมูลในเดือนก่อนหน้า
				$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."' and  t1.start_date between '".$date1."' and '".$date2."'))";
			}else{
				$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";
			}
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}//end if($compare_id == "2"){
			
						


			
			if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
	
	$sql = "SELECT count(distinct t1.staffid) as numstaff FROM
 keystaff as t1 where  t1.keyin_group='2' and t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0'  $conid_staff $con1
group by  t1.keyin_group";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


$sql2 = "SELECT
count(distinct t2.datekeyin) as numday,
sum(t2.numkpoint) as numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
	
	$arr['numday'] = $rs2[numday];
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	$arr['sub_numpoint'] = $rs2[sub_numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){

function GetDataGroupN($site_id,$compare_id,$date1,$date2="",$ctype="0"){
	global $dbnameuse,$point_per_doc;
	$temp_date = $date1."-01";
	$end_date = GetdateEnd($temp_date);
	if($compare_id == "2"){
		$conid = " AND t2.datekeyin LIKE '$date1%'";
		if($ctype == "0"){
			$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."-01' and  t1.start_date between '".$date1."-01' and '".$end_date."'))";
		}else{
			$conid_staff = " AND ((t1.start_date <= '".$date1."-31' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";	
		}//end if($ctype == "0"){
	}else{
		$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
		if($ctype == "0"){
			$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$date1."' and  t1.start_date between '".$date1."' and '".$date2."'))";
		}else{
			$conid_staff = " AND ((t1.start_date <= '".$date2."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";	
		}
	}//end if($compare_id == "2"){
					if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
	
	


$sql = "SELECT
count(distinct t2.datekeyin) as numday,
t1.ratio_id as rpoint,
sum(t2.numkpoint) as numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='3' and t1.period_time='am'  $conid $con1	
group by 
t1.ratio_id";
//echo $sql."<hr>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[rpoint]]['numday'] = $rs[numday];
	$arr[$rs[rpoint]]['numpoint'] = $rs[numpoint];
	$arr[$rs[rpoint]]['sub_numpoint'] = $rs[sub_numpoint];
	
}//end while($rss = mysql_fetch_assoc($result_staff)){
	
	
		$sql2 = "SELECT
		t1.ratio_id as rpoint,
		count(distinct t1.staffid) as numstaff
FROM
 keystaff as t1 where  t1.keyin_group='3' and t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0'   $conid_staff  $con1
group by t1.ratio_id";
//echo $sql2."<br>";
	$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs2 = mysql_fetch_assoc($result2)){
		$arr[$rs2[rpoint]]['numstaff'] = $rs2[numstaff]	;
	}


	//echo "<pre>";
	//print_r($arr);
	
	return $arr;		
}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){




########################################################################################################

        	if($compare_id == "1"){
				$date1 = ThaiDate2DBDate($s_data1);
				$date2 = ThaiDate2DBDate($s_data2);
				$date3 = ThaiDate2DBDate($e_data1);
				$date4 = ThaiDate2DBDate($e_data2);
				
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date3,$date4,"1"); // กลุ่ม E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date3,$date4,"1"); // กลุ่ม L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date3,$date4,"1"); // กลุ่ม N
				
				$condate1 = $date1."||".$date2;
				$condate2 = $date3."||".$date4;
				
					$xhead = " รายงานเปรียบเทียบผลผลิตระหว่างวันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2)." เปรียบเทียบกับ ".DBThaiLongDateFull($date3)." ถึง ".DBThaiLongDateFull($date4)." ".$arrsite[$site_id];
					$sub_h1 = "วันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2);
					$sub_h2 =  "วันที่ ".DBThaiLongDateFull($date3)." ถึง ".DBThaiLongDateFull($date4);
			}else{
					$cmm = intval(date("m"));
					$cyy = intval(date("Y")+543);
					$cdd = intval(date("d"));
					if($cmm == $mm1 and $cyy == $yy1){
						$hsub1 = "ข้อมูลวันที่ 1 ถึงวันที่ $cdd";	
					}else{
						$hsub1 = "";
					}// end if($cmm == $mm1 and $cyy == $yy1){
					if($cmm == $mm2 and $cyy == $yy2){
						$hsub2 = "ข้อมูลวันที่ 1 ถึงวันที่ $cdd";	
					}else{
						$hsub2 = "";
					}//end if($cmm == $mm2 and $cyy == $yy2){
					$xhead = " รายงานเปรียบเทียบผลผลิตระหว่างเดือน  ".$monthname[$mm1]." พ.ศ. ".$yy1." เปรียบเทียบกับ ".$monthname[$mm2]." พ.ศ. ".$yy2." ".$arrsite[$site_id];	
					$sub_h1 = $hsub1." เดือน  ".$monthname[$mm1]." พ.ศ. ".$yy1;
					$sub_h2 = $hsub2." เดือน  ".$monthname[$mm2]." พ.ศ. ".$yy2;
				
					
					
					$month_val1 = sprintf("%02d",$mm1);
					$month_val2 = sprintf("%02d",$mm2);
					$year_val1 = $yy1-543;
					$year_val2 = $yy2-543;
					$date1 = $year_val1."-".$month_val1;
					$date2 = $year_val2."-".$month_val2;
					
					$condate1 = $date1;
					$condate2 = $date2;
					//echo $date1." :: ".$date2;
					
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,"","0"); // กลุ่ม E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date2,"","1"); // กลุ่ม E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,"","0"); // กลุ่ม L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date2,"","1"); // กลุ่ม L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,"","0"); // กลุ่ม N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date2,"","1"); // กลุ่ม N

					
			}
			
			
		###########  การแสดงข้อมูล ################
		
		                     $sql = "SELECT * FROM keystaff_group_report ORDER BY orderby ASC";
							$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
							$arr_show = array();
							while($rs = mysql_fetch_assoc($result)){

								if($rs[groupreport_id] == "1"){
										$staff_val1 = $arr_e['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_e1['numstaff'];
										$numpoint_val1 = ($arr_e['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numpoint_val2 = ($arr_e1['numpoint'])/$point_per_doc;
										$numdaykey1 = $arr_e['numday']; // จำนวนวันคีย์ข้อมูล
										$numdaykey2 = $arr_e1['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1; // จำนวนเฉลี่ยต่อวัน
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2; // จำนวนชุดเฉลี่ยต่อวันต่อคน
										}
										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
								}//if($rs[groupreport_id] == "1"){
									
								else if($rs[groupreport_id] == "2"){
										
										$staff_val1 = $arr_l['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_l1['numstaff'];
										$numpoint_val1 = ($arr_l['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numpoint_val2 = ($arr_l1['numpoint'])/$point_per_doc;
										$numdaykey1 = $arr_l['numday']; // จำนวนวันคีย์ข้อมูล
										$numdaykey2 = $arr_l1['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1;
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2;
										}

										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
								}//end else if($rs[groupreport_id] == "1"){
									
								else{
										
										$staff_val1 = $arr_n[$rs[r_point]]['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_n1[$rs[r_point]]['numstaff'];
										
										$numdaykey1 = $arr_n[$rs[r_point]]['numday']; // จำนวนวันคีย์ข้อมูล
										$numdaykey2 = $arr_n1[$rs[r_point]]['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_val1 = ($arr_n[$rs[r_point]]['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										}//end if($staff_val1 > 0){
										if($staff_val2 > 0){
											$numpoint_val2 = ($arr_n1[$rs[r_point]]['numpoint'])/$point_per_doc;
										}//end if($staff_val2 > 0){
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1;
										}// end if($staff_val1 > 0){
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2;
										}//end if($staff_val2 > 0){
										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
	
									}//end else($rs[groupreport_id] == "3"){
						################  เก็บค่าไว้ในตัวแปร array
						$arr_show[$rs[groupreport_id]]['groupname'] = $rs[groupreport_name];
						$arr_show[$rs[groupreport_id]]['numstaff1'] = $staff_val1;
						$arr_show[$rs[groupreport_id]]['numstaff2'] = $staff_val2;
						$arr_show[$rs[groupreport_id]]['numpoint1'] = $numpoint_val1;
						$arr_show[$rs[groupreport_id]]['numpoint2'] = $numpoint_val2;
						$arr_show[$rs[groupreport_id]]['numpoint_avg1'] = $numpoint_avg1;
						$arr_show[$rs[groupreport_id]]['numpoint_avg2'] = $numpoint_avg2;
						$arr_show[$rs[groupreport_id]]['staff_pd'] = $staff_pd; // จำนวนคนบวกลบ
						$arr_show[$rs[groupreport_id]]['numpoint_pd'] = $numpoint_pd; // คะแนนบวกลบ
						$arr_show[$rs[groupreport_id]]['numavg_pd'] = $numavg_pd; // คะเฉลี่ยบวกลบ
						$arr_show[$rs[groupreport_id]]['r_point'] = $rs[r_point]; // คะเฉลี่ยบวกลบ
						
						
							$staff_val1 = 0;
							$numpoint_val1 = 0;
							$numpoint_avg1 = 0;
							$staff_val2 = 0;
							$staff_pd = 0;
							$numpoint_val2 = 0;
							$numpoint_pd = 0;
							$numpoint_avg2 = 0;
							$numavg_pd = 0;

		}//end while($rs = mysql_fetch_assoc($result)){


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	


function CheckForm(){
	
if(document.form1.compare_id1.checked == true){
	var d1 = document.form1.s_data1.value;
	var d2 =  document.form1.s_data2.value;
	var d3 =  document.form1.e_data1.value
	var d4 = document.form1.e_data2.value
	// วันที่ที่ 1
	arr1 = d1.split("/");
	v1 = arr1[2]+""+arr1[1]+""+arr1[0];
	// วันที่ที่ 2
	arr2 =  d2.split("/");
	v2 = arr2[2]+""+arr2[1]+""+arr2[0];
	
	arr3 =  d3.split("/");
	v3 = arr3[2]+""+arr3[1]+""+arr3[0];
	
	arr4 =  d4.split("/");
	v4 = arr4[2]+""+arr4[1]+""+arr4[0];
		if(v2 < v1){
				alert("วันที่สิ้นสุดส่วนหน้าต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		if(v4 < v3){
				alert("วันที่สิ้นสุดส่วนหลังต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		
	return true;	
	}else if(document.form1.compare_id2.checked == true){
	var m1 = document.form1.mm1.value;
	var y1 =  document.form1.yy1.value;
	var m2 =  document.form1.mm2.value
	var y2 = document.form1.yy2.value	
		val1 = y1+""+m1;
		val2 = y2+""+m2;
		if(val2 < val1){
				alert("เดือนปีสิ้นสุดต้องไม่น้อยกว่าเดือนปีเริ่มต้น");
				document.form1.yy2.focus();
				return false
		}
			
		return true;
	}//end if(document.form1.compare_id1.checked == true){
		
}//end function CheckForm(){
	

function CheckR1(){
		document.form1.compare_id1.checked = true;
}

function CheckR2(){
		document.form1.compare_id2.checked = true;
}

</script>

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48"><img src="../../images_sys/banner_report.jpg" width="100%" height="177"></td>
        </tr>
        <form name="form1" method="post" action="" onSubmit="return CheckForm()">
		   <tr>
		     <td bgcolor="#CCCCCC" >&nbsp;</td>
	      </tr>
		   <tr>
          <td bgcolor="#CCCCCC" ><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="19%" rowspan="3" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                      <td colspan="2" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ทั้งหมด<br>
(คน)</strong></td>
                      <td colspan="10" align="center" bgcolor="#A5B2CE"><strong>สรุปภาพรวมการจัดทำข้อมูลปฐมภูมิ</strong></td>
                      </tr>
                    <tr>
                      <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>บันทึกข้อมูลแล้ว</strong></td>
                  <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>คงเหลือ</strong></td>
                  <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อวันของข้อมูลใหม่(คน)</strong></td>
                </tr>
                <tr>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>ข้อมูลใหม่</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>ข้อมูลต่อเนื่อง</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>รวม</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>ข้อมูลใหม่</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ข้อมูลต่อเนื่อง</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ร้อยละ</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>คน</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ร้อยละ</strong></td>
                  <td width="7%" align="center" bgcolor="#A5B2CE"><strong>จำนวนวัน</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>เป้าหมาย</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ทำได้</strong></td>
                  <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
                </tr>
                <?
                	if(count($arr_show) > 0){		
						foreach($arr_show as $key1 => $val1){		
						$exsum_workkey = $exsum_workkey+($val1['numpoint_avg2']*$val1['numstaff2']);
						}//end foreach($arr_show as $key => $val){		
					}//end 	if(count($arr_show) > 0){		
					
					
					$numkey_all = $num_approve+$num_approve_old;
					$numkey1 = (($num_kp7all-$num_approve)/$numdayproject); // ข้อมูลเป้าหมาย
					$numkey_pass = $exsum_workkey-$numkey1; // จำนวนบวกลบ
					
				?>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><strong>จำนวนข้าราชการครูและบุคลากรทางการศึกษา</strong></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($num_kp7all)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($num_kp7all_old)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($numkey_all)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($num_approve )?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($num_approve_old)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format(($num_approve*100)/$num_kp7all,2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($num_kp7all-$num_approve)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format((($num_kp7all-$num_approve)*100)/$num_kp7all,2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=$numdayproject?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($numkey1,2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format(($exsum_workkey),2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><? if($numkey_pass < 0){ echo "<font color=\"#CC0000\">".number_format($numkey_pass,2)."</font>"; }else{ echo number_format($numkey_pass,2);}?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" > &nbsp;&nbsp; ข้อมูล ณ วันที่ <? $tempdate = (date("Y")+543)."-".date("m-d"); echo MakeDate($tempdate);?>&nbsp;&nbsp;&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;&nbsp;<a href="#" onClick="window.open('popup_endproduct.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=800,height=550');"><img src="../../images_sys/gear_replace.gif"  width="20" height="16" border="0" title="คลิ๊กเพื่อค้นหาสถิติข้อมูล"></a>&nbsp;&nbsp;&nbsp;</td>
	      </tr>
        </form>

		   <tr>
		     <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td width="3%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
		                   <td width="18%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
		                   <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h1?>
	                        </strong></td>
		                   <td colspan="6" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h2?>
	                        </strong></td>
		                   </tr>
		                 <tr>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวน (คน)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
		                   <td width="12%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อคนต่อวัน(ชุด)</strong></td>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวน (คน)</strong></td>
		                   <td width="6%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="11%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
		                   <td width="6%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="11%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อคนต่อวัน(ชุด)</strong></td>
		                   <td width="5%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   </tr>
                           <?
				if(count($arr_show) > 0){		
				$i=0;
					foreach($arr_show as $key => $val){		
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}			
					$rpoint = 	$val['r_point'];						
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><?=$val['groupname']?></td>
		                   <td align="center"><? if($val['numstaff1'] > 0){ echo "<a href='report_key_endproduct_detail_new.php?groupreport_id=$key&xtype=1&site_id=$site_id&rpoint=$rpoint&condate=$condate1' target='_blank'>".number_format($val['numstaff1'])."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($val['numpoint1'],2)?></td>
		                   <td align="center"><?=number_format($val['numpoint_avg1'],2)?></td>
		                   <td align="center"><? if($val['numstaff2']  > 0){ echo "<a href='report_key_endproduct_detail_new.php?groupreport_id=$key&xtype=2&site_id=$site_id&rpoint=$rpoint&condate=$condate2' target='_blank'>".number_format($val['numstaff2'])."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><? if($val['staff_pd'] < 0){ echo "<font color=\"#CC0000\"><a href='report_key_endproduct_detail_diff_new.php?groupreport_id=$key&xtype=3&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&r=N&numstaff=".$val['staff_pd']."' target='_blank' style=\"color:#F00000\">".number_format($val['staff_pd'])."</a></font>";}else if($val['staff_pd'] > 0){ echo "<a href='report_key_endproduct_detail_diff_new.php?groupreport_id=$key&xtype=3&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&r=Y&numstaff=".$val['staff_pd']."' target='_blank'>".number_format($val['staff_pd'])."</a>"; }else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($val['numpoint2'],2)?></td>
		                   <td align="center"><? if($val['numpoint_pd'] < 0){ echo "<font color=\"#CC0000\">".number_format($val['numpoint_pd'],2)."</font>";}else{ echo number_format($val['numpoint_pd'],2);}?></td>
		                   <td align="center"><?=number_format($val['numpoint_avg2'],2)?></td>
		                   <td align="center"><? if($val['numavg_pd'] < 0){ echo "<font color=\"#CC0000\">".number_format($val['numavg_pd'],2)."</font>";}else{ echo number_format($val['numavg_pd'],2); }?></td>
		                   </tr>
                           <?
						   	$num1 += $val['numstaff1'];
							$num2 += $val['numpoint1'];
							$num3 += $val['numpoint_avg1'];
							$num4 += $val['numstaff2'];
							$num5 += $val['staff_pd'];
							$num6 += $val['numpoint2'];
							$num7 += $val['numpoint_pd'];
							$num8 += $val['numpoint_avg2'];
							$num9 += $val['numavg_pd'];
							
							
							
							
							}// end 	foreach($arr_show as $key => $val){	
					}// end 	if(count($arr_show) > 0){		
						   ?>
		                 <tr>
		                   <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม :</strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num1)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num2,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num3/5,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num4)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <? if($num5 < 0){ echo "<font color=\"#CC0000\">".number_format($num5)."</font>";}else{ echo number_format($num5);}?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num6,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <? if($num7 < 0){ echo "<font color=\"#CC0000\">".number_format($num7,2)."</font>";}else{ echo number_format($num7,2);}?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num8/5,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <? if($num9 < 0){ echo "<font color=\"#CC0000\">".number_format($num9/5,2)."</font>";}else{ echo number_format($num9/5,2); }?>
		                   </strong></td>
		                   </tr>
	                    </table></td>
                     </tr>
	                </table>
	             </td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
