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
			

			//echo $profile_id;die;
			$start_project = "2011-02-01"; // �ѹ��������ѭ���ç���
			$end_date_project = "2012-01-27"; 	## �ѹ����ش�ç���
			$curent_date_project = date("Y-m-d"); // �ѹ���Ѩ�غѹ�ͧ�ç���
			$point_per_doc = 69; // ��Ҥ�ṵ�ͪش
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			$sql_day = "SELECT * FROM view_report_keykp7 WHERE date_report LIKE '2011-08%' ORDER BY  date_report ASC";
			$result_day = mysql_db_query($dbnameuse,$sql_day) or die(mysql_error()."$sql_day<br>LINE__".__LINE__);
			while($rsd = mysql_fetch_assoc($result_day)){
					$numHoliday = GetNumHoliday($rsd[date_report],$end_date_project); // �Ѻ�ӹǹ�ѹ��ش
						ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
					$numdayproject = GetNumDayOfDate($rsd[date_report],$end_date_project)-$numHoliday;
					$sql_update = "UPDATE view_report_keykp7 SET day_work='$numdayproject' where date_report='$rsd[date_report]' ";
					mysql_db_query($dbnameuse,$sql_update);
					echo $sql_update."<br>";
			}//end while($rsd = mysql_fetch_assoc($result_day)){
			
			
			

					 
					 

	

 $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
?>
