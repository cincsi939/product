<?


session_start();

//$limitrow = " LIMIT 10";
include("checklist2.inc.php");

	$db_dbf = "temp_pobec_import_checklist";
/*	$sql = "SELECT
	t1.IDCODE,
	t1.NAME1,
	t1.NAME2,
	t2.POST_NAME,
	t1.DATE_B,
	t1.DATE_F
	FROM  temp_ranong1 as t1 left  join postcode as t2 on t1.POST_CODE=t2.POST_CODE
	WHERE t1.IDCODE <> '' $limitrow";
	$result  = mysql_db_query($db_dbf,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrb1 = explode("-",$rs[DATE_B]);
		$arrb2 = explode("-",$rs[DATE_F]);
		$birthday= ($arrb1[0]+543)."-".$arrb1[1]."-".$arrb1[2];
		$begindate = ($arrb2[0]+543)."-".$arrb2[1]."-".$arrb2[2];
		$sql_update = "UPDATE tbl_checklist_kp7 SET position_now='$rs[POST_NAME]',birthday='$birthday',begindate='$begindate'  WHERE idcard='$rs[IDCODE]' and siteid='8501' and profile_id='5'";
		//echo "$sql_update<br>";	
		mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()." LINE ".__LINE__);
	}// end while($rs = mysql_fetch_assoc($result)){
*/

$arrp = array('นางสาว'=>'น.ส.','นาง'=>'นาง','นาย'=>'นาย','พ.จ.อ.'=>'พ.จ.อ.','ว่าที่ ร.ต.'=>'ว่าที่ ร.ต.','ส.อ.'=>'ส.อ.');


foreach($arrp as $key => $val){
	$sql = "SELECT
	fullname,
	org,
	posito_now,
	idcard,
	prename_th,
	name_th,
	surname_th
	FROM `temp_supan` WHERE fullname LIKE '$val%'";
	$result = mysql_db_query($db_dbf,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr = explode("  ",trim($rs[fullname]));	
		$name_th = trim(str_replace($val,"",$arr[0]));
		$surname_th = trim($arr[1]); // คำนำหน้าชื่อ
		$sql_update = "UPDATE temp_supan SET prename_th='$key',name_th='$name_th',surname_th='$surname_th' WHERE idcard='$rs[idcard]' and fullname like '%$rs[fullname]%'";
		//echo $sql_update."<br>";
		mysql_db_query($db_dbf,$sql_update) or die(mysql_error());
	}// end while($rs = mysql_fetch_assoc($result)){
}// foreach($arrp as $key => $val){
echo "OK";
?>
