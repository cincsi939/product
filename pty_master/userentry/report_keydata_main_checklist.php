<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "competency_percenentry_byarea";
$module_code 		= "percenentry_byarea"; 
$process_id			= "percenentry_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		Rungsit
	## E-mail :			
	## Tel. :			
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		�к��ҹ�����źؤ�ҡ�
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

session_start() ; 
set_time_limit(0) ; 
if ( $_SESSION[siteid]   != ""){ 
	# $_SESSION[reportsecid]
} 
if ($xsiteid == ""){ $xsiteid = $_SESSION[siteid]  ;    $xxsiteid = $xsiteid  ; } 

if ($loginid != ""){   $xxsiteid = $loginid  ; } 
if ($_SESSION[reportsecid] == "cmss-otcsc" ){
	########### ok 
} ### END if ($_SESSION[reportsecid] == "cmss-otcsc" ){
//
/*echo "<pre>";
print_r($_SESSION);
*/
$link_file = "percen_entry_v5sc_appv_detail.php";
$link_file1 = "percen_entry_v5sc_appv.php";
if($xsiteid != ""){ $xsiteid = $xsiteid;}else{ $xsiteid = "5006";}; // �óշ��ͺ�����ͧ

$edubkk_master = "edubkk_master" ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include ("graph.inc.php");
$profile_id = 1; // fix profile
$date_conf = "2009-11-01";// fix ��

$time_start = getmicrotime();



	
	$month = array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 

$getdepid = $depid ;

############ �Ѻ�ӹǹ��õ��Ǩ�ͺ������� checklist 
function CountCheckListKp7(){
	global $profile_id;
		$dbname_temp = "edubkk_checklist";
		$sql = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid,
Count(idcard) AS NumAll,
Sum(if(status_check_file='YES',1,0)) AS NumDoc,
Sum(if(status_check_file='NO',1,0)) AS NumRemain,
Sum(if(status_check_file='YES' and status_file=1,1,0)) AS NumDocTrue,
Sum(if(status_check_file='YES' and status_file=0,1,0)) AS NumDocFalse,
Sum(if(page_upload > 0 and status_file=1,1,0)) AS NumUpload
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
WHERE  profile_id='$profile_id'
group by  ".DB_CHECKLIST.".tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['NumAll'] = $rs['NumAll'];
		$arr[$rs[siteid]]['NumDoc'] = $rs['NumDoc'];
		$arr[$rs[siteid]]['NumRemain'] = $rs['NumRemain'];
		$arr[$rs[siteid]]['NumDocTrue'] = $rs['NumDocTrue'];
		$arr[$rs[siteid]]['NumDocFalse'] = $rs['NumDocFalse'];
		$arr[$rs[siteid]]['NumUpload'] = $rs['NumUpload'];	
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end  function CountCheckList(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<title>��§ҹ�����š���׹�ѹ������ �ͧ ʾ�.</title>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>
<style type="text/css">
<!--
.style1 {

	text-decoration: underline;
	
}
-->
</style>
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<link href="../application/hr3/hr_report/libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../application/hr3/hr_report/libary/tabber.js"></script>
<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script language=JavaScript> 

function CheckIsIE() 
{ 
if (navigator.appName.toUpperCase() == 'MICROSOFT INTERNET EXPLORER') { return true;} 
else { return false; } 
} 


function PrintThisPage() 
{ 

if (CheckIsIE() == true) 
{ 
parent.iframe1.focus(); 
parent.iframe1.print(); 
} 
else 
{ 
window.frames['iframe1'].focus(); 
window.frames['iframe1'].print(); 
} 

} 

 
</script></head>
<body>
<table width="99%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td width="10%" align="center">&nbsp;</td>
         <td width="90%" align="right"><strong>
           ������ � �ѹ���
  <?=$DateNData?>
          </strong></td>
       </tr>
     </table></td>
   </tr>
</table>
      <table cellspacing="1" cellpadding="3" width="99%" align="center" bgcolor="#000000" border="0">
   <tbody>
     <tr>
       <td colspan="9" align="center" bgcolor="#A3B2CC" ><strong>��§ҹ�š�èѴ�Ӣ����Ż�����Ԣ���Ҫ��ä����кؤ�ҡ÷ҧ����֡����ѧ�Ѵ ʾ�.</strong></td>
     </tr>
     <tr >
       <td width="4%" rowspan="3" align="center" bgcolor="#A3B2CC" ><strong>�ӴѺ</strong></td>
       <td width="23%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>ʾ�.</strong></td>
       <td width="9%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>�ؤ�ҡ÷�����</strong></td>
       <td colspan="6" align="center" bgcolor="#A3B2CC"><strong>�����͡��� ��.7 �鹩�Ѻ (��)</strong></td>
     </tr>
     <tr >
       <td width="11%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>���Ѻ�͡���</strong></td>
       <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>��ҧ�Ѻ</strong></td>
       <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>��Ǩ�ͺ����</strong></td>
       <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>�͡�õ�Ǩ</strong></td>
       <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>upload ����</strong></td>
     </tr>
     <tr >
       <td width="11%" align="center" bgcolor="#A3B2CC"><strong>����ó�</strong></td>
       <td width="12%" align="center" bgcolor="#A3B2CC"><strong>�������ó�</strong></td>
     </tr>
		 <?
		 $arrsite = CountCheckListKp7();				 
		$sql = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND
eduarea_config.pdf_org =  '1' order by eduarea_config.orde_by DESC";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 	if($rs[pdf_sys] == 1){
				$num_personsys = 1;
			}else{
				$num_personsys = 0;	
			}
			
			####�����Ţͧ�����Ф���
		?>
     <tr bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="left"><? if($num_personsys > 0){echo "<a href='report_keydata_area.php?xsiteid=$rs[secid]&secname=$rs[secname]&sys=$rs[pdf_sys]&type=all' target='_blank'>".$rs[secname]."</a>&nbsp;<font color='green'><b>*</b></font>";}else{ echo $rs[secname];}?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumAll']?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumDoc']?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumRemain']?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumDocTrue']?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumDocFalse']?></td>
       <td align="center"><?
       $NumWait = $arrsite[$rs[secid]]['NumDoc']-$arrsite[$rs[secid]]['NumDocTrue']-$arrsite[$rs[secid]]['NumDocFalse'];
	   echo number_format($NumWait);
	   ?></td>
       <td align="center"><?=$arrsite[$rs[secid]]['NumUpload']?></td>
     </tr>
<?
		$sum1 += $arrsite[$rs[secid]]['NumAll'];
		$sum2 += $arrsite[$rs[secid]]['NumDoc'];
		$sum3 += $arrsite[$rs[secid]]['NumRemain'];
		$sum4 += $arrsite[$rs[secid]]['NumDocTrue'];
		$sum5 += $arrsite[$rs[secid]]['NumDocFalse'];
		$sum6 += $NumWait;
		$sum7 += $arrsite[$rs[secid]]['NumUpload'];
		}// end while($rs = mysql_fetch_assoc()){
?>
     <tr  bgcolor="#A3B2CC"  align="center"   class="strong_black">
       <td colspan="2"  ><strong>���</strong></td>
       <td align="center"><?=number_format($sum1);?></td>
       <td align="center"><?=number_format($sum2);?></td>
       <td align="center"><?=number_format($sum3);?></td>
       <td align="center"><?=number_format($sum4);?></td>
       <td align="center"><?=number_format($sum5);?></td>
       <td align="center"><?=number_format($sum6);?></td>
       <td align="center"><?=number_format($sum7);?></td>
     </tr>
   </tbody>
 </table>
&nbsp;&nbsp;&nbsp; �����˵� ����ͧ���� * ��ࢵ���ѹ�֡��������к�����
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
