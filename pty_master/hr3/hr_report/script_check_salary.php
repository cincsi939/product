<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
.style5 {font-weight: bold}
.style6 {font-weight: bold}
.style7 {font-weight: bold}
.style8 {font-weight: bold}
.style9 {font-weight: bold}
.style10 {font-weight: bold}
.style11 {font-weight: bold}
.body,td,th{
font-size: 12px;}
-->
</style>
</head>

<body>
<?php
include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
require_once("check_lvsalary.php");



$month_th 	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); 
//$idcard = '3720100232742';
//$idcard = '5700200023092'; // แบบเต็มขั้น
//$idcard = '3700100393801';
//$idcard = '3440300001810';
//$idcard = '3430300508698';
//$idcard = '3419900347847';
//$idcard = '3720500056275';
//$idcard = '3411800373946';
//$idcard = '3670400426411';
//$idcard = '3700800070478';
//$idcard = '3670400576707';
//$idcard = '3180100147538';

//$site = '7001';
//$site = '4102';
//$site = '6702';
//$site = '4303';
//$site = '1801';
$idcard = $_GET['idcard'];
$site = $_GET['site'];
$dbname = STR_PREFIX_DB.$site;

$sql_create_profile = "INSERT INTO log_profile_check_command_type(profile_id,profile_date,idcard,order_type) VALUES(NULL,NOW(),'$idcard','4')";
mysql_db_query("competency_system",$sql_create_profile)or die(mysql_error());
$profile_id = mysql_insert_id();


//$sql = "SELECT * FROM salary WHERE  date > '2543-12-31' AND id = '$idcard'  AND (schoolid = '0' OR schoolid = '') AND school_label = ''   ORDER BY runno ";
$sql = "SELECT * FROM salary WHERE   id = '$idcard'  ORDER BY runno ";
$query = mysql_db_query($dbname,$sql)or die(mysql_error());
$num = mysql_num_rows($query);
echo "ข้อมูลทั้งหมด =".$num;
echo "<br>";
$j = 1;
$k = 0;
$s = 1;
$number_change_salary = 0;
$number_change_radub = 0;
$number_change_all = 0;
$status_special = 0;
$status_return = 0;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="4%" bgcolor="#CCCCCC" class="style2"><div align="center">ลำดับ</div></td>
    <td width="13%" bgcolor="#CCCCCC" class="style3"><div align="center">เงื่อนไขการพิจารณา</div></td>
    <td width="11%" bgcolor="#CCCCCC" class="style4"><div align="center">กลุ่มเงื่อนไข</div></td>
    <td width="16%" bgcolor="#CCCCCC" class="style5"><div align="center">runno</div></td>
    <td width="8%" bgcolor="#CCCCCC" class="style6"><div align="center">วันที่</div></td>
    <td width="7%" bgcolor="#CCCCCC" class="style7"><div align="center">ตำแหน่ง</div></td>
    <td width="10%" bgcolor="#CCCCCC" class="style8"><div align="center">เลขทีตำแหน่ง</div></td>
    <td width="7%" bgcolor="#CCCCCC" class="style9"><div align="center">ระดับ</div></td>
    <td width="10%" bgcolor="#CCCCCC" class="style10"><div align="center">เงินดือน</div></td>
    <td width="14%" bgcolor="#CCCCCC" class="style11"><div align="center">เลขที่คำสั่ง</div></td>
  </tr>
<?php
while($rows = mysql_fetch_array($query)){
  $all_runno[] = $rows['runno'];
  $data_before44[] = $rows['runno'].":".$rows['salary'];
  
  $arr_month10 = explode("-",$rows['date']);
  $m10 = $arr_month10[1];
  $d10 = $arr_month10[2];
  
 
   
   $arr_salary_check[$k] = $rows['salary'];
   $arr_radub_check[$k] = $rows['radub'];
   $arr_position_check[$k] = $rows['position'];
   $arr_date[$k] = $rows['date'];
   //$arr_position_id = $rows['position_id']; 
   
   if($k == 0){
    $sql_first_pos = "SELECT * FROM salary WHERE runno < '".$rows['runno']."' AND id = '$idcard' ORDER BY runno DESC LIMIT 0,1 ";
	$query_first = mysql_db_query($dbname,$sql_first_pos);
	$rows_first = mysql_fetch_array($query_first);
	$num_first = mysql_num_rows($query_first);
	
	 if($num_first > 0){
	  $last_salary = $rows_first['salary'];
	  $last_radub = $rows_first['radub'];
	  $last_position = $rows_first['position'];
	  $last_date = $rows_first['date'];
	  $last_position_id = $rows_first['position_id'];

	 }else{# ถ้าเชคว่าเป็น เรคคอร์ดแรกของทะเบียนประวัติ
	  $sql_first_pos = "SELECT * FROM salary WHERE runno = '".$rows['runno']."' AND id = '$idcard' ORDER BY runno DESC LIMIT 0,1 ";
	  $query_first = mysql_db_query($dbname,$sql_first_pos);
	  $rows_first = mysql_fetch_array($query_first);
	  
	  $last_salary = $rows_first['salary'];
	  $last_radub = $rows_first['radub'];
	  $last_position = $rows_first['position'];
	  $last_date = $rows_first['date'];
	  $last_position_id = $rows_first['position_id'];
	 }
	  
	
   }else{
    $last_salary = $arr_salary[$k-1];
	$last_radub = $arr_radub[$k-1];
	$last_position = $arr_position[$k-1];
	$last_date = $arr_date[$k-1];
	$last_position_id = $arr_position_id[$k-1];

   }	
  
   
   
   //if($arr_salary_check[$k] >= $last_salary and $arr_date[$k] >= $last_date ){
     
	 $arr_salary[$k] = $rows['salary'];
     $arr_radub[$k] = $rows['radub'];
     $arr_position[$k] = $rows['position'];
	 $arr_position_id[$k] = $rows['position_id'];
	 $arr_date[$k] = $rows['date'];  
   
    #เชคว่ามีการปรับตามมติ ครม หรือไม่
	$not_change = "0";
	$string = $rows['noorder'];
    if (eregi('ปรับ', $string)) {
      $not_change = "1";
    } 
	
	
  
  
  $change_salary = 0;
  $change_radub = 0; 
  
?>

  <tr bgcolor="#FFFFF4">
    <td>
	<?=$j?>
	<br />
	<br />
	<?php
	#เชคว่ามี school label หรือ schoolid หรือไม่  schoolid school_label
	$change_school = 0;
	if( ($rows['schoolid'] != '0' and $rows['schoolid'] != '')  or $rows['school_label'] != '' ){
	  $change_school = 1;
	  echo "<br>";
	  echo "*อาจมีการย้ายหน่วยงาน";
	  echo "<br>";
	}
	
	?>
	
	<br />
	<?php
	//echo $last_date."<br>".$arr_date[$k];
	?>	</td>
    <td>
	<br>
	<?php
   
   
    //echo $rows['noorder'];
	
	
   	
	if($k == 0){
	  
	  // echo $rows_first['salary'];
	  // echo $rows_first['radub'];
	   
	   
	   if($arr_salary[$k] > $rows_first['salary']){
		 $change_salary = 1;
	   }
	    echo "เงินเดือนเดิม  ".$rows_first['salary']."<br>"; 
	    echo "เงินเดือนใหม่ ".$arr_salary[$k]."<br>";
	  
		
		if(checkmathradub2($arr_radub[$k],$arr_position_id[$k],$arr_date[$k]) != checkmathradub2($rows_first['radub'],$rows_first['position_id'],$rows_first['date'])){
		 $change_radub = 1;
	    }
		  echo "----";
		  echo "<br>";
		  echo "ระดับเดิม ".$rows_first['radub']."<br>";
		  echo "ระดับใหม่ ".$arr_radub[$k]."<br>";
		
		
	    
		//echo "<br>----<br>";
		//echo "ตำแหน่งเดิม  ".$rows_first['position']."<br>";
		//echo "ตำแหน่งใหม่ ".$arr_position[$k]."<br>";
		
	   
	}
	
	if($k > 0){
	  
	  
	   if($arr_salary[$k] > $arr_salary[$k-1]){
		 $change_salary = 1;
	   }
	    echo "เงินเดือนเดิม  ".$arr_salary[$k-1]."<br>"; 
	    echo "เงินเดือนใหม่ ".$arr_salary[$k]."<br>";
	  
		
		if(checkmathradub2($arr_radub[$k],$arr_position_id[$k],$arr_date[$k]) != checkmathradub2($arr_radub[$k-1],$arr_position_id[$k-1],$arr_date[$k-1])){
		 $change_radub = 1;
	    }
		  echo "----";
		  echo "<br>";
		  echo "ระดับเดิม ".$arr_radub[$k-1]."<br>";
		  echo "ระดับใหม่ ".$arr_radub[$k]."<br>";
		
		
		//echo "<br>----<br>";
		//echo "ตำแหน่งเดิม  ".$arr_position[$k-1]."<br>";
		//echo "ตำแหน่งใหม่ ".$arr_position[$k]."<br>";
		
	  }	
	  
	  
	  
	  #ดักจับคำสั่งที่มีการแก้ไขสั่ง
	  /*$text = "111/11";
	  if(eregi('^[0-9]+/+[0-9]+$',$text)){
	    echo "////////";
	  }else{
	    echo "xxxxxxxxxxxx";
	  }*/
	  
	  if (eregi('แก้ไข', $rows[pls])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
      }
	  if (eregi('แก้ไข', $rows[noorder])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
	  }
	  if (eregi('แก้ไข', $rows[label_dateorder])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
	  }
	  
	  if (eregi('ถอนชื่อ', $rows[pls])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
      }
	  if (eregi('ถอนชื่อ', $rows[noorder])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
	  }
	  if (eregi('ถอนชื่อ', $rows[label_dateorder])) {
	    $arr_not_sure_type1[$rows['date']] = $rows[runno];
	  }
	  
	  echo "<br>";
	  echo "<br>";
	  echo "ไม่แน่ใจเพราะแก้ไขคำสั่ง";
	  echo "<pre>";
	  print_r($arr_not_sure_type1);
	  echo "</pre>";
	 

	?>	</td>
    <td >
	<?php
	
     $arr_date_check = explode("-",$rows['date']);
   
     if($not_change == '0'){	
	   if($change_radub == '1'){
	      echo "<font color='#0000FF'>- เลื่อนระดับ</font><br>";
	   }
	   if($change_salary == '1'){
	      echo "<font color='#FF0000'>- เลื่อนขั้นเงินเดือน</font><br>";
	   }
	   
	   if($change_salary == '1' and $change_radub == '0'){
	     /*echo $arr_date_check[1];
		 echo $arr_date_check[2];*/
		 
		 if( ($arr_date_check[1] == '10' and $arr_date_check[2] == '01') or ($arr_date_check[1] == '04' and $arr_date_check[2] == '01') ){
		    
		 }else{
		   $arr_not_sure_type2[$rows['date']] = $rows['runno'];
		   echo "<br>";
		   echo "ไม่แน่ใจเนื่องจากวันที่  ";
		   echo "<pre>";
		   print_r($arr_not_sure_type2);  
		   echo "</pre>";
		 }
		 
		 if($change_school == '0'){
          $arr_change_salary_all[$rows['date']] = $rows['runno'];
		 }
		   
       }
	   if($change_radub == '1' and $change_salary == '1' and $not_change == '0'){
	     $arr_not_sure_type3[$rows['date']] = $rows['runno'];
		   echo "<br>";
		   echo "ไม่แน่ใจเนื่องมีทั้งการเลื่อนระดับ และเลื่อนเงินเดือน ";
		   echo "<pre>";
		   print_r($arr_not_sure_type3);  
		   echo "</pre>";
	   }
	   
     }else{
	   echo "<font color='#FF00FF'>** ปรับตามมติ ครม</font><br>";
	 }
	 
	
     #หาว่าเงินเดือนเต็มขั้นรึยัง
	 if(($arr_date_check[1] == '10' or $arr_date_check[1] == '04') and $arr_date_check[2] == '01'){
	   
	   
	   if($change_salary == '0'){
	     
		
		 #เชคกับผังเงินเดือนใหม่
	     if(check_max_salary($rows['radub'],$arr_date_check[0],$arr_date_check[1],$rows['salary'])){ #เต็มผังใหม่
		  #เชคว่าวันนั้นมีคำสั่งมากว่า 1 คำสั่งหรือไม่
		  $sql_check_num_command = "SELECT runno FROM salary WHERE id = '$idcard' AND date = '".$rows['date']."' AND noorder NOT LIKE '%ปรับตาม%'  ";
		  $query_check_num_command = mysql_db_query($dbname,$sql_check_num_command);
		  $num_command = mysql_num_rows($query_check_num_command);
		  if($num_command > 1){
		   if( eregi('%)',$rows['label_salary']) or eregi('%)',$rows['pls']) or eregi('ขั้น)',$rows['label_salary']) or eregi('ขั้น)',$rows['pls']) ) {
             echo $rows['label_salary']."<br>";
			 echo $rows['pls']."<br>";
			 if($change_school == '0'){
		      $arr_change_salary_all[$rows['date']] = $rows['runno'];
			 } 
           }
		  }else{
		   if($change_school == '0'){
		    $arr_change_salary_all[$rows['date']] = $rows['runno'];
		   }	
		  }  
		   
		   
		 }
		 #เชคกับผังเงินเดือนเก่า
	     if(check_max_salary($rows['radub'],$arr_date_check[0],($arr_date_check[1])-1,$rows['salary'])){ #เต็มผังเก่า
		  #เชคว่าวันนั้นมีคำสั่งมากว่า 1 คำสั่งหรือไม่
		  
		  
		  
		  $sql_check_num_command = "SELECT runno FROM salary WHERE id = '$idcard' AND date = '".$rows['date']."' AND noorder NOT LIKE '%ปรับตาม%'  ";
		  $query_check_num_command = mysql_db_query($dbname,$sql_check_num_command);
		  $num_command = mysql_num_rows($query_check_num_command);
		  if($num_command > 1){
		  
		   if( eregi('%)',$rows['label_salary']) or eregi('%)',$rows['pls']) or eregi('ขั้น)',$rows['label_salary']) or eregi('ขั้น)',$rows['pls']) ) {
             echo $rows['label_salary']."<br>";
			 echo $rows['pls']."<br>";
			 if($change_school == '0'){
		      $arr_change_salary_all[$rows['date']] = $rows['runno'];
			 } 
           }
		  }else{
		    if($change_school == '0'){
		     $arr_change_salary_all[$rows['date']] = $rows['runno'];
			} 
		  }
		  
		 }
		 
		  
		  
	   }
	   
	   
	 }
	 
  	
	?>	</td>
    <td>runno = <?=$rows['runno']?>
	<?php
	#ถ้าหากมีคำสั่งย้อนหลังให้คำนวนใหม่
	if($arr_date[$k] < $last_date){
	  unset($arr_not_sure_type3[$arr_date[$k]]);
	  
	  
	       
	  
	  echo "<br>";
	  echo "<font color='#cc0000'><b>เป็นคำสั่งย้อนหลังทำการคำนวนใหม่</b></font>";
	  $date_start_new = $arr_date[$k];
	  $date_end_new = $last_date;
	  echo "<br>";
	  echo "ตั้งแต่  ";
	  echo $date_start_new;
	  echo " ถึง ";
	  echo $date_end_new;
	  
	  
	  echo "<br>";
	  echo "<br>";
	  echo "<br>";
	  
	  //$sql_check_return = "SELECT * FROM salary WHERE id = '$idcard' AND runno < '".$rows['runno']."' AND date = '".$arr_date[$k]."' ";
	 // echo $sql_check_return;
	  
	  echo "<br>";
	  echo "<br>";
	  $num_del = 0;
	  foreach($arr_change_salary_all as $key=>$value){
	    if($key >= $date_start_new and $key <= $date_end_new){
		  //echo "<font color='#cc0000'>Del </font>".$key."=>".$value."<br>";
		  //$arr_return[$value] = $key;  
		  //unset($arr_change_salary_all[$key]);
		  $num_del++;
		}
	  }
	  echo "<br><br>";
	  echo "number of del ".$num_del."<br>";
	  $sql_check_return = "SELECT * FROM salary WHERE id = '$idcard' AND runno >= '".$rows['runno']."' AND date <= '$date_end_new' ";

	  $query_check_return = mysql_db_query($dbname,$sql_check_return);
	  $num_check_return = mysql_num_rows($query_check_return);
	  echo "number of period".$num_check_return;
	  echo "<br>";
	  echo "<br>";
	  //echo "all preiod  <br>";
	  $pos_return = 0;
	  
	 #ทำการเชคคำสั่งล่วงหน้าว่า มีผลต่อคำสั่งย้อนหลังหรือไม่
	 $num_del_future = 0;
	 while($rows_check_return = mysql_fetch_array($query_check_return)){
	    //echo $rows_check_return['date']."=>".$rows_check_return['runno']."<br>";
		
		$arr_pos_salary[$pos_return] = $rows_check_return['salary'];
		$arr_pos_radub[$pos_return] = $rows_check_return['radub'];
		$arr_pos_position_id[$pos_return] = $rows_check_return['position_id'];
		$arr_pos_date[$pos_return] = $rows_check_return['date'];
		
		//echo $arr_pos_position_id[$pos_return]."<br>";
		
		if($pos_return == '0'){
		 $sql_salary_last = "SELECT * FROM salary 
		                     WHERE id = '$idcard' AND runno < '".$rows_check_return['runno']."' 
							 AND date < '".$rows_check_return['date']."' 
							 ORDER BY runno DESC LIMIT 0,1 ";
		// echo $sql_salary_last;					 
		 $query_salary_last = mysql_db_query($dbname,$sql_salary_last)or die(mysql_error);
		 $rows_salary_last = mysql_fetch_array($query_salary_last);					 
		 $last_pos_salary = $rows_salary_last['salary'];
		 $last_pos_radub = $rows_salary_last['radub'];
		 $last_pos_position_id = $rows_salary_last['position_id'];
		 $last_pos_date = $rows_salary_last['date'];					 
		}else{
		 $last_pos_salary = $arr_pos_salary[$pos_return-1];
		 $last_pos_radub = $arr_pos_radub[$pos_return-1];
		 $last_pos_position_id = $arr_pos_position_id[$pos_return-1];
		 $last_pos_date = $arr_pos_date[$pos_return-1];
		}
		
		$not_change_sub = "0";
	    $string = $rows_check_return['noorder'];
       if (eregi('ปรับ', $string)) {
          $not_change_sub = "1";
       } 
		//echo $last_pos_salary."--".$arr_pos_salary[$pos_return]."<br><br>";
		//echo $last_pos_radub."--".$arr_pos_radub[$pos_return]."<br><br>"; 
		//echo $string."<br><br>";
		//echo "---------";
		//echo "<br>";
		
		$change_salary_sub = '0';
		$change_radub_sub = '0';
		if($arr_pos_salary[$pos_return] > $last_pos_salary){
		  $change_salary_sub = '1';
		}
		
		//echo "xx".$arr_pos_position_id[$pos_return];
		//echo "yy".$last_pos_position_id."<br>";
		
		if(checkmathradub2($arr_pos_radub[$pos_return],$arr_pos_position_id[$pos_return],$arr_pos_date[$pos_return]) != checkmathradub2($last_pos_radub,$last_pos_position_id,$last_pos_date)){
		  $change_radub_sub = '1';
		}
		
		if($change_salary_sub == '1' and $change_radub_sub == '0' and $not_change_sub == '0' ){
		  echo "<font color='#cc0000'>Del </font> key => ".$rows_check_return['date']."<br>";
		  unset($arr_change_salary_all[$rows_check_return['date']]);
		  $num_del_future++;
		}
		
		$pos_return++;
	}
	  
  #ถ้าเชคได้ว่าคำสั่งย้อนหลังนั้นอาจมีผลต่อคำสั่งก่อนหน้านี้
  
  echo "num_del_future == ".$num_del_future;
  if($num_del == $num_del_future){
	    //echo "yes";
	  /*foreach($arr_change_salary_all as $key=>$value){
	    if($key >= $date_start_new and $key <= $date_end_new){
		  echo "<font color='#cc0000'>Del </font>".$key."=>".$value."<br>";
		  $arr_return[$value] = $key;  
		  unset($arr_change_salary_all[$key]);
		}
	  }*/
	  
	  
	  
	  
	  $sql_return = "SELECT * FROM salary WHERE id = '$idcard' AND runno < '".$rows['runno']."' AND date < '".$rows['date']."' ORDER BY runno DESC LIMIT 0,1 ";
	  //echo $sql_return;
	  $query_return = mysql_db_query($dbname,$sql_return);
	  $rows_return = mysql_fetch_array($query_return);
	  echo "<br>";
	  echo "<br>";
	  echo  "เงินเดือนเดิม  ".$last_salary = $rows_return['salary'];
	  echo "<br>";
	  echo  "เงินเดือนใหม่".$arr_salary[$k] = $rows['salary'];
	  echo "<br>";
	  echo "<br>";
	  echo "ระดับเดิม  ".$last_radub = $rows_return['radub'];
	  echo "<br>";
	  echo "ระดับใหม่  ".$arr_radub[$k] = $rows['radub'];
	  echo "<br>";
	  echo "<br>";
	  $change_salary = '0';
	  $change_radub = '0';
	  
	  if($arr_salary[$k] > $last_salary){
	    $change_salary = 1;
	    echo "<font color='#FF0000'>เลื่อนขั้นเงินเดือน</font>"."<br>";
	  }
	  if(checkmathradub2($arr_radub[$k],$arr_position_id[$k],$arr_date[$k]) != checkmathradub2($last_radub,$last_position_id,$last_date)){
	    $change_radub = 1;
	    echo "<font color='#0000ff'>เลื่อนระดับ</font>"."<br>";
	  }
	  
	  /*echo "<br>";
	  echo "<br>";  
	  echo "bbbbbb".$arr_position_id[$k].$arr_radub[$k];
	  echo "aaaaaa".$last_position_id.$last_radub;
	  echo "<br>"; 
	  echo "<br>"; */
	  
	  if($change_salary == '1' and $change_radub == '0' and $not_change == '0' and $change_school == '0'){
         $arr_change_salary_all[$rows['date']] = $rows['runno'];
		 
		 if( ($arr_date_check[1] == '10' and $arr_date_check[2] == '01') or ($arr_date_check[1] == '04' and $arr_date_check[2] == '01') ){
		    
		 }else{
		   $arr_not_sure_type2[$rows['date']] = $rows['runno'];
		   echo "<br>";
		   echo "ไม่แน่ใจเนื่องจากวันที่  ";
		   echo "<pre>";
		   print_r($arr_not_sure_type2);  
		   echo "</pre>";
		 }
		 
       }
	  
	  
	  if($change_radub == '1' and $change_salary == '1' and $not_change == '0'){
	     $arr_not_sure_type3[$rows['date']] = $rows['runno'];
		   echo "<br>";
		   echo "ไม่แน่ใจเนื่องมีทั้งการเลื่อนระดับ และเลื่อนเงินเดือน ";
		   echo "<pre>";
		   print_r($arr_not_sure_type3);  
		   echo "</pre>";
	   }
	  
	  
		
		
  }else{
    
    unset($arr_radub[$k]);
	unset($arr_salary[$k]);
	unset($arr_position_id[$k]);
	$k = $k-1;
  }
  #จบการเชคการมีผลย้อนหลังของคำสั่งนั้น
	   
	  
	  

	}
	#จบการคำนวณใหม่
	
	
	echo "<pre>";
	print_r($arr_change_salary_all);
	echo "</pre>";
	?>	</td>
    <td >
	<?php
	
	  $arr_date_th = explode("-",$rows['date']);
	  echo (int)$arr_date_th[2]." ".$month_th[(int)$arr_date_th[1]]." ".$arr_date_th[0];
	?>	</td>
    <td><?=$rows['position']?></td>
    <td><?=$rows['noposition']?></td>
    <td><?=$rows['radub']?></td>
    <td><?=$rows['salary']?></td>
    <td><?=$rows['noorder']?></td>
  </tr>

<?php
 
  
 //}
  $k++;  
  $j++;
}
  ?>
</table>

<?php
echo "<pre>";
print_r($arr_not_sure_type1);
echo "</pre>";

echo "<pre>";
print_r($arr_not_sure_type2);
echo "</pre>";

echo "<pre>";
print_r($arr_not_sure_type3);
echo "</pre>";
?>
<br />
<br />

<strong>สรุปคำสั่งเลื่อนขั้นเงินเดือน</strong>
<br />
เลขที่บัตรประชาชน : <?=$idcard?>
<br>
<?php
$sql = "SELECT * FROM view_general WHERE CZ_ID = '$idcard' ";
$query = mysql_db_query($dbname,$sql);
$rows = mysql_fetch_array($query);
echo $rows['prename_th'].$rows['name_th']."  ".$rows['surname_th'];
?>
<br />
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="6%" bgcolor="#CCCCCC" class="style2"><div align="center">ลำดับ</div></td>
    <td width="8%" bgcolor="#CCCCCC" class="style6"><div align="center">runno</div></td>
    <td width="23%" bgcolor="#CCCCCC" class="style6"><div align="center">วันที่</div></td>
    <td width="14%" bgcolor="#CCCCCC" class="style7"><div align="center">ตำแหน่ง</div></td>
    <td width="12%" bgcolor="#CCCCCC" class="style8"><div align="center">เลขทีตำแหน่ง</div></td>
    <td width="9%" bgcolor="#CCCCCC" class="style9"><div align="center">ระดับ</div></td>
    <td width="12%" bgcolor="#CCCCCC" class="style10"><div align="center">เงินดือน</div></td>
    <td width="16%" bgcolor="#CCCCCC" class="style11"><div align="center">เลขที่คำสั่ง</div></td>
  </tr>
<?php
$i = 1;
foreach($arr_change_salary_all as $key=>$value){
  $sql = "SELECT * FROM salary WHERE id = '$idcard' AND runno = '$value' ";
  $query = mysql_db_query($dbname,$sql);
  $rows = mysql_fetch_array($query);
  
  if($rows['order_type'] != ''){
    if($rows['order_type'] != '4'){
	  $bg='bgcolor="#FF8080"';
	}else{
	  $bg='bgcolor="#CEFFCE"';
	}
  }
  
?>  
  <tr <?=$bg?>  >
    <td><?=$i?></td>
	<td><?=$rows['runno']?></td>
	<td><?php
	  $txt_error1 = '';
	  $txt_error2 = '';
	  $txt_error3 = '';
	  $arr_date_th = explode("-",$rows['date']);
	  echo (int)$arr_date_th[2]." ".$month_th[(int)$arr_date_th[1]]." ".$arr_date_th[0];
      echo "<br>";
	  foreach($arr_not_sure_type1 as $key=>$value){
	    if($key == $rows['date'] ){
		  $txt_error1 = "อาจมีการแก้ไขคำสั่ง";
		  echo "<font color='#cc0000'>* อาจมีการแก้ไขคำสั่ง</font><br>";
		}
	  }
	 
	  foreach($arr_not_sure_type2 as $key=>$value){
	    if($key == $rows['date'] ){
		  $txt_error2 = "วันที่ไม่ตรงกับ 1 ตุลาคม หรือ 1 เมษายน";
		  echo "<font color='#cc0000'>** วันที่ไม่ตรงกับ 1 ตุลาคม หรือ 1 เมษายน</font><br>";
		}
	  }
	 
	  foreach($arr_not_sure_type3 as $key=>$value){
	    if($key == $rows['date'] ){
		  $txt_error3 = "อาจมีทั้งเลื่อนเงินเดือนและระดับ";
		  echo "<font color='#cc0000'>*** อาจมีทั้งเลื่อนเงินเดือนและระดับ</font><br>";
		}
	  }
	?></td>
	<td><?=$rows['position']?></td>
    <td><?=$rows['noposition']?></td>
    <td><?=$rows['radub']?></td>
    <td><?=$rows['salary']?></td>
    <td><?=$rows['noorder']?></td>
  </tr>
<?php
 $sql_log = "INSERT INTO log_check_command_type(log_id,profile_id,runno,idcard,order_type,error_type1,error_type2,error_type3,date_time)
         VALUES(NULL,'$profile_id','$value','$idcard','4','$txt_error1','$txt_error2','$txt_error3',NOW())";
 mysql_db_query("competency_system",$sql_log)or die(mysql_error());		 
 $i++;
}
?>  
</table> 
<br />
<br /> 
<input name="bt_close" type="button" value="  เสร็จสิ้นกระบวนการตรวจสอบ  "  onclick="opener.document.location.reload(), window.close()" />
</body>
</html>
