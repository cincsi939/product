<?php
include("../../../config/config_hr.inc.php");
include("../../../config/phpconfig.php");

$i=1;
foreach($_POST['order_table'] as $value){
	if($i>2){
		$sql="update salary set runno='".($i-2)."' where runid='$value'";
		@mysql_query($sql);
	}
	$i++;
}	
//print_r($_POST);

?>