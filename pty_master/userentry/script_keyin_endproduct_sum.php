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
			
			$start_project = "2011-02-01"; // �ѹ��������ѭ���ç���
			$end_date_project = "2011-12-20"; 	## �ѹ����ش�ç���
			$curent_date_project = date("Y-m-d"); // �ѹ���Ѩ�غѹ�ͧ�ç���
			$point_per_doc = 69; // ��Ҥ�ṵ�ͪش
			$arrsite = GetSiteKeyData();
			$numHoliday_all = GetNumHoliday($start_project,$end_date_project); // �Ѻ�ӹǹ�ѹ��ش������
			$numHoliday = GetNumHoliday($curent_date_project,$end_date_project); // �Ѻ�ӹǹ�ѹ��ش
			$numHoliday_s = GetNumHoliday($start_project,$curent_date_project); // �Ѻ�ӹǹ�ѹ��ش��͹�ѹ�Ѩ�غѹ
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			### �Ѻ�ӹǹ�ѹ�������ͧ͢�ç������ѧ����ѡ�ѹ��ش
			$numdayproject_all = GetNumDayOfDate($start_project,$end_date_project); // �������ҷ�����
			$numdayproject = GetNumDayOfDate($curent_date_project,$end_date_project)-$numHoliday; // �������Ҥ������
			$numdayproject_s  = GetNumDayOfDate($start_project,$curent_date_project)-$numHoliday_s; // �������ҷ���������������
			
			$num_approve = GetNumKeyApprove($profile_id); // �ӹǹ����������Ѻ�ͧ�����������
			$num_kp7all = GetNumKp7All($profile_id); // �ӹǹ�ؤ�ҡ÷�����
			
			
			$num_kp7all = GetNumKp7Allv1($profile_id,"NEW"); // �����ŷ���������
			$num_kp7all_old = GetNumKp7Allv1($profile_id,""); // �����ŷ���������
			$num_approve = GetNumKeyApproveSite("NEW"); // ࢵ������Ӣ�����
			$num_approve_old = GetNumKeyApproveSite(""); // ࢵ������ͧ���Ӣ�����
			
			
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

			
			  $date_dis = (date("Y")+543)-2; // ����͹��ѧ
			 $idcard_ex = GetCard_idExcerent();// �Ţ�ѵû�Шӵ�ǻ�ЪҪ��ͧ����� excerent
		
	function GetKeykp7($compare_id,$date1,$date2=""){
		global $dbnameuse;
		
		if($compare_id == "2"){
			$conid = " AND  t1.datekeyin LIKE '$date2%'";
		}else{
			$conid = " AND  t1.datekeyin between '$date1' AND '$date2'";	
			
		}//end if($compare_id == "2"){
		$sql = "SELECT count(distinct t1.idcard)/count(distinct t1.datekeyin) as keydoc FROM stat_user_keyperson as t1 Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard
WHERE  t2.status_keydata='1' $conid  group by month(t1.datekeyin)";	
//echo $sql;die;
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[keydoc];
		
	}//end function GetKeykp7($site_id,$compare_id,$date1,$date2=""){	
			 
	############################# function �ʴ��ż�Ե��͡���� #####################	 
	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){ // $ctype = 1 �����͹�Ѩ�غѹ 0 �����͹����ҹ��
		global $dbnameuse,$idcard_ex,$point_per_doc;
		$temp_date = $date1."-01";
		$end_date = GetdateEnd($temp_date);
		$cyy_cmm = date("Y-m");/// ��͹�Ѩ�غѹ
		//echo "temp_date : $temp_date :: end : ".$end_date;die;
		if($compare_id == "2"){
			$conid = " AND t2.datekeyin LIKE '$date1%'";
				
				if($cyy_cmm == $date1){
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
				}else{
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '$date1%'";		
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE '$date1%'";
				}
				
			
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
			
			$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
			$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	
			
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
				$conid_staff1 .= " AND t1.card_id IN($idcard_ex) ";
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
			
	$sql = "SELECT  count(distinct t1.staffid) as numstaff FROM  keystaff_history as t2 Inner Join keystaff as t1 ON t2.staffid = t1.staffid WHERE  t2.group_id='2'  and t1.period_time='am'  $conid_staff $con1 GROUP BY   t2.group_id ";
	//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


/*$sql2 = "SELECT 
count(distinct t2.datekeyin) as numday,
sum(t2.numkpoint) as numpoint
FROM
keystaff as t1 Inner Join 
stat_user_keyin as t2  ON t1.staffid=t2.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
*/
$sql2 = "SELECT count(distinct t2.datekeyin) as numday, sum(t2.numkpoint) as numpoint 
FROM keystaff as t1
Inner Join keystaff_history as t3 ON t1.staffid=t3.staffid $conid_staff1
Inner Join stat_user_keyin as t2 ON t1.staffid=t2.staffid 
where t3.group_id='2' and t1.period_time='am' $conid $con1";

$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
if($rs2[numday] > 25){ $numday = 25;}else{ $numday = $rs2[numday];}
	$arr['numday'] = $numday;
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){
		
function GetDataGroupL($site_id,$compare_id,$date1,$date2=""){ // 1 �����͹�Ѩ�غѹ
		global $dbnameuse,$idcard_ex,$point_per_doc;
		$temp_date = $date1."-01";
		$cyy_cmm = date("Y-m");/// ��͹�Ѩ�غѹ
		$end_date = GetdateEnd($temp_date);
		if($compare_id == "2"){
			$conid = "AND t2.datekeyin LIKE '$date1%'";
				if($cyy_cmm == $date1){
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
				}else{
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '$date1%'";
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE '$date1%'";	
				}


			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = "AND t2.datekeyin between '$date1' AND '$date2'";	
			//$conid_staff = " AND t1.start_date between '$date1' AND '$date2' ";
			
			$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
			$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	

			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
				$conid_staff1 .= " AND t1.card_id NOT IN($idcard_ex) ";
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
	

$sql = "SELECT  count(distinct t1.staffid) as numstaff FROM  keystaff_history as t2 Inner Join keystaff as t1 ON t2.staffid = t1.staffid WHERE   t2.group_id='2'  and t1.period_time='am'  $conid_staff $con1 GROUP BY   t2.group_id ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


/*$sql2 = "SELECT
count(distinct t2.datekeyin) as numday,
sum(t2.numkpoint) as numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
*/
$sql2 = "SELECT count(distinct t2.datekeyin) as numday, sum(t2.numkpoint) as numpoint 
FROM keystaff as t1
Inner Join keystaff_history as t3 ON t1.staffid=t3.staffid $conid_staff1
Inner Join stat_user_keyin as t2 ON t1.staffid=t2.staffid 
where t3.group_id='2' and t1.period_time='am' $conid $con1";


//echo $sql2."<hr>";
$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
if($rs2[numday] > 25){ $numday = 25;}else{ $numday = $rs2[numday];}
	
	$arr['numday'] = $numday;
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){

function GetDataGroupN($site_id,$compare_id,$date1,$date2=""){
	global $dbnameuse,$point_per_doc;
	$temp_date = $date1."-01";
	$cyy_cmm = date("Y-m");/// ��͹�Ѩ�غѹ
	$end_date = GetdateEnd($temp_date);
	if($compare_id == "2"){
		$conid = " AND t2.datekeyin LIKE '$date1%'";

				if($cyy_cmm == $date1){
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE '$date1%' AND t1.status_permit='YES'";
				}else{
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE  '$date1%'";	
					$conid_staff1 = " AND concat(t3.staff_yy,"."'-'".",t3.staff_mm) LIKE  '$date1%'";	
				}



	}else{
		$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	

		$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
		$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	

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
	
	


/*$sql = "SELECT
count(distinct t2.datekeyin) as numday,
t1.ratio_id as rpoint,
sum(t2.numkpoint) as numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
where t1.keyin_group='3' and t1.period_time='am'  $conid $con1	
group by 
t1.ratio_id";
*///echo $sql."<hr>";
$sql = "SELECT count(distinct t2.datekeyin) as numday, t3.ratio_id as rpoint, sum(t2.numkpoint) as numpoint 
FROM keystaff as t1  
inner Join keystaff_history as t3 ON t1.staffid=t3.staffid  $conid_staff1
Inner Join stat_user_keyin as t2 ON t1.staffid=t2.staffid 
where t1.keyin_group='3' and t1.period_time='am' $conid $con1	 group by t3.ratio_id";


	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
	if($rs[numday] > 25){ $numday = 25;}else{ $numday = $rs[numday];}
	$arr[$rs[rpoint]]['numday'] = $numday;
	$arr[$rs[rpoint]]['numpoint'] = $rs[numpoint];
	
}//end while($rss = mysql_fetch_assoc($result_staff)){
	$sql2 = "SELECT  t2.ratio_id as rpoint ,count(distinct t1.staffid) as numstaff FROM  keystaff_history as t2 Inner Join keystaff as t1 ON t2.staffid = t1.staffid WHERE   t2.group_id='3'  and t1.period_time='am'  $conid_staff $con1 GROUP BY   t2.ratio_id ";
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
				
				$numdoc_key = GetKeykp7($compare_id,$date3,$date4); // �ӹǹ�͡��÷�������㹪�ǧ��͹
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,$date2); // ����� E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date3,$date4); // ����� E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,$date2); // ����� L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date3,$date4); // ����� L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,$date2); // ����� N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date3,$date4); // ����� N
				
				$condate1 = $date1."||".$date2;
				$condate2 = $date3."||".$date4;
				
					$xhead = " ��§ҹ���º��º�ż�Ե�����ҧ�ѹ��� ".DBThaiLongDateFull($date1)." �֧ ".DBThaiLongDateFull($date2)." ���º��º�Ѻ ".DBThaiLongDateFull($date3)." �֧ ".DBThaiLongDateFull($date4)." ".$arrsite[$site_id];
					$sub_h1 = "�ѹ��� ".DBThaiLongDateFull($date1)." �֧ ".DBThaiLongDateFull($date2);
					$sub_h2 =  "�ѹ��� ".DBThaiLongDateFull($date3)." �֧ ".DBThaiLongDateFull($date4);
			}else{
					$cmm = intval(date("m"));
					$cyy = intval(date("Y")+543);
					$cdd = intval(date("d"));
					if($cmm == $mm1 and $cyy == $yy1){
						$hsub1 = "�������ѹ��� 1 �֧�ѹ��� $cdd";	
					}else{
						$hsub1 = "";
					}// end if($cmm == $mm1 and $cyy == $yy1){
					if($cmm == $mm2 and $cyy == $yy2){
						$hsub2 = "�������ѹ��� 1 �֧�ѹ��� $cdd";	
					}else{
						$hsub2 = "";
					}//end if($cmm == $mm2 and $cyy == $yy2){
					$xhead = " ��§ҹ���º��º�ż�Ե�����ҧ��͹  ".$monthname[$mm1]." �.�. ".$yy1." ���º��º�Ѻ ".$monthname[$mm2]." �.�. ".$yy2." ".$arrsite[$site_id];	
					$sub_h1 = $hsub1." ��͹  ".$monthname[$mm1]." �.�. ".$yy1;
					$sub_h2 = $hsub2." ��͹  ".$monthname[$mm2]." �.�. ".$yy2;
				
					
					
					$month_val1 = sprintf("%02d",$mm1);
					$month_val2 = sprintf("%02d",$mm2);
					$year_val1 = $yy1-543;
					$year_val2 = $yy2-543;
					$date1 = $year_val1."-".$month_val1;
					$date2 = $year_val2."-".$month_val2;
					
					$condate1 = $date1;
					$condate2 = $date2;
					//echo $date1." :: ".$date2;
				$numdoc_key = GetKeykp7($compare_id,$date1,$date2); // �ӹǹ�͡��÷�������㹪�ǧ��͹
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,""); // ����� E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date2,""); // ����� E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,""); // ����� L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date2,""); // ����� L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,""); // ����� N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date2,""); // ����� N

					
			}
			
			
		//	echo "<pre>";
			//print_r($arr_n);
			//print_r($arr_n1);
			
		###########  ����ʴ������� ################
		
		                     $sql = "SELECT * FROM keystaff_group_report ORDER BY orderby ASC";
							$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
							$arr_show = array();
							while($rs = mysql_fetch_assoc($result)){
								//echo $rs[r_point]." :: ".$arr_n[$rs[r_point]]['numstaff']."<br>";

								if($rs[groupreport_id] == "1"){
										$staff_val1 = $arr_e['numstaff']; // �ӹǹ��ѡ�ҹ������
										$staff_val2 = $arr_e1['numstaff'];
										$numpoint_val1 = ($arr_e['numpoint'])/$point_per_doc;// �ӹǹ��ѡ�ҹ������1
										$numpoint_val2 = ($arr_e1['numpoint'])/$point_per_doc;
										$numdaykey1 = $arr_e['numday']; // �ӹǹ�ѹ���������
										$numdaykey2 = $arr_e1['numday']; // �ӹǹ�ѹ���������
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1; // �ӹǹ����µ���ѹ
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2; // �ӹǹ�ش����µ���ѹ��ͤ�
										}
										#########  �ż�Ե +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
								}//if($rs[groupreport_id] == "1"){
									
								else if($rs[groupreport_id] == "2"){
										
										$staff_val1 = $arr_l['numstaff']; // �ӹǹ��ѡ�ҹ������
										$staff_val2 = $arr_l1['numstaff'];
										$numpoint_val1 = ($arr_l['numpoint'])/$point_per_doc;// �ӹǹ��ѡ�ҹ������1
										$numpoint_val2 = ($arr_l1['numpoint'])/$point_per_doc;
										$numdaykey1 = $arr_l['numday']; // �ӹǹ�ѹ���������
										$numdaykey2 = $arr_l1['numday']; // �ӹǹ�ѹ���������
										if($staff_val1 > 0){
											$numpoint_avg1 = ($numpoint_val1/$staff_val1)/$numdaykey1;
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = ($numpoint_val2/$staff_val2)/$numdaykey2;
										}

										#########  �ż�Ե +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
								}//end else if($rs[groupreport_id] == "1"){
									
								else{
										
										$staff_val1 = $arr_n[$rs[r_point]]['numstaff']; // �ӹǹ��ѡ�ҹ������
										$staff_val2 = $arr_n1[$rs[r_point]]['numstaff'];
										
										$numdaykey1 = $arr_n[$rs[r_point]]['numday']; // �ӹǹ�ѹ���������
										$numdaykey2 = $arr_n1[$rs[r_point]]['numday']; // �ӹǹ�ѹ���������
										if($staff_val1 > 0){
											$numpoint_val1 = ($arr_n[$rs[r_point]]['numpoint'])/$point_per_doc;// �ӹǹ��ѡ�ҹ������1
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
										#########  �ż�Ե +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = ($numpoint_avg2)-($numpoint_avg1);
	
									}//end else($rs[groupreport_id] == "3"){
										
									
						################  �纤�����㹵���� array
						$arr_show[$rs[groupreport_id]]['groupname'] = $rs[groupreport_name];
						$arr_show[$rs[groupreport_id]]['numstaff1'] = $staff_val1;
						$arr_show[$rs[groupreport_id]]['numstaff2'] = $staff_val2;
						$arr_show[$rs[groupreport_id]]['numpoint1'] = $numpoint_val1;
						$arr_show[$rs[groupreport_id]]['numpoint2'] = $numpoint_val2;
						$arr_show[$rs[groupreport_id]]['numpoint_avg1'] = $numpoint_avg1;
						$arr_show[$rs[groupreport_id]]['numpoint_avg2'] = $numpoint_avg2;
						$arr_show[$rs[groupreport_id]]['staff_pd'] = $staff_pd; // �ӹǹ���ǡź
						$arr_show[$rs[groupreport_id]]['numpoint_pd'] = $numpoint_pd; // ��ṹ�ǡź
						$arr_show[$rs[groupreport_id]]['numavg_pd'] = $numavg_pd; // ������ºǡź
						$arr_show[$rs[groupreport_id]]['r_point'] = $rs[r_point]; // ������ºǡź
						
						
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
//echo "<pre>";
//print_r($arr_show);

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />

</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../../images_sys/banner_cmss2_report.jpg" width="100%" height="159"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
                      <td colspan="2" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>������<br>
(��)</strong></td>
                      <td colspan="10" align="center" bgcolor="#A5B2CE"><strong>��ػ�Ҿ�����èѴ�Ӣ����Ż������</strong></td>
                      </tr>
                    <tr>
                      <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>�ѹ�֡����������</strong></td>
                  <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>�������</strong></td>
                  <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե����ѹ�ͧ����������(��)</strong></td>
                </tr>
                <tr>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>����������</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>�����ŵ�����ͧ</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>���</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>����������</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�����ŵ�����ͧ</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>��</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
                  <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ѹ</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�������</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>����</strong></td>
                  <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
                </tr>
                <?
                	$exsum_workkey = $numdoc_key;
					
					
					$numkey_all = $num_approve+$num_approve_old;
					$numkey1 = (($num_kp7all-$num_approve)/$numdayproject); // �������������
					$numkey_pass = $exsum_workkey-$numkey1; // �ӹǹ�ǡź
					
				?>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡��</strong></td>
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
		     <td align="center" bgcolor="#CCCCCC" >
             <table>
             <TR>
                 <td  align="right">�ѹ�֡����(��):</td>
                 <td><?=$num_kp7all?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ�֡������ͧ(��):</td>
                 <td><?=$num_kp7all_old?></td>
             </TR>
             <TR>
                 <td  align="right">�š�úѹ�֡����(��):</td>
                 <td><?=$num_approve?></td>
             </TR>
             <TR>
                 <td  align="right">�š�úѹ�֡������ͧ(��):</td>
                 <td><?=$num_approve_old?></td>
             </TR>
             <TR>
                 <td  align="right">�������(��):</td>
                 <td><?=$numkey1?></td>
             </TR>
             <TR>
                 <td  align="right">����(��):</td>
                 <td><?=$exsum_workkey?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ�����������ç���:</td>
                 <td><?=$start_project?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ�������ش�ç���:</td>
                 <td><?=$end_date_project?></td>
             </TR>
             <TR>
                 <td  align="right">���Թ��÷�����(�ѹ):</td>
                 <td><?=$numdayproject_all?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ��ش������(�ѹ):</td>
                 <td><?=$numHoliday_all?></td>
             </TR>
             <TR>
                 <td  align="right">���Թ���������(�ѹ):</td>
                 <td><?=$numdayproject_s?></td>
             </TR>
             <TR>
                 <td  align="right">������ͨӹǹ(�ѹ):</td>
                 <td><?=$numdayproject?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ���Ѵ�红�����:</td>
                 <td><?=$curent_date_project?></td>
             </TR>
             <TR>
                 <td  align="right">�ѹ���-������䢢�����:</td>
                 <td><?=date("Y-m-d H:i:s")?></td>
             </TR>
             </table>
				<?php
				$sql_insert = "REPLACE INTO keyin_endproduct SET
										num_kp7all='".$num_kp7all."',
										num_kp7all_old='".$num_kp7all_old."',
										num_approve='".$num_approve."',
										num_approve_old='".$num_approve_old."',
										num_keytarget='".$numkey1."',
										num_exsum_workkey='".$exsum_workkey."',
										start_date_project='".$start_project."',
										end_date_project='".$end_date_project."',
										num_dayproject_all='".$numdayproject_all."' ,
										num_holiday_all='".$numHoliday_all."',
										num_dayproject_operation='".$numdayproject_s."',
										num_dayproject = '".$numdayproject."',
										curent_date_project = '".$curent_date_project."',
										update_datetime=NOW()
									";
				$db_ipad="cmss_ipad";
				mysql_db_query($db_ipad,$sql_insert);
                ?>
             </td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" > &nbsp;&nbsp; ������ � �ѹ��� <? $tempdate = (date("Y")+543)."-".date("m-d"); echo MakeDate($tempdate);?>&nbsp;&nbsp;&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;</td>
	      </tr>
        </form>
      </table>
	  </td>
  </tr>
</table>

</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
	}
?>
