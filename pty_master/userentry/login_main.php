<?
session_start();
include "epm.inc.php";
if($_GET['debug'] == "ON"){
echo "<pre>";
print_r($_SESSION);die();
}
if(!isset($_SESSION[session_staffid])){
//if($session_staffid == ''){
echo "<script type=\"text/javascript\">
window.location=\"login.php\";
</script>";
}
$sql_staff = "SELECT * FROM keystaff  WHERE staffid='$session_staffid'";
$result_staff = mysql_db_query($db_name,$sql_staff);
$rs_staff = mysql_fetch_assoc($result_staff);
$flag_change_password = $rs_staff[flag_change_password]; //  สถานการการเปลี่ยน password 
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
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #398BCB">
  <tr>
    <td><? include ("login_top.php");?></td>
  </tr>
  
  
  <tr>
    <td>
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="165" align="left" valign="top" bgcolor="#999999"><? include ("login_left.php");?></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td></td>
              </tr>
              <tr>
                <td >
                <iframe src=" <? if($_SESSION['session_staffid'] == "11026"){ echo "../../report/report_keydata_main.php";}else if($flag_change_password == "1"){ echo "user_properties.php"; }else if ( $_SESSION['session_sapphire'] == "1" ){ echo "index_key_report.php";} else{ echo "report_user_preview1.php";} ?>" width="100%" height="600" frameborder="0" hspace="0" marginwidth="0" vspace="0"   name="iframe_body"  id="iframe_body" style="z-index:9999"></iframe>
                </td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
