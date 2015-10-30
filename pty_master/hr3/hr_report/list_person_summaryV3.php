<?
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
if ($xsiteid != "") {  $_SESSION[secid] =$xsiteid ; } 
if ($loginid != "") {  $_SESSION[secid]=$loginid  ;   } 

include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";
# require_once("../../../common/preloading.php");
//include("timefunc.inc.php");

set_time_limit(3600);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

#$masterDB = "cmss_otcsc" ; 
#$masterIP = "192.168.2.12";
#$masterIP = "127.0.0.1";

$nowIPx =  $_SERVER[SERVER_ADDR] ; 
if ($nowIPx == "127.0.0.1"){
	$masterIP = "127.0.0.1";
	$nowIP = "localhost";
}else{
	$masterIP = "192.168.2.12";	
	$nowIP =  HOST ;
} ############### END  if ($nowIP == "127.0.0.1"){
#$masterIP = "192.168.2.12";	
$localDB =  $hr_dbname ; 
$masterDB = $dbnamemaster ; 
$title 	= "จำแนกตามสังกัด"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานสถานะความครบถ้วน</title>

</head>
<body  >

<?


#	while (list ($key, $val) = each ($_POST)) {
#		echo " <br> $key  :::: $val   ";
#	}  // end while (list 

if ( $_POST[submit]  != ""){ 
	$sql = " SELECT * FROM `login` WHERE `username` LIKE '$frm_username' AND `pwd` LIKE '$frm_password'    ";
	$result = mysql_db_query($localDB , $sql) ;  
	$nm_row = @mysql_num_rows($result) ; 
	if ($nm_row > 0 ){ 
		$rs = mysql_fetch_assoc($result) ; 
		$xsiteid = $rs[id] ; 
#		echo "   <hr>    :::::::::::::::::  $xsiteid    ";

	}else{
		$errmsg = "  <br><br> <font color =red><b>ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง </b></font>  ";
	}
} ############ if ( $submit != ""){  

$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$loginid'  "; 
$result = mysql_db_query($masterDB , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 

#  die (" หยุดบรรทัดที่ ".__LINE__) ; 
if ($xsiteid == ""){ 
############################################# loginid
## /competency/application/hr3/hr_report/list_person_summary.php 
?>
 <br />
<table width="480" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2 solid #BED6E0">
  <tr bgcolor="#E9F5F7">
    <td align="center" style="background-repeat:repeat-x;"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">&nbsp;</td>
            <td height="45" align="center" valign="middle" class="strong_black" > 
 สถานะความครบถ้วนการบันทึกข้อมูล  <br />
<?=$rssecname?>   <?=$errmsg?></td>
          </tr>
          <tr>
            <td width="1%" valign="top">&nbsp;</td>
            <td valign="top"><table width="90%" align="center" cellpadding="3" cellspacing="0" style="border:#FFFFFF 1 solid; ">
                <tr>
                  <td class="login_fill1"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr>
                        <td class="login_fill2"> 
                            <form action="?loginid=<?=$loginid?>" method="post" name="post" id="post"   >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="login_text">
                                <tr>
                                  <td width="10%">&nbsp;</td>
                                  <td width="24%" align="right"><strong>รหัสผู้ใช้</strong></td>
                                  <td width="66%" align="left"><input name="frm_username" type="text" id="frm_username" value="" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="right"><strong>รหัสผ่าน</strong></td>
                                  <td align="left"><label>
                                    <input name="frm_password" type="password" id="frm_password" value=""/>
                                  </label></td>
                                </tr>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left"><label>
                                    <input type="submit" name="submit" value="ตกลง" />
                                    <input name="loginid" type="hidden" id="loginid" value="<?=$loginid?>" />
                                    <input type="button" name="Button" value="ยกเลิก"  onclick="history.go(-1)"/>
                                  </label></td>
                                </tr>
                              </table>
                          </form></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
  </tr>
  <tr bgcolor="#8D99C4">
    <td background="images/tip_icon.gif" bgcolor="#E9F5F7" class="login_text" style=" padding:0px 5px 0px 50px; background-repeat:no-repeat"><p>สำหรับเจ้าหน้าบุคลากรของแต่ละหน่วยงานให้ป้อนรหัสผู้ใช้/รหัสผ่านประจำหน่วยงานของท่านตามที่  สพท. ได้แจ้งให้ทราบ หากสงสัยกรุณาติดต่อ <u><a href="http://www.sapphire.co.th/_sapphire/service_program.php?menu=5" target="_blank">Call center</a></u><strong><br />
            <br />
    </strong></p></td>
  </tr>
</table>
<?
	echo "   "; die; 
} 	

?>
<?	  ################################################################# จำนวน บุคลากรที่ต้องบันทึกข้อมูล
conn($masterIP) ; 
$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$xsiteid'  "; 
$result = mysql_db_query($masterDB , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 
# echo __LINE__ . " cxxxxxxxxx   "; 	    die; 

	$sql1 = "  SELECT * FROM `allschool` WHERE `siteid` LIKE '$xsiteid'   	 "; 
#	 echo " $sql1  " ; 
	$result1= mysql_db_query($masterDB , $sql1); 
	$school_nm = mysql_num_rows($result1)  ; 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[id] ; 
		$arr_name[$depid]  =  $rs1[office] ;  	
		$arr_voiceexe[$depid]  =  $rs1[voice_exe] ;  
		$arr_schead[$depid]  =  $rs1[sc_head] ;  
	}
 ################################################## ผู้บริหาร / เจ้าหน้าที่ในเขต ตามเกณฑ์
$sql1= " 
SELECT  siteid,  areaname, sc_num, area_head, area_voicehead, area_eduadvice, area_staff
FROM `area_staffref`
WHERE `siteid` LIKE '$xsiteid'
";
$result1= mysql_db_query($masterDB , $sql1); 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 

while($rs1 = @mysql_fetch_assoc($result1)){	
################################################	
	$std_area_head =  $rs1[area_head] ; 
	$std_area_voicehead =  $rs1[area_voicehead] ; 	
	$std_area_eduadvice =  $rs1[area_eduadvice] ; 	
	$std_area_staff =  $rs1[area_staff] ; 	
}
?>
<?
conn($nowIP) ; 	

######################################################################### หา  ผอ.  รร
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  'ผู้อำนวยการ%'  
	and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
	group by schoolid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scex[$depid]  =  $rs1[countnm] ;  	
	}
######################################################################### หา  ผอ. รร APPROVE แล้ว 
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  'ผู้อำนวยการ%'    and approve_status = 'approve'  
	and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
	group by schoolid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scex_approve[$depid]  =  $rs1[countnm] ;  	
	}	
######################################################################### หารอง ผอ. รร
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  'รอง%'  
	and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
	group by schoolid  
	" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scvoice[$depid]  =  $rs1[countnm] ;  		
	}
######################################################################### หา  รองผอ. รร APPROVE แล้ว 
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  'รอง%'  and schoolid != ''  and approve_status = 'approve'   
	and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
	group by schoolid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scvoice_approve[$depid]  =  $rs1[countnm] ;  		
	}

#	print_r($arr_name) ; 
################ ข้อมูลที่ได้จาก E_me	
?>
<? ##################################ค้นหา %ผอ% ==> ได้   ผอ. สพท.
$sql1 = "  
SELECT    count(  position_now ) AS  countnm  FROM   general  
WHERE  (
general.position_now LIKE  'ผู้อำนวยการ%' OR  general.position_now LIKE  'ผอ%'   )
AND (
general.position_now LIKE  '%สำนักงานเขตพื้นที่การศึกษา%' OR general.position_now LIKE  '%สพท%' )
 AND(
general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
 AND
( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid =  $xsiteid 
" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_head  =  $rs1[countnm] ;  		
	}
	

	#################################################### ผอ.ที่ approve ใช้ SQL ด้านบน เพิ่มอีกเงื่อนไข
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_head_approve  =  $rs1[countnm] ;  		
	}
?>
<? ##################################ค้นหา %ผอ% ==> ได้  รองผอ. สพท.
$sql1 = "  
SELECT    count(  position_now ) AS  countnm  FROM   general  
WHERE  (
general.position_now LIKE  '%ผู้อำนวยการ%' OR  general.position_now LIKE  '%ผอ%'   )
AND (
general.position_now NOT LIKE  'ผู้อำนวยการ%' and  general.position_now  NOT LIKE  'ผอ%'   )
AND (
general.position_now LIKE  '%สำนักงานเขตพื้นที่การศึกษา%' OR general.position_now LIKE  '%สพท%' )
 AND(
general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
 AND
( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid =  $xsiteid 
" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_voicehead  =  $rs1[countnm] ;  		
	}
	

	#################################################### ผอ.ที่ approve ใช้ SQL ด้านบน เพิ่มอีกเงื่อนไข
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_voicehead_approve  =  $rs1[countnm] ;  		
	}
?>
<?   ################################### หา  เจ้าหน้าที่ในเขต ไม่รวมศึกษานิเทศน์ 
$sql1 = "  
SELECT  count(  position_now ) AS  countnm   FROM   general  
WHERE  (
general.position_now not LIKE  '%ผู้อำนวยการ%' and   general.position_now not LIKE  '%ผอ%'   )
# AND( general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
 AND ( general.position_now not  LIKE  '%ครู%'    )
 AND ( general.position_now not  LIKE  '%ศึกษานิ%'    )
 AND ( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid = $xsiteid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$areastaff =  $rs1[countnm] ;  		
	}
	#################################################### เจ้าหน้าที่ approve ใช้ SQL ด้านบน เพิ่มอีกเงื่อนไข
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$areastaff_approve  =  $rs1[countnm] ;  		
	}
################################################## เจ้าหน้าที่ในเขต ตามเกณฑ์
?>
<?   ################################### หา  เจ้าหน้าที่ในเขต เฉพาะ ศึกษานิเทศน์ 
$sql1 = "  
SELECT  count(  position_now ) AS  countnm   FROM   general  
WHERE  
  ( general.position_now    LIKE  '%ศึกษานิ%'    )
 and   siteid = $xsiteid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_eduadvice =  $rs1[countnm] ;  		
	}
	#################################################### เจ้าหน้าที่ approve ใช้ SQL ด้านบน เพิ่มอีกเงื่อนไข
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_eduadvice_approve  =  $rs1[countnm] ;  		
	}
################################################## เจ้าหน้าที่ในเขต ตามเกณฑ์
?>



 
<? 
@reset($arr_name) ; 
@reset($arr_name1) ; 
/*	
	$arrdb_scex    ####### ผอ.รร.รายโรง
	$arrdb_scex_approve   ####### ผอ.รร.รายโรง
	$arrdb_scvoice   ####### ผอ.รร.รายโรง
	$arrdb_scvoice_approve   ####### ผอ.รร.รายโรง
	$area_head   ####### ผอ. สพท.
	$area_head_approve   ####### ผอ. สพท.	 	
	$area_voicehead    ####### รอง. ผอ. สพท.	
	$area_voicehead_approve   ####### รอง. ผอ. สพท.	
	$area_eduadvice   ####### ศึกษานิเทศ
	$area_eduadvice_approve   #######  ศึกษานิเทศ 
*/	
?>
<table width="20%" border="0" align="center">
  <tr>
    <td><img src="images/spacer.gif" width="100" height="5" /></td>
  </tr>
</table>
 
<?
$std_sc = @array_sum($arr_schead)      ;
$std_scvoice =  @array_sum($arr_voiceexe) ; 
$std_sc_approve = @array_sum($arrdb_scex_approve)  ; 
$std_scvoice_approve = @array_sum($arrdb_scvoice_approve) ; 
########################################################
$entry_areahead = $area_head ; 
$entry_area_voicehead       = $area_voicehead      ;
$entry_area_eduadvice        = $area_eduadvice      ;
$entry_areastaff        = $areastaff      ;
$entry_schead        = @array_sum($arrdb_scex)      ;
$entry_scvoice        = @array_sum($arrdb_scvoice)      ;
########################################################
$scvoice_approve = @array_sum($arrdb_scvoice_approve) ;
$schead_approve =  @array_sum($arrdb_scex_approve) ;

########################################################
$alltarget = $std_area_head  + $std_area_voicehead+$std_area_eduadvice+$std_area_staff + $std_sc +  $std_scvoice   ;     
$allentry = $entry_areahead+$entry_area_voicehead+$entry_area_eduadvice+$entry_areastaff+$entry_schead+$entry_scvoice ; 
$allnow = $area_head_approve + $area_voicehead_approve+$area_eduadvice_approve+$areastaff_approve+$std_sc_approve               +   $std_scvoice_approve  ;    
	

		
	 $percennow = @(($allnow * 100)/  $alltarget)   ; 
	


?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style=" margin-top:10px; ">
  <tr>
    <td width="79%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2" style="color:#000000; font-size:12px; font-weight:bold">
      <tr>
        <td colspan="4" align="center">ภาพรวมการบันทึกข้อมูลเข้าสู่ระบบ สพท.
          <?=$rssecname?>        </td>
        </tr>
      <tr>
        <td width="62%">บุคลากรทั้งหมดที่ต้องบันทึกข้อมูลเข้าสู่ระบบตามหนังสือสั่งการ</td>
        <td width="16%" align="center" bgcolor="#99CC99" style="color:#000000"><?

	  echo number_format($alltarget)   ; 
	  ?></td>
        <td width="13%">&nbsp; </td>
        <td width="9%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" style="color:#000000">คน</td>
        <td align="center">ร้อยละ</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ตรวจสอบและรับรองความถูกต้อง </td>
        <td align="center" bgcolor="#FFCC99" style="color:#000000"><?
	  echo number_format($allnow) ; 
	  ?></td>
        <td align="center" bgcolor="#FFCC99"><span style="color:#000000">
          <?   echo number_format($percennow,2) ; 
	  ?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">รายงาน ณ วันที่
          <?
$timenow2 = date("Y") ."-".   date("m")   ."-".  date("j")  ." ". date("H")  .":". date("i")  .":". date("s")  ; #2006-05-20 12:07:01 		  
$db_lastupdate =  		$timenow2 ;  
$month1 = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$date1 = trim($db_lastupdate) ;
	if (!(($date1=="0000-00-00") OR  ($date1 ==""))){
		$arrdate1 = explode(" ",$date1) ;     
		$arrdate11 = explode("-",$arrdate1[0]) ;     #  2549-03-26	
		$thyy = (int)$arrdate11[0]  ;   	if ($thyy < 2299) { $thyy+=543 ; }  
		$mm =  (int)$arrdate11[1]   ;  	
		$dd  =   (int)$arrdate11[2]   ;  		
		$arrdate11 = explode(":",$arrdate1[1]) ;     # 17:52:27  
		$HH =   (int)$arrdate11[0]  ;  
		$min =   (int)$arrdate11[1]  ;  	
		$sec =   (int)$arrdate11[2]  ;  				
		$arr_date = array($thyy,$mm,$dd,$HH,$min,$sec) ;
	}else{ 
		$arr_date = false ; 
	}	
	echo $arr_date[2] ." ".  $month1[$arr_date[1]] ." ". $arr_date[0] ." เวลา ". $arr_date[3] .":". $arr_date[4] .":". $arr_date[5] ." นาที" 
	?></td>
      </tr>
    </table></td>
    <td width="21%" rowspan="2" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="170" height="170"
	codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0">
      <param value="bimg/cockpit_100.swf?actualGrade=<?=sprintf("%03.04f",number_format($percennow,2 ))?>&amp;<?=$alert?>" 
				name="movie" />
      <param name="quality" value="high" />
      <param name="wmode" value="transparent" />
      <embed src="bimg/cockpit_100.swf?actualGrade=<?=sprintf("%03.04f",number_format($percennow,2 ))?>&amp;<?=$alert?>" 
	quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" 
	width="170" height="170" swliveconnect="true"></embed>
    </object></td>
  </tr>
  
  <tr>
    <td valign="top"  >&nbsp;  </td>
  </tr>
</table>
	<table width="98%" border="0" align="center">
  
  <tr>
    <td width="33%"><a href="list_person_sc.php?xsiteid=<?=$xsiteid?>">แสดงรายละเอียดรายหน่วยงาน</a></td>
    <td width="46%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
</table>
<br />
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr bgcolor="#99CC99" class="strong_black"   align="center"  >
    <td rowspan="2"  >บุคคลากรที่ต้องบันทึกข้อมูลทั้งหมด ตามหนังสือเลขที่ ศธ.0206.6/1158 ลว.24 ก.ย. 2550 <br />
    <br /></td>
    <td>ทั้งหมดที่ต้องบันทึกข้อมูลเข้าสู่ระบบตามหนังสือสั่งการ </td>
    <td>อยู่ระหว่างบันทึกข้อมูล </td>
    <td colspan="2">ตรวจสอบและรับรองความถูกต้องของข้อมูล ตามเอกสาร กพ.7 แล้ว</td>
  </tr>
  <tr bgcolor="#99CC99" class="strong_black"  align="center"  >
    <td>คน</td>
    <td>คน</td>
    <td>คน</td>
    <td>ร้อยละ</td>
  </tr>
  <tr>
    <td bgcolor="EFEFEF"> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=1&xcol=2" target="_blank">ผอ.สพท.</a></td>
    <td align="center" bgcolor="EFEFEF"><?=$std_area_head?>    </td>
    <td align="center" bgcolor="EFEFEF">
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=1&xcol=2" target="_blank"></a>
	 
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=1&amp;xcol=3" target="_blank">
	  <?=$entry_areahead?>
      </a></td>
    <td align="center" bgcolor="EFEFEF"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=1&xcol=3" target="_blank"><?=$area_head_approve?>
    </a> </td>
    <td align="center" bgcolor="EFEFEF">
	<? $percen_headarea = $area_head_approve /  $area_head * 100 ; 
	echo number_format($percen_headarea,2 ) ; ?>    </td>
  </tr>
  <tr bgcolor="DDDDDD">
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=2" target="_blank">รอง ผอ.สพท.</a></td>
    <td align="center"> <?=$std_area_voicehead?>     </td>
    <td align="center">
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=2&xcol=2" target="_blank"></a>
 
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=2&amp;xcol=3" target="_blank">
	  <?=$entry_area_voicehead?>
      </a></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=2&xcol=3" target="_blank"><?=$area_voicehead_approve?> 
    </a></td>
    <td align="center"> 
	<? $percen_voiceheadarea = $area_voicehead_approve /  $std_area_voicehead * 100 ; 
	echo number_format($percen_voiceheadarea,2 ) ; ?>	</td>
  </tr>
  <tr bgcolor="EFEFEF">
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=3" target="_blank">ศึกษานิเทศน์</a></td>
    <td align="center"><?=$std_area_eduadvice?>     </td>
    <td align="center">
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=3&xcol=2" target="_blank"></a>
 
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=3&amp;xcol=3" target="_blank">
	  <?=$entry_area_eduadvice?>
      </a></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=3&xcol=3" target="_blank"><?=$area_eduadvice_approve?> 
    </a></td>
    <td align="center"> 
	<? $percen_eduadvice = $area_eduadvice_approve /  $std_area_eduadvice * 100 ; 
	echo number_format($percen_eduadvice,2 ) ; ?>	 </td>
  </tr>
  <tr bgcolor="DDDDDD">
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=4" target="_blank">บุคคลากรทางการศึกษาอื่นตามมาตรา 38 ค.(2)</a></td>
    <td align="center"><?=$std_area_staff?>
    <br /></td>
    <td align="center">
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=4&xcol=2" target="_blank"></a>
	   
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=4&amp;xcol=3" target="_blank">
	  <?=$entry_areastaff?>
      </a></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=4&xcol=3" target="_blank"><?=$areastaff_approve?>
    </a> </td>
    <td align="center"> 
	<? $percen_areastaff = $areastaff_approve /  $std_area_staff * 100 ; 
	echo number_format($percen_areastaff,2 ) ; ?>	 </td>
  </tr>
  <tr bgcolor="EFEFEF">
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=5" target="_blank">ผู้อำนวยการโรงเรียน</a></td>
    <td align="center"><?=$std_sc?>    </td>
    <td align="center">
	
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=5&xcol=2" target="_blank"></a>
	 
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=5&amp;xcol=3" target="_blank">
	  <?=number_format($entry_schead)?>
      </a></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=5&xcol=3" target="_blank"><?=number_format($schead_approve)?> 
    </a></td>
    <td align="center"> 
	<? $percen_schead = $schead_approve /  $std_sc * 100 ; 
	echo number_format($percen_schead,2 ) ; ?>	 </td>
  </tr>
  <tr bgcolor="DDDDDD">
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=6" target="_blank">รองผู้อำนวยการโรงเรียน </a></td>
    <td align="center"><?=number_format($std_scvoice)?>    </td>
    <td align="center">
	
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=6&xcol=2" target="_blank"></a>
	   
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&amp;xtype=6&amp;xcol=3" target="_blank">
	  <?=number_format($entry_scvoice)?>
      </a></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=6&xcol=3" target="_blank"><?=number_format($scvoice_approve)?>       
    </a></td>
    <td align="center">  
	<? $percen_scvoice_head = $scvoice_approve /  $std_scvoice * 100 ; 
	echo number_format($percen_scvoice_head,2 ) ; ?>	</td>
  </tr>
  <tr bgcolor="#99CC99" class="strong_black"   align="center" >
    <td bgcolor="#99CC99">รวม</td>
    <td align="center"><?=number_format($alltarget)?></td>
    <td align="center"><a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=0&xcol=2" target="_blank"></a>
    
      <? $xentry =  $alltarget - $allnow ;  echo  number_format($allentry) ; ?>
    </td>
    <td align="center"> 
	  <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=0&xcol=3" target="_blank"><?=number_format($allnow)?>
    </a> </td>
    <td align="center"> 
	<? $percen_all = $allnow /  $alltarget * 100 ; 
	echo number_format($percen_all,2 ) ; ?>	</td>
  </tr>
</table>
<?
#  ALTER TABLE `allschool` ADD `voice_exe` INT NOT NULL DEFAULT '2' COMMENT 'รอง/ผู้ช่วย ผอ.'; 
/*
	$area_head   ####### ผอ. สพท.
	$area_head_approve   ####### ผอ. สพท.	 	
	$area_voicehead    ####### รอง. ผอ. สพท.	
	$area_voicehead_approve   ####### รอง. ผอ. สพท.

	$arrdb_scex    ####### ผอ.รร.รายโรง
	$arrdb_scex_approve   ####### ผอ.รร.รายโรง
	$arrdb_scvoice   ####### ผอ.รร.รายโรง
	$arrdb_scvoice_approve   ####### ผอ.รร.รายโรง
	
	$area_eduadvice   ####### ศึกษานิเทศ
	$area_eduadvice_approve   #######  ศึกษานิเทศ 
*/

?>

</body>
</html>
