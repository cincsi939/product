<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();

			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
$arr_log = array("salary_log_"=>"ข้อมูลเงินเดือน","general_log_"=>"ข้อมูลข้าราชการ","general_pic_log_"=>"ข้อมูลภาพประวัติบุคลากร","getroyal_log_"=>"ข้อมูลเครื่องราชอิสรยาภรณ์","goodman_log_"=>"ข้อมูลความดีความชอบ","graduate_log_"=>"ข้อมูลการศึกษา","hr_absent_log_"=>"ข้อมูลจำนวนวันลาหยุด","hr_addhistoryaddress_log_"=>"ข้อมูลประวัติการเปลี่ยนแปลงที่อยู่","hr_addhistoryfathername_log_"=>"ข้อมูลประวัติการเปลี่ยนชื่อบิดา","hr_addhistorymarry_log_"=>"ข้อมูลประวัติการเปลี่ยนชื่อภรรยา","hr_addhistorymothername_log_"=>"ข้อมูลประวัติการเปลี่ยนชื่อมารดา","hr_addhistoryname_log_"=>"ข้อมูลประวัติการเปลี่ยนชื่อบุคคล","hr_nosalary_log_"=>"ข้อมูลวันที่ไม่ได้รับเงินเดือน","hr_other_log_"=>"ข้อมูลรายการอื่นๆ","hr_prohibit_log_"=>"ข้อมูลการได้รับโทษทางวินัย","hr_specialduty_log_"=>"ข้อมูลการปฏิบัติราชการพิเศษ","seminar_log_"=>"ข้อมูลการประชุม ดูงาน สัมนา","special_log_"=>"ข้อมูลความสามารถพิเศษ");

function getfieldsource_all($tblname,$db_site){
	
	$sql = " SHOW FIELDS FROM  $tblname ";
	$result = mysql_db_query($db_site,$sql);
	while($rs = mysql_fetch_assoc($result) ){
			if(trim(strip_tags($rsfield)) > ""){ $rsfield .= ",";}
			$rsfield .= "`$rs[Field]`" ; 
	}
	return $rsfield;
}//end function getfieldsource_all($tblname,$db_site){
	
	
function CreateTblTemp($tblname,$sub_table,$db_site){
	$sqlx = " SELECT * FROM  ".$tblname."$sub_table  limit 1";
	$resultx = @mysql_db_query($db_site,$sqlx);
	if(!$resultx){
	$sql_cre = " CREATE  TABLE IF NOT EXISTS ".$tblname."$sub_table  SELECT  *  FROM  $tblname  limit 1 " ;		
	$sql_emtry = " TRUNCATE  ".$tblname."$sub_table ";	
	$sql_alter = " ALTER TABLE `".$tblname."$sub_table` ADD `auto_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
ADD `staffid` VARCHAR( 16 ) NOT NULL AFTER `auto_id` ;  ";
	@mysql_db_query($db_site,$sql_cre);	
	@mysql_db_query($db_site,$sql_emtry);
	@mysql_db_query($db_site,$sql_alter);
	}
	
}//end function CreateTblTemp(){


function TrunCateTable($tblname,$db_site){
	$sql_emtry = " TRUNCATE  ".$tblname."";	
	@mysql_db_query($db_site,$sql_emtry);
}//end function TrunCateTable($tblname,$sub_table,$db_site){
	
########  ล้างข้อมูลในตาราง

/*if($action == "CleanData"){
				$sql = "SELECT * FROM temp_moniter_keyin  WHERE flag_id='0'";
				$result = mysql_db_query($dbnameuse,$sql);
				$k=0;
				while($rs = mysql_fetch_assoc($result)){
					$db_site = STR_PREFIX_DB.$rs[siteid];
					//echo "$db_site :: $rs[idcard]<br>";
				################################## บันทึกข้อมูลเงินเดือน
						foreach($arr_log as $key => $val){
							$tbl_before_temp = $key."before_temp_incen";
							$tbl_after_temp = $key."after_temp_incen";
							TrunCateTable($tbl_before_temp,$db_site);
							TrunCateTable($tbl_after_temp,$db_site);

						}
				}
}// end if($action == "CleanData"){
*/
#####  ล้างข้อมูล	
	
	
	
	############################  เริ่มประมวลผล		
			if($action == "process"){
				/*$sql = "SELECT monitor_keyin.staffid, monitor_keyin.idcard, monitor_keyin.siteid FROM `monitor_keyin`
where date(timeupdate) ='2010-11-08' or date(timeupdate) ='2010-11-09' order by monitor_keyin.siteid asc";*/
				$sql = "SELECT * FROM temp_moniter_keyin  WHERE flag_id='0'";
				$result = mysql_db_query($dbnameuse,$sql);
				$k=0;
				while($rs = mysql_fetch_assoc($result)){
					$db_site = STR_PREFIX_DB.$rs[siteid];
					//echo "$db_site :: $rs[idcard]<br>";
				################################## บันทึกข้อมูลเงินเดือน
				foreach($arr_log as $key => $val){
					//CreateTblTemp($tblname,"_log_before_temp_incen",$db_site);
					//CreateTblTemp($tblname,"_log_after_temp_incen",$db_site);
					$tbl_before = $key."before";
					$tbl_after = $key."after";
					//$tbl_before_temp = $key."before_temp_incen";
					//$tbl_after_temp = $key."after_temp_incen";
					$tbl_before_temp = $key."before";
					$tbl_after_temp = $key."after";
					$spos = strpos($tbl_before,"hr_addhistory");
					if($spos === false){
						$keyid = "id";	
					}else{
						$keyid = "gen_id";	
					}//end if($spos === false){
					#### ตารางข้อมูลจริง 
					$tblname = substr($key,0,-5);
					//echo "$tblname";die;
					$sql_Field = "SHOW COLUMNS FROM $tblname WHERE TYPE  LIKE '%timestamp%' or TYPE LIKE '%datetime%'";
					$result_Field = mysql_db_query($db_site,$sql_Field);
					$rsF = mysql_fetch_assoc($result_Field);
					$Field_Time = $rsF[Field]; // ฟิลด์ เก็บเวลาบันทึกข้อมูลในแต่ละตาราง 
					
					$sql_table_key = "SHOW COLUMNS FROM $tblname WHERE `Key`='PRI'";
					$result_table_key = mysql_db_query($db_site,$sql_table_key);
					$i=0;
					while($rstk = mysql_fetch_assoc($result_table_key)){
						$key_arr[$i] .= "$rstk[Field]";
						$i++;
					}//end while($rstk = mysql_fetch_assoc($result_table_key)){
					
					$sql_table = "SELECT * FROM $tblname WHERE $keyid='$rs[idcard]'";
					//echo $sql_table." :: $val :: <br>";
					$reuslt_table = mysql_db_query($db_site,$sql_table);
					while($rstbl = mysql_fetch_assoc($reuslt_table)){ // AND (action='insert' or action='add' or action='edit')
							$sql_checklog = "SELECT COUNT(username) AS num1  FROM log_update WHERE subject='$val' AND username='$rs[idcard]' AND  staff_login='$rs[staffid]'   and $Field_Time  BETWEEN '".$rstbl[$Field_Time]."' - INTERVAL 3 SECOND AND '".$rstbl[$Field_Time]."' + INTERVAL 3 SECOND";
							//echo " <br>$val  ||||  ".$sql_checklog."<br><br>";
							$result_checklog = mysql_db_query($db_site,$sql_checklog);
							$rsL = mysql_fetch_assoc($result_checklog);
							if($rsL[num1] > 0){
								######### หาคืย์หลักของแต่ละตาราง
								$conkey = "";
								if(count($key_arr) > 0){
										foreach($key_arr as $key1 => $val1){
												$conkey .= " AND $val1='$rstbl[$val1]' ";
										}//end foreach($key_arr as $key => $val){
								}// end 	if(count($key_arr) > 0){
								############ end หาคีย์หลักของแต่ละตา
								
								$sql_logAf = "SELECT COUNT($keyid) AS numid,auto_id FROM  $tbl_after WHERE $keyid='$rs[idcard]'  $conkey  GROUP BY $keyid";
							//	echo $sql_logAf."<br><hr>";
								$result_logAf = mysql_db_query($db_site,$sql_logAf);
								$rsAf = mysql_fetch_assoc($result_logAf);
									if($rsAf[numid] < 1){
										$k++;
										
									//CreateTblTemp($tblname,"_log_before_temp_incen",$db_site);
									//CreateTblTemp($tblname,"_log_after_temp_incen",$db_site);
										
										$field_result = getfieldsource_all($tblname,$db_site);
										
										$sql_beforB1 = "INSERT INTO $tbl_before_temp(staffid,$Field_Time)VALUES($rs[staffid],'".$rstbl[$Field_Time]."')";
										//echo $sql_beforB1."<br>";
										$result_beforB1 = mysql_db_query($db_site,$sql_beforB1);
										$last_id = mysql_insert_id(); // หา id ล่าสุดที่เพิ่มเข้าไป
										
										$sql_insertAf1 = "INSERT INTO $tbl_after_temp($field_result,staffid,auto_id)
						SELECT $field_result,'".$rs[staffid]."','$last_id'
						FROM $tblname  WHERE $keyid='$rs[idcard]' $conkey ";
										//echo $sql_insertAf1."<br><hr>";
										mysql_db_query($db_site,$sql_insertAf1);
											
									}else{##########  กรณีมีใน มีใน log after แล้ว
										$sql_checkBf1  = "SELECT COUNT($keyid) AS numid FROM  $tbl_before  WHERE auto_id='$rsAf[auto_id]'";
										$result_checkBf1 = mysql_db_query($db_site,$sql_checkBf1);
										$rsBf1 = mysql_fetch_assoc($result_checkBf1);
										if($rsBf1[numid] < 1){
											$k++;
												//CreateTblTemp($tblname,"_log_before_temp_incen",$db_site);
												//CreateTblTemp($tblname,"_log_after_temp_incen",$db_site);
										
										$field_result = getfieldsource_all($tblname,$db_site);
										
										$sql_beforB1 = "INSERT INTO $tbl_before_temp(staffid,$Field_Time)VALUES($rs[staffid],'".$rstbl[$Field_Time]."')";
										//echo $sql_beforB1."<br>";
										$result_beforB1 = mysql_db_query($db_site,$sql_beforB1);
										$last_id = mysql_insert_id(); // หา id ล่าสุดที่เพิ่มเข้าไป
										
										$sql_insertAf1 = "INSERT INTO $tbl_after_temp($field_result,staffid,auto_id)
						SELECT $field_result,'".$rs[staffid]."','$last_id'
						FROM $tblname  WHERE $keyid='$rs[idcard]' $conkey ";
										//echo $sql_insertAf1."<br><hr>";
										mysql_db_query($db_site,$sql_insertAf1);

												
										}//end if($rsBf1[numid] < 1){
										
											
									}//end if($rsAf[numid] < 1){
									
							}//end if($rsL[num1] > 0){
							
					}//end while($rstbl = mysql_fetch_assoc($reuslt_table)){
					
					$conkey = "";
					unset($key_arr);
					
				
				}//end foreach($arr_log as $key => $val){
					
					$sql_upflag = "UPDATE temp_moniter_keyin SET  flag_id='1' WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]'";
					mysql_db_query($dbnameuse,$sql_upflag);
						
				}//end while($rs = mysql_fetch_assoc($result)){
					
					echo "<h3>จำนวนการเก็บข้อมูลทั้งหมดมี  $k  รายการ</h3>";
					
			}//end if($action == "process"){
			
	#############################  end การประมวลผลข้อมูล		
	echo "<br><a href='?action=process'>ประมวลผลข้อมูล</a> ";
	//echo "|| <a href='?action=CleanData'>ล้างข้อมูล</a>";

 ?>