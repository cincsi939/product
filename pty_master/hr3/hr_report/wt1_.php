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
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " �.�. " . (date("Y")+543);
$time_start = getmicrotime();

include("../hr_report/timefunc.inc.php");
//include("../hr_report/phpconfig.php");
//include("../hr_report/db.inc.php");
//conn2DB();

$sql = "select *,t2.th_name,t3.ampname from general t1 left join smis_matchschool t2 ON t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t1.id = '$getid';";
$query 	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs	= mysql_fetch_assoc($query);
if($rs[vitaya] == "�ӹҭ���"){
		$vitaya_t = "�ӹҭ��þ����";
}else if($rs[vitaya] == "����Ǫҭ"){
		$vitaya_t = "����Ǫҭ�����";
}else{
		$vitaya_t = "�ӹҭ���";
}

$sql2 = "select * from salary where id = '$getid' order by runno desc limit 1 ;";
$query 	= mysql_query($sql2)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs2	= mysql_fetch_assoc($query);
$date_o = explode("-",$rs2[dateorder]); // �ѹ��� �ѹ ��͹ ��  
if ($rs2[dateorder] != "" && $rs2[dateorder] != "0000-00-00" ) {
	$xdate_o = " ".intval($date_o[2])." ".$monthname[intval($date_o[1])]." �.�.".$date_o[0].'';
}else{
	$xdate_o = "";
}

$sql3 = "select * from salary where id = '$getid' order by runno asc limit 1 ;";
$query 	= mysql_query($sql3)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs3	= mysql_fetch_assoc($query);
$date_x = explode("-",$rs3[date]); // �ѹ��� �ѹ ��͹ ��  
$xdate_x = " ".intval($date_x[2])." ".$monthname[intval($date_x[1])]." �.�.".$date_x[0].'';

$sql4 = "select * from graduate where id = '$getid' order by runno desc limit 1 ;";
$query 	= mysql_query($sql4)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs4	= mysql_fetch_assoc($query);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>��§ҹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ���դس���ѵ�����͹�Է°ҹ�</title>
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
	<td>��§ҹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ���դس���ѵ�����͹�Է°ҹ�<br />
	���˹� <U><?=$rs[position]?></U> �Է°ҹ� <U><?=$vitaya_t?></U><br />
	<hr /></td>
</tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
	<td>
	1. �����ż����Ѻ��û����Թ <br />
	����-ʡ�� <U><?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></U> ���� <? $diff = dateLength($rs[birthday]); ?>
                <U><?=$diff[year] ?></U> �� �����Ҫ��� <? $diff = dateLength($rs[begindate]);?>
                      <U><?=$diff[year]?></U> �� <br /> 
	�س�ز��٧�ش <U><?=$rs[education]?></U> �Ԫ��͡ <U><?=$rs4[grade]?></U> �ҡʶҺѹ����֡�� <U><?=$rs4[place]?></U><br />
	���˹�  <U><?=$rs[position_now]?></U>  ���˹��Ţ��� <U><?=$rs[noposition]?></U><br />
	ʶҹ�֡�� <U><?=$rs[th_name]?></U> �����/ࢵ <U><?=$rs[ampname]?></U><br />
	ࢵ��鹷�����֡�� <U><?=$global_areaname?></U> ࢵ <U><?=$global_areaname_no?></U> ���/��ǹ�Ҫ��� <U><?=$rs[subminis_now]?></U><br />
	�Ѻ�Թ��͹��ѹ�Ѻ <U><?=$rs2[radub]?></U> ���  <U><?=number_format($rs2[salary],0)?></U> �ҷ<br />
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
$pdf		= "<div align=\"center\"><a href=\"wt1_pdf.php?getid=".$getid."\" target=\"_blank\">download �͡���&nbsp;";
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
	2. ����Ѻ�Ҫ��� <br />
			2.1 ������Ѻ�Ҫ���㹵��˹� <U><?=$rs3[position]?></U> ������ѹ��� <U><?=$xdate_x?></U><br /> 
			2.2 �´�ç����/�Է°ҹ� ����Ӥѭ �ѧ���<br />
</td>
</tr>
</table>
<br />
<table width="800" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
<tr align="center" bgcolor="#A5B2CE" style="font-weight:bold;">
	<td rowspan="2" width="132">�ѹ  ��͹  ��</td>
    <td width="386" rowspan="2" bgcolor="#A5B2CE">���˹�/�Է°ҹ�</td>
    <td colspan="2">�Ѻ�Թ��͹</td>
  </tr>

<tr align="center" bgcolor="#A5B2CE" style="font-weight:bold;" valign="middle">
  <td width="152">�дѺ/�ѹ�Ѻ</td>
  <td width="109">���/�ҷ</td>
  </tr>
<?

$subsql = "select radub,date,position,salary from salary where id = '$getid' group by radub order by runno ";
$query 	= mysql_query($subsql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
while($rss	= mysql_fetch_assoc($query)){
$date_s = explode("-",$rss[date]); // �ѹ��� �ѹ ��͹ ��  
$xdate_s = " ".intval($date_s[2])." ".$monthsname[intval($date_s[1])]." �.�. ".$date_s[0].'';
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
			2.3 ���Ѻ�觵������ç���˹觻Ѩ�غѹ ������ѹ��� <U><?=$xdate_o?></U><br /> 
			���Ѻ�觵�����Է°ҹлѨ�غѹ ������ѹ��� <U></U><br />
			2.4 �¢�����������͹���Է°ҹ����ǡѹ��� �����ش���� ������ѹ��� <U></U><br /></td>
</tr>
</table>


	</td>
  </tr>
</table>
<BR><BR><BR>

</body> 
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>