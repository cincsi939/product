<?php
	session_start();
	header("Content-Type: text/html; charset=windows-874"); 
	//header("content-type: application/x-javascript; charset=tis-620");
  
include("../../../common/common_competency.inc.php");
include("../../../common/class-date-format.php");

$b_birth='';
if($_GET['id']){
		$day='';
		$month='';
		$year='';
		$arr=explode("/",$_GET['tempdate']);
		if(strlen($arr[0])==2){
				$day=$arr[0];
				$month=$arr[1];
				$year=($arr[2]*1)-543;
		}else if(strlen($arr[0])==4){
				$day=$arr[2];
				$month=$arr[1];
				$year=($arr[0]*1)-543;
		}
		
		$b_day1 = new date_format;
		$b_birth= $b_day1->show_date($_GET['tempStr'],$year."-".$month."-".$day);
}
echo $b_birth;
	
?>				