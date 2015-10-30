<?
require_once("../../config/conndb_nonsession.inc.php");
$dbcall = DB_USERENTRY;

			// id
			$arr_tbl1 = array("general"=>"ข้อมูลทั่วไป" ,"general_pic"=>"แก้ไขรูปภาพ","graduate"=>"ประวัติการศึกษา","salary"=>"ตำแหน่งและอัตราเงินเดือน","seminar"=>"ฝึกอบรมและดูงาน","sheet"=>"ผลงานทางวิชาการ","getroyal"=>"เครื่องราชอิสริยาภรณ์ ","special"=>"ความรู้ความสามารถพิเศษ","goodman"=>"รายการความดีความชอบ","hr_absent"=>"จำนวนวันลาหยุดราชการ ขาดราชการมาสาย","hr_nosalary"=>"วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็มฯ","hr_prohibit"=>"การได้รับโทษทางวินัย","hr_specialduty"=>"การปฏิบัติราชการพิเศษ","hr_other"=>"รายการอื่น ๆ ที่จำเป็น","hr_teaching"=>"ประวัติการสอน","seminar_form"=>"การเข้าร่วมประชุมสัมนา / จัดกิจกรรม" );
			// gen_id
			$arr_tbl3 = array( "hr_addhistoryaddress"=>"ประวัติการเปลี่ยนแปลงที่อยู่","hr_addhistoryfathername"=>"ประวัติการเปลี่ยนแปลงชื่อบิดา" , "hr_addhistorymarry"=>"ประวัติการเปลี่ยนแปลงชื่อคู่สมรส" , "hr_addhistorymothername"=>"ประวัติการเปลี่ยนแปลงชื่อมารดา" , "hr_addhistoryname"=>"ประวัติการเปลี่ยนแปลงชื่อ" );			

			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");


	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


			
?>