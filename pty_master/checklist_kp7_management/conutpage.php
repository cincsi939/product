<?
require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');

function CountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}
?>