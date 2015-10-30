<?php   
header("Content-Type: text/plain; charset=windows-874");    
session_start();

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_general";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
//include ("../libary/function.php");
//include ("checklogin.php");
//include ("../../../config/phpconfig.php");
//include ("timefunc.inc.php");
//ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");

$q =  iconv( 'UTF-8', 'TIS-620', $_GET["q"])  ; 
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง   
$table_db="article"; // ตารางที่ต้องการค้นหา   
$find_field="arti_topic"; // ฟิลที่ต้องการค้นหา   

//$sql = "select * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql="SELECT
allschool.office,
eduarea.secname,
allschool.id
FROM
allschool
Inner Join eduarea ON allschool.siteid = eduarea.secid where   allschool.office like '%$q%' order by allschool.office limit 100"  ;
 $select1  = mysql_db_query(DB_MASTER,$sql)or die(mysql_error()); 
 $name = str_replace("'", "", $sql);   

 while ($row=mysql_fetch_array($select1,MYSQL_ASSOC)){ 
   $xid = $row["id"]; // ฟิลที่ต้องการส่งค่ากลับ   
   $name =  $row["office"]." : ". str_replace("สำนักงานเขตพื้นที่การศึกษา", "สพท.", $row["secname"]);    ; // ฟิลที่ต้องการแสดงค่า   
   // ป้องกันเครื่องหมาย '   
    $name = str_replace("'", "'", $name);   
    // กำหนดตัวหนาให้กับคำที่มีการพิมพ์   
    $display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);   
    echo "<li onselect=\"this.setText('$name').setValue('$xid');\">$display_name</li>"; 
 }

?>