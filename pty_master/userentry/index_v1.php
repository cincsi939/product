<?
session_start();
if($_SESSION[session_staffid] == ""){
	echo "<script>alert('กรุณา login เข้าสู่ระบบอีกครั้ง'); </script>";
	header("Location:../../../userentry/login.php");
	die;
}

$path_pdf = "../../../../../edubkk_kp7file/";
$imgpdf = "<img src='../../../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='20' height='21' border='0'>";	

//echo "<pre>";
//print_r($_SESSION);
set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include('function_checkdata.inc.php') ;

if($profile_id == ""){
		$profile_id = LastProfile();
}// end if($profile_id == ""){
//echo "index ";die;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>โปรแกรมตรวจความถูกต้องการบันทึกข้อมูล</title>
<LINK href="../../../../common/style.css" rel=stylesheet type="text/css">
<style type="text/css">
<!--
body {
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#002B48', EndColorStr='#C8E3F1');
	/*background-image: url(../images/interface/bg.gif); */
	background-color: #c8e3f1;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

</style>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>

<script type="text/JavaScript">
<!--


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

</script>

<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
</head>

<body>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td colspan="2" valign="top" bgcolor="#95caea"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%" align="center"><img src="../../hr_report/images/group.png" width="32" height="32" /></td>
        <td width="96%" align="left"><strong>ตรวจสอบกับบันทึกข้อมูลรายบุคคล</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="18%" valign="top" bgcolor="#95caea"><table width="100%" height="300" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td align="center" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top" bgcolor="#CCCCCC">&nbsp;
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="10%"><img src="images/star_green.png" width="16" height="16" /></td>
              <td width="90%" align="left"><a href="index_v1.php?action=browse&profile_id=<?=$profile_id?>"> ตรวจสอบข้อมูลรายบุคคล</a></td>
              </tr>
            <tr>
              <td><img src="images/star_green.png" width="16" height="16" /></td>
              <td align="left"><strong><a href="index.php?action=browse_sys&profile_id=<?=$profile_id?>">ตรวจสอบข้อมูลโดยระบบ</a></strong></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left">&nbsp;</td>
              </tr>
            <tr>
              <td align="center"><img src="images/star_red.png" width="16" height="16" /></td>
              <td align="left"><strong><a href="index.php?action=browse_check&profile_id=<?=$profile_id?>">เทียบข้อมูลกับต้นฉบับ</a></strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr>
              <td align="center"><img src="images/wrench.png" width="20" height="20" /></td>
              <td align="left"><strong><a href="report_qc.php" target="_blank">รายงานที่ต้อง QC</a></strong></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left"><strong><a href="../../../userentry/report_alert_qc1.php" target="_blank">ระบบแจ้งเตือนการ QC</a></strong></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left"><a href="index_temp_qc.php" target="_blank">รายงานจำนวนค้าง QC รายเขต</a></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left"><a href="report_check_data_executive.php" target="_blank">ตรวจข้อมูลผอ.เขต หัวหน้าฝ่าย</a></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="left"><a href="../report_count_area_key_salary.php" target="_blank">รายการการบันทึกข้อมูลตามช่วงเวลา</a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
    <td width="82%" valign="top" bgcolor="#CDE7F5">
    <?
    	if($action == "browse"){
			include("browse.php");
		}else if($action == "browse_sys"){
			include("browse_sys.php");
		}else if($action == "browse_check"){
			include("browse_check.php");	
		}
	?>
    
    </td>
  </tr>
</table>
</body>
</html>
