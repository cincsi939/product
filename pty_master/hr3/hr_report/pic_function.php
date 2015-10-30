<?
function savelog($act){
	$stamp		= date("Y-m-d H:i:s");
	$ip 			= get_real_ip();	
	$sql 			= " insert into `user_log` set user = '".$_SESSION[user_name]."', stamp = '$stamp', ip = '$ip', action='".$act."'; ";
	$result		= mysql_query($sql)or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());	
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


// =====================================================
// Log Function @19/7/2550
// =====================================================
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


function add_pdf_log($keycode,$idcard){
global $server_id;
	$uname = $_SESSION[session_username];
	$ip = get_real_ip();
	$sql = "insert into log_print_pdf(server_id,keycode,logtime,username,target_idcard,user_ip) values('$server_id','$keycode',now(),'$uname','$idcard','$ip');";
	mysql_query($sql);

}


function add_log($subject,$idcard,$action){
global $server_id;
	$uname = $_SESSION[session_username];
	$ip = get_real_ip();
	$sql = "insert into log_update(server_id,logtime,username,subject,target_idcard,user_ip,action) values('$server_id',now(),'$uname','$subject','$idcard','$ip','$action');";
	mysql_query($sql);

}


// -------------ส่วนการ Tranfer ข้อมูลเข้า log-------------------

function getfieldsource_all_log($tblname){
	$sql = " SHOW FIELDS FROM  $tblname ";
	//echo ":: $sql <hr>$dbsource";
	$result = mysql_query($sql);
	while($rs = mysql_fetch_assoc($result) ){
			if(trim(strip_tags($rsfield)) > ""){ $rsfield .= ",";}
			$rsfield .= "`$rs[Field]`" ; 
	}
	return $rsfield;
}

function add_monitor_logbefore($tabledata,$keyfield){

	$sqlx = " SELECT * FROM  ".$tabledata."_log_before ";
	$resultx = @mysql_query($sqlx);
	$rsx  = @mysql_fetch_array($resultx);
	if($rsx[0]==""){
	$sql_cre = " CREATE  TABLE IF NOT EXISTS ".$tabledata."_log_before  SELECT  *  FROM  $tabledata  limit 1 " ;		
	$sql_emtry = " TRUNCATE  ".$tabledata."_log_before ";	
	$sql_alter = " ALTER TABLE `".$tabledata."_log_before` ADD `auto_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
ADD `staffid` VARCHAR( 16 ) NOT NULL AFTER `auto_id` ;  ";
	mysql_query($sql_cre);	
	mysql_query($sql_emtry);
	mysql_query($sql_alter);
	}
	
	
	//หารายการ FIELD
	$returnid = 0;
	$field_result = getfieldsource_all_log($tabledata);
	if($field_result){
		if($keyfield  == ""){
			$sql = " INSERT ".$tabledata."_log_before(staffid) values('".$_SESSION[session_staffid]."')";
		}else{
			$sql = " INSERT ".$tabledata."_log_before($field_result,staffid)  SELECT $field_result,'".$_SESSION[session_staffid]."'  FROM $tabledata WHERE  $keyfield ";
		}
		//echo $sql;die;
		mysql_query($sql);
		$returnid = mysql_insert_id();
	}
	return $returnid ;
} 

function add_monitor_logafter($tabledata,$keyfield,$fkey){
	$sqlx = " SELECT * FROM  ".$tabledata."_log_after ";
	$resultx = @mysql_query($sqlx);
	$rsx  = @mysql_fetch_array($resultx);
	if($rsx[0]==""){
	$sql_cre = " CREATE  TABLE IF NOT EXISTS ".$tabledata."_log_after  SELECT  *  FROM  $tabledata  limit 1 " ;		
	$sql_emtry = " TRUNCATE  ".$tabledata."_log_after ";	
	$sql_alter = " ALTER TABLE `".$tabledata."_log_after` ADD `auto_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
ADD `staffid` VARCHAR( 16 ) NOT NULL AFTER `auto_id` ;  ";
	mysql_query($sql_cre);	
	mysql_query($sql_emtry);
	mysql_query($sql_alter);
	}
	
	
	//หารายการ FIELD
	$field_result = getfieldsource_all_log($tabledata);
	if($field_result){
		$sql = " INSERT ".$tabledata."_log_after($field_result,staffid,auto_id)  SELECT $field_result,'".$_SESSION[session_staffid]."','$fkey'  FROM $tabledata WHERE  $keyfield ";
		mysql_query($sql);
	}
} 

// =====================================================
###  สร้าง โฟล์เดอร์
function RmkDirPic($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
		mkdir($way);
	}
}


?> 