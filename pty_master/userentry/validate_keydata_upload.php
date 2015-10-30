<?
set_time_limit(0);
session_start();
include ("../../../../config/conndb_nonsession.inc.php")  ;
require_once("../../../../common/function_upload_kp7file_qc.php"); 
require_once("../../../checklist_kp7_management/function_check_xref.php");
include('function.inc_v1.php') ;
$path_file = "../../../../../kp7file_qc/";

if($_SESSION[session_staffid] == ""){
		echo "<script>alert('กรุณา login ใหม่อีกครั้ง'); location.href='../../../userentry/login.php';</script>";
		exit;
}//end 

function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){
	
	
function CheckSubData($get_parent){
	global $db_name;
	$sql_c = "SELECT COUNT(parent_id) AS numData FROM validate_datagroup WHERE parent_id='$get_parent'";
	$result_c = mysql_db_query($db_name,$sql_c);
	$rs_c = mysql_fetch_assoc($result_c);
	return $rs_c[numData];
}//end function CheckSubData(){

function GetSiteID($idcard){
	global $dbnamemaster;
		$sql = "SELECT siteid FROM view_general WHERE CZ_ID='$idcard'";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[siteid];
}// end function GetSiteID($idcard){

$TicketID = GetTicketId($idcard,$staffid); // หารหัสใบมอบหมายงาน



	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$path_file = $path_file.$TicketID."/"; // path ปลายทาง
		if($kp7file_name != ""){
			$get_siteid = GetSiteID($idcard);
			$result_upload = UploadKp7fileQC($kp7file,$kp7file_name,$idcard,$path_file,$get_siteid,$staffid,$TicketID,$comment_upload);
		}//end if($kp7file_name != ""){
	
	//echo "UPLOAD PASS :: $result_upload";die;
	
		$sql_admin = "DELETE FROM alert_qc_admin WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID'";
		@mysql_db_query($db_name,$sql_admin);
		if($sent_admin == 1){
			$sql_replace = "REPLACE INTO alert_qc_admin SET idcard='$idcard', staffid='$staffid',ticketid='$TicketID',staff_qc='$qc_staffid'";	
			@mysql_db_query($db_name,$sql_replace);
		}
		
//		echo "<pre>";
//		print_r($_POST);
//		echo "ข้อมูล <br>";
//		print_r($chData);
//		die;
//				
		####  update ตัวข้อมูลที่สุ่มมา QC
		$sql_up_qc = "UPDATE stat_user_keyperson SET status_random_qc='1' WHERE idcard='$idcard' AND staffid='$staffid'";
		mysql_db_query($db_name,$sql_up_qc);
		
		#### บันทึกการ approve การ assign งาน
		//ApproveAssign($idcard,$flag_qc,$staffid);
		
		#update flag_qc ที่ทำการ qc ไปแล้ว
		$sql_update_temp = "UPDATE stat_user_person_temp SET qc_pass='1',status_qc='1'   WHERE flag_id='$flag_qc' AND staffid='$staffid'";
		mysql_db_query($dbnameuse,$sql_update_temp);
		
		
		
		#### end  UPDATE  สุ่ม QC		
		
		$sql_data = "SELECT *  FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' AND  result_check='0' and status_cal='1'";
		$result_data = mysql_db_query($db_name,$sql_data);
		while($rsd = mysql_fetch_assoc($result_data)){
				if($qc_date == ""){
					$xqc_date = $rsd[qc_date];
				}else{
					$xqc_date = DateSaveDB($qc_date);
				}//end 	if($qc_date == ""){

			
			$ArrWhere[] = " UPDATE validate_checkdata SET status_cal='$rsd[status_cal]', datecal='$rsd[datecal]',date_check='$rsd[date_check]',qc_date='".$xqc_date."' WHERE idcard='$rsd[idcard]' AND staffid='$rsd[staffid]' AND ticketid='$rsd[ticketid]' AND checkdata_id='$rsd[checkdata_id]'";
				
		}//end 	while($rsd = mysql_fetch_assoc($result_data)){
	
		if(count($chData) > 0){
			
			
			###  end กรณีมีการ qc ข้อมูลไปแล้วให้เอาวันที่ QC ครั้งแรกมาบันทึกข้อมูล
			## ลบข้อมูลก่อนทำการบันทึก
			$sql_del = "DELETE FROM validate_checkdata WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' ";
			mysql_db_query($db_name,$sql_del);
			## เริ่มทำการบันทึกข้ัอมูลใหม่
			foreach($chData as $k1 => $v1){
				if($qc_date == ""){
					$xqc_date = date("Y-m-d");
				}else{
					$xqc_date = DateSaveDB($qc_date);
				}//end 	if($qc_date == ""){
					
					if($num_point[$v1] < 1){
						$xnum_point = 1;		
					}else{
						$xnum_point = $num_point[$v1];	
					}
	
			$sql_rep = "REPLACE INTO validate_checkdata SET idcard='$idcard',staffid='$staffid', num_point='$xnum_point', checkdata_id='$v1',ticketid='$TicketID', staffid_check='".$_SESSION['session_staffid']."', date_check='".date("Y-m-d")."',timeupdate=NOW(),result_check='0',qc_staffid='$qc_staffid', qc_date='$xqc_date',datetime_check='".date("Y-m-d H:i:s")."'";
			$result_rep = mysql_db_query($db_name,$sql_rep);
			}//end 	foreach(){
				if($result_rep){
		
		############  คำนวณคะแนน QC
		CalSubtractQc($idcard); // คำนวนคะแนนผลการ QC
		$xdate1 = ShowYYMMKey($idcard,$staffid);
		$arrd = explode("-",$xdate1);
		$yymm = $arrd[0]."-".$arrd[1];
		$arrd1 = ShowSdateEdate($xdate1);
		$xsdate = $arrd1['start_date'];
		$xedate = $arrd1['end_date'];
		// คำนวณค่าเฉลี่ย
			$sql_avg = "SELECT * FROM stat_subtract_keyin  WHERE datekey LIKE '$xdate1%'  and staffid='$staffid' ";
			//echo $sql_avg."<br>";
			$result_avg = mysql_db_query($dbnameuse,$sql_avg);
			$rsa = mysql_fetch_assoc($result_avg);
			if($rsa[spoint] == 0 or $rsa[spoint] == ""){ $spoint = intval($rsa[spoint]);}else{ $spoint = $rsa[spoint];}
			$sql_save = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p,sdate,edate) VALUES('$staffid','$xdate1','$spoint','1','$xsdate','$xedate')";
			//echo $sql_save;
			@mysql_db_query($dbnameuse,$sql_save);
	##### ทำการบันทึกค่าคะแนนที่ QC ได้
						echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); location.href='?idcard=$idcard&TicketID=$TicketID&staffid=$staffid&fullname=$fullname&staffname=$_GET[staffname]&xsiteid=$xsiteid&flag_qc=$flag_qc';</script>";
				}
		}else if($checkTrue == 1){
			$sql_del = "DELETE FROM validate_checkdata WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' ";
			mysql_db_query($db_name,$sql_del);
			
				if($qc_date == ""){
					$xqc_date = date("Y-m-d");
				}else{
					$xqc_date = DateSaveDB($qc_date);
				}//end 	if($qc_date == ""){
					
					if($num_point[$v1] < 1){
						$xnum_point = 1;		
					}else{
						$xnum_point = $num_point[$v1];	
					}

			## เริ่มทำการบันทึก
			$sql_rep = "INSERT INTO validate_checkdata SET idcard='$idcard',staffid='$staffid', num_point='$xnum_point',checkdata_id='$v1',ticketid='$TicketID', staffid_check='".$_SESSION['session_staffid']."', date_check='".date("Y-m-d")."',timeupdate=NOW(),result_check='1',qc_staffid='$qc_staffid', qc_date='$xqc_date',datetime_check='".date("Y-m-d H:i:s")."'";
			$result_rep = mysql_db_query($db_name,$sql_rep);
			if($result_rep){
		############################################  คำนวณคะแนน QC
		CalSubtractQc($idcard); // คำนวนคะแนนผลการ QC
		$xdate1 = ShowYYMMKey($idcard,$staffid);
		$arrd = explode("-",$xdate1);
		$yymm = $arrd[0]."-".$arrd[1];
		$arrd1 = ShowSdateEdate($xdate1);
		$xsdate = $arrd1['start_date'];
		$xedate = $arrd1['end_date'];
		// คำนวณค่าเฉลี่ย
			$sql_avg = "SELECT * FROM stat_subtract_keyin  WHERE datekey LIKE '$xdate1%'  and staffid='$staffid' ";
			//echo $sql_avg."<br>";
			$result_avg = mysql_db_query($dbnameuse,$sql_avg);
			$rsa = mysql_fetch_assoc($result_avg);
			if($rsa[spoint] == 0 or $rsa[spoint] == ""){ $spoint = intval($rsa[spoint]);}else{ $spoint = $rsa[spoint];}
			$sql_save = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p,sdate,edate) VALUES('$staffid','$xdate1','$spoint','1','$xsdate','$xedate')";
			//echo $sql_save;
			@mysql_db_query($dbnameuse,$sql_save);
	##### ทำการบันทึกค่าคะแนนที่ QC ได้

					echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); location.href='?idcard=$idcard&TicketID=$TicketID&staffid=$staffid&fullname=$fullname&staffname=$_GET[staffname]&xsiteid=$xsiteid&flag_qc=$flag_qc';</script>";
					
			}
				
		}else{
			$sql_del = "DELETE FROM validate_checkdata WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' ";
			mysql_db_query($db_name,$sql_del);
			
					############  คำนวณคะแนน QC
		CalSubtractQc($idcard); // คำนวนคะแนนผลการ QC
		$xdate1 = ShowYYMMKey($idcard,$staffid);
		$arrd = explode("-",$xdate1);
		$yymm = $arrd[0]."-".$arrd[1];
		$arrd1 = ShowSdateEdate($xdate1);
		$xsdate = $arrd1['start_date'];
		$xedate = $arrd1['end_date'];
		// คำนวณค่าเฉลี่ย
			$sql_avg = "SELECT * FROM stat_subtract_keyin  WHERE datekey LIKE '$xdate1%'  and staffid='$staffid' ";
			//echo $sql_avg."<br>";
			$result_avg = mysql_db_query($dbnameuse,$sql_avg);
			$rsa = mysql_fetch_assoc($result_avg);
			if($rsa[spoint] == 0 or $rsa[spoint] == ""){ $spoint = intval($rsa[spoint]);}else{ $spoint = $rsa[spoint];}
			$sql_save = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p,sdate,edate) VALUES('$staffid','$xdate1','$spoint','1','$xsdate','$xedate')";
			//echo $sql_save;
			@mysql_db_query($dbnameuse,$sql_save);
	##### ทำการบันทึกค่าคะแนนที่ QC ได้

		echo "<script>location.href='?idcard=$idcard&TicketID=$TicketID&staffid=$staffid&fullname=$fullname&staffname=$_GET[staffname]&xsiteid=$xsiteid&flag_qc=$flag_qc';</script>";
			}//end if(count($chData) > 0){

			##########  เก็บข้อมูลเก่าที่นำค่าคะแนนไปคำนวณแล้วจะไม่ทำการนำไปคำนวณอีก
			if(count($ArrWhere) > 0){
				foreach($ArrWhere as $xkey => $xval){
					@mysql_db_query($db_name,$xval);
				}// end 	foreach($ArrWhere as $xkey => $xval){
			}// end if(count($ArrWhere) > 0){
			########### end เก็บข้อมูลเก่าที่นำค่าคะแนนไปคำนวณแล้วจะไม่ทำการนำไปคำนวณอีก
			
			
			
	}//end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script language="javascript">

function CheckF1(){
	if(document.form1.kp7file.value != "" && document.form1.comment_upload.value == "" ){
		alert("กรณีเลือกไฟล์แนบผลการ QC เอกสาร ก.พ.7 ให้ระบุหมายเหตุด้วย");
		document.form1.comment_upload.focus();
		return false;
			
	}	
	return true;
} 

	function UncheckTrue(){
		var xi = document.form1.xch.value;
		if( xi > 0){
				for(i=0;i<xi; i++){
					document.getElementById("chData"+i).checked = false;
				}
		}//end if( xi > 0){
		
	}
	
function showEle(divname){
	if(document.getElementById(divname).style.display == 'none'){
		document.getElementById(divname).style.display = 'block';
	} else {  
		document.getElementById(divname).style.display = 'none';
	}
}
</script>


</head>
<body>
<?
	$sql_check = "SELECT * FROM validate_checkdata WHERE idcard='$idcard' AND staffid='$staffid'";
	$result_check = mysql_db_query($db_name,$sql_check);
	$rs_check = mysql_fetch_assoc($result_check);
	
	$sql_qc = "SELECT *  FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' AND qc_date <> '0000-00-00' ORDER BY qc_date DESC ";
	$result_qc = mysql_db_query($db_name,$sql_qc);
	$rs_qc = mysql_fetch_assoc($result_qc);
	$date_qc = DateView($rs_qc[qc_date]);
	
	$pathfile = "../../../../../edubkk_kp7file/$xsiteid/$idcard".".pdf";
	
	$dbsite = STR_PREFIX_DB.$xsiteid;
	$xstrSql = "SELECT id,idcard,prename_th,name_th,surname_th, siteid,schoolid, position_now FROM general WHERE id='$idcard'";
	$xresult = mysql_db_query($dbsite,$xstrSql);
	$xrs = mysql_fetch_assoc($xresult);
	
	$sql_qc1 = "SELECT *  FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' LIMIT 0,1";
	$result_qc1 = mysql_db_query($db_name,$sql_qc1);
	$rs_qc1 = mysql_fetch_assoc($result_qc1);
	$key_staffid = $rs_qc1[qc_staffid];
	
	$sql_keydata = "SELECT timestamp_key FROM monitor_keyin WHERE idcard='$idcard' AND staffid='$staffid'";
	$result_keydata = mysql_db_query($db_name,$sql_keydata);
	$rsd1 = mysql_fetch_assoc($result_keydata);
	$datekeydata = DateThai($rsd1[timestamp_key],"FULL");
	$datekeydata1 = DateThai($rsd1[timestamp_key]);
?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return CheckF1();">
  <br />
  <table width="95%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td align="left"><img src="../../../validate_management/images/book_open.png" width="16" height="16" />&nbsp;<b>บันทึกผลการตรวจสอบการคีย์ข้อมูลของพนักงาน ชื่อ</b> <?=$_GET["staffname"]?>  <strong>วันที่คีย์ข้อมูล : <? echo $datekeydata; ?></strong></td>
            </tr>
            <tr>
              <td align="left"><b>ข้อมูลของ :</b> <?=$fullname?>&nbsp;<b>รหัสบัตรประชาชน :</b><?=$idcard?> 
</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;<? echo "<a href='login_data.php?xname_th=$xrs[name_th]&xsurname_th=$xrs[surname_th]&xidcard=$xrs[idcard]&action=login&xsiteid=$xrs[siteid]' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" border="0" alt="คลิ๊กเพื่อ login เข้าสู่ระบบ"><? echo "</a>";?>&nbsp;&nbsp;<? if(is_file($pathfile)){?><a href="<?=$pathfile?>" target="_blank"><img src="../../../../images_sys/gnome-mime-application-pdf.png" width="20" height="21" alt="ตรวจสอบไฟล์ pdf ต้นฉบับ" border="0"></a><? } ?>&nbsp;<a href="../../hr_report/report_check/report_check_data.php?idcard=<?=$idcard?>&siteid=<?=$xsiteid?>&xtype=validate" target="_blank"><img src="../../../validate_management/images/zoom.png" width="16" height="16" / border="0" alt="หน้ารายงานเทียบ label กับ value"></a></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                    <? if($date_qc != "0000-00-00" and $date_qc != ""){ $qc_date = $date_qc;}?>
                      <td width="26%" align="right">วันที่ QC : </td>
                      <td width="39%" align="left"><INPUT name="qc_date" onFocus="blur();" value="<?=$qc_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.qc_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
                      <td width="35%" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right">พนักงาน QC : </td>
                      <td align="left"><select name="qc_staffid" id="qc_staffid">
            <option value="">เลือกชื่อพนักงานQC</option>
            <?
            	$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES' AND sapphireoffice='0' AND (status_extra = 'QC' or status_extra='QC_WORD') ORDER BY staffname ASC";
				$result_staff = mysql_db_query($db_name,$sql_staff);
				while($rs_staff = mysql_fetch_assoc($result_staff)){
					if($rs_staff[staffid] == $key_staffid){ $sel = "selected='selected'";}else{ $sel = "";}
					$staffname = "$rs_staff[prename]$rs_staff[staffname]  $rs_staff[staffsurname]";
					echo "<option value='$rs_staff[staffid]' $sel>$staffname</option>";
						
				}
			?>
            </select></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <?
                   $sql_ad =  "SELECT COUNT(idcard)  AS numad FROM alert_qc_admin WHERE idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID'";
				   $result_ad = mysql_db_query($db_name,$sql_ad);
				   $rsad = mysql_fetch_assoc($result_ad);
					?> 
                    <tr>
                      <td colspan="3" align="left"><em>หมายเหตุ : ค่าคะแนนความผิดพลาดของการคีย์ข้อมูลที่ท่าน QC จะเป็นของวันที่ <? echo $datekeydata1; ?> หากเดือนที่ท่าน QC เป็นคนละเดือนกับที่คีย์ข้อมูลกรุณาแจ้งผู้ดูแลระบบเนื่องจากจะมีผลการการคำนวณค่า Incentive</em> &nbsp; คลิ๊กเลือกเพื่อแจ้งผู้ดูแลระบบ 
                        <input type="checkbox" name="sent_admin" id="sent_admin" value="1" <? if($rsad[numad] > 0){ echo "checked='checked'";}?> ></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#F4F4F4"><strong>ลำดับ</strong></td>
              <td width="49%" align="center" bgcolor="#F4F4F4"><strong>หมวดรายการ</strong></td>
              <td width="15%" align="center" bgcolor="#F4F4F4"><strong>จำนวนจุดผิด</strong></td>
              <td width="32%" align="center" bgcolor="#F4F4F4"><strong>ประเภทปัญหา</strong></td>
            </tr>
            <?
            	$sql = "SELECT * FROM validate_datagroup WHERE parent_id='0'";
				$result = mysql_db_query($db_name,$sql);
				$i=0;
				$j=0;
				while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left">
                <?=$rs[dataname]?></td>
              <td align="center">&nbsp;</td>
              <td align="left"><?
              	//echo GetMistaken($rs[mistaken_id]);
			  ?></td>
            </tr>
            <?
					$sql1 = "SELECT * FROM validate_datagroup WHERE parent_id='$rs[checkdata_id]'";
					$result1 = mysql_db_query($db_name,$sql1);
					$num1 = @mysql_num_rows($result1);
					if($num1 > 0){
						$ii=0;
						while($rs1 = mysql_fetch_assoc($result1)){
							if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								$sqlc = "SELECT COUNT(idcard) AS numc FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND checkdata_id='$rs1[checkdata_id]' AND ticketid='$TicketID'";
								$resultc = mysql_db_query($db_name,$sqlc);
								$rsc = mysql_fetch_assoc($resultc);
								
								$xsqlc2 = "SELECT * FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND checkdata_id='$rs1[checkdata_id]' AND ticketid='$TicketID' ";
								$xresultc2 = mysql_db_query($db_name,$xsqlc2);
								$xrsc2 = mysql_fetch_assoc($xresultc2);
								//echo $sqlc."<br>";
								if($rsc[numc] > 0){ $chk1 = "checked='checked'";}else{ $chk1 = "";}
								echo "<tr bgcolor='$bg'>";
								echo "<td align='center'>&nbsp;</td>";
									if(CheckSubData($rs1[checkdata_id]) > 0){
										echo "<td align='left'>&nbsp;&nbsp;<b>$rs1[dataname]  <a  href=\"#\" onClick=\"showEle('xshow')\">ซ่อน/แสดง</a></b><br>";
										echo "<div id='xshow' style=\"display:block;\">";
										echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
										echo "<tr><td width='10%'>&nbsp;</td><td width='90%' bgcolor='#000000'>";
									echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
										$sql_sub = "SELECT * FROM  validate_datagroup WHERE parent_id='$rs1[checkdata_id]'";
										$result_sub = mysql_db_query($db_name,$sql_sub);
										$jj=0;
										while($rs_sub = mysql_fetch_assoc($result_sub)){
											$sqlc1 = "SELECT COUNT(idcard) AS numc1 FROM validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND checkdata_id='$rs_sub[checkdata_id]' AND ticketid='$TicketID'";
											$resultc1 = mysql_db_query($db_name,$sqlc1);
											$rsc1 = mysql_fetch_assoc($resultc1);
											
											$sqlc2 = "SELECT * FROM  validate_checkdata  WHERE idcard='$idcard' AND staffid='$staffid' AND checkdata_id='$rs_sub[checkdata_id]' AND ticketid='$TicketID' ";
											$resultc2 = mysql_db_query($db_name,$sqlc2);
											$rsc2 = mysql_fetch_assoc($resultc2);
											//echo $sqlc1."<br>";
											if($rsc1[numc1] > 0){ $chk2 = " checked='checked'";}else{ $chk2 = "";}
												if ($jj++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
										  echo "<tr bgcolor='$bg'>";
											echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"chData[]\" id=\"chData$j\" value='$rs_sub[checkdata_id]' $chk2>&nbsp;$rs_sub[dataname]</td>";
											echo "<td><input name=\"num_point[$rs_sub[checkdata_id]]\" type=\"text\" id=\"num_point$j\" size=\"10\" maxlength=\"4\" value='$rsc2[num_point]'></td>";
											echo "<td>".GetMistaken($rs_sub[mistaken_id])."</td>";
										  echo "</tr>";
										  $j++;
										}//end while($rs_sub = mysql_fetch_assoc($result_sub)){
										  echo "</td></tr></table>";
										  echo "</table>";
										  
										  echo "</div>";
										  
										  echo "</td>";
										  echo "<td  colspan='2' align='left'>".GetMistaken($rs1[mistaken_id])."</td>";

										
									}else{
									echo "<td align='left'><input type=\"checkbox\" name=\"chData[]\" id=\"chData$j\" value='$rs1[checkdata_id]' $chk1>&nbsp;$rs1[dataname]</td>";
									echo "<td align='center'><input name=\"num_point[$rs1[checkdata_id]]\" type=\"text\" id=\"num_point$j\" size=\"10\" maxlength=\"4\" value='$xrsc2[num_point]'></td>";
									echo "<td align='left'>".GetMistaken($rs1[mistaken_id])."</td>";
									}

								echo "</tr>";
								$j++;
						} //end while($rs1 = mysql_fetch_assoc($result1)){
					}//end if($num1 > 0){
				}//end while(){
			?>
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td colspan="2" align="left" bgcolor="#CCCCCC"><strong>แนบไฟล์แสกนผลการ QC เอกสาร ก.พ.7</strong></td>
                  </tr>
                <tr>
                  <td width="42%" align="right"><strong>เลือกไฟล์แนบ : </strong></td>
                  <td width="58%"> <input type="file" name="kp7file" id="kp7file"></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><strong>หมายเหตุไฟล์แนบ : </strong></td>
                  <td><label for="comment_upload"></label>
                    <textarea name="comment_upload" id="comment_upload" cols="45" rows="5"></textarea></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><label>
              <? 
			  	$sql_true = "SELECT COUNT(idcard) AS numc1 FROM validate_checkdata WHERE  idcard='$idcard' AND staffid='$staffid' AND ticketid='$TicketID' AND result_check='1'";
				$result_true = mysql_db_query($db_name,$sql_true);
				$rs_t = mysql_fetch_assoc($result_true);
				if($rs_t[numc1] > 0){ $check1 = "checked='checked'";}else{ $check1 = "";}
			  ?>
                <input type="checkbox" name="checkTrue" id="checkTrue" value="1"  onclick="return UncheckTrue();" <?=$check1?>>
                คลิ๊กกรณีผลการตรวจไม่พบข้อผิดพลาด
              </label></td>
            </tr>
            <?
            	$flag_qc = ShowFlagQc($idcard,$staffid);
			?>
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><label>
                <input type="submit" name="button" id="button" value="บันทึก" />
                <input type="hidden" name="xch" value="<?=$j?>">
                <input type="hidden" name="idcard" value="<?=$idcard?>" />
                <input type="hidden" name="fullname" value="<?=$fullname?>" />
                <input type="hidden" name="staffname" value="<?=$staffname?>">
                <input type="hidden" name="staffid" value="<?=$staffid?>">
                <input type="hidden" name="TicketID" value="<?=$TicketID?>">
                <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                <input type="hidden" name="flag_qc" value="<?=$flag_qc?>">
                &nbsp;
                <input type="button" name="btnC" id="btnC" value="ปิดหน้าต่าง" onClick="window.close()">
              </label></td>
              </tr>
          </table></td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</form>
</body>
</html>
