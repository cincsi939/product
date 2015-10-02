<?php
$nochecklogin=true;
include("../../../config/config_epm.inc.php");
include('service_function.php');
$db_name = 'dcy_usermanager';

function getCCAAname($id=''){
	$strSQL = "SELECT ccName FROM ccaa WHERE ccDigi='{$id}' ";
	$Fetch = mysql_db_query(getDataBase(), $strSQL) or die(mysql_error());
	$Result = mysql_fetch_assoc($Fetch);
	return $Result['ccName'];
}

$strSQL = "SELECT
							org_staffgroup.gid,
							org_staffgroup.groupname,
              org_staffgroup.comment,
							org_staffgroup.tambon,
							org_staffgroup.amphur,
							org_staffgroup.province,
							org_staffgroup.latitude,
							org_staffgroup.longitude
						FROM org_staffgroup
						WHERE org_staffgroup.gid='".$_GET['gid']."'
          ";

$Fetch = mysql_db_query($db_name, $strSQL) or die(mysql_error());
$Result = mysql_fetch_assoc($Fetch);
$data = getCCAAname($Result['tambon']).' '.getCCAAname($Result['amphur']).' '.getCCAAname($Result['province']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>Identify</title>
</head>
<body style="background-color:#FFF; margin-left:0px; margin-top:0px; margin-right:0px;">
<table width="95%" border="0" cellspacing="1" cellpadding="1">
  <tr style="background-color:#FFF;font-size:10px;">
    <td >
    <?php echo $Result['comment'];?>
    </td>
  </tr>
  </table>
  </td>
  </tr>
</table>
</body>
</html>
