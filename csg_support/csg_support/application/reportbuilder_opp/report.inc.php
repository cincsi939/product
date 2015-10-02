<?php
/**
 * @comment 	หน้าออก report
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: แกนของการแสดงผลรายงาน
Version			: 2.0
Last Modified	: 23/10/2548
Changes		:
	28/7/2548 - ไม่ต้องนำค่า Caption ของรายงานมาแสดงในส่วน Exec. Sum.
					- แก้ไขเรื่องรูปแบนเนอร์โดนบีบแม้ไม่ stretch
					- เพิ่มลำดับหัวข้อ
					- จัดการเส้นบรรทัดด้านบนของ Table Header
	6/8/2548	- แก้ไขให้ print เส้นตารางได้ด้วย
					- จัดการ Link ข้าม Report
					- รูปที่ Stretch เปลี่ยนเป็นขนาด 189 * 120
					- ปีอิสระ ปีด้านขวา ต้องมากกว่าด้านซ้าย
					- #diff# จัดรูปแบบตามที่กำหนด
	8/8/2548	- เพิ่มข้อมูลแบบ Function ให้ไปดึงข้อมูลจาก URL ได้
	23/10/2548- แก้กรอบตารางให้สวยงาม
					- เพิ่ม พารามีเตอร์ #pv1# - #pv4# โดยเอาค่าจาก $pvcode[] มาใส่
					- มี pre-execute include file (เพิ่ม field 'pinclude' แบบ text ในตาราง reportinfo) โดยเชคว่าชื่อ ตารางคือ tmp_report หรือไม่
#
# โครงสร้างตาราง `tmp_report`
#

CREATE TABLE `tmp_report` (
  `pvcode` char(2) NOT NULL default '',
  `yy` smallint(5) unsigned NOT NULL default '0',
  `id` varchar(10) NOT NULL default '',
  `caption` varchar(255) NOT NULL default '',
  `val1` double NOT NULL default '0',
  `val2` double NOT NULL default '0',
  `val3` double NOT NULL default '0',
  `val4` double NOT NULL default '0',
  `total` double NOT NULL default '0'
) TYPE=MyISAM;

	24/10/2548 - เพิ่ม parameter #total# แทนค่าผลรวมแนวนอน (แถวเดียวกัน)
	26/11/2548 - เพิ่มให้ใช้ parameter rtype=compare
	12/12/2548 - เพิ่มส่วน sorting หากระบุ skey

	28/12/2548 - กำนหดความกว้างของ column ได้ (เฉพาะใน Footer) 
					  - ใช้ได้กับ Database ที่แก้ reportinfo ให้มี cwidth1,cwidth2,cwidth3,cwidth4 เท่านั้น
	13/1/2549	 - ใส่ค่าของ param0 - param5 ในเวลาเลื่อนปี
	26/1/2549	 - แก้ไขให้ส่วนของ [cond] ใช้ special Parameter ได้

	5/1/2549	- แก้ลำดับจังหวัด จาก (จันทบุรี / ชลบุรี / ตราด / ระยอง) มาเป็น (ชลบุรี / ระยอง / จันทบุรี / ตราด)
	4/2/2549	- แก้บรรทัด 290 ให้แทรก "" ก่อนหน้าค่าตัวเลขที่จะแทนที่ #diff#
	13/2/2549 - แก้ปัญหาที่หาปี - 1
	13/2/2549 - ใช้ #fld:fieldname# สำหรับอิงข้อมูลใน field ของตารางที่เป็น Key Table ใช้ได้ใน Information port เท่านั้น
	17/2/2549 - แก้ไข column แสดงไม่ถูกต้องหากมี หลาย parameter
	17/2/2549 - แก้ไข ผลต่างการเปรียบเทียบ

	25/2/2549 - เพิ่ม link ให้ขยายส่วน executive summary  ได้
	9/3/2549	- จัดให้มีรายงานแบบ compare และ ปกติในหน้าเดียวกัน 
	23/3/2549	- แก้ไข กรณีที่ระบุ $_GET[rtype] ให้ override เป็น rtype=2 (compare w/out diff)
	25/3/2549 - แก้ไขปัญหาการแสดงผลที่ Executive Summary ของ Flash ผิดพลาด
	11/4/2549 - แก้ field แบบ function ให้ใช้ relative path ได้
					- เพิ่ม Report แบบ Redirect
	17/4/2549 - แก้ไขเรื่องของการแสดงผลการ sort ให้ click mี่ icon แทน
	// @modify Phada Woodtikarn 25/06/2556
	24/06/2557 - เพิ่มให้ header ตารางแบบเปรียบเทียบ แสดงตัวแปรแบบเปรียบเทียบได้
	25/06/2557 - ให้การรับ parameter ลบปีได้ -543 +543
	26/06/2557 - เพิ่ม rtype = 3 จะไม่มี หัวตาราง information ที่เป็น parameter
	19/06/2557 - เพิ่ม pagination
	// @end
*****************************************************************************/
//ini_set("display_errors","1");
ob_start(); 
//require_once "report.db.inc.php";
//require_once "common/class_create_temp.php";
//$user = "cmss201";  
//$module_code = 'RPT02';

/*$param = $_GET['param0'].$_GET['param1'].$_GET['param2'].$_GET['param3'].$_GET['param4'].$_GET['param5'].$_GET['skey'].$_GET['rtype'].$_GET['yy'].$_GET['yy_x'].$_GET['key'].$_GET['key'].$_GET['t1_id'].$_GET['t2_id'];
$xlinkpara = "edit2$module_code".$_GET['id'].$param;  
$xfile = "$module_code$xlinkpara$user";

$Contents = new Get_Contents("","report_temp/", "$xfile"); 
$Contents->CurrentFile = "index.php";
if($Contents->Contents != ""){
 	echo $Contents->Contents ; 
 	exit;
}*/
include('common/function.php');
/*if (isset($prov_name)){
	echo " <B>จังหวัด $prov_name</B><br>";
}*/
//echo "$dbname";
//$pvcode = array('','22','20','23','21'); // รหัสจังหวัด (เริ่มจาก 1) / จันทบุรี / ชลบุรี / ตราด / ระยอง เรียงตามตัวอักษร
$pvcode = array('','20','21','22','23'); // รหัสจังหวัด (เริ่มจาก 1) / ชลบุรี / ระยอง / จันทบุรี / ตราด => 5/1/2549

// ----------------------------------------------------------------------- get json -----------------------------------------------------------------
// @modify Phada Woodtikarn 26/06/2014 แก้ไขให้การให้ฟังชั่น SQL set สามารถรับ param ได้
// @modify Phada Woodtikarn 11/09/2014 เพิ่ม Parameter return SQL
function GetJSON($sec = '',$m = 0,$returnSQL = ''){ //$sec ถ้าไม่กำหนดตัวแปรจะหาทั้งหมดยกเว้นตาราง information, $m คือการเปรียบเทียบ
// @end
	global $db_name,$id;
	if($sec == ''){
		$report = "SELECT * FROM ".$db_name.".report_sqldata WHERE rid='".$id."' AND sec != 'I'";
	}else{
		$report = "SELECT * FROM ".$db_name.".report_sqldata WHERE rid='".$id."' AND sec='".$sec."'";
	}
	$rRow = mysql_query($report);
	$json = '';
	if($rRow){
		while ($row = mysql_fetch_array($rRow, MYSQL_ASSOC))
		{	
			$rSql = $row['sqlname'];
			if ($m == 0){ // รอบแรก หรือ ไม่ได้เป็นรายงานที่เปรียบเทียบ
				$rQuery = ReplaceParam($row['query']);
			}else{
				$rQuery = ReplaceXParam($row['query']);
			}
			if(isset($_GET['debug']) && $rQuery != ''){
				if($sec == 'I'){
					echo 'Information SQL-Set: '.$rQuery . '<br>';
				}else{
					echo 'Executive SQL-Set: '.$rQuery . '<br>';
				}
			}
			// @modify Phada Woodtikarn 11/09/2014
			if($returnSQL == 'true'){
				$json[$rSql] = $rQuery;
			}else{
			// @end
				$result = mysql_query($rQuery);
				$i=0;
				if($result){
					while ($rs = mysql_fetch_array($result,MYSQL_NUM))
					{	
						for($j=0; $j<count($rs); $j++){
							$json[$rSql][$i][$j] = $rs[$j];
						}
						$i++;
					}
				}
			}
		}
	}
	return $json;
}
// @end
// @modify Phada Woodtikarn 11/09/2014 Function Query SQL set
function GetResultJSON($sql,$keyword = ''){
	$json = '';
	if(is_array($sql)){
		foreach($sql as $key => $value):
			$value = str_replace('#key#',$keyword,$value).' LIMIT 1';
			$result = mysql_query($value);
			$i=0;
			if($result){
				while($rs = mysql_fetch_array($result,MYSQL_NUM)){	
					for($j=0; $j<count($rs); $j++){
						$json[$key][$i][$j] = $rs[$j];
					}
					$i++;
				}
			}
		endforeach;
	}
	return $json;
}
// @end
// --------------------------------------------------------------------------------------------------------------------------------------------------
function ReportGetColumnWidth($rid,$sec,$cellno){
	global $rs;
	$x = explode('.',$cellno);
	$col = $x[1];

	// H,E,I,F
	if($sec == 'H'){
		$xwidth = $rs['cwidth1'];
	}else if ($sec == 'E'){
		$xwidth = $rs['cwidth2'];
	}else if ($sec == 'I'){
		$xwidth = $rs['cwidth3'];
	}else {
		$xwidth = $rs['cwidth4'];
	}

	$cwidth = '';
	$x=explode('|',$xwidth); //แต่ละ column คั่นด้วย |
	if(isset($x[$col - 1])){
		$cwidth = $x[$col - 1]; // เอาเฉพาะตัวที่กำหนดจากค่าตัวหลังของ cellno
	}

	return htmlspecialchars($cwidth);
}
function GetParamCondition($sql){
	global $param,$paramname,$paramdefault,$paramfield;
	$paramcond='';
	if($param > 0){
		for($i=1;$i<=$param;$i++){ //เริ่มจาก 1
			$xfld = explode(".",$paramfield[$i]);
			if($xfld[0] != ""){ // เข้า function เมื่อมีค่า
				if(stristr($sql,$xfld[0])){   //หาดูว่า มี table.field ของ parameter ใน sql นี้หรือไม่
					if ($paramcond != '') $paramcond .= ' and ';
					$paramcond .= "(" . $paramfield[$i] . " = '" . $paramdefault[$i] . "')";
				}
			}
		}
	}
	return $paramcond;
}

function GetQueryValue($sql){
	$result = mysql_query($sql);
	if($result){
		$count=mysql_num_rows($result);
		$rs=mysql_fetch_array($result,MYSQL_NUM);
		if($count == 1){
			return $rs[0];
		}else{
			return $count;
		}
	}else{
		return NULL;
	}
}
// @modify Phada Woodtikarn 27/06/2014 function สำหรับหา keywords function find_keywords(คำที่ต้องการหา,ข้อความ)
function find_keywords($keywords, $text) {
	$found = strpos($text, $keywords);
	if($found !== false){
		return true;
	}else{
		return false;	
	}
}
// @end
// @modify Phada Woodtikarn 28/03/2015 funcion สำหรับ replace &nbsp; to margin
function ReplaceSpace($text,$time = 0){
	$text = trim($text);
	$tmpText = substr($text,0,6);
	$found = find_keywords('&nbsp;',$tmpText);
	$repace['text'] = $text;
	$repace['margin'] = $time * 5;
	if($found == true){
		$time++;
		$text = substr($text,6);
		$repace = ReplaceSpace($text,$time);
	}
	
	$repace['text'] = $repace['text'];
	$repace['margin'] = $repace['margin'];
	if($repace['margin'] == 0){
		$repace = false;
	}
	return $repace;
}
// @end
function ReplaceParamOLD($s){
	global $param,$paramname,$paramdefault,$paramcomment;
	for($i=1;$i<=$param;$i++){ //start from 1
		$s = str_replace("#" . $paramname[$i] . "#",$paramcomment[$i] . " " . $paramdefault[$i],$s);
		$s = str_replace("#" . $paramname[$i] . "-1#",$paramcomment[$i] . " " . intval($paramdefault[$i]) - 1,$s);
		$s = str_replace("#" . $paramname[$i] . "+1#",$paramcomment[$i] . " " . intval($paramdefault[$i]) + 1,$s);
	}
	return $s;
}

function ReplaceParam($s){
	global $param,$paramname,$paramdefault,$paramcomment,$xparamdefault,$pvcode,$imgpath;
	for($i=1;$i<=$param;$i++){ //start from 1
		// @modify Phada Woodtikarn 27/06/2014 เนื่องจากมี str_replace เยอะเกิน เกรงว่าจะช้า เลยให้หา ก่อนว่ามี ตัวที่จะ replace มั้ย
		$find_param = find_keywords("#".$paramname[$i],$s);
		if($find_param == true){
			$s = str_replace("#" . $paramname[$i] . "#", $paramdefault[$i],$s);
			$s = str_replace("#" . $paramname[$i] . "-2#",intval($paramdefault[$i]) - 2,$s);
			$s = str_replace("#" . $paramname[$i] . "-1#",intval($paramdefault[$i]) - 1,$s);
			$s = str_replace("#" . $paramname[$i] . "+1#",intval($paramdefault[$i]) + 1,$s);
			$s = str_replace("#" . $paramname[$i] . "+2#",intval($paramdefault[$i]) + 2,$s);
			$find_param = find_keywords("#".$paramname[$i]."_x",$s);
			if($find_param == true){
				$s = str_replace("#" . $paramname[$i] . "_x#", $xparamdefault[$i],$s);
				$s = str_replace("#" . $paramname[$i] . "_x-1#",intval($xparamdefault[$i]) - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "_x+1#",intval($xparamdefault[$i]) + 1,$s);
			}
			$find_param = find_keywords("#".$paramname[$i]."-543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 เพิ่มเงื่อนไขปี
				$s = str_replace("#" . $paramname[$i] . "-543#", intval($paramdefault[$i]) - 543,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-2#",intval($paramdefault[$i]) - 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-1#",intval($paramdefault[$i]) - 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+1#",intval($paramdefault[$i]) - 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+2#",intval($paramdefault[$i]) - 543 + 2,$s);
				// @end
			}
			$find_param = find_keywords("#".$paramname[$i]."+543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 เพิ่มเงื่อนไขปี
				$s = str_replace("#" . $paramname[$i] . "+543#", intval($paramdefault[$i]) + 543 ,$s);
				$s = str_replace("#" . $paramname[$i] . "+543-2#",intval($paramdefault[$i]) + 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "+543-1#",intval($paramdefault[$i]) + 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "+543+1#",intval($paramdefault[$i]) + 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "+543+2#",intval($paramdefault[$i]) + 543 + 2,$s);
				// @end
			}
		}
		// @end
	}
	$s = str_replace('#space#', '<img src="'.$imgpath.'space.png" border="0">',$s); 
	$s = ReplaceURLParam($s);
	// แทนค่ารหัสจังหวัด โดยต้องระบุค่าในตัวแปรอะเรย์ $pvcode
	for($n=1;$n<=4;$n++){
		if (stristr($s,"#pv$n#")){  // รหัสจังหวัดที่ n
			$s = str_replace("#pv$n#", $pvcode[$n],$s);
		}
	}
	return $s;
}

function ReplaceXParam($s){ // สำหรับคอลัมที่เปรียบเทียบ
	global $param,$paramname,$xparamdefault,$paramcomment;
	for($i=1;$i<=$param;$i++){ //start from 1
		// @modify Phada Woodtikarn 27/06/2014 เนื่องจากมี str_replace เยอะเกิน เกรงว่าจะช้า เลยให้หา ก่อนว่ามี ตัวที่จะ replace มั้ย
		$find_param = find_keywords("#".$paramname[$i],$s);
		if($find_param == true){
			$s = str_replace("#" . $paramname[$i] . "#", $xparamdefault[$i],$s);
			$s = str_replace("#" . $paramname[$i] . "-1#",intval($xparamdefault[$i]) - 1,$s);
			$s = str_replace("#" . $paramname[$i] . "+1#",intval($xparamdefault[$i]) + 1,$s);
			$find_param = find_keywords("#".$paramname[$i]."_x",$s);
			if($find_param == true){
				$s = str_replace("#" . $paramname[$i] . "_x#", $xparamdefault[$i],$s);
				$s = str_replace("#" . $paramname[$i] . "_x-1#",intval($xparamdefault[$i]) - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "_x+1#",intval($xparamdefault[$i]) + 1,$s);
			}
			$find_param = find_keywords("#".$paramname[$i]."-543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 เพิ่มเงื่อนไขปี
				$s = str_replace("#" . $paramname[$i] . "-543#", intval($xparamdefault[$i]) - 543,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-2#",intval($xparamdefault[$i]) - 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-1#",intval($xparamdefault[$i]) - 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+1#",intval($xparamdefault[$i]) - 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+2#",intval($xparamdefault[$i]) - 543 + 2,$s);
				// @end
			}
			$find_param = find_keywords("#".$paramname[$i]."+543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 เพิ่มเงื่อนไขปี
				$s = str_replace("#" . $paramname[$i] . "+543#", intval($xparamdefault[$i]) + 543 ,$s);
				$s = str_replace("#" . $paramname[$i] . "+543-2#",intval($xparamdefault[$i]) + 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "+543-1#",intval($xparamdefault[$i]) + 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "+543+1#",intval($xparamdefault[$i]) + 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "+543+2#",intval($xparamdefault[$i]) + 543 + 2,$s);
				// @end
			}
		}
		// @end
	}
	return $s;
}

function SetDecimal($val,$dec){
	if ($dec == 1){ // 00
		$val = number_format($val,2,".",",");
	}else if ($dec == 2){ // 000
		$val = number_format($val,3,".",",");
	}else if ($dec == 3){ // None
		$val = number_format($val,0,".",",");
	}
	return $val;
}
// @modify Phada Woodtikarn 13/08/2014 เพิ่ม blank value
function SetNumberFormat($val,$nformat,$dec,$nblank = 0){
	if($nblank == 1){
		$blank = 'N/A';	
	}else if($nblank == 2){
		$blank = '-';	
	}else if($nblank == 3){
		$blank = '0';	
	}else if($nblank == 4){
		$blank = 'NULL';	
	}else if($nblank == 5){
		$blank = ' ';	
	}else{
		$blank = '';	
	}
	if($nformat == 0){ //NATUARAL
		if (is_null($val) || $val == ""){
			if($nblank == 0){
				$val = '<font color="#666666">N/A</font>';
			}else{
				$val = $blank;
			}
		}else if (is_numeric($val)){
			$val = SetDecimal($val,$dec);
		}
	}else if($nformat == 1){ // NORMAL
		if ($val < 0){  // Negative
			$val = '<font color="RED">'.SetDecimal($val,$dec).'</font>';
		}else if ($val == 0){
			$val = '<font color="BLACK">'.SetDecimal($val,$dec).'</font>';
		}else if (is_null($val) || $val == ""){
			if($nblank == 0){
				$val = '<font color="BLACK">0</font>';
			}else{
				$val = $blank;
			}
		}else{ // > 0
			$val = '<font color="BLUE">'.SetDecimal($val,$dec).'</font>';
		}
	}else if($nformat == 2){ //INVERT
		if ($val < 0){  // Negative
			$val = '<font color="BLUE">'.SetDecimal($val,$dec).'</font>';
		}else if ($val == 0){
			$val = '<font color="BLACK">'.SetDecimal($val,$dec).'</font>';
		}else if (is_null($val) || $val == ""){
			if($nblank == 0){
				$val = '<font color="BLACK">0</font>';
			}else{
				$val = $blank;
			}
		}else{ // > 0
			$val = '<font color="RED">'.SetDecimal($val,$dec).'</font>';
		}
	// @modify Phada Woodtikarn 25/06/2014 format date thai
	}else if($nformat == 3){ //format date thai Short
		if(strlen($val) < 10 || $val == '0000-00-00' || $val == ""){
			if($nblank == 0){
				$val = '<font color="#666666">N/A</font>';
			}else{
				$val = $blank;
			}
		}else{
			$val = date_eng2thai($val,543,'S','S');
		}
	}else if ($nformat == 4){ //format date thai Full
		if(strlen($val) < 10 ||  $val == '0000-00-00' || $val == ""){
			if($nblank == 0){
				$val = '<font color="#666666">N/A</font>';
			}else{
				$val = $blank;
			}
		}else{
			$val = date_eng2thai($val,543);
		}
	// @end
	// @modify Phada Woodtikarn 28/06/2014 อายุกี่ปีกี่เดือน
	}else if($nformat == 5){ //format อายุกี่ปีกี่เดือน
		if(strlen($val) < 10 ||  $val == '0000-00-00' || $val == ""){
			if($nblank == 0){
				$val = '<font color="#666666">N/A</font>';
			}else{
				$val = $blank;
			}
		}else{
			$val = age_yy_mm($val);
		}
	// @end
	// @modify Phada Woodtikarn 30/09/2014 ซ่อนข้อมูล
	}else if($nformat == 6){ //format ซ่อนข้อมูล
		global $hideValue;
		if($val == ''){
			if($nblank == 0){
				$val = '<font color="#666666">N/A</font>';
			}else{
				$val = $blank;
			}		
		}else if($hideValue == true){
			$len = strlen($val);
			if($len > 3){
				$x = str_repeat('X', $len - 3);
				$val = substr($val,0,3).$x;
			}
		}
	// @end
	}else{
		$val = $blank;
	}
	return $val;
	//return $nformat.' '.$nblank;
}
// @end
// @modify Phada Woodtikarn 04/08/2014 เปลี่ยน for เป็น foreach และจัด array ใหม่ เพื่อเพิ่มประสิทธิภาพ
function SearchCellInfo($sec,$cellno){
	global $cellinfo;
	if(isset($cellinfo[$sec])){
		foreach($cellinfo[$sec] as $key => $value){
			if($value['cellno'] == $cellno && strlen($value['cellno']) == strlen($cellno)){
				return $value;
			}
		}
	}
	return NULL;
}

function GetCellProperty2($id,$sec1,$cellno,$val = 0){
	global $trInfo;
	$rs = SearchCellInfo($sec1,$cellno);
	// @modify Phada Woodtiakrn 04/08/2014 เปลี่ยน $prop เป็น array เพราะจะแยก style
	$prop = array();
	$prop[0] = NULL;
	$prop[1] = NULL;
	// @end
	if(isset($rs)){
		$prop[0] = " ";
		if(isset($rs['alignment'])){
			$prop[0] .= 'align="'.$rs['alignment'].'" ';
		}

		if(isset($rs['valign'])){
			$prop[0] .= 'valign="'.$rs['valign'].'" ';
		}

		if(isset($rs['width'])){
			$prop[0] .= 'width="'.$rs['width'].'" ';
		}
		// @modify Phada Woodtikarn 19/07/2014 เปลี่ยนมาเขียนใน style เอา
		if(isset($rs['bgcolor'])){
			// @modify Phada Woodtikarn 18/08/2014 เพิ่ม bgcolor_type สำหรับ information port
			if($sec1 == 'I'){
				$styleBG = getStyleBG($rs['bgcolor']);
				if($styleBG['type'] == 0){
					$prop[1] = 'background-color:'.$styleBG['bg'].';';
				}else{
					$value = getBG($styleBG,$val);
					$prop[1] = 'background-color:'.$value.';';
					if($styleBG['type'] == 2 && $trInfo['status'] == false){
						$trInfo['status'] = true;
					}
				}
			}else{
				$prop[1] = 'background-color:'.$rs['bgcolor'].';';
				//$prop .= 'bgcolor"'.$rs['bgcolor'].'" ';
			}
			// @end;
		}
		// @end
		return $prop;
	}else{
		return $prop;
	}
}

function ReplaceURLParam($s){ 
	for($i=0;$i<=5;$i++){
		if (stristr($s,"#param$i#")){  // Parameter ที่ส่งมาจากไฟล์อื่น
			$s = str_replace("#param$i#", $_GET["param$i"],$s);
		}
		if (stristr($s,"#param$i-543#")){  // Parameter ที่ส่งมาจากไฟล์อื่น
			$s = str_replace("#param$i-543#", (intval($_GET["param$i"])-543),$s);
		}
	}
	return $s;
}

function ReplaceSpecialParam($s,$n,$nformat=1,$dec=1,$nblank=0){ //executive sum
	global $cvalue,$c,$startj,$imgpath,$cell;
	$s = ReplaceURLParam($s);
	if(stristr($s,"#delta#")){  // เครื่องหมาย 3 เหลี่ยม
		$s = str_replace("#delta#", '<img src="'.$imgpath.'delta.png" border=0>',$s);
	}
	if(stristr($s,"#diff#")){  // Field ที่หาผลต่างของ 2 Field ก่อนนี้
		if($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$n-1])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$n-2])));
			$s = str_replace("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec,$nblank),$s);
		}else{
			$s = str_replace("#diff#", "0",$s);
		}
	}
	if(stristr($s,"#%diff#")){  // Field ที่หา % ผลต่างของ 2 Field ก่อนนี้
		if($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$n-1])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$n-2])));
			if($cvalue[($n-1)] == "0"){
				$s = str_replace("#%diff#", "0",$s); //6/2/2549
			}else if($a == 0 && $b == 0){
				$s = str_replace("#%diff#", "" . SetNumberFormat(0,$nformat,$dec,$nblank),$s);
			}else if($a != 0){
				$xn = @(($a - $b)/$b) * 100.00; 
				$x = SetNumberFormat($xn,$nformat,$dec,$nblank);
				$s = str_replace("#%diff#", "" . $x ,$s);
			}else{
				$s = str_replace("#%diff#", "0",$s);   
			}
		}else{
			$s = str_replace("#%diff#", "0",$s);
		}
	}
	for($i=1;$i<=15;$i++){
		if(stristr($s,"#%diff:$i#")){  // Field ที่หา % ผลต่างของ 2 Field ก่อนนี้
			if($n > 2){	
				$a = floatval(strip_tags(str_replace(",","",$cvalue[$n-1])));
				$b = floatval(strip_tags(str_replace(",","",$cvalue[$n-$i])));
				if($cvalue[($n-1)] == "0"){
					$s = str_replace ("#%diff:$i#", "0",$s); //6/2/2549
				}else if($a == 0 && $b == 0){
					$s = str_replace ("#%diff:$i#", "" . SetNumberFormat(0,$nformat,$dec,$nblank),$s);
				}else if($a != 0){
					$xn = @(($a - $b)/$b) * 100.00; 
					$x = SetNumberFormat($xn,$nformat,$dec,$nblank);
					$s = str_replace ("#%diff:$i#", "" . $x ,$s);
				}else{
					$s = str_replace ("#%diff:$i#", "-100",$s);   
				}
			}else{
				$s = str_replace ("#%diff:$i#", "0",$s);
			}
		}
	}
	//24/10/2548 เพิ่ม #total# หาผลรวมแนวนอน
	if (stristr($s,"#total#")){  // ผลรวมทางแนวนอน (ในแถวเดียวกัน)
		$sum = 0;
		for($j=$startj;$j<=$c;$j++){
			$sum += floatval(strip_tags(str_replace(",","",$cvalue[$j])));
		}
		$total = SetNumberFormat($sum,$nformat,$dec,$nblank);
		$s = str_replace("#total#", $total . "",$s);
	}
	if (stristr($s,"#@")){  // สูตร  #@2.2# +  #@3.2# 	
		preg_match_all("/#@([\w\.]+)*#/", $s, $var1);
		//for ($k=0;$k<=count($var1);$k++){
		$vr = explode("@", $s);
		for($k=0;$k<=count($vr);$k++){
			if(isset($var1[0][$k])){
				$funcname = trim($var1[0][$k]);
			}else{
				$funcname = '';
			}
			if(isset($var1[1][$k])){
				$funcfld = trim($var1[1][$k]);
			}else{
				$funcfld = '';
			}

			if($funcname > ""){
				$f1 = explode(".",$funcfld);
				//	 ส่วนของ caption กับ itemname ใช้เป็น #max::yy#
				$s = str_replace($funcname, "floatval(" . ($cell[$f1[0]][$f1[1]]) . ")",$s );
			}
		}
		// 8/4/2549
		$x = $s;
		// evaluate calculation
		// @modify Phada Woodtikarn 09/10/2014 เพิ่มไม่ให้ tag ที่กำหนด font หาย
		$found = strpos($x,'<span');
		if($found !== false){
			$temp_s = ">".strip_tags($x)."<";
			@eval("\$s = " . strip_tags($x) . ";");
			$s = SetNumberFormat($s,$nformat,$dec,$nblank);
			$s = str_replace($temp_s,">".$s."<",$x);
		}else{
			@eval("\$s = " . strip_tags($x) . ";");
			$s = SetNumberFormat($s,$nformat,$dec,$nblank);
		}
		
		
		// @end
	}
	return $s;
}

function ReplaceSpecialParam2($s,$n,$nformat=1,$dec=1){   // $cvalue เป็น array 2 มิติ (กรณีของ เปรียบเทียบ)
	global $cvalue,$m,$c,$startj,$imgpath;
	$s = ReplaceURLParam($s);
	if(stristr($s,"#delta#")){  // เครื่องหมาย 3 เหลี่ยม
		$s = str_replace("#delta#", '<img src="'.$imgpath.'delta.png" border=0>',$s);
	}
	if(stristr($s,"#diff#")){  // Field ที่หาผลต่างของ 2 Field ก่อนนี้
		if($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-2])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-1])));
			$s = str_replace("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec),$s);
		}else{
			$s = str_replace("#diff#", "0",$s);
		}
	}	
	if(stristr($s,"#%diff#")){  // Field ที่หา % ผลต่างของ 2 Field ก่อนนี้
		if ($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-2])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-1])));
			if($a == 0 && $b == 0){
				$s = str_replace("#%diff#", "" . SetNumberFormat(0,$nformat,$dec),$s);
			}else if($a != 0){
				$s = str_replace("#%diff#", "" . SetNumberFormat(@(($a - $b)/$b) * 100.00,$nformat,$dec),$s);
			}else{
				$s = str_replace("#%diff#", "0",$s);
			}
		}else{
			$s = str_replace("#%diff#", "0",$s);
		}
	}	
	//24/10/2548 เพิ่ม #total# หาผลรวมแนวนอน
	if(stristr($s,"#total#")){  // ผลรวมทางแนวนอน (ในแถวเดียวกัน)
		$sum = 0;
		for($j=$startj;$j<=$c;$j++){
			$sum += floatval(strip_tags(str_replace(",","",$cvalue[$m][$j])));
		}
		$total = SetNumberFormat($sum,$nformat,$dec);
		$s = str_replace("#total#", $total ."" ,$s);
	}
	return $s;
}

// @modify Phada Woodtikarn 09/09/2014 function GetPopUp
$popup = 0;
function GetPopUp($width = '75%',$height = 'auto',$top = 'auto'){
	global $popup;
	if($width == ''){
		$width = '75%';
	}
	if($height != '' && $height != 'auto'){
		$height = ',maxHeight:"'.$height.'"';	
	}else{
		$height = '';	
	}
	if($top == '' && $top != 'auto'){
		$top = 'auto';	
	}
	if($popup == 0){
		$script = '<script type="text/javascript" src="common/fancybox/jquery.fancybox.js"></script>';
		$script .= '<link rel="stylesheet" type="text/css" href="common/fancybox/jquery.fancybox.css" media="screen" />';
		if($top != 'auto'){
			$script .= '<style>';
			$script .= '.fancybox-wrap{
							top: '.$top.' !important
						}';
			$script .= '</style>';
		}
		$script .= '<script>';
		$script .= '$(".fancybox").fancybox({
						width:"'.$width.'"'.$height.',
						helpers: { 
							title: null
						}
					});';
		$script .= '</script>';
		$popup++;
	}
	return $script;
}
// @end
// @modify Phada Woodtikarn 24/06/2014 เพิ่มให้รู้เป็นแบบ normal หรือ compare ให้รับ param $m=0 เพิ่ม
function GetCellSumValue($id,$sec,$cid,$json,$m=0){
// @end
	global $irs;
	global $popup;
	global $reportstyle;
	
	$irs = SearchCellInfo($sec,$cid);
	$val1 = "";
	if(isset($irs)){
		//$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);
		// @modify Phada Woodtikarn 24/06/2014 ถ้า m=0 คือ normal
		if($m==0){
			$val1 = ReplaceParam($irs['caption']);
		}else{
			$val1 = ReplaceXParam($irs['caption']); 
		}
		// @end
		if($irs['celltype'] == 1){
			// @modify Phada Woodtikarn 24/06/2014 ถ้า m=0 คือ normal
			if($m==0){
				$sql = ReplaceParam(str_replace(";","",$irs['cond'])); 
			}else{
				$sql = ReplaceXParam(str_replace(";","",$irs['cond'])); 
			}
			// @end
			$sql = ReplaceURLParam($sql); 
/*				$paramcond = GetParamCondition($sql);
			if ($paramcond != ""){
				if (!stristr($sql," where ")){  //ถ้าไม่มี where
					$sql .= " where $paramcond ";
				}else{
					$sql = eregi_replace (" where ", " where $paramcond and ",$sql);
				}
			}
*/
			if(isset($_GET['debug'])){
				if($sec == 'E'){
					echo 'Executive Summary DB('.$cid.'): '.$sql . '<br>';
				}else if($sec == 'H'){
					echo 'Information Header DB('.$cid.'): '.$sql . '<br>';
				}else if($sec == 'I'){
					echo 'Information DB('.$cid.'): '.$sql . '<br>';
				}else if($sec == 'F'){
					echo 'Footer DB('.$cid.'): '.$sql . '<br>';
				}
			}
			$xval = GetQueryValue($sql);
			$val1 .= SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
		}else if($irs['celltype'] == 3){  // function URL
			$xval="";
			if(trim($irs['cond']) > ""){
				$furl = ReplaceParam($irs['cond']);
				// 11/4/2549
				if (strtolower(substr($furl,0,7)) != "http://" ){
					// relative url
					$xurl = $_SERVER['PHP_SELF'];
					while (substr($xurl,-1) != "/" && strlen($xurl)){
						$xurl = substr($xurl,0,strlen($xurl) - 1);
					}
					$furl = "http://" . $_SERVER['SERVER_NAME'] . $xurl . $furl;
				}
				if(isset($_GET['debug'])){
					if($sec == 'E'){
						echo 'Executive Summary Function('.$cid.'): '.$fuel . '<br>';
					}else if($sec == 'H'){
						echo 'Information Header Function('.$cid.'): '.$fuel . '<br>';
					}else if($sec == 'I'){
						echo 'Information Function('.$cid.'): '.$fuel . '<br>';
					}else if($sec == 'F'){
						echo 'Footer Function('.$cid.'): '.$fuel . '<br>';
					}
				}
				$xval = @trim(@implode(' ',@file($furl))); 
			}
			$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
			$val1 .= $xval;
		}else if($irs['celltype'] == 4){
			$xval="";
			if (trim($irs['cond']) > ""){
				$xval = trim($irs['cond']);
			}
			$xval = ReplaceSpecialParam($xval,0,$irs['nformat'],$irs['decpoint']);
			$val1 .= $xval;
		}else if($irs['celltype'] == 5){  //sql array #############################################################################
			if($json != ''){
				$sqlid = str_replace("]", "", $irs['cond']);
				$key = explode("[", $sqlid);
				if(isset($json[$key[0]][$key[1]][$key[2]])){
					$xval = $json[$key[0]][$key[1]][$key[2]];
				}else{
					$xval = "";	
				}
				if(isset($n) && isset($column)){
					$cellvalue[$n][$column] = $xval;
				}
				// @modify Phada Woodtiakrn 15/07/2014 เพิ่มให้ exsum แบบ sql set เปลี่ยน format ได้
				$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
				// @end
				
				//convert to number format
				if(is_numeric($xval)) {
					//$xval = floatval($xval);
					//$xval = 9999;
				}
			}else{
				// @modify Phada Woodtikarn 30/06/2014 สามารถเลือก target ได้
				//$xval = '<font color="#666666">N/A</font>';
				$xval = SetNumberFormat('','','',$irs['nblank']);
				// @end
			}
			$val1 .= $xval;
			
		}
		if($irs['font']){
			$val1 = '<span class="span'.$sec.'" style="'.$irs['font'].'">'.$val1.'</span>';
		}
		if($irs['url']){
			$iurl = ReplaceParam($irs['url']);
			// @modify Phada Woodtikarn 15/06/2015 เพิ่ม title 
			$newUrl = GetTitle($iurl);
			$iurl = $newUrl[0];
			$urlTitle = $newUrl[1];
			// @end
			// @modify Phada Woodtikarn 09/09/2014 เพิ่ม popup
			if($irs['urltype'] == 4){
				if($popup == 0){
					$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);	
					echo $scriptPopUp;
				}
				$val1 = '<a class="result fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
			}else{
				// @modify Phada Woodtikarn 30/06/2014 สามารถเลือก target ได้
				$itarget =  GetTarget($irs['urltype']);
				$val1 = '<a class="result" href="'.$iurl.'" target="'.$itarget.'" title="'.$urlTitle.'">'.$val1.'</a>';
				// @end
			}
			// @end
		}
	}else{
		//$val1 = "&nbsp;";
	}
	//report exec sum N/A is null value
	if($val1 == "" && $sec == "E"){
		// @modify Phada Woodtikarn 13/08/2014 เพิ่ม blank value
		//$val1 ="N/A";
		$val1 = SetNumberFormat('','','',$irs['nblank']);
		// @end
	}
	return $val1;
}

function ParseTable($tb,$ts){
	global $r,$c,$tspan;
	$x = explode("x",$ts);
	$r = intval($x[0]);
	$c = intval($x[1]);

	$tspan=array();
	$tbrow = explode("|",$tb);
	$counttbrow = count($tbrow);
	for($i=0;$i<$counttbrow;$i++){
		$tbcol = explode("*",$tbrow[$i]);
		$counttbcol = count($tbcol);
		for($j=0;$j<$counttbcol;$j++){
			$tspan[$i][$j] = $tbcol[$j];
		}
	}

}
// @modify Phada Woodtikarn 30/06/2014 เพิ่มประเภท Target link
function GetTarget($target){
	if($target == 1){
		$target = '_blank';
	}else if($target == 2){
		$target = '_parent';
	}else if($target == 3){
		$target = '_top';
	}else if($target == 4){
		$target = '';
	}else{
		$target = '_self';
	}
	return $target;
}
// @end
// @modify Phada Woodtikarn 15/05/2015 เพิ่ม title link
function GetTitle($url){
	$getTitle = explode('||',$url);
	$countTitle = count($getTitle);
	if($countTitle == 2){
		$title[0] = $getTitle[0];
		$title[1] = $getTitle[1];
	}else{
		$title[0] = $url;
		$title[1] = '';
	}
	return $title;
}
// @end
// @modify Phada 28/07/2014 เพิ่ม pagination แบบ แบ่ง query
function getLimit($page=1,$divide=0,$all=0){ //สำหรับหา limit
	if($all != 0 && $all > $divide && $divide != 0){
		$tpages = ceil($all/$divide);
	}else{
		$tpages = 1;	
	}
	if($page == '' || $page <= 1 && $page != 'all'){
		$limit = ' LIMIT 0,'.$divide;
	}else if($page == 'all'){
		$limit = '';	
	}else{
		if($page > $tpages){
			$page = $tpages;
		}
		$startlimit = (($page - 1) * $divide);
		$limit = ' LIMIT '.$startlimit.','.$divide;
	}
	return $limit;
}

function pagination($page=1,$divide=0,$all=0){ //ใช้ในการเขียน style pagination 
	global $paginationurl;
	if($all != 0 && $all > $divide && $divide != 0 && $page != 'all'){
		$tpages = ceil($all/$divide);
	}else{
		$tpages = 1;	
	}
	if($page == '' || $page <= 1 && $page != 'all'){
		$page = 1;	
	}else if($page > $tpages){
		$page = $tpages;
	}
    $prevlabel = "ย้อนกลับ";
    $nextlabel = "ถัดไป";
    $val = '<div class="dataTables_wrapper">';
	$val .= '<div class="dataTables_paginate paging_simple_numbers">';
	if($page == 'all'){
		$val .= '<a href="?'.$paginationurl.'page=1" class="paginate_button all">แบ่งหน้า</a>';
	}else{
		$val .= '<a href="?'.$paginationurl.'page=all" class="paginate_button all">แสดงทั้งหมด</a>';
	}
	if($page == 1 || $page == 'all'){
		$val .= '<a class="paginate_button previous disabled">'.$prevlabel.'</a>';
	}else{
		$val .= '<a class="paginate_button previous" id="tablereportbuilder_previous">'.$prevlabel.'</a>';
	}
	$val .= '<span>';
	$dot = false;
	for($i=1;$i<=$tpages;$i++){
		if($i == $page || $page == 'all'){
			$dot = false;
			$val .= '<a class="paginate_button current" id="tablereportbuilder_'.$i.'">'.$i.'</a>';
		}else if($i <= 2 || ($i <= ($page + 2) && $i >= ($page - 2)) || ($i >= ($tpages - 1)) && $i <= $tpages){
			$dot = false;
			$val .= '<a href="?'.$paginationurl.'page='.$i.'" class="paginate_button" id="tablereportbuilder_'.$i.'">'.$i.'</a>';
		}else if($dot == false){
			$dot = true;
			$val .= '...';	
		}
	}
	$val .= '</span>';
	if($page == $tpages || $page == 'all'){
		$val .= '<a class="paginate_button next disabled">'.$nextlabel.'</a>';
	}else{
		$val .= '<a class="paginate_button next" id="tablereportbuilder_next">'.$nextlabel.'</a>';
	}
	$val .= '</div>';
	$val .= '</div>';
	return $val;
}
// @end
// @modify Phada Woodtikarn 29/07/2014 เพิ่มหา max min page
function getPage($page=1,$divide=0,$all=0){
	if($all != 0 && $all > $divide && $divide != 0){
		$tpages = ceil($all/$divide);
	}else{
		$tpages = 1;	
	}
	if($page == '' || $page <= 1 && $page != 'all'){
		$page = 1;	
	}else if($page > $tpages){
		$page = $tpages;
	}
	return $page;
}
// @end

/********************** START **************************/
if($id > 0 && isset($reportinfo[0])){
	if(isset($_GET['PDF'])){ // กรณี Export PDF
		$exportPDF = $_GET['PDF'];
	}else{
		$exportPDF = '';
	}
	// @modify Phada Woodtikarn 02/10/2014 hide Condition 
	$hideValue = true;
	if($reportinfo[0]['hidecondition'] != '' || $reportinfo[0]['hidecondition'] != '||'){
		$hideCon = explode('|',$reportinfo[0]['hidecondition']);
		if($hideCon[0] != '' && $hideCon[1] != '' && $hideCon[2] != ''){
			$hideCondition = "if($hideCon[0] $hideCon[1] $hideCon[2]){ \$hideValue = false; }else{ \$hideValue = true; }";
			eval($hideCondition);
		}
	}
	// @end
	$allowsort = false;
	// @modify Phada Woodtikarn 19/08/2014 ใช้สำหรับกรณี information background type เป็น fade color จะให้สีพื้นหลังเปลี่ยนเป็นสีขาว
	$trInfo['status'] = false;
	$trInfo['count'] = 0;
	$trInfo['value'] = '<style>.trInfo{background:#ffffff;}</style>';
	// @end
	// @modify Phada Woodtiakrn 19/07/2014 ห้ามให้ skey มากกว่า column และ เพิ่ม ordercolumn จากการตั้งค่า
	if(!isset($_GET['skey'])){
		$_GET['skey'] = $reportinfo[0]['ordercolumn'];
		$skey = $reportinfo[0]['ordercolumn'];
		$sort_order[$skey] = $reportinfo[0]['ordertype'];
	}
	$maxcolumn = explode('x',$reportinfo[0]['tsize2']);
	$skey = intval($_GET['skey']);
	$Htable = strip_tags(GetCellSumValue($id,'H','1.1',''));
	if($Htable != 'ลำดับ'){
			$columnstart = 'true';	
		}else{
			$columnstart = 'false';
		}
	if($reportinfo[0]['pagination'] == 1){
	 	
	}
	if($skey > $maxcolumn[1]){
		$skey = $maxcolumn[1];
	}else if($skey <= 2){
		if($skey == 0){
			$skey = 0;
		}else{
			if($Htable != 'ลำดับ' && $skey == 1){
				$skey = 1;
			}else{
				$skey = 2;
			}
		}
	}
	unset($Htable);
	if(!isset($_GET['asc']) and !isset($_GET['desc'])){
		if($reportinfo[0]['ordertype'] == 1){
			$sort_order[$skey] = 'desc';
		}else{
			$sort_order[$skey] = 'asc';
		}
	}else if(!isset($_GET['desc'])){
		$sort_order[$skey] = 'asc';
	}else{
		$sort_order[$skey] = 'desc';
	}
	// @end
	if(!isset($_GET['rtype'])){
		$_GET['rtype'] = '';	
	}
	$paramnosort = "";
	$paginationurl = "";
	foreach($_GET as $key=>$value){
		// @modify Phada Woodtikarn 28/07/2014 เพิ่ม url สำหรับ pagination
		if(strtolower($key) != "page"){
				$paginationurl .= $key.'='.$value.'&';
			}
		// @end
		if($key != "skey"){  
			if ($key != "asc" && $key != "desc"){  
				$paramnosort .= $key.'='.$value.'&';
			}
		}else{
			$allowsort = true;
		}
	}
	$cvalue = array();
	
	$id = $reportinfo[0]['rid'];
	
	$paramname = array();
	$paramfield = array();
	$paramcomment = array();
	$parammin = array();
	$parammax = array();
	$paramdefault = array();
	$param=0;
	
	$rs = $reportinfo[0];
	if($rs){
		// @modify Phada Woodtikarn 26/06/2014 ในกรณี rtype = 3 จะปิดหัวตาราง information ที่ show parameter
		$temp_rtype = 0;
		if($rs['rtype'] == 3){
			$temp_rtype = 3;
			$rs['rtype'] = 0;	
			$rs['startcolumn'] = 0;
		}
		// @end
		//11/4/2549 รายงานแบบ redirect
		if($rs['redirect']){
			header('Location: ' . $rs['reurl']);
			exit;
		}

		$refno = $rs['refno'];
		$keyincode = $rs['keyincode'];
		$createby = $rs['createby'];

		mysql_select_db($data_db_name);
		// @modify Phada Woodtikarn 01/07/2014 เอา count ออกจาก for ใส่ตัวแปรแทน เพื่อเพิ่มประสิทธิภาพการทำงาน
		$paramcount = count($paraminfo);
		$whereparam = '';
		// @end
		if($paramcount > 0){
			for ($param=1;$param <= $paramcount;$param++){ // เริ่มจาก 1 
				$prs = $paraminfo[$param - 1];

				$paramname[$param] = $prs['param'];
				$paramfield[$param] = $prs['dfield'];
				$paramcomment[$param] = $prs['comment'];
				// @modify Phada Woodtikarn 25/07/2014 สามารถใส่ function SQL ใน parameter ได้
				$ffld = explode("(",$prs['dfield']);
				if(isset($ffld[1])){
					$ffld[1] =  substr($ffld[1], 0, strpos($ffld[1], ')'));
					$ffld[1] =  substr($ffld[1], 0, strpos($ffld[1], ','));
					$xfld = explode(".",$ffld[1]);
				}else{
					$xfld = explode(".",$prs['dfield']);
				}
				// @end
				// @modify Phada Woodtiakrn 01/07/2014 ทำให้สามารถ หา param ข้ามตาราง และ ใส่ condition
				if(isset($prs['cond']) && $prs['cond'] != ''){
					$whereparam = ' WHERE '.$prs['cond'];
					$whereparam = ReplaceParam($whereparam);
				}else{
					$whereparam = '';
				}
				if(isset($xfld[2])){
					$parammin[$param] = GetQueryValue('SELECT MIN('.$prs['dfield'].') FROM '.$xfld[0] . '.' . $xfld[1].$whereparam);
					$parammax[$param] = GetQueryValue('SELECT MAX('.$prs['dfield'].') FROM '.$xfld[0] . '.' . $xfld[1].$whereparam);
				}else{
					$parammin[$param] = GetQueryValue('SELECT MIN('.$prs['dfield'].') FROM '.$xfld[0].$whereparam);
					$parammax[$param] = GetQueryValue('SELECT MAX('.$prs['dfield'].') FROM '.$xfld[0].$whereparam);	
				}
				// @end
				// @modify Phada Woodtikarn 26/07/2014 check show parameter
				if($prs['active']==1){
					$showparam[$param] = $parammin[$param];
				}
				// @end
				if(isset($_GET['debug'])){
					if(isset($xfld[2])){
						echo 'Parameter SQL: '.'SELECT MIN('.$prs['dfield'].') FROM '.$xfld[0] . '.' . $xfld[1].$whereparam.'<br>';
					}else{
						echo 'Parameter SQL: '.'SELECT MIN('.$prs['dfield'].') FROM '.$xfld[0].$whereparam.'<br>';
					}
				}
				// ตรวจสอบการส่งค่า Parameter มากับ URL
				if(isset($_GET[$paramname[$param]]) && $_GET[$paramname[$param]] > ""){
					$paramdefault[$param] = str_replace("'","",$_GET[$paramname[$param]]);
				}else{
					$paramdefault[$param] = $parammax[$param];
				}
				// ตรวจสอบการส่งค่า Parameter ที่ใช้เปรียบเทียบ(ชื่อ parameter ต่อท้ายด้วย "_x" ) ที่มากับ URL
				if(isset($_GET[$paramname[$param] . "_x"]) && $_GET[$paramname[$param] . "_x"] > ""){
					$xparamdefault[$param] = $_GET[$paramname[$param] . "_x"];

					// ปีอิสระ ปีด้านขวา ต้องมากกว่าด้านซ้าย
					if ($xparamdefault[$param] < $paramdefault[$param]){
						$paramdefault[$param] = $xparamdefault[$param];
					}
				}else{
					$xparamdefault[$param] = $parammax[$param];
					// @modify Phada Woodtiakrn 28/07/2014 ใส่ && $_GET['rtype'] != 'normal' เพิ่ม เพื่อไม่ให้ paramdefault เปลี่ยนค่าเอง
					if ((isset($_GET[$paramname[$param] . "_x"]) || $rs['rtype'] > 0 || $_GET['rtype'] == 'compare') && $_GET['rtype'] != 'normal'){  
					// @end
						// 23/3/2549 แก้ไขโดยเพิ่มเงื่อนไข || $rs[rtype] > 0 || $_GET[rtype] == "compare"
						// 13/2/2549 แก้ปัญหาที่หาปี - 1
						if ($parammax[$param] != $parammin[$param]){ // ถ้ามีค่าที่แตกต่าง
							$paramdefault[$param] = intval($parammax[$param]) - 1;
						}
					}  
				}
			}
		}
		// @modify Phada Woodtiakrn 01/07/2014 unset ที่ไม่ได้ใช้แล้ว
		//$param = count($paraminfo);
		$param = $paramcount; //count รอบเดียวพอ
		unset($whereparam);
		// @end
		//Generate Condition from Parameter 
		$paramcond = "";
		if($param > 0){
			for ($i=1;$i<=$param;$i++){ //เริ่มจาก 1
				if ($paramcond != "") $paramcond .= " and ";
				$paramcond .= "(" . $paramfield[$i] . " = '" . $paramdefault[$i] . "')";
			}
		}
		// Get Table Border 
		$reportbgcolor = ($rs['bgcolor'] != "") ? $rs['bgcolor'] : "#A3B2CC";
		$bcolor1 = ($rs['bcolor1'] != "") ? $rs['bcolor1'] : "#000000";
		$bcolor2 = ($rs['bcolor2'] != "") ? $rs['bcolor2'] : "#000000";
		$bcolor3 = ($rs['bcolor3'] != "") ? $rs['bcolor3'] : "#000000";
		$bcolor4 = ($rs['bcolor4'] != "") ? $rs['bcolor4'] : "#000000";
		$bsize1 = intval($rs['bsize1']);
		$bsize2 = intval($rs['bsize2']);
		$bsize3 = intval($rs['bsize3']);
		$bsize4 = intval($rs['bsize4']);
		if($rs['fldname'] == ""){
			$msg = "Cannot find KeyField for this report.";
		}
	}else{
		$msg = "Cannot find Report.";
	}
}else{
	$msg = "Cannot find Report.";
}
?>
<?php
// ====== 9/3/2549 จัดให้มีรายงานแบบ compare และ ปกติในหน้าเดียวกัน ========
//เก็บ url ทั้งหมด
$allurl = "";
foreach($_GET as $k => $v){
	if (strtolower($k) != "rtype"){
		$allurl .= $k.'='.$v.'&';
	}
}
?>
<?php
// Start Writing Report
?>
<html>
<head>
<meta charset="TIS-620">
<title><?php echo strip_tags(ReplaceParam($rs['caption'])); ?></title>
<link href="<?php echo $css_path?>report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="common/functions.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui-themes-1.10.3/themes/smoothness/jquery-ui.css" />
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<?php
// @modify Phada Woodtikarn 31/07/2014 เพิ่ม style หน้ารายงาน
if(isset($rs['fontstyle'])){
	// @modfiy Phada Woodtikarn 08/09/2014 เพิ่ม parameter ตัวที่สอง $rs['dateOfData']
	$reportstyle = getStylePreview($rs['fontstyle'],$rs['dateOfData']);
	// @end
}else{
	$reportstyle = getStylePreview('');
}
// @modify Phada Woodtikarn 13/08/2014 เพิ่มการ export to excel 
if($reportstyle['ExportCo'] == 'true'){
	$excel_host = $_SERVER['HTTP_HOST'];
?>
<script src="http://<?php echo $excel_host; ?>/html2excel_service/js/jquery.html2excel.js"></script>
<?php
}
// @end 
// @modify Phada Woodtikarn 01/08/2014 เพิ่ม function เพิ่มลด ขนาด font
if($reportstyle['ZoomCo'] == 'true'){
?>
<script>
	var size = 0;
	function ChangeFontSize(type){
		var newsize = 2;
		var zoomin = 4;
		var zoomout = -2;
		var tag = ['span.caption','span.dataat','span.reportat','span.tdcaption','span.spanE',
					'span.spanH','span.spanI','span.spanF','span.spaninfo',
					'span.spaninfosum','a.exsum','a.rtype','a.result','a.resultinfo',
					'table.tableinfo td','table.tableexsum td','table.tablefootnote td',
					'a.paginate_button'];
		var curfont;
		count = tag.length;
		if(type == 'inc' && size < zoomin){
			if(size == zoomout){
				size++;	
			}
			size++;
			if(size == (zoomin - 1)){
				$('#zoomIn').attr('src','<?php echo $imgpath; ?>icon_large_dis.png');
				$('#zoomIn').css('cursor','default');
			}else if(size == (zoomout + 1) || size == (zoomout + 2)){
				$('#zoomOut').attr('src','<?php echo $imgpath; ?>icon_small.png');
				$('#zoomOut').css('cursor','pointer');
			}
		}else if(type == 'dec' && size > zoomout){
			if(size == zoomin){
				size--;	
			}
			size--;
			if(size == (zoomout + 1)){
				$('#zoomOut').attr('src','<?php echo $imgpath; ?>icon_small_dis.png');
				$('#zoomOut').css('cursor','default');
			}else if(size == (zoomin - 1) || size == (zoomin - 2)){
				$('#zoomIn').attr('src','<?php echo $imgpath; ?>icon_large.png');
				$('#zoomIn').css('cursor','pointer');
			}
		}
		for(i=0;i<count;i++){
			curfont = parseInt($(tag[i]).css('font-size'));
			if(type == 'inc' && size < zoomin){
				curfont = curfont + newsize;
			}else if(type == 'dec' && size > zoomout){
				curfont = curfont - newsize;
			}
			$(tag[i]).css('font-size',curfont);
		}
	}
</script>
<?php
}
// @end
// @modify Phada Woodtikarn 07/08/2014 เพิ่ม TH Sarabun PSK
$font = array("Angsana New","AngsanaUPC","Arial","Browallia New","BrowalliaUPC","Comic Sans MS",
			"Cordia New","CordiaUPC","Courier New","Impact","Microsoft Sans Serif","MS Sans Serif",
			"Small","System","Tahoma","Terminal","Times New Roman","Verdana","Wingdings");
if(!in_array($reportstyle['FontNameCo'],$font)){
	$cssname = str_replace(' ','_',$reportstyle['FontNameCo']);
	echo '<link rel="stylesheet" href="common/font/'.$cssname.'.css" />';
}
// @end
?>
<style>
	body,td,th,a {
		font-family: <?php echo $reportstyle['FontNameCo'] ?>;
		font-size: <?php echo $reportstyle['FontSizeCo'] ?>px;
		color: <?php echo $reportstyle['FontColorCo'] ?>;
	}
	td{
		padding: 2px;	
	}
	a:link {
		font-size: <?php echo $reportstyle['FontSizeCo'] ?>px;
		color: <?php echo $reportstyle['FontColorL'] ?>;
		text-decoration: <?php echo $reportstyle['TextDecorationL'] ?>;
	}
	a:visited {
		font-size: <?php echo $reportstyle['FontSizeCo'] ?>px; 
		color: <?php echo $reportstyle['FontColorL'] ?>; 
		text-decoration: <?php echo $reportstyle['TextDecorationL'] ?>;
	}
	a:hover { 
		font-size: <?php echo $reportstyle['FontSizeCo'] ?>px;
		color: <?php echo $reportstyle['FontColorLO'] ?>;
		text-decoration: <?php echo $reportstyle['TextDecorationLO'] ?>;
	}
</style>
<?php
// @end
// @modify Phada Woodtikarn 19/07/2014 เพิ่ม JS สำหรับ Pagination 
if(isset($rs['pagination']) && $rs['pagination'] != 0){
	$pagistyle = getStylePagination($rs['paginationstyle']);
?>
<link rel="stylesheet" href="css/report.css"/>
<style>
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		color: <?php echo $pagistyle['FontColorO']; ?> !important;
		border: 1px solid <?php echo $pagistyle['BorderColorO']; ?>;
		background-color: <?php echo $pagistyle['BGColorO']; ?>; /* Old browsers */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $pagistyle['BGColorO']; ?>), color-stop(100%, <?php echo $pagistyle['BGColor2O']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, <?php echo $pagistyle['BGColorO']; ?> 0%, <?php echo $pagistyle['BGColor2O']; ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -moz-linear-gradient(top, <?php echo $pagistyle['BGColorO']; ?> 0%, <?php echo $pagistyle['BGColor2O']; ?> 100%); /* FF3.6+ */
		background: -ms-linear-gradient(top, <?php echo $pagistyle['BGColorO']; ?> 0%, <?php echo $pagistyle['BGColor2O']; ?> 100%); /* IE10+ */
		background: -o-linear-gradient(top, <?php echo $pagistyle['BGColorO']; ?> 0%, <?php echo $pagistyle['BGColor2O']; ?> 100%); /* Opera 11.10+ */
		background: linear-gradient(to bottom, <?php echo $pagistyle['BGColorO']; ?> 0%, <?php echo $pagistyle['BGColor2O']; ?> 100%); /* W3C */
	}
	.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
		color: <?php echo $pagistyle['FontColorA']; ?> !important;
		border: 1px solid <?php echo $pagistyle['BorderColorA']; ?>;
		background-color: <?php echo $pagistyle['BGColorA']; ?>; /* Old browsers */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $pagistyle['BGColorA']; ?>), color-stop(100%, <?php echo $pagistyle['BGColor2A']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, <?php echo $pagistyle['BGColorA']; ?> 0%, <?php echo $pagistyle['BGColor2A']; ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -moz-linear-gradient(top, <?php echo $pagistyle['BGColorA']; ?> 0%, <?php echo $pagistyle['BGColor2A']; ?> 100%); /* FF3.6+ */
		background: -ms-linear-gradient(top, <?php echo $pagistyle['BGColorA']; ?> 0%, <?php echo $pagistyle['BGColor2A']; ?> 100%); /* IE10+ */
		background: -o-linear-gradient(top, <?php echo $pagistyle['BGColorA']; ?> 0%, <?php echo $pagistyle['BGColor2A']; ?> 100%); /* Opera 11.10+ */
		background: linear-gradient(to bottom, <?php echo $pagistyle['BGColorA']; ?> 0%, <?php echo $pagistyle['BGColor2A']; ?> 100%); /* W3C */
	}
	.dataTables_wrapper .dataTables_paginate .paginate_button {
		color: <?php echo $pagistyle['FontColorFA']; ?> !important;
	}
	.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
		color: <?php echo $pagistyle['FontColorFD']; ?> !important;
	}
</style>
<?php
	unset($pagistyle);
	if($rs['paginationrow'] < 10){
		$rs['paginationrow'] = 10;
	}
	if($rs['pagination'] == 1){
?>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
	var table = $('#tablereportbuilder').DataTable( {
		"paging":   true,
		"iDisplayLength": <?php echo $rs['paginationrow'];?>,
		"aLengthMenu": [[<?php echo $rs['paginationrow'];?>,-1], [<?php echo $rs['paginationrow'];?>,"All"]],
		"info":     false,
		"columnDefs": [ {
			"searchable": false,
			"orderable": <?php echo $columnstart; ?>,
			"targets": 0
		} ],
		<?php if($skey == 0){ ?>
		"aaSorting": []
		<?php }else{ ?>
		"aaSorting": [[ 2, 'asc' ]], 
		"order": [[ <?php echo $skey-1 ?>, '<?php echo $sort_order[$skey] ?>' ]]
		<?php } ?>
	} );
	table.on( 'order.dt search.dt', function () {
		table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	$('#tablereportbuilder').show();
	<?php // @modify Phada Woodtikarn 29/07/2014 เพิ่มการแสดงทั้งหมด ?>
	$('#tablereportbuilder_all').click(function(){
		if($('select[name=tablereportbuilder_length]').val() == -1){
			$('select[name=tablereportbuilder_length]').val(<?php echo $rs['paginationrow'];?>);
			$('select[name=tablereportbuilder_length]').change();
			$('#tablereportbuilder_all').html('แสดงทั้งหมด');
		}else{
			$('select[name=tablereportbuilder_length]').val(-1);
			$('select[name=tablereportbuilder_length]').change();
			$('#tablereportbuilder_all').html('แบ่งหน้า');
		}
	});
	<?php // @end ?>
});
</script>
<?php	
	}else{
		if(!isset($_GET['page'])){
			$_GET['page'] = 1;	
		}
?>
<script>
$(document).ready(function(){
	$('#tablereportbuilder_previous').click(function(){
		$(location).attr('href', '?<?php echo $paginationurl.'page='.($_GET['page']-1) ?>');
	});
	$('#tablereportbuilder_next').click(function(){
		$(location).attr('href', '?<?php echo $paginationurl.'page='.($_GET['page']+1) ?>');
	});
	$('#tablereportbuilder').show();
	
});
</script>
<?php	
	}
?>
<?php
}else{
?>
<script>
$(document).ready(function(){
	$('#tablereportbuilder').show();
});
</script>
<?php	
}
//@end
?>
<script src="common/jquery.fnTableData-1.0.js"></script>
<?php
// @modify Phada Woodtikarn 19/07/2014 comment ไว้ เหมือนจะไม่ได้ใช้
/*<script type="text/javascript" src="common/jquery.min.js"></script>*/
?>
<script language="javascript">
<!--
function el(id) {
	if(document.getElementById){
		return document.getElementById(id);
	}else if(window[id]){
		return window[id];
	}
	return null;
}
//-->
</script>
</head>
<body bgcolor="<?php echo isset($reportbgcolor)?$reportbgcolor:'#A3B2CC'; ?>">
<?php
// @modify Phada Wooditkarn 04/11/2014
if(isset($rs['hinclude']) && $rs['hinclude'] != ''){
	if(is_file($rs['hinclude'])){
		include($rs['hinclude']);
	}
}
// @end
?>
<?
// ERROR MESSAGE
if(isset($msg)){
	echo '<h1 align="center">'.$msg.'</h1></body></html>';
	exit;
}
?>
<?php
// <!-- Fix WIDTH to 790 pixel -->
if($exportPDF != 'on'){ // กรณี Export PDF จะ Export เฉพาะส่วนของข้อมูล(Information) header
?>
<table id="reportbuilder" border="0" width="99%" cellspacing="0" cellpadding="0" align="center">
<?php
// @modify Phada Woodtikarn 01/08/2014 เพิ่มปุ่ม เพิ่มลดขนาดfont
if($reportstyle['ZoomCo'] == 'true'){
?>
<tr>
	<td align="right" style="font-size:12 !important;">
    	<img id="zoomOut" src="<?php echo $imgpath; ?>icon_small.png" title="small" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('dec')">
        <img id="zoomIn" src="<?php echo $imgpath; ?>icon_large.png" title="large" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('inc')">
    </td>
</tr>
<?php
}
// @end
?>
<tr>
<td>
<?php
// <!-- report name -->
// @modify Phada Woodtikarn 23/06/2014 เพิ่มค่า GET สำหรับซ่อน caption 
if(!isset($_GET['caption']) || $_GET['caption'] == "on"){
	if(trim($rs['caption']) != ''){
?>
<div align="center" style="padding-top:10px; padding-bottom:10px;">
	<?php // @modify Phada Woodtikarn 31/07/2014 เพิ่ม style ?>
	<span class="caption" style="font-size:<?php echo $reportstyle['FontSizeCa'] ?>px;color:<?php echo $reportstyle['FontColorCa'] ?>;">
	<?php echo ReplaceParam($rs['caption'])?>
    </span>
    <?php // @end ?>
</div>
<?php
	}
}
// @end
?>
<?php
//<!-- Executive Summary -->
// @modify Phada Woodtikarn 30/06/2014 เพิ่มการดูเฉพาะส่วน Executive Summary 
if(!isset($_GET['sec']) || $_GET['sec'] == 'E' || $_GET['sec'] == ''){
// @end
?>
<table border="0" width="100%" cellspacing="0" cellpadding="5">
<tr valign="middle">
<td width="100%">
<table class="tableexsum" id="corner-exsummary" border="<?php echo $bcolor1;?>" width="100%" align="right" cellpadding="0" bordercolor="<?php echo $bcolor1;?>" style="background-color:<?php echo $bcolor1;?>; border-collapse:collapse; border:<?php echo $bsize1;?>px solid <?php echo $bcolor1;?>;">
<?php
$cell = array();
// @modify Phada Woodtiakrn 26/06/2014 เรียกใช้ ฟังค์ชั้น ให้สามารถใช้ SQL Set แบบรับ param ได้
$json = GetJSON();
if(isset($_GET['debug']) && $_GET['debug'] == 'json'){
	echo '<pre>';
	print_r($json);
	echo '</pre>';
}
// @end
ParseTable($rs['table1'],$rs['tsize1']);
$flash = array();
if($c != 0){
	$px = 100.00 / $c; // ความกว้างแต่ละเซล
}
for($i=1;$i<=$r;$i++){
	if($reportstyle['TypeEx'] == 'flash'){
		$flash[$i] = "Exec" . (intval($i) - 1) . "=";
	}
	echo '<tr bgcolor="'.$reportbgcolor.'" valign="top">';
	for($j=1;$j<=$c;$j++){
		$cvalue[$j] = 0;
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if($rspan > 0 && $cspan > 0){
			$cellvalue = GetCellSumValue($id,"E",$i . "." . $j,$json);
			
			$fcellvalue = $cellvalue;
			$fcellvalue = str_replace("#delta#","::delta::",$fcellvalue);
			$fcellvalue = ReplaceSpecialParam($fcellvalue,$j,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
			//$fcellvalue = str_replace("::delta::","#delta#",$fcellvalue);
			$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
			$cvalue[$j] = $cellvalue;
			$cell[$i][$j] = strip_tags(str_replace(",","",$cellvalue));

			// 13/2/2549
			//หาว่ามีการ set ค่าความกว้างหรือไม่
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"E","1.$j");
				if($xpx > "" && $cspan < 2){  //ไม่มี column span
					$cwidth = ' width="'.$xpx.'" ';
					if (strpos($xpx,"%")){
						$fwidth = str_replace("%","",$xpx); // ระบุมาเป็น % อยู่แล้ว
					}else{
						$fwidth = intval((  $xpx / (650 - $wx) ) * 100);
					}
				}else{
					$cwidth = "";  //ไม่ระบุ
					$fwidth = $cspan * $px;
				}

			}else{ // ไม่มีการกำหนดค่าความกว้าง
				$cwidth = ' width="'.$px.'%" '; 
				$fwidth = $cspan * $px;
			}
			// 13/2/2549

			//ส่งค่าให้ Flash
			$tempstr = substr($cellvalue,0,strpos($cellvalue,">"));
			if(strpos($tempstr,"bold;") ){
				$isbold = "b";
			}else{
				$isbold = "";
			}

			$fcolor="";
			$x1 = strpos($tempstr,"color:");
			if($x1){
				$x2 = strpos($tempstr,";",$x1+7);
				if ($x2){
					$fcolor = substr($tempstr,$x1+7,$x2 - $x1 - 7);
				}
			}

			$falign = "";
			$bcolor = "";

			$frs = SearchCellInfo('E',$i . '.' . $j);
			if(isset($frs)){
				if($frs['alignment']){
					$falign = $frs['alignment'];
				}

				if($frs['bgcolor']){
					$bcolor = $frs['bgcolor'];
				}
			}

			$fcellvalue = strip_tags($fcellvalue);
			if($reportstyle['TypeEx'] == 'flash'){
				$flash[$i] .= urlencode($fcellvalue.'|'.$fwidth.'|'.$isbold.'|'.$falign.'|'.$fcolor.'|'.$bcolor.'^');
				//$flash[$i] .= ("$fcellvalue|$fwidth|$isbold|$falign|$fcolor|$bcolor^");
			}
			// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
			$getstyle = GetCellProperty2($id,'E',$i.'.'.$j);
			// @end
?>
<td class="<?php if(strlen($bcolor)<=1 && $frs['celltype']!="") echo 'ui-widget-header';?>" <?php echo $getstyle[0];?> <?php echo $cwidth;?> colspan="<?php echo $cspan;?>" rowspan="<?php echo $rspan;?>" style="border-collapse:collapse; border:<?php echo $bsize1;?>px solid <?php echo $bcolor1;?>;<?php echo $getstyle[1]; ?>"  >
	<?php echo $cellvalue;?>
</td>
<?
		}
	}
	echo '</tr>';
}
?>
</table>
</td>
<td width="<?php echo $wx+10?>" align="center" valign="top">
<?php
//<!-- ######################################## Chart exesummary ######################################################## -->
	$sec = "E";
	if(count($chartinfo) > 0){
		include('report_chart.php');
	}
?>
<?php
//<!-- BANNER -->
if($rs['bannerurl']){ 
	if($rs['bstyle'] == 0){ // Image
		if($rs['bstretch'] == 0){
			echo '<img src="'.$bimgpath.$rs['bannerurl'].'" alt="Banner" border=0 width="'.$wx.'" height="'.$hx.'">';
		}else if($rs['bstretch'] == 2){
			// @modify Phada Woodtikarn 05/08/2014 เพิ่มการกำหนด size เอง
			if(isset($rs['bsize'])){
				$bsize = explode('x',$rs['bsize']);
			}
			echo ChangeSizeImage($bimgpath.$rs['bannerurl'],$bsize[0],$bsize[1]);
			// @end
		}else{
			echo '<img src="'.$bimgpath.$rs['bannerurl'].'" alt="Banner" border=0>';
		}
	}else if($rs['bstyle'] == 1){ // FLASH
		if($rs['bstretch'] == 0){
			$setwidth = 'width="'.$wx.'" height="'.$hx.'" ';
		}else{
			$setwidth = "";
		}
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?php echo $setwidth; ?>>
<param name="movie" value="<?php echo $bimgpath.$rs['bannerurl']; ?>">
<param name="quality" value="high">
<embed src="<?php echo $bimgpath.$rs['bannerurl']?>" quality="100%" 
pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
</object>
<?php
	}
}
?>
</td>
</tr></table>
<?php
// @modify Phada Woodtikarn 30/06/2014 ปิดส่วนการดูเฉพาะส่วน Executive Summary 
}
// @end
//<!-- END Executive Summary -->
?>
<?php
// start Executive Summary, รายงานณวันที่, ข้อมูลณวันที่, export
if($reportstyle['VisibleEx'] == 'true' || $reportstyle['VisibleDA'] == 'true' || $reportstyle['VisibleRA'] == 'true' || $reportstyle['ExportCo'] == 'true' || $reportstyle['PDFCo'] == 'true'){
?>
<BR>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
	<tr>
        <td>
			<?php
            // @modify Phada Woodtikarn 21/06/2014 เอา comment กับ defin MAIN_RPT ออก
			if(!isset($_GET['executive'])){
				$_GET['executive'] = 'on';
			}
            if($_GET['executive'] != 'off' && $reportstyle['VisibleEx'] == 'true'){
				// @modify Phada Woodtikarn 08/08/2014 สามารถเลือกประเภท executive summary ได้ แบบธรรมดา แบบflash
				if($reportstyle['TypeEx'] == 'normal'){
            ?>
                <a class="exsum" onClick="windowsFromTableId('corner-exsummary','common/exsummary.php','Executive Summary','<?php echo $reportstyle['StyleEx'] ?>','dataat')" target="_blank" style="cursor:pointer;font-size:<?php echo $reportstyle['FontSizeEx'] ?>px;color:<?php echo $reportstyle['FontColorEx'] ?>">
                    <img src="<?php echo $imgpath; ?>full_exsum.png" style="width:20px;margin-right:6px;"/>Executive Summary
                </a>
            <?php 
            	}else{
					$flashstring = "";
					for($i=1;$i<=count($flash);$i++){
						$flashstring .= $flash[$i] . "&";
					}
					echo '<br><a href="common/executivesum.php?'.$flashstring.'" target="_blank" style="cursor:pointer;font-size:'.$reportstyle['FontSizeEx'].'px;color:'.$reportstyle['FontColorEx'].'"><img src="'.$imgpath.'full_exsum.png" style="width:20px;margin-right:6px;"/>Executive Summary</a>';
				}
			}
            // @end
            ?>
        </td>
        <td align="right">
            <?php
			// @modify Phada Woodtikarn 08/09/2014 เพิ่ม ข้อมูล ณ วันที่
			if($reportstyle['VisibleDA'] == 'true'){
				$dateOfData = GetQueryValue(ReplaceParam($reportstyle['SQLDA']));
				if(is_null($dateOfData)){
					$dateOfData = date_eng2thai(date('Y-m-d'),543);			
				}else{
					$dateOfData = date_eng2thai($dateOfData,543);
				}
            ?>
            <span class="dataat" style="font-size:<?php echo $reportstyle['FontSizeDA'] ?>px;color:<?php echo $reportstyle['FontColorDA'] ?>;">ข้อมูล ณ วันที่ <?php echo $dateOfData;?></span><br/>
            <?php
            }
			// @end
            // @modify Phada Woodtikarn 27/06/2014 สามารถปิดรายงาน ณ วันที่ได้
			if(!isset($_GET['reportat'])){
				$_GET['reportat'] = 'on';
			}
            if($_GET['reportat'] != 'off' && $reportstyle['VisibleRA'] == 'true'){
            ?>
            <span class="reportat" style="font-size:<?php echo $reportstyle['FontSizeRA'] ?>px;color:<?php echo $reportstyle['FontColorRA'] ?>;">รายงาน ณ วันที่ <?php echo intval(date('d')).' '.$monthname[intval(date('m'))].' '.(date('Y')+543);?></span><br/>
            <?php
            }
            // @end
            ?>
		</td>
	</tr>
    <tr>
        <td align="right" colspan="2" style="padding-top:0px">
        	<?php
            if($rs['table2'] != '' && $reportstyle['VisibleRC'] == 'true'){
				$fontRC = 'font-size:'.$reportstyle['FontSizeRC'].'px;';
                // @modify Phada Woodtikarn 21/06/2014 เอาcomment compare ออก
                if($rs['rtype'] >= 1){ //เป็น compare
                    if($_GET['rtype'] == "normal"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">รายงานเปรียบเทียบ</a>';
                    }else{
                        echo '<a class="rtype" href="?'.$allurl.'rtype=normal" style="'.$fontRC.'float:right;">รายงานแบบปกติ</a>';
                    }
                }else if($rs['rtype'] == 0 && $temp_rtype != 3){ //เป็น normal
                    if($_GET['rtype'] == "normal"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">รายงานเปรียบเทียบ</a>';
                    }else if($_GET['rtype'] == "compare"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=normal" style="'.$fontRC.'float:right;">รายงานแบบปกติ</a>';
                    }else{	
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">รายงานเปรียบเทียบ</a>';
                        //$_GET['rtype'] = "normal";	
                    }
                }
                // @end
				unset($fontRC);
            // ====== 9/3/2549 จัดให้มีรายงานแบบ compare และ ปกติในหน้าเดียวกัน ========
            }
        	?>
        </td>
    </tr>
    <tr>
    	<td align="right" colspan="2">
        	<?php 
            // @modify Phada Woodtikarn 04/04/2015 เพิ่มการ export to PDF
            if($reportstyle['PDFCo'] == 'true'){
				$pdf_host = $_SERVER['HTTP_HOST'];
				$url_report = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&PDF=on';
				$url_report = urlencode($url_report);
            ?>
            <a style="text-decoration: initial !important;" href="http://<?php echo $pdf_host; ?>/html2pdf_service/html2pdf.service.php?mgt=10&mgl=10&mgr=10&mgb=10&dowload=0&mgfontsize=18&filename=pdf&Format=A4&Orientation=L&HtmlFile=<?php echo $url_report; ?>&button=Submit" target="_blank">
        		<img src="<?php echo $imgpath; ?>PDF-icon.png" width="20px" title="PDF" alt="">
            </a>
			<?php 
            }
            // @end 
            ?>
			<?php 
            // @modify Phada Woodtikarn 13/08/2014 เพิ่มการ export to excel
            if($reportstyle['ExportCo'] == 'true'){
            ?>
        	<a style="text-decoration: initial !important;" href="javascript:void()" onclick="html2excel('tablereportbuilder','http://<?php echo $excel_host; ?>/html2excel_service/html2excel.php','info','')">
            	<img src="<?php echo $imgpath; ?>Excel-icon.png" width="20px" title="Excel" alt="">
            </a>
			<?php 
            }
            // @end 
            ?>
        </td>
    </tr>
</table>
<?php
}
// end Executive Summary, รายงานณวันที่, ข้อมูลณวันที่, export
?>
<div>
<?php
	$_cHistory= "<script>document.write(history.length)</script>";
	//echo  "page: ".$_SESSION['backurl'];
	if(intval($_cHistory) <= 1){
		
	}
?>
</div>
<?php
} // end header if($exportPDF != 'on'){
// <!-- TABLE HEADER -->
// @modify Phada Woodtikarn 30/06/2014 เพิ่มการดูเฉพาะส่วน Information 
if(!isset($_GET['sec']) || $_GET['sec'] == 'H' || $_GET['sec'] == 'I' || $_GET['sec'] == ''){
// @end
	$reportAt = intval(date('d')).' '.$monthname[intval(date('m'))].' '.(date('Y')+543); // รายงาน ณ วันที่
?>
<?php if($exportPDF == 'on'){ // กรณี Export PDF จะย้าย Caption มาแสดงก่อนตาราง Information ?>
<div align="center" style="padding-top:10px; padding-bottom:10px;">
	<span class="caption" style="font-size:16px;color:<?php echo $reportstyle['FontColorCa'] ?>;">
	<?php echo ReplaceParam($rs['caption']); ?>
    </span><br>
    <div class="reportat" style="width:100%;text-align:right;font-size:12px;color:<?php echo $reportstyle['FontColorRA'] ?>;">รายงาน ณ วันที่ <?php echo $reportAt; ?></div>
</div>
<?php } ?>
<table class="tableinfo" id="tablereportbuilder" border="<?php echo $bsize2;?>" width="100%" align="center" cellpadding="2" bordercolor="<?php echo $bcolor2;?>" style="background-color:<?php echo $bcolor2;?>; border-collapse:collapse; border:<?php echo $bsize2;?>px solid <?php echo $bcolor2;?>; display: none;">
<thead>
<?php if($exportPDF != 'on'){ ?> 
	<tr><td colspan="<?php echo $maxcolumn[1] ?>" style="display:none;"><?php echo ReplaceParam($rs['caption']); ?></td></tr>
    <tr><td colspan="<?php echo $maxcolumn[1] ?>" style="display:none;">รายงาน ณ วันที่ <?php echo $reportAt; ?></td></tr>
<?php } ?>
<?php
if($rs['table2'] != ''){
// 26/11/2548 เพิ่ม parameter เพื่อการ เปรียบเทียบ
if ($_GET['rtype'] == "compare"){
	if ($rs['rtype'] == 0 && $temp_rtype != 3){ //หากดั้งเดิมเป็น normal
		$rs['rtype'] = 2;   // Overide to comparision report type 2 (no diff) 
	}
}else if ($_GET['rtype'] == "normal"){
	if ($rs['rtype'] != 0){ //หากดั้งเดิมไม่เป็น normal
		$rs['rtype'] = 0;   // Overide to normal report
	}
}
ParseTable($rs['table2'],$rs['tsize2']);
$startcolumn = intval($rs['startcolumn'] - 1);
if ($startcolumn < 0){
	$startcolumn = 0;
}
//ถ้ามี parameter
// @modify Phada Woodtikarn 26/06/2014 ถ้าส่งตัวแปร rtype = 3 มา จะปิด หัวตารางส่งแสดงจา parameter
if($temp_rtype != 3){
// @end
	for($i=1;$i<=$param;$i++){
		// @modify Phada Woodtikarn 26/07/2014 เช็คว่าจะให้แสดง parameter นี้สำหรับ hearder ตารางมั้ย
		if(isset($showparam[$i])){
		// @end
			$nrow = $param+$r;  
			echo '<tr bgcolor="#b8b8b8">';
			if ($i==1){ //เฉพาะบรรทัดแรก
				for ($n1=0;$n1<$startcolumn;$n1++){
					// @modify Phada Woodtikarn 26/06/2014 เพิ่ม property ที่กำหนด
					// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
					$getstyle = GetCellProperty2($id,'H',(11+$n1)/10);
					// @end
					echo '<td rowspan="'.$nrow.'" align="center" '.$getstyle[0].' style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';'.$getstyle[1].'" >';
					echo '<span class="tdcaption" id="caption'.$n1.'">&nbsp;</span>';
					echo '</td>';
					// @end
				}
			}
			echo '<td align="center" colspan="'.($c - $startcolumn).'"  style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';">';
			echo '<table border="0" width="100%"><tr>';
			echo '<td width="25px">';
			// BACK Button
			if($paramdefault[$i] > $parammin[$i]){
				$px1 = "";
				for($j=1;$j<=$param;$j++){
					$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
					if ($j != $i){
						$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
					}
				}
				for($j=0;$j<=5;$j++){
					if (isset($_GET['param'.$j])){
						$px1 .= 'param'.$j.'='.$_GET['param'.$j].'&';
					}
				}
				if($allowsort){
					$px1 .= 'skey='.$skey.'&';
				}
				if($_GET['rtype'] != ''){
					// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
					echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
					// @end
				}else{
					// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
					echo '<a href="?id='.$id.'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
					// @end
				}
			}
			echo '</td><td align="center"><b>';
			echo $paramcomment[$i]." ".$paramdefault[$i];
			echo '</b></td><td align="right" width="25px">';
			// NEXT Button
			if($paramdefault[$i] < $parammax[$i]){
				if(! ($rs['rtype'] >= 1 && $paramdefault[$i] >= $xparamdefault[$i] )) {
					$px1 = "";
					for($j=1;$j<=$param;$j++){
						$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
						if($j != $i){
							$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
						}
					}
					for($j=0;$j<=5;$j++){
						if (isset($_GET['param'.$j])){
							$px1 .= 'param'.$j.'='.$_GET['param'.$j].'&';
						}
					}
					if($allowsort){
						$px1 .= 'skey='.$skey.'&';
					}
					if($_GET['rtype'] != ''){
						// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
						echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}else{
						// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
						echo '<a href="?id='.$id.'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}
		
				}
			}
			echo "</td></tr></table></td>";
			if($rs['rtype'] >= 1){ // Comparision Report
				echo '<td align="center" colspan="'.($c - $startcolumn).'" style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.'; font-size:12px;">';
				echo '<table border="0" width="100%"><tr>';
				echo '<td width="25px">';
				// BACK Button
				if($xparamdefault[$i] > $parammin[$i]){
					if(($paramdefault[$i] < $xparamdefault[$i] )) {
						$px1 = "";
						for($j=1;$j<=$param;$j++){
							$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&"; // prameter ปกติ
							if ($j != $i){
								$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
							}
						}
						for($j=0;$j<=5;$j++){
							if (isset($_GET['param'.$j])){
								$px1 .= 'param'.$j.'='.$_GET['param'.$j].'&';
							}
						}
						
						if($allowsort){
							$px1 .= 'skey='.$skey.'&';
						}
						if($_GET['rtype'] != ''){
							// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
							echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
							// @end
						}else{
							// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
							echo '<a href="?id='.$id.'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
							// @end
						}
					}
				}
				echo '</td><td align="center" style="font-size:12px;"><b>';
				echo $paramcomment[$i]." ".$xparamdefault[$i];
				echo '</b></td><td align="right" width="25px">';
				// NEXT Button
				if($xparamdefault[$i] < $parammax[$i]){
					$px1 = "";
					for ($j=1;$j<=$param;$j++){
						$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
						if ($j != $i){
							$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
						}
					}
					for($j=0;$j<=5;$j++){
						if (isset($_GET['param'.$j])){
							$px1 .= 'param'.$j.'='.$_GET['param'.$j].'&';
						}
					}
					if($allowsort){
						$px1 .= 'skey='.$skey.'&';
					}
					if($_GET['rtype'] != ''){
						// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
						echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}else{
						// @modify Phada Woodtikarn 26/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
						echo '<a href="?id='.$id.'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}
				}
				echo "</td></tr></table></td>";
				// เปรียบเทียบ
				//if ($rs[rtype] == 1 && $_GET[rtype] != "compare"){ // Comparision Report เท่านั้น rtype == 2 ไม่แสดง
				if($rs['rtype'] == 1){ // Comparision Report เท่านั้น rtype == 2 ไม่แสดง
					if($i == 1) {  //แสดงเฉพาะ parameter แรก จะได้ไม่ซ้ำซ้อน
						echo '<td align="center" rowspan="'.($param+$r).'" colspan="'.($c - $startcolumn).'" style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';font-size:12px;"><img src="'.$imgpath.'delta.png" border="0"><b>%</b></td>';
					}else{
						//echo "<td align=center rowspan='".($param+$r)."'colspan='".($c - $startcolumn)."' style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'>&nbsp;</td>";
					}
				}
			} // Comparision Report
			echo '</tr>';
		// @modify Phada Woodtikarn 26/07/2014 endif isset($testparam[$i]
		}
		// @end
	} //end for ถ้ามี para
// @modify Phada Woodtikarn 26/06/2014 endif temp_rtype != 3
}
// @end
// บรรทัดที่เป็น Header 
$px = intval(100 / $c); // ความกว้างแต่ละเซล
for($i=1;$i<=$r;$i++){
	echo '<tr bgcolor="#A3B2CC" valign="top">';
	for($j=1;$j<=$c;$j++){
		$cvalue[$j] = 0;
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if($rspan > 0 && $cspan > 0){
			$cellvalue = GetCellSumValue($id,"H",$i . "." . $j,$json);
			$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
			$cvalue[$j] = $cellvalue;
			//SORTING (28/10/2548)
			// @modify Phada Woodtikarn 16/09/2014 เพิ่มการ order ($rspan + $i - 1) == $r ในกรณีที่ marge rowspan
			if(($i == $r || ($i == 1 && $j == $startcolumn )) || ($rspan + $i - 1) == $r && $allowsort){
			// @end
				if(!isset($sort_order[$j])) $sort_order[$j] = "asc";
				// @modify Phada Woodtikarn 19/07/2014 ถ้าเปิด pagination จะให้ใช้ order ของ datatable.js แทน
				if($rs['pagination'] != 1){
					if (trim(strip_tags($cellvalue)) != "ลำดับ"){  //17/4/2549
						if ($skey == $j){
							if ($sort_order[$j] == "asc"){
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$j.'&desc"><img src="'.$imgpath.'sort-asc.gif" border="0"></a>';
							}else{
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$j.'&asc"><img src="'.$imgpath.'sort-desc.gif" border="0"></a>';
							}
						}else{
							$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$j.'&asc"><img src="'.$imgpath.'sort.gif" border="0"></a>';
						}
					}
				}
				// @end
			}
			if ($i==1 && $param > 0 && $startcolumn > 0 && $j <= $startcolumn){  //rowspan
?>
				<?php
                // @modify Phada Woodtikarn 26/06/2014 ถ้าส่งตัวแปร rtype = 3 มา จะปิด หัวตารางส่งแสดงจา parameter
                if($temp_rtype != 3){
                // @end
                ?>
                <script language="JavaScript">
                <!--
                var captiontext = el("caption<?php echo $j-1;?>");
                captiontext.innerHTML = '<?php echo $cellvalue;?>';
                //-->
                </script>
                <?php
                // @modify Phada Woodtikarn 26/06/2014 endif rtype != 3
                }
                // @end
                ?>
<?php
			}else{
			// 13/2/2549
			//หาว่ามีการ set ค่าความกว้างหรือไม่
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"H","1.$j");
				if ($xpx > "" && $cspan < 2){  //ไม่มี column span
					$cwidth = ' width="'.$xpx.'" ';
				}else{
					$cwidth = "";  //ไม่ระบุ
				}
			}else{ // ไม่มีการกำหนดค่าความกว้าง
				$cwidth = ' xxwidth="'.$px.'%" ';  //auto สำหรับ header
			}
			// 13/2/2549

			// 18/10/2013
			$hrs = SearchCellInfo('H',$i.'.'.$j);
			if(isset($hrs)){
				if(isset($hrs['bgcolor']) && $hrs['bgcolor']){
					$bcolor = $hrs['bgcolor'];
				}
			}
			// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
			$getstyle = GetCellProperty2($id,'H',$i.'.'.$j);
			// @end
?>
<td class="<?php if(strlen($bcolor)<=1) echo 'ui-widget-header';?>" <?php echo $getstyle[0];?> <?php echo $cwidth;?> colspan="<?php echo $cspan;?>" rowspan="<?php echo $rspan?>" style="border-collapse:collapse; border:<?php echo $bsize2;?>px solid <?php echo $bcolor2;?>;<?php echo $getstyle[1];?>">
	<?php echo $cellvalue?>
</td>
<?php
			}
		}
	}
	if($rs['rtype'] >= 1){ // Comparision Report
		for($j=$startcolumn+1;$j<=$c;$j++){   // ตั้งแต่ Cell ที่ระบุใน startcolumn
			$cvalue[$j] = 0;
			$x = explode("x",$tspan[$i-1][$j-1]);
			$rspan = intval($x[0]);
			$cspan = intval($x[1]);
			if($rspan > 0 && $cspan > 0){
				// @modify Phada Woodtikarn 24/06/2014 เพิ่ม param 1 เข้าไป
				$cellvalue = GetCellSumValue($id,"H",$i . "." . $j,$json,1);
				// @end
				$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
				$cvalue[$j] = $cellvalue;
				//sorting
				if(($i == $r || ($i == 1 && $j == $startcolumn )) && $allowsort ){
					$nxx = $c + $j - 1;
					if(!isset($sort_order[$j])) $sort_order[$j] = "asc";
					// @modify Phada Woodtikarn 19/07/2014 ถ้าเปิด pagination จะให้ใช้ order ของ datatable.js แทน
					if($rs['pagination'] != 1){
						if($skey == $c + $j - 1){
							//$cellvalue .= " <img src='$imgpath/down1.gif' border=0>";
							//$cellvalue = "<u>$cellvalue</u>";
							if($sort_order[$j] == "asc"){
								// @modify Phada Woodtikarn 27/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&desc"><img src="'.$imgpath.'sort-asc.gif" border="0"></a>';
								// @end
							}else{
								// @modify Phada Woodtikarn 27/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&asc"><img src="'.$imgpath.'sort-desc.gif" border="0"></a>';
								// @end
							}
						}else{
							// @modify Phada Woodtikarn 27/06/2014 เอา target='_parent' ออก เพราะถ้าเรียกรายงานในiframe จะมีปัญหา
							$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&asc"><img src="'.$imgpath.'sort.gif" border="0"></a>';
							// @end
						}
					}
					// @end
				}
				// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
				$getstyle = GetCellProperty2($id,'H',$i.'.'.$j);
				// @end
	?>
	<td <?php echo $getstyle[0]; ?> xxxwidth="<?php echo $px;?>%" colspan="<?php echo $cspan;?>" rowspan="<?php echo $rspan;?>" style="border-collapse:collapse; border:<?php echo $bsize2;?>px solid <?php echo $bcolor2;?>;<?php echo $getstyle[1]; ?>">
		<?php echo $cellvalue;?>
	</td>
	<?
			}
		} //for
// ไม่ต้องแสดงในส่วนของ Header แล้ว เพราะ ใช้ rowspan มาจากบรรทัดบน
		// เปรียบเทียบ
		//		echo "<td align=center colspan='" . ($c - $startcolumn) . "'>&nbsp;</td>";

	}  // 	if ($rs[rtype] == 1){ // Comparision Report
	echo '</tr>';
}
}
// <!-- END TABLE HEADER -->
?>
</thead>
<tbody>
<?php
// <!-- INFORMATION PORT / NO SPAN / 2 ROWS-->
// BGCOLOR
$bg[1] = "#FF6633";   // Data Row
$bg[2] = "#996600";   // Summarize Row

$px = intval(100 / $c); // ความกว้างแต่ละเซล
//INFORMATION
$i = 1;
$nrow = 0;

$cvalue = array();
$csum = array();
$xfld = explode(".",$rs['fldname']);
// 23/10/2548
// ตรวจสอบว่าเป็นการดึงข้อมูลจาก tmp_report หรือไม่ หากมาจาก tmp_report ไม่ต้องดึงข้อมูลจริงๆ 
// แต่ให้ include file ทำงานแทน โดยดึง summary มาเก็บลง array แล้วเอามาใช้
if($xfld[0] == "tmp_report"){
	$tablestyle = 1; // tmp_report
}else{
	$tablestyle = 0;  //actual table
}

//24/10/2548 
//บังคับให้อ่านจาก tmp_report เพื่อการ DEMO
//$tablestyle = 0;  //actual table
if($rs['rtype'] == 0){
	$nround = 0;   // รอบเดียว
}else if($rs['rtype'] == 1 ){
	$nround = 2;   // 3 รอบ  (0-2)
}else{
	$nround = 1;   // 2 รอบ  (0-1)
}

$paramcond = GetParamCondition($rs['fldname']);
$arr_fldname = explode('.',$rs['fldname']);
$count_arr_fldname = count($arr_fldname);
$fldorder = $rs['fldorder'];
if($fldorder == ''){
	if($count_arr_fldname >= 3){
		$fldorder = $xfld[2];
	}else{
		$fldorder = $xfld[1];
	}
}
if(trim($rs['cond']) == ""){
	if($count_arr_fldname >= 3){
		$sql = 'SELECT * FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]).' ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 เพิ่ม หาจำนวน record ใช้สำหรับแบ่งหน้า
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[2].') FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]);
		}
		// @end
	}else{
		$sql = 'SELECT * FROM '.$xfld[0].' ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 เพิ่ม หาจำนวน record ใช้สำหรับแบ่งหน้า
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[1].') FROM '.$xfld[0];
		}
		// @end
	}
}else{
	// @modify Phada Woodtikarn 26/07/2014 เพิ่ม กรณี รายงานแบบเปรียบเทียบ ให้สามารถเปรียบเทียบแบบ โดยใช้แบบ field ได้
	if($count_arr_fldname >= 3){
		$sql = 'SELECT * FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]).'
					 WHERE '.ReplaceParam(ReplaceSpecialParam($rs['cond'],0)).' 
					 ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 เพิ่ม หาจำนวน record ใช้สำหรับแบ่งหน้า
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[2].') FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]).' WHERE '.ReplaceParam(ReplaceSpecialParam($rs['cond'],0));
		}
		// @end
		if($nround != 0){
			$sql_x = 'SELECT * FROM '.ReplaceXParam($xfld[0].'.'.$xfld[1]).'
						 WHERE '.ReplaceXParam(ReplaceSpecialParam($rs['cond'],0)).' 
						 ORDER BY '.$xfld[2];
		}
	}else{
		$sql = 'SELECT * FROM '.$xfld[0].'
					 WHERE '.ReplaceParam(ReplaceSpecialParam($rs['cond'],0)).' 
					 ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 เพิ่ม หาจำนวน record ใช้สำหรับแบ่งหน้า
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[1].') FROM '.$xfld[0].' WHERE '.ReplaceParam(ReplaceSpecialParam($rs['cond'],0));
		}
		// @end
		if($nround != 0){
			$sql_x = 'SELECT * FROM '.$xfld[0].'
						 WHERE '.ReplaceXParam(ReplaceSpecialParam($rs['cond'],0)).' 
						 ORDER BY '.$xfld[1];
		}
	}
	// @end
}
// @modify Phada 28/07/2014 เพิ่ม pagination แบบ แบ่ง query
if($rs['pagination'] == 2){
	$findrecord = GetQueryValue($sqlrecord);
	$_GET['page'] = getPage($_GET['page'],$rs['paginationrow'],$findrecord);
	$sql .= getLimit($_GET['page'],$rs['paginationrow'],$findrecord);
}
// @end
unset($count_arr_fldname);
if(isset($_GET['debug'])){
	echo 'Information SQL: '.$sql.'<br>';
}
// ดึงข้อมูลจาก RecordSet จาก Array หรือ จาก ResultSet
// 23/10/2548 เพื่อใช้ร่วมกับ tmp_report ได้ โดยไม่ต้องเก็บข้อมูลลงตารางจริง
function GetRecord(&$resultset,$tbstyle){
	if ($tbstyle == 0){ // from actual table
		return @mysql_fetch_array($resultset,MYSQL_ASSOC);
	}else{
		return  @array_pop($resultset);
	}
}

if($rs['table2'] != ''){
$n=0;
$cellvalue = array();
$rowtext = array();

if ($tablestyle == 1){ //tmpreport
	if ($rs['pinclude']){
		include $rs['pinclude'];  //ให้ include file ทำการดึงข้อมูลเก็บลง $tmp_rs
	}
	$mresult = @array_reverse($tmp_rs); //เอาตัวแปรมาจาก array ที่ทำไว้ใน include file แล้ว reverse เพื่อ pop ออกมา 
}else{  // actual query
	$mresult = mysql_query($sql);
	// @modify Phada Woodtikarn 26/07/2014 เพิ่ม กรณี รายงานแบบเปรียบเทียบ ให้สามารถเปรียบเทียบแบบ โดยใช้แบบ field ได้
	if($nround != 0){
		$mresult_x = mysql_query($sql_x);
		$i = 1;
		while($mrs_x_temp = GetRecord($mresult_x,0)){
			$mrs_x[$i] = $mrs_x_temp;
			$i++;	
		};
		if (isset($_GET['debug'])){
			echo 'Information SQL_X: '.$sql_x.'<br>';
		}
		unset($sql_x);
		unset($mresult_x);
		unset($mrs_x_temp);
	}
	// @end
}
//json
// @modify Phada Woodtikarn 26/06/2014 หา SQL set แบบเปรียบเทียบปีได้
for($m=0;$m<=$nround;$m++){
	if($m == 0){
		// @modify Phada Woodtikarn 11/09/2014 เพิ่ม paramter ตัวที่สาม return SQL
		$jsonSQL = GetJSON('I','','true');
		// @end
	}else{
		// @modify Phada Woodtikarn 11/09/2014 เพิ่ม paramter ตัวที่สาม return SQL
		$json_compareSQL[$m] = GetJSON('I',$m,'true');
		// @end
	}
}
// @end
// @modify Phada Woodtikarn 23/07/2014 หา Key Field เดิมอยู่ใน loop ทำให้ทำงานช้า
$xfldkey = explode(".",$rs['fldname']);
$countxfldkey = count($xfldkey);
if($countxfldkey == 3){
	$xfldkey[0] = $xfldkey[1];
	$xfldkey[1] = $xfldkey[2];
}
// @end
while($mrs=GetRecord($mresult,$tablestyle)){
	$n++;
	$column=0;
	$rowtext[$n] = "";
	// @modify Phada Woodtikarn 19/08/2014 ใช้สำหรับกรณี information background type เป็น fade color จะให้สีพื้นหลังเปลี่ยนเป็นสีขาว
	if($trInfo['status'] == true && $trInfo['count'] == 0){
		echo $trInfo['value'];
		$trInfo['count']++;
	}
	// @end
//	if ($n % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
//FOR SORTING (28/10/2548)
	// @modify Phada Woodtikarn 19/08/2014 เพิ่ม class trInfo
	$rowtext[$n] .= '<tr class="trInfo" bgcolor="#IBG#" valign="top">';
	// @end
	for($m=0;$m<=$nround;$m++){   // ทำ 3 รอบสำหรับ Comparision
		if($m == 0){ //รอบแรกเริ่มที่ 1 , รอบที่ 2,3 เริ่มที่ startcolumn
			// @modify Phada Woodtikarn 11/09/2014 เพิ่ม การใช้งาน SQL-set ในส่วนinformation
			if($jsonSQL != ''){
				$json = GetResultJSON($jsonSQL,$mrs[$xfldkey[1]]);
			}
			// @end
			$startj = 1;  
		}else{
			// @modify Phada Woodtikarn 11/09/2014 เพิ่ม การใช้งาน SQL-set ในส่วนinformation
			if($jsonSQL != ''){
				$json_compare[$m] = GetResultJSON($json_compareSQL[$m],$mrs[$xfldkey[1]]);
			}
			// @end
			$startj = $startcolumn+1;  
		}
		for($j=$startj;$j<=$c;$j++){  //แต่ละ Column
			// เชคว่า ค่าเป็น N/A ทั้งหมดทุก row ในแต่ละ column หรือเปล่า (23/3/2549)
			if(!isset($is_all_na[$m][$j])) $is_all_na[$m][$j] = true; // ถือว่าเป็น n/a ไว้ก่อน
			
			$cvalue[$m][$j] = 0;
			
			if(!isset($csum[$m][$j])) $csum[$m][$j] = 0;
			
			//echo "<td " . GetCellProperty2($id,"I","1." . $j) . " width='$px%' colspan='1' rowspan='1'>";
			//นับ column
			$column++;
			$cellvalue[$n][$column] = "";
			
			$irs = SearchCellInfo('I','1.'.$j);
			if(isset($irs)){
				//$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);

				// Grouping option
				if($rs['rgroup'] == 1){
					$xfld = explode(".",$rs['fldname']);
					if(count($xfld) >= 3){
						$x = " ".$mrs[$xfld[2]];
					}else{
						$x = " ".$mrs[$xfld[1]];
					}
					$gp = substr($x,strlen($x) - 2,2);
					if($gp == "00"){
						$val1 = "<B>" . $irs['caption'];
						$groupitem = true;
					}else{
						if ($j == 1){ // First Column
							$val1 = '&nbsp;&nbsp;&nbsp;' . $irs['caption'];
						}else{
							$val1 = $irs['caption'];
						}
						$groupitem = false;
					}
				}else{  // no grouping
					$find_param = find_keywords("#fld:",$irs['caption']);
					if($find_param == true){
						foreach($mrs as $fieldname1 => $fieldvalue1){
							$find_param = find_keywords("#fld:",$irs['caption']);
							if($find_param == true){
								$irs['caption'] = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$irs['caption']);
							}else{
								break;
							}
						}
					}
					$val1 = $irs['caption'];
					$groupitem = false;
				}

				$val1 = ReplaceSpecialParam2($val1,$j,$irs['nformat'],$irs['decpoint']);
				$xval = @floatval(strip_tags(str_replace(",","",$val1)));
				$csum[$m][$j] += floatval(str_replace(",","",$xval));

				// เก็บ original value ของเซลล์ (28/10/2548)
				$cellvalue[$n][$column] = $xval;

//SORTING (28/10/2548)
//				// #no# ตัวเลขแสดงลำดับ
//				$val1 = eregi_replace ("#no#", "$n",$val1);
				
				if($rs['rtype'] >= 1 && $m == 2){  // หาก เป็น Comparision column เฉพาะ rtype == 1 เท่านั้น แบบที่ == 2 ไม่แสดง
					$a = floatval(strip_tags(str_replace(",","",$cvalue[1][$j])));
					$b = floatval(strip_tags(str_replace(",","",$cvalue[0][$j])));
					if($a != 0){
						// เก็บ original value ของเซลล์ (28/10/2548)
						$cellvalue[$n][$column] = @(($a - $b)/$b) * 100.00;

						$val1 = SetNumberFormat(@(($a - $b)/$b) * 100.00,1,1);
					}else{
						// เก็บ original value ของเซลล์ (28/10/2548)
						$cellvalue[$n][$column] = "";
						$val1 = "0";
					}
					$cvalue[$m][$j] = $val1;
				}else if($irs['celltype'] == 1){  //Database
					$sql = str_replace(";","",$irs['cond']); 
					$xfld = explode(".",$rs['fldname']);
					if(count($xfld)>=3){
						$sql = str_replace("#key#",$mrs[$xfld[2]] ,$sql);   //แทนค่าของ parameter ที่เป็น Keyfield ลงใน SQL Query
					}else{
						$sql = str_replace("#key#",$mrs[$xfld[1]] ,$sql);   //แทนค่าของ parameter ที่เป็น Keyfield ลงใน SQL Query
					}
					// 13/2/2549 ใช้ #fld:ชื่อ field# สำหรับอิงข้อมูลใน field ของตารางที่เป็น Key Table ใช้ได้ใน Information port เท่านั้น
					if(stristr($sql,"#fld:")){
						foreach($mrs as $fieldname1 => $fieldvalue1){
							$find_param = find_keywords("#fld:",$sql);
							if($find_param == true){
								$sql = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$sql);   //แทนค่าของ parameter ที่เป็นค่าใน field ลงใน SQL Query
							}else{
								break;
							}
							
						}
					}
	/*ใช้ #paramname-1# แทน จึงต้องระบุ Parameter เองทุก sql*/
	/*				$paramcond = GetParamCondition($sql);
					if ($paramcond != ""){
						if (!stristr($sql," where ")){  //ถ้าไม่มี where
							$sql .= " where $paramcond ";
						}else{
							$sql = eregi_replace (" where ", " where $paramcond and ",$sql);;
						}
					}
	*/
					if($m == 0){ // รอบแรก หรือ ไม่ได้เป็นรายงานที่เปรียบเทียบ
						$sql = ReplaceParam($sql);
					}else{
						$sql = ReplaceXParam($sql);
					}
					$sql = ReplaceURLParam($sql); 
					if (isset($_GET['debug'])){
						echo 'Information DB: '.$sql . '<br>';
					}
					$xval = GetQueryValue($sql);
					// เก็บ original value ของเซลล์ (28/10/2548)
					$cellvalue[$n][$column] = $xval;

					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));

					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					if($groupitem){
						$val1 .= '<b>'.$xval.'</b>';
					}else{
						$val1 .= $xval;
					}
				}else if($irs['celltype'] == 2){  //field
					// @modify Phada Woodtikarn 26/07/2014 เพิ่มความสามารถ ใท้ เปรียบเทียบได้
					$xfld = explode(".",$irs['cond']);
					// @modify Phada Woodtikarn 16/09/2014 ถ้ากรณีเรียกฟิว ตั้งแต่ชื่อฐานข้อมูล
					$countxfld = count($xfld);
					if($countxfld == 3){
						$xfld[0] = $xfld[1];
						$xfld[1] = $xfld[2];
					}
					// @end
					if($m == 0){
						if(isset($xfld[1]) && isset($mrs[$xfld[1]])){
							$xval = $mrs[$xfld[1]];   //เอาค่าจากใน record ปัจจุบัน
						}else{
							$xval = "";
						}
					}else{
						if(isset($xfld[1]) && isset($mrs_x[$n][$xfld[1]])){
							$xval = $mrs_x[$n][$xfld[1]];
						}else{
							$xval = "";
						}
					}
					// เก็บ original value ของเซลล์ (28/10/2548)
					$cellvalue[$n][$column] = $xval;
					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					if($groupitem){
						$val1 .= '<b>'.$xval.'</b>';
					}else{
						$val1 .= $xval;
					}
				}else if($irs['celltype'] == 3){ //function
					$xval="";
					if (trim($irs['cond']) > ""){
						$furl = ReplaceParam($irs['cond']);

						// 11/4/2549
						if (strtolower(substr($furl,0,7)) != "http://" ){
							// relative url
							$xurl = $_SERVER['PHP_SELF'] ;
							while (substr($xurl,-1) != "/" && strlen($xurl)){
								$xurl = substr($xurl,0,strlen($xurl) - 1);
							}
							$furl = "http://" . $_SERVER['SERVER_NAME'] . $xurl . $furl;
						}
						$xval = @trim(@implode(' ',@file($furl)));
					}
					// เก็บ original value ของเซลล์ (28/10/2548)
					$cellvalue[$n][$column] = $xval;
					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					if($groupitem){
						$val1 .= '<b>'.$xval.'</b>';
					}else{
						$val1 .= $xval;
					}
				}else if($irs['celltype'] ==5){ //sql set #######################################################################
					$sqlid = str_replace("]", "", $irs['cond']);
					$key = explode("[", $sqlid);
					// @modify Phada Woodtikarn 12/09/2014 แก้ keyField
					//$keyField = $mrs[$xfld[1]];
					$keyField = $mrs[$xfldkey[1]];
					// @end
					// @modify Phada Woodtikarn 26/06/2014 เปรียบเทียบปี
					if($m == 0){
						if(isset($json[$key[0]])){
							$jsonCount = count($json[$key[0]]);
							for($rr=0; $rr<$jsonCount; $rr++){
								if($json[$key[0]][$rr][0] == $keyField){
									$xval = $json[$key[0]][$rr][$key[2]];
									break;
								}
							}
						}else{
							$xval = '';
						}
					}else{
						if(isset($json_compare[$m][$key[0]])){
							$jsonCount = count($json_compare[$m][$key[0]]);
							for($rr=0; $rr<$jsonCount; $rr++){
								if($json_compare[$m][$key[0]][$rr][0] == $keyField){
									$xval = $json_compare[$m][$key[0]][$rr][$key[2]];
									break;
								}
							}
						}else{
							$xval = '';
						}
					}
					// @end
					// เก็บ original value ของเซลล์
					$cellvalue[$n][$column] = $xval;
					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					// @modify Phada Woodtikarn 24/09/2014 เพิ่ม SetNumberFormat
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					if($groupitem){
						$val1 .= '<b>'.$xval.'</b>';
					}else{
						$val1 .= $xval;
					}
					// @end
				}
				if($irs['font']){
					// @modify Phada Woodtikarn 25/07/2014 ทำให้สามารถดึง css จาก filed ในฐานข้อมูลได้
					$find_param = find_keywords("#fld:",$irs['font']);
					if($find_param == true){
						if($m == 0){
							foreach ($mrs as $fieldname1 => $fieldvalue1){
								$find_param = find_keywords("#fld:",$irs['font']);
								if($find_param == true){
									$irs['font'] = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$irs['font']);
								}else{
									break;
								}
							}
						}else if($m == 1){
							foreach ($mrs_x[$n] as $fieldname1 => $fieldvalue1){
								$find_param = find_keywords("#fld:",$irs['font']);
								if($find_param == true){
									$irs['font'] = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$irs['font']);
								}else{
									break;
								}
							}
						}
					}
					// @end
					$marginLeft = ReplaceSpace($val1);
					if($marginLeft != false && isset($marginLeft['text'])){
						$val1 = '<span class="spaninfo" style="margin-left:'.$marginLeft['margin'].';'.$irs['font'].'">'.$marginLeft['text'].'</span>';
					}else{
						$val1 = '<span class="spaninfo" style="'.$irs['font'].'">'.$val1.'</span>';
					}
				}
				if($irs['url'] && $exportPDF != 'on'){ // กรณี Export PDF จะลบ link ออก
					$iurl = $irs['url'];
					$iurl = str_replace("#key#",$mrs[$xfldkey[1]] ,$iurl);   //แทนค่าของ parameter ที่เป็น Keyfield ลงใน SQL Query
					// @modify Phada Wooditkarn 23/07/2014 เพิ่มการ replace #fld:
					$find_param = find_keywords("#fld:",$iurl);
					if($find_param == true){
						if($m == 0){
							foreach ($mrs as $fieldname1 => $fieldvalue1){
								$find_param = find_keywords("#fld:",$iurl);
								if($find_param == true){
									$iurl = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$iurl);
								}else{
									break;
								}
							}
						}else if($m == 1){
							foreach ($mrs_x[$n] as $fieldname1 => $fieldvalue1){
								$find_param = find_keywords("#fld:",$iurl);
								if($find_param == true){
									$iurl = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$iurl);
								}else{
									break;
								}
							}
						}
					}
					// @end
					// @modif Phada Woodtikarn 23/07/2014 comment ไว้ เหมือนไม่ได้ใช้ใส่ส่วนของ url
					// 13/2/2549 ใช้ #fld:ชื่อ field# สำหรับอิงข้อมูลใน field ของตารางที่เป็น Key Table ใช้ได้ใน Information port เท่านั้น
					/*if (stristr($sql,"#fld:")){
						foreach ($mrs as $fieldname1 => $fieldvalue1){
							$sql = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$sql);   //แทนค่าของ parameter ที่เป็นค่าใน field ลงใน SQL Query
						}
					}*/
					// @end
					$iurl = ReplaceParam($iurl);
					$iurl = str_replace("#value#", $val1, $iurl);
					// @modify Phada Woodtikarn 15/06/2015 เพิ่ม title 
					$newUrl = GetTitle($iurl);
					$iurl = $newUrl[0];
					$urlTitle = $newUrl[1];
					// @end
					
					// @modify Phada Woodtikarn 09/09/2014 เพิ่ม popup
					if($irs['urltype'] == 4){
						if($popup == 0){
							$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);	
							echo $scriptPopUp;
						}
						$val1 = '<a class="resultinfo fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
					}else{
						// @modify Phada Woodtikarn 30/06/2014 สามารถเลือก target ได้
						$itarget =  GetTarget($irs['urltype']);
						$val1 = '<a class="resultinfo" href="'.$iurl.'" target="'.$itarget.'" title="'.$urlTitle.'">'.$val1.'</a>';
						// @end
					}
					// @end
				}
			}else{
				$val1 = '&nbsp;';
				$cvalue[$m][$j] = 0;
			}
			//ตรวจสอบค่า ว่าเป็น N/A ทั้งหมดทุก row ในแต่ละ column หรือไม่ เพราะ N/A ทั้งหมด ต้อง sum ได้  N/A ไม่ใช่ 0
			if(strip_tags ($val1) != "0" ){
				$is_all_na[$m][$j] = false; //หากมีอันใดอันหนึ่งไม่ใช่ ถือว่าผลรวมต้องไม่เป็น N/A 
			}
			if(strip_tags ($val1) == "0" ){
				// $val1="N/A";
				//$is_all_na[$m][$j] =true;
			}
			// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
			// @modify Phada Woodtikarn 18/08/2014 เพิ่มตัวแปร สำหรับ bgcolor_type
			$getstyle = GetCellProperty2($id,'I','1.'.$j,strip_tags($val1));
			// @end
			// @end
			$rowtext[$n] .= '<td '.$getstyle[0].' colspan="1" rowspan="1" style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';'.$getstyle[1].'">';
			$rowtext[$n] .= $val1;
			$rowtext[$n] .= '</td>';
		}  // for $j
	} // for $m
$rowtext[$n] .= '</tr>';
}
//SORT (28/10/2548)
//int strcmp ( string str1, string str2)
//Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they are equal.
// @modify Phada Woodtikarn 24/07/2014 เพิ่ม $rs['pagination'] != 1 ให้ไม่ทำงานเมื่อมีการใช้งาน pagination เพราะ มีความสามารถ order อยู่แล้ว
if($allowsort && $rs['pagination'] != 1){
// @end
	$keycol = $skey;  //column ที่เรียง
	if(isset($cellvalue[1])){
		$countcellvalue = count($cellvalue[1]);
	}else{
		$countcellvalue = 0;
	}
	if($keycol >= 1 && $keycol <= $countcellvalue){  //อยู่ใน scope
		if(is_numeric($cellvalue[1][$keycol])){
			$number_compare = true;
		}else{
			$number_compare = false;
		}
		for($k=1;$k<$n;$k++){
			for($j=$k+1;$j<=$n;$j++){
				if($sort_order[$keycol] == "asc"){ //น้อยไปมาก
					if($number_compare){
						if($cellvalue[$k][$keycol] > $cellvalue[$j][$keycol]){
							//swap $rowtext
							$temp_array = $rowtext[$k];
							$rowtext[$k] = $rowtext[$j];
							$rowtext[$j] = $temp_array;
							//swap $cellvalue
							$temp_array = $cellvalue[$k];
							$cellvalue[$k] = $cellvalue[$j];
							$cellvalue[$j] = $temp_array;
						}
					}else{ //string compare
						if(strcmp($cellvalue[$k][$keycol],$cellvalue[$j][$keycol]) > 0){
							//swap $rowtext
							$temp_array = $rowtext[$k];
							$rowtext[$k] = $rowtext[$j];
							$rowtext[$j] = $temp_array;
							//swap $cellvalue
							$temp_array = $cellvalue[$k];
							$cellvalue[$k] = $cellvalue[$j];
							$cellvalue[$j] = $temp_array;
						}
					}
				}else{ // มากไปน้อย
					if($number_compare){
						if($cellvalue[$k][$keycol] < $cellvalue[$j][$keycol] ){
							//swap $rowtext
							$temp_array = $rowtext[$k];
							$rowtext[$k] = $rowtext[$j];
							$rowtext[$j] = $temp_array;
							//swap $cellvalue
							$temp_array = $cellvalue[$k];
							$cellvalue[$k] = $cellvalue[$j];
							$cellvalue[$j] = $temp_array;
						}
					}else{ //string compare
						if(strcmp($cellvalue[$k][$keycol],$cellvalue[$j][$keycol]) < 0){
							//swap $rowtext
							$temp_array = $rowtext[$k];
							$rowtext[$k] = $rowtext[$j];
							$rowtext[$j] = $temp_array;
							//swap $cellvalue
							$temp_array = $cellvalue[$k];
							$cellvalue[$k] = $cellvalue[$j];
							$cellvalue[$j] = $temp_array;
						}
					}
				}
			}	//for j
		} //for k
	} // if
}
//แสดงผล
for($k=1;$k<=$n;$k++){
	// @modify Phada 28/07/2014 เพิ่ม pagination แบบ แบ่ง query ทำให้ต้องเรียงลำดับใหม่
	if($rs['pagination'] == 2 && $_GET['page'] != 'all'){
		$autonumber = (($_GET['page']-1) * $rs['paginationrow']) + $k;
		$rowtext[$k] = str_replace("#no#", "$autonumber" ,$rowtext[$k]);  //แทนค่าลำดับที่
	}else{
		$rowtext[$k] = str_replace("#no#", "$k" ,$rowtext[$k]);  //แทนค่าลำดับที่
	}
	// @end
	if($k % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
	$rowtext[$k] = str_replace("#IBG#", "$ibg" ,$rowtext[$k]);  //แทนค่าสี Background
	echo $rowtext[$k];
}
?>
</tbody>
<?php if($exportPDF != 'on'){  // กรณี Export PDF จะ ปิด tag tfoot ?>
<tfoot>
<?php } ?>
<?php
//SUMMARY
echo '<tr bgcolor="#b8b8b8" valign="top">';
for($m=0;$m<=$nround;$m++){   // ทำ 3 รอบสำหรับ Comparision
	if($m == 0){ //รอบแรกเริ่มที่ 1 , รอบที่ 2,3 เริ่มที่  startcolumn
		$startj = 1;  
	}else{
		$startj = $startcolumn+1;   
	}
	for($j=$startj;$j<=$c;$j++){
			$cvalue[$m][$j] = 0;
			//echo "<td " . GetCellProperty2($id,"I","2." . $j) . "width='$px%' colspan='1' rowspan='1'>";
			
			//GetCell Value
			$irs = SearchCellInfo('I','2.'.$j);
			if(isset($irs)){
				//$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);
				$val1 = $irs['caption'];
				$val1 = ReplaceSpecialParam2($val1,$j);
				if($rs['rtype'] >= 1 && $m == 2) {  // หาก เป็น Comparision column   แบบที่ rtype == 1 เท่านั้น ==2 ไม่แสดง
					$a = floatval(strip_tags(str_replace(",","",$cvalue[1][$j])));
					$b = floatval(strip_tags(str_replace(",","",$cvalue[0][$j])));
					if($a != 0){
						$val1 = SetNumberFormat(@(($a - $b)/$b) * 100.00,1,1);
					}else{
						// @modify Phada Woodtikarn 30/06/2014 สามารถเลือก target ได้
						//$val1 = "";
						$val1 = SetNumberFormat('','','',$irs['nblank']);
						// @end
					}
					$cvalue[$m][$j] = $val1;
				}else if($irs['celltype'] == 1){
					$sql = str_replace(";","",$irs['cond']);
	/*				$paramcond = GetParamCondition($sql);
					if ($paramcond != ""){
						if (!stristr($sql," where ")){  //ถ้าไม่มี where
							$sql .= " where $paramcond ";
						}else{
							$sql = eregi_replace (" where ", " where $paramcond and ",$sql);;
						}
					}
	*/
					$sql = ReplaceParam($sql);
					$sql = ReplaceURLParam($sql); 
					if(isset($_GET['debug'])){
						echo 'Information Footer DB: '.$sql . '<br>';
					}
					$xval = GetQueryValue($sql);
					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					$val1 .= $xval;
				}else if($irs['celltype'] == 2){
					$sql = str_replace(";","",$irs['cond']); 

					$xfld = explode(".",$irs['cond']);
					$sql = 'SELECT SUM('.$xfld[1].') FROM '.$xfld[0];

					$paramcond = GetParamCondition($sql);
					if($paramcond != ""){
						$sql .= ' WHERE '.$paramcond;
					}

					$xval = GetQueryValue($sql);
					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					$val1 .= $xval;
				}else if($irs['celltype'] == 3){
					$xval="";
					if(trim($irs['cond']) > ""){
						$furl = ReplaceParam($irs['cond']);
						// 11/4/2549
						if(strtolower(substr($furl,0,7)) != "http://" ){
							// relative url
							$xurl = $_SERVER['PHP_SELF'] ;
							while(substr($xurl,-1) != "/" && strlen($xurl)){
								$xurl = substr($xurl,0,strlen($xurl) - 1);
							}
							$furl = "http://" . $_SERVER['SERVER_NAME'] . $xurl . $furl;
						}
						$xval = @trim(@implode(' ',@file($furl)));
					}
					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					$val1 .= $xval;
				}else if($irs['caption'] == ""){
					if($m == 2){ // comparision column 
						$val1 .= "&nbsp;";
					}else{
						if(isset($is_all_na[$m][$j]) && $is_all_na[$m][$j] != ""){ //	หากทุก row ใน column นี้เป็น N/A ทั้งหมด 23/3/2549
							$cvalue[$m][$j] = "0";
							$xval = "0";
						}else{
							if(isset($csum[$m][$j])){
								$cvalue[$m][$j] = $csum[$m][$j];
								$xval = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']); // เอาค่า sum ของ field มาใส่ หากไม่มีการกำหนดค่า
							}
						}
						$val1 .= $xval;
					}
				}else if($irs['caption'] == "#count#"){
					$val1 = $n;
				}else if($irs['caption'] == "#sum#"){
					$val1 = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					$val1 = SetDecimal($val1,1);
				}else if($irs['caption'] == "#avg#"){
					$val1 = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					// @modify Phada Woodtikarn 11/09/2014
					$val1 = str_replace(',','',$val1);
					// @end;
					if($n == 0){
						$val1 = SetDecimal(0,1);
					}else{
						$val1 = SetDecimal($val1/$n,1);
					}
				}
				if ($irs['font']){
					$val1 = '<span class="spaninfosum" style="'.$irs['font'].'">'.$val1.'</span>';
				}
				if ($irs['url']){
					$iurl = ReplaceParam($irs['url']);
					$iurl = str_replace('#value#', $val1, $iurl);
					// @modify Phada Woodtikarn 15/06/2015 เพิ่ม title 
					$newUrl = GetTitle($iurl);
					$iurl = $newUrl[0];
					$urlTitle = $newUrl[1];
					// @end
					
					// @modify Phada Woodtikarn 09/09/2014 เพิ่ม popup
					if($irs['urltype'] == 4){
						if($popup == 0){
							$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);
							echo $scriptPopUp;
						}
						$val1 = '<a class="resultinfo fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
					}else{
						// @modify Phada Woodtikarn 30/06/2014 สามารถเลือก target ได้
						$itarget =  GetTarget($irs['urltype']);
						$val1 = '<a class="resultinfo" href="'.$iurl.'" target="'.$itarget.'" title="'.$urlTitle.'">'.$val1.'</a>';
						// @end
					}
					// @end
				}
			}else{ // ไม่มีข้อมูลเซลนี้ 
				if(isset($csum[$m][$j])){
					$val1 = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']); // เอาค่า sum ของ field มาใส่ หากไม่มีการกำหนดค่า
				}
				//global $n;
				//$val1 = round($val1/$n, 2); average sum count avg
				//$val1 = SetDecimal($val1/$n,1);
			}
			// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
			$getstyle = GetCellProperty2($id,'I','2.'.$j,strip_tags($val1));
			// @end
			echo '<td '.$getstyle[0].' colspan="1" rowspan="1" style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';'.$getstyle[1].'">';
			echo $val1;
			echo "</td>";
	}
}
echo "</tr>";
} //Sum คอลัม
?>
<?php if($exportPDF != 'on'){  // กรณี Export PDF จะ ปิด tag tfoot ?>
</tfoot>
<?php } ?>
</table>
<?php
if($exportPDF != 'on'){ // กรณี Export PDF จะ Export เฉพาะส่วนของข้อมูล(Information) footer
// @modify Phada 28/07/2014 เพิ่ม pagination แบบ แบ่ง query
if($rs['pagination'] == 2){
	echo pagination($_GET['page'],$rs['paginationrow'],$findrecord);
}else if($rs['pagination'] == 1){
	// @modify Phada 28/07/2014 เพิ่ม การแสดงทั้งหมด
	echo '<div class="dataTables_wrapper" style="display: initial;"><div class="dataTables_paginate"><a class="paginate_button all" id="tablereportbuilder_all">แสดงทั้งหมด</a></div></div>';
	// @end
}
// @end
?>
<?php
// @modify Phada Woodtikarn 30/06/2014 ปิดส่วนการดูเฉพาะส่วน information
}
// @end
// <!-- END INFORMATION PORT -->
?>
<BR>
<?php
// <!-- FOOTNOTE -->
// @modify Phada Woodtikarn 30/06/2014 เพิ่มการดูเฉพาะส่วน Footnote
if(!isset($_GET['sec']) || $_GET['sec'] == 'F' || $_GET['sec'] == ''){
// @end
?>
<table class="tablefootnote" border="0" width="100%" align="center" cellpadding="0" bordercolor="<?php echo $bcolor4;?>" style="background-color:#b8b8b8;border-collapse:collapse; border:<?php echo $bsize4;?>px solid <?php echo $bcolor4;?>;">
<?php
ParseTable($rs['table4'],$rs['tsize4']);
$cvalue = array();   //clear array
$px = intval(100 / $c); // ความกว้างแต่ละเซล
for($i=1;$i<=$r;$i++){
	echo '<tr bgcolor="'.$reportbgcolor.'" valign="top">';
	for($j=1;$j<=$c;$j++){
		$cvalue[$j] = 0;
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if($rspan > 0 && $cspan > 0){
			$cellvalue = GetCellSumValue($id,"F",$i . "." . $j,$json);
			$cvalue[$j] = $cellvalue;
			// 28/12/2548
			//หาว่ามีการ set ค่าความกว้างหรือไม่
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"F",'1.'.$j);
				if($xpx > "" && $cspan < 2){  //ไม่มี column span
					$cwidth = ' width="'.$xpx.'"';
				}else{
					$cwidth = "";  //ไม่ระบุ
				}
			}else{ // ไม่มีการกำหนดค่าความกว้าง
				$cwidth = ' width="'.$px.'%" '; 
			}
			// 28/12/2548
			// @modify Phada Woodtikarn 04/08/2014 เปลี่ยนการ return GetCellProperty2 เป็น array
			$getstyle = GetCellProperty2($id,'F',$i.'.'.$j);
			// @end
?>
<td <?php echo $getstyle[0];?> <?php echo $cwidth;?> colspan="<?php echo $cspan;?>" rowspan="<?php echo $rspan;?>" style="border-collapse:collapse; border:<?php echo $bsize4;?>px solid <?php echo $bcolor4;?>;<?php echo $getstyle[1];?>">
	<?php echo $cellvalue;?>
</td>
<?php
		}
	}
	echo '</tr>';
}
?>
</table>
<?php
// เอาค่า parameter แปลงเป็นตัวแปล
for($param=1;$param <= $paramcount;$param++){ // เริ่มจาก 1 
	$xx = '$' . str_replace("#","",$paramname[$param]) . "='" . $paramdefault[$param] . "';";
	eval($xx);
}
// @modify Phada Woodtikarn 25/06/2014 เพิ่มความเร็วเอา @ ออก
/*if ($rs[finclude]){
	@include "$rs[finclude]";
}*/
if(is_file($rs['finclude'])){
	$irs = SearchCellInfo('F','1.1');
	include($rs['finclude']);
}
// @end
?>
<?php
// @modify Phada Woodtikarn 30/06/2014 ปิดส่วนการดูเฉพาะส่วน Footnote
}
// @end
// <!-- END FOOTNOTE -->
// <!-- End Display Table & Merge Cell -->
?>
<BR>
</td></tr>
</table>
<?php
} // end footer if($exportPDF != 'on'){
// <!-- End Main Table - Fix Width to 790 -->
?>
</body>
</html>
<?php
/*$Contents->Put_contents(); 
ob_end_flush();  */ 
?>
