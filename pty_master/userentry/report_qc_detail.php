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
$col_w = 70;

function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		//echo "$db_name :: ".$sql;
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[numkpoint] > 0){
			return floor($rs[numkpoint]/$point_num);
		}else{
			return 0;	
		}
		
}

function CheckQCPerDay($get_staff,$get_date){
global $db_name;
$sql1 = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' and datecal LIKE '$get_date%'  group by idcard;";
$result1 = mysql_db_query($db_name,$sql1);
$numr = @mysql_num_rows($result1);
return $numr;
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


####  
	if($action == "view_detail"){
			$date_title = "วันที่  ".ShowDateThai($datekey);
			$get_yymm = $datekey;
	}else{
			$date_title = " ประจำเดือน ".$monthFull[intval($mm)]."  $yy1";	
			$get_yymm = ($yy1-543)."-".sprintf("%02d",$mm);
	}//end if($action == "view_detail"){
		
		
		##########  function ตรวจสอบ การตรวจคำผิดแล้วจาก ทีมตรวจคำผิด
		function CheckWordKey($get_idcard){
				global $db_name;
				$sql = "SELECT COUNT(idcard) as num1 FROM temp_qc WHERE idcard='$get_idcard' AND status_qc='1'";
				$result = mysql_db_query($db_name,$sql);
				$rs = mysql_fetch_assoc($result);
				return $rs[num1];
		}//end function CheckWordKey($get_idcard){
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
          <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="left" bgcolor="#D4D4D4"><strong>รายการคีย์ข้อมูลของ <? echo ShowStaffKey($staffid); echo $date_title;?></strong></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="13%" align="center" bgcolor="#D4D4D4"><strong>รหัสบัตร</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="22%" align="center" bgcolor="#D4D4D4"><strong>เขตพื้นที่การศึกษา</strong></td>
              <td width="17%" align="center" bgcolor="#D4D4D4"><strong>วันที่คีย์ข้อมูล</strong></td>
              <td width="10%" align="center" bgcolor="#D4D4D4"><strong>QC</strong></td>
            </tr>
            <? 
				
				$sql = "SELECT * FROM monitor_keyin WHERE staffid='$staffid' AND timeupdate LIKE '$get_yymm%' ORDER BY timeupdate ASC";
				//echo $sql;
				$result = mysql_db_query($db_name,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFF";}
					$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
					if(is_file($pathfile)){
								$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" title=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
								$pdf_file = "";
							}//end if(is_file($pathfile))
							
						##### 
						if(CheckQcPerDayPerson($rs[staffid],$rs[idcard]) > 0){
								$bg = "#009900";
						}else{
								$bg = $bg;	
						}
						
						
					if(CheckWordKey($rs[idcard]) > 0){
							$syb = "<strong><font color='#000000'>*</font></strong>";
					}else{
							$syb = ""	;
					}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="left"><? echo "$rs[keyin_name]";?></td>
              <td align="left"><? echo ShowArea($rs[siteid]);?></td>
              <td align="center"><? echo ShowDateThai($rs[timeupdate]);?></td>
              <td align="center"><?=$syb?>&nbsp;<?=$pdf_file?>&nbsp;<a href="../../hr_report/report_check/report_check_data_new.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../../../validate_management/images/zoom.png" width="16" height="16" / border="0" title="หน้ารายงานเทียบ label กับ value"></a>&nbsp;
              <? /*if(CheckOnlineKey($rs[idcard]) < 1){*/ // อนุญาตให้ QC ได้ก็ต่อเมื่อไม่ได้คีย์ข้อมูลเสร็จแล้วเท่านั้น?>
              <a href="validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<?=$rs[keyin_name]?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../../../validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a>
              <? /* }else{  echo "<img src=\"../../../../images_sys/useronline.gif\" width=\"18\" height=\"18\" border=\"0\" title=\"ขณะนี้กำลังคีย์ข้อมูลอยู่ไม่อนุญาติให้ตรวจสอบความถูกต้องของข้อมูล\">";}*/?>
              </td>
            </tr>
            <? 
				}
			?>
          </table></td>
        </tr>
        <tr>
          <td><em>หมายเหตุ :: สัญลักษณ์เครื่องหมายดอกจันคือ ข้อมูลของบุคลากรที่ผ่านการตรวจคำผิดจากทีมตรวจคำผิดเรียบร้อยแล้ว</em></td>
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
