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
	## Modified Detail :		��§ҹ�����š�úѹ�֡�����Ţͧ��ѡ�ҹ���������
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

			
			 $sql = "SELECT * FROM view_report_keykp7 WHERE date_report LIKE '$yymm%' ORDER BY date_report ASC ";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
					$key_target = ($rs[numdoc_new]-$rs[keydoc_new])/$rs[day_work];
					
					if($daylist > "") $daylist .= ";";
					$daylist .= $rs[date_report];
					
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
			$arrdata1[$rsd[date_report]][$rsd[groupreport_id]] = $rsd[dockey_new];// �ʹ��ä����͡���
	}//end while($rsd = mysql_fetch_assoc($result_detail)){

$arrd = explode("-",$yymm);
$subtitle = "";
//$xtitle = "��ҿʶԵԡ�á�úѹ�֡�����Ż�Ш���͹".$monthname[intval($arrd[1])]." �.�.".$arrd[0]+543;
$graphurl = $graph_path . "?category=$daylist&data1=$d1&data2=$d2&outputstyle=&numseries=2&seriesname=�ӹǹ�ż�Ե(�ش);������¼ż�Ե(�ش)&graphtype=area&title=$title&xname=�ѹ ��͹ ��&yname=�ӹǹ�ż�Ե(�ش)&subtitle=&graphstyle=srd_for_dataentry_new";
			
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
    <td colspan="2"><img src="../../images_sys/banner_cmss2_report.jpg" width="100%" height="130"></td>
  </tr>
    <tr>
    <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>��§ҹʶԵԡ�úѹ�֡�����Ż�Ш���͹ 
          <?=$monthname[intval($arrd[1])]?> �.�. <? echo $arrd[0]+543;?></strong></td>
  </tr>
  <tr>
    <td width="70%" align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ѹ���</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�������<br>
          �ż�Ե(�ش)</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ż�Ե<br>
          ������(�ش)</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>�ŵ�ҧ <br>
          (�ش)</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե����� E</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե����� L</strong></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�ż�Ե����� N</strong></td>
        </tr>
      <tr>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�ش</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�ش</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�ش</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
      </tr>
        <?
		if(count($arrdata) > 0){
			$i=0;
			foreach($arrdata as $key => $val){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}		
				### �ʹ�������� E
				$numE = $arrdata1[$key]['1'];
				### �ʹ�������� L
				$numL = $arrdata1[$key]['2'];
				### �ʹ�������� N
				$numN =  $arrdata1[$key]['3']+$arrdata1[$key]['4']+$arrdata1[$key]['5'];
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=DBThaiLongDateFull($key);?></td>
        <td align="center"><?=number_format($val['key_target'])?></td>
        <td align="center"><?=number_format($val['key_doc'])?></td>
        <td align="center"><?=number_format($val['key_diff'])?></td>
        <td align="center"><?=number_format($numE)?></td>
        <td align="center"><?=number_format($numE*100/$val['key_doc'],2)?></td>
        <td align="center"><?=number_format($numL)?></td>
        <td align="center"><?=number_format($numL*100/$val['key_doc'],2)?></td>
        <td align="center"><?=number_format($numN)?></td>
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
		?>
        <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum3)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumE)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumE*100/$sum2,2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumL)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumL*100/$sum2,2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumN)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumN*100/$sum2,2)?></strong></td>
      </tr>
    </table></td>
    <td width="30%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right" valign="top" class="fillcolor_headgraph"><a href="#" onClick="window.open('<?=$graphurl?>')"><img src="../../images_sys/maximize.gif" width="18" height="18"  border="0" title="�ʴ���ҿ��Ҵ�˭�"></a></td>
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
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
?>
