<?
set_time_limit(0);
session_start();
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
	## Modified Detail :		ระบบส่งงาน
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
	$basenum = 20;

function GetToDate($get_date,$numday=15){
	$xbasedate = strtotime("$get_date");
	 $xdate = strtotime("$numday day",$xbasedate);
	 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
	return $xsdate;
}//end function GetToDate($get_date,$numday=15){
	
	
######### ข้อมูลวันทำงาน 2 สัปดาห์หลัง

function GetDateStart($staffid){
	global $dbnameuse;
	$sql = "SELECT
	t1.datekeyin
	FROM
	stat_user_keyperson as t1
	Inner Join validate_checkdata as t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard
	where t1.staffid='$staffid'	group by t1.datekeyin
	order by t1.datekeyin asc  limit 15";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$date_start = $rs[datekeyin];	
	}
	return $date_start;		
}//end function GetDateStart($staffid){

//echo "test ::".GetDateStart("11877");die;
					
function GetDataKey1($staffid,$d_start){
	global $dbnameuse;
		$sql = "SELECT
	t1.datekeyin,
	t1.staffid,
	t1.idcard,
	sum(distinct t1.numpoint) as numpoint,
	sum(t2.num_point) as sub_point
	FROM
	stat_user_keyperson as t1
	Inner Join validate_checkdata as t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard
	where t1.staffid='$staffid' 
	and t1.datekeyin >= '$d_start'
	#and t1.datekeyin between '$d_start' AND '$d_end'
	group by t1.idcard
	order by t1.datekeyin asc
	";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$numday = 0;
	while($rs = mysql_fetch_assoc($result)){
		
		if($numday == "15"){ break;	}	

		if($temp_date != $rs[datekeyin]){
			$numday++;
			$temp_date = $rs[datekeyin];	
		}//end if($temp_date != $rs[datekeyin]){
			//echo "$rs[datekeyin] => $rs[idcard] :: $rs[numpoint] :: $rs[sub_point]<br>";
		$sumpoint += $rs[numpoint];
		$sumsubpoint += $rs[sub_point];
		$date_end = $rs[datekeyin];	
	}//end 	while($rs = mysql_fetch_assoc($result)){
	$arr['keydate'] = $date_end;
	$arr['point'] = $sumpoint-$sumsubpoint;
	return $arr;
}//end function GetDataKey1(){
	
function Getid_subpoint($conv){
	global $dbnamemaster;
	$sql = "SELECT CZ_ID as idcard,begindate,birthday FROM `view_general`  where  begindate not like '%0000-00-00%'  AND begindate NOT LIKE '%--%'  $conv ORDER BY  begindate ASC, birthday ASC LIMIT 1";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[idcard];
}
	
	function GetDataKey2($staffid,$d_start){
	global $dbnameuse,$basenum;

		$sql = "SELECT
	t1.datekeyin,
	t1.staffid,
	t1.idcard,
	sum(distinct t1.numpoint) as numpoint,
	sum(t2.num_point) as sub_point
	FROM
	stat_user_keyperson as t1
	Inner Join validate_checkdata as t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard
	where t1.staffid='$staffid' 
	and t1.datekeyin > '$d_start'
	#and t1.datekeyin between '$d_start' AND '$d_end'
	group by t1.idcard
	order by t1.datekeyin asc
	";	
	//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$i=0;
	$j=0;
	$in_id = "";
	$numday = 0;
	while($rs = mysql_fetch_assoc($result)){
		
		if($numday == "15"){ break;	}	

		if($temp_date != $rs[datekeyin]){
			$numday++;
			$temp_date = $rs[datekeyin];	
		}
		$i++;
		//echo "$rs[datekeyin] => $rs[idcard] :: $rs[numpoint] :: $rs[sub_point]<br>";
		$sum_pointkey += $rs[numpoint];
		$arr_subpoint[$rs[idcard]] = $rs[sub_point];
		if($in_id > "") $in_id .= ",";
		$in_id .= "'$rs[idcard]'";

		if($i == $basenum){
			$arr_inid[$j] = $in_id;
			$in_id = "";
			$j++;
			$i=0;
		}	// end 	if($i == $basenum){
			
	}//end while($rs = mysql_fetch_assoc($result)){
		
		
	
	if(count($arr_inid) > 0){
		foreach($arr_inid as $key => $val){
			if($val != ""){
					$conv = " AND CZ_ID IN($val)";
					$idcard = Getid_subpoint($conv);
					$arrid[$idcard] = $idcard;
			}
			
		}// foreach($arr_inid as $key => $val){
			
		  if(count($arrid) > 0){
				  foreach($arrid as $k => $v){
					  if (array_key_exists($k, $arr_subpoint)) {
						 // echo "$k :: ".$arr_subpoint[$k]."<br>";
						  $sub_point += $arr_subpoint[$k]*$basenum;
					  }//end 	if (array_key_exists($k, $arr_subpoint)) {
				  }// end foreach($arrid as $k => $v){
		  }// fend if(count($arrid) > 0){
			
	}//end if(count($arr_point) > 0){
	//echo "point ::$sum_pointkey :: $sub_point ";
	return $sum_pointkey-$sub_point;
	
}//end function GetDataKey1(){
	
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">

function CheckF2(){
	if(document.form2.kp7file.value != "" ){
		alert("กรุณาระบุไฟล์แนบผลการ QC เอกสาร ก.พ.7");	
			document.form2.kp7file.focus();
	}
	if(document.form2.comment_upload.value == "" ){
		alert("กรุณาระบุหมายเหตุการ upload ไฟล์แนบ");
		document.form2.comment_upload.focus();
		return false;
			
	}	
	return true;
} 


</script>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="center" bgcolor="#A5B2CE"><strong>รายงานเปรียบเทียบผลคะแนนการคีย์หักด้วยคะแนน QC ของพนักงานกลุ่ม N ใน 1 เดือนแรกของการทำงาน</strong></td>
        </tr>
      <tr>
        <td width="5%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="35%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ชื่อพนักงาน กลุ่ม N</strong></td>
        <td width="19%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>วันที่เริ่มทำงาน</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลการเปรียบเทียบข้อมูล 2 สัปดาห์หลังของ 1 เดือนแรกของการทำงาน</strong></td>
        </tr>
      <tr>
        <td width="19%" align="center" bgcolor="#A5B2CE"><strong>2 สัปดาห์หลัง (1:1)</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>2 สัปดาห์หลัง (1:20)</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
min(t2.datekeyin) as mindate,
max(t2.datekeyin) as maxdate
FROM
keystaff as t1
Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid
where t1.keyin_group='3' and t1.status_extra='NOR' and t1.status_permit='YES'
group by t1.staffid
having maxdate LIKE '2011%' and mindate <= '2011-05-03'
order by mindate asc,t1.staffname ,t1.staffsurname asc ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		if($i% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $i++;
		$datestart = GetDateStart($rs[staffid]);

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname] [$rs[staffid]]";?></td>
        <td align="center"><?=DBThaiLongDate($rs[mindate]);?></td>
        <td align="center" valign="top">
		<? 		
			$arr1 = GetDataKey1($rs[staffid],$datestart);
			$date_end = $arr1['keydate'];
			echo number_format($arr1['point'],2);
		?></td>
        <td align="center" valign="top"><?=number_format(GetDataKey2($rs[staffid],$datestart),2);?></td>
      </tr>
      <?
	  	unset($arr1);
	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
