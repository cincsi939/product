<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_graduate";
$module_code 		= "graduate"; 
$process_id			= "graduate";
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
$time_start = getmicrotime();
include ("../../../config/phpconfig.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){
	
	add_log("ข้อมูลการศึกษา",$id,$action);
	if($_POST[action]=="edit2"){

	if($grade_update=="d1"){
		$sql 	= " update graduate set place='$place', startyear='$startyear' , finishyear = '$finishyear' , grade = '$grade',university_level='$university',major_level='$minor',degree_level='$level1_1', year_label='$year_label', minor_level='$minor1',major_label='$major_label',minor_label='$minor1_label',type_graduate='$up_clas', kp7_active='$kp7' where id ='$id' and runid='$runid'; ";
		
		$returnid = add_monitor_logbefore("graduate","  id ='$id' and runid='$runid'  ");
		 mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
		 add_monitor_logafter("graduate"," id ='$id' and runid='$runid' ",$returnid);
		 
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id';
				</script>
				";
				exit;
		
		}else if($grade_update=="d2"){
	$sql = " update graduate set place='$university1', startyear='$startyear' , finishyear = '$finishyear' , grade = '$level1',major_label='$major1',minor_label='$minor_1',type_graduate='$up_clas', year_label='$year_label', kp7_active='$kp7' where id ='$id' and runid='$runid'; ";
	
	$returnid = add_monitor_logbefore("graduate","  id ='$id' and runid='$runid'  ");
	 mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
	 add_monitor_logafter("graduate"," id ='$id' and runid='$runid' ",$returnid);
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id';
				</script>
				";
				exit;
		}else{
		$sql="update graduate set place='$place', startyear='$startyear', finishyear='$finishyear', year_label='$year_label', grade='$grade', type_graduate='$up_clas', kp7_active='$kp7' where id ='$id' and runid='$runid'";

	$returnid = add_monitor_logbefore("graduate","  id ='$id' and runid='$runid'  ");
	mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
	add_monitor_logafter("graduate"," id ='$id' and runid='$runid' ",$returnid);
	
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id';
				</script>
				";
				exit;
		}
		
	} elseif($action == "changeRow"){
		
		for($i=0;$i<count($runno);$i++){
			$sql		= " update graduate set runno='".$runno[$i]."' where id='".$id."' and runid='".$runid[$i]."' ";		
			$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		}
		header("Location: ?id=$id");
		echo"<meta http-equiv='refresh' content='0;URL=graduate.php'>";
		exit;
			
	} else {
	
	  	$result 	= mysql_query(" select max(runno) as runno from graduate where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  		$rs		= mysql_fetch_assoc($result);
	  	$runno	= ($rs[runno] <= 0) ? 1 : ($rs[runno] + 1);
		mysql_free_result($result);
		unset($rs);	
		if($level_grade=="grade1"){
		
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$clas_g','$highgrade') ";
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);

		}else if($level_grade=="grade2"){

		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$clas_g','$highgrade') ";
		
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);

		}else if($level_grade=="grade3"){
		
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$clas_g','$highgrade') ";
		
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);
		
		}else if($level_grade=="grade4"){
		
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$clas_g','$highgrade') ";
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);
		
		}else if($level_grade=="grade5"){
		
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$clas_g','$highgrade') ";

	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);
		}else if($level_grade=="grade6"){
				if($show=="d1"){
				$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,university_level,major_level,major_label,degree_level,minor_level,minor_label,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$university','$minor','$minor_label','$level1_1','$minor1','$minor1_label','$clas_g','$highgrade') ";

				}else{
				$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,major_label,minor_label,type_graduate,graduate_level) VALUES ('$id','$university_2','$startyear','$finishyear','$year_label','$level_2', '$runno','$major_2','$minor_2','$room_g','$highgrade')";
				}
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);
	
	
		### บันทึกข้อมูลระดับ ป.บัณฑิต
		}else if($level_grade == "grade6_1"){
			if($show=="d1"){
				$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,university_level,major_level,major_label,degree_level,minor_level,minor_label,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$university','$minor','$minor_label','$level1_1','$minor1','$minor1_label','$clas_g','$highgrade') ";

				}else{
				$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,major_label,minor_label,type_graduate,graduate_level) VALUES ('$id','$university_2','$startyear','$finishyear','$year_label','$level_2', '$runno','$major_2','$minor_2','$room_g','$highgrade')";
				}
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);

		### end บันทึกข้อมูลระดับ ป. บัณฑิต
		}else if($level_grade=="grade7"){
			if($show=="d1"){
			$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,university_level,major_level,major_label,degree_level,minor_level,minor_label,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$university','$minor_master','$minor_label','$level1_1','$minor1_master','$minor1_label','$clas_g','$highgrade') ";

			}else{
			$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,major_label,minor_label,type_graduate,graduate_level) VALUES ('$id','$university_2','$startyear','$finishyear','$year_label','$level_2', '$runno','$major_2','$minor_2','$room_g','$highgrade') ";

			}
		
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);
		
		}else if($level_grade=="grade8"){
				if($show=="d1"){
							$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,university_level,major_level,major_label,degree_level,minor_level,minor_label,type_graduate,graduate_level) VALUES ('$id','$place','$startyear','$finishyear','$year_label','$grade', '$runno','$university','$minor_doctor','$minor_doctor_label','$level1_a1','$minor1_doctor','$minor1_doctor_label','$clas_g','$highgrade') ";

				}else{
				$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,year_label,grade, runno,major_label,minor_label,type_graduate,graduate_level) VALUES('$id','$university_2','$startyear','$finishyear','$year_label','$level_2', '$runno','$major_2','$minor_2','$room_g','$highgrade')";

				}
	$returnid = add_monitor_logbefore("graduate","");
	$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
	$max_idx = mysql_insert_id();
	add_monitor_logafter("graduate"," id ='$id' and runid ='$max_idx' ",$returnid);

		
		}else{
		
			$sql = "INSERT INTO  seminar  (id,startdate,enddate,subject,versions,place,stype,note,kp7_active) 
				VALUES ('$id','$startdate','$enddate','$subject','$versions','$place','$stype','$note','$kp7_active')";
		
		$returnid = add_monitor_logbefore("seminar","");
		$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
		$max_idx = mysql_insert_id();
		add_monitor_logafter("seminar"," id ='$id' and runid ='$max_idx' ",$returnid);
		

		}
		//echo $sql;die;
			
			echo "
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id';
				</script>
				";
	//	header("Location: ?id=$id&action=edit");
		exit;				
	
	}
	
} elseif($_GET[action] == 'delete') {
	
	add_log("ข้อมูลการศึกษา",$id,$action);
	mysql_query(" delete from graduate where id = '$id' and runid='$runid'; ")or die("ไม่สามารถลบข้อมูลได้");
	//header("Location: ?id=$id");
	echo"<meta http-equiv='refresh' content='0;URL=graduate.php?id=$id&action='''>";
	exit();
	
} else {		

 	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql);
	$rs		= mysql_fetch_assoc($result);

}
	
?>
<html>
<head>
<title>ประวัติการศึกษา</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
<link href="libary/tab_style.css" rel="stylesheet" type="text/css">
<link href="hr.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="libary/tabber.js"></script>

<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');

<!--
function check_doc()
{

var radio_choice = false;

for (counter = 0; counter < post_doc.show.length; counter++)
{
if (post_doc.show[counter].checked)
radio_choice = true; 
}

if (!radio_choice)
{
alert("กรุณาเลือกวุฒิการศึกษาในประเทศหรือต่างประเทศ")
return (false);
}else if(document.post_doc.finishyear.value.length == 0){
		alert("ระบุ ปีพ.ศ. เพื่อเก็บข้อมูลทางสถิติ");
		document.post_doc.finishyear.focus();
		return false;
}else if(document.post_doc.university.value.length == 0 & document.post_doc.place.value.length == 0){
		alert("กรุณาระบุสถานศึกษา");
		document.post_doc.university.focus();
		return false;
}else if(document.post_doc.level1_a1.value.length == 0 & document.post_doc.grade.value.length == 0){
		alert("กรุณาระบุวุฒิการศึกษา");
		document.post_doc.level1_a1.focus();
		return false;
}else{
	return (true);
	}
}

-->
</script>
    
<script language="JavaScript">
<!--
function check_m()
{

var radio_choice = false;

for (counter = 0; counter < post_m.show.length; counter++)
{
if (post_m.show[counter].checked)
radio_choice = true; 
}

if (!radio_choice)
{
alert("กรุณาเลือกวุฒิการศึกษาในประเทศหรือต่างประเทศ")
return (false);
}else if(document.post_m.finishyear.value.length == 0){
		alert("ระบุ ปีพ.ศ. เพื่อเก็บข้อมูลทางสถิติ");
		document.post_m.finishyear.focus();
		return false;
}else if(document.post_m.university.value.length == 0 & document.post_m.place.value.length == 0){
		alert("กรุณาระบุสถานศึกษา");
		document.post_m.university.focus();
		return false;
}else if(document.post_m.level1_1.value.length == 0 & document.post_m.grade.value.length == 0){
		alert("กรุณาระบุวุฒิการศึกษา");
		document.post_m.level1_1.focus();
		return false;
}else{
	return (true);
	}
}

-->
</script>
 
<script language="JavaScript">
<!--
function check_mm()
{

var radio_choice = false;

for (counter = 0; counter < post_mm.show.length; counter++)
{
if (post_mm.show[counter].checked)
radio_choice = true; 
}

if (!radio_choice)
{
alert("กรุณาเลือกวุฒิการศึกษาในประเทศหรือต่างประเทศ")
return (false);
}else if(document.post_mm.finishyear.value.length == 0){
		alert("ระบุ ปีพ.ศ. เพื่อเก็บข้อมูลทางสถิติ");
		document.post_mm.finishyear.focus();
		return false;
}else if(document.post_mm.university.value.length == 0 & document.post_mm.place.value.length == 0){
		alert("กรุณาระบุสถานศึกษา");
		document.post_mm.university.focus();
		return false;
}else if(document.post_mm.level1_1.value.length == 0 & document.post_mm.grade.value.length == 0){
		alert("กรุณาระบุวุฒิการศึกษา");
		document.post_mm.level1_1.focus();
		return false;
}else{
	return (true);
	}
}

-->
</script>

<script language="javascript">

function check_t(){
	if(document.post_t.subject.value.length == 0){
		alert("ระบุชื่อหลักสูตร");
		document.post_t.subject.focus();
		return false;
	}else {
		return true;
	}
}	

function check(){
	if(document.post1.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post1.place.focus();
		return false;
	}else if(document.post1.finishyear.value.length == 0){
		alert("ระบุ ปีพ.ศ. เพื่อเก็บข้อมูลทางสถิติ");
		document.post1.finishyear.focus();
		return false;
	}else {
		return true;
	}
}	

function check2(){
	if(document.post2.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post2.place.focus();
		return false;
	}else if(document.post2.finishyear.value.length == 0){
	alert("ระบุ ปีพ.ศ.เพื่อเก็บข้อมูลทางสถิติ");
	document.post2.finishyear.focus();
		return false;
	}else {
		return true;
	}
}	

function check3(){
	if(document.post3.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post3.place.focus();
		return false;
	}else if(document.post3.finishyear.value.length == 0){
	alert("ระบุ ปีพ.ศ.เพื่อเก็บข้อมูลทางสถิติ");
	document.post3.finishyear.focus();
		return false;
	}else {
		return true;
	}
}	

function check4(){
	if(document.post4.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post4.place.focus();
		return false;
	}else if(document.post4.finishyear.value.length == 0){
	alert("ระบุ ปีพ.ศ.เพื่อเก็บข้อมูลทางสถิติ");
	document.post4.finishyear.focus();
		return false;
	}else {
		return true;
	}
}	

function check5(){
	if(document.post5.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post5.place.focus();
		return false;
	}else if(document.post5.finishyear.value.length == 0){
	alert("ระบุ ปีพ.ศ.เพื่อเก็บข้อมูลทางสถิติ");
	document.post5.finishyear.focus();
		return false;
	}else {
		return true;
	}
}	


<!-- 
var state = 'none'; 

function showhide(layer_ref) { 

if (state == 'block') { 
state = 'none'; 
} 
else { 
state = 'block'; 
} 
if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 

} 

function showhide1(layer_ref) { 

if (document.getElementById("level").value >=40) { 
state = 'block'; 
}else{ 
state = 'none'; 
} 

if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 

} 

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}


function showhide2() { 
var a = getCheckedValue(document.post.chk_university);
if (a ==1) { 
state = 'block'; 
layer_ref = 'divA';

if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
//--------------------

} // end a ==1

state = 'none'; 
layer_ref = 'divB';

if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 

}else{ 

state = 'none'; 
layer_ref = 'divA';

if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 

state = 'block'; 
layer_ref = 'divB';

if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 

} 
} 
//--> 
 //----------------------------------------------------------------------------------------ปริญญาตรี
 
 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList1() {
   var major = document.getElementById("major").value;
    if(major == "" ) {
        clearproductList1();
        return;
    }
    var url = "ajax_major.php?major_id=" + major;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange1() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList1();
        }
    }
}

function updateproductList1() {
    clearproductList1();
    var minor = document.getElementById("minor");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor.appendChild(option);
	}
    }
}

function clearproductList1() {
    var minor = document.getElementById("minor");
    while(minor.childNodes.length > 0) {
              minor.removeChild(minor.childNodes[0]);
    }
}
//จบ majorวิชาเอก------------------------------------------------------------------------

 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList2() {
   var major1 = document.getElementById("major1").value;
    if(major1 == "" ) {
        clearproductList2();
        return;
    }
    var url = "ajax_minor.php?major_id=" + major1;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange2;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange2() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList2();
        }
    }
}

function updateproductList2() {
    clearproductList2();
    var minor1 = document.getElementById("minor1");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor1.appendChild(option);
	}
    }
}

function clearproductList2() {
    var minor1 = document.getElementById("minor1");
    while(minor1.childNodes.length > 0) {
              minor1.removeChild(minor1.childNodes[0]);
    }
}

// ปริญญาโทร-------------------------------
// วิชาเอก

 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList_master() {
   var major_master = document.getElementById("major_master").value;
    if(major_master == "" ) {
        clearproductList_master();
        return;
    }
    var url = "ajax_graduate_masterdegree.php?major_master_id=" + major_master;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange_master;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange_master() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList_master();
        }
    }
}

function updateproductList_master() {
    clearproductList_master();
    var minor_master = document.getElementById("minor_master");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor_master.appendChild(option);
	}
    }
}

function clearproductList_master() {
    var minor_master = document.getElementById("minor_master");
    while(minor_master.childNodes.length > 0) {
              minor_master.removeChild(minor_master.childNodes[0]);
    }
}
// จบวิชาเอก

// วิชาโทร
 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList2_master() {
   var major1_master = document.getElementById("major1_master").value;
    if(major1_master == "" ) {
        clearproductList1_master();
        return;
    }
    var url = "ajax_graduate_level_masterdegree.php?major_master1_id=" + major1_master;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange1_master;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange1_master() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList1_master();
        }
    }
}

function updateproductList1_master() {
    clearproductList1_master();
    var minor1_master = document.getElementById("minor1_master");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor1_master.appendChild(option);
	}
    }
}

function clearproductList1_master() {
    var minor1_master = document.getElementById("minor1_master");
    while(minor1_master.childNodes.length > 0) {
              minor1_master.removeChild(minor1_master.childNodes[0]);
    }
}

//จบวิชาโทร
// จบปริญญาโทร-------------------

//เริ่มปริญญาเอก
// วิชาเอก

 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList_doctor() {
   var major_doctor = document.getElementById("major_doctor").value;
    if(major_doctor == "" ) {
        clearproductList_doctor();
        return;
    }
    var url = "ajax_graduate_doctor.php?major_doctor_id=" + major_doctor;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange_doctor;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange_doctor() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList_doctor();
        }
    }
}

function updateproductList_doctor() {
    clearproductList_doctor();
    var minor_doctor = document.getElementById("minor_doctor");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor_doctor.appendChild(option);
	}
    }
}

function clearproductList_doctor() {
    var minor_doctor = document.getElementById("minor_doctor");
    while(minor_doctor.childNodes.length > 0) {
              minor_doctor.removeChild(minor_doctor.childNodes[0]);
    }
}
// จบวิชาเอก

// วิชาโทร
 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList2_doctor() {
   var major1_doctor = document.getElementById("major1_doctor").value;
    if(major1_doctor == "" ) {
        clearproductList1_doctor();
        return;
    }
    var url = "ajax_graduate_level_doctor.php?major_doctor1_id=" + major1_doctor;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange1_doctor;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange1_doctor() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList1_doctor();
        }
    }
}

function updateproductList1_doctor() {
    clearproductList1_doctor();
    var minor1_doctor = document.getElementById("minor1_doctor");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           minor1_doctor.appendChild(option);
	}
    }
}

function clearproductList1_doctor() {
    var minor1_doctor = document.getElementById("minor1_doctor");
    while(minor1_doctor.childNodes.length > 0) {
              minor1_doctor.removeChild(minor1_doctor.childNodes[0]);
    }
}
// จบโทร
//จบปริญญาเอก



</script>

<script language="javascript">
function show_table(id) {
if(id == "d1") { // ถ้าเลือก radio button 1 ให้โชว์ table 1 และ ซ่อน table 2 
document.getElementById("table_1").style.display = "";
document.getElementById("table_2").style.display = "none";
} else if(id == "d2") { // ถ้าเลือก radio button 2 ให้โชว์ table 2 และ ซ่อน table 1 
document.getElementById("table_1").style.display = "none";
document.getElementById("table_2").style.display = "";
}
}
</script>
<!--จบปริญญาตรี-->

<script language="javascript">
function show_table1(id1) {
if(id1 == "d1") { // ถ้าเลือก radio button 1 ให้โชว์ table 1 และ ซ่อน table 2 
document.getElementById("table_t1").style.display = "";
document.getElementById("table_t2").style.display = "none";
} else if(id1 == "d2") { // ถ้าเลือก radio button 2 ให้โชว์ table 2 และ ซ่อน table 1 
document.getElementById("table_t1").style.display = "none";
document.getElementById("table_t2").style.display = "";
}
}
</script>
<!--จบปริญญาโท-->

<script language="javascript">
function show_table2(id2) {
if(id2 == "d1") { // ถ้าเลือก radio button 1 ให้โชว์ table 1 และ ซ่อน table 2 
document.getElementById("table_a1").style.display = "";
document.getElementById("table_a2").style.display = "none";
} else if(id2 == "d2") { // ถ้าเลือก radio button 2 ให้โชว์ table 2 และ ซ่อน table 1 
document.getElementById("table_a1").style.display = "none";
document.getElementById("table_a2").style.display = "";
}
}
</script>
<!--จบปริญญาเอก-->
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style4 {
	font-size: 11px;
	color: #000000;
}
.style5 {
	font-size: 11px;
	font-weight: bold;
	color: #000000;
}
.style10 {font-size: 14px; color: #000000; }
.style11 {color: #8C0000}
.style12 {
	font-size: 12px;
	color: #8C0000;
	font-weight: bold;
}
-->
</style>
</head>
<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="421" height="30"><a href="kp7_graduate.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0"align="absmiddle"><span class="style4">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์</span></a></td> 
    <td width="155" height="25"></td>
    <td width="382" height="25"></td>
</tr >
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top"> 
<td align="left">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" dwcopytype="CopyTableRow">
<tr>
  <td align="left" valign="top" ></td>
</tr>
<tr> 
	<td align="left" valign="top" height="30"><b><span class="style4">ชื่อ / สกุล</span> &nbsp;&nbsp; <u>
	  <span class="style4">
	  <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
	  	  </span></u></b></td>
</tr>
<tr>
  <td align="left" valign="top" ></td>
</tr>
<tr> 
	<td align="left" valign="top" height="30">
<span class="style5">๑๐. ประวัติการศึกษา</span></td>
</tr>
</table>
<? if($action ==""){?>
<form name="form1" method="post" action="<?=$PHP_SELF?>">			
<input type="hidden" name="action" value="changeRow">
<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#A3B2CC" align="center" style=" font-weight:bold;"> 
	<td width="8%">เรียงลำดับ</td>
	<td width="25%">สถานศึกษา</td>
	<td width="17%">ตั้งแต่ - ถึง (เดือน ปี)</td>
	<td width="43%">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)</td>
	<td width="7%"><input type="button" name="add" value=" เพิ่มข้อมูล " onClick="location.href='graduate.php?id=<?=$id?>&action=add'"></td>
    <td width="7%">สถานะการแสดงผลใน ก.พ.7</td>
</tr>
<?
$i			= 0;
$result 	= mysql_query("select * from graduate where id='$id' order by runno asc ;");
$row		= mysql_num_rows($result);
while($rs=mysql_fetch_assoc($result)){
	
	$i++;
	$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
	if($rs[finishyear]=="" or $rs[finishyear]=="0"){
		$showdate1 = "$rs[startyear]" ;
	}else if($rs[startyear]==""  or $rs[startyear]=="0" ){
		$showdate1 = "$rs[finishyear]" ;
	}else{
		$showdate1 = "$rs[startyear]"."-"."$rs[finishyear]";
	}
	
?>
<tr bgcolor="<?=$bg?>"> 
	<td align="center">
	<select name="runno[]">
<?
for($e=1;$e<=$row;$e++){
	$selected = ($e == $i) ? " selected " : "" ;
	echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
}
?>	
	</select>	</td>
	<td>
	<?
	if($rs[place] !=""){
		echo $rs[place];
	}else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$id' and graduate.runid='".$rs[runid]."'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	echo $rs11[u_name];
	}
	
	?>
	<INPUT TYPE="hidden" NAME="runid[]" VALUE="<?=$rs[runid]?>">	</td>
	<td align="center"><?
	if($rs[year_label]!=""){echo $rs[year_label];}else{ echo $showdate1;}
	?></td>
	<td>
	<?
	if($rs[grade] !=""){
		echo $rs[grade];
	}
	else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$id' and graduate.runid='".$rs[runid]."'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	echo $rs11[degree_fullname];
	}
	
	?>	</td>
	<td align="center">
	<a href="graduate.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2&&type_graduate=<?=$rs[type_graduate]?>"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a>&nbsp; 
	<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" >	<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
    <td align="center"><? if($rs[kp7_active]=="1"){ echo "<img src=\"../../../images_sys/approve20.png\" alt='แสดงข้อมูลใน กพ7'>";}else{ echo "<img src=\"../../../images_sys/unapprove.png\" alt='ไม่แสดงข้อมูลใน กพ7'>";}?></td>
</tr>
<?
}
mysql_free_result($result);
?>
<tr bgcolor="#dddddd" align="center">
	<td colspan="6">	
	
	<input type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
	<input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='graduate_all.php?'">	</td>
</tr>
</table>
</form>
<?
}else if($_GET[action] == "add"){

?>

<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr bgcolor="">
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>เลือกระดับการศึกษาก่อนทำการเพิ่มข้อมูล</strong></td>
        </tr>

    <?
    	$sql_level = "SELECT * FROM hr_addhighgrade WHERE active_status='1' order by runid ASC";
		$result_level = mysql_db_query($dbnamemaster,$sql_level);
		$i=0;
		while($rs_lv = mysql_fetch_assoc($result_level)){
			$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;$i++;
	?>
      <tr bgcolor="<?=$bg?>">
        <td width="7%" align="center"><img src="../../../images_sys/triangle.jpg" width="11" height="11" border="0"></td>
        <td width="93%" align="left"><a href="?action=edit&sent_level=<?=$rs_lv[runid]?>&sent_label=<?=$rs_lv[highgrade]?>"><?=$rs_lv[highgrade]?></a></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?	
}else if($_GET[action] =="edit"){
	

	$sql 		= "select * from graduate where id='$id' and runid = '$runid'   ;";
	$result 	= mysql_query($sql);	
	$rs		= mysql_fetch_assoc($result);
	
if($sent_level == "03"){
?>
<form name="post1" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade1">
<input type="hidden" name="show" value="">
<input type="hidden" name="highgrade" value="03">
<input type="hidden" name="clas_g" value="clas1">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ<?=$sent_label?></span></td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
	  <span class="style11">*</span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
	<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select> 
 <span class="style11">* รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input type="text" name="year_label" size="25" value="<?=$rs[startyear]?>" maxlength="50">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	  <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>
<?
	}else if($sent_level == "05"){//end if($sent_level == "03"){
				
?>
<form name="post2" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check2();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade2">
<input type="hidden" name="show" value="">
<input type="hidden" name="highgrade" value="05">
<input type="hidden" name="clas_g" value="clas2">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
      <span class="style11">*</span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
		<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select> 
 <span class="style11">* รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input type="text" name="year_label" size="25" value="<?=$rs[startyear]?>" maxlength="50">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
		
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	  <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>	  
<?
	}else if($sent_level == "10"){//end if($sent_level == "05"){
?>
	  
      <form name="post3" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check3();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade3">
<input type="hidden" name="show" value="">
<input type="hidden" name="highgrade" value="10">
<input type="hidden" name="clas_g" value="clas3">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
      <span class="style11">*</span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
 <span class="style11">* 
รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input type="text" name="year_label" size="25" value="<?=$rs[startyear]?>" maxlength="50">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
		
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>
<?
	} // end if($sent_level == "10"){
	else if($sent_level == "20"){
?>
      <form name="post4" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check4();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade4">
<input type="hidden" name="show" value="">
<input type="hidden" name="highgrade" value="20">
<input type="hidden" name="clas_g" value="clas4">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
      <span class="style11">*</span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
 <span class="style11">* 
รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input type="text" name="year_label" size="25" value="<?=$rs[startyear]?>" maxlength="50">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">

	  </td>
</tr>
</table>
</form>
<?
	} //end  else if($sent_level == "20"){
	else if($sent_level == "30"){
?>
	<form name="post5" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check5();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade5">
<input type="hidden" name="show" value="">
<input type="hidden" name="highgrade" value="30">
<input type="hidden" name="clas_g" value="clas5">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
      <span class="style11">*</span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
 <span class="style11">* 
รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input type="text" name="year_label" size="25" value="<?=$rs[startyear]?>" maxlength="50">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>
	
<?
	} //end if($sent_level == "30"){
	else if($sent_level == "40"){
?>
	
<form name="post_m" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check_m();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade6">
<input type="hidden" name="highgrade" value="40">
<input type="hidden" name="clas_g" value="clas6">
<input type="hidden" name="room_g" value="room6">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr>
  <td width="26%" height="25" align="right">กรุณาเลือกวุฒิการศึกษา</td>
      <td width="74%" align="left">
<!--	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
--><input name="show" type="radio" value="d1" onClick="show_table(this.value);"> 
    วุฒิการศึกษาสถาบันในประเทศ 
<!--       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
--><input name="show" type="radio" value="d2" onClick="show_table(this.value);"> 
วุฒิการศึกษาสถาบันต่างประเทศ </td>
</tr>
		<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
<span class="style11">* รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span> </label></td>
</tr>
<td align="right" height="25">&nbsp;</td>
	<td align="left"><input type="text" name="year_label" size="50" >
	  <br>
	  <span class="style11">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
	</tr>
<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
	<!--<div id="div1" style="display: none;">-->

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">

    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divB" style="display: none;">-->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_1" style="display:none"> 
		
		
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td width="26%">&nbsp;</td>
                    <td width="74%">&nbsp;</td>
                  </tr>
			<tr>
          <td align="right" height="25">สถานศึกษา</td>
          <td align="left">
            <select name="university">
			  <option value="">ไม่ระบุ</option>
              <? 
		$sql4 = " SELECT  *  FROM  hr_adduniversity   ORDER BY  u_id  ASC ";
		$result4 	= mysql_db_query($dbnamemaster,$sql4);	
		while($rs4 = mysql_fetch_assoc($result4)){
	  ?>
              <option value="<?=$rs4[u_id]?>"><? echo "$rs4[u_name]";?></option>
              <?  } ?>
            </select>
            &nbsp;<span class="style11">ข้อมูลเชิงสถิติ </span></td>
        </tr>
		<tr> 
	<td width="26%" height="25" align="right"></td>
	<td width="74%" align="left"><input type="text" name="place" size="50" value="<?=$rs[place]?>">
	<span class="style11">ส่วนแสดงผลใน ก.พ.7 </span>
	</td>
</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
		  </tr>
		            <tr height="20">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
  
		  
		  
		  <tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td height="25" colspan="2">วุฒิที่ได้รับระบุสาขาวิชาเอก (ถ้ามี)</td>
                  </tr>
		<tr>
          <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
          <td width="74%" align="left">
		  <select name="level1_1" id="level1_1">
		  <option value="">ไม่ระบุ</option>
		  <?
		  $tem_id=40;
		  	$strSQL="SELECT * FROM $dbnamemaster.hr_adddegree WHERE degree_id LIKE '$tem_id%'";	
			$Result=mysql_query($strSQL);
			while($Rs=mysql_fetch_array($Result)){
			echo " <option value=\"$Rs[degree_id]\">$Rs[degree_fullname]</option>";
			
			}
			
		  ?>
            </select>
           <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">สาขาวิชาเอก</td>
          <td align="left"><select name="major" id="major" onChange="refreshproductList1();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'    ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11">ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">
		  <select name="minor" id="minor">
	
            </select>          
			<input type="hidden" name="minor_label">
			</td>
        </tr>
		        <tr>
          <td align="right" height="25">สาขาวิชาโท</td>
          <td align="left"><select name="major1" id="major1" onChange="refreshproductList2();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'  ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11">ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left"><select name="minor1" id="minor1">
            </select>        
			<input type="hidden" name="minor1_label">
			</td>
        <tr> 
	<td align="right" height="25"></td>
	<td align="left">
	</td>
</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				           <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
			  <td width="41%" bgcolor="#666666"><table width="100%" height="38%" border="0" cellpadding="1" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td>ส่วนแสดงวุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี) </td>
                  </tr>
                  <tr>
                    <td>ตามเอกสาร ก.พ.7 ต้นฉบับ </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="text" name="grade" size="40">
                    </label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="28">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
		  </tr>
		
		

      </table>
<!--	  </div>-->
  <!--<div id="divA" style="display: none;"> -->
        <br>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_2" style="display:none"> 
          <tr>
            <td width="26%" align="right">วุฒิการศึกษา</td>
            <td width="74%"><input name="level_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาเอก</td>
            <td><input name="major_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาโท</td>
            <td><input name="minor_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สถาบันการศึกษา</td>
            <td><input name="university_2" type="text" size="60"></td>
          </tr>
        </table>
	<!--	</div> --><!-- end divB-->		</td>
      </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>
<?
	}//end if($sent_level == "40"){
	else if($sent_level == "50"){	
?>
<form name="post_m" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check_m();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade6_1">
<input type="hidden" name="highgrade" value="50">
<input type="hidden" name="clas_g" value="clas6_1">
<input type="hidden" name="room_g" value="room6_1">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr>
  <td width="26%" height="25" align="right">กรุณาเลือกวุฒิการศึกษา</td>
      <td width="74%" align="left">
<!--	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
--><input name="show" type="radio" value="d1" onClick="show_table(this.value);"> 
    วุฒิการศึกษาสถาบันในประเทศ 
<!--       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
--><input name="show" type="radio" value="d2" onClick="show_table(this.value);"> 
วุฒิการศึกษาสถาบันต่างประเทศ </td>
</tr>
		<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
<span class="style11">* รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span> </label></td>
</tr>
<td align="right" height="25">&nbsp;</td>
	<td align="left"><input type="text" name="year_label" size="50" >
	  <br>
	  <span class="style11">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
	</tr>
<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
	<!--<div id="div1" style="display: none;">-->

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">

    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divB" style="display: none;">-->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_1" style="display:none"> 
		
		
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td width="26%">&nbsp;</td>
                    <td width="74%">&nbsp;</td>
                  </tr>
			<tr>
          <td align="right" height="25">สถานศึกษา</td>
          <td align="left">
            <select name="university">
			  <option value="">ไม่ระบุ</option>
              <? 
		$sql4 = " SELECT  *  FROM  hr_adduniversity   ORDER BY  u_id  ASC ";
		$result4 	= mysql_db_query($dbnamemaster,$sql4);	
		while($rs4 = mysql_fetch_assoc($result4)){
	  ?>
              <option value="<?=$rs4[u_id]?>"><? echo "$rs4[u_name]";?></option>
              <?  } ?>
            </select>
            &nbsp;<span class="style11">ข้อมูลเชิงสถิติ </span></td>
        </tr>
		<tr> 
	<td width="26%" height="25" align="right"></td>
	<td width="74%" align="left"><input type="text" name="place" size="50" value="<?=$rs[place]?>">
	<span class="style11">ส่วนแสดงผลใน ก.พ.7 </span>
	</td>
</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
		  </tr>
		            <tr height="20">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
  
		  
		  
		  <tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td height="25" colspan="2">วุฒิที่ได้รับระบุสาขาวิชาเอก (ถ้ามี)</td>
                  </tr>
		<tr>
          <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
          <td width="74%" align="left">
		  <select name="level1_1" id="level1_1">
		  <option value="">ไม่ระบุ</option>
		  <?
		  $tem_id=50;
		  	$strSQL="SELECT * FROM $dbnamemaster.hr_adddegree WHERE degree_id LIKE '$tem_id%'";	
			$Result=mysql_query($strSQL);
			while($Rs=mysql_fetch_array($Result)){
			echo " <option value=\"$Rs[degree_id]\">$Rs[degree_fullname]</option>";
			
			}
			
		  ?>
            </select>
           <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">สาขาวิชาเอก</td>
          <td align="left"><select name="major" id="major" onChange="refreshproductList1();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'    ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11">ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">
		  <select name="minor" id="minor">
	
            </select>          
			<input type="hidden" name="minor_label">
			</td>
        </tr>
		        <tr>
          <td align="right" height="25">สาขาวิชาโท</td>
          <td align="left"><select name="major1" id="major1" onChange="refreshproductList2();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'  ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11">ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left"><select name="minor1" id="minor1">
            </select>        
			<input type="hidden" name="minor1_label">
			</td>
        <tr> 
	<td align="right" height="25"></td>
	<td align="left">
	</td>
</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				           <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
			  <td width="41%" bgcolor="#666666"><table width="100%" height="38%" border="0" cellpadding="1" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td>ส่วนแสดงวุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี) </td>
                  </tr>
                  <tr>
                    <td>ตามเอกสาร ก.พ.7 ต้นฉบับ </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="text" name="grade" size="40">
                    </label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="28">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
		  </tr>
		
		

      </table>
<!--	  </div>-->
  <!--<div id="divA" style="display: none;"> -->
        <br>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_2" style="display:none"> 
          <tr>
            <td width="26%" align="right">วุฒิการศึกษา</td>
            <td width="74%"><input name="level_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาเอก</td>
            <td><input name="major_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาโท</td>
            <td><input name="minor_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สถาบันการศึกษา</td>
            <td><input name="university_2" type="text" size="60"></td>
          </tr>
        </table>
	<!--	</div> --><!-- end divB-->		</td>
      </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">
	  </td>
</tr>
</table>
</form>
<?
	}//end if($sent_level == "50"){
	else if($sent_level == "60"){
?>
<form name="post_mm" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check_mm();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade7">
<input type="hidden" name="highgrade" value="60">
<input type="hidden" name="clas_g" value="clas7">
<input type="hidden" name="room_g" value="room7">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr>
      <td width="26%" height="25" align="right">กรุณาเลือกวุฒิการศึกษา</td>
      <td width="74%" align="left">
  <input name="show" type="radio" value="d1" onClick="show_table1(this.value);"> 
    วุฒิการศึกษาสถาบันในประเทศ 
<input name="show" type="radio" value="d2" onClick="show_table1(this.value);"> 
วุฒิการศึกษาสถาบันต่างประเทศ </td>
    </tr>
	<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
<span class="style11">*  
รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr> 
	<td align="right" height="25"></td>
	<td align="left"><input type="text" name="year_label" size="50">
	  <span class="style11"><br>
	  หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
	</tr>
<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
	<!--<div id="div1" style="display: none;">-->

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
    
    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divB" style="display: none;">-->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_t1" style="display:none"> 
		
		
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td width="26%">&nbsp;</td>
                    <td width="74%">&nbsp;</td>
                  </tr>
 				<tr>
          <td align="right" height="25">สถานศึกษา</td>
          <td align="left">
            <select name="university">
			  <option value="">ไม่ระบุ</option>
              <? 
		$sql4 = " SELECT  *  FROM  hr_adduniversity   ORDER BY  u_id  ASC ";
		$result4 	= mysql_db_query($dbnamemaster,$sql4);	
		while($rs4 = mysql_fetch_assoc($result4)){
	  ?>
              <option value="<?=$rs4[u_id]?>"><? echo "$rs4[u_name]";?></option>
              <?  } ?>
            </select>
            &nbsp;<span class="style11">ข้อมูลเชิงสถิติ </span></td>
        </tr>
		<tr> 
	<td width="26%" height="25" align="right"></td>
	<td width="74%" align="left"><input type="text" name="place" size="50">
	<span class="style11"> ส่วนแสดงผลใน ก.พ.7  </span>
	</td>
	</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
		  </tr>
		  <tr>
		  <td height="20" align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		  <tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td height="25" colspan="2">วุฒิที่ได้รับระบุสาขาวิชาเอก (ถ้ามี)</td>
                  </tr>
 		<tr>
          <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
          <td width="74%" align="left">
		  <select name="level1_1" id="level1_1">
		   <option value="">ไม่ระบุ</option>
		   <?
		  $tem_id=60;
		  	$strSQL="SELECT * FROM $dbnamemaster.hr_adddegree WHERE degree_id LIKE '$tem_id%'";	
			$Result=mysql_query($strSQL);
			while($Rs=mysql_fetch_array($Result)){
			echo " <option value=\"$Rs[degree_id]\">$Rs[degree_fullname]</option>";
			
			}
			
		  ?>
            </select>
             <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">สาขาวิชาเอก</td>
          <td align="left"><select name="major_master" id="major_master" onChange="refreshproductList_master();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'    ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
             <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left"><select name="minor_master" id="minor_master">
		
            </select>           
			<input type="hidden" name="minor_label">
			</td>
        </tr>

		        <tr>
          <td align="right" height="25">สาขาวิชาโท</td>
          <td align="left"><select name="major1_master" id="major1_master" onChange="refreshproductList2_master();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'  ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">
		  <select name="minor1_master" id="minor1_master">
		
            </select>		
			<input type="hidden" name="minor1_label">
			</td>
        </tr>
        <tr> 
	<td align="right" height="25"></td>
	<td align="left">

	</td>
	</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				   <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

              </table></td>
			  <td width="41%" bgcolor="#666666"><table width="100%" height="38%" border="0" cellpadding="1" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td>ส่วนแสดงวุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี) </td>
                  </tr>
                  <tr>
                    <td>ตามเอกสาร ก.พ.7 ต้นฉบับ </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="text" name="grade" size="40">
                    </label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="28">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
		  </tr>
		
		

      </table>
<!--	  </div>-->
  <!--<div id="divA" style="display: none;"> -->
        <br>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_t2" style="display:none"> 
          <tr>
            <td width="26%" align="right">วุฒิการศึกษา</td>
            <td width="74%"><input name="level_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาเอก</td>
            <td><input name="major_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาโท</td>
            <td><input name="minor_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สถาบันการศึกษา</td>
            <td><input name="university_2" type="text" size="60"></td>
          </tr>
        </table>
	<!--	</div> --><!-- end divB-->		</td>
      </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
		<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">

	  </td>
</tr>
</table>
</form>
<?
	}//end if($sent_level == "60"){
	else if($sent_level == "80"){
?>
<form name="post_doc" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check_doc();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="level_grade" value="grade8">
<input type="hidden" name="highgrade" value="80">
<input type="hidden" name="clas_g" value="clas8">
<input type="hidden" name="room_g" value="room8">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
  <td height="25" colspan="2" align="center"><span class="style10">ประวัติการศึกษาระดับ <?=$sent_label?></span></td>
  </tr>
<tr>
      <td width="26%" height="25" align="right">กรุณาเลือกวุฒิการศึกษา</td>
      <td width="74%" align="left">
<!--	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
-->	  <input name="show" type="radio" value="d1" onClick="show_table2(this.value);"> 
    วุฒิการศึกษาสถาบันในประเทศ 
<!--       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
--><input name="show" type="radio" value="d2" onClick="show_table2(this.value);"> 
วุฒิการศึกษาสถาบันต่างประเทศ </td>
    </tr>
	<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		echo "<option value='$i'>$i</option>";
}
	?>
</select>
<span class="style11">* 
รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr> 
	<td align="right" height="25"></td>
	<td align="left"><input type="text" name="year_label" size="50">
	  <br>
	  <span class="style11">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
	</tr>
<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
	<!--<div id="div1" style="display: none;">-->

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
    
    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divB" style="display: none;">-->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_a1" style="display:none"> 
	<!--เริ่ม-->	
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
			                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                 <tr>
          <td align="right" height="25">สถานศึกษา</td>
          <td align="left">
            <select name="university">
			  <option value="">ไม่ระบุ</option>
              <? 
		$sql4 = " SELECT  *  FROM  hr_adduniversity   ORDER BY  u_id  ASC ";
		$result4 	= mysql_db_query($dbnamemaster,$sql4);	
		while($rs4 = mysql_fetch_assoc($result4)){
	  ?>
              <option value="<?=$rs4[u_id]?>"><? echo "$rs4[u_name]";?></option>
              <?  } ?>
            </select>
            &nbsp;<span class="style11"> ข้อมูลเชิงสถิติ </span></td>
        </tr>
		
		<tr> 
	<td width="26%" height="25" align="right"></td>
	<td width="74%" align="left"><input type="text" name="place" size="50" >
		<span class="style11"> ส่วนแสดงผลใน ก.พ.7  </span>
	</td>
	</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
		  </tr>
	<!--จบ-->	
				<tr>
		  <td height="20" align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td height="25" colspan="2">วุฒิที่ได้รับระบุสาขาวิชาเอก (ถ้ามี)</td>
             
                  </tr>
<tr>
          <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
          <td width="74%" align="left">
		  <select name="level1_a1" id="level1_a1">
		   <option value="">ไม่ระบุ</option>
		     <?
		  $tem_id=80;
		  	$strSQL="SELECT * FROM $dbnamemaster.hr_adddegree WHERE degree_id LIKE '$tem_id%'";	
			$Result=mysql_query($strSQL);
			while($Rs=mysql_fetch_array($Result)){
			echo " <option value=\"$Rs[degree_id]\">$Rs[degree_fullname]</option>";
			
			}
			
		  ?>
            </select>
             <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>

        <tr>
          <td align="right" height="25">สาขาวิชาเอก</td>
          <td align="left"><select name="major_doctor" id="major_doctor" onChange="refreshproductList_doctor();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'    ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">
		  <select name="minor_doctor" id="minor_doctor">
		  
            </select>			 
			<input type="hidden" name="minor_doctor_label">
			</td>
        </tr>
		        <tr>
          <td align="right" height="25">สาขาวิชาโท</td>
          <td align="left"><select name="major1_doctor" id="major1_doctor" onChange="refreshproductList2_doctor();">
		  <option value="">ไม่ระบุ</option>
              <? 
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'  ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
	  ?>
              <option value="<?=$rs3[major_id]?>"><? echo "$rs3[major]";?></option>
              <? } ?>
            </select>
              <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
        </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left"><select name="minor1_doctor" id="minor1_doctor">
          
            </select>  
			<input type="hidden" name="minor1_doctor_label">    
			 </td>
        </tr>
<tr> 
	<td align="right" height="25"></td>
	<td align="left"  height="25">

	</td>
</tr>     
 <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
	 <td width="41%" bgcolor="#666666"><table width="100%" height="38%" border="0" cellpadding="1" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td>ส่วนแสดงวุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี) </td>
                  </tr>
                  <tr>
                    <td>ตามเอกสาร ก.พ.7 ต้นฉบับ </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="text" name="grade" size="40">
                    </label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="28">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
		  </tr>
		
      </table>
<!--	  </div>-->
  <!--<div id="divA" style="display: none;"> -->
        <br>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" id="table_a2" style="display:none"> 
          <tr>
            <td width="26%" align="right">วุฒิการศึกษา</td>
            <td width="74%"><input name="level_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาเอก</td>
            <td><input name="major_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาโท</td>
            <td><input name="minor_2" type="text" size="60"></td>
          </tr>
          <tr>
            <td align="right">สถาบันการศึกษา</td>
            <td><input name="university_2" type="text" size="60"></td>
          </tr>
        </table>
	<!--	</div> --><!-- end divB-->		</td>
      </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
 <input type="button" name="Button" value="ย้อนกลับ" onClick="location.href='graduate.php?action=add'">

	  </td>
</tr>
</table>
</form>
<?
	} //end if($sent_level == "80")
?>
	</td>
</tr>
</table>
<? 
} // end action 
if($_GET[action]=="edit2" && ($type_graduate=="clas6" || $type_graduate == "clas6_1" || $type_graduate=="clas7" || $type_graduate=="clas8")){
?>
<form name="post" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="graduate" value="1">
<input type="hidden" name="show_up" value="d1">
<input type="hidden" name="grade_update" value="d1">

<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<?
$select_g="select * from graduate where id='$id' and runid='$runid'";
$result_g=mysql_query($select_g);
$rs=mysql_fetch_assoc($result_g);
?>
<input type="hidden" name="up_clas" value="<?=$rs[type_graduate]?>">
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
<!--	<div id="div1" style="display: none;">-->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
   <!-- <tr>
      <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
      <td width="74%" align="left">
	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
        วุฒิการศึกษาสถาบันในประเทศ 
       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
วุฒิการศึกษาสถาบันต่างประเทศ </td>
    </tr>-->

    <tr>
      <td height="25" colspan="2" align="right">
	  <?
	  	if($rs[type_graduate]=="clas6"){
		echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาตรี</center></span>";
	
		}
		if($rs[type_graduate]=="clas6_1"){
		echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับประกาศนียบัตรชั้นสูง/ประกาศนียบัตรบัณฑิต(สูงกว่าปริญญาตรี/ต่ำกว่าปริญญาโท)</center></span>";
	
		}

		if($rs[type_graduate]=="clas7"){
		echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาโท</center></span>";
	
		}
		if($rs[type_graduate]=="clas8"){
		echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาเอก</center></span>";
		
		}
	  ?>

	  <input type="hidden" name="type_g" value="1">
<!--	<div id="divA" style="display: none;">--><br>


        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
			
       		<tr>
       		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
                <tr>
                  <td colspan="2" bgcolor="#666666">
				  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                    <tr>
                      <td height="25" align="right">&nbsp;</td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="25%" height="25" align="right">ตั้งแต่ (ปี)&nbsp;</td>
                      <td width="75%" align="left"><label>
                        <select name="startyear">
                          <option value="">ไม่ระบุ</option>
                          <?
	
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		if($rs[startyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
                        </select>
                        </label>
                        &nbsp; &nbsp; ถึง (ปี)
                        <label>
                          <select name="finishyear">
                            <option value="">ไม่ระบุ</option>
                            <?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
	if($rs[finishyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
                          </select>
                          <span class="style11">รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
                    </tr>
                    <tr>
                      <td align="right" height="25"></td>
                      <td align="left"><input type="text" name="year_label" size="50" value="<?=$rs[year_label]?>">
                        <span class="style11"><br>
                        หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
                
              </table></td>
       		  </tr>
       		
		<tr>
		  <td height="25" align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td height="25" colspan="2" align="right"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>
              <td colspan="2" bgcolor="#666666"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td align="right" height="25">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
          <td align="right" height="25">สถานศึกษา</td>
          <td align="left">
            <select name="university">
			<option value="">ไม่ระบุ</option>
              <? 
		$sql4 = " SELECT  *  FROM  hr_adduniversity   ORDER BY  u_id  ASC ";
		$result4 	= mysql_db_query($dbnamemaster,$sql4);	
		while($rs4 = mysql_fetch_assoc($result4)){
		if($rs[university_level]==$rs4[u_id]){
		echo "<option value='$rs4[u_id]' SELECTED>$rs4[u_name]</option>";
		}else{
		echo "<option value='$rs4[u_id]'>$rs4[u_name]</option>";
		}
	}	
	  ?>
            </select>
            &nbsp;<span class="style11">ข้อมูลเชิงสถิติ </span></td>
        </tr>
       	<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="50" value="<?=$rs[place]?>">
	  <span class="style11"><br>
	  หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
		  </tr>
		<tr>
		  <td height="25" align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td height="25" colspan="2" align="right">
		  <table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
            <tr>

              <td width="59%" bgcolor="#666666">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#A5B2CE">
			  <tr>
		  <td height="25" colspan="2">วุฒิที่ได้รับระบุสาขาวิชาเอก (ถ้ามี) </td>
		  </tr>
                  		<tr>
          <td width="21%" height="25" align="right">วุฒิการศึกษา</td>
          <td width="79%" align="left">
		  <select name="level1_1" id="level1_1">
		  <option value="">ไม่ระบุ</option>
			<?
	$xsql1 = "select * from hr_adddegree where degree_id like '".$rs[graduate_level]."%' ORDER BY runid  ASC";
	$xresult1 	= mysql_db_query($dbnamemaster,$xsql1);	
	while($xrs1 = mysql_fetch_assoc($xresult1)){
	if($rs[degree_level]==$xrs1[degree_id]){
	echo "<option value='$xrs1[degree_id]' SELECTED>$xrs1[degree_fullname]</option>";
	}else{
		echo "<option value='$xrs1[degree_id]'>$xrs1[degree_fullname]</option>";
	}
	
	
	}
			
			?>
            </select>
              <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
          </tr>

        <!--<tr>
          <td align="right" height="25" width="26%">สาขาวิชาเอก</td>
          <td align="left" width="74%">
            <select name="major" id="major">
            </select>
			 <span class="style2">* ข้อมูลเชิงสถิติ </span>
          </td>
        </tr>-->
      <tr>
          <td align="right" height="25">สาขาวิชาเอก</td>
          <td align="left"><select name="major" id="major" onChange="refreshproductList1();">
		 		<option value="">ไม่ระบุ</option>
              <? 
		$tem_major=substr($rs[major_level],0,1);
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00' ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
			$str_id=substr($rs3[major_id],0,1);
			if($tem_major==$str_id){
			echo "<option value='$rs3[major_id]' SELECTED>$rs3[major]</option>";
			}else{
			echo "<option value='$rs3[major_id]'>$rs3[major]</option>";
			}
		}		
	  ?>
   
            </select>
              <span class="style11">ข้อมูลเชิงสถิติ </span> </td>
          </tr>
        <tr>
          <td align="right" height="25"></td>
          <td align="left">
		  <select name="minor" id="minor">
		    <option value="">ไม่ระบุ</option>
		  <?
		$xtem_major=substr($rs[major_level],0,1);
		$str_sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '$xtem_major%' ORDER BY  major_id  ASC ";
		$xResult3 	= mysql_db_query($dbnamemaster,$str_sql3);	
		while($xRs3 = mysql_fetch_assoc($xResult3)){
			if($rs[major_level]==$xRs3[major_id]){
			echo "<option value='$xRs3[major_id]' SELECTED>$xRs3[major]</option>";
			}else{
			echo "<option value='$xRs3[major_id]'>$xRs3[major]</option>";
			}
		}		
		?>
            </select>
			<input type="hidden" name="major_label" value="">			</td>
          </tr>
		 <tr>
          <td align="right" height="25">สาขาวิชาโท</td>
          <td align="left"><select name="major1" id="major1" onChange="refreshproductList2();">
		  <option value="">ไม่ระบุ</option>
		  <?
		 $tem_major=substr($rs[minor_level],0,1);
		$sql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '%0000%00'    ORDER BY  major_id  ASC ";
		$result3 	= mysql_db_query($dbnamemaster,$sql3);	
		while($rs3 = mysql_fetch_assoc($result3)){
			$str_id=substr($rs3[major_id],0,1);
			if($tem_major==$str_id){
			echo "<option value='$rs3[major_id]' SELECTED>$rs3[major]</option>";
			}else{
			echo "<option value='$rs3[major_id]'>$rs3[major]</option>";
			}
		}		
		?>
            </select>
              <span class="style11"> ข้อมูลเชิงสถิติ </span> </td>
          </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">
		  <select name="minor1" id="minor1">
		  <option value="">ไม่ระบุ</option>
		    <?
		$t_major=substr($rs[minor_level],0,1);
		$xsql3 = " SELECT  *  FROM hr_addmajor  WHERE  major_id  LIKE '$t_major%' ORDER BY  major_id  ASC ";
		$xresult3 	= mysql_db_query($dbnamemaster,$xsql3);	
		while($xrs3 = mysql_fetch_assoc($xresult3)){
			
			if($rs[minor_level]==$xrs3[major_id]){
			echo "<option value='$xrs3[major_id]' SELECTED>$xrs3[major]</option>";
			}else{
			echo "<option value='$xrs3[major_id]'>$xrs3[major]</option>";
			}
		}		
		?>
            </select>			
			 <input type="hidden" name="minor1_label" value="">			</td>
          </tr>
        <tr>
          <td align="right" height="25">&nbsp;</td>
          <td align="left">   			</td>
          </tr>
				<tr>
		  <td height="25" align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
              </table>			  </td>
			    <td width="41%" bgcolor="#666666"><table width="100%" height="38%" border="0" cellpadding="1" cellspacing="0" bgcolor="#A5B2CE">
                  <tr>
                    <td>ส่วนแสดงวุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี) </td>
                  </tr>
                  <tr>
                    <td>ตามเอกสาร ก.พ.7 ต้นฉบับ </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="text" name="grade" size="40" value="<?=$rs[grade]?>">
                    </label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="27">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
		  </tr>
		 </table>

	<!--  </div>
  <div id="divB" style="display: none;"> -->
	<!--	</div>-->
    <!-- end divB-->      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center"><input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
ไม่แสดงผลใน ก.พ.7</td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="right">&nbsp;</td>
    </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	 <input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='graduate.php?action=add'">

	  </td>
</tr>
</table>
</form>
<?
}
if($_GET[action]=="edit2" && ($type_graduate=="room6" ||  $type_graduate=="room6_1" || $type_graduate=="room7" || $type_graduate=="room8")){
?>

<form name="post" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="graduate" value="2">
<input type="hidden" name="show_up" value="d2">
<input type="hidden" name="grade_update" value="d2">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<?
$select_g="select * from graduate where id='$id' and runid='$runid'";
$result_g=mysql_query($select_g);
$rs=mysql_fetch_assoc($result_g);
?>
<input type="hidden" name="up_clas" value="<?=$rs[type_graduate]?>">
<tr>
  <td height="25" colspan="2" align="center">
  <?
  if($rs[type_graduate]=="room6"){
  echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาตรี</center></span>";
  }
    if($rs[type_graduate]=="room6_1"){
  echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับประกาศนียบัตรชั้นสูง/ประกาศนียบัตรบัณฑิต(สูงกว่าปริญญาตรี/ต่ำกว่าปริญญาโท)</center></span>";
  }

  if($rs[type_graduate]=="room7"){
   echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาโท</center></span>";
  }
  if($rs[type_graduate]=="room8"){
    echo "<span class=\"style10\"><center>ประวัติการศึกษาระดับปริญญาเอก</center></span>";
  }
  ?>
  </td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">ตั้งแต่ (ปี)&nbsp;</td>
	<td width="74%" align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		if($rs[startyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
	if($rs[finishyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
</select>
<span class="style11">รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr> 
	<td align="right" height="25"></td>
	<td align="left"><input type="text" name="year_label" size="50" value="<?=$rs[year_label]?>">
	  <span class="style11"><br>
	  หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
	</tr>

<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
<!--	<div id="div1" style="display: none;">-->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
   <!-- <tr>
      <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
      <td width="74%" align="left">
	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
        วุฒิการศึกษาสถาบันในประเทศ 
       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
วุฒิการศึกษาสถาบันต่างประเทศ </td>
    </tr>-->

    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divA" style="display: none;">-->
<!--  </div>
  <div id="divB" style="display: none;"> -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">

          <tr>
            <td width="26%" align="right">วุฒิการศึกษา</td>
            <td width="74%"><input name="level1" type="text" size="60" value="<?=$rs[grade]?>"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาเอก</td>
            <td><input name="major1" type="text" size="60" value="<?=$rs[major_label]?>"></td>
          </tr>
          <tr>
            <td align="right">สาขาวิชาโท</td>
            <td><input name="minor_1" type="text" size="60" value="<?=$rs[minor_label]?>"></td>
          </tr>
          <tr>
            <td align="right">สถาบันการศึกษา</td>
            <td>
			
              <input name="university1" type="text" size="60" value="<?=$rs[place]?>">           </td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
ไม่แสดงผลใน ก.พ.7</td>
          </tr>
        </table>

	<!--	</div>--> <!-- end divB-->		</td>
      </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	<input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='graduate_all.php?'">
	  </td>
</tr>
</table>
</form>
<?
	}if($_GET[action]==edit2 && ($type_graduate=="clas1" || $type_graduate=="clas2" || $type_graduate=="clas3" || $type_graduate=="clas4" || $type_graduate=="clas5" || $type_graduate == "")){
?>

<form name="post" method="post" action = "<?=$PHP_SELF?>" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<input type="hidden" name="action" value="<?=$_GET[action]?>">
<input type="hidden" name="grade_update" value="">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
<?
$select_g="select * from graduate where id='$id' and runid='$runid'";
$result_g=mysql_query($select_g);
$rs=mysql_fetch_assoc($result_g);
?>
<input type="hidden" name="up_clas" value="<?=$rs[type_graduate]?>">
<tr>
  <td height="25" colspan="2" align="center">
  <?
  if($rs[type_graduate] == "clas1"){
  echo "<span class=\"style10\">ประวัติการศึกษาระดับ ประถมศึกษา</span>";
  }
  if($rs[type_graduate] =="clas2"){
    echo "<span class=\"style10\">ประวัติการศึกษาระดับ มัธยมศึกษาตอนต้น</span>";

  }
  
  if($rs[type_graduate] == "clas3"){
    echo "<span class=\"style10\">ประวัติการศึกษาระดับ มัธยมศึกษาปลาย-ปวช./เทียบเท่า</span>";
  }
  
  if($rs[type_graduate] == "clas4"){
    echo "<span class=\"style10\">ประวัติการศึกษาระดับ ปวท./เทียบเท่า</span>";
  }
  
  if($rs[type_graduate] == "clas5"){
    echo "<span class=\"style10\">ประวัติการศึกษาระดับ อนุปริญญา</span>";
  }
  
  ?>  </td>
  </tr>
<tr> 
	<td width="26%" height="25" align="right">สถานศึกษา&nbsp;</td>
	<td width="74%" align="left"><input type="text" name="place" size="60" value="<?=$rs[place]?>">
	  <span class="style11">ส่วนแสดงผลใน ก.พ.7 </span></td>
</tr>
<tr> 
	<td align="right" height="25">ตั้งแต่ (ปี)&nbsp;</td>
	<td align="left"><label>
	<select name="startyear">
	<option value="">ไม่ระบุ</option>
	<?
	
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
		if($rs[startyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
	  </select>
	</label>
	&nbsp; &nbsp; ถึง (ปี)

<label>
<select name="finishyear">
<option value="">ไม่ระบุ</option>
<?
	$thisyear = date("Y") + 543;
	for ($i=$thisyear;$i>=2470;$i--){
	if($rs[finishyear]==$i){
		echo "<option selected>$i</option>";   
		}else{
		echo "<option>$i</option>";
		}
}
	?>
</select>
<span class="style11">รูปแบบการแสดงผลของวันที่เช่น 2520 - 2525 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></label></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><label>
    <input type="text" name="year_label" value="<?=$rs[year_label]?>">
    <span class="style11"><br>
    หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></label></td>
</tr>
<tr> 
	<td align="right" height="25">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)&nbsp;</td>
	<td align="left"><input type="text" name="grade" size="60" value="<?=$rs[grade]?>"></td>
</tr>
<tr>
  <td align="right" height="25">&nbsp;</td>
  <td align="left"><input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
ไม่แสดงผลใน ก.พ.7</td>
</tr>

<tr>
  <td height="12" colspan="2" align="right">
  
  <!--  ซ่อนการแสดงผล -->
<!--	<div id="div1" style="display: none;">-->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
   <!-- <tr>
      <td width="26%" height="25" align="right">วุฒิการศึกษา</td>
      <td width="74%" align="left">
	  <input name="chk_university" type="radio" value="1" onClick="showhide2();">
        วุฒิการศึกษาสถาบันในประเทศ 
       <input name="chk_university" type="radio" value="2" onClick="showhide2();">
วุฒิการศึกษาสถาบันต่างประเทศ </td>
    </tr>-->

    <tr>
      <td height="25" colspan="2" align="right"><br>
<!--	<div id="divA" style="display: none;">-->
<!--  </div>
  <div id="divB" style="display: none;"> -->
<!--	</div>-->
<!-- end divB-->      </td>
    </tr>
  </table>
<!--</div>-->
  <!--  จบการซ่อน -->  </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td>
	<input type="submit" name="send" value="  บันทึก  ">
	  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?'">
	 <input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='graduate.php?action=add'">

	  </td>
</tr>
</table>
</form>
<?
}
?>
 <? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>