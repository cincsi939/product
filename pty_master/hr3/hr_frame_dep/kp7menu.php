<?	
session_start();
include("../hr_report/libary/config.inc.php");
//function ที่ใช้แสดงวันที่แบบไทย
function daythai($temp){
if($temp != "0000-00-00"){
	$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$num = explode("-", $temp);			
	if($num[0] == "0000"){
	  $date = "ไม่ระบุ";
	} else {
	  $tyear = $num[0] +  543;
	  $date = intval($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}
} else { 	$date = "ไม่ระบุ"; }	
return $date;
}

$sql 			= " select t1.name_th, t1.surname_th, t2.office, t1.approve_status as approve_status from general t1 left join login t2 on t1.unit = t2.id where t1.id='$id'; ";
$result 		= mysql_query($sql);
$rs 			= mysql_fetch_assoc($result);
$thistime 	= daythai(date("Y-m-d"))." เวลา ".date("H:s")." น. ";
$thisname	= " $rs[name_th] &nbsp; $rs[surname_th] &nbsp; &nbsp; หน่วยงาน $rs[office]  &nbsp;&nbsp;  ";
mysql_free_result($result);
//unset($sql,$rs);


if($_SERVER['REQUEST_METHOD'] == "POST"){
	#====================================================================> Start หาอีก 3 เดือนวันที่เท่าใหร่ 
	$sql = " SELECT date(DATE_SUB( NOW() , INTERVAL -3 MONTH ) ) AS new_expire    "; 
	$result	= mysql_query($sql) ; 
	$rs = mysql_fetch_assoc($result) ; 
	$xexpire = $rs[new_expire]  ;
	#==================================================================== > END หาอีก 3 เดือนวันที่เท่าใหร่ 
	if ($request_type != "99999"){ $comment  = "request_type"; }  
#	$sql		= " insert into req_print_kp7 set id='$id', request_type='$request_type', comment='$comment', request_time='".date("Y-m-d H:i:s")."'; ";	
	$sql		= " INSERT INTO req_print_kp7 SET id='$id', request_type='$request_type', comment='$comment', 
	request_time=NOW() , expire_date='$xexpire'  ";	
	$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());	
	$insertid = mysql_insert_id() ;
	
	
	echo "
	<link href=\"../../../common/style.css\" rel=\"stylesheet\" type=\"text/css\">
	<table width=\"95%\" cellspacing=\"1\" cellpadding=\"2\" align=\"center\" bgcolor=\"#808080\">
	<tr bgcolor=\"#000066\">
	  <td height=\"25\"><font style=\"font-weight:bold; color:#FFFFFF;\">".$thisname."</font></td>
	</tr>
	<tr bgcolor=\"#000066\">
	  <td height=\"25\"><font style=\"font-weight:bold; color:#FFFFFF;\">".$thistime."</font> </td>
	</tr>
	<tr bgcolor=\"#ffffff\">
		<td>
		&nbsp;-&nbsp;<img src=\"../images/krut-icon.gif\" width=\"22\" height=\"25\" align=\"absmiddle\" />
		<a href=\"../hr_report/kp7.php?id=".$id."&request_type=$request_type&insertid=$insertid\" target=\"_blank\">รายงานข้อมูลบุคลากรตามแฟ้มประวัติข้าราชการ(ก.พ.7)</a>
		
		
		<a href=\"../hr_report/kp7_2..php?id=$id&request_type=$request_type&insertid=$insertid\" target=\"_blank\"></a>
		
		</td>
	</tr>
	<tr bgcolor=\"#ffffff\" align=\"center\">
		<td><button onclick=\"window.location.href('".$PHP_SELF."')\">กลับสู่เมนูหลัก</button></td>
	</tr>	
	</table>	
 
	";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
<link href="../hr_report/example.css" rel="stylesheet" type="text/css">
<title>ตรวจสอบความถูกต้องของข้อมูล</title>
<script language="javascript">
function popup(){
	
	var url			= "kp7confirm.php?id=<?=$id?>";
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=no,resizable=no,width=500,height=300,top=200');
	newwin.focus();
	return true;

}

function popup2(){
	var url			= "kp7req_notapprove.php?id=<?=$id?>";
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=yes,resizable=yes,width=700,height=500,top=100');
	newwin.focus();
	return true;

}

function check(){
	
	if(document.post.request_type.selectedIndex == 0){
		alert("ระบุประเภทคำร้อง");
		document.post.request_type.focus();
		return false;
	} else if (document.post.request_type.selectedIndex == 6 && document.post.comment.value.length == 0){
		alert("ถ้าท่านระบุประเภทคำร้องเป็นอื่น ๆ ให้กรอกรายละเอียดเพิ่มเติม");
		document.post.comment.focus();
		return false;
	} else {
		return true;
	}
	
}	

function showComment(val){
	if(val == "99999" ){
		document.getElementById("comm").style.display = "block";
	} else {
		document.getElementById("comm").style.display = "none";
	}
}
</script>
</head>
<body>
<? 
if($action=="request"){ 
#$type		= array("เลือกประเภท","เพื่อใช้เป็นสำเนาเอกสาร ก.พ.7", "เพื่อใช้ยื่นประกอบการพิจารณาเลื่อนขั้น", "เพื่อใช้ยื่นประกอบการพิจารณาเลื่อนวิทยฐานะ",	"เพื่อใช้เป็นเอกสารประกอบการขอย้าย", "เพื่อใช้ยื่นสมัครสินเชื่อกับธนาคารพาณิชย์", "เพื่อใช้ยื่นประกอบการขอเครื่องราชฯ", "เพื่อใช้ยื่นประกอบการสมัครสอบ", "เพื่อใช้ยื่นประกอบการเก็บแฟ้มสะสมงาน","อื่น ๆ ระบุ");  
#========================================================================================
$type[0] = "เลือกประเภท"  ; 
$sql = " SELECT * FROM `req_print_kp7_label` ";
$result = mysql_db_query($dbnamemaster , $sql) ; 
while($rs = mysql_fetch_assoc($result)){
	$type[$rs[reqid]] = $rs[label] ; 
} ########### while($rs = mysql_fetch_assoc($result)){	
#echo "  <hr>====== $dbnamemaster  <div> ";			print_r($type) ; 
 
?>
<form name="post" method="post" action="<?=$PHP_SELF?>?id=<?=$id?>" onsubmit="return check();">
<table width="95%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#000066">
  <td height="25" colspan="2"><font style=" font-weight:bold; color:#FFFFFF;"><?=$thisname?></font></td>
</tr>
<tr bgcolor="#000066">
  <td height="25" colspan="2"><font style="font-weight:bold; color:#FFFFFF;"><?=$thistime?></font> </td>
</tr>
<tr bgcolor="#ffffff">
	<td width="45%" height="25" align="right">ท่านต้องการนำเอกสารก.พ.7 ไปใช้งานในกรณี&nbsp;<b>:</b>&nbsp;</td>
    <td width="55%">
<select name="request_type" style="width:220px;" onchange="showComment(this.value);">
<?
#for($i=0;$i<count($type);$i++){

while (list ($i, $val_label) = each ($type)) {
	echo "<option value=\"".$i."\">".$val_label ."</option>";
}
?>
	</select>		
	</td>
</tr>
<tr bgcolor="#ffffff" valign="top" id="comm" style="display:none;">
	<td height="25" align="right">รายละเอียด&nbsp;<b>:</b>&nbsp;</td>
	<td><textarea name="comment" style="width:98%; height:100px;"></textarea></td>
</tr>
<tr bgcolor="#eeeeee" align="center">
	<td height="25" colspan="2"><input type="submit" value="บันทึกรายการ" />
	  &nbsp; 
	  <input type="button" name="Button" value="ย้อนกลับ" onclick="history.go(-1) " /></td>
</tr>
</table> 
</form>
<? } else { ?>
<table width="95%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#000066">
  <td height="25"><font style=" font-weight:bold; color:#FFFFFF;"><?=$thisname?></font></td>
</tr>
<tr bgcolor="#000066">
  <td height="25"><font style="font-weight:bold; color:#FFFFFF;"><?=$thistime?></font> </td>
</tr>
<tr bgcolor="#ffffff">
    <td height="25">&nbsp;- 
	<img src="../images/krut-icon.gif" width="22" height="25" align="absmiddle" />
	<a href="?id=<?=$id?>&action=request">รายงานข้อมูลบุคลากรตามแฟ้มประวัติข้าราชการ(ก.พ.7)</a> 

	</td>
</tr>
<tr bgcolor="#ffffff">
    <td height="25">
<?
$nowsecid = $_SESSION[secid] ;  
if  ( $nowsecid == 5001 OR $nowsecid == 5002 OR $nowsecid == 5003 OR $nowsecid == 5004 OR $nowsecid == 5005  ){
	$area_phase1 = "yes" ; 
}else{ 
	$area_phase1 = "" ; 
} ######## END  if  ( $nowsecid == 5001 OR $nowsecid == 5002 OR $nowsecid == .............
if($rs[approve_status] == "approve"){
	//echo "&nbsp;-&nbsp;ยืนยันความถูกต้องของข้อมูล";
} else {
	//echo "&nbsp;-&nbsp;<a href=\"#\" onclick=\"popup()\">ยืนยันความถูกต้องของข้อมูล</a>";
}	
?>	</td>
</tr>
<!--   -->

<tr bgcolor="#ffffff">
  <td height="25">
<? 
/*         */	        
#echo " == $area_phase1  ";
//if($rs[approve_status] == "approve"  AND $area_phase1 == "" ){
	//echo "&nbsp;-&nbsp;<a href=\"#\" onclick=\"popup2()\">แจ้งความจำนงการปรับปรุงข้อมูล</a>"; 
//} else {
//	echo "&nbsp;-&nbsp;แจ้งความจำนงการปรับปรุงข้อมูล";
//}
?>  </td>
</tr>
</table>
<? } ?>
<br />
<a href="logout_edit.php" target="_top"></a>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td align="right">
	<a href="../hr_report/logout_edit.php" target="_top">
	<img src="../../../images_sys/logout.jpg" alt="ออกจากระบบ" width="75" height="25" border="0" class="fillcolor_topdown" /></a>
	</td>
</tr>
</table>
</body>
</html>