<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("class/class.compare_data.php");
include("../../common/class.import_checklist2cmss.php");

$obj = new Compare_DataImport();
$arr_field = array();
$arr_compare = array();
$arr_field = $obj->GetFieldCompare();
$confield = $obj->GetConField($arr_field);

## ตรวจสอบข้อมูลที่จะนำเข้าสู่ cmss
$obj_imp = new ImportData2Cmss();


if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}

?>
