<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
session_start();
set_time_limit(0);
$ApplicationName	= "AdminReport";
$module_code 		= "statuser"; 
$process_id			= "display";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110701.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-01 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110701.00
	## Modified Detail :		รายงานข้อมูลการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-01 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			

			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
			$time_start = getmicrotime();
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$report_day = 30;
			$arrsite = GetSiteKeyData();
			
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$idcard_ex = GetCard_idExcerent();// เลขบัตรประจำตัวประชาชนของกลุ่ม excerent
			
			function GetShowGroupname(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group.groupname, keystaff_group.groupkey_id FROM `keystaff_group`  ";
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql :: ".__LINE__);	
				while($rs = mysql_fetch_assoc($result)){
						$arr[$rs[groupkey_id]] = $rs[groupname];
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end 	function GetShowGroupname(){
				
			function GetShowGroupnameN(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group_report.groupreport_name, keystaff_group_report.r_point FROM `keystaff_group_report` where  r_point > 0";	
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[r_point]] = $rs[groupreport_name];	
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end function GetShowGroupnameN(){

			
			if($status_permit == "NO"){
				$subtitle = " (เริ่มงานวันที่ $datein  ออกงานวันที่ $dateout)";	
			}else{
				$subtitle = " (เริ่มงานวันที่ $datein)";	
			}
			
			$xhead = "รายงานสถิติค่าคะแนนการบันทึกข้อมูลของ ".$fullname." ย้อนหลัง $report_day วัน $subtitle";
			$graph_path="http://$servergraph/graphservice/graphservice.php";
			$w1 = 420;
			$h1 = 210 ;	
			
	$yy1 = date("Y");
	  $yy2 = $yy1-1;
	  	$sql = "SELECT
t1.datekeyin,
t1.numkpoint,
if(t1.rpoint > 0,t1.rpoint,if(t2.point_ratio > 0 and t2.point_ratio IS NOT NULL,t2.point_ratio,1)) as rpoint,
if(t2.spoint > 0,t2.spoint,0) as spoint
FROM
stat_user_keyin as t1
Left Join stat_subtract_keyin as t2 ON t1.staffid = t2.staffid AND t1.datekeyin = t2.datekey
WHERE t1.staffid='$staffid' AND (t1.datekeyin LIKE '$yy1%' OR t1.datekeyin LIKE '$yy2%')  ORDER BY  t1.datekeyin DESC LIMIT $report_day";
      	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[datekeyin]]['numkpoint'] = $rs[numkpoint];
			$arr[$rs[datekeyin]]['rpoint'] = $rs[numkpoint];
			$arr[$rs[datekeyin]]['spoint'] = $rs[spoint];
			
					if($daylist > "") $daylist .= ";";
					$daylist .= DBThaiLongDateFull($rs[datekeyin]);
					
					if($d1 > "") $d1 .= ";";
					$d1 .= $rs[numkpoint];
				//	if($d2 > "") $d2 .= ";";
					//$d2 .= ($rs[rpoint]*$rs[spoint]);
			
		}//end 
$graphurl = $graph_path . "?category=$daylist&data1=$d1&outputstyle=&numseries=1&seriesname=บันทึกข้อมูล(คะแนน)&graphtype=area&title=$title&xname=วัน เดือน ปี&yname=คะแนน&subtitle=&graphstyle=srd_for_dataentry_new";

			
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>

</HEAD>
<BODY >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../../images_sys/banner_cmss2_report.jpg" width="100%" height="130"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="69%" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#A5B2CE"><strong><?=$xhead?></strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="26%" align="center" bgcolor="#A5B2CE"><strong>วันที่บันทึกข้อมูล</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>คะแนนที่บันทึกได้</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>จุดผิด(จุด)</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>อัตราส่วน</strong></td>
        <td width="19%" align="center" bgcolor="#A5B2CE"><strong>คะแนนสัมประสิทธ์</strong></td>
        </tr>
      <?
	  	if(count($arr) > 0){
			foreach($arr as $key => $val){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left" nowrap><?=DBThaiLongDateFull($key)?></td>
        <td align="center" nowrap><?=number_format($val['numkpoint'],2)?></td>
        <td align="center"><?=$val['spoint']?></td>
        <td align="center"><?=$val['rpoint']?></td>
        <td align="center"><?=number_format($val['spoint']*$val['rpoint'],2)?></td>
        </tr>
      <?
			}//end foreach($arr as $key => $val){
		}// end if(count($arr) > 0){
	  ?>
    </table></td>
        <td width="31%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" valign="top" class="fillcolor_headgraph"><a href="#" onClick="window.open('<?=$graphurl?>')"><img src="../../images_sys/maximize.gif" width="18" height="18"  border="0" title="แสดงกราฟขนาดใหญ่"></a></td>
          </tr>
          <tr>
            <td valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="flashx1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>">
                                               <param name="wmode" value="transparent"> 
                                              <param name="movie" value="<?=$graphurl?>">
                                              <param name="quality" value="high">
                                              <embed src="<?=$graphurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$w1?>" height="<?=$h1?>"></embed>
                                          </object></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
