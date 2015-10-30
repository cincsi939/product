<?
include("epm.inc.php");
include("function_face2cmss.php");

if($xnumday == ""){
		$xnumday = 5;
}
$arrsite = GetSiteKeyData();
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$curent_yy = date("Y")+543;

//echo "<font color='red'><center>ขออภัยกำลังปรับปรุงโปรแกรม ประมาณ  30 นาที </center></font>";die;

$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "L";}
			else if($get_group == "3"){ return "N";}
			else if($get_group == "4"){ return "N Parttime";}
			else if($get_group == "5"){ return "L Parttime";}
	}

$array_day = array("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.");




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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="center" bgcolor="#D4D4D4"><form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="10%" align="right"><strong>เลือกศูนย์คีย์ข้อมูล</strong></td>
              <td width="23%"><select name="site_id" id="site_id">
                 <option value="">เลือก site งาน</option>
                 <option value="999" <? if($site_id == "999"){ echo " selected='selected' ";}?>>เลือกทั้งหมด</option>
                 <?
                 	if(count($arrsite) > 0){
							foreach($arrsite as $kk => $vv){
								if($kk == $site_id){ $sel = " selected='selected' ";}else{ $sel = "";}
									echo "<option value='$kk' $sel>$vv</option>";
							}
					}//end 	if(count($arrsite) > 0){
				 ?>
                 
                 </select></td>
              <td width="13%" align="right"><strong>เลือกจำนวนสถิติย้อนหลัง</strong></td>
              <td width="19%">
                <select name="xnumday" id="xnumday">
                <?
                	for($kk=1;$kk<=30;$kk++){
						if($xnumday == $kk){ $sel1 = " selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$kk' $sel1>$kk</option>";
					}
				?>
                </select></td>
              <td width="16%"><input type="submit" name="button" id="button" value="แสดงรายงาน" /></td>
              <td width="19%">&nbsp;</td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td colspan="5" align="center" bgcolor="#D4D4D4"><strong>รายงานค่าคะแนนการคีย์ข้อมูลของพนักงานคีย์ข้อมูลย้อนหลัง <?=$xnumday?> วัน ไม่รวมวันทำการปัจุบัน</strong></td>
        </tr>
      <tr>
        <td width="8%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
        <td width="30%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ นามสกุลพนักงาน</strong></td>
        <td width="21%" align="center" bgcolor="#D4D4D4"><strong>วันที่คีย์ข้อมูล</strong></td>
        <td width="20%" align="center" bgcolor="#D4D4D4"><strong>กลุ่มคีย์ข้อมูล</strong></td>
        <td width="21%" align="center" bgcolor="#D4D4D4"><strong>คะแนนคีย์</strong></td>
        </tr>
      	<?
		$arr_loop = array();
		if($site_id == "999"){
			$arr_loop = 	$arrsite;
		}else{
			$arr_loop = array("$site_id"=>"$arrsite[$site_id]");
		}
		
		if(count($arr_loop) > 0){
			
			foreach($arr_loop as $key => $val){	
      	
			if($key != $temp_site){
					echo "<tr bgcolor=\"#CCCCCC\"><td colspan='5'>ศูนย์คีย์ข้อมูล $val</td></tr>";
					$temp_site = $key;
			}//end if($key != $temp_site){
				
			$in_id = GetPinStaff($key);
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			if($in_id != ""){
			$sql = "SELECT * FROM keystaff WHERE card_id IN($in_id) and sapphireoffice='0' and status_permit='YES'";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
			$j=0;
			while($rs = mysql_fetch_assoc($result)){
				
			$sql_point = "SELECT * FROM stat_user_keyin WHERE staffid='$rs[staffid]' AND datekeyin LIKE '".date("Y-m")."%' and datekeyin NOT LIKE '".date("Y-m-d")."'  ORDER BY datekeyin DESC LIMIT $xnumday ";
			$result_point = mysql_db_query($dbnameuse,$sql_point) or die(mysql_error().__LINE__);
			$numr1 = mysql_num_rows($result_point);
			if($numr1 > 0){
			
			if($temp_staffid != $rs[staffid]){
				$j++;
						echo "<tr bgcolor=\"#CCCCCC\"><td align='center'>$j</td><td colspan='4'>$rs[staffname] $rs[staffsurname][$rs[staffid]]  เริ่มงานวันที่ ".DBThaiLongDate($rs[start_date])."</td></tr>";
			}
			$i=0;
			while($rsp = mysql_fetch_assoc($result_point)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
		?>
      <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="right">&nbsp;</td>
        <td align="center"><?=$rsp[datekeyin]?></td>
        <td align="center"><?=ShowGroup($rsp[keyin_group]);?><? echo "(1:$rsp[rpoint])";?></td>
        <td align="right"><? echo $rsp[numkpoint]?></td>
        </tr>
      <?
	  		$sump += $rsp[numkpoint];
			}//end while($rsp = mysql_fetch_assoc($result_point)){
		echo "<tr bgcolor=\"#CCCCCC\"><td colspan='4' align='right'><b>รวม : </b></td><td align='right'><b>".number_format($sump,2)."</b></td></tr>";
		$sump= 0;
			}//end 
			}//end while($rs = mysql_fetch_assoc($result)){
			
			}//end if($in_id != ""){
	  	$in_id = "";
			}// end foreach($arrsite as $key => $val){
	}//end 	if(count($arrsite) > 0){
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
