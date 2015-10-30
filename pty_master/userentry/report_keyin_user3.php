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
		


$resultx = mysql_db_query($dbnameuse," SELECT  *  FROM  keystaff  WHERE  staffid = '$staffid'  ");
$rsx = mysql_fetch_assoc($resultx) ;

//$staffid = 9928 ;
$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]"; 

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">
	function refresh_iframe(subject1,sentsecid,czid){
		top.frames['a1'].location = "statistic_graph_user.php?subject="+subject1+"&secid="+sentsecid+"&czid="+czid ;
	}
</script>
</HEAD>
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
              <td width="2%" height="16" align="center" class="index1">No.</td>
              <td width="26%" align="center" class="index1">รายการ</td>
              <td width="23%" align="center" class="index1">สพท.</td>
              <td width="10%" align="center" class="index1">เวลาเริ่ม</td>
              <td width="12%" align="center" class="index1">เวลาสิ้นสุด</td>
              <td width="13%" align="center" class="index1">เวลาบันทึกข้อมูล(ชม.)</td>
              <td width="14%" align="center" class="index1">จำนวนการบันทึก</td>
            </tr>
            <?
$TNUM = 0 ;
	  $j =1 ;

$sql = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.siteid,
monitor_keyin.timestamp_key
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' )   AND   keystaff.staffid =  '$staffid' AND  timestamp_key LIKE  '$datereq1%' GROUP BY idcard   ORDER BY monitor_keyin.timestamp_key ASC   


  " ;
 // echo "$sql";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

$TNUM = 0 ;
$TPOINT = 0 ;

$result3 = mysql_db_query("edubkk_master"," SELECT  siteid, prename_th,name_th,surname_th   FROM  view_general  WHERE  CZ_ID = '$rs[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;

$result4 = mysql_db_query("edubkk_master"," SELECT  secname   FROM  eduarea  WHERE  secid = '$rs3[siteid]' ");
$rs4 = mysql_fetch_assoc($result4);
$secname = str_replace('สำนักงานเขตพื้นที่การศึกษา','สพท.',$rs4[secname]);


$name = "$rs3[prename_th]$rs3[name_th]  $rs3[surname_th]";


	  	$sql2 = " SELECT  count(username) AS NUM , MAX(logtime) AS Maxtime , MIN(logtime) AS Mintime , TIMEDIFF( MAX(logtime),MIN(logtime)) AS difftime  , username , subject , logtime  FROM  log_update WHERE  username = '$rs[idcard]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'   OR action LIKE 'insert%') GROUP BY username  ORDER BY   logtime  DESC ";
		//echo "$dbsite : $sql2 <br>";
		$result2 = mysql_db_query($dbsite,$sql2) ;
		$rs2 = mysql_fetch_assoc($result2);


		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
						
			$sql_c = " SELECT COUNT(id) AS num  FROM  $t[0]".$subfix." WHERE id = '$rs[idcard]' AND $rs_ff[Field] LIKE '$datereq1%' GROUP BY  $c " ;
			$result_c = @mysql_db_query($dbsite,$sql_c) ;
			$rs_c = @mysql_fetch_assoc($result_c);
			$rs_c[num] = @mysql_num_rows($result_c);
			//echo "$rs[staffid] $t[0]".$subfix." $rs_c[num]<br>";
			
			if($rs_c[num]>0){
				$TNUM = $TNUM + $rs_c[num] ;
				$tb1 = $t[0]."$subfix";
				$arrnum[$rs[staffid]] = $arrnum[$rs[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
			}
		}
		
		if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		
		
		$t1 = explode(" ",$rs2[Mintime]);
		$t2 = explode(" ",$rs2[Maxtime]);
		
		if($TNUM > 0){
	  ?>
	  
            <tr>
              <td height="22" align="center" bgcolor="#FFFFFF"><?=$j?></td>
              <td bgcolor="#FFFFFF">&nbsp;
                  <? echo "$name [$rs[idcard]]";?></td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;<?=$secname?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$t1[1]?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$t2[1]?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$rs2[difftime]?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$TNUM?></td>
            </tr>
		<? }else{ ?>	
            <tr>
              <td height="22" align="center" bgcolor="#FFFFFF"><?=$j?></td>
              <td bgcolor="#FFFFFF">&nbsp;&nbsp;<? echo "$name [$rs[idcard]]";?></td>
              <td align="center" bgcolor="#FFFFFF"><?=$secname?></td>
              <td colspan="4" align="center" bgcolor="#FFFF00" class="redlink">Not Avaliable </td>
             </tr>
		<? } ?>	 
            <? 
	 	$j++ ;  

		}
	  ?>
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