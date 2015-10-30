<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ระบบส่งงาน
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

set_time_limit(0);
include "epm.inc.php";
define('FPDF_FONTPATH','/fpdi/font/');
require_once('fpdi/fpdf.php');

include("function_assign.php");
//$type_cmss = "province"; // กำหนดกรณีเป็นระบบของ จังหวัด
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "มอบหมายการบันทึกข้อมูล ก.พ.7 ให้กับผู้ใช้";
	### ห้องคีย์งานของพนักงานคีย์ข้อมูล
	$sql_staff = "SELECT t2.card_id FROM tbl_assign_sub as t1 Inner Join keystaff as t2 ON t1.staffid = t2.staffid WHERE t1.ticketid = '$ticketid'";
	$result_staff = mysql_db_query($dbnameuse,$sql_staff) or die(mysql_error()."".__LINE__);
	$rsstaff = mysql_fetch_assoc($result_staff);
	$sitekey = GetSiteName($rsstaff[card_id]);
	// connet ที่เครื่อง db server
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 


if($_SERVER['REQUEST_METHOD'] == "POST"){

	$amount_pay = str_replace(",","",$amount_pay);  // กรณีเป็น คอมม่า

	$sql_update = "UPDATE tbl_assign_sub SET recive_date='".sw_date_indb($recive_date)."', sent_date='".sw_date_indb($sent_date)."', assign_status='YES', amount_pay='$amount_pay',assign_comment='$assign_comment' WHERE ticketid='$ticketid'";
	$result  = mysql_db_query($db_name,$sql_update);
//	echo "<pre>";
//	print_r($_POST);
if(count($idcard) > 0){
	foreach($idcard as $k1 => $v1){
	// ปิด ในส่วนของการ gen pdf เพื่อเข้ารหัส
/*		$source_path = $_SERVER['DOCUMENT_ROOT']."/edubkk_kp7file/$xsiteid[$k1]";  
		$dest_path = $_SERVER['DOCUMENT_ROOT']."/kp7_assign";
		$password = "$ticketid";
		$origFile = "$source_path/$v1.pdf";
		$destFile ="$dest_path/".$v1."_assign.pdf";
		$in_db = $v1."_assign.pdf";
		pdfEncrypt($origFile, $password, $destFile );
*/		
###  end ปิด ในส่วนของการ gen pdf เพื่อเข้ารหัส
		$xestimate_pay = str_replace(",","",$estimate_pay[$k1]); // ค่าใช้จ่ายโดยประมาณต่อชุด
		$sql_up1 = "UPDATE tbl_assign_key SET kp7file ='$in_db', estimate_pay = '$xestimate_pay' WHERE ticketid='$ticketid' and idcard='$v1'";
		@mysql_db_query($db_name,$sql_up1);

	}// end foreach(){
}// end if(count($idcard) > 0){
	
	
	if($result){
		echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');
		 location.href='sent_job.php?ticketid=$ticketid&xmode=1';</script>";
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
	if(document.form1.sent_date.value == ""){
		alert("กรุณาระบุวันที่คาดว่าจะดำเนินการแล้วเสร็จ");
		document.form1.sent_date.focus();
		return false;
	}
}
</script>
</head>

<body bgcolor="#EFEFFF">
<?
		$sql = "SELECT * FROM tbl_assign_sub WHERE ticketid='$ticketid'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);	
?>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="right" bgcolor="#EFEFFF"><a href="assign_print.php?ticketid=<?=$ticketid?>">ใบปะหน้าเอกสาร</a> || <a href="assign_print1.php?ticketid=<?=$ticketid?>">ใบตรวจสอบเอกสาร</a></td>
        </tr>
        <tr>
          <td colspan="4" align="left" bgcolor="#A5B6CE"><strong>ใบงานตรวจสอบความครบถ้วนสมบูรณ์ของเอกสาร ก.พ.7</strong></td>
          </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
          <td width="40%" align="right"><input type="button" name="print_doc" id="button" value="ปริ้นเอกสาร" onClick="return window.print();"></td>
        </tr>
		<? 
		if($rs[recive_date] != "0000-00-00"){
			$arr_rd =explode("-",$rs[recive_date]);
			$recive_date = sw_date_intxtbox($rs[recive_date]);
		}else{
			$recive_date = date("d/m")."/".(date("Y")+543);
		}
		
		?>
        <tr>
          <td width="16%" align="left"><strong>หมายเลขงาน :</strong></td>
          <td width="22%" align="left"><?=$ticketid?></td>
          <td width="22%" align="left"><strong>วันที่รับเอกสาร : </strong></td>
          <td align="left"><?=DBThaiLongDate($rs[recive_date]);?></td>
        </tr>
        <tr>
          <td align="left"><strong>ชื่อ- นามสกุล : </strong></td>
          <td align="left"><?=show_user($rs[staffid]);?></td>
          <td align="left"><strong>เจ้าหน้าที่มอบหมายงาน : </strong></td>
          <td align="left"><?=show_user($rs[admin_id]);?></td>
        </tr>
        <tr>
          <td align="left"><strong>หมายเลขโทรศัพท์ : </strong></td>
          <td align="left">
		  <?
		  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
		  $result_user = mysql_db_query($db_name,$sql_user);
		  $rs_u = mysql_fetch_assoc($result_user);
		  if($rs_u[telno] != ""){
		  echo "$rs_u[telno]";
		  }else{ echo "-";}
		  ?>		  </td>
		  
          <td align="left"><strong>เบอร์โทรศัพท์เจ้าหน้าที่มอบหมายงาน : </strong></td>
          <td align="left"><?
		  		  $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[admin_id]'";
		  $result_admin = mysql_db_query($db_name,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);
		  if($rs_admin[telno] != ""){
		  echo "$rs_admin[telno]";
		  }else{ echo "-";}
		  ?></td>
        </tr>
        <tr>
          <td align="left"><strong>จำนวน (ชุด/แผ่น) : </strong></td>
          <td align="left"><?  $arrdoc1 = SumPageTicket($rs[ticketid]); echo $arrdoc1['num_doc'];?> ชุด / <?=$arrdoc1['sumpage'];?> แผ่น</td>
          <td align="left"><strong>ห้องคีย์งาน :</strong></td>
          <td align="left"><?=$sitekey?></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="5%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
                  <td width="15%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
                  <td width="17%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ-นามสกุล</strong></td>
                  <td width="19%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
                  <td width="18%" align="center" bgcolor="#A5B2CE"><strong>โรงเรียน/หน่วยงาน</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>อายุราชการ</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>จำนวนรูป(รูป)</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>จำนวน(แผ่น)</strong></td>
				  <? if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <? } //end   if ($_SESSION[session_sapphire] == 1 ){?>
                  </tr>
				<?
		$cyy = (date("Y")+543);
					$sql1 = "SELECT
$db_name.tbl_assign_key.ticketid,
$db_name.tbl_assign_key.profile_id,
$db_name.tbl_assign_key.estimate_pay,
$dbnamemaster.view_general.CZ_ID,
$dbnamemaster.view_general.siteid,
$dbnamemaster.view_general.prename_th,
$dbnamemaster.view_general.name_th,
$dbnamemaster.view_general.surname_th,
$dbnamemaster.view_general.position_now,
$dbnamemaster.view_general.schoolid,
TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  
FROM
$db_name.tbl_assign_key
Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid'";

				
				$result1 = mysql_db_query($db_name,$sql1);
				$k=0;
				while($rs1 = mysql_fetch_assoc($result1)){
				 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$arrpicpage = GetNumPicPage($rs1[CZ_ID],$rs1[profile_id]);				 
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center">
                    <input type="checkbox" name="checkbox" id="checkbox"></td>
                  <td align="center"><?=$rs1[CZ_ID]?></td>
                  <td align="left"><? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?></td>
                  <td align="left"><? echo "$rs1[position_now]";?></td>
                  <td align="left"><?=show_org($rs1[schoolid])."/".show_area($rs1[siteid]);?></td>
                  <td align="center"><?=floor($rs1[age_gov])?></td>
                  <td align="center"><?=$arrpicpage['pic']?></td>
                  <td align="center"><?=$arrpicpage['page']?></td>
                  </tr>
               <?
			   			$sum_pic += $arrpicpage['pic'];
						$sum_page += $arrpicpage['page'];
					}
				?>
                <tr>
                  <td colspan="6" align="right" bgcolor="#CCCCCC"><strong>รวม :</strong></td>
                  <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_pic)?></strong></td>
                  <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_page)?></strong></td>
                </tr>

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
                <?=show_user($rs[admin_id]);?>
&nbsp;&nbsp;)</td>
            </tr>
            <tr>
              <td align="center">ผู้รับจ้าง</td>
              <td align="center">เจ้าหน้าที่มอบหมายงาน</td>
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
</BODY>
</HTML>
