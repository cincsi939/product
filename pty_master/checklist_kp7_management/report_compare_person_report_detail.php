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
$tblgeneral = "general"; // ���ҧ��ѡ㹡�ä��Һؤ�ҡ�
$link_file = "percen_entry_v5sc_appv_detail.php";
$link_file1 = "percen_entry_v5sc_appv.php";

$edubkk_master = DB_MASTER ; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = "cmss_". $xxsiteid ; 
$db_site = "cmss_$xsiteid";
//$profile_id = 1;
$dbname_temp = DB_CHECKLIST;


include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("../common/class.loadpage.php");
include("../common/common_checklist.php");

$time_start = getmicrotime();



	
	$month = array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 
	$date_curent = intval(date("d"))." ".$month[intval(date("m"))]." ".(date("Y")+543);


## function �ʴ���ª����ç���¹�ࢵ���
function GetSchoolArr($xsiteid){
	global $dbnamemaster;
	$sql = "SELECT * FROM allschool WHERE siteid='$xsiteid' ";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[id]] = $rs[prefix_name].$rs[office];	
	}//end while($rs = mysql_fetch_assoc($result)){
		
	return $arr;
}//end function GetSchoolArr($xsiteid){






	$sql = "SELECT secid,secname,if(substring(secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite FROM eduarea WHERE secid LIKE '$xsiteid%'";	
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$secname = $rs[secname];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<link href="../application/hr3/hr_report/images/style.css" type="text/css" rel="stylesheet">
<SCRIPT SRC="sorttable_1.js"></SCRIPT>
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
<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>
<link href="../application/hr3/hr_report/libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../application/hr3/hr_report/libary/tabber.js"></script>
<link href="../common/cssfixtable.css" rel="stylesheet" type="text/css">
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
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
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 1 });
        });
</SCRIPT>

</head>
<body>
<?
include("../common/page_loading/page_loading.php");
CreatePageLoader('circle','14',"���ѧ��Ŵ������...",'14');


	if($xtype == "1"){
			$xtitle = "��ª��ͺؤ�ҡ÷�����(��)";
			$conw  = " WHERE siteid='$xsiteid'";
	}else if($xtype == "2"){
			$xtitle = "��ª��ͺؤ�ҡ÷���ҹ��èѴ�Ӣ����Ż������(��)";
			$conw  = " WHERE siteid='$xsiteid' AND (ustatus='1' OR ustatus='2')";
	}else if($xtype == "3"){
			$xtitle = "��ª��ͺؤ�ҡ÷������ҹ��èѴ�Ӣ����Ż������(��)";
			$conw  = " WHERE siteid='$xsiteid' AND (ustatus='0')";
	}
?>


<table width="99%" border="0" align="center">
 <tr>
     <td>&nbsp;</td>
  </tr>
</table>
 <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000"><table cellspacing="1" cellpadding="3" width="100%" align="center" bgcolor="#F5F5F5" border="1"  id="table0" class="tbl3">

     <tr  bgcolor="#a3b2cc"  class="strong_black" align="center" onMouseOver="this.style.cursor='hand';" onMouseOut="this.style.cursor='point';">
       <td colspan="6" bgcolor="#CCCCCC" ><strong><?=$secname?>&nbsp;<?=$xtitle?></strong></td>
       </tr>
     <tr  bgcolor="#a3b2cc"  class="strong_black" align="center" onMouseOver="this.style.cursor='hand';" onMouseOut="this.style.cursor='point';">
       <td width="5%" bgcolor="#CCCCCC" >�ӴѺ</td>
       <td width="16%" bgcolor="#CCCCCC">�����Ţ�ѵû�ЪҪ�</td>
       <td width="19%" bgcolor="#CCCCCC">����-���ʡ��</td>
       <td width="25%" bgcolor="#CCCCCC">���˹�</td>
       <td width="29%" bgcolor="#CCCCCC">�ѧ�Ѵ˹��§ҹ</td>
       <td width="6%" bgcolor="#CCCCCC">�.�.7</td>
     </tr>
     <?


$sql = "SELECT CZ_ID as idcard,siteid,prename_th,name_th,surname_th,schoolname,position_now FROM view_general $conw ORDER BY schoolname ASC,name_th ASC,surname_th ASC";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while ($rs = mysql_fetch_assoc($result)){  
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	
	 
		$fname = "../../".PATH_KP7_FILE."/$rs[siteid]/".$rs[idcard].".pdf"  ;
	 if (is_file($fname)){ 
			$pdf_orig = " <a href='$fname' target='_blank'><img src='../images_sys/gnome-mime-application-pdf.png' title='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'  /></a> " ; 
		}else{
					$pdf_orig = "";
		}
		if($rs[idcard] != ""){
			$xpdf	= "<a href=\"../application/hr3/hr_report/kp7.php?id=".$rsv[idcard]."&sentsecid=".$rsv[siteid]."\" target=\"_blank\"><img src=\"../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\"   alt='�.�.7 ���ҧ���к� '  ></a>";
		}else{
			$xpdf = "";	
		}
		


?>

     <tr   bgcolor="<?=$bg?>"  align="center">
       <td ><?=$i?></td>
       <td align="center"><font color="<?=$fcolor?>"><? echo $rs[idcard]?></font></td>
       <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
       <td align="left"><? echo "$rs[position_now]";?></td>
       <td align="left"><? echo "$rs[schoolname]";  ?></td>
       <td align="center">&nbsp;<? echo $pdf_orig."&nbsp;".$xpdf;?></td>
     </tr>
<?

}//end while ($rs = mysql_fetch_assoc($result)){  
?>
 </table></td>
        </tr>
</table>

</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
