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
$file_name = basename($_SERVER['PHP_SELF']);
$kp7path = "../../../".PATH_KP7_FILE."/";
$time_start = getmicrotime();
if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
	$profile_id = LastProfile();
}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบสืบค้นเอกสาร ก.พ. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
    document.location = delUrl;
  }
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
          <td align="center" valign="middle" bgcolor="#CCCCCC"><strong><img src="../../images_sys/searchb.gif" width="26" height="22"></strong></td>
          <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"><strong>ค้นหาข้อมูลข้าราชการครูและบุคลากรทางการศึกษาเพื่อบันทึกรายการผลการตรวจสอบเอกสาร
            <?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
        <tr>
          <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="12%" bgcolor="#FFFFFF">ชื่อ</td>
          <td width="19%" bgcolor="#FFFFFF">
            <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>"></td>
          <td width="66%" bgcolor="#FFFFFF">&nbsp;</td>
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
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">หน่วยงาน</td>
          <td bgcolor="#FFFFFF"><label for="schoolname"></label>
            <input name="schoolname" type="text" id="schoolname" size="25" value="<?=$schoolname?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">ข้อมูล ณ วันที่</td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id">
            <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>

            </select></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">สำนักงานเขต</td>
          <td bgcolor="#FFFFFF">
            <select name="sent_secid" id="sent_secid">
            <option value=""> - เลือกสำนักงานเขต - </option>
            <?
            	$sql_area = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%' ORDER BY secname ASC";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				while($rsa = mysql_fetch_assoc($result_area)){
					if($rsa[secid] == "$sent_secid"){ $sel = " selected='selected'";}else{ $sel = "";}
					echo "<option value='$rsa[secid]'>$rsa[secname]</option>";
				}//end 	while($rsa = mysql_fetch_assoc($result_area)){
			?>
            </select></td>
          <td bgcolor="#FFFFFF"><input type="submit" name="save" id="save" value="ตกลง">
            <input type="reset" name="btncancel" id="btncancel" value="ยกเลิก">
            <input type="hidden" name="profile_id" value="<?=$profile_id?>">
            <input type="hidden" name="search" value="search">
            <input type="hidden" name="page" value=""></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<? if($search == "search" or $displaytype=="people"){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;</td></tr>
<?

if($schoolname != ""){
	$sqlschool = "SELECT id,office,siteid FROM allschool WHERE office LIKE '%$schoolname%'";
	$resultschool = mysql_db_query($dbnamemaster,$sqlschool);
	while($rsch = mysql_fetch_assoc($resultschool)){
		if($inschool > "")  $inschool .= ",";
		$inschool .= "'$rsch[id]'";
		$arrschool[$rsch[id]] = $rsch[office];
	}//end while(){
		
}//end if($schoolname != ""){
	
	
if($inschool != ""){ // กรณีค้นหาชื่อโรงเรียน
	$conwhere .= " AND schoolid IN($inschool)"; 
		
}//end if($inschool != ""){

if($sent_secid != ""){
	$conwhere .= " AND siteid LIKE '%$sent_secid%'";
}//end if($sent_secid != ""){

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


	$sql = "SELECT COUNT(idcard) as numall FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'  $conwhere ";
	//echo $sql_main."<br>";
	
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
    <td><strong>ผลการสืบค้น พบจำนวน <?=number_format($all)?> คน จากจำนวนข้อมูลทั้งหมด <?=number_format($rs[numall])?> คน (<? $time_e 	= getmicrotime();
	echo  number_format($time_e - $time_start,2);?> วินาที)</strong></td>
  </tr>
  <tr>
    <td bgcolor="#000000">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" >
      <tr>
        <td width="3%" align="center" bgcolor="#999999"><strong>ลำดับ</strong></td>
        <td width="9%" align="center" bgcolor="#999999"><strong>เลขบัตรประชาชน</strong></td>
        <td width="12%" align="center" bgcolor="#999999"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="12%" align="center" bgcolor="#999999"><strong>ตำแหน่ง</strong></td>
        <td width="14%" align="center" bgcolor="#999999"><strong>โรงเรียน</strong></td>
        <td width="19%" align="center" bgcolor="#999999"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="14%" align="center" bgcolor="#999999"><strong>ข้อมูล ณ วันที่</strong></td>
        <td width="17%" align="center" bgcolor="#999999">&nbsp;</td>
      </tr>
        <?
 		 while($rsm = mysql_fetch_assoc($result_main)){
	  	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 
		 			if($rsm[general_status] == "1" and $rsm[graduate_status] == "1" and $rsm[salary_status] == "1"  and $rsm[seminar_status] == "1" and $rsm[sheet_status] == "1" and $rsm[getroyal_status] == "1" and $rsm[special_status] == "1" and  $rsm[goodman_status] == "1" and $rsm[absent_status] == "1" and $rsm[nosalary_status] == "1" and $rsm[prohibit_status] == "1" and $rsm[specialduty_status] == "1" and $rsm[other_status] == "1"){
					$file_complate = "1";
			}else if($rsm[general_status] == "0" or $rsm[graduate_status] == "0" or $rsm[salary_status] == "0"  or $rsm[seminar_status] == "0" or $rsm[sheet_status] == "0" or $rsm[getroyal_status] == "0" or $rsm[special_status] == "0" or $rsm[goodman_status] == "0" or $rsm[absent_status] == "0" or $rsm[nosalary_status] == "0" or $rsm[prohibit_status] == "0" or $rsm[specialduty_status] == "0" or $rsm[other_status] == "0"){
					$file_complate = "0";
			}else{
					$file_complate = "";
			}
			

  ?>

      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rsm[idcard]?></td>
        <td align="left"><? echo "$rsm[prename_th]$rsm[name_th]  $rsm[surname_th]";?></td>
        <td align="left"><? echo "$rsm[position_now]";?></td>
        <td align="left"><? 
			if(count($arrschool) > 0){
					echo $arrschool[$rsm[schoolid]];
			}else{
					echo show_school($rsm[schoolid]);	
			}
		?></td>
        <td align="left"><? echo show_area($rsm[siteid]);?></td>
        <td align="left"><? echo ShowProfile_name($rsm[profile_id]);?></td>
        <td align="center">
<? if($file_complate == "1"){ // ไฟล์ที่สมบูรณ์เท่านั้น?>
       <A href="#" onClick="window.open('check_kp7_popup_upload.php?idcard=<?=$rsm[idcard]?>&profile_id=<?=$rsm[profile_id]?>&xsiteid=<?=$rsm[siteid]?>&lv=2&schoolid=<?=$rsm[schoolid]?>&sentsecid=<?=$rsm[siteid]?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=400');"><img src="../../images_sys/move-file-icon.png" width="25" height="25" border="0"  title="คลิ๊กเพื่อ upload ไฟล์ ก.พ. 7 ต้นฉบับ"></a><? }//end  if($file_complate == "1"){ ?>&nbsp;
<? // if(CheckLockArea($sentsecid) > 0){ echo "<em>Lock</em>"; }else{?>
		<img src="../../images_sys/b_edit.png" width="16" height="16" border="0" alt="แก้ไขรายการ" onClick="location.href='form_manage_checklist.php?action=EDIT&sentsecid=<?=$rsm[siteid]?>&idcard=<?=$rsm[idcard]?>&fullname=<? echo "$rsm[prename_th]$rsm[name_th]  $rsm[surname_th]";?>&search=<?=$search?>&key_name=<?=$rsm[name_th]?>&key_surname=<?=$rsm[surname_th]?>&key_idcard=<?=$rsm[idcard]?>&schoolid=<?=$rsm[schoolid]?>&xsiteid=<?=$rsm[siteid]?>&profile_id=<?=$rsm[profile_id]?>'" style="cursor:hand">
        <? //} //end if(CheckLockArea($rs[secid]) > 0){ ?>
		&nbsp;&nbsp;
		<? if($rsm[status_file] != "1"){?>
		<a href="#" onClick="window.open('check_kp7_popup_delete.php?sentsecid=<?=$rsm[siteid]?>&idcard=<?=$rsm[idcard]?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>&lv=<?=$lv?>&xfilename=<?=$file_name?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=600,height=400');"><img src="../../images_sys/b_drop.png" width="16" height="16" border="0" title="ลบรายการ"></a>
		&nbsp;&nbsp;<? } //end if($rsm[status_file] != "1"){ ?>
          <? //if(CheckLockArea($sentsecid) <  1){  // กรณี log เขต?>
        <a href="check_kp7_area.php?action=execute&sentsecid=<?=$rsm[siteid]?>&idcard=<?=$rsm[idcard]?>&fullname=<? echo "$rsm[prename_th]$rsm[name_th]  $rsm[surname_th]";?>&search=<?=$search?>&key_name=<?=$rsm[name_th]?>&key_surname=<?=$rsm[surname_th]?>&key_idcard=<?=$rsm[idcard]?>&schoolid=<?=$rsm[schoolid]?>&xsiteid=<?=$rsm[siteid]?>&profile_id=<?=$rsm[profile_id]?>"><img src="../../images_sys/refresh.png" width="18" height="18" border="0" alt="คลิ๊กเพื่อบันทึกผลการตรวจสอบเอกสาร"></a>
		<? //} //end  if(CheckLockArea($sentsecid) <  1){ ?>
		
<?
$sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$rsm[idcard]' AND status_problem = '0' AND profile_id='$rsm[profile_id]'   ORDER BY menu_id,problem_id  ASC";
$result_detail = mysql_db_query($dbtemp_check,$sql_detail);
if (@mysql_num_rows($result_detail) > 0 ){ 
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#A8B9FF"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#A8B9FF"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?

					$j=0;
					while($rs_d = mysql_fetch_assoc($result_detail)){
					
					
						if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
				?>
              <tr bgcolor="<?=$bg1?>">
                <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
                <td align="left"><?=$rs_d[problem_detail]?></td>
                </tr>
               <?
					}//end while(){
			   ?>
            </table>     
            <? }//end if (@mysql_num_rows($result_detail) > 0 ){ ?>   
        </td>
  <?
  }//end   while($rsm = mysql_fetch_assoc($result_main)){
	  if($all > 0){
  ?>
  </tr></table></td>
  </tr>
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