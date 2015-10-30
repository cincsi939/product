<?php error_reporting(E_ALL | E_STRICT);
require('../../../common/SMLcore/Plugin/UploadFile/server/php/UploadHandler.php');
//$upload_handler = new UploadHandler();
$options = array(
    'script_url' => 'UploadNow.php', // สำหรับโยงมายังไฟล์เซิร์ฟเวอร์สคริป เพื่อการทำงานหลังอัพโหลดเสร็จสิ้น เช่นการลบรูปภาพ
    'upload_dir' => 'uploadImg/', // ไดเร็กทอรี่ในการเก็บรูปภาพ
    'upload_url' => 'uploadImg/', // URL ของการไดเร็กทอรี่ที่ใช้ในการเก็บรูปภาพ
        );
$error_messages = array(
       	1 => 'ไฟล์ที่อัพโหลดมีขนาดไฟล์เกินกว่าคำสั่งใน php.ini',
		2 => 'ไฟล์ที่อัพโหลดมีขนาดไฟล์เกินขนาดที่กำหนด',
		3 => 'ไฟล์ที่อัพโหลดถูกอัพโหลดเพียงบางส่วนเท่านั้น',
		4 => 'ไม่มีไฟล์อัพโหลด',
		6 => 'ไม่สามารถหาโฟลเดอร์ชั่วคราว',
		7 => 'ล้มเหลวในการเขียนไฟล์ในดิสก์ ',
		8 => 'PHP หยุดการอัพโหลดไฟล์',
		'post_max_size' => 'ไฟล์ที่อัพโหลดขนาดใน php.ini',
		'max_file_size' => 'ไฟล์มีขนาดใหญ่เกินไป',
		'min_file_size' => 'ไฟล์มีขนาดเล็กเกินไป',
		'accept_file_types' => 'ไม่สามารถใช้นามสกุลไฟล์นี้',
		'max_number_of_files' => 'จำนวนไฟล์เกินจำนวนสูงสุดของการอัพโหลด',
		'max_width' => 'ขนาดความกว้างภาพเกินกว่าที่กำหนด',
		'min_width' => 'ขนาดความกว้างภาพต่ำกว่าที่กำหนด',
		'max_height' => 'ขนาดความสูงภาพเกินกว่าที่กำหนด',
		'min_height' => 'ขนาดความสูงภาพต่ำกว่าที่กำหนด'
    );
$upload_handler = new UploadHandler($options);
?>