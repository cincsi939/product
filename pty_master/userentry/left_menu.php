
<?
$arr_staffreport = array();
$sql_staffreport  = "SELECT t1.staffid, t1.status_active FROM  keystaff_analyse_cost as t1 WHERE t1.status_active='1'";
$result_staffreport = mysql_db_query($dbnameuse,$sql_staffreport);
while($rssf = mysql_fetch_assoc($result_staffreport)){
		$arr_staffreport[$rssf[staffid]] = $rssf[staffid];
}//end while($rssf = mysql_fetch_assoc($result_staffreport)){




$staff_idarray = array('10217','10357','10192','10169','10092','10525','10559','10660','10591','10571','10762','10694','10399','10394');
if(in_array($_SESSION['session_staffid'],$staff_idarray)){
	$unlock_approve = 1;
}else{
	$unlock_approve = 0;	
}

if ($_SESSION[session_sapphire] == 1 ){
	if($_SESSION[session_staffid] == "11026"){ // สำหรับหัวหน้าวัชชัย
		$main_url = "../../report/report_keydata_main.php" ;
	}else{
		$main_url = "index_key_report.php" ;
	}
}else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}

if($_SESSION[session_staffid] == "11026"){
	$menu_group = array("หน้าหลัก"=>"$main_url,iframe_body","แสดง Session"=>"print_r_session.php,iframe_body","ออกจากระบบ"=>"logout.php,_top");
}else{
$menu_group = array("หน้าหลัก"=>"$main_url,iframe_body","บันทึกข้อมูลเงินเดือนที่ขาดหาย"=>"../hr3/tool_competency/script_check_data/script_checke_datasalary.php,_blank","บันทึกข้อมูล update 48 เขตนำร่อง"=>"report_keyupdate_areamain.php,iframe_body","ระบบค้นหาข้อมูล"=>"qsearch2.php,iframe_body","ค้นหาประวัติการจัดทำข้อมูล"=>"../req_approve/req_search.php,iframe_body","การจัดการข้อมูลระบบ"=>"","รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท."=>"","รายงานสำหรับผู้บริหาร"=>"","ทดสอบความเร็ว"=>"../diagnose/bandwidth/initialmeter.php,_blank","ตรวจสอบการนำเข้ารูป ก.พ.7"=>"../pic2cmss_entry_new/site_report.php?profile_id=4&direct_check=ON,_blank","แสดง Session"=>"print_r_session.php,iframe_body","ออกจากระบบ"=>"logout.php,_top");
}

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1  and $_SESSION[session_staffid] != "11026"){
	


/*$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank",
							 "เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../hr3/tool_competency/pic2cmss/_index.php","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),
*/
$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("ระบบบันทึกข้อมูล ขรก. เฉพาะข้อมูลปัจจุบัน"=>"index_report_keylast.php,_blank","เครื่องมือจัดการข้อมูลโรงเรียน"=>"../hr3/hr_tools2/manage_school.php","รายงานคงค้างการรับรองผลการบันทึกข้อมูลเขตต่อเนื่อง"=>"../hr3/tool_competency/diagnosticv1/index_list_approve_day_site.php,_blank","ระบบมอบหมายงานสำหรับเจ้าหน้าที่เขต"=>"index_assign_area.php","รายงานการปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile_timeall.php","ยืนยันแก้ไขข้อมูล ก.พ.7 จากคำร้องขอแก้ไขข้อมูล"=>"req_admin_verify.php","กำหนดเปิดปิดระบบรับรองข้อมูล"=>"../req_approve/admin_sapphire/main_manager.php,_blank","ระบบปลดรับรองข้อมูลนับตัวรายโรงเรียน"=>"../raise_salary/unapprove_school/index.php,_blank","กำหนดสถานะการป้องกันข้อมูลการมอบหมายงาน"=>"assign_protection.php","ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank","เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank","รายงาน Download Excel ข้อมูล กบข."=>"../gpf_download/index_download.php,_blank"),


"รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท."=>array("รายงานจำนวนรายการที่ยังไม่ได้ปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile.php","รายงานตรวจสอบข้อมูลรูปราชการครูและบุคลาการทางการศึกษา"=>"report_check_data_image.php"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเลือกวิทยฐานะ"=>"../../report/report_vitaya_wrong.php,_blank","รายงานการเลือกตำแหน่งไม่สัมพันธ์กับระดับ"=>"../../report/report_vitaya_not_match.php,_blank","รายงานวิเคราะห์ต้นทุน"=>"manage_keyin_data/performance_per_head.php,_blank","รายงานสำหรับ monitor คะแนนการคีย์ข้อมูลและการQCเอกสาร"=>"../hr3/tool_competency/report_monitor_qc/report_monitor_qc.php,_blank","รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php","รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล"=>"report_keydata_error.php,_blank","รายงานคีย์ข้อมูลผู้บริหาร"=>"report_executive_area.php,_blank","รายงานพนักงานคีย์ข้อมูลบันทึกข้อมูล Sub ในเวลางาน"=>"report_check_userkeydata.php,_blank")

//"รายงานสรุปการบันทึกข้อมูล"=>"report_sum.php",
//"ประมวลผล Ranking "=>"ranking.inc.php",
);

if (!(array_key_exists($_SESSION['session_staffid'], $arr_staffreport))) {
  unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานวิเคราะห์ต้นทุน']);	
}


if($_SESSION[session_sub] == "0"){ // กรณีไม่ใช่ผู้บริหารที่สามารถเรียกดูหน้ารายงานการคีย์งานของ SUB
	unset($menu_array['รายงาน']['รายงานพนักงานคีย์ข้อมูลบันทึกข้อมูล Sub ในเวลางาน']);	
}



} else if($_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "QC_WORD"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบบันทึกข้อมูล ขรก. เฉพาะข้อมูลปัจจุบัน"=>"index_report_keylast.php,_blank","ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","ระบบสุ่มตรวจสอบข้อมูล"=>"report_alert_qc1.php,_blank","เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล"=>"report_keydata_error.php,_blank","รายงานคีย์ข้อมูลผู้บริหาร"=>"report_executive_area.php,_blank")



);

	if($unlock_approve != "1"){ // กลุ่ม QC บางคนเท่านั้นที่เห็นเมนูนี้
		unset($menu_array['การจัดการข้อมูลระบบ']['เครื่องมือในการปลดรับรองข้อมูล']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("ระบบบันทึกข้อมูล ขรก. เฉพาะข้อมูลปัจจุบัน"=>"index_report_keylast.php,_blank","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php"),
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	//$menu_group = array("ระบบค้นหาข้อมูล"=>"qsearch2.php,iframe_body");
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("ระบบบันทึกข้อมูล ขรก. เฉพาะข้อมูลปัจจุบัน"=>"index_report_keylast.php,_blank","เครื่องมือจัดการข้อมูลโรงเรียน"=>"../hr3/hr_tools2/manage_school.php","ยืนยันแก้ไขข้อมูล ก.พ.7 จากคำร้องขอแก้ไขข้อมูล"=>"req_admin_verify.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","กำหนดเปิดปิดระบบรับรองข้อมูล"=>"../req_approve/admin_sapphire/main_manager.php,_blank","ระบบปลดรับรองข้อมูลนับตัวรายโรงเรียน"=>"../raise_salary/unapprove_school/index.php,_blank","เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),
"รายงานสำหรับผู้บริหาร"=>array("รายงานการเปลี่ยนเลขบัตร"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));


	if($unlock_approve != "1"){ // กลุ่ม QC บางคนเท่านั้นที่เห็นเมนูนี้
		unset($menu_array['การจัดการข้อมูลระบบ']['เครื่องมือในการปลดรับรองข้อมูล']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "site_area"){
	
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("รายงานความสำเร็จของการนับตัว"=>"https://master.cmss-otcsc.com/edubkk_master/application/raise_salary/performance/index_report_announce_master.php","รายงานตรวจสอบการทำข้อมูลให้เป็นปัจจุบันของเจ้าหน้าที่เขต"=>"../confirm_teacher/admin/index.php?xsiteid=".$_SESSION[session_site]."","รายงานตรวจสอบการจัดทำรูปภาพ"=>"../hr3/tool_competency/script_check_data/script_check_picture_all.php","รายงานการตรวจสอบผังเลื่อนขั้นเงินเดือน"=>"../confirm_teacher/confirm_user/report_casecheck_money.php?xsiteid=".$_SESSION[session_site]."&action=view&login_type=site&lock_edu=1","ปลดการยืนยันข้อมูลการนับตัวของโรงเรียน"=>"../raise_salary/unapprove_school/index_admin.php?lock=1&select_edu=".$_SESSION[session_site]."","รายงานคงค้างการรับรองผลการบันทึกข้อมูลเขตต่อเนื่อง"=>"../hr3/tool_competency/diagnosticv1/index_list_approve_day_site.php,_blank","รายงานการปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile_timeall.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php","จำนวนรายการที่ยังไม่ได้ปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile.php","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank")
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
/*"รายงานสำหรับผู้บริหาร"=>array("จำนวนรายการที่ยังไม่ได้ปรับปรุงข้อมูลตามช่วงเวลา"=>"report_check_data_profile.php","สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")*/ );
	
}else{

$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("ระบบบันทึกข้อมูล ขรก. เฉพาะข้อมูลปัจจุบัน"=>"index_report_keylast.php,_blank","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin"),
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงานสำหรับผู้บริหาร"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

unset($menu_group['ตรวจสอบการนำเข้ารูป ก.พ.7']);
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
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php")*/
	unset($menu_array['รายงานสถิติสำหรับผู้บริหาร']);
	unset($menu_array['การเข้างานลูกจ้างประจำ']);
	unset($menu_array['รายงานสถิติการตรวจข้อมูล']);

}


if($_SESSION[session_status_extra] == "QC_WORD"){
		unset($menu_array['การจัดการข้อมูลระบบ']['เครื่องมือในการปลดรับรองข้อมูล']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบมอบหมายงาน ก.พ.7']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบสุ่มตรวจสอบข้อมูล']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['รายงานจัดการผู้ใช้']);	
		unset($menu_array['การจัดการข้อมูลระบบ']['ระบบร้องขอแจ้งแก้ไขข้อมูล']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานการเปลี่ยนเลขบัตร']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานพัฒนาการบันทึกข้อมูลของพนักงานคีย์ข้อมูล']);
		unset($menu_array['รายงานสำหรับผู้บริหาร']['รายงานคีย์ข้อมูลผู้บริหาร']);
}else if($_SESSION[session_status_extra] == "NOR" and $_SESSION[session_sapphire] != "1"){
		unset($menu_group['รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท.']);	
		unset($menu_group['รายงานสำหรับผู้บริหาร']);
		
}
if($_SESSION[session_status_extra] == "site_area"){
		unset($menu_group['รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท.']);	
		unset($menu_group['รายงานสำหรับผู้บริหาร']);
		unset($menu_group['บันทึกข้อมูล update 48 เขตนำร่อง']);
		
}// end if($_SESSION[session_status_extra] == "site_area"){


## ปิดเมนูที่ไม่ต้องการออก
unset($menu_group['บันทึกข้อมูลเงินเดือนที่ขาดหาย']);
unset($menu_group['บันทึกข้อมูล update 48 เขตนำร่อง']);
unset($menu_group['ค้นหาประวัติการจัดทำข้อมูล']);
unset($menu_group['รายงานการติดตามการจัดทำข้อมูลปฐมภูมิของ จนท. สพท.']);	


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
