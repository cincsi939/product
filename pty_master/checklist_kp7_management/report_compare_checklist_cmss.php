<?
set_time_limit(0);

include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");

function GetEduArea($get_secid){
	global $dbnamemaster;
	$sql_eduarea = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
	$result_eduarea = mysql_db_query($dbnamemaster,$sql_eduarea);
	$rs_edu = mysql_fetch_assoc($result_eduarea);
	return $rs_edu[secname];
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		if(count($status_confrim) > 0){
				foreach($status_confrim as $k => $v){
						$sql_update = "UPDATE report_check_idcard_nomath_name SET status_confrim='$v'  WHERE idcard='$k' ";
						mysql_db_query($dbname_temp,$sql_update);
				}
		}//end 	if(count($status_confrim) > 0){
			echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); location.href='?conw=$conw';</script>";	
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){
	
#############  ประมวลรายการตรวจสอบข้อมูล
if($_GET['process'] == 1){
		$sql1 = "SELECT
	edubkk_checklist.tbl_checklist_kp7.siteid,
	edubkk_checklist.tbl_checklist_kp7.idcard,
	edubkk_checklist.tbl_checklist_kp7.prename_th as pname,
	edubkk_checklist.tbl_checklist_kp7.name_th as name,
	edubkk_checklist.tbl_checklist_kp7.surname_th as surname,
	edubkk_master.view_general.prename_th as pname1,
	edubkk_master.view_general.name_th as name1,
	edubkk_master.view_general.surname_th as surname1
	FROM
	edubkk_checklist.tbl_checklist_kp7
	Inner Join edubkk_master.view_general ON edubkk_checklist.tbl_checklist_kp7.idcard = edubkk_master.view_general.CZ_ID";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$name_checklist = trim($rs1[name])."".trim($rs1[surname]);	
		$name_cmss = trim($rs1[name1])."".trim($rs1[surname1]);
		if($name_checklist != $name_cmss){
			$sql_check = "SELECT count(idcard) as num1 FROM  report_check_idcard_nomath_name  WHERE idcard='$rs[idcard]'";
			$result_check = mysql_db_query($dbname_temp,$sql_check);
			$rs_ck  = mysql_fetch_assoc($result_check);
				if($rs_ck[num1] < 1){
						$sql_insert = "INSERT INTO report_check_idcard_nomath_name SET idcard='$rs1[idcard]',prename_th='$rs1[pname]',name_th='$rs1[name]',surname_th='$rs1[surname]',prename_th_cmss='$rs1[pname1]',name_th_cmss='$rs1[name1]',surname_th_cmss='$rs1[surname1]',siteid='$rs1[siteid]' ";
						mysql_db_query($dbname_temp,$sql_insert);
				}
		}
	}// end while($rs1 = mysql_fetch_assoc($result1)){
		
}/// end if($_GET['process'] == 1){

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>หน้ารายงานตรวจสอบเลขบัตรที่ชื่อนามสกุลไม่ตรงกัน</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="7" align="left" bgcolor="#CAD5FF"><strong><a href="?process=1">คลิ๊กเพื่อประมวลผลไฟล์อีกครั้ง</a><br />
  &nbsp;<a href="?conw=1">ข้อมูลที่ยืนยันว่าถูกต้องแล้ว</a>&nbsp;<a href="?conw=2">ยืนยันข้อมูลแล้วไม่ถูกต้อง</a>&nbsp;<a href="?conw=0">รอการตรวจสอบข้อมูล</a>&nbsp;<a href="?conw=all">แสดงข้อมูลทั้งหมด</a></strong></td>
        </tr>
        <tr>
          <td colspan="7" align="center" bgcolor="#CAD5FF"><strong>&nbsp;รายงานเลขบัตรในระบบ checklist ที่่มีชื่อและนามสกุลไม่ตรงกับชื่อและนามสกุลที่อยู่ในข้อมูล Cmss  :::: <? if($conw == "1"){ echo "ข้อมูลที่ยืนยันว่าถูกต้องแล้ว";}else if($conw == "2"){ echo "ยืนยันข้อมูลแล้วไม่ถูกต้อง";}else if($conw == "0"){ echo "รอการตรวจสอบข้อมูล";}else{ echo "แสดงข้อมูลทั้งหมด";}?> </strong></td>
          </tr>
        <tr>
          <td width="4%" align="center" valign="top" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
          <td width="16%" align="center" valign="top" bgcolor="#CAD5FF"><strong>เลขบัตรประชาชน</strong></td>
          <td width="19%" align="center" valign="top" bgcolor="#CAD5FF"><strong>ชื่อ-นามสกุล ใน checklist</strong></td>
          <td width="21%" align="center" valign="top" bgcolor="#CAD5FF"><strong>ชื่อ-นามสกุล ใน cmss</strong></td>
          <td width="21%" align="center" valign="top" bgcolor="#CAD5FF"><strong>เขตพื้นที่การศึกษา</strong></td>
          <td width="8%" align="center" valign="top" bgcolor="#CAD5FF"><strong>ไฟล์ pdf</strong></td>
          <td width="11%" align="center" valign="top" bgcolor="#CAD5FF"><label>
            <input type="submit" name="button" id="button" value="บันทึกรายการ" />
            <input type="hidden" name="conw" value="<?=$conw?>" />
          </label></td>
        </tr>
        <?
		$path_file = "../../../".PATH_KP7_FILE."/";
			if($conw == 0){
					$con_sql = " WHERE status_confrim='0' ";
			}else if($conw == "1"){
					$con_sql = " WHERE status_confrim='1' ";
			}else if($conw == "2"){
					$con_sql = " WHERE status_confrim='2' ";
			}else{
					$con_sql = "";	
			}
        	$sql = "SELECT * FROM report_check_idcard_nomath_name $con_sql ORDER BY siteid ASC";
			$result = mysql_db_query($dbname_temp,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			$i++;
				if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
			$pdf_file = $path_file.$rs[siteid]."/".$rs[idcard].".pdf";
				if(is_file($pdf_file)){
						$show_pdf = "<a href='$pdf_file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf_gray.gif\" width=\"20\" height=\"20\" border=\"0\" title=\"ไฟล์ pdf ต้นฉบับ\"></a>";
				}else{
						$show_pdf = "";	
				}
				
		?>
        <tr bgcolor="#<?=$bgcolor1?>">
          <td align="center"><?=$i?></td>
          <td align="center"><? echo "$rs[idcard]";?></td>
          <td align="center"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="center"><? echo "$rs[prename_th_cmss]$rs[name_th_cmss]  $rs[surname_th_cmss]";?></td>
          <td align="center"><?
		  echo GetEduArea($rs[siteid]);
		  ?></td>
          <td align="center">
          <? echo $show_pdf;?>
          
          </td>
          <td align="center"><label>
            <select name="status_confrim[<?=$rs[idcard]?>]">
            <option value="0" <? if($rs[status_confrim] == "0"){ echo "selected='selected'";}?>>รอการตรวจสอบข้อมูล</option>
            <option value="1" <? if($rs[status_confrim] == "1"){ echo "selected='selected'";}?>>ข้อมูลถูกต้องแล้ว</option>
            <option value="2" <? if($rs[status_confrim] == "2"){ echo "selected='selected'";}?>>ข้อมูลไม่ถูกต้อง</option>
            </select>
          </label></td>
        </tr>
        <?
			}//end while($rs = mysql_fetch_assoc()){
		?>
      </table></td>
    </tr>
  </table>
    </form>
</body>
</html>
