<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
$dbname_temp = $db_name;

######  �ӡ�û����żš�ùѺQC
	if($action == "process_qc"){
		$cong = " WHERE  keystaff.keyin_group='$xtype' AND status_permit='YES'";		
		
		$sql_p = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff $cong";
//echo "$dbnameuse :: ".$sql_p;die;
		$result_p = mysql_db_query($dbnameuse,$sql_p);
		while($rsp = mysql_fetch_assoc($result_p)){
			//echo $rsp[staffid];die;
				 SubQCGroupL($xtype,$configdate,$rsp[staffid]);
		}//end while($rsp = mysql_fetch_assoc($result_p)){
		
			echo "<script>alert('�����żš���觡���� QC ���º��������');  window.opener.location.reload();window.close(); </script>";
		//exit;
	}///end 	if($action == "process_qc"){





?>