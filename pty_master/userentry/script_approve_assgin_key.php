<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
include("../../config/conndb_nonsession.inc.php");
//$limit_sql = " LIMIT 0,5";

if($_SERVER['REQUEST_METHOD'] == "GET"){
	if($action == "process"){
		
	$sql = "SELECT staffid,flag_qc FROM stat_user_keyperson WHERE status_random_qc='1' group by  staffid, flag_qc $limit_sql";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT * FROM stat_user_keyperson WHERE flag_qc='$rs[flag_qc]' AND staffid='$rs[staffid]'";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
			$sql_up = "UPDATE tbl_assign_key SET approve='2'  WHERE idcard='$rs1[idcard]'";
			//echo $sql_up."<br>";
			mysql_db_query($dbnameuse,$sql_up);
				
		}//end while($rs1 = mysql_fetch_assoc($result1)){
	}//end while($rs = mysql_fetch_assoc($result)){	
	
	}//end if($action == "process"){
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	
###### 
if($action == "process1"){
	$sql = "SELECT
validate_checkdata.idcard,
validate_checkdata.staffid
FROM `validate_checkdata`
group by idcard $limit_sql";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT * FROM stat_user_keyperson WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]' order by flag_qc DESC LIMIT 0,1";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[flag_qc] == 0){
				$sql_up = "UPDATE tbl_assign_key SET approve='2'  WHERE idcard='$rs1[idcard]'";
				//echo "up :: ".$sql_up."<br>";
				mysql_db_query($dbnameuse,$sql_up);
		}else{
				$sql2 = "SELECT * FROM stat_user_keyperson WHERE flag_qc='$rs1[flag_qc]' AND staffid='$rs1[staffid]'";	
				$result2 = mysql_db_query($dbnameuse,$sql2);
				while($rs2 = mysql_fetch_assoc($result2)){
					$sql_up1 = "UPDATE tbl_assign_key SET approve='2'  WHERE idcard='$rs2[idcard]' ";	
					//echo "up1 :: ".$sql_up1."<br>";
					mysql_db_query($dbnameuse,$sql_up1);
				}//end while($rs2 = mysql_fetch_assoc($result2)){
		}//end 	if($rs1[flag_qc] == 0){
			
	}//end 	while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process1"){


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
</head>

<body bgcolor="#EFEFFF">
<a href="?action=process">run</a> ||  <a href="?action=process1">ประมวลผลการการQC</a>
</BODY>
</HTML>
