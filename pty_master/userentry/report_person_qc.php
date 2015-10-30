<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc_v1.php') ;
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	//echo $yy;
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "B";}
			else if($get_group == "3"){ return "C";}
	}

$array_day = array("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.");
/*
echo "<pre>";
print_r($_POST);
*/

//$get_date = "2010-03-01";	
function ShowDayOfMonth($get_month){
	$arr_d1 = explode("-",$get_month);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($get_month){
//$xarr = ShowDayOfMonth("2010-04-01");
//echo "<pre>";
//print_r($xarr);


function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		//$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		$sql = "SELECT count(idcard) as numid FROM `monitor_keyin` where staffid='$get_staffid' and timeupdate LIKE '$get_date%' GROUP BY staffid";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
		
}

function CheckQCPerDay($get_staff,$get_date){
global $db_name;
$sql1 = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' and datecal LIKE '$get_date%' GROUP BY  idcard";
$result1 = mysql_db_query($db_name,$sql1);
$num_r1 = @mysql_num_rows($result1);
return $num_r1;
//$rs1 = mysql_fetch_assoc($result1);
//return $rs1[num1];
	
}

### บันทึกข้อมูลลงในตาราง temp 
function SaveStatQc($get_staff,$get_date){
		global $db_name;
		$numkey = ShowKeyPerson($get_staff,$get_date); // จำนวนชุดที่คีย์ไ้ด้ในแต่ละวัน
		$numqc = CheckQCPerDay($get_staff,$get_date); // จำนวนชุดที่ QC
		$sql_save = "REPLACE INTO temp_check_qc(datekeyin,staffid,numkey,numqc)VALUES('$get_date','$get_staff','$numkey','$numqc')";
		//echo $sql_save."<br>";
		 mysql_db_query($db_name,$sql_save);
		
}//end function SaveStatQc($get_staff,$get_date){
	
	
function AlertQC($get_staff,$get_yymm){
		global $db_name;
		$Rpoint = ShowRpoint($get_staff);
		$sql = "SELECT * FROM temp_check_qc WHERE staffid='$get_staff' AND datekeyin LIKE '$get_yymm%' ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$numk = 0;
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
				if($j==0){ // กำหนดวันเริ่ิมคีย์
					$date_start = $rs[datekeyin];
				}
				
				$numk += $rs[numkey];
				if($numk >= $Rpoint){   // กรณียอดที่คีย์เกินค่าเรโช ให้ตรวจสอบการ QC
					
					if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){ // 5hk
						$arrDQc[$rs[datekeyin]] = "Y";
					}else{
						$arrDQc[$rs[datekeyin]] = "N";
					}//if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){
					//$numk = 0; // กำหนดค่าเศษจากการ QC
					$numk = $numk-$Rpoint;
					$j=0;
				}else{ 
					$j++;
				} // e   // กรณียอดที่คีย์เกินค่าเรโช ให้ตรวจสอบการ QC
			
		}//end while($rs = mysql_fetch_assoc($result)){
			//echo "<pre>";
			//print_r($arrDQc);
			return $arrDQc;
}

function ShowRpoint($get_staff){
		global $db_name;
		$sql1 = "SELECT
keystaff_group.rpoint
FROM
keystaff_group
Inner Join keystaff ON keystaff_group.groupkey_id = keystaff.keyin_group
WHERE
keystaff.staffid =  '$get_staff'
";
	$result1 = mysql_db_query($db_name,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[rpoint];
}

function CheckLengthQC($get_staff,$date_s,$date_e){
		global $db_name;
		$sql1 = "SELECT sum(numqc) AS numqc FROM  temp_check_qc  WHERE staffid='$get_staff' AND datekeyin BETWEEN '$date_s' and '$date_e' ";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($db_name,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		return $rs1[numqc];
}

##### function นับจำนวนการ QC .ในแต่ละวัน
function CountQC($get_staffid,$get_date){
		global $db_name;
		$sql = "SELECT COUNT(idcard) AS  numqc FROM validate_checkdata WHERE qc_staffid='$get_staffid' AND date_check='$get_date' GROUP BY idcard";
		$result = mysql_db_query($db_name,$sql);
		$num_r = @mysql_num_rows($result);
		return $num_r;
		
}//end function CountQC(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>รายงานตรวจสอบจำนวนรายการที่ต้อง QC</strong></td>
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
                 	for($y = 2552 ; $y <= 2553 ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
                </label><label>
                  <input type="submit" name="button2" id="button" value="แสดงรายงาน">
                </label></td>
              </tr>
            </table>
          </form></td>
        </tr>
        <? 
		$col_w = 65; // อัตราความกว้าวของวันที่
		//echo "$yy1<br>";
		if($xtype == ""){ $xtype = 1;} // กรณีมีได้ระบุกลุ่ม ให้ค่า defult เป็น กลุ่ม A
		if($xtype == "1"){$bg_link1 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link1 = "#E9E9E9";}
		if($xtype == "2"){$bg_link2 = "#FFFFFF";$bg_link1 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link2 = "#E9E9E9";}
		if($xtype == "3"){$bg_link3 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link1 = "#E9E9E9";}else{ $bg_link3 = "#E9E9E9";}
		$xmonth1 = ($yy1-543)."-".sprintf("%02d",$mm);
		//echo "<br>$xmonth1";
		$xarr = ShowDayOfMonth($xmonth1); // แสดงรายการวันที่ของเดือนนั้น
		//echo "<pre>";
		//print_r($xarr);
		$width_col = $col_w/count($xarr);
		
		
		$txt_yy = $yy1;
		$txt_mm = $mm;

		//echo "<pre>";print_r($xarr);
		?>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="12%" align="center" bgcolor="<?=$bg_link1?>"><strong><a href="report_qc.php?xtype=1&mm=<?=$mm?>&yy1=<?=$yy1?>">กลุ่ม A</a></strong></td>
              <td width="13%" align="center" bgcolor="<?=$bg_link2?>"><strong><a href="report_qc.php?xtype=2&mm=<?=$mm?>&yy1=<?=$yy1?>">กลุ่ม B</a></strong></td>
              <td width="13%" align="center" bgcolor="<?=$bg_link3?>"><strong><a href="report_qc.php?xtype=3&mm=<?=$mm?>&yy1=<?=$yy1?>">กลุ่ม C</a></strong></td>
              <td width="62%" bgcolor="#E9E9E9">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="left" bgcolor="#E9E9E9"><strong>รายงานแสดงการ QC ผลการบันทึกข้อมูลรายวัน <? echo ShowGroup($xtype);?> ประจำเดือน <?=$monthFull[intval($txt_mm)]?> <?=$txt_yy?></strong></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="15%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>กลุ่ม</strong></td>
              <?
              foreach($xarr as $k => $v){
			  ?>
              <td width="<?=$width_col?>%" align="center" bgcolor="#D4D4D4"><strong><? echo "สัปดาห์ที่ $k";?></strong></td>
              <?
			  }
			  ?>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>รวม</strong></td>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4">&nbsp;</td>
            </tr>
            <tr>
            <?
			
            	foreach($xarr as $k1 => $v1){
					$xcount = count($k1);
					$w1 = 100/6;
					
			?>
              <td align="center" bgcolor="#D4D4D4">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr>
                <?
					$b= 0;
					
                	foreach($v1 as $k2 => $v2){
	
						if ($b++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
				?>
                  <td width="<?=$w1?>%" bgcolor="<?=$bg1?>"><strong><? echo intval(substr($v2,-2));?></strong></td>
                  <? } // foreach($v1 as $k2 => $v2){ ?>
                </tr>
              </table>
              
              </td>
              <?
					
				}//end foreach($xarr as $k1 => $v1){
			  ?>
              </tr>
              <?
        if($xtype == "1"){
			$cong = " WHERE  keyin_group='1'";	
		}else if($xtype == "2"){
			$cong = " WHERE  keyin_group='2'";	
		}else if($xtype == "3"){
			$cong = " WHERE  keyin_group='3'";
		}

			  $sql = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff $cong  ";	//  AND staffid='10378'
			$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#F0F0F0";}
			 
			 ?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname]   $rs[staffsurname]";?></td>
              <td align="center"><?=ShowGroup($rs[keyin_group]);?></td>
              <?
			  $qc_true = 0;
              foreach($xarr as $k3 => $v3){
				
			  ?>
              <td align="center">
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <? 
				$b1 = 0;
				
				foreach($v3 as $k4 => $v4){
					if ($b1++ %  2){ $bg2 = "#F0F0F0";}else{$bg2 = "#FFFFFF";}	
					//$xkey_val = ShowKeyPerson($rs[staffid],$v4);	
					$xkey_val = CountQC($rs[staffid],$v4)
				?>
               <td width="<?=$w1?>%" bgcolor="<?=$bg2?>" align="center"><? echo number_format($xkey_val);?></td>
               <?
			   		$sumkeyval += $xkey_val;
			   }//end  foreach($v3 as $k4 => $v4){ ?>
                </tr>
              </table>
              
              </td>
              <?
				  
			  }//end  foreach(){
			  ?>
              <td align="center"><? echo $sumkeyval; ?></td>
              <td align="center">&nbsp;</td>
            </tr>
            <?
			$qc_true = 0;
			$all_qc = 0;
			}//end 
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
</body>
</html>
