<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetAutoPageBreak('auto',15);

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(10,10);
$pdf->Cell(270,10,'แบบสรุปปริมาณงานของสถานศึกษาประกอบการวางแผนอัตรากำลังครูของสถานศึกษา สังกัดสำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน ปีงบประมาณ ',0,0,'C');
$pdf->SetXY(10,15);
$pdf->Cell(270,15,'สพท. $global_areaname เขต $global_areaname_no ',0,0,'C');
$pdf->SetXY(10,20);
$pdf->Cell(270,20,'ส่งพร้อมหนังสือ สพท.  เขต  ที่ ศธ  ลงวันที่ ',0,0,'C');

$pdf->SetXY(10,35);

			$col_width = array(20,60,6,6,6,6,6,6,6,6,6,6,70,14,14,14,14,14,7,7,7,7,7,7,7,7,7,7,42,21,21,7,7,7,7,7,7,21,7,7,7,10,10,10,34,17,17); // กำหนดความกว้าง column
			$col_height = 20;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ประเภท",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"จำนวนโรงเรียนตามรหัสที่ตั้ง",1,0,'C');
			
			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"๑",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"๒",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"๓",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"๔",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"๕",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height/2),"๖",1,0,'C');

			$x += $col_width[7];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[8],($col_height/2),"๗",1,0,'C');

			$x += $col_width[8];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[9],($col_height/2),"๘",1,0,'C');

			$x += $col_width[9];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[10],($col_height/2),"๙",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[11],($col_height/2),"รวม",1,0,'C');


			$x += $col_width[11];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[12],($col_height/4),"ปริมาณงาน",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[13],($col_height/4),"อนุบาล",1,0,'C');

			$x += $col_width[13];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[14],($col_height/4),"ป.๑-ป.๖",1,0,'C');

			$x += $col_width[14];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[15],($col_height/4),"ม.๑-ม.๓",1,0,'C');

			$x += $col_width[15];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[16],($col_height/4),"ม.๔-ม.๖",1,0,'C');

			$x += $col_width[16];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[17],($col_height/4),"รวม",1,0,'C');

			
			$pdf->SetFont('Angsana New','B',10);
			$x -= ($col_width[13]+$col_width[14]+$col_width[15]+$col_width[16]);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[18],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[18];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[19],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[19];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[20],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[20];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[21],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[21];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[22],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[22];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[23],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[23];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[24],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[24];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[25],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[25];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[26],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[26];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[27],($col_height/2),"ห้อง",1,0,'C');


			$x += $col_width[27];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[28],($col_height/4),"จำนวนครู",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[29],($col_height/4),"ตาม จ.18",1,0,'C');

			$x += $col_width[29];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[30],($col_height/4),"ตามเกณฑ์ ก.ค",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$x -= ($col_width[30]);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[31],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[31];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[32],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[32];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[33],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[33];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[34],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[34];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[35],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[35];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[36],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[36];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[37],($col_height/2),"จำนวนครู-ขาด เกิน",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[38],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[38];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[39],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[39];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[40],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[40];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height/2),"ขาดเกิน",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height/2),"ร้อยละ",0,0,'C');

			$x += $col_width[41];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height/2),"ครูเกษียณ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height/2),"ปี",0,0,'C');

			$x += $col_width[42];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/4),"พนักงาน",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/4),"ราชการ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",0,0,'');

			$y  = $row1_y+($col_height/2.6);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/2.6),"ตำแหน่ง",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/2),"ครูผู้สอน",0,0,'C');

			$x += $col_width[43];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[44],($col_height/2),"ข้อมูลเฉพาะ ร.ร.ที่ขาดครู",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[45],($col_height/2),"จำนวนโรงที่ขาด",1,0,'C');

			$x += $col_width[45];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[46],($col_height/2),"จำนวนครูที่ขาด",1,0,'C');


		$pdf->SetMargins($pdf->save_lMargin,$pdf->save_tMargin);
		$pdf->SetLineWidth(0.1);
		$pdf->Rect($pdf->left,$pdf->top,$pdf->width,$pdf->height);

		$pdf->SetFont('Angsana New','',12);

		$pdf->SetY(-40);
		$pdf->Cell(500,0,"ขอรับรองว่าข้อมูลถูกต้อง",0,0,'C');

		$pdf->SetY(-30);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-25);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-20);
		$pdf->Cell(500,0,"ตำแหน่ง หัวหน้ากลุ่มบริหารงานบุคคล",0,0,'C');

		$pdf->SetY(-15);
		$pdf->Cell(500,0,"สพท._________________เขต______",0,0,'C');

$pdf->Output(spt_pdf.".pdf",'D');
?>