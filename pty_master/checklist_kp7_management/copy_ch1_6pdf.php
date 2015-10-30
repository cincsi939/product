<?
set_time_limit(0);

include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");
$db_system = "competency_system";

function CountPdfXref(){
	global $db_system;
	$sql = "SELECT count(siteid) as num1,siteid FROM `log_check_pdf`  group by siteid ORDER BY siteid";
	$result = mysql_db_query($db_system,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	return $arr;
}//end function CountPdfXref(){
function xShowArea($get_siteid){
	global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	///echo "::: ";$rs[secname];
	return $rs[secname];
}// function xShowArea($get_siteid){
function xShowSchool($get_schoolid){
	global $dbnamemaster;
	$sql = "SELECT office FROM allschool WHERE id='$get_schoolid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
		
}//end function xShowSchool(){
function xCountCheckKp7(){
	global $dbname_temp;
	$sql = "SELECT COUNT(idcard) as num1, siteid FROM tbl_checklist_kp7 GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr1[$rs[siteid]] = $rs[num1];
	}//end 	while($rs = mysql_fetch_assoc($result)){
		return $arr1;
}//end function xCountCheckKp7(){
	
	
	######################
	
function read_file_folder($get_site=""){
	if($get_site == ""){
		$Dir_Part="../../../checklist_kp7file/fileall/";	
	}else{
		$Dir_Part="../../../checklist_kp7file/$get_site/";	
	}
		
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
	// edit_pic----------------------------------------------------------------------------------------<br />

$arr_area = array("5001","5002","5003","5004","5005","5006");
	
if($action == "copy"){
	foreach($arr_area as $key => $val){
		$file_pdf = read_file_folder($val);
		$path_s =  "../../../".PATH_KP7_FILE."/$val/";
		$path_n = "../../../temp_pdf_ch1_6/$val/";
		if(count($file_pdf) > 0){
		$j=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v' AND siteid='$val'";
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$rsc = mysql_fetch_assoc($result_c);
				if($rsc[idcard] != ""){
					$j++;
					$file_source = $path_s.$v.".pdf";
					$file_dest = $path_n.$v.".pdf";
					if(copy($file_source,$file_dest)){
						$sql_log = "REPLACE INTO log_copy_pdf SET idcard='$v' ,siteid='$val'";	
						mysql_db_query($dbname_temp,$sql_log);
					}
					//exit;
				}//end if($rsc[idcard] != ""){
				
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
		
			
	}//end foreach($arr_area as $key => $val){
	
}// end if($action == "copy"){

?> 



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>รายงานการตรวจสอบไฟล์ pdf error Xref</title>
</head>
<body>
<a href="?action=copy">ประมวลผล</a>
</body>
</html>
