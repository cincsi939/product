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
			
			$dbnameuse = DB_USERENTRY;
			
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
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy += 543;
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$round = "am" ;
		
	}

	if($round == "am"){
		$checked1 = "checked" ;
		$checked2 = "" ;
	}else{
		$checked1 = "" ;
		$checked2 = "checked" ;
	}



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
        <td align="center" bgcolor="#CCCCCC"><a href="CC_keyin_user.inc.php" target="_blank"><img src="../../images_sys/refresh.png" width="16" height="16" border="0">ประมวลค่าสูงสุดและค่าเฉลี่ย</a></td>
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
    <td align="center" class="fillcolor_menu">ประวัติการทำงานวันนี้</td>
    <td align="center" class="fillcolor_menu">ประวัติการทำงานทั้งหมด</td>
    <td align="center" class="fillcolor_menu"><strong>สถานที่ทำงาน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนคน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนรายการ</strong></td>
  </tr>
<?
$sql = "
SELECT
general_check.idcard,
general_check.siteid,
general_check.update_date,
general_check.update_staff,
general_check.update6y_date,
general_check.update6y_staff
FROM keystaff Inner Join general_check ON general_check.update_staff = keystaff.staffid OR general_check.update6y_staff = keystaff.staffid
WHERE
( ( general_check.update_date = '$datereq' AND general_check.update_status = 100 )
 OR (general_check.update6y_date = '$datereq' AND  general_check.update6y_status = 100  ) )
AND ( keystaff.sapphireoffice = 0 ) AND ( status = '$round' ) AND  (keystaff.sapphireoffice = 0)
GROUP BY
general_check.idcard 
ORDER BY idcard,siteid
";
//echo "$sql <br>" ;
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	//echo " $datereq :  $rs[update6y_staff]  : $rs[update_staff] ";
  if($rs[update6y_date] == "$datereq"){
  	$rs[staffid] =  $rs[update6y_staff] ;
//	echo " 6 ปี => $rs[staffid] <br>";
  }else{
  	$rs[staffid] =  $rs[update_staff] ;
//	echo " 100% => $rs[staffid] <br>";
  }
  
  $arr_staff[] = $rs[staffid] ;
}  

$arr_staff = array_unique($arr_staff) ;

//echo "<pre>";print_r($arr_staff);echo "</pre>";

$i = 1 ;


foreach($arr_staff AS $key1 => $val1){
  if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
  //echo "$name<br>";
  

$TNUM = 0 ;
	  $j =1 ;

	$sql1 = "
SELECT

general_check.idcard,
general_check.siteid,

general_check.update_status,
general_check.update_note,
general_check.update_date,
general_check.update_staff,

general_check.update6y_status,
general_check.update6y_date,
general_check.update6y_staff
FROM

general_check  
WHERE  ( general_check.update_status =  100  AND  general_check.update_date =  '$datereq'  AND  general_check.update_staff = '$val1' ) OR  ( general_check.update6y_status = 100 AND  general_check.update6y_date =  '$datereq'  AND  general_check.update6y_staff = '$val1' )   " ;
$result1 = mysql_db_query($dbnameuse,$sql1);
$numrows = mysql_num_rows($result1);
while($rs1 = mysql_fetch_assoc($result1)){

//echo " $sql1 <hr> $name : $rs1[idcard] <br> ";

$result3 = mysql_db_query(DB_MASTER," SELECT  siteid   FROM  view_general  WHERE  CZ_ID = '$rs1[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;


	  	$sql2 = " SELECT  count(username) AS NUM , username , subject , logtime , user_ip  FROM  log_update WHERE  username = '$rs1[idcard]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC ";
		//echo "$rs3[siteid]  : $sql2<br>";
		$result2 = mysql_db_query($dbsite,$sql2) ;
		$rs2 = mysql_fetch_assoc($result2);
		
		$TNUM = $TNUM + $rs2[NUM] ;
		//echo "$dbsite : $TNUM + $rs2[NUM] :  $sql2 <hr>";
		$j++ ; 
}

$resultx= mysql_db_query($dbnameuse," SELECT  *    FROM  keystaff  WHERE  staffid  = '$val1' ");
$rsx = mysql_fetch_assoc($resultx);
$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]"; 


		if(substr($rs2[user_ip],0,8)=="192.168."){ $place = "Office";}else{$place = "InternetCafe";}
		
		if($rsx[status] == $round || $rsx[status] != ""){
		if($TNUM > 0 ){ $arrnum[] = $TNUM ; }
		
		
	 ?>	
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="3%" height="18" align="center"><?=$i?></td>
    <td width="27%">&nbsp;      <? echo "$name : $val1 : $rsx[status]"?></td>

      <td width="14%" align="center"><a href="report_keyin_user3.php?staffid=<?=$val1?>&datereq=<?=$datereq?>" target="_blank"><img src="images/cal.jpg" width="16" height="16" border="0"></a></td>
      <td width="16%" align="center"><a href="report_keyin_user2.php?staffid=<?=$val1?>" target="_blank"><img src="images/calendar.jpg" width="16" height="16" border="0"></a></td>
      <td width="18%" align="center"><?=$place?></td>
	    <td width="11%" align="center"><?=$numrows?> </td>
    <td width="11%" align="center"><?=$TNUM?></td>
  </tr>
  <? $i++; } } ?>
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
    <td width="20%" align="center" bgcolor="#5C85EF" class="link_back">ค่า</td>
    <td width="36%" bgcolor="#5C85EF">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าสูงสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$maxkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">รายการ</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าต่ำสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$minkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">รายการ</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าเฉลี่ย </td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=number_format(($sumarr/$numuser))?></td>
    <td bgcolor="#B7CBCF" class="link_back">รายการ</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#B7CBCF" class="headerTB">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
  </tr>
</table>
<? } ?>
</BODY></HTML>