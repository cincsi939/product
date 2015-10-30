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

</head>

<body>
<div align="right" id="report">
<h3 align="center">รายงานสรุปการบันทึกข้อมูลของเขตนำร่อง</h3>
<table align="center"cellspacing="0" cellpadding="3" class="tbl_exsum">
	<thead>
    <tr>
    	<th>รายการ</th>
        <th>จำนวน</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
	<tr>
    	<td>จำนวนบุคลากรทั้งหมด</td>
        <td align="right" id="t1"><? echo number_format($sum_sumall)?></td>
        <td>คน</td>
    </tr>
    <tr>
    	<td>จำนวนที่บันทึกข้อมูลแล้ว</td>
        <td align="right" id="t2"><? echo number_format($sum_approve)?></td>
        <td>คน</td>
    </tr>
    <tr>
    	<td>จำนวนที่ค้างบันทึกข้อมูล</td>
        <td align="right" id="t3"><? echo number_format($sum_pass)?></td>
        <td>คน</td>
    </tr>
    <tr>
    	<td>จำนวนที่ UPDATE ข้อมูล</td>
        <td align="right" id="t4"><? echo number_format($sum_notpass)?></td>
        <td>คน</td>
    </tr>
    <tr>
    	<td>จำนวนที่ค้าง UPDATE ข้อมูล</td>
        <td align="right" id="t5"><? echo number_format($sum_notapprove)?></td>
        <td>คน</td>
    </tr>
    </tbody>
</table><br />
<table  border="0" cellspacing="0" cellpadding="3" class="tbl_detail fig1" id="my_table">
    	<thead>
            <tr>
                <th rowspan="2">ลำดับ</th>
                <th  rowspan="2">สำนักงานเขตพื้นที่การศึกษา</th>
                <th  rowspan="2">จำนวนบุคลากรในพื้นที่ทั้งหมด</th>
                <th colspan="3">บันทึกข้อมูล</th>
                <th rowspan="2">ค้างบันทึกข้อมูล</th>
            </tr>
            <tr>
            	<th>รวม</th>
                <th>update</th>
                <th>ค้างupdate</th>             
            </tr> 
        </thead>
        <tbody>
        <?php
			$sqlEdu="SELECT eduarea.secid,eduarea.secname_short
FROM ".DB_USERENTRY.".keystaff INNER JOIN eduarea ON ".DB_USERENTRY.".keystaff.site_area = eduarea.secid
GROUP BY eduarea.secid
ORDER BY if(substring(secid,1,1) ='0',cast(secid as SIGNED),0) ASC, secname ASC";

			$resEdu=mysql_db_query($dbnamemaster, $sqlEdu);
			$number =1;
			while($ass=mysql_fetch_assoc($resEdu)){ 
			$sqlEdu2="SELECT COUNT(view_general.CZ_ID) AS sumall,SUM(IF(view_general.user_approve<>'0' ,1 ,0)) AS approve,SUM(IF(view_general.user_approve='0' ,1 ,0)) AS notapprove
FROM view_general WHERE view_general.siteid='$ass[secid]' GROUP BY view_general.siteid";

			$resEdu2=mysql_db_query($dbnamemaster, $sqlEdu2)or die(mysql_error());
			
			$ass2=mysql_fetch_assoc($resEdu2);
			
			$sqlEdu3="SELECT COUNT(view_general.CZ_ID) AS pass 
FROM view_general INNER JOIN ".DB_USERENTRY.".view_kp7approve ON view_general.CZ_ID = ".DB_USERENTRY.".view_kp7approve.idcard AND view_general.siteid = ".DB_USERENTRY.".view_kp7approve.siteid
WHERE view_general.siteid='$ass[secid]' AND ".DB_USERENTRY.".view_kp7approve.profile_id='99' AND view_general.user_approve<>'0' GROUP BY view_general.siteid";

			$resEdu3=mysql_db_query($dbnamemaster, $sqlEdu3)or die(mysql_error());
			
			$ass3=mysql_fetch_assoc($resEdu3);
			?>
				<tr>
                	<td align="center"><?php echo $number?></td>
                    <?php $number++;?>
                    <td align="left"><?php echo $ass[secname_short];?></td>
                    <td align="right"><a href="rpt_keydata_siteex_detail.php?type=all&siteid=<? echo $ass[secid]?>&secname=<? echo $ass[secname_short]?>&title=จำนวนบุคลากรในพื้นที่ทั้งหมด" target="_blank"><?php echo number_format($ass2[sumall]);?></a></td>
                    <td align="right"><a href="rpt_keydata_siteex_detail.php?type=approve&siteid=<? echo $ass[secid]?>&secname=<? echo $ass[secname_short]?>&title=จำนวนที่บันทึกข้อมูลทั้งหมด" target="_blank""><?php echo number_format($ass2[approve]);?></a></td>
                    <td align="right"><a href="rpt_keydata_siteex_detail.php?type=pass&siteid=<? echo $ass[secid]?>&secname=<? echo $ass[secname_short]?>&title=จำนวนที่ UPDATE ข้อมูล" target="_blank""><?php echo number_format($ass3[pass]);?></a></td>
                    <td align="right"><a href="rpt_keydata_siteex_detail.php?type=notpass&siteid=<? echo $ass[secid]?>&secname=<? echo $ass[secname_short]?>&title=จำนวนที่ค้าง UPDATE ข้อมูล" target="_blank""><?php echo number_format(($ass2[approve])-($ass3[pass]));?></a></td>
                    <td align="right"><a href="rpt_keydata_siteex_detail.php?type=notapprove&siteid=<? echo $ass[secid]?>&secname=<? echo $ass[secname_short]?>&title=จำนวนที่ค้างบันทึกข้อมูล" target="_blank""><?php echo number_format($ass2[notapprove]);?></a></td>
                </tr>
               <?php 
			   $sum_sumall+=$ass2[sumall];
			   $sum_approve +=$ass2[approve];
			   $sum_pass+=$ass3[pass];
			   $sum_notpass+=($ass2[approve])-($ass3[pass]);
			   $sum_notapprove+=$ass2[notapprove];
 			}?>	
		</tbody>
        <tfoot>
        <tr>
            	<th colspan="2">รวม</th>
                <th align="right"><? echo number_format($sum_sumall)?></th>
                <th align="right"><? echo number_format($sum_approve)?></th>
                <th align="right"><? echo number_format($sum_pass)?></th>
                <th align="right"><? echo number_format($sum_notpass)?></th>
                <th align="right"><? echo number_format($sum_notapprove)?></th>
            </tr>
            <script>
            	document.getElementById("t1").innerHTML="<? echo number_format($sum_sumall)?>";
				document.getElementById("t2").innerHTML="<? echo number_format($sum_approve)?>";
				document.getElementById("t3").innerHTML="<? echo number_format($sum_pass)?>";
				document.getElementById("t4").innerHTML="<? echo number_format($sum_notpass)?>";
				document.getElementById("t5").innerHTML="<? echo number_format($sum_notapprove)?>";
            </script>
        </tfoot>
        </table>
        </div>
</body>
</html>