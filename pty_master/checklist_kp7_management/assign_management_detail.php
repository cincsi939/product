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
$time_start = getmicrotime();


function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
if($xaction=="setuser"){
	unset($_SESSION['def_staff']);
	$arr=explode(",",$setuser);
	if(is_array($arr) ){
	foreach($arr as $index=>$values){
	 $_SESSION['def_staff'][$values]='ok';
		}
	}
 
}

if(is_array($_SESSION['def_staff']) ){
	foreach($_SESSION['def_staff'] as $index=>$values){	
	 if($xstr_arr!=""){$xstr_arr.=",";}
	  $xstr_arr.="'".$index."'";
	 
	}
}
//echo $xstr_arr;




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
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกกลุ่มรายการข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&staffid=<?=$staffid?>&xmode=<?=$xmode?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ประเภทกิจกรรม : </strong></td>
          <td bgcolor="#FFFFFF">
            <select name="activity_id" id="activity_id" onChange="gotourl(this)">
              <option value="">เลือกประเภทกิจกรรม</option>
              <?
            	$sql_act = "SELECT * FROM tbl_checklist_activity ORDER BY activity ASC";
				$result_act = mysql_db_query($dbname_temp,$sql_act);
				while($rsac = mysql_fetch_assoc($result_act)){
					if($rsac[activity_id] == $activity_id){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='?profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$rsac[activity_id]' $sel>$rsac[activity]</option>";
				}//end while($rsac = mysql_fetch_assoc($result_act)){
			?>
              </select>
          </td>
          </tr>
      </table>
   </td>
  </tr>
</table>
 </form>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <? if($action == ""){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#D2D2D2"><strong><a href="assign_management.php?xmode=<?=$xmode?>&action=&staffid=<?=$staffid?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>"><img src="../../images_sys/home.gif" width="20" height="20" border="0" title="กลับหน้าหลัก"></a>&nbsp;รายการมอบหมายงานของ <?=show_user($staffid);?><?=ShowDateProfile($profile_id)?>&nbsp;<? echo "(".ShowActivity($activity_id).")";?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="30%" align="center" bgcolor="#D2D2D2"><strong>รหัสมอบหมายงาน</strong></td>
        <td width="15%" align="center" bgcolor="#D2D2D2"><strong>จำนวนบุคลากรในใบงาน</strong></td>
        <td width="16%" align="center" bgcolor="#D2D2D2"><strong>วันที่มอบหมายงาน</strong></td>
        <td width="16%" align="center" bgcolor="#D2D2D2"><strong>วันที่กำหนดส่งใบงาน</strong></td>
        <td width="18%" align="center" bgcolor="#D2D2D2"><strong>สถานะการตรวจงาน</strong></td>
        </tr>
      <?
	  	$arrnum = CountScanDetail($staffid);// นับจำนวนเอกสารที่มอบหมายงาน
		//echo "<pre>";
		//print_r($arrnum);
     	$sql = "SELECT * FROM `tbl_checklist_assign` WHERE staffid='$staffid' AND activity_id='$activity_id' ORDER BY date_assign DESC  ;";
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		
	 ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[ticketid]";?></td>
        <td align="center"><? 
		if($arrnum[$rs[ticketid]] > 0){
				echo "<a href='assign_management_detail.php?ticketid=$rs[ticketid]&staffid=$rs[staffid]&profile_id=$profile_id&action=detail&activity_id=$activity_id'>".$arrnum[$rs[ticketid]]."</a>";
		}else{
				echo "0";	
		}//end if($arrnum[$rs[staffid]] > 0){
		?></td>
        <td align="center"><?=thai_date($rs[date_assign])?></td>
        <td align="center"><?=thai_date($rs[date_sent]);?></td>
        <td align="center"><?=ShowIconAssign($rs[approve]);?></td>
        </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <? }//end if($action == ""){
	if($action == "detail"){	  
?>
    <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#D2D2D2"><strong><a href="?xmode=<?=$xmode?>&action=&staffid=<?=$staffid?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>"><img src="../../images_sys/home.gif" width="20" height="20" border="0" title="กลับหน้าหลัก"></a>&nbsp;รหัสใบงาน <?=$ticketid?> ของ <?=show_user($staffid);?><?=ShowDateProfile($profile_id)?>&nbsp;<? echo "(".ShowActivity($activity_id).")";?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="21%" align="center" bgcolor="#D2D2D2"><strong>เลขบัตรประชาชน</strong></td>
        <td width="31%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="28%" align="center" bgcolor="#D2D2D2"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="15%" align="center" bgcolor="#D2D2D2"><strong>จำนวนแผ่นเอกสาร</strong></td>
      </tr>
      <? 
	  	$arrpage = CountPagePerPerson($ticketid,$profile_id);
	  	$sql_detail = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' ORDER BY name_th ASC";
		$result_detail = mysql_db_query($dbname_temp,$sql_detail);
		$i=0;
		while($rsd = mysql_fetch_assoc($result_detail)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rsd[idcard]?></td>
        <td align="left"><? echo "$rsd[prename_th]$rsd[name_th] $rsd[surname_th]";?></td>
        <td align="left"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($rsd[siteid]));?></td>
        <td align="center"><? 
		echo $arrpage[$rsd[idcard]];
		
		?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($xmode == "1"){	

  ?>

</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
