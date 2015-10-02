<?php
$_month_name = array("1"=>"มกราคม",  "2"=>"กุมภาพันธ์",  "3"=>"มีนาคม",   "4"=>"เมษายน",  "5"=>"พฤษภาคม",  "6"=>"มิถุนายน",   "7"=>"กรกฎาคม",  "8"=>"สิงหาคม",  "9"=>"กันยายน",   "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
if($_GET['chk_year']==2558){
	$ui ='';
	for($i=9;$i<=12;$i++){
		if($i == $_GET['chk_month']){
			$selected = 'selected';
		}else{
			$selected = '';
		}
					$ui .= '<option value="'.$i.'" '.$selected.'>'.$_month_name[$i].'</option>';
			}
			echo $ui;
}else{
	$ui ='';
	for($i=1;$i<=12;$i++){
		if($i == $_GET['chk_month']){
			$selected = 'selected';
		}else{
			$selected = '';
		}
					$ui .= '<option value="'.$i.'" '.$selected.'>'.$_month_name[$i].'</option>';
			}
			echo $ui;
}

?>