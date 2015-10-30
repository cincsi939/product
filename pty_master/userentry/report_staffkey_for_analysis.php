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
include("function_assign.php");
function GetArea($get_siteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];
}
function CountPersonArea(){
	global $db_temp;
	$sql = "SELECT COUNT(idcard) AS num1, siteid FROM tbl_checklist_kp7 GROUP BY siteid";
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountPersonArea(){

function ShowStaffKey(){
	global $db_name;
	$sql = "SELECT
	COUNT(tbl_assign_key.idcard) as numall,
SUM(if(keystaff.keyin_group=1 and sapphireoffice=0 and status_permit='YES',1,0)) as NUM1,
SUM(if(keystaff.keyin_group=2 and sapphireoffice=0 and status_permit='YES',1,0)) as NUM2,
SUM(if(keystaff.keyin_group=3 and sapphireoffice=0 and status_permit='YES',1,0)) as NUM3,
SUM(if(keystaff.keyin_group=4 and sapphireoffice=0 and status_permit='YES',1,0)) as NUM4,
SUM(if(sapphireoffice=2 and status_permit='YES',1,0)) as NUM_SUBC,
tbl_assign_key.siteid
FROM
tbl_assign_sub
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join keystaff ON keystaff.staffid = tbl_assign_sub.staffid
WHERE
tbl_assign_sub.nonactive =  '0' AND
tbl_assign_key.nonactive =  '0'
GROUP BY siteid";
//echo $sql;
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['numall'] = $rs[numall];
		$arr[$rs[siteid]]['NUM1'] = $rs[NUM1];
		$arr[$rs[siteid]]['NUM2'] = $rs[NUM2];
		$arr[$rs[siteid]]['NUM3'] = $rs[NUM3];
		$arr[$rs[siteid]]['NUM4'] = $rs[NUM4];
		$arr[$rs[siteid]]['NUM_SUBC'] = $rs[NUM_SUBC];
		
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function ShowStaffKey(){
	
######  นับจำนวนที่ QC
function CountQC($cong){
	global $db_name;
	
	if($cong == "1"){
		$conw = " where keystaff.keyin_group='1' and sapphireoffice='0' and status_permit='YES' ";	
	}else if($cong == "2"){
		$conw = " where keystaff.keyin_group='2' and sapphireoffice='0' and status_permit='YES' ";
	}else if($cong == "3"){
		$conw = " where keystaff.keyin_group='3' and sapphireoffice='0' and status_permit='YES' ";	
	}else if($cong == "4"){
		$conw = " where keystaff.keyin_group='4' and sapphireoffice='0' and status_permit='YES'";
	}else if($cong == "5"){
		$conw = " where sapphireoffice='2' and status_permit='YES' ";	
	}else{ 
		$conw = "";
	}
		
		$sql = "SELECT
Count( ".DB_CHECKLIST.".tbl_check_data.idcard) AS num1,
 ".DB_CHECKLIST.".tbl_check_data.secid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".validate_checkdata ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".validate_checkdata.idcard
Inner Join ".DB_USERENTRY.".keystaff ON ".DB_USERENTRY.".validate_checkdata.staffid = ".DB_USERENTRY.".keystaff.staffid
$conw
GROUP BY
 ".DB_CHECKLIST.".tbl_check_data.secid,
 ".DB_CHECKLIST.".tbl_check_data.idcard";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$numarr[$rs[secid]] = $numarr[$rs[secid]]+1; // 
	}//end  while($rs = mysql_fetch_assoc($result)){
	return $numarr;
}//end function CountQC(){

function ShowStaffQC($get_idcard){
	global $db_name;
	$sql = "SELECT
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
validate_checkdata
Inner Join keystaff ON validate_checkdata.qc_staffid = keystaff.staffid
WHERE
validate_checkdata.idcard =  '$get_idcard'
GROUP BY
validate_checkdata.staffid";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
if($rs[staffname] != "" and $rs[staffsurname] != ""){
return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}else{
	$sql = "SELECT
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
validate_checkdata
Inner Join keystaff ON validate_checkdata.staffid_check = keystaff.staffid
WHERE
validate_checkdata.idcard =  '$get_idcard'
GROUP BY
validate_checkdata.staffid";	
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}
		
}
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
</HEAD>
<BODY>
<? 
	if($action == ""){ 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="3%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="14%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>สพท.</strong></td>
        <td width="6%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวน<br>
          ทั้งหมด</strong></td>
        <td colspan="12" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากรที่คีย์ข้อมูล(คน)</strong></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        <td width="5%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>ค้าง</strong></td>
        </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>กลุ่ม A</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>กลุ่ม B</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong><br>
          กลุ่ม C</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>pattime</strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>ที่ออกไปแล้ว<br>
          หรือย้ายทำ<br>
          ทำหน้าที่ อื่น </strong></td>
        <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>subcontract</strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="6%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คีย์</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>QC</strong></td>
        </tr>
        <?
			$arr1 = CountPersonArea();// นับจำนวนบุคลากรในเขต
			$arr2 = ShowStaffKey();// นับจำนวนบุคลากรที่คีย์ข้อมูล
			$arrqc = CountQC(''); //  qc ทั้งหมด
			$arrqc1 = CountQC('1'); // กลุ่ม A
			$arrqc2 = CountQC('2');// กลุ่ม b
			$arrqc3 = CountQC('3');// กลุ่ม c
			$arrqc4 = CountQC('4');// กลุ่ม pattime
			$arrqc5 = CountQC('5');// กลุ่ม sumcontract
			// AND eduarea.secid IN('7002','2101','8401','5501')
        	$sql = "SELECT eduarea.secid,eduarea.secname FROM eduarea INNER JOIN eduarea_config ON eduarea.secid=eduarea_config.site WHERE eduarea_config.group_type='keydata' AND eduarea.secid IN('7002','2101','8401','5501')";	
			$result = mysql_db_query($dbnamemaster,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$num_key_other = $arr2[$rs[secid]]['numall']-($arr2[$rs[secid]]['NUM1']+$arr2[$rs[secid]]['NUM2']+$arr2[$rs[secid]]['NUM3']+$arr2[$rs[secid]]['NUM4']+$arr2[$rs[secid]]['NUM_SUBC']);
			$qc_other = $arrqc[$rs[secid]]-($arrqc1[$rs[secid]]+$arrqc2[$rs[secid]]+$arrqc3[$rs[secid]]+$arrqc4[$rs[secid]]+$arrqc5[$rs[secid]]);
			$sum_allp = $num_key_other+($arr2[$rs[secid]]['NUM1']+$arr2[$rs[secid]]['NUM2']+$arr2[$rs[secid]]['NUM3']+$arr2[$rs[secid]]['NUM4']+$arr2[$rs[secid]]['NUM_SUBC']);
			$numqcall = $arrqc[$rs[secid]];
			$numdif = $arr1[$rs[secid]]-$sum_allp;
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])?></td>
        <td align="center"><?=number_format($arr1[$rs[secid]])?></td>
        <td align="center"><? if($arr2[$rs[secid]]['NUM1'] > 0){ echo "<a href='?action=view&xgtype=1&xsiteid=$rs[secid]' target='_blank'>".number_format($arr2[$rs[secid]]['NUM1'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arrqc1[$rs[secid]])?></td>
        <td align="center"><? if($arr2[$rs[secid]]['NUM2'] > 0){ echo "<a href='?action=view&xgtype=2&xsiteid=$rs[secid]' target='_blank'>".number_format($arr2[$rs[secid]]['NUM2'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arrqc2[$rs[secid]])?></td>
        <td align="center"><? if($arr2[$rs[secid]]['NUM3'] > 0){ echo "<a href='?action=view&xgtype=3&xsiteid=$rs[secid]' target='_blank'>".number_format($arr2[$rs[secid]]['NUM3'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arrqc3[$rs[secid]])?></td>
        <td align="center"><? if($arr2[$rs[secid]]['NUM4'] > 0){ echo "<a href='?action=view&xgtype=4&xsiteid=$rs[secid]' target='_blank'>".number_format($arr2[$rs[secid]]['NUM4'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arrqc4[$rs[secid]])?></td>
        <td align="center"><? if($num_key_other > 0){ echo "<a href='?action=view&xgtype=5&xsiteid=$rs[secid]' target='_blank'>".number_format($num_key_other)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($qc_other)?></td>
        <td align="center"><? if($arr2[$rs[secid]]['NUM_SUBC'] > 0){ echo "<a href='?action=view&xgtype=6&xsiteid=$rs[secid]' target='_blank'>".number_format($arr2[$rs[secid]]['NUM_SUBC'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($arrqc5[$rs[secid]])?></td>
        <td align="center"><? if($sum_allp > 0){ echo "<a href='?action=view&xgtype=7&xsiteid=$rs[secid]' target='_blank'>".number_format($sum_allp)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($numqcall);?></td>
        <td align="center"><?=number_format($numdif);?></td>
        </tr>
        <?
		$xsumall += $arr1[$rs[secid]];
		$xsum1 += $arr2[$rs[secid]]['NUM1'];
		$xsum2 += $arrqc1[$rs[secid]];
		$xsum3 += $arr2[$rs[secid]]['NUM2'];
		$xsum4 += $arrqc2[$rs[secid]];
		$xsum5 += $arr2[$rs[secid]]['NUM3'];
		$xsum6 +=  $arrqc3[$rs[secid]];
		$xsum7 += $arr2[$rs[secid]]['NUM4'];
		$xsum8 += $arrqc4[$rs[secid]];
		$xsum9 += $num_key_other;
		$xsum10 += $qc_other;
		$xsum11 += $arr2[$rs[secid]]['NUM_SUBC'];
		$xsum12 += $arrqc5[$rs[secid]];
		$xsum13 += $sum_allp;
		$xsum14 += $numqcall;
		$xsum15 += $numdif;
		
		
		
	   		$numqcall = 0;
			$numdif = 0;
	   		$qc_other = 0;
	   		$num_key_other = 0;
			$sum_allp = 0;
			}//end while($rs = mysql_fetch_assoc($result)){

	   ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsumall)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum1)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum2)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum3)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum4)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum5)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum6)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum7)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum8)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum9)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum10)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum11)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum12)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum13)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($xsum14)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($xsum15)?></td>
      </tr>
    </table></td>
  </tr>
</table>

  <? 
  } //end if($action == ""){
	if($action == "view"){
		
		if($xgtype == "1"){ // กลุ่ม A
			$conw = " AND (keystaff.keyin_group='1' AND sapphireoffice='0' AND status_permit='YES')";	
			$xHead = " พนักงาน กลุ่ม A";
		}else if($xgtype == "2"){ // กลุ่ม B
			$conw = " AND (keystaff.keyin_group='2' AND sapphireoffice='0' AND status_permit='YES') ";	
			$xHead = " พนักงาน กลุ่ม B";
		}else if($xgtype == "3"){ // กลุ่ม C
			$conw = " AND (keystaff.keyin_group='3' AND sapphireoffice='0' AND status_permit='YES')";	
			$xHead = " พนักงาน กลุ่ม C";
		}else if($xgtype == "4"){ // กลุ่ม pattime
			$conw = " AND (keystaff.keyin_group='4' AND sapphireoffice='0' AND status_permit='YES')";	
			$xHead = " พนักงาน กลุ่ม Pattime";
		}else if($xgtype == "5"){
			$conw = " AND ((status_permit='NO' and (keyin_group NOT IN('1','2','3','4') OR keyin_group IS NULL)) OR (status_permit='YES' AND status_extra <> 'NOR' AND (keyin_group NOT IN('1','2','3','4') OR keyin_group IS NULL)) ) AND sapphireoffice <> '2'";
			//$conW = " AND (keystaff.keyin_group <> '1' AND sapphireoffice <> '0' AND status_permit <> 'YES') AND  (keystaff.keyin_group <> '2' AND sapphireoffice <> '0' AND status_permit <> 'YES') AND (keystaff.keyin_group <> '3' AND sapphireoffice <> '0' AND status_permit <> 'YES') AND (keystaff.keyin_group <> '4' AND sapphireoffice <> '0' AND status_permit <> 'YES')";
			$xHead = " พนักงานกลุ่มที่ออกไปแล้วหรือเคยเป็นพนักงานคีย์แต่ไปทำหน้าที่อื่น";
		}else if($xgtype == "6"){
				$conw = " AND (sapphireoffice='2' AND status_permit='YES')";
				$xHead = " พนักงาน กลุ่ม Subcontract";
		}else if($xgtype == "7"){
			$conw = " ";
			$xHead = " พนักงาน ทั้งหมด";				
		}
		//echo "ex:: ".$xgtype;
		$sql1 = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.idcard,
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid,
 ".DB_CHECKLIST.".tbl_checklist_kp7.prename_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.name_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.surname_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.position_now, ".DB_USERENTRY.".keystaff.staffid, ".DB_USERENTRY.".keystaff.prename, ".DB_USERENTRY.".keystaff.staffname, ".DB_USERENTRY.".keystaff.staffsurname
FROM ".DB_USERENTRY.".tbl_assign_sub
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
Inner Join ".DB_USERENTRY.".keystaff ON ".DB_USERENTRY.".keystaff.staffid = ".DB_USERENTRY.".tbl_assign_sub.staffid
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 ON ".DB_USERENTRY.".tbl_assign_key.idcard =  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard
WHERE ".DB_USERENTRY.".tbl_assign_sub.nonactive =  '0' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid = '$xsiteid'
$conw
order by ".DB_USERENTRY.".keystaff.staffid ASC
";
//echo $sql1;
$result = mysql_db_query($db_name,$sql1);
$NUMKEY = @mysql_num_rows($result);

$sql2 = "SELECT
 ".DB_CHECKLIST.".tbl_checklist_kp7.idcard
FROM ".DB_USERENTRY.".tbl_assign_sub
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
Inner Join ".DB_USERENTRY.".keystaff ON ".DB_USERENTRY.".keystaff.staffid = ".DB_USERENTRY.".tbl_assign_sub.staffid
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 ON ".DB_USERENTRY.".tbl_assign_key.idcard =  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard
WHERE ".DB_USERENTRY.".tbl_assign_sub.nonactive =  '0' AND ".DB_USERENTRY.".tbl_assign_key.nonactive =  '0' AND
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid = '$xsiteid'
$conw
GROUP BY ".DB_USERENTRY.".keystaff.staffid
";
//echo $sql2;
$result2 = mysql_db_query($db_name,$sql2);
$numk2 = @mysql_num_rows($result2);

### sql qc
$sql3 = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".validate_checkdata ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".validate_checkdata.idcard
Inner Join ".DB_USERENTRY.".keystaff ON ".DB_USERENTRY.".validate_checkdata.staffid = ".DB_USERENTRY.".keystaff.staffid
WHERE  ".DB_CHECKLIST.".tbl_check_data.secid='$xsiteid'
$conw
GROUP BY
 ".DB_CHECKLIST.".tbl_check_data.idcard";
$result3 = mysql_db_query($db_name,$sql3);
$numQC = @mysql_num_rows($result3);

$sql4 = "SELECT ".DB_USERENTRY.".validate_checkdata.qc_staffid
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".validate_checkdata ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".validate_checkdata.idcard
Inner Join ".DB_USERENTRY.".keystaff ON ".DB_USERENTRY.".validate_checkdata.staffid = ".DB_USERENTRY.".keystaff.staffid
WHERE  ".DB_CHECKLIST.".tbl_check_data.secid='$xsiteid'
$conw
GROUP BY ".DB_USERENTRY.".validate_checkdata.qc_staffid
";
$result4 = mysql_db_query($db_name,$sql4);
$numQCP = @mysql_num_rows($result4);


	
	//echo $sql1;
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"><table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="41%" rowspan="3" align="center" bgcolor="#A3B2CC"><strong>หมวดรายการ</strong></td>
              <td colspan="2" align="center" bgcolor="#A3B2CC"><strong><? echo $xHead;?></strong></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>จำนวนเอกสร</strong></td>
              </tr>
            <tr>
              <td width="15%" align="center" bgcolor="#A3B2CC"><strong>จำนวนชุด(ชุด)</strong></td>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>จำนวนคน(คน)</strong></td>
              </tr>
            <tr>
              <td bgcolor="#A3B2CC"><strong>จำนวนเอกสารที่คีย์</strong></td>
              <td align="center" bgcolor="#A3B2CC"><?=$NUMKEY?></td>
              <td align="center" bgcolor="#A3B2CC"><? echo $numk2;?></td>
              </tr>
            <tr>
              <td bgcolor="#A3B2CC"><strong>จำนวนเอกสารที่ QC</strong></td>
              <td align="center" bgcolor="#A3B2CC"><?=$numQC?></td>
              <td align="center" bgcolor="#A3B2CC"><?=$numQCP?></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>
            <? echo GetArea($xsiteid);?>
        </strong></td>
        </tr>
        <tr>
          <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
          <td width="15%" align="center" bgcolor="#A3B2CC"><strong>เลขบัตรประชาชน</strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล</strong></td>
          <td width="26%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>ชื่อพนักงานคีย์ข้อมูล</strong></td>
          <td width="17%" align="center" bgcolor="#A3B2CC"><strong>ชื่อพนักงาน QC</strong></td>
        </tr>
        <?
        	
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="center"><? echo $rs[idcard];?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left"><? echo "$rs[position_now]"; ?></td>
          <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
          <td align="left"><? echo ShowStaffQC($rs[idcard]);?></td>
        </tr>
        <?
			}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
  </tr>
</table>
<?
	}//end  //	if($action == "view"){
?>
</BODY>
</HTML>
