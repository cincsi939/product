<?
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK media=screen href="common/styles.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-h.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-v.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<script type="text/javascript" language="javascript" src="jquery.js"></script>
<SCRIPT language=JavaScript src="common/jquery.min.js" type=text/javascript></SCRIPT>
<script type="text/javascript">
<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{
	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#firstpane p.menu_head").click(function()
    {
		$(this).css({backgroundImage:"url(images/down.png)"}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
       	$(this).siblings().css({backgroundImage:"url(images/left.png)"});
	});
	
	
	//slides the element with class "menu_body" when mouse is over the paragraph
	$("#secondpane p.menu_head").mouseover(function()
    {
	     $(this).css({backgroundImage:"url(images/down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
         $(this).siblings().css({backgroundImage:"url(images/left.png)"});
	});
	
	
	
});
</script>
<SCRIPT language=JavaScript type=text/javascript>
$(document).ready(function() {
  $('.links li code').hide();  
  $('.links li p').click(function() {
    $(this).next().slideToggle('fast');
  });
});
</SCRIPT>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font: normal 13px Verdana, Arial, Helvetica, sans-serif;
	width:100%;
}
.menu_list {	
	margin:  0px;
	width: 170px;
}
.menu_head {
	padding: 5px 10px;
	/*font: normal 13px;*/
	font:normal 12px;
	width: 170px;
	color:#EFEFEF;
	text-decoration:none; 
	cursor:pointer;
	position: relative;
	margin:1px;
	background: #045199 url(images/left.png) center right no-repeat; 
	font-weight:bold;
}
.menu_head a{
/*	font: normal 13px;*/
	font:normal 12px;
	color:#EFEFEF;
	text-decoration:none; 
	font-weight:bold;
  }

.menu_body {
	display:none; 
	vertical-align:middle;
/*	font: normal 11px;*/
	font:normal 11 px;
	width: 175px;
  border:1px; border-color:#FFFFFF;
}
.menu_body a{
  display:block;
  color:#FFFFFF;
  width: 175px;
  height:23px;
  vertical-align:middle;
  background: #197FC9;
  text-decoration:none; 
  border:1px; border-color:#FFFFFF;
}
.menu_body a:hover{
  font: normal 12px;
  	width: 175px;
  color: #000000;
  font-weight:bold;
  vertical-align:middle;
  text-decoration:none; 
  background: #EFEFEF;
  border:1px; 
  border-color:#FFFFFF;
  }
  
  
.txtwhite {
	font-size: 12px;
	color: #FFFFFF;
}

.project_input{
	padding:5px;
}
.fillcolor_loginleft{	
	vertical-align: top;
	padding: 0pt;
	background-color:#ffffff;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#197FC9');
}
.fillcolor_loginleft2{	
	
	padding: 0pt;
	background-color:#197FC9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#197FC9', EndColorStr='#0C5FB5');
}
  
</style>


</head>

<body bgcolor="#273F6F">

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%" >

<TR HEIGHT="100" VALIGN=MIDDLE>

  <TD ALIGN=CENTER><table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#197FC9" style="margin-bottom:5px; margin-top:5px">

    <tr>

      <td width="1%" align="left" valign="top" background="images/user_information_08.gif" style="background-repeat: repeat-y"><IMG SRC="images/user_information_03.gif" WIDTH=6 HEIGHT=6 ALT=""></td>

      <td width="99%" background="images/user_information_04.gif" style="background-repeat:repeat-x; padding:3px">&nbsp;&nbsp;<strong class="txtwhite">ข้อมูลผู้ใช้</strong></td>

      <td width="0%" align="right" valign="top" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;"><img src="images/user_information_06.gif" width="6" height="6"></td>

    </tr>

    <tr>

      <td background="images/user_information_08.gif" style="background-repeat: repeat-y">&nbsp;</td>

      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="1%" valign="top" class="fillcolor_loginleft"><img src="images/user_information_14.gif" width="6" height="6"></td>

          <td width="99%" height="65" align="center" class="fillcolor_loginleft" style="background-repeat:no-repeat; background-position: top right; padding-top:5px;"><span style="padding-top:5px">

            <?

$sql 		= " select * from $epm_staff where staffid = '".$_SESSION[session_staffid]."' ";

$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());

$rs		= mysql_fetch_assoc($result);

$image	= ($rs[image] != "") ? $rs[image] : "nopicture.gif" ;

$user=base64_encode($rs[username]);
$pwd=base64_encode($rs[password]);
mysql_free_result($result);



?>

          </span>

            <div id="img" align="center"><img src="images/personnel/<?=$image?>" width="100"  border="0"></div></td>

          <td width="0%" align="center" valign="top" class="fillcolor_loginleft"><img src="images/user_information_30.gif" width="6" height="6"></td>

        </tr>

        <tr>

          <td align="left" valign="bottom" class="fillcolor_loginleft2"><img src="images/user_information_19.gif" width="6" height="6"></td>

          <td class="fillcolor_loginleft2" style="padding : 3px 0px 5px 0px;"><span class="txtwhite"><strong>&nbsp;ชื่อ&nbsp;:</strong> <U>

          <?=$_SESSION[session_fullname]?>

          </U></span><BR>          <span class="txtwhite"><strong>&nbsp;หน่วยงาน :</strong>&nbsp;<U>

          <?=$_SESSION[session_depname]?>

          </U></span><BR>          <span class="txtwhite"><strong>&nbsp;&nbsp;</strong></span><BR>          </td>

          <td align="right" valign="bottom" class="fillcolor_loginleft2"><img src="images/user_information_22.gif" width="6" height="6"></td>

        </tr>

        

      </table></td>

      <td align="right" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;">&nbsp;</td>

    </tr>

    <tr>

      <td align="left" valign="bottom" background="images/user_information_08.gif" style="background-repeat: repeat-y"><img src="images/user_information_23.gif" width="6" height="6"></td>

      <td height="5" background="images/user_information_25.gif" style="background-repeat:repeat-x; background-position:bottom">&nbsp;</td>

      <td align="right" valign="bottom" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;"><img src="images/user_information_26.gif" width="6" height="6"></td>

    </tr>

  </table></TD>

</TR>



<TR HEIGHT="1" VALIGN=TOP BGCOLOR="#333399"><TD ALIGN=CENTER></TD></TR>
  <tr>
  <td  width="165"  height="100%" align="center"><? include("left_menu.php");?></td>
 </tr>
<TR VALIGN=MIDDLE>
<TD ALIGN=LEFT valign="middle">&nbsp;</TD>

</TR>
<script language="javascript">

function setstyle(objst){

	var x = document.getElementById("active_menu_epm");

	if (x) x.id="";

	objst.id="active_menu_epm";

}

function updateImg(img){
	if(img == "images/personnel/"){
		image = "images/personnel/noimg.jpg";
	} else {
		image = img;
	}
	
	document.getElementById("img").innerHTML = "<img src=\""+ image + "\" width=\"150\" border=\"0\">" ;
}
//setstyle();
</script>

<TR HEIGHT="400" VALIGN=TOP ><TD ALIGN=CENTER></TD></TR>
</TABLE>

</BODY></HTML>