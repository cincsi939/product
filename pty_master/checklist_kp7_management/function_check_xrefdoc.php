<?

	$db_temp = DB_CHECKLIST;
	$dbname_temp = DB_CHECKLIST;
	$dbnamemaster = DB_MASTER;
	$path_fileall = "../../../".PATH_KP7_REFDOC_FILE."/fileall/";
	$folder_bk_pdf = "../../../backup_kp7file/";
	$path_filesorce = "../../../".PATH_KP7_REFDOC_FILE."/";
	$path_filesorce_new = "../../../".PATH_KP7_REFDOC_FILE."/";
	//$xemail = "chalinee@sapphire.co.th";
	$staff_mail = "suwat@sapphire.co.th";
	$email_sys = "system@sapphire.co.th";
	$workname = "ผลการ upload  ไฟล์ เมื่อวันที่".date("Y-m-d")."มีปัญหา ";
	$msgtext = "พบไฟล์ที่มีปัญหา Xref ของ ";
	
	###  end function  นับจำนวนหน้า
		
	require_once('xfpdi/fpdf.php');
	require_once('xfpdi/FPDI_Protection.php');
	function CheckFilePDF($pathfile){
		$pdf =& new FPDI_Protection();
		$pagecount = $pdf->setSourceFile($pathfile);
		$xpdf =  $pdf->xvalue1;
		 unset($pdf);
		 return $xpdf;
		 
	}//end function CheckFilePDF($pathfile){
	function CountFilePDF($pathfile){
		$pdf =& new FPDI_Protection();
		$pagecount = $pdf->setSourceFile($pathfile);
		return $pagecount;
		 
	}	
		
		
function CheckFileEncrypt($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceEncrypt($pathfile);
	$xpdf =  $pdf->xvalue2;
	 unset($pdf);
	 return $xpdf;
	 
}//end function CheckFilePDF($pathfile){

		
function CheckFileError($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceError($pathfile);
	$xpdf =  $pdf->xvalue3;
	 unset($pdf);
	 return $xpdf;
}//end function CheckFileError(){
	

//require_once('fpdi/fpdf.php');
//require_once('fpdi/FPDI_Protection.php');
//### function นับจำนวนหน้า pdf by พี่น้อย
//function CountPageSystem($pathfile){
//	$pdf =& new FPDI_Protection();
//	$pagecount = $pdf->setSourceFile($pathfile);
//	return $pagecount;
//}
### end function CountPageSystem($pathfile){

	
	
	function CheckXrefPdf($get_idcard,$get_siteid,$subfix_file=''){
		global $db_temp,$path_fileall;
		if($subfix_file != ""){ $pdf = "R.pdf";}else{ $pdf =  ".pdf";}
		$file_pdf = $path_fileall.$get_idcard.$pdf; // ที่อยู่ไฟล์
		$xref_msg = CheckFilePDF($file_pdf); // function ในการตรวจสอบ xref
		if($xref_msg == "error"){
			$sql = "REPLACE INTO tbl_check_xref_pdf SET idcard='$get_idcard',siteid='$get_siteid'";
			mysql_db_query($db_temp,$sql);
			return "error";
		}else{
			return "ok";	
		}//end if($xref_msg == "error"){
	
	}//end 	function CheckXrefPdf($file_pdf){
#########################################  นับไฟล์ในโฟล์เดอร์
function DelDataXrefPdf($get_siteid){
	global $db_temp;
	$sql_del = "DELETE FROM tbl_check_xref_pdf WHERE  siteid='$get_siteid'";
	mysql_db_query($db_temp,$sql_del);
		
}//end function DelDataXrefPdf(){

function xNumMailXrefError($get_siteid){
	global $db_temp,$xemail;
	$sql_sel = "SELECT COUNT(idcard) as num1 FROM tbl_check_xref_pdf WHERE siteid='$get_siteid'";
	$result_sel = mysql_db_query($db_temp,$sql_sel);
	$rs_sel = mysql_fetch_assoc($result_sel);
	return $rs_sel[num1];
	// Your email address 
	
}//end function SentMailXrefError($get_siteid){
	
function XShowAreaName($get_siteid){
	global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
	//echo "$dbnamemaster  : ".$sql;
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[secname];
		
}//end function XShowAreaName($get_siteid){

function ReadFileFolder($get_site=""){
		if($get_site == ""){
			$Dir_Part="../../../".PATH_KP7_REFDOC_FILE."/fileall/";	
		}else{
			$Dir_Part="../../../".PATH_KP7_REFDOC_FILE."/$get_site/";	
		}//end if($get_site == ""){
		
		$Dir=opendir($Dir_Part);
		
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function ReadFileFolder($get_site=""){
#############  end #########################################  นับไฟล์ในโฟล์เดอร์

function XCountPagePdf($file){
        if(file_exists($file)) { 
		
                        //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
						
                    }else { 
                          $contents = fread($handle, 1000); 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
						//echo "<pre>";
						//print_r($found);
						//$count_file = $found['1'];
                        // return $found[1]; 
                        } 
                    } 
                    $i++; 
                } //end   while (!feof($handle)) { 
				}
			}
		return $found;
		//fclose($handle); 
	}//end function XCountPagePdf($file){
		
	function getNumPagesPdf($filepath){ // countpagePDF
		$fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
		$max=0;
		while(!feof($fp)) {
				$line = fgets($fp,255);
				if (preg_match('/\/Count [0-9]+/', $line, $matches)){
						preg_match('/[0-9]+/',$matches[0], $matches2);
						if ($max<$matches2[0]) $max=$matches2[0];
				}
		}
		fclose($fp);
		if($max==0){
			$im = new imagick($filepath);
			$max=$im->getNumberImages();
		}
	
		return $max;
	}// countpagePDF
		
		
	###########  นับจำนวนไฟล์ที่ หา xref ไม่เจอ
	function NumXrefError(){
		global $db_temp;
		$sql = "SELECT COUNT(idcard) as num1 , siteid FROM tbl_check_xref_pdf GROUP BY siteid";
		$result = mysql_db_query($db_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]] = $rs[num1];
		}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}//end function NumXrefError(){


###  แสดงชื่อเขตพื้นที่การศึกษา
	function show_area($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname];
	}//end function show_area($get_secid){
	
###  ฟังก์ชั่นแสดงหน่วยงาน
	function show_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){

#########  funciton กรส่งเมล์
function mail_daily_request($title_name,$email_to,$email_from,$msgtext,$refid='',$xsiteid=''){
global $PHP_SELF,$dbname_temp;
//require_once "Mail.php";
require_once("class.phpmailer.php");

//$msg= "MIME-Version: 1.0\r\n";
//$msg .= "Content-type: text/html; charset=tis-612\r\n"; 
$msg .= "
	<head>
	<title> HTML content</title>
	</head>
	<body>".ereg_replace(chr(13),"<br>", $msgtext)."</body>
	</html>
";
$from = $email_from;
$to = $email_to;

$subject = iconv('TIS-620', 'UTF-8',$title_name);
$msg = iconv('TIS-620', 'UTF-8',$msg);

//$subject = $title_name;
$body = $msg;

$host = "mail.sapphire.co.th"; 
$username = "suwat@sapphire.co.th";
$password = "sapp2009";
$content=" text/html; charset=utf-8";


//$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject, 'Content-Type' => $content);
//$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);
//$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
//$mail = $smtp->send($to, $headers, $body);

//if (PEAR::isError($mail)) {
//echo $mail->getMessage();
//}else {
//echo "Message successfully sent!";
//}
###################### NEW MAILLER 5.1
$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP

$mail->CharSet ="utf-8";
$mail->IsSMTP();
$mail->Host ="mail.sapphire.co.th";
$mail->Port=25;

$mail->Username = $username;  // SMTP username
$mail->Password = $password; // SMTP password

$mail->From = "$from";
$mail->FromName = "EPM SAPPHIRE R&D";
$mail->AddAddress("$to");
$mail->AddReplyTo("$from");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "$subject";
$mail->Body    = "$msg";
//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
//echo "$subject"."$msg";
if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
###################### END MAILLER 5.1

### บันทึก
$page=basename("$PHP_SELF");
$strSQL="
INSERT INTO `tbl_check_save_logmail` SET 
`mail_from`='$email_from',
`mail_to`='$email_to',
`msg`='$msgtext',
`siteid`='$xsiteid'
";
@mysql_db_query($dbname_temp,$strSQL);
//echo "<pre>$email_from, $subject, $msg, $headers, $refid"; die;
}



function xget_real_ip()
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
}//end function xget_real_ip()

#################  function เก็บ log การ upload pdf
function SaveLogUploadPdf($get_siteid="",$type_ref=''){
	global $db_temp,$folder_bk_pdf;
	$xip = xget_real_ip();
	$date_upload = date("Y-m-d H:i:s");
	$date_bk = date("YmdHis");
	if($type_ref != ""){
			$insert_ref = ",type_ref='Y'";
	}
	$sql = "INSERT INTO log_upload_pdf SET staffid='".$_SESSION['session_staffid']."',ip_server='$xip', date_upload='".$date_upload."',folder_bk='$date_bk',siteid='$get_siteid' $insert_ref";
	$result = mysql_db_query($db_temp,$sql);
	###  ตรวจสอบและสร้าง folder_backup
	$folder_main = $folder_bk_pdf.$date_bk; // folder หลัก
	
	if(!is_dir($folder_main)){
		xRmkdir($folder_main);
		//chmod("$folder_main",0777);	
	}//end 	if(!is_dir($folder_main)){
		
	return mysql_insert_id();	
}//end function SaveLogUploadPdf(){
	
##### function คัดลอกไฟล์ backup
function CopyFilePdfBackup($get_upload_id,$idcard,$get_siteid,$subfix_file=''){
	global $db_temp,$folder_bk_pdf,$path_filesorce_new;
	if($subfix_file != ""){ $pdf = "R.pdf";}else{ $pdf = ".pdf";}
	$sql1 = "SELECT * FROM log_upload_pdf  WHERE upload_id='$get_upload_id'";
	$result1 = mysql_db_query($db_temp,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$path_sub = $folder_bk_pdf.$rs1[folder_bk]."/".$get_siteid."/";
	$path_source = $path_filesorce_new."".$get_siteid."/".$idcard.$pdf;
	$path_dest = $path_sub."".$idcard.$pdf;
	if(!is_dir($path_sub)){
		xRmkdir($path_sub);	
		//chmod("$path_sub",0777);	
	}
	@copy($path_source,$path_dest); // ทำการคัดลอกไฟล์  backup ก่อนทำการ upload ไฟล์
	chmod("$path_dest",0777);	
	
}//end function CopyFilePdfBackup(){
	

##############  function log_detail
function SaveLogUploadPdfDetail($upload_id,$get_idcard,$get_siteid,$status_file,$type_ref=''){
	global $db_temp;
	if($type_ref != ""){
			$insert_ref = " ,type_ref='Y'";
	}
	$sql = "INSERT INTO log_upload_pdf_detail SET upload_id='$upload_id',idcard='$get_idcard',siteid='$get_siteid',status_file='$status_file',timeupdate=NOW() $insert_ref";
	mysql_db_query($db_temp,$sql);
}//end SaveLogUploadPdfDetail($upload_id,$get_idcard,$get_siteid,$status_file){

	###  สร้าง โฟล์เดอร์
function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
		mkdir($way);
		chmod($way, $mode);
	}
}//end function xRmkdir($path,$mode = 0777){

//$xref_msg = CheckFilePDF("5550600001152.pdf"); // function ในการตรวจสอบ xref
//echo "ตรวจสอบ xref : ".$xref_msg;

function checkMod($idcard,$siteid,$main_forder,$subfix_file=''){
  $arr_permission777 = array('drwxrwxrwx','-rwxrwxrwx');
  if($subfix_file != ""){ $pdf = "R.pdf";}else{ $pdf = ".pdf";}
  $dir = "../../../$main_forder/".$siteid."/".$idcard.$pdf;
  $dir_pdf2 = "../../../$main_forder/".$siteid;
  $dir_pdf3 = "../../../$main_forder";
  $user_name = "root";
  #$dir_test = "../../../../../kp7file_pts_system";
 

  

  if(file_exists($dir)){

	  $permission = fileperms($dir);
	  $perm = convertPermission($permission); 
   if(!in_array($perm,$arr_permission777)){ #if file permission = 777
   		chmod($dir_pdf2,0777);
		chmod($dir_pdf3,0777);
		 if(chmod($dir,0777)){ #change mod
		  $status_file = 1;
		}else{
		  $status_file = 0;
		}//end   if(chmod($dir,0777)){ 
   }else{
		$status_file = 1;  	 
	}// end    if(!in_array($perm,$arr_permission777)){ 
}//end  if(file_exists($dir)){
return $status_file;
}//end function checkMod($idcard,$siteid){


### This function create by Sun
function convertPermission($perms){
  
 if(($perms & 0xC000) == 0xC000) {
    #Socket
    $info = 's';
 }elseif(($perms & 0xA000) == 0xA000) {
    #Symbolic Link
    $info = 'l';
 }elseif(($perms & 0x8000) == 0x8000) {
    #Regular
    $info = '-';
 }elseif(($perms & 0x6000) == 0x6000) {
    #Block special
    $info = 'b';
 }elseif(($perms & 0x4000) == 0x4000) {
    #Directory
    $info = 'd';
 }elseif(($perms & 0x2000) == 0x2000) {
    #fo = 'c';
 }elseif(($perms & 0x1000) == 0x1000) {
    #FIFO pipe
    $info = 'p';
 }else{
    #Unknown
    $info = 'u';
 }

 #Owner
 $info .= (($perms & 0x0100) ? 'r' : '-');
 $info .= (($perms & 0x0080) ? 'w' : '-');
 $info .= (($perms & 0x0040) ?
          (($perms & 0x0800) ? 's' : 'x') :
          (($perms & 0x0800) ? 'S' : '-'));
 #Group
 $info .= (($perms & 0x0020) ? 'r' : '-');
 $info .= (($perms & 0x0010) ? 'w' : '-');
 $info .= (($perms & 0x0008) ?
          (($perms & 0x0400) ? 's' : 'x') :
          (($perms & 0x0400) ? 'S' : '-'));

 #World
 $info .= (($perms & 0x0004) ? 'r' : '-');
 $info .= (($perms & 0x0002) ? 'w' : '-');
 $info .= (($perms & 0x0001) ?
          (($perms & 0x0200) ? 't' : 'x') :
          (($perms & 0x0200) ? 'T' : '-'));

 return $info;
 
}
?>