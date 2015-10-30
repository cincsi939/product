<?
$type_problem = "1"; // 1 คือพิมพ์ผิด 2 คือ ข้อมูลไม่เป็นปัจจุบัน	
$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
$arr_gday = array("0"=>"อาทิตย์","1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์");
$group_id_sub = 8;// กลุ่มพนักงานที่เป็น sub crontact
$open_assign = 1; // กำหนดการปิดเปิดการมอบหมายงาน
$utype = "sub";
$xsapphireoffice = 2;
$config_date = "2011-05-01"; // รอบการทำงานใหม่ของงาน sub
$config_age = 26;
$maxassign = 20;
$point_base1 = 240;
$limit_day = 7;
$doc_assign1 = 3;
$point_per_doc = 69;// ค่าคะแนนต่อชุด
function DiffDayAssign($StartDate, $StopDate){
	
   return (date('U', strtotime($StopDate)) - date('U', strtotime($StartDate))) / 86400; //seconds a day
   
}// end function DiffDayAssign($StartDate, $StopDate){
	


function GetDay($group_id){
	global $dbnameuse;
	$sql = "SELECT * FROM keystaff_group_detail WHERE group_id='$group_id'";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[day_assign]] = $rs[day_assign];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetDay($group_id){
	## ปีเดือนวัน
$arrTime = getdate(date(mktime(0, 0, 0, intval(date("m")), intval(date("d")), intval(date("Y")))));
$curent_day = $arrTime["wday"];

#########  function ตรวจสอบการส่งงานช้า

function GetStatusAssign($staffid){
	global $dbnameuse,$config_date;
	$cdate = date("Y-m-d");
	#sent_date_true >  sent_date AN
	$sql	= "SELECT count(ticketid) as  num1 FROM tbl_assign_sub WHERE staffid='$staffid' AND assign_date >= '$config_date' AND  sent_date_true = '0000-00-00' ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[num1] > 0){
			$xstatus = 0;
	}else{
		$sql1 = "SELECT * FROM tbl_assign_sub WHERE staffid='$staffid' AND assign_date >= '$config_date'  ORDER BY assign_date DESC limit 1 ";	
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[sent_date_true] == $rs1[sent_date]){
			$xstatus = 1;
		}else{
				$diffdate = DiffDayAssign($rs1[sent_date], $rs1[sent_date_true]);
				if($diffdate > 0){
					
					$temp_date = $rs1[sent_date_true];
					$temp_i= 0;
					for($i=1;$i <= $diffdate;$i++){
						$xbasedate = strtotime("$temp_date");
						$xdate = strtotime("+$i day",$xbasedate);
						$temp_date = date("Y-m-d",$xdate);// วันถัดไป
						$arrd1 = explode("-",$temp_date);
						$arrTime = getdate(date(mktime(0, 0, 0, intval($arrd1[1]), intval($arrd1[2]), intval($arrd1[0]))));
						$curent_day = $arrTime["wday"];
						if($curent_day=="0"){
								$temp_i++;
						}
					}// for($i=0;$i < $diffdate;$i++){
					
				$numpday = $diffdate+$temp_i;
				$numdate = "+$numpday day";
				$xbasedate = strtotime("$rs1[sent_date_true]");
				$xdate = strtotime("$numdate",$xbasedate);
				$xsdate = date("Y-m-d",$xdate);// วันถัดไป
				
				$numdate1 = $numpday+1;
				$txtnumdate = "+$numdate1 day";
				$xbasedate1 = strtotime("$xsdate");
				$xdate1 = strtotime("$txtnumdate",$xbasedate1);
				$temp_date = date("Y-m-d",$xdate1);// วันถัดไป
				$arr2 = explode("-",$temp_date);
				
						$arrTime1 = getdate(date(mktime(0, 0, 0, intval($arr2[1]), intval($arr2[2]), intval($arr2[0]))));
						$curent_day1 = $arrTime1["wday"];
						if($curent_day1 == "0"){
							$numdate1 = $numpday+2;
							$txtnumdate = "+$numdate1 day";
							$xbasedate1 = strtotime("$xsdate");
							$xdate1 = strtotime("$txtnumdate",$xbasedate1);
							$temp_date = date("Y-m-d",$xdate1);// วันถัดไป	
						}
						

					if($xsdate > $cdate){
							$xstatus = 1;
					}else{
							$xstatus = 0;	
					}
				}else{
						$xstatus = 1;	
				}// end 	if($diffdate > 0){
				
		}// end if($rs1[sent_date_true] == $rs1[sent_date]){
		
	}//end if($rs[num1] > 0){
	$arr[0] = $xstatus;
	$arr[1] = $temp_date;
	return $arr;
}//end function GetDateSentJob(){
	
###############  functionคำนวนจำนวนชุดที่มอบหมายงาน sub
function GetNumAssign($staffid){
	global $dbnameuse,$point_base1,$limit_day,$doc_assign1,$point_per_doc;
	$sql = "SELECT
stat_user_keyin.datekeyin,
stat_user_keyin.staffid,
stat_user_keyin.numkpoint-$point_base1 AS diffpoint
FROM `stat_user_keyin`
WHERE staffid='$staffid'
ORDER BY
datekeyin DESC LIMIT $limit_day";
 	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."LINE :: ".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sumpoint += $rs[diffpoint];
	}//end while($rs = mysql_fetch_assoc($result)){
		
	if($sumpoint > 0){
		$avg_point = $sumpoint/$limit_day; // ค่าเฉลี่ยจำนวนชุด
		if($avg_point > 0){
			$doc_num = 	number_format($avg_point/$point_per_doc);
			if($doc_num < 1){
					$doc_num = $doc_assign1;
			}else{
					$doc_num = $doc_num;
			}
		}else{
		$doc_num = $doc_assign1;	
		}
	}else{
		$doc_num = $doc_assign1;
	}// end if($sumpoint > 0){
	
	return $doc_num;
	
}// end function GetNumAssign($staffid){




	
?>