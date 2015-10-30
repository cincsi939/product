<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_absent";
$module_code 		= "absent"; 
$process_id			= "absent";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
//include("session.inc.php");
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");

$yy_now = date("Y")+543 ; 
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " พ.ศ. " . (date("Y")+543);
$time_start = getmicrotime();

include("../hr_report/timefunc.inc.php");
//include("../hr_report/phpconfig.php");
//include("../hr_report/db.inc.php");
//conn2DB();

$sql = "select *,t2.th_name,t3.ampname from general t1 left join smis_matchschool t2 ON t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t1.id = '$getid';";
$query 	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs	= mysql_fetch_assoc($query);
if($rs[vitaya] == "ชำนาญการ"){
		$vitaya_t = "ชำนาญการพิเศษ";
}else if($rs[vitaya] == "เชี่ยวชาญ"){
		$vitaya_t = "เชี่ยวชาญพิเศษ";
}else{
		$vitaya_t = "ชำนาญการ";
}

$sql2 = "select * from salary where id = '$getid' order by runno desc limit 1 ;";
$query 	= mysql_query($sql2)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs2	= mysql_fetch_assoc($query);
$date_o = explode("-",$rs2[dateorder]); // วันที่ วัน เดือน ปี  
if ($rs2[dateorder] != "" && $rs2[dateorder] != "0000-00-00" ) {
	$xdate_o = " ".intval($date_o[2])." ".$monthname[intval($date_o[1])]." พ.ศ.".$date_o[0].'';
}else{
	$xdate_o = "";
}

$sql3 = "select * from salary where id = '$getid' order by runno asc limit 1 ;";
$query 	= mysql_query($sql3)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs3	= mysql_fetch_assoc($query);
$date_x = explode("-",$rs3[date]); // วันที่ วัน เดือน ปี  
$xdate_x = " ".intval($date_x[2])." ".$monthname[intval($date_x[1])]." พ.ศ.".$date_x[0].'';

$sql4 = "select * from graduate where id = '$getid' order by runno desc limit 1 ;";
$query 	= mysql_query($sql4)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs4	= mysql_fetch_assoc($query);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานข้าราชการครูและบุคลากรทางการศึกษาที่มีคุณสมบัติเลื่อนวิทยฐานะ</title>
<style type="text/css">
.verticaltext{
writing-mode	: tb-rl;
filter				: flipv fliph;
}
</style>
</head>
<body bgcolor="#A5B2CE">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
  <tr style=" border-bottom:1px solid #FFFFFF" align="right">
    <td height="50" background="../hr_report/images/report_banner_01.gif"><img src="../hr_report/images/report_banner_03.gif" width="365" height="50" /></td>
</table>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="center" style="font-weight:bold;">
	<td>รายงานข้าราชการครูและบุคลากรทางการศึกษาที่มีคุณสมบัติเลื่อนวิทยฐานะ<br />
	ตำแหน่ง <U><?=$rs[position]?></U> วิทยฐานะ <U><?=$vitaya_t?></U><br />
	<hr /></td>
</tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
	<td>
	1. ข้อมูลผู้ขอรับการประเมิน <br />
	ชื่อ-สกุล <U><?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></U> อายุ <? $diff = dateLength($rs[birthday]); ?>
                <U><?=$diff[year] ?></U> ปี อายุราชการ <? $diff = dateLength($rs[begindate]);?>
                      <U><?=$diff[year]?></U> ปี <br /> 
	คุณวุฒิสูงสุด <U><?=$rs[education]?></U> วิชาเอก <U><?=$rs4[grade]?></U> จากสถาบันการศึกษา <U><?=$rs4[place]?></U><br />
	ตำแหน่ง  <U><?=$rs[position_now]?></U>  ตำแหน่งเลขที่ <U><?=$rs[noposition]?></U><br />
	สถานศึกษา <U><?=$rs[th_name]?></U> อำเภอ/เขต <U><?=$rs[ampname]?></U><br />
	เขตพื้นที่การศึกษา <U><?=$global_areaname?></U> เขต <U><?=$global_areaname_no?></U> กรม/ส่วนราชการ <U><?=$rs[subminis_now]?></U><br />
	รับเงินเดือนในอันดับ <U><?=$rs2[radub]?></U> ขั้น  <U><?=number_format($rs2[salary],0)?></U> บาท<br />
</td>
<td rowspan="8" height="125" align="center" valign="middle">
<?			  

//@20/7/2550
function get_picture($getid){
	$imgpath = "images/personal/";
	$ext_array = array("jpg","jpeg","png","gif");
	if ($getid <= "") return "";

	for ($i=0;$i<count($ext_array);$i++){
		$img_file = $imgpath . $getid . "." . $ext_array[$i];
		if (file_exists($img_file)) return $img_file;
	}

	return "";
}


						$img_file = get_picture($getid);
						 If ($img_file == "")
						 {
						 ?>
                                                <img src="bimg/nopicture.gif" border=0 width=150 height=180>
                                                <?
						 }else
						 {
						 ?>
                                                <img src="<?=$img_file?>" border=0 width=150 height=180>
                                                <?
						 }
$pdf		= "<div align=\"center\"><a href=\"wt1_pdf.php?getid=".$getid."\" target=\"_blank\">download เอกสาร&nbsp;";
$pdf		.= "<img src=\"bimg/pdf.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"></a></div>";			  
echo $pdf;						 
						 ?>
						 
			</td>
</tr>

</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
	<td>
	2. การรับราชการ <br />
			2.1 เริ่มรับราชการในตำแหน่ง <U><?=$rs3[position]?></U> เมื่อวันที่ <U><?=$xdate_x?></U><br /> 
			2.2 เคยดำรงตำแน่ง/วิทยฐานะ ที่สำคัญ ดังนี้<br />
</td>
</tr>
</table>
<br />
<table width="800" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
<tr align="center" bgcolor="#A5B2CE" style="font-weight:bold;">
	<td rowspan="2" width="132">วัน  เดือน  ปี</td>
    <td width="386" rowspan="2" bgcolor="#A5B2CE">ตำแหน่ง/วิทยฐานะ</td>
    <td colspan="2">รับเงินเดือน</td>
  </tr>

<tr align="center" bgcolor="#A5B2CE" style="font-weight:bold;" valign="middle">
  <td width="152">ระดับ/อันดับ</td>
  <td width="109">ขั้น/บาท</td>
  </tr>
<?

$subsql = "select radub,date,position,salary from salary where id = '$getid' group by radub order by runno ";
$query 	= mysql_query($subsql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
while($rss	= mysql_fetch_assoc($query)){
$date_s = explode("-",$rss[date]); // วันที่ วัน เดือน ปี  
$xdate_s = " ".intval($date_s[2])." ".$monthsname[intval($date_s[1])]." พ.ศ. ".$date_s[0].'';
if($rss[radub]==""){continue;}
?>
<tr align="center" bgcolor="#ffffff">
  <td height="25"><?=$xdate_s?></td>
  <td align="left"><?=$rss[position]?></td>
  <td><?=$rss[radub]?></td>
  <td><?=number_format($rss[salary],0)?></td>
  </tr>
<?

}

?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
	<td>
<br />
			2.3 ได้รับแต่งตั้งให้ดำรงตำแหน่งปัจจุบัน เมื่อวันที่ <U><?=$xdate_o?></U><br /> 
			ได้รับแต่งตั้งเป็นวิทยฐานะปัจจุบัน เมื่อวันที่ <U></U><br />
			2.4 เคยขอมีหรือเลื่อนเป็นวิทยฐานะเดียวกันนี้ ครั้งสุดท้าย เมื่อวันที่ <U></U><br /></td>
</tr>
</table>


	</td>
  </tr>
</table>
<BR><BR><BR>

</body> 
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>