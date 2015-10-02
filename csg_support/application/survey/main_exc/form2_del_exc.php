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
	 error_reporting(E_ALL ^ E_NOTICE);
	 require_once("../lib/class.function.php");
	 include "../../../common/php_class/class_calculate_kpi.php";	
	 $con = new Cfunction();
	 $con->connectDB();
	 
	 $con->delete('eq_person',"eq_idcard = ".$_GET['id']." AND eq_year='".(date('Y')+543)."' AND eq_round = 1");
	 $con->delete('eq_var_data',"pin_idcard = ".$_GET['id']." AND  form_id = 2 AND number_action = 1");
 ?>
  <body onload="parent.$.fancybox.close();">บันทึกข้อมูลเสร็จสิ้น</body>