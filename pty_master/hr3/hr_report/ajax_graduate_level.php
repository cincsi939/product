<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;

	$sql_select = "select * from hr_adddegree where degree_id LIKE '$runid%' order by runid ";
    $result1= mysql_query( $sql_select );
     //�����ǹ�ͺ�ʴ�������
    while ($result = mysql_fetch_array($result1))
	
    //�ʴ����㹰ҹ������
	
    {
	//$name = substr($result[secname], -1, 2);
	echo"$result[degree_fullname]::$result[degree_id],";
   }
       // �Դ�����������
 	mysql_close();
?>