<?
	function find_month($num_month){
			switch ($num_month) {
				case "01":
					$num_month =  1; 					break;
				case "02":
					$num_month =  2;					break;
				case "03":
					$num_month =  3;					break;					
				case "04":
					$num_month =  4; 					break;
				case "05":
					$num_month =  5;					break;
				case "06":
					$num_month =  6;					break;		
				case "07":
					$num_month =  7; 					break;
				case "08":
					$num_month =  8;					break;
				case "09":
					$num_month =  9;					break;		
			}	// end swish
	$arr_month =  array("",���Ҥ�,����Ҿѹ��,�չҤ�,����¹,����Ҥ�,�Զع�¹,�á�Ҥ�,�ԧ�Ҥ�,�ѹ��¹,���Ҥ�,��Ȩԡ�¹,�ѹ�Ҥ�);
	return $arr_month[$num_month] ;
}
	function find_shortmonth($num_month){
			switch ($num_month) {
				case "01":					$num_month =  1; 					break;
				case "02":					$num_month =  2;					break;
				case "03":					$num_month =  3;					break;					
				case "04":					$num_month =  4; 					break;
				case "05":					$num_month =  5;					break;
				case "06":					$num_month =  6;					break;		
				case "07":					$num_month =  7; 					break;
				case "08":					$num_month =  8;					break;
				case "09":					$num_month =  9;					break;		
				default: 
					$num_month =  $num_month ;					break;
			}	// end swish
	$arr_month =  array("","�.�. ", "�.�."  , "��.�.  "," ��.�.  ", "�.�. " , "��.�."  , "�.�. " , "�.�. " , "�.�.  "," �.�. " , "�.�. " , "�.�." );
	return $arr_month[$num_month] ;
}

	function find_quarter($num_quarter){
	$arr_quarter =  array(0,"���Ҥ�-�ѹ�Ҥ�","���Ҥ�-�չҤ�","����¹-�Զع�¹","�á�Ҥ�-�ѹ��¹");
	return $arr_quarter[$num_quarter] ;
}

	function set_redcolor($val1){
		if ($val1 <   0) {
				$msg1 =  "<b> <font color=#FF0000>  $val1 </font> </b>";
		}else{
				$msg1 =  "<b> $val1 </b>";
		}
	return $msg1 ;
}


	function subval($inputval){ 
	if ($inputval == 0){
	$msg1= "0";
	}else if (($inputval == "")) {
	$msg1= "N/A";

	}else{
	$msg1= number_format($inputval,2);
	}
	return $msg1 ;
	}

	function subval_2($inputval){
	if (($inputval == 0)) {
	$msg1= "0";
	}else if ($inputval == ""){
	$msg1= "N/A";
	}else{
	$msg1= number_format($inputval);
	}
	return $msg1 ;
	}

	function subval_3($inputval){
	if (($inputval == "")){
	$msg1= "N/A";
	}else{
	$msg1= $inputval;
	}
	return $msg1 ;
	}

	function naval($inputval){
	if ($inputval == 0){
	$msg1= "0";
	}else if ($inputval == ""){
	$msg1= "N/A";
	}else{
	$msg1= number_format($inputval,2);
	}
	return $msg1 ;
	}
	function naval_2($inputval){
	if ($inputval == "0"){
	$msg1= "0";
	}else if ($inputval == "") {
	$msg1= "N/A";
	}else{
	$msg1= number_format($inputval);
	}
	return $msg1 ;
	}
	function subnum($inputval){
	if (($inputval == "") or ($inputval == 0)) {
	$msg1= "0";
	}else{
	$msg1= $inputval;
	}
	return $msg1 ;
	}

function double_explode($first_break,$second_break,$string){
	global $NM_row , $NM_col ;
   	$array = explode($first_break, $string); 
	$j = count($array);
   for ($k=0; $k < count($array); $k++) 
   { 
       $count = substr_count($array[$k],$second_break); 
       if ($count>0) 
       { 
           $array[$k] = explode($second_break, $array[$k]); 
       } 
   } 
	$NM_row  = $j ;
	$NM_col  = $k+1 ;
   	return $array ; 
}


	function sub1($inputval){
	if (($inputval == "") or ($inputval == 0)) {
	$msg1= "-";
	}else{
	$msg1= number_format($inputval);
	}
	return $msg1 ;
	}

	function sub1_2($inputval){
	if (($inputval == "") or ($inputval == 0)) {
	$msg1= "-";
	}else{
	$msg1= number_format($inputval,2);
	}
	return $msg1 ;
	}

	function subzero($inputval){
	if ($inputval == "0"){
	$msg1= "0";
	}else if ($inputval == "")  {
	$msg1= "N/A";
	}else{
	$msg1= number_format($inputval,3);
	}
	return $msg1 ;
	}

	function subzero_np($inputval){
	if ($inputval == "0"){
	$msg1= "0";
	}else if ($inputval == "")  {
	$msg1= "N/A";
	}else{
	$msg1= number_format($inputval);
	}
	return $msg1 ;
	}
	// =============================== Catate By
	function subn_per_a($inputval){
	if ($inputval == 0){
	$msg1= "0";	
	}else if ($inputval == "")   {
	$msg1= "<font color=red>N/A</font>";
	}else{
	$msg1= number_format($inputval);
	}
	return $msg1 ;
	}
	// =============================== Catate By char 10/11/2547 22.00
	function chk_na($val01,$decimal_nm){										
	if (($val01 == "9999") or ($val01 == "N/A") or ($val01 == "n/a")) {
		$na_val = "N/A" ;
	}else if (($val01 == "") or ($val01 == "-"))  {
		$na_val = "-" ;
	}else{
		$na_val = number_format($val01,$decimal_nm)      ;
	}
	return $na_val ; 
}  // end function
	// =============================== Catate By char 1/11/2005 07.09
	function substrna($val01){										
	if (($val01 == "") or ($val01 == "N/A") or ($val01 == "n/a")) {
		$na_val = "N/A" ;
	}else{
		$na_val = $val01     ;
	}
	return $na_val ; 
}  // end function
	// =============================== Catate By char  1/24/2005  23.54
function swich_feq($db_feq){	
	switch ($db_feq) {		
		case null:
			$str_result  =  "N/A";          break;
		case 0:
			$str_result  =    " �Ѵ�纤������� ";          break;
		case 1: 
			$str_result  =   "  �����͹ ";          break; 
		case 3: 
			$str_result  =    "  ��������  ";          break; 		
		case 6: 
			$str_result  =   "  ��¤��觻�";          break; 		
		case 12: 
			$str_result  =   " ��»�  ";          break; 		
		case 24: 
			 $str_result  =  " ��� 2 ��   ";          break;
		
	}
return $str_result  ;
}  // end  function swich_feq

// =============================== Catate By char 28/04/2005 22.20
function compute_ratio($val01,$val_base){										
	if ($val_base > 0){
			$ratio01 = number_format((($val01 - $val_base)/$val_base),2) ;
			if ($ratio01 <0 ){
				$ratio01 =  	abs($ratio01);
				$ratio01 =  "<font color='#FF0000'>$ratio01</span>"  ;
			}
	}else{
			$ratio01 = "N/A" ;
	}
	return $ratio01 ; 
}  // end function compute_ratio
// =============================== Catate By char 7/7/2548 13.16
function compute_percent($val01,$val_base){										
	if ($val_base > 0){
			$percent = number_format((($val01 * 100)/ $val_base),2) ;
	}else{
			$ratio01 = "n/a" ;
	}
	return $percent ; 
}  // end function compute_percent
//======== Create BY PAIROJ 7/7/2548 ==============================================

if (!function_exists('SetDecimal')){
function SetDecimal($val,$dec){
	if ($dec == 2){ // 00
		$val = number_format($val,2,".",",");
	}else if ($dec == 1){ // 11
		$val = number_format($val,1,".",",");
	}else if ($dec == 3){ // 000
		$val = number_format($val,3,".",",");
	}else if ($dec == 0){ // None
		$val = number_format($val,0,".",",");
	}
	return $val;
}

function SetNumberFormat($val,$nformat,$dec){
	if ($nformat == 0){ //NATUARAL
		if ((is_null($val) OR ($val == "" )) AND ($val != "0")){
			$val = "N/A";
		}else if (is_numeric($val)){
			$val = SetDecimal($val,$dec);
		}
	}else if ($nformat == 1){ // NORMAL
		/*
			�	.� Null �� .�ʴ�� .� N/A �մ��
			� .� 0 �� .�ʴ�� .� 0 �մ��
			� .ҵ� �ź � .�� ᴧ
			� .Һǡ � .�չ����Թ
		*/
		if (is_null($val)){  // Negative
			$val = "<font color='BLACK'>N/A</font>";
		}else if ($val == 0){
			$val = "<font color='BLACK'>" . SetDecimal($val,$dec) . "</font>";
		}else if ($val < 0){
			$val = "<font color='RED'>" . SetDecimal($val,$dec) . "</font>";
		}else{ // > 0
			$val = "<font color='BLUE'>" . SetDecimal($val,$dec) . "</font>";
		}
	}else if ($nformat == 2){ //INVERT
		/*
		- ��� Null ��� �ʴ��� N/A �մ��
		- ��� 0 ��� .�ʴ��� 0 �մ��
		- ��ҵԴź �� .�չ���Թ
		- ��Һǡ �� .�� ᴧ
		*/
		if ((is_null($val) OR ($val == "" )) AND ($val != "0")){  // Negative
			$val = "<font color='BLACK'>N/A</font>";
		}else if ($val == 0){
			$val = "<font color='BLACK'>" . SetDecimal($val,$dec) . "</font>";
		}else if ($val < 0){
			$val = "<font color='BLUE'>" . SetDecimal($val,$dec) . "</font>";
		}else{ // > 0
			$val = "<font color='RED'>" . SetDecimal($val,$dec) . "</font>";
		}
	}
	return $val;
}

}
//======================================================

################################################################################
############ ��㹡����ʶҹС�� upload file ������ QPassport   Version �����  �� �������
function  chkupload_status1($d_limit,$time_check ,  $d_now){
$d_upload = $time_check  ; 
############$d_limit		1111338000	�ѹ�ú��˹���Ѻ��ا������
############$d_upload		1111424400	�ѹ���ӡ�û�Ѻ��ا������ 
############$d_now		1112202000	�ѹ���Ѩ�غѹ 
/*                
-	1 ����ͧ	Waiting				�͡�û�Ѻ��ا���������� 24 ������� 
-	2 ����Թ	In progress			���ѧ����������ҧ�͡�ù���Ң����ŵ���ͺ���� 
	3 ����		Delay					��Ѻ��ا������������� ����ó� �����ѧ��˹�  
-	4 ᴧ		No progress		�ѧ����ա�û�Ѻ��ا������ ��Фú��˹� ����
	5 ����		Updated				��Ѻ��ا�����������������ó� ���㹡�˹� 
	$d_limit	            �ѹ�ú��˹���Ѻ��ا������
	$d_now             �ѹ���Ѩ�غѹ 
	$d_upload            �ѹ���ӡ�û�Ѻ��ا������ 
         d_limit :: -1 _ d_now :: 1122829200 _ d_upload:: 1122051600
*/     
	if (   ($d_limit == $d_now)    ){  // waiting
		$status_img = "status1.gif";   
	}else if ((($d_limit  > $d_now ) and ($d_upload == -1 )) or ( $d_limit == -1 and  $d_upload == -1) ) { //in progress
		$status_img = "status2.gif";     
// 1  && �Ѿ��ѧ�ѹ��˹�  &&  d_limit ����˹�
	}else  if ((  1 ) AND ($d_limit < $d_upload) AND ($d_limit  != -1) ){  //  delay
		$status_img = "status3.gif";  		 
//         ����ѹ����Ѿ��Ŵ����  and  ��˹��ѹ��Ѻ��ا���� ) ||  ������Ѿ��Ŵ���
	}else  if ((($d_now > $d_limit )&&( $d_limit != -1 )&&($d_upload  == -1) )||($d_upload  == -1) ) {  // no progress
		$status_img = "status4.gif";   
//  (�Ѿ��Ŵ��ѹ��� ���͡�͹ date limit && ���Ѿ��Ŵ) || ����ա�á�˹��ѹ�ú��˹���Ѻ��ا
	}else   if ((($d_limit >= $d_upload) AND ( $d_upload > 0))  OR ( ($d_limit == -1)   ))  {  //updated ���͹�  �Ѿ��Ŵ����ҷ���˹� ���� �Ѿ��Ŵ������������˹����һ�Ѻ��ا������
		$status_img = "status5.gif";    

	}

// 		echo "<hr> 2 (( $d_limit  > $d_now ) and ($d_upload != -1 )) OR ( $d_limit == -1 and $d_upload == -1) <hr> ";

	return  $status_img  ;
	}

################################################################3
function nesdbcompute_ratio ($n_yearval , $c_yearval ){
	$return_val = (($n_yearval  - $c_yearval )/ $c_yearval ) ;
	return $return_val ;
}
####################################################	
	function find_month_budget($num_month){ # 8/4/2549 By char 
			switch ($num_month) {
				case "01":					$num_month =  1; 					break;
				case "02":					$num_month =  2;					break;
				case "03":					$num_month =  3;					break;					
				case "04":					$num_month =  4; 					break;
				case "05":					$num_month =  5;					break;
				case "06":					$num_month =  6;					break;		
				case "07":					$num_month =  7; 					break;
				case "08":					$num_month =  8;					break;
				case "09":					$num_month =  9;					break;		
			}	// end swish
	$arr_month =  array("0",���Ҥ�,��Ȩԡ�¹,�ѹ�Ҥ�,���Ҥ�,����Ҿѹ��,�չҤ�,����¹,����Ҥ�,�Զع�¹,�á�Ҥ�,�ԧ�Ҥ�,�ѹ��¹);
	return $arr_month[$num_month] ;
}


	function getstryy_budget($int_budget){ # 8/4/2549 By char 
			switch ($int_budget) {
				case "0": $str_month[0] =  "�ջ�ԷԹ"; $str_month[1] =  "�.�.";							break;
				case "1": $str_month[0] =  "�է�����ҳ";	 $str_month[1] =  "������ҳ";		break;
				default:    $str_month[0] =  "�ջ�ԷԹ";$str_month[1] =  "�.�.";		 					break;
			}	// end swish
	return $str_month  ;   
	}
	function getqq_month($num_quarter,$yy_budget){
		if ($yy_budget==1){
			$arr_quarter =  array(0,"�ѹ�Ҥ�","�չҤ�","�Զع�¹","�ѹ��¹");
		}else{
			$arr_quarter =  array(0,"�չҤ�","�Զع�¹","�ѹ��¹","�ѹ�Ҥ�" );	
		} 
	return $arr_quarter[$num_quarter] ;
}

################################################################ 19/4/2549 ��
### time stamp MySQL :::: 2006 04 19 18 27 34
function convert_timestamp($timestamp){
	$thyy = substr($timestamp,0,4)+ 543 ;
	$mm = substr($timestamp,4,2)  ;		$mm = trim($mm) ;
	$dd = substr($timestamp,6,2)  ;			$dd = trim($dd) ; 
	$HH = substr($timestamp,8,2)  ;		$HH= trim($HH) ;
	$min = substr($timestamp,10,2)  ;		$min= trim($min);
	$sec = substr($timestamp,12,2)  ;		$sec = trim($sec) ;
	$arr_time = array($dd,$mm,$thyy,$HH,$min,$sec) ;  
return $arr_time ;  # 	Array ( [0] => 19 [1] => 04 [2] => 2549 [3] => 18 [4] => 39 [5] => 26 ) 
## echo $tmp[0] .find_shortmonth($tmp[1]) . $tmp2 ;
}	


function convert_timestamp2($date1){
	$arrdate1 = explode(" ",$date1) ;     #  2549-03-26 17:52:27  
	$arrdate11 = explode("-",$arrdate1[0]) ;     #  2549-03-26	
	$thyy = (int)$arrdate11[0]  ;   	if ($thyy < 2299) { $thyy+=543 ; }  
	$mm =  (int)$arrdate11[1]   ;  	
	$dd  =   (int)$arrdate11[2]   ;  		
	$arrdate11 = explode(":",$arrdate1[1]) ;     # 17:52:27  
	$HH =   (int)$arrdate11[0]  ;  
	$min =   (int)$arrdate11[1]  ;  	
	$sec =   (int)$arrdate11[2]  ; 
	$arr_time = array($dd,$mm,$thyy,$HH,$min,$sec) ;  
return $arr_time ;  # 	Array ( [0] => 19 [1] => 04 [2] => 2549 [3] => 18 [4] => 39 [5] => 26 ) 
## echo $tmp[0] .find_shortmonth($tmp[1]) . $tmp2 ;
}	

function  convert_date1($date001){  // convert  form format   2004-11-25  (YYYY-MM-DD)
				$syear = substr ("$date001", 0,4); // ��
//				$syear = $syear + 543 ;
				$smm =  number_format(substr ("$date001", 5,2))  ; // ��͹
				$sday = (int)substr ("$date001", 8,2); // �ѹ
				$convert_date1 = "  $sday   ".find_shortmonth($smm)." $syear  ";		
				return $convert_date1 ;
}

?>
