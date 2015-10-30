<?
include("epm.inc.php");
include("function.php");
$org_id	= intval($_SESSION[session_dev_id]);
$sex 		= array("M"=>"ชาย","F"=>"หญิง");	
$m1		= array("#default", "user_pf.php", "user_ht.php");
$m2		= array("เปลี่ยนรหัสผ่าน", "ข้อมูลส่วนตัว", "รายละเอียดการเข้าใช้งาน");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" rel="stylesheet" />
<title>แก้ไขรายละเอียดต่าง ๆ</title>
<style>
.p_border{
border-bottom:2 solid #DADCED;
}
.shadetabs{
padding				: 3px 0px ;
margin-left			: 0;
margin-top			: 1px;
margin-bottom	: 0;
font					: bold 12px tahoma;
list-style-type		: none;
text-align			: left; /*set to left, center, or right to align the menu as desired*/
}

.shadetabs li{
display	: inline;
margin	: 0;
background-color:#F2F4F7;
}

.shadetabs li a{
text-decoration	: none;
padding				: 3px 7px;
margin-right		: 0px;
border				: 1px solid #cccccc;
color					: #666666;
text-decoration	:underline;
}

.shadetabs li a:visited{
color					: #666666;
}

.shadetabs li a:hover{
color					: #666666;
}

.shadetabs li.selected{
position			: relative;
top				: 1px;
}



.shadetabs li.selected a{ /*selected main tab style */
background-color		: #DADCED;
border-bottom-color	: #DADCED;
}

.shadetabs li.selected a:hover{ /*selected main tab style */
text-decoration			: none;
}

.contentstyle{
border						: 1px solid #cccccc;
width							: 700px;
margin-bottom			: 1em; 
padding						: 10px;
background-color		: #DADCED;
}

body {
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
}
</style>
<script language="javascript" src="ajaxtabs.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="javascript">

function postData(){
		if(document.form2.old_pwd.value.length==0) {
		alert("กรุณากรอกรหัสผ่าน");
		document.form2.old_pwd.focus();
		return false;
	} else if(document.form2.new_pwd1.value.length==0) {
		alert("โปรดใส่รหัสผ่านใหม่");
		document.form2.new_pwd1.focus();
		return false;
	} else if(document.form2.new_pwd1.value.length != document.form2.new_pwd2.value.length) {
		alert("รหัสผ่านทั้งสองไม่ตรงกัน กรุณายืนยันรหัสผ่านให้ถูกต้อง") ;
		document.form2.new_pwd2.focus() ;
		return false ;	
	} 

	
	$.post("user_cpwd.php", { 
		   old_pwd: $("#old_pwd").val(),
		   new_pwd1:$("#new_pwd1").val(),
		   new_pwd2:$("#new_pwd2").val()
		   }, 
		function(data){
			$("#divPostData").html(data);
		}
	);
}




var xmlHttp;
function GetXmlHttpObject(){
	if (window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	}
	if (window.ActiveXObject){  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	  }
return null;
}//end function GetXmlHttpObject(){



function ChangePass() {

	if(document.form2.old_pwd.value.length==0) {
		alert("กรุณากรอกรหัสผ่าน");
		document.form2.old_pwd.focus();
		return false;
	} else if(document.form2.new_pwd1.value.length==0) {
		alert("โปรดใส่รหัสผ่านใหม่");
		document.form2.new_pwd1.focus();
		return false;
	} else if(document.form2.new_pwd1.value.length != document.form2.new_pwd2.value.length) {
		alert("รหัสผ่านทั้งสองไม่ตรงกัน กรุณายืนยันรหัสผ่านให้ถูกต้อง") ;
		document.form2.new_pwd2.focus() ;
		return false ;	
	} 

	
	var rnd				= "rnd=" + Math.random();
	var pwd_old 		= "&pwd_old=" + document.form2.old_pwd.value;
	var pwd_new	= "&pwd_new=" + document.form2.new_pwd1.value;	
	var url_user = "user_cpwd.php";
	
	var param			= rnd + pwd_old + pwd_new;
	var txt				= "&nbsp;&nbsp;<img src=\"images/indicator.gif\" align=\"absmiddle\" height=\"16\" width=\"16\">&nbsp;Updating...";	
	document.getElementById("Status").innerHTML= txt;
	//alert("test");return false;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
  	alert ("Browser does not support HTTP Request");
  	return false;
  	}
	//return false;
 	xmlHttp.open("POST", url_user, true); 
    xmlHttp.onreadystatechange = function() { 
	//alert(xmlHttp.readyState);
         if (xmlHttp.readyState==4) {
			// alert(xmlHttp.responseText);
              if (xmlHttp.status==200) {
			
				  document.getElementById("Status").innerHTML = xmlHttp.responseText }
         }
    };

    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlHttp.send(param); 
	document.form2.reset();
}

function UpdateProfile() {

	if(document.profile.staffname.value.length==0) {
		alert("โปรดระบุชื่อภาษาไทย");
		document.profile.staffname.focus();
		return false;
	} else if(document.profile.staffsurname.value.length==0) {
		alert("โปรดระบุนามสกุลภาษาไทย");
		document.profile.staffsurname.focus();
		return false;
	} else if(document.profile.engname.value.length==0) {
		alert("โปรดระบุชื่อภาษาอังกฤษ");
		document.profile.engname.focus();
		return false;
	} else if(document.profile.engsurname.value.length==0) {
		alert("โปรดระบุนามสกุลภาษาอังกฤษ");
		document.profile.engsurname.focus();
		return false;	
	} else if(document.profile.email.value.length != 0) {	
		
		if(profile.email.value.indexOf('@')==-1) {
	  		alert("อีเมล์ของคุณไม่ถูกต้องครับ") ;
	  		document.profile.email.focus() ;
	  		return false ;
  		} else if(profile.email.value.indexOf('.')==-1) {
	  		alert("อีเมล์ของคุณไม่ถูกต้องครับ") ;
	  		document.profile.email.focus() ;
	  		return false ;
	  	}			

	} 

	var rnd					= "rnd=" + Math.random();
	var prename			= "&prename=" + document.profile.prename.value;
	var staffname 		= "&staffname=" + document.profile.staffname.value;
	var staffsurname	= "&staffsurname=" + document.profile.staffsurname.value;		
	var engprename	= "&engprename=" + document.profile.engprename.value;		
	var engname			= "&engname=" + document.profile.engname.value;		
	var engsurname	= "&engsurname=" + document.profile.engsurname.value;		
	var email				= "&email=" + document.profile.email.value;	
	var sex					= "&sex=" + document.profile.sex.value;	
	var title					= "&title=" + document.profile.title.value;	
	var telno				= "&telno=" + document.profile.telno.value;	
	var address			= "&address=" + document.profile.address.value;		
	var comment			= "&comment=" + document.profile.comment.value;		
	var param		= rnd + prename + staffname + staffsurname + engprename + engname + engsurname + email + sex + title + telno + address + comment ;
	var txt			= "&nbsp;&nbsp;<img src=\"images/indicator.gif\" align=\"absmiddle\" height=\"16\" width=\"16\">&nbsp;Updating...";
	document.getElementById("Status").innerHTML= txt;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
  		alert ("Browser does not support HTTP Request");
  		return false;
  	}
 	xmlHttp.open("POST", "user_profile.php", true); 
	alert("error");return false;
    xmlHttp.onreadystatechange = function() { 
         if (xmlHttp.readyState==4) {
              if (xmlHttp.status==200) { document.getElementById("Status").innerHTML = xmlHttp.responseText }
         }
    };

    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlHttp.send(param); 	

}	

	

function uplImage()	{

	var url 			= "user_image.php?rnd=" + Math.random() ;
	var newwin 	= window.open(url ,'popup','location=0,status=no,scrollbars=no,resizable=no,width=400,height=120,top=200');
	newwin.focus();

}

</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr valign="top">
    <td>
<ul id="maintab" class="shadetabs">
&nbsp;
<?
for($i=0;$i<count($m1);$i++){

	$showtab = ($i<=0) ? " class=\"selected\" " : "" ;	
	echo "<li $showtab><a href=\"".$m1[$i]."\" rel=\"ajaxcontentarea\">".$m2[$i]."</a></li>";

}
?>
</ul>
<div id="ajaxcontentarea" class="contentstyle" align="left" style="width:100%">
<form id="form2" name="form2" method="post" action="">
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#F2F4F7">
<tr>
	<td align="left" bgcolor="#DADCED"><span style="font-size:11pt; font-weight:bold">เปลี่ยนข้อมูลรหัสผ่าน</span></td>
</tr>
<tr>
	<td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr align="center">
	<td colspan="2"><div id="divPostData"></div></td>
</tr>
<tr>
	<td width="171" height="20" align="left" class="p_border" ><strong>รหัสผ่านเดิม</strong>&nbsp;</td>
    <td width="754" class="p_border" ><input name="old_pwd" id="old_pwd" type="password" style="width:150;" size="20" maxlength="20"></td>
</tr>
<tr>
	<td height="20" align="left"><strong>รหัสผ่านใหม่</strong>&nbsp;</td>
	<td><input name="new_pwd1" id="new_pwd1" type="password" style="width:150;" size="20" maxlength="20"></td>
</tr>
<tr>
    <td height="20" align="left"><strong>ยืนยันรหัสผ่านใหม่</strong>&nbsp;</td>
	<td><input name="new_pwd2" id="new_pwd2" type="password" style="width:150;" size="20" maxlength="20"></td>
</tr>
</table>
	</td>
</tr>
<tr>
	<td align="left" bgcolor="#DADCED"><input type="button" name="Button2" id="button2" value="OK" onclick="postData()" />
    </td>
</tr>
</table>
</form>	
</div>	
	</td>
</tr>
</table>
<script type="text/javascript">startajaxtabs("maintab")</script>
</body>
</html>