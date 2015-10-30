<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_lock_area"; 
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
include("send_mail/func_send_mail.php");
$time_start = getmicrotime();

function CountPerson($profile_id){
global $dbname_temp;
if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
	$profile_id = LastProfile();
}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
	$sql_count = "SELECT COUNT(idcard) AS numC,siteid FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' group by siteid";
	//echo $sql_count."<br>";
	$result_count = mysql_db_query($dbname_temp,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$arr[$rs_c[siteid]]	 = $rs_c[numC];
	}
	return $arr;
}

//function SaveLockArea($get_siteid){
//	global $dbname_temp;	
//	$sql_check = "SELECT COUNT(siteid) AS numsite FROM tbl_status_unlock_site WHERE siteid='$get_siteid' ";
//	$result_check = mysql_db_query($dbname_temp,$sql_check);
//	$rs_ch = mysql_fetch_assoc($result_check);
//	if($rs_ch[numsite] < 1){
//			$sql_save = "INSERT INTO tbl_status_unlock_site SET siteid='$get_siteid'";
//			$result_save = mysql_db_query($dbname_temp,$sql_save);
//	}//end if($rs_ch[numsite] < 1){
//}//end function SaveLockArea($get_secid){




if($_SERVER['REQUEST_METHOD'] == "POST"){
		if(count($ch_area) > 0){
		foreach($ch_area as $k1 => $v1){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'$v1'";
			
				
		}
		}//end if(count($ch_area) > 0){
			if($in_id != ""){ $conv = " AND siteid NOT IN($in_id) ";}else{ $conv = "";}
			
		$sql_del = "DELETE FROM tbl_status_unlock_site WHERE profile_id='$profile_id' $conv ";
		//echo $sql_del;die;
		mysql_db_query($dbname_temp,$sql_del);
			//echo $in_id;die;
		
		$cdate = date("Y-m-d");
		//echo "<pre>";
		//print_r($ch_area);die;
		
		if(count($ch_area) > 0){
				foreach($ch_area as $k => $v){
					$sql_1 = "SELECT count(siteid) as num1 FROM tbl_status_unlock_site WHERE siteid='$v' AND profile_id='$profile_id'";
					$result_1 = mysql_db_query($dbname_temp,$sql_1);
					$rs_1 = mysql_fetch_assoc($result_1);
					if($rs_1[num1] > 0){
						$sql_in = "INSERT INTO tbl_status_unlock_site SET siteid='$v', status_unlock='1',profile_id='$profile_id'";
						mysql_db_query($dbname_temp,$sql_in);
					}else{
						$sql_in = "INSERT INTO tbl_status_unlock_site SET siteid='$v', status_unlock='1',profile_id='$profile_id',timeupdate=NOW()";
						mysql_db_query($dbname_temp,$sql_in);	
					}//end if($rs_1[num1] > 0){
						
						$sqlinsert = "INSERT INTO tbl_status_unlock_site_log SET siteid='$v' ,staffid='".$_SESSION[session_staffid]."',profile_id='$profile_id',timeupdate=NOW() ";
						mysql_db_query($dbname_temp,$sqlinsert);
				}//end foreach($ch_area as $k => $v){
		}//end 	if(count($ch_area) > 0){

			echo "<script>location.href='?profile_id=$profile_id';</script>";
		exit;		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
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
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" align="left" bgcolor="#9FB3FF"><strong>เครื่องมือในการปลดเครื่องหมาย <font color="#006600">*</font> หลังชื่อหน่วยงานเป็นเขตที่ทำการตรวจสอบเอกสารทุกฉบับที่ได้รับจากทางเขตแล้ว  </strong></td>
              </tr>
            <tr>
              <td width="5%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
              <td width="38%" align="center" bgcolor="#9FB3FF"><strong>สำนักงานเขตพื่นที่การศึกษา</strong></td>
              <td width="28%" align="center" bgcolor="#9FB3FF"><strong>จำนวนรายการทั้งหมด(คน)</strong></td>
              <td width="15%" align="center" bgcolor="#9FB3FF"><strong>คลิ๊กเพื่อปลดการตรวจสอบข้อมูลเสร็จสิ้น</strong></td>
              </tr>
            <?
		
				$sql = "SELECT eduarea.secid, eduarea.secname,
				if(substring(eduarea.secid,1,1) ='0',cast(eduarea.secid as SIGNED),9999) as idsite
				 FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata'  AND profile_id='$profile_id' ORDER BY idsite,eduarea.secname ASC";
				$result = mysql_db_query($dbnamemaster,$sql);
				$i=0;
				$arr1 = CountPerson($profile_id);
				while($rs = mysql_fetch_assoc($result)){
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				 $sql_count1 = "SELECT COUNT(siteid) AS num1 FROM tbl_status_unlock_site WHERE siteid='$rs[secid]' AND profile_id='$profile_id'";
				 $result_count1 = mysql_db_query($dbname_temp,$sql_count1);
				 $rs_c1 = mysql_fetch_assoc($result_count1);
				 if($rs_c1[num1] > 0){ $chk = "checked";}else{ $chk = "";}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);?></td>
              <td align="center"><?=number_format($arr1[$rs[secid]]);?></td>
              <td align="center"><label>
                <input type="checkbox" name="ch_area[<?=$rs[secid]?>]" value="<?=$rs[secid]?>" <?=$chk?>>
              </label></td>
              </tr>
            <?
				}//end 
			?>
            <tr>
              <td colspan="3" align="left" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF"><label>
              <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                <input type="submit" name="button" id="button" value="บันทึก">
                &nbsp;
                <input type="reset" name="button2" id="button2" value="ล้างข้อมูล">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>