<?
# require_once("../../../common/preloading.php");
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

include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";

//include("timefunc.inc.php");

set_time_limit(3600);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

if ($xsiteid == "") { $xsiteid = $_SESSION[secid] ; } 
$masterdb = "cmss" ; 
$masterIP = "192.168.2.12";
#$masterIP = "127.0.0.1";
$nowIP =  $_SERVER[SERVER_ADDR] ; 
$nowIP = HOST;


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
if ($xsiteid == ""){ 
	echo " ��س��к� siteid "; die; 
} 	
?>
<?	  ################################################################# �ӹǹ �ؤ�ҡ÷���ͧ�ѹ�֡������
conn($masterIP) ; 
	  
	$sql1 = "  SELECT * FROM `allschool` WHERE `siteid` LIKE '$xsiteid'   order by office asc 	 "; 
#	 echo " $sql1  " ; 
	$result1= mysql_db_query($masterdb , $sql1); 
	$school_nm = mysql_num_rows($result1)  ; 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$depid = $rs1[id] ; 
		$arr_name[$depid]  =  $rs1[office] ;  	
		$arr_voiceexe[$depid]  =  $rs1[voice_exe] ;  
		$arr_schead[$depid]  =  $rs1[sc_head] ; 
	}  
 ################################################## ���˹�ҷ���ࢵ ���ࡳ��  
$sql1= " 
 SELECT
(area_head + area_voicehead ) AS areaexe_num  ,
(area_eduadvice + area_staff) AS  area_num 
FROM  area_staffref   WHERE   siteid =  '$xsiteid'
";
$result1= mysql_db_query($masterdb , $sql1); 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
while($rs1 = @mysql_fetch_assoc($result1)){	
	$area_num = $rs1[area_num] ; 
	$areaexe_num = $rs1[areaexe_num] ; 
}

?>
<?
conn($nowIP) ; 	

######################################################################### ��  ��. 
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
######################################################################### ��  ��. APPROVE ���� 
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
	 
######################################################################### ���ͧ ��. 
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
######################################################################### ��  �ͧ��. APPROVE ���� 
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
<? ##################################���� %��% ==> �� �� ��� �ͧ��. ʾ�.
	$sql1 = "  
#	SELECT   schoolid ,   count(  position_now ) AS  countnm    	FROM  general
#	where  siteid =  $xsiteid  and     position_now like  '�ͧ%'  
#	and position_now   like '%�ӹѡ�ҹࢵ��鹷�����֡��%' 	or position_now   like '%ʾ�%'
#	group by schoolid  

SELECT    count(  position_now ) AS  countnm  FROM   general  
WHERE  (
general.position_now LIKE  '%����ӹ�¡��%' OR  general.position_now LIKE  '%��%'   )
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
		$arrdb_areaexe  =  $rs1[countnm] ;  		
	}
	#################################################### ��.��� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$arrdb_areaexe_approve  =  $rs1[countnm] ;  		
	}
?>
<?   ################################### ��  ���˹�ҷ���ࢵ
$sql1 = "  
SELECT  count(  position_now ) AS  countnm   FROM   general  
WHERE  (
general.position_now not LIKE  '%����ӹ�¡��%' and   general.position_now not LIKE  '%��%'   )
 AND(
general.position_now not  LIKE  '%�ç���¹%' and general.position_now not LIKE  '%ʶҹ�֡��%'  )
 AND
( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 and   siteid = $xsiteid  
	" ; 
	$result1= mysql_db_query($hr_dbname , $sql1); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$arrdb_areastaff =  $rs1[countnm] ;  		
	}
	#################################################### ���˹�ҷ�� approve �� SQL ��ҹ�� �����ա���͹�
	$sql2 = $sql1 . "  and approve_status  = 'approve'       ";
		$result1= mysql_db_query($hr_dbname , $sql2); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;   } 
	while($rs1 = @mysql_fetch_assoc($result1)){	
		$arrdb_areastaff_approve  =  $rs1[countnm] ;  		
	}
################################################## ���˹�ҷ���ࢵ ���ࡳ��
	
?>



 
<? 
@reset($arr_name) ; 
@reset($arr_name1) ; 
?>
<?
$all_schead =  @array_sum($arr_schead) ; 
$alltarget = @array_sum($arr_voiceexe) +   $all_schead  + $areaexe_num +  $area_num ; 
 $allnow  = @array_sum($arrdb_scex_approve) +  @array_sum($arrdb_scvoice_approve) + $arrdb_areastaff_approve +  $arrdb_areaexe_approve  ; 


 
 $percennow = @(($allnow * 100)/  $alltarget)   ; 
 
#	  $alltarget = (@array_sum($arr_areaexenum)) + (@array_sum($arr_scnum))+(@array_sum($arr_exenum)) ;  
#	   $allnow  = (@array_sum($arrdb_areaexenum)) + (@array_sum($arrdb_exenm)) +(@array_sum($arrdb_scex)) ; 
#	   $percennow = @(($allnow * 100)/  $alltarget)   ; 
?>
<table width="808" border="0" align="center" cellpadding="0" cellspacing="0" style=" margin-top:10px; ">
  <tr>
    <td width="638" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2" style="color:#000000; font-size:12px; font-weight:bold">
      <tr>
        <td width="62%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
      </tr>
      <tr>
        <td>�ؤ�ҡ÷���������ͧ�ѹ�֡�������������к����˹ѧ�����觡�� (�»���ҳ)</td>
        <td align="center" bgcolor="#99CC99" style="color:#000000"><?

	  echo number_format($alltarget)   ; 
	  ?></td>
        <td>&nbsp; </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" style="color:#000000">��</td>
        <td align="center">������</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>��Ǩ�ͺ����Ѻ�ͧ�����١��ͧ</td>
        <td align="center" bgcolor="#FFCC99" style="color:#000000"><?
	  echo number_format($allnow) ; 
	  ?></td>
        <td align="center" bgcolor="#FFCC99">          <?   echo number_format($percennow,2) ; 
	  ?>        </td>
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
    <td width="170" rowspan="2" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="170" height="170"
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
    <td valign="top" style="padding:5px; font-size:14px; font-weight:bold"> 
	<iframe height="0" width="0"    src="list_person_scexcel.php?xsiteid=<?=$xsiteid?>"> </iframe>
	<a href="list_person_summary.php?xsiteid=<?=$xsiteid?>">��ػ��§ҹʶҹС�ù����</a></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="padding:5px"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="6" bgcolor="#C0C0C0"><strong>�ؤ�ҡ��ӹѡ�ҹࢵ��鹷��</strong></td>
        </tr>
      <tr  bgcolor="#99CC99"  align="center" class="strong_black"   >
        <td colspan="2" >�ӹǹ�ؤ��ҡ÷���ͧ�ѹ�֡������ (��)</td>
        <td colspan="2"  >�ӹǹ�ؤ��ҡ���к� �Ѩ�غѹ (��)</td>
        <td colspan="2"   >�ӹǹ �ؤ�ҡ� ����ҹ��� �Ѻ�ͧ������ </td>
      </tr>
      <tr   bgcolor="#99CC99" align="center" class="strong_black"   >
        <td>��./�ͧ ��.ʾ� </td>
        <td>���˹�ҷ�� ʾ�. </td>
        <td>��./�ͧ ��.ʾ� </td>
        <td>���˹�ҷ�� ʾ�. </td>
        <td>��./�ͧ ��.ʾ� </td>
        <td>���˹�ҷ�� ʾ�. </td>
      </tr>
      <tr align="center" bgcolor="#EFEFEF"  >
        <td><?=$areaexe_num?></td>
        <td><?=$area_num?></td>
        <td>
		<? 
		$areaexe_ing =$arrdb_areaexe - $arrdb_areaexe_approve ;   
		$areastaff_ing =$arrdb_areastaff - $arrdb_areastaff_approve ;   		
		?>		
		<?=$areaexe_ing?>
          </td>
        <td><?=$areastaff_ing?>
           </td>
        <td><?=$arrdb_areaexe_approve?></td>
        <td><?=$arrdb_areastaff_approve?></td>
      </tr>
     
    </table>
      <a href="../../../../competency__tmpxls/SCvoiceexecutive_<?=$xsiteid?>.xls" target="_blank">Download Excel ������� �ӹǹ�ؤ�ҡ÷���ͧ�ѹ�֡������� (�ӹǹ����ӹ�¡�� ��� �ͧ����ӹ�¡�� �����ç���¹)</a>
<?

conn($masterIP) ; 
?>	  
      <table width="100%" align="center" border="0" cellspacing="1" cellpadding="3" style="margin-top:5px; ">
      <tr bgcolor="#99CC99" align="right" style="font-weight:bold;">
        <td colspan="8" align="left" bgcolor="#C0C0C0" >�ؤ�ҡ�ʶҹ�֡��</td>
        </tr>	
      <tr   style="font-weight:bold;"     align="center"     bgcolor="#99CC99"     >
        <td width="5%" height="20" rowspan="2"  >�ӴѺ</td>
        <td width="35%" rowspan="2" bgcolor="#99CC99" >�ç���¹</td>
        <td colspan="2" >�ӹǹ�ؤ��ҡ÷���ͧ�ѹ�֡������ (��)</td>
        <td colspan="2" bgcolor="#99CC99">�ӹǹ�ؤ��ҡ���к� �Ѩ�غѹ (��)</td>
        <td colspan="2" bgcolor="#99CC99">�ӹǹ �ؤ�ҡ� ����ҹ��� �Ѻ�ͧ������ </td>
      </tr>
      
      <tr bgcolor="#99CC99"  style="font-weight:bold;"     align="center"            >
        <td width="10%" height="24" bgcolor="#99CC99" >����ӹ�¡��</td>
        <td width="10%" bgcolor="#99CC99" >�ͧ��. </td>
        <td >����ӹ�¡��</td>
        <td >�ͧ��. </td>
        <td >����ӹ�¡��</td>
        <td >�ͧ��. </td>
      </tr>
<?  if (	  $arrdb_scex[99] >0 or $arrdb_scvoice[99] >0  ) { ?> 
	  <? $bgcolor1= "EFEFEF" ; ?>
      <tr bgcolor="<?=$bgcolor1?>" align="center" onmouseover='mOvr(this,&quot;dbf2ae&quot;);' onmouseout='mOut(this,&quot;<?=$bgcolor1?>&quot;);'>
        <td height="18">1</td>
        <td align="left">����к�ʶҹ�֡��</td>
        <td align="right"  >-</td>
        <td align="right"   >-</td>
<?
$scex_ing  = $arrdb_scex[$depid] -  $arrdb_scex_approve[$depid]  ;  
echo  number_format($scex_ing ) ;  
$all_scexing += $scex_ing ; 
###############################
$scex_ing  = $arrdb_scex[99] -  $arrdb_scex_approve[99]  ;  $all_scexing += $scex_ing ; 

$scvoice_ing  = $arrdb_scvoice[99] - $arrdb_scvoice_approve[99] ;    $all_scvoiceing += $scvoice_ing ; 
?>		
        <td align="right"><?=number_format($scex_ing)?></td>
        <td align="right"><?=number_format($scvoice_ing)?></td>
        <td align="right"><?=number_format($arrdb_scex_approve[99])?></td>
        <td align="right"><?=number_format($arrdb_scvoice_approve[99])?></td>
      </tr>	  
<?
	$i=1 ; 
}else{
	$i=0 ; 
} #  if (	  $arrdb_scex[99] >0 or $arrdb_scvoice[99] >0  ) { ?> 	  
      <? 

 while (list ($depid, $depname) = each ($arr_name)) {
#    echo "$codeid, $name, $val  <br> "; 
$i++; 
if ($bgcolor1 == "EFEFEF"){  $bgcolor1 = "DDDDDD"  ; } else {$bgcolor1 = "EFEFEF" ;}
# if ($cal_nm <= $arr_numperson[$depid]){ 	$bgcolor1 = "FFFFCC";   }
# if ($i > 10 ) { exit ; } 
?>

      <tr bgcolor="<?=$bgcolor1?>" align="center" onmouseover='mOvr(this,&quot;dbf2ae&quot;);' onmouseout='mOut(this,&quot;<?=$bgcolor1?>&quot;);'>
        <td height="18"><?=$i?></td>
        <td align="left">  &nbsp;
       <? # $depid?>   &nbsp;    <?=$depname?> </td>
        <td align="right" bgcolor="<?=$bgcolor1?>"> <?=$arr_schead[$depid]?></td>
        <td align="right" bgcolor="<?=$bgcolor1?>"><?=$arr_voiceexe[$depid]?></td>
        <td align="right">  
<?
/*
if ($xsiteid==5002 ){  
	$xsc_head = $arrdb_scex[$depid] ; 
	$xsc_voice = $arrdb_scvoice[$depid] ; 
	$sqlup .= " UPDATE `allschool` SET `sc_head`='$xsc_head',`voice_exe`='$xsc_voice' WHERE (`id`='$depid') ; # $depname  \n   " ; 
		$xsc_head =9999 ; 
	$xsc_voice = 9999 ; 
#	$result = mysql_db_query($masterdb , $sqlup) ; 
#	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sqlup <br> ".mysql_error() ."<br>"  ;   } 
}  ######## 
*/
?>
<?
$scex_ing  = $arrdb_scex[$depid] -  $arrdb_scex_approve[$depid]  ;  $all_scexing += $scex_ing ; 

$scvoice_ing  = $arrdb_scvoice[$depid] - $arrdb_scvoice_approve[$depid] ;    $all_scvoiceing += $scvoice_ing ; 

?>		
          <?=number_format($scex_ing)?> 
          &nbsp; </td>
        <td align="right"><?=number_format($scvoice_ing)?></td>
        <td align="right"><?=number_format($arrdb_scex_approve[$depid])?></td>
        <td align="right"><?=number_format($arrdb_scvoice_approve[$depid])?></td>
      </tr>
      <?

} #########  while (list ($depid, $depname) = each ($arr_name)) {

?>
      <tr bgcolor="#99CC99" align="right" style="font-weight:bold;">
        <td colspan="2" align="center" >��� </td>
        <td align="center" ><?=$all_schead?></td>
        <td align="center" ><?=number_format(@array_sum($arr_voiceexe))?></td>
        <td align="center"   ><?=number_format($all_scexing)?></td>
        <td align="center"   ><?=number_format($all_scvoiceing)?></td>
        <td align="center"   ><?=number_format(@array_sum($arrdb_scex_approve))?></td>
        <td align="center"   ><?=number_format(@array_sum($arrdb_scvoice_approve))?></td>
      </tr>
    </table>
    <?
$scex_ing  = $arrdb_scex[$depid] -  $arrdb_scex_approve[$depid]  ;  
# echo  number_format($scex_ing ) ;  
$all_scexing += $scex_ing ; 
?></td>
  </tr>
</table>
<?
#echo "<pre>";
#echo " $sqlup ";
#echo "</pre>";
#  ALTER TABLE `allschool` ADD `voice_exe` INT NOT NULL DEFAULT '2' COMMENT '�ͧ/������ ��.'; 
# include("list_person_scexcel.php?xsiteid=$xsiteid");
?>

</body>
</html>
