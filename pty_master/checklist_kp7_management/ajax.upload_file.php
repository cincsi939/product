<?php
	include("../../config/conndb_nonsession.inc.php");
	$db_temp = DB_CHECKLIST;
	session_start();
	$pathdir = '../../../checklist_kp7file/'; 
	$uploaddir=$pathdir."zipfile/";
	$extractdir=$pathdir."fileall/";

	$userid = $_GET[userid] ? $_GET[userid] : $_SESSION[session_staffid];

	function getRealIpAddr(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	//Function สุ่ม ตัวเลข | วิธีใช้งาน :  randomcharactor (ความยาวอักษรที่ต้องการสุ่ม) by Paak  
	function randomcharactor2 ($length){
		$possible = '0198765432';
		$possible.= 'abcdefghijklmnopqrstuvwxyz';
		$str=" ";
		while ( strlen ($str) <= $length){
			$str .= substr ($possible, (rand() % strlen($possible)), 1);
		}
		return (trim($str));
	}
	
	$ranname = $userid."_".date("ymdHis")."_".randomcharactor2('4');
	$file = $uploaddir . $ranname . substr(basename($_FILES['uploadfile']['name']),-4); 
	while(is_file($file)){//ตรวจสอบไฟล์ซ้ำ้้ 
		$ranname = $userid."_".date("ymdHis")."_".randomcharactor2('4');
		$file = $uploaddir . $ranname . substr(basename($_FILES['uploadfile']['name']),-4); 		
	}

	$realfilename = $_FILES['uploadfile']['name'];			
	$zipfilename = $ranname . substr(basename($_FILES['uploadfile']['name']),-4);			
	$size=$_FILES['uploadfile']['size'];	
	$hashx = hash_file('md5',$uploadfile);		

	## คืนค่า สำเร็จ หรือไม่สำเร็จ
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
		$sql="
			insert into pdf_zip set
				staffid = '$userid',
				orgi_zipname = '$realfilename',
				zipfilename = '$zipfilename',
				ip =  '".getRealIpAddr()."',
				hashfile = '$hashx',
				filesize = '$size'
			";
		$result=mysql_db_query($db_temp,$sql);
		$upid=mysql_insert_id();	
		echo "$upid";
	} else {
		echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}


?>