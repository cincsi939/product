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
	$dbnameuse = "edubkk_userentry";
	$dbcall = "edubkk_userentry";
	
	$_GET['Graph'] = "Show";
	
	$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");


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
	//$xlastlogin=$_SESSION['session_lastlogin'];
}
$sql_starttime = "SELECT
min(timestamp_key) as starttime
FROM monitor_keyin WHERE date(timestamp_key) ='".date("Y-m-d")."' and staffid='$xstaff_id'";
$result_starttime = mysql_db_query($dbnameuse,$sql_starttime) or die(mysql_error()."$sql_starttime<br>LINE::".__LINE__);
$rs_stime = mysql_fetch_assoc($result_starttime);
$xlastlogin = $rs_stime[starttime];

	$resultx = mysql_db_query($dbnameuse," SELECT * FROM keystaff  WHERE  staffid = '$xstaff_id'  ");
	$rsx = mysql_fetch_assoc($resultx) ;
	
	//$xstaff_id = 9928 ;
	$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]";
	
	// Aussy : Select Ranking, Score /////////////////////////////////////////////////////////////////
/*	$strSQL = "SELECT COUNT(epm_log.staffid) AS CountResult FROM epm_log
					WHERE DATE(epm_log.logtime)=\"".date("Y-m-d")."\" AND
					epm_log.staffid=\"".$xstaff_id."\" AND
					epm_log.act=\"9\";"; 
*/	$strSQL = "SELECT numperson as CountResult  FROM stat_user_keyin  WHERE  staffid='$xstaff_id' AND datekeyin='".date("Y-m-d")."'";		
	if ( $_GET['Debug'] == "ON" ) echo $strSQL;
	$rsConn = mysql_query($strSQL);
	$objKeyResult = mysql_fetch_object($rsConn);
	// End Select Ranking, Score /////////////////////////////////////////////////////////////////////
?>
<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style4 {color: #FFFFFF}
.style6 {color: #FFFF00}
.style7 {color: #FFFF00; font-weight: bold; }
-->
</style>
<script language="javascript">
	<!--
	/*
	By George Chiang (WA's JavaScript tutorial) 
	http://wsabstract.com
	*/
	
/*	function shwDateTimeNow() {
		//if (!document.all)
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
		setTimeout(shwDateTimeNow(),1000)
	}
	
	window.onload=shwDateTimeNow();

*/</script>

</head>
<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=0 cellpadding=0 width="98%">
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center"><table width="70%" border="1" cellspacing="0" cellpadding="0" bordercolor="#990000">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-color:#990000">
        <tr>
          <td><p>  <font color="#990000">
              <h3>��С�ȡ����������Է���Ҿ�ͧ����ͧ����������������</h3>
              </font>
            </p></td>
        </tr>
        <tr>
          <td><p>&nbsp;&nbsp;&nbsp;<strong>�</strong><strong>������������Է���Ҿ�ͧ����ͧ����������������  ��������ͧ�� ����ѷ ������¹��äӹǳ��ṹ Incentive</strong><strong><br>
�ҡ �ء � 2 �������  �� <u>�ѹ���ͧ���� ������� </u><u>12.00 �. ��� 24.00  �.</u> �觼�������Ѻ�ͧ��Ҥ�ṹ <br>
��ͧ�ӡ���Ѻ�ͧ��͹��ѧ �ѹ��͹˹��  �������ö�Ѻ�ͧ��ѹ��� � ��</strong><br>
<strong>���㹻Ѩ�غѹ���ա���������˹��¤�����(</strong><strong>RAM) �����������&nbsp;</strong><br>
<strong>�����ͧ�ҡ˹��»����żš�ҧ(</strong><strong>CPU) ��ͧ����Ҩҡ��ҧ����ȫ�觨зӡ��Upgrade  �ѹ�շ�����Ѻ�Թ���</strong></p></td>
        </tr>
        <tr>
          <td><p><strong>�֧��������Һ�·��ǡѹ </strong></p></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td class="Label_big_black">&nbsp;</td>
</tr>
<tr><td width=35><img src="images/user_icon.gif"></td>
<td class="Label_big_black">��§ҹ��úѹ�֡�����Ţͧ   <?=$_SESSION[session_fullname]?>&nbsp;&nbsp;<a href="report_incentive_per_month.php?sent_staffid=<?=$_SESSION[session_staffid]?>&staff=keyin">��§ҹ Incentive ��Ш���͹</a></td>
</tr>
<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>
<tr valign=top>
  <td colspan=2 valign="middle"><img src="../../images_sys/new.gif" width="31" height="23">&nbsp;��й���к����Ѻ��ا��û����żŤ�ṹ �ҡ�ء� 3 ����������繷ء� 2 ����������� �����Ţͧ��ҹ�ж١��Ѻ��ا�ء���������� 2 ���ŧ��� ������䢻ѭ�Ң������Ѿവ��Ҫ�����ͧ�� �ҡ��ҹ��ҹ�к���ǧ�鹪�������Ҩ�Դ��û����Ū���ѡ�Դ..�к��������ҡ�û����Ż���ҳ 1 �ҷդ������������ṹ���Ѻ�ء��ҹ ������㹤�������дǡ </td>
</tr>
<tr valign=top>
  <td colspan=2><table width="750" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td background="images/box_bg.gif" bgcolor="#0879c7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="49%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                          <tr>
                            <td width="47%" class="style6"><span class="style7">���� - ���ʡ�� : </span></td>
                            <td width="53%" class="style4"><?=$name?></td>
                          </tr>
                  <!--        <tr>
                            <td class="style6"><span class="style7">�����������Ժѵԧҹ : </span></td>
                            <td class="style4"><?=ShowThaiDateTime($xlastlogin);?></td>
                          </tr>-->
                          <tr>
                            <td class="style7">����㹢�й�� : </td>
                            <td class="style4"><? echo ShowThaiDateTime(date("Y-m-d H:i:s"));?> <span id="tick2"></span></td>
                          </tr>
                          <tr>
                            <td class="style3">&nbsp;</td>
                            <td class="style4">&nbsp;</td>
                          </tr>
                      </table></td>
                      <td width="20%" valign="top"><iframe src="ranking.php" name="a1" width="140" height="120" align="center"  frameborder="0" id="a1" border="0" scrolling="no"></iframe></td>
                      <td width="31%"><table width="90" height="100" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="top" bgcolor="#006699"><iframe src="score1.php" name="a1" width="280" height="140" align="center"  frameborder="0" id="a1" border="0" scrolling="no"></iframe></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="#273f6f"><span class="style4">&nbsp;�ӹǹ�ؤ�ҡ÷��ѹ�֡������ <strong><?=number_format($objKeyResult->CountResult)?></strong> ��</span></td>
                      <td colspan="2" align="center" bgcolor="#172c55">
                        <span class="style6"><strong>�����Ť�ṹ �</strong> : </span>
                        <span class="ptext_w">
                        <?
	$dbnameuse = "edubkk_userentry";
	$sql1 =  " SELECT  *  FROM  ranking   " ;
	$result1 = mysql_db_query($dbnameuse,$sql1) ;
	$rs1 = mysql_fetch_assoc($result1) ;
	//echo $rs1[timeupdate];
	echo "�ѹ��� ".ShowThaiDateTime($rs1[timeupdate]);
?></span></td>
                    </tr>
                    <tr>
                      <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                          <tr>
                            <td width="52%" height="24" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><?
$TNUM = 0 ;$j =1 ;

if($start_date == ""){
	$start_date = "01/".date("m")."/".(date("Y")+543);	
}
if($end_date == ""){
	$end_date = date("d/m")."/".(date("Y")+543);
}

$con_s_date = ThaiDate2DBDate($start_date);
$con_e_date = ThaiDate2DBDate($end_date);

$condate = " AND datekeyin BETWEEN '$con_s_date' AND '$con_e_date' ";

$arrbese = GetBasePointAndPercenAdd($xstaff_id); // ��Ҥ�ṹ�ҵðҹ
$basepointg = $arrbese['base_point'];
$sql1 = " SELECT *  FROM  stat_user_keyin   WHERE  staffid = '$xstaff_id' $condate ORDER BY  datekeyin  DESC  " ;
$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
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
	if($d2 > "") $d2 .= ";";
	$d2 .= $rsget[val_kmax];
	if($d3 > "") $d3 .= ";";
	$d3 .= $rsget[val_kavg];
	if($d4 > "") $d4 .= ";";
	$d4 .= $basepointg;

	///echo "$rsget[val_avg] <br>";
	if($daylist > "") $daylist .= ";";
	$daylist .= DBThaiLongDateS($key1);
}

//die;

$subtitle = "";
$title = "ʶԵԡ�úѹ�֡�����Ţͧ $name";
//$graphurl = $graph_path . "?category=$daylist&data1=$d1&data2=$d2&data3=$d3&data4=$d4&outputstyle=&numseries=3&seriesname=�ӹǹ��¡��;���ʧ�ش;��������;ࡳ���Ҥ�ṹ&graphtype=area&title=$title&xname=�ѹ ��͹ ��&yname=�ӹǹ��¡��(����)&subtitle=&graphstyle=srd_for_dataentry";
$graphurl = $graph_path . "?category=$daylist&data1=$d1&data2=$d2&data3=$d3&data4=$d4&outputstyle=&numseries=4&seriesname=�ӹǹ��¡��;���ʧ�ش;��������;����ҵðҹ&graphtype=area&title=$title&xname=�ѹ ��͹ ��&yname=�ӹǹ��¡��(����)&subtitle=&graphstyle=srd_for_dataentry_new";


?>
                                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #666666;">
                                        <tr>
                                          <td height="19" align="center" valign="middle" bgcolor="003499"><form name="form1" method="post" action="">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                              <tr>
                                                <td width="28%" class="style7"><strong>���͡��ǧ����㹡���ʴ���ҿ:</strong></td>
                                                <td width="72%" class="style7"><INPUT name="start_date" onFocus="blur();" value="<?=$start_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.start_date, 'dd/mm/yyyy')"value="�ѹ��͹��"> �֧ <INPUT name="end_date" onFocus="blur();" value="<?=$end_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.end_date, 'dd/mm/yyyy')"value="�ѹ��͹��">
            <input type="submit" name="button2" id="button" value="�ʴ���ҿ"></td>
                                              </tr>
                                            </table>
                                          </form></td>
                                        </tr>
                                        <tr>
                                          <td width="100%" height="19" align="center" valign="middle" bgcolor="003499"><? if ( $_GET['Graph'] == "Show" ) { ?><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td align="right" class="fillcolor_headgraph"><img src="../../images_sys/maximize.gif" width="18" height="18" onClick="window.open('<?=$graphurl?>')" style="cursor:hand" alt="�ʴ���ҿ��Ҵ�˭�"></td>
                                              </tr>
                                              <tr>
                                                <td align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="flashx1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$w1?>" height="<?=$h1?>">
                                               <param name="wmode" value="transparent"> 
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
  <td colspan=2>&nbsp;</td>
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