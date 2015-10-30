<?
	header("Content-Type: text/html; charset=windows-874");  
	session_start();
	include("../../config/conndb_nonsession.inc.php");
	include ("../../common/common_competency.inc.php") ;
	include("function.php");
	$db_master = "edubkk_master";
	$openform="kj";	
	$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

		$xcond = " AND req_problem.siteid='$xsiteid'";

		$sql = "SELECT req_problem_group.problem_name ,A.* FROM req_problem_group LEFT JOIN 

( SELECT
			COUNT(req_problem.req_person_id) AS nnum,
			SUM(IF(req_temp_wrongdata.status_admin_key_approve=1,1,0)) AS success,
			SUM(IF(req_temp_wrongdata.status_admin_key_approve<>1 OR req_temp_wrongdata.status_admin_key_approve IS NULL,1,0)) AS edit,
			req_problem_group.problem_name AS problem_name2,
			req_problem_group.runno
		FROM
			req_problem_group
			LEFT  Join req_problem ON req_problem_group.runno = req_problem.problem_group
			INNER JOIN req_problem_person ON req_problem_person.req_person_id=req_problem.req_person_id
			INNER JOIN req_temp_wrongdata ON req_problem_person.req_person_id = req_temp_wrongdata.req_person_id 
			LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
			INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
			LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid
		WHERE 
			req_problem_person.del=0  
			AND req_temp_wrongdata.problem_type=1 
			$values $xcond 
		GROUP BY 
			req_problem_group.runno
) A	ON A.runno = req_problem_group.runno	
			";
//echo "<pre>";
//echo $sql;
//exit;
$result = mysql_db_query($db_master,$sql);
//$rs = mysql_fetch_assoc($result)

function getDataDate($siteid,$db_master){
	//echo $siteid,$db_master;
	//exit;
	$sql = "SELECT MIN(req_date) AS dt FROM req_problem_person WHERE req_status IN(1,2) AND idcard != '' AND del <> 1 AND site='$siteid'";
	//echo $sql;
	//exit;

	$res = mysql_db_query($db_master,$sql);
	$row = mysql_fetch_assoc($res);
	return $row[dt];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายการยื่นคำร้องขอแก้ไขข้อมูล</title>
</head>

<link href="../../common/style.css" rel="stylesheet" type="text/css" />


<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100" background="../req_approve/images/braner/banner.jpg" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="37%" valign="top">&nbsp;</td>
        <td width="63%" height="100" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td bgcolor="#DFDFDF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="5" align="center" bgcolor="#A3B2CC">
                <table width="100%" border="0">
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center"><span class="report_head"><strong style="font-size:14px;">รายงานสรุปผลการตรวจสอบข้อมูลทะเบียนประวัตอิเล็กทรอนิกส์รายบุคคล</strong></span></td>
                  </tr>
                  <tr>
                    <td align="center"><span class="report_head"><strong style="font-size:14px;">
                      <?php
					$sql="SELECT eduarea.secid, eduarea.secname FROM `eduarea` where  secid='$xsiteid'";
					$result_site = mysql_db_query($db_master,$sql);
					$rs_site = mysql_fetch_array($result_site);
					echo $rs_site [secname];					  
					  ?> 
                    </strong></span></td>
                  </tr>
                  <tr>
                    <td align="center"><span class="report_head"><strong style="font-size:14px;">(เอกสารทะเบียนประวัติข้อมูล ณ วันที่
					<?php

				$txt_date = getDataDate($xsiteid,$db_master);
				$txt_date = shortday(substr($txt_date,0,10));
				//echo $txt_date;			 

					?>
                        <?=$txt_date;?>
                      ) </strong></span></td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>หมวดรายการ</strong></td>
              <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>บันทึกข้อมูลผิดพลาด (รายการ) </strong></td>
              </tr>
            <tr>
              <td width="20%" align="center" bgcolor="#A3B2CC"><strong>ทั้งหมด</strong></td>
              <td width="21%" align="center" bgcolor="#A3B2CC"><strong>แก้ไขเรียบร้อย</strong></td>
              <td width="23%" align="center" bgcolor="#A3B2CC"><strong>อยู่ระหว่างแก้ไข</strong></td>
              </tr>
            
            <?
			//$arr_req = get_num($xsiteid2);
			
			

			$i=0;
			$tot_all = 0;
			$tot_success = 0;
			$tot_edit = 0;
		while($rs = mysql_fetch_assoc($result)){				
		if ($i % 2) {$bg = "#FFFFFF";}else{$bg = "#F0F0F0";}$i++;
			//$arr_sch=Countschool("$rs[siteid]");
				$tot_all += $rs[nnum];
				$tot_success += $rs[success];
				$tot_edit += $rs[edit];			
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><?=($rs[nnum]>0)?"<a href=\"req_wrong_detail.php?xsiteid=$xsiteid&problem_group=".$rs[runno]."\">$rs[problem_name]</a>":$rs[problem_name]?></td>
              <td align="center"><?=number_format($rs[nnum])?></td>
              <td align="center"><?=number_format($rs[success])?></td>
              <td align="center"><?=number_format($rs[edit])?></td>
              </tr>
            <?
			
				}//end 	while($rs = mysql_fetch_assoc($result)){
//			$arr_all=get_numall($xsiteid2);
//			$sum1=$arr_all['total'];
//			$sum2=$arr_all['list_total'];
//			$sum3=$arr_all['total_1'];
//			$sum4=$arr_all['list_total_1'];
//			$sum5=$arr_all['total_2'];
//			$sum6=$arr_all['list_total_2'];
//			$sum7=$arr_all['total_2edit'];
//			$sum8=$arr_all['list_total_2edit'];
			?>
               <tr bgcolor="<?=$bg?>">
              <td colspan="2" align="center">&nbsp;</td>
              <td align="center"><strong><?=number_format($tot_all)?></strong></td>
              <td align="center"><strong><?=number_format($tot_success)?></strong></td>
              <td align="center"><strong><?=number_format($tot_edit)?></strong></td>
              </tr>

          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td width="68%" align="left" style="font-size:12px">&nbsp;</td>
      <td width="32%" align="right" style="font-size:12px">&nbsp;</td>
    </tr>
  </table>
</body>
</html>
