<?

setcookie("ck", "hello", time()+3600);
#echo $_COOKIE["PHPSESSID"]."<br>";

if (isset($_COOKIE["ck"]))
echo "�Թ�յ�͹�Ѻ " . $_COOKIE["ck"] . "!<br />";
else
echo "cookie �ѧ���١��!<br />";
?>