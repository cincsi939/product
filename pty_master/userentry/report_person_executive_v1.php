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
	## Modified Detail :		รายงานข้อมูลบุคลากรในกลุ่มผู้บริหารและเจ้าหน้าที่ประจำเขต
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
set_time_limit(0);
include "epm.inc.php";
$numH_target = 255; // จำนวนผอ.สพท.
if($_SERVER['REQUEST_METHOD'] == "GET"){
	if($_GET['action'] == "process"){
	### ทำการลบข้อมูลการจัดเก็บใน temp
	mysql_db_query($dbnamemaster,"DELETE FROM view_person_executive");
	### เก็บข้อมูลบุคลากรในเขต
		$sql_insert = "REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,pid,schoolid)
		SELECT
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.pid,
t1.schoolid
FROM
view_general AS t1
Inner Join eduarea AS t2 ON t1.schoolid = t2.secid";
	mysql_db_query($dbnamemaster,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
	
## เก็บข้อมูลผู้บริหารโรงเรียน
$sql_insert1 = "REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,pid,schoolid)
SELECT
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.pid,
t1.schoolid
FROM
view_general AS t1
WHERE
t1.pid IN('325001002','325001003','325001005','325001006','325001007','325001010','325471008','325471009','325471012','325471013','325481014','325481015')
";
mysql_db_query($dbnamemaster,$sql_insert1) or die(mysql_error()."".__LINE__);

### ข้อมูลใน checklist ที่ไม่มีใน cmss
$sql_insert2 = " REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_data) 
SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,0
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join  ".DB_MASTER.".eduarea AS t3 ON t2.schoolid = t3.secid
GROUP BY
t1.idcard
";
mysql_db_query($dbnamemaster,$sql_insert2) or die(mysql_error()."$sql_insert2<br>LINE__".__LINE__);

########### ข้อมูลผู้บริหารสถานศึกษา
$sql_insert3 = " REPLACE INTO view_person_executive(idcard,siteid,prename_th,name_th,surname_th,birthday,begindate,position_now,schoolid,status_data) 
SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,0
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
where t2.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการสถานศึกษา','ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','รองผู้อำนวยการสถานศึกษา','ผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการวิทยาลัย','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ')
GROUP BY
t1.idcard";
mysql_db_query($dbnamemaster,$sql_insert3) or die(mysql_error()."$sql_insert3<br>LINE__".__LINE__);


############  update ข้อมูล 

$sqlmain = "SELECT
t1.idcard,
t1.siteid,
t1.pid,
t1.position_now
FROM
view_person_executive AS t1
WHERE
t1.status_process =  '0'";
$resultmain = mysql_db_query($dbnamemaster,$sqlmain) or die(mysql_error()."$sqlmain<br>LINE__".__LINE__);
while($rsm = mysql_fetch_assoc($resultmain)){
	
	### ตรวจสอบการ QC 
	
	$sql_qc = "SELECT count(idcard) as numqc FROM `validate_checkdata` where idcard='$rsm[idcard]' group by idcard;";
	$result_qc = mysql_db_query($dbnameuse,$sql_qc) or die(mysql_error()."$sql_qc<br>LINE__".__LINE__);
	$rs_qc = mysql_fetch_assoc($result_qc);
	if($rs_qc[numqc] > 0){
			$status_qc = "1";
	}else{
			$status_qc = "0";
	}
	
	### ตรวจสอบการยื่นคำร้อง
	$sql_req = "SELECT count(idcard) as num_req  FROM `req_problem_person` where idcard='$rsm[idcard]' group by idcard;";
	$result_req = mysql_db_query($dbnamemaster,$sql_req) or die(mysql_error()."$sql_req<br>LINE__".__LINE__);
	$rs_req = mysql_fetch_assoc($result_req);
	if($rs_req[num_req] > 0){
			$status_send_req = "1";
	}else{
			$status_send_req = "0";	
	}
	
	if($rsm[pid] == ""){ 
			$sqlpid = "SELECT t1.pid FROM hr_addposition_now AS t1 WHERE t1.`position` =  '$rsm[position_now]' ";
			$resultpid= mysql_db_query($dbnamemaster,$sqlpid) or die(mysql_error()."$sqlpid<br>LINE__".__LINE__);
			$rspid = mysql_fetch_assoc($resultpid);
			$update_pid = ",pid='$rspid[pid]'";
	}else{
			$update_pid = " ";	
	}//end if($rsm[pid] == ""){
		
	# update ข้อมูล
	
	$sql_up = "UPDATE view_person_executive SET status_qc='$status_qc',status_send_req='$status_send_req',status_process='1' $update_pid  WHERE idcard='$rsm[idcard]' ";
	mysql_db_query($dbnamemaster,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
	
		
}//end while($rsm = mysql_fetch_assoc($resultmain)){

			
	}//end if($_GET['action'] == "process"){
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){

?>

<html>
<head>
<title>Report Person QC</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>

<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</script>

<style type="text/css">
<!--
.style1 {

	text-decoration: underline;
	
}
-->
</style>
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>
</head>
<body bgcolor="#EFEFFF">

  <?
		  $sql_data = "SELECT
t1.siteid,
sum(if(t1.pid='125471008',1,0)) as num_exA_All,
sum(if(t1.pid='125471008' and (t1.status_data='1' or t1.status_data='1'),1,0)) as num_exA_areaT,
sum(if(t1.pid='125471008' and (t1.status_data='0' and t1.status_data='0'),1,0)) as num_exA_areaF,
sum(if(t1.pid IN('125471009','125471064','125471065','125471066'),1,0)) as num_exA1_All,
sum(if(t1.pid IN('125471009','125471064','125471065','125471066') and (t1.status_data='1' or t1.status_data='1') ,1,0)) as num_exA1_areaT,
sum(if(t1.pid IN('125471009','125471064','125471065','125471066') and (t1.status_data='0' and t1.status_data='0'),1,0)) as num_exA1_areaF,
sum(if(t1.pid='225471000',1,0)) as num_exA2_All,
sum(if(t1.pid='225471000' and (t1.status_data='1' or t1.status_data='1'),1,0)) as num_exA2_areaT,
sum(if(t1.pid='225471000' and (t1.status_data='0' and t1.status_data='0'),1,0)) as num_exA2_areaF,
sum(if(t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000'),1,0 )) as num_exA3_All,
sum(if(t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000') and (t1.status_data='1' or t1.status_data='1'),1,0 )) as num_exA3_areaT,
sum(if(t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000') and (t1.status_data='0' and t1.status_data='0'),1,0 )) as num_exA3_areaF,
sum(if(t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ'),1,0)) as num_exH_All,
sum(if(t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ') and (t1.status_data='1' or t1.status_data='1'),1,0)) as num_exH_schoolT,
sum(if(t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ') and (t1.status_data='0' and t1.status_data='0'),1,0)) as num_exH_schoolF,
sum(if(t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา'),1,0)) as num_exH1_All,
sum(if(t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา') and (t1.status_data='1' or t1.status_data='1'),1,0)) as num_exH1_schoolT,
sum(if(t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา') and (t1.status_data='0' and t1.status_data='0'),1,0)) as num_exH1_schoolF
FROM
view_person_executive AS t1
group by t1.siteid";
$result_data = mysql_db_query($dbnamemaster,$sql_data) or die(mysql_error()."$sql_data<br>LINE__".__LINE__);
while($rsd = mysql_fetch_assoc($result_data)){
	$site =$rsd[siteid];
	$arr_data[$site]['num1_A'] = $rsd[num_exA_All];	 // ผู้อำนวยการเขต
	$arr_data[$site]['num1_T'] = $rsd[num_exA_areaT];	
	$arr_data[$site]['num1_F'] = $rsd[num_exA_areaF];	
	
	$arr_data[$site]['num2_A'] = $rsd[num_exA1_All];	 // รองผู้อำนวยการเขต
	$arr_data[$site]['num2_T'] = $rsd[num_exA1_areaT];	
	$arr_data[$site]['num2_F'] = $rsd[num_exA1_areaF];	
	
	
	$arr_data[$site]['num3_A'] = $rsd[num_exA2_All];	 // ศึกษานิเทศก์
	$arr_data[$site]['num3_T'] = $rsd[num_exA2_areaT];	
	$arr_data[$site]['num3_F'] = $rsd[num_exA2_areaF];	
	
	$arr_data[$site]['num4_A'] = $rsd[num_exA3_All];	 // 38 ค
	$arr_data[$site]['num4_T'] = $rsd[num_exA3_areaT];	
	$arr_data[$site]['num4_F'] = $rsd[num_exA3_areaF];	
	
	$arr_data[$site]['num5_A'] = $rsd[num_exH_All];	 // ผอ.สถานศึกษา
	$arr_data[$site]['num5_T'] = $rsd[num_exH_schoolT];	
	$arr_data[$site]['num5_F'] = $rsd[num_exH_schoolF];	
	
	$arr_data[$site]['num6_A'] = $rsd[num_exH1_All];	 // รองผอ.สถานศึกษา
	$arr_data[$site]['num6_T'] = $rsd[num_exH1_schoolT];	
	$arr_data[$site]['num6_F'] = $rsd[num_exH1_schoolF];	
	
}//end while($rsd = mysql_fetch_assoc($result_data)){
	
	
	#### รวมจำนวนผอ.สพท. ทั้งหมด
	
	if(count($arr_data) > 0){
		foreach($arr_data as $k1 => $v1){
				$exsum_1 += $v1['num1_A']; // ผอ.เขต
				$exsum_1T += $v1['num1_T']; // ผอ.เขต
						
				$exsum_2 += $v1['num2_A']; // รองผอ.เขต
				$exsum_2T += $v1['num2_T']; // รองผอ.เขต
				
				$exsum_3 += $v1['num3_A']; // ศึกษานิเทศก์
				$exsum_3T += $v1['num3_T']; // ศึกษานิเทศก์
				
				$exsum_4 +=  $v1['num4_A']; // 38 ค
				$exsum_4T +=  $v1['num4_T']; // 38 ค
				
				$exsum_5 += $v1['num5_A']; // ผอ.สถานศึกษา
				$exsum_5T += $v1['num5_T']; // ผอ.สถานศึกษา
				
				$exsum_6 += $v1['num6_A']; // รองผอ.สถานศึกษา
				$exsum_6T += $v1['num6_T']; // รองผอ.สถานศึกษา
				
		}// end foreach($arr_data as $k1 => $v1){
	}//end if(count($arr_data) > 0){
	
	  

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" bgcolor="#999999"><a href="CCreport_person_executive.php" target="_blank">คลิ๊กเพื่อประมวลผล</a> </td>
  </tr>
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#666666"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="4" align="center" bgcolor="#CCCCCC"><strong> รายงานข้อมูลข้าราชการครูและบุคลากรทางการศึกษาที่ QC และค้าง QC</strong></td>
          </tr>
          <tr>
            <td width="34%" align="center" bgcolor="#CCCCCC"><strong>กลุ่มบุคลากรใน สพท.</strong></td>
            <td width="22%" align="center" bgcolor="#CCCCCC"><strong>เป้าหมายรวมทั้งหมด(คน)</strong></td>
            <td width="21%" align="center" bgcolor="#CCCCCC"><strong>QC และยื่นคำร้อง(คน)</strong></td>
            <td width="23%" align="center" bgcolor="#CCCCCC"><strong>คงค้างงานที่ต้อง QC (คน)</strong></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">ผอ.สพท.</td>
            <td align="right" bgcolor="#FFFFFF"><? if($numH_target > $exsum_1 ){ echo "<font color=\"#FF0000\">".number_format($numH_target)."</font>";}else{ echo number_format($exsum_1);}?></td>
            <td align="right" bgcolor="#FFFFFF"><? echo number_format($exsum_1T);?></td>
            <td align="right" bgcolor="#FFFFFF"><? echo number_format($numH_target-$exsum_1T);?></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">รอง ผอ.สพท.</td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_2)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_2T)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_2-$exsum_2T)?></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">บุคลากร 38 ค(2)</td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_3)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_3T)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_3-$exsum_3T)?></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">ศึกษานิเทศก์</td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_4)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_4T)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_4-$exsum_4T)?></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">ผอ.สถานศึกษา</td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_5)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_5T)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_5-$exsum_5T)?></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">รอง ผอ.สถานศึกษา</td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_6)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_6T)?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format($exsum_6-$exsum_6T)?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><strong>รวม</strong></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format(($numH_target+$exsum_2+$exsum_3+$exsum_4+$exsum_5+$exsum_6))?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format(($exsum_1T+$exsum_2T+$exsum_3T+$exsum_4T+$exsum_5T+$exsum_6T))?></td>
            <td align="right" bgcolor="#FFFFFF"><?=number_format(($numH_target+$exsum_2+$exsum_3+$exsum_4+$exsum_5+$exsum_6)-($exsum_1T+$exsum_2T+$exsum_3T+$exsum_4T+$exsum_5T+$exsum_6T))?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td width="3%" rowspan="3" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" rowspan="3" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td colspan="12" align="center" bgcolor="#CCCCCC"><strong>บุคลากรใน สพท.</strong></td>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>บุคลากรในโรงเรียน</strong></td>
        </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ผอ.สพท.</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รอง ผอ.สพท.</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>บุคลากร 38 ค(2)</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ศึกษานิเทศก์</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ผอ.สถานศึกษา</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รอง ผอ.สถานศึกษา</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
          ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>QC และ<br>
ยื่นคำร้อง</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ค้าง QC และ<br>
ยื่นคำร้อง</strong></td>
      </tr>
      <?
	 # echo "<pre>";
	  #print_r($arr_data);
      	$sql = "SELECT secid,secname_short,if(substring(secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite FROM eduarea WHERE secid NOT LIKE '99%'   ORDER BY  idsite,secname ASC";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $siteid = $rs[secid];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center" width="3%"><?=$i?></td>
        <td align="left" width="11%"><?=$rs[secname_short]?></td>
        <td align="right" width="4%"><? if($arr_data[$siteid]['num1_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=1A' target='_blank'>".number_format($arr_data[$siteid]['num1_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="4%"><? if($arr_data[$siteid]['num1_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=1T' target='_blank'>".number_format($arr_data[$siteid]['num1_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num1_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=1F' target='_blank'>".number_format($arr_data[$siteid]['num1_F'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="4%"><? if($arr_data[$siteid]['num2_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=2A' target='_blank'>".number_format($arr_data[$siteid]['num2_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num2_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=2T' target='_blank'>".number_format($arr_data[$siteid]['num2_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num2_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=2F' target='_blank'>".number_format($arr_data[$siteid]['num2_F'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="4%"><? if($arr_data[$siteid]['num3_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=3A' target='_blank'>".number_format($arr_data[$siteid]['num3_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num3_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=3T' target='_blank'>".number_format($arr_data[$siteid]['num3_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num3_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=3F' target='_blank'>".number_format($arr_data[$siteid]['num3_F'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num4_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=4A' target='_blank'>".number_format($arr_data[$siteid]['num4_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num4_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=4T' target='_blank'>".number_format($arr_data[$siteid]['num4_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num4_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=4F' target='_blank'>".number_format($arr_data[$siteid]['num4_F'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num5_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=5A' target='_blank'>".number_format($arr_data[$siteid]['num5_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="6%"><? if($arr_data[$siteid]['num5_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=5T' target='_blank'>".number_format($arr_data[$siteid]['num5_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num5_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=5F' target='_blank'>".number_format($arr_data[$siteid]['num5_F'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num6_A'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=6A' target='_blank'>".number_format($arr_data[$siteid]['num6_A'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="4%"><? if($arr_data[$siteid]['num6_T'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=6T' target='_blank'>".number_format($arr_data[$siteid]['num6_T'])."</a>";}else{ echo "0";}?></td>
        <td align="right" width="5%"><? if($arr_data[$siteid]['num6_F'] > 0){ echo "<a href='report_person_executive_detail.php?xsiteid=$siteid&xmode=6F' target='_blank'>".number_format($arr_data[$siteid]['num6_F'])."</a>";}else{ echo "0";}?></td>
      </tr>

      <?
	  	$sum1 += $arr_data[$siteid]['num1_A'];
		$sum2 += $arr_data[$siteid]['num1_T'];
		$sum3 += $arr_data[$siteid]['num1_F'];
		$sum4 += $arr_data[$siteid]['num2_A'];
		$sum5 += $arr_data[$siteid]['num2_T'];
		$sum6 += $arr_data[$siteid]['num2_F'];
		$sum7 += $arr_data[$siteid]['num3_A'];
		$sum8 += $arr_data[$siteid]['num3_T'];
		$sum9 += $arr_data[$siteid]['num3_F'];
		$sum10 += $arr_data[$siteid]['num4_A'];
		$sum11 += $arr_data[$siteid]['num4_T'];
		$sum12 += $arr_data[$siteid]['num4_F'];
		$sum13 += $arr_data[$siteid]['num5_A'];
		$sum14 += $arr_data[$siteid]['num5_T'];
		$sum15 += $arr_data[$siteid]['num5_F'];
		$sum16 += $arr_data[$siteid]['num6_A'];
		$sum17 += $arr_data[$siteid]['num6_T'];
		$sum18 += $arr_data[$siteid]['num6_F'];

		
	  
	  
		}//end while($rs = mysql_fetch_assoc($result)){
			
			
		unset($arr_data);
	  ?>
        <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum2)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum3)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum4)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum5)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum6)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum7)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum8)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum9)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum10)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum11)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum12)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum13)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum14)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum15)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum16)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum17)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum18)?>
        </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
