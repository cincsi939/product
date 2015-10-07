<?php
/**
 * @comment 		define var
 * @projectCode	P1
 * @tor
 * @package			core
 * @author			Eakkaksit Kamwong
 * @created			31/08/2015
 * @access			public
 */
#### ตัวแปรเกี่ยวกับคำต่างๆ
  define('TXT_DCY_MASTER','dcy_master');
  define('TXT_DCY_WEBSITE','dcy_website');
  define('TXT_DCY_USERMANAGER','dcy_usermanager');
  define('TXT_ORG_PARENT',$_SESSION["session_org_parent"]); //เงื่อนไขแสดงหน่วยงานในlistbox peerasak sane
  
   #### ค่า Define สำหรับการแสดงผลข้อความของ
	#@modefy Suwat.k 28/09/2015 ข้อความสำหรับแสดงผลในระบบรับแจ้งเรื่องร้องทุกข์
		define('TXT_NO','ลำดับ'); # ข้อความ ลำดับ
		define('TXT_NO_RECIVED','รหัสรับแจ้ง'); # ข้อความ รหัสรับแจ้ง
		define('TXT_DATE_RECIVED','วันเวลารับแจ้ง');
		define('TXT_TITLE_RECIVED','หัวข้อเหตุการณ์');
		define('TXT_USER_RECIVED','ผู้แจ้ง');
		define('TXT_PRIORITY_RECIVED','ความเร่งด่วน');
		define('TXT_GPROUP_PLB_RECIVED','หมวดปัญหา');
		define('TXT_STATUS_RECIVED','สถานะเรื่อง');
		define('TXT_INFORMER_RECIVED','ผู้รับแจ้ง');
		define('TXT_TOOLS_RECIVED','เครื่องมือ');
	#@end 
?>
