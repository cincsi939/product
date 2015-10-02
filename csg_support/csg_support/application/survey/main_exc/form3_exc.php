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
	
	$trees = 3;
	
	$PIN = $_POST['pin']; // รหัสบัตรประชาชน
	$id_card= $_POST['pin']; // รหัสบัตรประชาชน
	foreach($_POST as $name => $value)
	{		
		//echo $name;
		if(ereg("v",$name) == true)
		{ 
			$n=str_replace("v","",$name);  // ค่าอื่นๆตาม choice
			$VAR[$n]=$value;
		}
	}
	
	$status=($status)?$status:"add";
	
	$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value from eq_var_data where siteid=1 AND form_id=3 AND pin='".$PIN."'";
	$results = $con->select($sql);
	
	if(count($results)==0)
	{
		$con->delete('eq_var_data','pin = '.$PIN.' AND form_id=3');
	}
	
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
	
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../question_form.php?frame=form4&id='.$PIN.'">';
 ?>
 