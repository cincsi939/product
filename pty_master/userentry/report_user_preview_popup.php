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
	include "epm.inc.php";
	
	$dbnameuse = DB_USERENTRY;
	$dbcall = DB_USERENTRY;
	
	$_GET['Graph'] = "Show";
	
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
//$xxx_SESSION['session_staffid']
if($_GET[xstaff_id]==""){
	$xstaff_id=$_SESSION['session_staffid'];	
	$xlastlogin=$_SESSION['session_lastlogin'];
}
	$resultx = mysql_db_query($dbnameuse," SELECT * FROM keystaff  WHERE  staffid = '$xstaff_id'  ");
	$rsx = mysql_fetch_assoc($resultx) ;
	
	//$xstaff_id = 9928 ;
	$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]";
	
	// Aussy : Select Ranking, Score /////////////////////////////////////////////////////////////////
	$strSQL = "SELECT COUNT(epm_log.staffid) AS CountResult FROM epm_log
					WHERE DATE(epm_log.logtime)=\"".date("Y-m-d")."\" AND
					epm_log.staffid=\"".$xstaff_id."\" AND
					epm_log.act=\"9\";"; if ( $_GET['Debug'] == "ON" ) echo $strSQL;
	$rsConn = mysql_query($strSQL);
	$objKeyResult = mysql_fetch_object($rsConn);
	// End Select Ranking, Score /////////////////////////////////////////////////////////////////////
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style4 {color: #FFFFFF}
.style6 {color: #FFFF00}
.style7 {color: #FFFF00; font-weight: bold; }
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<script>
	<!--
	/*
	By George Chiang (WA's JavaScript tutorial) 
	http://wsabstract.com
	*/
	
	function shwDateTimeNow() {
		if (!document.all)
		return
		
		var Digital=new Date()
		var hours=Digital.getHours()
		var minutes=Digital.getMinutes()
		var seconds=Digital.getSeconds()
		var dn="AM" 
		
		if (hours>12){
		dn="PM"
		hours=hours-12
		}
		
		if (hours==0)
		hours=12
		
		if (minutes<=9)
		minutes="0"+minutes
		
		if (seconds<=9)
		seconds="0"+seconds
		var ctime = hours+":"+minutes+":"+seconds+" "+dn
		tick2.innerHTML="<b style='font-size:10;color:#FFCC00;'>"+ctime+"</b>"
		setTimeout("shwDateTimeNow()",1000)
	}
	
	window.onload=shwDateTimeNow
	//-->
</script>
<table border=0 align=center cellspacing=0 cellpadding=0 width="98%">
<tr valign=top height=1 bgcolor="#808080"><td width="35"></td></tr>
<tr valign=top>
  <td>&nbsp;</td>
</tr>
<tr valign=top>
  <td><table width="700" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td background="images/box_bg.gif" bgcolor="#0879c7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="78%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                          <tr>
                            <td width="27%" class="style6"><span class="style7">ชื่อ - นามสกุล : </span></td>
                            <td width="73%" class="style4"><?=$name?></td>
                          </tr>
                          <tr>
                            <td class="style7">เวลาในขณะนี้ : </td>
                            <td class="style4"><?=date("d-m-Y")?> <span id="tick2"></span></td>
                          </tr>
                          <tr>
                            <td class="style3">&nbsp;</td>
                            <td class="style4">&nbsp;</td>
                          </tr>
                      </table></td>
                      <td width="11%" valign="top"><iframe src="ranking.php?xstaff_id=<?=$xstaff_id?>" name="a1" width="140" height="120" align="center"  frameborder="0" id="a1" border="0" scrolling="no"></iframe></td>
                      <td width="11%"><table width="90" height="100" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="top" bgcolor="#006699"><iframe src="score.php?xstaff_id=<?=$xstaff_id?>" name="a1" width="140" height="120" align="center"  frameborder="0" id="a1" border="0" scrolling="no"></iframe></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="#273f6f"><span class="style4">&nbsp;จำนวนบุคลากรที่บันทึกข้อมูล <strong><?=$objKeyResult->CountResult?></strong> คน</span></td>
                      <td colspan="2" align="center" bgcolor="#172c55">
                        <span class="style6"><strong>ประมวลคะแนน ณ</strong> : </span>
                        <span class="ptext_w">
                        <?
	$dbnameuse = DB_USERENTRY;
	$sql1 =  " SELECT  *  FROM  ranking   " ;
	$result1 = mysql_db_query($dbnameuse,$sql1) ;
	$rs1 = mysql_fetch_assoc($result1) ;
	echo $rs1[timeupdate];
?></span></td>
                    </tr>
                    <tr>
                      <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                          <tr>
                            <td width="52%" height="24" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><?
$TNUM = 0 ;$j =1 ;

$sql1 = " SELECT *  FROM  stat_user_keyin   WHERE  staffid = '$xstaff_id'  ORDER BY  datekeyin  DESC  " ;
$result1 = mysql_db_query($dbnameuse,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){


$arrdata[$rs1[datekeyin]] = $rs1[numkpoint] ; 
	if($rs1[val_max] == $rs2[maxnum]){$usrstar="<img src=\"../../images_sys/iopcstar.gif\" width=\"15\" height=\"14\">";}else{$usrstar="";}
	 	$j++ ;   
		}
	  	rsort($arrnum);
		$maxc = $arrnum[0] ;
		reset($arrnum);
	  	sort($arrnum);
		$minc = $arrnum[0] ;
		reset($arrnum);
	  ?>
                                      <?
$graph_path="http://$servergraph/graphservice/graphservice.php";
$w1 = 700;
$h1 = 350 ;

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
                                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #666666;">
                                        <tr>
                                          <td width="100%" height="19" align="center" valign="middle" bgcolor="003499"><? if ( $_GET['Graph'] == "Show" ) { ?><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td align="right" class="fillcolor_headgraph"><img src="../../images_sys/maximize.gif" width="18" height="18" onClick="window.open('<?=$graphurl?>')" style="cursor:hand" alt="แสดงกราฟขนาดใหญ่"></td>
                                              </tr>
                                              <tr>
                                                <td align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="flashx1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>">
                                              <param name="movie" value="<?=$graphurl?>">
                                              <param name="quality" value="high">
                                              <embed src="<?=$graphurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$w1?>" height="<?=$h1?>"></embed>
                                          </object></td>
                                              </tr>
                                          </table><? } ?></td>
                                        </tr>
                                    </table></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
</tr>
<tr valign=top>
  <td>&nbsp;</td>
</tr>
</table>
</BODY>
</HTML>
<?
	if ( $_GET['Debug'] == "ON" ) {
		echo("<pre>");
		print_r($_SESSION);
		echo("</pre>");
	}
?>