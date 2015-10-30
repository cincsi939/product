<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "class process idcard";
$module_code = "class";
$process_id = "process";
$VERSION = "9.1";
$BypassAPP= true;
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110920.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-09-20 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110920.00
	## Modified Detail :		นำเข้าเลขบัตรจำลอง
	## Modified Date :		2011-09-20 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
require_once("../../config/conndb_nonsession.inc.php");
require_once("../../common/lib/Genidcard.php");

class ProcessIdcard extends Genidcard{
	var  $dbnamemaster=DB_MASTER;
	var $dbname_temp = DB_CHECKLIST; 
	var $dbnameuse = DB_USERENTRY;
	var $tbl_log_genid = "log_gen_idcard"; // ชื่อตารางเก็บข้อมูล การ gen เลขบัตร
	var $tbl_checklist_kp7 = "tbl_checklist_kp7"; // ชื่อตารางชื่อข้อมูลที่เลขบัตรไม่ถูกต้องตามกรมการปกครอง
	var $tbl_profile = "view_checklist_lastprofile";//
	var $tbl_log = "log_change_idcard_generate";//  log การเปลี่ยนเ
	
	private function Script_checkID($StrID){
     if(is_numeric($StrID)){
				 $sub_id = substr($StrID,0,1); // หาตัวเลขตัวแรกว่าเป็น 0 หรือไม่
				if($sub_id >0){
					if(strlen($StrID)==13){
						$id=str_split($StrID); 
						$sum=0;    
							for($i=0; $i < 12; $i++){
								 $sum += floatval($id[$i])*(13-$i); 
							}   
								if((11-$sum%11)%10!=floatval($id[12])){
									 return false;
								}else{
									 return true; 
								}
					}else{
						return false;
					} 
			}else{
				return false; 
			}
    }else{
        return false;    
    }
}//end private function Script_checkID($StrID){
	
#### หาเลขบัตรที่ไม่ตรงการปกครอง
public function GetIdcardGen($numlimit=""){
	if($numlimit != ""){
			$conlimit = " LIMIT $numlimit";
	}else{
			$conlimit = "";
	}
	$sql = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.status_id_false
FROM
tbl_checklist_kp7 AS t1
Inner Join view_checklist_lastprofile AS t2 ON t1.profile_id = t2.last_profile AND t1.profile_id = t2.last_profile AND t1.siteid = t2.siteid
where t1.status_id_false='1' $conlimit";
	$result = mysql_db_query($this->dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$new_idcard = $this->genID($rs[siteid]); // เลขบัตรประชาชน
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
			if($this->Script_checkID($new_idcard)){// ตรวจสอบเลขบัตรประชาชนที่ gen อีกครั้ง
				$this->UpdateIdcardChecklist($rs[idcard],$new_idcard,$rs[siteid],$rs[profile_id]); // ทำการเปลี่ยนเลขบัตรประชาชน
				# เก็บ log การเปลี่ยนเลขบัตร
				$this->SaveLogIdcard($rs[idcard],$new_idcard,$rs[siteid],$rs[profile_id]);
				# set status เลขบัตรที่นำไปใช้
				$this->UpdateLogGen($new_idcard);
			}
			
	}//end while($rs = mysql_fetch_assoc($result)){
}//end private function GetIdcardGen(){
	
######  update 

public function Query($dbname,$sql){
		return mysql_db_query($dbname,$sql) or die(mysql_error()."$sql<br>".__LINE__);
}

public function GetRows($result){
		return mysql_fetch_assoc($result);
}

	
private function UpdateIdcardChecklist($idcard,$new_idcard,$siteid,$profile_id){
		$sql = "update  ".$this->tbl_checklist_kp7." SET idcard='$new_idcard',status_id_false='0' WHERE idcard='$idcard' AND status_id_false='1' AND siteid='$siteid' AND profile_id='$profile_id' ";
		#echo $sql."<br>";
		$this->Query($this->dbname_temp,$sql);
		$sql1 = "UPDATE tbl_checklist_kp7_all_checklist_notin_cmss SET idcard='$new_idcard' WHERE idcard='$idcard' ";
		$this->Query($this->dbname_temp,$sql1);
		
}

private function SaveLogIdcard($idcard_old,$idcard_new,$siteid,$profile_id){
		$sql = "insert into ".$this->tbl_log." set idcard_old='$idcard_old',idcard_new='$idcard_new',profile_id='$profile_id',siteid='$siteid',time_update=NOW()";
		$this->Query($this->dbname_temp,$sql);
}

private function UpdateLogGen($idcard){
		$sql = "update ".$this->tbl_log_genid." set status='1' WHERE idcard='$idcard'";
		#echo $sql."<br>";die;
		$this->Query($this->dbnamemaster,$sql);	
}

public function GetLogChange($siteid=""){
	if($siteid != ""){ $consite = " Where siteid='$siteid' ";}else{ $consite = "";}
	$sql = "select  * FROM ".$this->tbl_log."  $consite";	
	$result = $this->Query($this->dbname_temp,$sql);
	while($rs=$this->GetRows($result)){
			$arr[$rs[idcard]] = $rs[idcard_old]."=>".$rs[idcard_new];
	}
	
	return $arr;
}

	
	
	 

}// end class ProcessIdcard extends Genprocess{
	
$obj = new ProcessIdcard();
$obj->GetIdcardGen();
echo "<br>Done.....";
#echo "<pre>";
#print_r($obj->GetLogChange());

	
	
	
?>