<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include ("../../../../common/Script_CheckIdCard.php")  ;
include('function_check_data.inc.php') ;
$db_call= "edubkk_userentry";
$db_temp = "edubkk_checklist";
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	#####  แสดงชื่อเขตพืีนที่การศึกษา
function ShowArea1($get_siteid){
	global $dbnamemaster;
	$xsql1 = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
	$xresult1 = mysql_db_query($dbnamemaster,$xsql1);
	$xrs1 = mysql_fetch_assoc($xresult1);
	return $xrs1[secname];
}

if($_GET['action'] == "process"){
	$sql = "SELECT * FROM tbl_check_data_excutive";
	$result = mysql_db_query($db_temp,$sql);
	$sql_del = mysql_db_query($db_temp,"DELETE FROM tbl_check_data_excutive_detail");// ลบก่อนทำการตรวจสอบ
	$arrcheck = array();
	while($rs = mysql_fetch_assoc($result)){
		$arrcheck = CheckPersonData($rs[siteid],$rs[idcard]);
		if(count($arrcheck) > 0){
			$flag_check = 0;
			
			foreach($arrcheck as $k => $v){
					foreach($v  as $k1 => $v1){
						$sqlsave = "INSERT INTO tbl_check_data_excutive_detail SET idcard='$rs[idcard]' , code_error='$v1'";
						mysql_db_query($db_temp,$sqlsave);
					}
			}
				
		}else{
			$flag_check = 1;
		}
		
		$sql_up = "UPDATE tbl_check_data_excutive SET flag_check='$flag_check'  WHERE idcard='$rs[idcard]'";
		mysql_db_query($db_temp,$sql_up);
		unset($arrcheck);
	}
	/*echo "<script>location.href='?action=&show=view';</script>";*/
}//end if($_GET['action'] == "process"){


if($show == ""){ $show = "view";}
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
<?
	if($show == "view"){
?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="left" bgcolor="#D4D4D4"><strong><a href="?action=process">ประมวลผลรายการ</a> || รายงานการตรวจสอบข้อมูลของผู้บริหารและหัวหน้าฝ่ายสำนักงานเขตพื้นที่การศึกษา</strong></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="15%" align="center" bgcolor="#D4D4D4"><strong>รหัสบัตร</strong></td>
              <td width="22%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="28%" align="center" bgcolor="#D4D4D4"><strong>ตำแหน่ง</strong></td>
              <td width="19%" align="center" bgcolor="#D4D4D4"><strong>สังกัด</strong></td>
              <td width="12%" align="center" bgcolor="#D4D4D4"><strong>จำนวนรายการ<br />
                ที่ผิดพลาด</strong></td>
            </tr>
            <?
            	$sql = "SELECT * FROM tbl_check_data_excutive WHERE flag_check='0' ORDER BY siteid ASC";
				$result = mysql_db_query($db_temp,$sql);
				$i=0;

				while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#F0F0F0";}
					$fullname = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
					$xsqlnum = "SELECT COUNT(idcard) AS xnum1 FROM tbl_check_data_excutive_detail WHERE idcard='$rs[idcard]' GROUP BY idcard";					
					$xresultnum = mysql_db_query($db_temp,$xsqlnum);
					$xrsn = mysql_fetch_assoc($xresultnum);
					$xnumerror1 = $xrsn[xnum1];
					//echo $xnumerror1 ."<br>";
					
					
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
              <td align="left"><? echo "$rs[position_now]";?></td>
              <td align="left"><? echo ShowArea1($rs[siteid]);?></td>
              <td align="center"><? //echo "$rs[idcard] :: <br>";
			  
			  if($xnumerror1 > 0){ echo "<a href='?show=detail&xidcard=$rs[idcard]&fullname=$fullname&xsiteid=$rs[siteid]&xname_th=$rs[name_th]&xsurname_th=$rs[surname_th]'>พบข้อผิดพลาด</a>";}else{ echo "0";}?></td>
            </tr>
            <?
				}//end while($rs = mysql_fetch_assoc($result)){
			?>
          </table></td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
  <?
	}//end if($show == "view"){
					
else if($show == "detail"){
	$pathfile = "../../../../../edubkk_kp7file/$xsiteid/$xidcard".".pdf";
  ?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="3" align="left" bgcolor="#D4D4D4"><strong><a href="?show=view">กลับหน้าหลัก</a> || รายงานการตรวจสอบข้อมูลของ <?=$fullname?> เลขบัตร <?=$xidcard?> <?=ShowArea1($xsiteid)?>
                &nbsp;&nbsp;<? if(is_file($pathfile)){?><a href="<?=$pathfile?>" target="_blank"><img src="../../../../images_sys/gnome-mime-application-pdf.png" width="20" height="21" alt="ตรวจสอบไฟล์ pdf ต้นฉบับ" border="0"></a><? } ?>&nbsp;&nbsp;<? echo "<a href='login_data.php?xname_th=$xname_th&xsurname_th=$xsurname_th&xidcard=$xidcard&action=login&xsiteid=$xsiteid' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" title="คลิ๊กเพื่อ login เข้าสู่ระบบ" border="0"><? echo "</a>";?></strong></td>
              </tr>
            <tr>
              <td width="6%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="33%" align="center" bgcolor="#D4D4D4"><strong>รหัสรายการที่ผิด</strong></td>
              <td width="61%" align="center" bgcolor="#D4D4D4"><strong>รายละเอียดที่ผิด</strong></td>
              </tr>
            <?
            	$sql = "SELECT
tbl_check_data_excutive_detail.code_error,
diag_error.error_name
FROM
tbl_check_data_excutive_detail
Left Join diag_error ON tbl_check_data_excutive_detail.code_error = diag_error.error_code
WHERE
tbl_check_data_excutive_detail.idcard =  '$xidcard'";
				$result = mysql_db_query($db_temp,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#F0F0F0";}
					$xpos = strpos($rs[code_error],"A0");
					$xpos1 = strpos($rs[code_error],"B0");
					$xpos2 = strpos($rs[code_error],"C0");
					if((!($xpos === false)) or (!($xpos1 === false)) or (!($xpos2 === false))){
						$xcode = "$rs[code_error]";
						$xshow = "$rs[error_name]";
					
					}else{
						$xcode = "S001";
						$xshow = 	"$rs[code_error]";
					
					}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="center"><?=$xcode;?></td>
              <td align="left"><? echo "$xshow";?></td>
              </tr>
            <?
				}//end while($rs = mysql_fetch_assoc($result)){
			?>
          </table></td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>

  <?
}//end if($show == "detail"){
  ?>
</body>
</html>
