<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;
	include ("../libary/function.php");

	echo get_hisname($xid,$xsiteid);
       // �Դ�����������
 	mysql_close();
?>