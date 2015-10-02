<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  30/08/2014
 * @access  public
 */
 
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php 
session_start();
header ('Content-type: text/html; charset=utf-8'); 
if($_GET['debug'] == "on"){
	echo "<pre>";
	print_r($_SESSION);
}

#@modify Suwat.k 22/09/2558 หาค่าปีงบประมาณโดยตรวจสอบกับเดือน
$dd = date('m');
if($dd >= 10){
	$yy = (date('Y')+543)+1;
}else{
	$yy = (date('Y')+543);
}
#@end

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>รายงานสรุปข้อมูลการลงทะเบียนเพื่อขอรับสิทธิ์เงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
	$(document).ready(function(){			
		 var newWindowHight = $(window).height();
		 var height = newWindowHight-180;
		  //document.getElementById("ifram").style.height = height+'px';
	});
</script>
<style>
 .style7 {color: #000; font-weight: bold; }
#ppDriverTable th{
	 background:#dfdfdf; /*ปรับสีหัวตาราง แดชบอร์ด*/
 }
 #ifram{
	 overflow: scroll;
 }
#ppDriverTable tbody tr:nth-child(even) {background: #fff} /*ปรับสีสลับช่องตารางแดชบอร์ด*/
#ppDriverTable tbody tr:nth-child(odd) {background: #ebebeb}
#ppDriverTable tbody tr:hover{ background:#FF9}

/* ส่วนกำหนดสำหรับ แสดง iframe  */
div#myiframe_position1{

	position:relative;
	display:block;	
	width:440px; /*ความกว้างส่วนของเนื้อหา iframe ที่ต้องการแสดง*/
	height:250px; /* ความสูงส่วนของเนื้อหา iframe ที่ต้องการแสดง */
	overflow:hidden;
}
/* ส่วนกำหนด สำหรับ iframe */
div#myiframe_position1 iframe{
	position:absolute;
	display:block;
	float:left;
	margin-top:-50px; /* ปรับค่าของ iframe ให้ขยับขึ้นบนตามตำแหน่งที่ต้องการ */
	margin-left:0px; /* ปรับค่าของ iframe ให้ขยับมาด้านซ้ายตามตำแหน่งที่ต้องการ */
}
</style>
</head>

<body>
<?  include "header.php"; ?>
<script type="text/javascript">
  function resizeIframe(iframe) {
    iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
  }
</script> 
<!--<iframe id="rpb_iframe" width="1" height="1" src="http://61.19.255.90/csg_support/application/survey/sp_process.php" align="left" frameborder="0"></iframe> -->
<div>
<iframe id="ifram" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/csg_support/application/reportbuilder_csg/report_preview.php?id=440&yy=<?=$yy?>" width="100%"  frameborder="0" onload="resizeIframe(this)"></iframe>
</div>
<p>
<table width="100%">
	<tr>
      <td></td>
  </tr>
</table>
</p>
</body>
</html>