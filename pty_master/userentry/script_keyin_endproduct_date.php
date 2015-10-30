<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "crontab";
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

#Begin Check stop Script
$dateTime = intval(date("H"));
if( ($dateTime >= 4 && $dateTime <= 4 )|| $_GET['start']=='on'){
#End Check stop Script

			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm_report.inc.php")  ;
			include("function_face2cmss.php");
			include("function_date.php");
			include("function_get_data.php");
			$time_start = getmicrotime();
			
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

function monthDateEnd($month=""){
	$year = date("Y");
	switch ($month) {
			case 01:
                $maxdays=31;
                break;
            case 01:
                $maxdays=31;
                break;
            case 02:
                $a = $year / 4;
                $b = ceil($a);
                if ($a==$b){                
                     $maxdays=29;
                } else {
                      $maxdays=28;
                }
                break;
            case 03:
                $maxdays=31;
                break;
            case 04:
                $maxdays=30;
                break;
            case 05:
                $maxdays=31;
                break;
            case 06:
                $maxdays=30;
                break;
            case 07:
                $maxdays=31;
                break;
            case 08:
                $maxdays=31;
                break;
            case 09:
                $maxdays=30;
                break;
            case 10:
                $maxdays=31;
                break;
            case 11:
                $maxdays=30;
                break;
            case 12:
                $maxdays=31;
                break;
        }
		return  $maxdays;
}

function getWeek($week=""){
	$day = date("d");
	$month = date("m");
	$year = date("Y")+543;
	$my = "/".$month."/".$year;
	$arr_date = array();
	if($week==1 || $day<=7){
		$arr_date[0] = "01".$my;
		$arr_date[1] = "07".$my;
	}else if($week==2 || $day<=15){
		$arr_date[0] = "08".$my;
		$arr_date[1] = "15".$my;
	}else if($week==3 || $day<=23){
		$arr_date[0] = "16".$my;
		$arr_date[1] = "23".$my;
	}else if($week==4 || $day>=24){
		$arr_date[0] = "24".$my;
		$arr_date[1] = monthDateEnd($month).$my;
	}
	return $arr_date;
}


########################################################################################################

#Begin set value 
$site_id = "999";
$compare_id = 1;
$arrw = getWeek();
$s_data1 = $arrw[0];
$s_data2 = $arrw[1];
#End set value



        	if($compare_id == "1"){
				$date1 = ThaiDate2DBDate($s_data1);
				$date2 = ThaiDate2DBDate($s_data2);
				
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,$date2,"0"); // กลุ่ม N
				
				$condate1 = $date1."||".$date2;
				
					$xhead = " รายงานเปรียบเทียบผลผลิตระหว่างวันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2);
					$sub_h1 = "วันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2);
			}
			
			
		###########  การแสดงข้อมูล ################
		
		                     $sql = "SELECT * FROM keystaff_group_report ORDER BY orderby ASC";
							$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
							$arr_show = array();
							while($rs = mysql_fetch_assoc($result)){

								if($rs[groupreport_id] == "1"){
										$staff_val1 = $arr_e['numstaff']; // จำนวนพนักงานทั้งหมด
										$numpoint_val1 = ($arr_e['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numdaykey1 = $arr_e['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1; // จำนวนเฉลี่ยต่อวัน
										}
										
										
								}//if($rs[groupreport_id] == "1"){
									
								else if($rs[groupreport_id] == "2"){
										
										$staff_val1 = $arr_l['numstaff']; // จำนวนพนักงานทั้งหมด
										$numpoint_val1 = ($arr_l['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numdaykey1 = $arr_l['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1;
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2;
										}

								}//end else if($rs[groupreport_id] == "1"){
									
								else{
										
										$staff_val1 = $arr_n[$rs[r_point]]['numstaff']; // จำนวนพนักงานทั้งหมด
										$numdaykey1 = $arr_n[$rs[r_point]]['numday']; // จำนวนวันคีย์ข้อมูล
										if($staff_val1 > 0){
											$numpoint_val1 = ($arr_n[$rs[r_point]]['numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										}//end if($staff_val1 > 0){
										
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1;
										}// end if($staff_val1 > 0){
										
										
									}//end else($rs[groupreport_id] == "3"){
						################  เก็บค่าไว้ในตัวแปร array
						$arr_show[$rs[groupreport_id]]['groupname'] = $rs[groupreport_name];
						$arr_show[$rs[groupreport_id]]['numstaff1'] = $staff_val1;
						$arr_show[$rs[groupreport_id]]['numpoint1'] = $numpoint_val1;
						$arr_show[$rs[groupreport_id]]['numpoint_avg1'] = $numpoint_avg1;
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

		$numkey1 = (($num_kp7all-$num_approve)/$numdayproject); // ข้อมูลเป้าหมาย
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48"><img src="../../images_sys/banner_report.jpg" width="100%" height="177"></td>
        </tr>
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
		                   </tr>
		                 <tr>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวน (คน)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
		                   <td width="12%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อคนต่อวัน(ชุด)</strong></td>
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
		                   <td align="center"><? echo number_format($val['numstaff1']);?></td>
		                   <td align="center"><?=number_format($val['numpoint1'],2)?></td>
		                   <td align="center"><?=number_format($val['numpoint_avg1'],2)?></td>
		                   </tr>
                           <?
						   	$num1 += $val['numstaff1'];
							$num2 += $val['numpoint1'];
							$num3 += $val['numpoint_avg1'];
	
							
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
		                   </tr>
	                    </table>
                        
                        </td>
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
<?php
$numHoliday_work = GetNumHoliday($date1,$date2); // นับจำนวนวันหยุด
$numday_work = GetNumDayOfDate($date1,$date2);
$numdayproject_work = $numday_work-$numHoliday_work; // ระยะเวลาคงเหลือ
$numkey_target = ($numkey1*$numdayproject_work); // ข้อมูลเป้าหมาย
?>
<table bgcolor="#CCCCCC" align="center">
<TR>
	<td  align="right">วันที่เริ่มต้นจัดเก็บข้อมูล:</td>
    <td><?=$date1?></td>
</TR>
<TR>
     <td  align="right">วันที่สิ้นสุดจัดเก็บข้อมูล:</td>
     <td><?=$date2?></td>
</TR>
<TR>
      <td  align="right">จำนวน (คน):</td>
      <td><?=number_format($num1)?></td>
</TR>
<TR>
      <td  align="right">ผลผลิตรวม(ชุด):</td>
      <td><?=number_format($num2,2)?></td>
</TR>
<TR>
       <td  align="right">ผลผลิตต่อคนต่อวัน(ชุด):</td>
       <td><?=number_format($num3/5,2)?></td>
</TR>
<TR>
       <td  align="right">ทำงาน(วัน):</td>
       <td><?=number_format($numdayproject_work)?></td>
</TR>
<TR>
       <td  align="right">วันหยุด(วัน):</td>
       <td><?=number_format($numHoliday_work)?></td>
</TR>
<TR>
       <td  align="right">เป้าหมาย(ชุด):</td>
       <td><?=number_format($numkey_target,2)?></td>
</TR>
<TR>
        <td  align="right">วันที่-เวลาแก้ไขข้อมูล:</td>
        <td><?=date("Y-m-d H:i:s")?></td>
</TR>
</table>
<?php
connect_db();
$sql_insert = "REPLACE INTO keyin_endproduct_date SET
										start_date='".$date1."',
										end_date='".$date2."',
										num_person='".$num1."',
										num_key='".$num2."',
										num_keytodate='".($num3/5)."',
										num_daywork='".$numdayproject_work."',
										num_holiday='".$numHoliday_work."',
										num_keytarget='".$numkey_target."',
										update_datetime=NOW()
									";
$db_ipad="cmss_ipad";
mysql_db_query($db_ipad, $sql_insert) or die(mysql_error());


?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
}
?>
