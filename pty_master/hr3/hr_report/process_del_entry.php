<?
//include ("session.inc.php");
session_start();
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
//Conn2DB();
//เปลี่ยนข้อมูลที่โพสมาจาก AJAX จาก UTF-8 เป็น TIS-620
function post_decode($string) {
	$str = $string;
    $res = "";
    for ($i = 0; $i < strlen($str); $i++) {
    	if (ord($str[$i]) == 224) {
        	$unicode = ord($str[$i+2]) & 0x3F;
            $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
            $unicode |= (ord($str[$i]) & 0x0F) << 12;
            $res .= chr($unicode-0x0E00+0xA0);
            $i += 2;
       	} else {
            $res .= $str[$i];
        }
	}
    return $res;
}

$id		= post_decode($_POST['id']);
$runid	= post_decode($_POST['runid']);
$table	= post_decode($_POST['table']);

$sql		= " delete from `".$table."` where id='$id' and runid='$runid'; ";
$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
echo "deleted";
?>