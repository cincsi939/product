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
			
			//echo "วันที่ล่าสุด :: ".GetdateEnd("2011-08");die;
			//$yymm = date("Y-m");
			//echo $yymm."<br>";
			//echo "::".LastMonth($yymm);die;
			
			if($profile_id == ""){
				$sql_p = "SELECT  profile_report FROM view_profile_report ORDER BY profile_report DESC LIMIT 1";
				$resultp = mysql_db_query($dbnameuse,$sql_p) or die(mysql_error()."".__LINE__);
				$rsp = mysql_fetch_assoc($resultp);
				$profile_id = $rsp[profile_report];
			}
			//echo $profile_id;die;
			$start_project = "2011-02-01"; // วันเริ่มทำสัญญาโครงการ
			$end_date_project = "2012-01-27"; 	## วันสิ้นสุดโครงการ
			$curent_date_project = date("Y-m-d"); // วันที่ปัจจุบันของโครงการ
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$arrsite = GetSiteKeyData();
			$numHoliday = GetNumHoliday($curent_date_project,$end_date_project); // นับจำนวนวันหยุด
			#$numHoliday_s = GetNumHoliday($start_project,$curent_date_project); // นับจำนวนวันหยุดก่อนวันปัจจุบัน
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			### นับจำนวนวันที่เหลือของโครงการโดยยังไม่หักวันหยุด
			$numdayproject = GetNumDayOfDate($curent_date_project,$end_date_project)-$numHoliday; // ระยะเวลาคงเหลือ
			#$numdayproject_s  = GetNumDayOfDate($start_project,$curent_date_project)-$numHoliday_s; // ระยะเวลาที่คีย์ข้อมูลไปแล้ว
					
			$num_kp7all = GetNumKp7Allv1($profile_id,"NEW"); // ข้อมูลทั้งหมดใหม่
			$num_kp7all_old = GetNumKp7Allv1($profile_id,""); // ข้อมูลทั้งหมดใหม่
			$num_approve = GetNumKeyApproveSite("NEW"); // เขตใหม่ที่ทำข้อมูล
			$num_approve_old = GetNumKeyApproveSite(""); // เขตต่อเนื่องที่ทำข้อมูล
			
		
			
			
			

			 
			 
			 
	######################## 
	#### นับจำนวนการคีย์ข้อมูลของกลุ่ม E
	function GetKeyKp7GroupE($type=""){
		global $dbnameuse;
			$insite = GetsiteContinue();
			if($insite != ""){
					if($type == "NEW"){
						$conW1  = " AND t1.siteid NOT IN($insite)";
					}else{
						$conW1  = " AND t1.siteid IN($insite)";
					}
			}//end if($insite != ""){
			$in_idcard = GetCard_idExcerent();
			if($in_idcard != ""){
					$conW2 = " AND t3.card_id IN($in_idcard)";
			}
			
			$arrd_holiday = GetDateHoliday();
			
			$in_date = "";
			//echo"<pre>";print_r($arrd_holiday);
			if(count($arrd_holiday) > 0){
				foreach($arrd_holiday as $key => $val){
						if($in_date > "") $in_date .= ",";
						$in_date .= "'$val'";
				}	// end foreach($arrd_holiday as $key => $val){
			}//end if(count($arrd_holiday) > 0){
			
			if($in_date != ""){
					$condate1 = " AND (date(t1.datetime_approve) NOT IN($in_date))";
			}else{
					$condate1 = "";	
			}
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$yymm = date("Y-m");
			$lastmonth = LastMonth($yymm);			
			$contime = " AND (date(t1.datetime_approve) LIKE '$yymm%' or date(t1.datetime_approve) LIKE '$lastmonth%') and  date(t1.datetime_approve) < '".date("Y-m-d")."' $condate1 ";
	
				$sql = "SELECT
		date(t1.datetime_approve) as datekey,
		count(t1.idcard) as numkey
		FROM
		tbl_assign_key as t1
		Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
		Inner Join keystaff as t3 ON t2.staffid = t3.staffid
		WHERE   t1.approve='2' and t1.status_keydata='1' and t3.keyin_group='2'   $conW1  $conW2 $contime
		GROUP  BY date(t1.datetime_approve)
		ORDER BY datekey DESC LIMIT 1";
		//echo "SQL :: <br>".$sql;die;
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				$rs = mysql_fetch_assoc($result);
				return $rs[numkey];
	}// END function GetKeyKp7GroupE($type=""){
		
		
	#######################  นับจำนวนชุดการคีย์เอกสารรายวันของกลุ่ม L
	
		function GetKeyKp7GroupL($type=""){
		global $dbnameuse;
			$insite = GetsiteContinue();
			if($insite != ""){
					if($type == "NEW"){
						$conW1  = " AND t1.siteid NOT IN($insite)";
					}else{
						$conW1  = " AND t1.siteid IN($insite)";
					}
			}//end if($insite != ""){
			$in_idcard = GetCard_idExcerent();
			if($in_idcard != ""){
					$conW2 = " AND t3.card_id NOT IN($in_idcard)";
			}
			
			
						$arrd_holiday = GetDateHoliday();
			
			$in_date = "";
			//echo"<pre>";print_r($arrd_holiday);
			if(count($arrd_holiday) > 0){
				foreach($arrd_holiday as $key => $val){
						if($in_date > "") $in_date .= ",";
						$in_date .= "'$val'";
				}	// end foreach($arrd_holiday as $key => $val){
			}//end if(count($arrd_holiday) > 0){
			
			if($in_date != ""){
					$condate1 = " AND (date(t1.datetime_approve) NOT IN($in_date))";
			}else{
					$condate1 = "";	
			}
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 


			$yymm = date("Y-m");
			$lastmonth = LastMonth($yymm);			
			$contime = " AND (date(t1.datetime_approve) LIKE '$yymm%' or date(t1.datetime_approve) LIKE '$lastmonth%') and  date(t1.datetime_approve) < '".date("Y-m-d")."'  $condate1";
	
				$sql = "SELECT
		date(t1.datetime_approve) as datekey,
		count(t1.idcard) as numkey
		FROM
		tbl_assign_key as t1
		Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
		Inner Join keystaff as t3 ON t2.staffid = t3.staffid
		WHERE   t1.approve='2' and t1.status_keydata='1' and t3.keyin_group='2'   $conW1  $conW2 $contime
		GROUP  BY date(t1.datetime_approve)
		ORDER BY datekey DESC LIMIT 1";	
		echo $sql;
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				$rs = mysql_fetch_assoc($result);
				return $rs[numkey];
	}// END function GetKeyKp7GroupL($type=""){
		
		
	##################  นับจำนวนชุดเอกสารที่คีย์ได้ในแต่ละวันของกลุ่ม N
	function GetKeyKp7GroupN($type=""){
		global $dbnameuse;
			$insite = GetsiteContinue();
			if($insite != ""){
					if($type == "NEW"){
						$conW1  = " AND t1.siteid NOT IN($insite)";
					}else{
						$conW1  = " AND t1.siteid IN($insite)";
					}
			}//end if($insite != ""){
			
			$arrd_holiday = GetDateHoliday();
			
			$in_date = "";
			//echo"<pre>";print_r($arrd_holiday);
			if(count($arrd_holiday) > 0){
				foreach($arrd_holiday as $key => $val){
						if($in_date > "") $in_date .= ",";
						$in_date .= "'$val'";
				}	// end foreach($arrd_holiday as $key => $val){
			}//end if(count($arrd_holiday) > 0){
			
			if($in_date != ""){
					$condate1 = " AND (date(t1.datetime_approve) NOT IN($in_date))";
			}else{
					$condate1 = "";	
			}
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 



			$yymm = date("Y-m");
			$lastmonth = LastMonth($yymm);			
			$contime = " AND (date(t1.datetime_approve) LIKE '$yymm%' or date(t1.datetime_approve) LIKE '$lastmonth%') and  date(t1.datetime_approve) < '".date("Y-m-d")."'  $condate1";
			
	
			$sql_main = "SELECT t1.r_point FROM keystaff_group_report as t1 where t1.group_id='3' ";
			$result_main = mysql_db_query($dbnameuse,$sql_main) or die(mysql_error()."$$sql_main<br>LINE__".__LINE__);
			while($rsm = mysql_fetch_assoc($result_main)){
				$sql = "SELECT
		date(t1.datetime_approve) as datekey,
		count(t1.idcard) as numkey
		FROM
		tbl_assign_key as t1
		Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
		Inner Join keystaff as t3 ON t2.staffid = t3.staffid
		WHERE   t1.approve='2' and t1.status_keydata='1' and t3.keyin_group='3' and ratio_id='$rsm[r_point]'   $conW1  $conW2 $contime
		GROUP  BY date(t1.datetime_approve)
		ORDER BY datekey DESC LIMIT 1";	
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				$rs = mysql_fetch_assoc($result);
				$arr[$rsm[r_point]] = $rs[numkey];
		}//end while($rsm = mysql_fetch_assoc($result_main)){
			return $arr;
	}// END function GetKeyKp7GroupN($type=""){

		
/*		$arrkeynew = GetKeyKp7GroupN("NEW");
		$arrkeyold = GetKeyKp7GroupN("");
		echo "<pre>";
		print_r($arrkeynew);
		print_r($arrkeyold);
		die;*/
		
	
	
	function GetKeykp7(){
		global $dbnameuse;
		$insite = GetsiteContinue();
		if($insite != ""){
				$conW1  = " AND t2.siteid NOT IN($insite)";
		}
		
					$arrd_holiday = GetDateHoliday();
			
			$in_date = "";
			//echo"<pre>";print_r($arrd_holiday);
			if(count($arrd_holiday) > 0){
				foreach($arrd_holiday as $key => $val){
						if($in_date > "") $in_date .= ",";
						$in_date .= "'$val'";
				}	// end foreach($arrd_holiday as $key => $val){
			}//end if(count($arrd_holiday) > 0){
			
			if($in_date != ""){
					$condate1 = " AND (date(t2.datetime_approve) NOT IN($in_date))";
			}else{
					$condate1 = "";	
			}
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

		

			$yymm = date("Y-m");
			$lastmonth = LastMonth($yymm);			
			$conid = " AND date(t2.datetime_approve) LIKE '$yymm%' and (t1.datekeyin LIKE '$yymm%' or t1.datekeyin LIKE '$lastmonth%' )and t1.datekeyin < '".date("Y-m-d")."' $condate1";
			
			

			$sql = "SELECT
t1.datekeyin,
Count(distinct t1.idcard) AS keydoc
FROM stat_user_keyperson as t1 Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard
WHERE  t2.status_keydata='1' and t2.approve='2'  $conid $conW1
group by t1.datekeyin
having keydoc > 100
order by t1.datekeyin DESC
limit 1";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[keydoc];
		
	}//end function GetKeykp7($site_id,$compare_id,$date1,$date2=""){
		
				
   $arr_d2 = explode("-",date("Y-m-d"));
   $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
   if($xFTime['wday'] != 0){
		
		//$dockey_perday = GetKeykp7();// เอกสารที่คีย์ได้ในแต่ละวัน
		$sql_replace = "REPLACE INTO view_report_keykp7 SET date_report='".date("Y-m-d")."',numdoc_new='$num_kp7all',numdoc_continue='$num_kp7all_old',keydoc_new='$num_approve',keydoc_continue='$num_approve_old',day_work='$numdayproject' ";
		mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE__".__LINE__);
		
	################ เก็บข้อมูล ยอดการบันทึกข้อมูลได้แยกรายกลุ่ม #######################
	
	$sql1 = "SELECT * FROM keystaff_group_report";
	$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
	while($rs1 = mysql_fetch_assoc($result1)){
		if($rs1[groupreport_id] == "1"){ // ข้อมูลกลุ่ม E
				$dockey_new = GetKeyKp7GroupE("NEW");
				$dockey_continue = GetKeyKp7GroupE("");	
		}else if($rs1[groupreport_id] == "2"){ // ข้อมูลกลุ่ม L
				$dockey_new = GetKeyKp7GroupL("NEW");
				$dockey_continue = GetKeyKp7GroupL("");
		}else{ // ข้อมูลกลุ่ม N
				$arrkeynew = GetKeyKp7GroupN("NEW");
				$arrkeyold = GetKeyKp7GroupN("");
				#### ข้อมูลใหม่ของกลุ่ม N
		
				$dockey_new = 	$arrkeynew[$rs1[r_point]]; // ข้อมูลของเขตใหม่
				$dockey_continue = $arrkeyold[$rs1[r_point]]; // ข้อมูลเขตเก่า
		}// end if($rs1[groupreport_id] == "1"){
	$sql_keydetail = "REPLACE INTO view_report_keykp7_detail SET date_report='".date("Y-m-d")."',groupreport_id='$rs1[groupreport_id]',dockey_new='$dockey_new',dockey_continue='$dockey_continue',timeupdate=NOW()";
	mysql_db_query($dbnameuse,$sql_keydetail) or die(mysql_error()."$sql_keydetail<br>LINE__".__LINE__);
			$dockey_new = 0;
			$dockey_continue = 0;
	}//end while($rs1 = mysql_fetch_assoc($result1)){
	#### เก็บข้อมูลผลผลิตที่ทำได้ในแต่ละวัน
	$sql_sum = "SELECT SUM(dockey_new) AS sumkey  FROM view_report_keykp7_detail WHERE date_report='".date("Y-m-d")."' ";
	$result_sum = mysql_db_query($dbnameuse,$sql_sum) or die(mysql_error()."$sql_sum<br>LINE__".__LINE__);
	$rss = mysql_fetch_assoc($result_sum);
	$sql_update4 = "UPDATE view_report_keykp7 SET dockey_perday='$rss[sumkey]'  WHERE date_report='".date("Y-m-d")."' ";
	mysql_db_query($dbnameuse,$sql_update4) or die(mysql_error()."$sql_update4<br>LINE__".__LINE__);
	
			 
		
	 }//end  if($xFTime['wday'] != 0){
					 
					 

	

 $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
