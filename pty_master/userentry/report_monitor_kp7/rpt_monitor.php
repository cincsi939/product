<?php
header('Content-type: text/html; charset=utf-8');
###################################################################
## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
###################################################################
## Version :		20120106.001 (Created/Modified; Date.RunNumber)
## Created Date :		2012-01-07
## Created By :		Mr. Nattaphon Mahawan
## E-mail :			nattaphon@sapphire.co.th
## Tel. :
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
session_start();
set_time_limit(0);
include("main.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="<?php echo $url_base; ?>common/jquery.js" type="text/javascript"></script>
<script src="<?php echo $url_base; ?>report_new_v1/js/report.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $url_base; ?>report_new_v1/css/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url_base; ?>report_new_v1/css/top_menu.css" />
<script type=text/javascript src="<?php echo $url_base; ?>common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="<?php echo $url_base; ?>common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<link href="<?php echo $url_base; ?>report_new_v1/css/default.css" type="text/css" rel="stylesheet">
<link href="<?php echo $url_base; ?>common/jscriptfixcolumn/cssfixtable.css" type="text/css" rel="stylesheet">
<script src="<?php echo $url_base; ?>common/gs_sortable.js"></script>
<title>รายงาน</title>
<script type=text/javascript>
            $(function() {
                $(".fix1").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 4 });
				$(".fix2").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 1 });
            });
</script>
</head>

<body>
<?php
function genSql($case, $siteid){
	global $datecheck;
	switch($case){
		case 'all': 
			$sql=""; break;
		case 'notkey': 
			$sql="AND view_monitor_key.status_doc='0' "; 
		break;
		case 'keyall': 
			$sql=" AND view_monitor_key.status_doc='1' "; 
		break;
		case 'less26upKey': 
			$sql=" AND view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_update' AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26) "; 
		break;
		case 'less26upNotKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='0' AND view_monitor_key.status_dockey='kp7_update'
AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26) "; 
		break;
		case 'more26upKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='1' AND view_monitor_key.status_dockey='kp7_update'
AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26) "; 
		break;
		case 'more26upNotKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='0' AND view_monitor_key.status_dockey='kp7_update' AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26) "; 
		break;
		case 'less26newKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='1' AND view_monitor_key.status_dockey='kp7_new' AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26) "; 
		break;
		case 'less26newNotKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='0' AND view_monitor_key.status_dockey='kp7_new'
AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26) "; 
		break;
		case 'more26newKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='1' AND view_monitor_key.status_dockey='kp7_new'
AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26) "; 
		break;
		case 'more26newNotKey': 
			$sql=" AND view_monitor_key.status_doc='1'  AND view_monitor_key.status_assign='0' AND view_monitor_key.status_dockey='kp7_new' AND FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26) "; 
		break;
	}
	$strSql="SELECT view_monitor_key.idcard, 
	 ".DB_CHECKLIST.".tbl_checklist_kp7.prename_th, 
	 ".DB_CHECKLIST.".tbl_checklist_kp7.name_th, 
	 ".DB_CHECKLIST.".tbl_checklist_kp7.surname_th, 
	 ".DB_CHECKLIST.".tbl_checklist_kp7.position_now,
	FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)) AS ageWork 
FROM view_monitor_key INNER JOIN  ".DB_CHECKLIST.".tbl_checklist_kp7 ON view_monitor_key.idcard =  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard 
AND view_monitor_key.siteid =  ".DB_CHECKLIST.".tbl_checklist_kp7.siteid AND  ".DB_CHECKLIST.".tbl_checklist_kp7.profile_id = view_monitor_key.profile_id
WHERE view_monitor_key.siteid='{$siteid}' {$sql} ";
	return $strSql;
}
function getDateProfile($profile_id){
	global $dbTempCheckData;
	list($profile)=mysql_fetch_row(mysql_db_query($dbTempCheckData, "SELECT profilename_short FROM tbl_checklist_profile WHERE profile_id='{$profile_id}' "));
	return $profile;
}
function showAll(){
	global $dbnamemaster;
	global $datecheck;
	global $tblMonitorKey;
	global $dbTempCheckData;
	$i=1;
	?>
    <div align="right"><a href='scriptImportViewMonitor.php' target='_blank'>ประมวลผลทั้งหมด</a></div>
    <table  border="0" cellspacing="0" cellpadding="3" class="tbl_detail fig1" id="my_table">
    	<thead>
            <tr>
                <th rowspan="4">ลำดับ</th>
                <th  rowspan="4">สำนักงาน<br />เขตพื้นที่การศึกษา</th>
                <th  rowspan="4">จำนวนบุคลากรในพื้นที่ทั้งหมด</th>
                <th  rowspan="4">เอกสารไม่พร้อมคีย์</th>
                <th colspan="9">เอกสารพร้อมคีย์</th>
                <th  rowspan="4">ข้อมูลนะวันที่</th>
                <th  rowspan="4">เครื่องมือ</th>
            </tr>
            <tr>
                <th rowspan="3">รวม</th>
                <th colspan="4">เอกสาร UPDATE</th>
                <th colspan="4">เอกสาร NEW</th>
            </tr>
            <tr>
                <th colspan="2">อายุราชการน้อยกว่า 26 ปี</th>
                <th colspan="2">อายุราชการตั้งแต่กว่า 26 ปี</th>
                <th colspan="2">อายุราชการน้อยกว่า 26 ปี</th>
                <th colspan="2">อายุราชการตั้งแต่กว่า 26 ปี</th>
            </tr>
            <tr>
                <th>อยู่ระหว่าง<br />กระบวณการบันทึกข้อมูล</th>
                <th>เอกสารค้างมอบหมาย</th>
                <th>อยู่ระหว่าง<br />กระบวณการบันทึกข้อมูล</th>
                <th>เอกสารค้างมอบหมาย</th>
                <th>อยู่ระหว่าง<br />กระบวณการบันทึกข้อมูล</th>
                <th>เอกสารค้างมอบหมาย</th>
                <th>อยู่ระหว่าง<br />กระบวณการบันทึกข้อมูล</th>
                <th>เอกสารค้างมอบหมาย</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$sqlEdu=" SELECT view_monitor_key.siteid, 
	eduarea.secname_short AS secname, 
	view_monitor_key.profile_id, 
	COUNT(view_monitor_key.idcard) AS sumall, 
	SUM(IF(view_monitor_key.status_doc='0', '1', '0')) AS sumfalse, 
	SUM(IF(view_monitor_key.status_doc='1', '1', '0')) AS sumtrue, 
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_update', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26), if(view_monitor_key.status_assign='1', 1, 0), 0) ,0)) AS less26upAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_update', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26), if(view_monitor_key.status_assign='0', 1, 0), 0) ,0)) AS less26upNotAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_update', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26), if(view_monitor_key.status_assign='1', 1, 0), 0) ,0)) AS more26upAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_update', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26), if(view_monitor_key.status_assign='0', 1, 0), 0) ,0)) AS more26upNotAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_new', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26), if(view_monitor_key.status_assign='1', 1, 0), 0) ,0)) AS less26newAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_new', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)<26), if(view_monitor_key.status_assign='0', 1, 0), 0) ,0)) AS less26newNotAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_new', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26), if(view_monitor_key.status_assign='1', 1, 0), 0) ,0)) AS more26newAssign,
	SUM(IF(view_monitor_key.status_doc='1' AND view_monitor_key.status_dockey='kp7_new', IF(FLOOR((TIMESTAMPDIFF(MONTH, ".DB_CHECKLIST.".tbl_checklist_kp7.begindate,'{$datecheck}')/12)>=26), if(view_monitor_key.status_assign='0', 1, 0), 0) ,0)) AS more26newNotAssign,
	view_monitor_key.timeupdate 
FROM view_monitor_key INNER JOIN eduarea ON view_monitor_key.siteid = eduarea.secid
	 INNER JOIN  ".DB_CHECKLIST.".tbl_checklist_kp7 ON view_monitor_key.idcard =  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard AND view_monitor_key.profile_id =  ".DB_CHECKLIST.".tbl_checklist_kp7.profile_id 
GROUP BY view_monitor_key.siteid
ORDER BY if(substring(secid,1,1) ='0',cast(secid as SIGNED),0) ASC, secname ASC ";
			$resEdu=mysql_db_query($dbnamemaster, $sqlEdu);
			while($ass=mysql_fetch_assoc($resEdu)){
				if($ass[sumall]>0){
					$link1="<a href='?action=all&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[sumall])."</a>";
				}else{
					$link1=number_format($ass[sumall]);
				}
				if($ass[sumfalse]>0){
					$link2="<a href='?action=notkey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[sumfalse])."</a>";
				}else{
					$link2=number_format($ass[sumfalse]);
				}
				if($ass[sumtrue]>0){
					$link3="<a href='?action=keyall&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[sumtrue])."</a>";
				}else{
					$link3=number_format($ass[sumtrue]);
				}
				if($ass[less26upAssign]>0){
					$link4="<a href='?action=less26upKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[less26upAssign])."</a>";
				}else{
					$link4=number_format($ass[less26upAssign]);
				}
				if($ass[less26upNotAssign]>0){
					$link5="<a href='?action=less26upNotKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[less26upNotAssign])."</a>";
				}else{
					$link5=number_format($ass[less26upNotAssign]);
				}
				if($ass[more26upAssign]>0){
					$link6="<a href='?action=more26upKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[more26upAssign])."</a>";
				}else{
					$link6=number_format($ass[more26upAssign]);
				}
				if($ass[more26upNotAssign]>0){
					$link7="<a href='?action=more26upNotKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[more26upNotAssign])."</a>";
				}else{
					$link7=number_format($ass[more26upNotAssign]);
				}
				if($ass[less26newAssign]>0){
					$link8="<a href='?action=less26newKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[less26newAssign])."</a>";
				}else{
					$link8=number_format($ass[less26newAssign]);
				}
				if($ass[less26newNotAssign]>0){
					$link9="<a href='?action=less26newNotKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[less26newNotAssign])."</a>";
				}else{
					$link9=number_format($ass[less26newNotAssign]);
				}
				if($ass[more26newAssign]>0){
					$link10="<a href='?action=more26newKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[more26newAssign])."</a>";
				}else{
					$link10=number_format($ass[more26newAssign]);
				}
				if($ass[more26newNotAssign]>0){
					$link11="<a href='?action=more26newNotKey&siteid={$ass[siteid]}' target='_blank'>".number_format($ass[more26newNotAssign])."</a>";
				}else{
					$link11=number_format($ass[more26newNotAssign]);
				}
				echo "<tr class=",($i%2=='1')?'odd':'even',">
							<td class='align_center'>{$i}</td>
							<td class='align_left' nowrap='nowrap'>{$ass[secname]}</td>
							<td class='align_amount'>{$link1}</td>
							<td class='align_amount'>{$link2}</td>
							<td class='align_amount'>{$link3}</td>
							<td class='align_amount'>{$link4}</td>
							<td class='align_amount'>{$link5}</td>
							<td class='align_amount'>{$link6}</td>
							<td class='align_amount'>{$link7}</td>
							<td class='align_amount'>{$link8}</td>
							<td class='align_amount'>{$link9}</td>
							<td class='align_amount'>{$link10}</td>
							<td class='align_amount'>{$link11}</td>
							<td class='align_center' nowrap='nowrap'>",getDateProfile($ass['profile_id']),"</td>
							<td class='align_center' nowrap='nowrap'><a href='scriptImportViewMonitor.php?xsiteid={$ass[siteid]}' target='_blank'>ประมวลผล</a></td>
						</tr>";
						$i++;
						$sum1+=$ass[sumall];
						$sum2+=$ass[sumfalse];
						$sum3+=$ass[sumtrue];
						$sum4+=$ass[less26upAssign];
						$sum5+=$ass[less26upNotAssign];
						$sum6+=$ass[more26upAssign];
						$sum7+=$ass[more26upNotAssign];
						$sum8+=$ass[less26newAssign];
						$sum9+=$ass[less26newNotAssign];
						$sum10+=$ass[more26newAssign];
						$sum11+=$ass[more26newNotAssign];
			}
		?>
        </tbody>
        <tfoot>
        	<tr>
            	<td colspan="2">รวม</td>
                <td class='align_amount'><?php echo number_format($sum1); ?></td>
                <td class='align_amount'><?php echo number_format($sum2); ?></td>
                <td class='align_amount'><?php echo number_format($sum3); ?></td>
                <td class='align_amount'><?php echo number_format($sum4); ?></td>
                <td class='align_amount'><?php echo number_format($sum5); ?></td>
                <td class='align_amount'><?php echo number_format($sum6); ?></td>
                <td class='align_amount'><?php echo number_format($sum7); ?></td>
                <td class='align_amount'><?php echo number_format($sum8); ?></td>
                <td class='align_amount'><?php echo number_format($sum9); ?></td>
                <td class='align_amount'><?php echo number_format($sum10); ?></td>
                <td class='align_amount'><?php echo number_format($sum11); ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <?php
}

function showFillter($case, $siteid){
	global $dbnamemaster;
	global $partPdf;
	global $partImgPdf;
	switch($case){
		case 'all': $title="รายงานจำนวนบุคลากรในพื้นที่"; break;
		case 'notkey': $title="รายงานจำนวนเอกสารไม่พร้อมคีย์"; break;
		case 'keyall': $title="รายงานจำนวนเอกสารพร้อมคีย์"; break;
		case 'less26upKey': $title="รายงานจำนวนเอกสาร UPDATE อายุราชการน้อยกว่า 26 ปี กระบวณการบันทึกข้อมูล"; break;
		case 'less26upNotKey': $title="รายงานจำนวนเอกสาร UPDATE อายุราชการน้อยกว่า 26 ปี เอกสารมอบหมาย"; break;
		case 'more26upKey': $title="รายงานจำนวนเอกสาร UPDATE อายุราชการตั้งแต่กว่า 26 ปี กระบวณการบันทึกข้อมูล"; break;
		case 'more26upNotKey': $title="รายงานจำนวนเอกสาร UPDATE อายุราชการตั้งแต่กว่า 26 ปี เอกสารมอบหมาย"; break;
		case 'less26newKey': $title="รายงานจำนวนเอกสาร NEW อายุราชการน้อยกว่า 26 ปี กระบวณการบันทึกข้อมูล"; break;
		case 'less26newNotKey': $title="รายงานจำนวนเอกสาร NEW อายุราชการน้อยกว่า 26 ปี เอกสารมอบหมาย"; break;
		case 'more26newKey': $title="รายงานจำนวนเอกสาร NEW อายุราชการตั้งแต่กว่า 26 ปี กระบวณการบันทึกข้อมูล"; break;
		case 'more26newNotKey': $title="รายงานจำนวนเอกสาร NEW อายุราชการตั้งแต่กว่า 26 ปี เอกสารมอบหมาย"; break;
	}
	list($sitename)=mysql_fetch_row(mysql_db_query($dbnamemaster, "SELECT secname FROM eduarea WHERE secid='{$siteid}' "));
	?>
   	<h2 align="center" style="margin:0; padding:0;"><?php echo $title; ?></h2>
    <h3 align="center" style="margin:0; padding:0;"><?php echo $sitename; ?></h3>
    <table  border="0" cellspacing="0" cellpadding="3" class="tbl_detail fix2" id="my_table">
    	<thead>
        	<tr>
            	<th>ลำดับ</th>
                <th>เลขบัตรประจำตัวประชาชน</th>
                <th>ชื่อสกุล</th>
                <th>ตำแหน่ง</th>
                <th>อายุราชการ</th>
                <th>กพ.7 ต้นฉบับ</th>
            </tr>
        </thead>
        <tbody>
        	<?php
			$i=1;
			$sql=genSql($case,$siteid);
			$result=mysql_db_query($dbnamemaster, $sql);
			while(list($idcard, $prename, $name, $surname, $position_now, $ageWork)=mysql_fetch_row($result)){
				$partPdf2 =$partPdf."$siteid/$idcard.pdf";
				if(is_file($partPdf2)){
					$linkPdf="<a href='$partPdf2' target='_blank'><img width=\"24\" height=\"26\" src='$partImgPdf' alt='กพ.7 ต้นฉบับ' title='กพ.7 ต้นฉบับ' ></a>";
				}else{
					$linkPdf="-";
				}
				//echo $partPdf2."<br>";
				echo "<tr class=",($i%2=='1')?'odd':'even',">
							<td class='align_center'>{$i}</td>
							<td class='align_center'>{$idcard}</td>
							<td>$prename$name &nbsp;$surname</td>
							<td>{$position_now}</td>
							<td  class='align_center'>{$ageWork}</td>
							<td  class='align_center'>".$linkPdf."</td>
						</tr>";
						$i++;
			}
			?>
        </tbody>
    </table>
    <?php
}
?>
<div id="report">
	<?php
	$action=$_GET['action'];
	$siteid=$_GET['siteid'];
	if($action!=""){
		showFillter($action, $siteid);
	}else{
		showAll();
	}
	?>
</div>
</body>
</html>