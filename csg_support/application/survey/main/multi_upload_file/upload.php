<?php
session_start();
ini_set('post_max_size', '2M');
ini_set('upload_max_filesize', '2M');
include('../../../config/conndb_nonsession.inc.php');
include('function_sql.php');
$output_dir = "../../../../repo_cmss/qualification/attach_files/";
$req_id = $_GET['req_id'];
$doc_id = $_GET['doc_id'];
$caption = $_GET['caption'];

if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName =  generateFileName($req_id,$doc_id);
 		if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName)){
			addfileToDB($req_id,$doc_id,$caption,'REQ');
		}
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName =  generateFileName($req_id,$doc_id);
		if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName)){
			addfileToDB($req_id,$doc_id,$caption,'REQ');
		}
	  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($_GET);
 }
 
 ?>