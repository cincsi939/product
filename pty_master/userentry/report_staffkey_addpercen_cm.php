<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
$VERSION 				= "9.91";
$BypassAPP 			= true;

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
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			$k12 = 0.1051;
			$percenadd = 5;
			$date1 = "2011-06-27";
			$date2 = "2011-07-25";

			
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			
			
			
			
			
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

		
		
function GetReport(){
	global $dbnameuse,$date1,$date2;
	$sql = "SELECT
t1.staffid,
count(t1.datekeyin) as numday,
sum(t1.numkpoint) as numpoint,
sum(t1.k5percen) as numk5p,
sum(t1.kpoint_add5p) as numadd_k5,
sum(t1.netkpoint) as numadd_kd,
sum(t1.v_k_date) as num_ks,
sum(t1.subtarct_val) as numsub,
sum(t1.kpoint_end) as numnet,
sum(t1.kpoint_end)/count(t1.datekeyin) as point_per_day
FROM stat_addkpoint_report as t1
WHERE t1.datekeyin BETWEEN '$date1' AND '$date2'
group by t1.staffid
order by 
point_per_day desc";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[staffid]]['numday'] = $rs[numday];
				$arr[$rs[staffid]]['numpoint'] = $rs[numpoint];
				$arr[$rs[staffid]]['numadd_k5'] = $rs[numadd_k5];
				$arr[$rs[staffid]]['numadd_kd'] = $rs[numadd_kd];
				$arr[$rs[staffid]]['numsub'] = $rs[numsub];
				$arr[$rs[staffid]]['numnet'] = $rs[numnet];
				$arr[$rs[staffid]]['point_per_day'] = $rs[point_per_day];
				$arr[$rs[staffid]]['numk5p'] = $rs[numk5p];
				$arr[$rs[staffid]]['num_ks'] = $rs[num_ks];
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
</head>


<link href="../../../common/style.css" type="text/css" rel="stylesheet">

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
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtcolor{
	color: #FF0000;
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" id="my_table" class="tbl3">
      <thead>  
      <tr>
        <td colspan="14" align="center" bgcolor="#CCCCCC"><strong><a href="Script_Save_temppoint_cm.php" target="_blank">ประมวลผลใหม่</a> || รายงานการบันทึกข้อมูลระหว่างวันที่ 27 มิถุนายน 2554 ถึง วันที่ 25 ก.ค. 2554 ของจังหวัดเชียงใหม่</strong></td>
        </tr>
      <tr>
        <th width="3%" align="center" bgcolor="#CCCCCC"><span class="txthead">ลำดับ</span></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><span class="txthead">ชื่อ นามสกุล</span></th>
        <th width="4%" align="center" bgcolor="#CCCCCC"><span class="txthead">กลุ่ม</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">วันที่เริ่มทำงาน</span></th>
        <th width="14%" align="center" bgcolor="#CCCCCC"><span class="txthead">ศูนย์คีย์ฯ</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนดิบ</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่า K(5%)</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่าสัมประสิทธิการ<br>
          ประมวลผล <br>
          Server ช้า</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนสุทธิ<br>
          ก่อนหักจุดผิด</span></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนถ่วงน้ำหนัก<br>
          คุณภาพ QC(คะแนน) </span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนสุทธิ<br>
          (คะแนน)</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">จำนวนวัน<br>
          ทำงาน(วัน)</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">ผลผลิตเฉลี่ย<br>
          ต่อวัน<br>
          (คะแนน)</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">ฐานเงินเดือน</span></th>
      </tr>
      	</thead>    
	<tbody>   
      <?
      	$sql = "SELECT
t1.staffid,
t1.id_code,
t2.groupname,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.start_date,
t1.site_id
FROM
keystaff AS t1
Left Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
where t1.site_id NOT IN('6','69','71') and t1.status_permit='YES' and t1.status_extra='NOR' and t1.period_time='am'
ORDER BY t1.keyin_group ASC,t1.staffname asc,t1.staffsurname asc
";
	$result = mysql_db_query($dbnameuse,$sql);
	$i=0;
	$arrk = GetReport();
	while($rs = mysql_fetch_assoc($result)){
	if($arrk[$rs[staffid]]['numpoint'] > 0){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numpoint_b = $arrk[$rs[staffid]]['numpoint']+$arrk[$rs[staffid]]['numk5p']+$arrk[$rs[staffid]]['num_ks'];
	$point_net = $numpoint_b-$arrk[$rs[staffid]]['numsub'];
	$point_end = $point_net/$arrk[$rs[staffid]]['numday'];

		 
		 	if($point_end >= 240){
					$salary = 7000;
					$bgtd = "  bgcolor=\"#006600\"";
			}else if($point_end >= 210 and $point_end < 240){
					$salary = 6500;
					$bgtd = "  bgcolor=\"#FF9900\"";
			}else {
					$salary = 6000;
					$bgtd = $bg;
			}
			
	
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center" width="3%"><?=$i?></td>
        <td align="left" nowrap="nowrap" width="9%"><? echo "<a href='report_staffkey_addpercen_detail.php?staffid=$rs[staffid]&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&netpoint=".$arrk[$rs[staffid]]['numnet']."&numday=".$arrk[$rs[staffid]]['numday']."&pointday=".$arrk[$rs[staffid]]['point_per_day']."&date_start=$rs[start_date]' target='_blank'>$rs[prename]$rs[staffname] $rs[staffsurname]</a>";?></td>
        <td align="center" nowrap="nowrap" width="4%"><?=$rs[groupname]?></td>
        <td align="center" nowrap="nowrap" width="7%"><?
        	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		echo  ShowDateThai($rs[start_date]);
	}else{
		echo  "";	
	}

		?></td>
        <td align="left" nowrap="nowrap" width="14%">"<?=$arrsite[$rs[site_id]]?></td>
        <td align="center" width="6%"><?=number_format($arrk[$rs[staffid]]['numpoint'],2)?></td>
        <td align="center" width="6%"><?=number_format($arrk[$rs[staffid]]['numk5p'],2)?></td>
        <td align="center" width="8%"><?=number_format($arrk[$rs[staffid]]['num_ks'],2)?></td>
        <td align="center" width="6%" ><?=number_format($numpoint_b,2)?></td>
        <td align="center" width="9%" class="txtcolor"><? echo "-".number_format($arrk[$rs[staffid]]['numsub'],2);?></td>
        <td align="center" width="7%"><?=number_format($point_net,2)?></td>
        <td align="center" width="7%"><?=$arrk[$rs[staffid]]['numday']?></td>
        <td align="center" width="7%"><?=number_format($point_end,2)?></td>
        <td align="center" <?=$bgtd?> width="7%"><? echo number_format($salary)	?></td>
      </tr>
 
      <?
	  $point_end = 0;
	  $point_net = 0;
	  $numpoint_b = 0;
	}//end 	if($arrk[$rs[staffid]]['numpoint'] > 0){
	}//end  while($rs = mysql_fetch_assoc($result)){
	  ?>
           </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 

<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','h','h', 'g','h','g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ?>
</BODY></HTML>
