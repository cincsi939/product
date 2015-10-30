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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
   
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รายงานจำนวนรายการเอกสารที่ค้างดำเนินการบันทึกข้อมูล update ของ 48 เขตนำร่อง</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="62%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="33%" align="center" bgcolor="#CCCCCC"><strong>จำนวนเอกสาร(ชุด)</strong></td>
      </tr>
      <?
	  $arr_data = GetNumDataKeyupdate(); # จำนวนชุดเอกสารที่ค้างบันทึกข้อมูลแยกรายเขต
	  
      	$sql = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
where group_type='edu_pre'
order by secname asc";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$i=0;
		while($rs  =mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$site = $rs[secid]; # รหัสเขต
				$num_update = $arr_data[$site]; ##  จำนวนชุดเอกสาร
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="right">
        <?
        	if($num_update > 0){
					echo "<a href='report_keyupdate_areamain_detail.php?site=$site&secname=$rs[secname]' target='_blank'>".number_format($num_update)."</a>";
			}else{
					echo "0";	
			}
		?>
        
        </td>
      </tr>
        <?
			$sum_data += $num_update;
		}//end 
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_data)?>
        </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>