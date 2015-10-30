<?php
ob_start();
set_time_limit(0);
$file = $_GET['code'];
$write_data = file_get_contents("tmp_pdf/".$file.".pdf");
//header("Content-Description: File Transfer");
//header("Content-Type: application/force-download");
header("Pragma: public");
header("Content-Transfer-Encoding: binary"); 
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=\"$file.pdf\"");
echo "$write_data";
?>