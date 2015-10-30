<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "report_keyupdate"; 
$process_id			= "userentry";
$VERSION 				= "1.0";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20121114.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2012-11-14 11:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20121114.00
	## Modified Detail :		รายงานสำหรับบันทึกข้อมูล update ต่อเนื่อง
	## Modified Date :		2011-11-14 11:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

include("../../config/conndb_nonsession.inc.php");
include("function_keyupdate.php");
include("../../common/common_competency.inc.php");
include("../../common/class.downloadkp7.php");


if($_SESSION[session_staffid] == ""){
	echo "<script>alert('หมดเวลาการเชื่อมต่อ กรุณา login อีกครั้ง'); location.href='login.php';</script>";
	exit;	
}

$time_start = getmicrotime();

$obj = new downloadkp7();
$pathfile = "../../../kp7file";

if($action == "login"){
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $idcard ;
				$_SESSION[name] = $name_th ;
				$_SESSION[surname] = $surname_th ;
				$_SESSION[session_username] = $idcard;
				$_SESSION[idoffice] = $idcard ;
				$_SESSION[secid] = $xsiteid ;
				$_SESSION[temp_dbsite] = STR_PREFIX_DB.$xsiteid;
	
				CreateTicket($_SESSION[session_staffid],$idcard,$xsiteid,"$name_th $surname_th",100);
				
				
				#echo " url : ".APPURL.APPNAME."application/hr3/hr_frame/frame.php";die();
	
				echo "<script>top.location.href='".APPURL.APPNAME."application/hr3/hr_frame/frame.php';</script>";
				exit();
}//end if($action == "login")

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#CCCCCC"><strong>รายการข้อมูลที่ค้างบันทึกข้อมูลให้เป็นปัจจุบัน 
          <?=$secname?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>เลขประจำตัวประชาชน</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ระดับ</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>ทะเบียนประวัติ</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>เครื่องมือ</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.CZ_ID,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.radub,
t1.schoolname
FROM
view_general AS t1
left Join hr_addposition_now AS t2 ON t1.position_now = t2.`position`
where t1.siteid='$site' and (t1.user_approve <> '1' or t1.flag_kp7 <> '1')
order by if(t1.schoolid=t1.siteid,0,1) asc, t1.schoolname asc,t2.orderby asc,t1.level_id desc";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$rs[CZ_ID]";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="center"><?=$rs[radub]?></td>
        <td align="left"><?=$rs[schoolname]?></td>
        <td align="center"><? echo $obj->get_pdforg($pathfile,$site,$rs[CZ_ID])." ".$obj->get_elecimg($site,$rs[CZ_ID]);?></td>
        <td align="center"><a href="?action=login&idcard=<?=$rs[CZ_ID]?>&name_th=<?=$rs[name_th]?>&surname_th=<?=$rs[surname_th]?>&xsiteid=<?=$rs[siteid]?>">Login</a></td>
      </tr>
      <?
		}//end while
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>