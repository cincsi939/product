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
	$count_no = count($approve); // จำนวนชุดทังหมด
	$sum_no = array_sum($approve);// จำนวนที่รับรองข้อมูล
	if(in_array("2",$approve)){
		$xapprove = 2;	
	}else  if($count_no == $sum_no){
		$xapprove = 1;
}else{
		$xapprove = 0;	
}

	$sql_update = "UPDATE tbl_checklist_assign SET date_recive_true='".sw_date_indb($date_recive_true)."', comment_approve='$comment_approve',approve='$xapprove' WHERE ticketid='$ticketid'";
	//echo $dbname_temp." :: ".$sql_update;
	$result  = mysql_db_query($dbname_temp,$sql_update);
	if($count_no > 0){
		foreach($approve as $k => $v){
			if($v == "1"){
					$status_scan = 1;
			}else{
					$status_scan = 0;
			}
				$sql_up = "UPDATE tbl_checklist_assign_detail SET approve='$v',status_scan='$status_scan',status_sr_doc='$status_sr_doc[$k]'  WHERE idcard='$k'";
				AddLogActivity($ticketid,$k,$arr_site[$k],$staffid,"recive",$activity_id,$status_sr_doc[$k],"ตรวจรับเอกสาร");
				//echo "$sql_up<br>";
				mysql_db_query($dbname_temp,$sql_up);
		}//end foreach($approve as $k = > $v){
			
	}//end if($count_no > 0){
//die;
	if($result){
		echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');
		window.opener.location.reload();
				 location.href='assign_recivejob.php?ticketid=$ticketid&xmode=2';
		
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
<input type="hidden" name="staffid" value="<?=$rs[staffid]?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="right" bgcolor="#EFEFFF"><input type="submit" name="Submit" value="บันทึกรับคืนเอกสาร"></td>
        </tr>
        <tr>
          <td colspan="4" align="left" bgcolor="#A5B6CE"><img src="logo_sapp.jpg" width="160" height="50"></td>
          </tr>
        <tr>
          <td colspan="3" align="left"><strong>หนังสือรับมอบเอกสาร กพ.7</strong>&nbsp;&nbsp; <? 
		  if($_SESSION[session_sapphire] == "1"){ // เห็น เฉพาะพนักงาน sapphire เท่านั้น
			   if($rs[assign_status] == "Y"){ echo "<a href='assign_pdf.php?ticketid=$rs[ticketid]&profile_id=$profile_id'><img src=\"../../images_sys/pdf.gif\" alt=\"จ่ายงานเรียบร้อยแล้วคลิ๊กเพื่อปริ้นเอกสาร pdf\" width=\"20\" height=\"20\" border=\"0\"></a>";}
		   }//end   if($_SESSION[session_sapphire] == "1"){
		   ?></td>
          <td width="41%" align="right"><label>&nbsp;          </label></td>
        </tr>
        <tr>
          <td width="16%" align="left"><strong>หมายเลขงาน :</strong></td>
          <td width="22%" align="left"><?=$ticketid?></td>
          <td width="21%" align="left"><strong>วันที่รับเอกสาร : </strong></td>
          <td align="left"><?=thai_date($rs[date_recive]);?></td>
        </tr>
        <tr>
          <td align="left"><strong>ชื่อ- นามสกุล : </strong></td>
          <td align="left"><?=show_user($rs[staffid]);?></td>
          <td align="left"><strong>วันที่คาดว่าจะดำเนินการ<br>
            แล้วเสร็จ : </strong></td>
          <td align="left"><?=thai_date($rs[date_sent]);?></td>
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
          <td align="left"><strong>วันที่สุ่งเอกสารคื่น : </strong></td>
          <td align="left"><INPUT name="date_sent_true" onFocus="blur();" value="<?=sw_date_intxtbox($rs[date_sent_true])?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.date_sent_true, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
			<? } // end if($_SESSION[session_sapphire] == "1"){ ?>
        </tr>
        <tr>
          <td align="left"><strong>จำนวน (ชุด/แผ่น) : </strong></td>
          <td align="left"><?=CountTicketDetail($rs[ticketid]);?> ชุด / <?=$page_all;?> แผ่น</td>
          <td align="left"><strong>เบอร์โทรเจ้าหน้าที่บริษัทฯ : </strong></td>
          <td align="left"><?
		  $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staff_assign]'";
		  $result_admin = mysql_db_query($dbedubkk_userentry,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);
		  if($rs_admin[telno] != ""){
		  echo "$rs_admin[telno]";
		  }else{ echo "-";}
		  ?></td>
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
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                  <td width="10%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>สถานะไฟล์</strong></td>
                  <td width="13%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>สถานะคืน<br>
                    เอกสาร</strong></td>
                </tr>
                <tr>
                  <td width="6%" align="center" bgcolor="#D2D2D2"><strong>คนนับ</strong></td>
                  <td width="6%" align="center" bgcolor="#D2D2D2"><strong>ระบบนับ</strong></td>
                  <? if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <? } //end   if ($_SESSION[session_sapphire] == 1 ){?>
                  </tr>
				<?
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
	  	$sql_detail = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' ORDER BY name_th ASC";
		$result_detail = mysql_db_query($dbname_temp,$sql_detail);
		$i=0;
		while($rsd = mysql_fetch_assoc($result_detail)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $arrp = ShowPersonDetail($rsd[idcard]);
			 $xval = "$rsd[approve]";
			 $xkp7file = "$path_kp7file".$rsd[siteid]."/".$rsd[idcard].".pdf";
echo "<a href='$xkp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf_gray.gif\" width=\"20\" height=\"20\" border=\"0\" title=\"เอกสารสำเนาต้นฉบับ\"></a>";
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
                  <td align="center"> 
                  <input type="hidden" name="arr_site[<?=$rsd[idcard]?>]" value="<?=$rsd[siteid]?>">
                  <select name="approve[<?=$rsd[idcard]?>]" id="approve">
				   <? 
				  foreach($arr_approve as $k2 => $v2){
						if($xval == $k2){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$k2' $sel>$v2</option>";
					
				  } //end  foreach($arr_approve as $k2 => $v2){
				  ?>
				  </select>
               
                  </td>
                  <td align="center">
                    <input type="radio" name="status_sr_doc[<?=$rsd[idcard]?>]" id="status_sr_doc" value="1" <? if($rsd[status_sr_doc] == "1"){ echo "checked='checked'";}?>>ค้างคืน

                      <input type="radio" name="status_sr_doc[<?=$rsd[idcard]?>]" id="status_sr_doc" value="2" <? if($rsd[status_sr_doc] == "2"){ echo "checked='checked'";}?>>รับคืน
</td>
                </tr>
				<?
					$xfile = "";
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
