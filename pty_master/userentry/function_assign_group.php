<?php ######################  start Header ########################
/**
* @comment ���١���ҧ���������Ѻ�к��ѹ�֡�����Ţ���Ҫ��ä����кؤ�ҡ÷ҧ����֡�� �ӹѡ����֡�� ��ا෾��ҹ��
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core(or plugin)
* @author Pannawit
* @access public/private
* @created 01/10/2014
*/
//include("function_assign.php");

$date_last = 31;
$date_last1 = 1;
$point_per_ch = 70; // �ӹǹ��ṹ��ͪش
$percen_add = 0.05; // ��������ǹ����
$day_per_week = 6;// �ӹǹ�ѹ� 1 �ѻ����
$avg_age = 26;// �����Ҫ��������
$age_begin = 22; // ���ء�ҧ㹡���Ѻ�Ҫ���
$constan_update_age = 200;// �óդ�ҷ��� update �ҡ����  200 � update
$point_avg_person = 18.42; // �ӹǹ�������¤�ṹ��� 1 �����Ҫ���
$con_point = 16;// ��ṹ�ǡ�ٵá���Ҥ�Ṩҡ�����Ҫ���
$con_point_multiply = 2.42; // ��ṹ�ٳ����Ҥ�ṹ�ҡ�����Ҫ��� 


$host_face = $host_face;# ��ҧ�ҡ��� config"192.168.2.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";

##############  function 㹡���ҷ������ͧ�硤���ҹ��Ҥ���ҹ���� office �˹
function GetSiteKey($idcard){
		global $dbface,$host_face,$user_face,$pass_face;
		ConHost($host_face,$user_face,$pass_face); // connect faceaccess
		$sql = "SELECT t1.officer_id, t1.pin, t2.site_name FROM faceacc_officer as t1 Inner Join faceacc_site as t2  ON t1.site_id = t2.site_id where  t1.pin='$idcard'";
		$result = mysql_db_query($dbface,$sql) ;
		$rs = mysql_fetch_assoc($result);
		return $rs[site_name];
}//end function GetSiteKey(){
	
	
function GetSiteName($idcard){
		return GetSiteKey($idcard);
}//end function GetSiteName($idcard){

###  connect ����ͧ database server
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
####  function 㹡���Ҩӹǹ�ѹ��͹��ѧ
function GetDateLast($last_num){ 
				$lastd = "-$last_num";
				$datereq1 = date("Y-m-d");	 
				 $xbasedate1 = strtotime("$datereq1");
				 $xdate1 = strtotime("$lastd day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// �ѹ�Ѵ�

return $xsdate1;
}//end function GetDateLast(){
	

################# �Ҥ�ṹ����·����������ѹ��͹��ѧ� 30 �ѹ
function GetPointAvgPerDay($staffid,$xtype=""){
	global $dbnameuse,$date_last,$date_last1,$day_per_week;
	
	$arr_sf = GetBasePointAndPercenAdd($staffid); // ��������ǹ������Ф�ṹ�ҵðҹ�ͧ���Ф�
	$base_point = $arr_sf['base_point']; // ��ṹ�ҵðҹ
	$date_start = GetDateLast($date_last); // �ѹ����������
	$date_end = GetDateLast($date_last1);//  �ѹ�������ش
	$sql = "SELECT
CEIL(avg(stat_user_keyin.numkpoint)) as avgpoint
FROM `stat_user_keyin`
where staffid='$staffid'  and datekeyin BETWEEN '$date_start' AND '$date_end'";
$result = mysql_db_query($dbnameuse,$sql);
$rs = mysql_fetch_assoc($result);

		if($rs[avgpoint] < $base_point){ // �óդ�Ҥ�ṹ����¹��¡��Ҥ�ṹ�ҵðҹ
			$xpoint  = $base_point;
		}else{
			$xpoint = $rs[avgpoint];
		}//end if($rs[avgpoint] < $base_point){

if($xtype == "w"){
		$pointkey = ceil($xpoint*$day_per_week); // ��Ҥ�ṹ����ѻ����
}else{

		$pointkey = ceil($xpoint); // ��Ҥ�ṹ����ѹ
}// end if($xtype == "w"){
	

return $pointkey;
######
}//end function function GetPointAvgPerDay($staffid){
	
	
############# function �Ҥ�ṹ��ä�������Ũҡ�����Ҫ���
function GetPointFormAgeGov($age){
	global $con_point,$con_point_multiply;
		return  ceil($con_point+($age*$con_point_multiply));
}//end function GetPointFormAgeGov(){ 

### function �������Ҫ��èҡ��ṹ
function GetAgeGovFromPoint($point){
	 global $con_point,$con_point_multiply;
	 return round(($point-$con_point)/$con_point_multiply); 
}
#######################  function �ӹǳ�������Ҫ��èҡ �ѹ��͹���Դ ####################################
function GetAgeGoverment($birthday){
	global $avg_age,$age_begin;
	$birth_yy = substr($birthday,0,4); // �շ��Դ
	$curent_yy = date("Y")+543; // �ջѨ�غѹ����Դ
	$age = $curent_yy-$birth_yy; // ���ص�Ǩҡ���Դ
	if(($age > 60) or ($age <= 21)){ // �ó����ع��¡���������ҡѺ 21 �� ���� �ҡ���� 60 �� ����������Ҫ��÷���繤�ҡ�ҧ��� 26 ��
			$age_gov = $avg_age;
	}else if($age == $age_begin){ // �ó����ص����ҡѺ�����ҵðҹ�������Ѻ�Ҫ��þʹ���������Ҫ�����ҡѺ 1
			$age_gov = 1;
	}else{
			$age_gov = $age-$age_begin; // ���ص��-22 ��������Ҫ���
	}//end if(($age > 60) or ($age <= 21)){ 

	return $age_gov;
}// end function GetAgeGoverment($birthday){
	
##############  function �Ѻ�ӹǹ������������������к� #####################  
function GetNumStaffKey(){
	global $dbnameuse;
	$sql = "SELECT COUNT(staffid) as num1 FROM `keystaff` WHERE status_permit = 'YES' AND keyin_group > '0' AND status_extra= 'NOR'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];		
}//end function GetNumStaffKey(){
	
	
	
	
###########  function ��Ǩ�ͺ��������ó�ͧ�͡��á�͹ assign 

function CheckNumPagePdf($idcard,$profile_id){
	global $dbname_temp;
	
	$sql = "SELECT page_num, page_upload,siteid FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[page_num] != $rs[page_upload]){
		return 0;
	}else{
		return 1;	
	}
}// end function CheckNumPagePdf($idcard,$profile_id){

function CheckStatusDoc($idcard,$siteid,$profile_id){
		global $dbname_temp,$pathkp7file,$dbnameuse,$db_temp;
		if(CheckFileKp7($idcard,$siteid) == "1"){
				if(CheckNumPagePdf($idcard,$profile_id) == "1"){
						if(CheckPicChecklistToCmss($profile_id,$idcard,$siteid) == "1"){
							$status_doc = 1;			
						}else{
							$status_doc = 0;		
						}// end if(CheckPicChecklistToCmss($profile_id,$idcard,$siteid) == "1"){
				}else{
					$status_doc = 0;			
				}//end if(CheckNumPagePdf($idcard,$profile_id) == "1"){
		}else{
			$status_doc = 0;	
		}
	return $status_doc;
}// end function CheckStatusDoc($idcard,$siteid){
	
	
	
############  function 㹡���� temp �����š���ͺ���§ҹ�����§�ӴѺ��������Ӥѭ�ͧࢵ������ҡ�͹

### function ��Ǩ�ͺ������ temp ��͹�ӡ�úѹ�֡
function CheckTempAssign($profile_id,$siteid=""){
		global $dbnameuse;
		if($siteid != ""){
				$consite = " AND t1.siteid='$siteid' ";
		}// end 	if($siteid != ""){
				$sql = "SELECT
		t1.siteid,
		t1.num_person_all,
		t1.num_person_keypass,
		t1.num_person_assign
		FROM tbl_constan_assign AS 	t1
		WHERE t1.profile_id='$profile_id' $consite";
		$result =mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]]['numall'] = $rs[num_person_all];
				$arr[$rs[siteid]]['numassign'] = $rs[num_person_keypass];
				$arr[$rs[siteid]]['numassigndiff'] = $rs[num_person_assign];
		}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function CheckTempAssign($profile_id,$siteid=""){
	
#############  function �� temp �����š�� assign ��¤�
function SaveTempAssignDetail($profile_id,$siteid){
	global $dbnameuse;
	$sql = "SELECT
t1.siteid,
t1.profile_id,
t1.birthday,
t1.idcard,
if(t3.idcard IS NOT NULL,1,0) as flag_assign,
t2.timeupdate
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join  ".DB_CHECKLIST.".tbl_check_data as t2 ON t1.idcard =t2.idcard AND t1.profile_id =t2.profile_id
Left Join ".DB_USERENTRY.".tbl_assign_key as t3  ON t2.idcard = t3.idcard AND t3.profile_id = '$profile_id'
WHERE
t1.profile_id =  '$profile_id'
and t1.siteid='$siteid'";	
//echo $sql;die;
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$age_gov = GetAgeGoverment($rs[birthday]); // �����Ҫ��÷��ӹǳ�ҡ�ѹ��͹���Դ
		$status_doc = CheckStatusDoc($rs[idcard],$rs[siteid],$rs[profile_id]); // ��Ǩ�ͺʶҹТͧ�͡���
		$yy1 = date("Y")+543;
		$sql_insert = "REPLACE INTO tbl_constan_assign_detail SET idcard='$rs[idcard]',siteid='$rs[siteid]',profile_id='$rs[profile_id]',birthday='$rs[birthday]',temp_age_gov='$age_gov',status_doc='$status_doc',flag_assign='$rs[flag_assign]',yy_age='$yy1'";
		//echo $sql_insert."<br>";
		mysql_db_query($dbnameuse,$sql_insert);
	}//end while($rs = mysql_fetch_assoc($result)){

}// end function SaveTempAssignDetail($profile_id,$siteid){


### �� temp ���� assign �ҹ
function SaveTempAssign($profile_id,$siteid=""){
	global $dbnameuse;
	if($siteid != ""){
		$consite = " AND t1.siteid='$siteid' ";	
		$arrch = CheckTempAssign($profile_id,$siteid);
	}else{
		$arrch = CheckTempAssign($profile_id,"");	
	}//end 	if($siteid != ""){
	
	//echo "$siteid :: $profile_id <br>
	//$consite
	//<pre>
	//";
	//print_r($arrch);die;
	
	$sql = "SELECT
t1.siteid,
t1.profile_id,
sum(if(t1.idcard=t2.idcard,1,0)) as numimp,
sum(if(t3.idcard IS NOT NULL,1,0)) as numassign,
sum(if(t3.idcard IS NULL,1,0)) as numassigndiff,
t2.timeupdate
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join  ".DB_CHECKLIST.".tbl_check_data as t2 ON t1.idcard =t2.idcard AND t1.profile_id =t2.profile_id
Left Join ".DB_USERENTRY.".tbl_assign_key as t3  ON t2.idcard = t3.idcard AND t3.profile_id = '$profile_id'
WHERE
t1.profile_id =  '$profile_id' $consite
group by t1.siteid
";
//echo "$dbnameuse  :: $sql";die;
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$numall_old = $arrch[$rs[siteid]]['numall'] ; // �ӹǹ�ؤ�ҡ÷�����ҷ������ temp
		###  ����������´ temp
		SaveTempAssignDetail($profile_id,$rs[siteid]);
		####  end ###  ����������´ temp
		if(($rs[numimp] > $numall_old) and $numall_old > 0 ){
			$sql_save = "UPDATE tbl_constan_assign SET num_person_all='$rs[numimp]',num_person_keypass='$rs[numassign]',num_person_assign='$rs[numassigndiff]' WHERE siteid='$rs[siteid]' AND profile_id='$profile_id'";
		}else{
			$sql_save = "INSERT INTO tbl_constan_assign SET num_person_all='$rs[numimp]',num_person_keypass='$rs[numassign]',num_person_assign='$rs[numassigndiff]',siteid='$rs[siteid]', profile_id='$rs[profile_id]',date_import='$rs[timeupdate]'"	;
		}// end 	if(($rs[numimp] > $numall_old) and $numall_old > 0 ){
		
		//echo "$sql_save<br>";
		mysql_db_query($dbnameuse,$sql_save);
	}//end  	while($rs = mysql_fetch_assoc($result)){
		
}//end function SaveTempAssign(){
	
##### function update ʶҹ�������ա�� assign ����
function UpdateStatusAssign($idcard,$profile_id){
		global $dbnameuse;
		$sql = "UPDATE tbl_constan_assign_detail SET flag_assign='1' WHERE idcard='$idcard' AND profile_id='$profile_id' ";
		mysql_db_query($dbnameuse,$sql);
}
	
##### function update ʶҹС�èͧ�Ţ�ѵù��������� �ͺ���§ҹ
function UpdateMarkAssign($idcard,$profile_id,$flag_mark){ // flag_mark = 1 ��ͨͧ id������� 0 ����ѧ�����ͧ
		global $dbnameuse;
		$sql = "UPDATE tbl_constan_assign_detail SET flag_mark='$flag_mark' WHERE idcard='$idcard' AND profile_id='$profile_id'";
		//echo $sql."<br>";
		mysql_db_query($dbnameuse,$sql);
}//end 
	
#############  function �Ҩӹǹ�ش�����Ţͧ���С���������ǧ�����Ҫ���
function CheckSubGroupAge($siteid,$profile_id){
	global $dbnameuse;
	$sql = "SELECT group_id,numperson,avg_age FROM tbl_constan_assign_group_detail WHERE siteid='$siteid' AND profile_id='$profile_id' ORDER BY group_id DESC";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrg[$rs[group_id]]['numall'] = intval($rs[numperson]);	
		$arrg[$rs[group_id]]['numavg'] = $rs[avg_age];
	}
	return $arrg;
}//end function CheckSubGroupAge(){
	
#####  function �ʴ�
###### function ��Ǩ�ͺ��û����ż��� log ��ùѺ�ӹǹ�ش�ͧ���С���������Ҫ���
function CheckFlagProcessGroupAge($siteid,$profile_id){
	global $dbnameuse;
	$sql = "SELECT  flag_assign_start  FROM tbl_constan_assign WHERE  siteid='$siteid' AND profile_id='$profile_id' ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[flag_assign_start];
		
}//end function CheckFlagProcessGroupAge(){
	
#######  function update ��ѧ�����żŨѴ�纡���������Ҫ���
function UpdateFlagProcessGroupAge($siteid,$profile_id,$field_name){
	global $dbnameuse;
	// flag_assign_start  ��� ʶҹС������������ż�
	// flag_assign_end ��� ʶҹл����ż���������
	$sql = "UPDATE tbl_constan_assign SET $field_name='1' WHERE  siteid='$siteid' AND profile_id='$profile_id' ";
	//echo $dbnameuse." :: ".$sql."<br>";
	mysql_db_query($dbnameuse,$sql);
}//end function UpdateFlagProcessGroupAge(){


function ProcessGroupAge($siteid,$profile_id){
	global $dbnameuse;
	
	//echo "$siteid  :: $profile_id<br>";
	$checkprocess = CheckFlagProcessGroupAge($siteid,$profile_id); // 0 ��� �ѧ���������żŷӡ�û����ż��� 1 ��ͷӡ�û����ż�������������ö�����ż��騹���Ҩд��Թ�������
	$arrp =  CheckSubGroupAge($siteid,$profile_id);
	$arrp1 = GetAvgAgeGroup($siteid,$profile_id);
	

		$sql = "SELECT * FROM tbl_constan_assign_group  ORDER BY group_id DESC ";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				if($rs[condition_sql] != ""){
						$cons = " AND $rs[condition_sql]";
				}else{
						$cons = "";	
				}//end if($rs[condition_sql] != ""){
					if($checkprocess == "0" or $arrp[$rs[group_id]]['numall'] == 0){ // �����żŢ�������
						$sqlnumgroup = "SELECT COUNT(idcard) AS num1 FROM tbl_constan_assign_detail  WHERE siteid='$siteid' AND profile_id='$profile_id' AND flag_assign='0'  $cons";
						$result_group = mysql_db_query($dbnameuse,$sqlnumgroup);
						$rsg = mysql_fetch_assoc($result_group);
						
						$sql_rep = "REPLACE INTO tbl_constan_assign_group_detail SET siteid='$siteid',profile_id='$profile_id',group_id='$rs[group_id]' ,numperson='$rsg[num1]',avg_age='".$arrp1[$rs[group_id]]."'";
						//echo $sql_rep."<br>";
						mysql_db_query($dbnameuse,$sql_rep);
						 UpdateFlagProcessGroupAge($siteid,$profile_id,"flag_assign_start");
					}// end if($checkprocess == "0" or $arrp[$rs[group_id]] == 0){ // �����żŢ�������
		}// end while($rs = mysql_fetch_assoc($result)){
	
}//end function if($checkprocess == "0"){
	
#####################  end �� ����š���觡���������ŵ�������Ҫ���

#### function �ʴ���ҡ���觨ӹǹ�ش㹡Ѻ��ѡ�ҹ��������Ţͧ���С���������Ҫ���
function GetShareNumGroup($siteid,$profile_id){
	global $dbnameuse;
	$arrp = CheckSubGroupAge($siteid,$profile_id); // �ӹǹ����������С���������Ҫ���
	$numstaff = GetNumStaffKey(); // �Ѻ�ӹǹ��ѡ�ҹ��������ŷ���������ѧ����ҹ���������� pattime
	if($numstaff > 0){ // �ó��ըӹǹ��ѡ�ҹ������
		if(count($arrp) > 0){
			foreach($arrp as $key => $val){
					$arrg[$key] = ceil($val['numall']/$numstaff); // �ӹǹ��������Ѻ��ѡ�ҹ���Ф�����С���������Ҫ��� ����ɻѴ���
			}//end 	foreach($arrp as $key => $val){
		}//end 	if(count($arrp) > 0){
	}//end if($numstaff > 0){
	return $arrg;
}//end function GetShareNumGroup(){
	
	
	###  function �ʴ���Ҥ�ṹ����������ͧ������
	function GetPointStaffAll($siteid,$profile_id){
		global $dbnameuse;
		$arrp1 = GetShareNumGroup($siteid,$profile_id); // �ӹǹ�ش������Ѻ����觷���������С����������
		$arrp =  CheckSubGroupAge($siteid,$profile_id); // �����Ҫ�����������С���������駨ӹǹ����ؤ�ҡ÷���ͧ�ͺ���§ҹ���С����
		if(count($arrp1) > 0){
			foreach($arrp1 as $key => $val){
				$age_avggroup = $arrp[$key]['numavg'];// �����Ҫ�������¢ͧ���С����
				$point_group_all += GetPointFormAgeGov($age_avggroup)*$val;// �����Ҫ�������¤ٳ���¨ӹǹ�ش������Ѻ��������	
			//echo GetPointFormAgeGov($age_avggroup)." :: ".$val."==".GetPointFormAgeGov($age_avggroup)*$val."  :: avg = $age_avggroup <br>";
			}//end foreach($arrp1 as $key => $val){
		}// end if(count($arrp1) > 0){
		return $point_group_all;
	}//end function GetPointStaffAll($siteid,$profile_id){
				
				

	
######  function �Ҥ������������Ҫ��âͧ���С���������Ҫ���
function GetAvgAgeGroup($siteid,$profile_id){
	global $dbnameuse;
	$sql = "SELECT * FROM tbl_constan_assign_group  ORDER BY group_id DESC";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[condition_sql] != ""){
				$conv = " AND $rs[condition_sql]";
		}else{
				$conv = "";	
		}//end if($rs[condition_sql] != ""){
			
		$sql1 = "SELECT floor(avg(temp_age_gov)) as avg_group FROM tbl_constan_assign_detail WHERE siteid='$siteid' AND profile_id='$profile_id' AND status_doc='1' AND flag_assign='0' $conv ";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		$arr[$rs[group_id]] = $rs1[avg_group];
	}//end while($rs = mysql_fetch_assoc($result)){
		//echo "<pre>";
		//print_r($arr);
	return $arr;
}//end function GetAvgAgeGroup(){
	
#######  function return condition ����ҡ���������Ҫ���
function GetSqlConditionAgeGroup(){
		global $dbnameuse;
		$sql = "SELECT * FROM tbl_constan_assign_group  ORDER BY group_id DESC";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arrcon[$rs[group_id]]	 = $rs[condition_sql];
		}// end while($rs = mysql_fetch_assoc($result)){
		return $arrcon;
}//end function GetSqlConditionAgeGroup(){
	

##########  function ������Ҫش�͡������Ѻ��ѧ�ҹ���������������ѹ
function RandomDocumentAssign($staffid,$siteid,$profile_id){
	global $dbnameuse,$day_per_week,$point_avg_person;
	
		$arrpp1 = GetBasePointAndPercenAdd($staffid); // ���������ǹ�������Ǥ�ṹ�ҵðҹ
		$add_percen_assign = $arrpp1['percen_add']; // �����繷���ͧ�ǡ����
		$arr_over = GetDocNokeyAsPoint($staffid,$profile_id); //�ʹ��ä�������ŷ���ҧ����
		$point_over = intval($arr_over['point']); // ��ṹ����ҧ����
		
	 
	####.GetAgeGovFromPoint($xpoint); �ŧ��ṹ�������Ҫ���
		$temp_point = 0; // temp ��ṹ����ѹ
		$temp_pointweek = 0; // temp ��ṹ����ѻ����
		$point_avg = GetPointAvgPerDay($staffid); // ��ṹ����¡�ä�����ͧ��ѡ�ҹ���������������ѹ��͹��ѧ 30 �ѹ
		$temp_percen_add = abs((((($point_avg*$day_per_week)-$point_over)*$add_percen_assign)/100)); // ���������ǹ����
		$point_week = ((($point_avg*$day_per_week)-$point_over))+$temp_percen_add;
		//echo "�ӹǹ��ṹ : ".$point_week;die;
		// ��Ҥ�ṹ�»���ҳ��������� 1 �ѻ���� ź���¨ӹǹ�ش����ѧ����������͹�͡���繤�� ���Ǻǡ�����������ա X �����繵��������ͧ������
		#### �ǡ�����������ա
		
		
		$arrp =  CheckSubGroupAge($siteid,$profile_id); // �����Ҫ�����������С���������駨ӹǹ����ؤ�ҡ÷���ͧ�ͺ���§ҹ���С����
		$arr_sub_group =  GetShareNumGroup($siteid,$profile_id);
		##### ��ṹ����������ͧ��ѡ�ҹ����鹷��Ф������¤ӹǹ�ҡ��������¤ٳ���¨ӹǹ�ش������������С����
		$point_staffall = GetPointStaffAll($siteid,$profile_id);
		
		$point_sub_doc = ceil($point_staffall/$point_avg);// �ӹǹ�ѹ���Ҵ��Ҩӷӡ�ä������������
	//	echo "daykey :: $point_sub_doc<br>";
		
		#### �ʴ����͹䢢ͧ����Ҫش���С���������Ҫ���
		$arrcon = GetSqlConditionAgeGroup();
		$k=0;
		for($j = 0; $j < 6 ;$j++){ //  �ѻ����
			
		if(count($arr_sub_group) > 0){
			
			foreach($arr_sub_group as $key => $val){
				if($arrcon[$key] != ""){
					$conv = " AND $arrcon[$key]";	
				}else{
					$conv = " ";	
				}//end if($arrcon[$key] != ""){
					
				####  �����Ҫ������������С����
				
				$document_assignday = ceil($val/$point_sub_doc);// �ӹǹ�ش����ͧ�֧�͡������ѹ
			//	echo "doc :: ".$document_assignday."<br>";
				
				$sql = "SELECT * FROM tbl_constan_assign_detail WHERE siteid='$siteid' AND profile_id='$profile_id' AND status_doc='1' AND flag_assign='0' AND flag_mark='0'  $conv  ORDER BY temp_age_gov ASC  LIMIT $document_assignday ";
				$result = mysql_db_query($dbnameuse,$sql);
				$i=0; // �ӹǹ�ͺ��ô֧�ӹǹ�ش�͡��
				while($rs = mysql_fetch_assoc($result)){
					$i++;
					$xpoint = GetPointFormAgeGov($rs[temp_age_gov]); // 
					$temp_point =  $temp_point+$xpoint;// ����Ҥ�ṹ��ä���ҡ�����Ҫ���			
					//echo " $j || $rs[idcard] :: $i == $document_assignday || $xtemp_point > $point_avg  ||  $temp_point > $point_avg<br>";
					
					if($temp_point <= $point_avg){
						$arr_assign[$k] = $rs[idcard];
						UpdateMarkAssign($rs[idcard],$profile_id,"1");### update ʶҹС�èͧ�͡�������͹
						$temp_point1 += $xpoint; // �ش����ҹ���͹䢡���ͺ���§ҹ����ѹ������Թ��Ҥ�ṹ�����
						$k++;
					}// end if($temp_point <= $point_avg){

					
				}//end while($rs = mysql_fetch_assoc($result)){		
				
			}// end foreach($arr_sub_group as $key => $val){
			//$xp = 0;
			$temp_point = 0;
			
		}// end if(count($arr_sub_group) > 0){
			
			$temp_pointweek += $temp_point1;
			$temp_point1 = 0;
	}//end for($j = 0; $j < 6 ;$j++){
	########  �óդ�ṹ�������ѻ���� �ѧ����Թ ��ṹ�������÷���
	$diffpoint = $point_week-	$temp_pointweek; // ��ǹ��ҧ�ͧ��ṹ
	//echo "$diffpoint > $point_avg_person<br>";
		if($diffpoint > $point_avg_person){
			$arrs1 = GetDocumentAdd($siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person,$point_week,$k);
			if(count($arrs1) > 0){
				foreach($arrs1 as $key => $val){
					$arr_assign1[$key] = $val['idcard'];
					$temp_pointweek += $val['point'];	
				}//end foreach($arrs1 as $key => $val){	
			}//end if(count($arrs1) > 0){
		}
		if(count($arr_assign1) > 0 and count($arr_assign) > 0){
			$result_array = array_merge($arr_assign, $arr_assign1);
		}else{
			$result_array = $arr_assign;
		}//end if(count($arr_assign1) > 0 and count($arr_assign) > 0){
		
		#### ��Ǩ�ͺ�����ش������ѧ�����Ť�ṹ�����
		$diff_point1 = $point_week-$temp_pointweek; //  ��Ǩ�ͺ�ӹǹ�����ش����
		if($diff_point1 > $point_avg_person){
			$temp_pointweek2 = $temp_pointweek;
			$sql_diff1 = "SELECT * FROM tbl_constan_assign_detail WHERE siteid='$siteid' AND profile_id='$profile_id' AND status_doc='1' AND flag_assign='0' AND flag_mark='0'  AND temp_age_gov < '".GetAgeGovFromPoint($diff_point1)."'  ORDER BY temp_age_gov DESC LIMIT 1  ";
					$result_diff1 = mysql_db_query($dbnameuse,$sql_diff1);
					$rsd1 = mysql_fetch_assoc($result_diff1);
					$xpoint3 =  GetPointFormAgeGov($rsd1[temp_age_gov]);
					$arr_assign2[] = $rsd1[idcard];
					$temp_pointweek += $xpoint3;
					UpdateMarkAssign($rsd1[idcard],$profile_id,"1");
	
		}//end   if($diff_point1 > $point_avg_person){
		
		if(count($result_array) > 0 and count($arr_assign2) > 0 ){
			$result_array = array_merge($result_array,$arr_assign2);
		}else{
			$result_array = $result_array;	
		}
		//echo "point++ :: ".$temp_pointweek."<br>";
		//echo "pointweek :: $point_week<br>";
		////echo "pointall :: $point_staffall<br>";
		//echo "point : $point_avg<br><pre>";
		//print_r($result_array1);
	return $result_array;
}//end function function RandomDocumentAssign($staffid,$siteid,$profile_id){
	
	
function GetDocumentAdd($siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person,$point_week,$k){
	//echo "$siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person,$point_week";die;
	global $dbnameuse;
	$temp_pointweek1 = $temp_pointweek;
		$arrcon = GetSqlConditionAgeGroup();
		foreach($arrcon as $key => $val){  // AND temp_age_gov < '".GetAgeGovFromPoint($diffpoint)."'
		$conv = "AND ".$val;
		$sql_diff = "SELECT * FROM tbl_constan_assign_detail WHERE siteid='$siteid' AND profile_id='$profile_id' AND status_doc='1' AND flag_assign='0' AND flag_mark='0'  $conv  ORDER BY temp_age_gov DESC limit 1  ";
				//echo $sql_diff."<br>";
				$result_diff = mysql_db_query($dbnameuse,$sql_diff);
				while($rsd = mysql_fetch_assoc($result_diff)){
				//echo $rsd[idcard]." :: $diffpoint ::: $rsd[temp_age_gov]<br>";
				$xpoint2 =  GetPointFormAgeGov($rsd[temp_age_gov]);
				
				$temp_pointweek1 += $xpoint2;
				$diffpoint = $point_week-	$temp_pointweek1;
				//echo "cond :: $diffpoint <= $point_avg_person ||  $point_week-	$temp_pointweek1;<br>";
				if($diffpoint >= $point_avg_person){ 
					$temp_pointweek += $xpoint2;
					$arr_assign1[$k]['idcard']  = $rsd[idcard];
					$arr_assign1[$k]['point'] = $xpoint2;
					UpdateMarkAssign($rsd[idcard],$profile_id,"1");
					
					$k++;
					//GetDocumentAdd($siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person,$point_week,$k);
				}
				
				
				if($diffpoint <= $point_avg_person){
						break;
				}
				}//end while($rsd = mysql_fetch_assoc($result_diff)){
			}//end 	foreach($arrcon as $key => $val){ 
/*			if(){
					
			}*/
			
/*			if(($point_week-$temp_pointweek) > $point_avg_person){
				GetDocumentAdd($siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person,$point_week,$k);	
			}
*/		//echo "<br>xxxx $point_week ::  ".$temp_pointweek;
		return $arr_assign1;
		
}// end function GetDocumentAdd($siteid,$profile_id,$diffpoint,$temp_pointweek,$point_avg_person){
	
######### function �Ҫش��������§�Ѻ��ṹ���Ҵ�
function GetDocumentFormPoint($siteid,$profile_id,$group_id,$point){
	global $dbnameuse;
		$arrcon1 = GetSqlConditionAgeGroup();
				if($arrcon1[$group_id] != ""){
					$conv = " AND $arrcon1[$group_id]";	
				}else{
					$conv = " ";	
				}//end if($arrcon[$key] != ""){

		$sql = "SELECT * FROM tbl_constan_assign_detail WHERE siteid='$siteid' AND profile_id='$profile_id' AND status_doc='1' AND flag_assign='0' AND flag_mark='0' AND temp_age_gov <='".GetAgeGovFromPoint($point)."' $conv  ORDER BY temp_age_gov DESC";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[idcard]] = GetPointFormAgeGov($rs[temp_age_gov]);
		}// end 	while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetDocumentFormPoint(){


#####  function ���§�ӴѺࢵ��������Ӥѭ
function GetSite(){
	global $dbnameuse;
	$sql = "SELECT
tbl_constan_assign.siteid
ORDER BY 
 tbl_constan_assign.num_person_assign DESC,tbl_constan_assign.date_import ASC";
 	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrsite[] = $rs[siteid];
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function GetSite(){
	
	
function ShowOfficeName($schoolid){
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
global $dbnamemaster;
$sql_org = "SELECT * FROM allschool WHERE id='$schoolid'";
//echo $dbnamemaster." :: ".$sql_org;
$result_org = mysql_db_query($dbnamemaster,$sql_org)or die(mysql_error());
$rs_org = mysql_fetch_assoc($result_org);
if($rs_org[office] != ""){ $temp_org = $rs_org[office];}else{ $temp_org = "����к�";}
return $temp_org;
}// end function ShowOfficeName($schoolid){

### function �ʴ���鹷��
function ShowSecname($siteid){
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	
	return str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname]);
} // end function ShowSecname($siteid){


function GetStaffApprove($staffid,$profile_id){
	global $dbnameuse;
	$sql = "SELECT
t1.ticketid,
Count(idcard) AS numall,
Sum(if(userkey_wait_approve='1',1,0)) AS approve,
Sum(if(userkey_wait_approve='0',1,0)) AS notapprove
FROM
tbl_assign_key as t1
Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
where t1.profile_id='$profile_id' and t2.staffid='$staffid'
group by t1.ticketid
";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[ticketid]]['approve'] = $rs[approve];
	$arr[$rs[ticketid]]['notapprove'] = $rs[notapprove];
	$arr[$rs[ticketid]]['numall'] = $rs[numall];
	}//end 
	
return $arr;
}

##########  function ����¹�ҡ�� �.�. �繻� �.�.
function Sw_DateEng($temp){
		if($temp != "0000-00-00" and $temp != "" and $temp != "//"){
			$arr1 = explode("/",$temp);
			return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
				
		}
}//end 
//SaveTempAssign("4","0105"); // �� temp ��¤����ࢵ���зӡ���ͺ���§ҹ
//ProcessGroupAge("0105","4"); // �� flag �Ҩӹǹ������С���������Ҫ���
//$arrdata = RandomDocumentAssign("10767","0105","4");
//echo "<pre>";
//print_r($arrdata);


function GetDocNokeyAsPoint($staffid,$profile_id){
	global $dbnameuse;
	$yyprocess = (date("Y")+543)."-09-30";
	$sql = "SELECT
t3.birthday,
FLOOR((TIMESTAMPDIFF(MONTH,t3.birthday,'$yyprocess')/12)) as agep,
FLOOR((TIMESTAMPDIFF(MONTH,t3.begindate,'$yyprocess')/12)) as age_gov
FROM ".DB_USERENTRY.".tbl_assign_sub as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.ticketid = t2.ticketid
Inner Join  ".DB_MASTER.".view_general as t3 ON t2.idcard = t3.CZ_ID 
WHERE
t2.status_keydata =  '0' AND
t2.profile_id =  '$profile_id' AND
t1.staffid =  '$staffid'";	
	$result = mysql_db_query($dbnameuse,$sql);
	$point_b = 0;
	$intA = 0;
	while($rs = mysql_fetch_assoc($result)){
		if($rs[age_gov] < 0 or $rs[age_gov] == ""){
			$age =  GetAgeGoverment($rs[birthday]);
		}else{
			$age = $rs[age_gov];	
		}
		$point_b += GetPointFormAgeGov($age);
		$intA++;
			
	}// end while($rs = mysql_fetch_assoc($result)){
		$arr['point'] = $point_b;
		$arr['num'] = $intA;
	return $arr; // ��ṹ����ҧ
}//end function GetDocNokeyAsPoint($staffid,$profile_id){






?>