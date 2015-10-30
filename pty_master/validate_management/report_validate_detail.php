<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
session_start();
include("validate.inc.php");
$maxdate = 7;

?>

<html>
<head>
<title>รายงานผลการตรวจสอบการบันทึกข้อมูล ก.พ. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
  <tr>
    <td height="50" align="right" background="images/report_banner_01.gif"  style=" border-bottom:1px solid #FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="45%" style="padding-left:15px"><font style="color:#FFFFFF; font-size:16px; font-weight:bold">รายงานสถิติการบันทึกผลการตรวจสอบข้อมูล</font><br>
<font style="color:#FFFFFF">&copy;  2002-2008 Sapphire Research and Development Co.,Ltd.</font></td>
        <td width="55%" style="padding-left:15px">&nbsp;</td>
      </tr>
      <tr>
        <td style="padding-left:15px">&nbsp;</td>
        <td style="padding-left:15px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="71%" align="right">&nbsp;</td>
            <td width="27%" align="right">&nbsp;</td>
            <td width="2%" align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td><form name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="4" align="left" bgcolor="#EFEFFF"><strong>ค้นหาเจ้าหน้าที่บันทึกข้อมูล</strong></td>
            </tr>
          <tr>
            <td width="14%" align="right" bgcolor="#EFEFFF"><strong>ชื่อ - นามสกุล: </strong></td>
            <td width="24%" align="left" bgcolor="#EFEFFF"><label>
              <select name="key_staffid" id="key_staffid">
              <option value=""> - เลือกชื่อพนักงาน - </option>
              <?
              		$sql_staff = "SELECT * FROM keystaff WHERE sapphireoffice='0' AND status_permit='YES' ORDER BY staffname ASC";
					$rsult_staff = mysql_db_query($db_name,$sql_staff);
					while($rs_s = mysql_fetch_assoc($rsult_staff)){
						if($rs_s[staffid] == $key_staffid){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_s[staffid]' $sel>$rs_s[prename]$rs_s[staffname]  $rs_s[staffsurname]</option>";
					}//end while(){
			  ?>
              </select>
            </label></td>
            <td width="8%" align="right" bgcolor="#EFEFFF">&nbsp;</td>
            <td width="54%" align="left" bgcolor="#EFEFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" bgcolor="#EFEFFF"><strong>ตั้งแต่วันที่ : </strong></td>
            <td align="left" bgcolor="#EFEFFF"><INPUT name="startdate" onFocus="blur();" value="<?=$startdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.startdate, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
            <td align="right" bgcolor="#EFEFFF"><strong>ถึงวันที่ : </strong></td>
            <td align="left" bgcolor="#EFEFFF"><INPUT name="enddate" onFocus="blur();" value="<?=$enddate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.enddate, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
            <td align="left" bgcolor="#EFEFFF">&nbsp;</td>
            <td colspan="2" align="left" bgcolor="#EFEFFF"><label>
              <input type="submit" name="button" id="button" value="ค้นหา">
            </label></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </form></td></tr>
  
  
  <tr>
  <?

  
  	if($startdate == "" and $enddate == ""){ 	// กรณีไม่ระบุวันที่
		$edate = date("Y-m-d");// วันที่สิ้นสุด
		$date_length = 7;
		$basedate = strtotime("$edate");
		$date1 = strtotime("-7 day", $basedate);
		$sdate = date("Y-m-d",$date1);// วันเริ่มต้น
		
	}else{
		$sdate = ConDateC($startdate,"/");
		$edate = ConDateC($enddate,"/");
		$date_length = DateDiff($sdate,$edate);

	}

	if($date_length > 7){
			$cons1 = "4";
			$cons2 = "2";
		$date_td = "<td width=\"53%\" align=\"center\" bgcolor=\"#A3B2CC\">จำนวนรวมระหว่างวันที่ ".DBThaiLongDate($sdate)." ถึง ".DBThaiLongDate($edate)."</td>";
		$date_td1 = "<td>&nbsp;</td>";
		$xtitle1 = "";
		
	}else if($date_length == 7){
		$xtitle1 = "ระหว่าง ".DBThaiLongDate($sdate)." ถึงวันที่ ".DBThaiLongDate($edate);
		$cons1 = 4+7;
		$cons2 = 2+7;
		$p1 = 53/7;
		$p2 = 53%7;
		for($k=1;$k <= 7;$k++){
			$xpercen = intval($p1);
			$basedate = strtotime("$sdate");
			$date1 = strtotime("$k day", $basedate);
			$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
			$txt_str = intval(substr($xsdate,-2));
			$date_td .= "<td width=\"$xpercen%\" align=\"center\" bgcolor=\"#A3B2CC\">".$txt_str."</td>";
			$date_td1 .= "<td align='center'>&nbsp;</td>";
		}//end for($i=1;$i <= 7;$i++){
	}else{
		$xtitle1 = "ระหว่าง ".DBThaiLongDate($sdate)." ถึงวันที่ ".DBThaiLongDate($edate);
		$cons1 = 4+$date_length;
		$cons2 = 2+$date_length;
		$p1 = 53/$date_length;
		$p2 = 53%$date_length;
		for($k=1;$k <= $date_length;$k++){
			$xpercen = intval($p1);
			$basedate = strtotime("$sdate");
			$date1 = strtotime("$k day", $basedate);
			$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
			$txt_str = intval(substr($xsdate,-2));
			$date_td .= "<td width=\"$xpercen%\" align=\"center\" bgcolor=\"#A3B2CC\">".$txt_str."</td>";
			$date_td1 .= "<td align='center'>&nbsp;</td>";
		}//end for($i=1;$i <= $date_length;$i++){
	}
  
  ?>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$cons1?>" align="left" bgcolor="#A3B2CC"><strong>ผลการตรวจสอบข้อมูลของ : <?=ShowStaff($key_staffid);?></strong></td>
        </tr>
      <tr>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="31%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>หมวด / รายการ</strong></td>
        <td colspan="<?=$cons2?>" align="center" bgcolor="#A3B2CC"><strong>จำนวนครั้ง(เฉลี่ยต่อวัน) <?=$xtitle1?></strong></td>
        </tr>
      <tr>
        <td width="<?=11+$p2?>%" align="center" bgcolor="#A3B2CC"><strong>เฉลี่ย(ครั้ง)</strong></td>
        
        <?  echo $date_td;?>
        
        </tr>
        <?
		$numkeydate = CountDateKey($key_staffid,$sdate);
        	$sql = "SELECT * FROM validate_datagroup WHERE parent_id='0' ORDER BY checkdata_id ASC";
			$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
					$i++;
				echo "<tr bgcolor='#CCCCCC'><td align='center'><b>$i</b></td>";
				echo "<td colspan='2' align='left'><b>$rs[dataname]</b></td>";
				echo $date_td1;	
				echo "</tr>";
			
			$sql1 = "SELECT * FROM validate_datagroup WHERE parent_id='$rs[checkdata_id]'";	
			$result1 = mysql_db_query($db_name,$sql1);
			$j=0;
			$val = 0;
			$val1 = 0;
			$avg_val = 0;
			while($rs1 = mysql_fetch_assoc($result1)){
			if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			if($date_length > 7){
				$val = 0;
					for($k=1;$k <= $date_length;$k++){
					$basedate = strtotime("$sdate");
					$date1 = strtotime("$k day", $basedate);
					$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
						$val += CountKeyCheck($key_staffid,$rs1[checkdata_id],$xsdate);
					}//end for($k=1;$k <= $date_length;$k++){	
					if($val > 0 ){ $avg_val = $val/$numkeydate;}else{ $avg_val = 0;}
			}else{ // กรณีค้นหาช่วงเวลาน้อยกว่า 7
			$val1 = 0;
				for($xk=1;$xk <= $date_length;$xk++){
					$basedate = strtotime("$sdate");
					$date1 = strtotime("$xk day", $basedate);
					$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
					 $val1 += CountKeyCheck($key_staffid,$rs1[checkdata_id],$xsdate);
				}//end for($i=1;$i <= $date_length;$i++){
				if($val1 > 0){ $avg_val = $val1/$numkeydate; }else{ $avg_val = 0;}
			}
			
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center">&nbsp;<? echo $i.".".$j?></td>
        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?=$rs1[dataname]?></td>
        <td align="center"><? echo number_format($avg_val,2);/*." :: ค่ารวม val1::".$val1." ค่ารวม val::".$val*/?></td>
       		 <? 
			 if($date_length > 7){
			?>
        <td align="center"><?=number_format($val);?></td>
        <?
			}else{
			
			for($k1=1;$k1 <= $date_length;$k1++){
				$basedate = strtotime("$sdate");
				$date1 = strtotime("$k1 day", $basedate);
				$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
				echo " <td align=\"center\">".CountKeyCheck($key_staffid,$rs1[checkdata_id],$xsdate)."</td>";
			}//end for($i=1;$i <= $date_length;$i++){
		}
		?>
        </tr>
        <?
				}//endwhile($rs1 = mysql_fetch_assoc($result1)){
			}//end while($rs = mysql_fetch_assoc($result)){
		?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
