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
$title 	= "��ṡ����ѧ�Ѵ"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>��§ҹʶҹФ����ú��ǹ</title>

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
		$errmsg = "  <br><br> <font color =red><b>���ͼ���� ���� ���ʼ�ҹ���١��ͧ </b></font>  ";
	}
} ############ if ( $submit != ""){  

$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$loginid'  "; 
$result = mysql_db_query($masterDB , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 

#  die (" ��ش��÷Ѵ��� ".__LINE__) ; 
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
 ʶҹФ����ú��ǹ��úѹ�֡������  <br />
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
                                  <td width="24%" align="right"><strong>���ʼ����</strong></td>
                                  <td width="66%" align="left"><input name="frm_username" type="text" id="frm_username" value="" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="right"><strong>���ʼ�ҹ</strong></td>
                                  <td align="left"><label>
                                    <input name="frm_password" type="password" id="frm_password" value=""/>
                                  </label></td>
                                </tr>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left"><label>
                                    <input type="submit" name="submit" value="��ŧ" />
                                    <input name="loginid" type="hidden" id="loginid" value="<?=$loginid?>" />
                                    <input type="button" name="Button" value="¡��ԡ"  onclick="history.go(-1)"/>
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
    <td background="images/tip_icon.gif" bgcolor="#E9F5F7" class="login_text" style=" padding:0px 5px 0px 50px; background-repeat:no-repeat"><p>����Ѻ���˹�Һؤ�ҡâͧ����˹��§ҹ����͹���ʼ����/���ʼ�ҹ��Ш�˹��§ҹ�ͧ��ҹ������  ʾ�. ��������Һ �ҡʧ��¡�سҵԴ��� <u><a href="http://www.sapphire.co.th/_sapphire/service_program.php?menu=5" target="_blank">Call center</a></u><strong><br />
            <br />
    </strong></p></td>
  </tr>
</table>
<?
	echo "   "; die; 
} 	

?>
<?	  ################################################################# �ӹǹ �ؤ�ҡ÷���ͧ�ѹ�֡������
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
 ################################################## �������� / ���˹�ҷ���ࢵ ���ࡳ��
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

######################################################################### ��  ��.  ��
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  '����ӹ�¡��%'  
	and position_now not like '%�ӹѡ�ҹࢵ��鹷�����֡��%' 	and position_now not like '%ʾ�%'
	group by schoolid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scex[$depid]  =  $rs1[countnm] ;  	
	}
######################################################################### ��  ��. �� APPROVE ���� 
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  '����ӹ�¡��%'    and approve_status = 'approve'  
	and position_now not like '%�ӹѡ�ҹࢵ��鹷�����֡��%' 	and position_now not like '%ʾ�%'
	group by schoolid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scex_approve[$depid]  =  $rs1[countnm] ;  	
	}	
######################################################################### ���ͧ ��. ��
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  '�ͧ%'  
	and position_now not like '%�ӹѡ�ҹࢵ��鹷�����֡��%' 	and position_now not like '%ʾ�%'
	group by schoolid  
	" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[schoolid] ; 	
		if ($depid == ""){ $depid = 99 ; } 
		$arrdb_scvoice[$depid]  =  $rs1[countnm] ;  		
	}
######################################################################### ��  �ͧ��. �� APPROVE ���� 
	$sql1 = "  
	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
	where  siteid =  $xsiteid  and     position_now like  '�ͧ%'  and schoolid != ''  and approve_status = 'approve'   
	and position_now not like '%�ӹѡ�ҹࢵ��鹷�����֡��%' 	and position_now not like '%ʾ�%'
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
################ �����ŷ����ҡ E_me	
?>
<? ##################################���� %��% ==> ��   ��. ʾ�.
$sql1 = "  
SELECT    count(  position_now ) AS  countnm  FROM   general  
WHERE  (
general.position_now LIKE  '����ӹ�¡��%' OR  general.position_now LIKE  '��%'   )
AND (
general.position_now LIKE  '%�ӹѡ�ҹࢵ��鹷�����֡��%' OR general.position_now LIKE  '%ʾ�%' )
 AND(
general.position_now not  LIKE  '%�ç���¹%' and general.position_now not LIKE  '%ʶҹ�֡��%'  )
 AND
( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid =  $xsiteid 
" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_head  =  $rs1[countnm] ;  		
	}
	

	#################################################### ��.��� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_head_approve  =  $rs1[countnm] ;  		
	}
?>
<? ##################################���� %��% ==> ��  �ͧ��. ʾ�.
$sql1 = "  
SELECT    count(  position_now ) AS  countnm  FROM   general  
WHERE  (
general.position_now LIKE  '%����ӹ�¡��%' OR  general.position_now LIKE  '%��%'   )
AND (
general.position_now NOT LIKE  '����ӹ�¡��%' and  general.position_now  NOT LIKE  '��%'   )
AND (
general.position_now LIKE  '%�ӹѡ�ҹࢵ��鹷�����֡��%' OR general.position_now LIKE  '%ʾ�%' )
 AND(
general.position_now not  LIKE  '%�ç���¹%' and general.position_now not LIKE  '%ʶҹ�֡��%'  )
 AND
( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid =  $xsiteid 
" ; 
	
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_voicehead  =  $rs1[countnm] ;  		
	}
	

	#################################################### ��.��� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_voicehead_approve  =  $rs1[countnm] ;  		
	}
?>
<?   ################################### ��  ���˹�ҷ���ࢵ �������֡�ҹ��ȹ� 
$sql1 = "  
SELECT  count(  position_now ) AS  countnm   FROM   general  
WHERE  (
general.position_now not LIKE  '%����ӹ�¡��%' and   general.position_now not LIKE  '%��%'   )
# AND( general.position_now not  LIKE  '%�ç���¹%' and general.position_now not LIKE  '%ʶҹ�֡��%'  )
 AND ( general.position_now not  LIKE  '%���%'    )
 AND ( general.position_now not  LIKE  '%�֡�ҹ�%'    )
 AND ( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid = $xsiteid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$areastaff =  $rs1[countnm] ;  		
	}
	#################################################### ���˹�ҷ�� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$areastaff_approve  =  $rs1[countnm] ;  		
	}
################################################## ���˹�ҷ���ࢵ ���ࡳ��
?>
<?   ################################### ��  ���˹�ҷ���ࢵ ੾�� �֡�ҹ��ȹ� 
$sql1 = "  
SELECT  count(  position_now ) AS  countnm   FROM   general  
WHERE  
  ( general.position_now    LIKE  '%�֡�ҹ�%'    )
 and   siteid = $xsiteid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_eduadvice =  $rs1[countnm] ;  		
	}
	#################################################### ���˹�ҷ�� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$area_eduadvice_approve  =  $rs1[countnm] ;  		
	}
################################################## ���˹�ҷ���ࢵ ���ࡳ��
?>



 
<? 
@reset($arr_name) ; 
@reset($arr_name1) ; 
/*	
	$arrdb_scex    ####### ��.��.����ç
	$arrdb_scex_approve   ####### ��.��.����ç
	$arrdb_scvoice   ####### ��.��.����ç
	$arrdb_scvoice_approve   ####### ��.��.����ç
	$area_head   ####### ��. ʾ�.
	$area_head_approve   ####### ��. ʾ�.	 	
	$area_voicehead    ####### �ͧ. ��. ʾ�.	
	$area_voicehead_approve   ####### �ͧ. ��. ʾ�.	
	$area_eduadvice   ####### �֡�ҹ���
	$area_eduadvice_approve   #######  �֡�ҹ��� 
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
        <td colspan="4" align="center">�Ҿ�����úѹ�֡�������������к� ʾ�.
          <?=$rssecname?>        </td>
        </tr>
      <tr>
        <td width="62%">�ؤ�ҡ÷���������ͧ�ѹ�֡�������������к����˹ѧ�����觡��</td>
        <td width="16%" align="center" bgcolor="#99CC99" style="color:#000000"><?

	  echo number_format($alltarget)   ; 
	  ?></td>
        <td width="13%">&nbsp; </td>
        <td width="9%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" style="color:#000000">��</td>
        <td align="center">������</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>��Ǩ�ͺ����Ѻ�ͧ�����١��ͧ </td>
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
        <td colspan="4">��§ҹ � �ѹ���
          <?
$timenow2 = date("Y") ."-".   date("m")   ."-".  date("j")  ." ". date("H")  .":". date("i")  .":". date("s")  ; #2006-05-20 12:07:01 		  
$db_lastupdate =  		$timenow2 ;  
$month1 = array("", "���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
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
	echo $arr_date[2] ." ".  $month1[$arr_date[1]] ." ". $arr_date[0] ." ���� ". $arr_date[3] .":". $arr_date[4] .":". $arr_date[5] ." �ҷ�" 
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
    <td width="33%"><a href="list_person_sc.php?xsiteid=<?=$xsiteid?>">�ʴ���������´���˹��§ҹ</a></td>
    <td width="46%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
</table>
<br />
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr bgcolor="#99CC99" class="strong_black"   align="center"  >
    <td rowspan="2"  >�ؤ��ҡ÷���ͧ�ѹ�֡�����ŷ����� ���˹ѧ����Ţ��� ȸ.0206.6/1158 ��.24 �.�. 2550 <br />
    <br /></td>
    <td>����������ͧ�ѹ�֡�������������к����˹ѧ�����觡�� </td>
    <td>���������ҧ�ѹ�֡������ </td>
    <td colspan="2">��Ǩ�ͺ����Ѻ�ͧ�����١��ͧ�ͧ������ ����͡��� ��.7 ����</td>
  </tr>
  <tr bgcolor="#99CC99" class="strong_black"  align="center"  >
    <td>��</td>
    <td>��</td>
    <td>��</td>
    <td>������</td>
  </tr>
  <tr>
    <td bgcolor="EFEFEF"> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=1&xcol=2" target="_blank">��.ʾ�.</a></td>
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
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=2" target="_blank">�ͧ ��.ʾ�.</a></td>
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
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=3" target="_blank">�֡�ҹ��ȹ�</a></td>
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
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=4" target="_blank">�ؤ��ҡ÷ҧ����֡����蹵���ҵ�� 38 �.(2)</a></td>
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
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=5" target="_blank">����ӹ�¡���ç���¹</a></td>
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
    <td> - <a href="list_person_summarydetail.php?xsiteid=<?=$xsiteid?>&xtype=6" target="_blank">�ͧ����ӹ�¡���ç���¹ </a></td>
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
    <td bgcolor="#99CC99">���</td>
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
#  ALTER TABLE `allschool` ADD `voice_exe` INT NOT NULL DEFAULT '2' COMMENT '�ͧ/������ ��.'; 
/*
	$area_head   ####### ��. ʾ�.
	$area_head_approve   ####### ��. ʾ�.	 	
	$area_voicehead    ####### �ͧ. ��. ʾ�.	
	$area_voicehead_approve   ####### �ͧ. ��. ʾ�.

	$arrdb_scex    ####### ��.��.����ç
	$arrdb_scex_approve   ####### ��.��.����ç
	$arrdb_scvoice   ####### ��.��.����ç
	$arrdb_scvoice_approve   ####### ��.��.����ç
	
	$area_eduadvice   ####### �֡�ҹ���
	$area_eduadvice_approve   #######  �֡�ҹ��� 
*/

?>

</body>
</html>
