<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับระบบบันทึกข้อมูลข้าราชการครูและบุคลากรทางการศึกษา สำนักการศึกษา กรุงเทพมหานคร
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core(or plugin)
* @author Pannawit
* @access public/private
* @created 01/10/2014
*/
require_once("../../config/conndb_nonsession.inc.php");
//require_once("../../common/common_competency.inc.php");
//check_redirec();
//echo GET_IPADDRESS();

$url = APPURL.APPNAME."application/userentry/login.php";
header("Location: $url");
?>
