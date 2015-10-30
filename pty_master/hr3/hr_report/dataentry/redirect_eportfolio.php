<? 
session_start();
session_destroy();
include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>เข้าสู่ระบบฐานข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="common/style.css" rel="stylesheet" type="text/css">
</head>
</html><body bgcolor="#FFFFFF">
<?
$sql = " select  IP,secid  from eduarea  INNER JOIN  area_info  ON  eduarea.area_id = area_info.area_id   where eduarea.secid = '$secname'  ";
$result = mysql_query($sql);
$rs = mysql_fetch_assoc($result);
$reporturl = "http://$rs[IP]/$aplicationpath/application/hr3/log_eportfolio.php?secid=$rs[secid]&action=login";

					echo "<script language=\"javascript\">
					top.location.href='$reporturl';
					</script>" ;
					exit;
?>


