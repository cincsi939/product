<?
session_start();

include("checklist.inc.php");
### function ตรวจสอบเลขบัตรซ้ำกับเขตอื่น
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>update ข้อมูลหน่วยงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<?
if($action == "run"){
$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.prename_th,
edubkk_checklist.tbl_checklist_kp7.name_th,
edubkk_checklist.tbl_checklist_kp7.surname_th,
edubkk_checklist.tbl_checklist_kp7.position_now,
edubkk_checklist.tbl_checklist_kp7.schoolid,
edubkk_master.allschool.id,
edubkk_master.allschool.office,
edubkk_checklist.tbl_checklist_kp7.siteid as site_id,
edubkk_master.allschool.siteid as site_id1
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid <>  edubkk_master.allschool.siteid
order by edubkk_checklist.tbl_checklist_kp7.siteid ASC
";
$result = mysql_db_query(DB_CHECKLIST,$sql);
$i=0;
	while($rs = mysql_fetch_assoc($result)){
		$sql_school = "SELECT id FROM allschool WHERE siteid='$rs[site_id]' AND office='$rs[office]'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_s = mysql_fetch_assoc($result_school);
		if($rs_s[id] != ""){
			$i++;
			$sql_update  = "UPDATE tbl_checklist_kp7 SET schoolid='$rs_s[id]' WHERE idcard='$rs[idcard]'";	
			//mysql_db_query(DB_CHECKLIST,$sql_update);
			echo $sql_update."<br>";
		}
	}
	
	echo "จำนวน $i รายการ";
}//end if($action == ""){
?>
<a href="?action=run">ประมวลผลข้อมูล</a>
</body>
</html>
