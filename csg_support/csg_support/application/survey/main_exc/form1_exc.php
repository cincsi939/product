<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  23/09/2014
 * @access  public
 */
 ?>
 <?php
 	session_start();
	//error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(0);
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
	$sDay = date('d');
	$sMonth = date('m');
	$sYear = (date('Y')+543);
	
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
	foreach( $VAR as $key => $val){
		$sqlVAR="
			INSERT INTO `eq_var_data` SET
			`siteid`='1',
			`number_action`='1', 
			form_id='".$trees."',
			`pin`='".$PIN."',
			`vid`='".$key."' ,
			`yy`='".$yy."',
			`mm`='".$mm."',
			`value`='".$val."',
			`appstatus`='approve',
			`reportdate`='".$sYear."-".$sMonth."-".$sDay."',
			`user_id`='".$_SESSION['username']."' ,
			pin_idcard = '".$id_card."'
		";
		$rsConn = mysql_query($sqlVAR);						
	}
	
	/*--------------------------------------------------------------------------------------- Upload Img*/
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["v378"]["name"]);
	$extension = end($temp);
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
		if (file_exists("../../img/profile/" . $_FILES["file"]["name"])) { //ตั้งค่าที่อยู่ไฟล์เก็บรูปภาพ
		   $_FILES["v378"]["name"] . " already exists. ";
		}  {
		  move_uploaded_file($_FILES["v378"]["tmp_name"],
		  "../../img/profile/" . $_FILES["v378"]["name"]);
		   "Stored in: " . "../../img/profile/" . $_FILES["v378"]["name"];
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
			INSERT INTO `eq_var_data` SET
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
			`user_id`='".$_SESSION['username']."' 
		";
		$rsConn = mysql_query($sqlVAR);	
	  }
	} else {
	   //echo "Invalid file";
	}
	
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
	//$birthDay = explode('/',$birthDay);
	//$day = $birthDay[2].'-'.$birthDay[1].'-'.$birthDay[0];

	$sql="
		REPLACE INTO eq_person
		select
			NULL as eq_id,
			'".$_POST['v3']."' as eq_idcard,
			'".$_POST['v376']."' as eq_code_prename,
			getDetail(4,".$_POST['v376'].") as eq_prename,
			'".$_POST['v1']."' as eq_firstname,
			'".$_POST['v2']."' as eq_lastname,
			'".$_POST['v5']."' as eq_address,
			'".$_POST['v6']."' as eq_village,
			'".$_POST['v7']."' as eq_street,
			'".$_POST['v8']."' as eq_code_parish,
			getCCAA(LEFT(".$_POST['v8'].",6)) as eq_parish,
			'".$_POST['v9']."' as eq_code_district,
			getCCAA(LEFT(".$_POST['v9'].",4)) as eq_district,
			'".$_POST['v10']."' as eq_code_province,
			getCCAA(LEFT(".$_POST['v10'].",2)) as eq_province,
			'".$_POST['v11']."' as eq_phone,
			'".$_POST['v12']."' as eq_code_gender,
			getDetail(5,".$_POST['v12'].") as eq_gender,
			'".$_POST['v377']."' as eq_birthday,
			'".$_POST['v14']."' as eq_age,
			'".$_POST['v22']."' as eq_code_education,
			getDetail(8,".$_POST['v22'].") as eq_education,
			'0' as eq_code_relation,
			'หัวหน้าครัวเรือน' as eq_relation,
			'".$career_code."' as eq_code_career,
			'".$career_title."' as eq_career,
			'".$_POST['v36']."' as eq_salary,
			0 as eq_partner_id,
			'".$_SESSION['username']."' as eq_user_create,
			'".date('Y-m-d H:i:s')."' as eq_date_create,
			'".$_SESSION['username']."' as eq_user_modify,
			'".date('Y-m-d H:i:s')."' as eq_date_modify,
			'".(date('Y')+543)."' as eq_year,
			1 as eq_round,
			0 as eq_type
	";
	$rsConn = mysql_query($sql);	
	
	
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../question_form.php?frame=form2&id='.$PIN.'">';
	
	
 ?>