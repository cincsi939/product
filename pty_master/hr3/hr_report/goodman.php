<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_goodman";
$module_code 		= "goodman"; 
$process_id			= "goodman";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
$time_start = getmicrotime();

$id 		= (empty($_POST[id])) ? $_GET[id] : $_POST[id] ;
$action 	= $_GET[action];

if ($_SERVER[REQUEST_METHOD] == "POST"){
	
	add_log("ข้อมูลความดีความชอบ",$id,$action);
	$date = $salary_year.'-'.$salary_month.'-'.$salary_day;
	 if ($_POST[action]=="edit2") {

		$sql = "update  goodman set  date='$date', gaction='$gaction' , radub = '$radub', salary ='$salary', note ='$note'  where id ='$id' and runid ='$runid' ;";	
		$returnid = add_monitor_logbefore("goodman"," id ='$id' and runid ='$runid' ");
		mysql_query($sql)or die("ไม่สามารถบันทึกได้");
		add_monitor_logafter("goodman"," id ='$id' and runid ='$runid' ",$returnid);
		
		echo "<script language=\"javascript\">eval(alert(\"ปรับปรุงข้อมูลเรียบร้อยแล้ว\"));location.href='goodman.php?id=$id&action=edit&vgoodman=1';</script>";
		//header("Location: ?id=$id&action=edit");
		exit;

	}  else {
		
		$sql 		= "INSERT INTO  goodman (id,date,gaction,radub,salary,note) VALUES ('$id','$date','$gaction','$radub','$salary','$note')";
		
		$returnid = add_monitor_logbefore("goodman","");
		$result  = mysql_query($sql)or die("ไม่สามารถบันทึกได้");
		$max_idx = mysql_insert_id();
		add_monitor_logafter("goodman"," id ='$id' and runid ='$max_idx' ",$returnid);
		
		echo "<script language=\"javascript\">alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");location.href='goodman.php?id=$id&action=edit&vgoodman=1';</script>";	
		//header("Location: ?id=$id&action=edit");	
		exit;
			
	}
	header("Location: ?id=$id");	
	exit;			
	
}else if ($_GET[action] == 'delete') {

	add_log("ข้อมูลความดีความชอบ",$id,$action);
		mysql_query("delete from goodman where id = $id and runid='$runid';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			//header("Location: ?id=$id&action=edit");
						echo "<script language=\"javascript\">
						
							</script>";
						echo"<meta http-equiv='refresh' content='0;URL=goodman.php?id=$id&action=edit&vgoodman=1'>";
			exit;
			}
	
}else {		
	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}
	
?>
<html>
<head>
<title>ความดีความชอบ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style4 {color: #000000}
-->
</style>
<!-- send id to menu flash -->
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
<script language=javascript>
addnone=1;
displaymonth='l';	

function check(){

	if(document.post.gaction.value.length==0){
		alert("ระบุรายการความดีความชอบ");
		document.post.gaction.focus();
		return false;
	} else {
		return true;
	}
	
}	
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left" valign="top"> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30">
		<br>
		<? if($action=="edit" && $vgoodman==0){?>
		<table width="98%"  align="center">
		<?
		if($dis_menu){//เปิดเมนู
		echo "";
		?>
		<?
		}else{
		?>
            <tr>
              <td width="23%" height="21"><a href="goodman.php?id=<?=$rs[id]?>&action=edit&vgoodman=1" title="แก้ไขข้อมูล"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style4">เพิ่ม /ลบ /แก้ไข ข้อมูล</span></a> </td>
              <td width="77%"></td>
            </tr>
		<?
		} // จบ($dis_menu)
		?>
        </table>
		<? }?>
		</td>
        <td width="50" height="30">&nbsp;</td>
      </tr>
    </table>
	  <br>
<table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr> 
<td align="left" valign="top" ><b><span class="style4">ชื่อ / สกุล &nbsp;&nbsp; <u>
<?=$rs[prename_th]?>
<?=$rs[name_th]?>&nbsp;&nbsp;
<?=$rs[surname_th]?>
</u></span><u></u></b> </td>
</tr>
</table>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;รายการความดีความชอบ</strong><br>
<br>
<? if($action=="edit")
{
	if($vgoodman==0)
	{
?><span class="style4"><br>
</span>
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">

<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;"> 
	<td width="14%" height="20">วัน เดือน พ.ศ.</td>
	<td width="27%">รายการความดีความชอบ</td>
	<td width="7%">ระดับ</td>
	<td width="8%">รับจริง</td>
	<td width="27%">หมายเหตุ</td>
	</tr>
<?
$i=0;
$result 	= mysql_query(" select * from goodman where id='$id' order by date ;");
$row		= mysql_num_rows($result);
while($rs = mysql_fetch_assoc($result)){
	
	$i++;
	$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
?>
<tr align="center" bgcolor="<?=$bg?>"> 
	<td><?=MakeDate($rs[date])?></td>
	<td align="left"><?=$rs[gaction] ?></td>
	<td><?=$rs[radub]?></td>
	<td align="right"><?=number_format($rs[salary])?></td>
	<td align="left"><?=$rs[note]?></td>
	</tr>
<?
	} //while
// List Template
?>
</table>
<?
	}//if(vgoodman==0) end
	else if($vgoodman==1)
	{
	?>
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">

<tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;"> 
	<td width="14%">วัน เดือน พ.ศ.</td>
	<td width="27%">รายการความดีความชอบ</td>
	<td width="7%">ระดับ</td>
	<td width="8%">รับจริง</td>
	<td width="27%">หมายเหตุ</td>
	<td width="6%">
	<input type="button" name="insert" value="เพิ่มข้อมูล" onClick="location.href='goodman.php?id=<?=$id?>' "></a></td>
</tr>
<?
$i=0;
$result 	= mysql_query(" select * from goodman where id='$id' order by date  ;");
while($rs = mysql_fetch_assoc($result)){
	
	$i++;
	$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
?>
<tr align="center" bgcolor="<?=$bg?>"> 
	<td><?=MakeDate($rs[date])?></td>
	<td align="left"><?=$rs[gaction] ?></td>
	<td><?=$rs[radub]?></td>
	<td align="right"><?=number_format($rs[salary])?></td>
	<td><?=$rs[note]?></td>
	<td>
	<a href="goodman.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2">
	<img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a>&nbsp;
 	<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';">
 	<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
</tr>
<?
	} //while
// List Template
?>
<tr bgcolor="#dddddd" align="center">
	<td colspan="7"><input type="button" name="back" value="กลับหน้าแรก" onClick="location.href='goodman.php?id=<?=$id?>&action=edit&vgoodman=0'"> 
	  </td>
</tr>
</table>
 <? 
		 }//END else if($vgoodman==1)
 }//end if($action==edit)
else
{
if($_GET[action]=="edit2"){

		$sql 		= "select * from goodman where id='$id' and runid = '$runid'   ;";
		$result 	= mysql_query($sql);	
		$rs		= mysql_fetch_assoc($result);	
}
?>
<form name="post" method="post"  action="<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr align="left"> 
	<td align="right" width="225"> วัน เดือน พ.ศ.</td>
	<td width="460"><? 
	//=DateInput_key($rs[date],"salary","ไม่ระบุ")
    
	$d1=explode("-",$rs[date]);
    ?>
    วันที่
				  <select name="salary_day"  id="salary_day"  onChange="check_date('salary_day','salary_month','salary_year');"></select>

				  
				เดือน
				<select name="salary_month" id="salary_month" onChange="check_date('salary_day','salary_month','salary_year');"></select>

				
				ปี พ.ศ.
				<select name="salary_year"  id="salary_year" onChange="check_date('salary_day','salary_month','salary_year');"></select>
          
<script>
	create_calendar('salary_day','salary_month','salary_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script>
           
              
    
    
    </td>
</tr>
<tr align="left"> 
	<td align="right"><font color="red">*</font> รายการความดีความชอบ</td>
	<td> <input type="text" name="gaction" size="40" value="<?=$rs[gaction]?>"></td>
</tr>
<tr align="left"> 
	<td align="right">ระดับ</td>
	<td><input type="text" name="radub" size="20" value="<?=$rs[radub]?>"></td>
</tr>
<tr align="left"> 
	<td align="right">รับจริง</td>
	<td><input type="text" name="salary" size="20" value="<?=$rs[salary]?>"></td>
</tr>
<tr align="left"> 
	<td align="right">หมายเหตุ</td>
	<td><input type="text" name="note" size="40" value="<?=$rs[note]?>"></td>
</tr>
<tr align="center" bgcolor="#333333"> 
	<td colspan="2"><input type="submit" name="send" value="  บันทึก  "><input type=button ONCLICK="location.href='goodman.php?id=<?=$id?>&action=edit&vgoodman=1' "  value="ยกเลิก" name="button" />
	  <input type="button" name="back2" value="กลับหน้าแรก" onClick="location.href='goodman.php?id=<?=$id?>&action=edit&vgoodman=0'"></td>
</tr>
</table>
</form>
<? }?>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	</td>
</tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>