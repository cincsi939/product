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
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
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
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
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
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
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
	
			$numall_all = $arr1['numall'];// จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)
			$numQL_all = $arr1['NumQL']; // ได้รับเอกสารจากเขตพื้นที่ (รวม)
			$numpage_all = $arr1['numpage'];//จำนวนแผ่น
			$numcheck_all =$arr1['numY1']+$arr1['NumNoMain']+$arr1['numY0']+$arr1['numidfalse']; // ตรวจสอบแล้ว
			$numY1_all = $arr1['numY1'];// ตรวจแล้วสมบูรณ์
			$NumNoMain_all = $arr1['NumNoMain'];// เอกสารขาดปก
			$numY0_all = $arr1['numY0']; // ตรวจแล้วไม่สมบูรณ์
			$numidfalse_all = $arr1['numidfalse'];// ตรวจแล้วเลขบัตรไม่สมบูรณ์
			$numwait_all = $arr1['numN']; // อยู่ระหว่างตรวจสอบ
			$numsite = CountAreaProfile($profile_id); // จำนวนเขตพื้นที่การศึกษาในโฟรไฟล์นั้น

	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>รายงานการตรวจสอบเอการต้นฉบับ <?=ShowProfile_name($profile_id);?></strong></td>
           </tr>
         <tr>
           <td width="55%" align="center" bgcolor="#CAD5FF"><strong>รายการ</strong></td>
           <td width="45%" align="center" bgcolor="#CAD5FF"><strong>จำนวน</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>จำนวนทั้งหมด</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numall_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>ได้รับเอกสาร</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numQL_all)?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>ตรวจสอบแล้ว</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numcheck_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numY1_all);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>ขาดเอกสารประกอบ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($NumNoMain_all);?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;เลขบัตรไม่สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numidfalse_all)?>
           </strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numY0_all)?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>อยู่ระหว่างการตรวจสอบ</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($numwait_all);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>จำนวนหน้าเอกสาร</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($arr1['numpage']);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>จำนวนรูป</strong></td>
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
   <td align="right"><strong>รายงาน ณ วันที่
       <?=thai_date(date("Y-m-d"));?>
    &nbsp;&nbsp;&nbsp;</strong></td>
 </tr>
 <tr>
    <td align="left"><strong><a href='main_report.php?lv=1&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'><?=show_area($xsiteid)?></a> ::</strong> <?=show_school($schoolid);?></td>
	</tr>
  
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#A8B9FF"><strong>รายงานการตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ  <?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#A8B9FF"><strong>เลขบัตรประจำตัวประชาชน</strong></td>
        <td width="10%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="14%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล </strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>สถานะการตรวจ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>จำนวนหน้าเอกสาร</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>จำนวนรูป</strong></td>
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
        <td colspan="5" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
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
