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
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
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
	
######  function get Avgpoint
function GetPointAvg(){
	global $dbnameuse;
		$sql = "SELECT avg(numkpoint) as pointavg,count(staffid) as numday,sum(numkpoint) as pointall,staffid  FROM `stat_user_keyin` inner join keystaff_math on stat_user_keyin.staffid=keystaff_math.staffid1  group by staffid";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]]['pointall'] = $rs[pointall];
			$arr[$rs[staffid]]['numday'] = $rs[numday];
			$arr[$rs[staffid]]['pointavg'] = $rs[pointavg];
				
		}
		return $arr;
		
}//end function GetPointAvg(){
	


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="left" bgcolor="#A5B2CE"><strong>ค่าคะแนนเฉลี่ยของพนักงานคีย์ข้อมูล</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="25%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ นามสกุล</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>คะแนนรวมทั้งหมด</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>จำนวนวันทำงาน</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>ค่าคะแนนเฉลี่ย</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>ค่าคะแนนมาตรฐาน</strong></td>
        <td width="15%" align="center" bgcolor="#A5B2CE"><strong>ส่วนต่าง</strong></td>
      </tr>
      <?
	  $arrb = GetBasePoint();
	  $arrp = GetPointAvg();
	  		$arr[$rs[staffid]]['pointall'] = $rs[pointall];
			$arr[$rs[staffid]]['numday'] = $rs[numday];
			$arr[$rs[staffid]]['pointavg'] = $rs[pointavg];
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
order by keystaff.staffname asc";
	$result = mysql_db_query($dbnameuse,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$point_all = $arrp[$rs[staffid]]['pointall'];// จำนวนคะแนนทั้งหมด
			$numdate = $arrp[$rs[staffid]]['numday']; // จำนวนวันที่ทำงาน
			$point_avg = $arrp[$rs[staffid]]['pointavg'];
			$base_point = $arrb[$rs[keyin_group]];
			$point_diff = $point_avg-$base_point;
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname] [$rs[staffid]]";?></td>
        <td align="center"><?=number_format($point_all,2)?></td>
        <td align="center"><?=number_format($numdate);?></td>
        <td align="center"><?=number_format($point_avg,2);?></td>
        <td align="center"><?=number_format($base_point);?></td>
        <td align="center"><?=number_format($point_diff,2);?></td>
      </tr>
      <?
	}//end 
	  ?>
    </table></td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>