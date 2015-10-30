<?
session_start();
set_time_limit(0);
setcookie("ck", "hello", time()+3600);

if (isset($_COOKIE["ck"]))
echo "ยินดีต้อนรับ " . $_COOKIE["ck"] . "!<br />";
else
echo "cookie ยังไม่ถูกเซ็ท!<br />";
?>