<?php
	include("../../config/conndb_nonsession.inc.php");
	session_start();
	$db_temp = DB_CHECKLIST;
	$pathdir = '../../../checklist_kp7file/'; 
	$uploaddir=$pathdir."zipfile/";
	$extractdir=$uploaddir."extract/";
	$destinydir=$pathdir."fileall/";

	require_once "dUnzip2.inc.php";
	require_once "dZip.inc.php";

	// เรียกดู เฉพาะ ไฟล์ ไม่นับ Folder 
	function scanDirectories($rootDir) {
	global $allData,$i;				
		$dirContent = scandir($rootDir);
		foreach($dirContent as $key => $content) {
			$path = $rootDir.'/'.$content;
			if(is_dir($path) && $content != "." && $content != "..") {
				$allData = scanDirectories($path);
			}else if(is_file($path)) {
				$allData[] = $path;
			}						
		}
		return $allData;
	}

	$userid = $_GET[userid] ? $_GET[userid] : $_SESSION[session_staffid];
	$sql=" select * from pdf_zip where uploadid  = $zip_id limit 1 ";
	$result=mysql_db_query($db_temp,$sql);
	if(@mysql_num_rows($result)>0){
		$Row = mysql_fetch_assoc($result);
		//echo "<pre>"; print_r($Row); echo "</pre>";
		$source_zip = $uploaddir.$Row[zipfilename];

		if(file_exists($source_zip)){
			
			# Check Dir
		 	$forder_extract = substr($Row[zipfilename],0,-4) ? substr($Row[zipfilename],0,-4) : date("dmyhis").rand(1000,9999);
			$extractpath=$extractdir.$forder_extract;
			if(!is_dir($extractpath)){mkdir($extractpath, 0777);}
			
			#Extrct
			$zip = new dUnzip2($source_zip);
			$zip->debug = false;
			$zip->getList();
			$zip->unzipAll($extractpath);
			
			#Scan Extract Dir
			$files_array = scanDirectories($extractpath);
			foreach($files_array as $key => $val ){
				$arr_name = explode("/",$val);
				$oncename = $arr_name[count($arr_name)-1];
				$target_file = $destinydir . $oncename;
				if(copy($val,$target_file)){
					$success++;
					$strSQL="
					
					";					
				}else{
					$unsuccess++;
				}
			}
			
			echo "suc:".intval($success).":uns:".intval($unsuccess);
		}
	}
?>