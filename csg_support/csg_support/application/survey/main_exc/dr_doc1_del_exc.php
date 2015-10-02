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
	 
	 $con->delete('eq_child',"eq_idcard = ".$_GET['id']." AND eq_mother_idcard = ".$_GET['mother_id']);
 ?>
  <body onLoad="alert('ลบข้อมูลเสร็จสิ้น'); window.location.href='../question_form.php?frame=dr_doc1&id=<?php echo $_GET['mother_id'];?>' "></body>