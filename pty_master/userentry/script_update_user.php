<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		จัดการผู้ใช้
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

include "epm.inc.php";
$report_title = "บุคลากร";
function mk_username($ename,$esurname,$eid,$xsapphireoffice=""){
global $epm_staff  ;
$ename = trim($ename);
$esurname = trim($esurname);


	if($xsapphireoffice == "2"){
		$length_sub = "4";
	}else{
		$length_sub = "3";	
	}
	$uname = strtolower($ename.".".substr($esurname,0,$length_sub));
	$lastuname = $uname;
	$n = 3; $k=0;
	$sql1 = "SELECT COUNT(username) AS num1  FROM $epm_staff WHERE username='$uname' AND staffid <> '$eid' ";
	$result1 = mysql_query($sql1);
	$xnum = @mysql_num_rows($sql1);
	if($xnum < 1){
		return $uname;	
	}else{
		$length_sub = $length_sub+1;
		$xuname = strtolower($ename.".".substr($esurname,0,$length_sub));
		$sql2 = "SELECT COUNT(username) AS num1  FROM $epm_staff WHERE username='$xuname' AND staffid <> '$eid' ";
		$result2 = mysql_query($sql2);
		$xnum2 = @mysql_num_rows($result2);
		if($xnum2 < 1){
				return $xuname;
		}else{
			$length_sub = $length_sub+2;
			$xuname1 = strtolower($ename.".".substr($esurname,0,$length_sub));
			return $xuname1;
		}
		
	}//end if($xnum < 1){
		
}//end function mk_username($ename,$esurname,$eid){
	
	$sql = "SELECT
keystaff.staffid,
keystaff.engname,
keystaff.engsurname,
keystaff.username,
keystaff.`password`
FROM `keystaff`
WHERE `sapphireoffice` = '2' AND engname <> '' and engname IS NOT NULL and engsurname <> '' and engsurname IS NOT NULL
";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$xusername = mk_username($rs[engname],$rs[engsurname],$rs[staffid],2);
		$sql_up = "UPDATE keystaff SET username='$xusername',password='logon' WHERE staffid='$rs[staffid]'";
		mysql_db_query($dbnameuse,$sql_up)or die(mysql_error()."$sql_up<br>".__LINE__);
		echo "$sql_up<br>";
			
	}

?>
