<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "ReportStatkeyinApprove";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::17/11/2010
#LastUpdate::17/11/2010
#DatabaseTable::log_stat_keyinapprove, log_stat_keyinapprove_detail
#END
#########################################################

	set_time_limit(0);
	include ("../../common/common_competency.inc.php")  ;
	include("epm.inc.php");
	$arr_month = array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน", "07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
	$arrday = array("1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์","7"=>"อาทิตย์");
	
	//echo $graph_path;
	
	function DateThaiFull($d1){
		global $monthname;
		$d1=explode("-",$d1);
		return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " พ.ศ. " . (intval($d1[0]) + 543);	
	}
	
	
	
function DBThaiShort($d){
	global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . substr((intval($d1[0]) + 543),-2);
}


	$time_start = getmicrotime();
	#### กรณี เดือนและ ปีเป็นค่าว่าง
	if($key_mm == ""){
			$key_mm = date("m");
	}
	if($key_yy == ""){
			$key_yy = date("Y")+543;
	}
	###  end กรณี เดือนและปี เป็นค่าว่าง
	
	
	
	function XShowDayOfMonth($get_month){
	$arr_d1 = explode("-",$get_month);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($get_month){

function CalStatKeyApprove($get_yymm){
	global $dbnameuse;
	$sql = "SELECT
datekeyin,
numkey_approve
FROM `log_stat_keyinapprove`
where datekeyin LIKE '$get_yymm%'
group by datekeyin
order by datekeyin asc
";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[datekeyin]] = $rs[numkey_approve];	
	}
return $arr;		
}//end function CalStatKeyApprove(){
	
	
	
	
	
	$get_yymm = ($key_yy-543)."-".$key_mm;
	$arrd = XShowDayOfMonth($get_yymm);
	$arrval = CalStatKeyApprove($get_yymm);
	
	if(count($arrd) > 0){
		foreach($arrd as $kk => $vv){
			foreach($vv as $kk1 => $vv1){
				$arrw[$kk] = $arrw[$kk]+$arrval[$vv1];
			}//end foreach($vv as $kk1 => $vv1){	
		}//end 	foreach($arrd as $kk => $vv){
	}//end	if(count($arrd) > 0){ 
	
	//echo "<pre>";
	//print_r($arr);die;
	
##กราฟ
	if(count($arrval) > 0){
		foreach($arrval as $xk => $xv){
				$dd = DBThaiShort($xk);
				if($daylist > "") $daylist .= ";";
					$daylist .= "$dd";
				if($data1 > "") $data1 .= ";";
					$data1 .= "$xv";
				
		}//end foreach($arrval as $xk => $xv){
	}//end if(count($arrval) > 0){

$txt_title = "กราฟเปรียบเทียบสถิติการคีย์ข้อมูลในแต่ละวันประจำเดือน $arr_month[$key_mm] พ.ศ. $key_yy";
$graphurl = $graph_path . "?category=$daylist&data1=$data1&outputstyle=&numseries=1&seriesname=&graphtype=line&graphstyle=srd_sf_004&title=$txt_title&subtitle=";
//$w1= "700";   $h1="350"; 
$w1= "400";   $h1="200"; 


	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    .fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="5%" align="left">เลือก เดือน</td>
          <td width="8%" align="left">
            <select name="key_mm" id="key_mm">
            <?
            	if(count($arr_month) > 0){
					foreach($arr_month as $keym => $valm){
						if($keym == $key_mm){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
						echo "<option value='$keym' $sel1>$valm</option>";
							
					}
				}//end if(count($arr_month) > 0){
			
			?>
            
            </select></td>
          <td width="8%" align="left">เลือก ปี</td>
          <td width="12%" align="left"><strong>
            <select name="key_yy" id="key_yy">
              <?
			$cyy = date("Y")+543;
			$cyy_min = $cyy-3;
			for($i=$cyy ; $i > $cyy_min ; $i--){
				if($i == $key_yy){ $sel = "selected='selected'";}else{ $sel = "";}				
				echo "<option value='$i' $sel>$i</option>";
					
			}
            
			?>
            </select>
          </strong></td>
          <td width="61%" align="left"><strong>
            <input type="submit" name="button" id="button" value="แสดงหน้ารายงาน" />
          </strong></td>
          <td width="6%" align="left">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
    <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="69%" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>สรุปภาพรวมการคีย์ข้อมูลรายสัปดาห์ ประจำเดือน
                    <?=$arr_month[$key_mm];?>
พ.ศ.
<?=$key_yy?>
                </strong></td>
                </tr>
              <tr>
                <td width="35%" align="center" bgcolor="#CCCCCC"><strong>สัปดาห์</strong></td>
                <td width="35%" align="center" bgcolor="#CCCCCC"><strong>จำนวน</strong></td>
                <td width="30%" align="center" bgcolor="#CCCCCC"><strong>ร้อยละ</strong></td>
              </tr>
              <?
			  if(count($arrw) > 0){
              	$arrsum1 = array_sum($arrw);
				$xi=0;
				foreach($arrw as $keyx1 => $valx1){
					if ($xi++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					if($arrsum1 > 0){ $percen = number_format(($valx1*100)/$arrsum1,2);}else{ $percen = 0.00;}
				
			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="center">สัปดาห์ที่ <?=$keyx1?></td>
                <td align="center"><?=number_format($valx1);?></td>
                <td align="center"><? echo $percen;?></td>
              </tr>
              <?
			  $percenall += $percen;
			  $valall += $valx1;
				}//end foreach(){
			  }//end  if(count($arrw) > 0){
			  ?>
                <tr>
                <td align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
                <td align="center" bgcolor="#CCCCCC"><?=number_format($valall)?></td>
                <td align="center" bgcolor="#CCCCCC"><?=number_format($percenall,2)?></td>
              </tr>

            </table></td>
          </tr>
        </table></td>
        <td width="31%" align="right" valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="fillcolor_headgraph"><img src="../../images_sys/maximize.gif" alt="แสดงกราฟขนาดใหญ่" width="18" height="18" class="fillcolor_loginleft2" style="cursor:hand" onclick="window.open('<?=$graphurl?>')" /></td>
              </tr>
              <tr>
                <td align="right"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>" style="z-index:-9999">
                  <param name="movie" value="<?=$graphurl?>" />
                  <param name="quality" value="high" />
                  <param name="wmode" value="transparent" />
                  <embed src="<?=$graphurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$w1?>" height="<?=$h1?>"></embed>
                </object></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รายงานยอดการคีย์ข้อมูล ประจำเดือน 
                  <?=$arr_month[$key_mm];?> พ.ศ. <?=$key_yy?>
                  </strong></td>
                </tr>
              <tr>
                <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                <td width="45%" align="center" bgcolor="#CCCCCC"><strong>วันที่การคีย์ข้อมูล</strong></td>
                <td width="49%" align="center" bgcolor="#CCCCCC"><strong>จำนวนชุดที่คีย์เสร็จ(ชุด)</strong></td>
                </tr>
              <?
              	if(count($arrd) > 0){
					$i=0;
					foreach($arrd as $k1 => $v1){
						echo "<tr bgcolor='#CCCCCC'><td colspan='3' align='left'><b>สัปดาห์ที่ $k1 </b></td></tr>";
						foreach($v1 as $k2 => $v2){
							if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		
			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=$i?></td>
                <td align="left"><? echo " วัน".$arrday[$k2]." ที่ ".DateThaiFull($v2);?></td>
                <td align="center"><? if($arrval[$v2] > 0){ echo number_format($arrval[$v2]);}else{ echo "-";}?></td>
                </tr>
              <?
			  				$numall += $arrval[$v2] ;
						}// foreach($v1 as $k2 => $v2){
					}// end foreach($arrd as $k1 => $v1){
				}//end if(count($arrd) > 0){
			  ?>
              <tr>
                <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
                <td align="center" bgcolor="#CCCCCC"><?=number_format($numall);?></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?
$time_end = getmicrotime();
echo "<br>เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
 writetime2db($time_start,$time_end);
?>
