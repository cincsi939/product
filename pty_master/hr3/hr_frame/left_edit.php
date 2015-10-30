<?
session_start();
$id = $_GET[id];

/*
ความหมายค่า $_SESSION['training_staff']
0=ไม่อยู่ในกลุ่มtraining, 1=อยู่ในกลุ่มผู้รับการtraining, 2=ผู้ให้การtraining
*/
include("../../../config/db.inc.php");

function getTagLevel( $num ){
	$tag = "";
	for($i=0;$i<$num;$i++){
		$tag .= "&nbsp;&nbsp;";
	}
	return $tag;
}

function showMenu( $menu_id = "" , $parent = 0){
	global $dbnamemaster;
	global $id,$rs_siteid;
	$sql = "SELECT
				training_menu_config.training_staff,
				training_menu_config.menu_id,
				training_menu.menu_id,
				training_menu.menu_name,
				training_menu.parent_id,
				training_menu.menu_url,
				training_menu.target,
				training_menu.param,
				training_menu.update_date,
				training_menu.create_date
				FROM
				training_menu_config
				Inner Join training_menu ON training_menu_config.menu_id = training_menu.menu_id  
				WHERE 
				training_menu.status_active='1'  and 
				training_menu.parent_id='".$menu_id."' 
				AND training_menu_config.training_staff='".(($_SESSION['training_staff']!="")?1:0)."'
				";
	$xresult2 = mysql_db_query($dbnamemaster,$sql);
	$menuitem=$parent;
	$menuitem++;
	while ($rs_menu=mysql_fetch_assoc($xresult2)){	
	#################  
	if($rs_menu[menu_id] == "18"){
		if($_SESSION[session_site] != "" or $_SESSION[session_sapphire] == "1"){
				$open_menu = "1";
		}else{
				$open_menu = "0";
		}
	}else{
			$open_menu = "1";	
	}//end if($rs_menu[menu_id] == "18"){
		
		if($open_menu == "1"){
		
			echo '<tr><td>';
			#ค่า $param
			$param = str_replace("\$id" ,$id,$rs_menu["param"]);
			$param = str_replace("\$rs_siteid" ,$rs_siteid,$param);
			
			echo '<a href="'.$rs_menu["menu_url"].$param.'" target="'.$rs_menu["target"].'" class="a_menu">';
			echo '<DIV class="div_menu">';
			echo getTagLevel( $menuitem ).':: '.$rs_menu["menu_name"];
			echo '</DIV>';
			echo '</a>';
			echo '</td>';
			echo '</tr>';
			showMenu( $rs_menu["menu_id"], $menuitem );
		}//end if($open_menu == "1"){
	}
}


/*echo "<pre>";
print_r($_SESSION);die;
*/
#$sql="select * from log_req_notapprove where general_id='$id' and status='1';";
$sql="select * from log_req_notapprove where general_id='$id' and  ( status='1' or status='2' )      ;";
#echo $sql ; 
$result = @mysql_query($sql);
if (@mysql_num_rows($result)){
	$menu_flag = array(
		"general"=>"",	
		"pic_history"=>"",
		"graduate"=>"",	
		"salary"=>"",	
		"seminar"=>"",	
		"sheet"=>"",	
		"getroyal"=>"",	
		"special"=>"",
		"start_work"=>"",	
		"goodman"=>"",	
		"absent"=>"",	
		"nosalary"=>"",	
		"prohibit"=>"",	
		"specialduty"=>"",	
		"other"=>""	
	);
	while ($rs = mysql_fetch_assoc($result)){
		$menu_flag["general"] += $rs["i1_general"];
		$menu_flag["pic_history"] += $rs["i1_general"];
		$menu_flag["graduate"] += $rs["i2_graduate"];
		$menu_flag["salary"] += $rs["i3_salary"];
		$menu_flag["seminar"] += $rs["i4_seminar"];
		$menu_flag["sheet"] += $rs["i5_sheet"];
		$menu_flag["getroyal"] += $rs["i6_getroyal"];
		$menu_flag["special"] += $rs["i7_special"];
		$menu_flag["goodman"] += $rs["i8_goodman"];
		$menu_flag["absent"] += $rs["i9_absent"];
		$menu_flag["nosalary"] += $rs["i10_nosalary"];
		$menu_flag["prohibit"] += $rs["i11_prohibit"];
		$menu_flag["specialduty"] += $rs["i12_specialduty"];
		$menu_flag["other"] += $rs["i13_other"];
		$menu_flag["start_work"] += $rs["i3_salary"];
	} //while
}else{
	$menu_flag = array(
		"general"=>"1",	
		"pic_history"=>"1",
		"graduate"=>"1",	
		"salary"=>"1",	
		"seminar"=>"1",	
		"sheet"=>"1",	
		"getroyal"=>"1",	
		"special"=>"1",	
		"start_work"=>"1",
		"goodman"=>"1",	
		"absent"=>"1",	
		"nosalary"=>"1",	
		"prohibit"=>"1",	
		"specialduty"=>"1",	
		"govplan"=>"1",
		"other"=>"1"	
	);
}
$total_menu = 0;
foreach ($menu_flag as $menukey => $flag){
	$total_menu += $flag;
}

$sql_get_site = "SELECT siteid FROM `view_general` WHERE CZ_ID='".$id."' ";
$result_site = mysql_query($sql_get_site);
$rs_site = mysql_fetch_assoc($result_site);
$rs_siteid =$rs_site['siteid'];


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
	padding:2px;
	cursor:pointer;
	border-bottom:#CCCCCC 1px solid;
}
.div_menu:hover{
	margin:0px;
	background-color:#D7D7D7;
	padding:2px;
	cursor:pointer;
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
</head>
<body bgcolor="#7187BD">
<table width="205" border="0" cellspacing="0" cellpadding="0" bgcolor="eeeeee" style="border:1px #5595CC solid;">
  <tr>
    <td height="12" style="padding: 1px ; background-image:url(../../../images_sys/tophi_03.jpg)"><font style="font-size:16px; font-weight:bold; color:#444444;">&nbsp;เมนู</font></td>
  </tr>
  <tr>
    <td bgcolor="#eeeeee" class="normal_black" height="3"></td>
  </tr>
 	<?php
	//แสดงเมนูทั่วไป
	showMenu(0,0);
	//แสดงเมนูการตั้งค่าเมนู
	if($_SESSION['training_staff']==2){
		echo '<tr><td>';
		echo '<a href="menu_config.php" target="mainFrame" class="a_menu">';
		echo '<DIV class="div_menu">';
		echo '&nbsp;&nbsp;:: ตั้งค่าเมนูสำหรับการ Training';
		echo '</DIV>';
		echo '</a>';
		echo '</td>';
		echo '</tr>';
	}

if ($total_menu == 0){ //ไม่มีเมนูเลย
	echo "<script>alert('ท่านไม่สามารถแก้ไขข้อมูลได้'); top.location.href='../hr_report/logout_edit.php';</script>";	
}else if (intval($menu_flag["general"]) == 0){ //เมนูแรกไม่ใช่ general
	echo "<script>window.open('$default_url','mainFrame');</script>";
}
?>  
</table>
 <? 
if($_SESSION[tmpuser] != ""){
		$xvalue = "ปิดหน้าต่าง";
		$xonclick = "parent.window.close()";	
}else{
		$xvalue = "ออกจากระบบ";
		$xonclick = "parent.window.location='logout.php'";
}
#if($_SESSION[session_sapphire] != ""){
if(substr($_SERVER['REMOTE_ADDR'],0,8) == "192.168."){
	?>
<table width="205" border="0" cellspacing="0" bgcolor="eeeeee" style="border:1px #5595CC solid; margin-bottom:5px">
  <tr>
    <td><iframe name="" src="../../msg_alert/user/index.php?xid=<?=$id?>" frameborder="0" width="100%" height="50px" scrolling="no"></iframe> 
    <iframe name="checkbandwidth" src="../../checkbandwidth/index.php?xid=<?=$id?>&user=1" frameborder="0" width="100%" height="0px" scrolling="no" ></iframe></td>
  </tr>
</table>
<?
}
if($_SESSION[secid] == "9999"){ // กรณีเป็นเขตที่ใช้ฝึกอบรมสำหรับการคีย์ข้อมูลให้มีปุ่มในการล้างข้อมูล
?>
&nbsp;&nbsp;&nbsp;<a href="../hr_report/script_clear_data_training.php" target="_blank">
<h2>ล้างข้อมูลฝึกอบรม</h2>
</a><br />
<!--&nbsp;&nbsp;&nbsp;<input type="button" name="btnC" class="go" value="ล้างข้อมูลอบรม" onclick="location.href='../hr_report/script_clear_data_training.php'" style="cursor:hand"><br /><br />-->
 <?
}
?>
  <!--<input name="Button" type="button" class="go" value="ออกจากระบบ"  onclick="parent.window.location='<?=$mainwebsite?>'">-->
  <!--<input name="Button" type="button" class="go" value="ออกจากระบบ"  onclick="parent.window.location='logout.php'">-->
  <input name="Button" type="button" class="go" value="<?=$xvalue?>"  onclick="<?=$xonclick?>">

  <br>
</p>
</body>
</html>
