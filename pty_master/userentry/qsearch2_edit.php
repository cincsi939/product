<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "search_edit"; 
$process_id			= "search_edit";
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
	## Modified Detail :		�к� login userentry
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
$time_start = getmicrotime();
$pathfile = "../../../edubkk_kp7file/";
$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
//$xtype = "sub";
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

$arricon = array("1"=>"<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"���Թ��������������\">","2"=>"<img src=\"../../images_sys/doc_green.png\" width=\"20\" height=\"20\"  border=\"0\" title=\"��Ǩ�ͺ������辺�����żԴ\">","3"=>"<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\"  border=\"0\" title=\"��Ǩ�ͺ�����繢����Ť���ͧ���\">","4"=>"<img src=\"../../images_sys/icon_comment.png\" width=\"20\" height=\"20\"  border=\"0\" title=\"��ͧ��ä�͸Ժ���������\">");

function GetkeyApproveType(){
		global $dbnamemaster,$arricon;
		$sql = "SELECT * FROM req_type_keyapprove ORDER BY runid ASC";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[runid]] = $arricon[$rs[runid]];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}//end function GetkeyApproveType(){

function GetSecname(){
	global $dbnamemaster;
	$sql = "SELECT secid,secname,intra_ip FROM eduarea Inner Join area_info ON eduarea.area_id = area_info.area_id  WHERE secid NOT LIKE '99%'";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[secid]]['site'] = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname]);
		$arr[$rs[secid]]['ip'] = $rs[intra_ip];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetSecname(){


$sql_staff = "SELECT * FROM keystaff  WHERE staffid='$session_staffid'";
//echo "$db_name";
$result_staff = mysql_db_query(DB_USERENTRY,$sql_staff);
$rs_staff = mysql_fetch_assoc($result_staff);

if($rs_staff[flag_change_password] == "1"){
	echo "<br><br><center><font color='red'><h3>��ҹ���ա����蹢����ʼ�ҹ��������к���ӡ���������ʼ�ҹ����ҹ<br>�ѧ��鹷�ҹ��ͧ����¹���ʼ�ҹ�ͧ��ҹ�ա�����������䢢�������ǹ���<br>���Ƿӡ������¹���ʼ�ҹ�ա���駨֧������ö���仺ѹ�֡�����źؤ�ҡ���</h3></font></center>";	
	die;
}

//$user_ip = $_SERVER["REMOTE_ADDR"] ;
//$user_ipx = $_SERVER['SERVER_ADDR'];
$user_ip = getenv("SERVER_NAME"); 
$sub_ipaddress = substr($user_ip,0,8);//  ��Ǩ�ͺ ip 


function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xmode,$xtype,$sname,$slastname,$idcard,$action,$status_edit;

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
			$table .= "<a href=\"?page=1&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&status_edit=$status_edit&displaytype=people".$kwd."\"><u><font color=\"black\">˹���á</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&status_edit=$status_edit&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&status_edit=$status_edit&displaytype=people". $kwd."\"><u><font color=\"black\">˹���ش����</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xmode=$xmode&xtype=$xtype&sname=$sname&slastname=$slastname&idcard=$idcard&action=$action&status_edit=$status_edit&displaytype=people". $kwd."\"><u><font color=\"black\">�ʴ�������</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">���͡�ٻẺ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">�ӹǹ������ <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;˹��&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}

#### function ��Ǩ�ͺ��� upload �ٻ
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
	$sql = "SELECT * FROM tbl_assign_edit_key WHERE  idcard='$idcard' AND nonactive='0'";
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
		

############  �óբ����Ţͧ�������Ѻ ticket ����ա��
	function check_assign_key($idcard,$staffid){

	//global $db_name;
			$sql_assign_key = "SELECT tbl_assign_edit_sub.staffid FROM tbl_assign_edit_key
Inner Join tbl_assign_edit_sub ON tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
Inner Join monitor_keyin ON tbl_assign_edit_sub.staffid = monitor_keyin.staffid
WHERE
tbl_assign_edit_key.idcard =  '$idcard' AND tbl_assign_edit_key.nonactive='0'";
		$result_assign_key = @mysql_db_query(DB_USERENTRY,$sql_assign_key);
		$rs_k = @mysql_fetch_assoc($result_assign_key);
			if($rs_k[staffid] != ""){
					if($rs_k[staffid] != $staffid){ // �ʴ�����繤��Ф�
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
####  ��Ǩ�ͺ��Ҥ�������仺ѹ�֡�������ա�� assign �ҹ���������������� log �����ʹ��Է�ԡ�úѹ�֡������
	function CheckAssign($get_staffid,$get_idcard){
		$sql_checkAssign = "SELECT  count(tbl_assign_edit_key.idcard) as num_assign  FROM tbl_assign_edit_sub Inner Join tbl_assign_edit_key ON tbl_assign_edit_sub.ticketid = tbl_assign_edit_key.ticketid WHERE tbl_assign_edit_sub.nonactive =  '0' AND tbl_assign_edit_key.idcard =  '$get_idcard' AND
tbl_assign_edit_sub.staffid =  '$get_staffid' GROUP BY tbl_assign_edit_sub.staffid ";
		$result_checkAssign = mysql_db_query(DB_USERENTRY,$sql_checkAssign);
		$rs_chA = mysql_fetch_assoc($result_checkAssign);
		return $rs_chA[num_assign];
		
	}//end function CheckAssign(){
###  end ��Ǩ�ͺ��Ҥ�������仺ѹ�֡�������ա�� assign �ҹ���������������� log �����ʹ��Է�ԡ�úѹ�֡������
?>
<html>
<TITLE>��Ǩ�ͺ������ Competency</TITLE>
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
	if (confirm("��úѹ�֡�����ŵ����ǧ���ҹ���դ��ѹ�֡������к�����! �س��ͧ��úѹ�֡�����ū�����������?")) { 
		window.location="qsearch2_edit.php?action=accept";
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

<H1 align=center>�к��ѹ�֡������ �.�.7 ����Ҫ��ä����кؤ�ҡ÷ҧ����֡��(�ҹ���)</H1>
<?

		$dd = date("d");
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$hh = date("H:i:s");
		$gendate = "$yy-$mm-$dd"." ".$hh;

 


if($action == "accept"){
	$namekey= "$_SESSION[name] "." $_SESSION[surname]";
	$_SESSION[userkeyin] = true;
	
 ##  ʶҹ� ��úѹ�֡�����Ţͧ ��ѡ�ҹ���������
if($_SESSION['session_sapphire'] == 1){
	$status_user = 1; // ��ѡ�ҹ sapphire
}else if($_SESSION['session_sapphire'] != 1 and $_SESSION['session_status_extra'] == "QC"){
	$status_user = 2; // �١��ҧ���Ǥ��Ƿ���˹���� qc
}else{
	$status_user = 0;// ��ѡ�ҹ��ҧ
}

#### ����������ش��� sum ���仺ѹ�֡������
$sql_a1 = "SELECT tbl_assign_edit_sub.staffid FROM tbl_assign_edit_key Inner Join tbl_assign_edit_sub ON tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
WHERE tbl_assign_edit_key.idcard =  '$_SESSION[id]' AND  tbl_assign_edit_key.nonactive =  '0'";
$resulta1 = mysql_db_query($dbnameuse,$sql_a1);
$rsa1 = mysql_fetch_assoc($resulta1);
if($rsa1[staffid] == $_SESSION[session_staffid]){
		$update_time_key = " , timeupdate_user = NOW()";
}else{
		$update_time_key = "";	
}//end 
	
	//if($session_sapphire != "1" and ($_SESSION[session_status_extra] != "QC")){ // �ѹ�֡�ó�����边ѡ�ҹ ����ѷ sapphire ��о�ѡ�ҹ QC

		$sql_check_k = "SELECT COUNT(monitor_keyin.idcard) as num1 FROM tbl_assign_edit_key Inner Join monitor_keyin ON tbl_assign_edit_key.idcard = monitor_keyin.idcard WHERE tbl_assign_edit_key.nonactive =  '0' AND monitor_keyin.staffid =  '$_SESSION[session_staffid]' AND
tbl_assign_edit_key.idcard =  '$_SESSION[id]' GROUP BY monitor_keyin.staffid";
		$result_check_k = mysql_db_query($dbnameuse,$sql_check_k);
		$rs_ck = mysql_fetch_assoc($result_check_k);
		$chnum = $rs_ck[num1];
		
		if(CheckAssign($_SESSION[session_staffid],$_SESSION[id]) > 0){  ## ��Ǩ�ͺ����� log � monitor keyin ��ͧ�Ҩҡ��кǹ��� assgin �ҹ��ҹ��
			
			if($chnum > 0){ // �ó��ա�úѹ�֡��¡�ë�������� update  timeupdate
					$str = " UPDATE   monitor_keyin SET siteid = '$_SESSION[secid]' ,keyin_name = '$namekey' , timestamp_key = NOW(), status_user='$status_user' $update_time_key  WHERE  staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]'  ";
			}else{
					##  �ó��繾�ѡ�ҹ���������ؤ�ҡä�����ҡ�ç��ûշ��������� update ���ͧ�ҡ primary key �� idcard ��� staffid 
					$sqlc1 = "SELECT COUNT(staffid) AS num2 FROM  monitor_keyin WHERE staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]' GROUP BY staffid";
					$resultc1 = mysql_db_query($dbnameuse,$sqlc1);
					$rsc1 = mysql_fetch_assoc($resultc1);
					if($rsc1[num2] > 0){
						$str = " UPDATE   monitor_keyin SET siteid = '$_SESSION[secid]' ,keyin_name = '$namekey' ,timeupdate,=NOW(), timestamp_key = NOW(), status_user='$status_user' $update_time_key  WHERE  staffid='$_SESSION[session_staffid]' AND idcard='$_SESSION[id]' ";	
					}else{
						$str = " INSERT INTO  monitor_keyin(staffid,idcard,siteid,keyin_name,timeupdate,timestamp_key,status_user,timeupdate_user) VALUES ('$_SESSION[session_staffid]','$_SESSION[id]','$_SESSION[secid]','$namekey',NOW(),NOW(),'$status_user',NOW()) ";
					}//end if($rsc1[num2] > 0){
			}//end if($chnum > 0){
	//echo $str;die;
	mysql_db_query($dbnameuse,$str);
	
		}//end if(CheckAssign($_SESSION[secid],$_SESSION[id]) > 0){ 
	 ##  end ��Ǩ�ͺ����� log � monitor keyin ��ͧ�Ҩҡ��кǹ��� assgin �ҹ��ҹ��
	//}// end 	if($session_sapphire != "1"){
		
		$redirec_ip = APPHOST_TEST;
		$log_ip_login = $_SESSION[id];
		$database1 = STR_PREFIX_DB.$_SESSION[secid];
		## ��Ǩ�ͺ�Է�ԡ����Ҷ֧�����Ż�ͧ�ѹ sub ��������Ţ�ҧ㹺���ѷ
		if($sub_ipaddress == "192.168." and $session_sapphire == "2"){
		$sql_log = "INSERT INTO log_check_staffkey SET staffid='$_SESSION[session_staffid]',idcard='$_SESSION[id]',siteid='$_SESSION[secid]'";
		mysql_db_query($dbnameuse,$sql_log);
		echo "<script> alert('��ҹ������Է�Ժѹ�֡���������ͧ�ҡ��ҹ��١��˹���ǧ���ҡ�úѹ�֡�������������');top.location.href='".APPURL.APPNAME."application/userentry/login_main.php';</script>";
		exit;
		}else{
		add_log("�������к�","$log_ip_login","login");
		echo "<script>top.location.href='".APPURL.APPNAME."application/hr3/hr_frame/frame.php';</script>";
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
				
				####  update ʶҹС�ä�������������ѹ�֡�����������
				$sql_key = "UPDATE tbl_assign_edit_key SET status_keydata='1' WHERE idcard='$idcard' and siteid='$xsiteid'";
				mysql_db_query($dbnameuse,$sql_key);
				
				$sqla = " SELECT  *  FROM  keystaff  WHERE  staffid = '$_SESSION[session_staffid]'  ";
				 //echo "$sqla";
				$resulta = mysql_db_query($dbnameuse,$sqla);
				$rsa = mysql_fetch_assoc($resulta);
				
				$namestaff = " $rsa[prename]$rsa[staffname]  $rsa[staffsurname]  ";

				$temp_name_th = "$name_th $surname_th";

	
		$redirec_ip = APPHOST_TEST;
	## ��Ǩ�ͺ�Է�ԡ����Ҷ֧�����Ż�ͧ�ѹ sub ��������Ţ�ҧ㹺���ѷ

		echo "<script>top.location.href='".APPURL.APPNAME."application/hr3/hr_frame/frame.php';</script>";
		exit;
	



?>
<table width="661" border=0 align=center cellpadding=5 cellspacing=1 bgcolor="#404040">
  <tr height=30>
    <td colspan="2" bgcolor="#808070" class="Label_big_black">��ҹ���ѧ��������ѹ�֡�����Ţͧ</td>
  </tr>
  <tr>
    <td width="133" height="28" bgcolor="#808070"><B>����-���ʡ��</B></td>
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
			echo "<img src=\"../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border=\"0\" title=\"������Ҿ �.�.7 �鹩�Ѻ\">"; 		 
		 }//end   if(is_file($img_filex)){
		  
		  ?></td>
        </tr>
    </table></td>
  </tr>
  <tr height=30>
    <td height="28" bgcolor="#808070"><B>�Ţ���ºѵû�ЪҪ�</B></td>
    <td bgcolor="#FFFFCC"><h2><?=$idcard?></h2></td>
  </tr>
  <tr height=30>
    <td height="30" bgcolor="#808070"><B>���ѹ�֡</B></td>
    <td bgcolor="#FFFFCC">&nbsp;<?=$namestaff?></td>
  </tr>
  <tr height=30>
    <td colspan=2 align=center bgcolor="#FFFFCC" class="Label_big_black"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFCC"><b>Log ��úѹ�֡������</b></td>
            </tr>
          <tr>
            <td width="51%" align="center" bgcolor="#FFFFCC"><b>��ª��ͼ��ѹ�֡</b></td>
            <td width="49%" align="center" bgcolor="#FFFFCC"><b>���ҷ��ѹ�֡</b></td>
          </tr>
		  <?
$date_chd = "2009-12-01"; // ����������鹺ѹ�֡������
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
$result_ch = mysql_db_query($dbnameuse,$sql_check);
$n=0;
$check_conf = 0;
while($rs_ch = mysql_fetch_assoc($result_ch)){
if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $n++;
$arr_d = explode(" ",$rs_ch[timeupdate]);
$arr_d1 = explode("-",$arr_d[0]);
if($arr_d[0] >= $date_chd ){
$check_conf ++;
	$show_date = "<font color='red' size='35'> �ѹ��� ".intval($arr_d1[2])." ".$mname[intval($arr_d1[1])]." ".($arr_d1[0]+543)."</font>";
}else{
	$show_date = "<font size='35'>�ѹ��� ".intval($arr_d1[2])." ".$mname[intval($arr_d1[1])]." ".($arr_d1[0]+543)."</font> ";
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
    <td colspan=2 align=center bgcolor="#FFFFCC" class="Label_big_black">�к����ѧ�кѹ�֡��÷ӧҹ�ͧ��ҹ ����͡���ŧ <br>
    <? if($check_conf > 0){ echo "<font color='red' size='35'><img src=\"../../images_sys/alert.gif\" width=\"31\" height=\"32\" border=\"0\" alt=\"ʶҹ�����͹��úѹ�֡�����ū��\">�س���ѧ�ѹ�֡�����ū��</font>";}else{ echo "";}
		/*if(($session_sapphire == "1" ) or ($_SESSION[session_status_extra] == "QC")){  echo "<font color='red' size='20'> 㹡ó������˹�ҷ��ͧ���ɷ SAPPHIRE ���� ���˹�ҷ�� QC �������仵�Ǩ�ͺ������ �.�.7 <br>
�к�������� log �����Һѹ�֡������</font>";}*/
	?>
    <br>
    <br>
    <font color="#FF0000">��سҵ�Ǩ�ͺ�����źؤ�ҡ÷���ҹ�зӡ�úѹ�֡���������ա�͹�ӡ�úѹ�֡������</font></td>
  </tr>
  <tr height=30>
    <td colspan=2 align=center><? if($check_conf > 0){?> <INPUT name="Button" TYPE="button" VALUE="     ��ŧ     " onClick="return con_accp();"><? } else{?><INPUT name="Button" TYPE="button" VALUE="     ��ŧ     " onClick="location.href='?action=accept';"><? } ?>
    <INPUT name="reset" TYPE="reset" ONCLICK="history.back();"  VALUE="   ¡��ԡ   ">
	</td>
  </tr>
</table>
<? exit; } ?>
<?			
connserver(HOST) ;  
# $dbnamemaster=DB_MASTER; 

$sname = trim($sname); 
$slastname = trim($slastname) ; 



########################################### �ӹǹ Server ��к�
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



connserver(HOST) ;   
if ($action == "update" && $id > ""){
	$sql = "update general set prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',";
	if ($chk_unit) $sql .= "unit='$unit',";
	$sql .= " idcard='$idcard',birthday='$birthday' where id='$id';";

	//echo $sql;
	mysql_query($sql);
	if (mysql_errno()  ){
		$msg = "�������ö�ѹ�֡��������  <br> ". mysql_error() .";  ";
	}else{
		$msg = "�ѹ�֡���������º��������";
	}
	echo " <center> $msg </center> ";
#	echo "<script>alert('$msg');location.href='?';< /script>";
#	exit;

}
?>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr  class="fillcolor">
<?
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


	if($xtype == ""){ $bg = "#EFEFEF";/* $font1 = "<font color='#FFFFFF'>";$font_end1 = "</font>";*/}else{  $bg = "#A3B2CC";}
	if($xtype == "sub"){ $bg1 = "#EFEFEF";/*$font2 = "<font color='#FFFFFF'>";$font_end2 = "</font>"; */}else{ $bg1 = "#A3B2CC"; }
	if($xtype == "sub1"){ $bg2 = "#EFEFEF";/*$font2 = "<font color='#FFFFFF'>";$font_end2 = "</font>"; */}else{ $bg2 = "#A3B2CC"; }
	if($_SESSION[session_sapphire]  == "1" or $_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "CALLCENTER" or $_SESSION[session_status_extra] == "site_area"){ // �ó��繾�ѡ�ҹ����ѷ��ҹ��
?>
    <td width="13%" align="center" bgcolor="<?=$bg?>"><strong><a href="qsearch2.php?xtype="><?=$font1?>��ä��һ���<?=$font_end1?></a></strong></td>
	<? 
	}//end if($_SESSION[session_sapphire]  == "1"){
	if($temp_i > 0){ // �Դ���١ó��ա�� assign �ҹ�����ҹѹ
?>
    <td width="14%" align="center" bgcolor="<?=$bg1?>"><strong><a href="qsearch2.php?xtype=sub"><?=$font2?>㺧ҹ���������<?=$font_end2?> </a></strong></td>
    <td width="12%" align="center" bgcolor="<?=$bg2?>"><strong><a href="qsearch2_edit.php?xtype=sub1">����Ѻ㺧ҹ���</a></strong></td>
   
  <?
	}//end if($temp_i > 0){
	if(xGetNumFileQc()>0){
  ?>
       <td width="16%" align="center" bgcolor="#A3B2CC"><strong><a href="report_request_kp7.php" target="_blank">���Ṻ�͡��õ�Ǩ�ӼԴ</a></strong></td>
      <?
	}//end 	if(GetNumFileQc()>0){
	  ?>
    <td width="45%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
  </tr>
</table>

<table width="98%" border=0 align=center cellpadding=5 cellspacing=1 bgcolor="#404040">
  <tr height=30 bgcolor="#336666">
    <th colspan="8" bgcolor="#EFEFEF" class="redlink">���ͤ����Ǵ����㹡�úѹ�֡�����ŷ�ҹ����ö���Һؤ�ҡ÷���ҹ�зӡ�úѹ�֡��������</th>
  </tr>
  <tr height=30 bgcolor="#336666" align="center">
    <th colspan="8" bgcolor="#EFEFEF" class="redlink"><form name="form1" method="post" action="">
      <table width="30%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#404040"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="31%" align="left" bgcolor="#808070"><strong>����</strong></td>
              <td width="69%" align="left" bgcolor="#EFEFEF"><label>
                <input name="sname" type="text" id="sname" size="30" value="<?=$sname?>">
              </label></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#808070"><strong>���ʡ��</strong></td>
              <td align="left" bgcolor="#EFEFEF"><label>
                <input name="slastname" type="text" id="slastname" size="30" value="<?=$slastname?>">
              </label></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#808070"><strong>���ʻ�ЪҪ�</strong></td>
              <td align="left" bgcolor="#EFEFEF"><label>
                <input name="idcard" type="text" id="idcard" size="30" value="<?=$idcard?>">
              </label></td>
            </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#404040"><label>
                <input type="submit" name="button" id="button" value="����">
                <input type="hidden" name="xtype" value="sub">
                <input type="hidden" name="xsearch" value="yes">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </form></th>
  </tr>
  <tr height=30 bgcolor="#336666">
    <th colspan="8" align="left" bgcolor="#A3B2CC"><a href="qsearch2_edit.php?xtype=sub1&status_edit=0">�ʹ��Թ���</a> || <a href="qsearch2_edit.php?xtype=sub1&status_edit=1">�����������</a> || <a href="qsearch2_edit.php?xtype=sub1&status_edit=2">��Ǩ�ͺ������辺�����żԴ</a> || <a href="qsearch2_edit.php?xtype=sub1&status_edit=3">��Ǩ�ͺ�����繢����Ť���ͧ���</a> || <a href="qsearch2_edit.php?xtype=sub1&status_edit=4">��ͧ��ä�͸Ժ���������</a></th>
  </tr>
  <?
 	 if($status_edit == ""){
		$status_edit = 0;	
		$subtitle = "��¡���ʹ��Թ������";
  	}else if($status_edit == "1"){
		 $subtitle = "��¡�������������"; 
	}else if($status_edit == "2"){
		$subtitle = "��§ҹ��Ǩ�ͺ������辺�����żԴ";
	}else if($status_edit == "3"){
		$subtitle = "��¡�õ�Ǩ�ͺ�����繢����Ť���ͧ���";	
	}else if($status_edit == "4"){
		$subtitle = "��¡�õ�ͧ��ä�͸Ժ���������";	
	}else{
		$subtitle = "��¡���ʹ��Թ������";
	}

  ?>
  <tr height=30 bgcolor="#336666">
    <th colspan="8" align="center" bgcolor="#A3B2CC"><h3><?=$subtitle?></h3></th>
  </tr>
  <tr height=30 bgcolor="#336666">
    <th width="3%" bgcolor="#A3B2CC">�ӴѺ</th>
    <th width="13%" bgcolor="#A3B2CC">���� - ���ʡ��</th>
    <th width="13%" bgcolor="#A3B2CC">�Ţ���ºѵû�ЪҪ�</th>
    <th width="12%" bgcolor="#A3B2CC">��-��͹-�ѹ �Դ</th>
    <th width="13%" bgcolor="#A3B2CC">ʾ�.</th>
    <th width="30%" bgcolor="#A3B2CC">��¡�ä���ͧ����ͧ���</th>
    <th width="7%" bgcolor="#A3B2CC">ʶҹЧҹ</th>
    <th width="9%" bgcolor="#A3B2CC">&nbsp;</th>
  </tr>
  <?
  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 10 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


$n=0;
connserver(HOST) ;
if($xsearch == "yes"){
		if($sname != ""){
				$xconv .= " AND t3.name_th LIKE '%$sname%' ";
		}
		if($slastname != ""){
				$xconv .= " AND t3.surname_th LIKE '%$slastname%'";
		}
		if($idcard != ""){
				$xconv .= " AND t3.CZ_ID LIKE '%$idcard%' ";
		}
}



$sql = "SELECT t1.staffid, t3.CZ_ID, t3.siteid, t3.prename_th, t3.name_th, t3.surname_th, t3.position_now, t3.birthday, t2.status_keydata, t2.approve,t3.schoolname,t3.pivate_key,t3.schoolid,t2.userkey_wait_approve,t1.ticketid FROM ".DB_USERENTRY.".tbl_assign_edit_sub as t1 Inner Join ".DB_USERENTRY.".tbl_assign_edit_key as t2 ON t1.ticketid = t2.ticketid Inner Join  ".DB_MASTER.".view_general as t3 ON t2.idcard = t3.CZ_ID
WHERE t1.staffid='".$_SESSION['session_staffid']."'  and t2.approve <> '2' and t2.userkey_wait_approve='$status_edit' $xconv  GROUP BY t2.idcard ORDER BY t1.timeupdate ASC,t3.name_th ASC, t3.surname_th ASC";
		
//echo $sql;
$arr_appk = GetkeyApproveType();
		$xresult = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<hr>LINE::".__LINE__);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
		if($all > 0){
			$arrsec =GetSecname();
		}
		
	if($page <= $allpage){
			$sql .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql .= " ";
	}else{
			$sql .= " LIMIT $i, $e";
	}
		$arr_sql[] = $sql;
//echo $sql;
		$result_main = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<hr>LINE::".__LINE__);
		$num_row = @mysql_num_rows($result_main);
		$search_sql = $sql ; 
		while ($rs = mysql_fetch_assoc($result_main)){
			$i++;
		$interip = $arrsec[$rs[siteid]]['ip'];
		$fullname = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
		$path_file = $pathfile."$rs[siteid]/".$rs[CZ_ID].".pdf";
		if(is_file($path_file)){
			$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'></a>";
		}else{
			$img_pdf = "";
		}
		
		$pdf_sys = "<a href=\"http://".APPHOST.APPNAME."application/hr3/hr_report/kp7.php?id=".$rs[CZ_ID]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='�.�.7 ���ҧ���к� '  ></a>";
		
		
		
?>
  <tr height=30 bgcolor="#efefef">
    <td align="center" valign="top"><?=$i?></td>
    <td align="left" valign="top"><a href="?name_th=<?=$rs[name_th]?>&surname_th=<?=$rs[surname_th]?>&idcard=<?=$rs[CZ_ID]?>&action=login&xsiteid=<?=$rs[siteid]?>&userkey=1">
      <?=$rs[prename_th]?>
      <?=$rs[name_th]?>
      <?=$rs[surname_th]?>
    </a></td>
    <td align="center"  valign="top"><?=$rs[CZ_ID]?></td>
    <td align="center"  valign="top"><?
# 2501-02-20
$tmp = explode("-" , $rs[birthday] ) ; 
$rsbirthday = $tmp[2] . $tmp[1] .$tmp[0]  ; 
echo $rsbirthday ; 
?></td>
    <td align="left"  valign="top"><?=$arrsec[$rs[siteid]]['site']?>
        <?
if ($rs[schoolname] != ""){ $stroffice = " (". $rs[schoolname] . ")" ; }else{  $stroffice = "" ; } 
echo $stroffice ; 
?></td>
    <td align="center"  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="35%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>��Ǵ�ѭ��</strong></td>
        <td width="35%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�����Ţ<br>��¡�÷��Դ</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>��������´�ѭ��</strong></td>
        </tr>
      <tr>
        <td width="32%" align="center" bgcolor="#A3B2CC"><strong>�����ŷ��Դ</strong></td>
        <td width="33%" align="center" bgcolor="#A3B2CC"><strong>�����ŷ��١��ͧ</strong></td>
      </tr>
      <?
	  	$sql_req = "SELECT t2.req_person_id FROM ".DB_USERENTRY.".tbl_assign_edit_log as t1 Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail as t2 ON t1.runid = t2.log_id
WHERE t1.idcard =  '$rs[CZ_ID]' AND t1.siteid =  '$rs[siteid]' GROUP BY t2.req_person_id";
		$result_req = mysql_db_query($dbnameuse,$sql_req);
		while($rsq = mysql_fetch_assoc($result_req)){
			if($in_req  > "") $in_req .= ",";
			$in_req .= "'$rsq[req_person_id]'";			
		}
		
		if($in_req != ""){
    /*  	$sql_problem = "SELECT t4.problem_caption, t4.problem_detail, t5.problem_name FROM ".DB_USERENTRY.".tbl_assign_edit_log as t1
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail as t2 ON t1.runid = t2.log_id
Inner Join  ".DB_MASTER.".req_temp_wrongdata as t3 ON t2.req_person_id = t3.req_person_id
Inner Join  ".DB_MASTER.".req_problem as t4 ON t3.req_person_id = t4.req_person_id
Inner Join  ".DB_MASTER.".req_problem_group as t5 ON t4.problem_group = t5.runno
WHERE t1.idcard =  '$rs[CZ_ID]' AND t1.siteid =  '$rs[siteid]' GROUP  BY t3.req_person_id";*/

			$sql_problem = "SELECT t4.problem_caption, t4.problem_detail, t5.problem_name,t6.no_caption FROM
  ".DB_MASTER.".req_temp_wrongdata as t3 
Inner Join  ".DB_MASTER.".req_problem as t4 ON t3.req_person_id = t4.req_person_id
Inner Join  ".DB_MASTER.".req_problem_group as t5 ON t4.problem_group = t5.runno
LEFT JOIN   ".DB_MASTER.".req_problem_groupno as t6 ON t6.runid = t4.problem_groupno
WHERE
t3.req_person_id in($in_req)
group by t3.req_person_id";
			$result_problem = mysql_db_query($dbnameuse,$sql_problem);
			$k=0;
			while($rsp = mysql_fetch_assoc($result_problem)){
					if ($k % 2) {$bgx = "#FFFFFF";}else{$bgx = "#F0F0F0";}$k++;
	  ?>
      
      <tr bgcolor="<?=$bgx?>">
        <td align="left"><?=$rsp[problem_name]?></td>
        <td align="left"><?=$rsp[no_caption] != "" ? $rsp[no_caption] : "<center>-</center>"?></td>
        <td align="left"><? echo $rsp[problem_caption];?></td>
        <td align="left"><? echo $rsp[problem_detail];?></td>
      </tr>
     <?
			}//end while($rsp = mysql_fetch_assoc($result_problem)){
		}//end if($in_req != ""){
	 ?>
    </table></td>
      </tr>
    </table></td>
    <td align="center"  valign="top"><?  if($arr_appk[$rs[userkey_wait_approve]] != ""){ echo $arr_appk[$rs[userkey_wait_approve]] ;$sysicon = "<font color='#FF0000'><b>*</b></font>";}else{ echo "<img src=\"../../images_sys/attention_s.png\" width=\"18\" height=\"18\" border=\"0\" title=\"�ʹ��Թ���\">";$sysicon="";}?></td>
    <td align="center"  valign="top"><?
	
		$sql_check_vitaya = "SELECT * FROM log_check_vitaya WHERE idcard = '".$rs[CZ_ID]."' ";
	$query_check_vitaya = mysql_db_query(DB_MASTER,$sql_check_vitaya)or die(mysql_error());
	$num_check_vitaya = mysql_num_rows($query_check_vitaya);
	if($num_check_vitaya == 0){
	 $txt_link = "&first_time=1";
	}else{
	 $txt_link = "";
	}


	echo $sysicon;
	
	?><a href="../hr3/tool_competency/diagnosticv1/userkey_checkdata_edit.php?open_check_vitaya=1<?=$txt_link?>&idcard=<?=$rs[CZ_ID]?>&xsiteid=<?=$rs[siteid]?>&ticketid=<?=$rs[ticketid]?>&fullname=<?=$fullname?>' target='_blank'" target="_blank"><img src="images/package_utilities.png" alt="��Ǩ�ͺ�š�ä�����������ͧ�鹨ҡ��ѡ�ҹ���������" width="20" height="20" border="0"></a>&nbsp;<?=$img_pdf?>&nbsp;<?=$pdf_sys?>&nbsp;
	<?php
	$sql_load = "SELECT MAX(kp7_loadid) AS mx FROM req_kp7_load WHERE idcard = '$rs[CZ_ID]'";
				   $res_load=mysql_db_query(DB_MASTER,$sql_load);   
				  $row_load=mysql_fetch_assoc($res_load);

  	$hdkp7loadid = $row[kp7_loadid] != "" ? $row[kp7_loadid] : $row_load[mx];
		if(trim($hdkp7loadid) != ""){
			echo "<a href='../../../kp7file_request/$rs[siteid]/".$rs[CZ_ID]."_$hdkp7loadid.pdf' target='_blank'><img src='../../images_sys/acroread.png' border='0'  width='16px' title='�͡��� �.�.7 ����硷�͹ԡ�� Ẻ�к������Ţ��¡�üԴ' align='absmiddle'/></a>";
		} else {
			echo "";
		}			
			?>
	</td>
  </tr>
 <?
 		$in_req = "";
		}//while
//} ###### END while (list ($serverid, $servername) = each ($arrserver_name)) { 		
?>

  <tr height=30 bgcolor="#efefef">
    <td colspan="8" align=left><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?>	</td>
  </tr>
  <tr height=30 bgcolor="#efefef">
    <td colspan="8" align=left><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" align="center"><img src="../../images_sys/approve20.png" width="16" height="16" border="0" title="���Թ��������������"></td>
        <td width="96%" align="left" valign="middle"><strong>�����������</strong></td>
      </tr>
      <tr>
        <td align="center"><img src="../../images_sys/doc_green.png" width="20" height="20"  border="0" title="��Ǩ�ͺ������辺�����żԴ"></td>
        <td align="left" valign="middle"><strong>��Ǩ�ͺ������辺�����żԴ</strong></td>
      </tr>
      <tr>
        <td align="center"><img src="../../images_sys/unapprove.png" width="16" height="16"  border="0" title="��Ǩ�ͺ�����繢����Ť���ͧ���"></td>
        <td align="left" valign="middle"><strong>��Ǩ�ͺ�����繢����Ť���ͧ���</strong></td>
      </tr>
      <tr>
        <td align="center"><img src="../../images_sys/icon_comment.png" width="20" height="20"  border="0" title="��ͧ��ä�͸Ժ���������"></td>
        <td align="left" valign="middle"><strong>��ͧ��ä�͸Ժ���������</strong></td>
      </tr>
      <tr>
        <td align="center"><img src="../../images_sys/attention_s.png" width="18" height="18" border="0" title="�ʹ��Թ���"></td>
        <td align="left" valign="middle"><strong>�ʹ��Թ���</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr height=30 bgcolor="#efefef">
    <td colspan="8" align=left>�����˵� : ����ͧ���� <span class="redlink">*</span> ���¶֧��¡�÷���ҹ��õ�Ǩ�ͺ���ͧ�鹨ҡ���������º��������</td>
  </tr>
</table>

<BR>
</BODY>
</HTML>
<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>