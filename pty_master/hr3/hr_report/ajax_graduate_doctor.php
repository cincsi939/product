<?php
    header("Content-Type: text/plain; charset=windows-874");

    //����������ǡѺ�ҹ�����ŷ����
	include ("../../../config/conndb_nonsession.inc.php")  ;
	//$id=substr($major_doctor_id,0,1);
	if(strlen($major_doctor_id)<=8)
	{
		$id=substr($major_doctor_id,0,1);
		$str_length = " and length(major_id) = '8'";
	}
	else
	{
		$id=substr($major_doctor_id,0,2);
		$str_length = " and length(major_id) = '9'";
	}

	//$sql_select = "select * from hr_addmajor where major_id LIKE '$major_id%' order by runid ";
		$sql_select = "select * from hr_addmajor where major_id LIKE '$id%' AND major_id NOT LIKE '$id%00' $str_length order by runid ";
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