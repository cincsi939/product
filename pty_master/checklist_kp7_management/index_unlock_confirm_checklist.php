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
$subid = substr($xsiteid,0,1); // สพนักงานประถมจะเป็น 1 มัธยมจะเป็น 0


	
###############3
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if($Aaction == "SAVE"){
		$sqlupdate = "UPDATE tbl_checklist_kp7_confirm_site SET flag_xls_endprocess='$conF_site',staff_endprocess='".$_SESSION['session_staffid']."'  WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
		//echo $sqlupdate;
	$result = mysql_db_query($dbname_temp,$sqlupdate) or die(mysql_error());
			if($result){
			SaveLogConfirmSite($xsiteid,$profile_id,"2","$comment_log","$conF_site");	
			echo "<script> alert('ปลดล็อกการทำงานของระบบ checklist เรียบร้อยแล้ว'); location.href='?action=&xsiteid=$xsiteid&profile_id=$profile_id';</script>";
		exit;
		}
			
	}//end if($Aaction == "SAVE"){

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>unlock การยืนยันข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

function msgconf(){
	alert("การยืนยันการดำเนินการตรวจสอบข้อมูลเสร็จสิ้นจะมีผลทำให้ไม่สามารถปรับปรุงข้อมูลผ่านฟอร์ม excel ได้");	
	return true;
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?
	if($action == ""){
?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>รายชื่อเขตทีทำการยืนยันการดำเนินการเสร็จสิ้นไปแล้ว 
          <?=ShowProfile_name($profile_id);?>
        </strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="49%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="29%" align="center" bgcolor="#CCCCCC"><strong>สถานะการดำเนินการ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ปลดล็อกการดำเนินการ</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.siteid,
t1.profile_id,
t1.flag_download_xls,
t1.flag_xls_endprocess,
t1.staff_download,
t1.staff_endprocess,
t2.secname_short,
if(substring(t2.secid,1,1) ='0',cast(t2.secid as SIGNED),9999) as idsite
FROM
edubkk_checklist.tbl_checklist_kp7_confirm_site as t1
Inner Join edubkk_master.eduarea  as t2
ON t1.siteid = t2.secid
WHERE t1.profile_id='$profile_id'
group by t1.siteid
order by idsite, t2.secname  ASC";
$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
         	if($rs[flag_xls_endprocess] == "1"){
				$img_lock = " <img src=\"../../images_sys/lock-icon.png\" width=\"20\" height=\"20\" border=\"0\" title=\"ดำเนินการเสร็จเรียบร้อยแล้ว\">";	
			
			}else{
				$img_lock	 = " <img src=\"../../images_sys/lock-off-disabled-icon.png\" width=\"20\" height=\"20\" border=\"0\" title=\"อยู่ระหว่างดำเนินการ\">";
				
			}//end 	if($rs[flag_xls_endprocess] == "1"){
				$link_lock = "<a href=\"?action=unlock&xsiteid=$rs[siteid]&profile_id=$rs[profile_id]\"><img src=\"../../images_sys/key_go.png\" width=\"16\" height=\"16\" border=\"0\" title=\"คลิ๊กเพื่อปรับสถานะการดำเนินการของทีมหน้าไซต์\"></a>";

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="center"><?=$img_lock?></td>
        <td align="center"><?=$link_lock?></td>
      </tr>
 <?
}//end 
?>
    </table></td>
  </tr>
  <?
	}//end if($action == ""){
	if($action == "unlock"){
  ?>
  <tr>
    <td><form name="form2" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" align="left" bgcolor="#CCCCCC"><strong>ฟอร์มปลดล็อกการดำเนินการตรวจสอบข้อมูลในระบบ checklist ของทีมออกนอกพื้นที่ 
                <?=show_area($xsiteid);?> 
                <?=ShowDateProfile($profile_id)?> 
                </strong></td>
              </tr>
            <tr>
              <td width="15%" align="right" valign="top" bgcolor="#FFFFFF"><strong>หมายเหตุการปลดล็อกข้อมูล</strong></td>
              <td width="85%" align="left" valign="top" bgcolor="#FFFFFF"><strong>
                <textarea name="comment_log" id="textarea" cols="50" rows="4"></textarea>
              </strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF">สถานะการดำเนินการ</td>
              <td align="left" bgcolor="#FFFFFF"><input type="radio" name="conF_site" id="radio" value="1" onClick="return msgconf();">
        ดำเนินการตรวจสอบข้อมูลเสร็จสิ้น 
            <input type="radio" name="conF_site" id="radio2" value="0"> 
            อยู่ระหว่างดำเนินการจัดทำข้อมูลหน้าไซต์
</td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">
             <input type="hidden" name="Aaction" value="SAVE">
              <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
              <input type="hidden" name="profile_id" value="<?=$profile_id?>">
              <input type="submit" name="button" id="button" value="ตกลง"> 
              <input type="button" name="btnC" value="ยกเลิก" onClick="location.href='?action=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'">
              </td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <?
	}//end if($action == "unlock"){
  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
