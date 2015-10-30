<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc_v1.php') ;
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$year1 = (date("Y")+543)."09-30";

if($xsiteid == ""){
	$xsiteid = "7002";
}else{
	$xsiteid = $xsiteid;	
}

function CountNumSalary($xsiteid,$idcard,$get_age){
	$db_site = STR_PREFIX_DB.$xsiteid;
	$sql = "SELECT COUNT(id) AS numsalary FROM salary WHERE id='$idcard'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	$xage = $get_age*2;
	if($rs[numsalary] < $xage){
		return 0;
	}else{
		return 1;	
	}

}//end function CountNumSalary($xsiteid,$idcard,$get_age){


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
</style>
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>สคริปตรวจสอบการบันทึกข้อมูลของราชบุรีเขต 2</strong></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="5" bgcolor="#CCCCCC">&nbsp;</td>
              </tr>
            <tr>
              <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
              <td width="18%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
              <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="28%" align="center" bgcolor="#CCCCCC"><strong>สังกัด</strong></td>
              <td width="26%" align="center" bgcolor="#CCCCCC"><strong>สถานะการคีย์ข้อมูล</strong></td>
            </tr>
            <?
			$db_site = STR_PREFIX_DB.$xsiteid;
            	$sql = "SELECT
CAST( ".DB_MASTER.".allschool.id as SIGNED) as xschool,
FLOOR((TIMESTAMPDIFF(MONTH,begindate,'$year1')/12)) as age_gov,
$db_site.general.idcard,
$db_site.general.siteid,
$db_site.general.schoolid,
$db_site.general.prename_th,
$db_site.general.name_th,
$db_site.general.surname_th,
 ".DB_MASTER.".allschool.office
FROM
$db_site.general
Inner Join  ".DB_MASTER.".allschool ON $db_site.general.schoolid =  ".DB_MASTER.".allschool.id
ORDER BY xschool ASC";
$result = mysql_db_query($db_site,$sql);
	$j++;
	$n=0;
while($rs = mysql_fetch_assoc($result)){
	 if($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 if(CountNumSalary($rs[siteid],$rs[idcard],$rs[age_gov]) == 0){
		$bg = "#FF3300";	 
		$err = "บันทึกเงินเดือนไม่ครบ";
		$n++;
	}else{
		$bg = $bg;	
		$err = "";
	}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$j?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="center"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
              <td align="center"><? echo "$rs[office]";?></td>
              <td align="center"><? echo "$err"; ?></td>
            </tr>
            <?
}//end while($rs = mysql_fetch_assoc($result)){
			?>
               <tr bgcolor="">
              <td colspan="4" align="right" bgcolor="#CCCCCC"><strong>รวมคีย์ข้อมูลที่ไม่สมบูรณ</strong>์</td>
              <td align="center" bgcolor="#CCCCCC"><strong><?=$n?></strong></td>
            </tr>

          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
