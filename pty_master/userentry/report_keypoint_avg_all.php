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
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;

			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$host_face = "202.129.35.101";
			$user_face = "sapphire";
			$pass_face = "sprd!@#$%";
			$dbface = "faceaccess";
			
			$host = HOST;
			$user = "cmss";
			$pass = "2010cmss";
		
			
			if($period_time == ""){
					$period_time = "am";
			}
			
			if($period_time == "am"){
					$xbgx1 = " bgcolor='#666666'";
					$xbgx2 = "";
					$bp =  240;
			}else{
					$xbgx2 = " bgcolor='#666666'";
					$xbgx1 = "";	
					$bp = 120;
			}
			
			if($xtype == ""){
				$xtype = "N";
			}//end 	if($xtype == ""){
			
			if($xtype == "N"){
					$pointb11 = $bp;	
					$bgx1 = " bgcolor='#CCCCCC'";
					$bgx2 = "";
			}else{
					$pointb11 = 0;
					$bgx2 = " bgcolor='#CCCCCC'";
					$bgx1 = "";
			}
			
			$date_config = "2010-10-01";
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			
			
			
			###########  function หาจำนวนวันขาดลามาสาย face
function GetNumStaffWork($period_time){
	global $dbface,$date_config,$curent_date,$host_face,$user_face,$pass_face;
			$startday =$date_config;
			$endday = $curent_date;

		$in_id = GetIdcard();
		if($in_id != ""){
		echo 
		ConHost($host_face,$user_face,$pass_face);
		$sql = "SELECT firstname,surname,pin,start_work,officer_id,site_id,office,period_group_id FROM faceacc_officer WHERE pin IN($in_id)";
		$result = mysql_db_query($dbface,$sql);
		while($row = mysql_fetch_assoc($result)){
		
		
		
		if($period_time == "am"){ // fulltime
			$sql_row0 = "SELECT
				SUM(time_late) AS  latetime,
				COUNT(imgId) AS numtime
				FROM faceacc_images_tmp
				WHERE time_line='09:00:00' AND time_work_in>'09:00:59'
				AND(imgDate BETWEEN '$startday' AND '$endday')
				AND officer_id='".$row[officer_id]."'
				AND approve_time IS NULL
				AND time_late>59
				GROUP BY officer_id
				ORDER BY imgId ASC";
			$result_row0 = mysql_db_query($dbface,$sql_row0);
			$row0 = mysql_fetch_assoc($result_row0);

				
			$sql_row1= "SELECT
				SUM(time_late) AS  latetime,
				COUNT(imgId) AS numtime
				FROM faceacc_images_tmp
				WHERE ( time_line>='12:30:00' AND time_line<='17:00:00' ) 
				AND ( time_work_in>time_line ) 
				AND time_line!='16:30:00'
				AND(imgDate BETWEEN '$startday' AND '$endday')
				AND officer_id='".$row[officer_id]."'
				AND approve_time IS NULL
				AND time_late>59
				GROUP BY officer_id
				ORDER BY imgId ASC";
			$result_row1 = mysql_db_query($dbface,$sql_row1);
			$row1 = mysql_fetch_assoc($result_row1);
			
				$time_total = $row0[latetime]+$row1[latetime];
				$time_num_total = $row0[numtime]+$row1[numtime];
		}else{ // parttime
			$sql_rowx0 = "SELECT
				SUM(time_late) AS  latetime,
				COUNT(imgId) AS numtime
				FROM faceacc_images_tmp
				WHERE  time_line='18:00:00' AND time_work_in>'18:00:59'
				AND(imgDate BETWEEN '$startday' AND '$endday')
				AND officer_id='".$row[officer_id]."'
				AND approve_time IS NULL
				AND time_late>59
				GROUP BY officer_id
				ORDER BY imgId ASC";
			$result_rowx0 =  mysql_db_query($dbface,$sql_rowx0);
			$rowx0 = mysql_fetch_assoc($result_rowx0);
			$time_total = $rowx0[latetime];
			$time_num_total = $rowx0[numtime];
		}//end if($period_time == "am"){
			$arr[$row[pin]]['latetime'] = chkTime($time_total);
			$arr[$row[pin]]['latenum'] = $time_num_total;
			
			$time_total = "";
			$time_num_total = "";
			
			
			
			##หาจำนวนวันทำงาน
			
			$sql_numday = "SELECT COUNT(*) as numd FROM faceacc_holiday_group 
			WHERE period_group_id='".$row[period_group_id]."' AND holiday_date>='$startday' AND holiday_date<='$endday' ";
			
			$result_numday = mysql_db_query($dbface,$sql_numday);
			$rsd = mysql_fetch_assoc($result_numday);
			$holiday_total = $rsd[numd];
			$li = explode("-",$startday);
			$wo = explode("-",$endday);
			$timestart = mktime("00","00","00",$li[1],$li[2],$li[0]);
			$timeend = mktime("00","00","00",$wo[1],$wo[2],$wo[0]);
			$line = $timeend-$timestart;
			$timeline = ($line)/(60*60*24);
			$timelineTotal = $timeline+1;
			$workDay = $timelineTotal-$holiday_total;
			$arr[$row[pin]]['numday'] = $workDay; // จำนวนวันทกงานทั้งหมด
			
			### จำนวนการขาดลาทั้งหมด 
			$sql_absent = "SELECT COUNT(*) as num_absent FROM faceacc_approve WHERE access_type_id='1' AND officer_id='".$row[officer_id]."' AND (approve_date BETWEEN '$startday' AND '$endday')";
			$result_absent = mysql_db_query($dbface,$sql_absent);
			$rsab = mysql_fetch_assoc($result_absent);
			$arr[$row[pin]]['numabsent'] = $rsab[num_absent]; // จำนวนการขาดลาทั้งหมด	
			}//end while($row = mysql_fetch_assoc($result)){
		}//end if($in_id != ""){
	return $arr;
}//end function GetNumStaffWork(){



$arr_work = GetNumStaffWork($period_time); // เก็บค่าวันการสายขาดการทำงานของพนักงาน

ConHost($host,$user,$pass); // connect cmss server
			
			
			
			
			
			if($yy == ""){
					$yy = date("Y")+543;
			}
			if($mm == ""){
					$sql_month = "SELECT month(datekeyin)  as month1  FROM `stat_user_keyin` group by datekeyin order by datekeyin desc limit 0,1";
					$result_month = mysql_db_query($dbnameuse,$sql_month);
					$rs_month = mysql_fetch_assoc($result_month);
					$mm = sprintf("%02d",$rs_month[month1]);
			}

//echo "$yy :: $mm";

			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}


function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){


function ShowSubtract($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){



function GetBasePoint(){
	global $dbnameuse;
	$sql= "SELECT * FROM  keystaff_group ";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[groupkey_id]] = $rs[base_point];
	}
	return $arr;
}// end function GetBasePoint(){
	
	function xGetBasePoint(){
	global $dbnameuse;
	$sql= "SELECT * FROM  keystaff_group ";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[groupkey_id]] = $rs[groupname];
	}
	return $arr;
}// end function GetBasePoint(){

	
######  function get Avgpoint
function GetPointAvg(){
	global $dbnameuse,$date_config,$curent_date,$pointb11,$period_time;
		//$sql = "SELECT avg(numkpoint) as pointavg,count(staffid) as numday,sum(numkpoint) as pointall,staffid  FROM `stat_user_keyin` inner join keystaff_math on stat_user_keyin.staffid=keystaff_math.staffid1  WHERE stat_user_keyin.datekeyin >= '$date_config'  and stat_user_keyin.datekeyin <> '$curent_date' and     group by staffid having pointavg >= $pointb11"; #Inner Join keystaff_math ON stat_user_keyin.staffid = keystaff_math.staffid1
		$sql = "SELECT avg(numkpoint) as pointavg,count( keystaff.staffid) as numday,sum(numkpoint) as pointall, keystaff.staffid
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE    (stat_user_keyin.datekeyin BETWEEN '$date_config'  and  '$curent_date') and 
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  '$period_time'
group by keystaff.staffid having pointavg >= 240 " ;
// having pointavg >= $pointb11
		
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]]['pointall'] = $rs[pointall];
			$arr[$rs[staffid]]['numday'] = $rs[numday];
			$arr[$rs[staffid]]['pointavg'] = $rs[pointavg];
				
		}
		return $arr;
		
}//end function GetPointAvg(){

function GetPointAvgAll(){
	
	$arr1 =GetPointAvg();
	foreach($arr1 as $key => $val1){
			$sumall += $val1['pointavg'];
	}
	return $sumall;
}// end function GetPointAvgAll(){
	
	
if($action == "process"){
	if(count($sel_name) > 0){
		$sql_del = "DELETE FROM keystaff_math";
		mysql_db_query($dbnameuse,$sql_del);
		foreach($sel_name as $k => $v){
			$sql = "REPLACE INTO keystaff_math SET staffid1='$v'";
			//echo $sql."<br>";
			mysql_db_query($dbnameuse,$sql);		
		}//end foreach($sel_name as $k => $v){
			
	echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); location.href='?action=&xtype=$xtype&period_time=$period_time';</script>";
	exit;
	}else{
			echo "<script>alert('ไม่ได้ทำการเลือกรายการที่จะทำการบันทึก'); location.href='?action=&xtype=$xtype&period_time=$period_time';</script>";
	exit;
	}//end if(count($sel_name) > 0){
		
}//end if($action == "process"){
	

function GetSelectM(){
	global $dbnameuse;
		$sqlc = "SELECT * FROM keystaff_math";
		$resultc = mysql_db_query($dbnameuse,$sqlc);
		while($rsc = mysql_fetch_assoc($resultc)){
				$arr[$rsc[staffid1]] = $rsc[staffid1];
		}//end while($rsc = mysql_fetch_assoc($resultc)){<br>
return $arr;
}//end function GetSelectM(){
	
	
function GetIdcard(){
	global $dbnameuse;
	$sql = "SELECT
keystaff.card_id,
keystaff.staffid
FROM
keystaff_math
Inner Join keystaff ON keystaff_math.staffid1 = keystaff.staffid";
$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'$rs[card_id]'";
	}// end while($rs = mysql_fetch_assoc($result)){
	return $in_id;	
}//end function GetIdcard(){
	
	
	function chkTime($time){
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
	}
	
	

	
	
###########  end function หาการขาดลามาสาย ในเครื่อง face
$pointb1 = GetPointAvgAll(); // ค่าคะแนน
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
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td bgcolor="#A5B2CE" align="left"><strong>ค่าคะแนนเฉลี่ยของพนักงานคีย์ข้อมูล ตั้งแต่ <?=thaidate($date_config)?>  ถึงปัจจุบัน <a href="?action=addstaff&xtype=<?=$xtype?>&period_time=<?=$period_time?>">เลือกพนักงานที่จะออกรายงาน</a>
    </strong></td>
  </tr>
  <tr>
    <td bgcolor="#A5B2CE" align="left"><strong>ค่าคะแนนประสิทธิภาพคือ
        <?=number_format($pointb1,4)?>
คะแนน</strong></td>
  </tr>
  <tr>
    <td bgcolor="#A5B2CE" align="left"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
        <td>&nbsp;</td>
        <td align="center"  <?=$xbgx1?>><a href="?action=<?=$action?>&xtype=<?=$xtype?>&period_time=am">Fulltime</a></td>
        <td align="center" <?=$xbgx2?>><a href="?action=<?=$action?>&xtype=<?=$xtype?>&period_time=pm">Parttime</a></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="14%" align="center" <?=$bgx1?>><a href="?action=<?=$action?>&xtype=N&period_time=<?=$period_time?>">คิดจากค่าคะแนน <?=$bp?></a></td>
        <td width="16%" align="center" <?=$bgx2?>><a href="?action=<?=$action?>&xtype=Y&period_time=<?=$period_time?>">คิดจากค่าคะแนนทั้งหมด</a></td>
        <td width="68%">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3"  id="table0" class="sortable">
      <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
        <td width="3%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ชื่อ นามสกุล</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนรวมทั้งหมด</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>จำนวนวันทำงาน</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่าคะแนนเฉลี่ย</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ส่วนต่าง</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>จำนวนวันที่ขาดงาน(วัน)</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>จำนวนวันที่สาย(วัน)</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>จำนวนนาทีที่สาย(นาที)</strong></td>
        <!--<td width="15%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่าประสิทธิภาพ (%)</strong></td>-->
      </tr>
      <?


	  $arrb = GetBasePoint();
	  $arrp = GetPointAvg();
      	$sql = "SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.period_time,
keystaff.keyin_group,
keystaff.part_keydata,
keystaff.card_id as idcard
FROM
keystaff_math
Inner Join keystaff ON keystaff_math.staffid1 = keystaff.staffid
where keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  '$period_time'
order by keystaff.staffname asc ";
//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error());
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
			
			$point_all = $arrp[$rs[staffid]]['pointall'];// จำนวนคะแนนทั้งหมด
			$numdate = $arrp[$rs[staffid]]['numday']; // จำนวนวันที่ทำงาน
			$point_avg = $arrp[$rs[staffid]]['pointavg'];
			$base_point = $arrb[$rs[keyin_group]];
			if($point_avg >= $pointb11){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$point_diff = $point_avg-$base_point;
			$percen1 = ($point_avg*100)/$pointb1;
			$numlate_time = intval($arr_work[$rs[idcard]]['latetime']); // จำนวนเวลามาสายทั้งหมด(นาที)
			$numlate_day =  $arr_work[$rs[idcard]]['latenum']; //จำนวนวันที่สาย
			$numabsent_day =  $arr_work[$rs[idcard]]['numabsent']; //จำนวนวันที่ขาดงาน
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><?=number_format($point_all,2)?></td>
        <td align="center"><?=number_format($numdate);?></td>
        <td align="center"><?=number_format($point_avg,2);?></td>
        <td align="center"><?=number_format($point_diff,2);?></td>
        <td align="center"><?=number_format($numabsent_day)?></td>
        <td align="center"><?=number_format($numlate_day)?></td>
        <td align="center"><?=number_format($numlate_time)?></td>
        <!--<td align="center" bgcolor="<?//=$bg?>"><?//=number_format($percen1,4)?></td>-->
      </tr>
      <?
	  $sumpercen += $percen1;
			}//end if($point_avg >= $pointb11){
	}//end 
	  ?>
      
    </table></td>
  </tr>
<!--  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="85%" align="right" bgcolor="#CCCCCC"><strong>รวม</strong>&nbsp;</td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><?//=number_format($sumpercen,2);?></td>
      </tr>
    </table></td>
  </tr>-->
</table>
<?
}//end 
if($action == "addstaff"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
    <input type="hidden" name="action" value="process">
    <input type="hidden" name="period_time" value="<?=$period_time?>">
    <input type="hidden" name="xtype" value="<?=$xtype?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="tbldata">
            <tr>
              <td colspan="5" align="left" bgcolor="#A5B2CE"><strong>เลือกพนักงานที่เพื่อที่จะแสดงหน้ารายงานค่าคะแนนเฉลียของการคีย์ข้อมูล</strong></td>
              </tr>
            <tr>
              <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
              <td width="35%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="18%" align="center" bgcolor="#A5B2CE"><strong>ค่าคะแนนเฉลี่ย</strong></td>
              <td width="19%" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
              <td width="21%" align="center" bgcolor="#A5B2CE"><strong>
              <a href="#" onClick="checkAll()" style="font-weight:bold">เลือกทั้งหมด</a>/<a href="#" onClick="UncheckAll()"  style="font-weight:bold">ไม่เลือกทั้งหมด</a><br><br>
                <input type="submit" name="button" id="button" value="บันทึก">
              </strong></td>
            </tr>
            <?
            	$sql = "SELECT avg(numkpoint) as pointavg,COUNT(keystaff.staffid), keystaff.* FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE  (stat_user_keyin.datekeyin BETWEEN '$date_config'  and  '$curent_date') and 
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  '$period_time' 
group by keystaff.staffid  ORDER BY  pointavg DESC,keystaff.staffname,keystaff.staffsurname ASC";
//echo $sql;
				$result = mysql_db_query($dbnameuse,$sql);
				$i=0;
				$arrg = xGetBasePoint();
				$arrs = GetSelectM();
			//	print_r($arrs);
				while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					if($rs[pointavg]<240){$bg="#FFCC66";$dis="disabled";}
					if($arrs[$rs[staffid]] != ""){
							$sel = " checked ";
					}else{
							$sel = "";	
					}
					
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><? echo "$rs[staffname]  $rs[staffsurname] [$rs[staffid]]"; ?></td>
              <td align="center"><?=number_format($rs[pointavg],2)?></td>
              <td align="center"><?=$arrg[$rs[keyin_group]]?></td>
              <td align="center"><input type="checkbox" name="sel_name[<?=$rs[staffid]?>]" id="listname" value="<?=$rs[staffid]?>" <?=$sel?> <?=$dis?>></td>
            </tr>
            <?
				}//end while($rs = mysql_fetch_assoc($result)){
			?>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<?
}//end if($action == "addstaff"){
?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>