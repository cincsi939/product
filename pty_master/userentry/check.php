<?php
##start loop
$debug = "0";

$arr_position_id = array();
$arr_level_id = array();
$arr_level_name = array();
$arr_have_vitaya = array();
$arr_radub_sub = array();
$arr_date_th = array();
if($_GET['check_all'] == '1'){
 $idcard = $rows_person['CZ_ID'];
}else{
 $idcard = $_GET['idcard'];
} 


$sql_runno = "SELECT runno FROM salary WHERE id = '$idcard' AND date = '$date_for_check' ORDER BY runno ASC LIMIT 0,1 ";
$query_runno = mysql_db_query($dbname,$sql_runno)or die(mysql_error());
$rows_runno = mysql_fetch_array($query_runno);
$runno_for_check =  (int)$rows_runno['runno'] - 1;

#find first radub for check
$sql_radub = "SELECT * FROM salary WHERE id = '$idcard' AND date >= $date_valid AND radub NOT LIKE 'คศ%' ORDER BY runno DESC LIMIT 0,1 ";
$query_radub = mysql_db_query($dbname,$sql_radub)or die(mysql_error());
$rows_radub = mysql_fetch_array($query_radub);
##echo $sql_radub."<br>";


$sql = "SELECT * FROM view_general WHERE CZ_ID = '$idcard' ";
$query = mysql_db_query($dbname,$sql);
$rows = mysql_fetch_array($query);

if($debug == "1"){
 echo $rows['prename_th'].$rows['name_th']."  ".$rows['surname_th'];
 echo "&nbsp;&nbsp;เลขที่บัตรประชาชน :".$idcard; 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="4%" align="center" bgcolor="#CCCCCC">ลำดับ</td>
    <td width="5%" align="center" bgcolor="#CCCCCC">runno</td>
    <td width="8%" align="center" bgcolor="#CCCCCC">วันที่</td>
	<td width="18%" align="center" bgcolor="#CCCCCC">pls</td>
    <td width="7%" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
    <td width="9%" align="center" bgcolor="#CCCCCC">เลขที่ตำแหน่ง</td>
    <td width="4%" align="center" bgcolor="#CCCCCC">ระดับ</td>
    <td width="7%" align="center" bgcolor="#CCCCCC">เงินเดือน</td>
    <td width="22%" align="center" bgcolor="#CCCCCC">เลขที่คำสั่ง</td>
	<td width="16%" align="center" bgcolor="#CCCCCC">ผลการตรวจสอบ</td>
  </tr>
<?php
}

$sql = "SELECT * FROM salary WHERE   id = '$idcard' AND date >= '$date_valid' AND runno >= '$runno_for_check'  ORDER BY runno ";
##echo "<br>".$sql ;
$query = mysql_db_query($dbname,$sql)or die(mysql_error());
$i = 1;
$k = 0;
$check_vitaya_first = 0;
$date_start_check = "";
$runno_start_check = "";

while($rows = mysql_fetch_array($query)){
  $txt = $rows['pls']." ".$rows['noorder'];
if(!is_conclusion($txt)){

  if($k == 0 and !is_radub_before47($rows['level_id'])){
    $arr_position_id[$k] = $rows_radub['position_id'];
    $arr_level_id[$k] = $rows_radub['level_id'];
    $arr_radub_sub = explode(".",$rows_radub['radub']);
    $arr_level_name[$k] = $arr_radub_sub[1];
  }else{
    $arr_position_id[$k] = $rows['position_id'];
    $arr_level_id[$k] = $rows['level_id'];
    $arr_radub_sub = explode(".",$rows['radub']);
    $arr_level_name[$k] = $arr_radub_sub[1];
  }
 
  
if($debug == "1"){ 
?>  
  <tr>
    <td align="center"><?=$i?></td>
    <td align="center"><?=$rows['runno']?></td>
	<td>
	<?php
	  $arr_date_th = explode("-",$rows['date']);
	  echo (int)$arr_date_th[2]." ".$month_th[(int)$arr_date_th[1]]." ".$arr_date_th[0];
	?>	</td>
    <td><?=$rows['pls']?></td>
    <td><?=$rows['position']?></td>
    <td><?=$rows['noposition']?></td>
    <td><?=$rows['radub']?></td>
    <td><?=$rows['salary']?></td>
    <td><?=$rows['noorder']?></td>
    <td>
<?php
echo "position_id = ".$rows['position_id']."<br>";
echo "level_id = ".$rows['level_id'];
echo "<hr>";
}
#start check vitaya
$str_replace_vitaya = str_replace($arr_vitaya_word,"x",$rows['pls']);
if(eregi('x',$str_replace_vitaya)){
  $check_vitaya_first++; 
}

if($rows['date'] >= $date_for_check and !is38k($rows['position_id']) and $check_vitaya_first == 1){
 #call function for check vitaya 
 $date_start_check = $rows['date'];
 $runno_start_check = $rows['runno'];
 $have_vitaya = have_vitaya($arr_position_id[0],$arr_level_id[0],$arr_level_id[$k]);
 if($have_vitaya != ""){
   $arr_have_vitaya[$rows['runid']] = $have_vitaya;
 }else{
  #if up level from คศ.1 to คศ.2
  if($arr_level_id[$k] == '91254702' and $arr_level_id[$k-1] == '91254701'){	
   $arr_have_vitaya[$rows['runid']] = find_vitaya_from_level($rows['level_id'],$rows['pls']);
  }
  #if up level from คศ.2 to คศ.3
  if($arr_level_id[$k] == '91254703' and $arr_level_id[$k-1] == '91254702'){
   $arr_have_vitaya[$rows['runid']] = find_vitaya_from_level($rows['level_id'],$rows['pls']);
  }
  #if up level from คศ.3 to คศ.4
  if($arr_level_id[$k] == '91254704' and $arr_level_id[$k-1] == '91254703'){
   $arr_have_vitaya[$rows['runid']] = find_vitaya_from_level($rows['level_id'],$rows['pls']);
  }
  #if up level from คศ.4 to คศ.5
  if($arr_level_id[$k] == '91254705' and $arr_level_id[$k-1] == '91254704'){
   $arr_have_vitaya[$rows['runid']] = find_vitaya_from_level($rows['level_id'],$rows['pls']);
  }
  
 }  
  
 
  $check_vitaya_first++;
}

#if($date_start_check != "" and $rows['date'] > $date_start_check){
if($runno_start_check != "" and $rows['runno'] > $runno_start_check){
  if($arr_level_name[$k] > $arr_level_name[$k-1] and !in_array(find_vitaya_from_level($rows['level_id'],$rows['pls']),$arr_have_vitaya)){
	$arr_have_vitaya[$rows['runid']] = find_vitaya_from_level($rows['level_id'],$rows['pls']);
  }
}

if($debug == "1"){ 
?>
	</td>
  </tr>
<?php
}
  $k++;
  $i++;
 } 
}
if($debug == "1"){ 
?>  
</table>
<br />
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="50%" valign="top">
<strong>สรุปการตรวจสอบวิทยฐานะจาก Script</strong><br />	
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="57%" align="center" bgcolor="#CCCCCC">คำสั่ง</td>
    <td width="43%" align="center" bgcolor="#CCCCCC">วิทยฐานะที่ได้รับ</td>
  </tr>
<?php
}
#clear log vitaya_stat
$sql_clear = "DELETE FROM log_vitaya_stat WHERE idcard = '$idcard' AND siteid = '$site' ";
mysql_db_query('cmss_log_tranfer',$sql_clear)or die(mysql_error());

#clear vitaya_stat
$sql_clear_vitaya = "DELETE FROM vitaya_stat WHERE id = '$idcard' ";
mysql_db_query($dbname,$sql_clear_vitaya)or die(mysql_error());

#แสดงผลการตรวจสอบวิทยฐานะโดย Script
foreach($arr_have_vitaya as $runid=>$vitaya_id){

 $sql_s = "SELECT runid,noorder,date,dateorder FROM salary WHERE runid = '$runid' AND id = '$idcard' ";
 $query_s = mysql_db_query($dbname,$sql_s)or die(mysql_error());
 $rows_s = mysql_fetch_array($query_s);
   
 $sql_v = "SELECT * FROM vitaya WHERE runid = '$vitaya_id' ";
 $query_v = mysql_db_query('edubkk_master',$sql_v)or die(mysql_error());
 $rows_v = mysql_fetch_array($query_v);
 if($rows_v['vitayaname'] != ""){
   if($debug == "1"){  
?>  
  <tr>
    <td>
<?php
echo $rows_s['noorder'];
?>	
	</td>
    <td>
<?php
echo $rows_v['vitayaname'];
?>	
	</td>
  </tr>
<?php
   }
  #add vitaya_stat
  $sql_vitaya_stat = "INSERT INTO vitaya_stat(id,salary_id,vitaya_id,name,date_command,date_start,remark,updatetime)
                                  VALUES('$idcard','$runid','$vitaya_id','".$rows_v['vitayaname']."','".$rows_s['dateorder']."',
								         '".$rows_s['date']."','".$rows_s['noorder']."',NOW())";
  mysql_db_query($dbname,$sql_vitaya_stat)or die(mysql_error());										 

  #add log vitaya_stat
  $sql_log = "INSERT INTO log_vitaya_stat(idcard,siteid,salary_id,remark,vitaya_id,vitaya_name,time_update)
              VALUES('$idcard','$site','$runid','".$rows_s['noorder']."','$vitaya_id','".$rows_v['vitayaname']."',NOW()) ";			  
  mysql_db_query('cmss_log_tranfer',$sql_log)or die(mysql_error());
 } 		

}

if($debug == "1"){
?>  
</table>	
	
	</td>
    <td width="50%" valign="top">
<strong>สรุปการได้รับวิทยฐานะจากการบันทึกข้อมูล</strong><br />	
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="57%" align="center" bgcolor="#CCCCCC">คำสั่ง</td>
    <td width="43%" align="center" bgcolor="#CCCCCC">วิทยฐานะที่ได้รับ</td>
  </tr>
<?php
}
$sql_vitaya = "SELECT * FROM vitaya_stat WHERE id = '$idcard' ";
$query_vitaya = mysql_db_query($dbname,$sql_vitaya)or die(mysql_error());
while($rows_vitaya = mysql_fetch_array($query_vitaya)){
 if($debug == "1"){
?>  
  <tr>
    <td>
<?php
  }
$sql = "SELECT noorder FROM salary WHERE runid = '".$rows_vitaya['salary_id']."'  ";
$query = mysql_db_query($dbname,$sql)or die(mysql_error());
$rows = mysql_fetch_array($query);
 if($debug == "1"){
  echo $rows['noorder'];
?>	
	</td>
	<td>
<?php
 }
$sql = "SELECT * FROM vitaya WHERE runid = '".$rows_vitaya['vitaya_id']."' ";
$query = mysql_db_query('edubkk_master',$sql)or die(mysql_error());
$rows = mysql_fetch_array($query);
 if($debug == "1"){
  echo $rows['vitayaname'];
?>	
	</td>	
 </tr>
<?php
 } 
}#end while

if($debug == "1"){
?> 
</table>  		
	</td>
  </tr>
</table>
<?php
}
?>
