<?
session_start();
include("epm.inc.php");
include("function.php");
$id 			= $_SESSION[session_staffid];
$img_path	= "images/personnel/";

	$sql		= " select image from $epm_staff where staffid = '$id'; ";
	$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
	$rs 		= mysql_fetch_assoc($result);
	$image	= $img_path.$rs[image];
	mysql_free_result($result);

if($_SERVER[REQUEST_METHOD] == "POST"){ 	

	
	$sql		= " select image from $epm_staff where staffid = '$id'; ";
	$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
	$rs 		= mysql_fetch_assoc($result);
	$image	= $img_path.$rs[image];
	if($rs[image] != "" && file_exists($image)){ unlink($image); }
	mysql_free_result($result);
	unset($image);
	
	$upload		= upload($img_path, $file, $file_name, "img");		
	if($extra == "1"){
	$msg 		= upload_status_alert($upload[0]);
	if($msg != ""){ /*echo $msg;*/ echo "<script language=\"javascript\">alert(\"$msg\");location.href='user_image.php?extra=$extra';</script>";exit; }	
	}else{
			$msg 		= upload_status($upload[0]);
			if($msg != ""){ echo $msg; exit; }	
	}
	if($msg == ""){
	$sql 		= " update $epm_staff  set image='".$upload[1]."' where staffid = '$id'; ";
	$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
	}
	$msg		= "( <font color=\"red\">ปรับปรุงข้อมูลภาพเรียบร้อยแล้ว</font> )";
	$image	= "<img src=\"".$img_path.$upload[1]."\" width=\"150\" border=\"0\">";
	if($extra == "1"){
		echo "<script language=\"javascript\">window.parent.leftFrame.document.getElementById(\"img\").innerHTML = '$image';location.href='qsearch2.php'</script>";
	}else{
		echo "<script language=\"javascript\">window.opener.parent.leftFrame.document.getElementById(\"img\").innerHTML = '$image';";
		echo "window.opener.document.getElementById(\"Status\").innerHTML = '<font color=\"blue\">ปรับปรุงข้อมูลรูปภาพแล้ว</font>';</script>";	
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" rel="stylesheet" />
<title>เปลี่ยนข้อมูลภาพใหม่</title>
</head>
<script language="javascript">
function check(){	
	 if (!/(\.(gif|jpg|jpeg|png))$/i.test(document.post.file.value)){
		alert("รูปแบบของ file ไม่ใช่รูปภาพ \nต้องเป้นนามสกุล gif,jpg,jpeg และ png เท่านั้น");
		document.post.file.focus();
		return false;	
	} 
		return true;
}
</script>
<body bgcolor="#f8f8f8" on>
<fieldset style="float: left; width:380px; margin-left:3px; margin-right:3px;">
<legend><b style="color:#0099CC;">Upload Image</b></legend>
<form method="post" name="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data" onSubmit="return check()"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="normal">
<tr>
	<td height="20">&nbsp;<b style="color:#006699;">เลือกภาพ</b>&nbsp;
	<?=$msg?></td>
</tr>
<tr align="center">
	<td height="20"><input type="file" name="file" style="width:350px;"></td>
</tr>
<tr align="center">
	<td height="20">
    <input type="hidden" name="extra"value="<?=$extra?>">
	<input type="submit" style="width:60px;" value="Upload">
	<input type="button" style="width:60px;" value="Close" onClick="self.close();">
	</td>
</tr>
</table>	
</form>
</fieldset>
</body>
</html>