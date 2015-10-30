<?
session_start() ; 
$xsiteid = $_SESSION[secid] ; 
$_SESSION[siteid] = $_SESSION[secid] ; 
include ("../../config/conndb_nonsession.inc.php")  ;
if($_SESSION['session_username'] == ""){
	header("Location: login.php");
	die;
}

if($_SESSION['session_sapphire'] == "1"){

	$main_url = "main_report2.php";
}else{
	$main_url = "blankpage2.php";
}
?>
<html>
<head>
<title>CMSS : Competency Management Supporting System</title>
<META http-equiv=Content-Type content="text/html; charset=windows-874">


<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<? include ("header.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #398BCB">
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="165" align="left" valign="top" bordercolor="#E6E6E6" bgcolor="#CCCCCC"><? include ("left_menu.php");?></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td></td>
              </tr>
              <tr>
                <td>
				<iframe src="<?=$main_url?>" width="100%" height="600" frameborder="0" hspace="0" marginwidth="0" vspace="0"   name="iframe_body"  id="iframe_body" style="z-index:9999"></iframe>				</td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><span style="border-right:1 solid #909090">
      <? include ("footer.php");?>
    </span></td>
  </tr>
</table>
</body>
</html>
