<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		��§ҹ��úѹ�֡������
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");

if($profile_id ==""){ // �óշ����������͡����������
		$profile_id = LastProfile();
}


function Datediff($datefrom,$dateto){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        $differnce = $startDate - $lastDate;
        $differnce = ($differnce / (60*60*24)); //�ó׷���ͧ������ return ������ѹ�Ф�Ѻ
        return $differnce;
      } // end function Datediff($datefrom,$dateto){

//$alert_file = 50;
$temp_d = "2009-06-01";
$temp_d1 = "2009-08-31";
$date_total = Datediff($temp_d1,$temp_d);
$temp_dc = date("Y-m-d");
$date_total_c = Datediff($temp_dc,$temp_d);


function search_ticket($get_siteid){
	global $db_name,$profile_id;
$sql = "SELECT keystaff.prename, keystaff.staffname, keystaff.staffsurname, tbl_assign_sub.ticketid,
tbl_assign_sub.recive_date,".DB_USERENTRY.".tbl_assign_key.idcard
FROM ".DB_USERENTRY.".keystaff
Inner Join ".DB_USERENTRY.".tbl_assign_sub ON ".DB_USERENTRY.".keystaff.staffid = ".DB_USERENTRY.".tbl_assign_sub.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
WHERE ".DB_USERENTRY.".tbl_assign_key.siteid =  '$get_siteid' AND ".DB_USERENTRY.".tbl_assign_sub.nonactive =  '0' AND ".DB_USERENTRY.".tbl_assign_key.profile_id='$profile_id'";
//echo $db_name,$sql;
$result = mysql_db_query($db_name,$sql);
while($rs = mysql_fetch_assoc($result)){
	$arrname[$rs[idcard]] = "$rs[staffname]  $rs[staffsurname]<br>$rs[ticketid] <br> �ѹ��� ".(thai_date($rs[recive_date]));
}
return $arrname;
}

function search_null_ticket($idcard){
	global $db_name,$profile_id;
$sql = "SELECT COUNT(idcard) AS num1 FROM
tbl_assign_key
Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_key.idcard =  '$idcard'
AND tbl_assign_key.nonactive='0' AND tbl_assign_key.profile_id='$profile_id'
GROUP BY idcard";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
if($rs[num1] < 1){
	return "�����͡";
}
	return "";
}


function count_all($xsecid){ // function �ӹǳ�Ҩӹǹ������
global $dbnamemaster;
	$sql = "SELECT COUNT(secid) AS num FROM log_pdf_check WHERE secid='$xsecid' group by secid";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
} // end function count_all($xsecid){ 

function count_file_pdf($xsecid){ // �Ѻ�ӹǹ��� pdf ��� up �����к�
	global $dbnamemaster;
	$sql1 = "SELECT COUNT(secid) AS num1 FROM  log_pdf  WHERE  secid='$xsecid' group by secid";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[num1];
}// end function count_file_pdf($xsecid){ // �Ѻ�ӹǹ��� pdf ��� up �����к�

function count_qc_pass1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '2' AND tbl_assign_key.siteid =  '$siteid' AND tbl_assign_key.profile_id='$profile_id' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' group by tbl_assign_key.siteid ";
//echo $sql;
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){

function count_qc1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid Inner Join  ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype'  AND tbl_assign_key.approve =  '3' AND tbl_assign_key.siteid =  '$siteid' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' AND tbl_assign_key.profile_id='$profile_id' group by tbl_assign_key.siteid";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_wait1($siteid,$xtype){
global $db_name,$profile_id;
$sql = "SELECT COUNT(tbl_assign_key.siteid) AS num1 FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid  Inner Join   ".DB_CHECKLIST.".tbl_check_data ON  ".DB_CHECKLIST.".tbl_check_data.idcard=tbl_assign_key.idcard  WHERE keystaff.sapphireoffice =  '$xtype' AND (tbl_assign_key.approve =  '0' or tbl_assign_key.approve = '1') AND tbl_assign_key.siteid =  '$siteid' AND tbl_assign_key.profile_id='$profile_id' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' GROUP BY  tbl_assign_key.siteid";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
}// end function count_qc_pass1(){


function count_area_all($xsecid){
global $db_name,$profile_id;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$xsecid' AND profile_id='$profile_id'  group by secid";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


function count_area_all_dis($xsecid){
global $db_name,$profile_id;
		$sql = "SELECT COUNT(secid) AS num1 FROM tbl_check_data  WHERE secid = '$xsecid' AND profile_id='$profile_id' group by secid";
		$result = mysql_db_query(DB_CHECKLIST,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}


function count_key_pass($xsecid){
	global $db_name,$profile_id;
	$sql ="SELECT  count(
 ".DB_CHECKLIST.".tbl_check_data.idcard) as num1
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE ".DB_USERENTRY.".tbl_assign_key.approve =  '2' AND ".DB_USERENTRY.".tbl_assign_key.nonactive='0' AND 
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND ".DB_USERENTRY.".tbl_assign_key='$profile_id' 
AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id'
group by  ".DB_CHECKLIST.".tbl_check_data.secid ";
	$result  = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

function id_in_kp7file($xsecid){
global $dbnamemaster,$db_name;
	$sql = "SELECT * FROM log_pdf  WHERE secid='$xsecid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($temp_id > "") $temp_id .= ","; 
			$temp_id .= "'$rs[idcard]'";
	}// end 	while($rs = mysql_fetch_assoc($result)){
 return $temp_id;
}// end function id_in_kp7file($xsecid){


function count_null_pdf($xsecid){ // �ѧ���蹹ѹ�ӹǹ������������� �.�.7 �鹩�Ѻ
global $profile_id;
	$temp_id = id_in_kp7file($xsecid);
	if($temp_id != ""){ $temp_id = $temp_id;}else{ $temp_id = "''";}
	$sql_count = "SELECT COUNT(idcard) AS num1  FROM tbl_check_data  WHERE secid='$xsecid' AND idcard  NOT IN ($temp_id) and profile_id='$profile_id'  group by secid";
	$result_count = mysql_db_query(DB_CHECKLIST,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
		return  $rs_c[num1];
}// end function count_null_pdf($xsecid){ // �ѧ���蹹ѹ�ӹǹ������������� �.�.7 �鹩�Ѻ

function count_pdf_fail($xsecid){// �Ѻ�ӹǹ����͡��÷���������ó�
	global $dbnamemaster;
	$sql = "SELECT COUNT(secid) num1 FROM log_pdf  WHERE  secid='$xsecid' and status_file ='0' group by secid";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function count_pdf_fail(){// �Ѻ�ӹǹ����͡��÷���������ó�
$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // ���ʢͧ���


## ��Ǩ�ͺ ������������ó�
function check_file_fail($idcard,$xsecid){
global $dbnamemaster;
	$sql_check_file = "SELECT COUNT(idcard) AS num1 FROM log_pdf   WHERE idcard='$idcard' AND status_file='0' AND secid='$xsecid' group by secid";
	//echo $sql_check_file."<br>$dbnamemaster";
	$result_check_file = mysql_db_query($dbnamemaster,$sql_check_file);
	$rs_c = mysql_fetch_assoc($result_check_file);
	return $rs_c[num1];
}// end function check_file_fail(){

#######  �Ѻ�ӹǹ��¡�÷���Ѻ�ͧ�����������ºؤ�ҡ��ࢵ������ҵ��
function count_person_approve($siteid){
$dbsite = STR_PREFIX_DB.$siteid;
	$sql_app = "SELECT count($dbsite.general.idcard) as num FROM  ".DB_CHECKLIST.".tbl_check_data Inner Join $dbsite.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $dbsite.general.idcard
WHERE
$dbsite.general.approve_status =  'approve' AND
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$siteid' group by  ".DB_CHECKLIST.".tbl_check_data.secid ";
//echo $sql_app." ::  ".$dbsite;
$result_app = @mysql_db_query($dbsite,$sql_app);
$rs_app = @mysql_fetch_assoc($result_app);
return $rs_app[num];
}// end function count_person_approve(){
	
## �Ѻ�ӹǹ����ա�ù���Ң���������
function CountPersonImp(){
	global $db_temp,$profile_id;
	$sql = "SELECT COUNT(tbl_checklist_kp7.idcard) AS NumAll, SUM(tbl_checklist_kp7.page_num) AS NumPage,
SUM(if(tbl_checklist_kp7.page_upload > 0 and tbl_checklist_kp7.page_upload  IS NOT NULL,1,0)) AS NumFileUpload,
SUM(if(tbl_checklist_kp7.page_upload < 1 OR tbl_checklist_kp7.page_upload  IS NULL,1,0)) AS NumNotFile,
tbl_checklist_kp7.siteid
FROM tbl_checklist_kp7  WHERE tbl_checklist_kp7.profile_id='$profile_id' GROUP BY siteid";	
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['NumAll'] = $rs[NumAll];
			$arr[$rs[siteid]]['NumPage'] = $rs[NumPage];
			$arr[$rs[siteid]]['NumFileUpload'] = $rs[NumFileUpload];
			$arr[$rs[siteid]]['NumNotFile'] = $rs[NumNotFile];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function CountPersonImp(){
	
### funciton ��Ǩ�Ѻ��ä���ҹ��С���Ѻ�ͧ�����١��ͧ
function CountKey(){
	global $db_name,$profile_id;
	$sql_count = "SELECT
Sum(if(t4.sapphireoffice ='1' AND t2.approve='2',1,0)) AS NumSapphireQcPass,
Sum(if(t4.sapphireoffice ='1' AND t2.approve='3',1,0)) AS NumSapphireQcWait,
Sum(if(t4.sapphireoffice ='1' AND (t2.approve='1' OR t2.approve='0' ),1,0)) AS NumSapphireProcess,
Sum(if(t4.sapphireoffice ='0' AND t2.approve='2',1,0)) AS NumStaffTempQcPass,
Sum(if(t4.sapphireoffice ='0' AND t2.approve='3',1,0)) AS NumStaffTempQcWait,
Sum(if(t4.sapphireoffice ='0' AND (t2.approve='1' OR t2.approve='0'),1,0)) AS NumStaffTempProcess,
Sum(if(t4.sapphireoffice ='2' AND t2.approve='2',1,0)) AS NumOutsoreceQcPass,
Sum(if(t4.sapphireoffice ='2' AND t2.approve='3',1,0)) AS NumOutsoreceQcWait,
Sum(if(t4.sapphireoffice ='2' AND (t2.approve='1' OR t2.approve='0'),1,0)) AS NumOutsoreceQcProcess,
t1.siteid
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard
AND t1.siteid = t2.siteid
Inner Join ".DB_USERENTRY.".tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
Inner Join ".DB_USERENTRY.".keystaff as t4 ON t3.staffid = t4.staffid
WHERE
t2.nonactive='0'  AND t1.profile_id='$profile_id' and t2.profile_id='$profile_id'
GROUP BY  t1.siteid
";
//echo "$db_name :: $sql_count ";die;
	$result_count = mysql_db_query($db_name,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$arr1[$rs_c[siteid]]['NumSapphireQcPass'] = $rs_c[NumSapphireQcPass];
		$arr1[$rs_c[siteid]]['NumSapphireQcWait'] = $rs_c[NumSapphireQcWait];
		$arr1[$rs_c[siteid]]['NumSapphireProcess'] = $rs_c[NumSapphireProcess];
		$arr1[$rs_c[siteid]]['NumStaffTempQcPass'] = $rs_c[NumStaffTempQcPass];
		$arr1[$rs_c[siteid]]['NumStaffTempQcWait'] = $rs_c[NumStaffTempQcWait];
		$arr1[$rs_c[siteid]]['NumStaffTempProcess'] = $rs_c[NumStaffTempProcess];
		$arr1[$rs_c[siteid]]['NumOutsoreceQcPass'] = $rs_c[NumOutsoreceQcPass];
		$arr1[$rs_c[siteid]]['NumOutsoreceQcWait'] = $rs_c[NumOutsoreceQcWait];
		$arr1[$rs_c[siteid]]['NumOutsoreceQcProcess'] = $rs_c[NumOutsoreceQcProcess];
	}// end while($rs_c = mysql_fetch_assoc($result_count)){
	return $arr1;
	
}// end function CountKey(){
	
## function �Ѻ�ӹǹ�ؤ�ҡ÷������ࢵ��Шӹǹ���͡���
function CountPersonAndFile(){
	global $profile_id;
	$db = DB_CHECKLIST;	
	$sql_count1 = "SELECT COUNT(tbl_checklist_kp7.idcard) AS NumAll, SUM(tbl_checklist_kp7.page_num) AS NumPage,
SUM(if(tbl_checklist_kp7.page_upload > 0 and tbl_checklist_kp7.page_upload  IS NOT NULL,1,0)) AS NumFileUpload,
SUM(if(tbl_checklist_kp7.page_upload < 1 OR tbl_checklist_kp7.page_upload  IS NULL,1,0)) AS NumNotFile,
tbl_checklist_kp7.siteid
FROM tbl_checklist_kp7  Inner Join tbl_check_data On tbl_checklist_kp7.idcard=tbl_check_data.idcard   
WHERE tbl_checklist_kp7.profile_id='$profile_id' AND tbl_check_data.profile_id='$profile_id'
GROUP BY tbl_checklist_kp7.siteid
";
	$result_count1 = mysql_db_query($db,$sql_count1);
	while($rs_c1 = mysql_fetch_assoc($result_count1)){
	$arr2[$rs_c1[siteid]]['NumAll'] = $rs_c1[NumAll];
	$arr2[$rs_c1[siteid]]['NumPage'] =  $rs_c1[NumPage];
	$arr2[$rs_c1[siteid]]['NumFileUpload'] = $rs_c1[NumFileUpload];
	$arr2[$rs_c1[siteid]]['NumNotFile'] = $rs_c1[NumNotFile];
	}
	return $arr2;
	
}// end CountPersonAndFile

## �ѧ���蹵�Ǩ�ͺʶҹС���Ѻ�ͧ���������к�
function CheckApproveKey($get_site){
	global $profile_id;
	$db = DB_USERENTRY;
	$sql_ap = "SELECT idcard,approve FROM tbl_assign_key WHERE siteid='$get_site' AND nonactive='0' AND profile_id='$profile_id'";
	//echo $sql_ap." ::  $db <br>";
	$result_ap = mysql_db_query($db,$sql_ap);
	while($rs_ap = mysql_fetch_assoc($result_ap)){
		$arr[$rs_ap[idcard]] = $rs_ap[approve];
	}
	return $arr;
}
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("�س��㨷���ź������ cmss ��ԧ�������")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body bgcolor="#EFEFFF">

<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>���͡��¡�â����ŵ����ǧ���Ң�����</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>���͡����� :</strong></td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">���͡������</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?action=<?=$action?>&profile_id=<?=$rsp[profile_id]?>xmode=<?=$xmode?>&xshow=<?=$xshow?>&xsecid=<?=$xsecid?>&secname=<?=$secname?>&type_view=<?=$type_view?>&xtitle=<?=$xtitle?>&xsiteid=<?=$xsiteid?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
            </td>
        </tr>
        </table>
   </td>
  </tr>
</table>
 </form>
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <!--<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="70%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td colspan="4" bgcolor="#A3B2CC"><span class="style1">��§ҹ��ػ��úѹ�֡������ </span></td>
              </tr>
              <tr>
                <td width="22%" align="center" bgcolor="#A3B2CC">�ѹ��������Թ�ҹ</td>
                <td width="25%" align="center" bgcolor="#A3B2CC">�ѹ����ش���Թ�ҹ</td>
                <td width="17%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td width="23%" align="center" bgcolor="#A3B2CC">�ӹǹ�ѹ���Թ���(�ѹ)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d1);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">�ѹ��������Թ�ҹ</td>
                <td align="center" bgcolor="#A3B2CC">�Ѩ�غѹ</td>
                <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                <td align="center" bgcolor="#A3B2CC">�ӹǹ�ѹ���Թ���(�ѹ)</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_d);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=thai_date($temp_dc);?></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><?=$date_total_c?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#A3B2CC">�ӹǹ������¡�úѹ�֡(��)</td>
                <td align="center" bgcolor="#A3B2CC">�ӹǹ��úѹ�֡��ԧ(��)</td>
                <td align="center" bgcolor="#A3B2CC">�������(��)</td>
                <td align="center" bgcolor="#A3B2CC">�����繵�������¡�úѹ�֡</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_all"><?=$txt_sum_all;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="sum_key"><?=$txt_sum_key;?></div></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><a href="report_non_key.php" target="_blank"><div id="dis_key"></div></a></td>
                <td align="center" bgcolor="#FFFFFF" class="headerTB"><div id="persent_key"><?=$txt_persent_key?></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="22%">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><strong class="headerTB">����ૹ���úѹ�֡������ � �Ѩ�غѹ</strong></td>
            </tr>
            <tr>
              <td>	<div id="cockpit_area">
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="310" height="161" align="middle">
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="movie" value="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#ffffff" />
    <embed src="../../images_sys/pocmanger_cockpit.swf?score=<?=$total_ratio?>&showalert=<?=$alert_file?>&showalertwindow=_self" quality="high" bgcolor="#ffffff" width="310" height="161" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />  
</object>
</div>	</td>
            </tr>
          </table>		</td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="top"><font color="#FF0000">(�����˵� : �ӹǹ������¡�úѹ�֡�С�˹��������͹ )</font>&nbsp;&nbsp;������ � �ѹ��� <?=thai_date($temp_dc);?></td>
        </tr>
    </table>--></td>
  </tr>
</table>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="14" align="center" bgcolor="#A3B2CC"><strong><?=ShowDateProfile($profile_id);?></strong></td>
            </tr>
            <tr>
              <td width="2%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>���</strong></td>
              <td width="14%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>ࢵ��鹷�����֡��</strong></td>
              <td colspan="3" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>PDF<a href="report_pdf.php" target="_blank"><img src="images/yast_www.png" alt="�������ʹ�˹����§ҹ��Ǩ�ͺ��� pdf" width="22" height="22" border="0"></a></strong></td>
              <td width="5%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�Ѻ�ͧ<br>
��������ࢵ</strong></td>
            <td colspan="6" align="center" bgcolor="#A3B2CC"><strong>��§ҹ��á�͡������</strong></td>
            <td width="4%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>����<br>
�͡</strong></td>
            <td width="4%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>���</strong></td>
            </tr>
          <tr>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>��ѡ�ҹ��ҧ</strong></td>
            <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>Outsource</strong></td>
            </tr>
          <tr>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>�ʹ���<br>
              (��/��)</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>Up File</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>�������</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>�� QC</strong></td>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���ѧ<br>
              ���Թ���</strong></td>
            <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC PASS</strong></td>
            <td width="6%" align="center" bgcolor="#A3B2CC"><strong>�� QC</strong></td>
            <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���ѧ<br>
              ���Թ���</strong></td>
            </tr>
			<?
				$arrnum1 = CountPersonAndFile(); // �����Ũӹǹ�ؤšèӹǹ���
				$arrnumc = CountKey();/// �š�õ�Ǩ�����š�á�ä��������
				$arrb = CountPersonImp();// �Ѻ��¡�÷��Ӣ������������º��������
				//$sql_area = "SELECT * FROM eduarea  WHERE status_area53 = '1'  ORDER BY secname ASC";
				$sql_area = "SELECT eduarea.secid , eduarea.secname  FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id =  '$profile_id' order by eduarea.secname  ASC ";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				$j=0;
				while($rs_a = mysql_fetch_assoc($result_area)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  	
					$num_all = $arrnum1[$rs_a[secid]]['NumAll'];
					$num_page = $arrnum1[$rs_a[secid]]['NumPage'];
					$num_file = $arrnum1[$rs_a[secid]]['NumFileUpload'];
					$num_nofile = $arrnum1[$rs_a[secid]]['NumNotFile'];
					##  �š�õ�Ǩ�����š�á�ä��������
					//$arrnumc = CountKey($rs_a[secid]);
					## ��ѡ�ҹ���Ǥ���
					$NumTempPass = $arrnumc[$rs_a[secid]]['NumStaffTempQcPass'];
					$NumTempWait = $arrnumc[$rs_a[secid]]['NumStaffTempQcWait'];
					$NumTempProcess = $arrnumc[$rs_a[secid]]['NumStaffTempProcess'];
					##  Outsource
					$NumOutPass = $arrnumc[$rs_a[secid]]['NumOutsoreceQcPass'];
					$NumOutWait = $arrnumc[$rs_a[secid]]['NumOutsoreceQcWait'];
					$NumOutProcess = $arrnumc[$rs_a[secid]]['NumOutsoreceQcProcess'];
					## ��ѡ�ҹ Sapphire
					$NumSapphirePass = $arrnumc[$rs_a[secid]]['NumSapphireQcPass'];
					$NumSapphireWait = $arrnumc[$rs_a[secid]]['NumSapphireQcWait'];
					$NumSapphireProcess = $arrnumc[$rs_a[secid]]['NumSapphireProcess'];
					

					$num_approve = count_person_approve($rs_a[secid]);
				  	if($num_approve > 0){
						$link_approve = "<a href='report_person_approve.php?xsecid=$rs_a[secid]&secname=$rs_a[secname]&profile_id=$profile_id' target='_blank'>".number_format($num_approve)."</a>";
					}else{
						$link_approve = "0";
					}
					$sum_num_approve += $num_approve;
					
					
					## ��Ǩ�ͺ�ó� �ѧ����� import ������ checklist �������к� cmss
					if($num_all < 1){
//							$sql_checklist = "SELECT COUNT(tbl_checklist_kp7.idcard) AS NumAll, SUM(tbl_checklist_kp7.page_num) AS NumPage,
//SUM(if(tbl_checklist_kp7.page_upload > 0 and tbl_checklist_kp7.page_upload  IS NOT NULL,1,0)) AS NumFileUpload,
//SUM(if(tbl_checklist_kp7.page_upload < 1 OR tbl_checklist_kp7.page_upload  IS NULL,1,0)) AS NumNotFile
//FROM tbl_checklist_kp7  WHERE siteid='$rs_a[secid]' GROUP BY siteid";
//							$result_checklist = mysql_db_query("edubkk_checklist",$sql_checklist);
//							$rs_chk = mysql_fetch_assoc($result_checklist);
							$num_all = $arrb[$rs_a[secid]]['NumAll'];
							$num_page  = $arrb[$rs_a[secid]]['NumPage'];
							$num_file = $arrb[$rs_a[secid]]['NumFileUpload'];
							$glink = 0;	
					}else{
						$glink = 1;	
					}
					
					
					if($num_page > 0){
						$totalnum_all = number_format($num_all)."/".number_format($num_page);
					}else{
						$totalnum_all = 	number_format($num_all);
					}
					###  ����褧�����
					$num_nofile = $num_all-$num_file;
					
			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$j?></td>
            <td align="left"><a href="?action=view&xsecid=<?=$rs_a[secid]?>&secname=<?=$rs_a[secname]?>&profile_id=<?=$profile_id?>" target="_blank"><?=str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_a[secname])?></a></td>
            <td align="right"><? echo $totalnum_all;?></td>
            <td align="right"><?=number_format($num_file);?></td>
            <td align="right"><?=number_format($num_nofile);?></td>
            <td align="right"><?=$link_approve?></td>
            <td align="right"><?  if($NumTempPass > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=��§ҹ�����ŷ���ҹ��õ�Ǩ�ͺ����[��ѡ�ҹ��ҧ]&profile_id=$profile_id' target='_blank'>".number_format($NumTempPass)."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if($NumTempWait > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=��§ҹ�����ŷ���͡�õ�Ǩ�ͺ����[��ѡ�ҹ��ҧ]&profile_id=$profile_id' target='_blank'>".number_format($NumTempWait)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if($NumTempProcess > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=0&xtitle=��§ҹ�����ŷ���ҧ���Թ���[��ѡ�ҹ��ҧ]&profile_id=$profile_id' target='_blank'>".number_format($NumTempProcess)."</a>";}else{ echo "0";}?></td>
            <td align="right"><?  if($NumOutPass > 0){ echo "<a href='report_flow_ticket.php?action=qc_pass&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=��§ҹ�����ŷ���ҹ��õ�Ǩ�ͺ����[Outsource]' target='_blank'>".number_format($NumOutPass)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if($NumOutWait > 0){ echo "<a href='report_flow_ticket.php?action=qc_wait&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=��§ҹ�����ŷ���͡�õ�Ǩ�ͺ������[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutWait)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? if($NumOutProcess > 0){ echo "<a href='report_flow_ticket.php?action=&secname=$rs_a[secname]&xsiteid=$rs_a[secid]&xtype=2&xtitle=��§ҹ�����ŷ���ҧ���Թ���[Outsource]&profile_id=$profile_id' target='_blank'>".number_format($NumOutProcess)."</a>";}else{ echo "0";}?></td>
            <td align="right"><? 
				$temp_n = $num_all-($NumTempPass+$NumTempWait+$NumTempProcess+$NumOutPass+$NumOutWait+$NumOutProcess+$NumSapphirePass+$NumSapphireWait+$NumSapphireProcess);
				if($temp_n > 0){
					if($glink > 0){
					echo "<a href='report_new.php?action=view&xsecid=$rs_a[secid]&secname=$rs_a[secname]&type_view=discount&xtitle=��ª��ͷ�������͡&profile_id=$profile_id' target='_blank'>".number_format($temp_n)."</a>";
					}else{
						echo 	number_format($temp_n);
					}
				}else{
					echo "0";
				}
				
			?></td>
            <td align="right"><? 
				$total1  = $num_all;
				echo number_format($total1);
			?></td>
          </tr>
		  <?
		  	$sumall1 += $num_all;
			$sumall2 += $num_file;
			$sumall3 += $num_nofile;
			$sumall4 += $NumTempPass;
			$sumall5 += $NumTempWait;
			$sumall6 += $NumTempProcess;
			$sumall7 += $NumOutPass;
			$sumall8 += $NumOutWait;
			$sumall9 += $NumOutProcess;
			$sumall10 += $NumSapphirePass;
			$sumall11 += $NumSapphireWait;
			$sumall12 += $NumSapphireProcess;

		  
		  	}// end while(){
		  ?>
          <tr>
            <td colspan="2" align="right" bgcolor="#E2E2E2"><strong>��� </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall2);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall3);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sum_num_approve);?>
             </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall4);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall5);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall6);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall7);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall8);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall9);?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?
				$temp_sumall = $sumall1-($sumall4+$sumall5+$sumall6+$sumall7+$sumall8+$sumall9+$sumall10+$sumall11+$sumall12);
				echo number_format($temp_sumall);
			?>
            </strong></td>
            <td align="right" bgcolor="#E2E2E2"><strong>
              <?=number_format($sumall1);?>
            </strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<?
	$temp_key = ($sumall4+$sumall7+$sumall10);
	$total_ratio = number_format((($temp_key*100)/$sumall1),2);
	
	$temp_total1 = $sumall1/$date_total;
	//$temp_total2 = $temp_total1*$date_total_c;
	$temp_total2 = $sumall1 ;
	
	$alert_file = number_format(($temp_total2*100)/$sumall1,2);
	
	$dis_key = number_format($sumall1-$temp_key);
	$persen_k1 = number_format(($dis_key*100)/$temp_total2,2); // �����繡�úѹ�֡
	
//	echo " �ѹ������==  ".$date_total."   �ѹ�Ѩ�غѹ ==  ".$date_total_c."  �ӹǹ�ش����ѹ  $temp_total1 ==  ".$temp_total2." == ".$alert_file;
	//echo $total_ratio;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
/*document.getElementById("cockpit_area").innerHTML="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"310\" height=\"161\" align=\"middle\">       <param name=\"allowScriptAccess\" value=\"sameDomain\" />        <param name=\"movie\" value=\"../../images_sys/pocmanger_cockpit.swf?score=<?//=$total_ratio?>&showalert=<?//=$alert_file?>&showalertwindow=_self\" />        <param name=\"quality\" value=\"high\" />        <param name=\"bgcolor\" value=\"#ffffff\" />        <embed src=\"../../images_sys/pocmanger_cockpit.swf?score=<?//=$total_ratio?>&showalert=<?//=$alert_file?>&showalertwindow=_self\" quality=\"high\" bgcolor=\"#ffffff\" width=\"310\" height=\"161\" align=\"middle\" allowscriptaccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />      </object>	";
document.getElementById("sum_all").innerHTML="<?//=number_format($temp_total2)?>";
document.getElementById("sum_key").innerHTML="<?//=number_format($temp_key)?>";
document.getElementById("persent_key").innerHTML="<?//=$alert_file?>";
document.getElementById("dis_key").innerHTML="<?//=$dis_key?>";
document.getElementById("persen_k1").innerHTML="<?//=$persen_k1?>";
*///-->
</SCRIPT>


<?
	}//end if($action == ""){
	if($action == "view"){
		$arr_view = CountKey();
		//$arr_view = CountKey($xsecid);
		//$arr_view1 = CountPersonAndFile($xsecid);
		$arr_view1 = CountPersonAndFile();
		
//	$arr1['NumSapphireQcPass'] = $rs_c[NumSapphireQcPass];
//	$arr1['NumSapphireQcWait'] = $rs_c[NumSapphireQcWait];
//	$arr1['NumSapphireProcess'] = $rs_c[NumSapphireProcess];
//	$arr1['NumStaffTempQcPass'] = $rs_c[NumStaffTempQcPass];
//	$arr1['NumStaffTempQcWait'] = $rs_c[NumStaffTempQcWait];
//	$arr1['NumStaffTempProcess'] = $rs_c[NumStaffTempProcess];
//	$arr1['NumOutsoreceQcPass'] = $rs_c[NumOutsoreceQcPass];
//	$arr1['NumOutsoreceQcWait'] = $rs_c[NumOutsoreceQcWait];
//	$arr1['NumOutsoreceQcProcess'] = $rs_c[NumOutsoreceQcProcess];
//	$arr2['NumAll'] = $rs_c1[NumAll];
//	$arr2['NumPage'] =  $rs_c1[NumPage];
//	$arr2['NumFileUpload'] = $rs_c1[NumFileUpload];
//	$arr2['NumNotFile'] = $rs_c1[NumNotFile];
		
		$num_key_pass = $arr_view[$xsecid]['NumSapphireQcPass']+$arr_view[$xsecid]['NumStaffTempQcPass']+$arr_view[$xsecid]['NumOutsoreceQcPass'];
		$num_Nokey = $arr_view1[$xsecid]['NumAll']-$num_key_pass;
		$num_NotFile = $arr_view1[$xsecid]['NumNotFile'];
		
		
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5"><strong><?=$secname?></strong></td>
        </tr>
        <tr>
          <td width="15%">&nbsp;</td>
          <td width="26%" align="right"><strong>�ӹǹ�ؤ�ҡ÷�����</strong></td>
          <td width="15%" align="right"><? if($arr_view1[$xsecid]['NumAll'] > 0){?><a href="?action=view&type_view=all&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=��ª��ͨӹǹ�ؤ�ҡ÷�����&profile_id=<?=$profile_id?>"><?=number_format($arr_view1[$xsecid]['NumAll']);?></a><? }else{ echo "0";}?></td>
          <td width="20%"><strong>��</strong></td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>�ӹǹ�ؤ�ҡ÷��ѹ�֡����������</strong></td>
          <td align="right"><? if($num_key_pass > 0){ ?> <a href="?action=view&type_view=key_pass&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=��ª��ͨӹǹ�ؤ�ҡ÷��ѹ�֡����������&profile_id=<?=$profile_id?>"><?=$num_key_pass?></a><? }else{ echo "0";}?></td>
          <td><strong>��</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>�ӹǹ����ҧ�ѹ�֡</strong></td>
          <td align="right"><? if($num_Nokey > 0){ ?><a href="?action=view&type_view=key_dis&xsecid=<?=$xsecid?>&secname=<?=$secname?>&xtitle=��ª��ͨӹǹ�ؤ�ҡ÷���ҧ�ѹ�֡&profile_id=<?=$profile_id?>"><?=number_format($num_Nokey)?></a><? }else{ echo "0";}?></td>
          <td><strong>��</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><strong>�ӹǹ�ؤ�ҡ÷���������� �.�.7 �鹩�Ѻ</strong> </td>
          <td align="right"><? if($num_NotFile > 0){ echo "<a href='?action=view&type_view=null_kp7&xsecid=$xsecid&secname=$secname&xtitle=��ª��ͺؤ�ŷ������� �.�.7 �鹩�Ѻ&profile_id=$profile_id'>".number_format($num_NotFile)."</a>";}else{ echo "0";}?></td>
          <td><strong>��</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="<?=$bg?>">
          <td colspan="5"><strong><?=$xtitle?></strong></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
                  <td width="16%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�ѵû�Шӵ�ǻ�ЪҪ�</strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
                  <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
                  <td width="14%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�ѧ�Ѵ</strong></td>
                  <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>ʶҹС�úѹ�֡������</strong></td>
                  </tr>
                <tr>
                  <td width="11%" align="center" bgcolor="#A3B2CC"><strong>�ѹ�֡����������</strong></td>
                  <td width="12%" align="center" bgcolor="#A3B2CC"><strong>���������ҧ���Թ���</strong></td>
                  <td width="13%" align="center" bgcolor="#A3B2CC"><strong>���ѧ���Թ�����</strong></td>
                </tr>
				<?
if($type_view != ""){$type_view = $type_view;}else{ $type_view = "all";}
$db_site = STR_PREFIX_DB.$xsecid;
			
if($type_view == "all"){
$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.position_now AS pos_now,
$db_site.general.position_now,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join $db_site.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $db_site.general.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard
";
	
$result = mysql_db_query($db_site,$sql);	
}else if($type_view == "key_pass"){

	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND
 ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' 
AND ".DB_USERENTRY.".tbl_assign_key.profile_id='$profile_id'

GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard";
$result = mysql_db_query($db_name,$sql);	

}else if($type_view == "key_dis"){
	
$sql_temp = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND ".DB_USERENTRY.".tbl_assign_key.approve =  '2' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' 
AND ".DB_USERENTRY.".tbl_assign_key.profile_id='$profile_id'
GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard";
//echo $sql_temp;
$result_temp = mysql_db_query($db_name,$sql_temp);
while($rs_t = mysql_fetch_assoc($result_temp)){
	if($xidcard > "") $xidcard .= ",";
	$xidcard .= "'$rs_t[idcard]'";
}

if($xidcard != ""){ $xidcard = $xidcard;}else{ $xidcard = "''";}

	$sql = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.position_now,
 ".DB_CHECKLIST.".tbl_check_data.schoolname,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND  ".DB_CHECKLIST.".tbl_check_data.idcard NOT IN($xidcard) AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard";
$result = mysql_db_query($db_temp,$sql);
	//echo $sql;
}else if($type_view == "discount"){
	$sql_temp1 = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
WHERE
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0'  AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id' 
AND ".DB_USERENTRY.".tbl_assign_key.profile_id='$profile_id'
GROUP BY  ".DB_CHECKLIST.".tbl_check_data.idcard";
//echo "$sql_temp1<hr>";
$result_temp1 = mysql_db_query($db_name,$sql_temp1);
while($rs1 = mysql_fetch_assoc($result_temp1)){
	//echo $rs1[idcard]."<br>";

		if($xidcard_d > "") $xidcard_d .= ",";
		$xidcard_d .= "'$rs1[idcard]'";
}// end while($rs1 = mysql_fetch_assoc($result_temp1)){
if($xidcard_d != ""){ $xidcard_d = $xidcard_d;}else{ $xidcard_d = "''";}	

$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_check_data.prename_th,
tbl_check_data.name_th,
tbl_check_data.surname_th,
tbl_check_data.schoolname,
tbl_check_data.position_now,
tbl_check_data.secid
FROM
tbl_checklist_kp7
Inner Join tbl_check_data ON tbl_checklist_kp7.idcard = tbl_check_data.idcard
WHERE
tbl_checklist_kp7.siteid =  '$xsecid' AND
( ".DB_CHECKLIST.".tbl_check_data.idcard  NOT IN($xidcard_d)) 
AND tbl_checklist_kp7.profile_id='$profile_id'
AND  ".DB_CHECKLIST.".tbl_check_data.profile_id='$profile_id'
GROUP BY tbl_checklist_kp7.idcard";
$result = mysql_db_query($db_temp,$sql);
//echo $sql."<br>";die;
}// end if($type_view == "discount"){
else if($type_view == "null_kp7"){

$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_check_data.prename_th,
tbl_check_data.name_th,
tbl_check_data.surname_th,
tbl_check_data.schoolname,
tbl_check_data.position_now,
tbl_check_data.secid
FROM
tbl_checklist_kp7
Inner Join tbl_check_data ON tbl_checklist_kp7.idcard = tbl_check_data.idcard
WHERE
tbl_checklist_kp7.siteid =  '$xsecid' AND
(tbl_checklist_kp7.page_upload IS NULL or tbl_checklist_kp7.page_upload < 1) 
AND tbl_checklist_kp7.profile_id='$profile_id'
AND tbl_check_data.profile_id='$profile_id'
GROUP BY tbl_checklist_kp7.idcard";
$result = mysql_db_query($db_temp,$sql);
}
//echo "$sql<br>";
	$arr_app = CheckApproveKey($xsecid); // ��Ǩ�ͺ����ա���Ѻ�ͧ�����������ѧ
	$arr_ticket = search_ticket($xsecid);
		
		
		$m=0;
		while($rs = mysql_fetch_assoc($result)){
			$status_approve = $arr_app[$rs[idcard]];
//		
//		$sql_check_approve = "SELECT approve FROM tbl_assign_key WHERE idcard='$rs[idcard]'";
//		$result_check_approve = mysql_db_query("edubkk_userentry",$sql_check_approve);
//		$rs_appv = mysql_fetch_assoc($result_check_approve);
//		
			if($m% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
			$path_imgtemp = "../../../checklist_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
			if(is_file($path_imgtemp) and is_file($path_img)){
				$flag_file = "";	
			}else{
				$flag_file = "<img src=\"../../images_sys/question.gif\" width=\"18\" height=\"18\" border='0' title='����ҧ��Ҩҡ�ç��ûշ������'>";	
			}
			
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" border=\"0\"></a>&nbsp;$flag_file";
					if($status_approve != "2"){
					$link_del = "  <img src=\"images/Cancel-2-32x32.png\" alt=\"�������͡�˹�ʶҹ��͡����������ó�\" width=\"18\" height=\"18\" border=\"0\" onClick=\"return confirmDelete('pupup_kp7_fail.php?idcard=$rs[idcard]')\" style=\"cursor:hand\">";
					}else{
					$link_del = "";
					}
				}else{
					$link_del = "";
					$link_img = "<font color='red'>�������� �.�.7 �鹩�Ѻ</a>";
				}
		
		#####################  �ó� ˹����§ҹ�ͧ����������͡ ###################
//		if(check_file_fail($rs[idcard],$xsecid) == 1){
//				$f_color1 = "<font color='red'>";
//				$f_color2 = "</font>";
//		}else{
//				$f_color1 = "";
//				$f_color2 = "";
//		}
		
		#############  �ó�˹��§ҹ�ѡ�Ѵ�� ��������ͧ�ҡ��ù���ҼԴ
//		if($rs[schoolname] > 0 or $rs[schoolname] == ""){
//			$xschoolname = $rs[pos_now];
//		}else{
//			$xschoolname = $rs[schoolname];
//		}
		#############  �ó�˹��§ҹ�ѡ�Ѵ�� ��������ͧ�ҡ��ù���ҼԴ
		$xschoolname = $rs[schoolname];
		?>

				     <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$m?></td>
                  <td align="left"><?=$f_color1?><?=$rs[idcard]?><?=$f_color2?>&nbsp;&nbsp;<?=$link_img?>&nbsp;<?=$link_del?> </td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="left"><?=$rs[position_now]?></td>
                  <td align="left"><?=$xschoolname?></td>
                  <td align="center">
				  <?
					if($status_approve == "2"){
						echo "��ҹ";
					}
				  ?>				  </td>
                  <td align="center"><?
					if($status_approve  != "2"){
						echo "���������ҧ���Թ���";
					}
				  ?></td>
                  <td align="LEFT">
				  	<? if($rs_c1[num] > 0){ echo $arr_ticket[$rs[idcard]];}else{ echo search_null_ticket($rs[idcard]);}?>
				  </td>
                </tr>

				<?
					$status_approve = "";
				}//end 		while($rs = mysql_fetch_assoc($result)){
				?>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
 <?
 		echo "<br><center><font color='red'>�����˵�: ���ʺѵ÷���繵��˹ѧ�����ᴧ�����¡�÷������� pdf ������ʶҹ���鹩�Ѻ�������ó�</font><br>
<img src=\"../../images_sys/question.gif\" width=\"18\" height=\"18\" border='0' title='����ҧ���'> ��� ������ҧ��Ҩҡ�ç��ûշ������</center>";
 	}//end if($action == "view"){
 ?>
</BODY>
</HTML>
