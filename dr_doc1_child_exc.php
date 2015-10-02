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
 session_start();
 require_once("../../../../<?php echo APP_SUPPORT; ?>/application/survey/lib/class.function.php");
 include "../../../../<?php echo APP_SUPPORT; ?>/common/php_class/class_calculate_kpi.php";	
 $con = new Cfunction();
 $con->connectDB();
 	foreach($_GET as $name => $value)
	{		
		$VAR[$name]=$value;
	}
	
	$sql = " SELECT
					tbl_prename.prename_th AS prename,
					tbl_prename.gender AS gender_code,
					IF( tbl_prename.gender = '1','ªÒÂ','Ë­Ô§' ) AS gender
				FROM tbl_prename
				WHERE tbl_prename.id = '".$VAR['prename']."' ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
 if( $_GET['from'] == 'add' ){
	 
	 $sql = "
	 INSERT INTO eq_child SET
	 eq_idcard = '".$VAR['idcard']."',
	eq_code_prename = '".$VAR['prename']."',
	eq_prename = '".$row['prename']."',
	eq_firstname = '".$VAR['firstname']."',
	eq_lastname = '".$VAR['surname']."',
	eq_bdoc_no = '".$VAR['bdoc_no']."',
	eq_bdoc_staff = '".$VAR['bdoc_staff']."',
	eq_docDate = '".$VAR['docDate']."',
	eq_birthPlace = '".$VAR['birthPlace']."',
	eq_presStatus = '".$VAR['presStatus']."',
	eq_stayPlace = '".$VAR['stayPlace']."',
	eq_comment= '".$VAR['comment']."',
	eq_address = '".$VAR['address1']."',
	eq_village = '".$VAR['address2']."',
	eq_subvillage = '".$VAR['address8']."',
	eq_alley = '".$VAR['address9']."',
	eq_street = '".$VAR['address3']."',
	eq_code_parish = '".$VAR['address6']."',
	eq_parish = getCCAA(LEFT('".$VAR['address6']."',6)),
	eq_code_district = '".$VAR['address5']."',
	eq_district = getCCAA(LEFT('".$VAR['address5']."',4)),
	eq_code_province = '".$VAR['address4']."',
	eq_province = getCCAA(LEFT('".$VAR['address4']."',2)),
	eq_phone = '".$VAR['address7']."',
	eq_code_gender = '".$row['gender_code']."',
	eq_gender = '".$row['gender']."',
	eq_birthday = '".$VAR['birthDate']."',
	eq_mother_idcard = '".$VAR['idcard_mother']."',
	eq_mobilephone = '".$VAR['eq_mobilephone']."',
	eq_postcode = '".$VAR['eq_postcode']."',
	eq_date_create = NOW()";
	
	$rsConn = mysql_query($sql);	
	if($rsConn){
		echo 'ok';
	}else{
		echo mysql_error();
	}
 }else{
 	 $sql = "
	 UPDATE eq_child SET
	 eq_idcard = '".$VAR['idcard']."',
	eq_code_prename = '".$VAR['prename']."',
	eq_prename = '".$row['prename']."',
	eq_firstname = '".$VAR['firstname']."',
	eq_lastname = '".$VAR['surname']."',
	eq_bdoc_no = '".$VAR['bdoc_no']."',
	eq_bdoc_staff = '".$VAR['bdoc_staff']."',
	eq_docDate = '".$VAR['docDate']."',
	eq_birthPlace = '".$VAR['birthPlace']."',
	eq_presStatus = '".$VAR['presStatus']."',
	eq_stayPlace = '".$VAR['stayPlace']."',
	eq_comment = '".$VAR['comment']."',
	eq_address = '".$VAR['address1']."',
	eq_village = '".$VAR['address2']."',
	eq_subvillage = '".$VAR['address8']."',
	eq_alley = '".$VAR['address9']."',
	eq_street = '".$VAR['address3']."',
	eq_code_parish = '".$VAR['address6']."',
	eq_parish = getCCAA(LEFT(".$VAR['address6'].",6)),
	eq_code_district = '".$VAR['address5']."',
	eq_district = getCCAA(LEFT(".$VAR['address5'].",4)),
	eq_code_province = '".$VAR['address4']."',
	eq_province = getCCAA(LEFT(".$VAR['address4'].",2)),
	eq_phone = '".$VAR['address7']."',
	eq_code_gender = '".$row['gender_code']."',
	eq_gender = '".$row['gender']."',
	eq_birthday = '".$VAR['birthDate']."',
	eq_mobilephone = '".$VAR['eq_mobilephone']."',
	eq_postcode = '".$VAR['eq_postcode']."',
	eq_mother_idcard = '".$VAR['idcard_mother']."'
	WHERE eq_id = '".$VAR['eq_id']."' ";
	
	$rsConn = mysql_query($sql);	
	if($rsConn){
		echo 'ok';
	}else{
		echo $sql.mysql_error();
	}
 }

 ?>