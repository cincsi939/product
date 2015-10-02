<?
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
	10/6/2549 - ���� #pvname#
					- ��Һ�÷Ѵ��ҧ �ͧ footnote �͡ (����ʴ�)
	24/6/2549 - parameter mm / month �ʴ��繪�����͹
	7/7/2549	- �ӹǹ #%diff# �� (��һբ�� - ��һի���) / ��һի���  (��÷Ѵ 341 ��� 419)
	16/8/2549 - ��÷Ѵ 1364 �� %diff ���ǹ infomation port
	17/8/2549 - ��÷Ѵ 1636 �� %diff ���ǹ infomation port (summary)
	18/8/2549	- ��䢢��� handle param0 - 10 ���ǹ�ͧ compare report
	5/9/2549	- ��䢡�èѴ column width ���ǹ�ͧ ��§ҹ���º��º
	5/9/2549	- ����͹ parameter ���������ѹ�á ���ҧ�����
					- ����͹ parameter �����ҡ���� 1 �� (��˹�� step �ͧ parameter) / ��ͧ���� field step (int) ��� paraminfo
	11/9/2549	- ��Ѻ����§ҹ�ͧ temp report ����ա�����º��º �������� tmp_rs_x ᷹ tmp_rs
	10/10/2549 - ��Ѻ %diff ��� x ��зӡѺ N/A �� N/A
*****************************************************************************/

$default_bg_color = "#A3B2CC"; // �����
//$default_bg_color = "#CBD8AC"; // �ӻҧ

if (file_exists("report.db.inc.php")){
	@require_once "report.db.inc.php";
}else{
	@require_once "../../common/report.db.inc.php";
}

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");

if ($prov_name){
	echo " <B>�ѧ��Ѵ $prov_name</B><br>";
}

if (!isset($_GET[skey])){
	$_GET[skey] = 0;
	$skey = 0;
}

//echo "$dbname";
//$pvcode = array('','22','20','23','21'); // ���ʨѧ��Ѵ (������ҡ 1) / �ѹ����� / �ź��� / ��Ҵ / ���ͧ ���§�������ѡ��

$pvcode = array('','20','21','22','23'); // ���ʨѧ��Ѵ (������ҡ 1) / �ź��� / ���ͧ / �ѹ����� / ��Ҵ => 5/1/2549

function ReportGetColumnWidth($rid,$sec,$cellno){
global $rs;
	$x = explode(".",$cellno);
	$col = $x[1];

	// H,E,I,F
	if ($sec == "H"){
		$xwidth = $rs[cwidth1];
	}else if ($sec == "E"){
		$xwidth = $rs[cwidth2];
	}else if ($sec == "I"){
		$xwidth = $rs[cwidth3];
	}else {
		$xwidth = $rs[cwidth4];
	}

	$cwidth = "";
	$x=explode("|",$xwidth); //���� column ��蹴��� |
	$cwidth = $x[$col - 1]; // ���੾�е�Ƿ���˹��ҡ��ҵ����ѧ�ͧ cellno

	return htmlspecialchars($cwidth);
}

function GetParamCondition($sql){
global $param,$paramname,$paramdefault,$paramfield;

	$paramcond="";
	if ($param > 0){
		for ($i=1;$i<=$param;$i++){ //������ҡ 1
			$xfld = explode(".",$paramfield[$i]);
			if (stristr($sql,$xfld[0])){   //�Ҵ���� �� table.field �ͧ parameter � sql ����������
				if ($paramcond != "") $paramcond .= " and ";
				$paramcond .= "(" . $paramfield[$i] . " = '" . $paramdefault[$i] . "')";
			}
		}
	}
	return $paramcond;
}

function GetQueryValue($sql){
	if ($_GET[debug]) echo "$sql<BR>";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_NUM);
		return $rs[0];
	}else{
		return NULL;
	}
}

function ReplaceParamOLD($s){
global $param,$paramname,$paramdefault,$paramcomment;
	for ($i=1;$i<=$param;$i++){ //start from 1
		$s = str_replace("#" . $paramname[$i] . "#",$paramcomment[$i] . " " . $paramdefault[$i],$s);
		$s = str_replace("#" . $paramname[$i] . "-1#",$paramcomment[$i] . " " . intval($paramdefault[$i]) - 1,$s);
		$s = str_replace("#" . $paramname[$i] . "+1#",$paramcomment[$i] . " " . intval($paramdefault[$i]) + 1,$s);
	}
	return $s;
}

function ReplaceParam($s){
global $param,$paramname,$paramdefault,$paramcomment,$xparamdefault,$pvcode;
	for ($i=1;$i<=$param;$i++){ //start from 1
		$s = str_replace("#" . $paramname[$i] . "#", $paramdefault[$i],$s);
		$s = str_replace("#" . $paramname[$i] . "-1#",intval($paramdefault[$i]) - 1,$s);
		$s = str_replace("#" . $paramname[$i] . "+1#",intval($paramdefault[$i]) + 1,$s);
		$s = str_replace("#" . $paramname[$i] . "_x#", $xparamdefault[$i],$s);
		$s = str_replace("#" . $paramname[$i] . "_x-1#",intval($xparamdefault[$i]) - 1,$s);
		$s = str_replace("#" . $paramname[$i] . "_x+1#",intval($xparamdefault[$i]) + 1,$s);
	}

	for ($i=0;$i<=10;$i++){
		if (stristr($s,"#param$i#")){  // Parameter ������Ҩҡ������
			$s = eregi_replace ("#param$i#", $_GET["param" . $i],$s);
		}
	}
	
	// ᷹������ʨѧ��Ѵ �µ�ͧ�кؤ��㹵���������� $pvcode
	for ($n=1;$n<=4;$n++){
		if (stristr($s,"#pv$n#")){  // ���ʨѧ��Ѵ��� n
			$s = eregi_replace ("#pv$n#", $pvcode[$n],$s);
		}
	}
	
	// 14/9/2549 => 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
	global $mrs;
	if (stristr($s,"#fld:")){
		foreach ($mrs as $fieldname1 => $fieldvalue1){
			$s = str_replace("#fld:$fieldname1#",$fieldvalue1,$s);   //᷹��Ңͧ parameter ����繤��� field 
		}
	}

	return $s;
}

function ReplaceXParam($s){ // ����Ѻ�����������º��º
global $param,$paramname,$xparamdefault,$paramcomment;
	for ($i=1;$i<=$param;$i++){ //start from 1
		$s = str_replace("#" . $paramname[$i] . "#", $xparamdefault[$i],$s);
		$s = str_replace("#" . $paramname[$i] . "-1#",intval($xparamdefault[$i]) - 1,$s);
		$s = str_replace("#" . $paramname[$i] . "+1#",intval($xparamdefault[$i]) + 1,$s);
	}

	for ($i=0;$i<=10;$i++){
		if (stristr($s,"#param$i#")){  // Parameter ������Ҩҡ������
			$s = eregi_replace ("#param$i#", $_GET["param" . $i],$s);
		}
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

function SetNumberFormat($val,$nformat,$dec){
	if ($nformat == 0){ //NATUARAL
		if (is_null($val)){
			$val = "N/A";
		}else if (is_numeric($val)){
			$val = SetDecimal($val,$dec);
		}
	}else if ($nformat == 1){ // NORMAL
		/*
			�	.� Null �� .�ʴ�� .� N/A �մ��
			� .� 0 �� .�ʴ�� .� 0 �մ��
			� .ҵ� �ź � .�� ᴧ
			� .Һǡ � .�չ����Թ
		*/
		if ($val < 0){  // Negative
			$val = "<font color='RED'>" . SetDecimal($val,$dec) . "</font>";
		}else if ($val == 0){
			$val = "<font color='BLACK'>" . SetDecimal($val,$dec) . "</font>";
		}else if (is_null($val)){
			$val = "<font color='BLACK'>N/A</font>";
		}else{ // > 0
			$val = "<font color='BLUE'>" . SetDecimal($val,$dec) . "</font>";
		}
	}else if ($nformat == 2){ //INVERT
		/*
		- � .� Null �� .�ʴ�� .� N/A �մ��
		- � .� 0 �� .�ʴ�� .� 0 �մ��
		- � .ҵ� �ź � .�չ����Թ
		- � .Һǡ � .�� ᴧ
		*/
		if ($val < 0){  // Negative
			$val = "<font color='BLUE'>" . SetDecimal($val,$dec) . "</font>";
		}else if ($val == 0){
			$val = "<font color='BLACK'>" . SetDecimal($val,$dec) . "</font>";
		}else if (is_null($val)){
			$val = "<font color='BLACK'>N/A</font>";
		}else{ // > 0
			$val = "<font color='RED'>" . SetDecimal($val,$dec) . "</font>";
		}
	}

	return $val;
}


function SearchCellInfo($sec,$cellno){
	global $cellinfo;
	for ($i=0;$i<count($cellinfo);$i++){
		if ($cellinfo[$i][sec] == $sec && $cellinfo[$i][cellno] == $cellno && strlen($cellinfo[$i][cellno]) == strlen($cellno)){
			return $cellinfo[$i];
		}
	}

	return NULL;
}


function GetCellProperty2($id,$sec1,$cellno){
//		$result = mysql_query("select * from cellinfo where rid=$id and sec='$sec1' and cellno='$cellno';");
		$rs = SearchCellInfo($sec1,$cellno);
		if ($rs){
//			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$prop = "";
			if ($rs[alignment]){
				$prop .= " align='$rs[alignment]' ";
			}

			if ($rs[valign]){
				$prop .= " valign='$rs[valign]' ";
			}

			if ($rs[bgcolor]){
				$prop .= " bgcolor='$rs[bgcolor]' ";
			}

			if ($rs[width]){
				$prop .= " width='$rs[width]' ";
			}

			return $prop;

		}else{
			return "";
		}
}

function ReplaceSpecialParam($s,$n,$nformat=1,$dec=1){ //executive sum
global $cvalue,$c,$startj,$imgpath,$cell,$prov_name;

	$s = eregi_replace ("#pvname#", $prov_name,$s);

	for ($i=0;$i<=10;$i++){
		if (stristr($s,"#param$i#")){  // Parameter ������Ҩҡ������
			$s = eregi_replace ("#param$i#", $_GET["param" . $i],$s);
		}
	}

	if (stristr($s,"#delta#")){  // ����ͧ���� 3 �������
		$s = eregi_replace ("#delta#", "<img src='$imgpath/delta.png' border=0>",$s);
	}

	if (stristr($s,"#diff#")){  // Field ����Ҽŵ�ҧ�ͧ 2 Field ��͹���
		if ($n > 2){
			$a = floatval(strip_tags(ereg_replace(",","",$cvalue[$n-1])));
			$b = floatval(strip_tags(ereg_replace(",","",$cvalue[$n-2])));
			$s = eregi_replace ("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec),$s);
		}else{
			$s = eregi_replace ("#diff#", "N/A",$s);
		}
	}	

	if (stristr($s,"#%diff#")){  // Field ����� % �ŵ�ҧ�ͧ 2 Field ��͹���
		if ($n > 2){
			$a = floatval(strip_tags(ereg_replace(",","",$cvalue[$n-1]))); //���
			$b = floatval(strip_tags(ereg_replace(",","",$cvalue[$n-2]))); //����
			if (is_null($cvalue[($n-1)]) || is_null($cvalue[($n-2)]) || strip_tags($cvalue[($n-1)]) == "N/A" || strip_tags($cvalue[($n-2)]) == "N/A"){ //��ҵ��㴵��˹���� N/A
				$s = eregi_replace ("#%diff#", "N/A",$s);   
			}else if ($cvalue[($n-1)] == "0"){
				$s = eregi_replace ("#%diff#", "0",$s); //6/2/2549
			}else if ($a == 0 && $b == 0){
				$s = eregi_replace ("#%diff#", "" . SetNumberFormat(0,$nformat,$dec),$s);
			}else if ($b != 0){
				//$xn = (($a - $b)/$a) * 100.00; 
				$xn = (($a - $b)/$b) * 100.00; //(��һբ�� - ��һի���) / ��һի��� 
				$x = SetNumberFormat($xn,$nformat,$dec);
				$s = eregi_replace ("#%diff#", "" . $x ,$s);
			}else{
				$s = eregi_replace ("#%diff#", "N/A",$s);   
			}
		}else{
			$s = eregi_replace ("#%diff#", "N/A",$s);
		}
	}	


	//24/10/2548 ���� #total# �Ҽ�����ǹ͹
	if (stristr($s,"#total#")){  // ������ҧ�ǹ͹ (������ǡѹ)
		$sum = 0;
		for ($j=$startj;$j<=$c;$j++){
			$sum += floatval(strip_tags(ereg_replace(",","",$cvalue[$j])));
		}
		$total = SetNumberFormat($sum,$nformat,$dec);
		$s = eregi_replace ("#total#", $total . "",$s);
	}



	if (stristr($s,"#@")){  // �ٵ�

		preg_match_all("/#@([\w\.]+)*#/", $s, $var1);
		for ($k=0;$k<=count($var1);$k++){
			$funcname = trim($var1[0][$k]);
			$funcfld = trim($var1[1][$k]);

			if ($funcname > ""){
				$f1 = explode(".",$funcfld);
		
				//	 ��ǹ�ͧ caption �Ѻ itemname ���� #max::yy#
				$s = str_replace($funcname, "floatval(" . ($cell[$f1[0]][$f1[1]]) . ")",$s );

			}
		}
		// 8/4/2549

		$x = $s;

		// evaluate calculation
		@eval("\$s = " . strip_tags($x) . ";");
		$s = SetNumberFormat($s,$nformat,$dec);
	}	


	// 14/9/2549 => 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
	global $mrs;
	if (stristr($s,"#fld:")){
		foreach ($mrs as $fieldname1 => $fieldvalue1){
			$s = str_replace("#fld:$fieldname1#",$fieldvalue1,$s);   //᷹��Ңͧ parameter ����繤��� field 
		}
	}


	return $s;
}

function ReplaceSpecialParam2($s,$n,$nformat=1,$dec=1){   // $cvalue �� array 2 �Ե� (�óբͧ ���º��º)
global $cvalue,$m,$c,$startj,$imgpath,$prov_name;
	$s = eregi_replace ("#pvname#", $prov_name,$s);
	if (stristr($s,"#delta#")){  // ����ͧ���� 3 �������
		$s = eregi_replace ("#delta#", "<img src='$imgpath/delta.png' border=0>",$s);
	}

	if (stristr($s,"#diff#")){  // Field ����Ҽŵ�ҧ�ͧ 2 Field ��͹���
		if ($n > 2){
			$a = floatval(strip_tags(ereg_replace(",","",$cvalue[$m][$n-2])));
			$b = floatval(strip_tags(ereg_replace(",","",$cvalue[$m][$n-1])));
			$s = eregi_replace ("#diff#", "" . SetNumberFormat(($a - $b),$nformat,$dec),$s);
		}else{
			$s = eregi_replace ("#diff#", "N/A",$s);
		}
	}	

	if (stristr($s,"#%diff#")){  // Field ����� % �ŵ�ҧ�ͧ 2 Field ��͹���
		if ($n > 2){
			$b = floatval(strip_tags(ereg_replace(",","",$cvalue[$m][$n-1]))); //���
			$a = floatval(strip_tags(ereg_replace(",","",$cvalue[$m][$n-2]))); //����
			if (is_null($cvalue[$m][($n-1)]) || is_null($cvalue[$m][($n-2)]) || strip_tags($cvalue[$m][($n-1)]) == "N/A" || strip_tags($cvalue[$m][($n-2)]) == "N/A" ){ //��ҵ��㴵��˹���� N/A
				$s = eregi_replace ("#%diff#", "N/A",$s);   
			}else if ($a == 0 && $b == 0){
				$s = eregi_replace ("#%diff#", "" . SetNumberFormat(0,$nformat,$dec),$s);
			}else if ($a != 0){
				$x = (($b - $a)/$a) * 100.00; //(��һբ�� - ��һի���) / ��һի���
				$s = eregi_replace ("#%diff#", "" . SetNumberFormat($x,$nformat,$dec),$s);
			}else{
				$s = eregi_replace ("#%diff#", "N/A",$s);
			}
		}else{
			$s = eregi_replace ("#%diff#", "N/A",$s);
		}
	}	

	//24/10/2548 ���� #total# �Ҽ�����ǹ͹
	if (stristr($s,"#total#")){  // ������ҧ�ǹ͹ (������ǡѹ)
		$sum = 0;
		for ($j=$startj;$j<=$c;$j++){
			$sum += floatval(strip_tags(ereg_replace(",","",$cvalue[$m][$j])));
		}
		$total = SetNumberFormat($sum,$nformat,$dec);
		$s = eregi_replace ("#total#", $total ."" ,$s);
	}

	// 14/9/2549 => 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
	global $mrs;
	if (stristr($s,"#fld:")){
		foreach ($mrs as $fieldname1 => $fieldvalue1){
			$s = str_replace("#fld:$fieldname1#",$fieldvalue1,$s);   //᷹��Ңͧ parameter ����繤��� field 
		}
	}

	return $s;
}

function GetCellSumValue($id,$sec,$cid){
global $irs;
//		$iresult = mysql_query("select * from cellinfo where rid=$id and sec='$sec' and cellno='$cid';");
		$irs = SearchCellInfo($sec,$cid);

		if ($irs){
//			$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);
			$val1 = ReplaceParam($irs[caption]);

			if ($irs[celltype] == 1){

				$sql = ReplaceParam(str_replace(";","",$irs[cond])); 

/*				$paramcond = GetParamCondition($sql);
				if ($paramcond != ""){
					if (!stristr($sql," where ")){  //�������� where
						$sql .= " where $paramcond ";
					}else{
						$sql = eregi_replace (" where ", " where $paramcond and ",$sql);
					}
				}
*/


				$xval = GetQueryValue($sql);
				$val1 .= SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);

			}else if ($irs[celltype] == 3){
				$xval="";
				if (trim($irs[cond]) > ""){
					$furl = ReplaceParam($irs[cond]);
					$xval = @trim(@implode(' ',@file($furl)));
				}

				$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
				$val1 .= $xval;

			}else if ($irs[celltype] == 4){
				$xval="";
				if (trim($irs[cond]) > ""){
					$xval = trim($irs[cond]);
				}

				$xval = ReplaceSpecialParam($xval,0,$irs[nformat],$irs[decpoint]);
				$val1 .= $xval;

			}

			if ($irs[font]){
				$val1 = "<span style='$irs[font]'>$val1</span>";
			}

			if ($irs[url]){
				$iurl = ReplaceParam($irs[url]);
//				$val1 = "<a href='$iurl' target='_blank'>$val1</a>";
				$val1 = "<a href='$iurl'>$val1</a>";
			}
			
		}else{
			$val1 = "&nbsp;";
		}

		return $val1;
}

function ParseTable($tb,$ts){
global $r,$c,$tspan;

	$x = explode("x",$ts);
	$r = intval($x[0]);
	$c = intval($x[1]);

	$tspan=Array();
	$tbrow = explode("|",$tb);
	for ($i=0;$i<count($tbrow);$i++){
		$tbcol = explode("*",$tbrow[$i]);
		for ($j=0;$j<count($tbcol);$j++){
			$tspan[$i][$j] = $tbcol[$j];
		}
	}

}



/********************** START **************************/

$allowsort = false;
$skey = intval($_GET[skey]);
if(!isset($_GET[desc])){
	$asc = false;
	$sort_order[$skey] = "asc";
}else{
	$asc = true;
	$sort_order[$skey] = "desc";
}

$paramnosort = "";
foreach($_GET as $key=>$value){
	if ($key != "skey"){  
		if ($key != "asc" && $key != "desc"){  
			$paramnosort .= "$key=$value&";
		}
	}else{
		$allowsort = true;
	}
}


$cvalue = Array();

$id = $reportinfo[0][rid];

$paramname = Array();
$paramfield = Array();
$paramcomment = Array();
$paramstep = Array();
$parammin = Array();
$parammax = Array();
$paramdefault = Array();
$param=0;

if ($id > 0){
//	$sql = "select * from  reportinfo  where rid=$id;";
//	$result = mysql_query($sql);
	$rs = $reportinfo[0];
	if ($rs){

		$refno = $rs[refno];
		$keyincode = $rs[keyincode];
		$createby = $rs[createby];



		mysql_select_db($data_db_name);



		if (count($paraminfo) > 0){
			for ($param=1;$param <= count($paraminfo);$param++){ // ������ҡ 1 
				$prs = $paraminfo[$param - 1];
				if (intval($prs[step]) <= 1) $prs[step] = 1;

				$paramname[$param] = $prs[param];
				$paramfield[$param] = $prs[dfield];
				$paramcomment[$param] = $prs[comment];
				$paramstep[$param] = intval($prs[step]);

				$xfld = explode(".",$prs[dfield]);
				$parammin[$param] = GetQueryValue("select MIN($xfld[1]) from " . $xfld[0] );
				$parammax[$param] = GetQueryValue("select MAX($xfld[1]) from " . $xfld[0] );

				// ��Ǩ�ͺ����觤�� Parameter �ҡѺ URL
				if (isset($_GET[$paramname[$param]]) && $_GET[$paramname[$param]] > ""){
					$paramdefault[$param] = $_GET[$paramname[$param]];
				}else{
					$paramdefault[$param] = $parammax[$param];
				}

				// ��Ǩ�ͺ����觤�� Parameter ��������º��º(���� parameter ��ͷ��´��� "_x" ) ����ҡѺ URL
				if (isset($_GET[$paramname[$param] . "_x"]) && $_GET[$paramname[$param] . "_x"] > ""){
					$xparamdefault[$param] = $_GET[$paramname[$param] . "_x"];

 					if ($param == 1){ // parameter �á ����ѡ���繻� �.�.
						// ������� �մ�ҹ��� ��ͧ�ҡ���Ҵ�ҹ����
						if ($xparamdefault[$param] < $paramdefault[$param]){
							$paramdefault[$param] = $xparamdefault[$param];
						}
					}

				}else{
					$xparamdefault[$param] = $parammax[$param];

					if (isset($_GET[$paramname[$param] . "_x"]) || $rs[rtype] > 0 || $_GET[rtype] == "compare"){  
						// 23/3/2549 ������������͹� || $rs[rtype] > 0 || $_GET[rtype] == "compare"
						// 13/2/2549 ��ѭ�ҷ���һ� - 1
						if ($parammax[$param] != $parammin[$param]){ // ����դ�ҷ��ᵡ��ҧ
							$paramdefault[$param] = intval($parammax[$param]) - $paramstep[$param];
						}
					}  
				}

			
			}
		}

		$param = count($paraminfo);

		//Generate Condition from Parameter 
		$paramcond = "";
		if ($param > 0){
			for ($i=1;$i<=$param;$i++){ //������ҡ 1
				if ($paramcond != "") $paramcond .= " and ";
				$paramcond .= "(" . $paramfield[$i] . " = '" . $paramdefault[$i] . "')";
			}
		}


		// Get Table Border 
		$reportbgcolor = ($rs[bgcolor] != "") ? $rs[bgcolor] : "$default_bg_color";
		$bcolor1 = ($rs[bcolor1] != "") ? $rs[bcolor1] : "#000000";
		$bcolor2 = ($rs[bcolor2] != "") ? $rs[bcolor2] : "#000000";
		$bcolor3 = ($rs[bcolor3] != "") ? $rs[bcolor3] : "#000000";
		$bcolor4 = ($rs[bcolor4] != "") ? $rs[bcolor4] : "#000000";
		$bsize1 = intval($rs[bsize1]);
		$bsize2 = intval($rs[bsize2]);
		$bsize3 = intval($rs[bsize3]);
		$bsize4 = intval($rs[bsize4]);

		if ($rs[fldname] == ""){
			$msg = "Cannot find KeyField for this report.";
		}

	} else {
		$msg = "Cannot find Report.";
	}

} else {
	$msg = "Cannot find Report.";
}
?>

<html>
<head>
<title><?=$rs[caption]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="<?=$css_path?>report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="dbselect.js"></script>
<script language="javascript" src="<?=$css_path?>/functions.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function el(id) {
  if (document.getElementById) {
    return document.getElementById(id);
  } else if (window[id]) {
    return window[id];
  }
  return null;
}

//-->
</SCRIPT>
</head>

<body bgcolor="<?=$reportbgcolor?>">


<?
// ERROR MESSAGE
if ($msg){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}
?>

<table border=0 width="790" cellspacing=0 cellpadding=0 align="CENTER"><TR><TD> <!-- Fix WIDTH to 790 pixel -->

<!-- Executive Summary -->
<table border=0 width="100%" cellspacing=0 cellpadding=5>
<tr valign=middle><td width="100%">

<table border=0 width="85%" align=RIGHT cellpadding=0 style="background-color:<?=$bcolor1?>; border-collapse:collapse; border:<?=$bsize1?> solid <?=$bcolor1?>;">
<?
$cell = array();
ParseTable($rs[table1],$rs[tsize1]);
$flash = array();
$px = 100.00 / $c; // �������ҧ������
for ($i=1;$i<=$r;$i++){
	$flash[$i] = "Exec" . (intval($i) - 1) . "=";
	echo "<tr bgcolor='$reportbgcolor' valign=top>";
	for ($j=1;$j<=$c;$j++){
		$cvalue[$j] = 0;
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if ($rspan > 0 && $cspan > 0){
			$cellvalue = GetCellSumValue($id,"E",$i . "." . $j);
			
			$fcellvalue = $cellvalue;
			$fcellvalue = str_replace("#delta#","::delta::",$fcellvalue);
			$fcellvalue = ReplaceSpecialParam($fcellvalue,$j,$irs[nformat],$irs[decpoint]);
//			$fcellvalue = str_replace("::delta::","#delta#",$fcellvalue);



			$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs[nformat],$irs[decpoint]);
			$cvalue[$j] = $cellvalue;
			$cell[$i][$j] = strip_tags(str_replace(",","",$cellvalue));

			if ($_GET[debug]) {
				echo "cvalue[$j] = " . $cvalue[$j] . "<BR>";
			}

			// 13/2/2549
			//������ա�� set ��Ҥ������ҧ�������
			if (isset($rs[cwidth1]) && isset($rs[cwidth2]) && isset($rs[cwidth3]) && isset($rs[cwidth4])){
				$xpx = ReportGetColumnWidth($id,"E","1.$j");
				if ($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = " width='$xpx' ";
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
				$cwidth = " width='$px%' "; 
				$fwidth = $cspan * $px;
			}
			// 13/2/2549

			//�觤����� Flash
			$tempstr = substr($cellvalue,0,strpos($cellvalue,">"));
			if (strpos($tempstr,"bold;") ){
				$isbold = "b";
			}else{
				$isbold = "";
			}

			$fcolor="";
			$x1 = strpos($tempstr,"color:");
			if ($x1){
				$x2 = strpos($tempstr,";",$x1+7);
				if ($x2){
					$fcolor = substr($tempstr,$x1+7,$x2 - $x1 - 7);
				}
			}

			$falign = "";
			$bcolor = "";

			$frs = SearchCellInfo("E",$i . "." . $j);
			if ($frs){
				if ($frs[alignment]){
					$falign = $frs[alignment];
				}

				if ($frs[bgcolor]){
					$bcolor = $frs[bgcolor];
				}
			}

			$fcellvalue = strip_tags($fcellvalue);
			$flash[$i] .= urlencode("$fcellvalue|$fwidth|$isbold|$falign|$fcolor|$bcolor^");
//			$flash[$i] .= ("$fcellvalue|$fwidth|$isbold|$falign|$fcolor|$bcolor^");
			

?>
<td <?=GetCellProperty2($id,"E",$i . "." . $j)?> <?=$cwidth?>  colspan='<?=$cspan?>' rowspan='<?=$rspan?>' style="border-collapse:collapse; border:<?=$bsize1?> solid <?=$bcolor1?>;">
	<?=$cellvalue?>
</td>
<?
		}
	}
	echo "</tr>"; 
}
?>
</table>

</td>

<td width="<?=$wx+10?>" align=center valign=middle> <!-- BANNER -->
<?
if ($rs[bannerurl]){
	if ($rs[bstyle] == 0){ // Image
		if ($rs[bstretch] == 1){
			echo "<img src='$basedir/$rs[bannerurl]' alt='Banner' border=0 width='$wx' height='$hx'>";
		}else{
			echo "<img src='$basedir/$rs[bannerurl]' alt='Banner' border=0>";
		}
	}else{ // FLASH
		if ($rs[bstretch] == 1){
			$setwidth = "width='$wx' height='$hx' ";
		}else{
			$setwidth="";;
		}

?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?=$setwidth?> >
<param name="movie" value="<?=$basedir . "/" . $rs[bannerurl]?>">
<param name="quality" value="high">
<embed src="<?=$basedir . "/" . $rs[bannerurl]?>"  quality="100%" 
pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
</object>
<?
	}
}else{
//	echo "<img src='$imgpath/banner.gif' alt='Banner' border=0 width='$wx' height='$hx'>";
}

?>

</td>
</tr></table>

<!-- END Executive Summary -->

<?
$flashstring = "";
for ($i=1;$i<=count($flash);$i++){
	$flashstring .= $flash[$i] . "&";
}

?>
<BR><A HREF="../../common/executivesum.php?<?=$flashstring?>" target="_blank">������ǹ�ͧ Executive Summary</A>
<BR>
<p align=right>
<?

// ====== 9/3/2549 �Ѵ�������§ҹẺ compare ��� �����˹�����ǡѹ ========

//�� url ������
$allurl = "";
foreach ($_GET as $k => $v){
	if (strtolower($k) != "rtype"){
		$allurl .= "$k=$v&";
	}
}

if (isset($_GET[rtype])){
	if ($rs[rtype] >=1){ // ����� compare ��������
		if ($_GET[rtype] == "normal"){
			echo "<a href='?$allurl&rtype=compare'>��§ҹ���º��º</a>";
		}else if ($_GET[rtype]=="compare"){ //rtype=compare
			echo "<a href='?$allurl&rtype=normal'>��§ҹẺ����</a>";
		}

	}else { // ����� normal

		if ($_GET[rtype] == "compare"){
			echo "<a href='?$allurl&rtype=normal'>��§ҹẺ����</a>";
		}else{
			echo "<a href='?$allurl&rtype=compare'>��§ҹ���º��º</a>";
		}		
		
//		echo "<a href='?$allurl&rtype=compare'>��§ҹ���º��º</a>";
	}

}else{ //����к� rtype
	if ($rs[rtype] >=1){ // ����� compare ��������
		echo "<a href='?$allurl&rtype=normal'>��§ҹẺ����</a>";
	}else{
		echo "<a href='?$allurl&rtype=compare'>��§ҹ���º��º</a>";
		$_GET[rtype] = "normal";
	}
}
// ====== 9/3/2549 �Ѵ�������§ҹẺ compare ��� �����˹�����ǡѹ ========

?>


<!-- TABLE HEADER -->
<table border=0  width="100%" align=centercellpadding=2 style="background-color:<?=$bcolor2?>;	border-collapse:collapse; border:<?=$bsize2?> solid <?=$bcolor2?>;">

<?



// 26/11/2548 ���� parameter ���͡�� ���º��º
if ($_GET[rtype] == "compare"){
	if ($rs[rtype] == 0){ //�ҡ�������� normal
		$rs[rtype] = 2;   // Overide to comparision report type 2 (no diff) 
	}

}else if ($_GET[rtype] == "normal"){
	if ($rs[rtype] != 0){ //�ҡ����������� normal
		$rs[rtype] = 0;   // Overide to normal report
	}
}



ParseTable($rs[table2],$rs[tsize2]);
$startcolumn = intval($rs[startcolumn] - 1);
if ($startcolumn < 0){
	$startcolumn = 0;
}

//����� parameter 
for ($i=1;$i<=$param;$i++){

	$nrow = $param+$r;  
	echo "<tr bgcolor='$default_bg_color'>";

	if ($i==1){ //੾�к�÷Ѵ�á
		for ($n1=0;$n1<$startcolumn;$n1++){
			echo "<td rowspan=$nrow align=center  style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'><span id=caption" . $n1 . ">&nbsp;</span></td>";
		}
	}
	echo "<td align=center colspan='" . ($c - $startcolumn) . "'  style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'><table border=0 width='100%'><tr>";
	echo "<td width=25>";
	// BACK Button
	if ($paramdefault[$i] - $paramstep[$i]  >= $parammin[$i]){
		$px1 = "";
		for ($j=1;$j<=$param;$j++){
			$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
			if ($j != $i){
				$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
			}
		}

		for ($j=0;$j<=5;$j++){
			if (isset($_GET["param" . $j])){
				$px1 .= "param$j=" . $_GET["param" . $j] . "&";
			}
		}
		
		if ($allowsort){
			$px1 .= "skey=$skey&";
		}
		
		if (isset($_GET[rtype])){
			echo "<a href='?id=$id&rtype=$_GET[rtype]&" . $px1 . $paramname[$i] . "=" . (intval($paramdefault[$i]) - $paramstep[$i]) . "'><img src='$imgpath/back.jpg' border=0></a>";
		}else{
			echo "<a href='?id=$id&" . $px1 . $paramname[$i] . "=" . (intval($paramdefault[$i]) - $paramstep[$i]) . "'><img src='$imgpath/back.jpg' border=0></a>";
		}
	}
	echo "&nbsp;</td><td align=center><B>";
	if ($paramname[$i] == "mm" || $paramname[$i] == "month" ){
		echo $paramcomment[$i] . " " . $monthname[$paramdefault[$i]];
	}else{
		echo $paramcomment[$i] . " " . $paramdefault[$i];
	}
	echo "</B></td><td align=right width=25>&nbsp;";

	// NEXT Button
	if ($paramdefault[$i] + $paramstep[$i] <= $parammax[$i]){
		if (($i > 1) || (! ($rs[rtype] >= 1 && $paramdefault[$i] >= $xparamdefault[$i] ))) {
			$px1 = "";
			for ($j=1;$j<=$param;$j++){
				$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
				if ($j != $i){
					$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
				}
			}

			for ($j=0;$j<=5;$j++){
				if (isset($_GET["param" . $j])){
					$px1 .= "param$j=" . $_GET["param" . $j] . "&";
				}
			}
			
			if ($allowsort){
				$px1 .= "skey=$skey&";
			}

			if (isset($_GET[rtype])){
				echo "<a href='?id=$id&rtype=$_GET[rtype]&" . $px1 . $paramname[$i] . "=" . (intval($paramdefault[$i]) + $paramstep[$i]) . "'><img src='$imgpath/next.jpg' border=0></a>";
			}else{
				echo "<a href='?id=$id&" . $px1 . $paramname[$i] . "=" . (intval($paramdefault[$i]) + $paramstep[$i]) . "'><img src='$imgpath/next.jpg' border=0></a>";
			}

		} //if


	}


	echo "</td></tr></table></td>";


	if ($rs[rtype] >= 1){ // Comparision Report

		echo "<td align=center colspan='" . ($c - $startcolumn) . "'  style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'><table border=0 width='100%'><tr>";
		echo "<td width=25>";
		// BACK Button
		if ($xparamdefault[$i] - $paramstep[$i] >= $parammin[$i]){
			if (($paramdefault[$i] < $xparamdefault[$i] ) || $i > 1) {
				$px1 = "";
				for ($j=1;$j<=$param;$j++){
					$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&"; // prameter ����
					if ($j != $i){
						$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
					}
				}

				for ($j=0;$j<=5;$j++){
					if (isset($_GET["param" . $j])){
						$px1 .= "param$j=" . $_GET["param" . $j] . "&";
					}
				}
				
				if ($allowsort){
					$px1 .= "skey=$skey&";
				}

				if (isset($_GET[rtype])){
					echo "<a href='?id=$id&rtype=$_GET[rtype]&". $px1 . $paramname[$i] . "_x=" . (intval($xparamdefault[$i]) - $paramstep[$i]) . "'><img src='$imgpath/back.jpg' border=0></a>";
				}else{
					echo "<a href='?id=$id&". $px1 . $paramname[$i] . "_x=" . (intval($xparamdefault[$i]) - $paramstep[$i]) . "'><img src='$imgpath/back.jpg' border=0></a>";
				}


			}
		}
		echo "&nbsp;</td><td align=center><B>";
		if ($paramname[$i] == "mm" || $paramname[$i] == "month" ){
			echo $paramcomment[$i] . " " . $monthname[$xparamdefault[$i]];
		}else{
			echo $paramcomment[$i] . " " . $xparamdefault[$i];
		}
		echo "</B></td><td align=right width=25>&nbsp;";
		// NEXT Button
		if ($xparamdefault[$i] + $paramstep[$i] <= $parammax[$i]){
			$px1 = "";
			for ($j=1;$j<=$param;$j++){
				$px1 .= $paramname[$j] . "=" . $paramdefault[$j] . "&";
				if ($j != $i){
					$px1 .= $paramname[$j] . "_x=" . $xparamdefault[$j] . "&";
				}
			}

			for ($j=0;$j<=5;$j++){
				if (isset($_GET["param" . $j])){
					$px1 .= "param$j=" . $_GET["param" . $j] . "&";
				}
			}
			
			if ($allowsort){
				$px1 .= "skey=$skey&";
			}

			if (isset($_GET[rtype])){
				echo "<a href='?id=$id&rtype=$_GET[rtype]&" . $px1 . $paramname[$i] . "_x=" . (intval($xparamdefault[$i]) + $paramstep[$i]) . "'><img src='$imgpath/next.jpg' border=0></a>";
			}else{
				echo "<a href='?id=$id&" . $px1 . $paramname[$i] . "_x=" . (intval($xparamdefault[$i]) + $paramstep[$i]) . "'><img src='$imgpath/next.jpg' border=0></a>";
			}


		}
		echo "</td></tr></table></td>";

		
		// ���º��º
//		if ($rs[rtype] == 1 && $_GET[rtype] != "compare"){ // Comparision Report ��ҹ�� rtype == 2 ����ʴ�
		if ($rs[rtype] == 1){ // Comparision Report ��ҹ�� rtype == 2 ����ʴ�
			if ($i == 1) {  //�ʴ�੾�� parameter �á ��������ӫ�͹
				echo "<td align=center rowspan='" . ($param+$r) . "' colspan='" . ($c - $startcolumn) . "' style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'><img src='$imgpath/delta.png' border=0> <b>%</b></td>";
			}else{
//				echo "<td align=center rowspan='" . ($param+$r) . "' colspan='" . ($c - $startcolumn) . "' style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'>&nbsp;</td>";
			}
		}
		
	
	} // Comparision Report

	echo "</tr>";
}

// ��÷Ѵ����� Header 
$px = intval(100 / $c); // �������ҧ������
for ($i=1;$i<=$r;$i++){
	echo "<tr bgcolor='$default_bg_color' valign=top>";
	for ($j=1;$j<=$c;$j++){
		$cvalue[$j] = 0;
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if ($rspan > 0 && $cspan > 0){
			$cellvalue = GetCellSumValue($id,"H",$i . "." . $j);
			$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs[nformat],$irs[decpoint]);
			$cvalue[$j] = $cellvalue;

			//SORTING (28/10/2548)	
			if (($i == $r || ($i == 1 && $j == $startcolumn )) && $allowsort ){
				if (!isset($sort_order[$j])) $sort_order[$j] = "asc";

				if ($skey == $j){
					//$cellvalue .= " <img src='$imgpath/down1.gif' border=0>";
					//$cellvalue = "<u>$cellvalue</u>";
					if ($sort_order[$j] == "asc"){
						$cellvalue = "<a href='?$paramnosort&skey=$j&desc'><u>$cellvalue</u></a>";
						$cellvalue .= " <img src='$imgpath/s_asc.gif' border=0 width=15 height=15>";
					}else{
						$cellvalue = "<a href='?$paramnosort&skey=$j&asc'><u>$cellvalue</u></a>";
						$cellvalue .= " <img src='$imgpath/s_desc.gif' border=0 width=15 height=15>";
					}

				}else{
					$cellvalue = "<a href='?$paramnosort&skey=$j&$sort_order[$j]'><u>$cellvalue</u></a>";
				}


			}

			if ($i==1 && $param > 0 && $startcolumn > 0 && $j <= $startcolumn){  //rowspan
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var captiontext = el("caption<?=$j-1?>");
captiontext.innerHTML = "<?=$cellvalue?>";
//-->
</SCRIPT>
<?
			}else{


			// 13/2/2549
			//������ա�� set ��Ҥ������ҧ�������
			if (isset($rs[cwidth1]) && isset($rs[cwidth2]) && isset($rs[cwidth3]) && isset($rs[cwidth4])){
				$xpx = ReportGetColumnWidth($id,"H","1.$j");
				if ($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = " width='$xpx' ";
				}else{
					$cwidth = "";  //����к�
				}
			}else{ // ����ա�á�˹���Ҥ������ҧ
				$cwidth = " xxwidth='$px%' ";  //auto ����Ѻ header
			}
			// 13/2/2549


?>
<td <?=GetCellProperty2($id,"H",$i . "." . $j)?> <?=$cwidth?> colspan='<?=$cspan?>' rowspan='<?=$rspan?>' style="border-collapse:collapse; border:<?=$bsize2?> solid <?=$bcolor2?>;">
	<?=$cellvalue?>
</td>
<?
			}

		}
	}


	if ($rs[rtype] >= 1 ){ // Comparision Report

		for ($j=$startcolumn+1;$j<=$c;$j++){   // ����� Cell ����к�� startcolumn
			$cvalue[$j] = 0;
			$x = explode("x",$tspan[$i-1][$j-1]);
			$rspan = intval($x[0]);
			$cspan = intval($x[1]);
			if ($rspan > 0 && $cspan > 0){
				$cellvalue = GetCellSumValue($id,"H",$i . "." . $j);
				$cellvalue = ReplaceSpecialParam($cellvalue,$j,$irs[nformat],$irs[decpoint]);
				$cvalue[$j] = $cellvalue;

				//sorting
				if (($i == $r || ($i == 1 && $j == $startcolumn )) && $allowsort ){
					$nxx = $c + $j - 1;
					if (!isset($sort_order[$j])) $sort_order[$j] = "asc";

					if ($skey == $c + $j - 1){
						//$cellvalue .= " <img src='$imgpath/down1.gif' border=0>";
						//$cellvalue = "<u>$cellvalue</u>";
						if ($sort_order[$j] == "asc"){
							$cellvalue = "<a href='?$paramnosort&skey=$nxx&desc'><u>$cellvalue</u></a>";
							$cellvalue .= " <img src='$imgpath/s_asc.gif' border=0 width=15 height=15>";
						}else{
							$cellvalue = "<a href='?$paramnosort&skey=$nxx&asc'><u>$cellvalue</u></a>";
							$cellvalue .= " <img src='$imgpath/s_desc.gif' border=0 width=15 height=15>";
						}
					}else{
						$cellvalue = "<a href='?$paramnosort&skey=$nxx&$sort_order[$j]'><u>$cellvalue</u></a>";
					}
				}

	

			// 13/2/2549
			//������ա�� set ��Ҥ������ҧ�������
			if (isset($rs[cwidth1]) && isset($rs[cwidth2]) && isset($rs[cwidth3]) && isset($rs[cwidth4])){
				$xpx = ReportGetColumnWidth($id,"H","1.$j");
				if ($xpx > "" && $cspan < 2){  //����� column span
					$cwidth = " width='$xpx' ";
				}else{
					$cwidth = "";  //����к�
				}
			}else{ // ����ա�á�˹���Ҥ������ҧ
				$cwidth = " xxwidth='$px%' ";  //auto ����Ѻ header
			}
			// 13/2/2549



	?>
	<td <?=GetCellProperty2($id,"H",$i . "." . $j)?> <?=$cwidth?> colspan='<?=$cspan?>' rowspan='<?=$rspan?>' style="border-collapse:collapse; border:<?=$bsize2?> solid <?=$bcolor2?>;">
		<?=$cellvalue?>
	</td>
	<?
			}
		} //for


// ����ͧ�ʴ����ǹ�ͧ Header ���� ���� �� rowspan �Ҩҡ��÷Ѵ��
		// ���º��º
		//		echo "<td align=center colspan='" . ($c - $startcolumn) . "'>&nbsp;</td>";

	}  // 	if ($rs[rtype] == 1){ // Comparision Report


	echo "</tr>";
}

?>
<!-- END TABLE HEADER -->


<!-- INFORMATION PORT / NO SPAN / 2 ROWS-->
<?
// BGCOLOR
$bg[1] = "#FF6633";   // Data Row
$bg[2] = "#996600";   // Summarize Row

$px = intval(100 / $c); // �������ҧ������

//INFORMATION
$i = 1;
$nrow = 0;

$cvalue = Array();
$csum = Array();
$xfld = explode(".",$rs[fldname]);

// 23/10/2548
// ��Ǩ�ͺ����繡�ô֧�����Ũҡ tmp_report ������� �ҡ�Ҩҡ tmp_report ����ͧ�֧�����Ũ�ԧ� 
// ����� include file �ӧҹ᷹ �´֧ summary ����ŧ array �����������
if ($xfld[0] == "tmp_report"){
	$tablestyle = 1; // tmp_report
}else{
	$tablestyle = 0;  //actual table
}

//24/10/2548 
//�ѧ�Ѻ�����ҹ�ҡ tmp_report ���͡�� DEMO
//$tablestyle = 0;  //actual table



$paramcond = GetParamCondition($rs[fldname]);
if (trim($rs[cond]) == ""){
	$sql = "select * from " . $xfld[0] . " order by $xfld[1];";
}else{
	$sql = "select * from " . $xfld[0] . " where (" . ReplaceParam(ReplaceSpecialParam($rs[cond],0)) . ") order by $xfld[1];";
}



if ($rs[rtype] == 0){
	$nround = 0;   // �ͺ����
//}else if ($rs[rtype] == 1  && $_GET[rtype] != "compare"){
}else if ($rs[rtype] == 1 ){
	$nround = 2;   // 3 �ͺ  (0-2)
}else{
	$nround = 1;   // 2 �ͺ  (0-1)
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


$n=0;
$cellvalue = array();
$rowtext = array();

if ($tablestyle == 1){ //tmpreport
	if ($rs[pinclude]){
		include "$rs[pinclude]";  //��� include file �ӡ�ô֧��������ŧ $tmp_rs
	}
	$mresult = @array_reverse($tmp_rs); //��ҵ�����Ҩҡ array �������� include file ���� reverse ���� pop �͡�� 
	if ($_GET[debug]) {echo "<pre>";print_r($tmp_rs); echo "<pre>"; };
}else{  // actual query
	$mresult = mysql_query($sql);
}
while ($mrs=GetRecord($mresult,$tablestyle)){
	$n++;
	$column=0;
	$rowtext[$n] = "";

//	if ($n % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
//FOR SORTING (28/10/2548)
	$rowtext[$n] .= "<tr bgcolor='#IBG#' valign=top>";

	for ($m=0;$m<=$nround;$m++){   // �� 3 �ͺ����Ѻ Comparision
		if ($m == 0){ //�ͺ�á�������� 1 , �ͺ��� 2,3 �������� startcolumn
			$startj = 1;  
		}else{
			$startj = $startcolumn+1;  
		}

		for ($j=$startj;$j<=$c;$j++){  //���� Column

			// ત��� ����� N/A �������ء row ����� column �������� (23/3/2549)
			if (!isset($is_all_na[$m][$j])) $is_all_na[$m][$j] = true; // �������� n/a ����͹
			

			$cvalue[$m][$j] = 0;
			if (!isset($csum[$m][$j])) $csum[$m][$j] = 0;

	//		echo "<td " . GetCellProperty2($id,"I","1." . $j) . " width='$px%' colspan='1' rowspan='1'>";
			$rowtext[$n] .= "<td " . GetCellProperty2($id,"I","1." . $j) . "  colspan='1' rowspan='1' style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'>";

			//�Ѻ column
			$column++;
			$cellvalue[$n][$column] = "";

	//		$iresult = mysql_query("select * from cellinfo where rid=$id and sec='I' and cellno='1.$j';");
			$irs = SearchCellInfo("I","1.$j");
			if ($irs){
	//			$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);

				// Grouping option
				if ($rs[rgroup] == 1 || $rs[rgroup] == 2){
					$xfld = explode(".",$rs[fldname]);
					$x = " " . $mrs["$xfld[1]"];
					$gp = substr($x,strlen($x) - 2,2);
					if ($gp == "00"){
						$val1 = "<B>" . $irs[caption];
						$groupitem = true;
					}else{
						//echo "j=$j , startcolumn=$startcolumn<br>";
						if ($j <= $startcolumn){ // First Column
							$val1 = "&nbsp;&nbsp;&nbsp;" . $irs[caption];
						}else{
							$val1 = $irs[caption];
						}
						$groupitem = false;
					}
				}else{  // no grouping
					$val1 = $irs[caption];
					$groupitem = false;
				}


				$val1 = ReplaceSpecialParam2($val1,$j,$irs[nformat],$irs[decpoint]);
				$xval = @floatval(strip_tags(ereg_replace(",","",$val1)));
				$csum[$m][$j] += floatval(str_replace(",","",$xval));

				// �� original value �ͧ���� (28/10/2548)
				$cellvalue[$n][$column] = $xval;

//SORTING (28/10/2548)
//				// #no# ����Ţ�ʴ��ӴѺ
//				$val1 = eregi_replace ("#no#", "$n",$val1);

				if ($rs[rtype] >= 1 && $m == 2 && $rs[rgroup] != 2) {  // �ҡ �� Comparision column ੾�� rtype == 1 ��ҹ�� Ẻ��� == 2 ����ʴ� , rgroup Ẻ��� 2 ����ʴ�

					// automatic %diff 
					$a = floatval(strip_tags(ereg_replace(",","",$cvalue[1][$j]))); //��һբ�� 
					$b = floatval(strip_tags(ereg_replace(",","",$cvalue[0][$j]))); // ��һի��� 

					if (is_null($cvalue[1][$j]) || is_null($cvalue[0][$j])){ //��ҵ��㴵��˹���� N/A
						$cellvalue[$n][$column] = "";
						$val1 = "N/A";
					}else if ($b != 0){
						// �� original value �ͧ���� (28/10/2548)
						$cellvalue[$n][$column] = (($a - $b)/$b) * 100.00;  //(��һբ�� - ��һի���) / ��һի��� 

						$val1 = SetNumberFormat((($a - $b)/$b) * 100.00,1,1);
					}else{
						// �� original value �ͧ���� (28/10/2548)
						$cellvalue[$n][$column] = "";

						$val1 = "N/A";
					}

					$cvalue[$m][$j] = $val1;

				}else	if ($irs[celltype] == 1){  //Database

					$sql = str_replace(";","",$irs[cond]); 
					$xfld = explode(".",$rs[fldname]);
					$sql = str_replace("#key#",$mrs["$xfld[1]"] ,$sql);   //᷹��Ңͧ parameter m���� Keyfield ŧ� SQL Query

					// 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
					if (stristr($sql,"#fld:")){
						foreach ($mrs as $fieldname1 => $fieldvalue1){
							$sql = str_replace("#fld:$fieldname1#",$fieldvalue1,$sql);   //᷹��Ңͧ parameter ����繤��� field ŧ� SQL Query
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

					if ($m == 0){ // �ͺ�á ���� ���������§ҹ������º��º
						$sql = ReplaceParam($sql);
					}else{
						$sql = ReplaceXParam($sql);
					}

					$xval = GetQueryValue($sql);

					// �� original value �ͧ���� (28/10/2548)
					$cellvalue[$n][$column] = $xval;

					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));

					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					if ($groupitem){
						if ($j <= $startcolumn  || $rs[rgroup] != 2){
							$val1 .= "<B>" . $xval . "</B>";
						}
					}else{
						$val1 .= $xval;
					}

				}else if ($irs[celltype] == 2){  //field
					$xfld = explode(".",$irs[cond]);

					if ($m == 0){ // �ͺ�á ���� ���������§ҹ������º��º
						$xval = $mrs[$xfld[1]];   //��Ҥ�Ҩҡ� record �Ѩ�غѹ
					}else{
						$xval = $mrs[$xfld[1] . "_x"];   //��Ҥ�Ҩҡ� record �Ѩ�غѹ
					}

					// �� original value �ͧ���� (28/10/2548)
					$cellvalue[$n][$column] = $xval;

					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					if ($groupitem){
						if ($j <= $startcolumn || $rs[rgroup] != 2){
							$val1 .= "<B>" . $xval . "</B>";
						}
					}else{
						$val1 .= $xval;
					}

				}else if ($irs[celltype] == 3){ //function
					$xval="";
					if (trim($irs[cond]) > ""){
						$furl = ReplaceParam($irs[cond]);
						$xval = @trim(@implode(' ',@file($furl)));
					}

					// �� original value �ͧ���� (28/10/2548)
					$cellvalue[$n][$column] = $xval;

					$cvalue[$m][$j] = $xval;
					$csum[$m][$j] += floatval(str_replace(",","",$xval));
					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					if ($groupitem){
						if ($j <= $startcolumn || $rs[rgroup] != 2){
							$val1 .= "<B>" . $xval . "</B>";
						}
					}else{
						$val1 .= $xval;
					}

				}



				if ($irs[font]){
					$val1 = "<span style='$irs[font]'>$val1</span>";
				}

				if ($irs[url]){
					$xfld = explode(".",$rs[fldname]);
					$iurl = str_replace("#key#",$mrs["$xfld[1]"] ,$irs[url]);   //᷹��Ңͧ parameter m���� Keyfield ŧ� SQL Query

					// 13/2/2549 �� #fld:���� field# ����Ѻ�ԧ������� field �ͧ���ҧ����� Key Table ����� Information port ��ҹ��
					if (stristr($sql,"#fld:")){
						foreach ($mrs as $fieldname1 => $fieldvalue1){
							$sql = str_replace("#fld:$fieldname1#",$fieldvalue1,$sql);   //᷹��Ңͧ parameter ����繤��� field ŧ� SQL Query
						}
					}
					
					$iurl = ReplaceParam($iurl);
//					$val1 = "<a href='" . $iurl . "' target='_blank'>$val1</a>";
					$val1 = "<a href='" . $iurl . "'>$val1</a>";
				}
				
			}else{
				$val1 = "&nbsp;";
				$cvalue[$m][$j] = 0;
			}

			//��Ǩ�ͺ��� ����� N/A �������ء row ����� column ������� ���� N/A ������ ��ͧ sum ��  N/A ����� 0
			if (strip_tags ($val1) != "N/A" ){
				$is_all_na[$m][$j] = false; //�ҡ���ѹ��ѹ˹������� �����Ҽ������ͧ����� N/A 
			}

			$rowtext[$n] .= $val1;
			$rowtext[$n] .= "</td>";

		}  // for $j


	} // for $m

$rowtext[$n] .= "</tr>";
}


//SORT (28/10/2548)
//int strcmp ( string str1, string str2)
//Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they are equal. 

if ($allowsort){
	$keycol = $skey;  //column ������§

	if ($keycol >= 1 && $keycol <= count($cellvalue[1])){  //����� scope
		if (is_numeric($cellvalue[1][$keycol])){
			$number_compare = true;
		}else{
			$number_compare = false;
		}

		for ($k=1;$k<$n;$k++){
			for ($j=$k+1;$j<=$n;$j++){
				
				if ($sort_order[$keycol] == "asc"){ //������ҡ
				
					if ($number_compare){
						if ($cellvalue[$k][$keycol] > $cellvalue[$j][$keycol] ){
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
						if (strcmp($cellvalue[$k][$keycol],$cellvalue[$j][$keycol]) > 0){
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

					if ($number_compare){
						if ($cellvalue[$k][$keycol] < $cellvalue[$j][$keycol] ){
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
						if (strcmp($cellvalue[$k][$keycol],$cellvalue[$j][$keycol]) < 0){
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
for ($k=1;$k<=$n;$k++){
	$rowtext[$k] = eregi_replace ("#no#", "$k" ,$rowtext[$k]);  //᷹����ӴѺ���
	if ($k % 2) $ibg = "#DDDDDD"; else $ibg = "#EFEFEF"; 
	$rowtext[$k] = eregi_replace ("#IBG#", "$ibg" ,$rowtext[$k]);  //᷹����� Background
	echo $rowtext[$k];
}





//SUMMARY
echo "<tr bgcolor='$default_bg_color' valign=top>";
for ($m=0;$m<=$nround;$m++){   // �� 3 �ͺ����Ѻ Comparision
	if ($m == 0){ //�ͺ�á�������� 1 , �ͺ��� 2,3 ��������  startcolumn
		$startj = 1;  
	}else{
		$startj = $startcolumn+1;   
	}

	for ($j=$startj;$j<=$c;$j++){
			$cvalue[$m][$j] = 0;
	//		echo "<td " . GetCellProperty2($id,"I","2." . $j) . "width='$px%' colspan='1' rowspan='1'>";
			echo "<td " . GetCellProperty2($id,"I","2." . $j) . " colspan='1' rowspan='1' style='border-collapse:collapse; border:$bsize2 solid $bcolor2;'>";

			//GetCell Value
	//		$iresult = mysql_query("select * from cellinfo where rid=$id and sec='I' and cellno='2.$j';");
			$irs = SearchCellInfo("I","2.$j");
			if ($irs){
	//			$irs=mysql_fetch_array($iresult,MYSQL_ASSOC);
				$val1 = $irs[caption];

				$val1 = ReplaceSpecialParam2($val1,$j);

				if ($rs[rtype] >= 1 && $m == 2) {  // �ҡ �� Comparision column   Ẻ��� rtype == 1 ��ҹ�� ==2 ����ʴ�
					$a = floatval(strip_tags(ereg_replace(",","",$cvalue[1][$j]))); //��һբ�� 
					$b = floatval(strip_tags(ereg_replace(",","",$cvalue[0][$j]))); // ��һի��� 
					if (is_null($cvalue[1][$j]) || is_null($cvalue[0][$j]) || $cvalue[1][$j]== "N/A" || $cvalue[0][$j] == "N/A"){ //��һ�㴻�˹���� N/A
						$val1 = "N/A";
					}else if ($b != 0){
						$val1 = SetNumberFormat((($a - $b)/$b) * 100.00,1,1); //(��һբ�� - ��һի���) / ��һի��� 
					}else{
						//$val1 = "N/A";
						$val1 = "";
					}

					$cvalue[$m][$j] = $val1;

				}else if ($irs[celltype] == 1){
					$sql = str_replace(";","",$irs[cond]); 

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

					$xval = GetQueryValue($sql);
					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					$val1 .= $xval;
				}else if ($irs[celltype] == 2){
					$sql = str_replace(";","",$irs[cond]); 

					$xfld = explode(".",$irs[cond]);
					$sql = "select sum($xfld[1]) from " . $xfld[0] ;

					$paramcond = GetParamCondition($sql);
					if ($paramcond != ""){
						$sql .= " where $paramcond ";
					}

					$xval = GetQueryValue($sql);
					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					$val1 .= $xval;

				}else if ($irs[celltype] == 3){
					$xval="";
					if (trim($irs[cond]) > ""){
						$furl = ReplaceParam($irs[cond]);
						$xval = @trim(@implode(' ',@file($furl)));
					}

					$cvalue[$m][$j] = $xval;
					$xval = SetNumberFormat($xval,$irs[nformat],$irs[decpoint]);
					$val1 .= $xval;

				}else if ($irs[caption] == ""){
					if ($m == 2){ // comparision column 
						$val1 .= "&nbsp;";
					}else{
						if ($is_all_na[$m][$j]){ //	�ҡ�ء row � column ����� N/A ������ 23/3/2549
							$cvalue[$m][$j] = "N/A";
							$xval = "N/A";
						}else{
							$cvalue[$m][$j] = $csum[$m][$j];
							$xval = SetNumberFormat($csum[$m][$j],$irs[nformat],$irs[decpoint]); // ��Ҥ�� sum �ͧ field ����� �ҡ����ա�á�˹����
						}
						$val1 .= $xval;
					}
				}

				if ($irs[font]){
					$val1 = "<span style='$irs[font]'>$val1</span>";
				}

				if ($irs[url]){
					$iurl = ReplaceParam($irs[url]);
					$val1 = "<a href='$iurl'>$val1</a>";
//					$val1 = "<a href='$irs[url]' target='_blank'>$val1</a>";
				}
				
			}else{ // ����բ������Ź�� 
				$val1 = SetNumberFormat($csum[$m][$j],$irs[nformat],$irs[decpoint]); // ��Ҥ�� sum �ͧ field ����� �ҡ����ա�á�˹����
			}

			echo $val1;
			echo "</td>";
	}

}
echo "</tr>";

?>
</table>

<!-- END INFORMATION PORT -->

<BR>

<!-- FOOTNOTE -->
<table border=0 width="100%" align=center cellpadding=0 style="background-color:<?=$default_bg_color?>;	border-collapse:collapse; border:<?=$bsize4?> solid <?=$bcolor4?>;">

<?
ParseTable($rs[table4],$rs[tsize4]);
$cvalue = Array();   //clear array
$px = intval(100 / $c); // �������ҧ������


if ($r == 2){
	// 10/6/2549 ����� footnote �բ������������ �ҡ����ա�����ͧ�ʴ�
	$hasvalue = false;
	for ($i=1;$i<=$r;$i++){
		for ($j=1;$j<=$c;$j++){
			if (SearchCellInfo($sec,$cellno)){
				$hasvalue = true;
			}
		}
	}

}else{
	$hasvalue = true;
}


if ($hasvalue){

	for ($i=1;$i<=$r;$i++){
		echo "<tr bgcolor='$reportbgcolor' valign=top>";
		for ($j=1;$j<=$c;$j++){
			$cvalue[$j] = 0;
			$x = explode("x",$tspan[$i-1][$j-1]);
			$rspan = intval($x[0]);
			$cspan = intval($x[1]);
			if ($rspan > 0 && $cspan > 0){
				$cellvalue = GetCellSumValue($id,"F",$i . "." . $j);
				$cvalue[$j] = $cellvalue;


				// 28/12/2548
				//������ա�� set ��Ҥ������ҧ�������
				if (isset($rs[cwidth1]) && isset($rs[cwidth2]) && isset($rs[cwidth3]) && isset($rs[cwidth4])){
					$xpx = ReportGetColumnWidth($id,"F","1.$j");
					if ($xpx > "" && $cspan < 2){  //����� column span
						$cwidth = " width='$xpx' ";
					}else{
						$cwidth = "";  //����к�
					}
				}else{ // ����ա�á�˹���Ҥ������ҧ
					$cwidth = " width='$px%' "; 
				}
				// 28/12/2548

	?>
	<td <?=GetCellProperty2($id,"F",$i . "." . $j)?> <?=$cwidth?> colspan='<?=$cspan?>' rowspan='<?=$rspan?>' style="border-collapse:collapse; border:<?=$bsize4?> solid <?=$bcolor4?>;">

		<?=$cellvalue?>

	</td>
	<?
			}
		}
		echo "</tr>";
	} //for


} // if ($hasvalue)
?>
</table>

<?


// ��Ҥ�� parameter �ŧ�繵����
for ($param=1;$param <= count($paraminfo);$param++){ // ������ҡ 1 
	$xx = '$' . str_replace("#","",$paramname[$param]) . "='" . $paramdefault[$param] . "';";
//	echo $xx;
	eval($xx);
}

if ($rs[finclude]){
	@include "$rs[finclude]";
}

?>
<!-- END FOOTNOTE -->

<!-- End Display Table & Merge Cell -->

<BR>

</td></tr></table>  <!-- End Main Table - Fix Width to 790 -->

</body>
</html>
