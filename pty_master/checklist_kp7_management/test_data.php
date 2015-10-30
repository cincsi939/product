<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("class/class.compare_data.php");
include("../../common/class.import_checklist2cmss.php");
include("../../common/class.getdata_master.php");
include("class.check_error.php");
$obj_imp = new ImportData2Cmss();
$obj_master = new GetDataMaster();

### ตรวจสอบเลขบัตร
$obj_checkdata = new CheckDataError();

$age = $obj_checkdata->GetAge("2525-10-13");
echo "ตรวจสอบ :".$age;
die();

?>
