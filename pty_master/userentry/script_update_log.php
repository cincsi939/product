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

//die;
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$date_start = "2010-07-14";
			$date_end = "2010-07-14";
			$db_site = STR_PREFIX_DB.$xsiteid;	
			$siteid = $xsiteid;
			//$date_req ="2010-04-03";
			
			//$con_staff = " ORDER BY updatetime ASC  LIMIT 0,20 ";
			### ส่วนของเมนูเงินเดือน AND staff_login IN('10679','10493','10768')
			$sql = "SELECT * FROM `log_update` where (date(log_update.updatetime) BETWEEN  '$date_start' AND '$date_end') and (action='insert' or action='add') AND log_update.subject LIKE  '%ข้อมูลเงินเดือน%' ";
			
			//echo "$db_site :: ".$sql."<br>";die;
			$result = mysql_db_query($db_site,$sql);
			$xi = 0;
			while($rs = mysql_fetch_assoc($result)){
				
				$sql1 = "SELECT * FROM salary where id='$rs[target_idcard]' and updatetime BETWEEN '$rs[updatetime]' - INTERVAL 3 SECOND AND '$rs[updatetime]' + INTERVAL 3 SECOND ";
				//echo "$rs[updatetime] :: $sql1<br>";
				$result1 = mysql_db_query($db_site,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				$numr1 = @mysql_num_rows($result1);
				if($numr1 == 1){ // กรณีที่ เงือนไขนี้มีแค่ บรรทัดเดียวคือสามารถใช้ข้อมูลได้เลย
				$xi++;
				$sqlc = "SELECT COUNT(salary_log_after.auto_id) AS NUMC FROM salary_log_after Inner Join salary_log_before ON salary_log_after.auto_id = salary_log_before.auto_id WHERE salary_log_after.runid = '$rs1[runid]' ";
				$resultc = mysql_db_query($db_site,$sqlc);
				$rsc = mysql_fetch_assoc($resultc);
					if($rsc[NUMC] < 1){ // แสดงว่ายังไม่ได้เก็บข้อมูลให้เพิ่มข้อมูลเข้าไปใน log
					
						$sql_befor = "INSERT INTO salary_log_before(staffid,updatetime)VALUES($rs[staff_login],'$rs1[updatetime]')";
						$result_befor = mysql_db_query($db_site,$sql_befor);
						$last_id = mysql_insert_id(); // หา id ล่าสุดที่เพิ่มเข้าไป
						$sql_insert = "INSERT INTO salary_log_after(staffid,id,runno,runid,date,position,noposition,salary,upgrade,note,radub,noorder,ch_position,ch_radub,ch_salary,pls,dateorder,pos_name,pos_group,label_date,label_noposition,label_salary,label_dateorder,label_radub,instruct,begindate_status,updatetime,system_type,status_startwork,lv,order_type,schoolid,school_label,pos_onduty,pos_onduty_label,position_id,level_id,auto_id)
						SELECT $rs[staff_login],salary.id,salary.runno,salary.runid,salary.date,salary.position,salary.noposition,salary.salary,salary.upgrade,salary.note,salary.radub,salary.noorder,salary.ch_position,salary.ch_radub,salary.ch_salary,salary.pls,salary.dateorder,salary.pos_name,salary.pos_group,salary.label_date,salary.label_noposition,salary.label_salary,salary.label_dateorder,salary.label_radub,salary.instruct,salary.begindate_status,salary.updatetime,salary.system_type,salary.status_startwork,salary.lv,salary.order_type,salary.schoolid,salary.school_label,salary.pos_onduty,salary.pos_onduty_label,salary.position_id,salary.level_id,$last_id 
						FROM salary  WHERE salary.runid='$rs1[runid]'";
						//echo "1 ::".$sql_insert."<br>";
						mysql_db_query($db_site,$sql_insert);
					}//end if($rsc[NUMC] < 1){
				}else{
					
				#####################################  กรณีมีมากว่า 1 บรรทัดให้ลดช่วงเวลาลง
				$sql1 = "SELECT * FROM salary where id='$rs[target_idcard]' and updatetime BETWEEN '$rs[updatetime]' - INTERVAL 2 SECOND AND '$rs[updatetime]' + INTERVAL 2 SECOND ";
				//echo " x2:: $sql1<br>";
				$result1 = mysql_db_query($db_site,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				$numr1 = @mysql_num_rows($result1);
					if($num1 == 1){ ///   เงื่อนไขที่ 2
					$sqlc = "SELECT COUNT(salary_log_after.auto_id) AS NUMC FROM salary_log_after Inner Join salary_log_before ON salary_log_after.auto_id = salary_log_before.auto_id WHERE salary_log_after.runid = '$rs1[runid]' ";
				$resultc = mysql_db_query($db_site,$sqlc);
				$rsc = mysql_fetch_assoc($resultc);
					if($rsc[NUMC] < 1){ // แสดงว่ายังไม่ได้เก็บข้อมูลให้เพิ่มข้อมูลเข้าไปใน log
						$sql_befor = "INSERT INTO salary_log_before(staffid,updatetime)VALUES($rs[staff_login],'$rs1[updatetime]')";
						$result_befor = mysql_db_query($db_site,$sql_befor);
						$last_id = mysql_insert_id(); // หา id ล่าสุดที่เพิ่มเข้าไป
						$sql_insert = "INSERT INTO salary_log_after(staffid,id,runno,runid,date,position,noposition,salary,upgrade,note,radub,noorder,ch_position,ch_radub,ch_salary,pls,dateorder,pos_name,pos_group,label_date,label_noposition,label_salary,label_dateorder,label_radub,instruct,begindate_status,updatetime,system_type,status_startwork,lv,order_type,schoolid,school_label,pos_onduty,pos_onduty_label,position_id,level_id,auto_id)
						SELECT $rs[staff_login],salary.id,salary.runno,salary.runid,salary.date,salary.position,salary.noposition,salary.salary,salary.upgrade,salary.note,salary.radub,salary.noorder,salary.ch_position,salary.ch_radub,salary.ch_salary,salary.pls,salary.dateorder,salary.pos_name,salary.pos_group,salary.label_date,salary.label_noposition,salary.label_salary,salary.label_dateorder,salary.label_radub,salary.instruct,salary.begindate_status,salary.updatetime,salary.system_type,salary.status_startwork,salary.lv,salary.order_type,salary.schoolid,salary.school_label,salary.pos_onduty,salary.pos_onduty_label,salary.position_id,salary.level_id,$last_id 
						FROM salary WHERE salary.runid='$rs1[runid]'";
						//echo "2 :: ".$sql_insert."<br>";
						mysql_db_query($db_site,$sql_insert);
						}//end if($rsc[NUMC] < 1)							
							
					}//  if($num1 == 1){ ///   เงื่อนไขที่ 2
		}//end if($numr1 == 1){ // กรณีที่ เงือนไขนี้มีแค่ บรรทัดเดียวคือสามารถใช้ข้อมูลได้เลย
	}// end while(){
				
echo " จำนวนรายการ ::".$xi;
		//echo "<hr>";
/*		###  ส่วนของข้อมูลประวัติการศึกษา
			$sql_edu = "SELECT * FROM `log_update` where updatetime LIKE '$date_req%' AND log_update.subject LIKE  '%การศึกษา%' $con_staff";
			$result_edu = mysql_db_query($db_site,$sql_edu);
			while($rs_edu = mysql_fetch_assoc($result_edu)){
			$sql_edu1 ="INSERT INTO graduate_log_after_temp (staffid,runid,id,runno,place,startyear,finishyear,year_label,grade,kp7_active,graduate_level,degree_level,major_level,major_label,minor_level,minor_label,university_level,type_graduate,updatetime)
  SELECT  $rs_edu[staff_login],graduate.runid,graduate.id,graduate.runno,graduate.place,graduate.startyear,graduate.finishyear,graduate.year_label,graduate.grade,graduate.kp7_active,graduate.graduate_level,graduate.degree_level,graduate.major_level,graduate.major_label,graduate.minor_level,graduate.minor_label,graduate.university_level,graduate.type_graduate,graduate.updatetime
  FROM graduate WHERE graduate.id='$rs_edu[username]' and graduate.updatetime BETWEEN '$rs_edu[updatetime]' - INTERVAL 1 SECOND AND '$rs_edu[updatetime]' + INTERVAL 1 SECOND";
  					//echo "$sql_edu1<br>";
					@mysql_db_query($db_site,$sql_edu1);
					
			}//end while($rs_edu = mysql_fetch_assoc($result_edu)){
*/			//echo "<hr>";
/*	########################### ฝึกอบรมและดูงาน
	$sql_semi = "SELECT * FROM `log_update` where updatetime LIKE '$date_req%' AND log_update.subject LIKE  '%ดูงาน%' $con_staff";
	$result_semi = mysql_db_query($db_site,$sql_semi);
	while($rs_semi = mysql_fetch_assoc($result_semi)){
		$sql_semi1 = "INSERT INTO seminar_log_after_temp(staffid,runid,id,runno,stype,startdate,enddate,subject,versions,place,note,kp7_active,updatetime)
		SELECT $rs_semi[staff_login],seminar.runid,seminar.id,seminar.runno,seminar.stype,seminar.startdate,seminar.enddate,seminar.subject,seminar.versions,seminar.place,seminar.note,seminar.kp7_active,seminar.updatetime FROM  seminar  WHERE  seminar.id='$rs_semi[username]' 
		AND  
seminar.updatetime BETWEEN '$rs_semi[updatetime]' - INTERVAL 1 SECOND AND '$rs_semi[updatetime]' + INTERVAL 1 SECOND";
		//echo "$sql_semi1<br>";
		@mysql_db_query($db_site,$sql_semi1);
			
	}//end while($rs_semi = mysql_fetch_assoc($result_semi)){
			//echo "<hr>";
	####################### 8 เครื่องราชอิสริยาภรณ์ วันที่ได้รับและวันส่งคืน รวมทั้งเอกสารอ้างอิง
	$sql_sheet = "SELECT * FROM `log_update` where updatetime LIKE '$date_req%'  and subject LIKE '%อิสรยาภรณ์%' $con_staff";
	$result_sheet = mysql_db_query($db_site,$sql_sheet);
	while($rs_sheet = mysql_fetch_assoc($result_sheet)){
			$sql_sheet1 = "INSERT INTO getroyal_log_after_temp (staffid,runid,id,orderid,getroyal,getroyal_id,date,no,bookno,book,section,page,date2,kp7_active,label_date,label_date2,updatetime)
			SELECT $rs_sheet[staff_login],getroyal.runid,getroyal.id,getroyal.orderid,getroyal.getroyal,getroyal.getroyal_id,getroyal.date,getroyal.no,getroyal.bookno,getroyal.book,getroyal.section,getroyal.page,getroyal.date2,getroyal.kp7_active,getroyal.label_date,getroyal.label_date2,getroyal.updatetime
			FROM getroyal WHERE getroyal.id='$rs_sheet[username]' AND  getroyal.updatetime BETWEEN '$rs_sheet[updatetime]' - INTERVAL 1 SECOND AND '$rs_sheet[updatetime]' + INTERVAL 1 SECOND	";
		//	echo "$sql_sheet1<br>";
			@mysql_db_query($db_site,$sql_sheet1);
	}//end while($rs_sheet = mysql_fetch_assoc($result_sheet)){
			//echo "<hr>";	
########## 11 ข้อมูลวันลา

	$sql_absent = "SELECT * FROM `log_update` WHERE log_update.updatetime LIKE  '$date_req%'  
	AND log_update.subject LIKE  '%ข้อมูลจำนวนวันลาหยุด%' $con_staff";
	$result_absent = mysql_db_query($db_site,$sql_absent);
	while($rs_ab = mysql_fetch_assoc($result_absent)){
			$sql_absent1 = "INSERT INTO  hr_absent_log_after_temp (staffid,id,yy,sick,duty,vacation,late,absent,education,etc,date,date_vacation,date_vacation_all,birth,startdate,enddate,other_absent,label_yy,label_sick,label_birth,label_dv,label_late,label_absent,label_etc,label_education,special_exp,merge_col,updatetime)
			SELECT $rs_ab[staff_login],hr_absent.id,hr_absent.yy,hr_absent.sick,hr_absent.duty,hr_absent.vacation,hr_absent.late,hr_absent.absent,hr_absent.education,hr_absent.etc,hr_absent.date,hr_absent.date_vacation,hr_absent.date_vacation_all,hr_absent.birth,hr_absent.startdate,hr_absent.enddate,hr_absent.other_absent,hr_absent.label_yy,hr_absent.label_sick,hr_absent.label_birth,hr_absent.label_dv,hr_absent.label_late,hr_absent.label_absent,hr_absent.label_etc,hr_absent.label_education,hr_absent.special_exp,hr_absent.merge_col,hr_absent.updatetime
			FROM hr_absent WHERE hr_absent.id='$rs_ab[username]' AND  hr_absent.updatetime BETWEEN '$rs_ab[updatetime]' - INTERVAL 1 SECOND AND '$rs_ab[updatetime]' + INTERVAL 1 SECOND
			";
			//echo "$sql_absent1<br>";
			@mysql_db_query($db_site,$sql_absent1);
	}//end while($rs_ab = mysql_fetch_assoc($result_absent)){
			//echo "<hr>";
	#######  ข้อมูลวันไม่ได้รับเงินเดือน
	$sql_nosalary = "SELECT * FROM `log_update` WHERE log_update.updatetime LIKE  '$date_req%' AND
log_update.subject LIKE  '%ไม่ได้รับเงินเดือน%' $con_staff ";
	$result_nosalary = mysql_db_query($db_site,$sql_nosalary);
	while($rs_nos = mysql_fetch_assoc($result_nosalary)){
		$sql_nosalary1 = " INSERT INTO hr_nosalary_log_after_temp (staffid,no,id,runno,fromdate,todate,comment,refdoc,label_date,kp7_active,updatetime) 
		SELECT $rs_nos[staff_login],hr_nosalary.no,hr_nosalary.id,hr_nosalary.runno,hr_nosalary.fromdate,hr_nosalary.todate,hr_nosalary.comment,hr_nosalary.refdoc,hr_nosalary.label_date,hr_nosalary.kp7_active,hr_nosalary.updatetime
		FROM hr_nosalary WHERE hr_nosalary.id='$rs_nos[username]' AND  hr_nosalary.updatetime BETWEEN '$rs_nos[updatetime]' - INTERVAL 1 SECOND AND '$rs_nos[updatetime]' + INTERVAL 1 SECOND
		";
		//echo "$sql_nosalary1<br>";
		@mysql_db_query($db_site,$sql_nosalary1);
			
	}//end while($rs_nos = mysql_fetch_assoc($result_nosalary)){
				//echo "<hr>";
		#### การได้รับโทษทางวินัย
	$sql_spec = "SELECT * FROM `log_update` WHERE log_update.updatetime LIKE  '$date_req%' AND
log_update.subject LIKE  '%การปฏิบัติราชการพิเศษ%' $con_staff ";
	$result_spec = mysql_db_query($db_site,$sql_spec);
	while($rs_sp = mysql_fetch_assoc($result_spec)){
			$sql_spec1 = "INSERT INTO hr_specialduty_log_after_temp(staffid,no,runid,id,yy,dutydate,comment,kp7_type,kp7_active,double_type,double_start,double_end,double_sick,double_duty,double_getyy,double_getmm,double_getdd,updatetime) 
			SELECT $rs_sp[staff_login],hr_specialduty.no,hr_specialduty.runid,hr_specialduty.id,hr_specialduty.yy,hr_specialduty.dutydate,hr_specialduty.comment,hr_specialduty.kp7_type,hr_specialduty.kp7_active,hr_specialduty.double_type,hr_specialduty.double_start,hr_specialduty.double_end,hr_specialduty.double_sick,hr_specialduty.double_duty,hr_specialduty.double_getyy,hr_specialduty.double_getmm,hr_specialduty.double_getdd,hr_specialduty.updatetime
			
			FROM hr_specialduty WHERE hr_specialduty.id='$rs_sp[username]' AND  hr_specialduty.updatetime BETWEEN '$rs_sp[updatetime]' - INTERVAL 1 SECOND AND '$rs_sp[updatetime]' + INTERVAL 1 SECOND  ";
			//echo "$sql_spec1<br>";
			@mysql_db_query($db_site,$sql_spec1);
	}//end 	while($rs_p = mysql_fetch_assoc($result_prohibit)){
				//echo "<hr>";
		### รายการอื่นๆ
		$sql_other = "SELECT * FROM `log_update` WHERE log_update.updatetime LIKE  '$date_req%' AND
log_update.subject LIKE  '%อื่นๆ%' $con_staff";
		$result_other = mysql_db_query($db_site,$sql_other);
		while($rs_oth = mysql_fetch_assoc($result_other)){
				$sql_other1 = "INSERT INTO hr_other_log_after_temp (staffid,no,id,runno,comment,kp7_active,updatetime) 
				SELECT $rs_oth[staff_login],hr_other.no,hr_other.id,hr_other.runno,hr_other.comment,hr_other.kp7_active,hr_other.updatetime
				FROM hr_other WHERE hr_other.id='$rs_oth[username]' AND hr_other.updatetime BETWEEN '$rs_oth[updatetime]' - INTERVAL 1 SECOND AND '$rs_oth[updatetime]' + INTERVAL 1 SECOND
				";
				//echo "$sql_other1<br>";
				@mysql_db_query($db_site,$sql_other1);
		}//end while($rs_oth = mysql_fetch_assoc($result_other)){
			
			
#######  รายการความดีความชอบ
		$sql_goodman = "SELECT * FROM log_update WHERE  updatetime LIKE '$date_req%' AND subject LIKE '%ความดีความชอบ%'";
		$result_goodman = mysql_db_query($db_site,$sql_goodman);
		while($rs_g = mysql_fetch_assoc($result_goodman)){
			$sql_insert  ="INSERT INTO goodman_log_after_temp(staffid,runid,runno,id,date,gaction,salary,note,radub,updatetime)
			SELECT $rs_g[staff_login],runid,runno,id,date,gaction,salary,note,radub,updatetime
			FROM goodman WHERE id='$rs_g[username]' AND updatetime BETWEEN '$rs_g[updatetime]' - INTERVAL 1 SECOND AND '$rs_g[updatetime]' + INTERVAL 1 SECOND";
			@mysql_db_query($db_site,$sql_insert);
				
		}//end 

*/
				echo "ประมวลผลข้อมูลเรียบร้อยแล้ว";
			
 ?>