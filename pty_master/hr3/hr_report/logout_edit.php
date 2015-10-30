<?
include ("session.inc.php");
session_start();
session_destroy();	
	
	 header("Location: http://www.cmss-otcsc.com"); 
	 die;
?>