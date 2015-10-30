<?
include ("session.inc.php");
session_start();




	

		unset($_SESSION[islogin]);
//		unset($_SESSION[id] );
	
	 $url="index.php"; 



	?>
<HTML><HEAD>
<TITLE>Logout</TITLE>
<meta http-equiv="refresh" content="0;URL=<?=$url?>">