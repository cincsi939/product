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
include("../../common/class.getdata_master.php");

$obj = new GetDataMaster();
function GetCountData(){
	global $dbnamemaster;
	$sql = "SELECT siteid,count(idcard) as num1 FROM `view_data_uncomplete` group by siteid ";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	return $arr;
} // end function GetCountData(){

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
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รายงานข้อมูลที่ต้องทำการบันทึกข้อมูลล่าสุดในฟอร์ม excel แยกรายเขต</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="61%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="35%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลที่คีย์ใหม่(คน)</strong></td>
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
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="right"><? if($arrdata[$rs[secid]] > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&mode=1' target=\"_blank\">".number_format($arrdata[$rs[secid]])."</a>";}else{ echo "0";}?></td>
        </tr>
      <?
	  $sum1 += $arrdata[$rs[secid]];
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
            <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        </tr>

    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
	if($action == "view"){	
	$secname_short = $obj->GetAreaName($xsiteid,"secname_short");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="25" bgcolor="#CCCCCC"><strong>รูปแบบฟอร์มบันทึกข้อมูลใน excel เพื่อดึงข้อมูลเข้าระบบ 
          <?=$obj->GetAreaName($xsiteid);?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เลขที่<br>
          คำสั่ง</strong></td>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลงวันที่</strong></td>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>สั่ง ณ วันที่</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน<br>
          (กรณีเป็นคำสั่งโรงเรียน)</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="2%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ชื่อ</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>นามสกุล</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เลขที่บัตรประชาชน</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>วิทยฐานะ</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่งเลขที่</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>อัตราเงินเดือน</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เลื่อนให้<br>
          ได้รับขั้น</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ค่าตอบแทนเงินเดือน</strong></td>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลส่วนเพิ่ม</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>อันดับ</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>ขั้น</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>2%</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>4%</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>6%</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>การศึกษาสูงสุด</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>วุฒิการศึกษา</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>วันเดือนปีเกิด</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>เพศ</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <?
        	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t2.office
FROM
view_data_uncomplete AS t1
Left Join allschool AS t2 ON t1.schoolid = t2.id
WHERE
t1.siteid =  '$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  
		   $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[idcard].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"$filekp7\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";
		}else{
				$link_kp7 = "";
		}
		  
		?>
        
      <tr bgcolor="<?=$bg?>">
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$secname_short?></td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th]?></td>
        <td align="left"><?=$rs[surname_th]?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$rs[office]?></td>
        <td align="left"><?=$rs[birthday]?></td>
        <td align="left"><?=$rs[begindate]?></td>
        <td align="left"><?=$obj->GetSexFormPrename($rs[prename_th]);?></td>
        <td align="center"><?=$link_kp7?></td>
        </tr>
        <?
	}//end 
		?>
    </table></td>
  </tr>
</table>
<?
	}//end 	if($action == "view"){
?>
</BODY>
</HTML>
