<?php

    header("Content-Type: text/plain; charset=windows-874");
include("../../../config/config_hr.inc.php");

    //����������ǡѺ�ҹ�����ŷ����
//	include ("../../../inc/conndb_nonsession.inc.php")  ;
    $sql_select=" select   runid , name,name_short from $dbnamemaster.cordon_list where groupid = '$runid'  ";
    $result1= mysql_query(  $sql_select )or die(mysql_error());
     //�����ǹ�ͺ�ʴ�������
    while ($result = mysql_fetch_array($result1))

    //�ʴ����㹰ҹ������
    {
	$runid =  $result[runid] ;
	$name =  $result[name] ;
	$sname=  ($result[name_short])?" (".$result[name_short].")":"" ;
	$mixname=$name.$sname."::".  $runid.'::'.$result[name_short] ;
	
	if ($result[name] == "  ��ǹ��ҧ"){
		//echo" ��ǹ��ҧ ,";
	}else{
	echo "$mixname,"; 
		//echo"$name$result[runid],$result[name] "." "."($result[name_short])";
			//echo" $name::$result[runid],";
	}
   }

       // �Դ�����������
 	mysql_close();
?>
