<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../config/conndb_nonsession.inc.php")  ;

    $sql_select=" select  *  from allschool where siteid = '$sent_siteid' order by office";
    $result1= mysql_query( $sql_select );
     //�����ǹ�ͺ�ʴ�������
    while ($result = mysql_fetch_array($result1))
	
    //�ʴ����㹰ҹ������
    {
#	$name = substr($result[secname], -1, 2);
#	$name =  $result[secname]  ; 
	$name = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$result[office] ) ; 
	echo"  $name::$result[id],";
   }
       // �Դ�����������
 	mysql_close();
?>