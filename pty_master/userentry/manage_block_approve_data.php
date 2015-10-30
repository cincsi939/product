<?php
include ("../../common/common_competency.inc.php");
include ("../../common/std_function.inc.php");
include ("epm.inc.php");
$db = DB_USERENTRY;
if($_POST['btn_save']!=''){
	$i = $_POST['countId']-1;
	for($ii=1;$ii<=$i;$ii++){
		if($_POST['chkChange'.$ii]=='1'){
			$re = update_error_code($_POST['runid'.$ii],$_POST['chkNew'.$ii]);
		}
	}
	if($re){
		echo '<script>alert("บันทึกเรียบร้อยแล้ว!!"); window.location = "?";</script>';
	}
}

function update_error_code($runid,$status){
	global $db;
	$sql='
		update tbl_error_code set
		status_block = '.$status.'
		where runid = '.$runid.'
	';
	//echo $sql;
	$rs = mysql_db_query($db,$sql)or die(mysql_error());
	
	return $rs;
}

$sql='
	select * from tbl_error_code;
';
$rs = mysql_db_query($db,$sql)or die(mysql_error());
while($re = mysql_fetch_assoc($rs)){
	 $arr[$re['runid']] = $re;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>supervisor</title>
<script type="text/javascript" src="../../common/jquery/1.4/jquery.min.js"></script>
<script>
	function changImg(i){
		if($("#chkNew"+i).val()==0){
			$("#chkNew"+i).val('1');
			$("#TDdetail"+i).html("<img src='images/turnon.png' width='24' style='cursor:pointer;' onClick='changImg("+i+");'>");
		}else{
			$("#chkNew"+i).val('0');
			$("#TDdetail"+i).html("<img src='images/turnoff.png' width='24' style='cursor:pointer;' onClick='changImg("+i+");'>");
		}
		
		if($("#chkOld"+i).val()!=$("#chkNew"+i).val()){
			$("#chkChange"+i).val('1');
		}else{
			$("#chkChange"+i).val('0');
		}
	}
</script>
<style>
body{
	color:#4C4C4C;
}
table{
	border:1px solid #333;
}
thead{
	background-color:#999;
	color:#FFF;
}
tbody tr:hover{
	background-color:#CCFFF4;
}
</style>
</head>
<body>
<h3 align="center">เครื่องมือควบคุมการตรวจสอบข้อมูลของทีม supervisor</h3>
<form name="frm" method="post">
<div align="right"><input name="btn_save" type="submit" value="  ยืนยันการบันทึกรายการ  " /></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<thead>
	<tr height="40">
    	<th>ลำดับ</th>
        <th>รหัสข้อมูลผิดพลาด</th>
        <th>รายการข้อมูล</th>
        <th>ปิด/เปิด</th>
    </tr>
</thead>
<tbody>
<?php 
$bg = array('#CCCCCC','#FFF');
$i=1;
foreach($arr as $id=>$val){
	if($val['status_block']=='1'){
		$pic = '<img src="images/turnon.png" width="24" style="cursor:pointer;" onClick="changImg('.$i.');">';
	}else{
		$pic = '<img src="images/turnoff.png" width="24" style="cursor:pointer;" onClick="changImg('.$i.');">';
	}
	echo '
		<tr bgcolor="'.$bg[$i%2].'">
			<td align="center">'.$i.'</td>
			<td align="center">'.$val['error_code'].'</td>
			<td>'.$val['error_comment'].'</td>
			<td align="center" id="TDdetail'.$i.'">'.$pic.'</td>
		</tr>
	';
	
	echo '
		<input type="hidden" id="chkOld'.$i.'" name="chkOld'.$i.'" value="'.$val['status_block'].'">
        <input type="hidden" id="chkNew'.$i.'" name="chkNew'.$i.'" value="'.$val['status_block'].'">
        <input type="hidden" id="chkChange'.$i.'" name="chkChange'.$i.'" value="0">
		<input type="hidden" id="runid'.$i.'" name="runid'.$i.'" value="'.$val['runid'].'">
	';
	$i++;
}
	echo '<input type="hidden" name="countId" value="'.$i.'">';
?>
</tbody>
</table>
</form>
</body>
</html>