<?
session_start();
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");
if($action == "process"){
			$sql = "SELECT count(idcard) as numid, idcard,concat(prename_th,name_th,surname_th,siteid,birthday) as groupname,name_th,surname_th,siteid,birthday FROM `tbl_checklist_kp7` where profile_id='4'   group by groupname having numid > 1";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT * FROM tbl_checklist_kp7 WHERE name_th='$rs[name_th]' AND surname_th='$rs[surname_th]' AND siteid='$rs[siteid]' AND birthday='$rs[birthday]' AND status_id_false='0' AND profile_id='4'";
			$result1 = mysql_db_query($dbname_temp,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$sql2 = "SELECT * FROM tbl_checklist_kp7 WHERE name_th='$rs[name_th]' AND surname_th='$rs[surname_th]' AND siteid='$rs[siteid]' AND birthday='$rs[birthday]' AND status_id_false='1' AND profile_id='4'";
			$result2 = mysql_db_query($dbname_temp,$sql2);
			$rs2 = mysql_fetch_assoc($result2);
			$new_id = $rs1[idcard]; //เลขบัตรที่ถูกต้อง
			$old_id = $rs2[idcard];// เลขบัตรจำลอง
			
			##########  ลบรายการเลขบัตรใหม่ออก
			if($new_id != "" and $old_id != ""){
			$sqldel = "DELETE FROM tbl_checklist_kp7  WHERE idcard='$new_id' AND profile_id='4'";
			//mysql_db_query($dbname_temp,$sqldel);
			echo $sqldel."<br>";
			foreach($arrtbl_checklist as $key => $val){
				$arrkey = explode(",",$val);
				$wkey1 = $arrkey[0]; // idcard
				$wkey2 = $arrkey[1]; // profile_id
				if($key == "tbl_checklist_kp7"){
					$sql_update = "UPDATE $key SET idcard='$new_id',status_id_false='0' WHERE $wkey1='$old_id' AND $wkey2='4'";
				}else{
					$sql_update = "UPDATE $key SET idcard='$new_id'  WHERE $wkey1='$old_id' AND $wkey2='4'";	
				}
				//mysql_db_query($dbname_temp,$sql_update);
				echo $sql_update."<br>";
				
				}//end 	foreach($arrtbl_checklist as $key => $val){
			
		}//end if($new_id != "" and $old_id != ""){
				
		}//end while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process"){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>


</head>
<body>

<a href="?action=process">process</a>
</body>
</html>
