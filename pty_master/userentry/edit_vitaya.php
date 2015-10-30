<?php
##include("../../../../config/conndb_nonsession.inc.php");
include("../../config/conndb_nonsession.inc.php")
include "function_vitaya.php";
$siteid = $_GET['xsiteid'];
$site = $_GET['xsiteid'];
$idcard = $_GET['idcard'];
$dbname = STR_PREFIX_DB.$siteid;
##defind parameter for check vitaya
$date_valid = "2547-10-01";
$date_for_check = "2547-12-24";
$arr_vitaya_word = array('ชำนาญการ','เชี่ยวชาญ','ขำนาญการ','เขี่ยวชาญ','ชำนาณการ','เชี่ยวชาณ','ชำนานการ','เชี่ยวชาน','เชียวชาญ');
##start check vitaya
if($_GET['first_time'] == "1"){
 include "check.php";
} 

if($_POST['bt_save'] != ""){
  $dbname = STR_PREFIX_DB.$_POST['siteid'];
  $sql_vitaya_name = "SELECT * FROM vitaya WHERE runid = '".$_POST['select_vitaya']."' ";
  $query_vitaya_name = mysql_db_query(DB_MASTER,$sql_vitaya_name)or die(mysql_error());
  $rows_vitaya_name = mysql_fetch_array($query_vitaya_name);
  $sql_update = "UPDATE vitaya_stat SET salary_id = '".$_POST['salary_id']."' , vitaya_id = '".$_POST['select_vitaya']."' , 
                                        name = '".$rows_vitaya_name['vitayaname']."' , remark = '".$_POST['remark']."' ,
										date_command = '".$_POST['date_command']."' ,date_start = '".$_POST['date_start']."'
				 WHERE id = '".$_POST['idcard']."' AND salary_id = '".$_POST['salary_id_old']."' ";
  mysql_db_query($dbname,$sql_update)or die(mysql_error());
  echo "<script>top.location='?siteid=".$_POST['siteid']."&idcard=".$_POST['siteid']."&xsiteid=".$_POST['siteid']."&fullname=".$_GET['fullname']."$txt_link'</script>";				 
}
if($_POST['bt_add'] != ""){
   $dbname = STR_PREFIX_DB.$_POST['siteid'];
   $sql_vitaya_name = "SELECT * FROM vitaya WHERE runid = '".$_POST['select_vitaya_add']."' ";
   $query_vitaya_name = mysql_db_query(DB_MASTER,$sql_vitaya_name)or die(mysql_error());
   $rows_vitaya_name = mysql_fetch_array($query_vitaya_name);
   
   #check duplicate
   $sql_check = "SELECT * FROM  vitaya_stat WHERE id = '".$_POST['idcard']."' AND salary_id = '".$_POST['salary_id_add']."' ";
   $query_check = mysql_db_query($dbname,$sql_check)or die(mysql_error());
   $num_check = mysql_num_rows($query_check);
   if($num_check == 0){
   
   #add log
   $sql_log = "INSERT INTO log_update_vitaya(runid,idcard,siteid,salary_id,vitaya_id,vitaya_name,staff_id,update_time)
                VALUES(NULL,'".$_POST['idcard']."','".$_POST['siteid']."','".$_POST['salary_id_add']."','".$_POST['select_vitaya_add']."',
				      '".$rows_vitaya_name['vitayaname']."','".$_SESSION['session_staffid']."',NOW())";
   mysql_db_query(DB_MASTER,$sql_log)or die(mysql_error());
   
   #add vitaya
   $sql_vitaya = "INSERT INTO vitaya_stat(id,salary_id,vitaya_id,name,date_command,date_start,remark,updatetime)
                              VALUES('".$_POST['idcard']."','".$_POST['salary_id_add']."','".$_POST['select_vitaya_add']."','".$rows_vitaya_name['vitayaname']."',
							  '".$_POST['date_command']."','".$_POST['date_start']."','".$_POST['remark_add']."',NOW())";	
   mysql_db_query($dbname,$sql_vitaya)or die(mysql_error());
   
   }else{
     echo "<script>alert('มีเลขที่คำสั่งนี้อยู่แล้ว');</script>";
   }
   echo "<script>top.location='?siteid=".$_POST['siteid']."&idcard=".$_POST['siteid']."&xsiteid=".$_POST['siteid']."&fullname=".$_GET['fullname']."$txt_link';</script>";							  				  
}
if($_GET['module'] == 'delete'){
  $dbname = STR_PREFIX_DB.$_GET['siteid'];
  $sql = "DELETE FROM vitaya_stat WHERE id = '".$_GET['idcard']."' AND salary_id = '".$_GET['salary_id']."' ";
  mysql_db_query($dbname,$sql)or die(mysql_error());
  echo "<script>top.location='?siteid=".$_GET['siteid']."&idcard=".$_GET['siteid']."&xsiteid=".$_GET['siteid']."&fullname=".$_GET['fullname']."$txt_link'</script>";
}

?>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#CC0000" style="border-collapse:collapse" bgcolor="#FFDFDF">
  <tr>
    <td><strong><font color="#990000">กรุณาตรวจสอบความถูกต้องของการได้วิทยฐานะตามข้อมูลด้านล่าง แล้วทำการยืนยันความถูกต้อง ก่อนที่จะบันทึกสถานะความพร้อมในการตรวจสอบข้อมูล</font></strong></td>
  </tr>
</table>
<br />
<?php
 $sql_s = "SELECT salary.*,vitaya_stat.salary_id,vitaya_stat.name FROM salary 
           LEFT JOIN vitaya_stat ON vitaya_stat.salary_id = salary.runid AND vitaya_stat.id = salary.id
           WHERE salary.id = '$idcard' AND salary.date >= '$date_valid'  ORDER BY salary.runno ";		   		   
 $query_s = mysql_db_query($dbname,$sql_s)or die(mysql_error());
?>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="3%" align="center" bgcolor="#CCCCCC">runno</td>
    <td width="9%" align="center" bgcolor="#CCCCCC">วันที่</td>
    <td width="12%" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
    <td width="14%" align="center" bgcolor="#CCCCCC">ระดับ</td>
    <td width="32%" align="center" bgcolor="#CCCCCC">คำอธิบาย</td>
    <td width="15%" align="center" bgcolor="#CCCCCC">เลขที่คำสั่ง</td>
	<td width="15%" align="center" bgcolor="#CCCCCC">วิทยฐานะ</td>
  </tr>
<?php
 while($rows_s = mysql_fetch_array($query_s)){
   if($rows_s['salary_id'] != ""){
     $bg = 'bgcolor="#CAFFCA"';
   }else{
     $bg = '';
   }
?>
 <tr <?=$bg?>>
   <td><div align="center"><?=$rows_s['runno']?></div></td>
   <td>
   <?php
	  $arr_date_th = explode("-",$rows_s['date']);
	  echo (int)$arr_date_th[2]." ".$month_th[(int)$arr_date_th[1]]." ".$arr_date_th[0];
	?>
   </td>
   <td><?=$rows_s['position']?></td>
   <td><?=$rows_s['radub']?></td>
   <td><?=$rows_s['pls']?></td>
   <td><?=$rows_s['noorder']?></td>
   <td><?=$rows_s['name']?></td>
 </tr>
<?php 
 }
?> 
</table>

<br />
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="3" >
  <tr>
    <td><a href="?siteid=<?=$siteid?>&idcard=<?=$idcard?>&module=add&xsiteid=<?=$siteid?>&fullname=<?=$_GET['fullname']?><?=$txt_link?>#add_vitaya">
	     <strong>[+ เพิ่มวิทยฐานะ]</strong>
		</a>
	</td>
  </tr>
</table>
<?php
if($_GET['module'] == 'add'){
?>
<a name="add_vitaya"></a>
<form action="?siteid=<?=$siteid?>&idcard=<?=$idcard?>&xsiteid=<?=$siteid?>&fullname=<?=$_GET['fullname']?><?=$txt_link?>" method="post">
<fieldset style="width:500px;">
<legend><strong>เพิ่มวิทยฐานะ</strong></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="27%" align="right">คำสั่งที่</td>
    <td width="73%">
	<input name="idcard" type="hidden" value="<?=$idcard?>" />
	<input name="siteid" type="hidden" value="<?=$siteid?>" /> 
	<input name="remark_add" type="hidden"  id="remark_add"/>
	<input name="salary_id_add" type="hidden" id="salary_id_add" />
	<input name="date_command" type="hidden"  id="date_command" />
	<input name="date_start" type="hidden" id="date_start" />
	<input name="noorder_add" type="text" size="40"  id="noorder_add" readonly="readonly">
<input name="brown" type="button" value="..." onclick="window.open('select_salary2.php?site=<?=$siteid?>&idcard=<?=$idcard?>','_blank','scrollbars=1,width=800,height=580')" /></td>
  </tr>
  <tr>
    <td align="right">วิทยฐานะ</td>
    <td>
     <select name="select_vitaya_add">
	   <option value="">เลือกวิทยะฐานะ</option>
	  <?php
	  $sql_vitaya = "SELECT * FROM vitaya";
	  $query_vitaya = mysql_db_query(DB_MASTER,$sql_vitaya)or die(mysql_error());
	  while($rows_vitaya = mysql_fetch_array($query_vitaya)){
	  ?>
	  <option value="<?=$rows_vitaya['runid']?>" <?php if($rows_vitaya['runid'] == $rows['vitaya_id']){echo "selected";} ?>><?=$rows_vitaya['vitayaname']?></option>
	  <?php
	  }
	  ?>
	</select>	
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input name="bt_add" type="submit" value=" บันทึก " />
	&nbsp;
	<input name="bt_cancel" type="submit" value=" ยกเลิก " />
	</td>
  </tr>
</table>
</fieldset>
</form>
<br />

<?php
}
?>
<a name="edit"></a>
<table width="100%" border="1" cellspacing="0" cellpadding="3"  bordercolor="#ffffff" style="border-collapse:collapse;">
  <tr>
    <td width="73" align="center" bgcolor="#cccccc"><strong>ลำดับ</strong></td>
    <td width="436" align="center" bgcolor="#cccccc"><strong>รายละเอียด</strong></td>
    <td width="396" align="center" bgcolor="#cccccc"><strong>คำสั่งที่</strong></td>
    <td width="182" align="center" bgcolor="#cccccc"><strong>วิทยฐานะ</strong></td>
	 <td width="188" align="center" bgcolor="#cccccc"><strong>จัดการ</strong></td>
  </tr>
<?php
$sql = "SELECT vitaya_stat.*,salary.pls FROM vitaya_stat
        JOIN salary ON salary.runid =  vitaya_stat.salary_id AND salary.id = vitaya_stat.id
        WHERE vitaya_stat.id = '$idcard' 
		ORDER BY vitaya_stat.salary_id ";
$query = mysql_db_query($dbname,$sql)or die(mysql_error());
$i = 1;
while($rows = mysql_fetch_array($query)){
 if($_GET['module']=='edit' and $_GET['salary_id'] == $rows['salary_id'] and $_GET['idcard'] == $rows['id']){
?>
<form action="?siteid=<?=$siteid?>&idcard=<?=$rows['id']?>&xsiteid=<?=$siteid?>&fullname=<?=$_GET['fullname']?><?=$txt_link?>" method="post">
  <tr <?php if($i%2 == '1'){echo 'bgcolor="#FFFFFF"';} ?>>
    <td align="center"><?=$i?></td>
	<td><label id="show_noorder"><?=$rows['pls']?></label></td>
	<td>
<input name="idcard" type="hidden" value="<?=$rows['id']?>">
<input name="siteid" type="hidden" value="<?=$siteid?>">	
<input name="salary_id" type="hidden" size="7"  id="salary_id" value="<?=$rows['salary_id']?>" />
<input name="salary_id_old" type="hidden" size="7" value="<?=$rows['salary_id']?>" />
<input name="remark" type="text" value="<?=$rows['remark']?>"  id="remark" readonly="readonly">
<input name="date_command" type="hidden"  id="date_command" />
<input name="date_start" type="hidden" id="date_start" />
<input name="brown" type="button" value="..." onclick="window.open('select_salary.php?site=<?=$siteid?>&idcard=<?=$rows['id']?>','_blank','scrollbars=1,width=800,height=580')" />	</td>
	<td>
	<select name="select_vitaya">
	  <?php
	  $sql_vitaya = "SELECT * FROM vitaya";
	  $query_vitaya = mysql_db_query(DB_MASTER,$sql_vitaya)or die(mysql_error());
	  while($rows_vitaya = mysql_fetch_array($query_vitaya)){
	  ?>
	  <option value="<?=$rows_vitaya['runid']?>" <?php if($rows_vitaya['runid'] == $rows['vitaya_id']){echo "selected";} ?>><?=$rows_vitaya['vitayaname']?></option>
	  <?php
	  }
	  ?>
	</select>	</td>
	<td align="center"><input name="bt_save" type="submit" value=" บันทึก ">&nbsp;&nbsp;
	<input name="bt_cancel" type="submit" value=" ยกเลิก "  /></td>
  </tr>
</form>  
<?php 
 }else{
?>  
  <tr <?php if($i%2 == '1'){echo 'bgcolor="#FFFFFF"';} ?>>
    <td align="center"><?=$i?></td>
    <td><label id="show_noorder"><?=$rows['pls']?></label></td>
    <td><?=$rows['remark']?></td>
    <td><?=$rows['name']?></td>
	<td align="center">
	<a href="?siteid=<?=$siteid?>&idcard=<?=$rows['id']?>&salary_id=<?=$rows['salary_id']?>&module=edit&xsiteid=<?=$siteid?>&fullname=<?=$_GET['fullname']?><?=$txt_link?>#edit"><img src="img/edit.png" align="absmiddle" border="0" title="แก้ไข"></a>&nbsp;
	|
	&nbsp;
	<a href="?siteid=<?=$siteid?>&idcard=<?=$rows['id']?>&salary_id=<?=$rows['salary_id']?>&module=delete&xsiteid=<?=$siteid?>&fullname=<?=$_GET['fullname']?><?=$txt_link?>" onclick="return confirm('ยืนยันการลบข้อมูล')">
	<img src="img/icon-access-denied.png" border="0" align="absmiddle" title="ลบ"></a></td>
  </tr>
<?php
  }
  $i++;
}
?>  
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="border-collapse:collapse" bgcolor="#CCFFE6">
  <tr>
    <td>
	<script>
	  function CheckButton(){
	    if(document.getElementById('confirm').checked == true){
		  document.getElementById('button').disabled = false;
		}else{
		  document.getElementById('button').disabled = true;
		}
	  }
	</script>
	<input name="comfirm_vitaya" type="checkbox" value="1" id="confirm"  onclick="CheckButton()" style=" background-color:#FF9900;"/>&nbsp;<strong><font color="#990000" size="4">ยืนยันความถูกต้องของข้อมูลวิทยฐานะ</font>&nbsp;(** หากไม่ยืนยันความถูกต้องของวิทยฐานะ จะไม่สามารถบันทึกสถานะความพร้อมในการตรวจสอบข้อมูลได้)</strong></td>
  </tr>
</table>