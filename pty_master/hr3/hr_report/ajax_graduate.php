<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;
	$id=substr($degree_id,2);
	$sql_select = "select * from hr_addmajor where major_id = '$id' order by runid ";
    $result1= mysql_query( $sql_select );
     //�����ǹ�ͺ�ʴ�������
    while ($result = mysql_fetch_array($result1))
	
    //�ʴ����㹰ҹ������

    {
	//$name = substr($result[secname], -1, 2);
	echo"$result[major]::$result[major_id],";
   }
       // �Դ�����������
 	mysql_close();
?>