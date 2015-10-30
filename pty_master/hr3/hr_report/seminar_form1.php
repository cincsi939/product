<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_seminar_form";
$module_code 		= "seminar_form"; 
$process_id			    = "seminar_form";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer:: Alongkot Karpchai
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
//include ("session.inc.php");
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
//include ("checklogin.php");
//include ("phpconfig.php");
//conn2DB();
$sql = "select * from  general where id='$id'";
	$result 	= mysql_query($sql);
	$rows		= mysql_fetch_array($result);
    $gid=$rows[idcard];

$table = "seminar_form";
if ($_SERVER[REQUEST_METHOD] == "POST"){

 	
  
	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action);
	// ประกอบค่าจาก select box
	$startdate 	= $start_year.'-'.$start_month.'-'.$start_day;
 	$enddate 	= $end_year.'-'.$end_month.'-'.$end_day;
	$ondate 	= $date_year.'-'.$date_month.'-'.$date_day;

	 if ($_POST[action]=="edit2"){
		$note1 =str_replace("\n", " ", $note1); 
		$note2 =str_replace("\n", " ", $note2); 
	    $note3 =str_replace("\n", " ", $note3); 
		$sql 	= " update `".$table."` set title1='$title1', title2='$title2', orderno='$orderno', ondate='$ondate', startdate='$startdate', enddate='$enddate', ";
		$sql	.= " subject='$subject', place='$place', note1='$note1', note2='$note2', note3='$note3' where runid='$runid' ;";
		mysql_query($sql)or die(" Cannot update parameter information. ");
		header("Location: ?id=$id");
	

	} elseif($action == "changeRow"){
		
		for($i=0;$i<count($runno);$i++){
			$sql		= " update `".$table."` set runno='".$runno[$i]."' where id='".$id."' and runid='".$runid[$i]."' ";		
			$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		}

		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
	//	header("Location: ?id=$id");
		exit;
							
		$result1 	= mysql_query(" select max(runno) as runno from `".$table."` where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  		$rs1		= mysql_fetch_assoc($result1);
	  	$runno	= ($rs1[runno] <= 0) ? 1 : ($rs1[runno] + 1);
		mysql_free_result($result1);
		unset($rs1);	

		} else {
         ///เรียงลำดับข้อมูลที่บันทึก
		$result1 	= mysql_query(" select max(runno) as runno from `".$table."` where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  		$rs1		= mysql_fetch_assoc($result1);
	  	$runno	= ($rs1[runno] <= 0) ? 1 : ($rs1[runno] + 1);
		mysql_free_result($result1);
			unset($rs1);	

        $note1 =str_replace("\n", " ", $note1); 
		$note2 =str_replace("\n", " ", $note2); 
	    $note3 =str_replace("\n", " ", $note3); 
		$sql	= " insert into `".$table."` set title1='$title1', title2='$title2', orderno='$orderno', ondate='$ondate', startdate='$startdate', enddate='$enddate', ";
		$sql	.= " subject='$subject', place='$place', note1='$note1', note2='$note2', note3='$note3', id='$rows[id]', runno='$runno' ; ";

		mysql_query($sql)or die(" ไม่สามารถบันทึกข้อมูลได้. <hr>".mysql_error());
		echo "
		<script language=\"javascript\">
		alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
		location.href='?id=$id&action=edit';
		</script>
				";
		//header("Location: ?id=$id");
		exit;
	
		}
	}	 elseif($_GET[action] == 'delete') {

	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action);
	mysql_query("delete from `".$table."` where runid='$runid';")or die(" Cannot delete parameter. ");
	           if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้";
			}else
			{
		    echo"<meta http-equiv='refresh' content='1;URL=seminar_form.php'>";
			header("Location: ?id=$id&action=edit");
			exit;
			}

}else {		

 	$sql 			= "select * from  general where id='$id'  ;";
	$result 		= mysql_query($sql)or die(" Cannot find parameter information. ");
	$rs			= mysql_fetch_array($result,MYSQL_ASSOC);
	$fullname	= $rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th];

}
?>
<html>
<head>
<title>อบรม / ดูงาน / สัมนา</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
<!-- send id to menu flash -->
<script language=javascript>

function check(){

	if(document.post.subject.value.length == 0){
		alert("ระบุข้อมูลชื่อหลักสูตร");
		document.post.subject.focus();
		return false;
	} else {
		return true;
	}
	
}	
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
	<td height="30">&nbsp;</td>
    <td width="50"></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr align="left" valign="top"> 
	<td>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr align="left" valign="top" > 
	<td><b>ชื่อ / สกุล &nbsp;&nbsp; <u><?=$fullname?></u></b> </td>
</tr>
</table>
<br>
<form name="form1" method="post" action="<?=$PHP_SELF?>">			
<input type="hidden" name="action" value="changeRow">
<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table border="0" cellspacing="2" cellpadding="2" align="center" width="98%" bgcolor="black">
<tr align="center" bgcolor="#2C2C9E">
	<td colspan="6" height="20"><b style="color:#ffffff;">รายงานการเข้าร่วมประชุมสัมนา / จัดกิจกรรม</b></td>
</tr>
<tr bgcolor="#A3B2CC" align="center" style=" font-weight:bold;"> 
	<td width="10%">เรียงลำดับ</td>
	<td width="16%">วันที่</td>	
	<td width="17%">ตามคำสั่งที่</td>
	<td width="31%">เรื่อง</td>
	<td width="18%">สถานที่ &nbsp;<a href="browse_file.php?"></a></td>
	<td width="8%">&nbsp;</td>
</tr>
<?
$stype 	= array("อบรม","ดูงาน","สัมนา");
$i			= 0;
$result	= mysql_query("select * from `".$table."`  where id='$id' order by runno ;");
$rows		= mysql_num_rows($result);
while($rs = mysql_fetch_assoc($result)){

	$i++;
	$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
?>
<tr bgcolor="<?=$bg?>" align="center"> 
	<td>	
	<select name="runno[]">
<?
for($e=1;$e<=$rows;$e++){
	$selected = ($e == $i) ? " selected " : "" ;
	echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
}
?>	
	</select>
	<input type="hidden" name="runid[]" value="<?=$rs[runid]?>">
	</td>
	<td><?=MakeDate($rs[ondate])?></td>
	<td><?=$rs[orderno]?></td>
	<td align="left">&nbsp;<?=$rs[subject]?></td>
	<td align="left" bordercolor="#1841A5">&nbsp;<?=$rs[place]?>
	<? 
  $up="select * from seminar_upload  where   id=".$rs[runid]."";
   $reup=mysql_query($up);
   $row=mysql_num_rows($reup);
    //mysql_num_rows($reup)
  if(@mysql_num_rows($reup) ==0){ 
	//if($rs[runid]== $run){
	 ?>
<a href="#" onClick="MM_openBrWindow('browse_file.php?id=<?=$rs[runid]?>','','width=400,height=400')"> 
	<img src="../../../images_sys/paperclip.jpg" width="18" height="18" border="0"></a>
		<? 	
	}else {
	echo"<a href=\"#\" onClick=\"MM_openBrWindow('browse_file.php?runid=".$rs[runid]."','','width=400,height=400')\">". $row." ไฟล์แนบ </a>"; 
 }  
 ?>
	</td>
	<td> 
	<a href="seminar_pdf.php?id=<?=$rs[id]?>&runnid=<?=$rs[runid]?>" target="_blank">
	<img src="bimg/pdf.gif" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;
	<a href="?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2">
	<img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a>&nbsp;
	<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" >
	<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	
	</td>
</tr>
<?
} 
mysql_free_result($result);
?>
<tr bgcolor="#dddddd" align="center">

	<td colspan="6"><input type="submit" value="ปรับปรุงข้อมูลลำดับแสดงผล"></td>
</tr>
</form>
</table>

<?
if($_GET[action]=="edit2"){

	$sql 		= "select * from `".$table."` where  runid = '$runid';";
	$result 	= mysql_query($sql);
	$rs		= mysql_fetch_assoc($result);
}
?>
<br>
<form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="gid" value="<?=$rs[id]?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr> 
	<td align="right" width="333" height="25">เรื่อง&nbsp;<b>:</b>&nbsp;</td>
	<td align="left" width="541">&nbsp;<b><u>การรายงานผลการไปประชุมสัมนา/จัดกิจกรรม</u></b></td>
</tr>
<tr> 
	<td align="right" height="25">สิ่งที่ส่งมาด้วย&nbsp;<b>:</b>&nbsp;</td>
	<td align="left">&nbsp;1&nbsp;<input type="text" name="title1" size="60" value="<?=$rs[title1]?>" style="width:300px;"></td>
</tr>
<tr> 
	<td align="right" height="25">&nbsp;</td>
	<td align="left">&nbsp;2&nbsp;<input type="text" name="title2" size="60" value="<?=$rs[title2]?>" style="width:300px;"></td>
</tr>
<tr> 
	<td align="right" height="25">ตามคำสั่งที่&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><input type="text" name="orderno" size="60" value="<?=$rs[orderno]?>" style="width:200px;"></td>
</tr>
<tr> 
	<td align="right" height="25">ลงวันที่&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><?=DateInput($rs[ondate],"date")?></td>
</tr>
<tr> 
	<td align="right" height="25"><font color="red">*</font> เรื่อง&nbsp;&nbsp;</td>
	<td align="left"><input type="text" name="subject" size="20" value="<?=$rs[subject]?>" style="width:200px;"></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่&nbsp;&nbsp;</td>
	<td align="left"><?=DateInput($rs[startdate],"start")?></td>
</tr>
<tr> 
	<td align="right" height="25">ถึง&nbsp;&nbsp;</td>
	<td align="left"><?=DateInput($rs[enddate],"end")?></td>
</tr>
<tr> 
	<td align="right" height="25">สถานที่&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>" style="width:200px;"></td>
</tr>
<tr valign="top">
	<td align="right" height="25">ความรู้ หรือ ประสพการณ์ ที่ได้รับจากการอบรมสัมนา&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><textarea name="note1" style="width:500px; height:100px;"><?=$rs[note1]?></textarea></td>
</tr>
<tr valign="top">
	<td align="right" height="25">การนำความรู้สู่การปฎิษัติ ได้ดังนี้&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><textarea name="note2" style="width:500px; height:100px;"><?=$rs[note2]?></textarea></td>
</tr>
<tr valign="top">
	<td align="right" height="25">สิ่งที่ต้องการให้โรงเรียนให้การสนับสนุน&nbsp;<b>:</b>&nbsp;</td>
	<td align="left"><textarea name="note3" style="width:500px; height:100px;"><?=$rs[note3]?></textarea></td>
</tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td><input type="submit" name="send" value="บันทึก"></td>
</tr>
</table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</td>
</tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>