<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Suwat.k
 * @created  24/09/2014
 * @access  private
 */
include("../../config/config_host.php"); #��ҧ�Ҥ�� Define
 
 session_destroy();
 
  header("location: ".HOMEPAGE_MAIN);
exit();
 
?>