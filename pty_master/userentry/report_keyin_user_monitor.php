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
			
			
			$dbnameuse = "edubkk_userentry";
			
			$time_start = getmicrotime();
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
				$d1 = intval($x[0]+543);
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


	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$date1 = swapdate($date1);
		$datereq1 = $date1 ;
		$exday = explode("-",$date1);
		$datereq = ($exday[0]+543)."-$exday[1]-$exday[2]";
		
		
	}else{
		
		$dd = date("d");
		$mm = date("m");
		$dd2 = $dd-1;
		$yy=date("Y");
		$yy += 543;
		$dd = sprintf("%02d",intval($dd));
		$dd2 = sprintf("%02d",intval($dd2));
		$mm = sprintf("%02d",intval($mm));
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$datereq2 = "$yy-$mm-$dd2";
		$round = "am" ;
		
	}

	if($round == "am"){
		$checked1 = "checked" ;
		$checked2 = "" ;
	}else{
		$checked1 = "" ;
		$checked2 = "checked" ;
	}

$str_std = " SELECT k_point ,tablename  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
}

$arr_idcard = "3100501014296,
3102101667201,
3160101094993,
3180500618325,
3420600033555,
3470400618258,
3530100128033,
3530700505687,
3530700508023,
3530700511741,
3540400529785,
3560600334201,
3600400483474,
3600700301053,
3601000362981,
3601100328610,
3609800107231,
3620401257176,
3630500002214,
3630500007399,
3640600244708,
3640600265713,
3640700443869,
3640700546625,
3650100053733,
3650100097471,
3650100168883,
3650100188884,
3650100227596,
3650100262375,
3650100288765,
3650100294650,
3650100306054,
3650100327698,
3650100428877,
3650100430022,
3650100437582,
3650100679624,
3650100844293,
3650100996247,
3650101058470,
3650101131053,
3650101141857,
3650101225155,
3650101240766,
3650101240782,
3650101240812,
3650200164090,
3650200205527,
3650200500464,
3650200604804,
3650300112296,
3650300159624,
3650300167252,
3650500032725,
3650500135966,
3650500137454,
3650500175585,
3650500191254,
3650500196281,
3650500203104,
3650500224624,
3650500236941,
3650500252547,
3650500340641,
3650500400694,
3650500412099,
3650500430178,
3650500479193,
3650500493889,
3650600208230,
3650600306487,
3650600616371,
3650600912611,
3650700023011,
3650800160338,
3650800193376,
3650800225499,
3650800281313,
3650800289594,
3650800311611,
3650800311824,
3650800325311,
3650800370413,
3650800371258,
3650800446088,
3650800531867,
3650800532341,
3650800536206,
3650800542796,
3650800573543,
3650800701703,
3650800827570,
3650800834177,
3650800834355,
3650800839420,
3650800862375,
3650801005484,
3650801028123,
3650801032562,
3650801069920,
3650900047517,
3650900100230,
3650900134436,
3650900280581,
3650900370342,
3650900516134,
3659900009214,
3659900045288,
3659900068857,
3659900082281,
3659900096010,
3659900153838,
3659900187538,
3659900229125,
3659900243764,
3659900265172,
3659900281101,
3659900292552,
3659900316672,
3659900320378,
3659900396099,
3659900403214,
3659900427857,
3659900460781,
3659900473531,
3659900512757,
3659900520385,
3659900527461,
3659900529315,
3659900536982,
3659900564994,
3659900625578,
3659900680072,
3659900715691,
3659900765027,
3659900819526,
3660100533174,
3660100578500,
3660200049924,
3660200239456,
3660300162421,
3660300189116,
3660400031948,
3660500405891,
3660500556015,
3660600566179,
3660700116302,
3660700207529,
3660800288091,
3670500090474,
3759900352791,
5650100010062,
5650100020726,
5650190021077,
5650390003161,
5650690000222"; 
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language='javascript' src='../../common/popcalendar.js'></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" colspan="2" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px">รายงานสถิติการบันทึกข้อมูล</td>
        </tr>
		   <tr>
          <td width="63%" class="headerTB">&nbsp;</td>
          <td width="37%">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
	  <form name="form" method="post" action="">
	<table width="100%" height="19" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="13%" align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="59%" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="28%" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#CCCCCC" class="indexbold">&nbsp;</td>
        <td bgcolor="#CCCCCC" class="indexbold">วัน เดือน ปี
          <input type="text" name="date1" value="<?=swapdate($datereq)?>" size="10">
            <input type=button NAME="d1" id="d1"  onclick='popUpCalendar(this, this.form.date1, "dd/mm/yyyy");' value='V' style='font-size:11px'>
            &nbsp;
            <input type="submit" name="Submit" value="   ค้นหา   ">		  </td>
        <td align="center" bgcolor="#CCCCCC"><a href="CC_keyin_user.inc.php?process=run" target="_blank"><img src="../../images_sys/refresh.png" width="16" height="16" border="0">ประมวลค่าสูงสุดและค่าเฉลี่ย</a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><input name="round" type="radio" value="am" <?=$checked1?>>
          รอบเช้า 
            <input name="round" type="radio" value="pm" <?=$checked2?>>
            รอบบ่าย</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
    </table>
      </form>    
<? if($action==""){?>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" id="table0" class="sortable">
  <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
    <td height="24" align="center" class="fillcolor_menu"><strong>ลำดับ</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ชื่อ-นามสกุล</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงานวันนี้</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงาน<br>
    รายชั่วโมง</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงานทั้งหมด</strong></td>
    <td align="center" class="fillcolor_menu"><strong>สถานที่ทำงาน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนคน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนรายการ</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ค่าคะแนน<br>
      การทำงาน</strong></td>
  </tr>
<?
$sql = "
SELECT 
keystaff.staffid
FROM keystaff Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid
WHERE  ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' )  AND date(timeupdate) > '2009-12-14'
AND period_time = '$round'
GROUP BY keystaff.staffid
ORDER BY keystaff.staffid ASC
";
//echo "$sql <br>" ; // AND ( keystaff.sapphireoffice = 0 ) AND ( keystaff.status = '$round' ) AND  (keystaff.sapphireoffice = 0)
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

//echo "$rs[staffid] <br>";

  $arr_staff[] = $rs[staffid] ;
}  

$arr_staff = array_unique($arr_staff) ;

//echo "<pre>";print_r($arr_staff);echo "</pre>";

$i = 1 ;


foreach($arr_staff AS $key1 => $val1){
  if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
  //echo "$name<br>";
$numrows =0 ;  

$TNUM = 0 ;
$TPOINT = 0 ;
	  $j =1 ;

	$sql1 = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' ) AND   keystaff.staffid =  '$val1'   AND   monitor_keyin.idcard IN($arr_idcard) AND  date(monitor_keyin.timeupdate) > '2009-12-14' GROUP BY idcard   ORDER BY keystaff.staffid ASC     limit 1   " ;
$result1 = mysql_db_query($dbnameuse,$sql1);
//echo " $sql1 <br> $name : $rs1[idcard] <hr> "; 
$numrows = mysql_num_rows($result1);
while($rs1 = mysql_fetch_assoc($result1)){



$result3 = mysql_db_query("edubkk_master"," SELECT  siteid   FROM  view_general  WHERE  CZ_ID = '$rs1[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;


	  	$sql3 = " SELECT  count(username) AS NUM ,  user_ip  FROM  log_update WHERE  username = '$rs1[idcard]' AND staff_login='$rs1[staffid]'  AND  date(logtime) > '2009-12-14'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC limit 1 ";
		//echo "$rs3[siteid]  : $sql3<br>";
		$result3 = mysql_db_query($dbsite,$sql3) ;
		$rs3= mysql_fetch_assoc($result3);

//	  	$sql2 = " SELECT  count(username) AS NUM , username , subject , logtime , user_ip  FROM  log_update WHERE  username = '$rs1[idcard]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC ";
//		//echo "$rs3[siteid]  : $sql2<br>";
//		$result2 = mysql_db_query($dbsite,$sql2) ;
//		$rs2 = mysql_fetch_assoc($result2);
		//$TNUM = $TNUM + $rs2[NUM] ;
		
		foreach($arr_f_tbl1 AS $key => $val){
			$t = explode("#",$val);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);

			
			$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rs1[idcard]' AND date($rs_ff[Field]) >  '2009-12-14'  GROUP BY  $c " ;
			//echo "$sql_c <br>";
			$result_c = @mysql_db_query($dbsite,$sql_c) ;
			$rs_c = @mysql_fetch_assoc($result_c);
			$rs_c[num] = @mysql_num_rows($result_c);
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$tb1 = $t[0]."$subfix";
				$TPOINT = $TPOINT + ($rs_c[num]*$k_point[$tb1]) ;
			}
			//echo "$dbsite  $t[0]".$subfix." ::  $sql_c  <br>$rs1[idcard]   ::  $rs_c[num] <hr>";
		}
		//echo "$dbsite : $TNUM + $rs2[NUM] : <br> $sql2 <hr>";
		$j++ ; 
}


$resultx= mysql_db_query($dbnameuse," SELECT  *    FROM  keystaff  WHERE  staffid  = '$val1' ");
$rsx = mysql_fetch_assoc($resultx);
$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]"; 

//echo "$name : $val1  $rsx[status] == $round || $rsx[status]";

		if(substr($rs3[user_ip],0,8)=="192.168."){ $place = "Office";}else{$place = "InternetCafe";}
		if(substr($rs3[user_ip],0,8) == "192.168."){ // แสดงหน้ารายงานเฉพาะ พนักงานที่คีย์ข้อมูลข้างใน
		
		if($TPOINT > 0 ){ $arrnum[] = $TPOINT ; }
		
		
	 ?>	
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="2%" height="18" align="center"><?=$i?></td>
    <td width="23%">&nbsp;      <? echo "$name : $val1 "; ?></td>

      <td width="10%" align="center"><a href="report_keyin_user3.php?staffid=<?=$val1?>&datereq=<?=$datereq?>" target="_blank"><img src="images/cal.jpg" width="16" height="16" border="0"></a></td>
      <td width="10%" align="center"><a href="CC_log_keyin.php?staffid=<?=$val1?>&datereq=<?=$datereq?>" target="_blank"><img src="../../images_sys/history.gif" width="16" height="16" border="0"></a></td>
      <td width="13%" align="center"><a href="report_keyin_user2.php?staffid=<?=$val1?>" target="_blank"><img src="images/calendar.jpg" width="16" height="16" border="0"></a></td>
      <td width="14%" align="center"><?=$place?></td>
	    <td width="7%" align="center"><?=$numrows?> </td>
    <td width="11%" align="center"><?=$TNUM?></td>
    <td width="10%" align="center"><?=$TPOINT?></td>
  </tr>
  <?
	  }//end if(substr($rs3[user_ip],0,8) == "192.168."){
  $i++; }
  ?>
</table>
<?

rsort($arrnum);
$maxkey = $arrnum[0];
reset($arrnum);
sort($arrnum);
$minkey = $arrnum[0];
reset($arrnum);
$numuser  = count($arrnum);
$sumarr = array_sum($arrnum);

?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td width="44%" align="center" bgcolor="#5C85EF" class="link_back">รายการ </td>
    <td width="20%" align="center" bgcolor="#5C85EF" class="link_back">ค่าคะแนน</td>
    <td width="36%" bgcolor="#5C85EF">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าสูงสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$maxkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าต่ำสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$minkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าเฉลี่ย </td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=number_format(($sumarr/$numuser),2)?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#B7CBCF" class="headerTB">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
  </tr>
</table>
<? } ?>
</BODY></HTML>