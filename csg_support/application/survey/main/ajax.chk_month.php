<?php
$_month_name = array("1"=>"���Ҥ�",  "2"=>"����Ҿѹ��",  "3"=>"�չҤ�",   "4"=>"����¹",  "5"=>"����Ҥ�",  "6"=>"�Զع�¹",   "7"=>"�á�Ҥ�",  "8"=>"�ԧ�Ҥ�",  "9"=>"�ѹ��¹",   "10"=>"���Ҥ�", "11"=>"��Ȩԡ�¹",  "12"=>"�ѹ�Ҥ�");
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