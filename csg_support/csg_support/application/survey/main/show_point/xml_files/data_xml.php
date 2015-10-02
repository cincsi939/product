<? 
header("Content-type: text/xml; charset=utf-8");
$getidcard = $_GET['id'];
$dataA = $_GET['x'];
$dataB = $_GET['y'];
include('../../../lib/class.function.php');

$pic_default = $pic_default = "../images/nopicture.gif";

function parseToXML($htmlStr) { 
	$xmlStr=str_replace('<','&lt;',$htmlStr); 
	$xmlStr=str_replace('>','&gt;',$xmlStr); 
	$xmlStr=str_replace('"','&quot;',$xmlStr); 
	$xmlStr=str_replace("'",'&#39;',$xmlStr); 
	$xmlStr=str_replace("&",'&amp;',$xmlStr); 
	return $xmlStr; 
} 

$icon = "gnome-home.png";

$arr = array("$dataA,$dataB");
echo "<markers>";
for($i=0;$i<=50;$i++){
	$arrlatlng	= explode(",",$arr[$i]);
	if($arrlatlng[0]!='' && $arrlatlng[1]!=''){
	  echo '<marker ';  
		echo 'name="'.parseToXML('').'" ';
		echo 'address="" ';
		echo 'lat="'.$arrlatlng[0].'" ';
		echo 'lng="' . $arrlatlng[1].'" ';
		echo 'picture="picture" ';
		echo 'icon="images/'.$icon.'" ';
	    echo 'identify="identify.php?id='.$getidcard.'"
		 ';
	  echo '/>';
	}
  
}//end while1

echo "</markers>";
?>