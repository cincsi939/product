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
			if($_SESSION['session_staffid'] == ""){
				echo "<script>alert('กรุณา login เพื่อเข้าใช้งานระบบ'); location.href='../login.php';</script>";
				exit;
			}//end if($_SESSION['session_staffid'] == ""){
			
			if($prov_site == "" ){
				$prov_site = 2; // รหัสจังหวัดของอุดร		
			}
			
			
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
			if($prov_site == "999"){	
				$in_site_id = "";
			}else{
				$in_site_id = GetInSite_id($prov_site);
			}
			
			
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


#####################################  sql ##########  แสดงข้อมูล #######################################################
	  if($in_site_id != ""){
		 	 $consite = " AND t1.site_id IN($in_site_id)";
	 	}else{
			$consite = "";	
		}
		
		if($staffname != ""){
				$constaff .= " AND t1.staffname LIKE '%$staffname%'";
		}//end if($staffname != ""){
		if($staffsurname != ""){
				$constaff .= " AND t1.staffsurname LIKE '%$staffsurname%'";
		}// end if($staffsurname != ""){
	  
	  if($incentive == "1"){
	 	$arrincent = GetIncentive($date1,$date2,$consite);
	  }// end 
	  if($qc_pd == ""){
		$qc_pd = 1;	 	 
		}
		
	if($cost_pd == ""){
		$cost_pd = 166.91;
	}
	if($manage_pd == ""){
		$manage_pd = 0.3;
	}
	if($salary == ""){
			$salary = 280;
	}
	 if($hw_pd == ""){
		 $hw_pd = 63;
	}
	if($incentive == ""){
			$incentive = 0;
	}
	  
	 $arrgroup1 = GetKeyGroupName();
	 $arridexcellent = GetIdExcellent(); // เลขบัตรของพนักงานที่เป็น excellent
	  
   $sql = "SELECT
t1.staffid,
t1.id_code,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.datekeyin,
(sum(t2.numkpoint)/69)/count(distinct t2.datekeyin) as docperday,
sum(t2.numkpoint)/count(distinct t2.datekeyin) as pointperday,
count(distinct t2.datekeyin) as countday,
t1.start_date,
t1.keyin_group,
t1.card_id
FROM
keystaff as t1
Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid
WHERE  t1.status_permit='YES' AND t1.status_extra='NOR' AND  t1.period_time='am' AND 
t2.datekeyin between '$date1' and '$date2' $consite $constaff
GROUP BY t1.staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$i=0;

	while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

	$docperday = $rs[docperday];//จำนวนชุดเฉลี่ยต่อวัน(ชุด)
	$amount_perday = $docperday*$cost_pd;//จำนวนชุดเฉลี่ยต่อวัน(บาท)
	$salary = $salary;// ค่าจ้างต่อวัน
	## ค่า incentive ##############
	if($arrincent[$rs[staffid]] > 0){
		$incentive = $arrincent[$rs[staffid]]/$rs[countday];
	}else{
		$incentive = 0;
	}
	## end ค่า incentive ##############
	
	####  ค่า QC
	$amount_qc = $docperday*$qc_pd;
	###  ค่าเช่า HW #####
	$amount_hw = $hw_pd;
	##### ค่าบริหารจัดการ ########## 
	$amount_manage = ($salary+$incentive+$amount_qc+$amount_hw)*$manage_pd;
	##### กำไรต่อคนต่อบาท
	$amount_benefit = $amount_perday-($salary+$incentive+$amount_qc+$amount_hw+$amount_manage);
	
	if($amount_benefit < 0){
		$tdread = " class=\"txtcolor\" ";	
	}else{
		$tdread = "";
	}
	
	if($amount_qc < 0){
		$tdread_qc = " class=\"txtcolor\" ";		
	}else{
		$tdread_qc = " ";		
	}
	
		######## เก็บข้อมูลไว้ใน array
	$arrdata[$rs[staffid]]['fullname'] = "$rs[prename]$rs[staffname] $rs[staffsurname]";
   	$arrdata[$rs[staffid]]['start_date'] = DBThaiLongDateFull($rs[start_date]);
	
	if (array_key_exists("$rs[card_id]", $arridexcellent)) {
		$arrdata[$rs[staffid]]['keyin_group'] = "กลุ่ม E";
	}else{
  	  	$arrdata[$rs[staffid]]['keyin_group'] = $arrgroup1[$rs[keyin_group]];
	} // end if (array_key_exists("$rs[card_id]", $arridexcellent)) {
    $arrdata[$rs[staffid]]['pointperday'] = $rs[pointperday];
    $arrdata[$rs[staffid]]['docperday'] = $docperday;
    $arrdata[$rs[staffid]]['amount_perday'] = $amount_perday;
    $arrdata[$rs[staffid]]['salary'] = $salary;
    $arrdata[$rs[staffid]]['incentive'] = $incentive;
    $arrdata[$rs[staffid]]['tdread_qc'] = $tdread_qc;
    $arrdata[$rs[staffid]]['amount_qc'] = $amount_qc;
    $arrdata[$rs[staffid]]['amount_hw'] = $amount_hw;
    $arrdata[$rs[staffid]]['amount_manage'] = $amount_manage;
    $arrdata[$rs[staffid]]['tdread'] = $tdread;
    $arrdata[$rs[staffid]]['amount_benefit'] = $amount_benefit;
    
	if($amount_benefit > 0){ // กำไร
			$arrexsum['numstaff']['add'] += 1;
			$arrexsum['doc']['add'] += $docperday;
			$arrexsum['money']['add'] += $amount_benefit;
	}else{
			$arrexsum['numstaff']['del'] += 1;
			$arrexsum['doc']['del'] += $docperday;	
			$arrexsum['money']['del'] += $amount_benefit;
			
	}
	
}//end 	while($rs = mysql_fetch_assoc($result)){

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
     <td align="center" bgcolor="#CCCCCC"><table width="70%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
           <tr>
             <td colspan="5" align="center" bgcolor="#CCCCCC"><span class="txthead">รายงานสถิติข้อมูลของพนักงาน ตั้งแต่วันที่  
          <?=DBThaiLongDateFull($date1)?> ถึงวันที่ <?=DBThaiLongDateFull($date2)?>
          <? if($prov_site == "999"){  echo "ศูนย์คีย์ทั้งหมด ";}else{ echo " ของจังหวัด".GetProvinceKeyData($prov_site);}?></span></td>
             </tr>
           <tr>
             <td width="24%" bgcolor="#FFFFFF">&nbsp;</td>
             <td width="17%" align="center" bgcolor="#FFFFFF"><strong>บริษัทขาดทุน</strong></td>
             <td width="22%" align="center" bgcolor="#FFFFFF"><strong>บริษัทมีกำไร</strong></td>
             <td width="19%" align="center" bgcolor="#FFFFFF"><strong>รวมทั้งหมด</strong></td>
             <td width="18%" align="left" bgcolor="#FFFFFF">&nbsp;</td>
           </tr>
           <tr>
             <td align="right" bgcolor="#FFFFFF"><strong>จำนวนพนักงาน : </strong></td>
             <td align="center" bgcolor="#FFFFFF"><?=$arrexsum['numstaff']['del']?></td>
             <td align="center" bgcolor="#FFFFFF"><?=$arrexsum['numstaff']['add']?></td>
             <td align="center" bgcolor="#FFFFFF"><?=$arrexsum['numstaff']['del']+$arrexsum['numstaff']['add']?></td>
             <td align="left" bgcolor="#FFFFFF"><strong>คน</strong></td>
           </tr>
           <tr>
             <td align="right" bgcolor="#FFFFFF"><strong>ค่าเฉลี่ยการบันทึกข้อมูล : </strong></td>
             <td align="center" bgcolor="#FFFFFF"><? if($arrexsum['numstaff']['del'] > 0){ echo number_format($arrexsum['doc']['del']/$arrexsum['numstaff']['del'],2);}?></td>
             <td align="center" bgcolor="#FFFFFF"><? if($arrexsum['numstaff']['add'] > 0){ echo number_format($arrexsum['doc']['add']/$arrexsum['numstaff']['add'],2);}?></td>
             <td align="center" bgcolor="#FFFFFF"><? if($arrexsum['numstaff']['del']+$arrexsum['numstaff']['add'] > 0){ echo number_format(($arrexsum['doc']['del']+$arrexsum['doc']['add'])/($arrexsum['numstaff']['del']+$arrexsum['numstaff']['add']),2);}?></td>
             <td align="left" bgcolor="#FFFFFF"><strong>ชุด/คน</strong></td>
           </tr>
           <tr>
             <td align="right" bgcolor="#FFFFFF"><strong>ค่าเฉลี่ยกำไรต่อคน : </strong></td>
             <td align="center" bgcolor="#FFFFFF"><?=number_format($arrexsum['money']['del']/$arrexsum['numstaff']['del'],2)?></td>
             <td align="center" bgcolor="#FFFFFF"><?=number_format($arrexsum['money']['add']/$arrexsum['numstaff']['add'],2)?></td>
             <td align="center" bgcolor="#FFFFFF"><? if($arrexsum['numstaff']['del']+$arrexsum['numstaff']['add'] > 0){ echo number_format(($arrexsum['money']['del']+$arrexsum['money']['add'])/($arrexsum['numstaff']['del']+$arrexsum['numstaff']['add']),2);}?></td>
             <td align="left" bgcolor="#FFFFFF"><strong>บาท/คน</strong></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
  </tr>
   <tr>
    <td align="right" bgcolor="#CCCCCC">&nbsp;&nbsp;<a href="#" onClick="window.open('popup_performance.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=800,height=550');"><img src="../../../images_sys/gear_replace.gif"  width="20" height="16" border="0" title="คลิ๊กเพื่อกำหนดค่าเพื่อวิเคราะห์ต้นทุน"></a>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" id="my_table" class="tbl3">
      <thead> 
      <tr>
        <th width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><span class="txthead">ลำดับ</span></th>
        <th width="12%" rowspan="2" align="center" bgcolor="#CCCCCC"><span class="txthead">ชื่อ นามสกุล</span></th>
        <th width="12%" rowspan="2" align="center" bgcolor="#CCCCCC"><span class="txthead">วันเริ่มงาน</span></th>
        <th width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><span class="txthead">กลุ่ม</span></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><span class="txthead">จำนวนผลผลิตเฉลี่ย/วัน</span></td>
        <td colspan="5" align="center" bgcolor="#CCCCCC"><span class="txthead">ต้นทุนต่อคนต่อวัน(บาท)</span></td>
        <th width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><span class="txthead">กำไรต่อคน <br>
          (บาท)</span></th>
      </tr>
      <tr>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">(คะแนน)</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">(ชุด)</span></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><span class="txthead">(บาท)</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">เงินเดือน</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">incentive</span></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่า QC</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่าเช่า HW</span></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><span class="txthead">ค่าบริหารจัดการ</span></th>
        </tr>
      	</thead>    
	<tbody>   
      <?
	  
if(count($arrdata) > 0){  
	$i=0;
	foreach($arrdata as $key => $val){	
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td align="center" width="3%"><?=$i?></td>
        <td align="left" nowrap="nowrap" width="12%"><?=$val['fullname']?></td>
        <td align="left" nowrap="nowrap" width="12%"><?=$val['start_date']?></td>
        <td align="center" nowrap="nowrap" width="7%"><?=$val['keyin_group']?></td>
        <td align="center" nowrap="nowrap" width="7%"><?=number_format($val['pointperday'],2)?></td>
        <td align="center" nowrap="nowrap" width="8%"><?=number_format($val['docperday'],2)?></td>
        <td align="right" nowrap="nowrap" width="9%"><?=number_format($val['amount_perday'],2)?></td>
        <td align="right" nowrap="nowrap" width="7%"><?=number_format($val['salary'],2);?></td>
        <td align="right" width="6%"><?=number_format($val['incentive'],2);?></td>
        <td align="right" width="6%" <?=$val['tdread_qc']?>><?=number_format($val['amount_qc'],2);?></td>
        <td align="right" width="8%"><?=number_format($val['amount_hw'],2);?></td>
        <td align="right" width="8%"><?=number_format($val['amount_manage'],2);?></td>
        <td align="right" width="7%" <?=$val['tdread']?>><?=number_format($val['amount_benefit'],2);?></td> 
         </tr>
      <?
	  	$sum_pointperday += $val['pointperday'];
		$sum_docperday += $val['docperday']; 
		$sum_amount_perday += $val['amount_perday'];
		$sum_salary += $val['salary'];
		$sum_incentive += $val['incentive'];
		$sum_amount_qc += $val['amount_qc'];
		$sum_amount_hw += $val['amount_hw'];
		$sum_amount_manage += $val['amount_manage'];
		$sum_amount_benefit += $val['amount_benefit'];
		$numstaff += 1;
		
		
	}//end  foreach($arrdata as $key => $val){
}//end if(count($arrdata) > 0){
	  ?>
           </tbody>
           <tfoot>
                 
      <tr bgcolor="#CCCCCC">
        <td colspan="4" align="center" ><span class="txthead">รวม</span></td>
        <td align="right"><span class="txthead"><?=number_format($sum_pointperday,2)?></span></td>
        <td align="right"><span class="txthead"><?=number_format($sum_docperday,2)?></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_amount_perday,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_salary,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_incentive,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_amount_qc,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_amount_hw,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_amount_manage,2)?>
        </span></span></td>
        <td align="right"><span class="txthead">&nbsp;<span class="txthead1">
          <?=number_format($sum_amount_benefit,2)?>
        </span></span></td>
      </tr>
</tfoot>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','h','h','h','h','g', 'g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ob_end_flush();    ?>

</body>
</html>


