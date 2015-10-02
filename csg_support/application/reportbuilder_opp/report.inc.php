<?php
/**
 * @comment 	˹���͡ report
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: ᡹�ͧ����ʴ�����§ҹ
Version			: 2.0
Last Modified	: 23/10/2548
Changes		:
	28/7/2548 - ����ͧ�Ӥ�� Caption �ͧ��§ҹ���ʴ����ǹ Exec. Sum.
					- �������ͧ�ٻẹ����ⴹ�պ������ stretch
					- �����ӴѺ��Ǣ��
					- �Ѵ�����鹺�÷Ѵ��ҹ���ͧ Table Header
	6/8/2548	- ������ print ��鹵��ҧ�����
					- �Ѵ��� Link ���� Report
					- �ٻ��� Stretch ����¹�繢�Ҵ 189 * 120
					- ������� �մ�ҹ��� ��ͧ�ҡ���Ҵ�ҹ����
					- #diff# �Ѵ�ٻẺ�������˹�
	8/8/2548	- ����������Ẻ Function ���仴֧�����Ũҡ URL ��
	23/10/2548- ���ͺ���ҧ�����§��
					- ���� ���������� #pv1# - #pv4# ����Ҥ�Ҩҡ $pvcode[] �����
					- �� pre-execute include file (���� field 'pinclude' Ẻ text 㹵��ҧ reportinfo) ��ત��Ҫ��� ���ҧ��� tmp_report �������
#
# �ç���ҧ���ҧ `tmp_report`
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

	24/10/2548 - ���� parameter #total# ᷹��Ҽ�����ǹ͹ (�����ǡѹ)
	26/11/2548 - ��������� parameter rtype=compare
	12/12/2548 - ������ǹ sorting �ҡ�к� skey

	28/12/2548 - �ӹ˴�������ҧ�ͧ column �� (੾��� Footer) 
					  - ����Ѻ Database ����� reportinfo ����� cwidth1,cwidth2,cwidth3,cwidth4 ��ҹ��
	13/1/2549	 - ����Ңͧ param0 - param5 ���������͹��
	26/1/2549	 - ��������ǹ�ͧ [cond] �� special Parameter ��

	5/1/2549	- ���ӴѺ�ѧ��Ѵ �ҡ (�ѹ����� / �ź��� / ��Ҵ / ���ͧ) ���� (�ź��� / ���ͧ / �ѹ����� / ��Ҵ)
	4/2/2549	- ���÷Ѵ 290 ����á "" ��͹˹�Ҥ�ҵ���Ţ����᷹��� #diff#
	13/2/2549 - ��ѭ�ҷ���һ� - 1
	13/2/2549 - �� #fld:fieldname# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
	17/2/2549 - ��� column �ʴ����١��ͧ�ҡ�� ���� parameter
	17/2/2549 - ��� �ŵ�ҧ������º��º

	25/2/2549 - ���� link ��������ǹ executive summary  ��
	9/3/2549	- �Ѵ�������§ҹẺ compare ��� �����˹�����ǡѹ 
	23/3/2549	- ��� �óշ���к� $_GET[rtype] ��� override �� rtype=2 (compare w/out diff)
	25/3/2549 - ��䢻ѭ�ҡ���ʴ��ŷ�� Executive Summary �ͧ Flash �Դ��Ҵ
	11/4/2549 - �� field Ẻ function ����� relative path ��
					- ���� Report Ẻ Redirect
	17/4/2549 - �������ͧ�ͧ����ʴ��š�� sort ��� click m�� icon ᷹
	// @modify Phada Woodtikarn 25/06/2556
	24/06/2557 - ������� header ���ҧẺ���º��º �ʴ������Ẻ���º��º��
	25/06/2557 - ������Ѻ parameter ź���� -543 +543
	26/06/2557 - ���� rtype = 3 ������� ��ǵ��ҧ information ����� parameter
	19/06/2557 - ���� pagination
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
	echo " <B>�ѧ��Ѵ $prov_name</B><br>";
}*/
//echo "$dbname";
//$pvcode = array('','22','20','23','21'); // ���ʨѧ��Ѵ (������ҡ 1) / �ѹ����� / �ź��� / ��Ҵ / ���ͧ ���§�������ѡ��
$pvcode = array('','20','21','22','23'); // ���ʨѧ��Ѵ (������ҡ 1) / �ź��� / ���ͧ / �ѹ����� / ��Ҵ => 5/1/2549

// ----------------------------------------------------------------------- get json -----------------------------------------------------------------
// @modify Phada Woodtikarn 26/06/2014 �����������ѧ��� SQL set ����ö�Ѻ param ��
// @modify Phada Woodtikarn 11/09/2014 ���� Parameter return SQL
function GetJSON($sec = '',$m = 0,$returnSQL = ''){ //$sec �������˹�����è��ҷ�����¡��鹵��ҧ information, $m ��͡�����º��º
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
			if ($m == 0){ // �ͺ�á ���� ���������§ҹ������º��º
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
	$x=explode('|',$xwidth); //���� column ��蹴��� |
	if(isset($x[$col - 1])){
		$cwidth = $x[$col - 1]; // ���੾�е�Ƿ���˹��ҡ��ҵ����ѧ�ͧ cellno
	}

	return htmlspecialchars($cwidth);
}
function GetParamCondition($sql){
	global $param,$paramname,$paramdefault,$paramfield;
	$paramcond='';
	if($param > 0){
		for($i=1;$i<=$param;$i++){ //������ҡ 1
			$xfld = explode(".",$paramfield[$i]);
			if($xfld[0] != ""){ // ��� function ������դ��
				if(stristr($sql,$xfld[0])){   //�Ҵ���� �� table.field �ͧ parameter � sql ����������
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
// @modify Phada Woodtikarn 27/06/2014 function ����Ѻ�� keywords function find_keywords(�ӷ���ͧ�����,��ͤ���)
function find_keywords($keywords, $text) {
	$found = strpos($text, $keywords);
	if($found !== false){
		return true;
	}else{
		return false;	
	}
}
// @end
// @modify Phada Woodtikarn 28/03/2015 funcion ����Ѻ replace &nbsp; to margin
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
		// @modify Phada Woodtikarn 27/06/2014 ���ͧ�ҡ�� str_replace �����Թ �ç��ҨЪ�� �������� ��͹����� ��Ƿ��� replace ����
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
				// @modify Phada Woodtikarn 25/06/2014 �������͹䢻�
				$s = str_replace("#" . $paramname[$i] . "-543#", intval($paramdefault[$i]) - 543,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-2#",intval($paramdefault[$i]) - 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-1#",intval($paramdefault[$i]) - 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+1#",intval($paramdefault[$i]) - 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+2#",intval($paramdefault[$i]) - 543 + 2,$s);
				// @end
			}
			$find_param = find_keywords("#".$paramname[$i]."+543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 �������͹䢻�
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
	// ᷹������ʨѧ��Ѵ �µ�ͧ�кؤ��㹵���������� $pvcode
	for($n=1;$n<=4;$n++){
		if (stristr($s,"#pv$n#")){  // ���ʨѧ��Ѵ��� n
			$s = str_replace("#pv$n#", $pvcode[$n],$s);
		}
	}
	return $s;
}

function ReplaceXParam($s){ // ����Ѻ�����������º��º
	global $param,$paramname,$xparamdefault,$paramcomment;
	for($i=1;$i<=$param;$i++){ //start from 1
		// @modify Phada Woodtikarn 27/06/2014 ���ͧ�ҡ�� str_replace �����Թ �ç��ҨЪ�� �������� ��͹����� ��Ƿ��� replace ����
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
				// @modify Phada Woodtikarn 25/06/2014 �������͹䢻�
				$s = str_replace("#" . $paramname[$i] . "-543#", intval($xparamdefault[$i]) - 543,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-2#",intval($xparamdefault[$i]) - 543 - 2,$s);
				$s = str_replace("#" . $paramname[$i] . "-543-1#",intval($xparamdefault[$i]) - 543 - 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+1#",intval($xparamdefault[$i]) - 543 + 1,$s);
				$s = str_replace("#" . $paramname[$i] . "-543+2#",intval($xparamdefault[$i]) - 543 + 2,$s);
				// @end
			}
			$find_param = find_keywords("#".$paramname[$i]."+543",$s);
			if($find_param == true){
				// @modify Phada Woodtikarn 25/06/2014 �������͹䢻�
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
// @modify Phada Woodtikarn 13/08/2014 ���� blank value
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
	// @modify Phada Woodtikarn 28/06/2014 ���ء��ա����͹
	}else if($nformat == 5){ //format ���ء��ա����͹
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
	// @modify Phada Woodtikarn 30/09/2014 ��͹������
	}else if($nformat == 6){ //format ��͹������
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
// @modify Phada Woodtikarn 04/08/2014 ����¹ for �� foreach ��ШѴ array ���� ������������Է���Ҿ
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
	// @modify Phada Woodtiakrn 04/08/2014 ����¹ $prop �� array ���Ш��¡ style
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
		// @modify Phada Woodtikarn 19/07/2014 ����¹����¹� style ���
		if(isset($rs['bgcolor'])){
			// @modify Phada Woodtikarn 18/08/2014 ���� bgcolor_type ����Ѻ information port
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
		if (stristr($s,"#param$i#")){  // Parameter ������Ҩҡ������
			$s = str_replace("#param$i#", $_GET["param$i"],$s);
		}
		if (stristr($s,"#param$i-543#")){  // Parameter ������Ҩҡ������
			$s = str_replace("#param$i-543#", (intval($_GET["param$i"])-543),$s);
		}
	}
	return $s;
}

function ReplaceSpecialParam($s,$n,$nformat=1,$dec=1,$nblank=0){ //executive sum
	global $cvalue,$c,$startj,$imgpath,$cell;
	$s = ReplaceURLParam($s);
	if(stristr($s,"#delta#")){  // ����ͧ���� 3 �������
		$s = str_replace("#delta#", '<img src="'.$imgpath.'delta.png" border=0>',$s);
	}
	if(stristr($s,"#diff#")){  // Field ����Ҽŵ�ҧ�ͧ 2 Field ��͹���
		if($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$n-1])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$n-2])));
			$s = str_replace("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec,$nblank),$s);
		}else{
			$s = str_replace("#diff#", "0",$s);
		}
	}
	if(stristr($s,"#%diff#")){  // Field ����� % �ŵ�ҧ�ͧ 2 Field ��͹���
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
		if(stristr($s,"#%diff:$i#")){  // Field ����� % �ŵ�ҧ�ͧ 2 Field ��͹���
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
	//24/10/2548 ���� #total# �Ҽ�����ǹ͹
	if (stristr($s,"#total#")){  // ������ҧ�ǹ͹ (������ǡѹ)
		$sum = 0;
		for($j=$startj;$j<=$c;$j++){
			$sum += floatval(strip_tags(str_replace(",","",$cvalue[$j])));
		}
		$total = SetNumberFormat($sum,$nformat,$dec,$nblank);
		$s = str_replace("#total#", $total . "",$s);
	}
	if (stristr($s,"#@")){  // �ٵ�  #@2.2# +  #@3.2# 	
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
				//	 ��ǹ�ͧ caption �Ѻ itemname ���� #max::yy#
				$s = str_replace($funcname, "floatval(" . ($cell[$f1[0]][$f1[1]]) . ")",$s );
			}
		}
		// 8/4/2549
		$x = $s;
		// evaluate calculation
		// @modify Phada Woodtikarn 09/10/2014 ���������� tag ����˹� font ���
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

function ReplaceSpecialParam2($s,$n,$nformat=1,$dec=1){   // $cvalue �� array 2 �Ե� (�óբͧ ���º��º)
	global $cvalue,$m,$c,$startj,$imgpath;
	$s = ReplaceURLParam($s);
	if(stristr($s,"#delta#")){  // ����ͧ���� 3 �������
		$s = str_replace("#delta#", '<img src="'.$imgpath.'delta.png" border=0>',$s);
	}
	if(stristr($s,"#diff#")){  // Field ����Ҽŵ�ҧ�ͧ 2 Field ��͹���
		if($n > 2){
			$a = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-2])));
			$b = floatval(strip_tags(str_replace(",","",$cvalue[$m][$n-1])));
			$s = str_replace("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec),$s);
		}else{
			$s = str_replace("#diff#", "0",$s);
		}
	}	
	if(stristr($s,"#%diff#")){  // Field ����� % �ŵ�ҧ�ͧ 2 Field ��͹���
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
	//24/10/2548 ���� #total# �Ҽ�����ǹ͹
	if(stristr($s,"#total#")){  // ������ҧ�ǹ͹ (������ǡѹ)
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
// @modify Phada Woodtikarn 24/06/2014 ������������Ẻ normal ���� compare ����Ѻ param $m=0 ����
function GetCellSumValue($id,$sec,$cid,$json,$m=0){
// @end
	global $irs;
	global $popup;
	global $reportstyle;
	
	$irs = SearchCellInfo($sec,$cid);
	$val1 = "";
	if(isset($irs)){
		//$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);
		// @modify Phada Woodtikarn 24/06/2014 ��� m=0 ��� normal
		if($m==0){
			$val1 = ReplaceParam($irs['caption']);
		}else{
			$val1 = ReplaceXParam($irs['caption']); 
		}
		// @end
		if($irs['celltype'] == 1){
			// @modify Phada Woodtikarn 24/06/2014 ��� m=0 ��� normal
			if($m==0){
				$sql = ReplaceParam(str_replace(";","",$irs['cond'])); 
			}else{
				$sql = ReplaceXParam(str_replace(";","",$irs['cond'])); 
			}
			// @end
			$sql = ReplaceURLParam($sql); 
/*				$paramcond = GetParamCondition($sql);
			if ($paramcond != ""){
				if (!stristr($sql," where ")){  //�������� where
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
				// @modify Phada Woodtiakrn 15/07/2014 ������� exsum Ẻ sql set ����¹ format ��
				$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
				// @end
				
				//convert to number format
				if(is_numeric($xval)) {
					//$xval = floatval($xval);
					//$xval = 9999;
				}
			}else{
				// @modify Phada Woodtikarn 30/06/2014 ����ö���͡ target ��
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
			// @modify Phada Woodtikarn 15/06/2015 ���� title 
			$newUrl = GetTitle($iurl);
			$iurl = $newUrl[0];
			$urlTitle = $newUrl[1];
			// @end
			// @modify Phada Woodtikarn 09/09/2014 ���� popup
			if($irs['urltype'] == 4){
				if($popup == 0){
					$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);	
					echo $scriptPopUp;
				}
				$val1 = '<a class="result fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
			}else{
				// @modify Phada Woodtikarn 30/06/2014 ����ö���͡ target ��
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
		// @modify Phada Woodtikarn 13/08/2014 ���� blank value
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
// @modify Phada Woodtikarn 30/06/2014 ���������� Target link
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
// @modify Phada Woodtikarn 15/05/2015 ���� title link
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
// @modify Phada 28/07/2014 ���� pagination Ẻ �� query
function getLimit($page=1,$divide=0,$all=0){ //����Ѻ�� limit
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

function pagination($page=1,$divide=0,$all=0){ //��㹡����¹ style pagination 
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
    $prevlabel = "��͹��Ѻ";
    $nextlabel = "�Ѵ�";
    $val = '<div class="dataTables_wrapper">';
	$val .= '<div class="dataTables_paginate paging_simple_numbers">';
	if($page == 'all'){
		$val .= '<a href="?'.$paginationurl.'page=1" class="paginate_button all">��˹��</a>';
	}else{
		$val .= '<a href="?'.$paginationurl.'page=all" class="paginate_button all">�ʴ�������</a>';
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
// @modify Phada Woodtikarn 29/07/2014 ������ max min page
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
	if(isset($_GET['PDF'])){ // �ó� Export PDF
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
	// @modify Phada Woodtikarn 19/08/2014 ������Ѻ�ó� information background type �� fade color ������վ����ѧ����¹���բ��
	$trInfo['status'] = false;
	$trInfo['count'] = 0;
	$trInfo['value'] = '<style>.trInfo{background:#ffffff;}</style>';
	// @end
	// @modify Phada Woodtiakrn 19/07/2014 ������� skey �ҡ���� column ��� ���� ordercolumn �ҡ��õ�駤��
	if(!isset($_GET['skey'])){
		$_GET['skey'] = $reportinfo[0]['ordercolumn'];
		$skey = $reportinfo[0]['ordercolumn'];
		$sort_order[$skey] = $reportinfo[0]['ordertype'];
	}
	$maxcolumn = explode('x',$reportinfo[0]['tsize2']);
	$skey = intval($_GET['skey']);
	$Htable = strip_tags(GetCellSumValue($id,'H','1.1',''));
	if($Htable != '�ӴѺ'){
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
			if($Htable != '�ӴѺ' && $skey == 1){
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
		// @modify Phada Woodtikarn 28/07/2014 ���� url ����Ѻ pagination
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
		// @modify Phada Woodtikarn 26/06/2014 㹡ó� rtype = 3 �лԴ��ǵ��ҧ information ��� show parameter
		$temp_rtype = 0;
		if($rs['rtype'] == 3){
			$temp_rtype = 3;
			$rs['rtype'] = 0;	
			$rs['startcolumn'] = 0;
		}
		// @end
		//11/4/2549 ��§ҹẺ redirect
		if($rs['redirect']){
			header('Location: ' . $rs['reurl']);
			exit;
		}

		$refno = $rs['refno'];
		$keyincode = $rs['keyincode'];
		$createby = $rs['createby'];

		mysql_select_db($data_db_name);
		// @modify Phada Woodtikarn 01/07/2014 ��� count �͡�ҡ for �������᷹ ������������Է���Ҿ��÷ӧҹ
		$paramcount = count($paraminfo);
		$whereparam = '';
		// @end
		if($paramcount > 0){
			for ($param=1;$param <= $paramcount;$param++){ // ������ҡ 1 
				$prs = $paraminfo[$param - 1];

				$paramname[$param] = $prs['param'];
				$paramfield[$param] = $prs['dfield'];
				$paramcomment[$param] = $prs['comment'];
				// @modify Phada Woodtikarn 25/07/2014 ����ö��� function SQL � parameter ��
				$ffld = explode("(",$prs['dfield']);
				if(isset($ffld[1])){
					$ffld[1] =  substr($ffld[1], 0, strpos($ffld[1], ')'));
					$ffld[1] =  substr($ffld[1], 0, strpos($ffld[1], ','));
					$xfld = explode(".",$ffld[1]);
				}else{
					$xfld = explode(".",$prs['dfield']);
				}
				// @end
				// @modify Phada Woodtiakrn 01/07/2014 ���������ö �� param �������ҧ ��� ��� condition
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
				// ��Ǩ�ͺ����觤�� Parameter �ҡѺ URL
				if(isset($_GET[$paramname[$param]]) && $_GET[$paramname[$param]] > ""){
					$paramdefault[$param] = str_replace("'","",$_GET[$paramname[$param]]);
				}else{
					$paramdefault[$param] = $parammax[$param];
				}
				// ��Ǩ�ͺ����觤�� Parameter ��������º��º(���� parameter ��ͷ��´��� "_x" ) ����ҡѺ URL
				if(isset($_GET[$paramname[$param] . "_x"]) && $_GET[$paramname[$param] . "_x"] > ""){
					$xparamdefault[$param] = $_GET[$paramname[$param] . "_x"];

					// ������� �մ�ҹ��� ��ͧ�ҡ���Ҵ�ҹ����
					if ($xparamdefault[$param] < $paramdefault[$param]){
						$paramdefault[$param] = $xparamdefault[$param];
					}
				}else{
					$xparamdefault[$param] = $parammax[$param];
					// @modify Phada Woodtiakrn 28/07/2014 ��� && $_GET['rtype'] != 'normal' ���� ���������� paramdefault ����¹����ͧ
					if ((isset($_GET[$paramname[$param] . "_x"]) || $rs['rtype'] > 0 || $_GET['rtype'] == 'compare') && $_GET['rtype'] != 'normal'){  
					// @end
						// 23/3/2549 ������������͹� || $rs[rtype] > 0 || $_GET[rtype] == "compare"
						// 13/2/2549 ��ѭ�ҷ���һ� - 1
						if ($parammax[$param] != $parammin[$param]){ // ����դ�ҷ��ᵡ��ҧ
							$paramdefault[$param] = intval($parammax[$param]) - 1;
						}
					}  
				}
			}
		}
		// @modify Phada Woodtiakrn 01/07/2014 unset ��������������
		//$param = count($paraminfo);
		$param = $paramcount; //count �ͺ���Ǿ�
		unset($whereparam);
		// @end
		//Generate Condition from Parameter 
		$paramcond = "";
		if($param > 0){
			for ($i=1;$i<=$param;$i++){ //������ҡ 1
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
// ====== 9/3/2549 �Ѵ�������§ҹẺ compare ��� �����˹�����ǡѹ ========
//�� url ������
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
// @modify Phada Woodtikarn 31/07/2014 ���� style ˹����§ҹ
if(isset($rs['fontstyle'])){
	// @modfiy Phada Woodtikarn 08/09/2014 ���� parameter ��Ƿ���ͧ $rs['dateOfData']
	$reportstyle = getStylePreview($rs['fontstyle'],$rs['dateOfData']);
	// @end
}else{
	$reportstyle = getStylePreview('');
}
// @modify Phada Woodtikarn 13/08/2014 ������� export to excel 
if($reportstyle['ExportCo'] == 'true'){
	$excel_host = $_SERVER['HTTP_HOST'];
?>
<script src="http://<?php echo $excel_host; ?>/html2excel_service/js/jquery.html2excel.js"></script>
<?php
}
// @end 
// @modify Phada Woodtikarn 01/08/2014 ���� function ����Ŵ ��Ҵ font
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
// @modify Phada Woodtikarn 07/08/2014 ���� TH Sarabun PSK
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
// @modify Phada Woodtikarn 19/07/2014 ���� JS ����Ѻ Pagination 
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
	<?php // @modify Phada Woodtikarn 29/07/2014 ��������ʴ������� ?>
	$('#tablereportbuilder_all').click(function(){
		if($('select[name=tablereportbuilder_length]').val() == -1){
			$('select[name=tablereportbuilder_length]').val(<?php echo $rs['paginationrow'];?>);
			$('select[name=tablereportbuilder_length]').change();
			$('#tablereportbuilder_all').html('�ʴ�������');
		}else{
			$('select[name=tablereportbuilder_length]').val(-1);
			$('select[name=tablereportbuilder_length]').change();
			$('#tablereportbuilder_all').html('��˹��');
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
// @modify Phada Woodtikarn 19/07/2014 comment ��� ����͹���������
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
if($exportPDF != 'on'){ // �ó� Export PDF �� Export ੾����ǹ�ͧ������(Information) header
?>
<table id="reportbuilder" border="0" width="99%" cellspacing="0" cellpadding="0" align="center">
<?php
// @modify Phada Woodtikarn 01/08/2014 �������� ����Ŵ��Ҵfont
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
// @modify Phada Woodtikarn 23/06/2014 ������� GET ����Ѻ��͹ caption 
if(!isset($_GET['caption']) || $_GET['caption'] == "on"){
	if(trim($rs['caption']) != ''){
?>
<div align="center" style="padding-top:10px; padding-bottom:10px;">
	<?php // @modify Phada Woodtikarn 31/07/2014 ���� style ?>
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
// @modify Phada Woodtikarn 30/06/2014 ������ô�੾����ǹ Executive Summary 
if(!isset($_GET['sec']) || $_GET['sec'] == 'E' || $_GET['sec'] == ''){
// @end
?>
<table border="0" width="100%" cellspacing="0" cellpadding="5">
<tr valign="middle">
<td width="100%">
<table class="tableexsum" id="corner-exsummary" border="<?php echo $bcolor1;?>" width="100%" align="right" cellpadding="0" bordercolor="<?php echo $bcolor1;?>" style="background-color:<?php echo $bcolor1;?>; border-collapse:collapse; border:<?php echo $bsize1;?>px solid <?php echo $bcolor1;?>;">
<?php
$cell = array();
// @modify Phada Woodtiakrn 26/06/2014 ���¡�� �ѧ���� �������ö�� SQL Set Ẻ�Ѻ param ��
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
	$px = 100.00 / $c; // �������ҧ������
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
			//������ա�� set ��Ҥ������ҧ�������
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"E","1.$j");
				if($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = ' width="'.$xpx.'" ';
					if (strpos($xpx,"%")){
						$fwidth = str_replace("%","",$xpx); // �к����� % ��������
					}else{
						$fwidth = intval((  $xpx / (650 - $wx) ) * 100);
					}
				}else{
					$cwidth = "";  //����к�
					$fwidth = $cspan * $px;
				}

			}else{ // ����ա�á�˹���Ҥ������ҧ
				$cwidth = ' width="'.$px.'%" '; 
				$fwidth = $cspan * $px;
			}
			// 13/2/2549

			//�觤����� Flash
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
			// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
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
			// @modify Phada Woodtikarn 05/08/2014 ������á�˹� size �ͧ
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
// @modify Phada Woodtikarn 30/06/2014 �Դ��ǹ��ô�੾����ǹ Executive Summary 
}
// @end
//<!-- END Executive Summary -->
?>
<?php
// start Executive Summary, ��§ҹ��ѹ���, �����ų�ѹ���, export
if($reportstyle['VisibleEx'] == 'true' || $reportstyle['VisibleDA'] == 'true' || $reportstyle['VisibleRA'] == 'true' || $reportstyle['ExportCo'] == 'true' || $reportstyle['PDFCo'] == 'true'){
?>
<BR>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
	<tr>
        <td>
			<?php
            // @modify Phada Woodtikarn 21/06/2014 ��� comment �Ѻ defin MAIN_RPT �͡
			if(!isset($_GET['executive'])){
				$_GET['executive'] = 'on';
			}
            if($_GET['executive'] != 'off' && $reportstyle['VisibleEx'] == 'true'){
				// @modify Phada Woodtikarn 08/08/2014 ����ö���͡������ executive summary �� Ẻ������ Ẻflash
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
			// @modify Phada Woodtikarn 08/09/2014 ���� ������ � �ѹ���
			if($reportstyle['VisibleDA'] == 'true'){
				$dateOfData = GetQueryValue(ReplaceParam($reportstyle['SQLDA']));
				if(is_null($dateOfData)){
					$dateOfData = date_eng2thai(date('Y-m-d'),543);			
				}else{
					$dateOfData = date_eng2thai($dateOfData,543);
				}
            ?>
            <span class="dataat" style="font-size:<?php echo $reportstyle['FontSizeDA'] ?>px;color:<?php echo $reportstyle['FontColorDA'] ?>;">������ � �ѹ��� <?php echo $dateOfData;?></span><br/>
            <?php
            }
			// @end
            // @modify Phada Woodtikarn 27/06/2014 ����ö�Դ��§ҹ � �ѹ�����
			if(!isset($_GET['reportat'])){
				$_GET['reportat'] = 'on';
			}
            if($_GET['reportat'] != 'off' && $reportstyle['VisibleRA'] == 'true'){
            ?>
            <span class="reportat" style="font-size:<?php echo $reportstyle['FontSizeRA'] ?>px;color:<?php echo $reportstyle['FontColorRA'] ?>;">��§ҹ � �ѹ��� <?php echo intval(date('d')).' '.$monthname[intval(date('m'))].' '.(date('Y')+543);?></span><br/>
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
                // @modify Phada Woodtikarn 21/06/2014 ���comment compare �͡
                if($rs['rtype'] >= 1){ //�� compare
                    if($_GET['rtype'] == "normal"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">��§ҹ���º��º</a>';
                    }else{
                        echo '<a class="rtype" href="?'.$allurl.'rtype=normal" style="'.$fontRC.'float:right;">��§ҹẺ����</a>';
                    }
                }else if($rs['rtype'] == 0 && $temp_rtype != 3){ //�� normal
                    if($_GET['rtype'] == "normal"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">��§ҹ���º��º</a>';
                    }else if($_GET['rtype'] == "compare"){
                        echo '<a class="rtype" href="?'.$allurl.'rtype=normal" style="'.$fontRC.'float:right;">��§ҹẺ����</a>';
                    }else{	
                        echo '<a class="rtype" href="?'.$allurl.'rtype=compare" style="'.$fontRC.'float:right;">��§ҹ���º��º</a>';
                        //$_GET['rtype'] = "normal";	
                    }
                }
                // @end
				unset($fontRC);
            // ====== 9/3/2549 �Ѵ�������§ҹẺ compare ��� �����˹�����ǡѹ ========
            }
        	?>
        </td>
    </tr>
    <tr>
    	<td align="right" colspan="2">
        	<?php 
            // @modify Phada Woodtikarn 04/04/2015 ������� export to PDF
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
            // @modify Phada Woodtikarn 13/08/2014 ������� export to excel
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
// end Executive Summary, ��§ҹ��ѹ���, �����ų�ѹ���, export
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
// @modify Phada Woodtikarn 30/06/2014 ������ô�੾����ǹ Information 
if(!isset($_GET['sec']) || $_GET['sec'] == 'H' || $_GET['sec'] == 'I' || $_GET['sec'] == ''){
// @end
	$reportAt = intval(date('d')).' '.$monthname[intval(date('m'))].' '.(date('Y')+543); // ��§ҹ � �ѹ���
?>
<?php if($exportPDF == 'on'){ // �ó� Export PDF ������ Caption ���ʴ���͹���ҧ Information ?>
<div align="center" style="padding-top:10px; padding-bottom:10px;">
	<span class="caption" style="font-size:16px;color:<?php echo $reportstyle['FontColorCa'] ?>;">
	<?php echo ReplaceParam($rs['caption']); ?>
    </span><br>
    <div class="reportat" style="width:100%;text-align:right;font-size:12px;color:<?php echo $reportstyle['FontColorRA'] ?>;">��§ҹ � �ѹ��� <?php echo $reportAt; ?></div>
</div>
<?php } ?>
<table class="tableinfo" id="tablereportbuilder" border="<?php echo $bsize2;?>" width="100%" align="center" cellpadding="2" bordercolor="<?php echo $bcolor2;?>" style="background-color:<?php echo $bcolor2;?>; border-collapse:collapse; border:<?php echo $bsize2;?>px solid <?php echo $bcolor2;?>; display: none;">
<thead>
<?php if($exportPDF != 'on'){ ?> 
	<tr><td colspan="<?php echo $maxcolumn[1] ?>" style="display:none;"><?php echo ReplaceParam($rs['caption']); ?></td></tr>
    <tr><td colspan="<?php echo $maxcolumn[1] ?>" style="display:none;">��§ҹ � �ѹ��� <?php echo $reportAt; ?></td></tr>
<?php } ?>
<?php
if($rs['table2'] != ''){
// 26/11/2548 ���� parameter ���͡�� ���º��º
if ($_GET['rtype'] == "compare"){
	if ($rs['rtype'] == 0 && $temp_rtype != 3){ //�ҡ�������� normal
		$rs['rtype'] = 2;   // Overide to comparision report type 2 (no diff) 
	}
}else if ($_GET['rtype'] == "normal"){
	if ($rs['rtype'] != 0){ //�ҡ����������� normal
		$rs['rtype'] = 0;   // Overide to normal report
	}
}
ParseTable($rs['table2'],$rs['tsize2']);
$startcolumn = intval($rs['startcolumn'] - 1);
if ($startcolumn < 0){
	$startcolumn = 0;
}
//����� parameter
// @modify Phada Woodtikarn 26/06/2014 ����觵���� rtype = 3 �� �лԴ ��ǵ��ҧ���ʴ��� parameter
if($temp_rtype != 3){
// @end
	for($i=1;$i<=$param;$i++){
		// @modify Phada Woodtikarn 26/07/2014 ����Ҩ�����ʴ� parameter �������Ѻ hearder ���ҧ����
		if(isset($showparam[$i])){
		// @end
			$nrow = $param+$r;  
			echo '<tr bgcolor="#b8b8b8">';
			if ($i==1){ //੾�к�÷Ѵ�á
				for ($n1=0;$n1<$startcolumn;$n1++){
					// @modify Phada Woodtikarn 26/06/2014 ���� property ����˹�
					// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
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
					// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
					echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
					// @end
				}else{
					// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
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
						// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
						echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'='.(intval($paramdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}else{
						// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
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
							$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&"; // prameter ����
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
							// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
							echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) - 1).'"><img src="'.$imgpath.'back.jpg" border="0"></a>';
							// @end
						}else{
							// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
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
						// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
						echo '<a href="?id='.$id.'&rtype='.$_GET['rtype'].'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}else{
						// @modify Phada Woodtikarn 26/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
						echo '<a href="?id='.$id.'&'.$px1.$paramname[$i].'_x='.(intval($xparamdefault[$i]) + 1).'"><img src="'.$imgpath.'next.jpg" border="0"></a>';
						// @end
					}
				}
				echo "</td></tr></table></td>";
				// ���º��º
				//if ($rs[rtype] == 1 && $_GET[rtype] != "compare"){ // Comparision Report ��ҹ�� rtype == 2 ����ʴ�
				if($rs['rtype'] == 1){ // Comparision Report ��ҹ�� rtype == 2 ����ʴ�
					if($i == 1) {  //�ʴ�੾�� parameter �á ��������ӫ�͹
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
	} //end for ����� para
// @modify Phada Woodtikarn 26/06/2014 endif temp_rtype != 3
}
// @end
// ��÷Ѵ����� Header 
$px = intval(100 / $c); // �������ҧ������
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
			// @modify Phada Woodtikarn 16/09/2014 ������� order ($rspan + $i - 1) == $r 㹡óշ�� marge rowspan
			if(($i == $r || ($i == 1 && $j == $startcolumn )) || ($rspan + $i - 1) == $r && $allowsort){
			// @end
				if(!isset($sort_order[$j])) $sort_order[$j] = "asc";
				// @modify Phada Woodtikarn 19/07/2014 ����Դ pagination ������� order �ͧ datatable.js ᷹
				if($rs['pagination'] != 1){
					if (trim(strip_tags($cellvalue)) != "�ӴѺ"){  //17/4/2549
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
                // @modify Phada Woodtikarn 26/06/2014 ����觵���� rtype = 3 �� �лԴ ��ǵ��ҧ���ʴ��� parameter
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
			//������ա�� set ��Ҥ������ҧ�������
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"H","1.$j");
				if ($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = ' width="'.$xpx.'" ';
				}else{
					$cwidth = "";  //����к�
				}
			}else{ // ����ա�á�˹���Ҥ������ҧ
				$cwidth = ' xxwidth="'.$px.'%" ';  //auto ����Ѻ header
			}
			// 13/2/2549

			// 18/10/2013
			$hrs = SearchCellInfo('H',$i.'.'.$j);
			if(isset($hrs)){
				if(isset($hrs['bgcolor']) && $hrs['bgcolor']){
					$bcolor = $hrs['bgcolor'];
				}
			}
			// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
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
		for($j=$startcolumn+1;$j<=$c;$j++){   // ����� Cell ����к�� startcolumn
			$cvalue[$j] = 0;
			$x = explode("x",$tspan[$i-1][$j-1]);
			$rspan = intval($x[0]);
			$cspan = intval($x[1]);
			if($rspan > 0 && $cspan > 0){
				// @modify Phada Woodtikarn 24/06/2014 ���� param 1 ����
				$cellvalue = GetCellSumValue($id,"H",$i . "." . $j,$json,1);
				// @end
				$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
				$cvalue[$j] = $cellvalue;
				//sorting
				if(($i == $r || ($i == 1 && $j == $startcolumn )) && $allowsort ){
					$nxx = $c + $j - 1;
					if(!isset($sort_order[$j])) $sort_order[$j] = "asc";
					// @modify Phada Woodtikarn 19/07/2014 ����Դ pagination ������� order �ͧ datatable.js ᷹
					if($rs['pagination'] != 1){
						if($skey == $c + $j - 1){
							//$cellvalue .= " <img src='$imgpath/down1.gif' border=0>";
							//$cellvalue = "<u>$cellvalue</u>";
							if($sort_order[$j] == "asc"){
								// @modify Phada Woodtikarn 27/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&desc"><img src="'.$imgpath.'sort-asc.gif" border="0"></a>';
								// @end
							}else{
								// @modify Phada Woodtikarn 27/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
								$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&asc"><img src="'.$imgpath.'sort-desc.gif" border="0"></a>';
								// @end
							}
						}else{
							// @modify Phada Woodtikarn 27/06/2014 ��� target='_parent' �͡ ���ж�����¡��§ҹ�iframe ���ջѭ��
							$cellvalue = $cellvalue.' <a href="?'.$paramnosort.'&skey='.$nxx.'&asc"><img src="'.$imgpath.'sort.gif" border="0"></a>';
							// @end
						}
					}
					// @end
				}
				// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
				$getstyle = GetCellProperty2($id,'H',$i.'.'.$j);
				// @end
	?>
	<td <?php echo $getstyle[0]; ?> xxxwidth="<?php echo $px;?>%" colspan="<?php echo $cspan;?>" rowspan="<?php echo $rspan;?>" style="border-collapse:collapse; border:<?php echo $bsize2;?>px solid <?php echo $bcolor2;?>;<?php echo $getstyle[1]; ?>">
		<?php echo $cellvalue;?>
	</td>
	<?
			}
		} //for
// ����ͧ�ʴ����ǹ�ͧ Header ���� ���� �� rowspan �Ҩҡ��÷Ѵ��
		// ���º��º
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

$px = intval(100 / $c); // �������ҧ������
//INFORMATION
$i = 1;
$nrow = 0;

$cvalue = array();
$csum = array();
$xfld = explode(".",$rs['fldname']);
// 23/10/2548
// ��Ǩ�ͺ����繡�ô֧�����Ũҡ tmp_report ������� �ҡ�Ҩҡ tmp_report ����ͧ�֧�����Ũ�ԧ� 
// ����� include file �ӧҹ᷹ �´֧ summary ����ŧ array �����������
if($xfld[0] == "tmp_report"){
	$tablestyle = 1; // tmp_report
}else{
	$tablestyle = 0;  //actual table
}

//24/10/2548 
//�ѧ�Ѻ�����ҹ�ҡ tmp_report ���͡�� DEMO
//$tablestyle = 0;  //actual table
if($rs['rtype'] == 0){
	$nround = 0;   // �ͺ����
}else if($rs['rtype'] == 1 ){
	$nround = 2;   // 3 �ͺ  (0-2)
}else{
	$nround = 1;   // 2 �ͺ  (0-1)
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
		// @modify Phada Woodtikarn 28/07/2014 ���� �Ҩӹǹ record ������Ѻ��˹��
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[2].') FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]);
		}
		// @end
	}else{
		$sql = 'SELECT * FROM '.$xfld[0].' ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 ���� �Ҩӹǹ record ������Ѻ��˹��
		if($rs['pagination'] == 2){
			$sqlrecord = 'SELECT COUNT('.$xfld[1].') FROM '.$xfld[0];
		}
		// @end
	}
}else{
	// @modify Phada Woodtikarn 26/07/2014 ���� �ó� ��§ҹẺ���º��º �������ö���º��ºẺ ����Ẻ field ��
	if($count_arr_fldname >= 3){
		$sql = 'SELECT * FROM '.ReplaceParam($xfld[0].'.'.$xfld[1]).'
					 WHERE '.ReplaceParam(ReplaceSpecialParam($rs['cond'],0)).' 
					 ORDER BY '.$fldorder;
		// @modify Phada Woodtikarn 28/07/2014 ���� �Ҩӹǹ record ������Ѻ��˹��
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
		// @modify Phada Woodtikarn 28/07/2014 ���� �Ҩӹǹ record ������Ѻ��˹��
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
// @modify Phada 28/07/2014 ���� pagination Ẻ �� query
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
// �֧�����Ũҡ RecordSet �ҡ Array ���� �ҡ ResultSet
// 23/10/2548 �����������Ѻ tmp_report �� ������ͧ�红�����ŧ���ҧ��ԧ
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
		include $rs['pinclude'];  //��� include file �ӡ�ô֧��������ŧ $tmp_rs
	}
	$mresult = @array_reverse($tmp_rs); //��ҵ�����Ҩҡ array �������� include file ���� reverse ���� pop �͡�� 
}else{  // actual query
	$mresult = mysql_query($sql);
	// @modify Phada Woodtikarn 26/07/2014 ���� �ó� ��§ҹẺ���º��º �������ö���º��ºẺ ����Ẻ field ��
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
// @modify Phada Woodtikarn 26/06/2014 �� SQL set Ẻ���º��º����
for($m=0;$m<=$nround;$m++){
	if($m == 0){
		// @modify Phada Woodtikarn 11/09/2014 ���� paramter ��Ƿ����� return SQL
		$jsonSQL = GetJSON('I','','true');
		// @end
	}else{
		// @modify Phada Woodtikarn 11/09/2014 ���� paramter ��Ƿ����� return SQL
		$json_compareSQL[$m] = GetJSON('I',$m,'true');
		// @end
	}
}
// @end
// @modify Phada Woodtikarn 23/07/2014 �� Key Field �������� loop �����ӧҹ���
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
	// @modify Phada Woodtikarn 19/08/2014 ������Ѻ�ó� information background type �� fade color ������վ����ѧ����¹���բ��
	if($trInfo['status'] == true && $trInfo['count'] == 0){
		echo $trInfo['value'];
		$trInfo['count']++;
	}
	// @end
//	if ($n % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
//FOR SORTING (28/10/2548)
	// @modify Phada Woodtikarn 19/08/2014 ���� class trInfo
	$rowtext[$n] .= '<tr class="trInfo" bgcolor="#IBG#" valign="top">';
	// @end
	for($m=0;$m<=$nround;$m++){   // �� 3 �ͺ����Ѻ Comparision
		if($m == 0){ //�ͺ�á�������� 1 , �ͺ��� 2,3 �������� startcolumn
			// @modify Phada Woodtikarn 11/09/2014 ���� �����ҹ SQL-set ���ǹinformation
			if($jsonSQL != ''){
				$json = GetResultJSON($jsonSQL,$mrs[$xfldkey[1]]);
			}
			// @end
			$startj = 1;  
		}else{
			// @modify Phada Woodtikarn 11/09/2014 ���� �����ҹ SQL-set ���ǹinformation
			if($jsonSQL != ''){
				$json_compare[$m] = GetResultJSON($json_compareSQL[$m],$mrs[$xfldkey[1]]);
			}
			// @end
			$startj = $startcolumn+1;  
		}
		for($j=$startj;$j<=$c;$j++){  //���� Column
			// ત��� ����� N/A �������ء row ����� column �������� (23/3/2549)
			if(!isset($is_all_na[$m][$j])) $is_all_na[$m][$j] = true; // �������� n/a ����͹
			
			$cvalue[$m][$j] = 0;
			
			if(!isset($csum[$m][$j])) $csum[$m][$j] = 0;
			
			//echo "<td " . GetCellProperty2($id,"I","1." . $j) . " width='$px%' colspan='1' rowspan='1'>";
			//�Ѻ column
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

				// �� original value �ͧ���� (28/10/2548)
				$cellvalue[$n][$column] = $xval;

//SORTING (28/10/2548)
//				// #no# ����Ţ�ʴ��ӴѺ
//				$val1 = eregi_replace ("#no#", "$n",$val1);
				
				if($rs['rtype'] >= 1 && $m == 2){  // �ҡ �� Comparision column ੾�� rtype == 1 ��ҹ�� Ẻ��� == 2 ����ʴ�
					$a = floatval(strip_tags(str_replace(",","",$cvalue[1][$j])));
					$b = floatval(strip_tags(str_replace(",","",$cvalue[0][$j])));
					if($a != 0){
						// �� original value �ͧ���� (28/10/2548)
						$cellvalue[$n][$column] = @(($a - $b)/$b) * 100.00;

						$val1 = SetNumberFormat(@(($a - $b)/$b) * 100.00,1,1);
					}else{
						// �� original value �ͧ���� (28/10/2548)
						$cellvalue[$n][$column] = "";
						$val1 = "0";
					}
					$cvalue[$m][$j] = $val1;
				}else if($irs['celltype'] == 1){  //Database
					$sql = str_replace(";","",$irs['cond']); 
					$xfld = explode(".",$rs['fldname']);
					if(count($xfld)>=3){
						$sql = str_replace("#key#",$mrs[$xfld[2]] ,$sql);   //᷹��Ңͧ parameter ����� Keyfield ŧ� SQL Query
					}else{
						$sql = str_replace("#key#",$mrs[$xfld[1]] ,$sql);   //᷹��Ңͧ parameter ����� Keyfield ŧ� SQL Query
					}
					// 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
					if(stristr($sql,"#fld:")){
						foreach($mrs as $fieldname1 => $fieldvalue1){
							$find_param = find_keywords("#fld:",$sql);
							if($find_param == true){
								$sql = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$sql);   //᷹��Ңͧ parameter ����繤��� field ŧ� SQL Query
							}else{
								break;
							}
							
						}
					}
	/*�� #paramname-1# ᷹ �֧��ͧ�к� Parameter �ͧ�ء sql*/
	/*				$paramcond = GetParamCondition($sql);
					if ($paramcond != ""){
						if (!stristr($sql," where ")){  //�������� where
							$sql .= " where $paramcond ";
						}else{
							$sql = eregi_replace (" where ", " where $paramcond and ",$sql);;
						}
					}
	*/
					if($m == 0){ // �ͺ�á ���� ���������§ҹ������º��º
						$sql = ReplaceParam($sql);
					}else{
						$sql = ReplaceXParam($sql);
					}
					$sql = ReplaceURLParam($sql); 
					if (isset($_GET['debug'])){
						echo 'Information DB: '.$sql . '<br>';
					}
					$xval = GetQueryValue($sql);
					// �� original value �ͧ���� (28/10/2548)
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
					// @modify Phada Woodtikarn 26/07/2014 ������������ö �� ���º��º��
					$xfld = explode(".",$irs['cond']);
					// @modify Phada Woodtikarn 16/09/2014 ��ҡó����¡��� �������Ͱҹ������
					$countxfld = count($xfld);
					if($countxfld == 3){
						$xfld[0] = $xfld[1];
						$xfld[1] = $xfld[2];
					}
					// @end
					if($m == 0){
						if(isset($xfld[1]) && isset($mrs[$xfld[1]])){
							$xval = $mrs[$xfld[1]];   //��Ҥ�Ҩҡ� record �Ѩ�غѹ
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
					// �� original value �ͧ���� (28/10/2548)
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
					// �� original value �ͧ���� (28/10/2548)
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
					// @modify Phada Woodtikarn 12/09/2014 �� keyField
					//$keyField = $mrs[$xfld[1]];
					$keyField = $mrs[$xfldkey[1]];
					// @end
					// @modify Phada Woodtikarn 26/06/2014 ���º��º��
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
					// �� original value �ͧ����
					$cellvalue[$n][$column] = $xval;
					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					// @modify Phada Woodtikarn 24/09/2014 ���� SetNumberFormat
					$xval = SetNumberFormat($xval,$irs['nformat'],$irs['decpoint'],$irs['nblank']);
					if($groupitem){
						$val1 .= '<b>'.$xval.'</b>';
					}else{
						$val1 .= $xval;
					}
					// @end
				}
				if($irs['font']){
					// @modify Phada Woodtikarn 25/07/2014 ���������ö�֧ css �ҡ filed 㹰ҹ��������
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
				if($irs['url'] && $exportPDF != 'on'){ // �ó� Export PDF ��ź link �͡
					$iurl = $irs['url'];
					$iurl = str_replace("#key#",$mrs[$xfldkey[1]] ,$iurl);   //᷹��Ңͧ parameter ����� Keyfield ŧ� SQL Query
					// @modify Phada Wooditkarn 23/07/2014 ������� replace #fld:
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
					// @modif Phada Woodtikarn 23/07/2014 comment ��� ����͹������������ǹ�ͧ url
					// 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
					/*if (stristr($sql,"#fld:")){
						foreach ($mrs as $fieldname1 => $fieldvalue1){
							$sql = str_replace('#fld:'.$fieldname1.'#',$fieldvalue1,$sql);   //᷹��Ңͧ parameter ����繤��� field ŧ� SQL Query
						}
					}*/
					// @end
					$iurl = ReplaceParam($iurl);
					$iurl = str_replace("#value#", $val1, $iurl);
					// @modify Phada Woodtikarn 15/06/2015 ���� title 
					$newUrl = GetTitle($iurl);
					$iurl = $newUrl[0];
					$urlTitle = $newUrl[1];
					// @end
					
					// @modify Phada Woodtikarn 09/09/2014 ���� popup
					if($irs['urltype'] == 4){
						if($popup == 0){
							$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);	
							echo $scriptPopUp;
						}
						$val1 = '<a class="resultinfo fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
					}else{
						// @modify Phada Woodtikarn 30/06/2014 ����ö���͡ target ��
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
			//��Ǩ�ͺ��� ����� N/A �������ء row ����� column ������� ���� N/A ������ ��ͧ sum ��  N/A ����� 0
			if(strip_tags ($val1) != "0" ){
				$is_all_na[$m][$j] = false; //�ҡ���ѹ��ѹ˹������� �����Ҽ������ͧ����� N/A 
			}
			if(strip_tags ($val1) == "0" ){
				// $val1="N/A";
				//$is_all_na[$m][$j] =true;
			}
			// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
			// @modify Phada Woodtikarn 18/08/2014 ��������� ����Ѻ bgcolor_type
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
// @modify Phada Woodtikarn 24/07/2014 ���� $rs['pagination'] != 1 ������ӧҹ������ա����ҹ pagination ���� �դ�������ö order ��������
if($allowsort && $rs['pagination'] != 1){
// @end
	$keycol = $skey;  //column ������§
	if(isset($cellvalue[1])){
		$countcellvalue = count($cellvalue[1]);
	}else{
		$countcellvalue = 0;
	}
	if($keycol >= 1 && $keycol <= $countcellvalue){  //����� scope
		if(is_numeric($cellvalue[1][$keycol])){
			$number_compare = true;
		}else{
			$number_compare = false;
		}
		for($k=1;$k<$n;$k++){
			for($j=$k+1;$j<=$n;$j++){
				if($sort_order[$keycol] == "asc"){ //������ҡ
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
				}else{ // �ҡ仹���
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
//�ʴ���
for($k=1;$k<=$n;$k++){
	// @modify Phada 28/07/2014 ���� pagination Ẻ �� query ������ͧ���§�ӴѺ����
	if($rs['pagination'] == 2 && $_GET['page'] != 'all'){
		$autonumber = (($_GET['page']-1) * $rs['paginationrow']) + $k;
		$rowtext[$k] = str_replace("#no#", "$autonumber" ,$rowtext[$k]);  //᷹����ӴѺ���
	}else{
		$rowtext[$k] = str_replace("#no#", "$k" ,$rowtext[$k]);  //᷹����ӴѺ���
	}
	// @end
	if($k % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
	$rowtext[$k] = str_replace("#IBG#", "$ibg" ,$rowtext[$k]);  //᷹����� Background
	echo $rowtext[$k];
}
?>
</tbody>
<?php if($exportPDF != 'on'){  // �ó� Export PDF �� �Դ tag tfoot ?>
<tfoot>
<?php } ?>
<?php
//SUMMARY
echo '<tr bgcolor="#b8b8b8" valign="top">';
for($m=0;$m<=$nround;$m++){   // �� 3 �ͺ����Ѻ Comparision
	if($m == 0){ //�ͺ�á�������� 1 , �ͺ��� 2,3 ��������  startcolumn
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
				if($rs['rtype'] >= 1 && $m == 2) {  // �ҡ �� Comparision column   Ẻ��� rtype == 1 ��ҹ�� ==2 ����ʴ�
					$a = floatval(strip_tags(str_replace(",","",$cvalue[1][$j])));
					$b = floatval(strip_tags(str_replace(",","",$cvalue[0][$j])));
					if($a != 0){
						$val1 = SetNumberFormat(@(($a - $b)/$b) * 100.00,1,1);
					}else{
						// @modify Phada Woodtikarn 30/06/2014 ����ö���͡ target ��
						//$val1 = "";
						$val1 = SetNumberFormat('','','',$irs['nblank']);
						// @end
					}
					$cvalue[$m][$j] = $val1;
				}else if($irs['celltype'] == 1){
					$sql = str_replace(";","",$irs['cond']);
	/*				$paramcond = GetParamCondition($sql);
					if ($paramcond != ""){
						if (!stristr($sql," where ")){  //�������� where
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
						if(isset($is_all_na[$m][$j]) && $is_all_na[$m][$j] != ""){ //	�ҡ�ء row � column ����� N/A ������ 23/3/2549
							$cvalue[$m][$j] = "0";
							$xval = "0";
						}else{
							if(isset($csum[$m][$j])){
								$cvalue[$m][$j] = $csum[$m][$j];
								$xval = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']); // ��Ҥ�� sum �ͧ field ����� �ҡ����ա�á�˹����
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
					// @modify Phada Woodtikarn 15/06/2015 ���� title 
					$newUrl = GetTitle($iurl);
					$iurl = $newUrl[0];
					$urlTitle = $newUrl[1];
					// @end
					
					// @modify Phada Woodtikarn 09/09/2014 ���� popup
					if($irs['urltype'] == 4){
						if($popup == 0){
							$scriptPopUp = GetPopUp($reportstyle['WidthPU'],$reportstyle['HeightPU'],$reportstyle['TopPU']);
							echo $scriptPopUp;
						}
						$val1 = '<a class="resultinfo fancybox fancybox.iframe" href="'.$iurl.'" title="'.$urlTitle.'">'.$val1.'</a>';
					}else{
						// @modify Phada Woodtikarn 30/06/2014 ����ö���͡ target ��
						$itarget =  GetTarget($irs['urltype']);
						$val1 = '<a class="resultinfo" href="'.$iurl.'" target="'.$itarget.'" title="'.$urlTitle.'">'.$val1.'</a>';
						// @end
					}
					// @end
				}
			}else{ // ����բ������Ź�� 
				if(isset($csum[$m][$j])){
					$val1 = SetNumberFormat($csum[$m][$j],$irs['nformat'],$irs['decpoint'],$irs['nblank']); // ��Ҥ�� sum �ͧ field ����� �ҡ����ա�á�˹����
				}
				//global $n;
				//$val1 = round($val1/$n, 2); average sum count avg
				//$val1 = SetDecimal($val1/$n,1);
			}
			// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
			$getstyle = GetCellProperty2($id,'I','2.'.$j,strip_tags($val1));
			// @end
			echo '<td '.$getstyle[0].' colspan="1" rowspan="1" style="border-collapse:collapse; border:'.$bsize2.'px solid '.$bcolor2.';'.$getstyle[1].'">';
			echo $val1;
			echo "</td>";
	}
}
echo "</tr>";
} //Sum �����
?>
<?php if($exportPDF != 'on'){  // �ó� Export PDF �� �Դ tag tfoot ?>
</tfoot>
<?php } ?>
</table>
<?php
if($exportPDF != 'on'){ // �ó� Export PDF �� Export ੾����ǹ�ͧ������(Information) footer
// @modify Phada 28/07/2014 ���� pagination Ẻ �� query
if($rs['pagination'] == 2){
	echo pagination($_GET['page'],$rs['paginationrow'],$findrecord);
}else if($rs['pagination'] == 1){
	// @modify Phada 28/07/2014 ���� ����ʴ�������
	echo '<div class="dataTables_wrapper" style="display: initial;"><div class="dataTables_paginate"><a class="paginate_button all" id="tablereportbuilder_all">�ʴ�������</a></div></div>';
	// @end
}
// @end
?>
<?php
// @modify Phada Woodtikarn 30/06/2014 �Դ��ǹ��ô�੾����ǹ information
}
// @end
// <!-- END INFORMATION PORT -->
?>
<BR>
<?php
// <!-- FOOTNOTE -->
// @modify Phada Woodtikarn 30/06/2014 ������ô�੾����ǹ Footnote
if(!isset($_GET['sec']) || $_GET['sec'] == 'F' || $_GET['sec'] == ''){
// @end
?>
<table class="tablefootnote" border="0" width="100%" align="center" cellpadding="0" bordercolor="<?php echo $bcolor4;?>" style="background-color:#b8b8b8;border-collapse:collapse; border:<?php echo $bsize4;?>px solid <?php echo $bcolor4;?>;">
<?php
ParseTable($rs['table4'],$rs['tsize4']);
$cvalue = array();   //clear array
$px = intval(100 / $c); // �������ҧ������
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
			//������ա�� set ��Ҥ������ҧ�������
			if(isset($rs['cwidth1']) && isset($rs['cwidth2']) && isset($rs['cwidth3']) && isset($rs['cwidth4'])){
				$xpx = ReportGetColumnWidth($id,"F",'1.'.$j);
				if($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = ' width="'.$xpx.'"';
				}else{
					$cwidth = "";  //����к�
				}
			}else{ // ����ա�á�˹���Ҥ������ҧ
				$cwidth = ' width="'.$px.'%" '; 
			}
			// 28/12/2548
			// @modify Phada Woodtikarn 04/08/2014 ����¹��� return GetCellProperty2 �� array
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
// ��Ҥ�� parameter �ŧ�繵����
for($param=1;$param <= $paramcount;$param++){ // ������ҡ 1 
	$xx = '$' . str_replace("#","",$paramname[$param]) . "='" . $paramdefault[$param] . "';";
	eval($xx);
}
// @modify Phada Woodtikarn 25/06/2014 ��������������� @ �͡
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
// @modify Phada Woodtikarn 30/06/2014 �Դ��ǹ��ô�੾����ǹ Footnote
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
