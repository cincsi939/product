<?php
session_start();
include('../../../config/conndb_nonsession.inc.php');
include('function_sql.php');
$output_dir = "../../../../repo_cmss/qualification/attach_files/";
$req_id = $_GET['req_id'];
$doc_id = $_GET['doc_id'];
$doc_no = $_GET['doc_no'];
$fileName =$_GET['name'];
$filePath = $output_dir.$fileName;
if (file_exists($filePath)) 
{
	unlink($filePath);
	$sqlDel = "DELETE FROM req_qualification_filesattach WHERE req_id='".$req_id."' AND doc_id='".$doc_id."' AND doc_no='".$doc_no."' ";
	mysql_db_query('cmss_qualification',$sqlDel);
}
?>