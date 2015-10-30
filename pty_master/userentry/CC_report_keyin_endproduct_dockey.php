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
					$condate1 = " AND (date(t1.datetime_approve) NOT IN($in_date))";
			}else{
					$condate1 = "";	
			}
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

			$yymm = date("Y-m");
			$lastmonth = LastMonth($yymm);	
			$conid = " AND date(t2.datetime_approve) LIKE '$yymm%' and (t1.datekeyin LIKE '$yymm%' or t1.datekeyin LIKE '$lastmonth%' ) and t1.datekeyin < '".date("Y-m-d")."' $condate1";
			
			

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
		
	$start_d = date("Y-m-d");
	for($i=1;$i < 60 ; $i++){
				$xbasedate = strtotime("$start_d");
				 $xdate = strtotime("-$i days",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
				 
				 
				 	$sql = "SELECT
t1.datekeyin,
Count(distinct t1.idcard) AS keydoc
FROM stat_user_keyperson as t1 Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard
WHERE  t2.status_keydata='1' and t2.approve='2' and  t1.datekeyin < '$xsdate'
group by t1.datekeyin
having keydoc > 100
order by t1.datekeyin DESC
limit 1";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);

		
		$dockey_perday =  $rs[keydoc];// เอกสารที่คีย์ได้ในแต่ละวัน
		$sql_replace = "REPLACE INTO view_report_keykp7 SET date_report='".$xsdate."',dockey_perday='$dockey_perday'";
		//echo $sql_replace."<br>";
		mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE__".__LINE__);
	}//end for($i=1;$i < 60 ; $i++){
		
			 
	

 $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
