<?
session_start();
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");

if($action == "process"){
		
		$sql = "SELECT * FROM tbl_checklist_log_uploadfile ORDER BY idcard ASC";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$urlfile = $rs[kp7file];
				if(file_exists($urlfile)){
					echo "<a href='$urlfile' target='_blank'> $rs[idcard] $rs[date_upload]</a><br>";	
					$sql_check = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_kp7 WHERE flag_uploadfalse='0' AND idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' ";
					$result = mysql_db_query($dbname_temp,$sql_check);
					$rsc = mysql_fetch_assoc($result);
					if($rsc[num1] > 0){
							$sql_up = "UPDATE tbl_checklist_kp7 SET flag_uploadfalse='1' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
							mysql_db_query($dbname_temp,$sql_up);
					}
				}else{
//					$sql_del = "DELETE FROM tbl_checklist_log_uploadfile WHERE idcard='$rs[idcard]' AND date_upload='$rs[date_upload]' AND profile_id='$rs[profile_id]'";
//					//echo "$sql_del<br>";
//					mysql_db_query($dbname_temp,$sql_del);
//					$sql_checklist = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_log_uploadfile  WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'";
//					$result_checklist=  mysql_db_query($dbname_temp,$sql_checklist);
//					$rsc= mysql_fetch_assoc($result_checklist);
//					if($rsc[num1] < 1){
//							$sql_update = "UPDATE tbl_checklist_kp7 SET flag_uploadfalse='0' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' ";
//							mysql_db_query($dbname_temp,$sql_update);
//					}//end 	if($rsc[num1] < 1){
//						//echo "<a href='$urlfile' target='_blank'> $urlfile </a><br>";	
				}
		}
			
}//end if($action == "process"){
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/tooltip_checklist/css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/tooltip_checklist/jquery_1_3_2.js"></script>
<script src="../../common/tooltip_checklist/script.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
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
.style1 {color: #006600}
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
<a href="?action=process">ประมวลผลรายการ</a>
</body>
</html>
