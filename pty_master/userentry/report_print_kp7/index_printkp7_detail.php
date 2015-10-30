<?
require_once("../../../config/conndb_nonsession.inc.php");
require_once("function_print_kp7.php");
require_once("../function_face2cmss.php");


$arrsite = GetSiteKeyData();

ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$arrstaff1 = GetStaff($staffid);
$site_name = GetSiteKey($arrstaff1['pin']);
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$curent_yy = date("Y")+543;

//echo "<font color='red'><center>ขออภัยกำลังปรับปรุงโปรแกรม ประมาณ  30 นาที </center></font>";die;

$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#A3B2CC"><strong>รายงานการปริ้นเอกสาร ของ <?=$arrstaff1['fullname']?>&nbsp;<?=$arrstaff1['groupname']?>&nbsp;<?=$site_name?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="40%" align="center" bgcolor="#A3B2CC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>วันที่บันทึกข้อมูล</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
      </tr>
      <?
	  if($xtype == "Y"){
		 	 $conv = " AND t1.status_print='1'";
	}else if($xtype == "N"){
			 $conv = " AND t1.status_print='0'";
	}else{
			$conv = "";	
	}
	  
      $sql = "SELECT
t1.idcard,
t1.staffid,
t1.datekqc,
t1.flag_qc,
t1.status_print,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.schoolname,
t3.secname,
t4.timeupdate,
t2.schoolid
FROM ".DB_USERENTRY.".tbl_person_print_kp7 AS t1
Inner Join  ".DB_MASTER.".view_general AS t2 ON t1.idcard = t2.CZ_ID
Inner Join  ".DB_MASTER.".eduarea AS t3 ON t2.siteid = t3.secid
left Join ".DB_USERENTRY.".monitor_keyin as t4  ON t1.staffid = t4.staffid AND t1.idcard = t4.idcard
where t1.staffid='$staffid' and t1.datekqc LIKE '$yymm%' $conv";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$areaname = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพม.",$rs[secname]);
				//echo $rs[siteid]." :: ".$rs[schoolid]."<br>";
				if($rs[siteid] == $rs[schoolid]){
						$orgname = $areaname." / ".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพม.",$rs[schoolname]);
				}else{
						$orgname = $areaname." / โรงเรียน".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพม.",$rs[schoolname]);
				}
				
				
		$pathfile = "../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
		if(is_file($pathfile)){
			$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../images_sys/gnome-mime-application-pdf.png\" width=\"16\" height=\"16\" alt=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
		}else{
			$pdf_file = "";	
		}//end if(is_file($pathfile)){
			
		if($rs[status_print] == "1"){
			$img_print = "<img src=\"../../validate_management/images/accept.png\" width=\"16\" height=\"16\" title=\"ปริ้นเอกสาร ก.พ. 7 เรียบร้อยแล้ว\">";
		}else{
			$img_print = "<a href=\"../../hr3/hr_report/report_check/report_check_data_print.php?idcard=$rs[idcard]&siteid=$rs[siteid]&staffid=$rs[staffid]&flag_qc=$rs[flag_qc]&datekqc=$rs[datekqc]&xtype=validate&groupid=$groupid\" target=\"_blank\"><img src=\"../../validate_management/images/zoom.png\" width=\"16\" height=\"16\" border=\"0\" title=\"คลิ๊กเพื่อปริ้นเอกสาร\"></a>";	
		}
	  ?>
      
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$rs[idcard]";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo $orgname;?></td>
        <td align="center"><? echo GetThaiDateTime($rs[timeupdate]);?></td>
        <td align="center"><? echo $pdf_file;?>&nbsp;<?=$img_print?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
