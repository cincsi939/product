<?php
$ui ='';
	for($i=1;$i<=$_GET['chk_day'];$i++){
		if($i == $_GET['selected_day']){
			$selected = 'selected';
		}else{
			$selected = '';
		}
					$ui .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			echo $ui;
?>