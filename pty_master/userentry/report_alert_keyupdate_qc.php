<?
include("epm.inc.php");
$curent_yy = date("Y")+543;
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

if($_SERVER['REQUEST_METHOD'] == "POST"){
		echo "<script>location.href='?mm=$mm&yy1=$yy1'</script>";	
		exit();
}else{

	if($yy1 == ""){
		$yy1 = date("Y")+543;
	
	}
	if($mm == ""){					
		$mm = sprintf("%02d",date("m"));
	}
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
	$get_yy = ($yy1-543);
	$yymm = $get_yy."-".$mm;
	
	$array_day = array("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.");
############  function แสดงจำนวนเอกสารที่คีย์ชุด update ของพนักงานคีย์ข้อมูล

function GetNumKeyupdate($yymm){
	global $dbnameuse;
	$sql = "SELECT
t1.staffid,
sum(if(t4.pid='125471008',1,0)) as sumH1,
sum(if(t4.pid IN('125471009','125471064','125471065','125471066'),1,0)) as sumH2,
sum(if(t4.pid='225471000',1,0)) as sumH3,
sum(if(t4.pid IN('525471007','525471018','525471024','525471030','525471042','525471049','525471084','525471091','525471095','525471102','525471107','525471118','525471119','525471120','525471132','525471133','525471142','525471145','525471147','525471162','525471168','525471174','525471187','525471196'),1,0)) as sumH4,
sum(if(t4.pid='325471008',1,0)) as sumO1,
sum(if(t4.pid='325001010',1,0)) as sumO2
FROM ".DB_USERENTRY.".keystaff_keyupdate AS t1
Inner Join ".DB_USERENTRY.".tbl_assign_sub AS t2 ON t1.staffid = t2.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key AS t3 ON t2.ticketid = t3.ticketid and t3.approve =  '2' AND t3.userkey_wait_approve =  '1' AND t3.profile_id >=  '6' AND t3.status_qc =  'NO' 
and date(t3.datetime_approve) like '$yymm%' 
Inner Join  ".DB_MASTER.".view_general AS t4 ON t3.idcard = t4.CZ_ID
left Join  ".DB_MASTER.".req_problem_person as t5 ON t4.CZ_ID = t5.idcard and t4.siteid=t5.site
WHERE t5.idcard IS NULL
group by t1.staffid";	
//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE___".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]]['sumH1'] = $rs[sumH1];
			$arr[$rs[staffid]]['sumH2'] = $rs[sumH2];
			$arr[$rs[staffid]]['sumH3'] = $rs[sumH3];
			$arr[$rs[staffid]]['sumH4'] = $rs[sumH4];
			$arr[$rs[staffid]]['sumO1'] = $rs[sumO1];
			$arr[$rs[staffid]]['sumO2'] = $rs[sumO2];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetNumKeyupdate(){
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
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
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
<?
	if($action == ""){
		$txt_yy = $yy1;
		$txt_mm = $mm;
?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>รายงานแจ้งเตื่อน QC สำหรับพนักงาน key ข้อมูล update</strong></td>
        </tr>
        <tr>
          <td align="left"><form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>เดือนปี : </strong></td>
                <td width="86%" align="left"><label>
                  <select name="mm" id="mm">
                  <option value="">เลือกเดือน</option>
                  <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>
                  </select>
                 <strong> ปี </strong>
                 <select name="yy1" id="yy1">
                 <option value="">เลือกปี</option>
                 <?
                 	for($y = 2552 ; $y <= $curent_yy ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
                </label><label>
                  <input type="submit" name="button2" id="button" value="แสดงรายงาน">
                </label><br></td>
              </tr>
            </table>
          </form></td>
        </tr>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="92%" align="left" bgcolor="#E9E9E9"><strong>แสดงกลุ่มคีย์ข้อมูล update ประจำเดือน <?=$monthFull[intval($txt_mm)]?> <?=$txt_yy?></strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td width="3%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="26%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล(พนักงานบันทึกข้อมูล)</strong></td>
              <td colspan="4" align="center" bgcolor="#D4D4D4"><strong>สำนักงานเขตฯ</strong></td>
              <td colspan="2" align="center" bgcolor="#D4D4D4"><strong>สถานศึกษา</strong></td>
              </tr>
            <tr>
              <td width="13%" align="center" bgcolor="#D4D4D4"><strong>ผอ.เขต</strong></td>
              <td width="15%" align="center" bgcolor="#D4D4D4"><strong>รอง ผอ.เขต</strong></td>
              <td width="12%" align="center" bgcolor="#D4D4D4"><strong>ศึกษานิเทศก์</strong></td>
              <td width="12%" align="center" bgcolor="#D4D4D4"><strong>บุคลากร 38 ค(2)</strong></td>
              <td width="10%" align="center" bgcolor="#D4D4D4"><strong>ผอ.สถานศึกษา</strong></td>
              <td width="9%" align="center" bgcolor="#D4D4D4"><strong>รอง ผอ.สถานศึกษา</strong></td>
              </tr>
            <?
			$arrdata = GetNumKeyupdate($yymm);
			$sql = "SELECT t2.staffid, t2.prename, t2.staffname, t2.staffsurname FROM keystaff_keyupdate as t1 Inner Join keystaff as t2 ON t1.staffid = t2.staffid where t1.status_active='1'  ";	
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				// SubGroupQC($rs[staffid]); // แบ่งกลุ่ม QC
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}		
				
				if($arrdata[$rs[staffid]]['sumH1'] > 0){ $bg1 = "  bgcolor=\"#FF0000\"";}else{$bg1 = "";}
				if($arrdata[$rs[staffid]]['sumH2'] > 0){ $bg2 = "  bgcolor=\"#FF0000\"";}else{$bg2 = "";}
				if($arrdata[$rs[staffid]]['sumH3'] > 0){ $bg3 = "  bgcolor=\"#FF0000\"";}else{$bg3 = "";}
				if($arrdata[$rs[staffid]]['sumH4'] > 0){ $bg4 = "  bgcolor=\"#FF0000\"";}else{$bg4 = "";}
				if($arrdata[$rs[staffid]]['sumO1'] > 0){ $bg5 = "  bgcolor=\"#FF0000\"";}else{$bg5 = "";}
				if($arrdata[$rs[staffid]]['sumO2'] > 0){ $bg6 = "  bgcolor=\"#FF0000\"";}else{$bg6 = "";}		
			  ?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname]   $rs[staffsurname]";?></td>
              <td align="center" <?=$bg1?>><? if($arrdata[$rs[staffid]]['sumH1'] > 0){ echo "<a href='?action=view&xgtype=H1&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=ผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumH1']."</a>";}else{ echo "0";}?></td>
              <td align="center" <?=$bg2?>><? if($arrdata[$rs[staffid]]['sumH2'] > 0){ echo "<a href='?action=view&xgtype=H2&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=รองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumH2']."</a>";}else{ echo "0";}?></td>
              <td align="center" <?=$bg3?>><? if($arrdata[$rs[staffid]]['sumH3'] > 0){ echo "<a href='?action=view&xgtype=H3&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=ศึกษานิเทศก์&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumH3']."</a>";}else{ echo "0";}?></td>
              <td align="center" <?=$bg4?>><? if($arrdata[$rs[staffid]]['sumH4'] > 0){ echo "<a href='?action=view&xgtype=H4&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=บุคลากร 38 ค(2)&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumH4']."</a>";}else{ echo "0";}?></td>
              <td align="center" <?=$bg5?>><? if($arrdata[$rs[staffid]]['sumO1'] > 0){ echo "<a href='?action=view&xgtype=O1&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=ผู้อำนวยการสถานศึกษา&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumO1']."</a>";}else{ echo "0";}?></td>
              <td align="center" <?=$bg6?>><? if($arrdata[$rs[staffid]]['sumO2'] > 0){ echo "<a href='?action=view&xgtype=O2&staffname=$rs[prename]$rs[staffname]   $rs[staffsurname]&group_position=รองผู้อำนวยการสถานศึกษา&staffid=$rs[staffid]&yymm=$yymm' target=\"_blank\">".$arrdata[$rs[staffid]]['sumO2']."</a>";}else{ echo "0";}?></td>
              </tr>
            <?
				}
			?>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
  <?
		}//end 	if($action == ""){
	if($action == "view"){
		
		if($xgtype == "H1"){
				$xconv = " AND t4.pid ='125471008' "; 
		}else if($xgtype == "H2"){
				$xconv = " AND t4.pid IN('125471009','125471064','125471065','125471066') ";
		}else if($xgtype == "H3"){
				$xconv = " AND t4.pid='225471000' ";
		}else if($xgtype == "H4"){
				$xconv = " AND t4.pid IN('525471007','525471018','525471024','525471030','525471042','525471049','525471084','525471091','525471095','525471102','525471107','525471118','525471119','525471120','525471132','525471133','525471142','525471145','525471147','525471162','525471168','525471174','525471187','525471196')";
		}else if($xgtype == "O1"){
				$xconv = " AND t4.pid='325471008' ";
		}else if($xgtype == "O2"){
				$xconv = " AND t4.pid='325001010' ";		
		}
		
  ?>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="6" align="center" bgcolor="#D4D4D4"><strong>รายการตรวจสอบคุณภาพข้อมูลของการคีย์ข้อมูลชุด update ของ <?=$staffname?> ในกลุ่มตำแหน่ง <?=$group_position?></strong></td>
    </tr>
    <tr>
      <td width="3%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
      <td width="11%" align="center" bgcolor="#D4D4D4"><strong>เลขบัตรประชาชน</strong></td>
      <td width="26%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
      <td width="34%" align="center" bgcolor="#D4D4D4"><strong>สังกัด</strong></td>
      <td width="18%" align="center" bgcolor="#D4D4D4"><strong>วันที่จัดทำข้อมูลแล้วเสร็จ</strong></td>
      <td width="8%" align="center" bgcolor="#D4D4D4">&nbsp;</td>
    </tr>
    <?
    	$sql = "SELECT
t1.staffid,
date(t3.datetime_approve) as dateapp,
t4.CZ_ID as idcard,
t4.siteid,
t4.prename_th,
t4.name_th,
t4.surname_th,
t4.position_now,
t4x.secname,
t4.schoolname,t4.schoolid,t3.profile_id
FROM ".DB_USERENTRY.".keystaff_keyupdate AS t1
Inner Join ".DB_USERENTRY.".tbl_assign_sub AS t2 ON t1.staffid = t2.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key AS t3 ON t2.ticketid = t3.ticketid and t3.approve =  '2' AND t3.userkey_wait_approve =  '1' AND t3.profile_id >=  '6' AND t3.status_qc =  'NO' and date(t3.datetime_approve) like '".$_GET['yymm']."%' 
Inner Join  ".DB_MASTER.".view_general AS t4 ON t3.idcard = t4.CZ_ID
inner join  ".DB_MASTER.".eduarea as t4x on t4.siteid=t4x.secid
left Join  ".DB_MASTER.".req_problem_person as t5 ON t4.CZ_ID = t5.idcard and t4.siteid=t5.site
WHERE
t5.idcard IS NULL and t1.staffid='$staffid'  $xconv

ORDER  BY t4x.secname asc, t4.schoolname asc, t4.name_th, t4.surname_th ASC";
//echo $sql;
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}			
	if($rs[schoolid] == $rs[siteid]){
			$orgname =  str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])." / ".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[schoolname]);
	}else{
		 	$orgname = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])." / โรงเรียน".$rs[schoolname];	
	}
	
		$pathfile = "../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
									$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" title=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
									$pdf_file = "";
							}//end if(is_file($pathfile))
	
	?>
    <tr bgcolor="<?=$bg?>">
      <td align="center"><?=$i?></td>
      <td align="center"><?=$rs[idcard]?></td>
      <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
      <td align="left"><? echo $orgname;?></td>
      <td align="left"><?=DBThaiLongDateFull($rs[dateapp]);?></td>
      <td align="center"><?=$pdf_file?>&nbsp;<a href="../hr3/hr_report/report_check/report_check_data_new.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../validate_management/images/zoom.png" width="16" height="16" / border="0" title="หน้ารายงานเทียบ label กับ value"></a>&nbsp;<a href="../hr3/tool_competency/diagnosticv1/validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>&qcupdate=1&profile_id=<?=$rs[profile_id]?>" target="_blank"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a></td>
    </tr>
    <?
	}// end while(){
	?>
  </table>
<?
	}//end 
  ?>
</body>
</html>
