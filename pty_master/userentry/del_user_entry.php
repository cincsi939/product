<?
session_start();
/*****************************************************************************
Function		: ��䢢����Ţͧ $epm_staff
Version			: 1.0
Last Modified	: 16/8/2548
Changes		:

*****************************************************************************/
include "epm.inc.php";
$dbcall = "edubkk_userentry";


if($action=="delete"){
	
	$sql = " UPDATE  monitor_keyin  SET  status_approve = '0'  WHERE  staffid = '$staffid'  AND  idcard = '$idcard'  " ;

mysql_db_query($dbcall,$sql);
		if (mysql_errno() != 0){
			echo "<script>alert('�������ö��ҧ��������');window.close();</script>";
		}else{
			echo "<script>alert('��ҧ���������º��������');
					opener.document.location.reload();
					window.close();
					 </script>";
			exit;
		}	
		
}


?>