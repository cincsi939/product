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

include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
$time_start = getmicrotime();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

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
   <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>��§ҹ��õ�Ǩ�ͺ�͡�õ鹩�Ѻ <?=ShowProfile_name($profile_id);?></strong></td>
           </tr>
         <tr>
           <td width="55%" align="center" bgcolor="#CAD5FF"><strong>��¡��</strong></td>
           <td width="45%" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ������</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numall_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>���Ѻ�͡���</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numQL_all)?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>��Ǩ�ͺ����</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numcheck_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>����ó�</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numY1_all);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>�Ҵ�͡��û�Сͺ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($NumNoMain_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;�Ţ�ѵ��������ó�</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numidfalse_all)?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�������ó�</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numY0_all)?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>���������ҧ��õ�Ǩ�ͺ</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($numwait_all);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>�ӹǹ˹���͡���</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($arr1['numpage']);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>�ӹǹ�ٻ</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($arr1['numpic']);?>
           </strong></td>
           </tr>
       </table></td>
     </tr>
   </table>
    <br></td>
 </tr>
 <tr>
   <td align="right"><strong>��§ҹ � �ѹ���
       <?=thai_date(date("Y-m-d"));?>
    &nbsp;&nbsp;&nbsp;</strong></td>
 </tr>
 <tr>
    <td align="left"><strong><a href='main_report.php?lv=1&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'><?=show_area($xsiteid)?></a> ::</strong> <?=show_school($schoolid);?></td>
	</tr>
  
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#A8B9FF"><strong>��§ҹ��õ�Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ  <?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A8B9FF"><strong>�ӴѺ</strong></td>
        <td width="15%" align="center" bgcolor="#A8B9FF"><strong>�Ţ�ѵû�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="10%" align="center" bgcolor="#A8B9FF"><strong>�ӹ�˹�Ҫ���</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>����</strong></td>
        <td width="14%" align="center" bgcolor="#A8B9FF"><strong>���ʡ�� </strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>���˹�</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>ʶҹС�õ�Ǩ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ˹���͡���</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ�ٻ</strong></td>
        </tr>
      
		<?
			$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND schoolid='$schoolid' AND profile_id='$profile_id' ORDER BY name_th ASC";		
			//echo $sql;
			$result = mysql_db_query($dbname_temp,$sql);	 
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numpage = $rs[page_num];
			$numpic = $rs[pic_num];
			
						if($rs[general_status] == "1" and $rs[graduate_status] == "1" and $rs[salary_status] == "1"  and $rs[seminar_status] == "1" and $rs[sheet_status] == "1" and $rs[getroyal_status] == "1" and $rs[special_status] == "1" and  $rs[goodman_status] == "1" and $rs[absent_status] == "1" and $rs[nosalary_status] == "1" and $rs[prohibit_status] == "1" and $rs[specialduty_status] == "1" and $rs[other_status] == "1"){
					$file_complate = "1";
			}else if($rs[general_status] == "0" or $rs[graduate_status] == "0" or $rs[salary_status] == "0"  or $rs[seminar_status] == "0" or $rs[sheet_status] == "0" or $rs[getroyal_status] == "0" or $rs[special_status] == "0" or $rs[goodman_status] == "0" or $rs[absent_status] == "0" or $rs[nosalary_status] == "0" or $rs[prohibit_status] == "0" or $rs[specialduty_status] == "0" or $rs[other_status] == "0"){
				$file_complate = "0";
			}else{
					$file_complate = "";
			}
			

			
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th] ?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><?=show_icon_check($rs[status_file],$rs[status_check_file],$rs[status_numfile],$file_complate);?></td>
        <td align="center"><?=number_format($numpage)?></td>
        <td align="center"><?=number_format($numpic)?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_pic_all += $numpic;
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>

      <tr bgcolor="">
        <td colspan="5" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_page_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
