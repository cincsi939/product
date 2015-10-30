<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');

function xshow_area($siteid){
	$sql_area = "SELECT secname FROM eduarea WHERE secid='$siteid'";
	$result_area = mysql_db_query(DB_MASTER,$sql_area);
	$rs_a = mysql_fetch_assoc($result_area);
	$xshow_area = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_a[secname]);
	return $xshow_area;
}


function show_school($schoolid){
		$sql_school = "SELECT office  FROM allschool WHERE id='$schoolid'";
		$result_school = mysql_db_query(DB_MASTER,$sql_school);
		$rs_s = mysql_fetch_assoc($result_school);
		return $rs_s[office];
}

function count_salary($siteid,$idcard){
	$db_site = STR_PREFIX_DB.$siteid;
		$sql_count = "SELECT COUNT(*) AS num FROM salary WHERE id='$idcard'";
		$result_count = mysql_db_query($db_site,$sql_count);
		$rs_c = mysql_fetch_assoc($result_count);
		return $rs_c[num];
}

function last_date_salary($siteid,$idcard){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql_salary = "SELECT * FROM salary WHERE id='$idcard' AND date LIKE '2552-04%' ORDER BY date DESC LIMIT 0,1";
		$result_salary = mysql_db_query($db_site,$sql_salary);
		$rs_salary = mysql_fetch_assoc($result_salary);
		return $rs_salary[date];
}

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#A3B2CC"><strong>รายงานการรับรองข้อมูลของบุคคล 
          <?=$secname?>&nbsp;<?=ShowDateProfile($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="23%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ</strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
        <td width="25%" align="center" bgcolor="#A3B2CC"><strong>สังกัด</strong></td>
        <td width="8%" align="center" bgcolor="#A3B2CC"><strong>ก.พ.7</strong></td>
      </tr>
	  <?
	  $db_site = STR_PREFIX_DB.$xsecid;
	  	$sql = "SELECT  $dbsite.general.idcard,$dbsite.general.prename_th,$dbsite.general.name_th,$dbsite.general.surname_th, $dbsite.general.position_now,$dbsite.general.siteid,$dbsite.general.schoolid FROM  ".DB_CHECKLIST.".tbl_check_data Inner Join $dbsite.general ON  ".DB_CHECKLIST.".tbl_check_data.idcard = $dbsite.general.idcard
WHERE
$dbsite.general.approve_status =  'approve' AND
 ".DB_CHECKLIST.".tbl_check_data.secid =  '$xsecid' GROUP BY  $dbsite.general.idcard";
		$result = mysql_db_query($db_site,$sql);
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
		  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  
		  $urlpath = "../../../edubkk_kp7file/$rs[siteid]/" . $rs[idcard] . ".pdf"  ;
		if ( is_file("$urlpath") ){ 
			$pdf_orig = " <a href='$urlpath' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$pdf_orig = "";
		}
		
		 $xpdf		= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";

		  
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="center"><? echo $rs[position_now];?></td>
        <td align="center"><? echo show_school($rs[schoolid]);?></td>
        <td align="center"><? echo "$pdf_orig  $xpdf"; ?></td>
      </tr>
	  <?
	  	}//end while
	  ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
