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
			//echo $profile_id;die;
			$start_project = "2011-02-01"; // �ѹ��������ѭ���ç���
			$end_date_project = "2012-01-27"; 	## �ѹ����ش�ç���
			$curent_date_project = date("Y-m-d"); // �ѹ���Ѩ�غѹ�ͧ�ç���
			$point_per_doc = 69; // ��Ҥ�ṵ�ͪش
			$arrsite = GetSiteKeyData();
			$numHoliday = GetNumHoliday($curent_date_project,$end_date_project); // �Ѻ�ӹǹ�ѹ��ش
			#$numHoliday_s = GetNumHoliday($start_project,$curent_date_project); // �Ѻ�ӹǹ�ѹ��ش��͹�ѹ�Ѩ�غѹ
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			### �Ѻ�ӹǹ�ѹ�������ͧ͢�ç������ѧ����ѡ�ѹ��ش
			
		echo "�ӹǹ�ѹ��ش  : ".$numHoliday;
		echo "<br>�ӹǹ�ѹ��������¤Դ�ҡ�ѹ�Ѩ�غѹ�֧����ش�ç��� :".GetNumDayOfDate($curent_date_project,$end_date_project);
			$numdayproject = GetNumDayOfDate($curent_date_project,$end_date_project)-$numHoliday; // �������Ҥ������
			#$numdayproject_s  = GetNumDayOfDate($start_project,$curent_date_project)-$numHoliday_s; // �������ҷ���������������

			
		
			
			
			

			 
			 
					 

	

 $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
?>
