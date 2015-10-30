<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AuthorityManagement";
$module_code = "add";
$process_id = "add";
$VERSION = "9.1";
$BypassAPP= false;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
set_time_limit(1000);
			include("../../config/config_hr.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("../../common/common.inc.php")  ;
			//include ("../../inc/authority.inc.php")  ;
?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>User</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

</head>

<?
//if ($isAdmin){
?>
<frameset rows="75,*" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="org_top.php" name="topFrame" noresize scrolling=no>
  <frameset cols="520,*" frameborder="NO" border="0" framespacing="0">
	  <frame src="application.php" name="leftFrame">
	  <frame src="org_left.php" name="mainFrame">
  </frameset>
</frameset>
<!-- <?  //}else{ ?>
<frameset rows="95,*" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="index_top.php" name="topFrame" noresize scrolling=no>
  <frame src="admin_menu.php" name="mainFrame">
</frameset>
<? //} ?>
 --><noframes><body></body></noframes>
</html>
