<?
# by : suwat
# module : check import cmss

#include("../../../config/conndb_nonsession.inc.php");
class Compare_DataImport{
	private  $tbl_general = "general";
	private  $tbl_check = "tbl_checklist_kp7";
	private $tbl_confirm = "log_import_cmss_confirm";
	private $tbl_field = "field_import_data_confirm";
	private  $db_temp = "edubkk_checklist";
	var $__result = "";
	var $__rs = array();
	var $__error = "";
	
	
	
	private function SqlError($sql){
		return mysql_error()."$sql<br>LINE__".__LINE__;
	}
	private function Query($db,$sql){
		return mysql_db_query($db,$sql).$this->SqlError("$db || $sql");	
	}
	
	
	private	function SetError(){
		return $this->__error = "";	
	}

	private	function SetRs(){
		return $this->__rs="";
	}
	
	private	function SetResult(){
		return $this->__result="";	
	}
	
	private function GetResult($db,$sql){
		return mysql_fetch_assoc(mysql_db_query($db,$sql));
	}


	### ตรวจสอบข้อมูลกับฐาน cmss
	function CheckDataImport($siteid,$idcard,$field_select){
		$dbsite = "cmss_".$siteid;
		$sql = "SELECT $field_select FROM ".$this->tbl_general." WHERE idcard = '$idcard' ";
		return $this->GetResult($dbsite,$sql);
	}//end function CheckDataImport($siteid,$idcard,$field_select){
		
	### ฟิลด์บังครับที่ใช้ตรวจสอบ
	function GetFieldCompare(){
			$sql = "SELECT field_id,field_name,field_compare,field_comment FROM ".$this->tbl_field." WHERE field_active='1'";
			#echo $this->db_temp." => ".$sql."<hr>";
			$result = mysql_db_query($this->db_temp,$sql) or die($this->SqlError($sql));
			$arr = array();
			while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[field_id]]['field_name'] = $rs[field_name];
				$arr[$rs[field_id]]['field_compare'] = $rs[field_compare];
				$arr[$rs[field_id]]['field_comment'] = $rs[field_comment];
			}
			return $arr;
	}//end function GetFieldCompare(){
		
	function GetConField($arr_field){
		$confield = "";
		foreach($arr_field as $key => $val){
			if($confield > "") $confield .= ",";
			$confield .= $val[field_compare];	
		}
		return $confield;
	}// end 	function GetConField(){
		

	
		### เพิ่มข้อมูลใน log การนำเข้าข้อมูล
		function SaveLogCompare($import_id,$idcard,$siteid,$field_id,$value_import,$value_check){
			$sql = "INSERT INTO ".$this->tbl_confirm." SET import_id='$import_id',idcard='$idcard', siteid='$siteid',field_id='$field_id',value_import='$value_import',value_check='$value_check',timeupdate=NOW()";	
			$this->Query($this->db_temp,$sql);
		}//end function SaveLogCompare($import_id,$idcard,$siteid,$field_id,$value_import,$value_check){
			
		function SaveConfirmData($import_id,$idcard,$field_id,$staff_confirm,$mode_data){
			$sql = "UPDATE  ".$this->tbl_confirm." SET status_confirm='1',staff_confirm='$staff_confirm',mode_data='$mode_data' WHERE import_id='$import_id' AND idcard='$idcard' AND field_id='$field_id'";	
			#echo $sql."<hr>";
			$this->Query($this->db_temp,$sql);
		}// end SaveConfirmData(){
		
		### นับ ข้อมูลที่ต้องทำการ ยืนยัน
		function CountLogConfirm($import_id){
			$sql = "SELECT COUNT(idcard) AS num FROM ".$this->tbl_confirm." WHERE import_id='$import_id'";	
			$rs = $this->GetResult($this->db_temp,$sql);
			return $rs[num];
		}
		
		### นับจำนวนรายการที่รอยืนยัน
		function CountNumListConfirm($import_id,$siteid){
				$sql  = "SELECT COUNT(distinct idcard) as num FROM ".$this->tbl_confirm." WHERE import_id='$import_id' AND siteid='$siteid'";
				$rs = $this->GetResult($this->db_temp,$sql);
				return $rs[num];
		}// end 	function CountNumListConfirm($import_id,$siteid){
		
		
		### update ข้อมูลใน general
		function UpdateGeneral($siteid,$idcard,$confield){
			$dbsite = "cmss_".$siteid;
			if($confield != ""){
				$sql = "UPDATE general SET $confield  WHERE  idcard='$idcard'";	
				#echo $sql."<hr>";
				$this->Query($dbsite,$sql);
			}//end if($confield != ""){
		}
		
}//end class Compare_DataImport{

/*#1509900004039
$obj = new Compare_DataImport();
#$data = $obj->CheckDataImport("5001","150","birthday");
$arr_field = $obj->GetFieldCompare();
echo "<pre>";
print_r($arr_field);

foreach($arr_field as $key => $val){
		if($confield > "") $confield .= ",";
		$confield .= $val[field_compare];	
}
echo "confield => ".$confield;
$arr_data  = $obj->CheckDataImport("9601","3960200441872",$confield);
echo "<pre>";
print_r($arr_data);*/



?>