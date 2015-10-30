<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report_pobec"; 
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


include("../../common/common_competency.inc.php");
include("checklist.inc.php");
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
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <? if($action == ""){?>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="5%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="59%" align="center" bgcolor="#CAD5FF"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="36%" align="center" bgcolor="#CAD5FF"><strong>จำนวนทั้งหมดใน pobec </strong></td>
        </tr>
	  <?
	  $sql_main = "SELECT * FROM eduarea where status_area53='1' order by secname ASC";
	  $result_main = mysql_db_query($dbnamemaster,$sql_main);
	  $num_total = 0;
	  while($rs = mysql_fetch_assoc($result_main)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		$num_per = count_person_pobec($rs[secid]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center">
		<? if($num_per > 0){ echo "<a href='?action=view&sentsecid=$rs[secid]' target='_blank'>".number_format($num_per)."</a>"; }else{ echo "-";}?></td>
        </tr>
		<?
			$num_total += $num_per;
				}//end  while(){
	    ?>
      <tr>
        <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($num_total)?></strong></td>
      </tr>	  
    </table></td>
  </tr>
<? } //end if($action == ""){
	if($action == "view"){
	$tbl_pobec = "pobec_".$sentsecid;
?>
  <tr>
    <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="9" align="left" bgcolor="#CAD5FF"><strong><?=show_area($sentsecid);?></strong></td>
            </tr>
          <tr>
            <td width="4%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
            <td width="9%" align="center" bgcolor="#CAD5FF"><strong>คำนำหน้าชื่อ</strong></td>
            <td width="12%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ</strong></td>
            <td width="11%" align="center" bgcolor="#CAD5FF"><strong>นามสกุล</strong></td>
            <td width="11%" align="center" bgcolor="#CAD5FF"><strong>วัน เดือน ปี เกิด</strong></td>
            <td width="13%" align="center" bgcolor="#CAD5FF"><strong>เลขบัตรประชาชน </strong></td>
            <td width="13%" align="center" bgcolor="#CAD5FF"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
            <td width="13%" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่งล่าสุด</strong></td>
            <td width="14%" align="center" bgcolor="#CAD5FF"><strong>สถานศึกษา/หน่วยงาน</strong></td>
          </tr>
		  <?
		  	$sql = "select * from $tbl_pobec WHERE IDCODE <> '' AND IDCODE IS NOT NULL ORDER BY I_CODE ASC";
			$result = mysql_db_query($dbtemp_pobec,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
		if($rs[DATE_B] != "0000-00-00 00:00:00" and $rs[DATE_B] != ""){
			$arr_b = explode(" ",$rs[DATE_B]);
			$arr_b1 = explode("-",$arr_b[0]);
			if($arr_b1[0] < 2000){// ตรวจสอบกรณีวันเดือนปีเกิดผิดปกติ
				//$check_birthday = ($arr_b1[0]+543)."-".$arr_b1[1]."-".$arr_b1[2];
				$check_birthday = $arr_b1[2]."-".$arr_b1[1]."-".($arr_b1[0]+543);
			}else{
				$check_birthday = "";
			}
		}else{
				$check_birthday = "";
		}//end 	if($rs[DATE_B] != "0000-00-00 00:00:00" and $rs[DATE_B] != ""){
		
		## วันเริ่มปฏิบัติราชการ
		if($rs[DATE_F] != "0000-00-00 00:00:00" and $rs[DATE_F] != ""){
			$arr_f = explode(" ",$rs[DATE_F]);
			$arr_f1 = explode("-",$arr_f[0]);
			//$check_begindate = ($arr_f1[0]+543)."-".$arr_f1[1]."-".$arr_f1[2];
			$check_begindate = $arr_f1[2]."-".$arr_f1[1]."-".($arr_f1[0]+543);
		}else{
			$check_begindate = "";	
		}//end 	if($rs[DATE_F] != "0000-00-00 00:00:00" and $rs[DATE_F] != ""){

	###  ชื่อโรงเรียน
		$arr_f = get_school($rs[I_CODE],$sentsecid);
		
			
		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="left"><?=get_prename($rs[SUR_CODE]);?></td>
            <td align="left"><?=$rs[NAME1]?></td>
            <td align="left"><?=$rs[NAME2]?></td>
            <td align="left"><?=$check_birthday?></td>
            <td align="left"><?=$rs[IDCODE]?></td>
            <td align="left"><?=$check_begindate?></td>
            <td align="left"><?=get_position($rs[POST_CODE]);?></td>
            <td align="left"><?=$arr_f['schoolname']?></td>
          </tr>
		  <?
		  	}//end while(){
		  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <?
  	}//end if($action == "view"){
  ?>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>