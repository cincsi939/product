<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

 SubQCGroupL($group_id,$configdate,$staffid);
echo "<script>alert('�����żš���觡���� QC ���º��������');  window.opener.location.reload();window.close(); </script>";




?>