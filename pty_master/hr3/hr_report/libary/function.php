<?
function savelog($act){
	$stamp		= date("Y-m-d H:i:s");
	$ip 			= get_real_ip();	
	$sql 			= " insert into `user_log` set user = '".$_SESSION[user_name]."', stamp = '$stamp', ip = '$ip', action='".$act."'; ";
	$result		= mysql_query($sql)or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());	
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
	
		$width 		= (!isset($width) || $width == "") ? 501 : $width ; 
		$height 		= (!isset($height) || $height == "") ? 501 : $height ; 
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
if($type == "doc" || $type == "fla" || $type == "all"){	
	$file_n		= chk_file($file_name, $path);
	$filename	= $path.$file_n;
} elseif($type == "img") {
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
$width 		= (!isset($width) || $width == "") ? 501 : $width ; 
$height 		= (!isset($height) || $height == "") ? 501 : $height ; 

	if($temp == "error_scale"){	
		$msg = "<br><b class=\"warn\">Error</b> : ขนาดของภาพเกินจากที่กำหนดไว้<br>ขนาดรูปภาพต้องไม่เกิน 500 x 500<br>";		
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

//Show Department Name
function depname($temp){
if($temp != ""){

	$result = mysql_query(" select name from `user` where user = '$temp' ")or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);	
	$name = $rs[name];
	mysql_free_result($result);
	
} else {
	$name = "ไม่ระบุ" ;
}
return $name;
}

//Swap date format in 2543-06-12 to 2000-06-12
function swapdate($temp){
	$d			= explode("-",$temp);
	$ndate 	= ($d[0] - 543)."-".$d[1]."-".$d[2];
	return $ndate;
}

function swapInput($temp){
	$d			= explode("-",$temp);
	$ndate 	= ($d[0] + 543)."-".$d[1]."-".$d[2];
	return $ndate;
}

//Remove Img tag in data
function noTag($temp){
	$data	= strip_tags($temp, "<img ");
	$data	= strip_tags($temp, "<table ");
	$data	= strip_tags($temp, "<font ");
	$data	= strip_tags($temp, "<span ");	
	$data	= strip_tags($temp, "<p ");		
	return $data;
}

//Trim length Text 
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

//Image Fix Scale
function fiximg($img, $width, $height){
if($img == ""){
	$pic = NULL;
} else {
	$img_size 	= GetImageSize($img);  		
	if(($img_size[0] >= $width) || ($img_size[1] >= $height)) {
		$pic 	= frameimg("<img src=\"".$img."\" width=\"".$width."\" border=\"0\">");
	} else {
		$pic	= frameimg("<img src=\"".$img."\" border=\"0\">");
	}	
}	
	return $pic;
}

//Image Frame
function frameimg($temp){
if(file_exists("images/web/border01.gif")){
	$image = "images/web/";
}else{
	$image = "../images/web/";
}
	$fr = "<table width=\"50\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">";
    $fr = $fr."<tr>";
    $fr = $fr."<td height=\"7\"><img src=\"".$image."border01.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."<td width=\"50\" height=\"7\" background=\"".$image."border04.gif\"><img src=\"".$image."border04.gif\" height=\"7\" /></td>";
    $fr = $fr."<td height=\"7\"><img src=\"".$image."border06.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."</tr>";
    $fr = $fr."<tr>";
    $fr = $fr."<td width=\"7\" background=\"".$image."border02.gif\"></td>";
    $fr = $fr."<td width=\"50\">".$temp."</td>";
    $fr = $fr."<td width=\"7\" background=\"".$image."border07.gif\"></td>";
    $fr = $fr."</tr>";
	$fr = $fr."<tr>";
	$fr = $fr."<td width=\"7\" height=\"7\"><img src=\"".$image."border03.gif\" width=\"7\" height=\"7\" /></td>";
	$fr = $fr."<td width=\"50\" height=\"7\" background=\"".$image."border05.gif\"><img src=\"".$image."border05.gif\" height=\"7\" /></td>";
    $fr = $fr."<td width=\"7\" height=\"7\"><img src=\"".$image."border08.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."</tr>";
    $fr = $fr."</table>";
	
	return $fr;
}

//Table Inside Tooltip
function tooltip($temp){

	$tab = "<table width=240 cellspacing=1 cellpadding=0 bgcolor=#eeeeee>";
	$tab = $tab."<tr bgcolor=#cccccc>";
	$tab = $tab."<td height=20>&nbsp;รายละเอียด</td>";
	$tab = $tab."</tr>";
	$tab = $tab."<tr bgcolor=#ffffff>";
	$tab = $tab."<td height=20>&nbsp;&nbsp;".$temp."</td>";	
	$tab = $tab."</tr>";
	$tab = $tab."</table>";
	
return $tab;
}

//Get Real IP-Address
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
}

//function ที่ใช้ปิดหมายเลย ip ตัวหลังสุด
function showip($temp){
global $user_permission;
	
	if($user_permission == "0"){		
		$show 	= "<a href=\"http://checkip.narak.com/index.cgi?domain=".$temp."\" target=\"_blank\"><font class=\"blue\">".$temp."</font></a>";	
	} else {		
		$ip 		= explode(".", $temp);
		$bip 		= $ip[0].".".$ip[1].".".$ip[2];
		$show 	= $bip.".xxx";
	}
	
return $show;
}

//ตัดค่า array พร้อมกับเรียงข้อมูลใหม่
function arraytrim($arr, $indice)
{ 
	 unset($arr[$indice]);     
     array_shift($arr); 
     return $arr; 
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

//Show Telephone number
function showtel($temp){
	$t = strlen($temp);
	if($t == 10){
		$t1 = substr($temp, 0, 3);
		$t2 = substr($temp, 3, 3);
		$t3 = substr($temp, 6, 4);
		$tel = $t1."-".$t2."-".$t3;
	} elseif($t == 9) {
		$t1 = substr($temp, 0, 2);
		$t2 = substr($temp, 2, 3);
		$t3 = substr($temp, 5, 4);
		$tel = $t1."-".$t2."-".$t3;
	} else {
 		$tel = $temp;
	}
return $tel;
}

//Show full time
function fulltime($temp){
if($temp != "00:00:00"){
	$t = explode(":", $temp);
	if($t[1] == 00){ 
		$time = remove_zero($t[0])." นาฬิกา ";
	} else {
		$time = remove_zero($t[0])." นาฬิกา ".remove_zero($t[1])." นาที";
	}
	} else { 	$time = "ไม่ระบุ"; }		
return $time;
}

//function ที่ใช้แสดงวันที่แบบไทย
function daythai($temp){
if($temp != "0000-00-00"){
	$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$num = explode("-", $temp);			
	if($num[0] == "0000"){
	  $date = "ไม่ระบุ";
	} else {
	  $tyear = $num[0] +  543;
	  $date = remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}
} else { 	$date = "ไม่ระบุ"; }	
return $date;
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

//เปลี่ยนข้อมูลที่โพสมาจาก AJAX จาก UTF-8 เป็น TIS-620
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
			$table	= $table."<a href=\"?page=".$i.$kwd."\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}
		
	if($max < $all){ 	
			$table	= $table."<a href=\"?page=".($i++).$kwd."\" style=\"text-decoration:none;\">></a>&nbsp;"; 
			$table	= $table."<a href=\"?page=".$all.$kwd."\" style=\"text-decoration:none;\">>></a>&nbsp;"; 
	}
	unset($max,$i);
	
} elseif($page > $per_page) {

	$min 	= $page - 5;		
	$max		= (($page + 5) >=  $all) ? $all : $page + 5 ;
	$table	= $table."<a href=\"?page=1".$kwd."\" style=\"text-decoration:none;\"><b><<</b></a>&nbsp;";
	$table	= $table."<a href=\"?page=".($min--).$kwd."\" style=\"text-decoration:none;\"><b><</b></a>&nbsp;";
	for($i=$min;$i<=$max;$i++) 
	{
		if($i != $page){ 
			$table	= $table."<a href=\"?page=$i$kwd\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}	
	
	if($max < $all){
		$table	= $table."&nbsp;<a href=\"?page=".($max++).$kwd."\" style=\"text-decoration:none;\"><b>></b></a>";
		$table	= $table."&nbsp;<a href=\"?page=".$all.$kwd."\" style=\"text-decoration:none;\"><b>>></b></a>&nbsp;"; 
	}	
}                  
	
	$table	= $table."</td>";
	$table	= $table."<td width=\"10%\">".number_format($record, 0, "", ",")."&nbsp;รายการ&nbsp;</td>";
	$table	= $table."<td width=\"10%\">".number_format($all, 0, "", ",")."&nbsp;หน้า&nbsp;</td>";
	$table	= $table."</tr>";
	$table	= $table."</table>";
}
 	return $table;
}
?> 