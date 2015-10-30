<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "audit";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::10/03/2010
#LastUpdate::10/03/2010
#DatabaseTable::edubkk_checklist
#END
#########################################################
//session_start();

			set_time_limit(80000);
			include("../../../../config/conndb_nonsession.inc.php");
			include("function.inc.php");
			include("send_mail/func_send_mail.php");
			$dbcallcenter_entry = DB_USERENTRY;
			$dbname_temp = DB_CHECKLIST;
			$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");		
			
	function get_dateThai($get_date,$xtype=""){
	global $shortmonth;
		if($get_date != "" and get_date != "0000-00-00 00:00:00"){
			$arrd = explode(" ",$get_date);
			$arrd1 = explode("-",$arrd[0]);
			if($xtype != ""){
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543);
			}else{
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543)." เวลา $arrd[1] น.";
			}
			
		}else{
			$xdate = "ไม่ระบุ";
		}
	return $xdate;
}//end function get_dateThai(){


			
			function ShowArea($get_siteid){
					global $dbnamemaster;
					$sql = "SELECT * FROM eduarea WHERE secid='$get_siteid'";
					//echo $sql;
					$result = mysql_db_query($dbnamemaster,$sql);
					$rs = mysql_fetch_assoc($result);
					return $rs[secname];
			}//end function function ShowArea(){
			
			$arr_folder = array("image_file"=>"jpg","checklist_kp7file"=>"pdf","kp7file"=>"pdf");
			function CheckProcess($get_idcard){ // ฟังก์ชั่นตรวจสอบว่ากระบวนการเปลี่ยนเลขบัตรสมบูรณ์มั้ย
					global $db_temp_data;
					$sql1 = "SELECT COUNT(*) AS num1 FROM temp_change_idcard WHERE old_idcard='$get_idcard' AND status_process='1'";
					//echo $sql1."<br>";
					$result1 = mysql_db_query($db_temp_data,$sql1);
					$rs1 = mysql_fetch_assoc($result1);
					return $rs1[num1];
			}//end function CheckProcess($get_idcard){
				
function show_user($get_staffid){
		global $dbcallcenter_entry;
		$sql = "SELECT * FROM  keystaff WHERE staffid='$get_staffid'";
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function show_user(){
			
##### ประมวลผลเปลี่ยนเลขบัตร

$cdatet = date("Y-m-d H:i:s");
$houre_ch = date("H");
$cdate = date("Y-m-d");
//$xt = "00";
//echo intval($x);
//echo $houre_ch ;


$txt_cdate = get_dateThai($cdate);
		$sql1 = "SELECT * FROM tbl_status_lock_site WHERE timeupdate LIKE '$cdate%' and flag_send_mail='0'";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$xshow_date1 = get_dateThai($cdatet);
		$txt_msg .= " รายงานการยืนยันจำนวนยอดบุคลากรของแต่ละเขตของวันที่ $xshow_date1 <br>";
	 	$i=0;
		while($rs1 = mysql_fetch_assoc($result1)){
			$i++;
			$sql_count = "SELECT COUNT(idcard) as numid FROM tbl_checklist_kp7 WHERE siteid='$rs1[siteid]' and profile_id='$rs1[profile_id]'";
			//echo $sql_count;
			$result_count = mysql_db_query($dbname_temp,$sql_count);
			$rs_c = mysql_fetch_assoc($result_count);
			$sql_up = "UPDATE tbl_status_lock_site SET flag_send_mail='1' WHERE siteid='$rs1[siteid]' AND profile_id='$rs1[profile_id]'";
			mysql_db_query($dbname_temp,$sql_up);
			
			$num_person = number_format($rs_c[numid]);
			$txt_msg .= "".ShowArea($rs1[siteid])."<br>";
			$txt_msg .= "จำนวนบุคลการที่ยืนยัน  ".$num_person." คน<br>";
			$txt_msg .= "พนักงานที่ยืนยันข้อมูล  ".show_user($_SESSION['session_staffid'])." <br>";
		
		}//end 

	
//echo $txt_msgmail;
$msg_mail = $txt_main.$txt_msg;
//echo $msg_mail;

$arr_email1 = array("suwat@sapphire.co.th"=>"สุวัฒ");
	if($i > 0){
		if(count($arr_email1) > 0){
		foreach($arr_email1 as $k_id => $v_id){
			$workname="แจ้ง : คุณ ".$v_id;
			$email_sys = "system@sapphire.co.th";
			$staff_mail  = "$k_id";
			$id = "";
			$title_msg = "ยืนยันจำนวนข้อมูลของเขตจากระบบ checklist";
		mail_daily_request($workname, $staff_mail , $email_sys ,$msg_mail,$title_msg,$id);	
		}// end foreach(){
		
		} // end if(count($arr_email) > 0){
			
				echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");location.href='../../../checklist_kp7_management/form_lock_area.php?profile_id=$profile_id';</script>";
		exit;			
			
	}// end 	if($i > 0){
		
	
		
?>

