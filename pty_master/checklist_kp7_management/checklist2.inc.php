<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 
if($path_config != ''){
	$path_config = $path_config;
}else{
	$path_config = '../../';
}
@include($path_config."config/conndb_nonsession.inc.php");

$dbcallcenter_entry =DB_USERENTRY  ;
$dbnamemaster=DB_MASTER;
$dbsystem = DB_STSTEM;
$dbname_temp = DB_CHECKLIST;
$db_temp = DB_CHECKLIST;
$pathkp7file = "../../../".PATH_KP7_FILE."/";
$config_yy = "52";
$activity_idkey = 3; // �ҹ�ͺ�����͡��ä��������
$path_pdf = "../../../".PATH_KP7_FILE."/";
$report_id48 = 5;// ����ࢵ������ͧ 48 ࢵ

$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='���� �.�.7 �鹩�Ѻ' width='20' height='21' border='0'>";	


$xd = date("Y-m-d");
$xh = date("H");
$xs = date("i");
/*if($xd == "2011-08-30" and (($xh == "13" and $xs >= "01")   or $xh == "14" or $xh == "15" or  $xh == "16" or ($xh == "17" and $xs <= "30")) ){
	
	echo "<font color=\"#CC0000\"><H1 align=center> ��С�� ���� 13.00-17.30  �ͧ�ѹ��� 30  �ԧ�Ҥ� 2554 <br>
��龹ѡ�ҹ�ѹ�֡�����ŷء��ҹ ��ش�ѹ�֡������ <br>
���ͧ�ҡ㹪�ǧ���Ҵѧ����� �е�ͧ��������Է���Ҿ�ͧ ����ͧ Server 
<br>
������㹤�������дǡ�� � �����
</H1></font>";die;
}*/


#$con_doccomplate = " AND  status_numfile='1' AND status_file='1' AND status_check_file='YES' AND (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') AND status_id_false='0'";
$con_doccomplate = " AND ((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0') OR (status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
$xreadonly = "readonly";
$arr_sex  = array("1"=>"���","2"=>"˭ԧ");

##### ���͹䢢����ŷ���������ö������к������ͧ�ҡ�����ž�鹰ҹ���ú ########################

$condition_data = " AND  (prename_th IS NULL OR prename_th='' OR name_th IS NULL OR name_th='' OR surname_th IS NULL OR surname_th='' OR birthday = '' OR birthday='0000-00-00' OR birthday IS NULL OR begindate='' OR begindate='0000-00-00' OR begindate IS NULL OR position_now IS NULL OR position_now='' OR schoolid IS NULL OR schoolid='' OR schoolid='0' OR sex='' OR sex IS NULL  ) ";

$arr_text_month = array("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","May"=>"05","Jun"=>"06","Jul"=>"07","Aug"=>"08","Sep"=>"09","Oct"=>"10","Nov"=>"11","Dec"=>"12");


/*$ipnx = getenv("SERVER_NAME"); 
if(substr($ipnx,0,8) != "192.168."){
		echo " <script language=\"JavaScript\">  alert(\" ��س� login �� ip 192.168.2.12 �����������ҹ�դ����Ǵ�����ҡ��� \") ; </script>  " ;   
		header("Location: http://192.168.2.12/competency_master/application/checklist_kp7_management/logout.php");
}
*/
//system data base
$sysdbname =""  ;
$aplicationpath=MAIN_APP;
//gov data
$gov_name = ""    ;
$ministry_name = "";
$gov_name_en = ""    ;
$connect_status =   ""   ;
$mainwebsite = MAIN_URL  ;
$admin_email    = "";  
$servergraph = "202.129.35.106";
$masterserverip = "";
$policyFile="";

#############################   ��ǹ�ͧ�ѭ�� �. 18
$str_secid=$_GET[xsecid];
$dbedubkk_site = STR_PREFIX_DB.$_GET[xsecid] ;
$sw=1;

$arrtbl_checklist = array("tbl_checklist_kp7"=>"idcard,profile_id","tbl_checklist_log"=>"idcard,profile_id","tbl_checklist_log_last"=>"idcard,profile_id","tbl_checklist_log_upkp7file"=>"idcard,profile_id","tbl_checklist_log_uploadfile"=>"idcard,profile_id","tbl_checklist_problem_detail"=>"idcard,profile_id");


if($sw==1){
	$db_master = DB_MASTER;
	$tbl_general="view_general";
	$tbl_general_outsite="view_general_tempj18_outsite";   
	$tbl_school="allschool";
	$tbl_j18_group="j18_group";
	$tbl_j18_position="j18_position";	
}else{
	$db_master = DB_MASTER;
	$tbl_general="view_general_tempj18";
	$tbl_general_outsite="view_general_tempj18_outsite";   
	$tbl_school="allschool_j18";
	$tbl_j18_group="j18_group_temp";
	$tbl_j18_position="j18_position_temp";
}//end if($sw==1){
######################  �ѭ�� �. 18


$dbtemp_pobec = "temp_pobec_import_checklist";
$dbtemp_check = DB_CHECKLIST;
$db_temp_pobec = "temp_pobec_import_checklist";
$temp_pobec_import = "temp_pobec_import_checklist";
//if($_SESSION['session_username'] == ""){
//	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
//	header("Location: login.php");
//	die;
//}

$ipsource = "localhost";
$ipdest ="localhost";
$arr_approve = array("0"=>"���Ѻ�ͧ","1"=>"�Ѻ�ͧ������","2"=>"�����");

//$config_date = "01/10/".(date("Y")+543);
$config_date = "01/10/2552";
$xyear = (date("Y")+543)."-09-30";

$epm_staff = "keystaff";
$epm_groupmember = "epm_groupmember";
$officetable = "epm_main_menu";
//$path_kp7file = "../../../	kp7file/";
$path_kp7file ="../../../".PATH_KP7_FILE."/";
$fullpath = $_SERVER['DOCUMENT_ROOT']."/".PATH_KP7_FILE."/";


$isLocked = 0;

$max_graphitem = 5;
$graph_path = "http://$servergraph/graphservice/graphservice.php";
$gstyle="srd_sf_014";
$gtype="pie";
$g_ydata = "";
$g_xdata = "";


$headcolor="#3355FF";
$bodycolor="#A3B2CC";
$nextyearcolor="#003333";
	
	//$arr_email = array("kampanat@sapphire.co.th"=>"�����ҷ","anchalee@sapphire.co.th"=>"�ѭ���","nattachai@sapphire.co.th "=>"�ѯ����","pilaiwan@sapphire.co.th"=>"������ó","silachol@sapphire.co.th"=>"���Ҫ�","wanvisa@sapphire.co.th"=>"��ó����","suwat@sapphire.co.th"=>"���Ѳ","chalinee@sapphire.co.th"=>"���Թ�","nongyao@sapphire.co.th"=>"�������","anuphol@sapphire.co.th"=>"͹ؾ� ����");

$arr_email = array("suwat@sapphire.co.th"=>"���Ѳ");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

$ThaiWeekDay = array("Monday"=>"�ѹ���","Tuesday"=>"�ѧ���","Wednesday"=>"�ظ", "Thursday"=>"����ʺ��","Friday"=>"�ء��","Saturday"=>"�����","Sunday"=>"�ҷԵ��");



$status_assign_doc = array("1"=>"��ҧ�׹�͡���","2"=>"�׹�͡�������");

$numdoc = 160; // �������µ���ѹ����᡹��




$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");

function GetDateThaiFullTime($temp){
	global $mname;
	if($temp != "0000-00-00 00:00:00" and $temp != ""){
		$arr = explode(" ",$temp);
		if($arr[0] != "0000-00-00"){
			$arr1 = explode("-",$arr[0]);
			$resultdate = intval($arr1[2])." ".$mname[intval($arr1[1])]." ".($arr1[0]+543) ." ���� ".$arr[1];
		}//end if($arr[0] != "0000-00-00"){
	}//end 	if($temp != "0000-00-00 00:00:00"){
		return $resultdate;
}//end function GetDateThaiFullTime(){


function Show_dateThai($temp){
		global $mname;
				if($temp != "00/00/0000" and $temp != ""){
					$x = explode("/",$temp);
					$m1 = $mname[intval($x[1])];
					$xrs = intval($x[0])." $m1 "." ".$x[2];
				}else{
					$xrs = "";	
				}
				return $xrs;
	}

	function thai_date($temp){
				global $mname;
				if($temp != "0000-00-00"){
					$x = explode("-",$temp);
					$m1 = $mname[intval($x[1])];
					if($x[0] > 2500){
							$y1 = intval($x[0]);
					}else{
						$y1 = intval($x[0]+543);
					}//end if($x[0] > 2500){
					$xrs = intval($x[2])." $m1 "." $y1 ";
				}else{
					$xrs = "";	
				}
				return $xrs;
			}
			
	function thai_dateS($temp){
				global $shortmonth;
				if($temp != "0000-00-00"){
					$x = explode("-",$temp);
					$m1 = $shortmonth[intval($x[1])];
					if($x[0] > 2500){
							$y1 = intval($x[0]);
					}else{
						$y1 = intval($x[0]+543);
					}//end if($x[0] > 2500){
					$xrs = intval($x[2])." $m1 "."".substr($y1,-2) ;
				}else{
					$xrs = "";	
				}
				return $xrs;
			}



function GetDateThaiFull($temp){
		global $monthname;
		if($temp != "0000-00-00"){
				$x = explode("-",$temp);
				$m1 = $monthname[intval($x[1])];
					if($x[0] > 2500){
							$y1 = intval($x[0]);
					}else{
							$y1 = intval($x[0]+543);
					}//end if($x[0] > 2500){
					$xrs = intval($x[2])." $m1 "."".$y1 ;
				}else{
					$xrs = "";	
				}
				return $xrs;

}//end  function GetDateThaiFull($d){
####  �ӹǳ�ѹ����˹��Ѻ�ҹ��ͧ͢��� assign �ҹ
function ShowDateScanEnd($get_date,$get_numdoc){
		global $monthname,$numdoc;
		$loopday = $get_numdoc/$numdoc; // �ӹǹ�ѹ���ӡ���᡹
		$loopc = floor($loopday);
		$loopc1 = ceil($loopday);
		//echo "$loopc :: $loopc1";
		if($loopc == "0"){
				 $arr_d2 = explode("-",$get_date);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] != "0" ){
					 $arr['xdate_label'] = intval($arr_d2[2])." ".$monthname[intval($arr_d2[1])]." ".($arr_d2[0]+543);
					$arr['xdate']	 = $get_date;
				}else{
						$xbasedate = strtotime("$get_date");
				 		$xdate = strtotime("1 day",$xbasedate);
				 		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�	
						$arrd = explode("-",$xsdate);
						$arr['xdate_label'] = intval($arrd[2])." ".$monthname[intval($arrd[1])]." ".($arrd[0]+543);
						$arr['xdate']	 = $xsdate;
	
				}
		}else{
			$arrd = explode("-",$get_date);
			 $xFTime = getdate(date(mktime(0, 0, 0, intval($arrd[1]), intval($arrd[2]), intval($arrd[0]))));	
			 if($xFTime['wday'] != "0"){
				$cdate = $xFTime['wday']+$loopc1;// �ѹ�Ѩ�غѹ
				if($cdate > 6){
					$disnum = floor($cdate/7);// ��ͨйѺ��ҵç�Ѻ�ѹ�ҷԵ�������
					$numday = $loopc1-$disnum;
						$xbasedate = strtotime("$get_date");
				 		$xdate = strtotime("$numday day",$xbasedate);
				 		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�	
						$arrd = explode("-",$xsdate);
						$arr['xdate_label'] = intval($arrd[2])." ".$monthname[intval($arrd[1])]." ".($arrd[0]+543);
						$arr['xdate']	 = $xsdate;

				}else{
						$xbasedate = strtotime("$get_date");
				 		$xdate = strtotime("$loopc1 day",$xbasedate);
				 		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�	
						$arrd = explode("-",$xsdate);
						$arr['xdate_label'] = intval($arrd[2])." ".$monthname[intval($arrd[1])]." ".($arrd[0]+543);
						$arr['xdate']	 = $xsdate;

				}//end if($cdate > 6){
			}else{
					$cdate = $xFTime['wday']+$loopc1+1;// �ѹ�Ѩ�غѹ
					if($cdate > 6){
					$disnum = floor($cdate/7);// ��ͨйѺ��ҵç�Ѻ�ѹ�ҷԵ�������
					$numday = $loopc1-$disnum;
						$xbasedate = strtotime("$get_date");
				 		$xdate = strtotime("$numday day",$xbasedate);
				 		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�	
						$arrd = explode("-",$xsdate);
						$arr['xdate_label'] = intval($arrd[2])." ".$monthname[intval($arrd[1])]." ".($arrd[0]+543);
						$arr['xdate']	 = $xsdate;

				}else{
						$xbasedate = strtotime("$get_date");
				 		$xdate = strtotime("$loopc1 day",$xbasedate);
				 		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�	
						$arrd = explode("-",$xsdate);
						$arr['xdate_label'] = intval($arrd[2])." ".$monthname[intval($arrd[1])]." ".($arrd[0]+543);
						$arr['xdate']	 = $xsdate;

				}//end if($cdate > 6){
					
			}// end  if($xFTime['wday'] != "0"){
			 				
		}//end if($loopc == "0"){
		
	return $arr;
}//end function ShowDateScanEnd(){





$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
function ran_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}


function RandomNumber($num1){

	$my_array = array("0","1","2","3","4","5","6","7","8","9");
	for ($i=0; $i<=$num1; $i++){
		$random = array_rand($my_array);
		$parola .= $my_array[$random];
	}//end for ($i=0; $i<=$num1; $i++){
	return $parola;
		
}//end function RandomNumber(){


function sw_date_show($temp_date){
	if($temp_date != ""){
		$arr = explode("-",$temp_date);
		$xdate = $arr[2]."/".$arr[1]."/".$arr[0];
	}
	return $xdate;
}

######  funcntion 㹡�� genisylࢵ��鹷�����֡��
function GenidcardSys($get_siteid,$str_digi){
		return $get_siteid."".RandomNumber($str_digi);
}//end function GenidcardSys($get_siteid,$str_digi){

function sw_date_indb($temp_date){
	if($temp_date != ""){
		$arr = explode("/",$temp_date);
		if($arr[2] > 2500){
			$result = ($arr[2]-543)."-".$arr[1]."-".$arr[0];
		}else{
			$result = ($arr[2])."-".$arr[1]."-".$arr[0];
		}
	}else{
		$result = "0000-00-00";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){
	
	
function sw_date_indbthai($temp_date){
	if($temp_date != "" and $temp_date != "0000-00-00"){
			$arr = explode("/",$temp_date);
			$result = ($arr[2])."-".$arr[1]."-".$arr[0];
	}else{
			$result = "0000-00-00";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){
## �ѧ���蹵�Ǩ�ͺ��úѹ�֡�����ū��
function check_assign_replace($idcard,$ticketid,$activity_id){
global $dbname_temp,$profile_id;
	$sql = "SELECT count(idcard) as num1 FROM tbl_checklist_assign_detail WHERE idcard='$idcard' AND profile_id='$profile_id' and activity_id='$activity_id' GROUP BY idcard  ";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	return $rs[num1];

}## end �ѧ���蹵�Ǩ�ͺ��úѹ�֡�����ū��	
	


function show_user($get_staffid){
		global $dbcallcenter_entry;
		$sql = "SELECT * FROM  keystaff WHERE staffid='$get_staffid'";
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function show_user(){

function CheckLockArea($get_site="",$profile_id){
	global $dbname_temp;
	if($profile_id == ""){// �ó���������͡���� ������
		$profile_id = LastProfile();
	}//end if($profile_id == ""){// �ó���������͡���� ������
	//$sql_count = "SELECT COUNT(siteid) AS num_site FROM tbl_status_lock_site WHERE siteid='$get_site' AND profile_id='$profile_id'";
	$sql_count = "SELECT COUNT(siteid) AS num_site,siteid FROM tbl_status_lock_site WHERE  profile_id='$profile_id'  group by siteid";
	$result_count = mysql_db_query($dbname_temp,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$arr1[$rs_c[siteid]] = $rs_c[num_site];	
	}
	return $arr1;
}

function get_dateThai($get_date,$xtype=""){
	global $shortmonth;
		if($get_date != "" and get_date != "0000-00-00 00:00:00"){
			$arrd = explode(" ",$get_date);
			$arrd1 = explode("-",$arrd[0]);
			if($xtype != ""){
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543);
			}else{
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543)." ���� $arrd[1] �.";
			}
			
		}else{
			$xdate = "����к�";
		}
	return $xdate;
}//end function get_dateThai(){

### �ѧ��Ѫ�� ����¹�ҡ �.�. �� �.�.
	function sw_dateE($get_date){
		$arr1 = explode("/",$get_date);
		return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
	}

### �ѧ��Ѫ�� ����¹�ٻẺ��èѴ�红�����
	function SwDateT($get_date){
		$arr1 = explode("/",$get_date);
		return ($arr1[2])."-".$arr1[1]."-".$arr1[0];
	}
### function FROM show
function DateFrom($d){
	$arr = explode("-",$d);
	return $arr[2]."/".$arr[1]."/".($arr[0]+543);
	
}//end function DateFrom(){
	
	
function sw_date_intxtbox($temp_date){
	if($temp_date != "0000-00-00"){
		$arr = explode("-",$temp_date);
		$result = $arr[2]."/".$arr[1]."/".($arr[0]+543);
	}else{
		$result = "";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){


function addLog($action,$detail){
//action 8=login fail, 9 = login , 10 = logout
	$ip = get_real_ip();
	$sql = "insert into log_update(logtime,staffid,act,detail,pcomplete,bpercent,ip) values(now(),'$_SESSION[session_staffid]','$action','$detail','$pcomplete','$bpercent','$ip');"; 
	$result = mysql_db_query(DB_CHECKLIST,$sql);
}




function person_not_assign($xidcard,$xsiteid,$ticketid,$act_id=""){ // �ѧ���蹵�Ǩ�ͺ�óպؤ�ҡö١ assing ¡��鹵���ͧ
global $dbname_temp,$profile_id;
if($act_id != ""){
		$conv = " AND activity_id='$act_id' ";
}else{
		$conv = "";	
}
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_assign_detail WHERE  idcard = '$xidcard'  AND siteid='$xsiteid' AND profile_id='$profile_id' $conv   GROUP BY idcard ";
	$result_p = @mysql_db_query($dbname_temp,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];
}// end function person_not_assign(){

## ��Ǩ�ͺ�ͧ����ͧ
function person_select_assign($xidcard,$xsiteid,$ticketid){
global $dbname_temp,$profile_id;
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_assign_detail  WHERE ticketid = '$ticketid' AND siteid='$xsiteid' AND idcard = '$xidcard' AND profile_id = '$profile_id' GROUP BY idcard ";
	$result_p = @mysql_db_query($dbname_temp,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];

}// function person_select_assign($xidcard,$xsiteid){

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


##########  log ��� assgin �ҹ�᡹
function SaveLogAssign($idcard,$siteid,$ticketid,$action,$comment=""){
		global $dbtemp_check;
			$ip = get_real_ip();
		$sql_insert = "INSERT INTO tbl_checklist_assign_log SET ticketid='$ticketid',idcard='$idcard',siteid='$siteid',staffid='".$_SESSION[session_staffid]."',user_ip='$ip',action='$action',comment='$comment',timeupdate=NOW()";
		mysql_db_query($dbtemp_check,$sql_insert);
}//end function SaveLogAssign($idcard,$siteid,$action,$comment=""){

function GetProvinceId_v1(){
	global $dbnamemaster;
	$sql = "SELECT left(t1.ccDigi,2) as prov_id FROM `view_province` as t1";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[prov_id]] = $rs[prov_id];	
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetProvinceId_v1(){


### ��Ǩ�ͺ�Ţ�ѵ�
function Check_IDCard($StrID){
	$arrprov = GetProvinceId_v1();
	 if(is_numeric($StrID)){
				 $sub_id = substr($StrID,0,1); // �ҵ���Ţ����á����� 0 �������
				 $sub_idprovince = substr($StrID,1,2); // ������ �Ţ�ѵ÷���� id �ͧ���ʨѧ��Ѵ
			 if(array_key_exists("$sub_idprovince", $arrprov) or $sub_id == "9") {
				 	
				if($sub_id >0){
					if(strlen($StrID)==13){
						$id=str_split($StrID); 
						$sum=0;    
							for($i=0; $i < 12; $i++){
								 $sum += floatval($id[$i])*(13-$i); 
							}   
								if((11-$sum%11)%10!=floatval($id[12])){
									 return false;
								}else{
									 return true; 
								}
					}else{
						return false;
					} 
			}else{
				return false; 
			}
		}else{
			return false;	
		}//end 
    }else{
        return false;    
    }
} //end function Check_IDCard($StrID){


###  

function count_person_pobec($get_secid){
global $dbtemp_pobec;
	$tbl_pobec = "pobec_$get_secid";
	$sql_count = "select count(IDCODE) as num_id 	from $tbl_pobec WHERE IDCODE <> '' AND IDCODE IS NOT NULL";
	$result_count = @mysql_db_query($dbtemp_pobec,$sql_count);
	$rs_c = @mysql_fetch_assoc($result_count);
	return $rs_c[num_id];
}
function check_imp_kp7($get_secid,$profile_id=""){
	$db_call = DB_CHECKLIST;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	$sql_1 = "select count(idcard) as num1 from tbl_checklist_kp7 where siteid='$get_secid' AND profile_id='$profile_id'";
	$result1 = mysql_db_query($db_call,$sql_1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[num1];
}
###########  ����Ң����� pobec ����к ��Ǩ�ͺ�����١��ͧ�ͧ�͡���
### �Ҥӹ�˹�Ҫ���
function get_prename($get_precode){
	global $dbtemp_pobec;
	$sql_p = "SELECT PRE_NAME FROM  prencode WHERE SUR_CODE='$get_precode'";
	$result_p = mysql_db_query($dbtemp_pobec,$sql_p);
	$rs_p = mysql_fetch_assoc($result_p);
	return $rs_p[PRE_NAME];
}// end function get_prename($get_precode){

## �ҵ��˹�
function get_position($get_postcode){
	global $dbtemp_pobec;
	$sql_post = "SELECT
edubkk_master.hr_addposition_now.`position`
FROM
temp_pobec_import_checklist.postcode
Inner Join edubkk_master.hr_addposition_now ON temp_pobec_import_checklist.postcode.pid = edubkk_master.hr_addposition_now.pid
WHERE
temp_pobec_import_checklist.postcode.POST_CODE =  '$get_postcode'";
	$result_post = mysql_db_query($dbtemp_pobec,$sql_post);
	$rs_post = mysql_fetch_assoc($result_post);
	return $rs_post[position];
}//END function get_position($get_postcode){

function get_school($get_icode,$get_siteid){
	global $dbnamemaster;
	$sql_school = "SELECT id, office,prefix_name FROM allschool WHERE i_code='$get_icode' AND siteid='$get_siteid'";
	$result_school = mysql_db_query($dbnamemaster,$sql_school);
	$rs_school = mysql_fetch_assoc($result_school);
	$arr_school['id'] = $rs_school[id];
	$arr_school['schoolname'] = $rs_school[prefix_name].$rs_school[office];
	return $arr_school;
}

###  �ʴ������ç���¹�¤��Ҩҡ����˹��§ҹ
function GetSchoolByName($get_school,$get_siteid){
global $dbnamemaster;
	$sql_s ="SELECT id FROM allschool WHERE office='$get_school' AND siteid='$get_siteid'";
	$result_s = mysql_db_query($dbnamemaster,$sql_s);
	$rs_s = mysql_fetch_assoc($result_s);
	return $rs_s[id];
}//end function GetSchoolByName(){
	
	################   update  icode � allschool 
function UpdateSchool_icode($icode,$schoolname,$siteid){
		global $dbnamemaster;
		$sqlu = "UPDATE allschool SET  i_code='$icode' WHERE office='$schoolname' AND siteid='$siteid'";
		mysql_db_query($dbnamemaster,$sqlu);
}//end function UpdateSchool_icode(){
	
function GetBirthDay($get_site,$get_idcard){
		global $dbnamemaster;
		$sql = "SELECT birthday,begindate,sex FROM view_general  WHERE CZ_ID='$get_idcard'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['birthday'] = $rs[birthday];
		$arr['begindate'] = $rs[begindate];
		$arr['sex'] = $rs[sex];
		return $arr;
	}//end function GetBirthDay(){


###  �ѧ�����ʴ���Ǵ�ѭ��
function show_problem($xtype=""){
	global $dbtemp_check;
	if($xtype == ""){
			$conv = " WHERE type_problem='0'";
	}else if($xtype == "1"){
			$conv = " WHERE type_problem='1'";
	}else if($xtype == "2"){
			$conv = "";
	}
	$sql = "SELECT * FROM tbl_problem  $conv  ORDER BY problem_id ASC";
	$result = mysql_db_query($dbtemp_check,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$result_id[$rs[problem_id]] = $rs[problem];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $result_id;
}//end function show_problem(){
	
	
function show_problem_process(){
	global $dbtemp_check;

	$sql = "SELECT * FROM tbl_problem  ORDER BY problem_id ASC";
	$result = mysql_db_query($dbtemp_check,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$result_id[$rs[problem_id]] = $rs[problem]."||".$rs[type_problem];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $result_id;
}//end function show_problem(){

###  ��Ǩ�ͺ�Ţ�ѵ�仫�ӡѺ�����
function check_idreplace($get_secid,$get_idcard,$get_name,$get_surname,$get_birthday){
	global $dbnamemaster;
	$sql_r = "SELECT CZ_ID,siteid,name_th,surname_th,birthday FROM view_general WHERE CZ_ID='$get_idcard'";
	$result_r = mysql_db_query($dbnamemaster,$sql_r);
	$rs_r = mysql_fetch_assoc($result_r);
	if($rs_r[CZ_ID] != ""){
	
	if($get_secid != $rs_r[siteid]){ // �ó�����ࢵ���ǡѹ
	
			if(($rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname)){
				$error_msg['siteid'] = $rs_r[siteid];
				$error_msg['msg'] = "IDCARD_REP";
			}else{
				$error_msg['siteid'] = $rs_r[siteid];
				$error_msg['msg'] = "IDCARD_REP_NO_PERSON";
			}
	}/*else{
	//echo "$rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname";
		if(($rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname)){
			$error_msg['siteid'] = "";
			$error_msg['msg'] = "";
		}else{
			$error_msg['siteid'] = $rs_r[siteid];
			$error_msg['msg'] = "IDCARD_REP_NO_PERSON";
		}
		
	}*///end 	if($get_secid == $rs_r[siteid]){
	}//end if($rs_r[CZ_ID] != ""){
	return $error_msg;
}// end function check_replace(){
	###  function ��Ǩ�ͺ ������� cmss ��������ѧ
	function UpdateDataCmss($get_siteid,$get_idcard,$get_schoolid){
		$db_site = "edubkk_$get_siteid";
		$sql = "SELECT COUNT(idcard) as numid FROM general WHERE idcard='$get_idcard'";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[numid] > 0){
				$sql_update = "UPDATE general SET schoolid='$get_schoolid' WHERE idcard='$get_idcard'";
				mysql_db_query($db_site,$sql_update);
		}
	}// end function UpdateDataCmss($get_siteid,$get_idcard){

	
	function insert_log_import($get_siteid,$get_idcard,$get_action="",$get_type="",$staff_id="",$get_schoolid="",$get_siteid_old="",$get_schoolid_old="",$profile_id="",$action_comment=""){
//action 8=login fail, 9 = login , 10 = logout
global $dbname_temp;
	$ip = get_real_ip();
	if($staff_id != ""){
		$staff_id = $staff_id;
	}else{
		$staff_id = $_SESSION[session_staffid];
	}
	
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	
	if($get_type != ""){
	$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,type_action,schoolid,siteid_old,schoolid_old,user_save,profile_id,action_comment,time_update) values('$get_idcard','$get_siteid','$staff_id','$ip','$get_action','1','$get_schoolid','$get_siteid_old','$get_schoolid_old','".$_SESSION[session_staffid]."','$profile_id','$action_comment',NOW())"; 
	}else{
		$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,type_action,user_save,profile_id,action_comment,time_update) values('$get_idcard','$get_siteid','$staff_id','$ip','$get_action','0','".$_SESSION[session_staffid]."','$profile_id','$action_comment',NOW())"; 
	}
	//echo $dbname_temp." :: ".$sql;die;
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()." $dbname_temp <br>$sql<br>LINE ::".__LINE__);
}


function insert_log_checklist_last($get_siteid,$get_idcard,$get_action="",$get_type="",$staff_id="",$get_schoolid="",$get_siteid_old="",$get_schoolid_old="",$profile_id="",$action_comment=""){
//action 8=login fail, 9 = login , 10 = logout
global $dbname_temp;
	$ip = get_real_ip();
	if($staff_id != ""){
		$staff_id = $staff_id;
	}else{
		$staff_id = $_SESSION[session_staffid];
	}
	
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	
	if($get_type != ""){
	$sql = "REPLACE INTO tbl_checklist_log_last(idcard,siteid,user_update,ip_server,action_data,type_action,schoolid,siteid_old,schoolid_old,user_save,profile_id,action_comment,time_update) values('$get_idcard','$get_siteid','$staff_id','$ip','$get_action','1','$get_schoolid','$get_siteid_old','$get_schoolid_old','".$_SESSION[session_staffid]."','$profile_id','$action_comment',NOW())"; 
	}else{
		$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,type_action,user_save,profile_id,action_comment,time_update) values('$get_idcard','$get_siteid','$staff_id','$ip','$get_action','0','".$_SESSION[session_staffid]."','$profile_id','$action_comment',NOW())"; 
	}

	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$dbname_temp<br>$sql<br>LINE : ".__LINE__);
}//end 


#######  �ѧ���蹵�Ǩ�ͺ���Ң����ū�ӡѹ� ���ҧ checklist
	function CheckIdReplaceChecklist($get_secid,$get_idcard,$profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		$sql_r1 = "SELECT count(idcard) as num_id,siteid FROM tbl_checklist_kp7 WHERE idcard='$get_idcard' and siteid <> '$get_secid' and profile_id='$profile_id' group by idcard";
		$result_r1 = mysql_db_query($dbtemp_check,$sql_r1);
		$rs_r1 = mysql_fetch_assoc($result_r1);
			if($rs_r1[num_id] > 0){ // �ó������ʫ��ѡѺࢵ���� �� list
				$error_msg['siteid'] = $rs_r1[siteid];
				$error_msg['msg'] = "REP_CHECKLISTSITE";
			}else{
				$error_msg['siteid'] = "";
				$error_msg['msg'] = "";
			}//end if($rs_r1[num_id] > 0){
		return $error_msg;
	}//end function CheckIdReplaceChecklist(){
###  end  �ѧ���蹵�Ǩ�ͺ���Ң����ū�ӡѹ� ���ҧ checklist

#####  function ��Ǩ�ͺ�ó��Ţ�ѵüԴ� pobec �������� cmss ����㹹��Ţ�ѵù����������
	function CheckIdCmss($get_siteid,$get_name,$get_surname,$get_birthday){
		global $dbnamemaster;
		$sql_cmss = "SELECT CZ_ID,siteid FROM view_general WHERE name_th='$get_name' AND surname_th='$get_surname' AND birthday='$get_birthday'";
		$result_cmss = @mysql_db_query($dbnamemaster,$sql_cmss);
		$rs_cmss = @mysql_fetch_assoc($result_cmss);
		if($rs_cmss[CZ_ID] != ""){ //�ó��դ������к�����ա��������� �Ţ�ѵ÷��١��ͧ����
				if($rs_cmss[siteid] != $get_siteid){ // �ʴ���Ң����������仫�ӡѺࢵ���
					$result_msg['siteid'] = $rs_cmss[siteid];
					$result_msg['msg'] = "REPLACE";
					$result_msg['id'] = $rs_cmss[CZ_ID];
				}else{
					$result_msg['siteid'] = "";
					$result_msg['msg'] = "";
					$result_msg['id'] = $rs_cmss[CZ_ID];
				}//end if($rs_cmss[siteid] != $get_siteid){ 
			}//end if($rs_cmss[CZ_ID] != ""){

		return $result_msg;
	}//end function CheckIdCmss(){

## end  function ��Ǩ�ͺ�ó��Ţ�ѵüԴ� pobec �������� cmss ����㹹��Ţ�ѵù����������
###  �Ѻ�ӹǹ���������� list ��
	function count_imp_checklist($get_secid,$get_type="",$profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		
		if($get_type == "F"){
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7_false WHERE siteid='$get_secid' AND status_IDCARD='IDCARD_FAIL' AND  status_chang_idcard='NO' and profile_id='$profile_id'";
		}else if($get_type == "FR"){
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7_false WHERE  profile_id='$profile_id' and siteid='$get_secid' AND (status_IDCARD_REP='IDCARD_REP' OR status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR status_IDCARD_REP='REP_CHECKLISTSITE') and (status_id_replace='0')";
		}else if($get_type == "R"){ // ���³�����Ҫ���
			$sql = "SELECT COUNT(idcard) as numIMP FROM tbl_checklist_kp7_false WHERE siteid='$get_secid' AND status_retire='1' and profile_id='$profile_id'";
		}else{
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7 WHERE siteid='$get_secid' AND profile_id='$profile_id'";
		}
			$result = mysql_db_query($dbtemp_check,$sql);
			$rs = mysql_fetch_assoc($result);

	return $rs[numIMP];
	}// end function count_imp_checklist($get_secid){
		
	###  �Ѻ�ӹǹ���������� list ��
	function count_imp_checklist_v1($profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
				 
		$sql = "SELECT 
		SUM(if(status_IDCARD='IDCARD_FAIL' AND  status_chang_idcard='NO',1,0)) AS F,
		SUM(if((status_IDCARD_REP='IDCARD_REP' OR status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR status_IDCARD_REP='REP_CHECKLISTSITE') and (status_id_replace='0'),1,0)) AS FR,
		SUM(if(status_retire='1',1,0)) AS R,siteid 
		FROM  tbl_checklist_kp7_false WHERE   profile_id='$profile_id'  GROUP BY siteid
		";
			$result = mysql_db_query($dbtemp_check,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]]['F'] = $rs[F];
					$arr[$rs[siteid]]['FR'] = $rs[FR];
					$arr[$rs[siteid]]['R'] = $rs[R];
			}// end while($rs = mysql_fetch_assoc($result)){

	return $arr;
	}// end function count_imp_checklist($get_secid){

	function count_imp_checklist_v2($profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
				 
		$sql = "SELECT COUNT(idcard) AS numIMP,siteid FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' GROUP BY siteid
		";
			$result = mysql_db_query($dbtemp_check,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]]= $rs[numIMP];
			}// end while($rs = mysql_fetch_assoc($result)){

	return $arr;
	}// end  function count_imp_checklist_v2($profile_id=""){



### �Ѻ�ӹǹ��¡�÷���ҹ��õ�Ǩ�ͺ����͡�õ�Ǩ�ͺs
	function count_checklist_kp7($get_siteid,$get_type,$get_school="",$profile_id){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		
		if($get_school != ""){
			$con_s = " AND schoolid='$get_school'  AND profile_id='$profile_id'";
		}else{
			$con_s = " AND profile_id='$profile_id'";
		}
		if($get_type == "Y"){
			$sql_c1 = "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file = 'YES' AND status_file='1' AND siteid='$get_siteid' $con_s";
		}else if($get_type == "YN"){
			$sql_c1 =  "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file = 'YES' AND status_file='0' AND siteid='$get_siteid' $con_s";
		}else if($get_type == "N"){
			$sql_c1 = "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file='NO' AND siteid='$get_siteid' $con_s";
		}
		//echo $sql_c1."<br>";
		$result_c1 = mysql_db_query($dbtemp_check,$sql_c1);
		$rs_c1 = mysql_fetch_assoc($result_c1);
		return $rs_c1[numc1];
	}//end 	function count_checklist_kp7($get_siteid,$get_type){
		
	#####  function �Ѻ�š�õ�Ǩ�͡��� version 1
	function CountCheckListKp7($get_siteid,$get_school="",$profile_id=""){
	global $dbtemp_check;
		if($profile_id == ""){
				$profile_id = LastProfile();
		}
	
		if($get_school != ""){
			$con_s = " AND schoolid='$get_school' AND profile_id='$profile_id'";
		}else{
			$con_s = " AND profile_id='$profile_id'";
		}
	
	$sql_count = "SELECT 
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as NumPass, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0'  ,1,0)) as NumDisC, 
sum(page_num) as NumPage, 
sum(if(status_numfile='1' ,1,0)) as NumQL, 
sum(pic_num) as NumPic, 
count(idcard) as NumAll,
sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse
 FROM tbl_checklist_kp7
 WHERE siteid='$get_siteid' $con_s";	
		
	$result_count = mysql_db_query($dbtemp_check,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
		$ArrNum['NumPass'] = $rs_c[NumPass];
		$ArrNum['NumNoPass'] = $rs_c[NumNoPass];
		$ArrNum['NumDisC'] = $rs_c[NumDisC];
		$ArrNum['NumPage'] = $rs_c[NumPage];
		$ArrNum['NumPic'] = $rs_c[NumPic];
		$ArrNum['NumAll'] = $rs_c[NumAll];
		$ArrNum['NumM'] = $rs_c[NumM];
		$ArrNum['NumF'] = $rs_c[NumF];
		$ArrNum['NumQL'] = $rs_c[NumQL];
		$ArrNum['NumNoMain'] = $rs_c[NumNoMain];
		$ArrNum['numidfalse'] = $rs_c[numidfalse];
		$ArrNum['numnorecive'] = $rs_c[numnorecive];
		$ArrNum['numnorecive_idfalse'] = $rs_c[numnorecive_idfalse];
	return $ArrNum;
	}//end 	function CountCheckListKp7($get_siteid,$get_type,$get_school=""){
	###  end function �Ѻ�š�õ�Ǩ�͡��� version 1
		
function CountCheckListKp7V1($profile_id=""){
	global $dbtemp_check;
		if($profile_id == ""){
				$profile_id = LastProfile();
		}
	

			$con_s = " WHERE  profile_id='$profile_id'";
	
	
	$sql_count = "SELECT 
	siteid,
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as NumPass, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0' ,1,0)) as NumDisC, 
sum(if(status_numfile='1',1,0)) as NumQL, 
sum(page_num) as NumPage, 
sum(pic_num) as NumPic, 
count(idcard) as NumAll,
sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse
 FROM tbl_checklist_kp7
   $con_s
 group by siteid
 ";	
		#echo $sql_count;die;
	$result_count = mysql_db_query($dbtemp_check,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$ArrNum[$rs_c[siteid]]['NumPass'] = $rs_c[NumPass];
		$ArrNum[$rs_c[siteid]]['NumNoPass'] = $rs_c[NumNoPass];
		$ArrNum[$rs_c[siteid]]['NumDisC'] = $rs_c[NumDisC];
		$ArrNum[$rs_c[siteid]]['NumPage'] = $rs_c[NumPage];
		$ArrNum[$rs_c[siteid]]['NumPic'] = $rs_c[NumPic];
		$ArrNum[$rs_c[siteid]]['NumAll'] = $rs_c[NumAll];
		$ArrNum[$rs_c[siteid]]['NumM'] = $rs_c[NumM];
		$ArrNum[$rs_c[siteid]]['NumF'] = $rs_c[NumF];
		$ArrNum[$rs_c[siteid]]['NumQL'] = $rs_c[NumQL];
		$ArrNum[$rs_c[siteid]]['NumNoMain'] = $rs_c[NumNoMain];
		$ArrNum[$rs_c[siteid]]['numidfalse'] = $rs_c[numidfalse];
		$ArrNum[$rs_c[siteid]]['numnorecive'] = $rs_c[numnorecive];
		$ArrNum[$rs_c[siteid]]['numnorecive_idfalse'] = $rs_c[numnorecive_idfalse];
	}
	return $ArrNum;
}//end 	function function CountCheckListKp7V1($get_siteid,$get_school="",$profile_id=""){
	###  end function �Ѻ�š�õ�Ǩ�͡��� version 1	
		
###  �ʴ�����ࢵ��鹷�����֡��
	function show_area($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname];
	}//end function show_area($get_secid){
		
	##�ʴ�����ࢵ��鹷�����֡��Ẻ���
	function ShowAreaSort($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_area[secname]);
	}//end function ShowAreaSort($get_secid){
	
	function ShowAreaSortName($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname_short FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname_short];
	}//end function ShowAreaSortName($get_secid){
	
###  �ѧ�����ʴ�˹��§ҹ
	function show_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office,prefix_name FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[prefix_name].$rs_school[office];
	}//end function show_school($get_schoolid){

## end �ѧ�����ʴ�˹��§ҹ
	function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_name,$key_surname,$key_idcard,$sentsecid,$schoolid,$xsiteid,$lv,$profile_id,$office;

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
			$table .= "<a href=\"?page=1&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people".$kwd."\"><u><font color=\"black\">˹���á</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><u><font color=\"black\">˹���ش����</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><u><font color=\"black\">�ʴ�������</font></u></a>";
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


###########   function �ʴ���������ó�����������ó�ͧ��¡��<img src="../../images_sys/unapprove.png" width="16" height="16">
	function show_icon_check($get_value,$get_status ="",$get_numfile="",$file_comp=""){
		
		if($get_status != ""){/// �óյ�Ǩ�ͺ 3 ʶҹ� ��� �ѧ������Ǩ�ͺ , ��Ǩ�ͺ���Ǽ�ҹ, ��Ǩ�ͺ�����ѧ����ҹ 
				if($get_status == "YES"){
					if($get_value == "1"){
						$g_icon = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"��¡������ó�\">";
					}else{						
							if($get_numfile == "1" and $file_comp == ""){
							$g_icon = "<img src=\"../../images_sys/person.gif\" width=\"16\" height=\"13\" border=\"0\" title=\"ʶҹС�õ�Ǩ�Ѻ���º��������\">";
							}else{
							$g_icon = "<img src=\"../salary_mangement/images/bullet_error.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"��Ǩ�ͺ�����ѧ����ҹ\">";	
							}
					}
				}else{
					if($get_numfile == "1" and $file_comp == ""){
						$g_icon = "<img src=\"../../images_sys/person.gif\" width=\"16\" height=\"13\" border=\"0\" title=\"ʶҹС�õ�Ǩ�Ѻ���º��������\">";
					}else{
						$g_icon = "<img src=\"../salary_mangement/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"��¡���ѧ������Ѻ��õ�Ǩ�ͺ\">";
					}
				}//end if($get_status == "YES"){
		}else{ /// �� 2 ʶҹ� ��ͼ�ҹ, ����ҹ
			if($get_value == "0"){

				$g_icon = "<img src=\"../salary_mangement/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�ѧ������Ѻ��õ�Ǩ�ͺ\">";
			}else if($get_value == "1"){
				$g_icon = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"��¡������ó�\">";
			} // end if($get_value == "0"){
		}//end 
		
		return $g_icon;
	}//end function show_icon_check(){ 
	
	###########  function �Ѻ�ӹǹ�� �ӹǹ�ٻ
	function count_page_pic($get_secid,$get_lv="area",$get_school="",$profile_id){
		global $dbname_temp;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}

		if($get_lv == "area"){
			$sql = "SELECT sum(page_num) as sum_page, sum(pic_num) as sum_pic FROM tbl_checklist_kp7 where siteid='$get_secid' AND profile_id='$profile_id'";
		}else if($get_lv == "school"){
			$sql = "SELECT sum(page_num) as sum_page, sum(pic_num) as sum_pic FROM tbl_checklist_kp7 where siteid='$get_secid' AND schoolid='$get_school' AND profile_id='$profile_id'";
		}
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr_val['page'] = $rs[sum_page];
		$arr_val['pic'] = $rs[sum_pic];
		return $arr_val;		
	}// end function count_page_pic($get_secid,$get_lv="area",$get_school=""){
	
	### �ѧ�����ʴ���� exsum
	function show_val_exsum($get_lv="",$get_siteid="",$get_school="",$profile_id=""){
		global $dbname_temp;
			if($profile_id == ""){
					$profile_id = LastProfile();
			}
		 if($get_lv == "1"){ // ����ࢵ
			$conv = " where siteid='$get_siteid' AND profile_id='$profile_id'";	
		}else if($get_lv == "2"){ // �����ç���¹
			$conv = " where siteid='$get_siteid' AND schoolid='$get_school' AND profile_id='$profile_id'";	
		}else{
			$conv = " where profile_id='$profile_id'";
		}



		$sql = "SELECT 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',1,0 )) as numY0, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',page_num,0 )) as numY0page, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as numY1, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and status_id_false='0' ,page_num,0)) as numY1page, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0',1,0)) as numN, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' ,page_num,0)) as numNpage,  
		sum(if(page_num <> page_upload and page_upload > 0,1,0)) as PageNoMath,
		sum(if(status_file='1' and page_upload > 0,1,0)) as NumFile,
    	count(idcard) as numall,
		sum(page_num) as numpage,
		sum(pic_num) as numpic,
		sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
		sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse,
		sum(if(status_numfile='1',1,0)) as NumQL
    	FROM tbl_checklist_kp7   $conv";	
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);

		$rs = mysql_fetch_assoc($result);
		$arr['numY0'] = $rs[numY0];														//  ��Ǩ�ͺ�͡������� �������ó�  
		$arr['numMY0'] = $rs[numMY0];	
		$arr['numFY0'] = $rs[numFY0];
		$arr['numY1'] = $rs[numY1];														//  ��Ǩ�ͺ�͡�������  ����ó
		  $arr['NumMY1'] = $rs[NumMY1];	
		 $arr['NumFY1'] = $rs[NumFY1];	
		  $arr['NumM'] = $rs[NumM];	
		 $arr['NumF'] = $rs[NumF];	
		 
		$arr['numN'] = $rs[numN];															// ���������ҧ��õ�Ǩ�ͺ
         $arr['NumMN'] = $rs[NumMN];	
		 $arr['NumFN'] = $rs[NumFN];	
		
		$arr['numall'] = $rs[numall];															// 
		$arr['numpage'] = $rs[numpage];												// 
		$arr['numpageM'] = $rs[numpageM];
		$arr['numpageF'] = $rs[numpageF];
		$arr['numpic'] = $rs[numpic];	
		$arr['numpicM'] = $rs[numpicM];	
		$arr['numpicF'] = $rs[numpicF];	
		// �ӹǹ�ٻ�Ҿ

		$arr['numY0page'] = $rs[numY0page];										// ��Ǩ�ͺ�͡������� �������ó�   �ӹǹ��
		$arr['numY1page'] = $rs[numY1page]; 										// ��Ǩ�ͺ�͡�������  ����ó �ӹǹ��
		$arr['numNpage'] = $rs[numNpage]; 	// ���������ҧ��õ�Ǩ�ͺ�ӹǹ��  =0
		$arr['PageNoMath']  = $rs[PageNoMath];// �ӹǹ��¡�÷��Ѻ�������ҡѺ�к�
		$arr['NumFile'] = $rs[NumFile]; // �Ѻ�ӹǹ��������
		$arr['NumM'] = $rs[NumM];
		$arr['NumF'] = $rs[NumF];
		$arr['NumNoMain'] = $rs[NumNoMain];
		$arr['numidfalse'] = $rs[numidfalse];
		$arr['numnorecive'] = $rs[numnorecive];
		$arr['numnorecive_idfalse'] = $rs[numnorecive_idfalse];
		$arr['NumQL'] = $rs[NumQL];
		return $arr;
	}//end function show_val_exsum($get_lv="",$get_type){
		
		
		function show_val_exsumall($profile_id){
		global $dbname_temp;

		$sql = "SELECT 
    	count(idcard) as numall,
		sum(pic_num) as numpic,
		sum(if(number='' or number is null,pic_num,number)) as numpicF,
		sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse,
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0' ,1,0)) as NumDisC,
		siteid,
Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as NumPass, 
Sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		if(substring(siteid,1,1)=0,'spm','spp') as subsite
    	FROM tbl_checklist_kp7 Left Join upload_compare_kp7 ON tbl_checklist_kp7.idcard = upload_compare_kp7.id  WHERE profile_id='$profile_id' GROUP BY siteid";	
	//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			
			$arr[$rs[siteid]]['numall'][$rs[subsite]] = $rs[numall];															// 
			$arr[$rs[siteid]]['numpic'][$rs[subsite]] = $rs[numpic];	
			$arr[$rs[siteid]]['numnorecive'][$rs[subsite]] = $rs[numnorecive];	
			$arr[$rs[siteid]]['NumDisC'][$rs[subsite]] = $rs[NumDisC];	
			$arr[$rs[siteid]]['NumPass'][$rs[subsite]] = $rs[NumPass];	
			$arr[$rs[siteid]]['NumNoPass'][$rs[subsite]] = $rs[NumNoPass];	
			$arr[$rs[siteid]]['NumNoMain'][$rs[subsite]] = $rs[NumNoMain];	
			$arr[$rs[siteid]]['numpicF'][$rs[subsite]] = $rs[numpicF];
			$arr[$rs[siteid]]['numnorecive_idfalse'][$rs[subsite]] = $rs[numnorecive_idfalse];
	
		}//end while($result = mysql_db_query($dbname_temp,$sql)){
		return $arr;
	}//end function show_val_exsum($get_lv="",$get_type){
		
		


function show_val_exsumbysite($profile_id=""){
		global $dbname_temp;
			if($profile_id == ""){
					$profile_id = LastProfile();
			}

		$sql = "SELECT 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',1,0 )) as numY0, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as numY1, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0',1,0)) as numN, 
    	count(idcard) as numall,
		sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
		sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
		sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse,
		sum(if(status_numfile='1',1,0)) as NumQL,
		siteid
    	FROM tbl_checklist_kp7   WHERE profile_id='$profile_id' GROUP BY siteid";	
		//echo $sql;
		//echo $dbname_temp;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['numY0'] = $rs[numY0];														//  ��Ǩ�ͺ�͡������� �������ó�  
			$arr[$rs[siteid]]['numY1'] = $rs[numY1];	
			$arr[$rs[siteid]]['NumNoMain'] = $rs[NumNoMain];
			$arr[$rs[siteid]]['numN'] = $rs[numN];														//  ��Ǩ�ͺ�͡�������  ����ó
			$arr[$rs[siteid]]['numall'] = $rs[numall];	
			$arr[$rs[siteid]]['numidfalse'] = $rs[numidfalse];	
			$arr[$rs[siteid]]['numnorecive'] = $rs[numnorecive];	
			$arr[$rs[siteid]]['numnorecive_idfalse'] = $rs[numnorecive_idfalse];	
			$arr[$rs[siteid]]['NumQL'] = $rs[NumQL];	
		}//end while($rs = mysql_fetch_assoc($result)){
		 
		return $arr;
	}//end function show_val_exsum($get_lv="",$get_type){


		### �ѧ�����ʴ���� exsum
	function CountSacnExsum($get_siteid=""){
		global $dbname_temp,$profile_id;
			if($profile_id == ""){
					$profile_id = LastProfile();
			}
		
		if($get_siteid != ""){
				$conw = " AND siteid='$get_siteid' GROUP BY schoolid";
		}else{
				$conw = " GROUP BY siteid";	
		}
		


		$sql = "SELECT 
		Count(idcard) AS NumAll,
		Sum(if(status_numfile='1',1,0)) AS NumR,
		Sum(if(status_numfile='1',page_num,0)) AS NumRPage,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and  status_id_false='0',1,0)) AS NumTrue,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0',page_num,0)) AS NumTruePage,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' and page_upload >0,1,0)) AS NumScan,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and  status_id_false='0' and page_upload >0,page_upload,0)) AS NumScanPage,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') 
and status_id_false='0' and (page_upload=0   or page_upload IS NULL or page_upload='' ),1,0)) AS NumDisScan,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') 
and  status_id_false='0' and (page_upload=0   or page_upload IS NULL or page_upload=''),page_num,0)) AS NumDisScanPage,
		siteid,
		schoolid
    	FROM tbl_checklist_kp7  WHERE profile_id='$profile_id' $conw";	
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if($get_siteid != ""){
				$arr[$rs[schoolid]]['NumAll']	 = $rs[NumAll]; // �ӹǹ�ؤ�ҡ÷�����
				$arr[$rs[schoolid]]['NumR']	 = $rs[NumR]; // �ӹǹ�͡��÷�����Ѻ
				$arr[$rs[schoolid]]['NumRPage']	 = $rs[NumRPage]; //  �ӹǹ�蹢ͧ�͡��÷�����Ѻ
				$arr[$rs[schoolid]]['NumTrue']	 = $rs[NumTrue];// �ӹǹ�͡��÷������ó�
				$arr[$rs[schoolid]]['NumTruePage']	 = $rs[NumTruePage]; // �ӹǹ���͡��÷��ʶҹ�������ó�
				$arr[$rs[schoolid]]['NumScan']	 = $rs[NumScan];//  �ӹǹ�͡��÷������ó�����᡹
				$arr[$rs[schoolid]]['NumScanPage']	 = $rs[NumScanPage]; //  �ӹǹ���͡��÷���᡹
				$arr[$rs[schoolid]]['NumDisScan']	 = $rs[NumDisScan];// �ӹǹ�͡����ó����ҧ�᡹
				$arr[$rs[schoolid]]['NumDisScanPage']	 = $rs[NumDisScanPage];// �ӹǹ���͡��÷���ҧ�᡹
			}else{
				$arr[$rs[siteid]]['NumAll']	 = $rs[NumAll]; // �ӹǹ�ؤ�ҡ÷�����
				$arr[$rs[siteid]]['NumR']	 = $rs[NumR]; // �ӹǹ�͡��÷�����Ѻ
				$arr[$rs[siteid]]['NumRPage']	 = $rs[NumRPage]; //  �ӹǹ�蹢ͧ�͡��÷�����Ѻ
				$arr[$rs[siteid]]['NumTrue']	 = $rs[NumTrue];// �ӹǹ�͡��÷������ó�
				$arr[$rs[siteid]]['NumTruePage']	 = $rs[NumTruePage]; // �ӹǹ���͡��÷��ʶҹ�������ó�
				$arr[$rs[siteid]]['NumScan']	 = $rs[NumScan];//  �ӹǹ�͡��÷������ó�����᡹
				$arr[$rs[siteid]]['NumScanPage']	 = $rs[NumScanPage]; //  �ӹǹ���͡��÷���᡹
				$arr[$rs[siteid]]['NumDisScan']	 = $rs[NumDisScan];// �ӹǹ�͡����ó����ҧ�᡹
				$arr[$rs[siteid]]['NumDisScanPage']	 = $rs[NumDisScanPage];// �ӹǹ���͡��÷���ҧ�᡹

			}
		}

		return $arr;
	}//end  function CountSacnExsum($get_lv="",$get_siteid="",$get_school="",$profile_id=""){
	#########################  function �Ѻ�ӹǹ����ʡ��͡��÷���������ó�
	
function CountExsumScanDocFalse($get_siteid=""){
		global $dbname_temp;
			if($profile_id == ""){
					$profile_id = LastProfile();
			}
			
		if($get_siteid != ""){
				$conw = " AND siteid='$get_siteid' GROUP BY schoolid";
		}else{
				$conw = " GROUP BY siteid";	
		}



		$sql = "SELECT 
		Count(idcard) AS NumAll,
		sum(if(status_numfile='1',1,0)) as NumQL,
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as NumTrue, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',1,0 )) as NumFalse, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' and flag_uploadfalse='1',1,0 )) as NumFalseUpload, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and flag_uploadfalse='1',1,0 )) as NumNoMainUpload, 
		sum(if(status_id_false='1' and status_numfile='1',1,0)) as NumIdFalse,
		sum(if(status_id_false='1' and status_numfile='1' and flag_uploadfalse='1',1,0)) as NumIdFalseUpload	,
		siteid,
		schoolid
    	FROM tbl_checklist_kp7   WHERE profile_id='$profile_id' $conw";	
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);

		while($rs = mysql_fetch_assoc($result)){
			if($get_siteid != ""){
				$arr[$rs[schoolid]]['NumAll']	 = $rs[NumAll]; // �ӹǹ�ؤ�ҡ÷�����
				$arr[$rs[schoolid]]['NumQL']	 = $rs[NumQL]; // �ӹǹ�͡��÷�����Ѻ
				$arr[$rs[schoolid]]['NumTrue']	 = $rs[NumTrue]; //  �͡��÷������ó�
				$arr[$rs[schoolid]]['NumFalse']	 = $rs[NumFalse];// �ӹǹ�͡��÷���������ó�
				$arr[$rs[schoolid]]['NumFalseUpload']	 = $rs[NumFalseUpload]; // �ӹǹ�͡��÷���������ó��� upload �
				$arr[$rs[schoolid]]['NumNoMain']	 = $rs[NumNoMain];//  �ӹǹ�͡��÷������ջ�
				$arr[$rs[schoolid]]['NumNoMainUpload']	 = $rs[NumNoMainUpload]; //  �ӹǹ�͡��÷������ջ����upload �����
				$arr[$rs[schoolid]]['NumIdFalse']	 = $rs[NumIdFalse];// �ӹǹ�Ţ�ѵ÷���������ó�
				$arr[$rs[schoolid]]['NumIdFalseUpload']	 = $rs[NumIdFalseUpload];// �ӹǹ�Ţ�ѵ÷���������ó���� upload �����

			}else{
				$arr[$rs[siteid]]['NumAll']	 = $rs[NumAll]; // �ӹǹ�ؤ�ҡ÷�����
				$arr[$rs[siteid]]['NumQL']	 = $rs[NumQL];// �ӹǹ�͡��÷�����Ѻ
				$arr[$rs[siteid]]['NumTrue']	 = $rs[NumTrue];//  �͡��÷������ó�
				$arr[$rs[siteid]]['NumFalse']	 = $rs[NumFalse];// �ӹǹ�͡��÷���������ó�
				$arr[$rs[siteid]]['NumFalseUpload']	 = $rs[NumFalseUpload]; // �ӹǹ�͡��÷���������ó��� upload �
				$arr[$rs[siteid]]['NumNoMain']	 = $rs[NumNoMain];//  �ӹǹ�͡��÷������ջ�
				$arr[$rs[siteid]]['NumNoMainUpload']	 = $rs[NumNoMainUpload]; //  �ӹǹ�͡��÷������ջ����upload �����
				$arr[$rs[siteid]]['NumIdFalse']	 = $rs[NumIdFalse];// �ӹǹ�Ţ�ѵ÷���������ó�
				$arr[$rs[siteid]]['NumIdFalseUpload']	 = $rs[NumIdFalseUpload];// �ӹǹ�Ţ�ѵ÷���������ó���� upload �����

			}//end 	if($get_siteid != ""){
				
		}//end while($rs = mysql_fetch_assoc($result)){
		
		return $arr;
	}//end function show_val_exsum($get_lv="",$get_type){
		
########################### end �Ѻ�͡����᡹������������ó� ##################

	
	#########  function �Ҥ���Ǩ�͡���
	function search_person_check_kp7($get_idcard){
		global $dbcallcenter_entry,$dbtemp_check;
		$sql_log = "SELECT * FROM tbl_checklist_log WHERE idcard='$get_idcard' AND type_action='1' group by user_update ORDER BY time_update DESC ";
		$result_log = mysql_db_query($dbtemp_check,$sql_log);
		while($rs = mysql_fetch_assoc($result_log)){
			$sql_staff = "SELECT * FROM keystaff  WHERE staffid='$rs[user_update]'";
			$result_staff = mysql_db_query($dbcallcenter_entry,$sql_staff);
			$rs1 = mysql_fetch_assoc($result_staff);
			$arr['user'] = "$rs1[prename]$rs1[staffname]  $rs1[staffsurname]";
			$arr['time'] = get_dateThai($rs[time_update]);
		}
		return $arr;
	}//end function search_person_check_kp7(){

	########### fucntion �ʴ�ʶҹо�ѡ�ҹ
	function show_type_staff($get_type){
		if($get_type == "1"){
			return "��ѡ�ҹ sapphire";
		}else if($get_type == "0"){
			return "�١��ҧ���Ǥ���";
		}else if($get_type =="2"){
			return "Subcontract";
		}
	}//end function show_type_staff(){
	
	function count_check_kp7($get_staff,$get_date){
		global $dbtemp_check;
		$sql_count = "SELECT COUNT(tbl_checklist_log.idcard) as num FROM tbl_checklist_log WHERE user_update='$get_staff' AND date(time_update) like '$get_date' AND edubkk_checklist.tbl_checklist_log.type_action='1' GROUP BY tbl_checklist_log.idcard ";
		$result_count = mysql_db_query($dbtemp_check,$sql_count);
		$numc = @mysql_num_rows($result_count);
		//$rs_c = mysql_fetch_assoc($result_count);
		return $numc;
	} //end 	function count_check_kp7($get_staff,$get_date){
	
	##  function �Ѻ�ӹǹ����Ǩ�͡�����ͧ���Ф�
	function CountPersonCheck($get_staffid){
		global $dbtemp_check;
		$sql_count = "SELECT COUNT(tbl_checklist_log.idcard) as numC FROM tbl_checklist_log WHERE user_update='$get_staffid' AND edubkk_checklist.tbl_checklist_log.type_action='1' GROUP BY tbl_checklist_log.idcard";
		$result_count = mysql_db_query($dbtemp_check,$sql_count);
		$numC = @mysql_num_rows($result_count);
		return $numC;
	}
	
	###  funciton �Ѻ�ӹǹ����µ���ѹ����Ǩ�ͺ�͡�����
	function CountCheckAvg($get_staffid){
		global $dbtemp_check;
		$numall = CountPersonCheck($get_staffid);// �ӹǹ������������Ǩ�ͺ�͡�����
		$sql1 = "SELECT 
count(date(time_update)) as num1
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1' and edubkk_checklist.tbl_checklist_log.user_update='$get_staffid' GROUP BY date(time_update) ";
		$result1 = mysql_db_query($dbtemp_check,$sql1);
		//$rs1 = mysql_fetch_assoc($result1);
		$numr1 = @mysql_num_rows($result1);
		if($numall > 0 ){
			$result_num = number_format($numall/$numr1);
		}else{
			$result_num = "0";
		}
	return $result_num;
	}
	###  ��Ǩ�ͺ��������ó����
function checkretireDate($date,$add=0){ 
    $d  = explode("-",$date);
    $year    = $d[0]+$add;
    $month    = $d[1];
    $date    = $d[2];
    if($month == 1 || $month == 2 || $month == 3){        
        $retire_year    = ($year < 2484) ? $year + 61 : $year + 60 ;        
    } else if($month == 10 || $month == 11 || $month == 12){        
        $retire_year     = ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;        
    } else {
        $retire_year     = $year + 60;
    }        
   
    $year_now=(date('Y')+543);         

     if($retire_year<=$year_now){
         return "0"; 
     }else{
         return "1";
     } 
}// end function checkretireDate($date,$add=0){ 

############  sql 
function ChRetireDate($date){
	$year_now=(date('Y')+543);   
	$yynow = "$year_now-09-30";
	if($date != "" and $date != "0000-00-00"){
		$sql = "select FLOOR(TIMESTAMPDIFF(MONTH,'$date','$yynow')/12) as agv_gov";	
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[agv_gov] > 60){			
			return "0";
		}else{
			return "1";	
		}
	}
}


function retireDate($date){

	$d			= explode("-",$date);
	$year	= $d[0];
	$month	= $d[1];
	$date	= $d[2];
	
	
		
	if($month == 1 || $month == 2 || $month == 3){		
		$retire_year	= ($year < 2484) ? $year + 61 : $year + 60 ;		
	} else if($month == 10 || $month == 11 || $month == 12){		
		$retire_year 	= ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;		
	} else {
		$retire_year 	= $year + 60;
	}		

	return "30 �ѹ��¹ �.�. ".$retire_year;
}
#############  �ʴ���Ǵ��¡�õ�Ǩ�ͺ
function GetTypeMenu($get_menu){
	global $dbtemp_check;
	$sql_menu = "SELECT * FROM tbl_check_menu WHERE menu_id='$get_menu'";
	//echo $sql_menu;
	$result_menu = mysql_db_query($dbtemp_check,$sql_menu);
	$rs_menu = mysql_fetch_assoc($result_menu);
	return $rs_menu[menu_detail];
}
##### �ʴ���Ǵ�ͧ�ѭ��
function GetTypeProblem($get_problem){
global $dbtemp_check;
	$sql_p = "SELECT * FROM tbl_problem WHERE problem_id='$get_problem'";
	$result_p = mysql_db_query($dbtemp_check,$sql_p);
	$rs_p = mysql_fetch_assoc($result_p);
	return $rs_p[problem];
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

function upload($path, $file, $file_name, $type,$idcard="",$date_file=""){
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

	$chk_doc = ($file_ext != "pdf") ? "n" : "y" ;
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
	//$file_n		= chk_file($file_name, $path);
	if($date_file != ""){
		$file_n		= $idcard."_".$date_file.".".$file_ext;
	}else{
		$file_n		= $idcard.".".$file_ext;	
	}

	
	//echo $file_n;die;
	$filename	= $path.$file_n;
} elseif($type == "img" || $type == "fla" || $type == "all") {
	if($date_file != ""){
		$file_n		= $idcard."_".$date_file.".".$file_ext; // gen ����������Ţ�ѵû�ЪҪ�	
	}else{
		$file_n		= $idcard.".".$file_ext; // gen ����������Ţ�ѵû�ЪҪ�
	}
	$filename 	= $path.$file_n;	
}
$status[1] = $file_n;

/* ---------------------------------------------------------Begin Uploading File */
if($approve == "y"){

	if($file_size >= "80000000") {
		$status[0] = "error_size";		
	} else {	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){	 
				$status[0] = "error_upload";
			} else {
				$status[0] = "complete";
				
				chmod("$filename",0777);
				//echo $filename;die;
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
		$msg = "<br><b class=\"warn\">Error</b> : ��Ҵ�ͧ�Ҿ�Թ�ҡ����˹����<br>��Ҵ�ٻ�Ҿ��ͧ����Թ $height x $width<br>";		
	} elseif($temp == "error_img") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>�ٻẺ�ͧ file ���١��ͧ<br>�ٻ�Ҿ��ͧ�չ��ʡ���� jpg, jpeg ��� gif ��ҹ��<br>";		
	} elseif($temp == "error_type") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>�ٻẺ�ͧ file ������������١��ͧ<br>";		
	} elseif($temp == "error_size") 	{	
		$msg = "<br><b class=warn>Error</b><br>�ٻ��Ҵ�ͧ file �ҡ���ҷ���к���˹�<br>����ͧ�բ�Ҵ����Թ 800 Kilo Bytes<br>";
	} elseif($temp == "error_upload") {	
		$msg = "<br><b class=\"warn\">Warning</b><br>����ͼԴ��Ҵ㹡�� Upload ��������к�<br>�ô�Դ��ͼ�����<br>";			
	} elseif($temp == "error_cmod")	{	
		$msg = "<br><b class=\"warn\">Warning</b><br>����ͼԴ��Ҵ㹡�� Upload ��������к�<br>�ô��Ǩ�ͺ CHMOD �ͧ Folder<br>";				
	} elseif($temp == "error_doc"){	
		$msg = "<br><b class=\"warn\">Warning</b><br>�ٻẺ������١��ͧ<br>�͡��õ�ͧ�չ��ʡ���� doc, xls ��� pdf ��ҹ��<br>";			
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

// function ������ʴ���������´��ҧ � �ͧ files ���зӡ�� upload
function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

## function �Ѻ�ӹǹ �͡��� �.�.7 #################   credit  by ������ #################################3
function count_page($idcard,$siteid) {
		
		$file = "../../../checklist_kp7file/$siteid/$idcard.pdf";
		//echo "<a href='$file'>$file</a>";die;
        if(file_exists($file)) { 

            //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
                    } 
                    else { 
                          $contents = fread($handle, 1000); 
                        //In some pdf files, there is an N tag containing the number of 
                        //of pages. This doesn't seem to be a result of the PDF version. 
                        //Saves reading the whole file. 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
                            return $found[1]; 
                        } 
                    } 
                    $i++; 
                } 
                fclose($handle); 
  
  	//echo "numpage ";die;
                //get all the trees with 'pages' and 'count'. the biggest number 
                //is the total number of pages, if we couldn't find the /N switch above.                 
                if(preg_match_all("/\/Type\s*\/Pages\s*.*\s*\/Count\s+([0-9]+)/", $contents, $capture, PREG_SET_ORDER)) { 
//				echo "<pre>aaa<br>";
//				print_r($capture);
//				die;
                    foreach($capture as $c) { 
                        if($c[1] > $count) 
                            $count = $c[1]; 
                    } 
                    return $count;             
                } 
            } 
        } 
        return 0; 
}

###  end function  �Ѻ�ӹǹ˹��

require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');
### function �Ѻ�ӹǹ˹�� pdf by ������
function CountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}
### end function CountPageSystem($pathfile){
	
function RmkDirPath($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	
	
function RecursiveFolderDelete ( $folderPath ){
	if ( is_dir ( $folderPath ) ){
			foreach ( scandir ( $folderPath )  as $value ){
					if ( $value != "." && $value != ".." ){
							$value = $folderPath . "/" . $value;
							if ( is_dir ( $value ) ){
								FolderDelete ( $value );
							}elseif ( is_file ( $value ) ){
								@unlink ( $value );
							}
					}
			}
				return rmdir ( $folderPath );
			}else{
		return FALSE;
	}
}// end function RecursiveFolderDelete ( $folderPath ){


	

## funciton copyfile �ҡ checklist_kp7file ������ kp7file
function CopyKp7File($get_idcard,$path_s,$path_d){
	if(!is_dir($path_d)){
		RmkDirPath($path_d);
	}
	$file_source = $path_s.$get_idcard.".pdf";
	$file_dest = $path_d.$get_idcard.".pdf";
	if(copy($file_source,$file_dest)){
		chmod("$file_dest",0777);
		$copy_status = "1";	
	}else{
		$copy_status = "0";	
	}
	return $copy_status;
}//end function CopyKp7File($get_idcard,$path_s,$path_d){
	
### ��Ǩ�ͺ fied ���й����
function CheckField($secid,$xfield){
		$sql_check = "SELECT COUNT(secid) AS  num_field  FROM tbl_status_field_import WHERE secid='$secid'  AND $xfield='1'";
		$result_check =mysql_db_query(DB_CHECKLIST,$sql_check);
		$rs_ch = mysql_fetch_assoc($result_check);
		return $rs_ch[num_field];
}//end 	function check_field($xfield){

## funciton �� ���ʤӹ�˹�Ҫ���
function GetPrenameId($get_prename){
	global $dbnamemaster;
	$sql = "SELECT sex,gender,PN_CODE FROM prename_th WHERE prename='$get_prename' or prename_th='$get_prename'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$arrG['sex'] = $rs[sex];
	$arrG['gender'] = $rs[gender];
	$arrG['PN_CODE'] = $rs[PN_CODE];
	return $arrG;
}//end function GetPrenameId(){
## end funnction �� ���ʤӹ�˹�Ҫ���
###  function �����ʵ��˹�
function GetPositionId($get_position){
	global $dbnamemaster;		
	$sql = " SELECT * FROM hr_addposition_now WHERE position='$get_position'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$arrP['pid'] = $rs[pid];
	$arrP['Gpid'] = substr($rs[pid],0,1);
	return $arrP;
}
### end function �����ʵ��˹�
###  function ��Ǩ�ͺ��Ң������ࢵ�����������������
function CheckDataInDb($get_siteid,$get_idcard){
	$db_site = "edubkk_$get_siteid";
	$sql = "SELECT COUNT(id) AS num FROM general WHERE id='$get_idcard'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
}//end function CheckDataInDb($get_siteid,$get_idcard)

#############  function 㹡�õ�Ǩ�ͺ������ç��ûշ������
function CheckDataOldYear($get_idcard,$profile_id=""){
	global $dbname_temp,$config_yy;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	//$tblyy = substr((date("Y")+543),-2);
	//$tbl = "tbl_check_data".$config_yy;
	$sql = "SELECT count(idcard) as num1 FROM tbl_check_data WHERE idcard='$get_idcard' AND profile_id <> '$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckDataOldYear($get_idcard){

## �ѧ����㹡�õ�Ǩ�ͺ���� tbl_check_data �������������
function CheckDataTable($get_idcard,$profile_id=""){
	global $dbname_temp;
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	$sql = "SELECT COUNT(idcard) AS NUM1 FROM tbl_check_data WHERE idcard='$get_idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
	
}//end function CheckDataTable(){
	
###  �ѧ���蹵�Ǩ�ͺࢵ�鹷ҧ�������¢������ҡó�����ࢵ���
function CheckDataListOld($getsiteid,$get_idcard){
	$db_site = "edubkk_$getsiteid";
	$sql = "SELECT COUNT(id) AS numList FROM general WHERE id='$get_idcard'";
	$result= mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numList];
	
}//end function CheckDataListOld(){
	
###  �ѧ���蹵�Ǩ�ͺ ��ù���Ң�����
function CheckImportData($get_siteid,$profile_id=""){
	$db_site = "edubkk_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	$sql = "SELECT
Count(edubkk_checklist.tbl_check_data.idcard) AS NumAll,
sum(if(edubkk_checklist.tbl_check_data.status_id_replace= '1' and edubkk_checklist.tbl_check_data.status_tranfer_data='1',1,0)) as TranferIn,
sum(if(edubkk_checklist.tbl_check_data.status_id_replace = '0' and edubkk_checklist.tbl_check_data.status_tranfer_data='1',1,0)) as InSite,
sum(if(edubkk_checklist.tbl_check_data.status_tranfer_data='0',1,0)) as imp_err,
sum(if(edubkk_checklist.tbl_check_data.status_tranfer_data='2',1,0)) as num_retire
FROM
edubkk_checklist.tbl_check_data
Left Join $db_site.general ON edubkk_checklist.tbl_check_data.idcard = $db_site.general.idcard
WHERE edubkk_checklist.tbl_check_data.secid='$get_siteid' and edubkk_checklist.tbl_check_data.profile_id='$profile_id'";
//echo $sql;
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['NumAll'] = $rs[NumAll];
	$arr['TranferIn'] = $rs[TranferIn];
	$arr['InSite'] = $rs[InSite];
	$arr['imp_err'] = $rs[imp_err];
	$arr['retire'] = $rs[num_retire];
	return $arr;
		
}//end function CheckImportData($get_siteid){
	
## �ѧ���� ��Ǩ�ͺ��͹ ����Ң�����
function CheckBeforImport($profile_id=""){
	global $dbname_temp;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	//$sql = "SELECT count(schoolid) as num_school FROM tbl_checklist_kp7 WHERE  (siteid = '$xsiteid') and (schoolid='0' or schoolid IS NULL or schoolid ='') and profile_id='$profile_id'";
	$sql = "SELECT count(schoolid) as num_school,siteid  FROM tbl_checklist_kp7 WHERE (schoolid='0' or schoolid IS NULL or schoolid ='') and profile_id='$profile_id' group by siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = 1;
	}
	
	return $arr;
}//end function CheckBeforImport($get_siteid){
	
### �ѧ���蹹Ѻ�ӹǹ�ٻ�������к���ԧ<br />
function CountPicSys($get_siteid,$get_schoolid="",$get_idcard="",$profile_id){
	$db_site = "edubkk_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	
	if($get_schoolid != ""){
		$conv = " AND  edubkk_checklist.tbl_checklist_kp7.schoolid ='$get_schoolid' ";
	}
	if($get_idcard != ""){
		$conp = " AND  edubkk_checklist.tbl_checklist_kp7.idcard='$get_idcard' ";
	}
	
	
	$sql = "SELECT
Count($db_site.general_pic.id) AS num1
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join $db_site.general_pic ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general_pic.id
and $db_site.general_pic.imgname <> '' and $db_site.general_pic.imgname IS NOT NULL
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$get_siteid'  AND edubkk_checklist.tbl_checklist_kp7.profile_id='$profile_id' $conv  $conp";
$result = mysql_db_query($db_site,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
		
}// end function CountPicSys($get_siteid,$get_schoolid=""){
	
	
	
	
function CountPicSysV1($get_siteid,$get_schoolid="",$get_idcard="",$profile_id){
	$db_site = "edubkk_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	
	if($get_schoolid != ""){
		$conv = " AND  edubkk_checklist.tbl_checklist_kp7.schoolid ='$get_schoolid'";
	}
	if($get_idcard != ""){
		$conp = " AND  edubkk_checklist.tbl_checklist_kp7.idcard='$get_idcard' ";
	}
	
	
	$sql = "SELECT
Count($db_site.general_pic.id) AS num1,
$db_site.general_pic.id
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join $db_site.general_pic ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general_pic.id
and $db_site.general_pic.imgname <> '' and $db_site.general_pic.imgname IS NOT NULL
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$get_siteid' AND profile_id='$profile_id'  $conv  $conp
group by $db_site.general_pic.id 
";
$result = mysql_db_query($db_site,$sql);
while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[id]] = $rs[num1];	
}
return $arr;
		
}// end function CountPicSys($get_siteid,$get_schoolid=""){
	
	
	
	function GetCountPicSys($get_siteid,$get_schoolid="",$get_idcard="",$profile_id){
	$db_site = "edubkk_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	
	if($get_schoolid != ""){
		$conv = " AND  edubkk_checklist.tbl_checklist_kp7.schoolid ='$get_schoolid' ";
	}
	if($get_idcard != ""){
		$conp = " AND  edubkk_checklist.tbl_checklist_kp7.idcard='$get_idcard' ";
	}
	
	
	$sql = "SELECT
Count($db_site.general_pic.id) AS num1
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join $db_site.general_pic ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general_pic.id
and $db_site.general_pic.imgname <> '' and $db_site.general_pic.imgname IS NOT NULL
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$get_siteid'  AND edubkk_checklist.tbl_checklist_kp7.profile_id='$profile_id' AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' $conv  $conp";
$result = mysql_db_query($db_site,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
		
}// end function CountPicSys($get_siteid,$get_schoolid=""){
## end �ѧ���� ��Ǩ�ͺ��͹ ����Ң�����

### function �Ѻ�ӹǹ��¡�úؤŷ��ӡ�õѴ�ҡࢵ������������㹶ѧ��ҧ���ͧ�ҡ�Ҩ���ա�������ࢵ������͢������Ţ�ѵ������㹰ҹ������ Checklikst ���й����Ң�����
	function CountDataCenter($get_siteid){
		global $dbnamemaster;
		$sql_c = "SELECT COUNT(idcard) as num_id FROM temp_general WHERE siteid='$get_siteid'" ;
		$result_c = mysql_db_query($dbnamemaster,$sql_c);
		$rs_c = mysql_fetch_assoc($result_c);
		return $rs_c[num_id];
	}///end function CountDataCenter($get_siteid){
		
####  funciton �ʴ�����������ش
function LastProfile(){
	global $dbname_temp;
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = @mysql_db_query($dbname_temp,$sql_profile);
		$rspro = @mysql_fetch_assoc($result_profile);
		$profile_id = $rspro[profile_id];
		return $profile_id;

}//end function LastProfile(){
	
###  �ʴ�����������
function ShowProfile_name($profile_id){
	global $dbname_temp;
	$sqlp = "SELECT profilename FROM tbl_checklist_profile WHERE profile_id='$profile_id'";
	$resultp = mysql_db_query($dbname_temp,$sqlp);
	$rsp = mysql_fetch_assoc($resultp);
	return $rsp[profilename];
}
######################################  ������������ش
if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������

##########   function �红�����˹��§ҹ������㹡�÷Ӻѭ�դ��
	function SaveTempOrderSchool($get_schoolid,$get_siteid,$get_order){
		global $dbname_temp;
		$sql = "REPLACE INTO temp_order_school SET schoolid='$get_schoolid', siteid='$get_siteid', orderby='$get_order'";
		$result = mysql_db_query($dbname_temp,$sql);
	}//end 	function SaveTempOrderSchool(){
		
			### function ��Ǩ�ͺ field owner _sys ������������
	function AlterField($get_dbsite,$get_tblname,$get_field){
			$sql = "SHOW FIELDS FROM $get_tblname WHERE Field='$get_field'";
			$result = mysql_db_query($get_dbsite,$sql);
			$numF = @mysql_num_rows($result);
			if($numF < 1){
				$sql_alter = "ALTER TABLE $get_tblname  ADD ( $get_field varchar(20) )";
				@mysql_db_query($get_dbsite,$sql_alter);	
			}//end if($numF < 1){
	}//end function AlterField(){

	function AddLogPicToCmss($get_idcard,$get_no,$get_siteid){
			global $dbname_temp;
			$ip_import = get_real_ip();
			$sql_log = "INSERT INTO log_importpic_to_cmss(idcard,no,siteid,import_staffid,ip_import)VALUES('$get_idcard','$get_no','$get_siteid','".$_SESSION[session_staffid]."','$ip_import')";
			mysql_db_query($dbname_temp,$sql_log);
	}//end function AddLogPicToCmss(){
		
	###  function 㹡�ùӢ������ٻ�ҡ����� checklist ������ cmss  ���ҧ upload_general_pic
	function ImportPicToCmss($get_siteid,$get_idcard){
		global $dbname_temp;
		$path_sorece = "../../../temp_image_kp7/$get_siteid/";
		$path_dest = "../../../image_file/$get_siteid/";
		$db_site = "edubkk_$get_siteid";
		$sql = "SELECT * FROM upload_general_pic WHERE id='$get_idcard' AND site='$get_siteid' AND approve_status='uncomplete' AND edubkk_entry='no'";
		$result = mysql_db_query($dbname_temp,$sql);
		$num_r = @mysql_num_rows($result);
		if($num_r > 0){ // ��Ǩ�ͺ ��ճ�բ������ temp 	��͹�ӡ��ź
			### �ӡ��ź�������ٻ��͹�ӡ�ù����Ң�����
			$sql_del = "DELETE FROM general_pic WHERE id='$get_idcard'";
			mysql_db_query($db_site,$sql_del);
			###  end �ӡ��ź�������ٻ��͹�ӡ�ù����Ң�����
		}// end if($num_r > 0){
		while($rs = mysql_fetch_assoc($result)){
			if($rs[imgname] != ""){
					$file_sorece = $path_sorece.$rs[imgname];
					$file_dest = $path_dest.$rs[imgname];
					###  �Ѵ�ͧ���
					if(copy($file_sorece,$file_dest)){
						@chmod("$file_dest",0777);
						$sql_insert = "INSERT INOT general_pic SET id='$rs[id]', no='$rs[no]', imgname='$rs[imgname]',  yy='$rs[yy]', img_owner='$rs[img_owner]' ";
						@mysql_db_query($db_site,$sql_insert);
						// update ʶҹС�� upload
						$sql_update = "UPDATE upload_general_pic SET edubkk_entry='yes'  WHERE id='$rs[id]' AND no='$rs[no]'";
						@mysql_db_query($db_site,$sql_update);
						AddLogPicToCmss($rs[id],$rs[no],$get_siteid);// ���� log ��ù���Ң����ż�ҹ�к� checklist
					}//end if(copy($file_sorece,$file_dest)){
			}//end if($rs[imgname] != ""){
		}//end 	while($rs = mysql_fetch_assoc($result)){	
	}//end function ImportPicToCmss($get_siteid,$get_idcard){


	function CheckMonitorKey($get_idcard){
		global $dbcallcenter_entry;
		$sql = "SELECT count(idcard) as numid  FROM monitor_keyin where idcard='$get_idcard' group by idcard";
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
	}//end function CheckMonitorKey($get_idcard){
		
		##  function �ʴ�˹��§ҹ � pobec
function ShowOrgInPobec($get_site,$get_idcard){
		global $db_temp_pobec;
		$tbl_pobec = "pobec_".$get_site;
		$tbl_school = "school_".$get_site;
		$sql_pobec = "SELECT
$tbl_school.S_NAME,$tbl_school.T_NAME,$tbl_school.H_NAME
FROM
$tbl_pobec
Inner Join $tbl_school ON $tbl_pobec.I_CODE = $tbl_school.I_CODE
WHERE
$tbl_pobec.IDCODE =  '$get_idcard'";
//echo $db_temp_pobec.":: ".$sql_pobec;
$result_pobec = @mysql_db_query($db_temp_pobec,$sql_pobec);
$rs_pobec  = @mysql_fetch_assoc($result_pobec);
	### �����ç���¹
	if($rs_pobec[S_NAME] != ""){
			$schoolname = $rs_pobec[S_NAME];
	}else{
			$schoolname = "";	
	}// end if($rs_pobec[S_NAME] != ""){
	### ˹��§ҹ �Ӻ�
	if($rs_pobec[T_NAME] != ""){
		$tambon = "( �Ӻ�".$rs_pobec[T_NAME]." )";	
	}else{
		$tambon = "";	
	}// end if($rs_pobec[T_NAME] != ""){
	#####  ��������˹��§ҹʶҹ�֡��
	if($rs_pobec[H_NAME] != ""){
			$hname = "( �������� :".$rs_pobec[H_NAME].")";
	}else{
			$hname = "";
	}//end if($rs_pobec[H_NAME] != ""){
		
	
		
return $schoolname.$tambon.$hname;
}//end function ShowOrgInPobec(){
	
		$dbname_temp = DB_CHECKLIST;
	
	$month = array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
function ShowDateProfile($get_profile){
	global $dbname_temp,$month;
	$sql = "SELECT * FROM tbl_checklist_profile WHERE profile_id='$get_profile'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[profile_date] != "" and $rs[profile_date] != "0000-00-00"){
			$arr = explode("-",$rs[profile_date]);
			return "(������ � �ѹ��� ".intval($arr[2])." ".$month[intval($arr[1])]." ".($arr[0]+543).")";
		}else{
			return $rs[profilename];	
		}

		
}//end function ShowDateProfile(){
	
	
/*function CountProblem($siteid,$profile_id,$schoolid,$xlv=""){
	global $dbname_temp;
	
	if($schoolid != ""){
			$conv = " AND schoolid='$schoolid'";
	}else{
			$conv = "";	
	}//end if($schoolid == ""){
		if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}
	
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
CAST(tbl_checklist_kp7.schoolid as SIGNED) as orderschoolid,
Sum(if(tbl_checklist_problem_detail.menu_id='1',1,0)) AS p1,
Sum(if(tbl_checklist_problem_detail.menu_id='2',1,0)) AS p2,
Sum(if(tbl_checklist_problem_detail.menu_id='3',1,0)) AS p3,
Sum(if(tbl_checklist_problem_detail.menu_id='4',1,0)) AS p4,
Sum(if(tbl_checklist_problem_detail.menu_id='5',1,0)) AS p5,
Sum(if(tbl_checklist_problem_detail.menu_id='6',1,0)) AS p6,
Sum(if(tbl_checklist_problem_detail.menu_id='7',1,0)) AS p7,
Sum(if(tbl_checklist_problem_detail.menu_id='8',1,0)) AS p8,
Sum(if(tbl_checklist_problem_detail.menu_id='9',1,0)) AS p9,
Sum(if(tbl_checklist_problem_detail.menu_id='10',1,0)) AS p10,
Sum(if(tbl_checklist_problem_detail.menu_id='11',1,0)) AS p11,
Sum(if(tbl_checklist_problem_detail.menu_id='12',1,0)) AS p12,
Sum(if(tbl_checklist_problem_detail.menu_id='13',1,0)) AS p13,
if(tbl_checklist_kp7.mainpage='0',1,0) AS nopage,
tbl_checklist_kp7.type_doc,
tbl_checklist_kp7.page_num


FROM
tbl_checklist_kp7
LEFT Join  tbl_checklist_problem_detail ON tbl_checklist_kp7.idcard = tbl_checklist_problem_detail.idcard
where tbl_checklist_kp7.profile_id='$profile_id' and siteid='$siteid'
 $conx $conv 

GROUP BY  tbl_checklist_kp7.idcard 
ORDER  BY orderschoolid ASC
";
//echo $sql;die;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[schoolid] != $rs[siteid]){ $pre_org = "�ç���¹";}else{ $pre_org = "";}
		//$arr[$rs[idcard]]['xtitle'] = ShowUserCheck($rs[idcard]);
		$arr[$rs[idcard]]['fullname'] = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
		$arr[$rs[idcard]]['position_now'] = $rs[position_now];
		$arr[$rs[idcard]]['schoolid'] = $pre_org."".show_school($rs[schoolid]);
		$arr[$rs[idcard]]['p1'] = $rs[p1];
		$arr[$rs[idcard]]['p2'] = $rs[p2];
		$arr[$rs[idcard]]['p3'] = $rs[p3];
		$arr[$rs[idcard]]['p4'] = $rs[p4];
		$arr[$rs[idcard]]['p5'] = $rs[p5];
		$arr[$rs[idcard]]['p6'] = $rs[p6];
		$arr[$rs[idcard]]['p7'] = $rs[p7];
		$arr[$rs[idcard]]['p8'] = $rs[p8];
		$arr[$rs[idcard]]['p9'] = $rs[p9];
		$arr[$rs[idcard]]['p10'] = $rs[p10];
		$arr[$rs[idcard]]['p11'] = $rs[p11];
		$arr[$rs[idcard]]['p12'] = $rs[p12];
		$arr[$rs[idcard]]['p13'] = $rs[p13];
		$arr[$rs[idcard]]['nopage'] = $rs[nopage];		
		$arr[$rs[idcard]]['type_doc'] = $rs[type_doc];
		$arr[$rs[idcard]]['page_num'] = $rs[page_num];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountProblem($siteid,$schoolid,$profile_id){
*/	
	
function CountProblemArea($siteid,$profile_id,$schoolid="",$xlv="",$school_type=""){
	global $dbname_temp,$xgen_id;
	
	if($school_type == '0'){
	  $having =  " HAVING school_status = 'pri_school' ";
	}elseif($school_type == '1'){
	  $having =  " HAVING school_status = 'high_school' ";
	}else{
	  $having = "";
	}
	
	
	if($schoolid != ""){
			$conv = " AND tbl_checklist_kp7.schoolid='$schoolid'";
			$conGroup = " GROUP BY  tbl_checklist_kp7.idcard ";
	}else{
			$conv = "";	
			$conGroup = " GROUP BY  tbl_checklist_kp7.schoolid";
	}//end if($schoolid == ""){
		if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}

		if($xgen_id != ""){
				$join_profile = " inner join profile_genfile_allschool on tbl_checklist_kp7.schoolid=profile_genfile_allschool.id";
				$con2 = " and profile_genfile_allschool.gen_id='1'";
		}else{
				$join_profile = "";		
				$con2 = "";
		}

	
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
CAST(tbl_checklist_kp7.schoolid as SIGNED) as orderschoolid,
Sum(if(tbl_checklist_problem_detail.menu_id='1',1,0)) AS p1,
Sum(if(tbl_checklist_problem_detail.menu_id='2',1,0)) AS p2,
Sum(if(tbl_checklist_problem_detail.menu_id='3',1,0)) AS p3,
Sum(if(tbl_checklist_problem_detail.menu_id='4',1,0)) AS p4,
Sum(if(tbl_checklist_problem_detail.menu_id='5',1,0)) AS p5,
Sum(if(tbl_checklist_problem_detail.menu_id='6',1,0)) AS p6,
Sum(if(tbl_checklist_problem_detail.menu_id='7',1,0)) AS p7,
Sum(if(tbl_checklist_problem_detail.menu_id='8',1,0)) AS p8,
Sum(if(tbl_checklist_problem_detail.menu_id='9',1,0)) AS p9,
Sum(if(tbl_checklist_problem_detail.menu_id='10',1,0)) AS p10,
Sum(if(tbl_checklist_problem_detail.menu_id='11',1,0)) AS p11,
Sum(if(tbl_checklist_problem_detail.menu_id='12',1,0)) AS p12,
Sum(if(tbl_checklist_problem_detail.menu_id='13',1,0)) AS p13,
Sum(if(tbl_checklist_kp7.mainpage='0',1,0)) AS nopage,
tbl_checklist_kp7.type_doc,
Sum(tbl_checklist_kp7.page_num) as page_num,
Count(distinct tbl_checklist_kp7.idcard) as numid,
Sum(if(tbl_checklist_kp7.type_doc='1',1,0)) as numtypedoc,
if( (edubkk_master.allschool_math_sd.schid IS NULL OR edubkk_master.allschool_math_sd.schid = '') , 'pri_school' , 'high_school'  ) AS school_status ,
edubkk_master.allschool_math_sd.schid


FROM
tbl_checklist_kp7
$join_profile
LEFT Join  tbl_checklist_problem_detail ON tbl_checklist_kp7.idcard = tbl_checklist_problem_detail.idcard
LEFT JOIN edubkk_master.allschool_math_sd ON tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid
where tbl_checklist_kp7.profile_id='$profile_id' and tbl_checklist_kp7.siteid='$siteid'
 $conx $conv  $con2
$conGroup
$having
ORDER  BY orderschoolid ASC
";
//echo "sql == ".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($schoolid != ""){
				$arr[$rs[idcard]]['fullname'] = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
				$arr[$rs[idcard]]['position_now'] = $rs[position_now];
				$arr[$rs[idcard]]['schoolid'] = show_school($rs[schoolid]);
				$arr[$rs[idcard]]['p1'] = $rs[p1];
				$arr[$rs[idcard]]['p2'] = $rs[p2];
				$arr[$rs[idcard]]['p3'] = $rs[p3];
				$arr[$rs[idcard]]['p4'] = $rs[p4];
				$arr[$rs[idcard]]['p5'] = $rs[p5];
				$arr[$rs[idcard]]['p6'] = $rs[p6];
				$arr[$rs[idcard]]['p7'] = $rs[p7];
				$arr[$rs[idcard]]['p8'] = $rs[p8];
				$arr[$rs[idcard]]['p9'] = $rs[p9];
				$arr[$rs[idcard]]['p10'] = $rs[p10];
				$arr[$rs[idcard]]['p11'] = $rs[p11];
				$arr[$rs[idcard]]['p12'] = $rs[p12];
				$arr[$rs[idcard]]['p13'] = $rs[p13];
				$arr[$rs[idcard]]['nopage'] = $rs[nopage];		
				$arr[$rs[idcard]]['type_doc'] = $rs[type_doc];
				$arr[$rs[idcard]]['page_num'] = $rs[page_num];
				$arr[$rs[idcard]]['numid'] = $rs[numid];
				$arr[$rs[idcard]]['numtypedoc'] = $rs[numtypedoc];
		}else{
				$arr[$rs[schoolid]]['sid'] = $rs[schoolid];
				$arr[$rs[schoolid]]['schoolid'] = $pre_org."".show_school($rs[schoolid]);
				$arr[$rs[schoolid]]['p1'] = $rs[p1];
				$arr[$rs[schoolid]]['p2'] = $rs[p2];
				$arr[$rs[schoolid]]['p3'] = $rs[p3];
				$arr[$rs[schoolid]]['p4'] = $rs[p4];
				$arr[$rs[schoolid]]['p5'] = $rs[p5];
				$arr[$rs[schoolid]]['p6'] = $rs[p6];
				$arr[$rs[schoolid]]['p7'] = $rs[p7];
				$arr[$rs[schoolid]]['p8'] = $rs[p8];
				$arr[$rs[schoolid]]['p9'] = $rs[p9];
				$arr[$rs[schoolid]]['p10'] = $rs[p10];
				$arr[$rs[schoolid]]['p11'] = $rs[p11];
				$arr[$rs[schoolid]]['p12'] = $rs[p12];
				$arr[$rs[schoolid]]['p13'] = $rs[p13];
				$arr[$rs[schoolid]]['nopage'] = $rs[nopage];		
				$arr[$rs[schoolid]]['type_doc'] = $rs[type_doc];
				$arr[$rs[schoolid]]['page_num'] = $rs[page_num];
				$arr[$rs[schoolid]]['numid'] = $rs[numid];
				$arr[$rs[schoolid]]['numtypedoc'] = $rs[numtypedoc];

		}// end if($schoolid != ""){
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountProblem($siteid,$schoolid,$profile_id){	


############  ��ʴ������ӡ�úѹ�֡����������ش
function UserChecklist($siteid,$profile_id,$xlv=""){
	global $dbname_temp;
	
			if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}

	
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_log_last.user_update,
tbl_checklist_log_last.time_update
FROM
tbl_checklist_kp7
Inner Join tbl_checklist_log_last ON tbl_checklist_kp7.idcard = tbl_checklist_log_last.idcard
where 
 tbl_checklist_log_last.profile_id='$profile_id' and tbl_checklist_kp7.profile_id='$profile_id'
and  tbl_checklist_kp7.siteid='$siteid' $conx";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[idcard]] = show_user($rs[user_update])." �ѹ��� ".get_dateThai($rs[time_update]);
			
	}
	return $arr1;
}//end function UserChecklist($siteid,$profile_id,$xlv=""){

function CountProblemSort($siteid,$profile_id,$schoolid,$xlv="",$typep=""){
		global $dbname_temp,$xgen_id;
		
	if($schoolid != ""){
			$conv = " AND schoolid='$schoolid'";
	}else{
			$conv = "";	
	}//end if($schoolid == ""){
		if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}
		
	if($typep != "" and $typep != "99" and $typep != "100"){
			$con_type = " AND  tbl_checklist_problem_detail.problem_id='$typep' ";
	}else{
			$con_type = " ";	
	}

	if($typep == "100"){
		$conx1 = " AND mainpage='0'";
	}else{
		$conx1 = " AND (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0')";	
	}
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE tbl_checklist_kp7.profile_id='$profile_id' and siteid='$siteid'  $conv $conx $conx1";
	//echo $sql;die;
	$result = mysql_db_query($dbname_temp,$sql);
	$ii=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		if($rs[mainpage] == "0"){
			$arrx[$rs[idcard]][$j]['mainpage'] = $rs[mainpage_comment];	
			$j++;
		}
	if($typep != "100"){
$sql1 = "SELECT
tbl_checklist_problem_detail.idcard,
tbl_checklist_problem_detail.problem_id,
tbl_checklist_problem_detail.menu_id,
tbl_checklist_problem_detail.problem_detail,
tbl_checklist_problem_detail.status_problem,
tbl_checklist_problem_detail.profile_id,
tbl_check_menu.menu_detail,
tbl_problem.problem
FROM
tbl_checklist_problem_detail
Inner Join tbl_check_menu ON tbl_checklist_problem_detail.menu_id = tbl_check_menu.menu_id
Inner Join tbl_problem ON tbl_checklist_problem_detail.problem_id = tbl_problem.problem_id
$con_type
where idcard='$rs[idcard]' and profile_id='$profile_id'
order by tbl_check_menu.orderby ASC";
//echo $sql1."<br>";
$result1 = mysql_db_query($dbname_temp,$sql1);
$num1 = @mysql_num_rows($result1);
		if($num1 > 0){
			
			while($rs1 = mysql_fetch_assoc($result1)){
				$arrx[$rs[idcard]][$j]['menu_detail'] = $rs1[menu_detail];
				$arrx[$rs[idcard]][$j]['problem_detail'] = $rs1[problem_detail];
				$j++;
				
			}//end while($rs1 = mysql_fetch_assoc($result1)){
		}//end if($num1 > 0){
		}//end 	if($typep != "100"){
	}//end 	while($rs = mysql_fetch_assoc($result))
	return $arrx;
}//end function CountProblemSort($siteid,$profile_id,$schoolid,$xlv=""){

######################  �Ѻ�ӹǹࢵ��鹷��� profile ���
function CountAreaProfile($profile_id){
	global $dbnamemaster;
	$sql = "SELECT
count(secid) as numsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id'
group by group_type";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numsite];
}//end function CountAreaProfile($profile_id){

function CountSchool($siteid,$profile_id=""){
	global $dbnamemaster;
	if($profile_id == ""){// �ó���������͡���� ������
		$profile_id = LastProfile();
	}//end if($profile_id == ""){// �ó���������͡���� ������

	$arr1 = GetEduareaAllschool($profile_id);
	$tbl_school = $arr1['allschool'];
	$sql = "SELECT count(id) as num1 FROM $tbl_school where siteid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end 

##############  function �Ѻ�ӹǹ�͡��÷���ͺ���§ҹ����Ѻ��� �᡹�͡���
function CountAssignScan(){
	global $dbname_temp,$profile_id,$activity_id;
	$sql = "SELECT count(ticketid) as numid, staffid  FROM `tbl_checklist_assign` WHERE  profile_id='$profile_id'  AND activity_id='$activity_id'  GROUP BY staffid";
	//echo $sql." :: ".$dbname_temp;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]] = $rs[numid];
	}//end while($rs = mysql_fetch_assoc($result)){	
	return $arr;
}//end function CountAssignScan(){
	
###########  �Ѻ�ӹǹ�͡��âͧ㺧ҹ
function CountScanDetail($staffid){
	global $dbname_temp,$profile_id,$activity_id;
	$sql = "SELECT
Count(idcard) AS NUM1,
tbl_checklist_assign_detail.idcard,
tbl_checklist_assign.ticketid
FROM
tbl_checklist_assign
Inner Join tbl_checklist_assign_detail ON tbl_checklist_assign.ticketid = tbl_checklist_assign_detail.ticketid
AND tbl_checklist_assign.activity_id='$activity_id'
WHERE tbl_checklist_assign.profile_id='$profile_id' AND staffid='$staffid' group by tbl_checklist_assign.ticketid";
	//echo "$dbname_temp :: ".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[ticketid]] = $rs[NUM1];
	}
	return $arr;	
}//end function CountScanDetail(){
	
	####  function �ʴ� icon ����ͺ���§ҹ
function ShowIconAssign($status_approve){
		if($status_approve == "1"){
				$xicon = "<img src=\"../userentry/images/greendot.gif\" width=\"20\" height=\"17\" border='0' title='ʶҹ����ͺ�ҹ���º��������'>";
		}else if($status_approve == "0"){
				$xicon = "<img src=\"../userentry/images/yellowdot.gif\" width=\"20\" height=\"17\" border='0' title='���������ҧ���Թ���'>";
		}else if($status_approve == "2"){
				$xicon = "<img src=\"../userentry/images/reddot.gif\" width=\"20\" height=\"17\" border='0' title='ʶҹ��͡��������'>";	
		}else{
				$xicon = "<img src=\"../userentry/images/yellowdot.gif\" width=\"20\" height=\"17\" border='0' title='���������ҧ���Թ���'>";
		}
		
		
	return $xicon;
}//end function ShowIconAssign(){
	
##########  �ӹǹ���͡�����¤�
function CountPagePerPerson($ticketid,$profile_id){
		global $dbname_temp;
		$sql = "SELECT
tbl_checklist_assign_detail.idcard,
tbl_checklist_kp7.page_num
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
WHERE
tbl_checklist_assign_detail.ticketid =  '$ticketid' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[idcard]] = $rs[page_num];
	}//end while($rs = mysql_fetch_assoc($result)){ 
	return $arr;
}//end function CountPagePerPerson(){
	
###########  �Ѻ�ӹǹ�ش�����㺧ҹ

function CountTicketDetail($ticketid){
	global $dbname_temp,$profile_id;
	$sql = "SELECT
Count(idcard) AS NUM1
FROM
tbl_checklist_assign
Inner Join tbl_checklist_assign_detail ON tbl_checklist_assign.ticketid = tbl_checklist_assign_detail.ticketid
WHERE tbl_checklist_assign.ticketid='$ticketid' AND tbl_checklist_assign.profile_id='$profile_id' group by tbl_checklist_assign.ticketid";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
}

#################  �ʴ����������´�ͧ�ؤ�ҡ�� checklist
function ShowPersonDetail($idcard){
	global $dbname_temp,$profile_id,$xyear;
	$sql = "SELECT idcard,position_now,schoolid,(TIMESTAMPDIFF(MONTH,tbl_checklist_kp7.begindate,'$xyear')/12) as age_gov FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['schoolid'] = show_school($rs[schoolid]);
	$arr['position_now'] =  $rs[position_now];
	$arr['age_gov'] = $rs[age_gov];
	return $arr;
}//end function ShowPersonDetail(){
	
	function XCountPagePdf_Brows($file){
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
		return $found[1];
		//fclose($handle); 
	}//end function XCountPagePdf($file){\\\
	
################  function ��Ǩ�ͺ����ͺ���§�ҹ
function CheckAssginSearch($idcard){
	global $dbname_temp,$profile_id;
	$sql = "SELECT
tbl_checklist_assign_detail.idcard,
tbl_checklist_assign_detail.approve
FROM `tbl_checklist_assign_detail`
where idcard='$idcard' and profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);

	$rs = mysql_fetch_assoc($result);
	return $rs[approve];
}

###  function �ʴ����;�ѡ�ҹ
function ShowUserScan($ticketid){
	global $dbname_temp,$profile_id;
	$sql = "SELECT
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_assign.ticketid
FROM
edubkk_checklist.tbl_checklist_assign
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_assign.staffid = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_assign.ticketid =  '$ticketid'";	
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}
################################################### sum array by key

	function SumArray2D($arr,$get_key){
		foreach($arr as $key => $value){
			$sum += $value[$get_key];
		}//end foreach($arr as $k => $v){

		return $sum;
	}//end function array_sum_by_key(){
		
	function SumArray3D($arr,$get_key){
		foreach($arr as $key => $value){
			foreach($value as $k1 => $val1){
				$sum += $val1[$get_key];
			}//end foreach($value as $k1 => $val1){
		}//end foreach($arr as $k => $v){

		return $sum;
	}//end function array_sum_by_key(){



###########  �Ѻ�ӹǹ�ؤ�ҡ÷��������ѧ�Ѵ
function CountPerSonNoArea($siteid=""){
	global $dbname_temp,$profile_id;
	if($siteid != ""){
			$conW = " AND siteid='$siteid'";
	}else{
			$conW = " ";	
	}
	$sql = "	SELECT COUNT(idcard) AS nump FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' AND (schoolid='0' OR schoolid IS NULL OR schoolid='') $conW" ;
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[nump];
}// end function CountPerSonNoArea($siteid=""){
	
#####  function �Ѵ�ͧ���ҡ����ʡ��͡��÷���� log ������Floder ࢵ
function CopyFilePdfArea($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_log_uploadfile WHERE idcard='$idcard' ORDER BY time_update DESC LIMIT 0,1";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$sourcefile = $rs[kp7file];
	$destfile = "../../../checklist_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
	if(file_exists($sourcefile)){
		@copy($sourcefile,$destfile);	
		@chmod($destfile,0777);
		$xnumpage = XCountPagePdf_Brows($destfile);
		$sql_up = "UPDATE tbl_checklist_kp7 SET page_upload='$xnumpage' WHERE  idcard='$idcard' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_up);
		
	}//end if(file_exists($sourcefile)){
}// //end function CopyFilePdfArea(){
	
########################### �Ѵ�ͧ���ó�ʶҹ����������ó�����
function ChangStatusFile($idcard,$profile_id,$sentsecid){
	global $dbname_temp;
		$sqlc_file = "SELECT * FROM tbl_checklist_kp7 WHERE status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' AND idcard='$idcard' AND profile_id='$profile_id' AND siteid='$sentsecid'";
	$sqlc_file = mysql_db_query($dbname_temp,$sqlc_file);
	$rscfile = mysql_fetch_assoc($sqlc_file);
	if($rscfile[idcard] != ""){
			CopyFilePdfArea($rscfile[idcard],$rscfile[profile_id]);
	}//end 	if($rscfile[idcard] != ""){
}//end function ChangStatusFile($idcard,$profile_id,$sentsecid){
	
####  funciton ��Ǩ�ͺ ��óյ�ͧ�������¹�Ţ�ѵèҡ˹������� checklist
function CheckChangeIdcardFrom($old_idcard,$new_idcard,$siteid,$profile_id=""){
	global $dbnamemaster,$dbname_temp,$dbcallcenter_entry;
	if($profile_id != ""){
			$conw = " AND profile_id='$profile_id'";
	}else{
			$conw = "";	
	}
	### ��ʨ�ͺ㹰ҹ������ cmss ��͹�����������
	$sqlcmss = "SELECT COUNT(CZ_ID) AS numid FROM view_general WHERE CZ_ID='$new_idcard'";
	$resultcmss = mysql_db_query($dbnamemaster,$sqlcmss);
	$rscmss = mysql_fetch_assoc($resultcmss);
	### ��Ǩ�ͺ������㹰ҹ������ checklist 
	$sql_checklist = "SELECT COUNT(idcard) AS numid1 FROM tbl_checklist_kp7 WHERE idcard='$new_idcard' $conw";
	$result_checklist = mysql_db_query($dbname_temp,$sql_checklist);
	$rscl = mysql_fetch_assoc($result_checklist);
		if($rscmss[numid] > 0 or  $rscl[numid1] > 0){ 
			$sql_update = "REPLACE  INTO temp_change_idcard SET status_process='2', old_idcard='$old_idcard',new_idcard='$new_idcard',siteid='$siteid', sys_change='sys'";
			mysql_db_query($dbname_temp,$sql_update);
		}else{
			mysql_db_query($dbname_temp,"UPDATE tbl_checklist_log_uploadfile SET idcard='$new_idcard' WHERE idcard='$old_idcard'");
		
			ChangStatusFile($new_idcard,$profile_id,$siteid);
			$sql_update = "REPLACE  INTO temp_change_idcard SET status_process='1', old_idcard='$old_idcard',new_idcard='$new_idcard',siteid='$siteid', sys_change='sys'";
			mysql_db_query($dbname_temp,$sql_update);
		}
		
}//end function CheckChangeIdcard(){
	
function DefultActivity_Id(){
	global $dbname_temp;
	$sql = "SELECT activity_id FROM tbl_checklist_activity WHERE defult_act='1'";
	$result = @mysql_db_query($dbname_temp,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[activity_id];

}//end function DefultActivity_Id(){
###################  funciton show �Ԩ����
function ShowActivity($activity_id){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_activity WHERE activity_id='$activity_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[activity];
}//end function ShowActivity($activity_id){

##  �óջ������Ԩ����繤����ҧ
if($activity_id == ""){
	$activity_id = DefultActivity_Id();
}//end if($activity_id == ""){
	
	#################
### funciton ����Ѻ�׹�͡���
function ApproveReciveDoc($ticketid,$act_id,$profile_id){
		global $dbname_temp;
		$sql = "SELECT sum(if(status_sr_doc='2',1,0)) as numapp,count(idcard) as numid FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' AND activity_id='$act_id'  GROUP BY ticketid";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[numapp] == $rs[numid]){
			return "<img src=\"../../images_sys/circle5.gif\" width=\"19\" height=\"19\" border='0' title='�׹�͡������º��������'>";		
		}else if($rs[numid] > $rs[numapp]){
			return "<img src=\"../../images_sys/circle3.gif\" width=\"19\" height=\"19\" border='0' title='�ѧ�����׹�͡���'>";
		}else{
			return "";	
		}
		
		
} // end ʶҹС���Ѻ�׹�͡���
	
function StatusDocument($get_id){
		if($get_id == "1"){
			return "<img src=\"../../images_sys/circle3.gif\" width=\"19\" height=\"19\" border='0' title='�ѧ�����׹�͡���'>";
		}else if($get_id == "2"){
			return "<img src=\"../../images_sys/circle5.gif\" width=\"19\" height=\"19\" border='0' title='�׹�͡������º��������'>";	
		}else{
			return "";	
		}
}//end function StatusDocument(){
	
##### �ʴ� �ӹǹ���͡��÷�� upload ������к�
function ShowPageUpload($idcard){
	global $dbname_temp,$profile_id;
	$sql = "SELECT page_upload FROM tbl_checklist_kp7 WHERE idcard='$idcard'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[page_upload];
}//end function ShowPageUpload($idcard){
#####  function ��͹ warnning  ��դ׹�͡��� ��á�� upload �͡���
function AlertWarnning($date_sent){
	$datec = date("Ymd");
	$arrs = explode("-",$date_sent);
	$datesent = $arrs[0]."".$arrs[1]."".$arrs[2];
	if($datec > $datesent){
		return "<img src=\"../../images_sys/alert.png\" width=\"15\" height=\"16\" border='0' title='ʶҹ�����͹�͡�����Ҫ��' style=\"cursor:hand\">";
	}else{
		return " ";	
	}
	
}//end function AlertWarnning(){
	
function CheckAlert($ticketid,$date_sent,$typea=""){
	global $dbname_temp,$profile_id,$activity_id;
	if($typea == ""){
		$sql = "SELECT COUNT(idcard) as numall ,SUM(if(status_sr_doc='2',1,0)) AS numapprove FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' ";	
	}else{
		$sql = "SELECT COUNT(idcard) as numall ,SUM(if(approve='1',1,0)) AS numapprove FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' ";	
	}
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[numall] != $rs[numapprove]){
		return  AlertWarnning($date_sent);
	}else{
		return " ";	
	}
}//end function CheckAlert($ticketid,$date_sent,$typea=""){
	
######  ��  log activity
function AddLogActivity($ticketid,$idcard,$siteid,$staffid_target,$action,$activity_id,$status_doc,$comment=""){
	global $dbname_temp,$profile_id;
		$ip = get_real_ip();
		$sql_insert = "INSERT INTO tbl_checklist_assign_log_activity SET ticketid='$ticketid',idcard='$idcard',siteid='$siteid',staffid='".$_SESSION[session_staffid]."',staffid_target='$staffid_target',user_ip='$ip',action='$action',activity_id='$activity_id',status_doc='$status_doc',comment='$comment',profile_id='$profile_id',timeupdate=NOW()";
		mysql_db_query($dbname_temp,$sql_insert);
}//end function AddLogActivity(){
###  �� log  activity


function ShowUserCheck($idcard){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_log WHERE idcard='$idcard' AND type_action='1' group by user_update ORDER BY time_update DESC LIMIT 1";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return show_user($rs[user_update])." �ѹ��� ".get_dateThai($rs[time_update]);
}//end 





function ShowDash($numid){
		if($numid > 0){
				return "<font color='red'>".$numid."</font>";
		}else{
				return "-";	
		}
}//end function ShowDash($numid){
	
#######################  �ʴ���Ǵ�ѭ�ҡ����䢻ѭ��

function ShowProblemStatus($idp){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_problem_status WHERE problem_status_id='$idp'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[problen_status_name];
}//end function ShowProblemStatus(){
	
	
	function SaveLoadPage($get_page,$profile_id,$point_page=""){
		global $dbname_temp;
		if($point_page == ""){
				@mysql_db_query($dbname_temp,"REPLACE INTO  tbl_temp_profile SET profile_id='$profile_id',start_time='".date("Y-m-d H:i:s")."',page_load='$get_page'");
		}else if($point_page == "m"){
				@mysql_db_query($dbname_temp,"UPDATE  tbl_temp_profile SET m_time='".date("Y-m-d H:i:s")."' WHERE page_load='$get_page' AND profile_id='$profile_id'");
		}else if($point_page == "e"){
				@mysql_db_query($dbname_temp,"UPDATE  tbl_temp_profile SET end_time='".date("Y-m-d H:i:s")."' WHERE page_load='$get_page' AND profile_id='$profile_id'");
		}else{
				@mysql_db_query($dbname_temp,"REPLACE INTO  tbl_temp_profile SET profile_id='$profile_id',start_time='".date("Y-m-d H:i:s")."',page_load='$get_page'");
		}
	
	}//end function SaveLoadPage(){
		
		
	function SaveLogLoadPage($get_page,$profile_id,$page_row){
			global $dbname_temp;
			$sql = "INSERT INTO tbl_temp_profile SET profile_id='$profile_id',start_time='".date("Y-m-d H:i:s")."',page_row='$page_row',page_load='$get_page'";
			$result = mysql_db_query($dbname_temp,$sql);
			$last_id = mysql_insert_id();
			return $last_id;
	}
	function SaveLogLoadPageDetail($last_id){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_temp_profile_detail SET load_id='$last_id',row_time='".date("Y-m-d H:i:s")."'";
		mysql_db_query($dbname_temp,$sql);
			
	}
	
	function UpdateLoadPage($last_id){
		global $dbname_temp;
		$sql_up = "UPDATE tbl_temp_profile SET status_load='1' WHERE load_id='$last_id' ";
		mysql_db_query($dbname_temp,$sql_up);
			
	}//end function UpdateLoadPage(){
		
	######### ��Ǩ�ͺ���� ��� ���ʡ�ŷ���ӡѹ��к�
function CheckNameSurname($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT name_th,surname_th,siteid FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	$sql1 = "SELECT COUNT(idcard) as num1 FROM tbl_checklist_kp7_false WHERE name_th='$rs[name_th]' AND surname_th='$rs[surname_th]' AND profile_id='$profile_id' AND siteid='$rs[siteid]' AND status_IDCARD LIKE  '%IDCARD_FAIL%' AND status_chang_idcard LIKE  '%NO%'";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$arr['num'] = $rs1[num1];
	$arr['name_th'] = $rs[name_th];
	$arr['surname_th'] = $rs[surname_th];
	$arr['siteid'] = $rs[siteid];	
	return $arr;
}//end function CheckNameSurname(){

######### ��Ǩ�ͺ���� ��� ���ʡ�ŷ���ӡѹ��к�

function CheckNameReplace($name_th,$surname_th,$profile_id,$siteid){
	global $dbname_temp;
	$sql = "SELECT idcard FROM tbl_checklist_kp7_false WHERE name_th='$name_th' AND surname_th='$surname_th' AND profile_id='$profile_id' AND siteid='$siteid' ";
//echo $sql;die;
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[idcard];	
}//end function CheckNameReplace($name_th,$surname_th,$profile_id,$siteid){
		
function CountProblem($siteid,$profile_id,$schoolid,$xlv="",$school_type=''){
	global $dbname_temp,$xgen_id;
	if($school_type == '0'){
	  $having =  " HAVING school_status = 'pri_school' ";
	}elseif($school_type == '1'){
	  $having =  " HAVING school_status = 'high_school' ";
	}else{
	  $having = "";
	}
	
	if($schoolid != ""){
			$conv = " AND tbl_checklist_kp7.schoolid='$schoolid'";
	}else{
			$conv = "";	
	}//end if($schoolid == ""){
		if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}

		if($xgen_id != ""){
				$join_profile = " inner join profile_genfile_allschool on tbl_checklist_kp7.schoolid=profile_genfile_allschool.id";
				$con2 = " and profile_genfile_allschool.gen_id='1'";
		}else{
				$join_profile = "";		
				$con2 = "";
		}
	
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
CAST(tbl_checklist_kp7.schoolid as SIGNED) as orderschoolid,
Sum(if(tbl_checklist_problem_detail.menu_id='1',1,0)) AS p1,
Sum(if(tbl_checklist_problem_detail.menu_id='2',1,0)) AS p2,
Sum(if(tbl_checklist_problem_detail.menu_id='3',1,0)) AS p3,
Sum(if(tbl_checklist_problem_detail.menu_id='4',1,0)) AS p4,
Sum(if(tbl_checklist_problem_detail.menu_id='5',1,0)) AS p5,
Sum(if(tbl_checklist_problem_detail.menu_id='6',1,0)) AS p6,
Sum(if(tbl_checklist_problem_detail.menu_id='7',1,0)) AS p7,
Sum(if(tbl_checklist_problem_detail.menu_id='8',1,0)) AS p8,
Sum(if(tbl_checklist_problem_detail.menu_id='9',1,0)) AS p9,
Sum(if(tbl_checklist_problem_detail.menu_id='10',1,0)) AS p10,
Sum(if(tbl_checklist_problem_detail.menu_id='11',1,0)) AS p11,
Sum(if(tbl_checklist_problem_detail.menu_id='12',1,0)) AS p12,
Sum(if(tbl_checklist_problem_detail.menu_id='13',1,0)) AS p13,
if(tbl_checklist_kp7.mainpage='0',1,0) AS nopage,
tbl_checklist_kp7.type_doc,
tbl_checklist_kp7.page_num,
if( (edubkk_master.allschool_math_sd.schid IS NULL OR edubkk_master.allschool_math_sd.schid = '') , 'pri_school' , 'high_school'  ) AS school_status ,
edubkk_master.allschool_math_sd.schid


FROM
tbl_checklist_kp7
$join_profile
LEFT Join  tbl_checklist_problem_detail ON tbl_checklist_kp7.idcard = tbl_checklist_problem_detail.idcard
LEFT JOIN edubkk_master.allschool_math_sd ON tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid
where tbl_checklist_kp7.profile_id='$profile_id' and tbl_checklist_kp7.siteid='$siteid'
 $conx $conv  $con2
GROUP BY  tbl_checklist_kp7.idcard 
$having
ORDER  BY orderschoolid ASC
";
//echo $sql;
//echo "<br><br>";
//echo $dbname_temp;
	$result = mysql_db_query($dbname_temp,$sql)or die(mysql_error());
	while($rs = mysql_fetch_assoc($result)){
		//$arr[$rs[idcard]]['xtitle'] = ShowUserCheck($rs[idcard]);
		$arr[$rs[idcard]]['fullname'] = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
		$arr[$rs[idcard]]['position_now'] = $rs[position_now];
		$arr[$rs[idcard]]['schoolid'] = $pre_org."".show_school($rs[schoolid]);
		$arr[$rs[idcard]]['p1'] = $rs[p1];
		$arr[$rs[idcard]]['p2'] = $rs[p2];
		$arr[$rs[idcard]]['p3'] = $rs[p3];
		$arr[$rs[idcard]]['p4'] = $rs[p4];
		$arr[$rs[idcard]]['p5'] = $rs[p5];
		$arr[$rs[idcard]]['p6'] = $rs[p6];
		$arr[$rs[idcard]]['p7'] = $rs[p7];
		$arr[$rs[idcard]]['p8'] = $rs[p8];
		$arr[$rs[idcard]]['p9'] = $rs[p9];
		$arr[$rs[idcard]]['p10'] = $rs[p10];
		$arr[$rs[idcard]]['p11'] = $rs[p11];
		$arr[$rs[idcard]]['p12'] = $rs[p12];
		$arr[$rs[idcard]]['p13'] = $rs[p13];
		$arr[$rs[idcard]]['nopage'] = $rs[nopage];		
		$arr[$rs[idcard]]['type_doc'] = $rs[type_doc];
		$arr[$rs[idcard]]['page_num'] = $rs[page_num];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountProblem($siteid,$schoolid,$profile_id){
	
	
########  function �� log ��� upload  pdf ���ӹǹ�����ç�ѹ
function SaveLogNumPageNoMath($idcard,$page_upload,$profile_id){
	global $dbname_temp;
	if($_SESSION['session_staffid'] == ""){
		$staffid = "SYS";
	}else{
		$staffid = $_SESSION['session_staffid'];	
	}
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$sql_insert = "INSERT INTO tbl_checklist_lognum_pagenomath SET idcard='$idcard',siteid='$rs[siteid]',page_num='$rs[page_num]', page_upload='$page_upload', staffid='$staffid',profile_id='$profile_id', timeupload=NOW()";
	mysql_db_query($dbname_temp,$sql_insert);
		
}

function CheckNumDataCmss(){
		global $dbnamemaster;
		$sql = "SELECT COUNT(status_all) as NUM1 FROM temp_checknum_data_byarea WHERE status_all='0' group by status_all";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[NUM1];
}

####  �� log 㹡����Ҵ١�������ҹ��к��ͧ senior
function SaveLogViewReport(){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_checklist_logviewreport_executive SET staffid='".$_SESSION['session_staffid']."',dateview=NOW()";
	mysql_db_query($dbname_temp,$sql);
}//end function SaveLogViewReport(){


function ShowProblemMainPage($page_id){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_mainpage_comment WHERE runid='$page_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[mainpage_comment];
}


function CheckReplaceCmss($idcard,$siteid){
	global $dbnamemaster;
	$sql = "SELECT COUNT(CZ_ID) AS numid,siteid FROM  view_general WHERE CZ_ID='$idcard' AND siteid <> '$siteid' GROUP BY CZ_ID";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[numid] > 0){
			$arr[0] = 1;
			$arr[1] = $rs[siteid];			
	}else{
		$arr[0] = 0;
		$arr[1] = "";	
	}
	return $arr;
}//end function CheckReplaceCmss($idcard,$siteid){
	
function SaveLogUnlinkFile($idcard,$siteid,$file_script,$url_file,$profile_id){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_log_unlinkfile SET idcard='$idcard',siteid='$siteid',file_script='$file_script',url_file='$url_file',profile_id='$profile_id',staff_id='".$_SESSION['session_staffid']."',timeupdate=NOW()";
	mysql_db_query($dbname_temp,$sql);	
}//end function SaveLogUnlinkFile($idcard,$siteid,$file_script,$url_file,$profile_id){
	
##########  function �� log ��� gen ��� pdf
function SaveLogExcelGen($profile_id,$siteid,$file_name){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_logfile_excel SET profile_id='$profile_id',siteid='$siteid',file_name='$file_name',file_time=NOW(),staffid='".$_SESSION['session_staffid']."'";
	//echo $dbname_temp." :: ".$sql;die;
	mysql_db_query($dbname_temp,$sql);
}//end function SaveLogExcelGen(){
	
	
function GetArea($siteid,$moi_id,$type_name){
	global $dbnamemaster;
	$subarea = substr($moi_id,0,4);
	$sql = "SELECT ccName FROM ccaa WHERE secid='$siteid' AND ccType='$type_name'  AND areaid='$subarea' ";	
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[ccName];
}// end function GetArea($siteid,$moi_id,$type_name){
	
function LogImpExpExcel($siteid,$profile_id,$action,$add_data="",$update_data="",$del_data=""){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_checklist_logexcel SET siteid='$siteid',staffid='".$_SESSION['session_staffid']."',action='$action',profile_id='$profile_id',time_update=NOW(),add_data='$add_data',update_data='$update_data',del_data='$del_data'";
	mysql_db_query($dbname_temp,$sql);	
}//end function LogImpExpExcel($siteid,$profile_id,$action){
	
function GetSchoolid($xsiteid,$schoolname){
	global $dbnamemaster;
	$sql = "SELECT * FROM allschool  WHERE office='$schoolname' AND siteid='$xsiteid'";	
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[id];
}//end function GetSchoolid($xsiteid,$schoolname){
	
function CheckBdate($d){
	if($d != ""){
		$spos = strpos($d,"-");
		if(!($spos === false)){
			$arr = explode("-",$d);
		}else{
			$arr = explode("/",$d);
		}//end if(!($spos === false)){
		
		if($arr[0] > 2000){
				$date1 = $arr[0]."-".$arr[1]."-".$arr[2];
		}else{
				$date1 = $arr[2]."-".$arr[1]."-".$arr[0];
					
		}
			
	}else{
		$date1 = "0000-00-00";	
	}
	return $date1;	
}//end function CheckBdate($d){
	
	function FieldComment(){
		global $dbname_temp;
		$sql = "SELECT * FROM tbl_check_menu ORDER BY orderby ASC";	
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[field_comment]] = $rs[menu_detail];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}//end function FieldComment(){
		
	#########  function 
	
	function FindChangeIdcard($profile_id,$siteid){
		global $dbname_temp;
		$sql = "SELECT * FROM temp_change_idcard  WHERE status_process='1' AND siteid='$siteid'";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[new_idcard]] = $rs[old_idcard];
		}//end 	while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}//end function FindChangeIdcard(){
		
		
	function FindOldArea($get_schoolid){
			$dbnamemaster = DB_MASTER;
			$sql = "SELECT * FROM allschool_math_sd WHERE schoolid='$get_schoolid'";
			$result = mysql_db_query($dbnamemaster,$sql);
			$rs = mysql_fetch_assoc($result);
			
			$sqledu = "SELECT secname FROM eduarea_profile1 WHERE secid='$rs[siteid]'";
			$resultedu = mysql_db_query($dbnamemaster,$sqledu);
			$rse = mysql_fetch_assoc($resultedu);
			return  str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rse[secname]);
			
	}// end 
	
	#############  function CountPdfPiccmss() �Ѻ�ӹǹ�ٻ�Ҿ��Шӹǹ pdf
	
	function CountPersonPdfPicCmss($profile_id,$siteid=""){
		global $dbname_temp;
		if($siteid != ""){
				$conv = " AND t1.siteid='$siteid' ";
				$groupby = " GROUP BY schoolid ";
		}else{
				$conv = "";
				$groupby = " GROUP BY t1.siteid";
		}//end if($siteid != ""){
			
		$sql = "SELECT 
		t1.siteid,
		if(t1.schoolid>0,t1.schoolid,0) as schoolid,
    	count(t1.idcard) as numall,
		Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as numpass, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' and t2.idcard Is not null,1,0 )) as num_imp,
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' and t2.idcard Is null,1,0)) as diffnum_imp,
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,t1.pic_num,0 )) as numpic,
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' and t1.page_upload > 0,1,0)) as numpdf
		FROM tbl_checklist_kp7 AS t1  LEFT JOIN tbl_check_data AS t2 
		ON  t1.idcard=t2.idcard 
		AND t1.siteid=t2.secid 
		AND t2.status_tranfer_data='1'  
		AND t2.profile_id='$profile_id'
		WHERE t1.profile_id='$profile_id' $conv  $groupby ";	
		//echo $dbname_temp." ".$sql;
		$result  = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){ 		#sum(t1.pic_num) as numpic,
			if($siteid != ""){ $orgid = $rs[schoolid];}else{ $orgid = $rs[siteid];}
				$arr[$orgid]['numall'] = $rs[numall]; // �ӹǹ�ؤ�ҡ÷�����
				$arr[$orgid]['numpass'] = $rs[numpass]; // �ӹǹ�ؤ�ҡ÷������������к�
				$arr[$orgid]['num_imp'] = $rs[num_imp]; // �ӹǹ��������к������
				$arr[$orgid]['diffnum_imp'] = $rs[diffnum_imp];
				$arr[$orgid]['numpic'] = $rs[numpic]; // �ӹǹ�ٻ��������к� checklist
				$arr[$orgid]['numpdf'] = $rs[numpdf];// �ӹǹpdf ��ѧ�����к�
		}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}//end 	function CountPersonPdfPicCmss(){
	
	##############  �Ѻ�ӹǹ�ٻ�Ҿ��� �.�.7 �鹩�Ѻ
	
	
function ProtectAssignKey($idcard,$profile_id){
	global $dbname_temp,$path_pdf;
	$status_kp7file = 1;
	$msg_err = "";
	$sql = "SELECT *,if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0',1,0) as status_doc FROM tbl_checklist_kp7 WHERE idcard='$idcard'  AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$kp7file = "$path_pdf".$rs[siteid]."/".$rs[idcard].".pdf";
	if(!(file_exists($kp7file))){
		$status_kp7file = 0;	
	}
	
				if($rs[pic_num] > 0){
				$db_site = STR_PREFIX_DB.$rs[siteid];
				$sql_general_pic = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$rs[idcard]' group by id";
				$result_general_pic = mysql_db_query($db_site,$sql_general_pic);
				$rspic1 = mysql_fetch_assoc($result_general_pic);
				$numpic_sys = intval($rspic1[numpic]);// �ӹǹ�ٻ��ԧ��к�
				//echo "$rs[pic_num] ::: $numpic_sys<br>";
				if($rs[pic_num] != $numpic_sys){
						$msg_err .= "�ٻ���ú���Ѻ�� $rs[pic_num] �ٻ��������к� $numpic_sys �ٻ \\n";
					}
				}//end 
				
				if($rs[status_doc] == "0"){
						$msg_err .= "ʶҹ��͡����������ó� \\n";
				}
				
				if($status_kp7file == "0"){ // �������� pdf
						$msg_err .= "��辺��� �.�. 7 �鹩�Ѻ \\n";
				}

				if($rs[page_upload] > 0 and $rs[page_num] != $rs[page_upload]){
					$msg_err .= "�ӹǹ���͡��� �.�.���ç�ѹ<br>��ѡ�ҹ�Ѻ�� $rs[page_num] �� �к��Ѻ�� $rs[page_upload] �� \\n";
				}

if($msg_err != ""){
	$arr['error'] = "error";
	$arr['msg'] = "�����Ţͧ $rs[prename_th]$rs[name_th]  $rs[surname_th]  �Ţ�ѵ� $rs[idcard]  $msg_err";
		
}else{
	$arr['error'] = "";	
	$arr['msg'] = "";
}
return $arr;

		
}// end function ProtectAssignKey(){
	
##### function GetProfile eduarea allschool

function GetEduareaAllschool($profile_id){
	global $dbnamemaster;
	$sql = "SELECT * FROM area_history WHERE profile_id='$profile_id'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[tbl_eduarea] != ""){
			$arr['eduarea'] = $rs[tbl_eduarea];
			$arr['allschool'] = $rs[tbl_allschool];
	}else{
			$arr['eduarea']	 = "eduarea";
			$arr['allschool'] = "allschool";
	}
	
	return $arr;	
}// end function GetEduareaAllschool($profile_id){
	
	
##########  FUNCTION update �Ţ�ѵ÷�����١��ͧ��������û���ͧ�ҡ temp pobec �������ó� �óշ���ա�� dowload ��� excel

function UpdateidfalsePobec($idcard,$profile_id,$siteid){
	global $dbname_temp;
	$strsql = "SELECT * FROM tbl_checklist_kp7_false WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$siteid'";
	$result1 = mysql_db_query($dbname_temp,$strsql) or die(mysql_error()."LINE ::".__LINE__);
	$rs1 = mysql_fetch_assoc($result1);
	
	if($rs1[status_IDCARD_REP]='IDCARD_REP' or $rs1[status_IDCARD_REP]='IDCARD_REP_NO_PERSON' or $rs1[status_IDCARD_REP]='REP_CHECKLISTSITE'){
		$consite = ", status_id_replace='1'";	
			if(!Check_IDCard($idcard)){
				$status_id_false = 1;
			}else{
				$status_id_false = 0;	
			}

	}else{
		$consite = "";
		$status_id_false = 1;
	}

	
	
	//$temp_id = CheckNameReplace($rs1[name_th],$rs1[surname_th],$profile_id,$siteid);
	$sql_sel = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' and profile_id='$profile_id'";
	$result_sel = mysql_db_query($dbname_temp,$sql_sel) or die(mysql_error()."LINE ::".__LINE__);
	$rss = mysql_fetch_assoc($result_sel);
	if($rss[idcard] == ""){
		$sql_insert = "INSERT INTO tbl_checklist_kp7 SET idcard='$idcard', siteid='$siteid', prename_th='$rs1[prename_th]', name_th='$rs1[name_th]', surname_th='$rs1[surname_th]',birthday='$rs1[birthday]', begindate='$rs1[begindate]', position_now='$rs1[position_now]', profile_id='$profile_id',schoolid='$rs1[schoolid]',status_id_false='$status_id_false' ";	
			mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE ::".__LINE__);
	}else{
			if($rs1[name_th] != "" and $rs1[surname_th] != ""){
		$sql_update = "UPDATE tbl_checklist_kp7 SET prename_th='$rs1[prename_th]',name_th='$rs1[name_th]',surname_th='$rs1[surname_th]',position_now='$rs1[position_now]'  WHERE idcard='$idcard' and siteid='$siteid' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."LINE ::".__LINE__);
			}// end if($rs1[name_th] != "" and $rs1[surname_th] != ""){
	}
	
	//if($temp_id == ""){ // �ѧ�������ª��ͤ������к� checklist
			
	//}// end if($temp_id == ""){ 
	
	
	$sql = "UPDATE tbl_checklist_kp7_false SET status_chang_idcard='YES' $consite  WHERE idcard='$idcard' AND profile_id='$profile_id' AND siteid='$siteid'";
	mysql_db_query($dbname_temp,$sql);
}//end function UpdateidfalsePobec(){
	
#############  end update  �Ţ�ѵ÷�����١��ͧ��������û���ͧ�ҡ temp pobec �������ó� �óշ���ա�� dowload ��� excel

#####  function CheckField protection
function FieldProtectionImport(){
	global $dbname_temp;
	$sql = "SELECT pro_id,field_name FROM tbl_checklist_protection WHERE status_active='1' ORDER BY pro_id ASC";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[field_name]] = $rs[pro_id];
	}// end 	while($rs = mysql_fetch_assoc($result)){ 
		return $arr;
}//end function FieldProtectionImport(){


######## function �� log ��ù���Ң�����

function SaveLogImpotCheckListToCmss($idcard,$siteid,$profile_id,$status_import){
	global $dbname_temp;
	$ip = get_real_ip();	 // ip ����ͧ import
	$sql = "INSERT INTO tbl_checklist_logimport SET idcard='$idcard',siteid='$siteid',profile_id='$profile_id',ip_import='$ip',staff_import='".$_SESSION['session_staffid']."',status_import='$status_import',time_import=NOW()";
	mysql_db_query($dbname_temp,$sql);
}//end function SaveLogImpotCheckListToCmss($idcard,$siteid,$profile_id,$status_import){ 

#####  function 㹡����  error
function SaveImpotError($idcard,$siteid,$profile_id,$pro_id){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_checklist_logimport_error SET idcard='$idcard',siteid='$siteid',profile_id='$profile_id',pro_id='$pro_id' ";
	mysql_db_query($dbname_temp,$sql);
		
}//end function SaveImpotError($idcard,$siteid,$profile_id,$pro_id){
	
### function 㹡�� ź ��¡��
function CleanImportError($idcard,$siteid,$profile_id){
	global $dbname_temp;
	$sql_del = "DELETE FROM tbl_checklist_logimport_error WHERE idcard='$idcard',siteid='$siteid',profile_id='$profile_id'";
	mysql_db_query($dbname_temp,$sql_del);
}//end function CleanImportError($idcard,$siteid,$profile_id){
	
###  function �Ѻ�ӹǹ��¡�â����ŷ���ջѭ���������ö�������

function CountImpError($siteid,$profile_id){
	global $dbname_temp;
	$sql = "SELECT COUNT(idcard) as num1,idcard FROM tbl_checklist_logimport_error WHERE siteid='$siteid' AND profile_id='$profile_id' GROUP BY idcard";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[idcard]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountImpError(){
	

	
###  function ��Ǩ�ͺ������³�����Ҫ���
function CheckRetire($idcard){
	global $dbnamemaster;
	$sql = "SELECT COUNT(idcard) as num1 FROM tran_temp_center  WHERE idcard='$idcard' and type_sys='2' and retire_status <> '7' ";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}//end 

#### function  㹡�õ�Ǩ�ͺ�͡��÷����Ѻ�׹�ҡ��������ͧ���͡������ҹ��� QC ������ҹ��
function CheckDocQC($idcard,$staffid){
	global $dbnameuse;
	$arrid = array();
	unset($arrid);

	$sql = "SELECT
t1.idcard,
t2.flag_qc,
t1.staffid
FROM
validate_checkdata as t1
Inner Join stat_user_keyperson as t2 ON t1.idcard = t2.idcard AND t1.staffid = t2.staffid
WHERE t1.idcard='$idcard' AND t1.staffid='$staffid'
group by t1.idcard";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
		$sql1 = "SELECT t1.idcard FROM  stat_user_keyperson AS t1  where t1.staffid='$rs[staffid]' AND t1.flag_qc='$rs[flag_qc]' GROUP BY t1.idcard";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
				$arrid[$rs1[idcard]] = $rs1[idcard];
		}//end while($rs1 = mysql_fetch_assoc($result1)){
		mysql_free_result($result1);
	}else{
		$sql2 = "SELECT idcard,flag_qc FROM stat_user_keyperson WHERE t1.idcard='$idcard' AND t1.staffid='$staffid' ";	
		$result2 = mysql_db_query($dbnameuse,$sql2);
		$rs2 = mysql_fetch_assoc($result2);
		if($rs2[flag_qc] > 0){
				$sql3 = "SELECT t1.idcard,t2.idcard as idqc FROM stat_user_keyperson AS t1  Left Join  validate_checkdata AS t2  ON t1.idcard=t2.idcard WHERE t1.staffid='$staffid' AND t1.flag_qc='$rs2[flag_qc]'   ORDER BY t2.idcard DESC";
				$result3 = mysql_db_query($dbnameuse,$sql3);
				$intA=0;
				while($rs3 = mysql_fetch_assoc($result3)){
					$intA++;
					
					if($intA == "1" and $rs3[idqc] == ""){ // �óա����㹪ش���������Ǩ������ա�� QC
							break;
					}else{
							$arrid[$rs3[idcard]] = $rs3[idcard]; // �óվ���� QC
					}//end 
					
						
				}//end while($rs3 = mysql_fetch_assoc($result3)){
				mysql_free_result($result3);
		}else{ // �óշ���繡�� QC 1 : 1
			$sql4 = "SELECT t1.idcard FROM validate_checkdata  WHERE t1.idcard='$idcard' group by t1.idcard";	
			$result4 = mysql_db_query($dbnameuse,$sql4);
			$rs4 = mysql_fetch_assoc($result4);
			$arrid[$rs4[idcard]] = $rs4[idcard];
			mysql_free_result($result4);
		}//end if($rs2[flag_qc] > 0){
			
		mysql_free_result($result2);
	}//end 	if($rs[idcard] != ""){
	mysql_free_result($result);
		
		return $arrid;
}//end function CheckDocQC($ticketid){
	

function GetStaffKeykp7($ticketid){
	global $dbnameuse;
	$arrid = array();
	unset($arrid);

	$sql = "SELECT
t2.idcard,
t3.staffid
FROM
edubkk_checklist.tbl_checklist_assign AS t1
Inner Join edubkk_checklist.tbl_checklist_assign_detail AS t2 ON t1.ticketid = t2.ticketid
Inner Join callcenter_entry.monitor_keyin as t3 ON t2.idcard = t3.idcard
WHERE
t2.ticketid =  '$ticketid'
group by t2.idcard";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arrid = CheckDocQC($rs[idcard],$rs[staffid]);
	}//end while($rs = mysql_fetch_assoc($result)){
	
	//	echo "<pre>";
	//	print_r($arrid);
	return $arrid;
		
}	// end function GetStaffKeykp7(){
	

	
######  ��Ǩ�ͺ�ش���ӡ�� QC
function GetDocKeyQC($ticketid){
		global $dbname_temp;
		$sql = "SELECT COUNT(t2.idcard) AS num1 FROM 
edubkk_checklist.tbl_checklist_assign as t1
Inner Join edubkk_checklist.tbl_checklist_assign_detail as t2  ON t1.ticketid = t2.ticketid
WHERE t2.ticketid =  '$ticketid' 
group by  t2.ticketid";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num1] > 0 ){
			$arrkey = GetStaffKeykp7($ticketid);
			if(count($arrkey) >=  $rs[num1]){ // �ʴ�����ա�� QC �ú
				$xreturn = 1;	
			}else{
				$xreturn = 0;	
			}
		}else{
			$xreturn = 0;	
		}//if($rs[num1] > 0 ){

		mysql_free_result($result);	
	return $xreturn;
}//end function GetDocKeyQC(){
	
	
#####  function ��  log ��� unlock
function SaveLogConfirmSite($siteid,$profile_id,$log_type,$comment_log,$lock_site){
	global $dbname_temp;
	$ip = get_real_ip();
	$sql = "INSERT INTO log_checklist_unlock SET siteid='$siteid',profile_id='$profile_id',staffid='".$_SESSION['session_staffid']."',log_type='$log_type',comment_log='$comment_log',lock_site='$lock_site',save_ip='$ip',timeupdate=NOW()";
	mysql_db_query($dbname_temp,$sql);
}//end function SaveLogConfirmSite(){
	
### function Check Lock site 㹡ó��ա����Ҿ�鹷�����ǵѴ�ѧ���蹡�÷ӧҹ�ͧ��� callcenter
function CheckLockSiteArea($profile_id){
	global $dbname_temp;
	$sql = "SELECT COUNT(siteid) as num1,siteid FROM tbl_checklist_kp7_confirm_site WHERE  profile_id='$profile_id' AND flag_download_xls='1' GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
		
}// end function CheckLockSiteArea($siteid,$profile_id){
	
#####  function  㹡����������㹵��ҧ hr_addhistoryname
function AddHistoryNameCmss($xsiteid,$idcard,$prename_th,$name_th,$surname_th){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	$sql_ch = "SELECT  COUNT(gen_id) AS num1 FROM hr_addhistoryname  WHERE gen_id='$idcard' GROUP BY gen_id";
	$result_ch = mysql_db_query($dbsite,$sql_ch);
	$rsc = mysql_fetch_assoc($result_ch);
	if($rsc[num1] > 0){
			$sql_ch1 = "SELECT *  FROM hr_addhistoryname WHERE gen_id='$idcard' AND trim(name_th)='$name_th' AND trim(surname_th)='$surname_th' ";
			$result_ch1 = mysql_db_query($dbsite,$sql_ch1);
			$rsc1 = mysql_fetch_assoc($result_ch1);

			$sql_max = "SELECT max(runno) as maxid,min(runno) as minid FROM hr_addhistoryname WHERE gen_id='$idcard'  GROUP BY gen_id";
			$result_max = mysql_db_query($dbsite,$sql_max);
			$rsm = mysql_fetch_assoc($result_max);
			
			if($rsc1[gen_id] != ""){ // �ʴ�����ժ��͹����к�����
					$sql_up = "UPDATE  hr_addhistoryname SET runno='1', kp7_active='1',daterec='".date("Y-m-d")."' WHERE runid='$rsc1[runid]' AND gen_id='$idcard' ";
					mysql_db_query($dbsite,$sql_up);
					$sql_up1 = "UPDATE hr_addhistoryname SET kp7_active='0'  WHERE gen_id='$idcard' AND daterec <> '".date("Y-m-d")."'";
					mysql_db_query($dbsite,$sql_up1);
			}else{
					if($rsm[maxid] == "1"){
						$max1 = $rsm[maxid] +1;
						$sql_up = "UPDATE hr_addhistoryname SET runno='$max1',daterec='".date("Y-m-d")."',kp7_active='0' WHERE gen_id='$idcard' AND runno='1'  ";
						mysql_db_query($dbsite,$sql_up);
					}
					if($rsm[minid] == "1"){
						$max1 = $rsm[maxid] +1;
						$sql_up = "UPDATE hr_addhistoryname SET runno='$max1',daterec='".date("Y-m-d")."',kp7_active='0' WHERE gen_id='$idcard' AND runno='1'  ";	
						mysql_db_query($dbsite,$sql_up);
					}
					
					$sql_insert = "INSERT INTO hr_addhistoryname SET gen_id='$idcard',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',runno='1',kp7_active='1',daterec='".date("Y-m-d")."'";	
					mysql_db_query($dbsite,$sql_insert);
			}
			
			
			
	}else{
		$sql_insert = "INSERT INTO hr_addhistoryname SET gen_id='$idcard',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',runno='1',kp7_active='1'";	
		mysql_db_query($dbsite,$sql_insert);
	}//end 	if($rsc[num1] > 0){
		
}//end function AddHistoryNameCmss($xsiteid,$idcard){
	
##############  function create profile �ͧࢵ��ù���Ң����� checklist
function CreateSiteProfile($sentsecid,$profile_id){
	global $dbnamemaster;
		$sql_config_area = "SELECT count(site) as num1 FROM eduarea_config WHERE site='$sentsecid' AND group_type='keydata' AND profile_id='$profile_id'";
		$result_config = mysql_db_query($dbnamemaster,$sql_config_area);
		$rscon = mysql_fetch_assoc($result_config);
			if($rscon[num1] < 1){
					$sql_up = "INSERT INTO eduarea_config SET site='$sentsecid', group_type='keydata',profile_id='$profile_id',timeupdate=NOW()";
					mysql_db_query($dbnamemaster,$sql_up);
					$sql_up1 = "UPDATE eduarea SET config_area='1' WHERE secid='$sentsecid'";
					mysql_db_query($dbnamemaster,$sql_up1);
			}

}//end function CreateSiteProfile($sentsecid,$profile_id){
	
###  ��Ǩ�ͺ����յ��ҧ㹺ѭ�չѺ������ѧ
function CheckTableName($siteid,$table_name){
		$dbsite = STR_PREFIX_DB.$siteid;
		$field_name = "Tables_in_".$dbsite;
		$sql = "SHOW TABLES WHERE $field_name='$table_name'";
		$result = @mysql_db_query($dbsite,$sql);
		$rs = @mysql_fetch_assoc($result);
		if($rs[$field_name] != ""){
			return 1;
		}else{
			return 0;	
		}
}//end function  CheckTableName($siteid,$table_name){
	

function CountDataInTable($siteid,$table_name){
	$dbsite = STR_PREFIX_DB.$siteid;
	$chid = CheckTableName($siteid,$table_name);
	if($chid > 0){ // �ʴ�����բ�����㹵�ҧ�������
			$sql_count = "SELECT COUNT(*) AS num1 FROM $table_name ";
			$result_count = mysql_db_query($dbsite,$sql_count);
			$rsc = mysql_fetch_assoc($result_count);
			return $rsc[num1];
	}else{
			return 0;	
	}//end if($chid > 0){
		
}//end function CountDataInTable(){
#####  �ӡ�����͡����������ش�ͧ�ѭ�չѺ���
function GetIdUpConfirm($siteid){
	$dbsite = STR_PREFIX_DB.$siteid;
	$sql = "SELECT
up_confirm_master.con_id_master
FROM `up_confirm_master`
WHERE con_status='1'
ORDER BY
con_year DESC ,con_budget DESC, con_dateconfirm DESC
LIMIT 0,1";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[con_id_master];
	
}//end function GetIdUpConfirm($siteid){


#######  function ���Ȩҡ�ӹ�˹�Ҫ���
function GetSexFromPrename(){
	global $dbnamemaster;
	$sql = "SELECT
prename_th.prename_th,
prename_th.sex
FROM `prename_th`
where prename_th.active='on'
group by prename_th.prename_th";	
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[prename_th]] = $rs[sex];
	}
	return $arr;
}// end function GetSexFromPrename(){
	
#### ʶҹС�õ�Ǩ�ͺ�����Ũҡ temp_general
function CheckidcardTempGeneral($idcard){
		global $dbnamemaster;
		$sql = "SELECT * FROM `temp_general` where status_tranfer='0' and status_data='1' and idcard='$idcard' ORDER BY profile_id DESC LIMIT 1";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[siteid];
}//end 


############  function ��Ǩ�ͺʶҹС���Ѻ�ͧ��ä�������Ţͧ��ѡ�ҹ����
function CheckKeyKp7($idcard,$profile_id){
		global $dbnameuse;
		$sql  = "SELECT userkey_wait_approve,approve  FROM `tbl_assign_key` WHERE idcard='$idcard' AND profile_id='$profile_id'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['key'] = $rs[userkey_wait_approve];
		$arr['approve'] = $rs[approve];
		return $arr;
}//end function CheckKeyKp7(){
	
###  ��Ǩ�ͺ�ѹ�����§ҹ�͡�������Ѻ�׹�͡���
function GetDateSendKp7($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_assign.date_assign,
tbl_checklist_assign.date_recive,
tbl_checklist_assign.date_recive_true,
tbl_checklist_assign_detail.status_sr_doc
FROM
tbl_checklist_assign
Inner Join tbl_checklist_assign_detail ON tbl_checklist_assign.ticketid = tbl_checklist_assign_detail.ticketid
WHERE
tbl_checklist_assign.activity_id =  '3' AND
tbl_checklist_assign_detail.idcard =  '$idcard'
AND tbl_checklist_assign.profile_id='$profile_id'
and assign_status='Y'";	
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['date_assign'] = GetDateThaiFull($rs[date_assign]);
	$arr['date_recive'] = GetDateThaiFull($rs[date_recive_true]);
	$arr['status_sr_doc'] = $rs[status_sr_doc];
	return $arr;
}// end function GetDateSendKp7($idcard,$profile_id){
	
### function GetTypeError
function GetTypeError(){
		global $dbname_temp;
		$sql = "SELECT * FROM tbl_checklist_check_errortype ";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[error_id]] = $rs[error_name];
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}//end function GetTypeError(){
	
############   function GetSchoolMathsiteid
function CheckSchoolMathSite($schoolid,$xsiteid){
		global $dbnamemaster;
		$sql = "SELECT COUNT(id) as num1 FROM allschool WHERE id='$schoolid' AND siteid='$xsiteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return intval($rs[num1]);
}//end function CheckSchoolMathSite(){
	
function GetNewCutPic($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT pic_num FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id' ";
	$result = mysql_db_query($dbname_temp,$sql)  or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	
	$sql_before = "SELECT pic_num FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id <> '$profile_id' ORDER BY profile_id DESC LIMIT 1";
	$result_b = mysql_db_query($dbname_temp,$sql_before) or die(mysql_error()."$sql_before<br>LINE::".__LINE__);
	$rsb = mysql_fetch_assoc($result_b);
	
	$new_pic = $rs[pic_num]-$rsb[pic_num]; // �ӹǹ�ٻ����
	
	### update ������
	if($new_pic > 0){
		$sql_update = "UPDATE tbl_checklist_kp7 SET pic_num_new_cut='$new_pic'  WHERE idcard='$idcard' AND profile_id='$profile_id' ";
		mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE::".__LINE__);
	}// end 	if($new_pic > 0){
	
}// end function GetNewCutPic($idcard,$profile_id){
	
#### function 㹡�� update ʶҹ�ࢵ����ա�ä������������
function UpdateKeydataActive($siteid,$profile_id){
		global $dbnamemaster;
		$sql = "UPDATE eduarea_config SET keydata_active='1' WHERE site='$siteid' AND group_type='keydata' AND profile_id='$profile_id'";
		mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
}//end function UpdateKeydataActive(){
	
#####################  log 㹡��ź������ #############################

function SaveLogChecklistFalse($idcard,$siteid,$profile_id,$subject,$action){
	global $dbname_temp;
	$ip = get_real_ip();	 // ip ����ͧ import
	$sql = "INSERT INTO log_checklist SET idcard='$idcard',siteid='$siteid',profile_id='$profile_id',ip_server='$ip',staffid='".$_SESSION['session_staffid']."',subject='$subject',action='$action',timeupdate=NOW()";
	$result= mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		
}//end function SaveLogChecklistFalse($idcard,$siteid,$profile_id,$subject,$action){
	
	
#############  ��Ǩ�ͺ 48 ࢵ�����ͧ
function GetDataAreaFirst(){
	global $dbname_temp,$dbnamemaster,$report_id48;
	$sql = "SELECT COUNT(*) AS num1 FROM tbl_checklist_report WHERE report_id='$report_id48' AND status_all='0'";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	if($rs[num1] > 0){
			$sql1 = "SELECT siteid FROM tbl_edubkk_profile_new WHERE report_id='$report_id48'";
			$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
			while($rs1 = mysql_fetch_assoc($result1)){
					$arr[$rs1[siteid]] = $rs1[siteid];
			}
	}else{
			$sql2 = "SELECT secid FROM eduarea WHERE secid NOT LIKE '99%'";	
			$result2 = mysql_db_query($dbnamemaster,$sql2) or die(mysql_error()."$sql2<br>__LINE".__LINE__);
			while($rs2 = mysql_fetch_assoc($result2)){
					$arr[$rs2[secid]] = $rs2[secid];
			}//end while($rs2 = mysql_fetch_assoc($result2)){
	}
		return $arr;
}// end function GetDataAreaFirst(){
	
###  funciton Get schoolname FROM area #########################
function GetArraySchoolName($siteid){
	global $dbnamemaster;
	$sql = "SELECT id,office,prefix_name FROM allschool WHERE siteid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[id]] = $rs[prefix_name].$rs[office];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetArraySchoolName(){
	
####  function �ʴ��ӹǹ�����ŷ�� error
function GetDataFieldDataNoComplete($profile_id){
		global $dbname_temp,$condition_data;
		$sql = "SELECT Count(idcard) AS numflase,siteid FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' $condition_data GROUP BY siteid ";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[numflase];
		}
		return $arr;
}//end function GetDataFieldDataNoComplete($profile_id){
	
####  ��Ǩ�ͺ������� cmss 000 ���͢�����㹰ҹ��ҧ��͹����բ������������������ͷ�����֧�����ŷ���¤������ǡ�Ѻ���ա����
function CheckNumCmssCenter($idcard,$siteid="0000"){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql = "SELECT COUNT(idcard) AS numid  FROM general WHERE idcard='$idcard' group by idcard";
		$result = mysql_db_query($db_site,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
}//end function CheckNumCmssCenter(){
	
function CountSalaryInsite($siteid,$idcard){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql = "SELECT COUNT(id) as num1 FROM salary WHERE id='$idcard' GROUP BY id";
		$result = mysql_db_query($db_site,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}//end function CountSalaryInsite(){
	
#########  function ��ҧ��ҵ��˹�� checklist ����������ѹ��Ѻ���˹�� hr_addposition_now
function CleanPositionChecklistNoMath($siteid,$profile_id){
	global $dbname_temp,$dbnamemaster;
	$sql = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t2.`position`
FROM
$dbname_temp.tbl_checklist_kp7 as t1
Left Join $dbnamemaster.hr_addposition_now as t2 ON t1.position_now = t2.`position`
where t2.`position` is null and siteid='$siteid' and profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql_update = "UPDATE  tbl_checklist_kp7 SET position_now='' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
			$sql_update2 = "UPDATE tbl_check_data SET position_now='' WHERE idcard='$rs[idcard]' AND secid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
			mysql_db_query($dbname_temp,$sql_update2) or die(mysql_error()."$sql_update2<br>LINE__".__LINE__);
	}//end while($rs = mysql_fetch_assoc($result)){
	#############  ������˹��§ҹ
	
			$sql2 = "SELECT
		t1.idcard,
		t1.profile_id,
		t1.siteid,
		t1.prename_th,
		t1.name_th,
		t1.surname_th,
		t1.position_now,
		t1.schoolid,
		t2.id,
		t2.office
		FROM
		edubkk_checklist.tbl_checklist_kp7 as t1
		Left Join edubkk_master.allschool as t2 ON t1.schoolid = t2.id and t2.siteid='$siteid'
		where t2.`id` is null and t1.siteid='$siteid' 
		and t1.profile_id='$profile_id'";
		$result2 = mysql_db_query($dbname_temp,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
		while($rs2 = mysql_fetch_assoc($result2)){
			$sql_up2 = "UPDATE tbl_checklist_kp7 SET schoolid='' WHERE idcard='$rs2[idcard]' AND profile_id='$rs2[profile_id]' AND siteid='$rs2[siteid]' ";
			$sql_up3 = "UPDATE tbl_check_data SET schoolid='' WHERE idcard='$rs2[idcard]' AND profile_id='$rs2[profile_id]' AND secid='$rs2[siteid]' ";
			mysql_db_query($dbname_temp,$sql_up2) or die(mysql_error()."$sql_up2<br>LINE__".__LINE__);
				
		}//end while($rs2 = mysql_fetch_assoc($result2)){
}
	
	
########################  log ����Ң����Ũҡ checklist ��� cmss
function InsertLogImpChecklistToCmss($siteid,$user_import){
	global $dbname_temp;	
	$ip = get_real_ip();
	$sql = "INSERT INTO log_import_cmss SET siteid='$siteid',user_import='$user_import',server_ip='$ip'";
	mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$last_id = mysql_insert_id();
	return $last_id;
}// end function InsertLogImpChecklistToCmss(){
	
#### 
function InsertLogImpDetail($import_id,$idcard,$siteid,$profile_id,$prename_th,$name_th,$surname_th,$schoolid,$position_now,$siteid_replace,$status_replace_sitecon){
		global $dbname_temp;
		$sql = "INSERT INTO log_import_edubkk_detail SET import_id='$import_id',idcard='$idcard',siteid='$siteid',profile_id='$profile_id',prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',schoolid='$schoolid',position_now='$position_now',siteid_replace='$siteid_replace',status_replace_sitecon='$status_replace_sitecon'";
		mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
}//end function InsertLogImpDetail(){
	
	
#### function ������ࢵ����ͧ
function GetSiteContinute(){
	global $dbnameuse;
	$sql = "SELECT
t1.site_area as siteid
FROM
keystaff AS t1
where t1.site_area > 0
group by t1.site_area";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arrsite[$rs[siteid]] = $rs[siteid];
	}
	return $arrsite;
}//end function GetSiteContinute(){


function gen_pivatekey($length= 4, $chars = '1234567890'){
    // Length of character list
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};
    // Generate random string
   for ($i = 1; $i < $length; $i = strlen($string)){
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }//end   for ($i = 1; $i < $length; $i = strlen($string)){
    return $string;
}//end function gen_pivatekey($length = 4, $chars = '1234567890'){



?>