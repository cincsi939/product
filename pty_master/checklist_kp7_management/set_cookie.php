<?

setcookie("ck", "hello", time()+3600);
#echo $_COOKIE["PHPSESSID"]."<br>";

if (isset($_COOKIE["ck"]))
echo "ยินดีต้อนรับ " . $_COOKIE["ck"] . "!<br />";
else
echo "cookie ยังไม่ถูกเซ็ท!<br />";
?>