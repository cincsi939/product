<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");

							$sitesource = "0119_20110621";
							$sitedest = "0119";
							$idcard = "4359900002229";
							$schoolid = "760327";
							$result_tranfer = transfer_data($idcard,$sitesource,$sitedest,$schoolid,$schoolid,"99","Script_Tranfer_Data");
							echo "<pre>";
							print_r($result_tranfer);
							
echo "DONE...";

?>

