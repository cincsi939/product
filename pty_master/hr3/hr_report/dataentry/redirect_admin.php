<? 
session_start();
include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>�������к��ҹ������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="common/style.css" rel="stylesheet" type="text/css">
</head>
</html><body bgcolor="#FFFFFF">
<?
$sql = " select  IP,secid  from eduarea  INNER JOIN  area_info  ON  eduarea.area_id = area_info.area_id   where eduarea.secid = '$secname'  ";
$result = mysql_query($sql);
$rs = mysql_fetch_assoc($result);
$reporturl = "http://$rs[IP]/$aplicationpath/application/hr3/indexadmin.php?secname=$rs[secid]&action=login";

					echo "<script language=\"javascript\">
					window.open('$reporturl','_top');
					</script>" ;
					exit;
?>

