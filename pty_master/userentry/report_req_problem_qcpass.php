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
#Developer::Suwat Khamtum
#DateCreate::2011-01-18
#LastUpdate::2011-01-18
#DatabaseTable::req_problem,req_problem_person
#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
function GetNumProblemEdit($siteid){
	global $dbnamemaster;
$sql = "SELECT
		req_problem_person.idcard
		if(req_problem_person.req_status='3',1,0) as approve
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		AND view_general.siteid='$siteid'
		group by req_problem_person.idcard";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[idcard]] = $rs[approve];
		}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
		
}// end function GetNumProblemEdit(){
	
function GetNumProblemEditPerson($idcard){
	global $dbnamemaster;
$sql = "SELECT
		req_problem.problem_group,
		if(req_problem_person.req_status='3',1,0) as approve
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		AND req_problem_person.idcard='$idcard'
		group by req_problem.problem_group";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[problem_group]]	 = $rs[approve];
		}

	return $arr;
		
}// end function GetNumProblemEditPerson($idcard){

			
			

function GetNumProblemPerson1($siteid){
	global $dbnamemaster;
	$sql = "SELECT
		count(distinct req_problem.problem_group) as num1,
		req_problem_person.idcard
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		AND view_general.siteid='$siteid'
		group by req_problem_person.idcard";
	//echo $sql;
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[idcard]] = $rs[num1];
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;	
}//end function GetNumProblem(){


function GetProblemPerson($idcard){
	global $dbnamemaster;
			$sql = "SELECT
		req_problem_person.idcard,
		view_general.siteid,
		view_general.prename_th,
		view_general.name_th,
		view_general.surname_th,
		view_general.position_now,
		req_problem.problem_group,
		req_problem.problem_caption
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		and req_problem_person.idcard='$idcard'
		group by req_problem.problem_group";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[problem_group]]['groupid'] = $rs[problem_group];
			$arr[$rs[problem_group]]['caption'] = $rs[problem_caption];	
		}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end 

function GetProblemQc($idcard){
		global $dbnameuse;
		$sql = "SELECT
	validate_checkdata.idcard,
	validate_checkdata.staffid,
	validate_checkdata.date_check,
	validate_checkdata.result_check,
	validate_checkdata.qc_staffid,
	validate_datagroup.dataname,
	validate_checkdata.checkdata_id,
	validate_datagroup.checkdata_id,
	validate_datagroup.parent_id,
	t1.req_menuid
	FROM
	validate_checkdata
	Left Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
	left join menu_math_req_qc as t1 on validate_datagroup.checkdata_id=t1.qc_menuid
	WHERE
	validate_checkdata.idcard =  '$idcard'
	group by t1.req_menuid
	";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[req_menuid]]['groupid'] = $rs[req_menuid];
			$arr[$rs[req_menuid]]['caption'] = $rs[dataname];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetProblemQc($idcard){


		function GetNumProblem(){
			global $dbnamemaster;
			$sql = "SELECT
view_general.siteid,
count(distinct req_problem_person.idcard) as num1
FROM
req_problem_person
Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
WHERE
req_problem_person.del =  '0' AND
req_problem.problem_type =  '1'
GROUP BY
view_general.siteid";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
				
		}// end 	while($rs = mysql_fetch_assoc($result)){
			return $arr;	
}//end 	function GetNumProblem(){
	
	
function GetProblemCheck(){
	global $dbnamemaster;
	$sql = "SELECT 
 ".DB_MASTER.".view_general.siteid,
sum(if( ".DB_MASTER.".req_problem_person.idcard <> '',1,0)) as numall,
sum(if(tc1.idcard IS NOT NULL,1,0)) as numqc
FROM
req_problem_person
Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
left join ".DB_USERENTRY.".validate_checkdata as tc1 ON req_problem_person.idcard=tc1.idcard
WHERE
req_problem_person.del =  '0' AND
req_problem.problem_type =  '1'
group by 
view_general.siteid
";	
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numall'] = $rs[numall];
		$arr1[$rs[siteid]]['numqc'] = $rs[numqc];
	}
	return $arr1;
}//end function GetProblemCheck(){
	
	
function GetSecname($xsiteid){
	global $dbnamemaster;
	$sql = "SELECT secname_short FROM eduarea WHERE secid='$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
		return $rs[secname_short];
}//end function GetSecname(){
		
			
function GetProblemAll(){
		global $dbnamemaster;
				$sql = "SELECT
		distinct  ".DB_MASTER.".req_problem_person.idcard,
		 ".DB_MASTER.".view_general.siteid,
		tc1.idcard as idcard1,
		 ".DB_MASTER.".view_general.prename_th,
		 ".DB_MASTER.".view_general.name_th,
		 ".DB_MASTER.".view_general.surname_th,
		 ".DB_MASTER.".view_general.position_now
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		left join ".DB_USERENTRY.".validate_checkdata as tc1 ON req_problem_person.idcard=tc1.idcard
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		order by
		 ".DB_MASTER.".view_general.siteid
		asc
		";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
			
			if($rs[idcard1] != ""){
					$arr[$rs[siteid]]['numqc'] = $arr[$rs[siteid]]['numqc']+1;
			}// end if($rs[idcard1] != ""){
					$arr[$rs[siteid]]['numall'] = $arr[$rs[siteid]]['numall']+1;
				
		}// end while($rs = mysql_fetch_assoc($result)){
			
		return $arr;
}//end 		function GetProblemAll(){
	
	function GetStaffname($staffid){
		global $dbnameuse;
		$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
			
	}//end function GetStaffname(){

	

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language='javascript' src='../../common/popcalendar.js'></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	



</script>
</HEAD>
<BODY >
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
          <td colspan="5" align="center" bgcolor="#CCCCCC"><strong>จำนวนการยื่นคำร้องขอแก้ไขข้อมูลจากเจ้าของข้อมูลเนื่องจากการพิมพ์ข้อมูลผิด || <a href="report_req_problem_numqc.php">แสดงจำนวนรายการจำแนกรายพนักงาน QC</a> || <a href="report_req_problem_qcpass.php">แสดงจำนวนรายการจำแนกราย สพท.</a></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="32%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนการพิมข้อมูลผิด(คน)</strong></td>
        <td width="22%" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่พิมพ์ผิดและผ่าน QC แล้ว(คน)</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><p><strong>จำนวนที่ยังไม่ผ่านการ QC(คน)</strong></p></td>
      </tr>
      
      <?
	  $arr = GetProblemAll(); // จำนวนเขต
      	$sql = "SELECT *,if(substring(secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite FROM eduarea WHERE secid NOT LIKE '99%' ORDER BY idsite,secname asc";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$numall = $arr[$rs[secid]]['numall'];
			$numqc= $arr[$rs[secid]]['numqc'];
			if($numall > 0){ // มีค่าเท่านั้น
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $numdiff = $numall-$numqc;
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="center"><? echo "<a href='?action=view&xsiteid=$rs[secid]&xtype=all'>".number_format($numall)."</a>";?></td>
        <td align="center"> <? if($numqc > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&xtype=qc'>".number_format($numqc)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numdiff > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&xtype=diff'>".number_format($numall-$numqc)."</a>";}else{ echo "0";}?></td>
      </tr>
      <?
	  		$sum_all += $numall;
			$sum_qc += $numqc;
			}//end if($numall > 0){
	  $numall = 0;
	  $numqc = 0;
	  $numdiff = 0;
		}//end 
	  ?>
         <tr bgcolor="#CCCCCC">
        <td colspan="2" align="center"><strong>รวม</strong></td>
        <td align="center"><strong>
          <?=number_format($sum_all);?>
        </strong></td>
        <td align="center"><strong>
          <?=number_format($sum_qc);?>
        </strong></td>
        <td align="center"><strong>
          <?=number_format($sum_all-$sum_qc);?>
        </strong></td>
      </tr>

    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
	if($action == "view"){
	
	if($xtype == "qc"){
			  $conv = " and tc1.idcard IS NOT NULL";
			  $xtitle = "รายชื่อที่มีการยื่นคำร้องขอแก้ไขข้อมูลผ่าน callcenter และมีการ QC แล้ว ";
	}else if($xtype == "diff"){
			  $conv = " and tc1.idcard IS  NULL";
			   $xtitle = "รายชื่อที่มีการยื่นคำร้องขอแก้ไขข้อมูลผ่าน callcenter และยังไม่ผ่านการ QC ";
	}else{
			$conv = "";	
			 $xtitle = "รายชื่อที่มีการยื่นคำร้องขอแก้ไขข้อมูลผ่าน callcenter ทั้งหมด ";
	}//end 	if($xtype == "qc"){

		
		
	if($xtype == "qc"){
		$xcolspan =  "8";	
	}else{
			$xcolspan = 4;
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$xcolspan?>" align="left" bgcolor="#CCCCCC"><strong><a href="?action=">ย้อนกลับ</a> || <?=$xtitle?> <?=GetSecname($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <? 	if($xtype == "qc"){ ?>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>พนักงาน QC</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>วันที่ QC</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>สถานะการแก้ไข<br>
          จากทีม Callcenter</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรายการปัญหา<br>
          ที่รับแจ้ง(รายการ)</strong></td>
        <? }//end 	if($xtype == "qc"){ ?>
        
      </tr>
      <?
	  $arr_approve = GetNumProblemEdit($xsiteid);
	  $arrnump = GetNumProblemPerson1($xsiteid);
	 // echo "<pre>";
	 // print_r($arrnump);
      	$sql = "SELECT
		distinct  ".DB_MASTER.".req_problem_person.idcard,
		 ".DB_MASTER.".view_general.siteid,
		tc1.idcard as idcard1,
		 ".DB_MASTER.".view_general.prename_th,
		 ".DB_MASTER.".view_general.name_th,
		 ".DB_MASTER.".view_general.surname_th,
		 ".DB_MASTER.".view_general.position_now,
		if(tc1.qc_staffid <> '',tc1.qc_staffid,tc1.staffid_check) as staffid,
		if(tc1.qc_date <> NULL and tc1.qc_date <> '',tc1.qc_date,tc1.date_check) as dateqc
		FROM
		req_problem_person
		Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
		Inner Join req_problem ON req_problem_person.req_person_id = req_problem.req_person_id
		left join ".DB_USERENTRY.".validate_checkdata as tc1 ON req_problem_person.idcard=tc1.idcard
		WHERE
		req_problem_person.del =  '0' AND
		req_problem.problem_type =  '1'
		$conv
		and 	 ".DB_MASTER.".view_general.siteid='$xsiteid'
		order by 		 ".DB_MASTER.".view_general.name_th asc
		";
		//echo $sql."<br>$dbnamemaster";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <? 	if($xtype == "qc"){ ?>
        <td align="left"><?=GetStaffname($rs[staffid]);?></td>
        <td align="center"><?=DBThaiLongDate($rs[dateqc]);?></td>
        <td align="center"><? if($arr_approve[$rs[idcard]] == 1){echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ได้รับการแก้ไขข้อมูลจากทีม callcenter เรียบร้อยแล้ว\">";}else{ echo "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ได้รับการแก้ไขข้อมูลจากทีม callcenter เรียบร้อยแล้ว\">";}?></td>
        <td align="center"><? if($arrnump[$rs[idcard]] > 0){ echo "<a href='?action=view_detail&xsiteid=$rs[siteid]&idcard=$rs[idcard]&xtype=$xtype&fullname=$rs[prename_th]$rs[name_th] $rs[surname_th]&dateqc=".DBThaiLongDate($rs[dateqc])."&staffqc=".GetStaffname($rs[staffid])."'>".number_format($arrnump[$rs[idcard]])."</a>";}else{ echo "0";}?></td>
        <? }// end 	if($xtype == "qc"){?>
          
        
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view"){
		
	if($action == "view_detail"){
		
		

			
	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#CCCCCC"><strong><a href="?action=view&xsiteid=<?=$xsiteid?>&xtype=<?=$xtype?>">ย้อนกลับ</a> || ข้อมูลการยื่นคำร้องขอแก้ไขข้อมูล(พิมพ์ข้อมูลผิด) ของ&nbsp;<?=$fullname?>
          พนักงาน QC <?=$staffqc?> วันที่ QC <?=$dateqc?></strong></td>
      </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="26%" align="center" bgcolor="#FFFF99"><strong>หมวดรายการปัญหา</strong></td>
        <td width="17%" align="center" bgcolor="#FFFF99"><strong>รายละเอียดการแจ้งขอแก้ไขข้อมูล</strong></td>
        <td width="23%" align="center" bgcolor="#FFFF99"><strong>สถานะการแก้ไขข้อมูล<br>
จากทีม callcenter</strong></td>
        <td width="19%" align="center" bgcolor="#CCFFFF"><strong>รายละเอียดการ QC</strong></td>
        <td width="12%" align="center" bgcolor="#CCFFFF"><strong>เอกสาร ก.พ.7</strong></td>
      </tr>
      <?

	  $xarr1 = GetProblemPerson($idcard);
	  $xarr2 = GetProblemQc($idcard);
	  $status_edit = GetNumProblemEditPerson($idcard); // สถานะการแก้ไขข้อมูล
	  //echo "<pre>";print_r($status_edit);
      	$sql = "SELECT * FROM req_problem_group ORDER BY order_by ASC";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			
			if($xarr1[$rs[runno]]['groupid'] != ""){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../edubkk_kp7file/$xsiteid/".$idcard.".pdf";
			 if(is_file($file_pdf)){
						 $pdforg = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
				}else{
						$pdforg = "";	
				}// end  if(is_file($file_pdf)){
			 
		$pdf.= "<a href=\"../hr3/hr_report/kp7_search.php?id=".$idcard."&sentsecid=".$xsiteid."\" target=\"_blank\">";
		$pdf.= "<img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='ก.พ.7 สร้างโดยระบบ'></a>";
		
			 
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left" ><?=$rs[problem_name]?></td>
        <td align="left" ><? echo $xarr1[$rs[runno]]['caption'];?></td>
        <td align="center" ><? if($status_edit[$rs[runno]] == "1"){ echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ได้รับการแก้ไขข้อมูลจากทีม callcenter เรียบร้อยแล้ว\">";}else{ echo "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ได้รับการแก้ไขข้อมูลจากทีม callcenter เรียบร้อยแล้ว\">";} ?></td>
        <td align="left" ><? if($xarr2[$rs[runno]]['caption'] != ""){ echo $xarr2[$rs[runno]]['caption'];}else{ echo "<font color=\"#FF0000\">QC ไม่พบปัญหา</font>";}?></td>
        <td align="center"><? echo "$pdforg || $pdf";?></td>
      </tr>
      <?
	  $pdf = "";
			}//end if($xarr1[$rs[runno]]['groupid'] != ""){
	}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view_detail"){
?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>