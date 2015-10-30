<?
session_start();
$ApplicationName	= "search_documentkp7";
$module_code 		= "search_documentkp7"; 
$process_id			= "checklistkp7_search";
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
include("function_search.php");
$comment_app = "รับคืนและทำลายเอกสารจากระบบค้นหาเพื่อทำลายเอกสาร";
$kp7path = "../../../".PATH_KP7_FILE."/";
$time_start = getmicrotime();
if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
	$profile_id = LastProfile();
}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

$activity_id = 3; // หมวดกิจกรรมเอกสาร :: งานส่งเอกสารเพื่อคีย์งาน
$status_doc = 3; // คือการบันทึกและทำลายเอกสาร
if($action == "confirm_destroy"){
	
	
	$sql_up = "UPDATE tbl_checklist_assign_detail SET approve='1',status_scan='1',status_sr_doc='$status_doc'  WHERE idcard='$idcard' AND activity_id='$activity_id' AND profile_id='$profile_id'";
	mysql_db_query($dbname_temp,$sql_up);
	$sql = "SELECT * FROM tbl_checklist_assign_detail WHERE idcard='$idcard' AND profile_id='$profile_id' AND activity_id='$activity_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	AddLogActivity($rs[ticketid],$idcard,$rs[siteid],$_SESSION['session_staffid'],"recive",'$activity_id','$status_doc',"รับคืนและทำลายเอกสาร");
	
	######  ตรวจสอบว่าในใบงานนี้มีการส่งคืนหมดหรือยัง
	$sql1 = "SELECT COUNT(idcard) as num1,sum(if(status_sr_doc='2' or status_sr_doc='3',1,0)) as num_doc  FROM tbl_checklist_assign_detail  WHERE profile_id='$profile_id' AND activity_id='$activity_id' AND ticketid='$rs[ticketid]'";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	if($rs1[num1] == $rs1[num_doc]){
	$sql_update = "UPDATE tbl_checklist_assign SET date_recive_true='".date("Y-m-d")."', comment_approve='$comment_app',approve='1' WHERE ticketid='$rs[ticketid]'";
	$result  = mysql_db_query($dbname_temp,$sql_update);	
	}
	
			echo "<script>alert('บันทึกการรับคืนและทำลายเอกสารเรียบร้อยแล้ว');
				 location.href='?activity_id=$activity_id&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&profile_id=$profile_id&search=search&displaytype=people';
		</script>";
		exit;
	
}//end if($action == "confirm_destroy"){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบสืบค้นเอกสาร ก.พ. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
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
</head>
<body>

<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="center" valign="middle" bgcolor="#CCCCCC">      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="9%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="58%">
            <select name="profile_id" id="profile_id">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <!--<option value="?profile_id=<?//=$rsp[profile_id]?>&search=<?//=$search?>&key_surname=<?//=$key_surname?>&key_idcard=<?//=$key_idcard?>&key_name=<?//=$key_name?>&page=<?//=$page?>" <?//=$sel?>><?//=$rsp[profilename]?></option>-->
              <option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
            </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table></td>
          </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#CCCCCC"><strong><img src="../../images_sys/searchb.gif" width="26" height="22"></strong></td>
          <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"><strong>แบบฟอร์มค้นหาเพื่อทำลายเอกสาร ก.พ.7 ต้นฉบับ เงื่อนไขการสืบค้นข้อมูล  <?=ShowProfile_name($profile_id);?></strong></td>
          </tr>
        <tr>
          <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="12%" bgcolor="#FFFFFF">ชื่อ</td>
          <td width="19%" bgcolor="#FFFFFF">
            <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>"></td>
          <td width="66%" bgcolor="#FFFFFF"><input type="submit" name="save" id="save" value="ค้นหา">
              <input type="hidden" name="search" value="search">
              <input type="hidden" name="page" value="">
            </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">นามสกุล</td>
          <td bgcolor="#FFFFFF">
            <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">หมายเลขบัตรประชาชน</td>
          <td bgcolor="#FFFFFF">
            <input name="key_idcard" type="text" id="key_idcard" size="25" maxlength="13" value="<?=$key_idcard?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<? if($search == "search" or $displaytype=="people"){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;</td></tr>
<?
if($key_name != ""){
		$conwhere  .= " AND name_th LIKE '%$key_name%'";
}
if($key_surname != ""){
		$conwhere .= " AND surname_th LIKE '%$key_surname%' ";
}

if($key_idcard != ""){
		$conwhere .= " AND idcard LIKE '%$key_idcard%'";
}


	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 10 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


/*	$sql = "SELECT COUNT(idcard) as numall FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' $conwhere";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
*/	
	$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'  $conwhere ";
	
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}
	//echo $sql_main;

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 
		
	if($num_row < 1){
	
?>
  <tr>
    <td><table width="99%" border="0" cellpadding="0" cellspacing="2" align="center" style="border:1px solid #5595CC;">
<tr>
	<td height="20"><img src="../../images_sys/alert.gif" width="16" height="16" align="absmiddle" />&nbsp;ผลการค้นหา:  <? if($key_name != ""){ echo "<br> - ชื่อ : $key_name  ";} if($key_surname != ""){ echo "<br> - นามสกุล : $key_surname  ";} if($key_idcard != ""){ echo " <br> - หมายเลขบัตรประชาชน : $key_idcard  ";} ?>&nbsp;ไม่ตรงกับบุคลากรใด ๆ<br /><br />
	ข้อแนะนำ :<br />
	- ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br />
	- ลดเงื่อนไขการค้นหาลง<br /><br />
	</td>
</tr>
</table></td>
  </tr>
  <?
	}//end 	if($num_row < 1){
   if($num_row > 0){?>
  <tr>
    <td><strong>ผลการสืบค้น พบจำนวน <?=number_format($all)?> คน  (<? $time_e 	= getmicrotime();
	echo  number_format($time_e - $time_start,2);?> วินาที)</strong></td>
  </tr>
  <?
  while($rsm = mysql_fetch_assoc($result_main)){
	  $i++;
	
	$arrassign_date  = GetDateSendKp7($rsm[idcard],$rsm[profile_id]);
	if($arrassign_date['status_sr_doc'] == "3"){
			$msg_title = "สถานะทำลายเอกสารเรียบร้อยแล้ว";
	}else{
			$msg_title = "";
	}// end if($arrassign_date['status_sr_doc'] == "3"){

	$kp7file = $kp7path.$rsm[siteid]."/".$rsm[idcard].".pdf";
	if($rsm[page_upload] > 0 and is_file($kp7file)){
		 $status_file = 1; 
		 $icon_status_file = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ผ่านการตรวจสอบ\">";
	}else{
		$status_file = 0;	
		 $icon_status_file = "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ไม่ผ่านการตรวจสอบ\">";
		
	}// end if($rsm[page_upload] > 0 and is_file($kp7file)){
	###########  ตรวจสอบการบันทึกข้อมูล
	$arrkeykp7 = CheckKeyKp7($rsm[idcard],$rsm[profile_id]);
	if($arrkeykp7['key'] == 1 or $arrkeykp7['approve'] == "2"){ // ตรวจสอบการคีย์ข้อมูล
		$status_key = 1;	
		$icon_status_key = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ผ่านการตรวจสอบ\">";
	}else{
		$status_key = 0;	
		$icon_status_key = "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ไม่ผ่านการตรวจสอบ\">";
	}//end if(CheckKeyKp7($rsm[idcard],$rsm[profile_id]) > 0){
		
	######  ตรวจสอบการรับรองข้อมูลจากทีม QC
	if($arrkeykp7['approve'] == "2"){
		$status_qc = 1;	
		$icon_status_qc = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ผ่านการตรวจสอบ\">";
	}else{
		$status_qc = 0;	
		$icon_status_qc =  "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ไม่ผ่านการตรวจสอบ\">";
	}//end 	if($arrkeykp7['approve'] == "2"){
	  


	$sumcheck = $status_file+$status_key+$status_qc;
	if($sumcheck == "3"){
			$msg = "<font color='green'>ผ่านการตรวจสอบพร้อมทำลายเอกสาร</font>";
			$dis1 = " ";
	}else{
			$msg = "<font color='red'>ไม่ผ่านการตรวจสอบ</font>";	
			$dis1 = " disabled";
	}
  ?>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="2%" align="center">&nbsp;</td>
        <td width="90%" align="left"><table width="99%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td align="left">&nbsp;<? echo "<u><b>".$i.".</b> ";?> <? echo "  $rsm[idcard]  $rsm[prename_th]$rsm[name_th]  $rsm[surname_th] </u> <b>$orgname</b> ";?> 
			<? $filekp7 = $kp7path.$rsm[siteid]."/".$rsm[idcard].".pdf";
			
					$kp7_sys = "<a href=\"../hr3/hr_report/kp7_search.php?id=".$rsm[idcard]."&sentsecid=".$rsm[siteid]."\" target=\"_blank\"><img src=\"..//hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='ก.พ.7 สร้างโดยระบบ ' ></a>";
			 if(is_file($filekp7) and $rsm[page_upload] > 0){
					$kp7img="<a href='$filekp7' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
					$file_upload = 1;
			}else{
					$kp7img = "";	
					$file_upload = 0;
			}
					echo "$kp7img &nbsp; $kp7_sys";
				?></td>
          </tr>
          
          <tr>
            <td align="left"><strong>วันจ่ายเอกสารออกจาก Store <?=$arrassign_date['date_assign']?></strong></td>
          </tr>
          <tr>
            <td align="left"><strong>วันรับคืนเอกสาร <?=$arrassign_date['date_recive']?></strong></td>
          </tr>
          <tr>
            <td align="left"><strong>วันรับคืนและทำลายเอกสาร <? if($arrassign_date['date_recive'] == ""){ echo GetDateThaiFull(date("Y-m-d"));}else{ echo $arrassign_date['date_recive'];}?> </strong></td>
          </tr>
          <tr>
            <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td colspan="3" align="center" bgcolor="#CACAFB"><strong>สถานะตรวจสอบการทำลายเอกสารก.พ.7 ต้นฉบับ <?=ShowProfile_name($profile_id);?></strong></td>
                    </tr>
                  <tr>
                    <td width="4%" align="center" bgcolor="#CACAFB"><strong>ลำดับ</strong></td>
                    <td width="36%" align="center" bgcolor="#CACAFB"><strong>หมวดการตรวจสอบ</strong></td>
                    <td width="60%" align="center" bgcolor="#CACAFB"><strong>สถานะการตรวจสอบ</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">1</td>
                    <td align="left" bgcolor="#FFFFFF">มีไฟล์ ก.พ.7 ต้นฉบับ</td>
                    <td align="center" bgcolor="#FFFFFF"><? echo $icon_status_file;?></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">2</td>
                    <td align="left" bgcolor="#FFFFFF">ผ่านการบันทึกข้อมูล</td>
                    <td align="center" bgcolor="#FFFFFF"><? echo $icon_status_key;?></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">3</td>
                    <td align="left" bgcolor="#FFFFFF">ผ่านการรับรองโดยทีม QC</td>
                    <td align="center" bgcolor="#FFFFFF"><? echo $icon_status_qc;?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>สรุปผลการตรวจสอบสถานะเอกสาร</strong></td>
                    <td align="center" bgcolor="#CCCCCC"><strong><?=$msg?> <? if($msg_title != ""){ echo " ( <font color='red'>$msg_title</font> ) ";}?></strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" bgcolor="#CCCCCC"><input type="button" name="conF" value="ยืนยันทำลายเอกสาร" <?=$dis1?> onClick="location.href='?action=confirm_destroy&idcard=<?=$rsm[idcard]?>&profile_id=<?=$rsm[profile_id]?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>'">
                    &nbsp;<input type="button" name="print_doc" value="ปริ้นเอกสาร" onClick="window.print()"></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="8%" align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <?
  }//end   while($rsm = mysql_fetch_assoc($result_main)){
	  if($all > 0){
  ?>
  <tr>
    <td><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
  </tr>
  <?
	  }//END if($all > 0){
  }//end if($num_row > 0){
  ?>
</table>
<? }//end if($search == "search" or $displaytype=="people"){?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>