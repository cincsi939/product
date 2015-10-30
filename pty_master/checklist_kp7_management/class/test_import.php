<?
# by : suwat
# module : check import cmss

include("../../../config/conndb_nonsession.inc.php");
include("class.compare_data.php");
$obj = new Compare_DataImport();
$arr_field = array();
$arr_compare = array();
$arr_field = $obj->GetFieldCompare();
$confield = $obj->GetConField($arr_field);


$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='9601' and profile_id='5'";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	
	$arr_compare = $obj->CheckDataImport("$rs[siteid]","$rs[idcard]",$confield);
	#echo "<pre>";
	#print_r($arr_compare);
	if(count($arr_field) > 0){
			foreach($arr_field as $key => $val){
				#echo $val['field_name']." =  checklist :: ".$rs[$val['field_name']]."=> general :: ".$arr_compare[$val['field_compare']]."<br>";
				
					if(($rs[$val['field_name']] != $arr_compare[$val['field_compare']]) and $arr_compare[$val['field_compare']] != ""){
							echo "<hr>$rs[idcard] ||".$val['field_name'] ."||  $key => checklist :: ".$rs[$val['field_name']] ." => general :: ". $arr_compare[$val['field_compare']]."</hr>";
					}
			}//end 	foreach($arr_field as $key => $val){
	}//end if(count($arr_field) > 0){
		
		
		
	unset($arr_compare);
}// end while($rs = mysql_fetch_assoc($result)){

echo "<br>Done...";

?>