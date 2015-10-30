<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_teaching";
$module_code 		= "teaching"; 
$process_id			= "teaching";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
//include ("session.inc.php");
session_start();
include("../libary/function.php");
//include("checklogin.php");
//include("phpconfig.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
//conn2DB();

$year	= date("Y") + 543;
$syear	= $year - 20;
$eyear	= $year + 5;
$arr1		= array("ไม่ระบุ","ภาคเรียนที่ 1","ภาคเรียนที่ 2");
$table	= "hr_teaching";
$clas		= array("ไม่ระบุ","มัธยมศึกษาปีที่ 1","มัธยมศึกษาปีที่ 2","มัธยมศึกษาปีที่ 3","มัธยมศึกษาปีที่ 4","มัธยมศึกษาปีที่ 5","มัธยมศึกษาปีที่ 6");
$action	= (empty($action)) ? "add" : $action ;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(empty($id)){
		echo	"ไม่สามารถบันทึกได้ ไม่มีข้อมูล id ของบุคลาการ";		
		echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
		exit;
	}	
	
if($action == "edit"){
	$query 	= " update `".$table."` set subject='$subject', clas='$className', amount='$amount', act='$act', total='$total', groupsara='$groupsara', ";
	$query 	.= " by_primary='$by_primary', by_exp='$by_exp', by_skill='$by_skill', yy='$yy', term='$term' where id='$id' and runid='$runid'; ";
} else {
	$query 	= " insert into `".$table."` set id='$id', subject='$subject', clas='$className', amount='$amount', act='$act', total='$total', ";
	$query 	.= "groupsara='$groupsara', by_primary='$by_primary', by_exp='$by_exp', by_skill='$by_skill', yy='$yy', term='$term'; ";
}	
	$result	= mysql_query($query)or die("Query line " . __LINE__ . " error<hr>".mysql_error());	
	echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
	exit;
	
} 
	/*if($action=="del"){
		$strDel="DELETE FROM '".$table."' WHERE id='$id'";
		$strRelult=mysql_query($strDel);
			if($strRelult)
			{ echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
		exit; 
			}
	}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>ประวัติการสอน</title>
<script language="javascript" src="libary/xmlhttp.js"></script>
<script language="javascript">
window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");
window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");

function check(){

	if(document.post.yy.selectedIndex == 0){
		alert("ระบุปีการศึกษา");
		document.post.yy.focus();
		return false;
	} else if(document.post.subject.value.length == 0){
		alert("ระบุข้อมูลรายวิชาที่สอน");
		document.post.subject.focus();
		return false;
	} else if(isNaN(document.post.amount.value) && document.post.amount.value.length >= 1){
		alert("จำนวน (ชม/สัปดาห์) ต้องระบุเป็นตัวเลขเท่านั้น ");
		document.post.amount.focus();
		return false;	
	} else if(document.post.amount.value >= 41){
		alert("จำนวน (ชม/สัปดาห์) ไม่ควรเกิน 40 ");
		document.post.amount.focus();
		return false;	
	} else if(isNaN(document.post.act.value) && document.post.amount.value.length >= 1){
		alert("กิจกรรม (ชม/สัปดาห์) ต้องระบุเป็นตัวเลขเท่านั้น ");
		document.post.act.focus();
		return false;	
	} else if(document.post.act.value >= 41){
		alert("กิจกรรม (ชม/สัปดาห์) ไม่ควรเกิน 40 ");
		document.post.act.focus();
		return false;	
	} else {
		return true;
	}

}

function delRecord(table, id, runid, divid){

	if(!confirm('ท่านต้องการที่จะลบข้อมูลนี้ ใช่หรือไม่ ?')){
		return false;
	}
	
	var sid 			= "sid=" + Math.random();
	var table 		= "&table=" + table;
	var id 			= "&id=" + id;
	var runid		= "&runid=" + runid;
	var param		= sid + table + id + runid;

 	xmlHttp.open('POST', 'process_del_entry.php', true); 
    xmlHttp.onreadystatechange = function() { 
         if (xmlHttp.readyState==4) {
              if (xmlHttp.status==200) { 
			  	document.getElementById(divid).style.display = "none";				
				alert("ลบข้อมูลเรียบร้อยแล้ว");
			  }
         }
    };
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlHttp.send(param); 

}
</script>
</head>
<body bgcolor="#A3B2CC">
<table width="97%" border="0" cellspacing="0" cellpadding="2" align="center">
<?
$sql 		= " select * from  general where id='$id'  ;";
$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " error".mysql_error());	
$rs		= mysql_fetch_assoc($result);
?>
<tr valign="top"> 
	<td width="86%" align="left"><b>ชื่อ / สกุล &nbsp;&nbsp; 
	<u><?=$rs[prename_th]."&nbsp;".$rs[name_th]."&nbsp;".$rs[surname_th]?></u></b> </td>
    <td width="14%" align="right">&nbsp;</td>
</tr>
<?
mysql_free_result($result);
unset($sql, $rs);
?>
</table>
<br />
<table width="97%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080" class="normal">
<tr bgcolor="#999999" align="center" style="font-weight:bold;">
	<td width="7%" height="20">ลำดับที่</td>
    <td width="18%">กลุ่มสาระ</td>
    <td width="15%">รายวิชาที่สอน</td>
    <td width="20%">ชั้น</td>
	<td width="11%">จำนวน (ชม/สัปดาห์)</td>
	<td width="11%">กิจกรรม (ชั่วโมง)</td>    
    <td width="11%">รวม (ชั่วโมง)</td>
    <td width="7%">&nbsp;</td>
</tr>
<?
$n			= 0;
$sql 		= " select * from `".$table."` where id='$id'; ";
$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error".mysql_error());	
if(mysql_num_rows($result) >= 1){
while($rs = mysql_fetch_assoc($result)){

   	     	$n 	= $n+1;
	$bgcolor	= ($bgcolor == "#f9f9f9") ? "#ffffff" : "#f9f9f9";

	$edit 	= "<a href=\"?action=edit&id=".$id."&runid=".$rs[runid]."\" style=\"text-decoration:none;\">";
	$edit 	= $edit."<img src=\"bimg/b_edit.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"แก้ไขข้อมูล\"></a>";
	$del 		= "<a href=\"#\" onClick=\"delRecord('".$table."','".$id."','".$rs[runid]."','rec_".$rs[runid]."')\">";
	$del		= $del."<img src=\"bimg/b_drop.png\" height=\"16\" width=\"16\" border=\"0\" align=\"absmiddle\" alt=\"ลบข้อมูล\"></a>";
	//echo $table.$id.$rs[runid]."rec_$rs[runid]";
	
	$gsql= mysql_query(" select subject from $dbnamemaster.hr_teaching_group where id='$rs[groupsara]'; ");
	$grs	= mysql_fetch_assoc($gsql);
	$groupname = $grs[subject];
	mysql_free_result($gsql);
	unset($grs);
	$total	= $rs[amount] + $rs[act];
	// ทำาการเลือก ระดับชั้นตาม 

	$strClass=mysql_query("SELECT * FROM $dbnamemaster.hr_teaching_class where id='".$rs[clas]."'");
		$strRow=mysql_fetch_array($strClass);
?>	
<tr class="normal" bgcolor="<?=$bgcolor?>" align="left" id="rec_<?=$rs[runid]?>">
	<td height="20" align="center"><?=$n?></td>
    <td>&nbsp;<?=$groupname?></td>
    <td>&nbsp;<?=$rs[subject]?></td>
    <td>&nbsp;<?=$strRow[name]?></td>
    <td align="center">&nbsp;<?=$rs[amount]?></td>
	<td align="center">&nbsp;<?=$rs[act]?></td>
    <td align="center">&nbsp;<?=$total?></td>
    <td align="center"><?=$edit."&nbsp;".$del?></td>
</tr>
<?
}
mysql_free_result($result);
} else {
	echo "<tr bgcolor=\"#ffffff\" align=\"center\"><td height=\"20\" colspan=\"8\"><font color=\"blue\">ยังไม่มีข้อมูล</font></td></tr>";
}
unset($sql, $rs);
?>
</table>
<?
if($action == "edit"){
	$sql 		= " select * from `".$table."`  where id='$id' and runid='$runid' ;";
	$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " error".mysql_error());	
	$rs		= mysql_fetch_assoc($result);
}	
?>
<form action="<?=$PHP_SELF?>" name="post" method="post" onsubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="runid" value="<?=$runid?>" />	
<table width="800" border="0" cellspacing="4" cellpadding="1" align="center">
<tr align="left">
    <td width="236" height="25" align="right">ปีการศึกษา&nbsp;<b>:</b>&nbsp;</td>
    <td width="220"><select name="yy" style="width:154px;">
	<option value="" style="color:red;">ไม่ระบุ</option>
<?
for($i=$syear;$i<=$eyear;$i++){
	$selected	= ($i == $rs[yy]) ? " selected style=\"color:#0099CC;\" " : "" ;
	echo "<option value=\"".$i."\" ".$selected.">".$i."</option>";
}
?>	
	</select>		
	</td>
    <td width="81" align="right">ภาคเรียนที่&nbsp;<b>:</b>&nbsp;</td>
    <td width="235">
	<input type="radio" name="term" value="1" style="border:none;"<? if($rs[term]==1){echo " checked ";}else{echo " checked ";}?> />&nbsp;ภาคเรียนที่ 1
	<input type="radio" name="term" value="2" style="border:none;"<? if($rs[term]==2){echo " checked ";} ?> />&nbsp;ภาคเรียนที่ 2	</td>
</tr>
<tr align="left">
    <td height="25" align="right">การสอนตรงกลุ่มวิชาเอก&nbsp;<b>:</b>&nbsp;</td>
    <td colspan="3">
	<input type="radio" name="by_primary" value="1" style="border:none;"<? if($rs[by_primary]==1){echo " checked ";}else{echo " checked ";}?> />
	&nbsp;ตรงวิชาเอก
	<input type="radio" name="by_primary" value="2" style="border:none;"<? if($rs[by_primary]==2){echo " checked ";} ?> />&nbsp;ไม่ตรงวิชาเอก	</td>
    </tr>
<tr align="left">
    <td height="25" align="right">การสอนตรงตามความถนัดของตนเอง&nbsp;<b>:</b>&nbsp;</td>
    <td colspan="3">
	<input type="radio" name="by_skill" value="1" style="border:none;"<? if($rs[by_skill]==1){echo " checked ";}else{echo " checked ";}?> />
	&nbsp;ตรงตามความถนัด
	<input type="radio" name="by_skill" value="2" style="border:none;"<? if($rs[by_skill]==2){echo " checked ";} ?> />&nbsp;ไม่ตรงตามความถนัด	</td>
</tr>
<tr align="left">
    <td height="25" align="right">ตามประสบการณ์ในวิชาสอน&nbsp;<b>:</b>&nbsp;</td>
    <td colspan="3">
	<input type="radio" name="by_exp" value="1" style="border:none;"<? if($rs[by_exp]==1){echo " checked ";}else{echo " checked ";}?> />
	&nbsp;< 1 - 2 ปี&nbsp;
	<input type="radio" name="by_exp" value="2" style="border:none;"<? if($rs[by_exp]==2){echo " checked ";} ?> />&nbsp;3 - 5 ปี&nbsp;
	<input type="radio" name="by_exp" value="3" style="border:none;"<? if($rs[by_exp]==3){echo " checked ";} ?> />&nbsp;> 5 ปี	</td>
</tr>
<tr align="left">
    <td height="25" align="right">กลุ่มสาระ&nbsp;<b>:</b>&nbsp;</td>
    <td colspan="3">
	<select name="groupsara" style="width:154px;" class="input">
	<option value="" style="color:red;">ไม่ระบุ</option>
<?
$query	= mysql_query(" select * from $dbnamemaster.hr_teaching_group order by id asc; ");
while($rss = mysql_fetch_assoc($query)){
	$selected = ($rs[groupsara] == $rss[id]) ? " selected style=\"color:#0099CC;\" " : "" ;
	echo "<option value=\"".$rss[id]."\" ".$selected.">".$rss[subject]."</option>";
}
mysql_free_result($query);
unset($selected);
?>	
	</select>
	</td>
</tr>
<tr>
    <td height="25" align="right">ชื่อวิชาย่อย (หากไม่ใช่กลุ่มสาระ)&nbsp;</td>
    <td colspan="3"><input type="text" name="subject" value="<?=$rs[subject]?>" style="width:150px;" /></td>
</tr>
<tr>
    <td height="25" align="right">ระดับชั้น&nbsp;</td>
    <td colspan="3">
	<select name="className" style="width:150px;" class="input">
	<option value="" style="color:red;">ไม่ระบุ</option>
<?
$query	= mysql_query(" select * from $dbnamemaster.hr_teaching_class order by id asc; ");
while($rss = mysql_fetch_assoc($query)){
	$selected = ($rs[clas] == $rss[id]) ? " selected style=\"color:#0099CC;\" " : "" ;
	echo "<option value=\"".$rss[id]."\" ".$selected.">".$rss[name]."</option>";
}
mysql_free_result($query);
unset($selected);
?>	
	</select>	
	</td>
</tr>
<tr>
    <td height="25" align="right">จำนวน (ชั่วโมง/สัปดาห์)&nbsp;</td>
    <td colspan="3"><input type="text" name="amount" value="<?=$rs[amount]?>" style="width:150px;" /></td>
</tr>
<tr>
    <td height="25" align="right">กิจกรรม (ชั่วโมง)&nbsp;</td>
    <td colspan="3"><input type="text" name="act" value="<?=$rs[act]?>" style="width:150px;" /></td>
</tr>
<tr align="center" bgcolor="#333333"> 
	<td colspan="5"><input type="submit" name="send" value="  บันทึก  "></td>
</tr>
</table>
</form>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>