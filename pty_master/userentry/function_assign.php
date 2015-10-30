<?
include("function_assign_group.php");
require_once("../../config/conndb_nonsession.inc.php");
//require_once("../../config/conndb_nonsession.inc.php");
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
$s_db = STR_PREFIX_DB;
$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
$path_checklist = "../../../edubkk_kp7file/";

function ran_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}


$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

				function thai_date($temp){
				global $mname;
				$x = explode("-",$temp);
				$m1 = $mname[intval($x[1])];
				$y1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				return $xrs;
			}


				function thai_datev1($temp){
				global $mname;
				$x = explode("-",$temp);
				$m1 = $mname[intval($x[1])];
				$y1 = intval($x[0]);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				return $xrs;
			}

## function ตรวจสอบการส่งงาน
function check_status_sent_job($ticketid){
	global $db_name;
	$sql = "SELECT count(idcard) as num1 FROM  tbl_assign_key WHERE ticketid='$ticketid' and (approve = '0' or approve = '1')  and nonactive = '0' GROUP BY ticketid"; 
	$result = mysql_db_query($db_name,$sql);
	$rs = @mysql_fetch_assoc($result);
	
//	$sql1 = "SELECT COUNT(*) AS num11  FROM  tbl_assign_key WHERE ticketid='$ticketid'";
//	$result1  = @mysql_db_query($db_name,$sql1);
//	$rs1 = @mysql_fetch_assoc($result1);
//	if($rs[num1] == $rs1[num11]){  $temp_1 = 1;}else{ $temp_1 = 0;}
	return $rs[num1]; 
}//
## function ตรวจสอบการส่งงาน

function check_status_sent_comp($ticketid){ // ฟังก์ชั่นส่งงานเรียบร้อยแล้ว
	global $db_name;
	$sql = "SELECT count(idcard) as num1 FROM  tbl_assign_key WHERE ticketid='$ticketid' and (approve = '2')  and nonactive = '0' GROUP UP ticketid"; 
	$result = mysql_db_query($db_name,$sql);
	$rs = @mysql_fetch_assoc($result);
	
	$sql1 = "SELECT COUNT(idcard) AS num11  FROM  tbl_assign_key WHERE ticketid='$ticketid'  and nonactive = '0' GROUP BY ticketid";
	$result1  = @mysql_db_query($db_name,$sql1);
	$rs1 = @mysql_fetch_assoc($result1);
	
	if($rs[num1] == $rs1[num11]){  $temp_1 = 1;}else{ $temp_1 = 0;}
	
	return $temp_1;
}//

function check_status_wqc($ticketid){ // สถานะรอ QC
	global $db_name;
	$sql = "SELECT count(idcard) as num1 FROM  tbl_assign_key WHERE ticketid='$ticketid' and (approve = '3')  and nonactive = '0'  GROUP BY ticketid "; 
	$result = mysql_db_query($db_name,$sql);
	$rs = @mysql_fetch_assoc($result);
	
	$sql_1 = "SELECT COUNT(idcard) AS num_1 FROM tbl_assign_key WHERE ticketid='$ticketid' and approve = '2'  and nonactive = '0' GROUP BY ticketid";
	$result_1 = @mysql_db_query($db_name,$sql_1);
	$rs_1 = @mysql_fetch_assoc($result_1);
	
	$temp_i = $rs[num1]+$rs_1[num_1]; // รวมสถานะตรวจงานเสร็จกับรอตรวจงาน
	
	$sql1 = "SELECT COUNT(idcard) AS num11  FROM  tbl_assign_key WHERE ticketid='$ticketid'  and nonactive = '0' GROUP BY ticketid";
	$result1  = @mysql_db_query($db_name,$sql1);
	$rs1 = @mysql_fetch_assoc($result1);
	if($rs[num1] > 0){
	if($temp_i == $rs1[num11]){  $temp_1 = 1;}else{ $temp_1 = 0;}
	}else{
		$temp_1 = 0;
	}
	
	return $temp_1;

}

# ฟังก์ชั่นในการนับจำนวนบุคลากรที่คีย์เสร็จแล้ว
function count_key_sucssec($staffid){
global $db_name;
	$sql1 = "SELECT siteid  FROM tbl_asign_key  WHERE staffid='$staffid'  and nonactive = '0' GROUP BY siteid";
	$result1 = mysql_db_query($db_name,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
	$sql2 = "SELECT COUNT(tbl_asign_key.idcard) AS num1 FROM tbl_asign_key INNER JOIN  monitor_keyin ON tbl_asign_key.idcard = monitor_keyin.idcard  WHERE monitor_keyin.siteid='$rs1[siteid]' AND monitor_keyin.staffid='$staffid'  and nonactive = '0'  GROUP BY monitor_keyin.idcard ";
	//echo $sql2;
	$result2 = mysql_db_query($db_name,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
		$temp_num  = $temp_num + $rs2[num1];
	}
	return $temp_num;
}// end function count_key_sucssec(){

# ฟังก์ชั่นในการนับจำนวนบุคลากรที่หมอบหมายให้ผู้คีย์ข้อมูล
function count_assign_key($ticketid){
global $db_name;
	$sql_count = "SELECT COUNT(idcard) AS  num1  FROM  tbl_assign_key  WHERE ticketid='$ticketid' and nonactive = '0' GROUP BY ticketid";
	$result_count = @mysql_db_query($db_name,$sql_count);
	$rs = @mysql_fetch_assoc($result_count);
	if($rs[num1] > 0){ $temp_result = $rs[num1];}else{ $temp_result = 0;}
	return $temp_result;
}
# end  ฟังก์ชั่นในการนับจำนวนบุคลากรที่หมอบหมายให้ผู้คีย์ข้อมูล

## ฟังก์ชั่นแสดงวันที่มอบหมายล่าสุด
function show_max_date($staffid){
global $db_name,$monthname;
	$sql_max = "SELECT MAX(sign_date) AS max_date FROM tbl_asign_key WHERE staffid='$staffid' AND sign_date <> '0000-00-00' and nonactive = '0'";
	$result_max = @mysql_db_query($db_name,$sql_max);
	$rs = @mysql_fetch_assoc($result_max);
	if($rs[max_date] != "0000-00-00" and $rs[max_date] != ""){
			$arr_t = explode("-",$rs[max_date]);
			$temp_result = intval($arr_t[2])." ".$monthname[intval($arr_t[1])]." ".($arr_t[0]+543);
	}else{
			$temp_result = "";
	}
	return $temp_result;
}
## end function show_max_date(){

function show_user($staffid){
	global $db_name;
	$sql = "SELECT *  FROM  keystaff  WHERE staffid='$staffid'";
	$result = @mysql_db_query($db_name,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[prename]."".$rs[staffname]." ".$rs[staffsurname];

}// end function show_user(){



function person_not_assign($xidcard,$xsiteid,$ticketid){ // ฟังก์ชั่นตรวจสอบกรณีบุคลากรถูก assing ยกเว้นตัวเอง
global $db_name,$profile_id;
	con_db($xsiteid);
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE  idcard = '$xidcard' and nonactive = '0' and profile_id='$profile_id' GROUP BY idcard ";
	#echo $sql_p."<br>";
	$result_p = @mysql_db_query($db_name,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];
}// end function person_not_assign(){

## ตรวจสอบของตัวเอง
function person_select_assign($xidcard,$xsiteid,$ticketid){
global $db_name;
	con_db($xsiteid);
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE ticketid = '$ticketid' AND idcard = '$xidcard' and nonactive = '0' GROUP BY idcard ";
	$result_p = @mysql_db_query($db_name,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];

}// function person_select_assign($xidcard,$xsiteid){

## ฟังก์ชั่นแสดงชื่อหน่วยงาน/โรงเรียน
function show_org($schoolid){
global $dbnamemaster;
$sql_org = "SELECT * FROM allschool WHERE id='$schoolid'";
//echo $dbnamemaster." :: ".$sql_org;
$result_org = mysql_db_query($dbnamemaster,$sql_org);
$rs_org = mysql_fetch_assoc($result_org);
if($rs_org[office] != ""){ $temp_org = $rs_org[office];}else{ $temp_org = "ไม่ระบุ";}
return $temp_org;
}// end function show_org(){

## ฟังก์ชัน สลับวันที่
function sw_date_indb($temp_date){
	if($temp_date != ""){
		$arr = explode("/",$temp_date);
		if($arr[2] > 2500){
			$result = ($arr[2]-543)."-".$arr[1]."-".$arr[0];
		}else{
			$result = ($arr[2])."-".$arr[1]."-".$arr[0];
		}
	}else{
		$result = "0000-00-00";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){

## ฟังก์ชัน แสดงวันที่ใน texbox
function sw_date_intxtbox($temp_date){
	if($temp_date != "0000-00-00"){
		$arr = explode("-",$temp_date);
		$result = $arr[2]."/".$arr[1]."/".($arr[0]+543);
	}else{
		$result = "";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){


function show_date($temp_date){
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

	if($temp_date != "0000-00-00"){
		$arr_d = explode("-",$temp_date);
		$txt_date = intval($arr_d[2])." ".$mname[intval($arr_d[1])]." ".($arr_d[0]+543);
	}else{
		$txt_date = "";
	}

return $txt_date;

}// end function show_date()


###  function คำนวณค่าใช้จ่าย

function cal_amount_pay($ticketid){
	global $db_name,$dbnamemaster;
	$cyy = (date("Y")+543);
	
	$sql = "SELECT
	TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  
	FROM
	$db_name.tbl_assign_key
	Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid' and $db_name.tbl_assign_key.nonactive = '0'";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[age_gov] > 0){
		$temp_age = floor($rs[age_gov]); // คำนวณอายุเต็ม
		if(DIS_PERCEN > 0){ ## กรณีลดเปอร์เซ็น
			$temp_sum = 20+(($temp_age*1.975)*0.9);
			$xsum = number_format($temp_sum-(($temp_sum*DIS_PERCEN)/100),2);
		}else{
			$xsum = number_format(20+(($temp_age*1.975)*0.9),2);
		}
		$xsum1 = str_replace(",","",$xsum);
		
		$result_sum += $xsum1;
		}
	}
	
	return  $result_sum;
}// end function cal_amount_pay($ticketid){

##  end function คำนวนค่าใช้จ่าย

## function นับจำนวน เอกสาร ก.พ.7 #################   credit  by พี่น้อย #################################3
function count_page($idcard,$siteid) {

		$file = "../../../edubkk_kp7file/$siteid/$idcard.pdf";
		//echo $file ;
        if(file_exists($file)) { 

            //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
                    } 
                    else { 
                          $contents = fread($handle, 1000); 
                        //In some pdf files, there is an N tag containing the number of 
                        //of pages. This doesn't seem to be a result of the PDF version. 
                        //Saves reading the whole file. 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
                            return $found[1]; 
                        } 
                    } 
                    $i++; 
                } 
                fclose($handle); 
  
                //get all the trees with 'pages' and 'count'. the biggest number 
                //is the total number of pages, if we couldn't find the /N switch above.                 
                if(preg_match_all("/\/Type\s*\/Pages\s*.*\s*\/Count\s+([0-9]+)/", $contents, $capture, PREG_SET_ORDER)) { 
                    foreach($capture as $c) { 
                        if($c[1] > $count) 
                            $count = $c[1]; 
                    } 
                    return $count;             
                } 
            } 
        } 
        return 0; 
}

###  end function  นับจำนวนหน้า

###  end function  นับจำนวนหน้า

require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');
### function นับจำนวนหน้า pdf by พี่น้อย
function CountPageSystem($idcard,$siteid){
	$pathfile = "../../../edubkk_kp7file/$siteid/$idcard.pdf";
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}
### end function CountPageSystem($pathfile){
	


## ฟังก์ชั่นตรวจสอบการบันทึกข้อมูลซ้ำ
function check_assign_replace($idcard,$ticketid){
global $db_name,$profile_id;
	$sql = "SELECT count(idcard) as num1 FROM tbl_assign_key WHERE idcard='$idcard'  and nonactive = '0' and profile_id='$profile_id' GROUP BY idcard  ";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	
	return $rs[num1];

}
## end ฟังก์ชั่นตรวจสอบการบันทึกข้อมูลซ้ำ

## ฟังก์ชั่นตรวจสอบก.พ. 7 ต้นฉบับ
function check_kp7file($idcard,$siteid){
global $path_checklist;
$file = $path_checklist."$siteid/$idcard.pdf";

	//	$file = "../../../edubkk_kp7file/$siteid/$idcard.pdf";
		//echo $file ;
        if(is_file($file)) { 
			return 1;
		}else{
			return 0;
		}
}// end check_kp7file(){


## function gen password kp7 file   by === พี่น้อย ===============================

function pdfEncrypt ($origFile, $password, $destFile){
//include the FPDI protection http://www.setasign.de/products/pdf-php-solutions/fpdi-protection-128/
require_once('fpdi/FPDI_Protection.php');

$pdf =& new FPDI_Protection();
// set the format of the destinaton file
$pdf->FPDF('P', 'mm', array(260,380));

//calculate the number of pages from the original document
$pagecount = $pdf->setSourceFile($origFile);

// copy all pages from the old unprotected pdf in the new one
for ($loop = 1; $loop <= $pagecount; $loop++) {
$tplidx = $pdf->importPage($loop);
$pdf->addPage();
$pdf->useTemplate($tplidx);
}

// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
$pdf->SetProtection(array(), $password, '');
$pdf->Output($destFile, 'F');

return $destFile;
}


### function แสดงพื้นที่
function show_area($siteid){
global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	
	return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);
} // end function แสดงพื้นที่

## function แสดงรหัส เขต 20 เขต
function in_area(){
	global $dbnamemaster,$profile_id;
	$sql = "SELECT
eduarea.secid
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id'
";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($site_in > "") $site_in .= ",";
		$site_in .= "'$rs[secid]'";
	}
return $site_in;
}// end function in_area(){


## function คำนวณ จำนวนแผ่นงานทั้งหมดต่อ 1 เอกสารมอบงาน

function sum_count_page($ticketid){
global $db_name,$dbnamemaster;
$xcyy = (date("Y")+543);
$xsql1 = "SELECT
$db_name.tbl_assign_key.ticketid,
$dbnamemaster.view_general.CZ_ID,
$dbnamemaster.view_general.siteid,
$dbnamemaster.view_general.prename_th,
$dbnamemaster.view_general.name_th,
$dbnamemaster.view_general.surname_th,
$dbnamemaster.view_general.position_now,
$dbnamemaster.view_general.schoolid,
TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  
FROM
$db_name.tbl_assign_key
Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid' AND $db_name.tbl_assign_key.nonactive = '0'";
$xresult1 = mysql_db_query($db_name,$xsql1);
while($xrs1 = mysql_fetch_assoc($xresult1)){
	//$p_result = CountPageSystem($xrs1[CZ_ID],$xrs1[siteid]);
	$p_result = NumPageCheckListPdf($xrs1[CZ_ID],$xrs1[siteid]);
	//if($p_result <= 1){ $p_result = 3;}else{ $p_result = $p_result;}
	
	//echo $p_result."<br>";
	
	$xp_result = $xp_result + $p_result;
	
}

return $xp_result;

}// end function sum_count_page($ticketid){

###  ฟังก์ชั่นคำนวณค่าใช้จ่ายจริง ทั้งหมด
function cal_budget_all_true($ticketid,$get_idcard=""){
global $db_name,$s_db;

if($get_idcard != ""){ $conv = " AND idcard NOT IN ($get_idcard)";}else{ $conv = "";}
	if($db_name != "") { $db_name = $db_name;}else{ $db_name = DB_USERENTRY;}
	$sql = "SELECT * FROM tbl_assign_key WHERE ticketid='$ticketid' $conv";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
		//if($rs[approve] == 2){ // คำนวณเฉพาะรายการที่ผ่านเท่านั้น
		$db_cal = "$s_db".$rs[siteid];
		$sql_count  =  "SELECT COUNT(id) AS num1 FROM salary WHERE  id='$rs[idcard]' GROUP BY id ";
		//echo $sql_count." == $db_cal";
		$result_count = @mysql_db_query($db_cal,$sql_count);
		$rs_c = @mysql_fetch_assoc($result_count);
		if($rs_c[num1] > 0){
			$temp_n =  @number_format(($rs_c[num1] * 0.9)+20,2);
			$temp_n1 = str_replace(",","",$temp_n);
			$result_num += $temp_n1;
		} // end 	if($rs_c[num1] > 0){
		//}// end 	if($rs[approve] == 2){
	}// end while
	
	return $result_num;
}
## end ฟังก์ชั่นคำนวณค่าใช้จ่ายจริง


## ฟังก์ชั่นเช็คความถูกต้องการบันทึกข้อมูลเงินเดือน
function check_record_salary($idcard,$siteid){
	global $s_db;
	$db_cal = "$s_db".$siteid;
	$sql = "SELECT COUNT(id) AS num_e FROM salary WHERE id='$idcard' and  (pls = '' or pls IS NULL) and (noorder = '' or noorder IS NULL) GROUP BY id";
	//echo $sql;
	$result = @mysql_db_query($db_cal,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[num_e];
}

## end ฟังก์ชั่นเช็คความสมบูรณ์การบันทึกข้อมูลของคนบันทึกข้อมูลเงินเดือน

##   ฟังก์ชั่นคำนวณค่าใช้จ่ายจริงรายบุคคล
function cal_budget_1_true($idcard,$siteid){
	global $s_db;
	$db_cal = $s_db.$siteid;
	$sql = "SELECT COUNT(id) AS num_t FROM salary WHERE id='$idcard' GROUP BY id ";
	$result = @mysql_db_query($db_cal,$sql);
	$rs = @mysql_fetch_assoc($result);
	if($rs[num_t] > 0){ 
		return number_format(($rs[num_t]*0.9)+20,2);
	}else{
		return "0";
	}
}// end function cal_budget_1_true(){
## end ฟังก์ชั่นคำนวณค่าใช้จ่ายจริงรายบุคคล

### ฟังก์ชั่นตรวจสอบ ไฟล์เอกสารไม่ชัด
	function check_pfd_fail1($siteid,$idcard){
	global $dbnamemaster;
			$sql = "SELECT COUNT(idcard) AS num1 FROM log_pdf  WHERE secid='$siteid' AND idcard='$idcard' AND status_file='0' GROUP BY idcard ";
			$result = mysql_db_query($dbnamemaster,$sql);
			$rs = mysql_fetch_assoc($result);
			return $rs[num1];
	} // end function check_pfd_fail1($siteid,$idcard){
	
################################################   ฟังก์ชั่นในการตรวจสอบความถูกต้องของข้อมูลก่อนการรับรองข้อมูล
	function check_data_approve($idcard,$siteid){
		$db_name = STR_PREFIX_DB.$siteid;
		$sql = "SELECT * FROM general WHERE  idcard='$idcard'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
			if($rs[prename_th] == "" and $rs[name_th] == "" and $rs[surname_th] == ""){
					$msg_err = "NAME ERROR";
			}else if($rs[schoolid] == "" or $rs[schoolid] == NULL){
					$msg_err = "SCHOOL ERROR";
			}else if($rs[birthday] == "" or $rs[birthday] == NULL or $rs[birthday] == "0000-00-00"){
					$msg_err = "BIRTHDAY ERROR";
			}else if($rs[begindate] == "" or $rs[begindate] == NULL or $rs[begindate] == "0000-00-00"){
					$msg_err = "BEGINDATE ERROR";
			}else if($rs[sex] == "" or $rs[sex] == NULL){
					$msg_err = "SEX ERROR";
			}else if($rs[position_now] == "" or $rs[position_now] == NULL){
					$msg_err = "POSITION ERROR";
			}else if($rs[salary] < 1){
					$msg_err = "SALARY ERROR";
			}else if($rs[position_now] != "ครูผู้ช่วย" and ($rs[noposition] == "" or $rs[noposition] == NULL)){
					$msg_err = "NOPOSITION ERROR";
			}else {
					$msg_err = "";
			}
		
		return $msg_err;
			
	}// end function check_data_approve(){
##################################################  end ฟังก์ชั่นในการตรวจสอบความถูกต้องของข้อมูลก่อนการรับรองข้อมูล


### funciton ตรวจสอบ กรณีเป็นข้อมูลเก่าของปีที่แล้วและจะ assign ให้ sub จะไม่อนุญาติให้ assign ได้
	function CheckTypeUser($get_staffid){
			global $db_name;
			$sql = "SELECT COUNT(staffid) AS num FROM keystaff WHERE staffid='$get_staffid' AND sapphireoffice='2' OR status='pm' GROUP BY staffid ";
			$result = mysql_db_query($db_name,$sql);
			$rs = mysql_fetch_assoc($result);
			return $rs[num];
	}
	### ตรวจสอบว่าเป็นข้อมูลเำ่ก่าจากโครงการปีที่แล้วรึเปล่า
	function CheckOldData($get_idcard){
		global $db_name;
		$sql = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE idcard='$get_idcard'  GROUP BY idcard ";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}
	
	########### นับจำนวนแผ่นเอกสารไฟล์ pdf
	function NumPageCheckListPdf($get_idcard,$get_siteid){
			global $db_temp;
			$sql = "SELECT page_upload FROM tbl_checklist_kp7 WHERE idcard='$get_idcard' AND siteid='$get_siteid'";
			$result = mysql_db_query($db_temp,$sql);
			$rs = mysql_fetch_assoc($result);
			return $rs[page_upload];
	}//end function NumPageCheckListPdf(){
		
###############  function เก็บ log การ assign งาน
	function SaveLogAssign($action,$ticketid,$idcard,$status_file){
			global $dbnameuse;
			$ip = get_real_ip();
			$sql_save = "INSERT INTO  tbl_log_assign_key SET action='$action', staffid_assign='".$_SESSION['session_staffid']."',ticketid='$ticketid',idcard='$idcard',status_file='$status_file',ip_assign='$ip' ";
			//echo $db_temp." :: ".$sql_save;die;
			mysql_db_query($dbnameuse,$sql_save);
	}//end function SaveLogAssign(){
		
function SaveAssignActivityTicketId($TicketId,$ssiteid,$staffid,$profile_id,$dateassign,$session_staffid){
	global $db_temp,$activity1,$staff_recivekey;

	$sql_tk = "INSERT INTO tbl_checklist_assign SET ticketid='$TicketId' , siteid='$ssiteid', staffid='$staff_recivekey',activity_id='$activity1', profile_id='$profile_id',date_assign='$dateassign', staff_assign='$session_staffid',flag_assign='1',timeupdate_scan=NOW()";
	$result_tk = mysql_db_query($db_temp,$sql_tk);
	
}// end function SaveAssignActivityTicketId(){
		
function SaveAssignActivity($TicketId,$idcard,$xsiteid,$prename_th,$name_th,$surname_th,$profile_id){
	global $db_temp,$activity1;
							$sql_check = "SELECT * FROM  tbl_checklist_assign_detail WHERE  idcard='$idcard' and profile_id='$profile_id' and activity_id='$activity1'" ;
							$result_chekc = @mysql_db_query($db_temp,$sql_check);
							$rs_ch = @mysql_fetch_assoc($result_chekc);
								if($rs_ch[idcard] != ""){
										$sql_insert = "UPDATE tbl_checklist_assign_detail SET siteid='$xsiteid', prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id' , ticketid='$TicketId' WHERE ticketid='$rs_ch[ticketid]' AND idcard='$idcard' and activity_id='$activity1'";
								}else{
									$sql_insert = "INSERT INTO tbl_checklist_assign_detail(ticketid,idcard,siteid,prename_th,name_th,surname_th,profile_id,activity_id)VALUES('$TicketId','$idcard','$xsiteid','$prename_th','$name_th','$surname_th','$profile_id','$activity1')";
								}
								## end ตรวจสอบข้อมูลก่อนเพิ่ม
							mysql_db_query($db_temp,$sql_insert);

}// end function SaveAssignActivity(){		

### คำนวนค่าคะแนนลบ
function GetSubtractPointTicketid($staffid,$ticketid){
	global $dbnameuse;
	$sql = "SELECT
sum(stat_subtract_keyin.spoint) as sumpoint
FROM `stat_subtract_keyin`
where staffid='$staffid' AND (ticketid='' or ticketid IS NULL) and status_cal='0'
group by staffid";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$sql_up = "UPDATE stat_subtract_keyin SET ticketid='$ticketid' WHERE  staffid='$staffid' AND (ticketid='' or ticketid IS NULL) and status_cal='0'";
	mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
	return $rs[sumpoint];
		
}//end function GetSubtractPointTicketid(){
	

function ShowPointSubtract($staffid,$ticketid){
	global $dbnameuse;
	$sql = "SELECT COUNT(*) as num1 FROM  stat_subtract_keyin WHERE staffid='$staffid' AND  ticketid='$ticketid'  ";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	if($rs[num1] > 0){
		GetSubtractPointTicketid($staffid,$ticketid);
		$sql1 = "SELECT sum(stat_subtract_keyin.spoint) as sumpoint FROM stat_subtract_keyin WHERE staffid='$staffid' AND  ticketid='$ticketid' ";
		$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs1 = mysql_fetch_assoc($result1);
		return $rs1[sumpoint];
	}else{
		return GetSubtractPointTicketid($staffid,$ticketid);
	}
}// end function ShowPointSubtract(){
	
?>