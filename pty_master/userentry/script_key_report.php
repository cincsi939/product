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
			include("../../config/conndb_nonsession.inc.php");
			$dbcall = DB_USERENTRY;
			$minute = 8*60;
			
			$arrdate = array("2010-07-05"=>"วันที่ 5 กรกฎาคม 2553","2010-07-06"=>"วันที่ 6 กรกฎาคม 2553","2010-07-07"=>"วันที่ 7 กรกฎาคม 2553","2010-07-08"=>"วันที่ 8 กรกฎาคม 2553"); // วันที่ 
			
				
		function TimeDiff($time_s,$time_e){
			$sql = "SELECT TIMESTAMPDIFF(MINUTE,'$time_s','$time_e') as timediff1";	
			$result = mysql_query($sql);
			$rs = mysql_fetch_assoc($result);
			return $rs[timediff1];
		}
		
		

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="left" bgcolor="#CFDFFC"><strong>ตัวอย่างช่วงเวลาการคีย์ข้อมูลระหว่างวันที่ 5 ถึง 8 กรกฎาคม 2553</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CFDFFC"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#CFDFFC"><strong>ชุดที่คีย์ข้อมูล</strong></td>
        <td width="9%" align="center" bgcolor="#CFDFFC"><strong>ค่าคะแนน<br>
          เฉลี่ยต่อวัน</strong></td>
        <td width="11%" align="center" bgcolor="#CFDFFC"><strong>ค่าคะแนน<br>
          ต่อนาที</strong></td>
        <td width="14%" align="center" bgcolor="#CFDFFC"><strong>เวลเริมต้นคีย์ข้อมูล</strong></td>
        <td width="12%" align="center" bgcolor="#CFDFFC"><strong>เวลาสิ้นสุดคีย์ข้อมูล</strong></td>
        <td width="13%" align="center" bgcolor="#CFDFFC"><strong>เวลาการคีย์<br>
ข้อมูลต่อชุด(นาที)</strong></td>
        <td width="12%" align="center" bgcolor="#CFDFFC"><strong>เวลาคีย์ชุดข้อมูลใหม่</strong></td>
        <td width="10%" align="center" bgcolor="#CFDFFC"><strong>เวลาการเปลี่ยนชุด</strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM keystaff WHERE staffid IN('10614','10237','10378','10028') ";
		$k=0;
		$result = mysql_db_query($dbcall,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if($rs[staffid] != $xstaffid){
				$k++;
				echo "<tr>
        <td colspan=\"9\" align=\"left\" bgcolor=\"#CFDFFC\"><strong>$k ::$rs[prename]$rs[staffname] $rs[staffsurname] [$rs[staffid]]</strong></td>
        </tr>";	
				$xstaffid= $rs[staffid];
			}//end if($rs[staffid] != $xstaffid){
		
			foreach($arrdate as $key => $val){
				if($key != $xdate){
				echo "<tr>
        <td colspan=\"9\" align=\"left\" bgcolor=\"#CCCCCC\">$val</td>
        </tr>";		
				$xdate = $key;
				}//end if($key != $xdate){
			
			$sql1 = "SELECT * FROM exemple_point WHERE datekeyin='$key' AND staffid='$rs[staffid]'";
			$result1 = mysql_db_query($dbcall,$sql1);
			$i=0;
			while($rs1 = mysql_fetch_assoc($result1)){
				if ($i++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
				
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs1[idcard]?></td>
        <td align="center"><?=$rs1[point_avg]?></td>
        <td align="center"><?=$rs1[point_per]?></td>
        <td align="center"><?=$rs1[date_start]?></td>
        <td align="center"><?=$rs1[date_end]?></td>
        <td align="center"><?=TimeDiff($rs1[date_start],$rs1[date_end]);?></td>
        <td align="center"><?=$rs1[date_change]?></td>
        <td align="center"><?=TimeDiff($rs1[date_end],$rs1[date_change]);?></td>
      </tr>
      <?
			}//end 	while($rs1 = mysql_fetch_assoc($result1)){
			}//end foreach($arrdate as $key => $val){
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
