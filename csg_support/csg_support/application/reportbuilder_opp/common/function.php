<?php
/**
 * @comment function date
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    24/06/2014
 * @access     public
 */
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."); 
$ThaiWeekDay = array("Monday"=>"จันทร์","Tuesday"=>"อังคาร","Wednesday"=>"พุธ", "Thursday"=>"พฤหัสบดี","Friday"=>"ศุกร์","Saturday"=>"เสาร์","Sunday"=>"อาทิตย์");

function date_eng2thai($date,$add=0/*เพิ่ม/ลดปี(543)*/,$dismonth="L"/*รูปแบบเดือน */,$disyear="L"/*รูปแบบปี */,$format='all'/*m|d|y*/){
	global $monthname,$shortmonth;
	if($date != '' && $date != '--' && $date!='0000-00-00'){
		$date = substr($date,0,10);
		$arr = explode('-',$date);
		$year = $arr[0];
		$month = $arr[1];
		$day = $arr[2];
		if($dismonth == 'S'){
			$month = $shortmonth[$month*1] ; 
		}else{
			$month = $monthname[$month*1] ; 
		}
		$xyear = 0;
		if($disyear == 'S'){
			$xyear = substr(($year+$add),2,2);
		}else{
			$xyear = ($year+$add);
		}
		if($format != 'all'){
			$format_ex = explode('|',$format);
			$rs = '';
			if(count($format_ex)>0){
				foreach($format_ex as $key_ex=>$val_ex){
					if($val_ex=='d'){
						$rs .= ($day*1);
					}else if($val_ex=='m'){
						$rs .= ' '.$month.' ';
					}else if($val_ex=='y'){
						$rs .= ($xyear);
					}	
				}
			}else{
				if($val_ex == 'd'){
					$rs .= ($day*1);
				}else if($val_ex == 'm'){
					$rs .= ' ' .$month.' ';
				}else if($val_ex == 'y'){
					$rs .= ($xyear);
				}	
			}	
		}else{
			$rs = ($day*1).' '.$month.' '.($xyear);
		}
		return $rs ;
	}else{
		return '';
	}
}
function date_thai2eng($date,$add=0){
	global $monthname ,$shortmonth;
	if($date!=''){
		$date=substr($date,0,10);
		list($day,$month,$year) = split('[/.-]', $date);        
		return ($year+$add).'-'.$month.'-'.($day);
	}else{
		return '';
	}
}
 
//เลขไทยเป็นอาราบิค
function numberThaiToArabic($num=''){
	$sNum = array('๐','๑','๒','๓','๔','๕','๖','๗','๘','๙');
	$rNum = array('0','1','2','3','4','5','6','7','8','9');
	return str_replace($sNum, $rNum, $num);
}
//อาราบิคเป็นเลขไทย
function numberArabicToThai($num=''){
	$sNum = array('0','1','2','3','4','5','6','7','8','9');
	$rNum = array('๐','๑','๒','๓','๔','๕','๖','๗','๘','๙');
	return str_replace($sNum, $rNum, $num);
}

// ฟังชั่นก์ แสดงผล วัน เดือน ปี ไทย
function  showthaidate($number,$type_day=''){

	$digit=array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
	$num=array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
	$number = explode(".",$number);
	//echo '<pre>';print_r($number);
	$c_num[0]=$len=strlen($number[0]);
	$c_num[1]=$len2=strlen($number[1]);
	$convert='';
	if($len > 2){
		$a1 = $len - 1 ;
		$f_digit = substr($number[0],$a1,1);
	}
	//คิดจำนวนเต็ม
	
	for($n=0;$n< $len;$n++){	
		$c_num[0]--;
		$c_digit=substr($number[0],$n,1);
		
		
		if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';
		
		if($len>1 && $len <= 2){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
		}else if($len>3){
			if($f_digit == 0){
				if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
			}else{
				if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
			}
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
		}
		
		
		if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='สอง';
		if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
		if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
		if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='ยี่'; 
		
		$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
	}
	$convert .= "";
	if($number[1]==''){$convert .= "";}
	//คิดจุดทศนิยม
	for($n=0;$n< $len2;$n++){ 
		$c_num[1]--;
		$c_digit=substr($number[1],$n,1);
		if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
		if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='สอง';
		if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='สอง'; 
		if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
		$convert.=$digit[$c_digit];
		$convert.=$num[$c_num[1]]; 
	}
	
	if($number[1]!='')$convert .= '';
	if($type_day!=''&&$number[0]=='01'){
		$convert='หนึ่ง';
	}
	return $convert;
}

function month_nameth($date_m){
	#### ชื่อเดือนภาษาไทย	
	$month_nameth = array("01"=>"มกราคม",
						"02"=> "กุมภาพันธ์",
						"03"=> "มีนาคม",
						"04"=>"เมษายน",
						"05"=> "พฤษภาคม",
						"06"=>"มิถุนายน",
						"07"=>"กรกฎาคม",
						"08"=>"สิงหาคม",
						"09"=> "กันยายน",
						"10"=>"ตุลาคม",
						"11"=> "พฤศจิกายน",
						"12"=>"ธันวาคม");
	return $month_nameth["$date_m"];
}

function set_format($date,$add=0){
	$new_birthday_label=explode("-",$date);
	$date_new = $new_birthday_label[2].'/'.$new_birthday_label[1].'/'.($new_birthday_label[0]+$add);
	return ($date=='')?'':$date_new;
}
// @modify Phada Woodtikarn 28/06/2014 เพิ่มหาอายุกี่ปีกี่เดือน
function age_yy_mm($date){
	if($date!="" and $date != "--" and $date!='0000-00-00'){
		$diff = dateDiff($date, date('Y-m-d'));
		if($diff['year'] == 0){
			if($diff['month'] != 0){
				$date = $diff['month'].' เดือน';
			}
		}else{
			if($diff['month'] != 0){
				$date = $diff['year'].' ปี '.$diff['month'].' เดือน';
			}else{
				$date = $diff['year'].' ปี';
			}
		}
	}
	return $date;
}
// @end
function dateDiff($d1,$d2) {
	$mday = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
	$re_d1 = str_replace('-','',$d1);
	$re_d2 = str_replace('-','',$d2);
	if($re_d1 > $re_d2){
			$x1 = explode("-", $d2);
			$x2 = explode("-", $d1);
	}else{
			$x1 = explode("-", $d1);
			$x2 = explode("-", $d2);
	}

	// จำนวนปี
	$ny = intval($x2[0]) - intval($x1[0]);

	if (intval($x1[1]) <= intval($x2[1])){  //เดือน ตัวตั้งมากกว่า
		$nm = intval($x2[1]) - intval($x1[1]);
	}else{
		$nm = intval($x2[1]) + 12 - intval($x1[1]);
		$ny --; // ลดปีลง
	}

	if (intval($x1[2]) <= intval($x2[2])){  //วัน ตัวตั้งมากกว่า
		$nd = intval($x2[2]) - intval($x1[2]);
	}else{
		$mday[2] = date("d",mktime (0,0,0,3,0,intval($x2[0]) ));  // หาจำนวนวันของเดือนกุมภาพันธ์
		$xmonth = intval($x2[1]) - 1;  //เดือนก่อนนี้
		if ($xmonth <= 0){
			$xday = 31; 
		}else{
			$xday = $mday[$xmonth];
		}

		$nd = intval($x2[2]) + $xday - intval($x1[2]);
		$nm --; // ลดเดือน

		if ($nm < 0){ // เดือนแรก (ลดแล้วเหลือ 0)
			$nm = 11;
			$ny--;
		}
	}
	if($re_d1 > $re_d2){
			$ret = array("day" => (($nd > 0)?'-'.$nd:$nd),"month" =>(($nm > 0)?'-'.$nm:$nm), "year" => (($ny > 0)?'-'.$ny:$ny) );
	}else{
			$ret = array("day" => $nd,"month" => $nm, "year" => $ny);
	}
	return $ret;
}
?>