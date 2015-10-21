<?php
//header("content-type:text/javascript;charset=tis-620"); 
# FileName="connect.php"
$hostname = "192.168.2.102";
$database = "eval_db";
$username = "trainee";
$password = "123456";
//$mysqli = query("SET names tis-620");
//$mysqli->set_charset('tis-620');
//$rel = mysql_set_charset($connect, "tis-620");




$connect = mysql_connect("$hostname", "$username", "$password", "$database");
$bool = mysql_select_db($database);
mysql_query("SET character_set_results=tis-620");
mysql_query("SET NAMES TIS620");

?>