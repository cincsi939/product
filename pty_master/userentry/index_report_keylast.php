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

/*if($_SESSION['session_staffid'] == ""){
echo "<script type=\"text/javascript\">
window.location=\"login.php\";
</script>";
}
*/



function GetCountData(){
	global $dbnamemaster;
	$sql = "SELECT
t1.siteid,
sum(if(t1.flag_assign='0' and t1.user_approve='0' and t1.flag_kp7='1',1,0)) as num1,
sum(if(t1.flag_assign='1' and t1.user_approve= '0' and t1.flag_kp7='1',1,0)) as num2
FROM
view_general AS t1
Left Join view_general_report_lastdata AS t2 ON t1.CZ_ID = t2.CZ_ID
where  t2.CZ_ID IS NULL OR t2.status_key='0'
group by t1.siteid";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]]['num1'] = $rs[num1];
			$arr[$rs[siteid]]['num2'] = $rs[num2];
	}
	return $arr;
}

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>รายงานข้อมูลที่ต้องทำการบันทึกข้อมูลล่าสุดแยกรายสำนักงานเขตพื้นที่การศึกษา</strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="41%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="27%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลที่คีย์ใหม่(คน)</strong></td>
        <td width="26%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลยังคีย์ไม่สร็จ(คน)</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.secid,
t1.secname,
t1.secname_short
FROM
 ".DB_MASTER.".eduarea AS t1
where t1.status='1' AND t1.secid NOT LIKE '99%'
group by t1.secid";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$j=0;
		$arrdata = GetCountData();
		while($rs = mysql_fetch_assoc($result)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  $data1 = $arrdata[$rs[secid]]['num1'];
				  $data2 = $arrdata[$rs[secid]]['num2'];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="right"><? if($data1 > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&mode=1'>".number_format($data1)."</a>";}else{ echo "0";}?></td>
        <td align="right"><? if($data2 > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&mode=2'>".number_format($data2)."</a>";}else{ echo "0";}?></td>
      </tr>
      <?
	  $sum1 += $data1;
	  $sum2 += $data2;
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
            <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum2)?></strong></td>
      </tr>

    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
	if($action == "view"){
		
		if($mode == "1"){
			$con1 = " AND t1.flag_assign='0' and t1.user_approve='0' and t1.flag_kp7='1' ";
			$xtitle = " (ข้อมูลที่คีย์ใหม่)";
		}else if($mode == "2"){
			$con1 = " AND t1.flag_assign='1' and t1.user_approve='0' and t1.flag_kp7='1' ";
			$xtitle = " (ข้อมูลยังคีย์ไม่สร็จ)";
		}

	
		
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#CCCCCC"><strong><a href="?action=">กลับหน้าหลัก</a> || รายงานข้อมูล<? echo $xtitle;?>&nbsp;<?=ShowSecnameArea($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>สังกัดโรงเรียน</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>บันทึกข้อมูล</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.CZ_ID as idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolname
FROM
view_general AS t1
Left Join view_general_report_lastdata AS t2 ON t1.CZ_ID = t2.CZ_ID
WHERE
(t2.CZ_ID IS NULL OR t2.status_key='0')  AND
t1.siteid =  '$xsiteid'  $con1
order by t1.schoolname ASC,t1.name_th,
t1.surname_th ASC";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  	
		  $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[idcard].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"$filekp7\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";
		}else{
				$link_kp7 = "";	
		}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo $rs[schoolname];?></td>
        <td align="center"><?=$link_kp7?> &nbsp;<a href="../hr3/hr_report/formkeyindata/formkeydata.php?idcard=<?=$rs[idcard]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../../images_sys/disk.gif" width="18" height="15" border="0" title="คลิ๊กเพื่อบันทึกข้อมูลล่าสุด"></a></td>
      </tr>
      <?
	}//end 	while($rs = mysql_fetch_assoc($result)){
	  
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end 	if($action == "view"){
?>
</BODY>
</HTML>
