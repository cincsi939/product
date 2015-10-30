<?
#require_once("../../../common/preloading.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_list_person";
$module_code 		= "list_person"; 
$process_id			= "list_person";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################
session_start() ; 


include("../../../config/conndb_nonsession.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();

require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";
  require_once "../../../common/class.excel.reader.php";

//include("timefunc.inc.php");

set_time_limit(3600);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

 
$masterdb =  $dbnamemaster ; 
$masterIP = "192.168.2.12";
#$masterIP = "127.0.0.1";
$nowIP =  HOST; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานสถานะความครบถ้วน</title>

</head>
<body  > 
Start ................................................  
<?
 
conn($masterIP) ; 
echo " $masterIP <br /> ";
if ($goupload != ""){ 
 
#echo "frm_upload_name  :::::::::::::::: $frm_upload_name   <hr> " ;

$timenow3 = date("Y") . date("m") . date("j") ."T". date("H") . date("i") . date("s")  ; 
$extfile = "_" . $timenow3  .".xls" ; 

$new_uploadfile = str_replace(".xls" , $extfile , $frm_upload_name ) ; 
#echo "   new_uploadfile ::::::::::  $new_uploadfile   <hr> " ;	

$path = "../../../../competency__tmpxls/update_scexe";
#$path = "";
##################################################################### 
if (!(copy( $frm_upload , "$path/".$new_uploadfile   ))){	
	echo " UPLOAD  $new_uploadfile  NOT Suceess !! <hr> ";	
}else{
	echo " UPLOAD Success  $path/$new_uploadfile  <hr>  ";
} ############## END Upload file ==> if (!(copy( $frm_upload , "$path/".$new_uploadfile   ))){	 


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
// Set output Encoding.
$data->setOutputEncoding('TIS-620');
$data->read($path. "/".$new_uploadfile  );


$xareaname = $data->sheets[0]['cells'][1][1];
echo " <h3> $xareaname  </h3> ";
for ($i =8; $i <= $data->sheets[0]['numRows']; $i++) {
	$xls_scid  = trim($data->sheets[0]['cells'][$i][1])  ;   
	$xls_scname  = trim($data->sheets[0]['cells'][$i][2])  ; 
	$xls_schead  = trim($data->sheets[0]['cells'][$i][3])  ; 
	$xls_scvoice  = trim($data->sheets[0]['cells'][$i][4])  ; 
	$xls_scamp  = trim($data->sheets[0]['cells'][$i][5])  ; 
	$xls_sctam  = trim($data->sheets[0]['cells'][$i][6])  ; 
	$xls_scnotes  = trim($data->sheets[0]['cells'][$i][7])  ;
	
	if (( $xls_scid =="" ) and  ( $xls_scname =="" ) and  ( $xls_schead =="" ) and  ( $xls_scvoice =="" )  ){
		continue ; 
	}
	echo " <hr> $i  :::::::::$xls_scid    ___   $xls_scname ___ $xls_schead  ___ $xls_scvoice      <br> " ; 
	$sqlup = "UPDATE `allschool` SET `sc_head`='$xls_schead',`voice_exe`='$xls_scvoice' WHERE (`id`='$xls_scid')  ;  ";
	mysql_db_query($masterdb , $sqlup) ; 
	echo "<br>$i  : OK  &nbsp;   $xls_scid &nbsp; &nbsp; &nbsp;  $xls_scname   <br>  $sqlup <br> ";
	if (mysql_errno() != 0 ) { echo "  $sqlup  <b> " .mysql_error()     .  "<b>   <br>  " ;  }
	# ------------------------------------------------------------------------------------------------------------------------> เริ่มหาข้อมูลอำเภอ 
	if (($xls_scnotes  =="edit" ) or ($xls_scnotes  =="add" )){ 
		$sql2 = " SELECT ccDigi  FROM `ccaa` WHERE `ccName` LIKE '%$xls_scamp%' ";
		$result2 = mysql_db_query($masterdb , $sql2) ; 
		$rs2 = mysql_fetch_assoc($result2) ; 
		$ampid = substr($rs2[ccDigi] , 0,4)  ; 
		
		$sql3 = " SELECT * FROM `ccaa` WHERE `ccDigi` LIKE '$ampid%' AND `ccName` LIKE '%$xls_sctam%'  ";
		$result3 = mysql_db_query($masterdb , $sql3) ; 
		$rs3 = mysql_fetch_assoc($result3) ; 
		$tamid = substr($rs3[ccDigi] , 0,6)  ; 		
		
		$sql4 = " UPDATE `allschool` SET `moiareaid`='$tamid' WHERE (`id`='$xls_scid')   ";
		$result4 = mysql_db_query($masterdb , $sql4) ; 
#		echo "  UPDATE รหัสพื้นที่ ::::: ||  $ampid ||  $tamid  || $sql3   <br>  ||   $sql4  <br>  ";
		if (mysql_errno() != 0 ) { echo "  $sql4  <b> " .mysql_error()     .  "<b>   <br>  " ;  }else{  echo " Update รหัสตำบล เสร็จสิ้น"; } 
	} #############  if (($xls_scnotes  =="edit" ) or ($xls_scnotes  =="add" )){ 
	
}  ############## for for ($i =8; $i <= $data->sheets[0]['numRows']; $i++) { 



?>
 <?
 die( " LINE :::::::::::   " . __LINE__ ) ;
} ######### END if ($goupload != ""){    ?> 
xxxxxxxxxxxxxxxx
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="90%" border="0" align="center">
    <tr>
      <td width="28%">&nbsp;</td>
      <td width="52%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td>เขต</td>
      <td>
<?
$sql = " SELECT secid , secname  FROM `eduarea`  where  `secid` <> '1040' AND `secid` < '9900' AND `secid` <> '1000' ";
$result = mysql_db_query($masterdb , $sql ) ; 

?> 	  
	  &nbsp;
	  <select name='frm_siteid' id='frm_siteid'>
<?  while ($rs = mysql_fetch_assoc($result)){  ?>	  
	    <option value='<?=$rs[secid]?>'><?=$rs[secname]?></option>
<?  } ########## ?>
	    </select>
	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>กรุณาเลือกไฟล์</td>
      <td><input name="frm_upload" type="file" id="frm_upload" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="goupload" type="submit" id="goupload" value="upload" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
