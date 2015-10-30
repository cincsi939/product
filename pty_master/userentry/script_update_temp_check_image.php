<?php
	###################################################################
	## REPORT: CHECK DATA PROFILE
	###################################################################
	## Version :			20110111.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2011-01-11 11:30
	## Created By :		Mr.KIDSANA PANYA(JENG)
	## E-mail :				kidsana@sapphire.co.th
	## Tel. :				-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	set_time_limit(0);
	include("../../config/conndb_nonsession.inc.php");
	include ("../../common/common_competency.inc.php");

#Begin ON/OFF AND Time Insert Temp crontab
	$insert_temp = "on";
	$insert_temp_time = 3;//ตีสาม
#End Insert Temp crontab
	
#Begin Function 
	#Function สร้าง SQL สำหรับแสดงเขตพื้นที่และโรงเรียน
	#$get_view คือ edu, school
	function gen_sql(){
		global $user_site;
		$sql = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM  ".DB_MASTER.".`eduarea_config` AS `eduarea_config` 
						Inner Join  sapphire_app.employee_work_site ON sapphire_app.employee_work_site.siteid =  ".DB_MASTER.".eduarea_config.site    ";
		$sql .= "WHERE eduarea_config.site IS NOT NULL AND eduarea_config.sitename IS NOT NULL AND eduarea_config.site NOT LIKE('99%') ";
		$sql .= "ORDER BY eduarea_config.orde_by ASC";
		return $sql;
	}
	
	#Function ตรวจสสอบข้อมูลจำนวนรูปและประเภทรูปว่าเป็นรูปขาวดำหรือสี
	#Note. Function CheckimageGrayscale() จากไฟล์ ../../common/common_competency.inc.php
	function checkDataImage($siteid=""){
			$dbsite = STR_PREFIX_DB.$siteid;
			$part_forder = "../../../image_file/".$siteid."/";
			$sum_general = 0;
			if($siteid!="" ){
				$sql_general = "SELECT id, siteid FROM {$dbsite}.`general` AS `general`   WHERE  siteid='".$siteid."'  ";
				$query_general = mysql_query($sql_general);
				while($row_general = mysql_fetch_assoc($query_general)){
					$sum_general++;
					$sql = "SELECT general_pic.id, general_pic.imgname FROM {$dbsite}.general_pic AS general_pic WHERE general_pic.id='".$row_general['id']."'  ";
					$query = mysql_query($sql);
					$num_rows = mysql_num_rows($query);
					while($row = mysql_fetch_assoc($query)){
						if(is_file($part_forder.$row['imgname'])){
							if(CheckimageGrayscale($part_forder.$row['imgname']) == 1){
								$general_person['no_color'][$row['id']] += 1; 	
							}else{
								$general_person['color'][$row['id']] += 1;
							}
						}
					}
					$sum_all[$row_general['id']] = count($general_person['no_color'][$row_general['id']]).":".count($general_person['color'][$row_general['id']]).":".$num_rows;
					$arr_num_type = explode(":",$sum_all[$row_general['id']]);
					if($arr_num_type[0]>=1){
						$arr_ckeck_image['no_color'][] = $row_general['id'];
					}else if($arr_num_type[0]==0 && $arr_num_type[1]>0&& $arr_num_type[2] > 0){
						$arr_ckeck_image['color'][] = $row_general['id'];
					}else if($arr_num_type[2]==0){
						$arr_ckeck_image['no_image'][] = $row_general['id'];
					}
				}
				$data = array("sum_general"=>$sum_general, "sum_no_image"=>count($arr_ckeck_image['no_image']),
										"sum_image_color"=>count($arr_ckeck_image['color']), "sum_image_no_color"=>count($arr_ckeck_image['no_color'])
									); 
			}else{
				$data = array("sum_general"=>0, "sum_no_image"=>0,"sum_image_color"=>0,"sum_image_no_color"=>0); 
			}
			unset($sum_all);
			unset($arr_ckeck_image);
			return $data;
	}
	
	#Function บันทึกข้อมูล Temp การตรวจสอบรูป
	function update_temp_check_image($siteid="", $general="", $no_image="", $no_color_image="", $color_image=""){
		global $dbname,$user_site;
		if($user_site != DB_MASTER){
			$sql = "REPLACE INTO temp_check_image 
						SET siteid='".$siteid."', general='".$general."', no_image='".$no_image."', no_color_image='".$no_color_image."', 
						color_image='".$color_image."', update_date=NOW() ";
			mysql_db_query($dbname, $sql);
		}
	}
#End Function

#Begin Process 
	if($insert_temp=="on"){
		if($insert_temp_time == intval(date("H"))){
			$sql =  gen_sql(); 
			 $query = mysql_db_query($dbname, $sql);
			 while($row = mysql_fetch_assoc($query)){
				 #set var sum
				$data_image = checkDataImage($row['siteid']);
				update_temp_check_image($row['siteid'], $data_image['sum_general'], $data_image['sum_no_image'], $data_image['sum_image_no_color'], $data_image['sum_image_color']);
			 }
			 echo "การ Crontab รันเสร็จสิ้น";
		 }else{
		 	echo "ยังไม่กำหนดเวลาในการรัน Crontab (ตั้งเวลารันไว้เวลา ".number_format($insert_temp_time,2)." น.)";
		 }
	 }else{
	 	echo "ปิดการรัน Crontab";
	 }
#End Process
	