<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
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
	## Modified Detail :		�к���Ǩ�ͺ�����ŷ���¹����ѵԵ鹩�Ѻ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();
if($_SESSION['session_username'] == ""){
	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
	header("Location: login.php");
	die;
}

set_time_limit(0);

function QueryDataList($xsiteid,$profile_id=""){
	global $dbname_temp;
	if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������
	$sql = "SELECT
if(edubkk_checklist.temp_order_school.orderby=0 or edubkk_checklist.temp_order_school.orderby='' or edubkk_checklist.temp_order_school.orderby is null,9999,edubkk_checklist.temp_order_school.orderby) as orderid,
 id,
allschool.siteid,office,
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ,1,0 )) as NumPass, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and  status_file='1' and status_id_false='0' ,1,0 )) as NumNoMain, 

Sum(if(status_numfile='1' and status_file='0' AND status_check_file='NO' and status_id_false='0' ,1,0)) AS NumDisC,
Sum(page_num) AS NumPage,
sum(if(status_numfile='1',1,0)) as NumQL, 
Sum(pic_num) AS NumPic,
Count(idcard) AS NumAll,
sum(if(status_id_false='1' and status_numfile='1',1,0)) as numidfalse,
sum(if(status_numfile='0',1,0)) as numnorecive
FROM
edubkk_checklist.tbl_checklist_kp7
inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
Left Join edubkk_checklist.temp_order_school ON edubkk_master.allschool.id = edubkk_checklist.temp_order_school.schoolid
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' AND profile_id='$profile_id'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.schoolid
ORDER BY
orderid  ASC";	
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$i++;
		### function ������˹��§ҹ���������㹡�����§�ӴѺ㹡�÷� index
		//SaveTempOrderSchool($rs[id],$rs[siteid],$i);
		## end ������˹��§ҹ���������㹡�����§�ӴѺ㹡�÷� index
		
		$arr[$rs[id]]['NumPass'] = $rs['NumPass'];
		$arr[$rs[id]]['NumNoPass'] = $rs['NumNoPass'];
		$arr[$rs[id]]['NumDisC'] = $rs['NumDisC'];
		$arr[$rs[id]]['NumPage'] = $rs['NumPage'];
		$arr[$rs[id]]['NumPic'] = $rs['NumPic'];
		$arr[$rs[id]]['NumAll'] = $rs['NumAll'];
		$arr[$rs[id]]['NumQL'] = $rs['NumQL'];
		$arr[$rs[id]]['NumNoMain'] = $rs['NumNoMain'];
		$arr[$rs[id]]['numidfalse'] = $rs['numidfalse'];
		$arr[$rs[id]]['numnorecive'] = $rs['numnorecive'];
		
			
	}//end while($rs = mysql_fetch_assoc($result)){
return $arr;
}//end function QueryDataList($xsiteid){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>���͡����� :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">���͡������</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<?
	
	
	$arr1 = show_val_exsum($lv,$xsiteid,$schoolid,$profile_id);
			$numall_all = $arr1['numall'];// �ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (�ѵ�Ҩ�ԧ)
			$numQL_all = $arr1['NumQL']; // ���Ѻ�͡��èҡࢵ��鹷�� (���)
			$numpage_all = $arr1['numpage'];//�ӹǹ��
			$numcheck_all =$arr1['numY1']+$arr1['NumNoMain']+$arr1['numY0']+$arr1['numidfalse']; // ��Ǩ�ͺ����
			$numY1_all = $arr1['numY1'];// ��Ǩ��������ó�
			$NumNoMain_all = $arr1['NumNoMain'];// �͡��âҴ��
			$numY0_all = $arr1['numY0']; // ��Ǩ�����������ó�
			$numidfalse_all = $arr1['numidfalse'];// ��Ǩ�����Ţ�ѵ��������ó�
			$numwait_all = $arr1['numN']; // ���������ҧ��Ǩ�ͺ
			$numsite = CountAreaProfile($profile_id); // �ӹǹࢵ��鹷�����֡����������

	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center">
<?  if  ($lv < 1 ){  
?> 
   
   <table width="650" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="5" align="center" bgcolor="#CAD5FF"><strong>��§ҹ�š�õ�Ǩ�ͺ�͡������� ��.7 �鹩�Ѻ <br>
             ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (
             <?=ShowProfile_name($profile_id);?>)</strong></td>
         </tr>
         <tr>
           <td width="57%" align="left" bgcolor="#FFFFFF"><strong>�ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (�ѵ�Ҩ�ԧ)</strong></td>
           <td width="17%" align="center" bgcolor="#FFFFFF"><strong>
             <? if($numall_all > 0){ echo "<a href='report_exsum_detail.php?xtype=all&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numall_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td width="6%" align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td width="9%" align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numsite);?>
           </strong></td>
           <td width="11%" align="center" bgcolor="#FFFFFF"><strong>ࢵ��鹷��</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>���Ѻ�͡��èҡࢵ��鹷�� (���)</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <? if($numQL_all > 0){ echo "<a href='report_exsum_detail.php?xtype=recive&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numQL_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numpage_all);?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>��Ǩ�ͺ����</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <? if($numcheck_all > 0){ echo "<a href='report_exsum_detail.php?xtype=check_person&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numcheck_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format(($numcheck_all*100)/$numall_all,2);?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>����ó�</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <? if($numY1_all > 0){ echo "<a href='report_exsum_detail.php?xtype=comp&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numY1_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format(($numY1_all*100)/$numall_all,2);?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"> <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; �Ҵ�͡��û�Сͺ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <? if($NumNoMain_all > 0){ echo "<a href='report_exsum_detail.php?xtype=nomain_page&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($NumNoMain_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format(($NumNoMain_all*100)/$numall_all,2)?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFF99">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;�Ţ�ѵ��������ó�</strong></td>
           <td align="center" bgcolor="#FFFF99"><strong>
             <? if($numidfalse_all > 0){ echo "<a href='report_exsum_detail.php?xtype=idfalse&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numidfalse_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFF99"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFF99"><strong>
             <?=number_format(($numidfalse_all*100)/$numall_all,2)?>
           </strong></td>
           <td align="center" bgcolor="#FFFF99"><strong>%</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�������ó�</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <? if($numY0_all > 0){ echo "<a href='report_exsum_detail.php?xtype=no_comp&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numY0_all)."</a>";}else{ echo "0";}?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format(($numY0_all*100)/$numall_all,2);?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong> ���������ҧ��õ�Ǩ�ͺ</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <? if($numwait_all > 0){ echo "<a href='report_exsum_detail.php?xtype=check_wait&sentsecid=$xsiteid&profile_id=$profile_id&lv=' target='_blank'>".number_format($numwait_all)."</a>";}else{ echo "0";}?>
             </strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>��</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format(($numwait_all*100)/$numall_all,2)?>
           </strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>%</strong></td>
         </tr>
         </table></td>
     </tr>
   </table>
<? }elseif  ($lv == 1 ){   ?>    
  <? 
  $sql2 = " SELECT time_update FROM tbl_checklist_kp7 where  time_update is not null AND profile_id='$profile_id'  ORDER BY  time_update ASC  LIMIT 1 ";
  $result2 = mysql_db_query($dbname_temp , $sql2 ) ;
  $xrs = mysql_fetch_assoc($result2) ; 
  $thtimemin =get_dateThai($xrs[time_update], 1 ) ; 
  
  $sql2 = " SELECT time_update FROM tbl_checklist_kp7 where  time_update is not null AND profile_id='$profile_id'  ORDER BY  time_update DESC  LIMIT 1 ";
  $result2 = mysql_db_query($dbname_temp , $sql2 ) ;
  $xrs = mysql_fetch_assoc($result2) ; 
  echo mysql_error() ; 
  echo " <br><br>   $timemax    ";
  $thtimemax =get_dateThai($xrs[time_update], 1 ) ; 
  ?>
     <table width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">
           <tr>
             <td colspan="7" align="center" bgcolor="#CAD5FF"><strong>��§ҹ�š�õ�Ǩ�ͺ�͡������� ��.7 �鹩�Ѻ <br>
����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (
    <?=ShowProfile_name($profile_id);?>
    )<br>
    <? show_area($xsiteid) ?></strong></td>
           </tr>
           <tr>
             <td colspan="5" align="left" bgcolor="#CAD5FF"><strong>��Ҿ�鹷����Թ��õ�����ѹ���  
               <?=$thtimemin?> 
               �֧�ѹ���  
               <?=$thtimemax?>
             </strong></td>
             <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ�͡���<br>
               �ʡ����ç</strong></td>
             </tr>
           <? if($arr1['PageNoMath'] > 0){ $xbg = "#FF0000";}else{ $xbg = "#FFFFFF";}?>
           <tr>
             <td width="37%" align="left" bgcolor="#FFFFFF"><strong>�ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (�ѵ�Ҩ�ԧ)</strong></td>
             <td width="11%" align="center" bgcolor="#EEEEEE"><strong>
               <? if($numall_all > 0){ echo "<a href='report_exsum_detail.php?xtype=all&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numall_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td width="12%" align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td width="11%" align="center" bgcolor="#EEEEEE"><strong>
               <?=CountSchool($xsiteid);?>
             </strong></td>
             <td width="11%" align="center" bgcolor="#FFFFFF"><strong>�ç���¹</strong></td>
             <td width="9%" bgcolor="<?=$xbg?>" align="center"><strong><? if($arr1['PageNoMath'] > 0){ echo "<a href='report_page_no_math.php?sentsecid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($arr1['PageNoMath'])."</a>";}else{ echo "0";}?></strong></td>
             <td width="9%" bgcolor="<?=$xbg?>"><strong>��</strong></td>
             </tr>
           <tr>
             <td height="22" align="left" bgcolor="#FFFFFF"><strong>���Ѻ�͡��èҡࢵ��鹷�� (���)</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($numQL_all > 0){ echo "<a href='report_exsum_detail.php?xtype=recive&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numQL_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? echo number_format($numpage_all);?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td colspan="2" rowspan="5" bgcolor="#FFFFFF">&nbsp;</td>
             </tr>
           <tr>
             <td height="22" align="left" bgcolor="#FFFFFF"><strong>��Ǩ�ͺ����</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($numcheck_all > 0){ echo "<a href='report_exsum_detail.php?xtype=check_person&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numcheck_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <?=number_format(($numcheck_all*100)/$numall_all,2);?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>����ó�</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($numY1_all > 0){ echo "<a href='report_exsum_detail.php?xtype=comp&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numY1_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <?=number_format(($numY1_all*100)/$numall_all,2);?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; �Ҵ�͡��û�Сͺ</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($NumNoMain_all > 0){ echo "<a href='report_exsum_detail.php?xtype=nomain_page&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($NumNoMain_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <?=number_format(($NumNoMain_all*100)/$numall_all,2)?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFF99"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�Ţ�ѵ��������ó�</strong></td>
             <td align="center" bgcolor="#FFFF99"><strong>
               <? if($numidfalse_all > 0){ echo "<a href='report_exsum_detail.php?xtype=idfalse&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numidfalse_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFF99"><strong>��</strong></td>
             <td align="center" bgcolor="#FFFF99"><strong>
               <?=number_format(($numidfalse_all*100)/$numall_all,2)?>
             </strong></td>
             <td align="center" bgcolor="#FFFF99"><strong>%</strong></td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�������ó�</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($numY0_all > 0){ echo "<a href='report_exsum_detail.php?xtype=no_comp&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numY0_all)."</a>";}else{ echo "0";}?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <?=number_format(($numY0_all*100)/$numall_all,2);?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
             <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>������ѧ�Ѵ</strong></td>
             </tr>
                          <?
             	$sql_school_num = "SELECT count(schoolid) as num_school FROM tbl_checklist_kp7 WHERE  (siteid = '$xsiteid') and (schoolid='0' or schoolid IS NULL or schoolid ='') ";
				$result_school_num = mysql_db_query($dbname_temp,$sql_school_num);
				$rs_school_num = mysql_fetch_assoc($result_school_num);
				$NoSchool = $rs_school_num[num_school];
				if($NoSchool > 0){
						$bg1 = "#FF0000";
				}else{
						$bg1 = "#FFFFFF";	
				}
			 ?>
           <tr>
             <td align="left" bgcolor="#FFFFFF"><strong>���������ҧ��õ�Ǩ�ͺ</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <? if($numwait_all > 0){ echo "<a href='report_exsum_detail.php?xtype=check_wait&sentsecid=$xsiteid&profile_id=$profile_id&lv=1' target='_blank'>".number_format($numwait_all)."</a>";}else{ echo "0";}?>
            </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>��</strong></td>
             <td align="center" bgcolor="#EEEEEE"><strong>
               <?=number_format(($numwait_all*100)/$numall_all,2)?>
             </strong></td>
             <td align="center" bgcolor="#FFFFFF"><strong>%</strong></td>
             <td colspan="2" align="center" bgcolor="<?=$bg1?>">
               <? if($NoSchool > 0){ echo "<a href='report_page_no_math.php?action=NOSCHOOL&xsiteid=$xsiteid&sentsecid=$xsiteid&profile_id=$profile_id' target='_blank'>".number_format($NoSchool)."</a>";}else{ echo "0";}?>
             </td>
             </tr>

          </table></td>
       </tr>
     </table><br>

<? } ######### END   }else{ if  ($lv == 1 ){   ?>    	 
	 <br>
</td>
 </tr>
 <tr>
    <td align="right"><strong>��§ҹ � �ѹ��� 
    <?=thai_date(date("Y-m-d"));?>&nbsp;&nbsp;&nbsp;</strong></td>
  </tr>
   <tr>
    <td align="left">&nbsp;<strong><? if($lv == 1){ echo "<a href='?lv=&profile_id=$profile_id'>�ʴ��������Ҿ���</a> :: ".show_area($xsiteid);}?></strong></td>
  </tr>
  <? if($lv == ""){ $xtitle = "�ӹѡ�ҹࢵ��鹷�����֡��"; $xcolh = "10"; $xcolf = "2";}else{ $xtitle = "˹��§ҹ"; $xcolh = "11"; $xcolf = "3";}
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr>
        <th width="3%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>�ӴѺ</strong><br>
          <?  if($lv == "1"){if(CheckLockArea($xsiteid,$profile_id) > 0){ echo "<em>Lock</em>"; }else{?><input type="button" name="btnA" value="����������" onClick="location.href='form_manage_checklist.php?action=ADD&sentsecid=<?=$xsiteid?>&extra=1&profile_id=<?=$profile_id?>'" style="cursor:hand"><? }  } //end //end <? if(CheckLockArea($sentsecid) > 0){ ?></th>
        <? if($lv == "1"){?>
        <th width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>����<br>
          ˹��§ҹ</strong></th>
        <? } //end ?>
        <th width="21%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong><?=$xtitle?></strong></th>
        <th width="6%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong></strong>�ѵ�Ҩ�ԧ<br>
          ���(��)</th>
        <th width="7%" rowspan="2" align="center" bgcolor="#A8B9FF">
          <p>���Ѻ<br>
            �͡���<br>
            (��)</p></th>
        <th width="7%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>��ҧ�Ѻ<br>
          (��)</strong></th>
        <td colspan="5" align="center" bgcolor="#A8B9FF"><strong>�š�õ�Ǩ�ͺ�͡���</strong>&nbsp;<a href="report_scan.php?lv=<?=$lv?>&profile_id=<?=$profile_id?>"><img src="../../images_sys/gnome-fs-regular.png" width="25" height="25" border="0" title="��¡�üš���᡹�͡���"></a></td>
        <th width="5%" rowspan="2" align="center" bgcolor="#A8B9FF">�ӹǹ<br>
          (��)</th>
        <th width="5%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong><br>
          �ٻ</strong></th>
      </tr>
      <tr>
        <th width="8%" align="center" bgcolor="#A8B9FF"><strong>���������ҧ<br>
          ��Ǩ�ͺ</strong></th>
        <th width="7%" align="center" bgcolor="#A8B9FF"><strong>����ó�</strong></th>
        <th width="9%" align="center" bgcolor="#A8B9FF">�Ţ�ѵ�<br>
          �������ó�</th>
        <th width="8%" align="center" bgcolor="#A8B9FF">�Ҵ�͡���<br>
          ��Сͺ</th>
        <th width="9%" align="center" bgcolor="#A8B9FF"><strong>�����<br>
          ��ó�</strong></th>
      </tr> 
	</thead>    
	<tbody>   
		<?
		

		
		
		if($lv == ""){// ���������ࢵ
			//$sql = "SELECT * FROM eduarea WHERE status_area53 ='1' order by secname ASC";
			$sql = "SELECT eduarea.secid, eduarea.name_proth, eduarea.office_ref, eduarea.secname, eduarea.provid, eduarea.partid, eduarea.siteid,
eduarea.status,
eduarea.msg,
eduarea.area_id,
eduarea.beunderid,
eduarea.area_under,
eduarea.staff_gain,
eduarea.staff_empty,
eduarea.import_pobec,
eduarea.config_area,
eduarea.full_area,
eduarea.no_import_pobec,
eduarea.status_area53,
substring(eduarea.secid,1,2) as subid
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' 
order by subid, eduarea.secname  ASC
";
			$result = mysql_db_query($dbnamemaster,$sql);
			  $arrN = CountCheckListKp7V1($profile_id);
			//$rs = mysql_fetch_assoc($result);
		}else if($lv == "1"){ // ����������ç
				//$sql = "SELECT CAST(id as SIGNED) as id, siteid,office FROM allschool WHERE siteid='$xsiteid' order by id ASC, office ASC";
				//$result = mysql_db_query($dbnamemaster,$sql);
				##CAST(id as SIGNED) as id, 
	# update temp_order school ���ࢵ��鹷�����֡��������ҧ���ش
	$sql_uptemp =  "UPDATE temp_order_school SET orderby='0' WHERE schoolid='$xsiteid'";
	mysql_db_query($dbname_temp,$sql_uptemp);
	
	$arrnum = array();
	$arrnum = QueryDataList($xsiteid,$profile_id); // �����Ũӹǹ�ͧ�����ç���¹
$sql = "SELECT
if(edubkk_checklist.temp_order_school.orderby IS NULL,9999,orderby) as orderby1,
edubkk_master.allschool.id,
edubkk_master.allschool.office,
edubkk_master.allschool.siteid
FROM
edubkk_master.allschool 
left Join edubkk_checklist.temp_order_school ON edubkk_master.allschool.id = edubkk_checklist.temp_order_school.schoolid
WHERE
edubkk_master.allschool.siteid=  '$xsiteid' and edubkk_master.allschool.activate_status=  'open'
ORDER BY
orderby1 ASC";

//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
				
		}//end if($lv == ""){
		$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
		
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			  if($lv == ""){
				  $temp_dis = CheckLockArea($rs[secid],$profile_id);
				
				  $id_org = "$rs[secid]";
				  	 $sxsiteid = $rs[secid];
				  
				  $count_impP = $arrN[$id_org]['NumAll'];// �ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (�ѵ�Ҩ�ԧ)
				  $count_QL =$arrN[$id_org]['NumQL']; // ���Ѻ�͡��èҡࢵ��鹷�� (���)
				  $count_norecive = $arrN[$id_org]['numnorecive'];// ��ҧ�Ѻ (��)
				  $count_n = $arrN[$id_org]['NumDisC'];// ���������ҧ��Ǩ�ͺ
				  $count_y = $arrN[$id_org]['NumPass'];// ��Ǩ�ͺ��ҹ
				  $count_idfalse = $arrN[$id_org]['numidfalse'];// ��Ǩ�����Ţ�ѵ��������ó�
				  $count_pagemain =$arrN[$id_org]['NumNoMain']; // ����ջ�
				  $count_yn = $arrN[$id_org]['NumNoPass'];// ��Ǩ�ͺ��������ҹ
				  $numpage = $arrN[$id_org]['NumPage']; //  �ӹǹ��
				  $numpic = $arrN[$id_org]['NumPic']; // �ӹǹ�ٻ
				   
				  $getlink = "?action=&lv=1&xsiteid=$rs[secid]&schoolid=&profile_id=$profile_id";
				  $lint_yn = "report_problem.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id";
				  $lint_yn1 = "report_problem.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=mainpage";
				  $link_y = "report_noproblem.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id";
				  $link_all = "report_checklist_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=all";
				   $link_QL = "report_checklist_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=QL";
				    $link_norecive = "report_checklist_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=norecive";
					$link_cn = "report_checklist_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=countn";
					$link_idfalse = "report_checklist_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=idfalse";
				  if($temp_dis > 0){
					  	$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
				  }else{
					  	$xalink_sys = "";
				 }//end  if($temp_dis > 0){
					  if($count_impP > 0){
							$xalink = "<a href='$getlink'>".str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname])."</a> $xalink_sys";
							
					  }else{
							$xalink = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs[secname]);	
					  }
				  
			  
			  }else if($lv == "1"){
				  $id_org = "$rs[id]";
				 // echo "<pre>";
				  //print_r($arrnum);
				  	### function ������˹��§ҹ���������㹡�����§�ӴѺ㹡�÷� index
					 SaveTempOrderSchool($rs[id],$xsiteid,$i);
					 ### end function ������˹��§ҹ���������㹡�����§�ӴѺ㹡�÷� index
					 $sxsiteid = $rs[siteid];

				  $count_impP =$arrnum[$id_org]['NumAll']; //�ӹǹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� (�ѵ�Ҩ�ԧ)
				  $count_QL =$arrnum[$id_org]['NumQL']; // ���Ѻ�͡��èҡࢵ��鹷�� (���)
				  $count_norecive = $arrnum[$id_org]['numnorecive'];// ��ҧ�Ѻ (��)
				  $count_n = $arrnum[$id_org]['NumDisC'];// ���������ҧ��Ǩ�ͺ
				  $count_y = $arrnum[$id_org]['NumPass'];// ��Ǩ�ͺ��ҹ
				  $count_idfalse = $arrnum[$id_org]['numidfalse'];// ��Ǩ�����Ţ�ѵ��������ó�
				  $count_pagemain =$arrnum[$id_org]['NumNoMain']; // ����ջ�
				  $count_yn = $arrnum[$id_org]['NumNoPass'];// ��Ǩ�ͺ��������ҹ
				  $numpage = $arrnum[$id_org]['NumPage']; //  �ӹǹ��
				  $numpic = $arrnum[$id_org]['NumPic']; // �ӹǹ�ٻ
	
				  $getlink = "check_kp7_area.php?action=&lv=2&xsiteid=$rs[siteid]&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id";
				  $lint_yn = "report_problem.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id";
				  $lint_yn1 = "report_problem.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=mainpage";
				  $link_y = "report_noproblem.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id";
				  $link_all = "report_checklist_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=all";
				   $link_QL = "report_checklist_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=QL";
				   $link_norecive = "report_checklist_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=norecive";
				   $link_cn = "report_checklist_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=countn";
					$link_idfalse = "report_checklist_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=idfalse";
				  if(CheckLockArea($rs[siteid],$profile_id) > 0){
						$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
					}else{
						$xalink_sys = "";
					}
					  if($count_impP > 0){
							$xalink = "<a href='$getlink'>$rs[office]</a>$xalink_sys";
					  }else{
							$xalink = "$rs[office]";
					  }

			  }
			 ### �����͹䢡�� loc ࢵ

		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
		<? if($lv == "1"){?>
		<td align="center"><?=$id_org?></td>
		<? } //end ?>
        <td align="left"><?=$xalink?>&nbsp;&nbsp;<? if($lv != "1"){?><a href="index_excel_form.php?profile_id=<?=$profile_id?>&xsiteid=<?=$sxsiteid?>" target="_blank"><img src="../../images_sys/xls_logo.gif" width="16" height="16" border="0" title="�����������͡���͹������� excel"></a><? }//end if($lv == "1"){ ?></td>
        <td align="center"><? if($count_impP > 0){ echo "<a href='$link_all' target='_blank'>".number_format($count_impP)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count_QL > 0){ echo "<a href='$link_QL' target='_blank'>".number_format($count_QL)."</a>"; }else{ echo "0";}?></td>
        <td align="center"><? if($count_norecive > 0){ echo "<a href='$link_norecive' target='_blank'>".number_format($count_norecive)."</a>";}else{ echo "0"; }?></td>
        <td align="center"><? if($count_n > 0){ echo "<a href='$link_cn' target='_blank'>".number_format($count_n)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count_y > 0){ echo "<a href='$link_y' target='_blank'>".number_format($count_y)."</a>";}else{ echo "0";} ?></td>
        <td align="center"><? if($count_idfalse > 0){ echo "<a href='$link_idfalse' target='_blank'>".number_format($count_idfalse)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count_pagemain > 0){ echo "<a href='$lint_yn1' target='_blank'>".number_format($count_pagemain)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count_yn > 0){ echo "<a href='$lint_yn' target='_blank'>".number_format($count_yn)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($numpage);?></td>
        <td align="center"><?=number_format($numpic)?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_norecive_all += $count_norecive;
			$sum_pic_all += $numpic;
			$sum_imp_all += $count_impP;
			$sum_y_all += $count_y;
			$sum_n_all += $count_n;
			$sum_yn_all += $count_yn;
			$sum_ql_all += $count_QL;
			$sum_pagemain_all += $count_pagemain;
			$sum_idfalse_all += $count_idfalse;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
 <tfoot>
      <tr class="txthead">
        <td colspan="<?=$xcolf?>" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_imp_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_ql_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_norecive_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_n_all)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_y_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_idfalse_all)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pagemain_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_yn_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sum_page_all)?></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td>
     
        </tr>
 </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><em>�����˵� <font color="#FF0000">*</font> ���¶֧ࢵ����Ǩ�ͺ�ӹǹ�١��ͧ����</em></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', '', 'h','g', 'g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>