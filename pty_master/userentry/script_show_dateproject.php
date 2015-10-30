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
			
		echo "จำนวนวันหยุด  : ".$numHoliday;
		echo "<br>จำนวนวันคงเหลือโดยคิดจากวันปัจจุบันถึงสิ้นสุดโครงการ :".GetNumDayOfDate($curent_date_project,$end_date_project);
			$numdayproject = GetNumDayOfDate($curent_date_project,$end_date_project)-$numHoliday; // ระยะเวลาคงเหลือ
			#$numdayproject_s  = GetNumDayOfDate($start_project,$curent_date_project)-$numHoliday_s; // ระยะเวลาที่คีย์ข้อมูลไปแล้ว

			
		
			
			
			

			 
			 
					 

	

 $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
