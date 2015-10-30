<?
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$month 			= array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

function DBThaiLongDateFull($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	if($d == "0000-00-00 00:00:00") return "";
	$arrd = explode(" ",$d);
	if($arrd[1] != ""){
		$time = " ���� ".$arrd[1]." �.";	
	}else{
		$time = "";
	}
	
	$d1=explode("-",$arrd[0]);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543) ." ".$time;
}

function GetDateThaiReport($d){
global $monthname;
	if (!$d) return "";
	if ($d == "00/00/0000") return "";
	
	$d1=explode("/",$d);
	return intval($d1[0]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[2]));
}


function ConvdateQuery($d){
	
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	if($d == "0000-00-00") return "";
	if($d == "00/00/0000") return ""; 
		$d1=explode("/",$d);
		return ($d1[2]-543). "-" . $d1[1] . "-" . $d1[0];
}


function DBThai($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	$d1=explode("-",$d);
	if(intval($d1[2]) > 0){
			$dd = intval($d1[2]);
	}else{
			$dd = "";	
	}
	if(intval($d1[1]) > 0){
		$mm = 	$shortmonth[intval($d1[1])];
	}else{
		$mm = "";	
	}
	return  $dd. " " . $mm . " " . (intval($d1[0]));
}


function GetArea($siteid){
	global $dbnamemaster;
	$sql = "SELECT secname_short FROM eduarea WHERE  secid = '$siteid'";	
	$res = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($res);
	return $rs[secname_short];
}

?>