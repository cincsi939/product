<?
/**
* @comment config ค่าตัวแปรฐานข้อมูล
* @projectCode PS56DSDPW04
* @tor -
* @package core
* @author Suwat.k
* @access private
* @created 16/05/2014
*/
$iphost = $_SERVER[SERVER_NAME]; # อ้างถึง host
define("DB_MASTER","csg_master"); # ตัวแปรฐานข้อมูล master
define("DB_DATA","csg_data"); # ตัวแปรฐานข้อมูล data
define("DB_USERMANAGER","csg_usermanager"); # ตัวแปรฐานข้อมูล usermanager

define("HOST_DEFAULT","localhost"); # ค่า Default ของ host
define("HOST",$iphost); # ค่า host สำหรบ connect db
define("USER",'root'); # ค่า username สำหรับ connect db
define("PWD",'SPRD525@sapphire'); # ค่า pwd สำหรับ connect db

define("HOMEPAGE_MAIN",'http://csg.dcy.go.th/'); # ค่า pwd สำหรับ connect db

## ค่า define สำหรับ folder appliction
define('APP_MASTER','csg_master');
define('APP_SUPPORT','csg_support');
define('APP_REPORTBUILDER','reportbuilder_csg');
define('APP_REPO','repo_csg');	
?>