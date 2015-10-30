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


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.date_sent.value == ""){
		alert("กรุณาระบุวันที่คาดว่าจะดำเนินการแล้วเสร็จ");
		document.form1.date_sent.focus();
		return false;
	}
}
</script>
</head>

<body bgcolor="#EFEFFF">
<?
		$sql = "SELECT * FROM tbl_checklist_assign  WHERE ticketid='$ticketid' AND activity_id='3'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
		$page_all = array_sum($arrpage);
		$arrqc = GetStaffKeykp7($ticketid);
		
?>

  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="100%" align="right" bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td align="center">&nbsp;</td>
              <td width="22%" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#A5B6CE"><strong>รายชื่อเอกสารที่ยังไม่ได้ทำการ QC</strong></td>
          </tr>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
                  <td width="10%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>เลขบัตรประชาชน</strong></td>
                  <td width="11%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>ชื่อ-นามสกุล</strong></td>
                  <td width="12%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>ตำแหน่ง</strong></td>
                  <td width="14%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>โรงเรียน/หน่วยงาน</strong></td>
                  <td width="8%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>อายุ<br>
                    ราชการ</strong></td>
                  <td colspan="2" align="center" bgcolor="#D2D2D2"><strong>จำนวน(แผ่น)</strong></td>
                  <td width="6%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>ไฟล์</strong></td>
                  </tr>
                <tr>
                  <td width="6%" align="center" bgcolor="#D2D2D2"><strong>คนนับ</strong></td>
                  <td width="6%" align="center" bgcolor="#D2D2D2"><strong>ระบบนับ</strong></td>
                  </tr>
                <?
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
	  	$sql_detail = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' ORDER BY name_th ASC";
		$result_detail = mysql_db_query($dbname_temp,$sql_detail);
		$i=0;
		while($rsd = mysql_fetch_assoc($result_detail)){
			if (!(array_key_exists($rsd[idcard], $arrqc))) { 
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $arrp = ShowPersonDetail($rsd[idcard]);
			 $xval = "$rsd[approve]";
			 $xkp7file = "$path_kp7file".$rsd[siteid]."/".$rsd[idcard].".pdf";
			if(file_exists($xkp7file)){
					$xfile = "<a href='$xkp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf_gray.gif\" width=\"20\" height=\"20\" border=\"0\" title=\"เอกสารสำเนาต้นฉบับ\"></a>";	 
			 }
				 
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="center"><?=$rsd[idcard]?></td>
                  <td align="left"><? echo "$rsd[prename_th]$rsd[name_th]  $rsd[surname_th]";?></td>
                  <td align="left"><? echo $arrp['position_now'];?></td>
                  <td align="left"><?=$arrp['schoolid']."/".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($rsd[siteid]));?></td>
                  <td align="center"><?=floor($arrp['age_gov'])?></td>
                  <td align="center"><? echo $arrpage[$rsd[idcard]];?></td>
                  <td align="center"><?=ShowPageUpload($rsd[idcard]);?></td>
                  <td align="center"><?=$xfile?></td>
                  </tr>
                <?
					$xfile = "";
			}//end if (!(array_key_exists($rsd[idcard], $arrqc))) { 
			
		}	// end while($rsd = mysql_fetch_assoc($result_detail)){
				?>
                </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
  </table>

</BODY>
</HTML>
