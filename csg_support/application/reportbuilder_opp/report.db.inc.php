<?php
/**
 * @comment Config Database Reportbuilder
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    20/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: ตั้งค่าการเชื่อมต่อ Database และ รวม function ต่างๆ ที่ใช้ในทุกไฟล์
Version			: 1.0
Last Modified	: 27/7/2548
Changes		:
	27/7/2548 - รองรับการเชื่อมต่อ Database อื่นๆได้ (เพิ่มส่วนของ $_SESSION)
	6/8/2548	- รูปที่ Stretch เปลี่ยนเป็นขนาด 189 * 120

*****************************************************************************/
session_start();
include 'bootstrap.php';
// Default Database Setting
// @modify Phada Woodtikarn 20/06/2014 เปลี่ยน Config DB
$hostname = $db['host'];
$db_name=  $db['database_reportbuiler']; // database reportbuilder name
$db_username = $db['username'];
$db_password = $db['password'];
$data_db_name = $db['database_name']; // default database data
// @end
$uname= ""; // default username

// Default Banner Size
$wx = 189;
$hx = 120;
// Banner Base Directory
$bimgpath = "bimg/";
//ที่เก็บรูป icon ต่างๆ ที่ใช้ใน Reportbuilder
$imgpath = "img/";
//ที่เก็บ report.inc.php
$report_inc_path = "";
   
//$css_path = "../../common/";   //ที่เก็บreport.css ใช้กับ poc
$css_path = "";   //ที่เก็บreport.css


if (!isset($notconnect)){
	@mysql_connect($hostname,$db_username,$db_password) or die("Cannot connect to Database Server.".$db_name);
	@mysql_select_db($db_name) or die("Cannot connect to Database.");
	//$iresult = mysql_query("SET character_set_results=tis-620");
	//$iresult = mysql_query("SET NAMES TIS620");  utf8
	  mysql_query("SET NAMES TIS620");
	  mysql_query("SET character_set_results=TIS620");
      mysql_query("SET character_set_client=TIS620");
      mysql_query("SET character_set_connection=TIS620");
	  mysql_query("collation_connection = tis620_thai_ci");
      mysql_query("collation_database = tis620_thai_ci");
      mysql_query("collation_server = tis620_thai_ci");
	  $notconnect = "connect";
      //aongtong
	  //$result = mysql_query($query);
}

function GetCellProperty($id,$sec1,$cellno){
	global $uname;
	$result = mysql_query("select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec1' and cellno='$cellno';");
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$prop = "";
		if (isset($rs['alignment'])){
			$prop .= " align='$rs[alignment]' ";
		}

		if (isset($rs['valign'])){
			$prop .= " valign='$rs[valign]' ";
		}
		// @modify Phada Woodtikarn 18/08/2014 เพิ่ม bgcolor_type สำหรับ information port
		if (isset($rs['bgcolor'])){
			if($sec1 == 'I'){
				$value = getStyleBG($rs['bgcolor']);
				if($value['type'] == 0){
					$prop .= ' bgcolor="'.$value['bg'].'" ';
				}else{
					$prop .= ' bgcolor="'.$value['bg'][0].'" ';
				}
			}else{
				$prop .= " bgcolor='$rs[bgcolor]' ";
			}
		}
		// @end
		if (isset($rs['width'])){
			$prop .= " width='$rs[width]' ";
		}

		return $prop;

	}else{
		return "";
	}
}

function GetCellValue($id,$sec1,$cellno){
	global $uname;
	$result = mysql_query("select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec1' and cellno='$cellno';");
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$val1 = $rs['caption'];

		if ($rs['celltype'] == 1){
			$val1 .= " [db] ";
		}else if ($rs['celltype'] == 2){
			$val1 .= " [fld] ";
		}else if ($rs['celltype'] == 3){
			$val1 .= " [fn] ";
		}else if ($rs['celltype'] == 4){
			$val1 .= " [cal] ";
		}else if ($rs['celltype'] == 5){
			$val1 .= $rs['cond'];
		}

		if (isset($rs['font'])){
			$val1 = "<span style='$rs[font]'>$val1</span>";
		}

		if (isset($rs['url'])){
			$val1 = "<a href='$rs[url]' target='_blank'>$val1</a>";
		}
		
		return $val1;

	}else{
		return "&nbsp;";
	}
}

function DB2Array($arrayname,$sql){
	$s = "\$$arrayname  = array(";
	$result = mysql_query($sql);
	$i = 0;
	$firstrow = true;
	while ($rs = mysql_fetch_assoc($result)){
		if ($firstrow){
			$firstrow = false;
		}else{
			$s .= ",";
		}

		$firstcol = true;
		$s .= "$i => array(";
		foreach($rs as $key => $value){
			if ($firstcol){
				$firstcol = false;
			}else{
				$s .= ", ";
			}
			$s .= "\"$key\"=>\"" . $value . "\"";
		}
		$s .= ")";

		$i++;
	}

	$s .= ");";

	return $s;
}


function DB2ArrayExport($arrayname,$sql){
	$s = "\$$arrayname  = array(";
	$result = mysql_query($sql);
	$i = 0;
	$firstrow = true;
	while ($rs = mysql_fetch_assoc($result)){
		if ($firstrow){
			$firstrow = false;
		}else{
			$s .= ",";
		}

		$firstcol = true;
		$s .= "$i => array(";
		foreach($rs as $key => $value){
			if ($firstcol){
				$firstcol = false;
			}else{
				$s .= ", ";
			}
			$s .= "\"$key\"=>\"" . htmlspecialchars($value) . "\"";
		}
		$s .= ")";

		$i++;
	}

	$s .= ");";

	return $s;
}
// @modify Phada Woodtikarn 04/08/2014 เพิ่ม มิติ array ให้เก็บ sec นำหน้า เวลาวนloop หาจะได้ไม่หาทุกตัว
function ChangeArrayCellinfo($getarray){
	$e = 0;
	$h = 0;
	$i = 0;
	$f = 0;
	$newarray = array();
	if(is_array($getarray)){
		foreach($getarray as $key => $value){
			if($value['sec'] == 'E'){
				$newarray['E'][$e] = $value;
				$e++;
			}else if($value['sec'] == 'H'){
				$newarray['H'][$h] = $value;
				$h++;
			}else if($value['sec'] == 'I'){
				$newarray['I'][$i] = $value;
				$i++;
			}else if($value['sec'] == 'F'){
				$newarray['F'][$f] = $value;
				$f++;
			}
		}
		return $newarray;
	}else{
		return NULL;
	}
}
// @end
function canSetWidth(){ // ตรวจสอบว่า ฐานข้อมูลรองรับการแก้ไข Column Width หรือไม่
	$result = @mysql_query("select cwidth1,cwidth2,cwidth3,cwidth4 from reportinfo limit 1");
	if ($result && mysql_errno() == 0){
		return true; // can set width
	}else{
		return false; //cannot set width
	}
}

function GetColumnWidth($rid,$sec,$cellno){
	global $uname;
	$x = explode(".",$cellno);
	$col = $x[1];

	// H,E,I,F
	if ($sec == "H"){
		$sql = "select cwidth1 from reportinfo where rid='$rid' and uname='$uname';";
	}else if ($sec == "E"){
		$sql = "select cwidth2 from reportinfo where rid='$rid' and uname='$uname';";
	}else if ($sec == "I"){
		$sql = "select cwidth3 from reportinfo where rid='$rid' and uname='$uname';";
	}else {
		$sql = "select cwidth4 from reportinfo where rid='$rid' and uname='$uname';";
	}

	$cwidth = "";

	$result = @mysql_query($sql);
	if ($result){
		$rs = mysql_fetch_array($result);
		$x=explode("|",$rs[0]); //แต่ละ column คั่นด้วย |
		if(isset($x[$col - 1])){
			$cwidth = $x[$col - 1]; // เอาเฉพาะตัวที่กำหนดจากค่าตัวหลังของ cellno
		}else{
			$cwidth = "";	
		}
	}

	return htmlspecialchars($cwidth);
}

function SetColumnWidth($rid,$sec,$cellno,$cwidth){
	global $uname;
	$x = explode(".",$cellno);
	$col = $x[1];

	$cwidth = str_replace("|","",$cwidth);  //กำจัดเครื่องหมาย | (ถ้ามี)

	// H,E,I,F
	if ($sec == "H"){
		$sql = "select cwidth1 from reportinfo where rid='$rid' and uname='$uname';";
	}else if ($sec == "E"){
		$sql = "select cwidth2 from reportinfo where rid='$rid' and uname='$uname';";
	}else if ($sec == "I"){
		$sql = "select cwidth3 from reportinfo where rid='$rid' and uname='$uname';";
	}else {
		$sql = "select cwidth4 from reportinfo where rid='$rid' and uname='$uname';";
	}

	$result = @mysql_query($sql);
	if ($result){
		$rs = mysql_fetch_array($result);
		$x=explode("|",$rs[0]); //แต่ละ column คั่นด้วย |

		//สำหรับอันที่ไม่เคยได้ทำถึงอันนี้
		for ($i=0;$i<$col-1;$i++){
			if (!isset($x[$i])){
				$x[$i] = "";
			}
		}

		$x[$col - 1] = $cwidth;  
		$columnwidth = implode("|",$x); //จับมารวมกัน
	}else{ // ยังไม่มีการกำหนดค่า
		$columnwidth = "";
		for ($i=0;$i<$col-1;$i++){
			$columnwidth .= "|";
		}
		$columnwidth .= "$cwidth|";
	}


	// H,E,I,F
	if ($sec == "H"){
		$sql = "update reportinfo set cwidth1='$columnwidth' where rid='$rid' and uname='$uname';";
	}else if ($sec == "E"){
		$sql = "update reportinfo set cwidth2='$columnwidth' where rid='$rid' and uname='$uname';";
	}else if ($sec == "I"){
		$sql = "update reportinfo set cwidth3='$columnwidth' where rid='$rid' and uname='$uname';";
	}else {
		$sql = "update reportinfo set cwidth4='$columnwidth' where rid='$rid' and uname='$uname';";
	}

	@mysql_query($sql);

}
// @modify Phada Woodtikarn 30/07/2014 function สำหรับเขียนstyle ให้ ปุ่่ม pagination
function getStylePagination($style){
	$value = explode('|',$style);
	$name = array('FontColorA'=>'#333333',
				'BGColorA'=>'#fbfcfe',
				'BGColor2A'=>'#ededed',
				'BorderColorA'=>'#cacaca',
				'FontColorO'=>'#ffffff',
				'BGColorO'=>'#585858',
				'BGColor2O'=>'#111111',
				'BorderColorO'=>'#111111',
				'FontColorFA'=>'#000',
				'FontColorFD'=>'#666');
	$i = 0;
	foreach($name as $getname=>$defalut){
		if(!isset($value[$i]) || $value[$i] == ''){
			$result[$getname] = $defalut;
		}else{
			$result[$getname] = $value[$i];
		}
		$i++;
	}
	return $result;
}
// @end
// @modify Phada Woodtikarn 31/07/2014 function สำหรับเขียนstyle ให้ หน้ารายงาน
// @modify Phada Woodtikarn 08/09/2014 เพิ่ม dateOfData และส่วนของ ข้อมูล ณ วันที่
function getStylePreview($style, $dateOfData = ''){
	$value = explode('|',$style);
	$name = array('FontNameCo'=>'Verdana',
				'FontColorCo'=>'#000000',
				'FontSizeCo'=>'12',
				'ZoomCo'=>'true',
				'FontColorCa'=>'#000000',
				'FontSizeCa'=>'18',
				'FontColorEx'=>'#000000',
				'FontSizeEx'=>'14',
				'VisibleEx'=>'true',
				'TypeEx'=>'normal',
				'StyleEx'=>'fade',
				'FontColorRA'=>'#000000',
				'FontSizeRA'=>'14',
				'VisibleRA'=>'true',
				'FontSizeRC'=>'12',
				'VisibleRC'=>'true',
				'FontColorL'=>'#000000',
				'TextDecorationL'=>'underline',
				'FontColorLO'=>'#f3960b',
				'TextDecorationLO'=>'underline',
				'ExportCo'=>'false',
				'FontColorDA'=>'#000000',
				'FontSizeDA'=>'14',
				'VisibleDA'=>'false',
				'SQLDA'=>'',
				'WidthPU'=>'75%',
				'HeightPU'=>'auto',
				'TopPU'=>'auto',
				'PDFCo'=>'false');
	$i = 0;
	foreach($name as $getname => $defalut){
		if($getname == 'SQLDA'){
			$result[$getname] = $dateOfData;
		}else if(!isset($value[$i]) || $value[$i] == ''){
			$result[$getname] = $defalut;
		}else{
			$result[$getname] = $value[$i];
		}
		$i++;
	}
	return $result;
}
// @end
// @end
// @modify Phada Woodtikarn 05/08/2014 function สำหรับ การconfig size รูป
function ChangeSizeImage($path,$newwidth,$newheight){
	if(is_file($path)){
		if($newwidth < 10){
			$newwidth = 10;
		}
		if($newheight < 10){
			$newheight = 10;
		}
		list($width, $height) = getimagesize($path);
		$a = $width/$height;
		$b = $newwidth/$newheight;
		if($a >= $b){
			$img = '<img src="'.$path.'" alt="Banner" border="0" style="width:'.$newwidth.'px;height:auto;">';
		}else{
			$img = '<img src="'.$path.'" alt="Banner" border="0" style="width:auto;height:'.$newheight.'px;">';
		}
		$img = '<div style="width:'.$newwidth.'px;height:'.$newheight.'px;display:table-cell;vertical-align:middle;text-align:center;">'.$img.'</div>';
		$img = '<div style="width:'.$newwidth.'px;height:'.$newheight.'px;">'.$img.'</div>';
		return $img;
	}
	return NULL;
}
// @end
// @modify Phada Woodtikarn 19/08/2014
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb;
}
// @end
// @modify Phada Woodtikarn 18/08/2014 เพิ่ม bgcolor_type	
function getStyleBG($bg){
	$value = explode('|',$bg);
	$count = count($value);
	if($count == 1){
		$reval['type'] = '0';
		$reval['bg'] = $value[0];	
	}else{
		$i = 0;
		foreach($value as $key => $getval){
			if($key == 0){
				$reval['type'] = $getval;	
			}else if($key < $count-1){
				if($key % 3 == 1){
					if(!isset($getval)){
						$reval['bg'][$i] = '#F00';
					}else{
						$reval['bg'][$i] = $getval;
					}
				}else if($key % 3 == 2){
					if(!isset($getval)){
						$reval['start'][$i] = 0;
					}else{
						$reval['start'][$i] = $getval;
					}
				}else{
					if(!isset($getval)){
						$reval['end'][$i] = 100;
					}else{
						$reval['end'][$i] = $getval;
					}
					$i++;
				}
			}
		}
	}
	return $reval;
}
function getBG($style,$value){
	$val = '';
	if($style['type'] == 1 && is_numeric($value)){
		foreach($style['bg'] as $key => $getval){
			if($value >= $style['start'][$key] && $value <= $style['end'][$key]){
				$val = $getval;
				return $val;
			}
		}
	}else  if($style['type'] == 2 && is_numeric($value)){
		foreach($style['bg'] as $key => $getval){
			if($value >= $style['start'][$key] && $value <= $style['end'][$key]){
				$len = $style['end'][$key] - $style['start'][$key];
				if($len == 0){
					$val = $getval;
				}else{
					$opacity = round($value/$len,2);
					$rgb = hex2rgb($getval);
					$val = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$opacity.')';
				}
				return $val;
			}
		}
	}else{
		if(isset($style['bg']) && !is_array($style['bg'])){
			$val = $style['bg'];
		}else if(isset($style['bg'][0]) && !is_array($style['bg'][0])){
			$val = $style['bg'][0];
		}
	}
	return $val;
}
// @end
?>