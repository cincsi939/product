<?
include("../../config/conndb_nonsession.inc.php");
class GetDataChecklist{
	
	function Get_Data($idcard,$profile_id){
			return 	$this->GetChecklist($idcard,$profile_id);			
	}//end function date_data($idcard,$xsiteid){
	
	function GetChecklist($idcard,$profile_id){
		global $dbname_temp;
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$arr['prename_th'] = $rs[prename_th];
		$arr['name_th'] = $rs[name_th];
		$arr['surname_th'] = $rs[surname_th];
		$arr['fullname'] = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
		$arr['pic_num'] = $rs[pic_num];
		$arr['pic_upload'] = $rs[pic_upload];
		echo "<pre>";
		print_r($arr);
		return $arr;
	}// end function date_salary($xsiteid){
		

}//  end class GetDataChecklist{
	
	
$xidcard = "4670200007278";
$profile_id = "1";
$x = new GetDataChecklist();
$arr =$x->Get_Data($xidcard,$profile_id);
echo "<pre>";
print_r($arr);



?>