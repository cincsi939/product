<?php
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
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

//include("session.inc.php");
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();


$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " พ.ศ. " . (date("Y")+543);


include("timefunc.inc.php");
//include("phpconfig.php");
//include("db.inc.php");

//conn2DB();


$sql = "select *,t2.th_name,t3.ampname from general t1 left join smis_matchschool t2 ON t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t1.id = '$getid';";
$result = mysql_query($sql);
$rs=mysql_fetch_array($result,MYSQL_ASSOC);
$diff1 = dateLength($rs[birthday]);
$diff2 = dateLength($rs[begindate]);
if($rs[vitaya] == "ชำนาญการ"){
		$vitaya_t = "ชำนาญการพิเศษ";
}else if($rs[vitaya] == "เชี่ยวชาญ"){
		$vitaya_t = "เชี่ยวชาญพิเศษ";
}else{
		$vitaya_t = "ชำนาญการ";
}

$sql2 = "select * from salary where id = '$getid' order by runno desc limit 1 ;";
$result2 = mysql_query($sql2);
$rs2=mysql_fetch_array($result2,MYSQL_ASSOC);
$date_o = explode("-",$rs2[dateorder]); // วันที่ วัน เดือน ปี  
if ($rs2[dateorder] != "" && $rs2[dateorder] != "0000-00-00" ) {
	$xdate_o = " ".intval($date_o[2])." ".$monthname[intval($date_o[1])]." พ.ศ.".$date_o[0].'';
}else{
	$xdate_o = "";
}

$sql3 = "select * from salary where id = '$getid' order by runno asc limit 1 ;";
$result3 = mysql_query($sql3);
$rs3=mysql_fetch_array($result3,MYSQL_ASSOC);
$date_x = explode("-",$rs3[date]); // วันที่ วัน เดือน ปี  
$xdate_x = " ".intval($date_x[2])." ".$monthname[intval($date_x[1])]." พ.ศ.".$date_x[0].'';

$sql4 = "select * from graduate where id = '$getid' order by runno desc limit 1 ;";
$result4 = mysql_query($sql4);
$rs4=mysql_fetch_array($result4,MYSQL_ASSOC);


$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$pdf->SetFont('Angsana New','',20);
$pdf->SetXY(70,10);
$pdf->Cell(70,10,'รายงานข้าราชการครูและบุคลากรทางการศึกษาที่มีคุณสมบัติเลื่อนวิทยฐานะ',0,0,'C');
$pdf->SetXY(70,15);
$pdf->Cell(70,15,"ตำแหน่ง $rs[position_now] วิทยฐานะ $vitaya_t",0,0,'C');
$pdf->SetFont('Angsana New','',18);
$pdf->SetXY(20,25);
$pdf->Cell(20,25,"1. ข้อมูลผู้ขอรับการประเมิน",0,0,'L');
$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(20,30);
$pdf->Cell(20,30,"ชื่อ-สกุล $rs[prename_th] $rs[name_th] $rs[surname_th] อายุ $diff1[year] ปี อายุราชการ $diff2[year] ปี ",0,0,'L');
$pdf->SetXY(20,35);
$pdf->Cell(20,35,"คุณวุฒิสูงสุด $rs[education] วิชาเอก $rs4[grade] จากสถาบันการศึกษา $rs4[place]",0,0,'L');
$pdf->SetXY(20,40);
$pdf->Cell(20,40,"ตำแหน่ง  $rs[position_now]  ตำแหน่งเลขที่ $rs[noposition]",0,0,'L');
$pdf->SetXY(20,45);
$pdf->Cell(20,45,"สถานศึกษา $rs[th_name] อำเภอ/เขต $rs[ampname]",0,0,'L');
$pdf->SetXY(20,50);
$pdf->Cell(20,50,"เขตพื้นที่การศึกษา $global_areaname เขต $global_areaname_no กรม/ส่วนราชการ $rs[subminis_now]",0,0,'L');
$pdf->SetXY(20,55);
$pdf->Cell(20,55,"รับเงินเดือนในอันดับ $rs2[radub] ขั้น ".number_format($rs2[salary])." บาท",0,0,'L');

$pdf->SetFont('Angsana New','',18);
$pdf->SetXY(20,60);
$pdf->Cell(20,60,"2. การรับราชการ",0,0,'L');
$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(20,65);
$pdf->Cell(20,65,"2.1 เริ่มรับราชการในตำแหน่ง $rs3[position] เมื่อวันที่ $xdate_x",0,0,'L');
$pdf->SetXY(20,70);
$pdf->Cell(20,70,"2.2 เคยดำรงตำแน่ง/วิทยฐานะ ที่สำคัญ ดังนี้",0,0,'L');

$pdf->SetXY(20,110);

			$col_width = array(25,90,60,30,30); // กำหนดความกว้าง column
			$col_height = 14;

			$pdf->SetFont('Angsana New','',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"วัน เดือน ปี",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"ตำแหน่ง/วิทยฐานะ",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"รับเงินเดือน",1,0,'C');
			
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"ระดับ/อันดับ",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"ขั้น/บาท",1,0,'C');


$col_width = array(25,90,30,30);
/*
$subsql = "select radub,date,position,salary from salary where id = '$getid' group by radub order by runno ";
$query = mysql_query($subsql);
*/

	$result1= mysql_query("select position as position  from salary where id='$getid'  GROUP BY position order by date asc  ;");
				while ($rs1=mysql_fetch_array($result1,MYSQL_ASSOC)){

					$result2 = mysql_query("select min(date) as mindate, max(date) as maxdate  from salary  where id='$getid' and position = '$rs1[position]' order by maxdate desc ");
					$rs2=mysql_fetch_array($result2,MYSQL_ASSOC);

					$result3 = mysql_query("select  radub,salary  from salary  where id='$getid' and position = '$rs1[position]' and date = '$rs2[maxdate]' ");
					$rs3=mysql_fetch_array($result3,MYSQL_ASSOC);

					If ($rs2[maxdate] == "00000000")
						{
							$xdate_s = " ";
			
						}else{
							$d1=explode("-",$rs2[maxdate]);
							$xdate_s = intval($d1[2]) . " " . $monthsname[intval($d1[1])] . "  " . $d1[0];

						}

		$y =  $pdf->GetY();
			
			$x = 20;
			$col_height = 7;
			$y +=  $col_height;

			$pdf->SetFont('Angsana New','',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,$xdate_s,1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,$rs1[position],1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,$rs3[radub],1,0,'C');

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,number_format($rs3[salary]),1,0,'C');

}

			$row1_y = $pdf->GetY();

			$x = 20;
			$y = $row1_y+$col_height+2;
			$col_height = 8;

$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(10,$col_height,"2.3 ได้รับแต่งตั้งให้ดำรงตำแหน่งปัจจุบัน เมื่อวันที่ $xdate_o",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"ได้รับแต่งตั้งเป็นวิทยฐานะปัจจุบัน เมื่อวันที่ ",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"2.4 เคยขอมีหรือเลื่อนเป็นวิทยฐานะเดียวกันนี้ ครั้งสุดท้าย เมื่อวันที่ ",0,0,'L');
$y +=  $col_height;
$pdf->SetFont('Angsana New','',18);
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"3. รายงานผลงานที่เกิดจากการปฏิบัติหน้าที่",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(10,$col_height,"ได้เสนอรายงานผลงานที่เกิดจากการปฏิบัติหน้าที่ย้อนหลัง 2 ปีติดต่อกัน ตามแบบ วฐ.2 จำนวน 4 ชุด มาพร้อมนี้",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"ขอรับรองว่าข้อมูลทั้งหมดถูกต้อง และเป็นความจริง",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ลงชื่อ)___________________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"$rs[prename_th] $rs[name_th] $rs[surname_th]",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"ตำแหน่ง$rs[position]$rs[vitaya]",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"วันที่  $datenow",0,0,'C');


$pdf->AddPage('P');

$pdf->SetFont('Angsana New','',20);
$pdf->SetXY(70,10);
$pdf->Cell(70,10,'การตรวจสอบและรับรอง',0,0,'C');

			$y = 15;
			$x = $pdf->lMargin;
			$col_height = 10;

$pdf->SetFont('Angsana New','',16);
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"การตรวจสอบและรับรองของผู้บังคับบัญชาชั้นต้น",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(200,$col_height,"               ได้ตรวจสอบแล้วรับรองว่าข้อมูลถูกต้อง และเป็นความจริง",0,0,'L');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ลงชื่อ)_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"         _______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"ตำแหน่ง_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"วันที่________เดือน____________________พ.ศ.___________",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"การตรวจสอบคุณสมบัติของสำนักงานเขตพื้นที่การศึกษา หรือส่วนราชการ",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               ได้ตรวจสอบแล้ว",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               (     )  มีคุณสมบัติตามที่ ก.ค.ศ. กำหนด",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               (     )  ขาดคุณสมบัติ (ระบุ)______________________________________________________________________",0,0,'L');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"                                      (ลงชื่อ)_______________________________________ผู้ตรวจสอบคุณสมบัติ",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"            (_______________________________________)",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"ตำแหน่ง_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"วันที่______เดือน_________________พ.ศ.________",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ลงชื่อ)_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"         _______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"ผู้อำนวยการสำนักงานเขตพื้นที่การศึกษา/หัวหน้าส่วนราชการ",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(หรือผู้ได้รับมอบหมาย)",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"วันที่______เดือน_________________พ.ศ.________",0,0,'C');


$pdf->Output(wt1_pdf.".pdf",'D');
 $time_end = getmicrotime(); writetime2db($time_start,$time_end); 
?>