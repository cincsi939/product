<?
session_start();
include("checklist2.inc.php");

//echo "xxxxx";die;

function CheckidFalseReplace($idcard){
	global $dbname_temp;
	$sqlc = "SELECT COUNT(idcard) as num1 FROM tbl_checklist_kp7 WHERE idcard='$idcard'";
	$resultc = mysql_db_query($dbname_temp,$sqlc);
	$rsc = mysql_fetch_assoc($resultc);
	return $rsc[num1];
}

function GenidcardFalse($sentsecid){
	global $dbname_temp;
	$sysid = GenidcardSys($sentsecid,"10");
	if(Check_IDCard($sysid)){
		if(CheckidFalseReplace($sysid) == "1"){
			GenidcardFalse($sentsecid);		
		}else{
			GenidcardFalse($sentsecid);		
		}
			
	}// end if(Check_IDCard($sysid)){
	return $sysid;
}// end function GenidcardFalse($sentsecid){ 

//echo "เลขบัตร :: <br>";

//echo GenidcardFalse("5001");

$sysid = GenidcardFalse($sentsecid);
//echo $sysid."<br>".ran_digi(10);


if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	//echo "<pre>";
//	print_r($_POST);
	$temp_idcard = CheckNameReplace($name_th,$surname_th,$profile_id,$sentsecid);
	if($temp_idcard != ""){
		echo "<script>if(confirm('การบันทึกข้อมูลพบชื่อนามสกุลที่เหมือนกันในเลขบัตรไม่ถูกต้องตามกรมการปกครองจาก pobec ชื่อที่ซ้ำคือ $name_th $surname_th \\n กด ok เพื่อที่จะเพิ่มข้อมูลเพื่อจะลบเลขบัตรที่ชื่อซ้ำใน pobec หรือกด Cancel เพื่อยกเลิกการบันทึกข้อมูล ')){   }else{ alert('คุณได้ยกเลิกการบันทึกข้อมูลเนื่องจากการเพิ่มเลขบัตรจำลองมีชื่อนามสกุลที่ตรงกับข้อมูลใน pobec');location.href='form_manage_checklist_popup.php?action=$action&xsiteid=$xsiteid&sentsecid=$sentsecid&schoolid=$schoolid&idcard=$idcard&prename_th=$prename_th&name_th=$name_th&surname_th=$surname_th&birthday=$birthday&begindate=$begindate&position_now=$position_now&profile_id=$profile_id';};</script>";		
		/// ทำการ update ข้อมูลเลขบัตรที่ไม่ถูกต้องที่อยู่ใน temp_pobec .ให้ป็นสถานะแก้เสร็จแล้ว
		$sql_upidfalse = "UPDATE  tbl_checklist_kp7_false  SET status_chang_idcard='YES' WHERE idcard='$temp_idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
	//	echo $dbname_temp." :: ".$sql_upidfalse;die;
		mysql_db_query($dbname_temp,$sql_upidfalse);
		
	}
	
	if($school_id > 0){
			$xsent_schoolid = $school_id;
	}else{
			$xsent_schoolid = $schoolid;	
	}//end if($school_id > 0){
		
		//echo $xsent_schoolid;die;
//echo "<pre>";
//print_r($_POST);
		$birthday_int = sw_date_indbthai($birthday);
		$begindate_int = sw_date_indbthai($begindate);
		
		//echo "$birthday_int";die;
		
		
		
		if($birthday_int != ""){
			$arr_rep = check_idreplace($sentsecid,$idcard,$name_th,$surname_th,$birthday_int);
//			echo"<pre>";
//			print_r($arr_rep);
			$temp_msg = $arr_rep['msg']; // ข้อความ error
			$site_rep = $arr_rep['siteid']; //รหัสเขตที่ข้อมูลไปซ้ำ
			if( $temp_msg != ""){
				$msg_err1 = "$temp_msg";
			}else{
				$msg_err1 = "";
			}//end if( $temp_msg != ""){
		}//end if($check_birthday != ""){
		
		### ตรวจสอบข้อมูลในเช็ค list ว่ามีการซ้ำกันหรือไม่
			$arr_rep_ch = CheckIdReplaceChecklist($sentsecid,$idcard,$profile_id);
			if($arr_rep_ch['msg'] != ""){
				$xmsg_err1 = $arr_rep_ch['msg'];
				$xtemp_site1 = $arr_rep_ch['siteid'];
			}else{
				$xmsg_err1 = "";
				$xtemp_site1 = "";
			}
			//echo "$action  :: ";die;\\
			
$arridcmss = CheckReplaceCmss($idcard,$sentsecid);
			
if($xmsg_err1 != ""){

	$txt_msg = "checklist เขตที่ซ้ำคือ".show_area($xtemp_site1);
}
if($msg_err1 != ""){
	$txt_msg = "ข้อมูลซ้ำกันในระบบ cmss เขตที่ซ้ำคือ".show_area($site_rep);
}

/*if($xmsg_err1 != "" or $msg_err1 != ""){
	insert_log_import($sentsecid,$idcard,"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรซ้ำในระบบ","1");
	echo "<script>alert('ไม่สามารถบันทึกได้เนื่องจากเลขบัตรไปซ้ำกับข้อมูลที่มีอยู่ในระบบ');location.href='form_manage_checklist_popup.php?action=$action&xsiteid=$xsiteid&sentsecid=$sentsecid&schoolid=$schoolid&idcard=$idcard&prename_th=$prename_th&name_th=$name_th&surname_th=$surname_th&birthday=$birthday&begindate=$begindate&position_now=$position_now';</script>";
	exit();
	
}else{
*/	//echo "aaa";
#####  ตรวจสอบเลขบัตรก่อนบันทึกเข้าไปในระบบ
if($status_id_false != "1"){
	if(!Check_IDCard($idcard)){
		$xstatus_id_false = "1";	 
	}else{
		$xstatus_id_false = "0";
	}
}else{
	$xstatus_id_false = "1"	;
}

//echo "xstatus_id_false :: $xstatus_id_false";die;

	if($action == "ADD"){
		if($xmsg_err1 != ""){
	insert_log_import($sentsecid,$idcard,"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรซ้ำในระบบ","1");
	echo "<script>alert(\"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรไปซ้ำกับข้อมูลที่มีอยู่ในระบบ $txt_msg\");location.href='form_manage_checklist_popup.php?action=$action&xsiteid=$xsiteid&sentsecid=$sentsecid&schoolid=$schoolid&idcard=$idcard&prename_th=$prename_th&name_th=$name_th&surname_th=$surname_th&birthday=$birthday&begindate=$begindate&position_now=$position_now&profile_id=$profile_id';</script>";
	exit();
		}else if($msg_err1 != ""){
			$sql_select = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
			$result_select = mysql_db_query($dbname_temp,$sql_select);
			$rs_s = mysql_fetch_assoc($result_select);
			
			if($extra == "1"){ $schoolid = $school_id;}else{ $schoolid = $schoolid;} // ตรวจสอบกรณีมีฟอร์มให้เปลี่ยนหน่วยงาน
		$sql = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$sentsecid',sex='$sex', prename_th='$prename_th', name_th='$name_th', surname_th='$surname_th',birthday='$birthday_int', begindate='$begindate_int', position_now='$position_now', profile_id='$profile_id',schoolid='$schoolid',status_id_replace='1',siteid_replace='$site_rep',status_id_false='$xstatus_id_false' ";
		insert_log_import($sentsecid,$idcard,"เพิ่มข้อมูลแต่ข้อมูลซ้ำกันในระบบ cmss","1","$schoolid","$rs_s[siteid]","$rs_s[schoolid]");
			$school_rep = show_school($rs_s[schoolid]);
			$xmsg = "บันทึกข้อมูลแล้ว แต่ข้อมูลไปซ้ำ".$school_rep;
		}else{
		### ตรวจสอบก่อนทำการบันทึก
		$sql_check = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
		$result_check = mysql_db_query($dbname_temp,$sql_check);
		$rs_check = mysql_fetch_assoc($result_check);
		if($extra == "1"){ $schoolid = $school_id;}else{ $schoolid = $schoolid;} // ตรวจสอบกรณีมีฟอร์มให้เปลี่ยนหน่วยงาน
			if($rs_check[idcard] != ""){ // กรณีมีอยู่แล้วแต่ไม่สามารถระบุโรงเรียนได้ให้ update
				$sql = "UPDATE  tbl_checklist_kp7 SET idcard='$xidcard',  sex='$sex',prename_th='$prename_th', name_th='$name_th', surname_th='$surname_th',birthday='$birthday_int', begindate='$begindate_int', position_now='$position_now', schoolid='$schoolid',status_id_false='$xstatus_id_false'  WHERE idcard='$idcard' and siteid='$sentsecid' AND profile_id='$profile_id'";
					UpdateDataCmss($sentsecid,$idcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
							
					
			}else{
			$sql = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$sentsecid',sex='$sex', prename_th='$prename_th', name_th='$name_th', surname_th='$surname_th',birthday='$birthday_int', begindate='$begindate_int', position_now='$position_now', schoolid='$schoolid',profile_id='$profile_id',status_id_false='$xstatus_id_false' ";
			}
			insert_log_import($sentsecid,$idcard,"เพิ่มข้อมูลบุคลากร","1");
		}
	}else if($action == "EDIT"){
		if($extra == "1"){ $schoolid = $school_id;}else{ $schoolid = $schoolid;} // ตรวจสอบกรณีมีฟอร์มให้เปลี่ยนหน่วยงาน
		
	if($xmsg_err1 != ""){
	insert_log_import($sentsecid,$idcard,"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรซ้ำในระบบ","1");
	echo "<script>alert(\"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรไปซ้ำกับข้อมูลที่มีอยู่ในระบบ $txt_msg\");location.href='form_manage_checklist_popup.php?action=$action&xsiteid=$xsiteid&sentsecid=$sentsecid&schoolid=$schoolid&idcard=$idcard&prename_th=$prename_th&name_th=$name_th&surname_th=$surname_th&birthday=$birthday&begindate=$begindate&position_now=$position_now&profile_id=$profile_id';</script>";
	exit();

		}else if($msg_err1 != ""){
		$sql = "UPDATE  tbl_checklist_kp7 SET idcard='$xidcard',sex='$sex', prename_th='$prename_th', name_th='$name_th', surname_th='$surname_th',birthday='$birthday_int', begindate='$begindate_int', position_now='$position_now', schoolid='$schoolid',status_id_replace='1',siteid_replace='$site_rep',profile_id='$profile_id',status_id_false='$xstatus_id_false'  WHERE idcard='$xidcard' and siteid='$sentsecid' AND profile_id='$profile_id'";
		UpdateDataCmss($sentsecid,$xidcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
		insert_log_import($sentsecid,$idcard,"แก้ไขข้อมูลบุคลากรแต่ข้อมูลซ้ำกันในระบบ cmss","1");
		}else{
		$sql = "UPDATE  tbl_checklist_kp7 SET idcard='$xidcard',sex='$sex',prename_th='$prename_th', name_th='$name_th', surname_th='$surname_th',birthday='$birthday_int', begindate='$begindate_int', position_now='$position_now', schoolid='$schoolid',status_id_false='$xstatus_id_false'  WHERE idcard='$xidcard' and siteid='$sentsecid' AND profile_id='$profile_id'";
		UpdateDataCmss($sentsecid,$xidcard,$schoolid);// ตรวจสอบเพื่อ update ฐานข้อมูล cmss
		insert_log_import($sentsecid,$idcard,"แก้ไขข้อมูลบุคลากร","1");
		}
	}
	//echo $sql
	$result = mysql_db_query($dbname_temp,$sql);
	####  กรณีข้อมูลไปซ้ำในระบบ cmss
	if($arridcmss[0] > 0){
		$sql_uptemp1 = "UPDATE tbl_checklist_kp7 SET  status_id_replace='1',siteid_replace='".$arridcmss[1]."' WHERE idcard='$idcard' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_uptemp1);
			
	}//end if($arridcmss[0] > 0){
	
	if($xstatus_id_false == "0"){
		CheckChangeIdcardFrom($idcard,$xidcard,$sentsecid,$profile_id);
	}//end if($xstatus_id_false == "0"){
	//echo "<br>".$sql;  
	
/*	$arrch = CheckNameSurname($idcard,$profile_id);
	$num_name_replace = $arrch['num'];
	$sent_name = $arrch['name_th'];
	$sent_surname = $arrch['surname_th'];
	$sent_siteid = $arrch['siteid'];*/
	if($result){
			if($msg_err1 != ""){
				if($xmsg != ""){ $txt_msg = $xmsg;}else{ $txt_msg = $txt_msg;}
/*					if($extra == "1"){
								echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยแล้ว แต่ $txt_msg\");opener.document.location.reload();window.close();</script>";
								exit();
							
					}else{*/
				echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยแล้ว แต่ $txt_msg\");opener.document.location.reload();window.close();</script>";
				exit();
							
					//}//end 	if($extra == "1"){
		
			}else{
/*					if($extra == "1"){
								echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');opener.document.location.reload();window.close();</script>";
								exit();
					}else{*/
							
								echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');opener.document.location.reload();window.close();</script>";
								exit();
				//	}//end if($extra == "1"){
			}
	}else{
	insert_log_import($sentsecid,$idcard,"ไม่สามารถบันทึกได้เนื่องจากเลขบัตรซ้ำในระบบ","1");
			echo "<script>alert('ไม่สามารถบันทึกได้เนื่องจากข้อมูลซ้ำกันภายในระบบตรวจสอบข้อมูลต้นฉบับ');location.href='form_manage_checklist_popup.php?action=$action&xsiteid=$xsiteid&sentsecid=$sentsecid&schoolid=$schoolid&idcard=$idcard&prename_th=$prename_th&name_th=$name_th&surname_th=$surname_th&birthday=$birthday&begindate=$begindate&position_now=$position_now&profile_id=$profile_id';</script>";
	exit();
	}//end if($result){
	
//}//end if($xmsg_err1 != "" or $msg_err1 != ""){

}//end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function IsNumeric(input){    
var RE = "/^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/";    
return (RE.test(input));  
}  

function checkID(id) { 
	if(! IsNumeric(id)) return false;
	if(id.length != 13) return false;
	for(i=0, sum=0; i < 12; i++)
	sum += parseFloat(id.charAt(i))*(13-i);
	if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
	return true;
} 


function checkFrom_idcard(){
		if(document.form1.status_id_false.checked ==  false){
				if(!checkID(document.form1.idcard.value)){
						//alert(" ! เลขบัตรประจำตัวของท่านไม่ถูกต้องตามกรมการปกครอง กรุณาระบุใหม่อีกครั้ง");
						
						document.getElementById("save_data").disabled=true;
						document.getElementById("txt_alt").innerHTML = " *เลขบัตรประจำตัวของท่านไม่ถูกต้องตามกรมการปกครอง";
					
						
				//		document.form1.idcard.focus();
//						return false;
					}else{
						document.getElementById("save_data").disabled=false;
						document.getElementById("txt_alt").innerHTML = "";
					}
	}
		//return true;
}//end function CheckForm(){

function EnableSave(){
	if( document.form1.status_id_false.checked ==  true){
		document.getElementById("save_data").disabled=false;	
	}else{
			checkFrom_idcard();
	}
}


function checkFrom(){

	if(document.form1.idcard.value == "" && document.form1.status_id_false.checked ==  false ){
		alert("เลขบัตรไม่ต้องเป็นค่าว่าง");
		document.form1.idcard.focus();
		return false;
	}
	if(document.form1.prename_th.value == ""){
		alert("คำนำหน้าชื่อไม่ควรเป็นค่าว่าง");
		document.form1.prename_th.focus();
		return false;
	}
	if(document.form1.name_th.value == ""){
		alert("ชื่อไม่ควรเป็นค่าว่าง");
		document.form1.name_th.focus();
		return false;
	}
	if(document.form1.surname_th.value == ""){
		alert("นามสกุลไม่ควรเป็นค่าว่าง");
		document.form1.surname_th.focus();
		return false;
	}
	/*if(document.form1.birthday.value == "" || document.form1.birthday.value == "00/00/0000"){
		alert("วันเกิดไม่ควรเป็นค่าว่าง");
		document.form1.birthday.focus();
		return false;
	}
	
	if(document.form1.begindate.value == "" || document.form1.begindate.value == "00/00/0000"){
		alert("วันเริ่มปฏิบัติราชการไม่ควรเป็นค่าว่าง");
		document.form1.begindate.focus();
		return false;
	}*/
	if(document.form1.position_now.value == ""){
		alert("ตำแหน่งไม่ควรเป็นค่าว่าง");
		document.form1.position_now.focus();
		return false;
	}
	return true;
}

//////////////////////////////////////////////////////////////////////////
	
function Getgenidcard() {
  var xidcard = "<?=$sysid?>";
   if(document.form1.status_id_false.checked == true){
	 	document.form1.idcard.value=xidcard; 
	}else{
		document.form1.idcard.value=""; 	
	}
 
  // document.getElementById("idcard").innerHTML = "xidcard";
}
    
</script>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<?
	if($action == "ADD"){
		$txt_title = "ฟอร์มเพิ่มข้อมูลบุคลากรระบบตรวจสอบข้อมูล ก.พ.7 ต้นฉบับ";
//		$idcard = $_POST[idcard];
//		$prename_th = $_POST[prename_th];
//		$name_th = $_POST[name_th];
//		$surname_th = $_POST[surname_th];
//		$birthday = $_POST[birthday];
//		$begindate = $_POST[begindate];
//		$position_now = $_POST[position_now];
	}else if($action == "EDIT"){
		$txt_title = "ฟอร์มแก้ไขข้อมูลบุคลากรระบบตรวจสอบข้อมูล ก.พ.7 ต้นฉบับ";
		$sql_e = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND idcard='$idcard' AND profile_id='$profile_id'";
		$result_e = mysql_db_query($dbname_temp,$sql_e);
		$rs_e = mysql_fetch_assoc($result_e);
		$xidcard = $rs_e[idcard];
		$prename_th = $rs_e[prename_th];
		$name_th = $rs_e[name_th];
		$surname_th = $rs_e[surname_th];
		$birthday = $rs_e[birthday];
		$begindate = $rs_e[begindate];
		$position_now = $rs_e[position_now];
		$xidcard = $rs_e[idcard];
		
	}
	//echo $action;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="" onSubmit="return checkFrom()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" bgcolor="#BBC9FF"><img src="../../images_sys/home.gif" width="20" height="20" alt="ย้อนกลับ" onClick="location.href='check_kp7_area.php?action=&xsiteid=<?=$xsiteid?>&sentsecid=<?=$sentsecid?>&schoolid=<?=$schoolid?>&profile_id=<?=$profile_id?>'" style="cursor:hand">&nbsp;<strong>
                <?=$txt_title?>&nbsp;&nbsp;<?=show_area($sentsecid)?></strong> ||  <a href="form_check_replace.php?profile_id=<?=$profile_id?>" target="_blank">คลิ๊กเพื่อตรวจสอบข้อมูลก่อนเพิ่ม</a></td>
              </tr>
            <tr>
              <td colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td width="16%" align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน : </strong></td>
              <td width="84%" align="left" bgcolor="#FFFFFF">
                <input name="idcard" type="text" id="idcard" size="25" onBlur="return checkFrom_idcard(this.value)"  value="<?=$idcard?>">
                <? if($action == "ADD"){ ?>
                <input type="checkbox" name="status_id_false" id="status_id_false" value="1" onClick="return Getgenidcard(this.value); return EnableSave(this.value);">
                เลือกกรณีเลขบัตรไม่สมบูรณ์
                <? } //end if($action == "ADD"){?>
           </td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>คำนำหน้าชื่อ : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><label>
                <select name="prename_th">
				<option value=""> - ระบุคำนำหน้าชื่อ - </option>
				<?
					$sql_pre = "SELECT * FROM prename_th  WHERE prename <> '' ORDER BY prename ASC";
					$result_pre = mysql_db_query($dbnamemaster,$sql_pre);
					while($rs_p = mysql_fetch_assoc($result_pre)){
						if($rs_p[prename] == $prename_th){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_p[prename]' $sel>$rs_p[prename]</option>";
					}
				?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><label>
                <input name="name_th" type="text" id="name_th" size="25" value="<?=$name_th?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>นามสกุล : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><label>
                <input name="surname_th" type="text" id="surname_th" size="25" value="<?=$surname_th?>">
              </label></td>
            </tr>
			<?
				if($action == "EDIT"){
					$xbirthday = sw_date_show($birthday);
					$xbegindate = sw_date_show($begindate);
				}else if($action == "ADD"){
					$xbirthday = $birthday;
					$xbegindate = $begindate;
				}
				
			?>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>เพศ : </strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <select name="sex" id="sex">
                <option value="">ระบุเพศ</option>
                <option value="1" <? if($rs_e[sex] == "1"){ echo "selected";}?>>ชาย</option>
                <option value="2" <? if($rs_e[sex] == "2"){ echo "selected";}?>> หญิง</option>
                </select></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>วันเดือนปีเกิด : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><INPUT name="birthday" onFocus="blur();" value="<?=$xbirthday?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.birthday, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>วันเริ่มปฏิบัติราชการ : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><INPUT name="begindate" onFocus="blur();" value="<?=$xbegindate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.begindate, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><label>
                <select name="position_now" id="position_now">
				<option value=""> - ระบุตำแหน่ง - </option>
				<?
					$sql_post = "SELECT * FROM hr_addposition_now  WHERE  status_active='yes' ORDER BY orderby ASC";
					$result_post = mysql_db_query($dbnamemaster,$sql_post);
					while($rs_post = mysql_fetch_assoc($result_post)){
						if($rs_post[position] == $position_now){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_post[position]' $sel>$rs_post[position]</option>";
						
					}
				?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>โรงเรียน : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><label>

				<?
					if($extra == "1"){ // กรณีต้องการแก้ไขหน่วยงาน
					  echo "<select name='school_id' id='school_id'>";
					  echo "<option value='0'> - กรุณาระบุหน่วยงานสังกัด</option>";
						$sql_school = "SELECT * FROM allschool WHERE siteid='$sentsecid' ORDER BY office ASC";  	
						$result_school = mysql_db_query($dbnamemaster,$sql_school);
						while($rs_sch = mysql_fetch_assoc($result_school)){
							if($rs_sch[id] == $schoolid){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$rs_sch[id]' $sel>$rs_sch[office]</option>";
						}
               		echo "</select>";
						
					}else{
					$sql_school = "SELECT * FROM allschool WHERE siteid='$sentsecid' and id='$schoolid' ";
					$result_school = mysql_db_query($dbnamemaster,$sql_school);
					$rs_sch = mysql_fetch_assoc($result_school);
					echo "$rs_sch[office]";
					} 
				?>
                 </label>
                <? if($extra != "1"){?>
              <a href="form_manage_checklist_popup.php?action=EDIT&sentsecid=<?=$sentsecid?>&idcard=<?=$idcard?>&fullname=<?=$fullname?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&extra=1&profile_id=<?=$profile_id?>">คลิ๊กเพื่อแก้ไขหน่วยงาน</a>
              <?
				}else{
			  ?>
               <a href="form_manage_checklist_popup.php?action=EDIT&sentsecid=<?=$sentsecid?>&idcard=<?=$idcard?>&fullname=<?=$fullname?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">ยกเลิกแก้ไขหน่วยงาน</a>
              <?
				}//end 
			  ?>
             </td>
            </tr>
          
            <tr>
              <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><label>
              <input type="hidden" name="profile_id" value="<?=$profile_id?>">
			  <input type="hidden" name="schoolid" value="<?=$schoolid?>">
			  <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
			  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
			  <input type="hidden" name="action" value="<?=$action?>">
              <input type="hidden" name="xidcard" value="<?=$xidcard?>">
              <input type="hidden" name="extra" value="<?=$extra?>">
                <input type="submit" name="Submit"  id="save_data"value="บันทึก" >
                <input type="reset" name="Submit2" value="ล้างข้อมูล">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><font color="#FF0000"><div id="txt_alt"></div></font></td>
            </tr>
          </table></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
