<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;

			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			if(!isset($session_staffid)){
				echo "<script type=\"text/javascript\">
				alert('กรุณาล็อกอินเข้าสู่ระบบ');
				window.location=\"login.php\";
				</script>";
			}
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			
			
			if($yy == ""){
					$yy = date("Y")+543;
			}
			if($mm == ""){
					$sql_month = "SELECT month(datekeyin)  as month1  FROM `stat_user_keyin` group by datekeyin order by datekeyin desc limit 0,1";
					$result_month = mysql_db_query($dbnameuse,$sql_month);
					$rs_month = mysql_fetch_assoc($result_month);
					$mm = sprintf("%02d",$rs_month[month1]);
			}

//echo "$yy :: $mm";

			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				if($x[0] > 0){
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				}else{
				$xrs = "";	
				}
				
				return $xrs;
			}

function thaidate1($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0]));
				if($x[0] > 0){
					$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				}else{
					$xrs = "";	
				}
				return $xrs;
			}

function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){
	

### แสดงชื่อพนักงาน QC
function GetStaffQc($get_staff){
		global $dbnameuse;
		$sql = "SELECT * FROM keystaff WHERE staffid='$get_staff'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function GetStaffQc(){

##############  function ค้นหาตำแหน่งที่เป็นผู้บริหารในเขต
function find_positiongroup($groupid){
		if($groupid == "1"){ // สายงานบริหารการศึกษา
			$sql_con = " ( ".find_groupstaff(1)." or".find_groupstaff(2)." ) ";
		}else if($groupid == "2"){ // สายงานนิเทศการศึกษา
			$sql_con = find_groupstaff(3);
		}else if($groupid == "3"){ // สายงานบริหารสถานศึกษา
			$sql_con = " ( ".find_groupstaff(4)." or ".find_groupstaff(5)." ) ";
		}else if($groupid == "4"){ // สายงานการสอน
			$sql_con = " ( ".find_groupstaff(6)." or ".find_groupstaff(8)." ) ";
		}else if($groupid == "5"){ // บุคลากรทางการศึกษา 38 ค.(2)
				$sql_con = " ( ".find_groupstaff(7)." ) ";
		}
	return $sql_con;
}

##############  end function เรียกแสดงกลุ่มตำแหน่ง by suwat

#function takes_array($input)
function  find_groupstaff($typegroup) { 
	
	###################### Way to use
	###################### $sqlext = find_groupstaff(1) ; 
	#1.	 ผอ.เขต #2.	 รอง ผอ.เขต 	#3.	 ศึกษานิเทศน์ #4.	 ผอ.โรงเรียน #5.	 รองผอ.โรงเรียน #6.	 ครู # else:: ไม่มี 
switch ($typegroup) {  
case 0:  ########################## ทุกคน 
	$sqlext = "  1  "; 
    break;
case 1:  ##########################ผอ.เขต 
	$sqlext = " (
	( `position_now` LIKE '%ผู้อำนวยการ%'   OR  `position_now` LIKE '%ผอ%'  )
	AND (`position_now`   LIKE '%สพท%'  or `position_now`   LIKE '%สำนักงานเขตพื้นที่การศึกษา%' ) 
	AND (`position_now` NOT LIKE '%โรงเรียน%'  AND `position_now` NOT LIKE '%สถานศึกษา%' ) 
	AND (`position_now` NOT LIKE '%รอง%'  AND `position_now` NOT LIKE '%ผู้ช่วย%' ) 
	) "; 
    break;
case 2:  ##########################รอง ผอ.เขต 
	$sqlext = " ((
	( `position_now` LIKE '%ผู้อำนวยการ%'   OR  `position_now` LIKE '%ผอ%'  )
	AND (`position_now`   LIKE '%สพท%'  or `position_now`   LIKE '%สำนักงานเขตพื้นที่การศึกษา%' ) 
	AND (`position_now` NOT LIKE '%โรงเรียน%'  AND `position_now` NOT LIKE '%สถานศึกษา%' ) 
	AND ( `position_now`  LIKE '%รอง%'  OR `position_now`   LIKE '%ผู้ช่วย%' ) 
	) OR (`position_now` LIKE '%เจ้าหน้าที่บริหารการศึกษา%'  OR position_now LIKE '%จนท%บริหารการศึกษา%' ) 
	)
	"; 
    break;
case 3:  ##########################ศึกษานิเทศน์ 
	$sqlext = " (
	`position_now` LIKE '%ศึกษานิ%'   OR `position_now` LIKE '%ศน%'  
	AND (`position_now` NOT LIKE '%โรงเรียน%'  AND `position_now` NOT LIKE '%สถานศึกษา%' ) 
	) "; 
    break;
case 4:  ##########################ผอ.โรงเรียน 
	$sqlext = " (
	( `position_now` LIKE '%ผู้อำนวยการ%'   OR `position_now` LIKE '%ครูใหญ่%' OR `position_now` LIKE '%อาจารย์ใหญ่%') 
	AND (`position_now` NOT LIKE '%สพท%'  AND `position_now`  NOT LIKE '%สำนักงานเขตพื้นที่การศึกษา%' ) 
	AND (`position_now` NOT LIKE '%รอง%'  AND `position_now` NOT LIKE '%ผู้ช่วย%' ) 
	) "; 
#AND (`position_now` LIKE '%โรงเรียน%'  OR `position_now` LIKE '%สถานศึกษา%' OR `position_now`   LIKE 'ผู้อำนวยการ' ) 
    break;
case 5:  ##########################รองผอ.โรงเรียน 
	$sqlext = " 
	(
	( `position_now` LIKE '%ผู้อำนวยการ%'   OR `position_now` LIKE '%ครูใหญ่%' OR `position_now` LIKE '%อาจารย์ใหญ่%' ) 
	AND (`position_now` NOT LIKE '%สพท%'  AND `position_now`  NOT LIKE '%สำนักงานเขตพื้นที่การศึกษา%' ) 
	AND (`position_now` LIKE '%รอง%'  OR `position_now`   LIKE '%ผู้ช่วย%' ) 
	) "; 
#	AND (`position_now` LIKE '%โรงเรียน%'  OR `position_now` LIKE '%สถานศึกษา%' OR `position_now`   LIKE 'รองผู้อำนวยการ'  ) 
    break;
case 6:  ##########################ครู // เอา  OR `position_now` = '' ออกเนื่องจากเอาไปไว้ในกลุ่มที่ไม่ระบุ
	$sqlext = " (
	( `position_now` LIKE '%ครู%'   OR `position_now` LIKE '%อาจารย์%' )  
	AND `position_now` NOT LIKE '%ครูใหญ่%'
	AND   position_now   NOT LIKE  '%อาจารย์ใหญ่%' 
	AND position_now NOT LIKE '%ครูผู้ช่วย%'
	) "; 
    break;
case 7:  ##########################เจ้าหน้าที่เขต
	$sqlext = " 
	(
(position_now not LIKE  '%ผู้อำนวยการ%' and position_now not LIKE  '%ผอ%' )
 AND ( position_now not  LIKE  '%ครู%'    )
 AND ( position_now not  LIKE  '%อาจารย์%' )
 AND ( position_now not  LIKE  '%ศึกษานิ%' ) 
 AND ( position_now not  LIKE  '%ศน%' ) 
 AND ( position_now not  LIKE  ''    ) 
 AND ( position_now NOT LIKE '%เจ้าหน้าที่บริหารการศึกษา%' )
 AND (position_now NOT LIKE '%จนท%บริหารการศึกษา%' )

	) "; //  AND (noposition  LIKE 'อ%' )
    break;
case 8:  ##########################ครูผู้ช่วย
	$sqlext = " 
	( `position_now` LIKE '%ครูผู้ช่วย%'   ) 
	"; 
    break;
case 9: ## ในกรณี ตำแหน่ง  position_now เป็นค่าว่าง  ### ไม่ระบุ
	$sqlext = "
	( `position_now` = '') 
	";
	break;
	//echo $sqlext;
	case 10: ### ตำแหน่งเจ้าหน้าที่บุคลาการการศึกษาอื่นๆ
		$sqlext = " 
	(
(position_now not LIKE  '%ผู้อำนวยการ%' and position_now not LIKE  '%ผอ%' )
 AND ( position_now not  LIKE  '%ครู%'    )
 AND ( position_now not  LIKE  '%อาจารย์%' )
 AND ( position_now not  LIKE  '%ศึกษานิ%' ) 
 AND ( position_now not  LIKE  '%ศน%' ) 
 AND ( position_now not  LIKE  ''    ) 
 AND ( position_now NOT LIKE '%เจ้าหน้าที่บริหารการศึกษา%' )
 AND (position_now NOT LIKE '%จนท%บริหารการศึกษา%' )

	) ";  //  AND (noposition  NOT LIKE 'อ%' )
	break;
default:
     $sqlext = "  0  " ; 
} ################################# END switch ($typegroup) {   
#	echo "$typegroup ||||||||| $sqlext   <hr>";
	return  $sqlext  ; 
}####### END fucntion find_groupstaff($typegroup) { 


###########  function บันทึกข้อมูลของผู้บริหาร
function SaveTempData(){
	global $dbnameuse,$db_temp;
	$conw = " where ".find_positiongroup(1);;
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.birthday,
tbl_checklist_kp7.position_now
FROM `tbl_checklist_kp7`
$conw
";
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$sql_save = "REPLACE INTO temp_report_executive SET idcard='$rs[idcard]',siteid='$rs[siteid]', prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',position_now='$rs[position_now]'";
			mysql_db_query($dbnameuse,$sql_save);
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function SaveTempData(){

##########  function ตรวจสอบว่ามีการบันทึกข้อมูลแล้วหรือยัง
function SetStatusKey($get_idcard){
		global $dbnameuse;
		$sql = "SELECT
tbl_assign_key.idcard,
tbl_assign_key.siteid,
monitor_keyin.staffid
FROM
tbl_assign_key
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' AND
tbl_assign_key.idcard = '$get_idcard'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
			$sql_update = "UPDATE temp_report_executive SET status_key='1',staff_key='$rs[staffid]' WHERE idcard='$rs[idcard]'";
			@mysql_db_query($dbnameuse,$sql_update);
	}
}//end 

function SetStatusQc($get_idcard){
	global $dbnameuse;
	$sql = "SELECT
validate_checkdata.idcard,
validate_checkdata.qc_staffid,
validate_checkdata.qc_date
FROM `validate_checkdata`
where idcard='$get_idcard'
group by validate_checkdata.idcard";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
			$sql_update = "UPDATE temp_report_executive SET staff_qc='$rs[qc_staffid]', date_qc='$rs[qc_date]' WHERE idcard='$rs[idcard]'";
			@mysql_db_query($dbnameuse,$sql_update);
	}
}
####### ฟังก์ชั่นกำหนดสถานะข้อมูลของผู้บริหาร
function SetStatusDataExecutive(){
	global $dbnameuse;
	$sql = "SELECT * FROM temp_report_executive";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			SetStatusKey($rs[idcard]); // กำหนดสถานะว่าคีย์ข้อมูลแล้วหรือยัง
			SetStatusQc($rs[idcard]); // กำหนดสถานะว่ามีการคีย์ข้อมูลแ้ล้วหรือยัง
	}//end 	while($rs = mysql_fetch_assoc($result)){ 	
}//end function SetStatusDataExecutive(){

if($Process == "1"){
		SaveTempData();// บันทึกข้อมูล
		SetStatusDataExecutive();// กำหนดสถานะข้อมูล
	echo "<script>location.href='?Process=';</script>";
}


function ShowExsumEx(){
	global $dbnameuse,$xtype;
	
	
	 if($xtype == "1"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='1'";
			
				 }else if($xtype == "0"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='0'"; 
		
				}else if($xtype == "QC"){
					$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.staff_qc <> '' AND ".DB_USERENTRY.".temp_report_executive.staff_qc IS NOT NULL";  	

					}else if($xtype == "NQC"){
					$conw1 = "AND (edubkk_userentry.temp_report_executive.staff_qc = '' or ".DB_USERENTRY.".temp_report_executive.staff_qc IS NULL)";
				
				}
			   else{
				   $conw1 = "";
			
				 }
	$constaff1 = find_groupstaff(1);// ผู้อำนวยการ
	$constaff2 = find_groupstaff(2);// รองผู้อำนวยการ
		$sql = "SELECT 
count(idcard) as numall,
sum(if($constaff1,1,0)) as   H1,
sum(if($constaff2,1,0)) as   H2,
sum(if($constaff1 and staff_qc >0,1,0)) as   H1QC,
sum(if($constaff2 and staff_qc >0,1,0)) as   H2QC,
sum(if($constaff1 and status_key>0,1,0)) as   H1KEY,
sum(if($constaff2 and status_key>0,1,0)) as   H2KEY


FROM `temp_report_executive` WHERE idcard <> '' $conw1
";
$result = mysql_db_query($dbnameuse,$sql);
$rs = mysql_fetch_assoc($result);
	$H3 = $rs[numall]-($rs[H1]+$rs[H2]);
	if($H3 > 0){
	$H3QC = $rs[numall]-($rs[H1QC]+$rs[H2QC]);
	}
	if($H3 > 0){
	$H3KEY = $rs[numall]-($rs[H1KEY]+$rs[H2KEY]);
	}
	$arr['H1'] = $rs[H1];
	$arr['H2'] = $rs[H2];
	$arr['H3'] = $H3;
	$arr['H1QC'] = $rs[H1QC];
	$arr['H2QC'] = $rs[H2QC];
	$arr['H3QC'] = $H3QC;
	$arr['H1KEY'] = $rs[H1KEY];
	$arr['H2KEY'] = $rs[H2KEY];
	$arr['H3KEY'] = $H3KEY;
	return $arr;
}// end function ShowExsumEx(){



$arr_data = ShowExsumEx();
?>



<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานรายชื่อ ผู้อำนวยการ/รองผู้อำนวยการ สำนักงานเขตพื้นที่การศึกษาและห้วหน้าฝ่ายบุคคล<br><a href="?Process=1">คลิ๊กเพื่อประมวลผลข้อมูล</a></td>
        </tr>
		   <tr>
		     <td align="center"><br>
		       <table width="70%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		           <tr>
		             <td width="26%" rowspan="2" bgcolor="#A5B2CE">&nbsp;</td>
		             <td width="14%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>จำนวนทั้งหมด</strong></td>
		             <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>สถานะข้อมูล</strong></td>
	                </tr>
		           <tr>
		             <td width="13%" bgcolor="#A5B2CE"><strong>บันทึกเสร็จ(คน)</strong></td>
		             <td width="12%" bgcolor="#A5B2CE"><strong>ค้างบันทึก(คน)</strong></td>
		             <td width="13%" bgcolor="#A5B2CE"><strong>QC เสร็จ(คน)</strong></td>
		             <td width="13%" bgcolor="#A5B2CE"><strong>ค้าง QC(คน)</strong></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">ผอ.สำนักงานเขตพื้นที่การศึกษา</td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']-$arr_data['H1KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']-$arr_data['H1QC']);?></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">รอง ผอ. สำนักงานเขตพื้นที่การศึกษา</td>
					<td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']-$arr_data['H2KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']-$arr_data['H2QC']);?></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">หัวหน้าฝ่ายบุคคล</td>
                    <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']-$arr_data['H3KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']-$arr_data['H3QC']);?></td>
	                </tr>
		           <tr>
		             <td align="center" bgcolor="#A5B2CE"><strong>รวม</strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1']+$arr_data['H2']+$arr_data['H3']);?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1KEY']+$arr_data['H2KEY']+$arr_data['H3KEY']); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format(($arr_data['H1']-$arr_data['H1KEY'])+($arr_data['H2']-$arr_data['H2KEY'])+($arr_data['H3']-$arr_data['H3KEY'])); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1QC']+$arr_data['H2QC']+$arr_data['H3QC']); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format(($arr_data['H1']-$arr_data['H1QC'])+($arr_data['H2']-$arr_data['H2QC'])+($arr_data['H3']-$arr_data['H3QC'])); ?></strong></td>
	                </tr>
	             </table></td>
	           </tr>
	         </table>
	         <br></td>
        </tr>
		   <tr>
		     <td>&nbsp;</td>
        </tr>
		   <tr>
          <td><a href="?xtype=1">คีย์ข้อมูลแล้ว</a> || <a href="?xtype=0">ยังไม่ไ้ด้คีย์ข้อมูล</a> || <a href="?xtype=QC">QC แล้ว</a> || <a href="?xtype=NQC">ยังไม่ได้ QC</a> || <a href="?xtype=">แสดงข้อมูลทั้งหมด</a></td>
        </tr>
		   <tr>
		     <td>&nbsp;</td>
        </tr>
		   <tr>
		     <td><!--หมายเหตุ : แถวที่เป็นสีเทาคือยังไม่มีการนำเข้าข้อมูลจากฐานข้อมูล Checklist สู่ ฐานข้อมูล CMSS , สีขาวคื่อนำเข้าข้อมูลสู่ฐานข้อมูล CMSS เพื่อรอการบันทึกข้อมูลเรียบร้อยแล้ว--></td>
        </tr>
		   <tr>
		     <td bgcolor="#000000">
             <table width="100%" border="0" cellspacing="1" cellpadding="2">  
             <?
             	 if($xtype == "1"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='1'";
				 	$xtitle = "รายงานข้อมูลผู้บริหารที่คีย์ข้อมูลแล้ว";
				 }else if($xtype == "0"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='0'"; 
					$xtitle = "รายงานข้อมูลผู้บริหารที่ยังไม่ไ้ด้คีย์ข้อมูล";
				}else if($xtype == "QC"){
					$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.staff_qc <> '' AND ".DB_USERENTRY.".temp_report_executive.staff_qc IS NOT NULL";  	
					$xtitle = "รายงานข้อมูลผู้บริหารที่QC แล้ว";
					}else if($xtype == "NQC"){
					$conw1 = "AND (edubkk_userentry.temp_report_executive.staff_qc = '' or ".DB_USERENTRY.".temp_report_executive.staff_qc IS NULL)";
					$xtitle = "รายงานข้อมูลผู้บริหารที่ยังไม่ได้QC ";
				}
			   else{
				   $conw1 = "";
				   $xtitle = "รายงานข้อมูลผู้บริหารทั้งหมด";
				 }

			 ?>
		       <tr>
		         <td colspan="12" align="center" bgcolor="#A5B2CE"><strong><? echo $xtitle;?></strong></td>
	           </tr>
		       <tr>
		         <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>วันเดือนปีเกิด</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
		         <td width="13%" align="center" bgcolor="#A5B2CE"><strong>สพท.</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>สถานะนำ<br>
	             เข้าข้อมูล</strong></td>
		         <td width="6%" align="center" bgcolor="#A5B2CE"><strong>สถานะ<br>
	             คีย์ข้อมูล</strong></td>
		         <td width="9%" align="center" bgcolor="#A5B2CE"><strong>พนักงาน QC</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>วันที่ QC</strong></td>
		         <td width="12%" align="center" bgcolor="#A5B2CE"><strong>เครื่องมือ</strong></td>
		         <td width="6%" align="center" bgcolor="#A5B2CE"><strong>QC</strong></td>
	           </tr>
               <?
               	$sql = "SELECT ".DB_USERENTRY.".temp_report_executive.idcard, ".DB_USERENTRY.".temp_report_executive.siteid, ".DB_USERENTRY.".temp_report_executive.prename_th, ".DB_USERENTRY.".temp_report_executive.name_th, ".DB_USERENTRY.".temp_report_executive.surname_th, ".DB_USERENTRY.".temp_report_executive.birthday, ".DB_USERENTRY.".temp_report_executive.position_now, ".DB_USERENTRY.".temp_report_executive.staff_key, ".DB_USERENTRY.".temp_report_executive.staff_qc, ".DB_USERENTRY.".temp_report_executive.date_qc, ".DB_USERENTRY.".temp_report_executive.status_key,
 ".DB_MASTER.".eduarea.secname
FROM ".DB_USERENTRY.".temp_report_executive
Inner Join  ".DB_MASTER.".eduarea ON ".DB_USERENTRY.".temp_report_executive.siteid =  ".DB_MASTER.".eduarea.secid
WHERE ".DB_USERENTRY.".temp_report_executive.idcard <> '' $conw1
ORDER BY ".DB_USERENTRY.".temp_report_executive.siteid ASC,edubkk_userentry.temp_report_executive.position_now ASC";
				$result = mysql_db_query($dbnameuse,$sql);
				$i=0;
				$k=0;
				while($rs = mysql_fetch_assoc($result)){
						$i++;
						//if($k % 2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
						if($i == 1){ $temp_siteid = $rs[siteid];}
						if($rs[siteid] != $temp_siteid){ $k++; $temp_siteid = $rs[siteid];}
						if($k % 2){ $bg = "#CCCCCC";}else{$bg = "#FFFFFF";}	
						
						$urlpath = "../../../edubkk_kp7file/$rs[siteid]/" . $rs[idcard] . ".pdf"  ;
						if(is_file($urlpath)){
								$pdf_org = "<a href='/edubkk_kp7file/$rs[siteid]/$rs[idcard].pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a>";
						}else{
								$pdf_org = "";	
						}
						
						
					$pdf	= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\">";
				 $pdf		.= "<img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";
				 
				 	$sql_imp = "SELECT COUNT(idcard) AS numid FROM tbl_check_data WHERE idcard='$rs[idcard]' AND secid='$rs[siteid]'";
					$result_imp = mysql_db_query($db_temp,$sql_imp);
					$rsi = mysql_fetch_assoc($result_imp);
					
					if($rsi[numid] > 0){
						$img_import = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" title=\"สถานะนำเข้าข้อมูลสู่ CMSS เพื่อรองการบันทึกข้อมูลเรียบร้อยแล้ว\">";
					}else{
						$img_import = "<img src=\"../../images_sys/cancel_s.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ยังไม่ได้นำเข้าข้อมูล\">";
					}// end 	if($rsi[numid] > 0){
			   ?>
           
		       <tr bgcolor="<?=$bg?>">
		         <td align="center"><?=$i?></td>
		         <td align="center"><?=$rs[idcard]?></td>
		         <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
		         <td align="center"><? echo thaidate1($rs[birthday]);?></td>
		         <td align="left"><? echo $rs[position_now];?></td>
		         <td align="left"><? echo str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);?></td>
		         <td align="center">
                 <?
					echo $img_import;
				 ?>
                 </td>
		         <td align="center"><? if($rs[status_key] == 1){ echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"บันทึกข้อมูลเข้าไปในระบบแล้ว\">";}else{ echo " <img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ยังไม่ได้บันทึกข้อมูล\">";} 
?>
	            </td>
		         <td align="left"><? if($rs[staff_qc] != ""){ echo GetStaffQc($rs[staff_qc]);}?></td>
		         <td align="center"><? echo thaidate($rs[date_qc]);?></td>
		         <td align="center"><? echo " <a href='../hr3/hr_report/general_all_1search.php?xid=$rs[idcard]&action=edit' target='_blank'> <img src='../../images_sys/doc_zoom.png' alt='แสดงข้อมูลสรุป' width='16' height='16' border='0' /></a> &nbsp; $pdf_org &nbsp; $pdf "; 	?><A href="../hr3/hr_report/report_main_govplan.php?id=<?=$rs['idcard']?>&xsiteid=<?=$rs['siteid']?>" target="_blank"><IMG SRC="../hr3/hr_report/images/organization.gif" WIDTH="23" HEIGHT="23" BORDER="0" ALT="" align="absmiddle"></A></td>
		         <td align="center"><a href="../hr3/hr_report/report_check/report_check_data.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../validate_management/images/zoom.png" width="16" height="16" / border="0" alt="หน้ารายงานเทียบ label กับ value"></a>&nbsp;<a href="../hr3/tool_competency/diagnosticv1/validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?>&staffname=<?=GetStaffQc($rs[staff_key])?>&staffid=<?=$rs[staff_key]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" alt="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a></td>
	           </tr>
               <? 
				}//end 
			   ?>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table> 

</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>