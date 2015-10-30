<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
//$constaff = " AND stat_user_keyperson.staffid='10319'";

$configdate = date("Y-m");
$sql = "SELECT
stat_user_person_temp.flag_id,
stat_user_keyperson.datekeyin,
stat_user_keyperson.staffid,
Count(distinct idcard) AS num1,
stat_user_person_temp.num_doc
FROM
stat_user_person_temp
Inner Join stat_user_keyperson ON stat_user_person_temp.flag_id = stat_user_keyperson.flag_qc AND stat_user_person_temp.staffid = stat_user_keyperson.staffid
WHERE
stat_user_person_temp.dateqc LIKE  '$configdate%' AND
stat_user_person_temp.num_doc =  '20' $constaff
group by stat_user_person_temp.staffid,stat_user_person_temp.flag_id
having num1 < 20
order by num1 asc
";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
while($rs = mysql_fetch_assoc($result)){
         $kvalgroup  = ShowQvalue($rs[staffid]); // จำนวนชุดที่ต้อง QC
		 ResetSubGroupQC($rs[staffid],$configdate,$kvalgroup);// 
}//end while($rs = mysql_fetch_assoc($result)){
echo "OK";

//echo "xxx :: $group_id :: $configdate";die;
/*if($group_id == ""){
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