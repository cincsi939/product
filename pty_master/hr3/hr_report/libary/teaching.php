<?
include ("checklogin.php");
include ("phpconfig.php");
conn2DB();

$table	= "hr_teaching";
$clas		= array("ไม่ระบุ","มัธยมศึกษาปีที่ 1","มัธยมศึกษาปีที่ 2","มัธยมศึกษาปีที่ 3","มัธยมศึกษาปีที่ 4","มัธยมศึกษาปีที่ 5","มัธยมศึกษาปีที่ 6");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(empty($id)){
		$msg		= "ไม่สามารถบันทึกได้ ไม่มีข้อมูล id ของบุคลาการ";
		include("msg_box.php");
		echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
		exit;
	}
	$startdate	= yearChange($startdate,1);
	
if($action == "edit"){
	$query 	= " update `".$table."` set yy='$yy', term='$term', by_primary='$by_primary', by_skill='$by_skill', by_exp='$by_exp', groupname='$groupname', ";
	$query 	.= " subject='$subject', level='$level', exptime='$exptime' where id='$id' and runid='$runid'; ";
} else {
	$query 	= " insert into `".$table."` set id='$id', yy='$yy', term='$term', by_primary='$by_primary', by_skill='$by_skill', by_exp='$by_exp', ";
	$query 	.= " groupname='$groupname',subject='$subject', level='$level', exptime='$exptime'; ";
}	
	$result	= mysql_query($query)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$msg		= "บันทึกข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
	exit;
	
} 

if($action == "del"){

	$query 	= " delete from `".$table."` where id='$id' and runid='$runid'; ";
	$result	= mysql_query($query)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$msg		= "บันทึกข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=?id=$id'>" ;
	exit;
	
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>ประวัติการสอน</title>
<script language="javascript" src="ibary/xmlhttp.js"></script>
<script language="javascript">
window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");
window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");

function check(){

	if(document.post.subject.value.length == 0){
		alert("ระบุข้อมูลรายวิชาที่สอน");
		document.post.subject.focus();
		return false;
	} else {
		return true;
	}

}

function delRecord(table, id, yy, divid){

	if(!confirm('ท่านต้องการที่จะลบข้อมูลนี้ ใช่หรือไม่ ?')){
		return false;
	}
	
	var sid 			= "sid=" + Math.random();
	var table 		= "&table=" + table;
	var id 			= "&id=" + id;
	var yy 			= "&yy=" + yy;
	var param		= sid + table + id + yy;

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
<tr> 
	<td align="left" valign="top" ><b>ชื่อ / สกุล &nbsp;&nbsp; 
	<u><?=$rs[prename_th]."&nbsp;".$rs[name_th]."&nbsp;".$rs[surname_th]?></u></b> </td>
</tr>
</table>
<br />
<table width="97%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080" class="normal">
<tr bgcolor="#999999" align="center" style="font-weight:bold;">
	<td width="7%" height="20">ลำดับที่</td>
    <td width="17%">รายวิชาที่สอน</td>
    <td width="11%">ชั้น</td>
	<td width="28%">จำนวน (ชม/สัปดาห์)</td>
	<td width="15%">กิจกรรม (ชั่วโมง)</td>    
    <td width="15%">รวม (ชั่วโมง)</td>
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
?>	
<tr class="normal" bgcolor="<?=$bgcolor?>" align="left" id="rec_<?=$rs[runid]?>">
	<td height="20" align="center"><?=$n?></td>
    <td>&nbsp;<?=$rs[yy]?></td>
    <td>&nbsp;<?=$arr1[$rs[term]]?></td>
    <td>&nbsp;<?=$rs[groupname]?></td>
	<td>&nbsp;<?=$rs[subject]?></td>
    <td>&nbsp;</td>
    <td align="center"><?=$edit."&nbsp;".$del?></td>
</tr>
<?
}
mysql_free_result($result);
} else {
	echo "<tr bgcolor=\"#ffffff\" align=\"center\"><td height=\"20\" colspan=\"6\" class=\"blue\">ยังไม่มีข้อมูล</td></tr>";
}
unset($sql, $rs);
?>
</table>

<form action="<?=$PHP_SELF?>" name="post" method="post" onsubmit="check();">
<table width="800" border="0" cellspacing="4" cellpadding="1" align="center">
<tr>
    <td width="219" height="25" align="right">รายวิชาที่สอน&nbsp;</td>
    <td width="565"><input type="text" name="subject" value="<?=$rs[subject]?>" style="width:150px;" /></td>
</tr>
<tr>
    <td height="25" align="right">ชั้น&nbsp;</td>
    <td><select name="clas" style="width:150px;">
<?
for($i=0;$i<count($clas);$i++){
	$selected = ($clas[$i] == $rs[clas]) ? "selected" : "" ;
	echo "<option value=\"".$clas[$i]."\" ".$selected.">".$clas[$i]."</option>";
}
unset($selected);
?>	
	</select>
	</td>
</tr>
<tr>
    <td height="25" align="right">จำนวน (ชม/สัปดาห์)&nbsp;</td>
    <td><input type="text" name="clas" value="<?=$rs[clas]?>" style="width:150px;" /></td>
</tr>
<tr>
    <td height="25" align="right">กิจกรรม (ชั่วโมง)&nbsp;</td>
    <td><input type="text" name="act" value="<?=$rs[act]?>" style="width:150px;" /></td>
</tr>
<tr>
    <td height="25" align="right">รวม (ชั่วโมง)&nbsp;</td>
    <td><input type="text" name="act" value="<?=$rs[act]?>" style="width:150px;" /></td>
</tr>
<tr align="center" bgcolor="#333333"> 
	<td colspan="2"><input type="submit" name="send" value="  บันทึก  "></td>
</tr>
</table>
</form>
</body>
</html>
