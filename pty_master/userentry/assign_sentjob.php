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


include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");



if($_SERVER['REQUEST_METHOD'] == "POST"){



	$sql_update = "UPDATE tbl_checklist_assign SET date_recive='".sw_date_indb($date_recive)."', date_sent='".$date_sent."', assign_status='Y', comment_approve='$comment_approve' WHERE ticketid='$ticketid'";
	//echo $dbname_temp." :: ".$sql_update;
	$result  = mysql_db_query($dbname_temp,$sql_update);
	if(count($arrid) > 0){
		foreach($arrid as $key => $val){
			AddLogActivity($ticketid,$key,$arr_site[$key],$staffid,"sent",$activity_id,"1","ให้ยืมเอกสาร");
		}//end foreach($arrid as $key => $val){
	}//end if(count($arrid) > 0){
	

	if($result){
		echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');
		window.opener.location.reload();
		 location.href='assign_sentjob.php?ticketid=$ticketid&xmode=1';
		 </script>";
		exit;
	}

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

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
<form name="form1" method="post" action="" onSubmit="return checkFields();">
  <input type="hidden" name="ticketid" value="<?=$ticketid?>">
<?
		$sql = "SELECT * FROM tbl_checklist_assign  WHERE ticketid='$ticketid'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
		$page_all = array_sum($arrpage);
		
?>
<input type="hidden"  name="staffid" value="<?=$rs[staffid]?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="right" bgcolor="#EFEFFF"><input type="submit" name="Submit" value="บันทึกรับมอบเอกสาร"></td>
        </tr>
        <tr>
          <td colspan="4" align="left" bgcolor="#A5B6CE"><img src="logo_sapp.jpg" width="160" height="50"></td>
          </tr>
        <tr>
          <td colspan="3" align="left"><strong>หนังสือรับมอบเอกสาร กพ.7</strong>&nbsp;&nbsp; <? 
		  if($_SESSION[session_sapphire] == "1"){ // เห็น เฉพาะพนักงาน sapphire เท่านั้น
			  /* if($rs[assign_status] == "Y"){ */echo "<a href='assign_pdf.php?ticketid=$rs[ticketid]&profile_id=$profile_id'><img src=\"../../images_sys/pdf.gif\" alt=\"จ่ายงานเรียบร้อยแล้วคลิ๊กเพื่อปริ้นเอกสาร pdf\" width=\"20\" height=\"20\" border=\"0\"></a>";//}
		   }//end   if($_SESSION[session_sapphire] == "1"){
		   ?></td>
          <td width="41%" align="right"><label>&nbsp;          </label></td>
        </tr>
		<? 
		//echo $rs[date_recive];
		if($rs[date_recive] != "0000-00-00"){
			$arr_rd =explode("-",$rs[date_recive]);
			$date_recive = sw_date_intxtbox($rs[date_recive]);
			$temp_rd = $rs[date_recive];
		}else{
			$date_recive = date("d/m")."/".(date("Y")+543);
			$temp_rd = sw_date_indb($date_recive);
		}
		
		$numdoc1 = CountTicketDetail($rs[ticketid]); // จำนวนชุด
		
		### กำหนดวันส่ง
		$arrd1 = ShowDateScanEnd($temp_rd,$numdoc1);
		?>
        <tr>
          <td width="16%" align="left"><strong>หมายเลขงาน :</strong></td>
          <td width="22%" align="left"><?=$ticketid?></td>
          <td width="21%" align="left"><strong>วันที่รับเอกสาร : </strong></td>
          <td align="left">
            <?=thai_date($temp_rd);?>
            <input type="hidden" name="date_recive" value="<?=$date_recive?>">
            </td>
        </tr>
        <tr>
          <td align="left"><strong>ชื่อ- นามสกุล : </strong></td>
          <td align="left"><?=show_user($rs[staffid]);?></td>
          <td align="left"><strong>วันที่คาดว่าจะดำเนินการ<br>
            แล้วเสร็จ : </strong></td>
          <td align="left">
            <? echo $arrd1['xdate_label']?>
            <input type="hidden" name="date_sent" value="<?=$arrd1['xdate']?>">
            </td>
        </tr>
        <tr>
          <td align="left"><strong>หมายเลขโทรศัพท์ : </strong></td>
          <td align="left">
		  <?
		  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
		  $result_user = mysql_db_query($dbedubkk_userentry,$sql_user);
		  $rs_u = mysql_fetch_assoc($result_user);
		  if($rs_u[telno] != ""){
		  echo "$rs_u[telno]";
		  }else{ echo "-";}
		  ?>		  </td>
		  <? if($_SESSION[session_sapphire] == "1"){ // เห็นข้อมูลเฉพาะพนักงาน sapphire เท่านั้น?>
          <td align="left"><strong>เบอร์โทรเจ้าหน้าที่บริษัทฯ : </strong></td>
          <td align="left"><?
		  $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staff_assign]'";
		  $result_admin = mysql_db_query($dbedubkk_userentry,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);
		  if($rs_admin[telno] != ""){
		  echo "$rs_admin[telno]";
		  }else{ echo "-";}
		  ?></td>
			<? } // end if($_SESSION[session_sapphire] == "1"){ ?>
        </tr>
        <tr>
          <td align="left"><strong>จำนวน (ชุด/แผ่น) : </strong></td>
          <td align="left"><?=CountTicketDetail($rs[ticketid]);?> ชุด / <?=$page_all;?> แผ่น</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>เจ้าหน้าที่บริษัทฯ : </strong></td>
          <td align="left"><?=show_user($rs[staff_assign]);?></td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>หมายเหตุ : </strong></td>
          <td colspan="3" align="left"><label>
            <textarea name="comment_approve" cols="110" rows="3" id="comment_approve"><?=$rs[comment_approve]?></textarea>
          </label></td>
          </tr>
        <tr>
          <td colspan="4" align="left"><em>หมายเหตุ : วันที่คาดว่าจะดำเนินการแล้วเสร็จระบบจำคำนวณให้โดยอัตโนมัติโดยคำนวณจ่าค่าเฉลี่ยที่สแกนได้ 
            <?=$numdoc?> ต่อวัน</em></td>
          </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
                  <td width="14%" align="center" bgcolor="#D2D2D2"><strong>เลขบัตรประชาชน</strong></td>
                  <td width="16%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ-นามสกุล</strong></td>
                  <td width="19%" align="center" bgcolor="#D2D2D2"><strong>ตำแหน่ง</strong></td>
                  <td width="18%" align="center" bgcolor="#D2D2D2"><strong>โรงเรียน/หน่วยงาน</strong></td>
                  <td width="8%" align="center" bgcolor="#D2D2D2"><strong>อายุราชการ</strong></td>
                  <td width="8%" align="center" bgcolor="#D2D2D2"><strong>จำนวน(แผ่น)</strong></td>
				  <? if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <? } //end   if ($_SESSION[session_sapphire] == 1 ){?>
                  <td width="4%" align="center" bgcolor="#D2D2D2"><strong>สถานะ</strong></td>
                </tr>
				<?
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
	  	$sql_detail = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' ORDER BY name_th ASC";
		$result_detail = mysql_db_query($dbname_temp,$sql_detail);
		$i=0;
		while($rsd = mysql_fetch_assoc($result_detail)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $arrp = ShowPersonDetail($rsd[idcard]);
				 
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="center"><?=$rsd[idcard]?></td>
                  <td align="left"><? echo "$rsd[prename_th]$rsd[name_th]  $rsd[surname_th]";?></td>
                  <td align="left"><? echo $arrp['position_now'];?></td>
                  <td align="left"><?=$arrp['schoolid']."/".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($rsd[siteid]));?></td>
                  <td align="center"><?=floor($arrp['age_gov'])?></td>
                  <td align="center"><? echo $arrpage[$rsd[idcard]];?></td>
                  <td align="center"><? if($rsd[status_scan] == "0"){ echo "<font color='red'>wait</font>";}else{ echo "scan";}?>
                  <input type="hidden" name="arrid[<?=$rsd[idcard]?>]" value="<?=$rsd[idcard]?>">
                  <input type="hidden" name="arr_site[<?=$rsd[idcard]?>]" value="<?=$rsd[siteid]?>">
                  </td>
                </tr>
				<?
					}
				?>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">ข้าพเจ้าได้รับสำเนาทะเบียนประวัติ ก.พ.7 จากบริษัท แซฟไฟร์ รีเสิร์ช แอนด์ ดีเวลล็อปเม็นท์ จำกัด ตามรายการ</td>
        </tr>
        <tr>
          <td colspan="4" align="left">ข้างต้น ข้าพเจ้าจะดูแลเอกสารที่ได้รับมาทั้งหมดเป็นอย่างดีและไม่นำไปทำสำเนาซ้ำไม่ว่าด้วยกรณีใด ๆ </td>
        </tr>
        <tr>
          <td colspan="4" align="left">พร้อมกับจะนำมาส่งคืนให้กับบริษัทฯ ทันทีเมื่อดำเนินการบันทึกข้อมูลแล้วเสร็จหรือทางบริษัทฯทวงถาม</td>
        </tr>
        <tr>
          <td colspan="4" align="left">หากเกิดความเสียหายกับเอกสาร เอกสารสูญหาย ข้าพเจ้ายินดีรับผิดชอบต่อความเสียหายทั้งปวงที่เกิดขึ้นตามที่</td>
        </tr>
        <tr>
          <td colspan="4" align="left">บริษัทฯ เรียกร้อง</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="49%" align="center">....................................................</td>
              <td width="51%" align="center">....................................................</td>
            </tr>
            <tr>
              <td align="center">(&nbsp;&nbsp;
                <?=show_user($rs[staffid]);?>
&nbsp;&nbsp;)</td>
              <td align="center">(&nbsp;&nbsp;
                <?=show_user($rs[staff_assign]);?>
&nbsp;&nbsp;)</td>
            </tr>
            <tr>
              <td align="center">ผู้รับจ้าง</td>
              <td align="center">เจ้าหน้าที่บริษัทฯ</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
