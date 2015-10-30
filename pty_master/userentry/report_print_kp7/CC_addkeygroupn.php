<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/03/2011
#LastUpdate::29/03/2011
#DatabaseTable:tbl_person_print
#END
#########################################################
//session_start();

			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			require_once("../../../common/common_competency.inc.php");
			require_once("function_print_kp7.php");
			
			GetPersonKeyGroupN1To1();
			ProcessDocQC();
			AddQPrintkp7Gn();
			
		echo "Done.....";


 ?>