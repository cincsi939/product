<?
//echo "<h1><font color='red'><center>ประกาศจากศูนย์อำนวยการแก้ไขสถานการณ์ฉุกเฉิน (ศอฉ.) </center></h1>
//<br />
//<h3>
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เนื่องจากวันจันทร์ที่ 28 มิถุนายน 2553 มีการตรวจรับงานที่ ก.ค.ศ.ดังนั้นจึงปิดระบบไว้ชั่วคราวเพื่อไม่ให้กระทบต่อความเร็วในการประมวลผลข้อมูลดังนั้นจึงให้ทีมตรวจสอบข้อมูลทำการตรวจสอบข้อมูลจากกระดาษไปก่อนจนกว่าจะทำการตรวจรับงานเสร็จจึงจะเปิดให้บันทึกข้อมูลผลการตรวจสอบข้อมูล (QC) ในระบบได้ ทางทีมพัฒนาระบบจะแจ้งให้ทราบอีกครั้งในเวลาประมาณ 15.00 น. หากมีกรณีเร่งด่วนติดต่อที่ คุณเจษฎา ฤดีกุลรุ่งโรจน์  <br />
//<br />
//
//</font></h3>";die;

require_once("../../config/conndb_nonsession.inc.php");


$yy = "2547";
$db_name = DB_USERENTRY;
$dbnameuse = $db_name;
$db_system = "edubkk_system";
$dbname_temp = DB_CHECKLIST;
$ratio_t1 = 1; // ค่าคะแนนหักโครงสร้าง
$ratio_t2 = 1; // ค่าคะแนนหักพิมพ์ผิด
##  config  การตรวจสอบการบันทึกเงินเดือนถึงปีสุดท้าย
$salary_date = (date("Y")+543);
//$salary_date = "2552";
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$arrstaff = array("พนักงานชั่วคราว","พนักงานประจำ","Subcontract");


function GetRatio($staffid){
		global $dbnameuse;
		$sql = "SELECT
keystaff_group.rpoint,
keystaff.staffid
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
where staffid='$staffid'";
$result = mysql_db_query($dbnameuse,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[rpoint];
}

function ShowKp7FileBlue($idcard){
		global $dbname_temp;
		$sql = "SELECT kp7file  FROM `tbl_checklist_log_uploadfile` WHERE idcard='$idcard' order by date_upload desc limit 1";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if(is_file($rs[kp7file])){
			return 1;
		}else{
			return 0;	
		}/// end if(is_file($rs[kp7file])){
}//end function ShowKp7FileBlue(){


function CheckMarry($get_site,$get_id){
	$db_site = STR_PREFIX_DB."$get_site";
	$sql = "SELECT COUNT(gen_id) AS num1 FROM hr_addhistorymarry WHERE gen_id='$get_id'";
	$result = @mysql_db_query($db_site,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckMarry($get_site,$get_id){

function DateThai($get_date,$get_type=""){
	global $shortmonth;
	if($get_type != ""){
		if($get_date != "" and get_date != "0000-00-00 00:00:00"){
		$arrd = explode(" ",$get_date);
		$arrd1 = explode("-",$arrd[0]);
			$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543)." เวลา ".$arrd[1] ."น.";
		}else{
			$xdate = "-";	
		}
		
	}else{
		if($get_date != "" and get_date != "0000-00-00"){
			$arrd1 = explode("-",$get_date);
			$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]);
		}else{
			$xdate = "-";
		}
	}//end if($get_type != ""){
	return $xdate;
}//end function get_dateThai(){
	
function ShowDateThai($get_date){
		global $monthname;
		$arr = explode(" ",$get_date);
		if($arr > 1){
			$get_date = $arr[0];
		}
		if($get_date != "0000-00-00"){
			$arr1 = explode("-",$get_date);	
			return intval($arr1[2])." ".$monthname[intval($arr1[1])]." ".($arr1[0]+543);
		}else{
			return "";	
		}
}//end function ShowDateThai($get_date){
	
 function Datediff($datefrom,$dateto){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        
        $differnce = $startDate - $lastDate;

        $differnce = ($differnce / (60*60*24)); //กรณืที่ต้องการให้ return ค่าเป็นวันนะครับ

        return $differnce;
  }//end  function Datediff($datefrom,$dateto){


#### function ตรวจสอบการเรียงลำดับการเปลี่ยนชื่อ
function CheckOrderHisName($get_siteid,$get_id){
	$db = STR_PREFIX_DB."$get_siteid";
	$sql = "SELECT * FROM hr_addhistoryname WHERE gen_id='$get_id' ORDER BY runno ASC";
	$result = mysql_db_query($db,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr_d[] = $rs[daterec];	
	}
	
	if(count($arr_d) > 0){
		$i=0;
			foreach($arr_d as $k => $v){
					$kc = $k-1;
					$date1 = $arr_d[$k];
					$date2 = $arr_d[$kc];
					
					if(Datediff($date1,$date2) > 0){
						$i++;						
					}
			}
	}
	if($i > 0){
		return false;
	}else{
		return true;	
	}
}//end function CheckOrderHisName(){



function checkID($StrID){
	if(is_numeric($StrID)){
		if(strlen($StrID)==13){
		$id=str_split($StrID); 
		$sum=0;    
		for($i=0; $i < 12; $i++){
			 $sum += floatval($id[$i])*(13-$i); 
		}   
		if((11-$sum%11)%10!=floatval($id[12])){
			 return false;
		}else{
			 return true; 
		}
	}else{
		return false;
	}   
	}else{
		return false;		
	}
} //end function checkID($StrID){
	
	
## ตรวจสอบกรณีคำนำหน้าชื่อเป็นนามแล้วเลือกสถานะภาพเป็นโสด
function CheckStatusMarry($get_prename_id,$get_marry_id){
		if($get_prename_id == "005" and $get_marry_id == "2"){ // ตรวจสอบกรณีคำนำหน้าชื่อเป็นนางและสถานเป็นเป็นโสดแสดงว่าไม่ถูกต้อง
			return false;
		}else{
			return true;	
		}
}
## end ตรวจสอบกรณีคำนำหน้าชื่อเป็นนามแล้วเลือกสถานะภาพเป็นโสด
	
## function ตรวจสอบ การบันทึกเงินเดือนเป็นปีปัจจุบันรึยัง
//function CheckLastSalary($get_siteid,$get_id){
//	global $salary_date;
//	$dbsite = STR_PREFIX_DB.$get_siteid;
//	$sql = "SELECT COUNT(id) as NUMSALARY FROM salary WHERE id='$get_id' AND date LIKE '$salary_date%'";
//	//echo $sql." :: $dbsite";
//	$result = mysql_db_query($dbsite,$sql);
//	$rs = mysql_fetch_assoc($result);
//	
//	$sql1 = "SELECT MAX(date) as maxdate FROM salary WHERE id='$get_id' ";
//	$result1 = mysql_db_query($dbsite,$sql1);
//	$rs1 = mysql_fetch_assoc($result1);
//	$arr1['NUMSALARY'] = $rs[NUMSALARY];
//	$arr1['maxdate'] = $rs1[maxdate];
//	return 	$arr1;
//}
//	



## function ตรวจสอบ การบันทึกเงินเดือนเป็นปีปัจจุบันรึยัง
function CheckLastSalary($get_siteid,$get_id){
	global $salary_date,$dbname_temp;
	$dbsite = STR_PREFIX_DB.$get_siteid;
	$sql_check = "SELECT
tbl_checklist_profile.profile_date
FROM
tbl_checklist_kp7
Inner Join tbl_checklist_profile ON tbl_checklist_kp7.profile_id = tbl_checklist_profile.profile_id
WHERE idcard='$get_id' AND siteid='$get_siteid' and tbl_checklist_profile.status_active='1'
ORDER BY tbl_checklist_kp7.profile_id DESC
LIMIT 0,1
";
$result_check = mysql_db_query($dbname_temp,$sql_check);
$rsc = mysql_fetch_assoc($result_check);
$exarr = explode("-",$rsc[profile_date]);

if($rsc[profile_date] != "" and $rsc[profile_date] != "0000-00-00"){
$dates = ($exarr[0]+543)."-".$exarr[1]."-".$exarr[2];
}else{
$dates =  	$salary_date."-04-01";
}

	
	$sql = "SELECT COUNT(id) as NUMSALARY FROM salary WHERE id='$get_id' AND date >= '$dates'";
	//echo $sql." :: $dbsite";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	
	$sql1 = "SELECT MAX(date) as maxdate FROM salary WHERE id='$get_id' ";
	$result1 = mysql_db_query($dbsite,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$arr1['NUMSALARY'] = $rs[NUMSALARY];
	$arr1['maxdate'] = $rs1[maxdate];
	//echo "<pre>";
	//print_r($arr1);
	return 	$arr1;
	
}
	

### function ตรวจสอบ คำนำหน้าชื่อกับเพศกณีเป็น 1:1
function CheckPrenameSex($prename_id,$gender_id){
	global $dbnamemaster;
	$sql_prename  = "SELECT * FROM prename_th WHERE PN_CODE='$prename_id'";
	$result_prename = mysql_db_query($dbnamemaster,$sql_prename);
	$rs_p = mysql_fetch_assoc($result_prename);
	if($rs_p[gender] != $gender_id){ // กรณีคำนำหน้าชื่อไม่ตรงสัมพันธ์กับเพศ
		return 1;
	}else{
		return 0;	
	}
	
}//end function CheckPrenameSex(){
### end  function ตรวจสอบ คำนำหน้าชื่อกับเพศกณีเป็น 1:1
### function ตรวจสอบสถานะการแสดงผลข้องชื่อใน ก.พ. 7 มี 2 แถว
function CheckActive2Record($get_id){
	
	global $dbsite;
	$sql_count = "SELECT COUNT(gen_id) AS num1 FROM hr_addhistoryname WHERE kp7_active='1' AND gen_id='$gen_id'";
	$result_count = mysql_db_query($dbsite,$sql_count);
	$rs_count = mysql_fetch_assoc($result_count);
	return $rs_count[num1];
}// end function CheckActive2Record($get_id){


###  ตรวจสอบวันเดือนปีเกิดกับอายุในการเข้ารับราชการ
function CheckAge1($get_id){
	global $dbsite;	
	$year1 = (date("Y")+543)."-09-30";
	$sql_a = "SELECT  ROUND((TIMESTAMPDIFF(MONTH,birthday,'$year1')/12)) as age FROM general WHERE id='$get_id' ";
	//echo $dbsite." :: ".$sql_a;
	$result_a = mysql_db_query($dbsite,$sql_a);
	$rs_a = mysql_fetch_assoc($result_a);
	if($rs_a[age] == ""){
			$sqlb = "SELECT birthday FROM general WHERE id='$get_id'";
			$resultb = mysql_db_query($dbsite,$sqlb);
			$rsb = mysql_fetch_assoc($resultb);
			$yy1 = date("Y")+543;
			$yy2 = substr($rsb[birthday],0,4);
			$age = $yy1-$yy2;
	}else{
		$age = $rs_a[age];	
	}
	//echo $rs_a[age];
	if($age >= 18 and $age <= 62){
		return 1;
	}else{
		return 0;	
	}
}
## ตรวจสอบ วันเดือนปีเกิดกับวันเริ่มปฏิบัตราชการควรห่างกันมากกว่า 18 ปีขึ้นไป
function CheckBirthdayBegindate($get_id){
	global $dbsite;	
	$year1 = (date("Y")+543)."-09-30";
	$sql_a1 = "SELECT  ROUND((TIMESTAMPDIFF(MONTH,birthday,'$year1')/12)) as age,ROUND((TIMESTAMPDIFF(MONTH,begindate,'$year1')/12)) as age_gov FROM general WHERE id='$get_id' ";
	$result_a1 = mysql_db_query($dbsite,$sql_a1);
	$rs_a1 = mysql_fetch_assoc($result_a1);
	if($rs_a1[age] == "" or $rs_a1[age_gov] == ""){
		$sqlb1 = " SELECT birthday,begindate FROM general WHERE id='$get_id'";
		$resultb1 = mysql_db_query($dbsite,$sqlb1);
		$rsb1 = mysql_fetch_assoc($resultb1);
		$cyy = date("Y")+543;
		$yy1 = substr($rsb1[birthday],0,4);
		$yy2 = substr($rsb1[begindate],0,4);
		$age = $cyy-$yy1;
		$age_gov = $ccy-$yy2;
			
	}else{
			$age = $rs_a1[age];
			$age_gov = $rs_a1[age_gov];
	}
	$dif_age = $age-$age_gov;
	if($dif_age >= 18){
			return 1;
	}else{
			return 0;	
	}
	
}//end function CheckBirthdayBegindate(){
	
###  ฟังก์ชั่นตรวจสอบการบันทึกเงินเดือนในตรงตามแท่งเงินเดือน
function CheckKeySalary($get_id){
		global $dbsite,$dbnamemaster,$yy;
		$sql_salary = "SELECT * FROM salary WHERE id='$get_id' AND year(date) > $yy ORDER BY date ASC";
		$result_salary = mysql_db_query($dbsite,$sql_salary);
		$IntA=0;
		//$salary_msg = "";
		while($rs_s = mysql_fetch_assoc($result_salary)){
		$sql_check = "SELECT
tbl_salary_level.money
FROM
tbl_salary_level
WHERE
 (money ='$rs_s[salary]' or money0_5='$rs_s[salary]' or money1='$rs_s[salary]' or money1_5='$rs_s[salary]')";
		$result_check = mysql_db_query($dbnamemaster,$sql_check);
		$rs_c = mysql_fetch_assoc($result_check);
		//echo "$rs_s[salary]  :: $rs_s[date] :: ".$rs_c[money]."<br>";
			if($rs_c[money] == ""){
					$IntA += 1;
					$salary_msg .= " ข้อมูลเงินเดือนบรรทัดที่ $rs_s[runno]  วันที่  $rs_s[date]  เงินเดือน $rs_s[salary]<br>";
			}
		}//end while($rs_s = mysql_fetch_assoc($result_salary)){
			$arr_check['NUM'] = $IntA;
			$arr_check['salary_error_msg'] = $salary_msg;
	return $arr_check;
}//end 	function CheckKeySalary(){
## end ฟังก์ชั่นตรวจสอบการบันทึกเงินเดือนในตรงตามแท่งเงินเดือน

## function ข้อมูล salary ที่ไม่ควรเป็นค่าว่าง
function CheckSalaryNull($get_id){
	global $dbsite;
	###  จำนวนแถวเงินเดือนไม่มี
	$sql1 = "SELECT COUNT(id) AS num1 FROM salary WHERE id='$get_id'";
	$result1 = mysql_db_query($dbsite,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
		if($rs1[num1] < 1){
			$arr['NumLine'] = "Error";
		}else{
			$arr['NumLine'] = "";	
		}
	## เลขที่ตำแหน่งเป็นค่าว่าง
	$sql2 = "SELECT COUNT(id) as num2,year(date) as yyyy FROM salary WHERE id='$get_id' AND (noposition='' OR noposition IS NULL) GROUP BY id";
	$result2 = mysql_db_query($dbsite,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
		if($rs2[num2] > 0){
				$arr['NumNoPosition'] = "$rs2[yyyy]";
		}else{
				$arr['NumNoPosition'] = "";
		}
	## วันที่เงินเดือนต้องไม่เป็นค่าว่าง
	$sql3 = "SELECT COUNT(id) as num3 FROM salary WHERE id='$get_id' AND substring(date,1,4) < 2000 ";
	$result3 = mysql_db_query($dbsite,$sql3);
	$rs3 = mysql_fetch_assoc($result3);
		if($rs3[num3] > 0){
				$arr['NumDate'] = "Error";
		}else{
				$arr['NumDate']	 = "";
		}
	return $arr;
	
	### บันทัดเป็นค่าว่าง
	
}//end function CheckSalaryNull($get_id){
	
function  CheckData($idcard,$dbsite,$showmsg=false){
	global $dbsite,$action;
// -----------------  ข้อมูลทั่วไป ----------------------------


// ====  ชื่อ นามสกุล ==========================
	$sql = " SELECT  *  FROM  general WHERE  idcard = '$idcard' ";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);


	if($rs[name_th] != "" AND $rs[surname_th] != ""){
		$sql1 = " SELECT  *  FROM  hr_addhistoryname WHERE  gen_id = '$idcard' ";
		$result1 = mysql_db_query($dbsite,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
			if($rs[name_th] != "" AND $rs[surname_th] != "" AND $rs1[kp7_active] == 1 ){
				$G[0] = true;
				$msg[0] = "";
				break;
			}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล ไม่ถูกต้อง ไม่พบข้อมูลใน ตารางประวัติการเปลี่ยนชื่อ ผลกระทบคือ จะทำให้ชื่อไม่แสดงผลใน กพ.7";
			}
		}
	}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล  ไม่พบข้อมูลใน ตารางข้อมูลทั่วไป ผลกระทบคือ จะทำให้ชื่อหรือนามสกุลไม่แสดงผลใน กพ.7";
	}


### คำนำหน้าชื่อไม่สัมพันธ์กับเพศ
	if(CheckPrenameSex($rs[prename_id],$rs[gender_id]) > 0){
		$G[9] = false;
		$msg[9] = "[Error Code : G010] ข้อมูลคำนำหน้าชื่อกับเพศไม่สัมพันธ์กัน";
	}else{
		$G[9] = true;
		$msg[9] = "";
	}
## end คำนำหน้าชื่อไม่สัมพันธ์กับเพศ
//==============================
###  สถานะการแสดงผลของชื่อ ในก.พ. 7 มี 2 แถว
	if(CheckActive2Record($idcard) > 1){
		$G[10] = false;
		$msg[10] = "[Error Code : G011] สถานะการแสดงผลใน ก.พ. 7 ข้องชื่อ - นามสกุล มีมากกว่า 1 แถว";
	}else{
		$G[10] = true;
		$msg[10] = "";	
	}


###  วันเืดือนปีเกิดไม่สอดคล้องกับอายุกับรับราชการ
	if(CheckAge1($idcard) == 0){
		$G[11] = false;
		$msg[11] = "[Error Code : G012] วันเดือนปีเกิดที่ระบุไม่สอดคล้องกับอายุความน่าจะเป็็นที่จะรับราชการ";
	}else{
		$G[11] = true;
		$msg[11] = "";
	}

### วันเกิดกับวันเริมปฏิบัตราชการควรห่างกัน อย่างน้อย 18 ปี
	if(CheckBirthdayBegindate($idcard) == 0){
		$G[12] = false;
		$msg[12] = "[Error Code : G013] วันเดือนปีเกิดกับวันเริ่มปฏิบัติราชการไม่ถูกต้องเนื่องจาก อายุตอนเริ่มรับราชการยังไม่ถึง 18 ปี";
	}else{
		$G[12] = true;
		$msg[12] = "";
	}
	
$arrsalary = CheckKeySalary($idcard);
	if($arrsalary['NUM'] > 0){
		$G[13] = false;
		$msg[13] = "[Error Code : G014] ข้อมูลเิงินเดือนไม่ตรงตามมาตรฐานเงินเดือน<br>".$arrsalary['salary_error_msg'];

	}else{
		$G[13] = true;
		$msg[13] = "";
	}//end if($arrsalary['number'] > 0){
	
	$xsql4 = "SELECT runno FROM salary WHERE id='$rs[idcard]' AND substring(date,1,4) < 2000 ";
	$xresult4 = mysql_db_query($dbsite,$xsql4);
	while($xrs4 = mysql_fetch_assoc($xresult4)){
		if($date_error > "") $date_error .= ",";
		$date_error .= "$xrs4[runno]";
	}
## ตรวจสอบข้อมูลทั่วไปของเงินเดือน
$arr_salary1 = CheckSalaryNull($idcard);
	if($arr_salary1['NumLine'] != ""){
		$G[14] = false;
		$msg[14] = "[Error Code : G015] ข้อมูลเิงินเดือนเป็นค่าว่าง";
	}else{
		$G[14] = true;	
		$msg[14] = "";
	}
	
	if($arr_salary1['NumNoPosition'] != ""){
		$G[15] = false;
		$msg[15] = "[Error Code : G016] ข้อมูลเลขที่ตำแหน่งการบันทึกเงินเดือนเป็นค่าว่าง  ปี".$arr_salary1['NumNoPosition'];	
	}else{
		$G[15] = true;
		$msg[15] = "";
	}
	
	if($arr_salary1['NumDate'] != ""){
		$G[16] = false;
		$msg[16] = "[Error Code : G017] ข้อมูลวันที่การบันทึกเดือนเดือนเป็นค่าว่างหรือกรอกปีไม่ถูกต้อง บรรทัดที่ ".$date_error;	
	}else{
		$G[16] = true;
		$msg[16] = "";
	}

	//
$dy=explode("-",$rs[begindate]);

// ====  รหัสบัตรบัตรประชาชน  ==========================
	if(!checkID($idcard)){
		$G[1] = false;
		$msg[1] = "[Error Code : G002] ข้อมูลรหัสบัตรประชาชนไม่ถูกต้อง ไม่ตรงรูปแบบของกรมการปกครอง  ";
	}else{
		$G[1] = true;
		$msg[1] = "";
	}
	
// =========== วัน เดือน ปีเกิด ====================
	if($rs[birthday] == ""){
		$G[2] = false;
		$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด เป็นช่องว่าง   ";
	}else{
		$bday1 = explode("-",$rs[birthday]) ;
		$bday1[0] = $bday1[0] ;
		$sql2 = " SELECT '".$bday1[0]."-".$bday1[1]."-".$bday1[2]."' <  '$rs[begindate]' ";
		//echo "$sql2";
		$result2 = @mysql_db_query($dbsite,$sql2);
		$rs2 = @mysql_fetch_array($result2);
		if($rs2[0]==0){
			$G[2] = false;
			$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด ค่าที่ไม่สอดคล้องกับวันเริ่มปฏิบัติราชการ   ";
		}else{
			$G[2] = true;
			$msg[2] = "";
		}
	}

//============================================
// คำนำหน้า
	$flag1 = true ;

	if($rs[prename_th]=="" OR $rs[prename_th]== NULL){
		$flag1 = false ;
		$msg[3] = "<br> - ไม่ระบุคำนำหน้า";
	}
	// ชื่อ
	if($rs[name_th]=="" OR $rs[name_th]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุชื่อ";
	}
	// นามสกุล
	if($rs[surname_th]=="" OR $rs[surname_th]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุนามสกุล";
	}
	// เพศ
	if($rs[sex]=="" OR $rs[sex]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุเพศ";
	}
	// ตำแหน่งเริ่ม
	if($rs[position]=="" OR $rs[position]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งเริ่มรับราชการ";
	}
	// ระดับเริ่มรับราชการ
	if($rs[radub_past]=="" OR $rs[radub_past]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับเริ่มรับราชการ";
	}
	// ตำแหน่งปัจจุับัน
	if($rs[position_now]=="" OR $rs[position_now]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งปัจจุับัน";
	}
	// ระดับปัจจุับัน
	if($rs[radub]=="" OR $rs[radub]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับปัจจุับัน";
	}

	if(!$flag1){
			$G[3] = false;
			$msg[3] = "[Error Code : G004] ".$msg[3];
	}

//=========รูป============================

$sql3 = " SELECT *  FROM general_pic WHERE id = '$idcard'  ORDER BY   kp7_active  ASC  " ;
if($result3 = mysql_db_query($dbsite,$sql3)){
	while($rs3 = mysql_fetch_assoc($result3)){
		if($rs[kp7_active] == "0"){
			$G[4] = false;
			$msg[4] = "[Error Code : G005]  ไม่ได้ตั้งค่าแสดงผลในกพ.7 ";
		}else{
			$G[4] = true;
			$msg[4] = "";
		}
	}
}else{
	$G[4] = false;
	$msg[4] = "[Error Code : G005]  ไม่มีข้อมูลรูปในระบบ ";
}

// ==============ประวัติการศึกษา========================
$sql4 = " SELECT id   FROM graduate  WHERE id = '$idcard' " ;
$result4 = mysql_db_query($dbsite,$sql4);

if(!$result4){
	$G[5] = false;
	$msg[5] = "[Error Code : G006]  ไม่มีข้อมูลประวัติการศึกษา ";
}

//===========การลาหยุด=====================
$msgshow11 = "";
$sqlabsent="SELECT Count(hr_absent.yy)as ABDAY FROM hr_absent WHERE hr_absent.id =  '$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' ";
$resultabsent =  mysql_db_query($dbsite,$sqlabsent) ;
$rsab=mysql_fetch_assoc($resultabsent);
$sumab=$rsab[ABDAY];
if($sumwork !=$sumab)
{
	for($i=$dy[0];$i<=2549;$i++)//หาปีที่กรอกข้อมูลไม่ครบ
	{
	$arr1[]=$i;
	}
	
	$sqlfindyy="SELECT yy from  hr_absent where id='$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' order by yy ASC";
	$queryfindyy = mysql_db_query($dbsite,$sqlfindyy) ;
	while($XX=mysql_fetch_assoc($queryfindyy))
	{
		$arr2[]=$XX[yy];
	}
for($i = 0; $i < sizeof($arr1); $i++){

for($j = 0; $j < sizeof($arr2); $j++)
	{ 
			if($arr1[$i] != $arr2[$j]){ 
			$isSame = false;
			}else{
			$isSame = true;
			break;
			} 
	}//for($j = 0; $j < sizeof($arr2); $j++)
	
	if($isSame == false){
		$msgshow11 .= "<br> -  ปี พ.ศ. $arr1[$i]  ";
		}
	}//for($i = 0; $i < sizeof($arr1); $i++){
}
if($msgshow11){
	$G[6] = false;
	$msg[6] = "[Error Code : G007]  ข้อมูลวันลาหยุดไม่สมบูรณ์ ขาด ".$msgshow11;
}
//======================================
$msgshow12 = "";

$sqlsa="SELECT count(runid) AS suma FROM `salary` WHERE `id` LIKE '%$idcard%' AND `date` BETWEEN '2544' AND '2550' ";
$resultsa = mysql_db_query($dbsite,$sqlsa) ;
$rssa=mysql_fetch_assoc($resultsa);
if($rssa[suma]<14 and $dy[0] < 2544){
	$msgshow12 .= "<br> - ในช่วงปี พ.ศ. 2544 - พ.ศ. 2549  กรอกข้อมูลเงินเดือนไม่ครบ";	
}

if($msgshow12 != ""){
	$G[7] = false;
	$msg[7] = "[Error Code : G008]  ข้อมูลเงินเดือนไม่สมบูรณ์ ขาด ".$msgshow12;
}else{
	$G[7] = true;
	$msg[7] = "";	
}

$xcheckfile = ShowKp7FileBlue($idcard);
///----------------  ไฟล์ต้นฉบับ -----------------------------------
$path_pdf = "../../../../../edubkk_kp7file/";
$imgpdf = "<img src='../../../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='20' height='21' border='0'>";	

//echo $idcard." :: ".$path_pdf." :::".$imgpdf ;
$arrkp7 = GetPdfOrginal($idcard,$path_pdf,$imgpdf,"","pdf");
//echo "<pre>";
//print_r($arrkp7);
$ch_file = $_SERVER['DOCUMENT_ROOT']."/edubkk_kp7file/$rs[siteid]/$idcard.pdf" ;
if(!is_file($ch_file) and $arrkp7['numfile'] == "0"){
	if($xcheckfile == 0){ // กรณียังเมีเอกสารสีฟ้าอยู่
	$G[8] = false;
	$msg[8] = "[Error Code : G009]  ไม่มีเอกสาร ก.พ.7 ต้นฉบับ ";
	}//end if($xcheckfile == 0){
}//end if(!is_file($ch_file)){



###  ตรวจสอบคำนำหน้าชื่อกับสถานะภาพสมรส
if(CheckStatusMarry($rs[prename_id],$rs[marital_status_id]) == false){
	$G[17]	 = false;
	$msg[17] = "[Error Code : G018]  คำนำหน้าชื่้อเป็นนางไม่ควรเลือกสถานะภาพเป็นโสด";
}else{
	$G[17] = true;	
	$msg[17] = "";
}


#### การเรียงลำดับประวัติการเปลี่ยนชื่อ
//if(CheckOrderHisName($rs[siteid],$rs[idcard]) == false){
//	$G[18] = false;
//	$msg[18] = "[Error Code : G019] การเรียงลำดับชื่อไม่สัมพันธ์กับวันที่เปลี่ยนชื่อ";
//}else{
//	$G[18] = true;
//	$msg[18] = "";
//}

###  วันเริ่มปฏิบัตราชการเป็นค่าว่าง
if($rs[begindate] == ""){
	$G[19] = false;
	$msg[19] = "[Error Code : G020] วันเริ่มปฏิบัติราชการเป็นค่าว่าง";
}else{
	$G[19] = true;
	$msg[19] = "";
}

if(CheckMarry($rs[siteid],$rs[idcard]) > 0 and (($rs[marry] == "" or $rs[marry] == "โสด" or $rs[marry] == "ไม่ระบุ") or ($rs[marital_status_id] == 0 or $rs[marital_status_id] == 2 or $rs[marital_status_id] == 5)) ){
	$G[20] = false;
	$msg[20] = "Error Code : G021] มีข้อมูลคู่สมรส !สถานะการสมรสไม่ควรเป็นค่าว่างหรือโสดหรือไม่ระบุ";
}else{
	$G[20] = true;
	$msg[20] = "";	
}


$check_radub = intval($rs[radub]);// ตรวจสอบกรณีระดับยังเป็นตัวเลขอยู่เป็นตัวเลข
if($check_radub > 0){
	$G[21] = false;
	$msg[21] = "[Error Code : G022] ข้อมูลระดับปัจจุบันไม่ถูกต้องเนื่องจากการบันทึกเงินเดือนปัจจุบันไม่ถูกต้อง";
}else{
	$G[21] = true;
	$msg[21] = "";
}


//if($action == "getdata" && $idcard != ""){
//
//$sqlx = " INSERT INTO  tempcheckdata(idcard) VALUES ('$idcard') " ;
//mysql_db_query($dbsite,$sqlx);
//
//}


//$flagerror = false;
//	foreach($G AS $key => $val){
//		if(!$val){
//			if($showmsg){
//				echo "$msg[$key] <br>";
//			}
//			if($action == "getdata" && $idcard != ""){
//				$sqlxa = " UPDATE   tempcheckdata  SET  G00".$key." = '1'  WHERE  idcard = '$idcard' " ;
//				//echo "$sqlxa <br>";
//				mysql_db_query($dbsite,$sqlxa);
//			}
//			$flagerror = true ;
//		}
//	}
//	if(!$flagerror){
//		if($showmsg){
//		echo "<h1>ตรวจสอบข้อมูลแล้ว ไม่พบส่วนที่มีความผิดพลาด</h1>";
//		}
//	}


return $msg;

}// function

function ShowArea($get_siteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];	
}// end function ShowArea($get_siteid){

function ShowSchool($get_school){
	global $dbnamemaster;
	$sql = "SELECT office FROM allschool WHERE id='$get_school'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
}

function  CheckDataV1($idcard,$dbsite,$showmsg=false){
	global $dbsite,$action;
// -----------------  ข้อมูลทั่วไป ----------------------------


// ====  ชื่อ นามสกุล ==========================
	$sql = " SELECT  *  FROM  general WHERE  idcard = '$idcard' ";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);


	if($rs[name_th] != "" AND $rs[surname_th] != ""){
		$sql1 = " SELECT  *  FROM  hr_addhistoryname WHERE  gen_id = '$idcard' ";
		$result1 = mysql_db_query($dbsite,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
			if($rs[name_th] != "" AND $rs[surname_th] != "" AND $rs1[kp7_active] == 1 ){
				$G[0] = true;
				$msg[0] = "";
				break;
			}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล ไม่ถูกต้อง ไม่พบข้อมูลใน ตารางประวัติการเปลี่ยนชื่อ ผลกระทบคือ จะทำให้ชื่อไม่แสดงผลใน กพ.7";
			}
		}
	}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล  ไม่พบข้อมูลใน ตารางข้อมูลทั่วไป ผลกระทบคือ จะทำให้ชื่อหรือนามสกุลไม่แสดงผลใน กพ.7";
	}


### คำนำหน้าชื่อไม่สัมพันธ์กับเพศ
	if(CheckPrenameSex($rs[prename_id],$rs[gender_id]) > 0){
		$G[9] = false;
		$msg[9] = "[Error Code : G010] ข้อมูลคำนำหน้าชื่อกับเพศไม่สัมพันธ์กัน";
	}else{
		$G[9] = true;
		$msg[9] = "";
	}
## end คำนำหน้าชื่อไม่สัมพันธ์กับเพศ
//==============================
###  สถานะการแสดงผลของชื่อ ในก.พ. 7 มี 2 แถว
	if(CheckActive2Record($idcard) > 1){
		$G[10] = false;
		$msg[10] = "[Error Code : G011] สถานะการแสดงผลใน ก.พ. 7 ข้องชื่อ - นามสกุล มีมากกว่า 1 แถว";
	}else{
		$G[10] = true;
		$msg[10] = "";	
	}


###  วันเืดือนปีเกิดไม่สอดคล้องกับอายุกับรับราชการ
	if(CheckAge1($idcard) == 0){
		$G[11] = false;
		$msg[11] = "[Error Code : G012] วันเดือนปีเกิดที่ระบุไม่สอดคล้องกับอายุความน่าจะเป็็นที่จะรับราชการ";
	}else{
		$G[11] = true;
		$msg[11] = "";
	}

### วันเกิดกับวันเริมปฏิบัตราชการควรห่างกัน อย่างน้อย 18 ปี
	if(CheckBirthdayBegindate($idcard) == 0){
		$G[12] = false;
		$msg[12] = "[Error Code : G013] วันเดือนปีเกิดกับวันเริ่มปฏิบัติราชการไม่ถูกต้องเนื่องจาก อายุตอนเริ่มรับราชการยังไม่ถึง 18 ปี";
	}else{
		$G[12] = true;
		$msg[12] = "";
	}
	
##  ตรวจสอบ เงินเืดือนที่ไม่ตรงตามแทงเงินเดือน
$arrsalary = CheckKeySalary($idcard);
//echo "<pre>";
//print_r($arrsalary);

	if($arrsalary['NUM'] > 0){
		$G[13] = false;
		$msg[13] = $arrsalary['msg'];

	}else{
		$G[13] = true;
		$msg[13] = "";
	}//end if($arrsalary['number'] > 0){
	
	
	
	$xsql4 = "SELECT runno FROM salary WHERE id='$rs[idcard]' AND substring(date,1,4) < 2000 ";
	$xresult4 = mysql_db_query($dbsite,$xsql4);
	while($xrs4 = mysql_fetch_assoc($xresult4)){
		if($date_error > "") $date_error .= ",";
		$date_error .= "$xrs4[runno]";
	}
## ตรวจสอบข้อมูลทั่วไปของเงินเดือน
$arr_salary1 = CheckSalaryNull($idcard);
	if($arr_salary1['NumLine'] != ""){
		$G[14] = false;
		$msg[14] = "[Error Code : G015] ข้อมูลเิงินเดือนเป็นค่าว่าง";
	}else{
		$G[14] = true;	
		$msg[14] = "";
	}
	
	if($arr_salary1['NumNoPosition'] != ""){
		$G[15] = false;
		$msg[15] = "[Error Code : G016] ข้อมูลเลขที่ตำแหน่งการบันทึกเงินเดือนเป็นค่าว่าง  ปี".$arr_salary1['NumNoPosition'];	
	}else{
		$G[15] = true;
		$msg[15] = "";
	}
	
	if($arr_salary1['NumDate'] != ""){
		$G[16] = false;
		$msg[16] = "[Error Code : G017] ข้อมูลวันที่การบันทึกเดือนเดือนเป็นค่าว่างหรือกรอกปีไม่ถูกต้อง บรรทัดที่ ".$date_error;		
	}else{
		$G[16] = true;
		$msg[16] = "";
	}

	//
$dy=explode("-",$rs[begindate]);

// ====  รหัสบัตรบัตรประชาชน  ==========================
	if(!checkID($idcard)){
		$G[1] = false;
		$msg[1] = "[Error Code : G002] ข้อมูลรหัสบัตรประชาชนไม่ถูกต้อง ไม่ตรงรูปแบบของกรมการปกครอง  ";
	}else{
		$G[1] = true;
		$msg[1] = "";
	}
	
// =========== วัน เดือน ปีเกิด ====================
	if($rs[birthday] == ""){
		$G[2] = false;
		$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด เป็นช่องว่าง   ";
	}else{
		$bday1 = explode("-",$rs[birthday]) ;
		$bday1[0] = $bday1[0] ;
		$sql2 = " SELECT '".$bday1[0]."-".$bday1[1]."-".$bday1[2]."' <  '$rs[begindate]' ";
		//echo "$sql2";
		$result2 = @mysql_db_query($dbsite,$sql2);
		$rs2 = @mysql_fetch_array($result2);
		if($rs2[0]==0){
			$G[2] = false;
			$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด ค่าที่ไม่สอดคล้องกับวันเริ่มปฏิบัติราชการ   ";
		}else{
			$G[2] = true;
			$msg[2] = "";
		}
	}

//============================================
// คำนำหน้า
	$flag1 = true ;

	if($rs[prename_th]=="" OR $rs[prename_th]== NULL){
		$flag1 = false ;
		$msg[3] = "<br> - ไม่ระบุคำนำหน้า";
	}
	// ชื่อ
	if($rs[name_th]=="" OR $rs[name_th]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุชื่อ";
	}
	// นามสกุล
	if($rs[surname_th]=="" OR $rs[surname_th]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุนามสกุล";
	}
	// เพศ
	if($rs[sex]=="" OR $rs[sex]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุเพศ";
	}
	// ตำแหน่งเริ่ม
	if($rs[position]=="" OR $rs[position]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งเริ่มรับราชการ";
	}
	// ระดับเริ่มรับราชการ
	if($rs[radub_past]=="" OR $rs[radub_past]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับเริ่มรับราชการ";
	}
	// ตำแหน่งปัจจุับัน
	if($rs[position_now]=="" OR $rs[position_now]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งปัจจุับัน";
	}
	// ระดับปัจจุับัน
	if($rs[radub]=="" OR $rs[radub]== NULL){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับปัจจุับัน";
	}

	if(!$flag1){
			$G[3] = false;
			$msg[3] = "[Error Code : G004] ".$msg[3];
	}

//=========รูป============================

$sql3 = " SELECT *  FROM general_pic WHERE id = '$idcard'  ORDER BY   kp7_active  ASC  " ;
if($result3 = mysql_db_query($dbsite,$sql3)){
	while($rs3 = mysql_fetch_assoc($result3)){
		if($rs[kp7_active] == "0"){
			$G[4] = false;
			$msg[4] = "[Error Code : G005]  ไม่ได้ตั้งค่าแสดงผลในกพ.7 ";
		}else{
			$G[4] = true;
			$msg[4] = "";
		}
	}
}else{
	$G[4] = false;
	$msg[4] = "[Error Code : G005]  ไม่มีข้อมูลรูปในระบบ ";
}

// ==============ประวัติการศึกษา========================
$sql4 = " SELECT id   FROM graduate  WHERE id = '$idcard' " ;
$result4 = mysql_db_query($dbsite,$sql4);

if(!$result4){
	$G[5] = false;
	$msg[5] = "[Error Code : G006]  ไม่มีข้อมูลประวัติการศึกษา ";
}

//===========การลาหยุด=====================
$msgshow11 = "";
$sqlabsent="SELECT Count(hr_absent.yy)as ABDAY FROM hr_absent WHERE hr_absent.id =  '$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' ";
$resultabsent =  mysql_db_query($dbsite,$sqlabsent) ;
$rsab=mysql_fetch_assoc($resultabsent);
$sumab=$rsab[ABDAY];
if($sumwork !=$sumab)
{
	for($i=$dy[0];$i<=2549;$i++)//หาปีที่กรอกข้อมูลไม่ครบ
	{
	$arr1[]=$i;
	}
	
	$sqlfindyy="SELECT yy from  hr_absent where id='$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' order by yy ASC";
	$queryfindyy = mysql_db_query($dbsite,$sqlfindyy) ;
	while($XX=mysql_fetch_assoc($queryfindyy))
	{
		$arr2[]=$XX[yy];
	}
for($i = 0; $i < sizeof($arr1); $i++){

for($j = 0; $j < sizeof($arr2); $j++)
	{ 
			if($arr1[$i] != $arr2[$j]){ 
			$isSame = false;
			}else{
			$isSame = true;
			break;
			} 
	}//for($j = 0; $j < sizeof($arr2); $j++)
	
	if($isSame == false){
		$msgshow11 .= "<br> -  ปี พ.ศ. $arr1[$i]  ";
		}
	}//for($i = 0; $i < sizeof($arr1); $i++){
}
if($msgshow11){
	$G[6] = false;
	$msg[6] = "[Error Code : G007]  ข้อมูลวันลาหยุดไม่สมบูรณ์ ขาด ".$msgshow11;
}
//======================================
$msgshow12 = "";

$sqlsa="SELECT count(runid) AS suma FROM `salary` WHERE `id` LIKE '%$idcard%' AND `date` BETWEEN '2544' AND '2550' ";
$resultsa = mysql_db_query($dbsite,$sqlsa) ;
$rssa=mysql_fetch_assoc($resultsa);
if($rssa[suma]<14 and $dy[0] < 2544){
	$msgshow12 .= "<br> - ในช่วงปี พ.ศ. 2544 - พ.ศ. 2549  กรอกข้อมูลเงินเดือนไม่ครบ";	
}

if($msgshow12 != ""){
	$G[7] = false;
	$msg[7] = "[Error Code : G008]  ข้อมูลเงินเดือนไม่สมบูรณ์ ขาด ".$msgshow12;
}else{
		$G[7] = true;
	$msg[7] = "";
}


$xcheckfile = ShowKp7FileBlue($idcard);
///----------------  ไฟล์ต้นฉบับ -----------------------------------
$path_pdf = "../../../../../edubkk_kp7file/";
$imgpdf = "<img src='../../../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='20' height='21' border='0'>";	

$arrkp7 = GetPdfOrginal($idcard,$path_pdf,$imgpdf,"","pdf");
$ch_file = $_SERVER['DOCUMENT_ROOT']."/edubkk_kp7file/$rs[siteid]/$idcard.pdf" ;
if(!is_file($ch_file) and $arrkp7['numfile'] == "0"){
	if($xcheckfile == "0"){ // กรณียังไม่มีเอกสารสีฟ้า
	$G[8] = false;
	$msg[8] = "[Error Code : G009]  ไม่มีเอกสาร กพ.7 ต้นฉบับ";
	}else{
		$G[8] = true;
		$msg[8] = "";	
	}
}else{
	$G[8] = true;
	$msg[8] = "";
}

###  ตรวจสอบคำนำหน้าชื่อกับสถานะภาพสมรส
if(CheckStatusMarry($rs[prename_id],$rs[marital_status_id]) == false){
	$G[17]	 = false;
	$msg[17] = "[Error Code : G18]  คำนำหน้าชื่้อเป็นนางไม่ควรเลือกสถานะภาพเป็นโสด";
}else{
	$G[17] = true;	
	$msg[17] = "";
}

//#### การเรียงลำดับประวัติการเปลี่ยนชื่อ
//if(CheckOrderHisName($rs[siteid],$rs[idcard]) == false){
//	$G[18] = false;
//	$msg[18] = "[Error Code : G019] การเรียงลำดับชื่อไม่สัมพันธ์กับวันที่เปลี่ยนชื่อ";
//}else{
//	$G[18] = true;
//	$msg[18] = "";
//}

###  วันเริ่มปฏิบัตราชการเป็นค่าว่าง
if($rs[begindate] == ""){
	$G[19] = false;
	$msg[19] = "[Error Code : G020] วันเริ่มปฏิบัติราชการเป็นค่าว่าง";
}else{
	$G[19] = true;
	$msg[19] = "";
}

if(CheckMarry($rs[siteid],$rs[idcard]) > 0 and (($rs[marry] == "" or $rs[marry] == "โสด" or $rs[marry] == "ไม่ระบุ") or ($rs[marital_status_id] == 0 or $rs[marital_status_id] == 2 or $rs[marital_status_id] == 5)) ){
	$G[20] = false;
	$msg[20] = "[Error Code : G021] มีข้อมูลคู่สมรส !สถานะการสมรสไม่ควรเป็นค่าว่างหรือโสดหรือไม่ระบุ";
}else{
	$G[20] = true;
	$msg[20] = "";	
}

$check_radub = intval($rs[radub]);// ตรวจสอบกรณีระดับยังเป็นตัวเลขอยู่เป็นตัวเลข
if($check_radub > 0){
	$G[21] = false;
	$msg[21] = "[Error Code : G022] ข้อมูลระดับปัจจุบันไม่ถูกต้องเนื่องจากการบันทึกเงินเดือนปัจจุบันไม่ถูกต้อง";
}else{
	$G[21] = true;
	$msg[21] = "";
}

//if($action == "getdata" && $idcard != ""){
//
//$sqlx = " INSERT INTO  tempcheckdata(idcard) VALUES ('$idcard') " ;
//mysql_db_query($dbsite,$sqlx);
//
//}
//echo "<pre>";
//print_r($msg);
$intError= 0;
	foreach($G AS $key => $val){
		if($val == false){
			$intError = 1;
			break;
		}
	}

//echo "val : ".$intError;
return $intError;

}// function


#### fucntion แสดงชื่อพนักงานคนบันทึกข้อมูล
function ShowStaffKey($get_staffid){
	$db = DB_USERENTRY;
	$sql = "SELECT staffid,prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($db,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function ShowStaffKey($get_staffid){
	
	
	function GetMistaken($get_mistaken){
	global $db_name;
		$sql_p = "SELECT * FROM validate_mistaken WHERE mistaken_id='$get_mistaken'";
		$result_p = mysql_db_query($db_name,$sql_p);
		$rs_p = mysql_fetch_assoc($result_p);	
		return $rs_p[mistaken];
}
### fucntion หา ticketid
function GetTicketId($get_idcard,$get_staffid){
	global $db_name;
			$sql = "SELECT
		tbl_assign_key.ticketid
		FROM
		tbl_assign_key
		Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
		WHERE
		tbl_assign_sub.staffid =  '$get_staffid' AND
		tbl_assign_key.idcard =  '$get_idcard' AND
		tbl_assign_key.nonactive =  '0'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[ticketid];	
}

## function ตรวจสอบการตรวจข้อมูล
function CheckTrueData($get_idcard,$get_staffid){
	global $db_name;
	$TicketID = GetTicketId($get_idcard,$get_staffid);
	$sql = "SELECT COUNT(idcard) AS numc FROM validate_checkdata  WHERE idcard='$get_idcard' AND staffid='$get_staffid' AND ticketid='$TicketID'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numc];
	
}//end function CheckTrueData(){
	
	
### แบ่งหน้า

function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_siteid,$key_idcard,$key_name,$key_surname,$date_key,$key_staffid,$key_action,$action;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">ส่งออกรูปแบบ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}

### funciton ตรวจสอบ การบันทึกผลการตรวจสอบข้อมูลเบื้องต้นของพนักงานคีย์ข้อมูล
function CheckUserKeyApprove($get_idcard){
	global $db_name;
	$sql_c = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE idcard='$get_idcard' AND nonactive='0' AND userkey_wait_approve='1' ";
	$result_c = mysql_db_query($db_name,$sql_c);
	$rs_c = mysql_fetch_assoc($result_c);
	return $rs_c[num1];
		
}//end function CheckUserKeyApprove($get_idcard){
	
### function ตวจสอบว่ามีการ QC รึุยัง
function CheckQcPerDayPerson($get_staff,$get_idcard){
	global $db_name;
	$sql = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' AND idcard='$get_idcard' GROUP BY idcard";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckQcPerDay($get_staff,$get_idcard){
	
	
	####  funciton ตรวจสอบว่ามีการ รับรองยอดแล้วหรือไม่
function CheckAppriveIncentive($temp_date){
	global $db_name;
	$sql = "SELECT COUNT(datekeyin) AS num1 FROM stat_incentive WHERE datekeyin LIKE '$temp_date%' GROUP BY datekeyin";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckAppriveIncentive(){
	
### function ตรวจสอบกลุ่มที่จะนำไปคำนวณช่ว่งเวลาในการตรวจสอบ
function CheckGroupKey($get_staffid){
	global $db_name;
	$sql_staff = "SELECT if(keyin_group='1' or keyin_group='2', 1,0) as group_val  FROM keystaff  WHERE  staffid='$get_staffid'";
	$result_staff = mysql_db_query($db_name,$sql_staff);
	$rs_staff = mysql_fetch_assoc($result_staff);
	return $rs_staff[group_val];
}//end function CheckGroupKey($get_staffid){
	
	
function ShowSdateEdate($get_date){ 
 $arr_d1 = explode("-",$get_date);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 คือ เลขสัปดาห์ ของวันจันทร์
 ## 6 คือ เลขสัปดาห์ ของวันเสาร์
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป

				 $xbasedate1 = strtotime("$get_date");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป	
				 
				 $arr_date['start_date'] = $xsdate;
				 $arr_date['end_date'] = $xsdate1;
	return $arr_date;
}//end function ShowSdateEdate(){
	
	
	### function ในการคำนวน ค่าคะแนนจุดผิด
function CalSubtract($get_idcard,$get_staffid,$get_ticketid){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$sql_cal = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t1)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard =  '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.ticketid =  '$get_ticketid'  AND 
validate_checkdata.status_cal='0'  AND validate_checkdata.status_process_point='YES'";
//echo $sql_cal."<br>";
	$result_cal = mysql_db_query($dbnameuse,$sql_cal);
	$rs_cal = mysql_fetch_assoc($result_cal);
	if($rs_cal[sumval] > 0){
		return $rs_cal[sumval];	
	}else{
		return 0;	
	}
	
}//end function CalSubtract(){
###  คำนวณคะแนะที่เป็นของวันที่นั้นแต่ไม่ใช่ของชุดที่กำลัง QC อยู่
function CalPointSubtractAdd($get_idcard,$get_staffid,$get_date,$ticketid=""){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	if($ticketid != ""){
			$conv = " AND validate_checkdata.ticketid='$ticketid' ";
	}
	$sql_cal = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard <> '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.qc_date =  '$get_date'  AND validate_checkdata.status_process_point='YES'  $conv";
	$result_cal = mysql_db_query($dbnameuse,$sql_cal);
	$rsc = mysql_fetch_assoc($result_cal);
	if($rs_cal[sumval] > 0){
		return $rs_cal[sumval];		
	}else{
		return 0;	
	}
	
		
}//end function CalPointSubtractAdd($get_staffid,$get_date){

function CalSubtractAB($get_staff,$get_date){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql_ab = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.staffid =  '$get_staff' AND
validate_checkdata.datecal BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND validate_checkdata.status_process_point='YES'
group by validate_checkdata.idcard
order by sumval DESC
LIMIT 1";
	$result_ab = mysql_db_query($dbnameuse,$sql_ab);
	$rs_ab = mysql_fetch_assoc($result_ab);
	return $rs_ab[sumval];
}//end function CalSubtractAB($get_staff,$get_date){
	
#####  function แสดงค่า Ratio การ QC ของแต่ละกลุ่มข้อมูล
function ShowQvalue($get_staffid){
	global $dbnameuse;
	$sqlQ = "SELECT
keystaff_group.rpoint
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff.staffid =  '$get_staffid'";
	$resultQ = mysql_db_query($dbnameuse,$sqlQ);
	$rsQ = mysql_fetch_assoc($resultQ);
	return $rsQ[rpoint];
}//end function ShowQvalue($get_staffid){

function NumP($get_staffid,$get_idcard,$ticketid=""){
	global $dbnameuse;
	if($ticketid != ""){
			$conv = " AND ticketid='$ticketid' ";
	}
	$sqlP = "SELECT COUNT(distinct idcard) AS num1  FROM validate_checkdata  where staffid='$get_staffid'  and idcard ='$get_idcard' $conv ";
	$resultP = mysql_db_query($dbnameuse,$sqlP) or die(mysql_error()."$sqlP<br>LINE::".__LINE__);
	$rsp = mysql_fetch_assoc($resultP);
	//$numP = @mysql_num_rows($resultP);
	return $rsp[num1];
}

function CheckGroupStaff($get_staffid){
	global $dbnameuse;	
	$sql = "SELECT keyin_group FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[keyin_group];
}
function CutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = $arr1[0].".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = $temp_point.".00";	
		}else if($temp_point == "0"){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){
	
	function ViewCutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = number_format($arr1[0]).".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = number_format($temp_point).".00";	
		}else if($temp_point == 0){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){


###  ตรวจสอบว่าภายใน 1 สัปดาห์ มีการตรวจเกินเกณฑ์ที่ำกำหนดรึเปล่า กลุ่ม A 1 ชุดต่อสัปดาห์ กลุ่ม B 2 ชุดต่อสัปดาห์ ถ้าเกินจะคำนวณค่าคะแนนถ่วงน้ำหนักโดยการเฉลี่ย
function CheckQC_Per_Week($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$group_type = CheckGroupStaff($get_staffid);
	if($group_type == "1" or $group_type == "2"){ // เป็นกลุ่ม a และ b
		$sql1 = "SELECT sum(num_p) AS nump FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey between '$xsdate' and '$xedate'";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			if($rs1[nump] > $group_type){ // กรณีที่จำนวนชุดที่สุ่มตรวจมากกว่าค่ามาตรฐานที่สุ่มตรวจ
			$sql2 = "SELECT (sum(spoint)/sum(num_p)) as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$result2 = mysql_db_query($dbnameuse,$sql2);
			$rs2 = mysql_fetch_assoc($result2);
			$pval = CutPoint($rs2[numval]);
			
			## หาวันที่จะทำการบันทึกในช่วงสัปดาห์ห
			$sql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$result3 = mysql_db_query($dbnameuse,$sql3);
			$rs3 = mysql_fetch_assoc($result3);
			$date_save = $rs3[datekey];
			
			$sql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			$result4 = mysql_db_query($dbnameuse,$sql4);
			$rs4 = mysql_fetch_assoc($result4);
				//if($rs4[NUM1] < 1){ // กรณียังไม่ไ้ด้เก็บค่าเฉลี่ยการบันทึกข้อมูล
					$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
					//echo $sql_insert."<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
				### กรณีที่จำนวนชุดที่ตรวจตรงกับค่ามาตรฐาน			
			}else{
			$xsql2 = "SELECT sum(spoint)as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$xresult2 = mysql_db_query($dbnameuse,$xsql2);
			$xrs2 = mysql_fetch_assoc($xresult2);
			$pval = CutPoint($xrs2[numval]);
			
			## หาวันที่จะทำการบันทึกในช่วงสัปดาห์ห
			$xsql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$xresult3 = mysql_db_query($dbnameuse,$xsql3);
			$xrs3 = mysql_fetch_assoc($xresult3);
			$date_save = $xrs3[datekey];
			
			$xsql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			echo "<br>$xsql4<br>";
			$xresult4 = mysql_db_query($dbnameuse,$xsql4);
			$xrs4 = mysql_fetch_assoc($xresult4);
				//if($xrs4[NUM1] < 1){
						$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
						echo "<br><br>$sql_insert<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
	
			}//end if($rs1[nump] > $group_type){
	### กรณีที่ไม่ใช่กลุ่ม A และ B
	}else{
		$sql_insert1 = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p) SELECT stat_subtract_keyin.staffid,
		stat_subtract_keyin.datekey,stat_subtract_keyin.spoint,stat_subtract_keyin.num_p
  FROM stat_subtract_keyin  WHERE stat_subtract_keyin.staffid='$get_staffid' AND stat_subtract_keyin.datekey='$get_date'";	
  		mysql_db_query($dbnameuse,$sql_insert1);
	}//end 	if($group_type == "1" or $group_type == "2"){ 
	
}//end function CheckQC_Per_Week($get_staffid,$get_date){
	
####  ตรวจสอบค่าสะสมว่ามีการหักค่าคะแนนลบรึยัง
function CheckSubpointAvg($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$sql = "SELECT sum(subtract) as s_val FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin  between '$xsdate' and '$xedate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[s_val];
}
###  function รวมค่าสะสมเอามาเป็นค่่าคะแนนที่จะเอาไปลบกับคะแนนถ่วงน้ำหนัก
function SumTempPoint($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$arr_d1 = explode("-",$get_date);
	$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]+1), intval($arr_d1[2]-1), intval($arr_d1[0]))));
	$end_date = $arr_d1[0]."-".$arr_d1[1]."-".$xFTime['mday'];
	$sql = "SELECT
sum(stat_incentive_temp.kpoint_add) as kpoint_add,
sum(stat_incentive_temp.subtract) as subtract
FROM `stat_incentive_temp`
where staffid='$get_staffid' and datekeyin  between '$start_date1' and '$end_date' ";
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	//echo $rs[net_point]."<br>";
	return $rs[kpoint_add]-$rs[subtract];
}

###  function ตรวจสอบค่าสะสมก่อนการคำนวณใหม่
function CheckPointADD($get_staffid,$get_date){
	global $dbnameuse;
	$sql = "SELECT COUNT(staffid) AS numc FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$get_date' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numc];
}

### function ตรวจสอบว่ามีการ QC หรือไม่
function CheckQC1($get_staffid,$get_date){
	global $dbnameuse;	
	$sql = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg WHERE staffid='$get_staffid' AND datekey='$get_date' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
}
###  รวมคะแนนสะสมโดยไม่ต้องหัก
function SumAdd($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$sql = "SELECT ROUND(SUM(kpoint_add),2) AS sumadd FROM stat_incentive WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[sumadd];
}//end function SumAdd(){
	
### sum ค่าลบก่อน
function xSumSubtract($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$yymm = $arrxd[0]."-".$arrxd[1];
	if($arrxd[2] != "01"){ // กรณีไม่ใช่วันที่ 1 ของเดือน
		$xbasedate = strtotime("$get_date");
		$xdate = strtotime("-1 day",$xbasedate); // ย้อนหลังไป 1 วัน
		$xsdate = date("Y-m-d",$xdate);// วันถัดไป
		$condate = $xsdate;
	}else{
		$condate = $get_date;	
	}
	## ตรวจสอบก่อนว่าก่อนหน้านี้มีค่าสะสมอยู่รึเปล่า
	$sqlx = "SELECT SUM(net_point) as sumx1 FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date' ";
	$resultx = mysql_db_query($dbnameuse,$sqlx);
	$rsx = mysql_fetch_assoc($resultx);
	
	
	$sql = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$condate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[net_point] == 0){
		if($rsx[sumx1] != 0){
			$sql1 = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND net_point <> 0 ORDER BY datekeyin DESC LIMIT 1";	
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$stat_val = $rs1[net_point];
		}	
	}else{
			$stat_val = $rs[net_point];
	}
	
	return $stat_val;
}
### หาวันเริ่มปฏิบัติงาน
function ShowStartDate($staffid){
	global $dbnameuse,$monthname;
	$sql = "SELECT date(timeupdate) as start_date  FROM `monitor_keyin` where staffid='$staffid' AND date(timeupdate) <> '0000-00-00' order by timeupdate ASC LIMIT 1";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$d1=explode("-",$rs[start_date]);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
	
}// end function ShowStartDate($staffid){
	
######## ฟังก์ชั้นหาวันที่ทำการ QC
function GetDateQC($get_idcard,$staffid,$ticketid){
	global $dbnameuse;
	$sql_date = "SELECT qc_date FROM validate_checkdata WHERE validate_checkdata.idcard='$get_idcard' AND validate_checkdata.staffid='$staffid' AND validate_checkdata.ticketid='$ticketid' ";
	$result_date = mysql_db_query($dbnameuse,$sql_date);
	$rsd = mysql_fetch_assoc($result_date);
	return $rsd[qc_date];	
}//end function GetDateQC(){
################  ฟังก์ชั่นคำนวณค่าคะแนนกรณีที่มีการคำนวนเสร็จ
function CalSubtractQc($get_idcard,$staffid,$ticketid=""){
	global $dbnameuse;
	
	if($ticketid != ""){
			$con_ticketid = " AND t2.ticketid='$ticketid' ";
	}
	
	$sql = "SELECT DISTINCT
t1.idcard,
t1.staffid,
t2.ticketid,
t1.timestamp_key as timeupdate
FROM
monitor_keyin as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard
WHERE
t1.idcard = '$get_idcard' and t1.staffid='$staffid' $con_ticketid  order by t1.timestamp_key DESC LIMIT 1 ";	
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr_d = explode(" ",$rs[timeupdate]);
	$datereq1 = $arr_d[0];// วันที่ทำการ QC
	//echo $rs[staffid] ." :: ".$rs[idcard];die;
	$nump = NumP($rs[staffid],$rs[idcard],$rs[ticketid]);
	$subtract = CalSubtract($rs[idcard],$rs[staffid],$rs[ticketid]); // ค่าคะแนนที่คำนวณได้
	$qc_date = GetDateQC($rs[idcard],$rs[staffid],$rs[ticketid]); // หาวันที่ทำการ QC เพื่อจะเอาไปเป็นคะแนนลบของวันที่นั้นๆ
	//echo ShowQvalue($rs[staffid]);die;
	//echo $nump."::".$subtract." ::".$qc_date;die;
	
	if($qc_date != "0000-00-00" and $qc_date != ""){
			$datereq1 = $qc_date;
	}else{
			$datereq1 = $datereq1;
	}//end if($qc_date != "0000-00-00" and $qc_date != ""){
	//echo $subtract;die;
	$sql_update = "UPDATE validate_checkdata SET status_cal='1' ,datecal='$datereq1'  WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]' AND ticketid='$rs[ticketid]' and status_cal='0'";
	//echo $sql_update."<br>";
	mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
	
	$subtract_add = CalPointSubtractAdd($rs[idcard],$rs[staffid],$datereq1,$rs[ticketid]);
	
	$arr_subtract[$rs[staffid]] = $arr_subtract[$rs[staffid]]+$subtract+$subtract_add;
	$arr_num_p[$rs[staffid]] = $arr_num_p[$rs[staffid]]+$nump;
	
	
	$arr_d1 = explode("-",$datereq1);
 	$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 	$curent_week = $xFTime["wday"];
 
 ## 1 คือ เลขสัปดาห์ ของวันจันทร์
 ## 6 คือ เลขสัปดาห์ ของวันเสาร์
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$datereq1");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
				 
				 $xbasedate1 = strtotime("$datereq1");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป

	
	#########  เก็บในฐานข้อมูล
	if(count($arr_subtract) > 0){
	foreach($arr_subtract as $key => $val){		
		$group_type = CheckGroupKey($key); // ตรวจสอบกลุ่มการคีย์ข้อมูลถ้าค่า เป็น 1 แสดงว่า เป็น กลุ่ม A และ กลุ่ม B ซึ่งจะนำมาหักตามช่วงเวลาที่กำหนด
		$arrk1 = GetKeyinGroupDate($key,$datereq1);					
		$kgroup = $arrk1['keyin_group']; // หากลุ่มตามช่วงเวลาการคีย์ข้อมูล
		//echo "a : ".$kgroup."<br>";
		$rpoint = intval($arrk1['rpoint']); // ค่าถ่วงน้ำหนักกาี QC ของแต่ละกลุ่ม 
		//echo "B : ".$ratio_point;
		
		if($rpoint < 1){
			$rpoint = intval(ShowQvalue($key));	// หาคะแนนถ่วงน้ำหนักตามช่วงเวลา
		}//end 

		
		if($group_type > 0){
			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p,point_ratio)VALUES('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."','$rpoint')";
		}else{
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p,point_ratio)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."','$rpoint')";	
			$str_update = "";
		}//end if($group_type > 0){
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
		$result_select = mysql_db_query($dbnameuse,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
			if($val > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]',point_ratio='$rpoint' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
				//echo " UP  ::".$sql_insert."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert);
			}//end 	if($val > 0){	
		}else{
				if($val > 0){
					//echo "insert ::".$sql_insert1."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert1);
				}//end if($val > 0){
		}//end if($rs_s[spoint] > 0){

		
	}//end foreach($arr_subtract as $key => $val){ 
		
	}//end if(count($arr_subtract) > 0){


}//end function CalSubtractQc($get_idcard){
	
function ShowRatioDate($kgroup){
	global $dbnameuse;
	$sql = "SELECT rpoint FROM keystaff_group WHERE groupkey_id='$kgroup'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[rpoint];
}//end function ShowRatioDate($kgroup){	
	
function GetKeyinGroupDate($get_staffid,$get_date){
	global $dbnameuse;
	$sql = "SELECT rpoint, keyin_group  FROM stat_user_keyin  WHERE  staffid='$get_staffid' AND datekeyin='$get_date'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$arr['rpoint'] = $rs[rpoint];
	$arr['keyin_group'] = $rs[keyin_group];
	return $arr;
}//end function GetKeyinGroupDate($get_staffid,$get_date){	
	
	
	

	
####  function แสดงวันที่คีย์ข้อมูล
function ShowYYMMKey($get_idcard,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT
date(monitor_keyin.timeupdate) as datekey
FROM `monitor_keyin`
where staffid='$get_staffid' and idcard = '$get_idcard'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[datekey];
}//end function ShowYYMMKey($get_idcard,$get_staffid){
	
###  ตรวจสอบว่าถ้ามีการคีย์อยู่จะไม่อนุญาติให้ QC
function CheckOnlineKey($get_idcard){
	global $db_system;
	$sql = "SELECT COUNT(username) as numkey FROM useronline WHERE username='$get_idcard'";
	//echo "$sql";
	$result = mysql_db_query($db_system,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numkey];	
}// end function CheckOnlineKey(){
	
	
### function Show Flag_qc 
function ShowFlagQc($idcard,$staffid){
		global $dbnameuse;
		$sql = "SELECT  flag_qc  FROM stat_user_keyperson WHERE idcard='$idcard' AND staffid='$staffid' LIMIT 1";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[flag_qc];
}//end function ShowFlagQc(){
	
#####  function UPDATE การ approve การคีย์ข้อมูลในตาราง assign
function ApproveAssign($idcard,$flagid="",$staffid=""){
		global $dbnameuse;
		if($flagid > 0){
			$sql_main = "SELECT * FROM stat_user_keyperson WHERE staffid='$staffid' AND flag_qc='$flagid'";
			$result_main = mysql_db_query($dbnameuse,$sql_main);
			while($rsm = mysql_fetch_assoc($result_main)){
					$sql = "UPDATE  tbl_assign_key SET approve='2' WHERE idcard='$rsm[idcard]'";
					mysql_db_query($dbnameuse,$sql);
			}//end while($rsm = mysql_fetch_assoc($result_main)){
				
		}else{
			$sql = "UPDATE tbl_assign_key  SET approve='2' WHERE idcard='$idcard'";	
			mysql_db_query($dbnameuse,$sql);
		}//end 	
}//end function ApproveAssign(){

?>