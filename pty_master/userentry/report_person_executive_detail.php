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
	## Modified Detail :		รายงานข้อมูลบุคลากรในกลุ่มผู้บริหารและเจ้าหน้าที่ประจำเขต
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
set_time_limit(0);
include "epm.inc.php";
include("../../common/common_competency.inc.php");
$arr_title = array("1A"=>"รายงานข้อมูลผู้อำนวยการสำนักงานเขตพื้นที่การศึกษารวม","1T"=>"รายงานข้อมูลผู้อำนวยการสำนักงานเขตพื้นที่การศึกษาที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","1F"=>"รายงานข้อมูลผู้อำนวยการสำนักงานเขตพื้นที่การศึกษาที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","2A"=>"รายงานข้อมูลรองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษารวม","2T"=>"รายงานข้อมูลรองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา ที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","2F"=>"รายงานข้อมูลรองผู้อำนวยการสำนักงานเขตพื้นที่การศึกษาที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","3A"=>"รายงานข้อมูลศึกษานิเทศก์รวม","3T"=>"รายงานข้อมูลศึกษานิเทศก์ ที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","3F"=>"รายงานข้อมูลศึกษานิเทศก์ ที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","4A"=>"รายงานข้อมูลบุคลากร 38ค(2) รวม","4T"=>"รายงานข้อมูลบุคลากร 38ค(2) ที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","4F"=>"รายงานข้อมูลบุคลากร 38ค(2) ที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","5A"=>"รายงานข้อมูลผู้อำนวยการสถานศึกษารวม","5T"=>"รายงานข้อมูลผู้อำนวยการสถานศึกษา ที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล ","5F"=>"รายงานข้อมูลผู้อำนวยการสถานศึกษา ที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล","6A"=>"รายงานข้อมูลรองผู้อำนวยการสถานศึกษารวม","6T"=>"รายงานข้อมูลรองผู้อำนวยการสถานศึกษา ที่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล ","6F"=>"รายงานข้อมูลรองผู้อำนวยการสถานศึกษา ที่ไม่ผ่านการ QC และยื่นคำร้องขอแก้ไขข้อมูล");

$path_pdf = "../../../edubkk_kp7file/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='16' height='16' border='0'>";	
	


$sql_sec = "SELECT * FROM eduarea WHERE secid='$xsiteid'";
$result_sec= mysql_db_query($dbnamemaster,$sql_sec);
$rssc = mysql_fetch_assoc($result_sec);

$sql_school = "select id,office from allschool where siteid='$xsiteid'";
$result_school = mysql_db_query($dbnamemaster,$sql_school);
while($rsa = mysql_fetch_assoc($result_school)){
	$arr_school[$rsa[id]] = $rsa[office];
}

?>

<html>
<head>
<title>Report Person QC</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>

<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</script>

<style type="text/css">
<!--
.style1 {

	text-decoration: underline;
	
}
-->
</style>
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong><? echo $arr_title[$xmode]." ".$rssc[secname]?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC">ลำดับ</td>
        <td width="17%" align="center" bgcolor="#CCCCCC">เลขบัตรประชาชน</td>
        <td width="27%" align="center" bgcolor="#CCCCCC">ชื่อ นามสกุล</td>
        <td width="21%" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
        <td width="24%" align="center" bgcolor="#CCCCCC">หน่วยงานสังกัด</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <?
	  if($xmode == "1A"){
		$conw = " AND t1.pid='125471008'"; 	 	 
	 }else if($xmode == "1T"){
		$conw = " AND t1.pid='125471008' and (t1.status_data='1' or t1.status_data='1')"; 	 	 	 
	}else if($xmode == "1F"){
			$conw = " AND t1.pid='125471008' and (t1.status_data='0' and t1.status_data='0')"; 	 	 		 
	}else if($xmode == "2A"){
			$conw = " AND t1.pid IN('125471009','125471064','125471065','125471066')  "; 
	}else if($xmode == "2T"){
			$conw = " AND  t1.pid IN('125471009','125471064','125471065','125471066') and (t1.status_data='1' or t1.status_data='1') "; 
	}else if($xmode == "2F"){
			$conw = " AND t1.pid IN('125471009','125471064','125471065','125471066') and (t1.status_data='0' and t1.status_data='0') "; 	 
	}else if($xmode == "3A"){
			$conw = " AND t1.pid='225471000' "; 	 
	}else if($xmode == "3T"){
			$conw = " AND t1.pid='225471000' and (t1.status_data='1' or t1.status_data='1') "; 	 
	}else if($xmode == "3F"){
			$conw = " AND t1.pid='225471000' and (t1.status_data='0' and t1.status_data='0') "; 	 
	}else if($xmode == "4A"){
			$conw = " AND t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000') "; 	 
	}else if($xmode == "4T"){
			$conw = " AND  t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000') and (t1.status_data='1' or t1.status_data='1')"; 	 
	}else if($xmode == "4F"){
			$conw = " AND t1.siteid=t1.schoolid and t1.pid NOT IN('125471009','125471064','125471065','125471066','125471008','225471000') and (t1.status_data='0' and t1.status_data='0') "; 	 
	}else if($xmode == "5A"){
			$conw = " AND t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ')"; 	 
	}else if($xmode == "5T"){
			$conw = " AND t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ') and (t1.status_data='1' or t1.status_data='1') "; 	 
	}else if($xmode == "5F"){
			$conw = " AND t1.position_now IN('ผู้อำนวยการโรงเรียน','ผู้อำนวยการวิทยาลัย','ผู้อำนวยการศูนย์','ผู้อำนวยการสถานศึกษา','ผู้อำนวยการหัวหน้าการประถมศึกษาอำเภอ') and (t1.status_data='0' and t1.status_data='0') "; 	 
	}else if($xmode == "6A"){
			$conw = " AND  t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา')"; 	 
	}else if($xmode == "6T"){
			$conw = " AND t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา') and (t1.status_data='1' or t1.status_data='1')"; 	 
	}else if($xmode == "6F"){
			$conw = " AND t1.position_now IN('ผู้ช่วยผู้อำนวยการโรงเรียน','ผู้ช่วยผู้อำนวยการวิทยาลัย','ผู้ช่วยผู้อำนวยการศูนย์การศึกษาพิเศษ','ผู้ช่วยผู้อำนวยการสถานศึกษา','รองผู้อำนวยการโรงเรียน','รองผู้อำนวยการสถานศึกษาศูนย์การศึกษาพิเศษ','รองผู้อำนวยการสถานศึกษา') and (t1.status_data='0' and t1.status_data='0')"; 	 
	}
	  
	  
	  
      	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid,
t1.status_data,
t1.status_qc,
t1.status_send_req
FROM
view_person_executive AS t1
WHERE t1.siteid='$xsiteid'  $conw";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 if($rs[status_data] == "1"){
		$xpdf	= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\"   alt='ก.พ.7 สร้างโดยระบบ '  ></a>"; 
		}else{
			$xpdf	= ""; 	
		}
		
		
		
	$fname = "../../../edubkk_kp7file/$rs[siteid]/".$rs[idcard].".pdf"  ;
	 if(is_file($fname)){ 
			$pdf_orig = " <a href='$fname' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' title='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'  /></a> " ; 
		}else{
			$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
			$pdf_orig = $arrkp7['linkfile'];
			if($pdf_orig == ""){
				$fname1 = "../../../edubkk_kp7file/0000/".$rs[idcard].".pdf"  ;
				if(is_file($fname1)){
					$pdf_orig = " <a href='$fname1' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' title='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'/></a> " ; 	
				}else{
					$pdf_orig = "";	
				}
			}
		}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center" width="5%"><?=$i?></td>
        <td align="center" width="17%"><?=$rs[idcard]?></td>
        <td align="left" width="27%"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left" width="21%"><? echo "$rs[position_now]";?></td>
        <td align="left" width="24%"><? echo $arr_school[$rs[schoolid]];?></td>
        <td align="center" width="6%"><? echo $pdf_orig."&nbsp;".$xpdf;?></td>
      </tr>
    <?
}// end while(){
	
unset($arr_school);
	?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
