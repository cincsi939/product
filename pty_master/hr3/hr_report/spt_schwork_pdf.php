<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');
include("../../../config/config_hr.inc.php");

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
//$datenow = date("d/m/") . (date("Y")+543);
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " พ.ศ. " . (date("Y")+543);
$timenow = date("H:i:s");
$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetAutoPageBreak('auto',15);

$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(10,10);
$pdf->Cell(270,10,"แบบรายงานปริมาณงานของสถานศึกษา",0,0,'C');
$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(10,15);
$pdf->Cell(10,15,'1. โรงเรียน___________________',0,0,'L');
$pdf->SetXY(10,20);
$pdf->Cell(10,20,"    อำเภอ___________________ สำนักงานเขตพื้นที่การศึกษา $global_areaname เขต $global_areaname_no",0,0,'L');
$pdf->SetXY(10,25);
$pdf->Cell(10,25,'2. การจัดการศึกษาดำเนินการ ดังนี้',0,0,'L');
$pdf->SetXY(10,30);
$pdf->Cell(10,30,'	     ( ) 2.1 ก่อนประถมศึกษา   ( ) เด็กเล็ก   ( ) อนุบาล 3 ขวบ   ( ) อนุบาล 1-2',0,0,'L');
$pdf->SetXY(10,35);
$pdf->Cell(10,35,'     ( ) 2.2 ประถมศึกษา           ( ) ป.1-4     ( ) ป.1-6   ( ) เกณฑ์เด็กปีเว้นปี',0,0,'L');
$pdf->SetXY(10,40);
$pdf->Cell(10,40,'     ( ) 2.3 มัธยมศึกษา             ( ) ม.1-3     ( ) ม.1-6',0,0,'L');
$pdf->SetXY(10,45);
$pdf->Cell(10,45,'3. รายละเอียดเกี่ยวกับห้องเรียนและนักเรียน',0,0,'L');

$pdf->SetXY(10,70);

			$col_width = array(35,20,20,15); // กำหนดความกว้าง column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ชั้นเรียน",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"จำนวนห้องเรียน",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"จำนวนนักเรียน",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"หมายเหตุ",1,0,'C');

$pdf->SetXY(105,70);

			$col_width = array(35,20,20,15); // กำหนดความกว้าง column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ชั้นเรียน",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"จำนวนห้องเรียน",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"จำนวนนักเรียน",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"หมายเหตุ",1,0,'C');

			$pdf->SetFont('Angsana New','',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x-($col_width[0]+$col_width[1]+$col_width[2]+$col_width[3]);
			$y = $row1_y+$col_height;

			$pdf->SetXY($x ,$y);
			$pdf->Cell(40,10,'4. อัตรากำลังครูและลูกจ้าง',0,0,'L');

$pdf->SetFont('Angsana New','',10);
$row1_x = $pdf->GetX();
$row1_y = $pdf->GetY();
$x = $row1_x-40;
$y = $row1_y+$col_height;
$pdf->SetXY($x ,$y);

			$col_width = array(30,10,10,10,30,10,10,10,15,20,10,10,12,12); // กำหนดความกว้าง column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"ครูตามเกณฑ์",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"บ.",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"ป.",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"ครูตาม จ.18",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"บ.",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"ป.",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[7];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[8],$col_height,"ขาด/เกิน",1,0,'C');

			$x += $col_width[8];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[9],($col_height/2),"ครูช่วยราชการ",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[10],($col_height/2),"เข้า",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[11],($col_height/2),"ออก",1,0,'C');

			$x += $col_width[11];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[12],$col_height,"ครูมีจริง",1,0,'C');

			$x += $col_width[12];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[13],$col_height,"ขาด/เกิน",1,0,'C');

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(195,40);
$pdf->Cell(195,40,'5. จำนวนครูรายหมวดวิชาของข้าราชการครูที่ขอย้าย',0,0,'L');


		$pdf->SetMargins($pdf->save_lMargin,$pdf->save_tMargin);
		$pdf->SetLineWidth(0.1);
		$pdf->Rect($pdf->left,$pdf->top,$pdf->width,$pdf->height);

		$pdf->SetFont('Angsana New','',12);

		$pdf->SetY(-90);
		$pdf->Cell(500,0,"ขอรับรองว่าข้อมูลถูกต้อง",0,0,'C');

		$pdf->SetY(-80);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-75);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-70);
		$pdf->Cell(500,0,"ผู้บริหารสถานศึกษา",0,0,'C');

		$pdf->SetY(-65);
		$pdf->Cell(500,0,"สพท._________________เขต______",0,0,'C');

		$pdf->SetY(-60);
		$pdf->Cell(500,0,"วันที่ $datenow",0,0,'C');

		$pdf->SetY(-45);
		$pdf->Cell(500,0,"ขอรับรองว่าข้อมูลถูกต้อง",0,0,'C');

		$pdf->SetY(-35);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-30);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-25);
		$pdf->Cell(500,0,"หัวหน้ากลุ่มบริหารงานบุคคล",0,0,'C');

		$pdf->SetY(-20);
		$pdf->Cell(500,0,"สพท._________________เขต______",0,0,'C');

		$pdf->SetY(-15);
		$pdf->Cell(500,0,"วันที่ $datenow",0,0,'C');
			

$pdf->Output(spt_schwork_pdf.".pdf",'D');
?>