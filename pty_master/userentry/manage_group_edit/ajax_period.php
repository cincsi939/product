<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;

    $sql_select=" select  *  from tbl_assign_edit_period_detail  where period_master_id = '$mid' order by periodname asc";
    $result1= mysql_db_query($dbnameuse,$sql_select );
     //�����ǹ�ͺ�ʴ�������
    while ($rs = mysql_fetch_array($result1)) {

	echo"  $rs[periodname]::$rs[period_id],";
   }
       // �Դ�����������
 	mysql_close();
?>