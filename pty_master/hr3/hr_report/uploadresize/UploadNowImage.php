<?php error_reporting(E_ALL | E_STRICT);
require('../../../../common/SMLcore/Plugin/UploadFile/server/php/UploadHandler.php');

$options = array(
    'script_url' => 'uploadresize/UploadNowImage.php', // สำหรับโยงมายังไฟล์เซิร์ฟเวอร์สคริป เพื่อการทำงานหลังอัพโหลดเสร็จสิ้น เช่นการลบรูปภาพ
	'upload_dir' => '../' . base64_decode($_GET['pathbeforesmcore']). base64_decode($_GET['foldername']), // ไดเร็กทอรี่ในการเก็บรูปภาพ
    'upload_url' => base64_decode($_GET['pathfolder']).base64_decode($_GET['foldername']), // URL ของการไดเร็กทอรี่ที่ใช้ในการเก็บรูปภาพ
	'pathbeforesmcore' => base64_encode(base64_decode($_GET['pathbeforesmcore'])),
	'foldername' => base64_encode(base64_decode($_GET['foldername'])),
	
        );

$upload_handler = new UploadHandler($options);


?>