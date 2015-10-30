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
$date_conf = "2552-10-01";
set_time_limit(0);

if($_SERVER['REQUEST_METHOD'] == "GET"){
	if($action == "process"){
		
	$sql = "SELECT idcard,siteid  FROM `tbl_assign_key` where  nonactive='0' and approve <> '2' group by idcard  ";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sqlx = "SELECT COUNT(idcard) AS numx FROM monitor_keyin WHERE idcard='$rs[idcard]' AND timestamp_key LIKE '2010%' AND timestamp_key LIKE '2009%' ";
		//echo "$dbnameuse  :: ".$sqlx."<br><br>";
		$resultx = mysql_db_query($dbnameuse,$sqlx);
		$rsx = mysql_fetch_assoc($resultx);
		$db_site = STR_PREFIX_DB.$rs[siteid];
		$sql1 = "SELECT COUNT(id) AS num1 FROM salary WHERE id='$rs[idcard]' AND date >= '$date_conf'";
		//echo $db_site." :: ".$sql1."<br><br>";
		$result1 = mysql_db_query($db_site,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			if($rsx[numx] > 0){
					$sql_update = "UPDATE tbl_assign_key SET approve='2',status_keydata='1'  WHERE idcard='$rs[idcard]'";
					//echo $sql_update."<br><br>";
					mysql_db_query($dbnameuse,$sql_update);
					if($rs1[num1] > 0){
							$status_problem = 0;
					}else{
							$status_problem = 1;	
					}
					
								$sql_update1 = "REPLACE INTO temp_idcard_approve_keydata SET idcard='$rs[idcard]' ,siteid='$rs[siteid]',status_problem='$status_problem',flag_id='1'";
			//echo "$sql_update1<br><br>";
			mysql_db_query($dbnameuse,$sql_update1);				

			}
	}//end while($rs = mysql_fetch_assoc($result)){	
	
	}//end if($action == "process"){
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	



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
<a href="?action=process">run</a>
</BODY>
</HTML>
