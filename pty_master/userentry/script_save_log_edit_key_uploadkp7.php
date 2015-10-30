<?
require_once("../../config/conndb_nonsession.inc.php")  ;
$tbl_before = "_log_before";
$tbl_after = "_log_after";

$arr_tbl_subject = array('ข้อมูลการได้รับโทษทางวินัย'=>'hr_prohibit','ข้อมูลการปฏิบัติราชการพิเศษ'=>'hr_specialduty','ข้อมูลการประชุม ดูงาน สัมนา'=>'seminar','ข้อมูลการศึกษา'=>'graduate','ข้อมูลข้าราชการ'=>'general','ข้อมูลความดีความชอบ'=>'goodman','ข้อมูลเครื่องราชอิสรยาภรณ์'=>'getroyal','ข้อมูลเงินเดือน'=>'salary','ข้อมูลจำนวนวันลาหยุด'=>'hr_absent','ข้อมูลประวัติการเปลี่ยนชื่อบิดา'=>'hr_addhistoryfathername','ข้อมูลประวัติการเปลี่ยนชื่อภรรยา'=>'hr_addhistorymarry','ข้อมูลประวัติการเปลี่ยนชื่อมารดา'=>'hr_addhistorymothername','ข้อมูลประวัติการเปลี่ยนแปลงที่อยู่'=>'hr_addhistoryaddress','ข้อมูลภาพประวัติบุคลากร'=>'general_pic','ข้อมูลรายการอื่นๆ'=>'hr_other','ข้อมูลวันที่ไม่ได้รับเงินเดือน'=>'hr_nosalary');

$arrgeneral = array('ข้อมูลประวัติการเปลี่ยนชื่อบิดา'=>'hr_addhistoryfathername','ข้อมูลประวัติการเปลี่ยนชื่อภรรยา'=>'hr_addhistorymarry','ข้อมูลประวัติการเปลี่ยนชื่อมารดา'=>'hr_addhistorymothername','ข้อมูลประวัติการเปลี่ยนแปลงที่อยู่'=>'hr_addhistoryaddress');

function GetTable($menu_id){
		global $dbnamemaster;
		$sql = "SELECT tablename FROM table_config WHERE menu_id='$menu_id' ";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[] = $rs[tablename];	
		}//end	while($rs = mysql_fetch_assoc($result)){
			$arr;
}//end function GetTable($menu_id){

function GetPrimaryKey($tblname,$siteid){
	$dbsite = STR_PREFIX_DB.$siteid;
	$sql = "SHOW  COLUMNS FROM  $tblname WHERE TYPE NOT LIKE '%timestamp%' 
AND `Key`='PRI'";	
	$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<brLINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arrfield[] = $rs[Field];
	}// end 	while($rs = mysql_fetch_assoc($result)){
		return $arrfield;
}//end function GetPrimaryKey($tblname){
	
function GetFieldTimeUpdate($tblname,$siteid){
	$dbsite = STR_PREFIX_DB.$siteid;
	$sql = "SHOW COLUMNS FROM $tblname WHERE TYPE  LIKE '%timestamp%'";
	$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[Field];
}//end function GetFieldTimeUpdate(){
	
function GetPrikeyId(){
	global $dbnamemaster;
	$sql = "SELECT tablename,primary_key FROM `table_config` GROUP BY tablename";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_db_query()."$sql<br>LINE::".__LINE__);	
	while($rs = mysql_fetch_assoc($result)){
		$arr1 = explode(",",$rs[primary_key]);
		if($arr1[0] != ""){
			$arr[$rs[tablename]] = $arr1[0];	
		}else{
			$arr[$rs[tablename]] = "$rs[primary_key]";		
		}// end if($arr1[0] != ""){
		
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetPrikeyId(){
	
	
function GetDiffAssoc($log_id,$idcard,$siteid,$updatetime,$timestart,$timeend){
		global $dbnameuse,$dbnamemaster,$arr_tbl_subject,$tbl_before,$tbl_after,$arrgeneral;
				$arrkey1 = GetPrikeyId(); // คีย์ในการค้นหาข้อมูลบุคลากร
				$dbsite = STR_PREFIX_DB.$siteid;
					#########################   updatetime
					
					foreach($arrgeneral as $tbl_key => $tblname){
					
					$table_before = $tblname.$tbl_before; // ตาราง log before
					$table_after = $tblname.$tbl_after; // ตาราง log after

					$field_timeupdate = GetFieldTimeUpdate($tblname,$siteid);
					if($field_timeupdate != ""){
							$con_up = " AND $field_timeupdate LIKE '$updatetime'";
					}else{
							$con_up = "";	
					}
					$conwhere = " ".$arrkey1[$tblname]."='$idcard'";
					$Pkey = GetPrimaryKey($tblname,$siteid); // คีย์หลัก
					
					if(count($Pkey) > 0){
						$sql2 = "SELECT * FROM $tblname WHERE $conwhere $con_up ";
						//echo $sql2."<hr>";
						$result2 = mysql_db_query($dbsite,$sql2) or die(mysql_error()."$sql2<br>LINE::".__LINE__);
						$rs2 = mysql_fetch_assoc($result2);
						//echo "<pre>";
						//print_r($rs2);
						//echo "end<hr>";
						$conv = "";
						if($tblname != "general"){
							foreach($Pkey as $key1 => $val1){
								if($arrkey1[$tblname] != $val1){
									$where_val = $rs2[$val1];
									$conv .= "  AND $val1='".$where_val."'";
								}//end 	if($arrkey1[$tblname] != $val1)
							}//end foreach($Pkey as $key1 => $val1){
						}//end if($tblname != "general"){
						
						#### ข้อมูล log หลังการแก้ไข
						$sql_after = "SELECT * FROM $table_after WHERE $conwhere $conv $con_up  ";
					//	echo "$sql_after<br><br>";
						$result_after = mysql_db_query($dbsite,$sql_after) or die(mysql_error()."$sql_after<br>LINE::".__LINE__);
						$numr1 = mysql_num_rows($result_after);
						$rs_af = mysql_fetch_assoc($result_after);
						
						### ข้อมูล log ก่อนแก้ไขข้อมูล
						$sql_before = "SELECT * FROM $table_before WHERE auto_id='$rs_af[auto_id]' AND  $conwhere ";
						//echo $sql_before."<br><br>";
						$result_before = mysql_db_query($dbsite,$sql_before) or die(mysql_error()."$sql_before<br>LINE::".__LINE__);
						$numr2 = mysql_num_rows($result_before);
						$rs_be = mysql_fetch_assoc($result_before);
						
						if($numr1 > 0 and $numr2 > 0){
						$result1_diff = array_diff_assoc($rs_af, $rs_be); // arr diff
						
						if(count($result1_diff) > 0){
								foreach($result1_diff as $key2 => $val2){
									
									$spos = strpos($key2,"time");
									if(($spos === false)){
											$arrtbl[$tblname]['before'][] = $rs_be[$key2];
											$arrtbl[$tblname]['after'][] = $rs_af[$key2];			
											 SaveLogKey($idcard,$siteid,$_SESSION['session_staffid'],'1',$rs_be[$key2],$rs_af[$key2],$timestart,$timeend);							
									}// end if(($spos === false)){
										
								}// end 	foreach($result1_diff as $key2 => $val2){
						}// end if(count($result1_diff) > 0){
						
						}// end 		if($numr1 > 0 and $numr2 > 0){
						
						
							
					}// end if(count($Pkey) > 0){

		}// end foreach($arrgeneral as $tbl_key => $tbl_val){
			
		return $arrtbl;
}// end function GetDiffAssoc(){
	
	
function GetDifftime($idcard,$siteid,$staffid,$updatetime){
	$dbsite = STR_PREFIX_DB.$siteid;	
	$sql_log = "SELECT * FROM  log_update WHERE username='$idcard' AND staff_login='$staffid' AND updatetime <  '$updatetime'  ORDER BY updatetime DESC LIMIT 0,1";
	$result_log = mysql_db_query($dbsite,$sql_log) or die(mysql_error()."$sql_log<br>LINE::".__LINE__);
	$rs1 = mysql_fetch_assoc($result_log);
	return $rs1[updatetime];
}//end function GetDifftime($idcard,$siteid,$staffid,$timeupdate){
	
function GetLogKey($idcard,$siteid,$ticketid){
	global $dbnameuse,$dbnamemaster,$arr_tbl_subject,$tbl_before,$tbl_after,$arrgeneral;

/*	$sql = "SELECT
t3.req_person_id,
t1.ticketid,
t1.idcard,
t1.siteid,
t1.fullname,
date(t1.update_time) as date_edit,
t3.runid as log_id,
t2.staffid,
t3.req_person_id
FROM ".DB_USERENTRY.".tbl_assign_edit_key as t1
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log  as t2
ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail  as t3
ON t2.runid = t3.log_id
where   t1.ticketid='$ticketid' AND t1.idcard='$idcard' AND t1.siteid='$siteid'
GROUP BY
t1.idcard ";*/

$sql = "SELECT
t2.idcard,
t2.staffid,
t2.keyin_name,
t2.siteid,
t2.timeupdate,
t2.timestamp_key,
date(t2.timeupdate_user) as date_edit,
t1.ticketid
FROM
validate_checkdata_upload as t1
Inner Join monitor_keyin as t2 ON t1.idcard = t2.idcard AND t1.staffid = t2.staffid AND t1.siteid = t2.siteid
where t2.idcard='$idcard' and t1.ticketid='$ticketid' AND t1.siteid='$siteid' group by t2.idcard ";
//echo "$sql";
$arrkey1 = GetPrikeyId(); // คีย์ในการค้นหาข้อมูลบุคลากร
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$dbsite = STR_PREFIX_DB.$rs[siteid];
		$sql_log = "SELECT * FROM log_update WHERE username='$rs[idcard]' AND date(updatetime)='$rs[date_edit]' AND staff_login='$rs[staffid]' AND action NOT LIKE '%login%'";	
		$result_log = mysql_db_query($dbsite,$sql_log) or die(mysql_error()."$sql_log<br>LINE::".__LINE__);
		while($rsl = mysql_fetch_assoc($result_log)){
			$tblname = GetTable($rsl[menu_id]);
			if($tblname == ""){
				$tblname = 	$arr_tbl_subject[$rsl[subject]]; // หาตารางจาก subject
			}// end if($tblname == ""){
				
				############  กรณี value ไม่เท่ากับค่าว่าง
				if($tblname != ""){
					
					$time_before =  GetDifftime($rs[idcard],$rs[siteid],$rs[staffid],$rsl[updatetime]);
					
				if($tblname == "general"){
					 GetDiffAssoc($rs[log_id],$rs[idcard],$rs[siteid],$rsl[updatetime],$time_before,$rsl[updatetime]);
				}// end 	if($tblname == "general"){
					
					$table_before = $tblname.$tbl_before; // ตาราง log before
					$table_after = $tblname.$tbl_after; // ตาราง log after
				
					#########################   updatetime
					
					$field_timeupdate = GetFieldTimeUpdate($tblname,$rs[siteid]);
					if($field_timeupdate != ""){
							$con_up = " AND $field_timeupdate LIKE '$rsl[updatetime]'";
					}else{
							$con_up = "";	
					}
					$conwhere = " ".$arrkey1[$tblname]."='$rs[idcard]'";
					$Pkey = GetPrimaryKey($tblname,$rs[siteid]); // คีย์หลัก
					
					if(count($Pkey) > 0){
						$sql2 = "SELECT * FROM $tblname WHERE $conwhere $con_up ";
						//echo $sql2."<hr>";
						$result2 = mysql_db_query($dbsite,$sql2) or die(mysql_error()."$sql2<brLINE::".__LINE__);
						$rs2 = mysql_fetch_assoc($result2);
						//echo "<pre>";
						//print_r($rs2);
						//echo "end<hr>";
						$conv = "";
						if($tblname != "general"){
							foreach($Pkey as $key1 => $val1){
								if($arrkey1[$tblname] != $val1){
									$where_val = $rs2[$val1];
									$conv .= "  AND $val1='".$where_val."'";
								}//end 	if($arrkey1[$tblname] != $val1)
							}//end foreach($Pkey as $key1 => $val1){
						}//end if($tblname != "general"){
						
						#### ข้อมูล log หลังการแก้ไข
						$sql_after = "SELECT * FROM $table_after WHERE $conwhere $conv $con_up  ";
						//echo "$sql_after<br><br>";
						$result_after = mysql_db_query($dbsite,$sql_after) or die(mysql_error()."$sql_after<br>LINE::".__LINE__);
						$numr1 = mysql_num_rows($result_after);
						$rs_af = mysql_fetch_assoc($result_after);
						
						### ข้อมูล log ก่อนแก้ไขข้อมูล
						$sql_before = "SELECT * FROM $table_before WHERE auto_id='$rs_af[auto_id]' AND  $conwhere ";
						//echo $sql_before."<br><br>";
						$result_before = mysql_db_query($dbsite,$sql_before) or die(mysql_error()."$sql_before<br>LINE::".__LINE__);
						$numr2 = mysql_num_rows($result_before);
						$rs_be = mysql_fetch_assoc($result_before);
						
						if($numr1 > 0 and $numr2 > 0){
						$result1_diff = array_diff_assoc($rs_af, $rs_be); // arr diff
						
						if(count($result1_diff) > 0){
								foreach($result1_diff as $key2 => $val2){
									
									$spos = strpos($key2,"time");
									if(($spos === false)){
													 SaveLogKey($rs[idcard],$rs[siteid],$rs[staffid],$rsl[menu_id],$rs_be[$key2],$rs_af[$key2],$time_before,$rsl[updatetime]);

										
									}
										
								}// end 	foreach($result1_diff as $key2 => $val2){
						}// end if(count($result1_diff) > 0){
						
						}// end 		if($numr1 > 0 and $numr2 > 0){
						
						
							
					}// end if(count($Pkey) > 0){
					
						}//	 end if($tblname == "general"){
					}// end foreach($arrgeneral as $tbl_key => $tbl_val){
					
				}// end if($tblname != ""){	
				
		
	
	return $arr_str;
}// end function GetLogKey($req_id){
	
	
function SaveLogKey($idcard,$siteid,$staffid,$menu_id,$val_before,$val_after,$timestart,$timeend){
	global $dbnameuse;
	$sql = "INSERT INTO validate_checkdata_upload_editdata  SET idcard='$idcard',siteid='$siteid',staffid='$staffid',menu_id='$menu_id',val_before='$val_before',val_after='$val_after',timestart='$timestart',timeend='$timeend' ";	
	mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
}
	
	
	##$arrtxt = GetLogKey("68346");
	
		GetLogKey("$rs1[idcard]","$rs1[siteid]","$rs1[ticketid]");	
	
	//GetLogKey("1100700052809","7401","TK-255405060918180123479");








?>