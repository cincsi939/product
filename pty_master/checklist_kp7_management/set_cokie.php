<?
session_start();
set_time_limit(0);
setcookie("ck", "hello", time()+3600);

if (isset($_COOKIE["ck"]))
echo "�Թ�յ�͹�Ѻ " . $_COOKIE["ck"] . "!<br />";
else
echo "cookie �ѧ���١��!<br />";
?>