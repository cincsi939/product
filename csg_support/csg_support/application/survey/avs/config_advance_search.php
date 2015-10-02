<?
$server_ip = "61.19.255.77";
$database_name = "question_project";
$tbl_table = "question_detail_1";
$username = "family_admin"; 
$password = "F@m!ly[0vE";
$tbl_map = ""; // หากไม่ระบุ map ระบบจะอ่านชื่อจาก comment ของ field
$normal = "question_idcard_detail"; // เงื่อนไขการ search ของ basic search
$advance = "true"; //ต้องการใช้ advance search (true) หรือ basic search (false) 
$output = "question_idcard_detail"; // ชื่อ field ผลลัพธ์ที่ต้องการ
$input_showquery = "false";//เปิดโหมด debug query : true ,false
$viewoutput = "xml"; //xml , table
$url_result = "form_result.php?other=demo_advance_search";  //หน้ารับค่า หากต้องการส่งค่าพ่วงไปด้วย สามารถส่งเหมือนค่า $_GET ได้
$para_query = "";  // พารามิเตอร์พิเศษ ใช้เพิ่มเป็นเงื่อนไขบังคับต่อท้ายระบบ (เช่น and org_id = "9" )
?>