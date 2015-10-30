<?
session_start();
/*
ความหมายค่า $_SESSION['training_staff']
0=ไม่อยู่ในกลุ่มtraining, 1=อยู่ในกลุ่มผู้รับการtraining, 2=ผู้ให้การtraining
*/
include("../../../config/conndb_nonsession.inc.php");

function getTagLevel( $num ){
	$tag = "";
	for($i=0;$i<$num;$i++){
		$tag .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	return $tag;
}

function showMenu( $menu_id = "" , $parent = 0){
	global $dbnamemaster;
	$sql = "SELECT
				training_menu.*
				FROM
				training_menu
				WHERE 
				training_menu.parent_id='".$menu_id."'
				";
	$xresult2 = mysql_db_query($dbnamemaster,$sql);
	$menuitem=$parent;
	$menuitem++;
	while ($rs_menu=mysql_fetch_assoc($xresult2)){	
			$sql_num = "SELECT
				COUNT(training_menu_config.menu_id) AS num_menu
				FROM
				training_menu_config
				Inner Join training_menu ON training_menu_config.menu_id = training_menu.menu_id  
				WHERE 
				training_menu_config.menu_id='".$rs_menu['menu_id']."'
				AND training_menu_config.training_staff='1'
				";
				$xresult_num = mysql_db_query($dbnamemaster,$sql_num);
				$rs_num_menu = mysql_fetch_assoc($xresult_num);
			echo '<tr><td>';
			echo '<DIV class="div_menu">';
			echo getTagLevel( $menuitem );
			echo '<input type="checkbox" name="menu_id[]" value="'.$rs_menu['menu_id'].'" '.(($rs_num_menu['num_menu']>0)?"CHECKED":"").'  onclick="checkGroupAll(\'menu_config\',\'all\')" >';
			echo ':: '.$rs_menu["menu_name"];
			echo '</DIV>';
			echo '</td>';
			echo '</tr>';
			showMenu( $rs_menu["menu_id"], $menuitem );
	}
}
if($_POST['menu_config']=='add'){
	$sql_del = "DELETE FROM training_menu_config WHERE training_staff='1' ";
	mysql_db_query($dbnamemaster,$sql_del);
	foreach($_POST['menu_id'] as $menu_id){
		$sql_insert = "INSERT INTO training_menu_config SET menu_id='".$menu_id."' , training_staff='1' ";
		mysql_db_query($dbnamemaster,$sql_insert);
	}
	echo '<script>alert(\'บันทึกข้อมูลเรียบร้อยแล้ว\'); window.parent.leftFrame.location.reload();window.location=\'menu_config.php\';</script>';
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.div_menu{
	margin:0px;
	background-color:#EEEEEE;
	padding:1px;
	border-bottom:#CCCCCC 1px solid;
}
.div_menu:hover{
	margin:0px;
	background-color:#D7D7D7;
	padding:1px;
	border-bottom:#CCCCCC 1px solid;
}
.go {
	BORDER: #09629A 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 14px; 
	BACKGROUND: url(../hr_report/images/hdr_bg.png) #5599C4 repeat-x 0px -1px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 35px;
	cursor:hand;
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #005C96 1px solid; 
	BACKGROUND: url(../hr_report/images/hdr_bg.png) #5599C4 repeat-x 0px -263px; 
}
-->
</style>
<script>
function checkAll(obj,check_id){
	var tagMeta = document.getElementById(check_id).getElementsByTagName ( 'input' );
	if(document.getElementById(obj.id).checked==true){
		for(i=0;i<tagMeta.length;i++){
			if(tagMeta[i].type == "checkbox"){
				inputs = tagMeta[i];
				inputs.checked = true;
			}
		}
	}else{
		for(i=0;i<tagMeta.length;i++){
			if(tagMeta[i].type == "checkbox"){
				inputs = tagMeta[i];
				inputs.checked = false;
			}
		}
	}
}
function checkGroupAll(group_id,main_id){
	var tagMeta = document.getElementById(group_id).getElementsByTagName ( 'input' );
	var checkInt=0;
	var checkIntAll=0;
	for(i=0;i<tagMeta.length;i++){
		if(tagMeta[i].type == "checkbox" && tagMeta[i].name != "all"){
			inputs = tagMeta[i];
			checkIntAll++;
			if(inputs.checked == true ){
				checkInt++;
			}
		}
	}
	if( checkIntAll == checkInt){
		document.getElementById(main_id).checked = true;
	}else{
		document.getElementById(main_id).checked = false;
	}
}
</script>
</head>
<body onload="checkGroupAll('menu_config','all');" >
<p/>
<form action="" method="post">
<table align="center" width="500" id="menu_config"  cellpadding="0" cellspacing="0" style="border:1px #CCCCCC solid;">
<tr bgcolor="#006699">
<td style="color:#FFFFFF; font-size:14px; height:25px;"><strong>ตั้งค่าเมนูสำหรับการ training</strong></td>
<tr bgcolor="#CCCCCC">
	<td><input type="checkbox" name="all" id="all" onclick="checkAll(this,'menu_config');" /> เลือกทั้งหมด</td>
</tr>
</tr>
<?php
showMenu(0,0);
?>
<tr >
<td  align="center" height="35">
<input type="hidden" name="menu_config" value="add"/>
<input type="submit" name="b_submit" value="บันทึกการตั้งค่า"/>
</td>
</tr>
</table>
</form>
<p/>
</body>
</html>
