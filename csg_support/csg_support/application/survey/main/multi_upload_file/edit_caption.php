<?php
session_start();
include('../../../config/conndb_nonsession.inc.php');
include('function_sql.php');
$req_id = $_GET['req_id'];
$doc_id = $_GET['doc_id'];
$doc_no = $_GET['doc_no'];
$newCaption = $_GET['newCaption'];

$sqlUpdate = "UPDATE req_qualification_filesattach SET `caption` = '".$newCaption."' WHERE req_id='".$req_id."' AND doc_id='".$doc_id."' AND doc_no='".$doc_no."' ";
mysql_db_query('cmss_qualification',$sqlUpdate);
?>