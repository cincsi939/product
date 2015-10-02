<?php
function getDataBase(){
	return $db_name = 'dcy_master';
}

function getTable(){
	return 'ccaa';
}

function parseToXML($htmlStr) {
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return iconv('tis-620','utf-8',$xmlStr);
}

function getColor($max_sc, $sc_val){
	//echo $max_sc.", ".$sc_val;
	if($max_sc>8){
		$rate_sc = ($sc_val/$max_sc)*100;
		if($rate_sc<=0){
			$color = '#CCCCCC';
		}else if($rate_sc<50){
			$color = '#d80600';
		}else if($rate_sc<70){
			$color = '#ff8b00';
		}else if($rate_sc<90){
			$color = '#fff800';
		}else if($rate_sc<100){
			$color = '#a0fb00';
		}else{
			$color = '#005e00';
		}
	}else{
		$rate_sc = $sc_val;
		if($rate_sc<=0){
			$color = '#CCCCCC';
		}else if($rate_sc<2){
			$color = '#d80600';
		}else if($rate_sc<4){
			$color = '#ff8b00';
		}else if($rate_sc<6){
			$color = '#fff800';
		}else if($rate_sc<=8){
			$color = '#a0fb00';
		}else{
			$color = '#005e00';
		}
	}
	return $color;
}

function setRateData($max_sc){
	$arr_rate = array(50, 70,90,100);
	$arrSetRate = array();
	if($max_sc>8){
		foreach($arr_rate as $k=>$rate){
			$s_rate = ($arr_rate[$k-1])?$arr_rate[$k-1]:0;
			$e_rate = ($arr_rate[$k])?$arr_rate[$k]:0;
			$sval = ($s_rate>0)?(($s_rate/100)*$max_sc)-1:1;
			$eval = ($e_rate/100)*$max_sc;

			$arrSetRate[] = array('s_rate'=>intval($sval), 'e_rate'=>intval($eval) );
		}
	}else{
		$arrSetRate[] = array('s_rate'=>1, 'e_rate'=>2);
		$arrSetRate[] = array('s_rate'=>3, 'e_rate'=>4);
		$arrSetRate[] = array('s_rate'=>5, 'e_rate'=>6);
		$arrSetRate[] = array('s_rate'=>7, 'e_rate'=>8);
	}
	return $arrSetRate;
}

?>
