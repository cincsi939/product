<?php /*<script src="'.$pathUrl.'SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>*/

require_once('lib/nusoap.php'); 
$ws_client = new nusoap_client('http://soapservices.sapphire.co.th/index.php?wsdl',true); 
//$ws_client = new nusoap_client('http://192.168.2.12/webservices/index.php?wsdl',true); 

$file = array('jquery-1.8.1.min.js');

$script = json_encode($file);
$para = array('script' => $script);
$result = $ws_client->call('script', $para);
echo $result;

$para = array(
		'pathbeforesmcore' => '../', 									//กำหนด path ที่โฟลเดอร์ก่อน UploadFile จนถึงก่อนโฟลเดอร์รูปที่ต้องการอัพโหลด
		'pathfolder' => '../', 											//กำหนด path ที่ตำแหน่งปัจจุบันจนถึงก่อนโฟลเดอร์รูปที่ต้องการอัพโหลด
		'foldername' => 'upload/img/'.$_GET['id'].'/',								//กำหนดชื่อโฟลเดอร์ที่ต้องการจะบันทึกรูปเมื่ออัพโหลดเสร็จ
		'formid' => 'fileupload',											//ถ้าเรียกFunction uploadfile() ในแท๊ก form ให้กำหนดค่า id ของ form ที่เรียก Function uploadfile()
		'path' => 'http://61.19.255.77/trat_eq/application/plugin/upload/js/', //กำหนด path เพื่อเรียกไฟล์ uploadfile_v1.rar ที่ท่านติดตั้ง
		'maxfilesize' => 5000000, 									//กำหนด Size มากที่สุดที่สามารถอัพโหลดได้ Default คือ 5 Mb = 5000000
		'acceptfiletypes' => '/(\.|\/)(pdf|gif|jpe?g|png)$/i', //กำหนดประเภทนามสกุลที่สามารถอัพโหลดได้
		'btnstart' => true,												//เปิด-ปิดปุ่มStart
		'btncancel' => true,											//เปิด-ปิดปุ่มCancel
		'btndelete' => true,											//เปิด-ปิดปุ่มDelete
		'version' => '1.0'													//กำหนด version เพื่อเรียกใช้งาน
	);	
	 $result = $ws_client->call('uploadimages_v1', $para);
?>

<?php  echo $result; ?>