<?php
## class add queue การประมวลผล gen ก.พ. 7 อิเล็กทรอนิกส์

class AddQueueGen{
		var $db_master = DB_MASTER;
		var $tbl_q = "kp7gen_queue_process";
		var $tbl_q_log = "kp7gen_quere_process_log";
		var $tbl_file_ele = "kp7gen_electronic";
		var $tbl_view = "view_general";
		var $db_req = "cmss_req";
		var $status_req = "3";
		
		
		function Query($db,$sql){
			return mysql_db_query($db,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);	
		}
		function GetResult($db,$sql){
			return mysql_fetch_assoc(mysql_db_query($db,$sql));
		}
		
		## ตรวจสอบการเพิ่ม Queue
		function CheckQuery($idcard){
			$sql = "SELECT COUNT(idcard) as num1 FROM ".$this->tbl_q." WHERE idcard='$idcard' GROUP BY idcard";	
			$rs = $this->GetResult($this->db_master,$sql);
			return $rs[num1];
		}
		
		### เพิ่ม Queue
		function SaveQueue($idcard,$siteid,$date_queue_process,$flag_process_now='0'){
			$sql = "INSERT INTO ".$this->tbl_q." SET idcard='$idcard',siteid='$siteid',date_queue_process='$date_queue_process',flag_process_now='$flag_process_now'";
			$this->Query($this->db_master,$sql);				
		}//end 	function SaveQueue(){
		
		## update queue
		function UpdateQueue($idcard,$siteid,$date_queue_process,$flag_process_now='0'){
			$sql = "UPDATE ".$this->tbl_q." SET siteid='$siteid',date_queue_process='$date_queue_process',flag_process_now='$flag_process_now' WHERE idcard='$idcard'";	
			$this->Query($this->db_master,$sql);
		}
		
		### delete queue
		function DeleteQueue($idcard){
				$sql = "DELETE FROM ".$this->tbl_q." WHERE idcard='$idcard'";
				$this->Query($this->db_master,$sql);
		}
		
		### เพิ่ม  ข้อมูลในตาราง log การประมวลผลข้อมูล
		function InsertLogProcess($idcard,$ip_process,$kp7file_load,$password_kp7,$error_process,$user_gen="Script"){
			$sql = "INSERT INTO ".$this->tbl_q_log."(idcard,siteid,user_gen,ip_process,error_process,date_process,kp7file_load,password_kp7)
			SELECT idcard,siteid,'".$user_gen."','".$ip_process."','$error_process',NOW(),'".$kp7file_load."','".$password_kp7."'   FROM ".$this->tbl_q." WHERE idcard='$idcard'";	
			$this->Query($this->db_master,$sql);
		}//end function InsertLogProcess($idcard,$ip_process,$user_gen="Script"){
			
		function CleanSiteProcess($siteid=""){
				if($siteid != ""){
						$conw = " Where siteid='$siteid'" ;
				}else{
						$conw = "";	
				}
				$sql = "UPDATE kp7gen_site_process SET flag_process='0' $conw  ";
				$this->Query($this->db_master,$sql);
		}//end function CleanSiteProcess($siteid=""){
			
		function UpdateSiteProcess($siteid){
				$sql = "UPDATE kp7gen_site_process SET flag_process='1' WHERE siteid='$siteid' ";
				$this->Query($this->db_master,$sql);
		}
		
		
		function InsertResultKp7File($idcard,$siteid,$flagkp7_org,$flagkp7_ele,$timeupdate_viewgeneral,$size_kp7file,$size_kp7org,$time_start,$time_stop,$page_numfile,$kp7file_load,$password_kp7){
			$sql = "REPLACE  INTO  ".$this->tbl_file_ele." SET idcard='$idcard',siteid='$siteid',flagkp7_org='$flagkp7_org',flagkp7_ele='$flagkp7_ele',timeupdate_viewgeneral='$timeupdate_viewgeneral',size_kp7file='$size_kp7file',size_kp7org='$size_kp7org',time_stop='$time_stop',time_start='$time_start',page_numfile='$page_numfile',kp7file_load='$kp7file_load',password_kp7='$password_kp7',timeupdate=NOW() ";	
			#echo $sql;die();
			$this->Query($this->db_master,$sql);
		}
		
		
		
		### นับผลการแก้ไขคำร้องขอแก้ไขข้อมูล
		function CheckReqResult($idcard){
			$sql = "SELECT count(idcard) as num1 FROM `req_problem_person` where req_date like '".date("Y")."%' and req_status='".$this->status_req."' and idcard='$idcard' group by idcard";	
			$rs = $this->GetResult($this->db_master,$sql);
			return $rs[num1];
		}
		
		
		#### ส่วนของการ gencode
		
		
function getNextNumber($n,$digit,$padzero=0){ // example : 1 => 2 => 3
	$nval = $n+1;
	for($i=0; $i<$digit; $i++){
		$nmax .= "9";
	}

	if($nval > $nmax){
		if($padzero == 1){
			$nval = sprintf("%0".$digit."s","1"); 
		}else{
			$nval = 1;
		}
	}
			
	if($padzero == 1){
		$sn = sprintf("%0".$digit."s",$nval);
	}
	return $sn;
}


function getNextChar($char){
	$i = ord($char);
	$i++;
	if($i > 90)$i=65; // 90:Z , 65:A
	
	return chr($i);
}

function getNextCN($char){ // example : A0 - Z9
	$C = substr($char,0,1);
	$N = substr($char,1,1);
	
	if($N == '9'){
		$C = $this->getNextChar($C);
		$N = 0;
	}else{
		$N++;
	}
	
	return $C.$N;
}
		

	function genDaBarcode(){
		global $xsiteid;
		$tbl1 = "req_problem_groupno_".$xsiteid;
	//return "FJAKDFJ";
//	$keycut = substr($key,0,3); // exp : 53AA0001 => 53AA0
	$sql = "SELECT MAX(kp7_loadid) AS nextbarcode FROM $tbl1 ";
	#echo $sql."<hr>";
	$row = $this->GetResult($this->db_master,$sql);
	$nextbarcode = $row[nextbarcode];


	if($nextbarcode != ""){
		$NNN = substr($nextbarcode,5,3);
		$CC = substr($nextbarcode,3,2);
		$C = substr($nextbarcode,2,1);
		$YY = substr($nextbarcode,0,2);
	}else{
		$NNN = "000";
		$CC = "A0";
		$C = "A";
		$YY = substr(date('Y')+543,2,2);
	}	
	
	$NNN = $this->getNextNumber($NNN,3,1);
	
	if($CC == "Z9"){
		$C = $this->getNextChar($C);
	}
	
	if($NNN == "001")
	{
		if($nextbarcode != "")
			$CC = $this->getNextCN($CC);	
	}
	//$keycut = substr(date('Y')+543,2,2);
	//echo $CC;

	$keycut = $YY.$C;
	$nexid = sprintf("%003d",$row[maxid]);
	
	$barcode = $keycut.$CC.$NNN;

	return $barcode;
}
		
		
		function SaveGenLoadFile($idcard,$siteid,$viewgeneral_timeupdate,$kp7_loadid){
			$tbl_load = "req_kp7_load_".$siteid;
			
			$sql_ins = "INSERT INTO $tbl_load SET kp7_loadid='$kp7_loadid' , idcard = '$idcard' , siteid='$siteid', create_date = now() , viewgeneral_timeupdate='$viewgeneral_timeupdate' , kp7file='".$idcard."_".$kp7_loadid.".pdf'";
			$this->Query($this->db_req,$sql_ins);
		
		}
		
		
	function insertKp7_loadid($kp7_loadid,$problem_groupid,$no_caption,$pin){
		global $xsiteid;
		$tbl_reqno = "req_problem_groupno_".$xsiteid;
		$no_caption = trim($no_caption);
 		if(!get_magic_quotes_gpc()){
			$no_caption			= addslashes($no_caption);
		 }
		$sql_ins = "INSERT INTO $tbl_reqno SET kp7_loadid='$kp7_loadid',problem_groupid = '$problem_groupid' , no_caption = '$no_caption' , pin='$pin'";
		#echo $sql_ins."<br>";die();
		$this->Query($this->db_req,$sql_ins);
	
	}
	
		
}//end class AddQueueGen{


?>