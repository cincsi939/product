<style>
	body{
		margin:0px auto;
	}
</style>
<?php
/**
* @comment หน้าหลักในส่วนขอการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
* @projectCode P2
* @tor
* @package core
* @author Eakkasit Kamwong
* @access private
* @created 01/10/2015
*/
include('../survey/header.php');

if(isset($_GET['p']) && $_GET['p'] != ''){
	include($_GET['p'].'.php');	
}else{
	include('dashboard.php');	
}

?>