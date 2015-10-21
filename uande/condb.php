<?php
$host = "192.168.2.102"  ;
$username = "trainee"  ;
$password = "123456"  ;
$db_name = "eval_db";
$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database  ");
@mysql_select_db($db_name) or die( "Unable to select database");


$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

?>