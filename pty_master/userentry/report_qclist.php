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
include "epm.inc.php";

$time_list = "6"; // เวลาเฉลียในการลง list ต่อ 1  ชุด
$time_sec = "360";

$time_per_day = 420; //  1 ;ทำงาน 7 ชม. 420 นาที
$time_per_doc = 2.6 ; // 1 ชุดใช้เวลา 2.6 นาที






	
	

$work_id = 4;
$report_title = "รายงานการบันทึกจุดผิดในระบบ QC ของพนักงานลง List ทีมตรวจคำผิด";
$start_yy = "2553";
if($mm == ""){
		$mm = date("m");
}
if($yy == ""){
		$yy = date("Y")+543;
}


$yymm = ($yy-543)."-".$mm;
$yymm1 = ($yy-543)."-".sprintf("%02d",$mm);
$arrday = XShowDayOfMonth($yymm);
function CountArray2D($arrday){
	$i=0;
		if(count($arrday) > 0){
				foreach($arrday as $k => $v){
						foreach($v as $k1 => $v1){
								$i++;
						}
				}
		}
		return $i;
}// end function CountArray2D($arrday){

$numday = CountArray2D($arrday); // จำนวนวันที่ที่ต้องแสดง
//echo "<pre>";
//print_r($arrday);
//$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
function GetStaffidQCList(){
	global $dbnameuse,$work_id;
	$sql = "SELECT
keystaff.staffid
FROM
keystaff
Inner Join keystaff_work_detail ON keystaff.staffid = keystaff_work_detail.staffid
Inner Join keystaff_work ON keystaff_work_detail.work_id = keystaff_work.work_id
WHERE
keystaff_work.work_id =  '$work_id'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($in_staff > "") $in_staff .= ",";
			$in_staff .= "'$rs[staffid]'";
	}//end while($rs = mysql_fetch_assoc($result)){
	return $in_staff;	
}//end function GetStaffidQCList(){


function GetPoint($yymm){
	global $dbnameuse;
	$inid = GetStaffidQCList();
	if($inid != ""){
			$conv = " AND  staffid_check IN($inid)";
	}else{
			$conv = " AND staffid_check > 0";	
	}
	$sql = "SELECT staffid_check,date_check,count(distinct idcard) as num1,sum(num_point) as sumpoint FROM `validate_checkdata` where  date_check LIKE '$yymm%'  $conv group by staffid_check,date_check;";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid_check]][$rs[date_check]]['num'] = $rs[num1];
			$arr[$rs[staffid_check]][$rs[date_check]]['point'] = $rs[sumpoint];
	}
	return $arr;
}//end function GetPoint($yymm){




function xshow_area($siteid){
	$sql_area = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result_area = mysql_db_query("edubkk_master",$sql_area);
	$rs_a = mysql_fetch_assoc($result_area);
	$xshow_area = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname]);
	return $xshow_area;
}


function show_school($schoolid){
		$sql_school = "SELECT office  FROM allschool WHERE id='$schoolid'";
		$result_school = mysql_db_query("edubkk_master",$sql_school);
		$rs_s = mysql_fetch_assoc($result_school);
		return $rs_s[office];
}

function count_salary($siteid,$idcard){
	$db_site = STR_PREFIX_DB.$siteid;
		$sql_count = "SELECT COUNT(id) AS num FROM salary WHERE id='$idcard'";
		$result_count = mysql_db_query($db_site,$sql_count);
		$rs_c = mysql_fetch_assoc($result_count);
		return $rs_c[num];
}

function last_date_salary($siteid,$idcard){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql_salary = "SELECT * FROM salary WHERE id='$idcard' AND date LIKE '2552-04%' ORDER BY date DESC LIMIT 0,1";
		$result_salary = mysql_db_query($db_site,$sql_salary);
		$rs_salary = mysql_fetch_assoc($result_salary);
		return $rs_salary[date];
}

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){
	
	$arr1 = GetPoint($yymm1);
	//echo "$yymm1 <pre>";
	//print_r($arr1);
	?>
<form action="" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="10%" align="right"><strong>เลือกเดือนปีที่ลงจุดผิด : </strong></td>
        <td width="10%" align="left">
          <select name="mm" id="mm">
          <?
          	foreach($monthname as $key => $val){
				if($val == ""){ $txt_month = "-เลือกเดือน-";}	else{ $txt_month = "$val";}	
				if(intval($mm) == $key){ $sel = " selected='selected'";}else{ $sel = "";}
				echo "<option value='$key' $sel>$txt_month</option>";
			}//end foreach($monthname as $key => $val){
		  ?>
          </select> 
          <strong>ปี</strong>
          <select name="yy" id="yy">
          <option value="">เลือกปี</option>
          <?
          	for($i=$start_yy;$i<=(date("Y")+543);$i++){
				if($yy == $i){ $sel = " selected='selected'";}else{ $sel = "";}
				echo "<option value='$i' $sel>$i</option>";	
			}
		  ?>
        </select>
</td>
        <td width="80%" align="left"><input type="submit" name="button" id="button" value="แสดงรายงาน"></td>
      </tr>
      <tr>
        <td align="right"><strong>หมายเหตุ :</strong></td>
        <td colspan="2" align="left"> C1 คือ <strong>keyboard เว้นว่าง(นาที)</strong></td>
        </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td colspan="2" align="left">C2 คือ <strong>จำนวนชุดที่ลง List ได้(ชุด)</strong></td>
        </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td colspan="2" align="left">C3 คือ <strong>จำนวนจุดผิดรวม(จุด)</strong></td>
        </tr>
    </table></td>
  </tr>

  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=8+($numday*3)?>" align="left" bgcolor="#A3B2CC"><img src="../../images_sys/docnew.png" width="33" height="23"><strong><?=$report_title?></strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="22%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล</strong></td>
        <?
		if(count($arrday) > 0){
        	foreach($arrday as $key => $val){
				foreach($val as $key1 => $val1){		
		?>
        <td colspan="3" align="center" bgcolor="#A3B2CC"><strong><?=DBThaiLongDate($val1);?></strong></td>
        <?
				}//end foreach($val as $key1 => $val1){		
			}//end foreach($arrday as $key => $val){
		}//end 	if(count($arrday) > 0){
		?>
        <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        </tr>
      <tr>
      <?
      		if(count($arrday) > 0){
        	foreach($arrday as $key => $val){
				foreach($val as $key1 => $val1){	
	  ?>
        <td width="27%" align="center" bgcolor="#A3B2CC"><strong>C1</strong></td>
        <td width="28%" align="center" bgcolor="#A3B2CC"><strong>C2</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>C3</strong></td>
   
      <?
      					}//end foreach($val as $key1 => $val1){		
			}//end foreach($arrday as $key => $val){
		}//end 	if(count($arrday) > 0){

	  ?>
        <td width="27%" align="center" bgcolor="#A3B2CC"><strong>C1</strong></td>
        <td width="28%" align="center" bgcolor="#A3B2CC"><strong>C2</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>C3</strong></td>

         </tr>
         <?
         	$sqlstaff = "SELECT t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t3.workname FROM keystaff AS t1 INNER JOIN keystaff_work_detail AS t2  ON t1.staffid=t2.staffid INNER JOIN keystaff_work AS t3 ON t2.work_id=t3.work_id WHERE t3.work_id='$work_id' AND t3.status_active='1' ";
			$resultstaff = mysql_db_query($dbnameuse,$sqlstaff) or die(mysql_error()."$sqlstaff<br>LINE::".__LINE__);
			$j=0;
			$numC1 =0;
			$numC2 =0;
			$numC3 =0;
			while($rs = mysql_fetch_assoc($resultstaff)){
			 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left" nowrap><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <?
        	    
      		if(count($arrday) > 0){
        	foreach($arrday as $key => $val){
				foreach($val as $key1 => $val1){	
				
				if($arr1[$rs[staffid]][$val1]['num'] > 0){
					$temp_numC1 = $time_per_day-($arr1[$rs[staffid]][$val1]['num']*$time_per_doc);
				}
				
	  ?>


        <td align="center"><? if($temp_numC1 > 0){echo number_format($temp_numC1);}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arr1[$rs[staffid]][$val1]['num'])?></td>
        <td align="center"><?=number_format($arr1[$rs[staffid]][$val1]['point'])?></td>
        <?			if($temp_numC1 > 0){
						$numC1 += $temp_numC1;
					}
					$numC2 += $arr1[$rs[staffid]][$val1]['num'];
					$numC3 += $arr1[$rs[staffid]][$val1]['point'];
					
					$temp_numC1= 0;
        	      }//end foreach($val as $key1 => $val1){		
			}//end foreach($arrday as $key => $val){
		}//end 	if(count($arrday) > 0){
		?>
         <td align="center"><?=number_format($numC1)?></td>
        <td align="center"><?=number_format($numC2)?></td>
        <td align="center"><?=number_format($numC3)?></td>

      </tr>
      <?
	  $temp_numC1 = 0;
	  $numC1 = 0;
	  $numC2 = 0;
	  $numC3 = 0;
		}//end while($rs = mysql_fetch_assoc($resultstaff)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
  </form>
 <?
}//end if($action == ""){
 ?>
</BODY>
</HTML>
