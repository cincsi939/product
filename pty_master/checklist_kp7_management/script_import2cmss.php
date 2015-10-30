<?
session_start();
set_time_limit(0);
include("checklist.inc.php");
include("function_tranfer.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}
//echo "script by suwat";die;

####  ประมวลผลรายการ
### ทดสอบ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ทดสอบ
	//echo "action  :: $action<br> Ac :: $Aaction :: $xsiteid ";die;
	if($Aaction == "process"){
	//	echo "script by suwat";die;
	//require_once("../../common/preloading.php");
		$dbsite = "cmss_".$xsiteid;
		AlterField($dbsite,"general_pic","img_owner");// ตรวจสอบเพื่อที่จะทำการปรับโครงสร้างตาราง general_pic
		$dateposition_now = SwDateT($dateposition_now);
		//echo "สิ้นสุดการนำข้อมูลเข้า";die;
### ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss#########################################################
$sql = "SELECT * FROM tbl_check_data WHERE secid='$xsiteid' AND status_tranfer_data='0' AND idcard_structure='1' AND schoolid IS NOT NULL AND schoolid <> '0' ";
//echo $sql."<br>";die;

$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
		## ตรวจสอบ ฟิลด์ที่จะนำเข้าข้อมูล
		## คำนำหน้าชื่อ
		if(CheckField($rs[secid],"prename_th") > 0){
			$arrp1 = GetPrenameId($rs[prename_th]);
			$update_prename = ", prename_th='$rs[prename_th]' ";
			$update_prename_id = ", prename_id='$arrp1[PN_CODE]' ";
			$update_sex = ", sex='$arrp1[sex]'";
			$update_gender_id = ", gender_id='$arrp1[gender]'";
		}else{
			$update_prename = "";
			$update_prename_id = "";
			$update_sex = "";
			$update_gender_id = "";	
		}// end if(CheckField($rs[secid],"prename_th") > 0){
		## ชือ
		if(CheckField($rs[secid],"name_th") > 0){
			$update_name = ", name_th='$rs[name_th]'";	
		}else{
			$update_name = "";
		}//end if(CheckField($rs[secid],"name_th") > 0){
		## นามสกุล
		if(CheckField($rs[secid],"surname_th") > 0){
			$update_surname = ", surname_th='$rs[surname_th]'";
		}else{
			$update_surname = "";	
		}//end if(CheckField($rs[secid],"surname_th") > 0){
		###  วันเดือนปีเกิด
		if(CheckField($rs[secid],"birthday") > 0){
			$update_birthday = ", birthday='$rs[birthday]'";
		}else{
			$update_birthday = "";
		}
		## วันเริ่มปฏิบัตราชการ
		if(CheckField($rs[secid],"begindate") > 0){
			$update_begindate = ", begindate='$rs[begindate]'";
		}else{
			$update_begindate = "";
		}//end if(CheckField($rs[secid],"begindate") > 0){
		## ตำแหน่งปัจจุบัน 
		if(CheckField($rs[secid],"position_now") > 0){
			$arrp2 = GetPositionId($rs[position_now]);
			$update_position = ", position_now='$rs[position_now]'";
			$update_pid = ", pid='$arrp2[pid]'";
			$update_positiongroup = ", positiongroup='$arrp2[Gpid]'";
		}else{
			$update_position = "";
			$update_pid = "";
			$update_positiongroup = "";
		}
		## หน่วยงาน
		if(CheckField($rs[secid],"schoolid") > 0){
			$update_schoolid = ", schoolid='$rs[schoolid]'";
		}else{
			$update_schoolid = "";
		}
		### 
		## end ตรวจสอบ ฟิลด์การนำเข้า 
#############################  กรณีนำเข้าได้ปกติ ##################################
		if($rs[status_id_replace] == "0"){ // คือข้อมูลปกติสามารถนำเข้าไปได้เลย
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // กรณีมีอยู่แล้ว update
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					//echo "update";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',siteid='$rs[secid]', vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
					//echo "insert";
				}
			//echo "<br>sql = ".$sql_imp2cmss."<br>";die;
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
			###  ทำการคัดลอกไฟล์รูปสู่ฐานข้อมูล cmss
			 ImportPicToCmss($rs[secid],$rs[idcard]); // ทำการคัดลอกไฟล์สู่ฐานข้อมูล  cmss
			## end ทำการคัดลอกรูปสู่ฐานข้อมูล cmss
			## ทำการคัดลอกไฟล์ kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // กรณีมีไฟล์เท่านั้น
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
				//echo $sql_update_tranfer."<br>";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end  //if($result_imp2cmss){
			### ล้างข้อมูลใหม่ก่อนคีย์
			if($rs[status_data_old] != "1"){ // ล้างข้อมูลกรณีไม่ใช่โครงการปีที่แล้ว
				DeleteDataNew($rs[secid],$rs[idcard]);
			}
#############################  กรณีไปซ้ำกับเขตอื่น ##################################		
		}else{ // กรณีข้อมูลไปซ้ำกับเขตอื่น
		//echo "ย้ายข้อมูล";die;
		
			$dbsource = "cmss_".$rs[siteid_replace]; // ฐานข้อมูลเขตต้นทาง
			$dbdest = "cmss_".$rs[secid];
				if($rs[status_data_old] == "1"){ // กรณีเป็นข้อมูลเก่าจากปีที่แล้ว
						#### เข้ากระบวนการย้ายข้อมูล
							
							// ข้อมูลในเขตต้นทางที่เป็นของเขตเก่าไม่มีในเขตอาจเป็นเพาะถูกตัดเข้าไปอยู่ใน temp_general ใน master ต้องดึงกลับมาก่อนทำการย้าย
							if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							$xdb_site = "cmss_".$rs[siteid_replace];
							//echo "ขอมูลเก่า";die;
									trn_temp_general2cmss("temp_general",$ipsource,$dbnamemaster,$rs[idcard],"id",$xdb_site);
									//echo "AAA <br>";
							}//end if(CheckDataListOld($rs[siteid_replace],$rs[idcard]) < 1){ 
							//echo "ข้อมูลใหม่";die;
							
							//echo $dbsource."::".$dbdest."  $rs[siteid_replace] :: $rs[idcard] ";die;
							
									foreach($arr_tbl1 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"id");
									}
									foreach($arr_tbl2 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"gen_id");		
									}
									foreach($arr_tbl5 as  $tbl){	
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"idcard");	
									}
									
								#######  ทำการ trigger ข้อมูลการศึกษาที่เป็นระดับสูงสุด
									// trigger_euation($rs[secid],$rs[idcard]);
								####### end  ทำการ trigger ข้อมูลการศึกษาที่เป็นระดับสูงสุด
								
									//CHECK_DATA  พร้อมลบข้อมูลเขตต้นทาง
									 foreach($arr_tbl1 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"id");
									}
									foreach($arr_tbl2 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"gen_id");		
									}
									foreach($arr_tbl5 as  $tbl){	
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$rs[idcard],"idcard");	
									}	

						#### end เข้ากระบวนการย้ายข้อมูล
					###  update ข้อมูล ใน general 
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
					$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
			## ทำการคัดลอกไฟล์ kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // กรณีมีไฟล์เท่านั้น
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
				$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
				mysql_db_query($dbname_temp,$sql_update_tranfer);
				}//end  if($result_imp2cmss){
					
				}else{ ###  กรณีไม่ได้อยู่ในเขตเก่าตามสัญญาปีที่แล้ว
					####  ลบข้อมูลเขตต้นทางที่ไม่ได้อยู่ใน 46 เขต
					//echo "$rs[siteid_replace] ::: $rs[idcard]";die;
					//DeleteDataNotIn($rs[siteid_replace],$rs[idcard]);
					###  
				if(CheckDataInDb($rs[secid],$rs[idcard]) > 0){ // กรณีมีอยู่แล้ว update
					$sql_imp2cmss = "UPDATE general SET vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid  WHERE id='$rs[idcard]' ";
				}else{// กรณียังไม่มีเพิ่ม
					$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',siteid='$rs[secid]',   vitaya_id='0',dateposition_now='$dateposition_now' $update_prename $update_prename_id $update_sex $update_gender_id $update_name $update_surname $update_birthday $update_begindate $update_position $update_pid  $update_positiongroup $update_schoolid ";	
				}
			$result_imp2cmss = mysql_db_query($dbsite,$sql_imp2cmss);
			## ทำการคัดลอกไฟล์ kp7
			$pathkp7file = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$pathkp7source = "../../../checklist_kp7file/$rs[secid]/";
			$pathkp7dest = "../../../".PATH_KP7_FILE."/$rs[secid]/";
			if(is_file($pathkp7file)){ // กรณีมีไฟล์เท่านั้น
				$status_copy_file = CopyKp7File($rs[idcard],$pathkp7source,$pathkp7dest);	
			}else{
				$status_copy_file = "0";	
			}//end if(is_file($pathkp7file)){
			if($result_imp2cmss){
			$sql_update_tranfer = "UPDATE tbl_check_data SET status_tranfer_filekp7='$status_copy_file', status_tranfer_data='1' WHERE idcard='$rs[idcard]'";
			mysql_db_query($dbname_temp,$sql_update_tranfer);
			}//end if($result_imp2cmss){
					
#####################################################################################################					
				}// end if($rs[status_data_old] == "1"){ 
		}//end if($rs[status_id_replace] == "0"){
}//endwhile($rs = mysql_fetch_assoc($result)){ 
###  end ทำการนำข้อมูลจาก edubkk_checklist เข้าสู่ฐาน Cmss
###  ทำการเทียบข้อมูลใน ตาราง checkl_data กับฐานข้อมูล cmss ถ้าข้อมูลส่วนเกินให้ย้ายและเก็บไปไว้ใน temp_general ก่อนเนื่องจากเป็นข้อมูลที่เคยคีย์อยู่แล้้ว
//		$sql1 = "SELECT $dbsite.general.id FROM $dbsite.general Left Join $dbname_temp.tbl_check_data ON $dbsite.general.id = $dbname_temp.tbl_check_data.idcard WHERE $dbname_temp.tbl_check_data.idcard IS NULL ";
//		$result1 = mysql_db_query($dbsite,$sql1);
//		$numrow1 = @mysql_num_rows($result1);
//		if($numrow1 > 0){
//			while($rs1 = mysql_fetch_assoc($result1)){
//				### จัดเก็บข้อมูลในรายการที่อยู่นอกเหนือจากเขตไปเก็บไว้ใน temp_general
//				//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
//				trn_temp_general("general",$ipsource,$dbsite,$rs1[id],"id");
//			}
//		}//end if($numrow1 > 0){
### end ทำการเทียบข้อมูลใน ตาราง checkl_data กับฐานข้อมูล cmss ถ้าข้อมูลส่วนเกินให้ย้ายและเก็บไปไว้ใน temp_general ก่อนเนื่องจากเป็นข้อมูลที่เคยคีย์อยู่แล้้ว
	//echo "AAAA";die;
		###  ทำการ update ข้อมูลเพื่อในข้อมูลใน general , view_general กับ view_general ใน master ตรงกัน
	//	$sql_update_general = "UPDATE general SET siteid='$xsiteid'";
		//$result_update_general = mysql_db_query($dbsite,$sql_update_general);
		
		
/*		echo "<script>alert('นำเข้าข้อมูลเรียบร้อยแล้ว');location.href='import2cmss.php?action=$action&xsiteid=$xsiteid&secname=$secname&flag_crontab=1';</script>";
		exit;*/
//?action=&xsiteid=6502&secname=สำนักงานเขตพื้นที่การศึกษาพิษณุโลก เขต 2

		$sql_update_general = "UPDATE general SET siteid='$xsiteid'";
		$result_update_general = mysql_db_query($dbsite,$sql_update_general);
		
	}// end if($Aaction == "process"){
###  end ประมวลผลรายการ
?>