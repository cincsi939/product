<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 

@include("../../config/conndb_nonsession.inc.php");
@include("../../../../config/conndb_nonsession.inc.php");
@include("../../../config/conndb_nonsession.inc.php");
$dbcallcenter_entry =DB_USERENTRY  ;
$dbnamemaster=DB_MASTER;
$dbsystem = "competency_system";
$dbname_temp = DB_CHECKLIST;
$config_yy = "52";
$activity_idkey = 3; // งานมอบหมายเอกสารคีย์ข้อมูล
$path_pdf = "../../../".PATH_KP7_FILE."/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='20' height='21' border='0'>";	

require_once('fpdipage/fpdf.php');
require_once('fpdipage/FPDI_Protection.php');
function GetCountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}

?>