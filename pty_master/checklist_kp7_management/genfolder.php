<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_genfolder"; 
$process_id			= "genfolder";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
set_time_limit(0);
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();
$pathN = "../../../foldername/";
$secname = ShowAreaSortName($xsiteid);
$foldermain = $pathN.$xsiteid."/";
$filesave = $pathN.$xsiteid.".zip";

include("../../common/class_zipfolder/spectre.zip.php");
 $zip= new spectreZip(); 
if($action == "process"){
	if(!is_dir($foldermain)){
		RmkDirPath($foldermain);
		//chmod($foldermain,"0777");
		
	}//end if(is_dir($foldermain)){
	
		$sql = "SELECT id,office,siteid FROM allschool WHERE siteid='$xsiteid'";
		//echo $dbnamemaster." :: ".$sql;die;
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$i++;
			$dirName = $foldermain.$rs[id]."/";
			
			if(!is_dir($dirName)){
			//echo "$i :: $dirName<br>";
				RmkDirPath($dirName);	
				//chmod($dirName,"0777");
			}//end if(!is_dir($dirName)){
			$zip->addFile("$dirName");   // สร้างไฟล์ zip
				
		}//end while($rs = mysql_fetch_assoc($result)){
			
		$zip->render("$filesave","save");  // ทำการบันทึกไฟล์ zip
}//end if($action == "process"){
?>

<HTML><HEAD><TITLE>เครื่องมือในการสร้างโฟล์เดอร์ในระบบ</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
.style4 {
	font-size:12px;
	padding-left:5px;
	padding-right:5px;
	color: #ffffff;
	font-style: italic;
}
-->
</style>
</HEAD>
<BODY bgcolor="#A5B2CE">
<?  
if(file_exists($filesave)){
	
	echo "<a href='$filesave'>Download[$secname]</a>";
		
}else{
	echo " <font color='#FF0000'>ERROR ไม่สามารถสร้าง Folder ได้</font>";	
}
	
	
	
	
	
	
	
	
if($action == "delete_folder"){
	
	$sql = "SELECT id FROM allschool WHERE siteid='$xsiteid'";
		//echo $dbnamemaster." :: ".$sql;die;
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$i++;
			$dirName = $foldermain.$rs[id]."/";
			//echo $dirName."<br>";
			RecursiveFolderDelete($dirName);
		}//end while($rs = mysql_fetch_assoc($result)){
		RecursiveFolderDelete($foldermain);
}//end if($action == "delete_folder"){
?>
</BODY></HTML>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>