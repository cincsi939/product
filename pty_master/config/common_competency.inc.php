<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับทดสอบ
* @projectCode 56EDUBKK01
* @tor 1.2.3 (Opt.)
* @package core(or plugin)
* @author Suwat.K 
* @access public
* @created 08/08/2014
*/


$debug_mode = 0; // 1 = DEBUG MODE / 0=PUBLISH MODE
$show_warning = 0; // 1 = แสดง warning / 0= ไม่แสดง warning
$maindatabase = "edubkk_system";
$cmssdatabase = "edubkk_master";
$mainapp = "edubkk_master";
$dbnmae_temp = "edubkk_checklist";
$dbname_center = "edubkk_0000"; # ฐานข้อมูลกลาง

$ALIGNMENT['TEXT']=" align='left' ";// ตัวอักษร
$ALIGNMENT['NUMBER']=" align='right' ";//ตัวเลข
$ALIGNMENT['DATE']=" align='center' ";//วันที่
$ALIGNMENT['CURRENCY']=" align='right' ";//จำนวนเงิน
$ALIGNMENT['ORDER']=" align='center' ";//ลำดับ
$ALIGNMENT['ICON']=" align='center' ";//icon
$ALIGNMENT['IDCARD']=" align='center' ";//เลขบัตร
//print_r($ALIGNMENT);
//echo  "ALIGNMENT[TEXT]";
//echo "<br>";

$dateconfig = "2012-03-01";






//----------------------- ตรวจสอบข้อมูลวากำลังเปิดหน้าต่างคีย์ข้อมูลซ้อนกันหรือไม่ NOI 20/01/2010 ------------------------------------------------
//print_r(basename($_SERVER['PHP_SELF']));
// -----------  FILE  NAME --------------------------
$arr_keyin = array('general_all_1compare.php','general.php','graduate_all.php','salary.php','absent_all_1.php');

if($_SESSION[session_staffid] != ""){ // กรณี login เป็น dataentry
		//$destroy_s = session_destroy();
		$r_url = "<meta http-equiv='refresh' content='1;url=../../userentry/index.php'>" ;
	}else{
		$r_url =  "<meta http-equiv='refresh' content='1;url=http://www.cmss-edubkk.com'>" ;
	//	$destroy_s = "";
}

if($_GET[id] != "" || $_GET[id] != 0){
	if(in_array(basename($_SERVER['PHP_SELF']),$arr_keyin)){
		if($_SESSION[id] != $_GET[id]){
			write_log($_SESSION[session_staffid],'check_id','miss_id','fail',"ผิดพลาดรหัสไม่ตรง sesion id = $_SESSION[id] , Get id = $_GET[id]",basename($_SERVER['PHP_SELF']),"$_SESSION[siteid]") ;
			echo " <script language=\"JavaScript\">  alert(\" เนื่องจากท่านเข้าระบบซ้ำซ้อนกันมากกว่า 1 คน \\n โปรดตรวจสอบหน้าต่างของท่านว่ามีการเข้าระบบซ้ำซ้อนหรือไม่ \") ; </script>  " ;   
			//echo $destroy_s;
			echo " <script language=\"JavaScript\"> top.location.replace('$r_url') </script>  " ;  
			die;
		}
	}
}
// ----------------------------------------------------------------------------------------------------------------------------------------

/* ฟังชั่นก์สำหรับการเขียน log
$user : ชื่อผู้ใช้
$module_code : รหัส module ที่กำลังใช้งาน
$process_id : รหัส Process ID ใช้ตาราง process_log
$pcrs : ผลลัพท์ของ process อาจเป็น seccess , error , unknow , 
$msg : ข้อความแจ้งให้ทราบของโปรแกรม
$filename : file ที่กำลังรันโปรแกรม
$siteid : เซิร์ฟเวอร์ที่รันโปรแกรม 
*/

 function write_log($usr,$md,$pcid,$pcrs,$msg,$filename,$siteid){
	 global $dbsystem;

	 $filename =    addslashes($filename) ; 
	 $msg =    addslashes($msg) ;
	 $msg =    str_replace("'"," ",$msg);

	 $sql = "INSERT INTO  syslog(userid,modulecode,processid,processresult,msg,filename,siteid) VALUES ( '$usr','$md','$pcid','$pcrs','$msg','$filename','$siteid' ); ";	 
	@mysql_db_query($dbsystem,$sql);
	
	return @mysql_insert_id() ; 
 }

 // set the error reporting level for this script
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// error handler function
//กำหนดให้ทุกไฟล์ ต้องใส่ตัวแปร $module_code,$process_id ไว้ที่หัวไฟล์ทุกครั้ง

function myErrorHandler($errno, $errstr, $errfile, $errline){
global $debug_mode,$module_code,$process_id,$siteid,$show_warning , $dbsystem;
	 
	 //DO NOTHING
	 return;


	switch ($errno) {
	 case E_ERROR:
			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$_SESSION[secid]);
			exit(1);
			break;
	 case E_WARNING:
			if ($debug_mode && $show_warning){
				echo "<b>คำเตือน</b>  บรรทัดที่ : <U>$errline</U> ไฟล์ : <U>$errfile</U><br />[$errno] $errstr<br />";
			}

			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 case E_PARSE:
			if ($debug_mode){
			   echo "<b>หมายเหตุ</b> บรรทัดที่ : <U>$errline</U> ไฟล์ : <U>$errfile</U><br />[$errno] $errstr<br />";
			}
			write_log($session_username,$module_code,$process_id,"incomplete","Line : $errline $errstr",$errfile,$siteid);
		   break;
	 default:
	   //echo "เกิดข้อผิดพลาดที่ไม่ทราบชนิด : [$errno] $errstr<br />\n";
		//write_log($session_username,$module_code,$process_id,"incomplete",$errstr,$errfile,$siteid);
	   break;
	}
}

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
 } 

//$time_start = getmicrotime();
//$time_end = getmicrotime();

function GET_IPADDRESS($fakeip=false){
$ip = (!empty($_SERVER['HTTP_CLIENT_IP'])) ? (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_CLIENT_IP'] : preg_replace('/(?:,.*)/', '', $_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['REMOTE_ADDR'];
$ip = (!$fakeip) ? $ip:$fakeip;

// local check class b and c
$patterns = array("/(192).(168).(\d+).(\d+)/i","/(10).(\d+).(\d+).(\d+)/i");
foreach($patterns as $pattern) {
	if(preg_match($pattern,$ip)) {
		return $_SERVER["REMOTE_ADDR"];
	}
}
// local check class a
$parts = explode(".",$ip);
if($parts[0]==172 && ($parts[1]>15 || $parts[1]<32)) {
return $_SERVER["REMOTE_ADDR"];
}

if($_SERVER['HTTP_X_FORWARDED_FOR'] != ""){
return $_SERVER['HTTP_X_FORWARDED_FOR'] ;
}

return trim($ip);
}

#####  เก็บ log การตรวจสอบและรับรองข้อมูล
	function SaveLogApproveKey($ticketid,$idcard,$profile_id,$siteid,$fullname,$approve,$action,$subject=""){
		global $dbnameuse;
		$ip = GET_IPADDRESS();
		$sql = "INSERT INTO tbl_assign_log SET ticketid='$ticketid',idcard='$idcard',profile_id='$profile_id',siteid='$siteid',fullname='$fullname',staffid='".$_SESSION[session_staffid]."',approve='$approve',server_ip='".$ip."',action='$action',subject='$subject'";
		mysql_db_query($dbnameuse,$sql)  or die(mysql_error()."$sql<br>LINE__".__LINE__);
			
	}// end function SaveLogApproveKey($ticketid,$idcard,$profile_id,$siteid,$fullname,$approve,$server_ip,$action){



#### เก็บ log การตรวจสอบและรับรองข้อมูล


function writetime2db($timestart,$timeend){
	GLOBAL $maindatabase,$ApplicationName,$session_username , $dbsystem ;
	//AddSessoinVariable();

	$serverip = $_SERVER['SERVER_NAME'];
	//$ipaddress = $_SERVER["REMOTE_ADDR"] ;
	$ipaddress = GET_IPADDRESS();
	$file_name = basename($_SERVER['PHP_SELF']);
	
	$filefullpath = __FILE__;
	$timequery = $timeend - $timestart;
	$sessionid = session_id();
	$siteid1 = $_SESSION[secid];
	
	$sql = " INSERT INTO system_timequery  SET  username = '".$_SESSION[session_username]."' ,ipaddress = '$ipaddress' ,siteid='$siteid1',appname = '$ApplicationName', filename = '$file_name' ,timequery = '$timequery' , serverip = '$serverip'  ";
	mysql_db_query($dbsystem,$sql);


	$sql1 = " REPLACE INTO useronline  SET sessionid= '$sessionid', username = '".$_SESSION[session_username]."' ,siteid='$siteid1',ipaddress = '$ipaddress' ,appname = '$ApplicationName',filename = '$file_name' , serverip = '$serverip' ,staffid='".$_SESSION[session_staffid]."'";
	//echo "$sql1 $dbsystem ";die;
	mysql_db_query($dbsystem,$sql1);

}
	ob_end_flush();

//=================== ฟังก์ชันปิดเมนู ใน cmss 
function set_privilage($secid,$pivilage){
	global $dbnamemaster;
	$strSQL = "SELECT secid FROM $dbnamemaster.eduarea WHERE status <> 1";
	$Result = mysql_query($strSQL);
	while($Rs = mysql_fetch_array($Result)){
		if($secid == $Rs[secid]){
					if(($secid == $Rs[secid]) and ($pivilage == "")){
					$disable_link = true;
					}else{
					$disable_link = false;
					}	
			break;
			}
	}
		return $disable_link;
}


 function cmdlog($act,$msg,$cmdid='0'){
	 global $dbsystem , $maindatabase , $_SESSION;

	//echo "<pre>";print_r($_SESSION);
	 $msg =    addslashes($msg) ;
	 $msg =    str_replace("'"," ",$msg);
	 $ip = getRealIpAddr();
	 $appid = implode(",",$_SESSION[applistid]);
	 $appname = implode(",",$_SESSION[applistname]);

	 $sql = "INSERT INTO  log_command SET
	 `app_id`='$appid',
	 `app_name`='$appname',
	 `secid`='".$_SESSION[secid]."',
	 `userid`='".$_SESSION[idoffice]."',
	 `username`='".$_SESSION[session_username]."',
	 `activity`='$act',
	 `cmd_id`='$cmdid',
	 `comment`='$msg',
	 `ipaddress`='$ip'
	";
	@mysql_db_query($maindatabase,$sql);	
	return @mysql_insert_id() ; 
 }

	function getRealIpAddr(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	###################  function แสดงชื่อเต็มของวิทยฐานะ อ้างอิงตามมาตรา 39
	#######  funciton แสดงชื่อวิทยฐานะ 
function ShowFullvitaya($get_position,$get_vitaya){
	
	##str_replace($get_position,"",$get_vitaya); ป้องกันกรณีในบางรายการเก็บชื่อวิทยฐาะนะเต็มไปแล้ว
	if($get_vitaya != ""){
		if($get_position != ""){
			$xpos = strpos($get_position,"ผู้อำนวยการสถานศึกษา");
			$xpos1 = strpos($get_position,"ผู้อำนวยการโรงเรียน");
			
			if((!$xpos) and (!$xpos1)){
				if(!$xpos){
					$txt_vitaya = str_replace("สถานศึกษา","",$get_position)."".str_replace($get_position,"",$get_vitaya); //  ป้องกันกรณีในบางรายการเก็บชื่อวิทยฐาะนะเต็มไปแล้ว
				}else{
					$txt_vitaya = str_replace("โรงเรียน","",$get_position)."".str_replace($get_position,"",$get_vitaya);
				}
			}else{ // กรณีไม่ใช่ผู้บริหารสถานศึกษาให้ใช้ชื่อตำแหน่งตามด้วยชื่อวิทยฐานะ
					$txt_vitaya = $get_position."".str_replace($get_position,"",$get_vitaya);
			}//end if((!$xpos === false) or (!$xpos1 === false)){	
		}else{
				$txt_vitaya = $get_vitaya;
		}// end if($get_position == ""){	
	}else{
				$txt_vitaya = "";	
	}//end 	if($get_vitaya != ""){
		return $txt_vitaya;
}//end function ShowFullvitaya($get_position,$get_vitaya){
function appadd_log($subject,$idcard,$action,$menu_id="",$listerr=""){
	 // $subject="ชื่อ module";
	 // $menu_id="ชื่อ application";
     // $listerr="0|form|0|0|บัญทึกข้อมูลนับตัว";
global $server_id,$dbcmss_site;
$xaction=trim($action);
if( !(strrpos($xaction,"edit")===false)){
    $xaction='edit';     
}elseif( !(strrpos($xaction,"delete")===false)){ 
    $xaction='delete';      
}if( !(strrpos($xaction,"insert")===false)){
    $xaction='insert';      
}else{
	$xaction = $xaction;
}
	$uname = $_SESSION[session_username];
	$staff_key = $_SESSION[session_staffid];
	$ip = GET_IPADDRESS();
	$sql = "insert into log_update(server_id,logtime,username,subject,target_idcard,user_ip,action,staff_login,menu_id) values('$server_id',now(),'$uname','$subject','$idcard','$ip','$xaction','$staff_key','$menu_id');";

	mysql_db_query($dbcmss_site,$sql)or die(mysql_error());

    $xid=mysql_insert_id();
  $arr=explode('#',$listerr);
  if(count($arr)>0){
      $i=0;
    foreach($arr as $index=>$value){       
       $value_list=explode('|',$value);
        if(count($value_list)>0){ 
           $i++;         
           if($value_list[3]!=""){ 
               $sql_log="insert into  log_update_list set
                    runid='$xid',
                    logid='$i',
                    errcode='$value_list[3]',
                    errmode='$value_list[0]',
                    formevent='$value_list[1]',
                    errtype='$value_list[2]',
                    msg='$value_list[4]',
                    logtime=NOW()";                       
                  mysql_db_query($dbcmss_site,$sql_log); 
           }
          
        }
    }
  }  
}

###############  function แสดงการตรวจสอบไฟล์ pdf ต้นฉบับในระบบ รวมทั้งแสดง icon ไฟล์ pdf จากระบบ
function GetPdfOrginal_bkk($idcard,$path_pdf,$img_pdforg,$schoolid="",$type=""){
	global $dbname_temp,$cmssdatabase;
	$sql = "SELECT idcard,siteid FROM tbl_checklist_kp7 WHERE idcard='$idcard' ORDER BY profile_id DESC";
//	echo $dbname_temp."<br>".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		$kp7file = $path_pdf."$rs[siteid]/".$rs[idcard].".pdf";
	//	echo "<a href='$kp7file' target='_blank'>$kp7file</a>";
		if(file_exists($kp7file)){
			$i++;
			$result_file = "<a href='$kp7file' target='_blank'>$img_pdforg</a>";
			//exit();
		}//end if(is_file($kp7file)){		
	}//end while($rs = mysql_db_query($result)){
		
	$sql1 = "SELECT allschool.siteid as sitenew, allschool_math_sd.siteid as siteold FROM allschool_math_sd Inner Join allschool ON allschool.id = allschool_math_sd.schoolid WHERE allschool.id =  '$schoolid'";
	//echo $cmssdatabase.":: $sql1<br>";
	$result1 = mysql_db_query($cmssdatabase,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$kp7file1 = $path_pdf."$rs1[sitenew]/".$idcard.".pdf";
	$kp7file2 = $path_pdf."$rs1[siteold]/".$idcard.".pdf";
	if(file_exists($kp7file1)){
		$i++;
		$result_file = "<a href='$kp7file1' target='_blank'>$img_pdforg</a>";	
		//exit();

	}/// end if(is_file($kp7file1)){
	if(file_exists($kp7file2)){
		
		$i++;
			$result_file = "<a href='$kp7file2' target='_blank'>$img_pdforg</a>";	
		//	exit();
		
	}//end if(is_file($kp7file2)){
		
		
			if($type != ""){
				return $result_file;	
			}else{
				return $i;	
			}//end 	if($type != ""){

		//echo $i." :: ".$result_file."<br>";
	#######  ส่วนของการแสดงผล
	
}//end function GetPdfOrginal(){
	
	
###############  function แสดงการตรวจสอบไฟล์ pdf ต้นฉบับในระบบ รวมทั้งแสดง icon ไฟล์ pdf จากระบบ
function GetPdfOrginal($idcard,$path_pdf,$img_pdforg,$schoolid="",$type=""){
	global $dbname_temp,$cmssdatabase;
	$sql = "SELECT idcard,siteid,schoolid FROM tbl_checklist_kp7 WHERE idcard='$idcard' ORDER BY profile_id DESC";
	//echo $dbname_temp."<br>".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	$i=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
	$syl = substr($path_pdf,-1);
	if($syl != "/"){
		$path_pdf = $path_pdf."/";	
	}
	
		$kp7file = $path_pdf."$rs[siteid]/".$rs[idcard].".pdf";
	//echo " <br> v:: <a href='$kp7file' target='_blank'>$kp7file</a>";
	if($j == "0"){
		$xschoolid = $rs[schoolid];
	}//end if($j == "0"){
		if(file_exists($kp7file)){
			$i++;
			$result_file = "<a href='$kp7file' target='_blank'>$img_pdforg</a>";
			//echo "1 :: $result_file<br>";
			$sitefile = $rs[siteid];
		}//end if(is_file($kp7file)){		
		$j++;
	}//end while($rs = mysql_db_query($result)){
		
		if($schoolid == ""){ // 
			$schoolid = $xschoolid;
		}//end if($schoolid == ""){
		
	$sql1 = "SELECT allschool.siteid as sitenew, allschool_math_sd.siteid as siteold FROM allschool_math_sd Inner Join allschool ON allschool.id = allschool_math_sd.schoolid WHERE allschool.id =  '$schoolid'";
	//echo $cmssdatabase.":: $sql1<br>";
	$result1 = mysql_db_query($cmssdatabase,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	
	$syl = substr($path_pdf,-1);
	if($syl != "/"){
		$path_pdf = $path_pdf."/";	
	}
	
	$kp7file1 = $path_pdf."$rs1[sitenew]/".$idcard.".pdf";
	$kp7file2 = $path_pdf."$rs1[siteold]/".$idcard.".pdf";
	//echo "1 : <a href='$kp7file1' target='_blank'>$img_pdforg</a>";
	//echo  "2 : <a href='$kp7file2' target='_blank'>$img_pdforg</a>";	
	if(file_exists($kp7file1)){
		$i++;
		$result_file = "<a href='$kp7file1' target='_blank'>$img_pdforg</a>";	
		$sitefile = $rs1[sitenew];
	}/// end if(is_file($kp7file1)){
	if(file_exists($kp7file2)){
		$i++;
			$result_file = "<a href='$kp7file2' target='_blank'>$img_pdforg</a>";	
			$sitefile = $rs1[siteold];
		
	}//end if(is_file($kp7file2)){
		
		
		
			$arr['linkfile'] = $result_file;
			$arr['sitefile'] = $sitefile;
			$arr['numfile'] = $i;
		
		//echo "<pre>";
		//print_r($arr);
			if($type != ""){
				return $arr;	
			}else{
				return $i;	
			}//end 	if($type != ""){

		//echo $i." :: ".$result_file."<br>";
	#######  ส่วนของการแสดงผล
	
}//end function GetPdfOrginal(){
	
function GetSiteHishory($idcard){
global $dbname_temp,$cmssdatabase;
	$sql = "SELECT siteid,schoolid FROM tbl_checklist_kp7 WHERE idcard='$idcard'";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrsite[$rs[siteid]] = $rs[siteid];
		$sql1 = "SELECT allschool.siteid as sitenew, allschool_math_sd.siteid as siteold FROM allschool_math_sd Inner Join allschool ON allschool.id = allschool_math_sd.schoolid WHERE allschool.id =  '$rs[schoolid]";
		$result1 = mysql_db_query($cmssdatabase,$sql1);
		$numr1 = @mysql_num_rows($result1);
		if($numr1 > 0){
		$rs1 = mysql_fetch_assoc($result1);
		$arrsite[$rs1[sitenew]] = $rs1[sitenew];
		$arrsite[$rs1[siteold]] = $rs1[siteold];
		}//end 	if($numr1 > 0){
	}
		
	return $arrsite;
}// end function GetSiteHishory($idcard){	

	
###############  function แสดงการตรวจสอบไฟล์ pdf ต้นฉบับในระบบ รวมทั้งแสดง icon ไฟล์ pdf จากระบบ
function GetImgKp7($idcard,$siteid,$path_img){
	global $dbname_temp,$cmssdatabase;
	$db_site = "edubkk_".$siteid;
	$sqlsite = "SELECT general.id, general_pic.imgname FROM general Inner Join general_pic ON general.id = general_pic.id WHERE general.id =  '$idcard'";
	$resultsite = mysql_db_query($db_site,$sqlsite);
	while($rss = mysql_fetch_assoc($resultsite)){
		$kp7img = $path_img.$siteid."/$rss[imgname]";
			if(file_exists($kp7img)){
				$arr_img[$rss[imgname]] = "<img src=\"$kp7img\" width=\"120\" height=\"160\" border=\"0\">";	
			}else{
				$arrsite = GetSiteHishory($idcard);
				foreach($arrsite as $key1 => $val1){
						$kp7img1 = $path_img.$val1."/$rss[imgname]";	
						//$arr_img["$kp7img1"] = "<img src=\"$kp7img1\" width=\"120\" height=\"160\" border=\"0\">";
						if(file_exists($kp7img1)){
							$arr_img[$rss[imgname]."||$val1"] = "<img src=\"$kp7img1\" width=\"120\" height=\"160\" border=\"0\"> :: HIS";
							break;
						}
				}//end foreach($arrsite as $key1 => $val1){
					
			}//end 	if(file_exists($kp7img)){
	}//end while($rss = mysql_fetch_assoc($resultsite)){ 
	
	return $arr_img;
	
}//end function GetImgKp7($idcard,$path_img,$schoolid="",$type=""){
	
	
	define("config_option","1"); //แสดง สพม,สพป
	//$config_option="1";//แสดง สพม,สพป
function gen_educond($fildename="siteid"){
	 $_dispmode=$_GET['dispmode'];
	 if($_dispmode=="edu1"){
		  $xcond="  SUBSTR($fildename,1,1)='0' ";
	}else if($_dispmode=="edu2"){
		  $xcond="  SUBSTR($fildename,1,1)<>'0' ";
	}
	$xcond = ($xcond!="")?$xcond." AND $fildename NOT LIKE('99%') ":" $fildename NOT LIKE('99%') ";

return  $xcond;
}	
function list_profile($link=""){
 global $cmssdatabase;
	$sql = "SELECT YEAR(MIN(date_submit)) AS year_min, YEAR(MAX(date_submit)) AS year_max FROM log_dataremove_report ";
	$result = mysql_db_query($cmssdatabase,$sql);
	$rs = mysql_fetch_assoc($result);
	$start_year = $rs['year_min'];
	$end_year = $rs['year_max']-((substr($rs['date_max'],6,10)<="10-01")?1:0);
	$str_list = '<select name="date_profile" onchange="window.location=\''.$link.'&date_profile=\'+this.value;">';
	for($year=$start_year;$year<=$end_year;$year++){
		$str_list .= '<option value="'.$year.'-10-01:'.($year+1).'-09-30" '. (((($_GET['date_profile'])?$_GET['date_profile']:$end_year."-10-01:".($end_year+1)."-09-30")== $year."-10-01:".($year+1)."-09-30")?"SELECTED":"").'>1 ตุลาคม '.($year+543).' - 30 กันยายน '.($year+543+1).'</option>';
	}
	$str_list .= '</select>';
	return $str_list;
}
function gen_removecond($date_profile=""){
global $cmssdatabase;
	$date_profile = ($date_profile!="")?$date_profile:$_GET['date_profile'];
	$sql = "SELECT YEAR(MIN(date_submit)) AS year_min, YEAR(MAX(date_submit)) AS year_max FROM log_dataremove_report ";
	$result = mysql_db_query($cmssdatabase,$sql);
	$rs = mysql_fetch_assoc($result);
	$end_year = $rs['year_max']-((substr($rs['date_max'],6,10)<="10-01")?1:0);
	if($date_profile==""){
		$date_profile=$end_year.'-10-01:'.($end_year+1).'-09-30';
	}
	if($date_profile!=""){
		$arr_date = explode(":",$date_profile);
		$cond = " date_submit BETWEEN  '".$arr_date[0]."' AND '".$arr_date[1]."' ";
	}else{
		$cond = "";
	}
	
	return $cond;
}
function gensql_edu($where_cond,$inner_cond,$type="edu",$fullarea="1",$date_profile=""){
 global $cmssdatabase,$set_profile;

 $where_cond= str_replace('provid','patameter',$where_cond);  
 $where_cond= str_replace('secid','site',$where_cond); 
 $where_cond= str_replace('siteid','site',$where_cond); 
 $inner_cond= str_replace('provid','patameter',$inner_cond);  
 $inner_cond= str_replace('secid','site',$inner_cond); 
 $inner_cond= str_replace('siteid','site',$inner_cond); 

 if($fullarea!=""){$sql_fullarea="and st_active='1'";}
 $_dispmode=$_GET['dispmode'];

if(config_option=="1"){
$type="edu";
}
	
	$sql_year = "SELECT YEAR(MIN(date_submit)) AS year_min, YEAR(MAX(date_submit)) AS year_max FROM log_dataremove_report ";
	$result_year = mysql_db_query($cmssdatabase,$sql_year);
	$rs_year = mysql_fetch_assoc($result_year);
	$end_year = $rs_year['year_max']-((substr($rs_year['date_max'],6,10)<="10-01")?1:0);
	if($date_profile=="" && $set_profile!=""){
		$date_profile=$end_year.'-10-01:'.($end_year+1).'-09-30';
	}else{
		$date_profile="";
	}

	if($date_profile!=""){
		$arr_date = explode(":",$date_profile);
	}
	$sqlarea_history = "
	SELECT * FROM `area_history` WHERE ('".$arr_date[0]."' >=start_date AND '".$arr_date[0]."'<=end_date) AND ('".$arr_date[1]."'>= start_date AND '".$arr_date[1]."'<= end_date  )
	";
	
	$result = mysql_db_query($cmssdatabase,$sqlarea_history);
	$rs = mysql_fetch_assoc($result);
	if($rs['profile_id']!=""){		
	 	if($_dispmode=="edu1"){
			  $xcond=" and SUBSTR(eduarea.secid,1,1)='0' ";
		}else if($_dispmode=="edu2"){
			  $xcond=" and SUBSTR(eduarea.secid,1,1)<>'0' ";
		}
		$tbl_eduarea = $rs['tbl_eduarea'];
		$tbl_allschool = $rs['tbl_allschool'];
		 $where_cond= str_replace('patameter','provid',$where_cond);  
		 $where_cond= str_replace('site','secid',$where_cond); 
		 $where_cond= str_replace('site','siteid',$where_cond); 
		 $inner_cond= str_replace('patameter' ,'provid',$inner_cond);  
		 $inner_cond= str_replace('site','secid',$inner_cond); 
		 $inner_cond= str_replace('site','siteid',$inner_cond); 
		if($type=="ccaa"){
				 $sql="SELECT eduarea.secname as secname,eduarea.secid as siteid ,eduarea.secid as secid , eduarea.secid as siteid , eduarea.secid as id ,eduarea.secid as idlink  ,eduarea.secname  as selname    FROM $tbl_eduarea as eduarea Inner Join ccaa ON ccaa.areaid = eduarea.patameter   $inner_cond WHERE  eduarea.secid not like('99%')  $sql_fullarea  $where_cond  $xcond order by if(left(eduarea.site,1)=0,eduarea.site,eduarea.siteshortname)";  
		}else{ 
		  		$sql="SELECT eduarea.secname as caption,eduarea.secname as secname,eduarea.secid as id,eduarea.secid as secid,eduarea.secid as siteid,eduarea.secid as idlink  ,eduarea.secname  as selname   FROM $tbl_eduarea as eduarea  WHERE eduarea.secid not like('99%')    $sql_fullarea $where_cond  $xcond  $inner_cond  order by if(left(eduarea.site,1)=0,eduarea.site,eduarea.siteshortname)";                
		}
	}else{
		if($_dispmode=="edu1"){
			  $xcond=" and SUBSTR(eduarea.site,1,1)='0' ";
		}else if($_dispmode=="edu2"){
			  $xcond=" and SUBSTR(eduarea.site,1,1)<>'0' ";
		}
		if($type=="ccaa"){
				 $sql="SELECT eduarea.siteshortname as secname,eduarea.site as siteid ,eduarea.site as secid , eduarea.site as siteid , eduarea.site as id ,eduarea.site as idlink  ,eduarea.siteshortname  as selname    FROM eduarea_config as eduarea Inner Join ccaa ON ccaa.areaid = eduarea.patameter   $inner_cond where eduarea.group_type='report' $sql_fullarea  $where_cond  $xcond order by if(left(eduarea.site,1)=0,eduarea.site,eduarea.siteshortname)";  
		}else{ 
		  $sql="SELECT eduarea.siteshortname as caption,eduarea.siteshortname as secname,eduarea.site as id,eduarea.site as secid,eduarea.site as siteid,eduarea.site as idlink  ,eduarea.siteshortname  as selname   FROM eduarea_config as eduarea  where eduarea.group_type='report' $sql_fullarea $where_cond  $xcond  $inner_cond  order by if(left(eduarea.site,1)=0,eduarea.site,eduarea.siteshortname)";                
		}
	}
    
 return  $sql;  

}
function gensql_edu_onecol($where_cond,$inner_cond,$type="edu",$fullarea="1",$col="eduarea.siteid"){
 $where_cond= str_replace('provid','patameter',$where_cond);  
 $where_cond= str_replace('secid','site',$where_cond); 
 $where_cond= str_replace('siteid','site',$where_cond); 
 $inner_cond= str_replace('provid','patameter',$inner_cond);  
 $inner_cond= str_replace('secid','site',$inner_cond); 
 $inner_cond= str_replace('siteid','site',$inner_cond); 
 if($fullarea!=""){$sql_fullarea="and st_active='1'";}
 $_dispmode=$_GET['dispmode'];
 if($_dispmode=="edu1"){
	  $xcond=" and SUBSTR(eduarea.site,1,1)='0' ";
}else if($_dispmode=="edu2"){
	  $xcond=" and SUBSTR(eduarea.site,1,1)<>'0' ";
}
if(config_option=="1"){
$type="edu";
}
    if($type=="ccaa"){
     $sql="SELECT $col    FROM eduarea_config as eduarea Inner Join ccaa ON ccaa.areaid = eduarea.patameter   $inner_cond where eduarea.group_type='report' $sql_fullarea  $where_cond  $xcond order by orde_by";         
    }else{ 
      $sql="SELECT $col   FROM eduarea_config as eduarea  where eduarea.group_type='report' $sql_fullarea $where_cond  $xcond  $inner_cond  order by orde_by";                
    
    }
    
 return  $sql;  

}

function gensql_school($where_cond="", $date_profile=""){
 global $cmssdatabase;
	$date_profile = ($date_profile!="")?$date_profile:$_GET['date_profile'];
	$sql_year = "SELECT YEAR(MIN(date_submit)) AS year_min, YEAR(MAX(date_submit)) AS year_max FROM log_dataremove_report ";
	$result_year = mysql_db_query($cmssdatabase,$sql_year);
	$rs_year = mysql_fetch_assoc($result_year);
	$end_year = $rs_year['year_max']-((substr($rs_year['date_max'],6,10)<="10-01")?1:0);
	if($date_profile==""){
		$date_profile=$end_year.'-10-01:'.($end_year+1).'-09-30';
	}

	if($date_profile!=""){
		$arr_date = explode(":",$date_profile);
	}
	$sqlarea_history = "
	SELECT * FROM `area_history` WHERE ('".$arr_date[0]."' >=start_date AND '".$arr_date[0]."'<=end_date) AND ('".$arr_date[1]."'>= start_date AND '".$arr_date[1]."'<= end_date  )
	";
	$result = mysql_db_query($cmssdatabase,$sqlarea_history);
	$rs = mysql_fetch_assoc($result);
	if($rs['profile_id']!=""){		
		$tbl_eduarea = $rs['tbl_eduarea'];
		$tbl_allschool = $rs['tbl_allschool'];
		$sql="SELECT SELECT allschool.id as id ,allschool.office as caption, allschool.siteid as siteid FROM $tbl_allschool AS allschool WHERE allschool.id IS NOT NULL $where_cond";                
	}else{
		$sql="SELECT SELECT allschool.id as id ,allschool.office as caption, allschool.siteid as siteid FROM allschool WHERE allschool.id IS NOT NULL $where_cond";      
	}
    
 return  $sql;  

}
function tbl_allschool($date_profile=""){
 global $cmssdatabase;
	$date_profile = ($date_profile!="")?$date_profile:$_GET['date_profile'];
	$sql_year = "SELECT YEAR(MIN(date_submit)) AS year_min, YEAR(MAX(date_submit)) AS year_max FROM log_dataremove_report ";
	$result_year = mysql_db_query($cmssdatabase,$sql_year);
	$rs_year = mysql_fetch_assoc($result_year);
	$end_year = $rs_year['year_max']-((substr($rs_year['date_max'],6,10)<="10-01")?1:0);
	if($date_profile==""){
		$date_profile=$end_year.'-10-01:'.($end_year+1).'-09-30';
	}
	if($date_profile!=""){
		$arr_date = explode(":",$date_profile);
	}
	$sqlarea_history = "
	SELECT * FROM `area_history` WHERE ('".$arr_date[0]."' >=start_date AND '".$arr_date[0]."'<=end_date) AND ('".$arr_date[1]."'>= start_date AND '".$arr_date[1]."'<= end_date  )
	";
	$result = mysql_db_query($cmssdatabase,$sqlarea_history);
	$rs = mysql_fetch_assoc($result);
	if($rs['profile_id']!=""){		
		$tbl_allschool = $rs['tbl_allschool'];        
	}else{
		$tbl_allschool = 'allschool'; 
	}
 return  $tbl_allschool;  
}

/*
function gensql_edu($where_cond,$inner_cond,$type="edu",$fullarea=""){
 $where_cond= str_replace('provid','eduarea_math_provice.provid',$where_cond);  
 $where_cond= str_replace('secid','site',$where_cond); 
 $where_cond= str_replace('siteid','site',$where_cond); 
 $inner_cond= str_replace('provid','eduarea_math_provice.provid',$inner_cond);  
 $inner_cond= str_replace('secid','site',$inner_cond); 
 $inner_cond= str_replace('siteid','site',$inner_cond); 
 if($fullarea!=""){$sql_fullarea="and st_active='1'";}
 $_dispmode=$_GET['dispmode'];
 if($_dispmode=="edu1"){
	  $xcond=" and SUBSTR(eduarea.site,1,1)='0' ";
}else if($_dispmode=="edu2"){
	  $xcond=" and SUBSTR(eduarea.site,1,1)<>'0' ";
}
	$sql="SELECT eduarea.siteshortname as caption,eduarea.siteshortname as secname,eduarea.site as id,eduarea.site as secid,eduarea.site as siteid  FROM eduarea_config as eduarea Inner Join eduarea_math_provice ON eduarea.site = eduarea_math_provice.siteid  $inner_cond  where eduarea.group_type='report' $sql_fullarea $where_cond  $xcond  group by  eduarea.siteshortname,eduarea.site  order by orde_by";       
	 return  $sql;  
}*/
function disp_link($filename="?",$parameter="",$target="_blank",$onoff_link="1",$other=""){

$_fromsite=$_GET['fromsite'];
$_dispmode=$_GET['dispmode'];
$_xsiteid=$_GET['xsiteid'];
if($_fromsite!="1"){
	if($other==""){
		$link_prov=$filename."print_t=Y&xsiteid=$_xsiteid&action=showdata&Disp=list_prov&openfrom=prov&fromsite=$_fromsite$parameter";
		$link_eduall=$filename."print_t=Y&xsiteid=$_xsiteid&action=showdata&Disp=list_edu&openfrom=edu&fromsite=$_fromsite$parameter";
		$link_edu1=$filename."print_t=Y&xsiteid=$_xsiteid&action=showdata&Disp=list_edu&openfrom=edu&fromsite=$_fromsite&dispmode=edu1$parameter";
		$link_edu2=$filename."print_t=Y&xsiteid=$_xsiteid&action=showdata&Disp=list_edu&openfrom=edu&fromsite=$_fromsite&dispmode=edu2$parameter";
		//$str_link="<a href=\"$link_prov\" target=\"$target\">แสดงข้อมูลระดับจังหวัด<a>||<a href=\"$link_eduall\" target=\"$target\">เขตพื้นที่การศึกษา<a>";
	//	$str_link="<a href=\"$link_eduall\" target=\"$target\">เขตพื้นที่การศึกษา<a>";
		if(config_option=="1"){
			$str_link="<a href=\"$link_eduall\" target=\"$target\">สพท.ทั้งประเทศ<a>";
			 $str_link.=" [ <a href=\"$link_edu1\" target=\"$target\">สพม.<a> <a href=\"$link_edu2\" target=\"$target\">สพป.<a> ]";
		}else{
		$str_link="<a href=\"$link_prov\" target=\"$target\">แสดงข้อมูลระดับจังหวัด<a>||<a href=\"$link_eduall\" target=\"$target\">เขตพื้นที่การศึกษา<a>";
		}
	}else{
	   if(is_array($filename)){
			  foreach($filename as $index=>$val){
				    if($index==$other){
						if(config_option=="1"){
								$link_eduall=$val[link].$val[para];
								$link_edu1=$val[link].$val[para]."&dispmode=edu1";
								$link_edu2=$val[link].$val[para]."&dispmode=edu2";							
							$str_link.="<a href=\"$link_eduall\" target=\"$val[target]\">สพท.ทั้งประเทศ<a>";
			                $str_link.=" [ <a href=\"$link_edu1\" target=\"$val[target]\">สพม.<a> <a href=\"$link_edu2\" target=\"$val[target]\">สพป.<a> ]";
							}else{
								if($str_link!=""){$str_link.=" || ";}
							 $str_link.="<a href=\"$val[link]$val[para]\" target=\"$val[target]\">$val[caption]<a>";
							}					    
					}else{
						if(config_option!="1"){
						    	if($str_link!=""){$str_link.=" || ";}
					    	 $str_link.="<a href=\"$val[link]$val[para]\" target=\"$val[target]\">$val[caption]<a>";
						 }
					}
			}
		}	
	}
}
 $th_l_m = array('','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
$yy=date('Y')+543;
$m=date('n');
$d= intval(date('d'));
//$str_date="รายงาน ณ วันที่  $d ".$th_l_m[$m]." $yy";
$str_date= "";
if($onoff_link){
 $str_date="$str_date<br><br>".$str_link;
}
return    $str_date;
}

function count_eduAndschool($get_prov=""){
global $cmssdatabase,$xsiteid;
       $str=gen_educond("view_general.siteid");
	   if( $str!=""){ $str=" AND  $str"; }
	if($get_prov != ""){ 
		if(strlen(trim($get_prov))=='4'){
		$con_area = "    eduarea_math_provice.siteid ='$get_prov'";
		}else{
		$con_area = "    eduarea_math_provice.provid='$get_prov'";
		}
	
	}else{ $con_area = "";}
if($con_area!=""){$con_area="  AND  $con_area";}
$con_area.=" $str ";
 $sql="SELECT count(distinct view_general.siteid) as count_siteid,
count(distinct if(view_general.schoolid<> view_general.siteid,view_general.schoolid ,null)) as   count_schoolid 
FROM
view_general
Inner Join eduarea_math_provice ON view_general.siteid = eduarea_math_provice.siteid
WHERE 1=1 $con_area  ";
if($_GET['debug']=="on"){
	//echo $sql;
}
$val=array('site'=>"-", 'school'=>"-");
	$result1 = mysql_db_query($cmssdatabase,$sql);
	if($result1){
		$row=mysql_fetch_assoc($result1);
		$val=array('site'=>"$row[count_siteid]", 'school'=>"$row[count_schoolid]");
	}
	return  $val;
}

#################   function ตรวจสอบไฟล์ภาพที่เป็นรูป grayscale  Credit By  พี่น้อย
function CheckimageGrayscale($source_file){
	$im = ImageCreateFromJpeg($source_file); 
	$imgw = imagesx($im);
	$imgh = imagesy($im);
	#echo $imgw."X".$imgh;
	$frame_size = 10; 
	$cen_image = (($imgw/2)-($frame_size/2));
	$line_left = ($cen_image/2)/2;
	$frame_cen_position = array(array($cen_image,80) ,array($cen_image,160) ,array($cen_image,240) ,array($cen_image,320));
	$frame_left_position = array(array($line_left,80) ,array($line_left,160) ,array($line_left,240) ,array($line_left,320));
	$r = array();
	$g = array();
	$b = array();
	$int_frame=0;
		$c = 0;
		#line center
		foreach($frame_cen_position as $k=>$wh){
			$int_frame++;
			for ($i=$wh[0]; $i<($wh[0]+$frame_size); $i++){
				for ($j=$wh[1]; $j<($wh[1]+$frame_size); $j++){
					// get the rgb value for current pixel
					$rgb = ImageColorAt($im, $i, $j); 
					// extract each value for r, g, b
					$r[$i][$j] = ($rgb >> 16) & 0xFF; 
					$g[$i][$j] = ($rgb >> 8) & 0xFF; 
					$b[$i][$j] = $rgb & 0xFF; 
					// count gray pixels (r=g=b)
					if ($r[$i][$j] == $g[$i][$j] && $r[$i][$j] == $b[$i][$j]){
						$c++;
					}// end if ($r[$i][$j] == $g[$i][$j] && $r[$i][$j] == $b[$i][$j])
				}// end for ($j=0; $j<$imgh; $j++)
			}// end for ($i=0; $i<$imgw; $i++)
		}
		#line left
		foreach($frame_left_position as $k=>$wh){
			$int_frame++;
			for ($i=$wh[0]; $i<($wh[0]+$frame_size); $i++){
				for ($j=$wh[1]; $j<($wh[1]+$frame_size); $j++){
					// get the rgb value for current pixel
					$rgb = ImageColorAt($im, $i, $j); 
					// extract each value for r, g, b
					$r[$i][$j] = ($rgb >> 16) & 0xFF; 
					$g[$i][$j] = ($rgb >> 8) & 0xFF; 
					$b[$i][$j] = $rgb & 0xFF; 
					// count gray pixels (r=g=b)
					if ($r[$i][$j] == $g[$i][$j] && $r[$i][$j] == $b[$i][$j]){
						$c++;
					}// end if ($r[$i][$j] == $g[$i][$j] && $r[$i][$j] == $b[$i][$j])
				}// end for ($j=0; $j<$imgh; $j++)
			}// end for ($i=0; $i<$imgw; $i++)
		}
		if ($c == $int_frame*($frame_size*$frame_size)){
			return 1;
		}else{
			return 0;
		}//end if ($c == ($imgw*$imgh)){
}// end function CheckimageGrayscale($imgfile){

#Function หาคุณสมบัติตำแหน่งผู้บริหาร
function executive_position($executive_id){
	#$executive_id
	#1: ผู้บริหารสำนักงานเขตพื้นที่การศึกษา
	#2: รองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา
	#3: ผู้อำนวยการสถานศึกษา
	#4: รองผู้อำนวยการสถานศึกษา
	if($executive_id==1){
		#125471009:รองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา
		#325471008:ผู้อำนวยการสถานศึกษา
		$sql = "
			(( view_general.pid ='125471009' 
			  AND 
			  TIMESTAMPDIFF(YEAR, date( concat(  CAST( substring(  comeday,1,4) as UNSIGNED )-543,substring( comeday,5,10 ) ) ) ,NOW()) >=1
			)OR (
			  view_general.pid='325471008' 
			  AND (view_general.vitaya_id='3' OR view_general.vitaya_id='4' ) 
			))
		";
	}else if($executive_id==2){
		#125001002:ผู้ช่วยผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา
		#325471008:ผู้อำนวยการสถานศึกษา
		$sql = "
			(( 
				 view_general.pid='125001002' 
			)OR( 
				 view_general.positiongroup='1' AND view_general.salary >='8320' 
			)OR(
				 view_general.pid = '325471008' AND (view_general.vitaya_id='2' OR view_general.vitaya_id='3' OR view_general.vitaya_id='4' ) 
			))
		";
	}else if($executive_id==3){
		#325001010:รองผู้อำนวยการสถานศึกษา
		#125471009:รองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา
		#125001002:ผู้ช่วยผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา
		#425471000:ครู
		$sql = "
		((
		 view_general.pid='325001010' 
		 AND (TIMESTAMPDIFF(YEAR, date( concat(  CAST( substring(  comeday,1,4) as UNSIGNED )-543,substring( comeday,5,10 ) ) ) ,NOW()) >=1)
		)OR(
		 view_general.pid='125471009'
		)OR(
		 view_general.pid='125001002'
		)OR(
		 view_general.positiongroup='1'
		)OR(
		 view_general.pid='425471000' AND (view_general.vitaya_id='1' OR view_general.vitaya_id='2' OR view_general.vitaya_id='3' OR 
		view_general.vitaya_id='4' )
		))
		";
	}else if($executive_id==4){
		#425471000:ครู
		$sql = "
		((
		 view_general.pid='425471000' AND (TIMESTAMPDIFF(YEAR, date( concat(  CAST( substring(  comeday,1,4) as UNSIGNED )-543,substring( 
		comeday,5,10 ) ) ) ,NOW()) >=2) AND view_general.graduate_level='40'
		)OR(
		 view_general.pid='425471000' AND (TIMESTAMPDIFF(YEAR, date( concat(  CAST( substring(  comeday,1,4) as UNSIGNED )-543,substring( 
		comeday,5,10 ) ) ) ,NOW()) >=4) AND view_general.graduate_level='60'
		))
		";
	}
	return $sql;
}

function up_salary_areaprofile($xdate){
    $db="edubkk_master";
    $sql= "SELECT run_id,tbl_eduarea,tbl_allschool,start_date,end_date,profile_id,table_subfix FROM `area_history_main` where   '$xdate'  between  area_history.start_date and area_history.end_date ";
    $val=null;
    $result = mysql_db_query($db,$sql);
    if($result){
      $row=mysql_fetch_assoc($result);
       $val=array('eduarea'=>"$row[tbl_eduarea]","all_school"=>"$row[tbl_allschool]",'subfix'=>"$row[table_subfix]");  
       mysql_free_result($result); 
    }
    return  $val;
    
}

function AddSessoinVariable(){
	global $cmssdatabase,$ApplicationName;
	unset($arr_session);
	$arr_session = array();
	session_start();
	$serverip = $_SERVER['SERVER_NAME'];
	$file_name = basename($_SERVER['PHP_SELF']);
	
	
	$arr_session = $_SESSION;
	if(count($arr_session) > 0){
		foreach($arr_session as $key => $val){
			$sql_save = "REPLACE INTO temp_session_variable SET session_name='$key',session_val='$val',appname='$ApplicationName',filename='$file_name',urlfile='".str_replace("/var/www/html/","",$_SERVER['SCRIPT_FILENAME'])."',server_ip='$serverip'";
			mysql_db_query($cmssdatabase,$sql_save);				
		}
	}//end 	if(count($arr_session) > 0){
		
}//end function AddSessoinVariable(){
	
####################################### แสดง 	SQL แสดงคำนำหน้าชื่อ
	function GetSqlPrename($status_active="on"){
		global $cmssdatabase;
		if($status_active == "on"){
				$sql = "SELECT  prename_th, PN_CODE ,gender FROM $cmssdatabase.prename_th  WHERE prename_th !='' AND PN_CODE !='' AND active = 'on'  GROUP BY  PN_CODE ORDER BY  orderby , prename_th";
		}else{
				$sql = "SELECT  prename_th, PN_CODE ,gender FROM $cmssdatabase.prename_th  WHERE prename_th !='' AND PN_CODE !='' AND active = 'off'  GROUP BY  PN_CODE ORDER BY  orderby , prename_th";
		}
		
		return $sql;
	}

	function GetSqlPosition($status_active="yes"){
		global $cmssdatabase;
		if($status_active == "yes"){
			$sql = "select position from $cmssdatabase.hr_addposition_now  where  status_active='yes'  order by  position asc";		
		}else{
			$sql = "select position from $cmssdatabase.hr_addposition_now  where  status_active <> 'yes'  order by  position asc";	
		}
		
		return $sql;
	}//end function GetSqlPosition($status_active="yes"){
		
	###############  ตรวจสอบเพื่อแก้ไขวันเดือนปีเกิดใน กรณี เป็นการคีย์ครั้งแรก ########################
	
	function CheckFlagEditBirthday($idcard){
	global $dbnameuse,$dbnamemaster;
		$sql = "SELECT COUNT(idcard) as numid FROM monitor_keyin WHERE idcard='$idcard' GROUP BY idcard";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		if($rs[numid] <= 1){
				$sql2 = "SELECT COUNT(idcard) as num1 FROM general_flag_edit_birthday WHERE idcard='$idcard'";	
				$result2 = mysql_db_query($dbnamemaster,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				$rs2 = mysql_fetch_assoc($result2);
				if($rs2[num1] < 1){
					$xedit = 1;
				}
		}else{
				$xedit = 0;
		}
	return $xedit;
}

#### เก็บ log การแก้ไขวันเดือนปีเกิด
function SaveLogEditBirthday($idcard,$siteid){
	global $dbnamemaster;
	$sql = "REPLACE INTO general_flag_edit_birthday SET idcard='$idcard',siteid='$siteid' ";	
	mysql_db_query($dbnamemaster,$sql);
}

###function สำหรับสลับหน้ารายงานเดิมกับใหม่
function switchReport($name=""){
	$arr=explode("/",$_SERVER["SCRIPT_NAME"]);
	if($arr[2]=="report_new"){
		$link="../..".str_replace("competency_master/report_new/","report/",$_SERVER["SCRIPT_NAME"]);
		$linkChk="report/report_compare_person_report.php";
		$name.="(เดิม)";
	}else{
		$link="../..".str_replace("competency_master/report/","report_new/",$_SERVER["SCRIPT_NAME"]);
		$linkChk="report/report_compare_person_report.php";
		$name.="(ใหม่)";
	}
	$sty="
	<style>
		.btSwitch{
			vertical-align:middle;
			text-align:center;  
			background:#EEEEEE; 
			border:1px solid #000;
			display:block;
			padding:10px;
			margin:5px;
			float:left;
		}
		.btSwitch:hover{ cursor:pointer; background:BBBBBB; }
		.clr{ clear:both; }
	</style>
	";
	for($i=1;$i<=count($arr)-3;$i++){
		$l.="../";
	}
	$sty.="<a href='".$link."' class=\"btSwitch\" >".$name."</a>";
	$sty.="<a href='".$l.$linkChk."' class=\"btSwitch\" target='_blank'>หน้ารายงานสำเปรียบเทียบยอด</a>";
	$sty.="<div class='clr'></div>";
	if($_SESSION[session_username]=="cmss999"){
		echo $sty;
	}
}
#####################

function GetProvinceId(){
	global $dbnamemaster;
	$sql = "SELECT left(t1.ccDigi,2) as prov_id FROM `view_province` as t1";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[prov_id]] = $rs[prov_id];	
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetProvinceId(){
	
#### แสดงชือเขต

function GetSecAreaName($siteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$siteid'";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];
}// end function GetSecAreaName(){

### function แสดงชื่ออำเภอ
function GetGisAreaName($schoolid,$type=''){
	global $dbnamemaster;
	 if($type == "Changwat"){
		$subid = 2; // ข้อมูลระดับอำเภอ
	}else if($type == "Aumpur"){
		$subid = 4; // ข้อมูลระดับอำเภอ
	}else{
		$subid = 6; // ข้อมูลตำบล		
	}
	$sql = "SELECT
t1.ccName
FROM
ccaa AS t1
Inner Join allschool AS t2 ON Left(t2.moiareaid,$subid) = t1.areaid
WHERE
t2.id =  '$schoolid'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[ccName];
}

#### แปลงวันที่

function ConvertDateDBtoForm($d,$type='FORM'){
	
	
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	if($d == "0000-00-00") return "";
	if($d == "00/00/0000") return ""; 
	if($type=="DB"){
		$d1=explode("/",$d);
		return ($d1[2]). "-" . $d1[1] . "-" . $d1[0];
	}else if($type == "FORM"){
		$d1=explode("-",$d);
		return ($d1[2]). "/" . $d1[1] . "/" . $d1[0];		
	}
	
	
}

############### function แบ่งหน้า
function devidepage_report($total, $kwd , $sqlencode,$para){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page;
	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&$para&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&$para&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&$para&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&$para&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">ส่งออกรูปแบบ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}

#### Function ตรวจสอบการเป็นเจ้าหน้าที่เขตในการเข้าไปจัดการข้อมูล

function CheckUserAreaEdit($siteid){
	global $dbnameuse;
	$sql = "SELECT
count(t1.staffid) as num1
FROM
keystaff AS t1
where t1.staffid='".$_SESSION[session_staffid]."' and t1.site_area='$siteid'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];	
}// end function CheckUserAreaEdit($username,$siteid){

### หาข้อมูลการจำหน่วยที่ไม่ต้องดึงข้อมูลกลับ	
function GetidNOtReturn(){
		global $dbnamemaster;
		$sql = "SELECT id FROM retire WHERE status_return='0'";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'".$rs[id]."'";
		}//end 	while($rs = mysql_fetch_assoc($result)){
			return $in_id;
}	
	

#### ตรวจสอบข้อมูลจากการจำหน่ายออกไปในฐานกลางเพื่อย้ายเข้าอีกเขต
function GetDataCenterForImport($idcard,$status_retire=''){
	global $dbnamemaster;
	if($status_retire != ""){
			$conw = " AND retire_status='$status_retire'";	
	}else{
			$id_noreturn = GetidNOtReturn();
			if($id_noreturn != ""){
			$conw = " AND retire_status NOT IN($id_noreturn)";
			}else{
				$conw = "  ";	
			}
	}
	
	$sql = "SELECT count(idcard) as num FROM `tran_temp_center` where   idcard='$idcard' $conw";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
}

### ตรวจสอบข้อมูลจากฐานกลาง
function CheckDataCenterImport($idcard){
		global $dbname_center;
		$sql = "SELECT count(idcard) AS num1 FROM general WHERE idcard='$idcard'";
		$result = mysql_db_query($dbname_center,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


### funciton ล้างข้อมูลปลายทางก่อนย้าย
function CleanDataBeforeTranfer($siteid,$xidcard){
	$dbsite = "edubkk_".$siteid;
			mysql_db_query($dbsite,"DELETE  FROM  getroyal	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  general_pic	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  goodman	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  graduate	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM   hr_absent  WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_nosalary	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_other	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_prohibit	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_specialduty	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_teaching	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  salary	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  seminar	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  seminar_form	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  special	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  sheet	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  vitaya_stat	 WHERE id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_addhistoryaddress	 WHERE gen_id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_addhistoryfathername	 WHERE gen_id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_addhistorymarry	 WHERE gen_id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_addhistorymothername	 WHERE gen_id='$xidcard'");
			mysql_db_query($dbsite,"DELETE  FROM  hr_addhistoryname	 WHERE gen_id='$xidcard'");	
}

### นับข้อมูลใน cmss
function GetNumCmssImport($idcard){
	global $dbnamemaster;
	$sql = "SELECT count(CZ_ID) as num1 FROM view_general WHERE CZ_ID='$idcard'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function GetNumCmss($idcard){
	
	#### ตรวจสอบการ login เข้าสู่ระบบ เลื่อนขั้นเงินเดือนครั้งแรก
	function CheckLoginUpsalaryFirst($xsiteid,$username){
		global $dbnamemaster,$dateconfig;
		$dbsite = "edubkk_".$xsiteid;
		$sql = "SELECT
count(t1.schoolid) as num1
FROM
edubkk_master.training_register AS t1
Inner Join $dbsite.login AS t2 ON t1.schoolid = t2.id
Inner Join $dbsite.log_update AS t3 ON t2.username = t3.username
where date(t3.updatetime) >= '$dateconfig' and t2.username='$username' group by t2.username";	

		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}// end function CheckLoginUpsalaryFirst($xsiteid,$username){
		
	### function หาวันสิ้นสุดเริ่มและวันสิ้นสุดปีงบประมาณ
	function GetYearEstimate($year){
		$arr = array();
		if($year == "" or $year < 1) return "";
		if($year > 0 and $year < 2400){
				$year = $year+543;
		}
			$year_start = ($year-1)."-10-01";
			$year_end = $year."-09-30";
			$arr['year_start'] = $year_start;
			$arr['year_end'] = $year_end;
			return $arr;
		
	}// end 	function GetYearEstimate($year){

function search_namesimilar($name,$sname){
	$xsiteid=$_SESSION['siteid'];
$url="http://master.cmss-otcsc.com/competency_master/application/search_data_similar/index.php?n_name=$name&s_name=$sname&sel0=1&sel2=1&sel3=1&sel1=1&sel4=1&percen=80&submit=search1&secid_bypass=$xsiteid&xsiteid=$xsiteid&secid=$xsiteid";
$img="http://master.cmss-otcsc.com/competency_master/images_sys/searchb.gif";
return "<a href=\"$url\" target=\"_blank\"><img src='$img'/ border='0'></a>";
}


function CheckSearchEdit($siteid,$user,$pwd){
	global $dbnamemaster;
	$dbsite = "edubkk_".$siteid;
	$sql = "SELECT
t2.status_editdata
FROM
$dbsite.login AS t1
Inner Join $dbnamemaster.app_profile_detail AS t2 ON t1.runid = t2.staffid
where t1.username='$user' and t1.pwd='$pwd' and t2.siteid='$siteid'";	
	$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[status_editdata];
}



### function หาเลขบัตรที่ซ้ำ
function GetIdcardCmdReplace($master_id,$persend=0,$operation=">="){
		global $dbnamemaster;
		$cond1=($persend!="")?" and name_simila {$operation}{$persend}":"";
		$in_id = "";
		$sql = "SELECT
t3.idcard
FROM
up_salary_conf_master AS t1
Inner Join up_salary_conf AS t2 ON t1.master_id = t2.master_id
Inner Join temp_check_person_upsalary_replace AS t3 ON t2.profile_id2 = t3.profile_id AND t2.siteid = t3.siteid
where t1.master_id='$master_id' and LENGTH(t3.idcard)='13' $cond1
group by idcard
having count(t3.idcard) > 1";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'$rs[idcard]'";
	}
	return $in_id;
} // end function GetIdcardCmdReplace($master_id)


############### แสดงข้อมูลคำสั่งเลื่อนเงินเดือนซ้ำ
function GetNumPersonCmdReplace_OLD($master_id, $persend=0,$operation=">="){
	global $dbnamemaster;
	$cond1=($persend!="")?" and name_simila {$operation}{$persend}":"";
	$arr = array();
	$in_id = GetIdcardCmdReplace($master_id);
	
	$con_sqlarea =  " SELECT
eduarea_config.site
FROM
eduarea_config
where group_type='edu_pre' ";
	
	if($in_id != ""){ ## กรณีมีคนซ้ำ
	
						$sql2 = "SELECT
				t3.siteid,
				count(t3.idcard) as num,
				sum(if(t3.siteid=t3.schoolid,1,0)) as num_site,
				sum(if(t3.siteid<>t3.schoolid,1,0)) as num_school,
				sum(if(t3.idcard IN(".$in_id.") and t3.siteid IN(".$con_sqlarea."),1,0)) as num_inarea,
				sum(if(t3.idcard IN(".$in_id.") and t3.siteid IN(".$con_sqlarea.") and t3.siteid=t3.schoolid,1,0)) as num_inarea_site,
				sum(if(t3.idcard IN(".$in_id.") and t3.siteid IN(".$con_sqlarea.") and t3.siteid<>t3.schoolid,1,0)) as num_inarea_school,
				sum(if (!(((t3.idcard IN(".$in_id.")) and (t3.siteid IN(".$con_sqlarea.")))),1,0)) as num_notinarea,
				sum(if (!(((t3.idcard IN(".$in_id.")) and (t3.siteid IN(".$con_sqlarea.")))) and t3.siteid=t3.schoolid ,1,0)) as num_notinarea_site,
				sum(if (!(((t3.idcard IN(".$in_id.")) and (t3.siteid IN(".$con_sqlarea.")))) and t3.siteid<>t3.schoolid,1,0)) as num_notinarea_school
				
				FROM
				up_salary_conf_master AS t1
				Inner Join up_salary_conf AS t2 ON t1.master_id = t2.master_id
				Inner Join temp_check_person_upsalary_replace AS t3 ON t2.profile_id2 = t3.profile_id AND t2.siteid = t3.siteid
				where t1.master_id='$master_id' and t3.idcard IN(".$in_id.") $cond1
				group by t3.siteid";
					$result2 = mysql_db_query($dbnamemaster,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LNE__);
					while($rs2 = mysql_fetch_assoc($result2)){
							$arr[$rs2[siteid]]['numall'] = $rs2['num'];
							$arr[$rs2[siteid]]['num_site'] = $rs2['num_site'];
							$arr[$rs2[siteid]]['num_school'] = $rs2['num_school'];
							$arr[$rs2[siteid]]['num_inarea'] = $rs2['num_inarea'];
							$arr[$rs2[siteid]]['num_inarea_site'] = $rs2['num_inarea_site'];
							$arr[$rs2[siteid]]['num_inarea_school'] = $rs2['num_inarea_school'];
							$arr[$rs2[siteid]]['num_notinarea'] = $rs2['num_notinarea'];
							$arr[$rs2[siteid]]['num_notinarea_site'] = $rs2['num_notinarea_site'];
							$arr[$rs2[siteid]]['num_notinarea_school'] = $rs2['num_notinarea_school'];	
					}	
			} // end if($in_id != "")
	return $arr;		
}// end GetNumPersonCmdReplace_OLD($master_id)


## function ในการ เช็คเขตที่เป็นเขตนำร่อง
function GetNumCmdContinute($master_id,$idcard,$siteid,$orderid='',$persend=0,$operation=">="){
	global $dbnamemaster;
		$cond1=($persend!="")?" and name_simila {$operation}{$persend}":"";
	$arr1 = array();
	$sql = "SELECT
t3.siteid,
t3.schoolid,
t3.idcard,
t3.order_id,
if(t3.siteid IN(SELECT
eduarea_config.site
FROM
eduarea_config
where group_type='edu_pre'),1,0) as flag_area
FROM
up_salary_conf_master AS t1
Inner Join up_salary_conf AS t2 ON t1.master_id = t2.master_id
Inner Join temp_check_person_upsalary_replace AS t3 ON t2.profile_id2 = t3.profile_id AND t2.siteid = t3.siteid
where t1.master_id='$master_id' and t3.idcard='$idcard' and ((t3.order_id<>'$orderid' and t3.siteid='$siteid') or t3.siteid<>'$siteid')  $cond1";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
		if($rs[flag_area] == "1"){
				$arr1[$rs[idcard]]['inarea']++;
				if($rs[schoolid] == $rs[siteid]){
					$arr1[$rs[idcard]]['inarea_site']++;	
				}else{
					$arr1[$rs[idcard]]['inarea_school']++;		
				}
		}else{
				$arr1[$rs[idcard]]['notinarea']++;
				if($rs[schoolid] == $rs[siteid]){
						$arr1[$rs[idcard]]['notinarea_site']++;
				}else{
						$arr1[$rs[idcard]]['notinarea_school']++;
				}
		}

	
	return $arr1;
}

function GetNumPersonCmdReplace($master_id,$persend=0,$operation=">="){
	global $dbnamemaster;
	$arr = array();
	$in_id = GetIdcardCmdReplace($master_id,$persend,$operation);
	$cond1=($persend!="")?" and name_simila {$operation}{$persend}":"";
	if($in_id != ""){
	 $sql = "SELECT
			t3.siteid,
			t3.schoolid,
			t3.idcard,
			t3.order_id,
			if(t3.siteid IN(SELECT
			eduarea_config.site
			FROM
			eduarea_config
			where group_type='edu_pre'),1,0) as flag_area
			FROM
			up_salary_conf_master AS t1
			Inner Join up_salary_conf AS t2 ON t1.master_id = t2.master_id
			Inner Join temp_check_person_upsalary_replace AS t3 ON t2.profile_id2 = t3.profile_id AND t2.siteid = t3.siteid
			where t1.master_id='$master_id' and t3.idcard IN(".$in_id.")  $cond1
			GROUP BY t3.siteid,t3.schoolid,t3.idcard
			order by t3.idcard asc";
			//echo $sql;
			//if($cond1!=""){
			//echo $sql;
			//}
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$site = $rs[siteid];
			$school = $rs[schoolid];
			$arr[$site]['numall'] = $arr[$site]['numall']+1;
			$arr[$site][$rs['order_id']] =$arr[$site][$rs['order_id']] +1;
			if($site == $school){
				$arr[$site]['num_site'] = $arr[$site]['num_site']+1;	
			}else{
				$arr[$site]['num_school'] = $arr[$site]['num_school']+1;	
			}
			
			## จำนวนข้อมูล
			$arr_data = GetNumCmdContinute($master_id,$rs[idcard],$site,$rs[order_id],$persend,$operation);
		
			$arr[$site]['num_inarea'] += $arr_data[$rs[idcard]]['inarea'];	
			$arr[$site]['num_inarea_site'] += $arr_data[$rs[idcard]]['inarea_site'];	
			$arr[$site]['num_inarea_school'] += $arr_data[$rs[idcard]]['inarea_school'];	
			$arr[$site]['num_notinarea'] += $arr_data[$rs[idcard]]['notinarea'];	
			$arr[$site]['num_notinarea_site'] += $arr_data[$rs[idcard]]['notinarea_site'];	
			$arr[$site]['num_notinarea_school'] += $arr_data[$rs[idcard]]['notinarea_school'];	
			unset($arr_data);			
		}
	}//end $in_id
	
	return $arr;
}// end function GetNumCmdRNew($master_id)



?>