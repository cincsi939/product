<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Wised Wisesvatcharajaren
 * @created  23/07/2558
 * @access  public
 */
 ?>
 <?php
 //print_r($_POST);
 	session_start();
	if(!$_SESSION['username']){
		header( "location:../../usermanager/login.php");
	}else{
	//include "../header.php";
	//error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(0);
	include("../../../config/config_host.php"); #อ้างหาค่า Define
	require_once("../lib/class.function.php");
	include "../../../common/php_class/class_calculate_kpi.php";	
	$con = new Cfunction();
	$con->connectDB();
	function fnc_get_ccaa($value){
			$gprename = mysql_query("select ccDigi,ccName,ccType from ccaa where ccDigi='$value' "); 
			$rpre = mysql_fetch_array($gprename);
			$name_fild = $rpre['ccName'];
			return $name_fild;
	}
	
	/*--------------------------------------------------------------------------------------- วันที่*/
	$sDay = $_POST['sDay'];
	$sMonth = sprintf("%02d",$_POST['sMonth']);
	$sYear = $_POST['sYear']-543;
	$register_date = $sYear.'-'.$sMonth.'-'.$sDay;
	$yy=$sYear;
	$mm=$sMonth;	
	$trees=1;
	
	$status = 1;
	$stamp = date("Y-m-d H:i:s"); 	
	
	$trees = 1;
	
	$PIN = $_POST['v3']; // รหัสบัตรประชาชน
	$id_card= $_POST['v3']; // รหัสบัตรประชาชน
	foreach($_POST as $name => $value)
	{		
		//echo $name;
		if(preg_match("/v/",$name) == true)
		{ 
			$n=str_replace("v","",$name);  // ค่าอื่นๆตาม choice
			$VAR[$n]=$value;
		}
	}
	
	$status=($status)?$status:"add";
	
	##บันทึกครั้งแรก		
	
	
	if($_POST['v23']!=''){$career[] = $_POST['v23'];$career_detail[] = 'รับจ้างทั่วไป';}
	if($_POST['v24']!=''){$career[] = $_POST['v24'];$career_detail[] = 'เกษตรกร';}
	if($_POST['v25']!=''){$career[] = $_POST['v25'];$career_detail[] = 'ประมง';}
	if($_POST['v26']!=''){$career[] = $_POST['v26'];$career_detail[] = 'ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ';}
	if($_POST['v27']!=''){$career[] = $_POST['v27'];$career_detail[] = 'พนักงานรัฐวิสาหกิจ';}
	if($_POST['v28']!=''){$career[] = $_POST['v28'];$career_detail[] = 'เจ้าหน้าที่องค์กรปกครองท้องถิ่น ';}
	if($_POST['v29']!=''){$career[] = $_POST['v29'];$career_detail[] = 'ค้าขาย/ธุรกิจส่วนตัว';}
	if($_POST['v30']!=''){$career[] = $_POST['v30'];$career_detail[] = 'พนักงาน/ลูกจ้างเอกชน';}
	if($_POST['v31']!=''){$career[] = $_POST['v31'];$career_detail[] = 'ว่างงาน/ไม่มีงานทำ';}
	if($_POST['v32']!=''){$career[] = $_POST['v32'];$career_detail[] = 'อื่น ๆ';}
	if($_POST['v33']!=''){$career_detail[] = $_POST['v33'];}
	$career_code = implode(',',$career);
	$career_title = implode(',',$career_detail);
	
	$birthDay = $_POST['v377'];
	$birthDay = explode('/',$birthDay);
	$day = ($birthDay[2]-543).'-'.$birthDay[1].'-'.$birthDay[0];
	$childBirth = '0000-00-00';
	if($_POST['v903'] != ''){
	$childBirth = ($_POST['v903']-543).'-'.sprintf("%02d",$_POST['v902']).'-00';
	}else{
	$childBirth = '0000-'.sprintf("%02d",$_POST['v902']).'-00';	
	}

	$sql="
		INSERT INTO ".DB_DATA.".eq_person SET
			eq_idcard = '".trim($_POST['v3'])."',
			eq_code_prename = '".$_POST['v376']."',
			eq_prename = getDetail(4,'".$_POST['v376']."'),
			eq_firstname = '".trim($_POST['v1'])."',
			eq_lastname = '".trim($_POST['v2'])."',
			eq_address = '".trim($_POST['v5'])."',
			eq_village = '".trim($_POST['v6'])."',
			eq_alley = '".trim($_POST['v13'])."',
			eq_street = '".trim($_POST['v7'])."',
			eq_code_parish = '".$_POST['v8']."',
			eq_code_district = '".$_POST['v9']."',
			eq_code_province = '".$_POST['v10']."',";
			if($_POST['v8']!=""){
		$sql.="eq_parish = getCCAA(LEFT('".$_POST['v8']."',6)),";
			}
			if($_POST['v9']!=""){
		$sql.="eq_district = getCCAA(LEFT('".$_POST['v9']."',4)),";
			}
			if($_POST['v10']!=""){
		$sql.="eq_province = getCCAA(LEFT('".$_POST['v10']."',2)),";
			}
		$sql.="eq_phone = '".trim($_POST['v11'])."',
			eq_address_now = '".trim($_POST['v805'])."',
			eq_village_now = '".trim($_POST['v806'])."',
			eq_alley_now = '".trim($_POST['v813'])."',
			eq_subvillage = '".trim($_POST['v814'])."',
			eq_street_now = '".trim($_POST['v807'])."',
			eq_code_parish_now = '".$_POST['v808']."',
			eq_code_district_now = '".$_POST['v809']."',
			eq_code_province_now = '".$_POST['v810']."',";
			
			if($_POST['v808']!=""){
		$sql.="eq_parish_now = getCCAA(LEFT('".$_POST['v808']."',6)),";
			}
			if($_POST['v809']!=""){
		$sql.="eq_district_now = getCCAA(LEFT('".$_POST['v809']."',4)),";
			}
			if($_POST['v810']!=""){
		$sql.="eq_province_now = getCCAA(LEFT('".$_POST['v810']."',2)),";
			}
			
		$sql.="eq_phone_now = '".trim($_POST['v811'])."',
			
				eq_postcode = '".trim($_POST['v406'])."',
				eq_mobile = '".trim($_POST['v410'])."',
				eq_postcode_now = '".trim($_POST['v407'])."',
				eq_mobile_now = '".trim($_POST['v411'])."',
				eq_embryo_number = '".trim($_POST['v415'])."',
				eq_father_name = '".trim($_POST['v412'])."',
				eq_father_lname = '".trim($_POST['v413'])."',
				eq_father_idcard = '".trim($_POST['v414'])."',
			
			eq_card_start = '".trim($_POST['v701'])."',
			eq_card_exp = '".trim($_POST['v702'])."',
			
			eq_b4preg_age = '".trim($_POST['v901'])."',
			eq_b4preg_birthmonth = '".trim($_POST['v902'])."',
				eq_b4preg_birthfull = '".trim($childBirth)."',
			eq_b4preg_birthyear = '".trim($_POST['v903'])."',
			eq_b4preg_place = '".trim($_POST['v904'])."',
			eq_afterpreg_regisdate = '".trim($_POST['v905'])."',
			eq_afterpreg_childage = '".trim($_POST['v906'])."',
			
			eq_b4preg_check = '".$_POST['v907']."',
			eq_afterpreg_check = '".$_POST['v908']."',
			
			eq_cardcopy_check = '".$_POST['v911']."',
			eq_healthhistory_check = '".$_POST['v912']."',
			eq_childbirthdoc_check = '".$_POST['v913']."',
				
				eq_father_cardcopy_check = '".$_POST['v914']."',
				eq_guaranteestatus_check = '".$_POST['v910']."',
				eq_motherstatus_check = '".$_POST['v915']."',
				eq_selfreceive_check = '".$_POST['v917']."',
				eq_transreceive_check = '".$_POST['v916']."',
			
			eq_bookbank_id = '".trim($_POST['v921'])."',
			eq_bookbank_name = '".trim($_POST['v922'])."',
			eq_bookbank_type = '".trim($_POST['v923'])."',
			eq_bankplace = '".trim($_POST['v925'])."',
			
			eq_code_gender = '".$_POST['v12']."',
			eq_gender = getDetail(5,'".$_POST['v12']."'),
			eq_birthday = '".trim($_POST['v377'])."',
			eq_age = '".trim($_POST['v14'])."',
			eq_code_education = '',
			eq_education = '',
			eq_code_relation = '0',
			eq_relation = 'มารดา',
			eq_code_career = '".$career_code."',
			eq_career = '".$career_title."',
			eq_salary = '".trim($_POST['v36'])."',
			eq_partner_id = 0,
			eq_user_create = '".$_SESSION['username']."',
			eq_date_create = '".date('Y-m-d H:i:s')."',
			eq_user_modify = '".$_SESSION['username']."',
			eq_date_modify = '".date('Y-m-d H:i:s')."',
			eq_year = '".(date('Y')+543)."',
			eq_round = 1,
			eq_type = 0,
			eq_gid = '".$_SESSION['session_group']."',
			eq_idcard_status = '".$_POST['eq_idcard_status']."',
			eq_register_date = '".$register_date."',
			eq_mother_status = '".$_POST['v417']."',
			eq_father_phone = '".$_POST['v418']."'
	";
	//echo $sql."<br>";
	$rsConn = mysql_db_query(DB_DATA,$sql);
	
	$sql_eq_id="SELECT eq_id FROM eq_person WHERE eq_idcard = '".$PIN."' ORDER BY eq_id DESC limit 1";
	$rs_eq_id = mysql_query($sql_eq_id);
	$res=mysql_fetch_assoc($rs_eq_id);
	
	foreach( $VAR as $key => $val){
		$sqlVAR="
			INSERT INTO ".DB_DATA.".eq_var_data SET
			`siteid`='1',
			`number_action`='1', 
			form_id='".$trees."',
			`pin`='".$PIN."',
			`vid`='".$key."' ,
			`yy`='".$yy."',
			`mm`='".$mm."',
			`value`='".trim($val)."',
			`appstatus`='approve',
			`reportdate`='".$register_date."',
			`user_id`='".$_SESSION['username']."' ,
			pin_idcard = '".$id_card."',
			eq_id = '".$res['eq_id']."'
		";
		//echo $sqlVAR."<br>";
		$rsConn = mysql_db_query(DB_DATA,$sqlVAR);			
	}
	
	/*--------------------------------------------------------------------------------------- Upload Img*/
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["v378"]["name"]);
	$extension = end($temp);
	//echo $_POST['lastPhoto'];
	if ((($_FILES["v378"]["type"] == "image/gif")
	|| ($_FILES["v378"]["type"] == "image/jpeg")
	|| ($_FILES["v378"]["type"] == "image/jpg")
	|| ($_FILES["v378"]["type"] == "image/pjpeg")
	|| ($_FILES["v378"]["type"] == "image/x-png")
	|| ($_FILES["v378"]["type"] == "image/png"))
	&& ($_FILES["v378"]["size"] < 100000000) //ตั้งค่าขนาดรูป
	&& in_array($extension, $allowedExts)) {
	  if ($_FILES["v378"]["error"] > 0) {
		 "Return Code: " . $_FILES["v378"]["error"] . "<br>";
	  } else {
		if (file_exists("../../../../<?php echo APP_REPO; ?>/profile/" . $_FILES["file"]["name"])) { //ตั้งค่าที่อยู่ไฟล์เก็บรูปภาพ
		   $_FILES["v378"]["name"] . " already exists. ";
		}  {
		  move_uploaded_file($_FILES["v378"]["tmp_name"],
		  "../../../../<?php echo APP_REPO; ?>/profile/" . $_FILES["v378"]["name"]);
		   "Stored in: " . "../../../../<?php echo APP_REPO; ?>/profile/" . $_FILES["v378"]["name"];
		}
		
		$namepic = ($_FILES["v378"]["name"]); //เก็บชื่อของรูปไว้ในฐานข้อมูล
		$photo = $namepic;
		$id = $PIN; // ชื่อที่ต้องการเปลี่ยน
		$folder = '../../img/profile'; //ที่อยู่โฟลเดอร์ที่จะเปลี่ยนชื่อ และไม่มีเครื่องหมาสแลชต่อท้าย
		$ext = explode('.',$photo);
		$ext = end($ext);
		rename($folder.'/'.$photo, $folder.'/'.$id.'.'.$ext);
		$nameNew = $id.'.'.$ext;
		$data = array(
			'value' => $nameNew
		);
		//$con->update("eq_var_data",$data,'pin='.$PIN.' AND vid = 378');
		$sqlVAR="
			INSERT INTO ".DB_DATA.".eq_var_data SET
			`siteid`='1',
			`number_action`='1', 
			form_id='".$trees."',
			`pin`='".$PIN."',
			`vid`='378' ,
			`yy`='".$yy."',
			`mm`='".$mm."',
			`value`='".$nameNew."',
			`appstatus`='approve',
			`reportdate`='".$sYear."-".$sMonth."-".$sDay."',
			`user_id`='".$_SESSION['username']."' ,
			pin_idcard = '".$id_card."',
			eq_id = '".$res['eq_id']."'
		";
		//echo $sqlVAR."<br>";
		$rsConn = mysql_db_query(DB_DATA,$sqlVAR);
	  }
	}else if(isset($_POST['lastPhoto']) && $_POST['lastPhoto']!=''){
		$data = $_POST['lastPhoto'];
		//echo '<img src="'.$data.'" />';
                $nameNew = $PIN.'.png';

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
				
                file_put_contents('../../../../<?php echo APP_REPO; ?>/profile/' . $nameNew , $data);
		$sqlVAR="
			INSERT INTO ".DB_DATA.".eq_var_data SET
			`siteid`='1',
			`number_action`='1', 
			form_id='".$trees."',
			`pin`='".$PIN."',
			`vid`='378' ,
			`yy`='".$yy."',
			`mm`='".$mm."',
			`value`='".$nameNew."',
			`appstatus`='approve',
			`reportdate`='".$sYear."-".$sMonth."-".$sDay."',
			`user_id`='".$_SESSION['username']."' ,
			pin_idcard = '".$id_card."',
			eq_id = '".$res['eq_id']."'
		";
		//echo $sqlVAR."<br>";
		$rsConn = mysql_db_query(DB_DATA,$sqlVAR);
		//echo $sqlVAR;
	} else {
	   //echo "Invalid file";
	}
		if($_POST['v416']!=''){
			$sql_dupp="
			INSERT INTO ".DB_DATA.".eq_dupp_person SET
			eq_id = '".$res['eq_id']."',
			eq_dupp_id = '".$_POST['v416']."',
			eq_idcard = '".$PIN."'
		";
		//echo $sql_dupp."<br>";
		$rs_dupp = mysql_db_query(DB_DATA,$sql_dupp);
		}
	//echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../question_form.php?frame=dr_doc1&id='.$PIN.'&eq_id='.$res["eq_id"].'">';
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../dashboard.php">';
	}
 ?>