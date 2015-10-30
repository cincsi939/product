<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
//$constaff = " AND staffid='10015'";
$yymm = "2011-05";
$sql = "SELECT COUNT(idcard) as num1,idcard,staffid,MIN(flag_qc) AS minflag FROM stat_user_keyperson where datekeyin LIKE '$yymm%'  AND  flag_qc > 0 $constaff group by staffid,idcard having num1 > 1";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sqlup = "UPDATE stat_user_keyperson SET flag_qc='$rs[minflag]' WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]' and  datekeyin LIKE '$yymm%'  ";
	mysql_db_query($dbnameuse,$sqlup) or die(mysql_error()."$sqlup<br>LINE::".__LINE__);
		
}//end while($rs = mysql_fetch_assoc($result)){
	

	$arrgroup = array("2"=>"2","5"=>"5");
	$configdate = date("Y-m");
	foreach($arrgroup as $key => $val){
		SubQCGroupL($val,$configdate,"");	
	}

	echo "OK";

/*$dbname_temp = $db_name;
$arrgroup = array("2"=>"2","5"=>"5");
//echo "xxx :: $group_id :: $configdate";die;
if($group_id == ""){
	$configdate = date("Y-m");
	foreach($arrgroup as $key => $val){
		SubQCGroupL($val,$configdate,"");	
	}
}else{
 	SubQCGroupL($group_id,$configdate,"");
}
 
 if($xscript == "1"){
	echo "<script>alert('ประมวลผลการแบ่งกลุ่ม QC เรียบร้อยแล้ว');  window.opener.location.reload();window.close(); </script>";
 }else{
	echo "OK";		 
}

*/


?>