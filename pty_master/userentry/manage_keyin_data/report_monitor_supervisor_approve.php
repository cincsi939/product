<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "report_monitor_keyupdate"; 
$process_id			= "report_monitor_keyupdate";
$VERSION 				= "9.91";
$BypassAPP 			= true;
ob_start(); 

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		��§ҹ����Ѻ�ʴ��š�úѹ�֡������ update
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			include("function_report_keyupdate.php");
		
			
			if($start_date == "" and $end_date == ""){
				$date1 = date("Y-m")."-01";
				$date2 = date("Y-m-d");
			}else{
				$date1 = GetDateDB($start_date);
				$date2 = GetDateDB($end_date);
			}

			$date_holiday = GetHolidayBetween($date1,$date2);
			//echo "$date1 :: $date2<pre>";
			//print_r($date_holiday);die;
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$arrdate = ShowDayBetween($date1,$date2);
		//	echo "$date1 :: $date2 <pre>";
			//print_r($arr_date);
		
		//die;
			$count_yy = date("Y")+543;
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");

			
			$time_start = getmicrotime();

			
	function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}
			
			
		function ShowDateThai($get_date){
			global $mname;
			$arr = explode(" ",$get_date);
			if($arr > 1){
				$get_date = $arr[0];
			}
			if($get_date != "0000-00-00"){
				$arr1 = explode("-",$get_date);	
				return intval($arr1[2])." ".$mname[intval($arr1[1])]." ".substr(($arr1[0]+543),-2);
			}else{
				return "";	
			}
		}//end function ShowDateThai($get_date){
			
	function GetNumSupervisorApprove($date1,$date2){
		global $dbnameuse;
		
		$sql = "SELECT
t1.staffid,
date(t2.datetime_approve) as dateapp,
count(t2.idcard) as numapprove
FROM
keystaff_supervisor as t1
Inner Join tbl_assign_key as t2  ON t1.staffid = t2.supervisor_staffid
where date(t2.datetime_approve) between '$date1' and '$date2' and t1.status_active='1' and t2.approve='2'
group by t1.staffid,date(t2.datetime_approve) order by t1.staffid ,date(t2.datetime_approve) ASC ";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[staffid]][$rs[dateapp]] = $rs[numapprove];
		}
		return $arr;
}// end function GetNumSupervisorApprove(){

$arrnum = 0;
if(count($arrdate) > 0){	
	foreach($arrdate as $k => $v){
		foreach($v as $xk => $xv){
		if($date_holiday[$xv] == ""){
			$arrnum++;
			$arrdate1[$xv] = $xv;	 
		}//end if($date_holiday[$v] == ""){
		}//end foreach($v as $xk => $xv){
	}//end foreach($arrdate as $k => $v){
}//end if(count($arrdate) > 0){	

//echo "<pre>";
//print_r($arrdate1);die;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
</head>


<link href="../../../common/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script src="../../../common/gs_sortable.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</script>
<link href="../../../common/gs_sortable.css" />
<style>
.txtcolor{
	color: #FF0000;
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
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>

<BODY >
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="7%" align="right"><strong>�ѹ���������� : </strong></td>
          <td width="60%" align="left"><INPUT name="start_date" onFocus="blur();" value="<?=GetDateFrom($date1)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.start_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
          <td width="33%" align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>�ѹ�������ش : </strong></td>
          <td align="left"><INPUT name="end_date" onFocus="blur();" value="<?=GetDateFrom($date2)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.end_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
          <td align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left"><input type="submit" name="btn_view" id="btn_view" value="�ʴ���§ҹ"></td>
          <td align="left">&nbsp;</td>
          </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3"  >

      <tr>
        <td colspan="<?=$arrnum+6?>" align="center" bgcolor="#CCCCCC"><strong> ��§ҹ����Ѻ�ͧ�����Ţͧ Supervisor �����ҧ�ѹ��� <?=DBThaiLongDateFull($date1)?> �֧�ѹ��� <?=DBThaiLongDateFull($date2)?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><span class="txthead">�ӴѺ</span></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>���ʾ�ѡ�ҹ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>���� ���ʡ��</strong></td>
        <?
        $cw = 68;
		$w = floor($cw/$arrnum);
		if($arrnum > 0){
              foreach($arrdate1 as $k => $v){
		?>
        <td width="<?=$w?>%" align="center" bgcolor="#CCCCCC"><strong>
          <?=ShowDateThai($v)?>
        </strong></td>
        <?
			  }//end foreach($arrdate as $k => $v){
		}//end if($arrnum > 0){
		?>
         <td width="5%" align="center" bgcolor="#CCCCCC"><strong>���(�ش)</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ӹǹ�ش<br>
          ����µ���ѹ</strong></td>
        </tr>

      <?
	  $arrnum = GetNumSupervisorApprove($date1,$date2);
	$sql = "SELECT
t2.staffid,
t2.prename,
t2.staffname,
t2.staffsurname
FROM
keystaff_supervisor as t1
Inner Join keystaff as t2 ON t1.staffid = t2.staffid 
where t1.status_active='1'
order by t2.staffname ASC";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	$numday = 0;
	$sumapp = 0;
	while($rs = mysql_fetch_assoc($result)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

		 

	
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center" nowrap="nowrap"><?=$rs[staffid]?></td>
        <td align="left" nowrap="nowrap"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <?
        	if($arrnum > 0){
              foreach($arrdate1 as $k => $v){
		?>
        <td align="center"><? if($arrnum[$rs[staffid]][$v] > 0){ echo "<a href='?action=view&dateapp=$v&staffid=$rs[staffid]&staffname=$rs[prename]$rs[staffname]  $rs[staffsurname]' target=\"_blank\">".number_format($arrnum[$rs[staffid]][$v])."</a>";}else{ echo "0";}?></td>
        <?
					$sumapp += $arrnum[$rs[staffid]][$v];
					$numday++;	
			
			  }// end   foreach($arrdate as $k => $v){
			}// end if($arrnum > 0){
		?>
         <td align="center"><?=number_format($sumapp)?></td>
        <td align="center"><?=number_format($sumapp/$numday)?></td>
        </tr>
      <?
		$sumapp = 0;
		$numday = 0;
	}//end  while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<?
}//end if($action == ""){
  	
	if($action == "view"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong><? echo "����Ѻ��á�ä�������Ţͧ $staffname �ͧ�ѹ���  ".ShowDateThai($dateapp);?></strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="26%" align="center" bgcolor="#CCCCCC"><strong>�Ţ�ѵû�ЪҪ�</strong></td>
        <td width="34%" align="center" bgcolor="#CCCCCC"><strong>���� - ���ʡ��</strong></td>
        <td width="34%" align="center" bgcolor="#CCCCCC"><strong>��ѡ�ҹ���������</strong></td>
        </tr>
        <?
	$sql = "SELECT
t1.idcard,
t1.fullname,
t3.prename,
t3.staffname,
t3.staffsurname
FROM
tbl_assign_key as t1
Inner Join tbl_assign_sub as t2  ON t1.ticketid = t2.ticketid
Inner Join keystaff  as t3 ON t2.staffid = t3.staffid
where t1.supervisor_staffid='$staffid' and date(t1.datetime_approve)='$dateapp' and t1.approve='2'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[fullname]?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        </tr>
      <?
	}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view"){
?>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ob_end_flush();    ?>

</body>
</html>


