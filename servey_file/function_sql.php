<?php

function getDocType($doc_type="REQ"){
	$where = "";
	if( $doc_type != "" ){
		$where = " AND doc_group = '".$doc_type."' ";
	}
	$arrOutput = array();
	$sql = "SELECT doc_id AS doc_id,
							doc_prefix_name AS doc_prefix_name,
							doc_type_name AS doc_type_name,
							doc_orderby AS doc_orderby,
							doc_active AS doc_active
			   FROM eq_document_type 
			   WHERE doc_active = '1' ".$where." ORDER BY doc_orderby ";
	//echo $sql.'<hr>';
	$result = mysql_db_query('csg_data',$sql) or die(mysql_error());
	while( $row = mysql_fetch_array($result) ){
		$arrOutput[$row['doc_id']]['doc_prefix_name'] = $row['doc_prefix_name'];
		$arrOutput[$row['doc_id']]['doc_type_name'] = $row['doc_type_name'];
		$arrOutput[$row['doc_id']]['doc_orderby'] = $row['doc_orderby'];
		$arrOutput[$row['doc_id']]['doc_active'] = $row['doc_active'];
	}
	return $arrOutput;
}

 function checkUploadfile($req_id,$doc_id,$upload_type=""){
	 if( $upload_type == 'APPV' ){
		$sql = "SELECT count(id) AS num
				FROM eq_qualification_filesattach
				WHERE letter_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	 }else{
	 	$sql = "SELECT count(id) AS num
				FROM eq_qualification_filesattach
				WHERE req_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	 }
	$result = mysql_db_query('csg_data',$sql)or die(mysql_error());
	$row = mysql_fetch_array($result);
	if( $row['num'] >= 1){
		return true;
	}else{
		return false;
	}
 }
 
 function getMAxFileNo($req_id,$doc_id,$upload_type){
	 if( $upload_type == 'APPV' ){
		$sql = "SELECT IF(MAX(doc_no) IS NULL,1,MAX(doc_no)) AS doc_no
				FROM eq_qualification_filesattach
				WHERE req_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	 }else{
	 	$sql = "SELECT IF(MAX(doc_no) IS NULL,1,MAX(doc_no)) AS doc_no
				FROM eq_qualification_filesattach
				WHERE letter_id = '".$req_id."' AND doc_id = '".$doc_id."' ";
	 }
	$result = mysql_db_query('csg_data',$sql)or die(mysql_error());
	$row = mysql_fetch_array($result);
	return $row['doc_no'];
 }
 
 function generateFileName($req_id,$doc_id,$upload_type=""){
		 if( checkUploadfile($req_id,$doc_id,$upload_type) == false ){
			 $file_name = "";
			 $sql = "SELECT doc_prefix_name AS doc_prefix_name
						FROM eq_document_type
						WHERE doc_id = '".$doc_id."' ";
			 $result = mysql_db_query('csg_data',$sql)or die(mysql_error());
			 $row = mysql_fetch_array($result);
			 $file_name .= $row['doc_prefix_name'];
			 $file_name .= '_'.$req_id.'_'.str_replace('-','',date('Y-m-d')).'_1.pdf';
		 }else{
			 $file_name = "";
			 $sql = "SELECT doc_prefix_name AS doc_prefix_name
						FROM eq_document_type
						WHERE doc_id = '".$doc_id."' ";
			 $result = mysql_db_query('csg_data',$sql)or die(mysql_error());
			 $row = mysql_fetch_array($result);
			 $file_name .= $row['doc_prefix_name'];
			 $file_name .= '_'.$req_id.'_'.str_replace('-','',date('Y-m-d'));
			 $doc_no = (getMAxFileNo($req_id,$doc_id,$upload_type)+1);
			 $file_name .= '_'.$doc_no.'.pdf';
		 }
	 return $file_name;
 }
 
 function addfileToDB($req_id="",$doc_id="",$caption="",$upload_type=""){
	 if( $upload_type == 'APPV' ){
		 $doc_no = '1';
	 }else{
		 if( checkUploadfile($req_id,$doc_id,$upload_type) == false ){
			 $doc_no = '1';
		 }else{
			 $doc_no = (getMAxFileNo($req_id,$doc_id,$upload_type)+1); 
		 }
	 }
	 $file_name = generateFileName($req_id,$doc_id,$upload_type);
	 $user_name = $_SESSION['office_name'];
	 $user = $_SESSION['session_username'];
	 $ip = $_SERVER['REMOTE_ADDR'];
	 if( $upload_type == 'APPV' ){
		/*	$sqlUpdate = "INSERT INTO eq_qualification_filesattach 
							SET letter_id = '".$req_id."',
								  doc_id = '".$doc_id."',
								  doc_no = '".$doc_no."',
								  caption = '".$caption."',
								  upload_type = '".$upload_type."',
								  upload_by = '".$user_name."',
								  upload_byid = '".$user."',
								   upload_ip = '".$ip."',
								  date_upload = NOW(),
								  full_path_name = '/repo_cmss/attach_file_approve/".$file_name."',
								  filename = '".$file_name."',
								  file_status = '1',
								  timecreate = NOW(),
								  timeupdate = NOW()
							";
		 mysql_db_query('csg_data',$sqlUpdate);*/
		/* $sqlUpdateAppvFile = "SELECT
											req_id,
											req_detail_id
										FROM letter_cmd_attach
										WHERE letter_id = '".$req_id."'
										ORDER BY req_id ASC ";
		$resUpdateAppvFile = mysql_db_query(DB_VERIFICATION,$sqlUpdateAppvFile);
		while( $rowUpdateAppvFile = mysql_fetch_array($resUpdateAppvFile) ){
			$sql = "UPDATE report_req_qualification SET approve_document='".$file_name."' WHERE req_id = '".$rowUpdateAppvFile['req_id']."' AND req_detail_id = '".$rowUpdateAppvFile['req_detail_id']."' ";
			mysql_db_query('csg_data',$sql) or die('<script>console.log("'.mysql_error().' :: '.__LINE__.'")</script>');
		}*/
	 }else{
		 $sqlUpdate = "INSERT INTO eq_qualification_filesattach 
							SET req_id = '".$req_id."',
								  doc_id = '".$doc_id."',
								  doc_no = '".$doc_no."',
								  caption = '".$caption."',
								  upload_type = '".$upload_type."',
								  upload_by = '".$user_name."',
								  upload_byid = '".$user."',
								   upload_ip = '".$ip."',
								  date_upload = NOW(),
								  full_path_name = '../../../../../repo_csg/survey/".$file_name."',
								  filename = '".$file_name."',
								  file_status = '1',
								  timecreate = NOW(),
								  timeupdate = NOW()
							";
		 mysql_db_query('csg_data',$sqlUpdate);
	 }
 }
?>