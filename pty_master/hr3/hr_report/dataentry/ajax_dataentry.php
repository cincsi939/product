<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;

    $sql_select=" select  secid,secname from eduarea where provid = '$Tid' order by secid ";
    $result1= mysql_query( $sql_select );
     //�����ǹ�ͺ�ʴ�������
    while ($result = mysql_fetch_array($result1))
	
    //�ʴ����㹰ҹ������
    {
	//$name = substr($result[secname], -1, 2);
	//echo"$result[secname]::$result[secid],";
	$name = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$result[secname] ) ; 
	echo"  $name::$result[secid],";
   }
       // �Դ�����������
 	mysql_close();
?>