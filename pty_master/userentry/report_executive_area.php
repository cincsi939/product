<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;

			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			if(!isset($session_staffid)){
				echo "<script type=\"text/javascript\">
				alert('��س���͡�Թ�������к�');
				window.location=\"login.php\";
				</script>";
			}
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
			
			
			if($yy == ""){
					$yy = date("Y")+543;
			}
			if($mm == ""){
					$sql_month = "SELECT month(datekeyin)  as month1  FROM `stat_user_keyin` group by datekeyin order by datekeyin desc limit 0,1";
					$result_month = mysql_db_query($dbnameuse,$sql_month);
					$rs_month = mysql_fetch_assoc($result_month);
					$mm = sprintf("%02d",$rs_month[month1]);
			}

//echo "$yy :: $mm";

			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				if($x[0] > 0){
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				}else{
				$xrs = "";	
				}
				
				return $xrs;
			}

function thaidate1($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0]));
				if($x[0] > 0){
					$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				}else{
					$xrs = "";	
				}
				return $xrs;
			}

function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){
	

### �ʴ����;�ѡ�ҹ QC
function GetStaffQc($get_staff){
		global $dbnameuse;
		$sql = "SELECT * FROM keystaff WHERE staffid='$get_staff'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function GetStaffQc(){

##############  function ���ҵ��˹觷���繼��������ࢵ
function find_positiongroup($groupid){
		if($groupid == "1"){ // ��§ҹ�����á���֡��
			$sql_con = " ( ".find_groupstaff(1)." or".find_groupstaff(2)." ) ";
		}else if($groupid == "2"){ // ��§ҹ���ȡ���֡��
			$sql_con = find_groupstaff(3);
		}else if($groupid == "3"){ // ��§ҹ������ʶҹ�֡��
			$sql_con = " ( ".find_groupstaff(4)." or ".find_groupstaff(5)." ) ";
		}else if($groupid == "4"){ // ��§ҹ����͹
			$sql_con = " ( ".find_groupstaff(6)." or ".find_groupstaff(8)." ) ";
		}else if($groupid == "5"){ // �ؤ�ҡ÷ҧ����֡�� 38 �.(2)
				$sql_con = " ( ".find_groupstaff(7)." ) ";
		}
	return $sql_con;
}

##############  end function ���¡�ʴ���������˹� by suwat

#function takes_array($input)
function  find_groupstaff($typegroup) { 
	
	###################### Way to use
	###################### $sqlext = find_groupstaff(1) ; 
	#1.	 ��.ࢵ #2.	 �ͧ ��.ࢵ 	#3.	 �֡�ҹ��ȹ� #4.	 ��.�ç���¹ #5.	 �ͧ��.�ç���¹ #6.	 ��� # else:: ����� 
switch ($typegroup) {  
case 0:  ########################## �ء�� 
	$sqlext = "  1  "; 
    break;
case 1:  ##########################��.ࢵ 
	$sqlext = " (
	( `position_now` LIKE '%����ӹ�¡��%'   OR  `position_now` LIKE '%��%'  )
	AND (`position_now`   LIKE '%ʾ�%'  or `position_now`   LIKE '%�ӹѡ�ҹࢵ��鹷�����֡��%' ) 
	AND (`position_now` NOT LIKE '%�ç���¹%'  AND `position_now` NOT LIKE '%ʶҹ�֡��%' ) 
	AND (`position_now` NOT LIKE '%�ͧ%'  AND `position_now` NOT LIKE '%������%' ) 
	) "; 
    break;
case 2:  ##########################�ͧ ��.ࢵ 
	$sqlext = " ((
	( `position_now` LIKE '%����ӹ�¡��%'   OR  `position_now` LIKE '%��%'  )
	AND (`position_now`   LIKE '%ʾ�%'  or `position_now`   LIKE '%�ӹѡ�ҹࢵ��鹷�����֡��%' ) 
	AND (`position_now` NOT LIKE '%�ç���¹%'  AND `position_now` NOT LIKE '%ʶҹ�֡��%' ) 
	AND ( `position_now`  LIKE '%�ͧ%'  OR `position_now`   LIKE '%������%' ) 
	) OR (`position_now` LIKE '%���˹�ҷ������á���֡��%'  OR position_now LIKE '%���%�����á���֡��%' ) 
	)
	"; 
    break;
case 3:  ##########################�֡�ҹ��ȹ� 
	$sqlext = " (
	`position_now` LIKE '%�֡�ҹ�%'   OR `position_now` LIKE '%ȹ%'  
	AND (`position_now` NOT LIKE '%�ç���¹%'  AND `position_now` NOT LIKE '%ʶҹ�֡��%' ) 
	) "; 
    break;
case 4:  ##########################��.�ç���¹ 
	$sqlext = " (
	( `position_now` LIKE '%����ӹ�¡��%'   OR `position_now` LIKE '%����˭�%' OR `position_now` LIKE '%�Ҩ�����˭�%') 
	AND (`position_now` NOT LIKE '%ʾ�%'  AND `position_now`  NOT LIKE '%�ӹѡ�ҹࢵ��鹷�����֡��%' ) 
	AND (`position_now` NOT LIKE '%�ͧ%'  AND `position_now` NOT LIKE '%������%' ) 
	) "; 
#AND (`position_now` LIKE '%�ç���¹%'  OR `position_now` LIKE '%ʶҹ�֡��%' OR `position_now`   LIKE '����ӹ�¡��' ) 
    break;
case 5:  ##########################�ͧ��.�ç���¹ 
	$sqlext = " 
	(
	( `position_now` LIKE '%����ӹ�¡��%'   OR `position_now` LIKE '%����˭�%' OR `position_now` LIKE '%�Ҩ�����˭�%' ) 
	AND (`position_now` NOT LIKE '%ʾ�%'  AND `position_now`  NOT LIKE '%�ӹѡ�ҹࢵ��鹷�����֡��%' ) 
	AND (`position_now` LIKE '%�ͧ%'  OR `position_now`   LIKE '%������%' ) 
	) "; 
#	AND (`position_now` LIKE '%�ç���¹%'  OR `position_now` LIKE '%ʶҹ�֡��%' OR `position_now`   LIKE '�ͧ����ӹ�¡��'  ) 
    break;
case 6:  ##########################��� // ���  OR `position_now` = '' �͡���ͧ�ҡ�������㹡�����������к�
	$sqlext = " (
	( `position_now` LIKE '%���%'   OR `position_now` LIKE '%�Ҩ����%' )  
	AND `position_now` NOT LIKE '%����˭�%'
	AND   position_now   NOT LIKE  '%�Ҩ�����˭�%' 
	AND position_now NOT LIKE '%��ټ�����%'
	) "; 
    break;
case 7:  ##########################���˹�ҷ��ࢵ
	$sqlext = " 
	(
(position_now not LIKE  '%����ӹ�¡��%' and position_now not LIKE  '%��%' )
 AND ( position_now not  LIKE  '%���%'    )
 AND ( position_now not  LIKE  '%�Ҩ����%' )
 AND ( position_now not  LIKE  '%�֡�ҹ�%' ) 
 AND ( position_now not  LIKE  '%ȹ%' ) 
 AND ( position_now not  LIKE  ''    ) 
 AND ( position_now NOT LIKE '%���˹�ҷ������á���֡��%' )
 AND (position_now NOT LIKE '%���%�����á���֡��%' )

	) "; //  AND (noposition  LIKE '�%' )
    break;
case 8:  ##########################��ټ�����
	$sqlext = " 
	( `position_now` LIKE '%��ټ�����%'   ) 
	"; 
    break;
case 9: ## 㹡ó� ���˹�  position_now �繤����ҧ  ### ����к�
	$sqlext = "
	( `position_now` = '') 
	";
	break;
	//echo $sqlext;
	case 10: ### ���˹����˹�ҷ��ؤ�ҡ�á���֡������
		$sqlext = " 
	(
(position_now not LIKE  '%����ӹ�¡��%' and position_now not LIKE  '%��%' )
 AND ( position_now not  LIKE  '%���%'    )
 AND ( position_now not  LIKE  '%�Ҩ����%' )
 AND ( position_now not  LIKE  '%�֡�ҹ�%' ) 
 AND ( position_now not  LIKE  '%ȹ%' ) 
 AND ( position_now not  LIKE  ''    ) 
 AND ( position_now NOT LIKE '%���˹�ҷ������á���֡��%' )
 AND (position_now NOT LIKE '%���%�����á���֡��%' )

	) ";  //  AND (noposition  NOT LIKE '�%' )
	break;
default:
     $sqlext = "  0  " ; 
} ################################# END switch ($typegroup) {   
#	echo "$typegroup ||||||||| $sqlext   <hr>";
	return  $sqlext  ; 
}####### END fucntion find_groupstaff($typegroup) { 


###########  function �ѹ�֡�����Ţͧ��������
function SaveTempData(){
	global $dbnameuse,$db_temp;
	$conw = " where ".find_positiongroup(1);;
	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.birthday,
tbl_checklist_kp7.position_now
FROM `tbl_checklist_kp7`
$conw
";
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$sql_save = "REPLACE INTO temp_report_executive SET idcard='$rs[idcard]',siteid='$rs[siteid]', prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',position_now='$rs[position_now]'";
			mysql_db_query($dbnameuse,$sql_save);
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function SaveTempData(){

##########  function ��Ǩ�ͺ����ա�úѹ�֡���������������ѧ
function SetStatusKey($get_idcard){
		global $dbnameuse;
		$sql = "SELECT
tbl_assign_key.idcard,
tbl_assign_key.siteid,
monitor_keyin.staffid
FROM
tbl_assign_key
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' AND
tbl_assign_key.idcard = '$get_idcard'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
			$sql_update = "UPDATE temp_report_executive SET status_key='1',staff_key='$rs[staffid]' WHERE idcard='$rs[idcard]'";
			@mysql_db_query($dbnameuse,$sql_update);
	}
}//end 

function SetStatusQc($get_idcard){
	global $dbnameuse;
	$sql = "SELECT
validate_checkdata.idcard,
validate_checkdata.qc_staffid,
validate_checkdata.qc_date
FROM `validate_checkdata`
where idcard='$get_idcard'
group by validate_checkdata.idcard";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[idcard] != ""){
			$sql_update = "UPDATE temp_report_executive SET staff_qc='$rs[qc_staffid]', date_qc='$rs[qc_date]' WHERE idcard='$rs[idcard]'";
			@mysql_db_query($dbnameuse,$sql_update);
	}
}
####### �ѧ���蹡�˹�ʶҹТ����Ţͧ��������
function SetStatusDataExecutive(){
	global $dbnameuse;
	$sql = "SELECT * FROM temp_report_executive";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			SetStatusKey($rs[idcard]); // ��˹�ʶҹ���Ҥ�����������������ѧ
			SetStatusQc($rs[idcard]); // ��˹�ʶҹ�����ա�ä������������������ѧ
	}//end 	while($rs = mysql_fetch_assoc($result)){ 	
}//end function SetStatusDataExecutive(){

if($Process == "1"){
		SaveTempData();// �ѹ�֡������
		SetStatusDataExecutive();// ��˹�ʶҹТ�����
	echo "<script>location.href='?Process=';</script>";
}


function ShowExsumEx(){
	global $dbnameuse,$xtype;
	
	
	 if($xtype == "1"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='1'";
			
				 }else if($xtype == "0"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='0'"; 
		
				}else if($xtype == "QC"){
					$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.staff_qc <> '' AND ".DB_USERENTRY.".temp_report_executive.staff_qc IS NOT NULL";  	

					}else if($xtype == "NQC"){
					$conw1 = "AND (edubkk_userentry.temp_report_executive.staff_qc = '' or ".DB_USERENTRY.".temp_report_executive.staff_qc IS NULL)";
				
				}
			   else{
				   $conw1 = "";
			
				 }
	$constaff1 = find_groupstaff(1);// ����ӹ�¡��
	$constaff2 = find_groupstaff(2);// �ͧ����ӹ�¡��
		$sql = "SELECT 
count(idcard) as numall,
sum(if($constaff1,1,0)) as   H1,
sum(if($constaff2,1,0)) as   H2,
sum(if($constaff1 and staff_qc >0,1,0)) as   H1QC,
sum(if($constaff2 and staff_qc >0,1,0)) as   H2QC,
sum(if($constaff1 and status_key>0,1,0)) as   H1KEY,
sum(if($constaff2 and status_key>0,1,0)) as   H2KEY


FROM `temp_report_executive` WHERE idcard <> '' $conw1
";
$result = mysql_db_query($dbnameuse,$sql);
$rs = mysql_fetch_assoc($result);
	$H3 = $rs[numall]-($rs[H1]+$rs[H2]);
	if($H3 > 0){
	$H3QC = $rs[numall]-($rs[H1QC]+$rs[H2QC]);
	}
	if($H3 > 0){
	$H3KEY = $rs[numall]-($rs[H1KEY]+$rs[H2KEY]);
	}
	$arr['H1'] = $rs[H1];
	$arr['H2'] = $rs[H2];
	$arr['H3'] = $H3;
	$arr['H1QC'] = $rs[H1QC];
	$arr['H2QC'] = $rs[H2QC];
	$arr['H3QC'] = $H3QC;
	$arr['H1KEY'] = $rs[H1KEY];
	$arr['H2KEY'] = $rs[H2KEY];
	$arr['H3KEY'] = $H3KEY;
	return $arr;
}// end function ShowExsumEx(){



$arr_data = ShowExsumEx();
?>



<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >��§ҹ��ª��� ����ӹ�¡��/�ͧ����ӹ�¡�� �ӹѡ�ҹࢵ��鹷�����֡��������˹�ҽ��ºؤ��<br><a href="?Process=1">�������ͻ����żŢ�����</a></td>
        </tr>
		   <tr>
		     <td align="center"><br>
		       <table width="70%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		           <tr>
		             <td width="26%" rowspan="2" bgcolor="#A5B2CE">&nbsp;</td>
		             <td width="14%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ������</strong></td>
		             <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>ʶҹТ�����</strong></td>
	                </tr>
		           <tr>
		             <td width="13%" bgcolor="#A5B2CE"><strong>�ѹ�֡����(��)</strong></td>
		             <td width="12%" bgcolor="#A5B2CE"><strong>��ҧ�ѹ�֡(��)</strong></td>
		             <td width="13%" bgcolor="#A5B2CE"><strong>QC ����(��)</strong></td>
		             <td width="13%" bgcolor="#A5B2CE"><strong>��ҧ QC(��)</strong></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">��.�ӹѡ�ҹࢵ��鹷�����֡��</td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']-$arr_data['H1KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H1']-$arr_data['H1QC']);?></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">�ͧ ��. �ӹѡ�ҹࢵ��鹷�����֡��</td>
					<td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']-$arr_data['H2KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H2']-$arr_data['H2QC']);?></td>
	                </tr>
		           <tr>
		             <td bgcolor="#A5B2CE">���˹�ҽ��ºؤ��</td>
                    <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']-$arr_data['H3KEY']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3QC']);?></td>
		             <td align="center" bgcolor="#A5B2CE"><? echo number_format($arr_data['H3']-$arr_data['H3QC']);?></td>
	                </tr>
		           <tr>
		             <td align="center" bgcolor="#A5B2CE"><strong>���</strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1']+$arr_data['H2']+$arr_data['H3']);?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1KEY']+$arr_data['H2KEY']+$arr_data['H3KEY']); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format(($arr_data['H1']-$arr_data['H1KEY'])+($arr_data['H2']-$arr_data['H2KEY'])+($arr_data['H3']-$arr_data['H3KEY'])); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format($arr_data['H1QC']+$arr_data['H2QC']+$arr_data['H3QC']); ?></strong></td>
		             <td align="center" bgcolor="#A5B2CE"><strong><? echo number_format(($arr_data['H1']-$arr_data['H1QC'])+($arr_data['H2']-$arr_data['H2QC'])+($arr_data['H3']-$arr_data['H3QC'])); ?></strong></td>
	                </tr>
	             </table></td>
	           </tr>
	         </table>
	         <br></td>
        </tr>
		   <tr>
		     <td>&nbsp;</td>
        </tr>
		   <tr>
          <td><a href="?xtype=1">�������������</a> || <a href="?xtype=0">�ѧ��������������</a> || <a href="?xtype=QC">QC ����</a> || <a href="?xtype=NQC">�ѧ����� QC</a> || <a href="?xtype=">�ʴ������ŷ�����</a></td>
        </tr>
		   <tr>
		     <td>&nbsp;</td>
        </tr>
		   <tr>
		     <td><!--�����˵� : �Ƿ�������Ҥ���ѧ����ա�ù���Ң����Ũҡ�ҹ������ Checklist ��� �ҹ������ CMSS , �բ�Ǥ��͹���Ң��������ҹ������ CMSS �����͡�úѹ�֡���������º��������--></td>
        </tr>
		   <tr>
		     <td bgcolor="#000000">
             <table width="100%" border="0" cellspacing="1" cellpadding="2">  
             <?
             	 if($xtype == "1"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='1'";
				 	$xtitle = "��§ҹ�����ż������÷��������������";
				 }else if($xtype == "0"){ 
				 	$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.status_key='0'"; 
					$xtitle = "��§ҹ�����ż������÷���ѧ��������������";
				}else if($xtype == "QC"){
					$conw1 = " AND ".DB_USERENTRY.".temp_report_executive.staff_qc <> '' AND ".DB_USERENTRY.".temp_report_executive.staff_qc IS NOT NULL";  	
					$xtitle = "��§ҹ�����ż������÷��QC ����";
					}else if($xtype == "NQC"){
					$conw1 = "AND (edubkk_userentry.temp_report_executive.staff_qc = '' or ".DB_USERENTRY.".temp_report_executive.staff_qc IS NULL)";
					$xtitle = "��§ҹ�����ż������÷���ѧ�����QC ";
				}
			   else{
				   $conw1 = "";
				   $xtitle = "��§ҹ�����ż������÷�����";
				 }

			 ?>
		       <tr>
		         <td colspan="12" align="center" bgcolor="#A5B2CE"><strong><? echo $xtitle;?></strong></td>
	           </tr>
		       <tr>
		         <td width="3%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>�Ţ�ѵû�ЪҪ�</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>���� - ���ʡ��</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ѹ��͹���Դ</strong></td>
		         <td width="10%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
		         <td width="13%" align="center" bgcolor="#A5B2CE"><strong>ʾ�.</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ʶҹй�<br>
	             ��Ң�����</strong></td>
		         <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ʶҹ�<br>
	             ���������</strong></td>
		         <td width="9%" align="center" bgcolor="#A5B2CE"><strong>��ѡ�ҹ QC</strong></td>
		         <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ѹ��� QC</strong></td>
		         <td width="12%" align="center" bgcolor="#A5B2CE"><strong>����ͧ���</strong></td>
		         <td width="6%" align="center" bgcolor="#A5B2CE"><strong>QC</strong></td>
	           </tr>
               <?
               	$sql = "SELECT ".DB_USERENTRY.".temp_report_executive.idcard, ".DB_USERENTRY.".temp_report_executive.siteid, ".DB_USERENTRY.".temp_report_executive.prename_th, ".DB_USERENTRY.".temp_report_executive.name_th, ".DB_USERENTRY.".temp_report_executive.surname_th, ".DB_USERENTRY.".temp_report_executive.birthday, ".DB_USERENTRY.".temp_report_executive.position_now, ".DB_USERENTRY.".temp_report_executive.staff_key, ".DB_USERENTRY.".temp_report_executive.staff_qc, ".DB_USERENTRY.".temp_report_executive.date_qc, ".DB_USERENTRY.".temp_report_executive.status_key,
 ".DB_MASTER.".eduarea.secname
FROM ".DB_USERENTRY.".temp_report_executive
Inner Join  ".DB_MASTER.".eduarea ON ".DB_USERENTRY.".temp_report_executive.siteid =  ".DB_MASTER.".eduarea.secid
WHERE ".DB_USERENTRY.".temp_report_executive.idcard <> '' $conw1
ORDER BY ".DB_USERENTRY.".temp_report_executive.siteid ASC,edubkk_userentry.temp_report_executive.position_now ASC";
				$result = mysql_db_query($dbnameuse,$sql);
				$i=0;
				$k=0;
				while($rs = mysql_fetch_assoc($result)){
						$i++;
						//if($k % 2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
						if($i == 1){ $temp_siteid = $rs[siteid];}
						if($rs[siteid] != $temp_siteid){ $k++; $temp_siteid = $rs[siteid];}
						if($k % 2){ $bg = "#CCCCCC";}else{$bg = "#FFFFFF";}	
						
						$urlpath = "../../../edubkk_kp7file/$rs[siteid]/" . $rs[idcard] . ".pdf"  ;
						if(is_file($urlpath)){
								$pdf_org = "<a href='/edubkk_kp7file/$rs[siteid]/$rs[idcard].pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'  /></a>";
						}else{
								$pdf_org = "";	
						}
						
						
					$pdf	= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\">";
				 $pdf		.= "<img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='�.�.7 ���ҧ���к� '  ></a>";
				 
				 	$sql_imp = "SELECT COUNT(idcard) AS numid FROM tbl_check_data WHERE idcard='$rs[idcard]' AND secid='$rs[siteid]'";
					$result_imp = mysql_db_query($db_temp,$sql_imp);
					$rsi = mysql_fetch_assoc($result_imp);
					
					if($rsi[numid] > 0){
						$img_import = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" title=\"ʶҹй���Ң�������� CMSS �����ͧ��úѹ�֡���������º��������\">";
					}else{
						$img_import = "<img src=\"../../images_sys/cancel_s.png\" width=\"13\" height=\"13\" border=\"0\" title=\"�ѧ��������Ң�����\">";
					}// end 	if($rsi[numid] > 0){
			   ?>
           
		       <tr bgcolor="<?=$bg?>">
		         <td align="center"><?=$i?></td>
		         <td align="center"><?=$rs[idcard]?></td>
		         <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
		         <td align="center"><? echo thaidate1($rs[birthday]);?></td>
		         <td align="left"><? echo $rs[position_now];?></td>
		         <td align="left"><? echo str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname]);?></td>
		         <td align="center">
                 <?
					echo $img_import;
				 ?>
                 </td>
		         <td align="center"><? if($rs[status_key] == 1){ echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�ѹ�֡������������к�����\">";}else{ echo " <img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�ѧ�����ѹ�֡������\">";} 
?>
	            </td>
		         <td align="left"><? if($rs[staff_qc] != ""){ echo GetStaffQc($rs[staff_qc]);}?></td>
		         <td align="center"><? echo thaidate($rs[date_qc]);?></td>
		         <td align="center"><? echo " <a href='../hr3/hr_report/general_all_1search.php?xid=$rs[idcard]&action=edit' target='_blank'> <img src='../../images_sys/doc_zoom.png' alt='�ʴ���������ػ' width='16' height='16' border='0' /></a> &nbsp; $pdf_org &nbsp; $pdf "; 	?><A href="../hr3/hr_report/report_main_govplan.php?id=<?=$rs['idcard']?>&xsiteid=<?=$rs['siteid']?>" target="_blank"><IMG SRC="../hr3/hr_report/images/organization.gif" WIDTH="23" HEIGHT="23" BORDER="0" ALT="" align="absmiddle"></A></td>
		         <td align="center"><a href="../hr3/hr_report/report_check/report_check_data.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../validate_management/images/zoom.png" width="16" height="16" / border="0" alt="˹����§ҹ��º label �Ѻ value"></a>&nbsp;<a href="../hr3/tool_competency/diagnosticv1/validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?>&staffname=<?=GetStaffQc($rs[staff_key])?>&staffid=<?=$rs[staff_key]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" alt="�������ͺѹ�֡�����Դ��Ҵ��úѹ�֡������"></a></td>
	           </tr>
               <? 
				}//end 
			   ?>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table> 

</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>