<?
header("Content-Type: text/html; charset=windows-874");  session_start(); 
			@include ("../../../../common/common_competency.inc.php")  ;
			@include("../../../../config/conndb_nonsession.inc.php");
			$time_start = getmicrotime();
			set_time_limit(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ADD INDEX</title>
</head>
<?
if($sent_secid != ""){
	$conv1 = " AND  secid LIKE '$sent_secid'";
		
}else{
	$conv1 = "";	
}
$xx="0";
$sql="SELECT secid  FROM eduarea  WHERE secid NOT LIKE '99%' $conv1";
//echo $sql;die;
//$sql="SELECT secid  FROM eduarea where secid='5001' order by secid limit 1";  
 $result_temp = mysql_db_query(DB_MASTER,$sql); 
 
$arr[]="salary_log_";
$arr[]="general_log_";
$arr[]="general_pic_log_";
$arr[]="getroyal_log_";
$arr[]="goodman_log_";
$arr[]="graduate_log_";
$arr[]="hr_absent_log_";
$arr[]="hr_addhistoryaddress_log_";
$arr[]="hr_addhistoryfathername_log_";
$arr[]="hr_addhistorymarry_log_";
$arr[]="hr_addhistorymothername_log_";
$arr[]="hr_addhistoryname_log_";
$arr[]="hr_nosalary_log_";
$arr[]="hr_other_log_";
$arr[]="hr_prohibit_log_";
$arr[]="hr_specialduty_log_";
$arr[]="seminar_log_";
$arr[]="special_log_";
$arr[]="vitaya_stat_log_";  

while($rs_temp = mysql_fetch_array($result_temp)){    
    echo "$rs_temp[secid] <br>";
    foreach($arr as $index=>$value){
        $value_before=$value."before";
        $value_after=$value."after";  
         $result_max = mysql_db_query(STR_PREFIX_DB.$rs_temp[secid],"(Select MAX(auto_id) as maxid from $value_after)"); 
         if(!$result_max){
                        $sql=" insert into log_auto_error( site,xtable,remark,app) values( '$rs_temp[secid]','$value','". str_replace("'",'', mysql_error()) ."','AUTO_INCREMENT') ";
                        mysql_db_query("temp_pobec_import",$sql); 
        }else{ 
         
         $row_max=mysql_fetch_array($result_max);
         $sql1="ALTER TABLE $value_before AUTO_INCREMENT =".($row_max[maxid]+1);       
            !$x=$result1 = mysql_db_query(STR_PREFIX_DB.$rs_temp[secid],$sql1);
            if(!$x){
                        $sql=" insert into log_auto_error( site,xtable,remark,app) values( '$rs_temp[secid]','$value','".str_replace("'",'' ,mysql_error()) ."','AUTO_INCREMENT') ";
                        mysql_db_query("temp_pobec_import",$sql); 
                 }
    }       
    }
      //$sql=" update eduarea   set  active='0' where secid='$rs_temp[secid]' ";
     // mysql_db_query("temp_pobec_import",$sql); 
       //echo"<META http-equiv=\"refresh\"content=\"1;URL=SET_AUTO_INCREMENT.php\"> ";   
     }

?>
<? echo "Time query : " ; $time_end = getmicrotime(); echo ($time_end - $time_start);echo " Sec.";?>
