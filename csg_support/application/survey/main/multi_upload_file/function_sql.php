<?php

function getDocType($doc_id=""){
	$where = "";
	if( $doc_id != "" ){
		$where = " AND doc_id = '".$doc_id."' ";
	}
	$arrOutput = array();
	$sql = "SELECT doc_id AS doc_id,
							doc_prefix_name AS doc_prefix_name,
							doc_type_name AS doc_type_name,
							doc_orderby AS doc_orderby,
							doc_active AS doc_active
			   FROM qua_document_type 
			   WHERE doc_active = '1' ".$where." ORDER BY doc_orderby ";
	$result = mysql_db_query('cmss_qualification',$sql) or die(mysql_error());
	while( $row = mysql_fetch_array($result) ){
		$arrOutput[$row['doc_id']]['doc_prefix_name'] = $row['doc_prefix_name'];
		$arrOutput[$row['doc_id']]['doc_type_name'] = $row['doc_type_name'];
		$arrOutput[$row['doc_id']]['doc_orderby'] = $row['doc_orderby'];
		$arrOutput[$row['doc_id']]['doc_active'] = $row['doc_active'];
	}
	return $arrOutput;
}

 function checkUploadfile($req_id,$doc_id){
 	$sql = "SELECT count(id) AS num
			FROM req_qualification_filesattach
			WHERE req_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	$result = mysql_db_query('cmss_qualification',$sql)or die(mysql_error());
	$row = mysql_fetch_array($result);
	if( $row['num'] >= 1){
		return true;
	}else{
		return false;
	}
 }
 
 function getMAxFileNo($req_id,$doc_id){
 	$sql = "SELECT MAX(doc_no) AS doc_no
			FROM req_qualification_filesattach
			WHERE req_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	$result = mysql_db_query('cmss_qualification',$sql)or die(mysql_error());
	$row = mysql_fetch_array($result);
	return $row['doc_no'];
 }
 
 function generateFileName($req_id,$doc_id){
	 if( checkUploadfile($req_id,$doc_id) == false ){
		 $file_name = "";
		 $sql = "SELECT doc_prefix_name AS doc_prefix_name
					FROM qua_document_type
					WHERE doc_id = '".$doc_id."' ";
		 $result = mysql_db_query('cmss_qualification',$sql)or die(mysql_error());
		 $row = mysql_fetch_array($result);
	 	 $file_name .= $row['doc_prefix_name'];
		 $file_name .= '_'.$req_id.'_'.str_replace('-','',date('Y-m-d')).'_1.pdf';
	 }else{
	 	 $file_name = "";
		 $sql = "SELECT doc_prefix_name AS doc_prefix_name
					FROM qua_document_type
					WHERE doc_id = '".$doc_id."' ";
		 $result = mysql_db_query('cmss_qualification',$sql)or die(mysql_error());
		 $row = mysql_fetch_array($result);
	 	 $file_name .= $row['doc_prefix_name'];
		 $file_name .= '_'.$req_id.'_'.str_replace('-','',date('Y-m-d'));
		 $doc_no = (getMAxFileNo($req_id,$doc_id)+1);
		 $file_name .= '_'.$doc_no.'.pdf';
	 }
	 return $file_name;
 }
 
 function addfileToDB($req_id,$doc_id,$caption,$upload_type=""){
	 if( checkUploadfile($req_id,$doc_id) == false ){
		 $doc_no = '1';
	 }else{
	 	 $doc_no = (getMAxFileNo($req_id,$doc_id)+1); 
	 }
	 $file_name = generateFileName($req_id,$doc_id);
	 $user_name = $_SESSION['office_name'];
	 $user = $_SESSION['session_username'];
	 $ip = $_SERVER['REMOTE_ADDR'];
 	$sqlUpdate = "INSERT INTO req_qualification_filesattach 
						SET req_id = '".$req_id."',
							  doc_id = '".$doc_id."',
							  doc_no = '".$doc_no."',
							  caption = '".$caption."',
							  upload_type = '".$upload_type."',
							  upload_by = '".$user_name."',
							  upload_byid = '".$user."',
							   upload_ip = '".$ip."',
							  date_upload = NOW(),
							  full_path_name = '/repo_cmss/qualification/attach_files/".$file_name."',
							  filename = '".$file_name."',
							  file_status = '1',
							  timecreate = NOW(),
							  timeupdate = NOW()
						";
	 mysql_db_query('cmss_qualification',$sqlUpdate);
 }
?>