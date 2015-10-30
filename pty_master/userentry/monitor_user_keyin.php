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
			include ("../../common/std_function.inc.php")  ;
			$dbnameuse = DB_USERENTRY;
			
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
				$d1 = intval($x[0]);
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

		$exday = explode("-",$datereq);
		$datereq1 = ($exday[0]-543)."-$exday[1]-$exday[2]";
		
/**
 * Function to calculate date or time difference.
 * 
 * Function to calculate date or time difference. Returns an array or
 * false on error.
 *
 * @author       J de Silva                             <giddomains@gmail.com>
 * @copyright    Copyright &copy; 2005, J de Silva
 * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
 * @param        string                                 $start
 * @param        string                                 $end
 * @return       array
 */
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">
	function refresh_iframe(subject1,sentsecid,czid){
		top.frames['a1'].location = "statistic_graph_user.php?subject="+subject1+"&secid="+sentsecid+"&czid="+czid ;
	}
</script></HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr3/hr_report/images/report_banner_011.gif">
        <tr>
          <td width="63%" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px">รายงานสถิติ</td>
          <td width="37%" align="right"><img src="../hr3/hr_report/images/report_banner_03.gif" width="365" height="50" /></td>
        </tr>
		   <tr>
          <td class="headerTB">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
<? if($action==""){?>

<table width="100%" border="0" cellpadding="0" cellspacing="1">
  
  <tr>
    <td height="24" class="fillcolor_menu"><strong>รายงานการบันทึกข้อมูลของ <?=$name?></strong></td>
  </tr>

  <tr>
    <td width="52%" height="24" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" id="table0" class="sortable">
  			<tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
              <td width="3%" height="16" align="center" class="index1">No.</td>
              <td width="12%" align="center" class="index1">วันที่</td>
              <td width="18%" align="center" class="index1">ผู้บันทึก</td>
              <td width="18%" align="center" class="index1">รายการ</td>
              <td width="15%" align="center" class="index1">สพท.</td>
              <td width="8%" align="center" class="index1">เวลาเริ่ม</td>
              <td width="9%" align="center" class="index1">เวลาสิ้นสุด</td>
              <td width="9%" align="center" class="index1">เวลาบันทึก<br>
                ข้อมูล(ชม.)</td>
              <td width="8%" align="center" class="index1">จำนวนการบันทึก</td>
            </tr>
            <?
		  $j =1 ;
		
$sqlx = " SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,date(monitor_keyin.timeupdate) AS datekin ,
MIN(monitor_keyin.timeupdate),
MAX(monitor_keyin.timeupdate)
FROM
monitor_keyin
Inner Join keystaff ON monitor_keyin.staffid = keystaff.staffid
WHERE
keystaff.sapphireoffice =  '0' AND
time(monitor_keyin.timeupdate) >  '18:00:00' AND date(monitor_keyin.timeupdate) >  '2009-09-11'
GROUP BY
monitor_keyin.staffid,date(monitor_keyin.timeupdate)
ORDER BY date(monitor_keyin.timeupdate)      ";			
$resultx = mysql_db_query($dbnameuse,$sqlx);
while($rsx = mysql_fetch_assoc($resultx)){
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
$TNUM = 0 ;

$sql = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.siteid,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   (  keystaff.sapphireoffice = 0 )  AND   keystaff.staffid =  '$rsx[staffid]' AND  date(timeupdate) =  '$rsx[datekin]' AND time(monitor_keyin.timeupdate) >  '18:00:00'  GROUP BY idcard   ORDER BY monitor_keyin.timeupdate ASC   


  " ;
 // echo "$sql";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

$result3 = mysql_db_query(DB_MASTER," SELECT  siteid, prename_th,name_th,surname_th   FROM  view_general  WHERE  CZ_ID = '$rs[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;

$result4 = mysql_db_query(DB_MASTER," SELECT  secname   FROM  eduarea  WHERE  secid = '$rs3[siteid]' ");
$rs4 = mysql_fetch_assoc($result4);
$secname = str_replace('สำนักงานเขตพื้นที่การศึกษา','สพท.',$rs4[secname]);


$name = "$rs3[prename_th]$rs3[name_th]  $rs3[surname_th]";

	  	$sql2 = " SELECT  count(username) AS NUM , MAX(logtime) AS Maxtime , MIN(logtime) AS Mintime , TIMEDIFF( MAX(logtime),MIN(logtime)) AS difftime  , username , subject , logtime  FROM  log_update WHERE  username = '$rs[idcard]'  AND logtime LIKE  '$rsx[datekin]%'  AND time(logtime) >  '18:00:00' AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   logtime  DESC ";
		//echo "$dbsite : $sql2 <br>";
		$result2 = mysql_db_query($dbsite,$sql2) ;
		$rs2 = mysql_fetch_assoc($result2);

		$t1 = explode(" ",$rs2[Mintime]);
		$t2 = explode(" ",$rs2[Maxtime]);

	  ?>
            <tr bgcolor="<?=$bgcolor1?>">
              <td height="22" align="center"><?=$j?></td>
              <td><? echo swapdate($rsx[datekin]);?></td>
              <td>&nbsp;<? echo "$rsx[prename]$rsx[staffname] $rsx[staffsurname]" ;  ?></td>
              <td>&nbsp; <? echo "$name";?></td>
              <td align="center">&nbsp;<?=$secname?></td>
              <td align="center"><?=$t1[1]?></td>
              <td align="center"><?=$t2[1]?></td>
              <td align="center"><?=$rs2[difftime]?></td>
              <td align="center"><?=number_format($rs2[NUM])?></td>
            </tr>
            <? 
	 	
		}
	  ?>
	  <? $j++ ;   } ?>
        </table>
		</td>
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