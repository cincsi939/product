<?php
$month_th 	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�."); 

function connect_host($connect_host){
  switch($connect_host){
    case '124':
	     $host_name = "202.129.35.124";
	     $uername = "cmss";
		 $password = "cmss2010";
	     break;
	case '125':
	     $host_name = "202.129.35.125";
	     $uername = "cmss";
		 $password = "cmss2010";	
	     break;
	case '74':
	     $host_name = HOST;
	     $uername = "sarawut";
		 $password = "sarawut2010";	
	     break;		 	
		  	 
  }
   
   mysql_pconnect($host_name,$uername,$password)or die("CAN'T CONNECTED TO DATABASE!!!");
   mysql_query("SET character_set_results=tis-620");
   mysql_query("SET NAMES TIS620");
}

function is38k($position_id){
  if($position_id[0] == '5'){
    return true;
  }else{
    return false;
  }
}

function is_radub_before47($level_id){
  $arr_radub47 = array('92254706','4252128','92254707','4252129','92254708','4252130','92254709','4252131');
  if(in_array($level_id,$arr_radub47)){
    return true;
  }else{
    return false;
  }
}

function have_vitaya($position_before,$radub_before,$radub_now){
  global $debug;
  $arr_radub6 = array('92254706','4252128');
  $arr_radub7 = array('92254707','4252129');
  $arr_radub8 = array('92254708','4252130');
  $arr_radub9 = array('92254709','4252131');
  $arr_radub_k2 = array('91254702');
  $arr_radub_k3 = array('91254703');
  $arr_radub_k4 = array('91254704');
  $arr_radub_k5 = array('91254705');
  $arr_position_ceo = array('325471008','325001005','325001006','325001007','125001002','325001011','325001000','125471009','325001002','325001003');
  if($debug == '1'){
   echo "<br>".$position_before ."/".$radub_before."<br>";
  } 
  #�����   �Ҩ���� 1 �дѺ 6-7
  if($position_before == '425001008' and (in_array($radub_before,$arr_radub6) or in_array($radub_before,$arr_radub7) ) ){
    
	if(in_array($radub_now,$arr_radub_k3)){
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
	 }
	 $vitaya = "2";
	}else{
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ���</font>";
	 } 
	 $vitaya = "1";
	} 
  }
  #�����   �Ҩ���� 2 �дѺ 6-7
  if($position_before == '425001009' and (in_array($radub_before,$arr_radub6) or in_array($radub_before,$arr_radub7) ) ){
     
	if(in_array($radub_now,$arr_radub_k3)){
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
	 }
	 $vitaya = "2";
	}else{
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ���</font>";
	 } 
	 $vitaya = "1";
	}
  }
  #�����   �Ҩ���� 3 �дѺ 6-7
  if($position_before == '425001010' and (in_array($radub_before,$arr_radub6) or in_array($radub_before,$arr_radub7) ) ){
 
	if(in_array($radub_now,$arr_radub_k3)){
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
	 }
	 $vitaya = "2";
	}else{
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ���</font>";
	 } 
	 $vitaya = "1";
	}
  }
  #�����   �Ҩ���� 3 �дѺ 8
  if($position_before == '425001010' and in_array($radub_before,$arr_radub8)){
   if($debug == '1'){
    echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
   }	
  }
  #�����   �Ҩ���� 3 �дѺ 9
  if($position_before == '425001010' and in_array($radub_before,$arr_radub9)){
   if($debug == '1'){
    echo "<font color='#0000FF'>����Ǫҭ</font>";
   }	
	$vitaya = "3";
  }
  #����繵��˹� ��. �дѺ 7
  if(in_array($position_before,$arr_position_ceo) and in_array($radub_before,$arr_radub7)){
 
	if(in_array($radub_now,$arr_radub_k3)){
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
	 }
	 $vitaya = "2";
	}else{
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ���</font>";
	 } 
	 $vitaya = "1";
	}
  }
  #����繵��˹� ��. �дѺ 8
  if(in_array($position_before,$arr_position_ceo) and in_array($radub_before,$arr_radub8)){
   if($debug == '1'){
    echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
   }	
	$vitaya = "2";
  }
  #����繵��˹� ��. �дѺ 9
  if(in_array($position_before,$arr_position_ceo) and in_array($radub_before,$arr_radub9)){
   if($debug == '1'){ 
    echo "<font color='#0000FF'> ����Ǫҭ</font>";
   }	
	$vitaya = "3";
  }
  
  #����� �֡�ҹ��� 7
  if($position_before == '225471001'){
  	
	if(in_array($radub_now,$arr_radub_k3)){
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
	 }
	 $vitaya = "2";
	}else{
	 if($debug == '1'){
      echo "<font color='#0000FF'>�ӹҭ���</font>";
	 } 
	 $vitaya = "1";
	}
  }
  #����� �֡�ҹ��� 8
  if($position_before == '225471003'){
   if($debug == '1'){
    echo "<font color='#0000FF'>�ӹҭ��þ����</font>";
   }	
	$vitaya = "2";
  }
  #����� �֡�ҹ��� 9
  if($position_before == '225471009'){
   if($debug == '1'){
    echo "<font color='#0000FF'> ����Ǫҭ</font>";
   }	
	$vitaya = "3";
  }
  #����� ��.ࢵ �дѺ 9
  if($position_before == '125471008' and in_array($radub_before,$arr_radub9) ){
   if($debug == '1'){
    echo "<font color='#0000FF'>����Ǫҭ</font>";
   }	
	$vitaya = "3";
  }
  
  return $vitaya;
  
}

function find_vitaya_from_level($level_id){
 global $arr_vitaya_word,$debug;
 $arr_vitaya_l[1] = array('�ӹҭ���','�ӹҭ���','�ӹҳ���','�ӹҹ���','�ӹ�¡��');
 $arr_vitaya_l[2] = array('�ӹҭ��þ����','�ӹҭ��þ����','�ӹҳ��þ����','�ӹҹ��þ����','�ӹ�¡�þ����');
 $arr_vitaya_l[3] = array('����Ǫҭ','���Ǫҭ','����Ǫҭ','����Ǫҳ','���Ǫҳ','����Ǫҹ');
 $arr_vitaya_l[4] = array('����Ǫҭ�����','���Ǫҭ�����','����Ǫҭ�����','����Ǫҳ�����','���Ǫҳ�����','����Ǫҹ�����');

 $sql = "SELECT * FROM radub_math_vitaya WHERE level_id = '$level_id'";
 $query = mysql_db_query(DB_MASTER,$sql)or die(mysql_error());
 $rows = mysql_fetch_array($query);
 $pls_re = str_replace($arr_vitaya_l[$rows['vitaya_id']],"x",$pls);
 if(eregi("x",$pls_re)){
  if($debug == '1'){
   echo "<font color='#0000FF'>x</font>";
  }  
   return $rows['vitaya_id']; 
 } 
}

function clear_log($idcard){
 $sql = "DELETE FROM log_check_vitaya WHERE idcard = '$idcard' ";
 mysql_db_query('cmss_log_tranfer',$sql)or die(mysql_error());
}

function is_conclusion($pls){
  $arr_txt = array('��Ѻ','���','�.�.�.','�î.','����ѵ�','���.','�.�.�.','����繡�������','����������','��С�ȡ�з�ǧ��Ҵ��','�غ�.�','�غ�.�.','�غ�ç���¹','�͹','ź','¡��ԡ','�.�.�.','�ú.');
  $pls_re = str_replace($arr_txt,'x',$pls);
  if(eregi('x',$pls_re)){
    return true;
  }else{
    return false;
  }
}

?>