<?
session_start();
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");
function ShowOrgArea($siteid){
		$sql = "SELECT secname FROM eduarea WHERE secid='$siteid'";
		$result = mysql_db_query(DB_MASTER,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];
}
function ShowOrgSchool($id){
	$sql = "SELECT office FROM allschool WHERE id='$id'";	
	$result = mysql_db_query(DB_MASTER,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
}
if($action == "process"){
		$sql = "SELECT * FROM tbl_checklist_kp7_false WHERE profile_id='4' AND status_chang_idcard='NO' AND status_IDCARD LIKE  '%IDCARD_FAIL%' ";
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
/*		echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">
  <tr>
    <td width=\"5%\" align=\"center\">ลำดับ</td>
    <td width=\"24%\" align=\"center\">เลขบัตร</td>
    <td width=\"25%\" align=\"center\">ชื่อนามสกุล</td>
    <td width=\"26%\" align=\"center\">ตำแหน่ง</td>
    <td width=\"20%\" align=\"center\">หน่วยงานสังกัด</td>
  </tr>";*/
		while($rs = mysql_fetch_assoc($result)){
			$sqlc = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_kp7 WHERE name_th='$rs[name_th]' AND surname_th='$rs[surname_th]' AND siteid='$rs[siteid]' AND schoolid='$rs[schoolid]' AND profile_id='$rs[profile_id]'";
			$resultc = mysql_db_query($dbname_temp,$sqlc);
			$rsc = mysql_fetch_assoc($resultc);
			if($rsc[num1] > 0){
				
				$sql_update = "UPDATE tbl_checklist_kp7_false SET status_chang_idcard='YES'   WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
				mysql_db_query($dbname_temp,$sql_update);
			//	$i++;
/*	echo "
  <tr>
    <td align=\"center\">$i</td>
    <td align=\"center\">$rs[idcard]</td>
    <td align=\"left\">$rs[prename_th]$rs[name_th] $rs[surname_th]</td>
    <td align=\"left\">$rs[position_now]</td>
    <td align=\"left\">".ShowOrgArea($rs[siteid])."/".ShowOrgSchool($rs[schoolid])."</td>
  </tr>
";
*/			}//end 
				
		}//end while($rs = mysql_fetch_assoc($result)){
			//echo "</table>";
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
