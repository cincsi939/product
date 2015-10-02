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
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include('../lib/class.function.php');
include "../../../common/php_class/class_calculate_kpi.php";	
$con = new Cfunction();
$con->connectDB();

/*--------------------------------------------------------------------------------------- วันที่*/
	$sDay = date('d');
	$sMonth = date('m');
	$sYear = (date('Y')+543);
	
	$yy=$sYear;
	$mm=$sMonth;	
	$trees=1;
	
	$status = 1;
	$stamp = date("Y-m-d H:i:s"); 	
	
	$trees = 2;
	//$PIN = $_POST['pin']; // รหัสบัตรประชาชน
	$PIN = $_POST['pin'];
	
	$sql_pin= "select eq_address,eq_village,eq_street,eq_code_parish,eq_parish,eq_code_district,eq_district,eq_code_province,eq_province,eq_phone From eq_person where eq_idcard = '".$PIN."'";
	$results = $con->select($sql_pin);
	foreach($results as $row){}
	
	if($_POST['eq_type']==1)
	{
		$eq_idcard = $_POST['v156'];
		$eq_code_prename = $_POST['v384'];
		$eq_firstname = $_POST['v154'];
		$eq_lastname = $_POST['v381'];
		$eq_address = $row['eq_address'];
		$eq_village = $row['eq_village'];
		$eq_street = $row['eq_street'];
		$eq_code_parish = $row['eq_code_parish'];
		$eq_parish = $row['eq_parish'];
		$eq_code_district = $row['eq_code_district'];
		$eq_district = $row['eq_district'];
		$eq_code_province = $row['eq_code_province'];
		$eq_province = $row['eq_province'];
		$eq_phone = $row['eq_phone'];
		$eq_code_gender = $_POST['v383'];
		$eq_birthday = $_POST['v382'];
		$eq_age = $_POST['v155'];
		$eq_code_education = $_POST['v158']; //การศึกษา
		$eq_code_relation = $_POST['v157']; //ความสัมพันธ์ครอบครัว
		$eq_code_career = '';
		$eq_career = '';
	}
	elseif($_POST['eq_type']==2)
	{
		$eq_idcard = $_POST['v196'];
		$eq_code_prename = $_POST['v400'];
		$eq_firstname = $_POST['v194'];
		$eq_lastname = $_POST['v388'];
		$eq_address = $row['eq_address'];
		$eq_village = $row['eq_village'];
		$eq_street = $row['eq_street'];
		$eq_code_parish = $row['eq_code_parish'];
		$eq_parish = $row['eq_parish'];
		$eq_code_district = $row['eq_code_district'];
		$eq_district = $row['eq_district'];
		$eq_code_province = $row['eq_code_province'];
		$eq_province = $row['eq_province'];
		$eq_phone = $row['eq_phone'];
		$eq_code_gender = $_POST['v396'];
		$eq_birthday = $_POST['v392'];
		$eq_age = $_POST['v195'];
		$eq_code_education = $_POST['v198']; //การศึกษา
		$eq_code_relation = $_POST['v197']; //ความสัมพันธ์ครอบครัว
		$eq_code_career = '';
		$eq_career = '';
	}
	elseif($_POST['eq_type']==3)
	{
		$eq_idcard = $_POST['v230'];
		$eq_code_prename = $_POST['v401'];
		$eq_firstname = $_POST['v228'];
		$eq_lastname = $_POST['v389'];
		$eq_address = $row['eq_address'];
		$eq_village = $row['eq_village'];
		$eq_street = $row['eq_street'];
		$eq_code_parish = $row['eq_code_parish'];
		$eq_parish = $row['eq_parish'];
		$eq_code_district = $row['eq_code_district'];
		$eq_district = $row['eq_district'];
		$eq_code_province = $row['eq_code_province'];
		$eq_province = $row['eq_province'];
		$eq_phone = $row['eq_phone'];
		$eq_code_gender = $_POST['v397'];
		$eq_birthday = $_POST['v393'];
		$eq_age = $_POST['v229'];
		$eq_code_education = $_POST['v232']; //การศึกษา
		$eq_code_relation = $_POST['v231']; //ความสัมพันธ์ครอบครัว
		$eq_code_career = '';
		$eq_career = '';
	}
	elseif($_POST['eq_type']==4)
	{
		$eq_idcard = $_POST['v261'];
		$eq_code_prename = $_POST['v402'];
		$eq_firstname = $_POST['v259'];
		$eq_lastname = $_POST['v390'];
		$eq_address = $row['eq_address'];
		$eq_village = $row['eq_village'];
		$eq_street = $row['eq_street'];
		$eq_code_parish = $row['eq_code_parish'];
		$eq_parish = $row['eq_parish'];
		$eq_code_district = $row['eq_code_district'];
		$eq_district = $row['eq_district'];
		$eq_code_province = $row['eq_code_province'];
		$eq_province = $row['eq_province'];
		$eq_phone = $row['eq_phone'];
		$eq_code_gender = $_POST['v398'];
		$eq_birthday = $_POST['v394'];
		$eq_age = $_POST['v260'];
		$eq_code_education = $_POST['v263']; //การศึกษา
		$eq_code_relation = $_POST['v262']; //ความสัมพันธ์ครอบครัว
		$eq_code_career = '';
		$eq_career = '';
	}
	elseif($_POST['eq_type']==5)
	{
		$eq_idcard = $_POST['v299'];
		$eq_code_prename = $_POST['v403'];
		$eq_firstname = $_POST['v297'];
		$eq_lastname = $_POST['v391'];
		$eq_address = $row['eq_address'];
		$eq_village = $row['eq_village'];
		$eq_street = $row['eq_street'];
		$eq_code_parish = $row['eq_code_parish'];
		$eq_parish = $row['eq_parish'];
		$eq_code_district = $row['eq_code_district'];
		$eq_district = $row['eq_district'];
		$eq_code_province = $row['eq_code_province'];
		$eq_province = $row['eq_province'];
		$eq_phone = $row['eq_phone'];
		$eq_code_gender = $_POST['v399'];
		$eq_birthday = $_POST['v395'];
		$eq_age = $_POST['v298'];
		$eq_code_education = $_POST['v301']; //การศึกษา
		$eq_code_relation = $_POST['v300']; //ความสัมพันธ์ครอบครัว
		$eq_code_career = '';
		$eq_career = '';
	}
	
	$id_card= $eq_idcard; // รหัสบัตรประชาชน
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
		$rsConn = mysql_query($sqlVAR) or die(mysql_error());		
	}
	
	
	//$eq_birthday = explode('/',$eq_birthday);
	//$day = $birthDay[2].'-'.$eq_birthday[1].'-'.$eq_birthday[0];
	
	$con->delete('eq_person',"eq_idcard = ".$eq_idcard." AND eq_year='".(date('Y')+543)."' AND eq_round = 1");
	
	$sql="
		REPLACE INTO eq_person
		select
			NULL as eq_id,
			'".$eq_idcard."' as eq_idcard,
			'".$eq_code_prename."' as eq_code_prename,
			getDetail(4,".$eq_code_prename.") as eq_prename,
			'".$eq_firstname."' as eq_firstname,
			'".$eq_lastname."' as eq_lastname,
			'".$eq_address."' as eq_address,
			'".$eq_village."' as eq_village,
			'".$eq_street."' as eq_street,
			'".$eq_code_parish."' as eq_code_parish,
			'".$eq_parish."' as eq_parish,
			'".$eq_code_district."' as eq_code_district,
			'".$eq_district."' as eq_district,
			'".$eq_code_province."' as eq_code_province,
			'".$eq_province."' as eq_province,
			'".$eq_phone."' as eq_phone,
			'".$eq_code_gender."' as eq_code_gender,
			getDetail(5,".$eq_code_gender.") as eq_gender,
			'".$eq_birthday."' as eq_birthday,
			'".$eq_age."' as eq_age,
			'".$eq_code_education."' as eq_code_education,
			getDetail(8,".$eq_code_education.") as eq_education,
			'".$eq_code_relation."' as eq_code_relation,
			getDetail(9,".$eq_code_relation.") as eq_relation,
			'".$eq_code_career."' as eq_code_career,
			'".$eq_career."' as eq_career,
			' ' as eq_salary,
			'".$PIN."' as eq_partner_id,
			'".$_SESSION['username']."' as eq_user_create,
			'".date('Y-m-d H:i:s')."' as eq_date_create,
			'".$_SESSION['username']."' as eq_user_modify,
			'".date('Y-m-d H:i:s')."' as eq_date_modify,
			'".(date('Y')+543)."' as eq_year,
			1 as eq_round,
			'".$_POST['eq_type']."' as eq_type
	";
	$rsConn = mysql_query($sql);	
	
	$sql = 'SELECT eq_person.eq_id FROM `eq_person` where eq_idcard = '.$eq_idcard.' ORDER BY eq_id desc LIMIT 0,1';
	$results = $con->select($sql);
	foreach($results as $row){
			$id = $row['eq_id'];
			if($_POST['eq_type']==1)
			{	
				if($_POST['v159']){$problem_1=1;}else{$problem_1 = 0;}
				if($_POST['v160']){$problem_2=1;}else{$problem_2 = 0;}
				if($_POST['v161']){$problem_3=1;}else{$problem_3 = 0;}
				if($_POST['v162']){$problem_4=1;}else{$problem_4 = 0;}
				if($_POST['v163']){$problem_5=1;}else{$problem_5 = 0;}
				if($_POST['v164']){$problem_6=1;}else{$problem_6 = 0;}
				if($_POST['v165']){$problem_7=1;}else{$problem_7 = 0;}
				if($_POST['v166']){$problem_8=1;}else{$problem_8 = 0;}
				if($_POST['v167']){$problem_9=1;}else{$problem_9 = 0;}
				if($_POST['v168']){$problem_10=1;}else{$problem_10 = 0;}
				if($_POST['v169']){$problem_11=1;}else{$problem_11 = 0;}
				if($_POST['v170']){$problem_12=1;}else{$problem_12 = 0;}
				if($_POST['v171']){$problem_13=1;}else{$problem_13 = 0;}
				if($_POST['v172']){$problem_14=1;}else{$problem_14 = 0;}
				if($_POST['v173']){$problem_15=1;}else{$problem_15 = 0;}
				if($_POST['v174']){$problem_16=1;}else{$problem_16 = 0;}
				if($_POST['v175']){$problem_17=1;}else{$problem_17 = 0;}
				if($_POST['v176']){$problem_18=1;}else{$problem_18 = 0;}
				if($_POST['v177']){$problem_19=1;}else{$problem_19 = 0;}
				if($_POST['v178']){$problem_20=1;}else{$problem_20 = 0;}
				if($_POST['v179']){$problem_21=1;}else{$problem_21 = 0;}
				if($_POST['v180']){$problem_22=1;}else{$problem_22 = 0;}
				if($_POST['v181']){$problem_23=1;}else{$problem_23 = 0;}
				if($_POST['v182']){$problem_24=1;}else{$problem_24 = 0;}
				
				if($_POST['v184']){$help_1=1;}else{$help_1 = 0;}
				if($_POST['v185']){$help_2=1;}else{$help_2 = 0;}
				if($_POST['v186']){$help_3=1;}else{$help_3 = 0;}
				if($_POST['v187']){$help_4=1;}else{$help_4 = 0;}
				if($_POST['v188']){$help_5=1;}else{$help_5 = 0;}
				if($_POST['v189']){$help_6=1;}else{$help_6 = 0;}
				if($_POST['v190']){$help_7=1;}else{$help_7 = 0;}
				if($_POST['v191']){$help_8=1;}else{$help_8 = 0;}
				if($_POST['v192']){$help_9=1;}else{$help_9 = 0;}
				if($_POST['v193']){$help_10=1;}else{$help_10 = 0;}	
				$table = 'question_tbl2_Type1';
		
				$data = array(
						'tbl2_id'=>$id,
						'problem_1'=>$problem_1,
						'problem_2'=>$problem_2,
						'problem_3'=>$problem_3,
						'problem_4'=>$problem_4,
						'problem_5'=>$problem_5,
						'problem_6'=>$problem_6,
						'problem_7'=>$problem_7,
						'problem_8'=>$problem_8,
						'problem_9'=>$problem_9,
						'problem_10'=>$problem_10,
						'problem_11'=>$problem_11,
						'problem_12'=>$problem_12,
						'problem_13'=>$problem_13,
						'problem_14'=>$problem_14,
						'problem_15'=>$problem_15,
						'problem_16'=>$problem_16,
						'problem_17'=>$problem_17,
						'problem_18'=>$problem_18,
						'problem_19'=>$problem_19,
						'problem_20'=>$problem_20,
						'problem_21'=>$problem_21,
						'problem_22'=>$problem_22,
						'problem_23'=>$problem_23,
						'problem_24'=>$problem_24,
						'help_1'=>$help_1,
						'help_2'=>$help_2,
						'help_3'=>$help_3,
						'help_4'=>$help_4,
						'help_5'=>$help_5,
						'help_6'=>$help_6,
						'help_7'=>$help_7,
						'help_8'=>$help_8,
						'help_9'=>$help_9,
						'help_10'=>$help_10
				);
				$con->insert($table,$data);
			}
			elseif($_POST['eq_type']==2)
			{
				if($_POST['v199']){$problem_1=1;}else{$problem_1 = 0;}
				if($_POST['v200']){$problem_2=1;}else{$problem_2 = 0;}
				if($_POST['v201']){$problem_3=1;}else{$problem_3 = 0;}
				if($_POST['v202']){$problem_4=1;}else{$problem_4 = 0;}
				if($_POST['v203']){$problem_5=1;}else{$problem_5 = 0;}
				if($_POST['v204']){$problem_6=1;}else{$problem_6 = 0;}
				if($_POST['v205']){$problem_7=1;}else{$problem_7 = 0;}
				if($_POST['v206']){$problem_8=1;}else{$problem_8 = 0;}
				if($_POST['v207']){$problem_9=1;}else{$problem_9 = 0;}
				if($_POST['v208']){$problem_10=1;}else{$problem_10 = 0;}
				if($_POST['v209']){$problem_11=1;}else{$problem_11 = 0;}
				if($_POST['v210']){$problem_12=1;}else{$problem_12 = 0;}
				if($_POST['v211']){$problem_13=1;}else{$problem_13 = 0;}
				if($_POST['v212']){$problem_14=1;}else{$problem_14 = 0;}
				if($_POST['v213']){$problem_15=1;}else{$problem_15 = 0;}
				if($_POST['v214']){$problem_16=1;}else{$problem_16 = 0;}
				if($_POST['v215']){$problem_17=1;}else{$problem_17 = 0;}
				if($_POST['v216']){$problem_18=1;}else{$problem_18 = 0;}
				if($_POST['v217']){$problem_19=1;}else{$problem_19 = 0;}
				
				if($_POST['v219']){$help_1=1;}else{$help_1 = 0;}
				if($_POST['v220']){$help_2=1;}else{$help_2 = 0;}
				if($_POST['v221']){$help_3=1;}else{$help_3 = 0;}
				if($_POST['v222']){$help_4=1;}else{$help_4 = 0;}
				if($_POST['v223']){$help_5=1;}else{$help_5 = 0;}
				if($_POST['v224']){$help_6=1;}else{$help_6 = 0;}
				if($_POST['v225']){$help_7=1;}else{$help_7 = 0;}
				if($_POST['v226']){$help_8=1;}else{$help_8 = 0;}
				if($_POST['v227']){$help_9=1;}else{$help_9 = 0;}
				$table = 'question_tbl2_Type2';
		
				$data = array(
						'tbl2_id'=>$id,
						'problem_1'=>$problem_1,
						'problem_2'=>$problem_2,
						'problem_3'=>$problem_3,
						'problem_4'=>$problem_4,
						'problem_5'=>$problem_5,
						'problem_6'=>$problem_6,
						'problem_7'=>$problem_7,
						'problem_8'=>$problem_8,
						'problem_9'=>$problem_9,
						'problem_10'=>$problem_10,
						'problem_11'=>$problem_11,
						'problem_12'=>$problem_12,
						'problem_13'=>$problem_13,
						'problem_14'=>$problem_14,
						'problem_15'=>$problem_15,
						'problem_16'=>$problem_16,
						'problem_17'=>$problem_17,
						'problem_18'=>$problem_18,
						'problem_19'=>$problem_19,
						'help_1'=>$help_1,
						'help_2'=>$help_2,
						'help_3'=>$help_3,
						'help_4'=>$help_4,
						'help_5'=>$help_5,
						'help_6'=>$help_6,
						'help_7'=>$help_7,
						'help_8'=>$help_8,
						'help_9'=>$help_9
				);
				$con->insert($table,$data);
			}
			elseif($_POST['eq_type']==3)
			{
				if($_POST['v233']){$problem_1=1;}else{$problem_1 = 0;}
				if($_POST['v234']){$problem_2=1;}else{$problem_2 = 0;}
				if($_POST['v235']){$problem_3=1;}else{$problem_3 = 0;}
				if($_POST['v236']){$problem_4=1;}else{$problem_4 = 0;}
				if($_POST['v237']){$problem_5=1;}else{$problem_5 = 0;}
				if($_POST['v238']){$problem_6=1;}else{$problem_6 = 0;}
				if($_POST['v239']){$problem_7=1;}else{$problem_7 = 0;}
				if($_POST['v240']){$problem_8=1;}else{$problem_8 = 0;}
				if($_POST['v241']){$problem_9=1;}else{$problem_9 = 0;}
				if($_POST['v242']){$problem_10=1;}else{$problem_10 = 0;}
				if($_POST['v243']){$problem_11=1;}else{$problem_11 = 0;}
				if($_POST['v244']){$problem_12=1;}else{$problem_12 = 0;}
				if($_POST['v245']){$problem_13=1;}else{$problem_13 = 0;}
				if($_POST['v246']){$problem_14=1;}else{$problem_14 = 0;}
				
				if($_POST['v248']){$help_1=1;}else{$help_1 = 0;}
				if($_POST['v249']){$help_2=1;}else{$help_2 = 0;}
				if($_POST['v250']){$help_3=1;}else{$help_3 = 0;}
				if($_POST['v251']){$help_4=1;}else{$help_4 = 0;}
				if($_POST['v252']){$help_5=1;}else{$help_5 = 0;}
				if($_POST['v253']){$help_6=1;}else{$help_6 = 0;}
				if($_POST['v254']){$help_7=1;}else{$help_7 = 0;}
				if($_POST['v255']){$help_8=1;}else{$help_8 = 0;}
				if($_POST['v256']){$help_9=1;}else{$help_9 = 0;}
				if($_POST['v257']){$help_10=1;}else{$help_10 = 0;}
				if($_POST['v258']){$help_11=1;}else{$help_11 = 0;}
				$table = 'question_tbl2_Type3';
		
				$data = array(
						'tbl2_id'=>$id,
						'problem_1'=>$problem_1,
						'problem_2'=>$problem_2,
						'problem_3'=>$problem_3,
						'problem_4'=>$problem_4,
						'problem_5'=>$problem_5,
						'problem_6'=>$problem_6,
						'problem_7'=>$problem_7,
						'problem_8'=>$problem_8,
						'problem_9'=>$problem_9,
						'problem_10'=>$problem_10,
						'problem_11'=>$problem_11,
						'problem_12'=>$problem_12,
						'problem_13'=>$problem_13,
						'problem_14'=>$problem_14,
						'help_1'=>$help_1,
						'help_2'=>$help_2,
						'help_3'=>$help_3,
						'help_4'=>$help_4,
						'help_5'=>$help_5,
						'help_6'=>$help_6,
						'help_7'=>$help_7,
						'help_8'=>$help_8,
						'help_9'=>$help_9,
						'help_10'=>$help_10,
						'help_11'=>$help_11
				);
				$con->insert($table,$data);
			}
			elseif($_POST['eq_type']==4)
			{
				if($_POST['v264']){$problem_1=1;}else{$problem_1 = 0;}
				if($_POST['v265']){$problem_2=1;}else{$problem_2 = 0;}
				if($_POST['v266']){$problem_3=1;}else{$problem_3 = 0;}
				if($_POST['v267']){$problem_4=1;}else{$problem_4 = 0;}
				if($_POST['v268']){$problem_5=1;}else{$problem_5 = 0;}
				if($_POST['v269']){$problem_6=1;}else{$problem_6 = 0;}
				if($_POST['v270']){$problem_7=1;}else{$problem_7 = 0;}
				if($_POST['v271']){$problem_8=1;}else{$problem_8 = 0;}
				if($_POST['v272']){$problem_9=1;}else{$problem_9 = 0;}
				if($_POST['v273']){$problem_10=1;}else{$problem_10 = 0;}
				if($_POST['v274']){$problem_11=1;}else{$problem_11 = 0;}
				if($_POST['v275']){$problem_12=1;}else{$problem_12 = 0;}
				if($_POST['v276']){$problem_13=1;}else{$problem_13 = 0;}
				if($_POST['v277']){$problem_14=1;}else{$problem_14 = 0;}
				if($_POST['v278']){$problem_15=1;}else{$problem_15 = 0;}
				if($_POST['v279']){$problem_16=1;}else{$problem_16 = 0;}
				if($_POST['v280']){$problem_17=1;}else{$problem_17 = 0;}
				if($_POST['v281']){$problem_18=1;}else{$problem_18 = 0;}
				if($_POST['v282']){$problem_19=1;}else{$problem_19 = 0;}
				
				if($_POST['v284']){$help_1=1;}else{$help_1 = 0;}
				if($_POST['v285']){$help_2=1;}else{$help_2 = 0;}
				if($_POST['v286']){$help_3=1;}else{$help_3 = 0;}
				if($_POST['v287']){$help_4=1;}else{$help_4 = 0;}
				if($_POST['v288']){$help_5=1;}else{$help_5 = 0;}
				if($_POST['v289']){$help_6=1;}else{$help_6 = 0;}
				if($_POST['v290']){$help_7=1;}else{$help_7 = 0;}
				if($_POST['v291']){$help_8=1;}else{$help_8 = 0;}
				if($_POST['v292']){$help_9=1;}else{$help_9 = 0;}
				if($_POST['v293']){$help_10=1;}else{$help_10 = 0;}	
				if($_POST['v294']){$help_11=1;}else{$help_11 = 0;}	
				if($_POST['v295']){$help_12=1;}else{$help_12 = 0;}	
				if($_POST['v296']){$help_13=1;}else{$help_13 = 0;}	
				$table = 'question_tbl2_Type4';
		
				$data = array(
						'tbl2_id'=>$id,
						'problem_1'=>$problem_1,
						'problem_2'=>$problem_2,
						'problem_3'=>$problem_3,
						'problem_4'=>$problem_4,
						'problem_5'=>$problem_5,
						'problem_6'=>$problem_6,
						'problem_7'=>$problem_7,
						'problem_8'=>$problem_8,
						'problem_9'=>$problem_9,
						'problem_10'=>$problem_10,
						'problem_11'=>$problem_11,
						'problem_12'=>$problem_12,
						'problem_13'=>$problem_13,
						'problem_14'=>$problem_14,
						'problem_15'=>$problem_15,
						'problem_16'=>$problem_16,
						'problem_17'=>$problem_17,
						'problem_18'=>$problem_18,
						'problem_19'=>$problem_19,
						'problem_20'=>$problem_20,
						'problem_21'=>$problem_21,
						'problem_22'=>$problem_22,
						'problem_23'=>$problem_23,
						'problem_24'=>$problem_24,
						'help_1'=>$help_1,
						'help_2'=>$help_2,
						'help_3'=>$help_3,
						'help_4'=>$help_4,
						'help_5'=>$help_5,
						'help_6'=>$help_6,
						'help_7'=>$help_7,
						'help_8'=>$help_8,
						'help_9'=>$help_9,
						'help_10'=>$help_10,
						'help_11'=>$help_11,
						'help_12'=>$help_12,
						'help_13'=>$help_13
				);
				$con->insert($table,$data);
			}
			elseif($_POST['eq_type']==5)
			{
				if($_POST['v302']){$problem_1=1;}else{$problem_1 = 0;}
				if($_POST['v303']){$problem_2=1;}else{$problem_2 = 0;}
				if($_POST['v304']){$problem_3=1;}else{$problem_3 = 0;}
				if($_POST['v305']){$problem_4=1;}else{$problem_4 = 0;}
				if($_POST['v306']){$problem_5=1;}else{$problem_5 = 0;}
				if($_POST['v307']){$problem_6=1;}else{$problem_6 = 0;}
				if($_POST['v308']){$problem_7=1;}else{$problem_7 = 0;}
				if($_POST['v309']){$problem_8=1;}else{$problem_8 = 0;}
				if($_POST['v310']){$problem_9=1;}else{$problem_9 = 0;}
				if($_POST['v311']){$problem_10=1;}else{$problem_10 = 0;}
				if($_POST['v312']){$problem_11=1;}else{$problem_11 = 0;}
				if($_POST['v313']){$problem_12=1;}else{$problem_12 = 0;}
				if($_POST['v314']){$problem_13=1;}else{$problem_13 = 0;}
				if($_POST['v315']){$problem_14=1;}else{$problem_14 = 0;}
				if($_POST['v316']){$problem_15=1;}else{$problem_15 = 0;}
				if($_POST['v317']){$problem_16=1;}else{$problem_16 = 0;}
				if($_POST['v318']){$problem_17=1;}else{$problem_17 = 0;}
				if($_POST['v319']){$problem_18=1;}else{$problem_18 = 0;}
				
				if($_POST['v321']){$help_1=1;}else{$help_1 = 0;}
				if($_POST['v322']){$help_2=1;}else{$help_2 = 0;}
				if($_POST['v323']){$help_3=1;}else{$help_3 = 0;}
				if($_POST['v324']){$help_4=1;}else{$help_4 = 0;}
				if($_POST['v325']){$help_5=1;}else{$help_5 = 0;}
				if($_POST['v326']){$help_6=1;}else{$help_6 = 0;}
				if($_POST['v327']){$help_7=1;}else{$help_7 = 0;}
				if($_POST['v328']){$help_8=1;}else{$help_8 = 0;}
				if($_POST['v329']){$help_9=1;}else{$help_9 = 0;}
				if($_POST['v330']){$help_10=1;}else{$help_10 = 0;}	
				if($_POST['v331']){$help_11=1;}else{$help_11 = 0;}	
				if($_POST['v332']){$help_12=1;}else{$help_12 = 0;}	
				if($_POST['v333']){$help_13=1;}else{$help_13 = 0;}	
				if($_POST['v334']){$help_14=1;}else{$help_14 = 0;}	
				if($_POST['v335']){$help_15=1;}else{$help_15 = 0;}	
				if($_POST['v336']){$help_16=1;}else{$help_16 = 0;}	
				if($_POST['v337']){$help_17=1;}else{$help_17 = 0;}	
				if($_POST['v338']){$help_18=1;}else{$help_18 = 0;}	
				if($_POST['v339']){$help_19=1;}else{$help_19 = 0;}	
				if($_POST['v340']){$help_20=1;}else{$help_20 = 0;}	
				if($_POST['v341']){$help_21=1;}else{$help_21 = 0;}	
				if($_POST['v342']){$help_22=1;}else{$help_22 = 0;}	
				
				$table = 'question_tbl2_Type5';
		
				$data = array(
						'tbl2_id'=>$id,
						'problem_1'=>$problem_1,
						'problem_2'=>$problem_2,
						'problem_3'=>$problem_3,
						'problem_4'=>$problem_4,
						'problem_5'=>$problem_5,
						'problem_6'=>$problem_6,
						'problem_7'=>$problem_7,
						'problem_8'=>$problem_8,
						'problem_9'=>$problem_9,
						'problem_10'=>$problem_10,
						'problem_11'=>$problem_11,
						'problem_12'=>$problem_12,
						'problem_13'=>$problem_13,
						'problem_14'=>$problem_14,
						'problem_15'=>$problem_15,
						'problem_16'=>$problem_16,
						'problem_17'=>$problem_17,
						'problem_18'=>$problem_18,
						'help_1'=>$help_1,
						'help_2'=>$help_2,
						'help_3'=>$help_3,
						'help_4'=>$help_4,
						'help_5'=>$help_5,
						'help_6'=>$help_6,
						'help_7'=>$help_7,
						'help_8'=>$help_8,
						'help_9'=>$help_9,
						'help_10'=>$help_10,
						'help_11'=>$help_11,
						'help_12'=>$help_12,
						'help_13'=>$help_13,
						'help_14'=>$help_14,
						'help_15'=>$help_15,
						'help_16'=>$help_16,
						'help_17'=>$help_17,
						'help_18'=>$help_18,
						'help_19'=>$help_19,
						'help_20'=>$help_20,
						'help_21'=>$help_21,
						'help_22'=>$help_22
				);
				$con->insert($table,$data);
			}
	}
	
 ?>
 <body onload="parent.$.fancybox.close();">บันทึกข้อมูลเสร็จสิ้น</body>
 