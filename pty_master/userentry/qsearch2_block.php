<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "search"; 
$process_id			= "search";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		ระบบ login userentry
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################





if(!isset($session_staffid)){
echo "<script type=\"text/javascript\">
window.location=\"login.php\";
</script>";
}


include "../../config/conndb_nonsession.inc.php";
include ("../../common/common_competency.inc.php")  ;
include("function_block_key.php");
$time_start = getmicrotime();
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	function xGetNumFileQc(){
		global $dbnameuse;
		$sql = "SELECT count(distinct t1.ticketid) as num1
FROM ".DB_USERENTRY.".validate_checkdata as t1
Inner Join ".DB_USERENTRY.".keystaff  as t2 ON t1.staffid = t2.staffid
Inner Join  ".DB_MASTER.".view_general as t3 ON t1.idcard = t3.CZ_ID
Inner Join ".DB_USERENTRY.".validate_checkdata_upload as t4 ON t1.ticketid=t4.ticketid AND t1.staffid=t4.staffid AND t1.idcard=t4.idcard
WHERE   t2.staffid='".$_SESSION['session_staffid']." '
GROUP BY  t2.staffid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
	}// end 	function GetNumFileQc(){



$sql_staff = "SELECT * FROM keystaff  WHERE staffid='$session_staffid'";
//echo "$db_name";
$result_staff = mysql_db_query(DB_USERENTRY,$sql_staff);
$rs_staff = mysql_fetch_assoc($result_staff);


function CountEditKey(){
	global $dbnameuse;
	$sql = "SELECT COUNT(t2.idcard) AS num1 FROM ".DB_USERENTRY.".tbl_assign_edit_sub as t1 Inner Join ".DB_USERENTRY.".tbl_assign_edit_key as t2 ON t1.ticketid = t2.ticketid 
WHERE t1.staffid='".$_SESSION['session_staffid']."' and t2.userkey_wait_approve ='0' ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end CountEditKey(){


################  กรณีที่มีใบงานแก้ไขต้องแก้งานแก้ไขก่อนที่จะทำการคีย์ข้อมูลของตนเอง##################
/*
if(CountEditKey() > 0){ // กรณีมีใบงานแก้ไข
	echo "<script type=\"text/javascript\">
	alert('ขณะนี้มีงานที่คุณต้องแก้ไขอยู่\nต้องทำการแก้ไขใบงานแก้ไขให้เสร็จสิ้นก่อนถึงจะทำการคีย์ข้อมูลในใบงานปกติได้');
window.location=\"qsearch2_edit.php\";
</script>";
}//end if(CountEditKey() > 0){ // กรณีมีใบงานแก้ไข

*/

########################  end กรณีที่มีใบงานแก้ไขต้องแก้งานแก้ไขก่อนที่จะทำการคีย์ข้อมูลของตนเอง ################


if($rs_staff[flag_change_password] == "1"){
	echo "<br><br><center><font color='red'><h3>ท่านได้มีการยื่นขอรหัสผ่านใหม่และระบบได้ทำการสุ่มรหัสผ่านให้ท่าน<br>ดังนั้นท่านต้องเปลี่ยนรหัสผ่านของท่านอีกครั้งในเมนูแก้ไขข้อมูลส่วนตัว<br>แล้วทำการเปลี่ยนรหัสผ่านอีกครั้งจึงจะสามารถเข้าไปบันทึกข้อมูลบุคลากรได้</h3></font></center>";	
	die;
}

//$user_ip = $_SERVER["REMOTE_ADDR"] ;
//$user_ipx = $_SERVER['SERVER_ADDR'];
$user_ip = getenv("SERVER_NAME"); 
$sub_ipaddress = substr($user_ip,0,8);//  ตรวจสอบ ip 


function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xmode,$xtype,$sname,$slastname,$idcard,$action;

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
			$table .= "<a href=\"?page=1&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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

#### function ตรวจสอบการ upload รูป
function CheckUploadPic($get_staffid){
	$db_name = DB_USERENTRY;	
	$path_img = "images/personnel/";
	$sql_pic = "SELECT image FROM keystaff WHERE staffid='$get_staffid'";
	$result_pic = mysql_db_query($db_name,$sql_pic);
	$rs_pic = mysql_fetch_assoc($result_pic);
	if($rs_pic[image] == ""){
			return 0;
	}else{
			$file_img = $path_img.$rs_pic[image];
		if(!is_file($file_img)){
			return 0;
		}else{
			return 1;	
		}
	}
}//end function CheckUploadPic($get_staffid){
	
	


function check_status_job($idcard){
	$sql = "SELECT * FROM tbl_assign_key WHERE  idcard='$idcard' AND nonactive='0'";
	$result = mysql_db_query(DB_USERENTRY,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[approve];
}


	function add_log($subject,$idcard,$action){
		global $server_id,$database1;
			$uname = $_SESSION[session_username];
			$ip = get_real_ip();
			$sql = "insert into log_update(server_id,logtime,username,subject,target_idcard,user_ip,action) values('$server_id',now(),'$uname','$subject','$idcard','$ip','$action');";
			mysql_db_query($database1,$sql);
	}
	
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
		

############  กรณีข้อมูลของคนนี้ผู้กับ ticket และมีการ
	function check_assign_key($idcard,$staffid){

	//global $db_name;
			$sql_assign_key = "SELECT tbl_assign_sub.staffid FROM tbl_assign_key
Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
Inner Join monitor_keyin ON tbl_assign_sub.staffid = monitor_keyin.staffid
WHERE
tbl_assign_key.idcard =  '$idcard' AND tbl_assign_key.nonactive='0'";
		$result_assign_key = @mysql_db_query(DB_USERENTRY,$sql_assign_key);
		$rs_k = @mysql_fetch_assoc($result_assign_key);
			if($rs_k[staffid] != ""){
					if($rs_k[staffid] != $staffid){ // แสดงว่าเป็นคนละคน
							$xvalue = "1";
					}else{
							$xvalue = "0";
					}
			}else{
					$xvalue = "0";
			}
			
	//echo $idcard." == ".$staffid." == ".$rs_k[staffid] ."== ".$xvalue;
		return $xvalue;
	}
####  ตรวจสอบว่าคนที่เข้าไปบันทึกข้อมูลมีการ assign งานหรือไม่ถ้ามีใ้หเก็บ log โดยไม่สนใจสิทธิการบันทึกข้อมูล
	function CheckAssign($get_staffid,$get_idcard){
		$sql_checkAssign = "SELECT  count(tbl_assign_key.idcard) as num_assign  FROM tbl_assign_sub Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid WHERE tbl_assign_sub.nonactive =  '0' AND tbl_assign_key.idcard =  '$get_idcard' AND
tbl_assign_sub.staffid =  '$get_staffid' GROUP BY tbl_assign_sub.staffid ";
		$result_checkAssign = mysql_db_query(DB_USERENTRY,$sql_checkAssign);
		$rs_chA = mysql_fetch_assoc($result_checkAssign);
		return $rs_chA[num_assign];
		
	}//end function CheckAssign(){
###  end ตรวจสอบว่าคนที่เข้าไปบันทึกข้อมูลมีการ assign งานหรือไม่ถ้ามีใ้หเก็บ log โดยไม่สนใจสิทธิการบันทึกข้อมูล


/*if(CheckUploadPic($_SESSION[session_staffid]) == 0){
		if($_SESSION[session_sex] == "F" and $_SESSION[session_sapphire] != "1"){
			$msg_name = $_SESSION[session_staffname];
			echo "<script>alert('$msg_name คุณยังไม่ได้ upload รูปในระบบ กรุณา upload รูปที่ในระบบด้วยครับ\\n รูปที่ upload ควรเป็นรูปเดี่ยวหน้าตรง ขนาดรูปควรเป็น 150 x 180 px'); location.href='user_image.php?extra=1';</script>";
			exit;
			
		}else{
		echo "<script>alert('ท่านยังไม่ได้ upload รูปในระบบ กรุณา upload รูปในระบบด้วย\\n รูปที่ upload ควรเป็นรูปเดี่ยวหน้าตรง ขนาดรูปควรเป็น 150 x 180 px'); location.href='user_image.php?extra=1';</script>";
		exit;

		}		
}//end if(CheckUploadPic($_SESSION[session_staffid]) == 0){
*/?>
<html>
<TITLE>ตรวจสอบข้อมูล Competency</TITLE>
<META content="text/html; charset=windows-874" http-equiv=Content-Type>
<LINK href="../../common/style.css" rel=stylesheet type="text/css">
<script  language="javascript">

  var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
  	  }
	}
	

function con_accp() {
	if (confirm("การบันทึกข้อมูลตามช่วงเวลานี้มีคนบันทึกเข้าไปในระบบแล้ว! คุณต้องการบันทึกข้อมูลซ้ำใช้หรือไม่?")) { 
		window.location="qsearch2.php?action=accept";
		return true; 
	}else{
		return false;
	}

}


</script>

<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>

</HEAD>
<BODY>

<H1 align=center>ตรวจสอบข้อมูล Competency จากทุก Server  </H1>
<?

$dbcall = DB_USERENTRY;

		$dd = date("d");
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$hh = date("H:i:s");
		$gendate = "$yy-$mm-$dd"." ".$hh;

 


if($action == "accept"){
//check_assign_key($_SESSION[id],$session_staffid);
//	echo "<pre>";
//	print_r($_SESSION);
	$namekey= "$_SESSION[name] "." $_SESSION[surname]";
	$_SESSION[userkeyin] = true;
	
/*			if((check_assign_key($_SESSION[id],$session_staffid) == "1") and $session_sapphire != "1" and ($_SESSION[session_status_extra] != "QC") ){
				echo "<script>alert('ไม่สามารถบันทึกได้เนื่องจาก บุคลากรชื่อ $namekey  มีคนคีย์ไปแล้ว'); location.href='qsearch2.php?name_th=$name&surname_th=$surname&idcard=$id&action=login&siteid=$siteid';</script>";
				exit;
				
		}
*/
 ##  สถานะ การบันทึกข้อมูลของ พนักงานคีย์ข้อมูล
if($_SESSION['session_sapphire'] == 1){
	$status_user = 1; // พนักงาน sapphire
}else if($_SESSION['session_sapphire'] != 1 and $_SESSION['session_status_extra'] == "QC"){
	$status_user = 2; // ลูกจ้างชั่วคราวที่กำหนดในเป็น qc
}else{
	$status_user = 0;// พนักงานจ้าง
}

#### เก็บเวลาล่าสุดที่ sum เข้าไปบันทึกข้อมูล
$sql_a1 = "SELECT tbl_assign_sub.staffid FROM tbl_assign_key Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
WHERE tbl_assign_key.idcard =  '$_SESSION[id]' AND  tbl_assign_key.nonactive =  '0'";
$resulta1 = mysql_db_query($dbcall,$sql_a1);
$rsa1 = mysql_fetch_assoc($resulta1);
if($rsa1[staffid] == $_SESSION[session_staffid]){
		$update_time_key = " , timeupdate_user = NOW()";
}else{
		$update_time_key = "";	
}//end 
	
	//if($session_sapphire != "1" and ($_SESSION[session_status_extra] != "QC")){ // บันทึกกรณีไม่ใช่พนักงาน บริษัท sapphire และพนักงาน QC

		$sql_check_k = "SELECT COUNT(monitor_keyin.idcard) as num1 FROM tbl_assign_key Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard WHERE tbl_assign_key.nonactive =  '0' AND monitor_keyin.staffid =  '$_SESSION[session_staffid]' AND
tbl_assign_key.idcard =  '$_SESSION[id]' GROUP BY monitor_keyin.staffid";
		$result_check_k = mysql_db_query($dbcall,$sql_check_k);
		$rs_ck = mysql_fetch_assoc($result_check_k);
		$chnum = $rs_ck[num1];
		
		if(CheckAssign($_SESSION[session_staffid],$_SESSION[id]) > 0){  ## ตรวจสอบการเก็บ log ใน monitor keyin ต้องมาจากกระบวนการ assgin งานเท่านั้น
			
			if($chnum > 0){ // กรณีมีการบันทึกรายการซ้ำเดิมไม่ update  timeupdate
					$str = " UPDATE   monitor_keyin SET siteid = '$_SESSION[secid]' ,keyin_name = '$namekey' , timestamp_key = NOW(), status_user='$status_user' $update_time_key  WHERE  staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]'  ";
			}else{
					##  กรณีเป็นพนักงานคนเดิมคีย์บุคลากรคนเดิมจากโครงการปีที่แล้วให้ update เนื่องจาก primary key เป็น idcard และ staffid 
					$sqlc1 = "SELECT COUNT(staffid) AS num2 FROM  monitor_keyin WHERE staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]' GROUP BY staffid";
					$resultc1 = mysql_db_query($dbcall,$sqlc1);
					$rsc1 = mysql_fetch_assoc($resultc1);
					if($rsc1[num2] > 0){
						$str = " UPDATE   monitor_keyin SET siteid = '$_SESSION[secid]' ,keyin_name = '$namekey' ,timeupdate,=NOW(), timestamp_key = NOW(), status_user='$status_user' $update_time_key  WHERE  staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]' ";	
					}else{
						$str = " INSERT INTO  monitor_keyin(staffid,idcard,siteid,keyin_name,timeupdate,timestamp_key,status_user,timeupdate_user) VALUES ('$_SESSION[session_staffid]','$_SESSION[id]','$_SESSION[secid]','$namekey',NOW(),NOW(),'$status_user',NOW()) ";
					}//end if($rsc1[num2] > 0){
			}//end if($chnum > 0){
	//echo $str;die;
	mysql_db_query($dbcall,$str);
	
		}//end if(CheckAssign($_SESSION[secid],$_SESSION[id]) > 0){ 
	 ##  end ตรวจสอบการเก็บ log ใน monitor keyin ต้องมาจากกระบวนการ assgin งานเท่านั้น
	//}// end 	if($session_sapphire != "1"){
/*		$sql_area = "SELECT area_info.intra_ip,area_info.IP,area_info.area_name, eduarea.secid, eduarea.area_id FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id WHERE eduarea.secid =  '$_SESSION[secid]'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
*///		if($sub_ipaddress == "192.168."){
//			$redirec_ip = $rs_area[intra_ip];	
//		}else{
//			$redirec_ip = $rs_area[IP];		
//		}
		
		$redirec_ip = APPHOST_TEST;
		$log_ip_login = $_SESSION[id];
		$database1 = STR_PREFIX_DB.$_SESSION[secid];
		## ตรวจสอบสิทธิการเข้าถึงข้อมูลป้องกัน sub คีย์ข้อมูลข้างในบริษัท
		if($sub_ipaddress == "192.168." and $session_sapphire == "2"){
		$sql_log = "INSERT INTO log_check_staffkey SET staffid='$_SESSION[session_staffid]',idcard='$_SESSION[id]',siteid='$_SESSION[secid]'";
		mysql_db_query($dbcall,$sql_log);
		echo "<script> alert('ท่านไม่มีสิทธิบันทึกข้อมูลเนื่องจากท่านได้ถูกกำหนดช่วงเวลาการบันทึกข้อมูลไว้แล้ว');top.location.href='http://$redirec_ip".APPNAME."application/userentry/login_main.php';</script>";
		exit;
		}else{
		add_log("เข้าสู่ระบบ","$log_ip_login","login");
		echo "<script>top.location.href='http://$redirec_ip".APPNAME."application/hr3/hr_frame/frame.php';</script>";
		exit;
		}//end 	if($sub_ipaddress == "192.168." and $session_sapphire == "2"){

}


if($action == "login"){
			
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $idcard ;
				$_SESSION[name] = $name_th ;
				$_SESSION[surname] = $surname_th ;
				$_SESSION[session_username] = $idcard;
				$_SESSION[idoffice] = $idcard ;
				$_SESSION[secid] = $xsiteid ;
				$_SESSION[temp_dbsite] = STR_PREFIX_DB.$xsiteid;
				//echo "<pre>";
				//print_r($_SESSION);die;
				
				####  update สถานะการคีย์ข้อมูลว่าได้บันทึกข้อมูลไปแล้ว
				$sql_key = "UPDATE tbl_assign_key SET status_keydata='1' WHERE idcard='$idcard'";
				mysql_db_query($dbcall,$sql_key);
				
				$sqla = " SELECT  *  FROM  keystaff  WHERE  staffid = '$_SESSION[session_staffid]'  ";
				 //echo "$sqla";
				$resulta = mysql_db_query($dbcall,$sqla);
				$rsa = mysql_fetch_assoc($resulta);
				
				$namestaff = " $rsa[prename]$rsa[staffname]  $rsa[staffsurname]  ";

$temp_name_th = "$name_th $surname_th";

if($_SESSION['session_sapphire'] == "1"){ // กรณีเป็นเจ้าหน้าที่ sapphire ไม่ต้องขึ้นหน้ายืนยัน
/*			$sql_area = "SELECT area_info.intra_ip,area_info.IP,area_info.area_name, eduarea.secid, eduarea.area_id FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id WHERE eduarea.secid =  '$_SESSION[secid]'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		if($sub_ipaddress == "192.168."){
			$redirec_ip = $rs_area[intra_ip];	
		}else{
			$redirec_ip = $rs_area[IP];		
		}
*/		
	$redirec_ip = APPHOST_TEST;
	## ตรวจสอบสิทธิการเข้าถึงข้อมูลป้องกัน sub คีย์ข้อมูลข้างในบริษัท
	if($sub_ipaddress == "192.168." and $rsa[sapphireoffice] == "2"){
		$sql_log = "INSERT INTO log_check_staffkey SET staffid='$_SESSION[session_staffid]',idcard='$_SESSION[id]',siteid='$_SESSION[secid]'";
		mysql_db_query($dbcall,$sql_log);
		echo "<script> alert('ท่านไม่มีสิทธิบันทึกข้อมูลเนื่องจากท่านได้ถูกกำหนดช่วงเวลาการบันทึกข้อมูลไว้แล้ว');top.location.href='http://$redirec_ip".APPNAME."application/userentry/login_main.php';</script>";
		exit;
	}else{
		echo "<script>top.location.href='http://$redirec_ip".APPNAME."application/hr3/hr_frame/frame.php';</script>";
		exit;
	}//end if($sub_ipaddress == "192.168." and $session_sapphire == "2"){

}// end if($session_sapphire == "1"){ // กรณีเป็นเจ้าหน้าที่ sapphire ไม่ต้องขึ้นหน้ายืนยัน

?>
<table width="661" border=0 align=center cellpadding=5 cellspacing=1 bgcolor="#404040">
  <tr height=30>
    <td colspan="2" bgcolor="#808070" class="Label_big_black">ท่านกำลังจะเริ่มบันทึกข้อมูลของ</td>
  </tr>
  <tr>
    <td width="133" height="28" bgcolor="#808070"><B>ชื่อ-นามสกุล</B></td>
    <td width="505" bgcolor="#FFFFCC">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="62%"><h2><? echo " $name_th  $surname_th "; ?></h2></td>
          <td width="38%" align="center"><? 
		  $sql_site = "SELECT * FROM general_pic WHERE id='$idcard'  AND kp7_active='1' ORDER BY yy  DESC LIMIT 1 ";
		  $xdbsite = STR_PREFIX_DB.$xsiteid;
		  //echo $xdbsite." :: ".$sql_site;
		  $result_site = mysql_db_query($xdbsite,$sql_site);
		  $rssite = mysql_fetch_assoc($result_site);
		  $img_filex = "../../../image_file/$xsiteid/$rssite[imgname]";
		 // echo "<a href='$img_filex' target='_blank'>$img_filex</a>";
		  if(is_file($img_filex)){
		 	 echo "<img src='$img_filex' width='120' height='160'>";
		  }else{
			echo "<img src=\"../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border=\"0\" title=\"ไม่มีภาพ ก.พ.7 ต้นฉบับ\">"; 		 
		 }//end   if(is_file($img_filex)){
		  
		  ?></td>
        </tr>
    </table></td>
  </tr>
  <tr height=30>
    <td height="28" bgcolor="#808070"><B>เลขหมายบัตรประชาชน</B></td>
    <td bgcolor="#FFFFCC"><h2><?=$idcard?></h2></td>
  </tr>
  <tr height=30>
    <td height="30" bgcolor="#808070"><B>ผู้บันทึก</B></td>
    <td bgcolor="#FFFFCC">&nbsp;<?=$namestaff?> </td>
  </tr>
  <tr height=30>
    <td colspan=2 align=center bgcolor="#FFFFCC" class="Label_big_black"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFCC"><b>Log การบันทึกข้อมูล</b></td>
            </tr>
          <tr>
            <td width="51%" align="center" bgcolor="#FFFFCC"><b>รายชื่อผู้บันทึก</b></td>
            <td width="49%" align="center" bgcolor="#FFFFCC"><b>เวลาที่บันทึก</b></td>
          </tr>
		  <?
$date_chd = "2009-12-01"; // เวลาเริ่มต้นบันทึกข้อมูล
 $sql_check = "SELECT
keystaff.staffname,
keystaff.staffsurname,
monitor_keyin.timeupdate
FROM
monitor_keyin
Inner Join keystaff ON monitor_keyin.staffid = keystaff.staffid
WHERE
monitor_keyin.idcard =  '$idcard'
AND 
monitor_keyin.status_user='0'
order by monitor_keyin.timeupdate ASC ";
$result_ch = mysql_db_query($dbcall,$sql_check);
$n=0;
$check_conf = 0;
while($rs_ch = mysql_fetch_assoc($result_ch)){
if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $n++;
$arr_d = explode(" ",$rs_ch[timeupdate]);
$arr_d1 = explode("-",$arr_d[0]);
if($arr_d[0] >= $date_chd ){
$check_conf ++;
	$show_date = "<font color='red' size='35'> วันที่ ".intval($arr_d1[2])." ".$mname[intval($arr_d1[1])]." ".($arr_d1[0]+543)."</font>";
}else{
	$show_date = "<font size='35'>วันที่ ".intval($arr_d1[2])." ".$mname[intval($arr_d1[1])]." ".($arr_d1[0]+543)."</font> ";
}

		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center" bgcolor="#FFFFFF"><? echo "$rs_ch[staffname]  $rs_ch[staffsurname]";?></td>
            <td align="center" bgcolor="#FFFFFF"><? echo $show_date;?></td>
          </tr>
<?
	}
?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr height=30>
    <td colspan=2 align=center bgcolor="#FFFFCC" class="Label_big_black">ระบบกำลังจะบันทึกการทำงานของท่าน เมื่อกดตกลง <br>
    <? if($check_conf > 0){ echo "<font color='red' size='35'><img src=\"../../images_sys/alert.gif\" width=\"31\" height=\"32\" border=\"0\" alt=\"สถานะแจ้งเตือนการบันทึกข้อมูลซ้ำ\">คุณกำลังบันทึกข้อมูลซ้ำ</font>";}else{ echo "";}
		/*if(($session_sapphire == "1" ) or ($_SESSION[session_status_extra] == "QC")){  echo "<font color='red' size='20'> ในกรณีเป็นเจ้าหน้าที่ของบริษท SAPPHIRE หรือ เจ้าหน้าที่ QC ที่จะเข้าไปตรวจสอบข้อมูล ก.พ.7 <br>
ระบบจะไม่เก็บ log การเข้าบันทึกข้อมูล</font>";}*/
	?>
    <br>
    <br>
    <font color="#FF0000">กรุณาตรวจสอบข้อมูลบุคลากรที่ท่านจะทำการบันทึกข้อมูลให้ดีก่อนทำการบันทึกข้อมูล</font></td>
  </tr>
  <tr height=30>
    <td colspan=2 align=center><? if($check_conf > 0){?> <INPUT name="Button" TYPE="button" VALUE="     ตกลง     " onClick="return con_accp();"><? } else{?><INPUT name="Button" TYPE="button" VALUE="     ตกลง     " onClick="location.href='?action=accept';"><? } ?>
    <INPUT name="reset" TYPE="reset" ONCLICK="history.back();"  VALUE="   ยกเลิก   ">
	</td>
  </tr>
</table>
<? exit; } ?>
<?			
connserver(HOST) ;  
# $dbnamemaster=DB_MASTER; 

$sname = trim($sname); 
$slastname = trim($slastname) ; 



########################################### จำนวน Server ในระบบ
if(count($session_arr_siteid) > 0){
	foreach($session_arr_siteid as $k => $v){
		$sql = "SELECT area_info.intra_ip,area_info.IP,area_info.area_name, eduarea.secid, eduarea.area_id FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id WHERE eduarea.secid =  '$v'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
			$arrserver_ip[$rs[area_id]] = $rs[IP] ; 
			$arrserver_intraip[$rs[area_id]] = $rs[intra_ip] ; 
			$arrserver_name[$rs[area_id]] = $rs[area_name] ; 
			$siteid = $rsl[secid] ;  $nonm++; 
			$rsip = $rsl[IP] ; 
			$arr_site[$nonm] = $siteid  ; 
			$arr_ip_nai[$siteid] = $rsl[intra_ip] ; 
			$arr_ip_real[$siteid] = $rsip ; 	
			$arr_secname[$siteid] = $rsl[secname] ;
	}// end foreach(){
}// end if(count($session_arr_siteid]) > 0){
//$sql = " SELECT * FROM `area_info`  WHERE    `area_info`.area_id = 4    order by IP  "; 
//$result = mysql_db_query($dbnamemaster , $sql) ; 
//while($rs = mysql_fetch_assoc($result)){ 
//	
//	$arrserver_ip[$rs[area_id]] = $rs[IP] ; 
//	$arrserver_intraip[$rs[area_id]] = $rs[intra_ip] ; 
//	$arrserver_name[$rs[area_id]] = $rs[area_name] ; 
//} #### END while($rs = mysql_fetch_assoc($result)){ 


$sqll = " 
SELECT   `eduarea`.`secid`,   `eduarea`.`secname`,  `area_info`.`IP` ,   intra_ip 
FROM  `area_info`    Inner Join `eduarea` ON `area_info`.`area_id` = `eduarea`.`area_id`     WHERE  eduarea.status_area53 =  '1'
ORDER BY  IP , secname
" ;
$resultl = mysql_db_query( $dbnamemaster ,  $sqll); 
echo mysql_error() ;
while ($rsl = mysql_fetch_assoc($resultl)){
if ($rsl[secid] == 9999){ continue; } 
	$siteid = $rsl[secid] ;  $nonm++; 
	$rsip = $rsl[IP] ; 
	$arr_site[$nonm] = $siteid  ; 
	$arr_ip_nai[$siteid] = $rsl[intra_ip] ; 
	$arr_ip_real[$siteid] = $rsip ; 	
	$arr_secname[$siteid] = $rsl[secname] ;
}	


	$intra_ip = $arrserver_intraip[$getareaid]  ; 
	connserver(HOST) ;   
if ($action == "update" && $id > ""){
	$sql = "update general set prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',";
	if ($chk_unit) $sql .= "unit='$unit',";
	$sql .= " idcard='$idcard',birthday='$birthday' where id='$id';";

	//echo $sql;
	mysql_query($sql);
	if (mysql_errno()  ){
		$msg = "ไม่สามารถบันทึกข้อมูลได้  <br> ". mysql_error() .";  ";
	}else{
		$msg = "บันทึกข้อมูลเรียบร้อยแล้ว";
	}
	echo " <center> $msg </center> ";
#	echo "<script>alert('$msg');location.href='?';< /script>";
#	exit;

}else if ($action == "edit"){
	$result = mysql_query("select * from general where id='$id';");
	$rs = mysql_fetch_assoc($result);
?>
<FORM METHOD=GET ACTION="">
<INPUT TYPE="hidden" NAME="action" VALUE="update">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table border=0 bgcolor="#404040" cellspacing=1 cellpadding=5 align=center>
<tr height=30>
<td bgcolor="#808070"><B>ชื่อ-นามสกุล</B></td>
<td bgcolor="#FFFFCC">
<INPUT TYPE="text" NAME="prename_th" VALUE="<?=$rs[prename_th]?>" SIZE="10"> 
<INPUT TYPE="text" NAME="name_th" VALUE="<?=$rs[name_th]?>" SIZE="30"> 
<INPUT TYPE="text" NAME="surname_th" VALUE="<?=$rs[surname_th]?>" SIZE="30"> 
</td>
</tr>

<tr height=30>
<td bgcolor="#808070"><B>เลขหมายบัตรประชาชน</B></td>
<td bgcolor="#FFFFCC"><INPUT TYPE="text" NAME="idcard" size="60" value="<?=$rs[idcard]?>"></td>
</tr>

<tr height=30>
<td bgcolor="#808070"><B>ปี-เดือน-วัน เกิด</B></td>
<td bgcolor="#FFFFCC"><INPUT TYPE="text" NAME="birthday" size="60" value="<?=$rs[birthday]?>"></td>
</tr>

<tr height=30>
<td bgcolor="#808070"><B>หน่วยงาน</B></td>
<td bgcolor="#FFFFCC">
<select name="unit" disabled>
<?
	$xresult = mysql_query("select * from office_detail order by th_name");
	while ($xrs=mysql_fetch_assoc($xresult)){
		if ($rs[unit] == $xrs[id]) $sel="SELECTED"; else $sel="";
		echo "<option value='$xrs[id]' $sel > $xrs[th_name]";
	} // while	
?>
</select>

<INPUT TYPE="checkbox" NAME="chk_unit" value="1" ONCLICK="this.form.unit.disabled = ! this.checked;"> แก้ไขหน่วยงาน
<input name="getareaid" type="hidden" id="getareaid" value="<?=$getareaid?>"></td>
</tr>

<tr height=30>
<td colspan=2 align=right>
<INPUT TYPE="submit" VALUE="     บันทึก     "> 
<INPUT TYPE="reset"  VALUE="   ยกเลิก   " ONCLICK="history.back();">
</td>
</tr>

</table>

</FORM>


<?

	exit;
}else if ($action == "search"){

?>
<table width="98%" border=0 align=center cellpadding=5 cellspacing=1 bgcolor="#404040">
<tr height=30 bgcolor="#336666">
<th width="4%">ลำดับ</th>
<th width="18%">ชื่อ - นามสกุล</th>
<th width="14%">เลขหมายบัตรประชาชน</th>
<th width="10%">ปี-เดือน-วัน เกิด</th>
<th width="8%">PivateKey</th>
<th width="8%">Site ID </th>
<th width="13%">Server IP </th>
<th width="20%">สพท.</th>
<th width="5%">&nbsp;</th>
</tr>
<?
#	$arrserver_ip[$rs[areaid]] = $rs[IP] ; 
#	$arrserver_intraip[$rs[areaid]] = $rs[intra_ip] ; 
#	$arrserver_name[$rs[areaid]] = $rs[area_name] ; 
$n=0;


connserver(HOST) ;  
//if($session_key_siteid != ""){ $where_site = "  AND  view_general.siteid IN ($session_key_siteid)";}else{ $where_site = " ";}
/*$where_site = " AND view_general.siteid IN ('6601','4101','3405','7102','4001','4005','6002','6302','7103','6502','8602','6301','5101','7002','5701','6702','7203','4802','7302','3303','5001','5002','5003','5004','5005','5006')";*/

/*$sql_site = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
$where_eduarea
GROUP BY eduarea.secid";
if($_GET['debug']=="on"){
		echo $sql_site."<hr/>";
}
$result_site = mysql_db_query($dbnamemaster,$sql_site);
while($rs_site = mysql_fetch_assoc($result_site)){
$db_site = STR_PREFIX_DB.$rs_site[secid];*/
if($area_site != ""){
		$con_site = " AND view_general.siteid='$area_site'";
}else{
		$con_site = "";	
}

$sql = "SELECT view_general.CZ_ID, view_general.siteid, view_general.prename_th, view_general.name_th, view_general.surname_th, view_general.position_now,
view_general.schoolid, view_general.pivate_key, view_general.birthday, view_general.schoolname FROM view_general  WHERE (  view_general.name_th LIKE  '%$sname%' AND   view_general.surname_th LIKE  '%$slastname%'   AND  view_general.CZ_ID like '%$idcard%' )  $con_site "; 
//echo $sql;
$arr_sql[] = $sql;
		/*$sql = "SELECT general.id as CZ_ID, general.siteid,general.prename_th,general.name_th, general.surname_th,general.position_now,general.schoolid,general.pivate_key,general.birthday FROM general WHERE (general.name_th LIKE  '%$sname%' AND   general.surname_th LIKE  '%$slastname%'   AND  general.id like '%$idcard%' ) ";*/
	
		$result = @mysql_db_query($dbnamemaster,$sql );
		while ($rs = @mysql_fetch_assoc($result)){
		$sql_sel = "SELECT area_info.intra_ip, eduarea.secid, eduarea.area_id, eduarea.secname FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id
WHERE eduarea.secid =  '$rs[siteid]' ";
        $arr_sql[] = $sql_sel;
		$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
		$rs_sel  = mysql_fetch_assoc($result_sel);
		$rs_secname = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$rs_sel[secname]) ; 
		$interip = $rs_sel[intra_ip];
?>
<tr height=30 bgcolor="#efefef">
<td align=center><?=++$n?></td>
<td align=left><a href="?name_th=<?=$rs[name_th]?>&surname_th=<?=$rs[surname_th]?>&idcard=<?=$rs[CZ_ID]?>&action=login&xsiteid=<?=$rs[siteid]?>"><?=$rs[prename_th]?> <?=$rs[name_th]?> <?=$rs[surname_th]?></a></td>
<td align=center><?=$rs[CZ_ID]?></td>
<td align=center> 
<?
# 2501-02-20
$tmp = explode("-" , $rs[birthday] ) ; 
$rsbirthday = $tmp[2] . $tmp[1] .$tmp[0]  ; 
echo $rsbirthday ; 
?></td>
<td align=center><?=$rs[pivate_key]?></td>
<td align=center> <?=$rs[siteid]?></td>
<td align=center> <?=$interip?></td>
<td align=center> <?=$rs_secname?>
<?
if ($rs[office] != ""){ $stroffice = " (". $rs[office] . ")" ; }else{  $stroffice = "" ; } 
echo $stroffice ; 
?></td>

<td align=center>
<!--<A HREF="?action=edit&id=<?=$rs[id]?>&getareaid=<?=$serverid?>"></A>--><img src="../../images_sys/b_edit.png" alt="กำลังปรับโปรแกรมให้แก้ไขได้ครับ" border=0></td>
</tr>
<?
		}//while
//} ###### END $result_site = mysql_db_query($dbnamemaster,$sql_site);
?>
</table>
<?
} //if

$sql_sub = "SELECT count(tbl_assign_key.idcard) as num1 FROM tbl_assign_sub Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
WHERE tbl_assign_sub.staffid =  '$session_staffid' AND tbl_assign_key.approve <>  '2' AND tbl_assign_sub.nonactive='0'";

$sql_sub1 = "SELECT
count(t2.idcard) as num1
FROM
tbl_assign_edit_sub as t1
Inner Join tbl_assign_edit_key as t2 ON t1.ticketid = t2.ticketid
WHERE
t1.staffid =  '$session_staffid' AND t2.approve <>  '2' and t2.userkey_wait_approve <> '1'";
$result_sub1 = mysql_db_query($dbnameuse,$sql_sub1) ;
$rs_sub1 = mysql_fetch_assoc($result_sub1);
$arr_sql[] = $sql_sub;
//echo "$dbcall :: $sql_sub<br>";
$result_sub = mysql_db_query($dbnameuse,$sql_sub) ;
$rsnum = mysql_fetch_assoc($result_sub);
$temp_i = intval($rsnum[num1])+intval($rs_sub1[num1]);


if($_SESSION[session_sapphire]  != "1" and $_SESSION[session_status_extra] != "QC" and $_SESSION[session_status_extra] != "CALLCENTER" and $_SESSION[session_status_extra] != "site_area"){ 
	$xtype = "sub";
}

?><BR>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr  class="fillcolor">
<?
	if($xtype == ""){ $bg = "#EFEFEF";/* $font1 = "<font color='#FFFFFF'>";$font_end1 = "</font>";*/}else{  $bg = "#A3B2CC";}
	if($xtype == "sub"){ $bg1 = "#EFEFEF";/*$font2 = "<font color='#FFFFFF'>";$font_end2 = "</font>"; */}else{ $bg1 = "#A3B2CC"; }
	if($xtype == "sub1"){ $bg2 = "#EFEFEF";/*$font2 = "<font color='#FFFFFF'>";$font_end2 = "</font>"; */}else{ $bg2 = "#A3B2CC"; }
	if($_SESSION[session_sapphire]  == "1" or $_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "CALLCENTER" or $_SESSION[session_status_extra] == "site_area"){ // กรณีเป็นพนักงานบริษัทเท่านั้น
?>
    <td width="13%" align="center" bgcolor="<?=$bg?>"><strong><a href="qsearch2.php?xtype="><?=$font1?>การค้นหาปกติ<?=$font_end1?></a></strong></td>
	<? 
	}//end if($_SESSION[session_sapphire]  == "1"){
if($temp_i > 0){ // เปิดเมนูกรณีมีการ assign งานให้เท่านัน?>
    <td width="14%" align="center" bgcolor="<?=$bg1?>"><strong><a href="qsearch2.php?xtype=sub"><?=$font2?>ใบงานคีย์ข้อมูล<?=$font_end2?> </a></strong></td>
    <td width="12%" align="center" bgcolor="<?=$bg2?>"><strong><a href="qsearch2_edit.php?xtype=sub1">สำหรับใบงานแก้ไข</a></strong></td>
   
	<?  }// end  if($temp_i > 0){
			if(xGetNumFileQc()>0){
		?>
     <td width="16%" align="center" bgcolor="#A3B2CC"><strong><a href="report_request_kp7.php" target="_blank">ไฟล์แนบเอกสารตรวจคำผิด</a></strong></td>
     <?
			}//end if(GetNumFileQc()>0){
	 ?>
    <td width="45%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
  </tr>
</table>
<? if($xtype == ""){
		if($_SESSION[session_sapphire]  == "1" or $_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "CALLCENTER" or $_SESSION[session_status_extra] == "site_area"){
?>
<FORM METHOD=GET ACTION="">
<INPUT TYPE="hidden" NAME="action" VALUE="search">
<input type="hidden" name="xtype" value="<?=$xtype?>"> 
<input type="hidden" name="area_site" value="<?=$_SESSION[session_site]?>">
<table border=0 bgcolor="#404040" cellspacing=1 cellpadding=5 align=center>
<tr height=30>
  <td bgcolor="#808070" class="link_back"><B> ชื่อ</B></td>
  <td bgcolor="#FFFFCC"><input type="text" name="sname" size="30" value="<?=$sname?>"></td>
</tr>

<tr height=30>
<td bgcolor="#808070" class="link_back"><B>นามสกุล</B></td>
<td bgcolor="#FFFFCC"><input name="slastname" type="text" value="<?=$slastname?>" size="30"></td>
</tr>
<tr height=30>
  <td bgcolor="#808070" class="link_back">รหัสประชาชน</td>
  <td bgcolor="#FFFFCC"> <input name="idcard" type="text" value="<?=$idcard?>" size="30"> </td>
</tr>
<tr height=30>
<td colspan=2 align=right><INPUT TYPE="submit" VALUE="     ค้นหา     "></td>
</tr>
</table>
<CENTER>
</CENTER>

</FORM>
<? 
	}//end if($_SESSION[session_sapphire]  != "2"){
} //end if($xtype == ""){
if($xtype == "sub"){
?>
<table width="98%" border=0 align=center cellpadding=5 cellspacing=1 bgcolor="#404040">
  <tr height=30 bgcolor="#336666">
    <th colspan="10" bgcolor="#EFEFEF" class="redlink">เพื่อความรวดเร็วในการบันทึกข้อมูลท่านสามารถค้นหาบุคลากรที่ท่านจะทำการบันทึกข้อมูลได้</th>
  </tr>
  <tr height=30 bgcolor="#336666" align="center">
    <th colspan="10" bgcolor="#EFEFEF" class="redlink"><form name="form1" method="post" action="">
      <table width="30%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#404040"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="31%" align="left" bgcolor="#808070"><strong>ชื่อ</strong></td>
              <td width="69%" align="left" bgcolor="#EFEFEF"><label>
                <input name="sname" type="text" id="sname" size="30" value="<?=$sname?>">
              </label></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#808070"><strong>นามสกุล</strong></td>
              <td align="left" bgcolor="#EFEFEF"><label>
                <input name="slastname" type="text" id="slastname" size="30" value="<?=$slastname?>">
              </label></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#808070"><strong>รหัสประชาชน</strong></td>
              <td align="left" bgcolor="#EFEFEF"><label>
                <input name="idcard" type="text" id="idcard" size="30" value="<?=$idcard?>">
              </label></td>
            </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#404040"><label>
                <input type="submit" name="button" id="button" value="ค้นหา">
                <input type="hidden" name="xtype" value="sub">
                <input type="hidden" name="xsearch" value="yes">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </form></th>
  </tr>
  <?
  	$alert_msg = CheckKeyLastApprove($_SESSION[session_staffid]);
	if($alert_msg != ""){
		
		$arrid_block = AssignIdcardNoKey($_SESSION[session_staffid]); // เลขบัตรที่ยังไม่สามารถคีย์ได้จนกว่าจะทำการคีย์ให้เสร็จและรับรองข้อมูล
		if(count($arrid_block) > 0){
				$flag_block = 1;
		}else{
				$flag_block = 0;
		}
		//echo $flag_block."<br>";
  ?>
  <tr height=30 bgcolor="#FFFFFF">
    <th colspan="10" bgcolor="#FFFFFF"><font color="#FF0000"><?=$alert_msg?></font></th>
  </tr>
  <?
	}//end if($alert_msg != ""){
  ?>
  <tr height=30 bgcolor="#336666">
    <th width="3%">ลำดับ</th>
    <th width="14%">รหัสใบงาน</th>
    <th width="18%">ชื่อ - นามสกุล</th>
    <th width="11%">เลขหมายบัตรประชาชน</th>
    <th width="9%">ปี-เดือน-วัน เกิด</th>
    <th width="6%">Site ID </th>
    <th width="10%">Server IP </th>
    <th width="16%">สพท.</th>
    <th width="6%">สถานะงาน</th>
    <th width="7%">ตรวจสอบ</th>
  </tr>
  <?
  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 20 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


$n=0;
connserver(HOST) ;
if($xsearch == "yes"){
		if($sname != ""){
				$xconv .= " AND t1.name_th LIKE '%$sname%' ";
		}
		if($slastname != ""){
				$xconv .= " AND t1.surname_th LIKE '%$slastname%'";
		}
		if($idcard != ""){
				$xconv .= " AND t1.CZ_ID LIKE '%$idcard%' ";
		}
	
}else{
		$xconv = " ";
}//end if($xsearch == "yes"){
	
if($_SESSION[session_site] != ""){
		$consite = "and t3.site_area='".$_SESSION[session_site]."'";
}else{
		$consite = "";	
}
//$sql = "SELECT view_general.CZ_ID, view_general.siteid, view_general.prename_th, view_general.name_th, view_general.surname_th, view_general.position_now,
//view_general.schoolid, view_general.pivate_key, view_general.birthday, view_general.schoolname FROM view_general  $xconv"; 

$sql = "SELECT
t3.ticketid,
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid,
t1.pivate_key,
t1.birthday,
t1.schoolname
FROM
 ".DB_MASTER.".view_general as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.CZ_ID = t2.idcard AND t1.siteid = t2.siteid
Inner Join ".DB_USERENTRY.".tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
WHERE
t3.staffid =  '".$_SESSION[session_staffid]."'  AND t3.approve <>  '2' AND t3.nonactive='0'  $consite $xconv
GROUP BY t1.CZ_ID
ORDER BY t2.userkey_wait_approve ASC,t3.ticketid DESC ";
		
//echo $sql;

		$xresult = mysql_db_query($dbnamemaster,$sql);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql .= " ";
	}else{
			$sql .= " LIMIT $i, $e";
	}

//echo $sql;
		//$result_main = mysql_db_query($dbnamemaster,$sql);
		//$num_row = @mysql_num_rows($result_main);
		$search_sql = $sql ; 
        
		$arr_sql[] = $sql;
		
		$result = mysql_db_query($dbnamemaster,$sql );
		while ($rs = mysql_fetch_assoc($result)){
			$i++;
		$sql_sel = "SELECT area_info.intra_ip, eduarea.secid, eduarea.area_id, eduarea.secname FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id
WHERE eduarea.secid =  '$rs[siteid]' ";
        
		$arr_sql[] = $sql_sel;

		$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
		$rs_sel  = mysql_fetch_assoc($result_sel);
		$rs_secname = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$rs_sel[secname]) ; 
		$interip = $rs_sel[intra_ip];
		$fullname = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
?>
  <tr height=30 bgcolor="#efefef">
    <td align=center><?=$i?></td>
    <td align=left><?=$rs[ticketid]?></td>
    <td align=left><?
	 if($flag_block == "1"){  
	 	 if(array_key_exists($rs[CZ_ID], $arrid_block)){  
		 	echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";
		}else{ 
			echo "<a href='?name_th=$rs[name_th]&surname_th=$rs[surname_th]&idcard=$rs[CZ_ID]&action=login&xsiteid=$rs[siteid]&userkey=1'>$rs[prename_th]$rs[name_th] $rs[surname_th]</a>";
		}// end if(array_key_exists($rs[CZ_ID], $arrid_block)){
	}else{ 
		echo "<a href='?name_th=$rs[name_th]&surname_th=$rs[surname_th]&idcard=$rs[CZ_ID]&action=login&xsiteid=$rs[siteid]&userkey=1'>$rs[prename_th]$rs[name_th] $rs[surname_th]</a>";
	}// end if($flag_block == "1"){
	?></td>
    <td align=center><?=$rs[CZ_ID]?></td>
    <td align=center><?
# 2501-02-20
$tmp = explode("-" , $rs[birthday] ) ; 
$rsbirthday = $tmp[2] . $tmp[1] .$tmp[0]  ; 
echo $rsbirthday ; 
?></td>
    <td align=center><?=$rs[siteid]?></td>
    <td align=center><?=$interip?></td>
    <td align=left><?=$rs_secname?>
        <?
if ($rs[office] != ""){ $stroffice = " (". $rs[office] . ")" ; }else{  $stroffice = "" ; } 
echo $stroffice ; 
?></td>
    <td align=center><? if(check_status_job($rs[CZ_ID]) == "0"){ echo "ปกติ";}else if(check_status_job($rs[CZ_ID]) == "1"){ echo "<font color='red'>แก้งาน</font>";}else{ echo "ผ่าน"; }?></td>
    <td align=center><?
	
/*	$sql_check_vitaya = "SELECT * FROM log_check_vitaya WHERE idcard = '".$rs[CZ_ID]."' ";
	$query_check_vitaya = mysql_db_query('edubkk_master',$sql_check_vitaya)or die(mysql_error());
	$num_check_vitaya = mysql_num_rows($query_check_vitaya);
	if($num_check_vitaya == 0){
	 $txt_link = "&first_time=1";
	}else{
	 $txt_link = "";
	}*/
	
    $sql_key = "SELECT COUNT(idcard) AS num_key  FROM tbl_assign_key WHERE idcard='$rs[CZ_ID]' AND nonactive='0' AND userkey_wait_approve='1' GROUP BY idcard";
	$arr_sql[] = $sql_key;
	$result_key = mysql_db_query(DB_USERENTRY,$sql_key);
	$rs_key = mysql_fetch_assoc($result_key);
	if($rs_key[num_key] > 0){ echo "<font color='#FF0000'>*</font>";}else{ echo "";}
	
	?><a href="../hr3/tool_competency/diagnosticv1/userkey_checkdata.php?open_check_vitaya=1<?=$txt_link?>&idcard=<?=$rs[CZ_ID]?>&xsiteid=<?=$rs[siteid]?>&fullname=<?=$fullname?>' target='_blank'" target="_blank"><img src="images/package_utilities.png" alt="ตรวจสอบผลการคีย์ข้อมูลเบื้องต้นจากพนักงานคีย์ข้อมูล" width="20" height="20" border="0"></a></td>
  </tr>
 <?
		}//while
//} ###### END while (list ($serverid, $servername) = each ($arrserver_name)) { 		
?>

  <tr height=30 bgcolor="#efefef">
    <td colspan="10" align=left><? 
	//echo $search_sql;
	$sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?>	</td>
  </tr>
  <tr height=30 bgcolor="#efefef">
    <td colspan="10" align=left>หมายเหตุ : เครื่องหมาย <span class="redlink">*</span> หมายถึงรายการที่ผ่านการตรวจสอบเบื้องต้นจากคนคีย์เรียบร้อยแล้ว</td>
  </tr>
</table>

<? } 

if($_GET['debug'] == '1'){
  echo "<pre>";
  print_r($arr_sql);
  echo "</pre>";
}

?>
<BR>
</BODY>
</HTML>
<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>