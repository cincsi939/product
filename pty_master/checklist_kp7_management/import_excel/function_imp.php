<?

############  log ในการลบข้อมูลจาก checklist ออกจากระบบโดยยึดข้อมูลจาก excel
	function LogDeleteChecklistkp7($idcard,$siteid,$profile_id){
		global $dbname_temp;
		$sql = "SELECT COUNT(idcard) as num1  FROM tbl_checklist_kp7_logdelete WHERE idcard='$idcard' AND siteid='$siteid' AND profile_id='$profile_id' ";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] < 1){
			$sql_insert = "INSERT INTO tbl_checklist_kp7_logdelete(idcard,siteid,prename_th,name_th,surname_th,position_now,birthday,begindate,schoolid,profile_id,pic_upload,page_upload,staff_login)
			SELECT t2.idcard,t2.siteid,t2.prename_th,t2.name_th,t2.surname_th,t2.position_now,t2.birthday,t2.begindate,t2.schoolid,t2.profile_id,t2.pic_upload,t2.page_upload,'".$_SESSION['session_staffid']."'
  FROM tbl_checklist_kp7 AS t2 WHERE t2.idcard='$idcard' AND t2.siteid='$siteid' AND t2.profile_id='$profile_id' ";
			mysql_db_query($dbname_temp,$sql_insert);
		}// end if($rs[num1] < 1){
		//$sql = "REPLACE INTO tbl_checklist_kp7_logdelete SET idcard='$idcard' ,";
	}//end 		function LogDeleteChecklistkp7($idcard,$siteid,$profile_id){


##### log ในการนำข้อมูลจาก checklist_logdelete กลับมายัง checklist ###
function ReDataFromChecklist($idcard,$siteid,$profile_id){
	global $dbname_temp;
		$sql = "SELECT COUNT(idcard) as num1  FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$siteid' AND profile_id='$profile_id' ";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] < 1){
			$sql_insert = "INSERT INTO tbl_checklist_kp7(idcard,siteid,prename_th,name_th,surname_th,position_now,birthday,begindate,schoolid,profile_id,pic_upload,page_upload)
			SELECT t2.idcard,t2.siteid,t2.prename_th,t2.name_th,t2.surname_th,t2.position_now,t2.birthday,t2.begindate,t2.schoolid,t2.profile_id,t2.pic_upload,t2.page_upload
  FROM tbl_checklist_kp7_logdelete AS t2 WHERE t2.idcard='$idcard' AND t2.siteid='$siteid' AND t2.profile_id='$profile_id'
			";
			$result_query = mysql_db_query($dbname_temp,$sql_insert);
			if($result_query){
				$result1 = 1;	
			}else{
				$result1 = 0;
			}//end 	if($result_query){
			###   ทำการ update สถานะข้อมูลใน log
			$sql_update = "UPDATE tbl_checklist_kp7_logdelete SET flag_redata='1' WHERE idcard='$idcard' AND siteid='$siteid' AND profile_id='$profile_id'";
			mysql_db_query($dbname_temp,$sql_update);

		}else{
			$result1 = 1;
		}// end if($rs[num1] < 1){
			return $result1;
		
}//end function ReDataFromChecklist($idcard,$siteid,$profile_id){

##### end  log ในการนำข้อมูลจาก checklist_logdelete กลับมายัง checklist ###
function InsertTempChecklist($idcard,$siteid,$prename_th,$name_th,$surname_th,$profile_id){
	global $dbname_temp;
	$sql_insert = "REPLACE INTO tbl_checklist_kp7_temp SET idcard='$idcard',siteid='$siteid',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',profile_id='$profile_id',  staffupload='".$_SESSION['session_staffid']."'";
	mysql_db_query($dbname_temp,$sql_insert);
}//end function InsertTempChecklist(){

function CleanTemp($siteid,$profile_id){
	global $dbname_temp;
	$sql = "DELETE FROM  tbl_checklist_kp7_temp WHERE siteid='$siteid'  AND profile_id='$profile_id' AND staffupload='".$_SESSION['session_staffid']."' ";	
	mysql_db_query($dbname_temp,$sql);
}



########  function  ในการลบข้อมูลใน checklist ในกรณีที่ไม่มีใน excel
function CutOffChecklistKp7($xsiteid,$profile_id){
	global $dbname_temp;
		$sql_kp7 = "SELECT tbl_checklist_kp7.idcard,tbl_checklist_kp7.siteid,tbl_checklist_kp7.profile_id FROM tbl_checklist_kp7 Left Join tbl_checklist_kp7_temp ON tbl_checklist_kp7.idcard = tbl_checklist_kp7_temp.idcard AND tbl_checklist_kp7_temp.profile_id='$profile_id' AND tbl_checklist_kp7_temp.staffupload='".$_SESSION['session_staffid']."'
WHERE tbl_checklist_kp7_temp.idcard IS NULL  AND tbl_checklist_kp7.profile_id =  '$profile_id' AND tbl_checklist_kp7.siteid =  '$xsiteid'";
		$result_kp7 = mysql_db_query($dbname_temp,$sql_kp7);
		while($rs7 = mysql_fetch_assoc($result_kp7)){
			### ลบข้อมูลใน checklist
			$sql_delkp7 = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$rs7[idcard]' AND siteid='$rs7[siteid]' AND profile_id='$rs7[profile_id]' ";
			mysql_db_query($dbname_temp,$sql_delkp7);
			LogDeleteChecklistkp7($rs7[idcard],$rs7[siteid],$rs7[profile_id]); // เก็บ log การลบ
				
		}//end while($rskp7 = mysql_fetch_assoc($result_kp7)){

		
}// end function CutOffChecklist($profile_id,$xsiteid){

#############  funciton ในการเก็บ temp ข้อมูล

function SaveTempUploadData($idcard,$staffid,$profile_id,$xsiteid,$num_pic,$num_page,$date_upload){
	global $dbname_temp;
	if($num_page > 0){ // กรณีมีการปรับปรุงข้อมูลเท่านั้นถึง จัดเก็บข้อมูลใน temp
		$sql_replace = "REPLACE INTO temp_upload_excel2checklist SET idcard='$idcard',staffid='$staffid',profile_id='$profile_id',siteid='$xsiteid',num_pic='$num_pic',num_page='$num_page',date_upload='$date_upload',time_update=NOW() ";
		$result = mysql_db_query($dbname_temp,$sql_replace);
	}//end 
}// end function SaveTempUploadData($num_page,$idcard,$staffid,$profile_id,$xsiteid,$num_pic,$num_page,$date_upload){

##############  funtion ตรวจสอบรหัสพนักงานออกพื้นที่ที่ upload ผ่าน excel 
function StringUpdateStaff($num_page,$idcard,$profile_id,$staffid,$date_upload){
	global $dbname_temp;
	if($num_page > 0){
		$sql_check = "SELECT staff_upload_pic FROM tbl_checklist_kp7 WHERE idcard='$idcard'  and profile_id='$profile_id' ";
		$result_check = mysql_db_query($dbname_temp,$sql_check);
		$rsc = mysql_fetch_assoc($result_check);
		if($rsc[staff_upload_pic] == ""){
				$result_txt = " ,staff_upload_pic='$staffid',date_upload_pic='$date_upload'";
		}else{
				$result_txt = "";	
		}
	
	}else{
			$result_txt = "";
			
	}// end if($num_page > 0){
	
	return $result_txt;
		
}//end StringUpdateStaff($num_page,$idcard,$profile_id,$staffid,$date_upload)


function GetNameChecklist($profile_id,$idcard){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' and profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
		
}// end function GetNameChecklist(){
############  function ตรวจสอบการ upload ซ้ำ
function CheckUploadReplace($profile_id,$siteid){
	global $dbname_temp;
	$sql = "SELECT COUNT(idcard) as numid,idcard FROM temp_upload_excel2checklist WHERE flag_process='0' AND profile_id='$profile_id' AND siteid='$siteid' GROUP BY idcard ";
	//echo $sql."<br>";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[idcard]] = GetNameChecklist($profile_id,$rs[idcard]);
	}//end 	while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CheckUploadReplace(){
	
	
function GetIdReplace($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT * FROM temp_upload_excel2checklist WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]]['staffid'][] = show_user($rs[staffid]);
			$arr[$rs[staffid]]['num_pic'][] = $rs[num_pic];
			$arr[$rs[staffid]]['num_page'][] = $rs[num_page];
			
	}//end while($rs = mysql_fetch_assoc($result)){
return $arr;		
}

function GetPrecessUpload($xsiteid,$profile_id,$staffid){
	global $dbname_temp;
	$sql = "SELECT 
	count(idcard) as numall,
	sum(if(staff_upload_pic='$staffid',pic_num,0)) as sumpic,
	sum(if(staff_upload_pic='$staffid',page_num,0)) as sumpage,
	sum(if(staff_upload_pic='$staffid',1,0)) as numupload,
	sum(if(staff_upload_pic='$staffid',pic_num_new_cut,0)) as numpic_add,
	sum(if(staff_upload_pic='$staffid',page_num_new,0)) as numpage_add,
	sum(if(staff_upload_pic='$staffid' and status_check_file='YES' and status_numfile='0' and status_file='0',1,0)) as numno_recive,
sum(if(page_num>0,1,0)) as numuploadall
  FROM `tbl_checklist_kp7` where siteid='$xsiteid' and profile_id='$profile_id'";
  $result = mysql_db_query($dbname_temp,$sql);
  $rs = mysql_fetch_assoc($result);
  $arr['numall'] = $rs[numall];
  $arr['pic'] = $rs[sumpic];
  $arr['page'] = $rs[sumpage];
  $arr['upload'] = $rs[numupload];
  $arr['uploadall'] = $rs[numuploadall];
  $arr['uploaddiff'] = $rs[numall]-$rs[numuploadall];
  $arr['pic_add'] = $rs[numpic_add];
  $arr['page_add'] = $rs[numpage_add];
  $arr['norecive'] = $rs[numno_recive];
	
	return 	$arr;
}//end function GetPrecessUpload(){
	
	
function CheckIdcardReplace($old_idcard,$idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT *  FROM tbl_checklist_kp7 WHERE idcard='$idcard'  AND profile_id='$profile_id' ";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
			$sql_up2 = "REPLACE INTO temp_change_idcard SET old_idcard='$old_idcard',new_idcard='$idcard',siteid='$rs[siteid]' ,fullname='$rs[prename_th]$rs[name_th] $rs[surname_th]',status_process='2',profile_id='$profile_id' ";
			mysql_db_query($dbname_temp,$sql_up2);
			$num1 = 1;
			$replacename = "$rs[prename_th]$rs[name_th]  $rs[surname_th]  ตำแหน่ง $rs[position_now]  สังกัด ".show_area($rs[siteid])."/".show_school($rs[schoolid]);
	}else{
			$num1 = 0;
			$replacename = "$rs[prename_th]$rs[name_th]  $rs[surname_th]  ตำแหน่ง $rs[position_now]  สังกัด ".show_area($rs[siteid])."/".show_school($rs[schoolid]);
	}
	$arr[0] = $num1;
	$arr[1] = $replacename;
return $arr;
//echo "";die;
}//end function CheckIdcardReplace($idcard,$profileid=""){
	
######  function ตรวจสอบการ update จำนวนแผ่นและจำนวนหน้า
function CheckUpdatePicPagenum($idcard,$profile_id,$staffupdate,$page_num,$pic_num,$mainpage,$page_num_new,$pic_num_new_cut){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	#echo $sql."<br>";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
			#### ทำการเก็บ log ข้อมูลไว้ในการณีที่ จำนวจแผ่น จำนวนรูปไม่ตรงกันรวมทั้ง รหัสพนักงานคีย์ไม่ตรงกัน
			
			#echo "$rs[page_num]  ||  $page_num :: $rs[pic_num] ||  $pic_num :: $staffupdate || $rs[staff_upload_pic]<hr>";
			if(($rs[page_num] > 0 and $rs[page_num] != $page_num) or ($rs[pic_num] > 0 and $rs[pic_num] != $pic_num) or($rs[staff_upload_pic] != "" and $staffupdate != $rs[staff_upload_pic]) or (($page_num_new > 0) or ($pic_num_new_cut > 0))){
			 # echo "Y<br>";
			  ## Modify by Sun
			  if($page_num_new > 0 and $pic_num_new_cut > 0){
			    $conf_update = " ,page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage',page_num_new='$page_num_new',pic_num_new_cut='$pic_num_new_cut' ";
			  }elseif($page_num_new > 0 and $pic_num_new_cut == 0){
			    $conf_update = " ,page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage',page_num_new='$page_num_new' ";
			  }elseif($page_num_new == 0 and $pic_num_new_cut > 0){
			    $conf_update = " ,page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage',pic_num_new_cut='$pic_num_new_cut' ";
			  }else{
					SaveTempUploadData($idcard,$staffupdate,$profile_id,$rs[siteid],$pic_num,$page_num,date("Y-m-d H:i:s"));
					$conf_update = "";
			  }
			  ## End Modify By Sun
		
			}else{
					#echo "N<br>";
					$conf_update = " ,page_num='$page_num',pic_num='$pic_num',mainpage='$mainpage' ";	
			}// end if(($rs[page_num] > 0 and $rs[page_num] != $page_num) or ($rs[pic_num] > 0 and $rs[pic_num] != $pic_num) or($rs[staff_upload_pic] != "" and $staffupdate != $rs[staff_upload_pic])){
return $conf_update;
}// end function CheckUpdatePicPagenum($idcard,$profile_id,$staffupdate,$num_page,$num_pic){
	
###### function  เก็บ log การนำเข้าข้อมูลผิด
function SaveErrorDataFromExcel($idcard,$profile_id,$siteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,$type_error,$value_error){
	global $dbname_temp;
	$sql_save = "INSERT INTO tbl_checklist_imp_excel_error SET idcard='$idcard',profile_id='$profile_id',siteid='$siteid',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',schoolid='$schoolid',position_now='$position_now',type_error='$type_error',value_error='$value_error',staff_upload='".$_SESSION['session_staffid']."',timeupdate=NOW()";
	mysql_db_query($dbname_temp,$sql_save);
		
}//end function SaveErrorDataFromExcel($idcard,$profile_id,$siteid,$prename_th,$name_th,$surname_th,$schoolid,$position_now,$type_error,$value_error){

##### ล้างค่า log การ upload การนำเข้าข้อมูลผิด
function CleanLogError($idcard,$siteid,$profile_id,$type_error){
	global $dbname_temp;
	$sql_del = "DELETE FROM tbl_checklist_imp_excel_error WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$siteid' AND type_error='$type_error'";
	mysql_db_query($dbname_temp,$sql_del);
		
}// end function CleanLogError($idcard,$siteid,$profile_id){
	
######  ตรวจสอบรหัสโรงเรียนที่ไม่สัมพันกับเขตพื้นที่การศึกษา
function CheckSchoolFormChecklist($siteid,$schoolid){
	global $dbnamemaster;
	$sql = "SELECT COUNT(id) as num1 FROM allschool WHERE id='$schoolid' AND siteid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];	
}//end function CheckSchoolFormChecklist(){
	



?>