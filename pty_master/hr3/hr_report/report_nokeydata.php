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
	## Modified Detail :		ระบบฐานข้อมูลบุคลากร
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
$edubkk_master = "edubkk_master" ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("positionsql.inc_v2.php");
include ("graph.inc.php");
$date_conf = "2009-11-01";// fix ปี

$time_start = getmicrotime();



	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 


	function GetSchoolName($siteid){
			global $dbnamemaster;
			$sql = "SELECT id,office FROM allschool WHERE siteid='$siteid'";
			$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[id]] = $rs[office];
			}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}//end 	function GetSchoolName($siteid){

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<link href="../common/cssfixtable.css" rel="stylesheet" type="text/css">
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<title>รายงานข้อมูลการยืนยันข้อมูล ของ สพท.</title>
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

 
</script>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>

</head>
<body>
<table width="99%" border="0" align="center">
 <tr>
     <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td width="10%" align="center">&nbsp;</td>
         <td width="90%" align="right"><strong>
           ข้อมูล ณ วันที่
  <?=$DateNData?>
          </strong></td>
       </tr>
     </table></td>
   </tr>
</table>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#F5F5F5"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="6" align="left" bgcolor="#CCCCCC"><strong>รายชื่อข้าราชการครูและบุคลากรทางการศึกษาที่ยังไม่ได้บันทึกข้อมูล<?=$secname?>
        </strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="37%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <? 	  
	 if($schoolid != ""){
			 $conv = " AND t1.schoolid='$schoolid'";
	}else{
			$conv = "";			
	}


 $arrschool = GetSchoolName($xsiteid);
$sql1 = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid,
CAST(t1.schoolid as SIGNED) as orderbyschoolid

FROM
".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Left Join ".DB_USERENTRY.".view_kp7approve as t2 ON t1.idcard = t2.idcard and t1.siteid=t2.siteid and t1.profile_id=t2.profile_id

Left Join ".DB_MASTER.".hr_addposition_now as t3 ON t1.position_now = t3.position
WHERE ((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
		(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) and t1.page_upload>0
		and t1.profile_id =  '$profile_id'  and t1.siteid='$xsiteid' and t2.idcard IS NULL  $conv
GROUP BY t1.idcard
order by orderbyschoolid,t3.orderby asc";
//echo $sql1;
$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."<hr>$sql1</hr><br>".__LINE__);
$i=0;
$prefix_url = "http://".HOST_FILE;
while($rss = mysql_fetch_assoc($result1)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	 $urlpath = "../../edubkk_kp7file/$rss[siteid]/" . $rss[idcard] . ".pdf"  ;
	 $xlinkfile = $prefix_url."/edubkk_kp7file/$rss[siteid]/" . $rss[idcard] . ".pdf"  ;
	 if(is_file($urlpath)){
			$pdf= " <a href=\"$xlinkfile\" target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a> " ;  
	}else{
			$sql_pdf = "SELECT CZ_ID AS idcard,siteid FROM  view_general WHERE CZ_ID='$rss[idcard]'  ";
			$result_pdf = mysql_db_query($dbnamemaster,$sql_pdf);
			$rspdf = mysql_fetch_assoc($result_pdf);
			$fname1 = "../../edubkk_kp7file/$rspdf[siteid]/".$rss[idcard].".pdf"  ;
			if(is_file($fname1)){
				$sql_area = "SELECT secname FROM eduarea WHERE secid='$rspdf[siteid]'";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				$rsaa = mysql_fetch_assoc($result_area);
				$pdf = " <a href='$fname1' target='_blank'><img src='../images_sys/gpdf_tranfer.png' title='ก.พ.7 สำเนาจากต้นฉบับที่ย้ายไป ".$rsaa[secname]."' width='16' height='16' border='0'  /></a> " ; 
			}else{
				$pdf = "";	
			}
	}
		$pdf_sys= "<a href=\"$prefix_url/edubkk_master/application/hr3/hr_report/kp7_search.php?id=".$rss[idcard]."&sentsecid=".$rss[siteid]."&tmpuser=$tmpuser&tmppass=$tmppass\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='ก.พ.7 สร้างโดยระบบ' ></a>";

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rss[idcard]?></td>
        <td align="left"><? echo "$rss[prename_th]$rss[name_th]  $rss[surname_th]";?></td>
        <td align="left"><?	echo $rss[position_now]?></td>
        <td align="left"><?
			if($rss[schoolid] != $xsiteid){
					echo "โรงเรียน".$arrschool[$rss[schoolid]];
			}else{
				echo $arrschool[$rss[schoolid]];
			}
			
		?></td>
        <td align="center"><? echo $pdf."&nbsp;".$pdf_sys; ?></td>
      </tr>
   <?
}// end while($rss = mysql_fetch_assoc($result1)){
   ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
