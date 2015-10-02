<?php
include "epm.inc.php";
?>
<html>
<head>
<title>application management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body >
<?php
		$sql = "SELECT
		t1.gid,
		t1.parent,
		t1.`comment`
		FROM
		org_staffgroup AS t1
		WHERE t1.parent = '0' ";
		$result = mysql_db_query('opp_usermanager',$sql);
		while($obj = mysql_fetch_object($result)){
			$arrySubfix[$obj->gid] = $obj->comment;
		}
		echo '<pre>';
		print_r($arrySubfix);
		echo '</pre>';
		
		$sql = "SELECT
		t1.gid,
		t1.parent,
		SUBSTR(t1.province,1,2) AS pv
		FROM
				org_staffgroup AS t1
		WHERE t1.parent != '0' ";
		$result = mysql_db_query('opp_usermanager',$sql);
		while($obj = mysql_fetch_object($result)){
			if(strlen($obj->gid) == '1'){
				$digi = '0000'.$obj->gid;
			}elseif(strlen($obj->gid) == '2'){
				$digi = '000'.$obj->gid;
			}elseif(strlen($obj->gid) == '3'){
				$digi = '00'.$obj->gid;
			}elseif(strlen($obj->gid) == '4'){
				$digi = '0'.$obj->gid;
			}elseif(strlen($obj->gid) == '5'){
				$digi = $obj->gid;
			}
			
			$user = 'opp-'.$arrySubfix[$obj->parent].$obj->pv.$digi;
			$pass = 'logon';
			
			$sql_insert = "INSERT INTO epm_staff SET
			gid = '1',
			org_id = '2',
			username = '{$user}',
			password = '{$pass}' ";
			mysql_db_query('opp_usermanager',$sql_insert);
			$staff_id = mysql_insert_id();
			
			$sql_insert = "INSERT INTO org_groupmember SET
			gid = '{$obj->gid}',
			staffid = '{$staff_id}' ";
			mysql_db_query('opp_usermanager',$sql_insert);
		}
?>
</body>
</html>