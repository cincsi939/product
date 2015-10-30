<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		จัดการผู้ใช้
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

include "epm.inc.php";
$report_title = "บุคลากร";

//echo "<pre>";
//print_r($_SESSION);

//**********ต้องปรับใหม่*************************
//$office_id = "13000200";
//$hr_db = "hr";
//****************************************

$org_id = intval($org_id);
$msg = "";

//echo "$step<hr>";

//function fix_condb104(){ // เพื่อ connect เครื่อง 104 ด้วย
//	global $db_name;
//		$host = "202.129.35.104";
//		$username = "sapphire";
//		$password = "sprd!@#$%";
//		$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database  ");
//		mysql_select_db($db_name) or die( "Unable to select database");
//		$iresult = mysql_query("SET character_set_results=tis-620");
//		$iresult = mysql_query("SET NAMES TIS620");
//}//end fix_condb
//
//function fix_condb130(){ // เพื่อ connect เครื่อง 104 ด้วย
//	global $db_name;
//		$host = "localhost";
//		$username = "sapphire";
//		$password = "sprd!@#$%";
//		$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database  ");
//		mysql_select_db($db_name) or die( "Unable to select database");
//		$iresult = mysql_query("SET character_set_results=tis-620");
//		$iresult = mysql_query("SET NAMES TIS620");
//}//end fix_condb


$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

				function thai_date($temp){
				global $mname;
				if($temp != "0000-00-00"){
				$x = explode("-",$temp);
				$m1 = $mname[intval($x[1])];
				$y1 = intval($x[0]+543);
				$y1 = substr($y1,-2);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				}//end if($temp != "0000-00-00"){
				return $xrs;
			}



function mk_username($ename,$esurname,$eid,$xsapphireoffice=""){
global $epm_staff  ;

	if($xsapphireoffice == "2"){
		$length_sub = "4";
	}else{
		$length_sub = "3";	
	}
	$uname = strtolower($ename . "." . substr($esurname,0,$length_sub));
	//echo "uname ::".$uname."<br>";
	$lastuname = $uname;
	$n = $length_sub; $k=0;
	$sql1 = "SELECT COUNT(username) AS num1  FROM $epm_staff WHERE username='$uname'  ";// AND staffid <> '$eid'
	$result1 = mysql_query($sql1);
	$xnum = @mysql_num_rows($sql1);
	if($xnum < 1){
		return $uname;	
	}else{
		$length_sub = $length_sub+1;
		$xuname = strtolower($ename . "." . substr($esurname,0,$length_sub));
		$sql2 = "SELECT COUNT(username) AS num1  FROM $epm_staff WHERE username='$xuname' ";// AND staffid <> '$eid'
		$result2 = mysql_query($sql2);
		$xnum2 = @mysql_num_rows($result2);
		if($xnum2 < 1){
				return $xuname;
		}else{
			$length_sub = $length_sub+2;
			$xuname1 = strtolower($ename . "." . substr($esurname,0,$length_sub));
			return $xuname1;
		}
		
	}//end if($xnum < 1){

}//end function mk_username($ename,$esurname,$eid){




if (($_SERVER[REQUEST_METHOD] == "POST" && ($step == "confirm" || $step == "start") ) or ($conF == "1") ){  // แก้ไขกรณีผู้ใช้ไม่ต้องการมีหน้ายืนยัน ( ความต้องการพี่เพ็ญ )


//echo "<pre>";
//print_r($_POST);
## กรณีพนักงานที่ออกไปแล้วแต่ยังต้องคำนวณค่า incentive อยู่
	if($status_permit == "NO"){
		$cal_incentive = 1;
	}else{
		$cal_incentive = 0;	
	}//end if($status_permit == "NO"){


if($retire_date != ""){
	$arr_x1 = explode("/",$retire_date);
	$retire_date = ($arr_x1[2]-543)."-".$arr_x1[1]."-".$arr_x1[0];
}

###  วันที่เปลี่ยนกลุ่ม
if($date_change != "" and $date_change != "//543"){
	$arrx2 =explode("/",$date_change);
	$date_change  = ($arrx2[2]-543)."-".$arrx2[1]."-".$arrx2[0];
	$month_date = substr($date_change,0,7);
		
}


if($date_area != "" and $date_area != "//543"){
	$arrx2 =explode("/",$date_area);
	$date_area  = ($arrx2[2]-543)."-".$arrx2[1]."-".$arrx2[0];
		
}


			$xpassword = "logon";
		
			$xusername = mk_username($engname,$engsurname,$id,$sapphireoffice);
			//echo $xusername."<br>";die;

/*
	// remove slashes from variable
	foreach ($_POST as $key => $value){
		if (!is_array($value) && !is_numeric($value)){
			$_POST[$key] = stripslashes($value);
		}
	}
*/




	if ($staffname == ""){
		$msg = "กรุณาระบุชื่อ - นามสกุล";
	}else{
		
		
				if(CheckQCChangeGroup($xstaffid,$month_date) > 0 and $conF == 0){
					 echo "<script>if(confirm('ข้อมูลที่  $prename$staffname  $staffsurname บันทึก ยังไม่ได้ QC ทั้งหมดดังนั้นการเปลี่ยนสถานะจะมีผลกระทบต่อการคำนวณ incentive   \\n กด ok เพื่อยืนยันที่จะเปลี่ยน หรือกด Cancel เพื่อยกเลิกการบันทึกข้อมูล ')){ 
					  if(parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$action&xstaffid=$xstaffid&org_id=$org_id&utype=$utype&conF=1';
					   }else{ alert('คุณได้ยกเลิกการบันทึกการเปลี่ยนแปลงสถานะพนักงาน');if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';};</script>";		
						/*echo "<script>alert('ไม่สามารถเปลี่ยนกลุ่มการคีย์ข้อมูลได้เนื่องจากข้อมูลที่จะต้อง QC ยังQC ไม่เสร็จ'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";exit();*/
				}

		
		if($sapphireoffice == "2"){ $keyin_group = 8;}else{ $keyin_group = $keyin_group;} // กรณีเป็น sub

		if ($action == "new"){
			###############   ตรวจสอบ กลุ่มก่อนการบันทึกเพื่อเก็บ log
			$sql = "insert into $epm_staff( prename,staffname,staffsurname,engprename,engname,engsurname, email,comment,sex,title,telno,address,username,password,org_id,status,std_cost,card_id,weight,sapphireoffice,priority,status_permit,retire_date,status_extra,period_time,keyin_group,part_keydata,cal_incentive,flag_assgin,site_area,date_area) values ('$prename','$staffname','$staffsurname','$engprename','$engname','$engsurname', '$email','$comment','$sex','$title', '$telno','$address','$xusername','$xpassword','$org_id','$xstatus','$std_cost','$card_id','$weight','$sapphireoffice','$priority','$status_permit','$retire_date','$status_extra','$period_time','$keyin_group','$part_keydata','$cal_incentive','$flag_assgin','$site_area','$date_area')";
			if($site_area != ""){
				$sql_site = "SELECT COUNT(*) AS num1 FROM $epm_staff WHERE site_area='$site_area' and status_permit='YES' ";
				$result_site = mysql_db_query($dbnameuse,$sql_site);
				$rssite = mysql_fetch_assoc($result_site);
				if($rssite[num1] > 0){
						echo "<script>alert(' !ไม่สารมารถระบุเขตพื้นที่พนักงานไปจำเขตได้เนื่องจากมีเจ้าหน้าที่ประจำเขตอยู่แล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>"; exit();
				}
			}//end if($site_area != ""){
			$xresult = mysql_db_query($dbnameuse,$sql);
			$staff_id = mysql_insert_id($xresult); // รหัสพนักงานใหม่
			SaveGroupKeyData($staff_id,$keyin_group,$date_change); // เก็บข้อมูลเป็น สถิติไว้
			SaveJobNameData($staff_id,$status_extra);// เก็บประวัติการย้ายกลุ่มงาน
		}else if ($action == "edit"){
			$sql = " update $epm_staff set prename='$prename',staffname='$staffname',staffsurname='$staffsurname', engprename='$engprename',engname='$engname',engsurname='$engsurname', email='$email', comment='$comment', sex='$sex',title='$title', telno='$telno',address='$address',status='$xstatus', std_cost='$std_cost',card_id='$card_id',weight='$weight' ,username='$xusername', sapphireoffice = '$sapphireoffice' ,priority = '$priority',status_permit='$status_permit', retire_date='$retire_date', status_extra='$status_extra',period_time='$period_time',keyin_group='$keyin_group',part_keydata='$part_keydata',cal_incentive='$cal_incentive',flag_assgin='$flag_assgin',site_area='$site_area',date_area='$date_area' where staffid = '$xstaffid'; ";
			//echo "$sql";die;
			//echo CheckQCChangeGroupAB($xstaffid,$month_date);
		if($site_area != ""){
				$sql_site = "SELECT COUNT(*) AS num1 FROM $epm_staff WHERE site_area='$site_area' AND staffid <> '$xstaffid'  and status_permit='YES' ";
				$result_site = mysql_db_query($dbnameuse,$sql_site);
				$rssite = mysql_fetch_assoc($result_site);
				if($rssite[num1] > 0){
						echo "<script>alert(' !ไม่สารมารถระบุเขตพื้นที่พนักงานไปจำเขตได้เนื่องจากมีเจ้าหน้าที่ประจำเขตอยู่แล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>"; exit();
				}
		}//end	if($site_area != ""){ 

		
			if($keyin_group == "1" or $keyin_group == "2"){ // สำหรับกลุ่ม A กับ B
				 if(CheckQCChangeGroupAB($xstaffid,$month_date) > 0 and $conF == 0){
					 
					 echo "<script>if(confirm('ข้อมูลที่  $prename$staffname  $staffsurname บันทึก  ยังไม่ได้ QC ทั้งหมดดังนั้นการเปลี่ยนสถานะจะมีผลกระทบต่อการคำนวณ incentive   \\n กด ok เพื่อยืนยันที่จะเปลี่ยน หรือกด Cancel เพื่อยกเลิกการบันทึกข้อมูล ')){  
					 if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$action&xstaffid=$xstaffid&org_id=$org_id&utype=$utype&conF=1';
					  }else{ alert('คุณได้ยกเลิกการบันทึกการเปลี่ยนแปลงสถานะพนักงาน');if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';};</script>";		
					 
						/*echo "<script>alert(' !ไม่สามารถเปลี่ยนกลุ่มการคีย์ข้อมูลได้เนื่องจากข้อมูลที่จะต้อง QC ยัง QC ไม่เสร็จ'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>"; exit();*/
				}
			}else{
				if(CheckQCChangeGroup($xstaffid,$month_date) > 0 and $conF == 0){
					 echo "<script>if(confirm('ข้อมูลที่  $prename$staffname  $staffsurname บันทึก ยังไม่ได้ QC ทั้งหมดดังนั้นการเปลี่ยนสถานะจะมีผลกระทบต่อการคำนวณ incentive   \\n กด ok เพื่อยืนยันที่จะเปลี่ยน หรือกด Cancel เพื่อยกเลิกการบันทึกข้อมูล ')){ 
					  if(parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$action&xstaffid=$xstaffid&org_id=$org_id&utype=$utype&conF=1';
					   }else{ alert('คุณได้ยกเลิกการบันทึกการเปลี่ยนแปลงสถานะพนักงาน');if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';};</script>";		
						/*echo "<script>alert('ไม่สามารถเปลี่ยนกลุ่มการคีย์ข้อมูลได้เนื่องจากข้อมูลที่จะต้อง QC ยังQC ไม่เสร็จ'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";exit();*/
				}
			}
			
			//echo $sql."<br>$date_change";die;
			SaveGroupKeyData($xstaffid,$keyin_group,$date_change); // เก็บข้อมูลเป็น สถิติไว้
			SaveJobNameData($xstaffid,$status_extra);// เก็บประวัติการย้ายกลุ่มงาน
			$xresult = mysql_db_query($dbnameuse,$sql);
				echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";
				header("Location : ?org_id=$org_id");
				exit;

		}else{
		echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";
		header("Location : ?org_id=$org_id");
		exit;
		}//end if ($action == "new"){
		if (mysql_errno() != 0){ 
			$msg = "ไม่สามารถบันทึกลงฐานข้อมูลได้<BR>$sql<BR><BR>" . mysql_error() ;
		}else{
			echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";
			header("Location: ?org_id=$org_id");
			exit;
		}

	}
	$action = "";
}else if ($_SERVER[REQUEST_METHOD] == "POST" && $action == "import"){ 

	foreach ($_POST[hr_id] as $k => $xid){
		//echo "$k = $xid<BR>";
		$result = mysql_query("select * from $hr_db.general where id='$xid';");
		$rs = mysql_fetch_assoc($result);
		//เชคเลขบัตรประชาชน
		if ($rs[idcard] > ""){
			$result2 = mysql_query("select * from $epm_staff where card_id = '$rs[idcard]';");
			$rs2 = mysql_fetch_assoc($result2);

			if ($rs[card_id] == $rs2[idcard]){
				echo "<FONT COLOR='RED'>ข้อมูลซ้ำ</FONT> :$rs[idcard] $rs[prename_th] $rs[name_th] $rs[surname_th] <BR>";
				continue; //skip
			}

		}//if

		
		//เชคชื่อ + นามสกุล
		$result2 = mysql_query("select * from $epm_staff where staffname='$rs[name_th]' and staffsurname='$rs[surname_th]';");
		if (mysql_num_rows($result2) > 0){
			echo "<FONT COLOR='RED'>ข้อมูลซ้ำ</FONT> : $rs[prename_th] $rs[name_th] $rs[surname_th] <BR>";
			continue; //skip
		}


		//gen username
		//$uname = mk_username($rs[name_en],$rs[surname_en]);
		$x = explode(" ",$rs[birthday]);
		$x = explode("-",$x[0]);
		$uname = "$x[2]$x[1]$x[0]";
		$pwd = $rs[idcard];

		//convert sex
		if ($rs[sex] == "ชาย") {
			$sex = "M";
		}else if ($rs[sex] == "หญิง"){
			$sex="F";
		}else{
			$sex="";
		}

		//add into $epm_staff
		$sql = "insert into $epm_staff (prename,staffname,staffsurname,engprename,engname,engsurname,sex,org_id,title,telno, address,username,password,card_id,hr_id,status,sapphireoffice,priority,status_permit, retire_date,status_extra,period_time,keyin_group,part_keydata,cal_incentive,flag_assgin,site_area,date_area) values('$rs[prename_th]','$rs[name_th]','$rs[surname_th]', '$rs[prename_en]','$rs[name_en]', '$rs[surname_en]','$sex','$org_id','$rs[position_now]','$rs[telno]','$rs[address]','$uname','$pwd','$rs[idcard]','$rs[id]' , '$rs[status]','$rs[sapphireoffice]','$rs[priority]','$status_permit','$retire_date','$status_extra','$period_time','$keyin_group','$part_keydata','$cal_incentive','$flag_assgin','$site_area','$date_area')";

		//echo "insert : $sql <BR><BR>";
		//fix_condb130(); //  เครื่อง 130
		//@mysql_query($sql);
		//fix_condb104(); // เครื่อง 104
				if($site_area != ""){
				$sql_site = "SELECT COUNT(*) AS num1 FROM $epm_staff WHERE site_area='$site_area'  and status_permit='YES'  ";
				$result_site = mysql_db_query($dbnameuse,$sql_site);
				$rssite = mysql_fetch_assoc($result_site);
				if($rssite[num1] > 0){
						echo "<script>alert(' !ไม่สารมารถระบุเขตพื้นที่พนักงานไปจำเขตได้เนื่องจากมีเจ้าหน้าที่ประจำเขตอยู่แล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>"; exit();
				}
		}//end	if($site_area != ""){ 

		$xresult = mysql_db_query($dbnameuse,$sql);
		$staff_id = mysql_insert_id();
		SaveGroupKeyData($staff_id,$keyin_group,$date_change); // เก็บข้อมูลเป็น สถิติไว้
		SaveJobNameData($staff_id,$status_extra);// เก็บประวัติการย้ายกลุ่มงาน
		echo "<FONT COLOR='GREEN'>นำเข้า</FONT> : $rs[prename_th] $rs[name_th] $rs[surname_th] <BR>";

	} // foreach
	exit;

}else	if ($action == "delete" && $xstaffid > ""){
	$strdel = " SELECT  idcard  FROM   general_check  WHERE  check_staff = '$xstaffid'  or update_staff = '$xstaffid'  or update6y_staff =  '$xstaffid' " ;
	
	###################### ตรวจสอบกรณีมีการ assign #############################################
	
	$sql_check = "SELECT COUNT(staffid)  as num_c FROM tbl_assign_sub WHERE staffid='$xstaffid'";
	$result_check = mysql_query($sql_check);
	$rs_check = mysql_fetch_assoc($result_check);
	
	##############################   end ตรวจสอบกรณีมีการ assign#################################  
	//echo "$strdel";die;
	if(Query1($strdel) or $rs_check[num_c] > 0){
		$entrystatus = true;
	}else{
		///fix_condb130();
		//@mysql_query("delete from $epm_staff where staffid='$xstaffid';");
		//fix_condb104();
		@mysql_query("delete from $epm_staff where staffid='$xstaffid';");
	}
	
	if (mysql_errno() > 0 || $entrystatus == true ){
		echo "<script>alert('ไม่สามารถลบข้อมูลได้เนื่องจากมีข้อมูลที่อ้างอิงอยู่'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id';</script>";
		exit;	
	}else{
		echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";
		exit;
	}
	$action = "";
}else	if ($action == "resetpwd" && $id > ""){
	//fix_condb130();
	//@mysql_query("update $epm_staff set password='logon' where staffid='$xstaffid';");
	//fix_condb104();
	@mysql_query("update $epm_staff set password='logon' where staffid='$xstaffid';");
	if (mysql_errno() > 0){
		$msg = "ไม่สามารถ Reset Passwordได้";
	}
	$action = "";
}
//include("index_top.php");
?>


<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>

function checkID(id) { 
	if(id.length != 13) return false; 
		for(i=0, sum=0; i < 12; i++) 
		sum += parseFloat(id.charAt(i))*(13-i); 
		if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false; 
		return true; 
} 

function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	var xstatus = document.form1.xstatus.value;
	//alert(xstatus);
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	
/*	if (document.form1.card_id.value == "" && xstatus != 1)  {	
	missinginfo1 += "\n- เลขบัตรประจำตัวประชาชน ไม่สามารถเป็นค่าว่าง"; }		
		if(document.form1.card_id.value != "" && xstatus != 1){
			if(!checkID(document.form1.card_id.value)){ 
			missinginfo1 += "\n- เลขบัตรประจำตัวประชาชน ไม่ถูกต้องตามกรมการปกครอง"; 
			}
	}//end if(document.form1.card_id.value != ""){
	
*/	
if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
	
	
	function toDisble(rdo){
	var value = rdo.value;
	if(value == "NO"){
		document.getElementById("retire_date").disabled = false;
		document.getElementById("button0").disabled = false;
	}else if(value == "YES"){
		document.getElementById("retire_date").disabled = true;
		document.getElementById("button0").disabled = true;
		//document.getElementById("retire_date").value = "";

	}	
}//end 	function toDisble(rdo){
	
	
	
function DisSiteArea(){
	if(document.form1.status_extra.value == "site_area"){
			document.form1.site_area.disabled=false;
	}else{
		document.form1.site_area.disabled=true;
	}
		
}//end function DisSiteArea(){
	
function Filter_Keyboard() {
  var keycode = window.event.keyCode;
  if( keycode >=37 && keycode <=40 ) return true;  // arrow left, up, right, down  
  if( keycode >=48 && keycode <=57 ) return true;  // key 0-9
  if( keycode >=96 && keycode <=105 ) return true;  // numpad 0-9
  if( keycode ==110 || keycode ==190  ) return true;  // dot
  if( keycode ==8  ) return true;  // backspace
  if( keycode ==9 ) return true;  // tab
  if( keycode ==45 ||  keycode ==46 || keycode ==35 || keycode ==36) return true;  // insert, del, end, home
  return false;
}


</script>

</head>

<body bgcolor="#EFEFFF">

<?

if ($_GET[action] == "edit" || $_GET[action] == "new" || $step == "start"){
	
	if($conF == "1"){ // กรณีทีมีการยืนยันการเปลี่ยนกลุ่ม
			echo "<script> if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?org_id=$org_id&utype=$utype';</script>";
			header("Location: ?org_id=$org_id");
			exit;
	}
	
	
	if ($_GET[action] == "edit" && $step == ""){
		$sql = "select * from $epm_staff where staffid='$_GET[xstaffid]';";
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		$title="แก้ไข";
		$uname= $rs[username];
		$pwd = $rs[password];
		//echo $rs[username];
	   // $uname = mk_username($_POST[engname],$_POST[engsurname]);
	}else{
		$rs = array();
		$rs[weight] = 1;
		$title = "เพิ่ม";
	}

	$lock = "";
    
	if ($step == ""){
		$step = "start";
	}else if ($step == "start"){
		if ($action == "edit"){
			$pwd = $_POST[xpassword];
			$uname = $_POST[xusername];	
			$retire_date = $_POST[retire_date];
            
		$uname = mk_username($_POST[engname],$_POST[engsurname],$_POST[xstaffid],$sapphireoffice);
       // echo "B : ".$uname."<br>";die;
		}else{
			$pwd = "logon";
		
			$uname = mk_username($_POST[engname],$_POST[engsurname],$_POST[xstaffid],$sapphireoffice);
			// echo "C : ".$uname."<br>";die;

		} // if

		$step = "confirm";
		$rs = $_POST;
//		echo "<pre>";
//		print_r($rs);
		$lock = " ONFOCUS='blur();' ";
		$title = "ยืนยัน";
        

	}
?>
<form action="?" method="POST" NAME="form1" ONSUBMIT="Javascript:return (checkFields());">
<INPUT TYPE="hidden" NAME="xstaffid" VALUE="<?=$xstaffid?>" >
<INPUT TYPE="hidden" NAME="step" VALUE="<?=$step?>" >
<INPUT TYPE="hidden" NAME="org_id" VALUE="<?=$org_id?>" >
<input type="hidden" name="action" value="<?=$action?>"  >
<INPUT TYPE="hidden" NAME="xusername" VALUE="<?=$uname?>"  >
<INPUT TYPE="hidden" NAME="xpassword" VALUE="<?=$pwd?>"  >
<table border=0 align=center cellspacing=1 cellpadding=3 bgcolor="#DDDDDD" width="98%">
    <tr bgcolor="#a3b2cc"> 
      <td colspan=2> &nbsp; <FONT COLOR="WHITE" style="font-size:14pt;"><B><?=$title?>ข้อมูล<?=$report_title?></B></font></td>
    </tr>
<?
 if ($step == "confirm" || $action == "edit"){	
?>
	<tr bgcolor="#EFEFFF" valign=top> <td bgcolor="#EFEFFF" class="link_back"> Username </td>  <td> <U><?=$uname?></U> </td> </tr>
	<tr bgcolor="#EFEFFF" valign=top> <td bgcolor="#EFEFFF" class="link_back"> Password </td>  <td bgcolor="#EFEFFF"> <input type="password" name="xpwd" value="<?=$pwd?>" readonly style="border:none;background-color:#EFEFFF"> </td> </tr>
	<tr bgcolor="#808080" height=10><td colspan=2></td>	</tr>
<?
}	
?>

	<tr bgcolor=white valign=top> 
      <td class="link_back">คำนำหน้า (ไทย) </td>
      <td> 
        <INPUT TYPE="text" NAME="prename" VALUE="<?=$rs[prename]?>" size="30" maxlength=50 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">ชื่อ (ไทย) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="staffname" VALUE="<?=$rs[staffname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">นามสกุล (ไทย) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="staffsurname" VALUE="<?=$rs[staffsurname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">คำนำหน้า (อังกฤษ) </td>
      <td> 
        <INPUT TYPE="text" NAME="engprename" VALUE="<?=$rs[engprename]?>" size="30" maxlength=50 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">ชื่อ (อังกฤษ) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="engname" VALUE="<?=$rs[engname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">นามสกุล (อังกฤษ) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="engsurname" VALUE="<?=$rs[engsurname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">เลขบัตรประจำตัว<FONT COLOR="RED">*</FONT></td>
      <td><INPUT TYPE="text" NAME="card_id" VALUE="<?=$rs[card_id]?>" onKeyDown="return Filter_Keyboard();" size="20" maxlength=13 class=inputbox <?=$lock?> >      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">Email Address</td>
      <td> <INPUT TYPE="text" NAME="email" VALUE="<?=$rs[email]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ประเภท</td>
	  <td>
	  <select name="sex" <?=$lock?> style="width:150px;">
<?
$sex_array = array("M"=>"ชาย","F"=>"หญิง", "O"=>"องค์กร");	
foreach ($sex_array as $sex=>$caption){
	if ($rs[sex] == $sex) $sel="SELECTED"; else $sel="";
	echo "<option value='$sex' $sel>$caption";
}
		?>
	  </select>	  </td>
</tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะ</td>
	  <td>
	  <select name="xstatus" <?=$lock?> style="width:150px;">
	  <?
		$status_array = array("0"=>"เข้าระบบได้ตามปกติ","1"=>"ระงับการเข้าระบบ");	
		foreach ($status_array as $status=>$caption){
			if ($rs[status] == $status) $sel="SELECTED"; else $sel="";
			echo "<option value='$status' $sel>$caption";
		}
		?>
	  </select>	  </td>
</tr>
	<tr bgcolor=white valign=top>
	  <td class="link_back">ช่วงเวลาทำงาน<FONT COLOR="RED">*</FONT></td>
	  <td><select name="period_time" id="period_time">
	    <option value="">กรุณาเลือก</option>
	    <option value="am" <? if($rs[period_time]=="am"){echo "selected='selected'";} ?>>Fulltime 09:00-17:30</option>
	    <option value="pm" <? if($rs[period_time]=="pm"){echo "selected='selected'";} ?>>passtime 18:00-22:00</option>
	    </select>	  </td>
    </tr>
	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะ<FONT COLOR="RED">*</FONT></td>
	  <td><? if($xsapphireoffice != "2"){?><select name="sapphireoffice" id="sapphireoffice">
	    <option value="0" <? if($rs[sapphireoffice] == "0"){echo "selected";} ?>>ลูกจ้างชั่วคราว</option>
	    <option value="1" <? if($rs[sapphireoffice] == "1"){echo "selected";} ?>>พนักงานบริษัท</option>
		<option value="2" <? if($rs[sapphireoffice] == "2"){echo "selected";} ?>>Subcontract</option>
         </select>
         <?
	  	}else{
			echo "Subcontract";
			echo "<input type='hidden' name='sapphireoffice' value='$xsapphireoffice'>";	
		}// end if($xsapphireoffice != "2"){
				
		 ?>
         </td>
    </tr>
	<tr bgcolor=white valign=top>
	  <td class="link_back">ระดับการเข้าถึงข้อมูล<FONT COLOR="RED">*</FONT></td>
	  <td><select name="priority" id="priority">
	  	    <option value="100">Dataentry</option>
	    	<option value="2000">Supervisor</option>
              </select></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ตำแหน่ง</td>
      <td> <INPUT TYPE="text" NAME="title" VALUE="<?=$rs[title]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">อัตราค่าแรง / วัน</td>
      <td> <INPUT TYPE="text" NAME="std_cost" VALUE="<?=$rs[std_cost]?>" size="10" maxlength=10 class=inputbox <?=$lock?>>  บาท</td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">น้ำหนักความสำคัญ</td>
      <td> <INPUT TYPE="text" NAME="weight" VALUE="<?=$rs[weight]?>" size="10" maxlength=10 class=inputbox <?=$lock?>> </td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ที่อยู่</td>
	  <td><TEXTAREA NAME="address" ROWS="3" COLS="60" <?=$lock?>><?=$rs[address]?></TEXTAREA></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">โทรศัพท์</td>
      <td> <INPUT TYPE="text" NAME="telno" VALUE="<?=$rs[telno]?>" size="60" maxlength=100 class=inputbox <?=$lock?>>      </td>
    </tr>

<?
if ($hr_db){	
?>
	<tr bgcolor=white valign=top>
	  <td class="link_back">เชื่อมโยงกับบุคลากร CMSS</td>
      <td> 
		<select name="hr_id">
		<option value=""> - ไม่ระบุ - </option>
		<?
			$hresult = mysql_query("select * from $hr_db.general where unit='$office_id';");
			while ($hrs = mysql_fetch_assoc($hresult)){
				if ($rs[hr_id] == $hrs[id]) $sel="SELECTED"; else $sel="";
				echo "<option value='$hrs[id]' $sel>$hrs[name_th] $hrs[surname_th]</option>";
			}
		?>
		</select>	</td>
    </tr>
<?
}	
?>


	<tr bgcolor=white valign=top>
	  <td class="link_back">หมายเหตุ</td>
	  <td><TEXTAREA NAME="comment" ROWS="3" COLS="60" <?=$lock?>><?=$rs[comment]?></TEXTAREA></td>
    </tr>
	<? 
			$temp_pos = strpos($rs[retire_date],"/");
			//echo "xx = $temp_pos";
			if($rs[retire_date] != "0000-00-00" and $temp_pos < 1){
			$arr_dx = explode("-",$rs[retire_date]);
			$retire_date = "$arr_dx[2]/$arr_dx[1]/".($arr_dx[0]+543);
			}else if($rs[retire_date] == "0000-00-00"){
			$retire_date = "";
			}else{
			$retire_date = $rs[retire_date];
			}
	
	
	
	if($rs[status_permit] == "YES"){
		$dis1 = "disabled";
	}else{
		$dis1 = "";
	}
	
	?>
	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะการจ้าง</td>
	  <td>
	    <input name="status_permit" type="radio" value="YES" <? if($rs[status_permit] == "YES"){ echo "checked='checked'";}?> onClick="toDisble(this)" >
	    อยู่ระหว่างการจ้าง 
	    <input name="status_permit" type="radio" value="NO" <? if($rs[status_permit] == "NO"){ echo "checked='checked'";}?>  onClick="toDisble(this)" >
	    เลิกจ้างแล้ว
	  <INPUT name="retire_date" id="retire_date" onFocus="blur();" value="<? if($retire_date != "\\543" ){ echo $retire_date;}?>" size="15" readOnly <?=$dis1?>>
              <INPUT name="button" id="button0" type="button"  onClick="popUpCalendar(this, form1.retire_date, 'dd/mm/yyyy')"value="วันเดือนปี" <?=$dis1?>></td>
    </tr>
	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะพิเศษ</td>
	  <td>
	    <select name="status_extra" onChange="return DisSiteArea(this.value);">
		<option value="NOR" <? if($rs[status_extra] == "NOR"){ echo "selected='selected'";}?>>ปกติ(คีย์ข้อมูล)</option>
		<option value="QC" <? if($rs[status_extra] == "QC"){ echo "selected='selected'";}?>>ตรวจสอบความถูกต้องการบันทึกข้อมูล (QC)</option>
        <option value="QC_WORD" <? if($rs[status_extra] == "QC_WORD"){ echo "selected='selected'";}?>>ตรวจสอบการบันทึกข้อมูล(ตรวจสอบคำผิด)</option>
		<option value="AC" <? if($rs[status_extra] == "AC"){ echo "selected='selected'";}?>>เจ้าหน้าที่บัญชี</option>
        <option value="CALLCENTER" <? if($rs[status_extra] == "CALLCENTER"){ echo "selected='selected'";}?>>เจ้าหน้าที่ Callcenter</option>
         <option value="SCAN" <? if($rs[status_extra] == "SCAN"){ echo "selected='selected'";}?>>เจ้าหน้าที่สแกนเอกสาร ก.พ.7</option>
        <option value="GRAPHIC" <? if($rs[status_extra] == "GRAPHIC"){ echo "selected='selected'";}?>>เจ้าหน้าที่ตัดรูป</option>
         <option value="site_area" <? if($rs[status_extra] == "site_area"){ echo "selected='selected'";}?>>เจ้าหน้าที่ประจำเขต</option>
        </select>
	  </td>
          </tr>
      
      	<tr bgcolor=white valign=top>
      	  <td class="link_back">เลือกเขตพื้นที่การศึกษาที่พนักงานไปประจำ</td>
      	  <td>
          <? if($rs[status_extra] == "site_area"){ $diss = "";}else{ $diss = " disabled";}?>
      	    <select name="site_area" id="site_area" <?=$diss?>>
            <option value="">เลือกเขตพื้นที่การศึกษา</option>
            <?
            $sql_area = "SELECT secid,secname FROM eduarea WHERE secid NOT LIKE '%99%' ORDER BY secname ASC";
			$result_area = mysql_db_query(DB_MASTER,$sql_area);
			while($rsa = mysql_fetch_assoc($result_area)){
				if($rsa[secid] == $rs[site_area]){$sel = " selected='selected'"; }else{ $sel = "";}
					echo "<option value='$rsa[secid]' $sel>$rsa[secname]</option>";
			}
			
			?>
          </select> 
          <?
		   if($rs[date_area] != "" and $rs[date_area] != "0000-00-00"){
			 	 	$xarr_dx = explode("-",$rs[date_area]);
					$date_area = "$xarr_dx[2]/$xarr_dx[1]/".($xarr_dx[0]+543);
			 }
			 ?>
      	    วันทีเริ่มประจำเขต  <INPUT name="date_area" id="date_area" onFocus="blur();" value="<? if($date_area != "//543" ){ echo $date_area;}?>" size="15" readOnly >
            <INPUT name="button" id="button0" type="button"  onClick="popUpCalendar(this, form1.date_area, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
    </tr>
      	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะกลุ่มงานมอบเอกสาร</td>
	  <td>	    <select name="flag_assgin">
      	<option value="">เลือกกลุ่มงานมอบหมายงาน</option>
		<option value="assgin_key" <? if($rs[flag_assgin] == "assgin_key"){ echo "selected='selected'";}?>>กลุ่มบันทึกข้อมูล ก.พ.7</option>
		<option value="assgin_scan" <? if($rs[flag_assgin] == "assgin_scan"){ echo "selected='selected'";}?>>กลุ่มสแกนเอกสาร ก.พ.7</option>
		<option value="assign_checklist" <? if($rs[flag_assgin] == "assign_checklist"){ echo "selected='selected'";}?>>กลุ่มตรวจสอบเอกสาร</option>
        </select>
</td>
    </tr>
     <? if(($utype == "0" and $rs[status_extra] == "NOR") or ($rs[status_extra] == "")){ // เฉพาะกลุ่มที่เป็นพนักงานคีย์ข้อมูลเท่านั้น?>
	<tr bgcolor=white valign=top>
	  <td class="link_back">กลุ่มการคีย์ข้อมูล</td>
	  <td>
      <select name="keyin_group">
      <option value=""> - เลือกกลุ่มการคีย์ข้อมูล - </option>
      <?
      	$sql_group = "SELECT * FROM keystaff_group WHERE status_active='1' ORDER BY groupkey_id ASC";
		$result_group = mysql_db_query($dbnameuse,$sql_group);
		while($rs_g1 = mysql_fetch_assoc($result_group)){
			if($rs[keyin_group] == $rs_g1[groupkey_id]){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
			echo "<option value='$rs_g1[groupkey_id]' $sel1>$rs_g1[groupname]</option>";	
		}//end while($rs_g = mysql_fetch_assoc($result_group)){
	  ?>
      </select>
      <?
      	$sql_ch_date = "SELECT keystaff_log_group.start_date FROM keystaff_log_group Inner Join keystaff ON keystaff_log_group.staffid = keystaff.staffid AND keystaff.keyin_group = keystaff_log_group.keyin_group WHERE keystaff_log_group.staffid =  '$rs[staffid]' order by keystaff_log_group.start_date desc limit 1";
		$result_ch_date = mysql_db_query($dbnameuse,$sql_ch_date);
		$rsch = mysql_fetch_assoc($result_ch_date);
		//echo $rsch[start_date];
		
			$xtemp_pos = strpos($rsch[start_date],"/");
			//echo "xx = $temp_pos";
			if($rsch[start_date] != "0000-00-00" and $xtemp_pos < 1){
			$xarr_dx = explode("-",$rsch[start_date]);
			$date_change = "$xarr_dx[2]/$xarr_dx[1]/".($xarr_dx[0]+543);
			}else if($rsch[start_date] == "0000-00-00"){
			$date_change = "";
			}else{
			$date_change = $rsch[start_date];
			}

	  ?>
      <INPUT name="date_change" id="date_change" onFocus="blur();" value="<? if($date_change != "//543" ){ echo $date_change;}?>" size="15" readOnly >
              <INPUT name="button" id="button0" type="button"  onClick="popUpCalendar(this, form1.date_change, 'dd/mm/yyyy')"value="วันเดือนปี">
      </td>
    </tr>
	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะ QC เคยเป็นพนักงานคีย์ข้อมูล</td>
	  <td><label>
	    <select name="part_keydata" id="part_keydata">
        <option value="0" <? if($rs[part_keydata] == "0"){ echo "selected='selected'";}?>> - ไม่ระบุ - </option>
        <option value="1" <? if($rs[part_keydata] == "1"){ echo "selected='selected'";}?>> เคยเป็นพนักงานคีย์ข้อมูล </option>
	      </select>
      </label></td>
    </tr>
	<? } //end if($utype == "0"){?>
    <tr bgcolor="#888899" valign=top> 
      <td colspan=2 align=right> 
      <input type="hidden" name="xsapphireoffice" value="<?=$xsapphireoffice?>">
	  <input type="hidden" name="utype" value="<?=$utype?>">
        <INPUT TYPE="submit" VALUE="    บันทึก    " CLASS=xbutton>
        <INPUT TYPE="reset" VALUE=" ยกเลิก " class=xbutton ONCLICK="location.href='?org_id=<?=$org_id?>';">	  </td>
    </tr>
  </table>
</form>


<?
//====================================================================
}else if ($_GET[action] == "show" ){
		$sql = "select * from $epm_staff where staffid='$id';";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		if ($rs[sex] == "M") $sex = "man"; else $sex="girl";
?>
<BR>
<table border=0 align=center cellspacing=1 cellpadding=3 bgcolor="#808080" width="98%">
    <tr bgcolor="#a3b2cc"> 
      <td width="150"><FONT COLOR="WHITE" style="font-size:14pt;"><img src="images/<?=$sex?>.gif" align=middle> <B>ข้อมูล<?=$report_title?></B></font></td>
       <td align=right> 
        <INPUT TYPE="reset" VALUE=" แก้ไข " class=xbutton ONCLICK="location.href='?org_id=<?=$org_id?>&id=<?=$id?>&action=edit';">
	  </td>
    </tr>


	<tr bgcolor=white valign=top> 
      <td class="link_back">Username </td>
      <td> <?=$rs[username]?> <input type=button value=" Reset Password" onClick="if(confirm('ต้องการ reset รหัสผ่านของผู้ใช้คนนี้กลับไปเป็น logon ใช่หรือไม่?')) location.href='?org_id=<?=$org_id?>&id=<?=$id?>&action=resetpwd';"></td>
    </tr>


	<tr bgcolor=white valign=top> 
      <td class="link_back">ชื่อ - นามสกุล </td>
      <td><?=$rs[prename]?> <?=$rs[staffname]?> <?=$rs[staffsurname]?> </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">Email Address</td>
      <td><?=$rs[email]?></td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">เลขบัตรประจำตัวประชาชน</td>
      <td><?=$rs[card_id]?></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">สถานะ</td>
	  <td>
	  <?
		$status_array = array("0"=>"เข้าระบบได้ตามปกติ","1"=>"ระงับการเข้าระบบ");	
		echo $status_array[intval($rs[status])];
		?>
	  
	  </select>
	  </td>
</tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ตำแหน่ง</td>
      <td> <?=$rs[title]?></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ที่อยู่</td>
	  <td><?=nl2br($rs[address])?></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">โทรศัพท์</td>
      <td> <?=$rs[telno]?></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">หมายเหตุ</td>
	  <td><?=nl2br($rs[comment])?></td>
    </tr>

    <tr bgcolor="#DDDDEE" > 
	  <td class="link_back" colspan=2><img src="images/users.gif" align=middle> สังกัดกลุ่ม</td>
    </tr>

    <tr bgcolor="white" valign=top> 
	  <td colspan=2>
	  <?
		//echo " &nbsp; &nbsp; &nbsp; <img src='dtree/img/users.gif' > (ทั่วไป) <BR>";
		$sql = "select t2.* from epm_groupmember t1 inner join $epm_staffgroup t2 on t1.gid=t2.gid where t1.staffid='$id';"; 
		$xresult = mysql_db_query($dbnameuse,$sql);
		while ($xrs=mysql_fetch_assoc($xresult)){
			echo " &nbsp; &nbsp; &nbsp; <img src='dtree/img/users.gif' > $xrs[groupname] <BR>";
		}
		?>
	  
	  </td>
    </tr>

</table>

<?
//====================================================================
}else if ($_GET[action] == "import" ){
?>
<H3>นำเข้าข้อมูลจากระบบ Competency</H3>
<FORM METHOD=POST ACTION="">
<INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>">
<INPUT TYPE="hidden" NAME="org_id" VALUE="<?=$org_id?>">
<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=ภ0>ลำดับ</th>
<th>ชื่อ - นามสกุล</th>
<th>ตำแหน่ง</th>
<th width=40>เลือก</th>
</tr>

<?
	$n = 0;
	$sql = "select * from $hr_db.general where unit='$office_id';";
	$result = mysql_query($sql);
	while ($rs = mysql_fetch_assoc($result)){
		if ($n++ %  2) $bgcolor = "#F0F0F0"; else $bgcolor = "#FFFFFF";

?>
<TR BGCOLOR="<?=$bgcolor?>">
<TD ALIGN=CENTER><?=$n?></TD>
<TD ALIGN=LEFT>&nbsp; <?=$rs[prename_th]?> <?=$rs[name_th]?> <?=$rs[surname_th]?></TD>
<TD ALIGN=CENTER><?=$rs[position_now]?></TD>
<TD ALIGN=CENTER><INPUT TYPE="checkbox" NAME="hr_id[]" value="<?=$rs[id]?>"></TD>
</TR>
<?
		} //while
?>
</table>
<P align=right>
<INPUT TYPE="submit" VALUE=" นำเข้าข้อมูลที่เลือก ">
&nbsp;
</P>

</FORM>
<?

  
}else{//ไม่ระบุ action

//====================================================================

?>



<BR>
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td colspan="2" class="fillcolor"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="13%"  bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="org_user.php?xmode="><strong>จัดการข้อมูลผู้ใช้</strong></A></td>
<!--              <td width="26%"  bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="asign_user_key.php?xmode=1"><B><U style="color:<?=$bgcolor?>;">มอบหมายการคีย์ข้อมูลให้กับผู้ใช้</U></B></A></td>
-->              <td width="61%">&nbsp;</td>
            </tr>
          </table></td></tr>
<tr><td width=37><img src="images/user_icon.gif"></td>
<td width="910" align="left"> <B style="font-size: 12pt;">
<?
if ($org_id > 0){	
?>
บุคลากรในหน่วยงาน <?=Query1(" select NLABEL from main_menu  ")?>
<?
}else{	
?>
บุคลากรไม่สังกัดหน่วยงาน 
<?
}	
?>
</B></td>
</tr>

<tr valign=top height=1><td colspan=2><table width="100%" border="0" cellspacing="1" cellpadding="3">
  <? 
		if($utype == "1"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($utype == "0"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
		if($utype == "2"){ $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
		if($utype == "3"){ $fcolor4 = "<font color='#000000'>"; $fcolor_n4 = "</font>"; $bg4 = "#FFFFFF";}else{ $bg4 = "#A5B2CE";} 
	
	?>
  <tr>
    <td width="12%" align="center" bgcolor="<?=$bg1?>"><a href="org_user.php?xmode=&utype=1"><strong>
      <?=$fcolor1?>
      พนักงานประจำ
      <?=$fcolor_n1?>
    </strong></a></td>
    <td width="14%" align="center" bgcolor="<?=$bg2?>"><strong><a href="org_user.php?xmode=&utype=0">
      <?=$fcolor2?>
      ลูกจ้างชั่วคราว
      <?=$fcolor_n2?>
    </a> </strong></td>
    <td width="14%" align="center" bgcolor="<?=$bg3?>"><strong><a href="org_user.php?xmode=&utype=2">
      <?=$fcolor3?>
      Subcontract
      <?=$fcolor_n3?>
    </a> </strong></td>
    <td width="14%" align="center" bgcolor="<?=$bg4?>"><strong><a href="org_user.php?xmode=&utype=3"><?=$fcolor4?>เจ้าหน้าที่ประจำเขต<?=$fcolor_n4?></a></strong></td>
    <td width="46%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
  </tr>
</table></td></tr>

<tr valign=top><td colspan=2>
<BR><BR>
<? if($utype == "2"){?><img src="images/profile_collapsed.gif"> <A HREF="?action=new&org_id=<?=$org_id?>&xsapphireoffice=2">เพิ่มข้อมูลใหม่</A><? }else{?><font color="#FF0000">การเพิ่มข้อมูลพนักงานจะมาจากระบบ face เท่านั้น</font><? }//end if($utype == "2"){?>&nbsp;
|| <a href="org_user.php?xmode=<?=$xmode?>&utype=<?=$utype?>&xtype_view=">ทั้งหมด</a> || <a href="org_user.php?xmode=<?=$xmode?>&utype=<?=$utype?>&xtype_view=Y">อยู่ระหว่างการจ้าง</a> ||<a href="org_user.php?xmode=<?=$xmode?>&utype=<?=$utype?>&xtype_view=N">สิ้นสุดการจ้าง</a>
  (หากมีการเพิ่มข้อมูลในระบบ face แล้วระบบไม่ดึงข้อมูลมาให้ในระบบ userentry ให้ <a href="#" onClick="window.open('form_update_user_form_faceaccess.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=750,height=400')">คลิีก update</a>)</td>

</tr>
</table>


<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
  <th colspan="10"><strong><? if($xtype_view == "Y"){ echo "กลุ่มบุคลที่อยู่ระหว่างการจ้างงาน";}else if($xtype_view == "N"){ echo "กลุ่มบุคลที่สิ้นสุดการจ้างงาน";}else{ echo "กลุ่มบุคลที่อยู่ระหว่างจ้างงานและเลิกจ้างงาน";}?></strong></th>
  </tr>
<tr bgcolor="#a3b2cc">
<th width=47>ลำดับ</th>
<th width="199">ชื่อ - นามสกุล</th>
<!--<th width="114">Username</th>
<th width="122">password</th>-->
<th width="94">รอบทำงาน</th>
<th width="160" bgcolor="#a3b2cc">ประเภทพนักงาน</th>
<th width="118">สถานะการจ้าง</th>
<th width="143">หน้าที่พิเศษ</th>
<th width="221">ประจำเขตพื้นที่</th>
<th width="111">วันที่เริ่มทำงาน</th>
<th width="96">กลุ่มคีย์</th>
<th width=72>&nbsp;</th>
</tr>
<?

	if($utype == "3"){ $conu = " WHERE status_extra='site_area'";}else{
		if($utype != ""){ $utype = $utype;}else{ $utype = 1;}	
			$conu = " WHERE sapphireoffice = '$utype'";
	}
	
	
$n = 0;
if($xtype_view == "Y"){
		$conv1 = " AND status_permit='YES'";
}else if($xtype_view == "N"){
	$conv1 = " AND status_permit='NO'";	
}else{
	$conv1 = "";
}
$sql = "select * from  $epm_staff   $conu  $conv1 ORDER BY keyin_group DESC ";
$result = mysql_query($sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align=center ><?=$n?></td>
<td ><?=$rs[staffname]?> <?=$rs[staffsurname]?></td>
<!--<td valign="middle" ><?=$rs[username]?></td>
<td valign="middle" ><?=$rs[password]?></td>-->
<td align="center" ><? if($rs[status]=="am"){echo "Full Time";}else if($rs[status]=="pm"){echo "Passtime";}else{echo "ไม่ระบุ";}?></td>
<td align="center" ><? if($rs[sapphireoffice]=="0"){echo "ลูกจ้างชั่วคราวบริษัท";}else if($rs[sapphireoffice]=="1"){echo "พนักงานประจำ";}else if($rs[sapphireoffice]=="2"){echo "SubContact";}else{echo "ไม่ระบุ";}?></td>
<td ><? if($rs[status_permit] == "NO"){ echo "ยกเลิกการจ้าง วันที่ ";   echo thai_date($rs[retire_date]);}?></td>
<td align="center" ><? if($rs[status_extra] == "QC"){ echo "ตรวจสอบข้อมูล (QC)";}else if($rs[status_extra] == "AC"){ echo "ผ่ายบัญชี";}else if($rs[status_extra] == "CALLCENTER"){ echo "พนักงาน callcenter";}else if($rs[status_extra] == "GRAPHIC"){ echo "พนักงานตัดรูป";}else if($rs[status_extra] == "QC_WORD"){ echo "พนักงานตรวจสอบคำผิด";}?></td>
<td align="left" ><?
	$sql_a1 = "SELECT secname,secname_short FROM eduarea WHERE secid='$rs[site_area]'";
	$result_a1 = mysql_db_query(DB_MASTER,$sql_a1);
	$rsa1 = mysql_fetch_assoc($result_a1);
	if($rsa1[secname] != ""){
		$date_area = 	thai_date($rs[date_area]);
	}else{
		$date_area = 	"";
	}
	echo $rsa1[secname_short];
?></td>
<td align="center" ><?=$date_area?></td>
<td align="center" ><? 
if($rs[status_extra] != "NOR"){
echo $rs[status_extra];
}else{
$sql_group1 = "SELECT
keystaff_group.groupname
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff.staffid =  '$rs[staffid]'";
$result_group1 = mysql_db_query($dbnameuse,$sql_group1);
$rsg1 = mysql_fetch_assoc($result_group1);
	echo "$rsg1[groupname]";	
}


if($rs[part_keydata] == 1){ echo " :: เคยเป็นพนักงานคีย์ข้อมูล";  }
?></td>
<td align=center>
<?
if($_SESSION[session_sapphire] == "1"){ // เห็นกรณีเป็นเจ้าหน้าที่ sapphire เท่านั้น

if(strstr($rs[username],"admin"))	{
echo "<I>System user</I>";
}else{
	
	
####  ตรวจสอบว่ามีประวัติการเปลี่ยนชื่อกลุ่มมั้ย
$sqlcg = "SELECT COUNT(staffid) AS numc FROM keystaff_log_group WHERE staffid='$rs[staffid]' and keyin_group > 0";
$resultcg = mysql_db_query($dbnameuse,$sqlcg);
$rscg = mysql_fetch_assoc($resultcg);
if($rscg[numc] > 0){
		$hlink = "<a href=\"report_log_change_group.php?xstaffid=$rs[staffid]\" target=\"_blank\"><img src=\"../../images_sys/history.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"คลิ๊กเพื่อดูประวัติการย้ายกลุ่ม\"></a>";
}else{
		$hlink = "";	
}
?>
<a href="?action=edit&xstaffid=<?=$rs['staffid']?>&org_id=<?=$org_id?>&utype=<?=$utype?>"><img src="../../images_sys/b_edit.png" alt="แก้ไข" width="16" height="16" border="0"></a>	&nbsp;&nbsp;<?=$hlink?>
<!--<a href="#" ONCLICK="if (confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')) location.href='?action=delete&xstaffid=<?=$rs['staffid']?>&org_id=<?=$org_id?>&utype=<?=$utype?>';">
<img src="../../images_sys/b_drop.png" alt="ลบข้อมูล" width="16" height="16" border="0"></a>-->
<?
}

}//end if($_SESSION[session_sapphire] == "1"){ 

?></td>
</tr>
<?
}
?>
</table>

<?
}	
?>
<BR><BR>
</BODY>
</HTML>
