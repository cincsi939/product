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
			$graph_path="http://$servergraph/graphservice/graphservice.php";
			$w1 = 420;
			$h1 = 210 ;
			
				function GetDatePN($yymm,$xtype){
						if($xtype == "prev"){
								$xsdate = "-1 month";
						}else{
								$xsdate = "+1 month";
						}
					 $xbasedate = strtotime("$yymm");
					 $xdate = strtotime("$xsdate",$xbasedate);
					 $xsdate = date("Y-m",$xdate);// วันถัดไป
					 return $xsdate;
				}
				
				function GetDatePrev($get_date){	
					$xbasedate = strtotime("$get_date");
					 $xdate = strtotime("-1 days",$xbasedate);
					 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
					 return $xsdate;
						
				}//end function GetDatePrev($get_date){	
				 
				 
			if($_GET['xyymm'] != ""){
				$yymm = GetDatePN($xyymm,$xtype);
			}
				 
			
			$sql = "SELECT * FROM view_report_keykp7 WHERE date_report LIKE '$yymm%' ORDER BY date_report ASC ";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
					$key_target = ($rs[numdoc_new]-$rs[keydoc_new])/$rs[day_work];
					$arrdd = explode("-",$rs[date_report]);
					
					if($daylist > "") $daylist .= ";";
					$daylist .= $arrdd[2]."-".$arrdd[1]."-".substr(($arrdd[0]+543),-2);
					
					if($d1 > "") $d1 .= ";";
					$d1 .= $rs[dockey_perday];
					
					if($d2 > "") $d2 .= ";";
					$d2 .= $key_target;
					$arrdata[$rs[date_report]]['key_doc'] = $rs[dockey_perday];
					$arrdata[$rs[date_report]]['key_target'] = $key_target;
					$arrdata[$rs[date_report]]['key_diff'] = $rs[dockey_perday]-$key_target;
					
			}//end while($rs = mysql_fetch_assoc($result)){
				
	################  
	$sql_detail = "SELECT * FROM  view_report_keykp7_detail  WHERE date_report LIKE '".$yymm."%'  ORDER BY date_report ASC ";
	$result_detail = mysql_db_query($dbnameuse,$sql_detail) or die(mysql_error()."$sql_detail<br>LINE__".__LINE__);
	while($rsd = mysql_fetch_assoc($result_detail)){
			$arrdata1[$rsd[date_report]][$rsd[groupreport_id]] = $rsd[dockey_new];// ยอดการคีย์เอกสาร
	}//end while($rsd = mysql_fetch_assoc($result_detail)){

$arrd = explode("-",$yymm);
$subtitle = "";
//$xtitle = "กราฟสถิติการการบันทึกข้อมูลประจำเดือน".$monthname[intval($arrd[1])]." พ.ศ.".$arrd[0]+543;
$graphurl = $graph_path . "?category=$daylist&data1=$d1&data2=$d2&outputstyle=&numseries=2&seriesname=จำนวนผลผลิต(ชุด);เป้าหมายผลผลิต(ชุด)&graphtype=area&title=$title&xname=วัน เดือน ปี&yname=จำนวนผลผลิต(ชุด)&subtitle=&graphstyle=srd_for_dataentry_new";
			
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script src="../../common/gs_sortable.js"></script>
<link href="../../common/gs_sortable.css">
<style>
.txtcolor{
	color: #FF0000;

}
.txtcolor_green{
	color:#060;
}

.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</HEAD>
<BODY >
<?

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><img src="../../images_sys/banner_cmss2_report.jpg" width="100%" height="130"></td>
  </tr>
    <tr>
    <td colspan="2" align="center" bgcolor="#A5B2CE"><strong><? if($yymm > "2011-08"){?><a href="?xyymm=<?=$yymm?>&xtype=prev"><img src="../../images_sys/arrow_left_blue.png" width="16" height="16" title="คลิ๊กเพื่อดูข้อมูลสถิติเดือนก่อนหน้านี้" border="0"></a><? }?>&nbsp;รายงานสถิติการบันทึกข้อมูลประจำเดือน 
          <?=$monthname[intval($arrd[1])]?> พ.ศ. <? echo $arrd[0]+543;?>&nbsp;<? 	if($yymm < date("Y-m")){ ?><a href="?xyymm=<?=$yymm?>&xtype=net"><img src="../../images_sys/arrow_right_blue.png" width="16" height="16" title="คลิ๊กเพื่อดูข้อมูลสถิติเดือนถัดไป" border="0"></a><? } ?></strong></td>
  </tr>
  <tr>
    <td width="70%" align="center" valign="top" bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3"  id="my_table">
    <thead>
      <tr>
        <th width="4%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></th>
        <th width="12%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>วันที่</strong></th>
        <th width="9%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>เป้าหมาย<br>
          ผลผลิต(ชุด)</strong></th>
        <th width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>จำนวนผลผลิต<br>
          ทั้งหมด(ชุด)</strong></th>
        <th width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลต่าง <br>
          (ชุด)</strong></th>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตกลุ่ม E</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตกลุ่ม L</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตกลุ่ม N</strong></td>
        </tr>
      <tr>
        <th width="9%" align="center" bgcolor="#A5B2CE"><strong>ชุด</strong></th>
        <th width="9%" align="center" bgcolor="#A5B2CE"><strong>ร้อยละ</strong></th>
        <th width="9%" align="center" bgcolor="#A5B2CE"><strong>ชุด</strong></th>
        <th width="9%" align="center" bgcolor="#A5B2CE"><strong>ร้อยละ</strong></th>
        <th width="9%" align="center" bgcolor="#A5B2CE"><strong>ชุด</strong></th>
        <th width="10%" align="center" bgcolor="#A5B2CE"><strong>ร้อยละ</strong></th>
      </tr>
      </thead>
      <tbody>
        <?
		if(count($arrdata) > 0){
			$i=0;
			foreach($arrdata as $key => $val){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}		
				### ยอดคีย์กลุ่ม E
				$prev_date = GetDatePrev($key); // วันก่อนหน้า
				$numEPrev = $arrdata1[$prev_date]['1']; // ค่าก่อนหน้านี้
				$numE = $arrdata1[$key]['1'];
				### ยอดคีย์กลุ่ม L
				$numLPrev = $arrdata1[$prev_date]['2']; // ค่าก่อนหน้านี้
				$numL = $arrdata1[$key]['2'];
				### ยอดคีย์กลุ่ม N
				$numNPrev = $arrdata1[$prev_date]['3']+$arrdata1[$prev_date]['4']+$arrdata1[$prev_date]['5']; // ค่าก่อนหน้านี้
				$numN =  $arrdata1[$key]['3']+$arrdata1[$key]['4']+$arrdata1[$key]['5'];
				if($numEPrev > $numE){
					$color_E = 	" class=\"txtcolor\" ";	
				}else if($numE > $numEPrev){
					$color_E = 	" class=\"txtcolor_green\" ";		
				}else{
					$color_E = "";	
				}
				
				if($numLPrev > $numL){
					$color_L = 	" class=\"txtcolor\" ";	
				}else if($numL > $numLPrev){
					$color_L = 	" class=\"txtcolor_green\" ";		
				}else{
					$color_L = "";	
				}
				
				if($numNPrev > $numN){
					$color_N = 	" class=\"txtcolor\" ";	
				}else if($numN > $numNPrev){
					$color_N = 	" class=\"txtcolor_green\" ";		
				}else{
					$color_N = "";	
				}


				
				
				if($val['key_diff'] < 0){
					$tdread = " class=\"txtcolor\" ";	
					
				}else{
					$tdread = "";			
				}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=DBThaiLongDateFull($key);?></td>
        <td align="center"><?=number_format($val['key_target'])?></td>
        <td align="center"><?=number_format($val['key_doc'])?></td>
        <td align="center" <?=$tdread?>><?=number_format($val['key_diff'])?></td>
        <td align="center" <?=$color_E?>><?=number_format($numE)?></td>
        <td align="center"><?=number_format($numE*100/$val['key_doc'],2)?></td>
        <td align="center" <?=$color_L?>><?=number_format($numL)?></td>
        <td align="center"><?=number_format($numL*100/$val['key_doc'],2)?></td>
        <td align="center" <?=$color_N?>><?=number_format($numN)?></td>
        <td align="center"><?=number_format($numN*100/$val['key_doc'],2)?></td>
        </tr>

        <?
				$sum1 += $val['key_target'];
				$sum2 += $val['key_doc'];
				$sum3 += $val['key_diff'];
				$sumE += $numE;
				$sumL += $numL;
				$sumN += $numN;
				
			}//end foreach($arrdata as $key => $val){
		}// end if(count($arrdata) > 0){
			
			if($sum3 < 0){
				$tdread1 = " class=\"txtcolor\" ";		
			}else{
				$tdread1 = "";	
			}
		?>
        </tbody>
        <tfoot>
        <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC" <?=$tdread1?>><strong><?=number_format($sum3)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumE)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumE*100/$sum2,2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumL)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumL*100/$sum2,2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumN)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumN*100/$sum2,2)?></strong></td>
      </tr>
      </tfoot>
    </table></td>
    <td width="30%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right" valign="top" class="fillcolor_headgraph"><a href="#" onClick="window.open('<?=$graphurl?>')"><img src="../../images_sys/maximize.gif" width="18" height="18"  border="0" title="แสดงกราฟขนาดใหญ่"></a></td>
      </tr>
      <tr>
        <td align="center" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="flashx1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>">
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
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','g','g','g','g','g', 'g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
