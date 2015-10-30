<?php
header('Content-type: text/html; charset=utf-8');
###################################################################
## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
###################################################################
## Version :		20120106.001 (Created/Modified; Date.RunNumber)
## Created Date :		2012-01-24
## Created By :		Mr. Shayut Sriyala
## E-mail :			chayut@sapphire.co.th
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
<? 
	$type = $_GET[type];
	$siteid = $_GET[siteid];
	$secname = $_GET[secname];
	$title = $_GET[title];
?>
</head>

<body>
<div align="right" id="report">
<table  border="0" cellspacing="0" cellpadding="3" class="tbl_detail fig1" id="my_table">
    	<thead>
        <tr><th align="center" colspan="7">รายงาน<? echo $title?>ของสำนักงานเขตพื่นที่การศึกษา&nbsp;&nbsp;<? echo $secname?></th></tr>
            <tr>
            	
                <th>ลำดับ</th>
                <th>เลขบัตรประชาชน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ตำแหน่ง</th>
                <th>หน่วยงานที่สังกัด</th>
                <th>ไฟล์</th>
            </tr>
        </thead>
        <? 
		
			if($type=='all'){
				$sql="SELECT view_general.CZ_ID,view_general.name_th,view_general.surname_th,view_general.position_now,view_general.schoolname,view_general.prename_th
FROM view_general
WHERE view_general.siteid = '$siteid'";
				
				}
			elseif($type=='approve'){
				$sql="SELECT view_general.CZ_ID,view_general.name_th,view_general.surname_th,view_general.position_now,view_general.schoolname,view_general.prename_th
FROM view_general
WHERE view_general.siteid = '$siteid' AND view_general.user_approve<>'0'";
					
					}
			elseif($type=='notapprove'){
				$sql="SELECT view_general.CZ_ID,view_general.name_th,view_general.surname_th,view_general.position_now,view_general.schoolname,view_general.prename_th
FROM view_general
WHERE view_general.siteid = '$siteid' AND view_general.user_approve='0'";
			}
			elseif($type=='pass'){
				$sql="SELECT view_general.CZ_ID,view_general.name_th,view_general.surname_th,view_general.position_now,view_general.schoolname,view_general.prename_th 
FROM view_general INNER JOIN ".DB_USERENTRY.".view_kp7approve ON view_general.CZ_ID = ".DB_USERENTRY.".view_kp7approve.idcard AND view_general.siteid = ".DB_USERENTRY.".view_kp7approve.siteid
WHERE view_general.siteid='$siteid' AND ".DB_USERENTRY.".view_kp7approve.profile_id='99' AND view_general.user_approve<>'0'";
			}
			elseif($type=='notpass'){
				$sql="SELECT view_general.CZ_ID,
view_general.prename_th,
view_general.name_th,
view_general.surname_th,view_general.position_now,view_general.schoolname, ".DB_USERENTRY.".view_kp7approve.idcard,
SUM(IF(edubkk_userentry.view_kp7approve.profile_id='99' ,1 ,0)) AS chkf 
FROM view_general LEFT OUTER JOIN ".DB_USERENTRY.".view_kp7approve ON view_general.CZ_ID = ".DB_USERENTRY.".view_kp7approve.idcard AND ".DB_USERENTRY.".view_kp7approve.siteid='$siteid'
WHERE view_general.siteid='$siteid' AND view_general.user_approve<>'0' GROUP BY view_general.CZ_ID";
			}		
		?>
        <tbody>
        <?
        	$resEdu=mysql_db_query($dbnamemaster, $sql);
			$number =1;
			
			if($type=='notpass'){
				while($ass=mysql_fetch_assoc($resEdu)){ 
				
				if($ass[chkf]==0){		
			
			$partPdf1 =$partPdf."$siteid/$ass[CZ_ID].pdf";
			if(is_file($partPdf1)){
				$linkPdf="<a href='$partPdf1' target='_blank'><img width=\"24\" height=\"26\" src='$partImgPdf' alt='กพ.7 ต้นฉบับ'
				title='กพ.7 ต้นฉบับ' ></a>";
			}else{
					$linkPdf="-";
					}
			$partPdf2 =$partPdfElec."id=$ass[CZ_ID]&sentsecid=$siteid";
			$linkPdf2="<a href='$partPdf2' target='_blank'><img width=\"24\" height=\"26\" src='$partImgPdfElec' alt='กพ.7 อิเล็กทรอนิกส์'title='กพ.7 อิเล็กทรอนิกส์' ></a>";
				
					?>
				<tr>         	
                <td align="center"><? echo $number?></td> 
				<?php $number++;?>
				<td align="center"><?php echo $ass[CZ_ID];?></td>
                <td align="left"><?php echo $ass[prename_th];?><?php echo $ass[name_th];?>&nbsp;&nbsp;<?php echo $ass[surname_th];?></td>
				<td align="left"><?php echo $ass[position_now];?></td>
                <td align="left"><?php echo $ass[schoolname];?></td>
                <td align="right"><? echo $linkPdf?>&nbsp;<? echo $linkPdf2?></td>
            </tr>
				
			<? }
				}
			}else{
			while($ass=mysql_fetch_assoc($resEdu)){ 
			
			$partPdf1=$partPdf."$siteid/$ass[CZ_ID].pdf";
			if(is_file($partPdf1)){
				$linkPdf="<a href='$partPdf1' target='_blank'><img width=\"24\" height=\"26\" src='$partImgPdf' alt='กพ.7 ต้นฉบับ'
				title='กพ.7 ต้นฉบับ' ></a>";
				}else{
					$linkPdf="-";
					}
			$partPdf2 =$partPdfElec."id=$ass[CZ_ID]&sentsecid=$siteid";
			$linkPdf2="<a href='$partPdf2' target='_blank'><img width=\"24\" height=\"26\" src='$partImgPdfElec' alt='กพ.7 อิเล็กทรอนิกส์'title='กพ.7 อิเล็กทรอนิกส์' ></a>";
					?>
				<tr>   	
                <td align="center"><? echo $number?></td> 
				<?php $number++;?>
				<td align="center"><?php echo $ass[CZ_ID];?></td>
                <td align="left"><?php echo $ass[prename_th];?><?php echo $ass[name_th];?>&nbsp;&nbsp;<?php echo $ass[surname_th];?></td>
				<td align="left"><?php echo $ass[position_now];?></td>
                <td align="left"><?php echo $ass[schoolname];?></td>
                <td align="right"><? echo $linkPdf?>&nbsp;<? echo $linkPdf2?></td>
            </tr>
				
			<? }
			}?>	
		</tbody>
        </table>
        </div>
</body>
</html>