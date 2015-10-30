
<?
if ($_SESSION[session_sapphire] == 1 ){
$main_url = "index_key_report.php" ;
}else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}


$menu_group = array("หน้าหลัก"=>"$main_url,iframe_body","ระบบค้นหาข้อมูล"=>"qsearch2.php,iframe_body","การจัดการข้อมูลระบบ"=>"","รายงาน"=>"","ทดสอบความเร็ว"=>"../diagnose/bandwidth/initialmeter.php,_blank","ออกจากระบบ"=>"logout.php,_top");

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1 ){
	


$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank",
							 "เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../pic2cmss_entry/login_main.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php,_blank")
//"รายงานสรุปการบันทึกข้อมูล"=>"report_sum.php",
//"ประมวลผล Ranking "=>"ranking.inc.php",
);
} else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","ระบบสุ่มตรวจสอบข้อมูล"=>"report_alert_qc1.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../pic2cmss_entry/login_main.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")



);


}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบนำเข้ารูป ก.พ.7"=>"../pic2cmss_entry/login_main.php,_blank"),
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));
}else{

$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php"),
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

}

if($_SESSION[session_staffid] != 93 AND $_SESSION[session_staffid] != 9948 AND $_SESSION[session_staffid] != 95 AND $_SESSION[session_staffid] != 57 AND $_SESSION[session_staffid] != 9974){
	unset($menu_array['รายงานจัดการผู้ใช้']);
}

if($_SESSION[session_staffid] == 10691){ // กรณีเป็น userของ ก.ค.ศ. ที่เข้ามาดูหน้ารายงาน
	unset($menu_group['การจัดการข้อมูลระบบ']);
	unset($menu_group['ระบบค้นหาข้อมูล']);
/*	"รายงาน"=>array("รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php,_blank")*/
	unset($menu_array['รายงานสถิติสำหรับผู้บริหาร']);
	unset($menu_array['การเข้างานลูกจ้างประจำ']);
	unset($menu_array['รายงานสถิติการตรวจข้อมูล']);

}


		echo "<DIV id=content>";
		echo "<UL id=navmenu-v>";
  $c= 0;
  foreach ($menu_group as $caption=>$url){
  		$exdata = explode(",",$url);
		$url = $exdata[0];
		$target = $exdata[1];
		// สร้างหัวข้อ
		if($url==""){
			$strurl = "<LI ><A href=\"#\">$caption +</A>"; 
			$endLI = "</LI>";
		}else{
			$strurl = "<LI><a href=\"$url\" TARGET=\"$target\">$caption</a></LI>";
			$endLI = "";
		}
		echo "$strurl";
	
			
			foreach ($menu_array as $key=>$val){
				if($key==$caption){
						echo "<UL>";
					
						foreach ($val as $key1=>$url1){
							$exdata1 = explode(",",$url1);
							$url1 = $exdata1[0];
							if($exdata1[1] != ""){
							$target = $exdata1[1];
							}else{
							$target = 'iframe_body';
							}
							echo "<LI><a href=\"$url1\" TARGET=\"$target\" >$key1</a></LI>";
						}
					echo "</UL>";
				}
			}
			echo $endLI;
	}
		echo "</UL>";
		echo "</DIV>";


?>
