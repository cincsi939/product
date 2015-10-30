<? 
	session_start();
	if ($session_id == "1"){  	
		$url= "annou_index.php"; 
	}else{
		$url= "usr_index.php"; 
	}
?>
<HTML>
<HEAD>
<TITLE>app</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-874">
<link href="../../common/style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<!-- ImageReady Slices (app.psd) -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="16%" align="center"><a href="../admin/<?=$url?>" target="_top"><img src="../../images_sys/Q.gif" width="25" height="25" border="0"></a><br>
      <a href="../admin/<?=$url?>" target="_top">Qpassport</a></td>
    <td width="84%" class="link_back"><a href="../admin/<?=$url?>" target="_top">ระบบบริหารจัดการข้อมูล</a></td>
  </tr>
  <? if($session_id == "1"){ ?>
  <tr>
    <td align="center"><a href="../register/register_report.php" target="_blank"><img src="../../images_sys/emblem-documents.gif" width="25" height="25" border="0"></a><br>
      <a href="../register/register_report.php" target="_blank">Report</a></td>
    <td class="link_back"><a href="../register/register_report.php" target="_blank">รายชื่อผู้ลงทะเบียนรับรหัสผ่าน</a></td>
  </tr>
  <? } ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td class="link_back"><a href="applist.php" target="_self">more...</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right" class="link_back"><a href="http://www.pdc-obec.com" target="_top"><img src="../../images_sys/logout.jpg" alt="ออกจากระบบ" width="75" height="25" border="0" class="fillcolor_topdown"></a></td>
  </tr>
</table>
<!-- End ImageReady Slices -->
</BODY>
</HTML>