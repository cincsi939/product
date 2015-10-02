<?php
session_start();
include('../../../config/conndb_nonsession.inc.php');

$sql = "SELECT filename AS filename,
					   full_path_name AS full_path_name,
					   doc_id AS doc_id,
					   doc_no AS doc_no,
					   `caption` AS caption
			FROM req_qualification_filesattach
			WHERE req_id = '".$_GET['req_id']."' AND doc_id = '".$_GET['doc_id']."' ";
$result = mysql_db_query('cmss_qualification',$sql)or die(mysql_error());
$outPut = array();
$index = 0;
while( $row = mysql_fetch_array($result) ){
	$outPut[$index]['full_path_name'] = $row['full_path_name']; 
	$outPut[$index]['file_name'] = $row['filename']; 
	$outPut[$index]['doc_id'] = $row['doc_id']; 
	$outPut[$index]['doc_no'] = $row['doc_no']; 
	$outPut[$index]['caption'] = iconv('tis-620','utf-8',$row['caption']); 
	$index++;
}
echo json_encode($outPut);
?>