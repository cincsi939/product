<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epm.inc.php");
include("function_face2cmss.php");

$yyconfig = "2009";


$year_c = date("Y"); // �ջѨ�غѹ㹡�ä��բ�����
$arrdate_holiday = GetHolidayStaffAll($year_c);
if(count($arrdate_holiday) > 0){
	foreach($arrdate_holiday as $key => $val){
			if($in_date1 > "") $in_date1 .= ",";
			$in_date1 .= "'$key'";
	}//end foreach($arrdate_holiday as $key => $val){
}// end if(count($arrdate_holiday) > 0){

ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
//echo "<font color='red'><center>�����¡��ѧ��Ѻ��ا����� ����ҳ  30 �ҷ� </center></font>";die;

$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");

function ShowDateTime1($get_date){
	global $monthFull;
	if($get_date != "" and $get_date != "0000-00-00 00:00:00"){
		$arr1 = explode(" ",$get_date);
		$arr2 = explode("-",$arr1[0]);
		return intval($arr2[2])." ".$monthFull[intval($arr2[1])]." ".($arr2[0]+543)." ���� ".$arr1[1];
	}//end 		if($get_date != "" and $get_date != "0000-00-00 00:00:00";){
}//end function ShowDateTime1($get_date){


$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "B";}
			else if($get_group == "3"){ return "C";}
	}

$array_day = array("1"=>"�.","2"=>"�.","3"=>"�.","4"=>"��.","5"=>"�.","6"=>"�.");
/*
echo "<pre>";
print_r($_POST);
*/

//$get_date = "2010-03-01";	
function ShowDayOfMonth($get_month){
	$arr_d1 = explode("-",$get_month);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // �ѹ�������
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // �ѹ����ش���¢ͧ��͹
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�		
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
}//end function ShowDayOfMonth($get_month){
//$xarr = ShowDayOfMonth("2010-04-01");
//echo "<pre>";
//print_r($xarr);


function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		//$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		$sql = "SELECT count(idcard) as numid FROM `monitor_keyin` where staffid='$get_staffid' and timeupdate LIKE '$get_date%'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
		
}

function CheckQCPerDay($get_staff,$get_date){
global $db_name;
$sql1 = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' and datecal LIKE '$get_date%'  group by idcard;";
$result1 = mysql_db_query($db_name,$sql1);
$numr1 = @mysql_num_rows($result1);
return $numr1;
//$rs1 = mysql_fetch_assoc($result1);
//return $rs1[num1];
	
}

### �ѹ�֡������ŧ㹵��ҧ temp 
function SaveStatQc($get_staff,$get_date){
		global $db_name;
		$numkey = ShowKeyPerson($get_staff,$get_date); // �ӹǹ�ش���������������ѹ
		$numqc = CheckQCPerDay($get_staff,$get_date); // �ӹǹ�ش��� QC
		$sql_save = "REPLACE INTO temp_check_qc(datekeyin,staffid,numkey,numqc)VALUES('$get_date','$get_staff','$numkey','$numqc')";
		//echo $sql_save."<br>";
		 mysql_db_query($db_name,$sql_save);
		
}//end function SaveStatQc($get_staff,$get_date){
	
	
function AlertQC($get_staff,$get_yymm){
		global $db_name;
		$Rpoint = ShowRpoint($get_staff);
		$sql = "SELECT * FROM temp_check_qc WHERE staffid='$get_staff' AND datekeyin LIKE '$get_yymm%' ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$numk = 0;
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
				if($j==0){ // ��˹��ѹ����������
					$date_start = $rs[datekeyin];
				}
				
				$numk += $rs[numkey];
				if($numk >= $Rpoint){   // �ó��ʹ�������Թ������ ����Ǩ�ͺ��� QC
					
					if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){ // 5hk
						$arrDQc[$rs[datekeyin]] = "Y";
					}else{
						$arrDQc[$rs[datekeyin]] = "N";
					}//if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){
					//$numk = 0; // ��˹������ɨҡ��� QC
					$numk = $numk-$Rpoint;
					$j=0;
				}else{ 
					$j++;
				} // e   // �ó��ʹ�������Թ������ ����Ǩ�ͺ��� QC
			
		}//end while($rs = mysql_fetch_assoc($result)){
			//echo "<pre>";
			//print_r($arrDQc);
			return $arrDQc;
}//end function AlertQC($get_staff,$get_yymm){
####  funciton �Ѻ�ӹǹ��¡����¡��
function  CountNumQC($flag_id,$staffid){
	global $dbnameuse;
	$sql = "SELECT count(flag_qc) as numqc FROM stat_user_keyperson WHERE flag_qc='$flag_id' AND staffid='$staffid' and flag_qc <> '0' ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numqc];
}

	
function AlertQcMark($get_flagid,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT count(idcard) as num1 FROM `stat_user_keyperson` WHERE stat_user_keyperson.status_random_qc =  '1' AND
stat_user_keyperson.staffid =  '$get_staffid' AND stat_user_keyperson.flag_qc =  '$get_flagid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
	
}//end function AlertQcMark(){
	
function xCheckUserKey($get_idcard,$get_siteid,$get_staffid,$get_fullname){
	global $db_name,$in_date1;
	$db_site = STR_PREFIX_DB.$get_siteid;
	if($in_date1 != ""){
			$conv = " AND date(log_update.logtime) NOT IN($in_date1)";
	}else{
			$conv = "";	
	}
	
	##and user_ip LIKE '192.168.%'
	$sql1 = "SELECT
min(log_update.logtime) as mintime,
max(log_update.logtime) as maxtime,
log_update.username,
date(log_update.logtime) as date1,
log_update.subject,
log_update.user_ip,
log_update.staff_login,
log_update.action
FROM `log_update`
where username='$get_idcard'   $conv
group by date1";
$result1 = mysql_db_query($db_site,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
				$arr_d2 = explode("-",$rs1[date1]);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] != 0){ // ��Ǩ�ͺ�ó�������ѹ��ش����ѹ�ҷԵ��
				 	$sql_intsert_log = "REPLACE INTO log_report_userkey SET staffid='$get_staffid', idcard='$rs1[username]', fullname='$get_fullname',siteid='$get_siteid',staff_login='$rs1[staff_login]',start_time='$rs1[mintime]',end_time='$rs1[maxtime]' ";
					mysql_db_query($db_name,$sql_intsert_log) or die(mysql_error()."<br>$sql_intsert_log<br>LINE__".__LINE__);
				 }// end  if($xFTime['wday'] == 0){ 		
	}//end while($rs1 = mysql_fetch_assoc($result1)){	
}//end function xCheckUserKey($get_idcard){
	
######### ###################  �����żŵ�Ǩ�ͺ������
if($action == "process"){
	
		if($in_date1 != ""){
			$conv = " AND date(monitor_keyin.timeupdate) NOT IN($in_date1) AND date(monitor_keyin.timestamp_key) NOT IN($in_date1)";
	}else{
			$conv = "";	
	}

	//global $db_name;
$sql = "SELECT
keystaff.staffname,
keystaff.staffsurname,
monitor_keyin.staffid,
monitor_keyin.idcard,
monitor_keyin.keyin_name,
monitor_keyin.siteid,
date(monitor_keyin.timeupdate) as date1,
date(monitor_keyin.timestamp_key) as date2
FROM
keystaff
Inner Join monitor_keyin ON keystaff.staffid = monitor_keyin.staffid
WHERE
keystaff.sapphireoffice =  '2' AND
keystaff.status_permit =  'YES'
AND(( time(monitor_keyin.timeupdate) BETWEEN '09:00:00' AND '18:00:00') OR (time(monitor_keyin.timestamp_key) BETWEEN '09:00:00' AND '18:00:00'))
AND monitor_keyin.timeupdate LIKE '$year_c%' $conv
group by monitor_keyin.idcard
order by monitor_keyin.staffid ASC";

$result = mysql_db_query($db_name,$sql) or die(mysql_error()."<br>$sql<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	 xCheckUserKey($rs[idcard],$rs[siteid],$rs[staffid],$rs[keyin_name]);	 // �� log �ѹ�֡�����š�͹		
}//end while($rs = mysql_fetch_assoc($result)){	
echo "<script>alert('�����żŢ��������º��������'); location.href='report_check_userkeydata.php?action=';</script>";
exit;

}//end if($action == "process"){


function CountUserKey(){
	global $db_name;
	$sql = "SELECT COUNT(idcard) as num1,staffid FROM log_report_userkey WHERE  staffid=staff_login GROUP BY staffid";	
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr_staff[$rs[staffid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr_staff;
}//end function CountUserKey(){
	
function CountUserKey1(){
	global $db_name;
	$sql = "SELECT COUNT(idcard) as num1,staffid FROM log_report_userkey WHERE  staffid <> staff_login and  staff_login<>''  GROUP BY staffid";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr_staff1[$rs[staffid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr_staff1;
}//end function CountUserKey1(){
	
function xCountUserKey(){
	global $db_name;
	$sql = "SELECT COUNT(idcard) as num1,staffid FROM log_report_userkey WHERE  staffid=staff_login GROUP BY staffid";	
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr_staff[$rs[staffid]] = $rs[staffid];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr_staff;
}//end function CountUserKey(){
	
function xCountUserKey1(){
	global $db_name;
	$sql = "SELECT COUNT(idcard) as num1,staffid FROM log_report_userkey WHERE  staffid <> staff_login and  staff_login<>''  GROUP BY staffid";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr_staff1[$rs[staffid]] = $rs[staffid];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr_staff1;
}//end function CountUserKey1(){


function ShowUserKey($get_staff){
		global $db_name;
		$sql = "SELECT prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staff'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname] $rs[staffsurname]";
}

function ShowMaxMinDate($get_staff){
		global $db_name,$yyconfig;
		$sql = "SELECT min(start_time) as mintime,max(end_time) as maxtime FROM log_report_userkey WHERE  staffid='$get_staff' and start_time NOT LIKE '$yyconfig%' ";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr_time['mintime'] = $rs[mintime];
		$arr_time['maxtime'] = $rs[maxtime];
		return $arr_time;
}

function ShowXarea($xsiteid){
	global $dbnamemaster;	
	$sql = "SELECT secname FROM eduarea WHERE secid='$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[secname];
}

function CountKeyNum($get_siteid,$get_staffid,$xtype,$get_idcard){
	global $in_date1;
	if($in_date1 != ""){
			$conv = " AND date(log_update.logtime) NOT IN($in_date1) ";
	}else{
			$conv = "";	
	}

	
	$db_site = STR_PREFIX_DB.$get_siteid;
	if($xtype == "1"){
		$sql = "SELECT count(username) as num1 FROM log_update WHERE username='$get_idcard' AND staff_login='$get_staffid' $conv";	
	}else{
		$sql = "SELECT count(username) as num1  FROM log_update WHERE username='$get_idcard'  AND staff_login<>'$get_staffid'  $conv AND staff_login <> '' AND staff_login IS NOT NULL";
	}
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CountKeyNum($get_siteid,$get_staffid,$xtype,$get_idcard){
	
#####
function GroupCountKeyNum($get_siteid,$get_staffid,$xtype,$get_idcard){
	global $in_date1;
	if($in_date1 != ""){
			$conv = " AND date(log_update.logtime) NOT IN($in_date1) ";
	}else{
			$conv = "";	
	}


	$db_site = STR_PREFIX_DB.$get_siteid;
	if($xtype == "1"){
		$sql = "SELECT * FROM log_update WHERE username='$get_idcard' AND  staff_login='$get_staffid' $conv";	
	}else{
		$sql = "SELECT *  FROM log_update WHERE username='$get_idcard' $conv AND  staff_login<>'$get_staffid' AND staff_login <> '' AND staff_login IS NOT NULL";
	}
	$result = mysql_db_query($db_site,$sql);
	while($rs = mysql_fetch_assoc($result)){
		
				if($rs[action] == "login" or $rs[action] == "loginadmin"){
					$arr1['login'] += 1;
				}else if($rs[action] == "view"){
					$arr1['view'] += 1;
				}else{
					$arr1['edit'] += 1;
				}
			
	}//end 	while($rs = mysql_fetch_assoc($result)){
	return $arr1;
}//end function CountKeyNum($get_siteid,$get_staffid,$xtype,$get_idcard){

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>��§ҹ��Ǩ�ͺ��� QC</title>

<link href="../../common/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F90;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
<? if($action == ""){?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" bgcolor="#D4D4D4"><a href="?action=process">���꡻����żŵ�Ǩ�ͺ��úѹ�֡������</a></td>
        </tr><tr>
          <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="center" bgcolor="#D4D4D4"><strong>��§ҹ��ѡ�ҹ��������ŷ��������ҧҹ����令�������ŷ���� Subcontact </strong></td>
              </tr>
            <tr>
              <td width="5%" align="center" bgcolor="#D4D4D4"><strong>�ӴѺ</strong></td>
              <td width="23%" align="center" bgcolor="#D4D4D4"><strong>��ѡ�ҹ���������</strong></td>
              <td width="14%" align="center" bgcolor="#D4D4D4"><strong>�ӹǹ����� user <br />
                ����ͧ�ѹ�֡������</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>�ӹǹ����� user ���<br />
                �ѹ�֡������</strong></td>
              <td width="23%" align="center" bgcolor="#D4D4D4"><strong>����������ѹ�֡������</strong></td>
              <td width="19%" align="center" bgcolor="#D4D4D4"><strong>��������ش�ѹ�֡������</strong></td>
            </tr>
            <?
			$arr_num = CountUserKey();
			$arr_num1 = CountUserKey1();
			
			$xarr_num = xCountUserKey();
			$xarr_num1 = xCountUserKey1();
			//echo "<pre>";
			//print_r($arr_num);
			$arr_merge = array_merge($xarr_num,$xarr_num1);
			//echo "<pre>";
			//print_r($arr_merge);
            if(count($arr_merge) > 0){
				$ii=0;
				foreach($arr_merge as $key => $val){
				
						if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
						$arr_time = ShowMaxMinDate($val);
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$ii?></td>
              <td align="left"><?=ShowUserKey($val);?></td>
              <td align="center"><? if($arr_num[$val] > 0){ echo "<a href='?action=view&staffid=$val&xtype=1'>$arr_num[$val]</a>"; }else{ echo "";}?></td>
              <td align="center"><? if($arr_num1[$val] > 0){ echo "<a href='?action=view&staffid=$val&xtype=2'>$arr_num1[$val]</a>";}else{ echo "";}?></td>
              <td align="left"><?=ShowDateTime1($arr_time['mintime'])?></td>
              <td align="left"><?=ShowDateTime1($arr_time['maxtime'])?></td>
            </tr>
            <?
				}//end foreach($arr_merge as $key => $val){
			}//end      if(count($arr_merge) > 0){
			?>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
</table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
  <?
	}//end 
	else if($action == "view"){
		if($xtype == "1"){ 
			$xtitle = "��¡�úؤ�ҡ÷�边ѡ�ҹ�ѹ�֡����������ҧҹ";
			//$sql = "SELECT * FROM log_report_userkey WHERE  staffid=staff_login AND staffid='$staffid' ORDER BY siteid ASC";
			$sql = "SELECT
t1.staffid,
t1.idcard,
t1.fullname,
t1.siteid,
t1.staff_login,
t1.start_time,
t1.end_time,
t2.ticketid
FROM
log_report_userkey as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
where t1.staffid=t1.staff_login AND t1.staffid='$staffid' ORDER BY t1.start_time ASC";
		
		}else{
			//$sql = "SELECT *  FROM log_report_userkey WHERE  staffid<>staff_login AND  staff_login <> '' AND staffid='$staffid' ORDER BY siteid ASC";
			$sql = "SELECT
t1.staffid,
t1.idcard,
t1.fullname,
t1.siteid,
t1.staff_login,
t1.start_time,
t1.end_time,
t2.ticketid
FROM
log_report_userkey as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
where t1.staffid<>t1.staff_login AND  t1.staff_login <> '' and  t1.staffid='$staffid' ORDER BY t1.start_time ASC";
			
			$xtitle = "��§ҹ�ӹǹ�ؤ�ҡ÷���� user �������Һѹ�֡������";
		}
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="12" align="center" bgcolor="#D4D4D4"><strong><a href="?action=">��͹��Ѻ</a> ::: <? echo $xtitle;?> �ͧ ��ѡ�ҹ���������  <?=ShowUserKey($staffid);?></strong></td>
        </tr>
        <tr>
          <td width="3%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>�ӴѺ</strong></td>
          <td width="11%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>㺧ҹ</strong></td>
          <td width="9%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>�ѵû�ЪҪ�</strong></td>
          <td width="13%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>���� - ���ʡ��</strong></td>
          <td width="9%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ࢵ��鹷�����֡��</strong></td>
          <td width="8%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>���ҷ��ѹ�֡<br />
          ������</strong></td>
          <td width="8%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>�����͡<br />
          �ҡ�к�</strong></td>
          <td colspan="4" align="center" bgcolor="#D4D4D4"><strong>�ӹǹ��¡��</strong></td>
          <td width="9%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>use r����� login</strong></td>
        </tr>
        <tr>
          <td width="6%" align="center" bgcolor="#D4D4D4"><strong>�������к�</strong></td>
          <td width="7%" align="center" bgcolor="#D4D4D4"><strong>�٢�����</strong></td>
          <td width="9%" align="center" bgcolor="#D4D4D4"><strong>����ź���<br />
          ������</strong></td>
          <td width="8%" align="center" bgcolor="#D4D4D4"><strong>���</strong></td>
        </tr>
        <?
		//echo $sql;
        	$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$arr2 = GroupCountKeyNum($rs[siteid],$staffid,$xtype,$rs[idcard]);
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="left" nowrap="nowrap"><?=$rs[ticketid]?></td>
          <td align="left"><? echo "<a href='?action=view_detail&idcard=$rs[idcard]&xsiteid=$rs[siteid]&staffid=$staffid&xtype=$xtype&fullname=$rs[fullname]' target='_blank'>$rs[idcard]</a>";?></td>
          <td align="left"><?=$rs[fullname]?></td>
          <td align="left"><?=ShowXarea($rs[siteid]);?></td>
          <td align="left"><?=ShowDateTime1($rs[start_time]);?></td>
          <td align="center"><?=ShowDateTime1($rs[end_time]);?></td>
          <td align="center"><?=$arr2['login']?></td>
          <td align="center"><?=$arr2['view']?></td>
          <td align="center"><?=$arr2['edit']?></td>
          <td align="center"><?=CountKeyNum($rs[siteid],$staffid,$xtype,$rs[idcard]);?></td>
          <td align="left"><?=ShowUserKey($rs[staff_login]);?></td>
        </tr>
        <?
			}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
<?
	}//end if($action == "view"){
	else if($action == "view_detail"){
		$db_site = STR_PREFIX_DB.$xsiteid;

	if($in_date1 != ""){
			$conv = " AND date(log_update.logtime) NOT IN($in_date1) ";
	}else{
			$conv = "";	
	}
		
		
		if($xtype == "1"){
			$sql = "SELECT * FROM log_update WHERE username='$idcard' $conv AND staff_login='$staffid' ORDER BY updatetime ASC";	
		}else{
			$sql = "SELECT * FROM log_update WHERE username='$idcard' $conv  AND staff_login<>'$staffid' AND staff_login <> '' AND staff_login IS NOT NULL ORDER BY updatetime ASC";	
		}
			
	
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5" align="center" bgcolor="#D4D4D4"><strong>���ʺѵ� :
            <?=$idcard?> ���� ���ʡ�� : <?=$fullname?> 
            &nbsp;��ѡ�ҹ��������� <?=ShowUserKey($staffid);?>
          </strong></td>
        </tr>
        <tr>
          <td width="4%" align="center" bgcolor="#D4D4D4"><strong>�ӴѺ</strong></td>
          <td width="20%" align="center" bgcolor="#D4D4D4"><strong>��Ǵ��¡�÷��ѹ�֡</strong></td>
          <td width="19%" align="center" bgcolor="#D4D4D4"><strong>�Ը���Ҷ֧������</strong></td>
          <td width="21%" align="center" bgcolor="#D4D4D4"><strong>ip ����ͧ���ѹ�֡������</strong></td>
          <td width="36%" align="center" bgcolor="#D4D4D4"><strong>���Һѹ�֡������</strong></td>
        </tr>
        <?
        	$result = mysql_db_query($db_site,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				
				if($rs[action] == "login" or $rs[action] == "loginadmin"){
					$txt_action = "�������к�";
				}else if($rs[action] == "view"){
					$txt_action = "��Ҵ٢�����";
				}else{
					$txt_action = "����/ź/��� ������";	
				}
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="left"><?=$rs[subject]?></td>
          <td align="left"><?=$txt_action?></td>
          <td align="left"><?=$rs[user_ip]?></td>
          <td align="left"><?=ShowDateTime1($rs[logtime]);?></td>
        </tr>
        <?
			}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
<?
	}//end else if($action == "view_detail"){
  ?>
</body>
</html>
