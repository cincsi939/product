<?
include ("../../../../common/class.salarylevel.php")  ; 
$yy = "2547";
$db_name = "edubkk_userentry";
$dbnameuse = $db_name;
$db_system = "edubkk_system";
$dbname_temp = "edubkk_checklist";
$ratio_t1 = 5; // ��Ҥ�ṹ�ѡ�ç���ҧ
$ratio_t2 = 5; // ��Ҥ�ṹ�ѡ�����Դ
##  config  ��õ�Ǩ�ͺ��úѹ�֡�Թ��͹�֧���ش����
//$salary_date = (date("Y")+543);
$salary_date = "2553";
$date_profile = "2553-10-01";
$age_startdate = 18; // ���ط������ö������è��Ҫ�����
$config_diff_beginstart_date = 1; // ��˹�����ѹ�������Ժѵ��Ҫ�������ѹ�ѧ��èص�ͧ��ҧ�ѹ����Թ 1 ��
//$salary_date = "2552";
$xwraning = "!wraning ";

$image_path = "../../../../../image_file/" ;
$path_pdf = "../../../../../edubkk_kp7file/";
$imgpdf = "<img src='../../../../images_sys/gnome-mime-application-pdf.png' alt='���� �.�.7 �鹩�Ѻ' width='20' height='21' border='0'>";	
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$arrstaff = array("��ѡ�ҹ���Ǥ���","��ѡ�ҹ��Ш�","Subcontract");



function GetFieldComment(){
	global $dbname_temp;
	$sql  = "SELECT field_comment,pre_error FROM tbl_check_menu ORDER BY pre_error ASC ";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[pre_error]] = $rs[field_comment];
	}//end while($rs = mysql_fetch_assoc($result)){
		mysql_free_result($result);
	return $arr;
		
}//end 



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




#### fucntion �ʴ����;�ѡ�ҹ���ѹ�֡������
function ShowStaffKey($get_staffid){
	$db = "edubkk_userentry";
	$sql = "SELECT staffid,prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($db,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function ShowStaffKey($get_staffid){
	
	
	function GetMistaken($get_mistaken){
	global $db_name;
		$sql_p = "SELECT * FROM validate_mistaken WHERE mistaken_id='$get_mistaken'";
		$result_p = mysql_db_query($db_name,$sql_p);
		$rs_p = mysql_fetch_assoc($result_p);	
		mysql_free_result($result_p);
		return $rs_p[mistaken];
}
### fucntion �� ticketid
function GetTicketId($get_idcard,$get_staffid){
	global $db_name;
			$sql = "SELECT
		tbl_assign_key.ticketid
		FROM
		tbl_assign_key
		Inner Join tbl_assign_sub ON tbl_assign_key.ticketid = tbl_assign_sub.ticketid
		WHERE
		tbl_assign_sub.staffid =  '$get_staffid' AND
		tbl_assign_key.idcard =  '$get_idcard' AND
		tbl_assign_key.nonactive =  '0'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $rs[ticketid];	
}

## function ��Ǩ�ͺ��õ�Ǩ������
function CheckTrueData($get_idcard,$get_staffid){
	global $db_name;
	$TicketID = GetTicketId($get_idcard,$get_staffid);
	$sql = "SELECT COUNT(idcard) AS numc FROM validate_checkdata  WHERE idcard='$get_idcard' AND staffid='$get_staffid' AND ticketid='$TicketID'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[numc];
	
}//end function CheckTrueData(){
	
	
### ��˹��

function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_siteid,$key_idcard,$key_name,$key_surname,$date_key,$key_staffid,$key_action,$action;

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
			$table .= "<a href=\"?page=1&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people".$kwd."\"><u><font color=\"black\">˹���á</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">˹���ش����</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">�ʴ�������</font></u></a>";
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

### funciton ��Ǩ�ͺ ��úѹ�֡�š�õ�Ǩ�ͺ���������ͧ�鹢ͧ��ѡ�ҹ���������
function CheckUserKeyApprove($get_idcard){
	global $db_name;
	$sql_c = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE idcard='$get_idcard' AND nonactive='0' AND userkey_wait_approve='1' ";
	$result_c = mysql_db_query($db_name,$sql_c);
	$rs_c = mysql_fetch_assoc($result_c);
	mysql_free_result($result_c);

	return $rs_c[num1];
		
}//end function CheckUserKeyApprove($get_idcard){
	
### function �Ǩ�ͺ����ա�� QC ����ѧ
function CheckQcPerDayPerson($get_staff,$get_idcard){
	global $db_name;
	$sql = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' AND idcard='$get_idcard' GROUP BY idcard";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[num1];
}//end function CheckQcPerDay($get_staff,$get_idcard){
	
	
	####  funciton ��Ǩ�ͺ����ա�� �Ѻ�ͧ�ʹ�����������
function CheckAppriveIncentive($temp_date){
	global $db_name;
	$sql = "SELECT COUNT(datekeyin) AS num1 FROM stat_incentive WHERE datekeyin LIKE '$temp_date%' GROUP BY datekeyin";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[num1];
}//end function CheckAppriveIncentive(){
	
### function ��Ǩ�ͺ��������й�令ӹǳ��������㹡�õ�Ǩ�ͺ
function CheckGroupKey($get_staffid){
	global $db_name;
	$sql_staff = "SELECT if(keyin_group='1' or keyin_group='2', 1,0) as group_val  FROM keystaff  WHERE  staffid='$get_staffid'";
	$result_staff = mysql_db_query($db_name,$sql_staff);
	$rs_staff = mysql_fetch_assoc($result_staff);
	mysql_free_result($result_staff);
	return $rs_staff[group_val];
}//end function CheckGroupKey($get_staffid){
	
	
function ShowSdateEdate($get_date){ 
unset($arr_date);
unset($xFTime);
 $arr_d1 = explode("-",$get_date);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 ��� �Ţ�ѻ���� �ͧ�ѹ�ѹ���
 ## 6 ��� �Ţ�ѻ���� �ͧ�ѹ�����
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�

				 $xbasedate1 = strtotime("$get_date");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// �ѹ�Ѵ�	
				 
				 $arr_date['start_date'] = $xsdate;
				 $arr_date['end_date'] = $xsdate1;
	return $arr_date;
}//end function ShowSdateEdate(){
	
	
	### function 㹡�äӹǹ ��Ҥ�ṹ�ش�Դ
function CalSubtract($get_idcard,$get_staffid,$get_ticketid){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$sql_cal = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t1)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard =  '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.ticketid =  '$get_ticketid'  AND 
validate_checkdata.status_cal='0'  AND validate_checkdata.status_process_point='YES'";
//echo $sql_cal."<br>";
	$result_cal = mysql_db_query($dbnameuse,$sql_cal);
	$rs_cal = mysql_fetch_assoc($result_cal);
	mysql_free_result($result_cal);
	if($rs_cal[sumval] > 0){
		return $rs_cal[sumval];	
	}else{
		return 0;	
	}
	
}//end function CalSubtract(){
###  �ӹǳ���з���繢ͧ�ѹ������������ͧ�ش�����ѧ QC ����
function CalPointSubtractAdd($get_idcard,$get_staffid,$get_date){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$sql_cal = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard <> '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.qc_date =  '$get_date' AND validate_checkdata.status_process_point='YES' ";
	$result_cal = mysql_db_query($dbnameuse,$sql_cal);
	$rsc = mysql_fetch_assoc($result_cal);
	mysql_free_result($result_cal);
	if($rs_cal[sumval] > 0){
		return $rs_cal[sumval];		
	}else{
		return 0;	
	}
	
		
}//end function CalPointSubtractAdd($get_staffid,$get_date){

function CalSubtractAB($get_staff,$get_date){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$arrdate = ShowSdateEdate($get_date); // ���ѹ��������������ش�ͧ�����ѻ����
	$sql_ab = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.staffid =  '$get_staff' AND
validate_checkdata.datecal BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND validate_checkdata.status_process_point='YES'
group by validate_checkdata.idcard
order by sumval DESC
LIMIT 1";
	$result_ab = mysql_db_query($dbnameuse,$sql_ab);
	$rs_ab = mysql_fetch_assoc($result_ab);
	mysql_free_result($result_ab);
	return $rs_ab[sumval];
}//end function CalSubtractAB($get_staff,$get_date){
	
#####  function �ʴ���� Ratio ��� QC �ͧ���С����������
function ShowQvalue($get_staffid){
	global $dbnameuse;
	$sqlQ = "SELECT
keystaff_group.rpoint
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff.staffid =  '$get_staffid'";
	$resultQ = mysql_db_query($dbnameuse,$sqlQ);
	$rsQ = mysql_fetch_assoc($resultQ);
	mysql_free_result($resultQ);
	return $rsQ[rpoint];
}//end function ShowQvalue($get_staffid){

function NumP($get_staffid,$get_idcard){
	global $dbnameuse;
	$sqlP = "SELECT distinct idcard FROM `validate_checkdata`  where staffid='$get_staffid'  and idcard ='$get_idcard'";
	$resultP = mysql_db_query($dbnameuse,$sqlP);
	$numP = @mysql_num_rows($resultP);
	mysql_free_result($resultP);
	return $numP;
}

function CheckGroupStaff($get_staffid){
	global $dbnameuse;	
	$sql = "SELECT keyin_group FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[keyin_group];
}
function CutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = $arr1[0].".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = $temp_point.".00";	
		}else if($temp_point == "0"){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){
	
	function ViewCutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = number_format($arr1[0]).".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = number_format($temp_point).".00";	
		}else if($temp_point == 0){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){


###  ��Ǩ�ͺ������� 1 �ѻ���� �ա�õ�Ǩ�Թࡳ����ӡ�˹������� ����� A 1 �ش����ѻ���� ����� B 2 �ش����ѻ���� ����Թ�Фӹǳ��Ҥ�ṹ��ǧ���˹ѡ�¡�������
function CheckQC_Per_Week($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$group_type = CheckGroupStaff($get_staffid);
	if($group_type == "1" or $group_type == "2"){ // �繡���� a ��� b
		$sql1 = "SELECT sum(num_p) AS nump FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey between '$xsdate' and '$xedate'";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			if($rs1[nump] > $group_type){ // �óշ��ӹǹ�ش���������Ǩ�ҡ���Ҥ���ҵðҹ���������Ǩ
			$sql2 = "SELECT (sum(spoint)/sum(num_p)) as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$result2 = mysql_db_query($dbnameuse,$sql2);
			$rs2 = mysql_fetch_assoc($result2);
			$pval = CutPoint($rs2[numval]);
			
			## ���ѹ���зӡ�úѹ�֡㹪�ǧ�ѻ�����
			$sql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$result3 = mysql_db_query($dbnameuse,$sql3);
			$rs3 = mysql_fetch_assoc($result3);
			$date_save = $rs3[datekey];
			
			$sql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			$result4 = mysql_db_query($dbnameuse,$sql4);
			$rs4 = mysql_fetch_assoc($result4);
				//if($rs4[NUM1] < 1){ // �ó��ѧ�������纤������¡�úѹ�֡������
					$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
					//echo $sql_insert."<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
				### �óշ��ӹǹ�ش����Ǩ�ç�Ѻ����ҵðҹ			
			}else{
			$xsql2 = "SELECT sum(spoint)as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$xresult2 = mysql_db_query($dbnameuse,$xsql2);
			$xrs2 = mysql_fetch_assoc($xresult2);
			$pval = CutPoint($xrs2[numval]);
			
			## ���ѹ���зӡ�úѹ�֡㹪�ǧ�ѻ�����
			$xsql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$xresult3 = mysql_db_query($dbnameuse,$xsql3);
			$xrs3 = mysql_fetch_assoc($xresult3);
			$date_save = $xrs3[datekey];
			
			$xsql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			echo "<br>$xsql4<br>";
			$xresult4 = mysql_db_query($dbnameuse,$xsql4);
			$xrs4 = mysql_fetch_assoc($xresult4);
				//if($xrs4[NUM1] < 1){
						$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
						echo "<br><br>$sql_insert<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
	
			}//end if($rs1[nump] > $group_type){
	### �óշ����������� A ��� B
	}else{
		$sql_insert1 = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p) SELECT stat_subtract_keyin.staffid,
		stat_subtract_keyin.datekey,stat_subtract_keyin.spoint,stat_subtract_keyin.num_p
  FROM stat_subtract_keyin  WHERE stat_subtract_keyin.staffid='$get_staffid' AND stat_subtract_keyin.datekey='$get_date'";	
  		mysql_db_query($dbnameuse,$sql_insert1);
	}//end 	if($group_type == "1" or $group_type == "2"){ 
	
}//end function CheckQC_Per_Week($get_staffid,$get_date){
	
####  ��Ǩ�ͺ�����������ա���ѡ��Ҥ�ṹź���ѧ
function CheckSubpointAvg($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$sql = "SELECT sum(subtract) as s_val FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin  between '$xsdate' and '$xedate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[s_val];
}
###  function ����������������繤��Ҥ�ṹ��������ź�Ѻ��ṹ��ǧ���˹ѡ
function SumTempPoint($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$arr_d1 = explode("-",$get_date);
	$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]+1), intval($arr_d1[2]-1), intval($arr_d1[0]))));
	$end_date = $arr_d1[0]."-".$arr_d1[1]."-".$xFTime['mday'];
	$sql = "SELECT
sum(stat_incentive_temp.kpoint_add) as kpoint_add,
sum(stat_incentive_temp.subtract) as subtract
FROM `stat_incentive_temp`
where staffid='$get_staffid' and datekeyin  between '$start_date1' and '$end_date' ";
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);

	//echo $rs[net_point]."<br>";
	return $rs[kpoint_add]-$rs[subtract];
}

###  function ��Ǩ�ͺ���������͹��äӹǳ����
function CheckPointADD($get_staffid,$get_date){
	global $dbnameuse;
	$sql = "SELECT COUNT(staffid) AS numc FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$get_date' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numc];
}

### function ��Ǩ�ͺ����ա�� QC �������
function CheckQC1($get_staffid,$get_date){
	global $dbnameuse;	
	$sql = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg WHERE staffid='$get_staffid' AND datekey='$get_date' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
}
###  �����ṹ����������ͧ�ѡ
function SumAdd($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$sql = "SELECT ROUND(SUM(kpoint_add),2) AS sumadd FROM stat_incentive WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[sumadd];
}//end function SumAdd(){
	
### sum ���ź��͹
function xSumSubtract($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$yymm = $arrxd[0]."-".$arrxd[1];
	if($arrxd[2] != "01"){ // �ó�������ѹ��� 1 �ͧ��͹
		$xbasedate = strtotime("$get_date");
		$xdate = strtotime("-1 day",$xbasedate); // ��͹��ѧ� 1 �ѹ
		$xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�
		$condate = $xsdate;
	}else{
		$condate = $get_date;	
	}
	## ��Ǩ�ͺ��͹��ҡ�͹˹�ҹ���դ����������������
	$sqlx = "SELECT SUM(net_point) as sumx1 FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date' ";
	$resultx = mysql_db_query($dbnameuse,$sqlx);
	$rsx = mysql_fetch_assoc($resultx);
	
	
	$sql = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$condate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[net_point] == 0){
		if($rsx[sumx1] != 0){
			$sql1 = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND net_point <> 0 ORDER BY datekeyin DESC LIMIT 1";	
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$stat_val = $rs1[net_point];
		}	
	}else{
			$stat_val = $rs[net_point];
	}
	
	return $stat_val;
}
### ���ѹ�������Ժѵԧҹ
function ShowStartDate($staffid){
	global $dbnameuse,$monthname;
	$sql = "SELECT date(timeupdate) as start_date  FROM `monitor_keyin` where staffid='$staffid' AND date(timeupdate) <> '0000-00-00' order by timeupdate ASC LIMIT 1";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$d1=explode("-",$rs[start_date]);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
	
}// end function ShowStartDate($staffid){
	
######## �ѧ�������ѹ���ӡ�� QC
function GetDateQC($get_idcard,$staffid,$ticketid){
	global $dbnameuse;
	$sql_date = "SELECT qc_date FROM validate_checkdata WHERE validate_checkdata.idcard='$get_idcard' AND validate_checkdata.staffid='$staffid' AND validate_checkdata.ticketid='$ticketid' ";
	$result_date = mysql_db_query($dbnameuse,$sql_date);
	$rsd = mysql_fetch_assoc($result_date);
	return $rsd[qc_date];	
}//end function GetDateQC(){
################  �ѧ���蹤ӹǳ��Ҥ�ṹ�óշ���ա�äӹǹ����
function CalSubtractQc($get_idcard){
	global $dbnameuse;
	$sql = "SELECT DISTINCT
monitor_keyin.idcard,
monitor_keyin.staffid,
tbl_assign_key.ticketid,
monitor_keyin.timestamp_key as timeupdate
FROM
monitor_keyin
Inner Join tbl_assign_key ON monitor_keyin.idcard = tbl_assign_key.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND  monitor_keyin.idcard = '$get_idcard'  order by monitor_keyin.timestamp_key DESC LIMIT 1 ";	
//echo $sql;die;
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr_d = explode(" ",$rs[timeupdate]);
	$datereq1 = $arr_d[0];// �ѹ���ӡ�� QC
	//echo $rs[staffid] ." :: ".$rs[idcard];die;
	$nump = NumP($rs[staffid],$rs[idcard]);
	$subtract = CalSubtract($rs[idcard],$rs[staffid],$rs[ticketid]); // ��Ҥ�ṹ���ӹǳ��
	$qc_date = GetDateQC($rs[idcard],$rs[staffid],$rs[ticketid]); // ���ѹ���ӡ�� QC ���ͨ������繤�ṹź�ͧ�ѹ������
	
	if($qc_date != "0000-00-00" and $qc_date != ""){
			$datereq1 = $qc_date;
	}else{
			$datereq1 = $datereq1;
	}//end if($qc_date != "0000-00-00" and $qc_date != ""){
	//echo $subtract;die;
	$sql_update = "UPDATE validate_checkdata SET validate_checkdata.status_cal='1' ,validate_checkdata.datecal='$datereq1'  WHERE validate_checkdata.idcard='$rs[idcard]' AND validate_checkdata.staffid='$rs[staffid]' AND validate_checkdata.ticketid='$rs[ticketid]' and status_cal='0'";
	//echo $sql_update."<br>";
	@mysql_db_query($dbnameuse,$sql_update);
	
	$subtract_add = CalPointSubtractAdd($rs[idcard],$rs[staffid],$datereq1);
	
	$arr_subtract[$rs[staffid]] = $arr_subtract[$rs[staffid]]+$subtract+$subtract_add;
	$arr_num_p[$rs[staffid]] = $arr_num_p[$rs[staffid]]+$nump;
	
	
	 $arr_d1 = explode("-",$datereq1);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 ��� �Ţ�ѻ���� �ͧ�ѹ�ѹ���
 ## 6 ��� �Ţ�ѻ���� �ͧ�ѹ�����
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$datereq1");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�
				 
				 $xbasedate1 = strtotime("$datereq1");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// �ѹ�Ѵ�

	
	#########  ��㹰ҹ������
	if(count($arr_subtract) > 0){
	foreach($arr_subtract as $key => $val){		
		$group_type = CheckGroupKey($key); // ��Ǩ�ͺ�������ä�������Ŷ�Ҥ�� �� 1 �ʴ���� �� ����� A ��� ����� B ��觨й����ѡ�����ǧ���ҷ���˹�
		if($group_type > 0){
			$str_update = " ,sdate='$xsdate',edate='$xsdate1' ";
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate,num_p)VALUES('$key','$datereq1','$val','$xsdate','$xsdate1','".$arr_num_p[$key]."')";
		}else{
			$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p)VALUE('$key','$datereq1','$val','".$arr_num_p[$key]."')";	
			$str_update = "";
		}//end if($group_type > 0){
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$key' AND datekey='$datereq1'";
		$result_select = mysql_db_query($dbnameuse,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // �ó��բ����� ���ź����㹵��ҧ������������Ǩ�ͺ��ҡ�͹�ѹ�֡
			if($val > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$val',num_p='$arr_num_p[$key]' $str_update  WHERE staffid='$key' AND datekey='$datereq1'";
				//echo " UP  ::".$sql_insert."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert);
			}//end 	if($val > 0){	
		}else{
				if($val > 0){
					//echo "insert ::".$sql_insert1."<br><br>";
				mysql_db_query($dbnameuse,$sql_insert1);
				}//end if($val > 0){
		}//end if($rs_s[spoint] > 0){

		
	}//end foreach($arr_subtract as $key => $val){ 
		
	}//end if(count($arr_subtract) > 0){


}//end function CalSubtractQc($get_idcard){
	
####  function �ʴ��ѹ�����������
function ShowYYMMKey($get_idcard,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT
date(monitor_keyin.timeupdate) as datekey
FROM `monitor_keyin`
where staffid='$get_staffid' and idcard = '$get_idcard'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[datekey];
}//end function ShowYYMMKey($get_idcard,$get_staffid){
	
###  ��Ǩ�ͺ��Ҷ���ա�ä�����������͹حҵ���� QC
function CheckOnlineKey($get_idcard){
	global $db_system;
	$sql = "SELECT COUNT(username) as numkey FROM useronline WHERE username='$get_idcard'";
	//echo "$sql";
	$result = mysql_db_query($db_system,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numkey];	
}// end function CheckOnlineKey(){
	
	
### function Show Flag_qc 
function ShowFlagQc($idcard,$staffid){
		global $dbnameuse;
		$sql = "SELECT  flag_qc  FROM stat_user_keyperson WHERE idcard='$idcard' AND staffid='$staffid' LIMIT 1";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[flag_qc];
}//end function ShowFlagQc(){
	
#####  function UPDATE ��� approve ��ä��������㹵��ҧ assign
function ApproveAssign($idcard,$flagid="",$staffid=""){
		global $dbnameuse;
		if($flagid > 0){
			$sql_main = "SELECT * FROM stat_user_keyperson WHERE staffid='$staffid' AND flag_qc='$flagid'";
			$result_main = mysql_db_query($dbnameuse,$sql_main);
			while($rsm = mysql_fetch_assoc($result_main)){
					$sql = "UPDATE  tbl_assign_key SET approve='2' WHERE idcard='$rsm[idcard]'";
					mysql_db_query($dbnameuse,$sql);
			}//end while($rsm = mysql_fetch_assoc($result_main)){
				
		}else{
			$sql = "UPDATE tbl_assign_key  SET approve='2' WHERE idcard='$idcard'";	
			mysql_db_query($dbnameuse,$sql);
		}//end 	
}//end function ApproveAssign(){
	
	
	
	
	function insert_log_checklist($get_siteid,$get_idcard,$get_action="",$staff_id="",$get_schoolid="",$get_siteid_old="",$get_schoolid_old="",$profile_id=""){
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
	$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,time_update,type_action,schoolid,siteid_old,schoolid_old,user_save,profile_id) values($get_idcard,'$get_siteid','$staff_id','$ip','$get_action',now(),'1','$get_schoolid','$get_siteid_old','$get_schoolid_old','".$_SESSION[session_staffid]."','$profile_id');"; 
	mysql_db_query($dbname_temp,$sql);
}//enfd function insert_log_checklist($get_siteid,$get_idcard,$get_action="",$get_type="",$staff_id="",$get_schoolid="",$get_siteid_old="",$get_schoolid_old="",$profile_id=""){



function ShowArea($get_siteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $rs[secname];	
}// end function ShowArea($get_siteid){

function ShowSchool($get_school){
	global $dbnamemaster;
	$sql = "SELECT office FROM allschool WHERE id='$get_school'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[office];
}

function LastProfile(){
	global $dbname_temp;
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		$rspro = mysql_fetch_assoc($result_profile);
		mysql_free_result($result_profile);
		$profile_id = $rspro[profile_id];
		return $profile_id;

}//end function LastProfile(){



	##############  ��Ǩ�ͺ��� �.�. 7 �鹩�Ѻ
	function CheckKp7file($xsiteid,$idcard){
		global $path_pdf,$imgpdf;
		unset($arr);		
		$ch_file = $path_pdf."".$xsiteid."/".$idcard.".pdf" ;
		
		if(!is_file($ch_file)){
				$arr[0] = 0;
				$arr[1] = "������͡��� �.�.7 �鹩�Ѻ";
		}else{
				$arr[0] = 1;
				$arr[1] = "";
		}//end if(!is_file($ch_file)){
			return $arr;
			
		
	}//end function CheckKp7file($idcard){
	#########  end ��Ǩ�ͺ �.�.7 �鹩�Ѻ


	function CheckIDCard($idcard){//��Ǩ�ͺ�����١��ͧ�ͧ�Ţ�ѵ�
      //return error type
      //0=�١��ͧ
      //1=���ú13 ��ѡ ���� �Թ
      //2=���١��ͧ��������û���ͧ
      //3=�����ҧ
      if(strlen($idcard)==13){
        $id=str_split($idcard); 
        $sum=0;    
        for($i=0; $i < 12; $i++){
        if(is_numeric($id[$i])){   
             $sum += floatval($id[$i])*(13-$i);            
          if((11-$sum%11)%10!=floatval($id[12])){
             return 2;
         }else{
             return 0; 
         }
        
        }else{
           return 2; 
        } 
        }  
    }else{
        if($idcard==""){
            return 3; 
        }else{
         return 1; 
        }
        
    }   
}//end function CheckIDCard($idcard){//��Ǩ�ͺ�����١��ͧ�ͧ�Ţ�ѵ�


 function XDate_Diff($datefrom,$dateto,$xtype=""){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        
        $differnce = $startDate - $lastDate;
		if($xtype == "Y"){
        	$differnce = floor(($differnce / (60*60*24))/365); //�ó׷���ͧ������ return ����繻�
		}else if($xtype == "M"){
			$differnce = floor(($differnce / (60*60*24))/30); //�ó׷���ͧ������ return �������͹
		}else{
			$differnce = floor(($differnce / (60*60*24))); //�ó׷���ͧ������ return ������ѹ
		}

        return $differnce;
  }//end  function Datediff($datefrom,$dateto){
	  
	  
	 //���繻� ��. �� ���ѹ�á��ͧ���¡����ѹ����ͧ
function dateDiff($d1,$d2) {
$mday = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
unset($x1);
unset($x2);
unset($ret);

	$x1 = explode("-",$d1);
	$x2 = explode("-",$d2);

	// �ӹǹ��
	$ny = intval($x2[0]) - intval($x1[0]);

	if (intval($x1[1]) <= intval($x2[1])){  //��͹ ��ǵ���ҡ����
		$nm = intval($x2[1]) - intval($x1[1]);
	}else{
		$nm = intval($x2[1]) + 12 - intval($x1[1]);
		$ny --; // Ŵ��ŧ
	}

	if (intval($x1[2]) <= intval($x2[2])){  //�ѹ ��ǵ���ҡ����
		$nd = intval($x2[2]) - intval($x1[2]);
	}else{
		$mday[2] = date("d",mktime (0,0,0,3,0,intval($x2[0]) ));  // �Ҩӹǹ�ѹ�ͧ��͹����Ҿѹ��
		$xmonth = intval($x2[1]) - 1;  //��͹��͹���
		if ($xmonth <= 0){
			$xday = 31; 
		}else{
			$xday = $mday[$xmonth];
		}

		$nd = intval($x2[2]) + $xday - intval($x1[2]);
		$nm --; // Ŵ��͹

		if ($nm < 0){ // ��͹�á (Ŵ��������� 0)
			$nm = 11;
			$ny--;
		}
	}

	$ret = array("day" => $nd,"month" => $nm, "year" => $ny);
	return $ret;
} //end function dateDiff($d1,$d2) {



	 
	 //$arrd1 = dateDiff("2523-05-16","2523-07-14"); 
	 
	//echo "<pre>";
	//print_r($arrd1);

function ShowKp7FileBlue($idcard){
		global $dbname_temp;
		$sql = "SELECT kp7file  FROM `tbl_checklist_log_uploadfile` WHERE idcard='$idcard' order by date_upload desc limit 1";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		mysql_free_result($result);
		if(is_file($rs[kp7file])){
			return 1;
		}else{
			return 0;	
		}/// end if(is_file($rs[kp7file])){
}//end function ShowKp7FileBlue(){
	

#######  function ��Ǩ�ͺ�ӹǹ�ٻ��к���ͧ��ҡѺ�ӹǹ�ٻ� checklist
function CheckNum_imageKp7($xsiteid,$idcard,$profile_id,$pic_num){
	global $dbname_temp;
	unset($arr);
	$dbsite = STR_PREFIX_DB.$xsiteid;
	$numpic_checklist = intval($pic_num); // �ӹǹ�ٻ� checklist
	$sql1 = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$idcard' GROUP BY id";
	$result1  =mysql_db_query($dbsite,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	mysql_free_result($result1);
	$numpic_cmss = intval($rs1[numpic]);
	
	if($numpic_checklist != $numpic_cmss){
			$arr[0] = 0;
			$arr[1] = "�ӹǹ�ٻ��к��� $numpic_cmss �ٻ �ӹǹ�ٻ� checklist �� $numpic_checklist �ٻ ";
	}else{
			$arr[0] = 1;	
			$arr[1] = "";
	}
	
	return $arr;
}// end function CheckNum_imageKp7($xsiteid,$idcard,$profile_id){
#############  end ��Ǩ�ͺ�ӹǹ�ٻ��к���ͧ��ҡѺ�ӹǹ�ٻ� checklist

################  ��Ǩ�ͺ�ٻ�������к�
function CheckImageSys($xsiteid,$idcard){
	global $image_path,$xwraning;
	unset($arr);
	$dbsite = STR_PREFIX_DB.$xsiteid;
	$sql = "SELECT id,no,imgname FROM general_pic WHERE id='$idcard' order by no ASC";
	//echo $dbsite." :: ".$sql;
	$result = mysql_db_query($dbsite,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$imagefile = $image_path.$xsiteid."/$rs[imgname]"; 
			//echo "<img src='$imagefile'>$imagefile</a>";
			if(!(file_exists($imagefile))){
				if($xmsg1 > "") $xmsg1 .= ",";	
				$xmsg1 .= " $rs[imgname]";
			}// end if(!(file_exists($imagefile))){
				
	}//end while($rs = mysql_fetch_assoc($result)){
		
		if($xmsg1 != ""){
				$arr[0] = 0;
				$arr[1] = "��辺�ٻ�Ҿ��к� ".$xmsg1." ��سҵԴ��ͷ���Ѵ�ٻ";
		}else{
				$arr[0] = 1;
				$arr[1] = "";	
		}//end 	if($xmsg1 != ""){
		
	mysql_free_result($result);	
	$xmsg1 = "";
	return $arr;

		
}//end function CheckImageSys($idcard){

###  function ��Ǩ�ͺ �� �.�. ���ٻ����к�
function CheckYY_image($xsiteid,$idcard){
global $xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT count(id) as num  FROM `general_pic` where  id='$idcard' and yy < 1";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[num] > 0){
			$arr[0] = 0;
			$arr[1] = "�ըӹǹ�ٻ�������кػ� �.�. ���� $rs[num] �ٻ";
	}else{
			$arr[0] = 1;
			$arr[1] = "";	
	}
	mysql_free_result($result);
	return $arr;
}//end function CheckYY_image(){


####  function  ��Ǩ�ͺ �����ѹ��͹���Դ
function CheckName_Birthday($birthday,$prename_th,$name_th,$surname_th){
	global $xwraning;
		
		unset($arr);
		if(($birthday == "0000-00-00" or $birthday = "")){
				$xmsg .= "������к��ѹ��͹���Դ";
		}
		if($prename_th == ""){
				$xmsg .= "������кؤӹ�˹�Ҫ���";
		}
		if($name_th == ""){
				$xmsg .= "������кت���";
		}
		if($surname_th  == ""){
				$xmsg .= "������кع��ʡ��";
		}
		
		if(trim($xmsg) != ""){
			$arr[0] = 0;
			$arr[1] = $xmsg;
		}else{
			$arr[0] = 1;
			$arr[1] = "";	
		}
		$xmsg = "";
		
	return $arr;
	
}//end function CheckName_Birthday(){
	
###############  ��Ǩ�ͺ �������Ѩغѹ
function CheckAddress($xsiteid,$idcard){
	global $xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT COUNT(gen_id) as num1 FROM  hr_addhistoryaddress WHERE gen_id='$idcard'";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[num1] < 1){
			 $arr[0] = 0;
			 $arr[1] = "������кط������Ѩ�غѹ";
	}else{
			$arr[0] = 1;
			$arr[1] = "";	
	}//end if($rs[num1] < 1){
	
	mysql_free_result($result);
	return $arr;
		
}//end function CheckAddress(){
	
#############  ��õ�Ǩ�ͺ���ͧ�Ҫ��  ��ҧ���Թ���

function CheckGetroyal($xsiteid,$idcard,$age){ 
	global $date_profile,$xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	if($age > 5){
			$sql_c = "SELECT  COUNT(id) AS num FROM getroyal WHERE id='$idcard' GROUP BY id ";		
			$result_c = mysql_db_query($dbsite,$sql_c);
			$rsc = mysql_fetch_assoc($result_c);
			if($rsc[num] < 1){
					$arr[0] = 0;
					$arr[1] = "������к�����ͧ�Ҫ��";
			}else{
					$arr[0] = 1;
					$arr[1] = "";	
			}//end if($rsc[num] < 1){
	}else{
			$arr[0] = 1;
			$arr[1] = "";
	}//end if($rs[age] > 5){
		mysql_free_result($result_c);
		return $arr;
}//end function CheckGetroyal(){


###########  end ��õ�Ǩ�ͺ����ͧ�Ҫ��


####  function �ʴ���������»ա����
function GetYYAbsent($xsiteid,$idcard){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT yy  FROM  hr_absent WHERE id='$idcard' ORDER BY yy ASC";
	$result = mysql_db_query($dbsite,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[yy]] = $rs[yy];
	}//end while($rs = mysql_fetch_assoc($result)){
	mysql_free_result($result);
	return $arr;	
}//end function GetYYAbsent(){

#### end function �ʴ���������»ա����

########### ��õ�Ǩ�ͺ�ӹǹ�ѹ����ش�Ҫ���
function CheckAbsent($xsiteid,$idcard){
	global $date_profile,$xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arrabsent_yy);
	unset($arr);
		$sub_yy = substr($date_profile,0,4)-1; // �ջѨ�غѹ
	$sql = "SELECT
FLOOR((TIMESTAMPDIFF(MONTH,t1.begindate,'$date_profile')/12)) as age_gov,
COUNT(t2.id) as num_absent,t1.begindate,
year(t1.begindate) as yy,
month(t1.begindate) as mm
FROM
general as t1
LEFT Join hr_absent as t2 ON t1.id = t2.id
where 
t1.idcard='$idcard'
group by  t1.id";
//echo "sql :: ".$sql;die;
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	//echo $rs[age_gov];
	if($rs[age_gov] > 0 and ($rs[num_absent] < $rs[age_gov])){ // �ó��ѹ��͡�ѹ�����ú
		$arrabsent_yy = GetYYAbsent($xsiteid,$idcard); // array loop �ӹǹ���ѹ��
		if(count($arrabsent_yy) < 1){
			$arr[0] = 0;
			$arr[1] = "��辺�������ѹ��";
		}else{
		
		if($rs[mm] >= 10){ // �ó���͹�ҡ����������ҡѺ��͹���Ҥ� ���ǡ�վ.�. � 1 ��
			$start_yy = $rs[yy]+1; 	
		}else{
			$start_yy = $rs[yy];
		}// end if($rs[mm] >= 10){
			

			#########  loop �������ѹ�ҷ��Ҵ�;
			for($yy=$start_yy; $yy <= $sub_yy;$yy++){
				if($arrabsent_yy[$yy] == ""){
					if($xmsg > "") $xmsg .= ",";
					$xmsg .= "$yy";
				}//end if($arrabsent_yy[$yy] == ""){
					
			}//end for($yy=$start_yy; $yy <= $sub_yy;$yy++){
		###  end loop 
		$arr[0] = 0;
		$arr[1] = "�Ҵ�������ѹ�һ� $xmsg";
			}//end if(count($arrabsent_yy) < 1){
	}else{
		$arr[0] = 1;
		$arr[1] = "";	
	}//end 	if($rs[age_gov] > 0 and ($rs[num_absent] < $rs[age_gov])){
		mysql_free_result($result);
		$xmsg = "";
	return $arr;	
}// end function CheckAbsent(){
	
########### end ��õ�Ǩ�ͺ�ӹǹ�ѹ��ش�Ҫ���


####  function ��Ǩ�ͺ���ͺԴ�
function CheckFatherName($xsiteid,$idcard){
	global $xwraning;
		$dbsite = STR_PREFIX_DB.$xsiteid;
		unset($arr);
		$sql = "SELECT COUNT(gen_id) AS num FROM hr_addhistoryfathername WHERE gen_id='$idcard' GROUP BY gen_id";
		$result = mysql_db_query($dbsite,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num] < 1){
				$arr[0] = 0;
				$arr[1] = "����кت��ͺԴ�";
		}else{
				$arr[0] = 1;
				$arr[1] = "";	
		}// end 	if($rs[num] < 1){
		
	return $arr;
}//end function CheckFatherName(){
	
###  end ####  function ��Ǩ�ͺ���ͺԴ�


##  function ��Ǩ�ͺ������ô�
function CheckMotherNmae($xsiteid,$idcard){
	global $xwraning;
		$dbsite = STR_PREFIX_DB.$xsiteid;
		unset($arr);
		$sql = "SELECT COUNT(gen_id) as num FROM hr_addhistorymothername WHERE gen_id='$idcard' GROUP BY gen_id";
		$result = mysql_db_query($dbsite,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[num] < 1){
			$arr[0] = 0;
			$arr[1] = "����кت����ô�";	
		}else{
			$arr[0] = 1;
			$arr[1] = "";
		}
	return $arr;
}//end function CheckMotherNmae(){


####  ��Ǩ�ͺ�ѹ��觺�è�
function CheckStartDate($get_startdate){
	global $xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	if($get_startdate == "" or $get_startdate == "0000-00-00"){
		$arr[0] = 0;
		$arr[1] = "����к��ѹ��觺�è��Ҫ���";
	}else{
		$arr[0] = 1;
		$arr[1] = "";	
	}
return $arr;
}// end function CheckStartDate($get_startdate){


##### ��Ǩ�ͺ�ѹ�������Ժѵ��Ҫ��õ�ͧ����ѹ��Ѻ����
function CheckBegindate($get_begindate,$get_birthday){
		global $age_startdate,$date_profile,$xwraning;
		
		//echo "date :: ".$date_profile;
		unset($arr);
		unset($arrd1);
		
			if(($get_begindate == "" or $get_begindate == "0000-00-00")){
					$arr[0] = 0;
					$arr[1] = "����к��ѹ�������Ժѵ�Ҫ���";
			}else{
					//$diffyy =  XDate_Diff("$date_profile","$get_begindate","Y"); // �ӹǹ�շ����ҧ�ѹ�����ҧ���ص�ǡѺ�ѹ�������Ժѵ��Ҫ���		
					$arrd1 = dateDiff($get_birthday,$get_begindate);
					$diffyy = $arrd1['year']; // �ӹǹ��
					//echo $get_begindate." $date_profile <pre>";
					//print_r($arrd1);
					if($age_startdate > $diffyy){
					$arr[0] =0;
					$arr[1] = "�ѹ�������Ժѵ��Ҫ����������ѹ��Ѻ���� �����������Ժѵ��Ҫ��ä�� $diffyy";
					}else{
					$arr[0] = 1;
					$arr[1] = "";	
				}
					
			}//end if(($get_begindate == "" or $get_begindate == "0000-00-00")){
				
	return $arr;		
}//end 
####  end �ѹ�������Ժѵ��Ҫ��õ�ͧ����ѹ��Ѻ����

###  ��Ǩ�ͺ�ѹ�������Ժѵ��Ҫ��áѺ�ѹ��觺�èص�ͧ����ҡ��� 1 �� ��е�ͧ����ѹ��Ѻ����

	function CheckBegindateStartdate($get_begindate,$get_startdate){
			global $date_profile,$config_diff_beginstart_date,$xwraning;
			
		//	echo " result  :: $date_profile :: $config_diff_beginstart_date<br>$get_begindate :: $get_startdate";
		unset($arrd1);
		unset($arr);
		unset($arrd3);
				if($config_diff_beginstart_date == "1" ){
					//$DiffD =  XDate_Diff("$get_begindate","$get_startdate","Y"); // 
					$arrd1 = dateDiff($get_begindate,$get_startdate);
					//echo "$get_begindate :: $date_profile<pre>";
					//print_r($arrd1);
					 $DiffD = $arrd1['year'];
					///echo "�ӹǹ :: ".$DiffD."<br>";
					if($DiffD != "0"){
							$arr[0] = 0;
							$arr[1] = "�ѹ�������Ժѵ��Ҫ��áѺ�ѹ��觺�èص�ͧ��ҧ�ѹ����Թ $config_diff_beginstart_date ��";
					}else{
							$arr[0] = 1;
							$arr[1] = "";	
					}// end if($DiffD != "0"){
				}else{
						//$DiffD =  XDate_Diff("$get_begindate","$get_startdate","M"); // 
						$arrd3 = dateDiff($get_begindate,$get_startdate);
						$DiffD = $arrd3['month'];
						if($DiffD > $config_diff_beginstart_date){
								$arr[0] = 0;
								$arr[1] = "�ѹ�������Ժѵ��Ҫ��áѺ�ѹ��觺�èص�ͧ��ҧ�ѹ����Թ $config_diff_beginstart_date ��͹";
						}else{
								$arr[0] = 1;
								$arr[1] = "";	
						}
				}// end if($config_diff_beginstart_date == "1" ){
			
			return $arr;
	}//end 	function CheckBegindateStartdate($get_begindate,$get_startdate){
		
###########  end ###  ��Ǩ�ͺ�ѹ�������Ժѵ��Ҫ��áѺ�ѹ��觺�èص�ͧ����ҡ��� 1 �� ��е�ͧ����ѹ��Ѻ����

####  ��Ǩ�ͺ����������Ҫ���
function CheckTypePerson($label_persontype2now,$persontype2_now){
	global $xwraning;
	unset($arr);
	
	if($label_persontype2now !=""){
		$str_position=$label_persontype2now;
	}else{
		$str_position=$persontype2_now;
	}// end if($label_persontype2now !=""){
	
	if($str_position == ""){
			$arr[0] = 0;
			$arr[1] = "������кػ���������Ҫ���";
	}else{
			$arr[0] = 1;
			$arr[1] = "";	
	}
	return $arr;
}// end function CheckTypePerson($label_persontype2now,$persontype2_now){
	
#####################   ��Ǩ�ͺ����ѵԡ���֡��
function CheckGraduate($xsiteid,$idcard){
	global $xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT COUNT(id) as num FROM graduate WHERE id='$idcard' GROUP BY id ";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[num] < 1){
			$arr[0] = 0;
			$arr[1] = "��辺�����Ż���ѵԡ���֡��";
	}else{
			$arr[0] = 1;
			$arr[1] = "";	
	}//end if($rs[num] < 1){
		mysql_free_result($result);
	return $arr;
}//end function CheckGraduate($idcard){
	
####### 

###### �֧�ӹǹ��÷Ѵ������� salary 
function GetSalary($xsiteid,$idcard){
		$dbsite = STR_PREFIX_DB.$xsiteid;
		unset($arrsalary);
		$sql = "SELECT id,runno,date,year(date) as yy FROM salary WHERE id='$idcard' ORDER BY date ASC ";
		$result = mysql_db_query($dbsite,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arrsalary[$rs['yy']] = $rs["date"];
		}//end while($rs = mysql_fetch_assoc($result)){
			mysql_free_result($result);
		return $arrsalary;
}//end  function GetSalary($idcard){
	
############  ��Ǩ�ͺ����ա�ä�������ŻջѨ�غѹ�����ѧ
function CheckDateSalary($xsiteid,$idcard,$begindate){
	global $date_profile,$xwraning;
	unset($arrsalary);
	unset($yy);
	unset($arr);
	unset($arrd2);
	$db_site = STR_PREFIX_DB.$xsiteid;
	//echo $date_profile."<br>";
	$sub_date = substr($date_profile,0,4);
	$sub_bdate =  substr($begindate,0,4);
	$arrsalary = GetSalary($xsiteid,$idcard);
	
	if(count($arrsalary) < 1){
		$arr[0] = 0;
		$arr[1] = "��辺�������Թ��͹";
	}else{
	
	//$date_df = XDate_Diff($date_profile,$begindate,"Y");
	$arrd2 = dateDiff($begindate,$date_profile);
	$date_df = $arrd2['year'];
	//echo $yy." :: $sub_bdate :: $sub_date";
			
	for($yy = $sub_bdate ; $yy <= $sub_date ; $yy++){
			if($arrsalary[$yy] == ""){
					if($xmsg > "") $xmsg .= ",";
						$xmsg .= "$yy";
			}
	}//end 
	
	//echo "$date_profile<br><pre>";
	//print_r($arrsalary);
	
	$sql_date_p = "SELECT count(id) as num1  FROM salary WHERE id='$idcard' and date='$date_profile'  GROUP BY id";
	$result_date_p = mysql_db_query($db_site,$sql_date_p);
	$rsp = mysql_fetch_assoc($result_date_p);
	mysql_free_result($result_date_p);
	if($rsp[num1] < 1){
			$msg1  = "��辺������ $date_profile ";
	}else{
			$msg1 = "";	
	}//end if(!(in_array("$date_profile",$arrsalary))){

	
	
	if($xmsg != "" or $msg1 != ""){
		$arr[0] = 0;
		$arr[1] = "����բ������Թ��͹ ".$xmsg.$msg1;
	}else{
		$arr[0] = 1;
		$arr[1] = "";	
	}//end if($xmsg != "" or $msg1 != ""){

	}//end if(count($arrsalary) < 1){
	$xmsg = "";
	$msg1 = "";
	return $arr;	
}//end function CheckSalaryKeyUpdate(){
	
	
#####################################################################  end ��Ǩ�ͺ��������� checklist ############################################################# 

######################################  �������Ǩ�ͺ������ ����� ��áФ�������ó�ͧ������ ##############################################################################

function CheckMarry($xsiteid,$idcard){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	
	$sql = "SELECT COUNT(gen_id) AS num1 FROM hr_addhistorymarry WHERE gen_id='$idcard'";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $rs[num1];
}//end function CheckMarry($get_site,$get_id){
	

function DateThai($get_date,$get_type=""){
	global $shortmonth;
	unset($arrd);
	unset($arrd1);
	if($get_type != ""){
		if($get_date != "" and get_date != "0000-00-00 00:00:00"){
		$arrd = explode(" ",$get_date);
		$arrd1 = explode("-",$arrd[0]);
			$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543)." ���� ".$arrd[1] ."�.";
		}else{
			$xdate = "-";	
		}
		
	}else{
		if($get_date != "" and get_date != "0000-00-00"){
			$arrd1 = explode("-",$get_date);
			$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]);
		}else{
			$xdate = "-";
		}
	}//end if($get_type != ""){
	return $xdate;
}//end function get_dateThai(){
	
function ShowDateThai($get_date){
		global $monthname;
		unset($arr);
		unset($arr1);
		$arr = explode(" ",$get_date);
		if($arr > 1){
			$get_date = $arr[0];
		}
		if($get_date != "0000-00-00"){
			$arr1 = explode("-",$get_date);	
			return intval($arr1[2])." ".$monthname[intval($arr1[1])]." ".($arr1[0]+543);
		}else{
			return "";	
		}
}//end function ShowDateThai($get_date){

## ��Ǩ�ͺ�óդӹ�˹�Ҫ����繹���������͡ʶҹ��Ҿ���ʴ
function CheckStatusMarry($get_prename_id,$get_marry_id){
		if($get_prename_id == "005" and $get_marry_id == "2"){ // ��Ǩ�ͺ�óդӹ�˹�Ҫ����繹ҧ���ʶҹ�����ʴ�ʴ�������١��ͧ
			return false;
		}else{
			return true;	
		}
}
## end ��Ǩ�ͺ�óդӹ�˹�Ҫ����繹���������͡ʶҹ��Ҿ���ʴ

###### function �Ң����� � �ѹ��� 
function DateProfile($get_id,$get_siteid,$profile_id=""){
	global $dbname_temp,$salary_date;
	$dates =  	$salary_date."-10-01";
	return $dates;
}//end function DateProfile($get_id,$get_siteid){
	
####  ��Ǩ�ͺ��ä�������� �Թ��͹

function CheckMaxSalary($xsiteid,$idcard,$profile_id){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	unset($rs);
	$dates = DateProfile($idcard,$xsiteid,$profile_id);
	$sql = "SELECT COUNT(id) as NUMSALARY,max(date) as maxdate FROM salary WHERE id='$idcard' AND date >= '$dates' GROUP BY id";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[NUMSALARY] < 1){
			$arr[0] = 0;
			$arr[1] = "�ѹ�֡�Թ��͹�ѧ���ú��й�� �ѹ�֡�֧ $rs[maxdate]";
	}else{
			$arr[0] = 1;
			$arr[1] = "";	
	}//end 	if($rs[NUMSALARY] < 1){
		mysql_free_result($result);
	return $arr;
}//end function CheckMaxSalary($xsiteid,$idcard){


### function ��Ǩ�ͺ �ӹ�˹�Ҫ��͡Ѻ�ȡ���� 1:1
function CheckPrenameSex($prename_id,$gender_id){
	global $dbnamemaster;
	unset($rs_p);
	$sql_prename  = "SELECT * FROM prename_th WHERE PN_CODE='$prename_id'";
	$result_prename = mysql_db_query($dbnamemaster,$sql_prename);
	$rs_p = mysql_fetch_assoc($result_prename);
	mysql_free_result($result_prename);
	if($rs_p[gender] != $gender_id){ // �óդӹ�˹�Ҫ������ç����ѹ��Ѻ��
		return 1;
	}else{
		return 0;	
	}//end if($rs_p[gender] != $gender_id){ 
	
}//end function CheckPrenameSex(){
	
### function ��Ǩ�ͺʶҹС���ʴ��Ţ�ͧ����� �.�. 7 �� 2 ��
function CheckActive2Record($xsiteid,$get_id){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($rs_count);
	$sql_count = "SELECT COUNT(gen_id) AS num1 FROM hr_addhistoryname WHERE kp7_active='1' AND gen_id='$gen_id'";
	$result_count = mysql_db_query($dbsite,$sql_count);
	$rs_count = mysql_fetch_assoc($result_count);
	mysql_free_result($result_count);
	return $rs_count[num1];
}// end function CheckActive2Record($get_id){
	
	
###  �ѧ���蹵�Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹
function CheckKeySalary($xsiteid,$get_id){
		global $dbnamemaster,$yy;
		$dbsite = STR_PREFIX_DB.$xsiteid;
		unset($arr);
		
		$sql_salary = "SELECT * FROM salary WHERE id='$get_id' AND year(date) > $yy ORDER BY date ASC";
		$result_salary = mysql_db_query($dbsite,$sql_salary);
		$IntA=0;
		while($rs_s = mysql_fetch_assoc($result_salary)){
			$arr_xdate = explode("-",$rs_s[date]);
			$year = $arr_xdate[0]-543;
			$month = $arr_xdate[1];
			$day = $arr_xdate[2];
			//echo "$rs_s[radub] $rs_s[salary] $year-$month-$day  <br>";
/*			$obj=new salary_level("$rs_s[radub]",$rs_s[salary],"$year-$month-$day");
			$r=$obj->check();
			  if(!($r==true)){
				  $IntA += 1;
					$salary_msg .= " �Թ��͹���ç����ѧ�ѭ����͹��÷Ѵ��� $rs_s[runno]  �ѹ���  $rs_s[date]  �Թ��͹ ".number_format($rs_s[salary])."<br>";
				}
*/		$sql_check = "SELECT
tbl_salary_level.money
FROM
tbl_salary_level
WHERE
 (money ='$rs_s[salary]' or money0_5='$rs_s[salary]' or money1='$rs_s[salary]' or money1_5='$rs_s[salary]')";
		$result_check = mysql_db_query($dbnamemaster,$sql_check);
		$rs_c = mysql_fetch_assoc($result_check);
		//echo "$rs_s[salary]  :: $rs_s[date] :: ".$rs_c[money]."<br>";
			if($rs_c[money] == ""){
					$IntA += 1;
					$salary_msg .= " �Թ��͹���ç����ѧ�ѭ����͹��÷Ѵ��� $rs_s[runno]  �ѹ���  $rs_s[date]  �Թ��͹ $rs_s[salary]<br>";
			}
		}//end while($rs_s = mysql_fetch_assoc($result_salary)){
			
		if($IntA > 0){
			$arr[0] = 0;
			$arr[1] = $salary_msg;	
		}else{
			$arr[0] = 1;
			$arr[1] = "";	
		}// end if($IntA > 0){
	$salary_msg = "";
	return $arr;
}//end 	function CheckKeySalary(){
## end �ѧ���蹵�Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹

######  ��Ǩ�ͺ�Ţ�����˹���Թ��͹�繤����ҧ
function CheckNoPositionNull($xsiteid,$idcard){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT runno,date FROM salary WHERE id='$idcard' AND (noposition='' OR noposition IS NULL)";	
	$result = mysql_db_query($dbsite,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($xmsg > "") $xmsg .= ",";
			$xmsg .= " ��÷Ѵ��� $rs[runno] �ѹ��� $rs[date]";
	}
	if($xmsg != ""){
			$arr[0] = 0;
			$arr[1] = "�Ţ�����˹�㹢������Թ��͹㹪�ͧ value �繤���ҧ ".$xmsg;
	}else{
		$arr[0] = 1;
		$arr[1] = "";	
	}// end 	if($xmsg != ""){
		mysql_free_result($result);
		$xmsg = "";
	return $arr;
}//end function CheckNoPositionNull($idcard){
	
#######  �Һ�÷Ѵ�á�Թ��͹ ��к�÷Ѵ�ش�����Թ��͹
function GetMaxMinSalary($xsiteid,$idcard){
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arr);
	$sql = "SELECT max(date) as maxdate,min(date) as mindate FROM salary WHERE id='$idcard'  GROUP BY id";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['mindate'] = $rs[mindate];
	$arr['maxdate'] = $rs[maxdate];
	return $arr;
}//end function GetMaxMinSalary($idcard){
	
 
 
 
####################################################################  �ѹ�֡�����ŷ�� wanning ��Ұҹ������ checklist �����Ǵ��¡�� #####################################
//include ("../../../../config/conndb_nonsession.inc.php")  ;

function CleanChecklistWarnning($field_update,$idcard,$profile_id){
	global $dbname_temp;
	
	$sql = "UPDATE tbl_checklist_kp7 SET $field_update='' WHERE idcard='$idcard' AND profile_id='$profile_id'";
	//mysql_db_query($dbname_temp,$sql);
}//end function CleanChecklistWarnning($field_update,$idcard,$profile_id){


function UpdateChecklistWarning($field_update,$idcard,$profile_id,$msg){
	global $dbname_temp;
		$sql1 = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
		$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error());
		$rs1 = mysql_fetch_assoc($result1);

		$data_check = "$rs1[$field_update]";
		$sql2 = "SELECT COUNT(idcard) as num1 FROM  tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'  AND $field_update LIKE '%$msg%' GROUP  BY idcard";
		//echo $sql2."<br>";
		$result2 = mysql_db_query($dbname_temp,$sql2);
		$rs2 = mysql_fetch_assoc($result2);
		$nummsg = intval($rs2[num1]);
		
		if(trim($msg) != ""){
		echo $data_check." :: ".$nummsg."<br>";
		//echo "$rs1[$field_update]   :: $nummsg";
		if($data_check != "" and $nummsg < 1){ // �ó� msg ����������
			$xmsg = $data_check."<br>".$msg;
		}else if($data_check != "" and $nummsg > 0){
			$xmsg = $data_check;
		}else{
			$xmsg = $msg;
		}//end if($rs1["$field_update"] != "" and $nummsg < 1){ 
	}else{
		$xmsg =  $data_check;	
	}// end if(trim($msg) != ""){
	$sql_update = "UPDATE tbl_checklist_kp7 SET $field_update='".$xmsg."'  WHERE idcard='$idcard' AND profile_id='$profile_id'";
	//echo $dbname_temp." :: ".$sql_update."<br>";
	mysql_db_query($dbname_temp,$sql_update) or die(mysql_error());

		
}//end function UpdateChecklistWarning($field_update,$idcard,$profile_id,$msg){
	
//UpdateChecklistWarning("comment_general","3620600097942","1","aaaaa");
############################################################################  ��Ǩ�ͺ ������

function ProcessQCData($xsiteid,$idcard,$profile_id,$update_checklist=""){
	global $db_name,$dbname_temp,$salary_date,$age_startdate,$config_diff_beginstart_date,$xwraning;
	$dbsite = STR_PREFIX_DB.$xsiteid;
	unset($arrmsg);
	
		$sql1 = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);

	//echo "dbsite :: ".$dbsite."<br>";
	$date_profile =  DateProfile($idcard,$xsiteid,$profile_id);// �ѹ���Ѵ�Ӣ�����
	$sql = "SELECT *,ROUND((TIMESTAMPDIFF(MONTH,birthday,'$date_profile')/12)) as age,ROUND((TIMESTAMPDIFF(MONTH,begindate,'$date_profile')/12)) as age_gov,ROUND((TIMESTAMPDIFF(MONTH,startdate,'$date_profile')/12)) as yy_startdate  FROM general WHERE idcard='$idcard'";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);

	##################  �����ŷ����
	### ��Ǩ�ͺ�ӹǹ�ٻ�ҡ checklist �Ѻ cmss
	$arr1 = CheckNum_imageKp7($xsiteid,$idcard,$profile_id,$rs1[pic_num]); 
	if($arr1[0] == "0"){
			$arrmsg['A001'] = $xwraning."".$arr1[1];
	}// end if($arr1[0] == "0"){
	
				
	###  ��Ǩ�ͺ�ѹ��͹���Դ�ӹ�˹�Ҫ��ͪ���
	$arr3 = CheckName_Birthday($rs[birthday],$rs[prename_th],$rs[name_th],$rs[surname_th]);
	if($arr3[0] == "0"){
			$arrmsg['A003'] = $xwraning."".$arr3[1];
	}// end 	if($arr3[0] == "0"){
				
	
	######  ��Ǩ�ͺ�������Ѩغѹ
	$arr4 = CheckAddress($xsiteid,$idcard);
	if($arr4[0] == "0"){
			$arrmsg['A004'] = $xwraning."".$arr4[1];
	}//end if($arr4[0] == "0"){
				

	####  ��Ǩ�ͺ  ������Ѻ����ͧ�Ҫ��
	$arr5 = CheckGetroyal($xsiteid,$idcard,$rs[age]);	
	if($arr5[0] == "0"){
			$arrmsg['F001'] = $xwraning."".$arr5[1];
	}// end if($arr5[0] == "0"){
			
			
			
		if($rs[age_gov] == ""){
				$rs[age_gov] = XDate_Diff($rs[begindate],$rs[birthday],"Y");
		}

	###  ��Ǩ�ͺ�Ҵ�������
	if($rs[age_gov] < 0 or $rs[age_gov] > 60 or $rs[age_gov] == ""){
			$arrmsg['A016'] = "��͡�������ѹ�������Ժѵ��Ҫ������١��ͧ ";
	}else{

		$arr6 = CheckAbsent($xsiteid,$idcard);	
		if($arr6[0] == "0"){
				$arrmsg['I001'] = $xwraning."".$arr6[1];
		} //end if($arr6[0] == "0"){
		
	}//end if($rs[age_gov] <1 or $rs[age_gov] > 60){
	### ��Ǩ�ͺ���ͺԴ�
	$arr7 = CheckFatherName($xsiteid,$idcard);
	if($arr7[0] == "0"){
		$arrmsg['A005'] = $xwraning."".$arr7[1];
	}// end 	if($arr7[0] == "0"){
	
	
	##### ��Ǩ�ͺ������ô�
	$arr8 = CheckMotherNmae($xsiteid,$idcard);
	if($arr8[0] == "0"){
		$arrmsg['A006'] = $xwraning."".$arr8[1];		
	}//end if($arr8[0] == "0"){

	
	#########  �ѹ��觺�è��Ҫ���
	$arr9 = CheckStartDate($rs[startdate]);	
	if($arr9[0] == "0"){
		$arrmsg['A007'] = $xwraning."".$arr9[1];	
	}//end if($arr9[0] == "0"){
	
		
	######## ��Ǩ�ͺ�ѹ�������Ժѵ��Ҫ��õ�ͧ����ѹ��Ѻ����
	$arr10 = CheckBegindate($rs[begindate],$rs[birthday]);
	if($arr10[0] == "0"){
			$arrmsg['A008'] = $xwraning."".$arr10[1];
	}// end if($arr10[0] == "0"){
			

		##############��Ǩ�ͺ�ѹ�������Ժѵ��Ҫ��áѺ�ѹ��觺�èص�ͧ����ҡ��� 1 �� ��е�ͧ����ѹ��Ѻ����
		$arr11 = CheckBegindateStartdate($rs[begindate],$rs[startdate]);
		if($arr11[0] == "0"){
				$arrmsg['A009'] = $xwraning."".$arr11[1];
		}
			
	
		###############  ��Ǩ�ͺ����������Ҫ���
		$arr12 = CheckTypePerson($rs[label_persontype2now],$rs[persontype2_now]);
		if($arr12[0] == "0"){
				$arrmsg['A010'] = $xwraning."".$arr12[1];
		}// if($arr12[0] == "0"){
				
			
		##############  ��Ǩ�ͺ����ѵԡ���֡��
		$arr13 = CheckGraduate($xsiteid,$idcard);
		if($arr13[0] == "0"){
				$arrmsg['B001'] = $xwraning."".$arr13[1];
		}//end 	if($arr13[0] == "0"){ 
			

		#############  ��Ǩ�ͺ�Թ��͹
		if($rs[yy_startdate] == ""){
			$rs[yy_startdate] = 	XDate_Diff($rs[startdate],$rs[birthday],"Y");
		}
		
	
		if($rs[yy_startdate] < 0 or $rs[yy_startdate] > 60 or $rs[yy_startdate] == ""){ // �ʴ���ҡ�á�͡�������ѹ�������Ժѵ��Ҫ������١��ͧ
			$arrmsg['A017'] = "��͡�������ѹ�������è����١��ͧ";		
		}else{
			//echo "<br>�ѹ����� :: $rs[startdate]<br>";
			$arr14 = CheckDateSalary($xsiteid,$idcard,$rs[startdate]);
			if($arr14[0] == "0"){
					$arrmsg['C001'] = $xwraning."".$arr14[1];
			}// end if($arr14[0] == "0"){
		}//end if($rs[yy_startdate] < 1 and $rs[yy_startdate] > 60){
		
		#####################################  end ��Ǩ�ͺ��������ó�ͧ���������� upldate ʶҹТͧ�͡���� checklist ##############
	

		unset($arr12);unset($arr11);unset($arr10);unset($arr9);unset($arr8);unset($arr7);unset($arr4);unset($arr3); unset($arr1);// 
		#### ��ҧ�������ѹ��
		unset($arr6);
		### ��ҧ����������ͧ�Ҫ��
		unset($arr5);
		unset($arr13);
		##### ��ҧ��Ң������Թ��͹
		unset($arr14);

		### ����ͺ������ʷ������ѹ��Ѻʶҹ��Ҿ
		
if(CheckMarry($xsiteid,$idcard) > 0 and (($rs[marry_kp7] == "" or $rs[marry_kp7] == "�ʴ" or $rs[marry_kp7] == "����к�") or ($rs[marital_kp7_status_id] == 0 or $rs[marital_kp7_status_id] == 2 or $rs[marital_kp7_status_id] == 5)) ){
		$arrmsg['A011'] = "�բ����Ť������ !ʶҹС������������繤����ҧ�����ʴ��������к�";
}//end if(CheckMarry()){
		
	##########  ��Ǩ�ͺ�ӹ�˹�Ҫ��͡Ѻʶҹ��Ҿ����
	if(CheckStatusMarry($rs[prename_id],$rs[marital_status_id]) == false){
		$arrmsg['A011']= "�ӹ�˹�Ҫ�����繹ҧ��������͡ʶҹ��Ҿ���ʴ";
	}// end if(CheckStatusMarry($rs[prename_id],$rs[marital_status_id]) == false){
		
	#########  ��Ǩ�ͺ��ä���������Թ��͹�֧�ѹ���Ѩ�غѹ�����ѧ
	if(count(GetSalary($rs[siteid],$idcard)) > 0){
		$arr15 = CheckMaxSalary($rs[siteid],$idcard,$profile_id);
		if($arr15[0] == "0"){
				$arrmsg['C002'] = $arr15[1];
		}//end if($arr15[0] == "0"){
	}//end if(count(GetSalary($rs[siteid],$idcard)) > 0){
	unset($arr15);
	
		############  �ӹ�˹�Ҫ����������ѹ��Ѻ��
	if(CheckPrenameSex($rs[prename_id],$rs[gender_id]) > 0){
		$arrmsg['A012'] = "�����Ťӹ�˹�Ҫ��͡Ѻ���������ѹ��ѹ";
	}// end if(CheckPrenameSex($rs[prename_id],$rs[gender_id]) > 0){
	#########  ʶҹС���ʴ�������� �.�.7 �ͧ����
	if(CheckActive2Record($xsiteid,$idcard) > 1){
		$arrmsg['A013'] = "ʶҹС���ʴ���� �.�. 7 ��ͧ���� - ���ʡ�� ���ҡ���� 1 ��";
	}// endif(CheckActive2Record($idcard) > 1){ 

	#############   �ѧ���蹵�Ǩ�ͺ��úѹ�֡�Թ��͹㹵ç������Թ��͹
	$arr16 = CheckKeySalary($xsiteid,$idcard);
	if($arr16[0] == "0"){
		$arrmsg['C003'] = $arr16[1];
	}// end if($arr16[0] == "0"){
	unset($arr16);
	
	########  ��Ǩ�ͺ�Ţ�����˹���Թ��͹�繤����ҧ
	$arr17 = CheckNoPositionNull($xsiteid,$idcard);
	if($arr17[0] == "0"){
		$arrmsg['C004'] = $arr17[1];	
	}// end if($arr17[0] == "0"){
	unset($arr17);
		
	################    ��Ǩ�ͺ��äú���¹�����Ҫ���
	if($rs[age] > 61 ){ // �ú���³�����Ҫ�������
		$arrmsg['A014'] =  "�ѹ��͹���Դ�Ҩ�����١��ͧ���ͧ�ҡ��й�����غؤ�ҡ� $rs[age] �ú���³�����Ҫ�������";
	}// end if($rs[age] > 61 ){
		
	//if(!CheckIDCard($idcard)){
		//$arrmsg['A0015']	 = "�Ţ�ѵ÷����������к����١��ͧ��������û���ͧ";
	//}
	
	
######################   ��Ǩ�ͺ�����ž�鹰ҹ��������з���ͧ��
	// ��
$flag1 = true;
$xmsg1 = "";
	if($rs[sex]==""){
		$flag1 = false ;
		$xmsg1 .= "<br> - ����к���";
	}
	if(($rs[sex] == "���" and $rs[gender_id] == "2") or ($rs[sex] == "˭ԧ" and $rs[gender_id] == "1")){
		$flag1 = false;
		$xmsg1 .= "<br> - �ȡѺ�������������ѹ��ѹ ������ҧ���١��ͧ��� ��� ���ʵ�ͧ�� 1 ���� ����� ˭ԧ ���ʵ�ͧ�� 2 ��й��������� $rs[sex]  ������ $rs[gender_id]";
	}// end if(($rs[sex] == "���" and $rs[gender_id] == "2") or ($rs[sex] == "˭ԧ" and $rs[gender_id] == "1")){
	
	
	// ���˹������
/*	if($rs[position]==""){
		$flag1 = false ;
		$xmsg1 .= "<br> - ����кص��˹�������Ѻ�Ҫ���";
	}
	// �дѺ������Ѻ�Ҫ���
	if($rs[radub_past]==""){
		$flag1 = false ;
		$xmsg1 .= "<br> - ����к��дѺ������Ѻ�Ҫ���";
	}
*/	// ���˹觻Ѩ��Ѻѹ
	if($rs[position_now]==""){
		$flag1 = false ;
		$xmsg1 .= "<br> - ����кص��˹觻Ѩ�غѹ";
	}
	// �дѺ�Ѩ��Ѻѹ
	if($rs[radub]==""){
		$flag1 = false ;
		$xmsg1 .= "<br> - ����к��дѺ�Ѩ�غѹ";
	}
	if($rs[status_gpf] < 1){ // ������кء������Ҫԡ ���.
		$flag1 = false;
		$xmsg1 .= "<br> - ������кء������Ҫԡ ���.";
	}// end 	if($rs[status_gpf] < 1){ 

	if(!$flag1){
			$arrmsg['A016'] = $xmsg1;
	}
######################  end ��Ǩ�ͺ�����ž�鹰ҹ��������з���ͧ��

#############  ��Ǩ�ͺ����ٻ�� server 
	$arrch_pic = CheckImageSys($rs[siteid],$idcard);
	if($arrch_pic[0] == "0"){
			$arrmsg['A017'] = $arrch_pic[1];
	}// end if($arrch_pic[0] == "0"){
	unset($arrch_pic);
	
	$arrkp7 = CheckKp7file($xsiteid,$idcard);
	if($arrkp7[0] == "0"){
		$arrmsg['A018'] = $arrkp7[1];
	}//end if($arrkp7[0] == "0"){
	 unset($arrkp7);

	unset($rs);
	mysql_free_result($result);
	mysql_free_result($result1);

	########################  end �ӡ�õ�Ǩ�ͺ #####################################
	return $arrmsg;
	
}//end function ProcessQCData(){

	

	
#################################################################################################################

function GetKeyGroup($staffid){
	global $dbnameuse;
		$sql = "SELECT
t1.prename,
t1.staffname,
t1.staffsurname,
t1.image,
t1.sapphireoffice,
t2.groupname
FROM
keystaff as t1
Inner Join keystaff_group as t2  ON t1.keyin_group = t2.groupkey_id
WHERE
t1.staffid =  '$staffid'";
$result = mysql_db_query($dbnameuse,$sql);
$rs = mysql_fetch_assoc($result);
$arr['fullname'] = "$rs[prename]$rs[staffname]  $rs[staffsurname]";
$arr['image'] = $rs[image];
$arr['groupname'] =  $rs[groupname];
$arr['sapphireoffice'] = $rs[sapphireoffice];
return $arr;
}//end function GetKeyGroup($staffid){
	
#######  function update approve key
function ApproveKeyDataKp7($idcard,$staffid,$approve_status="2"){
	global $dbnameuse;
	$sql_sel = "SELECT t1.ticketid, t1.idcard, t1.siteid, t2.staffid FROM tbl_assign_key as t1 Inner Join tbl_assign_sub as t2  ON t1.ticketid = t2.ticketid where t1.idcard='$idcard' and t2.staffid='$staffid'";
	$result_sel = mysql_db_query($dbnameuse,$sql_sel) or die(mysql_error()."$sql_sel<br>LINE::".__LINE__);
	$rss = mysql_fetch_assoc($result_sel);
	if($rss[ticketid] != ""){
		$conv = " AND ticketid='$rss[ticketid]' AND siteid='$rss[siteid]'";	
	}// end if($rss[ticketid] != ""){
		
	$sql = "UPDATE tbl_assign_key SET approve='$approve_status'  WHERE idcard='$idcard' $conv ";
	mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		
}//end function ApproveKeyDataKp7($idcard,$staffid,$approve_status="2"){








	



?>