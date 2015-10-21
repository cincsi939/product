<?php
require_once('reader.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>reader</title>
</head>

<body style="font-size:12px;">
<?php
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('TIS-620');

$data->read('helpdest_data.xls');
$setstrartrow = 2;
for ($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
  $typeid_new = trim($data->sheets[0]['cells'][$i][1]);
  $typeid_old = trim($data->sheets[0]['cells'][$i][2]);
  $type =  trim($data->sheets[0]['cells'][$i][3]);
  $comment = trim($data->sheets[0]['cells'][$i][4]);
  echo $typeid_new;
  echo "--------";
  echo $typeid_old;
  echo "--------";
  echo $type;
  echo "--------";
  echo $comment;
  echo "<br><br>";
  $sub_comment =  trim(substr($comment,0,25));
  echo $sub_comment;
  echo "<br>";
  $sql_update = "UPDATE callcenter_ptype SET typeid = '$typeid_new' WHERE typeid = '$typeid_old' AND TRIM(SUBSTRING(pcomment, 1, 25)) = '$sub_comment'  ";
  mysql_db_query('callcenter_otcsc_helpdesk',$sql_update)or die(mysql_error());
  echo "<br>";
  echo "<hr>";
}
?>
</body>
</html>
