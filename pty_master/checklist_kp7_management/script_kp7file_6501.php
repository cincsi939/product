<?
session_start();
set_time_limit(0);

include("checklist2.inc.php");

function xRmkdir1($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}


$sql = "SELECT idcard,siteid,profile_id,date(time_update) as datet,schoolid,page_num,pic_num FROM tbl_checklist_kp7  WHERE status_numfile='1' and status_check_file='YES' and mainpage ='0' and  status_file='1' and status_id_false='0' and siteid='6501'";
$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	$file_path = "../../../checklist_kp7file/$rs[siteid]/";
	$xpathfile = "../../../checklist_kp7file/$rs[siteid]/$rs[idcard]/";
		if(!is_dir($xpathfile)){
			xRmkdir1($xpathfile);
	}
	$sfile = "$file_path".$rs[idcard].".pdf";
	$dfile = "$xpathfile".$rs[idcard]."_".$rs[datet].".pdf";
	if(file_exists($sfile)){
		
		if(copy($sfile,$dfile)){
			$page_num = XCountPagePdf_Brows($dfile);
			$i++;
			$sql_update = "UPDATE tbl_checklist_kp7 SET flag_uploadfalse='1' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error());
			
			$sql_insert = "REPLACE INTO tbl_checklist_log_uploadfile SET idcard='$rs[idcard]', siteid='$rs[siteid]',schoolid='$rs[schoolid]',numpage='$page_num',numpic='$rs[pic_num]',date_upload='$rs[datet]',kp7file='$dfile',user_update='',user_save='',time_update=NOW(),profile_id='$rs[profile_id]'";
			
			mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error());;
			
				
		}// end if(copy($sfile,$dfile)){
			
	}//end if(file_exists($sfile)){

	
}//end while($rs = mysql_fetch_assoc($result)){
echo "จำนวนรายการที่ update   $i  รายการ";




?>