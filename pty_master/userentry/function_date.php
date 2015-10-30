<?
########### นับจำนวนวันระหว่างวันที่ ######################
function  GetNumDayOfDate($start_d,$end_d){
	$numday = (strtotime($end_d)-strtotime($start_d))/86400; 
	return $numday;
}///end function  GetNumDay($start_d,$end_d){

########### end  นับจำนวนวันระหว่างวันที่ ###################
	function LastMonth($yymm){			
				$xbasedate = strtotime("$yymm");
				 $xdate = strtotime("-1 month",$xbasedate);
				 $xsdate = date("Y-m",$xdate);// วันถัดไป
				 return $xsdate;
				 
	}//end function LastMonth(){		
	
	
function ShowDayBetween($date1,$date2){
	
	$numcount = GetNumDayOfDate($date1,$date2);
	
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i <= $numcount ; $i++){
				$xbasedate = strtotime("$date1");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($yymm){
	

?>