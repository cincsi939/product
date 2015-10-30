<?
	#START
	###### This Program is copyright Sapphire Research and Development co.,ltd ########
	#########################################################
	$ApplicationName= "AdminReport";
	$module_code = "statuser";
	$process_id = "display";
	$VERSION = "9.1";
	$BypassAPP= true;
	#########################################################
	#Developer::Pairoj
	#DateCreate::29/03/2007
	#LastUpdate::29/03/2007
	#DatabaseTable::schooll_name, login
	#END
	#########################################################
	
	session_start();
	set_time_limit(8000);
	if($_GET[xstaff_id]==""){
	$xstaff_id=$_SESSION['session_staffid'];	
	
}		
	include ("preloading.php")  ;
	include ("../../common/common_competency.inc.php")  ;
	include("../../config/conndb_nonsession.inc.php");
	include ("../../common/std_function.inc.php")  ;
	
	$dbnameuse = DB_USERENTRY;
	
	$sql =  " SELECT  numkpoint  FROM  stat_user_keyin WHERE  staffid = '$xstaff_id' AND datekeyin='".date("Y-m-d")."'" ;
	$result = mysql_db_query($dbnameuse,$sql) ;
	$rs = mysql_fetch_assoc($result);
	
	$Score = ( $rs[numkpoint] ) ? number_format($rs[numkpoint]) : "0";
?>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<link href="../../common/style.css" type="text/css" rel="stylesheet">

<style type="text/css">
<!--
body {
	background-color: #003366;
	background-image: url(images/score_bg_main.gif);
	background-repeat: no-repeat;
}
.style1 {
	font-size: 36px;
	color: #FF0000;
}
.style89 {font-size: 36px; font-weight: bold; font-family: Tahoma; color: #33CC33; }
-->
</style></head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td height="16" align="center" class="fillcolor_loginleft2"><strong class="ptext_w">Score</strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#333333"><table width="100%" border="0" cellpadding="2" cellspacing="1">
      <tr>
        <td align="center" background="images/score_bg.gif" class="style89"><?=$Score?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
