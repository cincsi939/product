<?php
/**
 * @comment 		define db
 * @projectCode	P1
 * @tor
 * @package			core
 * @author			Eakkaksit Kamwong
 * @created			31/08/2015
 * @access			public
 */

	#### ตัวแปรเกี่ยวกับฐานข้อมูล
	DEFINE("DB_USERMANAGER", "dcy_usermanager"); # ฐานข้อมูล usermanager
	DEFINE("DB_MASTER", "dcy_master");
	DEFINE("DB_NAME", "dcy_master");
	DEFINE("DB_EPBM", "dcy_epbm");
	DEFINE("DB_OSCC","dcy_oscc");		# Kaisorrawat panyo สร้างตัวแปร define กับค่า DBNAME ชื่อฐานข้อมูล
	DEFINE("DB_XMLSERVICE","dcy_xmlservice");		# ฐานข้อมูล การส่งออก xml
	DEFINE("DB_DONATE","dcy_donate"); #Peerasak sane ฐานข้อมูล ระบบบริจาคทรัพยากร
	DEFINE("DB_REPORT","reportbuilder_dcy"); # ฐานข้อมูลของ Reportbuilder
	
	#@modify Suwat.k 24/09/2015 ตัวแปร username และ password สำหรับเชื่องต่อฐานข้อมูล
	DEFINE("USERNAME", "wandc"); 
	DEFINE("PASSWORD","c;ofu:u");
	#@end

?>
