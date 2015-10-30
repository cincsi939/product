<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_import_pdf"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
//include("checklist.inc.php");
###  กรณี profile_id เป็นค่าว่าง
if($action == "process"){
	$sql = "SELECT * FROM eduarea";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$secname_s = str_replace("ศึกษาศึกษา","ศึกษา",$rs[secname_short]);
		$sql_up = "UPDATE eduarea SET secname_short='$secname_s' WHERE secid='$rs[secid]' ";
		//echo "$sql_up<br>";
		mysql_db_query($dbnamemaster,$sql_up);
		
	}//end while
}//end function NumPersonUpload(){

	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<link href="../../common/jscriptfixcolumn/cssfixtable.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</SCRIPT>

</head>

<body bgcolor="#EFEFFF">
<?
	echo "<a href='?action=process'>ประมวลผล</a>";
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>