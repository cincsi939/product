<?
require_once("../../config/conndb_nonsession.inc.php");
$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = "edubkk_userentry";

$host = HOST;
$user = "cmss";
$pass = "2010cmss";

$arrstaff = array('19'=>'NOR','34'=>'QC','35'=>'AC','16'=>'CALLCENTER','12'=>'SCAN','18'=>'GRAPHIC','40'=>'site_area');// site งาน




function GetStaffFace($pin){
	global $dbface,$dbnameuse,$host_face,$user_face,$pass_face;

	ConHost($host_face,$user_face,$pass_face); // connect faceaccess
	$sql = "SELECT
t1.pin,
t1.firstname,
t1.surname,
t2.prename_th,
t1.status_id,
t1.office,
t1.email,
t1.phone_number,
t1.username,
t1.`password`,
t3.time_start,
t1.firstname_eng,
t1.surname_eng,
t1.period_group_id
FROM faceacc_officer as t1 left join tbl_prename as t2 ON t1.prename=t2.id
left join faceacc_officer_to_status as t3 ON t1.officer_id=t3.officer_id
WHERE t1.pin='$pin'";
	$result = mysql_db_query($dbface,$sql) or die(mysql_error());
	$rs = mysql_fetch_assoc($result);
	if($rs[pin] != ""){
		ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
		
			if($rs[firstname_eng] == ""){
				$sub_user = $rs[username].".sys";	
			}else{
				$sub_user = $rs[firstname_eng].".".substr($rs[surname_eng],0,3);
			}//end 	if($rs[firstname_eng] == ""){
				
			if($rs[period_group_id] == "3"){
				$keyin_group = "4";	
			}else if($rs[period_group_id] == "1"){
				$keyin_group = "3";		
			}//end 	if($rs[period_group_id] == "3"){
				
				if($arrstaff[office] == ""){
					$status_extra = "NOR";
				}else{
					$status_extra = $arrstaff[office];	
				}//end 	if($arrstaff[office] == ""){
				
				
				
			$sql_insert_staff= "INSERT INTO keystaff SET prename='$rs[prename_th]',staffname='$rs[firstname]',staffsurname='$rs[surname]',card_id='$rs[pin]',status_permit='YES',email='$rs[email]',username='$sub_user',password='logon',telno='$rs[phone_number]',status_extra='".$status_extra."',sapphireoffice='0',engname='$rs[firstname_eng]',engsurname='$rs[surname_eng]',keyin_group='$keyin_group'";
			mysql_db_query($dbnameuse,$sql_insert_staff);
			$last_id = mysql_insert_id();
	
		return $last_id;
	}else{
		return "";	
	}//end if($rs[pid] != ""){
}//end function GetStaffFace($pin){
	
	
#####################  proces #########################3

	
if($_SERVER['REQUEST_METHOD'] == "POST"){
		$sql = "SELECT * FROM keystaff WHERE card_id='$pin' AND period_time='$period_time' AND status_permit='YES'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs  =mysql_fetch_assoc($result);
		if($rs[card_id] == ""){
				$last_id = GetStaffFace($pin); 
				if($last_id != ""){
						if($site_area != ""){
						$sql_site = "SELECT COUNT(*) AS num1 FROM keystaff WHERE site_area='$site_area' AND staffid <> '$last_id'  and status_permit='YES' ";
						$result_site = mysql_db_query($dbnameuse,$sql_site);
						$rssite = mysql_fetch_assoc($result_site);
							if($rssite[num1] > 0){
								$consite = "";
								$error_area = "error";
							}else{
								$consite = ",site_area='$site_area' ,date_area='$date_area' ";	
								$error_area = "";
								$flag_site = 1;
							}
						}//end	if($site_area != ""){ 
					
					$sql_update = "UPDATE  keystaff SET status_extra='$status_extra',period_time='$period_time',flag_assgin='$flag_assgin',keyin_group='$keyin_group' $consite  WHERE staffid='$last_id' ";
					mysql_db_query($dbnameuse,$sql_update);
				}else{
					$error_area = "NO_idcard";	
				}// end if($last_id != ""){
		}else{
			
						if($site_area != ""){
						$sql_site = "SELECT COUNT(*) AS num1 FROM keystaff WHERE site_area='$site_area' AND staffid <> '$last_id'  and status_permit='YES' ";
						$result_site = mysql_db_query($dbnameuse,$sql_site);
						$rssite = mysql_fetch_assoc($result_site);
							if($rssite[num1] > 0){
								$consite = "";
								$error_area = "error";
							}else{
								$consite = ",site_area='$site_area' ,date_area='$date_area' ";	
								$error_area = "";
								$flag_site = 1;
							}
						}//end	if($site_area != ""){ 

			$sql_update = "UPDATE  keystaff SET status_extra='$status_extra',period_time='$period_time',flag_assgin='$flag_assgin',keyin_group='$keyin_group' $consite  WHERE staffid='$rs[staffid]' ";
			mysql_db_query($dbnameuse,$sql_update);
		}//end if($rs[card_id] == ""){
		
		if($error_area == "error"){
			$sql_sel = "SELECT * FROM keystaff WHERE site_area='$site_area' AND status_permit='YES' ";
			$result_sel = mysql_db_query($dbnameuse,$sql_sel);
			$rss = mysql_fetch_assoc($result_sel);
			$msg = "ปรับปรุงข้อมูลเรียบร้อยแล้ว แต่ไม่สามารถกำหนดเป็นจำหน้าที่เขตได้เนื่องจาก $rss[prename]$rss[staffname]  $rss[staffsurname]  ครองอยู่";	
		}else if($error_area == "NO_idcard"){
			$msg = "ไม่พบข้อมูลจากระบบ face";
		}else{
			$msg = "บันทึกข้อมูลเรียบร้อยแล้ว";	
		}
		
		
	if($flag_site == "1"){
		$redirect_file = "org_user.php??xmode=&utype=3&xtype_view=Y";	
	}else{
		$redirect_file = "org_user.php?xmode=&utype=0&xtype_view=Y";	
	}	
		echo "<script>
alert(\"$msg\");
window.opener.location='$redirect_file';
window.close();
</script>";
		exit;

}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
	

?>
<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="../../common/Script_CheckIdCard.js"></script>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">	
	function DisSiteArea(){
	if(document.form1.status_extra.value == "site_area"){
			document.form1.site_area.disabled=false;
			document.form1.btnCalendar.disabled=false;
			
	}else{
		document.form1.site_area.disabled=true;
		document.form1.btnCalendar.disabled=true;
	}
		
}//end function DisSiteArea(){
	
function CheckKeyIdcard(id){
	if(document.form1.pin.value != ""){
	if(!Script_checkID(id)){
		alert("เลขบัตรประชาชนไม่ถูกต้องตามตรมการปกครอง");	
		document.form1.pin.focus();
		return false;
	}else{
		return true;	
	}
	}else{
		alert("กรุณาระบุเลขบัตรประชาชนของพนักงาน");
		document.form1.pin.focus();
		return false;
	}
}

function CheckFromKey(){
	if(document.form1.pin.value == ""){
		alert("กรุณาระบุเลขบัตรประชาชนพนักงาน");
		document.form1.pin.focus();
		return false;
	}
	if(document.form1.status_extra.value == ""){
		alert("กรุณาระบุกลุ่มการทำงานของพนักงาน");	
		document.form1.status_extra.focus();
		return false;
	}	
	return true;
}
</script>

</head>
<body>
<?
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
?><br />
<form id="form1" name="form1" method="post" action="" onsubmit="return CheckFromKey();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="../../images_sys/useronline.gif" width="20" height="20" />แบบฟอร์มการเพิ่ม user จากระบบ face</strong></td>
          </tr>
        <tr>
          <td width="37%" align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชนพนักงาน <span class="redlink">*</span></strong></td>
          <td width="63%" align="left" bgcolor="#FFFFFF"><label for="pin"></label>
            <input name="pin" type="text" id="pin" size="25" maxlength="13" onblur=" return CheckKeyIdcard(this.value);"></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>กลุ่มการทำงาน<span class="redlink">*</span></strong></td>
          <td align="left" bgcolor="#FFFFFF"><select name="status_extra" onChange="return DisSiteArea(this.value);">
            <option value="">- เลือกกลุ่มการทำงาน - </option>
            <option value="NOR" <? if($rs[status_extra] == "NOR"){ echo "selected='selected'";}?>>ปกติ(คีย์ข้อมูล)</option>
            <option value="QC" <? if($rs[status_extra] == "QC"){ echo "selected='selected'";}?>>ตรวจสอบความถูกต้องการบันทึกข้อมูล (QC)</option>
            <option value="QC_WORD" <? if($rs[status_extra] == "QC_WORD"){ echo "selected='selected'";}?>>ตรวจสอบการบันทึกข้อมูล(ตรวจสอบคำผิด)</option>
            <option value="AC" <? if($rs[status_extra] == "AC"){ echo "selected='selected'";}?>>เจ้าหน้าที่บัญชี</option>
            <option value="CALLCENTER" <? if($rs[status_extra] == "CALLCENTER"){ echo "selected='selected'";}?>>เจ้าหน้าที่ Callcenter</option>
            <option value="SCAN" <? if($rs[status_extra] == "SCAN"){ echo "selected='selected'";}?>>เจ้าหน้าที่สแกนเอกสาร ก.พ.7</option>
            <option value="GRAPHIC" <? if($rs[status_extra] == "GRAPHIC"){ echo "selected='selected'";}?>>เจ้าหน้าที่ตัดรูป</option>
            <option value="site_area" <? if($rs[status_extra] == "site_area"){ echo "selected='selected'";}?>>เจ้าหน้าที่ประจำเขต</option>
          </select></td>
          </tr>
                <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ช่วงเวลาทำงาน</strong></td>
          <td align="left" bgcolor="#FFFFFF"><select name="period_time" id="period_time">
            <option value="">กรุณาเลือก</option>
            <option value="am" <? if($rs[period_time]=="am"){echo "selected='selected'";} ?>>Fulltime 09:00-17:30</option>
            <option value="pm" <? if($rs[period_time]=="pm"){echo "selected='selected'";} ?>>passtime 18:00-22:00</option>
          </select></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>เลือกเขตพื้นที่การศึกษาที่พนักงานไปประจำ</strong></td>
          <td align="left" bgcolor="#FFFFFF">
            <select name="site_area" id="site_area">
              <option value="">เลือกเขตพื้นที่การศึกษา</option>
              <?
            $sql_area = "SELECT secid,secname FROM eduarea WHERE secid NOT LIKE '%99%' ORDER BY secname ASC";
			$result_area = mysql_db_query("edubkk_master",$sql_area);
			while($rsa = mysql_fetch_assoc($result_area)){
				if($rsa[secid] == $rs[site_area]){$sel = " selected='selected'"; }else{ $sel = "";}
					echo "<option value='$rsa[secid]' $sel>$rsa[secname]</option>";
			}
			
			?>
              </select></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>วันทีเริ่มประจำเขต</strong></td>
          <td align="left" bgcolor="#FFFFFF"><input name="date_area" id="date_area" onfocus="blur();" value="<? if($date_area != "//543" ){ echo $date_area;}?>" size="15" readonly="readOnly">
            <input name="btnCalendar" id="button0" type="button"  onclick="popUpCalendar(this, form1.date_area, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>สถานะกลุ่มงานมอบเอกสาร</strong></td>
          <td align="left" bgcolor="#FFFFFF">  <select name="flag_assgin">
            <option value="">เลือกกลุ่มงานมอบหมายงาน</option>
            <option value="assgin_key" <? if($rs[flag_assgin] == "assgin_key"){ echo "selected='selected'";}?>>กลุ่มบันทึกข้อมูล ก.พ.7</option>
            <option value="assgin_scan" <? if($rs[flag_assgin] == "assgin_scan"){ echo "selected='selected'";}?>>กลุ่มสแกนเอกสาร ก.พ.7</option>
            <option value="assign_checklist" <? if($rs[flag_assgin] == "assign_checklist"){ echo "selected='selected'";}?>>กลุ่มตรวจสอบเอกสาร</option>
          </select></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>กลุ่มการคีย์ข้อมูล</strong></td>
          <td align="left" bgcolor="#FFFFFF">      <select name="keyin_group">
            <option value=""> - เลือกกลุ่มการคีย์ข้อมูล - </option>
            <?
      	$sql_group = "SELECT * FROM keystaff_group WHERE status_active='1' ORDER BY groupkey_id ASC";
		$result_group = mysql_db_query($dbnameuse,$sql_group);
		while($rs_g1 = mysql_fetch_assoc($result_group)){
			if($rs[keyin_group] == $rs_g1[groupkey_id]){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
			echo "<option value='$rs_g1[groupkey_id]' $sel1>$rs_g1[groupname]</option>";	
		}//end while($rs_g = mysql_fetch_assoc($result_group)){
	  ?>
            </select>
</td>
          </tr>
        <tr>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td align="left" bgcolor="#CCCCCC">
            <input type="submit" name="button2" id="button" value="บันทึกข้อมูล" />
            <input type="button" name="btnC" value="ปิดหน้าต่าง">
          </td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body></html>
