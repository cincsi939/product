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
        <td width="19%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ชื่อ นามสกุล</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนรวมทั้งหมด</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>จำนวนวันทำงาน</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่าคะแนนเฉลี่ย</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่าคะแนนมาตรฐาน</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ส่วนต่าง</strong></td>
        <td width="15%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่าประสิทธิภาพ (%)</strong></td>
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
keystaff.part_keydata
FROM
keystaff_math
Inner Join keystaff ON keystaff_math.staffid1 = keystaff.staffid
where keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.period_time =  '$period_time'
order by keystaff.staffname asc ";

	$result = mysql_db_query($dbnameuse,$sql);
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
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><?=number_format($point_all,2)?></td>
        <td align="center"><?=number_format($numdate);?></td>
        <td align="center"><?=number_format($point_avg,2);?></td>
        <td align="center"><?=number_format($base_point);?></td>
        <td align="center"><?=number_format($point_diff,2);?></td>
        <td align="center" bgcolor="<?=$bg?>"><?=number_format($percen1,4)?></td>
      </tr>
      <?
	  $sumpercen += $percen1;
			}//end if($point_avg >= $pointb11){
	}//end 
	  ?>
      
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="85%" align="right" bgcolor="#CCCCCC"><strong>รวม</strong>&nbsp;</td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><?=number_format($sumpercen,2);?></td>
      </tr>
    </table></td>
  </tr>
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