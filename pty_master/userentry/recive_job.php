<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
$s_db = STR_PREFIX_DB;
include("function_assign.php");
$dbnameuse = $db_name;
###################  คำนวณเงินจาก subcontab
function CalMoneySubV1($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix,$subfix_befor,$arr_f_tbl3;
$datereq1 = "2009-12-14";
$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
	
}

$round = "am";
$TNUM = 0 ;
 $j =1 ;
$j=1;
$sumkeyuser = array() ;
$numkey= array() ;
$TPOINT = array();
$str = "SELECT 
monitor_keyin.idcard,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
date(monitor_keyin.timeupdate) as val
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND 
keystaff.staffid='$staff_id'
AND date(timeupdate) >= '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];

	$list_field = "";
		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			
			$str_listfield = "SHOW COLUMNS FROM $t[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield = mysql_db_query($dbsite,$str_listfield);
			$xi = 0;
			$list_field = "";
			while($rs_l = mysql_fetch_assoc($result_listfield)){
				if($rs_l[Field] != "staffid"){
					if($list_field > "") $list_field .= ","; 
					$list_field .= " $rs_l[Field] ";
					$xarr_field[] = $rs_l[Field];
					$xi++;
				}//end if($rs_l[Field] != "staffid"){
			}//end while($rs_l = mysql_fetch_assoc($result_listfield)){
			
			
			##  log หลังทำการบันทึก
			$sql_after = "SELECT $list_field  FROM $t[0]".$subfix." WHERE id='$rss[idcard]' AND date($rs_ff[Field]) >= '$ndate'  GROUP BY $c";
			//echo "$dbsite  :: ".$sql_after."<br>";
			$result_after = mysql_db_query($dbsite,$sql_after);
			while($rs_after = mysql_fetch_assoc($result_after)){
			$sql_befor = "SELECT ".$list_field."  FROM  $t[0]".$subfix_befor." WHERE id='$rss[idcard]' and runid='$rs_after[runid]' ORDER BY runid ASC ";	
			$result_befor = mysql_db_query($dbsite,$sql_befor);
			$rs_befor = mysql_fetch_assoc($result_befor);
			$numr1 = @mysql_num_rows($result_befor);
			if($numr1 > 0){ // กรณีมีข้อมูลก่อนการบันทึก
				$result1 = array_diff_assoc($rs_befor, $rs_after);
				$numpoint  = count($result1);
				if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
					$tb1 = $t[0]."$subfix";
					$numval[$tb1] +=   $numpoint*$price_point[$tb1];
				}//end if($numpoint > 0){
			}else{
				$tb1 = $t[0]."$subfix";
					$numval[$tb1] += 1*$k_point[$tb1];
			}//end if($numr1 > 0){
		}// end while($rs_after = mysql_fetch_assoc($result_after)){
	} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){	
	
##################  คำนวณจาก ตารางที่มีรหัสเป็น gen_id ##################################################
	
		$list_field3 = "";
		foreach($arr_f_tbl3 AS $key3 => $val3){
			$t3 = explode("#",$val3);
			$c3 = cond_str($t3[1]);
			//echo $t3[0]."<br>";
			
			$sql_ff3 = " SHOW  COLUMNS FROM  $t3[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			$result_ff3 = @mysql_db_query($dbsite,$sql_ff3) ;
			$rs_ff3 = @mysql_fetch_assoc($result_ff3);
			
			$str_listfield3 = "SHOW COLUMNS FROM $t3[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield3 = mysql_db_query($dbsite,$str_listfield3);
			$xi3 = 0;
			$list_field3 = "";
			while($rs_l3 = mysql_fetch_assoc($result_listfield3)){
				if($rs_l3[Field] != "staffid"){
					if($list_field3 > "") $list_field3 .= ","; 
					$list_field3 .= " $rs_l3[Field] ";
					$xarr_field3[] = $rs_l3[Field];
					$xi3++;
				}//end if($rs_l3[Field] != "staffid"){
			}//end while($rs_l3 = mysql_fetch_assoc($result_listfield3)){
			
			
			##  log หลังทำการบันทึก
			$sql_after3 = "SELECT $list_field3  FROM $t3[0]".$subfix." WHERE gen_id='$rss[idcard]' AND date($rs_ff3[Field]) >= '$ndate'  GROUP BY $c3";
			//echo "$dbsite  :::  $sql_after3<br>";
			$result_after3 = mysql_db_query($dbsite,$sql_after3);
			while($rs_after3 = mysql_fetch_assoc($result_after3)){
			//echo "<pre>";
			//print_r($rs_after3);
			$sql_befor3 = "SELECT ".$list_field3."  FROM  $t3[0]".$subfix_befor." WHERE gen_id='$rss[idcard]' and runid='$rs_after3[runid]' ORDER BY runid ASC ";	
			$result_befor3 = mysql_db_query($dbsite,$sql_befor3);
			$rs_befor3 = mysql_fetch_assoc($result_befor3);
			$numr13 = @mysql_num_rows($result_befor3);
			if($numr13 > 0){ // กรณีมีข้อมูลก่อนการบันทึก
				$result13 = array_diff_assoc($rs_befor3, $rs_after3);
				$numpoint3  = count($result13);
				if($numpoint3 > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
					$tb13 = $t3[0]."$subfix";
					$numval3[$tb13] +=   $numpoint3*$price_point[$tb13];
				}//end if($numpoint3 > 0){
			}else{
				$tb13 = $t3[0]."$subfix";
					$numval3[$tb13] += 1*$k_point[$tb1];
			}//end if($numr1 > 0){
		}// end while($rs_after = mysql_fetch_assoc($result_after)){
	} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){	

###############################   end 	
	
	
}//end while($rss  = mysql_fetch_assoc($results)){

	return  (array_sum($numval))+(array_sum($numval3));
}//end function ###################### end คำนวณเงินให้กับ sub

function CalMoneySub($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix;


$datereq1 = "2009-12-14";
$str_std = " SELECT k_point ,tablename  FROM  table_price ";
//echo " db ::".$dbnameuse." sql ".$str_std;
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
}

$round = "am";

$TNUM = 0 ;
	  $j =1 ;
$sql_view = "SELECT siteid FROM view_general WHERE CZ_ID='$get_idcard'";
$result_view = mysql_db_query($dbnamemaster,$sql_view);
$rsv = mysql_fetch_assoc($result_view);
$db_site = STR_PREFIX_DB.$rsv[siteid];


$sql1 = "SELECT date(updatetime) as update_date, username as idcard  FROM `log_update` where  staff_login='$staff_id' 
and date(updatetime) >= '$datereq1' group by date(updatetime)";
//echo "$db_site ::: $sql1<br>";
$result1 = mysql_db_query($db_site,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){

$dayrecord[] =   $rs1[update_date] ;

}
//echo "<pre>";
//print_r($dayrecord);
$dayrecord = array_unique($dayrecord);
rsort($dayrecord);
reset($dayrecord);

//echo "<pre>"; print_r($dayrecord);echo"</pre>";
//die;

$j=1;

//foreach($dayrecord AS $key=>$val){
//if($val != "0000-00-00"){
$sumkeyuser = array() ;
$numkey= array() ;
$TPOINT = array();
$str = "SELECT 
 monitor_keyin.idcard,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
date(monitor_keyin.timeupdate) as val
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND 
keystaff.staffid='$staff_id'
AND date(timeupdate) > '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];


		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
						
		$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rss[idcard]' AND date($rs_ff[Field]) >= '$ndate' GROUP BY  $c " ;
			//echo $sql_c."<br>";
				$result_c = @mysql_db_query($dbsite,$sql_c) ;
				$rs_c = @mysql_fetch_assoc($result_c);
				$rs_c[num] = @mysql_num_rows($result_c);
			//echo "$rss[staffid]  $t[0]".$subfix." $rs_c[num]<br>";
			
			
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$sumkeyuser[$rss[staffid]] +=  $rs_c[num] ;
				$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
				$tb1 = $t[0]."$subfix";
				$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
				$num_val  = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
			}//end if($rs_c[num]>0){
		} //end 		foreach($arr_f_tbl1 AS $key1 => $val1){
		
}//end while($rss  = mysql_fetch_assoc($results)){

//} // end if($val != "0000-00-00"){

//} // end foreach($dayrecord AS $key=>$val){
return $TPOINT;
}//end function 
//$type_cmss = "province"; // กำหนดกรณีเป็นระบบของ จังหวัด
###################   function คำนวณเงินให้ sub

function CalMoneySubV2($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix,$subfix_befor,$arr_f_tbl3;
$datereq1 = "2009-12-14";

$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
	
}//end while($rs_std = mysql_fetch_assoc($result_std)){

$numval = array() ;

$str = "SELECT 
monitor_keyin.idcard,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
date(monitor_keyin.timeupdate) as val
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND 
keystaff.staffid='$staff_id'
AND date(timeupdate) >= '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query("edubkk_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];


				
			##  log หลังทำการบันทึก

				$tb1 = "salary"."$subfix";
				$sql_logupdate = "SELECT count(username) as num_salary FROM log_update WHERE subject LIKE '%ข้อมูลเงินเดือน%' AND username='$rss[idcard]' AND updatetime >= '$ndate' AND (action='edit1' or action='')  and staff_login='$staff_id'";
				//echo $sql_logupdate;
				$result_logupdate = mysql_db_query($dbsite,$sql_logupdate);
				$rs_log = mysql_fetch_assoc($result_logupdate);
				$num_add = $rs_log[num_salary];
					if($num_add > 0){
							$numval[$tb1] += $num_add*$k_point[$tb1];
							//echo "$numval[$tb1] += $num_add*$k_point[$tb1]"."$tb1 :: ".$k_point[$tb1]."<br>";
					}
					
				###  นับจำนวนบรรทัดเงินเดือนทั้งหมด
				$sql_nums = "SELECT COUNT(id) AS nums FROM salary WHERE id='$rss[idcard]'";
				$result_s = mysql_db_query($dbsite,$sql_nums);
				$rs_s = mysql_fetch_assoc($result_s);
				$nums = $rs_s[nums];
				$limit1 = $nums-$num_add;
				
				###  คำนวณข้อมูลเงินเดือนที่เกิดจากการแก้ไข
				$sql_s1 = "SELECT * FROM salary WHERE id='$rss[idcard]' ORDER BY runno DESC LIMIT 1,$limit1";
				$result_s1 = mysql_db_query($dbsite,$sql_s1);
				while($rss1 = mysql_fetch_assoc($result_s1)){
					if($rss1[lv] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[order_type] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[schoolid] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[school_label] != ""){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}//end if($rss1[school_label] != ""){
					
				}//end while($rss1 = mysql_fetch_assoc($result_s1)){
				
		
		############ ส่วนของการลา
		$tb2 = "hr_absent"."$subfix";
				$sql_logupdate1 = "SELECT count(username) as num_absent FROM log_update WHERE subject LIKE '%ข้อมูลจำนวนวันลาหยุด%' AND username='$rss[idcard]' AND updatetime >= '$ndate' AND (action='add' or action='')  and staff_login='$staff_id'";
				//echo $sql_logupdate1."<br>";
				$result_logupdate1 = mysql_db_query($dbsite,$sql_logupdate1);
				$rs_log1 = mysql_fetch_assoc($result_logupdate1);
				$num_add1 = $rs_log1[num_absent];
					if($num_add1 > 0){
							$numval[$tb2] += $num_add1*$k_point[$tb2];
					}//end 	if($rs_log1[num_salary] > 0){
					



###############################   end 	
}//end while($rss  = mysql_fetch_assoc($results)){
	
////echo "<pre>";
////print_r($numval);
$xval1 = (array_sum($numval));
//echo "val == ".$xval1;
return $xval1;
}//end function 










//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "มอบหมายการบันทึกข้อมูล ก.พ.7 ให้กับผู้ใช้";
$arr_approve = array('0'=>'อยู่ระหว่างดำเนินการ','3'=>'รอ QC','1'=>'ส่งแก้ไข','2'=>'ผ่าน');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	
		$amount_pay_net = str_replace(",","",$amount_pay_net);
		
		$sql_budget = "SELECT status_pay  FROM tbl_assign_sub WHERE  ticketid='$ticketid'";
		$result_budget = mysql_db_query($db_name,$sql_budget);
		$rs_b1 = mysql_fetch_assoc($result_budget);
			if($rs_b1[status_pay] != "YES"){ // กรณีรับรองการจ่ายข้อมูลแล้วไม่ให้แก้ไขสถานะการจ่ายเงิน
					$update_status_pay = " ,status_pay='$status_pay' ";
			}else{
					$update_status_pay = "";
			}
		
		$sql_up = "UPDATE tbl_assign_sub SET sent_date_true='".sw_date_indb($sent_date_true)."', approve='1' ,amount_pay_net='$amount_pay_net', staff_approve='".$_SESSION[session_staffid]."', comment_approve='$comment_approve' $update_status_pay   WHERE ticketid='$ticketid'";

		@mysql_db_query($db_name,$sql_up);
		
	## บันทึกรายการย่อย
			foreach($chv as $k => $v){
				
				$sql_up1 = "UPDATE tbl_assign_key SET approve='$approve[$k]', pay_net = '$xpay_net[$k]',staff_apporve='".$_SESSION[session_staffid]."'  WHERE ticketid='$ticketid' AND idcard='$v'";
				@mysql_db_query($db_name,$sql_up1);
			}// end 
			
		
		
				echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); location.href='index_assign_key.php?xmode=2&xtype=$xtype';</script>";
		exit;

	
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
	###  ตรวจสอบว่าเป็น sub หรือไม่
	function CheckTypeUser1($get_staffid){
		global $db_name;
		$sql = "SELECT COUNT(staffid) AS  num_type  FROM keystaff WHERE sapphireoffice='2' AND staffid='$get_staffid'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		 return $rs[num_type];
	}//end 	function CheckTypeUser1($get_staffid){
	######  ตรวจสอบว่าเป็นข้อมูลของโครงการปีที่แล้ว
	function CheckOldKeyData($get_idcard){
		global $db_name;
		$sql1 = "SELECT COUNT(idcard) AS NUM1 FROM tbl_assign_key WHERE idcard='$get_idcard' AND nonactive='1'";
		$result1 = mysql_db_query($db_name,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		return $rs1[NUM1];
	}

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date_true.value == ""){
		alert("กรุณาระบุวันส่งคือเอกสาร");
		document.form1.sent_date_true.focus();
		return false;
	}
	}
	
	
	
	var checkflag = "false";
function check(field) {
	if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
			field[i].checked = true;
		}
		checkflag = "true";
		return "ไม่เลือกทั้งหมด"; 
	} else {
		for (i = 0; i < field.length; i++) {
			field[i].checked = false; 
		}
		checkflag = "false";
		return "เลือกทั้งหมด"; 
	}

}

function checkAll(field,x) {
	for (i = 0; i < field.length; i++) {
		field[i].checked = x;
	}
}


</script>
<style type="text/css">
<!--
.style5 {font-size: 16px; font-weight: bold; }
-->
</style>
</head>

<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td colspan="2" class="fillcolor"><!--<table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="13%"  bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode="><strong><U style="color:<?=$bgcolor?>;">จัดการข้อมูลผู้ใช้</U></strong></A></td>
              <td width="26%"  bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode=1"><strong><U style="color:<?=$bgcolor?>;"> ส่วนจ่ายงานให้กับผู้รับงาน</U></strong></A></td>
			   <td width="26%"  bgcolor="<? if($xmode == "2"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode=2"><strong><U style="color:<?=$bgcolor?>;"> ส่วนของการรอตรวจงาน</U></strong></A></td>

              <td width="61%">&nbsp;</td>
            </tr>
          </table>--></td></tr>
<tr><td width=39><img src="images/user_icon.gif"></td>
<td width="908" align="left"><B style="font-size: 12pt;"><? if($xmode == ""){ $txt_mode = "ส่วนผู้บันทึก";}else if($xmode == "1"){ $txt_mode = "ส่วนของการจ่ายงานให้กับผู้รับงาน";}else if($xmode == "2"){ $txt_mode = "ส่วนของการรอตรวจงาน";} echo "$txt_mode";?></B></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>
<BR></td>
</tr>
</table>
<form name="form1" method="post" action="" onSubmit="return checkFields();">
<input type="hidden" name="ticketid" value="<?=$ticketid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" align="left"><strong>ส่งงานบันทึกข้อมูลเอกสาร ก.พ. 7 </strong></td>
          <td width="40%" align="right"><label>
            <input type="submit" name="Submit" value="บันทึกรับเอกสารคืน">
&nbsp;          </label></td>
        </tr>
		<? 
		$sql = "SELECT * FROM tbl_assign_sub WHERE ticketid='$ticketid'";
		//echo $sql;
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		
		 $point_sub = ShowPointSubtract($rs[staffid],$ticketid);
		
		if($rs[sent_date_true] != "0000-00-00"){
			$sent_date_true = sw_date_intxtbox($rs[sent_date_true]);
		}else if($rs[sent_date] != "0000-00-00"){
			$sent_date_true = sw_date_intxtbox($rs[sent_date]);
		}else{
			$sent_date_true = date("d/m")."/".(date("Y")+543);
		}
		
		
//		
//		if($rs[amount_pay_net] > 0){
//			$amount_pay_net = $rs[amount_pay_net];
//		}else{
//			$amount_pay_net = $rs[amount_pay];
//		}
		?>
        <tr>
          <td width="16%" align="left"><strong>หมายเลขงาน :</strong></td>
          <td width="24%" align="left"><?=$ticketid?></td>
          <td width="20%" align="left"><strong>วันที่รับเอกสาร : </strong></td>
          <td align="left"><?=show_date($rs[recive_date]);?></td>
        </tr>
        <tr>
          <td align="left"><strong>ชื่อ- นามสกุล : </strong></td>
          <td align="left"><?=show_user($rs[staffid]);?></td>
          <td align="left"><strong>วันที่คาดว่าจะดำเนินการแล้วเสร็จ : </strong></td>
          <td align="left"><?=show_date($rs[sent_date]);?></td>
        </tr>
        <tr>
          <td align="left"><strong>หมายเลขโทรศัพท์ : </strong></td>
          <td align="left">
		  <?
		  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
		  $result_user = mysql_db_query($db_name,$sql_user);
		  $rs_u = mysql_fetch_assoc($result_user);
		  echo "$rs_u[telno]";
		  
		  ?>		  </td>
          <td align="left"><strong>วันที่ส่งเอกสารคืน : </strong></td>
          <td align="left">
          <INPUT name="sent_date_true" onFocus="blur();" value="<?=$sent_date_true;?>" size="10" readOnly>
          <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sent_date_true, 'dd/mm/yyyy')"value="วันเดือนปี">
         </td>
        </tr>
        <tr>
          <td align="left"><strong>จำนวน (ชุด/แผ่น) : </strong></td>
          <td align="left"><?=count_assign_key($rs[ticketid]);?> ชุด / 
            <?=sum_count_page($ticketid);?>
แผ่น</td>
<?   if($_SESSION[session_sapphire] == "1"){ ?>
          <td align="left"><strong>ประมาณการค่าบันทึกข้อมูล : </strong></td>
          <td align="left"><strong> <? echo number_format($rs[amount_pay],2);?>&nbsp;บาท </strong></td>
<? } // end if($_SESSION[session_sapphire] == "1"){ ?>
        </tr>
        <tr>
          <td align="left"><strong>เจ้าหน้าที่บริษัทฯ : </strong></td>
          <td align="left"><?=show_user($rs[admin_id]);?></td>
		  <? if($_SESSION[session_sapphire] == "1"){ ?>
          <td align="left"><span class="style5">ค่าใช้จ่ายที่บันทึกได้ : </span></td>
          <td align="left">            <span class="style5">
            <? /* if(($rs[amount_pay_net] > 0) and (cal_budget_all_true($ticketid) != $rs[amount_pay_net] )){  $temp_amount_pay=cal_budget_all_true($ticketid);}else{ $temp_amount_pay = $rs[amount_pay_net];}else{*/
					
				
				
				
			if(CheckTypeUser1($rs[staffid]) > 0){  //กรณีเป็น sub ให้คำนวณตามจุดที่คีย์จริง
			$sqlcal = "SELECT tbl_assign_key.ticketid, tbl_assign_key.approve,tbl_assign_key.siteid,tbl_assign_key.idcard FROM tbl_assign_key  WHERE tbl_assign_key.ticketid='$ticketid' group by idcard";
			//echo $db_name." :: ".$sqlcal;
			$resultcal = mysql_db_query($db_name,$sqlcal);
				while($rscal = mysql_fetch_assoc($resultcal)){
						if(CheckOldKeyData($rscal[idcard]) > 0){
							$arrval = CalMoneySubV2("$rs[staffid]","$rscal[idcard]","$ticketid");
							$temp_amount_pay1 += $arrval;
							if($xin_id > "") $xin_id .= ",";
							$xin_id .= "'$rscal[idcard]'";
						}
				}//end while($rscal = mysql_fetch_assoc($resultcal)){
			}//end if(CheckTypeUser1($rs[staffid]) > 0){   CalMoneySubV2
			
			$temp_amount_pay = cal_budget_all_true($ticketid,$xin_id)+$temp_amount_pay1; 
			
			?>
		    <?=number_format($temp_amount_pay,2);?>
		    <input type="hidden" name="amount_pay_net" value="<?=number_format($temp_amount_pay,2)?>">
            บาท </span><? if($temp_amount_pay > 1000){?> ยังไม่หักภาษี <? }//end if($temp_amount_pay > 1000){?></td>
			<? } //end if($_SESSION[session_sapphire] == "1"){?>
        </tr>
        <tr>
          <td align="left"><strong>เบอร์โทรเจ้าหน้าที่บริษัทฯ : </strong></td>
          <td align="left"><?
		   $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[admin_id]'";
		  $result_admin = mysql_db_query($db_name,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);
		  if($rs_admin[telno] != ""){
		  echo "$rs_admin[telno]";
		  }else{ echo "-";}
		  ?></td>

          <td align="left"><span class="style5">คะแนนจุดผิด:</span></td>
          <td align="left"><strong><?=number_format($point_sub,2)?> จุด</strong></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left"><span class="style5">อัตราส่วนการ QC :</span></td>
          <td align="left"><strong><? if($rs_u[keyin_group] == "8"){  $pointr1 = ShowRatioDate($rs_u[keyin_group]);echo "1 ต่อ ". $pointr1;} ?></strong></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left"><span class="style5">ค่าคะแนนลบ : </span></td>
          <td align="left"><strong><? 
		  if($pointr1 < 1){ $pointr1 = 1;}
		  if($point_sub > 0){
			 
			  echo "ดังนั้นคะแนนลบเท่ากับ (คะแนนจุดผิด X อัตราส่วนการ QC) เท่ากับ  ";
			 echo number_format($point_sub*$pointr1,2)." คะแนน<br> คิดเป็น ";
			echo number_format(($point_sub*$pointr1)*0.5,2)." บาท";
		  }else{
			 echo "-"; 	
			 }
		  
		  ?></strong></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left"><span class="style5">ค่าใช้จ่ายสุทธิ : </span></td>
          <td align="left"><strong><? echo number_format($temp_amount_pay-((($point_sub*$pointr1))*0.5),2)?> บาท</strong></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
		  
		  <? if($_SESSION[session_sapphire] == "1"){ ?>
          <td align="left"><strong><? if($xtype == "2"){?>สถานะการจ่ายเงินจากฝ่ายบัญชี<? } ?></strong></td>
          <td align="left"><label>
		  <? 
		  	if($xtype == "2"){ // เปิดเฉพาะกรณีตรวจงานผ่านแล้วเท่านั้น
		  	if($_SESSION[session_staffid] == "72" OR $_SESSION[session_staffid] == "64"){ // เห็นเฉพาะ user ที่เป็น ฝ่ายบัญชีเท่านั้น
			?>
            <input name="status_pay" type="radio" value="YES" <? if($rs[status_pay] == "YES"){ echo "checked='checked'";}?>>
            จ่ายเงินแล้ว <? } ?>
            <input name="status_pay" type="radio" value="WAIT" <? if($rs[status_pay] == "WAIT"){ echo "checked='checked'";}?>>
            รอจ่ายเงิน
            <input name="status_pay" type="radio" value="NO" <? if($rs[status_pay] == "NO"){ echo "checked='checked'"; }?>>
          ยังไม่ได้จ่ายเงิน
		  <?
		  	} //end 	if($xtype == "2"){
		  ?>
		  </label></td>
		  <? } // end if($_SESSION[session_sapphire] == "1"){  ?>
        </tr>
        <tr>
          <td colspan="4" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="27%"><strong>หมายเหตุการรับรองข้อมูล : </strong></td>
              <td width="73%"><textarea name="comment_approve" cols="70" rows="3" id="comment_approve"><?=$rs[comment_approve]?>
              </textarea></td>
            </tr>
          </table>            <label></label></td>
          </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
                  <td width="10%" align="center" bgcolor="#A5B2CE"><strong>บัตรประชาชน</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ-นามสกุล</strong></td>
                  <td width="11%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
                  <td width="14%" align="center" bgcolor="#A5B2CE"><strong>โรงเรียน/หน่วยงาน</strong></td>
                  <td width="10%" align="center" bgcolor="#A5B2CE"><strong>เวลาเริ่มบันทึก</strong></td>
                  <td width="7%" align="center" bgcolor="#A5B2CE"><SPAN lang="TH"><strong>เวลาบันทึกล่าสุด</strong></SPAN></td>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>อายุราชการ</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE"><strong>จำนวน(แผ่น)</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
				  <?  if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ค่าใช้จ่ายจริง</strong></td>
				  <? } //end  if ($_SESSION[session_sapphire] == 1 ){?>
                  <td width="9%" align="center" bgcolor="#A5B2CE"> <!--<INPUT TYPE="checkbox" NAME="chk" ONCLICK="checkAll(this.form.list,this.checked)" > 
                    <strong>ส่งงานทั้งหมด</strong> --></td>
                </tr>
				<?
$cyy = (date("Y")+543);
$sql1 = "SELECT tbl_assign_key.ticketid, tbl_assign_key.approve,tbl_assign_key.siteid,tbl_assign_key.idcard FROM tbl_assign_key  WHERE tbl_assign_key.ticketid='$ticketid'";
$result1 = mysql_db_query($db_name,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){
$db_site = STR_PREFIX_DB."$rs1[siteid]";
		$sql_site = "SELECT id,siteid,prename_th,name_th,surname_th, position_now, schoolid, TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov   FROM  general WHERE id='$rs1[idcard]'";
		//echo $sql_site."$db_site<br>";
		$result_site = mysql_db_query($db_site,$sql_site);
		$rs_s = mysql_fetch_assoc($result_site);
		$xarr_prove[$rs1[idcard]] = $rs1[approve];
		$xarr_siteid[$rs1[idcard]] = $rs_s[siteid];
		$xarr_name[$rs1[idcard]] = $rs_s[prename_th]."".$rs_s[name_th]."".$rs_s[surname_th];
		$xarr_surname[$rs1[idcard]] = $rs_s[surname_th];
		$xarr_position[$rs1[idcard]] = $rs_s[position_now];
		$xarr_schoolid[$rs1[idcard]] = $rs_s[schoolid];
		$xarr_age[$rs1[idcard]] = $rs_s[age_gov];
}// end while($rs1 = mysql_fetch_assoc($result1)){

				
//				$result1 = mysql_db_query($db_name,$sql1);
//				$ch_num = @mysql_num_rows($result1);
				$k=0;
			//while($rs1 = mysql_fetch_assoc($result1)){
			$ch_num = count($xarr_prove);
			foreach($xarr_prove as $xkey => $xval){
			
				 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				 
				 ### ตรวจสอบข้อมูลเงินเดือน
				 $db_site = STR_PREFIX_DB."$xarr_siteid[$xkey]";
				 $sql_check_salary = "SELECT COUNT(id) AS num_salary FROM salary WHERE id='$xkey'";
				 $result_check_salary  = @mysql_db_query($db_site,$sql_check_salary);
				 $rs_ch_s = @mysql_fetch_assoc($result_check_salary);
				 $temp_age = floor($xarr_age[$xkey])*2;
				 
				 if($rs_ch_s[num_salary] < $temp_age ){
				 	$dis_app = "F";
				 }else{
				 	$dis_app = "";
				 }
				 
				 #########//  ตรวจสอบข้อมูลเบื้องต้นก่อนการรับรองข้อมูล
				 if(check_data_approve($xkey,$xarr_siteid[$xkey]) != "" and $xtype != "2"){
				 		$xstyle = " style='cursor:hand'";
						$dis_list = " disabled='disabled'";
						$bg = "#FF0000";
							if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "NAME ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจาก คำนำหน้าชื่อ, ชื่อ หรือนามสกุลเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "SCHOOL ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากหน่วยงานสถานศึกษาที่สังกัดเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "BIRTHDAY ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากวันเดือนปีเกิดเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "BEGINDATE ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากวันเริ่มปฏิบัติราชการเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "SEX ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากเพศเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "POSITION ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากตำแหน่งปัจจุบันเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "SALARY ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากเงินเดือนเป็นค่าว่าง' ";
							}else if(check_data_approve($xkey,$xarr_siteid[$xkey]) == "NOPOSITION ERROR"){
								$xtitle = " title='ไม่สามารถรับรองข้อมูลได้เนื่องจากเลขที่ตำแหน่งเป็นค่าว่าง'";
							}
							
				 }else{
				 		$bg = $bg;
				 		$xstyle = "";
						$dis_list = "";
						$xtitle = "";
				 }
				 $dis_list = "";
				 

				   $sql_monitor = "SELECT * FROM monitor_keyin WHERE idcard='$xkey' and staffid='$rs[staffid]' ORDER BY timeupdate ASC LIMIT 0,1";
				  $result_monitor = mysql_db_query($db_name,$sql_monitor);
				  $rs_monitor = mysql_fetch_assoc($result_monitor);
				  
				  $kp7file1 = "../../../edubkk_kp7file/$xarr_siteid[$xkey]/$xkey".".pdf";
				  
				  $pdf = "<a href=\"../hr3/hr_report/kp7_search.php?id=".$xkey."&sentsecid=".$xarr_siteid[$xkey]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" title='ก.พ.7 สร้างโดยระบบ'></a>";
				  
				  if(is_file($kp7file1)){
					 	$imgpdf = "<a href='$kp7file1' target=\"_blank\" title=\"แสดงไฟล์ ก.พ. 7 ต้นฉบับ\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"แสดงเอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";
					}else{
						$imgpdf = "";	
					}
				 
				 
				?>
                <tr bgcolor="<?=$bg?>" <?=$xtitle?> <?=$xstyle?>>
                  <td align="center"><?=$k?></td>
                  <td align="center"><?=$xkey?></td>
                  <td align="left"><? echo "$xarr_name[$xkey]";?></td>
                  <td align="left"><? echo "$xarr_position[$xkey]";?></td>
                  <td align="left"><?=show_org($xarr_schoolid[$xkey])."/".show_area($xarr_siteid[$xkey]);?></td>
                  <td align="center">
				  <?
				
				  	$arr_exd = explode(" ",$rs_monitor[timeupdate]);
					$arr_d1 = explode("-",$arr_exd[0]);
					if($arr_d1[0] > 2000){// มีวันที่ที่เข้าไปบันทึกข้อมูลแล้ว
						//echo "$arr_d1[2]-$arr_d1[1]-".($arr_d1[0]+543)." เวลา ".$arr_exd[1];
						echo DBThaiLongDate($arr_exd[0])." เวลา ".$arr_exd[1];
					}else{
						echo "";
					}
				  ?>				  
				  </td>
                  <td align="center"><?
				  	$arr_exd = explode(" ",$rs_monitor[timeupdate_user]);
					$arr_d1 = explode("-",$arr_exd[0]);
					if($arr_d1[0] > 2000){// มีวันที่ที่เข้าไปบันทึกข้อมูลแล้ว
						//echo "$arr_d1[2]-$arr_d1[1]-".($arr_d1[0]+543)." เวลา ".$arr_exd[1];//timeupdate
						echo DBThaiLongDate($arr_exd[0])." เวลา ".$arr_exd[1];
					}else{
						echo "";
					}
				  
				  ?></td>
                  <td align="center"><?=floor($xarr_age[$xkey])?></td>
                  <td align="center"><? $page_result = count_page($xkey,$xarr_siteid[$xkey]);  if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  echo $page_result;?></td>
                  <td align="center"><?=$imgpdf?>&nbsp;<?=$pdf?></td>
				  <?  if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <td align="center"> 
                    <? // if(check_record_salary($rs1[CZ_ID],$rs1[siteid]) > 0){ echo "<img src=\"images/project_status3.gif\" alt=\"สถานะการบันทึกข้อมูลไม่สมบูรณ์\" width=\"8\" height=\"8\" border=\"0\">&nbsp;";}?>
					<?  //if(CheckTypeUser1($rs[staffid]) > 0 and CheckOldKeyData($xkey) > 0){
					if(CheckTypeUser1($rs[staffid]) > 0 and CheckOldKeyData($xkey) > 0){
						$arrval = CalMoneySubV2("$rs[staffid]","$xkey","$ticketid");
						$money_cal_budget_true = $arrval;
					}else{
						$money_cal_budget_true =  cal_budget_1_true($xkey,$xarr_siteid[$xkey]);
					}
					
					echo number_format($money_cal_budget_true);
					?>
					<? if($dis_list == ""){?>
					<input type="hidden" name="xpay_net[]" value="<?=$money_cal_budget_true;?>">					</td>
					<? 
						}// end if($dis_list == ""){
					} //end  if ($_SESSION[session_sapphire] == 1 ){?>
                  <td align="center"><label>
				  <select name="approve[]" id="approve" <?=$dis_list?>>
				   <? 
				  foreach($arr_approve as $k2 => $v2){
					  	//if($dis_app == "F" and $k2 == "2"){ // ตรวจสอบกรณีการ QC เป็นผ่านเพื่อป้องกันความผิดพลาด
						
						//}else{
						if($xval == $k2){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$k2' $sel>$v2</option>";
						//}
					
				  } //end  foreach($arr_approve as $k2 => $v2){
				  ?>
				    </select>
                   <!-- <input type="checkbox" name="chv[<?=$xkey?>]" id="list" value="1" <? if($xval == "1"){ echo " checked='checked'";}?>>-->
				   	<? if($dis_list == ""){?>
				<input type="hidden" name="chv[]" value="<?=$xkey?>">
				<? } //end if($dis_list == ""){ ?>
                  </label></td>
                </tr>
				<?
						//$temp_net1 = cal_budget_1_true($rs1[CZ_ID],$rs1[siteid]);
						$temp_net1 = str_replace(",","",$money_cal_budget_true);
						$bud_net += $temp_net1; // ค่าใช้จ่ายรวม
					}// end while
				?>
				<? if($_SESSION[session_sapphire] == "1"){ 
					$pay_money = $bud_net-(($point_sub*$pointr1)*0.5);
				
				 ?>
                <tr>
                  <td colspan="10" align="right" bgcolor="#FFFFFF"><strong><span class="style5">ค่าใช้จ่ายสุทธิ</span> = <span class="style5">ค่าใช้จ่ายที่บันทึกได้</span> - <span class="style5">ค่าคะแนนลบ</span>:</strong></td>
                  <td align="right" bgcolor="#FFFFFF"><strong>
                    <?=number_format($bud_net-(($point_sub*$pointr1)*0.5),2);?>
                  </strong></td>
                  <td align="center" bgcolor="#FFFFFF"><strong>บาท</strong></td>
                </tr>
				<? if($pay_money > 1000){?>
                <tr>
                  <td colspan="10" align="right" bgcolor="#FFFFFF"><strong>หักภาษี 3 % : </strong></td>
                  <td align="right" bgcolor="#FFFFFF"><strong>
                    <? $temp_v = (($pay_money*3)/100); echo number_format($temp_v,2)?>
                  </strong></td>
                  <td align="center" bgcolor="#FFFFFF"><strong>บาท</strong></td>
                </tr>
                <tr>
                  <td colspan="10" align="right" bgcolor="#FFFFFF"><strong><span class="style5">ค่าใช้จ่ายสุทธิ</span>:</strong></td>
                  <td align="right" bgcolor="#FFFFFF"><strong><? echo @number_format($pay_money-$temp_v,2)?></strong></td>
                  <td align="center" bgcolor="#FFFFFF"><strong>บาท</strong></td>
                </tr>
				
				<? 
					} //end if($temp_v > 1000){
				} //end if($_SESSION[session_sapphire] == "1"){ ?>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="4" align="center"><input type="hidden" name="ch_num" value="<?=$ch_num?>"><input type="hidden" name="xtype" value="<?=$xtype?>"></td>
        </tr>
        <tr>
          <td colspan="4" align="center"> <strong>* หมายเหตุ </strong><i>ถ้าไม่สามารถ QC เป็นผ่านได้ ้ต้องไปตรวจสอบข้อมูลในระบบก่อนเนื่องจากระบบจะคำนวณค่า ตำแหน่งและอัตราเงินเดือน<br>
            เท่ากับอายุราชการคูณสอง เช่น อายุราชการ 30 ปี จำนวนแถวในตำแหน่งและอัตราเงินเดือนต้อง ไม่น้อยกว่า 60 <br>
            ทั้งนี้
            เพื่อป้องกันความผิดพลาดของการตรวจสอบ </i></td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>

</BODY>
</HTML>
