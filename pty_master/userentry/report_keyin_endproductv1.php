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
			
			$time_start = getmicrotime();
			//echo "�ѹ�������ش :: ".GetdateEnd("2011-08");die;
			//$yymm = date("Y-m");
			//echo $yymm."<br>";
			//echo "::".LastMonth($yymm);die;
			
			if($profile_id == ""){
				$sql_p = "SELECT  profile_report FROM view_profile_report ORDER BY profile_report DESC LIMIT 1";
				$resultp = mysql_db_query($dbnameuse,$sql_p) or die(mysql_error()."".__LINE__);
				$rsp = mysql_fetch_assoc($resultp);
				$profile_id = $rsp[profile_report];
			}
			
			$start_project = "2011-02-01"; // �ѹ��������ѭ���ç���
			$end_date_project = "2011-12-20"; 	## �ѹ����ش�ç���
			$curent_date_project = date("Y-m-d"); // �ѹ���Ѩ�غѹ�ͧ�ç���
			$point_per_doc = 69; // ��Ҥ�ṵ�ͪش
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

			
			
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
			 
			 
			 
	######################## 
	
	
			 
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
				}//end  if($cyy_cmm == $date1){
					
					$constaff_in = " AND  t1.start_date like '$date1%'  ";
					$constaff_out = " AND  t1.retire_date like '$date1%'  ";
			
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
				$constaff_in  .= " AND t1.card_id IN($idcard_ex) ";
				$constaff_out  .= " AND t1.card_id IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
			
			$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
			$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	
			
			$constaff_in = " AND  t1.start_date between '$date1' and '$date2' ";
			$constaff_out = " AND  t1.retire_date between '$date1' and '$date2' ";
			
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id IN($idcard_ex) ";
				$conid_staff1 .= " AND t1.card_id IN($idcard_ex) ";
				$constaff_in  .= " AND t1.card_id IN($idcard_ex) ";
				$constaff_out  .= " AND t1.card_id IN($idcard_ex) ";
				
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
	
	$sql_staffin = "SELECT Count(distinct t1.card_id) AS numstaff FROM keystaff as t1 WHERE t1.keyin_group='2'  AND  t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='YES'  $constaff_in $con1";
	$result_staffin = mysql_db_query($dbnameuse,$sql_staffin) or die(mysql_error()."$sql_staffin<br>LINE__".__LINE__);
	$rsin = mysql_fetch_assoc($result_staffin);
	
	$sql_staffout = "SELECT Count(distinct t1.card_id) AS numstaff FROM keystaff as t1 WHERE t1.keyin_group='2'  AND  t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='NO'  $constaff_out $con1";
	$result_staffout = mysql_db_query($dbnameuse,$sql_staffout) or die(mysql_error()."$sql_staffout<br>LINE__".__LINE__);
	$rsout = mysql_fetch_assoc($result_staffout);



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
	$arr['staffin'] = $rsin[numstaff];
	$arr['staffout'] = $rsout[numstaff];
	
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


				$constaff_in = " AND  t1.start_date like '$date1%'  ";
				$constaff_out = " AND  t1.retire_date like '$date1%'  ";

			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
				$constaff_in  .= " AND t1.card_id NOT IN($idcard_ex) ";
				$constaff_out  .= " AND t1.card_id NOT IN($idcard_ex) ";
			}//end if($idcard_ex != ""){
		}else{
			$conid = "AND t2.datekeyin between '$date1' AND '$date2'";	
			//$conid_staff = " AND t1.start_date between '$date1' AND '$date2' ";
			
			$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
			$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	
			
			$constaff_in = " AND  t1.start_date between '$date1' and '$date2' ";
			$constaff_out = " AND  t1.retire_date between '$date1' and '$date2' ";

			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
				$conid_staff .= " AND t1.card_id NOT IN($idcard_ex) ";
				$conid_staff1 .= " AND t1.card_id NOT IN($idcard_ex) ";
				$constaff_in  .= " AND t1.card_id NOT IN($idcard_ex) ";
				$constaff_out  .= " AND t1.card_id NOT IN($idcard_ex) ";
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
	
	$sql_staffin = "SELECT Count(distinct t1.card_id) AS numstaff FROM keystaff as t1 WHERE t1.keyin_group='2'  AND t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='YES'  $constaff_in $con1 ";
	$result_staffin = mysql_db_query($dbnameuse,$sql_staffin) or die(mysql_error()."$sql_staffin<br>LINE__".__LINE__);
	$rsin = mysql_fetch_assoc($result_staffin);
	
	$sql_staffout = "SELECT Count(distinct t1.card_id) AS numstaff FROM keystaff as t1 WHERE t1.keyin_group='2'  AND  t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0'  AND t1.status_permit='NO'  $constaff_out $con1 ";
	//echo $sql_staffout;
	$result_staffout = mysql_db_query($dbnameuse,$sql_staffout) or die(mysql_error()."$sql_staffout<br>LINE__".__LINE__);
	$rsout = mysql_fetch_assoc($result_staffout);



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
	$arr['staffin'] = $rsin[numstaff];
	$arr['staffout'] = $rsout[numstaff];
	
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
				$constaff_in = " AND  t1.start_date LIKE  '$date1%'";
				$constaff_out = " AND  t1.retire_date LIKE  '$date1%'";


	}else{
		$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	

		$conid_staff = " AND t2.date_start <= '$date1' AND t2.date_end >= '$date2' ";	
		$conid_staff1 = " AND t3.date_start <= '$date1' AND t3.date_end >= '$date2' ";	
			
			$constaff_in = " AND  t1.start_date between '$date1' and '$date2' ";
			$constaff_out = " AND  t1.retire_date between '$date1' and '$date2' ";

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
	
	$sql_staffin = "SELECT
Count(distinct t1.card_id) AS numstaff,
t1.ratio_id
FROM
keystaff AS t1
where  t1.keyin_group='3'  AND  t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='YES'  $constaff_in $con1
group by t1.ratio_id";
	$result_staffin = mysql_db_query($dbnameuse,$sql_staffin) or die(mysql_error()."$sql_staffin<br>LINE__".__LINE__);
	while($rsin = mysql_fetch_assoc($result_staffin)){
			$arr[$rsin[ratio_id]]['staffin'] = $rsin[numstaff];
	}//end while($rsin = mysql_fetch_assoc($result_staffin)){
	
	$sql_staffout = "SELECT t1.ratio_id,Count(distinct t1.card_id) AS numstaff FROM keystaff as t1 WHERE t1.keyin_group='3'  AND  t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='NO' $constaff_out $con1 GROUP BY t1.ratio_id ";
	//echo $sql_staffout."<br>";
	$result_staffout = mysql_db_query($dbnameuse,$sql_staffout) or die(mysql_error()."$sql_staffout<br>LINE__".__LINE__);
	while($rsout = mysql_fetch_assoc($result_staffout)){
			$arr[$rsout[ratio_id]]['staffout'] = $rsout[numstaff];
	}//end 	while($rsout = mysql_fetch_assoc($result_staffout)){



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
				
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,""); // ����� E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date2,""); // ����� E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,""); // ����� L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date2,""); // ����� L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,""); // ����� N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date2,""); // ����� N

					
			}
			
			

			
			//echo "<pre>";
			//print_r($arr_n);
			//print_r($arr_n1);die;
			
		###########  ����ʴ������� ################
		
		                     $sql = "SELECT * FROM keystaff_group_report ORDER BY orderby ASC";
							$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
							$arr_show = array();
							while($rs = mysql_fetch_assoc($result)){
								//echo $rs[r_point]." :: ".$arr_n[$rs[r_point]]['numstaff']."<br>";

								if($rs[groupreport_id] == "1"){
										$staff_val1 = $arr_e['numstaff']; // �ӹǹ��ѡ�ҹ������
										$staff_val2 = $arr_e1['numstaff'];
										$staffin = $arr_e1['staffin']+$arr_e['staffin'];// �ӹǹ��ѡ�ҹ�����ҧҹ
										$staffout = $arr_e1['staffout']+$arr_e['staffout']; // �ӹǹ��ѡ�ҹ����͡�ҹ
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
										$staffin = $arr_l1['staffin']+$arr_l['staffin'];// �ӹǹ��ѡ�ҹ�����ҧҹ
										$staffout = $arr_l1['staffout']+$arr_l['staffout']; // �ӹǹ��ѡ�ҹ����͡�ҹ
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
										$staffin =$arr_n1[$rs[r_point]]['staffin']+$arr_n[$rs[r_point]]['staffin'];// �ӹǹ��ѡ�ҹ�����ҧҹ
										$staffout = $arr_n1[$rs[r_point]]['staffout']+$arr_n[$rs[r_point]]['staffout']; // �ӹǹ��ѡ�ҹ����͡�ҹ
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
						$arr_show[$rs[groupreport_id]]['staffin'] = $staffin; // ��ѡ�ҹ���
						$arr_show[$rs[groupreport_id]]['staffout'] = $staffout; // ��ѡ�ҹ�͡
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
							$staffin = 0;
							$staffount = 0;

		}//end while($rs = mysql_fetch_assoc($result)){
//echo "<pre>";
//print_r($arr_show);

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
	// �ѹ����� 1
	arr1 = d1.split("/");
	v1 = arr1[2]+""+arr1[1]+""+arr1[0];
	// �ѹ����� 2
	arr2 =  d2.split("/");
	v2 = arr2[2]+""+arr2[1]+""+arr2[0];
	
	arr3 =  d3.split("/");
	v3 = arr3[2]+""+arr3[1]+""+arr3[0];
	
	arr4 =  d4.split("/");
	v4 = arr4[2]+""+arr4[1]+""+arr4[0];
		if(v2 < v1){
				alert("�ѹ�������ش��ǹ˹�ҵ�ͧ�����¡����ѹ����������");
				document.form1.s_data2.focus();
				return false;
		}
		if(v4 < v3){
				alert("�ѹ�������ش��ǹ��ѧ��ͧ�����¡����ѹ����������");
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
				alert("��͹������ش��ͧ�����¡�����͹���������");
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
				
				$sql_exsum = "SELECT * FROM view_report_keykp7 WHERE date_report='".date("Y-m-d")."'";
				$result_exsum = mysql_db_query($dbnameuse,$sql_exsum) or die(mysql_error()."".__LINE__);
				$rsex = mysql_fetch_assoc($result_exsum);
				
	
					$exsum_workkey = $rsex[dockey_perday]; // �ӹǹ�ش��������������ѹ
					$numkey_all = $rsex[keydoc_new]+$rsex[keydoc_continue]; // �ӹǹ�͡��÷����������
					$numkey1 = (($rsex[numdoc_new]-$rsex[keydoc_new])/$rsex[day_work]); // �������������
					$numkey_pass = $exsum_workkey-$numkey1; // �ӹǹ�ǡź
					
				?>
                <tr>
                  <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡��</strong></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($rsex[numdoc_new])?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($rsex[numdoc_continue])?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($numkey_all)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($rsex[keydoc_new] )?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($rsex[keydoc_continue])?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format(($rsex[keydoc_new]*100)/$rsex[numdoc_new],2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format($rsex[numdoc_new]-$rsex[keydoc_new])?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=number_format((($rsex[numdoc_new]-$rsex[keydoc_new])*100)/$rsex[numdoc_new],2)?></td>
                  <td align="center" bgcolor="#FFFFFF"><?=$rsex[day_work]?></td>
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
		     <td align="right" bgcolor="#CCCCCC" > &nbsp;&nbsp; ������ � �ѹ��� <? $tempdate = (date("Y")+543)."-".date("m-d"); echo MakeDate($tempdate);?>&nbsp;&nbsp;&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;</td>
	      </tr>
		   <tr>
		     <td align="right" bgcolor="#CCCCCC" >&nbsp;&nbsp;<a href="#" onClick="window.open('popup_endproduct.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=800,height=550');"><img src="../../images_sys/gear_replace.gif"  width="20" height="16" border="0" title="�������ͤ���ʶԵԢ�����"></a>&nbsp;&nbsp;&nbsp;</td>
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
		                   <td width="3%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
		                   <td width="15%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�������ѡ�ҹ</strong></td>
		                   <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h1?>
	                        </strong></td>
		                   <td colspan="8" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h2?>
	                        </strong></td>
		                   </tr>
		                 <tr>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ (��)</strong></td>
		                   <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե���(�ش)</strong></td>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե���<br>
	                        ������ѹ(�ش)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ (��)</strong></td>
		                   <td width="6%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�������/<br>
	                        ��Ѻ�����(��)</strong></td>
		                   <td width="6%" align="center" bgcolor="#A5B2CE"><strong>���͡(��)</strong></td>
		                   <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե���(�ش)</strong></td>
		                   <td width="6%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե��ͤ�<br>
	                        ����ѹ(�ش)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
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
		                   <td align="center"><? if($val['numstaff1'] > 0){ echo "<a href='report_key_endproduct_detail_newv1.php?groupreport_id=$key&xtype=1&site_id=$site_id&rpoint=$rpoint&condate=$condate1' target='_blank'>".number_format($val['numstaff1'])."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($val['numpoint1'],2)?></td>
		                   <td align="center"><?=number_format($val['numpoint_avg1'],2)?></td>
		                   <td align="center"><? if($val['numstaff2']  > 0){ echo "<a href='report_key_endproduct_detail_newv1.php?groupreport_id=$key&xtype=2&site_id=$site_id&rpoint=$rpoint&condate=$condate2' target='_blank'>".number_format($val['numstaff2'])."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><?  if($val['staff_pd'] < 0){ echo "<font color=\"#CC0000\">".number_format($val['staff_pd'])."</font>";}else{ echo number_format($val['staff_pd']);};
						  /* if($val['staff_pd'] < 0){ echo "<font color=\"#CC0000\"><a href='report_key_endproduct_detail_diff_newv1.php?groupreport_id=$key&xtype=3&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&r=N&numstaff=".$val['staff_pd']."' target='_blank' style=\"color:#F00000\">".number_format($val['staff_pd'])."</a></font>";}else if($val['staff_pd'] > 0){ echo "<a href='report_key_endproduct_detail_diff_newv1.php?groupreport_id=$key&xtype=3&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&r=Y&numstaff=".$val['staff_pd']."' target='_blank'>".number_format($val['staff_pd'])."</a>"; }else{ echo "0";}*/
						  ?>
                           </td>
		                   <td align="center"><? if($val['staffin'] > 0){ echo "<a href='report_key_endproduct_inout.php?xtype=in&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&groupreport_id=$key' target='_blank'>".number_format($val['staffin'])."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><? if($val['staffout']  > 0){  echo "<a href='report_key_endproduct_inout.php?xtype=out&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2&groupreport_id=$key' target='_blank' style=\"color:#F00000\">".number_format($val['staffout'])."</a>";}else{ echo "0";}?></td>
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
							$num_in += $val['staffin'];
							$num_out += $val['staffout'];
							$num6 += $val['numpoint2'];
							$num7 += $val['numpoint_pd'];
							$num8 += $val['numpoint_avg2'];
							$num9 += $val['numavg_pd'];
							
							
							
							
							}// end 	foreach($arr_show as $key => $val){	
					}// end 	if(count($arr_show) > 0){		
						   ?>
		                 <tr>
		                   <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>��� :</strong></td>
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
		                   <td align="center" bgcolor="#CCCCCC"><strong><? if($num_in > 0){ echo "<a href='report_key_endproduct_inout.php?xtype=inall&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2' target='_blank'>".number_format($num_in)."</a>";}else{ echo "0";}?></strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong><? if($num_out > 0){ echo "<a href='report_key_endproduct_inout.php?xtype=outall&site_id=$site_id&rpoint=$rpoint&condate1=$condate1&condate2=$condate2' target='_blank' style=\"color:#F00000\">".number_format($num_out)."</a>";}else{ echo "0";}?></strong></td>
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
	echo "����㹡�û����ż� :: $timeprocess";
?>
