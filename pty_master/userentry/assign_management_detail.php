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

##########  บันทึกการตรวจสอบเอกสาร
$arr_problem = show_problem(); // รายการปัญหาทั้งหมด
if($action == "process"){
	$file_path = "../../../checklist_kp7file/$sentsecid/";
	$xpathfile = "../../../checklist_kp7file/$sentsecid/$idcard/";
	if(!is_dir($file_path)){
			xRmkdir($file_path);
	}
	
//	echo "upload file :: <br>";
//	echo "<pre>";
//	print_r($_POST);
//	echo "<pre>";
//	print_r($_SESSION);
//	echo "<br>";
//	echo "file_name  :: ".$kp7_file_name."<br>";
	###  ทำการ upload file
		if($kp7_file_name != ""){		

			if(!is_dir($xpathfile)){
				xRmkdir($xpathfile);
			}

			$xd = sw_dateE($date_upload);
			$upload		= upload($xpathfile, $kp7_file, $kp7_file_name,"doc",$idcard,$xd);		
			$msg 		= upload_status($upload[0]);
			$xpfile = $xpathfile.$idcard."_".$xd.".pdf";
			//echo "file :: ".$xpfile;
			

				if(file_exists($xpfile)){			
				$sql_logup = "REPLACE INTO tbl_checklist_log_uploadfile SET idcard='$idcard',siteid='$sentsecid',schoolid='$schoolid',numpage='$page_num',numpic='$pic_num',date_upload='".sw_dateE($date_upload)."',kp7file='$xpfile',user_update='$user_check',user_save='".$_SESSION['session_staffid']."',profile_id='$profile_id',time_update=NOW()";
				//echo $sql_logup;
				mysql_db_query($dbname_temp,$sql_logup);	
				}//end if(file_exists($xpfile)){	
	
			
			//echo "xxxxxxxxxxx".die;
		}//end if($kp7_file_name != ""){		

		
		

		//echo $filedb;die;
	### end medki upload file
$check_file = "$file_path".$idcard.".pdf";
//echo "<a href='$check_file'>file</a>";
if(is_file($check_file)){
	$temp_page = CountPageSystem($xpfile);

}else{
	$temp_page = "";
}

//echo "<br>page == $temp_page";die;
//echo "<pre>";
//print_r($_POST);die;
	$sql_count = "SELECT COUNT(menu_id) as num1 FROM tbl_check_menu";
	$result_count = mysql_db_query($dbname_temp,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	$num_menu = $rs_c[num1]; // จำนวนทั้งหมดของรายการ
	###  จำนวนเมนูรายการทั้งหมดที่ตรวจสอบ
	$sql = "SELECT * FROM tbl_check_menu ORDER BY menu_id ASC ";
	$result = mysql_db_query($dbname_temp,$sql);
	$check_i = 0;
	while($rs = mysql_fetch_assoc($result)){
		if($$rs[field_name] == "1"){
			$check_i++;
			### ทำการล้างปัญหาเมื่อทำการ
			$sql_update_problem = "UPDATE tbl_checklist_problem_detail SET status_problem='1',profile_id='$profile_id' WHERE idcard='$idcard' AND menu_id='$rs[menu_id]' AND profile_id='$profile_id'";
			mysql_db_query($dbname_temp,$sql_update_problem);
			
		}else{
			##  ทำการลบรายการปัญหาก่อนทำการสร้างใหม่
				$sql_del = "DELETE FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND menu_id='$rs[menu_id]' AND profile_id='$profile_id'";
				$result_del = mysql_db_query($dbname_temp,$sql_del);
			## end ทำการลบรายการปัญหาก่อนทำการสร้างใหม่
			foreach($arr_problem as $k => $v){
				if($check_problem[$idcard][$rs[menu_id]][$k] != ""){
					$sql_problem = "REPLACE INTO tbl_checklist_problem_detail(idcard,problem_id,menu_id,problem_detail,status_problem,profile_id)VALUE('".$idcard."','".$k."','".$rs[menu_id]."','".$problem_detail[$idcard][$rs[menu_id]][$k]."','0','$profile_id')";
					$result_problem = mysql_db_query($dbname_temp,$sql_problem);
					//echo "$sql_problem<hr>";
				}//end if($check_problem[$idcard][$rs[menu_id]][$k] != ""){
			}//end foreach($arr_problem as $k => $v){
		}//end if($$rs[field_name] == "1"){
		$update_value .= ",$rs[field_name]='".$$rs[field_name]."'";
	}//end while($rs = mysql_fetch_assoc($result)){
	## ตรวจสอบว่ารายการทั้งหมดสมบูรณ์หรือยัง
	
	if($cls_usercheck == "1"){  // กรณีต้องการล้างข้อมูลคนตรวจเอกสาร
		$sql_del1 = "DELETE FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND profile_id='$profile_id'";
		mysql_db_query($dbname_temp,$sql_del1);
		$val_statusfile = "0";
		$con_file = ", status_check_file='NO',mainpage=NULL ,mainpage_comment=NULL , status_numfile=NULL ,pic_num=NULL,page_num=NULL";
	}else{
		if($page_num == "0" and  $pic_num == "0"){
			$con_file = ", status_check_file='NO'";	
		}else{
			$con_file = ", status_check_file='YES'";	
		}
		$val_statusfile = "1";
	}// end 	if($cls_usercheck == "1"){

	if($check_i == $num_menu){ $sql_status_file = " ,status_file='$val_statusfile'";}else{ $sql_status_file = " ,status_file='0'";}
	## select เพื่อตรวจสอบข้อมูล
	
	
	$sql_update = "UPDATE tbl_checklist_kp7 SET profile_id='$profile_id',page_num='$page_num', type_doc='$type_doc',mainpage='$mainpage',mainpage_comment='$mainpage_comment',pic_num='$pic_num',comment_pic='$comment_pic',status_numfile='$status_numfile'  $sql_status_file $update_value $con_file WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id' ";
	//echo $sql_update;die;
	$result_update = mysql_db_query($dbname_temp,$sql_update);
	if($kp7_file_name != ""){
		if($temp_page == "0"){
				$xmsg = "เกิดข้อผิดพลาดไม่สามารถนับจำนวนหน้าในระบบได้";	
		}else{
			if($page_num != $temp_page){
				$xmsg = "จำนวนแผ่นที่ตรวจสอบกับไฟล์ที่อยู่ในระบบจำนวนหน้าไม่เท่ากัน";	
			}else{
				$xmsg = "";	
			}
		}
	}else{
		$xmsg = "";	
	}//end if($kp7_file_name != ""){
		
	if($extra == "1"){ // มาจากการเปิดหน้าต่างการแก้ไขข้อมูลจำนวนแผ่นไม่เจอ report_page_no_math.php?sentsecid=6502
		if($result_update){
		echo "<script>alert(\" บันทึกข้อมูลเรียบร้อยแล้ว \");opener.document.location.reload();window.close();</script>";
		exit;
		}else{
			echo "<script>alert(' !ไม่สามารถบันทึกข้อมูลได้');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}
	}else{
	if($result_update){
			if($cls_usercheck == "1"){ // แสดงว่าต้องการล้างค่าพนักงานตรวจสอบเอกสาร
					$sql_up1 = "UPDATE tbl_checklist_log SET type_action='2' WHERE type_action='1' AND idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id' ";
					@mysql_db_query($dbname_temp,$sql_up1);
			}else{
				insert_log_import($sentsecid,$idcard,"บันทึกตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ","1",$user_check);
			}//end if($cls_usercheck == "1"){
		if($msg != ""){
		echo "<script>alert(\" ไม่สามารถuploadไฟล์ต้นฉบับได้ <br>
$msg \");location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}else{
		echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยแล้ว $xmsg\");location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
		}//end if($msg != ""){
	}else{
		echo "<script>alert(' !ไม่สามารถบันทึกข้อมูลได้');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
	}//end 	if($result_update){
	}//end if($extra == "1"){
	


}//end if($action == "process"){

#######  ลบข้อมูล
if($action == "DEL"){
	$file_path = "../../../checklist_kp7file/$sentsecid/";
	$xfile = $file_path.$idcard.".pdf";
		if(is_file($xfile)){
			@unlink($xfile);	
		}
	$sql_del = "DELETE FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND siteid='$sentsecid' AND profile_id='$profile_id'";
	$result_del = mysql_db_query($dbname_temp,$sql_del);
	insert_log_import($sentsecid,$idcard,"ลบข้อมูลในchecklist","1");
	if($result_del){
		echo "<script>alert('ลบรายการเรียบร้อยแล้ว');location.href='check_kp7_area.php?sentsecid=$sentsecid&lv=1&xsiteid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
		exit;
	}
	
}//end if($action == "DEL"){

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
              <option value="">เลือกประเำภทกิจกรรม</option>
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
