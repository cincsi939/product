<?
include("checklist2.inc.php");

if($_POST[submit]){
	foreach($_POST[config_val] as $id=>$val){
		mysql_db_query($dbnamemaster,$sql_update="UPDATE config_tranfer_cmss SET config_status='{$val}' WHERE config_id='{$id}' ");
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ปลดล็อกเงื่อนไขการจำเข้าข้อมูล</title>
<script language="javascript" src="js/jquery-1.3.2.js"></script>
</head>
<style>
table{
border-collapse:collapse;
}
table,th, td{
border: 1px solid black;
}
thead{text-align:center; font-weight:bold; background-color:#CCC}
</style>
<body>
<form action="" method="post">
<strong>ปลดล็อกเงื่อนไขการจำเข้าข้อมูล</strong><br>
<table width="600">
<thead>
	<tr>
    	<th width="50">ลำดับ</th>
        <th>เงื่อนไข</th>
        <th width="150">สถานะ</th>
    </tr>
</thead>
<tbody>
	<?
	$sql="SELECT
	t1.config_id,
	t1.config_field_name,
	t1.config_value,
	t1.config_status
	FROM
	config_tranfer_cmss AS t1
	ORDER BY t1.config_id";
	$rs=mysql_db_query($dbnamemaster,$sql);
	$num=1; $numrow=mysql_num_rows($rs);
	while($row=mysql_fetch_assoc($rs)){
	?>
	<tr>
    	<td align="center"><?=$num?></td>
        <td><?=$row[config_field_name]?></td>
        <td align="center">
        <select name="config_val[<?=$row[config_id]?>]" id="sel<?=$num?>" style="background:<? if($row[config_status]=="Y"){ echo "#0C0";}else{ echo "#FF2929";}?>" onChange="if(this.value=='Y'){ $('#sel<?=$num?>').css('background','#0C0');}else{ $('#sel<?=$num?>').css('background','#FF2929');}"> 
        	<option value="Y" <? if($row[config_status]=="Y"){ echo "selected";}?>>เปิด</option>
            <option value="N" <? if($row[config_status]=="N"){ echo "selected";}?>>ปิด</option>
        </select>
        </td>
    </tr>
    <? $num++; } ?>
</tbody>
<tfoot>
	<tr><th colspan="2"></th><th><input type="submit" name="submit" value="บันทึก"></th></tr>
</tfoot>
</table>
</form>
</body>
</html>