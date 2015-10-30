<?
//Swap date format in 2006-06-12 to 12/06/2006
$arr_type_create = array("0"=>"รูปแบบการสร้างปกติ","1"=>"ปรับเพิ่มอัตราเงินเดือนแบบร้อยละหรือการคัดลอกโฟล์ไฟล์");
$image_approve = "<img src=\"images/accept.png\" width=\"16\" height=\"16\" alt=\"โฟรไฟล์ได้รับอนุมัติจากผู้แทนสำนักงาน ก.ค.ศ.แล้ว\">";

function swapdate($temp){
	$kwd = strrpos($temp, "/");
	if($kwd != ""){
		$d = explode("/", $temp);
		$ndate = $d[2]."-".$d[1]."-".$d[0];
	} else { 		
		$d = explode("-", $temp);
		$ndate = $d[2]."/".$d[1]."/".$d[0];
	}
	return $ndate;
}

//function ที่ใช้แสดงวันที่แบบเต็ม ใช้ใน edocument
function daythai($temp){
if($temp != "0000-00-00"){

	$month 	= array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); 
	$num 	= explode("-", $temp);			
	if($num[0] == "0000"){
	  $date 	= "ไม่ระบุ";
	}else if($num[0] > 2500){
	  $tyear = $num[0];
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}else{
	  $tyear = $num[0] +  543;
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}

} else {
	$date = "ไม่ระบุ";
}	
	return $date;
}

function shortday($temp){
if($temp != "0000-00-00"){

	$month 	= array("ม.ค.", "ก.พ.", "มี.ค.", "ม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); 
	$num 	= explode("-", $temp);			
	if($num[0] == "0000"){
	  $date 	= "ไม่ระบุ";
	} else  if($num[0] > 2500){
	
	$tyear = $num[0] ;
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	

	}else{
	  $tyear = $num[0] +  543;
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}

} else {
	$date = "ไม่ระบุ";
}	
	return $date;
}

function monthly2how($tempa,$tempb){
if(($tempa != "0000-00-00") && ($tempb != "0000-00-00")){

$month 	= array(NULL,"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); 
	$numa 	= explode("-", $tempa);
	$numb 	= explode("-", $tempb);
	$mka=mktime(0, 0, 0, $numa[1], $numa[2], ($numa[0]+$yearadd));
	$mkb=mktime(0, 0, 0, $numb[1], $numb[2], ($numb[0]+$yearadd));


	$ma=date("m",$mka);
	$ya=date("Y",$mka);

	$mb=date("m",$mkb);
	$yb=date("Y",$mkb);



	$texta=$month[intval($ma)]." พ.ศ.".intval($ya+543);
	$textb=$month[intval($mb)]." พ.ศ.".intval($yb+543);

	if($texta==$textb){$textall=$texta;}else{$textall=$texta." ถึง ".$textb;}

} else {
	$textall = "ไม่ระบุ";
}	
	return $textall;
}

function longtimehow($tempa,$tempb){
if(($tempa != "0000-00-00") && ($tempb != "0000-00-00")){

$month 	= array(NULL,"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); 
	$numa 	= explode("-", $tempa);
	$numb 	= explode("-", $tempb);
	$mka=mktime(0, 0, 0, $numa[1], $numa[2], ($numa[0]+$yearadd));
	$mkb=mktime(0, 0, 0, $numb[1], $numb[2], ($numb[0]+$yearadd));

$def_time=$mkb-$mka+(3600*24*10);
$yage=$def_time/(365*24*3600);
$mage=($def_time%(365*24*3600))/(30*24*3600);

	if($def_time>=(30*24*3600)){
	$textall="(";
	if($yage>=1){ $textall.= " ".intval($yage)." ปี ";}
	if(($mage>=1) && ($mage<12)){ $textall.= " ".intval($mage)." เดือน ";}
	$textall.=")";
	}
} else {
	$textall = "";
}	
	return $textall;
}

//function ที่ใช้แสดงวันที่แบบเต็ม
function fulldate($temp)
{
	$date = explode(" ", $temp);
	$temp = $date[0];
	$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$num = explode("-", $temp);		
	$day = intval($num[2]);
	$tyear = $num[0] + 543;
	$date = "<font class=\"normal_black\">".$day."</font>&nbsp;".$month[$num[1] - 1 ]."&nbsp;พ.ศ.&nbsp;<font class=\"normal_black\">".$tyear."</font>";	
	return $date;
}

function remove_zero($temp) 
{
	$num_chk = strlen($temp);
	if($num_chk == 2) {	
		$num_1 = substr($temp, 0, 1);  
		if($num_1 == 0){ 
			$rnum = substr($temp, 1, 2); 
		} else { 
			$rnum = $temp; 
		}
	} else { 
	$rnum = $temp; 
	}
	return $rnum;
}

function add_zero($temp) 
{
	$num_chk = strlen($temp);
	if($num_chk == 1) {	
		$rnum = "0".$temp;
	} else {
		$rnum = $temp;
	}
	return $rnum;
}

function upload($path, $file, $file_name, $type){
$file_ext 	= strtolower(getFileExtension($file_name));		
global $height;
global $width;

if($type == "all"){

	$approve = "y";
	
}elseif($type == "img"){

	$chk_img = ($file_ext != "jpg" and $file_ext != "gif" and $file_ext != "jpeg"  and $file_ext != "png") ? "n" : "y" ;
	if($chk_img == "y"){
	
		$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
		$height 		= (!isset($height) || $height == "") ? 801 : $height ; 
		$img_size 	= GetImageSize($file);  
		
		if(($img_size[0] >= $width) || ($img_size[1] >= $height)) {
			$approve 	= "n";
			$status[0]	= "error_scale";
		}else{
			$approve 	= "y";
		}
		
	} else {
		$approve 	= "n";
		$status[0]	= "error_img";
	}  
	
} elseif($type == "fla") {

		$approve 	= ($file_ext != "swf") ? "n" : "y" ;
	
} elseif($type == "doc") {

	$chk_doc = ($file_ext != "doc" and $file_ext != "xls" and $file_ext != "pdf" and $file_ext != "zip" and $file_ext != "rar") ? "n" : "y" ;
	if($chk_doc == "y"){
		$approve 	= "y";
	} else {
		$approve 	= "n";
		$status[0]	= "error_doc";
	}

} else {

	$approve 	= "n";
	$status[0]	= "error_type";
	
}

/* -------------------------------------------------------------Check file Exists  */
if($type == "doc"){	
	$file_n		= chk_file($file_name, $path);
	$filename	= $path.$file_n;
} elseif($type == "img" || $type == "fla" || $type == "all") {
	$file_n		= random(6).".".$file_ext;
	$filename 	= $path.$file_n;	
}
$status[1] = $file_n;

/* ---------------------------------------------------------Begin Uploading File */
if($approve == "y"){

	if($file_size >= "2000000") {
		$status[0] = "error_size";		
	} else {	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){	 
				$status[0] = "error_upload";
			} else {
				$status[0] = "complete";
			}
			unlink($file);  					
		} else { 	$status[0] = "error_cmod";	}	
	}
	
}	
return $status;

}

//Function Delete File
function del_file($temp){
	if(file_exists($temp)){ unlink($temp); }
}

//Function check file exist
function chk_file($file_name, $folder){
	if(file_exists($folder.$file_name)){ 
		
		$f 				= explode(".", $file_name);
		$f_name 	= $f[0];	
		$f_ext 		= $f[1];		

		//find number in () 
		$f_otag 		= (strrpos($f[0], "(") + 1);	
		$f_ctag 		= (strrpos($f[0], ")") - $f_otag) ;		
		$f_num		= substr($f_name, $f_otag, $f_ctag);
		
		//if is number just increse it 		
		if(is_numeric($f_num)){ 	
			$filename 	= substr($f[0],0, strrpos($f[0], "("))."(".($f_num + 1).").".$f[1];					
		} else { 
			$filename 	= $f[0]."(1).".$f[1]; 
		}
		
	} else {	 
			$filename 		= $file_name; 
	}
		
return $filename;	
}

//Status of Uploading
function upload_status($temp){
global $height;
global $width;
$button 		= "<hr size=\"1\"><button name=\"button\" style=\"width:90px;\" onClick=\"history.go(-1);\">Back</button>";
$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
$height 		= (!isset($height) || $height == "") ? 801 : $height ; 

	if($temp == "error_scale"){	
		$msg = "<br><b class=\"warn\">Error</b> : ขนาดของภาพเกินจากที่กำหนดไว้<br>ขนาดรูปภาพต้องไม่เกิน $height x $width<br>";		
	} elseif($temp == "error_img") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>รูปแบบของ file ไม่ถูกต้อง<br>รูปภาพต้องมีนามสกุลเป็น jpg, jpeg และ gif เท่านั้น<br>";		
	} elseif($temp == "error_type") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>รูปแบบของ file ที่นำเข้ามาไม่ถูกต้อง<br>";		
	} elseif($temp == "error_size") 	{	
		$msg = "<br><b class=warn>Error</b><br>รูปขนาดของ file มากกว่าที่ระบบกำหนด<br>ไฟล์ต้องมีขนาดไม่เกิน 800 Kilo Bytes<br>";
	} elseif($temp == "error_upload") {	
		$msg = "<br><b class=\"warn\">Warning</b><br>พบข้อผิดพลาดในการ Upload เข้าสู่่ระบบ<br>โปรดติดต่อผู้ดูแล<br>";			
	} elseif($temp == "error_cmod")	{	
		$msg = "<br><b class=\"warn\">Warning</b><br>พบข้อผิดพลาดในการ Upload เข้าสู่่ระบบ<br>โปรดตรวจสอบ CHMOD ของ Folder<br>";				
	} elseif($temp == "error_doc"){	
		$msg = "<br><b class=\"warn\">Warning</b><br>รูปแบบไฟล์ไม่ถูกต้อง<br>เอกสารต้องมีนามสกุลเป็น doc, xls และ pdf เท่านั้น<br>";			
	} 
$msg	 = ($msg != "") ? $msg.$button : "" ;
return $msg;
}


//Random Generater
function random($length){
	
	$template = "1234567890abcdefghijklmnopqrstuvwxyz";  
    
	settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
    	$b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

// function ที่ใช้แสดงรายละเอียดต่าง ๆ ของ files ที่จะทำการ upload
function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

//Use in AJAX for decode
function post_decode($string) {
	$str = $string;
    $res = "";
    for ($i = 0; $i < strlen($str); $i++) {
    	if (ord($str[$i]) == 224) {
        	$unicode = ord($str[$i+2]) & 0x3F;
            $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
            $unicode |= (ord($str[$i]) & 0x0F) << 12;
            $res .= chr($unicode-0x0E00+0xA0);
            $i += 2;
       	} else {
            $res .= $str[$i];
        }
	}
    return $res;
}

// ส่วนของการแสดงข้อมูลการแบ่งหน้า
function devide_page($all, $record, $kwd){
$per_page		= 11;
$page_all 		= ceil($all / $per_page);
global $page;

if($all >= 1){

	$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$table	= $table."<tr valign=\"top\" align=\"right\">";
	$table	= $table."<td width=\"80%\" align=\"left\">&nbsp;";
		
//first Eleven Page
if($page <= $per_page){

	$max		=	($all <= $per_page) ? $all : $per_page ; 			
	for($i=1;$i<=$max;$i++) 
	{
		if($i != $page){ 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$i.$kwd."\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}
		
	if($max < $all){ 	
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($i++).$kwd."\" style=\"text-decoration:none;\">></a>&nbsp;"; 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$all.$kwd."\" style=\"text-decoration:none;\">>></a>&nbsp;"; 
	}
	unset($max,$i);
	
} elseif($page > $per_page) {

	$min 	= $page - 5;		
	$max		= (($page + 5) >=  $all) ? $all : $page + 5 ;
	$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=1".$kwd."\" style=\"text-decoration:none;\"><b><<</b></a>&nbsp;";
	$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($min--).$kwd."\" style=\"text-decoration:none;\"><b><</b></a>&nbsp;";
	for($i=$min;$i<=$max;$i++) 
	{
		if($i != $page){ 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=$i$kwd\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}	
	
	if($max < $all){
		$table	= $table."&nbsp;<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($max++).$kwd."\" style=\"text-decoration:none;\"><b>></b></a>";
		$table	= $table."&nbsp;<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$all.$kwd."\" style=\"text-decoration:none;\"><b>>></b></a>&nbsp;"; 
	}	
}                  
	if ($max > 1){ //ถ้ามากกว่า 1 หน้า
		$table   = $table." <A HREF=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&e=1000000$kwd\" >แสดงทั้งหมด</A>";
	}

	$table	= $table."</td>";
	$table	= $table."<td width=\"10%\">".number_format($record, 0, "", ",")."&nbsp;รายการ&nbsp;</td>";
	$table	= $table."<td width=\"10%\">".number_format($all, 0, "", ",")."&nbsp;หน้า&nbsp;</td>";
	$table	= $table."</tr>";
	$table	= $table."</table>";
}
 	return $table;
}


function cpdate($First, $Second)
{

	$first_date 			= explode ("-", $First);
	$second_date 		= explode ("-", $Second);

	$intFirstDay 			= $first_date[2];
	$intFirstMonth 		= $first_date[1];
	$intFirstYear 			= $first_date[0];

	$intSecondDay 		= $second_date[2];
	$intSecondMonth	= $second_date[1];
	$intSecondYear 		= $second_date[0];

	$intDate1Jul 			= gregoriantojd($intFirstMonth, $intFirstDay, $intFirstYear);
	$intDate2Jul 			= gregoriantojd($intSecondMonth, $intSecondDay, $intSecondYear);

$diff_date 	= $intDate1Jul - $intDate2Jul + 1;
//$diff_date	= ($diff_date <= 0) ? "<font color=red>".abs($diff_date)."</font>" : "<font color=green>".$diff_date."<font>";
$diff_date	= ($diff_date <= 0) ? "<font color=red>".($diff_date)."</font>" : "<font color=green>".$diff_date."<font>";
return $diff_date;
}

function swapyear($temp, $lang){
	if($temp != ""){
		
		$d	 		= explode("-", $temp);
		$year	= ($lang == "t") ? $d[0] + 543 : $d[0] - 543 ;
		return $year."-".$d[1]."-".$d[2];	
	} else {
		return false;
	}
}

//Function Trim data
function trimtxt($temp, $val){

	$txtchk = strlen($temp);
	if($txtchk > $val){ 	
		$txt= substr($temp,0 ,$val); 
		$txt = $txt."...";		
	} else { 
		$txt = $temp; 
	}
	return $txt;
}

//Email function
function sendmail($mail_to, $mail_subject, $mail_msg, $mail_from){

	$to 			= $mail_to;
	$subject 	= $mail_subject;
	$msg 		= "
	<head>
	<title> HTML content</title>
	</head>
	<body>".$mail_msg."</body>
	</html>
	";
	$headers 	= "From: ".$mail_from."\n";
	$headers	.= "Reply-To: ".$mail_from."\n";
	$headers	.= "Content-Type: text/html; charset=tis-620"; 
	mail("$to", "$subject", "$msg", "$headers");

}

function showpic($getfile_att,$getproblem,$getproblem_result,$reportid){
	if($getfile_att){
		$msg1 = "<a href=\"daily_file_attach.php?id=$reportid\"><img src=\"images/attach16.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg1 ="";
	}	
	if($getproblem){
		$msg2 = "<a href=\"daily_report_detailview.php?id=$reportid\"><img src=\"../../images_sys/alert.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg2 ="";
	}
	if($getproblem_result){
		$msg3 = "<a href=\"daily_report_detailview.php?id=$reportid\"><img src=\"images/alert_red.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg3 ="";
	}
	$picview = "$msg1|||$msg2|||$msg3";
	return $picview;
}




function cut_dec($get_dec,$xlen){ // ฟังก์ชันตัดตำแหน่งทศนิยม
	$arr_dec = explode(".",$get_dec);
	if($arr_dec[1] != ""){
		$txt_show = $arr_dec[0].".".(substr($arr_dec[1],0,$xlen));
	}else{
		$txt_show = $get_dec.".00";
	}
return $txt_show;
}

##################   log 
function get_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips, $ip);
			$ip = false;
		}
	for($i = 0; $i < count($ips); $i++){
		if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
			if(version_compare(phpversion(), "5.0.0", ">=")){
				if(ip2long($ips[$i]) != false){
					$ip = $ips[$i];
					break;
				}
			} else {
				if(ip2long($ips[$i]) != - 1){
					$ip = $ips[$i];
					break;
				}
			}
		}
	}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}//end function get_real_ip()
########  add log

function add_log_msalary($subject,$action){
global $dbnamemaster;
	$uname = $_SESSION[session_username];
	if($uname != ""){$uname = $uname;}else{ $uname = "SYSTEM";}
	$ip = get_real_ip();
	$sql = "insert into tbl_salary_log_profile(server_ip,time_update,user_id,subject,action)values('$ip',now(),'$uname','$subject','$action')";
	//echo $sql." ::  $dbname<br>";
	mysql_db_query($dbnamemaster,$sql);
}//end add_log_msalary($subject,$action){

############   function cal persent salary
###  ฟังก์ชั่นคำนวณค่าเปอร์เซ็นขั้นเงินเดือน หลักโดยผลคำนวณที่ออกมา ปัดขึ้นให้เป็น หลัก 10  เช่น 8952.3  ปัดเป็น  8960
function cal_persent_salary($money,$persent){
	if($persent == 0){ // กรณีมีการกำหนดเปอร์เซ็นเป็น 0 จะไม่มีการเพิ่มเงินเดือน
		return $money;
	}else{
		$temp_val = ceil(($money*$persent)/100);
		$val = $money+$temp_val;
	//	echo " val = ".$val."<br>";
		$sub_digi = substr($val,-1);
		if($sub_digi > 0){
			$add_digi = 10-$sub_digi;
			$result_val = $val+$add_digi;	
		}else{
			$result_val = $val;	
		}
		return $result_val;
		}//end if($persent == 0){
} // end function cal_persent_salary(){
### end  ###  ฟังก์ชั่นคำนวณค่าเปอร์เซ็นขั้นเงินเดือน หลักโดยผลคำนวณที่ออกมา ปัดขึ้นให้เป็น หลัก 10  เช่น 8952.3  ปัดเป็น  8960
####  ฟังก์ชั่นสร้าง profile โดยอัตโนมัต
function create_profile_auto($profile_id){
global $dbnamemaster;
	$sql_profile = "SELECT * FROM tbl_salary_profile WHERE profile_id='$profile_id'";
	$result_profile = mysql_db_query($dbnamemaster,$sql_profile);
	$rs_profile = mysql_fetch_assoc($result_profile);
	$persent = $rs_profile[add_persent];
	###  ข้อมูล profile ต้นแบบ
	$sql_p1 = "SELECT * FROM  tbl_salary_profile WHERE profile_id='$rs_profile[profile_original]'";
	$result_p1 = mysql_db_query($dbnamemaster,$sql_p1);
	$rs_p1 = mysql_fetch_assoc($result_p1);
	### ข้อมูลระดับต้นแบบ
	$sql_p2 = "SELECT * FROM tbl_salary_radub WHERE profile_id='$rs_p1[profile_id]' ORDER BY salary_radub_id ASC";
	$sql_p2 = mysql_db_query($dbnamemaster,$sql_p2);
	while($rs_p2 = mysql_fetch_assoc($sql_p2)){
			##  บันทึกข้อมูลระดับต้นแบบ
				$sql_insert_radub = "INSERT INTO tbl_salary_radub(radub_label,profile_id)VALUES('$rs_p2[radub_label]','$profile_id')";
				$result_insert_radub = mysql_db_query($dbnamemaster,$sql_insert_radub);
				$last_radub_id = mysql_insert_id(); // หา id ล่าสุดข้อการเพิ่มระดับใหม่
			### end บันทึกข้อมูลต้นแบบ
				###  เชือมโยงข้อมูลระดับ detail 
			$sql_p3 = "SELECT * FROM tbl_salary_math_radub WHERE profile_id='$rs_p1[profile_id]' AND salary_radub_id='$rs_p2[salary_radub_id]'";
			$result_p3 = mysql_db_query($dbnamemaster,$sql_p3);
			while($rs_p3 = mysql_fetch_assoc($result_p3)){
				## บันทึกข้อมูลเชื่อมโยงระดับ
					$sql_insert_radub1 = "INSERT INTO tbl_salary_math_radub(profile_id,salary_radub_id,radub_id)VALUES('$profile_id','$last_radub_id','$rs_p3[radub_id]')";
					$result_insert_radub1 = mysql_db_query($dbnamemaster,$sql_insert_radub1);
				## end บันทึกข้อมูลเชื่อมโยงระดับ	
			} // end while($rs_p3 = mysql_fetch_assoc($result_p3)){
			
			#### ข้อมูลเงินเดือนในแต่ละระดับ
			$sql_p4 = "SELECT * FROM tbl_salary_level WHERE salary_radub_id='$rs_p2[salary_radub_id]'";
			$result_p4 = mysql_db_query($dbnamemaster,$sql_p4);
			while($rs_p4 = mysql_fetch_assoc($result_p4)){
				$new_level = $rs_p4[level]; // ระดับ
				$new_money = cal_persent_salary($rs_p4[money],$persent);  // อัตราเงินใหม่
				# บันทึกข้อมูลเงินเดือนใหม่
				$sql_insert_money = "INSERT INTO tbl_salary_level(level,money,salary_radub_id)VALUES('$new_level','$new_money','$last_radub_id')";
				$result_insert_money = mysql_db_query($dbnamemaster,$sql_insert_money);
			}//end 	while($rs_p4 = mysql_fetch_assoc($result_p4)){
			####  end 	ข้อมูลเงินเดือนในแต่ละระดับ
	}//end 	while($rs_p2 = mysql_fetch_assoc($sql_p2)){
	
	
	
}//end function create_profile_auto(){
#### end  ฟังก์ชั่นสร้าง profile โดยอัตโนมัต

####  ฟังก์ชั่นลบ profile โดยอัตโนมัต
function del_profile_auto($profile_id){
global $dbnamemaster;
$sql_del = "DELETE FROM tbl_salary_math_radub  WHERE profile_id='$profile_id'";
@mysql_db_query($dbnamemaster,$sql_del);

	$sql_p2 = "SELECT * FROM tbl_salary_radub WHERE profile_id='$profile_id'";
	$sql_p2 = mysql_db_query($dbnamemaster,$sql_p2);
	while($rs_p2 = mysql_fetch_assoc($sql_p2)){
				$sql_del1 = "DELETE FROM tbl_salary_radub  WHERE salary_radub_id='$rs_p2[salary_radub_id]'";
				@mysql_db_query($dbnamemaster,$sql_del1);
				$sql_del2 = "DELETE FROM tbl_salary_level WHERE salary_radub_id='$rs_p2[salary_radub_id]'";
				@mysql_db_query($dbnamemaster,$sql_del2);
	}//end 	while($rs_p2 = mysql_fetch_assoc($sql_p2)){

}//end function  del_profile_auto($profile_id){
#### end  ฟังก์ชั่นลบ profile โดยอัตโนมัต

function check_status_approve($profile_id){
	global $dbnamemaster;
	$sql_c = "SELECT COUNT(profile_id) AS num1  FROM tbl_salary_profile WHERE profile_id='$profile_id' AND active_status='1'";
	$result_c = mysql_db_query($dbnamemaster,$sql_c);
	$rs_c = mysql_fetch_assoc($result_c);
	return $rs_c[num1];
}

function dis_menu_approve($salary_radub_id){
	global $dbnamemaster;
	$sql_c1 = "SELECT count(tbl_salary_profile.profile_id) as num2
FROM
tbl_salary_profile
Inner Join tbl_salary_radub ON tbl_salary_profile.profile_id = tbl_salary_radub.profile_id
Inner Join tbl_salary_level ON tbl_salary_radub.salary_radub_id = tbl_salary_level.salary_radub_id
where 
tbl_salary_profile.active_status='1' AND tbl_salary_level.salary_radub_id='$salary_radub_id'";
//echo $sql_c1;
	$result_c1 = mysql_db_query($dbnamemaster,$sql_c1);
	$rs_c1 = mysql_fetch_assoc($result_c1);
	return $rs_c1[num2];
}

function check_in_data($profile_id){
	global $dbnamemaster;
	$sql_in = "SELECT COUNT(profile_id) as num_in FROM tbl_salary_radub WHERE profile_id='$profile_id'";
	$result_in = mysql_db_query($dbnamemaster,$sql_in); 
	$rs_in = mysql_fetch_assoc($result_in);
	return $rs_in[num_in];
}

#########  function หาระดับสูงสุดของแต่ละแท่ง
function search_max_row_radub($profile_id){
global $dbnamemaster;
	$sql_max = "SELECT count(tbl_salary_level.level) as num  FROM tbl_salary_profile
Inner Join tbl_salary_radub ON tbl_salary_profile.profile_id = tbl_salary_radub.profile_id
Inner Join tbl_salary_level ON tbl_salary_radub.salary_radub_id = tbl_salary_level.salary_radub_id
WHERE tbl_salary_profile.profile_id =  '$profile_id' GROUP BY tbl_salary_level.salary_radub_id";
$result_max = mysql_db_query($dbnamemaster,$sql_max);
$a=0;
while($rs_max = mysql_fetch_assoc($result_max)){
	$arr_max[$a]  = $rs_max[num];
	$a++;
}
	$count_max = max($arr_max);
	return $count_max;
}//end function search_max_row_radub(){


function search_max_level($profile_id){
	global $dbnamemaster;
	$sql_mlevel = "SELECT max(tbl_salary_level.level) as max_lv  FROM tbl_salary_profile
Inner Join tbl_salary_radub ON tbl_salary_profile.profile_id = tbl_salary_radub.profile_id
Inner Join tbl_salary_level ON tbl_salary_radub.salary_radub_id = tbl_salary_level.salary_radub_id
WHERE tbl_salary_profile.profile_id =  '$profile_id'";
	$result_mlevel = mysql_db_query($dbnamemaster,$sql_mlevel);
	$rs_mlevel = mysql_fetch_assoc($result_mlevel);
	return $rs_mlevel[max_lv];
}


function GetTypeMistaken($get_mistaken){
	$db = DB_USERENTRY;
	$sql = "SELECT * FROM validate_mistaken  WHERE mistaken_id='$get_mistaken'";
	$result = mysql_db_query($db,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[mistaken];
}
?>