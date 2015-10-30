<?
function CheckInsertTemp($staffid,$idcard){
	global $dbnameuse;
	$sql = "SELECT COUNT(*) AS num1 FROM stat_user_keyperson WHERE staffid='$staffid' AND idcard='$idcard' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CheckInsertTemp($staffid,$idcard){
	
function GetGroup_id($staffid){
	global $dbnameuse;
	$sql = "SELECT
keystaff_group.groupkey_id,
keystaff_group.rpoint,
keystaff.staffid
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE staffid='$staffid'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$arrid['id'] = $rs[groupkey_id];
	$arrid['rpoint'] = $rs[rpoint];
	return $arrid;
}

function InsertSubTempPerson($staffid,$idcard){
	global $dbnameuse;
	if(CheckInsertTemp($staffid,$idcard) < 1){
		$arrid = GetGroup_id($staffid);
		$sql_insert = "INSERT INTO stat_user_keyperson SET datekeyin='".date("Y-m-d")."',staffid='$staffid',idcard='$idcard',status_approve='1',keyin_group='".$arrid['id']."',rpoint='".$arrid['rpoint']."'"; 
		mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
	}
}//end  function InsertTempPerson(){








	



?>