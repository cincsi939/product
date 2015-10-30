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
 $_GET['id']= $_SESSION[id];
 $_POST['id']= $_SESSION[id];
if ($_SERVER[REQUEST_METHOD] == "POST"){	
	add_log("ข้อมูลการศึกษา",$id,$action);
	if($_POST[action]=="edit2"){
		if($graduate==1){
		$sql 		= " update graduate set place='$place', startyear='$startyear' , finishyear = '$finishyear' , grade = '$grade',kp7_active='$kp7_active',university_level='$university',major_level='$minor',degree_level='$level1_1',graduate_level='$level', minor_level='$minor1',type_graduate='$graduate' where id ='$id' and runid='$runid'; ";
		$result  = mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้นใน\\n \");
				location.href='?id=$id';
				</script>
				";
				exit;
		}else if($graduate==2){
		$sql 		= " update graduate set place='$place', startyear='$startyear' , finishyear = '$finishyear' , grade = '$grade',kp7_active='$kp7_active',university_level='$university1',major_level='$major1',degree_level='$level1',graduate_level='$level',minor_level='$minor_1',type_graduate='$type_g' where id ='$id' and runid='$runid'; ";
		$result  = mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
		echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้นต่าง\\n \");
				location.href='?id=$id';
				</script>
				";
				exit;
		}else{
		$sql 		= " update graduate set place='$place', startyear='$startyear' , finishyear = '$finishyear' , grade = '$grade',kp7_active='$kp7_active' where id ='$id' and runid='$runid'; ";
		$result  = mysql_query($sql)or die("ไม่สามารถบันทึกข้อมูลได้");
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
		if($chk_university==1){
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,grade, runno,kp7_active,university_level,major_level,degree_level,minor_level,graduate_level,type_graduate) VALUES ('$id','$place','$startyear','$finishyear','$grade', '$runno','$kp7_active','$university','$minor','$level1_1','$minor1','$level','$chk_university') ";
		}else{
		$sql 		= " INSERT INTO  graduate (id,place,startyear,finishyear,grade, runno,kp7_active,university_level,major_level,degree_level,minor_level,graduate_level,type_graduate) VALUES ('$id','$place','$startyear','$finishyear','$grade', '$runno','$kp7_active','$university_2','$major_2','$level_2','$minor_2','$level','$chk_university') ";
		}
		//echo $sql;die;
		$result  = mysql_query($sql)or die("ไม่สามารถปรับปรุงข้อมูลได้");
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
	mysql_query(" delete from graduate where id = $id and runid='$runid'; ")or die("ไม่สามารถลบข้อมูลได้");
	header("Location: ?id=$id&action=edit");
	echo"<meta http-equiv='refresh' content='0;URL=graduate.php'>";
	exit;
	
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
<!-- send id to menu flash -->
<script language="javascript">

function check(){

	if(document.post.place.value.length == 0){
		alert("ระบุข้อมูลสถานศึกษา");
		document.post.place.focus();
		return false;
	} else if(document.post.startyear.value.length==0){
		alert("ระบุข้อมูลปีที่เริ่มการศึกษา");
		document.post.startyear.focus();
		return false;
		}else if(document.post.finishyear.value.length==0){
			alert("ระบุข้อมูลปีที่จบการศึกษา");
			document.post.finishyear.focus();
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
refreshproductList();
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

 var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList() {
   var level = document.getElementById("level").value;
    if(level == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_graduate_level.php?runid=" + level;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var level1_1 = document.getElementById("level1_1");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           level1_1.appendChild(option);
	}
    }
}

	function clearproductList() {
    var level1_1 = document.getElementById("level1_1");
    while(level1_1.childNodes.length > 0) {
              level1_1.removeChild(level1_1.childNodes[0]);
    }
}


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
 //----------------------------------------------------------------------------------------
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

</script>
<style type="text/css">
<!--
-->
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
a.pp:link, a.pp:visited, a.pp:active { color: #444444;	
	font-weight:normal;
	text-decoration: none}
a.pp:hover {
	text-decoration: underline;
	color: #444444;
}
.style6 {
	font-size: 11px;
	color: #000000;
}
.style7 {font-size: 11px}
.style8 {color: #000000}
-->

</style>
</head>
<body >
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" style="border:1px solid #DADAE1;">
  <tr>
    <td height="35" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="noPrint" id="dm0m0">
	<?
	 if($dis_menu){
	?>
	      <tr>
        <td height="26" colspan="3"><a href="kp7_graduate.php?id=<?=$id?>"class="pp" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16"align="absmiddle" border=""> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </a></td>
      </tr>

	<?
	}else{
	?>
      <tr>
        <td width="95" height="26"><a href="graduate.php?id=<?=$id?>" class="pp" title="แก้ไขข้อมูลประวัติการศึกษา"><img src="images/edit.png" width="16" height="16" align="absmiddle" border="">แก้ไขข้อมูล</a></td>
        <td width="293" height="26"><a href="kp7_graduate.php?id=<?=$id?>"class="pp" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16"align="absmiddle" border=""> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิก</a>ส์</td>
        <td width="552">&nbsp;</td>
      </tr>
	  <?
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td style="padding:2px"><b class="Label_big_black bodyblack style6">ชื่อ / สกุล &nbsp;&nbsp; 
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
    </b></td>
  </tr>
  <tr>
    <td class="headerTB" style="padding:2px">&nbsp;<b class="Label_big_black bodyblack style6">๑๐. ประวัติการศึกษา</b></td>
  </tr>
  <tr>
    <td><? if($action ==""){
		
		
			$sql_show = "SELECT 
runid as run_id,runno as run_no,place as place ,startyear as s_year,finishyear as e_year,year_label as la_year,grade as grade, kp7_active as at_kp7,type_graduate as g_type
  FROM graduate  WHERE id = '$id'
UNION
SELECT
 runid as run_id,runno as run_no,place as place,startdate as s_year,enddate as e_year,'',subject as grade ,kp7_active as at_kp7,''
  FROM seminar WHERE id = '$id' ORDER BY run_no ASC";
  $result_show = mysql_db_query($dbname,$sql_show);
  $i=0;
  while($rs_s = mysql_fetch_assoc($result_show)){
	  
	  $key_runid[$i] = $rs_s[run_id];
	  $key_runno[$i] = $rs_s[run_no];
	  $key_place[$i] = $rs_s[place];
	  $key_startdate[$i] = $rs_s[s_year];
	  $key_enddate[$i] = $rs_s[e_year];
	  $key_labeldate[$i] = $rs_s[la_year];
	  $key_grade[$i] = $rs_s[grade];
	  $key_kp7[$i] = $rs_s[at_kp7];
	  $key_gtype[$i] = $rs_s[g_type];
	  $i++;
  }
		?>
      <form name="form1" method="post" action="<?=$PHP_SELF?>">
        <input type="hidden" name="action" value="changeRow">
        <input type="hidden" NAME="id" VALUE="<?=$id?>">
        <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
          <tr bgcolor="#A3B2CC" align="center" style=" font-weight:bold;">
            <td width="38%" class="header style8 style7">สถานศึกษา</td>
            <td width="18%" class="header style8 style7">ตั้งแต่ - ถึง (เดือน ปี)</td>
            <td width="44%" class="header style8 style7">วุฒิที่ได้รับ ระบุสาขาวิชาเอก (ถ้ามี)</td>
          </tr>
    <?
//	$i	= 0;
//	$sql 	= "select * from graduate where id='$id' order by runno asc ";
//	$result = mysql_query($sql);
//	$row		= mysql_num_rows($result);
//	while($rs=mysql_fetch_assoc($result)){
//		$i++;
//		$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
//		if($rs[finishyear]=="" or $rs[finishyear]=="0"){
//			$showdate1 = "$rs[startyear]" ;
//		}else if($rs[startyear]==""  or $rs[startyear]=="0" ){
//			$showdate1 = "$rs[finishyear]" ;
//		}else{
//			$showdate1 = "$rs[startyear]"."-"."$rs[finishyear]";
//		}

if(count($key_runid) > 0){
$row = count($key_runid);
$i=0;
foreach($key_runid as $k => $v){
	$i++;
	$bg = ($i % 2) ? "#EFEFEF" : "#DDDDDD" ;
	if($key_gtype[$k] != ""){
		$sent_type = "Y";	 // เป็นประเภทการศึกษา
		$url_file = "graduate.php";
	}else{
		$sent_type = "N";	 // เป็นประเภทการฝึกอบรม
		$url_file = "seminar.php";
	}
	### วันที่ศึกษาหรือฝึกอบรม
	if($key_labeldate[$k] != ""){ 
		$showdate1 = $key_labeldate[$k];
	}else{
		if($key_startdate[$k] == "" or $key_startdate[$k] == "0"){
			$showdate1 = $key_enddate[$k];	
		}else if($key_enddate[$k] == "" or $key_enddate[$k] == "0"){
				$showdate1 = $key_startdate[$k];	
		}else{
			    $showdate1 = 	"$key_startdate[$k]-$key_enddate[$k]";
		}
	}//end if($key_labeldate[$k] != ""){ 
	## end วันที่ศึกษาหรือฝึกอบรม

		
	?>
	<tr bgcolor="<?=$bg?>">
				<td><?
	if($key_place[$k] !=""){
		echo $key_place[$k];
	}else{
		$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$id' and graduate.runid='".$key_runid[$k]."'";
		$Rs1=mysql_query($str1);
		$rs11=mysql_fetch_array($Rs1);
		echo $rs11[u_name];
	}
		
	?>
</td>
            <td align="center"><? echo $showdate1;?></td>
            <td><?
	if($key_grade[$k] !=""){
		echo $key_grade[$k];
	}
	else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$id' and graduate.runid='".$key_runid[$k]."'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	echo $rs11[degree_fullname];
	}
	
	?>            </td>
          </tr>
          <?
	} //end foreach($key_runid as $k => $v){
}//end if(count($key_runid) > 0){
//mysql_free_result($result);
?>
        </table>
      </form>
      <?
}

?></td>
  </tr>
  <tr>
    <td height="39" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px"><? include("../../../config/licence_inc.php");?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top"> 
<td align="left"><br></td>
	</tr>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>