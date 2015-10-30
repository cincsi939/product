<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_search_people";
$module_code 		= "search_people"; 
$process_id				= "search_people";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
ob_start();
session_start();
//include("session.inc.php");
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();

//include("timefunc.inc.php");
include("../../../config/phpconfig.php");
//include("db.inc.php");
//conn2DB();


if($isprivilage!=""){$_SESSION[isprivilage] = $isprivilage;}

function ischeked($valdb, $valdef){
	$checked	= ($valdb == $valdef) ? " checked " :  "" ;	
	return $checked;
}

function isselected($valdb, $valdef){
	$checked	= ($valdb == $valdef) ? " selected style=\"color:#0066CC\" " :  "" ;	
	return $checked;
}

function isdisplay($valdb, $valdef){
	$checked	= (trim($valdb) == trim($valdef)) ? "  style=\"display:block;\" " :  "  style=\"display:none;\" " ;	
	return $checked;
}

function devidepage($total, $kwd){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i.$kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all.$kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1).$kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
		
		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}

#############################################
##### function การเลื่อนวิทยฐานะ ######################
function vitaya_find($typeselect,$vitayaselect){
		//echo "$typeselect,$vitayaselect";
		switch ($typeselect) {
		case "ครู":
			if($vitayaselect == "ชำนาญการ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
							
			}else if($vitayaselect == "ชำนาญการพิเศษ"){
			
				// มีวิทยฐานะครูชำนาญการ  > 1 ปี
				$year1 = (date(Y)+543)-1;
				$mm1 =  date(m) ;
				$day1 = date(d);
				$condition = " general.vitaya  like 'ชำนาญการ'  AND ( substring(date_command,1,4) <= '$year1'  )    " ;
				$condition .= " AND ( general.salary >= 18180 )  ";
				
			}else if($vitayaselect == "เชี่ยวชาญ"){

				$year1 = (date(Y)+543)-3; // ชำนาญการพิเศษ
				$year2 = (date(Y)+543)-5; //ชำนาญการ
				$mm1 =  date(m) ;
				$day1 = date(d);
				$condition = " ( general.vitaya  like 'ชำนาญการพิเศษ'  AND  ( substring(date_command,1,4) <= '$year1'  ) ) OR ( general.vitaya  like 'ชำนาญการ'  AND  ( substring(date_command,1,4) <= '$year2' ) )    " ;
				$condition .= " AND ( general.salary >= 22330 )  ";
				
			}else{
				$condition = " general.id <> ''  "; // disalble SQL error 
			}							
			break;
		case "รองผู้อำนวยการโรงเรียน":
			if($vitayaselect == "ชำนาญการ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "ชำนาญการพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else{
				$condition = " general.id <> ''  "; // disalble SQL error 
			}			
		   break;
		   
		case "ผู้อำนวยการโรงเรียน":
			if($vitayaselect == "ชำนาญการ"){
				$condition = " general.id <> ''  ";
			}else if($vitayaselect == "ชำนาญการพิเศษ"){
			
				$year1 = (date(Y)+543)-1;
				$mm1 =  date(m) ;
				$day1 = date(d);
				$condition = " general.vitaya  like 'ชำนาญการ'  AND  ( substring(date_command,1,4) <= '$year1' AND substring(date_command,6,2) <= '$mm1' AND substring(date_command,9,2) <= '$day1' )    " ;
				$condition .= " AND ( general.salary >= 18180 )  ";
				
			}else if($vitayaselect == "เชี่ยวชาญ"){
			
				$year1 = (date(Y)+543)-3; // ชำนาญการพิเศษ
				$year2 = (date(Y)+543)-5; //ชำนาญการ
				$mm1 =  date(m) ;
				$day1 = date(d);
				$condition = " ( general.vitaya  like 'ชำนาญการพิเศษ'  AND  ( substring(date_command,1,4) <= '$year1' AND substring(date_command,6,2) <= '$mm1' AND substring(date_command,9,2) <= '$day1' ) ) OR ( general.vitaya  like 'ชำนาญการ'  AND  ( substring(date_command,1,4) <= '$year2' AND substring(date_command,6,2) <= '$mm1' AND substring(date_command,9,2) <= '$day1' ) )    " ;
				$condition .= " AND ( general.salary >= 22330 )  ";
				
			}else if($vitayaselect == "เชี่ยวชาญพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else{
				$condition = " general.id <> ''  "; // disalble SQL error 
			}			
		   break;
		case "รองผู้อำนวยการ สพท.":
			if($vitayaselect == "ชำนาญการ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "ชำนาญการพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else{
				$condition = " general.id <> ''  "; // disalble SQL error 
			}			
		   break;
		case "ผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา":
			if($vitayaselect == "ชำนาญการ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "ชำนาญการพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else if($vitayaselect == "เชี่ยวชาญพิเศษ"){
				$condition = " general.id <> ''  "; // disalble SQL error 
			}else{
				$condition = " general.id <> ''  "; // disalble SQL error 
			}		
		   break;
		}
		return $condition ;
}



#############################################

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<link href="libary/tab_style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="libary/popcalendar.js"></script>
<script language="javascript" src="libary/xmlhttp.js"></script>
<script type="text/javascript" src="libary/tabber.js"></script>

<title>ค้นหาบุคลากร</title>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em
}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>
<script type="text/javascript">
//--------------------------------------------------------------------------------------------------------------------------------------------------

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
   var secid = document.getElementById("secid").value;
 	
    if(secid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_dataentry.php?Tid=" + secid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


 //ภาค
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}


//ภาค
function updateproductList() {
    clearproductList();
    var ampid = document.getElementById("ampid");

    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           ampid.appendChild(option);
	}
    }
}

//ภาค
function clearproductList() {
    var ampid = document.getElementById("ampid");
    while(ampid.childNodes.length > 0) {
              ampid.removeChild(ampid.childNodes[0]);
    }
}

//----------------------------------------------------------------------------------------
//จังหวัด

//
function refreshproductList1() {
   var provid = document.getElementById("provid").value;
   alert(provid);
       if(provid == "" ) {
        clearproductList1();
		
		
        return;
    }
    var url = "ajax_dataentry1.php?Tid=" + provid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
//ขยับทีละทีละบันทัด 	
function handleStateChange1() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList1();
        }
    }
}

//อัพเด็ดทีละบันทัดที่อยู่
function updateproductList1() {
    clearproductList1();
    var secname = document.getElementById("secname");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           secname.appendChild(option);
	}
    }
}

//ล้างค่าใน list box
function clearproductList1() {
    var secname = document.getElementById("secname");
    while(secname.childNodes.length > 0) {
              secname.removeChild(secname.childNodes[0]);
    }
}


//-------------------------------------------------------------------------------------------------------------------------------------------------------
</script>

<script language="javascript">

function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 

function showEle(divname){
	if(document.getElementById(divname).style.display == 'none'){
		document.getElementById(divname).style.display = 'block';
	} else {  
		document.getElementById(divname).style.display = 'none';
	}
}

function getAmpur(value) {
	var param 	= "sid=" + Math.random() + "&ampur_id=" + value;
 	xmlHttp.open('POST', 'list_people_get_ampur.php', true); 
    xmlHttp.onreadystatechange = function() { 
         if (xmlHttp.readyState==4) {
              if (xmlHttp.status==200) { 
			  	document.getElementById("div_unit").innerHTML = xmlHttp.responseText 
			  }
         }
    };
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlHttp.send(param); 
}

function validate(){
	var s1 = document.post.sal1;
	var s2 = document.post.sal2;
	if((s1.value.length >=1 && isNaN(s1.value)) || (s2.value.length >=1 && isNaN(s2.value))){
		s1.focus();
		alert("ข้อมูลเงินเดือนต้องระบุเป็นตัวเลขเท่านั้น");
		return false;
	} 
	
	if(s2.value.length >=1 && s1.value.length == 0) {	
		s1.focus();
		alert("ระบุอัตราเงินเดือนเริ่มต้น");
		return false;	
	} 	
	
	return true;
}

</script>
<script language="javascript">
// เก็บค่าที่เลือกมาแสดง
dpvar = Array();
function tf(tfv){
	if(tfv==true){
		return "เลือก";
	}else{
		return "ไม่เลือก";
	}
}
	strec = "<?=$dpvar2?>";
	dpvarset = strec.split("^");
	for(sti=0;sti<dpvarset.length-1;sti++){
		dpvarseta = dpvarset[sti].split("||");
		dpvar[dpvarseta[0]] = dpvarseta[1];
   }
function showstatus(){
	st = "";
	st2 = "";
	for(i in dpvar){
		st += dpvar[i]+"-->"
		st2 +=  i+"||"+dpvar[i]+"^"
	}
	//st2 = substr(st2,0,(st2.length-1));
	document.getElementById("dpvar").value = st;
	document.getElementById("dpvar2").value = st2;
	document.getElementById("display").innerHTML = st;
}
function getvalue(arg){
	//alert(document.getElementById("label"+arg.id).innerHTML+" : "+tf(arg.checked));
	switch(arg.type){
	case "text":
		dpvar[arg.id] = "<b>"+document.getElementById("label"+arg.id).innerHTML+"</b> = "+arg.value;
 	break;
	case "select":
		dpvar[arg.id] = "<b>"+document.getElementById("label"+arg.id).innerHTML+"</b> = "+arg[arg.selectedIndex].innerHTML;
	break;
	case "checkbox":
		 dpvar[arg.id] = "<b>"+document.getElementById("label"+arg.id).innerHTML+"</b> = "+tf(arg.checked);
	break;
	case "radio":
		dpvar[arg.name] = "<b>"+document.getElementById("label"+arg.id).innerHTML+"</b> = "+tf(arg.checked);
	break;
	}
	showstatus();
}
function clearall(){
	dpvar = Array();
	st = "";
	st2 = "";
	document.getElementById('display').innerHTML='';
	document.post.province.selectedIndex = 0;
	document.post.area_opt.selectedIndex = 0;
	document.post.ampid.selectedIndex = 0; 
	document.post.education.selectedIndex = 0; 
	document.post.radub.selectedIndex = 0;
	document.post.position_now.selectedIndex = 0;
	document.post.unit.selectedIndex = 0;
	document.post.home.selectedIndex = 0;
	document.post.sal1.value = '';
	document.post.sal2.value = '';
	document.post.vitaya_opt.selectedIndex = 0; 
	document.post.positiongroup.selectedIndex = 0;
	document.post.vitaya_type.selectedIndex = 0;
	document.post.year.value = '';
	document.post.dpvar.value='';
	document.post.dpvar2.value='';
	document.post.upvitaya.value='';
	document.post.positionvitaya.value='';
}
function checkwitaya(wty){
	if(wty.value==2 || wty.value==""){
		document.getElementById("positiongroup").disabled = true;
		document.getElementById("radabwit").disabled = true;
		document.getElementById("upvitaya").disabled = true;
		document.getElementById("positionvitaya").disabled = true;		
	}else if(wty.value==3){
		document.getElementById("positiongroup").disabled = true;
		document.getElementById("radabwit").disabled = true;
		document.getElementById("upvitaya").disabled = false;
		document.getElementById("positionvitaya").disabled = false;		
	}else{
		document.getElementById("positiongroup").disabled = false;
		document.getElementById("radabwit").disabled = false;
		document.getElementById("upvitaya").disabled = true;
		document.getElementById("positionvitaya").disabled = true;		
	}
}
</script>
</head>
<body>


  <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
    <tr style=" border-bottom:1px solid #FFFFFF" >
      <td height="50" background="images/report_banner_01.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%"><img src="images/search_banner_01.gif" width="56" height="50" /></td>
          <td width="66%"><span style="font-size:16px; color:#FFFFFF;">&nbsp;&nbsp;<strong>CMSS</strong> Search</span></td>
          <td width="33%" align="right"><img src="images/search_banner_04.gif" width="258" height="50" /></td>
        </tr>
      </table></td>
    </tr>
    
    <tr align="right" >
      <td style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#868E94', EndColorStr='#ffffff')">&nbsp;</td>
    </tr>
  </table>

<form action="<?=$PHP_SELF?>"method="post" enctype="multipart/form-data"  name="movedata" onSubmit="return checkselect();">
  <table width="963" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="104" valign="middle" style=" font-size:14px; padding-left:20px">ชื่อ - นามสกุล </td>
      <td width="536" valign="middle" ><input name="name_th" type="text" class="q"  value="<?=$name_th?>" />
      <span style=" font-size:14px; padding-left:2px; ">
      <input name="submit2" type="submit" class="go" value="ค้นหา" />
      <input name="Button" type="button" class="go" value="ล้างค่า" onclick="clearall(); 	""/>
      <input name="dpvar" type="hidden" id="dpvar" value="<?=$dpvar?>" />
	   <input name="dpvar2" type="hidden" id="dpvar2" value="<?=$dpvar2?>" />
      </span></td>
      <td width="315" valign="middle" style=" font-size:12px; ">
      <li onclick="showEle('div_search_all');" style="cursor:hand" title="เลือกค้นหาแบบละเอียด"><u>ค้นหาแบบละเอียด</u></li> </td>
    </tr>
  </table>
  <table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td width="100%" colspan="2" valign="top"><b><u>เลือกเงื่อนไขการสืบค้น</u></b>&nbsp;<b>:</b>&nbsp;
        
      <div id="display" name="display"><?=$dpvar?></div></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div id="div_search_all" style="display:block;">
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#E6E6E6" class="login_fill3" style="border:1px solid #5595CC;">
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" align="center" style="margin-top:5px;">
            <tr valign="top">
              <td colspan="2" style="border-bottom:1px #aaaaaa solid"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input type="hidden" name="action" value="view" />
                    <strong style="font-size:16px; color:#4753A2;">ค้นหาแบบละเอียด</strong></td>
                  <td align="right"><img src="images/closed.png" alt="ซ่อน" width="16" height="16" style="cursor:hand" onclick="showEle('div_search_all');" /></td>
                </tr>
              </table></td>
            </tr>
            <tr valign="top">
              <td width="11%"><img src="images/text_view.png" width="48" height="48" /><br /></td>
              <td width="89%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr valign="top">
                    <td height="20"><div class="tabber">
                      <div class="tabbertab">
                        <h2>พื้นที่</h2>
						
                             <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" style="margin-top:5px;">
 
                          <tr bgcolor="#ffffff">
                            <td align="right"></td>
                            <td>&nbsp;</td>
                          </tr>
						   <tr bgcolor="#ffffff">
                            <td width="26%" align="right">ภาค&nbsp;<b>:</b>&nbsp;</td>
                            <td width="74%">
							   <select name="area_id"   id="area_id"  disabled="disabled" style="width:180px;">
							<option value="0">ระบุื้ตำแหน่ง(ภาค)</option>
							<?
							$sql1 = " SELECT  area_id , area_name,siteid  FROM  area_info  where  area_id!='5'  and  siteid='$_SESSION[siteid]'  order by area_name";
							$query_area = mysql_query($sql1) ;
							while($rs_area = mysql_fetch_assoc($query_area)){
							?>
							<option value="<? echo $rs_area[area_id]?>"> <? echo $rs_area[area_name]?> </option>
							<? } ?>
						  </select>
                            <input name="button2" type="button" onclick="document.post.province.selectedIndex = 0;" value="ล้างค่า" /> </td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td width="26%" align="right">พื้นที่&nbsp;<b>:</b>&nbsp;</td>
                            <td width="74%">

							<select name="provid"   id="provid"    disabled="disabled"  style="width:180px;" >
							<?
								if ($Submit2 == ""){ 
							   $sql_select=" select  secid,secname,name_proth  from eduarea where eduarea.secid = '$_SESSION[siteid]'order by secid ";
                            $result1= mysql_query( $sql_select );
                          //เริ่มวนรอบแสดงข้อมูล
                           while ($row= mysql_fetch_array($result1))
                                {
		                   //  $selected = ($ccDigi == $result[ccDigi])? " selected style=\"color:#0066CC\" " : "" ;
							    echo " 	<option   value=\"".$row[secid]."\" > $row[name_proth]  </option> " ; 
							   }
						       }
							?>
                            </select>
							
			
                              <input name="button2" type="button" onclick="document.post.province.selectedIndex = 0;" value="ล้างค่า" /></td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right">เขต&nbsp;<b>:</b>&nbsp;</td>
                            <td>
							
							<select name="secsid" id="secsid"  style="width:180px;"  onClick="refreshproductList();">
							
			                 <?
							$sql1 = " SELECT secid , secname  FROM  eduarea  where  secid='$_SESSION[siteid]' ";
							$query_area = mysql_query($sql1) ;
							while($rs_sec = mysql_fetch_assoc($query_area)){
							?>	
							<option value="<? echo $rs_sec[secid]?>"> <? $name = substr($rs_sec[secname], -1, 2);
	                            echo"สพท. เขต $name";?> </option>
							<? } ?>
                              </select>
                                <input name="button2" type="button" onclick="document.post.area_opt.selectedIndex = 0;" value="ล้างค่า" />                            </td>
                             </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="ampid" id="labelampid">อำเภอ</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td>
							
							<select name="ccDigi"  id="ccDigi" style="width:180px;" >
							<?
							if ($Submit2 == ""){ 
								 $sql_select1="Select
								dopa_ampur.DESC_CCAATT,
								eduarea.secname,
								dopa_ampur.secid,
								eduarea.secid , ccDigi 
								From
								eduarea
								Inner Join dopa_ampur ON dopa_ampur.secid = eduarea.secid
								Where    dopa_ampur.secid = '$_SESSION[siteid]' ";
							
								$result1= mysql_query($sql_select1);
								 //เริ่มวนรอบแสดงข้อมูล
								while ($result = mysql_fetch_array($result1)) 
								//แสดงค่าในฐานข้อมูล
								{
							
								$selected = ($ccDigi == $result[ccDigi])? " selected style=\"color:#0066CC\" " : "" ;
							    echo " 	<option   value=\"".$result[ccDigi]."\" ".$selected." > $result[DESC_CCAATT]  </option> " ; 
							   }
							  }    
							?>
                              </select>
						
                                <input name="button2" type="button" onclick="document.post.ampid.selectedIndex = 0; getvalue(this.form.ampid);" value="ล้างค่า" /> </td>
                          </tr>
                        </table>
						
                      </div>
                      <div class="tabbertab">
                        <h2>ข้อมูลทั่วไป</h2>
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" style="margin-top:5px;">
                          
                          <tr bgcolor="#ffffff">
                            <td align="right">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td width="26%" align="right"><label for="education" id="labeleducation">การศึกษาสูงสุด</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td width="74%"><select name="education" style="width:300px;" id="education" onchange="getvalue(this)" type="select">
                                <option value="" style="color:red;">ไม่ระบุ</option>
                                <?
								$sql 		= " select * from hr_addhighgrade ; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($education == $rs[highgrade]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[highgrade]."\" ".$selected.">".$rs[highgrade]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                                <input name="button3" type="button" onclick="document.post.education.selectedIndex = 0; getvalue(this.form.education);" value="ล้างค่า" />                            </td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="radub" id="labelradub">ระดับ</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><select name="radub" style="width:300px;" id="radub" onchange="getvalue(this)" type="select">
                                <option value="" style="color:red;">ไม่ระบุ</option>
                                <?
								$sql 		= " select radub from general  GROUP BY radub  order by radub asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($radub == $rs[radub]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[radub]."\" ".$selected.">".$rs[radub]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                                <input name="button3" type="button" onclick="document.post.radub.selectedIndex = 0; getvalue(this.form.radub);" value="ล้างค่า" /> </td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="position_now" id="labelposition_now">ตำแหน่ง</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><select name="position_now" style="width:300px;" id="position_now" onchange="getvalue(this)" type="select">
                                <option value="" style="color:red;">ไม่ระบุ</option>
                                <?
								$sql 		= " select  position_now from general GROUP BY position_now  order by position_now asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($position_now == $rs[position_now]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[position_now]."\" ".$selected.">".$rs[position_now]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                                <input name="button3" type="button" onclick="document.post.position_now.selectedIndex = 0; getvalue(this.form.position_now);" value="ล้างค่า" />                            </td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td height="20" align="right"><label for="unit" id="labelunit">สังกัด</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><div id="div_unit">
                                <select name="unit" style="width:300px;" id="unit" onchange="getvalue(this)" type="select">
                                  <option value="" style="color:red;">ไม่ระบุ</option>
                                  <?
									$sqlcon	= (!empty($ampid)) ? " where ampid='$ampid' " : "" ;
									$sql 		= " select id, office from login ".$sqlcon." order by office asc; ";
									$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
									while($rs = mysql_fetch_assoc($result)){
										$selected = ($unit == $rs[id]) ? " selected style=\"color:#0066CC\" " : "" ;
										echo "<option value=\"".$rs[id]."\" ".$selected.">".$rs[office]."</option>";
									}
									mysql_free_result($result);
									unset($rs,$sql,$selected);
									?>
                                </select>
                                <input name="button3" type="button" onclick="document.post.unit.selectedIndex = 0; getvalue(this.form.unit);" value="ล้างค่า" />
                            </div></td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td height="20" align="right"><label for="home" id="labelhome">ภูมิลำเนา</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><select name="home" style="width:300px;" id="home" onchange="getvalue(this)" type="select">
                                <option value="" style="color:red;">ไม่ระบุ</option>
                                <?
								$sql 		= " select id, province from hr_province order by province asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($home == $rs[id]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[id]."\" ".$selected.">".$rs[province]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                                <input name="button3" type="button" onclick="document.post.home.selectedIndex = 0; getvalue(this.form.home);" value="ล้างค่า" /> </td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td height="20" align="right"><label for="sal1" id="labelsal1">เงินเดือน</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><input type="text" name="sal1" value="<?=$sal1?>" style="width:100px;" maxlength="6" id="sal1"  onKeyDown="getvalue(this)" onKeyUp="getvalue(this)" />
                              &nbsp;<label for="sal2" id="labelsal2"> </label>-
                              <input type="text" name="sal2" value="<?=$sal2?>" style="width:100px;" maxlength="6" id="sal2"  onKeyDown="getvalue(this)" onKeyUp="getvalue(this)"/>
                              &nbsp;( เช่น 8000 ถึง 15000 ) </td>
                          </tr>
                        </table>
                      </div>
                      <div class="tabbertab">
                        <h2>วิทยฐานะ</h2>
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" style="margin-top:5px;">
                          
                          <tr bgcolor="#ffffff">
                            <td width="26%" align="right">&nbsp;</td>
                            <td width="74%">&nbsp;</td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="label" id="labelvitaya_opt">วิทยฐานะ</label>
&nbsp;<b>:</b>&nbsp;</td>
                            <td><select name="vitaya_opt" style="width:180px;" onchange="checkwitaya(this);getvalue(this);"id="vitaya_opt" type="select">
                              <option value="" <?=isselected("", $vitaya_opt)?>>ทั้งหมด</option>
                              <option value="1" <?=isselected(1, $vitaya_opt)?>>ได้รับวิทยฐานะ</option>
                              <option value="2" <?=isselected(2, $vitaya_opt)?>>ไม่ได้รับวิทยฐานะ</option>
                              <option value="3" <?=isselected(3, $vitaya_opt)?>>เลื่อนวิทยฐานะ</option>
                              <?
								if(isselected(2, $vitaya_opt)==" selected style=\"color:#0066CC\" " || isselected("", $vitaya_opt)==" selected style=\"color:#0066CC\" " ){
									$st_positiongroup = " disabled='disabled' ";
									$st_radabwit = " disabled='disabled' ";
									$st_upvitaya = " disabled='disabled' ";
									$st_positionvitaya = " disabled='disabled' "; 
								}else if(isselected(3, $vitaya_opt)==" selected style=\"color:#0066CC\" "){
								
									$st_positiongroup = " disabled='disabled' ";
									$st_radabwit = " disabled='disabled' ";
									
								}else{									
									$st_positiongroup = "";
									$st_radabwit = "";
								}
								
								?>
                            </select>
                              <input name="button42" type="button" onclick="document.post.vitaya_opt.selectedIndex = 0; getvalue(this.form.vitaya_opt);" value="ล้างค่า" /></td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="positiongroup" id="labelpositiongroup">สายงานการบริหาร</label>&nbsp;<b>:</b>&nbsp;</td>
                            <td><label>
							<select name="positiongroup" style="width:180px;" id="positiongroup" <?=$st_positiongroup?> onchange="getvalue(this)" type="select">
							 <option value="" selected="selected" style="color:red;">ไม่ระบุ</option>
                              <?
								$sql 		= " select * from hr_positiongroup order by positiongroupid asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($positiongroup == $rs[positiongroupid]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[positiongroupid]."\" ".$selected.">".$rs[positiongroup]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                              <input name="button4" type="button" id="button4" onclick="document.post.positiongroup.selectedIndex = 0; getvalue(this.form.positiongroup);" value="ล้างค่า" />
							  </label></td>
                          </tr>
                          
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="radabwit" id="labelradabwit">ระดับวิทยฐานะ</label> :&nbsp;</td>
                            <td><label>
                              <select name="vitaya_type" style="width:180px;" id="radabwit"  onchange="getvalue(this)" <?=$st_radabwit?> type="select">
                                <option value="" selected="selected" style="color:red;">ไม่ระบุ</option>
                              <?
								$sql 		= " select  vitaya from general where vitaya<>'' GROUP BY vitaya order by vitaya asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($vitaya_type == $rs[vitaya]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[vitaya]."\" ".$selected.">".$rs[vitaya]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                              </select>
                              <input name="button4" type="button" onclick="document.post.vitaya_type.selectedIndex = 0; getvalue(this.form.vitaya_type);" value="ล้างค่า" />
                            </label>							</td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="positionvitaya" id="labelpositionvitaya">ตำแหน่ง </label>:&nbsp;</td>
                            <td>
							<select name="positionvitaya" style="width:180px;" id="positionvitaya" <?=$st_positionvitaya?> onchange="getvalue(this)" type="select">
                              <option value="" selected="selected" style="color:red;">ไม่ระบุ</option>
                              <?
								$sql 		= " select   position_now  from general  WHERE (general.vitaya like '%เชี่ยวชาญ%' OR general.vitaya like '%ชำนาญ%'   )  group by position_now order by vitaya asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($positionvitaya == $rs[position_now]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[position_now]."\" ".$selected.">".$rs[position_now]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                            </select>
							<input name="button43" type="button" onclick="document.post.positionvitaya.selectedIndex = 0; getvalue(this.form.positionvitaya);" value="ล้างค่า" /></td>
                          </tr>
						  
                          <tr bgcolor="#ffffff">
                            <td align="right"><label for="upvitaya" id="labelupvitaya">เลื่อนวิทยฐานะเป็น </label>
                              :&nbsp;</td>
                            <td><select name="upvitaya" style="width:180px;" id="upvitaya" <?=$st_upvitaya?> onchange="getvalue(this)" type="select">
                              <option value="" selected="selected" style="color:red;">ไม่ระบุ</option>
                              <?
								$sql 		= " select   vitaya  from general  WHERE (general.vitaya like '%เชี่ยวชาญ%' OR general.vitaya like '%ชำนาญ%'   )   group by vitaya order by vitaya asc; ";
								$result	= mysql_query($sql)or die("line ". __LINE__  ."<hr>".mysql_error());
								while($rs = mysql_fetch_assoc($result)){
									$selected = ($upvitaya == $rs[vitaya]) ? " selected style=\"color:#0066CC\" " : "" ;
									echo "<option value=\"".$rs[vitaya]."\" ".$selected.">".$rs[vitaya]."</option>";
								}
								mysql_free_result($result);
								unset($rs,$sql,$selected);
								?>
                            </select>
                              <input name="button44" type="button" onclick="document.post.upvitaya.selectedIndex = 0; getvalue(this.form.upvitaya);" value="ล้างค่า" /></td>
                          </tr>
                        </table>
                      </div>
					  
                      <div class="tabbertab">
                        <h2>ปีเกษียณอายุราชการ</h2>
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" style="margin-top:5px;">
                          <tr bgcolor="#ffffff">
                            <td align="right">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr bgcolor="#ffffff">
                            <td width="26%" align="right"><label for="year" id="labelyear">ปีงบประมาณ</label> <b>:</b>&nbsp;</td>
                            <td width="74%"><label>
                              <input name="year" type="text" id="year" value="<?=$year?>" size="6" maxlength="4" onKeyDown="getvalue(this)" onKeyUp="getvalue(this)"/>
                              </label>
							  </td>
                          </tr>
                        </table>
                      </div>
                    </div>
					</td>
                  </tr>
                  
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </div>
</form>
<? 
//Searching Condition
//Fix variable
$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
$e			= (!isset($e) || $e == 0) ? 20 : $e ;
$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

$get[]	= "action=$action";
$con[] 	= " ( general.insideout = '' or general.insideout is null or general.insideout = '0' ) " ; //ไม่นับมาช่วยราชการ
//end Fix

$get[]	= "name_th=$name_th";

// พื้นที่	
//----------------------------------------------------------------------------------------------------------------
$get[] = "area=$area";

$get[] = "dpvar=$dpvar";
$get[] = "dpvar2=$dpvar2";


if(!empty($ccDigi)){

//echo $ampid="substr('$ccDigi',0,5)";
 $amp= substr($ccDigi,0, 4);

	$con[] 	= "  substring(allschool.moiareaid,1,4)='$amp' " ;
	$get[]	= "moiareaid=$amp";	

  }

if(!empty($amp)){
	$con[] 	= "   ccDigi like '%$amp%'" ;
	$get[]	= "ccDigi=$amp";	
}


// ข้อมูลทั่วไป
$get[] = "personnel=$personnel";
	
if(!empty($unit)){
	$con[] 	= " general.unit='$unit' " ;
	$get[]	= "unit=$unit";
}
	
if(!empty($position_now)){
  	$con[] 	= " general.position_now='$position_now'  ";
	$get[]	= "position_now=$position_now";
}	
	
if(!empty($education)){			
	$con[] 	= " general.education='$education' "; 
	$get[]	= "education=$education";
}
		
if(!empty($home)){
	$con[] 	= " general.home='$home' ";	
	$get[]	= "home=$home";
}
		
if(!empty($radub)){
	$con[] 	= " general.radub='$radub' ";	
	$get[]	= "radub=$radub";
}	
	
if(!empty($sal1) && !empty($sal2)){
	$con[] 	= " general.salary between '$sal1' and '$sal2' ";	
	$get[]	= "sal1=$sal1";
	$get[]	= "sal2=$sal2";
} elseif(!empty($sal1)){		
	$con[] 	= " general.salary > '$sal1' ";			
	$get[]	= "sal1=$sal1";
}

//////////////////  วิทยฐานะ ////////////////////////////////////
$get[] = "vitaya=$vitaya";

if(!empty($positiongroup)){
  	$con[] 	= " general.positiongroup='$positiongroup' ";
	$get[]	= "positiongroup=$positiongroup";
}

if($vitaya_opt == 2){
	$con[] 	= " ( general.vitaya = '' or general.vitaya is null ) ";
	$get[]	= "vitaya_opt=$vitaya_opt";
} elseif($vitaya_opt == 1) {
	$con[] 	= " general.vitaya <> '' ";
	$get[]	= "vitaya_opt=$vitaya_opt";
} else if($vitaya_opt == 3) {
// **************** เลื่อน 
	$getcondition = vitaya_find($positionvitaya,$upvitaya);
	$joinsql  = " INNER JOIN vitaya_stat  ON  general.id = vitaya_stat.id ";
	$con[] 	= " general.position_now like '$positionvitaya' ";
	$con[] 	= " $getcondition  " ;
	$get[]	= "vitaya_opt=$vitaya_opt";
	$get[] = "positionvitaya=$positionvitaya";
	$get[] = "upvitaya=$upvitaya";
	
#######################################	
} else{
	$get[]	= "vitaya_opt=$vitaya_opt";
}	
if(!empty($vitaya_type)){
  	$con[] 	= " general.vitaya='$vitaya_type' ";
	$get[]	= "positiongroup=$positiongroup";
	$get[]	= "vitaya_type=$vitaya_type";
}

#################################################

// ปีเกษียณอายุราชการ
$get[] = "retireYear=$retireYear";
	
if(!empty($year)){
	$year1 = $year-61;
	$year2	= $year-60;
	$con[]	= " (general.birthday like '".$year1."-10%' or general.birthday like '".$year1."-11%' or general.birthday like '";
	$con[]	.=	$year1."-12%' or general.birthday like '".$year2."-%' ) and (general.birthday not like '".$year2;
	$con[]	.=	"-10%' and general.birthday not like '".$year2."-11%' and general.birthday not like '".$year2."-12%' ) ";
	$get[]	= "year=$year";
}
//print_r($con);
//echo "<hr>";

if(count($con) >= 1){
	$condition 	= " and ".implode("and", $con);
}

if(count($get) >= 1){
	$keyword 	= "&".implode("&", $get);
}

if(count($join) >= 1){
	$joinsql 	= implode(" ", $join);
}

if(count($field) >= 1){
	$addfield	= ", ".implode(", ", $field);
}
//End Searching Condition

//=======================================Begin searching people
if($action == "view"){

	$sql		= " select count(distinct general.id) as num ";
	$sql		.= " from   allschool
Inner Join general ON allschool.id = general.schoolid
Inner Join login ON login.id = general.unit
Inner Join dopa_ampur ON dopa_ampur.secid = login.id ".$joinsql;
	$sql		.= " where ((general.name_th like '%".trim($name_th)."%' or general.surname_th like '%".trim($name_th)."%') ";
	$sql		.=	" and login.not_j18=1)  and  general.siteid='$_SESSION[siteid]' ".$condition." ";

	$sum	= mysql_query($sql)or die($sql."<br><br>Line " . __LINE__ . "<hr>".mysql_error());
	$rss			= mysql_fetch_assoc($sum);
	$all			= $rss[num];
	$allpage	= ceil($all / $e);
	mysql_free_result();
	unset($sql,$rss,$sum);

	$time_e 	= getmicrotime();
	$stime		= number_format($time_e - $time_start,2);
	$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;

	//Field(s)  Select
	$sql		= " select distinct   general.id, general.idcard,  general.prename_th, general.name_th, general.surname_th, general.position_now, ";
	$sql		.= " general.approve_status, login.username, login.office, general.vitaya, login.ampid, general.education, ";
	$sql		.=	" general.salary,general.siteid, general.birthday,dopa_ampur.secid,dopa_ampur.ccDigi,dopa_ampur.DESC_CCAATT,allschool.office,allschool.moiareaid ".$addfield;
$sql		.= " from   allschool  Inner Join general ON allschool.id = general.schoolid  Inner Join login ON login.id = general.unit  Inner Join dopa_ampur ON dopa_ampur.secid = login.id ".$joinsql;
	$sql		.= " where ((general.name_th like '%".trim($name_th)."%' or general.surname_th like '%".trim($name_th)."%') ";
	$sql		.=	" and login.not_j18='1')   and  general.siteid='$_SESSION[siteid]'  ".$condition." group by  general.id order by general.unit ";
	    echo"$sql";
	if($i>$all){
		$sql		.=	"; ";
		$i	= 0;
	} else {
		$sql		.= " limit $i, $e; ";
	}
	//echo "$sql <hr>" ;	
	$result 	= mysql_query($sql)or die($sql."<br><br>Line " . __LINE__ . "<hr>".mysql_error());
	$record	= mysql_num_rows($result);
	if($record <= 0){
?>
<table width="99%" border="0" cellpadding="0" cellspacing="2" bgcolor="#E6E6E6" align="center" style="border:1px solid #5595CC;">
<tr>
	<td height="20">
	<ul><br />
	<img src="../images/web/alert.gif" width="16" height="17" align="absmiddle" />&nbsp;ผลการค้นหา - ไม่ตรงกับบุคลากรใด ๆ<br /><br />
	ข้อแนะนำ :<br />
	- ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br />
	- ลดเงื่อนไขการค้นหาลง<br /><br />
	</ul>
	</td>
</tr>
</table>
<? 
	} else { 
?>
<table width="99%" border="0" cellpadding="0" cellspacing="2" bgcolor="#E6E6E6" align="center" style="border:1px solid #5595CC;">
<tr align="right">
	<td height="20">
	ผลการค้นหา <?="<b>".($i + 1)." - ".$sumpage."</b>"?> รายการจากทั้งหมด <b><?=number_format($all)?></b>  คน
	( <b><?=$stime?></b> วินาที)&nbsp;</td>
</tr>
</table>
<table border="0" width="99%" cellspacing="1" cellpadding="2" bgcolor="black" align="center" style="margin-top:5px; margin-bottom:5px;">
<tr bgcolor="#A3B2CC">
	<th width="5%"> ลำดับที่ </th>
<?
if(!empty($year)){
?>
	<th width="10%"> วันเดือนปีเกิด</th>
<?
}
?>
	<th width="17%"> ชื่อ-นามสกุล</th>
	<th width="18%">ตำแหน่งปัจจุบัน</th>
	<th width="9%">ระดับวิทยฐานะ</th>
<!--	<th width="10%">วันที่ได้รับวิทยฐานะ</th>		-->
	<th width="24%">ชื่ออำเภอ<br /></th>
    <th width="9%">สำเนาเอกสาร<br />
    ต้นฉบับ</th>
    <th width="8%">ทะเบียนประวัติ<br />
    (ก.พ.7)</th>
</tr>
<?
		while($rs = mysql_fetch_assoc($result)){
			
			$i += 1;	
			$color 		= ($i%2 == 0) ? "#DDDDDD" : "#EFEFEF" ;
			$inside		= ($rs[inside] == "1") ? "( มาช่วยราชการ )" : "" ;
			$outside	= ($rs[outside] == "1") ? "( ไปช่วยราชการ )" : "" ;
			$vitaya		= (!empty($rs[vitaya])) ? $rs[vitaya] : "" ;
		
			//if($_SESSION[idoffice] == "13000200" || $_SESSION[isprivilage] == "hrexec"  || $_SESSION[isprivilage] == "hrexec_all" ){
				$pdf		= "<a href=\"kp7.php?id=".$rs[id]."\" target=\"_blank\">";
				$pdf		.= "<img src=\"bimg/pdf.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"></a>";
			//}
?>
<tr align="center" bgcolor="<?=$color?>" onmouseover='mOvr(this,"dbf2ae");' onmouseout='mOut(this,"<?=$color?>");'>
	<td height="20"><?=$i?></td>	
<?
if(!empty($year)){
?>
	<td align="center"><?=daythai(swapdate($rs[birthday]))?></td>
<?
}
?>
	<td align="left">&nbsp;<? if($vitaya_opt != "" ){?>
    <a href="view_vitaya.php?getid=<?=$rs[id]?>&vitaya=<?=$vitaya?>" target="_blank"><?=$rs[prename_th]."".$rs[name_th]." ".$rs[surname_th]."&nbsp;".$inside.$outside?></a><? }else{ ?><?=$rs[prename_th]."".$rs[name_th]." ".$rs[surname_th]."&nbsp;".$inside.$outside?><? } ?></td>
	<td align="left">&nbsp;<?=$rs[position_now]?></td>
	<?
	if($vitaya=="")
		$vitaya		=	"ไม่ได้รับวิทยฐานะ";

	$date_vitaya	=	"";
	
	if(substr($rs[username],0, 2)=="sc"){
		$office_name = "โรงเรียน".$rs[DESC_CCAATT];
	} else {
		$office_name = $rs[DESC_CCAATT];
	}
	?>
	<td align="center"><?=$vitaya?></td>
<!--	<td align="center"><?=$date_vitaya?></td>	-->
	<td align="left"><?=$office_name?></td>
    <td><? $filepath = "../../../../edubkk_kp7file/$rs[idcard].pdf" ; if(file_exists($filepath)){?><a href="<?=$filepath?>" target="_blank"><img src="../../../images_sys/gnome-mime-application-pdf.png" width="16" height="16" border="0"></a><?  } ?></td>
    <td><?=$pdf?></td>
</tr>
<? 	
		} 
		mysql_free_result($result);
?>	
</table>
<table width="99%" border="0" cellpadding="0" cellspacing="2" bgcolor="#E6E6E6" align="center" style="border:1px solid #5595CC;">
<tr align="right">
	<td height="20"><?=devidepage($allpage, $keyword)?></td>
</tr>
</table>
<? 
	}
}
?>
<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" style="border-top:1px #CCCCCC solid"><? include("licence_inc.php");  ?></td>
  </tr>
</table>
<?
if($_SERVER['REQUEST_METHOD'] == "POST"){
	echo "<script language=\"javascript\">";
	echo "showEle('div_search_all');";
	echo "</script>";
}
?>

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
</body>
</html>

