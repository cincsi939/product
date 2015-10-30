<?php
define('FPDF_FONTPATH','/fpdi/font/');
require_once('fpdi/fpdf.php');


function pdfEncrypt ($origFile, $password, $destFile){
//include the FPDI protection http://www.setasign.de/products/pdf-php-solutions/fpdi-protection-128/
require_once('fpdi/FPDI_Protection.php');

$pdf =& new FPDI_Protection();
// set the format of the destinaton file
$pdf->FPDF('P', 'mm', array(260,380));

//calculate the number of pages from the original document
$pagecount = $pdf->setSourceFile($origFile);

// copy all pages from the old unprotected pdf in the new one
for ($loop = 1; $loop <= $pagecount; $loop++) {
$tplidx = $pdf->importPage($loop);
$pdf->addPage();
$pdf->useTemplate($tplidx);
}

// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
$pdf->SetProtection(array(), $password, '');
$pdf->Output($destFile, 'F');

return $destFile;
}

//password for the pdf file (I suggest using the email adress of the purchaser)
$password = "0101";

//name of the original file (unprotected)
$origFile = "3501600025242.pdf";

//name of the destination file (password protected and printing rights removed)
$destFile ="3501600025242_x.pdf";

//encrypt the book and create the protected file
pdfEncrypt($origFile, $password, $destFile );
?>