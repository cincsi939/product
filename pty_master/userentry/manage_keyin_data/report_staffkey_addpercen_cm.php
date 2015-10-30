<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
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
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			include("function_add_percen.php");
			$prov_site = 1; // รหัสจังหวัดของอุดร
			
			$k12 = 0.1051;
			$percenadd = 5;
			$datenotcal = "2011-07-04";
			
			if($start_date == "" and $end_date == ""){
				$date1 = "2011-06-27";
				$date2 = "2011-07-25";
			}else{
				$date1 = GetDateDB($start_date);
				$date2 = GetDateDB($end_date);
			}

		
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			$in_site_id = GetInSite_id($prov_site);
			
			
	######################  ประมวลผล script #############################
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($_POST['btn_process']  == "ประมวลผลข้อมูลก่อนแสดงรายงาน"){
			if($in_site_id != ""){
					$conin = " AND  t1.site_id IN($in_site_id)";
					CleanStatIncentive($conin);
			}else{
					$conin = "";
			}
			$arr_serverdown = GetPercenServerDown($date1,$date2);
			$arr_basepoint = GetBasePoint(); // เกณฑ์ค่าคะแนนมาตรฐาน
			//echo "<pre>$date1 :: $date2 ";
			//print_r($arr_serverdown);die;
					$sql = "SELECT
t2.datekeyin, t1.staffid, t2.numkpoint, t3.spoint, t3.point_ratio, t2.rpoint, 
if(t2.rpoint > 0 AND t2.rpoint Is Not Null,t3.spoint * t2.rpoint,if(t3.point_ratio > 0 AND t3.point_ratio Is Not Null,t3.spoint * t3.point_ratio,t3.spoint * 1)) AS subpoint
FROM
keystaff as t1
Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid
left Join stat_subtract_keyin as t3 On t2.staffid=t3.staffid and t2.datekeyin=t3.datekey
where   t2.datekeyin between '$date1' and '$date2' and t2.datekeyin <> '$datenotcal'   $conin
group by t2.datekeyin,t1.staffid
order by t2.datekeyin,t1.staffid ASC";
					
					//echo $sql;
					$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
					$arrkdate = GetKDate($date1,$date2);
					while($rs = mysql_fetch_assoc($result)){
						
												$yymm = substr($rs[datekeyin],0,7);
						if($yymm == $temp_yymm){
							$stat_pointadd = 0;
							$incentive = 0;
							$temp_yymm = $yymm;
						}
						
						if($temp_staffid  != $rs[staffid]){
								$stat_pointadd = 0;
								$incentive = 0;
								$temp_staffid = $rs[staffid];
						}
						
						
							if($arr_basepoint[$rs[keyin_group]] == ""){
								$base_point = 240;
							}else{
								$base_point = $arr_basepoint[$rs[keyin_group]];
							}
						
						
						
						
						$k5percen = (($rs[numkpoint]*$percenadd)/100);
						$kpoint_add5p = $rs[numkpoint]+(($rs[numkpoint]*$percenadd)/100);
						$k_date = $arrkdate[$rs[datekeyin]];
						$k_server = $arr_serverdown[$rs[datekeyin]]; // ค่าประมวลผล server down
						//echo $rs[datekeyin]." => ".$arr_serverdown[$rs[datekeyin]]."<br>";
						if($k_date > 0){
							$v_k_date = (($kpoint_add5p*$k_date)/100);
							$netkpoint = $kpoint_add5p+$v_k_date;
						}else{
							$k_date = 0;
							$v_k_date = 0;
							$netkpoint = $kpoint_add5p;
								
						}
						$vk_serverdown = ($netkpoint*$k_server)/100;
						$point_addserver = $netkpoint+$vk_serverdown;
						
						
						$kpoint_end = $point_addserver-$rs[subpoint];
						
###########  ส่วนของ incentive  
						$point_add = $point_addserver-$base_point;
						if($point_add < 0){
								$point_add = 0;
						}
						
						$point_add1 = StatSumPointAdd($rs[staffid],$rs[datekeyin]);
						
						##### หาค่าคะแนนสะสะม #####
						
						
						$stat_pointadd  = ($point_add+$point_add1); // คะแนนสะสม
						$point_add_net = $stat_pointadd-$rs[subpoint]; // คะแนนสุทธิ
					
						$incentive = $point_add_net*0.5;
						
						$sqlr = "REPLACE INTO stat_addkpoint_report SET staffid='$rs[staffid]',datekeyin='$rs[datekeyin]',numkpoint='$rs[numkpoint]',k5percen='$k5percen',kpoint_add5p='$kpoint_add5p',k_date='$k_date',v_k_date='$v_k_date',netkpoint='$netkpoint',subtarct_val='$rs[subpoint]',kpoint_end='$kpoint_end',vk_serverdown='$vk_serverdown',point_addserver='$point_addserver' ,point_add='$point_add',stat_pointadd='$stat_pointadd',incentive='$incentive',point_add_net='$point_add_net' ";
					mysql_db_query($dbnameuse,$sqlr) or die(mysql_error()."$sqlr<br>LINE__".__LINE__);
							
					}// end while($rs = mysql_fetch_assoc($result)){
				
				
			echo "<script>alert('ประมวลผลข้อมูลเรียบร้อยแล้ว');location.href='?start_date=$start_date&end_date=$end_date'</script>";	
			exit();
		}// end if($_POST['btn_process']  == "ประมวลผลข้อมูลก่อนแสดงรายงาน"){
	}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
	
	
	####################### end ประมวลผล Script ########################
			
			
			
			
			
			
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

		
		
function GetReport($date1,$date2){
	global $dbnameuse;
	$sql = "SELECT
t1.staffid,
count(t1.datekeyin) as numday,
sum(t1.numkpoint) as numpoint,
sum(t1.k5percen) as numk5p,
sum(t1.kpoint_add5p) as numadd_k5,
sum(t1.netkpoint) as numadd_kd,
sum(t1.v_k_date) as num_ks,
sum(t1.vk_serverdown) as numpserver,
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
				$arr[$rs[staffid]]['numpserver'] = $rs[numpserver];
				
				
				
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="7%" align="right"><strong>วันที่เริ่มต้น : </strong></td>
          <td width="60%" align="left"><INPUT name="start_date" onFocus="blur();" value="<?=GetDateFrom($date1)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.start_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td width="33%" align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>วันที่สิ้นสุด : </strong></td>
          <td align="left"><INPUT name="end_date" onFocus="blur();" value="<?=GetDateFrom($date2)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.end_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left"><input type="submit" name="btn_view" id="btn_view" value="แสดงรายงาน">
            <input type="submit" name="btn_process" id="btn_process" value="ประมวลผลข้อมูลก่อนแสดงรายงาน"></td>
          <td align="left">&nbsp;</td>
          </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table" >
      <thead>  
      <tr>
        <td colspan="15" align="center" bgcolor="#CCCCCC"><strong><a href="report_staffkey_addpercen_cm_incentive.php" target="_blank">แสดงรายงาน incentive</a> || รายงานการบันทึกข้อมูลระหว่างวันที่ <?=DBThaiLongDateFull($date1)?> ถึงวันที่ <?=DBThaiLongDateFull($date2)?> ของจังหวัดเชียงใหม่</strong></td>
        </tr>
      <tr>
        <th width="3%" align="center" bgcolor="#CCCCCC"><span class="txthead">ลำดับ</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">ชื่อ นามสกุล</span></th>
        <th width="3%" align="center" bgcolor="#CCCCCC"><span class="txthead">กลุ่ม</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">วันที่เริ่มทำงาน</span></th>
        <th width="12%" align="center" bgcolor="#CCCCCC"><span class="txthead">ศูนย์คีย์ฯ</span></th>
        <th width="5%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนดิบ</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่า K(5%)</span></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่าสัมประสิทธิการ<br>
          ประมวลผล <br>
          Server ช้า</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">ชดเชยเนื่อง<br>
          จากปิดระบบ</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนสุทธิ<br>
          ก่อนหักจุดผิด</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนถ่วง<br>
          น้ำหนัก<br>
          คุณภาพ QC(คะแนน) </span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">คะแนนสุทธิ<br>
          (คะแนน)</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">จำนวนวัน<br>
          ทำงาน(วัน)</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">ผลผลิตเฉลี่ย<br>
          ต่อวัน<br>
          (คะแนน)</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">ฐานเงินเดือน</span></th>
      </tr>
      	</thead>    
	<tbody>   
      <?
	  
	  			if($in_site_id != ""){
					$conin = " AND  t1.site_id IN($in_site_id)";
			}else{
					$conin = "";
			}

	  
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
where  t1.status_permit='YES' and t1.status_extra='NOR'  AND t1.period_time='am'
$conin
ORDER BY t1.keyin_group ASC,t1.staffname asc,t1.staffsurname asc
";
	$result = mysql_db_query($dbnameuse,$sql);
	$i=0;
	$arrk = GetReport($date1,$date2);
	$numpoint_b = 0;
	$point_net =0;
	$point_end = 0;
	while($rs = mysql_fetch_assoc($result)){
	if($arrk[$rs[staffid]]['numpoint'] > 0){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	$numpoint_b = $arrk[$rs[staffid]]['numpoint']+$arrk[$rs[staffid]]['numk5p']+$arrk[$rs[staffid]]['num_ks']+$arrk[$rs[staffid]]['numpserver'];
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
        <td align="left" nowrap="nowrap" width="7%"><? echo "<a href='report_staffkey_addpercen_detail.php?staffid=$rs[staffid]&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&netpoint=".$arrk[$rs[staffid]]['numnet']."&numday=".$arrk[$rs[staffid]]['numday']."&pointday=".$arrk[$rs[staffid]]['point_per_day']."&date_start=$rs[start_date]' target='_blank'>$rs[prename]$rs[staffname] $rs[staffsurname]</a>";?></td>
        <td align="center" nowrap="nowrap" width="3%"><?=$rs[groupname]?></td>
        <td align="center" nowrap="nowrap" width="7%"><?
        	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		echo  ShowDateThai($rs[start_date]);
	}else{
		echo  "";	
	}

		?></td>
        <td align="left" nowrap="nowrap" width="12%"><?=$arrsite[$rs[site_id]]?></td>
        <td align="center" width="5%"><?=number_format($arrk[$rs[staffid]]['numpoint'],2)?></td>
        <td align="center" width="6%"><?=number_format($arrk[$rs[staffid]]['numk5p'],2)?></td>
        <td align="center" width="9%"><?=number_format($arrk[$rs[staffid]]['num_ks'],2)?></td>
        <td align="center" width="6%"><?=number_format($arrk[$rs[staffid]]['numpserver'],2)?></td>
        <td align="center" width="7%"><?=number_format($numpoint_b,2)?></td>
        <td align="center" width="8%" class="txtcolor"><? echo"-".number_format($arrk[$rs[staffid]]['numsub'],2);?></td>
        <td align="center" width="6%"><?=number_format($point_net,2)?></td>
        <td align="center" width="6%"><?=$arrk[$rs[staffid]]['numday']?></td>
        <td align="center" width="8%"><?=number_format($point_end,2)?></td>
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
var TSort_Data = new Array ('my_table','','h','h', 'g','h','g','g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ob_end_flush();    ?>

</body>
</html>


