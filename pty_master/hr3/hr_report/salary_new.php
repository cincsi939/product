<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_salary";
$module_code 		= "salary_new"; 
$process_id			= "salary_new";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
//include("checklogin.php");
include("../../../config/phpconfig.php");
include("inc/libary.php");
//conn2DB();

$namevit = array( "ผอ.สพท." => array( "เชี่ยวชาญ","เชี่ยวชาญพิเศษ"),"รอง ผอ.สพท." => array("เชี่ยวชาญ","ชำนาญการพิเศษ"),"ผอ." => array("ชำนาญการ","ชำนาญการพิเศษ","เชี่ยวชาญ","เชี่ยวชาญพิเศษ"),"รอง ผอ." => array("ชำนาญการ","ชำนาญการพิเศษ","เชี่ยวชาญ","เชี่ยวชาญพิเศษ"),"ศน." => array("ชำนาญการ","ชำนาญการพิเศษ","เชี่ยวชาญ","เชี่ยวชาญพิเศษ"),"ครู" => array("ชำนาญการ","ชำนาญการพิเศษ","เชี่ยวชาญ","เชี่ยวชาญพิเศษ") );

if ($_SERVER[REQUEST_METHOD] == "POST"){

add_log("ข้อมูลเงินเดือน",$id,$action);
$pls			= trim($pls);
$pls			= wordwrap($pls, 65, "\n", true);
$dateorder	= ($checkdateorder == 1) ? "" : $dateorder_year.'-'.$dateorder_month.'-'.$dateorder_day ;

if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update salary set runno='".$runno[$i]."' where id='".$id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	header("Location: ?id=$id&action=viewAll");
	exit;
}

	$date 		= $salary_year.'-'.$salary_month.'-'.$salary_day;
  	$result 		= mysql_query(" select max(runno) as runno from salary where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  	$rs			= mysql_fetch_assoc($result);
  	$runno		= ($rs[runno] <= 0) ? 1 : ($rs[runno] + 1);
	mysql_free_result($result);
	unset($rs);
 //echo $runid.$id;
if($_POST[action]=='edit2'){
$strUpdate="update salary set position='$hr_addposition', salary='$salary', noorder='$noorder', date='$date', dateorder='$dateorder', noposition='$noposition', radub='$hr_addradub', instruct='$instruct', pls='$pls', ch_position='$ch_position', ch_salary='$ch_salary', ch_radub='$ch_radub', pos_name='$pos_name', pos_group='$pos_group' where id='$id' and runid='$runid'";
//$sql="update  salary set  date='$date', position='$hr_addposition', noposition='$noposition', radub='$hr_addradub', salary='$salary',";
//	$sql	.= " upgrade='$upgrade', note='$note', noorder='$noorder', pls='$pls', ch_position='$ch_position', ch_salary='$ch_salary',";
//	$sql	.= " ch_radub='$ch_radub', dateorder='$dateorder', pos_name='$pos_name', pos_group='$pos_group', instruct='$instruct' where id='$id' and runid='$runid';";	
	mysql_query($strUpdate) or die(mysql_error());
	if($vitaya_sts == 1 && $vitaya != "" ){
		$resultx = mysql_query(" SELECT  name  FROM  vitaya_stat  WHERE    id ='$id'  AND  name = '$vitaya' ");
		$numrows_ch = mysql_num_rows($resultx);
		if($numrows_ch > 0){
		$sql_update =  " UPDATE    vitaya_stat  SET  date_start = '$date', date_command = '$dateorder' , name = '$vitaya' , remark = '$noorder' WHERE   id ='$id'  AND  name = '$vitaya'  " ;
		mysql_query($sql_update);
		}else{
		$sql_insert =  " REPLACE  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder')  " ;
		mysql_query($sql_insert);
		}
	}
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
					location.href='?id=$id&action=edit#keys';
				</script>
				";
	//header("Location: ?id=$id&action=edit#keys");
	exit;

} else {

	$sql 	= "INSERT INTO salary (id, date, position, noposition, radub, salary, `upgrade`, note, noorder, ch_position, ch_radub, ch_salary, pls, dateorder, pos_name,pos_group, runno,instruct) VALUES ('$id', '$date', '$hr_addposition', '$noposition', '$hr_addradub', '$salary', '$upgrade', '$note', '$noorder', ";
	$sql	.= " '$ch_position', '$ch_radub','$ch_salary','$pls','$dateorder','$pos_name','$pos_group', '$runno','$instruct') ";		
	mysql_query($sql)or die("Query line ". __LINE__ ." error<br> $sql <hr>".mysql_error());
	
	// ======= INPUT  VITAYATHANA===========
	if( $vitaya_sts == 1 && $vitaya != "" ){
		$sql_insert =  " REPLACE  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder')  " ;
		//echo "$sql_insert";die;
		mysql_query($sql_insert);
	}
	//+++++++++++++++++++++++++++++++
	
		echo "
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit#keys';
				</script>
				";
//	header("Location: ?id=$id&action=edit#keys");
	exit;
				
}
				

} elseif($_GET[action] == 'delete') {

	add_log("ข้อมูลเงินเดือน",$id,$action);
	mysql_query("delete from salary where id = $id and runid='$runid';")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	header("Location: ?id=$id&action=edit");
	 echo"<meta http-equiv='refresh' content='0;URL=salary_new.php'>";
	exit;
	
} else {		
	
	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rs		=mysql_fetch_array($result,MYSQL_ASSOC);
	//
		$strSalary=mysql_query("SELECT * FROM salary WHERE id='$id' and runid='$runid'");
		$strRS=mysql_fetch_assoc($strSalary);
	//
	$sqlx 		= "select * from  vitaya_stat  where id='$id' AND date_start='".$strRS[dateorder]."'";
	$resultx 	= mysql_query($sqlx)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rsx		= mysql_fetch_array($resultx,MYSQL_ASSOC);

}
?>
<html>
<head>
<title>เงินเดือน</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {  
	margin				: 0px  0px; 
	padding				: 0px  0px;
}

a:link { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:visited { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:active { 
	color					: #0099FF; 
	text-decoration	: underline
}

a:hover { 
	color					: #0099FF; 
	text-decoration	: underline;
}

.style1 {
	color					: #FFFFFF;
	font-weight		: bold;
}

</style>
<script language="javascript">
window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");
window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");

function ylib_Browser()
{
	d				= document;
	this.agt		= navigator.userAgent.toLowerCase();
	this.major	= parseInt(navigator.appVersion);
	this.dom	= (d.getElementById)?1:0;
	this.ns		= (d.layers);
	this.ns4up	= (this.ns && this.major >=4);
	this.ns6	= (this.dom&&navigator.appName=="Netscape");
	this.op 		= (window.opera? 1:0);
	this.ie		= (d.all);
	this.ie4		= (d.all&&!this.dom)?1:0;
	this.ie4up	= (this.ie && this.major >= 4);
	this.ie5		= (d.all&&this.dom);
	this.win	= ((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac	= (this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

function DisplayElement ( elt, displayValue ) {
	if ( typeof elt == "string" )
		elt = document.getElementById( elt );
	if ( elt == null ) return;
	if ( oBw && oBw.ns6 ) {
		// OTW table formatting will be lost:
		if ( displayValue == "block" && elt.tagName == "TR" )
			displayValue = "table-row";
		else if ( displayValue == "inline" && elt.tagName == "TR" )
			displayValue = "table-cell";
	}

	elt.style.display = displayValue;
}

function insert_bline(id, siteid)
{
	var url			= "bline_popup.php?kid=" + id + "&siteid=" + siteid;
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=no,resizable=no,width=500,height=370,top=200');
	newwin.focus();
} 

function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=yes,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}

function onSelect(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 


function check(){
	if(document.post.noorder.value.length == 0){
		alert("ระบุหมายเลขคำสั่ง");
		document.post.noorder.focus();
		return false;
	}else if(document.post.pls.value == ""){
		alert("กรุณาระบุช่อง หมายเหตุ( สำหรับกรอกข้อมูลตำแหน่ง ) \n เพื่อนำไปแสดงในช่องตำแหน่ง ในเอกสาร กพ.7 ");
		document.post.pls.focus();
		return false;
	}else if(document.post.vitaya_sts[1].checked = true){
		if(document.post.vitaya.value == 0){
			//alert(" กรุณาเลือกวิทยฐานะที่ได้รับ " );
			//document.post.vitaya.focus();
			//return false;
		}
	}else {
		return true;
	}
}

function check_radio(){
		document.post.vitaya_sts[1].checked = true;
}
</script>
</head>
<body bgcolor="#A3B2CC" <?=$onload?>>
<? if($action == "viewAll"){ ?>
<?
$i 			= 0;
$result 	= mysql_query("select * from salary where id='$id' order by runno asc;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>&nbsp;<a href="kp7_salary.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > ตรวจสอบเอกสารข้อมูล กพ7. อิเล็กทรอนิก </a> 
<table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr> 
	<td><b>ชื่อ / สกุล &nbsp;<u><?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></u></b> </td>
</tr>
</table>
<form name="form1" method="post" action="<?=$PHP_SELF?>">			
<input type="hidden" name="action" value="changeRow">
<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#A3B2CC" align="center">
<td colspan="11" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง</span></td>
</tr>
<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
	<td width="3%" rowspan="2">ลำดับใหม่</td>
	<td colspan="2">คำสั่ง</td> 
	<td width="12%" rowspan="2">วัน เดือน ปี</td>
	<td width="17%" rowspan="2">ตำแหน่ง</td>
	<td width="8%" rowspan="2">เลขที่<br>ตำแหน่ง</td>
	<td width="5%" rowspan="2">ระดับ</td>
	<td width="9%" rowspan="2">อัตรา<br>เงินเดือน</td>
	<td width="21%" rowspan="2">หมายเหตุ</td>
	<td width="2%" rowspan="2">&nbsp;</td>    
</tr>
<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
	<td width="11%">เลขที่</td>
	<td width="12%">วันที่</td>
</tr>
<?
while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}
$sql_1 = " SELECT  *  FROM  vitaya_stat   WHERE  vitaya_stat.date_command = '$rs[dateorder]'  AND  vitaya_stat.date_start = '$rs[date]'  AND vitaya_stat.id = '$id'  ";
$result_1= mysql_db_query($hr_dbname,$sql_1) ;
$rs_1 = mysql_fetch_assoc($result_1);

if($rs_1[id] != ""){
	$showvit = "<img src=\"../../../images_sys/iopcstar.gif\" width=\"15\" height=\"14\" alt=\"ได้รับวิทยฐานะ $rs_1[name]\">";
}else{
	$showvit = "";
}
?>
<tr align="center" bgcolor="<?=$bg?>">
	<td><select name="runno[]">
<?
for($e=1;$e<=$row;$e++){
	$selected = ($e == $i) ? " selected " : "" ;
	echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
}
?>	
	</select>
	</td>
	<td><?=$rs[noorder]?><?=$showvit?>
	<input type="hidden" name="runid[]" value="<?=$rs[runid]?>">
	</td> 
	<td><?=MakeDate2($rs[dateorder])?> </td>
	<td><?=MakeDate2($rs[date])?></td>
	<td align="left"><?=$rs[position] ?></td>
	<td><?=$rs[noposition]?></td>
	<td><?=$rs[radub]?></td>
	<td align="right"><?=number_format($rs[salary])?>&nbsp;</td>
	<td align="left"><?=wordwrap($rs[pls], 30, "\n", true)?></td>
	<td><a href="salary_new.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2">
	<img src="bimg/b_edit.png" width="16" height="16" border="0" alt="edit"></a> 
	&nbsp; <a href="#" 
	onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" >
	<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>    
</tr>
<?
	} //while
// List Template
?>
<tr bgcolor="#dddddd" align="center">
	<td colspan="10">
	<input type="submit" value="ปรับปรุงข้อมูล" style="width:120px;" name="replase">
	&nbsp;
	<input type="button" value="กลับหน้าบันทึกข้อมูล" style="width:120px;" onClick="window.location.href('?id=<?=$id?>')">
	</td>
</tr>
</table>
</form>
<? } else { ?>
&nbsp;<a href="kp7_salary.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > ตรวจสอบเอกสารข้อมูล กพ7. อิเล็กทรอนิก </a><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"> 
	<td><br>            
<table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr> 
	<td><b>ชื่อ / สกุล &nbsp;<u><?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></u></b> </td>
</tr>
</table>
<br>
<?
$i 			= 0;
$result 	= mysql_query("select * from salary where id='$id' order by runno DESC limit 0,10;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#A3B2CC" align="center">
<td colspan="10" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง </span></td>
</tr>
<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
	<td colspan="2">คำสั่ง</td>
	<td width="12%" rowspan="2">วัน เดือน ปี</td>
	<td width="17%" rowspan="2">ตำแหน่ง</td>
	<td width="8%" rowspan="2">เลขที่<br>ตำแหน่ง</td>
	<td width="5%" rowspan="2">ระดับ</td>
	<td width="9%" rowspan="2">อัตรา<br>เงินเดือน</td>
	<td width="21%" rowspan="2">หมายเหตุ</td>
	<td width="3%" rowspan="2">&nbsp;</td>    
</tr>
<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
  <td width="13%">เลขที่</td>
	<td width="12%">วันที่</td>
</tr>
<?
while ($rs=mysql_fetch_assoc($result)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}
?>
<tr align="center" bgcolor="<?=$bg?>">
	<td><?=$rs[noorder]?></td>
	<td><?=MakeDate2($rs[dateorder])?> </td>
	<td><?=MakeDate2($rs[date])?></td>
	<td align="left"><?=$rs[position] ?></td>
	<td><?=$rs[noposition]?></td>
	<td><?=$rs[radub]?></td>
	<td align="right"><?=number_format($rs[salary])?>&nbsp;</td>
	<td align="left"><?=wordwrap($rs[pls], 30, "\n", true)?></td>
	<td><a href="salary_new.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2">
	<img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	&nbsp; <a href="#" 
	onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" >
	<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>    
</tr>
<?
	} //while
// List Template
?>
<tr align="right" bgcolor="#eeeeee">
	<td height="20" colspan="9" align="center"><a href="?id=<?=$id?>&action=viewAll">เพื่อความรวดเร็วการแสดงผล ระบบจะแสดงเพียง 10 รายการล่าสุดเท่านั้น หากต้องการเรียกดูทั้งหมด   
	  คลิกที่นี่</a>&nbsp;&nbsp;</td>
</tr>
</table>
<?
if ($_GET[action]=="edit2"){

		$sql 		= "select * from salary where id='$id' and runid = '$runid'   ;";
		$result 	= mysql_query($sql);
		if ($result){
			$rs = mysql_fetch_array($result,MYSQL_ASSOC);
		}
		
}else{
	//	$sql = "select max(radub) as radub,max(salary) as salary, max(position) as position , max(noposition) as noposition from salary where id='$id'   ;";
	$sql 		= "select radub,salary,position,pos_group,noposition from salary  where id='$id' order by runno desc limit 1";
	$result 	= mysql_query($sql);
	$rs		= mysql_fetch_assoc($result);
}
?>
<br>
<!--<a name="keys"></a>-->

<form method="post" name="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<table width="100%" border="0" cellspacing="3" cellpadding="2" align="center">
  <tr>
    <td width="143" align="right"><font color="red">*</font> เลขที่คำสั่ง</td>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr valign="middle">
        <td width="30%" rowspan="2"><textarea name="noorder" style="width:250px; height:45px;"><?=$rs[noorder]?>
</textarea></td>
        <td><input name="checkdateorder" type="checkbox" value="1" >
          &nbsp;ไม่ระบุ</td>
      </tr>
      <tr>
        <td><input type="radio" name="instruct" value="ลว." checked="checked">ลว. <input type="radio" name="instruct" value="สั่ง">
        สั่ง <?=dateInput($rs[dateorder],"dateorder")?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top" width="143">วัน เดือน พ.ศ.</td>
    <td align="left" valign="top" width="818"><?=dateInput($rs[date],"salary");?></td>
  </tr>
  <tr valign="top">
    <td align="right" width="143">ตำแหน่ง</td>
    <td align="left"><table width="80%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><input name="ch_position" type="radio" value="0" checked onClick="onSelect('0','PosAdj');">
          &nbsp;คงเดิม<br>
          <input name="ch_position" type="radio" value="1" onClick="onSelect('1','PosAdj');">
          &nbsp;ปรับใหม่
          &nbsp;&nbsp;( <u>ตำแหน่ง <b>:</b></u>
                <?=$rs[position]?>
          | <u>ระดับ <b>:</b></u>
          <?=$rs[radub]?>
          ) </td>
      </tr>
      <tr>
        <td><div id='PosAdj' style="display:none;">
          <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
            <tr bgcolor="#dddddd">
              <td height="20" colspan="2">&nbsp;<b><u>ข้อมูลที่ปรับ</u></b></td>
            </tr>
            <tr bgcolor="#f8f8f8">
              <td width="25%" height="25" align="right">เลขที่ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
              <td width="75%"><input type="text" name="noposition" size="20" value="<?=$rs[noposition]?>"></td>
            </tr>
            <tr bgcolor="#f8f8f8">
              <td height="25" align="right">ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
              <td><div id="hr_addposition">
                <select name="hr_addposition" style="width:250px;">
                  <option value="" class="warn">ไม่ระบุ</option>
                  <?=getOption(" select runid as id, position as value from $dbnamemaster.hr_addposition order by position; ", $rs[position])?>
                </select>
                <? /*<img	src="images/web/index_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" align="absmiddle"
	onclick="popWindow('addElement.php?table=hr_addposition','400','300')" style="cursor:hand;" />*/ ?>
              </div></td>
            </tr>
            <tr bgcolor="#f8f8f8">
              <td height="25" align="right">ระดับ&nbsp;<b>:</b>&nbsp;</td>
              <td><div id="hr_addradub">
                <select name="hr_addradub" style="width:154px;">
                  <option value="" class="warn">ไม่ระบุ</option>
                  <?=getOption(" select runid as id, radub as value from $dbnamemaster.hr_addradub order by radub; ", $rs[radub])?>
                </select>
                <? /*<img	src="images/web/index_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" align="absmiddle"
	onclick="popWindow('addElement.php?table=hr_addradub','400','300')" style="cursor:hand;" />*/ ?>
              </div></td>
            </tr>
            <tr bgcolor="#f8f8f8">
              <td height="25" align="right">กลุ่ม / ฝ่าย&nbsp;<b>:</b>&nbsp;</td>
              <td><input type="text" name="pos_group" size="20" value="<?=$rs[pos_group]?>"></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top" width="143">อัตราเงินเดือน</td>
    <td align="left" valign="top"><table width="80%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><input name="ch_salary" type="radio" value="0" checked onClick="onSelect('0','SalAdj');">
          คงเดิม<br />
          <input name="ch_salary" type="radio" value="1" onClick="onSelect('1','SalAdj');">
          ปรับใหม่ 
          &nbsp;(
          <?=number_format($rs[salary])?>
          )
          <div id='SalAdj' style="display:none;">
            <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
              <tr bgcolor="#dddddd">
                <td height="20" colspan="2">&nbsp;<b><u>ข้อมูลที่ปรับ</u></b></td>
              </tr>
              <tr bgcolor="#f8f8f8">
                <td width="30%" height="25" align="right">อัตราเงินเดือนใหม่&nbsp;<b>:</b>&nbsp;</td>
                <td width="70%"><input name="salary" type="text" id="salary" value="<?=$rs[salary]?>" style="width:200px;"></td>
              </tr>
            </table>
          </div></td>
      </tr>
    </table></td>
  </tr>
  <? /*
<tr valign="top"> 
	<td width="150" align="right">การเลื่อนขั้น</td>
	<td width="713"><input type="text" name="upgrade" size="40" value="<?=$rs[upgrade]?>"></td>
</tr>
*/ ?>
  <tr valign="top">
    <td align="right" valign="middle">การเลื่อนวิทยฐานะ</td>
    <td valign="middle"><input name="vitaya_sts" type="radio" value="0" checked="checked">
      เป็นคำสั่งที่ไม่เกี่ยวข้องกับการได้รับ/ปรับเลื่อนวิทยฐานะ<br>
      <input name="vitaya_sts" type="radio" value="1">
      เป็นคำสั่งที่เกี่ยวกับการได้รับ/ปรับเลื่อนวิทยฐานะ&nbsp;เป็น
      <select name="vitaya" onFocus="check_radio();">
        <option value="0" <? if($rsx[name]==""){ echo "selected=\"selected\"";}?>>ไม่มี</option>
        <?  
		foreach($namevit AS $key => $values){ 
			foreach ($values  AS  $val){
	?>
        <option value="<?=$val?>" <? if( trim($rsx[name])==trim($val) ){ echo "selected=\"selected\"";}?>><? echo "$key $val"?></option>
        <? } } ?>
      </select>
      โดยคำสั่งนี้<? echo $rsx[name]?></td>
  </tr>
  <tr valign="top">
    <td align="right">หมายเหตุ<br>
      ( สำหรับกรอกข้อมูลตำแหน่ง )</td>
    <td><textarea name="pls" cols="100" rows="5" id="pls"><?=$rs[pls]?>
</textarea></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr valign="middle"> 
	<td align="center" colspan="2"><input type="submit" name="send" value="  บันทึก  "></td>
</tr>
</table>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>
	</td>
</tr>
</table>
<? 
}
include("licence_inc.php");  
?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>