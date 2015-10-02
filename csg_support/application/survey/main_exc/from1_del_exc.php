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
	 
	 $con->delete('eq_person',"eq_idcard = '".$_GET['id']."' AND eq_id = '".$_GET['eq_id']."' AND eq_year='".(date('Y')+543)."' AND eq_round = 1");
	 //$con->delete('eq_person',"eq_partner_id = '".$_GET['id']."' AND eq_year='".(date('Y')+543)."' AND eq_round = 1");
	 $con->delete('eq_var_data',"pin = '".$_GET['id']."' AND eq_id = '".$_GET['eq_id']."' AND number_action = 1");
	 
	 echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../dashboard.php">';
 ?>