<?
session_start();
/*****************************************************************************
Function		: แก้ไขข้อมูลของ $epm_staff
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
			echo "<script>alert('ไม่สามารถล้างข้อมูลได้');window.close();</script>";
		}else{
			echo "<script>alert('ล้างข้อมูลเรียบร้อยแล้ว');
					opener.document.location.reload();
					window.close();
					 </script>";
			exit;
		}	
		
}


?>