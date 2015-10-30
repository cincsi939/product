<?
require_once('fpdipage/fpdf.php');
require_once('fpdipage/FPDI_Protection.php');
function GetCountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}


?>