<?
session_start();
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");

$subfix = "_log_after";


$arr_tblc = array("salary"=>"id","graduate"=>"id");

function CheckDataIN($siteid,$idcard){
	global $arr_tblc;
	$dbsite = "cmss_".$siteid;	
	$intNum = 0;
	if(count($arr_tblc) > 0){
			foreach($arr_tblc as $tbl => $val_key){
				$sql = "SELECT COUNT($val_key) as num1 FROM $tbl WHERE $val_key='$idcard' ";	
				$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				$rs  = mysql_fetch_assoc($result);
				if($rs[num1] > 0){
						$intNum++;
				}
			}
	}// end if(count($arr_tblc) > 0){
	return $intNum;	
}// end function CheckDataIN($siteid,$idcard){
	
##########  function �Ѻ��÷Ѵ������ ������������к� ###########
function CountDataInTable($siteid,$tbl,$key,$value){
	$dbsite = "cmss_".$siteid;		
	$sql = "SELECT COUNT($key) as num1 FROM $tbl WHERE $key='$value' ";
	$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CountDataInTable(){


function InsertDataTemp(){
		global $dbname_center;
		## ��ҧ������
		$sql_clean = "DELETE FROM temp_tranferdata ";
		mysql_db_query($dbname_center,$sql_clean) or die(mysql_error()."".__LINE__);
		## �红�����
		$sql = "INSERT INTO  temp_tranferdata(idcard,siteid) 
SELECT
t1.idcard,
t1.siteid_dest
FROM `tbl_logmaster` as t1
where t1.siteid_source=t1.siteid_dest
group by t1.idcard";
	$result = mysql_db_query($dbname_center,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	
}//end function InsertDataTemp(){
	
#################  function get field 
function GetFieldTable($siteid,$tbl){
		$dbsite = "cmss_".$siteid;
		$infield = "";
		$sql = "SHOW COLUMNS FROM  $tbl  WHERE  Extra NOT LIKE '%auto_increment%'";
		$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				if($infield > "") $infield .= ",";
				$infield .= "$rs[Field]";
		}// end 	while($rs = mysql_fetch_assoc($result)){
			
		return $infield;
}
##############  end function Get Field

function GetTableList(){
		global $dbnamemaster;
		$sql = "SELECT tablename,primary_key,group_data FROM `table_config` where menu_id > 0 and tablename NOT LIKE 'general%'";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arrTbl[$rs[tablename]] = $rs[primary_key]."||".$rs[group_data];
		}// end while($rs = mysql_fetch_assoc($result)){
		return $arrTbl;
}// end function GetTableList(){

function UpdateStatusData($Field,$value,$idcard){
	global $dbname_center;
	$sql = "UPDATE temp_tranferdata SET $Field='$value'  WHERE idcard='$idcard' ";	
	#echo $sql."<br>";
	mysql_db_query($dbname_center,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
}// end function UpdateStatusData(){
############# ��Ǩ�ͺ��������¨ҡ������¢�����ࢵ���ǡѹ ################
if($_GET['action'] == "process"){
	
	InsertDataTemp(); // �红����ŷ������¢����š�Ѻ������ temp ��͹
	
	$sql = "SELECT t1.idcard, t1.siteid_dest as siteid FROM `tbl_logmaster` as t1 where t1.siteid_source=t1.siteid_dest group by t1.idcard";
	$result = mysql_db_query($dbname_center,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$intA = 0;
	while($rs = mysql_fetch_assoc($result)){
		$db_site = "cmss_".$rs[siteid]; // �ҹ������
		if(CheckDataIN($rs[siteid],$rs[idcard]) > 0){ // �óյ�Ǩ�������բ����������ҧ㹡�͹����
				UpdateStatusData("status_datainsite","1",$rs[idcard]);
		}else{ // �зӡ�����¢����š�� log  afer �����㹢����Ũ�ԧ
 			if(count(GetTableList()) > 0){
					foreach(GetTableList() as $tbl => $tbl_key){
						$exp_key = explode("||",$tbl_key); // �����Ť��� ��� �����ŷ��С���
						$key = $exp_key[0]; // ��������ŷ�������
						$data_group = $exp_key[1]; // �����ŷ������껢�����
						$num_data = CountDataInTable($rs[siteid],$tbl,$key,$rs[idcard]);
						if($num_data < 1){ // �ҡ����բ�����㹻��·ҧ���ӡ�����¢�����
								$sql_insert = "INSERT INTO $tbl (".GetFieldTable($rs[siteid],$tbl).") SELECT ".GetFieldTable($rs[siteid],$tbl)." FROM  $tbl".$subfix." WHERE $key='$rs[idcard]' GROUP BY $data_group ";
								#echo $sql_insert."<br>";
								$result_insert = mysql_db_query($db_site,$sql_insert);
								$intA++;
							
						}//end if($num_data < 1){		
					}// end foreach(GetTableList() as $key => $val){
			}// end if(count(GetTableList()) > 0){
				#### end ���¢����Ũҡ log �����
				
				if($intA > 0){
						
						UpdateStatusData("status_tranfer","1",$rs[idcard]); // update ʶҹС�����¢�����


				}//end if($intA > 0){
				
				$intA = 0;
		}
		
			
	}//end while($rs = mysql_fetch_assoc($result)){
		
		
		
echo "Done....";		
}//end if($_GET['action'] == "process"){
################## end ��Ǩ�ͺ��������¨ҡ������¢�����ࢵ���ǡѹ #############

echo "<a href='?action=process'>�����żŢ�����</a>";
//echo "<br>END";
?>
