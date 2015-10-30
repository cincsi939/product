<?
session_start();
set_time_limit(0);
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
include("../pic2cmss/function/function.php");
$file_name = basename($_SERVER['PHP_SELF']);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($action == "process"){
		$sql_up = "UPDATE tbl_checklist_kp7 SET pic_num='$pic_num' WHERE idcard='$idcard' and siteid='$xsiteid' and profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
		
		$sql_up1 = "UPDATE view_checkpicture SET checklist_numpic='$pic_num' WHERE idcard='$idcard' and siteid='$xsiteid' and profile_checklist='$profile_id'";
		mysql_db_query($dbnamemaster,$sql_up1) or die(mysql_error()."$sql_up1<br>LINE__".__LINE__);
		echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว');
		opener.document.location.reload();
		window.close();
		</script>";
		exit;
		
	}//end if($action == "save"){
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){



?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
function check_F(){

	if(document.form2.pic_num.value == "0"){
		alert("กรุณาระบุจำนวนรูป");	
		document.form2.pic_num.focus();
		return false;
	}// end if(document.form2.pic_num.value == "0"){
	
}//end function check_F(){
</script>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body>
<?	
		$sql_edit = "SELECT * FROM  tbl_checklist_kp7  WHERE idcard='$idcard' ORDER BY profile_id DESC LIMIT 1";
		$result_edit = mysql_db_query($dbname_temp,$sql_edit);
		$rs_e = mysql_fetch_assoc($result_edit);
		$profile_id = $rs_e[profile_id];
		$xsiteid = $rs_e[siteid];
		$schoolid = $rs_e[schoolid];
		$sentsecid = $rs_e[siteid];

?>
<form name="form2" method="post" action=""  enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#CCCCCC"><strong>ฟอร์มแก้ไขข้อมูลจำนวนรูปและจำนวนแผ่นเอกสาร</strong></td>
          </tr>
          <?
          $sql_sf = "SELECT user_update,user_save,time_update  FROM tbl_checklist_log where type_action='1' and idcard='$rs_e[idcard]' AND profile_id='$profile_id' ORDER BY time_update DESC LIMIT 1;";
		  $result_sf1 = mysql_db_query($dbname_temp,$sql_sf);
		  $rs_sf1 = mysql_fetch_assoc($result_sf1);
		 // echo $rs_sf1[user_update];
		  	
		  ?>
        <tr>
          <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="right" bgcolor="#FFFFFF"><strong>พนักงานที่บันทึกรายการ : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?
          	$sql_s1 = "SELECT * FROM keystaff WHERE staffid='$rs_sf1[user_save]'";
			$result_s1 = mysql_db_query($dbcallcenter_entry,$sql_s1);
			$rss1 = mysql_fetch_assoc($result_s1);
			echo "$rss1[prename]$rss1[staffname]  $rss1[staffsurname]";
		  
		  ?>  &nbsp; ปรับปรุงล่าสุด วันที่ <?=GetDateThaiFullTime($rs_sf1[time_update]);?></td>
        </tr>
        <tr>
          <td width="27%" align="center" bgcolor="#FFFFFF"><strong>หมวดรายการ </strong></td>
          <td width="25%" align="center" bgcolor="#FFFFFF"><strong>สถานะความสมบูรณ์ของเอกสาร</strong></td>
          <td width="48%" align="center" bgcolor="#FFFFFF"><strong>หมายเหตุ</strong></td>
          </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">จำนวนรูป</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="pic_num">
              <option value="0">จำนวนรูป</option>
              <?
				for($n=0;$n <= 20; $n++){
					if($rs_e[pic_num] == $n){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$n' $sel>$n</option>";
				}
			?>
              </select>
            รูป</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_pic" value="<?=$rs_e[comment_pic]?>" size="50">
            </label></td>
        </tr>
        <tr>
          <td height="35" colspan="3" align="center" valign="bottom" bgcolor="#FFFFFF">
            <input type="hidden" name="action" value="process">
            <input type="hidden" name="profile_id" value="<?=$profile_id?>">
            <input type="hidden" name="idcard" value="<?=$idcard?>">
            <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
            <input type="hidden" name="schoolid" value="<?=$schoolid?>">
            <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
            <input type="submit" name="Submit2" value="บันทึก">
            <input type="button" name="btnClose" value="ปิดหน้าต่าง" onClick="window.close()">
		</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
      </form>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
