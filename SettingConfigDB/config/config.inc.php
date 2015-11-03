<?php
session_start();

if($_SESSION['UserDB']!=""){
$conn=mysql_connect($_SESSION['HostDB'],$_SESSION['UserDB'],$_SESSION['PasswordDB']);
}
?>