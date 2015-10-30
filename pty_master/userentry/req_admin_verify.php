<?php
### create date : 23/04/2011 11:13
### create by : worasak jencharoenpokai (sak)
### application name : req_admin_verify

include ("../../config/conndb_nonsession.inc.php") ;
include("../../common/common_competency.inc.php");
include("function_assign_edit.php");


if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($_POST[Submit] != ""){
		foreach($che as $key => $val){
			$req_person_id = $val;
			mysql_query("UPDATE req_temp_wrongdata SET status_req_approve=1 WHERE req_person_id='$req_person_id'");
			
			### 
			$get_id = $_POST["temp_id".$req_person_id];
			$xtype = $_POST["working".$req_person_id];
//			echo $get_id."<hr>";
//			echo $xtype;
//			exit;
			EAssignEditKey("$get_id","$xtype");
		}
	}
}

	  
### binding TABLE : req_problem_type 
$sql_pb = "SELECT * FROM req_problem_type WHERE status=1 ";
$res_pb = mysql_query($sql_pb);
$arr_pb = array();
while($row_pb = mysql_fetch_assoc($res_pb)){
	$arr_pb[$row_pb[runno]] = $row_pb[problem_typename];
}

### problem group
$sql_gp = "SELECT * FROM req_problem_group";
$res_gp = mysql_query($sql_gp);
$arr_group = array();
while($row_gp = mysql_fetch_assoc($res_gp)){
	$arr_group[$row_gp[runno]] = $row_gp[problem_name];
}

//echo "<pre>";
//print_r($arr_pb);
//exit;
### +++++++++++++++++++++++++++++++++
	 
### get Main Data
$row_page = 100;

### count all data
$sql_cn = "SELECT 
			COUNT(req_temp_wrongdata.req_person_id) AS cn
		FROM
			req_temp_wrongdata 
			INNER JOIN req_problem 
				ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
		WHERE 
			req_temp_wrongdata.problem_type = 1
		";
$res_cn = mysql_query($sql_cn);
$row_cn = mysql_fetch_assoc($res_cn);
$row_count = $row_cn[cn];
$page_count = round($row_count/$row_page);
//echo $row_count."<hr>";
//echo $page_count."<hr>";
//exit;
$row_limit = $row_page;

if($_GET[page_no] > 1){
	$row_limit = ((($page_no-1)*$row_page)+1).",".$row_page;
} else {
	$page_no = 1;
}
	
$sql = "SELECT 
			* 
		FROM
			req_temp_wrongdata 
			INNER JOIN req_problem 
				ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
			LEFT JOIN req_problem_group ON req_problem_group.runno = req_problem.problem_group
		WHERE 
			req_temp_wrongdata.problem_type = 1
		LIMIT $row_limit 
		";
//echo $sql;
//exit;		
$res = mysql_query($sql);
//$row = mysql_fetch_assoc($res);
### +++++++++++++++++++++++++++++++++

### private function ###
function dateFormat($value,$type){
	if($type=="engthai"){
	
		$day = explode("-",$value);
		$date = $day[2].'/'.$day[1].'/'.($day[0]+543);			
			
	}else if($type=="thaieng"){
	
		$day = explode("/",$value);
		$date = ($day[2]-543).'-'.$day[1].'-'.$day[0];
		
	}else if($type=="thaidot"){
	
		$Month = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
		$day = explode("-",$value);
		$Y = $day[0];
		$m = $day[1];
		if($m<10){
			$m = str_replace("0","",$m);
		}
		$d = $day[2]*1;
		if($d == 0)
		{
			$date = '-';
		}
		else
		{
			$date = $d.' '.$Month[$m].' '.($Y+543);
		}
		
	}else if($type=="thaithaidot"){
		//echo "test";
		
		$Month = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
		$day = explode("-",$value);
		$Y = $day[0];
		$m = $day[1];
		if($m<10){
			$m = str_replace("0","",$m);
		}
		$d = $day[2]*1;
		$date = $d.' '.$Month[$m].' '.($Y);
		if($date==0){
			$date='-';
		}
		
	}
	else if($type==""){
	
		$date = explode("-",$value);
		
	}
	
	return $date;
}

function update_problem_type($problem_type){
	$sql_upd = "UPDATE req_problem_type SET problem_type='$problem_type'";
	$res_upd = mysql_query($sql_upd);
	if($res_upd){
		return true;
	} else {
		return false;
	}
}
### +++++++++++++++++++++++++++++++++
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>requested verify & assign </title>
<style>

.bg_frame{background-color:#CC99CC;}
.bg_frame_td{background-color:#FFDDFF}
.bg_table{background-color:#666666}
.bg_table_heder{background-color:#CCCCFF}
.bg_table_data{background-color:#FFFFFF}
.bg_table_data2{background-color:#FFC1FF}
.header_label{font-size:12px; font-family:tahoma; font-weight:900; text-align:center}
.title_label{font-size:14px; font-family:tahoma; font-weight:900}
.button_action{width:115px; height:35px; font:20px bolder;}
.select_status{width:105px;  font-size:12px; font-family:tahoma;}
.group_status{width:135px;  font-size:12px; font-family:tahoma;}
.button_delete{width:50px; height:25px; font-size:12px; font-family:tahoma;}
.page_box{height:25px; width:20px; padding:3 3 3 3; background-color:#CC99CC; border:0px}

body{font-size:12px; font-family:tahoma;}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="?page_no=<?=$page_no?>">
<table align="center" width="99%" border="0" cellspacing="10" cellpadding="1">
  <tr>
    <td align="center"><span class="title_label">รายการร้องขอแก้ไขข้อมูล ที่พิมพ์ผิด</span></td>
  </tr>
  <tr>
    <td align="center"><table class="page_box" cellpadding="3" cellspacing="1" ><tr>
	<?php 
		$j=1;
		for($i=1; $i<=$page_count; $i++){
	?>
	
      <td onmouseover="this.style.backgroundColor='#CCCCCC'; this.style.cursor='pointer'" onmouseout="this.style.backgroundColor='<?=$page_no==$i ? "#CCCCCC" : "#FFFFFF"?>'" style="background-color:<?=$page_no==$i ? "#CCCCCC" : "#FFFFFF"?>" class="bg_table_data" align="center" onclick="location.href='?page_no=<?=$i?>'"><strong><?=($i)?></strong></td>
   		
	<?php
		echo ($i % 30 == 0) ? "</tr><tr>" : "";
		}
	?></tr></table>	</td>
  </tr>
  <tr>
    <td ><img src="images/approve.gif" align="absmiddle"/> : จ่ายงาน (Assigned)</td>
  </tr>
</table>

<table class="bg_frame" align="center" width="99%" border="0" cellspacing="1" cellpadding="10"><tr><td class="bg_frame_td" valign="top" height="100%">

<table class = "bg_table" align="center" width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr class="bg_table_heder">
    <td width="4%" class="header_label">ลำดับ</td>
    <td width="3%" class="header_label"><input name="che_all" type="checkbox" value="" onclick="clickall(this);" /></td>
    <td width="9%" class="header_label">วันที่ร้องขอ<br>
      แก้ไขข้อมูล</td>
    <td class="header_label">รายละเอียดปัญหา</td>
    <td width="5%" class="header_label">พนักงาน</td>
    <td width="5%" class="header_label">รหัสเขต</td>
    <td width="22%" class="header_label">หมวดคำร้อง</td>
    <td width="17%" class="header_label">ปัญหาคำร้อง</td>
    <td width="9%" class="header_label">สถานะ</td>
    <td width="7%" class="header_label">การจัดการ</td>
  </tr>
  <?php
  	$rowIndex =0;
	if($page_no > 1){
		$rowIndex = ($page_no-1)*$row_page;
	}
  	while($row = mysql_fetch_assoc($res)){
		$rowIndex++;
		$class_color = $rowIndex % 2 ? "bg_table_data" : "bg_table_data2";
	
  ?>
  <tr class="<?=$class_color?>">
    <td><?=$rowIndex?></td>
	<?php
		$chk = "";
		if($row[status_req_approve] == 1){
			$chk = "checked";
		}
		
		$enable = "";
		if($row[status_req_approve] == 1){
			$enable = "disabled";	
		}
	?>
    <td><input type="hidden" name="temp_id<?=$row[req_person_id]?>" id="temp_id<?=$row[req_person_id]?>" value="<?=$row[runid]?>" /><input type="hidden" name="working<?=$row[req_person_id]?>" id="working<?=$row[req_person_id]?>" value="<?=$row[status_permit]?>" /><input name="che[]" <?=$enable?> id="che_<?=$row[req_person_id]?>" <?=$chk?> type="checkbox" value="<?=$row[req_person_id]?>"/></td>
    <td align="center"><?=dateFormat($row[req_date],'thaidot')?></td>
    <td><span><?=$row[problem_detail]?></span></td>
    <td align="center"><?=$row[status_permit]?></td>
    <td align="center"><?=$row[siteid]?></td>
    <td>
	<?php
		### ++++ กรณีที่ ตรวจสอบ แล้ว ไม่สามารถ ทำการลบ คำร้องนี้ได้
		if($row[status_req_approve] != 1){ 
	?>
	<label>
      <select name="group_<?=$row[req_person_id]?>"  id="group_<?=$row[req_person_id]?>" class="group_status">
		<?php
			foreach($arr_group AS $proglem_id => $problem_name){
				$stld = "";
				if($proglem_id == $row[runno]){
					$stld = "selected";
				}
				echo "<option value='".$proglem_id."' $stld>".$problem_name."</option>";
			}
		?>
      </select>
      <input type="button" name="save_<?=$row[req_person_id]?>" id="save_<?=$row[req_person_id]?>" value="บันทึก" style="width:43px; font-size:10px; font-family:tahoma" />
    </label>
	<?php
		}
	?>	</td>
    <td>
	<?php
		### ++++ กรณีที่ ตรวจสอบ แล้ว ไม่สามารถ ทำการลบ คำร้องนี้ได้
		if($row[status_req_approve] != 1){ 
	?>
	<label>
      <select name="select_<?=$row[req_person_id]?>"  id="select_<?=$row[req_person_id]?>" class="select_status">
		<?php
			foreach($arr_pb AS $runno => $pb_typename){
				$stld = "";
				if($runno == $row[problem_type]){
					$stld = "selected";
				}
				echo "<option value='".$runno."' $stld>".$pb_typename."</option>";
			}
		?>
      </select>
      <input type="button" name="button_<?=$row[req_person_id]?>" id="button_<?=$row[req_person_id]?>" value="บันทึก" style="width:43px; font-size:10px; font-family:tahoma" onclick="update_problemtype('<?=$row[req_person_id]?>') " />
    </label>
	<?php
		}
	?>	</td>
    <td align="center"><?=$row[status_req_approve] == 1 ? "<img src=\"images/approve.gif\" align=\"absmiddle\"/>" : "-"?></td>
    <td align="center">
	<?php
		### ++++ กรณีที่ ตรวจสอบ แล้ว ไม่สามารถ ทำการลบ คำร้องนี้ได้
		if($row[status_req_approve] != 1){ 
	?>
	<input type="submit" name="Submit2" value="ลบ" class="button_delete" />
	<?php
		}
	?>&nbsp;</td>
  </tr>
  <?php } ?>
  <tr class="bg_table_data2">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td></tr></table>
<table align="center" width="99%" border="0" cellspacing="10" cellpadding="1">
  <tr>
    <td align="center"><span class="title_label">
      <label>
      <input type="submit" name="Submit" value="Approved" class="button_action" />
      </label>
    </span></td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
	function clickall(e){
		var o = document.form1.elements;
		
		var t = document.getElementById("che");
		for(i=0; i<o.length; i++){
			var c = document.form1.elements[i];
			if(c.type == "checkbox"){
				c.checked = e.checked;
			}
		}
	}

	function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {	XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");	}
		catch(e){
			try{	XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");		} 
			catch(oc) {	XmlHttp = null;		}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	}

	function update_problemtype(req_person_id){
		var sel = document.getElementById("select_"+req_person_id);
		var problem_type = sel.options[sel.options.selectedIndex].value;
		var problem_type_name = sel.options[sel.selectedIndex].text;
		
		if(!confirm("ยืนยัน เปลี่ยนแปลงเป็น คำร้องประเภท '"+problem_type_name+"'")){
			return false;
		}
		CreateXmlHttp();

		
		var params = "req_person_id="+req_person_id+"&problem_type="+problem_type;
		XmlHttp.open("get", "ajax.update_problemtype.php?"+params ,true);
		XmlHttp.onreadystatechange=function() {
			if (XmlHttp.readyState==4) {
				if (XmlHttp.status==200) {
					var res = XmlHttp.responseText;
					//alert(res);
					if(res == "Y"){

						location.reload();
					}
				} else if (XmlHttp.status==404){	
					alert("ไม่สามารถทำการดึงข้อมูลได้");
				} //else {	alert("Error : "+XmlHttp.status);	}
			}
		}
		
		XmlHttp.send(null);	
	}	
</script>