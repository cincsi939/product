<?php
/**
* @comment ???
* @projectCode ???
* @tor ???
* @package ???
* @author noone
* @access ???
* @created 25/25/2525
*/

include('../lib/class.function.php');
include('../lib/function.php');
$con = new Cfunction();
$con->connectDB();
require_once("dr_doc2_function.php");	

if($_GET[ajax]){
	switch($_GET[req]){
		case 'getDistrict':  getDistrict($_GET[prov_id]); break;
		case 'getSubDistrict':  getSubDistrict($_GET[dist_id]); break;
		default: 
	}
	die;
}



