<?php
include "epm.inc.php";
include('../../config/config_host.php');
?>
<html>
<head>
<title>application management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body >
<?php
	if($_GET['org_id'] != '' && $_GET['insert_id'] != ''){
		$sql_delete = "DELETE FROM org_staffgroup WHERE parent = '{$_GET[insert_id]}' ";
		mysql_db_query(DB_USERMANAGER,$sql_delete);
		
		$sql = "SELECT
		t1.org_id,
		t1.parent_id,
		t1.org_name,
		t1.areaid,
		tambon.ccDigi AS tambon_id,
		tambon.ccName AS tambon,
		amphur.ccDigi AS amphur_id,
		amphur.ccName AS amphur,
		provice.ccDigi AS provice_id,
		provice.ccName AS provice
		FROM
		'.DB_USERMANAGER.'.organization AS t1
		INNER JOIN cmss_master.ccaa AS tambon ON t1.areaid = tambon.areaid
		INNER JOIN cmss_master.ccaa AS amphur ON CONCAT(SUBSTR(tambon.ccDigi,1,5),'000') = amphur.ccDigi
		INNER JOIN cmss_master.ccaa AS provice ON CONCAT(SUBSTR(amphur.ccDigi,1,3),'00000') = provice.ccDigi
		WHERE
		t1.org_name LIKE 'องค์การบริหารส่วนตำบล%' ";
		$result = mysql_db_query(DB_USERMANAGER,$sql);
		while($obj = mysql_fetch_object($result)){
			$sql_insert = "INSERT INTO org_staffgroup SET
			org_id = '2',
			parent = {$_GET[insert_id]},
			groupname = '{$obj->org_name}',
			province = '{$obj->provice_id}',
			amphur = '{$obj->amphur_id}',
			tambon = '{$obj->tambon_id}' ";
			mysql_db_query(DB_USERMANAGER,$sql_insert);
			echo $obj->org_id.' '.$obj->org_name.'<br>';
		}
	}elseif($_GET['from'] == 'edubkk'){
		$sql_delete = "DELETE FROM org_staffgroup WHERE parent = '{$_GET[insert_id]}' ";
		mysql_db_query(DB_USERMANAGER,$sql_delete);
		
		$sql = "SELECT
		t1.secid,
		t1.secname,
		t2.ccDigi AS provice_id,
		t3.ccDigi AS amphur_id
		FROM
		eduarea AS t1
		INNER JOIN cmss_master.ccaa AS t2 ON t1.name_proth = t2.ccName
		LEFT JOIN cmss_master.ccaa AS t3 ON REPLACE(t1.secname,'สำนักงาน','') = t3.ccName
		WHERE t1.secid NOT IN('0101','1000') ";	
		$result = mysql_db_query(DB_USERMANAGER,$sql);
		while($obj = mysql_fetch_object($result)){
			$sql_insert = "INSERT INTO org_staffgroup SET
			org_id = '2',
			parent = {$_GET[insert_id]},
			groupname = '{$obj->secname}',
			province = '{$obj->provice_id}',
			amphur = '{$obj->amphur_id}',
			tambon = '' ";
			mysql_db_query(DB_USERMANAGER,$sql_insert);
			echo $obj->secid.' '.$obj->secname.'<br>';
		}
	}
?>
</body>
</html>