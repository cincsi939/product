<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat Khamtum
#DateCreate::2011-01-18
#LastUpdate::2011-01-18
#DatabaseTable::req_problem,req_problem_person
#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;

			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			
			
function xchkTime($time){
			$thistime = $time;
			$hour = floor($thistime/3600);
			$T_minute = $thistime % 3600;
			
			$minute = floor($T_minute / 60);
			$second = $T_minute % 60;
			if($hour>0){
			
			$minute2 = $hour*60;
			}
			if($minute>0){
				$minute = $minute+$minute2;
			$word .= " $minute";
			}
			if($word==""){ $word = ""; }
			
			return $word;
}// end function chkTime($time){
	
			
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
function xMakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . ($d1[0]+543);
}

			$date_config = "2010-10-01";
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;


function GetPointAvgMax($staffid){
	global $dbnameuse,$date_config,$curent_date;
		$sql = "SELECT 
	numkpoint
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE    (stat_user_keyin.datekeyin BETWEEN '$date_config'  and  '$curent_date') and 
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  'am'
and  keystaff.staffid='$staffid'
order by numkpoint desc limit 15
" ;
//echo $sql;
		
		$result = mysql_db_query($dbnameuse,$sql);
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
			$j++;
			$sum1 += $rs[numkpoint];
			
		}
		return $sum1/$j;
		
}//end function GetPointAvg(){
	
	
	function GetPointAvg(){
	global $dbnameuse,$date_config,$curent_date;
		$sql = "SELECT avg(numkpoint) as pointavg,count( keystaff.staffid) as numday,sum(numkpoint) as pointall, keystaff.staffid
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE    (stat_user_keyin.datekeyin BETWEEN '$date_config'  and  '$curent_date') and 
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  'am'
group by keystaff.staffid 
" ;
		
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]]['pointavg'] = $rs[pointavg];
				
		}
		return $arr;
		
}//end function GetPointAvg(){




			
function GetProblemPerson($idcard){
	global $dbnamemaster;
			$sql = "SELECT
		req_problem_person.idcard,
		view_general.siteid,
		view_general.prename_th,
		view_general.name_th,
		view_general.surname_th,
		view_general.position_now,
		req_problem.problem_group,
		req_problem.problem_caption
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		and req_problem_person.idcard='$idcard'
		group by req_problem.problem_group";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[problem_group]]['groupid'] = $rs[problem_group];
			$arr[$rs[problem_group]]['caption'] = $rs[problem_caption];	
		}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end 

function GetProblemQc($idcard){
		global $dbnameuse;
		$sql = "SELECT
	validate_checkdata.idcard,
	validate_checkdata.staffid,
	validate_checkdata.date_check,
	validate_checkdata.result_check,
	validate_checkdata.qc_staffid,
	validate_datagroup.dataname,
	validate_checkdata.checkdata_id,
	validate_datagroup.checkdata_id,
	validate_datagroup.parent_id,
	t1.req_menuid
	FROM
	validate_checkdata
	Left Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
	left join menu_math_req_qc as t1 on validate_datagroup.checkdata_id=t1.qc_menuid
	WHERE
	validate_checkdata.idcard =  '$idcard'
	group by t1.req_menuid
	";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[req_menuid]]['groupid'] = $rs[req_menuid];
			$arr[$rs[req_menuid]]['caption'] = $rs[dataname];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetProblemQc($idcard){


		function GetNumProblem(){
			global $dbnamemaster;
			$sql = "SELECT
view_general.siteid,
count(distinct req_problem_person.idcard) as num1
FROM
req_problem_person
Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
WHERE
req_problem_person.del =  '0' AND
req_problem.problem_type =  '1'
GROUP BY
view_general.siteid";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
				
		}// end 	while($rs = mysql_fetch_assoc($result)){
			return $arr;	
}//end 	function GetNumProblem(){
	
	
function GetProblemCheck(){
	global $dbnamemaster;
	$sql = "SELECT 
 ".DB_MASTER.".view_general.siteid,
sum(if( ".DB_MASTER.".req_problem_person.idcard <> '',1,0)) as numall,
sum(if(tc1.idcard IS NOT NULL,1,0)) as numqc
FROM
req_problem_person
Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
left join ".DB_USERENTRY.".validate_checkdata as tc1 ON req_problem_person.idcard=tc1.idcard
WHERE
req_problem_person.del =  '0' AND
req_problem.problem_type =  '1'
group by 
view_general.siteid
";	
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numall'] = $rs[numall];
		$arr1[$rs[siteid]]['numqc'] = $rs[numqc];
	}
	return $arr1;
}//end function GetProblemCheck(){
	
	
function GetSecname($xsiteid){
	global $dbnamemaster;
	$sql = "SELECT secname_short FROM eduarea WHERE secid='$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
		return $rs[secname_short];
}//end function GetSecname(){
		
			
function GetProblemAll(){
		global $dbnamemaster;
				$sql = "SELECT
		distinct  ".DB_MASTER.".req_problem_person.idcard,
		 ".DB_MASTER.".view_general.siteid,
		tc1.idcard as idcard1,
		 ".DB_MASTER.".view_general.prename_th,
		 ".DB_MASTER.".view_general.name_th,
		 ".DB_MASTER.".view_general.surname_th,
		 ".DB_MASTER.".view_general.position_now
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		left join ".DB_USERENTRY.".validate_checkdata as tc1 ON req_problem_person.idcard=tc1.idcard
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		order by
		 ".DB_MASTER.".view_general.siteid
		asc
		";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			
			if($rs[idcard1] != ""){
					$arr[$rs[siteid]]['numqc'] = $arr[$rs[siteid]]['numqc']+1;
			}// end if($rs[idcard1] != ""){
					$arr[$rs[siteid]]['numall'] = $arr[$rs[siteid]]['numall']+1;
				
		}// end while($rs = mysql_fetch_assoc($result)){
			
		return $arr;
}//end 		function GetProblemAll(){
	
	function GetStaffname($staffid){
		global $dbnameuse;
		$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
			
	}//end function GetStaffname(){

	
function GetKeyLate($xtype){
	global $dbnameuse;
	
	if($xtype == "am"){
		$conv = "(mindate >= '09:30:00' and mindate <= '12:00:00' and maxdate <= '18:00:00') ";	
	}else{
		$conv = "(maxdate <= '17:00:00' and mindate <= '12:00:00' and maxdate <= '18:00:00') ";	
	}// end 	if($xtype == "am"){
	
	$sql = "SELECT
t1.staffid,
date(start_date) AS datekey,
Min(time(start_date)) AS mindate,
Max(time(end_date)) AS maxdate,
t2.prename,
t2.staffname,
t2.staffsurname
FROM
log_time_userkey AS t1
Inner Join keystaff AS t2 ON t1.staffid = t2.staffid AND t2.status_permit = 'YES'
 AND t2.status_extra = 'NOR'
GROUP BY
t1.staffid,
date(t1.start_date)
having 
$conv
order by t1.staffid
";	
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[staffid]] = $arr[$rs[staffid]]+1;	
}

	return $arr;
}
##################################

function GetMaxMinDate(){
	global $dbnameuse;
	$sql = "SELECT max(date(log_time_userkey.start_date)) AS maxdate,min(date(log_time_userkey.start_date)) as mindate FROM log_time_userkey";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['maxdate'] = $rs[maxdate];
	$arr['mindate'] = $rs[mindate];
	return $arr;
}

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language='javascript' src='../../common/popcalendar.js'></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	



</script>
</HEAD>
<BODY >
<?
	if($action == ""){
		
		$arrdate = GetMaxMinDate();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>จำนวนการเริ่มงานหลัง 09:30 และจำนวนที่หยุดคีย์ก่อน 17:30 น. แยกรายคน ตั้งแต่วันที่ <?=xMakeDate($arrdate['mindate']);?> ถึง วันที่ <?=xMakeDate($arrdate['maxdate']);?>|| <a href="CC_report_keyin.php" target="_blank">ประมวลผลเก็บ log การเริ่มและหยุดคีย์งานในแต่ละวัน</a></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="24%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนครั้งที่เริ่มงานหลัง 09:30 น.</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>จำนวนครั้งที่หยุดคีย์งานก่อน 17:30 น.</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>คะแนนเฉลี่ย</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>ค่าเฉลี่ยสูงสุด 15 อันดับ</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>เปอร์เซ็น</strong></td>
      </tr>
      <?
	  $point_avg1 = GetPointAvg();
	  $arr_am = GetKeyLate("am");
	  $arr_pm = GetKeyLate("pm");
      	$sql = "SELECT DISTINCT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
stat_user_keyin.numkpoint
FROM
keystaff
Inner Join stat_user_keyin ON keystaff.staffid = stat_user_keyin.staffid
where stat_user_keyin.datekeyin like '2011-01%' and stat_user_keyin.numkpoint > 0
group by  keystaff.staffid
order by keystaff.staffname
 ";
 		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if(($arr_am[$rs[staffid]] > 5 or $arr_pm[$rs[staffid]] > 5) and $point_avg1[$rs[staffid]]['pointavg'] > 0){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $avgmax = GetPointAvgMax($rs[staffid]);
	  	?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]"?></td>
        <td align="center"><? if($arr_am[$rs[staffid]] > 0){ echo "<a href='?action=view&ptime=am&staffid=$rs[staffid]&fullname=$rs[prename]$rs[staffname]  $rs[staffsurname]' target='_blank'>".number_format($arr_am[$rs[staffid]])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($arr_pm[$rs[staffid]] > 0){ echo "<a href='?action=view&ptime=pm&staffid=$rs[staffid]&fullname=$rs[prename]$rs[staffname]  $rs[staffsurname]' target='_blank'>".number_format($arr_pm[$rs[staffid]])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($point_avg1[$rs[staffid]]['pointavg'])?></td>
        <td align="center"><?=number_format($avgmax);?></td>
        <td align="center">
        <?
			$p1 = $avgmax-$point_avg1[$rs[staffid]]['pointavg']; // ผลต่างของคะแนน

			
        	echo number_format(($p1*100)/$avgmax,2);
			
		?>
        </td>
      </tr>
      <?
			}//end if($arr_am[$rs[staffid]] > 0 or $arr_pm[$rs[staffid]] > 0){
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end 
	if($action == "view"){
		
		if($ptime == "am"){
			$consp = "4";
			$conspn = "2";
			$conv = "(mindate >= '09:30:00' and mindate <= '12:00:00' and maxdate <= '18:00:00') ";	
			$xtitle = "จำนวนครั้งที่เริ่มงานหลัง 09:00 น.";
	}else{
			$conv = "(maxdate <= '17:00:00' and mindate <= '12:00:00' and maxdate <= '18:00:00') ";	
			$xtitle = "จำนวนครั้งที่หยุดคีย์งานก่อน 17:30 น.";
			$consp = "5";
			$conspn = "3";
	}// end 	if($xtype == "am"){

		$point_avg = GetPointAvg();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$consp?>" align="left" bgcolor="#CCCCCC"><strong>
          <?=$xtitle?> 
          ของ <?=$fullname?>  คะแนนเฉลี่ย  <?=number_format($point_avg[$staffid]['pointavg'])?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>วันที่</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>เวลา(ชั่วโมง:นาที:วินาที)</strong></td>
        <? if($ptime == "pm"){?>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนเวลาหลังหยุดคีย์งาน ถึง 17:30 น.(ชั่วโมง:นาที)</strong></td>
        <?
		}//end 
		?>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>ค่าคะแนนคีย์</strong></td>
        </tr>
      <?
	
	
	$sql = "SELECT
t1.staffid,
date(start_date) AS datekey,
Min(time(start_date)) AS mindate,
Max(time(end_date)) AS maxdate,
t2.prename,
t2.staffname,
t2.staffsurname
FROM
log_time_userkey AS t1
Inner Join keystaff AS t2 ON t1.staffid = t2.staffid AND t2.status_permit = 'YES'
 AND t2.status_extra = 'NOR' and t1.staffid='$staffid'
GROUP BY
t1.staffid,
date(t1.start_date)
having 
$conv";
$result = mysql_db_query($dbnameuse,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	 if($ptime == "am"){
			$timex = $rs[mindate]; 
		}else{
			$timex = $rs[maxdate];
		}
		
		$sdate = "$rs[datekey] $timex";
		$edate = "$rs[datekey] 17:30:00";
		
		$sqlt = "SELECT TIMEDIFF('$edate','$sdate') as time1";
		$resultt = mysql_db_query($dbnameuse,$sqlt);
		$rst = mysql_fetch_assoc($resultt);
		
		
			$sql_sec = "SELECT TIME_TO_SEC(TIMEDIFF('$edate','$sdate')) as time2";
			$result_sec = mysql_db_query($dbnameuse,$sql_sec);
			$rs_sec = mysql_fetch_assoc($result_sec);
			
			
			$arrd1 = explode("-",$rs[datekey]);
			$datex1 = ($arrd1[0]+543)."-".$arrd1[1]."-".$arrd1[2];
	  ?>
      
      
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><a href="http://202.129.35.120".APPNAME."application/userentry/report_keyin_user3.php?staffid=<?=$staffid?>&datereq=<?=$datex1?>" target="_blank"><?=xMakeDate($rs[datekey])?></a></td>
        <td align="center"><?=$timex?></td>
        <? if($ptime == "pm"){?>
        <td align="center"><? echo substr($rst[time1],0,-3);?></td>
        <?
		}//end 
		?>
        <td align="center"><?
        	$sql1 = "SELECT
stat_user_keyin.numkpoint
FROM `stat_user_keyin`
where datekeyin='$rs[datekey]' and staffid='$staffid'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	echo number_format($rs1[numkpoint],2);
	
		?></td>
        <?
	  $totlal_time += $rs_sec[time2];

}//end 
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td colspan="<?=$conspn?>" align="center" bgcolor="#CCCCCC"><strong>รวม </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
        <? 
			$rstime = mysql_fetch_assoc(mysql_query("SELECT SEC_TO_TIME($totlal_time) as timea"));
			echo $rstime[timea]."<br>";
		?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </table></td>
  </tr>
</table>
<?
	}//end 
?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>