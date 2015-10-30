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
			include("epm.inc.php");
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			
			$dbnameuse = "edubkk_userentry";
			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");


	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


	if (!isset($datereq)){
		if(!isset($dd)){
			$dd = date("d");
		}
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy += 543;
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$datereq =  "2551-06-09" ;
		$datereq1 = "2008-06-09" ;
	}


$resultx = mysql_db_query($dbnameuse," SELECT  *  FROM  keystaff  WHERE  staffid = '$staffid'  ");
$rsx = mysql_fetch_assoc($resultx) ;

//$staffid = 9928 ;
$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]"; 


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language='javascript' src='../../common/popcalendar.js'></script>

<script language="javascript">
	function refresh_iframe(subject1,sentsecid,czid){
		top.frames['a1'].location = "statistic_graph_user.php?subject="+subject1+"&secid="+sentsecid+"&czid="+czid ;
	}
</script></HEAD>
<BODY >
<? if($action==""){?>
<table width="850" border="0" cellpadding="0" cellspacing="1">
  
  <tr>
    <td height="24" class="fillcolor_menu"><strong>รายงานการบันทึกข้อมูลของ <?=$name?>
      <br>
    ระบบอัพเดตทุกชั่วโมง ไม่ได้อัพเดตเรียลไทม์ และจะต้องได้รับการ approve ก่อนจึงจะนับข้อมูล </strong></td>
  </tr>

  <tr>
    <td width="52%" height="24" align="center"><table width="850" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
            <tr>
              <td width="6%" height="16" align="center" bgcolor="#A5B2CE" class="index1">No.</td>
              <td width="27%" align="center" bgcolor="#A5B2CE" class="index1">วัน เดือน ปี </td>
              <td width="22%" align="center" bgcolor="#A5B2CE" class="index1">จำนวนรายการที่บันทึก</td>
              <td width="23%" align="center" bgcolor="#A5B2CE" class="index1">ค่าสูงสุดในวันนี้</td>
              <td width="22%" align="center" bgcolor="#A5B2CE" class="index1">ค่าเฉลี่ยในวันนี้</td>
            </tr>
<?
$TNUM = 0 ;$j =1 ;

$sql1 = " SELECT *  FROM  stat_user_keyin   WHERE  staffid = '$staffid'  ORDER BY  datekeyin  DESC  " ;
$result1 = mysql_db_query($dbnameuse,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){


$arrdata[$rs1[datekeyin]] = $rs1[numkpoint] ; 
	if($rs1[val_max] == $rs2[maxnum]){$usrstar="<img src=\"../../images_sys/iopcstar.gif\" width=\"15\" height=\"14\">";}else{$usrstar="";}
	  ?>
            <tr>
              <td height="18" align="center" bgcolor="#FFFFFF"><?=$j?></td>
              <td bgcolor="#FFFFFF">&nbsp;<?=thaidate($rs1[datekeyin])?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$usrstar?><?=number_format($rs1[numkpoint],2)?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$usrstar?><?=number_format($rs1[kval_max],2)?></td>
              <td align="center" bgcolor="#FFFFFF"><?=number_format($rs1[kval_avg],2)?></td>
            </tr>
            <? 
	 	$j++ ;   
		}
	  	rsort($arrnum);
		$maxc = $arrnum[0] ;
		reset($arrnum);
	  	sort($arrnum);
		$minc = $arrnum[0] ;
		reset($arrnum);
	  ?>
            <tr>
              <td width="6%" height="18" align="center" bgcolor="#CCCCCC">&nbsp;</td>
              <td colspan="3" align="right" bgcolor="#CCCCCC" class="link_back">&nbsp;</td>
              <td width="22%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
        </table>		</td>
        </tr>
      <tr>
        <td><?
$graph_path="http://$servergraph/graphservice/graphservice.php";
$w1 = 850;
$h1 = 400 ;

ksort($arrdata);

$d1 = $d2 = $d3 = $daylist =  "";



foreach($arrdata AS $key1 => $values ){
	$d1 .= $arrdata[$key1] . ";";
	
	$sqlget = " SELECT  *  FROM  std_val_ref  WHERE  datekeyin = '$key1%'   ";
	//echo "$sqlget <br>";
	$resultget = mysql_db_query($dbnameuse,$sqlget);
	$rsget = mysql_fetch_assoc($resultget);
	
	$d2 .= $rsget[val_kmax] . ";";
	$d3 .= $rsget[val_kavg] . ";";

	///echo "$rsget[val_avg] <br>";

	$daylist .= $key1 . ";";
}

//die;

$subtitle = "";
$title = "สถิติการบันทึกข้อมูลของ $name";
$graphurl = $graph_path . "?category=$daylist&data1=$d1&data2=$d2&data3=$d3&outputstyle=&numseries=3&seriesname=จำนวนรายการ;ค่าสงสุด;ค่าเฉลี่ย&graphtype=area&title=$title&xname=วัน เดือน ปี&yname=จำนวนรายการ(ครั้ง)&subtitle=&graphstyle=srd_for_dataentry";

?>
          <table width="850" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #666666;">
            <tr>
              <td width="100%" height="19" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" class="fillcolor_headgraph"><img src="../../images_sys/maximize.gif" width="18" height="18" onClick="window.open('<?=$graphurl?>')" style="cursor:hand" alt="แสดงกราฟขนาดใหญ่"></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td valign="middle" class="link_back"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="flashx1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>">
                  <param name="movie" value="<?=$graphurl?>">
                  <param name="quality" value="high">
                  <embed src="<?=$graphurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$w1?>" height="<?=$h1?>"></embed>
                </object></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
</table>
<? } ?>
</BODY></HTML>